<?php

class pagosalasf{
    public function reportarPago($db, $numeroordenpago, $item_amt){        
        require_once(dirname(__FILE__).'/../../generacionclaves.php');
        require_once(dirname(__FILE__).'/../../../../nusoap/lib/nusoap.php');
        require(dirname(__FILE__).'/../conexionpeople.php');
        require_once(dirname(__FILE__).'/../../../funciones/cambia_fecha_sap.php');
        
        $fechahoy=date("m/d/y");
        $fechapagoorden=date("Y-m-d");

        $query_logpagos = "SELECT l.FIName FROM LogPagos l where l.Reference1 = '".$numeroordenpago."' and StaCode = 'OK'";    
        $logpagos = $db->GetRow($query_logpagos);        

        if(!isset($logpagos['FIName']) && empty($logpagos['FIName'])){
            exit();
        }else{
          if($logpagos['FIName'] == "MASTERCARD" || $logpagos['FIName'] == "VISA"){
              $numerocuenta = "071000080001";
              $tipocuentapeople="TC";
          } else if ($logpagos['FIName'] == 'CODENSA') {
              $numerocuenta = "071000080007";
              $tipocuentapeople = "TC";
          }else{
              //Pago PSE Credicorp Fonval
              $numerocuenta = "071000080009";
              $tipocuentapeople="TD";
          }
        }
        
        //CREA CUENTA CORREO
        $objetoclaveusuario=new GeneraClaveUsuario($numeroordenpago,$salaobjecttmp);

        $query_variables = "SELECT dp.codigodocumentopeople, eg.numerodocumento, op.numeroordenpago, ".
        " coalesce(ccp.tipocuenta,ccp2.tipocuenta) as tipocuenta ,cp.cuentaoperacionprincipal ".
        " FROM carrera c ".
        " JOIN estudiante e ON (c.codigocarrera = e.codigocarrera) ".
        " JOIN estudiantegeneral eg ON (e.idestudiantegeneral = eg.idestudiantegeneral) ".
        " JOIN documentopeople dp ON (eg.tipodocumento = dp.tipodocumentosala)".
        " JOIN ordenpago op ON (e.codigoestudiante = op.codigoestudiante) ".
        " JOIN detalleordenpago dop ON (op.numeroordenpago = dop.numeroordenpago) ".
        " JOIN concepto cp ON (dop.codigoconcepto = cp.codigoconcepto) ".
        " LEFT JOIN carreraconceptopeople ccp ON (e.codigocarrera = ccp.codigocarrera AND dop.codigoconcepto = ccp.codigoconcepto) ".
        " LEFT JOIN carreraconceptopeople ccp2 ON (1 = ccp2.codigocarrera AND dop.codigoconcepto = ccp2.codigoconcepto ) ".
        " where op.numeroordenpago='".$numeroordenpago."' ".
        " group by dp.codigodocumentopeople,eg.numerodocumento,op.numeroordenpago,tipocuenta";         
        $row_variables = $db->GetAll($query_variables);
        $totalRows_variables = count($row_variables);        
        /*Condicion dada por el grupo de people
        * si tiene mas de dos cuentas la transaccion debe tener el tipo de cuenta PPA
        * Adicional debe sumar todos los valores como uno solo, ademas valida si el estudiante esta pagando inscripcion con el fin de
         * enviar los datos como estudiante dummy.
        */        

        if ($totalRows_variables > 1){                        
            $account_type_sf="PPA";
            $national_id_type=$row_variables['0']['codigodocumentopeople'];
            $national_id=$row_variables['0']['numerodocumento'];
            $invoice_id=$numeroordenpago;
        }else{            
           if(isset($row_variables['0']['cuentaoperacionprincipal']) && $row_variables['0']['cuentaoperacionprincipal']!='153'){                              
               $national_id_type=$row_variables['0']['codigodocumentopeople'];
               $national_id=$row_variables['0']['numerodocumento'];
               $invoice_id=$numeroordenpago;
           }else{                              
                $national_id_type='CC';
                // DETERMINA EL DUMMY QUE LE CORRESPONDE PARA PODER REALIZAR EL PAGO DE LA ORDEN
                //******************************************************************************
                $sql= "select dummy from logdummyintregracionps where '".$numeroordenpago."' ".
                "between numeroordenpagoinicial and numeroordenpagofinal";                   
                $rowDummy = $db->GetRow($sql);                 
                $national_id=$rowDummy["dummy"];
            //******************************************************************************
            $invoice_id=$numeroordenpago."-".$row_variables['0']['codigodocumentopeople'].$row_variables['0']['numerodocumento'];
          }//else
          $account_type_sf=$row_variables['0']['tipocuenta'];
        }//else
        
        if(strlen($invoice_id) > 22){
            $invoice_id = substr($invoice_id, 0, 22);
        }
        
        $item_type=$numerocuenta;
        $payment_method=$tipocuentapeople;
        $item_effective_dt=$fechahoy;

        //Consume webservice de people para reportar los pagos//
        $resultado=array();
        require_once(dirname(__FILE__).'/../reporteCaidaPeople.php');
        $envio=0;

        $servicioPS = verificarInformaPSE();
        if($servicioPS){
            // SE PONE UN TIEMPO DE RESPUESTA DE 200 SEGUNDOS
            $client = new nusoap_client(WEBREPORTAPAGOPSE, true, false, false, false, false, 0, 200);
            $err = $client->getError();
            if (!$client or $err = $client->getError()) {
                echo '<h2>ERROR EN EL CONSTRUCTOR</h2><pre>' . $err . '</pre>';
                $query_logps="INSERT INTO logtraceintegracionps(idlogtraceintegracionps, transaccionlogtraceintegracionps, ".
                " enviologtraceintegracionps, respuestalogtraceintegracionps, documentologtraceintegracionps, ".
                " fecharegistrologtraceintegracionps,estadoenvio) ".
                " VALUES( 0, 'Informa Pago PSE','', 'No hay respuesta del WSDL, error de conexión con el servidor $err', '".$numeroordenpago."',now(),".$envio.")";              
                $logps = $db->Execute($query_logps);
            }            
        }//$servicioPS
          
        $param=array('NATIONAL_ID_TYPE'=>$national_id_type,
            'NATIONAL_ID'=>$national_id ,
            'INVOICE_ID'=>$invoice_id,
            'ACCOUNT_TYPE_SF'=>$account_type_sf,
            'ITEM_TYPE'=>$item_type,
            'PAYMENT_METHOD'=>$payment_method,
            'ITEM_AMT'=>$item_amt,
            'ITEM_EFFECTIVE_DT'=>$item_effective_dt);        
        //En caso de que no funcione con el arreglo anterior utilizar este.
        $param2="<UB_INFOPAGO_WK>".
        "<NATIONAL_ID_TYPE>".$national_id_type."</NATIONAL_ID_TYPE> ".
        "<NATIONAL_ID>".$national_id."</NATIONAL_ID> ".
        "<INVOICE_ID>".$invoice_id."</INVOICE_ID>".
        "<ACCOUNT_TYPE_SF>".$account_type_sf."</ACCOUNT_TYPE_SF>".
        "<ITEM_TYPE>".$item_type."</ITEM_TYPE>".
        "<PAYMENT_METHOD>".$payment_method."</PAYMENT_METHOD>".
        "<ITEM_AMT>".$item_amt."</ITEM_AMT>".
        "<ITEM_EFFECTIVE_DT>".$item_effective_dt."</ITEM_EFFECTIVE_DT>".
        "</UB_INFOPAGO_WK>";        
        
        if($servicioPS){
            $start = time();
            $result = $client->call('UBI_PAGO_PSE_OPR_SRV', $param2);
            $time =  time()-$start;
            $envio = 1;

            if($time>=200 || $result===false){
                $envio=0;
                reportarCaida(1,'Informa Pago PSE');
            }
       
            if ($client->fault) {
                $detalleresult=$result['detail']['IBResponse']['DefaultMessage'];
                $query_auditoria="INSERT INTO logtraceintegracionps(idlogtraceintegracionps, transaccionlogtraceintegracionps,".
                " enviologtraceintegracionps, respuestalogtraceintegracionps, documentologtraceintegracionps, ".
                " fecharegistrologtraceintegracionps,estadoenvio) ".
                " VALUES( 0, 'Informa Pago PSE','".$param2."','".$detalleresult."', '".$invoice_id."',now(),".$envio.")";
                $db->Execute($query_auditoria);
            }else {
                // Check for errors
                $err = $client->getError();
                if($err){
                    $query_logps="INSERT INTO logtraceintegracionps(idlogtraceintegracionps, transaccionlogtraceintegracionps, ".
                    " enviologtraceintegracionps, respuestalogtraceintegracionps, documentologtraceintegracionps, ".
                    " fecharegistrologtraceintegracionps,estadoenvio) ".
                    " VALUES( 0, 'Informa Pago PSE','".$param2."', '".$err."', '".$invoice_id."',now(),".$envio.")";
                    $logps = $db->Execute($query_logps);
                }else {
                    // Display the result
                    if($result['ERRNUM'] ==0){
                        //Hay respuesta ok
                        $respuesta=$result['ERRNUM']." - ".$result['DESCRLONG'];
                        $query_logps="INSERT INTO logtraceintegracionps(idlogtraceintegracionps, transaccionlogtraceintegracionps, ".
                        " enviologtraceintegracionps, respuestalogtraceintegracionps, documentologtraceintegracionps, ".
                        " fecharegistrologtraceintegracionps,estadoenvio) ".
                        " VALUES( 0, 'Informa Pago PSE','".$param2."', '".$respuesta."', '".$invoice_id."',now(),".$envio.")";
                        $logps = $db->Execute($query_logps);

                        $query_ordenpago = "UPDATE ordenpago set fechapagosapordenpago = '".$fechapagoorden."' ".
                        " where numeroordenpago = '".$numeroordenpago."' ";
                        $ordenpago=$db->Execute($query_ordenpago) or die("$query_ordenpago".mysql_error());
                    }
                    if($result['ERRNUM'] !=0){
                        $respuesta=$result['ERRNUM']." - ".$result['DESCRLONG'];
                        $query_logps="INSERT INTO logtraceintegracionps(idlogtraceintegracionps, transaccionlogtraceintegracionps, ".
                        " enviologtraceintegracionps, respuestalogtraceintegracionps, documentologtraceintegracionps, ".
                        " fecharegistrologtraceintegracionps,estadoenvio) ".
                        " VALUES( 0, 'Informa Pago PSE','".$param2."', '".$respuesta."', '".$invoice_id."',now(),".$envio.")";
                        $logps = $db->Execute($query_logps);
                    }
                }//else
            }//else
        } else {
            $query="INSERT INTO logtraceintegracionps (transaccionlogtraceintegracionps,enviologtraceintegracionps, ".
            " respuestalogtraceintegracionps,documentologtraceintegracionps,estadoenvio) VALUES ('Informa Pago PSE', ".
            " '".$param2."','id:".$resultado['ERRNUM']." descripcion: ".$resultado['DESCRLONG']."',".$invoice_id.",".$envio.")";
            $logps = $db->Execute($query);
        }//else
    }//function
}//class 