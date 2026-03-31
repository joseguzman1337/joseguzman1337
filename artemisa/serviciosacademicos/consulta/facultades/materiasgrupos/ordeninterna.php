<?php
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
//error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING ^ E_DEPRECATED);
//ini_set('display_errors', E_ALL ^ E_NOTICE ^ E_WARNING ^ E_DEPRECATED);
require_once('../../../Connections/sala2.php');
$rutaado = "../../../funciones/adodb/";
require_once('../../../Connections/salaado.php');
session_start();
?>
<html>
	<head>
	        <title>Interesados Educontinuada</title>
	        <link rel="stylesheet" href="../../../estilos/sala.css" type="text/css">
		<style type="text/css">@import url(../../../funciones/calendario_nuevo/calendar-win2k-1.css);</style>
		<script type="text/javascript" src="../../../funciones/calendario_nuevo/calendar.js"></script>
		<script type="text/javascript" src="../../../funciones/calendario_nuevo/calendar-es.js"></script>
		<script type="text/javascript" src="../../../funciones/calendario_nuevo/calendar-setup.js"></script>
		<script>
			function validar() {
				var msj='';
				var str = document.form1.nroproyecto.value.replace(/^\s*|\s*$/g,"");
				if(str=='')
					msj+='El nro de proyecto es requerido.\n';
				if(document.form1.fechainicio.value=='')
					msj+='La fecha inicial es requerida.\n';
				if(document.form1.fechafin.value=='')
					msj+='La fecha final es requerida.\n';
				if(msj)
					alert(msj);
				else
					document.form1.submit();
			}
		</script>
	</head>
	<body>
		<form name="form1" id="form1"  method="POST">
<?php
			if($_REQUEST['accion']=='procesar') {
				if ($_REQUEST['fechafin'] < $_REQUEST['fechainicio']) {
					echo '<script>alert("La fecha inicial  no puede ser mayor a la fecha final.")</script>';
				} else {
					function getRealIP() {
						if (!empty($_SERVER['HTTP_CLIENT_IP']))
							return $_SERVER['HTTP_CLIENT_IP'];
						if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
							return $_SERVER['HTTP_X_FORWARDED_FOR'];
						return $_SERVER['REMOTE_ADDR'];
					}
					$user=$db->Execute("select idusuario from usuario where usuario='".$_SESSION['usuario']."'");
					$row_user=$user->FetchRow();
			
					if($_REQUEST['accion2']=='insertar') {
						$query_orden = "insert into numeroordeninternasap 
									values (default
										,'".date('Y-m-d')."'
										,'".$_REQUEST['fechainicio']."'
										,'".$_REQUEST['fechafin']."'
										,".$_REQUEST['idgrupo']."
										,".$row_user['idusuario']."
										,'".getRealIP()."'
										,".$_REQUEST['nroproyecto'].")";
					} else {
						$query_orden = "update numeroordeninternasap 
								set	 fechanumeroordeninternasap='".date('Y-m-d')."'
									,fechainicionumeroordeninternasap='".$_REQUEST['fechainicio']."'
									,fechavencimientonumeroordeninternasap='".$_REQUEST['fechafin']."'
									,idusuario=".$row_user['idusuario']."
									,ip='".getRealIP()."'
									,numeroordeninternasap=".$_REQUEST['nroproyecto']."
								where idgrupo=".$_REQUEST['idgrupo'];
					}
					$db->Execute($query_orden);
					echo "	<script language='javascript'>
							opener.location.reload();
							window.close();
						</script>";
				}
			}
			$query=$db->Execute("select * from numeroordeninternasap where idgrupo=".$_REQUEST['idgrupo']);
			if($query->RecordCount()>0) {
				$row=$query->FetchRow();
				echo "<input type='hidden' name='accion2' value='actualizar'>";
				$nombre_btn="Actualizar";	
			} else {
				echo "<input type='hidden' name='accion2' value='insertar'>";	
				$nombre_btn="Ingresar";	
			}
			
			
?>
			<br>
			<table border="0" align="center" cellpadding="10" cellspacing="10">
				<tr>
					<td id="tdtitulogris" align="center" colspan="3"><label id="labelresaltadogrande" >ASIGNACION DE NRO. DE PROYECTO</label></td>
				</tr>
				<tr>
					<td id="tdtitulogris" align="center"><label id="labelresaltado">N&uacute;mero de proyecto</label></td>
					<td id="tdtitulogris" align="center"><label id="labelresaltado">Fecha inicial</label></td>
					<td id="tdtitulogris" align="center"><label id="labelresaltado">Fecha final</label></td>
				</tr>
				<tr>
					<td align="center"><input type='text' name='nroproyecto' value='<?=$row['numeroordeninternasap']?>' style="text-align:center" size="8"></td>
					<td align="center">
						<div align="justify">
							<INPUT type="text" name="fechainicio" value='<?=$row['fechainicionumeroordeninternasap']?>' id="fechainicio" style="text-align:center" size="12" readonly> aaaa-mm-dd
							<script type="text/javascript">
								Calendar.setup(	{
									inputField  : "fechainicio",         // ID of the input field
									ifFormat    : "%Y-%m-%d",    // the date format
									onUpdate    : "fechainicio" // ID of the button
								} );
							</script>
						</div>
					</td>
					<td align="center">
						<div align="justify">
							<INPUT type="text" name="fechafin" value='<?=$row['fechavencimientonumeroordeninternasap']?>' id="fechafin" style="text-align:center" size="12" readonly> aaaa-mm-dd
							<script type="text/javascript">
								Calendar.setup( {
									inputField  : "fechafin",         // ID of the input field
									ifFormat    : "%Y-%m-%d",    // the date format
									onUpdate    : "fechafin" // ID of the button
								} );
							</script>
						</div>
					</td>
				</tr>
				<tr align="left">
					<td align="center" id="tdtitulogris" colspan="3">
						<input type="hidden" name="idgrupo" value="<?=$_REQUEST['idgrupo']?>">
						<input type="hidden" name="accion" value="procesar">
						<input type="button" value="<?=$nombre_btn?>" onclick="validar()">
					</td>
				</tr>
			</table>
		</form>
	</body>
</html>
