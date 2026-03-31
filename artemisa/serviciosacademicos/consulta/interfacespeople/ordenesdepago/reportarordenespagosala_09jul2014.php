<?
require_once($_SESSION['path_live'].'Connections/sala2.php');
$rutaado = $_SESSION['path_live']."funciones/adodb/";
require_once($_SESSION['path_live'].'Connections/salaado.php');
require_once($_SESSION['path_live'].'consulta/interfacespeople/lib/nusoap.php');
require_once($_SESSION['path_live'].'consulta/interfacespeople/conexionpeople.php');
require_once($_SESSION['path_live'].'consulta/interfacespeople/cambia_fecha_people.php');

// SE PONE UN TIEMPO DE RESPUESTA DE 200 SEGUNDOS
$client = new soapclient(WEBORDENDEPAGO, true, false, false, false, false, 0, 200);
//$client = new soapclient(WEBORDENDEPAGO, true);

$err = $client->getError();
if ($err)
	echo '<h2>ERROR EN EL CONSTRUCTOR</h2><pre>' . $err . '</pre>';
$proxy = $client->getProxy();
/*echo"Datos<pre>";
print_r($datos);
echo"</pre>";*/
//exit();


$parametros['UBI_OPERACION_ORD']='C';
$parametros['NATIONAL_ID_TYPE']=$datos['tipodocumento'];
$parametros['NATIONAL_ID']=$datos['documento'];
$parametros['NATIONAL_ID_TYPE_OLD']="";
$parametros['NATIONAL_ID_OLD']="";
$parametros['FIRST_NAME']=$datos['primernombre'];
$parametros['MIDDLE_NAME']=$datos['segundonombre'];
$parametros['LAST_NAME']=$datos['primerapellido'];
$parametros['SECOND_LAST_NAME']=$datos['segundoapellido'];
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


$query="select tipocuenta from detalleordenpago dop join carreraconceptopeople ccp on dop.codigoconcepto=ccp.codigoconcepto where numeroordenpago='".$datos['numeroordenpago']."' group by tipocuenta";
$exec = mysql_query($query, $sala) or die("$query" . mysql_error());
while($row=mysql_fetch_array($exec))
	$arrTiposCuenta[]=$row['tipocuenta'];

$xml_det="";

