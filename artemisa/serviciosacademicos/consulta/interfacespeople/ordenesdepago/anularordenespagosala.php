<?php

if (isset($_GET['modulo']) and $_GET['modulo'] == 'cambioCargaAcademica') {
	require(dirname(__FILE__).'/../../../Connections/sala2.php');
	$rutaado = dirname(__FILE__)."/../../../funciones/adodb/";
	require(dirname(__FILE__).'/../../../Connections/salaado.php');
	require(dirname(__FILE__).'/../../../consulta/interfacespeople/conexionpeople.php');
	require(dirname(__FILE__).'/../../../../nusoap/lib/nusoap.php');
	require(dirname(__FILE__).'/../../interfacespeople/reporteCaidaPeople.php');
}else{
	require_once(dirname(__FILE__).'/../../../Connections/sala2.php');
	$rutaado = dirname(__FILE__)."/../../../funciones/adodb/";
	require_once(dirname(__FILE__).'/../../../Connections/salaado.php');
	require_once(dirname(__FILE__).'/../../../consulta/interfacespeople/conexionpeople.php');
	require_once(dirname(__FILE__).'/../../../../nusoap/lib/nusoap.php');
	require_once(dirname(__FILE__).'/../../interfacespeople/reporteCaidaPeople.php');
}

$results=array();
$envio=0;
$servicioPS = verificarPSEnLinea();
	
if($servicioPS){
	$client = new nusoap_client(WEBORDENDEPAGO, true, false, false, false, false, 0, 30);
	$err = $client->getError();
	if ($err){
		echo '<h2>ERROR EN EL CONSTRUCTOR</h2><pre>' . $err . '</pre>';
	}
	$proxy = $client->getProxy();
}

//si no existe el parametro del documento del estudiante, se obtiene desde la orden de pago

if (!isset($_GET['documentoingreso'])) {

	$query= "select e2.numerodocumento from ordenpago o join estudiante e on o.codigoestudiante = e.codigoestudiante
	join estudiantegeneral e2 on e.idestudiantegeneral = e2.idestudiantegeneral
	where numeroordenpago ='".$_GET['numeroordenpago']."'";

	$exec = mysql_query($query, $sala) or die("$query" . mysql_error());

	$row = mysql_fetch_array($exec);

	$_GET['documentoingreso'] = $row['numerodocumento'];
	
}


$query="SELECT tipocuenta FROM detalleordenpago dop ".
" JOIN carreraconceptopeople ccp ON dop.codigoconcepto=ccp.codigoconcepto ".
" WHERE numeroordenpago='".$_GET['numeroordenpago']."' GROUP BY tipocuenta";

$exec = mysql_query($query, $sala) or die("$query" . mysql_error());

while($row=mysql_fetch_array($exec)){
	$arrTiposCuenta[]=$row['tipocuenta'];
}

if(in_array("PPA",$arrTiposCuenta)){
	$parametros['UBI_OPERACION_ORD']='R';
} else {
	$parametros['UBI_OPERACION_ORD']='A';
}
$query="SELECT dp.codigodocumentopeople, eg.numerodocumento FROM estudiantegeneral eg ".
" JOIN documentopeople dp ON dp.tipodocumentosala = eg.tipodocumento ".
" WHERE eg.numerodocumento='".$_GET['documentoingreso']."'";

$queryExec = $db->Execute($query) or die("$query<br>".mysql_error());
$row = $queryExec->FetchRow();

$codigodocumentopeople=$row['codigodocumentopeople'];
$numerodocumento = $row['numerodocumento'];

//verifica si la orden de pago es por concepto de inscripcion
$query="SELECT COUNT(*) as conteo  FROM detalleordenpago dop ".
" JOIN concepto c ON dop.codigoconcepto=c.codigoconcepto ".
" WHERE numeroordenpago ='".$_GET['numeroordenpago']."' AND cuentaoperacionprincipal='153' ".
" AND cuentaoperacionparcial='0001'";
$queryExec = $db->Execute($query) or die("$query<br>".mysql_error());
$row = $queryExec->FetchRow();

