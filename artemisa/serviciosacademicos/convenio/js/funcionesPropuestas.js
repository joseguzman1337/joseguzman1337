function validardatospropuesta(form){
    var nombreconvenio = $('#nombreconvenio').val();
    var representante = $('#representante').val();
    var supervisorbosque = $('#supervisorbosque').val();
    var supervisorinstitucion = $('#supervisorinstitucion').val();
    var tipoconvenio = $('#tipoconvenio').val();
    var institucion = $('#institucion').val();
    var pais = $('#pais').val();
    var nconsejo = $('#nconsejo').val();
    var fechaacta  = $('#fechaacta').val();
    if(nombreconvenio === ''){
        alert("Debe digitar el nombre del convenio");
        document.getElementById("nombreconvenio").focus();
        return false;
    }if(representante === ''){
        alert("Debe digitar el nombre del Representante");
        document.getElementById("representante").focus();
        return false;
    }if(supervisorbosque === ''){
        alert("Debe digitar el nombre del Supervisor Bosque");
        document.getElementById("supervisorbosque").focus();
        return false;
    }if(supervisorinstitucion === ''){
        alert("Debe digitar el nombre del Supervisor Instituto");
        document.getElementById("supervisorinstitucion").focus();
        return false;
    }if(tipoconvenio === ''){
        alert("Debe seleccionar el Tipo convenio");
        document.getElementById("tipoconvenio").focus();
        return false;
    }if(institucion === ''){
        alert("Debe Seleccionar Institución");
        document.getElementById("institucion").focus();
        return false;
    }if(pais === ''){
        alert("Debe Seleccionar País");
        document.getElementById("pais").focus();
        return false;
    }if(nconsejo === ''){
        alert("Debe Digitar el Número Acta Consejo Facultad");
        document.getElementById("nconsejo").focus();
        return false;
    }if(fechaacta === ''){
        alert("Debe Seleccionar Fecha de Acta");
        document.getElementById("fechaacta").focus();
        return false;
    }
       $(".messages").hide();
    //queremos que esta variable sea global
    var fileExtension = "";
    //función que observa los cambios del campo file y obtiene información
    $(':file').change(function()
    {
        //obtenemos un array con los datos del archivo
        var file = $("#archivo")[0].files[0];
        //obtenemos el nombre del archivo
        var fileName = file.name;
        //obtenemos la extensión del archivo
        fileExtension = fileName.substring(fileName.lastIndexOf('.') + 1);
        //obtenemos el tamaño del archivo
        var fileSize = file.size;
        //obtenemos el tipo de archivo image/png ejemplo
        var fileType = file.type;
        //mensaje con la información del archivo
        showMessage("<span class='info'>Archivo para subir: "+fileName+", peso total: "+fileSize+" bytes.</span>");
    });
    var formData = new FormData($("#propuesta")[0]);
    var message = "";
        //hacemos la petición ajax  
        $.ajax({
            url: '../convenio/nuevapropuesta.php',  
            type: 'POST',
            // Form data
            //datos del formulario
            data: formData,
            //necesario para subir archivos via ajax
            cache: false,
            contentType: false,
            processData: false,
            //mientras enviamos el archivo
            beforeSend: function(){
                message = $("<span class='before'>Subiendo el archivo, por favor espere...</span>");
                showMessage(message)        
            },
            //una vez finalizado correctamente
            success: function(data){
                message = $("<span class='success'>el archivo ha subido correctamente.</span>");
                showMessage(message);
                if(isImage(fileExtension))
                {
                    $(".showImage").html("<img src='fileSolicitudConvenio/"+data+"' />");
                }
                if(data.val==false){
                       alert(data.descrip);
                       return false;
                   }else{
                       alert('Datos Guardados Exitosamente');
                       location.href="../convenio/Propuestaconvenio.php";
                   }
            },
            //si ha ocurrido un error
            error: function(objeto, quepaso, otroobj){
                alert('Error de Conexión , Favor Vuelva a Intentar');
                message = $("<span class='error'>Ha ocurrido un error.</span>");
                showMessage(message);
            }
        });
}//function validardatospropuesta
function showMessage(message){
    $(".messages").html("").show();
    $(".messages").html(message);
}

//comprobamos si el archivo a subir es una imagen
//para visualizarla una vez haya subido
function isImage(extension)
{
    switch(extension.toLowerCase()) 
    {
        case 'jpg': case 'gif': case 'png': case 'jpeg':
            return true;
        break;
        default:
            return false;
        break;
    }
}
function seleccionarInstitucion()
{   
    var InstitucionConvenioId = $('#InstitucionConvenioId').val();    
     $.ajax({//Ajax
              type: 'POST',
              url: 'procesarSolicitudConvenio.php',
              async: false,
              dataType: 'html',
              //data:$('#NuevaRotacionSubGrupo').serialize(),
               data:({lista:'Instituciones',id:InstitucionConvenioId}),
              error:function(objeto, quepaso, otroobj){alert('Error de Conexi?n , Favor Vuelva a Intentar');},
              success: function(data){
                $('#TD_Otra').html(data);
                Datosinstitucion(InstitucionConvenioId);// ejecuta la funcion de datos de la institcuon para completar la información
              }//AJAX
       });     
}

