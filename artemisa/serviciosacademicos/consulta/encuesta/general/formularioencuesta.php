<?php
session_start();
include_once('../../../utilidades/ValidarSesion.php'); 
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION);

//session_start();
//require_once('../../../funciones/clases/autenticacion/redirect.php' ); 
//$rol=$_SESSION['rol'];
//$_SESSION['MM_Username']='admintecnologia';
//print_r($_SESSION);
$rutaado=("../../../funciones/adodb/");
require_once("../../../Connections/salaado-pear.php");
require_once("../../../funciones/clases/formulario/clase_formulario.php");
//require_once("../../../funciones/phpmailer/class.phpmailer.php");
//require_once("../../../funciones/validaciones/validaciongenerica.php");
require_once("../../../funciones/sala_genericas/FuncionesCadena.php");
require_once("../../../funciones/sala_genericas/FuncionesFecha.php");
require_once('../../../funciones/sala_genericas/FuncionesSeguridad.php');
require_once('../../../funciones/sala_genericas/FuncionesMatematica.php');

require_once("../../../funciones/sala_genericas/formulariobaseestudiante.php");
require_once("../../../funciones/sala_genericas/clasebasesdedatosgeneral.php");
require_once("claseconsultaencuesta.php");


?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
  <head>

<link rel="stylesheet" type="text/css" href="../../../estilos/sala.css">
<script type="text/javascript" src="../../../funciones/javascript/funciones_javascript.js"></script>
<style type="text/css">@import url(../../../funciones/calendario_nuevo/calendar-win2k-1.css);</style>
<script type="text/javascript" src="../../../funciones/calendario_nuevo/calendar.js"></script>
<script type="text/javascript" src="../../../funciones/calendario_nuevo/calendar-es.js"></script>
<script type="text/javascript" src="../../../funciones/calendario_nuevo/calendar-setup.js"></script>
<script type="text/javascript" src="../../../funciones/clases/formulario/globo.js"></script>
    <link rel="stylesheet" href="../../../funciones/sala_genericas/ajax/tab/css/tab-view.css" type="text/css" media="screen">
    <script type="text/javascript" src="../../../funciones/sala_genericas/ajax/tab/js/ajax.js"></script>

<script type="text/javascript" src="../../../funciones/sala_genericas/ajax/tab/js/tab-view.js"></script>
<script type="text/javascript" src="../../../funciones/sala_genericas/ajax/requestxml.js"></script>

<script LANGUAGE="JavaScript">

function quitarFrame()
{
	if (self.parent.frames.length != 0)
	self.parent.location=document.location.href="../../../aspirantes/aspirantes.php";

}
function regresarGET()
{
	//history.back();
	document.location.href="<?php echo 'menuadministracionresultados.php';?>";
}
function enviarpagina(){

process("actualizarespuestapregunta.php","");
/*
var pagina;
var formulario=document.getElementById("form1");
var menu=document.getElementById("menu");
//alert(formulario.action);
pagina=menu[menu.selectedIndex].value;
//alert(pagina);
formulario.action=pagina;
//return false;*/
return true;
}
function enviarrespuesta(obj,idpregunta,idusuario,idencuesta){
var params="idpregunta="+idpregunta+"&idusuario="+idusuario+"&idencuesta="+idencuesta+"&valorrespuesta="+obj.value;
process("actualizarespuestapregunta.php",params);

//alert("actualizarespuestapregunta.php?"+params);
return true;
}

function enviarmenulistado(){
//alert(pagina);

var formulario=document.getElementById("form1");
formulario.action="menulistadoresultados.php";
//alert(formulario.action);
formulario.submit();
//return false;
}

open("../seguridad.html" , "ventana1" , "width=290,height=200,scrollbars=NO");

//quitarFrame()
</script>

  </head>
  <body>
<?php
//print_r($_SESSION);



$fechahoy=date("Y-m-d H:i:s");

$formulario=new formulariobaseestudiante($sala,'form1','post','','true');
//$formulario2=new formulariobaseestudiante($sala,'form1','post','','true');
$objetobase=new BaseDeDatosGeneral($sala);



