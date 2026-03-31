<style type="text/css">
<!--
.Estilo1 {font-family: Tahoma; font-size: 12px}
.Estilo2 {font-family: Tahoma; font-size: 12px; font-weight: bold; }
.Estilo3 {font-family: Tahoma; font-size: 14px; font-weight: bold;}
.Estilo4 {color: #FF0000}
-->
</style>
<script language="javascript">
function enviar()
{
	document.aplicaarp.submit()
}
</script>
<?php 
//print_r($_POST);
require_once('../../../Connections/sala2.php');
require_once('../../../funciones/clases/autenticacion/redirect.php'); 

mysql_select_db($database_sala, $sala);
$query_sel_modalidadacademica = "SELECT * FROM modalidadacademica ORDER BY nombremodalidadacademica ASC";
$sel_modalidadacademica = mysql_query($query_sel_modalidadacademica, $sala) or die(mysql_error());
$row_sel_modalidadacademica = mysql_fetch_assoc($sel_modalidadacademica);
$totalRows_sel_modalidadacademica = mysql_num_rows($sel_modalidadacademica);

$query_periodo="SELECT codigoperiodo from periodo P
ORDER BY codigoperiodo DESC
";
$periodo=mysql_query($query_periodo) or die($query_periodo.mysql_error());
$row_periodo=mysql_fetch_assoc($periodo);
?>
<form name="aplicaarp" method="post" action="">
  <p align="center" class="Estilo3">ARP - MENU PRINCIPAL </p>
  <table width="58%"  border="2" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
    <tr>
      <td bordercolor="#FFFFFF" bgcolor="#CCDADD" class="Estilo2"><div align="center">Periodo</div></td>
      <td bordercolor="#FFFFFF" bgcolor='#FEF7ED'><div align="center">
        <select name="codigoperiodo" id="codigoperiodo" onChange="enviar()">
		<option value="">Seleccionar</option>
		<?php do{ ?>
		<option value="<?php echo $row_periodo['codigoperiodo'];?>"<?php if($_POST['codigoperiodo']==$row_periodo['codigoperiodo']){echo "Selected";}?>><?php echo $row_periodo['codigoperiodo'];?></option>
        <?php } while($row_periodo=mysql_fetch_assoc($periodo));?>
		</select>
      </div></td>
    </tr>
    <tr>
      <td width="51%" bordercolor="#FFFFFF" bgcolor="#CCDADD" class="Estilo2"><div align="center">Modalidad Acad&eacute;mica</div></td>
      <td width="49%" bordercolor="#FFFFFF" bgcolor='#FEF7ED'><p align="center" class="style2">
          <select name="modalidadacademica" id="modalidadacademica" onChange="enviar()">
            <option value="">Seleccionar</option>
            <?php
            do {
?>
            <option value="<?php echo $row_sel_modalidadacademica['codigomodalidadacademica']?>"<?php if(isset($_POST['modalidadacademica'])){if($_POST['modalidadacademica'] == $row_sel_modalidadacademica['codigomodalidadacademica']){echo "selected";}}?>><?php echo $row_sel_modalidadacademica['nombremodalidadacademica']?></option>
            <?php
            } while ($row_sel_modalidadacademica = mysql_fetch_assoc($sel_modalidadacademica));
            $rows = mysql_num_rows($sel_modalidadacademica);
            if($rows > 0) {
            	mysql_data_seek($sel_modalidadacademica, 0);
            	$row_sel_modalidadacademica = mysql_fetch_assoc($sel_modalidadacademica);
            }
?>
          </select>
      </p></td>
    </tr>
	<?php if(isset($_POST['codigoperiodo']) and $_POST['codigoperiodo']!="" and isset($_POST['modalidadacademica']) and $_POST['modalidadacademica']!=""){?>
    <tr>
      <td bordercolor="#FFFFFF" bgcolor="#CCDADD" class="Estilo2"><div align="center">Acci&oacute;n</div></td>
      <td bordercolor="#FFFFFF" bgcolor='#FEF7ED'><div align="center">
          <select name="tipo" id="tipo" onChange="cambia_tipo()">
            <option>Seleccionar</option>
            <option value="1">Insertar registros</option>
            <option value="2">Modificar registros</option>
            <option value="3">Consultar Registros</option>
          </select>
      </div></td>
    </tr>
<?php }?>
  </table>
</form>
<script language="javascript">
function cambia_tipo()
{
	//tomo el valor del select del tipo elegido
	var tipo
	tipo = document.aplicaarp.tipo[document.aplicaarp.tipo.selectedIndex].value
	//miro a ver si el tipo está definido
	if (tipo == 1)
	{
		window.location.reload("aplicaarpinsertar.php?codigoperiodo=<?php echo $_POST['codigoperiodo']?>&modalidadacademica=<?php echo $_POST['modalidadacademica'];?>");
	}
	if (tipo == 2)
	{
		window.location.reload("aplicaarpmodificar.php?codigoperiodo=<?php echo $_POST['codigoperiodo']?>&modalidadacademica=<?php echo $_POST['modalidadacademica'];?>");
	}
	if (tipo == 3)
	{
		window.location.reload("aplicaarpconsultar.php?codigoperiodo=<?php echo $_POST['codigoperiodo']?>&modalidadacademica=<?php echo $_POST['modalidadacademica'];?>");
	}
}
</script>
