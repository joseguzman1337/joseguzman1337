<?php
session_start();
$fechahoy=date("Y-m-d H:i:s");
require_once('../../../Connections/sala2.php');
$rutaado = "../../../funciones/adodb/";
require_once('../../../Connections/salaado.php');

$codigocarrera = $_REQUEST['codigocarrera'];
$codigoperiodo = $_REQUEST['codigoperiodo'];
$idplanestudio = $_REQUEST['idplanestudio'];

if(isset($_REQUEST['exportar'])) {
    $formato = 'xls';
    $nombrearchivo = "Perdida_Semestre";
    $strType = 'application/msexcel';
    $strName = $nombrearchivo.".xls";

    header("Content-Type: $strType");
    header("Content-Disposition: attachment; filename=$strName\r\n\r\n");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    //header("Cache-Control: no-store, no-cache");
    header("Pragma: public");
    
}

$query_nomcarrera="select nombrecarrera from carrera where codigocarrera='$codigocarrera'";
$nomcarrera= $db->Execute($query_nomcarrera);
$totalRows_nomcarrera= $nomcarrera->RecordCount();
$row_nomcarrera= $nomcarrera->FetchRow();

$query_periodo = "SELECT codigoperiodo, nombreperiodo from periodo where codigoperiodo='$codigoperiodo'";
        $periodo = $db->Execute($query_periodo);
        $totalRows_periodo = $periodo->RecordCount();
        $row_periodo= $periodo->FetchRow();

$query_totalest = "select count(distinct e.codigoestudiante) as total_estudiantes,pr.semestreprematricula*1 as semestre
                    FROM estudianteestadistica ee
                      join estudiante e on e.codigoestudiante=ee.codigoestudiante
                      join carrera c on c.codigocarrera=e.codigocarrera
                      join prematricula pr on e.codigoestudiante=pr.codigoestudiante
                    where ee.codigoperiodo = '$codigoperiodo'
                      and ee.codigoprocesovidaestudiante in (400,401)
                      and ee.codigoestado like '1%'
                      and c.codigocarrera ='$codigocarrera'
                      and pr.codigoperiodo='$codigoperiodo'
                    group by pr.semestreprematricula*1";
                    $totalest= $db->Execute($query_totalest);
                    $totalRows_totalest= $totalest->RecordCount();
                    $row_totalest= $totalest->FetchRow();
?>

