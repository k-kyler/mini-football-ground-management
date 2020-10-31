<?php
    require_once('../Config/config.php');

    if (isset($_GET['bookingid']) && isset($_GET['bookingdate'])) {
        $db = getDatabase();

        $bookingDate = $_GET['bookingdate'];
        $bookingId = $_GET['bookingid'];
        $bookingId = mysqli_escape_string($db, $bookingId);

        $sqlQuery = "delete from bookingdetails where booking_id = '$bookingId'";

        $result = $db -> query($sqlQuery);

        header("Location: ../management.php?datechoose=$bookingDate&m=bookingground_payment");
    }
?>