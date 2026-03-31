<?php
header('Content-Type: text/html; charset=UTF-8');
session_start();

include '../PlanTrabajoDocenteV2/lib/phpMail/class.phpmailer.php';
include '../PlanTrabajoDocenteV2/lib/phpMail/class.smtp.php';
include '../PlanTrabajoDocenteV2/lib/OficioUB.php';
include '../PlanTrabajoDocenteV2/lib/ControlEduOrdenCorreo.php';

//var_dump($db);

if($db==null){
	include_once ('../EspacioFisico/templates/template.php');
	$db = getBD(); 
}

if(isset($_POST["tipoOperacionCorreo"])){
	
    $codigoestudiante = $_POST['codigoestudiante'];
    
	   $sqlEnviaCorreoPortafolio = "SELECT
                                    	EG.emailestudiantegeneral,
                                    	EG.email2estudiantegeneral,
                                    	CONCAT(EG.nombresestudiantegeneral,' ',EG.apellidosestudiantegeneral) AS fulname,
                                        o.numeroordenpago
                                    FROM
                                    	estudiante E
                                    INNER JOIN estudiantegeneral EG ON E.idestudiantegeneral = EG.idestudiantegeneral
                                    INNER JOIN ordenpago o ON o.codigoestudiante=E.codigoestudiante
                                    WHERE
                                    	E.codigoestudiante = '".$codigoestudiante."'
                                    AND
                                    o.codigoestadoordenpago='10'";
	
	$correos = $db->Execute($sqlEnviaCorreoPortafolio);
	
	/*$contar = $correos->_numOfRows;
	$i = 1;*/
	//echo "<p>Se ha enviado un correo a los siguientes destinatarios:</p>";
	
	foreach( $correos as $correoEnviar ){
	
	$correo1 = $correoEnviar["emailestudiantegeneral"];
	$correo2 = $correoEnviar["email2estudiantegeneral"];
    $nombreEstudiante =  $correoEnviar["fulname"];
    $numeroOrden =  $correoEnviar["numeroordenpago"];      
	if (!(empty($correo1))){
			
	
    	$controlClienteCorreo = new ControlEduOrdenCorreo();
    	$enviarCorreo = $controlClienteCorreo->enviarCorreoEducaOrdenPago($correo1, $correo2,$nombreEstudiante,$numeroOrden);
    	
	/**/
    	}
	 
	}
    if(empty($correo1)){
		if(empty($correo2)){
		$info['msj'] = "No fue posible el envio del E-mail de confirmación favor actualize sus datos personales.";
        // echo '<pre>';print_r($info);
        echo json_encode($info);
        exit;
		}
	}else{    
		$info['msj'] = "Se le ha enviado un E-mail a sus correos personales.";
        // echo '<pre>';print_r($info);
        echo json_encode($info);
        exit;
	}

}
?>