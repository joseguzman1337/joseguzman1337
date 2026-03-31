$(document).ready(function(){
    $(".seleccionarCarrera").click(function(e){
        e.stopPropagation();
        e.preventDefault();
        seleccionarCarrera(this);
    });
});
$('#datos').bootstrapTable({
    onPageChange: function (name, args) {
        $(".seleccionarCarrera").click(function(e){
            e.stopPropagation();
            e.preventDefault();
            seleccionarCarrera(this);
        });
    },
    onSort: function (name, args) {
        $(".seleccionarCarrera").click(function(e){
            e.stopPropagation();
            e.preventDefault();
            seleccionarCarrera(this);
        });
    }
});

function seleccionarCarrera(obj){
    contentHTML = alertContent.replace("fa-icon", dataAlert[0].icon);
    contentHTML = contentHTML.replace('<span class="text-2x"></span>', '<span class="text-2x">Está seguro de seleccionar esta carrera?</span>');
    var codigoCarrera = $(obj).attr("dataCodigoCarrera");
    var confirma = '<div class="alert alert-warning fade in">'+contentHTML+'</div>';
    var origin = $(obj).attr("data-origin").trim();
    //bootbox.setLocale("es");
    bootbox.setDefaults({
        locale: "es"
    });
    bootbox.confirm(confirma, function(result) {
        if (result) {
            showLoader();
            $.ajax({
                url: HTTP_SITE+"/index.php",
                type: "POST",
                dataType: "json",
                data: {
                    tmpl : 'json',
                    action : "seleccionarCarrera",
                    option : "misCarreras",
                    codigoCarrera : codigoCarrera
                },
                success: function( data ){
                    if(data.s){
                        if(origin=="cambioPeriodo"){
                            bootbox.hideAll();
                            reloadCambioPeriodo();
                        }else{
                            window.location.href = HTTP_SITE+"/";
                        }
                    }
                } ,
                complete: function( ){
                    hideLoader();
                }
            }).always(function() {
                hideLoader();
            });
        }
    });
}