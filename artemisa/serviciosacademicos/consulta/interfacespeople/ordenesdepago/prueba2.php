<?
require_once('/usr/local/apache2/htdocs/html/serviciosacademicos/consulta/interfacespeople/lib/nusoap.php');
$client = new soapclient("http://campus.unbosque.edu.co/PSIGW/PeopleSoftServiceListeningConnector/UBI_ESTADO_CUENTA_SRV.1.wsdl", true);


$err = $client->getError();
if ($err)
	echo '<h2>ERROR EN EL CONSTRUCTOR</h2><pre>' . $err . '</pre>';
$proxy = $client->getProxy();

$xml = "<UB_DATOSCONS_WK>
		<NATIONAL_ID_TYPE>CC</NATIONAL_ID_TYPE>
		<NATIONAL_ID>1033715602</NATIONAL_ID>
	</UB_DATOSCONS_WK>";
$result = $client->call('UBI_CUENTA_CLIENTE_OPR_SRV',$xml);
print_r($result);
?>
