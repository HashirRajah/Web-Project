<?php
    //start session
    session_start();


    $title = "View Reservation";
    $moreStyle = true;
    $styleSheetNames = ["view-order.css"];

    include_once("./include/functions.php");
    include_once("./database/db_connect.php");

    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $username = $_SESSION["user-logged-in"]["username"];
   
    $sql = "SELECT * FROM reservations WHERE username = '$username' AND status = 'pending' ORDER BY date;" ;
    $result = $conn->query($sql);
            //fetch all results
    $reservations = $result->fetchAll(PDO::FETCH_ASSOC);
    //
    $sql = "SELECT * FROM reservations WHERE username = '$username' AND status <> 'pending' ORDER BY date;" ;
    $result = $conn->query($sql);
            //fetch all results
    $all_reservations = $result->fetchAll(PDO::FETCH_ASSOC);
   
 
?>


<?php include_once("./include/docStart.php"); ?>
<?php include_once("./include/navbar.php"); ?>

<!--heading-->
<br><br><br>
<div class="text-center section-heading p-5 m-0 ">
    <h2> Hello <span> <?php echo $_SESSION["user-logged-in"]["username"]; ?> </span></h2>
    <h1 class="lead">Current reservations</h1>
</div>

<div class="container-fluid text-center p-5">
    <div class="row pt-4">
        <div class="col-md-1"></div>
        <div class="col-md-10 p-3">
            <div class="row text-dark">
                <h1 class="text-uppercase">Reservations</h1>
            </div>
            <div id="message" class="p-2 m-2 rounded fs-3">
            </div>
            <?php if(count($reservations) > 0): ?>
                <div class="row">
                    <div class="container-fluid shadow m-2 p-3 bg-body rounded p-5">
                        <div>
                            <table class="table table-hover" id="order">
                                <thead>
                                    <tr class="table-warning text-uppercase">
                                        <th scope="col">date</th>
                                        <th scope="col">time-slot</th>
                                        <th scope="col">#no-of-people</th>
                                        <th scope="col">status</th>
                                        <th scope="col">cancel</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                    foreach($reservations as $reservation)
                                    { 
                                        echo '<tr>';
                                        echo '<td>' . $reservation['date'] . '</td>';
                                        echo '<td>' . $reservation['time_slot'] . '</td>';
                                        echo '<td>' . $reservation['no_of_people'] . '</td>';
                                        echo '<td>' . $reservation['status'] . '</td>';
                                        echo '<td>
                                                <svg height="25" width="25">
                                                    <circle id="' . $reservation['date'] . '" class="cancel" cx="12.5" cy="12.5" r="10" stroke="black" stroke-width="3" fill="yellow" />
                                                </svg>
                                            </td>';
                                        echo '</tr>';
                                    }//end for
                                ?> 
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            <?php if(count($all_reservations) > 0): ?>
                <div class="row">
                    <div class="container-fluid shadow m-2 p-3 bg-body rounded p-5">
                        <div>
                            <table class="table table-hover" id="order">
                                <thead>
                                    <tr class="table-warning text-uppercase">
                                        <th scope="col">date</th>
                                        <th scope="col">time-slot</th>
                                        <th scope="col">#no-of-people</th>
                                        <th scope="col">status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                    foreach($all_reservations as $reservation)
                                    { 
                                        echo '<tr>';
                                        echo '<td>' . $reservation['date'] . '</td>';
                                        echo '<td>' . $reservation['time_slot'] . '</td>';
                                        echo '<td>' . $reservation['no_of_people'] . '</td>';
                                        echo '<td>' . $reservation['status'] . '</td>';
                                        echo '</tr>';
                                    }//end for
                                ?> 
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            </div>
        </div>
        <div class="col-md-1"></div>
    </div>
</div>
<?php include_once("./include/footer.php"); ?>
<?php include_once("./include/docEnd.php"); ?>