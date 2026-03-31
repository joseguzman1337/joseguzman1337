<?php
	require_once("../../../funciones/sala_genericas/FuncionesCadena.php");
	require_once("../../../funciones/funcionpassword.php");
	require_once("../../../funciones/clases/phpmailer/class.phpmailer.php");
	require_once("../../../funciones/clases/autenticacion/claseldap.php");
	require_once("../../../Connections/conexionldap.php");
	$fechahoy=date("Y-m-d H:i:s");
	ini_set('max_execution_time','6000');

function GeneraClaveUsuarioPadre($idestudiantegeneral,$documento, $apellidosusuariopadre,$nombresusuariopadre,$emailusuariopadre,$db)
{
    global $db;
    $conexionldap=new claseldap(SERVIDORLDAP,CLAVELDAP,PUERTOLDAP,CADENAADMINLDAP,"",RAIZDIRECTORIO);
    $conexionldap->ConexionAdmin();

    generarnombreusuario(quitartilde($nombresusuariopadre),quitartilde($apellidosusuariopadre), $conexionldap, $nombresusuariopadre, $apellidosusuariopadre, $idestudiantegeneral,$documento,$emailusuariopadre);
    /*
     * Esto se debe reactivar cuando lo llenen las facultades
     *
    $query_datopadre ="SELECT * FROM usuario u, usuariopadre up where u.numerodocumento='$documento' and u.usuario=up.usuario and up.idestudiantegeneral='$idestudiantegeneral'";
    $datopadre= $db->Execute($query_datopadre);
    $totalRows_datopadre= $datopadre->RecordCount();
    $row_datopadre= $datopadre->FetchRow();

    if($totalRows_datopadre==0){
    
    generarnombreusuario(quitartilde($nombresusuariopadre),quitartilde($apellidosusuariopadre), $conexionldap, $nombresusuariopadre, $apellidosusuariopadre, $idestudiantegeneral,$documento,$emailusuariopadre);
    }*/
}//function GeneraClaveUsuarioPadre

