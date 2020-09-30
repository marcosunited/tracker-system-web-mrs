$(document).ready(function() {
    $(".confirm").on("click", function(event, ui) {
        event.preventDefault();
        askYes = confirm("Are you sure?");

        if (askYes) {
            $link = $(this).attr("href");
            window.location.href = $link;
        } else {

        }
    });

    $(".midnight , .alert").on("click", function() {
        hideAlert();
    });
});

function showAlert(html = null) {
    if (html) {
        $(".alert").html(html);
    }
    $(".midnight").fadeIn(200);
    $(".alert").fadeIn(400);
}

function hideAlert() {
    $(".midnight").fadeOut();
    $(".alert").fadeOut();
}
