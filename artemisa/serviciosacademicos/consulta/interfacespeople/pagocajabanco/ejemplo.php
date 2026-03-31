<?php
require_once('../../../Connections/sala2.php');
$rutaado = "../../../funciones/adodb/";
require_once('../../../Connections/salaado.php');
require_once('../../../trm/lib/nusoap.php');

 $proxyhost = isset($_POST['proxyhost']) ? $_POST['proxyhost'] : '';
    $proxyport = isset($_POST['proxyport']) ? $_POST['proxyport'] : '';
    $proxyusername = isset($_POST['proxyusername']) ? $_POST['proxyusername'] : '';
    $proxypassword = isset($_POST['proxypassword']) ? $_POST['proxypassword'] : '';



    $client = new soapclient("https://artemisa.unbosque.edu.co/serviciosacademicos/consulta/interfacespeople/pagocajabanco/interfaz_pago_caja_bancos.php?wsdl", true);
    $err = $client->getError();
    if ($err) {
        echo '<h2>ERROR EN EL CONSTRUCTOR</h2><pre>' . $err . '</pre>';
    }
    $proxy = $client->getProxy();

            $parametros['INVOICE_ID']='1552388';
            $parametros['TRANSFER_DT']='20121116';
            


        $result = $client->call('InformacionCajaBancos',$parametros);

            echo "<pre>";
           print_r($parametros);
            echo "</pre>";

            echo "<pre>";
            print_r($result);
            echo "</pre>";

             echo '<h2>Request</h2>';
     echo '<pre>' . htmlspecialchars($client->request, ENT_QUOTES) . '</pre>';
     echo '<h2>Response</h2>';
     echo '<pre>' . htmlspecialchars($client->response, ENT_QUOTES) . '</pre>';
     echo '<h2>Debug</h2>';
     echo '<pre>' . htmlspecialchars($client->debug_str, ENT_QUOTES) . '</pre>';
     //echo $national_id_type."<br>".$national_id."<br>".$invoice_id."<br>".$account_type_sf."<br>".$item_type."<br>".$payment_method."<br>".$item_amt."<br>".$item_effective_dt;

            //echo '<pre>' . htmlspecialchars($client->debug_str, ENT_QUOTES) . '</pre>';
            /*if($result['UploadIdentityCardResult']){
                echo "Sube Pleno";
            }
            else{
                echo "paila algun error";
            }*/



/*if ($proxy->fault) {
        echo '<h2>Fault</h2><pre>';
        print_r($result);
        echo '</pre>';
    } else {
        echo "<pre>AAAAA" . print_r($result) . "</pre>";
    }
    echo '<h2>Proxy Debug</h2><pre>' . htmlspecialchars($proxy->debug_str, ENT_QUOTES) . '</pre>';
    echo '<h2>Client Debug</h2><pre>' . htmlspecialchars($client->debug_str, ENT_QUOTES) . '</pre>';



    echo "<pre>";
   print_r($parametros);
    echo "</pre>";

    echo "<pre>";
    print_r($datosest);
    echo "</pre>";

    echo "<pre>";
    print_r($result);
    echo "</pre>";

//}*/


?>
