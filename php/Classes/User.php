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
    * @param $userAge age of user
    * @param $userDescription description of user
    * @param $userEmail user email
    * @param $userFirstName user first name
    * @param $userGender user gender
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
    * accessor method for user activation token
    *
    * @return Uuid value of activation token
    **/
   public function getUserActivationToken(): ?string {
      return ($this->getUserActivationToken);
   }

   /**
    * mutator method for author activation token
    *
    * @param string $newUserActivationToken
    * @throws \InvalidArgumentException if the token is not a string or insecure
    * @throws \RangeException if $newUserActivationToken is not exactly 32 characters
    * @throws \TypeError if $newUserActivationToken is not a string
    **/
   public function setUserActivationToken(?string $newUserActivationToken) : void {
      if($newUserActivationToken === null){
         $this->userActivationToken = null;
         return;
      }
      $newUserActivationToken = strolower(trim($newUserActivationToken));
      if(ctype_xdigit($newUserActivationToken) === false) {
         throw(new\RangeException("user activation token is not valid"));
      }
      $this->userActivationToken = $newUserActivationToken;
   }

   /**
    * accessor method for user age
    *
    * @return integer value of the user description
    **/
   public function getUserAge() : int {
      return ($this->userAge);
   }

   /**
    * mutator method for user age
    *
    * @param integer $newUserAge new value of the users age
    * @throws \InvalidArgumentException if $newUserAge is not a integer or insecure
    * @throws \RangeException if $newUserAge is < 120
    * @throws \TypeError if $newUserAge is not a integer
    **/
   public function setUserAge(int $newUserAge) : void {
      //verify the age integer is secure
      $newUserAge = trim($newUserAge);
      $newUserAge = filter_var($newUserAge, FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_NO_ENCODE_QUOTES);
      if(empty($newUserAge)===true){
         throw(new \InvalidArgumentException("Age value empty or insecure"));
      }
      //verify age
      if(is_integer($newUserAge) < 120){
         throw (new \RangeException("Age value too large"));
      }
      //store the age value
      $this->userAge= $newUserAge;
   }

   /**
    * accessor method for user description
    *
    * @return string value of the user description
    **/
   public function getUserDescription() : string {
      return ($this->userDescription);
   }

   /**
    * mutator method for user description
    *
    * @param string $newUserDescription new value of description content
    * @throws \InvalidArgumentException if $newUserDescription is not a string or insecure
    * @throws \RangeException if $newUserDescription is > 200 characters
    * @throws \TypeError if $newUserDescription is not a string
    **/
   public function setUserDescription(string $newUserdescription) : void {
      //verify the description content is secure
      $newUserdescription = trim($newUserdescription);
      $newUserdescription = filter_var($newUserdescription, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
      if(empty($newUserdescription)===true){
         throw(new\InvalidArgumentException("Description is empty or insecure"));
      }
      //verify user description will fit in the database
      if(strlen($newUserdescription) > 200) {
         throw(new \RangeException("Description is too long"));
      }
      //store user description
      $this->userDescription = $newUserdescription;

   }

   /**
    * accessor method for user email
    *
    * @return string value of user email
    **/
    public function getUserEmail() : string {
       return($this->userEmail);
    }

   /**
    * mutator method for user email
    *
    * @param string $newUserEmail
    * @throws \InvalidArgumentException if the email is not a string or insecure
    * @throws \RangeException if $newUserEmail is not over 64 characters
    * @throws \TypeError if $newUserEmail is not a string
    **/
   public function setUserEmail(string $newUserEmail) : void {
      //verify that the user email is secure
      $newUserEmail = trim($newUserEmail);
      $newUserEmail = filter_var($newUserEmail, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
      if(empty($newUserEmail)===true) {
         throw(new \InvalidArgumentException("User email is empty or insecure"));
      }
         //verify that the user email will fit in the database
         if(strlen($newUserEmail) > 64) {
            throw(new \RangeException("User email is too long"));
         }

         //store the user email
         $this->userEmail = $newUserEmail;
      }

   /**
    * accessor method for user first name
    *
    * @return string value of user first name
    **/
    public function getUserFirstName() : string {
       return ($this->userFirstName);
    }

   /**
    * mutator method for user first name
    *
    * @param string $newUserFirstName new value for user first name
    * @throws \InvalidArgumentException if $newUserFirstName is not a string or insecure
    * @throws \RangeException if $newUserFirstName is > 32 characters
    * @throws \TypeError if $newUserFirstName is not a string
    **/
   public function setUserFirstName(string $newUserFirstName) : void {
      //verify that the user first name is secure
      $newUserFirstName = trim($newUserFirstName);
      $newUserFirstName = filter_var($newUserFirstName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
      if(empty($newUserFirstName)===true) {
         throw(new \InvalidArgumentException("User first name is empty or insecure"));
      }
      //verify that the user first name will fit in the database
      if(strlen($newUserFirstName) > 32) {
         throw(new \RangeException("User first name is too long"));
      }

      //store the user email
      $this->userFirstName = $newUserFirstName;
   }

   /**
    * accessor method for user gender
    *
    * @return string value of user gender
    **/
    public function getUserGender() : string {
       return($this->userGender);
    }
   /**
    * mutator method for user gender
    *
    * @param string $newUserGender new value for user gender
    * @throws \InvalidArgumentException if $newUserGender is not a string or insecure
    * @throws \RangeException if $newUserGender is > 32 characters
    * @throws \TypeError if $newUserGender is not a string
    **/
   public function setUserGender(string $newUserGender): void {
      //verify the user gender is secure
      $newUserGender = trim($newUserGender);
      $newUserGender = filter_var($newUserGender, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
      if(empty($newUserGender) === true) {
         throw(new \InvalidArgumentException("user gender is empty or insecure"));
      }

      //verify user gender will fit in the database
      if(strlen($newUserGender) > 32) {
         throw(new \RangeException("user gender is too large"));
      }

      //store the user gender
      $this->userGender = $newUserGender;
   }

   /**
    * accessor method for user hash
    *
    * @return string value of user hash
    **/
    public function getUserHash() : string {
       return ($this->userHash);
    }

   /**
    * mutator method for user password
    *
    * @param string $newUserHash string containing encrypted password
    * @throws \InvalidArgumentException if the hash is not secure
    * @throws \RangeException if $newUserHash is not 97 characters
    * @throws \TypeError if $newUserHash is not a sting
    **/
   public function setUserHash(string $newUserHash) : void {
      //enforce that the hash is properly formatted
      $newUserHash = trim($newUserHash);
      if(empty($newUserHash) === true) {
         throw(new \InvalidArgumentException("user password hash empty or insecure"));
      }
      //enforce that the hash is exactly 97 characters
      if(strlen($newUserHash) < 96) {
         throw(new \RangeException("user hash must be less than 96 characters"));
      }
      //store the hash
      $this->userHash = $newUserHash;
   }

   /**
    * accessor method for user last name
    *
    * @return string for user last name
    **/
    public function getUserLastName() : string {
      return $this->userLastName;
    }

   /**
    * mutator method for user first name
    *
    * @param string $newUserLastName new value for user first name
    * @throws \InvalidArgumentException if $newUserLastName is not a string or insecure
    * @throws \RangeException if $newUserLastName is > 32 characters
    * @throws \TypeError if $newUserLastName is not a string
    **/
   public function setUserLastName(string $newUserLastName) : void {
      //verify that the user last name is secure
      $newUserLastName = trim($newUserLastName);
      $newUserLastName = filter_var($newUserLastName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
      if(empty($newUserLastName)===true) {
         throw(new \InvalidArgumentException("User last name is empty or insecure"));
      }
      //verify that the user last name will fit in the database
      if(strlen($newUserLastName) > 32) {
         throw(new \RangeException("User last name is too long"));
      }

      //store the user last name
      $this->userLastName = $newUserLastName;
   }

   /**
    * accessor method for user phone number
    *
    * @return string value of user phone number
    **/
   public function getUserPhone(): string {
      return $this->userPhone;
   }

   /**
    * mutator method for user phone number
    *
    * @param string $newUserPhone new value of user phone number
    * @throws \InvalidArgumentException if $newUserPhone is not a string or insecure
    * @throws \RangeException if $newUserPhone is > 11 characters
    * @throws \TypeError if $newUserPhone is not a string
    **/
   public function setUserPhone(string $newUserPhone) : void {
      //verify the phone number is a string and secure
      $newUserPhone = trim($newUserPhone);
      $newUserPhone = filter_var($newUserPhone, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
      if(empty($newUserPhone) === true) {
         throw(new \InvalidArgumentException("user phone number is empty or insecure"));
      }

      //verify the phone number will fit in the database
      if(strlen($newUserPhone) > 11){
         throw(new \RangeException("user phone number is too long"));
      }

      //store phone number
      $this->userPhone = $newUserPhone;
   }

}