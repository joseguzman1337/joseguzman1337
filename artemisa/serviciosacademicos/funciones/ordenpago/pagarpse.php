<?php
require_once('../../Connections/sala2.php');
mysql_select_db($database_sala, $sala);
$link = $sala;
$result['Reference1'] = $_GET['numeroordenpago'];

$numeroordenpago = $result['Reference1'];
$query_sellog = "select max(l.TicketId) as TicketId
from LogPagos l";
$sellog = mysql_query($query_sellog, $link) or die("$query_sellog" . mysql_error());
$totalRows_sellog = mysql_num_rows($sellog);
$row_sellog = mysql_fetch_array($sellog);
$cuentalog = $row_sellog['TicketId'] + 1;
// El informe del pago se hace con la orden que se paga, si tiene plan de pago la papa no se informa a sap
$ruta = "../../";
require("../../interfacessap/informa_pago_internet.php");
saprfc_close($rfc);

//exit();
$query_selestadoorden = "INSERT INTO LogPagos(TicketId, SrvCode, Reference1, Reference2, Reference3, PaymentDesc, TransValue, TransVatValue, SoliciteDate, BankProcessDate, FIName, StaCode, TrazabilityCode, FlagButton, RefAdc1, RefAdc2, RefAdc3, RefAdc4) 
VALUES('$cuentalog', ' ', '" . $_GET['numeroordenpago'] . "', ' ', ' ', ' ', ' ', ' ', '2006-4-7 5:36:10.0', '2006-4-7 5:36:10.0', '', 'OK', '', '', '', '', '', '')";
$selestadoorden = mysql_query($query_selestadoorden, $link) or die("$query_selestadoorden" . mysql_error());
//print_r($result);
// Primero miro cual es el estado actual de la orden y la prematricula
$query_selestadoorden = "select o.codigoestadoordenpago
from ordenpago o
where o.numeroordenpago = '" . $result['Reference1'] . "'";
$selestadoorden = mysql_query($query_selestadoorden, $link) or die("$query_selestadoorden" . mysql_error());
$totalRows_selestadoorden = mysql_num_rows($selestadoorden);
$row_selestadoorden = mysql_fetch_array($selestadoorden);
$digitoorden = ereg_replace("^[0-9]{1,1}", "", $row_selestadoorden['codigoestadoordenpago']);

$query_selestadoprematricula = "select p.codigoestadoprematricula 
from prematricula p, ordenpago o
WHERE o.numeroordenpago = '" . $result['Reference1'] . "'
and o.idprematricula = p.idprematricula";
$selestadoprematricula = mysql_query($query_selestadoprematricula, $link) or die("$query_selestadoprematricula" . mysql_error());
$totalRows_selestadoprematricula = mysql_num_rows($selestadoprematricula);
$row_selestadoprematricula = mysql_fetch_array($selestadoprematricula);
$digitoprematricula = ereg_replace("^[0-9]{1,1}", "", $row_selestadoprematricula['codigoestadoprematricula']);

// Actualizamos las tablas
/* // 1. Actualización de la tabla LogPagos
  $strQuery = "UPDATE LogPagos SET StaCode = 'OK', TrazabilityCode = '" . $result['TrazabilityCode'] . "',  BankProcessDate = '" . $result['BankProcessDate'] . "', FIName = '" . $result['BankName'] . "'  WHERE TicketId = '" . $row['TicketId'] . "';";
  $query = mysql_query($strQuery,$link);
 */
// 3. Actualización de la tabla prematricula
$strPrematricula = "UPDATE prematricula p, ordenpago o
SET p.codigoestadoprematricula = 4" . $digitoprematricula . "
WHERE o.numeroordenpago = '" . $result['Reference1'] . "'
and o.idprematricula = p.idprematricula
and o.codigoperiodo = p.codigoperiodo;";
$Prematricula = mysql_query($strPrematricula, $link);

// 3. Actualización de la tabla detalleprematricula
$strDetallePrematricula = "UPDATE detalleprematricula SET codigoestadodetalleprematricula = 30 
WHERE numeroordenpago = '" . $result['Reference1'] . "'
and codigoestadodetalleprematricula like '1%';";
$DetallePrematricula = mysql_query($strDetallePrematricula, $link);

// 4. Actualización del estado del estudiante a inscrito en caso de pagar el formulario de inscripción
$query_conceptoorden = "select do.codigoconcepto
from detalleordenpago do
WHERE do.numeroordenpago = '" . $result['Reference1'] . "'
and do.codigoconcepto = '153'";
$conceptoorden = mysql_query($query_conceptoorden, $link) or die("$query_conceptoorden" . mysql_error());
$totalRows_conceptoorden = mysql_num_rows($conceptoorden);
$row_conceptoorden = mysql_fetch_array($conceptoorden);
if ($row_conceptoorden <> "") {
    require_once('../funcion_inscribir.php');
    hacerInscripcion_mysql($result['Reference1']);
    /*$query_inscripcion = "UPDATE ordenpago o,estudiante e,inscripcion i,estudiantecarrerainscripcion ec
	SET i.codigosituacioncarreraestudiante = '107', e.codigosituacioncarreraestudiante = '107', e.codigoperiodo = o.codigoperiodo
	WHERE o.codigoestudiante = e.codigoestudiante
	AND e.idestudiantegeneral = i.idestudiantegeneral 
	AND e.codigocarrera = ec.codigocarrera
	AND i.idinscripcion = ec.idinscripcion
	AND o.numeroordenpago = '" . $result['Reference1'] . "'";
    $inscripcion = mysql_query($query_inscripcion, $link) or die("$query_inscripcion" . mysql_error());*/
}

