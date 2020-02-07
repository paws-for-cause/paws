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

		// convert and store the author id
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
	public function setAnimalShelter($newAnimalShelterId): void {
		try {
			$uuid = self::validateUuid($newAnimalShelterId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}

		// convert and store the author id
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
	public
	function setAnimalSpecies(string $newAnimalSpecies): void {
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
}

//**getFooByBar methods below**//

/**
 * TEMPLATE FOR SPLFIXED ARRAY OF ALL ANIMALS BELOW
 * a method that returns an SplFixedArray of all animals
 *
 * @param \PDO $pdo
 * @param string $authorUsername
 * @return authorSplFixedArray
 */
public static function getAuthorByAuthorUsername(\PDO $pdo, string $authorUsername): \SPLFixedarray {

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
	//bind the authorUsername to the place holder in the template
	$authorUsername = "%authorUsername%";
	$parameters = ["authorUsername" => $authorUsername];
	$statement->execute($parameters);

	// building an array of Authors
	$authorArray = SplFixedArray($statement->rowCount());
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
	?>