function Datosinstitucion(InstitucionConvenioId)
{ 
     $.ajax({//Ajax
              type: 'POST',
              url: 'procesarSolicitudConvenio.php',
              async: false,
              dataType: 'json',
              //data:$('#NuevaRotacionSubGrupo').serialize(),
               data:({lista:'DatosInstituciones',id:InstitucionConvenioId}),
              error:function(objeto, quepaso, otroobj){alert('Error de Conexi?n , Favor Vuelva a Intentar');},
              success: function(data){
                if(data[0] != 'NO SE TIENE' && data[0] != 'NO TIENE')
                {
                    $('#representante').val(data[0]);    
                }
                if(data[1] != 'NO SE TIENE' && data[1] != 'NO TIENE')
                {
                    $('#txtNumeroIdentificacion').val(data[1]);
                }
                if(data[2] != 'NO SE TIENE' && data[2] != 'NO TIENE')
                {
                    $('#txtContactoI').val(data[2]);
                }
                if(data[3] != 'NO SE TIENE' && data[3] != 'NO TIENE')
                {
                    $('#txtCargoSI').val(data[3]);
                }
                if(data[4] != 'NO SE TIENE' && data[4] != 'NO TIENE')
                {
                    $('#txtCorreoSI').val(data[4]);
                }
                if(data[5] != 'NO SE TIENE' && data[5] != 'NO TIENE')
                {
                    $('#txtCelularSI').val(data[5]);
                }
                if(data[6] != 'NO SE TIENE' && data[6] != 'NO TIENE')
                {
                    $('#txtDireccion').val(data[6]);
                }
              }//AJAX
       });
}//Datosinstitucion

function validarNumeroActa(numeroacta)
{    
   // var numeroacta = $('#nconsejo');
    $.ajax({//Ajax
              type: 'POST',
              url: 'procesarSolicitudConvenio.php',
              async: false,
              dataType: 'json',
               data:({Acta:'Acta',id:numeroacta}),
              error:function(objeto, quepaso, otroobj){alert('Error de Conexi?n , Favor Vuelva a Intentar');},
              success: function(data){                
                if(data.val=='existe'){
                    alert('El numero de acta que esta digitando ya existe.');
                    $('#nconsejo').val('');
                    return false;
                    }
              }//AJAX
       });
}

function validardatospropuestaactualizar(form){
    var data = validateForm(form);    
    if(data===true){
        $.ajax({//Ajax
         type: 'POST',
         url: '../convenio/Detallepropuesta.php',
         async: false,
         dataType: 'json',
         data:$(form).serialize(),
         error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
         success: function(data){
              if(data.val==false){
                       alert('Error de Actualización');
                       return false;
                   }else{
                       alert('Datos Actualizados Correctamente');
                       location.href="../convenio/Propuestaconvenio.php";
                   }
        }//data
       });// AJAX
    }    
}//function validardatospropuesta

function validardatosProrroga(form){
    var institucionPro = $('#institucionPro').val();
    if(institucionPro === ''){
        alert("Debe Seleccionar Institución");
        document.getElementById("institucionPro").focus();
        return false;
    }
    var convenioID = $('#convenioID').val();
    if(convenioID === ''){
        alert("Debe Seleccionar Convenio");
        document.getElementById("convenioID").focus();
        return false;
    }
       $(".messages").hide();
    //queremos que esta variable sea global
    var fileExtension = "";
    //función que observa los cambios del campo file y obtiene información
    $(':file').change(function()
    {
        //obtenemos un array con los datos del archivo
        var file = $("#archivo")[0].files[0];
        //obtenemos el nombre del archivo
        var fileName = file.name;
        //obtenemos la extensión del archivo
        fileExtension = fileName.substring(fileName.lastIndexOf('.') + 1);
        //obtenemos el tamaño del archivo
        var fileSize = file.size;
        //obtenemos el tipo de archivo image/png ejemplo
        var fileType = file.type;
        //mensaje con la información del archivo
        showMessage("<span class='info'>Archivo para subir: "+fileName+", peso total: "+fileSize+" bytes.</span>");
    });
    var formData = new FormData($("#prorroga")[0]);

    var message = "";
        //hacemos la petición ajax  
        $.ajax({
            url: '../convenio/classSolicitudProrroga.php',  
            type: 'POST',
            // Form data
            //datos del formulario
            data: formData,
            //necesario para subir archivos via ajax
            cache: false,
            contentType: false,
            processData: false,
            //mientras enviamos el archivo
            beforeSend: function(){
                message = $("<span class='before'>Subiendo el archivo, por favor espere...</span>");
                showMessage(message)        
            },
            //una vez finalizado correctamente
            success: function(data){
                message = $("<span class='success'>el archivo ha subido correctamente.</span>");
                showMessage(message);
                if(isImage(fileExtension))
                {
                    $(".showImage").html("<img src='fileSolicitudConvenio/"+data+"' />");
                }
                if(data.val==false){
                       alert(data.descrip);
                       return false;
                   }else{
                       alert('Datos Guardados Exitosamente');
                       location.href="../convenio/Propuestaconvenio.php";
                   }
            },
            //si ha ocurrido un error
            error: function(objeto, quepaso, otroobj){
                alert('Error de Conexión , Favor Vuelva a Intentar');
                message = $("<span class='error'>Ha ocurrido un error.</span>");
                showMessage(message);
            }
        });
}//function validardatospropuesta