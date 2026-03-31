$(document).ready(function() 
{
	$(".messages").hide(); 
	var fileExtension = "";
	$('#modalidad').change(function (){
			var modalidad = $(this).val();
			if(modalidad == 0){
				alert('seleccione una modalidad antes de continuar');
				$('#contenedores').fadeOut(1000);
			}else{
				cargar_facultad(modalidad);
				if(modalidad == 200){
					$('#facultad').removeAttr('disabled');
					$('#programa').attr('disabled', 'true');
					$('#Div_Facultad').removeAttr('style');
					$('#tipo_ensenanza').html('<option value="0" selected="selected">Seleccione</option><option value="1">Asignatura</option><option value="2">Atenci&oacute;n en laboratorios, talleres o preclinicas</option><option value="3">Atenci&oacute;n - tutorias PAE</option><option value="4">Horas dedicadas a TICs</option>');
				}
				if(modalidad == 300){
					$('#Div_Facultad').css('display', 'none');
					$('#programa').removeAttr('disabled');
					$('#tipo_ensenanza').html('<option value="0" selected="selected">Seleccione</option><option value="1">Asignatura</option><option value="2">Atenci&oacute;n en laboratorios, talleres o preclinicas</option><option value="3">Atenci&oacute;n - tutorias PAE</option><option value="4">Horas dedicadas a TICs</option>');
				}
			}
		});
		
	  
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
	 
		$('#guardar').click(function(){
			//información del formulario
			var formData = new FormData($(".nuevoacuerdo")[0]);        
			var user = $('#user').val();         
			var contador = $('#contador').val();
            var contador_carrera = $('#contador_carrera').val();   
			var numeroAcuerdo = $('#numeroAcuerdo').val();
			var archivo = document.getElementById("archivo");
			
			var file = archivo.files[0];
		  
			formData.append("user", user);
			formData.append("contador", contador);
            formData.append("contador_carrera", contador_carrera);
			formData.append("archivo",file);
			formData.append("numeroAcuerdo",numeroAcuerdo);
			
			parseInt(contador);
            parseInt(contador_carrera);
			
			var instituciones = new Array();
			var cupos = new Array();
			var $i = 0;
			
			for(parseInt($i = 1); contador >= $i;parseInt($i = $i + 1))
			{
				instituciones[$i] = $("#instituciones_0"+$i).val();
				cupos[$i] = $('#cupos_0'+$i).val();
				
				formData.append("instituciones_0"+$i, instituciones[$i]);
				formData.append("cupos_0"+$i, cupos[$i]);
			}
            
            var carreras = $("#carrera").val();
			formData.append("carrera", carreras);
            
			var actionID = 'SaveData';
			formData.append("actionID", actionID);
			
			var message = "";
			//hacemos la petición ajax 
			$.ajax({
				url: 'acuerdos_ajax.php',  
				type: 'POST',
				data: formData,
				//necesario para subir archivos via ajax
				cache: false,
				contentType: false,
				processData: false,
				//mientras enviamos el archivo
				beforeSend: function(){
					message = $("<span class='before'>Subiendo el archivo, por favor espere...</span>");
					showMessage(message);        
				},
				//una vez finalizado correctamente
				success: function(data){
					message = $("<span class='success'>El archivo fue agregado correctamente.</span>");
					showMessage(message);
					alert('Los datos fueron agregados correctamente.');
					location.href="../convenio/AcuerdosCarreras.php";
				},
				//si ha ocurrido un error
				error: function(){
				   message = $("<span class='error'>Ha ocurrido un error.</span>");
				   showMessage(message);
					 alert('Se encontraron errores en los datos, por favor verificar la información.');
				}
			});
		});
		
		$("#facultad").change(function (){
			var facultad_id;
			var documento_docente;
			var periodo;
			facultad_id = $(this).val();
			documento_docente = $('#NumDocumento').val();
			periodo = $('#Periodo').val();
			var modalidad = $('#modalidad').val();
			if(facultad_id == 0){
				alert('seleccione una facultad antes de continuar');
				$('#contenedores').fadeOut(1000);
				$('#programa').attr('disabled', 'disabled');
			}else{
				cargar_programa_academico(facultad_id, documento_docente, periodo, modalidad);
				$('#programa').removeAttr('disabled');
			}
		});
		$("#guardarActividad").on( "click", function () {
				
				$.ajax({
					url: 'classSolicitudProrroga.php',  
					type: 'POST',
					dataType: 'json',
					data: $("#actividadnueva").serialize(),
					//una vez finalizado correctamente
					success: function(data)
					{
						alert('Los datos fueron agregados correctamente.');
						location.href="../convenio/ActividadesConvenio.php";
						
					},
					//si ha ocurrido un error
					error: function(){
					   message = $("<span class='error'>Ha ocurrido un error.</span>");
					   showMessage(message);
						 alert('Se encontraron errores en los datos, por favor verificar la información.');
					}
				});
			});
			$(".del_ExpenseRowActividad").on( "click", function () {
				var txt;
				var r = confirm("Esta seguro de Eliminar esta activdad?");
				if (r == true) {
					txt = "You pressed OK!";
				} else {
					return false;
				}
				
			
           var i = $(this).attr('id');
           i = i.replace("delete_",""); 
           var value = $('#idEliminar_'+i).val();
            
           var user = $('#user').val();
           
              	$.ajax({
					url: 'classSolicitudProrroga.php',  
					type: 'POST',
					dataType: 'json',
                    data: {value:value,Action_id:'deleteActividad',user:user},			
					//una vez finalizado correctamente
					success: function(data)
					{
						alert('La Actividad fue eliminada correctamente.');
					},
					//si ha ocurrido un error
					error: function(){
					   message = $("<span class='error'>Ha ocurrido un error.</span>");
					   showMessage(message);
						 alert('Se encontraron errores en los datos, por favor verificar la información.');
					}
				});
			});
});


