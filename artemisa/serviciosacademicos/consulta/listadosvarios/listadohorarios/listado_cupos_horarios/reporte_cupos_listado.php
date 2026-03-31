<?php
require('../../../../Connections/sala2.php');
$rutaado = "../../../../funciones/adodb/";
require_once('../../../../Connections/salaado.php');
require_once('../../../../funciones/clases/motorv2/motor.php');
session_start();
$db->SetFetchMode(ADODB_FETCH_ASSOC);

$codigoperiodo = $_SESSION['codigoperiodosesion'];

if ($_REQUEST['nacodigomodalidadacademica'] == 0 and $_REQUEST['nacodigocarrera'] == 0 and $_REQUEST['tipo'] == 0) {

    if ($_REQUEST['horario'] == 2) {
        $query_materia = "SELECT m.codigomateria, m.nombremateria, m.numerocreditos, tm.nombretipomateria, ple.semestredetalleplanestudio as semestre, ple.idplanestudio, ple.nombreplanestudio, SUM(maximogrupo - (matriculadosgrupoelectiva + matriculadosgrupo) ) AS cupo, concat(d.nombredocente,' ', d.apellidodocente) as Nombre, d.numerodocumento as Documento_Docente
	FROM materia m
	inner join grupo g on (m.codigomateria = g.codigomateria)
	inner join docente d on (g.numerodocumento = d.numerodocumento)
	inner join tipomateria tm on (m.codigotipomateria = tm.codigotipomateria)
        left join (select dpe.codigomateria, dpe.semestredetalleplanestudio, dpe.idplanestudio, pe.nombreplanestudio
                    from detalleplanestudio dpe
                    inner join planestudio pe on dpe.idplanestudio = pe.idplanestudio and pe.codigoestadoplanestudio IN (100, 101)
                    where dpe.codigoestadodetalleplanestudio IN (100, 101)) as ple
                    on ple.codigomateria = m.codigomateria
	WHERE g.codigoperiodo = '$codigoperiodo'
	AND codigoestadogrupo = '10'
	AND m.codigoestadomateria = '01'
        GROUP by 1,2 ORDER BY m.nombremateria";
        $materia = $db->Execute($query_materia);
        $totalRows_materia = $materia->RecordCount();
        $row_materia = $materia->FetchRow();
    } else {
        $query_materia = " SELECT m.codigomateria, m.nombremateria, m.numerocreditos, tm.nombretipomateria, ple.semestredetalleplanestudio as semestre, ple.idplanestudio, ple.nombreplanestudio, g.idgrupo,g.nombregrupo ,maximogrupo,matriculadosgrupo,  matriculadosgrupoelectiva,(matriculadosgrupoelectiva + matriculadosgrupo) AS totalmatriculados,(maximogrupo - (matriculadosgrupoelectiva + matriculadosgrupo) ) AS cupo, maximogrupoelectiva,di.nombredia, h.horainicial, h.horafinal,m.codigocarrera, if(h.codigosalon = 1,'Sin Definir',h.codigosalon) as codigosalon, concat(d.nombredocente,' ', d.apellidodocente) as Nombre, d.numerodocumento as Documento_Docente
	FROM materia m
	inner join grupo g on (m.codigomateria = g.codigomateria)
	inner join horario h on (g.idgrupo = h.idgrupo)
	inner join dia di on (h.codigodia = di.codigodia)
	inner join docente d on (g.numerodocumento = d.numerodocumento)
	inner join tipomateria tm on (m.codigotipomateria = tm.codigotipomateria)
        left join (select dpe.codigomateria, dpe.semestredetalleplanestudio, dpe.idplanestudio, pe.nombreplanestudio
                    from detalleplanestudio dpe
                    inner join planestudio pe on dpe.idplanestudio = pe.idplanestudio and pe.codigoestadoplanestudio IN (100, 101)
                    where dpe.codigoestadodetalleplanestudio IN (100, 101)) as ple
                    on ple.codigomateria = m.codigomateria
	WHERE g.codigoperiodo = '$codigoperiodo'
	AND codigoestadogrupo = '10'
	AND m.codigoestadomateria = '01'
        ORDER BY m.nombremateria";
        $materia = $db->Execute($query_materia);
        $totalRows_materia = $materia->RecordCount();
        $row_materia = $materia->FetchRow();
    }
    do {
        $Array_interno[] = $row_materia;
    } while ($row_materia = $materia->FetchRow());
}
if ($_REQUEST['nacodigocarrera'] <> 0 and $_REQUEST['tipo'] == 0) {
    if ($_REQUEST['horario'] == 2) {
        $query_materia = "SELECT m.codigomateria, m.nombremateria, m.numerocreditos, tm.nombretipomateria, ple.semestredetalleplanestudio as semestre, ple.idplanestudio, ple.nombreplanestudio, SUM(maximogrupo - (matriculadosgrupoelectiva + matriculadosgrupo) ) AS cupo, concat(d.nombredocente,' ', d.apellidodocente) as Nombre, d.numerodocumento as Documento_Docente
	FROM materia m
	inner join grupo g on (m.codigomateria = g.codigomateria)
	inner join docente d on (g.numerodocumento = d.numerodocumento)
	inner join tipomateria tm on (m.codigotipomateria = tm.codigotipomateria)
        left join (select dpe.codigomateria, dpe.semestredetalleplanestudio, dpe.idplanestudio, pe.nombreplanestudio
                    from detalleplanestudio dpe
                    inner join planestudio pe on dpe.idplanestudio = pe.idplanestudio and pe.codigoestadoplanestudio IN (100, 101)
                    where dpe.codigoestadodetalleplanestudio IN (100, 101)) as ple
                    on ple.codigomateria = m.codigomateria
	WHERE g.codigoperiodo = '$codigoperiodo'
	AND m.codigocarrera = '" . $_REQUEST['nacodigocarrera'] . "'
	AND codigoestadogrupo = '10'
	AND m.codigoestadomateria = '01'
        GROUP by 1,2 ORDER BY m.nombremateria";
        $materia = $db->Execute($query_materia);
        $totalRows_materia = $materia->RecordCount();
        $row_materia = $materia->FetchRow();
    } else {
        $query_materia = " SELECT m.codigomateria, m.nombremateria, m.numerocreditos, tm.nombretipomateria, ple.semestredetalleplanestudio as semestre, ple.idplanestudio, ple.nombreplanestudio, g.idgrupo,g.nombregrupo ,maximogrupo,matriculadosgrupo,  matriculadosgrupoelectiva,(matriculadosgrupoelectiva + matriculadosgrupo) AS totalmatriculados,(maximogrupo - (matriculadosgrupoelectiva + matriculadosgrupo) ) AS cupo, maximogrupoelectiva,di.nombredia, h.horainicial, h.horafinal,m.codigocarrera, if(h.codigosalon = 1,'Sin Definir',h.codigosalon) as codigosalon, concat(d.nombredocente,' ', d.apellidodocente) as Nombre, d.numerodocumento as Documento_Docente
	FROM materia m
	inner join grupo g on (m.codigomateria = g.codigomateria)
	inner join horario h on (g.idgrupo = h.idgrupo)
	inner join dia di on (h.codigodia = di.codigodia)
	inner join docente d on (g.numerodocumento = d.numerodocumento)
	inner join tipomateria tm on (m.codigotipomateria = tm.codigotipomateria)
        left join (select dpe.codigomateria, dpe.semestredetalleplanestudio, dpe.idplanestudio, pe.nombreplanestudio
                    from detalleplanestudio dpe
                    inner join planestudio pe on dpe.idplanestudio = pe.idplanestudio and pe.codigoestadoplanestudio IN (100, 101)
                    where dpe.codigoestadodetalleplanestudio IN (100, 101)) as ple
                    on ple.codigomateria = m.codigomateria
	WHERE g.codigoperiodo = '$codigoperiodo'
	AND m.codigocarrera = '" . $_REQUEST['nacodigocarrera'] . "'
	AND codigoestadogrupo = '10'
	AND m.codigoestadomateria = '01'
        ORDER BY m.nombremateria";
        $materia = $db->Execute($query_materia);
        $totalRows_materia = $materia->RecordCount();
        $row_materia = $materia->FetchRow();
    }
    do {
        $Array_interno[] = $row_materia;
    } while ($row_materia = $materia->FetchRow());
}
if ($_REQUEST['nacodigocarrera'] <> 0 and $_REQUEST['tipo'] <> 0) {
    if ($_REQUEST['horario'] == 2) {
        $query_materia = "SELECT m.codigomateria, m.nombremateria, m.numerocreditos, tm.nombretipomateria, ple.semestredetalleplanestudio as semestre, ple.idplanestudio, ple.nombreplanestudio, SUM(maximogrupo - (matriculadosgrupoelectiva + matriculadosgrupo) ) AS cupo, concat(d.nombredocente,' ', d.apellidodocente) as Nombre, d.numerodocumento as Documento_Docente
	FROM materia m
	inner join grupo g on (m.codigomateria = g.codigomateria)
	inner join docente d on (g.numerodocumento = d.numerodocumento)
	inner join tipomateria tm on (m.codigotipomateria = tm.codigotipomateria)
        left join (select dpe.codigomateria, dpe.semestredetalleplanestudio, dpe.idplanestudio, pe.nombreplanestudio
                    from detalleplanestudio dpe
                    inner join planestudio pe on dpe.idplanestudio = pe.idplanestudio and pe.codigoestadoplanestudio IN (100, 101)
                    where dpe.codigoestadodetalleplanestudio IN (100, 101)) as ple
                    on ple.codigomateria = m.codigomateria
	WHERE g.codigoperiodo = '$codigoperiodo'
	AND m.codigocarrera = '" . $_REQUEST['nacodigocarrera'] . "'
	AND m.codigotipomateria = '" . $_REQUEST['tipo'] . "'
	AND codigoestadogrupo = '10'
	AND m.codigoestadomateria = '01'
	GROUP by 1,2 ORDER BY m.nombremateria";
        $materia = $db->Execute($query_materia);
        $totalRows_materia = $materia->RecordCount();
        $row_materia = $materia->FetchRow();
    } else {
        $query_materia = "SELECT m.codigomateria, m.nombremateria, m.numerocreditos, tm.nombretipomateria, ple.semestredetalleplanestudio as semestre, ple.idplanestudio, ple.nombreplanestudio, g.idgrupo,g.nombregrupo ,maximogrupo,matriculadosgrupo,  matriculadosgrupoelectiva,(matriculadosgrupoelectiva + matriculadosgrupo) AS totalmatriculados,(maximogrupo - (matriculadosgrupoelectiva + matriculadosgrupo) ) AS cupo, maximogrupoelectiva,di.nombredia, h.horainicial, h.horafinal,m.codigocarrera, if(h.codigosalon = 1,'Sin Definir',h.codigosalon) as codigosalon, concat(d.nombredocente,' ', d.apellidodocente) as Nombre, d.numerodocumento as Documento_Docente
	FROM materia m
	inner join grupo g on (m.codigomateria = g.codigomateria)
	inner join horario h on (g.idgrupo = h.idgrupo)
	inner join dia di on (h.codigodia = di.codigodia)
	inner join docente d on (g.numerodocumento = d.numerodocumento)
	inner join tipomateria tm on (m.codigotipomateria = tm.codigotipomateria)
        left join (select dpe.codigomateria, dpe.semestredetalleplanestudio, dpe.idplanestudio, pe.nombreplanestudio
                    from detalleplanestudio dpe
                    inner join planestudio pe on dpe.idplanestudio = pe.idplanestudio and pe.codigoestadoplanestudio IN (100, 101)
                    where dpe.codigoestadodetalleplanestudio IN (100, 101)) as ple
                    on ple.codigomateria = m.codigomateria
	WHERE g.codigoperiodo = '$codigoperiodo'
	AND m.codigocarrera = '" . $_REQUEST['nacodigocarrera'] . "'
	AND m.codigotipomateria = '" . $_REQUEST['tipo'] . "'
	AND codigoestadogrupo = '10'
	AND m.codigoestadomateria = '01'
        ORDER BY m.nombremateria";
        $materia = $db->Execute($query_materia);
        $totalRows_materia = $materia->RecordCount();
        $row_materia = $materia->FetchRow();
    }
    do {
        $Array_interno[] = $row_materia;
    } while ($row_materia = $materia->FetchRow());
}

