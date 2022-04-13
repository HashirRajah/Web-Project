<div class="offcanvas offcanvas-start bg-light" tabindex="-1" id="profile" aria-labelledby="profile-Label">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title" id="profile-Label">Profile</h5>
    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">
    <div class="container-fluid d-flex align-items-center justify-content-center">
        <div class="row text-center">
            <i class="bi bi-person-circle fs-1"></i>
            <h3 class="text-warning"><?php echo $_SESSION["user-logged-in"]["username"]; ?></h3>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row pt-5">
            <p><i class="bi bi-person-fill"></i><?php echo " " . $_SESSION["user-logged-in"]["first_name"] . " " . $_SESSION["user-logged-in"]["last_name"]; ?></p>
        </div>
        <div class="row pt-2">
            <p><i class="bi bi-envelope-fill"></i><?php echo " " . $_SESSION["user-logged-in"]["email"]; ?></p>
        </div>
        <div class="row pt-2 pb-2">
            <p><i class="bi bi-telephone-fill"></i><?php echo " " . $_SESSION["user-logged-in"]["phone_number"]; ?></p>
        </div>
    </div>
    <div class="container-fluid text-center pb-2">
        <a href="view_order.php" class="btn btn-warning">Orders</a>
    </div>
    <div class="container-fluid text-center pb-2">
        <a href="view_reservation.php" class="btn btn-warning">Reservations</a>
    </div>
    <div class="container-fluid text-center pb-5">
        <a href="add_review.php" class="btn btn-warning">Add a comment</a>
    </div>
    <div class="container-fluid d-flex align-items-center justify-content-center text-center">
        <a href="edit_profile.php" class="btn rounded-pill fs-5 shadow m-2 p-3 bg-body"><i class="bi bi-pencil-fill"></i></a>
    </div>
  </div>
</div>