<?php

// import connection code
require_once('conn/connApts.php');

// extract (always defined) form data
$bdrms     = $_GET['bdrms'];
$baths     = $_GET['baths'];
$maxRent   = $_GET['maxRent'];
$minRent   = $_GET['minRent'];
$IDbldg    = $_GET['IDbldg'];
$orderBy   = $_GET['orderBy'];
$ascDesc   = $_GET['ascDesc'];
$rowsPerPg = $_GET['rowsPerPg'];

// build the SQL query
$query = "SELECT * FROM apartments, buildings
          WHERE apartments.bldgID=buildings.IDbldg
          AND rent <= $maxRent
          AND rent >= $minRent";

if ($IDbldg != -1) {
    $query .= " AND IDbldg = $IDbldg";
}

// if bedrooms choice is not "Any", then add query filter
if ($bdrms != -1) {
    // if the choice is + (.1) or exact match
    if ($bdrms == round($bdrms)) {
        // value is an integer, so look for an exact match
        $query .= " AND bdrms = $bdrms";
    }
    else {
        // value is not an integer, so it is a + match
        $query .= " AND bdrms >= " . round($bdrms); // use the rounded value
    }
}

// if baths choice is not "Any", then add query filter
if ($baths != -1) {
    // because 1.5 is an exact match, we cannot use round
    $baths10 = $baths * 10;
    if ($baths10 % 5 == 0) {
        // baths is either an integer, or a .5 choice
        $query .= " AND baths = $baths";
    }
    else {
        $query .= " AND baths >= " . ($baths - 0.1);
    }
    
}

// Is the user searching for anything?
if (isset($_GET['search']) && !empty($_GET['search'])) {
    // break the search string into words array, analog to js split method 
    $words = explode(' ', $_GET['search']);
    // foreach goes through every item, without having to specify the length
    foreach ($words as $word) {
        // $word becomes the current item, like $words[$i] in a for loop.
        // add keyword search filter using SQL LIKE
        // percentage sign means anything matches, so wrapping the word around percents means an include match, instead of an exact match
        // look for the word in EVERY text column
        $query .= " AND (
            apt LIKE '%$word%' OR
            aptTitle LIKE '%$word%' OR
            aptDesc LIKE '%$word%' OR
            bldgName LIKE '%$word%' OR
            address LIKE '%$word%' OR
            email LIKE '%$word%' OR
            bldgDesc LIKE '%$word%'
        )";
    }
}

if (isset($_GET['doorman'])) {
  // user checked the doorman checkbox
  $query .= " AND isDoorman = 1";
}
if (isset($_GET['pets'])) {
  $query .= " AND isPets = 1";
}
if (isset($_GET['parking'])) {
  $query .= " AND isParking = 1";
}
if (isset($_GET['gym'])) {
  $query .= " AND isGym = 1";
}

$query .= " ORDER BY $orderBy $ascDesc";


/**************** Pagination ****************/

// get the total number of results. cannot use limit
$countResult = mysqli_query($conn, $query);
$totalRows = mysqli_num_rows($countResult);

// if the total count query has an error, echo the error message
if ($countResult == false) {
    echo mysqli_error($conn);
}

// round up result count divided by results per page
$pageCount = ceil($totalRows / $rowsPerPg);

// if page num is part of the URL, use it as the current page
if (isset($_GET['pageNum'])) {
    $pageNum = $_GET['pageNum'];
}
else {
    // else it must be the first page
    $pageNum = 1;
}

// index of the first result to show in current page
$startRow = ($pageNum - 1) * $rowsPerPg;

// create the URLs for the pagination links
if (isset($_GET['pageNum'])) {
    // if page num is part of the URL, then update its value using string replacement
    $firstUrl = str_replace("pageNum=$pageNum", "pageNum=1", $_SERVER['REQUEST_URI']);
    
    $prevUrl = str_replace("pageNum=$pageNum", "pageNum=" . max(1, $pageNum - 1), $_SERVER['REQUEST_URI']);
    
    $nextUrl = str_replace("pageNum=$pageNum", "pageNum=" . min($pageCount, $pageNum + 1), $_SERVER['REQUEST_URI']);
    
    $lastUrl = str_replace("pageNum=$pageNum", "pageNum=$pageCount", $_SERVER['REQUEST_URI']);
}
else {
    // page num is 1, and we need to add the pageNum var to the URL
    $firstUrl = $_SERVER['REQUEST_URI'] . '&pageNum=1';
    $prevUrl = $_SERVER['REQUEST_URI'] . '&pageNum=1';
    $nextUrl = $_SERVER['REQUEST_URI'] . '&pageNum=2';
    $lastUrl = $_SERVER['REQUEST_URI'] . "&pageNum=$pageCount";
}

