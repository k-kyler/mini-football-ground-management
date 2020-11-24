<?php
    require_once('../Config/config.php');

    if (isset($_POST['deleteSubmit'])) {
        $db = getDatabase();

        // Current booking user real name and phone
        $userRealNameAndPhone = $_POST['selectUserRealName'];

        // Get current booking user phone
        $userRealNameAndPhone = strrev($userRealNameAndPhone);
        $userPhone = strrev(substr($userRealNameAndPhone, 0, strpos($userRealNameAndPhone, " - ")));

        // Get current booking user id by phone
        $getUserData = getIdByUserPhone($userPhone);
        $userData = $getUserData -> fetch_assoc();
        $userId = $userData['user_id'];

        // Current booking date
        $bookingDate = $_POST['dateChooseForm'];

        // Delete from database
        $bookingDateDelete = mysqli_escape_string($db, $bookingDate);
        $userId = mysqli_escape_string($db, $userId);

        $sqlQuery = "delete from bookingdetails where user_id = '$userId' and booking_date = '$bookingDateDelete'";

        $result = $db -> query($sqlQuery);

        // Announcement session
        $_SESSION['booking-success'] = "Đã hủy lịch đặt sân!";

        // Redirect back
        header("Location: ../management.php?datechoose=$bookingDate&m=bookingground_payment");
    }
?>