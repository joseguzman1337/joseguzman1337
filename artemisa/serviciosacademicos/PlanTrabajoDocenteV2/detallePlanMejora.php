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
	case 'insertarPlanMejora':
		
	$txtPlanMejora = $_POST["planMejora"];
	$txtPlanMejoraConsolidado = $_POST["planMejoraConsolidado"];
	
	$idDocente = $_POST["id_Docente"];
 
 	$periodo = $_POST["Periodo"];
 
 	$txtCarrera = $_POST["txtCarreraPM"];
	
	$txtNumeroDocumento = $_POST["txtNumeroDocumento"];
	 
 	$idVocacion = $_POST["idVocacion"];
 			
	$sqlUsuarioDocente = "SELECT idusuario FROM usuario WHERE numerodocumento = $txtNumeroDocumento LIMIT 1";
	 
	$txtIdUsuario = $db->Execute($sqlUsuarioDocente);
	//$txtIdUsuario = $txtIdUsuario->fields["idusuario"];
	
	if( $txtIdUsuario->fields["idusuario"] != "" ){
		$txtIdUsuario = $txtIdUsuario->fields["idusuario"];
	}else{
		$txtIdUsuario = "4186";
	}
	 
	$sqlInsertPlanMejora = "INSERT INTO PlanMejoraDocentes 
                		(PlanMejoraDocentesId, 
                        DocenteId, 
                        PlanMejoraConsolidado, 
                        PlanMejora, 
                        VocacionesId, 
                        CodigoPeriodo, 
                        CodigoEstado, 
                        CodigoCarrera, 
                        UsuarioCreacion, 
                        UsuarioUltimaModificacion, 
                        FechaCreacion, 
                        FechaUltimaModificacion, 
                        UsuarioId) 
                        VALUES ((SELECT IFNULL(MAX(PM.PlanMejoraDocentesId)+1,1) 
									FROM PlanMejoraDocentes PM), $idDocente, '$txtPlanMejoraConsolidado', '$txtPlanMejora', $idVocacion, '$periodo', default, $txtCarrera, $txtIdUsuario, $txtIdUsuario, NOW(), NOW(), $txtIdUsuario)";
	
	
	//echo $sqlInsertPlanMejora;
	$ingresoPlanMejora = $db->Execute( $sqlInsertPlanMejora );
	
	if($ingresoPlanMejora === false ){
		echo "0";
	}else{
		echo "1";
	}
	break;

}
 
 
?>