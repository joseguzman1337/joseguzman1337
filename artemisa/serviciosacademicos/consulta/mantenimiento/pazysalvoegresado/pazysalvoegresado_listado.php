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
require_once(realpath(dirname(__FILE__)).'/../../../funciones/clases/autenticacion/redirect.php');
$fechahoy=date("Y-m-d H:i:s");

$query="
SELECT pe.idpazysalvoegresado,
pe.fechapazysalvoegresado,
c.nombrecarrera,
pe.fechadesdepazysalvoegresado,
pe.fechahastapazysalvoegresado,
u.usuario,
pe.ip
FROM pazysalvoegresado pe
INNER JOIN carrera c ON pe.codigocarrera=c.codigocarrera
INNER JOIN usuario u ON pe.idusuario=u.idusuario
";
$operacion=$sala->query($query);
$rowOperacion=$operacion->fetchRow();
do {
	$arrayInterno[]=$rowOperacion;
}
while($rowOperacion=$operacion->fetchRow());


$motor = new matriz($arrayInterno,"Listado de carreras que tienen requisito para paz y salvo de egresados","pazysalvoegresado_listado.php",'si','no','','pazysalvoegresado_listado.php',false,'si','../../../',false);
$motor->jsVarios();
$motor->agregarllave_emergente('idpazysalvoegresado','pazysalvoegresado_listado.php','pazysalvoegresado.php','edicionpazysalvoegresado','idpazysalvoegresado','',800,200,100,100,'yes','yes','yes','yes','no','','','Clic aquí para edición carrera paz y salvo','');
$motor->agregarllave_emergente('nombrecarrera','pazysalvoegresado_listado.php','detallepazysalvoegresado_listado.php','ediciondetallepazysalvoegresado','idpazysalvoegresado','',800,400,100,100,'yes','yes','yes','yes','no','','','Clic aquí para edición DETALLES de paz y salvos','');
$motor->mostrarTitulo=true;
$motor->botonRegresar=false;

$motor->botonRecargar=false;
$motor->mostrar();
$motor->MuestraBotonVentanaEmergente('Agregar','pazysalvoegresado.php','',800,600,100,100,'yes','yes','no','no','no');

?>