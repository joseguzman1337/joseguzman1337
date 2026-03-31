<?php
session_start();
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
			<span >Docente:&nbsp;&nbsp;&nbsp;<strong><?php echo $nombreDocente; ?></strong></span><br /><br />
			<span >A continuación se detalla las oportunidades de consolidación y de mejora del Docente</span><br />
	</div>
	<?php
	foreach( $idVocaciones as $idVocacion ){
		
		$sqlVocaciones = "SELECT Nombre FROM VocacionPlanesTrabajoDocentes WHERE VocacionesPlanesTrabajoDocenteId = $idVocacion";
		
		$nombreVocacion = $db->Execute( $sqlVocaciones );
		
		$sqlPlanMejoraD = "SELECT
									PM.PlanMejoraDocentesId,
									CRA.nombrecarrera AS programa,
									PM.CodigoCarrera AS CodigoCarrera,
									PM.VocacionesId AS VocacionesId,
									PM.PlanMejora AS PlanMejora,
									PM.PlanMejoraConsolidado AS PlanMejoraConsolidado,
									PM.CodigoEstado
								FROM
									PlanMejoraDocentes PM
								INNER JOIN carrera CRA ON (
									CRA.codigocarrera = PM.CodigoCarrera
								)
								WHERE
									PM.DocenteId = $idDocente
								AND PM.CodigoPeriodo = $idPeriodo
								AND PM.CodigoCarrera = $idPrograma
								AND PM.VocacionesId = $idVocacion
								AND PM.CodigoEstado = 100";
		
		$docentePlanMejoras = $db->Execute( $sqlPlanMejoraD );
	if( $docentePlanMejoras->_numOfRows != 0 ){		
		$planMejoraConsolidado = $docentePlanMejoras->fields["PlanMejoraConsolidado"];
		$planMejora = $docentePlanMejoras->fields["PlanMejora"];
		$comentarioDecano = $docenteAutoEvaluaciones->fields["ComentarioDecanos"];
		$estadoPM = $docentePlanMejoras->fields["CodigoEstado"];
					
	?>
	<html>
	<head>
	<title>Plan Mejora Docente</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link type="text/css" rel="stylesheet" href="tema/themes/base/jquery.ui.all.css" />
	<script type="text/javascript" language="javascript" src="tema/paginador/js/jquery-3.6.0.min.js"></script>
    </head>
    <body style="background: #eff2dc;">
    
	<div style="font-family: 'Century Gothic', CenturyGothic, AppleGothic, sans-serif;">
		
		<form id="formAutoevaluacion">
		<fieldset style="border:1px groove #ccc; border-radius: 3px; margin: 20px">
			<legend style="color: #5169B1; font-size: 15pt;"><?php echo $nombreVocacion->fields["Nombre"]; ?></legend>
			<br />
			<div style="border:1px groove; border-radius: 2px;">
			<tr>
				<td>
					<table width="50%" border="0" style="color: black; margin-left: 20px;">
						<tr>
							<td>Oportunidades de Consolidación</td>
						</tr>
						<tr>
							<td><textarea rows="7" cols="70" readonly="readonly" style="font-family: 'Century Gothic', CenturyGothic, AppleGothic, sans-serif;" ><?php echo strip_tags($planMejoraConsolidado); ?></textarea></td>
						</tr>
						<tr>
							<td></td>
						</tr>
						<tr>
							<td>Oportunidades de Plan Mejora</td>
						</tr>
						<tr>
							<td><textarea rows="7" cols="70" readonly="readonly" style="font-family: 'Century Gothic', CenturyGothic, AppleGothic, sans-serif;" ><?php echo strip_tags($planMejora); ?></textarea></td>
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
			</div>
			<br />
		</fieldset>
		</form>
	</div>
	<br />
	</body>
	</html>	
	<?php 
			
		}
	}
?>