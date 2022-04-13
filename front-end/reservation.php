<?php
    //make sure user is logged in
    session_start();
    //
    if(!isset($_SESSION["user-logged-in"])){
        header("Location: login.php?destination=reservation");
        die();
    }
    //page title
    $title = "Reservation";
    $moreStyle = true;
    $styleSheetNames = ["reservation.css"];
    //db connection
    include_once("./database/db_connect.php");
    //times
    $sql = "SELECT opening_hr, closing_hr FROM restaurant_info;";
    //query statement
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $result = $conn->query($sql);
    //fetch result
    $operatingHours = $result->fetch(PDO::FETCH_ASSOC);
    //timeSlots
    $timeSlot = strtotime($operatingHours["opening_hr"]);
    $closingTime = strtotime($operatingHours['closing_hr']);

    //data
    if(!isset($_POST["find-another-table"])){
        $data = array("date" => date('Y-m-d'), "time" => date("G:i:s", $timeSlot), "partySize" => 1);
    } else {
        $data = array("date" => $_SESSION["reservation-data"]["date"], "time" => $_SESSION["reservation-data"]["time"], "partySize" => $_SESSION["reservation-data"]["partySize"]);
    }
    $errors = array("dateErr" => "", "timeErr" => "", "partySizeErr" => "");
    //initially no tables found
    $foundTable = false;
    $NoTableAvailable = false;

    //validations
    if(isset($_POST["submit"])){
        $data["date"] = $_POST["date"];
        $data["time"] = $_POST["time-slot"];
        $data["partySize"] = $_POST["party-size"];
        //time and date validation
        if($data["date"] === date('Y-m-d') && strtotime($data["time"]) < (strtotime(date("G:i:s")) + (strtotime("03:00:00") - strtotime("00:00:00")))){
            $errors["timeErr"] = "Invalid time!";
        }
        //date
        if($data["date"] < date('Y-m-d')){
            $errors["dateErr"] = "Invalid date!";
        }
        //party size
        if($data["partySize"] < 1 || $data["partySize"] > 16 ){
            $errors["partySizeErr"] = "Invalid party size!";
        }
        
        //finding a table
        if(!array_filter($errors)){
            $_SESSION["reservation-data"] = $data;
            //tables close to number of people
            //min number of table algorithm
            $sql = "SELECT * FROM table_arrangement;";
            $result = $conn->query($sql);
            //fetch result
            $tables = $result->fetchAll(PDO::FETCH_ASSOC);
            //tables already in use
            $sql = "SELECT table_for, SUM(qty) AS sum_tables FROM tables_used WHERE id IN (SELECT id FROM reservations WHERE date = '{$data['date']}' AND time_slot = '{$data['time']}') GROUP BY table_for ORDER BY table_for;";
            $result = $conn->query($sql);
            //fetch result
            $used_tables = $result->fetchAll(PDO::FETCH_ASSOC);
            //fill arrays
            $seatings = array();//{2, 4, 6}
            $available = array();//{16 - sum, 7-sum, 5-sum}
            $value;
            foreach($tables as $table){
                $value = 0;
                array_push($seatings, $table["seating_for"]);
                //
                foreach($used_tables as $used_table){
                    if($used_table["table_for"] == $table["seating_for"]){
                        $value = $used_table["sum_tables"];
                        break;
                    }
                }
                array_push($available, ($table["qty"] - $value));
            }
            // print_r($seatings);
            // echo "<br />";
            // print_r($available);
            // echo "<br />";
            //tables to be used
            
            
            
            //
            include_once("./include/functions.php");
            $minTables = array();
            array_push($minTables, 0, 1);
            for($a = 2;$a <= $data["partySize"];$a++){
                array_push($minTables, recursiveFindMinTable($seatings, $available, $a));
            }
            
            //echo $minTables[sizeof($minTables) - 1];
            //tracing back
            $minTablesUsed = array();
            $used;
            $cost;
            if($minTables[sizeof($minTables) - 1] == 1){
                for($i = 0;$i < sizeof($seatings);$i++){
                    if(sizeof($minTables) - 1 == $seatings[$i] || sizeof($minTables) - 1 < $seatings[$i]){
                        $used = $seatings[$i];
                        break;
                    }
                }
                array_push($minTablesUsed, $used);
            } else {
                $cost = $minTables[sizeof($minTables) - 1];
                $a = sizeof($minTables) - 1;
                $b = sizeof($minTables) - 2;
                while($cost > 0){
                    for($b;$b >= 0;$b--){
                        if($minTables[$a] - $minTables[$b] == 1){
                            $cost--;
                            for($i = 0;$i < sizeof($seatings);$i++){
                                if($seatings[$i] >= ($a - $b)){
                                    $used = $seatings[$i];
                                    break;
                                }
                            }
                            $a = $b;
                            $b--;
                            break;
                        }
                    }
                    array_push($minTablesUsed, $used);
                }
                
            }
            //print_r($minTablesUsed);
            //place available
            if(array_sum($minTablesUsed) >= $data["partySize"]){
                $foundTable = true;
                $_SESSION["tables-used"] = array();
                $table_for = array();
                $qty = array();
                $found = false;
                for($i = 0;$i < sizeof($minTablesUsed);$i++){
                    for($j = 0;$j < sizeof($table_for);$j++){
                        if($minTablesUsed[$i] == $table_for[$j]){
                            $found = true;
                            $qty[$j]++;
                            break;
                        }
                    }
                    if(!$found){
                        array_push($table_for, $minTablesUsed[$i]);
                        array_push($qty, 1);
                    } else {
                        $found = false;
                    }
                }
                //
                for($j = 0;$j < sizeof($table_for);$j++){
                    $_SESSION["tables-used"] += array($table_for[$j] => $qty[$j]);
                }
                //print_r($_SESSION["tables-used"]);
            } else {
                $NoTableAvailable = true;
            }
            
        }
    }
    
    if(isset($_POST["book-table"])){
        //insert in reservations and tables used
        $reservationInsert = "INSERT INTO reservations(date, time_slot, no_of_people, status, username) VALUES(?,?,?,?,?);";
        $reservationStatus = 'pending';
        $stmt_1 = $conn->prepare($reservationInsert, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $stmt_1->bindParam(1, $_SESSION["reservation-data"]["date"]);
        $stmt_1->bindParam(2, $_SESSION["reservation-data"]["time"]);
        $stmt_1->bindParam(3, $_SESSION["reservation-data"]["partySize"]);
        $stmt_1->bindParam(4, $reservationStatus);
        $stmt_1->bindParam(5, $_SESSION["user-logged-in"]["username"]);
        
        //
        $tablesUsedInsert = "INSERT INTO tables_used(id, table_for, qty) VALUES(?,?,?);";
        $stmt_2 = $conn->prepare($tablesUsedInsert, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        //transaction begin
        $conn->beginTransaction();
        $status = $stmt_1->execute();
        if(!$status){
            $conn->rollBack();
            die();
        }
        //retreive id
        $sql = "SELECT MAX(id) AS id FROM reservations;";
        $result = $conn->query($sql);
        //fetch result
        $id = $result->fetch(PDO::FETCH_ASSOC);
        foreach($_SESSION["tables-used"] as $key => $val){
            $stmt_2->bindParam(1, $id["id"]);
            $stmt_2->bindParam(2, $key);
            $stmt_2->bindParam(3, $val);

            $status = $stmt_2->execute();
            if(!$status){
                $conn->rollBack();
                die();
            }
        }
        //transaction end
        $conn->commit();

        //head to home
        header("Location: index.php?reservation=booked");
        die();
    }
    //disconnect db
    include_once("./database/db_disconnect.php");
?>


<?php include_once("./include/docStart.php"); ?>
<?php include_once("./include/navbar.php"); ?>


<div class="container-fluid text-center bg-dark background-image p-5">
    <div class="row pt-4">
        <div class="col-md-3"></div>
        <div class="col-md-6 p-3">
            <div class="row text-white">
                <h1 class="text-uppercase ">find a table</h1>
                <p class="lead fw-bold m-0 text-danger">Your accounts's email and phone number will be used for contacting purposes. Make sure to update them if neccessary.</p>
                <a href="edit_profile.php?destination=reservation" class="link-warning">Update account</a>
                <p class="lead fw-bold text-danger"> All the star (*) marked boxes must be filled up.</p>
            </div>
            <div class="row">
                <div class="container-fluid shadow m-2 p-3 bg-body rounded p-5">
                    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                        <div class="container text-start">
                            <?php if(!$foundTable && !$NoTableAvailable): ?>
                                <!-- date -->
                                <label for="date" class="form-label text-left">Select a date:</label>
                                <span class="text-danger fw-bold">*</span>
                                <input type="date" name="date" id="date" class="form-control mb-2"  value="<?php echo $data['date']; ?>" min="<?php echo $data['date']; ?>" required/>
                                <div class="text-danger"><?php echo $errors["dateErr"]; ?></div>
                                <!-- time -->
                                <label for="time-slot" class="form-label">Pick a time-slot:</label>
                                <span class="text-danger fw-bold">*</span>
                                <select name="time-slot" id="time-slot" class="form-select mb-2" required>
                                    <?php while($timeSlot < $closingTime): ?>
                                        <option value="<?php echo date('G:i:s', $timeSlot); ?>" <?php if(date('G:i:s', $timeSlot) === $data["time"]) {echo "selected";} ?>><?php echo date('G:i', $timeSlot); ?></option>
                                        <?php $timeSlot += (strtotime("00:30:00") - strtotime("00:00:00")); ?>
                                    <?php endwhile; ?>
                                </select>
                                <div class="text-danger"><?php echo $errors["timeErr"]; ?></div>
                                <!-- party size -->
                                <label for="party-size" class="form-label">Party size</label>
                                <span class="text-danger fw-bold">*</span>
                                <input type="number" class="form-control" name="party-size" id="party-size" min="1" max="16" placeholder="1" value="<?php echo $data['partySize']?>" required />
                                <div class="text-danger"><?php echo $errors["partySizeErr"]; ?></div>
                                <div class="text-center"><input type="submit" class="btn btn-primary btn-lg rounded-pill mt-4" name="submit" value="FIND TABLE"></div>
                            <?php elseif($foundTable): ?>
                                <div class="text-center">
                                    <h1 class="text-uppercase text-danger">table found</h1>
                                    <input type="submit" class="btn btn-primary btn-lg rounded-pill mt-4" name="book-table" value="BOOK TABLE">
                                </div>
                            <?php elseif($NoTableAvailable): ?>
                                <div class="text-center">
                                    <h1 class="text-uppercase text-danger">no tables found</h1>
                                    <p class="lead text-warning fw-bold">Try another time-slot.</p>
                                    <input type="submit" class="btn btn-primary btn-lg rounded-pill mt-4" name="find-another-table" value="FIND ANOTHER TABLE">
                                </div>
                            <?php endif; ?>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-3"></div>
    </div>
</div>

<?php include_once("./include/docEnd.php"); ?>