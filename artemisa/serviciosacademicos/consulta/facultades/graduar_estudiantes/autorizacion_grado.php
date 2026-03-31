<script language="javascript">
function Verificacion()
{
if(confirm('La autorización de grado no es reversible. ¿Desea continuar?'))
{
document.form1.submit();
}
else
{

}
}

</script>

<style type="text/css">
<!--
.Estilo1 {font-family: Tahoma; font-size: 12px}
.Estilo2 {font-family: Tahoma; font-size: 12px; font-weight: bold;}
.Estilo3 {font-family: Tahoma; font-size: 14px; font-weight: bold;}
.Estilo4 {color: #FF0000}
-->
</style>
<?php require_once('../../../Connections/sala2.php'); ?>
<?php require('calendario/calendario.php');?>
<?php require('funciones/funcionip.php');?>
<?php 
@session_start();
//print_r($_GET);
//print_r($_SESSION);
$fechaautorizaciongraduado=date("Y-m-d H:i:s");
$direccionipregistrograduado=tomarip();
$usuario=$_SESSION['MM_Username'];
?>

<?php 
$fechaautorizacionregistrograduado=date("Y-m-d H:i:s");

mysql_select_db($database_sala, $sala);
/*$query_seliddirectivo = "SELECT d.iddirectivo,d.idusuario, concat(nombresdirectivo,' ',apellidosdirectivo) AS nombre FROM directivo d, autorizagraduado ag
WHERE ag.iddirectivo=d.iddirectivo
AND '$fechaautorizaciongraduado' >= ag.fechainicioautorizagraduado  AND '$fechaautorizaciongraduado' <= ag.fechafinalautorizagraduado";
//echo $query_seliddirectivo;
$seliddirectivo = mysql_query($query_seliddirectivo, $sala) or die(mysql_error());
$row_seliddirectivo = mysql_fetch_assoc($seliddirectivo);
$totalRows_seliddirectivo = mysql_num_rows($seliddirectivo);
*/
mysql_select_db($database_sala, $sala);
$query_autorizacion = "SELECT * from registrograduado where idregistrograduado='".$_GET['idregistrograduado']."'";
//echo $query_autorizacion;
$autorizacion=mysql_query($query_autorizacion,$sala);
$totalrows_autorizacion=mysql_num_rows($autorizacion);
$row_autorizacion=mysql_fetch_assoc($autorizacion);

mysql_select_db($database_sala, $sala);
$query_selcodigoautorizaciongraduado = "SELECT * FROM autorizacionregistrograduado";
$selcodigoautorizaciongraduado = mysql_query($query_selcodigoautorizaciongraduado, $sala) or die(mysql_error());
$row_selcodigoautorizaciongraduado = mysql_fetch_assoc($selcodigoautorizaciongraduado);
$totalRows_selcodigoautorizaciongraduado = mysql_num_rows($selcodigoautorizaciongraduado);
?>




<script language="JavaScript" src="calendario/javascripts.js"></script>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin t&iacute;tulo</title>
</head>

<body>
<form id="form1" name="form1" method="post" action="">
  <table border="2" align="center" cellpadding="2" bordercolor="#003333">
    <tr>
      <td><table border="0" align="center" cellpadding="0" bordercolor="#003333">
          <tr class="Estilo1">
            <td bgcolor="#C5D5D6" class="Estilo2">Fecha</td>
            <td><?php echo $fechaautorizacionregistrograduado;?>&nbsp;</td>
          </tr>
          <tr class="Estilo2">
            <td bgcolor="#C5D5D6">Directivo</td>
            <td bgcolor="#FFFFFF"><?php if(isset($_GET['nombre'])){echo $_GET['nombre'];}?> &nbsp;</td>
          </tr>
          <tr class="Estilo1">
            <td bgcolor="#C5D5D6" class="Estilo2"><div align="center">Autorizaci&oacute;n Grado<span class="Estilo4">*</span> </div></td>
            <td><select name="codigoautorizacionregistrograduado" id="codigoautorizacionregistrograduado">
			<option value="">Seleccionar</option>
                <?php
                do {
?>
                <option value="<?php echo $row_selcodigoautorizaciongraduado['codigoautorizacionregistrograduado']?>" <?php if($row_autorizacion['codigoautorizacionregistrograduado']==$row_selcodigoautorizaciongraduado['codigoautorizacionregistrograduado']){echo "selected";}?>><?php echo $row_selcodigoautorizaciongraduado['nombreautorizacionregistrograduado']?></option>
                <?php
                } while ($row_selcodigoautorizaciongraduado = mysql_fetch_assoc($selcodigoautorizaciongraduado));
                $rows = mysql_num_rows($selcodigoautorizaciongraduado);
                if($rows > 0) {
                	mysql_data_seek($selcodigoautorizaciongraduado, 0);
                	$row_selcodigoautorizaciongraduado = mysql_fetch_assoc($selcodigoautorizaciongraduado);
                }
?>
              </select>            </td>
          </tr>
          <tr class="Estilo1">
            <td colspan="2" bgcolor="#C5D5D6" class="Estilo2"><div align="center">
                <input name="Grabar" type="button" id="Grabar" value="Grabar" onClick="Verificacion()" />
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              <input name="Cancelar" type="submit" id="Cancelar" value="Cancelar" />
            </div></td>
          </tr>
      </table></td>
    </tr>
  </table>
</form>
</body>
</html>




<?php
if(isset($_POST['Cancelar']))
{
	echo '<script language="javascript">window.close();</script>';
}
//if(isset($_POST['Grabar'])){
	if($totalrows_autorizacion==1)
	{
		$query_autorizar="update registrograduado set iddirectivo='".$_GET['iddirectivo']."', fechaautorizacionregistrograduado='$fechaautorizacionregistrograduado',
	codigoautorizacionregistrograduado='".$_POST['codigoautorizacionregistrograduado']."'
	where idregistrograduado='".$_GET['idregistrograduado']."'";
		//echo $query_autorizar;
		$autorizar=mysql_query($query_autorizar,$sala);
		if($_POST['codigoautorizacionregistrograduado']==100)
		{
			$query_cambioestado_graduado="update estudiante set codigosituacioncarreraestudiante='400' where codigoestudiante='".$row_autorizacion['codigoestudiante']."'";
			$cambioestado_graduado=mysql_query($query_cambioestado_graduado,$sala) or die (mysql_error());
		}
		elseif($_POST['codigoautorizacionregistrograduado']==200)
		{
			$query_cambioestado_egresado="update estudiante set codigosituacioncarreraestudiante='104' where codigoestudiante='".$row_autorizacion['codigoestudiante']."'";
			$cambioestado_egresado=mysql_query($query_cambioestado_egresado,$sala) or die (mysql_error());
		}

		if($autorizar and ($cambioestado_graduado or $cambioestado_egresado))
		{
			$query_ingresardatos_log_autorizacion=
			"
	insert into logregistrograduado
	values
	(
	'',
	'".$row_autorizacion['idregistrograduado']."',
	'".$row_autorizacion['codigoestudiante']."',
	'".$row_autorizacion['numeropromocion']."',
	'$fechaautorizaciongraduado',
	'".$row_autorizacion['numeroacuerdoregistrograduado']."',
	'".$row_autorizacion['fechaacuerdoregistrograduado']."',
	'".$row_autorizacion['responsableacuerdoregistrograduado']."',
	'".$row_autorizacion['numeroactaregistrograduado']."',
	'".$row_autorizacion['fechaactaregistrograduado']."',
	'".$row_autorizacion['numerodiplomaregistrograduado']."',
	'".$row_autorizacion['fechadiplomaregistrograduado']."',
	'".$row_autorizacion['fechagradoregistrograduado']."',
	'".$row_autorizacion['lugarregistrograduado']."',
	'".$row_autorizacion['presidioregistrograduado']."',
	'".$row_autorizacion['observacionregistrograduado']."',
	'100',
	'".$row_autorizacion['codigotiporegistrograduado']."',
	'$direccionipregistrograduado',
	'$usuario',
	'".$_GET['iddirectivo']."',
	'".$_POST['codigoautorizacionregistrograduado']."',
	'$fechaautorizaciongraduado',
	'216',
	'".$row_autorizacion['idtipogrado']."'
	)
	";
			//echo $query_ingresardatos_log_autorizacion;
			$ingresardatos_log_autorizacion=mysql_query($query_ingresardatos_log_autorizacion,$sala);
			if($ingresardatos_log_autorizacion){echo '
			<script language="javascript">window.opener.recargar();</script>;
			<script language="javascript">window.close();</script>';}
			else{echo mysql_error(),$query_ingresardatos_log_autorizacion;}

		}
		else
		{
			echo $query_autorizar, mysql_error();
		}
	}
//}
?>