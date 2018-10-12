<?php

//connection variables
$host = 'localhost';
$user = 'root';
$password = '';

//create mysql connection
$mysqli = new mysqli($host,$user,$password);
if ($mysqli->connect_errno) {
    printf("Connection failed: %s\n", $mysqli->connect_error);
    die();
}

//create the database
if ( !$mysqli->query('CREATE DATABASE accounts') ) {
    printf("Errormessage: %s\n", $mysqli->error);
}

$mysqli->query('
CREATE TABLE `accounts`.`songs` 
(
    `song_id` INT NOT NULL AUTO_INCREMENT,
    `id` INT NOT NULL,
    `song` VARCHAR(50) NOT NULL,
    `genre` VARCHAR(50) NULL,
    `country` VARCHAR(50) NULL,
    `period` VARCHAR(50) NULL,
    `language` VARCHAR(50) NULL,
    `artist` VARCHAR(50) NULL,
PRIMARY KEY (`song_id`) 
);') or die($mysqli->error);

//create users table with all the fields
$mysqli->query('
CREATE TABLE `accounts`.`users` 
(
    `id` INT NOT NULL AUTO_INCREMENT,
    `first_name` VARCHAR(50) NOT NULL,
     `last_name` VARCHAR(50) NOT NULL,
    `email` VARCHAR(100) NOT NULL,
    `password` VARCHAR(100) NOT NULL,
    `hash` VARCHAR(32) NOT NULL,
    `active` BOOL NOT NULL DEFAULT 0,
PRIMARY KEY (`id`) 
);') or die($mysqli->error);


?>