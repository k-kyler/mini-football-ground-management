<?php
    function getDatabase() {
        $conn = new mysqli(SERVER, USER, PASS, DB);

        if ($conn -> connect_error) {
            die('Error! Can not connect to MySQL database' . $conn -> connect_error);
        }

        else {
            return $conn;
        }
    }

    function getImages($db) {
        $sqlQuery = "select * from images";

        return $db -> query($sqlQuery);
    }

    function getUserByUserName($db, $username) {
        $sqlQuery = "select * from users where user_name = ?";

        $stm = $db ->prepare($sqlQuery);
        $stm -> bind_param('s', $username);
        $status = $stm -> execute();

        if ($status) {
            $data = $stm -> get_result();

            return $data;
        }

        else {
            $stm -> close();

            return null;
        }
    }

    function login($usernameInput, $passwordInput) {
        $db = getDatabase();
        $userInfo = getUserByUserName($db, $usernameInput);

        if ($userInfo -> num_rows == 0) {
            ?>
                <style>
                    .username-input::placeholder {
                        color: red;
                    }
                </style>
            <?php
        }

        else {
            $data = $userInfo -> fetch_assoc();
            $user_name = $data['user_name'];
            $user_password = $data['user_password'];
            $user_type = $data['user_type'];

            if ($user_name == $usernameInput && $user_password == $passwordInput && $usernameInput != "" && $passwordInput != "") {
                session_start();

                $_SESSION['user_name'] = $user_name;
                $_SESSION['user_type'] = $user_type;

                header("Location: index.php");
            }
    
            else if ($user_name != $usernameInput || $usernameInput == "") {
                ?>
                    <style>
                        .username-input::placeholder {
                            color: red;
                        }
                    </style>
                <?php
            }
    
            else if ($user_password != $passwordInput || $passwordInput == "") {
                ?>
                    <style>
                        .password-input::placeholder {
                            color: red;
                        }
                    </style>
                <?php
            }
        }
    }

    function checkAndUploadRegisterData($usernameInput, $passwordInput, $emailInput, $phoneInput, $realName) {
        $db = getDatabase();

        $userIdGenerate = uniqid();

        $ui = mysqli_escape_string($db, $userIdGenerate);
        $u = mysqli_escape_string($db, $usernameInput);
        $p = mysqli_escape_string($db, $passwordInput);
        $e = mysqli_escape_string($db, $emailInput);
        $ph = mysqli_escape_string($db, $phoneInput);
        $r = mysqli_escape_string($db, $realName);

        $getUserByUserName = $db -> query("select user_name from users where user_name = '$u'");
        $getUserEmail = $db -> query("select user_email from users where user_email = '$e'");
        $getUserPhone = $db -> query("select user_phone from users where user_phone = '$ph'");

        if ($getUserName -> num_rows > 0) {
            ?>
                <style>
                    .register-username-input::placeholder {
                        color: red;
                    }
                </style>
            <?php
        }

        else if ($getUserEmail -> num_rows > 0) {
            ?>
                <style>
                    .register-email-input::placeholder {
                        color: red;
                    }
                </style>
            <?php
        }

        else if ($getUserPhone -> num_rows > 0) {
            ?>
                <style>
                    .register-phone-input::placeholder {
                        color: red;
                    }
                </style>
            <?php
        }

        else {
            $uploadRegisterData = "insert into users (user_id, user_name, user_password, user_email, user_phone, user_realname) values ('$ui', '$u', '$p', '$e', '$ph', '$r')";
            $result = $db -> query($uploadRegisterData);

            header("Location: login.php");
        }
    }

    function getBookingDetails($db) {
        $sqlQuery = "select * from bookingdetails";

        return $db -> query($sqlQuery);
    }

    function getUserById($id) {
        $db = getDatabase();

        $sqlQuery = "select * from users where user_id = ?";

        $stm = $db ->prepare($sqlQuery);
        $stm -> bind_param('s', $id);
        $status = $stm -> execute();

        if ($status) {
            $data = $stm -> get_result();

            return $data;
        }

        else {
            $stm -> close();

            return null;
        }
    }

    function getGroundById($id) {
        $db = getDatabase();

        $sqlQuery = "select * from grounds where ground_id = ?";

        $stm = $db ->prepare($sqlQuery);
        $stm -> bind_param('s', $id);
        $status = $stm -> execute();

        if ($status) {
            $data = $stm -> get_result();

            return $data;
        }

        else {
            $stm -> close();

            return null;
        }
    }

    function getUsers($db) {
        $sqlQuery = "select * from users";

        return $db -> query($sqlQuery);
    }

    function getGrounds($db) {
        $sqlQuery = "select * from grounds";

        return $db -> query($sqlQuery);
    }

    function getIdByUserPhone($userPhone) {
        $db = getDatabase();

        $sqlQuery = "select * from users where user_phone = ?";

        $stm = $db ->prepare($sqlQuery);
        $stm -> bind_param('s', $userPhone);
        $status = $stm -> execute();

        if ($status) {
            $data = $stm -> get_result();

            return $data;
        }

        else {
            $stm -> close();

            return null;
        }
    }

    function getIdByGroundName($groundName) {
        $db = getDatabase();

        $sqlQuery = "select * from grounds where ground_name = ?";

        $stm = $db ->prepare($sqlQuery);
        $stm -> bind_param('s', $groundName);
        $status = $stm -> execute();

        if ($status) {
            $data = $stm -> get_result();

            return $data;
        }

        else {
            $stm -> close();

            return null;
        }
    }

    function getBeverages($db) {
        $sqlQuery = "select * from beverages";

        return $db -> query($sqlQuery);
    }

    function getPayments($db) {
        $sqlQuery = "select * from payments";

        return $db -> query($sqlQuery);
    }

    function getIdByUserEmail($userEmail) {
        $db = getDatabase();

        $sqlQuery = "select * from users where user_email = ?";

        $stm = $db ->prepare($sqlQuery);
        $stm -> bind_param('s', $userEmail);
        $status = $stm -> execute();

        if ($status) {
            $data = $stm -> get_result();

            return $data;
        }

        else {
            $stm -> close();

            return null;
        }
    }

    function getEmailByUserPhone($userPhone) {
        $db = getDatabase();

        $sqlQuery = "select * from users where user_phone = ?";

        $stm = $db ->prepare($sqlQuery);
        $stm -> bind_param('s', $userPhone);
        $status = $stm -> execute();

        if ($status) {
            $data = $stm -> get_result();

            return $data;
        }

        else {
            $stm -> close();

            return null;
        }
    }

    function getIdByBeverageName($beverageName) {
        $db = getDatabase();

        $sqlQuery = "select * from beverages where beverage_name = ?";

        $stm = $db ->prepare($sqlQuery);
        $stm -> bind_param('s', $beverageName);
        $status = $stm -> execute();

        if ($status) {
            $data = $stm -> get_result();

            return $data;
        }

        else {
            $stm -> close();

            return null;
        }
    }
?>