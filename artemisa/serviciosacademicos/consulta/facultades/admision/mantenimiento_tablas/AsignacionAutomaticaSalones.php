<?php
    session_start();
    include_once('../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
session_start();
ini_set('memory_limit', '64M');
ini_set('max_execution_time','90');
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
</script>
</head>
<body>
<?php
$rutaado=("../../../../funciones/adodb/");
require_once('../../../../Connections/salaado-pear.php');
require_once("funciones/ObtenerDatos.php");
?>
<?php
$debug=false;
if($_GET['depurar']=='si')
{
echo "Entro a depurar ";
	$debug=true;
}
$admisiones = new TablasAdmisiones($sala,$debug);

if($_GET['codigocarrera']=='todos' or $_GET['codigocarrera']=="" or $_GET['codigoperiodo']=="")
{
	echo '<script language="javascript">alert("Debe seleccionar solo una carrera y periodo para poder correr el proceso")</script>';
	echo '<script language="javascript">window.location.reload("menu.php")</script>';
}
else
{
	$codigocarrera=$_GET['codigocarrera'];
	$codigoperiodo=$_GET['codigoperiodo'];
}
$array_subperiodo=$admisiones->LeerCarreraPeriodoSubperiodosRecibePeriodo($codigocarrera,$codigoperiodo);

$idsubperiodo=$array_subperiodo['idsubperiodo'];
//echo "idsubperiodo $idsubperiodo<br>";
$idadmision=$admisiones->LeerIdadmision($codigocarrera,$idsubperiodo);

$array_salones=$admisiones->ObtenerSalonesdelaAdmision($codigocarrera,$idsubperiodo);
echo "<br><br><br>";
$admisiones->DibujarTabla($array_salones,"Datos de los salones para la inscripción");

$array_salones_con_cupo=$admisiones->DeterminarSalonesConCupo($array_salones,$codigocarrera,$idsubperiodo);
echo "<br><br><br>";
$admisiones->DibujarTabla($array_salones_con_cupo,"Datos de los salones con cupo antes de la asignación");

//echo "<pre>";print_r($array_salones_con_cupo);
$array_codigoestudiante=$admisiones->ObtenerEstudiantesInscritosOrdenPagadaIncluyeInscritosSinPago($codigocarrera,$codigoperiodo,$idsubperiodo);

//echo "<br/><br/><pre>";print_r($array_codigoestudiante);
$array_asignacion_salones=$admisiones->AsignarSalonesConCupo($array_codigoestudiante,$array_salones_con_cupo);
echo "<br><br><br>";
if(count($array_asignacion_salones)>0)
$admisiones->DibujarTabla($array_asignacion_salones,"Datos de asignacion de Salones");
//die;
$admisiones->InsertarAsignacionesEnBaseDatos($array_asignacion_salones,$codigocarrera,$idsubperiodo);

$array_salones_con_cupo=$admisiones->DeterminarSalonesConCupo($array_salones,$codigocarrera,$idsubperiodo);
echo "<br><br><br>";
$admisiones->DibujarTabla($array_salones_con_cupo,"Datos de los salones con cupo al finalizar la asignación");

?>
<table width="100%"><tr><td align="center"><a href="menu.php"><input type="button" value="Regresar" name="Regresar" onClick="document.URL='menuasignacionsalones.php';"></a></td></tr></table>

    </body>
</html>