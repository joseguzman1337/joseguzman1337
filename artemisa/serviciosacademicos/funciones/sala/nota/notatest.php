<?php
require_once('../../../Connections/sala2.php');
$rutaado = "../../adodb/";
//$rutazado = "../../../funciones/zadodb/";
require_once('../../../Connections/salaado.php'); 
require('nota.php');

set_time_limit(9000000000);

if(isset($_GET['debug']))
{
	$db->debug = true; 
}
if(isset($_GET['test']))
{
	$codigoperiodo = 20081;
	$codigoestudiante = 40732;
	$codigoestudiante = 22545;
	$detallenota = new detallenota($codigoestudiante, $codigoperiodo);
	if($detallenota->tieneNotas())
	{
	    echo "<pre>";
	    print_r($detallenota);
	    echo "</pre>";
	    
	    if($detallenota->esAltoRiesgo())
	    {
	        echo "ALto Que man tan vago";
	    }
	    //echo "Tiene Notas";
	    if($detallenota->estaEnPrueba())
	    {
	        echo "<br>Estea man sigue de vago";
	    }
	    
	}
	else
	{
	    echo "El estudiante no tiene notas";
	}
	echo "<br>RIESGO : ".$detallenota->riesgoEstudiante();
	echo "<br>PERDIO ALGUNA MATERIA POR FALLAS? : ".$detallenota->perdioPorFallas();
	
	// Para validar que es mediano riesgo es que no sea alto riesgo y este en mediano riesgo
	
}
if(isset($_GET['codigoperiodo']))
{
	$codigoperiodo = $_GET['codigoperiodo'];
	// 0. Selecciona todos los estudiantes que tienen prematricula paga en el periodo que se desea
	$query_estudiantes = "select distinct p.codigoestudiante
	from prematricula p
	where p.codigoperiodo = '$codigoperiodo'
	and p.codigoestadoprematricula like '4%'
	order by 1";
	$estudiantes = $db->Execute($query_estudiantes);
	$totalRows_estudiantes = $estudiantes->RecordCount();
	while($row_estudiantes = $estudiantes->FetchRow())
	{
		$codigoestudiante = $row_estudiantes['codigoestudiante'];
		unset($detallenota);
		$detallenota = new detallenota($codigoestudiante, $codigoperiodo, $condatos = false);
		$ppa = $detallenota->tienePPAenBD();
		if($ppa == false)
		{
			$ppa = $detallenota->calculaPPA();
			if($ppa != 0)
			{
				$detallenota->insertarPPAenBD($ppa);
			}
		}
	}
}

if(isset($_GET['eliminar']))
{
	$query_estudiantes = "select count(*) as cuenta, valorbasesalario, idbasesalario 
	from basesalario
	group by 2
	having cuenta > 1";
	$estudiantes = $db->Execute($query_estudiantes);
	$totalRows_estudiantes = $estudiantes->RecordCount();
	while($row_estudiantes = $estudiantes->FetchRow())
	{
		$query_delestudiantes = "DELETE FROM basesalario WHERE idbasesalario = ".$row_estudiantes['idbasesalario']."";
		$delestudiantes = $db->Execute($query_delestudiantes);
	}
}
// 1. Mirar si el estudiante tiene ppa en la tabla 

?>