<?php require_once('../../../../Connections/conexion.php');session_start();?>
<style type="text/css">
<!--
.Estilo1 {font-family: Tahoma; font-size: 12px}
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
       $base= "select * from autoria where idautoria = '".$_GET['modificar']."'";
       $sol=mysql_db_query($database_conexion,$base);
	   $totalRows = mysql_num_rows($sol);
       $row=mysql_fetch_array($sol);      
?>

<?php
	mysql_select_db($database_conexion, $conexion);
	$query_Recordset6 = "SELECT * FROM tipoautoria";
	$Recordset6 = mysql_query($query_Recordset6, $conexion) or die(mysql_error());
	$row_Recordset6 = mysql_fetch_assoc($Recordset6);
	$totalRows_Recordset6 = mysql_num_rows($Recordset6);
?>
<form name="form1" method="post" action="modificarobra.php">
  <p align="center" class="Estilo3">MODIFICACI&Oacute;N DE DATOS</span>
  <div align="center" class="Estilo2">
  <?php
   if (($_POST['nombreautoria'] == "") or ($_POST['codigotipoautoria'] == 0))
   {
     echo  "<h5>Recuerde que los campos con <span class='Estilo4'>*</span> son obligatorios</h5>";
   }
 
else 
     {
     require_once('modificarobra1.php');
	 exit();
     }
    ?>
    </p>
      <div align="center">
        <table width="480" border="1" cellpadding="1" cellspacing="2" bordercolor="#003333">
          <tr>
            <td bgcolor="#C5D5D6" class="Estilo2">&nbsp; T&iacute;tulo <span class="Estilo4">*</span></td>
            <td width="300" class="Estilo1"><span class="style4">
            <input name="nombreautoria" type="text" id="nombreautoria" value="<?php echo  $row['nombreautoria']; ?>" size="50">
            <?php  $ano=date("Y",strtotime($row['fechaautoria']));
			       $mes=date("m",strtotime($row['fechaautoria']));
			       $dia=date("d",strtotime($row['fechaautoria']));
			?>
            </span></td>
          </tr>
          <tr>
            <td bgcolor="#C5D5D6" class="Estilo2">&nbsp; Referencia</td>
            <td class="Estilo1"><input name="referenciaautoria" type="text" id="referenciaautoria" value="<?php echo $row['referenciaautoria'];?>" size="50"></td>
          </tr>
          <tr>
            <td bgcolor="#C6CFD0" class="Estilo2">&nbsp; Tipo de Publicaci&oacute;n<span class="Estilo4">*</span></td>
            <td class="Estilo1"><span class="style4">
              <select name="codigotipoautoria" id="codigotipoautoria">
                <option value="value" <?php if (!(strcmp("value", $row['codigotipoautoria']))) {echo "SELECTED";} ?>>Seleccionar</option>
                <?php
do {  
?>
                <option value="<?php echo $row_Recordset6['codigotipoautoria']?>"<?php if (!(strcmp($row_Recordset6['codigotipoautoria'], $row['codigotipoautoria']))) {echo "SELECTED";} ?>><?php echo $row_Recordset6['nombretipoautoria']?></option>
                <?php
} while ($row_Recordset6 = mysql_fetch_assoc($Recordset6));
  $rows = mysql_num_rows($Recordset6);
  if($rows > 0) {
      mysql_data_seek($Recordset6, 0);
	  $row_Recordset6 = mysql_fetch_assoc($Recordset6);
  }
?>
            </select>
            </span></td>
          </tr>
        </table>
      </div>
  </div>
    <div align="center" class="style1">
      <p align="center">
        <input name="modificar" type="hidden" value="<?php echo $_GET['modificar']; ?>">
      </p>
  </div>
  <p align="center">
    <span class="style1">
    <input type="submit" name="Submit" value="Modificar">
    </span> </p>
</form>
<p align="center">&nbsp;</p>
<?php
mysql_free_result($Recordset6);
?>
