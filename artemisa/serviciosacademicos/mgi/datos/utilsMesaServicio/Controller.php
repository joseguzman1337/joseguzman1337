<?php
	session_start();
	if(empty($_SESSION['MM_Username'])){
		echo "No ha iniciado sesión en el sistema";
		exit();
	}else{
		require_once("../templates/template.php");
		include '../../../PlanTrabajoDocenteV2/lib/phpMail/class.phpmailer.php';
		include '../../../PlanTrabajoDocenteV2/lib/phpMail/class.smtp.php';
		include '../../../PlanTrabajoDocenteV2/lib/OficioUB.php';
		include 'ControlEnvioCorreoPreins.php';
		$db = getBD();
		$main=new Controller();
		$main->main($db);	
	}

class Controller{
	public function main($db){
		switch($_POST['action']){
			case 'consultaEstudiante':
				$this->consultaEstudiante($db);
			break;
			case 'actualizarEstudiante':
				$this->actualizarEstudiante($db);
			break;
			case 'enviarCorreo':
				$this->enviarCorreo();
			break;
		}
		
	}
	public function consultaEstudiante($db){
		$documento = $_POST['documento'];
		if(empty($documento)){
			echo "Debe digitar número de documento";
			die;
		}
		
		$Sql = "SELECT EG.numerodocumento,EG.nombresestudiantegeneral, 
				EG.apellidosestudiantegeneral , EG.emailestudiantegeneral 
				FROM estudiantegeneral EG 
				WHERE EG.numerodocumento = ".$documento."";
		if($data=&$db->GetAll($Sql) === false){
			echo 'Ocurrio un error al consultar la data';
			die;
		}
		$html=null;
		if(!empty($data)){
			
			$html="<table border = '1.5'width='80%'>  
						<th>Documento</th>	
						<th>Nombre Estudiante</th>	
						<th>Apellido Estudiante</th>
						<th>Email</th>
						<th>Clave Temporal</th>";
			foreach($data as $datos){
				$html.= "<tr><td>".$datos['numerodocumento']."
							<input type='hidden' name='documento' id='documento'value='".$datos['numerodocumento']."'/></td>
							<td>".$datos['nombresestudiantegeneral']."</td>
							<td>".$datos['apellidosestudiantegeneral']."</td>
							<td><input type='text' name='email' id='email' size='35' value='".$datos['emailestudiantegeneral']."'/></td>
							<td><input type='text' name='claveTemporal' id='claveTemporal' size='35'/></td>
							</tr>";
			}
			$html .= "</table>";
			echo ($html);
		}
	}
	public function actualizarEstudiante($db){
		$email = $_POST['email'];
		$documento = $_POST['documento'];
		$claveTemporal = $_POST['claveTemporal'];
		$sqlUpdate = "UPDATE estudiantegeneral SET emailestudiantegeneral = '".$email."',
		 fechaactualizaciondatosestudiantegeneral = '" . date("Y-m-d G:i:s", time()) . "'
		 WHERE numerodocumento = '".$documento."'";
		if ($update = $db->Execute($sqlUpdate) === false) {
			echo 'Error al actualizar estudiante';
			exit;
		}
		if(!empty($claveTemporal)){
			/* Consultar que el estudiante este preinscrito */
				$query_preins = "SELECT
								eg.idestudiantegeneral
							FROM
								estudiantegeneral eg								
							WHERE
							 eg.numerodocumento = '".$documento."' ";
								
			if($row_preins=&$db->GetAll($query_preins) === false){
			echo 'Ocurrio un error al consultar la data';
			die;
			}
			/* Consultar que el usuario este creado en usuariopreinscripcion*/
				 $query_consultaUsuarioPre = "SELECT
								idestudiantegeneral,
								idusuariopreinscripcion
							FROM
								usuariopreinscripcion
							WHERE
								idestudiantegeneral = '".$row_preins[0][0]."'";
				
			if($row_consultaUsuarioPre=&$db->GetAll($query_consultaUsuarioPre) === false){
			echo 'Ocurrio un error al consultar la data';
			die;
			}
			
			if(!empty($row_consultaUsuarioPre[0][0])){
				$claveTemporal256 = hash('sha256', $claveTemporal);
				$query_updpreins = "UPDATE usuariopreinscripcion up
				SET usuariopreinscripcion= '".$email."',
					up.claveusuariopreinscripcion = '".$claveTemporal256."',
					up.fechavencimientousuariopresinscripcion = '2099-12-01'
				WHERE
					up.idestudiantegeneral = '".$row_consultaUsuarioPre[0][0]."'
				AND up.idusuariopreinscripcion = '".$row_consultaUsuarioPre[0][1]."'";
				if ($updateCla = $db->Execute($query_updpreins) === false) {
					echo 'Error al actualizar';
					exit;
				}else{
					echo '<script> alert("Se cambio la clave temporal exitosamente") ; </script>'; 
				}
			}else{
				$claveTemporal256 = hash('sha256', $claveTemporal);
					$query_insertPre ="INSERT INTO usuariopreinscripcion (
									idestudiantegeneral,
									usuariopreinscripcion,
									claveusuariopreinscripcion,
									fechavencimientoclaveusuariopresinscripcion,
									fechavencimientousuariopresinscripcion
								)
								VALUES
									(
										".$row_preins[0][0].",
										'".$email."',
										'".$claveTemporal256."',
										'2999-12-31',
										'2999-12-31'
									)";
			
				if ($insertCla = $db->Execute($query_insertPre) === false) {
					echo 'Error al insert';
					exit;
				}else{
					echo '<b>. Se cambio la clave temporal exitosamente</b>';
				}
			}
			
		}
	}
	public function enviarCorreo(){
		$correo = $_POST['correo'];
		$controlClienteCorreo = new ControlEnvioCorreoPreins();
		$enviarCorreo = $controlClienteCorreo->enviarCorreoEvento($correo);
		$info['msj'] = "Se le ha enviado un E-mail a sus correos personales.";
		echo json_encode($info);
		exit;
		
	}
}

?>