<?php
    require_once('../Config/config.php');

    if (isset($_POST['editSubmit'])) {
        $db = getDatabase();

        // Current booking user real name and phone
        $userRealNameAndPhone = $_POST['selectUserRealName'];

        // Get current booking user real name
        $userRealName = substr($userRealNameAndPhone, 0, strpos($userRealNameAndPhone, " - "));

        // Get current booking user phone
        $userRealNameAndPhone = strrev($userRealNameAndPhone);
        $userPhone = strrev(substr($userRealNameAndPhone, 0, strpos($userRealNameAndPhone, " - ")));

        // Edit real name
        $userEditRealName = $_POST['editRealName'];

        // Edit phone
        $userEditPhone = $_POST['editPhone'];

        // Check if edit phone has existed in the database
        $checkUserEditPhone = true;

        if ($userPhone != $userEditPhone) {
            // Compare phone of users in database
            $userEditPhone = mysqli_escape_string($db, $userEditPhone);
            $getUserEditPhone = $db -> query("select user_phone from users where user_phone = '$userEditPhone'");

            if ($getUserEditPhone -> num_rows > 0) {
                // Get current booking user id by phone
                $getUserData = getIdByUserPhone($userPhone);
                $userData = $getUserData -> fetch_assoc();
                $userId = $userData['user_id'];

                // Get user id edit by edit phone
                $getUserDataEdit = getIdByUserPhone($userEditPhone);
                $userDataEdit = $getUserDataEdit -> fetch_assoc();
                $userIdEdit = $userDataEdit['user_id'];

                if ($userId != $userDataEdit) {
                    $checkUserEditPhone = false;
                }
            }

            else {
                // Get current booking user id by phone
                $getUserData = getIdByUserPhone($userPhone);
                $userData = $getUserData -> fetch_assoc();
                $userId = $userData['user_id'];

                // Update new phone for user if it is required 
                $userEditRealName = mysqli_escape_string($db, $userEditRealName);
                $userEditPhone = mysqli_escape_string($db, $userEditPhone);
                $userEditId = mysqli_escape_string($db, $userId);

                $sqlQueryEditPhone = "update users set user_phone = '$userEditPhone' where user_id = '$userEditId'";
                $res = $db -> query($sqlQueryEditPhone);
            }
        }

        else {
            // Get current booking user id by phone
            $getUserData = getIdByUserPhone($userPhone);
            $userData = $getUserData -> fetch_assoc();
            $userId = $userData['user_id'];
        }

        // Check to update new user real name
        if ($userRealName != $userEditRealName) {
            // Update new real name for user if it is required 
            $userEditRealName = mysqli_escape_string($db, $userEditRealName);
            $userEditId = mysqli_escape_string($db, $userId);

            $sqlQueryEditRealName = "update users set user_realname = '$userEditRealName' where user_id = '$userEditId'";
            $res = $db -> query($sqlQueryEditRealName);
        }

        // Ground name select
        $groundNameSelected = $_POST['selectGround'];

        // Get ground id
        $getGroundDataSelected = getIdByGroundName($groundNameSelected);
        $groundDataSelected = $getGroundDataSelected -> fetch_assoc();
        $groundIdSelected = $groundDataSelected['ground_id'];

        // Current booking date
        $bookingDateSelected = $_POST['dateChooseForm'];

        // Time start & end
        $timeStart = $_POST['selectTimeStart-1'] . ":" . $_POST['selectTimeStart-2'];
        $timeEnd = $_POST['selectTimeEnd-1'] . ":" . $_POST['selectTimeEnd-2'];

        // Check time start & end
        $checkBookingTimes = true;
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

                if ($bookingDate == $bookingDateSelected && $groundName == $groundNameSelected && strtotime($timeStart) > strtotime($bookingStart) && strtotime($timeStart) < strtotime($bookingEnd) && strtotime($timeEnd) > strtotime($bookingStart) && strtotime($timeEnd) > strtotime($bookingEnd)) {
                    $checkBookingTimes = false;
                }

                else if ($bookingDate == $bookingDateSelected && $groundName == $groundNameSelected && strtotime($timeEnd) > strtotime($bookingStart) && strtotime($timeEnd) < strtotime($bookingEnd) && strtotime($timeStart) < strtotime($bookingStart) && strtotime($timeStart) < strtotime($bookingEnd)) {
                    $checkBookingTimes = false;
                }

                else if ($bookingDate == $bookingDateSelected && $groundName == $groundNameSelected && strtotime($timeStart) < strtotime($bookingStart) && strtotime($timeEnd) > strtotime($bookingEnd)) {
                    $checkBookingTimes = false;
                }

                else if ($bookingDate == $bookingDateSelected && $groundName == $groundNameSelected && strtotime($timeStart) > strtotime($bookingStart) && strtotime($timeEnd) < strtotime($bookingEnd)) {
                    $checkBookingTimes = false;
                }
            }
        }

        // Check if start and end time are the same or start larger than end
        if ($timeStart == $timeEnd || strtotime($timeStart) > strtotime($timeEnd)) {
            $checkBookingTimes = false;
        }

        // Check and edit database
        if ($checkBookingTimes == false) {
            $_SESSION['booking-error'] = "Khung giờ đặt sân không hợp lệ!";
        }

        else if ($checkUserEditPhone == false) {
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