<?php
    require_once('../Config/config.php');

    if (isset($_POST['deleteSubmit'])) {
        $db = getDatabase();

        // Current beverage name and cost
        $beverageNameAndCost = $_POST['selectBeverageName'];

        // Get current beverage name
        $beverageName = substr($beverageNameAndCost, 0, strpos($beverageNameAndCost, " - "));

        // Get current beverage id by name
        $getBeverageData = getIdByBeverageName($beverageName);
        $beverageData = $getBeverageData -> fetch_assoc();
        $beverageId = $beverageData['beverage_id'];

        // Delete from database
        $beverageId = mysqli_escape_string($db, $beverageId);

        $deleteBeverageQuery = "delete from beverages where beverage_id = '$beverageId'";

        $result = $db -> query($deleteBeverageQuery);

        // Announcement session
        $_SESSION['beverage-management-success'] = "Xóa đồ uống thành công!";

        // Redirect back
        header("Location: ../management.php?m=beveragemanagement");
    }
?>