<?php

   require_once dirname(__DIR__, 3) . "/vendor/autoload.php";
   require_once dirname(__DIR__, 3) . "/Classes/autoload.php";
   require_once dirname(__DIR__, 3) . "/lib/xsrf.php";
   require_once dirname(__DIR__, 3) . "/lib/jwt.php";
   require_once dirname(__DIR__, 3) . "/lib/uuid.php";
   require_once("/etc/apache2/capstone-mysql/Secrets.php");

   use PawsForCause\Paws\{Shelter, Animal};


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

      $id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
      $animalShelterId = filter_input(INPUT_GET, "animalShelterId", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
      $animalAdoptionStatus = filter_input(INPUT_GET, "animalAdoptionStatus", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
      $animalBreed = filter_input(INPUT_GET, "animalBreed", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
      $animalGender = filter_input(INPUT_GET, "animalGender", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
      $animalName = filter_input(INPUT_GET, "animalName", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
      $likeUserId = filter_input(INPUT_GET, "likeUserId", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
      $animalSpecies = filter_input(INPUT_GET, "animalSpecies", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

      //make sure the id is valid for methods that require it
      if(($method === "DELETE" || $method === "PUT") && (empty($id) === true)) {
         throw(new InvalidArgumentException("id cannot be empty or negative", 402));
      }


      // handle GET request - if id is present, that animal is returned, otherwise all animals are returned
      if($method === "GET") {
         //set XSRF cookie
         setXsrfCookie();

         //get a specific animal or all animals and update reply
         if(empty($id) === false) {
            $reply->data = Animal::getAnimalByAnimalId($pdo, $id);
         } else if(empty($animalShelterId) === false) {
            // if the user is logged in grab all the animals by that user based on animals liked
            $reply->data = Animal::getAnimalByShelterId($pdo, $animalShelterId)->toArray();

         } else if(empty($likeUserId) === false) {
            $reply->data = Animal::getAnimalByLikeUserId($pdo, $likeUserId)->toArray();

         } else {
            $reply->data = Animal::getAllAnimals($pdo)->toArray();
         }

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