$invoiceNormal = true;
if($row['conteo']==0) {
	$parametros['INVOICE_ID']=$_GET['numeroordenpago'];
	$parametros['NATIONAL_ID_TYPE']=$codigodocumentopeople;

	$queryDocumento = "SELECT eg.numerodocumento FROM ordenpago o ".
   " INNER JOIN estudiante e on e.codigoestudiante=o.codigoestudiante ".
   " INNER JOIN estudiantegeneral eg on eg.idestudiantegeneral=e.idestudiantegeneral ".
	" WHERE o.numeroordenpago = ".mysql_real_escape_string($_GET['numeroordenpago']);
	$queryEscDoc = $db->Execute($queryDocumento) or die("$queryDocumento<br>".mysql_error());
	$doc = $queryEscDoc->FetchRow();

	if(!empty($doc['numerodocumento'])){
		$parametros['NATIONAL_ID']=$doc['numerodocumento'];
	}else{
		$parametros['NATIONAL_ID']=$_GET['documentoingreso'];
	}
} else {
	//Inscripcion
	$sqlFechaOrdenPago="SELECT fechaordenpago  FROM ordenpago  WHERE  numeroordenpago=".$_GET['numeroordenpago'];
    $execsqlFechaOrdenPago= $db->Execute($sqlFechaOrdenPago) or die("$sqlFechaOrdenPago".mysql_error());
    $rowsqlFechaOrdenPago = $execsqlFechaOrdenPago->FetchRow();

    if($rowsqlFechaOrdenPago['fechaordenpago']  <= '2020-09-17')	{
    	$parametros['INVOICE_ID']=$_GET['numeroordenpago']."-".$codigodocumentopeople.$_GET['documentoingreso'];
	    $parametros['NATIONAL_ID_TYPE']='CC';
	    $invoiceNormal=false;
		$query = "SELECT dummy  FROM logdummyintregracionps ".
	   " WHERE ".$_GET['numeroordenpago']." BETWEEN numeroordenpagoinicial AND numeroordenpagofinal";
		$execDummy = $db->Execute($query);
		$rowDummy = $execDummy->FetchRow();
		$parametros['NATIONAL_ID']=$rowDummy["dummy"];
    }else{
	    $parametros['INVOICE_ID']=$_GET['numeroordenpago'];
		$parametros['NATIONAL_ID_TYPE']=$codigodocumentopeople;
		$invoiceNormal=false;
		$parametros['NATIONAL_ID']=$numerodocumento ;	
    }
}

$parametros['BUSINESS_UNIT']='UBSF0';

$xml="
	<m:messageRequest xmlns:m=\"http://xmlns.oracle.com/Enterprise/Tools/schemas/UBI_CREA_ORDENPAG_REQ_MSG.VERSION_1\">
		<UBI_OPERACION_ORD>".$parametros['UBI_OPERACION_ORD']."</UBI_OPERACION_ORD>
		<NATIONAL_ID_TYPE>".$parametros['NATIONAL_ID_TYPE']."</NATIONAL_ID_TYPE>
		<NATIONAL_ID>".$parametros['NATIONAL_ID']."</NATIONAL_ID>
		<INVOICE_ID>".$parametros['INVOICE_ID']."</INVOICE_ID>
		<BUSINESS_UNIT>".$parametros['BUSINESS_UNIT']."</BUSINESS_UNIT>
	</m:messageRequest>";

