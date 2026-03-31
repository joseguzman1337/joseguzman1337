<?php
session_start();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; encoding=UTF-8">
<title>Documento sin t&iacute;tulo</title>
<link rel="stylesheet" type="text/css" href="../../estilos/sala.css">
</head>
<?php
ini_set("display_errors", "0");
error_reporting(0);
unset($_SESSION['resultadosvotaciones']);
/*unset($_SESSION['resultadosvotaciones']['datos_pie']);
unset($_SESSION['resultadosvotaciones']['votos']);
unset($_SESSION['resultadosvotaciones']['ganadores']);*/
?>
<body>
<script language="javascript">
function enviar(){
form1.submit();
}
</script>
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
//exit();
$escrutinio = new Votaciones(&$sala,false);
$escrutinio->leerVotacion('',0);
//echo "<pre>";
//print_r($escrutinio->array_datos_votacion);
//echo "</pre>";
/*  echo "<pre>";
print_r($votos);
echo "</pre>";
 */ //exit();
$_SESSION['resultadosvotaciones']['votos']=$votos;
$_SESSION['resultadosvotaciones']['ganadores']=$ganadores;
$_SESSION['resultadosvotaciones']['votacioncarrera']=$_POST['menucarrera'];
$_SESSION['resultadosvotaciones']['votacionplantilla']=$_POST['menuplantilla'];
$_SESSION['resultadosvotaciones']['idvotacion']=$_POST['idvotacion'];

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
<link rel="stylesheet" type="text/css" href="../../estilos/sala.css">
<script type="text/javascript" src="../../funciones/javascript/funciones_javascript.js"></script>
<style type="text/css">@import url(../../funciones/calendario_nuevo/calendar-win2k-1.css);</style>
<script type="text/javascript" src="../../funciones/calendario_nuevo/calendar.js"></script>
<script type="text/javascript" src="../../funciones/calendario_nuevo/calendar-es.js"></script>
<script type="text/javascript" src="../../funciones/calendario_nuevo/calendar-setup.js"></script>
<script type="text/javascript" src="../../funciones/clases/formulario/globo.js"></script>
<?php 

echo "<form name='form1' action='' method='POST' >
	<input type='hidden' name='AnularOK' value='' onChange=''>
	<table border='1' cellpadding='1' cellspacing='0' bordercolor='#E9E9E9' width='750'>";
	$formulario->dibujar_fila_titulo('VOTACIONES','labelresaltado',"2","align='center'");
	for($i=0;$i<count($escrutinio->array_datos_votacion);$i++){
	$formulario->filatmp[$escrutinio->array_datos_votacion[$i]["idvotacion"]]=$escrutinio->array_datos_votacion[$i]["nombrevotacion"];
	}
	$formulario->filatmp[""]="Seleccionar";
	$menu='menu_fila'; $parametros="'idvotacion','".$_POST['idvotacion']."','onchange=\'enviar(); parent.topFrame.location.reload();\''";
	$formulario->dibujar_campo($menu,$parametros,"Votaciones","tdtitulogris","idvotacion",'requerido');
	unset($formulario->filatmp);

	if(isset($_POST['idvotacion'])&&$_POST['idvotacion']!=''){
		$formulario->filatmp=$arraymenucarrera;
		$formulario->filatmp[""]="Seleccionar";
		$menu='menu_fila'; $parametros="'menucarrera','".$_POST['menucarrera']."','onchange=\'enviar(); parent.topFrame.location.reload();\''";
		$formulario->dibujar_campo($menu,$parametros,"Carrera","tdtitulogris","menucarrera",'requerido');
		unset($formulario->filatmp);
		$formulario->filatmp=$arraymenutipoplantilla;
		$formulario->filatmp[""]="Seleccionar";
		$menu='menu_fila'; $parametros="'menuplantilla','".$_POST['menuplantilla']."','onchange=\'enviar(); parent.topFrame.location.reload();\''";
		$formulario->dibujar_campo($menu,$parametros,"Grupo de votación","tdtitulogris","menuplantilla",'requerido');
	}

	echo "<tr><td colspan='2'>";
	echo "<iframe id='frametabladatos' src='tabladatos.php' height='260' width='800'></iframe>";
	echo "</td></tr>";
	echo "	
  </table>
</form>";
?>

</body>
</html>