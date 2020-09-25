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

    ?>
        <!-- Login page background -->
        <div class="login-background"></div>

        <!-- Login content -->
        <div class="login-container">
            <img src="./Images/user-logo.png">

            <h1>Đăng nhập tại đây!</h1>

            <form>
                <p>Tên đăng nhập</p>
                <input type="text">

                <p>Mật khẩu</p>
                <input type="password">

                <input type="submit" value="Đăng nhập">

                <a href="#">Chưa có tài khoản?</a>
            </form>
        </div>
    <?php
?>