<?php
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
	include("../../templates/templateAutoevaluacion.php");
    $db =writeHeader("Importar respuestas desde Excel",true,"Autoevaluacion");

    $data = array();
    $mensaje="";
    
    if(isset($_REQUEST["mensaje"])){
        $mensaje=$_REQUEST["mensaje"];        
    }
    $mensajeTodo=explode(':',$mensaje);
    $mensajeTipo=$mensajeTodo[0];
    $mensaje=$mensajeTodo[1];    

?>
<link rel="stylesheet" href="../../../educacionContinuada/css/normalize.css" type="text/css" /> 
<link rel="stylesheet" href="../../../educacionContinuada/css/style.css" type="text/css"  media="screen, projection" /> 
<script type="text/javascript" src="../../../educacionContinuada/js/jquery.powertip.js"></script>
<link rel="stylesheet" type="text/css" href="../../../educacionContinuada/css/jquery.powertip.css" />
<style type="text/css">
form input[type="text"],form select{
padding:7px 5px 5px;
}
</style>
<div id="contenido" style="margin-top: 10px;">
<h4>Registrar Respuestas Instrumento de Percepción</h4>
    <div id="form"> 
        <form action="procesarRespuestasEC.php" method="post" id="form_test" enctype="multipart/form-data">
            <div id="msg-success" class="msg-success" <?php if(strcmp('exito', $mensajeTipo)==0){ echo 'style="display:block"'; $mostrar=true; } else {echo 'style="display:none"'; $mostrar=false;} ?> ><p><?php echo $mensaje;?></p></div>
            <div id="msg-error" class="msg-error" <?php if(!$mostrar&&$mensajeTipo!=""){ echo 'style="display:block"'; } else {echo 'style="display:none"';} ?> ><p><?php echo $mensaje;?></p></div>
			     <div class="vacio"></div>
			<label for="nombre" class="fixed" style="width:170px" >Curso: <span class="mandatory">(*)</span></label>
						<input type="text"   class="grid-6-12 required" minlength="2" name="carrera" id="carrera" title="Nombre de la Carrera" maxlength="120" tabindex="1" autocomplete="off" value="<?php echo $data["nombrecarrera"]; ?>"  />
						<input type="hidden" name="codigocarrera" id="codigocarrera" value="<?php echo $data["codigocarrera"]; ?>" />            
						<input type="hidden" name="tipocurso" id="tipocurso" value="" /> 
						<label for="nombre" class="fixed" style="width:170px">Grupo: <span class="mandatory">(*)</span></label>
					<select name="idgrupo" id="grupos" class="required" style="padding:3px 5px;"><option value=""></option></select>
            <div class="vacio"></div>
            <label for="file">Archivo con las respuestas y preguntas:</label>
            <input accept="application/vnd.ms-excel" type="file" name="file" id="file" style="position:relative;top:-5px;">
            <a href="../../../educacionContinuada/templates/plantillaRegistroInstrumento.xls" style="font-size:11px;margin-left:15px;position: relative;top: -15px;"> (descargar plantilla en excel) </a>
 		<img width="32" height="32" alt="ayuda" id="ayuda" name="image" src="../../../educacionContinuada/images/help.png" style="cursor:pointer;position: relative; top: -5px;">

            <br/>
            <br/>
            <br/>
            
            <input type="submit" value="Registrar instrumento de percepción" />
            
        </form>
    </div>
 </div>


<script type="text/javascript">
$(':submit').click(function(event){
    event.preventDefault();
    if(validar()){
        $("#form_test").submit();
    }
});

function validar(){
	$( "#carrera" ).removeClass('error');
	$( "#grupos" ).removeClass('error');
	if(document.getElementById('codigocarrera').value==''){
		$( "#carrera" ).addClass('error');
        $( "#carrera" ).effect("pulsate", { times:3 }, 500);
        alert('Por favor ingresar un curso válido.');
        return false;
    } else if(document.getElementById('grupos').value==''){
	$( "#grupos" ).addClass('error');
	$( "#grupos" ).effect("pulsate", { times:3 }, 500);
        alert('Por favor elegir el grupo al que se inscribiran los participantes.');
	return false; 

	}
    else if(document.getElementById('file').value==''){
        alert('Por favor ingresar un archivo.');
        return false;
    }
    else{
        var validExts = new Array(".xls");
        var fileExt=document.getElementById('file').value;
        fileExt = fileExt.substring(fileExt.lastIndexOf('.'));
        if(validExts.indexOf(fileExt) < 0){
            alert("Tipo de archivo invalido, favor seleccionar uno de los siguientes tipos de archivo: " + validExts.toString());
            return false;
        }
    }
	return true;
}


function getGrupos(){
    var carrera = $('#codigocarrera').val();
    //var fecha = $("#fechaLista").val();
    
    $.ajax({
	dataType: 'json',
	type: 'POST',
	async: false,
        url: '../../../educacionContinuada/searches/lookForAllGrupos.php',        
	//url: '../searches/lookForGrupos.php',
	data: {carrera: carrera},                
	success:function(data){
		if (data.success == true){
                        var opciones = "";
			for (var i=0;i<data.total;i++)
                        {              
                            opciones = opciones + "<option value='"+data.data[i].value+"'>"+data.data[i].label+"</option>";                                      
                        }
                        $("#grupos").html(opciones);
		} else {                    
                        $("#grupos").html("<option value=''></option>");
			alert("No hay grupos para este curso. Por favor crear un grupo antes de cargar la autoevaluacion.");
		}
	},
	error: function(data,error,errorThrown){alert(error + errorThrown);}
   }); 
}

$(document).ready(function(){
    $('#carrera').autocomplete({
        source: function( request, response ) {
            $.ajax({
                url: "../../../educacionContinuada/searches/lookForCursos.php",
                dataType: "json",
                data: {
                    term: request.term
                },
                success: function( data ) {
                    response( $.map( data, function( item ) {
                        return {
                            label: item.label,
                            value: item.value,
                            id: item.id
                        }
                    }));
                }
            });
        },
        minLength: 2,
        selectFirst: false,
        open: function(event, ui) {
            var maxWidth = $('#form_test').width()-400;  
            var width = $(this).autocomplete("widget").width();
            if(width>maxWidth){
                $(".ui-autocomplete.ui-menu").width(maxWidth);                                 
            }
            
        },
        select: function( event, ui ) {
            $('#codigocarrera').val(ui.item.id);
            getGrupos();
            
        }                
    });
});
$('#carrera').change(function(){
    if(document.getElementById('carrera').value==''){
        document.getElementById('codigocarrera').value='';
        
    }
});


$('#grupos').change(function(){
    if(document.getElementById('carrera').value==''){
        document.getElementById('codigocarrera').value='';
        
    }
});

$('#ayuda').data('powertipjq', $([
    '<p><b>Nota:</b></p>',
    '<p>Se crearán las preguntas e instrumento de percepción al hacer el cargue</p>'
    ].join('\n')));
$('#ayuda').powerTip({
    placement: 'sw',
    smartPlacement: true
});

  </script>
<?php  writeFooter(); ?>