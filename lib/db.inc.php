<?php

$dbServer = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName = "testdatabase";

$connection_string = "mysql:host=$dbServer;dbname=$dbName;charset=utf8mb4";
//using the PDO connector create a new connect to the DB
//if no error occurs we're connected
$db = new PDO($connection_string, $dbUsername, $dbPassword);
//the default fetch mode is FETCH_BOTH which returns the data as both an indexed array and associative array
//we'll override the default here so it's always fetched as an associative array
$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

?>