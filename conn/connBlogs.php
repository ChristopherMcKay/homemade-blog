<?php

$db_user = 'root';
$db_pass = 'mysql';
$db_name = 'blogging';
$db_host = 'localhost';

// your actual bluehost credentials
$db_user2 = 'ezshocom_Brian';
$db_pass2 = 'Abc123$1'; 
$db_name2 = 'ezshocom_mywebsite';


// local ampps
$conn = mysqli_connect($db_host, $db_user, $db_pass) or die('Could not connect to the database server');

mysqli_select_db($conn, $db_name) or die('Could not select the database');


// remote bluehost
//$conn = mysqli_connect($db_host, $db_user2, $db_pass2) or die('Could not connect to the database server');
//
//mysqli_select_db($conn, $db_name2) or die('Could not select the database');

