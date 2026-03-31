<?php

require_once(realpath(dirname(__FILE__) . "/../../sala/includes/adaptador.php"));
require('valorestadisticoestudiante.php');

function crea_estudiante($sala, $numeroordenpago, $idgrupo, $db= null, $modulo=null) { // func

    //uso de variable global db del componente de factory
    global $db;
    global $Configuration;
    if (isset($_REQUEST['zidgrupo']))
        $idgrupo = $_REQUEST['zidgrupo'];

    $query_data = "SELECT DISTINCT
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
			,prema.semestreprematricula
			,telefonoresidenciaestudiantegeneral
			,emailestudiantegeneral
			,c.codigoconcepto
			,dop.valorconcepto
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
			,dop.codigotipodetalleordenpago
		FROM ordenpago o
INNER JOIN estudiante e on  e.codigoestudiante = o.codigoestudiante
INNER JOIN estudiantegeneral eg on eg.idestudiantegeneral=e.idestudiantegeneral
LEFT JOIN detalleordenpago dop on o.numeroordenpago = dop.numeroordenpago
LEFT JOIN fechaordenpago f on f.numeroordenpago = dop.numeroordenpago
LEFT JOIN concepto c on dop.codigoconcepto = c.codigoconcepto
LEFT JOIN subperiodo s on o.idsubperiododestino = s.idsubperiodo
LEFT JOIN documentopeople doc on doc.tipodocumentosala = eg.tipodocumento
LEFT JOIN prematricula prema on prema.idprematricula = o.idprematricula
LEFT JOIN estadocivilpeople ecp on eg.idestadocivil = ecp.idestadocivil
LEFT JOIN sexopeople sp on eg.codigogenero=sp.codigosexo
LEFT JOIN ciudad ciu on ciu.idciudad = eg.ciudadresidenciaestudiantegeneral
LEFT JOIN departamento dep on  ciu.iddepartamento = dep.iddepartamento
LEFT JOIN pais pai on dep.idpais = pai.idpais
		WHERE o.numeroordenpago =  '$numeroordenpago'";
    if(isset($sala) && !empty($sala)) {
        $data = mysql_query($query_data, $sala) or die(mysql_error());
        $row_data = mysql_fetch_assoc($data);
    }else{
        $row_data = $db->GetRow($query_data);
    }

    $query_nacionalidad = "SELECT pai.codigosappais,dep.codigosapdepartamento,ciu.codigosapciudad ".
	" FROM estudiantegeneral eg,ciudad ciu,departamento dep,pais pai ".
	" WHERE eg.idciudadnacimiento = ciu.idciudad ".
	" AND ciu.iddepartamento = dep.iddepartamento ".
	" AND dep.idpais = pai.idpais ".
	" and eg.numerodocumento = '" . $row_data['numerodocumento'] . "'";
    if(isset($sala) && !empty($sala)) {
        $nacionalidad = mysql_query($query_nacionalidad, $sala) or die("$query_conceptos" . mysql_error());
        $row_nacionalidad = mysql_fetch_assoc($nacionalidad);
    }else{
        $row_nacionalidad = $db->GetRow($query_nacionalidad);
    }

    $paisnacionalidad = $row_nacionalidad ['codigosappais'];
    $departamentonacionalidad = $row_nacionalidad ['codigosapdepartamento'];
    $ciudadnacionalidad = $row_nacionalidad ['codigosapciudad'];
    $estadocivil = $row_data ['codigoestadocivilpeople'];
    $codigocarrera = $row_data ['codigocarrera'];
    $ordeninterna = false;

    $query_carrera = "SELECT c.codigomodalidadacademica,c.codigocentrobeneficio,c.nombrecarrera ".
    " FROM carrera c WHERE c.codigocarrera = '" . $row_data['codigocarrera'] . "' ".
	" AND codigotipocosto = '100'";
    if(isset($sala) && !empty($sala)) {
        $carrera = mysql_query($query_carrera, $sala) or die("$query_carrera" . mysql_error());
        $row_carrera = mysql_fetch_assoc($carrera);
    }else{
        $row_carrera = $db->GetRow($query_carrera);
    }
    $centrobeneficio = 0;
    if (isset($row_carrera['nombrecarrera']) && !empty($row_carrera['nombrecarrera'])) {
        $centrobeneficio = $row_carrera['codigocentrobeneficio'];
        $nombrecarrera = $row_carrera['nombrecarrera'];
    } else if (!$row_carrera) {
        // Validamos si la orden tiene un solo concepto y se trata de un concepto para centro de beneficio
        // Aca vamos a validar si el concepto que viene es para pasarse por centro de beneficio
        $query_concepto = "select distinct c.codigoindicadorcobroconcepto, do.codigoconcepto ".
        " from ordenpago o, detalleordenpago do, fechaordenpago fo, concepto c ".
        " where o.numeroordenpago = do.numeroordenpago ".
        " and fo.numeroordenpago = o.numeroordenpago and o.numeroordenpago = '$numeroordenpago' ".
        " and c.codigoconcepto = do.codigoconcepto";
        if(isset($sala) && !empty($sala)) {
            $concepto = mysql_query($query_concepto, $sala) or die("$query_concepto" . mysql_error());
            $row_concepto = mysql_fetch_assoc($concepto);
            $totalRows_concepto = mysql_num_rows($concepto);
        }else{
            $row_concepto = $db->GetRow($query_concepto);
        }
        if ($totalRows_concepto == 1 && $row_concepto['codigoindicadorcobroconcepto'] == 200) {
            // Si entra aplica centro de beneficio
            $query_carrera = "SELECT c.codigomodalidadacademica,c.codigocentrobeneficio,c.nombrecarrera ".
            " FROM carrera c WHERE c.codigocarrera = '" . $row_data['codigocarrera'] . "'";
            if(isset($sala) && !empty($sala)) {
                $carrera = mysql_query($query_carrera, $sala) or die("$query_carrera" . mysql_error());
                $row_carrera = mysql_fetch_assoc($carrera);
            }else{
                $row_carrera  = $db->GetRow($query_carrera);
            }
            $centrobeneficio = $row_carrera['codigocentrobeneficio'];
            $nombrecarrera = $row_carrera['nombrecarrera'];
        } else {
            if ($idgrupo == '') {
                $query_selgrupos = "select dp.idgrupo, dp.codigomateria ".
			    " from detalleprematricula dp, prematricula p ".
			    " where dp.idprematricula = p.idprematricula ".
			    " and p.codigoestudiante = '" . $row_data['codigoestudiante'] . "' ".
			    " and p.codigoperiodo = '" . $row_data['codigoperiodo'] . "' ".
			    " and (dp.codigoestadodetalleprematricula like '1%' or dp.codigoestadodetalleprematricula like '3%') ".
			    " and (p.codigoestadoprematricula like '1%' or p.codigoestadoprematricula like '4%')";
                if(isset($sala) && !empty($sala)) {
                    $selgrupos = mysql_query($query_selgrupos, $sala) or die("$query_selgrupos" . mysql_error());
                    $rows_selgrupos = mysql_fetch_array($selgrupos);
                }else{
                    $rows_selgrupos = $db->GetAll($selgrupos);
                }
                foreach ($rows_selgrupos as $row_selgrupos) {
                    $idgrupo = $row_selgrupos['idgrupo'];
                }
            }

            $query_carrera = "SELECT numeroordeninternasap, c.nombrecarrera, c.codigomodalidadacademica, ".
            " DATE_FORMAT(CURDATE(),'%Y-%m-%d') AS hoy, fechainicionumeroordeninternasap AS inicio, ".
            " fechavencimientonumeroordeninternasap AS final ".
            " FROM carrera c,numeroordeninternasap n,grupo g,materia m ".
	        " WHERE g.idgrupo = n.idgrupo ".
	        " AND n.idgrupo = '$idgrupo' AND m.codigocarrera = c.codigocarrera ".
	        " AND g.codigomateria = m.codigomateria GROUP BY 1  HAVING (hoy <=  final)";
            if(isset($sala) && !empty($sala)) {
                $carrera = mysql_query($query_carrera, $sala) or die("$query_carrera" . mysql_error());
                $row_carrera = mysql_fetch_assoc($carrera);
            }else{
                $row_carrera = $db->GetRow($query_carrera);
            }
            if ($row_carrera <> "") {
                $centrobeneficio = $row_carrera['numeroordeninternasap'];
                $nombrecarrera = $row_carrera['nombrecarrera'];
                $ordeninterna = true;
            } else {
                $centrobeneficio = existe_ordeninternaocentrobeneficio($row_data['codigoestudiante'], $row_data['codigocarrera'], $row_data['codigoperiodo'], $sala);
                $nombrecarrera = '';
                $ordeninterna = true;

                if (!$centrobeneficio) {
                    //////// Anulo Ordenes de pago //////////////////////

                    $query_ordenpago = "UPDATE ordenpago set codigoestadoordenpago = '20' ".
                    " where numeroordenpago = '$numeroordenpago'";
                    if(isset($sala) && !empty($sala)) {
                        $ordenpago = mysql_query($query_ordenpago, $sala) or die("$query_ordenpago" . mysql_error());
                    }else{
                        $ordenpago = $db->Execute($query_ordenpago);
                    }

                    $query_detalleprematricula = "UPDATE detalleprematricula set codigoestadodetalleprematricula = '20' ".
				    " where numeroordenpago = '$numeroordenpago'";
                    if(isset($sala) && !empty($sala)) {
                        $detalleprematricula = mysql_query($query_detalleprematricula, $sala)
                        or die("$query_detalleprematricula" . mysql_error());
                    }else{
                        $detalleprematricula = $db->Execute($query_detalleprematricula);
                    }
                    ////// Fin Anulo Ordenes Pago ////////////////////
                }
            }
        }
    }

    if ($ordeninterna == false) {
        $fechainicio = $row_data['fechainiciofinancierosubperiodo'];
        $fechafinal = $row_data['fechafinalfinancierosubperiodo'];
    } elseif ($ordeninterna == true) {
        $fechainicio = "";
        $fechafinal = "";
    }
    $documento = $row_data['numerodocumento'];
    $tipodocumento = $row_data['codigodocumentopeople'];
    $primernombre = $row_data['primernombre'];
    $segundonombre = $row_data['segundonombre'];
    $primerapellido = $row_data['primerapellido'];
    $segundoapellido = $row_data['segundoapellido'];

    $id = $row_data['idestudiantegeneral'];
    $idestudiantegeneral= $row_data['idestudiantegeneral'];

    if ($row_data['telefonoresidenciaestudiantegeneral'] <> "" and
        preg_match("/^[0-9]{1,15}$/", $row_data['telefonoresidenciaestudiantegeneral'])) {
        $telefono = $row_data['telefonoresidenciaestudiantegeneral'];
    } else {
        $telefono = "57 1 9999999";
    }

    if ($row_data['direccionresidenciaestudiantegeneral'] <> "") {
        $direccion = $row_data['direccionresidenciaestudiantegeneral'];
    } else {
        $direccion = "TV 9A BIS 132 55";
    }

    if ($row_data['celularestudiantegeneral'] <> "" and preg_match("/^[0-9]{1,15}$/", $row_data['celularestudiantegeneral'])) {
        $celular = $row_data['celularestudiantegeneral'];
    } else {
        $celular = "57 1 9999999";
    }
    $email = $row_data['emailestudiantegeneral'];
    $fechacreacion = $row_data['fechacreacion'];
    $fechavencimiento = $row_data['fechavencimiento'];
    $totalordenpago = $row_data['totalordenpago'];
    $codigomodalidadacademica = $row_carrera['codigomodalidadacademica'];
    $ciudad = $row_data['nombreciudad'];
    if ($ciudad == ".EXTRANJERO" || $ciudad == "" || $ciudad == null) {
        $ciudad = "BOGOTA DC";
    }
    $pais = $row_data['codigosappais'];
    $periodo = $row_data['codigoperiodo'];
    $subperiodo = substr($periodo, 2, 2) . "0" . substr($periodo, 4, 1);
    $semestre = $row_data['semestreprematricula'];
    $departamento = $row_data['codigosapdepartamento'];
    $fechanacimiento = $row_data['fechanacimientoestudiantegeneral'];

    $genero = $row_data['codigopeoplesexo'];

    $fechanacimiento = $row_data['fechanacimientoestudiantegeneral'];

    $e_mail = "/^[A-z0-9\._-]+"
            . "@"
            . "[A-z0-9][A-z0-9-]*"
            . "(\.[A-z0-9_-]+)*"
            . "\.([A-z]{2,6})$/";

    if ((!preg_match($e_mail, $email) or $email == "")) {
        $email = "no@tiene.com";
    }

    $vars = array("tipodocumento"
        , "documento"
        , "primernombre"
        , "segundonombre"
        , "primerapellido"
        , "segundoapellido"
        , "fechanacimiento"
        , "paisnacionalidad"
        , "departamentonacionalidad"
        , "ciudadnacionalidad"
        , "genero"
        , "estadocivil"
        , "direccion"
        , "telefono"
        , "email"
        , "numeroordenpago"
        , "fechacreacion"
        , "fechavencimiento"
        , "totalordenpago"
        , "codigocarrera"
        , "periodo"
        , "idestudiantegeneral");

    $datos = compact($vars);

    if(isset($db) && !empty($db)){
        require_once(PATH_ROOT . '/serviciosacademicos/consulta/interfacespeople/funcionesPS.php');
        $result = reportarCreacionPeople($db, $datos, $modulo);
    }else{
        require_once(PATH_ROOT . '/serviciosacademicos/consulta/interfacespeople/ordenesdepago/reportarordenespagosala.php');
    }
    return $result; 
}//function crea_estudiante

