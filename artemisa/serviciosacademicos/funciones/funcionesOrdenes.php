<?php
require_once(PATH_ROOT . '/serviciosacademicos/consulta/interfacespeople/funcionesPS.php');
function enviarps_orden($ordenpago, $sala, $id, $db = null) {
    $resultado = "";
    $query_selmaxnumeroordenpago = "SELECT do.codigoconcepto
		FROM detalleordenpago do,concepto c
		WHERE c.codigoconcepto = do.codigoconcepto
		AND do.numeroordenpago = '" . $ordenpago . "'
		AND c.cuentaoperacionprincipal = '153' ";
    //echo $query_selmaxnumeroordenpago."<br>";
    if (isset($sala) && !empty($sala)) {
        $selmaxnumeroordenpago = mysql_query($query_selmaxnumeroordenpago, $sala) or die("$query_selmaxnumeroordenpago<br>" . mysql_error());
        $row_selmaxnumeroordenpago = mysql_fetch_array($selmaxnumeroordenpago);
    } else {
        $row_selmaxnumeroordenpago = $db->GetRow($query_selmaxnumeroordenpago);
    }
    
    
        $resultado = estudianteOrden($db, $ordenpago);
   
    //print_r($resultado);
    $query_update = "UPDATE tmpIntegracionorden20112 SET estado='" . $resultado['ERRNUM'] . "', respuesta='" . $resultado['DESCRLONG'] . "' WHERE numeroordenpago = '" . $ordenpago . "' AND (estado='' OR estado IS NULL) ";
    if (isset($sala) && !empty($sala)) {
        mysql_query($query_update, $sala) or die("$query_update<br>" . mysql_error());
    } else {
        $db->Execute($Query);
    }
}

function validarOrden($numeroorden, $sala, $db = null) {
    $Query = "select eg.numerodocumento,o.numeroordenpago,tmp.numerodocumento as doc from ordenpago o 
					INNER JOIN prematricula pr on pr.idprematricula=o.idprematricula 
					INNER JOIN detalleprematricula dpr on dpr.idprematricula=pr.idprematricula 
					INNER JOIN estudiante e on e.codigoestudiante=o.codigoestudiante 
					INNER JOIN carrera c on c.codigocarrera=e.codigocarrera 
					INNER JOIN estudiantegeneral eg on eg.idestudiantegeneral=e.idestudiantegeneral 
					INNER JOIN detalleordenpago do on do.numeroordenpago=o.numeroordenpago and do.valorconcepto>0 
					INNER JOIN fechaordenpago f on f.numeroordenpago = do.numeroordenpago 
					LEFT JOIN tmpIntegracionorden20112 tmp on tmp.numeroordenpago = o.numeroordenpago and estado in (0,1) 
					WHERE o.numeroordenpago IN ('" . $numeroorden . "' ) 
					AND codigoestadoordenpago not like '2%'
				GROUP BY eg.numerodocumento";
    if (isset($sala) && !empty($sala)) {
        $resultado = mysql_query($Query, $sala) or die("$Query<br>" . mysql_error());
        $row = mysql_fetch_array($resultado);
    } else {
        $row = $db->GetRow($Query);
    }
    if (count($row) > 0) {
        return $row;
    }
    return false;
}

?>