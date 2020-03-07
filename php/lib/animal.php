<?php
   require_once dirname(__DIR__, 1) . "/vendor/autoload.php";
   require_once(dirname(__DIR__) . "/Classes/autoload.php");
   require_once("/etc/apache2/capstone-mysql/Secrets.php");
   require("uuid.php");
   $secrets = new \Secrets("/etc/apache2/capstone-mysql/paws.ini");
   $pdo = $secrets->getPdoObject();


   use PawsForCause\Paws\{Animal, User, Like, Shelter};

   $password = "password";
   $hash = password_hash($password, PASSWORD_ARGON2I, ["time_cost" => 45]);
/*
   $user1 = new User(generateUuidV4(), null, 100, "goober@gmail.com", "Joe", $hash, "Blah", "1112223434");
   $user1->insert($pdo);

   $user2 = new User(generateUuidV4(), null, 50, "jambo@gmail.com", "Chris", $hash, "McFake", "8383883838");
   $user2->insert($pdo);

   $user3 = new User(generateUuidV4(), null, 53, "boop@beep.com", "Dan", $hash, "Man", "2748329483");
   $user3->insert($pdo);*/

   $shelter1 = new Shelter(generateUuidV4(), "10001 Seven St.", "Squ Shelter", "5554442222");
   $shelter1->insert($pdo);

   $shelter2 = new Shelter(generateUuidV4(), "12341 Bloo Blv.", "pschulzetenbe", "1112223333");
   $shelter2->insert($pdo);

   $shelter3 = new Shelter(generateUuidV4(), "7847 Block Blv." , "Animal Farm", "9998884444");
   $shelter3->insert($pdo);

   $animal1 = new Animal(generateUuidV4(), $shelter1->getShelterId(),"not adopted","pug", 1, "Frank", "https://animals.com/franks-photo", "dog");
   $animal1->insert($pdo);

   $animal2 = new Animal(generateUuidV4(), $shelter2->getShelterId(),"adopted","Boxer", 0,"Jojo", "https://alsdjf.org/lasjfla", "parrot");
   $animal2->insert($pdo);

   $animal3 = new Animal(generateUuidV4(), $shelter3->getShelterId(),"not adopted","german kangaroo", 1, "Jan", "https://askdfa.com/aksjhf", "sksjdhfs");
   $animal3->insert($pdo);

/*
   $like1 = new Like($animal1->getAnimalId(), $user1->getUserId(), 1);
   $like1->insert($pdo);
   echo "success1";

   $like2 = new Like($animal2->getAnimalId(), $user2->getUserId(), 1);
   $like2->insert($pdo);
   echo "success2";

   $like3 = new Like( $animal3->getAnimalId(), $user3->getUserId(),1);
   $like3->insert($pdo);
   echo "success3";
*/