// 2. Actualización de la tabla ordenpago
$strOrdenpago = "UPDATE ordenpago SET codigoestadoordenpago = 4" . $digitoorden . "
WHERE numeroordenpago = '" . $result['Reference1'] . "';";
$Ordenpago = mysql_query($strOrdenpago, $link);

// Si la orden pertenece a un plan de pagos
$query_plan = "SELECT * FROM ordenpagoplandepago
WHERE numerorodencoutaplandepagosap = '$numeroordenpago'";
//echo $query_data,"<br>";
$plan = mysql_query($query_plan, $link) or die(mysql_error());
$row_plan = mysql_fetch_assoc($plan);
$totalRows_plan = mysql_num_rows($plan);

if ($row_plan <> "") { //if 2
    $numeroordenpago = $row_plan['numerorodenpagoplandepagosap'];
    $query_selestadoorden = "select o.codigoestadoordenpago
	from ordenpago o
	where o.numeroordenpago = '$numeroordenpago'";
    $selestadoorden = mysql_query($query_selestadoorden, $link) or die("$query_selestadoorden" . mysql_error());
    $totalRows_selestadoorden = mysql_num_rows($selestadoorden);
    $row_selestadoorden = mysql_fetch_array($selestadoorden);
    $digitoorden = ereg_replace("^[0-9]{1,1}", "", $row_selestadoorden['codigoestadoordenpago']);

    $query_selestadoprematricula = "select p.codigoestadoprematricula
	from prematricula p, ordenpago o
	WHERE o.numeroordenpago = '$numeroordenpago'
	and o.idprematricula = p.idprematricula";
    $selestadoprematricula = mysql_query($query_selestadoprematricula, $link) or die("$query_selestadoprematricula" . mysql_error());
    $totalRows_selestadoprematricula = mysql_num_rows($selestadoprematricula);
    $row_selestadoprematricula = mysql_fetch_array($selestadoprematricula);
    $digitoprematricula = ereg_replace("^[0-9]{1,1}", "", $row_selestadoprematricula['codigoestadoprematricula']);

    // 3. Actualización de la tabla prematricula
    $strPrematricula = "UPDATE prematricula p, ordenpago o
	SET p.codigoestadoprematricula = 4" . $digitoprematricula . "
	WHERE o.numeroordenpago = '$numeroordenpago'
	and o.idprematricula = p.idprematricula
	and o.codigoperiodo = p.codigoperiodo;";
    $Prematricula = mysql_query($strPrematricula, $link);

    // 3. Actualización de la tabla detalleprematricula
    $strDetallePrematricula = "UPDATE detalleprematricula SET codigoestadodetalleprematricula = 30
	WHERE numeroordenpago = '$numeroordenpago'
	and codigoestadodetalleprematricula like '1%';";
    $DetallePrematricula = mysql_query($strDetallePrematricula, $link);

    // 4. Actualización del estado del estudiante a inscrito en caso de pagar el formulario de inscripción
    $query_conceptoorden = "select do.codigoconcepto
	from detalleordenpago do
	WHERE do.numeroordenpago = '$numeroordenpago'
	and do.codigoconcepto = '153'";
    $conceptoorden = mysql_query($query_conceptoorden, $link) or die("$query_conceptoorden" . mysql_error());
    $totalRows_conceptoorden = mysql_num_rows($conceptoorden);
    $row_conceptoorden = mysql_fetch_array($conceptoorden);
    if ($row_conceptoorden <> "") {
        require_once('../funcion_inscribir.php');
        hacerInscripcion_mysql($numeroordenpago);
        /*$query_inscripcion = "UPDATE ordenpago o,estudiante e,inscripcion i,estudiantecarrerainscripcion ec
		SET i.codigosituacioncarreraestudiante = '107', e.codigosituacioncarreraestudiante = '107', e.codigoperiodo = o.codigoperiodo
		WHERE o.codigoestudiante = e.codigoestudiante
		AND e.idestudiantegeneral = i.idestudiantegeneral 
		AND e.codigocarrera = ec.codigocarrera
		AND i.idinscripcion = ec.idinscripcion
		AND o.numeroordenpago = '$numeroordenpago'";
        $inscripcion = mysql_query($query_inscripcion, $link) or die("$query_inscripcion" . mysql_error());*/
    }
    // 2. Actualización de la tabla ordenpago
    $strOrdenpago = "UPDATE ordenpago SET codigoestadoordenpago = 4" . $digitoorden . "
	WHERE numeroordenpago = '$numeroordenpago';";
    $Ordenpago = mysql_query($strOrdenpago, $link);
    // if 2
}
?>
<script language="javascript">
    history.go(-4);
</script>