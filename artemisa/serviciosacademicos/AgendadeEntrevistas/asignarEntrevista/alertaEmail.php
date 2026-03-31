<?php
require('../../Connections/sala2.php');
require('../../funciones/funcionpassword.php');
$rutaado = '../../funciones/adodb/';
require('../../Connections/salaado.php');
require('../funciones/funcionAsignacionEntrevista.php');
/*
 * Caso 95695	
 * @modified Luis Dario Gualteros 
 * <castroluisd@unbosque.edu.co>
 * Se adiciona el correo de atención al usuario para que se le envíe copia de los aspirantes programados a entrevista.
 * @since Noviembre 16, 2017
*/ 
$EmailAtencionUsuario = "socheleydy@unbosque.edu.co@unbosque.edu.co";	
$responsables = emailResponsables( $db );//consulta responsables para envio de correo 
$cantidadEntrevistas = sizeof( $responsables );
$bodyEmail = "";

	if ( $cantidadEntrevistas > 0 ) {

		foreach ( $responsables as $responsable ) {
			
			$bodyEmail="";
			$corroResponsable = $responsable['CorreoResponsable'];
            $corroResponsable.= ";".$EmailAtencionUsuario; 
			$codigoCarrera = $responsable['codigocarrera'];
			$carrerasEmail = envioCarrera( $db , $codigoCarrera );//consulta carreras  del responsable para envio de correo  de entrevistas programadas

			$bodyEmail .= "<table border=1 cellspacing=0 cellpadding=0  align='center'>
							<tr style='background-color:#577CB8;color:white' align='center'>
								<td><strong>Programa</strong></td>
								<td><strong>Documento</strong></td>
								<td><strong>Nombre</strong></td>
								<td><strong>Fecha</strong></td>
								<td><strong>Hora</strong></td>
							<tr>";
			
			foreach ( $carrerasEmail as $carreraEmail ) {	

				$documento = $carreraEmail['numerodocumento'];
				$nombre = $carreraEmail['nombresestudiantegeneral'];
				$apellido =	$carreraEmail['apellidosestudiantegeneral'];
				$fecha = $carreraEmail['FechaEntrevista'];
				$hora =	$carreraEmail['HoraInicio'];
				$carrera = $carreraEmail['nombrecarrera'];
			
				$bodyEmail .="<tr>
								<td>".$carrera."</td>
								<td>".$documento."</td>
								<td>".$nombre." ".$apellido."</td>
								<td>".$fecha."</td>
								<td>".$hora."</td>
							  </tr>";


			}

			$bodyEmail .= "</table>";

			$mail = new PHPMailer;
			$mail->From ="sala@unbosque.edu.co";
			$mail->FromName = "Universidad el Bosque";
			$mail->isHTML(true);
			$mail->Subject = "Entrevistas Programadas";
			$mail->Body = "Cordial saludo,<br><br><br>Nos permitimos adjuntar el listado de personas programadas para entrevistas/pruebas en las fechas y horas señaladas:<br><br><br>".$bodyEmail;
			$mail->AddEmbeddedImage('logonegro.png', 'logo');
			$mail->AddAddress( $corroResponsable );
		

			if( !$mail->Send() ) {
					echo "Mailer Error: " . $mail->ErrorInfo;
				} else {
					echo 'Correo enviado';
			}


		}


	} else {


	}
	 
?>