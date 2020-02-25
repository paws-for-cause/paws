<?php

   namespace PawsForCause\Paws\Test;

   use PawsForCause\Paws\{
       shelter
   };

//grab the class under scrutiny
   require_once(dirname(__DIR__) . "/autoload.php");

//grab the uuid generator
   require_once(dirname(__DIR__, 2) . "/lib/uuid.php");

   /**
    * Full PHPUnit test for the Shelter class
    *
    * This is a complete PHPUnit test of the Shelter class. It is complete because *ALL* mySQL/PDO enabled methods are tested for both invalid and valid inputs.
    *
    * @see Shelter
    * @author Usaama Alnaji <ualnaji@cnm.edu> with code referenced from Dylan McDonald <dmcdonald21@cnm.edu>
    *
    */
   class ShelterTest extends PawsTest {
      /**
       * valid shelter id to create the shelter object to own the test
       * @var string $VALID_SHELTER_ID
       */

      protected $VALID_SHELTER_ID;

      /**
       * address of the shelter
       * @var string $VALID_SHELTER_ADDRESS
       */

      protected $VALID_SHELTER_ADDRESS = "123 testing street";

      /**
       * name of the shelter
       * @var string $VALID_SHELTER_NAME
       */

      protected $VALID_SHELTER_NAME = "Test Shelter";

      /**
       * second name of the shelter to use
       * @var string $VALID_SHELTER_NAME2
       */

      protected $VALID_SHELTER_NAME2 = "Test Shelter 2";

      /**
       * phone number for the shelter
       * @var string $VALID_SHELTER_PHONE
       */

      protected $VALID_SHELTER_PHONE = "1111111111";

      /**
       * test inserting a valid Shelter and verify that the actual mySQL data matches
       */

       /*
        * run the defualt setup operation to create salt and hash.
        */

       public final function setUp(): void {
           parent::setUp();

           //
           $password = "abc123";
           $this->VALID_HASH = password_hash($password, PASSWORD_ARGON2I, ["time_cost" => 7]);
           $this->VALID_ACTIVATION = bin2hex(random_bytes(15));
       }


       public function testInsertValidShelter(): void {
         //count the number of rows and save it for later
         $numRows = $this->getConnection()->getRowCount("shelter");

         $shelterId = generateUuidV4();
         $shelter = new Shelter($shelterId, $this->VALID_SHELTER_ADDRESS, $this->VALID_SHELTER_NAME2, $this->VALID_SHELTER_PHONE);
         $shelter->insert($this->getPDO());


           //grab the data from mySQL and enforce the fields match our expectations
         $pdoShelter = Shelter::getShelterByShelterId($this->getPDO(), $shelter->getShelterId());
         $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("shelter"));
          $this->assertEquals($pdoShelter->getShelterId(), $shelterId);
          $this->assertEquals($pdoShelter->getShelterAddress(), $this->VALID_SHELTER_ADDRESS);
          $this->assertEquals($pdoShelter->getShelterName(), $this->VALID_SHELTER_NAME2);
          $this->assertEquals($pdoShelter->getShelterPhone(), $this->VALID_SHELTER_PHONE);
      }

      /**
       * test inserting a Shelter, editing it, and then updating it
       **/
      public function testUpdateValidShelter() {
         // count the number of rows and save it for later
         $numRows = $this->getConnection()->getRowCount("shelter");

         // create a new Shelter and insert to into mySQL
         $shelterId = generateUuidV4();
         $shelter = new Shelter($shelterId, $this->VALID_SHELTER_ADDRESS, $this->VALID_SHELTER_NAME, $this->VALID_SHELTER_PHONE);
         $shelter->insert($this->getPDO());


         // edit the Shelter and update it in mySQL
         $shelter->setShelterName($this->VALID_SHELTER_NAME2);
         $shelter->update($this->getPDO());

         // grab the data from mySQL and enforce the fields match our expectations
         $pdoShelter = Shelter::getShelterByShelterId($this->getPDO(), $shelter->getShelterId());


         $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("shelter"));
         $this->assertEquals($pdoShelter->getShelterId(), $shelterId);
         $this->assertEquals($pdoShelter->getShelterAddress(), $this->VALID_SHELTER_ADDRESS);
         $this->assertEquals($pdoShelter->getShelterName(), $this->VALID_SHELTER_NAME2);
         $this->assertEquals($pdoShelter->getShelterPhone(), $this->VALID_SHELTER_PHONE);

      }


      /**
       * test creating a Shelter and then deleting it
       **/

      public function testDeleteValidShelter(): void {
         // count the number of rows and save it for later
         $numRows = $this->getConnection()->getRowCount("shelter");

         $shelterId = generateUuidV4();
         $shelter = new Shelter($shelterId, $this->VALID_SHELTER_ADDRESS, $this->VALID_SHELTER_NAME, $this->VALID_SHELTER_PHONE);
         $shelter->insert($this->getPDO());


         // delete the Shelter from mySQL
         $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("shelter"));
         $shelter->delete($this->getPDO());

         // grab the data from mySQL and enforce the Shelter does not exist
         $pdoShelter = Shelter::getShelterByShelterId($this->getPDO(), $shelter->getShelterId());
         $this->assertNull($pdoShelter);
         $this->assertEquals($numRows, $this->getConnection()->getRowCount("shelter"));
      }


      /**
       * test inserting a Shelter and regrabbing it from mySQL
       **/
      public function testGetValidShelterByShelterId(): void {
         // count the number of rows and save it for later
         $numRows = $this->getConnection()->getRowCount("shelter");

         $shelterId = generateUuidV4();
         $shelter = new Shelter($shelterId, $this->VALID_SHELTER_ADDRESS, $this->VALID_SHELTER_NAME, $this->VALID_SHELTER_PHONE);
         $shelter->insert($this->getPDO());

         // grab the data from mySQL and enforce the fields match our expectations
         $pdoShelter = Shelter::getShelterByShelterId($this->getPDO(), $shelter->getShelterId());
         $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("shelter"));
          $this->assertEquals($pdoShelter->getShelterId(), $shelterId);
          $this->assertEquals($pdoShelter->getShelterAddress(), $this->VALID_SHELTER_ADDRESS);
          $this->assertEquals($pdoShelter->getShelterName(), $this->VALID_SHELTER_NAME);
          $this->assertEquals($pdoShelter->getShelterPhone(), $this->VALID_SHELTER_PHONE);
      }


   }









   // When do you use null as opposed to "PHP Test Passing" ?