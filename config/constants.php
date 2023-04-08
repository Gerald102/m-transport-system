<?php
    //start Session
    session_start();


//Create constants to store none repeating values
define('SITEURL','http://localhost/transport-system/');
define('LOCALHOST','localhost');
define('DB_USERNAME','root');
define('DB_PASSWORD','');
define('DB_NAME','transport-system');

$conn = mysqli_connect(LOCALHOST,DB_USERNAME,DB_PASSWORD) or die(mysqli_error()); //Database connection
$db_select = mysqli_select_db($conn,DB_NAME) or die(mysqli_error); //Selecting Database


 ?>
