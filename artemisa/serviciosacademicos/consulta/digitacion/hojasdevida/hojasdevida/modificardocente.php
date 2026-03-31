<?php require_once('../../../../Connections/conexion.php');session_start();?>

<?php
       $base= "select * from docente where numerodocumento = '".$_GET['modificar']."'";
       $sol=mysql_db_query("hojavida",$base);
	   $totalRows = mysql_num_rows($sol);
       $row=mysql_fetch_array($sol); 
      
?>

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
?>
<style type="text/css">
<!--
.style1 {
	font-family: Tahoma;
	font-size: x-small;
}
.style2 {font-size: small}
.style4 {font-size: x-small}
.style5 {
	font-size: x-small;
	font-weight: bold;
}
.style7 {font-size: x-small}
.Estilo1 {font-size: 14px}
.Estilo5 {color: #FF0000}
-->
</style>


<form name="form1" method="post" action="modificardocente.php">
  <p align="center" class="style1 style2 Estilo1"><strong>MODIFICACI&Oacute;N DE LOS DATOS PERSONALES </strong></p>
  <div align="center" class="style1">
<?php
$ano = substr($_POST['fnacimiento'],0,4); 
$mes = substr($_POST['fnacimiento'],5,2);
$dia = substr($_POST['fnacimiento'],8,2);
 
   if (($_POST['codigotipodocumento'] == 0)or($_POST['numerodocumento'] == "") or ($_POST['nombresdocente'] == "")or ($_POST['apellidosdocente'] == "")or ($_POST['sexodocente'] == "")or ($_POST['lugarnacimientodocente'] == "")or ($_POST['direcciondocente'] == "")or ($_POST['ciudaddocente'] == "")or ($_POST['emaildocente'] == "")or ($_POST['telefonodocente'] == "")or ($_POST['telefonodocente2'] == "")or ($_POST['codigoescalafondocente'] == 0))
   {
     echo  "<h5>Recuerde que los campos con <span class='Estilo5'>*</span> son obligatorios</h5>";
   }
   else 

 if ( !( checkdate($mes,$dia,$ano)) or ($ano > 2000) or ($ano < 1930)) {

    echo "<h3>La fecha es incorrecta</h3>";
 
 } 
   
else 
     {
     require_once('modificardocente1.php');
      exit();
	 }

    ?>
</div>
    <div align="center" class="style1">
      <div align="center">
      <table width="500" border="1" cellpadding="1" cellspacing="2" bordercolor="#003333">
        <tr bgcolor="#C5D5D6">
          <td colspan="2"><div align="center"><span class="style5">INFORMACI&Oacute;N B&Aacute;SICA</span></div></td>
        </tr>
        <tr>
          <td width="170" bgcolor="#C5D5D6"><div align="left" class="style4"><strong>&nbsp; Tipo Identificaci&oacute;n <span class="style5"><span class="Estilo5">*</span></span></strong></div></td>
          <td width="314"><div align="left">
              <select name="codigotipodocumento" id="codigotipodocumento">
                <option value="value" <?php if (!(strcmp("value", $row['codigotipodocumento']))) {echo "SELECTED";} ?>>Seleccionar</option>
                <?php
do {  
?>
                <option value="<?php echo $row_Recordset1['codigotipodocumento']?>"<?php if (!(strcmp($row_Recordset1['codigotipodocumento'], $row['codigotipodocumento']))) {echo "SELECTED";} ?>><?php echo $row_Recordset1['nombretipodocumento']?></option>
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
          <td bgcolor="#C5D5D6"><div align="left" class="style4"><strong><strong>&nbsp; </strong>Numero Identificaci&oacute;n <span class="style5"><span class="Estilo5">*</span></span></strong></div></td>
          <td><div align="left">
              <input name="numerodocumento" type="text" id="numerodocumento" value="<?php if (isset( $row['numerodocumento'])) echo $row['numerodocumento']; else echo $_POST['numerodocumento'];?>">
          </div></td>
        </tr>
        <tr>
          <td bgcolor="#C5D5D6"><div align="left" class="style4"><strong><strong>&nbsp; </strong>Nombres <span class="style5"><span class="Estilo5">*</span></span></strong></div></td>
          <td><div align="left">
              <input name="nombresdocente" type="text" id="nombresdocente" value="<?php if (isset( $row['nombresdocente'])) echo $row['nombresdocente']; else echo $_POST['nombresdocente'];?>" size="40">
          </div></td>
        </tr>
        <tr>
          <td bgcolor="#C5D5D6"><span class="style5"><span class="style4"><strong>&nbsp; </strong></span>Apellidos <span class="Estilo5">*</span></span></td>
          <td><input name="apellidosdocente" type="text" id="apellidosdocente" value="<?php if (isset( $row['apellidosdocente'])) echo $row['apellidosdocente']; else echo $_POST['apellidosdocente'];?>" size="40"></td>
		</tr>
        <tr>
          <td bgcolor="#C5D5D6"><div align="left" class="style4">
            <p><strong><strong>&nbsp; </strong>G&eacute;nero<span class="style5"><span class="Estilo5">*</span></span></strong></p>
          </div></td>
          <td><div align="left">
            <select name="sexodocente" id="sexodocente">
              <option value="""" <?php if (!(strcmp("", $row['sexodocente']))) {echo "SELECTED";} ?>>Seleccionar</option>
              <option value="F" <?php if (!(strcmp("F", $row['sexodocente']))) {echo "SELECTED";} ?>>Femenino</option>
              <option value="M" <?php if (!(strcmp("M", $row['sexodocente']))) {echo "SELECTED";} ?>>Masculino</option>
              <option value="O" <?php if (!(strcmp("O", $row['sexodocente']))) {echo "SELECTED";} ?>>Otro</option>
            </select>
          </div></td>
        </tr>
      </table>
      <br>
      <table width="500" border="1" cellpadding="1" cellspacing="2" bordercolor="#003333">
        <tr bgcolor="#C5D5D6">
          <td colspan="2"><div align="center"><span class="style4"><strong>INFORMACI&Oacute;N PERSONAL</strong></span></div></td>
        </tr>
        <tr>
          <td width="170" bgcolor="#C5D5D6"><span class="style5"><strong>&nbsp; </strong>Fecha de Nacimiento <span class="Estilo5">*</span> </span></td>
          <td><span class="style4"><!-- DD
            <input name="dia" type="text" id="dia" value="<?php //echo $dia;?>" size="1">
MM
<input name="mes" type="text" id="mes" value="<?php echo //$mes;?>" size="1">
AAAA
<input name="ano" type="text" id="ano" value="<?php echo //$ano;?>" size="2"> -->
<input name="fnacimiento" type="text" size="10" value="<?php if(isset($row['fechanacimientodocente'])) echo $row['fechanacimientodocente']; else echo $_POST['fnacimiento']; ?>" onBlur="iniciarinicio(this)" onFocus="limpiarinicio(this)" maxlength="10">
</span></td>
        </tr>
        <tr>
          <td bgcolor="#C5D5D6"><span class="style5"><span class="style4"><strong>&nbsp; </strong></span>Lugar de Nacimiento<span class="Estilo5"> *</span></span></td>
          <td><input name="lugarnacimientodocente" type="text" id="lugarnacimientodocente" value="<?php if (isset( $row['lugarnacimientodocente'])) echo $row['lugarnacimientodocente']; else echo $_POST['lugarnacimientodocente'];?>" size="40"></td>
        </tr>
        <tr>
          <td bgcolor="#C5D5D6"><span class="style5"> <span class="style4"><strong>&nbsp; </strong></span>C&oacute;digo Postal <span class="Estilo5">*</span></span></td>
          <td><input name="codigopostaldocente" type="text" id="codigopostaldocente" value="<?php if (isset( $row['codigopostaldocente'])) echo $row['codigopostaldocente']; else echo $_POST['codigopostaldocente'];?>"></td>
        </tr>
        <tr>
          <td bgcolor="#C5D5D6"><span class="style5"><span class="style4"><strong>&nbsp; </strong></span>Direcci&oacute;n<span class="Estilo5"> *</span></span></td>
          <td><input name="direcciondocente" type="text" id="direcciondocente" value="<?php if (isset( $row['direcciondocente'])) echo $row['direcciondocente'];  else echo $_POST['direcciondocente'];?>" size="40"></td>
        </tr>
        <tr>
          <td bgcolor="#C5D5D6"><span class="style5"><span class="style4"><strong>&nbsp; </strong></span>Ciudad <span class="Estilo5">*</span></span></td>
          <td><input name="ciudaddocente" type="text" id="ciudaddocente" value="<?php if (isset( $row['ciudaddocente'])) echo $row['ciudaddocente'];  else echo $_POST['ciudaddocente'];?>" size="40"></td>
        </tr>
        <tr>
          <td bgcolor="#C5D5D6"><span class="style5"><span class="style4"><strong>&nbsp; </strong></span>E-mail <span class="Estilo5">*</span></span></td>
          <td><input name="emaildocente" type="text" id="emaildocente" value="<?php  if (isset( $row['emaildocente'])) echo $row['emaildocente']; else echo $_POST['emaildocente']; ?>" size="40"></td>
        </tr>
        <tr>
          <td bgcolor="#C5D5D6"><span class="style5"><span class="style4"><strong>&nbsp; </strong></span>Tel&eacute;fono Casa <span class="Estilo5">*</span></span></td>
          <td><input name="telefonodocente" type="text" id="telefonodocente" value="<?php if (isset( $row['telefonodocente'])) echo $row['telefonodocente']; else echo $_POST['telefonodocente'];?>"></td>
        </tr>
        <tr>
          <td bgcolor="#C6CFD0"><span class="style5"><span class="style4"><strong>&nbsp; </strong></span>Tel&eacute;fono Oficina <span class="Estilo5">*</span></span></td>
          <td><input name="telefonodocente2" type="text" id="telefonodocente2" value="<?php if (isset( $row['telefonodocente2'])) echo $row['telefonodocente2']; else echo $_POST['telefonodocente2'];?>"></td>
        </tr>
        <tr>
          <td bgcolor="#C6CFD0">&nbsp;&nbsp;<span class="style5">Celular</span></td>
          <td><input name="celulardocente" type="text" id="celulardocente" value="<?php  if (isset( $row['celulardocente'])) echo $row['celulardocente']; else echo $_POST['celulardocente']; ?>"></td>
        </tr>
        <tr>
          <td bgcolor="#C6CFD0"><span class="style5"><span class="style4"><strong>&nbsp;&nbsp;&nbsp;</strong></span>Fax</span></td>
          <td><input name="faxdocente" type="text" id="faxdocente" value="<?php if (isset( $row['faxdocente'])) echo $row['faxdocente']; else echo $_POST['faxdocente']; ?>"></td>
        </tr>
        <tr>
          <td bgcolor="#C6CFD0"><span class="style5"><span class="style4"><strong>&nbsp;&nbsp;</strong></span> Escalaf&oacute;n <span class="Estilo5">*</span></span></td>
          <td><select name="codigoescalafondocente" id="codigoescalafondocente">
            <option value="value" <?php if (!(strcmp("value", $row['codigoescalafondocente']))) {echo "SELECTED";} ?>>Seleccionar</option>
            <?php
do {  
?>
            <option value="<?php echo $row_Recordset2['codigoescalafondocente']?>"<?php if (!(strcmp($row_Recordset2['codigoescalafondocente'], $row['codigoescalafondocente']))) {echo "SELECTED";} ?>><?php echo $row_Recordset2['nombreescalafondocente']?></option>
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
      <p>
        <input name="modificar" type="hidden" value="<?php echo $_GET['modificar']; ?>">
    </p>
      </div>
    </div>
  <p align="center">
    <span class="style1">
    <input type="submit" name="Submit" value="Modificar">
  </span> </p>
</form>
<p>
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
</p>
