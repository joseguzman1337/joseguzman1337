<?php
session_start();
include_once('../utilidades/ValidarSesion.php'); 
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION);

//initialize the session
//session_start();
// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
	$logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){

	if(isset($_SESSION['nuevoMenu'])){
		$logoutGoTo = "facultades/consultafacultadesalt.htm";
	}
	else{
		$logoutGoTo = "login.php";
	}
	//to fully log out a visitor we need to clear the session varialbles
	foreach ($_SESSION as $nombre => $valor)
	{
		// echo "$nombre => $valor";
		session_unregister($nombre);
	}

	if ($logoutGoTo) {
		header("Location: $logoutGoTo");
		exit;
	}
}
?>

<?php
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



$MM_restrictGoTo = "login.php";
//unset($_SESSION['MM_Username']);

if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {

	//echo "<h3>MM_Username = ".$_SESSION['MM_Username']."MM_authorizedUsers $MM_authorizedUsers MM_Username = ".$_SESSION['MM_Username']."MM_UserGroup = ".$_SESSION['MM_UserGroup']."</h3>";
	$MM_qsChar = "?";

	$MM_referrer = $_SERVER['PHP_SELF'];

	if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";

	if (isset($QUERY_STRING) && strlen($QUERY_STRING) > 0)

	$MM_referrer .= "?" . $QUERY_STRING;

	$MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);

	//echo "<h1>$MM_restrictGoTo</h1>";
?>
<script language="javascript">
alert("Se ha cerrado la sesion")
self.parent.location=document.location.href="https://artemisa.unbosque.edu.co/serviciosacademicos/consulta/login.php";
</script>
<?php
//header("Location: ". $MM_restrictGoTo);
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

.Estilo1 {

	font-size: x-small;

	font-family: Tahoma;

}

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

<div id="Layer2" style="position:absolute; left:20; top:53px; width:49px; height:19px; z-index:2"><a href="consultanotassala.php" target="contenidocentral"><img src="../../imagenes/sala/consultanotas.jpg" width="131" height="19" border="0"></a></div>

<div align="right"><img src="../../imagenes/sala/linea.jpg" width="2" height="299"></div>
<div id="Layer3" style="position:absolute; left:20; top:85px; width:109px; height:18px; z-index:3"><a href="estadocredito/estado_cuenta.php" target="contenidocentral"><img src="../../imagenes/sala/extractocredito.jpg" width="131" height="19" border="0"></a></div>

<div id="Layer4" style="position:absolute; left:20; top:120px; width:114px; height:18px; z-index:4">

  <p><a href="prematricula/loginpru.php" target="contenidocentral"><img src="../../imagenes/sala/prematricula.jpg" width="131" height="19" border="0"></a><a href="manualprematricula/index.htm" target="_blank"><img src="../../imagenes/sala/manual.jpg" width="131" height="19" border="0"></a><br>

  <span class="Estilo1"> </span></p>
</div>

<div id="Layer5" style="position:absolute; left:20; top:205px; width:118px; height:21px; z-index:5; font-family: Tahoma; font-size: small;"><a href="<?php echo $logoutAction ?>" target="_top"><img src="../../imagenes/sala/cerrarsesion.jpg" width="131" height="19" border="0"></a></div>

<div id="Layer3" style="position:absolute; left:20; top:170px; width:133px; height:21px; z-index:3"><a href="ordenpagovarias/ordenpagovarias.php" target="contenidocentral"><img src="../../imagenes/sala/pagos.jpg" width="131" height="19" border="0"></a></div>

</body>

</html>
<script language="javascript">
window.open('aviso.php','aviso','width=550,height=550,left=10,top=10,sizeable=yes,scrollbars=no');
window.open('facultades/registro_graduados/carta_egresados/carta_egresados.php?codigoestudiante=<?php echo $codigo?>','carta','width=550,height=550,left=400,top=10,sizeable=yes,scrollbars=yes');
</script>
