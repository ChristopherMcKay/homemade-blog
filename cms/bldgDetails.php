<?php

    require_once('../conn/connApts.php');

    // "get" the building ID from the URL
    $bldgID = $_GET['bldgID'];

    // CRUD (Create - Read - Update - Delete)

    // SQL CRUD (INSERT INTO - SELECT FROM - UPDATE - DELETE)

    // use the building ID in the URL to get all the information about the building
    $query = "SELECT * FROM buildings WHERE IDbldg = $bldgID";

    $result = mysqli_query($conn, $query);

    // error checking the SQL query
    if ($result == false) {
        echo mysqli_error($conn);
        exit();
    }

    // get the one and only result 
    $row = mysqli_fetch_array($result);

?>

<!DOCTYPE html>
<html lang="en-us">
    
<head>
    
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $row['bldgName']; ?> Building Details | Lofty Heights</title>
  <link rel="stylesheet" href="../css/apts.css">
    
</head>
    
<body style="background-color:#DDD">
        
  <form name="form1" id="form1" method="post" action="bldgDetailsProc.php">
      
        <input type="hidden" name="IDbldg" id="IDbldg" value="<?php echo $bldgID; ?>"> 
    
    <article class="property building">
        
        <h1>ID: <?php echo $bldgID; ?> - 
            
          <input type="text" name="bldgName" value="<?php echo $row['bldgName']; ?>" style="font-size:2rem; font-weight:bold; padding:3px; text-align:center; color:#DDD; width:350px;">
            
        </h1>
        
        <p>
            <img src="../images/propPics/<?php echo $row['bldgPic']; ?>">
        </p>
        
        <section class="property-info">
            
            Building Description:
                <p>
                    <textarea name="bldgDesc" id="bldgDesc" rows="5" 
                      style="font-size:1rem; padding:3px; width:600px;"><?php echo $row['bldgDesc']; ?>
                    </textarea>
                </p>
            
            <p>
                <strong>Address: </strong>
                <input type="text" name="address" value="<?php echo $row['address']; ?>" style="font-size:1rem; padding:3px; width:400px;">
                
                
             <br/>
                
                <strong>Phone: </strong>
                <input type="text" name="phone" value="<?php echo $row['phone']; ?>" style="font-size:1rem; padding:3px; width:200px; margin:10px">
                
            <br/>
                
                <strong>Phone: </strong>
                <input type="text" name="email" value="<?php echo $row['email']; ?>" style="font-size:1rem; padding:3px; width:300px; margin:10px">
                
            </p>
            
            <p>
                <strong>Floors: </strong>
                <input type="text" name="floors" value="<?php echo $row['floors']; ?>" style="font-size:1rem; padding:3px; width:30px; margin:10px">
                
             &nbsp; &nbsp; &nbsp; &nbsp; 
                
                <strong>Year Built: </strong>
                <input type="text" name="yearBuilt" value="<?php echo $row['yearBuilt']; ?>" style="font-size:1rem; padding:3px; width:50px; margin:10px">
            </p>
            
            <p>
                <strong>Amenities: </strong><br>
                
                <label>
                    <input type="checkbox" class="cb" name="pets" value="pets"
                           <?php if($row['isPets'] == 1) { echo 'checked'; } ?>> Pet-Friendly
                </label>
                
                <label>
                    <input type="checkbox" class="cb" name="doorman" value="doorman" <?php if($row['isDoorman'] == 1) { echo 'checked'; } ?>> Doorman
                </label>
                
                <label>
                    <input type="checkbox" class="cb" name="parking" value="parking" <?php if($row['isParking'] == 1) { echo 'checked'; } ?>> Parking
                </label>
          
                <label>
                    <input type="checkbox" class="cb" name="gym" value="gym" <?php if($row['isGym'] == 1) { echo 'checked'; } ?>> Fitness Center
                </label>
                
            </p>
            
            <p>
                    <button style="background-color:green; padding:5px 20px; font-weight:bold; font-size:1rem; color:white;">Save Changes</button>
                    
                     &nbsp;  &nbsp;  &nbsp;  &nbsp; 
                    
                    <button type="button" onclick="window.history.back()">Back To Search Results</button>
                    
                </p>
            
        </section>
        
    </article>
      
  </form>

  <script>

     const mainPic = document.getElementById('mainPic');

     function swapPic() {
        mainPic.src = event.target.src;
     }

  </script>

</body>
    
</html>