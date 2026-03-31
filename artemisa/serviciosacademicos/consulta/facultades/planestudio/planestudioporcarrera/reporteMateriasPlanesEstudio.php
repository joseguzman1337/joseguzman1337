<?php 
    session_start();
    include_once('../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
?>
<?php
//ini_set('display_errors', 'On');
//error_reporting(E_ALL);
header("Content-type: application/x-msdownload");
header("Content-Disposition: attachment; filename=reportePlanesEstudio_".date('Y-m-d').".xls");
header("Pragma: no-cache");
header("Expires: 0");
ini_set('mysql.connect_timeout', 14400);
ini_set('default_socket_timeout', 14400);
require_once('../../../../mgi/datos/templates/template.php');
require_once("./funciones.php");
$db = getBD(false);

//var_dump($db);
$codigoperiodo = $_REQUEST['codigoperiodo'];
$queryPlanes = getQueryPlanesEstudioActivos($codigoperiodo);
//$queryPlanes =getQueryPlanesEstudio();
$planes = $db->GetAll($queryPlanes);
$estados[100] = "Activo";
$estados[101] = "Construccion";
$estados[200] = "Inactivo";
 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7">
<title>Reporte</title>


<style type="text/css">
table
{
 border-collapse: collapse;
    border-spacing: 0;
}
th, td {
border: 1px solid #000000;
    padding: 0.5em;
}
</style>
</head>
<body>
    <table>
        <thead>
            <tr>
                <th>Modalidad académica</th>
                <th>Programa académico</th>
                <th>No. Plan de Estudio</th>
                <th>Plan de Estudio</th>
                <th>Total Materias</th>
                <th>Total Créditos</th>
                <th>Total materias electivas obligatorias</th>
                <th>Total créditos electivas obligatorias</th>
                <th>Total materias electivas libres</th>
                <th>Total créditos electivas libres</th>
                <th>Estado plan</th>
                <th>Fecha de inicio del plan</th>
                <th>Indicador linea énfasis</th>
            </tr>
        </thead>
        <tbody>
		<?php
foreach($planes as $plan){
	echo "<tr>";
	$materiasQuery = getQueryMateriasElectivas($plan["idplanestudio"]);
	$materias = $db->GetAll($materiasQuery);
	echo "<td>".$plan["nombremodalidadacademica"]."</td>";
	echo "<td>".$plan["nombrecarrera"]."</td>";
	echo "<td>".$plan["idplanestudio"]."</td>";
	echo "<td>".$plan["nombreplanestudio"]."</td>";
	echo "<td>".$plan["numMaterias"]."</td>";
	echo "<td>".$plan["numCreditos"]."</td>";
	$resultados = array();
	foreach($materias as $row){
		$resultados[$row["codigotipomateria"]]["numMaterias"] = $row["numMaterias"];
		$resultados[$row["codigotipomateria"]]["numCreditos"] = $row["numCreditos"];
	}
	echo "<td>".$resultados[5]["numMaterias"]."</td>";
	echo "<td>".$resultados[5]["numCreditos"]."</td>";
	echo "<td>".$resultados[4]["numMaterias"]."</td>";
	echo "<td>".$resultados[4]["numCreditos"]."</td>";
	echo "<td>".$estados[$plan["codigoestadoplanestudio"]]."</td>";
	echo "<td>".$plan["fechainioplanestudio"]."</td>";
	echo "<td>".$plan["indicadorLinea"]."</td>";
	echo "</tr>";
}
?>
    </tbody>
    </table>
</body>
</html>