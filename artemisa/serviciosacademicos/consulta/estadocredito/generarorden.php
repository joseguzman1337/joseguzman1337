<?php
require_once('../../Connections/sala2.php');
mysql_select_db($database_sala, $sala);
$ruta = "../../funciones/";
require('../../funciones/ordenpago/claseordenpago.php');

require_once(realpath(dirname(__FILE__) . "/../../../sala/includes/adaptador.php"));

Factory::validateSession($variables);

$pos = strpos($Configuration->getEntorno(), "local");
if ($Configuration->getEntorno() == "local" ||
    $Configuration->getEntorno() == "Preproduccion" ||
    $Configuration->getEntorno() == "pruebas" || $pos !== false) {
    require_once(PATH_ROOT . '/kint/Kint.class.php');
    $_SESSION['path_live'] = PATH_ROOT . "/serviciosacademicos/";
}

$hoy = date('Y-m-d');
if (isset($_GET['fecha']) && !empty($_GET['fecha'])) {
    $fecha = $_GET['fecha'];
}
if (isset($_GET['inicial']) && !empty($_GET['inicial'])) {
    $inicial = $_GET['inicial'];
}
if (isset($_GET['ordenpago']) && !empty($_GET['ordenpago'])) {
    $numeroordenpago = $_GET['ordenpago'];
}
if (isset($_SESSION['arreglos'])) {
    $array = $_SESSION['arreglos'];

    if (!isset($array[0]) || !is_array($array[0])) {
        $resultstmp = $array;
        unset($array);
        $array[0] = $resultstmp;
    }
}

$codigoestudiante = $_SESSION['codigo'];

if (!empty($numeroordenpago)) {
    $query = "SELECT codigoestudiante, codigoperiodo FROM ordenpago "
        . " WHERE numeroordenpago = " . $db->qstr($numeroordenpago);
    $datos = $db->Execute($query);
    $d = $datos->FetchRow();
    if (!empty($d) && !empty($d['codigoestudiante'])) {
        $codigoestudianteBasico = $d['codigoestudiante'];
        $codigoperiodoBasico = $d['codigoperiodo'];
    }
}
if (empty($codigoestudiante)) {
    $codigoestudiante = $codigoestudianteBasico;
}

$fechalimite = $fecha;

if ($fecha < $hoy) {

    $fechalimite = $hoy;
    $timestamp = strtotime($fecha);
    $undias = ($timestamp + (60 * 60 * 24 * 1));
    $fechapago = date('Y-m-d', $undias);
}
$arr = array();

for ($i = 0; $i < count($array); $i++) {
    $array[$i]['ITEM_AMT'];
    $itemconcepto = $array[$i]['ITEM_TYPE'];
    $billingdate = $array[$i]['BILLING_DT'];

    if ($fecha == $array[$i]['DUE_DT']) {

        $valorconcepto[] = $array[$i]['ITEM_AMT'] - $array[$i]['APPLIED_AMT'];
        $valorconceptos = $array[$i]['ITEM_AMT'] - $array[$i]['APPLIED_AMT'];

        $itemnbrps[] = $array[$i]['ITEM_NBR'];

        $numerodocumentoplandepagosap[] = $array[$i]['ITEM_NBR'];
        $numeroorden = $array[$i]['INVOICE_ID'];

        $query_concepto = "SELECT * FROM carreraconceptopeople ccp, concepto c "
            . " WHERE c.codigoconcepto=ccp.codigoconcepto and itemcarreraconceptopeople='$itemconcepto'";
        $concepto = mysql_query($query_concepto, $sala) or die("$query_concepto" . mysql_error());
        $row_concepto = mysql_fetch_assoc($concepto);
        $totalRows_concepto = mysql_num_rows($concepto);

        $conceptocuota[] = $row_concepto['codigoconcepto'];

        $arr[$array[$i]['DUE_DT']]['ITEM_AMT'] =
            $arr[$array[$i]['DUE_DT']]['ITEM_AMT'] -
            $arr[$array[$i]['DUE_DT']]['APPLIED_AMT'] +
            $array[$i]['ITEM_AMT'] -
            $array[$i]['APPLIED_AMT'];

        $arr[$array[$i]['DUE_DT']]['INVOICE_ID'] = $array[$i]['INVOICE_ID'];

        foreach ($arr as $clave => $valor) {
            $valortotalcuota = $valor['ITEM_AMT'];
        }
    }

}

