<?
require_once($_SESSION['path_live'].'Connections/sala2.php');
$rutaado = $_SESSION['path_live']."funciones/adodb/";
require_once($_SESSION['path_live'].'Connections/salaado.php');
require_once($_SESSION['path_live'].'consulta/interfacespeople/lib/nusoap.php');
require_once($_SESSION['path_live'].'consulta/interfacespeople/conexionpeople.php');

$client = new soapclient(WEBORDENDEPAGO, true);
$err = $client->getError();
if ($err)
	echo '<h2>ERROR EN EL CONSTRUCTOR</h2><pre>' . $err . '</pre>';
$proxy = $client->getProxy();



$query="select tipocuenta from detalleordenpago dop join carreraconceptopeople ccp on dop.codigoconcepto=ccp.codigoconcepto where numeroordenpago='".$ordenpago."' group by tipocuenta";
$exec = mysql_query($query, $sala) or die("$query" . mysql_error());
while($row=mysql_fetch_array($exec))
	$arrTiposCuenta[]=$row['tipocuenta'];

if(in_array("PPA",$arrTiposCuenta))
	$parametros['UBI_OPERACION_ORD']='R';
else
	$parametros['UBI_OPERACION_ORD']='A';

$query="select codigodocumentopeople from estudiantegeneral eg join documentopeople dp on dp.tipodocumentosala = eg.tipodocumento where numerodocumento='".$numerodocumento."'";
$queryExec = mysql_query($query, $sala) or die("$query" . mysql_error());
$row = mysql_fetch_array($queryExec);
$codigodocumentopeople=$row['codigodocumentopeople'];

//verifica si la orden de pago es por concepto de inscripcion
$query="select count(*) as conteo from detalleordenpago dop join concepto c on dop.codigoconcepto=c.codigoconcepto where numeroordenpago ='".$ordenpago."' and cuentaoperacionprincipal='153' and cuentaoperacionparcial='0001'";
$queryExec = mysql_query($query, $sala) or die("$query" . mysql_error());
$row = mysql_fetch_array($queryExec);

if($row['conteo']==0) {
	$parametros['INVOICE_ID']=$ordenpago;
	$parametros['NATIONAL_ID_TYPE']=$codigodocumentopeople;
	$parametros['NATIONAL_ID']=$numerodocumento;
} else {
	$parametros['INVOICE_ID']=$ordenpago."-".$codigodocumentopeople.$numerodocumento;
	$parametros['NATIONAL_ID_TYPE']='CC';
	$parametros['NATIONAL_ID']='88888888';
}

$parametros['BUSINESS_UNIT']='UBSF0';

$xml="	<m:messageRequest xmlns:m=\"http://xmlns.oracle.com/Enterprise/Tools/schemas/UBI_CREA_ORDENPAG_REQ_MSG.VERSION_1\">
		<UBI_OPERACION_ORD>".$parametros['UBI_OPERACION_ORD']."</UBI_OPERACION_ORD>
		<NATIONAL_ID_TYPE>".$parametros['NATIONAL_ID_TYPE']."</NATIONAL_ID_TYPE>
		<NATIONAL_ID>".$parametros['NATIONAL_ID']."</NATIONAL_ID>
		<INVOICE_ID>".$parametros['INVOICE_ID']."</INVOICE_ID>
		<BUSINESS_UNIT>".$parametros['BUSINESS_UNIT']."</BUSINESS_UNIT>
	</m:messageRequest>";

//echo $xml;exit;

// Envio de parametros con arreglo
//$result = $client->call('UBI_CREA_ORDENPAG1_OPR_SRV',array($parametros));
// Envio de parametros por xml
$result = $client->call('UBI_CREA_ORDENPAG1_OPR_SRV',$xml);

echo "<pre>";
print_r($result);
echo "</pre>";


echo '<pre>' . htmlspecialchars($client->fault, ENT_QUOTES) . '</pre>';

 echo '<h2>Request</h2>';
     echo '<pre>' . htmlspecialchars($client->request, ENT_QUOTES) . '</pre>';
     echo '<h2>Response</h2>';
     echo '<pre>' . htmlspecialchars($client->response, ENT_QUOTES) . '</pre>';
     echo '<h2>Debug</h2>';
     echo '<pre>' . htmlspecialchars($client->debug_str, ENT_QUOTES) . '</pre>';

//exit;


$query="INSERT INTO logtraceintegracionps (transaccionlogtraceintegracionps,enviologtraceintegracionps,respuestalogtraceintegracionps,documentologtraceintegracionps) VALUES ('Anulacion Orden Pago','".$xml."','id:".$result['ERRNUM']." descripcion: ".$result['DESCRLONG']."',".$ordenpago.")";
mysql_query($query, $sala) or die("$query" . mysql_error());

?>