function generarnombreusuario($nombrepadre,$apellidopadre, $conexionldap, $nombresusuariopadre, $apellidosusuariopadre,$idestudiantegeneral,$documento,$emailusuariopadre)
{
	$nombrepadre=quitartilde($nombrepadre);
	$apellidopadre=quitartilde($apellidopadre);
	$cuentapalabrasapellidos=cuentapalabras(trim($apellidopadre));
	$apellido1=trim(sacarpalabras(trim($apellidopadre),0,$cuentapalabrasapellidos-2));
	$apellido2=trim(sacarpalabras(trim($apellidopadre),$cuentapalabrasapellidos-1,$cuentapalabrasapellidos));
	$cuentapalabrasapellido1=cuentapalabras(trim($apellido1));
	if($cuentapalabrasapellido1>1)
	$apellido1=sacarpalabras(trim($apellido1),$cuentapalabrasapellido1-1,$cuentapalabrasapellido1);
	$nombre1=trim(sacarpalabras($nombrepadre,0,0));
	$nombre2=trim(sacarpalabras($nombrepadre,1));
	//generacion de clave
	$clave=generar_pass(8);
	//$clave=$documento;
	$cuentacorreocreada=false;
	$i=0;
	while($cuentacorreocreada==false){

	$i++;
		switch($i)
		{
			case 1:
			$nuevousuario=strtolower($nombre1[0].$apellido1);
			$cuentacorreocreada=crearcorreo($nuevousuario,$clave,$conexionldap, $nombresusuariopadre, $apellidosusuariopadre, $idestudiantegeneral,$documento,$emailusuariopadre);
			break;
			case 2:
			$nuevousuario=strtolower($nombre1[0].$apellido1.$apellido2[0]);
			$cuentacorreocreada=crearcorreo($nuevousuario,$clave,$conexionldap, $nombresusuariopadre, $apellidosusuariopadre, $idestudiantegeneral,$documento,$emailusuariopadre);
			break;
			case 3:
			$nuevousuario=strtolower($nombre1[0].$nombre2[0].$apellido1);
			$cuentacorreocreada=crearcorreo($nuevousuario,$clave,$conexionldap, $nombresusuariopadre, $apellidosusuariopadre, $idestudiantegeneral,$documento,$emailusuariopadre);
			break;
			case 4:
			$nuevousuario=strtolower($nombre1[0].$nombre2[0].$apellido1.$apellido2[0]);
			$cuentacorreocreada=crearcorreo($nuevousuario,$clave,$conexionldap, $nombresusuariopadre, $apellidosusuariopadre, $idestudiantegeneral,$documento,$emailusuariopadre);
			break;
			case 5:
			$nuevousuario=strtolower($nombre1[0].$apellido1.$apellido2[0].$apellido2[1]);
			$cuentacorreocreada=crearcorreo($nuevousuario,$clave,$conexionldap, $nombresusuariopadre, $apellidosusuariopadre, $idestudiantegeneral,$documento,$emailusuariopadre);
			break;
			case 6:
			$nuevousuario=strtolower($nombre1[0].$nombre2[0].$nombre2[1].$apellido1);
			$cuentacorreocreada=crearcorreo($nuevousuario,$clave,$conexionldap, $nombresusuariopadre, $apellidosusuariopadre, $idestudiantegeneral,$documento,$emailusuariopadre);
			break;
			case 7:
			$nuevousuario=strtolower($nombre1[0].$nombre2[0].$nombre2[1].$apellido1.$apellido2[0]);
			$cuentacorreocreada=crearcorreo($nuevousuario,$clave,$conexionldap, $nombresusuariopadre, $apellidosusuariopadre, $idestudiantegeneral,$documento,$emailusuariopadre);
			break;
			case 8:
			$nuevousuario=strtolower($nombre1[0].$nombre2[0].$nombre2[1].$apellido1.$apellido2[0].$apellido2[1]);
			$cuentacorreocreada=crearcorreo($nuevousuario,$clave,$conexionldap, $nombresusuariopadre, $apellidosusuariopadre, $idestudiantegeneral,$documento,$emailusuariopadre);
			break;
			case 9:
			$nuevousuario=strtolower($nombre1[0].$apellido1.$apellido2[0].$apellido2[1].$apellido2[2]);
			$cuentacorreocreada=crearcorreo($nuevousuario,$clave,$conexionldap, $nombresusuariopadre, $apellidosusuariopadre, $idestudiantegeneral,$documento,$emailusuariopadre);
			break;
			case 10:
			$nuevousuario=strtolower($nombre1[0].$nombre2[0].$nombre2[1].$nombre2[2].$apellido1);
			$cuentacorreocreada=crearcorreo($nuevousuario,$clave,$conexionldap, $nombresusuariopadre, $apellidosusuariopadre, $idestudiantegeneral,$documento,$emailusuariopadre);
			break;
			case 11:
			$nuevousuario=strtolower($nombre1[0].$nombre2[0].$nombre2[1].$nombre2[2].$apellido1.$apellido2[0]);
			$cuentacorreocreada=crearcorreo($nuevousuario,$clave,$conexionldap, $nombresusuariopadre, $apellidosusuariopadre, $idestudiantegeneral,$documento,$emailusuariopadre);
			break;
			default:
				if($nuevousuario=strtolower(nombredefecto($nombre1,$nombre2,$apellido1,$apellido2,($i-10)))){
					$cuentacorreocreada=crearcorreo($nuevousuario,$clave, $conexionldap, $nombresusuariopadre, $apellidosusuariopadre, $idestudiantegeneral,$documento,$emailusuariopadre);
				}
				else{
					$mensaje .= "-Todas Las Combinaciones Encontradas-Nombre de Usuario No Se Genero-";
					$cuentacorreocreada=true;						
				}
			break;

		}
		//echo "$i)$nuevousuario<br>";
	}
}//function generarnombreusuario

