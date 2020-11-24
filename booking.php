<style>
    <?php 
        require_once('./CSS/booking.css');
    ?>
</style>

<script src="./JS/date-picker.js?v=<?php echo time(); ?>"></script>
<script src="./JS/close-popup-message.js?v=<?php echo time(); ?>"></script>

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
                <form action="" method="POST" name="dateChooseInput">
                    <label>Chọn ngày:</label>
    
                    <?php 
                        if (isset($_POST['submit'])) {
                            ?>
                                <input type="text" required placeholder="dd/mm/yyyy" class="date" id="dateChoose" autocomplete="off" name="dateChoose" value="<?= $_POST['dateChoose'] ?>">
                            <?php
                        }

                        else if (isset($_GET['datechoose'])) {
                            ?>
                                <input type="text" required placeholder="dd/mm/yyyy" class="date" id="dateChoose" autocomplete="off" name="dateChoose" value="<?= $_GET['datechoose'] ?>">
                            <?php
                        }

                        else {
                            ?>
                                <input type="text" required placeholder="dd/mm/yyyy" class="date" id="dateChoose" autocomplete="off" name="dateChoose">
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
                                    <th>Trạng thái</th>
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
                                                        <td style="color: red; font-weight: 600;">Chưa thanh toán</td>

                                                        <!-- Hidden input to store edit data -->
                                                        <input type="hidden" id="<?= 'userRealName' . $number ?>" value="<?= $userRealName ?>">
                                                        <input type="hidden" id="<?= 'userPhone' . $number ?>" value="<?= $userPhone ?>">
                                                        <input type="hidden" id="<?= 'groundName' . $number ?>" value="<?= $groundName ?>">
                                                        <input type="hidden" id="<?= 'bookingStart' . $number ?>" value="<?= $bookingStart ?>">
                                                        <input type="hidden" id="<?= 'bookingEnd' . $number ?>" value="<?= $bookingEnd ?>">
                                                    </tr>
                                                <?php
                                            }
                                        }
                                    }
                                ?>

                                <input type="hidden" id="totalBookingUsers" value="<?= $number ?>">
                            </table>
                        </div>
                        
                        <!-- Controller & profit area -->
                        <div class="controller-and-profit-area">
                            <div class="management-controller">
                                <a id="addButton" class="controller-button" href="javascript:void(0)">
                                    <i class="fas fa-user-plus"></i>
                                </a>

                                <a id="editButton" class="controller-button" href="javascript:void(0)">
                                    <i class="fas fa-edit"></i>
                                </a>
                                
                                <a id="deleteButton" class="controller-button" href="javascript:void(0)">
                                    <i class="far fa-trash-alt"></i>                                                        
                                </a>

                                <a id="payButton" class="controller-button" href="javascript:void(0)">
                                    <i class="fas fa-coins"></i>
                                </a>
                            </div>
                            
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
                                    <th>Trạng thái</th>
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
                                                        <td style="color: red; font-weight: 600">Chưa thanh toán</td>

                                                        <!-- Hidden input to store edit data -->
                                                        <input type="hidden" id="<?= 'userRealName' . $number ?>" value="<?= $userRealName ?>">
                                                        <input type="hidden" id="<?= 'userPhone' . $number ?>" value="<?= $userPhone ?>">
                                                        <input type="hidden" id="<?= 'groundName' . $number ?>" value="<?= $groundName ?>">
                                                        <input type="hidden" id="<?= 'bookingStart' . $number ?>" value="<?= $bookingStart ?>">
                                                        <input type="hidden" id="<?= 'bookingEnd' . $number ?>" value="<?= $bookingEnd ?>">
                                                    </tr>
                                                <?php
                                            }
                                        }
                                    }
                                ?>
                                
                                <input type="hidden" id="totalBookingUsers" value="<?= $number ?>">
                            </table>
                        </div>

                        <!-- Add & profit area -->
                        <div class="controller-and-profit-area">
                            <div class="management-controller">
                                <a id="addButton" class="controller-button" href="javascript:void(0)">
                                    <i class="fas fa-user-plus"></i>
                                </a>

                                <a id="editButton" class="controller-button" href="javascript:void(0)">
                                    <i class="fas fa-edit"></i>
                                </a>
                                
                                <a id="deleteButton" class="controller-button" href="javascript:void(0)">
                                    <i class="far fa-trash-alt"></i>                                                        
                                </a>

                                <a id="payButton" class="controller-button" href="javascript:void(0)">
                                    <i class="fas fa-coins"></i>
                                </a>
                            </div>
                            
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


        

        <!-- Pay booking form -->
        <div class="pay-booking-form" title="Thanh toán" id="payBookingForm">
            <form method="POST" action="API/pay-booking.php">
                <!-- Select user real name -->
                <br>
                <select required name="selectUserRealName" id="selectUserRealNamePay" style="width: 100%;">
                    <option class="user-realname" selected="true" value="">(Chọn tên)</option>
                    
                    <?php
                        $bookingDetailsEditData = getBookingDetails($db);

                        if (isset($_POST['dateChoose'])) {
                            if ($bookingDetailsEditData != null && $bookingDetailsEditData -> num_rows > 0) {
                                while ($data = $bookingDetailsEditData -> fetch_assoc()) {
                                    $userIdentity = $data['user_id'];
                                    $bookingDateEdit = $data['booking_date'];
    
                                    // Get user detail by id
                                    $getUserData = getUserById($userIdentity);
                                    $userData = $getUserData -> fetch_assoc();
                                    $userRealName = $userData['user_realname'];
                                    $userPhone = $userData['user_phone'];
    
                                    if ($bookingDateEdit == $_POST['dateChoose']) {
                                        ?>
                                            <option class="user-realname"><?= $userRealName . " - " . $userPhone ?></option>
                                        <?php
                                    }
                                }
                            }
                        }
                        
                        else if (isset($_GET['datechoose'])) {
                            if ($bookingDetailsEditData != null && $bookingDetailsEditData -> num_rows > 0) {
                                while ($data = $bookingDetailsEditData -> fetch_assoc()) {
                                    $userIdentity = $data['user_id'];
                                    $bookingDateEdit = $data['booking_date'];
    
                                    // Get user detail by id
                                    $getUserData = getUserById($userIdentity);
                                    $userData = $getUserData -> fetch_assoc();
                                    $userRealName = $userData['user_realname'];
                                    $userPhone = $userData['user_phone'];
    
                                    if ($bookingDateEdit == $_GET['datechoose']) {
                                        ?>
                                            <option class="user-realname"><?= $userRealName . " - " . $userPhone ?></option>
                                        <?php
                                    }
                                }
                            }
                        }
                    ?>
                </select>

                <!-- Pay date -->
                <br>
                <br>
                <label>Ngày: </label>
                <?php 
                    if (isset($_POST['submit'])) {
                        ?>
                            <input type="text" required placeholder="dd/mm/yyyy" class="date" autocomplete="off" name="dateChooseForm" value="<?= $_POST['dateChoose'] ?>">
                        <?php
                    }

                    else if (isset($_GET['datechoose'])) {
                        ?>
                            <input type="text" required placeholder="dd/mm/yyyy" class="date" autocomplete="off" name="dateChooseForm" value="<?= $_GET['datechoose'] ?>">
                        <?php
                    }

                    else {
                        ?>
                            <input type="text" required placeholder="dd/mm/yyyy" class="date" autocomplete="off" name="dateChooseForm">
                        <?php
                    }
                ?>

                <!-- Additional services fee -->
                <br>
                <br>
                <label>Phí dịch vụ: </label>
                <?php

                ?>
                
                <br>
                <br>
                <input type="submit" onclick="return confirm('Bạn có chắc chắn muốn thanh toán?');" name="paySubmit" id="paySubmit" class="pay-submit" value="Thanh toán">
            </form>
        </div>
        
        <!-- Delete booking form -->
        <div class="delete-booking-form" title="Hủy lịch đặt sân" id="deleteBookingForm">
            <form method="POST" action="API/delete-booking.php">
                <!-- Select user real name -->
                <br>
                <select required name="selectUserRealName" id="selectUserRealNameDelete" style="width: 100%;">
                    <option class="user-realname" selected="true" value="">(Chọn tên)</option>
                    
                    <?php
                        $bookingDetailsEditData = getBookingDetails($db);

                        if (isset($_POST['dateChoose'])) {
                            if ($bookingDetailsEditData != null && $bookingDetailsEditData -> num_rows > 0) {
                                while ($data = $bookingDetailsEditData -> fetch_assoc()) {
                                    $userIdentity = $data['user_id'];
                                    $bookingDateEdit = $data['booking_date'];
    
                                    // Get user detail by id
                                    $getUserData = getUserById($userIdentity);
                                    $userData = $getUserData -> fetch_assoc();
                                    $userRealName = $userData['user_realname'];
                                    $userPhone = $userData['user_phone'];
    
                                    if ($bookingDateEdit == $_POST['dateChoose']) {
                                        ?>
                                            <option class="user-realname"><?= $userRealName . " - " . $userPhone ?></option>
                                        <?php
                                    }
                                }
                            }
                        }
                        
                        else if (isset($_GET['datechoose'])) {
                            if ($bookingDetailsEditData != null && $bookingDetailsEditData -> num_rows > 0) {
                                while ($data = $bookingDetailsEditData -> fetch_assoc()) {
                                    $userIdentity = $data['user_id'];
                                    $bookingDateEdit = $data['booking_date'];
    
                                    // Get user detail by id
                                    $getUserData = getUserById($userIdentity);
                                    $userData = $getUserData -> fetch_assoc();
                                    $userRealName = $userData['user_realname'];
                                    $userPhone = $userData['user_phone'];
    
                                    if ($bookingDateEdit == $_GET['datechoose']) {
                                        ?>
                                            <option class="user-realname"><?= $userRealName . " - " . $userPhone ?></option>
                                        <?php
                                    }
                                }
                            }
                        }
                    ?>
                </select>

                <!-- Date -->
                <br>
                <br>
                <label>Ngày: </label>
                <?php 
                    if (isset($_POST['submit'])) {
                        ?>
                            <input type="text" required placeholder="dd/mm/yyyy" class="date" autocomplete="off" name="dateChooseForm" value="<?= $_POST['dateChoose'] ?>">
                        <?php
                    }

                    else if (isset($_GET['datechoose'])) {
                        ?>
                            <input type="text" required placeholder="dd/mm/yyyy" class="date" autocomplete="off" name="dateChooseForm" value="<?= $_GET['datechoose'] ?>">
                        <?php
                    }

                    else {
                        ?>
                            <input type="text" required placeholder="dd/mm/yyyy" class="date" autocomplete="off" name="dateChooseForm">
                        <?php
                    }
                ?>
                
                <br>
                <br>
                <input type="submit" onclick="return confirm('Bạn có chắc chắn muốn xóa?');" name="deleteSubmit" id="deleteSubmit" class="delete-submit" value="Xóa">
            </form>
        </div>

        <!-- Edit booking form -->
        <div class="edit-booking-form" title="Chỉnh sửa lịch đặt sân" id="editBookingForm">
            <form method="POST" action="API/edit-booking.php">
                <!-- Select user real name -->
                <br>
                <select required name="selectUserRealName" id="selectUserRealNameEdit" style="width: 100%;">
                    <option class="user-realname" selected="true" value="">(Chọn tên)</option>
                    
                    <?php
                        $bookingDetailsEditData = getBookingDetails($db);

                        if (isset($_POST['dateChoose'])) {
                            if ($bookingDetailsEditData != null && $bookingDetailsEditData -> num_rows > 0) {
                                while ($data = $bookingDetailsEditData -> fetch_assoc()) {
                                    $userIdentity = $data['user_id'];
                                    $bookingDateEdit = $data['booking_date'];
    
                                    // Get user detail by id
                                    $getUserData = getUserById($userIdentity);
                                    $userData = $getUserData -> fetch_assoc();
                                    $userRealName = $userData['user_realname'];
                                    $userPhone = $userData['user_phone'];
    
                                    if ($bookingDateEdit == $_POST['dateChoose']) {
                                        ?>
                                            <option class="user-realname"><?= $userRealName . " - " . $userPhone ?></option>
                                        <?php
                                    }
                                }
                            }
                        }
                        
                        else if (isset($_GET['datechoose'])) {
                            if ($bookingDetailsEditData != null && $bookingDetailsEditData -> num_rows > 0) {
                                while ($data = $bookingDetailsEditData -> fetch_assoc()) {
                                    $userIdentity = $data['user_id'];
                                    $bookingDateEdit = $data['booking_date'];
    
                                    // Get user detail by id
                                    $getUserData = getUserById($userIdentity);
                                    $userData = $getUserData -> fetch_assoc();
                                    $userRealName = $userData['user_realname'];
                                    $userPhone = $userData['user_phone'];
    
                                    if ($bookingDateEdit == $_GET['datechoose']) {
                                        ?>
                                            <option class="user-realname"><?= $userRealName . " - " . $userPhone ?></option>
                                        <?php
                                    }
                                }
                            }
                        }
                    ?>
                </select>

                <!-- Edit real name -->
                <br>
                <br>
                <label>Họ tên: </label>
                <input required type="text" name="editRealName" id="editRealName">

                <!-- Edit phone -->
                <br>
                <br>
                <label>Số điện thoại: </label>
                <input required type="tel" pattern="[0-9]{10}" name="editPhone" id="editPhone">

                <!-- Select date -->
                <br>
                <br>
                <label>Ngày: </label>
                <?php 
                    if (isset($_POST['submit'])) {
                        ?>
                            <input type="text" required placeholder="dd/mm/yyyy" class="date" autocomplete="off" name="dateChooseForm" value="<?= $_POST['dateChoose'] ?>">
                        <?php
                    }

                    else if (isset($_GET['datechoose'])) {
                        ?>
                            <input type="text" required placeholder="dd/mm/yyyy" class="date" autocomplete="off" name="dateChooseForm" value="<?= $_GET['datechoose'] ?>">
                        <?php
                    }

                    else {
                        ?>
                            <input type="text" required placeholder="dd/mm/yyyy" class="date" autocomplete="off" name="dateChooseForm">
                        <?php
                    }
                ?>

                <!-- Select ground -->
                <br>
                <br>
                <label>Sân: </label>
                <select name="selectGround" id="selectGround">
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
                <select name="selectTimeStart-1" id="selectTimeStart-1">
                    <?php
                        for ($i = 7; $i <= 21; $i++) { 
                            ?>
                                <option><?= $i ?></option>
                            <?php
                        }
                    ?>
                </select>

                :

                <select name="selectTimeStart-2" id="selectTimeStart-2">
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
                <select name="selectTimeEnd-1" id="selectTimeEnd-1"> 
                    <?php
                        for ($i = 7; $i <= 21; $i++) { 
                            ?>
                                <option><?= $i ?></option>
                            <?php
                        }
                    ?>
                </select>

                :

                <select name="selectTimeEnd-2" id="selectTimeEnd-2">
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
                <input type="submit" name="editSubmit" id="editSubmit" class="edit-submit" value="Cập nhật">
            </form>
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
            <form method="POST" action="API/add-booking.php?typeuser=new" id="addNew">
                <!-- Enter name -->
                <br>
                <label>Nhập tên: </label>
                <input required type="text" name="newRealName">

                <!-- Enter phone -->
                <br>
                <br>
                <label>Số điện thoại: </label>
                <input required type="tel" pattern="[0-9]{10}" name="newPhone">
                
                <!-- Select date -->
                <br>
                <br>
                <label>Chọn ngày: </label>
                <?php 
                    if (isset($_POST['submit'])) {
                        ?>
                            <input type="text" required placeholder="dd/mm/yyyy" class="date" autocomplete="off" name="dateChooseForm" value="<?= $_POST['dateChoose'] ?>">
                        <?php
                    }

                    else if (isset($_GET['datechoose'])) {
                        ?>
                            <input type="text" required placeholder="dd/mm/yyyy" class="date" autocomplete="off" name="dateChooseForm" value="<?= $_GET['datechoose'] ?>">
                        <?php
                    }

                    else {
                        ?>
                            <input type="text" required placeholder="dd/mm/yyyy" class="date" autocomplete="off" name="dateChooseForm">
                        <?php
                    }
                ?>

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
                <input type="submit" name="newSubmit" class="new-submit" value="Xác nhận">
            </form>

            <!-- Input form for adding old user -->
            <form method="POST" action="API/add-booking.php?typeuser=old" name="addBooking" id="addOld">
                <!-- Select user real name -->
                <br>
                <select required name="selectUserRealName" id="selectUserRealName" style="width: 100%;">
                    <option class="user-realname" selected="true" value="">(Chọn tên)</option>
                    
                    <?php
                        $usersData = getUsers($db);

                        if ($usersData != null && $usersData -> num_rows > 0) {
                            while ($data = $usersData -> fetch_assoc()) {
                                $realName = $data['user_realname'];
                                $phone = $data['user_phone'];

                                if ($realName) {
                                    ?>
                                        <option class="user-realname"><?= $realName . " - " . $phone ?></option>
                                    <?php
                                }
                            }
                        }
                    ?>
                </select>

                <!-- Select date -->
                <br>
                <br>
                <label>Chọn ngày: </label>
                <?php 
                    if (isset($_POST['submit'])) {
                        ?>
                            <input type="text" required placeholder="dd/mm/yyyy" class="date" autocomplete="off" name="dateChooseForm" value="<?= $_POST['dateChoose'] ?>">
                        <?php
                    }

                    else if (isset($_GET['datechoose'])) {
                        ?>
                            <input type="text" required placeholder="dd/mm/yyyy" class="date" autocomplete="off" name="dateChooseForm" value="<?= $_GET['datechoose'] ?>">
                        <?php
                    }

                    else {
                        ?>
                            <input type="text" required placeholder="dd/mm/yyyy" class="date" autocomplete="off" name="dateChooseForm">
                        <?php
                    }
                ?>

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
                <input type="submit" name="oldSubmit" id="oldSubmit" class="old-submit" value="Xác nhận">
            </form>
        </div>

        <!-- Handling success & error message of booking -->
        <?php
            if (isset($_SESSION['booking-error'])) {
                ?>
                    <div class="booking-error">
                        <p><?= $_SESSION['booking-error'] ?></p>
                        <span>&times;</span>
                    </div>
                <?php

                unset($_SESSION['booking-error']);
            }

            if (isset($_SESSION['booking-success'])) {
                ?>
                    <div class="booking-success">
                        <p><?= $_SESSION['booking-success'] ?></p>
                        <span>&times;</span>
                    </div>
                <?php

                unset($_SESSION['booking-success']);
            }
        ?>
    <?php
?>

<script src="./JS/add-booking-form.js?v=<?php echo time(); ?>"></script>
<script src="./JS/edit-booking-form.js?v=<?php echo time(); ?>"></script>
<script src="./JS/delete-booking-form.js?v=<?php echo time(); ?>"></script>
<script src="./JS/pay-booking-form.js?v=<?php echo time(); ?>"></script>