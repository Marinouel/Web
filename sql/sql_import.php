<?php

//connection variables
$host = 'localhost';
$user = 'root';
$password = ' ';

//create mysql connection
$mysqli = new mysqli($host,$user,$password);
if ($mysqli->connect_errno) {
    printf("Connection failed: %s\n", $mysqli->connect_error);
    die();
}

//create the database
if ( !$mysqli->query('CREATE DATABASE login') ) {
    printf("Errormessage: %s\n", $mysqli->error);
}

//create users table with all the fields
$mysqli->query('
CREATE TABLE  `users` 
(
    
    `username` VARCHAR(50) NOT NULL,
    `password` VARCHAR(100) NOT NULL,
    `tracking_num` VARCHAR(100)  NULL,
PRIMARY KEY (`username`) 
);') or die($mysqli->error);

?>