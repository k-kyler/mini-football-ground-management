$(document).ready(function() {
    $(".header-nav-mobile-down").click(function() {
        $(".header-nav").css("display", "block");
        $(".header-nav-mobile-up").removeClass("clicked-active");
        $(".header-nav-mobile-down").addClass("clicked-active");
    });

    $(".header-nav-mobile-up").click(function() {
        $(".header-nav").css("display", "none");
        $(".header-nav-mobile-down").removeClass("clicked-active");
        $(".header-nav-mobile-up").addClass("clicked-active");
    });
});