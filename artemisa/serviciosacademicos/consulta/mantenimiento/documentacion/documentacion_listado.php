<?php
session_start();
    include_once(realpath(dirname(__FILE__)).'/../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
?>
<link rel="stylesheet" type="text/css" href="../../../estilos/sala.css">
<script language="javascript">
function recargar(){
	document.getElementById('form1').submit();
}
</script>
<?php
require(realpath(dirname(__FILE__)).'/../../../Connections/sala2.php');
$rutaado = "../../../funciones/adodb/";
require_once(realpath(dirname(__FILE__)).'/../../../Connections/salaado-pear.php');
//require_once('../../../funciones/clases/formulariov2/clase_formulario.php');
require_once(realpath(dirname(__FILE__)).'/../../../funciones/clases/motorv2/motor.php');
$fechahoy=date("Y-m-d H:i:s");

$query="
SELECT d.iddocumentacion, d.nombredocumentacion FROM documentacion d
";
$operacion=$sala->query($query);
$rowOperacion=$operacion->fetchRow();
do {
	$arrayInterno[]=$rowOperacion;
}
while($rowOperacion=$operacion->fetchRow());


$motor = new matriz($arrayInterno,"Listado de documentación existente","documentacion_listado.php",'si','no','','documentacion_listado.php',false,'si','../../../',false);
$motor->jsVarios();
$motor->agregarllave_emergente('nombredocumentacion','documentacion_listado.php.php','documentacion.php','ediciondocumentacion','iddocumentacion','',800,400,100,100,'yes','yes','yes','yes','no','','','','');
$motor->mostrarTitulo=true;
$motor->botonRegresar=false;

$motor->botonRecargar=false;
$motor->mostrar();
$motor->MuestraBotonVentanaEmergente('Agregar','documentacion.php','',640,400,100,100,'yes','yes','no','no','no');

?>