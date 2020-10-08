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

    function getUserByName($db, $username) {
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
        $userInfo = getUserByName($db, $usernameInput);

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

        $u = mysqli_escape_string($db, $usernameInput);
        $p = mysqli_escape_string($db, $passwordInput);
        $e = mysqli_escape_string($db, $emailInput);
        $e = mysqli_escape_string($db, $emailInput);
        $r = mysqli_escape_string($db, $realName);

        $getUserName = $db -> query("select user_name from users where user_name = '$u'");
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
            $uploadRegisterData = "insert into users (user_name, user_password, user_email, user_phone, user_realname) values ('$u', '$p', '$e', '$ph', '$r')";
            $result = $db -> query($uploadRegisterData);

            header("Location: login.php");
        }
    }
?>