<?php
    require_once('../Config/config.php');

    if (isset($_POST['deleteSubmit'])) {
        $db = getDatabase();

        // Current user real name and phone
        $userRealNameAndPhone = $_POST['selectUserRealName'];

        // Get current user phone
        $userRealNameAndPhone = strrev($userRealNameAndPhone);
        $userPhone = strrev(substr($userRealNameAndPhone, 0, strpos($userRealNameAndPhone, " - ")));

        // Get current user id by phone
        $getUserData = getIdByUserPhone($userPhone);
        $userData = $getUserData -> fetch_assoc();
        $userId = $userData['user_id'];

        // Delete from database
        $userId = mysqli_escape_string($db, $userId);

        $deleteUserQuery = "delete from users where user_id = '$userId'";
        $deleteUserBookingQuery = "delete from bookingdetails where user_id = '$userId'";

        $result1 = $db -> query($deleteUserQuery);
        $result2 = $db -> query($deleteUserBookingQuery);

        // Announcement session
        $_SESSION['user-management-success'] = "Xóa người dùng thành công!";

        // Redirect back
        header("Location: ../management.php?m=usermanagement");
    }
?>