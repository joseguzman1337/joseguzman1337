<?php
require_once(PATH_ROOT.'/serviciosacademicos/consulta/generacionclaves.php');
require_once(PATH_ROOT.'/sala/entidadDAO/OrdenPagoDAO.php');
require_once(PATH_ROOT.'/sala/entidadDAO/PrematriculaDAO.php');
require_once(PATH_ROOT.'/sala/entidadDAO/DetallePrematriculaDAO.php');
require_once(PATH_ROOT.'/sala/entidadDAO/LogTraceIntegracionPsDAO.php');

function InformacionCajaBancos($numeroordenpago, $fechapagoordenpago,$valorordenpago, $origen="people") {
    global $db;
    global $salaobjecttmp;
    global $Configuration;
    global $xml;

    if(empty($db)){
        $db = Factory::createDbo();
        global $db;
    }
    //valor aporte semillas
    $valorAporte = 35000;
    $transaccion = "Pago Caja-Bancos";

    //1 Condicion si existe APORTE VOLUNTARIO PROGRAMA SEMILLAS si no el valorAporte ya esta predefinido anteriormente en 35000
    if(!empty($numeroordenpago)){
        $query = " SELECT vp.valorpecuniario".
            " FROM valorpecuniario vp ".
            "   INNER JOIN concepto c ON (c.codigoconcepto = vp.codigoconcepto) ".
            "   INNER JOIN ordenpago op ON (vp.codigoperiodo = op.codigoperiodo) ".
            " WHERE  vp.codigoestado = 100 ".
            "  AND c.codigoestado = 100 ".
            "  AND c.codigoconcepto = 'C9106'".
            "  AND op.numeroordenpago = ".$db->qstr($numeroordenpago)." ".
            " ORDER BY vp.idvalorpecuniario DESC LIMIT 0,1";
        $valorAporte = $db->GetRow($query);
    }

    //asignacion de valores a variables
    $numeroordenpago = formatearOrden($numeroordenpago);
    $fechapagoordenpago = limpiarComillas($fechapagoordenpago);
    $valorordenpago = limpiarComillas($valorordenpago);
    $dateObj = \DateTime::createFromFormat('Ymd',$fechapagoordenpago);

    //2 Condicion $dateObj devuelve falso genera ERRNUM 4 Formato fecha incorrecta, debe ser YYYYmmdd (20180116)
    if (!$dateObj){
        $dateObj = new DateTime($fechapagoordenpago);
        if (!$dateObj){
            return array(
                'ERRNUM' => 4,
                'DESCRLONG' => 'Formato fecha incorrecta, debe ser YYYYmmdd (20180116) '
            );
        }
    }

    $fechapago =$dateObj->format('Y-m-d');
    $fechahoy=date("Y-m-d");

    $nuevafecha= explode("-", $fechapago);
    $anio=$nuevafecha[0];
    $mes=$nuevafecha[1];
    $dia=$nuevafecha[2];

    $envio = "INVOICE_ID =$numeroordenpago,  TRANSFER_DT=$fechapago TOTAL_BILL=$valorordenpago";
    #3 Condicion , valida el formato de la fecha y pregunta si la fecha pagada es menor o igual a la fecha actual
    if(checkdate((int) $mes, (int) $dia, (int) $anio) && $fechapago<=$fechahoy){
        $ordenpagoDAO = new \Sala\entidadDAO\OrdenPagoDAO();
        $row_dataOrdenPago = $ordenpagoDAO->getNumeroOrdenes($numeroordenpago);

        //3.1 Condicion valida si la orden que se intenta pagar no existe existe en sala para enviarla a sala virtual
        if(empty($row_dataOrdenPago['numeroOrdenes'])){
            // se envia a sala virtual para comprobar
            // 1. se obtiene la url por enviar
            $basicUrl = $Configuration->getHTTP_ROOT();
            $virtualUrl = $basicUrl.'/serviciosacademicos/consulta/interfacespeople/pagocajabanco/interfaz_pago_caja_bancos.php';
            $virtualUrl = str_replace('artemisa','artemisavirtual',$virtualUrl);
            $virtualUrl = $virtualUrl."?wsdl";

            // 2. cambiar la informacion parametrizada
            $xml = str_replace('artemisa','artemisavirtual',$xml);
            // 3. Realizar la conexion

            $SOAPAction =  str_replace('artemisa','artemisavirtual',$_SERVER['HTTP_SOAPACTION']);

            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, $virtualUrl);

            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'SOAPAction: '. $SOAPAction,
                'Content-Type: text/xml;charset=UTF-8'
            ));

            curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);

            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $curl_output = curl_exec ($ch);

            curl_close ($ch);

            //validacion de errnum
            $pos1 = strpos($curl_output,'<ERRNUM xsi:type="xsd:string">');

            $errorNum = substr($curl_output,$pos1,31);
            $errorNum = substr($errorNum,30,1);

            //validacion de descripcion
            $pos2 = strpos($curl_output, '<DESCRLONG xsi:type="xsd:string">');
            $pos3 = strpos($curl_output, "</DESCRLONG>");

            $errorDesc = substr($curl_output,$pos2+33,$pos3-$pos2-33);

            return array(
                'ERRNUM' => $errorNum,
                'DESCRLONG' => $errorDesc
            );

        }
        //3.2 Condicion Cuando la orden existe en sala y comienza el proceso de pago
        else{
            #3.2.1 Condicion  consulta la orden  en sala, y se valida que venga exactamente el mismo valor por el que se creo o superior
            $sql = " SELECT o.idprematricula, o.codigoperiodo, o.numeroordenpago, "
                . " o.codigoestadoordenpago, fop.valorfechaordenpago AS valorapagar,  "
                . " o.idprematricula"
                . " FROM ordenpago o "
                . " INNER JOIN fechaordenpago fop ON (fop.numeroordenpago = o.numeroordenpago) "
                . " WHERE o.numeroordenpago = ".$db->qstr($numeroordenpago)
                . " AND (fop.valorfechaordenpago <= (".$db->qstr($valorordenpago)."))";

            $row_data = $db->GetRow($sql);

            //3.2.2 Condicion  si el resultado de la consulta el verdadero define un estado pago para la orden
            if(!empty($row_data)){
                $valorOrdenpagoSala = $row_data["valorapagar"];// valor fecha ordenpago sala0.
                $codigoEstadoOrden = $row_data['codigoestadoordenpago'];
                $digito1 = ereg_replace("^[0-9]{1,1}", "", $row_data['codigoestadoordenpago']);
            }
            
            //3.2.3 Condicion para cambios de estado de orden  EJ: 10 a 40 o 11 a 41
            if(!empty($row_data['codigoestadoordenpago']) ){
                $queryHomologacion = "SELECT codigoEstadoPrematricula 
                                          FROM homologacionWSPagoCajaBancos "
                    . " WHERE codigoEstado = '100' AND codigoEstadoOrdenPago = ".$db->qstr($row_data['codigoestadoordenpago']);
                $data = $db->Execute($queryHomologacion);
                //3.2.3.1 Condicion si la tabla de homologacion tiene datos devolvera un codigo de estado
                if(!empty($data)){
                    $datos = $data->FetchRow();
                }
                //3.2.3.2 Condicion Su se obtienen resultados de $data se reasigna la variable digito y con el codigo de estado correspondiente de lo contrario genera errornum 5 SQl 1
                if(!empty($datos['codigoEstadoPrematricula'])){
                    $digito = $datos['codigoEstadoPrematricula'];
                }else{
                    return array( 'ERRNUM' =>5, 'DESCRLONG' => 'Error SQL 1: vacio en tabla homologacionWSPagoCajaBancos' );
                }
            }else{
                $digito = null;
            }
            //3.2.4 Condicion diferencia de valororden people y valor a pagar de sala, si el valorOrdenPeople es menor al valor de pago en sala devuelve falso
            $validacionValorPagado = validarValorPagado(@$valorordenpago, @$row_data['valorapagar'], $valorAporte);
            //valida si la orden esta pagada
            //3.2.5 Condicion, si la orden esta paga procede a actualizar carga academica (prematricula - detalleprematricula)
            if($row_data['codigoestadoordenpago']==40 || $row_data['codigoestadoordenpago']==41){
                //3.2.5.1 Condicion,si el id de prematricula es diferente a 1 esto significa que tiene una prematricula asignada
                if($row_data['idprematricula'] != '1'){
                    $sqlpremtraicula = "SELECT codigoestadoprematricula FROM prematricula WHERE idprematricula = '".$row_data['idprematricula']."'";
                    $estadoprematricula = $db->GetRow($sqlpremtraicula);
                    //3.2.5.1.1 Condicion si esta activa o aprobada por la facultad.
                    if($estadoprematricula['codigoestadoprematricula'] == '10' || $estadoprematricula['codigoestadoprematricula'] == '30'){
                        $preMatricula = new \Sala\entidadDAO\PrematriculaDAO();
                        $preMatricula->update($row_data['idprematricula'], 40);//actualiza la prematricula a 40
                        $estadoprematricula['codigoestadoprematricula'] = 40;
                    }
                    //3.2.5.1.2 Condicion, cuando la prematricula esta en estado 40 matriculada
                    if($estadoprematricula['codigoestadoprematricula'] == 40){
                        //si el detalleprematricula esta pagado procede a la revision del detalle de la prematricula
                        $sqldetalleprematricula = "SELECT idDetallePrematricula, codigoestadodetalleprematricula 
                                                       FROM detalleprematricula ".
                            " WHERE idprematricula = '".$row_data['idprematricula']."' AND numeroordenpago =".$db->qstr($numeroordenpago);
                        $materias = $db->GetAll($sqldetalleprematricula);
                        foreach($materias as $materia){
                            //3.2.5.1.2.1 Condicion, cuando la materia esta en estado 10 activa la matricula
                            if($materia['codigoestadodetalleprematricula'] == '10'){
                                //matricula la materia
                                $updatedetalle = "UPDATE detalleprematricula SET ".
                                    " codigoestadodetalleprematricula = 30 WHERE idDetallePrematricula= '".$materia['idDetallePrematricula']."'";
                                $db->Execute($updatedetalle);
                            }
                        }
                    }
                }
                $log = new \Sala\entidadDAO\LogTraceIntegracionPsDAO();
                $envio = "INVOICE_ID =$numeroordenpago,  TRANSFER_DT=$fechapago TOTAL_BILL=$valorordenpago";
                $parametros = "ERRNUM=0, DESCRLONG=OK";
                $log->setLog($numeroordenpago, $envio, $transaccion, $parametros, '1');
                return array(
                    'ERRNUM' =>0,
                    'DESCRLONG' => 'Ok'
                );
            }
            //3.2.6 Condicion, Valor diferente al que hay que pagar
            elseif(!empty($row_data) && (!$validacionValorPagado)){
                $log = new \Sala\entidadDAO\LogTraceIntegracionPsDAO();
                $parametros = "ERRNUM=3, DESCRLONG = Valor pagado diferente a valor en Orden Pago";
                $log->setLog($numeroordenpago, $envio, $transaccion, $parametros, '1');
                return array(
                    'ERRNUM' => 3,
                    'DESCRLONG' => 'valor pago diferente:'.$valorordenpago.'--'.$row_data['valorapagar'].' '
                );
            }
            //3.2.7 Condicion, actualizacion de orden y prematricula
            else{
                //3.2.7 Condicion, si los resultados de la orden son correctos actualiza a estado pago
                if(!empty($row_data)) {
                    $ordenPagoDAO = new \Sala\entidadDAO\OrdenPagoDAO();
                    $ordenPagoDAO->update($numeroordenpago, $digito, $fechapago);
                    //3.2.7.1 Condicion,si es diferente de id 1 actualiza la prematricula y el detalle prematricula
                    if ($row_data['idprematricula'] != '1') {
                        $preMatricula = new \Sala\entidadDAO\PrematriculaDAO();
                        $prematricula = $preMatricula->update($row_data['idprematricula'], 40);

                        if (empty($prematricula)) {
                            return array('ERRNUM' => 5,
                                'DESCRLONG' => 'Actualizar prematricula a 40');
                            exit();
                        }

                        //actualizacion de  detalleprematricula
                        $detallePreMatricula = new \Sala\entidadDAO\DetallePrematriculaDAO();
                        $resultadodetalle = $detallePreMatricula->update($numeroordenpago, 30, $row_data['idprematricula'], 10);

                        if (empty($resultadodetalle)) {
                            return array('ERRNUM' => 5, 'DESCRLONG' => 'Error SQL 2 : Actualizacion prematricula');
                        }
                    }

                    $query_conceptoorden = "SELECT do.codigoconcepto 
                                                FROM detalleordenpago do,concepto c " .
                        " WHERE do.numeroordenpago = '$numeroordenpago' AND do.codigoconcepto = c.codigoconcepto " .
                        " AND c.cuentaoperacionprincipal = '153'";// concepto inscripcion
                    $conceptoorden = $db->Execute($query_conceptoorden) or die("$query_conceptoorden" . mysql_error());
                    $totalRows_conceptoorden = $conceptoorden->RecordCount();
                    $row_conceptoorden = $conceptoorden->FetchRow();

                    //consulta de usuario
                    $query = "SELECT u.usuario FROM ordenpago op " .
                        " JOIN estudiante e USING(codigoestudiante) " .
                        " JOIN estudiantegeneral eg USING(idestudiantegeneral) " .
                        " JOIN usuario u USING(numerodocumento) WHERE op.numeroordenpago='$numeroordenpago'";
                    $reg_exec = $db->Execute($query);
                    //3.2.7.2 validacion usuario en sala si no existe lo intenta crear en sala
                    if ($reg_exec->NumRows() == 0) {
                        //CREA CUENTA CORREO
                        $objetoclaveusuario = new GeneraClaveUsuario($numeroordenpago, $salaobjecttmp);
                    }
                    //3.2.7.3 Condicion, validacion de conceptos de inscripcion
                    if ($row_conceptoorden <> "") {
                        //consulta el maximo id de inscripcion
                        $query_inscripcionorden = "SELECT MAX(i1.idinscripcion) maxidinscripcion " .
                            " FROM ordenpago op1 " .
                            " INNER JOIN estudiante e1 ON (op1.codigoestudiante = e1.codigoestudiante) " .
                            " INNER JOIN inscripcion i1 ON (e1.idestudiantegeneral = i1.idestudiantegeneral) " .
                            " INNER JOIN estudiantecarrerainscripcion ec1 ON (e1.codigocarrera = ec1.codigocarrera AND i1.idinscripcion = ec1.idinscripcion) " .
                            " WHERE op1.numeroordenpago = '" . $numeroordenpago . "' AND e1.codigoperiodo = '" . $row_data['codigoperiodo'] . "'";
                        $inscripcionorden = $db->Execute($query_inscripcionorden);
                        //3.2.7.3.1 Condicion, si el resultado de la consulta es vacio entonces crea el erro para people
                        if (empty($inscripcionorden)) {
                            return array('ERRNUM' => 5, 'DESCRLONG' => 'Error SQL 3: No existe Inscripcion para estudiante');
                        }
                        $row_inscripcionorden = $inscripcionorden->FetchRow();
                        //actualizacion de inscripcion
                        $query_inscripcion = "UPDATE ordenpago o,estudiante e,inscripcion i, " .
                            " estudiantecarrerainscripcion ec SET i.codigosituacioncarreraestudiante = '107', " .
                            " e.codigosituacioncarreraestudiante = '107', e.codigoperiodo = '" . $row_data['codigoperiodo'] . "' " .
                            " WHERE o.codigoestudiante = e.codigoestudiante AND e.idestudiantegeneral = i.idestudiantegeneral " .
                            " AND e.codigocarrera = ec.codigocarrera AND i.idinscripcion = ec.idinscripcion " .
                            " AND o.numeroordenpago = '$numeroordenpago' AND i.idinscripcion ='" . $row_inscripcionorden['maxidinscripcion'] . "' " .
                            " AND o.codigoperiodo = i.codigoperiodo";
                        $inscripcion = $db->Execute($query_inscripcion);
                        //3.2.7.3.1 Condicion, si no surge ninguna modificacion en los registros de estudiante, inscripcionordenpago
                        if (empty($inscripcion)) {
                            return array('ERRNUM' => 5, 'DESCRLONG' => 'Error SQL 4: No se  Actualizo  la Inscripcion');
                        }
                    }

                    $ordenpagoDAO = new \Sala\entidadDAO\OrdenPagoDAO();
                    $estado = "4$digito1";
                    #paga orden en sala
                    $ordenpago = $ordenpagoDAO->update($numeroordenpago, $estado, $fechapago);
                    //3.2.7.4 Condicion Sin cambios para la actualizacion,
                    if (empty($ordenpago)) {
                        return array('ERRNUM' => 5, 'DESCRLONG' => 'Error SQL 5: no se Actualizo el Estado de la Orden');
                    }
                    // ************************************************************************************************
                    // SE PAGA LA ORDEN EN SALA. SE REGISTRA EN EL TRACE Y SE ACTUALIZA EL ESTADO EN LA TABLA DE CONTROL
                    $log = new \Sala\entidadDAO\LogTraceIntegracionPsDAO();
                    $parametros = "ERRNUM=0, DESCRLONG=OK";
                    $log->setLog($numeroordenpago, $envio, $transaccion, $parametros, '1');

                    if ($origen == "people") {
                        $db->Execute("UPDATE controlreportepagospeoplesala SET fechaactualizacionreporte=now(),errnum=0,descrlong='Ok' WHERE numeroordenpago='$numeroordenpago'");
                        // ************************************************************************************************
                    }

                    // Verifica si esa orden tiene descuentos
                    $query_detalleorden = "SELECT d.codigoconcepto,d.valorconcepto,o.codigoperiodo,o.codigoestudiante " .
                        " FROM ordenpago o,detalleordenpago d " .
                        " WHERE o.numeroordenpago = '$numeroordenpago' AND o.numeroordenpago = d.numeroordenpago " .
                        " AND d.codigotipodetalleordenpago = 2";
                    $detalleorden = $db->Execute($query_detalleorden);

                    if (empty($detalleorden)) {
                        return array('ERRNUM' => 5, 'DESCRLONG' => 'Error SQL 6: No Contiene Ningun Descuento');
                    }

                    while ($row_detalleorden = $detalleorden->FetchRow()) {
                        $query_consultadvd = "SELECT iddescuentovsdeuda FROM descuentovsdeuda " .
                            " WHERE codigoestudiante = '" . $row_detalleorden['codigoestudiante'] . "' " .
                            " AND codigoestadodescuentovsdeuda = '01' " .
                            " AND codigoperiodo = '" . $row_detalleorden['codigoperiodo'] . "' " .
                            " AND codigoconcepto = '" . $row_detalleorden['codigoconcepto'] . "' " .
                            " AND valordescuentovsdeuda = '" . $row_detalleorden['valorconcepto'] . "'";
                        $consultadvd = $db->Execute($query_consultadvd) or die("$query_consultadvd" . mysql_error());
                        $totalRows_consultadvd = $consultadvd->RecordCount();
                        $row_consultadvd = $consultadvd->FetchRow();

                        if ($row_consultadvd <> "") {
                            $base3 = "UPDATE descuentovsdeuda SET codigoestadodescuentovsdeuda = '03' " .
                                " WHERE iddescuentovsdeuda = '" . $row_consultadvd['iddescuentovsdeuda'] . "'";
                            $sol3 = $db->Execute($base3);

                            if (empty($sol3)) {
                                return array('ERRNUM' => 5, 'DESCRLONG' => 'Error SQL 7: Problemas al Actualizar Descuentos');
                            }
                        }
                    }

                    /* Si Existe plan de pagos  */
                    $query_plan = "SELECT * FROM ordenpagoplandepago " .
                        " WHERE numerorodencoutaplandepagosap = '$numeroordenpago'";
                    $plan = $db->Execute($query_plan);

                    if (empty($plan)) {
                        return array('ERRNUM' => 5, 'DESCRLONG' => 'Error SQL 8: La Orden no Pertenece a un Plan de Pagos');
                    }
                    $row_plan = $plan->FetchRow();

                    if ($row_plan <> "") { //if 2 validaciones orden plan de pagos
                        $numeroordenpago = $row_plan['numerorodenpagoplandepagosap'];
                        $query = "SELECT u.usuario FROM ordenpago op " .
                            " JOIN estudiante e USING(codigoestudiante) " .
                            " JOIN estudiantegeneral eg USING(idestudiantegeneral) " .
                            " JOIN usuario u USING(numerodocumento) " .
                            " WHERE op.numeroordenpago='$numeroordenpago'";
                        $reg_exec = $db->Execute($query);
                        if ($reg_exec->NumRows() == 0) {
                            //CREA CUENTA CORREO
                            $objetoclaveusuario = new GeneraClaveUsuario($numeroordenpago, $salaobjecttmp);
                        }

                        //actualiza detalleprematricula----
                        $detallePreMatricula = new \Sala\entidadDAO\DetallePrematriculaDAO();
                        $resultadodetalle = $detallePreMatricula->update($numeroordenpago, 30, "",10);

                        if (empty($resultadodetalle)) {
                            return array('ERRNUM' => 5, 'DESCRLONG' => 'Error SQL 9: No es Posible Actualizar el Detalle de la Prematricula');
                        }

                        //actualiza plan de pagos
                        $query_planes = "UPDATE ordenpagoplandepago " .
                            " SET codigoindicadorprocesosap	= '300' " .
                            " WHERE numerorodencoutaplandepagosap = '" . $row_plan['numerorodencoutaplandepagosap'] . "'";
                        $planes = $db->Execute($query_planes);

                        if (empty($planes)) {
                            return array('ERRNUM' => 5, 'DESCRLONG' => 'Error SQL 10: No fue Posible actualiza  Orden Pago Plan de Pagos');
                        }

                        //consulta conceptos
                        $query_conceptoorden = "SELECT do.codigoconcepto FROM detalleordenpago do,concepto c " .
                            " WHERE do.numeroordenpago = '$numeroordenpago' AND do.codigoconcepto = c.codigoconcepto " .
                            " AND c.cuentaoperacionprincipal = '153'";
                        $conceptoorden = $db->Execute($query_conceptoorden);

                        if (empty($conceptoorden)) {
                            return array('ERRNUM' => 5, 'DESCRLONG' => 'Error SQL 11: No Hay Concepto  Detalle Orden Pago');
                        }

                        $totalRows_conceptoorden = $conceptoorden->RecordCount();
                        $row_conceptoorden = $conceptoorden->FetchRow();

                        if ($row_conceptoorden <> "") {
                            //consulta maximo de inscripcion
                            $query_conceptoorden = "SELECT MAX(i1.idinscripcion) maxidinscripcion " .
                                " FROM ordenpago op1,estudiante e1,inscripcion i1,estudiantecarrerainscripcion ec1 " .
                                " WHERE op1.codigoestudiante = e1.codigoestudiante " .
                                " AND e1.idestudiantegeneral = i1.idestudiantegeneral " .
                                " AND e1.codigocarrera = ec1.codigocarrera " .
                                " AND i1.idinscripcion = ec1.idinscripcion " .
                                " AND op1.numeroordenpago = '" . $numeroordenpago . "' " .
                                " AND e1.codigoperiodo = '" . $row_data['codigoperiodo'] . "'";
                            $inscripcionorden = $db->Execute($query_conceptoorden);

                            if (empty($inscripcionorden)) {
                                return array('ERRNUM' => 5, 'DESCRLONG' => 'Error SQL 12:  Problemas al Encontrar la Maxima Inscripcion del estudiante - orden plan de pago');
                            }

                            $row_inscripcionorden = $conceptoorden->FetchRow();

                            //actuliza inscripciones
                            $query_inscripcion = "UPDATE ordenpago o,estudiante e,inscripcion i, " .
                                "estudiantecarrerainscripcion ec  SET i.codigosituacioncarreraestudiante = '107', " .
                                " e.codigosituacioncarreraestudiante = '107', " .
                                " e.codigoperiodo = '" . $row_data['codigoperiodo'] . "' " .
                                " WHERE o.codigoestudiante = e.codigoestudiante " .
                                " AND e.idestudiantegeneral = i.idestudiantegeneral AND e.codigocarrera = ec.codigocarrera " .
                                " AND i.idinscripcion = ec.idinscripcion AND o.numeroordenpago = $numeroordenpago " .
                                " AND i.idinscripcion ='" . $row_inscripcionorden['maxidinscripcion'] . "' " .
                                " AND o.codigoperiodo = i.codigoperiodo";
                            $inscripcion = $db->Execute($query_inscripcion);

                            if (empty($inscripcion)) {
                                return array('ERRNUM' => 5, 'DESCRLONG' => 'Error SQL 13: Error SQL 4: No Fue Posible  Actualizar La Inscripcion Plan de Pago');
                            }
                        } // if 2

                        //actualiza ordenpago
                        $ordenpagoDAO = new \Sala\entidadDAO\OrdenPagoDAO();
                        $estado = "4$digito1";
                        $ordenpago = $ordenpagoDAO->update($numeroordenpago, $estado, $fechapago);

                        if (empty($ordenpago)) {
                            return array('ERRNUM' => 5, 'DESCRLONG' => 'Error SQL 14: No Fue Posible Actualizar Orden');
                        }

                        // ************************************************************************************************
                        // SE PAGA LA ORDEN PADRE EN SALA. SE REGISTRA EN EL TRACE Y EN LA TABLA DE CONTROL TAMBIEN SE
                        // REGISTRA EL PAGO, YA QUE DESDE PS SOLO LLEGA LA ORDEN HIJA, MAS NO LA PADRE
                        $log = new \Sala\entidadDAO\LogTraceIntegracionPsDAO();
                        $parametros = "ERRNUM=0, DESCRLONG=Ok, se realiza el pago de la orden padre";
                        $log->setLog($numeroordenpago, $envio, $transaccion, $parametros, '1');
                        // ************************************************************************************************

                        // Verifica si esa orden tiene descuentos

                        $query_detalleorden = "SELECT d.codigoconcepto,d.valorconcepto,o.codigoperiodo, " .
                            " o.codigoestudiante FROM ordenpago o,detalleordenpago d " .
                            " WHERE o.numeroordenpago = '$numeroordenpago' AND o.numeroordenpago = d.numeroordenpago " .
                            " AND d.codigotipodetalleordenpago = 2";
                        $detalleorden = $db->Execute($query_detalleorden);

                        if (empty($detalleorden)) {
                            return array('ERRNUM' => 5, 'DESCRLONG' => 'Error SQL 15: orden sin descuento');
                        }

                        while ($row_detalleorden = $detalleorden->FetchRow()) {
                            $query_consultadvd = "SELECT iddescuentovsdeuda FROM descuentovsdeuda " .
                                " WHERE codigoestudiante = '" . $row_detalleorden['codigoestudiante'] . "' " .
                                " AND codigoestadodescuentovsdeuda = '01' " .
                                " AND codigoperiodo = '" . $row_detalleorden['codigoperiodo'] . "' " .
                                " AND codigoconcepto = '" . $row_detalleorden['codigoconcepto'] . "' " .
                                " AND valordescuentovsdeuda = '" . $row_detalleorden['valorconcepto'] . "'";
                            $consultadvd = $db->Execute($query_consultadvd);

                            if (empty($consultadvd)) {
                                return array('ERRNUM' => 5, 'DESCRLONG' => 'Error SQL 16: no se Encontrol el Descuento en Descuento vs Deuda');
                            }

                            $totalRows_consultadvd = $consultadvd->RecordCount();
                            $row_respuestadvd = $consultadvd->FetchRow();

                            if ($row_respuestadvd <> "") {
                                $base3 = "UPDATE descuentovsdeuda SET  codigoestadodescuentovsdeuda = '03' " .
                                    " WHERE iddescuentovsdeuda = '" . $row_respuestadvd['iddescuentovsdeuda'] . "'";
                                $sol3 = $db->Execute($base3);

                                if (empty($sol3)) {
                                    return array('ERRNUM' => 5, 'DESCRLONG' => 'Error SQL 17: Actualizacion Descuento vs Deuda no Actualizada');
                                }
                            }
                        }
                    }// fin if 2 validaciones orden plan de pagos

                    return array(
                        'ERRNUM' => 0,
                        'DESCRLONG' => 'Ok'
                    );
                }else{
                    return array(
                        'ERRNUM' => 5,
                        'DESCRLONG' => 'Error SQL 18: Valor orden Incorrecto'
                    );
                }
            }
        }//else
    }else{
        // ************************************************************************************************
        // ORDEN DE PAGO CON FECHA INCORRECTA. SE REGISTRA EN EL TRACE Y SE ACTUALIZA EL ESTADO EN LA TABLA DE CONTROL
        $log = new \Sala\entidadDAO\LogTraceIntegracionPsDAO();
        $parametros = "ERRNUM=2, DESCRLONG= Fecha Pago mayor a Fecha Actual";
        $log->setLog($numeroordenpago, $envio, $transaccion, $parametros, '1');
        // ************************************************************************************************
        return array(
            'ERRNUM' => 2,
            'DESCRLONG' => 'Fecha incorrecta'
        );
    }//else
}//function InformacionCajaBancos

function limpiarComillas($var){
    return str_replace('"','',str_replace("'","",trim($var)));
}//limpiarComillas

function formatearOrden($var){
    $pos = strpos($var, "-CC");

    if ($pos !== false) {
        $t = explode("-CC", $var);
        $var = $t[0];
    }
    $var = limpiarComillas($var);
    return $var;
}//formatearOrden

function validarValorPagado($valorordenpago,$valorapagar,$valorAporte){
    $return = true;

    if($valorordenpago != $valorapagar){
        if(((int)$valorordenpago-(int)$valorAporte) != $valorapagar){
            if($valorordenpago < $valorapagar){
                $return = false;
            }
        }
    }

    return $return;
}//validarValorPagado
