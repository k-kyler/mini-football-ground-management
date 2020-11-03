$(function() {
    $("#addBookingForm").dialog({
        autoOpen: false,
        height: 400,
        width: 350,
        modal: true,
        draggable: false,
        hide: "fadeOut",
        show : "fadeIn",
        buttons: {
            "Xác nhận": function submitForm() {
                $("#addOld").submit();
            }
        }
    });

    $("#addButton").click(function() {
        $("#addBookingForm").dialog("open");
    });

    
    $("#oldUser").click(function() {
        $("#newUser").prop("checked", false)
        $("#addOld").css("display", "block");
        $("#addNew").css("display", "none");
    });

    $("#newUser").click(function() {
        $("#oldUser").prop("checked", false);
        $("#addNew").css("display", "block");
        $("#addOld").css("display", "none");
    });
});