<?php

/*include_once('../utilidades/ValidarSesion.php'); 
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION);*/


header ('Content-type: text/html; charset=utf-8');
header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

session_start();

include "funciones.php";

//var_dump($db);
if($db==null){
	include_once ('../EspacioFisico/templates/template.php');
	$db = getBD(); 
}

if($_POST){ 
    $keys_post = array_keys($_POST); 
    foreach ($keys_post as $key_post){ 
      $$key_post = $_POST[$key_post] ; 
     } 
 }

 if($_GET){
    $keys_get = array_keys($_GET); 
    foreach ($keys_get as $key_get){ 
        $$key_get = $_GET[$key_get]; 
     } 
 } 

$idDocente = $_GET["idDocente"];

$idPrograma = $_GET["idPrograma"];

$idPeriodo = $_GET["idPeriodo"];

$sqlDocente = "SELECT CONCAT(nombredocente, ' ', apellidodocente ) AS NombreDocente 
				FROM docente
				WHERE iddocente = $idDocente";

$sacaDocente = $db->Execute( $sqlDocente );
$nombreDocente = $sacaDocente->fields["NombreDocente"];

$idVocaciones = explode("|", $_GET["idVocacion"]);
$idVocaciones = array_merge(array_unique($idVocaciones));
$idVocaciones = orderMultiDimensionalArray($idVocaciones);

	?>
	<div style="font-family: 'Century Gothic', CenturyGothic, AppleGothic, sans-serif; margin: 20px; ">
		<input type="hidden" id="txtIdDocente" name="txtIdDocente" value="<?php echo $idDocente; ?>" />
			<span >Docente:&nbsp;&nbsp;&nbsp;<strong><?php echo $nombreDocente; ?></strong></span><br />
	</div>
	<?php 
	$maximoPorcentaje = 100;
	$contarVocacion = 0;
	foreach( $idVocaciones as $idVocacion ){
		
		$sqlVocaciones = "SELECT Nombre FROM VocacionPlanesTrabajoDocentes WHERE VocacionesPlanesTrabajoDocenteId = $idVocacion";
		
		$nombreVocacion = $db->Execute( $sqlVocaciones );
		
		$sqlAutoEvaluacionD = "SELECT
									AED.AutoevaluacionDocentesId,
									CRA.nombrecarrera AS programa,
									AED.CodigoCarrera AS CodigoCarrera,
									AED.VocacionesId AS VocacionesId,
									AED.Descripcion AS Descripcion,
									AED.PorcentajeCumplimiento AS Porcentaje,
									AED.PorcentajeCumplimientoDecanos,
									AED.ComentarioDecanos,
									AED.CodigoEstado
								FROM
									AutoevaluacionDocentes AED
								INNER JOIN carrera CRA ON (
									CRA.codigocarrera = AED.CodigoCarrera
								)
								WHERE
									AED.DocenteId = $idDocente
								AND AED.CodigoPeriodo = $idPeriodo
								AND AED.CodigoCarrera = $idPrograma
								AND AED.VocacionesId = $idVocacion
								";
		
		$docenteAutoEvaluaciones = $db->Execute( $sqlAutoEvaluacionD );
	if( $docenteAutoEvaluaciones->_numOfRows != 0 ){		
		$porcentajeDecano = $docenteAutoEvaluaciones->fields["PorcentajeCumplimientoDecanos"];
		$comentarioDecano = $docenteAutoEvaluaciones->fields["ComentarioDecanos"];
		$estadoAutoE = $docenteAutoEvaluaciones->fields["CodigoEstado"];
		
		if( $estadoAutoE == 200 ) {
			$atributo = 'disabled = "disabled"';
			
		}else{
			$atributo = "";
			
		}
		if ( ( $porcentajeDecano && $comentarioDecano ) != null ){
			$texto = 'placeholder = "Ya existe un comentario ingresado para esta vocación"';
		}else{
			$texto = "";
		} 
					
	?>
	<html>
	<head>
	<title>Autoevaluación Docente</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link type="text/css" rel="stylesheet" href="tema/themes/base/jquery.ui.all.css" />
	<script type="text/javascript" language="javascript" src="tema/paginador/js/jquery-3.6.0.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			$("#btnGuardarAEv<?php echo $contarVocacion; ?>").click(function(){
				
				
				if( validarAutoevaluacion( ) ){
				var txtIdAutoevaluacion = $("#txtIdAutoevaluacion<?php echo $contarVocacion; ?>").val( );
				var txtComentarioAE = $("#txtComentarioAE<?php echo $contarVocacion; ?>").val( );
				var cmbComentarioAE = $("#cmbComentarioAE<?php echo $contarVocacion; ?>").val( );
				var txtIdDocente = $("#txtIdDocente").val( );
				var codigoPeriodo = $("#txtCodigoPeriodo").val( );
					$.ajax({
						url: "servicio/autoevaluacion.php",
				  		type: "POST",
				  		data: { txtIdAutoevaluacion : txtIdAutoevaluacion, txtComentarioAE : txtComentarioAE, cmbComentarioAE : cmbComentarioAE, txtIdDocente : txtIdDocente, codigoPeriodo : codigoPeriodo},
						success: function( data ){
							
							alert(data);
							location.reload();	
						}
					});
				
					return false;
				}
				return false;
			});
			
			function validarAutoevaluacion( ){
				
				if( $("#txtComentarioAE<?php echo $contarVocacion; ?>").val( ) == ""){
					alert("Por favor inserte un comentario de autoevaluacion");
					$("#txtComentarioAE<?php echo $contarVocacion; ?>").focus( );
					return false;
					
				}
				if( $("#cmbComentarioAE<?php echo $contarVocacion; ?>").val( ) == "-1"){
					alert("Por favor seleccione un porcentaje de cumplimiento");
					$("#cmbComentarioAE<?php echo $contarVocacion; ?>").focus( );
					return false;
				}
				
				return true;
			}
		});
	</script>
	<style type="text/css">
		.verAutoE{
			-moz-box-shadow:inset 0px 1px 0px 0px #ffffff;
			-webkit-box-shadow:inset 0px 1px 0px 0px #ffffff;
			box-shadow:inset 0px 1px 0px 0px #ffffff;
			background:-webkit-gradient(linear, left top, left bottom, color-stop(0.05, #ffffff), color-stop(1, #f6f6f6));
			background:-moz-linear-gradient(top, #ffffff 5%, #f6f6f6 100%);
			background:-webkit-linear-gradient(top, #ffffff 5%, #f6f6f6 100%);
			background:-o-linear-gradient(top, #ffffff 5%, #f6f6f6 100%);
			background:-ms-linear-gradient(top, #ffffff 5%, #f6f6f6 100%);
			background:linear-gradient(to bottom, #ffffff 5%, #f6f6f6 100%);
	/*filter: progid:DXImageTransform.Microsoft.gradient(startColorstr=#ffffff, endColorstr=#f6f6f6,GradientType=0);*/
			background-color:#ffffff;
			-moz-border-radius:6px;
			-webkit-border-radius:6px;
			border-radius:6px;
			border:1px solid #dcdcdc;
			display:inline-block;
			cursor:pointer;
			color:#666666;
			font-family:Arial;
			font-size:12px;
			font-weight:normal;
			padding:4px 22px;
			text-decoration:none;
			text-shadow:0px 1px 0px #ffffff;
		}
		
		.verAutoE:hover {
			background:-webkit-gradient(linear, left top, left bottom, color-stop(0.05, #f6f6f6), color-stop(1, #ffffff));
			background:-moz-linear-gradient(top, #f6f6f6 5%, #ffffff 100%);
			background:-webkit-linear-gradient(top, #f6f6f6 5%, #ffffff 100%);
			background:-o-linear-gradient(top, #f6f6f6 5%, #ffffff 100%);
			background:-ms-linear-gradient(top, #f6f6f6 5%, #ffffff 100%);
			background:linear-gradient(to bottom, #f6f6f6 5%, #ffffff 100%);
			/*filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#f6f6f6', endColorstr='#ffffff',GradientType=0);*/
			background-color:#f6f6f6;
		}
		
		.verAutoE:hover {
			position:relative;
			top:1px;
		}
		
	</style>
    </head>
    <body style="background: #eff2dc;">
    
	<div style="font-family: 'Century Gothic', CenturyGothic, AppleGothic, sans-serif;">
		<form id="formAutoevaluacion">
			<p>
				<input type="hidden" id="txtIdAutoevaluacion<?php echo $contarVocacion; ?>" name="txtIdAutoevaluacion<?php echo $contarVocacion; ?>" value="<?php echo $docenteAutoEvaluaciones->fields["AutoevaluacionDocentesId"]; ?>" />
				<input type="hidden" id="txtCodigoPeriodo" name="txtCodigoPeriodo" value="<?php echo $idPeriodo; ?>" />
				
			</p>
		<fieldset style="border:1px groove #ccc; border-radius: 3px; margin: 20px">
			<legend style="color: #5169B1; font-size: 15pt;"><?php echo $nombreVocacion->fields["Nombre"]; ?></legend>
			<br />
			<div style="border:1px groove; border-radius: 2px;">
			<tr>
				<td>
					<table width="50%" border="0" style="color: black; margin-left: 20px;">
						<tr>
							<td><span style="font-size: 12pt; font-weight: bold;">Porcentaje Cumplimiento del Docente: <?php echo $docenteAutoEvaluaciones->fields["Porcentaje"]."%"; ?>.</span></td>
						</tr>
						<tr>
							<td>Autoevaluación Docente</td>
						</tr>
						<tr>
							<td><textarea rows="7" cols="70" readonly="readonly" style="font-family: 'Century Gothic', CenturyGothic, AppleGothic, sans-serif;" ><?php echo strip_tags($docenteAutoEvaluaciones->fields["Descripcion"]); ?></textarea></td>
						</tr>
						<tr>
							<td></td>
						</tr>
						<tr>
							<td>Comentario Decano: &nbsp;&nbsp;&nbsp;</td>
						</tr>
						<tr>
							<td><textarea rows="5" cols="45" id="txtComentarioAE<?php echo $contarVocacion; ?>" name="txtComentarioAE<?php echo $contarVocacion; ?>" <?php echo $atributo. " ".$texto; ?> ></textarea></td>
						</tr>
						<tr>
							<td>Porcentaje de Cumplimiento: &nbsp;&nbsp;&nbsp;
							<select id="cmbComentarioAE<?php echo $contarVocacion; ?>" name="cmbComentarioAE<?php echo $contarVocacion; ?>" <?php echo $atributo; ?> >
								<option value="-1">Seleccione</option>
								<?php for( $i = 5; $i <= $maximoPorcentaje;  $i+=5 ) {?>
                						<option value="<?php echo $i;?>"><?php echo $i."%"; ?> </option>
            					<?php } ?>
							</select>	
							</td>
						</tr>
						<tr>
							<td></td>
						</tr>
						<tr>
							<td></td>
						</tr>	
					</table>
				</td>
			</tr>
			<br />
			<div align="center">
				<?php if( ( $porcentajeDecano && $comentarioDecano ) == null && $estadoAutoE != 200 ) { ?>
				<button id="btnGuardarAEv<?php echo $contarVocacion; ?>" name="btnGuardarAEv<?php echo $contarVocacion; ?>" class="verAutoE">Guardar</button>
				<?php } ?>
			</div>
			<br />
			</div>
			<br />
		</fieldset>
		</form>
	</div>
	<br />
	</body>
	</html>	
	<?php 
			$contarVocacion = $contarVocacion + 1;
		}
	}
?>