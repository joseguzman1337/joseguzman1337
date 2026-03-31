<?php
session_start();
?>
<?php
//ini_set("display_errors", "on");
//error_reporting(1);
//unset($_SESSION['resultadosvotaciones']);
/*unset($_SESSION['resultadosvotaciones']['datos_pie']);
unset($_SESSION['resultadosvotaciones']['votos']);
unset($_SESSION['resultadosvotaciones']['ganadores']);*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="UTF-8">
<title>Universidad El Bosque</title>
<link rel="stylesheet" type="text/css" href="../../estilos/sala.css">
<link rel="stylesheet" type="text/css" href="../../estilos/sala.css">
<script type="text/javascript" src="../../funciones/javascript/funciones_javascript.js"></script>
<style type="text/css">@import url(../../funciones/calendario_nuevo/calendar-win2k-1.css);</style>
<script type="text/javascript" src="../../funciones/calendario_nuevo/calendar.js"></script>
<script type="text/javascript" src="../../funciones/calendario_nuevo/calendar-es.js"></script>
<script type="text/javascript" src="../../funciones/calendario_nuevo/calendar-setup.js"></script>
<script type="text/javascript" src="../../funciones/clases/formulario/globo.js"></script>
<script type="text/javascript" src="../../funciones/sala_genericas/ajax/requestxml.js"></script>
<script type="text/javascript" src="requestescrutinio.js"></script>
<body>
<?php
$fechahoy=date("Y-m-d H:i:s");
$rutaado=("../../funciones/adodb/");
require_once('../../Connections/salaado-pear.php');
//require_once("../../funciones/clases/motorv2/motor.php");
require_once("../../funciones/sala_genericas/clase_formulario.php");
require_once("../funciones/obtenerDatos.php");
require_once("../../funciones/sala_genericas/FuncionesCadena.php");
require_once("../../funciones/sala_genericas/FuncionesFecha.php");
require_once("../../funciones/sala_genericas/formulariobaseestudiante.php");
require_once("../../funciones/sala_genericas/clasebasesdedatosgeneral.php");
$fechahoy=date("Y-m-d H:i:s");
$formulario=new formulariobaseestudiante($sala,'form1','post','','true');
$objetobase=new BaseDeDatosGeneral($sala);

//exit();
$escrutinio = new Votaciones(&$sala,false);
$escrutinio->leerVotacion('',0);
// //exit();
/*
echo "<pre>";
print_r($_SESSION['resultadosvotaciones']);
echo "</pre>";
  echo "<pre>";
print_r($_POST);
echo "</pre>";
*/
if(isset($_POST['idvotacion']))
{
$_SESSION['resultadosvotaciones']['votos']=$votos;
$_SESSION['resultadosvotaciones']['ganadores']=$ganadores;
$_SESSION['resultadosvotaciones']['votacioncarrera']=$_POST['menucarrera'];
$_SESSION['resultadosvotaciones']['votacionplantilla']=$_POST['menuplantilla'];
$_SESSION['resultadosvotaciones']['idvotacion']=$_POST['idvotacion'];
}



$escrutinio->asignarEscrutinios($_SESSION['resultadosvotaciones']['idvotacion'],0);
//$ganadores=$escrutinio->ordenaArrayParaCalculoGanadoresSegunConteo();
if(is_array($escrutinio->array_tipos_plantillas_votacion))
$votos=$escrutinio->retornaArrayConteoVotos();
/*echo "<pre>";
print_r($votos);
echo "</pre>";*/
foreach ($votos as $llave => $valor){

  		$arraymenutipoplantilla[$valor["idtipoplantillavotacion"]]=$valor["nombretipoplantillavotacion"];
  		$arraymenucarrera[$valor["codigocarrerapertenenciaplantilla"]]=$valor["nombrecarrerapertenciaplantilla"];

	//$_SESSION['datos_pie'][]=array('etiquetas'=>$valor['representanteplantilla'],'valores'=>$valor['CantVotos']);
}
foreach ($votos as $llave => $valor){
  		//$arraymenutipoplantilla[$valor["idtipoplantillavotacion"]]=$valor["nombretipoplantillavotacion"];
  		//$arraymenucarrera[$valor["codigocarrerapertenenciaplantilla"]]=$valor["nombrecarrerapertenciaplantilla"];
	
	if($_SESSION['resultadosvotaciones']['votacioncarrera']==$valor["codigocarrerapertenenciaplantilla"]){
		if($_SESSION['resultadosvotaciones']['votacionplantilla']==$valor['idtipoplantillavotacion']){
			$_SESSION['resultadosvotaciones']['nombrecarrera']=$valor['nombrecarrerapertenciaplantilla'];
			$resultadovotostmp["PLANTILLA"]=$votos[$llave]["nombreplantillavotacion"];
			$resultadovotostmp["VOTOS"]=$votos[$llave]["CantVotos"];
			$resultadovotostmp["GRUPO_DE_VOTACION"]=$votos[$llave]["nombretipoplantillavotacion"];
			$resultadovotostmp["REPRESENTANTE"]=$votos[$llave]["representanteplantilla"];
			$resultadovotostmp["CARGO"]=$votos[$llave]["representanteplantilla"];
			$resultadovotostmp["CARRERA"]=$votos[$llave]["nombrecarrerapertenciaplantilla"];
			$_SESSION['resultadosvotaciones']['resultadofiltro'][]=$resultadovotostmp;
			$_SESSION['resultadosvotaciones']['datos_pie'][]=array('etiquetas'=>$valor['representanteplantilla'],'valores'=>$valor['CantVotos']);
		}
	}
}
//echo "<pre>";
	//print_r($_SESSION['resultadosvotaciones']['resultadofiltro']);
