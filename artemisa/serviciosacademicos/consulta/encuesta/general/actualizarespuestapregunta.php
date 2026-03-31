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
//require_once("../../../funciones/phpmailer/class.phpmailer.php");
//require_once("../../../funciones/validaciones/validaciongenerica.php");
require_once("../../../funciones/sala_genericas/FuncionesCadena.php");
require_once("../../../funciones/sala_genericas/FuncionesFecha.php");
require_once('../../../funciones/sala_genericas/FuncionesSeguridad.php');
require_once('../../../funciones/sala_genericas/FuncionesMatematica.php');
require_once("../../../funciones/sala_genericas/clasebasesdedatosgeneral.php");
require_once("claseconsultaencuesta.php");


$objetobase=new BaseDeDatosGeneral($sala);

$objetoconsultapregunta= new ConsultaEncuesta($codigotipousuario,$objetobase,$formulario);

			unset($fila);
			$tabla="respuestadetalleencuestapregunta";
			//$fila["idpregunta"]=$idpregunta;
			$fila["idusuario"]=$_GET["idusuario"];
			$fila["valorrespuestadetalleencuestapregunta"]="".$_GET["valorrespuesta"];
			$fila["codigoestado"]="100";
			$idencuestapregunta=$objetoconsultapregunta->recuperaidencuestapregunta($_GET["idpregunta"],$_GET["idencuesta"]);
			$fila["idencuestapregunta"]=$idencuestapregunta;
		/*echo "<pre>";
		print_r($fila);
		echo "<pre>";*/
			$condicionactualiza=" idencuestapregunta=".$idencuestapregunta.
						" and idusuario=".$_GET["idusuario"];
			//echo "<pre>";
			$objetobase->insertar_fila_bd($tabla,$fila,0,$condicionactualiza);


	header('Expires: Fri, 25 Dec 1980 00:00:00 GMT'); // time in the past
	header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . 'GMT');
	header('Cache-Control: no-cache, must-revalidate');
	header('Pragma: no-cache');
	// generate the output in XML format
	header('Content-type: text/xml');
	echo '<?xml version="1.0" encoding="UTF-8"?>';
	echo '<data>';
	echo "Guardado exitoso";
	echo '</data>';

?>