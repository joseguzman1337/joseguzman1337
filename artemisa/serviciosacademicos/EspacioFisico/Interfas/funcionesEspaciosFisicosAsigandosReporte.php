<?php
 /**
 * @created Vega Gabriel <vegagabriel@unbosque.edu.do>.
 * Se crea este archivo para organizar los casos del actionID
 * @since Agosto 9, 2019
 */
switch ($_POST['actionID']) {
    case 'generamensaje': {
            $db = General();
            $Num_Docente = $_POST['Num_Docente'];
            $Num_Estudiante = $_POST['Num_Estudiante'];
            $Fecha_Actual = $_POST['Fecha_ini'];
            $Fecha_Fin = $_POST['Fecha_Fin'];

            $Datos = Consulta($db, $Num_Docente, $Num_Estudiante, '', '', $Fecha_Actual, $Fecha_Fin);

            $nombreestadodetalleprematricula = array();
            for ($i = 0; $i < count($Datos['Datos']); $i++) {
                $nombreestadodetalleprematricula[] = $Datos['Datos'][$i]['nombreestadodetalleprematricula'];
            }
            $html1 = '';

            if (in_array("Prematricula", $nombreestadodetalleprematricula)) {
                $html1 .= "<center>";
                $html1 .= "<div class='form-group col-md-12'> ";
                $html1 .= "<h3>Aun se encuentra prematriculado</h3>";
                $html1 .= "</div>";
                $html1 .= "</center>";
            }

            echo $html1;
        }break;
    case 'consultardatos': {
            $db = General();
            $Num_Docente = $_POST['Num_Docente'];
            $Num_Estudiante = $_POST['Num_Estudiante'];
            $Fecha_Actual = $_POST['Fecha_ini'];
            $Fecha_Fin = $_POST['Fecha_Fin'];

            $Datos = Consulta($db, $Num_Docente, $Num_Estudiante, '', '', $Fecha_Actual, $Fecha_Fin);
            $html1 = '';
            for ($i = 0; $i < count($Datos['Datos']); $i++) {
                $n = $i + 1;
                $html1 .= "<tr>";
                $html1 .= "<td>" . $n . "</td>";
                $html1 .= "<td>" . $Datos['Datos'][$i]['Campus'] . "</td>";
                $html1 .= "<td>" . $Datos['Datos'][$i]['Bloke'] . "</td>";
                $html1 .= "<td>" . $Datos['Datos'][$i]['Nombre'] . "</td>";
                $html1 .= "<td>" . $Datos['Datos'][$i]['nombregrupo'] . "</td>";
                $html1 .= "<td>" . $Datos['Datos'][$i]['nombrecarrera'] . "</td>";
                $html1 .= "<td>" . $Datos['Datos'][$i]['nombremateria'] . "</td>";
                $html1 .= "<td>" . $Datos['Datos'][$i]['nombreestadodetalleprematricula'] . "</td>";
                $html1 .= "<td>" . $Datos['Datos'][$i]['FechaAsignacion'] . "</td>";
                $html1 .= "<td>" . $Datos['Datos'][$i]['nombredia'] . "</td>";
                $html1 .= "<td>" . $Datos['Datos'][$i]['HoraInicio'] . "</td>";
                $html1 .= "<td>" . $Datos['Datos'][$i]['HoraFin'] . "</td>";
                $html1 .= "<td>" . $Datos['Datos'][$i]['DocenteName'] . "</td>";
                $html1 .= "</tr>";
            }
            echo $html1;
        }break;
}

function General() {

    include_once("../templates/template.php");


    $db = getBD();

    return $db;
}

