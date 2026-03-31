<?php
session_start();
    include_once(realpath(dirname(__FILE__)).'/../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
$rutaado=("../../../../funciones/adodb/");
require_once(realpath(dirname(__FILE__))."/../../../../Connections/salaado-pear.php");
require_once(realpath(dirname(__FILE__))."/../../../../funciones/clases/formulario/clase_formulario.php");
require_once(realpath(dirname(__FILE__))."/../../../../funciones/phpmailer/class.phpmailer.php");
require_once(realpath(dirname(__FILE__))."/../../../../funciones/validaciones/validaciongenerica.php");
require_once(realpath(dirname(__FILE__))."/../../../../funciones/sala_genericas/FuncionesCadena.php");
require_once(realpath(dirname(__FILE__))."/../../../../funciones/sala_genericas/FuncionesFecha.php");
require_once(realpath(dirname(__FILE__)).'/../../../../funciones/sala_genericas/FuncionesSeguridad.php');
require_once(realpath(dirname(__FILE__)).'/../../../../funciones/sala_genericas/FuncionesMatematica.php');
require_once(realpath(dirname(__FILE__))."/../../../../funciones/sala_genericas/formulariobaseestudiante.php");
require_once(realpath(dirname(__FILE__))."/../../../../funciones/sala_genericas/clasebasesdedatosgeneral.php");
require_once(realpath(dirname(__FILE__))."/clasemenusic.php");

//if(!isset($_GET['saveString']))die("no input");
//echo "Message from saveNodes.php\n";
$objetobase=new BaseDeDatosGeneral($sala);

$tabla="formularioestudiante";
$fila["idformulario"]=$_GET["iditem"];
$fila["idestudiantegeneral"]=$_SESSION["sissic_idestudiantegeneral"];
$fila["fechaformularioestudiante"]=date("Y-m-d");
$fila["codigoestado"]="100";
if($_GET["estado"]=="true")
$fila["codigoestadodiligenciamiento"]="200";
else
$fila["codigoestadodiligenciamiento"]="100";

	$condicionactualiza=" idformulario = '".$_GET["iditem"]."'
				and idestudiantegeneral = '".$_SESSION["sissic_idestudiantegeneral"]."'";
	//echo "<pre>";
	$objetobase->insertar_fila_bd($tabla,$fila,0,$condicionactualiza);
	//echo "</pre>";

echo "OK";