<style>
    <?php
        require_once('./CSS/header.css');
    ?>
</style>

<div class="header">
    <div class="header-banner">
        <div class="banner">
            <img src="./Images/header-banner.png">

            <div class="banner-text">Sân bóng mini KHV</div>
        </div>

        <a class="user-login" href="login.php">
            <img src="./Images/user-logo.png">

            <?php
                if (isset($_SESSION['username'])) {
                    ?>
                        <div class="login"><?= $_SESSION['username'] ?></div>
                    <?php

                    ?>
                        <script>alert("Đăng nhập thành công!");</script>
                    <?php
                }

                else {
                    ?>
                        <div class="login">Đăng nhập</div>
                    <?php
                }
            ?>
        </a>
    </div>

    <div class="header-nav">
        <ul class="nav-items">
            <a href="#">
                <li>Trang chủ</li>
            </a>
            
            <a href="#">
                <li>Đặt sân ngay</li>
            </a>

            <a href="#">
                <li class="nav-item-dropdown">
                    Các loại sân
                    
                    <ul class="ground-type-dropdown">
                        <a href="#">
                            <li>Sân 5 người</li>
                        </a>
                        
                        <a href="#">
                            <li>Sân 7 người</li>
                        </a>

                        <a href="#">
                            <li>Sân 9 người</li>
                        </a>
                    </ul>
                </li>
            </a>

            <a href="#">
                <li>Tình trạng sân hiện tại</li>
            </a>

            <a href="#">
                <li>Chi phí & khung giờ hoạt động</li>
            </a>
        </ul>
    </div>
</div>