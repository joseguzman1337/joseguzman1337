<?php
/**
 * @modified Vega Gabriel <vegagabriel@unbosque.edu.do>.
 * Se agregan validaciones para cambiar la situacion academica del estudiante cuando
 * el periodo es superior al actual, para evitar la generacion de errores (Req: 1135).
 * @since Abril 30, 2019
 */
$fechaactual = date("Y-m-d H:i:s");

function hacerInscripcion_mysql($numeroordenpago) {
    global $database_sala;
    //consulta los datos del estudiantes carrera y periodo
    $query_orden = "SELECT o.codigoperiodo, o.codigoestudiante, es.codigocarrera, es.idestudiantegeneral
        FROM ordenpago o, concepto c, detalleordenpago dor, estudiante es
        WHERE o.numeroordenpago = '$numeroordenpago'
        AND dor.codigoconcepto = c.codigoconcepto
        and dor.numeroordenpago = o.numeroordenpago
        AND c.cuentaoperacionprincipal = '153'
        and es.codigoestudiante = o.codigoestudiante
        and es.codigosituacioncarreraestudiante = '106'";
    $orden = mysql_db_query($database_sala, $query_orden) or die("$query_orden<br>" . mysql_error());
    $totalRows_orden = mysql_num_rows($orden);

    if ($totalRows_orden == 0) {
        return false;
    } else {
        $row_orden = mysql_fetch_array($orden);

        //consulta el id de inscripcion del estudiante
        $query_inscripcion = "SELECT i.idinscripcion
            FROM inscripcion i, estudiantecarrerainscripcion eci
            WHERE i.idinscripcion = eci.idinscripcion
            and eci.codigocarrera = '" . $row_orden['codigocarrera'] . "'
            and i.codigoperiodo = '" . $row_orden['codigoperiodo'] . "'
            and i.idestudiantegeneral = '" . $row_orden['idestudiantegeneral'] . "'
            and i.codigoestado like '1%'
            and eci.idnumeroopcion = 1";
        $inscripcion = mysql_db_query($database_sala, $query_inscripcion) or die("$query_inscripcion<br>" . mysql_error());
        $totalRows_inscripcion = mysql_num_rows($inscripcion);

        if ($totalRows_inscripcion == 0) {
            return false;
        } else {
            $query_periodo = "SELECT p.codigoestadoperiodo, p.fechainicioperiodo FROM periodo p
                WHERE p.codigoperiodo = '" . $row_orden['codigoperiodo'] . "' ";
            $periodo = mysql_db_query($database_sala, $query_periodo) or die("$query_periodo<br>" . mysql_error());
            $totalRows_periodo = mysql_num_rows($periodo);
            $row_periodo = mysql_fetch_array($periodo);
            //Vaidacion para inactivar el codigoestadoperiodo para que permita cambiar el codigosituacioncarreraestudiante
            //en la tabla inscripcion, ya que si el periodo es superior al actual 
            //este genera error Mysql 1172 - Result consisted of more than one row
            if ($row_periodo['fechainicioperiodo'] > $fechaactual) {
                if ($row_periodo['codigoestadoperiodo'] == 4) {
                    $query_upcodigoestadoperiodo = "UPDATE periodo SET codigoestadoperiodo = '2' WHERE codigoperiodo = '" . $row_orden['codigoperiodo'] . "' ";
                    $upodigoestadoperiodo = mysql_db_query($database_sala, $query_upcodigoestadoperiodo) or die("$query_upcodigoestadoperiodo<br>" . mysql_error());
                }
            }

            $row_inscripcion = mysql_fetch_array($inscripcion);

            //Actualiza el registro del estudiante a 107: inscrito
            $query_updinscripcion = "update inscripcion
                set codigosituacioncarreraestudiante = '107'
                where idinscripcion = '" . $row_inscripcion['idinscripcion'] . "'";
            $updinscripcion = mysql_db_query($database_sala, $query_updinscripcion) or die("$query_updinscripcion<br>" . mysql_error());

            $query_periodo = "SELECT p.codigoestadoperiodo, p.fechainicioperiodo FROM periodo p
                WHERE p.codigoperiodo = '" . $row_orden['codigoperiodo'] . "' ";
            $periodo = mysql_db_query($database_sala, $query_periodo) or die("$query_periodo<br>" . mysql_error());
            $totalRows_periodo = mysql_num_rows($periodo);
            $row_periodo = mysql_fetch_array($periodo);
            //Vaidacion para volver dejar en estado "inscripciones" luego de cambiar el codigosituacioncarreraestudiante
            //en la tabla inscripcion cuando el periodo es superior al actual 
            if ($row_periodo['fechainicioperiodo'] > $fechaactual) {
                if ($row_periodo['codigoestadoperiodo'] == 2) {
                    $query_upcodigoestadoperiodo = "UPDATE periodo SET codigoestadoperiodo = '4' WHERE codigoperiodo = '" . $row_orden['codigoperiodo'] . "' ";
                    $upodigoestadoperiodo = mysql_db_query($database_sala, $query_upcodigoestadoperiodo) or die("$query_upcodigoestadoperiodo<br>" . mysql_error());
                }
            }

            //Si el estudiante tiene notas en el histórico entonces se actualiza el periodo de la cohorte
            $query_nota = "SELECT nh.idnotahistorico
                FROM notahistorico nh
                WHERE nh.codigoestudiante = '" . $row_orden['codigoestudiante'] . "'
                and nh.codigoestadonotahistorico in(100)";
            $nota = mysql_db_query($database_sala, $query_nota) or die("$query_nota<br>" . mysql_error());
            $totalRows_nota = mysql_num_rows($nota);

            if ($totalRows_nota == 0) {
                // Debe actualizar el periodo de la cohorte y la situación del estudiante
                $query_updestudiante = "update estudiante
                    set codigosituacioncarreraestudiante = '107', codigoperiodo = '" . $row_orden['codigoperiodo'] . "'
                    where codigoestudiante = '" . $row_orden['codigoestudiante'] . "'";
                $updestudiante = mysql_db_query($database_sala, $query_updestudiante) or die("$query_updestudiante<br>" . mysql_error());
            }
        }
    }
}

