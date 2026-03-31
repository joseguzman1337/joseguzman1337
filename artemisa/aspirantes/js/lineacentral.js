$(document).ready(function () {
    $("#sincronizar").click(function (e) {
        e.stopPropagation();
        e.preventDefault();
        var url = $(this).attr("href");

        $.ajax({
            url: url,
            type: "GET",
            dataType: "json",
            data: {},
            success: function (data) {
                alert(data.msj);
                window.location.reload();
            },
            error: function (xhr, ajaxOptions, thrownError) {}
        });
    });
});