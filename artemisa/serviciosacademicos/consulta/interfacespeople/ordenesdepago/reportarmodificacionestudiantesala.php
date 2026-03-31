<?php
require_once(realpath(dirname(__FILE__)) . '/../../../Connections/sala2.php');
$rutaado = realpath(dirname(__FILE__)) . "/../../../funciones/adodb/";
require_once(realpath(dirname(__FILE__)) . '/../../../Connections/salaado.php');
if (!class_exists('../../consulta/interfacespeople/lib/nusoap.php')) {
    require_once(realpath(dirname(__FILE__)) . '/../../../consulta/interfacespeople/lib/nusoap.php');
} else {
    require_once(realpath(dirname(__FILE__)) . '/../../../../nusoap/lib/nusoap.php');
}
require_once(realpath(dirname(__FILE__)) . '/../../interfacespeople/conexionpeople.php');
require_once(realpath(dirname(__FILE__)) . '/../../interfacespeople/cambia_fecha_people.php');

function limpiarCadena($cadena)
{
    $cadena = (ereg_replace('[^ A-Za-z0-9_ñÑáéíóúÁÉÍÓÚ\s]', '', $cadena));
    return $cadena;
}

$results = array();
require_once(dirname(__FILE__) . '/../../interfacespeople/reporteCaidaPeople.php');
$envio = 0;
$servicioPS = verificarPSEnLinea();
if ($servicioPS) {
    $client = new nusoap_client(WEBORDENDEPAGO, true, false, false, false, false, 0, 200);
    $err = $client->getError();
    if ($err)
        echo '<h2>ERROR EN EL CONSTRUCTOR</h2><pre>' . $err . '</pre>';
    $proxy = $client->getProxy();
}
$parametros['UBI_OPERACION_ORD'] = 'U';

$query = "select codigodocumentopeople from documentopeople where tipodocumentosala='" . $_REQUEST['tipodocumento'] . "'";
$exec = mysql_query($query, $sala) or die("$query" . mysql_error());
$row = mysql_fetch_array($exec);
$vtipodocumentonew = $row['codigodocumentopeople'];

$query = "select codigodocumentopeople from documentopeople where tipodocumentosala='" . $_REQUEST['tipodocumentoold'] . "'";
$exec = mysql_query($query, $sala) or die("$query" . mysql_error());
$row = mysql_fetch_array($exec);
$vtipodocumentoold = $row['codigodocumentopeople'];

$parametros['NATIONAL_ID_TYPE'] = $vtipodocumentonew;
$parametros['NATIONAL_ID'] = $_REQUEST['documento'];

if ($vtipodocumentonew != $vtipodocumentoold || $_REQUEST['documento'] != $_REQUEST['documentoold']) {
    $parametros['NATIONAL_ID_TYPE_OLD'] = $vtipodocumentoold;
    $parametros['NATIONAL_ID_OLD'] = $_REQUEST['documentoold'];
} else {
    $parametros['NATIONAL_ID_TYPE_OLD'] = "";
    $parametros['NATIONAL_ID_OLD'] = "";
}

$posApell = strpos(trim($_REQUEST['apellidos']), " ");
if ($posApell > 0) {
    $primerapellido = substr(trim($_REQUEST['apellidos']), 0, $posApell);
    $segundoapellido = substr(trim($_REQUEST['apellidos']), $posApell + 1, strlen(trim($_REQUEST['apellidos'])));
} else {
    $primerapellido = trim($_REQUEST['apellidos']);
    $segundoapellido = "";
}
$posNomb = strpos(trim($_REQUEST['nombres']), " ");
if ($posNomb > 0) {
    $primernombre = substr(trim($_REQUEST['nombres']), 0, $posNomb);
    $segundonombre = substr(trim($_REQUEST['nombres']), $posNomb + 1, strlen(trim($_REQUEST['nombres'])));
} else {
    $primernombre = trim($_REQUEST['nombres']);
    $segundonombre = "";
}
$parametros['FIRST_NAME'] = limpiarCadena(filter_var($primernombre, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES));
$parametros['MIDDLE_NAME'] = limpiarCadena(filter_var($segundonombre, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES));
$parametros['LAST_NAME'] = limpiarCadena(filter_var($primerapellido, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES));
$parametros['SECOND_LAST_NAME'] = limpiarCadena(filter_var($segundoapellido, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES));

$parametros['BIRTHDATE'] = $_REQUEST['fnacimiento'];

$query = "select p.codigosappais
		,d.codigosapdepartamento
		,c.codigosapciudad
	from ciudad c
	join departamento d using(iddepartamento)
	join pais p using(idpais)
	where idciudad=" . $_REQUEST['ciudad1'];
$exec = mysql_query($query, $sala) or die("$query" . mysql_error());
$row = mysql_fetch_array($exec);
$parametros['BIRTHCOUNTRY'] = $row['codigosappais'];
$parametros['BIRTHSTATE'] = $row['codigosapdepartamento'];
$parametros['BIRTHPLACE'] = $row['codigosapciudad'];

$query = "select codigopeoplesexo from sexopeople where codigosexo=" . $_REQUEST['genero'];
$exec = mysql_query($query, $sala) or die("$query" . mysql_error());
$row = mysql_fetch_array($exec);
$parametros['SEX'] = $row['codigopeoplesexo'];

