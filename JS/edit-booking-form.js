$(document).ready(function() {
    // Config and open dialog
    $("#editButton").click(function() {
        $("#editBookingForm")
            .dialog({
                autoOpen: false,
                height: 360,
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
});