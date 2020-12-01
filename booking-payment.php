<style>
    <?php 
        require_once('./CSS/booking-payment.css');
    ?>
</style>

<script src="./JS/date-picker.js?v=<?php echo time(); ?>"></script>
<script src="./JS/close-popup-message.js?v=<?php echo time(); ?>"></script>

<?php
    ?>
        <div class="booking-management-container">
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
                                    <th>Trạng thái</th>
                                </tr>
                                
                                <!-- Get booking list data -->
                                <?php
                                    $db = getDatabase();
                                    $bookingDetailsData = getBookingDetails($db);

                                    if ($bookingDetailsData != null && $bookingDetailsData -> num_rows > 0) {
                                        $number = 0;
                                        
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
                                                ?>
                                                    <tr>
                                                        <td><?= $number += 1 ?></td>
                                                        <td><?= $userRealName ?></td>
                                                        <td><?= $userPhone ?></td>
                                                        <td><?= $groundName ?></td>
                                                        <td><?= $bookingStart ?></td>
                                                        <td><?= $bookingEnd ?></td>
                                                        <td><?= $bookingTotaltime ?></td>
                                                        <td class="booking-status">Chưa thanh toán</td>

                                                        <!-- Hidden input to store edit & pay data -->
                                                        <input type="hidden" id="<?= 'userRealName' . $number ?>" value="<?= $userRealName ?>">
                                                        <input type="hidden" id="<?= 'userPhone' . $number ?>" value="<?= $userPhone ?>">
                                                        <input type="hidden" id="<?= 'groundName' . $number ?>" value="<?= $groundName ?>">
                                                        <input type="hidden" id="<?= 'bookingStart' . $number ?>" value="<?= $bookingStart ?>">
                                                        <input type="hidden" id="<?= 'bookingEnd' . $number ?>" value="<?= $bookingEnd ?>">
                                                        <input type="hidden" id="<?= 'totalTime' . $number ?>" value="<?= $bookingTotaltime ?>">
                                                        <input type="hidden" id="<?= 'groundCost' . $number ?>" value="<?= $bookingCost ?>">
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

                                <a id="payHistoryButton" class="controller-button" href="javascript:void(0)">
                                    <i class="fas fa-history"></i>
                                </a>
                            </div>
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
                                    <th>Trạng thái</th>
                                </tr>
                                
                                <!-- Get booking list data -->
                                <?php
                                    $db = getDatabase();
                                    $bookingDetailsData = getBookingDetails($db);

                                    if ($bookingDetailsData != null && $bookingDetailsData -> num_rows > 0) {
                                        $number = 0;
                                        
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
                                                ?>
                                                    <tr>
                                                        <td><?= $number += 1 ?></td>
                                                        <td><?= $userRealName ?></td>
                                                        <td><?= $userPhone ?></td>
                                                        <td><?= $groundName ?></td>
                                                        <td><?= $bookingStart ?></td>
                                                        <td><?= $bookingEnd ?></td>
                                                        <td><?= $bookingTotaltime ?></td>
                                                        <td class="booking-status">Chưa thanh toán</td>

                                                        <!-- Hidden input to store edit data -->
                                                        <input type="hidden" id="<?= 'userRealName' . $number ?>" value="<?= $userRealName ?>">
                                                        <input type="hidden" id="<?= 'userPhone' . $number ?>" value="<?= $userPhone ?>">
                                                        <input type="hidden" id="<?= 'groundName' . $number ?>" value="<?= $groundName ?>">
                                                        <input type="hidden" id="<?= 'bookingStart' . $number ?>" value="<?= $bookingStart ?>">
                                                        <input type="hidden" id="<?= 'bookingEnd' . $number ?>" value="<?= $bookingEnd ?>">
                                                        <input type="hidden" id="<?= 'totalTime' . $number ?>" value="<?= $bookingTotaltime ?>">
                                                        <input type="hidden" id="<?= 'groundCost' . $number ?>" value="<?= $bookingCost ?>">
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

                                <a id="payHistoryButton" class="controller-button" href="javascript:void(0)">
                                    <i class="fas fa-history"></i>
                                </a>
                            </div>
                        </div>
                    <?php
                }

                // Display error message if no date is chosen
                else {
                    ?>
                        <div class="empty-message">Bạn hãy chọn ngày để xem...</div>
                    <?php
                }
            ?>
        </div>

        <?php
            if (isset($_POST['submit'])) {
                ?>
                    <!-- Time & grounds status -->
                    <div class="time-grounds-status">
                        <div class="time-grounds-status-title">Tình trạng sân ngày <?= $_POST['dateChoose'] ?></div>

                        <div class="time-grounds-schedule">
                            <table>
                                <tr>
                                    <th></th>
                                    <th colspan="4">9:00</th>
                                    <th colspan="4">10:00</th>
                                    <th colspan="4">11:00</th>
                                    <th colspan="4">12:00</th>
                                    <th colspan="4">13:00</th>
                                    <th colspan="4">14:00</th>
                                    <th colspan="4">15:00</th>
                                    <th colspan="4">16:00</th>
                                    <th colspan="4">17:00</th>
                                    <th colspan="4">18:00</th>
                                    <th colspan="4">19:00</th>
                                    <th colspan="4">20:00</th>
                                    <th colspan="4">21:00</th>
                                </tr>
                                
                                <?php 
                                    $groundsData = getGrounds($db);

                                    if ($groundsData != null && $groundsData -> num_rows > 0) {
                                        while ($data = $groundsData -> fetch_assoc()) {
                                            $groundName = $data['ground_name'];
            
                                            if ($groundName) {
                                                ?>
                                                    <tr>
                                                        <td><?= $groundName ?></td>
                                                    </tr>
                                                <?php
                                            }
                                        }
                                    }
                                ?>
                            </table>
                        </div>
                    </div>
                <?php
            }

            else if (isset($_GET['datechoose'])) {
                ?>
                    <!-- Time & grounds status -->
                    <div class="time-grounds-status">
                        <div class="time-grounds-status-title">Tình trạng sân ngày <?= $_GET['datechoose'] ?></div>

                        <div class="time-grounds-schedule">
                            <table>
                                <tr>
                                    <th></th>
                                    <th colspan="4">9:00</th>
                                    <th colspan="4">10:00</th>
                                    <th colspan="4">11:00</th>
                                    <th colspan="4">12:00</th>
                                    <th colspan="4">13:00</th>
                                    <th colspan="4">14:00</th>
                                    <th colspan="4">15:00</th>
                                    <th colspan="4">16:00</th>
                                    <th colspan="4">17:00</th>
                                    <th colspan="4">18:00</th>
                                    <th colspan="4">19:00</th>
                                    <th colspan="4">20:00</th>
                                    <th colspan="4">21:00</th>
                                </tr>
                                
                                <?php 
                                    $groundsData = getGrounds($db);

                                    if ($groundsData != null && $groundsData -> num_rows > 0) {
                                        while ($data = $groundsData -> fetch_assoc()) {
                                            $groundName = $data['ground_name'];
            
                                            if ($groundName) {
                                                ?>
                                                    <tr>
                                                        <td><?= $groundName ?></td>
                                                    </tr>
                                                <?php
                                            }
                                        }
                                    }
                                ?>
                            </table>
                        </div>
                    </div>
                <?php
            }
        ?>

        <!-- Pay booking history -->
        <div class="pay-booking-history" title="Lịch sử đặt sân và thanh toán" id="payBookingHistory">
            <!-- Select user real name -->
            <br>
            <select required name="selectUserRealName" id="selectUserRealNameHistory" style="width: 100%;">
                <option selected="true" value="">(Chọn tên)</option>
                
                <?php
                    $bookingHistoriesData = getBookingHistories($db);
                    $count = 0;

                    if (isset($_POST['dateChoose'])) {
                        if ($bookingHistoriesData != null && $bookingHistoriesData -> num_rows > 0) {
                            while ($data = $bookingHistoriesData -> fetch_assoc()) {
                                $userIdHistory = $data['user_id'];
                                $bookingIdHistory = $data['booking_id'];
                                $bookingStartHistory = $data['booking_start'];
                                $bookingEndHistory = $data['booking_end'];
                                $groundIdHistory = $data['ground_id'];

                                // Get user detail by id
                                $getUserData = getUserById($userIdHistory);
                                $userData = $getUserData -> fetch_assoc();
                                $userRealName = $userData['user_realname'];
                                $userPhone = $userData['user_phone'];

                                // Get payment detail by id
                                $getPaymentData = getPaymentByBookingId($bookingIdHistory);
                                $paymentDate = '';
                                
                                if ($getPaymentData != null && $getPaymentData -> num_rows > 0) {
                                    $paymentData = $getPaymentData -> fetch_assoc();
                                    $paymentDate = $paymentData['payment_date'];
                                    $paymentBeverageType = $paymentData['beverage_type'];
                                    $paymentBeverageCost = $paymentData['beverage_cost'];
                                    $paymentGroundCost = $paymentData['ground_cost'];
                                    $paymentTotalCost = $paymentData['total_cost'];
                                }

                                if ($paymentDate == $_POST['dateChoose']) {
                                    $count += 1;

                                    ?>
                                        <option><?= $userRealName . " - " . $userPhone ?></option>

                                        <!-- Store data to hidden option -->
                                        <option  disabled id="<?= 'userRealNameUsed' . $count ?>" value="<?= $userRealName ?>"></option>
                                        <option  disabled id="<?= 'userPhoneUsed' . $count ?>" value="<?= $userPhone ?>"></option>
                                        <option  disabled id="<?= 'groundNameUsed' . $count ?>" value="<?= $groundName ?>"></option>
                                        <option  disabled id="<?= 'bookingStartHistory' . $count ?>" value="<?= $bookingStartHistory ?>"></option>
                                        <option  disabled id="<?= 'bookingEndHistory' . $count ?>" value="<?= $bookingEndHistory ?>"></option>
                                        <option  disabled id="<?= 'paymentGroundCost' . $count ?>" value="<?= $paymentGroundCost ?>"></option>
                                        <option  disabled id="<?= 'paymentBeverageType' . $count ?>" value="<?= $paymentBeverageType ?>"></option>
                                        <option  disabled id="<?= 'paymentBeverageCost' . $count ?>" value="<?= $paymentBeverageCost ?>"></option>
                                        <option  disabled id="<?= 'paymentTotalCost' . $count ?>" value="<?= $paymentTotalCost ?>"></option>
                                    <?php
                                }
                            }
                        }
                    }
                    
                    else if (isset($_GET['datechoose'])) {
                        if ($bookingHistoriesData != null && $bookingHistoriesData -> num_rows > 0) {
                            while ($data = $bookingHistoriesData -> fetch_assoc()) {
                                $userIdHistory = $data['user_id'];
                                $bookingIdHistory = $data['booking_id'];
                                $bookingStartHistory = $data['booking_start'];
                                $bookingEndHistory = $data['booking_end'];
                                $groundIdHistory = $data['ground_id'];

                                // Get user detail by id
                                $getUserData = getUserById($userIdHistory);
                                $userData = $getUserData -> fetch_assoc();
                                $userRealName = $userData['user_realname'];
                                $userPhone = $userData['user_phone'];

                                // Get payment detail by id
                                $getPaymentData = getPaymentByBookingId($bookingIdHistory);
                                $paymentDate = '';
                                
                                if ($getPaymentData != null && $getPaymentData -> num_rows > 0) {
                                    $paymentData = $getPaymentData -> fetch_assoc();
                                    $paymentDate = $paymentData['payment_date'];
                                    $paymentBeverageType = $paymentData['beverage_type'];
                                    $paymentBeverageCost = $paymentData['beverage_cost'];
                                    $paymentGroundCost = $paymentData['ground_cost'];
                                    $paymentTotalCost = $paymentData['total_cost'];
                                }

                                // Get ground data
                                $getGroundData = getGroundById($groundIdHistory);
                                $groundData = $getGroundData -> fetch_assoc();
                                $groundName = $groundData['ground_name'];

                                if ($paymentDate == $_GET['datechoose']) {
                                    $count += 1;

                                    ?>
                                        <option><?= $userRealName . " - " . $userPhone ?></option>

                                        <!-- Store data to hidden option -->
                                        <option  disabled id="<?= 'userRealNameUsed' . $count ?>" value="<?= $userRealName ?>"></option>
                                        <option  disabled id="<?= 'userPhoneUsed' . $count ?>" value="<?= $userPhone ?>"></option>
                                        <option  disabled id="<?= 'groundNameUsed' . $count ?>" value="<?= $groundName ?>"></option>
                                        <option  disabled id="<?= 'bookingStartHistory' . $count ?>" value="<?= $bookingStartHistory ?>"></option>
                                        <option  disabled id="<?= 'bookingEndHistory' . $count ?>" value="<?= $bookingEndHistory ?>"></option>
                                        <option  disabled id="<?= 'paymentGroundCost' . $count ?>" value="<?= $paymentGroundCost ?>"></option>
                                        <option  disabled id="<?= 'paymentBeverageType' . $count ?>" value="<?= $paymentBeverageType ?>"></option>
                                        <option  disabled id="<?= 'paymentBeverageCost' . $count ?>" value="<?= $paymentBeverageCost ?>"></option>
                                        <option  disabled id="<?= 'paymentTotalCost' . $count ?>" value="<?= $paymentTotalCost ?>"></option>
                                    <?php
                                }
                            }
                        }
                    }
                ?>
            </select>

            <!-- Hidden input to store total payment history -->
            <input type="hidden" id="totalPaymentUsers" value="<?= $count ?>">

            <!-- Pay date -->
            <br>
            <br>
            <label>Ngày đặt: </label>
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

            <!-- Ground -->
            <br>
            <br>
            <label>Sân đã dùng: </label>
            <span id="groundUsed"></span>

            <!-- Time start -->
            <br>
            <br>
            <label>Thời gian bắt đầu: </label>
            <span id="timeStartUsed"></span>
          
            <!-- Select time end -->
            <br>
            <br>
            <label>Thời gian kết thúc: </label>
            <span id="timeEndUsed"></span>

            <!-- Beverage name and cost -->
            <br>
            <br>
            <label>Đồ uống: </label>
            <span id="beverageUsed"></span>

            <!-- Beverage number -->
            <br>
            <br>
            <label>Số lượng: </label>
            <span id="beverageNumberUsed"></span>
            
            <!-- Beverage cost -->
            <br>
            <br>
            <label>Phí đồ uống: </label>
            <span id="beverageCostUsed"></span>

            <!-- Ground cost -->
            <br>
            <br>
            <label>Phí đặt sân: </label>
            <span id="groundCostUsed"></span>
            <input type="hidden" name="groundCostTemp" id="groundCostUsedTemp">

            <!-- Total cost -->
            <br>
            <br>
            <label>Tổng chi phí: </label>
            <span id="totalCostUsed"></span>
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

                <!-- Select ground -->
                <br>
                <br>
                <label>Sân: </label>
                <select name="selectGround" id="selectGroundPay">
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
                <select name="selectTimeStart-1" id="selectTimeStartPay-1">
                    <?php
                        for ($i = 9; $i <= 21; $i++) { 
                            ?>
                                <option><?= $i ?></option>
                            <?php
                        }
                    ?>
                </select>

                :

                <select name="selectTimeStart-2" id="selectTimeStartPay-2">
                    <option>00</option>
                    <option>15</option>
                    <option>30</option>
                    <option>45</option>
                </select>

                <!-- Select time end -->
                <br>
                <br>
                <label>Thời gian kết thúc: </label>
                <select name="selectTimeEnd-1" id="selectTimeEndPay-1"> 
                    <?php
                        for ($i = 9; $i <= 21; $i++) { 
                            ?>
                                <option><?= $i ?></option>
                            <?php
                        }
                    ?>
                </select>

                :

                <select name="selectTimeEnd-2" id="selectTimeEndPay-2">
                    <option>00</option>
                    <option>15</option>
                    <option>30</option>
                    <option>45</option>
                </select>

                <!-- Total time -->
                <br>
                <br>
                <label>Tổng thời gian: </label>
                <input type="text" required name="totalTime" id="totalTime">

                <!-- Beverage name and cost -->
                <br>
                <br>
                <label>Thêm đồ uống: </label>
                <select name="selectBeverage" id="selectBeverage">
                    <option selected="true" value="">(Thêm nước uống)</option>

                    <?php
                        $beveragesData = getBeverages($db);

                        if ($beveragesData != null && $beveragesData -> num_rows > 0) {
                            while ($data = $beveragesData -> fetch_assoc()) {
                                $beverageName = $data['beverage_name'];
                                $beverageCost = $data['beverage_cost'];

                                if ($beverageName && $beverageCost) {
                                    ?>
                                        <option><?= $beverageName . ' - ' . number_format($beverageCost) ?></option>
                                    <?php
                                }
                            }
                        }
                    ?>
                </select>

                <!-- Beverage number -->
                <br>
                <br>
                <label>Số lượng: </label>
                <input type="number" name="beverageNumber" id="beverageNumber" min="0" value="0">
                
                <!-- Ground cost -->
                <br>
                <br>
                <label>Phí đặt sân: </label>
                <input type="text" required name="groundCost" id="groundCost">
                <input type="hidden" required name="groundCostTemp" id="groundCostTemp">

                <!-- Total cost -->
                <br>
                <br>
                <label>Tổng chi phí: </label>
                <input type="text" required name="totalCost" id="totalCost">
                
                <br>
                <br>
                <input type="submit" onclick="return confirm('Bạn có chắc chắn muốn thanh toán?');" name="paySubmit" id="paySubmit" class="pay-submit" value="Thanh toán">
            </form>
        </div>
        
        <!-- Delete booking form -->
        <div class="delete-booking-form" title="Xóa lịch đặt sân" id="deleteBookingForm">
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
                        for ($i = 9; $i <= 21; $i++) { 
                            ?>
                                <option><?= $i ?></option>
                            <?php
                        }
                    ?>
                </select>

                :

                <select name="selectTimeStart-2" id="selectTimeStart-2">
                    <option>00</option>
                    <option>15</option>
                    <option>30</option>
                    <option>45</option>
                </select>

                <!-- Select time end -->
                <br>
                <br>
                <label>Thời gian kết thúc: </label>
                <select name="selectTimeEnd-1" id="selectTimeEnd-1"> 
                    <?php
                        for ($i = 9; $i <= 21; $i++) { 
                            ?>
                                <option><?= $i ?></option>
                            <?php
                        }
                    ?>
                </select>

                :

                <select name="selectTimeEnd-2" id="selectTimeEnd-2">
                    <option>00</option>
                    <option>15</option>
                    <option>30</option>
                    <option>45</option>
                </select>
                
                <br>
                <br>
                <input type="submit" name="editSubmit" onclick="return confirm('Bạn có chắc chắn muốn chỉnh sửa?');" id="editSubmit" class="edit-submit" value="Cập nhật">
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
                        for ($i = 9; $i <= 21; $i++) { 
                            ?>
                                <option><?= $i ?></option>
                            <?php
                        }
                    ?>
                </select>

                :

                <select name="selectTimeStart-2">
                    <option>00</option>
                    <option>15</option>
                    <option>30</option>
                    <option>45</option>
                </select>

                <!-- Select time end -->
                <br>
                <br>
                <label>Thời gian kết thúc: </label>
                <select name="selectTimeEnd-1"> 
                    <?php
                        for ($i = 9; $i <= 21; $i++) { 
                            ?>
                                <option><?= $i ?></option>
                            <?php
                        }
                    ?>
                </select>

                :

                <select name="selectTimeEnd-2">
                    <option>00</option>
                    <option>15</option>
                    <option>30</option>
                    <option>45</option>
                </select>

                <br>
                <br>
                <input type="submit" onclick="return confirm('Thêm lịch đặt?');" name="newSubmit" class="new-submit" value="Xác nhận">
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
                        for ($i = 9; $i <= 21; $i++) { 
                            ?>
                                <option><?= $i ?></option>
                            <?php
                        }
                    ?>
                </select>

                :

                <select name="selectTimeStart-2">
                    <option>00</option>
                    <option>15</option>
                    <option>30</option>
                    <option>45</option>
                </select>

                <!-- Select time end -->
                <br>
                <br>
                <label>Thời gian kết thúc: </label>
                <select name="selectTimeEnd-1"> 
                    <?php
                        for ($i = 9; $i <= 21; $i++) { 
                            ?>
                                <option><?= $i ?></option>
                            <?php
                        }
                    ?>
                </select>

                :

                <select name="selectTimeEnd-2">
                    <option>00</option>
                    <option>15</option>
                    <option>30</option>
                    <option>45</option>
                </select>

                <br>
                <br>
                <input type="submit" onclick="return confirm('Thêm lịch đặt?');" name="oldSubmit" id="oldSubmit" class="old-submit" value="Xác nhận">
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
<script src="./JS/pay-booking-history.js?v=<?php echo time(); ?>"></script>