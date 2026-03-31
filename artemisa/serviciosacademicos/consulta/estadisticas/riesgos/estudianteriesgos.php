<?php
//session_start();
session_start();
include_once('../../../utilidades/ValidarSesion.php'); 
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION);

require_once('../../../Connections/sala2.php');
$rutaado=("../../../funciones/adodb/");
//$rutazado = "../../../funciones/zadodb/";
require_once('../../../Connections/salaado.php'); 
require('../../../funciones/sala/nota/nota.php');
require ('../../../funciones/notas/redondeo.php');
require('../../../funciones/notas/funcionequivalenciapromedio.php');
if(isset($_GET['debug']))
{
	$db->debug = true; 
}

// Crear un formulario donde visualize los riesgos del estudiante
?>
<html>
<head>
<title>Riesgos del Estudiante</title>
</head>
<link rel="stylesheet" type="text/css" href="../../../estilos/sala.css">
<body>
<?php
$detallenota = new detallenota($_REQUEST['codigoestudiante'], $_SESSION['codigoperiodoriesgo']);
//echo "<pre>";print_r($detallenota);echo "</pre>";
$detallenota->setAcumuladoCertificado("1");
$riesgos = $detallenota->riesgoEstudiante(false);
$riesgosarreglo = explode("\\n",$riesgos); 
//print_r($riesgosarreglo);
foreach($riesgosarreglo as $key => $riesgo)
{
	if($key == 0)
		echo "<p>$riesgo</p>";
	else
		echo "$riesgo <br>";
}
//echo "$riesgos";
if(count($riesgosarreglo) <= 1)
	echo "<p>Este estudiante no tiene riesgo</p>"
?>
<br>
<br>
<input type="button" onClick="history.go(-1);" name="regresar" value="Regresar">
</body>
</html>