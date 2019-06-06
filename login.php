<?php


?><!DOCTYPE html>
<html lang="">
<head>
  <title>Member Login</title>
  <style>
    input {
      color: beige;
      background-color: #888;
      font-weight: bold;
    }
  </style>
</head>
<body>
  <?php
    // if there is a successful login attempt, just print the welcome message
    if (isset($_SESSION['user'])) { ?>
  
      <h1>Welcome, <?php echo $_SESSION['firstName']; ?> (<?php echo $_SESSION['user']; ?>)</h1>
      <p><a href="blog/blog.php">Blog</a></p>
      <p><a href="logout.php">Logout</a></p>
  
    <?php }
    
    else { // no successful login attempt, so print the form
      
      // if there is a failed login attempt, print a failure message before the form
      if (isset($_POST['user'])) {
        echo '<h3 style="color:red">Username and password did not match.</h3>';
      }
      
    ?>
      <form name="form1" id="form1" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">

        <table border="1" cellpadding="5">

          <tr>
            <th colspan="2">Login</th>
          </tr>

          <tr>
            <td>Username: </td>
            <td><input type="text" name="user" id="user" required></td>
          </tr>

          <tr>
            <td>Password: </td>
            <td><input type="password" name="pswd" id="pswd" required></td>
          </tr>

         <tr>
            <td colspan="2"><input type="submit"></td>
          </tr>
        </table>
      </form>
  <?php
      // form was printed inside an else statement, so add the closing curly
    }
  ?>
</body>
</html>