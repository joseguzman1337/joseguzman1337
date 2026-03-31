<?php require_once('../../../../Connections/conexion.php');session_start();?>
<?php
mysql_select_db($database_conexion, $conexion);
$query_Recordset1 = "SELECT * FROM tipolabor";
$Recordset1 = mysql_query($query_Recordset1, $conexion) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

mysql_select_db($database_conexion, $conexion);
$query_Recordset2 = "SELECT * FROM facultad";
$Recordset2 = mysql_query($query_Recordset2, $conexion) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

mysql_select_db($database_conexion, $conexion);
$query_Recordset3 = "SELECT * FROM asignatura";
$Recordset3 = mysql_query($query_Recordset3, $conexion) or die(mysql_error());
$row_Recordset3 = mysql_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysql_num_rows($Recordset3);
?>
<?php
       $base= "select * from jornadalaboral where idjornadalaboral = '".$_GET['modificar']."'";
       $sol=mysql_db_query($database_conexion,$base);
	   $totalRows = mysql_num_rows($sol);
       $row=mysql_fetch_array($sol); 
      
?>
<style type="text/css">
<!--
.Estilo1 {font-size: 12px; font-family: Tahoma; }
.Estilo2 {
	font-family: Tahoma;
	font-size: 14;
	font-weight: bold;
}
.Estilo3 {color: #FF0000}
-->
</style>
<body class="Estilo1">
<form name="form1" method="post" action="modificarjornadalaboral1.php">
  <p align="center"><span class="Estilo2">MODIFICACI&Oacute;N DE DATOS</span><br>
  </span>
  <div align="center" class="Estilo1">
    <?php	
  
   if (($_POST['codigofacultad'] == "")or ($_POST['codigotipolabor'] == ""))
   {       
    echo  "<h5>Recuerde que los campos con <span class='Estilo3' align='center'>*</span> son obligatorios</h5>";
   }
	else 
	 
	 {
     require_once('modificarjornadalaboral1.php');
     }
	
	?>
</p>
  <table border="1" align="center" cellpadding="1" cellspacing="2" bordercolor="#003333">
    <tr>
      <td bgcolor="#C5D5D6" class="Estilo1"><strong>&nbsp; Labor <span class="Estilo3">*</span></strong></td>
      <td class="Estilo1">
        <select name="codigotipolabor" id="codigotipolabor">
          <option value="" <?php if (!(strcmp("", $row['codigotipolabor']))) {echo "SELECTED";} ?>>Seleccionar</option>
          <?php
do {  
?>
          <option value="<?php echo $row_Recordset1['codigotipolabor']?>"<?php if (!(strcmp($row_Recordset1['codigotipolabor'], $row['codigotipolabor']))) {echo "SELECTED";} ?>><?php echo $row_Recordset1['nombretipolabor']?></option>
          <?php
} while ($row_Recordset1 = mysql_fetch_assoc($Recordset1));
  $rows = mysql_num_rows($Recordset1);
  if($rows > 0) {
      mysql_data_seek($Recordset1, 0);
	  $row_Recordset1 = mysql_fetch_assoc($Recordset1);
  }
?>
        </select>
      </strong></span> </td>
    </tr>
    <tr>
      <td bgcolor="#C5D5D6" class="Estilo1"><strong>&nbsp; Nombre de la Facultad<strong> <span class="Estilo3">*</span></strong></strong></td>
      <td><span class="Estilo1">
        <select name="codigofacultad" id="select2">
          <option value="" <?php if (!(strcmp("", $row['codigofacultad']))) {echo "SELECTED";} ?>>Seleccionar</option>
          <?php
do {  
?>
          <option value="<?php echo $row_Recordset2['codigofacultad']?>"<?php if (!(strcmp($row_Recordset2['codigofacultad'], $row['codigofacultad']))) {echo "SELECTED";} ?>><?php echo $row_Recordset2['nombrefacultad']?></option>
          <?php
} while ($row_Recordset2 = mysql_fetch_assoc($Recordset2));
  $rows = mysql_num_rows($Recordset2);
  if($rows > 0) {
      mysql_data_seek($Recordset2, 0);
	  $row_Recordset2 = mysql_fetch_assoc($Recordset2);
  }
?>
        </select>
      </span> </strong></td>
    </tr>
    <tr>
      <td bgcolor="#C5D5D6" class="Estilo1"><strong>&nbsp; Nombre de la Asignatura<strong> <span class="Estilo3">*</span></strong></strong></td>
      <td><span class="Estilo1">
        <select name="codigoasignatura" id="select">
          <option value="" <?php if (!(strcmp("", $row['codigoasignatura']))) {echo "SELECTED";} ?>>Seleccionar</option>
          <?php
do {  
?>
          <option value="<?php echo $row_Recordset3['nombreasignatura']?>"<?php if (!(strcmp($row_Recordset3['nombreasignatura'], $row['codigoasignatura']))) {echo "SELECTED";} ?>><?php echo $row_Recordset3['nombreasignatura']?></option>
          <?php
} while ($row_Recordset3 = mysql_fetch_assoc($Recordset3));
  $rows = mysql_num_rows($Recordset3);
  if($rows > 0) {
      mysql_data_seek($Recordset3, 0);
	  $row_Recordset3 = mysql_fetch_assoc($Recordset3);
  }
?>
        </select>
      </strong></span></td>
    </tr>
  </table>
  <div align="center">
    <p><span class="Estilo1">
    <input name="modificar" type="hidden" value="<?php echo $_GET['modificar']; ?>">
    </span></p>
    <p>
      <input type="submit" name="Submit" value="Modificar">
    </p>
  </div>
</form>
<?php
mysql_free_result($Recordset1);

mysql_free_result($Recordset2);

mysql_free_result($Recordset3);
?>
