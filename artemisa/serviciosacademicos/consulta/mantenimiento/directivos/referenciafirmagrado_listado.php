<?php
   session_start();
    include_once(realpath(dirname(__FILE__)).'/../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
require_once(realpath(dirname(__FILE__)).'/../../../funciones/clases/autenticacion/redirect.php');
if(!isset($_SESSION['MM_Username'])){
	echo "<h1>Variable de sesión perdida, no se puede continuar</h1>";
	exit();
}
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

$query="SELECT rfg.idreferenciafirmagrado,d.iddirectivo,
CONCAT(d.apellidosdirectivo,' ',d.nombresdirectivo) as nombre,
rfg.fechainicioreferenciafirmagrado,rfg.fechafinalreferenciafirmagrado FROM referenciafirmagrado rfg
INNER JOIN directivo d ON rfg.iddirectivo=d.iddirectivo
";
$operacion=$sala->query($query);
$rowOperacion=$operacion->fetchRow();
do {
	$arrayInterno[]=$rowOperacion;
}
while($rowOperacion=$operacion->fetchRow());


$motor = new matriz($arrayInterno,"Listado de directivos que firman grados","referenciafirmagrado_listado.php",'si','no','','referenciafirmagrado_listado.php',false,'si','../../../',false);
$motor->jsVarios();
$motor->agregarllave_emergente('nombre','referenciafirmagrado_listado.php.php','referenciafirmagrado.php','edicionreferenciafirmagrado','idreferenciafirmagrado','',800,400,100,100,'yes','yes','yes','yes','no','','','','');
$motor->mostrarTitulo=true;
$motor->botonRegresar=false;

$motor->botonRecargar=false;
$motor->mostrar();
$motor->MuestraBotonVentanaEmergente('Agregar_Nuevo_Directivo','referenciafirmagrado.php','',640,400,100,100,'yes','yes','no','no','no');

?>