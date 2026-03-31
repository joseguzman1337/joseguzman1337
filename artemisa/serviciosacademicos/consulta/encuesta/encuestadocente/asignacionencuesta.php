<?php
session_start();
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

require_once("../../../funciones/sala_genericas/formulariobaseestudiante.php");
require_once("../../../funciones/sala_genericas/clasebasesdedatosgeneral.php");
require_once("claseconsultaencuesta.php");
$formulario=new formulariobaseestudiante($sala,'form1','post','','true');
$objetobase=new BaseDeDatosGeneral($sala);


if(isset($_POST["Guardar"])){
/*echo "<pre>";
print_r($_POST);
echo "</pre>";*/
//echo "<BR>	TIPOUSUARIO=".$_POST["codigotipousuario"];
//echo "<BR>	ENCUESTA=".$_POST["idencuesta"];

if(isset($_POST["codigotipousuario"])&&isset($_POST["idencuesta"])&&trim($_POST["codigotipousuario"])!=''&&trim($_POST["idencuesta"])!=''){
		foreach($_POST["preguntas"] as $llave=>$idpregunta){
	/*echo "<BR>IDPREGUNTA=".$idpregunta."<BR>";
	echo $_POST["observacionpregunta".$idpregunta];
	echo "<br>menu=";
	echo $_POST["menu".$idpregunta];
	echo " check=";
	echo $_POST["check".$idpregunta];
	echo " padre=";
	echo $_POST["padre".$idpregunta];
	echo "<br>";*/
			unset($fila);
			$tabla="pregunta";
			$fila["idtipopregunta"]=$_POST["menu".$idpregunta];
			$fila["nombrepregunta"]=$_POST["observacionpregunta".$idpregunta];
			$fila["idpreguntagrupo"]=$_POST["padre".$idpregunta];
			$fila["codigoestado"]="100";
		/*echo "<pre>";
		print_r($fila);
		echo "<pre>";*/
			$condicionactualiza=" idpregunta=".$idpregunta;
			$objetobase->insertar_fila_bd($tabla,$fila,0,$condicionactualiza);	
		
			if(isset($_POST["check".$idpregunta])){
				unset($fila);
				$tabla="encuestapregunta";
				$fila["idpregunta"]=$idpregunta;
				$fila["idencuesta"]=$_POST["idencuesta"];
				$fila["codigoestado"]="100";
				$condicionactualiza=" idpregunta=".$fila["idpregunta"].
							" and idencuesta=".$_POST["idencuesta"];
				$objetobase->insertar_fila_bd($tabla,$fila,0,$condicionactualiza);
			}
			else{
				if(is_array($_POST["preguntaschecadas"]))
				if(in_array($idpregunta,$_POST["preguntaschecadas"])){
				unset($fila);
				$tabla="encuestapregunta";
				$fila["idpregunta"]=$idpregunta;
				$fila["idencuesta"]=$_POST["idencuesta"];
				$fila["codigoestado"]="200";
				$condicionactualiza=" idpregunta=".$fila["idpregunta"].
							" and idencuesta=".$_POST["idencuesta"];
				$objetobase->insertar_fila_bd($tabla,$fila,0,$condicionactualiza);
				
				}
		
			}

		}
	}
	else{
	alerta_javascript("Es necesario seleccionar un Tipo de Usuario o una Encuesta");
	}
}


?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
  <head>
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

var pagina;
var formulario=document.getElementById("form1");
var menu=document.getElementById("menu");
//alert(formulario.action);
pagina=menu[menu.selectedIndex].value;
//alert(pagina);
formulario.action=pagina;
//return false;
}
function enviarmenulistado(){
//alert(pagina);

var formulario=document.getElementById("form1");
formulario.action="menulistadoresultados.php";
//alert(formulario.action);
formulario.submit();
//return false;
}
//quitarFrame()
</script>
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

  </head>
  <body>
<?php







$objetoconsultapregunta= new ConsultaEncuesta($_POST["codigotipousuario"],$objetobase,$formulario);

$objetoconsultapregunta->consultaprimernivelpreguntas();
$arrayencuesta=$objetoconsultapregunta->recuperarencuestapreguntas();
/*echo "arbolpreguntas <pre>";
print_r($objetoconsultapregunta->arbolpreguntas);
echo  "</pre>";*/

/*echo "arrayencuesta <pre>";
print_r($arrayencuesta);
echo  "</pre>";*/


$arraytitulospestanas=$objetoconsultapregunta->recuperarpadrepreguntas();
/*echo "arraytitulospestanas<pre>";
print_r($arraytitulospestanas);
echo  "</pre>";*/

