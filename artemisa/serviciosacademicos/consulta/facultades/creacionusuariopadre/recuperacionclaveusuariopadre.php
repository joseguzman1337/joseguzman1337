<?php
	require_once('../../../Connections/sala2.php' );
	$fechahoy=date("Y-m-d H:i:s");
	$rutaado = "../../../funciones/adodb/";
	require_once('../../../Connections/salaado.php');
	require_once("../../../funciones/clases/autenticacion/claseldap.php");
	require_once("../../../Connections/conexionldap.php");
	require_once("../../../../serviciosacademicos/funciones/sala_genericas/securimage/securimage.php");
	require_once('restauracionusuariopadre.php');
	//$urldesarrollo="http://172.16.3.202/~dmolano/desarrollo/serviciosacademicos/consulta/facultades/creacionusuariopadre/recuperacionclaveusuariopadre.php";
	$urldesarrollo="https://artemisa.unbosque.edu.co/serviciosacademicos/consulta/facultades/creacionusuariopadre/recuperacionclaveusuariopadre.php";
	//session_start();
	//$_SESSION['MM_Username'];
	$horaactual = mktime();
	$horaregistro = $_GET['ta'];
	$activarclave = 0;
	$modificarclave = 0;
	$tiempoactivacion=86400;

	$image = new Securimage();

	if (isset($_GET['id']) && trim($_GET['ta']) != '') {
		if (($horaactual - $horaregistro) < $tiempoactivacion) {
			 //echo "HABER SI SALE ESTO ?";
			$modificarclave = 1;
		} else {
			echo "<script language='javascript'>
				alert('Su periodo de tiempo para recuperar la contraseña a expirado ,\\n Recuerde que tiene un dia para utilizar el enlace que llega en su cooreo,\\n puede volver a intentarlo');
				</script>";
			echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=" . $urldesarrollo . "'>";
		}
	}

	$varguardar=0;
	$patron = "^[A-z0-9\._-]+"
							."@"
							."[A-z0-9][A-z0-9-]*"
							."(\.[A-z0-9_-]+)*"
							."\.([A-z]{2,6})$";

	if (isset($_POST['enviar'])) {
			if ($_POST['emailusuariopadre'] == "" || !ereg($patron,$_POST['emailusuariopadre'])) {
				echo '<script language="JavaScript">alert("Debe Digitar un E-mail con formato valido")</script>';
				$varguardar = 1;
			}
			elseif ($varguardar == 0) {
				CorreoRecuperacion($_POST['emailusuariopadre']);
			}
	}
	if (isset($_POST['modificar'])) {
			if ($_POST['clave'] == "" ) {
				echo '<script language="JavaScript">alert("Debe Digitar el campo Clave")</script>';
				$varguardar = 1;
			}
			elseif (strlen($_POST['clave'])<6 ) {
				echo '<script language="JavaScript">alert("La clave debe contener más de 6 caracteres")</script>';
				$varguardar = 1;
			}
			elseif ($_POST['confirmaclave'] == "" ) {
				echo '<script language="JavaScript">alert("Debe Digitar el campo Confirmar Clave")</script>';
				$varguardar = 1;
			}
			elseif (strlen($_POST['confirmaclave'])<6 ) {
				echo '<script language="JavaScript">alert("La clave debe contener más de 6 caracteres")</script>';
				$varguardar = 1;
			}
			elseif ($_POST['clave'] != $_POST['confirmaclave']) {
				echo '<script language="JavaScript">alert("Los campos de clave no coinciden, recuerde que deben coincidir los dos campos.")</script>';
				$varguardar = 1;
			}
			elseif ($_POST['codigoverificacion'] == "") {
				echo '<script language="JavaScript">alert("Debe digitar el texto que se ve en la imagen.")</script>';
				$varguardar = 1;
			}
			elseif ($image->check($_POST['codigoverificacion']) != true) {
				echo '<script language="JavaScript">alert("El texto que digito debe ser igual al de la imagen.")</script>';
				$varguardar = 1;
			}
			elseif ($varguardar == 0) {
				//echo "si coincide";

				//$infomodificado["gacctMail"]=$_POST['emailusuariopadre'];
				$infomodificado["userPassword"]="{MD5}".base64_encode(pack("H*",md5($_POST['clave'])));
				$query_emailconsulta="SELECT * FROM usuariopadre where emailusuariopadre='".$_POST['emailusuariopadre']."' and codigoestado like '1%'";				
				$emailconsulta= $db->Execute($query_emailconsulta);
				$totalRows_emailconsulta = $emailconsulta->RecordCount();
				$row_emailconsulta= $emailconsulta->FetchRow();

				$conexionldap=new claseldap(SERVIDORLDAP,CLAVELDAP,PUERTOLDAP,CADENAADMINLDAP,"",RAIZDIRECTORIO);
				$conexionldap->ConexionAdmin();
				if(!$conexionldap->ModificacionUsuario($infomodificado,$row_emailconsulta["usuario"])){
					echo '<script language="JavaScript">alert("Se ha presentado un problema inténtelo nuevamente.\\nSi el error persiste por favor contactarse con la Mesa de Servicio al siguiente correo: mesadeservicio@unbosque.edu.co")</script>';

				}
				else{
					echo '<script language="JavaScript">alert("El cambio de clave se ha realizado exitosamente!!!.\\nIngrese al portal académico con la nueva clave.")</script>';
				}
				//CorreoRecuperacion($_POST['emailusuariopadre']);
			}
	}
