<?php


namespace PawsForCause\Paws;

require_once(dirname(__DIR__) . "/Classes/autoload.php");
//require_once(dirname(__DIR__ ). "/vendor/autoload.php");

//use Ramsey\Uuid\Uuid;
use PawsForCause\Paws\Shelter;


$hash = password_hash("password", PASSWORD_ARGON2I, ["time_cost" => 7]);
var_dump($hash);

$newShelter = new Shelter("40a2540a-d711-44f5-a3d3-008593054e77", "12345678123456781234567812345678", "Dog Shelter", "1111111111", $hash, "New Author 1");

//echo ($newAuthor->getAuthorId());

//echo ($newAuthor-> getAuthorId()),($newAuthor-> getAuthorActivationToken()),($newAuthor-> getAuthorAvatarUrl()),($newAuthor-> getAuthorEmail()),($newAuthor-> getAuthorHash()),($newAuthor-> getAuthorUsername());
var_dump($newShelter);