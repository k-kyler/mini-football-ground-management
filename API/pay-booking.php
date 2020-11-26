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
        $getBookingDetailData = getBookingDetailByUserId($userId);
        $data = $getBookingDetailData -> fetch_assoc();
        $bookingId = $data['booking_id'];

        // Get beverage
        $selectBeverage = $_POST['selectBeverage'];

        // Get beverage number
        $beverageNumber = $_POST['beverageNumber'];
        $beverageNumber = (int)$beverageNumber;

        // Beverage cost for insert
        $beverageCost = explode(" - ", $selectBeverage)[1];
        // $beverageCost = numfmt_parse($beverageCost) * $beverageNumber;
        $beverageCost = str_replace(",", "", $beverageCost) * $beverageNumber;

        // Beverage type
        $beverageType = explode(" - ", $selectBeverage)[0] . ' x ' . $beverageNumber;

        // Ground cost for insert
        $groundCost = $_POST['groundCost'];
        $groundCost = explode(" VNĐ", $groundCost)[0];
        // $groundCost = numfmt_parse($groundCost);
        $groundCost = str_replace(",", "", $groundCost);

        // Total cost for insert
        $totalCost = $beverageCost + $groundCost;

        // Payment status
        $paymentStatus = 'isPaid';

        // Insert into database
        $paymentId = mysqli_escape_string($db, $paymentId);
        $bookingId = mysqli_escape_string($db, $bookingId);
        $beverageType = mysqli_escape_string($db, $beverageType);
        $beverageCost = mysqli_escape_string($db, $beverageCost);
        $groundCost = mysqli_escape_string($db, $groundCost);
        $totalCost = mysqli_escape_string($db, $totalCost);
        $paymentStatus = mysqli_escape_string($db, $paymentStatus);

        $sqlQuery = "insert into payment 
                        (payment_id, booking_id, beverage_type, beverage_cost, ground_cost, total_cost, status) 
                        values 
                        ('$paymentId', '$bookingId', '$beverageType', '$beverageCost', '$groundCost', '$totalCost', '$paymentStatus')";

        $result = $db -> query($sqlQuery);

        // Announcement session
        $_SESSION['booking-success'] = "Thanh toán thành công!";

        // Redirect back
        header("Location: ../management.php?datechoose=$bookingDateSelected&m=bookingground_payment");
    }
?>