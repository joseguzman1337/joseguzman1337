$(document).ready(function(){
  
    //queremos que esta variable sea global
    var fileExtension = "";
    var tipo = "";
    //función que observa los cambios del campo file y obtiene información
    $(':file').change(function()
    {
        //obtenemos un array con los datos del archivo
        var indicador1 = $("#indicador1").val();
        if(indicador1 == 0)
        {
            if($("#archivoCarta")[0].files[0]!= null)
            {
            var file = $("#archivoCarta")[0].files[0]; var id = '1';
            }    
        }

        var indicador2 = $("#indicador2").val();
        if(indicador2 == 0)
        {
            if($("#archivoConvenio")[0].files[0]!= null)
            {
                var file = $("#archivoConvenio")[0].files[0]; var id = '2';
            }    
        }
           
        var indicador3 = $("#indicador3").val();
        if(indicador3 == 0)
        {
            if($("#archivoCamara")[0].files[0]!= null)
            {
                var file = $("#archivoCamara")[0].files[0]; var id = '3';
            }    
        }
        
        var indicador4 = $("#indicador4").val();
        if(indicador4 == 0)
        {
            if($("#archivoRepresentante")[0].files[0]!= null)
            {
                var file = $("#archivoRepresentante")[0].files[0]; var id = '4';
            }   
        }
        
        var indicador5 = $("#indicador5").val();
        if(indicador5 == 0)
        {
            if($("#archivoPlan")[0].files[0]!= null)
            {
                var file = $("#archivoPlan")[0].files[0]; var id = '5';
            }    
        }
        
        
        var indicador6 = $("#indicador6").val();
        if(indicador6 == 0)
        {
            if($("#archivoPresupuesto")[0].files[0]!= null)
            {
                var file = $("#archivoPresupuesto")[0].files[0]; var id = '6';
            }   
        }
        
        var indicador7 = $("#indicador7").val();
        if(indicador7 == 0)
        {
            if($("#otro")[0].files[0]!= null)
            {
                var file = $("#otro")[0].files[0]; var id = '7';
            }   
        }

        //obtenemos el nombre del archivo
        var fileName = file.name;
        //obtenemos la extensión del archivo
        fileExtension = fileName.substring(fileName.lastIndexOf('.')).toLowerCase();
        //obtenemos el tamaño del archivo
        var fileSize = file.size;
        //obtenemos el tipo de archivo image/png ejemplo
        var fileType = file.type;
        //mensaje con la información del archivo
        tipo = id;      
        if(id == '2' || id == '7')
        {
            switch(fileExtension)
            {                
                case '.doc': showMessage("<span class='info'>Archivo tipo doc: "+fileName+", peso total: "+fileSize+" bytes.</span>", id);
                        break;
                case '.docx':showMessage("<span class='info'>Archivo tipo docx: "+fileName+", peso total: "+fileSize+" bytes.</span>", id); 
                        break;
                default: showMessage("<span class='info'>El formato del archivo no es valido. Solo formatos <strong>WORD</strong></span>", id);
                        break;
            }    
        }else
        {
            if(id == '1' || id == '3' || id == '4' || id == '5' || id == '6' || id == '7')
            {
                switch(fileExtension)
                {
                    case '.pdf': showMessage("<span class='info'>Archivo: "+fileName+", peso total: "+fileSize+" bytes.</span>", id);
                            break;
                    default: showMessage("<span class='info'>El formato del archivo no es valido. Solo formato <strong>PDF</strong></span>", id);
                            break;    
                }
            }            
        } 
    });

    //al enviar el formulario
    $(':button').click(function(){   
        switch(tipo){
            case '1':
                    var formData = new FormData($("#formulario1")[0]);
                    break;
            case '2':
                    var formData = new FormData($("#formulario2")[0]);
                    break;
            case '3':
                    var formData = new FormData($("#formulario3")[0]);
                    break;  
            case '4':
                    var formData = new FormData($("#formulario4")[0]);
                    break;
            case '5':
                    var formData = new FormData($("#formulario5")[0]);
                    break;
            case '6':
                    var formData = new FormData($("#formulario6")[0]);
                    break;
            case '7':
                    var formData = new FormData($("#formulario7")[0]);
                    break;  
        }
        var message = ""; 
        message = '<div><img width="50p" src="../images/loading.gif"/></div>';
        showMessage(message, tipo);         
        //hacemos la petición ajax  
        $.ajax({
            url: 'SolicitudesArchivos_ajax.php',  
            type: 'POST',
            // Form data
            //datos del formulario
            data: formData,
            dataType: 'json',
            //necesario para subir archivos via ajax
            cache: false,
            contentType: false,
            processData: false,
            //una vez finalizado correctamente
            success: function(data){
                if(data.val==false){
                    message = $("<span class='success'>"+data.mesj+"</span>");     
                }else{
                    message = $("<span class='success'>El archivo ha subido correctamente.</span>");
                }
                showMessage(message, tipo);
                $("#indicador"+tipo).val("1");
                tipo = "";
            },
            //si ha ocurrido un error
            error: function(){
                message = $("<span class='error'>Ha ocurrido un error.</span>");
                showMessage(message, tipo);
                tipo = "";
            }
        });
    });
})

//como la utilizamos demasiadas veces, creamos una función para 
//evitar repetición de código
function showMessage(message, id){    
    switch (id){
        case '1':
                $(".messagesCarta").html("").show();
                $(".messagesCarta").html(message);        
                break;
        case '2':
                $(".messagesConvenio").html("").show();
                $(".messagesConvenio").html(message);
                break;
        case '3':
                $(".messagesCamara").html("").show();
                $(".messagesCamara").html(message);        
                break;
        case '4':
                $(".messagesRepresentante").html("").show();
                $(".messagesRepresentante").html(message);
                break;
        case '5':
                $(".messagesPlan").html("").show();
                $(".messagesPlan").html(message);        
                break;
        case '6':
                $(".messagesPresupuesto").html("").show();
                $(".messagesPresupuesto").html(message);
                break;
        case '7':
                $(".messagesOtro").html("").show();
                $(".messagesOtro").html(message);
                break;
    }
}

//comprobamos si el archivo a subir es una imagen
//para visualizarla una vez haya subido
