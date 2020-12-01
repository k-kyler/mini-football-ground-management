$(document).ready(function() {
    // Config and open dialog
    $("#payHistoryButton").click(function() {
        $("#payBookingHistory")
            .dialog({
                autoOpen: false,
                height: 455,
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
    $('#selectUserRealNameHistory').select2();

    // Get booking data from hidden input
    let totalPaymentUsers = $("#totalPaymentUsers").val();
    let totalPaymentUsersList = [];

    for (let i = 1; i <= totalPaymentUsers; i++) {
        let temp = [];
        let userRealName = $("#userRealNameUsed" + i).val();
        let userPhone = $("#userPhoneUsed" + i).val();
        let userRealNameAndPhone = userRealName + ' - ' + userPhone;
        let groundName = $("#groundNameUsed" + i).val();
        let bookingStart = $("#bookingStartHistory" + i).val();
        let bookingEnd = $("#bookingEndHistory" + i).val();
        let groundCost = $("#paymentGroundCost" + i).val();
        let beverageCost = $("#paymentBeverageCost" + i).val();
        let beverageType = $("#paymentBeverageType" + i).val();
        let totalCost = $("#paymentTotalCost" + i).val();

        temp.push(userRealNameAndPhone);
        temp.push(groundName);
        temp.push(bookingStart);
        temp.push(bookingEnd);
        temp.push(groundCost);
        temp.push(beverageCost);
        temp.push(beverageType);
        temp.push(totalCost);

        totalPaymentUsersList.push(temp);
    }

    // Display pay data to pay form when choosing user
    $("#selectUserRealNameHistory").change(function() {
        for (let i = 0; i < totalPaymentUsersList.length; i++){
            if (totalPaymentUsersList[i][0] == $("#selectUserRealNameHistory").val()) {
                for (let j = 0; j < totalPaymentUsersList[i].length; j++) {
                    $("#groundUsed").text(totalPaymentUsersList[i][1]);

                    $("#timeStartUsed").text(totalPaymentUsersList[i][2]);
                    $("#timeEndUsed").text(totalPaymentUsersList[i][3]);

                    $("#groundCostUsed").text(Intl.NumberFormat().format(totalPaymentUsersList[i][4]) + ' VNĐ');
                    $("#groundCostUsedTemp").text(totalPaymentUsersList[i][4]);

                    // Calculate beverage cost of each and numbers
                    let tempBeverageCost = totalPaymentUsersList[i][5] / parseInt(totalPaymentUsersList[i][6].split(" x ")[1]);

                    if (totalPaymentUsersList[i][6] != " x 0") {
                        $("#beverageUsed").text(totalPaymentUsersList[i][6].split(" x ")[0] + ' - ' + Intl.NumberFormat().format(tempBeverageCost));
                        $("#beverageNumberUsed").text(totalPaymentUsersList[i][6].split(" x ")[1]);
                    }

                    else {
                        $("#beverageUsed").text("Không có");
                        $("#beverageNumberUsed").text(0);
                    }
                    

                    // Total beverage cost 
                    $("#beverageCostUsed").text(Intl.NumberFormat().format(totalPaymentUsersList[i][5]) + ' VNĐ');

                    // Total cost
                    $("#totalCostUsed").text(Intl.NumberFormat().format(totalPaymentUsersList[i][7]) + ' VNĐ');
                }
            }
        }
    });
});