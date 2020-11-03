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
                                    <th>Phí dịch vụ</th>
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
                                                            <a onclick="return confirm('Bạn muốn chỉnh sửa?');" href="./API/edit.php?bookingid=<?= $bookingId ?>&bookingdate=<?= $bookingDate ?>">
                                                                <i class="fas fa-edit"></i>
                                                            </a>
                                                            
                                                            <a onclick="return confirm('Bạn có chắc chắn muốn xóa?');" href="./API/delete.php?bookingid=<?= $bookingId ?>&bookingdate=<?= $bookingDate ?>">
                                                                <i class="far fa-trash-alt"></i>                                                        
                                                            </a>

                                                            <a onclick="return confirm('Bạn muốn thanh toán?');" href="./API/payment.php?bookingid=<?= $bookingId ?>&bookingdate=<?= $bookingDate ?>">
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
                            <button id="addButton" class="add-button">Thêm</button>
                            
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
                                    <th>Phí dịch vụ</th>
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
                                                            <a onclick="return confirm('Bạn muốn chỉnh sửa?');" href="./API/edit.php?bookingid=<?= $bookingId ?>&bookingdate=<?= $bookingDate ?>">
                                                                <i class="fas fa-edit"></i>
                                                            </a>
                                                            
                                                            <a onclick="return confirm('Bạn có chắc chắn muốn xóa?');" href="./API/delete.php?bookingid=<?= $bookingId ?>&bookingdate=<?= $bookingDate ?>">
                                                                <i class="far fa-trash-alt"></i>                                                        
                                                            </a>

                                                            <a onclick="return confirm('Bạn muốn thanh toán?');" href="./API/payment.php?bookingid=<?= $bookingId ?>&bookingdate=<?= $bookingDate ?>">
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
                            <button id="addButton" class="add-button">Thêm</button>
                            
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

        <!-- Add booking form -->
        <div class="add-booking-form" title="Thêm lịch đặt sân" id="addBookingForm">
            <!-- Choose type of users to display correct input form -->
            <input type="radio" id="oldUser">
            <label for="oldUser">Chọn người dùng có sẵn</label>
            <br>
            <input type="radio" id="newUser">
            <label for="newUser">Nhập người dùng mới</label>
            <br>
            <br>

            <!-- Input form for adding new user -->
            <form method="POST" action="API/add-booking.php?typeuser=new&bookingdate=<?= $bookingDate ?>" id="addNew">
                <br>
                <label for="">Nhập tên: </label>
                <input type="text">

                

                <br>
                <br>
                <input type="submit" name="newSubmit" class="new-submit" value="Xác nhận">
            </form>

            <!-- Input form for adding old user -->
            <form method="POST" action="API/add-booking.php?typeuser=old&bookingdate=<?= $bookingDate ?>" id="addOld">
                <!-- Select user real name -->
                <br>
                <select name="selectUserRealName" id="selectUserRealName" style="width: 100%;">
                    <option selected="true">(Chọn tên)</option>
                    <?php
                        $usersData = getUsers($db);

                        if ($usersData != null && $usersData -> num_rows > 0) {
                            while ($data = $usersData -> fetch_assoc()) {
                                $realName = $data['user_realname'];
                                $phone = $data['user_phone'];

                                if ($realName) {
                                    ?>
                                        <option><?= $realName . " - " . $phone ?></option>
                                    <?php
                                }
                            }
                        }
                    ?>
                </select>

                <!-- Select ground -->
                <br>
                <br>
                <label>Chọn sân: </label>
                <select name="selectGround">
                    <?php
                        $groundsData = getGrounds($db);

                        if ($groundsData != null && $groundsData -> num_rows > 0) {
                            while ($data = $groundsData -> fetch_assoc()) {
                                $groundName = $data['ground_name'];

                                if ($groundName) {
                                    ?>
                                        <option><?= $groundName ?></option>
                                    <?php
                                }
                            }
                        }
                    ?>
                </select>

                <!-- Select time start -->
                <br>
                <br>
                <label>Thời gian bắt đầu: </label>
                <select name="selectTimeStart-1">
                    <?php
                        for ($i = 7; $i <= 21; $i++) { 
                            ?>
                                <option><?= $i ?></option>
                            <?php
                        }
                    ?>
                </select>

                :

                <select name="selectTimeStart-2">
                    <?php
                        for ($i=0; $i < 12; $i++) { 
                            if ($i < 2) {
                                ?>
                                    <option><?= "0" . $i * 5 ?></option>
                                <?php
                            }

                            else {
                                ?>
                                    <option><?= $i * 5 ?></option>
                                <?php
                            }
                        }
                    ?>
                </select>

                <!-- Select time end -->
                <br>
                <br>
                <label>Thời gian kết thúc: </label>
                <select name="selectTimeEnd-1"> 
                    <?php
                        for ($i = 7; $i <= 21; $i++) { 
                            ?>
                                <option><?= $i ?></option>
                            <?php
                        }
                    ?>
                </select>

                :

                <select name="selectTimeEnd-2">
                    <?php
                        for ($i=0; $i < 12; $i++) { 
                            if ($i < 2) {
                                ?>
                                    <option><?= "0" . $i * 5 ?></option>
                                <?php
                            }

                            else {
                                ?>
                                    <option><?= $i * 5 ?></option>
                                <?php
                            }
                        }
                    ?>
                </select>
                
                <br>
                <br>
                <input type="submit" name="oldSubmit" class="old-submit" value="Xác nhận">
            </form>
        </div>

        
    <?php
?>

<script src="./JS/date-picker.js?v=<?php echo time(); ?>"></script>
<script src="./JS/add-booking-form.js?v=<?php echo time(); ?>"></script>