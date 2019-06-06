<?php
    // load the requested blog only -- just one record
    require_once('../conn/connBlogs.php');
    
    // "GET" the blog ID from the URL: blogArchive.php?blogID=4
    $blogID = $_GET['blogID'];
    
    // "R" for CRUD: Read just ONE record from the blogs table
    $query = "SELECT * FROM blogs, members
    WHERE blogs.mbrID = members.IDmbr
    AND IDblog = '$blogID'";

    $result = mysqli_query($conn, $query);
    
    //grab the one and only row of results -- the requested blog
    $row = mysqli_fetch_array($result);

    // QUERY #2: LOAD ALL BLOGS FOR ARCHIVE
    $query2 = "SELECT * FROM blogs, members
    WHERE blogs.mbrID = members.IDmbr
    ORDER BY blogTime DESC";

    $result2 = mysqli_query($conn, $query2);

    $title = $row['blogTitle'] . ' - Blog Archive';

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
            
            <h4>
                <a href="blogCMS.php">Post New Blog</a>
            </h4>
            
            <h4>Blog Archive</h4>
            
            <?php while($row = mysqli_fetch_array($result2)) { ?>
            
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
        
        <?php include '../includes/footer.php'; ?>
    
    </div>
    
    <?php include '../includes/scripts.php'; ?>
    
</body>
    
</html>
