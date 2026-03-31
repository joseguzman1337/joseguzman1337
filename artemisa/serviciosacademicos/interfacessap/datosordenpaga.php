<?php

$ruta = "../";
require('../Connections/sala2.php');

mysql_select_db($database_sala, $sala);


$query_estadoconexionexterna = "select e.codigoestadoconexionexterna, e.nombreestadoconexionexterna,hostestadoconexionexterna,numerosistemaestadoconexionexterna,
	mandanteestadoconexionexterna,usuarioestadoconexionexterna,passwordestadoconexionexterna
	from estadoconexionexterna e
	where e.codigoestado like '1%'";
$estadoconexionexterna = mysql_query($query_estadoconexionexterna, $sala) or die("$query_estadoconexionexterna<br>" . mysql_error());
$totalRows_estadoconexionexterna = mysql_num_rows($estadoconexionexterna);
$row_estadoconexionexterna = mysql_fetch_array($estadoconexionexterna);

$host = $row_estadoconexionexterna['hostestadoconexionexterna'];
$sistema = $row_estadoconexionexterna['numerosistemaestadoconexionexterna'];
$mandante = $row_estadoconexionexterna['mandanteestadoconexionexterna'];
$usuario = $row_estadoconexionexterna['usuarioestadoconexionexterna'];
$clave = $row_estadoconexionexterna['passwordestadoconexionexterna'];

$login = array(// Set login data to R/3
    "ASHOST" => "$host", // application server host name
    "SYSNR" => "$sistema", // system number
    "CLIENT" => "$mandante", // client
    "USER" => "$usuario", // user
    "PASSWD" => "$clave",
    "CODEPAGE" => "1100");              // codepage

function cambiaf_a_sala($fecha) {
    ereg("([0-9]{2,4})([0-9]{1,2})([0-9]{1,2})", $fecha, $mifecha);
    $lafecha = $mifecha[1] . "-" . $mifecha[2] . "-" . $mifecha[3];
    return $lafecha;
}

//echo $rfc;
//exit();
/* * ***************************   VALIDACION DE CONEXION Y EXISTENCIA DE TABLA DE PAGOS EN SAP ************************* */
$query_todas = "select o.*
from ordenpago o
where o.codigoestadoordenpago like '4%'
and o.fechapagosapordenpago = '0000-00-00'";
$query_todas = "select o.*
from ordenpago o
where o.codigoestadoordenpago like '4%'
and o.fechapagosapordenpago = '0000-00-00'";
/*$query_todas = "select o.*
from ordenpago o
where o.codigoestadoordenpago like '4%'
and o.fechapagosapordenpago < o.fechaordenpago";*/
//and numeroordenpago in(1028812, 1031496, 1032486)
// and numeroordenpago in(1028812, 1031496, 1032486)
//, 1031496, 1032486
$todas = mysql_db_query($database_sala, $query_todas) or die("$query_todas" . mysql_error());
$totalRows_todas = mysql_num_rows($todas);
while ($row_todas = mysql_fetch_array($todas)) {
    $orden = $row_todas['numeroordenpago'];

    /* Ordenes con fecha de pago en 0000-00-00 o  null */
    /* $query_ordenpago = "select numeroordenpago
from ordenpago
where codigoestadoordenpago like '4%'
and (fechapagosapordenpago = '0000-00-00' or fechapagosapordenpago is null)
and numeroordenpago = '$orden'";*/

    /* Ordenes con fecha de pago menor a la fecha de creacio */
    $query_ordenpago = "select *
    from ordenpago
    where codigoestadoordenpago like '4%'
    and fechapagosapordenpago = '0000-00-00'
    and numeroordenpago = '$orden'";
    
// echo $query_ordenpago;
    $ordenpago = mysql_db_query($database_sala, $query_ordenpago) or die("$query_ordenpago" . mysql_error());
    $totalRows_orden = mysql_num_rows($ordenpago);
//$row_ordenpago = mysql_fetch_array($ordenpago);

    if ($totalRows_orden != 0) {
        $row_ordenpago = mysql_fetch_array($ordenpago);
        $fechaordenpago = $row_ordenpago['fechaordenpago'];

        $rfc = saprfc_open($login);
        $entrego = "XBLNR";
        $rfcfunction = "ZFICA_SALA_CONSULT_ORDEN_PAGO";
        $resultstable = "ZTAB_ORDEN";

        $rfchandle = saprfc_function_discover($rfc, $rfcfunction);

        if (!$rfchandle) {
            echo "We have failed to discover the function" . saprfc_error($rfc);
// exit(1);
        }
// traigo la tabla interna de SAP
        saprfc_table_init($rfchandle, $resultstable);
        saprfc_import($rfchandle, $entrego, $orden);
        @$rfcresults = saprfc_call_and_receive($rfchandle);
        $numrows = saprfc_table_rows($rfchandle, $resultstable);

        for ($i = 1; $i <= $numrows; $i++) {
            $tabla[$i] = saprfc_table_read($rfchandle, $resultstable, $i);
        }

        if ($tabla <> "") { 
            echo "<pre>";
            //print_r($tabla);
            $opbel = $tabla[1]['OPBEL'];
            $budat = cambiaf_a_sala($tabla[1]['BUDAT']);
            $augbl = $tabla[1]['AUGBL'];
            //echo "$opbel - $budat - $augbl</pre>";
            $query_data = "update ordenpago
        set fechapagosapordenpago = '$budat', documentocuentaxcobrarsap = '$opbel', documentocuentacompensacionsap = '$augbl'
        WHERE numeroordenpago = '$orden'
        and codigoestadoordenpago like '4%'";
            echo "$fechaordenpago: ".$query_data, "<br><br>";
            $data = mysql_query($query_data, $sala) or die(mysql_error());
        }
        else {
            echo "Orden no encontrada en sap:   $orden<br>";
        }
        saprfc_close($rfc);
    }
}
?>