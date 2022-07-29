<?php

  //check if user is logged in
  $loggedIn = false;
  if(isset($_SESSION["user-logged-in"])){
    $loggedIn = true;
  }

?>

<header>
    <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
        <div class="container-fluid px-5">
          <!-- navbar brand / title -->
          <a class="navbar-brand mb-0 h1  " href="#">
              <div class="row justify-content-center align-items-center" >
                 <div class="col-sm-6"> <img src="./images/logo/logo11.png" class=" d-inline-block align-top" width="60" height="60"></div> 
                 <div class="col-sm-6">The Crazy Chef</div>
              </div>       
              <!-- <h1 class="logotext"><span class="name">The</span><span class="second">Crazy</span><span class="name">Chef</span></h1> -->
          </a>
          <!-- toggle button for mobile nav -->
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#main-nav" aria-controls="main-nav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
    
          <!-- navbar links -->
          <div class="collapse navbar-collapse justify-content-end align-center" id="main-nav">
            <ul class="navbar-nav">
              <li class="nav-item">
                <a class="nav-link <?php if($title === "Restaurant"){echo "text-warning";} else{echo "text-white";} ?>" href="index.php">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link <?php if($title === "Menu"){echo "text-warning";} else{echo "text-white";} ?>" href="menu.php">Menu</a>
              </li>
              <li class="nav-item">
                <a class="nav-link <?php if($title === "Order"){echo "text-warning";} else{echo "text-white";} ?>" href="order.php">Order</a>
              </li>
              <li class="nav-item ">
                <a class="nav-link <?php if($title === "Reservation"){echo "text-warning";} else{echo "text-white";} ?>" href="reservation.php">Reservation</a>
              </li>
              <li class="nav-item">
                <a class="nav-link text-white" href="index.php#reviews">Reviews</a>
              </li>
              <?php if(!$loggedIn): ?>
                <li class="nav-item">
                  <a class="nav-link <?php if($title === "Login"){echo "text-warning";} else{echo "text-white";} ?>" href="login.php">Log in</a>
                </li>
              <?php else: ?>
                <li class="nav-item">
                  <a class="nav-link <?php if($title === "Logout"){echo "text-warning";} else{echo "text-white";} ?>" href="logout.php" onclick="alert('You have successfully logged out')">Log Out</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link text-info fw-bold" data-bs-toggle="offcanvas" href="#profile" role="button" aria-controls="profile"><i class="bi bi-person-circle"></i></a>
                </li>
              <?php endif; ?>
              <?php if($title === "Order"): ?>
                <li class="nav-item">
                  <a class="nav-link text-warning fw-bold" data-bs-toggle="offcanvas" href="#cart" role="button" aria-controls="cart"><i class="bi bi-cart4"><span id="cart-items-count" class="badge bg-danger rounded-pill"><?php echo $_SESSION["cart"]->getTotalItems(); ?></span></i></a>
                </li>
              <?php endif; ?>
              <!-- <li class="nav-item ms-2 d-none d-md-inline">
                <a class="btn btn-secondary" href="#pricing">buy now</a>
              </li> -->
            </ul>
          </div>
        </div>
      </nav>
</header>
<?php include_once("./profile.php"); ?>
