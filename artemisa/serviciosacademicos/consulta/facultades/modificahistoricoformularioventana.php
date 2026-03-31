<?php
    session_start();
    include_once('../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
 
include_once(realpath(dirname(__FILE__)).'/../../utilidades/ValidarModuloNota.php');
include_once(realpath(dirname(__FILE__)).'/../../utilidades/Ipidentificar.php');

//identificaicon de la ip del usuario
$A_Validarip = new ipidentificar();
$ip = $A_Validarip->tomarip();
//validacion del ingreso del modulo
$C_ValidarFecha = new ValidarModulo(); 
$alerta = $C_ValidarFecha->ValidarIngresoModulo($_SESSION['usuario'], $ip, 'NotaHistorico-Formulario ventana');
//si el usuario ingresa durante fecha no autorizadas se genera la alerta.
if($alerta)
{
    echo $alerta;
    die;
}
    
require('../../Connections/sala2.php');
require_once('../../utilidades/notas/funcionesModificarNotas.php' );

//session_start();

if (!$_SESSION['MM_Username'])
 {
   header( "Location: https://artemisa.unbosque.edu.co/serviciosacademicos/consulta/facultades/consultafacultadesv2.htm");
 }


$id=$_GET['idhistorico'];
$direccion = "modificahistoricoformulario.php";
//$nuevogrupo = $row_maxgrupo['maximogrupo'] + 1;

mysql_select_db($database_sala, $sala);

$query_Recordset1 = "	SELECT *
			FROM notahistorico n
			,materia m
			,estadonotahistorico e
			,tiponotahistorico t
			WHERE n.idnotahistorico = '".$_GET['idhistorico']."'
				AND e.codigoestadonotahistorico = n.codigoestadonotahistorico
				AND m.codigomateria = n.codigomateria
				AND n.codigotiponotahistorico = t.codigotiponotahistorico ";
//echo $query_Recordset1;
$Recordset1 = mysql_query($query_Recordset1, $sala) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

$query_estadonota = "SELECT * FROM estadonotahistorico ORDER BY 1";
$estadonota = mysql_query($query_estadonota, $sala) or die(mysql_error());
$row_estadonota = mysql_fetch_assoc($estadonota);
$totalRows_estadonota = mysql_num_rows($estadonota);

$query_tiponota = "SELECT * FROM tiponotahistorico";
$tiponota = mysql_query($query_tiponota, $sala) or die(mysql_error());
$row_tiponota = mysql_fetch_assoc($tiponota);
$totalRows_tiponota = mysql_num_rows($tiponota);

?>
<style type="text/css">
	<!--
	.Estilo1 {font-family: Tahoma; font-size: 12px}
	.Estilo2 {font-family: Tahoma; font-size: 12px; font-weight: bold; }
	.Estilo3 {font-family: Tahoma; font-size: 14px; font-weight: bold;}
	-->
</style>
<script language="JavaScript" >
	function cancelar(id) {
		if(confirm('Esta seguro de cancelar la solictud "'+id+'"?')){
			document.form1.IdSolicitud.value=id;
			document.form1.accion.value="cancelar";
			document.form1.submit();
		}
	}
</script>
<form name="form1" method="get" action="modificahistoricoformularioventana.php">
	<input type="hidden" name="accion">
	<input type="hidden" name="IdSolicitud">
	<p align="center" class="Estilo3">Modificaci&oacute;n Historico de Notas</p>
	<table width="600"  border="1" align="center" cellpadding="2" bordercolor="#E97914">
		<tr class="Estilo2">
			<td align="center">Código</td>
			<td align="center">Nombre</td>
			<td align="center">Nota</td>
			<td align="center">Tipo nota</td>
			<td align="center">Estado nota</td>
		</tr>
		<tr class="Estilo1">
			<td align="center"><?php echo $row_Recordset1['codigomateria']; ?></td>
			<td><?php echo $row_Recordset1['nombremateria']; ?></td>
			<td align="center">
				<?php echo number_format($row_Recordset1['notadefinitiva'],1);?>
				<input name='nota' type='hidden' value='<?php echo number_format($row_Recordset1['notadefinitiva'],1);?>' size='3' maxlength='3'>
			</td>
			<td>
				<div align="center" class="Estilo1">
					<input name='tiponota' type='hidden' value='<?php echo $row_Recordset1['codigotiponotahistorico'];?>' size='3' maxlength='3'>
					<input name='nombretiponotahistorico' type='hidden' value='<?php echo $row_Recordset1['nombretiponotahistorico'];?>' size='3' maxlength='3'>
<?php
					if ($row_Recordset1['codigotiponotahistorico'] <> 100) { // tipo nota
?>
						<select name="tiponota" id="tiponota">

<?php
							do {
?>
								<option value="<?php echo $row_tiponota['codigotiponotahistorico']?>"<?php if (!(strcmp($row_tiponota['codigotiponotahistorico'], $row_Recordset1['codigotiponotahistorico']))) {echo "SELECTED";} ?>><?php echo $row_tiponota['nombretiponotahistorico']?></option>
<?php
							} while ($row_tiponota = mysql_fetch_assoc($tiponota));
							$rows = mysql_num_rows($tiponota);
							if($rows > 0) {
								mysql_data_seek($tiponota, 0);
								$row_tiponota = mysql_fetch_assoc($tiponota);
							}
?>
						</select>
<?php
					} else {
						echo $row_Recordset1['nombretiponotahistorico'];
					}
?>
				</div>
			</td>
<?php
			$query_modif = "select	 id
						,observaciones
						,codigoestadosolicitud
						,nombreestadosolicitudcredito
						,nombreestadonotahistorico
						,observaciones
					from solicitudaprobacionmodificacionnotas s 
					join estadosolicitudcredito e on s.codigoestadosolicitud=e.codigoestadosolicitudcredito
					join estadonotahistorico en using(codigoestadonotahistorico)
					where idnotahistorico=".$_REQUEST['idhistorico']."
						and codigoestadosolicitud=10
						and idtiposolicitudaprobacionmodificacionnotas=20";
			$reg_modif = mysql_query($query_modif, $sala) or die(mysql_error());
			$count_modif = mysql_num_rows($reg_modif);
			if($count_modif>0) {
				$row_modif = mysql_fetch_assoc($reg_modif);
				echo "	<td>
						<div align='center' class='Estilo1'>
							<table width='100%' bgcolor='#CFFFEC'>
								<tr class='Estilo1'><td>Estado nota:</td><th align='right'>".$row_modif['nombreestadonotahistorico']."</th></tr>
							</table>
							<table width='100%' style='border: solid 2px #000000; '>
								<tr class='Estilo1'><td>Id Solicitud:</td><td><b>".$row_modif['id']."</b></td></tr>
								<tr class='Estilo1'><td>Estado:</td><td><b><font color='#".$font."'>".$row_modif['nombreestadosolicitudcredito']."</font></b></td></tr>
							</table>
							<table width='100%'><tr class='Estilo1'><th><input type='button' value='Cancelar solicitud' style='font-size:10px' onclick='cancelar(".$row_modif['id'].")'></th></tr></table>
						</div>
				       	</td>";
			} else {
?>
				<td>
					<div align="center">
						<span class="Estilo3">
							<select name="estadonota" id="select2">
<?php
								do {
?>
									<option value="<?php echo $row_estadonota['codigoestadonotahistorico']?>"<?php if (!(strcmp($row_estadonota['codigoestadonotahistorico'], $row_Recordset1['codigoestadonotahistorico']))) {echo "SELECTED";} ?>><?php echo $row_estadonota['nombreestadonotahistorico']?></option>
<?php
								} while ($row_estadonota = mysql_fetch_assoc($estadonota));
								$rows = mysql_num_rows($estadonota);
								if($rows > 0) {
									mysql_data_seek($estadonota, 0);
									$row_estadonota = mysql_fetch_assoc($estadonota);
								}
?>
							</select>
						</span>
					</div>
				</td>
<?php
			}
			$query_modif2 = "select	 id
						,observaciones
						,codigoestadosolicitud
						,nombreestadosolicitudcredito
						,nombreestadonotahistorico
						,observaciones
						,fechaaprobacion
					from solicitudaprobacionmodificacionnotas s 
					join estadosolicitudcredito e on s.codigoestadosolicitud=e.codigoestadosolicitudcredito
					join estadonotahistorico en using(codigoestadonotahistorico)
					where idnotahistorico=".$_REQUEST['idhistorico']."
						and codigoestadosolicitud=20
						and idtiposolicitudaprobacionmodificacionnotas=20
					order by id desc
					limit 1";
			$reg_modif2 = mysql_query($query_modif2, $sala) or die(mysql_error());
			$count_modif2 = mysql_num_rows($reg_modif2);
			if($count_modif==0 && $count_modif2>0) {
				$row_modif2 = mysql_fetch_assoc($reg_modif2);
				echo "	<td>
						<div align='center' class='Estilo1'>
							<table width='100%' bgcolor='#CFFFEC'>
								<tr class='Estilo1'><td>Estado nota:</td><th align='right'>".$row_modif2['nombreestadonotahistorico']."</th></tr>
							</table>
							<table width='100%' style='border: solid 2px #000000; '>
								<tr class='Estilo1'><td>Id Solicitud:</td><td><b>".$row_modif2['id']."</b></td></tr>
								<tr class='Estilo1'><td>Fecha rechazo:</td><td><b>".$row_modif2['fechaaprobacion']."</b></td></tr>
								<tr class='Estilo1'><td>Estado:</td><td><b><font color='#D20D00'>".$row_modif2['nombreestadosolicitudcredito']."</font></b></td></tr>
							</table>
						</div>
				       	</td>";
			}
?>
		</tr>
		<tr>
			<td colspan="5">
				<span class="Estilo2">Observaci&oacute;n:</span>
				<span class="Estilo1"><input name="observacion" type="text" size="50" value="<?php echo $_GET['observacion'];?>"></span>
			</td>
		</tr>
		<tr>
			<td colspan="5">
				<div align="center">
					<span class="Estilo14">
						<input type="submit" name="Submit" value="Guardar Cambios">&nbsp;&nbsp;<input name="Aceptar" type="button" id="Aceptar" value="Cerrar" onClick="window.close()">
					</span>
				</div>
			</td>
		</tr>
	</table>
	<p>
		<input type="hidden" name="idhistorico" value="<?php echo $_GET['idhistorico'];?>">
	</p>
	<div align="center"></div>
	<div align="center"></div>
<?php
	$banderagrabar=0;
	require_once('../../funciones/funcionip.php' );

	$ip = (tomarip())?tomarip():"SIN DEFINIR";
	if ($_GET['Submit']) {
		$query="select *
			from ipsvalidasmodificacionnotas
			where (ip='".$ip."')
				and '".date("Y-m-d")."' between fechadesde and fechahasta";
		$regIP = mysql_query($query,$sala);

		$query=queryAprobadorMateria($row_Recordset1['codigomateria']);
		$regAprobador = mysql_query($query,$sala);

		if ((!eregi("^[0-9]{1,3}\.[0-9]{1,1}$", $_GET['nota'])) ) {
		//((!eregi("^[0-5]{1,1}\.[0-9]{1,1}$", $_GET['nota'])) or ($_GET['nota'] > 5)) 
			echo '<script language="JavaScript">alert("Las Notas se deben Digitar en Formato 0.0 a 5.0 con separador PUNTO(.)")</script>';
			echo '<script language="JavaScript">history.go(-1)</script>';
			$banderagrabar = 1;
			$_GET['Submit'] == false;
		} else if($_GET['observacion'] == "") {
			echo '<script language="JavaScript">alert("Debe escribir una observación de la modificación realizada")</script>';
			echo '<script language="JavaScript">history.go(-1)</script>';
			$banderagrabar = 1;
			$_GET['Submit'] == false;
		} else if (mysql_num_rows($regIP)==0) {
			echo '<script language="JavaScript">alert("Esta dirección IP ('.$ip.') no es válida para realizar modificaciones. Por favor comuniquese con la mesa de ayuda")</script>';
			echo '<script language="JavaScript">history.go(-1)</script>';
			$banderagrabar = 1;
			$_GET['Submit'] == false;
		} else if (mysql_num_rows($regAprobador)==0) {
			echo '<script language="JavaScript">alert("No se encontro aprobador de notas definido para la carrera asociada a esta matería. Por favor comuniquese con el área de registro y control")</script>';
			echo '<script language="JavaScript">history.go(-1)</script>';
			$banderagrabar = 1;
			$_GET['Submit'] == false;
		}

		if ($banderagrabar == 0) {
			

			$rowAprobador = mysql_fetch_assoc($regAprobador);

			$query="select idusuario from usuario where usuario='".$_SESSION['MM_Username']."'";
			$regSolicitante = mysql_query($query,$sala) OR die(mysql_error());
			$rowSolicitante = mysql_fetch_assoc($regSolicitante);

			$query="select	 numerodocumento
					,apellidosestudiantegeneral
					,nombresestudiantegeneral
				from estudiante
				join estudiantegeneral using(idestudiantegeneral)
				where codigoestudiante=".$_SESSION["codigo"];
			$regEstudiante = mysql_query($query,$sala) OR die(mysql_error());
			$rowEstudiante = mysql_fetch_assoc($regEstudiante);
			
			$fechahoy=date("Y-m-d H:i:s");

			$query="insert into solicitudaprobacionmodificacionnotas
					(codigotiponotahistorico
					,notamodificada
					,codigoestadonotahistorico
					,observaciones
					,idnotahistorico
					,codigoestudiante
					,codigomateria
					,idsolicitante
					,fechasolicitud
					,ipsolicitante
					,idaprobador
					,insdelupd
					,idtiposolicitudaprobacionmodificacionnotas
					,codigoestadosolicitud)
				values ( '".$_REQUEST["tiponota"]."'
					,".$_REQUEST["nota"]."
					,'".$_REQUEST["estadonota"]."'
					,'".$_REQUEST["observacion"]."'
					,".$_REQUEST["idhistorico"]."
					,".$_SESSION["codigo"]."
					,".$row_Recordset1['codigomateria']."
					,'".$rowSolicitante["idusuario"]."'
					,'".$fechahoy."'
					,'".$ip."'
					,'".$rowAprobador["idaprobador"]."'
					,'D'
					,20
					,10)";
			mysql_query($query,$sala);

			$idSol=mysql_insert_id();

			$tabla="<table border='1' align='center' bordercolor='#003333'>
					<tr>
						<td align='center' bgcolor='#C5D5D6'><font face='Tahoma' size='2'><strong>Id Solicitud</strong></font></td>
						<td align='center' bgcolor='#C5D5D6'><font face='Tahoma' size='2'><strong>Usuario solicitante</strong></font></td>
						<td align='center' bgcolor='#C5D5D6'><font face='Tahoma' size='2'><strong>Fecha solicitud</strong></font></td>
						<td align='center' bgcolor='#C5D5D6'><font face='Tahoma' size='2'><strong>Documento</strong></font></td>
						<td align='center' bgcolor='#C5D5D6'><font face='Tahoma' size='2'><strong>Apellidos y Nombres</strong></font></td>
						<td align='center' bgcolor='#C5D5D6'><font face='Tahoma' size='2'><strong>Carrera</strong></font></td>
						<td align='center' bgcolor='#C5D5D6'><font face='Tahoma' size='2'><strong>Materia</strong></font></td>
						<td align='center' bgcolor='#C5D5D6'><font face='Tahoma' size='2'><strong>Nota</strong></font></td>
						<td align='center' bgcolor='#C5D5D6'><font face='Tahoma' size='2'><strong>Observaciones</strong></font></td>
					</tr>
					<tr>
						<td align='center'><font face='Tahoma' size='2'>".$idSol."</font></td>
						<td align='center'><font face='Tahoma' size='2'>".$_SESSION["MM_Username"]."</font></td>
						<td align='center'><font face='Tahoma' size='2'>".$fechahoy."</font></td>
						<td align='center'><font face='Tahoma' size='2'>".$rowEstudiante['numerodocumento']."</font></td>
						<td align='center'><font face='Tahoma' size='2'>".$rowEstudiante["apellidosestudiantegeneral"]." ".$rowEstudiante["nombresestudiantegeneral"]."</font></td>
						<td align='center'><font face='Tahoma' size='2'>".$_SESSION["nombrefacultad"]."</font></td>
						<td align='center'><font face='Tahoma' size='2'>".$row_Recordset1["nombremateria"]."</font></td>
						<td align='center'><font face='Tahoma' size='2'>".$_REQUEST["nota"]."</font></td>
						<td align='center'><font face='Tahoma' size='2'>".$_REQUEST["observacion"]."</font></td>
					</tr>
				</table>";

			require_once("../../funciones/phpmailer/class.phpmailer.php");
			$mail = new PHPMailer();
			$mail->From = "no-reply@unbosque.edu.co";
			$mail->FromName = "Sistema SALA";
			$mail->ContentType = "text/html";
			$mail->Subject = "Tiene una nueva solicitud de desactivación de nota en el histórico de notas";
			$mail->Body = "<b>La siguiente solicitud está pendientes de aprobación o rechazo:</b><br><br>".$tabla;
			//$mail->AddAddress("dianarojas@unbosque.edu.co","Diana Rojas");
			//$mail->AddBCC("quinteroivan@unbosque.edu.co","Ivan Dario Quintero");
			//$mail->AddAddress("it@unbosque.edu.co","Jorge Martínez");
			//$mail->AddAddress("stipmp@gmail.com","Edwin Murcia");
			$mail->AddAddress($rowAprobador["emailaprobador"],$rowAprobador["nombreaprobador"]);
			$mail->Send();
			echo '<script language="JavaScript">alert("La desactivación de esta nota queda pendiente de aprobación o rechazo")</script>';
			echo '<script language="JavaScript">history.go(-1)</script>';
			
			//require_once('modificahistoricooperacion.php');
			//exit();
		}
		echo "	<script language='javascript'>
				 window.opener.location.reload();
            	 window.opener.focus();
            	 window.close();
			</script>";
	}
	if ($_REQUEST['accion'] == "cancelar") {
		$query = "update solicitudaprobacionmodificacionnotas set codigoestadosolicitud='21' where id=".$_REQUEST["IdSolicitud"];
		mysql_query($query,$sala);
		$query=queryAprobadorSolicitud($_REQUEST["IdSolicitud"]);
		$reg = mysql_query($query,$sala);
		$row = mysql_fetch_assoc($reg);
		$tabla="<table border='1' align='center' bordercolor='#003333'>
				<tr>
					<td align='center' bgcolor='#C5D5D6'><font face='Tahoma' size='2'><strong>Id Solicitud</strong></font></td>
					<td align='center' bgcolor='#C5D5D6'><font face='Tahoma' size='2'><strong>Usuario solicitante</strong></font></td>
					<td align='center' bgcolor='#C5D5D6'><font face='Tahoma' size='2'><strong>Fecha solicitud</strong></font></td>
					<td align='center' bgcolor='#C5D5D6'><font face='Tahoma' size='2'><strong>Documento</strong></font></td>
					<td align='center' bgcolor='#C5D5D6'><font face='Tahoma' size='2'><strong>Apellidos y Nombres</strong></font></td>
					<td align='center' bgcolor='#C5D5D6'><font face='Tahoma' size='2'><strong>Carrera</strong></font></td>
					<td align='center' bgcolor='#C5D5D6'><font face='Tahoma' size='2'><strong>Materia</strong></font></td>
					<td align='center' bgcolor='#C5D5D6'><font face='Tahoma' size='2'><strong>Nota</strong></font></td>
				</tr>
				<tr>
					<td align='center'><font face='Tahoma' size='2'>".$_REQUEST["IdSolicitud"]."</font></td>
					<td align='center'><font face='Tahoma' size='2'>".$_SESSION["MM_Username"]."</font></td>
					<td align='center'><font face='Tahoma' size='2'>".$row['fechasolicitud']."</font></td>
					<td align='center'><font face='Tahoma' size='2'>".$row['numerodocumento']."</font></td>
					<td align='center'><font face='Tahoma' size='2'>".$row["apellidosestudiantegeneral"]." ".$row["nombresestudiantegeneral"]."</font></td>
					<td align='center'><font face='Tahoma' size='2'>".$row['nombrecarrera']."</font></td>
					<td align='center'><font face='Tahoma' size='2'>".$row['nombremateria']."</font></td>
					<td align='center'><font face='Tahoma' size='2'>".$row["notamodificada"]."</font></td>
				</tr>
			</table>";
		require_once("../../funciones/phpmailer/class.phpmailer.php");
		$mail = new PHPMailer();
		$mail->From = "no-reply@unbosque.edu.co";
		$mail->FromName = "Sistema SALA";
		$mail->ContentType = "text/html";
		$mail->Subject = "Solicitud de desactivación de nota cancelada";
		$mail->Body = "<b>La siguiente solicitud ha sido cancelada por el usuario que la creó:</b><br><br>".$tabla;
		//$mail->AddAddress("dianarojas@unbosque.edu.co","Diana Rojas");
		//$mail->AddBCC("quinteroivan@unbosque.edu.co","Ivan Dario Quintero");
		//$mail->AddAddress("it@unbosque.edu.co","Jorge Martínez");
		//$mail->AddAddress("stipmp@gmail.com","Edwin Murcia");
		$mail->AddAddress($row["emailaprobador"],$row["nombreaprobador"]);
		$mail->Send();

		echo "	<script language='javascript'>
				window.close();
			</script>";
	}
?>
</form>
