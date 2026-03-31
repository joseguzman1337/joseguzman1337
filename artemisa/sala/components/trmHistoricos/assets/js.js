$(document).on('click','.trm', function (e) {
    e.preventDefault();
    e.stopPropagation();
    e.stopImmediatePropagation();
    let item = $(this).data("item");
    let valorTrm = $(this).data("valortrm");
    let fechaInicial = $(this).data("fechainicial");
    let fechaFin = $(this).data("fechafin");
    let tpMoneda = $(this).data("tipomoneda");
    let novedad = $(this).data("novedad");
    let estadoTrm = $(this).data("estadotrm");
    let dia = $(this).data("dia");
    let id =$(this).data("id");
    var titulo = "Editar";
    if (id == "") {
        dataction ='nuevo';
        titulo = "Nuevo";
    }else{
        dataction ='editar';
    }
    showLoader();
    $.ajax({
        url: HTTP_SITE + "/index.php",
        type: "POST",
        dataType: "html",
        data: {
            tmpl: 'json',
            option: "trmHistoricos",
            layout: "nuevo",
            item: item,
            valorTrm: valorTrm,
            fechaInicial: fechaInicial,
            fechaFin: fechaFin,
            tpMoneda: tpMoneda,
            novedad: novedad,
            estadoTrm:estadoTrm,
            dia: dia,
            dataAction: dataction
        },
        success: function (data) {
            abrirModal(titulo + " TRM Historico", data);
            hideLoader();
        },
        error: function (xhr, ajaxOptions, thrownError) {}
    }).always(function () {
        hideLoader();
    });
});
