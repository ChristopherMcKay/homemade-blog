<?php

$db_user = 'root';
$db_pass = 'mysql';
$db_name = 'blogging';
$db_host = 'localhost';



// local ampps
$conn = mysqli_connect($db_host, $db_user, $db_pass) or die('Could not connect to the database server');

mysqli_select_db($conn, $db_name) or die('Could not select the database');



