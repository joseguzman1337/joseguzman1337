$(document).ready(function(){
    $("#nuevaActividad").click(function(e){
        e.preventDefault();
        e.stopPropagation();
        crearEditarActividadesBienestar();
    });/**/
    $(".accion").click(function(e){
        e.preventDefault();
        e.stopPropagation();
        ejecutarAccion(this);
    });
    
}); 
$('#datos').bootstrapTable({
    onPageChange: function (name, args) {
        $(".accion").click(function(e){
            e.preventDefault();
            e.stopPropagation();
            ejecutarAccion(this);
        });
    },
    onSort: function (name, args) {
        $(".accion").click(function(e){
            e.preventDefault();
            e.stopPropagation();
            ejecutarAccion(this);
        });
    }
});
function crearEditarActividadesBienestar(id = null){
    var titulo = "";
    if(id==null){
        titulo = "Nueva Actividad";
    }else{
        titulo = "Editar Actividad";
    }
    showLoader();
    $.ajax({
        url: HTTP_SITE+"/index.php",
        type: "POST",
        dataType: "html",
        data: {
            tmpl : 'json',
            layout : "createEdit",
            option : "moduloActividadesBienestar",
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
        case "publicar":
        case "despublicar":
            publicar(obj);
            break;
        case "editar":
            crearEditarActividadesBienestar(id);
            break;
    }
}
function publicar(obj){
    var id = $(obj).attr("data-id");
    showLoader();
    $.ajax({
        url: HTTP_SITE+"/index.php",
        type: "POST",
        dataType: "json",
        data: {
            tmpl : 'json',
            option : "moduloActividadesBienestar",
            action : "publicarDespublicar",
            id : id
        },
        success: function( data ){
            if(data.s){
                var padre = $(obj).parent();
                $(obj).remove();
                padre.html(data.boton);
                padre.children(".accion").click(function(e){
                    e.preventDefault();
                    e.stopPropagation();
                    ejecutarAccion(this);
                });
            }
        },
        error: function (xhr, ajaxOptions, thrownError) {},
        complete: function( ){
            hideLoader();
        }
    }).always(function() {
        hideLoader();
    });
}
