$(document).ready(function(){
    $("#extracto").uploadFile({
            url: url+"?action=uploadFile&file=extracto&id="+$("#id").val()+"&bcoid="+$("#bcoid").val(),
            fileName:"extracto",
            returnType:"json",
            allowedTypes:"xlsx,xls,csv",
            maxFileCount:1,
            onSuccess:function(files,data,xhr,pd){
                $("#extractoFile").val(data);
            },
            deleteCallback: function(data,pd){
                for(var i=0;i<data.length;i++){
                    $.post(url+"?action=deleteDataFile&file=extracto&id="+$("#id").val()+"&bcoid="+$("#bcoid").val(),{op:"delete",name:data[i]},
                    function(resp, textStatus, jqXHR){
                    });
                }
                pd.statusbar.hide(); //You choice to hide/not.
            }
    });
    $("#campus").uploadFile({
            url: url+"?action=uploadFile&file=campus&id="+$("#id").val()+"&bcoid="+$("#bcoid").val(),
            fileName:"campus",
            returnType:"json",
            allowedTypes:"xlsx,xls,csv",
            maxFileCount:1,
            onSuccess:function(files,data,xhr,pd){
                $("#campusFile").val(data);
            },
            deleteCallback: function(data,pd){
                for(var i=0;i<data.length;i++){
                    $.post(url+"?action=deleteDataFile&file=campus&id="+$("#id").val()+"&bcoid="+$("#bcoid").val(),{op:"delete",name:data[i]},
                    function(resp, textStatus, jqXHR){
                    });
                }
                pd.statusbar.hide(); //You choice to hide/not.
            }
    });
    
    $(".borrar").click(function(e){
        e.stopPropagation();
        e.preventDefault();
        var file = $(this).attr("data-file");
        $.post(
            url+"?action=deleteDataFile&file="+file+"&id="+$("#id").val()+"&bcoid="+$("#bcoid").val(),
            {op:"delete"},
            function(resp, textStatus, jqXHR){
                $("#"+file).css("display","");
                $("#"+file+"Borrar").css("display","none");
            }
        );
    });
    
    $(".noborrar,.noBorrar").click(function(e){
        e.stopPropagation();
        e.preventDefault();
        mostrarLoader();
        $("#mensaje").html("No es posible borrar el archivo ya que esta cargando a base de datos.<br>Intente de nuevo en unos minutos.");
        setTimeout(function(){
            ocultarLoader();
        }, 4000);
    });
    
    $("#guardarFormulario").click(function(e){
        e.stopPropagation();
        e.preventDefault();
        $(".alert").css("display","none");
        var extracto = $("#extracto").val();
        var reporte = $("#reporte").val(); 

        if(extracto.trim()==""){
            $("#alertText").html("Por favor seleccione el archivo del extracto del banco para la conciliación");
            $(".alert").css("display","");
        }else if(reporte.trim()==""){
            $("#alertText").html("Por favor seleccione el reporte de people para la conciliación");
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
    var data = new FormData($("#fileinfo"));
    data.append("action", "cargarArchivos");
    //console.log(data);
    /*
    var p = $.ajax({
        type: "POST",
        enctype: 'multipart/form-data',
        url: url,
        data: data,
        processData: false,
        contentType: false,
        cache: false,
        timeout: 40000,
        success: function (data) {
            ocultarLoader();
        },
        error: function (e) {
            $("#mensaje").html("La tarea esta demorando mas de lo esperado, por favor intente de nuevo mas tarde");
            p.abort();
            setTimeout(function(){
                ocultarLoader();
            }, 3000);
        }
    });/**/
    setTimeout(function(){
        $("#mensaje").html("La tarea esta demorando mas de lo esperado, por favor intente de nuevo mas tarde");
        p.abort();
        setTimeout(function(){
            ocultarLoader();
        }, 3000);
    }, 40000);
}