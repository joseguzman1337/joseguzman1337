<?php
/**
* @modifed Ivan dario quintero rios <quinteroivan@unbosque.edu.co>
* @since Mayo 8 del 2019
* Creacion de archivo para gestion de funciones
*/

class controladorFunciones {
    //funcion que permite crear registro en el log
    public function registrarLog($db,$transaccion, $row, $result){
        $fecha = date("d-m-Y");
        if(isset($result['PaymentDesc'])){
            $paymentdesc = $result['PaymentDesc'];
        }else{
            $paymentdesc = " -- ";
        }
        if(isset($result['TransVatValue'])){
            $transvatvalue= $result['TransVatValue'];
        }else{
            $transvatvalue= " -- ";
        }
        
        $respuesta = "Ejecuto en: ".$fecha." - TicketId: ".$row." - TrazabilityCode: ".$result['TrazabilityCode']
        ."  - TranState: OK - SrvCode: 100 - PaymentDesc: ".$paymentdesc." - TransValue: ".$result['TransValue']
        ." - TransVatValue: ".$transvatvalue." - Reference1: ".$result['Reference1']." - Reference2: ".$result['Reference2']
        ." - Reference3: ".$result['Reference3']." - BankProcessDate: ".$result['BankProcessDate']." - BankName: ".$result['BankName']
        ." - ReturnCode: ".$result['ReturnCode']."\n"; 
        
        $query_logps="INSERT INTO LogTraceIntegracionAgentBank (Transaccion, NumeroOrdenPago, ".
        " DocumentoEstudiante, RespuestaTransaccion) VALUES( '".$transaccion."','".$result['Reference1']."', '".$result['Reference2']."', '".$respuesta."')";
        return is_object($db->Execute($query_logps));
    }
    //funcion que permite la creacion de un archivo de sonda, donde almacena los registros
    public function escribeLog($cadena) {
        $fecha = date("d-m-Y");
        $archivo = "SondaUBosque-" . $fecha . ".log";
        $fp = fopen($archivo, "a");
        $write = fputs($fp, $cadena);
        fclose($fp);
    }
    //funcion que permite actualizar el estado de la orden de pago
    public function updateEstadoPago($db,$val,$digito, $id){
        $strConsulta = "UPDATE ordenpago SET codigoestadoordenpago = '".$id."".$digito."' WHERE numeroordenpago ='".$val."';";          
        return is_object($db->Execute($strConsulta));

    }//function updateEstadoPago

    //funcion que permite la actualizacion de la fecha de entrega de la orden 
    public function updateFechaPagoU($db, $orden){
        $fecha = date("Y-m-d");
        $strConsulta = "UPDATE ordenpago SET fechaentregaordenpago = '".$fecha."' WHERE numeroordenpago = '".$orden."';";
        return is_object($db->Execute($strConsulta));
    }//function updateFechaPagoU

    //funcion que permite la actualizacion de la orden en logpagos
    public function updatePagoLog($db, $tk, $r1, $stacode = null, $bp= null, $bn= null, $trc= null, $flagb= null){
        $sqlstacode = ""; $sqlbp= ""; $sqlbn=""; $sqltrc = ""; $flagb= ""; $sqlflag = "";
        if($stacode <> '' || $stacode <> null){
            $sqlstacode = ", StaCode ='".$stacode."' ";
        }
        if($bp <> '' || $bp <> null){
            $sqlbp = ", BankProcessDate ='".$bp."' ";
        }
        if($bn <> '' || $bn <> null){
            $sqlbn = ", FIName ='".$bn."'";
        }
        if($trc <> '' || $trc <> null){
            $sqltrc = ", TrazabilityCode = '".$trc."' ";
        }
        if($flagb <> '' || $flagb <> null){
            $sqlflag = ", FlagButton = '".$flagb." ";
        }
        $strConsulta = "UPDATE LogPagos SET Reference1 = '".$r1."' ".$sqlflag." ".$sqlbp." ".$sqlbn." ". $sqlstacode." ".$sqltrc." ".
        " WHERE TicketId ='".$tk."' ";
        return is_object($db->Execute($strConsulta));
    }//function updatePagoOK

