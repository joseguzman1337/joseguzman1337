<?php 
require_once(dirname(__FILE__).'/../../../Connections/sala2.php');
$rutaado = dirname(__FILE__)."/../../../funciones/adodb/";
require_once(dirname(__FILE__).'/../../../Connections/salaado.php');
//require_once(dirname(__FILE__).'/../../../consulta/interfacespeople/lib/nusoap.php');
require_once(dirname(__FILE__).'/../../../consulta/interfacespeople/conexionpeople.php');
require_once(dirname(__FILE__).'/../../../../nusoap/lib/nusoap.php');
require_once(dirname(__FILE__).'/../../../consulta/interfacespeople/cambia_fecha_people.php');
require_once(realpath(dirname(__FILE__)).'/../../../utilidades/funcionesTexto.php');

	$results=array();
	require_once(dirname(__FILE__).'/../../interfacespeople/reporteCaidaPeople.php');
	$envio=0;
	$servicioPS = verificarPSEnLinea();
	if($servicioPS){
$client = new nusoap_client(WEBORDENDEPAGO,true, false, false, false, false, 0, 30);
$err = $client->getError();
if ($err)
	echo '<h2>ERROR EN EL CONSTRUCTOR</h2><pre>' . $err . '</pre>';
$proxy = $client->getProxy();
}

$parametros['UBI_OPERACION_ORD']=($itemnbrps==0)?'C':'F';
$parametros['NATIONAL_ID_TYPE']=$datos['tipodocumento'];
$parametros['NATIONAL_ID']=$datos['documento'];
$parametros['FIRST_NAME']=sanear_string($datos['primernombre'],false);
$parametros['MIDDLE_NAME']=sanear_string($datos['segundonombre'],false);
$parametros['LAST_NAME']=sanear_string($datos['primerapellido'],false);
$parametros['SECOND_LAST_NAME']=sanear_string($datos['segundoapellido'],false);
$parametros['BIRTHDATE']=$datos['fechanacimiento'];
$parametros['BIRTHCOUNTRY']=$datos['paisnacionalidad'];
$parametros['BIRTHSTATE']=$datos['departamentonacionalidad'];
$parametros['BIRTHPLACE']=$datos['ciudadnacionalidad'];
$parametros['SEX']=$datos['genero'];
$parametros['MAR_STATUS']=$datos['estadocivil'];
$parametros['ADDRESS1']=$datos['direccion'];
$parametros['PHONE']=$datos['telefono'];
$parametros['EMAIL_ADDR']=$datos['email'];
$parametros['BUSINESS_UNIT']='UBSF0';
$parametros['INVOICE_ID']=$datos['numeroordenpago'];
$parametros['INVOICE_DT']=$datos['fechacreacion'];
$parametros['DUE_DT']=$datos['fechavencimiento'];
$parametros['TOTAL_BILL']=$datos['totalordenpago'];
$anio=substr($datos['periodo'],2,2);
$mes=str_pad(substr($datos['periodo'],4,strlen($datos['periodo'])),2,0,STR_PAD_LEFT);
$parametros['STRM']=$anio.$mes;
$parametros['ITEM_NBR']=$itemnbrps;


//$query="SELECT itemcarreraconceptopeople,valorconcepto FROM detalleordenpago dop left join carreraconceptopeople ccp on dop.codigoconcepto=ccp.codigoconcepto and ".$datos['codigocarrera']."=ccp.codigocarrera WHERE numeroordenpago=".$datos['numeroordenpago'];

$query="SELECT   ccp.itemcarreraconceptopeople	AS item_ccp
		,ccp.tipocuenta
		,dop.valorconcepto		AS vlr_dop
		,sub.fechaordenpago
		,sub.valorfechaordenpago	AS vlr_sub
		,sub.itempagoextraordinario as item_sub
	FROM detalleordenpago dop
	LEFT JOIN carreraconceptopeople ccp ON dop.codigoconcepto=ccp.codigoconcepto and ".$datos['codigocarrera']."=ccp.codigocarrera
	LEFT JOIN (     select distinct f.numeroordenpago, f.fechaordenpago, f.porcentajefechaordenpago, f.valorfechaordenpago, '010210020002' as itempagoextraordinario
			from fechaordenpago f
			where f.numeroordenpago='".$datos['numeroordenpago']."'
	) AS sub ON dop.numeroordenpago=sub.numeroordenpago
	WHERE dop.numeroordenpago='".$datos['numeroordenpago']."'
	ORDER BY sub.fechaordenpago";
	
$orden = mysql_query($query, $sala) or die("$query" . mysql_error());




$xml_det="";
$valorCargoAdd=0;
while($row=mysql_fetch_array($orden)){
	if ($row['tipocuenta']=='MAT') {
		$fechaorden=$row['fechaordenpago'];
		$valor=$row['vlr_sub']-$valorCargoAdd;
		if ($row['vlr_dop']==$row['vlr_sub']) {
			$item=$row['item_ccp'];
			$itemto="";
		} else {
			$item=$row['item_sub'];
			$itemto=$row['item_ccp'];
		}
		$valorCargoAdd=$row['vlr_sub'];
	} else {
		$fechaorden=$parametros['DUE_DT'];
		$item=$row['item_ccp'];
		$valor=$row['vlr_dop'];
		$itemto="";
	}
	$xml_det.="	<UBI_ITEM_WRK>
				<ITEM_TYPE>".$item."</ITEM_TYPE>
				<ITEM_AMT>".$valor."</ITEM_AMT>
				<ACCOUNT_TYPE_SF>".$row['tipocuenta']."</ACCOUNT_TYPE_SF>
				<ITEM_TYPE_TO>".$itemto."</ITEM_TYPE_TO>
				<ITEM_NBR></ITEM_NBR>
				<ITEM_EFFECTIVE_DT>".cambiaf_a_people($parametros['INVOICE_DT'])."</ITEM_EFFECTIVE_DT>
				<DUE_DT2>".cambiaf_a_people($fechaorden)."</DUE_DT2>
			</UBI_ITEM_WRK>";
}