/* CARGAR FACULTAD */
function cargar_facultad(modalidad){
    //var modalidad = $('#modalidad').val();
    $.ajax({
        type: 'POST',
        url: 'acuerdos_ajax.php',
        async: false,
        dataType: 'json',
        data:({actionID: 'carga_facultad',
            modalidad:modalidad
        }),
        error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
        success: function(data){
            if(data.val=='FALSE'){
                alert(data.descrip);
                return false;
            }else{
                if(data.modalidad == 200){
					$('#facultad').html(data.option);
				}else{
					$('#programa').html(data.option);
				}
            }
        }
    });
}

function isImage(extension)
{
    switch(extension.toLowerCase())
    {
        case 'xlx': case 'pdf': case 'docx':
            return true;
        break;
        default:
            return false;
        break;
    }
}
/* CARGAR PROGRAMA ACADEMICO */
function cargar_programa_academico(facultad_id, documento_docente, periodo_id, modalidad){
    $.ajax({
	       type: 'POST',
		   url: 'acuerdos_ajax.php',
           data:({actionID:'cargar_programa_academico',facultad_id:facultad_id, documento_docente:documento_docente, periodo_id:periodo_id, modalidad: modalidad}),
		   error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
		   success:function(data){
                $('#programa').html('');
                $('#programa').html(data);
	       }
    });
}

function oculta_vocacion(vocacion){
	$('#'+vocacion).slideUp();
	$('#plus-'+vocacion).css('display', 'block');
}


function showMessage(message){
    $(".messages").html("").show();
    $(".messages").html(message);
}


function guradarcambiosacuerdo()
{
    var cupos = $('#cupos').val();
    var AcuerdoId = $('#id').val();
    var estado = $('#estado').val();
    var user = $('#user').val();
    
    $.ajax({
    type: 'POST',
    url:'acuerdos_ajax.php',
    data:({actionID:'GuardaCambios', AcuerdoId: AcuerdoId, cupos:cupos, estado:estado, user:user}),
    error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
    success:function(data)
    {
        alert('La información se actualizo correctamente.');
        location.href="../convenio/AcuerdosCarreras.php";
    }
    });
    
}
function RegresarAcuerdo()
{
   location.href="../convenio/AcuerdosCarreras.php"; 
}