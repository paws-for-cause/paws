<?php
   namespace PawsForCause\Paws;

   require_once (dirname(__DIR__)) . "/Classes/autoload.php";
   require_once (dirname(__DIR__)) . "/vendor/autoload.php";

   use PawsForCause\Paws\User;
   use Ramsey\Uuid\Uuid;

   $hash = password_hash("abc123", PASSWORD_ARGON2I, ["time_cost" => 7]);
   var_dump($hash);

   $newUser= new User( "24234234324234234234234234234343", 43, "gmail@gmail.com", "Joe", $hash, "White", "15058675309");
   var_dump($newUser);