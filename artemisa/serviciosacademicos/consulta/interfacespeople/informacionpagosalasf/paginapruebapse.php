<?php
require_once('../../../Connections/sala2.php');
$rutaado = "../../../funciones/adodb/";
require_once('../../../Connections/salaado.php');
require_once('../../../consulta/interfacespeople/lib/nusoap.php');

$fechahoy=date("m/d/Y");

?>

<html>
    <head>
                
    </head>
    <body>
<form name="f1" id="f1"  method="POST" action="">
            <table width="50%" border="1"  cellpadding="3" cellspacing="3">
                
                <TR>
                    <TD >Tipo Documento (CC,TI)</TD>
                    <TD><input type="text" name="tipodocumento" value="<?php if($_REQUEST['tipodocumento'] !=""){ echo $_REQUEST["tipodocumento"]; }?>">
                    </TD>
                </TR>
                <TR>
                    <TD >Numero Documento Estudiante</TD>
                    <TD><input type="text" name="documento" value="<?php if($_REQUEST['documento'] !=""){ echo $_REQUEST["documento"]; }?>">
                    </TD>
                </TR>
                <TR>
                    <TD >Numero Orden Pago</TD>
                    <TD><input type="text" name="ordenpago" value="<?php if($_REQUEST['ordenpago'] !=""){ echo $_REQUEST["ordenpago"]; }?>">
                    </TD>
                </TR>
                <TR>
                    <TD >ACCOUNT_TYPE_SF (MAT=Matriculas o ACA=Diferente Matriculas)</TD>
                    <TD><input type="text" name="tipocuenta" value="<?php if($_REQUEST['tipocuenta'] !=""){ echo $_REQUEST["tipocuenta"]; }?>">
                    </TD>
                </TR>
                <TR>
                    <TD >ITEM_TYPE (Numero Cuenta VISA O MASTERCARD=071000080001  DEBITO= 071000080004)</TD>
                    <TD><input type="text" name="numerocuenta" value="<?php if($_REQUEST['numerocuenta'] !=""){ echo $_REQUEST["numerocuenta"]; }?>">
                    </TD>
                </TR>
                <TR>
                    <TD >PAYMENT_METHOD(Metodopago T.Credito= TC o T.Debito= TD)</TD>
                    <TD><input type="text" name="metodopago" value="<?php if($_REQUEST['metodopago'] !=""){ echo $_REQUEST["metodopago"]; }?>">
                    </TD>
                </TR>
                <TR>
                    <TD >VALOR CONCEPTO  (ITEM_AMT)</TD>
                    <TD><input type="text" name="valorconcepto" value="<?php if($_REQUEST['valorconcepto'] !=""){ echo $_REQUEST["valorconcepto"]; }?>">
                    </TD>
                </TR>
                <TR>
                    <TD >FECHA mm/dd/aa(11/30/11)</TD>
                    <TD><input type="text" name="fecha" value="<?php if($_REQUEST['fecha'] !=""){ echo $_REQUEST["fecha"]; }?>">
                    </TD>
                </TR>
                <TR id="trgris" >
                    <TD colspan="2" align="center"><input type="submit" name="enviar" value="Enviar">
                    </TD>
                </TR>
            </table>
    </form>
    </body>
