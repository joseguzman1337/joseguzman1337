<?php
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
/*$query_inscritos = "SELECT p.codigoestudiante, concat(e.nombresestudiante,' ',e.apellidosestudiante) as nombre
FROM detalleprematricula d, prematricula p, estudiante e
WHERE d.idprematricula = p.idprematricula
AND p.codigoestudiante = e.codigoestudiante 
AND p.codigoestadoprematricula like '1%'
AND d.codigoestadodetalleprematricula like '1%'
AND d.idgrupo = '$idgrupo'";
//echo "<br>$query_inscritos<br>";
$res_inscritos = mysql_query($query_inscritos, $sala) or die(mysql_error());
$total_prematriculados = mysql_num_rows($res_inscritos);
		
// Este query es para los estudiantes que tienen ordenes de pago nuevas y tienen la prematricula en estado 4%
$query_inscritos2 = "SELECT c.nombrecarrera,p.codigoestudiante, concat(e.apellidosestudiante,' ',e.nombresestudiante) as nombre
FROM detalleprematricula d, prematricula p, estudiante e,carrera c
WHERE d.idprematricula = p.idprematricula
AND p.codigoestudiante = e.codigoestudiante 
AND c.codigocarrera = e.codigocarrera
AND p.codigoestadoprematricula like '4%'
AND d.codigoestadodetalleprematricula like '1%'
AND d.idgrupo = '$idgrupo'
order by 1,3 asc";
$res_inscritos2 = mysql_query($query_inscritos2, $sala) or die(mysql_error());
$total_prematriculados2 = mysql_num_rows($res_inscritos2);
$valor_prematriculados = $total_prematriculados + $total_prematriculados2;
	
$query_matriculados = "SELECT p.codigoestudiante, concat(e.nombresestudiante,' ',e.apellidosestudiante) as nombre
FROM detalleprematricula d, prematricula p, estudiante e
WHERE d.idprematricula = p.idprematricula
AND p.codigoestudiante = e.codigoestudiante 
AND p.codigoestadoprematricula like '4%'
AND d.codigoestadodetalleprematricula like '3%'
AND idgrupo = '$idgrupo'
order by 1,3 asc";
//echo "<br>$query_matriculados<br>";
$res_matriculados = mysql_query($query_matriculados, $sala) or die(mysql_error());
$total_matriculados = mysql_num_rows($res_matriculados);
$matriculadosgrupo =  $valor_prematriculados + $total_matriculados;
*/
$query_inscritos = "SELECT c.nombrecarrera, p.codigoestudiante, eg.numerodocumento ,concat(eg.apellidosestudiantegeneral,' ',eg.nombresestudiantegeneral) as nombre
FROM detalleprematricula d, prematricula p, estudiante e,carrera c,estudiantegeneral eg
WHERE e.idestudiantegeneral = eg.idestudiantegeneral 
and d.idprematricula = p.idprematricula
AND p.codigoestudiante = e.codigoestudiante 
AND c.codigocarrera = e.codigocarrera
AND p.codigoestadoprematricula like '1%'
AND d.codigoestadodetalleprematricula like '1%'
AND d.idgrupo = '$idgrupo'
order by 1,4 asc
";
$res_inscritos = mysql_query($query_inscritos, $sala) or die("1");
$total_prematriculados = mysql_num_rows($res_inscritos);

// Este query es para los estudiantes que tienen ordenes de pago nuevas y tienen la prematricula en estado 4%
$query_inscritos2 = "SELECT c.nombrecarrera,eg.numerodocumento, p.codigoestudiante, concat(eg.apellidosestudiantegeneral,' ',eg.nombresestudiantegeneral) as nombre
FROM detalleprematricula d, prematricula p, estudiante e,carrera c,estudiantegeneral eg
WHERE e.idestudiantegeneral = eg.idestudiantegeneral 
and d.idprematricula = p.idprematricula
AND p.codigoestudiante = e.codigoestudiante 
AND c.codigocarrera = e.codigocarrera
AND p.codigoestadoprematricula like '4%'
AND d.codigoestadodetalleprematricula like '1%'
AND d.idgrupo = '$idgrupo'
order by 1,4 asc";
$res_inscritos2 = mysql_query($query_inscritos2, $sala) or die("2");
$total_prematriculados2 = mysql_num_rows($res_inscritos2);

$query_matriculados = "SELECT eg.idestudiantegeneral,c.nombrecarrera, eg.numerodocumento, p.codigoestudiante, concat(eg.apellidosestudiantegeneral,' ',eg.nombresestudiantegeneral) as nombre
FROM detalleprematricula d, prematricula p, estudiante e,carrera c,estudiantegeneral eg
WHERE e.idestudiantegeneral = eg.idestudiantegeneral 
and d.idprematricula = p.idprematricula
AND p.codigoestudiante = e.codigoestudiante 
AND c.codigocarrera = e.codigocarrera
AND p.codigoestadoprematricula like '4%'
AND d.codigoestadodetalleprematricula like '3%'
AND d.idgrupo = '$idgrupo'
order by 5 asc";
$res_matriculados = mysql_query($query_matriculados, $sala) or die("3");
$total_matriculados = mysql_num_rows($res_matriculados);
?>
