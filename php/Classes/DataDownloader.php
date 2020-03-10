<?php

   require_once("autoload.php");
   require_once(dirname(__DIR__, 1) . "/lib/uuid.php");
   require_once(dirname(__DIR__) . "/vendor/autoload.php");
   require_once("/etc/apache2/capstone-mysql/paws.ini");
   require_once("/etc/apache2/capstone-mysql/Secrets.php");

   use GuzzleHttp\Client;


   /**
    * This class will download data from the Petfinder API.
    *
    * @author Matthew Urrea <matt.urrea.code@gmail.com
    * @author HalfMortise <https://www.github.com/halfmortise>
    * @author SHeckendorn <https://www.github.com/sheckendorn>
    *
    **/
   class DataDownloader {
      /**
       * @var Client
       */
      private $guzzle;

      /**
       * @var \PDO $pdo
       */
      private $pdo;

      /*
       * @var string
       */
      private $authToken;

      /*
       * @var string
       */
      private $secret;


      /*
       * constructor for the class
       */

      public function __construct() {
         //connection to the api
         $this->guzzle = new Client(["base_uri" => "https://api.petfinder.com/v2/"]);
         $secrets = new \Secrets("/etc/apache2/capstone-mysql/paws.ini");
         $this->secret = $secrets->getSecret("pet-finder");
         $this->pdo = $secrets->getPdoObject();
         $this->getAuthHeader();
         // $this->getDogData();
         // $this->getCatData();
         $this->getOrgsInNM();

      }

      /*
       * post method to get authorization header and token
       * @return
       */
      public function getAuthHeader(): void {
         //var_dump($this->secret->apiKey);
         $request = $this->guzzle->request('POST', 'oauth2/token', [
            'form_params' => [

               'grant_type' => 'client_credentials',
               "client_id" => $this->secret->apiKey,
               'client_secret' => $this->secret->secretKey

            ]
         ]);
        // echo $request->getBody();
         $this->accessArray = json_decode($request->getBody(), true);
         $this->authToken = $this->accessArray['access_token'];
      }

      /**
       * get method to get the dog data based on baseUri
       *
       */
      public function getDogData(): void {
         $data = $this->guzzle->request('GET', 'animals?type=dog&page=1', [ "headers" => ["Authorization" => "Bearer $this->authToken"]
         ]);
         //var_dump($data);
      }

      /**
       * get method to get the dog data based on baseUri
       *
       */
      public function getCatData(): void {
        $data = $this->guzzle->request('GET', 'animals?type=cat&page=1', [ "headers" => ["Authorization" => "Bearer $this->authToken"]
         ]);

        //var_dump($data);

      }

      /*
       * get method to get all shelters in new mexico
       *
       */
      public function getOrgsInNM(): void {
         $organizations = $this->guzzle->request('GET', 'organizations?state=NM', [ "headers" => ["Authorization" => "Bearer $this->authToken"]
         ]);

         $this->orgObject = json_decode($organizations->getBody());
         var_dump($this->orgObject);

         /*FIRST ATTEMPT UNSUCCESSFUL
          * foreach($this->orgObject['id'] as $key => $value) {
            print($value);
            print($this->orgObject['address'][$key]);
            print($this->orgObject['name'][$key]);
            print($this->orgObject['phone'][$key]);
         }*/

         /* SECOND ATTEMPT UNSCCESSFUL
          * foreach($this->orgObject->values as $arr){
            foreach ($arr as $obj) {
               $id = $obj->group->id;
               $address = $obj->group->address;
               $name = $obj->group->name;
               $phone = $obj->group->phone;

            }*/
         foreach($this->orgObject as $key => $value){
            foreach ($value as $object) {
               echo $object->id;
               echo $object->address;
               echo $object->name;
               echo $object->phone;
             }
         }
      }




   }


   new DataDownloader();

/*
   TODO Iterate over array to get Shelter, ID, Name, Address, Phone.

Get all cat and dog data related to ShelterId.

Iterate over array to get desired animal values*/