<?php
$query_inscritos = "SELECT c.nombrecarrera, p.codigoestudiante, concat(eg.apellidosestudiantegeneral,' ',eg.nombresestudiantegeneral) as nombre,eg.numerodocumento
FROM detalleprematricula d, prematricula p, estudiante e,carrera c,estudiantegeneral eg
WHERE d.idprematricula = p.idprematricula
and e.idestudiantegeneral = eg.idestudiantegeneral
AND p.codigoestudiante = e.codigoestudiante 
AND c.codigocarrera = e.codigocarrera
AND p.codigoestadoprematricula like '1%'
AND d.codigoestadodetalleprematricula like '1%'
AND d.idgrupo = '$idgruporef'
and p.codigoperiodo = '$codigoperiodo'
order by 1,3 asc";
$res_inscritos = mysql_query($query_inscritos, $sala) or die(mysql_error());
$total_prematriculados = mysql_num_rows($res_inscritos);

// Este query es para los estudiantes que tienen ordenes de pago nuevas y tienen la prematricula en estado 4%
$query_inscritos2 = "SELECT c.nombrecarrera, p.codigoestudiante, concat(eg.apellidosestudiantegeneral,' ',eg.nombresestudiantegeneral) as nombre,eg.numerodocumento
FROM detalleprematricula d, prematricula p, estudiante e,carrera c,estudiantegeneral eg
WHERE d.idprematricula = p.idprematricula
and e.idestudiantegeneral = eg.idestudiantegeneral
AND p.codigoestudiante = e.codigoestudiante 
AND c.codigocarrera = e.codigocarrera
AND p.codigoestadoprematricula like '4%'
AND d.codigoestadodetalleprematricula like '1%'
AND d.idgrupo = '$idgruporef'
and p.codigoperiodo = '$codigoperiodo'
order by 1,3 asc";
$res_inscritos2 = mysql_query($query_inscritos2, $sala) or die(mysql_error());
$total_prematriculados2 = mysql_num_rows($res_inscritos2);

$query_matriculados = "SELECT c.nombrecarrera, p.codigoestudiante, concat(eg.apellidosestudiantegeneral,' ',eg.nombresestudiantegeneral) as nombre,eg.numerodocumento
FROM detalleprematricula d, prematricula p, estudiante e,carrera c,estudiantegeneral eg
WHERE d.idprematricula = p.idprematricula
and e.idestudiantegeneral = eg.idestudiantegeneral
AND p.codigoestudiante = e.codigoestudiante 
AND c.codigocarrera = e.codigocarrera
AND p.codigoestadoprematricula like '4%'
AND d.codigoestadodetalleprematricula like '3%'
AND d.idgrupo = '$idgruporef'
and p.codigoperiodo = '$codigoperiodo'
order by 1,3 asc";
$res_matriculados = mysql_query($query_matriculados, $sala) or die(mysql_error());
$total_matriculados = mysql_num_rows($res_matriculados);
?>