<?php
session_start();
?>
<?php
//ini_set("display_errors", "0");
//error_reporting(0);
unset($_SESSION['resultadosvotaciones']['resultadofiltro']);
unset($_SESSION['resultadosvotaciones']['datos_pie']);
unset($_SESSION['resultadosvotaciones']['votos']);
unset($_SESSION['resultadosvotaciones']['ganadores']);
if(file_exists($_SESSION['resultadosvotaciones']['imagenpieescrutinio']))
unlink($_SESSION['resultadosvotaciones']['imagenpieescrutinio']);
 
 ?>
<?php
$fechahoy=date("Y-m-d H:i:s");
$rutaado=("../../funciones/adodb/");
require_once('../../Connections/salaado-pear.php');
require_once("../../funciones/clases/motorv2/motor.php");
require_once("../../funciones/sala_genericas/clase_formulario.php");
require_once("../funciones/obtenerDatos.php");
require_once("../../funciones/sala_genericas/FuncionesCadena.php");
require_once("../../funciones/sala_genericas/FuncionesFecha.php");
require_once("../../funciones/sala_genericas/formulariobaseestudiante.php");
require_once("../../funciones/sala_genericas/clasebasesdedatosgeneral.php");
//include_once ("graficaEscrutinio.php");

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
	//$_SESSION['resultadosvotaciones']['ganadores']=$ganadores;
	if(is_array($votos))
	foreach ($votos as $llave => $valor){
		if($_SESSION['resultadosvotaciones']['votacioncarrera']==$valor["codigocarrerapertenenciaplantilla"]){
			if($_SESSION['resultadosvotaciones']['votacionplantilla']==$valor['idtipoplantillavotacion']){
				$resultadovotostmp["PLANTILLA"]=iconv("UTF-8","UTF-8",str_replace("&","&amp;",str_replace("<","",$votos[$llave]["nombreplantillavotacion"])));
				$resultadovotostmp["VOTOS"]=iconv("UTF-8","UTF-8",str_replace("&","&amp;",str_replace("<","",$votos[$llave]["CantVotos"])));
				$resultadovotostmp["GRUPO_DE_VOTACION"]=iconv("UTF-8","UTF-8",str_replace("&","&amp;",str_replace("<","",$votos[$llave]["nombretipoplantillavotacion"])));
				$resultadovotostmp["REPRESENTANTE"]=iconv("UTF-8","UTF-8",str_replace("&","&amp;",str_replace("<","",$votos[$llave]["representanteplantilla"])));
				$resultadovotostmp["CARGO"]=iconv("UTF-8","UTF-8",str_replace("&","&amp;",str_replace("<","",$votos[$llave]["cargo"])));
				$resultadovotostmp["CARRERA"]=iconv("UTF-8","UTF-8",str_replace("&","&amp;",str_replace("<","",$votos[$llave]["nombrecarrerapertenciaplantilla"])));
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
<?php 

echo "
	
	<table border='1' cellpadding='1' cellspacing='0' bordercolor='#E9E9E9' width='700'>
	";

	$formulario->dibujar_fila_titulo('RESULTADOS '.iconv("UTF-8","UTF-8",str_replace("&","&amp;",str_replace("<","",$_SESSION['resultadosvotaciones']['nombrecarrera']))),'labelresaltado',"2","align='center'");
	echo "<tr><td colspan='2'>";
	$escrutinio->DibujarTablaNormal($_SESSION['resultadosvotaciones']['resultadofiltro'],"");
	//$formulario->dibujar_fila_titulo('MAYOR VOTACION','labelresaltado',"2","align='center'");
	//$escrutinio->DibujarTablaNormal($_SESSION['resultadosvotaciones']['ganadores'],"");


	echo "<tr><td colspan='2'>";
	echo "</td></tr>";

	echo "	
 	 </table>";

	echo "<table border='1' cellpadding='1' cellspacing='0' bordercolor='#E9E9E9' width='700'>";
$formulario->dibujar_fila_titulo("Diagrama Porcentual de Votacion <br> en  ".iconv("UTF-8","UTF-8",str_replace("&","&amp;",str_replace("<","",$_SESSION['resultadosvotaciones']['nombrecarrera']))),'labelresaltado',"2","align='center'");
	echo "<tr><td colspan='2'>";
	//graficaEscrutinio();
	//echo "<img src=".$_SESSION['resultadosvotaciones']['imagenpieescrutinio']."/>";
	echo "</td></tr>";
	echo "	
 	 </table>";

//if(file_exists($_SESSION['resultadosvotaciones']['imagenpieescrutinio']))
//unlink($_SESSION['resultadosvotaciones']['imagenpieescrutinio']);
?>