?>
<html>
    <head>
        <title></title>
        <link rel="stylesheet" href="../../../estilos/sala.css" type="text/css">
    </head>
    <body>
        <form name="f1" id="f1"  method="POST" action="">
            <table width="50%" border="1"  cellpadding="3" cellspacing="3">
                <TR id="trgris" >
                    <TD colspan="2" align="center"><LABEL id="labelresaltadogrande">Recuperación Clave Usuario Padre de Familia</LABEL></TD>
                </TR>
                <TR>
                    <TD id="tdtitulogris"><LABEL id="labelasterisco">*</LABEL>&nbsp;E-Mail Padre</TD>
                    <TD><input type="text" name="emailusuariopadre" value="<?php if($_REQUEST['emailusuariopadre'] !=""){ echo $_REQUEST["emailusuariopadre"]; } elseif($modificarclave){ echo $_GET['correo']; }?>" <?php if($modificarclave){ echo "readonly=yes"; } ?>></TD>
                </TR>
                <?php
                if(!$modificarclave){
                ?>
                <TR id="trgris" >
                    <TD colspan="2" align="center"><input type="submit" name="enviar" value="Enviar">
                    </TD>
                </TR>
                <?php
                }
                if($modificarclave){
                ?>                
                <TR>
                    <TD id="tdtitulogris"><LABEL id="labelasterisco">*</LABEL>&nbsp;Clave</TD>
                    <TD><input type="password" name="clave">
                    </TD>
                </TR>
                <TR>
                    <TD id="tdtitulogris"><LABEL id="labelasterisco">*</LABEL>&nbsp;Confirmar Clave</TD>
                    <TD><input type="password" name="confirmaclave" >
                    </TD>
                </TR>                
                <TR>
                    <TD width="50%" id="tdtitulogris"><LABEL id="labelasterisco">*</LABEL>&nbsp;Por favor digite en el campo los caracteres que se ven en la imagen.</TD>
                    <TD><img id="captcha" src="../../../../serviciosacademicos/funciones/sala_genericas/securimage/securimage_show.php" alt="CAPTCHA" border="1"><br><br>
                        <input type="text" name="codigoverificacion" size="10" maxlength="6">&nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="button" value="Otra imágen" onclick="document.getElementById('captcha').src = '../../../../serviciosacademicos/funciones/sala_genericas/securimage/securimage_show.php?' + Math.random(); return false">
                    </TD>
                </TR>
                <TR id="trgris" >
                    <TD colspan="2" align="center"><input type="submit" name="modificar" value="Modificar Clave">
                    </TD>
                </TR>
                <?php
                }
                ?>
            </table>
        </form>
    </body>
</html>