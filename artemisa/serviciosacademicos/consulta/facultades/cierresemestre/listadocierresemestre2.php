<?php
require('../../../Connections/sala2.php');
$rutaado = "../../../funciones/adodb/";
$rutazado = "../../../funciones/zadodb/";
require_once('../../../Connections/salaado.php');
include($rutazado.'zadodb-pager.inc.php');

session_start();
if(isset($_SESSION['debug_sesion']))
{
    $db->debug = true;
}

function seleccionarequivalencias1($codigomateria,$idplanestudio)
{
    global $db;
    $query_selequivalencias = "select r.codigomateria, r.fechainicioreferenciaplanestudio, r.fechavencimientoreferenciaplanestudio
    from referenciaplanestudio r
    where r.idplanestudio = '$idplanestudio'
    and r.codigomateriareferenciaplanestudio = '$codigomateria'
    and r.codigotiporeferenciaplanestudio like '3%'";
    //echo "$query_selequivalencias<br>";//and r.idlineaenfasisplanestudio = '$idlineaenfasis'
    $selequivalencias = $db->Execute($query_selequivalencias);
    $totalRows_selequivalencias = $selequivalencias->RecordCount();
    $row_selequivalencias = $selequivalencias->FetchRow();

    if($totalRows_selequivalencias != "")
    {
        //echo $row_selequivalencias['codigomateria'],"hola<br>";
        $codigomateriaequivalentes = $row_selequivalencias['codigomateria'];
        //echo $codigomateriaequivalente;
        return $codigomateriaequivalentes;
    }
    else
    {
        ///echo "hola3<br>";

        $query_selequivalencias = "select r.codigomateria, r.fechainicioreferenciaplanestudio, r.fechavencimientoreferenciaplanestudio
        from referenciaplanestudio r
        where r.idplanestudio = '$idplanestudio'
        and r.codigomateria = '$codigomateria'
        and r.codigotiporeferenciaplanestudio = '300'";
        //echo "$query_selequivalencias<br>";
        $selequivalencias = $db->Execute($query_selequivalencias);
        $totalRows_selequivalencias = $selequivalencias->RecordCount();
        $row_selequivalencias = $selequivalencias->FetchRow();

        return $row_selequivalencias['codigomateria'];
    }
}

function seleccionarequivalencias($codigomateria, $idplanestudio)
{
    global $db;
    //echo "$codigomateria<br>";
    // La correspondencia siempre va a ser uno a uno
    $query_selequivalencias = "select r.codigomateriareferenciaplanestudio, r.fechainicioreferenciaplanestudio, r.fechavencimientoreferenciaplanestudio
    from referenciaplanestudio r
    where r.idplanestudio = '$idplanestudio'
    and r.codigomateria = '$codigomateria'
    and r.codigotiporeferenciaplanestudio like '3%'";
    //echo "$query_selequivalencias<br>";
    $selequivalencias = $db->Execute($query_selequivalencias);
    $totalRows_selequivalencias = $selequivalencias->RecordCount();
    if($totalRows_selequivalencias != "")
    {
        while($row_selequivalencias = $selequivalencias->FetchRow())
        {
            $codigomateriaequivalente = $row_selequivalencias['codigomateriareferenciaplanestudio'];
            //echo "$codigomateriaequivalente<br>";
            $Arregloequivalencias[] = $codigomateriaequivalente;
        }
        return $Arregloequivalencias;
    }
    else
    {
        return;
    }
}
//$db->debug = true;
//print_r($_SERVER);

// Primero selecciona los estudiantes de la carrera que tienen prematricula paga para 20092
$codigoperiodo = '20092';
$query_estudiantes = "select e.codigoestudiante, e.codigosituacioncarreraestudiante, eg.numerodocumento, c.nombrecarrera, concat(eg.nombresestudiantegeneral,' ',eg.apellidosestudiantegeneral) as nombre, s.nombresituacioncarreraestudiante
from prematricula p, estudiante e, estudiantegeneral eg, carrera c, situacioncarreraestudiante s
where p.codigoestadoprematricula like '4%'
and p.codigoperiodo = '$codigoperiodo'
and e.codigoestudiante = p.codigoestudiante
and eg.idestudiantegeneral = e.idestudiantegeneral
and e.codigocarrera in (118)
and e.codigocarrera = c.codigocarrera
and s.codigosituacioncarreraestudiante = e.codigosituacioncarreraestudiante
order by c.nombrecarrera, eg.numerodocumento";
$estudiantes = $db->Execute($query_estudiantes);
$totalRows_estudiantes = $estudiantes->RecordCount();
?>
<table border="1" cellspacing="0">
    <TR>
        <TD><strong>Carrera</strong></TD><td><strong>Documento</strong></td><td><strong>Nombre</strong></td><td><strong>Estado actual</strong></td>
    </TR>
