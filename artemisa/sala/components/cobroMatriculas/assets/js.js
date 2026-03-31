$(document).on('click','.cobro', function (e) {
    e.preventDefault();
    e.stopPropagation();
    e.stopImmediatePropagation();

    var periodo = $(this).data("periodo");
    var porcentaje = $(this).data("porcentaje");
    var desde = $(this).data("desde");
    var hasta = $(this).data("hasta");
    var id =$(this).data("id");
    var item=$(this).data("item");
    
    var titulo = "Editar";

    if (id == "") {
        titulo = "Nuevo";
    }

    showLoader();

    $.ajax({
        url: HTTP_SITE + "/index.php",
        type: "POST",
        dataType: "html",

        data: {
            tmpl: 'json',
            option: "cobroMatriculas",
            layout: "nuevo",
            periodo: periodo,
            porcentaje:porcentaje,
            desde:desde,
            hasta:hasta,       
            item:item,
            dataAction: "nuevo"
        },
        success: function (data) {
            abrirModal(titulo + " Cobro Matricula", data);
            hideLoader();
        },
        error: function (xhr, ajaxOptions, thrownError) {}
    }).always(function () {
        hideLoader();
    });
});
