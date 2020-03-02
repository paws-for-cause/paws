<?php

   require_once dirname(__DIR__, 3) . "/vendor/autoload.php";
   require_once dirname(__DIR__, 3) . "/Classes/autoload.php";
   require_once dirname(__DIR__, 3) . "/lib/xsrf.php";
   require_once dirname(__DIR__, 3) . "/lib/jwt.php";
   require_once dirname(__DIR__, 3) . "/lib/uuid.php";
   require_once("/etc/apache2/capstone-mysql/Secrets.php");

   use UssHopper\DataDesign\{Shelter, Animal};


   /**
    * api for the Animal class
    *
    * @author Matthew Urrea <matt.urrea.code@gmail.com>
    **/

//verify the session, start if not active
   if(session_status() !== PHP_SESSION_ACTIVE) {
      session_start();
   }

//prepare an empty reply
   $reply = new stdClass();
   $reply->status = 200;
   $reply->data = null;
   try {

      $secrets = new \Secrets("/etc/apache2/capstone-mysql/paws.ini");
      $pdo = $secrets->getPdoObject();



      //determine which HTTP method was used
      $method = $_SERVER["HTTP_X_HTTP_METHOD"] ?? $_SERVER["REQUEST_METHOD"];

      //sanitize input

      $id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_STRING,FILTER_FLAG_NO_ENCODE_QUOTES);
      $animalShelterId = filter_input(INPUT_GET, "animalShelterId", FILTER_SANITIZE_STRING,FILTER_FLAG_NO_ENCODE_QUOTES);
      $animalAdoptionStatus = filter_input(INPUT_GET, "animalAdoptionStatus", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
      $animalBreed = filter_input(INPUT_GET, "animalBreed", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
      $animalGender = filter_input(INPUT_GET, "animalGender", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
      $animalName = filter_input(INPUT_GET, "animalName", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
      $animalPhotoUrl = filter_input(INPUT_GET, "animalPhotoUrl", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
      $animalSpecies = filter_input(INPUT_GET, "animalSpecies", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

      //make sure the id is valid for methods that require it
      if(($method === "DELETE" || $method === "PUT") && (empty($id) === true )) {
         throw(new InvalidArgumentException("id cannot be empty or negative", 402));
      }


      // handle GET request - if id is present, that tweet is returned, otherwise all tweets are returned
      if($method === "GET") {
         //set XSRF cookie
         setXsrfCookie();

         //get a specific animal or all animals and update reply
         if(empty($id) === false) {
            $reply->data = Animal::getAnimalByAnimalId($pdo, $id);
         } else if(empty($animalShelterId) === false) {
            // if the user is logged in grab all the animals by that user based  on animals liked
            $reply->data = Animal::getAnimalByAnimalShelterId($pdo, $animalShelterId)->toArray();

         } else if(empty($tweetContent) === false) {
            $reply->data = Animal::getAnimalByLikeUserId($pdo, $likeUserId)->toArray();

         } else {
            $animals = Animal::getAllAnimals($pdo)->toArray();
            $animals = [];
            foreach($animals as $animal){
               $user = 	User::getUserByUserId($pdo, $animal->getAnimalByLikeUserId());
               $animals[] = (object)[
                  "animalId"=>$animal->getAnimalId(),
                  "animalShelterId"=>$animal->getAnimalShelterId(),
                  "animalAdoptionStatus"=>$animal->getAnimalAdoptionStatus(),
                  "animalBreed"=>$animal->getanimalBreed(),
                  "animalGender"=>$animal->getAnimalGender(),
                  "animalName"=>$animal->getAnimalName(),
                  "animalPhotoUrl"=>$animal->getAnimalPhotoUrl(),
                  "animalSpecies"=>$animal->getAnimalSpecies(),
               ];
            }
            $reply->data = $animals;
         }
      } else if($method === "PUT" || $method === "POST") {
         // enforce the user has a XSRF token
         verifyXsrf();

         // enforce the user is signed in
         if(empty($_SESSION["user"]) === true) {
            throw(new \InvalidArgumentException("you must be logged in to like animals", 401));
         }

         $requestContent = file_get_contents("php://input");


         // Retrieves the JSON package that the front end sent, and stores it in $requestContent. Here we are using file_get_contents("php://input") to get the request from the front end. file_get_contents() is a PHP function that reads a file into a string. The argument for the function, here, is "php://input". This is a read only stream that allows raw data to be read from the front end request which is, in this case, a JSON package.
         $requestObject = json_decode($requestContent);

         // This Line Then decodes the JSON package and stores that result in $requestObject
         //make sure animal is available to be adopted (required field)
         if(empty($requestObject->animalAdoptionStatus) === true) {
            throw(new \InvalidArgumentException ("No Animal available for adoption.", 405));
         }
         $requestObject->foo; //value:bar

         //perform the actual put or post
         if($method === "PUT") {

            // retrieve the animal to update
            $animal = Animal::getAnimalByAnimalId($pdo, $id);
            if($animal === null) {
               throw(new RuntimeException("Animal does not exist", 404));
            }

            //enforce the end user has a JWT token


            //enforce the shelter that is signed in and only trying to edit their own animal
            if(empty($_SESSION["shelter"]) === true || $_SESSION["shelter"]->getShelterId()->toString() !== $animal->getAnimalShelterId()->toString()) {
               throw(new \InvalidArgumentException("You are not allowed to edit this animal", 403));
            }

            validateJwtHeader();

            // update all attributes
            //animal->setAdoptionStatus($requestObject->animalAdoptionStatus);
            $animal->setAdoptionStatus($requestObject->animalAdoptionStatus);
            $animal->update($pdo);

            // update reply
            $reply->message = "animal updated OK";

         } else if($method === "POST") {

            // enforce the user is signed in
            if(empty($_SESSION["shelter"]) === true) {
               throw(new \InvalidArgumentException("you must be logged in to post animals", 403));
            }

            //enforce the end user has a JWT token
            validateJwtHeader();

            // create new tweet and insert into the database
            $animal = new Animal(generateUuidV4(), $_SESSION["shelter"]->getShelterId(), $requestObject->animalAdoptionStatus, $requestObject->animalBreed, $requestObject->animalGender, $requestObject->animalName, $requestObject->animalPhotoUrl, $requestObject->animalSpecies);
            $animal->insert($pdo);

            // update reply
            $reply->message = "Animal created OK";
         }

      } else if($method === "DELETE") {

         //enforce that the end user has a XSRF token.
         verifyXsrf();

         // retrieve the Tweet to be deleted
         $animal = Animal::getAnimalByAnimalId($pdo, $id);
         if($animal === null) {
            throw(new RuntimeException("Animal does not exist", 404));
         }

         //enforce the user is signed in and only trying to edit their own tweet
         if(empty($_SESSION["shelter"]) === true || $_SESSION["shelter"]->getShelterId()->toString() !== $animal->getAnimalId()->toString()) {
            throw(new \InvalidArgumentException("You are not allowed to delete this animal", 403));
         }

         //enforce the end user has a JWT token
         validateJwtHeader();

         // delete tweet
         $animal->delete($pdo);
         // update reply
         $reply->message = "Animal deleted OK";
      } else {
         throw (new InvalidArgumentException("Invalid HTTP method request", 418));
      }
// update the $reply->status $reply->message
   } catch(\Exception | \TypeError $exception) {
      $reply->status = $exception->getCode();
      $reply->message = $exception->getMessage();
   }

// encode and return reply to front end caller
   header("Content-type: application/json");
   echo json_encode($reply);