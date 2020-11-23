<?php
    require_once('../Config/config.php');

    if (isset($_GET['typeuser'])) {
        $db = getDatabase();

        if (isset($_POST['oldSubmit']) && $_GET['typeuser'] == "old") {
            // Old user real name and phone
            $userRealNameAndPhone = $_POST['selectUserRealName'];

            // Get old user phone
            $userRealNameAndPhone = strrev($userRealNameAndPhone);
            $userPhone = strrev(substr($userRealNameAndPhone, 0, strpos($userRealNameAndPhone, " - ")));

            // Ground name
            $groundNameSelected = $_POST['selectGround'];

            // Booking date
            $bookingDateSelected = $_POST['dateChooseForm'];
        
            // Generate booking id
            $bookingId = uniqid();

            // Get user id
            $getUserData = getIdByUserPhone($userPhone);
            $userData = $getUserData -> fetch_assoc();
            $userId = $userData['user_id'];

            // Get ground id
            $getGroundDataSelected = getIdByGroundName($groundNameSelected);
            $groundDataSelected = $getGroundDataSelected -> fetch_assoc();
            $groundIdSelected = $groundDataSelected['ground_id'];

            // Time start & end
            $timeStart = $_POST['selectTimeStart-1'] . ":" . $_POST['selectTimeStart-2'];
            $timeEnd = $_POST['selectTimeEnd-1'] . ":" . $_POST['selectTimeEnd-2'];

            // Check time start & end
            $checkBookingTimes = true;
            $checkBookingPhone = true;
            $bookingDetailsData = getBookingDetails($db);

            if ($bookingDetailsData != null && $bookingDetailsData -> num_rows > 0) {
                while ($data = $bookingDetailsData -> fetch_assoc()) {
                    $groundId = $data['ground_id'];
                    $userIdInDatabase = $data['user_id'];
                    $bookingStart = $data['booking_start'];
                    $bookingEnd = $data['booking_end'];
                    $bookingDate = $data['booking_date'];

                    // Get ground data
                    $getGroundData = getGroundById($groundId);
                    $groundData = $getGroundData -> fetch_assoc();
                    $groundName = $groundData['ground_name'];
                    
                    if ($bookingDate == $bookingDateSelected && $groundName == $groundNameSelected && $bookingStart == $timeStart && $bookingEnd == $timeEnd) {
                        $checkBookingTimes = false;
                    }

                    else if ($bookingDate == $bookingDateSelected && $groundName == $groundNameSelected && strtotime($timeStart) > strtotime($bookingStart) && strtotime($timeStart) < strtotime($bookingEnd)) {
                        $checkBookingTimes = false;
                    }

                    else if ($bookingDate == $bookingDateSelected && $groundName == $groundNameSelected && strtotime($timeEnd) > strtotime($bookingStart) && strtotime($timeEnd) < strtotime($bookingEnd)) {
                        $checkBookingTimes = false;
                    }

                    else if ($userIdInDatabase == $userId && $bookingDate == $bookingDateSelected) {
                        $checkBookingPhone = false;
                    }
                }
            }

            // Check if start and end time are the same
            if ($timeStart == $timeEnd) {
                $checkBookingTimes = false;
            }

            // Check and insert into database
            if ($checkBookingTimes == false) {
                $_SESSION['booking-error'] = "Khung giờ đặt sân không hợp lệ!";
            }

            else if ($checkBookingPhone == false) {
                $_SESSION['booking-error'] = "Số điện thoại đã được dùng!";
            }

            else {
                $bookingId = mysqli_escape_string($db, $bookingId);
                $userId = mysqli_escape_string($db, $userId);
                $groundIdSelected = mysqli_escape_string($db, $groundIdSelected);
                $bookingStartSelected = mysqli_escape_string($db, $timeStart);
                $bookingEndSelected = mysqli_escape_string($db, $timeEnd);
                $bookingDateSelected = mysqli_escape_string($db, $bookingDateSelected);

                $sqlQuery = "insert into bookingdetails (booking_id, user_id, ground_id, booking_start, booking_end, booking_date) values ('$bookingId', '$userId', '$groundIdSelected', '$bookingStartSelected', '$bookingEndSelected', '$bookingDateSelected')";
                
                $result = $db -> query($sqlQuery);

                $_SESSION['booking-success'] = "Đặt sân thành công!";
            }

            // Redirect back
            header("Location: ../management.php?m=bookingground_payment&datechoose=$bookingDateSelected");
        }

        else if (isset($_POST['newSubmit']) && $_GET['typeuser'] == "new") {
            // New user real name
            $userRealName = $_POST['newRealName'];

            // new user phone
            $userPhone = $_POST['newPhone'];

            // New user id
            $newUserId = uniqid();

            // Insert new user data into database
            $userRealNameNew = mysqli_escape_string($db, $userRealName);
            $newPhone = mysqli_escape_string($db, $userPhone);
            $newUserId = mysqli_escape_string($db, $newUserId);

            $addNewUserQuery = "insert into users (user_id, user_phone, user_realname) values ('$newUserId', '$newPhone', '$userRealNameNew')";
            
            $addNewResult = $db -> query($addNewUserQuery);

            // Ground name
            $groundNameSelected = $_POST['selectGround'];

            // Booking date
            $bookingDateSelected = $_POST['dateChooseForm'];
        
            // Generate booking id
            $bookingId = uniqid();

            // Get user id
            $getUserData = getIdByUserPhone($userPhone);
            $userData = $getUserData -> fetch_assoc();
            $userId = $userData['user_id'];

            // Get ground id
            $getGroundDataSelected = getIdByGroundName($groundNameSelected);
            $groundDataSelected = $getGroundDataSelected -> fetch_assoc();
            $groundIdSelected = $groundDataSelected['ground_id'];

            // Time start & end
            $timeStart = $_POST['selectTimeStart-1'] . ":" . $_POST['selectTimeStart-2'];
            $timeEnd = $_POST['selectTimeEnd-1'] . ":" . $_POST['selectTimeEnd-2'];

            // Check time start & end
            $checkBookingTimes = true;
            $checkBookingPhone = true;
            $bookingDetailsData = getBookingDetails($db);

            if ($bookingDetailsData != null && $bookingDetailsData -> num_rows > 0) {
                while ($data = $bookingDetailsData -> fetch_assoc()) {
                    $groundId = $data['ground_id'];
                    $userIdInDatabase = $data['user_id'];
                    $bookingStart = $data['booking_start'];
                    $bookingEnd = $data['booking_end'];
                    $bookingDate = $data['booking_date'];

                    // Get ground data
                    $getGroundData = getGroundById($groundId);
                    $groundData = $getGroundData -> fetch_assoc();
                    $groundName = $groundData['ground_name'];
                    
                    if ($bookingDate == $bookingDateSelected && $groundName == $groundNameSelected && $bookingStart == $timeStart && $bookingEnd == $timeEnd) {
                        $checkBookingTimes = false;
                    }

                    else if ($bookingDate == $bookingDateSelected && $groundName == $groundNameSelected && strtotime($timeStart) > strtotime($bookingStart) && strtotime($timeStart) < strtotime($bookingEnd)) {
                        $checkBookingTimes = false;
                    }

                    else if ($bookingDate == $bookingDateSelected && $groundName == $groundNameSelected && strtotime($timeEnd) > strtotime($bookingStart) && strtotime($timeEnd) < strtotime($bookingEnd)) {
                        $checkBookingTimes = false;
                    }

                    else if ($userIdInDatabase == $userId && $bookingDate == $bookingDateSelected) {
                        $checkBookingPhone = false;
                    }
                }
            }

            // Check if start and end time are the same
            if ($timeStart == $timeEnd) {
                $checkBookingTimes = false;
            }

            // Check and insert into database
            if ($checkBookingTimes == false) {
                $_SESSION['booking-error'] = "Khung giờ đặt sân không hợp lệ!";
            }

            else if ($checkBookingPhone == false) {
                $_SESSION['booking-error'] = "Số điện thoại đã được dùng!";
            }

            else {
                $bookingId = mysqli_escape_string($db, $bookingId);
                $userId = mysqli_escape_string($db, $userId);
                $groundIdSelected = mysqli_escape_string($db, $groundIdSelected);
                $bookingStartSelected = mysqli_escape_string($db, $timeStart);
                $bookingEndSelected = mysqli_escape_string($db, $timeEnd);
                $bookingDateSelected = mysqli_escape_string($db, $bookingDateSelected);

                $sqlQuery = "insert into bookingdetails (booking_id, user_id, ground_id, booking_start, booking_end, booking_date) values ('$bookingId', '$userId', '$groundIdSelected', '$bookingStartSelected', '$bookingEndSelected', '$bookingDateSelected')";
                
                $result = $db -> query($sqlQuery);

                $_SESSION['booking-success'] = "Đặt sân thành công!";
            }

            // Redirect back
            header("Location: ../management.php?m=bookingground_payment&datechoose=$bookingDateSelected");
        }
    }
?>