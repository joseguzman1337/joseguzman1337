<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once(realpath(dirname(__FILE__) . "/../../../../sala/includes/adaptador.php"));

?>
    <html>
    <head>
        <link type="text/css" rel="stylesheet" href="../../../../assets/css/normalize.css">
        <link type="text/css" rel="stylesheet" href="../../../../assets/css/font-page.css">
        <link type="text/css" rel="stylesheet" href="../../../../assets/css/font-awesome.css">
        <link type="text/css" rel="stylesheet" href="../../../../assets/css/bootstrap.css">
        <link type="text/css" rel="stylesheet" href="../../../../assets/css/general.css">
        <link type="text/css" rel="stylesheet" href="../../../../assets/css/chosen.css">
        <!--  Space loading indicator  -->
        <script src="<?php echo HTTP_SITE; ?>/assets/js/spiceLoading/pace.min.js"></script>
        <!--  loading cornerIndicator  -->
        <link href="<?php echo HTTP_SITE; ?>/assets/css/CenterRadarIndicator/centerIndicator.css" rel="stylesheet">
        <script src="<?php echo HTTP_SITE; ?>/assets/js/bootstrap.min.js"></script>
        <link href="<?php echo HTTP_SITE; ?>/assets/css/bootstrap.min.css" rel="stylesheet">
        <script type="text/javascript" src="<?php echo HTTP_SITE; ?>/assets/js/jquery-3.6.0.min.js"></script>
        <script type="text/javascript" src="<?php echo HTTP_SITE; ?>/assets/js/bootstrap.js"></script>

    </head>
<body>
<div class="container">
    <div>