$query = "select codigoestadocivilpeople from estudiantegeneral join estadocivilpeople using(idestadocivil) where numerodocumento='" . $_REQUEST['documentoold'] . "'";
$exec = mysql_query($query, $sala) or die("$query" . mysql_error());
$row = mysql_fetch_array($exec);
$parametros['MAR_STATUS'] = $row['codigoestadocivilpeople'];

$parametros['ADDRESS1'] = trim($_REQUEST['direccion1']);
if ($parametros['ADDRESS1'] == "") {
    $parametros['ADDRESS1'] = 'KR 7B BIS No. 132-11';
}
$parametros['PHONE'] = $_REQUEST['telefono1'];
$parametros['EMAIL_ADDR'] = $_REQUEST['email'];
$parametros['BUSINESS_UNIT'] = 'UBSF0';

$xml = "	<m:messageRequest xmlns:m=\"http://xmlns.oracle.com/Enterprise/Tools/schemas/UBI_CREA_ORDENPAG_REQ_MSG.VERSION_1\">
		<UBI_ESTADO>I</UBI_ESTADO>
		<UBI_OPERACION_ORD>" . $parametros['UBI_OPERACION_ORD'] . "</UBI_OPERACION_ORD>
		<NATIONAL_ID_TYPE>" . $parametros['NATIONAL_ID_TYPE'] . "</NATIONAL_ID_TYPE>
		<NATIONAL_ID>" . $parametros['NATIONAL_ID'] . "</NATIONAL_ID>
		<NATIONAL_ID_TYPE_OLD>" . $parametros['NATIONAL_ID_TYPE_OLD'] . "</NATIONAL_ID_TYPE_OLD>
		<NATIONAL_ID_OLD>" . $parametros['NATIONAL_ID_OLD'] . "</NATIONAL_ID_OLD>
		<FIRST_NAME>" . $parametros['FIRST_NAME'] . "</FIRST_NAME>
		<MIDDLE_NAME>" . $parametros['MIDDLE_NAME'] . "</MIDDLE_NAME>
		<LAST_NAME>" . $parametros['LAST_NAME'] . "</LAST_NAME>
		<SECOND_LAST_NAME>" . $parametros['SECOND_LAST_NAME'] . "</SECOND_LAST_NAME>
		<BIRTHDATE>" . cambiaf_a_people($parametros['BIRTHDATE']) . "</BIRTHDATE>
		<BIRTHCOUNTRY>" . $parametros['BIRTHCOUNTRY'] . "</BIRTHCOUNTRY>
		<BIRTHSTATE>" . $parametros['BIRTHSTATE'] . "</BIRTHSTATE>
		<BIRTHPLACE>" . $parametros['BIRTHPLACE'] . "</BIRTHPLACE>
		<SEX>" . $parametros['SEX'] . "</SEX>
		<MAR_STATUS>" . $parametros['MAR_STATUS'] . "</MAR_STATUS>
		<ADDRESS1>" . $parametros['ADDRESS1'] . "</ADDRESS1>
		<PHONE>" . $parametros['PHONE'] . "</PHONE>
		<EMAIL_ADDR>" . $parametros['EMAIL_ADDR'] . "</EMAIL_ADDR>
		<BUSINESS_UNIT>" . $parametros['BUSINESS_UNIT'] . "</BUSINESS_UNIT>
	</m:messageRequest>";
// Envio de parametros con arreglo
//$result = $client->call('PS_UBI_SALA_ORDPAG',array($parametros));
// Envio de parametros por xml

/**
 * Se comenta codigo de llamado al web service de people, debido a falta de información
 * relacionada con los eventos de datos de actualización
 */
//if ($servicioPS) {
//    $result = $client->call('UBI_CREA_ORDENPAG1_OPR_SRV', $xml);
//    sleep(3);
//
//} else {
//    $result['ERRNUM'] = 0;
//    $result['DESCRLONG'] = 'Sistema abajo por mantenimiento PS';
//    $result['documentoold'] = $parametros['NATIONAL_ID'];
//    $result['xml'] = $xml;
//}

$result['ERRNUM'] = 0;
$result['DESCRLONG'] = 'Sistema abajo por mantenimiento PS';
$result['documentoold'] = $parametros['NATIONAL_ID'];
$result['xml'] = $xml;
/*Fin del bloque comentado

/*
 * @modified David Perez <perezdavid@unbosque.edu.co>
 * @since  Enero 22, 2018
 * Se asigna como estado el numero 2 para llevar un control de los terceros no actualizados.
*/

//$query="INSERT INTO logtraceintegracionps (transaccionlogtraceintegracionps,enviologtraceintegracionps,respuestalogtraceintegracionps,documentologtraceintegracionps,estadoenvio) VALUES ('Actualizacion estudiante','".$xml."','id:".$result['ERRNUM']." descripcion: ".$result['DESCRLONG']."','".$_REQUEST['documentoold']."',".$envio.")";


$query = "INSERT INTO logtraceintegracionps (transaccionlogtraceintegracionps,enviologtraceintegracionps,respuestalogtraceintegracionps,documentologtraceintegracionps,estadoenvio) VALUES ('Actualizacion estudiante','" . $xml . "','id:" . $result['ERRNUM'] . " descripcion: " . $result['DESCRLONG'] . "','" . $_REQUEST['documentoold'] . "',2)";
mysql_query($query, $sala) or die("$query" . mysql_error()."LINEA :".__LINE__);
?>
