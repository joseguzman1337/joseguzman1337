<?php
    session_start();
    include_once('../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
session_start();
ini_set('memory_limit', '128M');
ini_set('max_execution_time','216000');
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
$contador=0;
$totalizadorNew=0;
$totalizadorAnt=0;
$cont_periodo=0;;
$query_periodos_academicos="SELECT p.* FROM periodo p WHERE p.codigoperiodo >= '19841' and p.codigoperiodo <= '20062'";
//$periodos=QueryLlave(&$sala,$query_periodos_academicos,'codigoperiodo');

/*
 * @modified Carlos Suarez <suarezcarlos@unbosque.edu.co>
 * Aranda caso  83960
 * consulta actualizadas incluyendo las nuevas tablas creadas en el nuevo sistema de grados
 * @since  November 29, 2016
*/
$anioActual = date("Y");

for ($i=1984;$i<=$anioActual;$i++){
	$periodos[$i."1"]=array('codigoperiodo'=>$i."1",'fecha_ini'=>$i."-01-01",'fecha_fin'=>$i."-07-15");
	$periodos[$i."2"]=array('codigoperiodo'=>$i."2",'fecha_ini'=>$i."-07-16",'fecha_fin'=>$i."-12-31");
	$cont_periodo++;
}
/* END */
foreach ($periodos as $llave_p => $valor_p){

	$query_conteo_x_carrera_ant2006="SELECT COUNT(rga.idregistrograduadoantiguo) as cant
	FROM registrograduadoantiguo rga
	WHERE
	rga.codigocarrera='".$_GET['codigocarrera']."'
	AND rga.fechagradoregistrograduadoantiguo BETWEEN '".$valor_p['fecha_ini']."' AND '".$valor_p['fecha_fin']."'";
	$row_conteo=Query(&$sala,$query_conteo_x_carrera_ant2006,true);
	$totalizadorAnt=$totalizadorAnt + $row_conteo['cant'];

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
		AND e.codigocarrera = '".$_GET['codigocarrera']."'
		AND rg.codigoestado = '100'
		AND rg.codigoautorizacionregistrograduado = '100'
		AND rg.fechagradoregistrograduado BETWEEN '".$valor_p['fecha_ini']."' AND '".$valor_p['fecha_fin']."'
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
				E.codigocarrera = '".$_GET['codigocarrera']."'
			AND D.CodigoEstado = 100
			AND R.CodigoEstado = 100
			AND F.CodigoPeriodo = '".$llave_p."'
	) b";
	//echo $query_graduados_x_programa_pos2006."<br />";
	/* END */
	$row_conteo_pos=Query(&$sala,$query_graduados_x_programa_pos2006,true);
	$totalizadorNew=$totalizadorNew+$row_conteo_pos['cant'];


	$array_x_carrera[$contador]['codigoperiodo']=$llave_p;
	$array_x_carrera[$contador]['cant_graduados_ant']=$row_conteo['cant'];
	$array_x_carrera[$contador]['cant_graduados']=$row_conteo_pos['cant'];
	$array_x_carrera[$contador]['totalizarAnt']=$totalizadorAnt;
	$array_x_carrera[$contador]['totalizarNew']=$totalizadorNew;
	$contador++;
}

$total=$totalizadorAnt+$totalizadorNew;

if(is_array($array_x_carrera)){
	$motor = new matriz($array_x_carrera,$_SESSION['array_carrera'][$_GET['codigocarrera']]['nombrecarrera']." TOTAL GRADUADOS: $total ",'estadisticasDrillxPrograma.php','si','no','estadisticasPrincipal.php','estadisticasDrillxPrograma.php',false,'si','../../../../');
	$motor->jsVarios();
	$motor->mostrar();
}
?>



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