    public function tipoorden($db, $Reference){
        $sqltipo ="SELECT d.codigoconcepto, c.nombreconcepto, d.valorconcepto, c.codigoestado, c.cuentaoperacionprincipal ".
        " FROM detalleordenpago d ".
        " INNER JOIN concepto c on (d.codigoconcepto = c.codigoconcepto) ".
        " WHERE d.numeroordenpago = '".$Reference."' order by d.valorconcepto desc";   
        $resultado = $db->GetRow($sqltipo);

        if(isset($resultado['codigoconcepto'])&& !empty($resultado['codigoconcepto'])){
            return $resultado['cuentaoperacionprincipal'];
        }else{
            return '0';
        }        
    }
    
    public function estadoOrden($db, $Reference1){
        //Consulta de estado de la orden           
        $query_selestadoorden = "select o.codigoestadoordenpago from ordenpago o ".
        " where o.numeroordenpago = '" . $Reference1 . "'";
        $estadoorden = $db->GetRow($query_selestadoorden);
       
        return $estadoorden['codigoestadoordenpago'];
       
    }
    
    public function updatedetalleprematricula($db, $reference1, $estado){
        $and="";
        if($estado <> '10'){
          $and = "and codigoestadodetalleprematricula like '1%';";  
        }
        //Actualiza el detalleprematricula
        $strDetallePrematricula = "UPDATE detalleprematricula SET codigoestadodetalleprematricula = '".$estado."' ".
        " WHERE numeroordenpago = '".$reference1."' ".$and;
        return is_object($db->Execute($strDetallePrematricula));
    }
    
    public function updateprematricula($db, $numeroordenpago, $digitoprematricula ){
        //Actualiza la tabla prematricula
        $strPrematricula = "UPDATE prematricula SET codigoestadoprematricula='4".$digitoprematricula."' WHERE ".
        " idprematricula = (select d.idprematricula from detalleprematricula d ".
        " where d.numeroordenpago = '".$numeroordenpago."' limit 1)";
        return is_object($db->Execute($strPrematricula));
    }
    
    public function estadoprematricula($db, $reference1){
        //Consulta el estado de la orden de prematricula 
        $query_selestadoprematricula =  "SELECT p.codigoestadoprematricula  ".
	" FROM prematricula p INNER JOIN ordenpago o ON (o.idprematricula = p.idprematricula) ".
	" WHERE o.numeroordenpago ='".$reference1."'";
        $estadoprematricula = $db->GetRow($query_selestadoprematricula);
        return  $estadoprematricula['codigoestadoprematricula'];
    }
    
    public function updateplanpagos($db, $numeroordenpagohijo, $estado){
        //Actualiza el estado del plan de pagos a un estado
        $query_planes = "update ordenpagoplandepago set codigoindicadorprocesosap = '".$estado."' ".
        " WHERE numerorodencoutaplandepagosap = '".$numeroordenpagohijo."'";
        return is_object($db->Execute($query_planes));
    }
    
    public function consultaplanpagos($db, $numeroordenpago){
        // Consulta si la orden pertenece a un plan de pagos
        $query_plan = "SELECT codigoestado, numerorodenpagoplandepagosap  FROM ordenpagoplandepago ".
        " WHERE numerorodencoutaplandepagosap = '".$numeroordenpago."' AND codigoestado = 100 ".
        " AND cuentaxcobrarplandepagosap = 'C9013'";             
        $row_plan = $db->GetRow($query_plan); 
        return $row_plan;
    }
    
    //valida que la orden esta pagda en la anterior pasarela de pagos
    public function ordenpagada($db, $referencia){
        $sqllogpago = "select lp.StaCode, lp.TicketId, lp.Reference1, lp.TransValue, ".
        " lp.BankProcessDate, lp.FIName, lp.TrazabilityCode, lp.TransVatValue, lp.SrvCode, lp.StaCode,".
        " o.codigoestadoordenpago, o.codigoestudiante from LogPagos lp ".
        " INNER JOIN ordenpago o on (lp.Reference1 = o.numeroordenpago) ".
        " where lp.reference1='".$referencia."' AND lp.StaCode in ('OK', 'FAILED','CREATED')";
        $listadoorden = $db->GetAll($sqllogpago);
        
        return $listadoorden;
    }
    
    public function detalleorden($db, $numeroordenpago){
        // Consulta para aplicar los descuentos de la orden a validando la tabla descuento vs deudas
        $query_detalleorden = "SELECT d.codigoconcepto,d.valorconcepto,o.codigoperiodo,o.codigoestudiante ".
        " FROM ordenpago o,detalleordenpago d ".
        " WHERE o.numeroordenpago = '".$numeroordenpago."' ".
        " AND o.numeroordenpago = d.numeroordenpago ".
        " AND d.codigotipodetalleordenpago = '2'";
        $detalleorden = $db->GetAll($query_detalleorden);
        return $detalleorden;
    }
    
