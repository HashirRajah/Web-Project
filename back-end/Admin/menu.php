<?php
    //start session
  
    session_start();
    //page info
    $moreStyle = true;
    $styleSheetNames = ["editMenu.css"];
    $scripts = ["getMenu.js"];
    $title = "Menu";
    //imports
    
    
?>
<?php include_once("./include/docStart.php"); ?>
<?php include_once("./include/navbar.php")?>
<br />
<br />

    

    <!--items-->
    <!--Starters-->
    <div class="heading2 px-5 pt-5 m-0 d-flex align-items-center justify-content-center">  
        <h3>&mdash; EDIT MENU &mdash; </h3>
    </div>
    <div class="heading2 py-2 m-0 d-flex align-items-center justify-content-center">  
        <img id="add-item" src="./images/plus.png" alt="+">
    </div>
    <div class="heading2 p-3 m-0">  
        <div id="message" class="p-2 m-2 rounded <?php if(isset($_GET["message"])){ echo 'bg-success fs-4 lead text-white'; } ?>"><?php if(isset($_GET["message"])){ echo htmlspecialchars($_GET["message"]); } ?></div>
    </div>
    <div class="heading p-3 m-0 d-flex align-items-center justify-content-center">  
        <h3>&mdash; STARTERS &mdash; </h3>
    </div>
    <div class="menu bg-light py-5" id="starters">
       
    </div>
    <!--Main courses-->
    <div class="heading p-5 m-0 d-flex align-items-center justify-content-center text-uppercase">  
        <h3>&mdash; main course &mdash; </h3>
    </div>
    <div class="menu bg-light py-5" id="main-course">
       
    </div>
    <!--desserts-->
    <div class="heading p-5 m-0 d-flex align-items-center justify-content-center text-uppercase">  
        <h3>&mdash; desserts &mdash; </h3>
    </div>
    <div class="menu bg-light py-5" id="dessert">
        
    </div>
    <!--drinks-->
    <div class="heading p-5 m-0 d-flex align-items-center justify-content-center text-uppercase">  
        <h3>&mdash; drinks &mdash; </h3>
    </div>
    <div class="menu bg-light py-5" id="drinks">
       
    </div>


<?php include_once("./include/docEnd.php"); ?>