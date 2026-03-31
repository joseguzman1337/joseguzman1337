<?php require_once('Connections/conexion.php'); ?>
<?php
mysql_select_db($database_conexion, $conexion);
$query_Admini = "SELECT * FROM tautentadmon ORDER BY Nombre ASC";
$Admini = mysql_query($query_Admini, $conexion) or die(mysql_error());
$row_Admini = mysql_fetch_assoc($Admini);
$totalRows_Admini = mysql_num_rows($Admini);
?>
<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['Usuario'])) {
  $loginUsername=$_POST['Usuario'];
  $password=$_POST['Cedula'];
  $MM_fldUserAuthorization = "";
  $MM_redirectLoginSuccess = "AdmonOpciones.php";
  $MM_redirectLoginFailed = "NoAutenticadoAdm.php";
  $MM_redirecttoReferrer = false;
  mysql_select_db($database_conexion, $conexion);
  
  $LoginRS__query=sprintf("SELECT Nombre, IdAdmin FROM tautentadmon WHERE Nombre='%s' AND IdAdmin='%s'",
    get_magic_quotes_gpc() ? $loginUsername : addslashes($loginUsername), get_magic_quotes_gpc() ? $password : addslashes($password)); 
   
  $LoginRS = mysql_query($LoginRS__query, $conexion) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
     $loginStrGroup = "";
    
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;	      

    if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
  }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<style type="text/css">
<!--
.Estilo22 {color: #FFFFFF; font-weight: bold; }
.Estilo24 {color: #FFFFFF}
.Estilo4 {font-family: Tahoma;
	color: #596221;
	font-weight: bold;
}
-->
</style>
</head>

<body>
<table width="838" border="0">
  <tr>
    <td width="155" height="72" bgcolor="#98BD0D"><div align="center" class="Estilo22"><img src="IMAGENES/LOGOBOSQUETH.jpg" alt="as" width="138" height="62" /></div></td>
    <td width="673" bgcolor="#98BD0D"><div align="center" class="Estilo4 Estilo24">FORMULARIO DE AUTENTICACION DE <br />
      ADMINISTRADORES SISTEMA PERFILES DE CARGO </div></td>
  </tr>
</table>
<table width="841" border="0">
  <tr>
    <td bgcolor="#FFB112"><div align="center" class="Estilo4">DEPARTAMENTO DE TALENTO HUMANO - CONSTRUYENDO UN MEJOR EQUIPO </div></td>
  </tr>
</table>
<p>&nbsp;</p>
<table width="840" border="0">
  <tr>
    <td><div align="center">
      <p class="Estilo4">Estimado usuario, por favor escoja su nombre en la lista y escriba su c&eacute;dula sin puntos ni espacios. Luego presione &quot;Entrar a perfiles&quot;.</p>
    </div></td>
  </tr>
</table>
<p>&nbsp;</p>
<form id="form1" name="form1" method="POST" action="<?php echo $loginFormAction; ?>">
  <label></label>
  <p>
    <label></label>
    <label></label></p>
  <table width="840" border="0">
    <tr>
      <td width="409" class="Estilo4">
        <div align="right">Nombre usuario      </div></td>
      <td width="421" class="Estilo4"><select name="Usuario" id="Usuario">
        <option value="No ha seleccionado">Seleccione su nombre</option>
        <?php
do {  
?>
        <option value="<?php echo $row_Admini['Nombre']?>"><?php echo $row_Admini['Nombre']?></option>
        <?php
} while ($row_Admini = mysql_fetch_assoc($Admini));
  $rows = mysql_num_rows($Admini);
  if($rows > 0) {
      mysql_data_seek($Admini, 0);
	  $row_Admini = mysql_fetch_assoc($Admini);
  }
?>
                  </select></td>
    </tr>
    <tr>
      <td class="Estilo4">
        <div align="right">Cedula      </div></td>
      <td class="Estilo4"><input name="Cedula" type="text" id="Cedula" /></td>
    </tr>
    <tr>
      <td colspan="2" class="Estilo4"><div align="center">
        <input type="submit" name="Submit" value="Entrar al sistema " />
      </div></td>
    </tr>
  </table>
  <p>&nbsp;</p>
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($Admini);
?>
