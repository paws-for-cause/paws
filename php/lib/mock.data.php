<?php
require_once dirname(__DIR__, 1) . "/vendor/autoload.php";
require_once(dirname(__DIR__) . "/Classes/autoload.php");
require_once("/etc/apache2/capstone-mysql/Secrets.php");
require("uuid.php");
$secrets = new \Secrets("/etc/apache2/capstone-mysql/paws.ini");
$pdo = $secrets->getPdoObject();


use PawsForCause\Paws\{User, Like, Animal};
$password = "password";
$hash = password_hash($password, PASSWORD_ARGON2I, ["time_cost" => 45]);

$user1 = new User(generateUuidV4(), null, 18, "hello@gmail.com", "Hello", $hash, "Mate", "5055055505");

$user1->insert($pdo);
$animals =  Animal::getAllAnimals ($pdo);
for ($i=1; $i<=5; $i++) {
    $like = new like ($animals[$i]->getAnimalId(), $user1->getUserId(), 1);

    $like->insert($pdo);
}

