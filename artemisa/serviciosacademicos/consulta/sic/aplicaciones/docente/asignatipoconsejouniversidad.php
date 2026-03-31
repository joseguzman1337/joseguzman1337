<?php
session_start();
    include_once(realpath(dirname(__FILE__)).'/../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
$rutaado=("../../../../../funciones/adodb/");
require_once(realpath(dirname(__FILE__))."/../../../../../Connections/salaado-pear.php");
require_once(realpath(dirname(__FILE__))."/../../../../../funciones/clases/formulario/clase_formulario.php");
require_once(realpath(dirname(__FILE__))."/../../../../../funciones/phpmailer/class.phpmailer.php");
require_once(realpath(dirname(__FILE__))."/../../../../../funciones/validaciones/validaciongenerica.php");
require_once(realpath(dirname(__FILE__))."/../../../../../funciones/sala_genericas/FuncionesCadena.php");
require_once(realpath(dirname(__FILE__))."/../../../../../funciones/sala_genericas/FuncionesFecha.php");
require_once(realpath(dirname(__FILE__))."/../../../../../funciones/sala_genericas/FuncionesSeguridad.php");
require_once(realpath(dirname(__FILE__))."/../../../../../funciones/sala_genericas/FuncionesMatematica.php");
require_once(realpath(dirname(__FILE__))."/../../../../../funciones/sala_genericas/formulariobaseestudiante.php");
require_once(realpath(dirname(__FILE__))."/../../../../../funciones/sala_genericas/clasebasesdedatosgeneral.php");
$objetobase=new BaseDeDatosGeneral($sala);
unset($fila);
$i=0;
foreach($_GET as $llave => $valor)
{
$arrayget[$i]["codigotipoconsejouniversidad"]=$llave;
$arrayget[$i]["estado"]=$valor;
$i++;
}
/*echo "GET<pre>";
print_r($arrayget);
echo "</pre>";*/
if(in_array($arrayget[0]["codigotipoconsejouniversidad"],array("100","200","300"))){
$tabla="participacionuniversitariadocente";
$fila["iddocente"]=$_SESSION['sissic_iddocente'];
$fila["codigotipoconsejouniversidad"]=$arrayget[0]["codigotipoconsejouniversidad"];
$fila["codigotipoparticipacionuniversitaria"]="400";
$fila["nombreparticipacionuniversitariadocente"]=" ";
$fila["codigoestado"]=$arrayget[0]["estado"];



$condicionactualiza=" iddocente='".$_SESSION['sissic_iddocente']."' and codigotipoparticipacionuniversitaria='400' and codigotipoconsejouniversidad='".$fila["codigotipoconsejouniversidad"]."'";
//echo "<pre>";
$objetobase->insertar_fila_bd($tabla,$fila,0,$condicionactualiza);
//echo "</pre>";
}

	header('Expires: Fri, 25 Dec 1980 00:00:00 GMT'); // time in the past
	header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . 'GMT');
	header('Cache-Control: no-cache, must-revalidate');
	header('Pragma: no-cache');
	// generate the output in XML format
	header('Content-type: text/xml');
	echo '<?xml version="1.0" encoding="UTF-8"?>';
	echo '<data>';
	echo '<action>ok</action>';
	echo '</data>';
?>