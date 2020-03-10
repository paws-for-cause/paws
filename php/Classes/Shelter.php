<?php

   namespace PawsForCause\Paws;
   require_once(dirname(__DIR__) . "/vendor/autoload.php");
   require_once("autoload.php");

   use Ramsey\Uuid\Uuid;
   use JsonSerializable;

   /**
    * Constructors, getters, setters, PDO for Shelter
    *
    * @author Usaama Alnaji <ualnaji@cnm.edu> with help from Dylan McDonald's code
    */
   class Shelter implements JsonSerializable{
       use ValidateUuid;
      /**
       * shelter id for for this website. This is a primary key
       * @var uuid $shelterId
       */
      private $shelterId;

      /**
       * shelter address for this website.
       * @var string $shelterAddress
       */
      private  $shelterAddress;

      /**
       * shelter name for this website
       * @var string $shelterName
       */
      private $shelterName;

      /**
       * shelter phone number for this website
       * @var string $shelterPhone
       */
      private $shelterPhone;


       /**
       * Constructor for Shelter
       *
       * @param uuid $newShelterId id for the animal that shelter
       * @param string $newShelterAddress shelter's address
       * @param string $newShelterName shelter's name
       * @param string $newShelterPhone shelter's phone number
        * @throws \InvalidArgumentException if data type is not valid
        * @throws \RangeException if values are out of bounds
        * @throws \Exception if some other exception occurs
        * @throws \TypeError if data type violates data hint
       */

      public function __construct($newShelterId, string $newShelterAddress, string $newShelterName, string $newShelterPhone) {
         try {
            $this->setShelterId($newShelterId);
            $this->setShelterAddress($newShelterAddress);
            $this->setShelterName($newShelterName);
            $this->setShelterPhone($newShelterPhone);
         } catch(\InvalidArgumentException | RangeException | Exception | TypeError $exception) {
            //determine what exception type was thrown
            $exceptionType = get_class($exception);
            throw(new $exceptionType($exception->getMessage(), 0, $exception));
         }
      }

      /**
       * accessor method for shelter id
       *
       * @return uuid value of the shelter id
       */

      public function getShelterId(): Uuid {
         return ($this->shelterId);
      }

      /**
       * mutator method for shelter id
       * @param $newshelterId new shelter id
       * @throws \InvalidArgument Exception if $newShelterId is not a string or insecure
       * @throws \RangeException if $newShelterId is longer than 16 characters
       * @throws \TypeException if $newShelterId is not a string
       */
       public function setShelterId($newShelterId): void {
           try {
               $uuid = self::validateUuid($newShelterId);
           } catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
               $exceptionType = get_class($exception);
               throw (new $exceptionType($exception->getMessage(), 0, $exception));
           }

           //convert and store author id
           $this->shelterId = $uuid;
       }

      /**
       * accessor method for shelter address
       *
       * @return string value of the shelter address
       */

      public function getShelterAddress(): string {
         return ($this->shelterAddress);
      }

      /**
       * mutator method for shelter address
       * @param $newshelterAddress new shelter address
       * @throws \InvalidArgument Exception if $newshelterAddress is not a string or insecure
       * @throws \RangeException if $newShelterAddress is longer than 16 characters
       * @throws \TypeException if $newShelterAddress is not a string
       */
      public function setShelterAddress($newShelterAddress): void {
         // verify the shelter address is secure
         $newShelterAddress = trim($newShelterAddress);
         $newShelterAddress = filter_var($newShelterAddress, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
         if(empty($newShelterAddress) === true) {
            throw(new \InvalidArgumentException ("shelter address is empty or insecure"));
         }
         // verify the new shelter address will fit in the database
         if(strlen($newShelterAddress) > 256) {
            throw(newRangeException ("shelter address is too long"));
         }
         //store the shelter address
         $this->shelterAddress = $newShelterAddress;
      }

      /**
       * accessor method for shelter name
       *
       * @return string value of the shelter name
       */

      public function getShelterName(): string {
         return ($this->shelterName);
      }

      /**
       * mutator method for shelter name
       * @param $newshelterName new  shelter name
       * @throws \InvalidArgumentException if $newshelterName is not a string or insecure
       * @throws \RangeException if $newShelterName is longer than 16 characters
       * @throws \TypeException if $newShelterName is not a string
       */
      public function setShelterName($newShelterName): void {
         // verify the shelter name is secure
         $newShelterName = trim($newShelterName);
         $newShelterName = filter_var($newShelterName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
         if(empty($newShelterName) === true) {
            throw(new \InvalidArgumentException ("shelter name is empty or insecure"));
         }
         // verify the new shelter name will fit in the database
         if(strlen($newShelterName) > 64) {
            throw(newRangeException ("shelter name is too long"));
         }
         //store the shelter name
         $this->shelterName = $newShelterName;
      }

      /**
       * accessor method for shelter phone
       *
       * @return string value of the shelter phone
       */

      public function getShelterPhone(): string {
         return ($this->shelterPhone);
      }

      /**
       * mutator method for shelter phone
       * @param $newshelterPhone new shelter phone
       * @throws \InvalidArgument Exception if $newshelterPhone is not a string or insecure
       * @throws \RangeException if $newShelterPhone is longer than 16 characters
       * @throws \TypeException if $newShelterPhone is not a string
       */
      public function setShelterPhone($newShelterPhone): void {
         // verify the shelter phone is secure
         $newShelterPhone = trim($newShelterPhone);
         $newShelterPhone = filter_var($newShelterPhone, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
         if(empty($newShelterPhone) === true) {
            throw(new \InvalidArgumentException ("shelter phone is empty or insecure"));
         }
         // verify the new shelter phone is exactly 16 characters
         if(strlen($newShelterPhone) > 16) {
            throw(newRangeException ("shelter phone must be less than or equal to 16 characters"));
         }
         //store the shelter phone
         $this->shelterPhone = $newShelterPhone;
      }


      /**
       * inserts this new Shelter into mySQL
       *
       * @param \PDO $pdo PDO connection object
       * @throws \PDOException when mySQL related errors occur
       * @throws \TypeError if $pdo is not a PDO connection object
       **/
      public function insert(\PDO $pdo): void {

         // create query template
         $query = "INSERT INTO shelter (shelterId, shelterAddress, shelterName, shelterPhone) VALUES(:shelterId, :shelterAddress, :shelterName, :shelterPhone)";
         $statement = $pdo->prepare($query);

         // bind the member variables to the place holders in the template
         $parameters = ["shelterId" => $this->shelterId->getBytes(), "shelterAddress" => $this->shelterAddress, "shelterName" => $this->shelterName, "shelterPhone" => $this->shelterPhone];
         $statement->execute($parameters);
      }


      /**
       * updates this Shelter in mySQL
       *
       * @param \PDO $pdo PDO connection object
       * @throws \PDOException when mySQL related errors occur
       * @throws \TypeError if $pdo is not a PDO connection object
       **/
      public function update(\PDO $pdo): void {

         // create query template
         $query = "UPDATE shelter SET shelterId = :shelterId, shelterAddress = :shelterAddress, shelterName = :shelterName, shelterPhone = :shelterPhone";

         $statement = $pdo->prepare($query);

         $parameters = ["shelterId" => $this->shelterId->getBytes(), "shelterAddress" => $this->shelterAddress, "shelterName" => $this->shelterName, "shelterPhone" => $this->shelterPhone];
         $statement->execute($parameters);

      }

      /**
       * deletes this Shelter from mySql
       * @param \PDO $pdo PDO connection object
       * @throws \PDOException when mySQL related errors occur
       * @throws \TypeEror if $pdo is not a PDO connection object
       */

      public function delete(\PDO $pdo): void {
         //create query template
         $query = "DELETE FROM shelter WHERE shelterId = :shelterId";
         $statement = $pdo->prepare($query);

         //bind the member variable to the place holder in the template
         $parameters = ["shelterId" => $this->shelterId->getBytes()];
         $statement->execute($parameters);

      }

      /**
       * get the Shelter by ShelterId
       *
       * @param \PDO $pdo PDO connection object
       * @param string $shelterId shelter Id used for the search
       * @return Shelter | null Shelter or null if not found
       * @throws \PDOException when mySQL related errors occur
       * @throws \InvalidArgumentException if shelterId is not a binary string or insecure
       * @throws \RangeException if shelterId is larger than 16 characters
       * @throws \Exception if any other error occurs
       * @throws \TypeError when a variable is not the correct data type
       */


      public static function getShelterByShelterId(\PDO $pdo, $shelterId): ?Shelter {
         // sanitize the shelter id before searching
         try {
            $shelterId = self::validateUuid($shelterId);
         } catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
            throw (new \PDOException($exception->getMessage(), 0, $exception));
         }

         //create query template
         $query = "SELECT shelterId, shelterAddress, shelterName, shelterPhone FROM shelter WHERE shelterId = :shelterId";
         $statement = $pdo->prepare($query);

         //bind the shelter id to the place holder in the template
         $parameters = ["shelterId" => $shelterId->getBytes()];
         $statement->execute($parameters);

         //grab the shelter from mySQL
         try {
            $shelter = null;
            $statement->setFetchMode(\PDO::FETCH_ASSOC);
            $row = $statement->fetch();
            if($row !== false) {
               $shelter = new Shelter($row["shelterId"], $row["shelterAddress"], $row["shelterName"], $row["shelterPhone"]);
            }

         } catch(Exception $exception) {
            // if the row could not be converted, rethrow it
            throw(new PDOException ($exception->getMessage(), 0, $exception));
         }
         return ($shelter);

      }
       /**
        * formats the state variables for JSON serialization
        *
        * @return array resulting state variables to serialize
        **/
       public
       function jsonSerialize() {
           $fields = get_object_vars($this);
           $fields["shelterId"] = $this->shelterId->toString();
           return ($fields);
       }
   }
