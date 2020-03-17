-- Paws for the Cause - DDL Tables

DROP TABLE IF EXISTS `like`;
DROP TABLE IF EXISTS animal;
DROP TABLE IF EXISTS shelter;
DROP TABLE IF EXISTS `user`;

-- Create User Entity

CREATE TABLE `user`(
  userId BINARY(16) NOT NULL,
  userActivationToken VARCHAR (32),
  userAge SMALLINT SIGNED NOT NULL,
  userEmail VARCHAR (64) NOT NULL,
  userFirstName VARCHAR (32) NOT NULL,
  userHash CHAR (97) NOT NULL,
  userLastName VARCHAR (32) NOT NULL,
  userPhone VARCHAR (16) NOT NULL,
  UNIQUE (userEmail),
  PRIMARY KEY (userId)
);

-- Create Shelter Entity

CREATE TABLE shelter (
  shelterId BINARY(16) NOT NULL,
  shelterAddress VARCHAR(256) NOT NULL,
  shelterName VARCHAR(64) NOT NULL,
  shelterPhone VARCHAR(16) NOT NULL,
  UNIQUE (shelterName),
  PRIMARY KEY (shelterId)
);

-- Create Animal Entity

CREATE TABLE animal (
  animalId BINARY(16) NOT NULL,
  animalShelterId BINARY(16) NOT NULL,
  animalAdoptionStatus VARCHAR(32) NOT NULL,
  animalBreed VARCHAR(64) NOT NULL,
  animalGender TINYINT(1) NOT NULL,
  animalName VARCHAR(32) NOT NULL,
  animalPhotoUrl VARCHAR(256) NOT NULL,
  animalSpecies VARCHAR(32) NOT NULL,
  INDEX(animalShelterId),
  FOREIGN KEY (animalShelterId) references shelter(shelterId),
  PRIMARY KEY (animalId)
);


-- Create Like Entity

CREATE TABLE `like` (
  likeAnimalId BINARY(16) NOT NULL,
  likeUserId BINARY(16) NOT NULL,
  likeApproved TINYINT(1) NOT NULL,
  INDEX(likeAnimalId),
  INDEX(likeUserId),
  FOREIGN KEY (likeAnimalId) references animal(animalId),
  FOREIGN KEY (likeUserId) references `user`(userId),
  PRIMARY KEY (likeAnimalId, likeUserId)
);