function Consulta($db, $Num_Docente = '', $Num_Estudiante = '', $Name_Grupo = '', $Name_Materia = '', $Fecha_Actual, $Fecha_Fin) {
    

    $Fecha = date('Y-m-d');
    $Periodo = Periodo($db);
    $Data = array();

    if ($Num_Docente != '' && $Num_Estudiante == '' && $Name_Grupo == '' && $Name_Materia == '') {
        /*         * ****************Filtro Docente************************************* */
        $Condicion = '  g.numerodocumento="' . $Num_Docente . '"';
        $Gruop_By = 'GROUP BY a.AsignacionEspaciosId';
    } else if ($Num_Docente == '' && $Num_Estudiante != '' && $Name_Grupo == '' && $Name_Materia == '') {
        /*         * ****************Filtro Estudioante************************************* */
        $Condicion = '  eg.numerodocumento="' . $Num_Estudiante . '"';
        $Gruop_By = 'GROUP BY   x.codigodia,m.codigomateria,d.idgrupo,HoraInicio,HoraFin,a.FechaAsignacion';
    } else if ($Num_Docente == '' && $Num_Estudiante == '' && $Name_Grupo != '' & $Name_Materia == '') {
        /*         * ****************Filtro Nombre Grupo************************************* */
        $Condicion = '  g.nombregrupo LIKE "' . $Name_Grupo . '%"';
        $Gruop_By = '';
    } else if ($Num_Docente == '' && $Num_Estudiante == '' && $Name_Grupo == '' && $Name_Materia != '') {
        /*         * ****************Filtro Nombre Materia************************************* */
        $Condicion = '  m.nombremateria LIKE "' . $Name_Materia . '%"';
        $Gruop_By = '';
    } else if ($Num_Docente != '' && $Num_Estudiante != '' && $Name_Grupo == '' && $Name_Materia == '') {
        /*         * ****************Filtro Num Docente y Estudiante************************************* */
        $Condicion = '  g.numerodocumento="' . $Num_Docente . '" AND eg.numerodocumento="' . $Num_Estudiante . '"';
        $Gruop_By = '';
    } else if ($Num_Docente != '' && $Num_Estudiante == '' && $Name_Grupo != '' && $Name_Materia == '') {
        /*         * ****************Filtro Num Docente y Name Grupo************************************* */
        $Condicion = '  g.numerodocumento="' . $Num_Docente . '" AND g.nombregrupo LIKE "' . $Name_Grupo . '%"';
        $Gruop_By = '';
    } else if ($Num_Docente != '' && $Num_Estudiante == '' && $Name_Grupo == '' && $Name_Materia != '') {
        /*         * ****************Filtro Num Docente y Name Materia************************************* */
        $Condicion = '  g.numerodocumento="' . $Num_Docente . '" AND m.nombremateria LIKE "' . $Name_Materia . '%"';
        $Gruop_By = '';
    } else if ($Num_Docente == '' && $Num_Estudiante != '' && $Name_Grupo != '' && $Name_Materia == '') {
        /*         * ****************Filtro Num Estudiante y Name Grupo************************************* */
        $Condicion = '  eg.numerodocumento="' . $Num_Estudiante . '" AND g.nombregrupo LIKE "' . $Name_Grupo . '%"';
        $Gruop_By = '';
    } else if ($Num_Docente == '' && $Num_Estudiante != '' && $Name_Grupo == '' && $Name_Materia != '') {
        /*         * ****************Filtro Num Estudiante y Name Materia************************************* */
        $Condicion = '  eg.numerodocumento="' . $Num_Estudiante . '" AND m.nombremateria LIKE "' . $Name_Materia . '%"';
        $Gruop_By = '';
    } else if ($Num_Docente == '' && $Num_Estudiante == '' && $Name_Grupo != '' && $Name_Materia != '') {
        /*         * ****************Filtro Name Grupo y Name Materia************************************* */
        $Condicion = '  g.nombregrupo LIKE "' . $Name_Grupo . '%"" AND m.nombremateria LIKE "' . $Name_Materia . '%"';
        $Gruop_By = '';
    } else if ($Num_Docente != '' && $Num_Estudiante != '' && $Name_Grupo != '' && $Name_Materia == '') {
        /*         * ****************Filtro Num Docente, num Estudiante Y Name Grupo ************************************* */
        $Condicion = '  g.numerodocumento="' . $Num_Docente . '" AND eg.numerodocumento="' . $Num_Estudiante . '" AND g.nombregrupo LIKE "' . $Name_Grupo . '%"';
        $Gruop_By = '';
    } else if ($Num_Docente != '' && $Num_Estudiante != '' && $Name_Grupo == '' && $Name_Materia != '') {
        /*         * ****************Filtro Num Docente, num Estudiante Y Name Materia ************************************* */
        $Condicion = '  g.numerodocumento="' . $Num_Docente . '" AND eg.numerodocumento="' . $Num_Estudiante . '" AND m.nombremateria LIKE "' . $Name_Materia . '%"';
        $Gruop_By = '';
    } else if ($Num_Docente == '' && $Num_Estudiante != '' && $Name_Grupo != '' && $Name_Materia != '') {
        /*         * ***************Filtro num Estudiante, Name grupo Y Name Materia ************************************* */
        $Condicion = '   eg.numerodocumento="' . $Num_Estudiante . '"  AND g.nombregrupo LIKE "' . $Name_Grupo . '%"  AND m.nombremateria LIKE "' . $Name_Materia . '%"';
        $Gruop_By = '';
    } else if ($Num_Docente != '' && $Num_Estudiante != '' && $Name_Grupo != '' && $Name_Materia != '') {
        /*         * ****************Filtro Num Docente ,num Estudiante, Name grupo Y Name Materia ************************************* */
        $Condicion = '   g.numerodocumento="' . $Num_Docente . '"  AND eg.numerodocumento="' . $Num_Estudiante . '"  AND g.nombregrupo LIKE "' . $Name_Grupo . '%"  AND m.nombremateria LIKE "' . $Name_Materia . '%"';
        $Gruop_By = '';
    } else if ($Num_Docente == '' && $Num_Estudiante == '' && $Name_Grupo == '' && $Name_Materia == '') {
        /*         * ****************Error Data************************************* */

        $Data['val'] = false;
        $Data['Descrip'] = 'Error en la Data...';
        return $Data;
        exit;
    }

    $ValidaModalidadData = false;
    if ($Num_Estudiante) {
        $SQL = 'SELECT e.codigoestudiante
                    FROM estudiantegeneral ee 
                    INNER JOIN estudiante e ON e.idestudiantegeneral=ee.idestudiantegeneral
                    INNER JOIN carrera c ON c.codigocarrera=e.codigocarrera
                    WHERE ee.numerodocumento="' . $Num_Estudiante . '"
                    AND c.codigomodalidadacademica=300';

        if ($ValidaModalidad = &$db->Execute($SQL) === false) {
            echo 'Error en el Sistema .....';
            die;
        }

        if (!$ValidaModalidad->EOF) {
            $ValidaModalidadData = true;
        } else {
            $ValidaModalidadData = false;
        }
    }
    if ($ValidaModalidadData == false) {

        $SQL = 'SELECT
                p.idprematricula,
                d.idgrupo,
                x.codigodia,
                x.nombredia,
                ca.nombrecarrera,
                m.nombremateria,
                ed.nombreestadodetalleprematricula,
                g.nombregrupo,
                sg.SolicitudAsignacionEspacioId,
                IF(c.Nombre IS NULL,"Falta Por Asignar",c.Nombre) AS Nombre,
                a.FechaAsignacion,
                if(a.HoraInicio IS NULL,h.horainicial,a.HoraInicio) AS  HoraInicio,
                IF(a.HoraFin IS NULL, h.horafinal,a.HoraFin) AS HoraFin,
                cc.Nombre AS Bloke,
                ccc.Nombre AS Campus,
                g.numerodocumento AS numDocente,
                m.nombremateria,
                CONCAT(dc.nombredocente," ",dc.apellidodocente) AS DocenteName,
                p.idprematricula,
                p.codigoestudiante,
                CONCAT(eg.nombresestudiantegeneral," ",eg.apellidosestudiantegeneral) AS NameEstudiante,
                eg.numerodocumento
                FROM prematricula p
                INNER JOIN detalleprematricula d ON d.idprematricula = p.idprematricula
                INNER JOIN estadodetalleprematricula ed ON ed.codigoestadodetalleprematricula=d.codigoestadodetalleprematricula
                INNER JOIN horario h ON h.idgrupo = d.idgrupo
                INNER JOIN dia x ON x.codigodia = h.codigodia
                INNER JOIN grupo g ON g.idgrupo = d.idgrupo
                INNER JOIN materia m ON m.codigomateria = g.codigomateria
                INNER JOIN estudiante e ON e.codigoestudiante=p.codigoestudiante
                INNER JOIN estudiantegeneral eg ON eg.idestudiantegeneral=e.idestudiantegeneral
                INNER JOIN carrera ca ON ca.codigocarrera=e.codigocarrera
                INNER JOIN docente dc ON dc.numerodocumento=g.numerodocumento
                LEFT JOIN SolicitudEspacioGrupos sg ON sg.idgrupo = d.idgrupo
                LEFT JOIN AsignacionEspacios a ON a.SolicitudAsignacionEspacioId = sg.SolicitudAsignacionEspacioId
                LEFT JOIN SolicitudAsignacionEspacios s ON s.SolicitudAsignacionEspacioId = sg.SolicitudAsignacionEspacioId
                LEFT JOIN ClasificacionEspacios c ON c.ClasificacionEspaciosId = a.ClasificacionEspaciosId
                LEFT JOIN ClasificacionEspacios cc ON cc.ClasificacionEspaciosId=c.ClasificacionEspacionPadreId
                LEFT JOIN ClasificacionEspacios ccc ON ccc.ClasificacionEspaciosId=cc.ClasificacionEspacionPadreId                    
                WHERE
                ' . $Condicion . '
                AND (a.EstadoAsignacionEspacio = 1 OR a.EstadoAsignacionEspacio IS NULL)
                AND d.codigoestadodetalleprematricula  IN (10,30)
                /*AND p.codigoestadoprematricula IN (40,41)*/
                AND p.codigoperiodo="' . $Periodo . '"
                AND (sg.codigoestado=100 OR sg.codigoestado IS NULL)
                AND (a.codigoestado=100 OR a.codigoestado IS NULL)
                AND (a.FechaAsignacion BETWEEN "' . $Fecha_Actual . '" AND "' . $Fecha_Fin . '" OR a.FechaAsignacion IS NULL)
                AND (s.codigodia=h.codigodia OR s.codigodia IS NULL)
                AND s.codigoestado=100 
                ' . $Gruop_By . '                            
                ORDER BY x.codigodia,a.FechaAsignacion ,a.HoraInicio, a.HoraFin';
    } else {
        $SQL = 'SELECT
                p.idprematricula,
                g.idgrupo,
                x.codigodia,
                x.nombredia,
                ca.nombrecarrera,
                m.nombremateria,
                ed.nombreestadodetalleprematricula,
                g.nombregrupo,
                sg.SolicitudAsignacionEspacioId,
                IF ( c.Nombre IS NULL, "Falta Por Asignar", c.Nombre ) AS Nombre,
                a.FechaAsignacion,
                a.HoraInicio,
                a.HoraFin,
                cc.Nombre AS Bloke,
                ccc.Nombre AS Campus,
                g.numerodocumento AS numDocente,
                m.nombremateria,
                p.idprematricula,
                p.codigoestudiante,
                CONCAT( ee.nombresestudiantegeneral, " ", ee.apellidosestudiantegeneral ) AS NameEstudiante,
                ee.numerodocumento,
                IF(g.numerodocumento=1," "," ") AS DocenteName
                FROM
                estudiantegeneral ee 
                INNER JOIN estudiante e ON e.idestudiantegeneral=ee.idestudiantegeneral
                INNER JOIN carrera ca ON ca.codigocarrera=e.codigocarrera
                INNER JOIN prematricula p ON p.codigoestudiante=e.codigoestudiante
                INNER JOIN detalleprematricula dp ON dp.idprematricula=p.idprematricula
                INNER JOIN estadodetalleprematricula ed ON ed.codigoestadodetalleprematricula=dp.codigoestadodetalleprematricula
                INNER JOIN grupo g ON g.idgrupo=dp.idgrupo
                INNER JOIN materia m ON m.codigomateria=g.codigomateria
                LEFT JOIN SolicitudEspacioGrupos sg ON sg.idgrupo=dp.idgrupo
                LEFT JOIN SolicitudAsignacionEspacios s ON s.SolicitudAsignacionEspacioId=sg.SolicitudAsignacionEspacioId AND s.codigoestado = 100
                LEFT JOIN AsignacionEspacios a ON a.SolicitudAsignacionEspacioId=s.SolicitudAsignacionEspacioId
                LEFT JOIN AsociacionSolicitud aso ON aso.SolicitudAsignacionEspaciosId=s.SolicitudAsignacionEspacioId
                LEFT JOIN ClasificacionEspacios c ON c.ClasificacionEspaciosId=a.ClasificacionEspaciosId
                LEFT JOIN ClasificacionEspacios cc ON cc.ClasificacionEspaciosId = c.ClasificacionEspacionPadreId
                LEFT JOIN ClasificacionEspacios ccc ON ccc.ClasificacionEspaciosId = cc.ClasificacionEspacionPadreId
                LEFT JOIN dia x ON x.codigodia=s.codigodia 
                WHERE ee.numerodocumento="' . $Num_Estudiante . '" 
                AND p.codigoperiodo="' . $Periodo . '"
                AND dp.codigoestadodetalleprematricula IN (10,30)
                /*AND p.codigoestadoprematricula IN (40, 41)*/
                AND ( sg.codigoestado = 100 OR sg.codigoestado IS NULL )
                AND ( a.codigoestado = 100 OR a.codigoestado IS NULL )
                AND ( a.FechaAsignacion BETWEEN "' . $Fecha_Actual . '" AND "' . $Fecha_Fin . '" OR a.FechaAsignacion IS NULL )
                GROUP BY x.codigodia, m.codigomateria, g.idgrupo, a.HoraInicio, a.HoraFin, a.FechaAsignacion
                ORDER BY x.codigodia, a.FechaAsignacion, a.HoraInicio, a.HoraFin';
    }

    if ($Resultao = &$db->Execute($SQL) === false) {
        Echo 'Error en el SQL de la Consulta....<br><br>' . $SQL;
        die;
    }
    $C_Resultado = $Resultao->GetArray();

    $Data['val'] = true;
    $Data['Datos'] = $C_Resultado;
    return $Data;
}

function Periodo($db) {
    
    $SQL = 'SELECT 
                codigoperiodo AS id,
                codigoperiodo
                FROM periodo
                WHERE codigoestadoperiodo IN(1,3)';

    if ($Periodos = &$db->Execute($SQL) === false) {
        echo 'Error en el SQl Periodos...<br><br>' . $SQL;
        die;
    }

    return $Periodos->fields['id'];
    
}