// by using 'LIMIT {startIndex, count}' we can limit number of rows
$query .= " LIMIT $startRow, $rowsPerPg";

echo $query.'<br>';

// run the query in the database
$result = mysqli_query($conn, $query);

echo 'count: ' . $totalRows . '<br>';

if ($result == false) {
    echo mysqli_error($conn);
}

?>

<!DOCTYPE html>
<html lang="">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Search Results</title>
  <link rel="stylesheet" href="css/apts.css">
</head>

<body>
  
  <div id="container">
  
    <table>
    
      <tr><th colspan="13"><h1>Search Results</h1></th></tr>
      
      <!--    For guidance, look at Pg. 39

        1. Turn the 1s and 0s into yes or no.

        2. Turn bedroom 0 into 'Studio'.

        3. Change Avail to Status, with Available or Occupied as possible values.

      -->

        
        <?php 
            if (mysqli_num_rows($result) == 0) {
                echo '<tr>
                          <td colspan="15" align="center">
                            <h3>No Search Rssults Found!<br>
                            <button type="button" onclick="history.back()">
                                Search Again</button></h3>
                          </td>
                      </tr>';
            } else {
                echo '<tr>
                        <th>ID</th>
                        <th>Apt</th>
                        <th>Building</th>
                        <th>Floor</th>
                        <th>Bdrms</th>
                        <th>Baths</th>
                        <th>Rent</th>
                        <th>Sqft</th>
                        <th>Status</th>   
                        <th>Pets</th>   
                        <th>Doorman</th>   
                        <th>Parking</th>   
                        <th>Fitness</th>   
                      </tr>';          
            }
        ?>
      
      <!-- All other rows are search results supplied by php/mysql -->
      <?php while ($row = mysqli_fetch_array($result)) { ?>
          
        <tr>
          <td><?php echo $row['IDapt']; ?></td>
          <td><a href="aptDetails.php?aptID=<?php echo $row['IDapt']; ?>"><?php echo $row['apt']; ?></a></td>
          <td><a href="bldgDetails.php?bldgID=<?php echo $row['bldgID']; ?>"><?php echo $row['bldgName']; ?></a></td>
          <td><?php echo $row['floor']; ?></td>
          <td><?php if ($row['bdrms'] == 0) echo 'Studio'; else echo $row['bdrms']; ?></td>
          <td><?php echo $row['baths']; ?></td>
          <td>$<?php echo number_format($row['rent']); ?></td>
          <td><?php echo number_format($row['sqft']); ?></td>
          <td><?php if ($row['isAvail'] == 0) echo 'Occupied'; else echo 'Available'; ?></td>
          <td><?php if ($row['isPets'] == 0) echo 'No'; else echo 'Yes'; ?></td>
          <td><?php if ($row['isDoorman'] == 0) echo 'No'; else echo 'Yes'; ?></td>
          <td><?php if ($row['isParking'] == 0) echo 'No'; else echo 'Yes'; ?></td>
          <td><?php if ($row['isGym'] == 0) echo 'No'; else echo 'Yes'; ?></td>
        </tr>
      
      <?php } ?>
      
        <tr>
          <td colspan="13"><p>
              <a href="<?php echo $firstUrl; ?>">First</a>
              <a href="<?php echo $prevUrl; ?>">Previous</a>
              
              <span><?php printf('Showing %d — %d of %d total results',
                 $startRow + 1,
                 min($totalRows, $startRow + $rowsPerPg),
                 $totalRows
              ); ?></span>
              
              <a href="<?php echo $nextUrl; ?>">Next</a>
              <a href="<?php echo $lastUrl; ?>">Last</a>
          </p></td>
        </tr>
        
    </table>
  
  </div>
  
</body>
</html>