<?php
    require_once('../Config/config.php');

    if (isset($_POST['paySubmit'])) {
        $db = getDatabase();

        // Current booking user real name and phone
        $userRealNameAndPhone = $_POST['selectUserRealName'];

        // Get current booking user phone
        $userRealNameAndPhone = strrev($userRealNameAndPhone);
        $userPhone = strrev(substr($userRealNameAndPhone, 0, strpos($userRealNameAndPhone, " - ")));

        // Current booking date
        $bookingDateSelected = $_POST['dateChooseForm'];

        // Get current booking user id by phone
        $getUserData = getIdByUserPhone($userPhone);
        $userData = $getUserData -> fetch_assoc();
        $userId = $userData['user_id'];

        // Generate payment id
        $paymentId = uniqid();

        // Get booking id
        $insertBookingId = '';
        $bookingDetailsData = getBookingDetails($db);

        if ($bookingDetailsData != null && $bookingDetailsData -> num_rows > 0) {
            while ($data = $bookingDetailsData -> fetch_assoc()) {
                $bookingId = $data['booking_id'];
                $bookingDate = $data['booking_date'];
                $userIdInDatabase = $data['user_id'];

                if ($bookingDate == $bookingDateSelected && $userIdInDatabase == $userId) {
                    $insertBookingId = $bookingId;
                    break;
                }
            }
        }

        // Get beverage
        $selectBeverage = $_POST['selectBeverage'];

        // Get beverage number
        $beverageNumber = $_POST['beverageNumber'];
        $beverageNumber = (int)$beverageNumber;

        // Beverage cost for insert
        $beverageCost = explode(" - ", $selectBeverage)[1];
        $beverageCost = str_replace(",", "", $beverageCost) * $beverageNumber;

        // Beverage type
        $beverageType = explode(" - ", $selectBeverage)[0] . ' x ' . $beverageNumber;

        // Ground cost for insert
        $groundCost = $_POST['groundCost'];
        $groundCost = explode(" VNĐ", $groundCost)[0];
        $groundCost = str_replace(",", "", $groundCost);

        // Total cost for insert
        $totalCost = $beverageCost + $groundCost;

        // Insert into database
        $paymentId = mysqli_escape_string($db, $paymentId);
        $insertBookingId = mysqli_escape_string($db, $insertBookingId);
        $beverageType = mysqli_escape_string($db, $beverageType);
        $beverageCost = mysqli_escape_string($db, $beverageCost);
        $groundCost = mysqli_escape_string($db, $groundCost);
        $totalCost = mysqli_escape_string($db, $totalCost);
        $paymentStatus = mysqli_escape_string($db, $paymentStatus);
        $paymentDate = mysqli_escape_string($db, $bookingDateSelected);

        $sqlQuery1 = "insert into payments 
                        (payment_id, booking_id, beverage_type, beverage_cost, ground_cost, total_cost, payment_date) 
                        values 
                        ('$paymentId', '$insertBookingId', '$beverageType', '$beverageCost', '$groundCost', '$totalCost', '$paymentDate')";

        $result1 = $db -> query($sqlQuery1);

        $sqlQuery2 = "delete from bookingdetails where booking_id = '$insertBookingId'";

        $result2 = $db -> query($sqlQuery2);

        // Announcement session
        $_SESSION['booking-success'] = "Thanh toán thành công!";

        // Redirect back
        header("Location: ../management.php?datechoose=$bookingDateSelected&m=bookingground_payment");
    }
?>