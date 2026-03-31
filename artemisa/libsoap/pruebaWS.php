<?php
require_once('nusoap.php');
$proxyhost = isset($_POST['proxyhost']) ? $_POST['proxyhost'] : '';
$proxyport = isset($_POST['proxyport']) ? $_POST['proxyport'] : '';
$proxyusername = isset($_POST['proxyusername']) ? $_POST['proxyusername'] : '';
$proxypassword = isset($_POST['proxypassword']) ? $_POST['proxypassword'] : '';
$client = new soapclient("http://200.31.69.162:8080/corepsem/webservice/MPPWebServices.asmx?WSDL", true,$proxyhost, $proxyport, $proxyusername, $proxypassword);

 $err = $client->getError();
 /*
 * Manejo de error de la clase main de SOAP, informa
 * si algo esta mal al instanciar la clase.
 */
 if ($err) {
	echo '<h2>Constructor error</h2><pre>' . $err . '</pre>';
 }
 $proxy = $client->getProxy();
 $param[] = array(
    'EntityCode' => '10017'
 );
$result = $client->call('getBankList', array($param), '', '', true, true);
// Revisar posibles errores
if ($proxy->fault) {
	echo '<h2>Fault</h2><pre>';
	print_r($result);
	echo '</pre>';
} else {
	// Revisar mas errores
	$err = $proxy->getError();
	if ($err) {
		// Mostrar el error.
		echo '<h2>Error</h2><pre>' . $err . '</pre>';
	} else {
        ?>
            <select name="cmbBanco">
        <?php
          for ($i = 0; $i <= sizeof($result); $i++){
            echo "<option value='" . $result[$i]['financialInstitutionCode'] . "'>" . $result[$i]['financialInstitutionName'] . "</option>";
          }
          ?>
        </select>
        <?php
        print_r($result);
        }
        // Redirecciona al result del web services.
echo '<h2>Debug</h2><pre>' . htmlspecialchars($client->debug_str, ENT_QUOTES) . '</pre>';
	}
?>