$xml="	<m:messageRequest xmlns:m=\"http://xmlns.oracle.com/Enterprise/Tools/schemas/UBI_CREA_ORDENPAG_REQ_MSG.VERSION_1\">
		<UBI_OPERACION_ORD>".$parametros['UBI_OPERACION_ORD']."</UBI_OPERACION_ORD>
		<NATIONAL_ID_TYPE>".$parametros['NATIONAL_ID_TYPE']."</NATIONAL_ID_TYPE>
		<NATIONAL_ID>".$parametros['NATIONAL_ID']."</NATIONAL_ID>
		<FIRST_NAME>".$parametros['FIRST_NAME']."</FIRST_NAME>
		<MIDDLE_NAME>".$parametros['MIDDLE_NAME']."</MIDDLE_NAME>
		<LAST_NAME>".$parametros['LAST_NAME']."</LAST_NAME>
		<SECOND_LAST_NAME>".$parametros['SECOND_LAST_NAME']."</SECOND_LAST_NAME>
		<BIRTHDATE>".cambiaf_a_people($parametros['BIRTHDATE'])."</BIRTHDATE>
		<BIRTHCOUNTRY>".$parametros['BIRTHCOUNTRY']."</BIRTHCOUNTRY>
		<BIRTHSTATE>".$parametros['BIRTHSTATE']."</BIRTHSTATE>
		<BIRTHPLACE>".$parametros['BIRTHPLACE']."</BIRTHPLACE>
		<SEX>".$parametros['SEX']."</SEX>
		<MAR_STATUS>".$parametros['MAR_STATUS']."</MAR_STATUS>
		<ADDRESS1>".$parametros['ADDRESS1']."</ADDRESS1>
		<PHONE>".$parametros['PHONE']."</PHONE>
		<EMAIL_ADDR>".$parametros['EMAIL_ADDR']."</EMAIL_ADDR>
		<BUSINESS_UNIT>".$parametros['BUSINESS_UNIT']."</BUSINESS_UNIT>
		<INVOICE_ID>".$parametros['INVOICE_ID']."</INVOICE_ID>
		<INVOICE_DT>".cambiaf_a_people($parametros['INVOICE_DT'])."</INVOICE_DT>
		<DUE_DT1>".cambiaf_a_people($parametros['DUE_DT'])."</DUE_DT1>
		<TOTAL_BILL>".$parametros['TOTAL_BILL']."</TOTAL_BILL>
		<STRM>".$parametros['STRM']."</STRM>
		<UBI_ESTADO>I</UBI_ESTADO>
		<UBI_ITEMS_WRK>
			".$xml.=$xml_det."
		</UBI_ITEMS_WRK>
	</m:messageRequest>";
//echo "<h1>aquuiiiiiiiiii</h1>";

//echo $xml;
// Envio de parametros con arreglo
//$result = $client->call('PS_UBI_SALA_ORDPAG',array($parametros));
if($servicioPS){
$hayResultado = false;
			for($i=0; $i <= 5 && !$hayResultado; $i++){
				// Envio de parametros por xml
				$start = time();
				$result = $client->call('UBI_CREA_ORDENPAG1_OPR_SRV',$xml);
				$time =  time()-$start;             
				$envio = 1;
				if($time>=40 || $result===false){
					$envio=0;
					if($i>=5){
						reportarCaida(1,'Creacion Orden Pago');
						$result['ERRNUM']=0;
					}
				} else {
						$hayResultado = true;
					}
					sleep(3); // this should halt for 3 seconds for every loop
		}			
} else {
	//para que si la cree en SALA de todas formas
	$result['ERRNUM']=0;
}

$query="INSERT INTO logtraceintegracionps (transaccionlogtraceintegracionps,enviologtraceintegracionps,respuestalogtraceintegracionps,documentologtraceintegracionps,estadoenvio) VALUES ('Creacion Orden Pago','".$xml."','id:".$result['ERRNUM']." descripcion: ".$result['DESCRLONG']."',".$datos['numeroordenpago'].",".$envio.")";
$orden = mysql_query($query, $sala) or die("$query" . mysql_error());
//$iderrorpeople=$result['ERRNUM'];
//$errorpeople=$result['DESCRLONG'];

//print_r($result);


// SE SUPONE QUE PARA NO MODIFICAR EL CODIGO ESTA FUNCION DEBERIA RETORNAR UN CODIGO, EN DONDE EL 0 ES EXITO.
/*    if ($client->fault) {
echo '<p><b>Fault: ';
echo "<pre>";
print_r($result);
echo "</pre>";
echo '</b></p>';
} 
else {
// Check for errors
$err = $client->getError();
if ($err) {
    // Display the error
    echo '<p><b>Error: ' . $err . '</b></p>';
}
else {
    // Display the result
    print_r($result);
}
}

// Impresion de funciones request, response, debug
echo '<h2>Request</h2>';
echo '<pre>' . htmlspecialchars($client->request, ENT_QUOTES) . '</pre>';
echo '<h2>Response</h2>';
echo '<pre>' . htmlspecialchars($client->response, ENT_QUOTES) . '</pre>';
echo '<h2>Debug</h2>';
echo '<pre>' . htmlspecialchars($client->debug_str, ENT_QUOTES) . '</pre>';
echo $national_id_type."<br>".$national_id."<br>".$invoice_id."<br>".$account_type_sf."<br>".$item_type."<br>".$payment_method."<br>".$item_amt."<br>".$item_effective_dt;

*/

?>
