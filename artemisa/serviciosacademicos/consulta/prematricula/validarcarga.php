<?php
    session_start();
    include_once('../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
function mensajeCorrequisito($mensaje, $mostrar=true)
{
    if($mostrar)
    {
?>
<script language="JavaScript">
    alert('<?php echo $mensaje; ?>');
</script>
<?php
    }
}
function nombreMateria($codigomateria)
{
    global $sala;
    $query_materia = "select m.nombremateria
    from materia m
    where m.codigomateria = '$codigomateria'";
    $materia=mysql_query($query_materia, $sala) or die(mysql_error()."$query_materia");
    $totalRows_materia = mysql_num_rows($materia);
    if($totalRows_materia != "")
    {
        $row_materia = mysql_fetch_array($materia);
        return $row_materia['nombremateria'];
    }
    return false;
}

function esAprobada($codigomateria)
{
    global $sala, $codigoestudiante;
    $query_notahistorico = "select n.notadefinitiva, m.notaminimaaprobatoria
    from materia m, notahistorico n
    where m.codigomateria = '$codigomateria'
    and n.codigomateria = m.codigomateria
    and n.codigoestudiante = $codigoestudiante
    order by 1 desc";
    $notahistorico=mysql_query($query_notahistorico, $sala) or die(mysql_error()."$query_notahistorico");
    $totalRows_notahistorico = mysql_num_rows($notahistorico);
    if($totalRows_notahistorico != "")
    {
        //echo $query_notahistorico;
        $row_notahistorico = mysql_fetch_array($notahistorico);
        if($row_notahistorico['notadefinitiva'] < $row_notahistorico['notaminimaaprobatoria'])
            return false;
        else
            return true;
    }
    return false;
}

function faltaCorrequisitoDoble($codigomateria, $cargaescogida)
{
    global $sala, $idplanestudioini;

    // Selecciona las materias con las que tiene co-requisito doble y mira si está en la cargaescogida
    // Si todas las materias con co-requisito están en la carga pone verdadero si no pone falso

    $query_materiascorequisito = "select distinct r.codigomateria
    from referenciaplanestudio r, materia m
    where r.idplanestudio = '$idplanestudioini'
    and r.codigomateriareferenciaplanestudio = '$codigomateria'
    and r.codigotiporeferenciaplanestudio like '200'
    and r.codigoestadoreferenciaplanestudio = '101'";
    $materiascorequisito=mysql_query($query_materiascorequisito, $sala) or die("$query_materiascorequisito");
    $totalRows_materiascorequisito = mysql_num_rows($materiascorequisito);
    if($totalRows_materiascorequisito != "")
    {
        print_r($row_materiascorequisito);
        while($row_materiascorequisito = mysql_fetch_array($materiascorequisito))
        {
            if(!in_array($row_materiascorequisito['codigomateria'], $cargaescogida))
            {
                if(!esAprobada($row_materiascorequisito['codigomateria']))
                {
                    mensajeCorrequisito("La materia ".nombreMateria($row_materiascorequisito['codigomateria'])." debe seleccionarse ya que tiene seleccionado a ".nombreMateria($codigomateria)." que es un co-requisito doble");
                    return true;
                }
            }
        }
    }
    //echo $query_materiascorequisito;

    $query_materiascorequisito = "select distinct r.codigomateriareferenciaplanestudio
    from referenciaplanestudio r
    where r.idplanestudio = '$idplanestudioini'
    and r.codigomateria = '$codigomateria'
    and r.codigotiporeferenciaplanestudio like '200'
    and r.codigoestadoreferenciaplanestudio = '101'";
    $materiascorequisito=mysql_query($query_materiascorequisito, $sala) or die("$query_materiascorequisito");
    $totalRows_materiascorequisito = mysql_num_rows($materiascorequisito);
    if($totalRows_materiascorequisito != "")
    {
        print_r($row_materiascorequisito);
        while($row_materiascorequisito = mysql_fetch_array($materiascorequisito))
        {
            if(!in_array($row_materiascorequisito['codigomateriareferenciaplanestudio'], $cargaescogida))
            {
                if(!esAprobada($row_materiascorequisito['codigomateriareferenciaplanestudio']))
                {
                    mensajeCorrequisito("La materia ".nombreMateria($row_materiascorequisito['codigomateriareferenciaplanestudio'])." debe seleccionarse ya que tiene seleccionado a ".nombreMateria($codigomateria)." que es un co-requisito doble");
                    return true;
                }
            }
        }
    }
    //echo $query_materiascorequisito;
    return false;
}

function faltaCorrequisitoSencillo($codigomateria, $cargaescogida)
{
    global $sala, $idplanestudioini;

    // Selecciona las materias con las que tiene co-requisito doble y mira si está en la cargaescogida
    // Si todas las materias con co-requisito están en la carga pone verdadero si no pone falso

    $query_materiascorequisito = "select distinct r.codigomateria
    from referenciaplanestudio r
    where r.idplanestudio = '$idplanestudioini'
    and r.codigomateriareferenciaplanestudio = '$codigomateria'
    and r.codigotiporeferenciaplanestudio like '201'
    and r.codigoestadoreferenciaplanestudio = '101'";
    $materiascorequisito=mysql_query($query_materiascorequisito, $sala) or die("$query_materiascorequisito");
    $totalRows_materiascorequisito = mysql_num_rows($materiascorequisito);
    if($totalRows_materiascorequisito != "")
    {
        print_r($row_materiascorequisito);
        while($row_materiascorequisito = mysql_fetch_array($materiascorequisito))
        {
            if(!in_array($row_materiascorequisito['codigomateria'], $cargaescogida))
            {
                //echo "ACA ".esAprobada($row_materiascorequisito['codigomateria']);
                if(!esAprobada($row_materiascorequisito['codigomateria']))
                {
                    mensajeCorrequisito("La materia ".nombreMateria($row_materiascorequisito['codigomateria'])." debe seleccionarse ya que tiene seleccionado a ".nombreMateria($codigomateria)." que es un co-requisito sencillo");
                    return true;
                }
            }
        }
    }
    //echo $query_materiascorequisito;
    return false;
}
?>
