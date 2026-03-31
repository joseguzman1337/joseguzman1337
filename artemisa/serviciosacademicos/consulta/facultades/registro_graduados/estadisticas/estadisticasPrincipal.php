<?php
    session_start();
    include_once('../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
session_start();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Listado</title>
<link rel="stylesheet" type="text/css" href="../../../../estilos/sala.css">
</head>
<?php
if (empty($_SESSION['MM_Username']))
{
	//echo "<h1>Usted no está autorizado para ver esta página</h1>";
	//exit();
}
$rutaado=("../../../../funciones/adodb/");
require_once("../../../../funciones/clases/debug/SADebug.php");
require_once("../../../../Connections/salaado-pear.php");
require_once("../../../../funciones/clases/motorv2/motor.php");
?>
<?php
$query_carreras="SELECT c.codigocarrera, c.nombrecarrera FROM carrera c ORDER BY c.codigomodalidadacademica, c.nombrecarrera";
$array_carrera=QueryLlave(&$sala,$query_carreras,'codigocarrera');
$_SESSION['array_carrera']=$array_carrera;
$contador=0;
foreach ($array_carrera as $llave_c => $valor_c){
	
	$query_graduados_x_programa_antes2006="SELECT COUNT(rga.idregistrograduadoantiguo) as cant
	FROM registrograduadoantiguo rga
	WHERE
	rga.codigocarrera='$llave_c'
	AND rga.fechagradoregistrograduadoantiguo BETWEEN '1984-01-01' AND '2005-12-31'
	";
	$row_conteo=Query(&$sala,$query_graduados_x_programa_antes2006,true);
	
	/*
	 * @modified Carlos Suarez <suarezcarlos@unbosque.edu.co>
	 * Aranda caso  83960
	 * consulta actualizadas incluyendo las nuevas tablas creadas en el nuevo sistema de grados
	 * @since  November 29, 2016
	*/
	$query_graduados_x_programa_pos2006="SELECT
	SUM(cant) AS cant
FROM
	(
		SELECT
			COUNT(rg.idregistrograduado) AS cant
		FROM
			registrograduado rg,
			estudiante e
		WHERE
			rg.codigoestudiante = e.codigoestudiante
		AND e.codigocarrera = '$llave_c'
		AND rg.codigoestado = '100'
		AND rg.codigoautorizacionregistrograduado = '100'
		AND rg.fechagradoregistrograduado BETWEEN '2006-01-01'
		AND NOW()
		UNION
			SELECT
				COUNT(R.RegistroGradoId) AS cant
			FROM
				estudiantegeneral EG
			INNER JOIN estudiante E ON (
				E.idestudiantegeneral = EG.idestudiantegeneral
			)
			INNER JOIN carrera C ON (
				C.codigocarrera = E.codigocarrera
			)
			INNER JOIN FechaGrado F ON (
				F.CarreraId = C.codigocarrera
			)
			INNER JOIN AcuerdoActa A ON (
				A.FechaGradoId = F.FechaGradoId
			)
			INNER JOIN DetalleAcuerdoActa D ON (
				D.AcuerdoActaId = A.AcuerdoActaId
				AND D.EstudianteId = E.codigoestudiante
			)
			INNER JOIN RegistroGrado R ON (
				R.AcuerdoActaId = A.AcuerdoActaId
				AND R.EstudianteId = E.codigoestudiante
			)
			INNER JOIN titulo T ON (
				T.codigotitulo = C.codigotitulo
			)
			INNER JOIN documento DT ON (
				DT.tipodocumento = EG.tipodocumento
			)
			INNER JOIN genero G ON (
				G.codigogenero = EG.codigogenero
			)
			WHERE
				E.codigocarrera = '$llave_c'
			AND D.CodigoEstado = 100
			AND R.CodigoEstado = 100
	) b
	";
	//echo $query_graduados_x_programa_pos2006;
	/* END */
	$row_conteo_pos=Query(&$sala,$query_graduados_x_programa_pos2006,true);
	
	$array_interno[$contador]['codigocarrera']=$valor_c['codigocarrera'];
	$array_interno[$contador]['nombrecarrera']=$valor_c['nombrecarrera'];
	$array_interno[$contador]['cant_graduados_ant']=$row_conteo['cant'];
	$array_interno[$contador]['cant_graduados']=$row_conteo_pos['cant'];
	$array_interno[$contador]['Total']=$row_conteo['cant']+$row_conteo_pos['cant'];
	
	$contador++;
}
if(is_array($array_interno)){
	$motor = new matriz($array_interno,'Informe Gnral Cantidad de Graduados','estadisticasPrincipal.php','si','no','menu.php','',false,'si','../../../../');
	$motor->agregarllave_drilldown('nombrecarrera','estadisticasPrincipal.php','estadisticasDrillxPrograma.php','detalle','codigocarrera','','','','','','');
	$motor->mostrar();
}
?>
<br>
<input type="button" name="Informe_x_periodo" value="Informe_x_periodo" onclick="window.location.href='estadisticasDrillxPeriodo.php'";>

<?php
function Query(&$conexion,$query,$unicaFila=true){
	$operacion=$conexion->query($query);
	$row_operacion=$operacion->fetchRow();
	if($unicaFila==true){
		return $row_operacion;
	}
	else {
		do{
			if(!empty($row_operacion)){
				$array_interno[]=$row_operacion;
			}
		}
		while ($row_operacion=$operacion->fetchRow());
		if(is_array($array_interno)){
			return $array_interno;
		}
	}
}

function QueryLlave(&$conexion,$query,$llave){
	$operacion=$conexion->query($query);
	$row_operacion=$operacion->fetchRow();
	do{
		if(!empty($row_operacion)){
			$array_interno[$row_operacion[$llave]]=$row_operacion;
		}
	}
	while ($row_operacion=$operacion->fetchRow());
	if(is_array($array_interno)){
		return $array_interno;
	}
}

?>