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

    // Require date picker 
    ?>
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
                            if (isset($_GET['u'])) {
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
                            }

                            // Processing for booking online
                            else if (isset($_GET['bo'])) {

                            }

                            // Processing for viewing ground status
                            else if (isset($_GET['s'])) {
                                $db = getDatabase();

                                ?>
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
                                                        <th></th>
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
                                    <!-- <div class="main-content">
                                        <div class="main-title"></div>
                                    </div> -->
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