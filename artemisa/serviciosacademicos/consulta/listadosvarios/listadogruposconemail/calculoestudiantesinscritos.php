<?php
/**
 * Caso 2927
 * @modified Luis Dario Gualteros C <castroluisd@unbosque.edu.co>
 * Lista los estudiantes prematriculados con orden de pago pendiente por pago sin importar si tienen usuario.
 * @since  Julio 22, 2019.
*/
$query_inscritos = "SELECT  
	c.nombrecarrera,
	p.codigoestudiante,
	CONCAT(eg.apellidosestudiantegeneral,' ',	eg.nombresestudiantegeneral) AS nombre,
	eg.numerodocumento,
	eg.emailestudiantegeneral,
	CASE
 	 WHEN u.usuario IS NULL THEN 'SIN INFORMACIÓN ' 
		ELSE  CONCAT(u.usuario, '@unbosque.edu.co')
	END	AS usuario
FROM
	detalleprematricula d
  INNER JOIN prematricula p ON (d.idprematricula = p.idprematricula)
  INNER JOIN estudiante e ON (p.codigoestudiante = e.codigoestudiante)
  INNER JOIN carrera c ON (c.codigocarrera = e.codigocarrera)
  INNER JOIN estudiantegeneral eg ON (e.idestudiantegeneral = eg.idestudiantegeneral)
  LEFT JOIN usuario u ON (eg.numerodocumento = u.numerodocumento AND u.codigotipousuario = '600')
WHERE
 p.codigoestadoprematricula = '10'
AND d.codigoestadodetalleprematricula = '10'
AND d.idgrupo = $idgrupo
AND p.codigoperiodo = $codigoperiodo
ORDER BY 3 ASC ";

$res_inscritos = mysql_query($query_inscritos, $sala) or die(mysql_error());
$total_prematriculados = mysql_num_rows($res_inscritos);

// Este query es para los estudiantes que tienen ordenes de pago nuevas y tienen la prematricula en estado 4%
$query_inscritos2 = "SELECT c.nombrecarrera, p.codigoestudiante, concat(eg.apellidosestudiantegeneral,' ',eg.nombresestudiantegeneral) as nombre,
eg.numerodocumento, eg.emailestudiantegeneral, u.usuario
FROM detalleprematricula d, prematricula p, estudiante e,carrera c, estudiantegeneral eg, usuario u
WHERE d.idprematricula = p.idprematricula
AND p.codigoestudiante = e.codigoestudiante 
AND c.codigocarrera = e.codigocarrera
AND p.codigoestadoprematricula like '4%'
AND d.codigoestadodetalleprematricula like '1%'
AND d.idgrupo = '$idgrupo'
and p.codigoperiodo = '$codigoperiodo'
and e.idestudiantegeneral = eg.idestudiantegeneral
and eg.numerodocumento=u.numerodocumento
and u.codigotipousuario like '6%'
order by 3 asc";
$res_inscritos2 = mysql_query($query_inscritos2, $sala) or die(mysql_error());
$total_prematriculados2 = mysql_num_rows($res_inscritos2);

$query_matriculados = "SELECT * FROM
(
SELECT c.nombrecarrera, p.codigoestudiante, concat(eg.apellidosestudiantegeneral,' ',eg.nombresestudiantegeneral) as nombre,
eg.numerodocumento, eg.emailestudiantegeneral, u.usuario, o.fechapagosapordenpago, lg.codigoestadodetalleprematricula, 
lg.fechalogfechadetalleprematricula, p.fechaprematricula
FROM detalleprematricula d
INNER JOIN prematricula p on d.idprematricula = p.idprematricula AND p.codigoestadoprematricula like '4%' and p.codigoperiodo = '$codigoperiodo'
INNER JOIN estudiante e on p.codigoestudiante = e.codigoestudiante 
INNER JOIN carrera c on c.codigocarrera=e.codigocarrera 
INNER JOIN estudiantegeneral eg on e.idestudiantegeneral = eg.idestudiantegeneral
INNER JOIN ordenpago o on d.numeroordenpago=o.numeroordenpago AND o.codigoestudiante = e.codigoestudiante
INNER JOIN grupo gr on gr.idgrupo=d.idgrupo  
LEFT JOIN usuario u ON eg.numerodocumento = u.numerodocumento 
		AND u.codigotipousuario LIKE '6%'
LEFT JOIN logdetalleprematricula lg ON lg.idprematricula=p.idprematricula and lg.codigomateria=gr.codigomateria and lg.codigoestadodetalleprematricula IN(10) 
WHERE d.codigoestadodetalleprematricula like '3%'
AND d.idgrupo = '$idgrupo' 
and o.codigoperiodo='$codigoperiodo'
and o.codigoestadoordenpago like '4%' 
order by 3 asc, lg.fechalogfechadetalleprematricula ASC) x GROUP BY x.numerodocumento";

$res_matriculados = mysql_query($query_matriculados, $sala) or die(mysql_error());
$total_matriculados = mysql_num_rows($res_matriculados);
?>
