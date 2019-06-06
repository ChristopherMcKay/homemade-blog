<?php
    // image upload proc runs on click of Upload button in Upload Img form in blogCMS.php
    session_start();
    
    if($_SESSION['user'] == false) { // not logged in
        header('HTTP/1.0 403 Forbidden'); // block
        header('Location: blogCMS.php'); // redirect
    } else { // are logged in
        require_once('../conn/connBlogs.php');
        // get the IDmbr from the session
        $IDmbr = $_SESSION['IDmbr'];
        $user = $_SESSION['user'];
        // do the upload:
        
        // 1.) get the data of the file to upload?
        $imgAlt = $_POST['img-alt'];
        $imgDesc = $_POST['img-desc'];
        $imgGallery = $_POST['img-gallery'];
        
        // the multi-part part--the image itself
        $fileName = $_FILES['fileToUpload']['name']; // cat.jpg
        $fileTemp = $_FILES['fileToUpload']['tmp_name']; // cat.jpgtype
        $fileSize = $_FILES['fileToUpload']['size']; // in Bytes
        $filePath = '../members/' . $user . '/images/' . $fileName;
        $fileType = pathinfo($fileName, PATHINFO_EXTENSION);

        // 2.) run a series of tests to see if the image is good to go
        // a Boolean-ish var to flip from good (1) to bad (0) if any test fails
        $ok = 1;
        $msg = "";
        
        // A.) is the image too big? Our limit is 5 MB
        if($fileSize > 5*1000*1000) { // 5 million bytes == 5 MB
            $ok = 0; // image is too big, so flip the "Boolean"
            $msg = "Whoa! Image file size exceeds 5.12MB Max (5120KB)! Your file is " . round($fileSize/1024) . 'KB';
        }
        
        // B.) is the file in fact an image..? Image type begins w 'image/'
        if($fileType != 'jpg' && $fileType != 'jpeg' && $fileType != 'gif' && $fileType != 'svg' && $fileType != 'png') {
            $ok = 0; // image is too big, so flip the "Boolean"
            $msg = "Hey! What gives! That's not even an image you're trying to upload!";
        }
        
        // C.) is the image already in the user's folder (already been uploaded)
        if(file_exists($filePath)) {
            $ok = 0; // image is too big, so flip the "Boolean"
            $msg = "Oops! That image has already been uploaded to the " . $user . " folder!";
        }
        
        // D.) is the image file name already in the database for this user?
        $query_img = "SELECT imgName FROM images 
        WHERE imgName = '$fileName' AND mbrID = '$IDmbr'";
        $result_img = mysqli_query($conn, $query_img);
        
        if(mysqli_num_rows($result_img) > 0) { // or mysqli_affected_rows($conn)
            $ok = 0; // image is already in the database
            $msg = "That's weird! The file name is already in the database, even though the file itself isn't in your folder yet!";
        }
        
        if($ok == 1) { // if ok is still 1 after all those tests, save and upload already!!!
        
            // 3.) save img file name to DB
            $query = "INSERT INTO images(mbrID, imgName, imgAlt, imgDesc, imgGall) VALUES('$IDmbr', '$fileName', '$imgAlt', '$imgDesc', '$imgGall')";
            mysqli_query($conn, $query);
            
            // 4.) upload the image itself to the user's folder
            // this method does the actual upload
            // path to upload image file into:
            move_uploaded_file($fileTemp, $filePath); 
            
            $msg = "<h1>Congrats! Image " . $fileName . " uploaded to<br/>" . $filePath . "<br/>File size: " . ($fileSize/1000) . "KB</h1>";
            
        } // end if $ok still == 1
        
    } // end big if-else

    echo '<h1 style="margin:2rem 0 0 2rem">' . $msg . '</h1>';

    header("Refresh: 3; url=blogCMS.php", true, 303);
    
?>