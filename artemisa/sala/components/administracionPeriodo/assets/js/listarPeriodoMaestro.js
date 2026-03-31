$(document).on('click', '.accionPeriodoMaestro', function (e) {
    e.preventDefault( );
    e.stopPropagation();
    e.stopImmediatePropagation();
    id = $(this).data("id");
    var titulo = "Editar";
    if(id==""){
        titulo = "Nuevo";
    }
    showLoader();
    $.ajax({
        url: HTTP_SITE + "/index.php",
        type: "POST",
        dataType: "html",
       
        data: {
            tmpl: 'json',
            option: "administracionPeriodo",
            layout: "nuevoPeriodoMaestro",
            id:id,
            dataType: "PeriodoMaestro",
            dataAction:"nuevo"
        },
        success: function (data) {
            abrirModal(titulo+" Período maestro", data);
            hideLoader();
        },
        error: function (xhr, ajaxOptions, thrownError) {}
    }).always(function () {
        hideLoader();
    });

});

$(document).on('change', '#anio', function (e) {
    e.preventDefault( );
    e.stopPropagation();
    e.stopImmediatePropagation();
    var valor = $("#anio option:selected").html();
    $("#codigoMaestro").val(valor);
});