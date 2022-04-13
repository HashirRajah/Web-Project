<?php
    include("./database/db_connect.php");
    //sql statement
    $sql = "SELECT name, street, city, googleMap_location, phone_number, email, opening_hr, closing_hr, facebook_link, instagram_link FROM restaurant_info;";
    //query statement
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $result = $conn->query($sql);
    //fetch result
    $info = $result->fetch(PDO::FETCH_ASSOC);
    //print_r($info);
    include("./database/db_disconnect.php");
?>


<footer>
    <!-- <div class="curve">
        <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
            <path d="M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5C438.64,32.43,512.34,53.67,583,72.05c69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113-14.29,1200,52.47V0Z" opacity=".25" class="shape-fill"></path>
            <path d="M0,0V15.81C13,36.92,27.64,56.86,47.69,72.05,99.41,111.27,165,111,224.58,91.58c31.15-10.15,60.09-26.07,89.67-39.8,40.92-19,84.73-46,130.83-49.67,36.26-2.85,70.9,9.42,98.6,31.56,31.77,25.39,62.32,62,103.63,73,40.44,10.79,81.35-6.69,119.13-24.28s75.16-39,116.92-43.05c59.73-5.85,113.28,22.88,168.9,38.84,30.2,8.66,59,6.17,87.09-7.5,22.43-10.89,48-26.93,60.65-49.24V0Z" opacity=".5" class="shape-fill"></path>
            <path d="M0,0V5.63C149.93,59,314.09,71.32,475.83,42.57c43-7.64,84.23-20.12,127.61-26.46,59-8.63,112.48,12.24,165.56,35.4C827.93,77.22,886,95.24,951.2,90c86.53-7,172.46-45.71,248.8-84.81V0Z" class="shape-fill"></path>
        </svg>
    </div> -->
    <div class="pt-3 px-3" id="footer">
        <div class="container-fluid text-light text-center pt-5">
            <div class="row">
                <div class="col-lg-4 px-6 text-warning">
                    <h4 class="h4">We&apos;re Open</h4>
                    <h5 class="h5 text-danger">Monday - Sunday:</h5>
                    <h6 class="h6"><?php echo $info["opening_hr"] . " AM - " . $info["closing_hr"] . " PM"; ?></h6>
                    <p class="display-6 text-danger">Hungry yet?</p>
                    <a href="order.php" class="btn btn-lg btn-outline-warning rounded-pill mb-2">Order Now</a>
                </div>
                <div class="col-lg-4 px-6">
                    <h4 class="h4 text-warning pb-2">CONTACT</h4>
                    <div class="pb-3">
                        <i class="bi bi-telephone fs-3"></i><br />
                        <?php echo $info["phone_number"]; ?>
                    </div>
                    <div class="pb-4">
                        <i class="bi bi-envelope fs-3"></i><br />
                        <?php echo $info["email"]; ?>
                    </div>
                </div>
                <div class="col-lg-4 px-6">
                    <h4 class="h4 text-warning pb-2">LOCATION</h4>
                    <div class="row">
                        <div class="col px-1">
                            <iframe class="py-2" src="<?php echo $info["googleMap_location"]; ?>" width="350" height="300" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col px-5">
                            <i class="bi bi-geo-alt fs-3"></i>
                            <?php echo "  " . $info["street"] . " " . $info["city"]; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid text-center fs-2">
            <a class="px-1" href="<?php echo $info["facebook_link"]; ?>" target="_blank"><i class="bi bi-facebook text-white-50"></i></a>
            <a class="px-1" href="<?php echo $info["instagram_link"]; ?>" target="_blank"><i class="bi bi-instagram text-white-50"></i></a>
        </div>
        <p class="lead text-center text-white-50 p-3 m-0 fs-6">Copyright &copy; <?php echo date("Y") . " " . $info["name"]; ?>. All rights reserved.</p>
    </div>
</footer>