<?php
$c = 1;
//Pagos de ordenes de pago fqallidos
?>
    <h3>Informe de matriculas 20202</h3>
    <table id="cronreenvio" name="cronreenvio" class="table table-bordered">
        <thead>
        <tr>
            <td>#</td>
            <td>orden</td>
            <td>estado orden</td>
            <td>documento</td>
            <td>codigo carrera</td>
            <td>nombre carrera</td>
            <td>semestre</td>
            <td>Valor 2020</td>
            <td>Valor de creditos</td>
            <td>Valor pagado</td>
            <td>Fecha de pago</td>
            <td>Pago Descuento</td>
            <td>Creditos completos semestre</td>
            <td>Creditos seleecionado</td>
            <td>% creditos prematricula</td>
            <td>Rango porcentaje</td>
        </tr>
        </thead>
        <tbody>
        <?php
        $Datosmatricula = Buscarmatriculas($db);
        if (!empty($Datosmatricula) && count($Datosmatricula) > 0) {
            foreach ($Datosmatricula as $valores) {
                echo '<tr><td>' . $c . '</td>';
                echo '<td>' . $valores['numeroordenpago'] . '</td>';
                echo '<td>' . $valores['nombreestadoordenpago'] . '</td>';
                echo '<td>' . $valores['numerodocumento'] . '</td>';
                echo '<td>' . $valores['codigocarrera'] . '</td>';
                echo '<td>' . $valores['nombrecarrera'] . '</td>';
                echo '<td>' . $valores['semestreprematricula'] . '</td>';
                echo '<td>' . $valores['Valor_2020'] . '</td>';
                if (isset($valores['creditos_seleecionado'])) {
                    $valorcredito = $valores['Valor_2020'] / $valores['creditos_completos'];
                    echo '<td>' . round($valorcredito, 0) . '</td>';
                } else {
                    echo '<td>0</td>';
                }
                $pago = 0;
                $valor_caja = 0;
                $fechapago = 0;
                $valor_pse = 0;
                $comparacionpago = 0;
                if ($valores['codigoestadoordenpago'] == 40 || $valores['codigoestadoordenpago'] == 41) {
                    $sqlcontador = "select count(*) as 'conteo' from fechaordenpago " .
                        " where numeroordenpago = " . $valores['numeroordenpago'] . " ";
                    $contador = $db->GetRow($sqlcontador);
                    if ($contador['conteo'] == 1) {
                        $valida = " ";
                    } else {
                        $valida = " and f.fechaordenpago >= ( select date_format(fecharegistrologtraceintegracionps, 'Y-m-d') " .
                            " from logtraceintegracionps where documentologtraceintegracionps = f.numeroordenpago " .
                            " and transaccionlogtraceintegracionps = 'Pago Caja-Bancos' limit 1)";
                    }

                    $sqlvalorpagado = "select f.valorfechaordenpago as 'valor_caja', o.fechapagosapordenpago " .
                        " from fechaordenpago f " .
                        " inner join ordenpago o on f.numeroordenpago = o.numeroordenpago " .
                        " where f.numeroordenpago = " . $valores['numeroordenpago'] . " " . $valida . "  limit 1";
                    $valorcaja = $db->GetRow($sqlvalorpagado);

                    if (isset($valorcaja['valor_caja'])) {
                        $valor_caja = $valorcaja['valor_caja'];
                        $fechapago = $valorcaja['fechapagosapordenpago'];
                    } else {
                        $pago++;
                        $sqlpse = "select TransValue, SoliciteDate from LogPagos where " .
                            " Reference1 = " . $valores['numeroordenpago'] . " and StaCode = 'OK'";
                        $valorpse = $db->getRow($sqlpse);

                        if (isset($valorpse['TransValue'])) {
                            $valor_pse = $valorpse['TransValue'];
                            $fechapago = $valorpse['SoliciteDate'];
                        } else {
                            $pago++;
                        }
                        if ($pago == 2) {
                            $sqlmanual = "select f.valorfechaordenpago, o.fechapagosapordenpago from logordenpago l " .
                                " inner join ordenpago o on l.numeroordenpago = o.numeroordenpago " .
                                " inner join fechaordenpago f on l.numeroordenpago = f.numeroordenpago " .
                                " where l.numeroordenpago = " . $valores['numeroordenpago'] . " " .
                                " and l.observacionlogordenpago like '%PAGA MANUALMENTE%' limit 1";
                            $manual = $db->GetRow($sqlmanual);

                            if (isset($manual['valorfechaordenpago'])) {
                                $valor_caja = $manual['valorfechaordenpago'];
                                $fechapago = $manual['fechapagosapordenpago'];
                            } else {
                                $sqlplanpagos = "select o.valorconcepto from ordenpagoplandepago od " .
                                    " inner join detalleordenpago o on od.numerorodenpagoplandepagosap = o.numeroordenpago and o.codigoconcepto = '151' " .
                                    " where od.numerorodenpagoplandepagosap = " . $valores['numeroordenpago'] . " limit 1";
                                $planpago = $db->getRow($sqlplanpagos);
                                if (isset($planpago['valorconcepto'])) {
                                    $valor_caja = $planpago['valorconcepto'];
                                }
                            }
                        }
                        $pago = 0;
                    }
                }

                if (isset($valor_caja) || isset($valor_pse)) {
                    if ($valor_caja != '0') {
                        $comparacionpago = $valor_caja;
                        echo '<td>' . $valor_caja . '</td>';
                    } else {
                        if ($valor_pse != '0') {
                            $comparacionpago = $valor_pse;
                            echo '<td>' . $valor_pse . '</td>';
                        } else {
                            echo '<td>0</td>';
                        }
                    }
                    echo '<td>' . $fechapago . '</td>';
                }

                if ($valores['codigoestadoordenpago'] == 40 || $valores['codigoestadoordenpago'] == 41) {
                    $sqldescuento = "select codigoconcepto from detalleordenpago where numeroordenpago =  " .
                        $valores['numeroordenpago'] . " "." and codigoconcepto in ('C9110', 'C9111')";
                    $descuento = $db->GetRow($sqldescuento);

                    if (isset($descuento['codigoconcepto'])) {
                        $valorcalculado = $valorcredito * $valores['creditos_seleecionado'];
                        $valordescuento = $valorcalculado - $comparacionpago;
                        if($valordescuento > 0) {
                            echo '<td>' . round($valordescuento, 0) . '</td>';
                        }else{
                            echo '<td>0</td>';
                        }
                    } else {
                        echo '<td>sin descuento</td>';
                    }
                }else{
                    echo '<td>0</td>';
                }

                echo '<td>' . $valores['creditos_completos'] . '</td>';
                echo '<td>' . $valores['creditos_seleecionado'] . '</td>';
                if (isset($valores['creditos_seleecionado'])) {
                    $porcentajematricula = ($valores['creditos_seleecionado'] / $valores['creditos_completos']) * 100;
                } else {
                    $porcentajematricula = "0";
                }
                echo '<td>' . round($porcentajematricula, 2) . ' %</td>';

                //funcion en excel=SI(N16199<51%;"menor igual 50%";SI(N16199<100%;"entre 51% y 99%"; SI(N16199=100%;"Matricula completa";"Sobreacreditado")))
                if ($porcentajematricula < '51') {
                    $rango = "menor igual 50%";
                } else {
                    if ($porcentajematricula < '100') {
                        $rango = "entre 51% y 99%";
                    } else {
                        if ($porcentajematricula == '100') {
                            $rango = "Matricula completa";
                        } else {
                            $rango = "Sobreacreditado";
                        }
                    }
                }
                echo '<td>' . $rango . '</td>';
                echo '</tr>';
                $c++;
            }//foreach
        }//if $DatosPagos

        ?>
        </tbody>
    </table>
