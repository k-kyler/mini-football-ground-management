<?php
    // Config
    require_once('./Config/config.php');
?>

<?php
    if (isset($_SESSION['user_type'])) {
        if ($_SESSION['user_type'] == 'admin' || $_SESSION['user_type'] == 'staff') {
            // Layout
            require_once('layout.php');

            ?>
                <style>
                    <?php
                        // Management styles
                        require_once('./CSS/management.css');   
                    ?>
                </style>
            <?php

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

                        <?php
                            if ($_SESSION['user_type'] == "admin") {
                                ?>
                                    <div class="management-options">
                                        <a href="management.php?m=bookingground_payment">Quản lý đặt sân và thanh toán</a>
                                        <a href="management.php?m=usermanagement">Quản lý người dùng</a>
                                        <a href="management.php?m=beveragemanagement">Quản lý đồ uống</a>
                                        <a href="management.php?m=statisticprofit">Thống kê doanh thu</a>
                                        <a href="index.php">Về trang chủ</a>
                                        <a href="logout.php">Đăng xuất</a>
                                    </div>
                                <?php
                            }

                            else if ($_SESSION['user_type'] == "staff") {
                                ?>
                                    <div class="management-options">
                                        <a href="management.php?m=bookingground_payment">Quản lý đặt sân và thanh toán</a>
                                        <a href="management.php?m=usermanagement">Quản lý người dùng</a>
                                        <a href="management.php?m=beveragemanagement">Quản lý đồ uống</a>
                                        <a href="index.php">Về trang chủ</a>
                                        <a href="logout.php">Đăng xuất</a>
                                    </div>
                                <?php
                            }
                        ?>
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
                                            require_once('./booking-payment.php');
                                        }

                                        else if ($_GET['m'] == "usermanagement") {
                                            require_once('./user-management.php');
                                        }

                                        else if ($_GET['m'] == "beveragemanagement") {
                                            require_once('./beverage-management.php');
                                        }

                                        else if ($_GET['m'] == "statisticprofit") {
                                            require_once('./statistic-profit.php');
                                        }
                                    }
            
                                    else {
                                        ?>
                                            <div class="empty-function-message">Bạn hãy chọn chức năng để hiển thị...</div>
                                        <?php
                                    }
                                ?>
                            </div>
                        </div>
                    </div>            
                </div>
            <?php
        }
    }

    else {
        header("Location: login.php");
    }
?>