<?php
	global $db;
	$banderagrabar = 0;

	$ano = substr($_POST['fecha1'],0,4);
	$mes = substr($_POST['fecha1'],5,2);
	$dia = substr($_POST['fecha1'],8,2);
	$email = "^[A-z0-9\._-]+"
	."@"
	."[A-z0-9][A-z0-9-]*"
	."(\.[A-z0-9_-]+)*"
	."\.([A-z]{2,6})$";
	 $_POST['nombres']   =  strtr(strtoupper($_POST['nombres']), "àáâãäåæçèéêëìíîïðñòóôõöøùüú", "ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÜÚ");
     $_POST['apellidos'] =  strtr(strtoupper($_POST['apellidos']), "àáâãäåæçèéêëìíîïðñòóôõöøùüú", "ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÜÚ");
	if ($_POST['trato'] == 0)
	{
		echo '<script language="JavaScript">alert("Debe seleccionar el trato")</script>';
		$banderagrabar = 1;
	}
	else
	if ((!ereg("^([a-zA-ZáéíóúüñÁÉÍÓÚÑÜ]+([A-Za-záéíóúüñÁÉÍÓÚÑÜ]*|( *[A-Za-záéíóúüñÁÉÍÓÚÑÜ]+)*)) *$",$_POST['nombres']) or $_POST['nombres'] == ""))
	{
		echo '<script language="JavaScript">alert("El Nombre es Incorrecto")</script>';
		$banderagrabar = 1;
	}
	else
	if ((!ereg("^([a-zA-ZáéíóúüñÁÉÍÓÚÑÜ]+([A-Za-záéíóúüñÁÉÍÓÚÑÜ]*|( *[A-Za-záéíóúüñÁÉÍÓÚÑÜ]+)*)) *$",$_POST['apellidos']) or $_POST['apellidos'] == ""))
	{
		echo '<script language="JavaScript">alert("El Apellido es Incorrecto")</script>';
		$banderagrabar = 1;
	}
	else
	if ($_POST['tipodocumento'] == 0)
	{
		echo '<script language="JavaScript">alert("Debe seleccionar el tipo de documento")</script>';
		$banderagrabar = 1;
	}
	else
	if ($_POST['idestrato'] == 'seleccionar')
	{
		echo '<script language="JavaScript">alert("Debe seleccionar el estrato")</script>';
		$banderagrabar = 1;
	}
	else
	if(trim($_POST['numerodocumento'])=='0'){
		echo '<script language="JavaScript">alert("Número de documento Incorrecto")</script>';
		$banderagrabar = 1;
	}
	else
	if (!eregi("^[0-9]{1,15}$", $_POST['numerodocumento']))
	{
		echo '<script language="JavaScript">alert("Número de documento Incorrecto")</script>';
		$banderagrabar = 1;
	}
	else
	if ($_POST['expedidodocumento'] == "")
	{
		echo '<script language="JavaScript">alert("Expedido documento es Incorrecto")</script>';
		$banderagrabar = 1;
	}
	else
	if ($_POST['genero'] == 0)
	{
		echo '<script language="JavaScript">alert("Seleccione el genero")</script>';
		$banderagrabar = 1;
	}
	else
	if ($_POST['idestrato'] == "")
	{
		echo '<script language="JavaScript">alert("Debe seleccionar el estrato")</script>';
		$banderagrabar = 1;
	}
	else
	if ($_POST['ciudadnacimiento'] == 0)
	{
		echo '<script language="JavaScript">alert("Lugar de nacimiento es Incorrecto")</script>';
		$banderagrabar = 1;
	}
	else
	if (!(@checkdate($mes, $dia,$ano)) or ($ano > date("Y")) or ($ano < 1900))
	{
		echo '
		<script language="JavaScript">
		alert("La fecha digitada debe ser valida y en formato aaaa-mm-dd")
		</script>
		';
		$banderagrabar = 1;
	}
	else
	if ($_POST['genero'] == 0)
	{
		echo '<script language="JavaScript">alert("Debe seleccionar el genero")</script>';
		$banderagrabar = 1;
	}
	else
	if (!eregi($email,$_POST['email']) or $_POST['email'] == "")
	{
		echo '<script language="JavaScript">alert("E-mail Incorrecto")</script>';
		$banderagrabar = 1;
	}
	else
	if ($_POST['direccion1'] == "")
	{
		echo '<script language="JavaScript">alert("Debe Digitar una Dirección")</script>';
  	    $banderagrabar = 1;
	}
	else
	if (!eregi("^[0-9]{1,15}$", $_POST['telefono1']))
	{
		echo '<script language="JavaScript">alert("Teléfono de residencia Incorrecto")</script>';
		$banderagrabar = 1;
	}

	else
	if ($_POST['ciudad1'] == 0)
	{
		echo '<script language="JavaScript">alert("Ciudad de residencia es Incorrecta")</script>';
		$banderagrabar = 1;
	}
	else if($_POST['ciudad1'] == 359 && $_POST['estudiantebarrio'] == "")
	{
		echo '<script language="JavaScript">alert("Debe seleccionar una localidad")</script>';
		$banderagrabar = 1;
	}
	else if($_POST['ciudadnacimiento'] == 2000 && $_POST['estudianteextranjero'] == "")
	{
		echo '<script language="JavaScript">alert("Debe digitar lugar de nacimiento")</script>';
		$banderagrabar = 1;
	}
	else if($_POST['hijo_egresado'] == 1 && ($_POST['familiar_egresado'] == "" || $_POST['telefono_egresado'] == "" || $_POST['parentesco_egresado'] == "" || $_POST['documento_egresado'] == ""))
	{
		echo '<script language="JavaScript">alert("Debe digitar la informacion completa del egresado")</script>';
		$banderagrabar = 1;
	}
    else if($_POST['celular'] == "" || $_POST['celular']==null){
        echo '<script language="JavaScript">alert("Debe digitar celular de contacto")</script>';
        $banderagrabar = 1;
    }
	else if($_POST['hijo_egresado'] == "" || $_POST['hijo_egresado']==null){
		echo '<script language="JavaScript">alert("Debe confirmar si es hijo(a) de algún egresado de la universidad")</script>';
		$banderagrabar = 1;
	}

	else
	if ($banderagrabar == 0)
	{

  		     $base="update estudiantegeneral
			 set idtrato = '".$_POST['trato']."',
             idestadocivil = '".$_POST['civil']."',
 			 tipodocumento = '".$_POST['tipodocumento']."',
   			 numerodocumento = '".$_POST['numerodocumento']."',
             expedidodocumento = '".$_POST['expedidodocumento']."',
			 numerolibretamilitar = '".$_POST['libreta']."',
			 numerodistritolibretamilitar = '".$_POST['distrito']."',
			 expedidalibretamilitar = '".$_POST['expedidalibreta']."',
             nombrecortoestudiantegeneral = '".$_POST['numerodocumento']."',
			 nombresestudiantegeneral = '".$_POST['nombres']."',
             apellidosestudiantegeneral = '".$_POST['apellidos']."',
			 fechanacimientoestudiantegeneral = '".$_POST['fecha1']."',
			 idciudadnacimiento = '".$_POST['ciudadnacimiento']."',
			 codigogenero = '".$_POST['genero']."',
			 direccionresidenciaestudiantegeneral = '".$_POST['direccion1']."',
			 direccioncortaresidenciaestudiantegeneral = '".$_POST['direccion1oculta']."',
			 ciudadresidenciaestudiantegeneral = '".$_POST['ciudad1']."',
			 telefonoresidenciaestudiantegeneral = '".$_POST['telefono1']."',
			 celularestudiantegeneral = '".$_POST['celular']."',
			 emailestudiantegeneral = '".$_POST['email']."',
			 email2estudiantegeneral = '".$_POST['email2']."',
			 casoemergenciallamarestudiantegeneral = '".$_POST['emergencia']."',
			 telefono1casoemergenciallamarestudiantegeneral = '".$_POST['telemergencia1']."',
			 telefono2casoemergenciallamarestudiantegeneral = '".$_POST['telemergencia2']."',
			 idtipoestudiantefamilia = '".$_POST['parentesco']."',
			 fechaactualizaciondatosestudiantegeneral = '" . date("Y-m-d G:i:s", time()) . "'
			 where idestudiantegeneral = '".$this->idestudiantegeneral."'";
		     $sol = $db->Execute($base);
		    // Mira si el estrato seleccionado es diferente al actual
			$query_estratohistorico = "select *
			from estratohistorico
			where idestudiantegeneral = '".$this->idestudiantegeneral."'
			and codigoestado like '1%'
			order by 1";
			$estratohistorico = $db->Execute($query_estratohistorico);
			$totalRows_estratohistorico = $estratohistorico->RecordCount();
			$row_estratohistorico = $estratohistorico->FetchRow();
			if($_POST['idestrato'] != $row_estratohistorico['idestrato'])
			{
				$query_updestratohistorico = "UPDATE estratohistorico
				SET codigoestado='200'
				WHERE idestudiantegeneral = '".$this->idestudiantegeneral."'";

				$updestratohistorico = $db->Execute($query_updestratohistorico);

				$query_insestratohistorico = "INSERT INTO estratohistorico(idestratohistorico, idestrato, idestudiantegeneral, fechaingresoestratohistorico, codigoestado)
			    VALUES(0, '".$_POST['idestrato']."', '".$this->idestudiantegeneral."', now(), '100');";

				$insestratohistorico = $db->Execute($query_insestratohistorico);
			}
			if($_POST['ciudad1'] == 359)
			{
				$query_estbarrio = "select *
				from estudiantebarrio
				where idestudiantegeneral = '".$this->idestudiantegeneral."'
				order by 1";
				$estbarrio = $db->Execute($query_estbarrio);
				$totalRows_estbarrio = $estbarrio->RecordCount();
				if($totalRows_estbarrio == 0)
				{
					$query_insbarrio = "INSERT INTO estudiantebarrio(idestudiantebarrio, idestudiantegeneral, estudiantebarrio, codigoestado)
					VALUES(0, '".$this->idestudiantegeneral."', '".$_POST['estudiantebarrio']."', '100')";

					$insbarrio = $db->Execute($query_insbarrio);
				}
				else
				{
					$query_updbarrio = "UPDATE estudiantebarrio
					SET estudiantebarrio= '".$_POST['estudiantebarrio']."', codigoestado = '100'
					WHERE idestudiantegeneral = '".$this->idestudiantegeneral."'";

					$updbarrio = $db->Execute($query_updbarrio);
				}

			}
			else
			{
				$query_updbarrio = "UPDATE estudiantebarrio
				SET codigoestado='200'
				WHERE idestudiantegeneral = '".$this->idestudiantegeneral."'";

				$updbarrio = $db->Execute($query_updbarrio);
			}
			if($_POST['ciudadnacimiento'] == 2000)
			{
				$query_estextranjero = "select *
				from estudianteextranjero
				where idestudiantegeneral = '".$this->idestudiantegeneral."'
				order by 1";
				$estextranjero = $db->Execute($query_estextranjero);
				$totalRows_estextranjero = $estextranjero->RecordCount();
				if($totalRows_estextranjero == 0)
				{
					$query_insextranjero = "INSERT INTO estudianteextranjero(idestudianteextranjero, idestudiantegeneral, estudianteextranjero, codigoestado)
					VALUES(0, '".$this->idestudiantegeneral."', '".$_POST['estudianteextranjero']."', '100')";

					$insextranjero = $db->Execute($query_insextranjero);
				}
				else
				{
					$query_updextranjero = "UPDATE estudianteextranjero
					SET estudianteextranjero= '".$_POST['estudianteextranjero']."', codigoestado = '100'
					WHERE idestudiantegeneral = '".$this->idestudiantegeneral."'";

					$updextranjero = $db->Execute($query_updextranjero);
				}

			}
			else
			{
				$query_updextranjero = "UPDATE estudianteextranjero
				SET codigoestado='200'
				WHERE idestudiantegeneral = '".$this->idestudiantegeneral."'";

				$updextranjero = $db->Execute($query_updextranjero);
			}

		$_SESSION['sesionmodulos'][1] = $nombremodulos[1];
		if($_POST['numerodocumento'] <> $this->numerodocumento)
		{
			$_SESSION['numerodocumentosesion'] = $_POST['numerodocumento'];
			$query_insdocumento = "INSERT INTO estudiantedocumento(idestudiantedocumento, idestudiantegeneral, tipodocumento, numerodocumento, expedidodocumento, fechainicioestudiantedocumento, fechavencimientoestudiantedocumento)
			VALUES(0,'".$this->idestudiantegeneral."', '".$_POST['tipodocumento']."', '".$_POST['numerodocumento']."', '".$_POST['expedidodocumento']."', '".date("Y-m-d")."', '2999-12-31')";
			if(!($insdocumento = $db->Execute($query_insdocumento)))
			{
				$query_upddocumento = "UPDATE estudiantedocumento
				SET fechavencimientoestudiantedocumento='2999-12-31'
				WHERE idestudiantegeneral = '".$this->idestudiantegeneral."'
				and numerodocumento = '".$_POST['numerodocumento']."'";
				$upddocumento = $db->Execute($query_upddocumento);
			}
			$fechahabil = date("Y-m-d");
			$unDiaMenos = strtotime("-1 day", strtotime($fechahabil));
			$fechahabil = date("Y-m-d",$unDiaMenos);
			$query_upddocumento = "UPDATE estudiantedocumento
    		SET fechavencimientoestudiantedocumento='$fechahabil'
    		WHERE idestudiantegeneral = '".$this->idestudiantegeneral."'
			and numerodocumento = '$this->numerodocumento'";
			$upddocumento = $db->Execute($query_upddocumento);
			$query_updusuario = "UPDATE usuario
			SET numerodocumento = '".$_POST['numerodocumento']."'
            WHERE numerodocumento = '$this->numerodocumento'";
			$updusuario = $db->Execute($query_updusuario);
		}
        if(isset($_POST['numerodocumento'])) {
            $query_updusuario = "UPDATE usuario
            SET numerodocumento = '".$_POST['numerodocumento']."'
            WHERE numerodocumento = '$this->numerodocumento'";
            $updusuario = $db->Execute($query_updusuario);
        }
		if ($_SESSION['inscripcionsession'] <> "")
		{

		}
		else
		{
			$base="update estudiantegeneral
		    set fechaactualizaciondatosestudiantegeneral = '".date("Y-m-d G:i:s",time())."',
		    update_at = '" . date("Y-m-d G:i:s", time()) . "'
		    where idestudiantegeneral = '".$this->idestudiantegeneral."'";
			$sol = $db->Execute($base);
			//echo $base;
			$query_direccion = "SELECT direccioncortaresidenciaestudiantegeneral
			FROM estudiantegeneral
			WHERE idestudiantegeneral = '".$this->idestudiantegeneral."'";
			$direccion = $db->Execute($query_direccion);
			$totalRows_direccion = $direccion->RecordCount();
			$row_direccion = $direccion->FetchRow();

		}
		
		if($_POST['hijo_egresado'] == 1){
			$query_egresado = "select *
			from PadreEgresadoEstudiantes
			where idestudiantegeneral = '".$this->idestudiantegeneral."'
			order by 1";
			$egresado = $db->Execute($query_egresado);
			$totalRows= $egresado->RecordCount();
			$row = $egresado->FetchRow();
			if($row['idestduiantegeneral']!=$this->idestudiantegeneral){
				//insert
				$query="INSERT INTO `PadreEgresadoEstudiantes` (`idestudiantegeneral`, `NombrePadreEgresado`, `idtipoestudiantefamilia`, 
				`NumeroDocumento`, `codigoestado`, `Telefono`, `FechaCreacion`) VALUES ('".$this->idestudiantegeneral."', '".$_POST['familiar_egresado']."', 
				'".$_POST['parentesco_egresado']."', '".$_POST['documento_egresado']."', '100', '".$_POST['telefono_egresado']."', 
				'".date("Y-m-d G:i:s",time())."')";
			} else {
				//update
				$query="UPDATE `PadreEgresadoEstudiantes` SET `NombrePadreEgresado`='".$_POST['familiar_egresado']."', `idtipoestudiantefamilia`='".$_POST['parentesco_egresado']."', `NumeroDocumento`='".$_POST['documento_egresado']."', 
				`Telefono`='".$_POST['telefono_egresado']."', `codigoestado`='100', `FechaModificacion`='".date("Y-m-d G:i:s",time())."' WHERE (`idestudiantegeneral`='".$this->idestudiantegeneral."')";
			}
		} else {
			$query="UPDATE `PadreEgresadoEstudiantes` SET `codigoestado`='200' WHERE (`idestudiantegeneral`='".$this->idestudiantegeneral."')";
		}
		$db->Execute($query);
?>
<script type="text/javascript">
    alert("Los datos personales se han almacenado satisfactoriamente");
</script>
<?php
	}
?>