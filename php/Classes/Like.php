<?php

   namespace PawsForCause\Paws;
   require_once(dirname(__DIR__) . "/vendor/autoload.php");
   require_once("autoload.php");

   use Ramsey\Uuid\Uuid;

   /**
    * Constructors, getters, setters, PDO for Like
    *
    * @author Usaama Alnaji <ualnaji@cnm.edu> with help from Dylan McDonald's code
    */
   class Like {
      use ValidateUuid;
      /**
       * Like animal ID for this website. This is a foreign key.
       * @var uuid $likeAnimalId
       */

      private $likeAnimalId;

      /**
       * Like User ID for this website. This is a foreign key.
       * @var uuid $likeUserId
       */

      private $likeUserId;

      /**
       * Like Approved for this website.
       * @var int $likeApproved
       */

      private $likeApproved;


      /**
       * Constructor for Like
       *
       * @param string $newLikeAnimalId id for the animal that can been liked
       * @param string $newLikeUserId id for the user who is viewing the animals
       * @param int $newLikeApproved int for if the like is a "yes"
       */

      public function __construct($newLikeAnimalId, $newLikeUserId, int $newLikeApproved) {
         try {
            $this->setLikeAnimalId($newLikeAnimalId);
            $this->setLikeUserId($newLikeUserId);
            $this->setLikeApproved($newLikeApproved);
         } catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
            //determine what exception type was thrown
            $exceptionType = get_class($exception);
            throw(new $exceptionType($exception->getMessage(), 0, $exception));
         }
      }

      /**
       * accessor method for like animal id
       *
       * @return uuid value of the like animal id
       */

      public function getLikeAnimalId(): Uuid {
         return ($this->likeAnimalId);
      }

      /**
       * mutator method for like animal id
       * @param $newLikeAnimalId new like animal id
       * @throws \InvalidArgumentException Exception if $newLikeAnimalId is not a string or insecure
       * @throws \RangeException if $newLikeAnimalId is loner than 32 characters
       * @throws \TypeException if $newLikeAnimalId is not a string
       */
      public function setLikeAnimalId($newLikeAnimalId): void {
         try {
            $uuid = self::validateUuid($newLikeAnimalId);
         } catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
            $exceptionType = get_class($exception);
            throw(new $exceptionType($exception->getMessage(), 0, $exception));
         }
         //convert and store the animal id
         $this->likeAnimalId = $uuid;
      }

      /**
       * accessor method for like user id
       *
       * @return uuid value of the like user id
       */

      public function getLikeUserId(): Uuid {
         return ($this->likeUserId);
      }

      /**
       * mutator method for like user id
       * @param $newLikeUserId new like user id
       * @throws \InvalidArgument Exception if $new likeUserId is not a string or insecure
       * @throws \RangeException if $newLikeUserId is loner than 32 characters
       * @throws \TypeException if $newLikeUserId is not a string
       */
      public function setLikeUserId($newLikeUserId): void {
         try {
            $uuid = self::validateUuid($newLikeUserId);
         } catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
            $exceptionType = get_class($exception);
            throw(new $exceptionType($exception->getMessage(), 0, $exception));
         }
         //convert and store the like user id
         $this->likeUserId = $uuid;

      }

      /**
       * accessor method for like approved
       *
       * @return int value of the like approved
       */

      public function getLikeApproved(): int {
         return ($this->likeApproved);
      }

      /**
       * mutator method for like approved
       *
       * @param string $newLikeApproved
       * @throws \RangeException if $newLikeApproved is not within range
       **/


      function setLikeApproved(int $newLikeApproved) {
         // verify the like input is valid
         if(($newLikeApproved > 1) || ($newLikeApproved < 0))

            throw(new \RangeException("animal like value is invalid"));

         // store the approved like
         $this->likeApproved = $newLikeApproved;
      }


      /**
       * inserts this new Like into mySQL
       *
       * @param \PDO $pdo PDO connection object
       * @throws \PDOException when mySQL related errors occur
       * @throws \TypeError if $pdo is not a PDO connection object
       **/
      public function insert(\PDO $pdo): void {

         // create query template
         $query = "INSERT INTO `like` (likeAnimalId, likeUserId, likeApproved) VALUES(:likeAnimalId, :likeUserId, :likeApproved)";
         $statement = $pdo->prepare($query);

         // bind the member variables to the place holders in the template
         $parameters = ["likeAnimalId" => $this->likeAnimalId->getBytes(), "likeUserId" => $this->likeUserId->getBytes(), "likeApproved" => $this->likeApproved];
         $statement->execute($parameters);
      }

      /**
       * deletes this Like from mySql
       * @param \PDO $pdo PDO connection object
       * @throws \PDOException when mySQL related errors occur
       * @throws \TypeError if $pdo is not a PDO connection object
       */

      public function delete(\PDO $pdo): void {
         //create query template
         $query = "DELETE FROM `like` WHERE likeAnimalId = :likeAnimalId AND likeUserId = :likeUserId";
         $statement = $pdo->prepare($query);

         //bind the member variable to the place holder in the template
         $parameters = ["likeAnimalId" => $this->likeAnimalId->getBytes(), "likeUserId" => $this->likeUserId->getBytes()];
         $statement->execute($parameters);

      }

      /**
       * get like by like animal id and by like user id (which animals have been liked by which users?)
       *
       * @param \PDO $pdo PDO connection object
       * @param string $likeAnimalId
       * @param string $likeUserId
       * @return Like|null Like or null if not found
       * @throws \PDOException when mySQL related errors occur
       * @throws \TypeError when a variable is not the correct data type
       */

      public static function getLikeByLikeAnimalIdAndByLikeUserId(\PDO $pdo, string $likeAnimalId, string $likeUserId): ?Like {

         //
         try {
            $likeAnimalId = self::validateUuid($likeAnimalId);
         } catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
            throw(new \PDOException($exception->getMessage(), 0, $exception));
         }

         try {
            $likeUserId = self::validateUuid($likeUserId);
         } catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
            throw(new \PDOException($exception->getMessage(), 0, $exception));
         }

         // create query template
         $query = "SELECT likeAnimalId, likeUserId, likeApproved FROM `like` WHERE likeAnimalId = :likeAnimalId AND likeUserId = :likeUserId";
         $statement = $pdo->prepare($query);

         //bind the animal id and user id to the place holder in the template
         $parameters = ["likeAnimalId" => $likeAnimalId->getBytes(), "likeUserId" => $likeUserId->getBytes()];
         $statement->execute($parameters);

         //grab the link from mySQL
         try {
            $like = null;
            $statement->setFetchMode(\PDO::FETCH_ASSOC);
            $row = $statement->fetch();
            if($row !== false) {
               $like = new Like($row["likeAnimalId"], $row["likeUserId"], $row["likeApproved"]);
            }
         } catch(\Exception $exception) {
            // if the row couldn't be converted, rethrow it
            throw(new \PDOException($exception->getMessage(), 0, $exception));
         }
         return ($like);


      }

   }