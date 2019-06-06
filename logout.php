<?php

// logout the user
session_start();
// you must first start the session before you can destroy it
session_destroy();

// redirect the user to the login form
header("Refresh:3; url=login.php", true, 303);

echo 'You have been logged out. Redirecting you to the login page...';

// closing php tag is optional (and recommended) if there is no HTML output
