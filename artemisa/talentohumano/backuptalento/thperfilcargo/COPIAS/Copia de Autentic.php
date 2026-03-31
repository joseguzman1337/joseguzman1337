<?php require_once('../Connections/conexion.php'); ?>
<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['textfield2'])) {
  $loginUsername=$_POST['textfield2'];
  $password=$_POST['textfield'];
  $MM_fldUserAuthorization = "";
  $MM_redirectLoginSuccess = "../IniPerfil.php";
  $MM_redirectLoginFailed = "../NoAutenticado.php";
  $MM_redirecttoReferrer = false;
  mysql_select_db($database_conexion, $conexion);
  
  $LoginRS__query=sprintf("SELECT Usuario, Cedula FROM tautenticacion WHERE Usuario='%s' AND Cedula='%s'",
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
.Estilo4 {font-family: Tahoma;
	color: #596221;
	font-weight: bold;
}
.Estilo24 {color: #FFFFFF}
-->
</style>
</head>

<body>
<table width="838" border="0">
  <tr>
    <td width="155" height="72" bgcolor="#98BD0D"><div align="center" class="Estilo22"><img src="../IMAGENES/LOGOBOSQUETH.jpg" alt="as" width="138" height="62" /></div></td>
    <td width="673" bgcolor="#98BD0D"><div align="center" class="Estilo4 Estilo24">FORMULARIO DE AUTENTICACION DE USUARIO </div></td>
  </tr>
</table>
<table width="841" border="0">
  <tr>
    <td bgcolor="#FFB112"><div align="center" class="Estilo4">DEPARTAMENTO DE TALENTO HUMANO - CONFORMANDO UN MEJOR EQUIPO </div></td>
  </tr>
</table>
<br />
<table width="840" border="0">
  <tr>
    <td><div align="center">
      <p class="Estilo4">Estimado directivo, por favor ingrese el usuario y contrase&ntilde;a enviados a usted<br /> 
        a trav&eacute;s de su e mail o solic&iacute;telos en Talento Humano extension 366 </p>
      </div></td>
  </tr>
</table>
<p>&nbsp;</p>
<form id="form1" name="form1" method="POST" action="<?php echo $loginFormAction; ?>">
  <table width="843" border="0" bgcolor="#FFFFCC">
    <tr>
      <td width="312" class="Estilo4"><div align="right">Usuario</div></td>
      <td width="521" class="Estilo4">
        <div align="left">
          <input name="textfield2" type="text" size="50" />
        </div></td>
    </tr>
    <tr>
      <td class="Estilo4"><div align="right">Contraseña</div></td>
      <td class="Estilo4">
        <div align="left">
          <input name="textfield" type="text" size="50" />
        </div></td>
    </tr>
    <tr>
      <td colspan="2" class="Estilo4"><div align="center">
        <input type="submit" name="Submit" value="Ingresar" />
      </div></td>
    </tr>
  </table>
  <label><br />
  <br />
  <br />
  <br />
  <br />
  </label>
</form>
<p>&nbsp;</p>
<p>&nbsp;</p>
</body>
</html>
