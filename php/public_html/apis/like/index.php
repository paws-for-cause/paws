<?php

   require_once dirname(__DIR__, 3) . "/vendor/autoload.php";
   require_once dirname(__DIR__, 3) . "/Classes/autoload.php";
   require_once("/etc/apache2/capstone-mysql/Secrets.php");
   require_once dirname(__DIR__, 3) . "/lib/xsrf.php";
   require_once dirname(__DIR__, 3) . "/lib/jwt.php";
   require_once dirname(__DIR__, 3) . "/lib/uuid.php";


   use PawsForCause\Paws\{Like, User, Animal};

   /**
    * Api for the Like class
    *
    * @author Matthew Urrea <matt.urrea.code@gmail.com>
    */

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


      //sanitize the search parameters
      $likeAnimalId = $id = filter_input(INPUT_GET, "likeAnimalId", FILTER_SANITIZE_STRING,FILTER_FLAG_NO_ENCODE_QUOTES);
      $likeUserId = $id = filter_input(INPUT_GET, "likeUserId", FILTER_SANITIZE_STRING,FILTER_FLAG_NO_ENCODE_QUOTES);
	$likeApproved = $likeApproved = filter_input(INPUT_GET, "likeApproved", FILTER_VALIDATE_INT, FILTER_FLAG_NO_ENCODE_QUOTES);

      if($method === "GET") {
         //set XSRF cookie
         setXsrfCookie();

         //gets  a specific like associated based on its composite key
         if ($likeUserId !== null && $likeAnimalId !== null) {
            $like = Like::getLikeByLikeAnimalIdAndByLikeUserId($pdo, $likeUserId, $likeAnimalId);


            if($like!== null) {
               $reply->data = $like;
            }
            //if none of the search parameters are met throw an exception
         } else if(empty($likeUserId) === false) {
            $reply->data = Like::getLikeByLikeUserId($pdo, $likeUserId)->toArray();
            //get all the likes associated with the animalId
         } else if(empty($likeAnimalId) === false) {
            $reply->data = Like::getLikeByLikeAnimalId($pdo, $likeAnimalId)->toArray();
         } else {
            throw new InvalidArgumentException("incorrect search parameters ", 404);
         }

      } else if($method === "POST" || $method === "PUT") {

         //decode the response from the front end
         $requestContent = file_get_contents("php://input");
         $requestObject = json_decode($requestContent);



         if(empty($requestObject->likeAnimalId) === true) {
            throw (new \InvalidArgumentException("No Animal linked to the Like", 405));
         }

         if(empty($requestObject->likeApproved) === true) {
            throw (new \InvalidArgumentException("No action take on animal!", 405));
         }

         if($method === "POST") {

            //enforce that the end user has a XSRF token.
            verifyXsrf();

            //enforce the end user has a JWT token
            //validateJwtHeader();

            // enforce the user is signed in
            if(empty($_SESSION["user"]) === true) {
               throw(new \InvalidArgumentException("you must be logged in too like posts", 403));
            }

            validateJwtHeader();

            $like = new Like($requestObject->likeAnimalId, $_SESSION["user"]->getUserId(), $requestObject->likeApproved);
            $like->insert($pdo);
            $reply->message = "successfully liked animal";


         } else if($method === "PUT") {

            //enforce the end user has a XSRF token.
            verifyXsrf();

            //enforce the end user has a JWT token
            validateJwtHeader();

            //grab the like by its composite key
            $like = Like::getLikeByLikeAnimalIdAndByLikeUserId($pdo, $requestObject->likeUserId, $requestObject->likeAnimalId);
            if($like === null) {
               throw (new RuntimeException("Like does not exist"));
            }

            //enforce the user is signed in and only trying to edit their own like
            if(empty($_SESSION["user"]) === true || $_SESSION["user"]->getUserId()->toString() !== $like->getLikeUserId()->toString()) {
               throw(new \InvalidArgumentException("You are not allowed to do this.", 403));
            }

            //validateJwtHeader();

            //preform the actual delete
            $like->delete($pdo);

            //update the message
            $reply->message = "Like successfully deleted";
         }

         // if any other HTTP request is sent throw an exception
      } else {
         throw new \InvalidArgumentException("invalid http request", 400);
      }
      //catch any exceptions that is thrown and update the reply status and message
   } catch(\Exception | \TypeError $exception) {
      $reply->status = $exception->getCode();
      $reply->message = $exception->getMessage();
   }

   header("Content-type: application/json");
   if($reply->data === null) {
      unset($reply->data);
   }

   // encode and return reply to front end caller
   echo json_encode($reply);