<?php
	/*session_start;
include_once(realpath(dirname(__FILE__)).'/../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);*/

	include_once(realpath(dirname(__FILE__))."/../variables.php");
    include($rutaTemplate."template.php");
    $db = writeHeader("Importar participantes",TRUE);

    include("./menu.php");
    writeMenu(5);
    
    $data = array();
    $mensaje="";
    
    if(isset($_REQUEST["mensaje"])){
        $mensaje=$_REQUEST["mensaje"];
        
    }
    $mensajeTodo=explode(':',$mensaje);
    $mensajeTipo=$mensajeTodo[0];
    $mensaje=$mensajeTodo[1];
    
	if(isset($_REQUEST["id"])){  
       $id = str_replace('row_','',$_REQUEST["id"]);
	   $utils = Utils::getInstance();
       $data = $utils->getDataEntity("carrera", $id, "codigocarrera");       
	   //var_dump($data);
	   
	   ?>
	   <script type="text/javascript">
	   $(document).ready(function(){
			$.ajax({
					dataType: 'json',
					type: 'POST',
					async: false,
					url: '../searches/esCursoAbierto.php',
					data: {carrera: <?php echo $id; ?>},                
					success:function(data){
						if (data.result == true){
							//Es un curso abierto
							//$('#empresaPatrocinio').css("display","block");
						} else {
							//$('#empresaPatrocinio').css("display","none");
						}
					},
					error: function(data,error,errorThrown){alert(error + errorThrown);}
				 }); 
		}); 
		 </script>
	   <?php 
   }
	

?>
<script type="text/javascript" src="../js/jquery.powertip.js"></script>
<link rel="stylesheet" type="text/css" href="../css/jquery.powertip.css" />
<div id="contenido" style="margin-top: 10px;">
					<h4>Inscribir Participantes</h4>
    <div id="form"> 
        <form action="inscribirParticipantesBackEnd.php" method="post" id="form_test" enctype="multipart/form-data">
            <p style="margin:0; font-weight: bold; <?php if(strcmp('exito', $mensajeTipo)==0){ echo 'color:green;';}else{ echo 'color:red';} ?>"><?php echo $mensaje;?></p>
            <br/>
            <label for="nombre" class="fixed" style="width:170px" >Curso: <span class="mandatory">(*)</span></label>
            <input type="text"  class="grid-6-12 required" minlength="2" name="carrera" id="carrera" title="Nombre de la Carrera" maxlength="120" tabindex="1" autocomplete="off" value="<?php echo $data["nombrecarrera"]; ?>"  />
            <input type="hidden" name="codigocarrera" id="codigocarrera" value="<?php echo $data["codigocarrera"]; ?>" />            
            <input type="hidden" name="tipocurso" id="tipocurso" value="" /> 
            <label for="nombre" class="fixed" style="width:170px">Grupo: <span class="mandatory">(*)</span></label>
		<select name="idgrupo" id="grupos" class="required"><option value=""></option></select>
			<!--<div id="empresaPatrocinio" style="display:none">
				<label for="nombre" class="fixed" style="width:170px">Empresa: <span class="mandatory">(*)</span></label>
                <input type="text"  class="grid-6-12 empresaName" minlength="2" name="empresa" id="empresa_1" title="Empresa" maxlength="200" tabindex="1" autocomplete="off" value="" />
                <input type="hidden"  class="grid-5-12" minlength="2" name="idempresa" id="idempresa_1" maxlength="12" tabindex="1" autocomplete="off" value="" />
                <input type="hidden"  class="grid-5-12" minlength="2" name="tmp_empresa" id="tmp_empresa_1" value="" />
				<input type="hidden"  class="grid-5-12" minlength="2" name="tipo" id="tipo" value="2" />
			</div>-->
			
            <div class="vacio"></div>
            <label for="file" class="fixed" style="width:170px">Archivo de participantes: <span class="mandatory">(*)</span></label>
            <input accept="application/vnd.ms-excel" type="file" name="file" id="file">
			
            <a href="../templates/plantillaRegistroEstudiante.xls" style="font-size:11px;margin-left:15px;position: relative;top: -5px;"> (descargar plantilla en excel) </a>
			<img width="32" height="32" alt="ayuda" id="ayuda" name="image" src="../images/help.png" style="cursor:pointer;">
            <br/>
            <br/>
			<div id="mensajeInscripciones" style="background-color:#fff6bf;padding:10px;font-weight:bold;display:none;"></div>
            <br/>
            
            <input type="submit" value="Inscribir participantes" class="first" style="margin-left:190px" />
            
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
    else{
        if(document.getElementById('file').value==''){
            alert('Por favor ingresar un archivo');
            return false;
        }
        else{
            var validExts = new Array(".xlsx", ".xls", ".csv");
            var fileExt=document.getElementById('file').value;
            fileExt = fileExt.substring(fileExt.lastIndexOf('.'));
            if(validExts.indexOf(fileExt) < 0){
                alert("Tipo de archivo inválido, favor seleccionar uno de los siguientes tipos de archivo: " + validExts.toString());
                return false;
            }
            
        }
    }
	
	//si es abierto y no se define la empresa entonces pailas
	/*if(($('#tipo').val()==1 && $('#empresa_1').val()=="")){
            $( "#empresa_1" ).addClass('error');
            $( "#empresa_1" ).effect("pulsate", { times:3 }, 500);
            return false;
	}*/
	$( "#carrera" ).removeClass('error');
	$( "#grupos" ).removeClass('error');
	//$( "#empresa_1" ).removeClass('error');
	
	return true;
}


