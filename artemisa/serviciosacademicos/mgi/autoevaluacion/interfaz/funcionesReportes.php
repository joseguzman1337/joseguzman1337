<?php

require(realpath(dirname(__FILE__) . "/../../../../sala/includes/adaptador.php"));

$html = "";
$htmlp = "";

switch ($_POST['action']) {
    case 'consultardatos': {
            $idInstrumento = $_POST['id'];
            $carrera = $_POST['carrera'];
            $periodo = $_POST['periodo'];

            $sql = "SELECT
                        p.MateriasMatriculadas,
                    IF (
                        p.MateriasEvaluadas > p.MateriasMatriculadas,
                        p.MateriasMatriculadas,
                        p.MateriasEvaluadas
                    ) AS MateriasEvaluadas,
                    IF (
                        (p.MateriasMatriculadas - p.MateriasEvaluadas) < 0,
                        0,
                        (p.MateriasMatriculadas - p.MateriasEvaluadas)
                    ) AS MateriasSinEvaluar,
                     p.numerodocumento,
                     p.NombreCompleto,
                     p.telefonoresidenciaestudiantegeneral,
                     p.celularestudiantegeneral,
                     p.emailestudiantegeneral,
                     p.emailinstitucional,
                     p.codigocarrera,
                     p.nombrecarrera
                    FROM
                            (
                    SELECT
                            ege.numerodocumento,
                            CONCAT(
                                    ege.apellidosestudiantegeneral,
                                    ' ',
                                    ege.nombresestudiantegeneral
                            ) AS NombreCompleto,
                            COUNT( dp.idprematricula) AS MateriasMatriculadas,
                            dp.idprematricula,
                    IF (
                            (b.MateriasEvaluadas) IS NULL,
                            0,
                            b.MateriasEvaluadas
                    ) AS MateriasEvaluadas,
                     ege.telefonoresidenciaestudiantegeneral,
                     ege.celularestudiantegeneral,
                     ege.emailestudiantegeneral,
                     CONCAT(
                            u.usuario,
                            '@unbosque.edu.co'
                    ) AS emailinstitucional,
                     e.codigocarrera,
                     c.nombrecarrera,
                     u.idusuario
                    FROM estudiantegeneral ege
                    INNER JOIN estudiante e ON (ege.idestudiantegeneral = e.idestudiantegeneral)
                    INNER JOIN carrera c ON (e.codigocarrera = c.codigocarrera)
                    INNER JOIN usuario u ON (ege.numerodocumento = u.numerodocumento)
                    INNER JOIN prematricula p ON (e.codigoestudiante = p.codigoestudiante)
                    INNER JOIN detalleprematricula dp ON (p.idprematricula = dp.idprematricula)
                    -- INNER JOIN ordenpago o ON (dp.numeroordenpago = o.numeroordenpago)
                    LEFT JOIN (
                            SELECT
                                    a.usuariocreacion,
                                    COUNT(a.usuariocreacion) AS MateriasEvaluadas
                            FROM
                                    (
                                            SELECT
                                                    ar.usuariocreacion,
                                                    ar.idsiq_Ainstrumentoconfiguracion,
                                                    COUNT(*) AS Respuestas
                                            FROM siq_Arespuestainstrumento ar
                                            WHERE ar.idsiq_Ainstrumentoconfiguracion = '" . $idInstrumento . "'
                                            AND ar.codigoestado = '100'
                                            GROUP BY
                                                    ar.idgrupo,
                                                    ar.usuariocreacion
                                            HAVING COUNT(*) >= (
                                                            SELECT COUNT(*) AS contador
                                                            FROM siq_Ainstrumento i
                                                            INNER JOIN siq_Apregunta p ON (i.idsiq_Apregunta = p.idsiq_Apregunta)
                                                            WHERE i.idsiq_Ainstrumentoconfiguracion = '" . $idInstrumento . "'
                                                            AND p.obligatoria = '1'
                                                            AND i.codigoestado = '100'
                                                    )
                                            ORDER BY ar.usuariocreacion
                                    ) a
                            GROUP BY
                                    a.usuariocreacion
                    ) b ON (u.idusuario = b.usuariocreacion)
                    WHERE u.codigotipousuario = 600
                    AND u.codigoestadousuario = 100
                    AND p.codigoperiodo = '" . $periodo . "'
                    AND p.codigoestadoprematricula IN (40, 41)
                    AND dp.codigoestadodetalleprematricula = 30
                    AND dp.numeroordenpago IN (SELECT o.numeroordenpago FROM ordenpago o WHERE o.codigoperiodo = p.codigoperiodo AND o.codigoestudiante = p.codigoestudiante AND o.codigoestadoordenpago IN (40, 41, 44))
                    AND e.codigocarrera = '" . $carrera . "'
                    GROUP BY dp.idprematricula)p
                    ORDER BY p.NombreCompleto ASC ";

            $result = $db->GetAll($sql);

            $html1 = "";
            $i = 1;
            foreach ($result as $datos) {

                $sqlupdate = "";
                if ($datos['MateriasSinEvaluar'] == 0) {
                    $idusuario = $datos['idusuario'];

                    $sqlupdate = "UPDATE actualizacionusuario "
                            . "SET estadoactualizacion='3', changedate = NOW() "
                            . "WHERE (`usuarioid`= '" . $idusuario . "' "
                            . "AND id_instrumento =  (select s.idsiq_Ainstrumentoconfiguracion from siq_Ainstrumentoconfiguracion s, periodo p "
                            . " WHERE s.cat_ins = 'EDOCENTES' "
                            . " AND p.codigoperiodo = '" . $periodo . "' "
                            . " AND s.fecha_inicio > p.fechainicioperiodo "
                            . " AND s.fecha_fin < p.fechavencimientoperiodo "
                            . " AND s.estado = 1) "
                            . "AND estadoactualizacion <> '3') Limit 1";
                    $db->Execute($sqlupdate);
                } else {

                    $html1 .= "<tr>";
                    $html1 .= "<td>" . $i . "</td>";
                    $html1 .= "<td>" . $datos['MateriasMatriculadas'] . "</td>";
                    $html1 .= "<td>" . $datos['MateriasEvaluadas'] . "</td>";
                    $html1 .= "<td>" . $datos['MateriasSinEvaluar'] . "</td>";
                    $html1 .= "<td>" . $datos['numerodocumento'] . "</td>";
                    $html1 .= "<td>" . $datos['NombreCompleto'] . "</td>";
                    $html1 .= "<td>" . $datos['telefonoresidenciaestudiantegeneral'] . "</td>";
                    $html1 .= "<td>" . $datos['celularestudiantegeneral'] . "</td>";
                    $html1 .= "<td>" . $datos['emailestudiantegeneral'] . "</td>";
                    $html1 .= "<td>" . $datos['emailinstitucional'] . "</td>";
                    $html1 .= "<td>" . $datos['codigocarrera'] . "</td>";
                    $html1 .= "<td>" . $datos['nombrecarrera'] . "</td>";
                    $html1 .= "</tr>";

                    $i++;
                }
            }
            $html1 .= "";
            echo $html1;
        }
        break;

    case 'Consultaprogramas': {
            //LISTA LAS CARRERAS ACTIVAS SOLO PARA LA MODALIDAD DE PREGRADO.   
            $queryprogramas = "SELECT  c.codigocarrera, c.nombrecarrera
            FROM carrera c
            WHERE c.codigomodalidadacademica = 200
            AND c.codigocarrera NOT IN (30,39,74,138,2,1,12,79,3,868,4,1187,782,417,6,7)
            AND c.fechavencimientocarrera > now()
            AND c.codigocarrera IN( select DISTINCT c.codigocarrera from grupo g
                INNER JOIN materia m ON (m.codigomateria = g.codigomateria)
                INNER JOIN carrera c ON (c.codigocarrera = m.codigocarrera)
                INNER JOIN detalleprematricula dtpr ON (dtpr.idgrupo = g.idgrupo AND dtpr.codigoestadodetalleprematricula = 30)
                where g.codigoperiodo = " . $_POST['periodo'] . " AND g.codigoestadogrupo = 10)
            GROUP BY c.codigocarrera ORDER BY c.nombrecarrera";
            $programas = $db->GetAll($queryprogramas);

            $html .= "<select id='carrera' name='carrera' class='form-control js-example-basic-single'> <option value='0'>Selección</option>";
            foreach ($programas as $listado) {
                $html .= "<option value='" . $listado['codigocarrera'] . "'>" . $listado['nombrecarrera'] . "</option>";
            }
            $html .= "</select>";

            echo $html;
        }
        break;

    case 'Consultaperiodo': {
            //LISTA LOS PERIODOS ACTIVOS A PARTIR DEL PERIODO 20051.
            $SQL_periodo = "SELECT
                p.codigoperiodo,
                p.nombreperiodo
            FROM periodo p
            WHERE p.codigoperiodo >= 20101    
            ORDER BY p.codigoperiodo DESC";
            $periodos = $db->GetAll($SQL_periodo);

            $htmlp .= "<select id='periodo' name='periodo'> <option value='0'>Selección</option>";
            foreach ($periodos as $listaperiodos) {
                $htmlp .= "<option value='" . $listaperiodos['codigoperiodo'] . "'>" . $listaperiodos['nombreperiodo'] . "</option>";
            }
            $htmlp .= "</select>";

            echo $htmlp;
        }
        break;
    case 'Consultainstrumentos': {
            $categoria = 'EDOCENTES';
            $periodo = $_POST['periodo'];
            //Lista los instrumentos creados para la categoria de Docentes de acuerdo al periodo seleccionado.
            $sql = "SELECT s.idsiq_Ainstrumentoconfiguracion, s.nombre FROM siq_Ainstrumentoconfiguracion s WHERE s.estado = '1' AND cat_ins = '" . $categoria . "' " .
                    " AND s.codigoestado = '100' AND s.fecha_inicio >= (SELECT fechainicioperiodo FROM periodo WHERE codigoperiodo = '" . $periodo . "') " .
                    " AND s.fecha_fin <= (select fechavencimientoperiodo FROM periodo WHERE codigoperiodo = '" . $periodo . "')";

            $instrumento = $db->GetAll($sql);

            $html .= "<select id='instrumento' name='instrumento' class='form-control'><option value='0'>Selección</option>";
            foreach ($instrumento as $listado) {
                $html .= "<option value='" . $listado['idsiq_Ainstrumentoconfiguracion'] . "'>" . $listado['nombre'] . "</option>";
            }
            $html .= "</select>";

            echo $html;
        }break;
}