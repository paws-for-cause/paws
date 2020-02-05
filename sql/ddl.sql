-- Paws for the Cause - DDL Tables

DROP TABLE IF EXISTS `Like`;
DROP TABLE IF EXISTS Animal;
DROP TABLE IF EXISTS Shelter;
DROP TABLE IF EXISTS `User`;

-- Create User Entity

CREATE TABLE `User`(
  userId BINARY(16) NOT NULL,
  userActivationToken VARCHAR (32) NOT NULL,
  userAge SMALLINT SIGNED NOT NULL,
  userDescription VARCHAR(200),
  userEmail VARCHAR (64) NOT NULL,
  userFirstName VARCHAR (32) NOT NULL,
  userGender VARCHAR(32) ,
  userHash CHAR (97) NOT NULL,
  userLastName VARCHAR (32) NOT NULL,
  userPhone VARCHAR (11) NOT NULL,
  PRIMARY KEY (userId)
);

-- Create Shelter Entity

CREATE TABLE Shelter (
  shelterId BINARY(16) NOT NULL,
  shelterAddress VARCHAR(64) NOT NULL,
  shelterName VARCHAR(32) NOT NULL,
  shelterPhone VARCHAR(10) NOT NULL,
  PRIMARY KEY (shelterId)
);

-- Create Animal Entity

CREATE TABLE Animal (
  animalId BINARY(16) NOT NULL,
  animalShelterId BINARY(16) NOT NULL,
  animalAdoptionStatus VARCHAR(32) NOT NULL,
  animalBreed VARCHAR(32) NOT NULL,
  animalGender VARCHAR(6) NOT NULL,
  animalName VARCHAR(32) NOT NULL,
  animalPhotoUrl VARCHAR(32) NOT NULL,
  animalSpecies VARCHAR(32) NOT NULL,
  INDEX(animalId),
  FOREIGN KEY (animalId) references Shelter(shelterId),
  PRIMARY KEY (animalId)
);


-- Create Like Entity

CREATE TABLE `Like` (
  likeAnimalId BINARY(16) NOT NULL,
  likeUserId BINARY(16) NOT NULL,
  likeApproved TINYINT(1) NOT NULL,
  INDEX(likeUserId),
  INDEX(likeAnimalId),
  FOREIGN KEY (likeUserId) references `User`(userId),
  FOREIGN KEY (likeAnimalId) references Animal(animalId)
);
