<?php

$hostname_sala = "172.16.7.109";
$database_sala = "sala";
$username_sala = "root";
$password_sala = "";
$sala = mysql_pconnect($hostname_sala, $username_sala, $password_sala) or trigger_error(mysql_error(), E_USER_ERROR);
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
$rfc = saprfc_open($login);

function cambiaf_a_sala($fecha) {
    ereg("([0-9]{2,4})([0-9]{1,2})([0-9]{1,2})", $fecha, $mifecha);
    $lafecha = $mifecha[1] . "-" . $mifecha[2] . "-" . $mifecha[3];
    return $lafecha;
}

/* * ***************************   VALIDACION DE CONEXION Y EXISTENCIA DE TABLA DE PAGOS EN SAP ************************* */

$rfcfunction = "ZFICA_SALA_CONSULT_PAGOS";
$resultstable = "ZTAB_PAGOS";

$rfchandle = saprfc_function_discover($rfc, $rfcfunction);

if (!$rfchandle) {
    echo "We have failed to discover the function" . saprfc_error($rfc);
    // exit(1);
}
// traigo la tabla interna de SAP
saprfc_table_init($rfchandle, $resultstable);
@$rfcresults = saprfc_call_and_receive($rfchandle);
$numrows = saprfc_table_rows($rfchandle, $resultstable);

for ($i = 1; $i <= $numrows; $i++) {
    $tabla[$i] = saprfc_table_read($rfchandle, $resultstable, $i);
}



