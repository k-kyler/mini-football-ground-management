$(document).ready(function() {
    // Config and open dialog
    $("#payButton").click(function() {
        $("#payBookingForm")
            .dialog({
                autoOpen: false,
                height: 450,
                width: 350,
                resizable: false,
                modal: true,
                draggable: false,
                hide: "fadeOut",
                show : "fadeIn"
            })
            .dialog("open");
    });

    // Create search box in select user real name
    $('#selectUserRealNamePay').select2();

    // Create search box in select beverage
    $('#selectBeverage').select2();

    // Get booking data from hidden input
    let totalBookingUsers = $("#totalBookingUsers").val();
    let totalBookingUsersList = [];

    for (let i = 1; i <= totalBookingUsers; i++) {
        let temp = [];
        let userRealName = $("#userRealName" + i).val();
        let userPhone = $("#userPhone" + i).val();
        let userRealNameAndPhone = userRealName + ' - ' + userPhone;
        let groundName = $("#groundName" + i).val();
        let bookingStart = $("#bookingStart" + i).val();
        let bookingEnd = $("#bookingEnd" + i).val();
        let totalTime = $("#totalTime" + i).val();
        let groundCost = $("#groundCost" + i).val();
        // let beverageCost = $("#beverageCost" + i).val();
        // let beverageType = $("#beverageType" + i).val();
        // let isPaid = $("#isPaid" + i).val();

        temp.push(userRealNameAndPhone);
        temp.push(groundName);
        temp.push(bookingStart);
        temp.push(bookingEnd);
        temp.push(totalTime);
        temp.push(groundCost);
        // temp.push(beverageCost);
        // temp.push(beverageType);
        // temp.push(isPaid);

        totalBookingUsersList.push(temp);
    }

    // Display pay data to pay form when choosing user
    $("#selectUserRealNamePay").change(function() {
        for (let i = 0; i < totalBookingUsersList.length; i++){
            if (totalBookingUsersList[i][0] == $("#selectUserRealNamePay").val()) {
                for (let j = 0; j < totalBookingUsersList[i].length; j++) {
                    $("#selectGroundPay").val(totalBookingUsersList[i][1]);

                    $("#selectTimeStartPay-1").val(totalBookingUsersList[i][2].split(":")[0]);
                    $("#selectTimeStartPay-2").val(totalBookingUsersList[i][2].split(":")[1]);

                    $("#selectTimeEndPay-1").val(totalBookingUsersList[i][3].split(":")[0]);
                    $("#selectTimeEndPay-2").val(totalBookingUsersList[i][3].split(":")[1]);

                    $("#totalTime").val(totalBookingUsersList[i][4] + ' phút');

                    $("#groundCost").val(Intl.NumberFormat().format(totalBookingUsersList[i][5]) + ' VNĐ');
                    $("#groundCostTemp").val(totalBookingUsersList[i][5]);

                    $("#totalCost").val(Intl.NumberFormat().format(totalBookingUsersList[i][5]) + ' VNĐ');

                    // // Calculate beverage cost of each
                    // let tempBeverageCost = totalBookingUsersList[i][6] / parseInt(totalBookingUsersList[i][7].split(" x ")[1]);

                    // $("#selectBeverage").val(totalBookingUsersList[i][7].split(" x ")[0] + ' - ' + Intl.NumberFormat().format(tempBeverageCost)).trigger('change');
                    // $("#beverageNumber").val(totalBookingUsersList[i][7].split(" x ")[1]);
                    
                    // // Disable pay button if isPaid
                    // if (totalBookingUsersList[i][8] == "1") {
                    //     $("#paySubmit").prop('disabled', true);
                    //     $("#paySubmit").val("Đã thanh toán");
                    // }
                }
            }
        }
    });

    // Change cost when choosing beverages
    $("#selectBeverage").change(function() {
        let selectBeverage = $("#selectBeverage").val();
        let beverageNumber = $("#beverageNumber").val();
        let groundCost = $("#groundCostTemp").val();

        let beverageCost = parseInt(selectBeverage.split(" - ")[1]);
        let reCalculateTotalCost = parseInt(groundCost) + beverageCost * parseInt(beverageNumber) * 1000;

        if (selectBeverage != "") {
            $("#totalCost").val(Intl.NumberFormat().format(reCalculateTotalCost) + ' VNĐ');
        }
    });

    // Change cost when increase or decrease beverage number
    $("#beverageNumber").change(function() {
        let selectBeverage = $("#selectBeverage").val();
        let beverageNumber = $("#beverageNumber").val();
        let groundCost = $("#groundCostTemp").val();

        let beverageCost = parseInt(selectBeverage.split(" - ")[1]);
        let reCalculateTotalCost = parseInt(groundCost) + beverageCost * parseInt(beverageNumber) * 1000;

        if (selectBeverage != "") {
            $("#totalCost").val(Intl.NumberFormat().format(reCalculateTotalCost) + ' VNĐ');
        }
    });
});