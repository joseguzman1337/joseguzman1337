<?php
session_start();
 /*include_once(realpath(dirname(__FILE__)).'/../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);*/
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
$idpazysalvoegresado=$_GET['idpazysalvoegresado'];
$query="
SELECT dpe.iddetallepazysalvoegresado,
dpe.idpazysalvoegresado,
tdpe.nombretipodetallepazysalvoegresado,
dpe.textodetallepazysalvoegresado,
e.nombreestado,
dpe.ubicacionpaginadetallepazysalvoegresado
FROM
detallepazysalvoegresado dpe
INNER JOIN tipodetallepazysalvoegresado tdpe ON dpe.idtipodetallepazysalvoegresado=tdpe.idtipodetallepazysalvoegresado
INNER JOIN estado e ON dpe.codigoestado=e.codigoestado
WHERE
idpazysalvoegresado='$idpazysalvoegresado'
";
$operacion=$sala->query($query);
$rowOperacion=$operacion->fetchRow();
do {
	$arrayInterno[]=$rowOperacion;
}
while($rowOperacion=$operacion->fetchRow());


$motor = new matriz($arrayInterno,"Listado de requisitos para paz y salvo de egresados aplica también a la parametrización de las cartas egresados","detallepazysalvoegresado_listado.php",'si','no','','pazysalvoegresado_listado.php',false,'si','../../../',false);
$motor->jsVarios();
$motor->agregarllave_emergente('iddetallepazysalvoegresado','detallepazysalvoegresado_listado.php','detallepazysalvoegresado.php','ediciondetallepazysalvoegresado','iddetallepazysalvoegresado','',800,400,120,120,'yes','yes','yes','yes','no','','','Clic aquí para edición de detalle de paz y salvo','');
$motor->mostrarTitulo=true;
$motor->botonRegresar=false;

$motor->botonRecargar=false;
$motor->mostrar();
$motor->MuestraBotonVentanaEmergente('Agregar',"detallepazysalvoegresado.php","idpazysalvoegresado=$idpazysalvoegresado",800,400,100,100,'yes','yes','no','no','no');

?>