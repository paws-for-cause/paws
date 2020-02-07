<?php
namespace PawsForCause\Paws;
require_once(dirname(__DIR__). "/vendor/autoload.php");
require_once("autoload.php");
use Ramsey\Uuid\Uuid;


/**
 * Constructors, getters, setters, PDO for Like
 *
 * @author Usaama Alnaji <ualnaji@cnm.edu> with help from Dylan McDonald's code
 */

class Like
{
    /**
     * Like animal ID for this website. This is a foreign key.
     * @var string $likeAnimalId
     */

    private $likeAnimalId;

    /**
     * Like User ID for this website. This is a foreign key.
     * @var string $likeUserId
     */

    private $likeUserId;

    /**
     * Like Approved for this website.
     * @var boolean $likeApproved
     */

    private $likeApproved;


    /**
     * Constructor for Like
     *
     * @param string $newlikeAnimalId id for the animal that can been liked
     * @param string $newLikeUserId id for the user who is viewing the animals
     * @param boolean $newLikeApproved boolean for if the like is a "yes"
     */

    public function __construct(string $newLikeAnimalId, string $newLikeUserId, boolean $newLikeApproved)
    {
        try {
            $this->setLikeAnimalId($newLikeAnimalId);
            $this->setLikeUserId($newLikeUserId);
            $this->setLikeApproved($newLikeApproved);
        } catch (\InvalidArgumentException | \RangeException | \Exception | \TypeEror $exception) {
            //determine what exception type was thrown
            $exceptionType = get_class($exception);
            throw(new $exceptionType($exception->getMessage(), 0, $exception));
        }
    }

    /**
     * accessor method for like animal id
     *
     * @return string value of the like animal id
     */

    public function getLikeAnimalId(): string
    {
        return ($this->likeAnimalId);
    }

    /**
     * mutator method for like animal id
     * @param $newLikeAnimalId new like animal id
     * @throws \InvalidArgument Exception if $newLikeAnimalId is not a string or insecure
     * @throws \RangeException if $newLikeAnimalId is loner than 32 characters
     * @throws \TypeException if $newLikeAnimalId is not a string
     */
    public function setLikeAnimalId($newLikeAnimalId): void
    {
        // verify the like animal id is secure
        $newLikeAnimalId = trim($newLikeAnimalId);
        $newLikeAnimalId = filter_var($newLikeAnimalId, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
        if (empty($newLikeAnimalId) === true) {
            throw(new \InvalidArgumentException ("like animal Id is empty or insecure"));
        }
        // verify the new username will fit in the database
        if (strlen($newLikeAnimalId) > 32) {
            throw(new\RangeException ("like animal id is too long"));
        }
        //store the like animal id
        $this->likeAnimalId = $newLikeAnimalId;
    }

    /**
     * accessor method for like user id
     *
     * @return string value of the like user id
     */

    public function getLikeUserId(): string
    {
        return ($this->likeUserId);
    }

    /**
     * mutator method for like user id
     * @param $newLikeUserId new like user id
     * @throws \InvalidArgument Exception if $new likeUserId is not a string or insecure
     * @throws \RangeException if $newLikeUserId is loner than 32 characters
     * @throws \TypeException if $newLikeUserId is not a string
     */
    public function setLikeUserId ($newLikeUserId): void
    {
        // verify the like user id is secure
        $newLikeUserId = trim($newLikeUserId);
        $newLikeUserId = filter_var($newLikeUserId, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
        if (empty($newLikeUserId) === true) {
            throw(new \InvalidArgumentException ("like user Id is empty or insecure"));
        }
        // verify the new username will fit in the database
        if (strlen($newLikeUserId) > 32) {
            throw(new\RangeException ("like user id is too long"));
        }
        //store the like user id
        $this->likeUserId = $newLikeUserId;
    }

    /**
     * accessor method for like approved
     *
     * @return boolean value of the like approved
     */

    public function getLikeApproved(): string
    {
        return ($this->likeApproved);
    }

    /**
     * mutator method for like user id
     * @param $newLikeApproved new like approved
     * @throws \InvalidArgument Exception if $newLikeApproved is not a boolean or insecure
     * @throws \TypeException if $newLikeUserId is not a boolean
     */
    public function setLikeApproved ($newLikeApproved): void
    {
        // verify the like user id is secure
        $newLikeApproved = trim($newLikeApproved);
        $newLikeApproved = filter_var($newLikeApproved, FILTER_SANITIZE, FILTER_FLAG_NO_ENCODE_QUOTES);
        if (empty($newLikeApproved) === true) {
            throw(new \InvalidArgumentException ("like approved is empty or insecure"));
        }
        // verify the new like approved will fit in the database
        if (strlen($newLikeApproved) > 32) {
            throw(new\RangeException ("like approved id is too long"));
        }
        //store the like user id
        $this->likeApproved = $newLikeApproved;
    }


    /**
     * inserts this new Like into mySQL
     *
     * @param \PDO $pdo PDO connection object
     * @throws \PDOException when mySQL related errors occur
     * @throws \TypeError if $pdo is not a PDO connection object
     **/
    public function insert(\PDO $pdo): void
    {

        // create query template
        $query = "INSERT INTO LIKE (likeAnimalId, likeUserId, likeApproved) VALUES(:likeAnimalId, :likeUserId, :likeApproved)";
        $statement = $pdo->prepare($query);

        // bind the member variables to the place holders in the template
        $parameters = ["likeAnimalId" => $this->likeAnimalId, "likeUserId" => $this->likesuerId, "likeApproved" => $this->likeApproved];
        $statement->execute($parameters);
    }



    /**
     * updates this Like in mySQL
     *
     * @param \PDO $pdo PDO connection object
     * @throws \PDOException when mySQL related errors occur
     * @throws \TypeError if $pdo is not a PDO connection object
     **/
    public function update(\PDO $pdo): void {

        // create query template
        $query = "UPDATE Like SET likeAnimalId = :likeAnimalId, likeUserId = :likeUserId, likeApproved = :likeApproved WHERE likeAnimalId = :likeAnimalId ";

        $statement = $pdo->prepare($query);

        $parameters = ["likeAnimalId" => $this->likeAnimalId, "likeUserId" => $this->likeUserId, "likeApproved" => $this->likeApproved];
        $statement->execute($parameters);

    }

    /**
     * deletes this Like from mySql
     * @param \PDO $pdo PDO connection object
     * @throws \PDOException when mySQL related errors occur
     * @throws \TypeEror if $pdo is not a PDO connection object
     */

    public function delete(\PDO $pdo): void {
        //create query template
        $query = "DELETE FROM Like WHERE likeAnimalId = :likeAnimalId";
        $statement = $pdo->prepare($query);

        //bind the member variable to the place holder in the template
        $parameters = ["likeAnimalId" =>$this -> likeAnimalId()];
        $statement->execute($parameters);

    }
}

/**
 * I still kind of don't understand the header section "require once, autoload"
 * Tinyint? Smallint Signed?
 * Like Approved boolean?
 * Not sure about constructor descriptions
 * What do each of these methods do?
 * Do we need the exceptions for likeanimalId since that would be a private function most likely?
 * Type exception works for boolean?
 * length of these variables?
 * like approved probably doesn't need length exception?