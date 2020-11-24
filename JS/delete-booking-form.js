$(document).ready(function() {
    // Config and open dialog
    $("#deleteButton").click(function() {
        $("#deleteBookingForm")
            .dialog({
                autoOpen: false,
                height: 220,
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
    $('#selectUserRealNameDelete').select2();
});