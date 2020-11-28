$(document).ready(function() {
    // Close popup message in booking
    $(".booking-error span").click(function() {
        $(".booking-error").css("display", "none");
    });

    $(".booking-success span").click(function() {
        $(".booking-success").css("display", "none");
    });

    // Close popup message in user management
    $(".user-management-error span").click(function() {
        $(".user-management-error").css("display", "none");
    });

    $(".user-management-success span").click(function() {
        $(".user-management-success").css("display", "none");
    });

    // Close popup message in beverage management
    $(".beverage-management-error span").click(function() {
        $(".beverage-management-error").css("display", "none");
    });

    $(".beverage-management-success span").click(function() {
        $(".beverage-management-success").css("display", "none");
    });

    // Close popup message when login
    $(".login-success span").click(function() {
        $(".login-success").css("display", "none");
    });

    // Close popup message when register
    $(".register-success span").click(function() {
        $(".register-success").css("display", "none");
    });
});