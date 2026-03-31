<?php 
/*error_reporting(E_ALL);
ini_set("display_errors", 1);*/
session_start();
    require_once("../templates/template.php");
	require_once('../../../consulta/facultades/creacionestudiante/phpmailer/class.phpmailer.php');
    $db = getBD();
$diaAyer = date('Y-m-d',(strtotime ('-1 day' , strtotime (date('Y-m-d')) ) ));

$queryIngles = 'SELECT
						pr.*, IF(u.usuario IS NULL, eg.emailestudiantegeneral, CONCAT(u.usuario,"@unbosque.edu.co")) as email, eg.numerodocumento,
						u.usuario, CONCAT(eg.nombresestudiantegeneral, " ",eg.apellidosestudiantegeneral) as nombre
					FROM
						prematricula pr
					INNER JOIN detalleprematricula dpr ON dpr.idprematricula = pr.idprematricula
					INNER JOIN estudiante e ON e.codigoestudiante = pr.codigoestudiante 
					INNER JOIN estudiantegeneral eg ON eg.idestudiantegeneral=e.idestudiantegeneral 
					LEFT JOIN usuario u on u.numerodocumento=eg.numerodocumento 
					WHERE
							pr.fechaprematricula = "'.$diaAyer.'"
							AND (
								dpr.codigomateria IN (16716, 16717)
								OR dpr.codigomateriaelectiva IN (16716, 16717)
							)
				UNION 
				SELECT
						pr.*, IF(u.usuario IS NULL, eg.emailestudiantegeneral, CONCAT(u.usuario,"@unbosque.edu.co")) as email, eg.numerodocumento,
						u.usuario, CONCAT(eg.nombresestudiantegeneral, " ",eg.apellidosestudiantegeneral) as nombre
					FROM
						prematricula pr
					INNER JOIN logdetalleprematricula dpr ON dpr.idprematricula = pr.idprematricula
					INNER JOIN estudiante e ON e.codigoestudiante = pr.codigoestudiante 
					INNER JOIN estudiantegeneral eg ON eg.idestudiantegeneral=e.idestudiantegeneral 
					LEFT JOIN usuario u ON u.numerodocumento=eg.numerodocumento 
				WHERE dpr.fechalogfechadetalleprematricula>="'.$diaAyer.'"
				AND (dpr.codigomateria IN (16716, 16717) OR dpr.codigomateriaelectiva IN (16716, 16717))
				GROUP BY pr.codigoestudiante '; 
				//echo $queryIngles; die;
$prematriculadosIngles = $db->GetAll($queryIngles);		

foreach($prematriculadosIngles as $prematriculado){

			$mail  = new PHPMailer();	
				$body = '<page style="margin: 0; padding: 0; font-family: Verdana, Arial; font-size: 13px;">
							<p>Apreciado estudiante,</p>
								<p>Lea detenidamente <strong>todo</strong> el contenido de este mensaje y  NO responda a este correo.<br/><br/>
								Por favor, tenga en cuenta la siguiente información adjunta relacionada con la Electiva de inglés virtual.</p>
								<p><br/><br/>Cordial Saludo,<br/><br/>
								Centro de Lenguas - Universidad El Bosque</p>
								</page>';
					$mail->SetFrom('centrodelenguas@unbosque.edu.co', 'Universidad El Bosque');

					$mail->AddReplyTo("centrodelenguas@unbosque.edu.co","Universidad El Bosque");

					$mail->Subject    = "Instructivo Electiva Ingles Virtual - Universidad El Bosque";

					$mail->MsgHTML($body);
					
					$address = $prematriculado['email'];
					//$address = "castroluisd@unbosque.edu.co";   //correo de Prueba
					$mail->AddAddress($address, $prematriculado['nombre']);
					
                    /*
                     * @modified Dario Gualteros <castroluisd@unbosque.edu.co> 
                     * Por solicitud del centro de lenguas se incluye un nuevo archivo SISTEMA_EVALUCION.pdf con el fin que le llegue al correo 
                     * Tambien solicita modificación de los archivos INSTRUCTIVO_INGLES.pdf y PRUEBA_DE_CLASIFICACION.pdf
                     * cuando inscriba las electivas de Ingles con codigos de materias 16716, 16717.
                     * @since  November 21, 2016
                    */

                   	$mail->AddAttachment("INSTRUCTIVO_INGLES.pdf");   
					$mail->AddAttachment("PRUEBA_DE_CLASIFICACION.pdf");      // attachment
                    $mail->AddAttachment("SISTEMA_EVALUCION.pdf");            // nuevo archivo 
    
                    /* END */
					if(!$mail->Send()) {
					  echo "Mailer Error: " . $mail->ErrorInfo;
					}
}	

?>