<?php
require('../../../Connections/sala2.php');
$rutaado = "../../../funciones/adodb/";
$rutazado = "../../../funciones/zadodb/";
require_once('../../../Connections/salaado.php');
include($rutazado.'zadodb-pager.inc.php');
require ('../../../funciones/notas/redondeo.php');

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
$periodoactual = $codigoperiodo;
$query_estudiantes = "select e.codigoestudiante, e.codigosituacioncarreraestudiante, eg.numerodocumento, c.nombrecarrera, concat(eg.nombresestudiantegeneral,' ',eg.apellidosestudiantegeneral) as nombre, s.nombresituacioncarreraestudiante
from prematricula p, estudiante e, estudiantegeneral eg, carrera c, situacioncarreraestudiante s
where p.codigoestadoprematricula like '4%'
and p.codigoperiodo = '$codigoperiodo'
and e.codigoestudiante = p.codigoestudiante
and eg.idestudiantegeneral = e.idestudiantegeneral
        and e.codigocarrera in (SELECT codigocarrera FROM procesoperiodo p
        where codigoperiodo = 20092
        and fecharealizoprocesoperiodo <> '0000-00-00')
and e.codigocarrera = c.codigocarrera
and s.codigosituacioncarreraestudiante = e.codigosituacioncarreraestudiante
and e.codigosituacioncarreraestudiante = '100'
order by c.nombrecarrera, eg.numerodocumento";
$estudiantes = $db->Execute($query_estudiantes);
$totalRows_estudiantes = $estudiantes->RecordCount();
?>
<table border="1" cellspacing="0">
    <TR>
        <TD><strong>Carrera</strong></TD><td><strong>Documento</strong></td><td><strong>Nombre</strong></td><td><strong>Estado actual</strong></td><td><strong>Promedio acumulado</strong></td><td><strong>Estado Final</strong></td><td>Creditos perdidos >= Mitad créditos</td>
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
        $Arregloequivalencias = array_unique($Arregloequivalencias);
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

