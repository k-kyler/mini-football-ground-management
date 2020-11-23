<?php
    require_once('../Config/config.php');

    if (isset($_POST['editSubmit'])) {
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

        // Ground name select
        $groundNameSelected = $_POST['selectGround'];

        // Get ground id
        $getGroundDataSelected = getIdByGroundName($groundNameSelected);
        $groundDataSelected = $getGroundDataSelected -> fetch_assoc();
        $groundIdSelected = $groundDataSelected['ground_id'];

        // Current booking date
        $bookingDate = $_POST['dateChooseForm'];

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

        // Check and edit database
        if ($checkBookingTimes == false) {
            $_SESSION['booking-error'] = "Khung giờ đặt sân không hợp lệ!";
        }

        else if ($checkBookingPhone == false) {
            $_SESSION['booking-error'] = "Số điện thoại đã được dùng!";
        }

        else {
            $groundIdSelected = mysqli_escape_string($db, $groundIdSelected);
            $bookingStartSelected = mysqli_escape_string($db, $timeStart);
            $bookingEndSelected = mysqli_escape_string($db, $timeEnd);

            $bookingDateEdit = mysqli_escape_string($db, $bookingDate);
            $userId = mysqli_escape_string($db, $userId);

            $sqlQuery = "update bookingdetails 
                        set
                            ground_id = '$groundIdSelected', 
                            booking_start = '$bookingStartSelected', 
                            booking_end = '$bookingEndSelected'
                        where user_id = '$userId' and booking_date = '$bookingDateEdit'";

            $result = $db -> query($sqlQuery);

            // Announcement session
            $_SESSION['booking-success'] = "Cập nhật thông tin thành công!";
        }

        // Redirect back
        header("Location: ../management.php?datechoose=$bookingDate&m=bookingground_payment");
    }
?>