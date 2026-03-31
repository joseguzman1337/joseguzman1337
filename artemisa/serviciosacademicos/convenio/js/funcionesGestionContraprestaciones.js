$(document).ready(function() {
$('#modalidad').change(function (){
    var convenio = $('#idconvenio').val();
        var modalidad = $(this).val();
        if(modalidad == 0){
            alert('seleccione una modalidad antes de continuar');
        }else{
            cargar_facultad(modalidad,convenio);
            if(modalidad == 200){
                $('#facultad').removeAttr('disabled');
                $('#programa').attr('disabled', 'true');
                $('#Div_Facultad').removeAttr('style');
            }
            if(modalidad == 300){
                $('#Div_Facultad').css('display', 'none');
                $('#programa').removeAttr('disabled');
            }
        }
    });
    
$("#facultad").change(function(){
        var facultad_id;
        var documento_docente;
        var periodo;
        facultad_id = $(this).val();
        documento_docente = $('#NumDocumento').val();
        periodo = $('#Periodo').val();
		var modalidad = $('#modalidad').val();
                var convenio = $('#idconvenio').val();
    
        if(facultad_id == 0){
            alert('seleccione una facultad antes de continuar');
            $('#contenedores').fadeOut(1000);
            $('#programa').attr('disabled', 'disabled');
        }else{
            cargar_programa_academico(facultad_id, documento_docente, periodo, modalidad,convenio);
            $('#programa').removeAttr('disabled');
        }
    }); 
});

/* CARGAR FACULTAD */
function cargar_facultad(modalidad,convenio){
    
    $.ajax({
        type: 'POST',
        url: '../acuerdos_ajax.php',
        async: false,
        dataType: 'json',
        data:({actionID: 'carga_facultad',
            modalidad:modalidad,convenio:convenio
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
/* CARGAR PROGRAMA ACADEMICO */
function cargar_programa_academico(facultad_id, documento_docente, periodo_id, modalidad,convenio){
    $.ajax({
	       type: 'POST',
		   url: '../acuerdos_ajax.php',
           data:({actionID:'cargar_programa_academico_carreraconvenio',facultad_id:facultad_id, documento_docente:documento_docente, periodo_id:periodo_id, modalidad: modalidad,convenio:convenio}),
		   error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
		   success:function(data){
                $('#programa').html('');
                $('#programa').html(data);
	       }
    });
}

function ActualizarPrograma(from)
{    
    $.ajax({
        type: 'POST',
        url: '../Controller/NuevoPrograma.php',
        async: false,
        dataType: 'json',
        data:$(from).serialize(),
        error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
        success: function(data){
            if(data.val==true){
                      alert('Se actualizo la Carrera');
                      location.href="../Controller/ModificarContraprestaciones.php";
                   }
        }
    });  
}

function RegresarModificarcontraprestacion(){
    location.href="../Controller/ModificarContraprestaciones.php";
}

function RegresarReporteGerencial(){
    location.href="../Controller/RerporteGerencial.php";
}

function RegresarContraprestacion(){    
    location.href="../Controller/ModificarContraprestaciones.php";
}

function RegresarFormulas(){
    location.href="../Controller/Formulasliquidacion.php";
}

