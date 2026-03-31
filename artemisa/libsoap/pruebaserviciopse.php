<?php
//require_once('nusoap.php');
if(isset($_POST["ticket"])) {
require_once(dirname(__FILE__).'/../nusoap/lib/nusoap.php');

require_once(dirname(__FILE__)."/../serviciosacademicos/Connections/conexionECollect.php");
//$proxyhost = isset($_POST['proxyhost']) ? $_POST['proxyhost'] : '';
//$proxyport = isset($_POST['proxyport']) ? $_POST['proxyport'] : '';
//$proxyusername = isset($_POST['proxyusername']) ? $_POST['proxyusername'] : '';
//$proxypassword = isset($_POST['proxypassword']) ? $_POST['proxypassword'] : '';


$client = new nusoap_client(WEBSERVICEPSE, true);


$err = $client->getError();
if ($err) {
    echo '<h2>Constructor error</h2><pre>' . $err . '</pre>';
}
$proxy = $client->getProxy();


$param[] = array(
    'EntityCode' => 10017,
    'TicketId' => $_POST["ticket"]
);

$resultado = $client->call('getTransactionInformation', array("request"=>array(
    'EntityCode' => 10017,
    'TicketId' =>  $_POST['ticket'])));
echo "<pre>";
  print_r($resultado);
  echo "</pre>";


  /*echo '<h2>Request</h2>';
     echo '<pre>' . htmlspecialchars($client->request, ENT_QUOTES) . '</pre>';
     echo '<h2>Response</h2>';
     echo '<pre>' . htmlspecialchars($client->response, ENT_QUOTES) . '</pre>';
     echo '<h2>Debug</h2>';
     echo '<pre>' . htmlspecialchars($client->debug_str, ENT_QUOTES) . '</pre>';*/

} else {
?>
<form action="pruebaserviciopse.php" method="POST" name="form1">
TicketId:
<input type="text" value="" name="ticket"/>
<input type="submit" value="consultar" />
</form>
<?php } ?>

