<?php
    session_start();
    include_once('../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
session_start();
require_once('../../../../funciones/clases/autenticacion/redirect.php' ); 
$idadmision=$_SESSION['idadmision'];
ini_set('memory_limit', '64M');
ini_set('max_execution_time','90');
?>
<link rel="stylesheet" type="text/css" href="../../../../estilos/sala.css">
<script language="Javascript">
function abrir(pagina,ventana,parametros) {
	window.open(pagina,ventana,parametros);
}
</script>
<script language="javascript">
function enviar()
{
	document.form1.submit()
}
function reCarga(pagina){
	document.location.href=pagina;
}

</script>
<script language="Javascript">
function recargar()
{
	window.location.reload();
}
</script>
<?php
$rutaado=("../../../../funciones/adodb/");
require_once('../../../../Connections/salaado-pear.php');
require_once('../../../../funciones/clases/motor/motor.php');
?>
<?php
if($_GET['depurar']==si)
{
	$sala->debug=true;
}
$query="SELECT 

dal.iddetalleadmisionlistado,
dal.iddetalleadmision,
da.idadmision,
eea.nombreestadoestudianteadmision,
dal.titulodetalleadmisionlistado,
dal.fechainiciodetalleadmisionlistado,
dal.fechavencimientodetalleadmisionlistado,
dal.codigoestado
FROM
detalleadmision da, detalleadmisionlistado dal, estadoestudianteadmision eea
WHERE
dal.iddetalleadmision=da.iddetalleadmision
and da.idadmision='".$_GET['idadmision']."'
and dal.codigoestadoestudianteadmision=eea.codigoestadoestudianteadmision";
$operacion=$sala->query($query);
$row_operacion=$operacion->fetchRow();
do
{
	$array_interno[]=$row_operacion;
}
while ($row_operacion=$operacion->fetchRow());
$tabla = new matriz($array_interno,"Listado detalle de admisiones(detalleadmision)","detalleadmision_listado.php?iddetalleadmision=".$_GET['iddetalleadmision']."",'si','no',"menuparametrizacionadmisiones.php");
$tabla->agregarllave_emergente('iddetalleadmisionlistado','detalleadmisionlistado_listado.php','detalleadmisionlistado.php','iddetalleadmisionlistado','iddetalleadmisionlistado','',670,300);
//$tabla->agregarllave_drilldown('iddetalleadmisionlistado','detalleadmisionlistado.php','detalleadmision.php','detalleadmision','iddetalleadmision','','','','','Edición de Prueba','');

$tabla->mostrar();
$tabla->MuestraBotonVentanaEmergente('Agregar_Prueba','detalleadmisionlistado.php',"idadmision=".$_GET['idadmision']."",680,250,50,50,"yes","yes","no","yes","no");
?>