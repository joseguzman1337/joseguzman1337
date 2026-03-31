<?php require_once('../../../../Connections/conexion.php');session_start();?>
<?php
       $base= "select * from investigacion where idinvestigacion = '".$_GET['modificar']."'";
       $sol=mysql_db_query($database_conexion,$base);
	   $totalRows = mysql_num_rows($sol);
       $row=mysql_fetch_array($sol);      
?>

<?php
	mysql_select_db($database_conexion, $conexion);
	$query_Recordset2 = "SELECT * FROM tipoinvestigacion";
	$Recordset2 = mysql_query($query_Recordset2, $conexion) or die(mysql_error());
	$row_Recordset2 = mysql_fetch_assoc($Recordset2);
	$totalRows_Recordset2 = mysql_num_rows($Recordset2);
?>
<style type="text/css">
<!--
.Estilo1 {font-family: Tahoma; font-size: 12px}
.Estilo2 {font-family: Tahoma; font-size: 12px; font-weight: bold;}
.Estilo3 {font-family: Tahoma; font-size: 14px; font-weight: bold;}
.Estilo4 {color: #FF0000}
-->
</style>
<form name="form1" method="post" action="modificarinvestigacion.php"><div align="center">
<p><strong><span class="Estilo3">MODIFICACI&Oacute;N DE DATOS</span><br>
      <span class="Estilo2"><br>
      </span></strong>
      <span class="Estilo2">
    <?php
   if (($_POST['tituloinvestigacion'] == "") or ($_POST['unidadtiempoinvestigacion'] == "")or ($_POST['tiempoinvestigacion'] == "")or ($_POST['liderinvestigacion'] == "")or ($_POST['cantidadinvestigadores'] == "")or ($_POST['codigotipoinvestigacion'] == 0))
   {
     echo  "<h5>Recuerde que los campos con <span class='Estilo4'>*</span> son obligatorios</h5>";
   }
else 
     {
     require_once('modificarinvestigacion1.php');
	 exit();
     }

    ?>
    </span></span></span></p>
    <table width="500" border="1" cellpadding="1" cellspacing="2" bordercolor="#003333">
      <tr>
        <td bgcolor="#C5D5D6" class="Estilo2">&nbsp; Titulo Investigaci&oacute;n o Invento <span class="Estilo4">*</span></strong></td>
        <td width="240" class="Estilo1"><input name="tituloinvestigacion" type="text" id="tituloinvestigacion" value="<?php echo $row['tituloinvestigacion'];?>" size="40"></td>
      </tr>
      <tr>
        <td bgcolor="#C5D5D6" class="Estilo2">&nbsp; Instituci&oacute;n</td>
        <td class="Estilo1"><input name="institucioninvestigacion" type="text" id="institucioninvestigacion" value="<?php echo $row['institucioninvestigacion'];?>" size="40"></td>
      </tr>
      <tr>
        <td bgcolor="#C5D5D6" class="Estilo2">&nbsp; Entidad de Financiamiento</td>
        <td class="Estilo1"><input name="entidadfinanciamientoinvestigacion" type="text" id="entidadfinanciamientoinvestigacion" value="<?php echo $row['entidadfinanciamientoinvestigacion'];?>" size="40"></td>
      </tr>
      <tr>
        <td bgcolor="#C5D5D6" class="Estilo2">&nbsp; Tiempo Investigaci&oacute;n o Invento <span class="Estilo4">*</span></strong></strong></td>
        <td class="Estilo1"><span class="style11">
          <input name="unidadtiempoinvestigacion" type="text" id="unidadtiempoinvestigacion" value="<?php echo $row['unidadtiempoinvestigacion'];?>" size="1">
          <select name="tiempoinvestigacion" id="tiempoinvestigacion">
            <option value="" <?php if (!(strcmp("", $row['tiempoinvestigacion']))) {echo "SELECTED";} ?>>Seleccionar</option>
            <option value="Horas" <?php if (!(strcmp("Horas", $row['tiempoinvestigacion']))) {echo "SELECTED";} ?>>Horas</option>
            <option value="Dias" <?php if (!(strcmp("Dias", $row['tiempoinvestigacion']))) {echo "SELECTED";} ?>>Dias</option>
            <option value="Semanas" <?php if (!(strcmp("Semanas", $row['tiempoinvestigacion']))) {echo "SELECTED";} ?>>Semanas</option>
            <option value="Meses" <?php if (!(strcmp("Meses", $row['tiempoinvestigacion']))) {echo "SELECTED";} ?>>Meses</option>
            <option value="A&ntilde;os"Años <?php if (!(strcmp("Años", $row['tiempoinvestigacion']))) {echo "SELECTED";} ?>>A&ntilde;os</option>
          </select>
        </span></td>
      </tr>
      <tr>
        <td bgcolor="#C5D5D6" class="Estilo2">&nbsp; L&iacute;der Investigaci&oacute;n <strong>o Invento</strong><strong> <span class="Estilo4">*</span></strong></strong></td>
        <td class="Estilo1"><input name="liderinvestigacion" type="text" id="liderinvestigacion" value="<?php echo $row['liderinvestigacion'];?>" size="40"></td>
      </tr>
      <tr>
        <td bgcolor="#C5D5D6" class="Estilo2">&nbsp; Cantidad de Investigadores<strong> <span class="Estilo4">*</span></strong></strong></td>
        <td class="Estilo1"><input name="cantidadinvestigadores" type="text" id="cantidadinvestigadores" value="<?php echo $row['cantidadinvestigadores'];?>" size="8"></td>
      </tr>
      <tr>
        <td bgcolor="#C5D5D6" class="Estilo2">&nbsp; Tipo de Investigaci&oacute;n <strong>o Invento</strong><strong> <span class="Estilo4">*</span></strong></strong></td>
        <td class="Estilo1"><select name="codigotipoinvestigacion" id="codigotipoinvestigacion">
          <option value="value" <?php if (!(strcmp("value", $row['codigotipoinvestigacion']))) {echo "SELECTED";} ?>>Seleccionar</option>
          <?php
do {  
?>
          <option value="<?php echo $row_Recordset2['codigotipoinvestigacion']?>"<?php if (!(strcmp($row_Recordset2['codigotipoinvestigacion'], $row['codigotipoinvestigacion']))) {echo "SELECTED";} ?>><?php echo $row_Recordset2['nombretipoinvestigacion']?></option>
          <?php
} while ($row_Recordset2 = mysql_fetch_assoc($Recordset2));
  $rows = mysql_num_rows($Recordset2);
  if($rows > 0) {
      mysql_data_seek($Recordset2, 0);
	  $row_Recordset2 = mysql_fetch_assoc($Recordset2);
  }
?>
        </select></td>
      </tr>
    </table>
    <p class="style3">
      <input name="modificar" type="hidden" value="<?php echo $_GET['modificar']; ?>">
    </p>
    </div>
  <p align="center">
    <span class="style3">
    <input type="submit" name="Submit" value="Modificar">
    </span> </p>
</form>

<?php
mysql_free_result($Recordset2);
?>
