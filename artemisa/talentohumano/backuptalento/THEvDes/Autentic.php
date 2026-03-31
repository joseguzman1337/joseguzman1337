<?php require_once('Connections/conexion.php'); ?>
<?php
mysql_select_db($database_conexion, $conexion);
$query_AutentDirect = "SELECT * FROM tjefdep ORDER BY JefDepen ASC";
$AutentDirect = mysql_query($query_AutentDirect, $conexion) or die(mysql_error());
$row_AutentDirect = mysql_fetch_assoc($AutentDirect);
$totalRows_AutentDirect = mysql_num_rows($AutentDirect);
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

if (isset($_POST['usuario'])) {

  $loginUsername=$_POST['usuario'];
  $password=$_POST['cedula'];
  $MM_fldUserAuthorization = "";
  $MM_redirectLoginSuccess = "EvalDes.php";
  $MM_redirectLoginFailed = "NoAutenticado.php";
  $MM_redirecttoReferrer = false;
  mysql_select_db($database_conexion, $conexion);
  
  $LoginRS__query=sprintf("SELECT JefDepen, CCJefDep FROM tjefdep WHERE JefDepen='%s' AND CCJefDep='%s'",
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
.Estilo26 {font-size: 12px}
-->
</style>
</head>
POST
<body>
<table width="838" border="0">
  <tr>
    <td width="155" height="72" bgcolor="#98BD0D"><div align="center" class="Estilo22"><img src="IMAGENES/LOGOBOSQUETH.jpg" alt="as" width="138" height="62" /></div></td>
    <td width="673" bgcolor="#98BD0D"><div align="center" class="Estilo4 Estilo24">FORMULARIO DE AUTENTICACION DE USUARIO<br />
    PARA DILIGENCIAR EVALUACION DE DESEMPE&Ntilde;O<br />
    DE COLABORADORES CONTRATADOS A T&Eacute;RMINO FIJO E INDEFINIDO </div></td>
  </tr>
</table>
<table width="841" border="0">
  <tr>
    <td bgcolor="#FFB112"><div align="center" class="Estilo4">DEPARTAMENTO DE TALENTO HUMANO - CONSTRUYENDO UN MEJOR EQUIPO </div></td>
  </tr>
</table>
<br />
<table width="840" border="0">
  <tr>
    <td><div align="center">
      <p class="Estilo4">Estimado jefe, por favor escoja su nombre en la lista y escriba su c&eacute;dula sin puntos ni espacios. Luego presione &quot;Ingresar  a evaluaci&oacute;n de desempe&ntilde;o &quot;.</p>
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
          <label>
          <select name="usuario">
            <option value="">Escoja su nombre</option>
            <?php
do {  
?>
            <option value="<?php echo $row_AutentDirect['JefDepen']?>"><?php echo $row_AutentDirect['JefDepen']?></option>
            <?php
} while ($row_AutentDirect = mysql_fetch_assoc($AutentDirect));
  $rows = mysql_num_rows($AutentDirect);
  if($rows > 0) {
      mysql_data_seek($AutentDirect, 0);
	  $row_AutentDirect = mysql_fetch_assoc($AutentDirect);
  }
?>
          </select>
          </label>
        </div></td>
    </tr>
    <tr>
      <td class="Estilo4"><div align="right">C&eacute;dula <span class="Estilo26">(sin puntos ni espacios)</span> </div></td>
      <td class="Estilo4">
        <div align="left">
          <input name="cedula" type="text" size="45" />
        </div></td>
    </tr>
    <tr>
      <td colspan="2" class="Estilo4"><div align="center">
        <input type="submit" name="Submit" value="Ingresar a evaluaci&oacute;n de desempe&ntilde;o" />
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
<?php
mysql_free_result($AutentDirect);
?>
