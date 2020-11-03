<style>
    <?php 
        require_once('./CSS/management.css');
    ?>
</style>

<?php
    // Layout
    require_once('layout.php');

    // Config
    require_once('./Config/config.php');

    ?>
        <!-- Page background -->
        <div class="management-background"></div>

        <!-- Management header -->
        <div class="management-header">
            <div class="company-logo">
                <img src="./Images/football.svg" alt="">
                <div class="company-name">KHV Ground</div>
            </div>

            <div class="header-control">
                <div class="management-title">
                    <?= $_SESSION['user_type'] ?> Dashboard
                    <i class="fas fa-chevron-down"></i>
                </div>

                <div class="management-options">
                    <a href="management.php?m=bookingground_payment">Quản lý đặt sân và thanh toán</a>
                    <a href="management.php?m=usermanagement">Quản lý người dùng</a>
                    <a href="management.php?m=profitreport">Thống kê doanh thu</a>
                    <a href="index.php">Về trang chủ</a>
                    <a href="logout.php">Đăng xuất</a>
                </div>
            </div>
        </div>

        <!-- Management container -->
        <div class="management-container">
            <div class="row">
                <div class="col-12">
                    <div class="management">
                        <?php
                            if (isset($_GET['m'])) {
                                if ($_GET['m'] == "bookingground_payment") {
                                    require_once('./booking.php');
                                }
                            }
    
                            else {
                                ?>
                                    <div class="empty-function-message">Bạn chưa chọn chức năng để hiển thị...</div>
                                <?php
                            }
                        ?>
                    </div>
                </div>
            </div>            
        </div>
    <?php
?>