function crearcorreo($nuevousuario,$clave, $conexionldap, $nombresusuariopadre, $apellidosusuariopadre, $idestudiantegeneral,$documento,$emailusuariopadre)
{	
	global $db;              
	$query_nombreusuario ="SELECT * FROM usuario u where u.usuario='$nuevousuario'";
	$nombreusuario= $db->Execute($query_nombreusuario);
	$totalRows_nombreusuario= $nombreusuario->RecordCount();
	$row_nombreusuario= $nombreusuario->FetchRow();
        
	$ldapusuarios=$conexionldap->BusquedaUsuarios("uid=".$nuevousuario);
	if($totalRows_nombreusuario!=0 || @$ldapusuarios["count"]>0)
	{
		$mensaje .= "NOMBRE DE USUARIO ENCONTRADO".$nuevousuario."<br>";
		return false;
	}
	else{                
		$nuevousuario=trim($nuevousuario);		
		insertarnuevousuario(trim($nuevousuario),$clave,$conexionldap, $nombresusuariopadre, $apellidosusuariopadre, $idestudiantegeneral,$documento,$emailusuariopadre);     
 	}
	return true;
}//function crearcorreo

function nombredefecto($nombre1,$nombre2,$apellido1,$apellido2,$semilla)
{
	$largonombre=strlen($nombre1.$nombre2.$apellido1.$apellido2);
	$largonombre1=strlen($nombre1);
	$largonombre2=strlen($nombre2);
	$largoapellido2=strlen($apellido2);
	$campo1="";$campo2="";$campo3="";
	for($i=0;$i<($semilla);$i++)
	$campo1.=$nombre1[$i];
	for($i=0;$i<($semilla-$largonombre1);$i++)
	$campo2.=$nombre2[$i];
	for($i=0;$i<($semilla-($largonombre1+$largonombre2));$i++)
	$campo4.=$apellido2[$i];
	$largogenerado=strlen($campo1.$campo2.$apellido1.$campo4);
	if($largonombre<=$largogenerado)
	return false;
	else
	return $campo1.$campo2.$apellido1.$campo4;
}//function nombredefecto

