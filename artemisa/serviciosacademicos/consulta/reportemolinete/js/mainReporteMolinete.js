$( document ).ready(function() {
    $(".form_datetime").datetimepicker({
        format: 'YYYY-MM-DD'
    }).on('changeDate', function(ev) { 
        $('.form_datetime').datepicker('hide');
    });
      
    $("#irAExportar").click(function(){
        $(this).attr("class", "hidden");
    });
    $("#btnexportar").click(function(e){
        e.stopPropagation();
        e.preventDefault();
        
        var fechainicio = $("#fechainicio").val();
        var fechafin = $("#fechafin").val();
        var tiporeporte = $(".tiporeporte").is(':checked');
        if(fechainicio.trim()==""){
            alert("Debe Ingresar la fecha de Inicio");
        }else if(fechafin.trim()==""){
            alert("Debe ingresar una fecha final.");
        }else if(!tiporeporte){
            alert("Debe Seleccionar un tipo de reporte.");
        }
        var href = $(this).attr("data-href");
        //alert(href);
        
            $("#f1").attr("action", "reportemolinetebiblio.php");
            $("#f1").attr("target", "_BLANK");
            
        $("#f1").attr("action", href);
        /*$("#f1").attr("target", "_BLANK");/**/
        $("#f1").submit();
        
        /*$("#irAExportar").attr("href", href);
        $("#irAExportar").trigger('click');/**/
    });
    $("#submitForm").click(function(e){
        e.stopPropagation();
        e.preventDefault();
        
        var fechainicio = $("#fechainicio").val();
        var fechafin = $("#fechafin").val();
        var tiporeporte = $(".tiporeporte").is(':checked');
        if(fechainicio.trim()==""){
            alert("Debe Ingresar la fecha de Inicio");
        }else if(fechafin.trim()==""){
            alert("Debe ingresar una fecha final.");
        }else if(!tiporeporte){
            alert("Debe Seleccionar un tipo de reporte.");
        }else{
            $("#f1").attr("action", "menureportemolinete.php");
            $("#f1").attr("target", "_SELF");
            $("#f1").submit();
        }
        /**/
        return false;
    });
});
