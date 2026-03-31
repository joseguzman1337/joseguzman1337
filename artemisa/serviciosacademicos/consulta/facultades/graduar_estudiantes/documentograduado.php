<?php @session_start();?>
<?php require_once('../../../Connections/sala2.php'); ?>
<?php
$fechafirmadocumentos=date("Y-m-d H:i:s");
mysql_select_db($database_sala, $sala);
$query_seliddirectivo = "SELECT rf.iddirectivo, concat(nombresdirectivo,' ',apellidosdirectivo) AS nombre FROM directivo d, referenciafirmagrado rf
WHERE rf.iddirectivo=d.iddirectivo 
AND '$fechafirmadocumentos' >= rf.fechainicioreferenciafirmagrado  AND '$fechafirmadocumentos' <= rf.fechafinalreferenciafirmagrado";
$seliddirectivo = mysql_query($query_seliddirectivo, $sala) or die(mysql_error());
//$row_seliddirectivo = mysql_fetch_assoc($seliddirectivo);
$totalRows_seliddirectivo = mysql_num_rows($seliddirectivo);

//echo $query_seliddirectivo;

if(isset($_GET['documento'])){
	$idregistrograduado=$_GET['idregistrograduado'];
?>

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
          <tr class="Estilo2">
            <?php
            while($row_seliddirectivo = mysql_fetch_assoc($seliddirectivo)){

            	$chequear="";
            	$query_verifica_chequeado="select * from documentograduado d where d.idregistrograduado='$idregistrograduado' and d.codigotipodocumentograduado='".$_GET['documento']."' and iddirectivo='".$row_seliddirectivo['iddirectivo']."' and codigoestado='100'";
            	$verifica_chequeado=mysql_query($query_verifica_chequeado,$sala);
            	//echo $query_verifica_chequeado;
            	//  	$verifica_chequeado_detalle=mysql_fetch_assoc($verifica_chequeado);
            	$row_verifica_chequeado=mysql_num_rows($verifica_chequeado);

            	//echo $row_verifica_chequeado;
            	if ($row_verifica_chequeado > 0){$chequear="checked";}
            	echo "
		<tr>
				<td class='Estilo1'>".$row_seliddirectivo['nombre']."</a>&nbsp;</td>
				<td class='Estilo1'>".$row_seliddirectivo['iddirectivo']."</a>&nbsp;</td>
				<td class='Estilo1'><div align='center'><input type='checkbox' name='sel".$row_seliddirectivo['iddirectivo']."'  $chequear value='".$row_seliddirectivo['iddirectivo']."'></div></td>
		</tr>
	";
            }
}
?>
          </tr>
          <tr class="Estilo2">
            <td colspan="3" bgcolor="#C5D5D6"><div align="center">
                <input name="Enviar" type="submit" id="Enviar" value="Enviar" />
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              <input name="Anular" type="submit" id="Anular" value="Anular" />
            </div></td>
          </tr>
      </table></td>
    </tr>
  </table>
</form>
</body>
</html>
<?php 
if(isset($_POST['Enviar']))
{
	$_SESSION["accion"]='Enviar';
	$_SESSION["firmas"]=$_POST;
	if($_GET['documento']=='1'){$_SESSION["diploma"]='OK';}
	if($_GET['documento']=='2'){$_SESSION["acta"]='OK';}
	echo $_SESSION['acta'];
	echo $_SESSION['diploma'];

	echo '<script language="javascript">window.close();</script>';
	echo '<script language="javascript">window.opener.recargar();</script>';
}
?>

<?php 
if(isset($_POST['Anular']))
{
	$_SESSION["accion"]='Anular';
	$_SESSION["firmas"]=$_POST;
	if($_GET['documento']=='1'){$_SESSION["diploma"]='OK';}
	if($_GET['documento']=='2'){$_SESSION["acta"]='OK';}
	echo $_SESSION['acta'];
	echo $_SESSION['diploma'];

	echo '<script language="javascript">window.close();</script>';
	echo '<script language="javascript">window.opener.recargar();</script>';

}
?>
