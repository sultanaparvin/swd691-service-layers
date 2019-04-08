<?php 
//Database conection credentials
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'testing_dashboard';

//Connect to the database
$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

//Include classes
require_once('classes/user.php');
require_once('classes/project.php');