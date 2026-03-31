$(document).ready(function(){
    $('#datetimepicker1').datetimepicker({
        format: 'YYYY-MM-DD',
        locale: 'es',
        showTodayButton: true
    });
    $('#fecha').datetimepicker({
        format: 'YYYY-MM-DD',
        locale: 'es',
        showTodayButton: true 
    });
    $(".accion").click(function(e){
        e.stopPropagation();
        e.preventDefault();
        var accion = $(this).attr("data-action");
        //alert(accion);
        switch (accion){
            case "publicar":
            case "despublicar":
                publicarDespublicar(this);
                break;
            case "crear":
            case "editar":
                $("#modalBoby").html("Cargando");
                crearEditar(this);
                break;
            case "cargarArchivos":
                $("#modalBoby").html("Cargando");
                cargarArchivos(this);
                break;
            case "ejecutarAnalisis":
                ejecutarAnalisis(this);
                break;
            case "recargarPagina":
                window.location.reload();   
                break;
            case "verReporte":
                verReporte(this);   
                break;
        }
    });
});
function verReporte(obj){
    var id = $(obj).attr("data-id");
    var action = $(obj).attr("data-action");
    window.open(url+"?action="+action+"&idConciliacion="+id);
}
function ejecutarAnalisis(obj){
    mostrarLoader();
    var reload = true;
    var id = $(obj).attr("data-id");
    var accion = $(obj).attr("data-action");
    
    var parametros = {
        id : id,
        action : accion
    };

    var p = $.getJSON(
        url,
        parametros,
        function(data){
            ocultarLoader();
            $("#modalTitle").html("Analisis de conciliacion");
            $("#modalBoby").html(data.msj);
            $("#triggerModal").trigger( "click" );
            reload = data.s;
            if(data.s){
                setTimeout(function(){
                    window.location.reload();
                }, 2000);
            }
        }
    );
    
    setTimeout(function(){
        ocultarLoader();
        if(reload){
            $("#modalTitle").html("Analisis de conciliacion");
            $("#modalBoby").html('<div class="alert alert-success"><strong><i class="fa fa-check-circle-o" aria-hidden="true"></i></strong> Se esta procesando la conciliación.</div>');
            $("#triggerModal").trigger( "click" );
            //p.abort();
            setTimeout(function(){
                window.location.reload();
            }, 2000);
        }
    }, 5000);
}
function cargarArchivos(obj){
    $("#modalTitle").html("Cargar archivos");
    $("#triggerModal").trigger( "click" );
    mostrarLoader();

    var id = $(obj).attr("data-id");
    var bcoid = $(obj).attr("data-bcoid");
    var accion = $(obj).attr("data-action");

    var parametros = {
        id : id,
        bcoid : bcoid,
        option : 'cargarArchivos',
        json : true
    };

    var p = $.getJSON(
        url,
        parametros,
        function(data){
            ocultarLoader();
            if(data.s){
                $("#modalBoby").html(data.msj);
            }
        }
    );
    setTimeout(function(){
        $("#mensaje").html("La tarea esta demorando mas de lo esperado, por favor intente de nuevo mas tarde");
        p.abort();
        setTimeout(function(){
            ocultarLoader();
        }, 3000);
    }, 40000);
}
function crearEditar(obj){
    $("#triggerModal").trigger( "click" );
    mostrarLoader();

    var id = $(obj).attr("data-id");
    var bcoid = $(obj).attr("data-bcoid");
    if(id.trim()!=""){
        $("#modalTitle").html("Editar");
    }else{
        $("#modalTitle").html("Nuevo");
    }
    var accion = $(obj).attr("data-action");

    var parametros = {
        id : id,
        bcoid : bcoid,
        option : 'crearEditarConciliacion',
        json : true
    };

    var p = $.getJSON(
        url,
        parametros,
        function(data){
            ocultarLoader();
            if(data.s){
                $("#modalBoby").html(data.msj);
            }
        }
    );
    setTimeout(function(){
        $("#mensaje").html("La tarea esta demorando mas de lo esperado, por favor intente de nuevo mas tarde");
        p.abort();
        setTimeout(function(){
            ocultarLoader();
        }, 3000);
    }, 40000);
}
function ocultarLoader(){
    $(".contenedorExterior").css("display","none");
    $("#mensaje").html("");
}

function mostrarLoader(){
    $("#mensaje").html("");
    $(".contenedorExterior").css("display","block");
}
function publicarDespublicar(obj){
    mostrarLoader();

    var id = $(obj).attr("data-id");
    var accion = $(obj).attr("data-action");

    var parametros = {
        id : id,
        accion : accion,
        action : 'publicarDespublicarConciliacion'
    };

    var p = $.getJSON(
        url,
        parametros,
        function(data){
            ocultarLoader();
            if(data.s){
                window.location.reload();
            }
        }
    );
    setTimeout(function(){
        $("#mensaje").html("La tarea esta demorando mas de lo esperado, por favor intente de nuevo mas tarde");
        p.abort();
        setTimeout(function(){
            ocultarLoader();
        }, 3000);
    }, 40000);
}