function hacerInscripcion_adodb($numeroordenpago) {
    global $db;
    $query_orden = "SELECT o.codigoperiodo, o.codigoestudiante, es.codigocarrera, es.idestudiantegeneral
        FROM ordenpago o, concepto c, detalleordenpago dor, estudiante es
        WHERE o.numeroordenpago = '$numeroordenpago'
        AND dor.codigoconcepto = c.codigoconcepto
        and dor.numeroordenpago = o.numeroordenpago
        AND c.cuentaoperacionprincipal = '153'
        and es.codigoestudiante = o.codigoestudiante
        and es.codigosituacioncarreraestudiante = '106'";
    $orden = mysql_db_query($database_sala, $query_orden);
    $totalRows_orden = mysql_num_rows($orden);

    if ($totalRows_orden == 0) {
        return false;
    } else {
        $row_orden = mysql_fetch_array($orden);
        // Con el código del estudiante busco la inscripción
        $query_inscripcion = "SELECT i.idinscripcion
            FROM inscripcion i, estudiantecarrerainscripcion eci
            WHERE i.idinscripcion = eci.idinscripcion
            and eci.codigocarrera = '" . $row_orden['codigocarrera'] . "'
            and i.codigoperiodo = '" . $row_orden['codigoperiodo'] . "'
            and i.idestudiantegeneral = '" . $row_orden['idestudiantegeneral'] . "'
            and i.codigoestado like '1%'
            and eci.idnumeroopcion = 1";
        $inscripcion = mysql_db_query($database_sala, $query_inscripcion);
        $totalRows_inscripcion = mysql_num_rows($inscripcion);

        if ($totalRows_inscripcion == 0) {
            return false;
        } else {
            $query_periodo = "SELECT p.codigoestadoperiodo, p.fechainicioperiodo FROM periodo p
                WHERE p.codigoperiodo = '" . $row_orden['codigoperiodo'] . "' ";
            $periodo = mysql_db_query($database_sala, $query_periodo) or die("$query_periodo<br>" . mysql_error());
            $totalRows_periodo = mysql_num_rows($periodo);
            $row_periodo = mysql_fetch_array($periodo);
            //Vaidacion para inactivar el codigoestadoperiodo para que permita cambiar el codigosituacioncarreraestudiante
            //en la tabla inscripcion, ya que si el periodo es superior al actual 
            //este genera error Mysql 1172 - Result consisted of more than one row
            if ($row_periodo['fechainicioperiodo'] > $fechaactual) {
                if ($row_periodo['codigoestadoperiodo'] == 4) {
                    $query_upcodigoestadoperiodo = "UPDATE periodo SET codigoestadoperiodo = '2' WHERE codigoperiodo = '" . $row_orden['codigoperiodo'] . "' ";
                    $upodigoestadoperiodo = mysql_db_query($database_sala, $query_upcodigoestadoperiodo) or die("$query_upcodigoestadoperiodo<br>" . mysql_error());
                }
            }

            $row_inscripcion = mysql_fetch_array($inscripcion);
            // Con el idinscripcion modifico la situación de preinscrito a inscrito
            $query_updinscripcion = "update inscripcion
                set codigosituacioncarreraestudiante = '107'
                where idinscripcion = '" . $row_inscripcion['idinscripcion'] . "'";
            $updinscripcion = mysql_db_query($database_sala, $query_updinscripcion);

            $query_periodo = "SELECT p.codigoestadoperiodo, p.fechainicioperiodo FROM periodo p
                WHERE p.codigoperiodo = '" . $row_orden['codigoperiodo'] . "' ";
            $periodo = mysql_db_query($database_sala, $query_periodo) or die("$query_periodo<br>" . mysql_error());
            $totalRows_periodo = mysql_num_rows($periodo);
            $row_periodo = mysql_fetch_array($periodo);
            //Vaidacion para volver dejar en estado "inscripciones" luego de cambiar el codigosituacioncarreraestudiante
            //en la tabla inscripcion cuando el periodo es superior al actual 
            if ($row_periodo['fechainicioperiodo'] > $fechaactual) {
                if ($row_periodo['codigoestadoperiodo'] == 2) {
                    $query_upcodigoestadoperiodo = "UPDATE periodo SET codigoestadoperiodo = '4' WHERE codigoperiodo = '" . $row_orden['codigoperiodo'] . "' ";
                    $upodigoestadoperiodo = mysql_db_query($database_sala, $query_upcodigoestadoperiodo) or die("$query_upcodigoestadoperiodo<br>" . mysql_error());
                }
            }

            // Si el estudiante tiene notas en el histórico entonces se actualiza el periodo de la cohorte
            $query_nota = "SELECT nh.idnotahistorico
                FROM notahistorico nh
                WHERE nh.codigoestudiante = '" . $row_orden['codigoestudiante'] . "'
                and nh.codigoestadonotahistorico in(100)";
            $nota = mysql_db_query($database_sala, $query_nota);
            $totalRows_nota = mysql_num_rows($nota);

            if ($totalRows_nota == 0) {
                // Debe actualizar el periodo de la cohorte y la situación del estudiante
                $query_updestudiante = "update estudiante
                    set codigosituacioncarreraestudiante = '107', codigoperiodo = '" . $row_orden['codigoperiodo'] . "'
                    where codigoestudiante = '" . $row_orden['codigoestudiante'] . "'";
                $updestudiante = mysql_db_query($database_sala, $query_updestudiante);
            }
        }
    }
}

