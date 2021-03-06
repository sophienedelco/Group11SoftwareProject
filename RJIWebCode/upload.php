<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Logistics &mdash; Colorlib Website Template</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,700,900|Display+Playfair:200,300,400,700"> 
    <link rel="stylesheet" href="fonts/icomoon/style.css">

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/magnific-popup.css">
    <link rel="stylesheet" href="css/jquery-ui.css">
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">

    <link rel="stylesheet" href="css/bootstrap-datepicker.css">

    <link rel="stylesheet" href="fonts/flaticon/font/flaticon.css">



    <link rel="stylesheet" href="css/aos.css">

    <link rel="stylesheet" href="css/style.css">
    
  </head>
  <body>
  
  <div class="site-wrap">

    <div class="site-mobile-menu">
      <div class="site-mobile-menu-header">
        <div class="site-mobile-menu-close mt-3">
          <span class="icon-close2 js-menu-toggle"></span>
        </div>
      </div>
      <div class="site-mobile-menu-body"></div>
    </div>
    
    <header class="site-navbar py-3" role="banner">

      <div class="container">
        <div class="row align-items-center">
          
          <div class="col-11 col-xl-2">
            <h1 class="mb-0"><a href="home.html" class="text-white h2 mb-0">ImageEvolve</a></h1>
          </div>
          <div class="col-12 col-md-10 d-none d-xl-block">
            <nav class="site-navigation position-relative text-right" role="navigation">

              <ul class="site-menu js-clone-nav mx-auto d-none d-lg-block">
                <li><a href="home.html">Home</a></li>
              </ul>
            </nav>
          </div>


          <div class="d-inline-block d-xl-none ml-md-0 mr-auto py-3" style="position: relative; top: 3px;"><a href="home.html" class="site-menu-toggle js-menu-toggle text-white"><span class="icon-menu h3"></span></a></div>

          </div>

        </div>
      </div>
      
    </header>

  

    <div class="site-blocks-cover inner-page-cover overlay" style="background-image: url(https://www.sfsarch.com/images/projects/murji_projects_exterior_01_web.jpg);" data-aos="fade" data-stellar-background-ratio="0.5">
      <div class="container">
        <div class="row align-items-center justify-content-center text-center">

          <div class="col-md-8" data-aos="fade-up" data-aos-delay="400">
            <h1 class="text-white font-weight-light text-uppercase font-weight-bold">Image Processing Alorithm</h1>
            <p class="breadcrumb-custom" ><a href="blog.html">Home</a> <span class="mx-2">&gt;</span> <span>Image Processing</span></p>
          </div>
        </div>
      </div>
    </div>  

    
  
    <div class="site-section">
      <div class="container">
        <div class="row align-items-center justify-content-center text-center">
          <form action="upload.php" method="post" enctype="multipart/form-data">
          Select Image:
          <input name="filesToUpload[]" type="file" multiple="multiple"/>
          <input class="btn btn-primary py-3 px-5 text-white" type="submit" value="Process" name="submit"/>
          </form>
        </div>
      </div>
    </div>

<?php

$servername = "group11db.cot1rkpint0n.us-east-1.rds.amazonaws.com";
$username = "user";
$password = "dbpassword";
$db = "group11DB";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $db);

// Check connection
if (!$conn) {
   die("Connection failed: " . mysqli_connect_error());
}
echo "Connected successfully";

