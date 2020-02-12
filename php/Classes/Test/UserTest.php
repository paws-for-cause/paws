<?php

   namespace PawsForCause\Paws\Test;

   use PawsForCause\Paws\{Tests\PawsTest, User, Shelter, Animal, Like};


   //grab the class under scrutiny
   require_once(dirname(__DIR__) . "/autoload.php");

   //grab the uuid generator
   require_once (dirname(__DIR__, 2) . "/lib/uuid.php");

   /**
    * Full PhPUnit test for the User class
    *
    * This is a complete PHPUnit test of the User class. It is complete because *ALL* mySQL/PDO endabled methods are tested for both invalid and valid inputs.
    *
    * @see User
    * @author Matthew Urrea <matt.urrea.code@gmail.com>
    *
    */

   class UserTest extends PawsTest {
      /**
       * placeholder until account activation is created
       * @var string $VALID_ACTIVATION
       */
      protected $VALID_ACTIVATION;

      /**
       * vaild at handle to use
       * @var string $VALID_ATHANDLE
       */
      protected $VALID_FIRST_NAME = "hank";

      /**
       * second valid at handle to use
       * @var string $VALID_ATHANDLE2
       */
      protected $VALID_LAST_NAME = "hill";

      /**
       * second valid at handle to use
       * @var string $VALID_ATHANDLE2
       **/
      protected $VALID_AGE = "47";

      /**
       * valid user email to use
       * @var string $VALID_EMAIL
       **/
      protected $VALID_EMAIL = "hank.hill@gmail.com";

      /**
       * valid hash to use
       * @var $VALID_HASH
       */
      protected $VALID_HASH;

      /**
       * valid phone number to use
       * @var string $VALID_PHONE
       **/
      protected $VALID_PHONE = "23334445555";

      /*
       * run the defualt setup operation to create salt and hash.
       */

      public final function setUp(): void {
         parent::setUp();

         //
         $password = "abc123";
         $this->VALID_HASH = password_hash($password, PASSWORD_ARGON2I, ["time_cost" => 384]);
         $this->VALID_ACTIVATION = bin2hex(random_bytes(16));
      }

      /**
       * test inserting a valid User and verify that the actual mySQL data matches
       */
      public function  testInsertValidUser() : void {
         // count the number of rows and save it for later
         $numRows = $this->getConnection()->getRowCount("user");

         $userId = generateUuidV4();

         $user = new User($userId, $this->VALID_ACTIVATION, $this->VALID_FIRST_NAME, $this->VALID_LAST_NAME, $this->VALID_AGE, $this->VALID_EMAIL, $this->VALID_HASH, $this->VALID_PHONE);
         $user->insert($this->getPDO());

         // grab the data from mySQL and enforce the fields match our expectations
         $pdoUser = User::getUserByUserId($this->getPDO(), $user->getUserId());
         $this->assertEquals($numRows + 1, $this->getConnection()-> getRowCount("user"));
         $this->assertEquals($pdoUser->getUserId(), $userId);
         $this->assertEquals($pdoUser->getUserActivationToken(), $this->VALID_ACTIVATION);
         $this->assertEquals($pdoUser->getUserFirstName(), $this->VALID_FIRST_NAME);
         $this->assertEquals($pdoUser->getUserLastName(), $this->VALID_LAST_NAME);
         $this->assertEquals($pdoUser->getUserAge(), $this->VALID_AGE);
         $this->assertEquals($pdoUser->getUserEmail(), $this->VALID_EMAIL);
         $this->assertEquals($pdoUser->getUserHash(),$this->VALID_HASH);
         $this->assertEquals($pdoUser->getUserPhone(), $this->VALID_PHONE);
      }

      /**
       * test inserting a User, editing it, and then updating it
       */
      public function testUpdateValidUser() {
         // count the number of rows and save it for later
         $numRows = $this->getConnection()->getRowCount("user");

         // create a new User and insert into mySQL
         $userId = generateUuidV4();
         $user = new User($userId, $this->VALID_ACTIVATION, $this->VALID_FIRST_NAME, $this->VALID_FIRST_NAME, $this->VALID_AGE, $this->VALID_EMAIL, $this->VALID_HASH, $this->VALID_PHONE);
         $user->insert($this->getPDO());

         //edit the User and update it in mySQL
         $user->setUserAtHandle($this->VALID_EMAIL);
         $user->update($this->getPDO());

         //grab the data from mySQL and enforce the fields match our expectations
         $pdoUser = User :: getUserByEmail($this->getPDO(), $user->getUserEmail());

         $this->assertEquals($numRows, + 1, $this->getConnection()->getRowCount("user"));
         $this->assertEquals($pdoUser->getUserId(), $userId);
         $this->assertEquals($pdoUser->getUserActivationToken(), $this->VALID_ACTIVATION);
         $this->assertEquals($pdoUser->getUserFirstName(), $this->VALID_FIRST_NAME);
         $this->assertEquals($pdoUser->getUserLastName(), $this->VALID_LAST_NAME);
         $this->assertEquals($pdoUser->getUserAge(), $this->VALID_AGE);
         $this->assertEquals($pdoUser->getUserEmail(), $this->VALID_EMAIL);
         $this->assertEquals($pdoUser->getUserHash(),$this->VALID_HASH);
         $this->assertEquals($pdoUser->getUserPhone(), $this->VALID_PHONE);
      }

      /**
       * test creating a user and then deleting it
       */
      public function testDeleteValidUser() : void {
         //count the number of rows and save it for later
         $numRows = $this->getConnection()->getRowCount("user");

         $userId = generateUuidV4();
         $user = new User($userId, $this->VALID_ACTIVATION, $this->VALID_FIRST_NAME, $this->VALID_FIRST_NAME, $this->VALID_AGE, $this->VALID_EMAIL, $this->VALID_HASH, $this->VALID_PHONE);
         $user->insert($this->getPDO());


         // delete the user from mySQL
         $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("user"));
         $user->delete($this->getPDO());

         // grab the data from mySQL and enforce the user does not exist
         $pdoUser = User::getUserByUserId($this->getPDO(), $user->getUserId());
         $this->assertNull($pdoUser);
         $this->assertEquals($numRows, $this->getConnection()->getRowCount("user"));
      }

      /**
       * test grabbing a user by its activation
       */
      public function testGetValidUserByActivationToken() : void {
         // count the number of rows and save it for later
         $numRows = $this->getConnection()->getRowCount("user");

         $userId = generateUuidV4();
         $user = new User($userId, $this->VALID_ACTIVATION, $this->VALID_FIRST_NAME, $this->VALID_FIRST_NAME, $this->VALID_AGE, $this->VALID_EMAIL, $this->VALID_HASH, $this->VALID_PHONE);
         $user->insert($this->getPDO());

         // grab the data from mySQL and enforce the fields match our expectations
         $pdoUser = User::getUserByActivationToken($this->getPDO(), $user->getUserActivationToken());
         $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("user"));
         $this->assertEquals($pdoUser->getUserId(), $userId);
         $this->assertEquals($pdoUser->getUserActivationToken(), $this->VALID_ACTIVATION);
         $this->assertEquals($pdoUser->getUserFirstName(), $this->VALID_FIRST_NAME);
         $this->assertEquals($pdoUser->getUserLastName(), $this->VALID_LAST_NAME);
         $this->assertEquals($pdoUser->getUserAge(), $this->VALID_AGE);
         $this->assertEquals($pdoUser->getUserEmail(), $this->VALID_EMAIL);
         $this->assertEquals($pdoUser->getUserHash(),$this->VALID_HASH);
         $this->assertEquals($pdoUser->getUserPhone(), $this->VALID_PHONE);
      }



      /**
       * test inserting a User and regrabbing it from mySQL
       **/
      public function testGetValidUserByUserId() : void {
         // count the number of rows and save it for later
         $numRows = $this->getConnection()->getRowCount("user");

         $userId = generateUuidV4();
         $user = new User($userId, $this->VALID_ACTIVATION, $this->VALID_FIRST_NAME, $this->VALID_FIRST_NAME, $this->VALID_AGE, $this->VALID_EMAIL, $this->VALID_HASH, $this->VALID_PHONE);
         $user->insert($this->getPDO());

         // grab the data from mySQL and enforce the fields match our expectations
         $pdoUser = User::getUserByUserId($this->getPDO(), $user->getUserId());
         $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("user"));
         $this->assertEquals($pdoUser->getUserId(), $userId);
         $this->assertEquals($pdoUser->getUserActivationToken(), $this->VALID_ACTIVATION);
         $this->assertEquals($pdoUser->getUserFirstName(), $this->VALID_FIRST_NAME);
         $this->assertEquals($pdoUser->getUserLastName(), $this->VALID_LAST_NAME);
         $this->assertEquals($pdoUser->getUserAge(), $this->VALID_AGE);
         $this->assertEquals($pdoUser->getUserEmail(), $this->VALID_EMAIL);
         $this->assertEquals($pdoUser->getUserHash(),$this->VALID_HASH);
         $this->assertEquals($pdoUser->getUserPhone(), $this->VALID_PHONE);
      }


      /**
       * test grabbing a User by email
       **/
      public function testGetValidUserByEmail() : void {
         // count the number of rows and save it for later
         $numRows = $this->getConnection()->getRowCount("user");

         $userId = generateUuidV4();
         $user = new User($userId, $this->VALID_ACTIVATION, $this->VALID_FIRST_NAME, $this->VALID_FIRST_NAME, $this->VALID_AGE, $this->VALID_EMAIL, $this->VALID_HASH, $this->VALID_PHONE);
         $user->insert($this->getPDO());

         // grab the data from mySQL and enforce the fields match our expectations
         $pdoUser = User::getUserByUserEmail($this->getPDO(), $user->getUserEmail());
         $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("user"));
         $this->assertEquals($pdoUser->getUserId(), $userId);
         $this->assertEquals($pdoUser->getUserActivationToken(), $this->VALID_ACTIVATION);
         $this->assertEquals($pdoUser->getUserFirstName(), $this->VALID_FIRST_NAME);
         $this->assertEquals($pdoUser->getUserLastName(), $this->VALID_LAST_NAME);
         $this->assertEquals($pdoUser->getUserAge(), $this->VALID_AGE);
         $this->assertEquals($pdoUser->getUserEmail(), $this->VALID_EMAIL);
         $this->assertEquals($pdoUser->getUserHash(),$this->VALID_HASH);
         $this->assertEquals($pdoUser->getUserPhone(), $this->VALID_PHONE);
      }
   }