$tabla="usuario ep";
	$nombreidtabla="idusuario";
	$idtabla=$_GET["idusuario"];
	$condicion="";

$datosusuario=$objetobase->recuperar_datos_tabla($tabla,$nombreidtabla,$idtabla,$condicion,"",0);

$idusuario=$_GET["idusuario"];
//$codigotipousuario=$datosusuario["codigotipousuario"];
$codigotipousuario="650";

$objetoconsultapregunta= new ConsultaEncuesta($codigotipousuario,$objetobase,$formulario);

$objetoconsultapregunta->consultaprimernivelpreguntas();
/*echo "arbolpreguntas <pre>";
print_r($objetoconsultapregunta->arbolpreguntas);
echo  "</pre>";*/


$arrayencuesta=$objetoconsultapregunta->recuperarencuestapreguntas();

$arraydatosrespuesta=$objetoconsultapregunta->recuperarrespuestapreguntausuario($idusuario);
//echo "NOTERMINADO=".$objetoconsultapregunta->noterminado;
/*if(!$objetoconsultapregunta->noterminado){
	alerta_javascript("puede continuar");
}*/
/*
echo "arraydatosrespuesta<pre>";
print_r($arraydatosrespuesta);
echo "</pre>";
*/


$arraytitulospestanas=$objetoconsultapregunta->recuperarpadrepreguntas();


foreach($arrayencuesta as $idencuesta=>$arraylistaencuesta){	
	$arrayidencuesta[]=$idencuesta;	
}


if(!is_array($arraydatosrespuesta)){
	$idencuestaaleatorio=seleccionarAleatorioArreglo($arrayidencuesta);
}
else{
	$idencuestaaleatorio=$arraydatosrespuesta["idencuesta"];
}
//$idencuestaaleatorio=10;

if(isset($_GET["idencuesta"]))
$idencuestaaleatorio=$_GET["idencuesta"];

foreach($arrayencuesta[$idencuestaaleatorio] as $idencuesta=>$valor){
	$arrayidencuestaaleatorio[]=$idencuesta;
}


asort($arrayidencuestaaleatorio);



/*
echo "arrayencuesta <pre>";
print_r($arrayencuesta);
echo  "</pre>";



echo "<BR>ENCUESTA ELEGIDA=".$idencuestaaleatorio."<BR>";

echo "arrayidencuestaaleatorio <pre>";
print_r($arrayidencuestaaleatorio);
echo  "</pre>";
*/

echo "<table border=\"1\" cellpadding=\"1\" cellspacing=\"0\" bordercolor=\"#E9E9E9\" width=\"750\">";

$stringtitulo="<b>La autoevaluacion es un proceso de reflexion interna, de autoestudio colectivo, que permite detectar oportunidades de mejora en aquello que la Universidad quiere hacer, lo que hace, la forma en que controla que lo esta logrando y su capacidad de cambio e innovacion</b>.<br><br>  Este cuestionario tiene como fin obtener informacion actualizada sobre algunos aspectos de la Universidad. A continuacion encontrara una serie de preguntas o frases para que usted responda. Por favor marque con una (X) sobre el lugar que mas se aproxime  o aleje de la frase o respuesta formulada y que usted considere la mas adecuada, teniendo en cuenta su opinion, conocimiento o experiencia.  Recuerde que no hay respuestas malas o buenas y la informacion es absolutamente confidencial. En una cultura de calidad no pensamos en cosas bien o mal hechas. Pensamos en oportunidades de mejora.<br> <b>Su participacion es muy importante, de esta depende el exito del ejercicio de autoevaluacion</b>
";

	$formulario->dibujar_fila_titulo('<b><BR>PROCESO DE AUTOEVALUACIoN INSTITUCIONAL<BR><BR></b>','tdtituloencuesta',"2","align='center'","td");

$formulario->dibujar_fila_titulo($stringtitulo,'tdtituloencuestadescripcion',"2","align='left'","td");



echo "</table><br><br>";


echo "<table border=\"1\" cellpadding=\"1\" cellspacing=\"0\" bordercolor=\"#E9E9E9\" width=\"750\">";
$formulario->dibujar_fila_titulo("Por favor diligencie todas las pestañas para que pueda finalizar la encuesta",'tdtituloencuestadescripcion',"2","align='left'","td");
echo "</table>";

