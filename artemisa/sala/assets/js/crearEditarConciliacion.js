$(document).ready(function(){
    $('#datetimepickerFE1').datetimepicker({
        format: 'YYYY-MM',
        locale: 'es',
        showTodayButton: true,
        viewMode: 'months'

    });
    $('#fechaInicio').datetimepicker({
        format: 'YYYY-MM',
        locale: 'es',
        showTodayButton: true,
        viewMode: 'months'
    });

    $("#guardarFormulario").click(function(e){
        e.stopPropagation();
        e.preventDefault();
        $(".alert").css("display","none");
        var nombre = $("#nombre").val();
        var bcoid = $("#bcoid").val();
        var fecha = $("#fecha").val();
        var estado = $("#estado").val();

        if(nombre.trim()==""){
            $("#alertText").html("Por favor ingrese el nombre para la conciliación");
            $(".alert").css("display","");
        }else if(bcoid.trim()==""){
            $("#alertText").html("Por favor seleccione el banco para la conciliación");
            $(".alert").css("display","");
        }else if(fecha.trim()==""){
            $("#alertText").html("Por favor seleccione la fecha para la conciliación");
            $(".alert").css("display","");
        }else{
            $("#alertText").html("");
            $(".alert").css("display","none");
            guardar(this);
        }
    });
});
function guardar(obj){
    mostrarLoader();

    var parametros = {
        id : $("#id").val(),
        nombre : $("#nombre").val(),
        bcoid : $("#bcoid").val(),
        fecha : $("#fecha").val(),
        estado : $("#estado").val(),
        action : 'crearEditarConciliacion'
    };

    var p = $.getJSON(
        url,
        parametros,
        function(data){
            ocultarLoader();
            if(data.s){
                $('#contenedorForm').html("Registro guardado");
                setTimeout(function(){
                    window.location.reload();
                }, 3000);
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