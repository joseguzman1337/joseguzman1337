<?php
require_once('../../../Connections/sala2.php');
require('../../../funciones/notas/funcionequivalenciapromedio.php');
session_start();
//$carrera = 300;
//echo $database_sala;
mysql_select_db($database_sala, $sala);
unset($Arregloequivalencias);
mysql_select_db($database_sala, $sala);
$codigoestudiante=49648;
$periodoactual = 20092;
$query_creditos = " SELECT m.nombremateria,m.codigomateria,m.numerocreditos,g.idgrupo,p.codigoestudiante,pe.idplanestudio
        FROM prematricula p,detalleprematricula d,materia m,grupo g,planestudioestudiante pe
        WHERE  p.codigoestudiante = '$codigoestudiante'
        and p.codigoestudiante = pe.codigoestudiante
        AND p.idprematricula = d.idprematricula
        AND d.codigomateria = m.codigomateria
        AND d.idgrupo = g.idgrupo
        AND m.codigoestadomateria = '01'
        AND g.codigoperiodo = '$periodoactual'
        AND p.codigoestadoprematricula LIKE '4%'
        AND d.codigoestadodetalleprematricula LIKE '3%'";
                    //echo $query_creditos,"<br>";
                    $res_creditos = mysql_query($query_creditos, $sala) or die(mysql_error());
                    $solicitud_creditos = mysql_fetch_assoc($res_creditos);
                    $creditossemestre = 0;
                    $indicadormateriasperdidas = 0;

                    do {
    //$indicadormateriasperdidas = 0;
    $creditossemestre = $creditossemestre + $solicitud_creditos['numerocreditos'];
    /////////////////////////////////////////////////////////////
            $equivalencia = seleccionarequivalencias1($solicitud_creditos['codigomateria'],$solicitud_creditos['idplanestudio'],$sala);
    //echo $equivalencia,"<br>";
    $Arregloequivalencias = seleccionarequivalencias($equivalencia,$solicitud_creditos['idplanestudio'],$sala);

    if ($equivalencia == "") {
        //echo $solicitud_creditos['codigomateria'],"<br><br><br>";
        $Arregloequivalencias[] = $solicitud_creditos['codigomateria'];
    }
    $Arregloequivalencias[] = $equivalencia;
    $cuentamateriaperdida = 0;
    if(!array_search($solicitud_creditos['codigomateria'], $Arregloequivalencias))
        $Arregloequivalencias[] = $solicitud_creditos['codigomateria'];
    $Arregloequivalencias = array_unique($Arregloequivalencias);
    print_r($Arregloequivalencias);
    foreach($Arregloequivalencias as $key3 => $selEquivalencias) {
        // foreach
        if($selEquivalencias <> "") {
            $query_historico = "SELECT n.notadefinitiva,m.notaminimaaprobatoria
                    FROM notahistorico n,materia m
                    WHERE n.codigoestudiante = '".$codigoestudiante."'
                    and n.codigomateria = '$selEquivalencias'
                    and n.codigomateria = m.codigomateria
                    and n.codigoestadonotahistorico like '1%'";
                                //echo $query_historico,"qq<br><br><br>";
                                $res_historico = mysql_query($query_historico, $sala) or die(mysql_error());
                                $solicitud_historico = mysql_fetch_assoc($res_historico);
        }
        if ($solicitud_historico <> "") {
            do {
                echo $selEquivalencias,"&nbsp;&nbsp;&nbsp;",$solicitud_historico['notadefinitiva'],"&nbsp;",$solicitud_historico['notaminimaaprobatoria'],"aca$cuentamateriaperdida<br><br>";
                if ($solicitud_historico['notadefinitiva'] < $solicitud_historico['notaminimaaprobatoria']) {
                    $cuentamateriaperdida++;
                }
                else if ($solicitud_historico['notadefinitiva'] >= $solicitud_historico['notaminimaaprobatoria']) {
                    $cuentamateriaperdida = 0;
                }
            }
            while($solicitud_historico = mysql_fetch_assoc($res_historico));
            echo $cuentamateriaperdida,"perdida<br>";
            if ($cuentamateriaperdida > 1) {
                $indicadormateriasperdidas = 1;
            }
        }
        //////////////////////////////////////////////////////////////
    // echo $indicadormateriasperdidas,"indicador<br>";
    } // foreach
}
while($solicitud_creditos = mysql_fetch_assoc($res_creditos));
//exit();
?>