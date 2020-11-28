<?php
    require_once('../Config/config.php');

    if (isset($_POST['newSubmit'])) {
        $db = getDatabase();

        // New user real name
        $userRealName = $_POST['newRealName'];

        // New user phone
        $userPhone = $_POST['newPhone'];

        // New user email
        $userEmail = $_POST['newEmail'];

        // New user id
        $newUserId = uniqid();

        // Check if new phone has existed
        $checkUserNewPhone = true;

        $newPhone = mysqli_escape_string($db, $userPhone);

        $getUserNewPhone = $db -> query("select user_phone from users where user_phone = '$newPhone'");

        if ($getUserNewPhone -> num_rows > 0) {
            $checkUserNewPhone = false;
        }

        // Check if new email has existed
        $checkUserNewEmail = true;

        $newEmail = mysqli_escape_string($db, $userEmail);

        $getUserNewEmail = $db -> query("select user_email from users where user_email = '$newEmail'");

        if ($getUserNewEmail -> num_rows > 0) {
            $checkUserNewEmail = false;
        }

        // Check and insert into database
        if ($checkUserNewPhone == false) {
            $_SESSION['user-management-error'] = "Số điện thoại đã được dùng!";
        }

        else if ($checkUserNewEmail == false) {
            $_SESSION['user-management-error'] = "Email đã được dùng!";
        }

        else {
            $newUserId = mysqli_escape_string($db, $newUserId);
            $userRealName = mysqli_escape_string($db, $userRealName);

            $addNewUserQuery = "insert into users (user_id, user_phone, user_email, user_realname) values ('$newUserId', '$newPhone', '$newEmail', '$userRealName')";
            $res = $db -> query($addNewUserQuery);

            $_SESSION['user-management-success'] = "Thêm người dùng thành công!";
        }
    }
    
    // Redirect back
    header("Location: ../management.php?m=usermanagement");
?>