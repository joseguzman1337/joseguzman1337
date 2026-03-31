<?php
session_start();
include_once('../../../utilidades/ValidarSesion.php'); 
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION);

//session_start();

$rutaado=("../../../funciones/adodb/");
require_once("../../../Connections/salaado-pear.php");
require_once("../../../funciones/clases/formulario/clase_formulario.php");
require_once("../../../funciones/phpmailer/class.phpmailer.php");
require_once("../../../funciones/validaciones/validaciongenerica.php");
require_once("../../../funciones/sala_genericas/FuncionesCadena.php");
require_once("../../../funciones/sala_genericas/FuncionesFecha.php");
require_once("../../../funciones/sala_genericas/FuncionesSeguridad.php");
require_once("../../../funciones/sala_genericas/FuncionesMatematica.php");
require_once("../../../funciones/sala_genericas/formulariobaseestudiante.php");
require_once("../../../funciones/sala_genericas/clasebasesdedatosgeneral.php");
require_once('../../../funciones/sala/nota/nota.php');
require_once('../matriculasnew/funciones/obtener_datos.php');
require_once("indicadoresautoinstitucional.php");
require_once("titulosindicadores.php");
require_once("vistatablaestadistica.php");
require_once("cacheindicadores.php");
require_once("administraindicadores.php");
ini_set('max_execution_time','6000');

$objetobase=new BaseDeDatosGeneral($sala);
$_REQUEST["codigoperiodo"]="20092";
$objindicadores=new IndicadoresInstitucional($_REQUEST["codigoperiodo"],$objetobase);
$objcacheindicadores=new CacheIndicadores($_REQUEST["codigoperiodo"],$objetobase);

$db=$objetobase->conexion;
//border='1' cellpadding='0' cellspacing='0' bordercolor='#E9E9E9'
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Documento sin t&iacute;tulo</title>

<link rel="stylesheet" href="../../../estilos/sala.css" type="text/css">
<link rel="stylesheet" href="estilotabla.css" type="text/css">

</head>

<body  topmargin="0" leftmargin="0">
<?php
/*echo "<pre>";
print_r($_POST);
echo "</pre>";*/
/*$codigomodalidadacademicasic=$_REQUEST["codigomodalidadacademicasic"];
$codigocarrera=$_REQUEST["codigocarrera"];
$codigofacultad= $_REQUEST["codigofacultad"];
$codigoareadisciplinar=$_REQUEST["codigoareadisciplinar"];*/

$codigomodalidadacademicasic="";
$codigocarrera="10";
$codigofacultad="";
$codigoareadisciplinar="";
/*
$objcacheindicadores->setCarreraOpciones($codigomodalidadacademicasic,$codigocarrera,$codigofacultad,$codigoareadisciplinar);

$objindicadores->carreraOpciones($codigomodalidadacademicasic,$codigocarrera,$codigofacultad,$codigoareadisciplinar);
$objadminindicadores=new AdministracionIndicadores($objindicadores,$objcacheindicadores,$objetobase);
$objadminindicadores->setRangoPeriodo("20082","20092");
echo "<table>";
echo "<tr><td>";
$objadminindicadores->imprimirTitulosVertical();
echo "</td><td>";
$objadminindicadores->imprimirAreaPrincipal();
echo "</td></tr>";
echo "</table>";
*/

$objindicadores->estudiantesColegio("ESTUDIANTES COLEGIO");

/*
$titulo="Numero de nuevos estudiantes por estrato";
$funciones[0]["funcion"]="estudianteEstrato";
$funciones[0]["titulo"]="Numero de nuevos estudiantes por estrato";
$funciones[1]["funcion"]="desercionPrimerAnio";
$funciones[1]["titulo"]="Porcentaje Deserción en el primer año";
$funciones[2]["funcion"]="desercionEstudiante";
$funciones[2]["titulo"]="Porcentaje Deserción";
$funciones[3]["funcion"]="graduadosPeriodo";
$funciones[3]["titulo"]="% # graduados / # de nuevos estudiantes por Cohorte";
$funciones[4]["funcion"]="aniosGradoEstudiante";
$funciones[4]["titulo"]="# de años para graduarse";
$funciones[5]["funcion"]="docenteInvestigadorCarrera";
$funciones[5]["titulo"]="# docentes investigadores x carrera";
$funciones[6]["funcion"]="docenteInvestigador";
$funciones[6]["titulo"]="# Docentes investigadores de tiempo completo";
$funciones[7]["funcion"]="docenteDoctoradoEstudiante";
$funciones[7]["titulo"]="% #estudiantes / # docente doctorado";
$funciones[8]["funcion"]="contratoInvestigacionDocente";
$funciones[8]["titulo"]=" % # de contratos de investigación / # docentes";
$funciones[9]["funcion"]="publicacionDocente";
$funciones[9]["titulo"]=" % # Publicaciones / # Docentes";
$funciones[10]["funcion"]="publicacionIndexadaDocente";
$funciones[10]["titulo"]="  # Revistas Indexadas";
$funciones[11]["funcion"]="docenteEstudiante";
$funciones[11]["titulo"]="% # de estudiantes / # Profesores";
$funciones[12]["funcion"]="docente";
$funciones[12]["titulo"]="# de Docentes";
$funciones[13]["funcion"]="docenteEscalafon";
$funciones[13]["titulo"]=" # de Docentes por Escalafón";

echo "<table border='1'>";
foreach($funciones as $i => $valores){
	echo "<tr><td>".$valores["titulo"]."</td><td></td><td></td></tr>";
	$arraydatos=$objcacheindicadores->consultaCacheIndicador($valores["titulo"]);
	echo "<pre>";
	print_r($arraydatos);
	echo "</pre>";
	if(is_array($arraydatos)){
		foreach($arraydatos["total"][$valores["titulo"]] as $llave => $valor){
			//if(!is_array($valor))
				echo "<tr><td>&nbsp;</td><td>".$llave."</td><td>".$valor."</td></tr>";
		}
	}
	else{
		
		$arraydatos=$objindicadores->$valores["funcion"]($valores["titulo"]);
		$objcacheindicadores->insertarCacheIndicador($arraydatos);
		foreach($arraydatos["total"][$valores["titulo"]] as $llave => $valor){
			//if(!is_array($valor))
				echo "<tr><td>&nbsp;</td><td>".$llave."</td><td>".$valor."</td></tr>";
		}
	}

}
echo "</table>";*/


//$arrayestudianteestrato=$objindicadores->estudianteEstrato($titulo);
//$titulo="Porcentaje Deserción en el primer año";
//$arrayestudiantedesercion1=$objindicadores->desercionPrimerAnio($titulo);
//$titulo="Porcentaje Deserción";
//$arrayestudiantedesercion2=$objindicadores->desercionEstudiante($titulo);
//$titulo="% # graduados / # de nuevos estudiantes por Cohorte";
//$arrayestudiantedesercion2=$objindicadores->graduadosPeriodo($titulo);
//$titulo="# de años para graduarse";
//$arrayestudiantedesercion2=$objindicadores->aniosGradoEstudiante($titulo);
//echo "arrayestudiantedesercion2<pre>";
//print_r($arrayestudiantedesercion2);
//echo "</pre>";

?>

</body>
</html>