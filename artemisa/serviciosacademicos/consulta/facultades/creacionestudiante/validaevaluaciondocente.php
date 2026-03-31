<?php
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);  
    
function validaevaluaciondocente($sala,$codigoestudiante,$codigoperiodo,$codigocarrera){
$codigoperiodoposterior=encontrarPeriodoPosterior($codigoperiodo);

   $query_selcarrera = "select ec.carrera
from evaluacioncarrera ec
where ec.carrera = '".$codigocarrera."'
AND codigoperiodo = '".$codigoperiodo."'";
$selcarrera = mysql_query($query_selcarrera, $sala) or die("$query_selcarrera".mysql_error());
$totalRows_selcarrera = mysql_num_rows($selcarrera);
if($totalRows_selcarrera != "")
{
	 $query_selevaluacion = "SELECT dc.numerodocumento
FROM prematricula p, detalleprematricula d, grupo g, docente dc, materia m, carrera j
WHERE p.idprematricula=d.idprematricula
AND p.codigoestudiante='".$codigoestudiante."'
AND d.codigoestadodetalleprematricula='30'
AND g.idgrupo=d.idgrupo
and g.codigoperiodo = '".$codigoperiodo."'
AND dc.numerodocumento=g.numerodocumento
AND m.codigomateria=g.codigomateria
AND j.codigocarrera=m.codigocarrera
and dc.numerodocumento not in (select codigodocente from respuestas where codigoperiodo='".$codigoperiodo."' and codigoestudiante='".$codigoestudiante."')
and dc.numerodocumento <> 1";
	//echo "uno $query_selevaluacion";
	//$query_selevaluacion."<br>";
	//exit();
	$selevaluacion = mysql_query($query_selevaluacion, $sala) or die("$query_selevaluacion".mysql_error());
	$totalRows_selevaluacion = mysql_num_rows($selevaluacion);
	if($totalRows_selevaluacion > 0)
	{
		$query_selprematricula = "select p.codigoestudiante from prematricula p
		where p.codigoestudiante = '$codigoestudiante'
		and p.codigoperiodo = '".$codigoperiodoposterior."'
		and p.codigoestadoprematricula like '4%'";
		//echo "uno $query_selprematricula";
		$selprematricula = mysql_query($query_selprematricula, $sala) or die("$query_selprematricula".mysql_error());
		$totalRows_selprematricula = mysql_num_rows($selprematricula);

		if($totalRows_selprematricula != "")
		{
                    //echo "<br>if(".$_SESSION['codigoperiodosesion']." == ".$codigoperiodoposterior.")";
			if($_SESSION['codigoperiodosesion'] == $codigoperiodoposterior)
			{
				
				if(ereg("^estudiante+$", $_SESSION['MM_Username']))
				{
                                  return 0;
				}
			}
		}
	}
}
return 1;
}

?>