<html>
    <head>
        <link rel="stylesheet" href="../../../estilos/sala.css" type="text/css">
    </head>
    <body>
        <form action=""  name="form1" method="POST">
            
            <br><br>
            <table  border="1" width="50%" cellpadding="3" cellspacing="3" align="center">
                <TR>
                    <TD  align="center" colspan="6" id="tdtitulogris">
                        <label id="labelresaltadogrande" >PORCENTAJE DE PÉRDIDA POR SEMESTRE <br><?php echo $row_nomcarrera['nombrecarrera'] ?> </label>
                    </TD>
                </TR>
                <tr><TD id="tdtitulogris" align="center" colspan="6">
                         <label id="labelresaltadogrande" ><?php echo strtoupper($row_periodo['nombreperiodo']); ?></label>
                     </TD>
                </tr>
                <tr>
                    <td align="center"  bgcolor="#C5D5D6"><b>SEMESTRE</b></td>
                    <td align="center"  bgcolor="#C5D5D6"><b>T.ESTUDIANTES</b></td>
                    <td align="center"  bgcolor="#C5D5D6"><b>T.PERDIERON</b></td>
                    <td align="center"  bgcolor="#C5D5D6"><b>% PERDIDA</b></td>
                    <td align="center"  bgcolor="#C5D5D6"><b>ESTRATEGIA</b></td>
                    <td align="center"  bgcolor="#C5D5D6"><b>OBSERVACION</b></td>
                </tr>
                    
                <?php                   
                    $total_estudiantes=0;
                    $total_est_perdida=0;
                    do{ 
                    
                        $query_perdidos="select distinct e.codigoestudiante as total_perdida,
                        (SELECT sum(n.notadefinitiva)/ count(*) FROM notahistorico n where n.codigoestudiante=e.codigoestudiante
                        and n.codigoperiodo='$codigoperiodo') as nota_promedio
                        FROM estudianteestadistica ee
                          join estudiante e on e.codigoestudiante=ee.codigoestudiante
                          join carrera c on c.codigocarrera=e.codigocarrera  
                          join prematricula pr on e.codigoestudiante=pr.codigoestudiante
                        where ee.codigoperiodo = '$codigoperiodo'
                          and ee.codigoprocesovidaestudiante in (400,401)
                          and ee.codigoestado like '1%'
                          and c.codigocarrera ='$codigocarrera'
                        and pr.semestreprematricula = '".$row_totalest['semestre']."'
                          and pr.codigoperiodo='$codigoperiodo'
                        having nota_promedio < 3.0";
                        $perdidos= $db->Execute($query_perdidos);
                        $totalRows_perdidos= $perdidos->RecordCount();

                        $query_estobs="SELECT * FROM estrategiaperiodo
                        where codigocarrera='$codigocarrera'
                        and codigoperiodo='$codigoperiodo'
                        and semestre='".$row_totalest['semestre']."'
                        and codigoestado like '1%'";
                        $estobs= $db->Execute($query_estobs);
                        $totalRows_estobs= $estobs->RecordCount();
                        $row_estobs= $estobs->FetchRow();

                        $total_estudiantes=$total_estudiantes+$row_totalest['total_estudiantes'];
                        $total_est_perdida=$total_est_perdida+$totalRows_perdidos;
                        $porcentajeperdida=round($totalRows_perdidos/$row_totalest['total_estudiantes']*100);
                        ?>

                    <tr>
                        <td ><?php echo $row_totalest['semestre']; ?></td>
                        <td ><?php echo $row_totalest['total_estudiantes']; ?></td>
                        <td ><?php echo $totalRows_perdidos; ?></td>

                        <td bgcolor="<?php if($porcentajeperdida >65){ ?>#FC1251<?php }
                                   else if($porcentajeperdida >40 && $porcentajeperdida <=65){ ?>#FFFD5F<?php }
                                   else if($porcentajeperdida <=40){ ?>#00D100<?php }?>">
                        <?php echo $porcentajeperdida."%"; ?></td>

                        <?php if($totalRows_estobs!=""){ ?>
                        <td ><?php echo $row_estobs['estrategiaperiodo']; ?></td>
                        <td ><?php echo $row_estobs['observacionestrategiaperiodo']; ?></td>
                        <?php
                        }
                        else{
                        ?>
                        <td >&nbsp;</td>
                        <td >&nbsp;</td>
                        <?php
                        }
                        ?>
                    </tr>
                            
                            
                    <?php
                            }while($row_totalest= $totalest->FetchRow());

                            $porcentajefinal=round($total_est_perdida/$total_estudiantes*100);
                    ?>                                 
                     <tr>
                         <td  bgcolor="#C5D5D6"><b>Totales</b></td>
                        <td id="tdtitulogris"><?php echo $total_estudiantes; ?></td>
                        <td id="tdtitulogris"><?php echo $total_est_perdida; ?></td>
                        <td  bgcolor="<?php if($porcentajefinal >65){ ?>#FC1251<?php }
                                   else if($porcentajefinal >40 && $porcentajefinal <=65){ ?>#FFFD5F<?php }
                                   else if($porcentajefinal <=40){ ?>#00D100<?php }?>">
                            <p><?php echo $porcentajefinal."%"; ?></p></td>
                        <td bgcolor="#C5D5D6" colspan="2">&nbsp;</td>
                        
                    </tr>
                    <?php
                    if(!isset($_REQUEST['exportar'])){
                    ?>
                    <TR>
                        <TD colspan="6" bgcolor="#C5D5D6" align="center">
                            <?php
                            if(!isset($_REQUEST['mpcarrera']))
                            {
                            ?>
                            <INPUT type="button" name="Regresar" value="Regresar" onclick="window.location.href='menuperdidasemestre.php'">
                            <?php
                            }
                            else {
                            ?>
                            <INPUT type="button" name="Regresar" value="Regresar" onclick="window.location.href='menuperdidasemestrecarrera.php'">
                            <?php
                            }
                            ?>
                            <INPUT type="submit" name="exportar" value="Exportar"></TD>
                    </TR>
                    <tr>
                        <td colspan="6" id="tdtitulogris">
                            Este informe únicamente refleja en la columna "T.PERDIERON" de
                            los estudiantes que perdieron el 50% o más de los créditos del período consultado.
                            Sin embargo no  debe desviarse la intención del seguimiento y análisis específico de cada uno de los estudiantes.

                        </td>
                    </tr>
                    <?php
                    }
                    ?>
            </table>


            <br>
            <?php
            //    require_once('listadoasignaturasenfasis.php');
            ?>

        </form>
    </body>
</html>
