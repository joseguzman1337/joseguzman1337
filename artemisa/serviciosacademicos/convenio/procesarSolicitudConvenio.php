<?php
    session_start();
    include_once(realpath(dirname(__FILE__)).'/../utilidades/ValidarSesion.php');
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);

    include_once (realpath(dirname(__FILE__)).'/../EspacioFisico/templates/template.php');
    require_once(realpath(dirname(__FILE__))."/../modelos/convenios/SolicitudConvenios.php");
    require_once("NotificacionConvenio.php");

	$now = date('Y-m-d H-i-s');
	$sql = "SELECT idusuario FROM usuario WHERE usuario = ?";
	$stmt = $db->Prepare($sql);
	$usuario = $db->GetRow($stmt,array($_SESSION['MM_Username']));

    function limpiarCadena($cadena) {
         $cadena = (ereg_replace('[^ A-Za-z0-9_ñÑáéíóúÁÉÍÓÚ\s]', '', $cadena));
         return $cadena;
    }

    function asociarCarreras($db,$carrerasA,$id,$usuario,$now){
    	//inactivo todas las carreras
    	$sql = "UPDATE SolicitudConvenioCarrera SET CodigoEstado='100' WHERE (SolicitudConvenioId=?)";

    	$stmt = $db->Prepare($sql);
    	$db->Execute($stmt,array($id));
    	foreach($carrerasA as $carrera){
    		$sql = "SELECT SolicitudConvenioCarreraID FROM SolicitudConvenioCarrera WHERE SolicitudConvenioId = ? AND codigocarrera = ?";
    		$stmt = $db->Prepare($sql);
    		$fila = $db->GetRow($stmt,array($_POST["SolicitudConvenioId"],$carrera));
    		$carreras = new solicitudConvenioCarrera();
    		if(count($fila)>0){
    			$carreras->load("SolicitudConvenioCarreraID=?", array($fila["SolicitudConvenioCarreraID"]));
    		} else {
    			$carreras->codigocarrera = $carrera;
    			$carreras->solicitudconvenioid  = $id;
    			$carreras->fechacreacion  = $now;
    			$carreras->usuariocreacion  = $usuario;
    		}
    		$carreras->codigoestado  = 100;
    		$carreras->fechamodificacion  = $now;
    		$carreras->usuariomodificacion  = $usuario;
    		$carreras->save();
    	//var_dump($carreras->ErrorMsg()); die;
    	}
    }

if($_POST['Acta'] == 'Acta')
{
    $buscaracta = "select count(NumeroActa) as acta from SolicitudConvenios where NumeroActa = '".$_POST['id']."'";
    $numero = $db->GetRow($buscaracta);
    if($numero['acta'] > 0)
    {
        $val = "existe";
    }
    $a_vectt['val']			=$val;
    echo json_encode($a_vectt);
    exit;
}

if($_POST['lista']== 'Instituciones')
{
    if($_POST['id']=='0')
    {
        echo  "<input type='text' name='nombreconvenio' id='nombreconvenio' size='50%' class='required' onkeypress='return val_texto(event)'/>";
    }
}

if($_POST['lista']=='DatosInstituciones')
{
    $sqldatos= "SELECT RepresentanteLegal, IdentificacionRepresentante, NombreSupervisor, CargoSupervisor, EmailSupervisor, Telefono, Direccion FROM
	InstitucionConvenios WHERE InstitucionConvenioId = '".$_POST['id']."'";
    $datos = $db->GetRow($sqldatos);

    echo json_encode($datos);
    exit;
}

