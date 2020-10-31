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
                // User click on Chọn button
                if (isset($_POST['submit'])) {                                    
                    ?>
                        <!-- Booking title -->
                        <div class="booking-title">Danh sách đặt sân ngày <?= $_POST['dateChoose'] ?></div>

                        <!-- Display booking list -->
                        <div class="booking-list">
                            <table>
                                <tr>
                                    <th></th>
                                    <th>STT</th>
                                    <th>Tên khách hàng</th>
                                    <th>Số điện thoại</th>
                                    <th>Sân đã đặt</th>
                                    <th>Thời gian bắt đầu</th>
                                    <th>Thời gian kết thúc</th>
                                    <th>Tổng thời gian (phút)</th>
                                    <th>Phí đặt sân</th>
                                    <th>Phí phụ thu</th>
                                    <th>Tổng chi phí</th>
                                </tr>
                                
                                <!-- Get booking list data -->
                                <?php
                                    $db = getDatabase();
                                    $bookingDetailsData = getBookingDetails($db);

                                    if ($bookingDetailsData != null && $bookingDetailsData -> num_rows > 0) {
                                        $number = 0;
                                        $totalDayProfit = 0;
                                        
                                        while ($data = $bookingDetailsData -> fetch_assoc()) {
                                            $bookingId = $data['booking_id'];
                                            $userId = $data['user_id'];
                                            $groundId = $data['ground_id'];
                                            $bookingStart = $data['booking_start'];
                                            $bookingEnd = $data['booking_end'];
                                            $bookingDate = $data['booking_date'];

                                            // Calculate booking total time in minutes
                                            $bookingStartTime = strtotime($bookingStart);
                                            $bookingEndTime = strtotime($bookingEnd);
                                            $diff = abs($bookingStartTime - $bookingEndTime);
                                            $bookingTotaltime = $diff / 60;

                                            // Calculate booking cost, 1 min = 3.000đ
                                            $bookingCost = $bookingTotaltime * 3000;

                                            // Get user data
                                            $getUserData = getUserById($userId);
                                            $userData = $getUserData -> fetch_assoc();
                                            $userRealName = $userData['user_realname'];
                                            $userPhone = $userData['user_phone'];

                                            // Get ground data
                                            $getGroundData = getGroundById($groundId);
                                            $groundData = $getGroundData -> fetch_assoc();
                                            $groundName = $groundData['ground_name'];
                                            
                                            if ($bookingDate == $_POST['dateChoose']) {
                                                // $totalDayProfit += $bookingCost;

                                                ?>
                                                    <tr>
                                                        <td class="table-action">
                                                            <a href="./API/edit.php?bookingid=<?= $bookingId ?>&bookingdate=<?= $bookingDate ?>">
                                                                <i class="fas fa-edit"></i>
                                                            </a>
                                                            
                                                            <a onclick="return confirm('Bạn có chắc chắn muốn xóa?');" href="./API/delete.php?bookingid=<?= $bookingId ?>&bookingdate=<?= $bookingDate ?>">
                                                                <i class="far fa-trash-alt"></i>                                                        
                                                            </a>

                                                            <a href="./API/payment.php?bookingid=<?= $bookingId ?>&bookingdate=<?= $bookingDate ?>">
                                                                <i class="fas fa-shopping-cart"></i>
                                                            </a>
                                                        </td>

                                                        <td><?= $number += 1 ?></td>
                                                        <td><?= $userRealName ?></td>
                                                        <td><?= $userPhone ?></td>
                                                        <td><?= $groundName ?></td>
                                                        <td><?= $bookingStart ?></td>
                                                        <td><?= $bookingEnd ?></td>
                                                        <td><?= $bookingTotaltime ?></td>
                                                        <td><?= number_format($bookingCost) ?></td>
                                                        <td>0</td>
                                                        <td><?= number_format($bookingCost + 0) ?></td>
                                                    </tr>
                                                <?php
                                            }

                                            else {
                                                ?>  
                                                    <div class="table-empty-message">Không tìm thấy kết quả...</div>
                                                <?php
                                            }
                                        }
                                    }
                                ?>
                            </table>
                        </div>
                        
                        <!-- Add & profit area -->
                        <div class="add-and-profit-area">
                            <a href="./API/add.php?bookingid=<?= $bookingId ?>&bookingdate=<?= $bookingDate ?>" class="add-button">Thêm</a>

                            <?php
                                if (isset($totalDayProfit)) {
                                    ?>
                                        <!-- Display day profit -->
                                        <div class="day-profit">
                                            Tổng doanh thu của ngày: 
                                            <span><?= number_format($totalDayProfit) ?>đ</span>
                                        </div>
                                    <?php
                                }

                                else {
                                    ?>
                                    <!-- Display day profit -->
                                    <div class="day-profit">
                                        Tổng doanh thu của ngày: 
                                        <span>0đ</span>
                                    </div>
                                <?php
                                }
                            ?>
                        </div>
                    <?php
                }

                // Redirect data after using API 
                else if (isset($_GET['datechoose'])) {                                    
                    ?>
                        <!-- Booking title -->
                        <div class="booking-title">Danh sách đặt sân ngày <?= $_GET['datechoose'] ?></div>

                        <!-- Display booking list -->
                        <div class="booking-list">
                            <table>
                                <tr>
                                    <th></th>
                                    <th>STT</th>
                                    <th>Tên khách hàng</th>
                                    <th>Số điện thoại</th>
                                    <th>Sân đã đặt</th>
                                    <th>Thời gian bắt đầu</th>
                                    <th>Thời gian kết thúc</th>
                                    <th>Tổng thời gian (phút)</th>
                                    <th>Phí đặt sân</th>
                                    <th>Phí phụ thu</th>
                                    <th>Tổng chi phí</th>
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
                                            $userId = $data['user_id'];
                                            $groundId = $data['ground_id'];
                                            $bookingStart = $data['booking_start'];
                                            $bookingEnd = $data['booking_end'];
                                            $bookingDate = $data['booking_date'];

                                            // Calculate booking total time
                                            $bookingStartTime = strtotime($bookingStart);
                                            $bookingEndTime = strtotime($bookingEnd);
                                            $diff = abs($bookingStartTime - $bookingEndTime);
                                            $bookingTotaltime = $diff / 60;

                                            // Calculate booking cost, 1 min = 3.000đ
                                            $bookingCost = $bookingTotaltime * 3000;

                                            // Get user data
                                            $getUserData = getUserById($userId);
                                            $userData = $getUserData -> fetch_assoc();
                                            $userRealName = $userData['user_realname'];
                                            $userPhone = $userData['user_phone'];

                                            // Get ground data
                                            $getGroundData = getGroundById($groundId);
                                            $groundData = $getGroundData -> fetch_assoc();
                                            $groundName = $groundData['ground_name'];
                                            
                                            if ($bookingDate == $_GET['datechoose']) {
                                                // $totalDayProfit += $bookingCost;

                                                ?>
                                                    <tr>
                                                        <td class="table-action">
                                                            <a href="./API/edit.php?bookingid=<?= $bookingId ?>&bookingdate=<?= $bookingDate ?>">
                                                                <i class="fas fa-edit"></i>
                                                            </a>

                                                            <a onclick="return confirm('Bạn có chắc chắn muốn xóa?');" href="./API/delete.php?bookingid=<?= $bookingId ?>&bookingdate=<?= $bookingDate ?>">
                                                                <i class="far fa-trash-alt"></i>                                                        
                                                            </a>

                                                            <a href="./API/payment.php?bookingid=<?= $bookingId ?>&bookingdate=<?= $bookingDate ?>">
                                                                <i class="fas fa-shopping-cart"></i>
                                                            </a>
                                                        </td>

                                                        <td><?= $number += 1 ?></td>
                                                        <td><?= $userRealName ?></td>
                                                        <td><?= $userPhone ?></td>
                                                        <td><?= $groundName ?></td>
                                                        <td><?= $bookingStart ?></td>
                                                        <td><?= $bookingEnd ?></td>
                                                        <td><?= $bookingTotaltime ?></td>
                                                        <td><?= number_format($bookingCost) ?></td>
                                                        <td>0</td>
                                                        <td><?= number_format($bookingCost + 0) ?></td>
                                                    </tr>
                                                <?php
                                            }

                                            else {
                                                ?>  
                                                    <div class="table-empty-message">Không tìm thấy kết quả...</div>
                                                <?php
                                            }
                                        }
                                    }
                                ?>
                            </table>
                        </div>

                        <!-- Add & profit area -->
                        <div class="add-and-profit-area">
                            <a href="./API/add.php?bookingid=<?= $bookingId ?>&bookingdate=<?= $bookingDate ?>" class="add-button">Thêm</a>
                        
                            <?php
                                if (isset($totalDayProfit)) {
                                    ?>
                                        <!-- Display day profit -->
                                        <div class="day-profit">
                                            Tổng doanh thu của ngày: 
                                            <span><?= number_format($totalDayProfit) ?>đ</span>
                                        </div>
                                    <?php
                                }

                                else {
                                    ?>
                                    <!-- Display day profit -->
                                    <div class="day-profit">
                                        Tổng doanh thu của ngày: 
                                        <span>0đ</span>
                                    </div>
                                <?php
                                }
                            ?>
                        </div>
                    <?php
                }

                // Display error message if no date is chosen
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