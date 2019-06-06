<?php
// __DIR__ is gthe path to the directory THIS file is in, which is in the includes directory. Making the require relative to this file, and to to the page that imports THIS file.
require_once(__DIR__ . '/../conn/connBlogs.php');

// if the session has not been started, start it now
if(!isset($_SESSION)) {
  session_start(); // gets the current session variables, or creates a blank session if none is found.
}

if(isset($_GET['logout'])) {
  // if the URL has a logout variable, then log out the user
  session_destroy(); // delete the session cookie
  unset($_SESSION); // delete the session data
}

if(isset($_POST['submit-login'])) {
  // if true then the login form was submitted
  
  // import connection code
  // require_once('../conn/connBlogs.php');

  // only if the post variable "user" exists, then do login code
  // i.e. if the login form was submitted
  if(isset($_POST['user'])) {
    // get the value of the login form variables in the POST data
    $user = $_POST['user'];
    $pswd = $_POST['pswd'];

    // check if username matches any user in the database
    $query = "SELECT * FROM members WHERE user='$user'";

    // $query is just a string for now, so let's send it to the database
    $result = mysqli_query($conn, $query);

    // $row will be the user if we found a match, NULL otherwise.
    $row = mysqli_fetch_array($result);

    if($row) {
      // user exists, so now match hashed password w submitted password
      if(password_verify($pswd, $row['pswd'])) {
        // login was successful, so store the user info in the session
        $_SESSION['user'] = $row['user'];
        $_SESSION['IDmbr'] = $row['IDmbr'];
        $_SESSION['firstName'] = $row['firstName'];
        $_SESSION['lastName'] = $row['lastName'];
      } else {
        $loginError = 'Username and/or password did not match.';
      } // if-else if(password_verify($pswd, $row['pswd']))
    } else {
      $loginError = 'Username and/or password did not match.';
    } // ie-else if($row)
  } // if(isset($_POST['user']))
} // if(isset($_POST['submit-login']))

// POST submit-join is set if and only if the join form was submitted
if(isset($_POST['submit-join'])) {
  // get the value of the contact form variables in the POST data
  $firstName = $_POST['firstName'];
  $lastName = $_POST['lastName'];
  $email = $_POST['email'];
  $user = $_POST['user'];
  $pswd = $_POST['pswd'];
    
  echo "Form data: $firstName $lastName $email $user $pswd"; // testing

  // first check if the user already exists
  $query = "SELECT IDmbr FROM members WHERE user = '$user'";
  $result = mysqli_query($conn, $query);
  // if any rows got returned, then there is some user with that username
  if(mysqli_num_rows($result) > 0) {
    // username is already taken
    $msg = 'Username is already taken. Please try another.';
  } else {
    // hash the password so we don't save it in clear text
    $hashPswd = password_hash($pswd, PASSWORD_DEFAULT);
    // the password_hash function converts the password into a very long string of random chars.

    $query = "INSERT INTO
    members(firstName, lastName, email, user, pswd) VALUES('$firstName','$lastName','$email','$user','$hashPswd')";

    $result = mysqli_query($conn, $query);

    if(!$result) {
      $msg = mysqli_error($conn);
    }

    // mysqli_affected_rows tells us if we actually inserted a new row, by telling us how many rows were affected with the last statement
    $registered = mysqli_affected_rows($conn);

    if($registered == 1) {
      $msg = 'Thank you for joining. Please log in.';

      // to make sure we always use the right path to the members directory, we use the __DIR__ magic constant.
      // __DIR__ is always the path to the directory of the file in which it is located.
      $memberFolder = __DIR__ . "/../members/" . $user;
      
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

}

?>