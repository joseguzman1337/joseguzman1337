<?php require_once('../../../../Connections/conexion.php');session_start();?>
<?php
       $base= "select * from capacitacion where idcapacitacion = '".$_GET['idcapacitacion']."'";
       $sol=mysql_db_query("hojavida",$base);
	   $totalRows = mysql_num_rows($sol);
       $row=mysql_fetch_array($sol); 
      
?>

<?php
mysql_select_db($database_conexion, $conexion);
$query_Recordset3 = "SELECT * FROM tipogrado";
$Recordset3 = mysql_query($query_Recordset3, $conexion) or die(mysql_error());
$row_Recordset3 = mysql_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysql_num_rows($Recordset3);
?>
<style type="text/css">
<!--
.Estilo1 {
	font-family: Tahoma;
	font-size: 14px;
}
.Estilo2 {font-family: Tahoma; font-size: 12px; }
.Estilo3 {color: #FF0000}
-->
</style>
<body class="Estilo2">
<form name="form1" method="post" action="modificarcapacitacion.php"><div align="center">
<p><span class="style1"><span class="style2"><strong><span class="Estilo1">MODIFICACI&Oacute;N DE DATOS</span><br>
      <br>
</strong>
<?php
 $ano = substr($_POST['fgrado'],0,4); 
 $mes = substr($_POST['fgrado'],5,2);
 $dia = substr($_POST['fgrado'],8,2);
 	
   if (($_POST['tituloobtenidocapacitacion'] == "")or($_POST['codigopais'] == "") or ($_POST['periodocapacitacion'] == "")or  ($_POST['aniocapacitacion'] == 0) or (trim($_POST['codigotipocapacitacion']) == "") or (trim($_POST['codigotipofinanciacion']) == "") or (trim($_POST['codigotipogrado']) == "") )
   {
     echo  "<h5>Recuerde que los campos con <span class='Estilo4'>*</span> son obligatorios</h5>";   	  
   }  
	else 
  {
     require_once('modificarcapacitacion1.php');
     exit();
  }

    ?>
    </span></span></p>
    <table width="480" border="1" cellpadding="1" cellspacing="2" bordercolor="#003333">
      <tr>
        <td bgcolor="#C5D5D6" class="Estilo2"><strong>&nbsp; Titulo <span class="Estilo3">*</span></strong></td>
        <td width="240"><input name="tituloobtenidocapacitacion" type="text" id="tituloobtenidocapacitacion" value="<?php echo $row['tituloobtenidocapacitacion'];?>" size="40">
        </td>
      </tr>
      <tr>
        <td bgcolor="#C5D5D6" class="Estilo2"><strong>&nbsp; Pais <strong> <span class="Estilo3">*</span></strong></strong></td>
        <td><select name="codigopais" id="codigopais">
            <option value="" >Seleccionar</option>
            <?php
$query_Recordset2 = "SELECT * FROM pais";
$Recordset2 = mysql_query($query_Recordset2, $conexion) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

do {  
	if(isset($row['codigopais']))
		$codigopais=$row['codigopais'];
	else
		$codigopais=$_POST['codigopais'];

?>
            <option value="<?php echo $row_Recordset2['codigopais']?>"<?php if (!(strcmp($row_Recordset2['codigopais'],$codigopais))) {echo "SELECTED";} ?>><?php echo $row_Recordset2['nombrepais']?></option>
            <?php
} while ($row_Recordset2 = mysql_fetch_assoc($Recordset2));
  $rows = mysql_num_rows($Recordset2);
  if($rows > 0) {
     mysql_data_seek($Recordset2, 0);
	 $row_Recordset2 = mysql_fetch_assoc($Recordset2);
  }
?>
          </select>
        </td>
      </tr>
      <tr>
        <td bgcolor="#C5D5D6" class="Estilo2"><strong>&nbsp; A&ntilde;o<strong> <span class="Estilo3">*</span></strong></strong></td>
        <td><!-- DD
          <input name="dia" type="text" id="dia" value="<?php //echo $_POST['dia'];?>" size="1">
          MM
          <input name="mes" type="text" id="mes" value="<?php //echo $_POST['mes'];?>" size="1">
          AAAA</span>          
        <input name="ano" type="text" id="ano" value="<?php // echo $_POST['ano'];?>" size="2"> -->
            <input name="aniocapacitacion" type="text" size="10" value="<?php if(isset($row['aniocapacitacion'])) echo $row['aniocapacitacion']; else echo $_POST['aniocapacitacion']; ?>" onBlur="iniciaranio(this)" onFocus="limpiaranio(this)" maxlength="4"></td>
      </tr>
      <tr>
        <td bgcolor="#C5D5D6" class="Estilo2"><strong><strong>&nbsp; </strong>Periodo<strong> <span class="Estilo3">*</span></strong></strong></td>
        <td>
		<?php
			if(isset($row['periodocapacitacion']))
		$periodocapacitacion=$row['periodocapacitacion'];
	else
		$periodocapacitacion=$_POST['periodocapacitacion'];

		//$periodocapacitacion=$_POST['periodocapacitacion'];
		?>
		<select name="periodocapacitacion" id="periodocapacitacion">
            <option value="value" ?>Seleccionar</option>
            <option value="01" <?php if($periodocapacitacion=="01") echo "SELECTED";?>>01</option>
            <option value="02" <?php if($periodocapacitacion=="02") echo "SELECTED";?>>02</option>
          </select>
        </td>
      </tr>
      <tr>
        <td bgcolor="#C5D5D6" class="Estilo2"><strong>&nbsp; Tipo capacitacion <strong> <span class="Estilo3">*</span></strong></strong></td>
        <td><select name="codigotipocapacitacion" id="codigotipocapacitacion">
          <option value="value" <?php if (!(strcmp("value", $_POST['codigotipogrado']))) {echo "SELECTED";} ?>>Seleccionar</option>
          <?php
$query_Recordset3 = "SELECT * FROM tipocapacitacion";
$Recordset3 = mysql_query($query_Recordset3, $conexion) or die(mysql_error());
$row_Recordset3 = mysql_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysql_num_rows($Recordset3);
			
do {  

	if(isset($row['codigotipocapacitacion']))
		$codigotipocapacitacion=$row['codigotipocapacitacion'];
	else
		$codigotipocapacitacion=$_POST['codigotipocapacitacion'];

?>
          <option value="<?php echo $row_Recordset3['codigotipocapacitacion']?>"<?php if (!(strcmp($row_Recordset3['codigotipocapacitacion'], $codigotipocapacitacion))) {echo "SELECTED";} ?>><?php echo $row_Recordset3['nombretipocapacitacion']?></option>
          <?php
} while ($row_Recordset3 = mysql_fetch_assoc($Recordset3));
  $rows = mysql_num_rows($Recordset3);
  if($rows > 0) {
      mysql_data_seek($Recordset3, 0);
	  $row_Recordset3 = mysql_fetch_assoc($Recordset3);
  }
?>
        </select></td>
      </tr>
      <tr>
        <td bgcolor="#C5D5D6" class="Estilo2"><strong>&nbsp; Modalidad<strong> <span class="Estilo3">*</span></strong></strong></td>
        <td><select name="codigotipogrado" id="codigotipogrado">
            <option value="value" <?php if (!(strcmp("value", $_POST['codigotipogrado']))) {echo "SELECTED";} ?>>Seleccionar</option>
            <?php
			$query_Recordset1 = "SELECT * FROM tipogrado";
$Recordset1 = mysql_query($query_Recordset1, $conexion) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

do {  

	if(isset($row['codigotipogrado']))
		$codigotipogrado=$row['codigotipogrado'];
	else
		$codigotipogrado=$_POST['codigotipogrado'];

?>
            <option value="<?php echo $row_Recordset1['codigotipogrado']?>"<?php if (!(strcmp($row_Recordset1['codigotipogrado'], $codigotipogrado))) {echo "SELECTED";} ?>><?php echo $row_Recordset1['nombretipogrado']?></option>
            <?php
} while ($row_Recordset1 = mysql_fetch_assoc($Recordset1));
  $rows = mysql_num_rows($Recordset1);
  if($rows > 0) {
      mysql_data_seek($Recordset1, 0);
	  $row_Recordset1 = mysql_fetch_assoc($Recordset1);
  }
?>
          </select>
        </td>
      </tr>
      <tr>
        <td bgcolor="#C5D5D6" class="Estilo2"><strong> <strong> <strong>&nbsp; </strong>Financiado </strong><strong> <span class="Estilo3">*</span></strong></strong></td>
        <td><select name="codigotipofinanciacion" id="codigotipofinanciacion">
            <option value="value" <?php if (!(strcmp("value", $_POST['codigotipogrado']))) {echo "SELECTED";} ?>>Seleccionar</option>
            <?php
$query_Recordset4 = "SELECT * FROM tipofinanciacion";
$Recordset4 = mysql_query($query_Recordset4, $conexion) or die(mysql_error());
$row_Recordset4 = mysql_fetch_assoc($Recordset4);
$totalRows_Recordset4 = mysql_num_rows($Recordset4);

do {  
	if(isset($row['codigotipofinanciacion']))
		$codigotipofinanciacion=$row['codigotipofinanciacion'];
	else
		$codigotipofinanciacion=$_POST['codigotipofinanciacion'];

?>
            <option value="<?php echo $row_Recordset4['codigotipofinanciacion']?>"<?php if (!(strcmp($row_Recordset4['codigotipofinanciacion'], $codigotipofinanciacion))) {echo "SELECTED";} ?>><?php echo $row_Recordset4['nombretipofinanciacion']?></option>
            <?php
} while ($row_Recordset4 = mysql_fetch_assoc($Recordset4));
  $rows = mysql_num_rows($Recordset4);
  if($rows > 0) {
      mysql_data_seek($Recordset4, 0);
	  $row_Recordset4 = mysql_fetch_assoc($Recordset4);
  }
?>
        </select></td>
      </tr>
      <tr>
        <td bgcolor="#C5D5D6" class="Estilo2">&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table>
    <p class="style3">
      <input name="idcapacitacion" type="hidden" value="<?php echo $_GET['idcapacitacion']; ?>">
    </p>
    </div>
  <p align="center">
    <span class="style3">
    <input type="submit" name="Submit" value="Modificar">
    </span> </p>
</form>

<script language="javascript">
function limpiarinicio(texto)
{
	if(texto.value == texto)
		texto.value = "";
}

function iniciarinicio(texto)
{
	if(texto.value == "")
		texto.value = "aaaa-mm-dd";
}
</script>
<?php
mysql_free_result($Recordset3);
?>