if(in_array("MAT",$arrTiposCuenta)) {

	// VERIFICA SI LA ORDEN GENERADA TIENE CONCEPTOS ADICIONALES AL DE MATRICULA COMO POR EJEMPLO (TEXTOS, CARNET, SALDO A FAVOR)
	$query="SELECT	 COALESCE(ccp.itemcarreraconceptopeople,ccp2.itemcarreraconceptopeople) as itemcarreraconceptopeople
			,COALESCE(ccp.tipocuenta,ccp2.tipocuenta) as tipocuenta
			,dop.valorconcepto 
		FROM detalleordenpago dop 
		LEFT JOIN carreraconceptopeople ccp ON dop.codigoconcepto=ccp.codigoconcepto AND ".$datos['codigocarrera']."=ccp.codigocarrera
		LEFT JOIN carreraconceptopeople ccp2 ON dop.codigoconcepto=ccp2.codigoconcepto AND 1=ccp2.codigocarrera
		JOIN concepto c ON dop.codigoconcepto=c.codigoconcepto
		WHERE numeroordenpago='".$datos['numeroordenpago']."' AND concat(trim(cuentaoperacionprincipal),trim(cuentaoperacionparcial))<>'1510001'";
	//echo "<hr>$query<hr>";
	$exec = mysql_query($query, $sala) or die("$query" . mysql_error());
	if(mysql_num_rows($exec)==0) {
		$query2="SELECT	 COALESCE(ccp.itemcarreraconceptopeople,ccp2.itemcarreraconceptopeople) as item_ccp
				,COALESCE(ccp.tipocuenta,ccp2.tipocuenta) as tipocuenta
				,dop.valorconcepto		AS vlr_dop
				,sub.fechaordenpago
				,sub.valorfechaordenpago	AS vlr_sub
				,sub.itempagoextraordinario as item_sub
			FROM detalleordenpago dop
			LEFT JOIN carreraconceptopeople ccp ON dop.codigoconcepto=ccp.codigoconcepto and ".$datos['codigocarrera']."=ccp.codigocarrera
			LEFT JOIN carreraconceptopeople ccp2 ON dop.codigoconcepto=ccp2.codigoconcepto AND 1=ccp2.codigocarrera
			LEFT JOIN (     select distinct f.numeroordenpago, f.fechaordenpago, f.porcentajefechaordenpago, f.valorfechaordenpago, '010210020002' as itempagoextraordinario
					from fechaordenpago f
					where f.numeroordenpago='".$datos['numeroordenpago']."'
			) AS sub ON dop.numeroordenpago=sub.numeroordenpago
			WHERE dop.numeroordenpago='".$datos['numeroordenpago']."'
			ORDER BY sub.fechaordenpago";
		$exec2 = mysql_query($query2, $sala) or die("$query2" . mysql_error());
		$valorCargoAdd=0;
		while($row2=mysql_fetch_array($exec2)){
			if ($row2['vlr_dop']==$row2['vlr_sub']) {
				$item_type=$row2['item_ccp'];
				$item_type_to="";
			} else {
				$item_type=$row2['item_sub'];
				$item_type_to=$row2['item_ccp'];
			}
			$item_nbr="";
			$item_amt=$row2['vlr_sub']-$valorCargoAdd;
			$account_type_sf=$row2['tipocuenta'];
			$item_effective_dt=cambiaf_a_people($parametros['INVOICE_DT']);
			$due_dt2=cambiaf_a_people($row2['fechaordenpago']);

			$xml_det.="	<UBI_ITEM_WRK>
						<ITEM_TYPE>".$item_type."</ITEM_TYPE>
						<ITEM_TYPE_TO>".$item_type_to."</ITEM_TYPE_TO>
						<ITEM_NBR>".$item_nbr."</ITEM_NBR>
						<ITEM_AMT>".$item_amt."</ITEM_AMT>
						<ACCOUNT_TYPE_SF>".$account_type_sf."</ACCOUNT_TYPE_SF>
						<ITEM_EFFECTIVE_DT>".$item_effective_dt."</ITEM_EFFECTIVE_DT>
						<DUE_DT2>".$due_dt2."</DUE_DT2>
					</UBI_ITEM_WRK>";

			$valorCargoAdd=$row2['vlr_sub'];
		}
	} else {
		$items_excluir="";
		$suma_items_excluir1=0;
		$suma_items_excluir2=0;
		while($row=mysql_fetch_array($exec)) {
			// SI EL VALOR DE LOS CONCEPTOS ADICIONALES ES MENOR A CERO, SE TOMA COMO UN SALDO A FAVOR
			$items_excluir.=$row['itemcarreraconceptopeople'].",";
			if($row['valorconcepto']>0) {
				$suma_items_excluir2+=$row['valorconcepto'];
				$item_type=$row['itemcarreraconceptopeople'];
				$item_type_to="";
				$item_nbr="";
				$item_amt=$row['valorconcepto'];
				$account_type_sf=$row['tipocuenta'];
				$item_effective_dt=cambiaf_a_people($parametros['INVOICE_DT']);
				$due_dt2=cambiaf_a_people($parametros['DUE_DT']);

				$xml_det.="	<UBI_ITEM_WRK>
							<ITEM_TYPE>".$item_type."</ITEM_TYPE>
							<ITEM_TYPE_TO>".$item_type_to."</ITEM_TYPE_TO>
							<ITEM_NBR>".$item_nbr."</ITEM_NBR>
							<ITEM_AMT>".$item_amt."</ITEM_AMT>
							<ACCOUNT_TYPE_SF>".$account_type_sf."</ACCOUNT_TYPE_SF>
							<ITEM_EFFECTIVE_DT>".$item_effective_dt."</ITEM_EFFECTIVE_DT>
							<DUE_DT2>".$due_dt2."</DUE_DT2>
						</UBI_ITEM_WRK>";
			} else {
				$suma_items_excluir1+=$row['valorconcepto'];
			}
		}
		$query2="SELECT	 COALESCE(ccp.itemcarreraconceptopeople,ccp2.itemcarreraconceptopeople)	AS item_ccp
				,COALESCE(ccp.tipocuenta,ccp2.tipocuenta)				AS tipocuenta
				,dop.valorconcepto							AS vlr_dop
				,sub.fechaordenpago
				,sub.valorfechaordenpago + ".abs($suma_items_excluir1)."		AS vlr_sub
				,sub.itempagoextraordinario						AS item_sub
			FROM detalleordenpago dop
			LEFT JOIN carreraconceptopeople ccp ON dop.codigoconcepto=ccp.codigoconcepto and ".$datos['codigocarrera']."=ccp.codigocarrera
			LEFT JOIN carreraconceptopeople ccp2 ON dop.codigoconcepto=ccp2.codigoconcepto AND 1=ccp2.codigocarrera
			LEFT JOIN (     select distinct f.numeroordenpago, f.fechaordenpago, f.porcentajefechaordenpago, f.valorfechaordenpago, '010210020002' as itempagoextraordinario
					from fechaordenpago f
					where f.numeroordenpago='".$datos['numeroordenpago']."'
			) AS sub ON dop.numeroordenpago=sub.numeroordenpago
			WHERE dop.numeroordenpago='".$datos['numeroordenpago']."' AND COALESCE(ccp.itemcarreraconceptopeople,ccp2.itemcarreraconceptopeople) NOT IN (".trim($items_excluir,',').")
			ORDER BY sub.fechaordenpago";
		//echo $query2;
		$exec2 = mysql_query($query2, $sala) or die("$query2" . mysql_error());
		$valorCargoAdd=0;
		while($row2=mysql_fetch_array($exec2)){
			$vlrReal=$row2['vlr_sub']-$suma_items_excluir2;
			if ($row2['vlr_dop']==$vlrReal) {
				$item_type=$row2['item_ccp'];
				$item_type_to="";
				$suma_items_excluir2=0;
			} else {
				$item_type=$row2['item_sub'];
				$item_type_to=$row2['item_ccp'];
			}
			$item_nbr="";
			$item_amt=$vlrReal-$valorCargoAdd;
			$account_type_sf=$row2['tipocuenta'];
			$item_effective_dt=cambiaf_a_people($parametros['INVOICE_DT']);
			$due_dt2=cambiaf_a_people($row2['fechaordenpago']);

			$xml_det.="	<UBI_ITEM_WRK>
						<ITEM_TYPE>".$item_type."</ITEM_TYPE>
						<ITEM_TYPE_TO>".$item_type_to."</ITEM_TYPE_TO>
						<ITEM_NBR>".$item_nbr."</ITEM_NBR>
						<ITEM_AMT>".$item_amt."</ITEM_AMT>
						<ACCOUNT_TYPE_SF>".$account_type_sf."</ACCOUNT_TYPE_SF>
						<ITEM_EFFECTIVE_DT>".$item_effective_dt."</ITEM_EFFECTIVE_DT>
						<DUE_DT2>".$due_dt2."</DUE_DT2>
					</UBI_ITEM_WRK>";

			$valorCargoAdd=$vlrReal;
		}
	}
} elseif(in_array("PPA",$arrTiposCuenta)) {
	$parametros['UBI_OPERACION_ORD']='F';
	$query="select  COALESCE(ccp.itemcarreraconceptopeople,ccp2.itemcarreraconceptopeople) as itemcarreraconceptopeople
			,COALESCE(ccp.tipocuenta,ccp2.tipocuenta) as tipocuenta
			,dop.valorconcepto 
			,oppp.numerodocumentoplandepagosap as item_nbr
		from detalleordenpago dop
		LEFT JOIN carreraconceptopeople ccp ON dop.codigoconcepto=ccp.codigoconcepto AND ".$datos['codigocarrera']."=ccp.codigocarrera
		LEFT JOIN carreraconceptopeople ccp2 ON dop.codigoconcepto=ccp2.codigoconcepto AND 1=ccp2.codigocarrera
		join ordenpagoplandepago oppp on dop.numeroordenpago=oppp.numerorodencoutaplandepagosap and dop.codigoconcepto=oppp.cuentaxcobrarplandepagosap
		WHERE numeroordenpago=".$datos['numeroordenpago'];
	$exec = mysql_query($query, $sala) or die("$query" . mysql_error());
	while($row=mysql_fetch_array($exec)) {
		$item_type=$row['itemcarreraconceptopeople'];
		$item_type_to="";
		$item_nbr=$row['item_nbr'];
		$item_amt=$row['valorconcepto'];
		$account_type_sf=$row['tipocuenta'];
		$item_effective_dt=cambiaf_a_people($parametros['INVOICE_DT']);
		$due_dt2=cambiaf_a_people($parametros['DUE_DT']);
		$xml_det.="	<UBI_ITEM_WRK>
					<ITEM_TYPE>".$item_type."</ITEM_TYPE>
					<ITEM_TYPE_TO>".$item_type_to."</ITEM_TYPE_TO>
					<ITEM_NBR>".$item_nbr."</ITEM_NBR>
					<ITEM_AMT>".$item_amt."</ITEM_AMT>
					<ACCOUNT_TYPE_SF>".$account_type_sf."</ACCOUNT_TYPE_SF>
					<ITEM_EFFECTIVE_DT>".$item_effective_dt."</ITEM_EFFECTIVE_DT>
					<DUE_DT2>".$due_dt2."</DUE_DT2>
				</UBI_ITEM_WRK>";
	}
} else {
	// SI LA CONSULTA RETORNA RESULTADOS ES PORQUE LA ORDEN ES POR CONCEPTO DE INSCRIPCION.
	$query="select count(*) as conteo from detalleordenpago dop join concepto c on dop.codigoconcepto=c.codigoconcepto where numeroordenpago ='".$datos['numeroordenpago']."' and cuentaoperacionprincipal='153' and cuentaoperacionparcial='0001'";
	$exec = mysql_query($query, $sala) or die("$query" . mysql_error());
	$row=mysql_fetch_array($exec);
	if($row['conteo']>0) {
		// PROCESO PARA DETERMINAR EL DUMMY AL QUE SE ASOCIARÁ LA ORDEN DE PAGO DE INSCRIPCIÓN
		//************************************************************************************
		$execDummy = mysql_query("select * from logdummyintregracionps where codigoestado='100'",$sala);
		if(mysql_num_rows($execDummy)==0) {
			$execPer = mysql_query("select concat(substr(codigoperiodo,1,4),0,substr(codigoperiodo,5,1)) as codigoperiodo from periodo where codigoestadoperiodo=1",$sala);
			$rowPer=mysql_fetch_array($execPer);
			$NATIONAL_ID="PER".$rowPer["codigoperiodo"].date("Ymd");
			$cadenaDummy="insert into logdummyintregracionps (dummy,contador,codigoestado,numeroordenpagoinicial,numeroordenpagofinal) values ('".$NATIONAL_ID."',1,'100',".$datos['numeroordenpago'].",9999999)";
		} else {
			$rowDummy=mysql_fetch_array($execDummy);
			if($rowDummy["contador"]>=499)
				$cadenaDummy="update logdummyintregracionps set contador=contador+1,numeroordenpagofinal=".$datos['numeroordenpago'].",codigoestado='200' where idlogdummyintregracionps=".$rowDummy["idlogdummyintregracionps"];
			else
				$cadenaDummy="update logdummyintregracionps set contador=contador+1 where idlogdummyintregracionps=".$rowDummy["idlogdummyintregracionps"];
			$NATIONAL_ID=$rowDummy["dummy"];
		}
		mysql_query($cadenaDummy,$sala);
		//************************************************************************************
		$parametros['INVOICE_ID']=$_GET['numeroordenpago'];
		$parametros['NATIONAL_ID_TYPE']='CC';
		$parametros['NATIONAL_ID']=$NATIONAL_ID;
		$parametros['FIRST_NAME']='DUMMY';
		$parametros['MIDDLE_NAME']='DUMMY';
		$parametros['LAST_NAME']='DUMMY';
		$parametros['SECOND_LAST_NAME']='DUMMY';
		$parametros['BIRTHDATE']='1900-01-01';
		$parametros['BIRTHCOUNTRY']='CO';
		$parametros['BIRTHSTATE']='11';
		$parametros['BIRTHPLACE']='11001';
		$parametros['SEX']='F';
		$parametros['MAR_STATUS']='S';
		$parametros['ADDRESS1']='KR 7B BIS No. 132-11';
		$parametros['PHONE']='57 1 6331368';
		$parametros['EMAIL_ADDR']='dummy@unbosque.edu.co';
		$parametros['INVOICE_ID']=$datos['numeroordenpago']."-".$datos['tipodocumento'].$datos['documento'];
	}	
	$query2="SELECT	 COALESCE(ccp.itemcarreraconceptopeople,ccp2.itemcarreraconceptopeople) as itemcarreraconceptopeople
			,COALESCE(ccp.tipocuenta,ccp2.tipocuenta) as tipocuenta
			,dop.valorconcepto 
		FROM detalleordenpago dop
		LEFT JOIN carreraconceptopeople ccp ON dop.codigoconcepto=ccp.codigoconcepto AND ".$datos['codigocarrera']."=ccp.codigocarrera
		LEFT JOIN carreraconceptopeople ccp2 ON dop.codigoconcepto=ccp2.codigoconcepto AND 1=ccp2.codigocarrera
		WHERE numeroordenpago=".$datos['numeroordenpago'];
	$exec2 = mysql_query($query2, $sala) or die("$query2" . mysql_error());
	while($row2=mysql_fetch_array($exec2)){
		$item_type=$row2['itemcarreraconceptopeople'];
		$item_type_to="";
		$item_nbr="";
		$item_amt=$row2['valorconcepto'];
		$account_type_sf=$row2['tipocuenta'];
		$item_effective_dt=cambiaf_a_people($parametros['INVOICE_DT']);
		$due_dt2=cambiaf_a_people($parametros['DUE_DT']);

		$xml_det.="	<UBI_ITEM_WRK>
					<ITEM_TYPE>".$item_type."</ITEM_TYPE>
					<ITEM_TYPE_TO>".$item_type_to."</ITEM_TYPE_TO>
					<ITEM_NBR>".$item_nbr."</ITEM_NBR>
					<ITEM_AMT>".$item_amt."</ITEM_AMT>
					<ACCOUNT_TYPE_SF>".$account_type_sf."</ACCOUNT_TYPE_SF>
					<ITEM_EFFECTIVE_DT>".$item_effective_dt."</ITEM_EFFECTIVE_DT>
					<DUE_DT2>".$due_dt2."</DUE_DT2>
				</UBI_ITEM_WRK>";
	}
} 

