<?php require_once('../../../../Connections/conexion.php');session_start();?>
<style type="text/css">
<!--
.Estilo1 {font-family: Tahoma; font-size: 12px}
.Estilo2 {font-family: Tahoma; font-size: 12px; font-weight: bold;}
.Estilo3 {font-family: Tahoma; font-size: 14px; font-weight: bold;}
.Estilo4 {font-family: Tahoma; font-size: 12px; font-weight: bold; color: #FF0000}
-->
</style>
<?php
       $base= "select * from lengua where idlengua = '".$_GET['modificar']."'";
       $sol=mysql_db_query("hojavida",$base);
	   $totalRows = mysql_num_rows($sol);
       $row=mysql_fetch_array($sol); 
      
?>


<?php
mysql_select_db($database_conexion, $conexion);
$query_Recordset1 = "SELECT * FROM idioma";
$Recordset1 = mysql_query($query_Recordset1, $conexion) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>
<form name="form1" method="post" action="modificaridioma.php"><div align="center">
  <p><span class="Estilo3">MODIFICACI&Oacute;N DE DATOS</span><br>
      <br>
  </strong>
      <?php
	
   
   if (($_POST['codigoidioma'] == 0)or($_POST['hablalengua'] == "") or ($_POST['leelengua'] == "")or ($_POST['escribelengua'] == ""))
   {
     echo  "<h5><font size='2' face='Tahoma'><strong>Recuerde que los campos con <span class='Estilo4'>*</span> son obligatorios</h5>";
   }
else 
     {
     require_once('modificaridioma1.php');
	 exit();
     }

    ?>
    </span></span></p>
    <table width="310" border="1" cellpadding="1" cellspacing="2" bordercolor="#003333">
      <tr>
        <td width="173" bgcolor="#C5D5D6" class="Estilo2">&nbsp; Idioma<span class="Estilo4"> *</span></td>
        <td class="Estilo1"><select name="codigoidioma" id="codigoidioma">
            <option value="value" <?php if (!(strcmp("value", $row ['codigoidioma']))) {echo "SELECTED";} ?>>Seleccionar</option>
            <?php
do {  
?>
            <option value="<?php echo $row_Recordset1['codigoidioma']?>"<?php if (!(strcmp($row_Recordset1['codigoidioma'], $row ['codigoidioma']))) {echo "SELECTED";} ?>><?php echo $row_Recordset1['nombreidioma']?></option>
            <?php
} while ($row_Recordset1 = mysql_fetch_assoc($Recordset1));
  $rows = mysql_num_rows($Recordset1);
  if($rows > 0) {
      mysql_data_seek($Recordset1, 0);
	  $row_Recordset1 = mysql_fetch_assoc($Recordset1);
  }
?>
                </select></td>
      </tr>
      <tr>
        <td bgcolor="#C5D5D6" class="Estilo2">&nbsp; Nivel de conversaci&oacute;n<strong><span class="Estilo4"> *</span></strong></td>
        <td class="Estilo1"><span class="style11">
          <select name="hablalengua" id="hablalengua">
            <option value="" <?php if (!(strcmp("", $row['hablalengua']))) {echo "SELECTED";} ?>>Seleccionar</option>
            <option value="Nulo" <?php if (!(strcmp("Nulo", $row['hablalengua']))) {echo "SELECTED";} ?>>Nulo</option>
            <option value="Basico" <?php if (!(strcmp("Basico", $row['hablalengua']))) {echo "SELECTED";} ?>>Basico</option>
            <option value="Intermedio" <?php if (!(strcmp("Intermedio", $row['hablalengua']))) {echo "SELECTED";} ?>>Intermedio</option>
            <option value="Avanzado" <?php if (!(strcmp("Avanzado", $row['hablalengua']))) {echo "SELECTED";} ?>>Avanzado</option>
            <option value="Dominio Completo" <?php if (!(strcmp("Dominio Completo", $row['hablalengua']))) {echo "SELECTED";} ?>>Dominio Completo</option>
          </select>
        </span></td>
      </tr>
      <tr>
        <td bgcolor="#C5D5D6" class="Estilo2">&nbsp; Nivel de lectura<strong><span class="Estilo4"> *</span></strong></td>
        <td class="Estilo1"><span class="style11">
          <select name="leelengua" id="select3">
            <option value="" <?php if (!(strcmp("", $row['leelengua']))) {echo "SELECTED";} ?>>Seleccionar</option>
            <option value="Nulo" <?php if (!(strcmp("Nulo", $row['leelengua']))) {echo "SELECTED";} ?>>Nulo</option>
            <option value="Basico" <?php if (!(strcmp("Basico", $row['leelengua']))) {echo "SELECTED";} ?>>Basico</option>
            <option value="Intermedio" <?php if (!(strcmp("Intermedio", $row['leelengua']))) {echo "SELECTED";} ?>>Intermedio</option>
            <option value="Avanzado" <?php if (!(strcmp("Avanzado", $row['leelengua']))) {echo "SELECTED";} ?>>Avanzado</option>
            <option value="Dominio Completo" <?php if (!(strcmp("Dominio Completo", $row['leelengua']))) {echo "SELECTED";} ?>>Dominio Completo</option>
          </select>
        </span></td>
      </tr>
      <tr>
        <td bgcolor="#C5D5D6" class="Estilo2">&nbsp; Nivel de redacci&oacute;n<strong><span class="Estilo4"> *</span></strong></td>
        <td class="Estilo1"><span class="style11">
        <select name="escribelengua" id="select5">
          <option value="" <?php if (!(strcmp("", $row['escribelengua']))) {echo "SELECTED";} ?>>Seleccionar</option>
          <option value="Nulo" <?php if (!(strcmp("Nulo", $row['escribelengua']))) {echo "SELECTED";} ?>>Nulo</option>
          <option value="Basico" <?php if (!(strcmp("Basico", $row['escribelengua']))) {echo "SELECTED";} ?>>Basico</option>
          <option value="Intermedio" <?php if (!(strcmp("Intermedio", $row['escribelengua']))) {echo "SELECTED";} ?>>Intermedio</option>
          <option value="Avanzado" <?php if (!(strcmp("Avanzado", $row['escribelengua']))) {echo "SELECTED";} ?>>Avanzado</option>
          <option value="Dominio Completo" <?php if (!(strcmp("Dominio Completo", $row['escribelengua']))) {echo "SELECTED";} ?>>Dominio Completo</option>
        </select>
</span></td>
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
<p>
  <?php
mysql_free_result($Recordset1);
?>
</p>