echo "	<form id=\"form1\" name=\"form1\" action=\"\" method=\"post\"  >
		<input type=\"hidden\" name=\"AnularOK\" value=\"\">
		<input type=\"hidden\" name=\"idencuesta\" value=\"".$idencuestaaleatorio."\">

<div id='formulariohorario'>";
$conpreguntatabla=0;
foreach($objetoconsultapregunta->arbolpreguntas as $idpregunta=>$ramapregunta){
/*echo "ramapregunta=".$conpreguntatabla."<pre>";
print_r($ramapregunta);
echo "</pre>";*/

echo "	<div class='dhtmlgoodies_aTab'>

		<table border=\"1\" cellpadding=\"1\" cellspacing=\"0\" bordercolor=\"#E9E9E9\" width=\"750\">";


	/*$formulario->dibujar_fila_titulo('BIENESTAR UNIVERSITARIO','labelresaltado',"2","align='center'");
	$formulario->dibujar_fila_titulo('&nbsp;','labelresaltado',"2","align='left'");*/
	
$objetoconsultapregunta->muestraformulariopreguntas($ramapregunta,$idpregunta,$arrayidencuestaaleatorio,$idencuestaaleatorio);












echo "</table>";

echo "<table border=\"1\" cellpadding=\"1\" cellspacing=\"0\" bordercolor=\"#E9E9E9\" width=\"750\">";





		$conboton=0;

		/*$parametrobotonenviar[$conboton]="'submit','Guardar','Guardar',''";
		$boton[$conboton]='boton_tipo';
		$conboton++;*/
		$parametrobotonenviar[$conboton]="'button','Seguir','Seguir','onclick=\'return cambiapestana(".($conpreguntatabla+1)."); \''";
		$boton[$conboton]='boton_tipo';				

		if($conpreguntatabla>=(count($objetoconsultapregunta->arbolpreguntas)-1))
		$parametrobotonenviar[$conboton]="'submit','Finalizar','Finalizar',''";
		$boton[$conboton]='boton_tipo';		

		/*$parametrobotonenviar[$conboton]="'button','Regresar','Regresar','onclick=\'regresarGET();\''";
		$boton[$conboton]='boton_tipo';*/
		$formulario->dibujar_campos($boton,$parametrobotonenviar,"","tdtitulogris",'Enviar','');

$formulario->dibujar_fila_titulo('<b>Gracias por su colaboracion, sus respuestas son utiles para el mejoramiento de nuestra Institucion</b>','',"2","align='center'","td");
$conpreguntatabla++;
echo  "</table>";

echo "</div>";




}


echo "</div>";
?>
<script type="text/javascript">
var pathruta='../../../funciones/sala_genericas/ajax/tab/';
<?php
$cadena= "var arraypestanas=Array(";
$con=0;
foreach($arraytitulospestanas as $i=>$row){
//trim(sacarpalabras(str_replace("de","",str_replace("y","",$row["nombre"])),0,1))

if($con==0)
	$cadena.="'".substr(($con+1).". ".$row["nombre"],0,13)."...'";
else
	$cadena.=",'".substr(($con+1).". ".$row["nombre"],0,13)."...'";

$con++;
}
$cadena.= ");\n";
echo $cadena;

?>
initTabs('formulariohorario',arraypestanas,0,760,400);

function cambiapestana(pestana){
//alert("pestana="+pestana);
//initTabs('formulariohorario',arraypestanas,pestana,760,400);
showTab('formulariohorario',pestana);
return false;
}

</script>

<?php

echo "</form>"; 
/*echo "preguntasencuesta <pre>";
print_r($objetoconsultapregunta->preguntasencuesta);
echo  "</pre>";*/

