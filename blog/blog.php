<?php

// load all blogs w newest first
require_once('../conn/connBlogs.php');
// get the vars from the blogCMS.php Blog CMS form


include '../includes/login-join-proc.php';

// "R" for CRUD: Read all records from the blogs table
$query = "SELECT * FROM blogs, members
WHERE blogs.mbrID = members.IDmbr 
ORDER BY blogTime DESC";

$result = mysqli_query($conn, $query);

//grab the first row of results -- this is the latest blog
$row = mysqli_fetch_array($result);

$title = 'Blog'; // the page title, to be printed in the head include

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
            
            <article>
            
                <h1>Blog entries</h1>
                <h2><?php echo $row['blogTitle']; ?></h2>
                <h3><?php echo $row['blogBlurb']; ?></h3>
                
                <img src="../images/00-coming-soon.png" style="float:left; width:120px; margin:10px; border:1px solid #333;">
                
                <h4>by <?php echo $row['firstName'] . ' ' . $row['lastName']; ?></h4>
                <h5><?php echo date('D. M. d, Y - h:i A', strtotime($row['blogTime'])); ?></h5>
                <hr/>
                
                <div id="blogEntry">
                    <?php echo $row['blogEntry']; ?>
                </div>
            
            </article>
            
        </main>
        
        <aside>
            
            <?php 
                if(isset($_SESSION['user'])) {
                   echo '<h4>
                        <a href="blogCMS.php">Post New Blog</a>
                    </h4>';
                }
            ?>
            
            <h4>Blog Archive</h4>
            
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
            
        </aside>
        
        <!-- TURN THIS FOOTER INTO AN INCLUDE -->
        <?php include '../includes/footer.php'; ?>
        
    </div>
    
    <?php include '../includes/scripts.php'; ?>
    
</body>
    
</html>
