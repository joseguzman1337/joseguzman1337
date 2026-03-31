<?php
require_once('nusoap.php');
function getBankList(){
$proxyhost = isset($_POST['proxyhost']) ? $_POST['proxyhost'] : '';
$proxyport = isset($_POST['proxyport']) ? $_POST['proxyport'] : '';
$proxyusername = isset($_POST['proxyusername']) ? $_POST['proxyusername'] : '';
$proxypassword = isset($_POST['proxypassword']) ? $_POST['proxypassword'] : '';
//echo "$proxyhost = proxyhost - $proxyport = proxyport - $proxyusername = proxyusername - $proxypassword = proxypassword";
//68.178.148.205/corepsem
// http://68.178.148.167/payment/webservice/MPPWebServices.asmx?WSDL
//http://190.144.204.16/clientmpp/secure/pay_entityws.aspx
//echo "sdasdas";
//Internet 190.144.204.16
//Interna 172.16.3.204
//$client = new soapclient("http://pse.unbosque.edu.co/ecollect/webservice/MPPServices.asmx?WSDL", true,$proxyhost, $proxyport, $proxyusername, $proxypassword);
//$client = new soapclient("http://68.178.148.205/corepsem/webservice/MPPWebServices.asmx?WSDL", true,$proxyhost, $proxyport, $proxyusername, $proxypassword);
$err = $client->getError();
     if ($err) {
    	echo '<h2>Constructor error</h2><pre>' . $err . '</pre>';
     }
     $proxy = $client->getProxy();
     $param[] = array(
        'EntityCode' => '10017'
     );
    $result = $client->call('getBankList', array($param), '', '', true, true);
    if ($proxy->fault) {
    	echo '<h2>Fault</h2><pre>';
    	print_r($result);
    	echo '</pre>';
    } else {
        //echo "<pre>AAAAA".print_r($result)."</pre>";
    	?>
            <select name="cmbBanco" id="bancos">
        <?php
          for ($i = 0; $i <= sizeof($result) - 1; $i++){
          	if($result[$i]['paymentSystem'] == 0)
            	echo "<option value='" . $result[$i]['financialInstitutionCode'] . "'>" . $result[$i]['financialInstitutionName'] . "</option>";
          }
          ?>
        </select>
        <?php
     }
}

function getBankListTarjeta(){
$proxyhost = isset($_POST['proxyhost']) ? $_POST['proxyhost'] : '';
$proxyport = isset($_POST['proxyport']) ? $_POST['proxyport'] : '';
$proxyusername = isset($_POST['proxyusername']) ? $_POST['proxyusername'] : '';
$proxypassword = isset($_POST['proxypassword']) ? $_POST['proxypassword'] : '';
//68.178.148.205/corepsem
// http://68.178.148.167/payment/webservice/MPPWebServices.asmx?WSDL
//http://190.144.204.16/clientmpp/secure/pay_entityws.aspx
//echo "sdasdas";
//$client = new soapclient("http://pse.unbosque.edu.co/ecollect/webservice/MPPServices.asmx?WSDL", true,$proxyhost, $proxyport, $proxyusername, $proxypassword);
$client = new soapclient("http://pse.unbosque.edu.co/eCollectExpress/webservice/eCollectWebservicesv2.asmx?WSDL", true);

//$client = new soapclient("http://68.178.148.205/corepsem/webservice/MPPWebServices.asmx?WSDL", true,$proxyhost, $proxyport, $proxyusername, $proxypassword);
$err = $client->getError();
     if ($err) {
    	echo '<h2>Constructor error</h2><pre>' . $err . '</pre>';
     }
     $proxy = $client->getProxy();
     $param[] = array(
        'EntityCode' => '10017'
     );
    $result = $client->call('getBankList', array($param), '', '', true, true);
    if ($proxy->fault) {
    	echo '<h2>Fault</h2><pre>';
    	print_r($result);
    	echo '</pre>';
    } else {
    		//echo "<pre>AAAAA".print_r($result)."</pre>";
    	?>
            <select name="cmbBanco" id="tarjeta" disabled>
        <?php
          for ($i = 0; $i <= sizeof($result) - 1; $i++){
          	if($result[$i]['paymentSystem'] == 1)
            {
                //if($result[$i]['financialInstitutionName'] != "VISA")
            	    echo "<option value='" . $result[$i]['financialInstitutionCode'] . "'>" . $result[$i]['financialInstitutionName'] . "</option>";
            }
          }
          ?>
        </select>
        <?php
     }
}
//getBankListTarjeta()
?>

