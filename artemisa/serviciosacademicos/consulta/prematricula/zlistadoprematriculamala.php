<?php
    session_start();
    include_once('../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
set_time_limit(100000000000000);
require_once('../../Connections/sala2.php' );
mysql_select_db('sala',$sala);
$cargaValidar = $cargaescogida;
require_once("zvalidarcarga.php");

$query_estudiante = "select e.semestre, e.codigoestudiante, p.idprematricula, p.codigoestadoprematricula
from prematricula p, estudiante e
where p.codigoestudiante = e.codigoestudiante
and p.codigoperiodo = '20092'
and e.codigocarrera = 8
and (p.codigoestadoprematricula like '1%' or p.codigoestadoprematricula like '4%')
order by e.semestre";
//and p.codigoestudiante = 29873
$estudiante=mysql_query($query_estudiante, $sala) or die(mysql_error()."$query_estudiante");
$totalRows_estudiante = mysql_num_rows($estudiante);
if($totalRows_estudiante != "")
{
?>
<table cellpadding="1" border="1" cellspacing="0">
    <TR>
        <TD colspan="5" align="center"><strong>LISTADO DE ESTUDIANTES QUE TIENEN MATERIAS MATRICULADAS CON COREQUISITO DOBLE Y SENCILLO SELECCIONADO</strong></TD>
    </TR>
    <tr>
        <TD><strong>SEMESTRE</strong></TD>
        <TD><strong>DOCUMENTO ESTUDIANTE</strong></TD>
        <TD><strong>MATERIA SELECCIONADA (Falta co requisito doble)</strong></TD>
        <TD><strong>MATERIA SELECCIONADA (Falta co requisito sencillo)</strong></TD>
        <TD><strong>ESTADO MATRICULA</strong></TD>
    </tr>
<?php
    while($row_estudiante = mysql_fetch_array($estudiante))
    {
        unset($cargaescogida);
        $idprematricula = $row_estudiante['idprematricula'];
        $codigoestudiante = $row_estudiante['codigoestudiante'];
        $semestre = $row_estudiante['semestre'];
        $codigoestadoprematricula = $row_estudiante['codigoestadoprematricula'];

        $query_prematricula = "select dp.codigomateria
        from detalleprematricula dp
        where dp.idprematricula = '$idprematricula'
        and (dp.codigoestadodetalleprematricula like '1%' or dp.codigoestadodetalleprematricula like '3%')";
        //and p.codigoestudiante = 29873
        $prematricula=mysql_query($query_prematricula, $sala) or die(mysql_error()."$query_prematricula");
        $totalRows_prematricula = mysql_num_rows($prematricula);
        if($totalRows_prematricula != "")
        {
            while($row_prematricula = mysql_fetch_array($prematricula))
            {
                $cargaescogida[] = $row_prematricula['codigomateria'];
            }
            $query_data = "select pe.idplanestudio, eg.numerodocumento, e.codigoestudiante
            from estudiante e, planestudioestudiante pe, estudiantegeneral eg
            where pe.codigoestudiante = e.codigoestudiante
            and pe.codigoestadoplanestudioestudiante like '1%'
            and eg.idestudiantegeneral = e.idestudiantegeneral
            and e.codigoestudiante = $codigoestudiante";
            //and p.codigoestudiante = 29873
            $data=mysql_query($query_data, $sala) or die(mysql_error()."$query_data");
            $totalRows_data = mysql_num_rows($data);
            $row_data = mysql_fetch_array($data);
            $idplanestudioini=$row_data['idplanestudio'];
            $numerodocumento=$row_data['numerodocumento'];

            foreach($cargaescogida as $codigomateriaEscogida)
            {
                $mensaje1 = '';
                $mensaje2 = '';
                if(faltaCorrequisitoDoble($codigomateriaEscogida, $cargaescogida))
                {
                    $mensaje1 .= $mensaje1."Falta co requisito doble para la materia ".nombreMateria($codigomateriaEscogida);
                }
                if(faltaCorrequisitoSencillo($codigomateriaEscogida, $cargaescogida))
                {
                    $mensaje2 .= $mensaje2."Falta co requisito sencillo para la materia ".nombreMateria($codigomateriaEscogida);
                }
                if($mensaje1 != '' or $mensaje2 != '')
                {
?>
    <tr>
        <td><?php echo $semestre; ?></td>
        <td><?php echo $numerodocumento; ?></td>
        <td><?php echo $mensaje1; ?>&nbsp;</td>
        <td><?php echo $mensaje2; ?>&nbsp;</td>
        <td>
            <?php
                    if(ereg('^4',$codigoestadoprematricula))
                    {
                        echo "MATRICULA PAGA";
                    }
                    elseif(ereg('^1',$codigoestadoprematricula))
                    {
                        echo "MATRICULA SIN PAGAR";
                    }
            ?>

</td>
    </tr>
<?php
                }
            }
        }
    }
?>
</table>
<?php

}
?>