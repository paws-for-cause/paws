<?php
namespace PawsForCause\Paws\Tests;

use PHPUnit\Framework\TestCase;
use PHPUnit\DbUnit\TestCaseTrait;
use PHPUnit\DbUnit\DataSet\QueryDataSet;
use PHPUnit\DbUnit\Database\Connection;
use PHPUnit\DbUnit\Operation\{Composite, Factory, Operation};

// grab the encrypted properties file
require_once("/etc/apache2/ddl.sql/Secret.php");

require_once(dirname(__DIR__, 2) . "/vendor/autoload.php");

/**
 * Full PHPUnit test for the Animal class
 *
 * This is the Unit Test for the animal class for the Capstone Project
 *
 * @see Animal
 * @author Thomas Dameron <tdameron1@cnm.edu>
 */
class AnimalTest extends PawsTest {
	/**
	 * animalId that is in the database; this is for foreign key relations
	 * @var Animal animalId
	 */
	protected $animal = null;

	/**
	 * valid Animal Id for the animal
	 * @var $VALID_ANIMAL_ID
	 */
	protected $VALID_ANIMAL_ID;

	/**
	 * valid animal Shelter Id that is related to the animal
	 * @var $VALID_ANIMAL_SHELTER_ID;
	 **/
	protected $VALID_ANIMAL_SHELTER_ID;

	/**
	 * Animal Adoption Status, whether or not the animal has been adopted
	 * @var string $VALID_ANIMAL_ADOPTION_STATUS
	 **/
	protected $VALID_ANIMAL_ADOPTION_STATUS ="PHPUnit test passing";

	/**
	 * The breed of the animal
	 * @var string $ANIMAL_BREED
	 **/
	protected $VALID_ANIMAL_BREED = "PHPUnit test passing";

	/**
	 * The gender of the animal
	 * @var string $VALID_ANIMAL_GENDER
	 **/
	protected $VALID_ANIMAL_GENDER = "PHPUnit test passing";

	/**
	 * The name of the animal
	 * @var string $VALID_ANIMAL_NAME
	 **/
	protected $VALID_ANIMAL_NAME ="PHPUnit test passing";

	/**
	 * The Photo URL of the anima
	 * @var string $VALID_ANIMAL_PHOTO_URL;
	 **/
	protected $VALID_ANIMAL_PHOTO_URL = "PHPUnit test passing";

	/**
	 * The animal species
	 * @var string $VALID_ANIMAL_SPECIES;
	 **/
	protected $VALID_ANIMAL_SPECIES = "PHPUnit test passing";

	/**
	 * create dependant objects before running each test
	 **/
	public final function setUp() : void{
		// run the default setUp method first
		parent::setUp();

		// create and insert an animal to assign status's to.
		$this->animal = new Animal(generateUuidV4()), null, "PupperVille Animal Shelter", "Adopted", "Corgi", "Male", "Olaf", "https://media.giphy.com/media/3og0INyCmHlNylks9O/giphy.gif", "Dog";
		$this->animal->insert($this->getPDO());
	}
}