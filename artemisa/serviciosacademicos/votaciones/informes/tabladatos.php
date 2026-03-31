<?php
session_start();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Documento sin t&iacute;tulo</title>
<link rel="stylesheet" type="text/css" href="../../estilos/sala.css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"><style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style></head>
<?php
//ini_set("display_errors", "0");
//error_reporting(0);
unset($_SESSION['resultadosvotaciones']['resultadofiltro']);
unset($_SESSION['resultadosvotaciones']['datos_pie']);
unset($_SESSION['resultadosvotaciones']['votos']);
unset($_SESSION['resultadosvotaciones']['ganadores']);
 
 ?>
<body>
<?php
$fechahoy=date("Y-m-d H:i:s");
$rutaado=("../../funciones/adodb/");
require_once('../../Connections/salaado-pear.php');
require_once("../../funciones/clases/motorv2/motor.php");
require_once("../../funciones/clases/formulariov2/clase_formulario.php");
require_once("../funciones/obtenerDatos.php");
require_once("../../funciones/sala_genericas/FuncionesCadena.php");
require_once("../../funciones/sala_genericas/FuncionesFecha.php");
require_once("../../funciones/sala_genericas/formulariobaseestudiante.php");
require_once("../../funciones/sala_genericas/clasebasesdedatosgeneral.php");

$fechahoy=date("Y-m-d H:i:s");

$formulario=new formulariobaseestudiante($sala,'form1','post','','true');
$objetobase=new BaseDeDatosGeneral($sala);

//echo "CARRERA1=".$_SESSION['resultadosvotaciones']['votacioncarrera'];


$escrutinio = new Votaciones(&$sala,false);
//if(is_array($escrutinio->array_tipos_plantillas_votacion))
if(isset($_SESSION['resultadosvotaciones']['votacioncarrera'])&&$_SESSION['resultadosvotaciones']['votacioncarrera']!='')
	$escrutinio->asignarEscrutinios($_SESSION['resultadosvotaciones']['idvotacion']);
//$ganadores=$escrutinio->ordenaArrayParaCalculoGanadoresSegunConteo();

$votos=$escrutinio->retornaArrayConteoVotos();
//echo "CARRERA2=".$_SESSION['resultadosvotaciones']['votacioncarrera'];
/*echo "<pre>";
print_r($votos);
echo "</pre>";*/
//if(isset($_SESSION['resultadosvotaciones']['idvotacion'])&&$_SESSION['resultadosvotaciones']['idvotacion']!=''){

	$_SESSION['resultadosvotaciones']['votos']=$votos;
	$_SESSION['resultadosvotaciones']['ganadores']=$ganadores;
	if(is_array($votos))
	foreach ($votos as $llave => $valor){
		if($_SESSION['resultadosvotaciones']['votacioncarrera']==$valor["codigocarrerapertenenciaplantilla"]){
			if($_SESSION['resultadosvotaciones']['votacionplantilla']==$valor['idtipoplantillavotacion']){
				$resultadovotostmp["PLANTILLA"]=$votos[$llave]["nombreplantillavotacion"];
				$resultadovotostmp["VOTOS"]=$votos[$llave]["CantVotos"];
				$resultadovotostmp["GRUPO_DE_VOTACION"]=$votos[$llave]["nombretipoplantillavotacion"];
				$resultadovotostmp["REPRESENTANTE"]=$votos[$llave]["representanteplantilla"];
				$resultadovotostmp["CARGO"]=$votos[$llave]["cargo"];
				$resultadovotostmp["CARRERA"]=$votos[$llave]["nombrecarrerapertenciaplantilla"];
				$_SESSION['resultadosvotaciones']['resultadofiltro'][]=$resultadovotostmp;
				$_SESSION['resultadosvotaciones']['datos_pie'][]=array('etiquetas'=>$valor['representanteplantilla'],'valores'=>$valor['CantVotos']);
			}
		}
	}
//}
/* echo "<pre>";
	echo "CARRERA=".$_SESSION['resultadosvotaciones']['votacioncarrera'];
 echo "</pre>";
 */ 
/*  echo "<pre>";
print_r($_SESSION['resultadosvotaciones']['resultadofiltro']);
echo "</pre>";
 */
?>
<link rel="stylesheet" type="text/css" href="../../estilos/sala.css">
<script type="text/javascript" src="../../funciones/javascript/funciones_javascript.js"></script>
<style type="text/css">@import url(../../funciones/calendario_nuevo/calendar-win2k-1.css);</style>
<script type="text/javascript" src="../../funciones/calendario_nuevo/calendar.js"></script>
<script type="text/javascript" src="../../funciones/calendario_nuevo/calendar-es.js"></script>
<script type="text/javascript" src="../../funciones/calendario_nuevo/calendar-setup.js"></script>
<script type="text/javascript" src="../../funciones/clases/formulario/globo.js"></script>
<?php 

echo "
	
	<table border='1' cellpadding='1' cellspacing='0' bordercolor='#E9E9E9' width='700'>
	";

	$formulario->dibujar_fila_titulo('RESULTADOS '.$_SESSION['resultadosvotaciones']['nombrecarrera'],'labelresaltado',"2","align='center'");
	echo "<tr><td colspan='2'>";
	$escrutinio->DibujarTablaNormal($_SESSION['resultadosvotaciones']['resultadofiltro'],"");
	//$formulario->dibujar_fila_titulo('MAYOR VOTACION','labelresaltado',"2","align='center'");
	//$escrutinio->DibujarTablaNormal($_SESSION['resultadosvotaciones']['ganadores'],"");
	echo "</td></tr>";
	echo "	
 	 </table>";
?>
</body>
</html>