<?php
    session_start();
    include_once('../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
session_start();
if($_REQUEST['Exportar'])
{
	Exportar("Historico modificación de registros de grado","xls");
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Historico modificación de registros de grado</title>
</head>
<?php
if (empty($_SESSION['MM_Username']))
{
	echo "<h1>Usted no está autorizado para ver esta página</h1>";
	exit();
}
$rutaado=("../../../../funciones/adodb/");
require_once("../../../../funciones/clases/debug/SADebug.php");
require_once("../../../../Connections/salaado-pear.php");
require_once("../../../../funciones/clases/motor/motor.php");
require_once("../../../../funciones/clases/motor/motor.php");
?>
<link rel="stylesheet" type="text/css" href="../../../../estilos/sala.css">
<?php
$fechahoy=date("Y-m-d h:i:s");
$ano=2006;
$query="SELECT
lrg.idlogregistrograduado, 
lrg.idregistrograduado, 
lrg.codigoestudiante, 
concat(eg.apellidosestudiantegeneral,' ',eg.nombresestudiantegeneral) as nombre,
c.nombrecarrera,
lrg.numeropromocion, 
lrg.fecharegistrograduado, 
lrg.numeroacuerdoregistrograduado, 
lrg.fechaacuerdoregistrograduado, 
lrg.responsableacuerdoregistrograduado, 
lrg.numeroactaregistrograduado, 
lrg.fechaactaregistrograduado, 
lrg.numerodiplomaregistrograduado, 
lrg.fechadiplomaregistrograduado, 
lrg.fechagradoregistrograduado, 
lrg.lugarregistrograduado, 
lrg.presidioregistrograduado, 
lrg.observacionregistrograduado, 
lrg.codigoestado, 
trg.nombretiporegistrograduado,
lrg.direccionipregistrograduado, 
lrg.usuario, 
lrg.iddirectivo, 
lrg.codigoautorizacionregistrograduado, 
lrg.fechaautorizacionregistrograduado, 
lrg.codigotipomodificaregistrograduado, 
tmrg.nombretipomodificaregistrograduado,
tmrg.codigotipomodificaregistrograduado,
tg.nombretipogrado,
es.nombreestado,
arg.nombreautorizacionregistrograduado
FROM 
logregistrograduado lrg, tipomodificaregistrograduado tmrg, estudiantegeneral eg, estudiante e, carrera c, tiporegistrograduado trg, tipogrado tg, estado es, autorizacionregistrograduado arg
WHERE
lrg.codigotipomodificaregistrograduado=tmrg.codigotipomodificaregistrograduado
AND lrg.codigoestudiante=e.codigoestudiante
AND e.idestudiantegeneral=eg.idestudiantegeneral
AND e.codigocarrera=c.codigocarrera
AND lrg.codigotiporegistrograduado=trg.codigotiporegistrograduado
AND lrg.idtipogrado=tg.idtipogrado
AND lrg.codigoestado=es.codigoestado
AND lrg.codigoautorizacionregistrograduado=arg.codigoautorizacionregistrograduado
AND lrg.fecharegistrograduado like '$ano%'
ORDER BY idregistrograduado
";
//echo $query;
$operacion=$sala->query($query);
$row_operacion=$operacion->fetchRow();
do
{
	if(!empty($row_operacion))
	{
		$array_interno[]=$row_operacion;
	}
}
while($row_operacion=$operacion->fetchRow());
?>
<body>
<h3>Listado histórico de modificacion de registros de grado año <?php echo $ano?></h3>
<table cellpadding="0" cellspacing="0" border="1">
<tr>
	<td align="center">Fecha Novedad</td>
	<td align="center">No.registro</td>
	<td align="center">Nombres y apellidos</td>
	<td align="center">Tipo novedad</td>
	<td align="center">Observacion</td>
	<td align="center">Dato nuevo</td>
</tr>
<?php foreach ($array_interno as $llave => $valor){
	if($valor['codigotipomodificaregistrograduado'] == 200 or $valor['codigotipomodificaregistrograduado'] == 201 or $valor['codigotipomodificaregistrograduado'] == 202){
	?>
<tr>
	<td><?php echo $valor['fecharegistrograduado']?></td>
	<td><?php echo $valor['idregistrograduado']?></td>
	<td><?php echo $valor['nombre']?></td>
	<td><?php echo $valor['nombretipomodificaregistrograduado']?></td>
	<td><?php echo $valor['observacionregistrograduado']?>&nbsp;</td>
	<td><?php 
	switch ($valor['codigotipomodificaregistrograduado'])
	{
		case 100:
			echo "No hay cambio";
			break;
		case 200:
			echo $valor['numerodiplomaregistrograduado'];
			break;
		case 201:
			echo $valor['fechadiplomaregistrograduado'];
			break;
		case 202:
			echo $valor['numerodiplomaregistrograduado'];
			break;
		case 203:
			break;
			/*case 204:
			echo $valor['numeroacuerdoregistrograduado'];
			break;
			case 205:
			echo $valor['fechaacuerdoregistrograduado'];
			break;
			case 206:
			echo $valor['responsableacuerdoregistrograduado'];
			break;
			case 207:
			echo $valor['numeroactaregistrograduado'];
			break;
			case 208:
			echo $valor['fechaactaregistrograduado'];
			break;
			case 209:
			echo $valor['fechagradoregistrograduado'];
			break;
			case 210:
			echo $valor['lugarregistrograduado'];
			break;
			case 211:
			echo $valor['presidioregistrograduado'];
			break;
			case 212:
			echo $valor['observacionregistrograduado'];
			break;
			case 213:
			echo $valor['nombretiporegistrograduado'];
			break;
			case 214:
			echo $valor['nombretipogrado'];
			break;
			case 215:
			echo $valor['nombreestado'];
			break;
			case 216:
			echo $valor['nombreautorizacionregistrograduado'];
			break;
			*/
	}
	}
	?></td>
</tr>
<?php }?>
</table>
<form name="form1" method="POST" action="">
<input type="submit" name="Exportar" id="Exportar" value="Exportar">
</form>
</body>
</html>
<?php
function Exportar($nombrearchivo,$formato)
{
	$this->nombrearchivo=trim($nombrearchivo);
	switch ($formato)
	{
		case 'xls' :
			$strType = 'application/msexcel';
			$strName = $nombrearchivo.".xls";
			break;
		case 'doc' :
			$strType = 'application/msword';
			$strName = $nombrearchivo.".doc";
			break;
		case 'txt' :
			$strType = 'text/plain';
			$strName = $nombrearchivo.".txt";
			break;
		case 'csv' :
			$strType = 'text/plain';
			$strName = $nombrearchivo.".csv";
			break;
		case 'xml' :
			$strType = 'text/plain';
			$strName = $nombrearchivo.".xml";
			break;
		default :
			$strType = 'application/msexcel';
			$strName = $nombrearchivo.".xls";
			break;

	}
	header("Content-Type: $strType");
	header("Content-Disposition: attachment; filename=$strName\r\n\r\n");
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Pragma: public");
	return;
}
?>