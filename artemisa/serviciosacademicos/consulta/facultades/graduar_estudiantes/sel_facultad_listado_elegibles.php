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
	document.form1.submit()
}
</script>
<?php
require('../../../Connections/sala2.php');
mysql_select_db($database_sala, $sala);
$query_sel_modalidadacademica = "SELECT * FROM modalidadacademica ORDER BY nombremodalidadacademica ASC";
$sel_modalidadacademica = mysql_query($query_sel_modalidadacademica, $sala) or die(mysql_error());
$row_sel_modalidadacademica = mysql_fetch_assoc($sel_modalidadacademica);
$totalRows_sel_modalidadacademica = mysql_num_rows($sel_modalidadacademica);

$query_sel_facultad = "SELECT * FROM carrera c where codigomodalidadacademica='".$_POST['modalidadacademica']."' order by nombrecarrera asc";
$sel_facultad = mysql_query($query_sel_facultad, $sala) or die(mysql_error());
$row_sel_facultad = mysql_fetch_assoc($sel_facultad);
$totalRows_sel_facultad = mysql_num_rows($sel_facultad);


?>
<style type="text/css">
<!--
.Estilo2 {font-family: Tahoma; font-size: 12px; font-weight: bold;}
-->
</style>
<form name="form1" method="post" action="">

<p align="center"><span class="Estilo3">LISTADO DE ESTUDIANTES ELEGIBLES PARA GRADO POR FACULTAD </span></p>
<table width="58%"  border="2" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
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
    <td bordercolor="#FFFFFF" bgcolor="#CCDADD" class="Estilo2"><div align="center">Facultad</div></td>
    <td bordercolor="#FFFFFF" bgcolor='#FEF7ED'><div align="center"><span class="style2">
      <select name="facultad" id="facultad" onChange="enviar()">
        <option value="">Seleccionar</option>
        <?php
                do {
?>
        <option value="<?php echo $row_sel_facultad['codigocarrera']?>"<?php if(isset($_POST['facultad'])){if($_POST['facultad'] == $row_sel_facultad['codigocarrera']){echo "selected";}}?>><?php echo $row_sel_facultad['nombrecarrera']?></option>
        <?php
                } while ($row_sel_facultad = mysql_fetch_assoc($sel_facultad));
                $rows = mysql_num_rows($sel_facultad);
                if($rows > 0) {
                	mysql_data_seek($sel_facultad, 0);
                	$row_sel_facultad = mysql_fetch_assoc($sel_facultad);
                }
?>
      </select>
    </span>
    </div></td>
  </tr>
  <tr>
    <td colspan="2" bordercolor="#FFFFFF" bgcolor="#CCDADD" class="Estilo2"><div align="center">
      <input name="Enviar" type="submit" id="Enviar" value="Enviar">
    </div></td>
    </tr>
  <?php } ?>
</table>
</form>


<?php
if(isset($_POST['Enviar']))
{
echo '<script language="javascript">window.location.reload("listado_elegibles_grado_facultades.php?facultad='.$_POST['facultad'].'");</script>';
}
if(isset($_POST['Regresar']))
{
echo '<script language="javascript">window.close();</script>';
}

?>