if($servicioPS){
	$hayResultado = false;
	for($i=0; $i <= 5 && !$hayResultado; $i++){
		// Envio de parametros por xml
		$start = time();
		$result = $client->call('UBI_CREA_ORDENPAG1_OPR_SRV',$xml);
		$time =  time()-$start;
		$envio = 1;
		
		if(($time>=30 || $result===false)){
			$envio=0;
			if($i>=5){
				reportarCaida(1,'Anulacion Orden Pago');
				$result['ERRNUM']=0;
			}
		} else {
			$hayResultado = true;
		}
		
		sleep(3); // this should halt for 3 seconds for every loop
	}
	
	if($result['ERRNUM']==1 && strpos($result['DESCRLONG'],'La FACTURA no existe')!== false){
		//revisar si el estudiante ha cambiado de documento en este año e intentar anularla con el antiguo
		$query = "SELECT ed.numerodocumento,d.nombrecortodocumento ".
		" FROM estudiantegeneral eg ".
		" INNER JOIN estudiantedocumento ed ON ed.idestudiantegeneral=eg.idestudiantegeneral ".
		" INNER JOIN documento d ON d.tipodocumento=ed.tipodocumento ".
		" WHERE eg.numerodocumento='".$_GET['documentoingreso']."' ".
		" AND (fechavencimientoestudiantedocumento>='".date('Y')."-01-01' ".
		" and fechavencimientoestudiantedocumento<='".date('Y')."-12-31') ".
		" AND eg.numerodocumento<>ed.numerodocumento AND eg.tipodocumento<>ed.tipodocumento ".
		" ORDER BY fechavencimientoestudiantedocumento DESC";
		$row = $db->GetRow($query);
		
		if(count($row)>0){
			if($invoiceNormal) {
				$parametros['INVOICE_ID']=$_GET['numeroordenpago'];
				$parametros['NATIONAL_ID_TYPE']=$row["nombrecortodocumento"];
				$parametros['NATIONAL_ID']=$row["numerodocumento"];
			} else {
				$parametros['INVOICE_ID']=$_GET['numeroordenpago']."-".$row["nombrecortodocumento"].$row["numerodocumento"];
				$parametros['NATIONAL_ID_TYPE']='CC';
			}
			
			$xml=" <m:messageRequest xmlns:m=\"http://xmlns.oracle.com/Enterprise/Tools/schemas/UBI_CREA_ORDENPAG_REQ_MSG.VERSION_1\">
				<UBI_OPERACION_ORD>".$parametros['UBI_OPERACION_ORD']."</UBI_OPERACION_ORD>
				<NATIONAL_ID_TYPE>".$parametros['NATIONAL_ID_TYPE']."</NATIONAL_ID_TYPE>
				<NATIONAL_ID>".$parametros['NATIONAL_ID']."</NATIONAL_ID>
				<INVOICE_ID>".$parametros['INVOICE_ID']."</INVOICE_ID>
				<BUSINESS_UNIT>".$parametros['BUSINESS_UNIT']."</BUSINESS_UNIT>
				</m:messageRequest>";
			
			$start = time();
			$result = $client->call('UBI_CREA_ORDENPAG1_OPR_SRV',$xml);
			$time =  time()-$start;
			$envio = 1;
			if( $time>=30 || $result===false ){
				$envio=0;
				reportarCaida(1,'Anulacion Orden Pago');
				$result['ERRNUM']=0;
			} else {
				$hayResultado = true;
			}
			//var_dump($xml);exit; die;
		} else {
			//anularla igual porque no existe en people
			$result['ERRNUM']=0;
		}
	} else if($result['ERRNUM']==1 && strpos($result['DESCRLONG'],'La FACTURA esta en estado A')!== false){
		//para que si la anule en SALA de todas formas porque en people ya se anulo
		$result['ERRNUM']=0;
	}
} else {
	//para que si la anule en SALA de todas formas
	$result['ERRNUM']=0;
}

$query="INSERT INTO logtraceintegracionps (transaccionlogtraceintegracionps,enviologtraceintegracionps,".
" respuestalogtraceintegracionps,documentologtraceintegracionps,estadoenvio) VALUES ('Anulacion Orden Pago','".$xml.
"','id:".$result['ERRNUM']." descripcion: ".$result['DESCRLONG']."',".$_GET['numeroordenpago'].",".$envio.")";
mysql_query($query, $sala) or die("$query" . mysql_error());
