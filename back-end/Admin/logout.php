<?php
    //logout
    session_start();
    session_destroy();
    //
    $title = "Logout";
    header("Location: index.php?logout=success");
    die();
?>