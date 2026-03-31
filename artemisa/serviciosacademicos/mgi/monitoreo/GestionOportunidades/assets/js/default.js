$(document).ready(function(){
    //alert("carga??");
    $("#nuevoMenu").click(function(e){
        e.preventDefault();
        e.stopPropagation();
        crearEditar(null);
    });/**/
    escucharAccion();
    
}); 
function escucharAccion(){
    $(document).ready(function(){
        $(".accion").unbind( "click" );
        $(".accion").click(function(e){
            e.preventDefault();
            e.stopPropagation();
            ejecutarAccion(this);
        });
    });
}
$('#datos').bootstrapTable({
    onPageChange: function (name, args) {
        escucharAccion();
    },
    onSort: function (name, args) {
        escucharAccion();
    },
    onSearch: function (name, args) {
        escucharAccion();
    }
});
function crearEditar(id = null){
    var titulo = "";
    if(id==null){
        titulo = "Nueva oportunidad";
    }else{
        titulo = "Editar oportunidad";
    }
    showLoader();
    $.ajax({
        url: HTTP_GESTION+"/index.php",
        type: "POST",
        dataType: "html",
        data: {
            tmpl : 'json',
            layout : "createEdit",
            option : "default",
            id : id
        },
        success: function( data ){
            abrirModal(titulo,data);
            hideLoader();
        },
        error: function (xhr, ajaxOptions, thrownError) {}
    }).always(function() {
        hideLoader();
    });;
}

function ejecutarAccion(obj){
    var accion = $(obj).attr("data-action").trim();
    var id = $(obj).attr("data-id").trim();
    switch(accion){
        case "editar":
            crearEditar(id);
            break;
        case "eliminar":
            eliminar(id);
            break;
    }
}

function eliminar(id){
    var confirma = '<div class="text-2x alert alert-danger fade in"><strong><i class="fa fa-exclamation-triangle" aria-hidden="true"></i></strong> Está a punto de eliminar el registro, está seguro de continuar?</div>';
    
    bootbox.setDefaults({
        locale: "es"
    });
    bootbox.confirm(confirma, function(result) {
        if (result) {
            showLoader();
            $.ajax({
                url: HTTP_GESTION+'/index.php',
                type: "GET",
                dataType: "json",
                data: {
                    option: 'default',
                    tmpl: 'json',
                    action: 'eliminar',
                    id: id
                },
                success: function( data ){
                    bootbox.hideAll();
                    if(data.s){
                        hideLoader();
                        contentHTML = alertContent.replace("fa-icon", dataAlert[2].icon);
                        contentHTML = contentHTML.replace('<span class="text-2x"></span>', '<span class="text-2x">'+data.msj+'</span>');
                        showAlert(dataAlert[2].type,contentHTML,true);

                        window.setTimeout(function() {
                            location.reload();
                        }, 1500);
                    }else{
                        contentHTML = alertContent.replace("fa-icon", dataAlert[4].icon);
                        contentHTML = contentHTML.replace('<span class="text-2x"></span>', '<span class="text-2x">'+data.msj+'</span>');
                        showAlert(dataAlert[4].type,contentHTML,true);
                    }
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    contentHTML = alertContent.replace("fa-icon", dataAlert[4].icon);
                    contentHTML = contentHTML.replace('<span class="text-2x"></span>', '<span class="text-2x">El servidor no responde</span>');
                    showAlert(dataAlert[4].type,contentHTML,true);
                }
            });
        }
    });/**/
}
