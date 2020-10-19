<style>
    <?php 
        require_once('./CSS/booking.css');
    ?>
</style>

<?php
    // Layout
    require_once('layout.php');

    // Config
    require_once('./Config/config.php');

    ?>      
        <!-- Admin management content -->
        <div class="admin-management-container">
            <!-- Date picker processing -->
            <div class="date-picker">
                <form action="" method="POST">
                    <label for="dateChoose">Chọn ngày:</label>
    
                    <?php 
                        if (isset($_POST['submit'])) {
                            ?>
                                <input type="text" id="dateChoose" name="dateChoose" value="<?= $_POST['dateChoose'] ?>">
                            <?php
                        }

                        else if (isset($_GET['datechoose'])) {
                            ?>
                                <input type="text" id="dateChoose" name="dateChoose" value="<?= $_GET['datechoose'] ?>">
                            <?php
                        }

                        else {
                            ?>
                                <input type="text" id="dateChoose" name="dateChoose">
                            <?php
                        }
                    ?>
                    
                    <input type="submit" value="Chọn" name="submit">
                </form>
            </div>

            <!-- Booking ground & Payment processing -->
            <?php
                // If user click on Chọn button
                if (isset($_POST['submit'])) {                                    
                    ?>
                        <!-- Booking title -->
                        <div class="booking-title">Danh sách đặt sân ngày <?= $_POST['dateChoose'] ?></div>

                        <!-- Display booking list -->
                        <div class="booking-list">
                            <table>
                                <tr>
                                    <th>STT</th>
                                    <th>Tên khách hàng</th>
                                    <th>Số điện thoại</th>
                                    <th>Sân đã đặt</th>
                                    <th>Thời gian bắt đầu</th>
                                    <th>Thời gian kết thúc</th>
                                    <th>Tổng thời gian (phút)</th>
                                    <th>Tổng tiền</th>
                                    <th>Trạng thái</th>
                                </tr>
                                
                                <!-- Get booking list data -->
                                <?php
                                    $db = getDatabase();
                                    $bookingDetailsData = getBookingDetails($db);

                                    if ($bookingDetailsData != null && $bookingDetailsData -> num_rows > 0) {
                                        $count = 0;
                                        $totalDayProfit = 0;
                                        
                                        while ($data = $bookingDetailsData -> fetch_assoc()) {
                                            $bookingId = $data['booking_id'];
                                            $bookingName = $data['booking_name'];
                                            $bookingPhone = $data['booking_phone'];
                                            $bookingGround = $data['booking_ground'];
                                            $bookingStart = $data['booking_start'];
                                            $bookingEnd = $data['booking_end'];
                                            $bookingTotaltime = $data['booking_totaltime'];
                                            $bookingTotalmoney = $data['booking_totalmoney'];
                                            $bookingDate = $data['booking_date'];
                                            $bookingStatus = $data['booking_status'];
                                            
                                            if ($bookingDate == $_POST['dateChoose']) {
                                                $totalDayProfit += $bookingTotalmoney;

                                                ?>
                                                    <tr>
                                                        <td><?= $count += 1 ?></td>
                                                        <td><?= $bookingName ?></td>
                                                        <td><?= $bookingPhone ?></td>
                                                        <td><?= $bookingGround ?></td>
                                                        <td><?= $bookingStart ?></td>
                                                        <td><?= $bookingEnd ?></td>
                                                        <td><?= $bookingTotaltime ?></td>
                                                        <td><?= number_format($bookingTotalmoney) ?></td>
                                                        <td>
                                                            <?php
                                                                if ($bookingStatus == "isPaid") {
                                                                    ?>
                                                                        <div class="payment-finish">Đã thanh toán</div>
                                                                    <?php
                                                                }

                                                                else {
                                                                    ?>
                                                                        <a href="./API/payment.php?bookingid=<?= $bookingId ?>&bookingdate=<?= $bookingDate ?>" class="pay-button">Thanh toán</a>
                                                                    <?php
                                                                }
                                                            ?>
                                                        </td>
                                                    </tr>
                                                <?php
                                            }
                                        }
                                    }
                                ?>
                            </table>
                        </div>

                        <?php
                            // Display error message if data don't have in your database
                            if ($bookingDate != $_POST['dateChoose']) {
                                ?>  
                                    <div class="table-empty-message">Không tìm thấy kết quả...</div>
                                <?php
                            }
                        ?>
                        
                        <!-- Display day profit -->
                        <div class="day-profit">
                            Tổng doanh thu của ngày: 
                            <span><?= number_format($totalDayProfit) ?>đ</span>
                        </div>
                    <?php
                }

                // Redirect data after payment
                else if (isset($_GET['datechoose'])) {                                    
                    ?>
                        <!-- Booking title -->
                        <div class="booking-title">Danh sách đặt sân ngày <?= $_GET['datechoose'] ?></div>

                        <!-- Display booking list -->
                        <div class="booking-list">
                            <table>
                                <tr>
                                    <th>STT</th>
                                    <th>Tên khách hàng</th>
                                    <th>Số điện thoại</th>
                                    <th>Sân đã đặt</th>
                                    <th>Thời gian bắt đầu</th>
                                    <th>Thời gian kết thúc</th>
                                    <th>Tổng thời gian (phút)</th>
                                    <th>Tổng tiền</th>
                                    <th>Trạng thái</th>
                                </tr>
                                
                                <!-- Get booking list data -->
                                <?php
                                    $db = getDatabase();
                                    $bookingDetailsData = getBookingDetails($db);

                                    if ($bookingDetailsData != null && $bookingDetailsData -> num_rows > 0) {
                                        $count = 0;
                                        $totalDayProfit = 0;
                                        
                                        while ($data = $bookingDetailsData -> fetch_assoc()) {
                                            $bookingId = $data['booking_id'];
                                            $bookingName = $data['booking_name'];
                                            $bookingPhone = $data['booking_phone'];
                                            $bookingGround = $data['booking_ground'];
                                            $bookingStart = $data['booking_start'];
                                            $bookingEnd = $data['booking_end'];
                                            $bookingTotaltime = $data['booking_totaltime'];
                                            $bookingTotalmoney = $data['booking_totalmoney'];
                                            $bookingDate = $data['booking_date'];
                                            $bookingStatus = $data['booking_status'];
                                            
                                            if ($bookingDate == $_GET['datechoose']) {
                                                $totalDayProfit += $bookingTotalmoney;

                                                ?>
                                                    <tr>
                                                        <td><?= $count += 1 ?></td>
                                                        <td><?= $bookingName ?></td>
                                                        <td><?= $bookingPhone ?></td>
                                                        <td><?= $bookingGround ?></td>
                                                        <td><?= $bookingStart ?></td>
                                                        <td><?= $bookingEnd ?></td>
                                                        <td><?= $bookingTotaltime ?></td>
                                                        <td><?= number_format($bookingTotalmoney) ?></td>
                                                        <td>
                                                            <?php
                                                                if ($bookingStatus == "isPaid") {
                                                                    ?>
                                                                        <div class="payment-finish">Đã thanh toán</div>
                                                                    <?php
                                                                }

                                                                else {
                                                                    ?>
                                                                        <a href="./API/payment.php?bookingid=<?= $bookingId ?>&bookingdate=<?= $bookingDate ?>" class="pay-button">Thanh toán</a>
                                                                    <?php
                                                                }
                                                            ?>
                                                        </td>
                                                    </tr>
                                                <?php
                                            }
                                        }
                                    }
                                ?>
                            </table>
                        </div>

                        <?php
                            // Display error message if data don't have in your database
                            if ($bookingDate != $_GET['datechoose']) {
                                ?>  
                                    <div class="table-empty-message">Không tìm thấy kết quả...</div>
                                <?php
                            }
                        ?>
                        
                        <!-- Display day profit -->
                        <div class="day-profit">
                            Tổng doanh thu của ngày: 
                            <span><?= number_format($totalDayProfit) ?>đ</span>
                        </div>
                    <?php
                }

                // Display error message if no day is chosen
                else {
                    ?>
                        <div class="empty-message">Bạn chưa chọn ngày để xem</div>
                    <?php
                }
            ?>
        </div>
    <?php
?>

<script src="./JS/date-picker.js"></script>