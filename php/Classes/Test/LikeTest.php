<?php
   namespace PawsForCause\Paws\Test;

   use PawsForCause\Paws\ {User, Shelter, Animal,  Like};

// grab the class under scrutiny
   require_once(dirname(__DIR__) . "/autoload.php");

// grab the uuid generator
   require_once(dirname(__DIR__, 2) . "/lib/uuid.php");

   /**
    * Full PHPUnit test for the Like class
    *
    * This is a complete PHPUnit test of the Like class. It is complete because *ALL* mySQL/PDO enabled methods
    * are tested for both invalid and valid inputs.
    *
    * @see Like
    * @author Usaama Alnaji <ualnaji@cnm.edu> with code referenced from Dylan McDonald <dmcdonald21@cnm.edu>
    **/
   class LikeTest extends PawsTest {


      /**
       * animal that was liked; this is for foreign key relations
       * @var uuid $animal
       **/
      protected $animal;

      /**
       * user that created the like; this is for foreign key relations
       * @var uuid $user
       **/
      protected $user;


      /**
       * boolean to determine if an animal was liked by a user or not
       * @var int $VALID_LIKE_APPROVED
       */
      protected $VALID_LIKE_APPROVED = 1;


      protected $VALID_HASH;

      protected $VALID_ACTIVATION;

      /**
       * create dependent objects before running each test
       **/

      public final function setUp(): void {
         // run the default setUp() method first
         parent::setUp();

         // create a salt and hash for the mocked user
         $password = "abc123";
         $this->VALID_HASH = password_hash($password, PASSWORD_ARGON2I, ["time_cost" => 7]);
         $this->VALID_ACTIVATION = bin2hex(random_bytes(16));

         // create and insert the mocked user
         $this->user = new User (generateUuidV4(), "c7fb39c60e144d2887c3e3b7e31f1330", "20", "aldfkjd@gmail.com", "jalwdjfaldjflajf",'$argon2i$v=19$m=1024,t=384,p=2$dE55dm5kRm9DTEYxNFlFUA$nNEMItrDUtwnDhZ41nwVm7ncBLrJzjh5mGIjj8RlzVA', "Cool Potatos", "12125551212");
         $this->user->insert($this->getPDO());

         // create and inser the mock shelter
         $this->shelter = new Shelter(generateUuidV4(), "10000 street st." , "asdlfjlas", "9595555555");
         $this->shelter->insert($this->getPDO());

         // create and insert the mocked animal
         $this->animal = new Animal(generateUuidV4(), $this->shelter->getShelterId(), "nope", "Lab", "0", "Bobo", "https://dogphoto.com/dogphoto", "chupacabra");
         $this->animal->insert($this->getPDO());

      }

      /**
       * test inserting a valid Like and verify that the actual mySQL data matches
       **/
      public function testInsertValidLike(): void {
         // count the number of rows and save it for later
         $numRows = $this->getConnection()->getRowCount("like");

         // create a new Like and insert to into mySQL
         $like = new Like($this->animal->getAnimalId(), $this->user->getUserId(), 1);
         $like->insert($this->getPDO());

         // grab the data from mySQL and enforce the fields match our expectations
         $pdoLike = Like::getLikeByLikeAnimalIdAndByLikeUserId($this->getPDO(), $this->animal->getAnimalId(), $this->user->getUserId());
         $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("like"));
         $this->assertEquals($pdoLike->getLikeAnimalId(), $this->animal->getAnimalId());
         $this->assertEquals($pdoLike->getLikeUserId(), $this->user->getUserId());
         $this->assertEquals($pdoLike->getLikeApproved(),$like->getLikeApproved());
      }

      /**
       * test creating a Like and then deleting it
       **/
      public function testDeleteValidLike(): void {
         // count the number of rows and save it for later
         $numRows = $this->getConnection()->getRowCount("like");

         // create a new Like and insert to into mySQL
         $like = new Like($this->animal->getAnimalId(), $this->user->getUserId(), 1);
         $like->insert($this->getPDO());

         // delete the Like from mySQL
         $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("like"));
         $like->delete($this->getPDO());

         // grab the data from mySQL and enforce the Like does not exist
         $pdoLike = Like::getLikeByLikeAnimalIdAndByLikeUserId($this->getPDO(), $this->animal->getAnimalId(), $this->user->getUserId());
         $this->assertNull($pdoLike);
         $this->assertEquals($numRows, $this->getConnection()->getRowCount("like"));
      }

      /**
       * test inserting a Like and regrabbing it from mySQL
       **/
      public function testGetLikeByLikeAnimalIdAndByLikeUserId(): void {
         // count the number of rows and save it for later
         $numRows = $this->getConnection()->getRowCount("like");

         // create a new Like and insert to into mySQL
         $like = new Like($this->animal->getAnimalId(), $this->user->getUserId(), 1);
         $like->insert($this->getPDO());

         // grab the data from mySQL and enforce the fields match our expectations
         $pdoLike = Like::getLikeByLikeAnimalIdAndByLikeUserId($this->getPDO(), $this->animal->getAnimalId(), $this->user->getUserId());
         $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("like"));
         $this->assertEquals($pdoLike->getLikeAnimalId(), $this->animal->getAnimalId());
         $this->assertEquals($pdoLike->getLikeUserId(), $this->user->getUserId());
         $this->assertEquals($pdoLike->getLikeApproved(),$like->getLikeApproved());
      }
      
      /**
       * Test grabbing animal by Shelter Id
       **/
      public function testGetValidAnimalByLikeUserId(): void {
         // count the number of rows and save it for later
         $numRows = $this->getConnection()->getRowCount("animal");

         // create a new animal and insert to mySQL
         $animalId = generateUuidV4();
         $animal = new Animal($animalId->getBytes(), $this->shelter->getShelterId(), "nope", "Lab", "0", "Bobo", "https://dogphoto.com/dogphoto", "chupacabra");
         $animal->insert($this->getPDO());

         //create a like object(use the getUserId accessor and getAnimalId accessor for the foreign keys) and insert it into the database
         $user = new User(generateUuidV4(), $this->VALID_ACTIVATION, "24", "email@email.com", "alsdfj", $this->VALID_HASH, "asdhflaks", "5052224848");

         $like = new Like($animalId->getBytes(), $this->user->getUserId(), 0);
         $like->insert($this->getPDO());


         // grab the data from mySQL and enforce the fields match our expectations
         // use the getuserId accessor to pass the userId into getAnimalByLikeUserId
         $results = Animal::getAnimalByLikeUserId($this->getPDO(), $this->user->getUserId());
         $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("animal"));
         $this->assertCount(1, $results);
        // $this->assertContainsOnlyInstancesOf("PawsForCause\Paws\Animal", $results);

         // grab the result from the array and validate it
         $pdoAnimal = $results[0];
        // var_dump($pdoAnimal);
         $this->assertEquals($pdoAnimal->animalId, $animalId->getBytes());
         $this->assertEquals($pdoAnimal->animalShelterId, $this->shelter->getShelterId()->getBytes());
         $this->assertEquals($pdoAnimal->animalAdoptionStatus, $this->animal->getAnimalAdoptionStatus());
         $this->assertEquals($pdoAnimal->animalBreed, $this->animal->getAnimalBreed());
         $this->assertEquals($pdoAnimal->animalGender, $this->animal->getAnimalGender());
         $this->assertEquals($pdoAnimal->animalName, $this->animal->getAnimalName());
         $this->assertEquals($pdoAnimal->animalPhotoUrl, $this->animal->getAnimalPhotoUrl());
         $this->assertEquals($pdoAnimal->animalSpecies, $this->animal->getAnimalSpecies());
      }
   }

