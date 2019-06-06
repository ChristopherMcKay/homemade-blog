<?php

// import connection code
require_once('conn/connBlogs.php');

// get the value of the contact form variables in the POST data
$firstName = $_POST['firstName'];
$lastName = $_POST['lastName'];
$email = $_POST['email'];
$user = $_POST['user'];
$pswd = $_POST['pswd'];

// first check if the user already exists
$query = "SELECT IDmbr FROM members WHERE user = '$user'";
$result = mysqli_query($conn, $query);
// if any rows got returned, then there is some user with that username
if (mysqli_num_rows($result) > 0) {
  // username is already taken
  $msg = 'Username is already taken. Please try another.';
}
else {
  // hash the password so we don't save it in clear text
  $hashPswd = password_hash($pswd, PASSWORD_DEFAULT);
  // the password_hash function converts the password into a very long string of random chars.

  $query = "INSERT INTO
  members(firstName, lastName, email, user, pswd) VALUES('$firstName','$lastName','$email','$user','$hashPswd')";

  $result = mysqli_query($conn, $query);

  if (!$result) {
    $msg = mysqli_error($conn);
  }

  // mysqli_affected_rows tells us if we actually inserted a new row, by telling us how many rows were affected with the last statement
  $registered = mysqli_affected_rows($conn);

  if ($registered == 1) {
    $msg = 'Thank you for joining. Please log in.';

    header("Refresh:3; url=login.php", true, 303);

    $memberFolder = "members/" . $user;
    // make directory for user's files
    // 0777 is a unix style file access code
    // 7 means readable(4) + writable(2) + executable (1)
    // 777 means everyone + group + owner
    mkdir($memberFolder, 0777);

    $imagesFolder = $memberFolder . "/images";
    $audioFolder = $memberFolder . "/audio";
    $videoFolder = $memberFolder . "/video";
    $pdfFolder = $memberFolder . "/pdf";

    mkdir($imagesFolder, 0777);
    mkdir($audioFolder, 0777);
    mkdir($videoFolder, 0777);
    mkdir($pdfFolder, 0777);

  }
  else {
    $msg = 'Could not sign you up. Please try again.';
  }
	
} // end else username is not taken

?><!DOCTYPE html>
<html lang="">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Member Join Processor</title>
</head>
<body>
  <h1><?php echo $msg; ?></h1>
</body>
</html>