</html>
<?php
if(isset($_REQUEST['enviar'])){

    $national_id_type=$_REQUEST['tipodocumento'];
    $national_id=$_REQUEST['documento'];
    $invoice_id=$_REQUEST['ordenpago'];
    $account_type_sf=$_REQUEST['tipocuenta'];
    $item_type=$_REQUEST['numerocuenta'];
    $payment_method=$_REQUEST['metodopago'];
    $item_amt=$_REQUEST['valorconcepto'];
    $item_effective_dt=$_REQUEST['fecha'];

    $param2="<UB_INFOPAGO_WK>
                <NATIONAL_ID_TYPE>$national_id_type</NATIONAL_ID_TYPE>
                <NATIONAL_ID>$national_id</NATIONAL_ID>
                <INVOICE_ID>$invoice_id</INVOICE_ID>
                <ACCOUNT_TYPE_SF>$account_type_sf</ACCOUNT_TYPE_SF>
                <ITEM_TYPE>$item_type</ITEM_TYPE>
                <PAYMENT_METHOD>$payment_method</PAYMENT_METHOD>
                <ITEM_AMT>$item_amt</ITEM_AMT>
                <ITEM_EFFECTIVE_DT>$item_effective_dt</ITEM_EFFECTIVE_DT>
            </UB_INFOPAGO_WK>";

    $client = new soapclient("http://campusxxide.unbosque.edu.co:8210/PSIGW/PeopleSoftServiceListeningConnector/UBI_PAGO_PSE_SRV.1.wsdl", true);
    $err = $client->getError();
    if ($err) {
        echo '<h2>ERROR EN EL CONSTRUCTOR</h2><pre>' . $err . '</pre>';
        $query_logps="INSERT INTO logtraceintegracionps(idlogtraceintegracionps, transaccionlogtraceintegracionps,
        enviologtraceintegracionps, respuestalogtraceintegracionps, documentologtraceintegracionps,
        fecharegistrologtraceintegracionps)
        VALUES( 0, 'Preliminar Informa Pago PSE','', 'No hay respuesta del WSDL, error de conexión con el servidor $err', '$numeroordenpago',now())";
        $logps = $db->Execute($query_logps) or die(mysql_error());

    }
    $proxy = $client->getProxy();    


     $result = $client->call('UBI_PAGO_PSE_OPR_SRV',$param2);

    if ($client->fault) {

        echo "<h3><b>Se genero el siguiente error</b></h3>";

        echo "<h3><b>";
        echo "<pre>";
	print_r($result);
        echo "</pre>";
        echo "</b></h3>";        

        $detalleresult=$result['detail']['IBResponse']['DefaultMessage'];
        $query_auditoria="INSERT INTO logtraceintegracionps(idlogtraceintegracionps, transaccionlogtraceintegracionps,
        enviologtraceintegracionps, respuestalogtraceintegracionps, documentologtraceintegracionps,
        fecharegistrologtraceintegracionps)
        VALUES( 0, 'Preliminar Informa Pago PSE','$param2','$detalleresult', '$invoice_id',now())";
        $auditoria = $db->Execute($query_auditoria) or die(mysql_error());

    }
    else {
        // Check for errors
        $err = $client->getError();
	if ($err) {
            // Display the error
            echo '<H2><b>Error: ' . $err . '</b></H2>';
             $query_logps="INSERT INTO logtraceintegracionps(idlogtraceintegracionps, transaccionlogtraceintegracionps,
            enviologtraceintegracionps, respuestalogtraceintegracionps, documentologtraceintegracionps,
            fecharegistrologtraceintegracionps)
            VALUES( 0, 'Preliminar Informa Pago PSE','$param2', '$err', '$invoice_id',now())";
            $logps = $db->Execute($query_logps) or die(mysql_error());
	}
        else {
            // Display the result
            echo "<b>El web service responde</b>";
            
            echo "<h2><b>";
            echo "<pre>";
            print_r($result);
            echo "</pre>";
            echo "</b></h2>";

            
            if($result['ERRNUM'] ==0){
                
                $respuesta=$result['ERRNUM']." - ".$result['DESCRLONG'];
                $query_logps="INSERT INTO logtraceintegracionps(idlogtraceintegracionps, transaccionlogtraceintegracionps,
                enviologtraceintegracionps, respuestalogtraceintegracionps, documentologtraceintegracionps,
                fecharegistrologtraceintegracionps)
                VALUES( 0, 'Preliminar Informa Pago PSE','$param2', '$respuesta', '$invoice_id',now())";
                $logps = $db->Execute($query_logps) or die(mysql_error());
            }
            if($result['ERRNUM'] !=0){
                $respuesta=$result['ERRNUM']." - ".$result['DESCRLONG'];
                $query_logps="INSERT INTO logtraceintegracionps(idlogtraceintegracionps, transaccionlogtraceintegracionps,
                enviologtraceintegracionps, respuestalogtraceintegracionps, documentologtraceintegracionps,
                fecharegistrologtraceintegracionps)
                VALUES( 0, 'Preliminar Informa Pago PSE','$param2', '$respuesta', '$invoice_id',now())";
                $logps = $db->Execute($query_logps) or die(mysql_error());
            }
	}
    }

    //Impresion de funciones request, response, debug
     echo '<h2>Request</h2>';
     echo '<pre>' . htmlspecialchars($client->request, ENT_QUOTES) . '</pre>';
     echo '<h2>Response</h2>';
     echo '<pre>' . htmlspecialchars($client->response, ENT_QUOTES) . '</pre>';
     echo '<h2>Debug</h2>';
     echo '<pre>' . htmlspecialchars($client->debug_str, ENT_QUOTES) . '</pre>';



}
?>
