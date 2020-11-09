<style>
    <?php 
        require_once('./CSS/register.css');
    ?>
</style>

<?php
    // Layout
    require_once('layout.php');

    // Config
    require_once('./Config/config.php');

    // Register validate
    require_once('./Validates/auth-validate.php');

    // Register processing
    if (isset($_POST['submit'])) {
        // Data from form
        $usernameInput = $_POST['username'];
        $passwordInput = $_POST['password'];
        $emailInput = $_POST['email'];
        $phoneInput = $_POST['phone'];
        $realNameInput = $_POST['realname'];

        // Validate register data
        $usernameInput = userNameValidate($usernameInput);
        $passwordInput = passwordValidate($passwordInput);

        // Check and upload data to database
        checkAndUploadRegisterData($usernameInput, $passwordInput, $emailInput, $phoneInput, $realNameInput);

        $_SESSION['register-success'] = "Đăng ký thành công!";
    }

    ?>
        <!-- Register page background -->
        <div class="register-background"></div>

        <!-- Register content -->
        <div class="register-container">
            <img src="./Images/user-logo.png">

            <h1>Đăng ký tại đây!</h1>

            <form method="POST">
                <p>Họ tên</p>
                <input required type="text" name="realname">

                <p>Tên đăng nhập</p>
                <input required type="text" name="username" placeholder="Tên đăng nhập đã tồn tại" class="register-username-input">

                <p>Mật khẩu</p>
                <input required type="password" name="password" class="register-password-input">

                <p>Email</p>
                <input required type="email" name="email" placeholder="Email đã được sử dụng" class="register-email-input">

                <p>Số điện thoại</p>
                <input required type="tel" pattern="[0-9]{10}" name="phone" placeholder="Số điện thoại đã được sử dụng" class="register-phone-input">

                <input type="submit" value="Đăng ký" name="submit">

                <span>Đã có tài khoản? 
                    <a href="login.php">Đăng nhập.</a>
                </span>
            </form>
        </div>
    <?php
?>