if ($tabla <> "") {  // if 1
    foreach ($tabla as $valortabla => $totaltabla) { // foreach 1
        foreach ($totaltabla as $valor1tabla => $total1tabla) { // foreach 2
            if ($valor1tabla == "AUFNR") {

                $numeroordenpago = $total1tabla;

                // echo $orden,"<br>";
            }

            if ($valor1tabla == "FECHA") {

                $fechapagosapordenpago = cambiaf_a_sala($total1tabla);

                // echo $fechapago,"<br>";
            }

            if ($valor1tabla == "CXCOB") {

                $documentocuentaxcobrarsap = $total1tabla;

                //echo $cuenta,"<br>";
            }

            if ($valor1tabla == "RCAJA") {

                $documentocuentacompensacionsap = $total1tabla;

                //echo $recibo,"<br>";
            }
        } // foreach 2
//print_r($tabla);
        ////////////////////////////// Reporta  los pagos a sala /////////////////////////////////////////////////////////////
        //$numeroordenpago = 1023775;

        $query_data = "SELECT * FROM ordenpago
     WHERE numeroordenpago = '$numeroordenpago'";
        //echo $query_data,"<br>";
        $data = mysql_query($query_data, $sala) or die(mysql_error());
        $row_data = mysql_fetch_assoc($data);
        $totalRows_data = mysql_num_rows($data);

        $digito = ereg_replace("^[0-9]{1,1}", "", $row_data['codigoestadoordenpago']);

        if ($row_data <> "") { //if 2
            $query_prematricula = "UPDATE prematricula p,ordenpago o
		set codigoestadoprematricula = 4" . $digito . "
		where o.idprematricula = '" . $row_data['idprematricula'] . "'
		and o.codigoestudiante = p.codigoestudiante
		and o.numeroordenpago = '$numeroordenpago'
		and o.codigoperiodo = p.codigoperiodo";
            $prematricula = mysql_db_query($database_sala, $query_prematricula) or die("$query_prematricula" . mysql_error());

            //echo $query_prematricula;

            $query_detalleprematricula = "UPDATE detalleprematricula
		set codigoestadodetalleprematricula = '30'
		where numeroordenpago = '$numeroordenpago'
		and codigoestadodetalleprematricula like '1%'";
            $detalleprematricula = mysql_db_query($database_sala, $query_detalleprematricula) or die("$query_detalleprematricula" . mysql_error());

            $query_conceptoorden = "select do.codigoconcepto
        from detalleordenpago do
        WHERE do.numeroordenpago = '$numeroordenpago'
        and do.codigoconcepto = '153'";
            $conceptoorden = mysql_db_query($database_sala, $query_conceptoorden) or die("$query_conceptoorden" . mysql_error());
            $totalRows_conceptoorden = mysql_num_rows($conceptoorden);
            $row_conceptoorden = mysql_fetch_array($conceptoorden);

            if ($row_conceptoorden <> "") { // if 2
                require_once('funcion_inscribir.php');
                hacerInscripcion_mysql($numeroordenpago);
                /*$query_inscripcion = "UPDATE ordenpago o,estudiante e,inscripcion i,estudiantecarrerainscripcion ec
           SET i.codigosituacioncarreraestudiante = '107',
		   e.codigosituacioncarreraestudiante = '107',
            e.codigoperiodo = o.codigoperiodo
           WHERE o.codigoestudiante = e.codigoestudiante
           AND e.idestudiantegeneral = i.idestudiantegeneral 
           AND e.codigocarrera = ec.codigocarrera
           AND i.idinscripcion = ec.idinscripcion
           AND o.numeroordenpago = '$numeroordenpago'";
                $inscripcion = mysql_db_query($database_sala, $query_inscripcion) or die("$query_inscripcion" . mysql_error());*/
            } // if 2

            $query_ordenpago = "UPDATE ordenpago
		set codigoestadoordenpago = 4" . $digito . ",
		documentocuentaxcobrarsap = '$documentocuentaxcobrarsap',
		documentocuentacompensacionsap = '$documentocuentacompensacionsap',
		fechapagosapordenpago = '$fechapagosapordenpago'
		where numeroordenpago = '$numeroordenpago'";
            // echo $query_ordenpago;
            $ordenpago = mysql_db_query($database_sala, $query_ordenpago) or die("$query_ordenpago" . mysql_error());

            /*             * ********************************************************** BORRA TABLA DE PAGOS ******************************************* */

            $function = "ZFICA_SALA_BORRA_PAGOS";
            $function2 = "ZFICA_SALA_BORRA_ASPIRANTE";
            $function3 = "ZFICA_SALA_BORRA_ESTUDIANTE";

            $respuesta = saprfc_function_discover($rfc, $function);
            $respuesta2 = saprfc_function_discover($rfc, $function2);
            $respuesta3 = saprfc_function_discover($rfc, $function3);

            if (!$respuesta OR !$respuesta2 OR !$respuesta3) {
                // We have failed to discover the function
                echo "We have failed to discover the function" . saprfc_error($rfc);
                exit(1);
            }

            // Verifica si esa orden tiene descuentos

            $query_detalleorden = "SELECT d.codigoconcepto,d.valorconcepto,o.codigoperiodo,o.codigoestudiante
		 FROM ordenpago o,detalleordenpago d
         WHERE o.numeroordenpago = '$numeroordenpago'
		 AND o.numeroordenpago = d.numeroordenpago
		 AND d.codigotipodetalleordenpago = 2";
            //echo $query_data,"<br>";
            $detalleorden = mysql_query($query_detalleorden, $sala) or die(mysql_error());


            while ($row_detalleorden = mysql_fetch_assoc($detalleorden)) {

                $query_consultadvd = "SELECT iddescuentovsdeuda
			FROM descuentovsdeuda
			WHERE codigoestudiante = '" . $row_detalleorden['codigoestudiante'] . "'
			and codigoestadodescuentovsdeuda = '01'
			and codigoperiodo = '" . $row_detalleorden['codigoperiodo'] . "'
			and codigoconcepto = '" . $row_detalleorden['codigoconcepto'] . "'
			and valordescuentovsdeuda = '" . $row_detalleorden['valorconcepto'] . "'";
                $consultadvd = mysql_db_query($database_sala, $query_consultadvd) or die("$query_consultadvd" . mysql_error());
                $totalRows_consultadvd = mysql_num_rows($consultadvd);
                $row_respuestadvd = mysql_fetch_array($consultadvd);

                if ($row_respuestadvd <> "") {
                    $base3 = "update descuentovsdeuda
				set  codigoestadodescuentovsdeuda = '03' 
				where iddescuentovsdeuda = '" . $row_respuestadvd['iddescuentovsdeuda'] . "'";
                    $sol3 = mysql_db_query($database_sala, $base3);
                    echo $base3;
                }
            }

            $query_operacion = "select documentocuentaxcobrarsap
        from ordenpago
        WHERE numeroordenpago = '$numeroordenpago'";
            $operacion = mysql_db_query($database_sala, $query_operacion) or die("$query_operacion" . mysql_error());
            $totalRows_operacion = mysql_num_rows($operacion);
            $row_operacion = mysql_fetch_array($operacion);

            if ($row_operacion['documentocuentaxcobrarsap'] <> "") {
                saprfc_import($respuesta, "AUFNR", $numeroordenpago);
                saprfc_import($respuesta2, "AUFNR", $numeroordenpago);
                saprfc_import($respuesta3, "AUFNR", $numeroordenpago);
            }

            $rfcresult = saprfc_call_and_receive($respuesta);
            $rfcresult = saprfc_call_and_receive($respuesta2);
            $rfcresult = saprfc_call_and_receive($respuesta3);

            $re = saprfc_export($respuesta, "OK_COD");

            // echo $re;
            /////////////////////  Si Existe plan de pagos  ////////////////////////////////////////////////////////////
            $query_plan = "SELECT * FROM ordenpagoplandepago
         WHERE numerorodencoutaplandepagosap = '$numeroordenpago'";
            //echo $query_data,"<br>";
            $plan = mysql_query($query_plan, $sala) or die(mysql_error());
            $row_plan = mysql_fetch_assoc($plan);
            $totalRows_plan = mysql_num_rows($plan);

            if ($row_plan <> "") { //if 2
                $numeroordenpago = $row_plan['numerorodenpagoplandepagosap'];
                $digito = ereg_replace("^[0-9]{1,1}", "", $row_data['codigoestadoordenpago']);
                //echo $query_prematricula;

                $query_detalleprematricula = "UPDATE detalleprematricula
		set codigoestadodetalleprematricula = '30'
		where numeroordenpago = '$numeroordenpago'
		and codigoestadodetalleprematricula like '1%'";
                $detalleprematricula = mysql_db_query($database_sala, $query_detalleprematricula) or die("$query_detalleprematricula" . mysql_error());

                $query_conceptoorden = "select do.codigoconcepto
        from detalleordenpago do
        WHERE do.numeroordenpago = '$numeroordenpago'
        and do.codigoconcepto = '153'";
                $conceptoorden = mysql_db_query($database_sala, $query_conceptoorden) or die("$query_conceptoorden" . mysql_error());
                $totalRows_conceptoorden = mysql_num_rows($conceptoorden);
                $row_conceptoorden = mysql_fetch_array($conceptoorden);

                if ($row_conceptoorden <> "") { // if 2
                    require_once('funcion_inscribir.php');
                    hacerInscripcion_mysql($numeroordenpago);
                    /*$query_inscripcion = "UPDATE ordenpago o,estudiante e,inscripcion i,estudiantecarrerainscripcion ec
           SET i.codigosituacioncarreraestudiante = '107',
		   e.codigosituacioncarreraestudiante = '107',
            e.codigoperiodo = o.codigoperiodo
           WHERE o.codigoestudiante = e.codigoestudiante
           AND e.idestudiantegeneral = i.idestudiantegeneral 
           AND e.codigocarrera = ec.codigocarrera
           AND i.idinscripcion = ec.idinscripcion
           AND o.numeroordenpago = '$numeroordenpago'";
                    $inscripcion = mysql_db_query($database_sala, $query_inscripcion) or die("$query_inscripcion" . mysql_error());*/
                } // if 2

                $query_ordenpago = "UPDATE ordenpago
		set codigoestadoordenpago = 4" . $digito . ",
		documentocuentaxcobrarsap = '$documentocuentaxcobrarsap',
		documentocuentacompensacionsap = '$documentocuentacompensacionsap',
		fechapagosapordenpago = '$fechapagosapordenpago'
		where numeroordenpago = '$numeroordenpago'";
                // echo $query_ordenpago;
                $ordenpago = mysql_db_query($database_sala, $query_ordenpago) or die("$query_ordenpago" . mysql_error());

                /*                 * ********************************************************** BORRA TABLA DE PAGOS ******************************************* */

                $function = "ZFICA_SALA_BORRA_PAGOS";
                $function2 = "ZFICA_SALA_BORRA_ASPIRANTE";
                $function3 = "ZFICA_SALA_BORRA_ESTUDIANTE";

                $respuesta = saprfc_function_discover($rfc, $function);
                $respuesta2 = saprfc_function_discover($rfc, $function2);
                $respuesta3 = saprfc_function_discover($rfc, $function3);

                if (!$respuesta OR !$respuesta2 OR !$respuesta3) {
                    // We have failed to discover the function
                    echo "We have failed to discover the function" . saprfc_error($rfc);
                    //exit(1);
                }

                // Verifica si esa orden tiene descuentos

                $query_detalleorden = "SELECT d.codigoconcepto,d.valorconcepto,o.codigoperiodo,o.codigoestudiante
		 FROM ordenpago o,detalleordenpago d
         WHERE o.numeroordenpago = '$numeroordenpago'
		 AND o.numeroordenpago = d.numeroordenpago
		 AND d.codigotipodetalleordenpago = 2";
                //echo $query_data,"<br>";
                $detalleorden = mysql_query($query_detalleorden, $sala) or die(mysql_error());


                while ($row_detalleorden = mysql_fetch_assoc($detalleorden)) {
                    $query_consultadvd = "SELECT iddescuentovsdeuda
			FROM descuentovsdeuda
			WHERE codigoestudiante = '" . $row_detalleorden['codigoestudiante'] . "'
			and codigoestadodescuentovsdeuda = '01'
			and codigoperiodo = '" . $row_detalleorden['codigoperiodo'] . "'
			and codigoconcepto = '" . $row_detalleorden['codigoconcepto'] . "'
			and valordescuentovsdeuda = '" . $row_detalleorden['valorconcepto'] . "'";
                    $consultadvd = mysql_db_query($database_sala, $query_consultadvd) or die("$query_consultadvd" . mysql_error());
                    $totalRows_consultadvd = mysql_num_rows($consultadvd);
                    $row_respuestadvd = mysql_fetch_array($consultadvd);

                    if ($row_respuestadvd <> "") {
                        $base3 = "update descuentovsdeuda
				set  codigoestadodescuentovsdeuda = '03' 
				where iddescuentovsdeuda = '" . $row_respuestadvd['iddescuentovsdeuda'] . "'";
                        $sol3 = mysql_db_query($database_sala, $base3);
                    }
                }

                $query_operacion = "select documentocuentaxcobrarsap
        from ordenpago
        WHERE numeroordenpago = '$numeroordenpago'";
                $operacion = mysql_db_query($database_sala, $query_operacion) or die("$query_operacion" . mysql_error());
                $totalRows_operacion = mysql_num_rows($operacion);
                $row_operacion = mysql_fetch_array($operacion);

                if ($row_operacion['documentocuentaxcobrarsap'] <> "") {
                    saprfc_import($respuesta, "AUFNR", $numeroordenpago);
                    saprfc_import($respuesta2, "AUFNR", $numeroordenpago);
                    saprfc_import($respuesta3, "AUFNR", $numeroordenpago);
                }

                $rfcresult = saprfc_call_and_receive($respuesta);
                $rfcresult = saprfc_call_and_receive($respuesta2);
                $rfcresult = saprfc_call_and_receive($respuesta3);

                $re = saprfc_export($respuesta, "OK_COD");
                //echo $re;
            }

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        } // foreach 1
    }
} // if 1  
/* saprfc_function_free($function);
  saprfc_function_free($function2);
  saprfc_function_free($function3);
  saprfc_function_free($$rfcfunction); */
saprfc_close($rfc);
?>

