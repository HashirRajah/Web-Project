<?php
    //start session
    session_start();
    //page info
    $title = "Admin";
    $moreStyle = true;
    $styleSheetNames = ['index.css']

?>
<?php include_once("./include/docStart.php"); ?>
<!-- <?php include_once("./include/navbar.php"); ?> -->


    
    

    <section class="main">

    <h1><span>"The&nbsp</span><span>Crazy&nbsp</span><span>Chef"</span></h1>
       

        <div class="showcase">
            <div class="ptext">
                <h2>Welcome User. Please Login to continue</h2>
            </div>
        </div>
      </section>

      <!-- <p class="subtitle">Welcome to my website!</p> -->

      <a href="login.php" class="button">LOGIN</a>
    <!-- <p class="subtitle">Please login to continue</p> -->
    
    
      





<?php include_once("./include/docEnd.php"); ?>