$total = count($_FILES['filesToUpload']['name']);
$target_dir = "uploads/";
echo "<td style='font-size:1.25em;text-align:center;'>". $total . " files";
// Loop through each file
for( $i=0 ; $i < $total ; $i++ ) {
    echo "<br/>";
    
    // Get the temp file path
    $tmpFilePath = $_FILES['filesToUpload']['tmp_name'][$i];
    // Make sure we have a file path
    if ($tmpFilePath != "") {
        
        // Setup our new file path
  $filename = basename($_FILES['filesToUpload']['name'][$i]);
        $newFilePath = $target_dir . $filename;
        // Upload the file into the temp dir
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($newFilePath,PATHINFO_EXTENSION));
        // Check if image file is a actual image or fake image
        if (isset($_POST['submit'])) {
            $check = getimagesize($tmpFilePath);
            if($check !== false) {
                
                $uploadOk = 1;
            } else {
                echo "File is not an image. ";
                $uploadOk = 0;
            }
        }
        
        // Check if file already exists
        if (file_exists($newFilePath)) {
            echo "Sorry, file already exists. ";
            $uploadOk = 0;
        }
        
        // Check file size
        if ($_FILES["filesToUpload"]["size"][$i] > 100000000) {
            echo "Sorry, your file is too large. ";
            $uploadOk = 0;
        }
        
        // Allow certain file formats
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed. ";
            $uploadOk = 0;
        }
        // Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded. ";
        } 
        
        // Upload the file into the temp dir
        else {
            if (move_uploaded_file($tmpFilePath, $newFilePath)) {
                
                $technical = shell_exec("bash ./getScoreTechnical.sh $filename");
                $technical = substr($technical,-7,-3);
				//echo  ": technical ". $technical . " / 10. ";
        
                $aesthetic = shell_exec("bash ./getScoreAesthetic.sh $filename");
				$aesthetic = substr($aesthetic,-7,-3);
                		//echo  "aesthetic ". $aesthetic . " / 10. ";

		echo "<table border-style=none  width='100%' >";
                echo "<td width='350'>" . $title . "</td>";
                echo "<td><img src='/uploads/".$filename."'alt='".$filename."' width='200' height='150'></td>";
                echo "<td style='font-size:1.25em;text-align:center;'> <- technical score is ". $technical . " / 10 and aesthestic score is ". $aesthetic . " / 10 ";
		echo "</table>";
            }
            else {
                echo "Sorry, there was an error uploading your file. ";
            }
        }
    }
}
echo "<br/>";

mysqli_close($conn);
?>
<footer class="site-footer">
      <div class="container">
        <div class="row">
          <div class="col-md-9">
            <div class="row">
              <div class="col-md-3">
                <h2 class="footer-heading mb-4">Quick Links</h2>
                <ul class="list-unstyled">
                  <li><a href="#">About Us</a></li>
                  <li><a href="#">Contact Us</a></li>
                </ul>
              </div>
              <div class="col-md-3">
                <h2 class="footer-heading mb-4">Features</h2>
                <ul class="list-unstyled">
                  <li><a href="#">About Us</a></li>
                  <li><a href="#">Contact Us</a></li>
                </ul>
              </div>
              <div class="col-md-3">
                <h2 class="footer-heading mb-4">Follow Us</h2>
                <a href="#" class="pl-0 pr-3"><span class="icon-facebook"></span></a>
                <a href="#" class="pl-3 pr-3"><span class="icon-twitter"></span></a>
                <a href="#" class="pl-3 pr-3"><span class="icon-instagram"></span></a>
                <a href="#" class="pl-3 pr-3"><span class="icon-linkedin"></span></a>
              </div>
            </div>
          </div>
        </div>
        <div class="row pt-5 mt-5 text-center">
          <div class="col-md-12">
            <div class="border-top pt-5">
            <p>
            <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
            Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="icon-heart" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank" >Colorlib</a>
            <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
            </p>
            </div>
          </div>
          
        </div>
      </div>
    </footer>
  </div>

  <script src="js/jquery-3.3.1.min.js"></script>
  <script src="js/jquery-migrate-3.0.1.min.js"></script>
  <script src="js/jquery-ui.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/owl.carousel.min.js"></script>
  <script src="js/jquery.stellar.min.js"></script>
  <script src="js/jquery.countdown.min.js"></script>
  <script src="js/jquery.magnific-popup.min.js"></script>
  <script src="js/bootstrap-datepicker.min.js"></script>
  <script src="js/aos.js"></script>

  <script src="js/main.js"></script>
    
  </body>
</html>