// echo "</pre>";

?>
<?php 

if(isset($_POST['menuplantilla'])&&trim($_POST['menuplantilla'])!='')
{
$arraydireccion=explode("serviciosacademicos",$_SERVER['REQUEST_URI']);
$direccion="http://".$_SERVER['SERVER_NAME'].$arraydireccion[0]."serviciosacademicos/votaciones/informes/escrutinioajax.php";
echo "\n<META HTTP-EQUIV='Refresh' CONTENT='0;URL=".$direccion."'>\n";
}

echo "<form name='form1' id='form1' action='escrutinioajax.php' method='POST' >
	<input type='hidden' name='AnularOK' value='' onChange=''>
	<table border='1' cellpadding='1' cellspacing='0' bordercolor='#E9E9E9' width='750'>";
	$formulario->dibujar_fila_titulo('VOTACIONES','labelresaltado',"2","align='center'");
	for($i=0;$i<count($escrutinio->array_datos_votacion);$i++){
	$formulario->filatmp[$escrutinio->array_datos_votacion[$i]["idvotacion"]]=$escrutinio->array_datos_votacion[$i]["nombrevotacion"];
	}
	$formulario->filatmp[""]="Seleccionar";
	$menu='menu_fila'; $parametros="'idvotacion','".$_SESSION['resultadosvotaciones']['idvotacion']."','onchange=\'enviar();\''";
	$formulario->dibujar_campo($menu,$parametros,"Votaciones","tdtitulogris","idvotacion",'requerido');
	unset($formulario->filatmp);

	if(isset($_SESSION['resultadosvotaciones']['idvotacion'])&&$_SESSION['resultadosvotaciones']['idvotacion']!=''){
		$formulario->filatmp=$arraymenucarrera;
		$formulario->filatmp[""]="Seleccionar";
		$menu='menu_fila'; $parametros="'menucarrera','".$_SESSION['resultadosvotaciones']['votacioncarrera']."','onchange=\'enviar();\''";
		$formulario->dibujar_campo($menu,$parametros,"Carrera","tdtitulogris","menucarrera",'requerido');
		unset($formulario->filatmp);
		$formulario->filatmp=$arraymenutipoplantilla;
		$formulario->filatmp[""]="Seleccionar";
		$menu='menu_fila'; $parametros="'menuplantilla','".$_SESSION['resultadosvotaciones']['votacionplantilla']."','onchange=\'enviar();\''";
		$formulario->dibujar_campo($menu,$parametros,"Grupo de votación","tdtitulogris","menuplantilla",'requerido');
	}
	echo "<tr><td colspan='2'>";
	//echo "<iframe id='frametabladatos' src='tabladatos.php' height='260' width='800'></iframe>";
	echo "</td></tr>";
	echo " </table></form>";


?>
<div id='tablaescrutinio'></div>
<div id='graficaescrutinio'></div>
<script language="javascript">
function enviar(){
var formulario=document.getElementById("form1");
formulario.submit();
}
function llamadaFrame(){


var filetabla="tabladatosajax.php";
requestTXT(filetabla,params);
//setTimeout("llamagraficaescrutinio()",1000);
setTimeout("llamatablaescrutinio()",1000);

setTimeout("llamadaFrame()",3000);
//



}
function llamagraficaescrutinio(){
document.getElementById("graficaescrutinio").innerHTML=xmlHttpEscrutinio.responseText;
}
function llamatablaescrutinio()
{
var filegrafica="pieEscrutinioajax.php";
requestEscrutinioTXT(filegrafica,params);
document.getElementById("tablaescrutinio").innerHTML=xmlHttp2.responseText;

//document.getElementById("graficaescrutinio").innerHTML="";
//alert("escrutinio:\n"+xmlHttp2.responseText);
setTimeout("llamagraficaescrutinio()",1000);
}

function inicio(){
alert("escrutinio:\n"+xmlHttp2.responseText);
document.getElementById("menuescrutinio").innerHTML=xmlHttp2.responseText;
}

xmltmpHttp2=xmlHttp2;
var params="";
setTimeout("llamadaFrame()",1000);
//llamadaFrame();
</script>
</body>
</html>