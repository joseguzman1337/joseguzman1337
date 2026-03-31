function hideLoader(){
    $(".loaderContent").fadeOut();
    $("#mensajeLoader").html("");
}
function showLoader(){
    $("#mensajeLoader").html("");
    $(".loaderContent").fadeIn();
}

function actualizarListaCarrera(){
    var codigoPeriodo = $("#codigoperiodo").val();
    var url = $("#filter").attr("action");
    $.ajax({
        url: url,
        type: "GET",
        dataType: "html",
        data: {
            option : "getListadoCarreras",
            codigoPeriodo : codigoPeriodo,
            carreraSeleccionada : carreraSeleccionada
        },
        success: function( data ){
            $("#codigocarrera").parent().html(data);
            $("#codigocarrera").chosen({
                width: '100%',
                no_results_text: "No hay resultados para: "
            });
            $("#codigocarrera").change(function(){
                showLoader();
                actualizarListaDocente();
            });
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert("Error");
        },
        complete: function( ){
            hideLoader();
        }
    }).always(function() {
        hideLoader();
    });
}
function actualizarListaDocente(){
    var codigoPeriodo = $("#codigoperiodo").val();
    var codigoCarrera = $("#codigocarrera").val();
    var url = $("#filter").attr("action");
    $.ajax({
        url: url,
        type: "GET",
        dataType: "html",
        data: {
            option : "getListadoDocentes",
            codigoPeriodo : codigoPeriodo,
            codigoCarrera : codigoCarrera,
            carreraSeleccionada : carreraSeleccionada,
            docenteSeleccionado : docenteSeleccionado
        },
        success: function( data ){
            $("#iddocente").parent().html(data);
            $("#iddocente").chosen({
                width: '100%',
                no_results_text: "No hay resultados para: "
            });
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert("Error");
        },
        complete: function( ){
            hideLoader();
        }
    }).always(function() {
        hideLoader();
    });/**/
}

function editarPeriodo(obj){
    var url = $("#filter").attr("action");
    
    $("#triggerModal").trigger( "click" );
    showLoader();

    var id = $(obj).attr("data-id");
    $("#modalTitle").html("Editar Periodo");
    var parametros = {
        id : id,
        option : 'editarPeriodo'
    };
    
    $.ajax({
        url: url,
        type: "GET",
        dataType: "html",
        data: parametros,
        success: function( data ){
            $("#modalBoby").html(data);
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert("Error");
        },
        complete: function( ){
            hideLoader();
        }
    }).always(function() {
        hideLoader();
    });/**/ 
    
    setTimeout(function(){
        $("#mensaje").html("La tarea esta demorando mas de lo esperado, por favor intente de nuevo mas tarde");
        p.abort();
        setTimeout(function(){
            hideLoader();
        }, 3000);
    }, 40000);
}

$(document).ready(function(){
    hideLoader();
    
    $("#codigoperiodo").change(function(){
        showLoader();
        actualizarListaCarrera();
        actualizarListaDocente();
    });
    
    $("#codigocarrera").change(function(){
        showLoader();
        actualizarListaDocente();
    });
    
    $(".accion").click(function(e){
        e.stopPropagation();
        e.preventDefault();
        
        $("#modalBoby").html("Cargando");
        editarPeriodo(this);
    });
});

