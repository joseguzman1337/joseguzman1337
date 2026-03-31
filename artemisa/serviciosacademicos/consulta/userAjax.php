<?php require_once('../Connections/sala2.php');
session_start();
//print_r($_SESSION);
?>
<script language="javascript">
var browser = navigator.appName;
function hRefCentral(url){
	if(browser == 'Microsoft Internet Explorer'){
		parent.contenidocentral.location.href(url);
	}
	else{
		parent.contenidocentral.location=url;
	}
	return true;
}
</script>
<?php
include('validar.php');
if ($no==1){
	echo '<script language="javascript">hRefCentral("facultades/central.php");alert("Error de validacion");</script>';

}else if ($no==2){
	echo '<script language="javascript">hRefCentral("facultades/central.php");alert("Docente no encontrado, por favor acercarse a la facultad para asignar docente al curso correspondiente");</script>';

}else if ($ok==1){
	foreach ($_SESSION as $llave => $valor){
		unset($_SESSION[$llave]);
	}
	echo '<script language="javascript">hRefCentral("facultades/central.php");alert("Creación de usuario SALA realizada correctamente. Porfavor reingrese de nuevo al sistema para generar segunda clave");</script>';


}else if ($ok==2){
	foreach ($_SESSION as $llave => $valor){
		unset($_SESSION[$llave]);
	}

	echo '<script language="javascript">hRefCentral("facultades/central.php");alert("Creación de usuario SALA realizada correctamente. Porfavor reingrese de nuevo al sistema para generar segunda clave");</script>';
	;
	//$url="./digitacion/digitacionnotas.htm";
	//echo "<meta http-equiv=\"refresh\" content=\"0;url=$url\">\r\n";

}else {
	//$MM_restrictGoTo = "login.php";
	//if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {
	/*$MM_qsChar = "?";
	$MM_referrer = $_SERVER['PHP_SELF'];
	if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
	if (isset($QUERY_STRING) && strlen($QUERY_STRING) > 0)
	$MM_referrer .= "?" . $QUERY_STRING;
	$MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
	header("Location: ". $MM_restrictGoTo); */
	//exit;
	//}
	mysql_select_db($database_sala, $sala);
	$query_Recordset1 = "SELECT * FROM documento";
	$Recordset1 = mysql_query($query_Recordset1, $sala) or die(mysql_error());
	$row_Recordset1 = mysql_fetch_assoc($Recordset1);
	$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<style type="text/css">
<!--
.style5 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: small; }
.style7 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: small; font-weight: bold; }
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
.style8 {
	color: #000000;
	font-weight: bold;
}
.Estilo1 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10px;
}
.Estilo2 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; }
-->
</style>
</head>

<body>

<!--div align="left"><img src="../../imagenes/sala/serviciosacademicosinterna.jpg" width="750" height="122"><br>-->
      <span class="style5"><br>
      </span>
</div>
<div align="right">
  <p align="left" class="style5 Estilo2">Usted esta como: 
        <span class="style8"><?php echo $_SESSION['MM_Username']; ?></span></p>
</div>
  <form action="userAjax.php" method="post" name="form1" class="Estilo1">
  <br>
  <br>
  <input type="hidden" id="estado" name="estado" value="<?php echo $_GET['estado'] ?>">
  <table width="82%"  border="0" cellpadding="2" cellspacing="2">
    <tr>
      <td align="right">&nbsp;</td>
      <td><select name="rol" id="rol">
        <option value="" <?php if (!(strcmp("", $_POST['rol']))) {echo "SELECTED";} ?>>Seleccione una Opci&oacute;n</option>
        <option value="1" <?php if (!(strcmp(1, $_POST['rol']))) {echo "SELECTED";} ?>>Estudiante</option>
        <option value="2" <?php if (!(strcmp(2, $_POST['rol']))) {echo "SELECTED";} ?>>Docente</option>
      </select>
        
        <?php 
        if ($tiporol==1) {
        	echo "Falta Selecionar ";
        } else {

        }
	  ?>
      </td>
    </tr>
    <tr>
      <td width="23%" align="right"><strong>Tipo de documento:</strong></td>
      <td width="77%">
	    <select name="tipodocumento" id="tipodocumento">
	      <option value="" <?php if (!(strcmp("", $_POST['tipodocumento']))) {echo "SELECTED";} ?>>Selecione una opción</option>
	      <?php
	      do {
?>
	      <option value="<?php echo $row_Recordset1['tipodocumento']?>"<?php if (!(strcmp($row_Recordset1['tipodocumento'], $_POST['tipodocumento']))) {echo "SELECTED";} ?>><?php echo $row_Recordset1['nombredocumento']?></option>
	      <?php
	      } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1));
	      $rows = mysql_num_rows($Recordset1);
	      if($rows > 0) {
	      	mysql_data_seek($Recordset1, 0);
	      	$row_Recordset1 = mysql_fetch_assoc($Recordset1);
	      }
?>
        </select>
	    <?php 
	    if ($tipodoc==1) {
	    	echo "Falta Selecionar el Tipo de documento";
	    } else {

	    }
	  ?>
</td>
    </tr>
    <tr>
      <td align="right"><strong>N&uacute;mero documento</strong></td>
      <td><input name="numerodocumento" type="text" value="<?php echo $_POST['numerodocumento'];?>" size="32">
        
        <?php 
        if ($numdoc==1) {
        	echo "Debe digitar el número";
        } else {

        }
	  ?>
      </td>
    </tr>
    <tr>
      <td align="right"><strong>Apellidos</strong></td>
      <td><input name="apellidos" type="text" value="<?php echo $_POST['apellidos'];?>" size="32">
        
        <?php 
        if ($apelli==1) {
        	echo "Por favor coloque sus nombres";
        } else {

        }
	  ?>
      </td>
    </tr>
    <tr>
      <td align="right"><strong>Nombres:</strong></td>
      <td><input name="nombres" type="text" value="<?php echo $_POST['nombres'];?>" size="32">
        
        <?php 
        if ($nomb==1) {
        	echo "Por favor coloque sus apellidos";
        } else {

        }
	  ?>
      </td>
    </tr>
    <tr>
      <td align="right"><strong>C&oacute;digo n&oacute;mina o n&uacute;mero de documento</strong><br>
        (Solo para Docentes)</td>
      <td><input name="codigousuario" type="text" value="<?php echo $_POST['codigousuario'];?>" size="32">
        
        <?php 
        if ($cod==1) {
        	echo "Debe colocar su código";
        } else {

        }
	  ?>
      </td>
    </tr>
   <tr>
      <td align="right"><strong>Semestre</strong><br>
        (Solo para Estudiantes) </td>
      <td valign="top"><input name="semestre" type="text" id="semestre" value="<?php echo $_POST['semestre'];?>" maxlength="3">
        
        <?php 
        if ($sem==1) {
        	echo "Debe colocar el semestre en el que se encuentra";
        } else {

        }
	  ?>
      </td>
    </tr>
    <tr>
      <td align="right"><input name="user" type="hidden"></td>
      <td><input name="Submit2" type="submit" id="Submit22" value="Guardar Cambios"></td>
    </tr>
  </table>
  <div align="center"></div>
</form>
<p class="Estilo1">&nbsp;</p>

<p class="Estilo1">&nbsp;</p>

</body>
</html>
<?php
mysql_free_result($Recordset1);
}
?>
