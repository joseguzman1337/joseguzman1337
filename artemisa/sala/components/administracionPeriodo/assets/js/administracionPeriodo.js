$(function () {
    
    $(document).on('click', '.accionMenu', function (e) {
        configuracionBasica(e);
        var dataAction = $(this).data("action");
        var dataType = $(this).data("type");
        
        mostrarFormulario(dataAction, "administracionPeriodo", "cargarContenido", dataType);
    });


    function configuracionBasica(e) {
        e.preventDefault( );
        e.stopPropagation();
        e.stopImmediatePropagation();
        $("#cargarContenido").html("");
        $('.dropdown').removeClass('open');
        showLoader();
    }

    function mostrarFormulario(dataAction, option, div, dataType) {
        $.ajax({
            url: HTTP_SITE + "/index.php",
            type: "POST",
            dataType: "html",
            data: {
                tmpl: 'json',
                layout: dataAction+dataType,
                option: option,
                dataAction: dataAction,
                dataType: dataType
            },
            success: function (data) {
                $("#" + div).html(data);
                hideLoader();
            }
        });
    }

})


