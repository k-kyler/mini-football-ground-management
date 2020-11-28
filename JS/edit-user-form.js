$(document).ready(function() {
    // Config and open dialog
    $("#editButton").click(function() {
        $("#editUserForm")
            .dialog({
                autoOpen: false,
                height: 320,
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
    let totalUsers = $("#totalUsers").val();
    let totalUsersList = [];

    for (let i = 1; i <= totalUsers; i++) {
        let temp = [];
        let userRealName = $("#userRealName" + i).val();
        let userPhone = $("#userPhone" + i).val();
        let userRealNameAndPhone = userRealName + ' - ' + userPhone;
        let userEmail = $("#userEmail" + i).val();

        temp.push(userRealNameAndPhone);
        temp.push(userRealName);
        temp.push(userPhone);
        temp.push(userEmail);

        totalUsersList.push(temp);
    }

    // Display edit data to edit form when choosing user
    $("#selectUserRealNameEdit").change(function() {
        for (let i = 0; i < totalUsersList.length; i++){
            if (totalUsersList[i][0] == $("#selectUserRealNameEdit").val()) {
                for (let j = 0; j < totalUsersList[i].length; j++) {
                    $("#editRealName").val(totalUsersList[i][1]);

                    $("#editPhone").val(totalUsersList[i][2]);

                    $("#editEmail").val(totalUsersList[i][3]);
                }
            }
        }
    });
}); 