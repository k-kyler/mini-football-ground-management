<?php
    require_once('../Config/config.php');

    if (isset($_POST['editSubmit'])) {
        $db = getDatabase();

        // Current beverage name and cost
        $beverageNameAndCost = $_POST['selectBeverageName'];

        // Get current beverage name
        $beverageName = substr($beverageNameAndCost, 0, strpos($beverageNameAndCost, " - "));

        // Get current beverage cost
        $beverageNameAndCost = strrev($beverageNameAndCost);
        $beverageCost = strrev(substr($beverageNameAndCost, 0, strpos($beverageNameAndCost, " - ")));
        $beverageCost = (float)$beverageCost;

        // Edit beverage name
        $editBeverageName = $_POST['editBeverageName'];

        // Edit beverage cost
        $editBeverageCost = $_POST['editBeverageCost'];

        // Check if edit beverage name has existed
        $checkEditBeverageName = true;

        $newEditBeverageName = mysqli_escape_string($db, $editBeverageName);

        if ($beverageName != $editBeverageName) {
            $getNewEditBeverageName = $db -> query("select beverage_name from beverages where beverage_name = '$newEditBeverageName'");

            if ($getNewEditBeverageName -> num_rows > 0) {
                // Get current beverage id by name
                $getBeverageData = getIdByBeverageName($beverageName);
                $beverageData = $getBeverageData -> fetch_assoc();
                $beverageId = $beverageData['beverage_id'];

                // Get beverage id edit by edit name
                $getBeverageDataEdit = getIdByBeverageName($editBeverageName);
                $beverageDataEdit = $getBeverageDataEdit -> fetch_assoc();
                $beverageIdEdit = $beverageDataEdit['beverage_id'];

                if ($beverageId != $beverageIdEdit) {
                    $checkEditBeverageName = false;
                }
            }
        }

        else {
            // Get current beverage id by name
            $getBeverageData = getIdByBeverageName($beverageName);
            $beverageData = $getBeverageData -> fetch_assoc();
            $beverageId = $beverageData['beverage_id'];
        }

        // Check and insert into database
        if ($checkEditBeverageName == false) {
            $_SESSION['beverage-management-error'] = "Tên đồ uống đã tồn tại!";
        }

        else {
            $editBeverageName = mysqli_escape_string($db, $editBeverageName);
            $editBeverageCost = mysqli_escape_string($db, $editBeverageCost);

            $editBeverageQuery = "update beverages set
                                beverage_name = '$editBeverageName',
                                beverage_cost = '$editBeverageCost'
                            where beverage_id = '$beverageId'
                            ";
            $res = $db -> query($editBeverageQuery);

            $_SESSION['beverage-management-success'] = "Cập nhật thành công!";
        }
    }
    
    // Redirect back
    header("Location: ../management.php?m=beveragemanagement");
?>