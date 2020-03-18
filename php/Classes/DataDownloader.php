<?php

   namespace PawsForCause\Paws;
   require_once("autoload.php");
   require_once(dirname(__DIR__, 1) . "/lib/uuid.php");
   require_once(dirname(__DIR__) . "/vendor/autoload.php");
   require_once("/etc/apache2/capstone-mysql/paws.ini");
   require_once("/etc/apache2/capstone-mysql/Secrets.php");

   use GuzzleHttp\Client;

   /**
    * This class will download data from the Petfinder API.
    *
    * @author Matthew Urrea <matt.urrea.code@gmail.com>
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
       * constructor for new guzzle api interface
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
         $data = $this->guzzle->request('GET', 'animals?type=dog&page=1', ["headers" => ["Authorization" => "Bearer $this->authToken"]
         ]);

      }

      /**
       * get method to get the dog data based on baseUri
       *
       */
      public function getCatData(): void {
         $data = $this->guzzle->request('GET', 'animals?type=cat&page=1', ["headers" => ["Authorization" => "Bearer $this->authToken"]
         ]);
      }

      /*
       * get method to get all shelters in new mexico
       *
       */
      public function getOrgsInNM(): void {

         $currentPage = 1;


         //do {

            $organizations = $this->guzzle->request('GET', "organizations?state=NM&page=$currentPage", ["headers" => ["Authorization" => "Bearer $this->authToken"]
            ]);

            $this->orgObject = json_decode($organizations->getBody());

            $orgAddress = null;

            $currentPage = $this->orgObject->pagination->current_page;
            $totalPages = $this->orgObject->pagination->total_pages;

            var_dump($totalPages);

            foreach($this->orgObject->organizations as $key => $organization) {

               if($organization->address->address1 !== null && $organization->phone !== null) {
                  $orgAddress = $organization->address->address1 . " " . $organization->address->city . ", " . $organization->address->state . " " . $organization->address->postcode;
                  $orgName = $organization->name;
                  $orgPhone = $organization->phone === "" || $organization->phone === null ? $organization->phone : "no phone number";
                  $shelter = new Shelter(generateUuidV4(), $orgAddress, $orgName, $orgPhone);
                  $shelter->insert($this->pdo);
                  $this->getAnimalsInOrg($organization->id, $shelter->getShelterId());
               }
            }


        // } while($currentPage < $totalPages);


      }


      public function getAnimalsInOrg(string $petfinderOrgId, string $orgId): void {
         $animalsInOrg = $this->guzzle->request('GET', "animals?organization=$petfinderOrgId", ["headers" => ["Authorization" => "Bearer $this->authToken"]
         ]);

         $animalsObject = json_decode($animalsInOrg->getBody());

         foreach($animalsObject->animals as $key => $animal) {
            if(empty($animal->photos) === false) {
               //$animalAdoptionStatus = $animal->status;
               $animalAdoptionStatus = 1; //adoption status
               $animalBreed = $animal->breeds->primary;//breed of animaL
               $animalName = $animal->name;  //name of animal
               $animalPhoto = $animal->photos[0]->medium; //photos of animal
               $animalSpecies = $animal->type;  //species of animal
               if($animal->gender === 'male') { //gender of animal
                  $animalGender = 1;
               } else {
                  $animalGender = 0;
               }
               $animal = new Animal(generateUuidV4(), $orgId, $animalAdoptionStatus, $animalBreed, $animalGender, $animalName, $animalPhoto, $animalSpecies);
               $animal->insert($this->pdo);
               var_dump($animal);
            }
         }
      }

   }

   new DataDownloader();