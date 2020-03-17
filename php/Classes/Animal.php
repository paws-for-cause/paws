<?php

   namespace PawsForCause\Paws;

   require_once("autoload.php");
//require_once("ValidateUuid.php");
   require_once(dirname(__DIR__) . "/vendor/autoload.php");

   use Exception;
   use InvalidArgumentException;
   use \PDO;
   use PDOException;
   use Ramsey\Uuid\Uuid;
   use RangeException;
   use SplFixedArray;
   use TypeError;

   /**
    *
    * @author Thomas Dameron <tdameron1@cnm.edu>
    * @version 1.0.0
    **/
   class Animal implements \JsonSerializable {
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
       * @var int $animalGender
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
       * @param string|Uuid $newAnimalId the id for the animal
       * @param string|Uuid $newAnimalShelterId new animal shelter id for animal class
       * @param string $newAnimalAdoptionStatus whether or not the animal has been adopted
       * @param string|$newAnimalBreed the breed of the animal
       * @param int $newAnimalGender the gender of the animal
       * @param string $newAnimalName the name of the animal
       * @param string $newAnimalPhotoUrl the Url of the photo that is associated with the naimal
       * @param string $newAnimalSpecies the species of the animal
		 * @throws \InvalidArgumentException if data types are not valid
		 * @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers)
		 * @throws \TypeError if data types violate type hints
		 * @throws \Exception if some other exception occurs
       * @Documentation https://php.net/manual/en/language.oop5.decon.php
       **/

      public function __construct($newAnimalId, $newAnimalShelterId, string $newAnimalAdoptionStatus, string $newAnimalBreed, int $newAnimalGender, string $newAnimalName, string $newAnimalPhotoUrl, string $newAnimalSpecies) {
         try {
            $this->setAnimalId($newAnimalId);
            $this->setAnimalShelterId($newAnimalShelterId);
            $this->setAnimalAdoptionStatus($newAnimalAdoptionStatus);
            $this->setAnimalBreed($newAnimalBreed);
            $this->setAnimalGender($newAnimalGender);
            $this->setAnimalName($newAnimalName);
            $this->setAnimalPhotoUrl($newAnimalPhotoUrl);
            $this->setAnimalSpecies($newAnimalSpecies);
         } catch(InvalidArgumentException | RangeException | TypeError $exception) {
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

      /**
       * mutator method for animalId - This is the Primary Key
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
       * accessor method for animalShelterId
       *
       * @return Uuid
       */
      public function getAnimalShelterId(): Uuid {
         return ($this->animalShelterId);
      }

      /**
       * mutator method for animal shelter id
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
		 * accessor method for the Animal Adoption Status
		 *
		 * @return string
		 */
      public function getAnimalAdoptionStatus(): string {
         return ($this->animalAdoptionStatus);
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
         $this->animalAdoptionStatus = $newAnimalAdoptionStatus;
      }

		/**
		 * accessor method for the animal breed
		 *
		 * @return string
		 */

      public function getAnimalBreed(): string {
         return ($this->animalBreed);
      }

      /**
       * mutator method for animal breed
       *
       * @param string $newAnimalBreed new value of at handle
       * @throws \InvalidArgumentException if $newAnimalBreed is not a string or insecure
       * @throws \RangeException if $newAnimalBreed is > 64 characters
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
         if(strlen($newAnimalBreed) > 64) {
            throw(new \RangeException("name of animal breed is too large"));
         }
         // store the at handle
         $this->animalBreed = $newAnimalBreed;
      }

		/**
		 * accessor method for the Animal Gender
		 *
		 * @return int
		 */
      public function getAnimalGender(): int {
         return ($this->animalGender);
      }

      /**
       * mutator method for animal gender
       * @param int $newAnimalGender gender value for animal
       * @throws \RangeException if $newAnimalGender is invalid
       */

      function setAnimalGender(int $newAnimalGender) {
         // verify the gender input is valid
         if(($newAnimalGender > 1) || ($newAnimalGender < 0))

            throw(new \RangeException("animal gender value is invalid"));

         // store the animal gender
         $this->animalGender = $newAnimalGender;
      }

		/**
		 * accessor method for the name of the animal
		 *
		 * @return string
		 */
      public function getAnimalName() {
         return ($this->animalName);
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
		 * accessor for the photo url of the animal
		 *
		 * @return string
		 */
      public function getAnimalPhotoUrl() {
         return ($this->animalPhotoUrl);
      }

      /**
       * mutator method for the Animal Photo Url
       *
       * @param string $newAnimalPhotoUrl new value of at handle
       * @throws \InvalidArgumentException if $newAnimalPhotoUrl is not a string or insecure
       * @throws \RangeException if $newAnimalPhotoUrl is > 256 characters
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
         if(strlen($newAnimalPhotoUrl) > 256) {
            throw(new \RangeException("Avatar url is too large"));
         }
         // store the at handle
         $this->animalPhotoUrl = $newAnimalPhotoUrl;
      }

		/**
		 * accessor method for the species of the animal
		 *
		 * @return string
		 */
      public function getAnimalSpecies() {
         return ($this->animalSpecies);
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
       *
       * gets the animal by id
       *
       * @param \PDO $pdo - PDO connection object
       * @param string $animalId - the animal id to search for
       * @return animal - returns the animal that is in the database
		 * @throws \RangeException if the $animalId is out of too many/few characters
		 * @throws \TypeError if the $animalId is not a uuid or string
       */
      public static function getAnimalByAnimalId(\PDO $pdo, string $animalId): ?Animal {
         // sanitize the animalId before searching
         try {
            $animalId = self::validateUuid($animalId);
         } catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
            throw(new \PDOException($exception->getMessage(), 0, $exception));
         }

         // create query template
         $query = "SELECT animalId, animalShelterId, animalAdoptionStatus, animalBreed, animalGender, animalName, animalPhotoUrl, animalSpecies FROM animal WHERE animalId = :animalId";
         $statement = $pdo->prepare($query);

         // bind the animal id to the place holder in the template
         $parameters = ["animalId" => $animalId->getBytes()];
         $statement->execute($parameters);

         //grab the animal from mySQL
         try {
            $animal = null;
            $statement->setFetchMode(\PDO::FETCH_ASSOC);
            $row = $statement->fetch();
            if($row !== false) {
               $animal = new Animal($row["animalId"], $row["animalShelterId"], $row["animalAdoptionStatus"], $row["animalBreed"], $row['animalGender'], $row["animalName"], $row["animalPhotoUrl"], $row["animalSpecies"]);
            }
         } catch(Exception $exception) {
            // if the row coudn't be converted, rethrow it
            throw (new \PDOException($exception->getMessage(), 0, $exception));
         }
         return ($animal);
      }

      /**
       *
       *
       * gets animals by shelter id
       *
       * @param \PDO $pdo
       * @param string $animalShelterId id for the shelter
       * @return animal SplFixedArray of animals
		 * @throws \RangeException if shelter value is invalid
       */
      public static function getAnimalByShelterId(\PDO $pdo, string $animalShelterId): SPLFixedarray {

         try {
            $animalShelterId = self::validateUuid($animalShelterId);
         } catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
            throw(new \PDOException($exception->getMessage(), 0, $exception));
         }

         // create query template
         $query = "SELECT animalId, animalShelterId, animalAdoptionStatus, animalBreed, animalGender, animalName, animalPhotoUrl, animalSpecies FROM animal WHERE animalShelterId = :animalShelterId";
         $statement = $pdo->prepare($query);
         //bind the animalId to the place holder in the template
         $parameters = ["animalShelterId" => $animalShelterId->getBytes()];
         $statement->execute($parameters);

         // building an array of Animals
         $animalArray = new SplFixedArray($statement->rowCount());
         $statement->setFetchMode(\PDO::FETCH_ASSOC);
         while(($row = $statement->fetch()) !== false) {
            try {
               $animal = new Animal($row["animalId"], $row["animalShelterId"], $row["animalAdoptionStatus"], $row["animalBreed"], $row["animalGender"], $row["animalName"], $row["animalPhotoUrl"], $row["animalSpecies"]);
               $animalArray[$animalArray->key()] = $animal;
               $animalArray->next();

            } catch(Exception $exception) {
               // if the row couldn't be converted, rethrow it
               throw(new \PDOException($exception->getMessage(), 0, $exception));
            }
         }
         return ($animalArray);
      }

      /**
       * gets an array of animal by user like
       * @param \PDO $pdo PDO connection object
       * @param string $likeUserId like id to search by
       * @return \SplFixedArray SplFixedArray of Animals found
       * @throws \PDOException when mySQL related errors occur
       * @throws \TypeError when variables are not the correct data type
       **/
      public static function getAnimalByLikeUserId(\PDO $pdo, string $likeUserId): SPLFixedArray {
         try {
            $likeUserId = self::validateUuid($likeUserId);
         } catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
            throw(new \PDOException($exception->getMessage(), 0, $exception));
         }
         // create query template
         $query = "SELECT animal.animalId, animal.animalShelterId, animal.animalAdoptionStatus, animal.animalBreed, animal.animalGender, animal.animalName, animal.animalPhotoUrl, animal.animalSpecies FROM animal INNER JOIN `like` ON animal.animalId = `like`.likeAnimalId WHERE likeUserId = :likeUserId";
         $statement = $pdo->prepare($query);
         // bind the user like id to the place holder in the template
         $parameters = ["likeUserId" => $likeUserId->getBytes()];
         $statement->execute($parameters);
         // build an array of tweets
         $animalArray = new SplFixedArray($statement->rowCount());
         $statement->setFetchMode(PDO::FETCH_ASSOC);
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
                  "animalSpecies" => $row["animalSpecies"]
               ];
               $animalArray[$animalArray->key()] = $object;
               $animalArray->next();
            } catch(Exception $exception) {
               // if the row couldn't be converted, rethrow it
               throw(new PDOException($exception->getMessage(), 0, $exception));
            }
         }
         return ($animalArray);
      }

      /**
       * gets all Animals
       *
       * @param \PDO $pdo PDO connection object
       * @return \SplFixedArray SplFixedArray of Animals found or null if not found
       * @throws \PDOException when mySQL related errors occur
       * @throws \TypeError when variables are not the correct data type
       **/
      public static function getAllAnimals(\PDO $pdo) : \SPLFixedArray {
         // create query template
         $query = "SELECT animalId, animalShelterId, animalAdoptionStatus, animalBreed, animalGender, animalName, animalPhotoUrl, animalSpecies FROM animal";
         $statement = $pdo->prepare($query);
         $statement->execute();

         // build an array of animals
         $animals = new \SplFixedArray($statement->rowCount());
         $statement->setFetchMode(\PDO::FETCH_ASSOC);
         while(($row = $statement->fetch()) !== false) {
            try {
               $animal = new Animal($row["animalId"], $row["animalShelterId"], $row["animalAdoptionStatus"], $row["animalBreed"], $row["animalGender"], $row["animalName"], $row["animalPhotoUrl"], $row["animalSpecies"]);
               $animals[$animals->key()] = $animal;
               $animals->next();
            } catch(\Exception $exception) {
               // if the row couldn't be converted, rethrow it
               throw(new \PDOException($exception->getMessage(), 0, $exception));
            }
         }
         return ($animals);
      }


      /**
       * inserts this animal into mySQL
       *
       * @param PDO $pdo PDO connection object
       * @throws PDOException when mySQL related errors occur
       * @throws TypeError if $pdo is not a PDO connection object
       **/
      public function insert(PDO $pdo): void {

         // create query template
         $query = "INSERT INTO animal(animalId, animalShelterId, animalAdoptionStatus, animalBreed, animalGender, animalName, animalPhotoUrl, animalSpecies) VALUES(:animalId, :animalShelterId, :animalAdoptionStatus, :animalBreed, :animalGender, :animalName, :animalPhotoUrl, :animalSpecies)";
         $statement = $pdo->prepare($query);

         $parameters = ["animalId" => $this->animalId->getBytes(), "animalShelterId" => $this->animalShelterId->getBytes(), "animalAdoptionStatus" => $this->animalAdoptionStatus, "animalBreed" => $this->animalBreed, "animalGender" => $this->animalGender, "animalName" => $this->animalName, "animalPhotoUrl" => $this->animalPhotoUrl, "animalSpecies" => $this->animalSpecies];
         $statement->execute($parameters);
      }

      /**
       * deletes this animal from mySQL
       *
       * @param \PDO $pdo PDO connection object
       * @throws \PDOException when mySQL related errors occur
       * @throws \TypeError if $pdo is not a PDO connection object
       **/
      public function delete(PDO $pdo): void {

         // create query template
         $query = "DELETE FROM animal WHERE animalId = :animalId";
         $statement = $pdo->prepare($query);

         // bind the member variables to the place holder in the template
         $parameters = ["animalId" => $this->animalId->getBytes()];
         $statement->execute($parameters);
      }

      /**
       * updates this animal in mySQL
       *
       * @param PDO $pdo PDO connection object
       * @throws PDOException when mySQL related errors occur
       * @throws TypeError if $pdo is not a PDO connection object
       **/
      public function update(PDO $pdo): void {

         // create query template
         $query = "UPDATE animal SET animalShelterId = :animalShelterId, animalAdoptionStatus = :animalAdoptionStatus, animalBreed = :animalBreed, animalGender = :animalGender, animalName = :animalName, animalPhotoUrl = :animalPhotoUrl, animalSpecies = :animalSpecies WHERE animalId = :animalId";
         $statement = $pdo->prepare($query);


         $parameters = ["animalId" => $this->animalId->getBytes(), "animalShelterId" => $this->animalShelterId->getBytes(), "animalAdoptionStatus" => $this->animalAdoptionStatus, "animalBreed" => $this->animalBreed, "animalGender" => $this->animalGender, "animalName" => $this->animalName, "animalPhotoUrl" => $this->animalPhotoUrl, "animalSpecies" => $this->animalSpecies];
         $statement->execute($parameters);
      }


      /**
       * formats the state variables for JSON serialization
       *
       * @return array resulting state variables to serialize
       **/
      public function jsonSerialize(): array {
         $fields = get_object_vars($this);

         $fields["animalId"] = $this->animalId->toString();
         return $fields;
      }
   }
