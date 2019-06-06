<?php
require_once("../conn/connBlogs.php"); // import connection code

include '../includes/login-join-proc.php';

$q = $_GET['q'];

$query = "SELECT * FROM blogs, members
WHERE blogs.mbrID = members.IDmbr";

if(isset($_GET['q']) && !empty($_GET['q'])) {
    $words = explode(" ", $_GET['q']);
    foreach($words as $word) {
        $query .= " AND (
        blogTitle LIKE '%$word%' OR
        blogBlurb LIKE '%$word%' OR
        blogEntry LIKE '%$word%' OR
        firstName LIKE '%$word%' OR
        lastName LIKE '%$word%'
        )";
    }

}
$query .=" ORDER BY blogTime";

// **********************************
// save search results URL for pagination

// get total number of results, cannot use LIMIT
$countResult = mysqli_query($conn, $query);
$totalRows = mysqli_num_rows($countResult);
$rowsPerPage = 5; // static 5 rows per page

$totalPages = ceil($totalRows / $rowsPerPage); 


if(isset($_GET['pageNum'])) {
    $pageNum= $_GET['pageNum'];
} else {
    $pageNum = 1;
}
// index of the first result to show in current page
$startRow = ($pageNum -1) * $rowsPerPage; 

// create the URLs for the pagination links
if(isset($_GET['pageNum'])){
    // if pageNum is part of URL then update the value using string replacement
    $firstUrl = str_replace("pageNum=$pageNum", "pageNum=1", $_SERVER['REQUEST_URI']);
    $prevUrl = str_replace("pageNum=$pageNum", "pageNum=" . max(1, $pageNum -1), $_SERVER['REQUEST_URI']);
    $nextUrl = str_replace("pageNum=$pageNum", "pageNum=" . min($totalPages, $pageNum +1), $_SERVER['REQUEST_URI']);
    $lastUrl = str_replace("pageNum=$pageNum", "pageNum=$totalPages", $_SERVER['REQUEST_URI']);
} else {
    // page num is 1 and we need to add pageNum var to URL
    $firstUrl = $_SERVER['REQUEST_URI'] . '&pageNum=1';
    $prevUrl = $_SERVER['REQUEST_URI'] . '&pageNum=1';
    $nextUrl = $_SERVER['REQUEST_URI'] . '&pageNum=2';
    $lastUrl = $_SERVER['REQUEST_URI'] . "&pageNum=$totalPages";

}

// by using 'LIMIT {number}' we can limit number of rows
$query .= " LIMIT " . ($pageNum-1) * $rowsPerPage . ", " . $rowsPerPage; 


$result = mysqli_query($conn, $query);



if(!$result) {
    echo mysqli_error($conn);
    echo $query;
}

?>
<!DOCTYPE html>
<html lang="en-us">
    
<?php include '../includes/head.php'; ?>

<body>
    
    <?php include '../includes/login-join.php'; ?>
  
    <?php include '../includes/nav.php'; ?>
    
    <div id="container">
    
        <?php include '../includes/mobile-nav.php'; ?>
      
        <?php include '../includes/header.php'; ?>
    
        <main>

            <h1>
                <?= $totalRows ?>  search results containing: <br/>
                <span style="color:white;"><?php echo $q ?></span>  
            </h1>
            <br/>
            

            
            <article>
            
                <?php while($row = mysqli_fetch_array($result)) { ?>
            
                    <p>
                        <a href="blogArchive.php?blogID=<?php echo $row['IDblog']; ?>">
                            
                            <?php echo $row['blogTitle']; ?>
                        </a>
                        <br/>
                            by <?php echo $row['firstName'] . ' ' . $row['lastName']; ?><br/>
                            
                            <?php echo date('D. M. d, Y - h:i A', strtotime($row['blogTime'])); ?><br/>
                    </p>
                    <hr/>
        
                <?php } ?>
                <br/>
                
            </article>
            
            <p style="justify-content: center; display: flex;">
                  
                <?php 
                    if ($pageNum != 1) {
                    echo '<a href="' . $firstUrl . '">First</a> &nbsp &nbsp;
                    <a href="' . $prevUrl .'"> Previous </a> &nbsp &nbsp;';
                }
                ?>

                <?php 
                if($pageNum != $totalPages) {    
                    echo '<a href="' . $nextUrl . '"> Next </a> &nbsp &nbsp;
                    <a href="' . $lastUrl .'">Last </a>';
                }
                ?>
                    
            </p>
            <br/>
            <p>
                <h4 id="currentPage"> Current Page: <?= $pageNum ?> of <?= $totalPages ?>   </h4>
            </p>
            <br/>
            
        </main>
        
        <aside>   
        
    
        
                
                
            
        </aside>
        
      <?php include '../includes/footer.php'; ?>        
    
    </div><!-- #container -->
    
    <?php include '../includes/scripts.php'; ?>
    
</body>
    
</html>