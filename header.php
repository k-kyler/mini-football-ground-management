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
                if (isset($_SESSION['user_name']) && isset($_SESSION['user_type']) && $_SESSION['user_type'] == 'admin') {
                    ?>
                        <div class="login">
                            <img src="./Images/user-logo.png">
        
                            <?= $_SESSION['user_name'] ?>
                            
                            <i class="fas fa-chevron-down"></i>

                            <div class="user-detail">
                                <a href="admin.php">
                                    <p>Quản lý</p>
                                </a>

                                <a href="logout.php">
                                    <p>Đăng xuất</p>
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

                else if (isset($_SESSION['user_name']) && isset($_SESSION['user_type']) && $_SESSION['user_type'] == 'staff') {
                    ?>
                        <div class="login">
                            <img src="./Images/user-logo.png">
        
                            <?= $_SESSION['user_name'] ?>
                            
                            <i class="fas fa-chevron-down"></i>

                            <div class="user-detail">
                                <a href="staff.php">
                                    <p>Quản lý</p>
                                </a>

                                <a href="logout.php">
                                    <p>Đăng xuất</p>
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
                        <img src="./Images/user-logo.png">

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