//$objetoconsultapregunta->preguntasencuesta 
if(!is_array($arraydatosrespuesta)){
/*echo "preguntasencuesta<pre>";
print_r($objetoconsultapregunta->preguntasencuesta);
echo "</pre>";*/

foreach($objetoconsultapregunta->preguntasencuesta as $llave=>$idpregunta ){
			unset($fila);
			$tabla="respuestadetalleencuestapregunta";
			//$fila["idpregunta"]=$idpregunta;
			$fila["idusuario"]=$idusuario;
			$fila["valorrespuestadetalleencuestapregunta"]="";
			$fila["codigoestado"]="100";
			$idencuestapregunta=$objetoconsultapregunta->recuperaidencuestapregunta($idpregunta,$idencuestaaleatorio);
			$fila["idencuestapregunta"]=$idencuestapregunta;
		/*echo "$idpregunta,$idencuestaaleatorio<pre>";
		print_r($fila);
		echo "<pre>";*/
			
			$condicionactualiza=" idencuestapregunta=".$idencuestapregunta.
						" and idusuario=".$idusuario;
			//echo "<pre>";
			$objetobase->insertar_fila_bd($tabla,$fila,0,$condicionactualiza);

}
//alerta_javascript("Entro primera insercion");
}
//$arrayidencuestaaleatorio


if(isset($_POST["Guardar"])){
	//if($formulario->valida_formulario()){
		foreach($_POST["preguntas"] as $llave=>$idpregunta){
			//echo "<br>".$llave."=>".$idpregunta." =>".$_POST[$idpregunta];
				unset($fila);
			$tabla="respuestadetalleencuestapregunta";
			//$fila["idpregunta"]=$idpregunta;
			$fila["idusuario"]=$idusuario;
			$fila["valorrespuestadetalleencuestapregunta"]="".$_POST[$idpregunta];
			$fila["codigoestado"]="100";
			$idencuestapregunta=$objetoconsultapregunta->recuperaidencuestapregunta($idpregunta,$_POST["idencuesta"]);
			$fila["idencuestapregunta"]=$idencuestapregunta;
		/*echo "<pre>";
		print_r($fila);
		echo "<pre>";*/
			$condicionactualiza=" idencuestapregunta=".$idencuestapregunta.
						" and idusuario=".$idusuario;
			//echo "<pre>";
			$objetobase->insertar_fila_bd($tabla,$fila,0,$condicionactualiza);	
			//echo "</pre>";

		}
			alerta_javascript("Guardado Exitoso");	
			echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=formularioencuesta.php?idusuario=".$idusuario."'>";
	//}
}

if(isset($_POST["Finalizar"])){


		foreach($_POST["preguntas"] as $llave=>$idpregunta){
			//echo "<br>".$llave."=>".$idpregunta." =>".$_POST[$idpregunta];
				unset($fila);
			$tabla="respuestadetalleencuestapregunta";
			//$fila["idpregunta"]=$idpregunta;
			$fila["idusuario"]=$idusuario;
			$fila["valorrespuestadetalleencuestapregunta"]="".$_POST[$idpregunta];
			$fila["codigoestado"]="100";
			$idencuestapregunta=$objetoconsultapregunta->recuperaidencuestapregunta($idpregunta,$_POST["idencuesta"]);
			$fila["idencuestapregunta"]=$idencuestapregunta;
		/*echo "<pre>";
		print_r($fila);
		echo "<pre>";*/
			$condicionactualiza=" idencuestapregunta=".$idencuestapregunta.
						" and idusuario=".$idusuario;
			//echo "<pre>";
			$objetobase->insertar_fila_bd($tabla,$fila,0,$condicionactualiza);	
			//echo "</pre>";
		}
	$formulario=$objetoconsultapregunta->recuperaobjetoformulario();
	/*echo "<h1>FORMULARIO</h1><pre>";
	print_r($formulario);
	echo "</pre>";*/
	$validacion=$formulario->valida_formulario();
	if($validacion==false){
		alerta_javascript("No puede continuar hasta que diligencie toda la encuesta ");
		echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=formularioencuesta.php?idusuario=".$idusuario."'>";
	
	}
	else{
		alerta_javascript("Gracias por su colaboracion, sus respuestas son utiles para el mejoramiento de nuestra Institucion .\\n Puede continuar");
		echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=../../facultades/creacionestudiante/estudiante.php'>";
	}	

}
	?>	
	

  </body>
</html>