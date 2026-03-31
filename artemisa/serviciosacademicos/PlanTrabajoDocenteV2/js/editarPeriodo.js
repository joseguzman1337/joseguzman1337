$(document).ready(function(){
    $("#codigoNuevoPeriodo").chosen({
        width: '100%',
        no_results_text: "No hay resultados para: "
    });
    $("#actualizarPeriodo").click(function(e){
        e.stopPropagation();
        e.preventDefault();
        
        showLoader();

        var id = $("#id").val();
        var codigoNuevoPeriodo = $("#codigoNuevoPeriodo").val();
        var url = $("#editarPeriodo").attr("action");
        var parametros = {
            id : id,
            codigoNuevoPeriodo : codigoNuevoPeriodo,
            option : 'editarPeriodo',
            action : 'actualizarPeriodo'
        };

        $.ajax({
            url: url,
            type: "GET",
            dataType: "json",
            data: parametros,
            success: function( data ){
                if(data.s){
                    $("#modalBoby").html(data.msg);
                    $("#modalBody").html(data.msg);
                    setTimeout(function(){
                        $("#cerrarModal").trigger( "click" );
                        $("#Filtrar").trigger( "click" );
                    }, 3000);
                }
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
        
    });
});