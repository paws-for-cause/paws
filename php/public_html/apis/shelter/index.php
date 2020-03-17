<?php


   require_once dirname(__DIR__, 3) . "/vendor/autoload.php";
   require_once dirname(__DIR__, 3) . "/Classes/autoload.php";
   require_once("/etc/apache2/capstone-mysql/Secrets.php");
   require_once dirname(__DIR__, 3) . "/lib/xsrf.php";
   require_once dirname(__DIR__, 3) . "/lib/jwt.php";
   require_once dirname(__DIR__, 3) . "/lib/uuid.php";
   require_once("/etc/apache2/capstone-mysql/Secrets.php");

   use PawsForCause\Paws\Shelter;

   /**
    * API for Shelter
    *
    * @author Matthew Urrea <matt.urrea.code@gmail.com>
    * @version 1.0
    */

//verify the session, if it is not active start it
   if(session_status() !== PHP_SESSION_ACTIVE) {
      session_start();
   }
//prepare an empty reply
   $reply = new stdClass();
   $reply->status = 200;
   $reply->data = null;

   try {
      //grab the mySQL connection

      $secrets = new \Secrets("/etc/apache2/capstone-mysql/paws.ini");
      $pdo = $secrets->getPdoObject();


      //determine which HTTP method was used
      $method = $_SERVER["HTTP_X_HTTP_METHOD"] ?? $_SERVER["REQUEST_METHOD"];

      // sanitize input
      $id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
      $shelterAddress = filter_input(INPUT_GET, "shelterAddress", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
      $shelterName = filter_input(INPUT_GET, "shelterAddress", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
      $shelterPhone = filter_input(INPUT_GET, "shelterPhone", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);


      // make sure the id is valid for methods that require it
      if(($method === "DELETE" || $method === "PUT") && (empty($id) === true)) {
         throw(new InvalidArgumentException("id cannot be empty or negative", 405));
      }

      if($method === "GET") {
         //set XSRF cookie
         setXsrfCookie();

         //gets a shelter by id
         if(empty($id) === false) {
            $reply->data = Shelter::getShelterByShelterId($pdo, $id);

         }

      } elseif($method === "PUT") {

         //enforce that the XSRF token is present in the header
         verifyXsrf();

         //enforce the end user has a JWT token
         //validateJwtHeader();

         //enforce the shelter is signed in and only trying to edit their own profile
         if(empty($_SESSION["shelter"]) === true || $_SESSION["shelter"]->getShelterId()->toString() !== $id) {
            throw(new \InvalidArgumentException("You are not allowed to access this profile", 403));
         }

         validateJwtHeader();

         //decode the response from the front end
         $requestContent = file_get_contents("php://input");
         $requestObject = json_decode($requestContent);

         //retrieve the shelter to be updated
         $shelter = Shelter::getShelterByShelterId($pdo, $id);
         if($shelter === null) {
            throw(new RuntimeException("Shelter does not exist", 404));
         }

         //shelter address
         if(empty($requestObject->shelterAddress) === true) {
            throw(new \InvalidArgumentException ("No shelter address", 405));
         }

         //profile at handle
         if(empty($requestObject->shelterName) === true) {
            throw(new \InvalidArgumentException ("No shelter name", 405));
         }

         //profile at handle
         if(empty($requestObject->shelterPhone) === true) {
            throw(new \InvalidArgumentException ("No shelter phone number", 405));
         }

         $shelter->setShelterAddress($requestObject->shelterAddress);
         $shelter->setShelterName($requestObject->shelterName);
         $shelter->setShelterPhone($requestObject->shelterPhone);
         $shelter->update($pdo);

         // update reply
         $reply->message = "Shelter information updated";


      } elseif($method === "DELETE") {

         //verify the XSRF Token
         verifyXsrf();

         //enforce the end user has a JWT token
         //validateJwtHeader();

         $shelter = Shelter::getShelterByShelterId($pdo, $id);
         if($shelter === null) {
            throw (new RuntimeException("Shelter does not exist"));
         }

         //enforce the user is signed in and only trying to edit their own profile
         if(empty($_SESSION["shelter"]) === true || $_SESSION["shelter"]->getShelterId()->toString() !== $shelter->getShelterId()->toString()) {
            throw(new \InvalidArgumentException("You are not allowed to access this shelter", 403));
         }

         validateJwtHeader();

         //delete the post from the database
         $shelter->delete($pdo);
         $reply->message = "Shelter Deleted";

      } else {
         throw (new InvalidArgumentException("Invalid HTTP request", 400));
      }
      // catch any exceptions that were thrown and update the status and message state variable fields
   } catch
   (\Exception | \TypeError $exception) {
      $reply->status = $exception->getCode();
      $reply->message = $exception->getMessage();
   }

   header("Content-type: application/json");
   if($reply->data === null) {
      unset($reply->data);
   }

// encode and return reply to front end caller
   echo json_encode($reply);