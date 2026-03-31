<?php
    session_start();
    include_once('../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
session_start();
//ini_set('memory_limit', '64M');
//ini_set('max_execution_time','90');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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
<script language="javascript">
function recargar()
{
	window.location.reload("detallesitioadmision_listado.php?link_origen=admision.php&idadmision=<?php echo $_GET['idadmision']?>&iddetallesitioadmision=<?php echo $_GET['iddetallesitioadmision']?>");
}
</script>
</head>
<body>
<?php
$rutaado=("../../../../funciones/adodb/");
require_once('../../../../Connections/salaado-pear.php');
require_once('../../../../funciones/clases/formulario/clase_formulario.php');
require_once('../../../../funciones/clases/motor/motor.php');
?>
<?php
if($_GET['depurar']=='si')
{
	$sala->debug=true;
}
$idadmision=$_GET['idadmision'];


$query_carrera="SELECT c.nombrecarrera FROM carrera c
WHERE c.codigocarrera='".$_SESSION['admisiones_codigocarrera']."'
";
$operacion_carrera=$sala->query($query_carrera);
$row_carrera=$operacion_carrera->fetchRow();
$nombrecarrera=$row_carrera['nombrecarrera'];
$query="SELECT
dsa.iddetallesitioadmision,
dsa.idadmision,
dsa.codigosalon,
dsa.prioridaddetallesitioadmision,
s.cupomaximosalon,
c.nombrecarrera,
dsa.iddetalleadmision,
tda.nombretipodetalleadmision,
lugarRotacionBase as rotacion
FROM
detallesitioadmision dsa
INNER JOIN salon s on dsa.codigosalon=s.codigosalon
INNER JOIN admision a ON a.idadmision=dsa.idadmision
INNER JOIN carrera c on c.codigocarrera=a.codigocarrera
INNER JOIN detalleadmision da ON dsa.iddetalleadmision=da.iddetalleadmision
INNER JOIN tipodetalleadmision tda ON da.codigotipodetalleadmision=tda.codigotipodetalleadmision
LEFT JOIN LugarRotacionCarrera lr on lr.LugarRotacionCarreraID = dsa.LugarRotacionCarreraID
WHERE a.codigocarrera='".$_SESSION['admisiones_codigocarrera']."'
AND dsa.codigoestado=100
AND a.idadmision='".$_GET['idadmision']."'
";
$operacion=$sala->query($query);
$row_operacion=$operacion->fetchRow();
do
{
	$array_interno[]=$row_operacion;
}
while ($row_operacion=$operacion->fetchRow());
$tabla = new matriz($array_interno,"Detalle de salones asignados a sitios de admisiones (detallesitioadmision) $nombrecarrera",'detallesitioadmision_listado.php','si','no',"menuparametrizacionadmisiones.php",'detallesitioadmision_listado.php',true);
$tabla->agregar_llaves_totales('cupomaximosalon');

//$tabla->agregarllave_drilldown('iddetallesitioadmision','detallesitioadmision_listado.php','horariodetallesitioadmision_listado.php','horariodetallesitiadmision','iddetallesitioadmision','','idadmision','','','horarios para el salón(horariodetallesitioadmision)','');
$tabla->agregarllave_emergente('iddetallesitioadmision','detallesitioadmision_listado.php','horariodetallesitioadmision_listado.php','detalle','iddetallesitioadmision',"idadmision=$idadmision",800,600,200,150,"yes","yes","no","yes","no","","","Edición de horariodetallesitioadmision(horarios de salones)");
$tabla->agregarllave_emergente('codigosalon',"detallesitioadmisio_listado.php","detallesitioadmision.php",'detallesitioadmision',"iddetallesitioadmision","idadmision=$idadmision",680,200,200,150,"yes","yes","no","yes","no","","","Edición de detallesitioadmision(salones)");
$tabla->mostrar();
?>
<?php
$tabla->MuestraBotonVentanaEmergente('Agregar_Salón','detallesitioadmision.php',"idadmision=$idadmision",680,250,50,50,"yes","yes","no","yes","no");
?>
    </body>
</html>