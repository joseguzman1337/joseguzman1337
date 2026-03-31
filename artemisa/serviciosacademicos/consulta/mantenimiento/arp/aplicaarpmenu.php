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
?>
<form name="aplicaarp" method="post" action="">
  <table width="60%"  border="0" align="center" cellpadding="3">
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
	<?php if(isset($_POST['modalidadacademica']) or isset($_POST['accion'])){ ?>
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
	<?php } ?>
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
		window.location.reload("aplicaarpinsertar.php?modalidadacademica=<?php echo $_POST['modalidadacademica'];?>");
	}
	if (tipo == 2)
	{
		window.location.reload("aplicaarpmodificar.php?modalidadacademica=<?php echo $_POST['modalidadacademica'];?>");
	}
	if (tipo == 3)
	{
		window.location.reload("aplicaarpconsultar.php?modalidadacademica=<?php echo $_POST['modalidadacademica'];?>");
	}


}
</script>