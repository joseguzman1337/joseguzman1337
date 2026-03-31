<?php require_once('../../../../Connections/conexion.php');session_start();?>
<?php
mysql_select_db($database_conexion, $conexion);
$query_Recordset1 = "SELECT * FROM dia";
$Recordset1 = mysql_query($query_Recordset1, $conexion) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>
<?php
       $base= "select * from detallejornadalaboral where (iddetallejornadalaboral = '".$_GET['modificar']."')";
       $sol=mysql_db_query($database_conexion,$base);
	   $totalRows = mysql_num_rows($sol);
       $row=mysql_fetch_array($sol); 
      
?>
<style type="text/css">
<!--
.Estilo1 {
	font-size: 12px;
	font-family: Tahoma;
}
.Estilo2 {font-size: 14px}
.Estilo3 {color: #FF0000}
-->
</style>
<body class="Estilo1">
<form name="form1" method="post" action="">
  <p align="center" class="Estilo2"><strong>MODIFICACI&Oacute;N DE DATOS</strong></p>
  <div align="center">
    <span class="Estilo1">
    <?php	
  
   if (($_POST['ubicaciondetallejornadalaboral'] == "")or($_POST['codigodia'] == "")or($_POST['horainicialdetallejornadalaboral'] == "")or($_POST['horafinaldetallejornadalaboral'] == ""))
   {       
    echo  "<h5>Recuerde que los campos con <span class='Estilo4'>*</span> son obligatorios</h5>";
   }
else
  if (! checkdate($_POST['horainicialdetallejornadalaboral'],1,1)or(! checkdate($_POST['horafinaldetallejornadalaboral'],1,1))){ 
      echo "<h5>La hora no es correcta</h5>";
   }    
else 
	 {
     require_once('modificardetallejornadalaboral1.php');
	 exit();
     }
	
	?>
  </span></div>
  </p>
  <table border="1" align="center" cellpadding="1" cellspacing="2" bordercolor="#003333">
    <tr>
      <td height="30" bgcolor="#C5D5D6" class="Estilo1"><strong>&nbsp; Ubicaci&oacute;n UB &oacute; Ext. (Sede/Salon)<strong> <span class="Estilo3">*</span></strong></strong></td>
      <td><input name="ubicaciondetallejornadalaboral" type="text" id="ubicaciondetallejornadalaboral" value="<?php  echo  $row['ubicaciondetallejornadalaboral']; ?>" size="40">        </td>
    </tr>
    <tr>
      <td bgcolor="#C5D5D6" class="Estilo1"><strong>&nbsp; Dia <span class="Estilo3">*</span></strong></td>
      <td><select name="codigodia" id="codigodia">
        <option value="" <?php if (!(strcmp("", $row['codigodia']))) {echo "SELECTED";} ?>>Seleccionar</option>
        <?php
do {  
?>
        <option value="<?php echo $row_Recordset1['codigodia']?>"<?php if (!(strcmp($row_Recordset1['codigodia'], $row['codigodia']))) {echo "SELECTED";} ?>><?php echo $row_Recordset1['nombredia']?></option>
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
      <td bgcolor="#C5D5D6" class="Estilo1"><strong>&nbsp; Hora inicio<strong> <span class="Estilo3">*</span></strong></strong></td>
      <td><input name="horainicialdetallejornadalaboral" type="text" id="horainicialdetallejornadalaboral" value="<?php echo  $row['horainicialdetallejornadalaboral'] ?>" size="5">
        <select name="empezar" id="empezar">
          <option value="AM" <?php if (!(strcmp("AM", $row['meridianohorainicialdetallejornadalaboral']))) {echo "SELECTED";} ?>>AM</option>
          <option value="PM" <?php if (!(strcmp("PM", $row['meridianohorainicialdetallejornadalaboral']))) {echo "SELECTED";} ?>>PM</option>
        </select>
        <span class="Estilo1">HH:MM</span></td>
    </tr>
    <tr>
      <td bgcolor="#C5D5D6" class="Estilo1"><strong>&nbsp; Hora final<strong> <span class="Estilo3">*</span></strong></strong></td>
      <td><input name="horafinaldetallejornadalaboral" type="text" id="horafinaldetallejornadalaboral" value="<?php echo  $row['horafinaldetallejornadalaboral'] ?>" size="5">
        <select name="terminar" id="terminar">
          <option value="AM" <?php if (!(strcmp("AM", $row['meridianohorafinaldetallejornadalaboral']))) {echo "SELECTED";} ?>>AM</option>
          <option value="PM" <?php if (!(strcmp("PM", $row['meridianohorafinaldetallejornadalaboral']))) {echo "SELECTED";} ?>>PM</option>
        </select>
        <span class="Estilo1">HH:MM</span></td>
    </tr>
    <tr>
      <td bgcolor="#C5D5D6" class="Estilo1"><strong>&nbsp; Observaciones</strong></td>
      <td><span class="Estilo1">
        <input name="observaciondetallejornadalaboral" type="text" id="observaciondetallejornadalaboral" value="<?php echo  $row['observaciondetallejornadalaboral'];?>" size="50">
      </span></td>
    </tr>
  </table>
  <p align="center"><span class="Estilo1">
    <input name="detalle" type="hidden" value="<?php echo $_GET['detalle']; ?>">
    <input name="modificar" type="hidden" value="<?php echo $_GET['modificar']; ?>">
  </span></p>
  <p align="center">
    <input type="submit" name="Submit" value="Modificar">
  </p>
</form>
<?php
mysql_free_result($Recordset1);
?>