if ($_REQUEST['nacodigocarrera'] == 0 and $_REQUEST['tipo'] <> 0) {
    if ($_REQUEST['horario'] == 2) {
        $query_materia = "SELECT m.codigomateria, m.nombremateria, m.numerocreditos, tm.nombretipomateria, ple.semestredetalleplanestudio as semestre, ple.idplanestudio, ple.nombreplanestudio, SUM(maximogrupo - (matriculadosgrupoelectiva + matriculadosgrupo) ) AS cupo, concat(d.nombredocente,' ', d.apellidodocente) as Nombre, d.numerodocumento as Documento_Docente
	FROM materia m
	inner join grupo g on (m.codigomateria = g.codigomateria)
	inner join docente d on (g.numerodocumento = d.numerodocumento)
	inner join tipomateria tm on (m.codigotipomateria = tm.codigotipomateria)
        left join (select dpe.codigomateria, dpe.semestredetalleplanestudio, dpe.idplanestudio, pe.nombreplanestudio
                    from detalleplanestudio dpe
                    inner join planestudio pe on dpe.idplanestudio = pe.idplanestudio and pe.codigoestadoplanestudio IN (100, 101)
                    where dpe.codigoestadodetalleplanestudio IN (100, 101)) as ple
                    on ple.codigomateria = m.codigomateria
	WHERE g.codigoperiodo = '$codigoperiodo'
	AND m.codigotipomateria = '" . $_REQUEST['tipo'] . "'
	AND codigoestadogrupo = '10'
	AND m.codigoestadomateria = '01'
        GROUP by 1,2 ORDER BY m.nombremateria";
        $materia = $db->Execute($query_materia);
        $totalRows_materia = $materia->RecordCount();
        $row_materia = $materia->FetchRow();
    } else {
        $query_materia = "SELECT m.codigomateria, m.nombremateria, m.numerocreditos, tm.nombretipomateria, ple.semestredetalleplanestudio as semestre, ple.idplanestudio, ple.nombreplanestudio, g.idgrupo,g.nombregrupo ,maximogrupo,matriculadosgrupo,  matriculadosgrupoelectiva,(matriculadosgrupoelectiva + matriculadosgrupo) AS totalmatriculados,(maximogrupo - (matriculadosgrupoelectiva + matriculadosgrupo) ) AS cupo, maximogrupoelectiva,di.nombredia, h.horainicial, h.horafinal,m.codigocarrera, if(h.codigosalon = 1,'Sin Definir',h.codigosalon) as codigosalon, concat(d.nombredocente,' ', d.apellidodocente) as Nombre, d.numerodocumento as Documento_Docente
	FROM materia m
	inner join grupo g on (m.codigomateria = g.codigomateria)
	inner join horario h on (g.idgrupo = h.idgrupo)
	inner join dia di on (h.codigodia = di.codigodia)
	inner join docente d on (g.numerodocumento = d.numerodocumento)
	inner join tipomateria tm on (m.codigotipomateria = tm.codigotipomateria)
        left join (select dpe.codigomateria, dpe.semestredetalleplanestudio, dpe.idplanestudio, pe.nombreplanestudio
                    from detalleplanestudio dpe
                    inner join planestudio pe on dpe.idplanestudio = pe.idplanestudio and pe.codigoestadoplanestudio IN (100, 101)
                    where dpe.codigoestadodetalleplanestudio IN (100, 101)) as ple
                    on ple.codigomateria = m.codigomateria
	WHERE g.codigoperiodo = '$codigoperiodo'
	AND m.codigotipomateria = '" . $_REQUEST['tipo'] . "'
	AND codigoestadogrupo = '10'
	AND m.codigoestadomateria = '01'
        ORDER BY m.nombremateria";
        $materia = $db->Execute($query_materia);
        $totalRows_materia = $materia->RecordCount();
        $row_materia = $materia->FetchRow();
    }
    do {
        $Array_interno[] = $row_materia;
    } while ($row_materia = $materia->FetchRow());
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <title>Documento sin t&iacute;tulo</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <link rel="stylesheet" type="text/css" href="../../../../sala.css">
    </head>
    <body>
        <p>LISTA DE MATERIAS CON CUPO Y HORARIOS</p>
        <?php
        $motor = new matriz($Array_interno, "LISTAMATERIA", "reporte_cupos_listado.php", "si", "si", "si", "reporte_cupos.php", "", "", "../../../../");
        $motor->botonRecargar = false;
        $motor->botonRegresar = false;
        $motor->mostrar();
        ?>
        <input type="button" value="Regresar" onClick="regreso()">
    </body>
</html>
<script language="javascript">
    function regreso()
    {
        window.location.reload('reporte_cupos.php');
    }
</script>