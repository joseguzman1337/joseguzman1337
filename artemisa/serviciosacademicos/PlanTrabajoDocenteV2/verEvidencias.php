<?php
session_start();
/*include_once('../utilidades/ValidarSesion.php'); 
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION);*/

header ('Content-type: text/html; charset=utf-8');
header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

//var_dump($db);
if($db==null){
	include_once ('../EspacioFisico/templates/template.php');
	$db = getBD(); 
}

if($_POST){ 
    $keys_post = array_keys($_POST); 
    foreach ($keys_post as $key_post){ 
      $$key_post = $_POST[$key_post] ; 
     } 
 }

 if($_GET){
    $keys_get = array_keys($_GET); 
    foreach ($keys_get as $key_get){ 
        $$key_get = $_GET[$key_get]; 
     } 
 }



$idDocente = $_GET["idDocente"];

$idPrograma = $_GET["idPrograma"];

$idPeriodo = $_GET["idPeriodo"];

$sqlNombreCarrera = "SELECT 
						nombrecarrera 
						FROM carrera 
						WHERE codigocarrera = $idPrograma";

$nombreCarrera = $db->Execute( $sqlNombreCarrera );


?>
<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>elFinder 2.0</title>

		<!-- jQuery and jQuery UI (REQUIRED) -->
		<link rel="stylesheet" type="text/css" media="screen" href="tema/elfinder/css/jquery-ui.css" charset="utf-8">
		<script type="text/javascript" src="tema/elfinder/js/jquery.min.js" charset="utf-8"></script>
		<script type="text/javascript" src="tema/elfinder/js/jquery-ui.min.js"  charset="utf-8"></script>

		<!-- elFinder CSS (REQUIRED) -->
		<link rel="stylesheet" type="text/css" media="screen" href="tema/elfinder/css/elfinder.min.css" charset="utf-8">
		<link rel="stylesheet" type="text/css" media="screen" href="tema/elfinder/css/theme.css" charset="utf-8">
		<link rel="stylesheet" type="text/css" media="screen" href="tema/elfinder/css/cwd.css" charset="utf-8">

		<!-- elFinder JS (REQUIRED) -->
		<script type="text/javascript" src="tema/elfinder/js/elfinder.min.js" charset="utf-8"></script>

		<!-- elFinder translation (OPTIONAL) -->
		<!--<script type="text/javascript" src="tema/elfinder/js/i18n/elfinder.ru.js" charset="utf-8"></script>-->
		<script src="tema/elfinder/js/i18n/elfinder.es.js" type="text/javascript" charset="utf-8"></script>

		<!-- elFinder initialization (REQUIRED) -->
		<script type="text/javascript" charset="utf-8">
			$().ready(function() {
				var elf = $('#elfinderEvidencia').elfinder({
					url : 'tema/elfinder/php/connector.php?idDocente=<?php echo $idDocente; ?>&idPrograma=<?php echo $idPrograma;?>&idPeriodo=<?php echo $idPeriodo;?>',  // connector URL (REQUIRED)
					lang: 'es'             // language (OPTIONAL)
				}).elfinder('instance');
			});
		</script>
	</head>
	<body>
		<br />
		<div>
			<span style="color:#075DB2; font-family: 'Lucida Sans Unicode', 'Lucida Grande', sans-serif"><?php echo $nombreCarrera->fields["nombrecarrera"]; ?></span>
		</div>
		<br />
		<!-- Element where elFinder will be created (REQUIRED) -->
		<div id="elfinderEvidencia"></div>

	</body>
</html>