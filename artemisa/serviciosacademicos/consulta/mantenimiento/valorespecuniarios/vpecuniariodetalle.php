<script language="javascript">
function enviar()
{
	document.vpecuniarios.submit()
}
</script>
<?php 
require_once('../../../Connections/sala2.php');
require_once('../funciones/validacion.php');
require_once('../../../funciones/clases/autenticacion/redirect.php');
?>
<?php
mysql_select_db($database_sala, $sala);
$query_seleccionatipoestudiante = "SELECT codigotipoestudiante, nombretipoestudiante FROM tipoestudiante";
$seleccionatipoestudiante = mysql_query($query_seleccionatipoestudiante, $sala) or die(mysql_error());
$row_seleccionatipoestudiante = mysql_fetch_assoc($seleccionatipoestudiante);
$totalRows_seleccionatipoestudiante = mysql_num_rows($seleccionatipoestudiante);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin t&iacute;tulo</title>
<style type="text/css">
<!--
.Estilo2 {font-family: Tahoma; font-size: 12px; font-weight: bold; }
-->
</style>
</head>

<body>
<form name="vpecuniarios" method="post" action="">

<table width="100%"  border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr>
    <td><table width="100%" border="0" align="center" cellpadding="3" bordercolor="#003333">
      <tr>
        <td width="31%" bgcolor="#CCDADD" class="Estilo2"><div align="center">Tipo Estudiante </div></td>
        <td colspan="2" bgcolor="#FEF7ED" class="Estilo2"><div align="center">
          <select name="codigotipoestudiante" id="codigotipoestudiante" onChange="enviar()">
            <option value="">Seleccionar</option>
            <?php
                  do {
?>
            <option value="<?php echo $row_seleccionatipoestudiante['codigotipoestudiante']?>" <?php if(@$row_seleccionatipoestudiante['codigotipoestudiante'] == $_POST['codigotipoestudiante']) {echo "selected";} ?>><?php echo $row_seleccionatipoestudiante['nombretipoestudiante']?></option>
            <?php
                  } while ($row_seleccionatipoestudiante = mysql_fetch_assoc($seleccionatipoestudiante));
                  $rows = mysql_num_rows($seleccionatipoestudiante);
                  if($rows > 0) {
                  	mysql_data_seek($seleccionatipoestudiante, 0);
                  	$row_seleccionatipoestudiante = mysql_fetch_assoc($seleccionatipoestudiante);
                  }
?>
          </select>
        </div></td>
      </tr>
       <tr>
        <td bgcolor="#CCDADD" class="Estilo2"><div align="center">Concepto:</div></td>
        <td width="38%" bgcolor="#CCDADD" class="Estilo2"><div align="center">Valor:</div></td>
        <td width="31%" bgcolor="#CCDADD" class="Estilo2"><div align="center">Selecci&oacute;n:</div></td>
      </tr>
      <?php 
          if($_GET['masivo']=='si'){
          	$query_mostrar_conceptos="SELECT  v.idvalorpecuniario,v.codigoconcepto,v.valorpecuniario, c.nombreconcepto FROM valorpecuniario v, concepto c WHERE v.codigoconcepto=c.codigoconcepto
			GROUP by nombreconcepto";
          }
          elseif($_GET['masivo']=='no') {
          	$query_seleccionperiodoactivo ="SELECT p.codigoperiodo,p.fechainicioperiodo,p.fechavencimientoperiodo FROM carreraperiodo c, periodo p WHERE p.codigoperiodo = c.codigoperiodo AND c.codigocarrera = '".$_GET['selcodigocarrera']."' AND p.codigoestadoperiodo = '1' and c.codigoestado='100'";
          	$periodoactivo = mysql_query($query_seleccionperiodoactivo, $sala);
          	$row_periodoactivo=mysql_fetch_assoc($periodoactivo);
          	//print_r($row_periodoactivo);
          	$query_mostrar_conceptos="SELECT v.idvalorpecuniario,v.codigoperiodo, v.codigoconcepto, v.valorpecuniario, c.nombreconcepto
		FROM valorpecuniario v, concepto c WHERE v.codigoconcepto=c.codigoconcepto 
		AND v.codigoperiodo='".$row_periodoactivo['codigoperiodo']."'";
          }
          $mostrar_conceptos=mysql_query($query_mostrar_conceptos,$sala);
          //echo $query_mostrar_conceptos;
          if($_GET['masivo']=='no') {
          	while($concepto=mysql_fetch_assoc($mostrar_conceptos)){

          		//$chequear="";

          		echo "
		<tr>
				<td class='Estilo1'>".$concepto['nombreconcepto']."</a>&nbsp;</td>
				<td class='Estilo1'>".$concepto['valorpecuniario']."</a>&nbsp;</td>
				<td class='Estilo1'><div align='center'><input type='checkbox'  name='sel".$concepto['idvalorpecuniario']."' value='".$concepto['idvalorpecuniario']."'></div></td>
		</tr>
	";
          	}
          }
          elseif ($_GET['masivo']=='si')
          {
          	while($concepto=mysql_fetch_assoc($mostrar_conceptos)){

          		//$chequear="";

          		echo "
		<tr>
				<td class='Estilo1'>".$concepto['nombreconcepto']."</a>&nbsp;</td>
				<td class='Estilo1'>".$concepto['valorpecuniario']."</a>&nbsp;</td>
				<td class='Estilo1'><div align='center'><input type='checkbox'  name='sel".$concepto['codigoconcepto']."' value='".$concepto['codigoconcepto']."'></div></td>
		</tr>
	";
          	}

          }
	?>
      <tr>
        <td colspan="3" bgcolor="#CCDADD" class="Estilo2"><div align="center">
          <input name="Grabar" type="submit" id="Grabar" value="Grabar" />
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          <input name="Regresar" type="submit" id="Regresar" value="Regresar" />
        </div></td>
      </tr>
    </table></td>
  </tr>
</table>
</form>
</body>
</html>