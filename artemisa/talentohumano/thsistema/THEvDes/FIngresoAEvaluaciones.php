<?php 
require_once('../Connections/conexion.php'); 
mysql_select_db($database_conexion, $conexion);
$query_ListaJefes = "SELECT * FROM tlistacol GROUP BY JefeCol ORDER BY JefeCol ";
$ListaJefes = mysql_query($query_ListaJefes, $conexion) or die(mysql_error());
$row_ListaJefes = mysql_fetch_assoc($ListaJefes);
$totalRows_ListaJefes = mysql_num_rows($ListaJefes);

// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['nombre'])) {
  $loginUsername=$_POST['nombre'];
  $password=$_POST['cedula'];$serializeArray = base64_encode($password);
  $MM_fldUserAuthorization = "";
  $MM_redirectLoginSuccess = "CListadoEvaluados.php?turtle=".$serializeArray;
  $MM_redirectLoginFailed = "FErrorIngresoJefes.php";
  $MM_redirecttoReferrer = false;
  mysql_select_db($database_conexion, $conexion);
  
  $LoginRS__query=sprintf("SELECT JefeCol, CCJefeCol FROM tlistacol WHERE JefeCol='%s' AND CCJefeCol='%s'",
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
<title>Ingreso a Evaluacion</title>
<link href="file:///C|/wamp/www/CSS/Psicologia.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
body {
	background-color: #FAECFF;
}
.Estilo65 {color: #FF0033}
.Estilo22 {color: #FFFFFF; font-weight: bold; }
.Estilo4 {font-family: Tahoma;
	color: #596221;
	font-weight: bold;
}
-->
</style>
<link href="../ESTILSOGC.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div align="center">
  <table width="838" border="0">
    <tr>
      <td width="155" height="72" bgcolor="#98BD0D"><div align="center" class="Estilo22"><img src="../IMAGENES/LOGOBOSQUETH.jpg" alt="as" width="138" height="62" /></div></td>
      <td width="673" bgcolor="#98BD0D"><div align="center" class="Estilo4">EVALUACI&Oacute;N DE DESEMPE&Ntilde;O <br />
        COLABORADORES A T&Eacute;RMINO FIJO E INDEFINIDO </div></td>
    </tr>
  </table>
  <table width="838" border="0">
    <tr>
      <td width="832" bgcolor="#FFB112"><div align="center" class="Estilo4">DIRECCI&Oacute;N  DE TALENTO HUMANO - CONSTRUYENDO UN MEJOR EQUIPO </div></td>
    </tr>
  </table>
</div>
<p align="center">&nbsp;</p>
<form id="form1" name="form1" method="POST" action="<?php echo $loginFormAction; ?>">
  <label></label>
  <label></label>
  <p>
    <label></label>
  </p>
  <p align="center" class="Estilo4"> Estimado(a) directivo(a), bienvenido(a) a la evaluaci&oacute;n de desempe&ntilde;o </p>
  <p align="center" class="Estilo4">Gracias por su participaci&oacute;n </p>
  <p>
    <span class="Estilo4">
    <label></label>
    </span></p>
  <table width="457" border="1" align="center">
    <tr>
      <td width="153" bgcolor="#FFEAFF" class="Estilo4">Nombre</td>
      <td width="288" bgcolor="#FFFFCC" class="Estilo4"><select name="nombre" class="Estilo4">
        <option value="0">Seleccione su nombre</option>
        <?php
do {  
?>
        <option value="<?php echo $row_ListaJefes['JefeCol']?>"><?php echo $row_ListaJefes['JefeCol']?></option>
<?php
} while ($row_ListaJefes = mysql_fetch_assoc($ListaJefes));
  $rows = mysql_num_rows($ListaJefes);
  if($rows > 0) {
      mysql_data_seek($ListaJefes, 0);
	  $row_ListaJefes = mysql_fetch_assoc($ListaJefes);
  }
?>
      </select></td>
    </tr>
    <tr>
      <td nowrap="nowrap" bgcolor="#FFEAFF" class="Estilo4">Digite su c&eacute;dula sin puntos </td>
      <td bgcolor="#FFFFCC" class="Estilo4"><input name="cedula" type="password" class="Estilo4" /></td>
    </tr>
    <tr>
      <td colspan="2" bgcolor="#FFFFCC" class="Estilo4"><div align="center">
        <input name="Submit" type="submit" class="Estilo39" value="Entrar al sistema" />
      </div></td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($ListaJefes);
?>