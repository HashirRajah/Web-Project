<?php

    $loggedIn = false;
    if(isset($_SESSION["user-logged-in"])){
      $loggedIn = true;
    }

?>

<nav class="navbar navbar-dark bg-dark fixed-top">
  <div class="container-fluid">
    <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
      <span class="navbar-toggler-icon"></span>
    </button>
    <a class="navbar-brand" href="#">
      <div class="row justify-content-center align-items-center" >
        <div class="col-2 p-0 m-0"><img src="../../front-end/images/logo/logo11.png" class=" d-inline-block align-top" width="30" height="30"></div> 
        <div class="col-10 px-2 m-0 text-start">The Crazy Chef</div>
      </div>  
    </a>
    <div class="offcanvas offcanvas-start bg-dark text-white fs-3" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
      <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasNavbarLabel">The Crazy Chef</h5>
        <i type="button" class="bi bi-x-circle text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></i>
      </div>
      <div class="offcanvas-body">
        <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
          <li class="nav-item">
            <a class="nav-link <?php if($title === "Dashboard"){echo "text-warning";} ?>" aria-current="page" href="dashboard.php"><i class="bi bi-bar-chart-line-fill me-4"></i>Dashboard</a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?php if($title === "Info"){echo "text-warning";} ?>" aria-current="page" href="info.php"><i class="bi bi-info-circle me-4"></i>Info</a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?php if($title === "Manage Reviews"){echo "text-warning";} ?>" href="manage_reviews.php"><i class="bi bi-pencil-square me-4"></i>Reviews</a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?php if($title === "Reservations"){echo "text-warning";} ?>" href="reservations.php"><i class="bi bi-calendar-event me-4"></i>Reservations</a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?php if($title === "Orders"){echo "text-warning";} ?>" href="orders.php"><i class="bi bi-bag-check me-4"></i>Orders</a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?php if($title === "Menu"){echo "text-warning";} ?>" href="menu.php"><i class="bi bi-cup-straw me-4"></i>Menu</a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?php if($title === "Payments"){echo "text-warning";} ?>" href="payments.php"><i class="bi bi-cash-coin me-4"></i>Payments</a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?php if($title === "Staffs"){echo "text-warning";} ?>" href="staffs.php"><i class="bi bi-people-fill me-4"></i>Staffs</a>
          </li>
          <?php if(!$loggedIn): ?>
            <li class="nav-item">
              <a class="nav-link <?php if($title === "Login"){echo "text-warning";} ?>" href="login.php">
                <i class="bi bi-box-arrow-in-right me-4"></i>Log in
              </a>
            </li>
          <?php else: ?>
            <li class="nav-item">
              <a class="nav-link <?php if($title === "Logout"){echo "text-warning";} ?>" href="logout.php" onclick="alert('You have successfully logged out')">
                <i class="bi bi-box-arrow-left me-4"></i>Log Out
              </a>
            </li>
          <?php endif; ?>
        </ul>
      </div>
    </div>
  </div>
</nav>