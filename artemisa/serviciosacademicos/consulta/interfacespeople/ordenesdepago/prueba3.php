<?

function restaHoras($horaIni, $horaFin){
	return (date("H:i:s", strtotime("00:00:00") + strtotime($horaFin) - strtotime($horaIni) ));
}

function parteHora( $hora )
{    
    $horaSplit = explode(":", $hora);

    if( count($horaSplit) < 3 )
    {
	$horaSplit[2] = 0;
    }
    
    return $horaSplit;
}

// funcion que devuelve la suma de dos horas en formato horas:minutos:segundos
// Devuelve FALSE si se ha producido algun error
function SumaHoras( $time1, $time2 )
{
    list($hour1, $min1, $sec1) = parteHora($time1);
    list($hour2, $min2, $sec2) = parteHora($time2);

    return date('H:i:s', mktime( $hour1 + $hour2, $min1 + $min2, $sec1 + $sec2));
}  

echo "	<form name='forma' action='' method='post'>
	<table align='center' border='1'>
	<tr>
		<th colspan='2'>Generar ordenes de inscripci&oacute;n</th>
	</tr>
	<tr>
		<td>Numero dummy</td>
		<th><input type='text' name='dummy' value='".$_REQUEST['dummy']."' size='4' style='text-align:center'></th>
	</tr>
	<tr>
		<td>Ultima orden</td>
		<th><input type='text' name='ult_ord' value='".$_REQUEST['ult_ord']."' size='2' style='text-align:center'></th>
	</tr>
	<tr>
		<td>Nro de ordenes a generar</td>
		<th><input type='text' name='nro_ord' value='".$_REQUEST['nro_ord']."' size='2' style='text-align:center'></th>
	</tr>
	<tr>
		<th colspan='2'><input type='submit' name='accion' value='Generar'></th>
	</tr>
	</table>";

if($_REQUEST['accion']=='Generar') {
	require_once('/usr/local/apache2/htdocs/html/serviciosacademicos/consulta/interfacespeople/lib/nusoap.php');

	$client = new soapclient("http://campus.unbosque.edu.co/PSIGW/PeopleSoftServiceListeningConnector/UBI_CREA_ORDENPAG_SRV.1.wsdl", true);

	$err = $client->getError();
	if ($err)
		echo '<h2>ERROR EN EL CONSTRUCTOR</h2><pre>' . $err . '</pre>';
	$proxy = $client->getProxy();

	echo "	<br>
		<table align='center' border='1'>
		<tr>
			<th></th>
			<th>Numero dummy</th>
			<th>Numero de orden</th>
			<th>Numero de documento</th>
			<th>Envio</th>
			<th>Respuesta</th>
			<th>Hora inicio</th>
			<th>Hora fin</th>
			<th>Diferencia</th>
		</tr>";
	$j=1;
	$horas_aux='00:00:00';
	for($i=$_REQUEST['ult_ord'];$i<$_REQUEST['ult_ord']+$_REQUEST['nro_ord'];$i++) {
		$numero_orden="999".str_pad($i,4,"0",STR_PAD_LEFT);
		$numero_documento="111111".str_pad($i,4,"0",STR_PAD_LEFT);
		$xml="	<m:messageRequest xmlns:m='http://xmlns.oracle.com/Enterprise/Tools/schemas/UBI_CREA_ORDENPAG_REQ_MSG.VERSION_1'>
				<UBI_OPERACION_ORD>C</UBI_OPERACION_ORD>
				<NATIONAL_ID_TYPE>CC</NATIONAL_ID_TYPE>
				<NATIONAL_ID>".$_REQUEST['dummy']."</NATIONAL_ID>
				<NATIONAL_ID_TYPE_OLD></NATIONAL_ID_TYPE_OLD>
				<NATIONAL_ID_OLD></NATIONAL_ID_OLD>
				<FIRST_NAME>DUMMY</FIRST_NAME>
				<MIDDLE_NAME>DUMMY</MIDDLE_NAME>
				<LAST_NAME>DUMMY</LAST_NAME>
				<SECOND_LAST_NAME>DUMMY</SECOND_LAST_NAME>
				<BIRTHDATE>01011900</BIRTHDATE>
				<BIRTHCOUNTRY>CO</BIRTHCOUNTRY>
				<BIRTHSTATE>11</BIRTHSTATE>
				<BIRTHPLACE>11001</BIRTHPLACE>
				<SEX>H</SEX>
				<MAR_STATUS>S</MAR_STATUS>
				<ADDRESS1>KR 7B BIS No. 132-11</ADDRESS1>
				<PHONE>57 1 6331368</PHONE>
				<EMAIL_ADDR>dummy@unbosque.edu.co</EMAIL_ADDR>
				<BUSINESS_UNIT>UBSF0</BUSINESS_UNIT>
				<INVOICE_ID>".$numero_orden."-CC".$numero_documento."</INVOICE_ID>
				<INVOICE_DT>12312012</INVOICE_DT>
				<DUE_DT1>12312012</DUE_DT1>
				<TOTAL_BILL>333333</TOTAL_BILL>
				<STRM>1201</STRM>
				<UBI_ITEMS_WRK>
					<UBI_ITEM_WRK>
						<ITEM_TYPE>012321190023</ITEM_TYPE>
						<ITEM_TYPE_TO></ITEM_TYPE_TO>
						<ITEM_NBR></ITEM_NBR>
						<ITEM_AMT>333333</ITEM_AMT>
						<ACCOUNT_TYPE_SF>NAC</ACCOUNT_TYPE_SF>
						<ITEM_EFFECTIVE_DT>12312012</ITEM_EFFECTIVE_DT>
					<DUE_DT2>12312012</DUE_DT2>
				</UBI_ITEM_WRK>
			</UBI_ITEMS_WRK>
		</m:messageRequest>";
		$hora_inicio=date("h:i:s");
		$result = $client->call('UBI_CREA_ORDENPAG1_OPR_SRV',$xml);
		$hora_fin=date("h:i:s");
		echo "	<tr>
				<td>$j</td>
				<td>".$_REQUEST['dummy']."</td>
				<td>".$numero_orden."</td>
				<td>".$numero_documento."</td>
				<td>".htmlentities($xml)."</td>
				<td><b>ID:</b> ".$result['ERRNUM']."<br><b>DESCRIPCION:</b> ".$result['DESCRLONG']."</td>
				<td>".$hora_inicio."</td>
				<td>".$hora_fin."</td>
				<td>".restaHoras($hora_inicio,$hora_fin)."</td>
			</tr>";
			$horas_tot=sumaHoras($horas_aux,restaHoras($hora_inicio,$hora_fin));
			$horas_aux=$horas_tot;
		$j++;
	}
	echo "<tr><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><td><b>$horas_tot</b></td></tr>";
	echo "</table>";
}
echo "	</form>";
?>
