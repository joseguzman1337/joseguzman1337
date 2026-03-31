<?php
//require_once('nusoap.php');
function getBankList(){
$proxyhost = isset($_POST['proxyhost']) ? $_POST['proxyhost'] : '';
$proxyport = isset($_POST['proxyport']) ? $_POST['proxyport'] : '';
$proxyusername = isset($_POST['proxyusername']) ? $_POST['proxyusername'] : '';
$proxypassword = isset($_POST['proxypassword']) ? $_POST['proxypassword'] : '';
//68.178.148.205/corepsem
// http://68.178.148.167/payment/webservice/MPPWebServices.asmx?WSDL

$client = new soapclient("http://200.31.79.250/ecollect/webservice/MPPWebServices.asmx?WSDL", true,$proxyhost, $proxyport, $proxyusername, $proxypassword);
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
    	?>
            <select name="cmbBanco">
        <?php
          for ($i = 0; $i <= sizeof($result) - 1; $i++){
            echo "<option value='" . $result[$i]['financialInstitutionCode'] . "'>" . $result[$i]['financialInstitutionName'] . "</option>";
          }
          ?>
        </select>
        <?php
     }
}
?>

