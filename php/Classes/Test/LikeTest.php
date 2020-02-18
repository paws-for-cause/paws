<?php

   namespace PawsForCause\Paws\Test;

   use PawsForCause\Paws\ {User, Animal, Like};

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
       * @var  string $animal
       **/
      protected $animal;

      /**
       * user that created the like; this is for foreign key relations
       * @var string $user
       **/
      protected $user;


      /**
       * boolean to determine if an animal was liked by a user or not
       * @var string $VALID_LIKE_APPROVED
       */
      protected $VALID_LIKE_APPROVED;


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
         $this->user = new User (generateUuidV4(), null, "20", "she was a girl", "test@phpunit.de","Mr.Cool", $this->VALID_HASH, "Cool Potatos", "+12125551212");
         $this->user->insert($this->getPDO());

         // create and insert the mocked animal
         $this->animal = new Animal(generateUuidV4(), $this->user->getUserId(), "1");
         $this->animal->insert($this->getPDO());

      }

      /**
       * test inserting a valid Like and verify that the actual mySQL data matches
       **/
      public function testInsertValidLike(): void {
         // count the number of rows and save it for later
         $numRows = $this->getConnection()->getRowCount("like");

         // create a new Like and insert to into mySQL
         $like = new Like($this->user->getUserId(), $this->aniaml->getAnimalId());
         $like->insert($this->getPDO());

         // grab the data from mySQL and enforce the fields match our expectations
         $pdoLike = Like::getLikeByLikeAnimalIdAndByLikeUserId($this->getPDO(), $this->user->getUserId(), $this->animal->getAnimalId());
         $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("like"));
         $this->assertEquals($pdoLike->getLikeUserId(), $this->user->getUserId());
         $this->assertEquals($pdoLike->getLikeAnimalId(), $this->animal->getAnimalId());
      }

      /**
       * test creating a Like and then deleting it
       **/
      public function testDeleteValidLike(): void {
         // count the number of rows and save it for later
         $numRows = $this->getConnection()->getRowCount("like");

         // create a new Like and insert to into mySQL
         $like = new Like($this->user->getUserId(), $this->animal->getAnimalId(), $this->VALID_LIKE_APPROVED);
         $like->insert($this->getPDO());

         // delete the Like from mySQL
         $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("like"));
         $like->delete($this->getPDO());

         // grab the data from mySQL and enforce the Like does not exist
         $pdoLike = Like::getLikeByLikeAnimalIdAndByLikeUserId($this->getPDO(), $this->user->getUserId(), $this->animal->getAnimalId());
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
         $like = new Like($this->user->getUserId(), $this->animal->getAnimalId(), $this->VALID_LIKE_APPROVED);
         $like->insert($this->getPDO());

         // grab the data from mySQL and enforce the fields match our expectations
         $pdoLike = Like::getLikeByLikeAnimalIdAndByLikeUserId($this->getPDO(), $this->user->getUserId(), $this->animal->getAnimalId());
         $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("like"));
         $this->assertEquals($pdoLike->getLikeUserId(), $this->user->getUserId());
         $this->assertEquals($pdoLike->getLikeAnimalId(), $this->animal->getAnimalId());

      }

      /**
       * test grabbing a Like by animal id
       **/
      public function testGetValidLikeByAnimalId(): void {
         // count the number of rows and save it for later
         $numRows = $this->getConnection()->getRowCount("like");

         // create a new Like and insert to into mySQL
         $like = new Like($this->user->getUserId(), $this->animal->getAnimalId(), $this->VALID_LIKE_APPROVED);
         $like->insert($this->getPDO());

         // grab the data from mySQL and enforce the fields match our expectations
         $results = Like::getLikeByLikeAnimalIdAndByLikeUserId($this->getPDO(), $this->animal->getAnimalId());
         $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("like"));
         $this->assertCount(1, $results);
         $this->assertContainsOnlyInstancesOf("PawsForCause\\Paws\\Like", $results);

         // grab the result from the array and validate it
         $pdoLike = $results[0];
         $this->assertEquals($pdoLike->getLikeUserId(), $this->user->getUserId());
         $this->assertEquals($pdoLike->getLikeAnimalId(), $this->animal->getAnimalId());

      }


      /**
       * test grabbing a Like by user id
       **/
      public function testGetValidLikeByUserId(): void {
         // count the number of rows and save it for later
         $numRows = $this->getConnection()->getRowCount("like");

         // create a new Like and insert to into mySQL
         $like = new Like($this->user->getUserId(), $this->animal->getAnimalId(), $this->VALID_LIKE_APPROVED);
         $like->insert($this->getPDO());

         // grab the data from mySQL and enforce the fields match our expectations
         $results = Like::getLikeByLikeAnimalIdAndByLikeUserId($this->getPDO(), $this->user->getUserId());
         $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("like"));
         $this->assertCount(1, $results);

         // enforce no other objects are bleeding into the test
         $this->assertContainsOnlyInstancesOf("PawsForCause\\Paws\\Like", $results);

         // grab the result from the array and validate it
         $pdoLike = $results[0];
         $this->assertEquals($pdoLike->getLikeUserId(), $this->user->getUserId());
         $this->assertEquals($pdoLike->getLikeAnimalId(), $this->animal->getAnimalId());

      }

   }


   //what is "getConnection"?
   // why are we counting the number of rows?
   // What is this: $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("like")); ?
   // Do we need this line? $this->assertContainsOnlyInstancesOf("Edu\\Cnm\\DataDesign\\Like", $results); ?