function hacerInscripcion_pse($numeroordenpago) {
    global $link;
    //mysql_query($query_conceptoorden, $link)
    //mysql_select_db($database_sala, $sala);
    $query_orden = "SELECT o.codigoperiodo, o.codigoestudiante, es.codigocarrera, es.idestudiantegeneral
        FROM ordenpago o, concepto c, detalleordenpago dor, estudiante es
        WHERE o.numeroordenpago = '$numeroordenpago'
        AND dor.codigoconcepto = c.codigoconcepto
        and dor.numeroordenpago = o.numeroordenpago
        AND c.cuentaoperacionprincipal = '153'
        and es.codigoestudiante = o.codigoestudiante
        and es.codigosituacioncarreraestudiante = '106'";
    $orden = mysql_query($query_orden, $link) or die("$query_orden<br>" . mysql_error());
    $totalRows_orden = mysql_num_rows($orden);

    if ($totalRows_orden == 0) {
        return false;
    } else {
        $query_periodo = "SELECT p.codigoestadoperiodo, p.fechainicioperiodo FROM periodo p
            WHERE p.codigoperiodo = '" . $row_orden['codigoperiodo'] . "' ";
        $periodo = mysql_db_query($database_sala, $query_periodo) or die("$query_periodo<br>" . mysql_error());
        $totalRows_periodo = mysql_num_rows($periodo);
        $row_periodo = mysql_fetch_array($periodo);
        //Vaidacion para inactivar el codigoestadoperiodo para que permita cambiar el codigosituacioncarreraestudiante
        //en la tabla inscripcion, ya que si el periodo es superior al actual 
        //este genera error Mysql 1172 - Result consisted of more than one row
        if ($row_periodo['fechainicioperiodo'] > $fechaactual) {
            if ($row_periodo['codigoestadoperiodo'] == 4) {
                $query_upcodigoestadoperiodo = "UPDATE periodo SET codigoestadoperiodo = '2' WHERE codigoperiodo = '" . $row_orden['codigoperiodo'] . "' ";
                $upodigoestadoperiodo = mysql_db_query($database_sala, $query_upcodigoestadoperiodo) or die("$query_upcodigoestadoperiodo<br>" . mysql_error());
            }
        }

        $row_orden = mysql_fetch_array($orden);
        // Con el código del estudiante busco la inscripción
        $query_inscripcion = "SELECT i.idinscripcion
            FROM inscripcion i, estudiantecarrerainscripcion eci
            WHERE i.idinscripcion = eci.idinscripcion
            and eci.codigocarrera = '" . $row_orden['codigocarrera'] . "'
            and i.codigoperiodo = '" . $row_orden['codigoperiodo'] . "'
            and i.idestudiantegeneral = '" . $row_orden['idestudiantegeneral'] . "'
            and i.codigoestado like '1%'
            and eci.idnumeroopcion = 1";
        $inscripcion = mysql_query($query_inscripcion, $link) or die("$query_inscripcion<br>" . mysql_error());
        $totalRows_inscripcion = mysql_num_rows($inscripcion);

        if ($totalRows_inscripcion == 0) {
            return false;
        } else {
            $row_inscripcion = mysql_fetch_array($inscripcion);
            // Con el idinscripcion modifico la situación de preinscrito a inscrito
            $query_updinscripcion = "update inscripcion
                set codigosituacioncarreraestudiante = '107'
                where idinscripcion = '" . $row_inscripcion['idinscripcion'] . "'";
            $updinscripcion = mysql_query($query_updinscripcion, $link) or die("$query_updinscripcion<br>" . mysql_error());

            $query_periodo = "SELECT p.codigoestadoperiodo, p.fechainicioperiodo FROM periodo p
                WHERE p.codigoperiodo = '" . $row_orden['codigoperiodo'] . "' ";
            $periodo = mysql_db_query($database_sala, $query_periodo) or die("$query_periodo<br>" . mysql_error());
            $totalRows_periodo = mysql_num_rows($periodo);
            $row_periodo = mysql_fetch_array($periodo);
            //Vaidacion para volver dejar en estado "inscripciones" luego de cambiar el codigosituacioncarreraestudiante
            //en la tabla inscripcion cuando el periodo es superior al actual 
            if ($row_periodo['fechainicioperiodo'] > $fechaactual) {
                if ($row_periodo['codigoestadoperiodo'] == 2) {
                    $query_upcodigoestadoperiodo = "UPDATE periodo SET codigoestadoperiodo = '4' WHERE codigoperiodo = '" . $row_orden['codigoperiodo'] . "' ";
                    $upodigoestadoperiodo = mysql_db_query($database_sala, $query_upcodigoestadoperiodo) or die("$query_upcodigoestadoperiodo<br>" . mysql_error());
                }
            }

            // Si el estudiante tiene notas en el histórico entonces se actualiza el periodo de la cohorte
            $query_nota = "SELECT nh.idnotahistorico
                FROM notahistorico nh
                WHERE nh.codigoestudiante = '" . $row_orden['codigoestudiante'] . "'
                and nh.codigoestadonotahistorico in(100)";
            $nota = mysql_query($query_nota, $link) or die("$query_nota<br>" . mysql_error());
            $totalRows_nota = mysql_num_rows($nota);

            if ($totalRows_nota == 0) {
                // Debe actualizar el periodo de la cohorte y la situación del estudiante
                $query_updestudiante = "update estudiante
                    set codigosituacioncarreraestudiante = '107', codigoperiodo = '" . $row_orden['codigoperiodo'] . "'
                    where codigoestudiante = '" . $row_orden['codigoestudiante'] . "'";
                $updestudiante = mysql_query($query_updestudiante, $link) or die("$query_updestudiante<br>" . mysql_error());
            }
        }
    }
}

?>