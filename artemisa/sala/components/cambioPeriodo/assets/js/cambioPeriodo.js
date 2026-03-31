$(document).ready(function(){
    $("#userMenuNombreCarrera").html(nombreCarreraActual);
    $("#asideNombreCarrera span").html(nombreCarreraActual);
    $("#asideNombrePeriodo span").html(nombrePeriodoActual);
    $(".seleccionarPeriodo").click(function(e){
        e.stopPropagation();
        e.preventDefault();
        seleccionarPeriodo(this);
    });
    
    $("#cambiarCarrera").click(function(e){
        e.stopPropagation();
        e.preventDefault();
        cambiarCarrera();
    });
    bootbox.setDefaults({
        locale: "es"
    });
});
$('#datosCambioPeriodo').bootstrapTable({
    onPageChange: function (name, args) {
        $(".seleccionarPeriodo").click(function(e){
            e.stopPropagation();
            e.preventDefault();
            seleccionarPeriodo(this);
        });
    },
    onSort: function (name, args) {
        $(".seleccionarPeriodo").click(function(e){
            e.stopPropagation();
            e.preventDefault();
            seleccionarPeriodo(this);
        });
    }
});

function seleccionarPeriodo(obj){
    contentHTML = alertContent.replace("fa-icon", dataAlert[0].icon);
    contentHTML = contentHTML.replace('<span class="text-2x"></span>', '<span class="text-2x">Está seguro de seleccionar este periodo?</span>');
    var codigoPeriodo = $(obj).attr("data-Codigo-Periodo");
    var idPeriodoVirtual = $(obj).attr("data-id-PeriodoVirtual");
    var codigoPeriodoVirtual = $(obj).attr("data-Codigo-PeriodoVirtual");
    if(typeof idPeriodoVirtual === "undefined"){
        idPeriodoVirtual = null;
        codigoPeriodoVirtual = null;
    }
    //alert(codigoPeriodoVirtual);
    var confirma = '<div class="alert alert-warning fade in">'+contentHTML+'</div>';
    //bootbox.setLocale("es");
    bootbox.confirm(confirma, function(result) {
        if (result) {
            showLoader();
            $.ajax({
                url: HTTP_SITE+"/index.php",
                //type: "POST",
                type: "GET",
                dataType: "json",
                data: {
                    tmpl : 'json',
                    action : "seleccionarPeriodo",
                    option : "cambioPeriodo",
                    codigoPeriodo : codigoPeriodo,
                    idPeriodoVirtual : idPeriodoVirtual
                },
                success: function( data ){
                    if(data.s){
                        $(".iconosPeriodos").css("display","none");
                        if(idPeriodoVirtual === null){
                            $("#iconoPeriodo_"+codigoPeriodo).css("display","inline-block");
                            $("a.periodoactivo strong").html(codigoPeriodo);
                        }else{
                            $("#iconoPeriodo_"+codigoPeriodoVirtual).css("display","inline-block");
                            $("a.periodoactivo strong").html(codigoPeriodoVirtual);
                        }
                        $("#nombrePeriodoActual").html(data.nombrePeriodo);
                        $("#asideNombrePeriodo span").html(data.nombrePeriodo);
                        
                        //window.location.href = HTTP_SITE;
                        contentHTML = alertContent.replace("fa-icon", dataAlert[2].icon);
                        contentHTML = contentHTML.replace('<span class="text-2x"></span>', '<span class="text-2x">Periodo seleccionado: '+data.nombrePeriodo+'</span>');
                        showAlert(dataAlert[2].type,contentHTML,true);
                    }
                },
                complete: function( ){
                    hideLoader();
                }
            }).always(function() {
                hideLoader();
            });
            //hideLoader();
        }
    });
}

function cambiarCarrera(){
    var titulo = "Seleccionar carrera";
    showLoader();
    $.ajax({
        url: HTTP_SITE+"/index.php",
        type: "POST",
        dataType: "html",
        data: {
            tmpl : 'json', 
            option : "misCarreras",
            origin : "cambioPeriodo"
        },
        success: function( data ){
            abrirModal(titulo,data);
            hideLoader();
        },
        error: function (xhr, ajaxOptions, thrownError) {}
    }).always(function() {
        hideLoader();
    });
}
function reloadCambioPeriodo(){
    showLoader();
    $.ajax({
        url: HTTP_SITE+"/index.php",
        type: "POST",
        dataType: "html",
        data: {
            tmpl : 'json', 
            option : "cambioPeriodo"
        },
        success: function( data ){
            $( "#page-content" ).html( data );
            hideLoader();
        },
        error: function (xhr, ajaxOptions, thrownError) {}
    }).always(function() {
        hideLoader();
    });
}