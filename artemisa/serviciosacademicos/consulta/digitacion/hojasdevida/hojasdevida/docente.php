<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
 include('../../../../Connections/conexion.php');
session_start();?>
<style type="text/css">
<!--
.Estilo1 {font-family: Tahoma; font-size: 12px}
.Estilo2 {font-family: Tahoma; font-size: 12px; font-weight: bold;}
.Estilo3 {font-family: Tahoma; font-size: 14px; font-weight: bold;}
.Estilo4 {color: #FF0000}
-->
</style>
<form name="form1" method="post" action="docente.php">
  <div align="center">
    <p><span class="Estilo3">INFORMACI&Oacute;N B&Aacute;SICA </span></p>
    <p class="Estilo2">
  
<?php
mysql_select_db($database_conexion, $conexion);
$query_Recordset2 = "SELECT * FROM escalafondocente";
$Recordset2 = mysql_query($query_Recordset2, $conexion) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

mysql_select_db($database_conexion, $conexion);
$query_Recordset3 = "SELECT * FROM estadodocente";
$Recordset3 = mysql_query($query_Recordset3, $conexion) or die(mysql_error());
$row_Recordset3 = mysql_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysql_num_rows($Recordset3);

mysql_select_db($database_conexion, $conexion);
$query_Recordset1 = "SELECT * FROM tipodocumento";
$Recordset1 = mysql_query($query_Recordset1, $conexion) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

mysql_select_db($database_conexion, $conexion);
$query_Recordset4 = "SELECT * FROM vinculaciondocente";
$Recordset4 = mysql_query($query_Recordset4, $conexion) or die(mysql_error());
$row_Recordset4 = mysql_fetch_assoc($Recordset4);
$totalRows_Recordset4 = mysql_num_rows($Recordset4);

 $ano = substr($_POST['fnacimiento'],0,4); 
 $mes = substr($_POST['fnacimiento'],5,2);
 $dia = substr($_POST['fnacimiento'],8,2);

   if (($_POST['codigotipodocumento'] == 0)or($_POST['numerodocumento'] == "") or ($_POST['nombresdocente'] == "")or ($_POST['apellidosdocente'] == "")or ($_POST['sexodocente'] == "")or  ($_POST['lugarnacimientodocente'] == "")or ($_POST['direcciondocente'] == "")or ($_POST['ciudaddocente'] == "")or ($_POST['emaildocente'] == "")or ($_POST['telefonodocente'] == "")or ($_POST['telefonodocente2'] == "")or ($_POST['codigoescalafondocente'] == 0))
   {
     echo  "<h5><font size='2' face='Tahoma'>Recuerde que los campos con <span class='Estilo4'>*</span> son obligatorios</h5>";   
   }	
   else 

 if ( !( checkdate($mes, $dia,$ano)) or ($ano > 2000) or ($ano < 1930)) 
 {
  echo "<h5>LA fecha es incorrecta</h5>";
 }  
else 
     {	 
     require_once('capturadocente.php');
      exit();
	 }

?>
</p>
  </div>
   <div align="center">
    <table width="500" border="1" cellpadding="1" cellspacing="2" bordercolor="#003333">
      <tr bgcolor="#C5D5D6">
        <td colspan="2" align="center"><span class="Estilo2">INFORMACI&Oacute;N B&Aacute;SICA</span></td>
      </tr>
      <tr>
        <td bgcolor="#C5D5D6" class="Estilo2">&nbsp; Tipo de  Identificaci&oacute;n<span class="Estilo4"> *</span></span></td>
        <td class="Estilo1"><div align="left">
            <select name="codigotipodocumento" id="codigotipodocumento">
              <option value="value" <?php if (!(strcmp("value", $_POST['codigotipodocumento']))) {echo "SELECTED";} ?>>Seleccionar</option>
<?php
do {  
?>
              <option value="<?php echo $row_Recordset1['codigotipodocumento']?>"<?php if (!(strcmp($row_Recordset1['codigotipodocumento'], $_POST['codigotipodocumento']))) {echo "SELECTED";} ?>><?php echo $row_Recordset1['nombretipodocumento']?></option>
<?php
} while ($row_Recordset1 = mysql_fetch_assoc($Recordset1));
  $rows = mysql_num_rows($Recordset1);
  if($rows > 0) {
      mysql_data_seek($Recordset1, 0);
	  $row_Recordset1 = mysql_fetch_assoc($Recordset1);
  }
?>
            </select>
        </div></td>
      </tr>
      <tr>
        <td bgcolor="#C5D5D6" class="Estilo2">&nbsp; N&uacute;mero de Identificaci&oacute;n<span class="Estilo4"> *</span></td>
        <td class="Estilo1"><div align="left">
            <input name="numerodocumento" type="text" id="numerodocumento" value="<?php echo $_POST['numerodocumento'];?>">
        <span class="Estilo14">Sin puntos ni espacios</span></div></td>
      </tr>
      <tr>
        <td bgcolor="#C5D5D6" class="Estilo2">&nbsp; Nombres<span class="Estilo4"> *</span></td>
        <td class="Estilo1"><div align="left">
            <input name="nombresdocente" type="text" id="nombresdocente" value="<?php echo $_POST['nombresdocente'];?>" size="40">
        </div></td>
      </tr>
      <tr>
        <td bgcolor="#C5D5D6" class="Estilo2">&nbsp; Apellidos<span class="Estilo4"> *</span></span></td>
        <td class="Estilo1"><input name="apellidosdocente" type="text" id="apellidosdocente" value="<?php echo $_POST['apellidosdocente'];?>" size="40"></td>
      </tr>
      <tr>
        <td bgcolor="#C5D5D6" class="Estilo2">&nbsp; G&eacute;nero <span class="Estilo4"> *</span></td>
        <td class="Estilo1"><div align="left">
            <select name="sexodocente" id="sexodocente">
              <option value="" <?php if (!(strcmp("", $_POST['sexodocente']))) {echo "SELECTED";} ?>>Seleccionar</option>
              <option value="F" <?php if (!(strcmp("F", $_POST['sexodocente']))) {echo "SELECTED";} ?>>Femenino</option>
              <option value="M" <?php if (!(strcmp("M", $_POST['sexodocente']))) {echo "SELECTED";} ?>>Masculino</option>
            </select>
        </div></td>
      </tr>
    </table>
    <br>
  </div>
  <div align="center">
        <table width="500" border="1" cellpadding="1" cellspacing="2" bordercolor="#003333">
          <tr bgcolor="#C5D5D6">
            <td colspan="2" align="center"><span class="Estilo2">INFORMACI&Oacute;N PERSONAL</span></td>
          </tr>
          <tr>
            <td bgcolor="#C5D5D6" class="Estilo2">&nbsp; Fecha de Nacimiento</span><span class="Estilo4"> *</span> </td>
            <td class="Estilo1"><!-- DD
              <input name="dia" type="text" id="dia" value="<?php //echo $_POST['dia'];?>" size="1" maxlength="2">
  MM
  <input name="mes" type="text" id="mes" value="<?php// echo $_POST['mes'];?>" size="1" maxlength="2">
  AAAA
  <input name="ano" type="text" id="ano" value="<?php //echo $_POST['ano'];?>" size="2"> -->
         <input name="fnacimiento" type="text" size="10" value="<?php if(isset($_POST['fnacimiento'])) echo $_POST['fnacimiento']; else echo "aaaa-mm-dd"; ?>" onBlur="iniciarinicio(this)" onFocus="limpiarinicio(this)" maxlength="10"></td>
		  </tr>
          <tr>
            <td bgcolor="#C5D5D6" class="Estilo2">&nbsp;  </strong>Lugar de Nacimiento<span class="Estilo4"> *</span></span></td>
            <td class="Estilo1"><input name="lugarnacimientodocente" type="text" id="lugarnacimientodocente" value="<?php echo $_POST['lugarnacimientodocente'];?>" size="40"></td>
          </tr>
          <tr>
            <td bgcolor="#C5D5D6" class="Estilo2">&nbsp; C&oacute;digo Postal</span></td>
            <td class="Estilo1"><input name="codigopostaldocente" type="text" id="codigopostaldocente" value="<?php echo $_POST['codigopostaldocente'];?>"></td>
          </tr>
          <tr>
            <td bgcolor="#C5D5D6" class="Estilo2">&nbsp; Direcci&oacute;n<span class="Estilo4"> *</span></span></td>
            <td class="Estilo1"><input name="direcciondocente" type="text" id="direcciondocente" value="<?php echo $_POST['direcciondocente'];?>" size="40"></td>
          </tr>
          <tr>
            <td bgcolor="#C5D5D6" class="Estilo2">&nbsp;  Ciudad<span class="Estilo4"> *</span></span></td>
            <td class="Estilo1"><input name="ciudaddocente" type="text" id="ciudaddocente" value="<?php echo $_POST['ciudaddocente'];?>" size="40"></td>
          </tr>
          <tr>
            <td bgcolor="#C5D5D6" class="Estilo2">&nbsp;  E - mail<span class="Estilo4"> *</span></span></td>
            <td class="Estilo1"><input name="emaildocente" type="text" id="emaildocente" value="<?php echo $_POST['emaildocente'];?>" size="40"></td>
          </tr>
          <tr>
            <td bgcolor="#C5D5D6" class="Estilo2">&nbsp;  Tel&eacute;fono Casa<span class="Estilo4"> *</span></strong></span></td>
            <td class="Estilo1"><input name="telefonodocente" type="text" id="telefonodocente" value="<?php echo $_POST['telefonodocente'];?>"></td>
          </tr>
          <tr>
            <td bgcolor="#C5D5D6" class="Estilo2">&nbsp;  Tel&eacute;fono Oficina<span class="Estilo4"> *</span></strong></span></td>
            <td class="Estilo1"><input name="telefonodocente2" type="text" id="telefonodocente2" value="<?php echo $_POST['telefonodocente2'] ?>"></td>
          </tr>
          <tr>
            <td bgcolor="#C5D5D6" class="Estilo2">&nbsp;  Celular</td>
            <td class="Estilo1"><input name="celulardocente" type="text" id="celulardocente" value="<?php echo $_POST['celulardocente'] ?>"></td>
          </tr>
          <tr>
            <td bgcolor="#C5D5D6" class="Estilo2">&nbsp;   Fax</span></td>
            <td class="Estilo1"><input name="faxdocente" type="text" id="faxdocente" value="<?php echo $_POST['faxdocente'];?>"></td>
          </tr>
          <tr>
            <td bgcolor="#C5D5D6" class="Estilo2">&nbsp;  Escalaf&oacute;n<span class="Estilo4"> *</span></span></td>
            <td class="Estilo1"><select name="codigoescalafondocente" id="codigoescalafondocente">
             <option value="value" <?php if (!(strcmp("value", $_POST['codigoescalafondocente']))) {echo "SELECTED";} ?>>Seleccionar</option>
<?php             
do {  
?>
  <option value="<?php echo $row_Recordset2['codigoescalafondocente']?>"<?php if (!(strcmp($row_Recordset2['codigoescalafondocente'], $_POST['codigoescalafondocente']))) {echo "SELECTED";} ?>><?php echo $row_Recordset2['nombreescalafondocente']?></option>
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
  </div>
  <p align="center">
    <input type="submit" name="Submit" value="Grabar">
  </p>
</form>
<span class="Estilo2">
<?php
mysql_free_result($Recordset2);
mysql_free_result($Recordset3);
mysql_free_result($Recordset1);
mysql_free_result($Recordset4);
?>

<script language="javascript">
function limpiarinicio(texto)
{
	if(texto.value == "aaaa-mm-dd")
		texto.value = "";
}

function iniciarinicio(texto)
{
	if(texto.value == "")
		texto.value = "aaaa-mm-dd";
}
</script>

</span>