//func
///// FUNCION PARA HALLAR EL NUMERO DE ORDEN INTERNA /////////////////
function existe_ordeninternaocentrobeneficio($codigoestudiante, $codigocarrera, $codigoperiodo, $sala) {
    unset($materiascongrupo);
    $query_grupos = "select g.idgrupo from grupo g, materia m 
	where m.codigocarrera = '" . $codigocarrera . "'
	and m.codigomateria = g.codigomateria
	and g.codigoperiodo = '$codigoperiodo'";
    //echo $query_grupos;
    //exit();
    $grupos = mysql_query($query_grupos, $sala) or die("$query_grupos" . mysql_error());
    $totalRows_grupos = mysql_num_rows($grupos);
    while ($row_grupos = mysql_fetch_array($grupos)) {
        $materiascongrupo[] = $row_grupos['idgrupo'];
    }
    //  }
    if (is_array($materiascongrupo)) {
        $gruposavalidar = "";
        foreach ($materiascongrupo as $key => $idgrupo) {
            //echo "$key => $idgrupo <br>";
            $gruposavalidar = $gruposavalidar . " n.idgrupo = $idgrupo or";
        }
        $gruposavalidar = ereg_replace("or$", "", $gruposavalidar);
        // Si entra aca es por que aplica orden interna sap, el número de orden interna depende del grupo al que se mete el
        // estudiante, es decir que tengo que pasarle el idgrupo para poderlo validar
        $query_numeroordeninterna = "select distinct n.numeroordeninternasap, n.fechavencimientonumeroordeninternasap,
        g.idgrupo
		from numeroordeninternasap n, grupo g, materia m, estudiante e
		where m.codigomateria = g.codigomateria
		and ($gruposavalidar)
		and m.codigocarrera = e.codigocarrera
		and g.codigoperiodo = '$codigoperiodo'
		and e.codigoestudiante = '$codigoestudiante'
		and n.fechavencimientonumeroordeninternasap >= '" . date("Y-m-d") . "'
		order by 2 desc";
        //echo $query_numeroordeninterna;
        //exit();
        $numeroordeninterna = mysql_query($query_numeroordeninterna, $sala) or die("$query_numeroordeninterna<br>" . mysql_error());
        $totalRows_numeroordeninterna = mysql_num_rows($numeroordeninterna);
        if ($totalRows_numeroordeninterna != "") {
            $row_numeroordeninterna = mysql_fetch_array($numeroordeninterna);
            $ordeninternaocentrobeneficio = $row_numeroordeninterna['numeroordeninternasap'];
            //$idgrupo = $row_numeroordeninterna['idgrupo'];
        }
    }
    return $ordeninternaocentrobeneficio;
}

///////////////////////////////////////////////////////////////////////
?>
