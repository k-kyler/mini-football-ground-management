<style>
    <?php 
        require_once('./CSS/beverage-management.css');
    ?>
</style>

<script src="./JS/close-popup-message.js?v=<?php echo time(); ?>"></script>

<?php
    ?>
        <div class="beverage-management-container">
            <!-- Beverage management processing -->
            <div class="beverage-management-title">Danh sách các đồ uống</div>

            <!-- Beverages list -->
            <div class="beverages-list">
                <table>
                    <tr>
                        <th>STT</th>
                        <th>Tên đồ uống</th>
                        <th>Giá tiền</th>
                    </tr>

                    <!-- Get beverages list data -->
                    <?php
                        $db = getDatabase();
                        $beveragesData = getBeverages($db);

                        if ($beveragesData != null && $beveragesData -> num_rows > 0) {
                            $number = 0;

                            while ($data = $beveragesData -> fetch_assoc()) {
                                $beverageName = $data['beverage_name'];
                                $beverageCost = $data['beverage_cost'];

                                ?>
                                    <tr>
                                        <td><?= $number += 1 ?></td>
                                        <td><?= $beverageName ?></td>
                                        <td><?= number_format($beverageCost) ?></td>
                                    </tr>

                                    <!-- Hidden input to store beverage data -->
                                    <input type="hidden" id="<?= 'beverageName' . $number ?>" value="<?= $beverageName ?>">
                                    <input type="hidden" id="<?= 'beverageCost' . $number ?>" value="<?= $beverageCost ?>">
                                <?php
                            }
                        }
                    ?>

                    <!-- Hidden input to store total of beverages -->
                    <input type="hidden" id="totalBeverages" value="<?= $number ?>">
                </table>
            </div>

            <!-- Controller -->
            <div class="beverage-management-controller">
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

        <!-- Add beverage form -->
        <div class="add-beverage-form" title="Thêm đồ uống mới" id="addBeverageForm">
            <form method="POST" action="API/add-beverage.php">
                <!-- Enter name -->
                <br>
                <label>Tên đồ uống: </label>
                <input required type="text" name="newBeverageName">

                <!-- Enter cost -->
                <br>
                <br>
                <label>Giá tiền: </label>
                <input required type="text" name="newBeverageCost">

                <br>
                <br>
                <input type="submit" name="newSubmit" onclick="return confirm('Thêm đồ uóng mới?');" class="new-submit" value="Thêm">
            </form>
        </div>

        <!-- Edit beverage form -->
        <div class="edit-beverage-form" title="Chỉnh sửa thông tin đồ uống" id="editBeverageForm">
            <form method="POST" action="API/edit-beverage.php">
                <!-- Select name -->
                <br>
                <select required name="selectBeverageName" id="selectBeverageNameEdit" style="width: 100%;">
                    <option selected="true" value="">(Chọn tên)</option>
                    
                    <?php
                        $beveragesData = getBeverages($db);

                        if ($beveragesData != null && $beveragesData -> num_rows > 0) {
                            while ($data = $beveragesData -> fetch_assoc()) {
                                $beverageName = $data['beverage_name'];
                                $beverageCost = $data['beverage_cost'];

                                ?>
                                    <option><?= $beverageName . " - " . $beverageCost ?></option>
                                <?php
                            }
                        }
                    ?>
                </select>

                <!-- Edit name -->
                <br>
                <br>
                <label>Tên đồ uống: </label>
                <input required type="text" name="editBeverageName" id="editBeverageName">

                <!-- Edit cost -->
                <br>
                <br>
                <label>Giá tiền: </label>
                <input required type="text" name="editBeverageCost" id="editBeverageCost">

                <br>
                <br>
                <input type="submit" name="editSubmit" onclick="return confirm('Chỉnh sửa đồ uóng?');" class="edit-submit" value="Cập nhật">
            </form>
        </div>

        <!-- Delete beverage form -->
        <div class="delete-beverage-form" title="Xóa đồ uống" id="deleteBeverageForm">
            <form method="POST" action="API/delete-beverage.php">
                <!-- Select name -->
                <br>
                <select required name="selectBeverageName" id="selectBeverageNameDelete" style="width: 100%;">
                    <option selected="true" value="">(Chọn tên)</option>
                    
                    <?php
                        $beveragesData = getBeverages($db);

                        if ($beveragesData != null && $beveragesData -> num_rows > 0) {
                            while ($data = $beveragesData -> fetch_assoc()) {
                                $beverageName = $data['beverage_name'];
                                $beverageCost = $data['beverage_cost'];

                                ?>
                                    <option><?= $beverageName . " - " . $beverageCost ?></option>
                                <?php
                            }
                        }
                    ?>
                </select>

                <br>
                <br>
                <input type="submit" onclick="return confirm('Bạn có chắc chắn muốn xóa?');" name="deleteSubmit" id="deleteSubmit" class="delete-submit" value="Xóa">
            </form>
        </div>

        <!-- Handling success & error message of beverage management -->
        <?php
            if (isset($_SESSION['beverage-management-error'])) {
                ?>
                    <div class="beverage-management-error">
                        <p><?= $_SESSION['beverage-management-error'] ?></p>
                        <span>&times;</span>
                    </div>
                <?php

                unset($_SESSION['beverage-management-error']);
            }

            if (isset($_SESSION['beverage-management-success'])) {
                ?>
                    <div class="beverage-management-success">
                        <p><?= $_SESSION['beverage-management-success'] ?></p>
                        <span>&times;</span>
                    </div>
                <?php

                unset($_SESSION['beverage-management-success']);
            }
        ?>
    <?php
?>

<script src="./JS/add-beverage-form.js?v=<?php echo time(); ?>"></script>
<script src="./JS/edit-beverage-form.js?v=<?php echo time(); ?>"></script>
<script src="./JS/delete-beverage-form.js?v=<?php echo time(); ?>"></script>