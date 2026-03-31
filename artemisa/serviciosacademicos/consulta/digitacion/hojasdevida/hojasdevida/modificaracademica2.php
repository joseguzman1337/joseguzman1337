<?php require_once('../../../../Connections/conexion.php');session_start();?>
<?php
       $base= "select * from historialacademico where idhistorialacademico = '".$_GET['modificar']."'";
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
<form name="form1" method="post" action="modificaracademica.php"><div align="center">
<p><span class="style1"><span class="style2"><strong><span class="Estilo1">MODIFICACI&Oacute;N DE DATOS</span><br>
      <br>
</strong>
<?php
 $ano = substr($_POST['fgrado'],0,4); 
 $mes = substr($_POST['fgrado'],5,2);
 $dia = substr($_POST['fgrado'],8,2);
 	
   if (($_POST['tituloobtenidohistorialacademico'] == "")or($_POST['institucionhistorialacademico'] == "") or ($_POST['lugarhistorialacademico'] == "")or ($_POST['codigotipogrado'] == 0))
   {
     echo  "<h5>Recuerde que los campos con <span class='Estilo3'>*</span> son obligatorios</h5>";
   }
else 
  if ( !( checkdate($mes,$dia,$ano)) or $_POST['fgrado'] > date("Y-m-d"))
  {
   echo "<h5>Fecha incorrecta</h5>";
  }
else 
  {
     require_once('modificaracademica1.php');
     exit();
  }

    ?>
    </span></span></p>
    <table width="380" border="1" cellpadding="1" cellspacing="2" bordercolor="#003333">
      <tr>
        <td width="124" bgcolor="#C5D5D6" class="Estilo2"><strong>&nbsp; T&iacute;tulo <span class="Estilo3">*</span></strong></td>
        <td width="240" class="style3"><input name="tituloobtenidohistorialacademico" type="text" id="tituloobtenidohistorialacademico" value="<?php if (isset($row['tituloobtenidohistorialacademico'])) echo $row['tituloobtenidohistorialacademico']; else echo $_POST['tituloobtenidohistorialacademico'];?>" size="40"></td>
      </tr>
      <tr>
        <td bgcolor="#C5D5D6" class="Estilo2"><strong>&nbsp; Instituci&oacute;n<strong> <span class="Estilo3">*</span></strong></strong></td>
        <td class="Estilo2"><input name="institucionhistorialacademico" type="text" id="institucionhistorialacademico" value="<?php if (isset($row['institucionhistorialacademico'])) echo $row['institucionhistorialacademico']; else echo $_POST['institucionhistorialacademico'];?>" size="40"></td>
      </tr>
      <tr>
        <td bgcolor="#C5D5D6" class="Estilo2"><strong>&nbsp; Lugar<strong> <span class="Estilo3">*</span></strong></strong></td>
        <td class="Estilo2"><input name="lugarhistorialacademico" type="text" id="lugarhistorialacademico" value="<?php if (isset($row['lugarhistorialacademico'])) echo $row['lugarhistorialacademico']; else echo $_POST['lugarhistorialacademico'];?>" size="40"></td>
      </tr>
      <tr>
        <td bgcolor="#C5D5D6" class="Estilo2"><strong>&nbsp; Fecha<strong> <span class="Estilo3">*</span></strong></strong></td>
        <td class="Estilo2"><!-- DD
          <input name="dia" type="text" id="dia" value="<?php ///echo $dia;?>" size="1">
MM
<input name="mes" type="text" id="mes" value="<?php //echo $mes;?>" size="1">
AAAA
<input name="ano" type="text" id="ano" value="<?php //echo $ano;?>" size="2"> -->
<input name="fgrado" type="text" size="10" value="<?php if(isset($row['fechagradohistorialacademico'])) echo $row['fechagradohistorialacademico']; else echo $_POST['fgrado']; ?>" onBlur="iniciarinicio(this)" onFocus="limpiarinicio(this)" maxlength="10"></td>
 </tr>
 <tr>
        <td bgcolor="#C5D5D6" class="Estilo2"><strong>&nbsp; Modalidad<strong> <span class="Estilo3">*</span></strong></strong></td>
        <td class="style3"><select name="codigotipogrado" id="codigotipogrado">
          <option value="value" <?php if (!(strcmp("value", $row['codigotipogrado']))) {echo "SELECTED";} ?>>Seleccionar</option>
          <?php
do {  
?>
          <option value="<?php echo $row_Recordset3['codigotipogrado']?>"<?php if (!(strcmp($row_Recordset3['codigotipogrado'], $row['codigotipogrado']))) {echo "SELECTED";} ?>><?php echo $row_Recordset3['nombretipogrado']?></option>
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
