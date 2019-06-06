<?php

    require_once('../conn/connApts.php');
    
    // get the vars from the bldgDetails.php CMS
    $IDbldg = $_POST['IDbldg']; // the hidden field
    $bldgName = $_POST['bldgName'];
    $bldgName = mysqli_real_escape_string($conn, $bldgName);
    $bldgDesc = $_POST['bldgDesc'];
    $bldgDesc = mysqli_real_escape_string($conn, $bldgDesc);
    $address = $_POST['address'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $yearBuilt = $_POST['yearBuilt'];
    $floors = $_POST['floors'];

    // handle the checkboxes
    if(isset($_POST['doorman'])) { // isset true means checkbox is checked
        $isDoorman = 1;
    } else { // not set means checkbox not checked
        $isDoorman = 0;
    }

    if(isset($_POST['pets'])) { // isset true means checkbox is checked
        $isPets = 1;
    } else { // not set means checkbox not checked
        $isPets = 0;
    }

    if(isset($_POST['parking'])) { // isset true means checkbox is checked
        $isParking = 1;
    } else { // not set means checkbox not checked
        $isParking = 0;
    }

    if(isset($_POST['gym'])) { // isset true means checkbox is checked
        $isGym = 1;
    } else { // not set means checkbox not checked
        $isGym = 0;
    }

    // UPDATE the bldg -- make sure to specify ONE bldg to update
    $query = "UPDATE buildings SET bldgName='$bldgName', yearBuilt='$yearBuilt', bldgDesc='$bldgDesc', address='$address', email='$email', phone='$phone', floors='$floors', isDoorman='$isDoorman', isPets='$isPets', isParking='$isParking', isGym='$isGym' WHERE IDbldg='$IDbldg'";

    mysqli_query($conn, $query);

?>

<!DOCTYPE html>
<html lang="en-us">
    
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Bldg Updater</title>
  <link rel="stylesheet" href="../css/apts.css">
</head>

<body>
    
  <div id="container">
      <h1>
          <?php 
            if(mysqli_affected_rows($conn) == 1) {
                echo 'Changes to Bldg ID ' . $IDbldg . ' Saved Successfully!';
            } else {
                echo mysqli_error($conn);
            }
          ?>
      </h1>
      <h2>
          <button onclick="window.history.back()">Back To Search Results</button>
      </h2>
  </div>
    
</body>
</html>