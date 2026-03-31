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

$tabla="itemsiccarrera ";

if($_GET["estado"]=="true")
$fila["codigoestadoitemsiccarrera"]="200";
else
$fila["codigoestadoitemsiccarrera"]="100";

	$condicionactualiza=" iditemsic = ".$_GET["iditem"]."
				and codigocarrera='".$_SESSION['sissic_codigocarrera']."'
				and  '".date("Y-m-d")."' between fechacreacionitemsiccarrera and fechahastaitemsiccarrera";
	//echo "<pre>";
	$objetobase->insertar_fila_bd($tabla,$fila,0,$condicionactualiza);
	//echo "</pre>";

echo "OK";