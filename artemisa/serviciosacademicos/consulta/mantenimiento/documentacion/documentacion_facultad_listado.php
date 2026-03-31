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
SELECT df.iddocumentacionfacultad, 
c.codigocarrera,
c.nombrecarrera,
d.nombredocumentacion,
df.fechainiciodocumentacionfacultad,
df.fechavencimientodocumentacionfacultad,
tdf.nombretipodocumentacionfacultad,
gd.nombregenerodocumento,
nombretipoobligatoridaddocumentacionfacultad
FROM documentacionfacultad df
INNER JOIN carrera c ON df.codigocarrera=c.codigocarrera
INNER JOIN documentacion d ON df.iddocumentacion=d.iddocumentacion
INNER JOIN tipodocumentacionfacultad tdf ON df.codigotipodocumentacionfacultad=tdf.codigotipodocumentacionfacultad
INNER JOIN generodocumento gd ON df.codigogenerodocumento=gd.codigogenerodocumento
INNER JOIN tipoobligatoridaddocumentacionfacultad todf ON todf.codigotipoobligatoridaddocumentacionfacultad=df.codigotipoobligatoridaddocumentacionfacultad
";
$operacion=$sala->query($query);
$rowOperacion=$operacion->fetchRow();
do {
	$arrayInterno[]=$rowOperacion;
}
while($rowOperacion=$operacion->fetchRow());


$motor = new matriz($arrayInterno,"Listado de documentación requerida por las facultades","documentacion_facultad_listado.php",'si','no','','documentacion_facultad_listado.php',false,'si','../../../',false);
$motor->jsVarios();
$motor->agregarllave_emergente('nombrecarrera','documentacion_facultad_listado.php.php','documentacionfacultad.php','ediciondocumentacionfacultad','iddocumentacionfacultad','',800,400,100,100,'yes','yes','yes','yes','no','','','','');
$motor->mostrarTitulo=true;
$motor->botonRegresar=false;

$motor->botonRecargar=false;
$motor->mostrar();
$motor->MuestraBotonVentanaEmergente('Agregar','documentacionfacultad.php','',640,400,100,100,'yes','yes','no','no','no');

?>