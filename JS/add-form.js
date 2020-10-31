$(function() {
    $("#addBookingForm").dialog({
        autoOpen: false,
        height: 400,
        width: 350,
        hide: "fadeOut",
        show : "fadeIn",
        buttons: {

        }
    });

    $("#addButton").click(function() {
        $("#addBookingForm").dialog("open");
    });
});