for ($i = 0; $i < count($conceptocuota); $i++) {
    //consulta si existe una cuota igual para el estudiante
    $query_ordenplan = "SELECT o.numeroordenpago FROM ordenpago o " .
        " inner join detalleordenpago d on o.numeroordenpago = d.numeroordenpago " .
        " inner join fechaordenpago f on o.numeroordenpago = f.numeroordenpago " .
        " inner join ordenpagoplandepago op on o.numeroordenpago = op.numerorodencoutaplandepagosap " .
        " WHERE d.codigoconcepto = '" . $conceptocuota[$i] . "' AND d.valorconcepto = '" . $valorconcepto[$i] . "' " .
        " AND o.codigoestudiante = '" . $codigoestudiante . "' AND o.codigoestadoordenpago LIKE '1%' " .
        " AND op.numerodocumentoplandepagosap = '$numerodocumentoplandepagosap[$i]'";
    $ordenplan = mysql_query($query_ordenplan, $sala) or die("$query_ordenplan<br>" . mysql_error());
    $totalRows_ordenplan = mysql_num_rows($ordenplan);
    $row_ordenplan = mysql_fetch_array($ordenplan);
}

if ($totalRows_ordenplan <> 0) {
    echo '<script language="JavaScript">alert("Ya Presenta Orden de Pago para esta Cuota")</script>';
    echo '<script language="JavaScript">history.go(-1)</script>';
    exit();
}

$query_selprematricula = "SELECT idprematricula, codigoestudiante, codigoperiodo " .
    " FROM ordenpago where numeroordenpago = '$numeroordenpago'";
$selprematricula = mysql_query($query_selprematricula, $sala) or die("$query_selprematricula<br>" . mysql_error());
$row_selprematricula = mysql_fetch_array($selprematricula);

$idprematricula = $row_selprematricula['idprematricula'];

$query_selsubperiodo = "SELECT s.idsubperiodo,e.codigocarrera,p.codigoperiodo,
          fechainiciofinancierosubperiodo,fechafinalfinancierosubperiodo
	 FROM periodo p, carreraperiodo cp, subperiodo s,estudiante e
	 WHERE p.codigoperiodo  = cp.codigoperiodo
	 AND s.idcarreraperiodo = cp.idcarreraperiodo
	 AND cp.codigocarrera = e.codigocarrera
	 AND e.codigoestudiante = '$codigoestudiante'	
	 AND fechafinalfinancierosubperiodo >= '" . date("Y-m-d") . "'
	 AND p.codigoperiodo = '" . $row_selprematricula['codigoperiodo'] . "'";
$selsubperiodo = mysql_query($query_selsubperiodo, $sala) or die("$query_selsubperiodo<br>" . mysql_error());
$row_selsubperiodo = mysql_fetch_array($selsubperiodo);

if (!isset($row_selsubperiodo) || empty($row_selsubperiodo)) {
    $query_selsubperiodo = "SELECT s.idsubperiodo,e.codigocarrera,p.codigoperiodo,
             fechainiciofinancierosubperiodo,fechafinalfinancierosubperiodo
    	 FROM periodo p, carreraperiodo cp, subperiodo s,estudiante e
    	 WHERE p.codigoperiodo  = cp.codigoperiodo
    	 AND s.idcarreraperiodo = cp.idcarreraperiodo
    	 AND cp.codigocarrera = e.codigocarrera
    	 AND e.codigoestudiante = '$codigoestudiante'
    	 AND fechainiciofinancierosubperiodo <= '" . date("Y-m-d") . "'
    	 AND fechafinalfinancierosubperiodo >= '" . date("Y-m-d") . "'";
    $selsubperiodo = mysql_query($query_selsubperiodo, $sala) or die("$query_selsubperiodo<br>" . mysql_error());
    $row_selsubperiodo = mysql_fetch_array($selsubperiodo);
}

$row_selprematricula['codigoperiodo'] = $row_selsubperiodo['codigoperiodo'];
$codigoperiodo = $row_selprematricula['codigoperiodo'];

if (empty($codigoperiodo)) {
    $codigoperiodo = $codigoperiodoBasico;
}

$orden = new Ordenpago($sala, $codigoestudiante, $codigoperiodo, $numeroordenpago = 0, $idprematricula);

$numeroordenpago = $_GET['ordenpago'];
$inicial = 0;
if ($_GET['inicial'] == 1) {
    $orden->crear_ordenpago_estadodecuenta_aporte($conceptocuota, $valorconcepto, $valortotalcuota, $fechalimite,
        $itemnbrps, $numeroordenpago, $porcentajedetallefechafinanciera = 0, $totalconrecargo = 0);
} else {
    $orden->crear_ordenpago_estadodecuenta($conceptocuota, $valorconcepto, $valortotalcuota, $fechalimite,
        $itemnbrps, $numeroordenpago, $porcentajedetallefechafinanciera = 0, $totalconrecargo = 0);
}
?>
<?php

echo '<script language="JavaScript">alert("Se ha generado una orden de pago con éxito")</script>';
echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=cambiocodigosesion.php?codigoestudiante=" . $row_selprematricula['codigoestudiante'] . "'>";
?>   
