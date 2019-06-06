<div class="popup" <?php if (isset($loginError) || isset($joinError)) echo 'style="display:flex"'; ?> >

  <button id="close-x">X</button>
  
  <div id="login">
    
      <form name="login-form" id="login-form" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">

        <table border="0" cellpadding="5">

          <tr>
            <th colspan="2">Already a member? Please log in</th>
          </tr>

          <?php if (isset($loginError)): ?>
          <tr>
            <th colspan="2" class="error"><?php echo $loginError; ?></th>
          </tr>
          <?php endif; ?>
          
          <tr>
            <td>Username: </td>
            <td><input type="text" name="user" id="user" required></td>
          </tr>

          <tr>
            <td>Password: </td>
            <td><input type="password" name="pswd" id="pswd" required></td>
          </tr>

         <tr>
            <td colspan="2"><input type="submit" name="submit-login" value="Login"></td>
          </tr>
          
        </table>
        
      </form>

  </div>
  
  <div id="join">
    
    <form name="join-form" id="join-form" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    
      <table border="0" cellpadding="5">

        <tr>
          <th colspan="2">Not a member? Join now</th>
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
          <td colspan="2">
            <input type="submit" name="submit-join" value="Join">
         </td>
        </tr>
        
        <tr>
          <td colspan="2">
            <?php echo $msg; ?>
         </td>
        </tr>
        
      </table>

    </form>
    
  </div>

</div>