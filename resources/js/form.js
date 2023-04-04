// Give red * to label tag with required class
$(document).ready(function() {
    $("label.required").append("<span class='text-danger'> *</span>");
});

// Add data-bs-toggle="tooltip" data-bs-placement="bottom" title="Press Enter to search" property to the search input field
$(document).ready(function() {
    let searchInput = $("input[name='search']");
    searchInput.attr("data-bs-toggle", "tooltip");
    searchInput.attr("data-bs-placement", "bottom");
    searchInput.attr("title", "Press Enter to search");
    $('[data-bs-toggle="tooltip"]').tooltip();
});
