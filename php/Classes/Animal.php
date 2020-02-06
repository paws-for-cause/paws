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
	 * the status of whether or not the animal has been adopted yet
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

	public function __construct($newAuthorId, $newAuthorActivationToken, $newAuthorAvatarUrl, $newAuthorEmail, string $newAuthorHash, $newAuthorUsername) {
		try {
			$this->setAuthorId($newAuthorId);
			$this->setAuthorActivationToken($newAuthorActivationToken);
			$this->setAuthorAvatarUrl($newAuthorAvatarUrl);
			$this->setAuthorEmail($newAuthorEmail);
			$this->setAuthorHash($newAuthorHash);
			$this->setAuthorUsername($newAuthorUsername);
		} catch(\InvalidArgumentException | \RangeException | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType ($exception->getMessage(), 0, $exception));
		}
	}

	//** ----->>>>>ADD MUTATORS FOR ABOVE, CHECK LINE 75, getclass<<<<<-----*/

	/**
	 * accessor method for author id
	 *
	 * @return Uuid value of author id
	 **/
	public function getAuthorId(): Uuid {
		return ($this->authorId);
	}

	public function getAuthorActivationToken(): ?string {
		return ($this->authorActivationToken);
	}

	public function getAuthorAvatarURL($authorAvatarUrl) {
		$this->authorAvatarUrl;
	}

	public function getAuthorEmail($authorEmail) {
		$this->authorEmail;
	}

	public function getAuthorHash($authorHash) {
		$this->authorHash;
	}

	//** MUTATORS BELOW  **//

	/**
	 * mutator method for email
	 *
	 * @param string $newAuthorEmail new value of email
	 * @throws \InvalidArgumentException if $newEmail is not a valid email or insecure
	 * @throws \RangeException if $newEmail is > 128 characters
	 * @throws \TypeError if $newEmail is not a string
	 **/
	public function setAuthorEmail(string $newAuthorEmail): void {
		// verify the email is secure
		$newAuthorEmail = trim($newAuthorEmail);
		$newAuthorEmail = filter_var($newAuthorEmail, FILTER_VALIDATE_EMAIL);
		if(empty($newAuthorEmail) === true) {
			throw(new \InvalidArgumentException("author email is empty or insecure"));
		}
		// verify the email will fit in the database
		if(strlen($newAuthorEmail) > 128) {
			throw(new \RangeException("author email is too large"));
		}
		// store the email
		$this->authorEmail = $newAuthorEmail;
	}

	/**
	 * mutator method for author hash password
	 *
	 * @param string $newAuthorHash
	 * @throws \InvalidArgumentException if the hash is not secure
	 * @throws \RangeException if the hash is not 128 characters
	 * @throws \TypeError if author hash is not a string
	 */
	public function setAuthorHash(string $newAuthorHash): void {
		//enforce that the hash is properly formatted
		$newAuthorHash = trim($newAuthorHash);
		if(empty($newAuthorHash) === true) {
			throw(new \InvalidArgumentException("author password hash empty or insecure"));
		}
		//enforce the hash is really an Argon hash
		$authorHashInfo = password_get_info($newAuthorHash);
		if($authorHashInfo["algoName"] !== "argon2i") {
			throw(new \InvalidArgumentException("author hash is not a valid hash"));
		}
		//enforce that the hash is exactly 97 characters.
		if(strlen($newAuthorHash) !== 97) {
			throw(new \RangeException("author hash must be 97 characters"));
		}
		//store the hash
		$this->authorHash = $newAuthorHash;
	}


	/**
	 * mutator method for at handle
	 *
	 * @param string $newAuthorAvatarUrl new value of at handle
	 * @throws \InvalidArgumentException if $newAtHandle is not a string or insecure
	 * @throws \RangeException if $newAtHandle is > 32 characters
	 * @throws \TypeError if $newAtHandle is not a string
	 **/
	public function setAuthorAvatarUrl(string $newAuthorAvatarUrl): void {
		// verify the at handle is secure
		$newAuthorAvatarUrl = trim($newAuthorAvatarUrl);
		$newAuthorAvatarUrl = filter_var($newAuthorAvatarUrl, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newAuthorAvatarUrl) === true) {
			throw(new \InvalidArgumentException("Avatar url is empty or insecure"));
		}
		// verify the at handle will fit in the database
		if(strlen($newAuthorAvatarUrl) > 32) {
			throw(new \RangeException("Avatar url is too large"));
		}
		// store the at handle
		$this->authorAvatarUrl = $newAuthorAvatarUrl;
	}

	/**
	 * mutator method for at handle
	 *
	 * @param string $newAuthorUsername new value of at handle
	 * @throws \InvalidArgumentException if $newAtHandle is not a string or insecure
	 * @throws \RangeException if $newAtHandle is > 32 characters
	 * @throws \TypeError if $newAtHandle is not a string
	 **/
	public
	function setAuthorUsername(string $newAuthorUsername): void {
		// verify the at handle is secure
		$newAuthorUsername = trim($newAuthorUsername);
		$newAuthorUsername = filter_var($newAuthorUsername, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newAuthorUsername) === true) {
			throw(new \InvalidArgumentException("author at handle is empty or insecure"));
		}
		// verify the at handle will fit in the database
		if(strlen($newAuthorUsername) > 32) {
			throw(new \RangeException("author at handle is too large"));
		}
		// store the at handle
		$this->authorUsername = $newAuthorUsername;
	}

	/**
	 * @param string $newAuthorId
	 * @throws \InvalidArgumentException if the data types are not InvalidArgumentException
	 * @throws \RangeException if the data values are out of bounds (i.e. too long or negative)
	 * @throws \TypeError if data types violate type hints
	 **/
	public function setAuthorId($newAuthorId): void {
		try {
			$uuid = self::validateUuid($newAuthorId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}

		// convert and store the author id
		$this->authorId = $uuid;
	}

	/**
	 * @param string|null $newAuthorActivationToken
	 * *@throws \InvalidArgumentException if the token is not a string or is not secure
	 * @throws \RangeException if the token is not exactly 32 characters
	 * @throws \TypeError if the activation token is not a string
	 */
	public function setAuthorActivationToken(?string $newAuthorActivationToken): void {
		if($newAuthorActivationToken === null) {
			$this->authorActivationToken === null;
			return;
		}
		$newAuthorActivationToken = strtolower(trim($newAuthorActivationToken));
		if(ctype_xdigit($newAuthorActivationToken) === false) {
			throw(new\RangeException("user activation is not valid"));
		}
		//make sure user activation token is only 32 characters
		if(strlen($newAuthorActivationToken) !== 32) {
			throw(new\RangeException("user activation token has to be 32"));
		}
		$this->authorActivationToken = $newAuthorActivationToken;
	}

	/** EDIT THE BELOW CODE SO THAT IT WILL COMPLY WITH STATE VARIABLES */
	/**
	 * formats the state variables for JSON serialization
	 *
	 * @return array resulting state variables to serialize
	 **/
	public function jsonSerialize(): array {
		$fields = get_object_vars($this);

		$fields["authorId"] = $this->authorId->toString();
		$fields["authorActivationToken"] = $this->authorActivationToken->toString();
	}

	/**
	 * inserts this author into mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function insert(\PDO $pdo): void {

		// create query template
		$query = "INSERT INTO author(authorId,authorActivationToken, authorAvatarUrl, authorEmail, authorHash, authorUsername) VALUES(:tweetId, :AuthorId, :authorAvatarUrl)";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holders in the template
		$parameters = ["authorId" => $this->authorId->getBytes(), "authorActivationToken" => $this->authorActivationToken->getBytes(), "authorAvatarUrl" => $this->authorAvatarUrl];
		$statement->execute($parameters);
	}
	//**Object Oriented Phase II methods below. **//

	/**
	 * deletes this author from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function delete(\PDO $pdo): void {

		// create query template
		$query = "DELETE FROM author WHERE authorId = :authorId";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holder in the template
		$parameters = ["authorId" => $this->authorId->getBytes()];
		$statement->execute($parameters);
	}

	/**
	 * updates this Author in mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function update(\PDO $pdo): void {

		// create query template
		$query = "UPDATE author SET authorId = :authorId, authorAvatarUrl = :authorAvatarUrl WHERE authorId = :authorId";
		$statement = $pdo->prepare($query);


		$parameters = ["authorId" => $this->authorId->getBytes(), "authorActivationToken" => $this->authorActivationToken->getBytes(), "authorAvatarUrl" => $this->authorAvatarUrl];
		$statement->execute($parameters);
	}

	/**
	 * a method that returns an array of Authors
	 *
	 * @param \PDO $pdo
	 * @param string $authorUsername
	 * @return \SPLFixedArray
	 */
	public static function getAuthorByAuthorUsername(\PDO $pdo, string $authorUsername): \SPLFixedArray {

		//sanitize the description before searching
		//** trims the author username to a set number of characters for security */
		$authorUsername = trim($authorUsername);
		//**filter_var filters a variable, the format is: filter_var($authorUsername <-variable goes here, FILTER_SANITIZE_STRING <- filters go here seperated by commas)
		//**FILTER_SANITZE_STRING will strip tags, FILTER_FLAG_NO_ENCODE_QUOTES will strip invalid characters. **//
		$authorUsername = filter_var($authorUsername, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);


		// escape any mySQL wild cards
		//** str_replace("%","\\%", $authorUsername) will replace the command "%" with the string character "%", this will prevent security breaches.*/
		$result = str_replace("%", "\\%", $authorUsername);
		$authorUsername = str_replace("_", "\\", $result);

		// create query template
		$query = "SELECT authorId, authorActivationToken, authorAvatarUrl, authorEmail, authorHash, authorUsername FROM Author LIKE :authorUsername";
		$statement = $pdo->prepare($query);
		x
		//bind the authorUsername to the place holder in the template
		$authorUsername = "%authorUsername%";
		$parameters = ["authorUsername" => $authorUsername];
		$statement->execute($parameters);

		// building an array of Authors
		$authorArray = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$author = new Author($row["authorId"], $row["authorActivationToken"], $row["authorAvatarUrl"], $row["authorEmail"], $row["authorHash"], $row["authorUsername"]);
				$authorArray[$authorArray->key()] = $author;
				$authorArray->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($authorArray);
	}
}


?>