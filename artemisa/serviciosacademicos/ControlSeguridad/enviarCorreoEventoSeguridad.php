<?php
header('Content-Type: text/html; charset=UTF-8');
session_start();

include '../PlanTrabajoDocenteV2/lib/phpMail/class.phpmailer.php';
include '../PlanTrabajoDocenteV2/lib/phpMail/class.smtp.php';
include '../PlanTrabajoDocenteV2/lib/OficioUB.php';
include '../PlanTrabajoDocenteV2/lib/ControlEnvioCorreoSeguridad.php';

if($db==null){
	
	include_once ('../EspacioFisico/templates/template.php');

	$db = getBD(); 
}

	$sqlEnviaCorreoEventoSeguridad = "SELECT
                                    	IdEventoSeguridad,FechaEventoSeguridad,TipoEvento,TablaModificada,
										EstudianteModificado,RegistroOriginal,RegistroModificado,NotaOriginal,NotaModificada,UsuarioModificador										
                                    FROM
                                    	EventoSeguridad
									WHERE DATE(FechaEventoSeguridad) = DATE(CURDATE())	";
	
	$eventos = $db->getAll($sqlEnviaCorreoEventoSeguridad);
	
	if (!(empty($eventos)))
	{
		$controlClienteCorreo = new ControlCorreoSeguridad();
		$enviarCorreo = $controlClienteCorreo->enviarCorreoEvento($eventos);
		$info['msj'] = "Se le ha enviado un E-mail a sus correos personales.";
		echo json_encode($info);
		exit;
	}else{
		$info['msj'] = "No exiten registros de cambios suficientes para enviar E-mail";	
		echo json_encode($info);
		exit;
	}
	
  

?>