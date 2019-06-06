<?php
    // get the current session if it exists.
    session_start();

    if (isset($_SESSION['user']) == false) {
      // tell the browser the page is forbidden
      header('HTTP/1.0 403 Forbidden');
    } else {
        $IDmbr = $_SESSION['IDmbr'];
        $user = $_SESSION['user'];
    }

    /* ADD STUFF FROM blog.php:
      1) HERE
      2) HTML HEAD
      3) HTML BODY
      4) END OF HTML BODY
    */
    include '../includes/login-join-proc.php';
    $title = 'Blog CMS'; // the page title, to be printed in the head include
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
            
            <?php if(isset($_SESSION['user'])) {
    
                    echo '<h4>Blog Images: Upload and Click to Use</h4>';
    
                    // load the user's pics for display in thumbs-div
                    require_once('../conn/connBlogs.php');
                    $query_imgs = "SELECT * FROM images WHERE mbrID = '$IDmbr' 
                    ORDER BY imgDate";
                    $result_imgs = mysqli_query($conn, $query_imgs);
            ?>
            
                <div name="thumbs-div" id="thumbs-div">
                    
                    <!-- THUMBS LOAD HERE -->
                    <?php
                        while($row_imgs = mysqli_fetch_array($result_imgs)) {
                            echo '<img src="../members/' . $user . '/images/' . $row_imgs['imgName'] . '" title="' . $row_imgs['imgDesc'] . '" style="height:90px; margin:5px; border-radius:0; padding:0" onclick="deployImage()">';
                        }
                    ?>
                    
                </div>
                        
                <form method="post" action="uploadImgProc.php"
                      enctype="multipart/form-data">

                    <input type="file" style="font-size:1rem; margin:10px 0 5px 0" name="fileToUpload" id="fileToUpload">

                    <br/><br/>

                    <textarea name="img-alt" id="img-alt" placeholder="Alt" style="width:90%; margin:0 0 5px 0; font-size:0.9rem" rows="2"></textarea>

                    <br/>

                    <textarea name="img-desc" id="img-desc" placeholder="Caption/Description" style="width:90%; margin:0 0 5px 0; font-size:0.9rem" rows="2"></textarea>

                    <input type="text" placeholder="Gallery/Slideshow Name" style="padding:3px; width:90%; font-size:0.9rem; margin:0 0 5px 0" name="img-gallery" id="img-gallery">

                    <br/>
                    <button style="width:90%; font-size:1rem; margin:10px">Upload</button>

                </form>
            
            <?php } ?>
            
        </aside>
        
        <main>
            
          <div style="width:90%; margin: 0 auto">
            
            <?php if(isset($_SESSION['user'])): ?>
              
                <form method="post" action="blogCMSProc.php">

                    <h1>Blog CMS</h1>

                    <h4 style="text-align:center">Author: 
                    <?php echo $_SESSION['firstName'] . ' ' . $_SESSION['lastName'] . ' (' . $_SESSION['user'] . ')'; ?>
                    </h4>

                    <textarea name="blogTitle" id="blogTitle" rows="2" placeholder="Blog Title"></textarea>

                    <textarea name="blogBlurb" id="blogBlurb" rows="2" placeholder="Blog Blurb or Secondary Title"></textarea>

                    <div id="blog-format-bar">
                        
                        <select name="h-menu" id="h-menu">
                            <option value="H" selected disabled hidden>Heading</option>
                            <option value="h1">h1</option>
                            <option value="h2">h2</option>
                            <option value="h3">h3</option>
                            <option value="h4">h4</option>
                            <option value="h5">h5</option>
                            <option value="h6">h6</option>
                        </select>
                        
                        <!-- the id values match the tag they make -->
                        <button type="button" id="p">&para;</button>
                        <button type="button" id="strong">B</button>
                        <button type="button" id="em">I</button>

                        <select name="fonts-menu" id="fonts-menu">
                            <option value="fonts" selected disabled hidden>Fonts</option>
                            <option value="cursive">Cursive</option>
                            <option value="monspace">Monospace</option>
                            <option value="sans-serif">Sans-Serif</option>
                            <option value="serif">Serif</option>
                        </select>
                        
                        <button type="button" name="link-btn" id="link-btn">
                            <i class="fas fa-link"></i>
                        </button>
                        
                        <input type="url" name="link-box" id="link-box" placeholder="link" style="padding:3px; margin:0 5px 0 0">

                        <button type="button" id="preview" style="width:60px; padding:0 5px;">Preview</button>

                    </div>

                    <div id="preview-div" style="display:none">
                        <h3>Preview of Formatting Appears Here</h3>
                    </div>

                    <textarea name="blogEntry" id="blogEntry" placeholder="Main Blog Entry"></textarea>

                    <p>
                        <button id="save-blog-btn" style="width:100%;">SAVE BLOG</button>
                    </p>

                </form>
              
            <?php else: // user is not logged in ?>
            
                <h3>You must be logged in to post a new blog</h3>
            
            <?php endif; ?>
            
          </div>
            
        </main>
        
        <?php include '../includes/footer.php'; ?>
    
    </div>
    
    <?php include '../includes/scripts.php'; ?>
    
  </body>
    
</html>
