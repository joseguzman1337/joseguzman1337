<?php require_once('Connections/conexion.php'); ?>
<?php
       $base= "select * from asignaturadocente where idasignaturadocente = '".$_GET['modificar']."'";
       $sol=mysql_db_query("hojavida",$base);
	   $totalRows = mysql_num_rows($sol);
       $row=mysql_fetch_array($sol); 
      
?>

<?php
mysql_select_db($database_conexion, $conexion);
$query_Recordset4 = "SELECT * FROM facultad";
$Recordset4 = mysql_query($query_Recordset4, $conexion) or die(mysql_error());
$row_Recordset4 = mysql_fetch_assoc($Recordset4);
$totalRows_Recordset4 = mysql_num_rows($Recordset4);

mysql_select_db($database_conexion, $conexion);
$query_Recordset5 = "SELECT * FROM asignatura";
$Recordset5 = mysql_query($query_Recordset5, $conexion) or die(mysql_error());
$row_Recordset5 = mysql_fetch_assoc($Recordset5);
$totalRows_Recordset5 = mysql_num_rows($Recordset5);
?>
<?php require_once('Connections/conexion.php'); ?>
<style type="text/css">
<!--
.style1 {
	font-family: Tahoma;
	font-size: x-small;
}
.style2 {font-size: small}
.style4 {font-size: x-small}
.style6 {font-size: x-small; font-weight: bold; }
.Estilo3 {font-size: 10px}
-->
</style>

<form name="form1" method="post" action="modificarasignatura.php">
  <p align="center" class="style1"><strong><span class="style2">MODIFIQUE LOS DATOS</span>    </strong>
  <p align="center" class="style1">
	<?php
   if (($_POST['codigofacultad'] == "")or ($_POST['codigoasignatura'] == "")or ($_POST['ubicacionasignaturadocente'] == ""))
   {
     echo  "<h4>Los Campos con -> son Requeridos</h4>";
   }
else 
     {
     require_once('modificarasignatura1.php');
     }

    ?>
   
  </p>
    <div align="center" class="style1">
      <table width="708" border="1" cellpadding="1" cellspacing="2" bordercolor="#003333">
        <tr>
          <td width="265" bgcolor="#C6CFD0"><span class="style6">-&gt; Nombre de la Facultad: </span></td>
          <td width="417"><span class="style4">
            <select name="codigofacultad" id="codigofacultad">
              <option value="""" <?php if (!(strcmp("", $row['codigofacultad']))) {echo "SELECTED";} ?>>Seleccionar</option>
              <?php
do {  
?>
              <option value="<?php echo $row_Recordset4['codigofacultad']?>"<?php if (!(strcmp($row_Recordset4['codigofacultad'], $row['codigofacultad']))) {echo "SELECTED";} ?>><?php echo $row_Recordset4['nombrefacultad']?></option>
              <?php
} while ($row_Recordset4 = mysql_fetch_assoc($Recordset4));
  $rows = mysql_num_rows($Recordset4);
  if($rows > 0) {
      mysql_data_seek($Recordset4, 0);
	  $row_Recordset4 = mysql_fetch_assoc($Recordset4);
  }
?>
          </select>
          </span></td>
        </tr>
        <tr>
          <td bgcolor="#C6CFD0"><span class="style6">-&gt; Nombre de la Asignatura: </span></td>
          <td><span class="style4">
            <select name="codigoasignatura" id="codigoasignatura">
              <option value="""" <?php if (!(strcmp("", $row['codigoasignatura']))) {echo "SELECTED";} ?>>Seleccionar</option>
              <?php
do {  
?>
              <option value="<?php echo $row_Recordset5['codigoasignatura']?>"<?php if (!(strcmp($row_Recordset5['codigoasignatura'], $row['codigoasignatura']))) {echo "SELECTED";} ?>><?php echo $row_Recordset5['nombreasignatura']?></option>
              <?php
} while ($row_Recordset5 = mysql_fetch_assoc($Recordset5));
  $rows = mysql_num_rows($Recordset5);
  if($rows > 0) {
      mysql_data_seek($Recordset5, 0);
	  $row_Recordset5 = mysql_fetch_assoc($Recordset5);
  }
?>
            </select>
          </span></td>
        </tr>
        <tr>
          <td bgcolor="#C6CFD0"><span class="style6">-&gt; Lugar Actividad Unbosque: </span></td>
          <td><span class="style4"><span class="Estilo3">
            <input name="ubicacionasignaturadocente" type="text" id="ubicacionasignaturadocente" value="<?php echo $row['ubicacionasignaturadocente'] ?>" size="40">
          </span>
          </span></td>
        </tr>
      </table>
        
    </div>
  <p align="center" class="style1">
    <input name="modificar" type="hidden" value="<?php echo $_GET['modificar']; ?>">
  </p>
  <p align="center">
    <span class="style1">
    <input type="submit" name="Submit" value="Modificar">
    </span> </p>
</form>
<p>&nbsp;</p>
<?php
mysql_free_result($Recordset4);

mysql_free_result($Recordset5);
?>
