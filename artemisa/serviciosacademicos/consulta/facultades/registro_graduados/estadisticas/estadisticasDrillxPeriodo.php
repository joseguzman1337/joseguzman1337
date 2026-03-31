<?php
    session_start();
    include_once('../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
session_start();
error_reporting(2047);
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

for ($i=1984;$i<=2006;$i++){
	$periodos[$i."1"]=array('codigoperiodo'=>$i."1",'fecha_ini'=>$i."-01-01",'fecha_fin'=>$i."-07-15");
	$periodos[$i."2"]=array('codigoperiodo'=>$i."2",'fecha_ini'=>$i."-07-16",'fecha_fin'=>$i."-12-31");
	$cont_periodo++;
}

$query_modalidadacademica="SELECT * FROM modalidadacademica";
$array_modalidadacademica=Query(&$sala,$query_modalidadacademica,false);
?>
<form name="form1" method="GET" action="#">
<select name="codigomodalidadacademica">
<option value="">Seleccionar</option>

<?php 
foreach ($array_modalidadacademica as $llave_m => $valor_m){
?>
<option value="<?php echo $valor_m['codigomodalidadacademica']?>"><?php echo $valor_m['nombremodalidadacademica']?></option>
<?php }?>
</select>
<input type="submit" name="Enviar" value="Enviar">
</form>
<?php
if(isset($_GET['codigomodalidadacademica']) and $_GET['codigomodalidadacademica']<>""){
	$query_carreras="SELECT c.codigocarrera, c.nombrecarrera
	FROM carrera c 
	WHERE c.codigomodalidadacademica = '".$_GET['codigomodalidadacademica']."'
	ORDER BY c.codigomodalidadacademica, c.nombrecarrera 
	";
	
	$array_carrera=QueryLlave(&$sala,$query_carreras,'codigocarrera');



	if(is_array($array_carrera)){
		foreach ($array_carrera as $llave_c => $valor_c){
			foreach ($periodos as $llave_p => $valor_p){
				if($llave_p <= 20052){
					$query_conteo_x_carrera_ant2006="SELECT rga.idregistrograduadoantiguo
				FROM registrograduadoantiguo rga
				WHERE
				rga.codigocarrera='".$llave_c."'
				AND rga.fechagradoregistrograduadoantiguo BETWEEN '".$valor_p['fecha_ini']."' AND '".$valor_p['fecha_fin']."'";
					$operacion=$sala->query($query_conteo_x_carrera_ant2006);
					$total_operacion=$operacion->numRows();
					$totalizadorAnt=$totalizadorAnt + $total_operacion;
				}
				else{
					$query_graduados_x_programa_pos2006="SELECT rg.idregistrograduado
				FROM registrograduado rg, estudiante e
				WHERE
				rg.codigoestudiante=e.codigoestudiante
				AND e.codigocarrera='".$llave_c."'
				AND rg.codigoestado='100'
				AND rg.codigoautorizacionregistrograduado='100'
				AND rg.fechagradoregistrograduado BETWEEN '".$valor_p['fecha_ini']."' AND '".$valor_p['fecha_fin']."'";
					$operacion_new=$sala->query($query_graduados_x_programa_pos2006);
					$total_operacion_new=$operacion_new->numRows();
					$totalizadorNew=$totalizadorNew+$total_operacion_new;
				}
				$array_interno[$contador]['codigoperiodo']=$valor_p['codigoperiodo'];
				$array_interno[$contador]['nombrecarrera']=$valor_c['nombrecarrera'];
				$array_interno[$contador]['codigocarrera']=$valor_c['codigocarrera'];
				$array_interno[$contador]['cant_graduados_ant']=$totalizadorAnt;
				$array_interno[$contador]['cant_graduados']=$totalizadorNew;
				$array_interno[$contador]['Total']=$totalizadorAnt+$totalizadorNew;
				$totalizadorAnt=0;
				$totalizadorNew=0;
				$contador++;
			}

		}
	}
	if(isset($array_interno) and is_array($array_interno)){
		$motor = new matriz($array_interno,"por periodo",'estadisticasDrillxPrograma.php','si','no','estadisticasPrincipal.php','estadisticasDrillxPrograma.php',false,'si','../../../../');
		$motor->jsVarios();
		$motor->mostrar();
	}
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