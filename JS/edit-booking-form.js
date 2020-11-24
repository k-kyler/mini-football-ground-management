$(document).ready(function() {
    // Config and open dialog
    $("#editButton").click(function() {
        $("#editBookingForm")
            .dialog({
                autoOpen: false,
                height: 430,
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
    $('#selectUserRealNameEdit').select2();

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

        temp.push(userRealNameAndPhone);
        temp.push(userRealName);
        temp.push(userPhone);
        temp.push(groundName);
        temp.push(bookingStart);
        temp.push(bookingEnd);

        totalBookingUsersList.push(temp);
    }

    // Display edit data to edit form when choosing user
    $("#selectUserRealNameEdit").change(function() {
        for (let i = 0; i < totalBookingUsersList.length; i++){
            if (totalBookingUsersList[i][0] == $("#selectUserRealNameEdit").val()) {
                for (let j = 0; j < totalBookingUsersList[i].length; j++) {
                    $("#editRealName").val(totalBookingUsersList[i][1]);

                    $("#editPhone").val(totalBookingUsersList[i][2]);

                    $("#selectGround").val(totalBookingUsersList[i][3]);

                    $("#selectTimeStart-1").val(totalBookingUsersList[i][4].split(":")[0]);
                    $("#selectTimeStart-2").val(totalBookingUsersList[i][4].split(":")[1]);

                    $("#selectTimeEnd-1").val(totalBookingUsersList[i][5].split(":")[0]);
                    $("#selectTimeEnd-2").val(totalBookingUsersList[i][5].split(":")[1]);
                }
            }
        }
    });
}); 