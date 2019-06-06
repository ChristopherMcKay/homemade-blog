<?php

// import connection code
require_once('conn/connApts.php');

// build the SQL query
$query = "SELECT IDbldg, bldgName FROM buildings ORDER BY bldgName ASC";

$result = mysqli_query($conn, $query);

?><!DOCTYPE html>
<html lang="">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Search Apartments | Lofty Heights</title>
  <link rel="stylesheet" href="css/apts.css">
</head>

<body>
  <div id="container">
    
    <form name="form1" id="form1" method="get" action="searchAptsProc.php">
      <table>

        <tr>
          <th colspan="2">Apartment Search</th>
        </tr>

        <tr>
          <td>Search: </td>
          <td><input type="search" name="search" id="search"></td>
        </tr>

        <tr>
          <td>Building: </td>
          <td>
            <select name="IDbldg" id="IDbldg">
              <option value="-1">Any</option>
              <?php while ($row = mysqli_fetch_array($result))
                printf('<option value="%d">%s</option>', $row['IDbldg'], $row['bldgName']); ?>
            </select>
          </td>
        </tr>

        <tr>
          <td>Number of Bedrooms: </td>
          <td>
            <select name="bdrms" id="bdrms">
              <option value="-1">Any</option>
              <option value="0">Studio</option>
              <option value="1">1 Bedroom</option>
              <option value="1.1">1+ Bedrooms</option>
              <option value="2">2 Bedrooms</option>
              <option value="2.1">2+ Bedrooms</option>
              <option value="3">3 Bedrooms</option>
            </select>
          </td>
        </tr>

        <tr>
          <td>Number of Baths: </td>
          <td>
            <select name="baths" id="baths">
              <option value="-1">Any</option>
              <option value="1">1 Bath</option>
              <option value="1.5">1.5 Baths</option>
              <option value="1.6">1.5+ Baths</option>
              <option value="2">2 Baths</option>
              <option value="2.1">2+ Baths</option>
              <option value="2.5">2.5 Baths</option>
            </select>
          </td>
        </tr>
        
        <tr>
          <td>Maximum Rent: </td>
          <td>
            <select name="maxRent" id="maxRent">
              <option value="99999">Any</option>
              <?php
                $i = 2000;
                while($i <= 10000) {
                  echo '<option value="'. $i . '">$' . number_format($i) . '</option>';
                  $i += 250;
                }
              ?>
            </select>
          </td>
        </tr>
        
        <tr>
          <td>Minimum Rent: </td>
          <td>
            <select name="minRent" id="minRent">
              <option value="0">Any</option>
              <?php
                for ($min = 1000; $min <= 5000; $min += 250) echo '<option value="'. $min . '">$' . number_format($min) . '</option>';
              ?>
            </select>
          </td>
        </tr>
        
  <!--    Lab 05, Pg. 42
    1. Make functional minumum rent menu
    2. Alert user and block submit if the min rent is greater than the max rent (use password validation code as guide)
  -->
        <tr>
          <th colspan="2">Show me only apartments in buildings with these amenities:</th>
        </tr>

        <tr>
          <td><label><input type="checkbox" class="cb" name="pets" value="pets"> Pet-Friendly</label></td>
          <td><label><input type="checkbox" class="cb" name="doorman" value="doorman"> Doorman</label></td>
        </tr>

        <tr>
          <td><label><input type="checkbox" class="cb" name="parking" value="parking"> Parking</label></td>
          <td><label><input type="checkbox" class="cb" name="gym" value="gym"> Fitness Center</label></td>
        </tr>
          
        <tr>
            <td>Order By:</td>
            <td>
                <select name="orderBy" id="orderBy">
                    <option value="bdrms">Bedrooms</option>
                    <option value="bldgName">Building</option>
                    <option value="rent" selected>Rent</option>
                    <option value="sqft">Square Feet</option>
                </select>
                <br>
                <input type="radio" name="ascDesc" value="ASC">Ascending
                <input type="radio" name="ascDesc" value="DESC">Descending
                <br>Results per page:
                <select name="rowsPerPg" id="rowsPerPg" style="width: 50px;">
                    <option value="5">5</option>
                    <option value="10" selected>10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                </select>
            </td>
        </tr>

        <tr>
          <td colspan="2"><input type="submit"></td>
        </tr>
      </table>
    </form>
    
  </div><!-- close container -->
  
  <script>
    document.querySelector('form').addEventListener('submit', function(e) {
      const min = Number(document.querySelector('#minRent').value),
            max = Number(document.querySelector('#maxRent').value);
      if (min > max) {
        alert('Min rent is greater than max rent');
        // alternative to return false for blocking event
        e.preventDefault();
      }
    })
  </script>
</body>
</html>