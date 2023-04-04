// Autohide alert after 7 seconds if not hovered
$(document).ready(function() {
    let alert = $(".alert");
    if (alert.length) {
        if (!alert.is(":hover")) {
            setTimeout(function() {
                alert.slideUp();
            }, 12000);
        }
    }
});

