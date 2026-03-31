<?php
$rutaado=("../../../../funciones/adodb/");
require_once("../../../../Connections/salaado-pear.php");
require_once("../../../../funciones/clases/formulario/clase_formulario.php");
require_once("../../../../funciones/phpmailer/class.phpmailer.php");
require_once("../../../../funciones/validaciones/validaciongenerica.php");
require_once("../../../../funciones/sala_genericas/FuncionesCadena.php");
require_once("../../../../funciones/sala_genericas/FuncionesFecha.php");
require_once('../../../../funciones/sala_genericas/FuncionesSeguridad.php');
require_once('../../../../funciones/sala_genericas/FuncionesMatematica.php');
require_once("../../../../funciones/sala_genericas/formulariobaseestudiante.php");
require_once("../../../../funciones/sala_genericas/clasebasesdedatosgeneral.php");
require_once("clasemenusic.php");

//if(!isset($_GET['saveString']))die("no input");
//echo "Message from saveNodes.php\n";
$objetobase=new BaseDeDatosGeneral($sala);
$itemsdel = explode(",",$_GET["deleteIds"]);
for($conparejas=0;$conparejas<count($itemsdel);$conparejas++){
$tabla="itemsic";
$fila["codigoestado"]="200";
	$condicionactualiza=" iditemsic = (".$itemsdel[$conparejas].")";
	$objetobase->insertar_fila_bd($tabla,$fila,0,$condicionactualiza);
}
echo "OK";
?>