switch ($_POST['paso']) {
	case '1': {
		if($_POST["Action_id"]=="SaveData"){
			$solicitud = new solicitudConvenio();
			//var_dump($especialidad->getAttributeNames());
            $supervisorbosque = limpiarCadena(filter_var($_POST['supervisorbosque'],FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES));
            $txtCargoSU = limpiarCadena(filter_var($_POST['txtCargoSU'],FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES));
            $txtCorreoSU = filter_var($_POST['txtCorreoSU'],FILTER_SANITIZE_EMAIL);
            $txtCelularSU = limpiarCadena(filter_var($_POST['txtCelularSU'],FILTER_SANITIZE_NUMBER_INT));
            $nconsejo = limpiarCadena(filter_var($_POST['nconsejo'],FILTER_SANITIZE_NUMBER_INT));
            $OtrasFacultades = limpiarCadena(filter_var($_POST['OtrasFacultades'],FILTER_SANITIZE_NUMBER_INT));

			$solicitud->responsableconvenio = $supervisorbosque;
			$solicitud->cargoresponsableconvenio  = $txtCargoSU;
			$solicitud->cargoresponsableconvenio  = $txtCargoSU;
			$solicitud->correoresponsableconvenio  = $txtCorreoSU;
			$solicitud->OtrasFacultades = $OtrasFacultades;
			$solicitud->celularresponsableconvenio  = $txtCelularSU;
			$solicitud->numeroacta = $nconsejo;
			$solicitud->codigoestado  = 100;
			$solicitud->fechacreacion  = $now;
			$solicitud->usuariocreacion  = $usuario["idusuario"];
			$solicitud->fechamodificacion  = $now;
			$solicitud->usuariomodificacion  = $usuario["idusuario"];
			$solicitud->pasosolicitud  = 2;
			$solicitud->convenioprocesoid  = 1;
			$solicitud->save();
			//var_dump($solicitud->ErrorMsg()); die;
			$id = $db->Insert_ID();
			$fecha = date('Y-m-d H-i-s');

			$file = $_FILES['archivo']['name'];
            $filetmp = $_FILES['archivo']['tmp_name'];

            if(!empty($file))
            {
    			$finfo = finfo_open(FILEINFO_MIME_TYPE); // return mime type ala mimetype extension
    				$mime = finfo_file($finfo, $_FILES['archivo']['tmp_name']);
    			finfo_close($finfo);
    			if($_FILES['archivo']['type'] == "application/pdf" && $mime=="application/pdf")
    			{
					$file = str_replace(" ", "_", $file);
					//comprobamos si el archivo ha subido
					$nombre = str_replace(".pdf", "", $file);
					$nombre = str_replace(".docx", "", $nombre);
					$nombre = str_replace(".doc", "", $nombre);

					if($_FILES['archivo']['type']== "application/vnd.openxmlformats-officedocument.wordprocessingml.document")
					{
						$formato = "doc";
					}
					if($_FILES['archivo']['type'] == "application/pdf")
					{
						$formato = "pdf";
					}

					if ($file && move_uploaded_file($filetmp,"fileSolicitudConvenio/".$file))
					{
						$sqlselect = "Select SolicitudAnexoId from SolicitudAnexos where SolicitudConvenioId= '".$id."' and TipoAnexoId='8';";
						$buscar = $db->GetRow($sqlselect);
						if($buscar['SolicitudAnexoId'])
						{
							$sqlupdate = "UPDATE SolicitudAnexos SET Url='fileSolicitudConvenio/".trim($file)."', Nombre = '".$nombre."', FechaModificacion='".$fecha."', UsuarioModificacion='".$usuario["idusuario"]."' WHERE (SolicitudAnexoId='".$id."')";
						if($update= $db->execute($sqlupdate)===false){
							$Data['val'] = false;
							$Data['mesj'] = 'Error del sistema';
							exit;
							}
						}
						else
						{
							$sqlinsert = "INSERT INTO SolicitudAnexos (SolicitudConvenioId, Nombre, Url, TipoAnexoId, Formato, FechaCreacion, UsuarioCreacion, FechaModificacion, UsuarioModificacion, CodigoEstado) VALUES ('".$id."', '".$nombre."', 'fileSolicitudConvenio/".trim($file)."', '8', '".$formato."', '".$fecha."', '".$usuario["idusuario"]."', '".$fecha."', '".$usuario["idusuario"]."', '100');";
							if($insert= $db->execute($sqlinsert)===false){
							$Data['val'] = false;
							$Data['mesj'] = 'Error del sistema';
							exit;
							}
						}
					}
                }else
                {
                    ?>
                    <script type="text/javascript">
                    alert("El archivo no tiene un formato permitido.");
                    window.location = './nuevapropuesta.php';
                    </script>
                    <?php
				}//
            }//file empty
                if($id!=0){
                	$result=true;
                	$data = array('success'=> true,'message'=> "La especialidad se ha creado correctamente.");
                	asociarCarreras($db,$_POST["carrera"],$id,$usuario["idusuario"],$now);		//$_POST['SolicitudConvenioId']
                    ?>
                    <script type="text/javascript">
                    	window.location = './nuevapropuesta2.php?id=<?php echo $id; ?>';
                    </script>
                    <?php
                }else
                {
                    ?>
    				<script type="text/javascript">
    					alert("Ocurrio un problema al guardar la solicitud");
    					window.location = './nuevapropuesta.php';
    				</script>
    				<?php
                }

		} else if($_POST["Action_id"]=="UpdateData"){
			$solicitud = new solicitudConvenio();
            $SolicitudConvenioId = limpiarCadena(filter_var($_POST["SolicitudConvenioId"],FILTER_SANITIZE_NUMBER_INT));
            $supervisorbosque = limpiarCadena(filter_var($_POST['supervisorbosque'],FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES));
            $txtCargoSU = limpiarCadena(filter_var($_POST['txtCargoSU'],FILTER_SANITIZE_STRING));
            $txtCorreoSU = filter_var($_POST['txtCorreoSU'],FILTER_SANITIZE_EMAIL);
            $txtCelularSU = limpiarCadena(filter_var($_POST['txtCelularSU'],FILTER_SANITIZE_NUMBER_INT));
            $nconsejo = limpiarCadena(filter_var($_POST['nconsejo'],FILTER_SANITIZE_NUMBER_INT));
            $OtrasFacultades = limpiarCadena(filter_var($_POST['OtrasFacultades'],FILTER_SANITIZE_NUMBER_INT));
            $carrera = $_POST["carrera"];

			$solicitud->load("SolicitudConvenioId=?", array($SolicitudConvenioId));
			$solicitud->responsableconvenio = $supervisorbosque;
			$solicitud->cargoresponsableconvenio  = $txtCargoSU;
			$solicitud->OtrasFacultades = $OtrasFacultades;
			$solicitud->correoresponsableconvenio  = $txtCorreoSU;
			$solicitud->celularresponsableconvenio  = $txtCelularSU;
			$solicitud->numeroacta = $nconsejo;
			$solicitud->fechamodificacion  = $now;
			$solicitud->usuariomodificacion  = $usuario["idusuario"];
			$solicitud->save();
				asociarCarreras($db,$carrera,$SolicitudConvenioId,$usuario["idusuario"],$now);
			$result=true;
			$data = array('success'=> true,'message'=> "La especialidad se ha modificado correctamente.");

            $file = $_FILES['archivo']['name'];
            $filetmp = $_FILES['archivo']['tmp_name'];

            if(!empty($file))
            {
    			$finfo = finfo_open(FILEINFO_MIME_TYPE); // return mime type ala mimetype extension
    				$mime = finfo_file($finfo, $_FILES['archivo']['tmp_name']);
    			finfo_close($finfo);
    			if($_FILES['archivo']['type'] == "application/pdf" && $mime=="application/pdf")
    			{
					$file = str_replace(" ", "_", $file);
					//comprobamos si el archivo ha subido
					$nombre = str_replace(".pdf", "", $file);
					$nombre = str_replace(".docx", "", $nombre);
					$nombre = str_replace(".doc", "", $nombre);

					if($_FILES['archivo']['type']== "application/vnd.openxmlformats-officedocument.wordprocessingml.document")
					{
						$formato = "doc";
					}
					if($_FILES['archivo']['type'] == "application/pdf")
					{
						$formato = "pdf";
					}

					if ($file && move_uploaded_file($filetmp,"fileSolicitudConvenio/".$file))
					{
						$sqlselect = "Select SolicitudAnexoId from SolicitudAnexos where SolicitudConvenioId= '".$SolicitudConvenioId."' and TipoAnexoId='8';";
						$buscar = $db->GetRow($sqlselect);
						if($buscar['SolicitudAnexoId'])
						{
							$sqlupdate = "UPDATE SolicitudAnexos SET Url='fileSolicitudConvenio/".trim($file)."', Nombre = '".$nombre."', FechaModificacion='".$fecha."', UsuarioModificacion='".$usuario["idusuario"]."' WHERE (SolicitudAnexoId='".$SolicitudConvenioId."')";
						if($update= $db->execute($sqlupdate)===false){
							$Data['val'] = false;
							$Data['mesj'] = 'Error del sistema';
							exit;
							}
						}
						else
						{
							$sqlinsert = "INSERT INTO SolicitudAnexos (SolicitudConvenioId, Nombre, Url, TipoAnexoId, Formato, FechaCreacion, UsuarioCreacion, FechaModificacion, UsuarioModificacion, CodigoEstado) VALUES ('".$SolicitudConvenioId."', '".$nombre."', 'fileSolicitudConvenio/".trim($file)."', '8', '".$formato."', '".$fecha."', '".$usuario["idusuario"]."', '".$fecha."', '".$usuario["idusuario"]."', '100');";
							if($insert= $db->execute($sqlinsert)===false){
							$Data['val'] = false;
							$Data['mesj'] = 'Error del sistema';
							exit;
							}
						}
					}
                }else
                {
                    ?>
                    <script type="text/javascript">
                    alert("El archivo no tiene un formato permitido.");
                    window.location = './nuevapropuesta.php';
                    </script>
                    <?php
				}//
            }

			?>
			<script type="text/javascript">
				window.location = './nuevapropuesta2.php?id=<?php echo $SolicitudConvenioId; ?>';
			</script>
			<?php
		} else {
			echo "Ocurrio un problema en la solicitud http";
			exit();
		}
	}break;
	case '2':{
		if($_POST["Action_id"]=="UpdateData"){
			$solicitud = new solicitudConvenio();
            $SolicitudConvenioId = limpiarCadena(filter_var($_POST["SolicitudConvenioId"],FILTER_SANITIZE_NUMBER_INT));
            $representante = limpiarCadena(filter_var($_POST['representante'],FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES));
            $txtNumeroIdentificacion = limpiarCadena(filter_var($_POST["txtNumeroIdentificacion"],FILTER_SANITIZE_NUMBER_INT));
            $txtContactoI = limpiarCadena(filter_var($_POST['txtContactoI'],FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES));
            $txtCargoSI = limpiarCadena(filter_var($_POST['txtCargoSI'],FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES));
            $txtCorreoSI = filter_var($_POST['txtCorreoSI'],FILTER_SANITIZE_EMAIL);
            $txtCelularSI = limpiarCadena(filter_var($_POST["txtCelularSI"],FILTER_SANITIZE_NUMBER_INT));
            $idinstitucion = limpiarCadena(filter_var($_POST["InstitucionConvenioId"],FILTER_SANITIZE_NUMBER_INT));
            $ambito = limpiarCadena(filter_var($_POST["ambito"],FILTER_SANITIZE_NUMBER_INT));
            //$tipoconvenio = limpiarCadena(filter_var($_POST['tipoconvenio'],FILTER_SANITIZE_NUMBER_INT));
            if($_POST["nombreconvenio"])
            {
                $nombreinstitucion = limpiarCadena(filter_var($_POST["nombreconvenio"],FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES));
            }else
            {
                $buscar = "SELECT NombreInstitucion FROM InstitucionConvenios where InstitucionConvenioId = '".$idinstitucion."'";
                $nombre = $db->GetRow($buscar);
                $nombreinstitucion = limpiarCadena(filter_var($nombre['NombreInstitucion'],FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES));
            }
			$solicitud->load("SolicitudConvenioId=?", array($SolicitudConvenioId));
			$solicitud->representanteinstitucion = $representante;
			$solicitud->identificacionrepresentanteinstitucion  = $txtNumeroIdentificacion;
			$solicitud->nombrecontactoinstitucion  = $txtContactoI;
			$solicitud->cargocontactoinstitucion  = $txtCargoSI;
			$solicitud->correocontactoinstitucion = $txtCorreoSI;
			$solicitud->telefonocontactoinstitucion = $txtCelularSI;
			$solicitud->direccioninstitucion = limpiarCadena($_POST['txtDireccion']);
			$solicitud->nombreinstitucion = $nombreinstitucion;
            $solicitud->institucionconvenioid = $idinstitucion;
            //$solicitud->idsiq_tipoconvenio = $tipoconvenio;
            $solicitud->ambito= $ambito;
			$solicitud->pasosolicitud = 3;
			$solicitud->fechamodificacion  = $now;
			$solicitud->usuariomodificacion  = $usuario["idusuario"];
			$solicitud->save();
			$result=true;
			$data = array('success'=> true,'message'=> "La especialidad se ha modificado correctamente.");

			?>
			<script type="text/javascript">
				window.location = './nuevapropuesta3.php?id=<?php echo $SolicitudConvenioId; ?>';
			</script>
			<?php
		} else {
			echo "Ocurrio un problema en la solicitud http";
			exit();
		}
	} break;
	case '3':{
		if($_POST["Action_id"]=="UpdateData"){
			$solicitud = new solicitudConvenio();
            $SolicitudConvenioId = limpiarCadena(filter_var($_POST["SolicitudConvenioId"],FILTER_SANITIZE_NUMBER_INT));
            $txtJustificacionS = limpiarCadena(filter_var($_POST['txtJustificacionS'],FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES));
            $txtJustificacionI = limpiarCadena(filter_var($_POST['txtJustificacionI'],FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES));

			$solicitud->load("SolicitudConvenioId=?", array($SolicitudConvenioId));
			$solicitud->justificacionsuscripcion = $txtJustificacionS;
			$solicitud->justificacionimpacto  = $txtJustificacionI;
			$solicitud->pasosolicitud = 4;
			$solicitud->fechamodificacion  = $now;
			$solicitud->usuariomodificacion  = $usuario["idusuario"];
			$solicitud->save();
			$result=true;
			$data = array('success'=> true,'message'=> "La especialidad se ha modificado correctamente.");

			?>
			<script type="text/javascript">
				window.location = './nuevapropuesta4.php?id=<?php echo $SolicitudConvenioId; ?>';
			</script>
			<?php
		} else {
			echo "Ocurrio un problema en la solicitud http";
			exit();
		}
	} break;
	case '4':{
		if($_POST["Action_id"]=="UpdateData"){
			$solicitud = new solicitudConvenio();
            $SolicitudConvenioId = limpiarCadena(filter_var($_POST["SolicitudConvenioId"],FILTER_SANITIZE_NUMBER_INT));
            $txtObjetivoG = limpiarCadena(filter_var($_POST['txtObjetivoG'],FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES));
            $txtObjetivosE = limpiarCadena(filter_var($_POST['txtObjetivosE'],FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES));
            $txtCompromiso = limpiarCadena(filter_var($_POST['txtCompromiso'],FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES));
            $duracionConvenio = limpiarCadena(filter_var($_POST["duracionConvenio"],FILTER_SANITIZE_NUMBER_INT));
            $txtNombreDocente = limpiarCadena(filter_var($_POST['txtNombreDocente'],FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES));
            $txtActividades = limpiarCadena(filter_var($_POST['txtActividades'],FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES));
            $txtResultados = limpiarCadena(filter_var($_POST['txtResultados'],FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES));

			$solicitud->load("SolicitudConvenioId=?", array($SolicitudConvenioId));
			$solicitud->objetivogeneral = $txtObjetivoG;
			$solicitud->objetivoespecifico  = $txtObjetivosE;
			$solicitud->compromiso  = $txtCompromiso;
			$solicitud->duracionconvenioid  = $duracionConvenio;
			$solicitud->responsableacademico  = $txtNombreDocente;
			$solicitud->actividades  = $txtActividades;
			$solicitud->resultadoesperado  = $txtResultados;
			$solicitud->pasosolicitud = 4;
			$solicitud->fechamodificacion  = $now;
			$solicitud->usuariomodificacion  = $usuario["idusuario"];
			$solicitud->save();
			$result=true;
			$data = array('success'=> true,'message'=> "La especialidad se ha modificado correctamente.");

			?>
			<script type="text/javascript">
				window.location = './nuevapropuesta5.php?id=<?php echo $SolicitudConvenioId; ?>';
			</script>
			<?php
		} else {
			echo "Ocurrio un problema en la solicitud http";
			exit();
		}
	} break;
	case '5':{
		if($_POST["Action_id"]=="UpdateData"){

            $fecha = date('Y-m-d H-i-s');

			$solicitud = new solicitudConvenio();
            $SolicitudConvenioId = limpiarCadena(filter_var($_POST["SolicitudConvenioId"],FILTER_SANITIZE_NUMBER_INT));

			$solicitud->load("SolicitudConvenioId=?", array($SolicitudConvenioId));
			if($solicitud->fechaenviosolicitud==null){
				$solicitud->fechaenviosolicitud  = date('Y-m-d');
			}
			$solicitud->pasosolicitud = 0;
            $solicitud->convenioprocesoid  = 2;
			$solicitud->fechamodificacion  = $now;
			$solicitud->usuariomodificacion  = $usuario["idusuario"];
            $solicitud->ambito;
            $solicitud->save();

            $logCambios = "Insert into LogSolicitudConvenios (SolicitudConvenioId, ConvenioProcesoId, UsuarioCreacion, FechaCreacion) values('".$SolicitudConvenioId."', '1', '".$usuario["idusuario"]."', '".$fecha."')";
            $insertar4= $db->execute($logCambios);

            $to = "direcciondedesarrollo@unbosque.edu.co";
            $asunto = "Notificacion solicitud de convenio";
            $mensaje = "Nueva Solicitud de convenio por revisar por la Secretaria General. Por favor ingrese al sistema para verificar la lista de convenios en tramite.";
            //EnviarCorreo($to,$asunto,$mensaje);

            if($solicitud->ambito == '2')// nacional
            {
                $to = "lealhannia@unbosque.edu.co, internacionalizacion2@unbosque.edu.co";
                $asunto = "Notificacion solicitud de convenio";
                $mensaje = "Nueva Solicitud de Convenio Nacional por revisar por la Secretaria General. Por favor ingrese al sistema para verificar la lista de convenios en tramite.";
                //EnviarCorreo($to,$asunto,$mensaje);

            }else if($solicitud->ambito == '1')// internacional
            {
                $to2 = "relacionesinterinstitucionales@unbosque.edu.co";
                $asunto = "Notificacion solicitud de convenio";
                $mensaje = "Nueva Solicitud de Convenio Internacional por revisar por la Secretaria General. Por favor ingrese al sistema para verificar la lista de convenios en tramite.";
                //EnviarCorreo($to2,$asunto,$mensaje);
            }
			?>
			<script type="text/javascript">
				alert("Su solicitud ha sido enviada de forma exitosa a la oficina de desarrollo");
				window.location = './Propuestaconvenio.php';
			</script>
			<?php
		} else {
			echo "Ocurrio un problema en la solicitud http";
			exit();
		}
	} break;
}
?>