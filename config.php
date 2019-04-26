<?php
session_start();

// Local Database conection credentials
// $db_host = 'localhost';
// $db_user = 'root';
// $db_pass = '';
// $db_name = 'testing_dashboard';

// Production Database conection credentials
$db_host = 'localhost';
$db_user = 'ndzwgvra_user';
$db_pass = 'HiAW+qU4?LD&';
$db_name = 'ndzwgvra_db';


//Connect to the database
$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

//Include classes
require_once('classes/user.php');
require_once('classes/project.php');
require_once('classes/comment.php');
require_once('classes/testcase.php');