<?php

    if(isset($_GET['debug']) && !empty($_GET['debug'])) {
        echo "<br>errores<br>";
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }
    require_once(realpath(dirname(__FILE__) . "/../../../sala/includes/adaptador.php"));

    $pos = strpos($Configuration->getEntorno(), "local");
    require_once(PATH_ROOT . '/serviciosacademicos/consulta/interfacespeople/funcionesPS.php');

    $fechaanio = date('Y');
    $fechames= date('m');
    $fechadia= date('d');
    $fechahora= date('h:m');
?>
<html>
    <head>
        <link type="text/css" rel="stylesheet" href="../../../assets/css/normalize.css">
        <link type="text/css" rel="stylesheet" href="../../../assets/css/font-page.css">
        <link type="text/css" rel="stylesheet" href="../../../assets/css/font-awesome.css">
        <link type="text/css" rel="stylesheet" href="../../../assets/css/bootstrap.css">
        <link type="text/css" rel="stylesheet" href="../../../assets/css/general.css">
        <link type="text/css" rel="stylesheet" href="../../../assets/css/chosen.css">
        <!--  Space loading indicator  -->
        <script src="<?php echo HTTP_SITE;?>/assets/js/spiceLoading/pace.min.js"></script>
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
                Servicio: <?php echo $Configuration->getEntorno(); ?><br>
                <?php echo "Fecha : $fechaanio - $fechames - $fechadia Hora: $fechahora"; ?>
                <h2>INICIA COMUNICACION CON PEOPLE</h2>
            </div>
            <div>
                <?php
                $c=1;
                //Pagos de ordenes de pago fqallidos
                ?>
                <h3>Informa Pago PSE Fallidos</h3>
                <table id="cronreenvio" name="cronreenvio"class="table table-bordered">
                    <thead>
                    <tr>
                        <td>#</td><td>Orden</td><td>DESCRIPCION</td><td>Respuesta People</td>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $DatosPagos = BuscarPagosFallidos($db,$fechaanio, $fechames);
                    if (!empty($DatosPagos) && count($DatosPagos) > 0) {
                        foreach ($DatosPagos as $valores) {
                            echo '<tr><td>' . $c . '</td>';
                            echo '<td>' . $valores['numeroordenpago'] . '</td>';
                            $result= reportarPagoPSE($db, $valores['numeroordenpago']);
                            if (isset($result['ERRNUM']) && !empty($result['ERRNUM'])) {
                                $errornum = $result['ERRNUM'];
                            } else {
                                if(isset($result['faultcode']) && !empty($result['faultcode'])){
                                    $errornum = $result['detail']['IBResponse']['DefaultTitle'];
                                    $errornum.= "-".$result['detail']['IBResponse']['DefaultMessage'];
                                }else{
                                    $errornum = " ";
                                }
                            }
                            echo "<td>" . $errornum . " ";
                            if(isset($result['DESCRLONG'])){
                                echo $result['DESCRLONG'];
                            }
                            echo "</td>";
                            if (isset($result['val']) && $result['val'] == false) {
                                echo '<td>Proceso Fallido</td>';
                            } else {
                                echo '<td>Pago finalizada</td>';
                            }
                            $c++;
                            echo '</tr>';
                        }
                    }//if $DatosPagos
                    else{
                        echo '<tr><td colspan="4">Sin registros pendientes</td></tr>';
                    }

                    ?>
                    </tbody>
                </table>
                <?php
                //cargas academicas
                $c=1;
                ?>
              <!--<h3>Ajustes de cargas academicas</h3>
                <table id="cronreenvio" name="cronreenvio"class="table table-bordered">
                    <thead>
                    <tr>
                        <td>#</td><td>Documento - Codigoestudiante</td><td>Orden - Estado</td>
                        <td>Prematricula - Estado</td><td>Detalle prematricula - estado</td><td>Resultado</td>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                   /* $DatosCargas = CargasAcademicas($db);
                    if (!empty($DatosCargas) && count($DatosCargas) > 0) {
                        foreach ($DatosCargas as $cargas) {
                            echo "<tr><td>$c</td>";
                            echo "<td>".$cargas['numerodocumento']." - ".$cargas['codigoestudiante']."</td>";
                            echo "<td>".$cargas['numeroordenpago']." - ".$cargas['codigoestadoordenpago']."</td>";
                            echo "<td>".$cargas['idprematricula']." - ".$cargas['codigoestadoprematricula']."</td>";
                            echo "<td>".$cargas['idprematricula']." - ".$cargas['codigoestadodetalleprematricula']."</td>";
                            echo "<td>";
                            if(isset($cargas['codigoestadodetalleprematricula']) && !empty($cargas['codigoestadodetalleprematricula'])) {
                                $resultadocarga = AplicarPagoSala($db, $cargas);
                                if($cargas['codigoestadodetalleprematricula'] == '20' || $cargas['codigoestadodetalleprematricula'] == '22'){
                                    $resultadocarga = ActualizarCarga($db, $cargas['numeroordenpago'], $cargas['codigoestudiante'], $cargas['idprematricula']);
                                }
                            }else{
                                $resultadocarga = ActualizarCarga($db, $cargas['numeroordenpago'], $cargas['codigoestudiante'], $cargas['idprematricula']);
                            }
                            echo "$resultadocarga</td>";
                            $c++;
                            echo "</tr>";
                        }
                    }else{
                        echo '<tr><td colspan="5">Sin registros por solucionar</td></tr>';
                    }*/
                    ?>
                    </tbody>
                </table> -->
                <?php
                $c=1;
                //Pagos pendientes no reporetados
                ?>
                <h3>Informa Pago PSE Pendiente</h3>
                <table id="cronreenvio" name="cronreenvio"class="table table-bordered">
                    <thead>
                    <tr>
                        <td>#</td><td>Orden</td><td>DESCRIPCION</td><td>Respuesta People</td>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $DatosPagos = BuscarPagosPsePendientes($db, $fechaanio, $fechames);
                    if (!empty($DatosPagos) && count($DatosPagos) > 0) {
                        foreach ($DatosPagos as $valores) {
                            if(isset($valores['numeroordenpago']) && !empty($valores['numeroordenpago'])) {
                                echo '<tr><td>' . $c . '</td>';
                                echo '<td>' . $valores['numeroordenpago'] . '</td>';
                                $result = reportarPagoPSE($db, $valores['numeroordenpago']);
                                if (isset($result['ERRNUM']) && !empty($result['ERRNUM'])) {
                                    $errornum = $result['ERRNUM'];
                                } else {
                                    if (isset($result['faultcode']) && !empty($result['faultcode'])) {
                                        $errornum = $result['detail']['IBResponse']['DefaultTitle'];
                                        $errornum .= "-" . $result['detail']['IBResponse']['DefaultMessage'];
                                    } else {
                                        $errornum = " ";
                                    }
                                }
                                echo "<td>respondio peoplesoft " . $errornum . " - " . $result['DESCRLONG'] . "</td>";
                                echo '<td>Se realiza el reenvio del pago PSE</td>';
                                $c++;
                                echo '</tr>';
                            }
                        }//foreach
                    }//if $DatosPagos
                    else{
                        echo '<tr><td colspan="4">Sin registros pendientes</td></tr>';
                    }
                    ?>
                    </tbody>
                </table>
                <br>
                <?php
                $c=1;
                //pagos incompletos
                ?>
                <h3>Informa Pagos Incompletos</h3>
                <table id="cronreenvio" name="cronreenvio"class="table table-bordered">
                    <thead>
                    <tr>
                        <td>#</td><td>Orden</td><td>DESCRIPCION</td><td>Respuesta SALA</td>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $DatosPagos = BuscarPagosIncompletos($db);
                    if (!empty($DatosPagos) && count($DatosPagos) > 0) {
                        foreach ($DatosPagos as $pagos) {
                            echo '<tr><td>' . $c . '</td>';
                            echo '<td>' . $pagos['numeroordenpago'] . '</td>';
                            $resultado = AplicarPagoSala($db, $pagos);
                            echo "<td>" . $resultado . "</td>";
                            echo '<td>Proceso Actualizado</td>';
                            $c++;
                            echo "</tr>";
                        }
                    }else{
                        echo '<tr><td colspan="4">Sin registros pendientes</td></tr>';
                    }
                    ?>
                    </tbody>
                </table>
                <?php
                $c = 1;
                //Creacion Pendientes
                ?>
                <h3>Creacion Orden Pago Pendiente</h3>
                <table id="cronreenvio" name="cronreenvio"class="table table-bordered">
                    <thead>
                    <tr>
                        <td>#</td><td>Orden</td><td>DESCRIPCION</td><td>Respuesta People</td>
                    </tr>
                    </thead>
                    <tbody>
                        <?php
                        $DatosCreaciones = BuscarCreacionesPendientes($db, $fechaanio, $fechames);
                        if (!empty($DatosCreaciones)) {
                            foreach ($DatosCreaciones as $valores) {
                                if(isset($valores['numeroordenpago']) && !empty($valores['numeroordenpago'])) {
                                    echo '<tr><td>' . $c . '</td>';
                                    echo '<td>' . $valores['numeroordenpago'] . '</td>';
                                    $result = estudianteOrden($db, $valores['numeroordenpago']);
                                    if (isset($result['ERRNUM']) && !empty($result['ERRNUM'])) {
                                        $errornum = $result['ERRNUM'];
                                    } else {
                                        if (isset($result['faultcode']) && !empty($result['faultcode'])) {
                                            $errornum = $result['detail']['IBResponse']['DefaultTitle'];
                                            $errornum .= "-" . $result['detail']['IBResponse']['DefaultMessage'];
                                        } else {
                                            $errornum = " ";
                                        }
                                    }
                                    echo "<td>" . $errornum . " " . $result['DESCRLONG'] . "</td>";
                                    if (isset($result['val']) && $result['val'] == false) {
                                        echo '<td>Proceso Fallido</td>';
                                    } else {
                                        echo '<td>Creacion finalizada</td>';
                                    }
                                    $c++;
                                    echo '</tr>';
                                }
                            }//foreach
                        }//if datos
                        ?>
                    </tbody>
                </table>
                <br>
                <?php
                $c=1;
                //Creaciones, Pagos estado 0 pendientes spor enviar
                ?>
                <h3>Busquedas generales</h3>
                <table id="cronreenvio" name="cronreenvio"class="table table-bordered">
                    <thead>
                    <tr>
                        <td>#</td><td>Orden</td><td>Accion</td><td>DESCRIPCION</td><td>Respuesta People</td>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $Datosgenerales = BuscarDatos($db, $fechaanio, $fechames);
                    if (!empty($Datosgenerales) && count($Datosgenerales) > 0) {
                        foreach ($Datosgenerales as $valoresgenerales) {
                            if(isset($valoresgenerales['docu']) && !empty($valoresgenerales['docu'])) {
                                echo '<tr><td>' . $c . '</td>';
                                echo '<td>' . $valoresgenerales['docu'] . '</td>';
                                echo '<td>' . $valoresgenerales['Nombre'] . '<br> envio 0</td>';
                                switch ($valoresgenerales['Nombre']) {
                                    case 'Creacion Orden Pago':
                                        {
                                            $result = estudianteOrden($db, $valoresgenerales['codigo']);
                                            if (isset($result['ERRNUM']) && !empty($result['ERRNUM'])) {
                                                $errornum = $result['ERRNUM'];
                                            } else {
                                                if (isset($result['faultcode']) && !empty($result['faultcode'])) {
                                                    $errornum = $result['detail']['IBResponse']['DefaultTitle'];
                                                    $errornum .= "-" . $result['detail']['IBResponse']['DefaultMessage'];
                                                } else {
                                                    $errornum = " ";
                                                }
                                            }
                                            echo "<td>respondio peoplesoft " . $errornum . " - " . $result['DESCRLONG'] . "</td>";
                                            echo '<td>Creacion finalizada</td>';
                                        }
                                        break;
                                    case 'Actualizacion estudiante':
                                        {
                                            $msg = ActualizarEstudiante($db, $valoresgenerales['codigo'], $valoresgenerales['id']);
                                            echo "<td>$msg</td>";
                                            echo '<td>Se Actualizaron los datos del estudiante</td>';
                                        }
                                        break;
                                    case 'Informa Pago PSE':
                                        {
                                            $result = PagosPSE($db, $valoresgenerales['codigo'], $valoresgenerales['id'], 'Update');
                                            if (isset($result['ERRNUM']) && !empty($result['ERRNUM'])) {
                                                $errornum = $result['ERRNUM'];
                                            } else {
                                                if (isset($result['faultcode']) && !empty($result['faultcode'])) {
                                                    $errornum = $result['detail']['IBResponse']['DefaultTitle'];
                                                    $errornum .= "-" . $result['detail']['IBResponse']['DefaultMessage'];
                                                } else {
                                                    $errornum = " ";
                                                }
                                            }
                                            echo "<td>respondio peoplesoft " . $errornum . " - " . $result['DESCRLONG'] . "</td>";
                                            echo '<td>Se realiza el pago PSE</td>';
                                        }
                                        break;
                                }//switch
                                $c++;
                                echo '</tr>';
                            }else{
                                echo '<td colspan="2">Sin orden para procesar</td></tr>';
                            }
                        }
                    }//if datos
                    else{
                        echo '<tr><td colspan="5">Sin registros pendientes</td></tr>';
                    }
                    ?>
                    </tbody>
                </table>
                <?php
                $c=1;
                //Anulaciones peddientes de ordenes creadas satisfactoriamente
                ?>
                 <!--<h3>Anulacion Pendiente</h3>
               <table id="cronreenvio" name="cronreenvio"class="table table-bordered">
                    <thead>
                    <tr>
                        <td>#</td><td>Orden</td><td>DESCRIPCION</td><td>Respuesta People</td>
                    </tr>
                    </thead>
                    <tbody>
                <?php
                   /* $Datos = BuscarDatosAnulaciones($db, $fechaanio, $fechames);
                    if (!empty($Datos) && count($Datos) > 0) {
                        foreach ($Datos as $valores) {
                            echo '<tr><td>' . $c . '</td>';
                            echo '<td>' . $valores['docu'] . '</td>';
                            $result = Anular($db, $valores['codigo'], $valores['id'], $valores['docu']);
                            if(isset($result['ERRNUM']) && !empty($result['ERRNUM'])){
                                $errornum = $result['ERRNUM'];
                            }else{
                                if(isset($result['faultcode']) && !empty($result['faultcode'])){
                                    $errornum = $result['detail']['IBResponse']['DefaultTitle'];
                                    $errornum.= "-".$result['detail']['IBResponse']['DefaultMessage'];
                                }else{
                                    $errornum = " ";
                                }
                            }
                            echo "<td>" . $errornum . " - " . $result['DESCRLONG'] . "</td>";
                            echo '<td>Anulacion realizada</td>';
                            $c++;
                            echo '</tr>';
                        }
                    }
                    else{
                        echo '<tr><td colspan="4">Sin registros pendientes</td></tr>';
                    }*/
                    ?>
                  </tbody>
                </table>
                <br> -->
                <?php 
                $c=1;
                //Creacion de ordenes fallidas
                ?>
                <h3>Creacion Orden Pago Fallida</h3>
                <table id="cronreenvio" name="cronreenvio"class="table table-bordered">
                    <thead>
                    <tr>
                        <td>#</td><td>Orden</td><td>DESCRIPCION</td><td>Respuesta People</td>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $Datos = BuscarCreacionFallidas($db, $fechaanio, $fechames);
                    if (!empty($Datos) && count($Datos) > 0) {
                        foreach ($Datos as $valores) {
                            echo '<tr><td>' . $c . '</td>';
                            echo '<td>' . $valores['numeroordenpago'] . '</td>';
                            $result = estudianteOrden($db, $valores['numeroordenpago']);
                            if (isset($result['ERRNUM']) && !empty($result['ERRNUM'])) {
                                $errornum = $result['ERRNUM'];
                            } else {
                                if(isset($result['faultcode']) && !empty($result['faultcode'])){
                                    $errornum = $result['detail']['IBResponse']['DefaultTitle'];
                                    $errornum.= "-".$result['detail']['IBResponse']['DefaultMessage'];
                                }else{
                                    $errornum = " ";
                                }
                            }
                            echo "<td>" . $errornum . " " . $result['DESCRLONG'] . "</td>";
                            if (isset($result['val']) && $result['val'] == false) {
                                echo '<td>Proceso Fallido</td>';
                            } else {
                                echo '<td>Creacion finalizada</td>';
                            }

                            $c++;
                            echo '</tr>';
                        }//foreach
                    }else{
                        echo '<tr><td colspan="4">Sin registros pendientes</td></tr>';
                    }
                    ?>
                    </tbody>

                </table>

            </div>
            <?php
            function BuscarDatos($db, $fechaanio, $fechames) {
                $SQLdatos = "SELECT l.idlogtraceintegracionps AS id, l.transaccionlogtraceintegracionps AS Nombre, ".
                " l.enviologtraceintegracionps AS codigo, l.respuestalogtraceintegracionps AS rt, ".
                " l.documentologtraceintegracionps as docu, l.fecharegistrologtraceintegracionps AS fecha ".
                " FROM logtraceintegracionps l ".
                " inner join ordenpago o on l.documentologtraceintegracionps = o.numeroordenpago ".
                " WHERE ".
                " l.transaccionlogtraceintegracionps IN ('Creacion Orden Pago', ".
                " 'Actualizacion estudiante','Informa Pago PSE') AND l.estadoenvio=0 ".
                " and l.respuestalogtraceintegracionps not like '%La FACTURA esta en estado G%'".
                " and l.respuestalogtraceintegracionps not like '%La FACTURA esta en estado P%'".
                " and l.documentologtraceintegracionps not in ( ".
                    " select lt.documentologtraceintegracionps from logtraceintegracionps lt ".
                    " where lt.documentologtraceintegracionps = l.documentologtraceintegracionps ".
                    " and lt.respuestalogtraceintegracionps like '%1 - El Pago ya estaba aplicado%' )".
                " and o.fechaordenpago between '".$fechaanio."-".$fechames."-01' and '".$fechaanio."-".$fechames."-31'".
                " and o.codigoestadoordenpago not in (20, 21, 24) ORDER BY l.idlogtraceintegracionps DESC  limit 10";
                $Datageneral = $db->GetAll($SQLdatos);

                if (count($Datageneral) > 0) {
                    return $Datageneral;
                } else {
                    return false;
                }
            }

            function BuscarDatosAnulaciones($db, $fechaanio, $fechames) {
                /*
                * consulta ordenes de pago creadas correctamente, que no tengan pagos por lotes o por pse y que
                * no tengan una anulacion ya realizada y aplicada.
                */

                $SQLanulacion = "SELECT l.idlogtraceintegracionps AS id, l.transaccionlogtraceintegracionps AS Nombre, ".
                " l.enviologtraceintegracionps AS codigo, l.respuestalogtraceintegracionps AS rt, ".
                " l.documentologtraceintegracionps as docu, l.fecharegistrologtraceintegracionps AS fecha ".
                " FROM logtraceintegracionps l ".
                " inner join ordenpago o on l.documentologtraceintegracionps = o.numeroordenpago ".
                " and o.codigoestadoordenpago in (20, 21, 22, 24)".
                " WHERE ".
                " l.respuestalogtraceintegracionps not like '%id:0 descripcion:%'".
                " and  l.respuestalogtraceintegracionps not like '%ERRNUM=0, DESCRLONG=Ok%'".
                " and l.documentologtraceintegracionps not in (".
                "select lps.documentologtraceintegracionps from logtraceintegracionps lps ".
                " where lps.documentologtraceintegracionps = o.numeroordenpago ".
                " and lps.transaccionlogtraceintegracionps in ('Pago Caja-Bancos', 'Informa Pago PSE') ".
                " and (lps.respuestalogtraceintegracionps like '%ERRNUM=0, DESCRLONG=Ok%' or ".
                " lps.respuestalogtraceintegracionps like '%id:0 descripcion:%')) ".
                " and l.documentologtraceintegracionps not in (select lps.documentologtraceintegracionps ".
                " from logtraceintegracionps lps ".
                " where lps.documentologtraceintegracionps = o.numeroordenpago ".
                " and lps.transaccionlogtraceintegracionps = 'Anulacion Orden Pago' ".
                " and lps.respuestalogtraceintegracionps like '%id:0 descripcion: Correcto%')".
                " and l.fecharegistrologtraceintegracionps like '".$fechaanio."-".$fechames."%' ".
                " group by l.documentologtraceintegracionps  limit 50";
                $Data = $db->GetAll($SQLanulacion);
                if (count($Data) > 0) {
                    return $Data;
                } else {
                    return false;
                }
            }

            function BuscarCreacionesPendientes($db, $fechaanio, $fechames){
                //Lista de ordenes del mes actual pendientes por enviar a people en sus diferentes estados.
                $SQLcreacion = "select o.numeroordenpago, lt.idlogtraceintegracionps from ordenpago o ".
                " left join logtraceintegracionps lt on lt.documentologtraceintegracionps = o.numeroordenpago ".
                " where lt.idlogtraceintegracionps is null ".
                " and o.fechaordenpago between '".$fechaanio."-".$fechames."-01' and '".$fechaanio."-".$fechames."-31'".
                " and o.codigoestadoordenpago not in (20, 21, 24, 70, 60, 61) group by o.numeroordenpago limit 50";
                $Data = $db->GetAll($SQLcreacion);

                if (count($Data) > 0) {
                    return $Data;
                } else {
                    return false;
                }
            }

            function BuscarPagosPsePendientes($db, $fechaanio, $fechames){
                /*
                * ordenes de pago pagadas con log de pagos en estado ok, con log de trace de creacion correcta,
                * y sin intentos de pagos realizados
                */
                $SQLpagos = "select o.numeroordenpago, o.fechaordenpago, o.codigoestudiante, e.codigocarrera, d.codigoconcepto, ".
                " d.valorconcepto,lp.SoliciteDate, lp.TicketId, lp.TrazabilityCode, lp.TransValue, lp.FIName, lp.Reference1, ".
                " lt.idlogtraceintegracionps, lt.transaccionlogtraceintegracionps, lt.respuestalogtraceintegracionps".
                " from ordenpago o ".
                " inner join LogPagos lp on lp.Reference1 = o.numeroordenpago and lp.StaCode='OK' ".
                " inner join estudiante e on e.codigoestudiante = o.codigoestudiante ".
                " inner join detalleordenpago d on o.numeroordenpago = d.numeroordenpago ".
                " left join logtraceintegracionps lt on lt.documentologtraceintegracionps = o.numeroordenpago ".
                " and lt.transaccionlogtraceintegracionps in ('Informa Pago PSE') ".
                " where lp.BankProcessDate between '".$fechaanio."-".$fechames."-01' and '".$fechaanio."-".$fechames."-31' ".
                "  and o.numeroordenpago in ( select lps.documentologtraceintegracionps ".
                " from logtraceintegracionps lps ".
                " where lps.documentologtraceintegracionps = o.numeroordenpago ".
                " and lps.transaccionlogtraceintegracionps = 'Creacion Orden Pago' ".
                " and lps.respuestalogtraceintegracionps like '%id:0 descripcion:%') ".
                " and o.numeroordenpago not in (".
                    "select documentologtraceintegracionps ".
                    " from logtraceintegracionps ".
                    " where respuestalogtraceintegracionps like '%La FACTURA esta en estado G%' ".
                    " and documentologtraceintegracionps = o.numeroordenpago ) ".
                " and o.numeroordenpago not in (".
                    "select documentologtraceintegracionps ".
                    " from logtraceintegracionps ".
                    " where respuestalogtraceintegracionps like '%La orden ya esta siendo procesada%' ".
                    " and documentologtraceintegracionps = o.numeroordenpago ) ".
                " and lt.respuestalogtraceintegracionps is null group by o.numeroordenpago";
                $Data = $db->GetAll($SQLpagos);

                if (count($Data) > 0) {
                    return $Data;
                } else {
                    return false;
                }
            }

            function BuscarCreacionFallidas($db, $fechaanio, $fechames){
                $sqlfallidas = "SELECT l.respuestalogtraceintegracionps, l.documentologtraceintegracionps as numeroordenpago".
                " FROM logtraceintegracionps l ".
                " inner join ordenpago o on (l.documentologtraceintegracionps = o.numeroordenpago ".
                " and o.codigoestadoordenpago not in (20, 21, 22, 24) )".
                " WHERE l.transaccionlogtraceintegracionps IN ('Creacion Orden Pago') ".
                " and o.fechaordenpago between '".$fechaanio."-".$fechames."-01' and '".$fechaanio."-".$fechames."-31'".
                " and l.documentologtraceintegracionps not in ( ".
                " select lt.documentologtraceintegracionps from logtraceintegracionps lt ".
                " where lt.respuestalogtraceintegracionps like '%id:0 descripcion: %' ".
                " and lt.transaccionlogtraceintegracionps IN ('Creacion Orden Pago') ".
                " and lt.documentologtraceintegracionps = o.numeroordenpago)".
                " group by l.documentologtraceintegracionps ".
                " order by l.documentologtraceintegracionps limit 50";
                $casos = $db->GetAll($sqlfallidas);
                return $casos;
            }

            function BuscarPagosFallidos($db, $fechaanio, $fechames){
                $sql ="SELECT l.respuestalogtraceintegracionps, l.documentologtraceintegracionps as numeroordenpago ".
                " FROM logtraceintegracionps l ".
                " inner join ordenpago o on (l.documentologtraceintegracionps = o.numeroordenpago )".
                " inner join LogPagos lp on (lp.Reference1 = o.numeroordenpago and lp.StaCode = 'OK')".
                " WHERE l.transaccionlogtraceintegracionps IN ('Informa Pago PSE') ".
                " and lp.BankProcessDate between '".$fechaanio."-".$fechames."-01' and '".$fechaanio."-".$fechames."-31'".
                " and l.documentologtraceintegracionps in ( ".
                " select lt.documentologtraceintegracionps from logtraceintegracionps lt ".
                " where lt.respuestalogtraceintegracionps like '%id:0 descripcion: %' ".
                " and lt.transaccionlogtraceintegracionps IN ('Creacion Orden Pago') ".
                " and lt.documentologtraceintegracionps = o.numeroordenpago)".
                " and l.documentologtraceintegracionps not in ( ".
                " select lt.documentologtraceintegracionps from logtraceintegracionps lt ".
                " where lt.respuestalogtraceintegracionps like '%Correcto:%' ".
                " and lt.transaccionlogtraceintegracionps IN ('Informa Pago PSE') ".
                " and lt.documentologtraceintegracionps = o.numeroordenpago) ".
                " and l.documentologtraceintegracionps not in ( ".
                " select lt.documentologtraceintegracionps from logtraceintegracionps lt ".
                " where lt.respuestalogtraceintegracionps like '%1 - La orden ya esta siendo procesada%' ".
                " and lt.transaccionlogtraceintegracionps IN ('Informa Pago PSE') ".
                " and lt.documentologtraceintegracionps = o.numeroordenpago )".
                " and l.documentologtraceintegracionps not in ( select lt.documentologtraceintegracionps ".
                " from logtraceintegracionps lt ".
                " where lt.respuestalogtraceintegracionps like '%ERRNUM=0, DESCRLONG=OK%' ".
                 " and lt.transaccionlogtraceintegracionps IN ('Pago Caja-Bancos') ".
                 " and lt.documentologtraceintegracionps = o.numeroordenpago) ".
                " group by l.documentologtraceintegracionps ";
                $casos = $db->GetAll($sql);
                return $casos;
            }

            function BuscarPagosIncompletos($db){
                //consulta ordenes de matricula con problemas en prematricula y detalleprematricula
                $sqlincompletos = "select o.numeroordenpago, o.codigoestadoordenpago, p.idprematricula, ".
                " p.codigoestadoprematricula from ordenpago o ".
                " inner join prematricula p on o.idprematricula = p.idprematricula ".
                " inner join detalleprematricula d on o.numeroordenpago = d.numeroordenpago ".
                " inner join estudiante e on e.codigoestudiante = o.codigoestudiante ".
                " inner join detalleordenpago d2 on o.numeroordenpago = d2.numeroordenpago and d2.codigoconcepto = 151 ".
                " where o.codigoestadoordenpago in (40, 41) ".
                " and p.codigoestadoprematricula in (10, 30) and d.codigoestadodetalleprematricula in (30, 10) ".
                " and o.codigoperiodo in (20201, 20202) ".
                " group by o.numeroordenpago order by  o.codigoperiodo desc  limit 50";
                $datos = $db->GetAll($sqlincompletos);
                return $datos;
            }

            function CargasAcademicas($db){
                //consulta las ordenes de matricula pagadas con errores de carga academica,
                // omite estudiantes que ya cuentan con la carga academica asiganada y pagada
                $sqlcargas = "select e2.numerodocumento, e.codigoestudiante, o.numeroordenpago, o.codigoestadoordenpago, ".
                " o.idprematricula, f.fechaordenpago, d2.codigoconcepto, p.idprematricula, p.codigoestadoprematricula, ".
                " d.codigoestadodetalleprematricula, d.codigomateria, d.idgrupo ".
                " from ordenpago o ".
                " inner join estudiante e on o.codigoestudiante = e.codigoestudiante and e.codigocarrera not in (1186)".
                " inner join estudiantegeneral e2 on e.idestudiantegeneral = e2.idestudiantegeneral ".
                " inner join detalleordenpago d2 on o.numeroordenpago = d2.numeroordenpago and d2.codigoconcepto = '151' ".
                " inner join prematricula p on o.idprematricula = p.idprematricula ".
                " left join fechaordenpago f on o.numeroordenpago = f.numeroordenpago ".
                " left join detalleprematricula d on o.numeroordenpago = d.numeroordenpago ".
                " where o.codigoperiodo = 20202 and o.codigoestadoordenpago in (40, 41) and o.idprematricula <> 1".
                " and d.codigoestadodetalleprematricula not in (30) and p.idprematricula = d.idprematricula ".
                " and  o.codigoestudiante not in ( ".
                    " select odp.codigoestudiante from ordenpago odp ".
                    " inner join detalleordenpago d3 on odp.numeroordenpago = d3.numeroordenpago and d3.codigoconcepto = '151'".
                    " inner join prematricula p2 on odp.idprematricula = p2.idprematricula and p2.codigoestadoprematricula = 40 ".
                    " inner join detalleprematricula d4 on odp.numeroordenpago = d4.numeroordenpago and d4.codigoestadodetalleprematricula = 30".
                    " where odp.codigoestudiante = o.codigoestudiante and odp.codigoperiodo = 20202 ".
                    " and odp.codigoestadoordenpago in (40, 41, 44, 52) group by odp.codigoestudiante ".
                    " )".
                " group by o.numeroordenpago limit 50 ";
                $datoscargas = $db->GetAll($sqlcargas);

                return $datoscargas;
            }
          ?>
        </div>
    </body>
</html>