<?php require_once('../../../../Connections/conexion.php');session_start();?>
<style type="text/css">
<!--
.Estilo2 {font-family: Tahoma; font-size: 12px; font-weight: bold; }
.Estilo3 {
	font-family: Tahoma;
	font-size: 14px;
	font-weight: bold;
}
.Estilo4 {font-family: Tahoma; font-size: 12px; font-weight: bold; color: #FF0000}
-->
</style>
<?php
       $base= "select * from condecoracion where idcondecoracion = '".$_GET['modificar']."'";
       $sol=mysql_db_query("hojavida",$base);
	   $totalRows = mysql_num_rows($sol);
       $row=mysql_fetch_array($sol); 
      
?>
<?php
mysql_select_db($database_conexion, $conexion);
$query_Recordset1 = "SELECT * FROM tipocondecoracion";
$Recordset1 = mysql_query($query_Recordset1, $conexion) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

       $base= "select * from condecoracion where idcondecoracion = '".$_GET['modificar']."'";
       $sol=mysql_db_query("hojavida",$base);
	   $totalRows = mysql_num_rows($sol);
       $row=mysql_fetch_array($sol); 
      
?>
<form name="form1" method="post" action="modificarcondecoracion.php"><div align="center">
<p><span class="Estilo3">MODIFICACI&Oacute;N DE DATOS </span><span class="Estilo2"><strong><br>
      </strong>
      <?php
	
	$fecha=date("Y-n-j",time());
   if (($_POST['nombrecondecoracion'] == "")or($_POST['institucioncondecoracion'] == "")or ($_POST['codigotipocondecoracion'] == 0))
   {
     echo  "<h5>Recuerde que los campos con <span class='Estilo4'>*</span> son obligatorios</h5>";
   }
else 
     {
     require_once('modificarcondecoracion1.php');
	 exit();
     }

    ?>
            </span> </p>
    <table width="500" border="1" cellpadding="1" cellspacing="2" bordercolor="#003333">
      <tr>
        <td width="160" bgcolor="#C5D5D6" class="Estilo2">&nbsp; Nombre del Premio <span class="Estilo4">*</span> </strong></td>
        <td width="314" class="style3"><input name="nombrecondecoracion" type="text" id="nombrecondecoracion" value="<?php echo $row['nombrecondecoracion'];?>" size="40"></td>
      </tr>
      <tr>
        <td bgcolor="#C5D5D6" class="Estilo2">&nbsp; Instituci&oacute;n <span class="Estilo4">*</span> </strong></td>
        <td class="style3"><input name="institucioncondecoracion" type="text" id="institucioncondecoracion" value="<?php  echo $row['institucioncondecoracion'] ;?>" size="40">
        <?php  $ano=date("Y",strtotime($row['fechacondecoracion']));
			       $mes=date("m",strtotime($row['fechacondecoracion']));
			       $dia=date("d",strtotime($row['fechacondecoracion']));
			?></td>
      </tr>
      <tr>
        <td width="160" bgcolor="#C5D5D6" class="Estilo2">&nbsp; Tipo de Premio <span class="Estilo4">*</span> </strong></td>
        <td width="314" class="style3"><select name="codigotipocondecoracion" id="codigotipocondecoracion">
          <option value="value" <?php if (!(strcmp("value", $row['codigotipocondecoracion']))) {echo "SELECTED";} ?>>Seleccionar</option>
          <?php
do {  
?>
          <option value="<?php echo $row_Recordset1['tipocondecoracion']?>"<?php if (!(strcmp($row_Recordset1['tipocondecoracion'], $row['codigotipocondecoracion']))) {echo "SELECTED";} ?>><?php echo $row_Recordset1['nombretipocondecoracion']?></option>
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
mysql_free_result($Recordset1);
?>