function insertarnuevousuario($usuario,$clave,$conexionldap, $nombresusuariopadre, $apellidosusuariopadre, $idestudiantegeneral,$documento,$emailusuariopadre)
{
        global $db;
	
		$query_datosest ="SELECT e.codigoestudiante, eg.numerodocumento FROM estudiante e, estudiantegeneral eg where eg.idestudiantegeneral='$idestudiantegeneral' and  e.idestudiantegeneral = eg.idestudiantegeneral";
		$datosest= $db->Execute($query_datosest);
		$totalRows_datosest= $datosest->RecordCount();
		$row_datosest= $datosest->FetchRow();
		$codigoestudiante=$row_datosest['codigoestudiante'];
		$documentoestudiante=$row_datosest['numerodocumento'];

		$fechahoy=date("Y-m-d H:i:s");
		$dnpadre="ou=Padres,".RAIZDIRECTORIO;
		$conexionldap->EntradaPadre($usuario,$clave,$emailusuariopadre,$dnpadre, $nombresusuariopadre, $apellidosusuariopadre);

		/*
		*Ivan Quintero <quinteroivan@unbosque.edu.co>
		* Se modifica la variable tipodocumento 1  a 01 ya que presenta errores en el momento del registro
		* Marzo 24, 2017
		*/

		$query_insertausuario="insert into usuario (idusuario, usuario, numerodocumento, tipodocumento, apellidos, nombres, codigousuario,
		codigorol, fechainiciousuario, fechavencimientousuario, fecharegistrousuario, codigotipousuario, idusuariopadre, ipaccesousuario, codigoestadousuario)
		values( 0, '$usuario', '$documentoestudiante','01','$apellidosusuariopadre', '$nombresusuariopadre', '$documento', '1', '$fechahoy', '2099-12-31', '$fechahoy', '900','0', '',100)";
		$insertausuario=$db->Execute($query_insertausuario) or die(mysql_error());
		$idusuarioinsert= $db->Insert_ID();

		/*
		*END
		*/	
	
		/*
		* Ivan Quintero <quinteroivan@unbosque.edu.co>
		* Se agrega los dos insrte de la tabla usuariotipo y usuariorol que pertenecen al nuevo modelo de roles para docentes
		* Marzo 6, 2017
		*/

		//Consulta si el usuario existe en la tabla usuariotipo
		$sqlBuscarUsuariotipo = "SELECT UsuarioTipoId, CodigoEstado FROM UsuarioTipo WHERE UsuarioId = '".$idusuarioinsert."'";
		$Usuariotipo= $db->Execute($sqlBuscarUsuariotipo);			
		$ResultadoUsuario= $Usuariotipo->FetchRow();
	
		//si no existe ingresa para crear el usuario
		if(empty($ResultadoUsuario['UsuarioTipoId']))
		{
			//crea el usuario en la tabla UsuarioTipo
			$sql_usuariotipo = "insert into UsuarioTipo (CodigoTipoUsuario, UsuarioId, CodigoEstado) values ('900', '".$idusuarioinsert."', '100')";
			$db->Execute($sql_usuariotipo);

			//consulta el id del usuario en la tabla UsuarioTipo
			$sqlUsuariotipo = "SELECT UsuarioTipoId from UsuarioTipo where UsuarioId= '".$idusuarioinsert."'";
			$resultadoUsuariotipo= $db->Execute($sqlUsuariotipo);			
			$row_usuariotipo= $resultadoUsuariotipo->FetchRow();

			//inserta el usurio en la tabla usuariorol
			$sql_usuariorol = "insert into usuariorol (idrol, codigoestado, idusuariotipo) values('1', '100', '".$row_usuariotipo['UsuarioTipoId']."')";
			$insertausuariorol=$db->Execute($sql_usuariorol);
		}else
		{
			//si el usuario ya existe en la tabla usuariotipo verifica que este el estado y si esta en estado 200 inactivo ingresa para activarlo
			if($ResultadoUsuario['CodigoEstado'] == '200')
			{
				//actualiza el estado del usuario 
				$sqlupdate = "update UsuarioTipo set CodigoEstado ='100' where UsuarioId = '".$idusuarioinsert."' and CodigoEstado= 200";
				$db->Execute($sqlupdate);

				//consulta si existe el usuario en la tabla usuario rol
				$sqlBuscarusuariorol ="SELECT idrol, codigoestado, idusuariotipo FROM usuariorol WHERE idusuariotipo = '".$ResultadoUsuario['UsuarioTipoId']."'";
				$resultadoUsuariorol= $db->Execute($sqlBuscarusuariorol);			
				$row_usuariorol= $resultadoUsuariorol->FetchRow();

				//compara que el idrol del usuario no exista
				if(empty($row_usuariorol['idrol']))
				{
					//Se inserta en la tabla usuario rol el usuario
					$sql_usuariorolinsert = "insert into usuariorol (idrol, codigoestado, idusuariotipo) values('1', '100', '".$row_usuariotipo['UsuarioTipoId']."')";
					$db->Execute($sql_usuariorolinsert);						
				}else
				{
					//comaara que el codigo esstado del usuariorol esta inactivo
					if($row_usuariorol['codigoestado']== '200')
					{
						//se actualiza el estado del usuario en la tabla usuariorol
						$sql_usuariorolupdate = "update usuariorol set codigoestado= '100' where idusuariotipo = '".$row_usuariotipo['UsuarioTipoId']."' and codigoestado= 200";
						$db->Execute($sql_usuariorolupdate);
					}//if
				}//else
			}//if
		}//else	
			
		/*
		* END
		*/
		 $query_insertausuariopapa="insert into usuariopadre 
		(idusuariopadre, idestudiantegeneral, usuario, apellidosusuariopadre, nombresusuariopadre,
		documentousuariopadre, emailusuariopadre, codigoestado)
		values( 0,'$idestudiantegeneral', '$usuario', '$apellidosusuariopadre', '$nombresusuariopadre',
		'$documento', '$emailusuariopadre',100)";
		$insertausuariopapa=$db->Execute($query_insertausuariopapa) or die(mysql_error());

		$observacionlog="CREADO EXITOSAMENTE ".$emailusuariopadre.", ".$usuario."\n".$clave;
		$query_insertalog="insert into logcreacionusuario
		(idlogcreacionusuario, idusuario, tmpclavelogcreacionusuario,
		observacionlogcreacionusuario, fechalogcreacionusuario, numerodocumentocreacionusuario, codigoestado)
		values( 0, '$idusuarioinsert','$clave','$observacionlog', '$fechahoy', '$documento',100)";
		$insertalog=$db->Execute($query_insertalog) or die(mysql_error());
			
		/*
		* Enviar correo
		*/
		$nombrepadre=strtoupper($nombresusuariopadre)." ".strtoupper($apellidosusuariopadre);
		$mail = new PHPMailer();
		$mail->From = "UNIVERSIDAD EL BOSQUE";
		$mail->FromName = "UNBOSQUE UNIVERSIDAD EL BOSQUE";
		$mail->ContentType = "text/html";
		$mail->Subject = "USUARIO CUENTA INSTITUCIONAL SISTEMA ACADEMICO SALA";
		$mail->AddAddress($emailusuariopadre,$nombrepadre);
		$mensaje="Apreciado padre de familia.<br><br>"."<b>Reciba un cordial saludo en nombre de la Universidad El Bosque.</b><BR><BR>".
		"En nuestro compromiso de apoyar a nuestros estudiantes hemos desarrollado acciones encaminadas a que ustedes como padres de familia puedan tener una mayor participación en el proceso de formación de sus hijos.".
		'<br><br>De acuerdo a lo conversado con ustedes durante la inducción y de la autorización brindada por sus hijos para la consulta de su progreso académico, a continuación encontrarán el usuario y clave asignados para el ingreso al sistema de información académica en línea "SALA", en el cual podrán consultar el avance académico de su hijo.'.
		"<br><br>Para poder ingresar al sistema haga <a href='https://artemisa.unbosque.edu.co/serviciosacademicos/consulta/facultades/consultafacultadesv2.htm'>clic aquí</a>.<br><br>".
		"<b>usuario:\t".$usuario."</b><br><b>clave:\t".$clave."</b>".
		"<br><br>Adjunto encontrarán el Manual de Usuario que guiará su acceso al portal SALA y el Manual de Cambio de Clave en caso de ser requerido.".
		"<br><br>Si presentan algún tipo de inconveniente a nivel tecnológico y requieren apoyo para el ingreso al sistema por favor contactarse con la Mesa de Servicio al siguiente correo: mesadeservicio@unbosque.edu.co, para cualquier inquietud a nivel académico podrán comunicarse directamente con el programa académico correspondiente.".
		"<br><br><br>Atentamente,<br><b>UNIVERSIDAD EL BOSQUE</b>";
		$mail->Body = $mensaje;
		$mail->AddAttachment("Manual_Padres_SALA.pdf", "Manual_Padres_SALA.pdf");
		$mail->AddAttachment("Manual_Padres_SALA_Modificar_Clave.pdf", "Manual_Padres_SALA_Modificar_Clave.pdf");
		//$mail->Send();

		if(!$mail->Send())
		{
			echo "El mensaje no pudo ser enviado";
			echo "Mailer Error: " . $mail->ErrorInfo;
		//exit();
		}
		else
		{
			echo "Mensaje Enviado";
		}
		$conexionldap->Cerrar();
		//regresar a la pagina despues de mensaje de exito
		echo "<script language='javascript'>alert('Se ha creado  con exito el usuario padre.');
		window.location.href='datospadre.php?codigoestudiante=$codigoestudiante' ; </script>";		
}//function insertarnuevousuario


?>