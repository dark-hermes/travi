// Show spinnners when page is loading
$(window).on("load", function () {
    // Animate loader off screen
    $("#spinner").fadeOut("fast");
});

// Show spinners when request is sent
$(document).ajaxStart(function () {
    $("#spinner").show();
});
