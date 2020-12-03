<?php
    // Config
    require_once('./Config/config.php');
?>

<style>
    <?php 
        require_once('./CSS/login.css');
    ?>
</style>

<?php
    // Layout
    require_once('layout.php');

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

        // Call login
        login($usernameInput, $passwordInput);

        $_SESSION['login-success'] = "Đăng nhập thành công!";
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

        <!-- Handling register success message -->
        <?php
            if (isset($_SESSION['register-success'])) {
                ?>
                    <div class="register-success">
                        <p><?= $_SESSION['register-success'] ?></p>
                        <span>&times;</span>
                    </div>
                <?php

                unset($_SESSION['register-success']);
            }
        ?>
    <?php
?>

<script>
    <?php 
        require_once('./JS/close-popup-message.js');
    ?>
</script>