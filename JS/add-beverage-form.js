$(function() {
    // Config dialog
    $("#addBeverageForm").dialog({
        autoOpen: false,
        height: 215,
        width: 350,
        resizable: false,
        modal: true,
        draggable: false,
        hide: "fadeOut",
        show : "fadeIn"
    });

    // Open dialog
    $("#addButton").click(function() {
        $("#addBeverageForm").dialog("open");
    });
});