$objetoconsultapregunta->recuperartipopregunta();
/*echo "arraytirulospestanas <pre>";
print_r($arraytirulospestanas);
echo  "</pre>";*/

echo "<table border=\"1\" cellpadding=\"1\" cellspacing=\"0\" bordercolor=\"#E9E9E9\" width=\"750\">";
	$formulario->dibujar_fila_titulo('ASIGNACION ENCUESTA GENERAL','labelresaltado',"2","align='center'");




echo "</table>";

echo "	<form id=\"form1\" name=\"form1\" action=\"\" method=\"post\"  >
		<input type=\"hidden\" name=\"AnularOK\" value=\"\">";


echo "<table border=\"1\" cellpadding=\"1\" cellspacing=\"0\" bordercolor=\"#E9E9E9\" width=\"750\">";

$formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("tipousuario","codigotipousuario","nombretipousuario","");
$formulario->filatmp[""]="Seleccionar";
$menu="menu_fila";
$parametrosmenu="'codigotipousuario','".$_POST["codigotipousuario"]."','onchange=\'enviar();\''";
$formulario->dibujar_campo($menu,$parametrosmenu,"Tipos de usuario","tdtitulogris","codigotipousuario","requerido");

$formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("encuesta","idencuesta","nombreencuesta"," codigoestado like '1%' and codigotipousuario ='".$_POST["codigotipousuario"]."'");
$formulario->filatmp[""]="Seleccionar";
$menu="menu_fila";
$parametrosmenu="'idencuesta','".$_POST["idencuesta"]."','onchange=\'enviar();\''";
$formulario->dibujar_campo($menu,$parametrosmenu,"Encuesta","tdtitulogris","idencuesta","requerido");


$campo="ventana_emergente_submit";
$parametros="'../../../../pruebas/grid2/formulario/tabla.php?tabla=pregunta','idencuesta','Nueva Pregunta','600','400','form1','no'";

//ventana_emergente_submit($url,$nombre,$valor,$ancho,$alto,$form="form1",$menubar="no")

$formulario->dibujar_campo($campo,$parametros,"Nueva pregunta","tdtitulogris","idencuesta","");

$campo="ventana_emergente_submit";
$parametros="'../../../../pruebas/grid2/formulario/tabla.php?tabla=preguntatipousuario','idpreguntatipousuario','Pregunta tipo usuario','600','400','form1','no'";

//ventana_emergente_submit($url,$nombre,$valor,$ancho,$alto,$form="form1",$menubar="no")

$formulario->dibujar_campo($campo,$parametros,"Nueva asignacion","tdtitulogris","idpreguntatipousuario","");



echo "</table>";

echo "
<div id='formulariohorario'>

";





foreach($objetoconsultapregunta->arbolpreguntas as $llave=>$ramapregunta){
$ordenrama[]=$ramapregunta["nombre"];

echo "
	<div class='dhtmlgoodies_aTab'>


		<table border=\"1\" cellpadding=\"1\" cellspacing=\"0\" bordercolor=\"#E9E9E9\" width=\"750\">";


		

$objetoconsultapregunta->muestraformularioasignapreguntas($ramapregunta,$llave,$_POST["idencuesta"]);


echo "<table border=\"1\" cellpadding=\"1\" cellspacing=\"0\" bordercolor=\"#E9E9E9\" width=\"750\">";
		$conboton=0;
		$parametrobotonenviar[$conboton]="'submit','Guardar','Guardar','onClick=\"return enviarpagina();\"'";
		$boton[$conboton]='boton_tipo';
		$conboton++;				
		/*$parametrobotonenviar[$conboton]="'button','Regresar','Regresar','onclick=\'regresarGET();\''";
		$boton[$conboton]='boton_tipo';*/
		$formulario->dibujar_campos($boton,$parametrobotonenviar,"","tdtitulogris",'Enviar','');
		/*echo "<tr><td><pre>";
		print_r($ordenrama);
		echo "</pre><td></tr>";*/
echo  "</table>";	      


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

if($con==0)
	$cadena.="'".trim(sacarpalabras($row["nombre"],0,0))."'";
else
	$cadena.=",'".trim(sacarpalabras($row["nombre"],0,0))."'";

$con++;
}
$cadena.= ");\n";
echo $cadena;

?>
initTabs('formulariohorario',arraypestanas,0,760,400);
</script>

<?php

echo "</form>"; 


	?>

  </body>
</html>