    public function ConsultarDescuentos($db, $codigoestudiante, $codigoperiodo, $codigoconcepto, $valorconcepto){
        $query_consultadvd = "SELECT iddescuentovsdeuda FROM descuentovsdeuda ".
        " WHERE codigoestudiante = '".$codigoestudiante."' ".
        " and codigoestadodescuentovsdeuda = '01' ".
        " and codigoperiodo = '".$codigoperiodo."' ".
        " and codigoconcepto = '".$codigoconcepto."' ".
        " and valordescuentovsdeuda = '".$valorconcepto."' ";
        $consultadvd = $db->GetRow($query_consultadvd);
        
        if (isset($consultadvd['iddescuentovsdeuda']) && !empty($consultadvd['iddescuentovsdeuda'])) {
            //Actualiza el descuento
            $base3 = "update descuentovsdeuda ".
            " set  codigoestadodescuentovsdeuda = '03'  ".
            " where iddescuentovsdeuda = '" . $consultadvd['iddescuentovsdeuda'] . "'";

            return is_object($db->Execute($base3));
        }
    }
    //funcion de retorno de mensaje
    public function ReturnCodeDesc($cadena, $referencia1, $ticket, $origen) {
        $strMensaje ="";
        switch ($cadena) {
            case "OK":{
                $strMensaje="La transacción fue APROBADA en la Entidad Financiera";
            }break;
            case "PENDING":{
                if(isset($origen) && $origen!=''){
                    $strMensaje="En este momento su orden de pago ".$referencia1." ".
                    " presenta un proceso de pago cuya transacción se encuentra PENDIENTE de recibir ".
                    " confirmación por parte de su entidad financiera, por favor espere unos minutos y ".
                    " vuelva a consultar más tarde para verificar si su pago fue confirmado de forma exitosa. ".
                    " Si desea mayor información sobre el estado actual de su operación puede comunicarse a ".
                    " nuestras líneas de atención al cliente al teléfono 6489000 ext 1555 o enviar sus inquietudes ".
                    " al correo helpdesk@unbosque.edu.co y pregunte por el estado de la transaccion: ".$ticket." ";
                }else{
                    $strMensaje="La transacción se encuentra PENDIENTE. Por favor verificar si el débito fue realizado en el Banco.";
                }
            }break;
            case "FAILED":{
                $strMensaje="La transacción fué FALLIDA";
            }break;
            case "FAIL_INVALIDENTITYCODE":{
                $strMensaje="La transacción fué FALLIDA";
            }break;
            case "NOT_AUTHORIZED":{
                $strMensaje="La transacción fué RECHAZADA por la Entidad Financiera";
            }break;
            default:{
                if(isset($origen)&& $origen!=''){
                    $strMensaje="En este momento su orden de pago ".$referencia1." ".
                    " presenta un proceso de pago cuya transacción se encuentra PENDIENTE de recibir ".
                    " confirmación por parte de su entidad financiera, por favor espere unos minutos y ".
                    " vuelva a consultar más tarde para verificar si su pago fue confirmado de forma exitosa. ".
                    " Si desea mayor información sobre el estado actual de su operación puede comunicarse a ".
                    " nuestras líneas de atención al cliente al teléfono 6489000 ext 1555 o enviar sus inquietudes ".
                    " al correo helpdesk@unbosque.edu.co y pregunte por el estado de la transaccion: ".$ticket." ";
                }else{
                    $strMensaje="La transacción se encuentra PENDIENTE. Por favor verificar si el débito fue realizado en el Banco.";
                }
            }break;
        }//switch
        return $strMensaje;
    }//getReturnCodeDesc
    
    public function nombre($db, $reference2) {
        $strConsulta = "SELECT nombresestudiantegeneral, apellidosestudiantegeneral FROM estudiantegeneral WHERE ".
        " numerodocumento = '".$reference2."';";        
        $row =  $db->GetRow($strConsulta);
        $arrtemp = $row['nombresestudiantegeneral'];
        $arrtemp1 = $row['apellidosestudiantegeneral'];
        $name = $arrtemp . " " . $arrtemp1;
        $nombreEstudiante=$name;
        return $nombreEstudiante;
    }//function nombre
    