//echo $creditossemestre."<br>";
/*************************************/
    $query_materia = "SELECT *
    FROM notahistorico n,materia m
    WHERE n.codigoestudiante = '".$codigoestudiante."'
    and n.codigomateria = m.codigomateria
    AND n.codigoperiodo = '$periodoactual'
    AND n.codigotiponotahistorico like '10%'
    and n.codigoestadonotahistorico like '1%'";
    //echo $query_materia,"</br>";
    //exit();
    $res_materia = mysql_query($query_materia, $sala) or die(mysql_error());
    $solicitud_materia = mysql_fetch_assoc($res_materia);
    $creditosperdidos = 0;
    $notatotal = 0;
    $creditos  = 0;
    $promediosemestralperiodo = 0;
    do {
        //echo "CredPerdidos: $creditosperdidos -- ". $solicitud_materia['notadefinitiva'],"&nbsp;&nbsp;",$solicitud_materia['notaminimaaprobatoria'],"<br>";
            $notatotal = $notatotal + ($solicitud_materia['notadefinitiva'] * $solicitud_materia['numerocreditos']) ;
            $creditos = $creditos + $solicitud_materia['numerocreditos'];

            if ($solicitud_materia['notadefinitiva'] < $solicitud_materia['notaminimaaprobatoria'])
            {
                $creditosperdidos = $creditosperdidos +  $solicitud_materia['numerocreditos'];
            }
    }while($solicitud_materia = mysql_fetch_assoc($res_materia));

    //$promediosemestralperiodo = (number_format($notatotal/$creditos,1));
    //@$promediototal = number_format($notatotal/$creditos,1);
    //$promediosemestralperiodo=round($promediototal * 10)/10;
    @$promediototal = $notatotal/$creditos;
    $promediosemestralperiodo = redondeo($promediototal);
    //echo $promediosemestralperiodo,"->>>>>>>>>>>>";
    unset($Arregloequivalencias);
    $carreraestudiante = $_SESSION['codigofacultad'];

    ///require('calculopromedioacumulado.php');
    $promedioacumulado = AcumuladoReglamento ($codigoestudiante,$_GET['tipocertificado']="",$sala);
    $calculoperdida = $creditossemestre / 2;
    //echo $indicadormateriasperdidas ;
    //echo $codigoestudiante,"&nbsp;",$creditosperdidos,">=&nbsp;",$calculoperdida,"&nbsp;",$indicadormateriasperdidas,"&nbsp;",$promedioacumulado,"&nbsp;"/*,$numero*/,"<br>";
    $cambiosituacion = 100;
    $query_historicosituacion = "select *
            from historicosituacionestudiante
            where codigoestudiante = '".$codigoestudiante."'
            order by 1 desc
            ";
    $historicosituacion = mysql_query($query_historicosituacion, $sala) or die("$query_historicosituacion".mysql_error());
    $row_historicosituacion = mysql_fetch_assoc($historicosituacion);
    $totalRows_historicosituacion = mysql_num_rows($historicosituacion);

    if (($creditosperdidos >= $calculoperdida) or ($pierdeotravez) or ($promedioacumulado < 3.3 and $row_historicosituacion['codigosituacioncarreraestudiante'] == 200) )//
    {
        continue;
        // Debe Quedar en perdida
       {
            // Toca cambiarlo de situación a pérdida
                    ?>
                    <TR>
                    <TD><?php echo $row_estudiantes['nombrecarrera']; ?></td>
                    <TD><?php echo $row_estudiantes['numerodocumento']; ?></td>
                    <TD><?php echo $row_estudiantes['nombre']; ?></td>
                    <TD><?php echo $row_estudiantes['nombresituacioncarreraestudiante']; ?></td>
                    <td><?php echo $promedioacumulado;?></td>
                    <td><?php echo "$creditosperdidos _ $calculoperdida";?></td>
                    <td>DEJARLO EN PERDIDA</td>
                                            </TR>
                                                    <!--<h1><?php echo $row_estudiantes['nombrecarrera']." -- ".$row_estudiantes['numerodocumento']; ?> </h1>
                                                    <h1><?php echo $row_estudiantes['numerodocumento']; ?> Perdio más de una vez la materia <a href="zcambiarsituacion.php?codigoestudiante=<?php echo $codigoestudiante; ?>"><?php echo $row_estudiantes['numerodocumento']." -- $materiaperdida"; ?></a></h1>-->
                                                                <?php
        }
        unset($Arregloequivalencias);
        continue;
    }
    elseif ($promediosemestralperiodo < 3.3 or $promedioacumulado < 3.3) {
               // Debe pasarlo a prueba
                       /*$base1= "update estudiante set
                       codigosituacioncarreraestudiante ='200'
                       where  codigoestudiante = '".$codigoestudiante."'";*/
               $sol1=mysql_db_query($database_sala,$base1);
                       ?>
                       <TR>
                       <TD><?php echo $row_estudiantes['nombrecarrera']; ?></td>
                       <TD><?php echo $row_estudiantes['numerodocumento']; ?></td>
                               <TD><?php echo $row_estudiantes['nombre']; ?></td>
                                       <TD><?php echo $row_estudiantes['nombresituacioncarreraestudiante']; ?></td>
                                               <td><?php echo $promedioacumulado;?></td>
                                                       <td><?php echo "$creditosperdidos - $calculoperdida";?></td>
                                                       <td>PASAR A PRUEBA</td>
                                                               </TR>
                                                               <!--<h1><?php echo $row_estudiantes['nombrecarrera']." -- ".$row_estudiantes['numerodocumento']; ?> </h1>
                                                               <h1><?php echo $row_estudiantes['numerodocumento']; ?> Perdio más de una vez la materia <a href="zcambiarsituacion.php?codigoestudiante=<?php echo $codigoestudiante; ?>"><?php echo $row_estudiantes['numerodocumento']." -- $materiaperdida"; ?></a></h1>-->
                                                                           <?php
                                                                                unset($Arregloequivalencias);
                                                                           continue;
                                                                           ?>
                                                                                <h1>Qued&oacute; en perdida</h1>
                                                                                <?php
    }
    else if($row_estudiantes['codigosituacioncarreraestudiante'] == 100){
        // Toca cambiarlo de situación a normal
                /*$base1= "update estudiante set
                codigosituacioncarreraestudiante ='301'
                where  codigoestudiante = '".$codigoestudiante."'";*/
        $sol1=mysql_db_query($database_sala,$base1);
                    ?>
                    <TR>
                    <TD><?php echo $row_estudiantes['nombrecarrera']; ?></td>
                    <TD><?php echo $row_estudiantes['numerodocumento']; ?></td>
                            <TD><?php echo $row_estudiantes['nombre']; ?></td>
                                    <TD><?php echo $row_estudiantes['nombresituacioncarreraestudiante']; ?></td>
                                            <td><?php echo $promedioacumulado;?></td>
                                                    <td><?php echo "$creditosperdidos - $calculoperdida";?></td>
                                                    <td>PASAR A NORMAL</td>
                                            </TR>
                                                    <!--<h1><?php echo $row_estudiantes['nombrecarrera']." -- ".$row_estudiantes['numerodocumento']; ?> </h1>
                                                    <h1><?php echo $row_estudiantes['numerodocumento']; ?> Perdio más de una vez la materia <a href="zcambiarsituacion.php?codigoestudiante=<?php echo $codigoestudiante; ?>"><?php echo $row_estudiantes['numerodocumento']." -- $materiaperdida"; ?></a></h1>-->
                                                                <?php
                                                                        unset($Arregloequivalencias);
                                                                continue;
        }
}

?>
</table>
