<style type="text/css">
<!--
.Estilo1 {font-family: Tahoma; font-size: 12px}
.Estilo2 {font-family: Tahoma; font-size: 12px; font-weight: bold;}
.Estilo3 {font-family: Tahoma; font-size: 14px; font-weight: bold;}
.Estilo4 {color: #FF0000}
-->
</style>
<?php @session_start();?>
<?php require_once('../../../Connections/sala2.php'); ?>
<?php
unset($array_eliminar);
unset($array_actualizar);
$fechafirmadocumentos=date("Y-m-d H:i:s");
$carrera=$_GET['carrera'];
mysql_select_db($database_sala, $sala);
$query_seliddirectivo = "SELECT rf.iddirectivo, concat(apellidosdirectivo,' ',nombresdirectivo) AS nombre FROM directivo d, referenciafirmagrado rf
WHERE d.codigotipodirectivo='100' AND rf.iddirectivo=d.iddirectivo 
AND '$fechafirmadocumentos' >= rf.fechainicioreferenciafirmagrado  AND '$fechafirmadocumentos' <= rf.fechafinalreferenciafirmagrado
AND (d.codigocarrera = '1' or d.codigocarrera='$carrera') order by nombre
";
$seliddirectivo = mysql_query($query_seliddirectivo, $sala) or die(mysql_error());
$totalRows_seliddirectivo = mysql_num_rows($seliddirectivo);


//echo $query_seliddirectivo;

if(isset($_GET['documento'])){
	$idregistrograduado=$_GET['idregistrograduado'];
	$query_buscaacta="select * from documentograduado where idregistrograduado='".$_GET['idregistrograduado']."' and codigoestado='100' and codigotipodocumentograduado='2'";
	$buscaacta=mysql_query($query_buscaacta,$sala) or die(mysql_error());
	$totalrows_buscaacta=mysql_num_rows($buscaacta);
	$row_buscaacta=mysql_fetch_assoc($buscaacta);
	//echo $totalrows_buscaacta;


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
            	$query_verifica_chequeado="select * from documentograduado d where d.idregistrograduado='$idregistrograduado' and d.codigotipodocumentograduado='2' and iddirectivo='".$row_seliddirectivo['iddirectivo']."' and codigoestado='100'";
            	$verifica_chequeado=mysql_query($query_verifica_chequeado,$sala) or die(mysql_error());
            	//echo $query_verifica_chequeado;
            	//  	$verifica_chequeado_detalle=mysql_fetch_assoc($verifica_chequeado);
            	$row_verifica_chequeado=mysql_num_rows($verifica_chequeado);
            	$verificacion=mysql_fetch_assoc($verifica_chequeado);
            	$arraybd[]=$verificacion['iddirectivo'];


            	//echo $row_verifica_chequeado;
            	if ($row_verifica_chequeado > 0){$chequear="checked";}
            	echo "
		<tr>
				<td class='Estilo1'>".$row_seliddirectivo['nombre']."</a>&nbsp;</td>
				<td class='Estilo1'><div align='center'><input type='checkbox' name='sel".$row_seliddirectivo['iddirectivo']."'  $chequear value='".$row_seliddirectivo['iddirectivo']."'></div></td>
		</tr>
	";
            }

}
?>
          </tr>
          <tr class="Estilo2">
            <td colspan="2" bgcolor="#C5D5D6"><div align="center">
                <input name="Enviar" type="submit" id="Enviar" value="Enviar" />
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
	if($totalrows_buscaacta==0){
		$_SESSION["accion"]='Enviar';
		$_SESSION["acta"]=$_POST;

		echo '<script language="javascript">window.close();</script>';
		/*echo '<script language="javascript">window.opener.recargar();</script>';*/
	}
	else{
		foreach($_POST as $vpost => $valor)
		{
			if (ereg("sel",$vpost))
			{
				$iddirectivo = $_POST[$vpost];
				$arraypost[]=$iddirectivo;
			}
		}
		//print_r($arraybd);echo "<br>";
		//print_r($arraypost);

		if(isset($arraypost) and isset($arraybd))
		{

			$array_eliminar=array_diff($arraybd,$arraypost); //elimina los chulitos deseleccionados
			$array_actualizar=array_diff($arraypost,$arraybd);//pone los chulitos seleccionados

			foreach ($array_eliminar as $eliminacion => $valeliminar){
				$iddirectivo = $array_eliminar[$eliminacion];
				//echo "update",$iddirectivo;
				$query_anular_documentograduado_acta="update documentograduado set codigoestado='200' where idregistrograduado='$idregistrograduado' and iddirectivo='$iddirectivo' and codigotipodocumentograduado='2'";
				$anular_documentograduado_acta=mysql_query($query_anular_documentograduado_acta,$sala);
				$query_log_anular_documentograduado_acta="insert into logdocumentograduado values ('','".$row_buscaacta['iddocumentograduado']."','1','$iddirectivo','200','2','1')";
				//echo $query_log_anular_documentograduado_acta;
				$log_anular_documentograduado_acta=mysql_query($query_log_anular_documentograduado_acta,$sala);
			}
			if($anular_documentograduado_acta or $log_anular_documentograduado_acta){echo '<script language="javascript">window.close();</script>';echo '<script language="javascript">window.opener.recargar();</script>';}

			foreach ($array_actualizar as $actualizacion => $valactualizar){
				$iddirectivo = $array_actualizar[$actualizacion];
				//echo "insert",$iddirectivo;
				$query_insertar_documentograduado_acta="insert into documentograduado values ('','$idregistrograduado','1','$iddirectivo','100','2','1')";
				$insertar_documentograduado_acta=mysql_query($query_insertar_documentograduado_acta,$sala);
				$iddocumentograduado=mysql_insert_id();
				//echo $iddocumentograduado;
				$query_log_insertar_documentograduado_acta="insert into logdocumentograduado values ('','$iddocumentograduado','1','$iddirectivo','100','2','1')";
				$query_log_insertar_documentograduado_acta;
				$log_insertar_documentograduado_acta=mysql_query($query_log_insertar_documentograduado_acta,$sala);
			}
			if($insertar_documentograduado_acta and $log_insertar_documentograduado_acta ){echo '<script language="javascript">window.close();</script>';echo '<script language="javascript">window.opener.recargar();</script>';}
		}
		elseif(@$arraypost==0)
		{
			$query_anular_documentograduado_acta="update documentograduado set codigoestado='200' where idregistrograduado='$idregistrograduado' and codigotipodocumentograduado='2'";
			$anular_documentograduado_acta=mysql_query($query_anular_documentograduado_acta,$sala);
			if($anular_documentograduado_acta){echo '<script language="javascript">window.close();</script>';echo '<script language="javascript">window.opener.recargar();</script>';}
		}
	}
}
?>


