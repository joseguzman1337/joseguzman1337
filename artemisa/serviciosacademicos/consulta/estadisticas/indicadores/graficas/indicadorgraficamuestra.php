<?php
session_start();
include_once('../../../../utilidades/ValidarSesion.php'); 
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION);

//session_start();
/*include_once $rutaofc.'funciones/clases/ofc-library/open_flash_chart_object.php';
open_flash_chart_object( 800, 250, 'http://'. $_SERVER['SERVER_NAME'] .'/~javeeto/pruebas/openflash/tutorial-data-2.php', false );*/
function mostrarObjetoFlashGrafica($indicefila){
$arraydireccion=explode("serviciosacademicos",$_SERVER['REQUEST_URI']);
$rutarelativa="http://".$_SERVER['SERVER_NAME'].$arraydireccion[0]."serviciosacademicos/";
$rutadatosgrafica="consulta/estadisticas/indicadores/graficas/indicadorgrafica.php?indicefila=".$indicefila;

$rutaflash="funciones/clases/ofc-library/open-flash-chart.swf";

$cadenaimagen="<html><head>
<script LANGUAGE='JavaScript'>
//alert('".$rutadatosgrafica."');
</script>
</head>
<body style='margin:0px;padding: 0px;'>
<object classid='clsid:d27cdb6e-ae6d-11cf-96b8-444553540000'
 codebase='http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0' 
 id='graphx' align='middle' height='100%' width='100%'>
<param name='allowScriptAccess' value='always'>
<param name='movie' value='".$rutarelativa."".$rutaflash."?data=".$rutarelativa.$rutadatosgrafica."'>
<param name='quality' value='high'>
<param name='bgcolor' value='#FFFFFF'>
<embed src='".$rutarelativa."".$rutaflash."?data=".$rutarelativa.$rutadatosgrafica."' quality='high'
 bgcolor='#FFFFFF' name='open-flash-chart' allowscriptaccess='always' type='application/x-shockwave-flash'
  pluginspage='http://www.macromedia.com/go/getflashplayer' align='middle' height='100%' width='100%' id='graph'>
</object>';
</body>";
echo $cadenaimagen;
}
mostrarObjetoFlashGrafica($_GET["indicefila"]);
?>
