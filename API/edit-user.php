<?php
    require_once('../Config/config.php');

    if (isset($_POST['editSubmit'])) {
        $db = getDatabase();

        // Current user real name and phone
        $userRealNameAndPhone = $_POST['selectUserRealName'];

        // Get current user real name
        $userRealName = substr($userRealNameAndPhone, 0, strpos($userRealNameAndPhone, " - "));

        // Get current user phone
        $userRealNameAndPhone = strrev($userRealNameAndPhone);
        $userPhone = strrev(substr($userRealNameAndPhone, 0, strpos($userRealNameAndPhone, " - ")));

        // Get current user email
        $getUserEmailData = getEmailByUserPhone($userPhone);
        $userEmailData = $getUserEmailData -> fetch_assoc();
        $userEmail = $userEmailData['user_email'];

        // Edit user real name
        $editUserRealName = $_POST['editRealName'];

        // Edit user phone
        $editUserPhone = $_POST['editPhone'];

        // Edit user email
        $editUserEmail = $_POST['editEmail'];

        // Check if edit phone has existed
        $checkUserNewEditPhone = true;

        $newEditPhone = mysqli_escape_string($db, $editUserPhone);

        if ($userPhone != $editUserPhone) {
            $getUserNewEditPhone = $db -> query("select user_phone from users where user_phone = '$newEditPhone'");

            if ($getUserNewEditPhone -> num_rows > 0) {
                // Get current user id by phone
                $getUserData = getIdByUserPhone($userPhone);
                $userData = $getUserData -> fetch_assoc();
                $userId = $userData['user_id'];

                // Get user id edit by edit phone
                $getUserDataEdit = getIdByUserPhone($editUserPhone);
                $userDataEdit = $getUserDataEdit -> fetch_assoc();
                $userIdEdit = $userDataEdit['user_id'];

                if ($userId != $userIdEdit) {
                    $checkUserNewEditPhone = false;
                }
            }
        }

        else {
            // Get current user id by phone
            $getUserData = getIdByUserPhone($userPhone);
            $userData = $getUserData -> fetch_assoc();
            $userId = $userData['user_id'];
        }
        
        // Check if edit email has existed
        $checkUserNewEditEmail = true;

        $newEditEmail = mysqli_escape_string($db, $editUserEmail);

        if ($userEmail != $editUserEmail) {
            $getUserNewEditEmail = $db -> query("select user_email from users where user_email = '$newEditEmail'");

            if ($getUserNewEditEmail -> num_rows > 0) {
                // Get current user id by email
                $getUserData = getIdByUserEmail($userEmail);
                $userData = $getUserData -> fetch_assoc();
                $userId = $userData['user_id'];

                // Get user id edit by edit email
                $getUserDataEdit = getIdByUserEmail($editUserEmail);
                $userDataEdit = $getUserDataEdit -> fetch_assoc();
                $userIdEdit = $userDataEdit['user_id'];

                if ($userId != $userDataEdit) {
                    $checkUserNewEditEmail = false;
                }
            }
        }

        else {
            // Get current user id by email
            $getUserData = getIdByUserEmail($userEmail);
            $userData = $getUserData -> fetch_assoc();
            $userId = $userData['user_id'];
        }

        // Check and insert into database
        if ($checkUserNewEditPhone == false) {
            $_SESSION['user-management-error'] = "Số điện thoại đã được dùng!";
        }

        else if ($checkUserNewEditEmail == false) {
            $_SESSION['user-management-error'] = "Email đã được dùng!";
        }

        else {
            $editUserRealName = mysqli_escape_string($db, $editUserRealName);

            $editUserQuery = "update users set
                                user_realname = '$editUserRealName',
                                user_phone = '$newEditPhone',
                                user_email = '$newEditEmail'
                            where user_id = '$userId'
                            ";
            $res = $db -> query($editUserQuery);

            $_SESSION['user-management-success'] = "Cập nhật thành công!";
        }
    }
    
    // Redirect back
    header("Location: ../management.php?m=usermanagement");
?>