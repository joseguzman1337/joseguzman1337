$(document).ready(function(){
    //alert("carga??");
    $("#nuevoMenu").click(function(e){
        e.preventDefault();
        e.stopPropagation();
        crearEditarMenu();
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
function crearEditarMenu(id = null){
    var titulo = "";
    if(id==null){
        titulo = "Nuevo menu";
    }else{
        titulo = "Editar menu";
    }
    showLoader();
    $.ajax({
        url: HTTP_SITE+"/index.php",
        type: "POST",
        dataType: "html",
        data: {
            tmpl : 'json',
            layout : "createEdit",
            option : "adminMenu",
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
            crearEditarMenu(id);
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
            option : "adminMenu",
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
