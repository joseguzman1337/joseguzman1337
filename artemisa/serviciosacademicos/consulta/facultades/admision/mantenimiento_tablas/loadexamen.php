<?php 
    session_start();
    include_once('../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
require_once('../../../Connections/sala2.php'); 
$rutaado = "../../../funciones/adodb/";
require_once('../../../Connections/salaado.php'); 

$db->debug = true; 

// Primero hay que crear la tabla temporal si esta no existe
/*$query_createxamen = "CREATE TABLE `tmpexamenadmision` (
`tipodocumento` char(2) NOT NULL,
`numerodocumento` int(11) NOT NULL,
`resultadoexamen` smallint(6) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;";
$createxamen = $db->Execute($query_createxamen);
*/
$query_dropexamen = "delete from tmpexamenadmision ";
$dropexamen = $db->Execute($query_dropexamen);

// Lleno la tabla temporal
$query_loadtexamen = "LOAD DATA LOCAL INFILE '/var/tmp/examenadmision.txt' INTO TABLE tmpexamenadmision";
$loadtexamen = $db->Execute($query_loadtexamen);

/*
Despues de subido el archivo hay que hacer las modificaciones respectivas en las tablas de admision examen
1. Insertar en la tabla estudianteadmision
*/
// Si ya existen datos en la tabla estudiante admision para la facultad no debe permitir hacer el cargue automático
$query_selestudianteadmision = "SELECT ea.idestudianteadmision, e.codigoestudiante, e.codigocarrera, e.idestudiantegeneral
FROM estudianteadmision ea, estudiante e, carreraperiodo cp, subperiodo sp
where e.codigoestudiante = ea.codigoestudiante
and ea.idsubperiodo = sp.idsubperiodo
and sp.idcarreraperiodo = cp.idcarreraperiodo
and e.codigocarrera = '$codigocarrera'
and cp.codigoperiodo = '$codigoperiodo'";
$selestudianteadmision = $db->Execute($query_selestudianteadmision);
if($selestudianteadmision == false) die("Falla en la realización del query");
if($selestudianteadmision->RecordCount() != 0)
{
?>
<script language="javascript">
	alert("Esta facultad ya tiene estudiantes registrados para este periodo");
	//history.go(-1);
</script>
<?php
	//exit();
}
else
{
	$query_insestudianteadmision = "INSERT INTO estudianteadmision(idestudianteadmision, fechaestudianteadmision, fechainicioestudianteadmision, fechafinalestudianteadmision, codigoestudiante, idinscripcion, idsubperiodo, codigoestado, codigoestadoestudianteadmision) 
	select 0 as idestudianteadmision, CURDATE() as fechaestudianteadmision, CURDATE() as fechainicioestudianteadmision, 0 as fechafinalestudianteadmision, e.codigoestudiante, 
	i.idinscripcion, sp.idsubperiodo, 100 as codigoestado, 100 as codigoestadoestudianteadmision 
	from estudiante e, estudiantegeneral eg, carrera c, estudiantecarrerainscripcion ei, inscripcion i, tmpexamenadmision te, 
	carreraperiodo cp, subperiodo sp 
	where eg.idestudiantegeneral = e.idestudiantegeneral 
	and e.codigosituacioncarreraestudiante like '107' 
	and e.codigocarrera = c.codigocarrera 
	and ei.idinscripcion = i.idinscripcion 
	and ei.codigocarrera = e.codigocarrera 
	and i.idestudiantegeneral = e.idestudiantegeneral 
	and i.codigoperiodo = '$codigoperiodo' 
	and te.numerodocumento = eg.numerodocumento 
	and cp.codigoperiodo = '$codigoperiodo' 
	and cp.codigocarrera = e.codigocarrera 
	and cp.codigoestado like '1%' 
	and sp.idcarreraperiodo = cp.idcarreraperiodo 
	and sp.codigoestadosubperiodo like '1%'
	and e.codigocarrera = '$codigocarrera'";	
	$insestudianteadmision = $db->Execute($query_insestudianteadmision);
}
/*
2. Insertar en la tabla detalleestudianteadmision para el tipo detalle de examen
*/
$query_seldetalleestudianteadmision = "SELECT ea.idestudianteadmision, ea.codigoestudiante 
FROM estudianteadmision ea, estudiante e, carreraperiodo cp, subperiodo sp, detalleestudianteadmision dea, detalleadmision da
WHERE e.codigoestudiante = ea.codigoestudiante
AND ea.idsubperiodo = sp.idsubperiodo
AND sp.idcarreraperiodo = cp.idcarreraperiodo
AND e.codigocarrera = '$codigocarrera'
AND cp.codigoperiodo = '$codigoperiodo'
AND dea.idestudianteadmision = ea.idestudianteadmision
and da.iddetalleadmision = dea.iddetalleadmision
and ea.codigoestado like '1%'
and dea.codigoestado like '1%'
and da.codigotipodetalleadmision like '1%'";
$seldetalleestudianteadmision = $db->Execute($query_seldetalleestudianteadmision);
if($seldetalleestudianteadmision == false) die("Falla en la realización del query");
if($seldetalleestudianteadmision->RecordCount() != 0)
{
?>
<script language="javascript">
	alert("Esta facultad ya tiene estudiantes registrados con exámen para este periodo");
	//history.go(-1);
</script>
<?php
	//exit();
}
else
{
	$query_insdetalleestudianteadmision = "INSERT INTO detalleestudianteadmision(iddetalleestudianteadmision, fechadetalleestudianteadmision, idestudianteadmision, iddetalleadmision, resultadodetalleestudianteadmision, horainiciodetalleestudianteadmision, horafinaldetalleestudianteadmision, idhorariositioadmision, codigoestado, codigoestadoestudianteadmision, observacionesdetalleestudianteadmision) 
	select 0 as iddetalleestudianteadmision, now() as fechadetalleestudianteadmision, ea.idestudianteadmision, 
	da.iddetalleadmision, te.resultadoexamen as resultadodetalleestudianteadmision, now() as horainiciodetalleestudianteadmision, 
	now() as horafinaldetalleestudianteadmision, hs.idhorariositioadmision, 100 as codigoestado, 100 as codigoestadoestudianteadmision, 
	'EXAMEN ADMISION MASIVO' as observacionesdetalleestudianteadmision 
	from estudianteadmision ea, admision a, estudiante e, detalleadmision da, tmpexamenadmision te, horariositioadmision hs, estudiantegeneral eg, sitioadmision sa
	where ea.codigoestudiante = e.codigoestudiante
	and a.codigocarrera = e.codigocarrera
	and a.codigoperiodo = '$codigoperiodo'
	and da.idadmision = a.idadmision
	and te.numerodocumento = eg.numerodocumento
	and eg.idestudiantegeneral = e.idestudiantegeneral
	and sa.codigocarrera = e.codigocarrera
	and sa.codigoestado like '1%'
	and sa.idsitioadmision = hs.idsitioadmision
	and da.codigotipodetalleadmision = '1'
	and e.codigocarrera = '$codigocarrera'";	
	$insdetalleestudianteadmision = $db->Execute($query_insdetalleestudianteadmision);
}

/*
3. Insertar en la tabla detalleestudianteadmision para el tipo detalle de icfes
*/
$query_seldetalleestudianteadmision = "SELECT ea.idestudianteadmision 
FROM estudianteadmision ea, estudiante e, carreraperiodo cp, subperiodo sp, detalleestudianteadmision dea, detalleadmision da
WHERE e.codigoestudiante = ea.codigoestudiante
AND ea.idsubperiodo = sp.idsubperiodo
AND sp.idcarreraperiodo = cp.idcarreraperiodo
AND e.codigocarrera = '$codigocarrera'
AND cp.codigoperiodo = '$codigoperiodo'
AND dea.idestudianteadmision = ea.idestudianteadmision
and da.iddetalleadmision = dea.iddetalleadmision
and ea.codigoestado like '1%'
and dea.codigoestado like '1%'
and da.codigotipodetalleadmision like '4%'";
$seldetalleestudianteadmision = $db->Execute($query_seldetalleestudianteadmision);
if($seldetalleestudianteadmision == false) die("Falla en la realización del query");
if($seldetalleestudianteadmision->RecordCount() != 0)
{
?>
<script language="javascript">
	alert("Esta facultad ya tiene estudiantes registrados con exámen para este periodo");
	//history.go(-1);
</script>
<?php
	//exit();
}
else
{
	while(!$selestudianteadmision->EOF)
	{
		// Insertar estudiantes en icfes
		$query_insdetalleestudianteadmision = "INSERT INTO detalleestudianteadmision(iddetalleestudianteadmision, fechadetalleestudianteadmision, idestudianteadmision, iddetalleadmision, resultadodetalleestudianteadmision, horainiciodetalleestudianteadmision, horafinaldetalleestudianteadmision, idhorariositioadmision, codigoestado, codigoestadoestudianteadmision, observacionesdetalleestudianteadmision) 
		select 0 as iddetalleestudianteadmision, now() as fechadetalleestudianteadmision, ea.idestudianteadmision, 
		da.iddetalleadmision, (select sum(dr.notadetalleresultadopruebaestado) / count(dr.notadetalleresultadopruebaestado) as resultadoprueba
		from resultadopruebaestado rp, detalleresultadopruebaestado dr, asignaturaestado ae
		where rp.idestudiantegeneral = '".$selestudianteadmision->fields['idestudiantegeneral']."'
		and dr.idresultadopruebaestado = rp.idresultadopruebaestado
		and dr.idasignaturaestado = ae.idasignaturaestado
		and ae.codigoestado like '1%'
		group by rp.idestudiantegeneral) as resultadodetalleestudianteadmision, now() as horainiciodetalleestudianteadmision, 
		now() as horafinaldetalleestudianteadmision, hs.idhorariositioadmision, 100 as codigoestado, 100 as codigoestadoestudianteadmision, 
		'EXAMEN ADMISION MASIVO' as observacionesdetalleestudianteadmision 
		from estudianteadmision ea, admision a, estudiante e, detalleadmision da, horariositioadmision hs, estudiantegeneral eg, sitioadmision sa
		where ea.codigoestudiante = e.codigoestudiante
		and a.codigocarrera = e.codigocarrera
		and a.codigoperiodo = '$codigoperiodo'
		and da.idadmision = a.idadmision
		and eg.idestudiantegeneral = e.idestudiantegeneral
		and sa.codigocarrera = e.codigocarrera
		and sa.codigoestado like '1%'
		and sa.idsitioadmision = hs.idsitioadmision
		and da.codigotipodetalleadmision = '4'
		and e.codigocarrera = '$codigocarrera'
		and e.codigoestudiante = '".$selestudianteadmision->fields['codigoestudiante']."'";	
		$insdetalleestudianteadmision = $db->Execute($query_insdetalleestudianteadmision);
		$selestudianteadmision->MoveNext();
	}
}

/*
Por último se elimina la tabla temporal
*/
//$query_dropexamen = "drop table tmpexamenadmision";
$query_dropexamen = "delete from tmpexamenadmision ";
$dropexamen = $db->Execute($query_dropexamen);

exit();
echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=subirexamen.php?cargado'>";
?>
<script language="javascript">
	window.location.reload("subirexamen.php?cargado");
</script>
