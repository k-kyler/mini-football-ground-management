<?php
    require_once('../Config/config.php');
    require_once('../Functions/functions.php');

    if (isset($_GET['bookingid']) && isset($_GET['bookingdate'])) {
        $db = getDatabase();

        $bookingDate = $_GET['bookingdate'];

        $bookingId = $_GET['bookingid'];
        $bookingId = mysqli_escape_string($db, $bookingId);

        $sqlQuery = "update bookingdetails set booking_status = 'isPaid' where booking_id = '$bookingId'";

        $result = $db -> query($sqlQuery);

        header("Location: ../booking.php?datechoose=$bookingDate");
    }
?>