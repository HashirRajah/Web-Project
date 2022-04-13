<?php 
    //start session
    session_start();
    $title = "Restaurant";
    $moreStyle = true;
    $styleSheetNames = ["index.css"];

?>
<?php include("include/docStart.php"); ?>
<?php include_once("./include/navbar.php"); ?>
<!--Page content start-->
<!-- topofpage -->
<div class="container-fluid top-banner ">
    <div class=" animatecontent"> 
         <div class="container">
              <h1 class="text-warning">Life's too short for boring food</h1><br>
              <h2 class="text-white">EAT FRESH,</h2>
              <h2 class="text-white">EAT HEALTHY,</h2>
              <h2 class="text-white">EAT WITH US</h2>
              <br><br>
              <p></p>
         </div>
     </div>
     <div class=" animatecontent">
          <div class="container">
              <h1 class="text-warning">Your favourite now also delivered hot and fresh</h1>
              <a href="order.php" class="btn btn-lg btn-warning ">Order Now</a>
          </div>
    </div>
</div>
<!-- menu -->
<!-- aboutus -->
<div class="section-heading p-5 m-0 d-flex align-items-center justify-content-center">
    <h3>&mdash; ABOUT &mdash; </h3>
</div>
<div class="container-fluid bg-dark p-5"> 
    <div class="row">
        <div class="col-md-5 mb-2">
            <div class="container-fluid rounded border border-3 border-white p-0">
                <img class="img-fluid" src="images/bg/bg-5.jpg" alt="">
            </div>
        </div>
        <div class="col-md-7">
            <h2 class="text-warning mb-4">
               We pride ourselves on making real food from the best ingredients
            </h2>
            <p class="lead text-white mb-4">
                 We welcome you to sit back, unwind and appreciate the lovely sights of the ocean while our best gourment experts sets up a
                 scrumptious meal with the best and freshest ingredients. 
            </p>
        </div>
    </div>
</div>

<div class="container-fluid bg-dark p-5"> 
    <div class="row">

    <div class="col-md-7">
            <h2 class="text-warning mb-4">
               Enjoy our dazzling dishes and make the most of your eating experience with us.
            </h2>
            <p class="lead text-white mb-4">
            The Crazy Chef was established in 2020 and ever since we have been the first choice of tourist in Mauritius. Located at Grand Baie we provide 
            the utmost experience of a lively ambience for people to relax and enjoy their food.


            </p>
            <a href="" class="btn btn-lg btn-warning">Learn More</a>
        </div>

        <div class="col-md-5">
            <div class="container rounded   p-0">
                <img class="img-fluid" src="images/img/img-2.png" width= "1800%" alt="">
            </div>
        </div>
    </div>
</div>
<!-- review -->
<section id="reviews">
    <div class="section-heading p-5 m-0 d-flex align-items-center justify-content-center">
        <h3>&mdash; REVIEWS &mdash;</h3>
    </div>
</section>
<!--Page content end-->
<?php include("include/footer.php"); ?>
<?php include("include/docEnd.php"); ?>