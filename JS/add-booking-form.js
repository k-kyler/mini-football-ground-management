$(function() {
    // Config dialog
    $("#addBookingForm").dialog({
        autoOpen: false,
        height: 400,
        width: 350,
        resizable: false,
        modal: true,
        draggable: false,
        hide: "fadeOut",
        show : "fadeIn"
    });

    // Open dialog
    $("#addButton").click(function() {
        $("#addBookingForm").dialog("open");
    });
    
    // Hide add new user when choose add old user
    $("#oldUser").click(function() {
        $("#newUser").prop("checked", false);
        $("#addOld").css("display", "block");
        $("#addNew").css("display", "none");
    });

    // Hide add old user when choose add new user
    $("#newUser").click(function() {
        $("#oldUser").prop("checked", false);
        $("#addNew").css("display", "block");
        $("#addOld").css("display", "none");
    });

    // Create search box in select user real name
    $('#selectUserRealName').select2();
});