<?php
// Segundo para cada estudiante verifica el estado en que debe quedar
while($row_estudiantes = $estudiantes->FetchRow())
{
    $materiaperdida = '';
// Tercero selecciona las materias que está viendo el estudiante
    $codigoestudiante = $row_estudiantes['codigoestudiante'];
    $query_materias = "SELECT m.nombremateria,m.codigomateria,m.numerocreditos,g.idgrupo,p.codigoestudiante,pe.idplanestudio
    FROM prematricula p,detalleprematricula d,materia m,grupo g,planestudioestudiante pe
    WHERE  p.codigoestudiante = '$codigoestudiante'
    and p.codigoestudiante = pe.codigoestudiante
    AND p.idprematricula = d.idprematricula
    AND d.codigomateria = m.codigomateria
    AND d.idgrupo = g.idgrupo
    AND m.codigoestadomateria = '01'
    AND g.codigoperiodo = '$codigoperiodo'
    AND p.codigoestadoprematricula LIKE '4%'
    AND d.codigoestadodetalleprematricula LIKE '3%'";
    $materias = $db->Execute($query_materias);
    $totalRows_materias = $materias->RecordCount();
    $creditossemestre = 0;
    $pierdeotravez = false;

// Cuato mira si pierde la asignatura por más de una vez
    while($row_materias = $materias->FetchRow())
    {
        $creditossemestre = $creditossemestre + $row_materias['numerocreditos'];
/////////////////////////////////////////////////////////////
        $equivalencia = seleccionarequivalencias1($row_materias['codigomateria'],$row_materias['idplanestudio']);
       //echo $equivalencia,"<br>";
        $Arregloequivalencias = seleccionarequivalencias($equivalencia,$row_materias['idplanestudio']);
        if ($equivalencia == "")
        {
            //echo $solicitud_creditos['codigomateria'],"<br><br><br>";
            $Arregloequivalencias[] = $row_materias['codigomateria'];
        }
        $Arregloequivalencias[] = $equivalencia;
        $cuentamateriaperdida = 0;

        //print_r($Arregloequivalencias);
        $materiain = '';
        foreach($Arregloequivalencias as $codigomateria)
        {
            $query_historico = "SELECT n.notadefinitiva,m.notaminimaaprobatoria
            FROM notahistorico n,materia m
            WHERE n.codigoestudiante = '".$codigoestudiante."'
            and n.codigomateria = '$codigomateria'
            and n.codigomateria = m.codigomateria
            and n.codigoestadonotahistorico like '1%'";
            //echo $query_historico,"qq<br><br><br>";
            $res_historico = $db->Execute($query_historico);
            $totalRows_historico = $res_historico->RecordCount();

            if ($totalRows_historico <> 0)
            {
                while($solicitud_historico = $res_historico->FetchRow())
                {
                    if ($solicitud_historico['notadefinitiva'] < $solicitud_historico['notaminimaaprobatoria'])
                    {
                        $cuentamateriaperdida++;
                    }
                    elseif ($solicitud_historico['notadefinitiva'] >= $solicitud_historico['notaminimaaprobatoria'])
                    {
                        $cuentamateriaperdida = 0;
                        $indicadormateriasperdidas = 0;
                    }
                }
                if ($cuentamateriaperdida > 1)
                {
                    //echo "<h1>Pierde la materia $codigomateria m&aacute;s de una vez</h1>";
                    $materiaperdida .= $codigomateria;
                    $pierdeotravez = true;
                }
            }
        }
    }
    if($pierdeotravez && $row_estudiantes['codigosituacioncarreraestudiante'] != 100)
    {
        // Valida si al estudiante se le cambio la situación en el periodo 20092
        /*$query_historicosituacionhoy = "select *
        from historicosituacionestudiante
        where codigoestudiante = '".$codigoestudiante."'
        and codigoperiodo = '20091'
        order by 1 desc";
        $historicosituacionhoy = $db->Execute($query_historicosituacionhoy);
        $totalRows_historicosituacionhoy = $historicosituacionhoy->RecordCount();
        //$row_historicosituacionhoy = $historicosituacionhoy->FetchRow();
        if($totalRows_historicosituacionhoy == 0)*/
        {
            // Toca cambiarlo de situación a pérdida
?>
<TR>
        <TD><?php echo $row_estudiantes['nombrecarrera']; ?></td>
        <TD><?php echo $row_estudiantes['numerodocumento']; ?></td>
        <TD><?php echo $row_estudiantes['nombre']; ?></td>
        <TD><?php echo $row_estudiantes['nombresituacioncarreraestudiante']; ?></td>
    </TR>
<!--<h1><?php echo $row_estudiantes['nombrecarrera']." -- ".$row_estudiantes['numerodocumento']; ?> </h1>
<h1><?php echo $row_estudiantes['numerodocumento']; ?> Perdio más de una vez la materia <a href="zcambiarsituacion.php?codigoestudiante=<?php echo $codigoestudiante; ?>"><?php echo $row_estudiantes['numerodocumento']." -- $materiaperdida"; ?></a></h1>-->
<?php
        }
    }
    elseif($pierdeotravez)
    {
        continue;
    ?>
<h1>Qued&oacute; en perdida</h1>
<?php
    }
}

?>
</table>
