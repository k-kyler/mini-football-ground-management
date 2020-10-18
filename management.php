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
        <!-- Admin page background -->
        <div class="admin-background"></div>

        <!-- Staff page background -->
        <!-- ... -->

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
        <div class="container">
            <div class="row">
                <div class="col-3 col-right-0">
                    <div class="admin-menu">
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

                    </div>
                </div>
            </div>            
        </div>
    <?php
?>