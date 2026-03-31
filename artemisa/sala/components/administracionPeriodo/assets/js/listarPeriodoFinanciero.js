$(document).on('click', '.accionPeriodoFinanciero', function (e) {
    e.preventDefault( );
    e.stopPropagation();
    e.stopImmediatePropagation();
    var id = $(this).data("id");
    
    var accion = $(this).data("action");
    switch(accion){
        case "nuevo":
        case "editar":
            editar(id);
            break;
        case "eliminar":
            eliminar(id);
            break;
    }
});

function editar(id){
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
            layout:"nuevoPeriodoFinanciero",
            id:id,
            dataType: "PeriodoFinanciero",
            dataAction:"nuevo"
        },
        success: function (data) {
            abrirModal(titulo+" Período Financiero", data);
            hideLoader();
        },
        error: function (xhr, ajaxOptions, thrownError) {}
    }).always(function () {
        hideLoader();
    });/**/
}

function eliminar(id){    
    contentHTML = alertContent.replace("fa-icon", dataAlert[4].icon);
    contentHTML = contentHTML.replace('<span class="text-2x"></span>', '<span class="text-2x">Está a punto de eliminar este periodo, está seguro?</span>');
    var confirma = '<div class="alert alert-'+dataAlert[4].type+' fade in">'+contentHTML+' </div>';
    //bootbox.setLocale("es");
    bootbox.setDefaults({
        locale: "es"
    });
    bootbox.confirm(confirma, function(result) {
        if (result) {
            showLoader(); 
            $.ajax({
                url: HTTP_SITE + "/index.php",
                type: "POST",
                dataType: "json",

                data: {
                    tmpl: 'json',
                    action: "administrarPeriodo",
                    dataAction: "eliminar",
                    dataType: "PeriodoFinanciero",
                    option: "administracionPeriodo",
                    id:id,
                },
                success: function (data) {
                    console.log(data);
                    if(!data.s){
                        contentHTML = alertContent.replace("fa-icon", dataAlert[4].icon);
                        contentHTML = contentHTML.replace('<span class="text-2x"></span>', '<span class="text-2x">'+data.msj+'</span>');
                        $("#mensajeLoader").html('<div class="alert alert-'+dataAlert[4].type+' fade in">'+contentHTML+' </div>');
                    }else{
                        contentHTML = alertContent.replace("fa-icon", dataAlert[2].icon);
                        contentHTML = contentHTML.replace('<span class="text-2x"></span>', '<span class="text-2x">'+data.msj+'</span>');
                        $("#mensajeLoader").html('<div class="alert alert-'+dataAlert[2].type+' fade in">'+contentHTML+' </div>');
                    }
                    timeOutVar = window.setTimeout(function(){
                        $(".accionMenu[data-action=listar][data-type=PeriodoFinanciero]").trigger("click");
                        bootbox.hideAll();
                        hideLoader();
                    }, 5000);/**/
                },
                error: function (xhr, ajaxOptions, thrownError) {hideLoader();}
            }).always(function () {
                
            });
        }
    });  
}