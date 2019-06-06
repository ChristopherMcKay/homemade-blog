<!DOCTYPE html>
<html lang="">
<head>
  <title>Member Join Form</title>
  <style>
    input {
      color: beige;
      background-color: #888;
      font-weight: bold;
    }
  </style>
</head>
<body>
  <form name="form1" id="form1" method="post" action="memberJoinProc.php" onsubmit="return validatePasswords()">
    
    <table border="1" cellpadding="5">
      
      <tr>
        <th colspan="2">Join Now! It's Free!</th>
      </tr>
      
      <tr>
        <td>First Name: </td>
        <td><input type="text" name="firstName" id="firstName" required></td>
      </tr>
      
      <tr>
        <td>Last Name: </td>
        <td><input type="text" name="lastName" id="lastName" required></td>
      </tr>
      
      <tr>
        <td>Email: </td>
        <td><input type="email" name="email" id="email" required></td>
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
        <td>Re-Type Password: </td>
        <td><input type="password" name="pswd2" id="pswd2" required></td>
      </tr>
      
     <tr>
        <td colspan="2"><input type="submit"></td>
      </tr>
    </table>
  </form>
  
  <script>
    function validatePasswords() {
      // check that the two passwords match
      var pswd = document.getElementById('pswd').value;
      var pswd2 = document.getElementById('pswd2').value;
      if (pswd != pswd2) {
        // the passwords don't match, so alert the user and block the form
        alert('Passwords Don\'t Match!');
        return false; // blocks the form from submitting
      }
    }
  </script>
</body>
</html>