$xml="	<m:messageRequest xmlns:m=\"http://xmlns.oracle.com/Enterprise/Tools/schemas/UBI_CREA_ORDENPAG_REQ_MSG.VERSION_1\">
		<UBI_OPERACION_ORD>".$parametros['UBI_OPERACION_ORD']."</UBI_OPERACION_ORD>
		<NATIONAL_ID_TYPE>".$parametros['NATIONAL_ID_TYPE']."</NATIONAL_ID_TYPE>
		<NATIONAL_ID>".$parametros['NATIONAL_ID']."</NATIONAL_ID>
		<NATIONAL_ID_TYPE_OLD>".$parametros['NATIONAL_ID_TYPE_OLD']."</NATIONAL_ID_TYPE_OLD>
		<NATIONAL_ID_OLD>".$parametros['NATIONAL_ID_OLD']."</NATIONAL_ID_OLD>
		<FIRST_NAME>".utf8_encode($parametros['FIRST_NAME'])."</FIRST_NAME>
		<MIDDLE_NAME>".utf8_encode($parametros['MIDDLE_NAME'])."</MIDDLE_NAME>
		<LAST_NAME>".utf8_encode($parametros['LAST_NAME'])."</LAST_NAME>
		<SECOND_LAST_NAME>".utf8_encode($parametros['SECOND_LAST_NAME'])."</SECOND_LAST_NAME>
		<BIRTHDATE>".cambiaf_a_people($parametros['BIRTHDATE'])."</BIRTHDATE>
		<BIRTHCOUNTRY>".$parametros['BIRTHCOUNTRY']."</BIRTHCOUNTRY>
		<BIRTHSTATE>".$parametros['BIRTHSTATE']."</BIRTHSTATE>
		<BIRTHPLACE>".$parametros['BIRTHPLACE']."</BIRTHPLACE>
		<SEX>".$parametros['SEX']."</SEX>
		<MAR_STATUS>".$parametros['MAR_STATUS']."</MAR_STATUS>
		<ADDRESS1>".utf8_encode($parametros['ADDRESS1'])."</ADDRESS1>
		<PHONE>".$parametros['PHONE']."</PHONE>
		<EMAIL_ADDR>".utf8_encode($parametros['EMAIL_ADDR'])."</EMAIL_ADDR>
		<BUSINESS_UNIT>".$parametros['BUSINESS_UNIT']."</BUSINESS_UNIT>
		<INVOICE_ID>".$parametros['INVOICE_ID']."</INVOICE_ID>
		<INVOICE_DT>".cambiaf_a_people($parametros['INVOICE_DT'])."</INVOICE_DT>
		<DUE_DT1>".cambiaf_a_people($parametros['DUE_DT'])."</DUE_DT1>
		<TOTAL_BILL>".$parametros['TOTAL_BILL']."</TOTAL_BILL>
		<STRM>".$parametros['STRM']."</STRM>
		<UBI_ITEMS_WRK>
			".$xml.=$xml_det."
		</UBI_ITEMS_WRK>
	</m:messageRequest>";
//echo "<h1>aquuiiiiiiiiii</h1>";

//echo $xml;
// Envio de parametros con arreglo
//$result = $client->call('PS_UBI_SALA_ORDPAG',array($parametros));
// Envio de parametros por xml
$result = $client->call('UBI_CREA_ORDENPAG1_OPR_SRV',$xml);

$query="INSERT INTO logtraceintegracionps (transaccionlogtraceintegracionps,enviologtraceintegracionps,respuestalogtraceintegracionps,documentologtraceintegracionps) VALUES ('Creacion Orden Pago','".$xml."','id:".$result['ERRNUM']." descripcion: ".$result['DESCRLONG']."',".$datos['numeroordenpago'].")";
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
