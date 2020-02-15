<?php

   namespace PawsForCause\Paws;

   require_once("autoload.php");
//require_once("ValidateUuid.php");
   require_once(dirname(__DIR__) . "/vendor/autoload.php");

   use Ramsey\Uuid\Uuid;

   /**
    *
    * @author Thomas Dameron <tdameron1@cnm.edu>
    * @version 1.0.0
    **/
   class Animal {
      use ValidateUuid;

      //properties below
      /**
       *
       * @var Uuid $animalId
       * id for the animal, this is the primary key
       **/
      private $animalId;
      /**
       * id for the Animal Shelter; this is the foreign key
       * @var Uuid $animalShelterId
       **/

      private $animalShelterId;

      /**
       * the status of whether or not the animal has been adopted yet,
       * @var string $animalAdoptionStatus
       **/


      private $animalAdoptionStatus;

      /**
       * the breed of the cat or dog
       * @var string $animalBreed
       */
      private $animalBreed;
      /**
       * The gender of the animal
       * @var string $animalGender
       */
      private $animalGender;
      /**
       * The name of the animal
       * @var string $animalName
       */
      private $animalName;
      /**
       * animalPhotoUrl
       * The URL for the photo of the animal
       * @var string $animalPhotoUrl
       */
      private $animalPhotoUrl;
      /**
       * The species of the animal
       * @var string $animalSpecies
       */

      private $animalSpecies;

      /**
       * constructor for the animal class
       *
       * @param string|Uuid $newAnimalId
       * @param string|Uuid $newAnimalShelterId
       * @param string $newAnimalAdoptionStatus
       * @param string|$newAnimalBreed
       * @param string $newAnimalGender
       * @param string $newAnimalName
       * @param string $newAnimalPhotoUrl
       * @param string $newAnimalSpecies
       * @Documentation https://php.net/manual/en/language.oop5.decon.php
       **/

      public function __construct($newAnimalId, $newAnimalShelterId, string $newAnimalAdoptionStatus, string $newAnimalBreed, string $newAnimalGender, string $newAnimalName, string $newAnimalPhotoUrl, string $newAnimalSpecies) {
         try {
            $this->setAnimalId($newAnimalId);
            $this->setAnimalShelterId($newAnimalShelterId);
            $this->setAnimalAdoptionStatus($newAnimalAdoptionStatus);
            $this->setAnimalBreed($newAnimalBreed);
            $this->setAnimalGender($newAnimalGender);
            $this->setAnimalName($newAnimalName);
            $this->setAnimalPhotoUrl($newAnimalPhotoUrl);
            $this->setAnimalSpecies($newAnimalSpecies);
         } catch(\InvalidArgumentException | \RangeException | \TypeError $exception) {
            $exceptionType = get_class($exception);
            throw(new $exceptionType ($exception->getMessage(), 0, $exception));
         }
      }

      /**
       * accessor method for animal id
       *
       * @return Uuid value of animal id
       **/
      public function getAnimalId(): Uuid {
         return ($this->animalId);
      }

      public function getAnimalShelterId(): Uuid {
         return ($this->animalShelterId);
      }

      public function getAnimalAdoptionStatus($animalAdoptionStatus) {
         $this->animalAdoptionStatus;
      }

      public function getAnimalBreed($animalBreed) {
         $this->animalBreed;
      }

      public function getAnimalGender($animalGender) {
         $this->animalGender;
      }

      public function getAnimalName($animalName) {
         $this->animalName;
      }

      public function getAnimalPhotoUrl($animalPhotoUrl) {
         $this->animalPhotoUrl;
      }

      public function getAnimalSpecies($animalSpecies) {
         $this->animalSpecies;
      }

      //** MUTATORS BELOW  **//

      /**
       * Mutator Method for animalId - This is the Primary Key
       *
       * @param string $newAnimalId
       * @throws \InvalidArgumentException if the data types are not InvalidArgumentException
       * @throws \RangeException if the data values are out of bounds (i.e. too long or negative)
       * @throws \TypeError if data types violate type hints
       **/
      public function setAnimalId($newAnimalId): void {
         try {
            $uuid = self::validateUuid($newAnimalId);
         } catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
            $exceptionType = get_class($exception);
            throw(new $exceptionType($exception->getMessage(), 0, $exception));
         }

         // convert and store the animal id
         $this->animalId = $uuid;
      }

      /**
       * Mutator for animalShelterId - This is the foreign key
       *
       * @param string $newAnimalShelterId
       * @throws \InvalidArgumentException if the data types are not InvalidArgumentException
       * @throws \RangeException if the data values are out of bounds (i.e. too long or negative)
       * @throws \TypeError if data types violate type hints
       **/
      public function setAnimalShelterId($newAnimalShelterId): void {
         try {
            $uuid = self::validateUuid($newAnimalShelterId);
         } catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
            $exceptionType = get_class($exception);
            throw(new $exceptionType($exception->getMessage(), 0, $exception));
         }

         // convert and store the anima id
         $this->animalShelterId = $uuid;
      }

      /**
       * mutator method for animal adoption status
       *
       * @param string $newAnimalAdoptionStatus new value of at handle
       * @throws \InvalidArgumentException if $newAnimalAdoptionStatus is not a string or insecure
       * @throws \RangeException if $newAnimalAdoptionStatus is > 32 characters
       * @throws \TypeError if $newAnimalAdoptionStatus is not a string
       **/
      public function setAnimalAdoptionStatus(string $newAnimalAdoptionStatus): void {
         // verify the adoption status is secure
         $newAnimalAdoptionStatus = trim($newAnimalAdoptionStatus);
         $newAnimalAdoptionStatus = filter_var($newAnimalAdoptionStatus, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
         if(empty($newAnimalAdoptionStatus) === true) {
            throw(new \InvalidArgumentException("adoption status is empty or insecure"));
         }
         // verify the at handle will fit in the database
         if(strlen($newAnimalAdoptionStatus) > 32) {
            throw(new \RangeException("adoption status is too large"));
         }
         // store the at handle
         $this->animalName = $newAnimalAdoptionStatus;
      }

      /**
       * mutator method for animal breed
       *
       * @param string $newAnimalBreed new value of at handle
       * @throws \InvalidArgumentException if $newAnimalBreed is not a string or insecure
       * @throws \RangeException if $newAnimalBreed is > 32 characters
       * @throws \TypeError if $newAnimalBreed is not a string
       **/
      public function setAnimalBreed(string $newAnimalBreed): void {
         // verify the breed is secure
         $newAnimalBreed = trim($newAnimalBreed);
         $newAnimalBreed = filter_var($newAnimalBreed, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
         if(empty($newAnimalBreed) === true) {
            throw(new \InvalidArgumentException("animal name is empty or insecure"));
         }
         // verify the at handle will fit in the database
         if(strlen($newAnimalBreed) > 32) {
            throw(new \RangeException("name of animal breed is too large"));
         }
         // store the at handle
         $this->animalName = $newAnimalBreed;
      }


//** TinyInt mutator */
      function setAnimalGender(string $newAnimalGender) {
         // verify the gender input is valid
         if(($newAnimalGender > 1) || ($newAnimalGender < 0)) ;
         {
            throw(new \RangeException("animal gender value is invalid"));

            // store the animal gender
            $this->animalGender = $newAnimalGender;
         }
      }

      /**
       * mutator method for animal name
       *
       * @param string $newAnimalName new value of at handle
       * @throws \InvalidArgumentException if $newAnimalName is not a string or insecure
       * @throws \RangeException if $newAnimalName is > 32 characters
       * @throws \TypeError if $newAnimalname is not a string
       **/
      public function setAnimalName(string $newAnimalName): void {
         // verify the at handle is secure
         $newAnimalName = trim($newAnimalName);
         $newAnimalName = filter_var($newAnimalName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
         if(empty($newAnimalName) === true) {
            throw(new \InvalidArgumentException("animal name is empty or insecure"));
         }
         // verify the at handle will fit in the database
         if(strlen($newAnimalName) > 32) {
            throw(new \RangeException("animal name is too large"));
         }
         // store the at handle
         $this->animalName = $newAnimalName;
      }


      /**
       * mutator method for the Animal Photo Url
       *
       * @param string $newAnimalPhotoUrl new value of at handle
       * @throws \InvalidArgumentException if $newAnimalPhotoUrl is not a string or insecure
       * @throws \RangeException if $newAnimalPhotoUrl is > 32 characters
       * @throws \TypeError if $newAnimalPhotoUrl is not a string
       **/
      public function setAnimalPhotoUrl(string $newAnimalPhotoUrl): void {
         // verify the at handle is secure
         $newAnimalPhotoUrl = trim($newAnimalPhotoUrl);
         $newAnimalPhotoUrl = filter_var($newAnimalPhotoUrl, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
         if(empty($newAnimalPhotoUrl) === true) {
            throw(new \InvalidArgumentException("Avatar url is empty or insecure"));
         }
         // verify the at handle will fit in the database
         if(strlen($newAnimalPhotoUrl) > 32) {
            throw(new \RangeException("Avatar url is too large"));
         }
         // store the at handle
         $this->animalPhotoUrl = $newAnimalPhotoUrl;
      }

      /**
       * mutator method for animal species
       *
       * @param string $newAnimalSpecies new value of animal species
       * @throws \InvalidArgumentException if $newAnimalSpecies is not a string or insecure
       * @throws \RangeException if $newAnimalSpecies is > 32 characters
       * @throws \TypeError if $newAnimalSpecies is not a string
       **/
      public function setAnimalSpecies(string $newAnimalSpecies): void {
         // verify the at handle is secure
         $newAnimalSpecies = trim($newAnimalSpecies);
         $newAnimalSpecies = filter_var($newAnimalSpecies, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
         if(empty($newAnimalSpecies) === true) {
            throw(new \InvalidArgumentException("animal species is empty or insecure"));
         }
         // verify the at handle will fit in the database
         if(strlen($newAnimalSpecies) > 32) {
            throw(new \RangeException("name of animal species is too large"));
         }
         // store the at handle
         $this->animalSpecies = $newAnimalSpecies;
      }


      /**
       * formats the state variables for JSON serialization
       *
       * @return array resulting state variables to serialize
       **/
      public function jsonSerialize(): array {
         $fields = get_object_vars($this);

         $fields["animalId"] = $this->animalId->toString();
      }



//**getFooByBar methods below**//


      /**
       *
       * getAnimalByAnimalId
       *
       * a method that returns an SplFixedArray of all animals
       *
       * @param \PDO $pdo
       * @param string $animalId
       * @return animalSplFixedArray
       */
      public static function getAnimalByAnimalId(\PDO $pdo, string $animalId): \SPLFixedarray {

         //sanitize the description before searching
         //** trims the animal username to a set number of characters for security */
         $animalId = trim($animalId);
         //**filter_var filters a variable, the format is: filter_var($animalId <-variable goes here, FILTER_SANITIZE_STRING <- filters go here seperated by commas)
         //**FILTER_SANITZE_STRING will strip tags, FILTER_FLAG_NO_ENCODE_QUOTES will strip invalid characters. **//
         $animalId = filter_var($animalId, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);


         // escape any mySQL wild cards
         //** str_replace("%","\\%", $animalId) will replace the command "%" with the string character "%", this will prevent security breaches.*/
         $result = str_replace("%", "\\%", $animalId);
         $animalId = str_replace("_", "\\", $result);

         // create query template
         $query = "SELECT animalId, animalShelterId, animalAdoptionStatus, animalBreed, animalGender, animalName, animaPhotoUrl, animalSpecies FROM Animal LIKE :animalId";
         $statement = $pdo->prepare($query);
         //bind the animalId to the place holder in the template
         $animalId = "%animalId%";
         $parameters = ["animalId" => $animalId];
         $statement->execute($parameters);

         // building an array of Anuimals
         $animalArray = SplFixedArray($statement->rowCount());
         $statement->setFetchMode(\PDO::FETCH_ASSOC);
         while(($row = $statement->fetch()) !== false) {
            try {
               $animal = new Animal($row["animalId"], $row["animalShelterId"], $row["animalAdoptionStatus"], $row["animalBreed"], $row["animalGender"], $row["animalName"], $row["animalPhotoUrl"], $row["animalSpecies"]);
               $animalArray[$animalArray->key()] = $animal;
               $animalArray->next();
            } catch(\Exception $exception) {
               // if the row couldn't be converted, rethrow it
               throw(new \PDOException($exception->getMessage(), 0, $exception));
            }
         }
         return ($animalArray);
      }

      /**
       *
       * getAnimaByShelterId
       *
       * a method that returns an SplFixedArray of animal Shelter Ids
       *
       * @param \PDO $pdo
       * @param string $animalShelterId
       * @return animalSplFixedArray
       */
      public static function getAnimalByShelterId(\PDO $pdo, string $animalId): \SPLFixedarray {

         //sanitize the description before searching
         //** trims the animal username to a set number of characters for security */
         $animalId = trim($animalId);
         //**filter_var filters a variable, the format is: filter_var($animalId <-variable goes here, FILTER_SANITIZE_STRING <- filters go here seperated by commas)
         //**FILTER_SANITZE_STRING will strip tags, FILTER_FLAG_NO_ENCODE_QUOTES will strip invalid characters. **//
         $animalId = filter_var($animalId, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);


         // escape any mySQL wild cards
         //** str_replace("%","\\%", $animalId) will replace the command "%" with the string character "%", this will prevent security breaches.*/
         $result = str_replace("%", "\\%", $animalId);
         $animalId = str_replace("_", "\\", $result);

         // create query template
         $query = "SELECT animalId, animalShelterId, animalAdoptionStatus, animalBreed, animalGender, animalName, animaPhotoUrl, animalSpecies FROM Animal LIKE :animalShelterId";
         $statement = $pdo->prepare($query);
         //bind the animalId to the place holder in the template
         $animalShelterId = "%animalShelterId%";
         $parameters = ["animalShelterId" => $animalShelterId];
         $statement->execute($parameters);

         // building an array of Animals
         $animalArray = SplFixedArray($statement->rowCount());
         $statement->setFetchMode(\PDO::FETCH_ASSOC);
         while(($row = $statement->fetch()) !== false) {
            try {
               $animal = new Animal($row["animalId"], $row["animalShelterId"], $row["animalAdoptionStatus"], $row["animalBreed"], $row["animalGender"], $row["animalName"], $row["animalPhotoUrl"], $row["animalSpecies"]);
               $animalArray[$animalArray->key()] = $animal;
               $animalArray->next();
            } catch(\Exception $exception) {
               // if the row couldn't be converted, rethrow it
               throw(new \PDOException($exception->getMessage(), 0, $exception));
            }
         }
         return ($animalArray);
      }

//get Animals by likeUserId

      /**
       * gets the Animal by userLikeId
       * @param \PDO $pdo PDO connection object
       * @param string $likeUserId like id to search by
       * @return \SplFixedArray SplFixedArray of Animals found
       * @throws \PDOException when mySQL related errors occur
       * @throws \TypeError when variables are not the correct data type
       **/
      public static function getAnimalByLikeUserId(\PDO $pdo, string $userLikeId): \SPLFixedArray {
         try {
            $likeUserId = self::validateUuid($userLikeId);
         } catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
            throw(new \PDOException($exception->getMessage(), 0, $exception));
         }
         // create query template
         $query = "SELECT animal.animalId, animal.animalShelterId, animal.adoptionStatus, animal.animalBreed, animal.animalGender, animal.animalName, animal.animalPhotoUrl FROM animal INNER JOIN `like` ON animal.animalId = `like`.likeUserId WHERE likeUserId = :likeUserId";
         $statement = $pdo->prepare($query);
         // bind the user like id to the place holder in the template
         $parameters = ["likeUserId" => $likeUserId->getBytes()];
         $statement->execute($parameters);
         // build an array of tweets
         $animalArray = new \SplFixedArray($statement->rowCount());
         $statement->setFetchMode(\PDO::FETCH_ASSOC);
         while(($row = $statement->fetch()) !== false) {
            try {
               $object = (object)[
                  "animalId" => $row["animalId"],
                  "animalShelterId" => $row["animalShelterId"],
                  "animalAdoptionStatus" => $row["animalAdoptionStatus"],
                  "animalBreed" => $row["animalBreed"],
                  "animalGender" => $row["animalGender"],
                  "animalName" => $row["animalName"],
                  "animalPhotoUrl" => $row["animalPhotoUrl"],
               ];
               $animalArray[$animalArray->key()] = $object;
               $animalArray->next();
            } catch(\Exception $exception) {
               // if the row couldn't be converted, rethrow it
               throw(new \PDOException($exception->getMessage(), 0, $exception));
            }
         }
         return ($animalArray);
      }

      /**
       * inserts this Animal into mySQL
       *
       * @param \PDO $pdo PDO connection object
       * @throws \PDOException when mySQL related errors occur
       * @throws \TypeError if $pdo is not a PDO connection object
       **/
      public function insert(\PDO $pdo): void {

         // create query template
         $query = "INSERT INTO Animal(animalId, animalShelterId, animalAdoptionStatus, animalBreed, animalGender, animalName, animalPhotoUrl, animalSpecies) VALUES(:animalId, :animalShelterId, :animalAdoptionStatus, :animalBreed, :animalGender, :animalName, :animalPhotoUrl, :animalSpecies)";
         $statement = $pdo->prepare($query);

         $parameters = ["animalId" => $this->animalId->getBytes(), "animalShelterId" => $this->animalShelterId->getBytes(), "animalAdoptionStatus" => $this->animalAdoptionStatus, "animalBreed" => $this->animalBreed, "animalGender" => $this->animalGender, "animalName" => $this->animalName, "animalPhotoUrl" => $this->animalPhotoUrl, "animalSpecies" => $this->animaSpecies];
         $statement->execute($parameters);
      }

      /**
       * deletes this animal from mySQL
       *
       * @param \PDO $pdo PDO connection object
       * @throws \PDOException when mySQL related errors occur
       * @throws \TypeError if $pdo is not a PDO connection object
       **/
      public function delete(\PDO $pdo): void {

         // create query template
         $query = "DELETE FROM Animal WHERE animalId = :animalId";
         $statement = $pdo->prepare($query);

         // bind the member variables to the place holder in the template
         $parameters = ["animalId" => $this->animalId->getBytes()];
         $statement->execute($parameters);
      }

      /**
       * Updates this Animal in mySQL
       *
       * @param \PDO $pdo PDO connection object
       * @throws \PDOException when mySQL related errors occur
       * @throws \TypeError if $pdo is not a PDO connection object
       **/
      public function update(\PDO $pdo): void {

         // create query template
         $query = "UPDATE Animal SET animalId = :animalId WHERE animalId = :animalId";
         $statement = $pdo->prepare($query);


         $parameters = ["animalId" => $this->animalId->getBytes()];
         $statement->execute($parameters);
      }
   }