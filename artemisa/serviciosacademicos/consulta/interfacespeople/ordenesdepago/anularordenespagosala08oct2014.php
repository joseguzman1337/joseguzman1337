<?php 
require_once(dirname(__FILE__).'/../../../Connections/sala2.php');
$rutaado = dirname(__FILE__)."/../../../funciones/adodb/";
require_once(dirname(__FILE__).'/../../../Connections/salaado.php');
//require_once(dirname(__FILE__).'/../../../consulta/interfacespeople/lib/nusoap.php');
require_once(dirname(__FILE__).'/../../../consulta/interfacespeople/conexionpeople.php');
require_once(dirname(__FILE__).'/../../../../nusoap/lib/nusoap.php');

	$results=array();
	require_once(dirname(__FILE__).'/../../interfacespeople/reporteCaidaPeople.php');
	$envio=0;
	$servicioPS = verificarPSEnLinea();
	if($servicioPS){
		$client = new nusoap_client(WEBORDENDEPAGO, true, false, false, false, false, 0, 30);
		$err = $client->getError();
		if ($err)
			echo '<h2>ERROR EN EL CONSTRUCTOR</h2><pre>' . $err . '</pre>';
		$proxy = $client->getProxy();
	}


		$query="select tipocuenta from detalleordenpago dop join carreraconceptopeople ccp on dop.codigoconcepto=ccp.codigoconcepto where numeroordenpago='".$_GET['numeroordenpago']."' group by tipocuenta";
		$exec = mysql_query($query, $sala) or die("$query" . mysql_error());
		while($row=mysql_fetch_array($exec))
			$arrTiposCuenta[]=$row['tipocuenta'];

		if(in_array("PPA",$arrTiposCuenta))
			$parametros['UBI_OPERACION_ORD']='R';
		else
			$parametros['UBI_OPERACION_ORD']='A';

		$query="select codigodocumentopeople from estudiantegeneral eg join documentopeople dp on dp.tipodocumentosala = eg.tipodocumento where numerodocumento='".$_GET['documentoingreso']."'";
		$queryExec = $db->Execute($query) or die("$query<br>".mysql_error());
		$row = $queryExec->FetchRow();
		$codigodocumentopeople=$row['codigodocumentopeople'];


		//verifica si la orden de pago es por concepto de inscripcion
		$query="select count(*) as conteo from detalleordenpago dop join concepto c on dop.codigoconcepto=c.codigoconcepto where numeroordenpago ='".$_GET['numeroordenpago']."' and cuentaoperacionprincipal='153' and cuentaoperacionparcial='0001'";
		$queryExec = $db->Execute($query) or die("$query<br>".mysql_error());
		$row = $queryExec->FetchRow();

		if($row['conteo']==0) {
			$parametros['INVOICE_ID']=$_GET['numeroordenpago'];
			$parametros['NATIONAL_ID_TYPE']=$codigodocumentopeople;
			$parametros['NATIONAL_ID']=$_GET['documentoingreso'];
		} else {
			$parametros['INVOICE_ID']=$_GET['numeroordenpago']."-".$codigodocumentopeople.$_GET['documentoingreso'];
			$parametros['NATIONAL_ID_TYPE']='CC';
			if($_GET['numeroordenpago']<=1492166)
				$parametros['NATIONAL_ID']='88888888';
				elseif($numeroordenpago>1492166 && $numeroordenpago<=1494345)
				$parametros['NATIONAL_ID']='PER20120101';
				elseif($numeroordenpago>1494345 && $numeroordenpago<=1498522)
				$parametros['NATIONAL_ID']='PER20120102';
				elseif($numeroordenpago>1498522 && $numeroordenpago<=1547348)
				$parametros['NATIONAL_ID']='PER20120103';
			else
				$parametros['NATIONAL_ID']='PER20120201';
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
if($servicioPS){
		// Envio de parametros por xml
		$start = time();
		$result = $client->call('UBI_CREA_ORDENPAG1_OPR_SRV',$xml);
		$time =  time()-$start;             
		$envio = 1;
		if($time>=40 || $result===false){
			$envio=0;
			reportarCaida(1,'Anulacion Orden Pago');
			$result['ERRNUM']=0;
		} 
} else {
	//para que si la anule en SALA de todas formas
	$result['ERRNUM']=0;
}
$query="INSERT INTO logtraceintegracionps (transaccionlogtraceintegracionps,enviologtraceintegracionps,respuestalogtraceintegracionps,documentologtraceintegracionps,estadoenvio) VALUES ('Anulacion Orden Pago','".$xml."','id:".$result['ERRNUM']." descripcion: ".$result['DESCRLONG']."',".$_GET['numeroordenpago'].",".$envio.")";
mysql_query($query, $sala) or die("$query" . mysql_error());

?>
