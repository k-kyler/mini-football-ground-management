<style>
    <?php 
        require_once('./CSS/user-management.css');
    ?>
</style>

<script src="./JS/close-popup-message.js?v=<?php echo time(); ?>"></script>

<?php
    ?>
        <div class="user-management-container">
            <!-- User management processing -->
            <div class="user-management-title">Danh sách các người dùng</div>

            <!-- Users list -->
            <div class="users-list">
                <table>
                    <tr>
                        <th>STT</th>
                        <th>Tên người dùng</th>
                        <th>Số điện thoại</th>
                        <th>Email</th>
                    </tr>

                    <!-- Get users list data -->
                    <?php
                        $db = getDatabase();
                        $usersData = getUsers($db);

                        if ($usersData != null && $usersData -> num_rows > 0) {
                            $number = 0;

                            while ($data = $usersData -> fetch_assoc()) {
                                $userRealName = $data['user_realname'];
                                $userPhone = $data['user_phone'];
                                $userEmail = $data['user_email'];
                                $userType = $data['user_type'];

                                if ($userType == "") {
                                    ?>
                                        <tr>
                                            <td><?= $number += 1 ?></td>
                                            <td><?= $userRealName ?></td>
                                            <td><?= $userPhone ?></td>
                                            <td><?= $userEmail ?></td>
                                        </tr>

                                        <!-- Hidden input to store user data -->
                                        <input type="hidden" id="<?= 'userRealName' . $number ?>" value="<?= $userRealName ?>">
                                        <input type="hidden" id="<?= 'userPhone' . $number ?>" value="<?= $userPhone ?>">
                                        <input type="hidden" id="<?= 'userEmail' . $number ?>" value="<?= $userEmail ?>">
                                    <?php
                                }
                            }
                        }
                    ?>

                    <!-- Hidden input to store total of users -->
                    <input type="hidden" id="totalUsers" value="<?= $number ?>">
                </table>
            </div>

            <!-- Controller -->
            <div class="user-management-controller">
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
                </div>
            </div>
        </div>

        <!-- Add user form -->
        <div class="add-user-form" title="Thêm người dùng mới" id="addUserForm">
            <form method="POST" action="API/add-user.php">
                <!-- Enter name -->
                <br>
                <label>Họ tên: </label>
                <input required type="text" name="newRealName">

                <!-- Enter phone -->
                <br>
                <br>
                <label>Số điện thoại: </label>
                <input required type="tel" pattern="[0-9]{10}" name="newPhone">
                
                <!-- Enter email -->
                <br>
                <br>
                <label>Email: </label>
                <input required type="email" name="newEmail">

                <br>
                <br>
                <input type="submit" name="newSubmit" onclick="return confirm('Thêm người dùng mới?');" class="new-submit" value="Thêm">
            </form>
        </div>

        <!-- Edit user form -->
        <div class="edit-user-form" title="Chỉnh sửa thông tin người dùng" id="editUserForm">
            <form method="POST" action="API/edit-user.php">
                <!-- Select user real name -->
                <br>
                <select required name="selectUserRealName" id="selectUserRealNameEdit" style="width: 100%;">
                    <option class="user-realname" selected="true" value="">(Chọn tên)</option>
                    
                    <?php
                        $usersData = getUsers($db);

                        if ($usersData != null && $usersData -> num_rows > 0) {
                            while ($data = $usersData -> fetch_assoc()) {
                                $userRealName = $data['user_realname'];
                                $userPhone = $data['user_phone'];
                                $userType = $data['user_type'];

                                if ($userType == "") {
                                    ?>
                                        <option class="user-realname"><?= $userRealName . " - " . $userPhone ?></option>
                                    <?php
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
                
                <!-- Edit email -->
                <br>
                <br>
                <label>Email: </label>
                <input required type="email" name="editEmail" id="editEmail">

                <br>
                <br>
                <input type="submit" name="editSubmit" onclick="return confirm('Bạn có chắc chắn muốn chỉnh sửa?');" class="edit-submit" value="Cập nhật">
            </form>
        </div>

        <!-- Delete user form -->
        <div class="delete-user-form" title="Xóa người dùng" id="deleteUserForm">
            <form method="POST" action="API/delete-user.php">
                <!-- Select user real name -->
                <br>
                <select required name="selectUserRealName" id="selectUserRealNameDelete" style="width: 100%;">
                    <option class="user-realname" selected="true" value="">(Chọn tên)</option>
                    
                    <?php
                        $usersData = getUsers($db);

                        if ($usersData != null && $usersData -> num_rows > 0) {
                            while ($data = $usersData -> fetch_assoc()) {
                                $userRealName = $data['user_realname'];
                                $userPhone = $data['user_phone'];
                                $userType = $data['user_type'];

                                if ($userType == "") {
                                    ?>
                                        <option class="user-realname"><?= $userRealName . " - " . $userPhone ?></option>
                                    <?php
                                }
                            }
                        }
                    ?>
                </select>

                <br>
                <br>
                <input type="submit" onclick="return confirm('Bạn có chắc chắn muốn xóa?');" name="deleteSubmit" id="deleteSubmit" class="delete-submit" value="Xóa">
            </form>
        </div>

        <!-- Handling success & error message of user management -->
        <?php
            if (isset($_SESSION['user-management-error'])) {
                ?>
                    <div class="user-management-error">
                        <p><?= $_SESSION['user-management-error'] ?></p>
                        <span>&times;</span>
                    </div>
                <?php

                unset($_SESSION['user-management-error']);
            }

            if (isset($_SESSION['user-management-success'])) {
                ?>
                    <div class="user-management-success">
                        <p><?= $_SESSION['user-management-success'] ?></p>
                        <span>&times;</span>
                    </div>
                <?php

                unset($_SESSION['user-management-success']);
            }
        ?>
    <?php
?>

<script src="./JS/add-user-form.js?v=<?php echo time(); ?>"></script>
<script src="./JS/edit-user-form.js?v=<?php echo time(); ?>"></script>
<script src="./JS/delete-user-form.js?v=<?php echo time(); ?>"></script>