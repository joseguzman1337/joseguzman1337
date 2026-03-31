<?php

/*include_once('../../utilidades/ValidarSesion.php'); 
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION);*/


header ('Content-type: text/html; charset=utf-8');
header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

session_start();

include "../funciones.php";

include '../lib/phpMail/class.phpmailer.php';
include '../lib/phpMail/class.smtp.php';
 //include 'lib/OficioUB.php';

include '../lib/ControlClienteCorreo.php';

//var_dump($db);
if($db==null){
	include_once ('../../EspacioFisico/templates/template.php');
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
 
 $id_Docente = $_POST["txtIdDocente"];
 
 $txtIdAutoevaluacion = $_POST["txtIdAutoevaluacion"];
 
 $txtComentarioAE = $_POST["txtComentarioAE"];
 
 $cmbComentarioAE = $_POST["cmbComentarioAE"];
 
 $codigoPeriodo = $_POST["codigoPeriodo"];
 
 if( $txtComentarioAE != ""){
 
 $actualizarComentarioAE = "UPDATE AutoevaluacionDocentes 
 								SET PorcentajeCumplimientoDecanos = $cmbComentarioAE, ComentarioDecanos = '$txtComentarioAE' 
 								WHERE AutoevaluacionDocentesId = $txtIdAutoevaluacion";
 
 
 $actualizaAutoEvaluacion = $db->Execute($actualizarComentarioAE);
 
 $sqlCorreo = "SELECT CONCAT( D.nombredocente, ' ', D.apellidodocente ) AS Nombre , D.emaildocente,
								U.usuario 
								FROM docente D
								INNER JOIN usuario U ON( U.numerodocumento = D.numerodocumento)
								INNER JOIN tipousuario TU ON(TU.codigotipousuario = U.codigotipousuario)
								WHERE iddocente = ".$id_Docente."
								AND TU.codigotipousuario LIKE '5%'";
				
	
	$Docente = $db->Execute($sqlCorreo);
	
	$emailDocente = $Docente->fields['emaildocente'];
	$nombreDocente = $Docente->fields['Nombre'];
	
	
	$usuario = $Docente->fields['usuario'];
	
	$completaEmail = "@unbosque.edu.co";
	
	$emailUsuario = $usuario.$completaEmail;
 
	 if( $actualizaAutoEvaluacion === false ){
	 	echo "No se pudo ingresar el comentario de Autoevaluación";
	 }else{
	 	echo "Su comentario de Autoevaluación fue agregado correctamente";
		
			if( $emailDocente != "" ){
						
			$controlClienteCorreo = new ControlClienteCorreo();
			$enviarCorreo = $controlClienteCorreo->enviarAutoevaluacion($emailDocente, $emailUsuario, $nombreDocente, $id_Docente, $codigoPeriodo);
		
			}else{
		
			$controlClienteCorreo = new ControlClienteCorreo();
			$enviarCorreo = $controlClienteCorreo->enviarAutoevaluacionUsuario($emailUsuario, $nombreDocente, $id_Docente, $codigoPeriodo);
			
			}
		}
 	}else{
 	echo "Por favor ingrese un comentario de Autoevaluación";
 	}
  
?>