<?php

function Buscarmatriculas($db)
{
    $sql = "select o.numeroordenpago, o.codigoestadoordenpago, s.nombreestadoordenpago, eg.numerodocumento, ch.codigocarrera, ca.nombrecarrera, " .
        " p.semestreprematricula, d2.valordetallecohorte as 'Valor_2020', " .
        " (select sum(dp.numerocreditosdetalleplanestudio) from detalleplanestudio dp where dp.idplanestudio = p2.idplanestudio " .
        " and dp.semestredetalleplanestudio = p.semestreprematricula) as 'creditos_completos', " .
        " (select sum(m.numerocreditos) " .
        " from detalleprematricula dpm  inner join materia m on dpm.codigomateria = m.codigomateria  where dpm.numeroordenpago = o.numeroordenpago " .
        " and dpm.idprematricula = p.idprematricula and dpm.codigoestadodetalleprematricula in (30, 10))  as 'creditos_seleecionado' " .
        " from ordenpago o " .
        " inner join detalleordenpago d on o.numeroordenpago = d.numeroordenpago and d.codigoconcepto in ('151') " .
        " inner join estadoordenpago s on o.codigoestadoordenpago = s.codigoestadoordenpago " .
        " inner join estudiante e on o.codigoestudiante = e.codigoestudiante " .
        " inner join carrera ca on ca.codigocarrera = e.codigocarrera " .
        " inner join estudiantegeneral eg on eg.idestudiantegeneral = e.idestudiantegeneral " .
        " inner join prematricula p on o.idprematricula = p.idprematricula " .
        " inner join cohorte ch on o.codigoperiodo = ch.codigoperiodo and ch.codigocarrera = e.codigocarrera " .
        " inner join detallecohorte d2 on ch.idcohorte = d2.idcohorte and p.semestreprematricula = d2.semestredetallecohorte" .
        " inner join planestudioestudiante p2 on e.codigoestudiante = p2.codigoestudiante and p2.codigoestadoplanestudioestudiante in (100, 101) " .
        " where o.codigoperiodo = 20202 and o.codigoestadoordenpago in (10, 11, 40, 41) " .
        " and e.codigocarrera not in (1186, 1386) " .
        " group by o.numeroordenpago";
    $data = $db->getAll($sql);

    return $data;

}