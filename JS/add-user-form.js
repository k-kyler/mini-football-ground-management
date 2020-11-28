$(function() {
    // Config dialog
    $("#addUserForm").dialog({
        autoOpen: false,
        height: 255,
        width: 350,
        resizable: false,
        modal: true,
        draggable: false,
        hide: "fadeOut",
        show : "fadeIn"
    });

    // Open dialog
    $("#addButton").click(function() {
        $("#addUserForm").dialog("open");
    });
});