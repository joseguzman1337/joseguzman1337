<?php require_once('../../../../Connections/conexion.php');session_start();?>
<?php
mysql_select_db($database_conexion, $conexion);
$query_Recordset1 = "SELECT * FROM tipocontrato";
$Recordset1 = mysql_query($query_Recordset1, $conexion) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

mysql_select_db($database_conexion, $conexion);
$query_Recordset2 = "SELECT * FROM estadotipocontrato";
$Recordset2 = mysql_query($query_Recordset2, $conexion) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);
?>
<style type="text/css">
<!--
.Estilo1 {
	font-family: Tahoma;
	font-size: 12px;
}
.Estilo2 {
	font-size: 14px;
	font-weight: bold;
}
.Estilo3 {color: #FF0000}
-->
</style>


<div align="center">
</div>
<form action="" method="post" name="form1" class="Estilo1">
  <?php
       $base= "select * from contratolaboral where idcontratolaboral = '".$_GET['modificar']."'";
       $sol=mysql_db_query($database_conexion,$base);
	   $totalRows = mysql_num_rows($sol);
       $row=mysql_fetch_array($sol); 
      
?>
  <div align="center" class=" Estilo2">MODIFICACI&Oacute;N DE  DATOS</div>
  <div align="center">
  <p><span class="Estilo1">
<?php
$ano = substr($_POST['finicio'],0,4); 
$mes = substr($_POST['finicio'],5,2);
$dia = substr($_POST['finicio'],8,2);
	  
   if (($_POST['numerocontratolaboral'] == "") or ($_POST['codigotipocontrato'] == 0)or ($_POST['codigoestadotipocontrato'] == 0))
   {
     echo  "<h5>Recuerde que los campos con <span class='Estilo3'>*</span> son obligatorios</h5>";
    
   }  
 else 
    if (! checkdate($mes, $dia,$ano) or $_POST['finicio'] > date("Y-m-d"))
	   {

        echo "<h4>La fecha es incorrecta<h/4>";
       } 
else 
  if (($_POST['ffinal'] != "") and ($_POST['finicio'] > $_POST['ffinal']))
    {
	  echo "<h5>La fecha es mayor a la actual</5>";
	}     
     
   else 
     {	
     require_once('modificarcontratolaboral1.php');
	 exit();
     }

    ?>
</span></span></p>
  </div>
  <table width="400" border="1" align="center" cellpadding="1" cellspacing="2"  bordercolor="#003333">
    <tr>
      <td width="150" bgcolor="#C5D5D6" class="Estilo1"><strong>&nbsp; N&uacute;mero Contrato <span class="Estilo3">*</span></strong></td>
      <td><input name="numerocontratolaboral" type="text" id="numerocontratolaboral" value="<?php if (isset($row['numerocontratolaboral'])) echo $row['numerocontratolaboral']; else $_POST['numerocontratolaboral'];?>">
      </td>
    </tr>
    <tr>
      <td bgcolor="#C5D5D6" class="Estilo1"><strong>&nbsp; Fecha Inicio<strong> <span class="Estilo3">*</span></strong></strong></td>
      <td><input name="finicio" type="text" size="10" value="<?php if(isset($row['fechainiciocontratolaboral'])) echo $row['fechainiciocontratolaboral']; else echo $_POST['finicio'];?>" onBlur="iniciarinicio(this)" onFocus="limpiarinicio(this)" maxlength="10">
      </td>
    </tr>
    <tr>
      <td bgcolor="#C5D5D6" class="Estilo1"><strong>&nbsp; Fecha Final</strong></td>
      <td><input name="ffinal" type="text" size="10" value="<?php if($row['fechafinalcontratolaboral'] <> "0000-00-00") echo $row['fechafinalcontratolaboral']; else if ($_POST['ffinal'] <> "" or $_POST['ffinal'] <> "0000-00-00") echo $_POST['ffinal']; else echo "aaaa-mm-dd";?>" onBlur="iniciarinicio(this)" onFocus="limpiarinicio(this)" maxlength="10">
      </td>
    </tr>
    <tr>
      <td bgcolor="#C5D5D6" class="Estilo1"><strong>&nbsp; Tipo de Contrato<strong> <span class="Estilo3">*</span></strong></strong></td>
      <td><select name="codigotipocontrato" id="codigotipocontrato">
          <option value="" <?php if (!(strcmp("", $row['codigotipocontrato']))) {echo "SELECTED";} ?>>Seleccionar</option>
          <?php
do {  
?>
          <option value="<?php echo $row_Recordset1['codigotipocontrato']?>"<?php if (!(strcmp($row_Recordset1['codigotipocontrato'], $row['codigotipocontrato']))) {echo "SELECTED";} ?>><?php echo $row_Recordset1['nombretipocontrato']?></option>
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
      <td bgcolor="#C5D5D6" class="Estilo1"><strong>&nbsp; Estado de Contrato<strong> <span class="Estilo3">*</span></strong></strong></td>
      <td><label>
        <select name="codigoestadotipocontrato" id="codigoestadotipocontrato">
          <option value="" <?php if (!(strcmp("", $row['codigoestadotipocontrato']))) {echo "SELECTED";} ?>>Seleccionar</option>
          <?php
do {  
?>
          <option value="<?php echo $row_Recordset2['codigoestadotipocontrato']?>"<?php if (!(strcmp($row_Recordset2['codigoestadotipocontrato'], $row['codigoestadotipocontrato']))) {echo "SELECTED";} ?>><?php echo $row_Recordset2['nombreestadotipocontrato']?></option>
          <?php
} while ($row_Recordset2 = mysql_fetch_assoc($Recordset2));
  $rows = mysql_num_rows($Recordset2);
  if($rows > 0) {
      mysql_data_seek($Recordset2, 0);
	  $row_Recordset2 = mysql_fetch_assoc($Recordset2);
  }
?>
        </select>
      </label></td>
    </tr>
  </table>
  <p align="center"><span class="Estilo1">
    <input name="modificar" type="hidden" value="<?php echo $_GET['modificar']; ?>">
  </span></p>
  <p align="center">
    <input type="submit" name="Submit" value="Modificar">
  </p>
</form>
<p align="center" class="Estilo1">&nbsp;</p>
<span class="Estilo1">
<?php
mysql_free_result($Recordset1);

mysql_free_result($Recordset2);
?>
</span>
<script language="javascript">
function limpiarinicio(texto)
{
	if(texto.value == "aaaa-mm-dd")
		texto.value = "";
    else
	  if(texto.value == "0000-00-00")
		texto.value = "";
}

function iniciarinicio(texto)
{
	if(texto.value == "")
		texto.value = "aaaa-mm-dd";
	else
	 if(texto.value == "0000-00-00")
		texto.value = "";
}
</script>