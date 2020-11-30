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

            <?php
                if (isset($_SESSION['user_name']) && isset($_SESSION['user_type'])) {
                    if ($_SESSION['user_type'] == 'admin' || $_SESSION['user_type'] == 'staff') {
                        ?>
                            <div class="login">
                                <?= $_SESSION['user_name'] ?>

                                <i class="fas fa-chevron-down"></i>

                                <img src="./Images/user-logo.png">
            
                                <div class="user-detail">
                                    <a href="management.php">
                                        <div>Quản lý</div>
                                    </a>

                                    <a href="logout.php">
                                        <div>Đăng xuất</div>
                                    </a>
                                </div>
                            </div>

                            <script>
                                $(document).ready(function() {
                                    $(".user-login").attr('href', 'javascript:void(0)');
                                });
                            </script>
                        <?php
                    }
                    
                    else {
                        ?>
                            <div class="login">
                                <?= $_SESSION['user_name'] ?>

                                <i class="fas fa-chevron-down"></i>

                                <img src="./Images/user-logo.png">
            
                                <div class="user-detail">
                                    <a href="index.php?u=userinfo">
                                        <div>Thông tin</div>
                                    </a>

                                    <a href="logout.php">
                                        <div>Đăng xuất</div>
                                    </a>
                                </div>
                            </div>

                            <script>
                                $(document).ready(function() {
                                    $(".user-login").attr('href', 'javascript:void(0)');
                                });
                            </script>
                        <?php
                    }
                }

                else {
                    ?>
                        <div class="login">Đăng nhập</div>

                        <img src="./Images/user-logo.png">
                    <?php
                }
            ?>
        </a>
    </div>

    <div class="header-nav">
        <ul class="nav-items">
            <a href="index.php">
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