<?php
//initialize the session
session_start();
require_once('../../funciones/clases/autenticacion/redirect.php' ); 
// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
  //to fully log out a visitor we need to clear the session varialbles
  session_unregister('MM_Username');
  session_unregister('MM_UserGroup');
  session_unregister('codigo');
  session_unregister('periodos');
  session_unregister('grupos');
  session_unregister('materias');
  session_unregister('facultades');
	
  $logoutGoTo = "../login.php";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
}
?>
<?php
session_start();
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && true) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "../login.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($QUERY_STRING) && strlen($QUERY_STRING) > 0) 
  $MM_referrer .= "?" . $QUERY_STRING;
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Documento sin t&iacute;tulo</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<style type="text/css">
<!--
a:link {
	text-decoration: none;
}
a:visited {
	text-decoration: none;
}
a:hover {
	text-decoration: none;
}
a:active {
	text-decoration: none;
}
-->
</style>
<link href="file:///D|/Mis%20documentos/universidad/home/links.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.Estilo1 {
	font-family: Tahoma;
	font-size: x-small;
	font-weight: bold;
}
.Estilo2 {font-size: small}
-->
</style>
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);
//-->
</script>
</head>
<body>
<div id="Layer1" style="position:absolute; left:-2px; top:-52px; width:117px; height:180px; z-index:1"><img src="../../../imagenes/bordenotas1.jpg" width="170" height="600"></div>
<div id="Layer2" style="position:absolute; left:49px; top:47px; width:1px; height:19px; z-index:2">
  <p><a href="validacambioclave.php" target="contenidocentral"><img src="../../../imagenes/botondigitacionanotas.jpg" width="105" height="20" border="0"></a><a href="manualdigitacionnotasweb.pdf" target="_blank" class="Estilo1"> <img src="../../../imagenes/botonmanualusodignotas.jpg" width="79" height="18" border="0"></a> <a href="cursos.php" target="contenidocentral"><br>
  </a></p>
</div>
<div id="Layer3" style="position:absolute; left:50px; top:110px; width:109px; height:18px; z-index:3"><a href="listassala.php" target="contenidocentral"><img src="../../../imagenes/botonconsultalistados.jpg" width="112" height="20" border="0"></a></div>
<div id="Layer4" style="position:absolute; left:50px; top:215px; width:114px; height:18px; z-index:4; font-family: Tahoma; font-size: small; font-weight: bold;"><a href="hojasdevida/crearhojavida.htm" target="_top"><img src="../../../imagenes/botonhv.jpg" width="88" height="20" border="0"></a> </div>
<div id="Layer5" style="position:absolute; left:45px; top:270px; width:118px; height:21px; z-index:5; font-family: Tahoma; font-size: small;"><a href="<?php echo $logoutAction ?>" target="_top"><img src="../../../imagenes/botoncerrarsesion.jpg" width="87" height="20" border="0"></a></div>
<div id="Layer6" style="position:absolute; left:45px; top:160px; width:126px; height:20px; z-index:6"><a href="../facultades/consultaprematricula/listagrupos.php" target="contenidocentral"><img src="../../../imagenes/listadoestudiantes.jpg" width="124" height="20" border="0"></a></div>
</body>
</html>
