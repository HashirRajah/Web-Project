<?php

    function sanitize_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    //algorithm
    function recursiveFindMinTable($seatings, $available, $i){
        $min = (int) ($i / $seatings[0]) + 2;
        $check = $min;
        for($j = 0;$j < sizeof($seatings);$j++){
            if($available[$j] > 0){
                $available[$j]--;
                if($i > $seatings[$j]){
                    $t = 1 + recursiveFindMinTable($seatings, $available, $i - $seatings[$j]);
                } else {
                    $t = 1;
                }
                if($t < $min){
                    $min = $t;   
                }
            }
        }
        if($min === $check){
            return 0;
        } else {
            return $min;
        }
    }
    
?>