    public function Ultimoticket($db, $referencia1, $referencia2, $tipodocumento, $valor, $estado = null){        
        $sqlestado = "";
        if($estado <> null){
            $sqlestado = " and StaCode='".$estado."' ";
        }
        
        $SrvCode = "'10001', '10002', '10003'";
        
        $sqlticket = "SELECT TicketId, SrvCode FROM LogPagos where Reference1='".$referencia1."' ".
        " and  TransValue='".$valor."' and Reference2 = '".$referencia2."' ".
        " and Reference3='".$tipodocumento."' and SrvCode in (".$SrvCode.")".$sqlestado;                  
        $ticketid = $db->GetRow($sqlticket);
        return $ticketid['TicketId'];
    }
    
    public function datosuniversidad($db){
        $query_universidad = "SELECT nombreuniversidad,direccionuniversidad,c.nombreciudad,p.nombrepais,u.paginawebuniversidad,".
        "u.imagenlogouniversidad,u.telefonouniversidad,u.faxuniversidad,u.nituniversidad,u.personeriauniversidad,u.entidadrigeuniversidad ".
        " FROM universidad u,ciudad c,pais p,departamento d ".
        " WHERE u.iduniversidad = 1 ".
        " AND d.idpais = p.idpais ".
        " AND u.idciudad = c.idciudad ".
        " AND c.iddepartamento = d.iddepartamento";
        $row_universidad = $db->GetRow($query_universidad);
        return $row_universidad;
    }
    
    public function nombreconcepto($db, $Reference1){
        $query_conceptoorden = "select nombreconcepto from detalleordenpago d, concepto c ".
        " where d.codigoconcepto = c.codigoconcepto and d.numeroordenpago = '".$Reference1."'";
        $row_conceptoorden = $db->GetRow($query_conceptoorden);
        
        return $row_conceptoorden['nombreconcepto'];
    }
    
    public function estadoconcepto($db, $Reference1, $codigo){
        $query_conceptosordenpagomatricula = "select d.codigoconcepto, c.codigoreferenciaconcepto ".
        " from detalleordenpago d, concepto c where d.codigoconcepto = c.codigoconcepto ".
        " and d.numeroordenpago = '".$Reference1."' and c.codigoreferenciaconcepto = '".$codigo."'";
        $conceptosordenpagomatricula = $db->GetRow($query_conceptosordenpagomatricula);
        return $conceptosordenpagomatricula;
    }
    
    public function consultaestudiante($db, $Reference1, $Reference2, $Reference3){
        $sqlconsulta = "SELECT g.idestudiantegeneral, e.codigoestudiante FROM ".
	" estudiantegeneral g ".
        " INNER JOIN documento t ON (t.tipodocumento = g.tipodocumento) ".
        " INNER JOIN estudiante e ON (g.idestudiantegeneral = e.idestudiantegeneral) ".
        " INNER JOIN ordenpago o ON (o.codigoestudiante = e.codigoestudiante) ".
        " WHERE g.numerodocumento = '".$Reference2."' ".
        " and t.nombrecortodocumento = '".$Reference3."' ".
        " and o.numeroordenpago = '".$Reference1."'";
        $estudiante = $db->GetRow($sqlconsulta);
        
        return $estudiante;
    }
    
    public function contadorlogpagos($db, $referencia1, $referencia2, $referencia3){
        $query_contador = "select count(*) as 'contador' from LogPagos where ".
        " reference1='".$referencia1."' ".
        " and reference2='".$referencia2."' ".
        " and reference3='".$referencia3."' ".
        " and FlagButton='1' AND StaCode IN ('OK', 'PENDING', 'BANK')";          
        $contador = $db->GetRow($query_contador);
        if(isset($contador['contador']) && !empty($contador['contador'])){
            return $contador['contador'];
        }else{
            return '0';
        }
    }
    
    public function insertlogpagos($db, $Ticketa, $SrvCode, $referencia1, $referencia2, $tipodocumento, $PaymentDesc, $valor, $codigobanco, $pendiente, 
        $BankProcessDate, $TrazabilityCode, $setFlagButton){
       
        $strCons = "INSERT INTO LogPagos (TicketId,SrvCode,Reference1,Reference2,Reference3,PaymentDesc,TransValue,TransVatValue,SoliciteDate,".
        "BankProcessDate,FIName,StaCode,TrazabilityCode,FlagButton) VALUES ('".$Ticketa."', '".$SrvCode."', '".$referencia1."', '".$referencia2."'".
        ", '".$tipodocumento."', '".$PaymentDesc."', '".$valor."','".$valor."', '".date("Y-m-d H:i:s")."', '".$BankProcessDate."', '".$codigobanco.
        "','".$pendiente."', '".$TrazabilityCode."', '".$setFlagButton."' )";        
        return is_object($db->Execute($strCons));

    }
    
