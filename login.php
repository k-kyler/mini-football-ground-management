<style>
    <?php 
        require_once('./CSS/login.css');
    ?>
</style>

<?php
    // Layout
    require_once('layout.php');

    // Config
    require_once('./Config/config.php');

    // Login validate
    require_once('./Validates/auth-validate.php');

    // Login processing
    if (isset($_POST['submit'])) {
        // Data from form
        $usernameInput = $_POST['username'];
        $passwordInput = $_POST['password'];

        // Validate login data
        $usernameInput = userNameValidate($usernameInput);
        $passwordInput = passwordValidate($passwordInput);

        // Compare with data from database
        $db = getDatabase();
        $userInfo = getUserByName($db, $usernameInput);

        if ($userInfo -> num_rows == 0) {
            ?>
                <style>
                    .username-input::placeholder {
                        color: rgb(145, 255, 0);
                    }
                </style>
            <?php
        }

        else {
            $data = $userInfo -> fetch_assoc();
            $user_name = $data['user_name'];
            $user_password = $data['user_password'];

            if ($user_name == $usernameInput && $user_password == $passwordInput && $usernameInput != "" && $passwordInput != "") {
                $_SESSION['username'] = $user_name;
                header("Location: index.php");
            }
    
            else if ($user_name != $usernameInput || $usernameInput == "") {
                ?>
                    <style>
                        .username-input::placeholder {
                            color: rgb(145, 255, 0);
                        }
                    </style>
                <?php
            }
    
            else if ($user_password != $passwordInput || $passwordInput == "") {
                ?>
                    <style>
                        .password-input::placeholder {
                            color: rgb(145, 255, 0);
                        }
                    </style>
                <?php
            }
        }
    }

    ?>
        <!-- Login page background -->
        <div class="login-background"></div>

        <!-- Login content -->
        <div class="login-container">
            <img src="./Images/user-logo.png">

            <h1>Đăng nhập tại đây!</h1>

            <form method="POST">
                <p>Tên đăng nhập</p>
                <input type="text" name="username" class="username-input" placeholder="Tên đăng nhập không đúng">

                <p>Mật khẩu</p>
                <input type="password" name="password" class="password-input" placeholder="Mật khẩu không đúng">

                <input type="submit" value="Đăng nhập" name="submit">

                <a href="register.php">Chưa có tài khoản?</a>
            </form>
        </div>
    <?php
?>