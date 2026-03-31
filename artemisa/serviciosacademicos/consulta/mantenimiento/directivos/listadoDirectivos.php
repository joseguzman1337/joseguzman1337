<?php
   session_start();
    include_once(realpath(dirname(__FILE__)).'/../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
require_once('../../../funciones/clases/autenticacion/redirect.php');
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
require_once(realpath(dirname(__FILE__)).'/../../../funciones/clases/motorv2/motor.php');
$query="
select 
d.iddirectivo, 
d.nombrecortodirectivo, 
d.numerodocumentodirectivo, 
concat(d.apellidosdirectivo,' ',d.nombresdirectivo) as nombre,
d.cargodirectivo, 
c.nombrecarrera, 
d.fechainiciodirectivo, 
d.fechavencimientodirectivo, 
u.usuario, 
td.nombretipodirectivo 
from 
directivo d
inner join carrera c on d.codigocarrera=c.codigocarrera
inner join usuario u on u.idusuario=d.idusuario
inner join tipodirectivo td on td.codigotipodirectivo=d.codigotipodirectivo
";
$operacion=$sala->query($query);
$rowOperacion=$operacion->fetchRow();
do{
	$arrayInterno[]=$rowOperacion;
}
while($rowOperacion=$operacion->fetchRow());
$motor = new matriz($arrayInterno,"Listado de Directivos","listadoDirectivos.php",'si','no','','listadoDirectivos.php',false,'si','../../../',false);
$motor->jsVarios();
$motor->agregarllave_emergente('nombre','listadoDirectivos.php','directivos.php','ediciondirectivos','iddirectivo','',800,400,100,100,'yes','yes','yes','yes','no','','','','');
$motor->mostrarTitulo=true;
$motor->botonRegresar=false;

$motor->botonRecargar=false;
$motor->mostrar();
$motor->MuestraBotonVentanaEmergente('Agregar_Nuevo_Directivo','directivos.php','',800,400,100,100,'yes','yes','no','no','no');
?>