    public function maximoticket($db, $referencia1){
        $sqlvalidapago = "select TicketId from LogPagos where reference1 = ".$referencia1."  and StaCode = 'OK'";
        $pago = $db->GetRow($sqlvalidapago);

        if(isset($pago['TicketId']) && !empty($pago['TicketId'])){
            $return = $pago['TicketId'];
        }else {
            $query_ticket = "select max(TicketId) as ticketid from LogPagos where reference1='" . $referencia1 . "'";
            $row_ticket = $db->GetRow($query_ticket);
            $return = $row_ticket['ticketid'];
        }
        
        return $return;
    }
    
    public function documentopeople($db, $documento){
        $sqldocumento= "SELECT dp.tipodocumentosala, dp.nombredocumentosala, dp.codigodocumentopeople, d.nombrecortodocumento ".
        "FROM documentopeople dp  INNER JOIN documento d on (dp.nombredocumentosala = d.nombredocumento)".
        " where d.nombrecortodocumento = '".$documento."' ";
        $tipodocumento = $db->GetRow($sqldocumento);
        
        if(isset($tipodocumento['codigodocumentopeople']) || !empty($tipodocumento['codigodocumentopeople'])){
            $documentopeople = $tipodocumento['codigodocumentopeople'];
        }else{
            $documentopeople = "CC";
        }
        
        return $documentopeople;
    }
    
    public function estadomatriculado($db, $estudiante){
        $nuevoestado = "";
        $sqlestado = "SELECT codigosituacioncarreraestudiante  ".
        " FROM estudiante WHERE codigoestudiante = '".$estudiante."'";
        $estado = $db->GetRow($sqlestado);
        $codigoestado = $estado['codigosituacioncarreraestudiante'];
        if(isset($codigoestado) && !empty($codigoestado)){
            switch($codigoestado){
                case '107':{
                    //admitido
                    $nuevoestado = '300';
                }break;
                case '300':{
                    //normal
                    $nuevoestado = '301';
                }break;
                default:{
                    $nuevoestado = '0';
                }break;
            }//switch
            if($nuevoestado <> '0'){
                $update = "UPDATE estudiante SET ".
                " codigosituacioncarreraestudiante='".$nuevoestado."' WHERE ".
                " codigoestudiante='".$estudiante."'";
                return is_object($db->Execute($update));
            }
            
        }//if
    }
    
    public function estadolog($db, $referencia1, $ticket){
        $sqlestado = "SELECT StaCode FROM LogPagos ".
        " WHERE Reference1 = '".$referencia1."' and TicketId = '".$ticket."'";        
        $stacode = $db->GetRow($sqlestado);

        if(isset($stacode['StaCode']) && !empty($stacode['StaCode'])){
            return $stacode['StaCode'];
        }else{
            return "";
        }
    }

    //Author: Lina Quintero
    //Fecha: 27-04-2021
    //Parametros: $db: Conexion de base de datos,  $TicketId=  Id del ticket de la orden
    //Return: true si esta entre las fecha hablitadas para el envio del pago a people
    //false si no esta entre las fechas habilitadas para el envio   

    public function fechasreportarpagopeople($db, $TicketId){

    $fechaanio = date('Y');
    $fechames= date('m');
    $fechaultimodia = new DateTime();
    $fechaultimodia->modify('last day of this month');
    $fechaultimodiames= $fechaultimodia->format('d');
    $fechaaniomes= $fechaanio.'-'.$fechames;
    $mesAnterior = date( "m", strtotime( $fechaaniomes." -1 month" ) );
    $ultimoDiaMesAnterior= date("d",(mktime(0,0,0,$mesAnterior+1,1,$fechaanio)-1));

    $sqlfechapago = "SELECT SoliciteDate FROM LogPagos WHERE TicketId = '".$TicketId."'";
    $fechapago = $db->GetRow($sqlfechapago);

    $fechainicial = $fechaanio.'-'.$mesAnterior.'-'.$ultimoDiaMesAnterior.' 17:01:00';
    $fechafinal = $fechaanio.'-'.$fechames.'-'.$fechaultimodiames.' 17:00:00';

    if($fechapago['SoliciteDate'] >= $fechainicial &&  $fechapago['SoliciteDate'] <= $fechafinal)

    {
        return true;

    }else{

        return false;  

       }
    }
}
