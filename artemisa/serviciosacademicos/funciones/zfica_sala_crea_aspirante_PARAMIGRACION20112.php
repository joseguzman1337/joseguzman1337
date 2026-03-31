<?php

function genera_prodiverso_PARAMIGRACION20112($sala, $numeroordenpago) { // funcion
    $query_data="SELECT DISTINCT
			eg.idestudiantegeneral
			,numerodocumento
			,case when locate(' ',trim(apellidosestudiantegeneral))=0
				then trim(apellidosestudiantegeneral)
				else substring(trim(apellidosestudiantegeneral),1,locate(' ',trim(apellidosestudiantegeneral)))
			 end as primerapellido
			,case when locate(' ',trim(apellidosestudiantegeneral))=0
				then ''
				else substring(trim(apellidosestudiantegeneral) from locate(' ',trim(apellidosestudiantegeneral)))
			 end as segundoapellido
			,case when locate(' ',trim(nombresestudiantegeneral))=0
				then trim(nombresestudiantegeneral)
				else substring(trim(nombresestudiantegeneral),1,locate(' ',trim(nombresestudiantegeneral)))
			 end as primernombre
			,case when locate(' ',trim(nombresestudiantegeneral))=0
				then ''
				else substring(trim(nombresestudiantegeneral) from locate(' ',trim(nombresestudiantegeneral)))
			 end as segundonombre
			,direccionresidenciaestudiantegeneral
			,e.codigocarrera
			,doc.codigodocumentopeople
			,sp.codigopeoplesexo
			,eg.celularestudiantegeneral
			,ciu.nombreciudad
			,pai.codigosappais
			,dep.codigosapdepartamento
			,ciu.codigosapciudad
			,prema.semestreprematricula
			,telefonoresidenciaestudiantegeneral
			,emailestudiantegeneral
			,c.codigoconcepto
			,do.valorconcepto
			,s.fechainiciofinancierosubperiodo
			,s.fechafinalfinancierosubperiodo
			,cuentaoperacionprincipal
			,cuentaoperacionparcial
			,fechanacimientoestudiantegeneral
			,valorfechaordenpago
			,o.codigoperiodo
			,e.codigoestudiante
			,ecp.codigoestadocivilpeople
			,o.fechaordenpago as fechacreacion
			,f.fechaordenpago as fechavencimiento
			,f.valorfechaordenpago as totalordenpago
			,do.codigotipodetalleordenpago
		FROM estudiantegeneral eg
		,ordenpago o
		,detalleordenpago do
		,estudiante e
		,fechaordenpago f
		,concepto c
		,subperiodo s
		,documentopeople doc
		,pais pai
		,departamento dep
		,ciudad ciu
		,prematricula prema
		,estadocivilpeople ecp
		,sexopeople sp
		WHERE o.numeroordenpago = do.numeroordenpago
			AND eg.idestudiantegeneral = e.idestudiantegeneral
			AND e.codigoestudiante = o.codigoestudiante
			AND prema.idprematricula = o.idprematricula
			AND ciu.idciudad = eg.ciudadresidenciaestudiantegeneral
			AND ciu.iddepartamento = dep.iddepartamento
			AND dep.idpais = pai.idpais
			AND o.idsubperiododestino = s.idsubperiodo
			AND f.numeroordenpago = do.numeroordenpago
			AND do.codigoconcepto = c.codigoconcepto
			AND doc.tipodocumentosala = eg.tipodocumento
			AND eg.idestadocivil = ecp.idestadocivil
			AND eg.codigogenero=sp.codigosexo
			AND o.numeroordenpago =  '$numeroordenpago'";

	$data = mysql_query($query_data, $sala) or die(mysql_error());
	$row_data = mysql_fetch_assoc($data);
	$tipodocumento = $row_data['codigodocumentopeople'];
	$documento = $row_data['numerodocumento'];
	$primernombre = $row_data['primernombre'];
	$periodo = $row_data['codigoperiodo'];
	$segundonombre = $row_data['segundonombre'];
	$primerapellido = $row_data['primerapellido'];
	$segundoapellido = $row_data['segundoapellido'];
	$fechanacimiento = $row_data['fechanacimientoestudiantegeneral'];
	$paisnacionalidad = $row_data['codigosappais'];
	$departamentonacionalidad = $row_data['codigosapdepartamento'];
	$ciudadnacionalidad = $row_data['codigosapciudad'];
	$genero = $row_data['codigopeoplesexo'];
	$estadocivil = $row_data ['codigoestadocivilpeople'];
	$direccion = $row_data['direccionresidenciaestudiantegeneral'];
	$telefono = $row_data['telefonoresidenciaestudiantegeneral'];
	$email =  $row_data['emailestudiantegeneral'];
	$fechacreacion = $row_data['fechacreacion'];
	$fechavencimiento = $row_data['fechavencimiento'];
    	$totalordenpago = $row_data['totalordenpago'];
	$codigocarrera = $row_data ['codigocarrera'];

	$vars = array (	 "tipodocumento"
			,"documento"
			,"primernombre"			
			,"segundonombre"			
			,"primerapellido"			
			,"segundoapellido"
			,"fechanacimiento"
			,"paisnacionalidad"
			,"departamentonacionalidad"
			,"ciudadnacionalidad"
			,"genero"
			,"estadocivil"
			,"direccion"
			,"telefono"
			,"email"
			,"numeroordenpago"
			,"fechacreacion" 
			,"fechavencimiento"
			,"totalordenpago"
			,"codigocarrera" 
			,"periodo" );
	
	//reportarOrdenesPagoSala(compact($vars));
	$datos=compact($vars);
	require_once($_SESSION['path_live'].'consulta/interfacespeople/ordenesdepago/reportarordenespagosala_PARAMIGRACION20112.php');
	return $result;
	

/*
    if (isset($_REQUEST['zidgrupo']))
        $idgrupo = $_REQUEST['zidgrupo'];
    $query_data = "SELECT eg.idestudiantegeneral ,numerodocumento,nombresestudiantegeneral, apellidosestudiantegeneral,
    direccioncortaresidenciaestudiantegeneral, e.codigocarrera, telefonoresidenciaestudiantegeneral,
    emailestudiantegeneral, f.fechaordenpago, c.codigoconcepto, do.valorconcepto, s.fechainiciofinancierosubperiodo,
    s.fechafinalfinancierosubperiodo, cuentaoperacionprincipal, cuentaoperacionparcial
	FROM estudiantegeneral eg,ordenpago o,detalleordenpago do,estudiante e,fechaordenpago f,concepto c,subperiodo s
	WHERE o.numeroordenpago = do.numeroordenpago
	AND eg.idestudiantegeneral = e.idestudiantegeneral
	AND e.codigoestudiante = o.codigoestudiante
	AND o.idsubperiododestino = s.idsubperiodo
	AND f.numeroordenpago = do.numeroordenpago
	AND do.codigoconcepto = c.codigoconcepto
	AND o.numeroordenpago = '$numeroordenpago'";
    //echo $query_data;
    $data = mysql_query($query_data, $sala) or die(mysql_error());
    $row_data = mysql_fetch_assoc($data);
    $totalRows_data = mysql_num_rows($data);

    $query_carrera = "SELECT c.codigomodalidadacademica,c.codigocentrobeneficio,c.nombrecarrera
    FROM carrera c
	WHERE c.codigocarrera = '" . $row_data['codigocarrera'] . "'
	AND codigotipocosto = '100'";
    // echo $query_carrera;
    $carrera = mysql_query($query_carrera, $sala) or die("$query_carrera" . mysql_error());
    $row_carrera = mysql_fetch_assoc($carrera);
    $totalRows_carrera = mysql_num_rows($carrera);
    $centrobeneficio = 0;
    $ordeninterna = false;
    if ($row_carrera <> "") {
        // Si la carrera es por centro de beneficio entra
        $centrobeneficio = $row_carrera['codigocentrobeneficio'];
        $nombrecarrera = $row_carrera['nombrecarrera'];
    } else if (!$row_carrera) {
        //echo "ROWEOW $fechainicio $fechafinal";
        // Validamos si la orden tiene un solo concepto y se trata de un concepto para centro de beneficio
        // Aca vamos a validar si el concepto que viene es para pasarse por centro de beneficio
        $query_concepto = "select distinct c.codigoindicadorcobroconcepto, do.codigoconcepto
        from ordenpago o, detalleordenpago do, fechaordenpago fo, concepto c
        where o.numeroordenpago = do.numeroordenpago
        and fo.numeroordenpago = o.numeroordenpago
        and o.numeroordenpago = '$numeroordenpago'
        and c.codigoconcepto = do.codigoconcepto";
        // echo $query_carrera;
        $concepto = mysql_query($query_concepto, $sala) or die("$query_concepto" . mysql_error());
        $row_concepto = mysql_fetch_assoc($concepto);
        $totalRows_concepto = mysql_num_rows($concepto);
        if ($totalRows_concepto == 1 && $row_concepto['codigoindicadorcobroconcepto'] == 200) {
            // Si entra aplica centro de beneficio
            $query_carrera = "SELECT c.codigomodalidadacademica,c.codigocentrobeneficio,c.nombrecarrera
            FROM carrera c
            WHERE c.codigocarrera = '" . $row_data['codigocarrera'] . "'";
            // echo $query_carrera;
            $carrera = mysql_query($query_carrera, $sala) or die("$query_carrera" . mysql_error());
            $row_carrera = mysql_fetch_assoc($carrera);
            $totalRows_carrera = mysql_num_rows($carrera);
            $centrobeneficio = $row_carrera['codigocentrobeneficio'];
            $nombrecarrera = $row_carrera['nombrecarrera'];
        } else {
            $query_carrera = "SELECT numeroordeninternasap,c.nombrecarrera,c.codigomodalidadacademica,DATE_FORMAT(CURDATE(),'%Y-%m-%d') AS hoy,fechainicionumeroordeninternasap AS inicio,fechavencimientonumeroordeninternasap AS final
            FROM carrera c,numeroordeninternasap n,grupo g,materia m
	        WHERE g.idgrupo = n.idgrupo
	        AND c.codigocarrera = '" . $row_data['codigocarrera'] . "'
	        AND m.codigocarrera = c.codigocarrera
	        AND g.codigomateria = m.codigomateria
            and g.idgrupo = '$idgrupo'
	        GROUP BY 1
	        HAVING (hoy <=  final)";
            // echo $query_carrera;
            $carrera = mysql_query($query_carrera, $sala) or die("$query_carrera" . mysql_error());
            $totalRows_carrera = mysql_num_rows($carrera);

            if ($totalRows_carrera == 0) {
                $query_carrera = "SELECT numeroordeninternasap,c.nombrecarrera,c.codigomodalidadacademica,DATE_FORMAT(CURDATE(),'%Y-%m-%d') AS hoy,fechainicionumeroordeninternasap AS inicio,fechavencimientonumeroordeninternasap AS final
                FROM carrera c,numeroordeninternasap n,grupo g,materia m
                WHERE g.idgrupo = n.idgrupo
                AND c.codigocarrera = '" . $row_data['codigocarrera'] . "'
                AND m.codigocarrera = c.codigocarrera
                AND g.codigomateria = m.codigomateria
                GROUP BY 1
                HAVING (hoy <=  final)";
                // echo $query_carrera;
                $carrera = mysql_query($query_carrera, $sala) or die("$query_carrera" . mysql_error());
                $totalRows_carrera = mysql_num_rows($carrera);
            }

            $row_carrera = mysql_fetch_assoc($carrera);

            $centrobeneficio = $row_carrera['numeroordeninternasap'];
            $nombrecarrera = $row_carrera['nombrecarrera'];
            $ordeninterna = true;
        }
    }

    $formulario = 0;
    $inscripcion = 0;

    $documento = $row_data['numerodocumento'];
    $nombre = $row_data['nombresestudiantegeneral'] . " " . $row_data['apellodosestudiantegeneral'];
    $id = $row_data['idestudiantegeneral'];
    $telefono = $row_data['telefonoresidenciaestudiantegeneral'];
    $direccion = $row_data['direccioncortaresidenciaestudiantegeneral'];
    $email = $row_data['emailestudiantegeneral'];
    $fechapago = cambiaf_a_sap($row_data['fechaordenpago']);

    if ($ordeninterna == false) {
        $fechainicio = cambiaf_a_sap($row_data['fechainiciofinancierosubperiodo']);
        $fechafinal = cambiaf_a_sap($row_data['fechafinalfinancierosubperiodo']);
    } else if ($ordeninterna == true) {
        $fechainicio = "";
        $fechafinal = "";
    }

    $codigomodalidadacademica = $row_carrera['codigomodalidadacademica'];

    if($codigomodalidadacademica == 700) {
        $codigomodalidadacademica = 400;
    }
    if ($totalRows_data > 1) {
        do {
            if ($row_data['codigoconcepto'] == 152) {
                $formulario = $row_data['valorconcepto'];
                $opprincipalformulario = $row_data['cuentaoperacionprincipal'];
                $opparcialformulario = $row_data['cuentaoperacionparcial'];
            } else
            if ($row_data['codigoconcepto'] == 153) {
                $inscripcion = $row_data['valorconcepto'];
                $opprincipalinscripcion = $row_data['cuentaoperacionprincipal'];
                $opparcialinscripcion = $row_data['cuentaoperacionparcial'];
            }
        } while ($row_data = mysql_fetch_assoc($data));
    } else
    if ($row_data['codigoconcepto'] == 152) {
        $formulario = $row_data['valorconcepto'];
        $opprincipalformulario = $row_data['cuentaoperacionprincipal'];
        $opparcialformulario = $row_data['cuentaoperacionparcial'];
    } else
    if ($row_data['cuentaoperacionprincipal'] == 153) {
        $inscripcion = $row_data['valorconcepto'];
        $opprincipalinscripcion = $row_data['cuentaoperacionprincipal'];
        $opparcialinscripcion = $row_data['cuentaoperacionparcial'];
    } elseif ($row_data['codigoconcepto'] == 'C9048') {
        $inscripcion = $row_data['valorconcepto'];
        $opprincipalinscripcion = $row_data['cuentaoperacionprincipal'];
        $opparcialinscripcion = $row_data['cuentaoperacionparcial'];
    }

    $opprincipalformulario = '152';
    $opparcialformulario = '0001';
    $opprincipalinscripcion = '153';
    $opparcialinscripcion = '0001';


    $rfcfunction = "ZFICA_SALA_CREA_ASPIRANTE";
    //$entrego = "ZTAB_ASPIRANTE";

    $rfchandle = saprfc_function_discover($rfc, $rfcfunction);

    if (!$rfchandle) {
        // We have failed to discover the function
        echo "We have failed to discover the function" . saprfc_error($rfc);
        exit(1);
    }

    saprfc_import($rfchandle, "STCD1", $documento);
    saprfc_import($rfchandle, "NAME1", $nombre);
    saprfc_import($rfchandle, "CODES", $id);
    saprfc_import($rfchandle, "STRAS", $direccion);
    saprfc_import($rfchandle, "TELF1", $telefono);
    saprfc_import($rfchandle, "INTAD", $email);
    saprfc_import($rfchandle, "AUFNR", $numeroordenpago);
    saprfc_import($rfchandle, "MODAC", $codigomodalidadacademica);
    saprfc_import($rfchandle, "PROAC", $centrobeneficio);
    saprfc_import($rfchandle, "NOPRO", $nombrecarrera);
    saprfc_import($rfchandle, "INIPE", $fechainicio);
    saprfc_import($rfchandle, "FINPE", $fechafinal);
    saprfc_import($rfchandle, "FEVAL", $fechapago);
    saprfc_import($rfchandle, "OPPAL_FR", $opprincipalformulario);
    saprfc_import($rfchandle, "OPPAR_FR", $opparcialformulario);
    saprfc_import($rfchandle, "OPPAL_IN", $opprincipalinscripcion);
    saprfc_import($rfchandle, "OPPAR_IN", $opparcialinscripcion);
    saprfc_import($rfchandle, "VFORM", $formulario);
    saprfc_import($rfchandle, "VINSC", $inscripcion);

    $rfcresults = saprfc_call_and_receive($rfchandle);

    $re = saprfc_export($rfchandle, "OK_COD");

    return $re;
*/
}

// fin funcion
?>
