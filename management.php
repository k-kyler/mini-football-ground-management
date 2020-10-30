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
                    Admin Dashboard
                    <i class="fas fa-chevron-down"></i>
                </div>

                <div class="management-options">
                    <a href="index.php">Về trang chủ</a>
                    <a href="logout.php">Đăng xuất</a>
                </div>
            </div>
        </div>

        <!-- Management container -->
        <div class="management-container">
            <div class="row">
                <div class="col-3 col-right-0">
                    <div class="admin-menu-management">
                        <div class="admin-menu-header">
                            <div class="menu-title">MENU</div>
                            <i class="fas fa-bars"></i>
                        </div>

                        <div class="admin-menu-list">
                            <ul>
                                <a href="management.php?m=bookingground_payment">
                                    <li>Quản lý đặt sân và thanh toán</li>
                                </a>

                                <a href="management.php?m=usermanagement">
                                    <li>Quản lý người dùng</li>
                                </a>

                                <a href="management.php?m=profitreport">
                                    <li>Thống kê doanh thu</li>
                                </a>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-9">
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