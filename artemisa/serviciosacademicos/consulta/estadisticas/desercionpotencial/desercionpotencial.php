<?php
$nombrearchivo = 'desercionpotencial'.$_GET['fecha'];
if(isset($_REQUEST['formato']))
{
	$formato = $_REQUEST['formato'];
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
}

session_start();
$ruta = "../../../";
require_once($ruta.'Connections/sala2.php');
$rutaado = "../../../funciones/adodb/";
//$rutazado = "../../../funciones/zadodb/";
require_once($ruta.'Connections/salaado.php'); 
require_once('CDesercion.php'); 

?>
<html>
<head>
<title>Deserción Potencial</title>
<?php
if(!isset($_REQUEST['formato']))
{
?>
<link rel="stylesheet" type="text/css" href="<?php echo $ruta;?>estilos/sala.css">
<?php
}
?>
</head>
<body>
<form action="" name="f1" method="get">
<?php
if(isset($_GET['fecha']))
{
    $fecha = $_GET['fecha'];
    //echo "<b>REPORTE GENERADO PARA $fecha<b>";
}
if(!isset($_REQUEST['formato']))
{
?>
<a href="?formato&fecha=<?php echo $_GET['fecha'] ?>">Descargar a Excel</a><br><br>
<b>FECHA</b><br><input type="text" name="fecha"> aaaa-mm-dd<br><br>
<input type="submit" value="Generar">
<?php
}
?>
</form>
<?php
if(!isset($_GET['fecha']))
    exit();
else
{
    $fecha = $_GET['fecha'];
    echo "<b>REPORTE GENERADO PARA $fecha<b>";
}
// Primero traer las carreras de pregrado que son a las que se les va a hacer seguimiento
$query_carrera = "SELECT codigocarrera, nombrecarrera, codigomodalidadacademica
FROM carrera
where codigomodalidadacademica like '2%'
and fechavencimientocarrera > now()
order by 2";
$carrera = $db->Execute($query_carrera);
$totalRows_carrera = $carrera->RecordCount();

$query_situacion = "SELECT codigosituacioncarreraestudiante, nombresituacioncarreraestudiante 
FROM situacioncarreraestudiante
order by 1";
$situacion = $db->Execute($query_situacion);
$totalRows_situacion = $situacion->RecordCount();

?>
<table border="1" cellpadding="1" cellspacing="0">
<tr id="trtitulogris">
  <td rowspan="2">PROGRAMA ACADEMICO</td>
<?php
while($row_situacion = $situacion->FetchRow()) :
    $Asituacion[$row_situacion['nombresituacioncarreraestudiante']] = $row_situacion['codigosituacioncarreraestudiante'];
?>
  <td colspan="2"><?php echo $row_situacion['nombresituacioncarreraestudiante'];?></td>
<?php
endwhile;
?>
</tr>
<tr>
<?php
foreach($Asituacion as $key => $value) :
?>
<td>P</td><td>NP</td>
<?php
endforeach;
?>
</tr>
<?php
while($row_carrera = $carrera->FetchRow())
{
?>
<tr>
  <td><?php echo $row_carrera['nombrecarrera']; ?></td>
<?php
    //$db->debug = true;
    foreach($Asituacion as $key => $value) 
    {
        $prematriculados = 0;
        $noprematriculados = 0;
        $prematriculados = $prematriculados+obtener_prematriculados($row_carrera['codigocarrera'], $value, $fecha);
        $noprematriculados = $noprematriculados+obtener_noprematriculados($row_carrera['codigocarrera'], $value, $fecha);
        $totales[$value]['prematriculados'] = $totales[$value]['prematriculados']+$prematriculados;
        $totales[$value]['noprematriculados'] = $totales[$value]['noprematriculados']+$noprematriculados;
?>
<td><?php echo $prematriculados;?></td>
<td><?php echo $noprematriculados;?></td>
<?php
    }
?>
</tr>
<?php
}
?>
<tr id="trtitulogris">
<td>TOTALES</td>
<?php
    //$db->debug = true;
    $totalprematriculados = 0;
    $totalnoprematriculados = 0;
    foreach($Asituacion as $key => $value) 
    {
        $totalprematriculados = $totalprematriculados + $totales[$value]['prematriculados'];
        $totalnoprematriculados = $totalnoprematriculados + $totales[$value]['noprematriculados'];
?>
<td><?php echo $totales[$value]['prematriculados'];?></td>
<td><?php echo $totales[$value]['noprematriculados'];?></td>
<?php
    }
?>
</tr>
</table>
<table>
<tr>
<td id="tdtitulogris">
Total Prematriculados
</td>
<td>
<?php echo $totalprematriculados; ?>
</td>
</tr>
<tr>
<td id="tdtitulogris">
Total No Prematriculados
</td>
<td>
<?php echo $totalnoprematriculados; ?>
</td>
</tr>
</table>
</body>
</html>
