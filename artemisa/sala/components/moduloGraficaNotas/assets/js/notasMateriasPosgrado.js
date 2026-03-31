$(function(){
    $(".cabiarPeriodo").click(function(e){
        e.preventDefault();
        e.stopPropagation();
        cambiarPeriodo(this);
    });
});

function cambiarPeriodo(obj){
    var codigoPeriodo = $(obj).attr("data-codigoPeriodo");
    showLoader();
    $.ajax({
        url: HTTP_SITE+"/index.php",
        type: "POST",
        dataType: "html",
        data: {
            tmpl : 'json',
            layout : "notasMateriasPosgrado",
            option : "moduloGraficaNotas",
            codigoPeriodo : codigoPeriodo
        },
        success: function( data ){
            $("#contenido-estudiante").html(data);
            hideLoader();
        },
        error: function (xhr, ajaxOptions, thrownError) {}
    }).always(function() {
        hideLoader();
    });
}