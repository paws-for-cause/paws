<?php

	namespace PawsForCause\Paws;

	require_once ("autoload.php");
	require_once (dirname(__DIR__)) . "/vendor/autoload.php";

	use Ramsey\Uuid\Uuid;

	/**
    * User Class
    *
    * This is the user class for the Capstone Project - Paws for the Cause.
    *
    * @author Matthew Urrea <matt.urrea.code@gmail.com>
    *
    **/

class User{
   /**
    * id for the user; this is the primary key
    * @var Uuid $userId
    **/
   private $userId;
   /**
    * id for userActivationToken
    * @var Uuid $userActivationToken
    **/
   private $userActivationToken;
   /**
    * integer for user age
    * @var integer $userAge;
    **/
   private $userAge;
   /**
    * description of the user
    * @var string $userDescription;
    **/
   private $userDescription;
   /**
    * email of the user
    * @var string $userEmail;
    **/
   private $userEmail;
   /**
    * first name of the user
    * @var string $userFirstName;
    **/
   private $userFirstName;
   /**
    * gender of user
    * @var string $userGender;
    **/
   private $userGender;
   /**
    * id for user password
    * @var string $userHash;
    **/
   private $userHash;
   /**
    * last name of user
    * @var string $userLastName;
    **/
   private $userLastName;
   /**
    *  phone number of user
    * @var string $userPhone;
    **/
   private $userPhone;

   /**
    * constructor method for user
    * @param $userId id for the user
    * @param $userActiviationToken activation token for the author
    * @param $userAge integer for user age
    * @param $userDescription description of user
    * @param $userEmail user email
    * @param $userFirstName user first name
    * @param $userGender gender of the user
    * @param $userHash password for the user
    * @param $userLastName user last name
    * @param $userPhone user phone number
    *
    **/
   public function __construct($userId, $userActivationToken, $userAge, $userDescription, $userEmail, $userFirstName, $userGender, $userHash, $userLastName, $userPhone) {
      $this->userId = $userId;
      $this->userActivationToken = $userActivationToken;
      $this->userAge = $userAge;
      $this->userDescription = $userDescription;
      $this->userEmail = $userEmail;
      $this->userFirstName = $userFirstName;
      $this->userGender = $userGender;
      $this->userHash = $userHash;
      $this->userLastName = $userLastName;
      $this->userPhone = $userPhone;
   }

   /**
    * accessor method for user id
    *
    * @return Uuid value of user id
    **/
   public function getUserId(): Uuid {
      return ($this->userId);
   }

   /**
    * mutator method for user id
    *
    * @param Uuid|string $newUserId new value of user id
    * @throws \RangeException if $newUserId is not positive
    * @throws \TypeError if $newUserId is not a uuid or string
    **/
   public function setUserId($newUserId): void {
      try {
         $uuid = self::validateUuid($newUserId);
      } catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
         $exceptionType = get_class($exception);
         throw (new $exceptionType($exception->getMessage(), 0, $exception));
      }

      //convert and store author id
      $this->userId = $uuid;
   }

   /**
    * accessor method for a
    *
    ** /







}