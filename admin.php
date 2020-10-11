<style>
    <?php 
        require_once('./CSS/admin.css');
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

        <!-- Admin page content -->
        <div class="admin-container">
            <div class="admin">
                Xin chào <?= $_SESSION['user_name'] ?>!

                <div class="admin-logout">
                    <a href="logout.php">Đăng xuất</a>
                </div>
            </div>

            <div class="date-picker">
                <form action="" method="POST">
                    <label for="dateChoose">Chọn ngày:</label>
    
                    <?php 
                        if (isset($_POST['submit'])) {
                            ?>
                                <input type="text" id="dateChoose" name="dateChoose" value="<?= $_POST['dateChoose'] ?>">
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

            <?php
                if (isset($_POST['submit'])) {
                    ?>
                        <div class="booking-title">Danh sách đặt sân ngày <?= $_POST['dateChoose'] ?></div>

                        <div class="booking-list">
                            <table>
                                <tr>
                                    <th>STT</th>
                                    <th>Tên Khách Hàng</th>
                                    <th>Số điện thoại</th>
                                    <th>Sân đã đặt</th>
                                    <th>Thời gian bắt đầu</th>
                                    <th>Thời gian kết thúc</th>
                                    <th>Tổng thời gian (phút)</th>
                                    <th>Tổng tiền</th>
                                    <th></th>
                                </tr>
                    
                                <?php
                                    $db = getDatabase();
                                    $bookingDetailsData = getBookingDetails($db);

                                    if ($bookingDetailsData != null && $bookingDetailsData -> num_rows > 0) {
                                        $count = 0;
                                        
                                        while ($data = $bookingDetailsData -> fetch_assoc()) {
                                            $bookingName = $data['booking_name'];
                                            $bookingPhone = $data['booking_phone'];
                                            $bookingGround = $data['booking_ground'];
                                            $bookingStart = $data['booking_start'];
                                            $bookingEnd = $data['booking_end'];
                                            $bookingTotaltime = $data['booking_totaltime'];
                                            $bookingTotalmoney = $data['booking_totalmoney'];
                                            $bookingDate = $data['booking_date'];
                                            
                                            if ($bookingDate == $_POST['dateChoose']) {
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
                                                            <button>Xóa</button>
                                                        </td>
                                                    </tr>
                                                <?php
                                            }

                                            if ($bookingDate != $_POST['dateChoose']) {
                                                ?>  
                                                    <tr>
                                                        <td colspan="9" class="table-empty-message">Không tìm thấy kết quả...</td>
                                                    </tr>
                                                <?php
                                            }
                                        }
                                    }
                                ?>
                            </table>
                        </div>
                    <?php
                }

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