function getGrupos(){
    var carrera = $('#codigocarrera').val();
    //var fecha = $("#fechaLista").val();
    
    $.ajax({
	dataType: 'json',
	type: 'POST',
	async: false,
        url: '../searches/lookForAllGrupos.php',        
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
			alert("No hay grupos activos para este curso. Por favor crear una nueva versión antes de inscribir participantes.");
		}
	},
	error: function(data,error,errorThrown){alert(error + errorThrown);}
   }); 
}

function checkInscripcion(){
    var carrera = $('#codigocarrera').val();
    
    $.ajax({
	dataType: 'json',
	type: 'POST',
	async: false,
        url: '../searches/checkInscripcion.php',  
	data: {carrera: carrera},                
	success:function(data){
		if (data.success == true){
           $("#mensajeInscripciones").html(data.mensaje);
			$('#mensajeInscripciones').css("display","block");
		} else {
			$('#mensajeInscripciones').css("display","none");
		}
	},
	error: function(data,error,errorThrown){alert(error + errorThrown);}
   }); 
}
                
$(document).ready(function(){
    $('#carrera').autocomplete({
        source: function( request, response ) {
            $.ajax({
                url: "../searches/lookForCursos.php",
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
            //alert(ui.item.id);
            $('#codigocarrera').val(ui.item.id);
			checkInscripcion();
            getGrupos();
			//verificar si el curso es abierto o no
			verificarTipoGrupo(); 
            
        }                
    });
	
	/*$("#empresa_1").autocomplete({
                        source: function( request, response ) {
                            $.ajax({
                                url: "../searches/lookForEmpresas.php",
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
                            $('#tmp_empresa_1').val($('#empresa_1').val());
                        },
                        select: function( event, ui ) {
                            //alert(ui.item.id);
                            if(ui.item.value=="null"){
                                event.preventDefault();
                                $('#empresa_1').val($('#tmp_empresa_1').val());
                            }
                            $('#idempresa_1').val(ui.item.id);
                        }                
                    });*/
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
    '<p><b>Campos opcionales para cursos abiertos:</b></p>',
    '<p>Especialidad, Correo alterno, Número de Factura.</p>',
	'<p><b>Campos opcionales para cursos cerrados:</b></p>',
    '<p>Especialidad, Correo alterno, Empresas, Número de Factura.</p>',
    '<p style="font-size:0.8em;">Nota: si el participante ya es estudiante de la universidad no es necesario<br/>completar toda la información personal, solo el número de documento.</p>',
    ].join('\n')));
$('#ayuda').powerTip({
    placement: 'sw',
    smartPlacement: true
});


$('#grupos').change(function(){
    verificarTipoGrupo();
});


function verificarTipoGrupo(){	
		var id = $('#grupos').val();
		var carrera = $('#codigocarrera').val();
			//verificar si el curso es abierto o no
			$.ajax({
					dataType: 'json',
					type: 'POST',
					async: false,
					url: '../searches/esCursoAbierto.php',
					data: {carrera: carrera, grupo:id},                
					success:function(data){
						$('#tipocurso').val(data.result);
						if (data.result == true){
							//Es un curso abierto
							//$('#empresaPatrocinio').css("display","block");
						} else {
							//$('#empresaPatrocinio').css("display","none");
						}
					},
					error: function(data,error,errorThrown){alert(error + errorThrown);}
				 }); 
            
}

<?php if(isset($_REQUEST["id"])){  ?>

$(document).ready(function(){
	getGrupos();
	verificarTipoGrupo();
});

<?php } ?>
  </script>
<?php  writeFooter(); ?>
