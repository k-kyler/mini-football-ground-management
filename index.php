<?php
    // Config
    require_once('./Config/config.php');
?>

<style>
    <?php 
        require_once('./CSS/slider-main.css');
        require_once('./CSS/main.css');
    ?>
</style>

<?php
    // Layout
    require_once('layout.php');

    ?>
        <!-- Require date picker for using view ground status site -->
        <script src="./JS/date-picker.js?v=<?php echo time(); ?>"></script>
    <?php

    ?>
        <div class="wrapper">
            <!-- Header -->
            <?php
                require_once('header.php'); 
            ?>

            <!-- Index container -->
            <div class="container">
                <div class="row">
                    <div class="col-2">

                    </div>

                    <!-- Content -->
                    <div class="col-8 col-0 col-mobile">
                        <?php
                            // Processing for user info
                            if (isset($_GET['ui'])) {
                                if (isset($_SESSION['user_name'])) {
                                    $sessionUserName = $_SESSION['user_name'];
                                    $db = getDatabase();
                                    $users = getUsers($db);

                                    if ($users != null && $users -> num_rows > 0) {
                                        while ($userData = $users -> fetch_assoc()) {
                                            $userRealName = $userData['user_realname'];
                                            $userName = $userData['user_name'];
                                            $userPhone = $userData['user_phone'];
                                            $userEmail = $userData['user_email'];

                                            if ($userName == $sessionUserName) {
                                                // User info
                                                ?>
                                                    <div class="user-info">
                                                        <div class="user-info-title">Thông tin cá nhân</div>

                                                        <!-- User real name -->
                                                        <br>
                                                        <br>
                                                        <br>
                                                        <label>Họ tên: </label>
                                                        <input disabled value="<?= $userRealName ?>" type="text">

                                                        <!-- User name -->
                                                        <br>
                                                        <br>
                                                        <label>Tên người dùng: </label>
                                                        <input disabled value="<?= $userName ?>" type="text">

                                                        <!-- User phone -->
                                                        <br>
                                                        <br>
                                                        <label>Số điện thoại: </label>
                                                        <input disabled value="<?= $userPhone ?>" type="tel" pattern="[0-9]{10}">

                                                        <!-- User email -->
                                                        <br>
                                                        <br>
                                                        <label>Email: </label>
                                                        <input disabled value="<?= $userEmail ?>" type="email">
                                                    </div>
                                                <?php

                                                // Booking history
                                                ?>
                                                    <div class="booking-history">
                                                        <div class="booking-history-title">Lịch sử đặt sân</div>

                                                        <div class="booking-history-list">
                                                            <table>
                                                                <tr>
                                                                    <th>STT</th>
                                                                    <th>Sân đã đặt</th>
                                                                    <th>Thời gian bắt đầu</th>
                                                                    <th>Thời gian kết thúc</th>
                                                                    <th>Ngày đặt</th>
                                                                </tr>

                                                                <?php
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

                                                                            // Get user data
                                                                            $getUserData = getUserById($userId);
                                                                            $userData = $getUserData -> fetch_assoc();
                                                                            $userNameBooking = $userData['user_name'];

                                                                            // Get ground data
                                                                            $getGroundData = getGroundById($groundId);
                                                                            $groundData = $getGroundData -> fetch_assoc();
                                                                            $groundName = $groundData['ground_name'];

                                                                            if ($userNameBooking == $sessionUserName) {
                                                                                ?>
                                                                                    <tr>
                                                                                        <td><?= $number += 1 ?></td>
                                                                                        <td><?= $groundName ?></td>
                                                                                        <td><?= $bookingStart ?></td>
                                                                                        <td><?= $bookingEnd ?></td>
                                                                                        <td><?= $bookingDate ?></td>
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
                                        }
                                    }
                                }

                                else {
                                    ?>
                                        <!-- Add style for footer -->
                                        <style>
                                            .footer {
                                                margin-top: 30rem;
                                            }
                                        </style>

                                        <div class='ui-error-message'>Hãy đăng nhập để xem thông tin</div>
                                    <?php
                                }
                            }

                            // Processing for booking online
                            else if (isset($_GET['bo'])) {
                                if (isset($_SESSION['user_name'])) {
                                    $db = getDatabase();

                                    ?>
                                        <!-- Add style for footer -->
                                        <style>
                                            .footer {
                                                margin-top: 20rem;
                                            }
                                        </style>

                                        <div class="booking-online">
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

                                            <?php
                                                if (isset($_GET['datechoose'])) {
                                                    ?>
                                                        <div class="booking-online-title">Thông tin đặt sân ngày <?= $_GET['datechoose'] ?></div>

                                                        <div class="booking-list">
                                                            <table>
                                                                <tr>
                                                                    <th>Khách hàng</th>
                                                                    <th>Số điện thoại</th>
                                                                    <th>Sân đã đặt</th>
                                                                    <th>Thời gian bắt đầu</th>
                                                                    <th>Thời gian kết thúc</th>
                                                                    <th>Ngày</th>
                                                                </tr>
                                                                
                                                                <!-- Get booking list data -->
                                                                <?php
                                                                    $db = getDatabase();
                                                                    $bookingDetailsData = getBookingDetails($db);

                                                                    if ($bookingDetailsData != null && $bookingDetailsData -> num_rows > 0) {
                                                                        $number = 0;
                                                                        
                                                                        while ($data = $bookingDetailsData -> fetch_assoc()) {
                                                                            $number += 1;

                                                                            $bookingId = $data['booking_id'];
                                                                            $userId = $data['user_id'];
                                                                            $groundId = $data['ground_id'];
                                                                            $bookingStart = $data['booking_start'];
                                                                            $bookingEnd = $data['booking_end'];
                                                                            $bookingDate = $data['booking_date'];

                                                                            // Get user data
                                                                            $getUserData = getUserById($userId);
                                                                            $userData = $getUserData -> fetch_assoc();
                                                                            $userRealName = $userData['user_realname'];
                                                                            $userName = $userData['user_name'];
                                                                            $userPhone = $userData['user_phone'];

                                                                            // Get ground data
                                                                            $getGroundData = getGroundById($groundId);
                                                                            $groundData = $getGroundData -> fetch_assoc();
                                                                            $groundName = $groundData['ground_name'];

                                                                            if ($bookingDate == $_GET['datechoose'] && $userName == $_SESSION['user_name']) {
                                                                                ?>
                                                                                    <tr>
                                                                                        <td><?= $userRealName ?></td>
                                                                                        <td><?= $userPhone ?></td>
                                                                                        <td><?= $groundName ?></td>
                                                                                        <td><?= $bookingStart ?></td>
                                                                                        <td><?= $bookingEnd ?></td>
                                                                                        <td><?= $_GET['datechoose'] ?></td>

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
                                                    <?php
                                                }

                                                else if (isset($_POST['dateChoose'])) {
                                                    ?>
                                                        <div class="booking-online-title">Thông tin đặt sân ngày <?= $_POST['dateChoose'] ?></div>

                                                        <div class="booking-list">
                                                            <table>
                                                                <tr>
                                                                    <th>Khách hàng</th>
                                                                    <th>Số điện thoại</th>
                                                                    <th>Sân đã đặt</th>
                                                                    <th>Thời gian bắt đầu</th>
                                                                    <th>Thời gian kết thúc</th>
                                                                    <th>Ngày</th>
                                                                </tr>
                                                                
                                                                <!-- Get booking list data -->
                                                                <?php
                                                                    $db = getDatabase();
                                                                    $bookingDetailsData = getBookingDetails($db);

                                                                    if ($bookingDetailsData != null && $bookingDetailsData -> num_rows > 0) {
                                                                        $number = 0;
                                                                        
                                                                        while ($data = $bookingDetailsData -> fetch_assoc()) {
                                                                            $number += 1;

                                                                            $bookingId = $data['booking_id'];
                                                                            $userId = $data['user_id'];
                                                                            $groundId = $data['ground_id'];
                                                                            $bookingStart = $data['booking_start'];
                                                                            $bookingEnd = $data['booking_end'];
                                                                            $bookingDate = $data['booking_date'];

                                                                            // Get user data
                                                                            $getUserData = getUserById($userId);
                                                                            $userData = $getUserData -> fetch_assoc();
                                                                            $userRealName = $userData['user_realname'];
                                                                            $userName = $userData['user_name'];
                                                                            $userPhone = $userData['user_phone'];

                                                                            // Get ground data
                                                                            $getGroundData = getGroundById($groundId);
                                                                            $groundData = $getGroundData -> fetch_assoc();
                                                                            $groundName = $groundData['ground_name'];

                                                                            if ($bookingDate == $_POST['dateChoose'] && $userName == $_SESSION['user_name']) {
                                                                                ?>
                                                                                    <tr>
                                                                                        <td><?= $userRealName ?></td>
                                                                                        <td><?= $userPhone ?></td>
                                                                                        <td><?= $groundName ?></td>
                                                                                        <td><?= $bookingStart ?></td>
                                                                                        <td><?= $bookingEnd ?></td>
                                                                                        <td><?= $_POST['dateChoose'] ?></td>

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
                                                    <?php
                                                }

                                                else {
                                                    ?>
                                                        <p class="booking-online-empty">Hãy chọn ngày đặt sân...</p>
                                                    <?php
                                                }
                                            ?>

                                            <div class="user-controller">
                                                <a id="addButton" class="controller-button" href="javascript:void(0)">
                                                    <i class="fas fa-user-plus"></i>
                                                </a>

                                                <a id="editButton" class="controller-button" href="javascript:void(0)">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                
                                                <a id="deleteButton" class="controller-button" href="javascript:void(0)">
                                                    <i class="far fa-trash-alt"></i>                                                        
                                                </a>
                                            </div>
                                        </div>

                                        <!-- Delete booking form -->
                                        <div class="delete-booking-form" title="Xóa lịch đặt sân" id="deleteBookingForm">
                                            <form method="POST" action="API/delete-booking.php?typebooking=online">
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
                                            <form method="POST" action="API/edit-booking.php?typebooking=online">
                                                <!-- Select user real name -->
                                                <br>
                                                <select required name="selectUserRealName" id="selectUserRealNameEdit" style="width: 100%;">                                                    
                                                    <option class="user-realname" selected="true" value="">(Chọn tên)</option>
                                                    
                                                    <?php
                                                        $bookingDetailsEditData = getBookingDetails($db);
                                                        
                                                        if (isset($_GET['datechoose'])) {
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

                                                        else if (isset($_POST['dateChoose'])) {
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
                                            <!-- Input form for adding online user -->
                                            <form method="POST" action="API/add-booking.php?typeuser=online" id="addOld">
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
                                                                $userName = $data['user_name'];

                                                                if ($userName == $_SESSION['user_name']) {
                                                                    ?>
                                                                        <option selected="true" class="user-realname"><?= $realName . " - " . $phone ?></option>
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

                                        <!-- Handling success or error message when booking -->
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

                                        <script>
                                            <?php 
                                                require_once('./JS/close-popup-message.js');
                                                require_once('./JS/add-booking-form.js');
                                                require_once('./JS/edit-booking-form.js');
                                                require_once('./JS/delete-booking-form.js');
                                            ?>
                                        </script>
                                    <?php
                                }

                                else {
                                    ?>
                                        <!-- Add style for footer -->
                                        <style>
                                            .footer {
                                                margin-top: 30rem;
                                            }
                                        </style>

                                        <div class='ui-error-message'>Hãy đăng nhập để sử dụng chức năng này</div>
                                    <?php
                                }
                            }

                            // Processing for viewing ground types
                            else if (isset($_GET['gt'])) {
                                if ($_GET['gt'] == "groundtype5") {
                                    ?>
                                        <!-- Add style for footer -->
                                        <style>
                                            .footer {
                                                margin-top: 20rem;
                                            }
                                        </style>

                                        <div class="ground-type-5">
                                            <h2>Sân 5 người</h2>
                                            <p>Số lượng: 4 sân.</p>
                                            <p>Sân hiện có: sân số 1, sân số 2, sân số 3, sân số 4</p>
                                        </div>
                                    <?php
                                }

                                else if ($_GET['gt'] == "groundtype7") {
                                    ?>
                                        <!-- Add style for footer -->
                                        <style>
                                            .footer {
                                                margin-top: 20rem;
                                            }
                                        </style>
                                        
                                        <div class="ground-type-5">
                                            <h2>Sân 7 người</h2>
                                            <p>Số lượng: 2 sân.</p>
                                            <p>Sân hiện có: sân số 5, sân số 6</p>
                                        </div>
                                    <?php
                                }

                                else if ($_GET['gt'] == "groundtype11") {
                                    ?>
                                        <!-- Add style for footer -->
                                        <style>
                                            .footer {
                                                margin-top: 20rem;
                                            }
                                        </style>
                                        
                                        <div class="ground-type-5">
                                            <h2>Sân 11 người</h2>
                                            <p>Số lượng: 1 sân.</p>
                                            <p>Sân hiện có: sân số 7</p>
                                        </div>
                                    <?php
                                }
                            }

                            // Processing for viewing ground status
                            else if (isset($_GET['gs'])) {
                                $db = getDatabase();

                                ?>
                                    <!-- Add style for footer -->
                                    <style>
                                        .footer {
                                            margin-top: 20rem;
                                        }
                                    </style>

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

                                                else {
                                                    ?>
                                                        <input type="text" required placeholder="dd/mm/yyyy" class="date" id="dateChoose" autocomplete="off" name="dateChoose">
                                                    <?php
                                                }
                                            ?>
                                            
                                            <input type="submit" value="Chọn" name="submit">
                                        </form>
                                    </div>
                                <?php

                                // Processing for displaying ground status table
                                if (isset($_POST['submit'])) {
                                    ?>
                                        <!-- Time & grounds status -->
                                        <div class="time-grounds-status">
                                            <div class="time-grounds-status-title">Tình trạng sân ngày <?= $_POST['dateChoose'] ?></div>
                    
                                            <div class="time-grounds-schedule">
                                                <table>
                                                    <tr>
                                                        <th>Tên sân</th>
                                                        <th>Khung giờ đã được đặt</th>
                                                        <th>Tình trạng</th>
                                                    </tr>
                                                    
                                                    <?php 
                                                        $groundsData = getGrounds($db);
                                                        $tempGroundIdCheck = "";
                    
                                                        if ($groundsData != null && $groundsData -> num_rows > 0) {                                        
                                                            while ($data = $groundsData -> fetch_assoc()) {
                                                                $groundId = $data['ground_id'];
                                                                $groundName = $data['ground_name'];
                    
                                                                ?>
                                                                    <tr>
                                                                        <td><?= $groundName ?></td>
                    
                                                                        <!-- Processing for displaying booking duration time -->
                                                                        <?php
                                                                            // Get booking detail data
                                                                            $combineTimes = "";
                                                                            $timesArray = array();
                                                                            $getBookingDetailsData = getBookingDetailByGroundIdAndDate($groundId, $_POST['dateChoose']);
                    
                                                                            if ($getBookingDetailsData != null && $getBookingDetailsData -> num_rows > 0) {
                                                                                while ($bookingDetailData = $getBookingDetailsData -> fetch_assoc()) {
                                                                                    $bookingStartDetail = $bookingDetailData['booking_start'];
                                                                                    $bookingEndDetail = $bookingDetailData['booking_end'];
                    
                                                                                    // Combine to display duration time
                                                                                    $combineTimes = $bookingStartDetail . " - " . $bookingEndDetail;
                    
                                                                                    // Store times to array
                                                                                    array_push($timesArray, $combineTimes);
                                                                                }
                                                                            }
                                                                        ?>
                    
                                                                        <!-- Processing to display ground status -->
                                                                        <?php
                                                                            if (count($timesArray) == 1) {
                                                                                ?>
                                                                                    <td class="is-booking-time"><?= $timesArray[0] ?></td>
                                                                                    <td class="is-using-ground">Đang hoạt động</td>
                                                                                <?php
                                                                            }
                    
                                                                            else if (count($timesArray) > 1) {
                                                                                ?>
                                                                                    <td class="is-booking-time">
                                                                                        <?= implode(", ", $timesArray) ?>
                                                                                    </td>
                    
                                                                                    <td class="is-using-ground">Đang hoạt động</td>
                                                                                <?php
                                                                            }
                                                                        ?>
                                                                    </tr>
                                                                <?php
                                                            }
                                                        }
                                                    ?>
                                                </table>
                                            </div>
                                        </div>
                                    <?php
                                }
                            }

                            // Processing for viewing ground cost and activity time
                            else if (isset($_GET['gcat'])) {
                                ?>
                                    <!-- Add style for footer -->
                                    <style>
                                        .footer {
                                            margin-top: 20rem;
                                        }
                                    </style>

                                    <div class="ground-cost-and-activity-times">
                                        <h2>Chi phí khi sử dụng sân</h2>
                                        <p>1 phút = 3,000 đồng.</p>

                                        <h2>Khung giờ hoạt động</h2>
                                        <p>Mở cửa từ thứ 2 đến thứ 7 trong tuần, ngoại trừ chủ nhật.</p>
                                        <p>Từ 9h00 sáng đến 21h00 tối.</p>
                                    </div>
                                <?php
                            }

                            // Processing for main page
                            else {
                                ?>
                                    <!-- Slider main -->
                                    <div class="slider-container">
                                        <div class="slider-main" id="sliderMain">
                                            <!-- Slideshow images -->
                                            <?php        
                                                $db = getDatabase();
                                                $res = getImages($db);

                                                if ($res != null && $res -> num_rows > 0) {
                                                    while ($data = $res -> fetch_assoc()) {
                                                        $imageSrc = $data['image_src'];
                                                        $imageType = $data['image_type'];

                                                        if ($imageType == "slide") {
                                                            ?>
                                                                <div class="slide fade">
                                                                    <img src="<?= $imageSrc ?>">
                                                                </div>
                                                            <?php
                                                        }
                                                    }
                                                }
                                            ?>

                                            <!-- Slider navigation -->
                                            <div class="slider-nav">
                                                <span class="nav-dot"></span>   
                                                <span class="nav-dot"></span>   
                                                <span class="nav-dot"></span>   
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Main Content -->
                                    <div class="main-content">
                                        <!-- Introduction -->
                                        <h2>Giới thiệu</h2>
                                        <p>Sân bóng mini KHV, trang cung cấp dịch vụ cho thuê sân bóng mini trực tuyến.</p>
                                        <p>Đặt sân dễ dàng, nhanh chóng và trải nghiệm dịch vụ chuyên nghiệp.</p>
                                        
                                        <!-- Quality -->
                                        <h2 class="quality-content">Chất lượng</h2>
                                        <p>Các sân bóng mini được đảm bảo tiêu chuẩn chất lượng cao.</p>
                                        <p>Luôn được bảo dưỡng định kỳ hằng tháng để mang lại cho khách hàng trải nghiệm một sân bóng xịn sò.</p>

                                        <!-- Discount -->
                                        <h2 class="discount-content">Ưu đãi</h2>
                                        <p>Miễn phí nước khi khách hàng đến đặt sân lần đầu.</p>
                                        <p>Hãy cùng đến trải nghiệm dịch vụ <a href="index.php?bo=bookingonline" class="experience-link">tại đây</a>.</p>
                                    </div>
                                <?php
                            }
                        ?>
                    </div>

                    <div class="col-2">

                    </div>
                </div>
            </div>
        </div>
    <?php

    // Footer
    require_once('footer.php');

    // Handling success message when login
    if (isset($_SESSION['login-success'])) {
        ?>
            <div class="login-success">
                <p><?= $_SESSION['login-success'] ?></p>
                <span>&times;</span>
            </div>
        <?php

        unset($_SESSION['login-success']);
    }
?>

<script>
    <?php 
        require_once('./JS/slider-main.js');
        require_once('./JS/close-popup-message.js');
    ?>
</script>