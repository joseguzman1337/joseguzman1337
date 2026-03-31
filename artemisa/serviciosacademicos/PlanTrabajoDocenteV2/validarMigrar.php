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
 
 $codigoPeriodo = $_POST["codigoPeriodo"];
 $codigoPeriodoAntiguo = $_POST["codigoPeriodoAntiguo"];
 $idDocente = $_POST["id_Docente"]; 
 
 
 $sqlExisteAntiguo = "SELECT
									COUNT(PlanTrabajoDocenteEnsenanzaId) AS existeAntiguo
								FROM
									PlanesTrabajoDocenteEnsenanza
								WHERE
									codigoperiodo = $codigoPeriodoAntiguo
								AND iddocente = $idDocente
								AND codigoestado = 100";
								
	
								
	$existeAntiguo = $db->Execute( $sqlExisteAntiguo );
	$existeAntiguo = $existeAntiguo->fields["existeAntiguo"];

	
	$sqlExisteAntiguoOtros = "SELECT
								COUNT(PlanTrabajoDocenteOtrosId) AS existeAntiguoOtro
							FROM
								PlanesTrabajoDocenteOtros
							WHERE
								codigoperiodo = $codigoPeriodoAntiguo
							AND iddocente = $idDocente
							AND codigoestado = 100";
								
	$existeAntiguoOtros = $db->Execute( $sqlExisteAntiguoOtros );
	$existeAntiguoOtros = $existeAntiguoOtros->fields["existeAntiguoOtro"];
 	
 
 
 
 
 $sqlExisteMigracion = "SELECT
									COUNT(PlanTrabajoDocenteEnsenanzaId) AS existe
								FROM
									PlanesTrabajoDocenteEnsenanza
								WHERE
									codigoperiodo = $codigoPeriodo
								AND iddocente = $idDocente
								AND codigoestado = 100";
	$existeMigracion = $db->Execute( $sqlExisteMigracion );
	$existeMigracion = $existeMigracion->fields["existe"];
	
	
						
	$sqlExisteMigracionOtros = "SELECT
								COUNT(PlanTrabajoDocenteOtrosId) AS existeOtros
							FROM
								PlanesTrabajoDocenteOtros
							WHERE
								codigoperiodo = $codigoPeriodo
							AND iddocente = $idDocente
							AND codigoestado = 100";
	
	
	$existeMigracionOtros = $db->Execute( $sqlExisteMigracionOtros );
	$existeMigracionOtros = $existeMigracionOtros->fields["existeOtros"];
	//echo $existeMigracionOtros." ".$existeMigracion;
 
	if( $existeAntiguo != 0 || $existeAntiguoOtros != 0 ){ 
	 	if( $existeMigracion == 0 && $existeMigracionOtros == 0 ){
	 		echo "0";
	 	}else{
	 		echo "1";
	 	}
	}else{
		echo "1";
	}
 
 
?>