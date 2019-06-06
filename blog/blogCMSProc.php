<?php
    // get the current session if it exists.
    session_start();

    if(isset($_SESSION['user']) == false) {
      // tell the browser the page is forbidden
      header('HTTP/1.0 403 Forbidden');
    } else { // run the query to save new blog only if logged in
        // user is logged in so get the mbr ID
        $IDmbr = $_SESSION['IDmbr'];
        require_once('../conn/connBlogs.php');
        // get the vars from the blogCMS.php Blog CMS form
        $blogTitle = $_POST['blogTitle'];
        $blogTitle = mysqli_real_escape_string($conn, $blogTitle);
        $blogBlurb = $_POST['blogBlurb'];
        $blogBlurb = mysqli_real_escape_string($conn, $blogBlurb);
        $blogEntry = $_POST['blogEntry'];
        $blogEntry = mysqli_real_escape_string($conn, $blogEntry);

        // "C" for CRUD: Create new record in the blogs table
        $query = "INSERT INTO blogs(blogTitle, blogBlurb, blogEntry, mbrID) VALUES('$blogTitle', '$blogBlurb', '$blogEntry', '$IDmbr')";

        mysqli_query($conn, $query);
        
    } // end if-else logged in
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
        
        <aside>
            <h4>Sidebar stuff goes here</h4>
        </aside>
        
        <main>
            
            <h1>
                <?php
                    if(mysqli_affected_rows($conn) == 1) {
                        echo 'Congrats! Blog Saved!<br/>
                        <a href="blog.php">Go to Blog</a><br/>
                        <a href="blogCMS.php">Back to Blog CMS</a><br/>';
                    } else {
                        echo 'Sorry! Could Not Save Blog!<br/>
                        <a href="blogCMS.php">Back to Blog CMS</a><br/>';
                        echo mysqli_error($conn);
                    }
                ?>
            </h1>
            
        </main>
        
        <?php include '../includes/footer.php'; ?>
        
    </div><!-- end container -->
    
    <?php include '../includes/scripts.php'; ?>
    
</body>
    
</html>
