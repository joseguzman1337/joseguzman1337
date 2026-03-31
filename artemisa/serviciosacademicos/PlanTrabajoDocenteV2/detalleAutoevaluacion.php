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
 
 

 
 switch( $tipoOperacion ){
	case 'insertarAutoEvaluacion':
		
	$txtAutoEvaluacion = $_POST["autoEvaluacion"];	
	 
 	$txtPorcentaje = $_POST["porcentaje"];
	
	$idDocente = $_POST["id_Docente"];
 
 	$periodo = $_POST["Periodo"];
 
 	$txtCarrera = $_POST["txtCarreraAE"];
	
	$txtNumeroDocumento = $_POST["txtNumeroDocumento"];
	 
 	$idVocacion = $_POST["idVocacion"];
 			
	$sqlUsuarioDocente = "SELECT idusuario FROM usuario WHERE numerodocumento = $txtNumeroDocumento LIMIT 1";
	 
	$txtIdUsuario = $db->Execute($sqlUsuarioDocente);
	
	
	if( $txtIdUsuario->fields["idusuario"] != ""){
		$txtIdUsuario = $txtIdUsuario->fields["idusuario"];
	}else{
		$txtIdUsuario = "4186";
	}
	 
	$sqlInsertAutoEvaluacion = "INSERT INTO AutoevaluacionDocentes (
													AutoevaluacionDocentesId, 
													DocenteId, 
													Descripcion, 
													VocacionesId, 
													CodigoPeriodo, 
													CodigoEstado, 
													CodigoCarrera, 
													PorcentajeCumplimiento, 
													PorcentajeCumplimientoDecanos, 
													UsuarioCreacion, 
													UsuarioUltimaModificacion, 
													FechaCreacion, 
													FechaUltimaModificacion, 
													UsuarioId,
													ComentarioDecanos
												) VALUES ((SELECT IFNULL(MAX(AED.AutoevaluacionDocentesId)+1,1) 
																FROM AutoevaluacionDocentes AED), $idDocente, '$txtAutoEvaluacion', $idVocacion, '$periodo', default, $txtCarrera, $txtPorcentaje, 0, $txtIdUsuario, $txtIdUsuario, NOW(), NOW(), $txtIdUsuario, default)";
	
		
	$ingresoAutoEvaluacion = $db->Execute( $sqlInsertAutoEvaluacion );
	
	if($ingresoAutoEvaluacion === false ){
		echo "0";
	}else{
		echo "1";
	}
	break;
	
	case 'listaAutoEvaluacion':
	
	$id_Programa = $_GET["id_Programa"];
	
	$idDocente = $_GET["id_Docente"];
	
	$periodo = $_GET["Periodo"];
	
	$sqlListaAE = "SELECT
						AED.AutoevaluacionDocentesId,
						AED.ComentarioDecanos,
						AED.VocacionesId,
						AED.PorcentajeCumplimientoDecanos,
						V.Nombre
					FROM
						AutoevaluacionDocentes AED
					INNER JOIN VocacionPlanesTrabajoDocentes V ON ( V.VocacionesPlanesTrabajoDocenteId = AED.VocacionesId )
					WHERE
						AED.DocenteId = $idDocente
					AND AED.CodigoPeriodo = $periodo
					AND AED.CodigoCarrera = $id_Programa
					AND AED.CodigoEstado = 100
					AND AED.ComentarioDecanos IS NOT NULL
					ORDER BY
						AED.CodigoCarrera";	
	
	//echo "<pre>";print_r($sqlListaAE);
	
	$txtAEvaluaciones = $db->Execute( $sqlListaAE );
	
	//$nombreVocaciones = $txtAEvaluaciones->fields["Nombre"];
	
	foreach( $txtAEvaluaciones as $txtAEvaluacion ){ ?>
	
	<fieldset>
		
		<legend style="color: #5169B1; font-size: 15pt;"><?php echo $txtAEvaluacion["Nombre"]; ?></legend>
		<tr>
			<td>
				<table width="50%" border="0" style="margin-left: 20px; font-family: 'Century Gothic', CenturyGothic, AppleGothic, sans-serif;">
					<tr>
						<td><span style="font-size: 12pt; font-weight: bold;">Porcentaje Cumplimiento Decano: <?php echo $txtAEvaluacion["PorcentajeCumplimientoDecanos"]."%"; ?>.</span></td>
					</tr>
					<tr>
						<td><textarea rows="7" cols="70" readonly="readonly"><?php echo $txtAEvaluacion["ComentarioDecanos"]; ?></textarea></td>
					</tr>	
				</table>
			</td>
		</tr>
	</fieldset>	
		
	<?php } 
	
	
	break;
	
	case 'actualizarAutoEvaluacion':
	
	$id_Programa = $_GET["id_Programa"];
	
	$idDocente = $_GET["id_Docente"];
	
	$periodo = $_GET["Periodo"];
	
	$idVocaciones = $_GET["idVocaciones"];
	$id_Vocaciones = explode("|", $idVocaciones);
	$id_Vocaciones = array_merge(array_unique( $id_Vocaciones ));
	$id_Vocaciones = orderMultiDimensionalArray($id_Vocaciones);
	
	foreach( $id_Vocaciones as $id_Vocacion ){
	
	$actualizarAutoEvaluaciones = "UPDATE AutoevaluacionDocentes SET CodigoEstado = 200 WHERE DocenteId = $idDocente AND CodigoPeriodo = $periodo AND CodigoCarrera = $id_Programa AND VocacionesId = $id_Vocacion";
	
	$actualizaAEva = $db->Execute( $actualizarAutoEvaluaciones );
	}
	
	break;
	

}
 
 
?>