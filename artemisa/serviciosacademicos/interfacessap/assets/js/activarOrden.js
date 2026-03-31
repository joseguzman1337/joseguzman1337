$(function(){
    $("#buscar").on("click",function (){
        let numOrden = $("#busqueda_numero").val();
        let observacion = $("#busqueda_observacion").val();
        if (numOrden !='' && observacion!=''){
            $("#buscar").prop('disabled',true);
            $("#preLoad").show();
            $("#f1").submit();
        }

    });
});