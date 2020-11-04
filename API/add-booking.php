<?php
    require_once('../Config/config.php');

    if (isset($_GET['typeuser'])) {
        $db = getDatabase();

        if (isset($_POST['oldSubmit']) && $_GET['typeuser'] == "old") {
            $userRealName = $_POST['selectUserRealName'];
            $userRealName = substr($userRealName, 0, strpos($userRealName, " - "));

            $groundName = $_POST['selectGround'];

            $bookingDate = $_POST['dateChooseForm'];
        
            // Generate booking id
            $bookingId = uniqid();
            $bookingId = mysqli_escape_string($db, $bookingId);

            // Get user id
            $getUserData = getIdByUserRealName($userRealName);
            $userData = $getUserData -> fetch_assoc();
            $userId = $userData['user_id'];
            $userId = mysqli_escape_string($db, $userId);

            // Get ground id
            $getGroundData = getIdByGroundName($groundName);
            $groundData = $getGroundData -> fetch_assoc();
            $groundId = $groundData['ground_id'];
            $groundId = mysqli_escape_string($db, $groundId);

            // Time start & end
            $bookingStart = $_POST['selectTimeStart-1'] . ":" . $_POST['selectTimeStart-2'];
            $bookingEnd = $_POST['selectTimeEnd-1'] . ":" . $_POST['selectTimeEnd-2'];
            $bookingStart = mysqli_escape_string($db, $bookingStart);
            $bookingEnd = mysqli_escape_string($db, $bookingEnd);
            
            // Booking date
            $bookingDate = mysqli_escape_string($db, $bookingDate);

            // Insert into database
            $sqlQuery = "insert into bookingdetails (booking_id, user_id, ground_id, booking_start, booking_end, booking_date) values ('$bookingId', '$userId', '$groundId', '$bookingStart', '$bookingEnd', '$bookingDate')";

            $result = $db -> query($sqlQuery);

            header("Location: ../management.php?m=bookingground_payment&datechoose=$bookingDate");
        }

        else if (isset($_POST['newSubmit']) && $_GET['typeuser'] == "new") {

        }

    }
?>