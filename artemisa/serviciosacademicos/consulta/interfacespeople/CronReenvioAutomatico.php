<?php

    if(isset($_GET['debug']) && !empty($_GET['debug'])) {
        echo "<br>errores<br>";
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }
    require_once(realpath(dirname(__FILE__) . "/../../../sala/includes/adaptador.php"));
    require_once(PATH_ROOT . '/serviciosacademicos/consulta/interfacespeople/funcionesPS.php');
    require_once(PATH_ROOT . '/sala/entidadDAO/ColaNotificacionPagoPsDAO.php');

    $fechaanio = date('Y');
    $fechames= date('m');
    $fechadia= date('d');
    $fechahora= date('h:m');
    $fechaaniomes= $fechaanio.'-'.$fechames;
    $mesAnterior = date( "m", strtotime( $fechaaniomes." -1 month" ) );
    $ultimoDiaMesAnterior= date("d",(mktime(0,0,0,$mesAnterior+1,1,$fechaanio)-1));

    $fecha = new DateTime();
    $fecha->modify('last day of this month');
    $ultimoDiaMesActual = $fecha->format('d');

 //Comienzo Ejecucion del Cron
                //Pagos de ordenes de pago fallidos
                    $DatosPagos = BuscarPagosFallidos($db,$fechaanio, $fechames,$ultimoDiaMesAnterior, $mesAnterior, $ultimoDiaMesActual);

                    if (!empty($DatosPagos) && count($DatosPagos) > 0) {
                        foreach ($DatosPagos as $valores) {
                            $colaNotificacionPago = new \Sala\entidadDAO\ColaNotificacionPagoPsDAO();
                            $banderaEnvioPeople = $colaNotificacionPago->getOrderInProcess($valores['numeroordenpago']);
                    
                        if($banderaEnvioPeople == 0 || $banderaEnvioPeople == 1){
                         reportarPagoPSE($db, $valores['numeroordenpago'],$valores['TicketId']);
                         }
                        }
                    }
                
                //Pagos pendientes no reportados
                    $DatosPagos = BuscarPagosPsePendientes($db, $fechaanio, $fechames, $ultimoDiaMesAnterior, $mesAnterior, $ultimoDiaMesActual);
                    if (!empty($DatosPagos) && count($DatosPagos) > 0) {
                        foreach ($DatosPagos as $valores) {
                            if(isset($valores['numeroordenpago']) && !empty($valores['numeroordenpago'])) {
                                $colaNotificacionPago = new \Sala\entidadDAO\ColaNotificacionPagoPsDAO();
                                $banderaEnvioPeople = $colaNotificacionPago->getOrderInProcess($valores['numeroordenpago']);
                                if($banderaEnvioPeople == 0 || $banderaEnvioPeople == 1){
                                reportarPagoPSE($db, $valores['numeroordenpago'],$valores['TicketId']);
                                }
                            }
                        }
                    }

                //pagos incompletos
                    $DatosPagos = BuscarPagosIncompletos($db);
                    if (!empty($DatosPagos) && count($DatosPagos) > 0) {
                        foreach ($DatosPagos as $pagos) {
                            AplicarPagoSala($db, $pagos);
                        }
                    }
               
                //Creacion Pendientes
                        $DatosCreaciones = BuscarCreacionesPendientes($db, $fechaanio, $fechames);
                        if (!empty($DatosCreaciones)) {
                            foreach ($DatosCreaciones as $valores) {
                                if(isset($valores['numeroordenpago']) && !empty($valores['numeroordenpago'])) {
                                    estudianteOrden($db, $valores['numeroordenpago']);
                                }
                            }
                        }
                //Creacion de ordenes fallidas
                    $Datos = BuscarCreacionFallidas($db, $fechaanio, $fechames);
                    if (!empty($Datos) && count($Datos) > 0) {
                        foreach ($Datos as $valores) {
                           estudianteOrden($db, $valores['numeroordenpago']);
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

            function BuscarPagosPsePendientes($db, $fechaanio, $fechames, $ultimoDiaMesAnterior, $mesAnterior, $ultimoDiaMesActual){
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
                " where lp.SoliciteDate between '".$fechaanio."-".$mesAnterior."-".$ultimoDiaMesAnterior." 17:05:00' and '".$fechaanio."-".$fechames."-".$ultimoDiaMesActual." 17:00:00'".
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

            function BuscarPagosFallidos($db, $fechaanio, $fechames, $ultimoDiaMesAnterior, $mesAnterior,$ultimoDiaMesActual){
                $sql ="SELECT l.respuestalogtraceintegracionps, l.documentologtraceintegracionps as numeroordenpago, lp.TicketId".
                " FROM logtraceintegracionps l ".
                " inner join ordenpago o on (l.documentologtraceintegracionps = o.numeroordenpago )".
                " inner join LogPagos lp on (lp.Reference1 = o.numeroordenpago and lp.StaCode = 'OK')".
                " WHERE l.transaccionlogtraceintegracionps IN ('Informa Pago PSE') ".
                " and lp.SoliciteDate between '".$fechaanio."-".$mesAnterior."-".$ultimoDiaMesAnterior." 17:05:00' and '".$fechaanio."-".$fechames."-".$ultimoDiaMesActual." 17:00:00'".
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
?>
