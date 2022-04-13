<?php

    $loggedIn = false;
    if(isset($_SESSION["user-logged-in"])){
      $loggedIn = true;
    }

?>

<nav class="navbar navbar-dark bg-dark fixed-top">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">The Crazy Chef</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="offcanvas offcanvas-end bg-dark text-white fs-3" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
      <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasNavbarLabel">The Crazy Chef</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      <div class="offcanvas-body">
        <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
          <li class="nav-item">
            <a class="nav-link <?php if($title === "DashBoard"){echo "text-warning";} ?>" aria-current="page" href="index.php">Home</a>
          </li>
          <?php if(!$loggedIn): ?>
            <li class="nav-item">
              <a class="nav-link <?php if($title === "Login"){echo "text-warning";} ?>" href="login.php">Log in</a>
            </li>
          <?php else: ?>
            <li class="nav-item">
              <a class="nav-link <?php if($title === "Logout"){echo "text-warning";} ?>" href="logout.php" onclick="alert('You have successfully logged out')">Log Out</a>
            </li>
          <?php endif; ?>
          <li class="nav-item">
            <a class="nav-link <?php if($title === "Manage Reviews"){echo "text-warning";} ?>" href="manage_reviews.php">Manage Reviews</a>
          </li>
        </ul>
      </div>
    </div>
  </div>
</nav>