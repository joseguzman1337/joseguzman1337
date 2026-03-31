<?php
header ('Content-type: text/html; charset=UTF-8');
$haystack = 'Iñtërnâtiônàlizætiøn áéíóú ÁÉÍÓÚ Ññ';
$needle = 'Ñ';

$pos = strpos($haystack, $needle);

print "Position in bytes is $pos<br>";

$substr = substr($haystack, 0, $pos);

print "Substr: $substr<br>";

require_once('/usr/local/apache2/htdocs/html/serviciosacademicos/consulta/interfacespeople/lib/nusoap.php');

$client = new soapclient("http://campus.unbosque.edu.co/PSIGW/PeopleSoftServiceListeningConnector/UBI_CREA_ORDENPAG_SRV.1.wsdl", true);
$err = $client->getError();
if ($err)
	echo '<h2>ERROR EN EL CONSTRUCTOR</h2><pre>' . $err . '</pre>';
$proxy = $client->getProxy();

$xml="	<m:messageRequest xmlns:m=\"http://xmlns.oracle.com/Enterprise/Tools/schemas/UBI_CREA_ORDENPAG_REQ_MSG.VERSION_1\">
		<UBI_OPERACION_ORD>U</UBI_OPERACION_ORD>
		<NATIONAL_ID_TYPE>CC</NATIONAL_ID_TYPE>
		<NATIONAL_ID>1032421273</NATIONAL_ID>
		<NATIONAL_ID_TYPE_OLD></NATIONAL_ID_TYPE_OLD>
		<NATIONAL_ID_OLD></NATIONAL_ID_OLD>
		<FIRST_NAME>DIEGO</FIRST_NAME>
		<MIDDLE_NAME>LUÍS</MIDDLE_NAME>
		<LAST_NAME>RODRÍGUEZ</LAST_NAME>
		<SECOND_LAST_NAME>GÓMEZ</SECOND_LAST_NAME>
		<BIRTHDATE>04161988</BIRTHDATE>
		<BIRTHCOUNTRY>CO</BIRTHCOUNTRY>
		<BIRTHSTATE>11</BIRTHSTATE>
		<BIRTHPLACE>11001</BIRTHPLACE>
		<SEX>M</SEX>
		<MAR_STATUS>S</MAR_STATUS>
		<ADDRESS1>CALLE 26 40 85  APARTAMENTO 101</ADDRESS1>
		<PHONE>3688089</PHONE>
		<EMAIL_ADDR>diego232@msn.com.co</EMAIL_ADDR>
		<BUSINESS_UNIT>UBSF0</BUSINESS_UNIT>
	</m:messageRequest> ";
$result = $client->call('UBI_CREA_ORDENPAG1_OPR_SRV',$xml);
print_r($result);
?>



