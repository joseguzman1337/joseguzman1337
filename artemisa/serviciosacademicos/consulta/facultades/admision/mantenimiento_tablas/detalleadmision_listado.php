<?php
    session_start();
    include_once('../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
session_start();
require_once('../../../../funciones/clases/autenticacion/redirect.php' ); 
//$idadmision=$_SESSION['idadmision'];
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
	window.location.reload("detalleadmision_listado.php?link_origen=admision.php&idadmision=<?php echo $_GET['idadmision']?>");
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
da.iddetalleadmision,
da.idadmision,
da.numeroprioridaddetalleadmision,
da.nombredetalleadmision,
da.porcentajedetalleadmision,
da.totalpreguntasdetalleadmision,
da.codigoestado,
ctda.nombretipodetalleadmision,
rqps.nombrerequierepreselecciondetalleadmision
FROM
detalleadmision da, tipodetalleadmision ctda, requierepreselecciondetalleadmision rqps
WHERE
da.codigotipodetalleadmision=ctda.codigotipodetalleadmision
AND da.codigorequierepreselecciondetalleadmision=rqps.codigorequierepreselecciondetalleadmision
AND da.idadmision='".$_GET['idadmision']."'
AND da.codigoestado=100
";


//exit();

$operacion=$sala->query($query);
$row_operacion=$operacion->fetchRow();
do
{
	$array_interno[]=$row_operacion;
}
while ($row_operacion=$operacion->fetchRow());
$tabla = new matriz($array_interno,"Listado detalle de admisiones(detalleadmision)","detalleadmision_listado.php?idadmision=$idadmision",'si','no',"menuparametrizacionadmisiones.php");
//$tabla->agregarllave_emergente('iddetalleadmision','detalleadmision_listado.php','detalleadmision.php','detalleadmision','iddetalleadmision','',670,300);
//$tabla->agregarllave_drilldown('iddetalleadmision','detalleadmision_listado.php','detalleadmision.php','detalleadmision','iddetalleadmision','','','','','Edición de Prueba','');
$tabla->agregarllave_emergente('iddetalleadmision',"detalleadmision_listado.php","detalleadmision.php",'detalleadmision',"iddetalleadmision","",680,250,200,150,"yes","yes","no","yes","no","","","Edición de Prueba");

$tabla->mostrar();
$tabla->MuestraBotonVentanaEmergente('Agregar_Prueba','detalleadmision.php',"idadmision=".$_GET['idadmision'],680,250,50,50,"yes","yes","no","yes","no");
?>
