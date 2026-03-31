<?php
/**
 * Caso 107381
 * Ivan Dario Quintero Rios <quinteroivan@unbosque.edu.co>
 * Noviembre 21 del 2018
 * Creacion de funcion para docentes
 */

/**
 * Caso Interno 307.
 * Se incluye el archivo adaptador para tener acceso a las funciones basicas de
 * del nuevo sala si la aplicacion se corre en un entorno local o de pruebas
 * se activa la visualizacion de todos los errores de php
 * @modified Dario Gaulteros Castro <castroluisd@unbosque.edu.co>.
 * @since 23 de Abril 2019.
 */
//error_reporting(E_ALL);
//ini_set('display_errors', '1');
set_time_limit(0);
require_once(realpath(dirname(__FILE__) . "/../../../sala/includes/adaptador.php"));
include "../../../sala/esquemaComposer/vendor/autoload.php";

switch ($_REQUEST['action']) {
    case 'Consultarvalores':
        {
            $periodo1 = $_REQUEST['periodo1'];
            $periodo2 = $_REQUEST['periodo2'];

            $sqlestudiantes = "SELECT c.nombrecarrera, eg.nombresestudiantegeneral, " .
                " eg.apellidosestudiantegeneral, eg.numerodocumento, e.semestre, " .
                " e.codigoestudiante, h.codigoperiodo, h.codigosituacioncarreraestudiante," .
                " h.fechahistoricosituacionestudiante FROM historicosituacionestudiante h " .
                " INNER JOIN estudiante e ON (e.codigoestudiante = h.codigoestudiante) " .
                " INNER JOIN situacioncarreraestudiante s ON (e.codigosituacioncarreraestudiante = s.codigosituacioncarreraestudiante) " .
                " INNER JOIN estudiantegeneral eg ON (eg.idestudiantegeneral = e.idestudiantegeneral ) " .
                " INNER JOIN carrera c ON (e.codigocarrera = c.codigocarrera) " .
                " WHERE h.codigosituacioncarreraestudiante = 100     " .
                " and h.codigoperiodo BETWEEN '" . $periodo1 . "' and '" . $periodo2 . "' order by c.nombrecarrera";
            $datos = $db->GetAll($sqlestudiantes);

            $html = "";
            $k = 1;
            foreach ($datos as $estudiante) {
                $codigoestudiante = $estudiante['codigoestudiante'];
                $codigoperiodo = $estudiante['codigoperiodo'];

                $html .= "<tr><td>" . $k . "</td>
                <td>" . $estudiante['nombrecarrera'] . "</td>
                <td>" . $estudiante['nombresestudiantegeneral'] . " " . $estudiante['apellidosestudiantegeneral'] . "</td>
                <td>" . $estudiante['numerodocumento'] . "</td>
                <td>" . $estudiante['semestre'] . "</td>";

                $sqlasignaturasperdidas = "select m.nombremateria, n.codigomateria, n.notadefinitiva  "
                    . "from notahistorico n INNER JOIN materia m ON (n.codigomateria = m.codigomateria) "
                    . "where n.codigoestudiante = '" . $codigoestudiante . "' and n.codigoperiodo = '" . $codigoperiodo . "' and "
                    . "n.notadefinitiva < '3'";
                $materiaperdidas = $db->GetAll($sqlasignaturasperdidas);
                if (count($materiaperdidas)) {
                    $codmaterias = "";
                    $nommaterias = "";
                    $notas = "";
                    $matriculada = "";
                    foreach ($materiaperdidas as $materia) {
                        $codmaterias .= $materia['codigomateria'] . "<br/> ";
                        $nommaterias .= $materia['nombremateria'] . "<br/> ";
                        $notas .= $materia['notadefinitiva'] . "<br/>";

                        $sqldetallematricula = "select count(*) as 'total' from prematricula p "
                            . "INNER JOIN detalleprematricula d ON (p.idprematricula = d.idprematricula ) "
                            . "where p.codigoestudiante = '" . $codigoestudiante . "' "
                            . "and d.codigomateria = '" . $materia['codigomateria'] . "' "
                            . "and d.codigoestadodetalleprematricula = '30'";
                        $totalveces = $db->GetRow($sqldetallematricula);
                        $matriculada .= $totalveces['total'] . "<br/>";
                    }
                    $html .= "<td>" . $codmaterias . "</td>"
                        . "<td>" . $nommaterias . "</td>"
                        . "<td>" . $notas . "</td>"
                        . "<td>" . $matriculada . "</td>"
                        . "<td>" . $codigoperiodo . "</td>";
                } else {
                    $html .= "<td>0</td><td>Sin materias asociadas</td><td>0</td><td>0</td><td>" . $codigoperiodo . "</td>";
                }
                $html .= "</tr>";
                $k++;
            }
            echo $html;
        }
        break;

    case 'ConsultarPlanEstudio':
        {
            $periodo = $_REQUEST['periodo1'];

            $sql_planes = "SELECT c.codigocarrera, c.nombrecarrera, ps.nombreplanestudio, ps.idplanestudio " .
                " FROM planestudio ps " .
                " INNER JOIN carrera c ON (ps.codigocarrera = c.codigocarrera) " .
                " WHERE ps.codigoestadoplanestudio = 100 " .
                " AND c.codigomodalidadacademica = '200'";

            $planes = $db->GetAll($sql_planes);
            $html = "";
            $i = 1;
            foreach ($planes as $plan) {
                $materiasplan = "SELECT m.codigomateria, m.nombremateria, " .
                    " m.numerocreditos, tm.nombretipomateria, dps.semestredetalleplanestudio " .
                    " FROM detalleplanestudio dps " .
                    " INNER JOIN materia m ON (dps.codigomateria = m.codigomateria) " .
                    " INNER JOIN tipomateria tm ON (dps.codigotipomateria = tm.codigotipomateria) " .
                    " WHERE dps.idplanestudio = '" . $plan['idplanestudio'] . "' ORDER BY dps.semestredetalleplanestudio";

                $materias = $db->GetAll($materiasplan);
                $html_materia = "";
                $m = 1;
                foreach ($materias as $materia) {
                    $html_materia .= "<tr>";
                    $html_materia .= "<td>" . $materia['codigomateria'] . "</td>";
                    $html_materia .= "<td>" . $materia['nombremateria'] . "</td>";
                    $html_materia .= "<td>" . $materia['nombretipomateria'] . "</td>";

                    $sqlpadre = "SELECT c.codigocarrera, c.nombrecarrera FROM materia m " .
                        " INNER JOIN carrera c ON (m.codigocarrera = c.codigocarrera) " .
                        " WHERE m.codigomateria = '" . $materia['codigomateria'] . "'";
                    $padre = $db->GetRow($sqlpadre);

                    $html_materia .= "<td>" . $padre['codigocarrera'] . "</td>";
                    $html_materia .= "<td>" . $padre['nombrecarrera'] . "</td>";
                    $html_materia .= "<td>" . $materia['semestredetalleplanestudio'] . "</td>";

                    $sqlmatriculados = "SELECT SUM(matriculadosgrupo) AS total " .
                        " FROM  grupo g " .
                        " WHERE g.codigomateria = '" . $materia['codigomateria'] . "' AND g.codigoperiodo= '" . $periodo . "'";
                    $matriculados = $db->GetRow($sqlmatriculados);
                    if ($matriculados['total'] == "") {
                        $matriculados['total'] = 0;
                    }

                    $html_materia .= "<td>" . $matriculados['total'] . "</td>";

                    $sqperdidascorte = "SELECT dn.idcorte, COUNT(dn.idcorte) as perdidas " .
                        " FROM grupo g " .
                        " JOIN detallenota dn ON (g.idgrupo = dn.idgrupo) " .
                        " WHERE g.codigomateria = '" . $materia['codigomateria'] . "' " .
                        " AND g.codigoperiodo = '" . $periodo . "' " .
                        " AND g.matriculadosgrupo > '0' " .
                        " AND dn.nota < '3.0' " .
                        " AND dn.codigoestado = '100' " .
                        " GROUP BY dn.idcorte ORDER BY dn.idcorte";
                    $totalcorte = $db->GetAll($sqperdidascorte);
                    $corte1 = "0";
                    $c1 = "0";
                    $corte2 = "0";
                    $c2 = "0";
                    $corte3 = "0";
                    $c3 = "0";

                    $r = 0;
                    foreach ($totalcorte as $totales) {
                        if ($c1 == "0") {
                            $c1 = $totales['idcorte'];
                            $corte1 = $totales['perdidas'];
                        }

                        if ($c1 <> $totales['idcorte'] && $c2 == "0" && $c3 == "0") {
                            $c2 == $totales['idcorte'];
                            $corte2 = $totales['perdidas'];
                        }
                        if ($c2 <> $totales['idcorte'] && $c3 == "0") {
                            $c3 == $totales['idcorte'];
                            $corte3 = $totales['perdidas'];
                        }
                    }//forech

                    if ($matriculados['total'] == 0) {
                        $porcentaje1 = "0";
                        $porcentaje2 = "0";
                        $porcentaje3 = "0";
                    } else {
                        $porcentaje1 = number_format((($corte1 * 100) / $matriculados['total']), 2);
                        $porcentaje2 = number_format((($corte2 * 100) / $matriculados['total']), 2);
                        $porcentaje3 = number_format((($corte3 * 100) / $matriculados['total']), 2);
                    }

                    $html_materia .= "<td>" . $corte1 . "</td>";
                    $html_materia .= "<td>" . $porcentaje1 . "</td>";
                    $html_materia .= "<td>" . $corte2 . "</td>";
                    $html_materia .= "<td>" . $porcentaje2 . "</td>";
                    $html_materia .= "<td>" . $corte3 . "</td>";
                    $html_materia .= "<td>" . $porcentaje3 . "</td>";

                    $sqlnotafinal = "SELECT COUNT(*) as total FROM notahistorico nh " .
                        " WHERE nh.codigomateria = '" . $materia['codigomateria'] . "' AND " .
                        " nh.codigoperiodo = '" . $periodo . "' AND nh.notadefinitiva < '3.0'";

                    $notafinal = $db->GetRow($sqlnotafinal);

                    if ($matriculados['total'] == 0) {
                        $porcentaje4 = "0";
                    } else {
                        $porcentaje4 = number_format((($notafinal['total'] * 100) / $matriculados['total']), 2);
                    }

                    $html_materia .= "<td>" . $notafinal['total'] . "</td>";
                    $html_materia .= "<td>" . $porcentaje4 . "</td>";
                    $html_materia .= "</tr>";
                    $m++;
                }

                $html .= "<tr>";
                $html .= "<td rowspan='" . $m . "'>" . $i . "</td>";
                $html .= "<td rowspan='" . $m . "'>" . $plan['codigocarrera'] . "</td>";
                $html .= "<td rowspan='" . $m . "'>" . $plan['nombrecarrera'] . "</td>";
                $html .= "<td rowspan='" . $m . "'>" . $plan['nombreplanestudio'] . "</td>";
                $html .= "</tr>";
                $html .= $html_materia;
                $i++;
            }
            echo $html;
        }
        break;
    case 'ConsultarPerdidaCorte':
        {
            try {
                $periodo = $_REQUEST['periodo1'];
                $modalidad = $_REQUEST['modalidad'];
                $carrera = $_REQUEST['carrera'];
                $nombrecarrera = $_REQUEST['nombrecarrera'];
                $validar = 0;
                $departa = array(144, 146, 485, 150, 782, 491, 152, 417, 6, 492, 7, 157, 781, 486, 487, 151);
                if (!empty($carrera)) {
                    if ($carrera <> 1) {
                        $busqueda = strpos($nombrecarrera, 'DEPARTAMENTO');
                        if ($busqueda !== false) {
                            //si es un departamento.
                            $uniondepartamentos = "SELECT DISTINCT dp.idgrupo, g.nombregrupo, c.codigocarrera AS 'codigocarrera', " .
                                " c.nombrecarrera, dp.codigomateria, m.nombremateria, m.notaminimaaprobatoria, " .
                                " CONCAT(d.apellidodocente,' ',d.nombredocente) as NombresDocente" .
                                " FROM prematricula pm  " .
                                " INNER JOIN detalleprematricula dp ON (pm.idprematricula = dp.idprematricula) " .
                                " INNER JOIN materia m ON (dp.codigomateria = m.codigomateria) " .
                                " INNER JOIN carrera c on (m.codigocarrera = c.codigocarrera) " .
                                " INNER JOIN grupo g ON (dp.idgrupo = g.idgrupo) " .
                                " INNER JOIN docente d ON (g.numerodocumento = d.numerodocumento) " .
                                " INNER JOIN estudiante e ON (pm.codigoestudiante = e.codigoestudiante) " .
                                " INNER JOIN jornadacarrera jc ON (e.codigocarrera = jc.codigocarrera) " .
                                " INNER JOIN jornada j ON (jc.codigojornada = j.codigojornada)" .
                                " WHERE pm.codigoperiodo = " . $periodo . " " .
                                " AND dp.codigoestadodetalleprematricula = 30 " .
                                " AND m.codigocarrera IN (" . $carrera . ") ";
                            $validar = 1;
                            $sqlcarrerasmaterias = "";

                        } else {
                            //si es una carrera diferentes a un departmaneto
                            $consultacarrera = " AND e.codigocarrera = '" . $carrera . "' ";
                            $uniondepartamentos = "";
                        }

                    } else {
                        //si consulta todas los programas
                        $consultacarrera = "";
                        $departamentos = "144, 146, 485, 150, 782, 491, 152, 417,  6,  492,  7, 157, 781, 486, 487, 151";
                        $uniondepartamentos = " 
                    UNION SELECT DISTINCT " .
                            "c.codigocarrera AS 'codigocarrera'," .
                            "c.nombrecarrera," .
                            "dp.codigomateria," .
                            "m.nombremateria," .
                            "m.notaminimaaprobatoria," .
                            "dp.idgrupo," .
                            "g.nombregrupo," .
                            "CONCAT(d.apellidodocente, ' ', d.nombredocente) as NombresDocente" .

                            " FROM prematricula pm  " .
                            "INNER JOIN detalleprematricula dp ON (pm.idprematricula = dp.idprematricula) " .
                            "INNER JOIN materia m ON (dp.codigomateria = m.codigomateria) " .
                            "INNER JOIN carrera c ON (m.codigocarrera = c.codigocarrera) " .
                            "INNER JOIN grupo g ON (dp.idgrupo = g.idgrupo)" .
                            "INNER JOIN docente d ON (g.numerodocumento = d.numerodocumento)" .
                            "INNER JOIN estudiante e ON (pm.codigoestudiante = e.codigoestudiante)" .
                            "INNER JOIN jornadacarrera jc ON (e.codigocarrera = jc.codigocarrera)" .
                            "INNER JOIN jornada j ON (jc.codigojornada = j.codigojornada)" .
                            "WHERE pm.codigoperiodo = " . $periodo . " " .
                            "AND dp.codigoestadodetalleprematricula = 30 " .
                            "AND m.codigocarrera in (" . $departamentos . ")";
                    }
                } else {
                    //si es una carrera vacia
                    $consultacarrera = "";
                }

                $k = 1;
                $html = "";
                if ($validar == 0) {
                    //Consulta el programa académico, materia para un periodo y una modalidad
                    $sqlcarrerasmaterias = "SELECT DISTINCT " .
                        " e.codigocarrera, " .
                        " c.nombrecarrera, dp.codigomateria, m.nombremateria, m.notaminimaaprobatoria, dp.idgrupo, g.nombregrupo, " .
                        " CONCAT(d.apellidodocente,' ',d.nombredocente) as NombresDocente" .
                        " FROM prematricula pm  " .
                        " INNER JOIN detalleprematricula dp ON ( pm.idprematricula = dp.idprematricula) " .
                        " INNER JOIN estudiante e ON (pm.codigoestudiante = e.codigoestudiante) " .
                        " INNER JOIN carrera c ON (e.codigocarrera = c.codigocarrera) " .
                        " INNER JOIN materia m ON (dp.codigomateria = m.codigomateria) " .
                        " INNER JOIN grupo g ON (dp.idgrupo = g.idgrupo) " .
                        " INNER JOIN docente d ON (g.numerodocumento = d.numerodocumento) " .
                        " INNER JOIN jornadacarrera jc ON (e.codigocarrera = jc.codigocarrera) " .
                        " INNER JOIN jornada j ON (jc.codigojornada = j.codigojornada) " .
                        " WHERE pm.codigoperiodo = " . $periodo . " " .
                        " AND dp.codigoestadodetalleprematricula = 30 " .
                        " AND c.codigocarrera not in (13, 1187) " .
                        " AND c.codigomodalidadacademica = " . $modalidad . "  " . $consultacarrera . " ";
                }
                $sqlcarrerasmaterias .= $uniondepartamentos . " ORDER BY nombrecarrera";
                $MateriasCarreras = $db->GetAll($sqlcarrerasmaterias);

                $tmp = array();
                $l = 0;
                $d = 0;
                $contadorGrupos = 0;
                $contador = 0;
                foreach ($MateriasCarreras as $datos) {


                    $querymateria = "SELECT " .
                        " m.codigotipomateria, " .
                        " tm.nombretipomateria, " .
                        " c.codigocarrera, " .
                        " c.nombrecarrera, " .
                        " dpe.semestredetalleplanestudio, " .
                        " pe.nombreplanestudio, " .
                        " m.numerocreditos " .
                        " FROM " .
                        " materia m " .
                        " INNER JOIN tipomateria tm ON (m.codigotipomateria = tm.codigotipomateria) " .
                        " INNER JOIN carrera c ON (m.codigocarrera = c.codigocarrera) " .
                        " LEFT JOIN detalleplanestudio dpe ON (m.codigomateria = dpe.codigomateria) " .
                        " LEFT JOIN planestudio pe ON (dpe.idplanestudio = pe.idplanestudio) " .
                        " WHERE " .
                        " m.codigomateria = " . $datos['codigomateria'] . " " .
                        " GROUP BY m.codigomateria";

                    $tipomateria = $db->GetRow($querymateria);

                    $validarcarreras = "";
                    $sqlnombrecarrera = "SELECT nombrecarrera FROM carrera WHERE codigocarrera = " . $datos['codigocarrera'] . " ";
                    $nombreprograma = $db->GetRow($sqlnombrecarrera);
                    $nombreprograma = $nombreprograma['nombrecarrera'];
                    $validarcarreras = $datos['codigocarrera'];

                    #obtiene datos de la materia
                    $datosMateria = obtenerDatosMateria($db, $datos['codigomateria']);
                    $datosJornada = obtenerDatosJornada($db, $datos['codigocarrera']);
                    if ($tipomateria['codigotipomateria'] == 4) {
                        #obtiene plan de estudio por carrera y materia electiva
                        $tipomateria = obtenerPlanEstudioElectiva($db, $datos['codigomateria'], $datos['codigocarrera']);
                    }

                    $planEstudio = $tipomateria['nombreplanestudio'];
                    if (is_null($tipomateria['nombreplanestudio'])) {
                        $planEstudio = "Sin plan de estudio";
                    }
                    $semestreplan = $tipomateria['semestredetalleplanestudio'];
                    if (is_null($tipomateria['semestredetalleplanestudio'])) {
                        $semestreplan = 0;
                    }

                    $html .= "<tr>";
                    $html .= "<td>" . $k . "</td>";
                    $html .= "<td>" . $periodo . "</td>";
                    $html .= "<td>" . $datos['codigocarrera'] . "</td>";
                    $html .= "<td>" . $nombreprograma . "</td>";
                    $html .= "<td>" . $planEstudio . "</td>";
                    $html .= "<td>" . $datos['codigomateria'] . "</td>";
                    $html .= "<td>" . $datos['nombremateria'] . "</td>";
                    $html .= "<td>" . @$datosMateria['nombretipomateria'] . "</td>";
                    $html .= "<td>" . @$datosMateria['numerocreditos'] . "</td>";
                    $html .= "<td>" . $semestreplan . "</td>";
                    $html .= "<td>" . @$datosMateria['codigocarrera'] . "</td>";
                    $html .= "<td>" . @$datosMateria['nombrecarrera'] . "</td>";
                    $html .= "<td>" . $datos['idgrupo'] . "</td>";
                    $html .= "<td>" . $datos['nombregrupo'] . "</td>";
                    $html .= "<td>" . $datos['NombresDocente'] . "</td>";
                    $html .= "<td>" . @$datosJornada['nombrejornada'] . "</td>";

                    $contador = 0;
                    $depart = array(144, 146, 485, 150, 782, 491, 152, 417, 6, 492, 7, 157, 781, 486, 487, 151);
                    while (list(, $val) = each($depart)) {
                        if ($val == $validarcarreras) {
                            $sqlmatriculados = "select count(*) as 'matriculados', dp.idgrupo, e.codigocarrera " .
                                " FROM detalleprematricula dp " .
                                " INNER JOIN prematricula pm ON (dp.idprematricula = pm.idprematricula) " .
                                " INNER JOIN estudiante e ON (pm.codigoestudiante = e.codigoestudiante) " .
                                " INNER JOIN historicosituacionestudiante h on e.codigoestudiante = h.codigoestudiante " .
                                " where dp.codigomateria = " . $datos['codigomateria'] . " " .
                                " and pm.codigoperiodo = " . $periodo . " " .
                                " AND dp.idgrupo = " . $datos['idgrupo'] . " " .
                                " AND dp.codigoestadodetalleprematricula = 30 " .
                                " AND h.idhistoricosituacionestudiante in (select MAX(idhistoricosituacionestudiante)
                                           from historicosituacionestudiante hse1
                                           where e.codigoestudiante = hse1.codigoestudiante
                                             AND hse1.codigosituacioncarreraestudiante IN (200, 300, 301))"; //Prueba Académica, Normal y Admitido.
                            $contador = 1;
                        }
                    }
                    if ($contador == 0) {
                        //Consulta el total de estdiantes matriculados de un grupo y materia especifica de acuerdo al periodo.
                        $sqlmatriculados = "SELECT COUNT(*) AS 'matriculados', dp.idgrupo, e.codigocarrera, " .
                            " (SELECT COUNT(*) FROM logdetalleprematricula
                        WHERE
			idgrupo = dp.idgrupo
                        AND codigomateria = dp.codigomateria
                        AND codigoestadodetalleprematricula = 22) as retirados " .
                            " FROM detalleprematricula dp " .
                            " INNER JOIN prematricula pm ON (dp.idprematricula = pm.idprematricula) " .
                            " INNER JOIN estudiante e ON (pm.codigoestudiante = e.codigoestudiante) " .
                            " INNER JOIN historicosituacionestudiante h on e.codigoestudiante = h.codigoestudiante " .
                            " where dp.codigomateria = " . $datos['codigomateria'] . " " .
                            " and pm.codigoperiodo = " . $periodo . " " .
                            " AND dp.idgrupo = " . $datos['idgrupo'] . " " .
                            " AND dp.codigoestadodetalleprematricula in (30,22) " .
                            " AND h.idhistoricosituacionestudiante in (select MAX(idhistoricosituacionestudiante)
                                             from historicosituacionestudiante hse1
                                             where e.codigoestudiante = hse1.codigoestudiante
                                               AND hse1.codigosituacioncarreraestudiante IN (200, 300, 301))" .   //Prueba Académica, Normal y Admitido.
                            " AND e.codigocarrera in (" . $validarcarreras . ") ";

                    }

                    $matriculados = $db->GetRow($sqlmatriculados);

                    $html .= "<td><p><a  href= '#' id=" . $matriculados["idgrupo"] . "  onclick='totalMatriculados(" . $matriculados["idgrupo"] . "," . $matriculados["codigocarrera"] . "," . $periodo . "," . $datos['codigomateria'] . ")'>
                <span>" . $matriculados['matriculados'] . "</span></a></p></td>";

                    $totalRetiro = estudiantesMateriasRetiradas($db, $periodo, $datos['idgrupo'], $datos['codigomateria'], $validarcarreras, $contador);

                    if ($totalRetiro['Retiradas'] == 0) {
                        $html .= "<td>" . $totalRetiro['Retiradas'] . "</td>";
                    } else {
                        $html .= "<td><p><a  href= '#' id=" . $matriculados["idgrupo"] . "  onclick=\"retiraronMateria(" . $periodo . "," . $datos['idgrupo'] . "," . $datos['codigomateria'] . ",'" . $validarcarreras . "'," . $contador . ")\">
                <span>" . $totalRetiro['Retiradas'] . "</span></a></p></td>";
                    }

                    #saber si una carrera es nocturna
                    $queryMateriaNocturna = "select codigojornada from jornadacarrera where codigocarrera = " . $datos['codigocarrera'];
                    $materiaNocturna = $db->GetRow($queryMateriaNocturna);
                    $queryCodigoDiurnoMateria = "";
                    $codigoDiurnoMateria = "";
                    //consulta de la cantidad de cortes por materia
                    $sqlCortes = "SELECT c.numerocorte, c.porcentajecorte " .
                        " FROM corte c " .
                        "WHERE c.codigoperiodo = " . $periodo . " " .
                        " AND c.codigomateria = " . $datos['codigomateria'] . " ";
                    $cortes = $db->GetAll($sqlCortes);

                    //si la materia no tiene cortes creados para ese periodo
                    if (count($cortes) == 0) {
                        #si el codigo de la jornada para el programa es 02 (nocturna) realiza la busqueda del codigo diurno para ubicar el corte
                        if ($materiaNocturna['codigojornada'] == '02') {
                            $queryCodigoDiurnoMateria = "select codigoDiurno from carrera where codigocarrera = " . $datosMateria['codigocarrera'];
                            $codDiurno = $db->GetRow($queryCodigoDiurnoMateria);

                            $codigoDiurnoMateria = " AND c.codigocarrera = " . $codDiurno['codigoDiurno'] . "";
                        } else {
                            $codigoDiurnoMateria = " AND c.codigocarrera = " . $datosMateria['codigocarrera'] . "";
                        }
                        //se consulta el corte generico de la carrera para el periodo seleccionado
                        $sqlCortes = "SELECT c.numerocorte, c.porcentajecorte " .
                            " FROM corte c WHERE " .
                            " c.codigoperiodo = " . $periodo . " " .
                            " AND c.codigomateria = 1 " . $codigoDiurnoMateria;
                        $cortes = $db->GetAll($sqlCortes);
                    }

                    $contadorcortes = 0;
                    //Se confirma si existe cortes para la materias definida, sí no existen se usa la variable generica
                    if (count($cortes) == 0) {
                        $cortes = array();
                        $cortes[0]['numerocorte'] = '1';
                        $cortes[0]['porcentajecorte'] = '30';
                        $cortes[1]['numerocorte'] = '2';
                        $cortes[1]['porcentajecorte'] = '30';
                        $cortes[2]['numerocorte'] = '3';
                        $cortes[2]['porcentajecorte'] = '40';
                    } else {
                        foreach ($cortes as $listacortes) {
                            //Consulta el total de estudiantes que perdieron la materia de un corte especifico de acuerdo al grupo y el periodo.
                            $sqlperidieroncorte = "SELECT count(dtn.codigoestudiante) AS perdidas, dtn.idgrupo, cor.numerocorte, e.codigocarrera, " .
                                " (SELECT 
                            ea.estrategiaasignatura
                            FROM estrategiaasignatura ea 
                            WHERE ea.codigoperiodo = " . $db->qstr($periodo) . "
                            AND ea.codigomateria = " . $db->qstr($datos['codigomateria']) . "
                            AND ea.idgrupo = " . $datos['idgrupo'] . "
                            AND ea.numerocorte = " . $db->qstr($listacortes['numerocorte']) . "
                            AND ea.codigoestado = 100 ) as estrategiaasignatura " .
                                " FROM detallenota dtn " .
                                " INNER JOIN corte cor ON cor.idcorte = dtn.idcorte " .
                                " INNER JOIN estudiante e on dtn.codigoestudiante = e.codigoestudiante " .
                                " INNER JOIN historicosituacionestudiante hse on e.codigoestudiante = hse.codigoestudiante" .
                                " WHERE dtn.nota < " . $db->qstr($datos['notaminimaaprobatoria']) . " " .
                                " AND cor.numerocorte = " . $db->qstr($listacortes['numerocorte']) . " " .
                                " AND cor.codigoperiodo = " . $db->qstr($periodo) . " " .
                                " AND dtn.codigomateria = " . $db->qstr($datos['codigomateria']) . " " .
                                " AND dtn.idgrupo = " . $datos['idgrupo'] . " " .
                                " AND e.codigocarrera IN (" . $validarcarreras . ") " .
                                " AND hse.idhistoricosituacionestudiante in (select MAX(idhistoricosituacionestudiante)
                                             from historicosituacionestudiante hse1
                                             where e.codigoestudiante = hse1.codigoestudiante
                                               AND hse1.codigosituacioncarreraestudiante NOT IN (108));";

                            /*
                            * @modified Vega Gabriel <vegagabriel@unbosque.edu.do>.
                            * Se agrega esta validacion para cuando se seleccione depto tambien muestre las cantidades de estudiantes que hayan perdido en cada corte
                            * @since Diciembre 27, 2018
                            */
                            $busqueda = strpos($nombrecarrera, 'DEPARTAMENTO');
                            if ($busqueda !== false) {
                                //Consulta el total de estudiantes de un Departamento que perdieron la materia de un corte especifico de acuerdo al grupo y el periodo.
                                $sqlperidieroncorte = "SELECT count(dtn.codigoestudiante) AS perdidas, dtn.idgrupo, cor.numerocorte, e.codigocarrera, " .
                                    " (SELECT 
                            ea.estrategiaasignatura
                            FROM estrategiaasignatura ea 
                            WHERE ea.codigoperiodo = " . $db->qstr($periodo) . "
                            AND ea.codigomateria = " . $db->qstr($datos['codigomateria']) . "
                            AND ea.idgrupo = " . $datos['idgrupo'] . "
                            AND ea.numerocorte = " . $db->qstr($listacortes['numerocorte']) . "
                            AND ea.codigoestado = 100 ) as estrategiaasignatura " .
                                    " FROM detallenota dtn " .
                                    " INNER JOIN corte cor ON cor.idcorte = dtn.idcorte " .
                                    " INNER JOIN estudiante e on dtn.codigoestudiante = e.codigoestudiante " .
                                    " INNER JOIN historicosituacionestudiante hse on e.codigoestudiante = hse.codigoestudiante" .
                                    " WHERE dtn.nota < " . $db->qstr($datos['notaminimaaprobatoria']) . " " .
                                    " AND cor.numerocorte = " . $db->qstr($listacortes['numerocorte']) . " " .
                                    " AND cor.codigoperiodo = " . $db->qstr($periodo) . " " .
                                    " AND dtn.codigomateria = " . $db->qstr($datos['codigomateria']) . " " .
                                    " AND dtn.idgrupo = " . $datos['idgrupo'] .
                                    " AND hse.idhistoricosituacionestudiante in (select MAX(idhistoricosituacionestudiante)
                                             from historicosituacionestudiante hse1
                                             where e.codigoestudiante = hse1.codigoestudiante
                                               AND hse1.codigoperiodo = " . $db->qstr($periodo) . "
                                               AND hse1.codigosituacioncarreraestudiante NOT IN (108));";
                            }
                            $perdieroncorte = $db->GetRow($sqlperidieroncorte);


                            if ($perdieroncorte['perdidas'] == 0) {
                                $html .= "<td>" . $perdieroncorte['perdidas'] . "</td>";
                            } else {

                                $html .= "<td><p><a  href= '#' id=" . $perdieroncorte["idgrupo"] . "  onclick=\"perdieronCorte(" . $perdieroncorte["idgrupo"] . "," . $perdieroncorte["numerocorte"] . ",'" . $validarcarreras . "')\">
                            <span>" . $perdieroncorte['perdidas'] . "</span></a></p></td>";
                            }

                            $html .= "<td>" . $listacortes['porcentajecorte'] . "%</td>";

                            //calculo del porcentaje de la nota redondeando a dos cifras despues del punto
                            $porcentajecorte1 = ($matriculados['matriculados'] > 0) ?
                                round((($perdieroncorte['perdidas'] * 100) / $matriculados['matriculados']), 2)
                                : 0;
                            $porcentajecorte = str_replace(".", ",", $porcentajecorte1);

                            if ($porcentajecorte <= 14) {
                                $color = '#98FB98';
                            }//Verde
                            if ($porcentajecorte >= 15 and $porcentajecorte <= 20) {
                                $color = '#FFFF84';
                            }//Amarillo
                            if ($porcentajecorte >= 21 and $porcentajecorte <= 49) {
                                $color = '#FFA04A';
                            }//Naranja
                            if ($porcentajecorte >= 50) {
                                $color = '#FF7373';
                            }//Rojo


                            $html .= "<td bgcolor= $color>" . $porcentajecorte . "%</td>";
                            $html .= "<td>" . $perdieroncorte['estrategiaasignatura'] . "</td>";

                            $contadorcortes++;
                        }//cortes
                    }//else

                    //si la materias notiene cortes ni genericos se mostrará los espacios vacios segun el caso
                    switch ($contadorcortes) {
                        //sin cortes
                        case '0':
                            {
                                $html .= "<td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td>";
                            }
                            break;
                        //sin 2° y 3° corte
                        case '1':
                            {
                                $html .= "<td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td>";
                            }
                            break;
                        //sin 3° corte
                        case '2':
                            {
                                $html .= "<td>-</td><td>-</td><td>-</td><td>-</td>";
                            }
                            break;
                    }

                    $valornotafinal = 0;
                    $depart = array(144, 146, 485, 150, 782, 491, 152, 417, 6, 492, 7, 157, 781, 486, 487, 151);
                    while (list(, $val) = each($depart)) {
                        if ($val == $datos['codigocarrera']) {
                            $sqlnotafinal = "SELECT count(*) AS perdieron " .
                                " FROM notahistorico nh " .
                                " INNER JOIN estudiante e ON (nh.codigoestudiante = e.codigoestudiante) " .
                                " WHERE nh.codigoperiodo = " . $periodo . " " .
                                " AND nh.codigomateria = " . $datos['codigomateria'] . " " .
                                " AND nh.notadefinitiva < '" . $datos['notaminimaaprobatoria'] . "' " .
                                " AND nh.codigoestadonotahistorico = 100 " .
                                " AND nh.idgrupo = " . $datos['idgrupo'] . " ";
                            $valornotafinal = 1;
                        }
                    }
                    if ($valornotafinal == 0) {
                        //consulta de la nota final de la materia para el periodo y la carrera
                        $sqlnotafinal = "SELECT COUNT(*) AS perdieron " .
                            " FROM notahistorico nh " .
                            " INNER JOIN estudiante e ON (nh.codigoestudiante = e.codigoestudiante )" .
                            " WHERE nh.codigoperiodo = " . $periodo . " " .
                            " AND nh.codigomateria = " . $datos['codigomateria'] . " " .
                            " AND nh.notadefinitiva < '" . $datos['notaminimaaprobatoria'] . "' " .
                            " AND e.codigocarrera = " . $datos['codigocarrera'] . "  " .
                            " AND nh.codigoestadonotahistorico = 100 " .
                            " AND nh.idgrupo = " . $datos['idgrupo'] . " ";
                    }

                    $notafinal = $db->GetRow($sqlnotafinal);

                    if (empty($notafinal['perdieron'])) {
                        $notafinal['perdieron'] = 0;
                    }

                    $html .= "<td>" . $notafinal['perdieron'] . "</td>";
                    //calculo del porcentaje de la nota final de la cantidad de usuario que perdieron la materia
                    $porcentajefinal1 = ($matriculados['matriculados'] > 0) ?
                        round((($notafinal['perdieron'] * 100) / $matriculados['matriculados']), 2)
                        : 0;
                    $porcentajefinal = str_replace(".", ",", $porcentajefinal1);

                    #calcular color para porcentaje final
                    if ($porcentajecorte <= 14) {
                        $color = '#98FB98';
                    }//Verde
                    if ($porcentajecorte >= 15 and $porcentajecorte <= 20) {
                        $color = '#FFFF84';
                    }//Amarillo
                    if ($porcentajecorte >= 21 and $porcentajecorte <= 49) {
                        $color = '#FFA04A';
                    }//Naranja
                    if ($porcentajecorte >= 50) {
                        $color = '#FF7373';
                    }//Rojo

                    $html .= "<td style='background-color:$color '>" . $porcentajefinal . "%</td>";

                    $html .= "</tr>";
                    $contadorGrupos++;
                    $d++;
                    $k++;

                    $contador++;

                }

                echo $html;
            } catch (\Exception $e) {
                exit;
            }
        }
        break;

    case'consulta_periodos':
        {
            $queryperiodos = "SELECT codigoperiodo FROM periodo ORDER BY codigoperiodo desc";
            $periodos = $db->GetAll($queryperiodos);

            $html .= "<option value=''>Seleccion</option>";
            foreach ($periodos as $listado) {
                $html .= "<option value='" . $listado['codigoperiodo'] . "'>" . $listado['codigoperiodo'] . "</option>";
            }
            echo $html;
        }
        break;

    case'consulta_modalidad':
        {
            $querymodalidades = "select codigomodalidadacademica, nombremodalidadacademica from " .
                " modalidadacademica where codigomodalidadacademica in (200, 300, 800, 810)";
            $modalidades = $db->GetAll($querymodalidades);

            $html .= "<option value=''>Seleccion</option>";
            foreach ($modalidades as $listado) {
                $html .= "<option value='" . $listado['codigomodalidadacademica'] . "'>" . $listado['nombremodalidadacademica'] . "</option>";
            }
            echo $html;
        }
        break;

    case'consulta_programasacademicos':
        {
            $modalidad = $_REQUEST['modalidad'];
            $periodo = $_REQUEST['periodo'];
            #programas academicos con personas matriculadas
            $queryprogramas = "
select ca.codigocarrera, ca.nombrecarrera from carrera ca
where nombrecarrera like 'DEPARTAMENTO%' 
and fechavencimientocarrera >= NOW() 
AND codigomodalidadacademica = $modalidad
union
select distinct c.codigocarrera, c.nombrecarrera from carrera c
            inner join estudiante e on c.codigocarrera = e.codigocarrera
            inner join ordenpago o on e.codigoestudiante = o.codigoestudiante
            inner join detalleordenpago dop on o.numeroordenpago = dop.numeroordenpago
            inner join prematricula pm on pm.codigoestudiante = e.codigoestudiante
            inner join detalleprematricula d on (pm.idprematricula = d.idprematricula  and d.numeroordenpago = o.numeroordenpago)
    where
          c.codigomodalidadacademica = $modalidad
      and dop.codigoconcepto = 151
      and o.codigoestadoordenpago = 40
      and o.codigoperiodo = $periodo
      and c.fechavencimientocarrera >= NOW()
      and pm.codigoperiodo = $periodo
      and  c.codigocarrera
               not in (30, 39, 74, 138, 2, 12, 79, 3, 868, 4,13)
    order by nombrecarrera asc";
            $programas = $db->GetAll($queryprogramas);

            $html .= "<option value=''>Seleccion</option>";
            foreach ($programas as $listado) {
                $html .= "<option value='" . $listado['codigocarrera'] . "'>" . $listado['nombrecarrera'] . "</option>";
            }
            echo $html;
        }
        break;

    case 'consultardatosdocentes':
        {
            $periodo1 = $_REQUEST['periodo1'];
            $modalidad = $_REQUEST['modalidad'];
            $carrera = $_REQUEST['carrera'];

            if ($carrera <> 1) {
                $sqlcarrrera = "and c.codigocarrera =" . $carrera;
            } else {
                $sqlcarrrera = "";
            }

            $sqldocentes = "SELECT d.nombredocente, d.apellidodocente, d.numerodocumento, c.codigocarrera, " .
                " c.nombrecarrera, m.codigomateria, " .
                " m.nombremateria, g.codigoperiodo FROM grupo g " .
                " INNER JOIN docente d ON (g.numerodocumento = d.numerodocumento) " .
                " INNER JOIN materia m ON (g.codigomateria = m.codigomateria) " .
                " INNER JOIN carrera c ON (m.codigocarrera = c.codigocarrera) " .
                " WHERE g.codigoperiodo = '" . $periodo1 . "' AND g.codigoestadogrupo = 10 " .
                " AND c.codigomodalidadacademica = " . $modalidad . " " . $sqlcarrrera . " GROUP BY codigomateria, " .
                " numerodocumento ORDER BY numerodocumento";
            $datosdocentes = $db->GetAll($sqldocentes);

            $html = "";
            $f = 1;
            foreach ($datosdocentes as $valores) {
                $html .= "<tr><td>" . $f . "</td>";
                $html .= "<td>" . $valores['nombredocente'] . "</td>";
                $html .= "<td>" . $valores['apellidodocente'] . "</td>";
                $html .= "<td>" . $valores['numerodocumento'] . "</td>";
                $html .= "<td>" . $valores['nombrecarrera'] . "</td>";
                $html .= "<td>" . $valores['codigomateria'] . "</td>";
                $html .= "<td>" . $valores['nombremateria'] . "</td>";
                $html .= "<td>" . $periodo1 . "</td>";

                $sqlgrupos = "SELECT g.idgrupo FROM grupo g WHERE "
                    . "g.codigomateria = " . $valores['codigomateria'] . " AND  g.codigoperiodo = " . $periodo1 . " "
                    . "AND g.numerodocumento =" . $valores['numerodocumento'] . " AND g.codigoestadogrupo = 10";
                $listagrupos = $db->GetAll($sqlgrupos);
                $countgrupos = count($listagrupos);

                $idgrupos = "";
                for ($i = 0; $i < $countgrupos; $i++) {
                    if ($i > 0) {
                        $idgrupos .= "," . $listagrupos[$i]['idgrupo'];
                    } else {
                        $idgrupos .= $listagrupos[$i]['idgrupo'];
                    }
                }

                $html .= "<td>" . $countgrupos . "</td>";

                $sqlmatriculados = "SELECT COUNT(*) AS 'matriculados' FROM detalleprematricula " .
                    " WHERE idgrupo IN (" . $idgrupos . ") AND codigoestadodetalleprematricula = 30";

                $matriculados = $db->GetRow($sqlmatriculados);
                $html .= "<td>" . $matriculados['matriculados'] . "</td>";

                /*
                 * @modified Vega Gabriel <vegagabriel@unbosque.edu.do>.
                 * Se incluye la condicional AND idgrupo in (".$idgrupos.") para que no genere porcentajes superiores a 100
                 * @since Agosto 29, 2018
                 */
                $sqlperdida = "SELECT COUNT(*) AS perdieron FROM " .
                    " notahistorico nh " .
                    " INNER JOIN estudiante e on nh.codigoestudiante = e.codigoestudiante " .
                    " WHERE nh.codigoperiodo = " . $periodo1 . " " .
                    " AND nh.codigomateria = " . $valores['codigomateria'] . " " .
                    " AND nh.notadefinitiva < 3 " .
                    " AND idgrupo in (" . $idgrupos . ")  " .
                    " AND nh.codigoestadonotahistorico = 100";
                $perdida = $db->GetRow($sqlperdida);

                $html .= "<td>" . $perdida['perdieron'] . "</td>";
                //calculo del porcentaje de la nota final de la cantidad de usuario que perdieron la materia
                $porcentajefinal1 = round((($perdida['perdieron'] * 100) / $matriculados['matriculados']), 2);
                $porcentajefinal = str_replace(".", ",", $porcentajefinal1);

                $html .= "<td>" . $porcentajefinal . "% </td>";

                $sqlpromedio = "SELECT SUM(notadefinitiva) AS 'suma' FROM notahistorico WHERE " .
                    " idgrupo IN (" . $idgrupos . ") AND codigoestadonotahistorico = 100";

                $datopromedio = $db->GetRow($sqlpromedio);

                $promedio = round(($datopromedio['suma'] / $matriculados['matriculados']), 3);
                $html .= "<td>" . $promedio . "</td>";

                $sqlnotas = "SELECT MAX(notadefinitiva) AS 'max', MIN(notadefinitiva) as 'min' " .
                    " FROM notahistorico WHERE idgrupo IN (" . $idgrupos . ") AND codigoestadonotahistorico = 100";
                $notas = $db->GetRow($sqlnotas);
                /*
                 * @modified Ivan Quintero <coordinadorsisinfo@unbosque.edu.do>.
                 * Se incluye la formula de la desviacion estandar con la varianza
                 * @since Septiembre 17, 2018
                 */

                $sqllistanotas = "SELECT notadefinitiva FROM notahistorico WHERE idgrupo IN (" . $idgrupos . ") " .
                    " AND codigoestadonotahistorico = 100";
                $listanotas = $db->GetAll($sqllistanotas);

                $desviacion = desviacion($listanotas, $promedio);

                $html .= "<td>" . round($desviacion, 3) . "</td>";
                /*End*/
                if (empty($notas['max'])) {
                    $notas['max'] = 0;
                }
                if (empty($notas['min'])) {
                    $notas['min'] = 0;
                }

                $html .= "<td>" . $notas['max'] . "</td><td>" . $notas['min'] . "</td>";
                $html .= "</tr>";

                $f++;
            }

            echo $html;

        }
        break;

    case 'ConsultarMatriculados' :
        {
            $idgrupo = $_REQUEST['idgrupo'];
            $carrera = $_REQUEST['carrera'];
            $periodo = $_REQUEST['periodo'];
            $materia = $_REQUEST['materia'];

            $SQL_matriculados = "SELECT " .
                " ege.numerodocumento, " .
                " CONCAT(ege.apellidosestudiantegeneral,' ',ege.nombresestudiantegeneral) AS 'NombreCompleto', " .
                " ege.emailestudiantegeneral AS 'CorreoPersonal', " .
                " CONCAT(u.usuario,'@unbosque.edu.co') AS 'CorreoInstitucional', " .
                " c.nombrecarrera, " .
                " pm.semestreprematricula, " .
                " ege.telefonoresidenciaestudiantegeneral, " .
                " sce.nombresituacioncarreraestudiante, " .
                "  edp.nombreestadodetalleprematricula " .
                " FROM " .
                " detalleprematricula dp " .
                " INNER JOIN prematricula pm ON (dp.idprematricula = pm.idprematricula) " .
                " INNER JOIN estudiante e ON (pm.codigoestudiante = e.codigoestudiante) " .
                " INNER JOIN estudiantegeneral ege ON (e.idestudiantegeneral = ege.idestudiantegeneral) " .
                " LEFT  JOIN usuario u ON (ege.numerodocumento = u.numerodocumento) " .
                " INNER JOIN carrera c ON (e.codigocarrera = c.codigocarrera) " .
                " INNER JOIN situacioncarreraestudiante sce ON (e.codigosituacioncarreraestudiante = sce.codigosituacioncarreraestudiante) " .
                " INNER JOIN historicosituacionestudiante h on e.codigoestudiante = h.codigoestudiante" .
                " INNER JOIN estadodetalleprematricula edp on dp.codigoestadodetalleprematricula = edp.codigoestadodetalleprematricula" .
                " WHERE " .
                " pm.codigoperiodo = $periodo" .
                " and dp.codigomateria = $materia" .
                " and dp.idgrupo = '" . $idgrupo . "' " .
                " AND dp.codigoestadodetalleprematricula in (30,22) " .
                " AND h.idhistoricosituacionestudiante in (select MAX(idhistoricosituacionestudiante)
                                           from historicosituacionestudiante hse1
                                           where e.codigoestudiante = hse1.codigoestudiante
                                             AND hse1.codigosituacioncarreraestudiante IN (200, 300, 301))" .
                " AND u.codigotipousuario = 600 " .
                " AND u.codigoestadousuario = 100 " .
                " AND e.codigocarrera =  '" . $carrera . "' ";

            $datosMatriculados = $db->GetAll($SQL_matriculados);

            $html1 = "";
            $h = 1;

            $html1 .= '<div class="table-responsive" id="tabla5">                
                <table id="dataR5" class="table table-hover">
                    <thead>
                        <tr>
                            <th>N°</th>
                            <th>Número Documento</th>
                            <th>Nombre Completo</th>
                            <th>Correo Personal</th>
                            <th>Correo Institucional</th>
                            <th>Programa Académico</th>                            
                            <th>Semestre</th>
                            <th>Teléfono</th>
                            <th>Situación Estudiante</th>
                            <th>Estado det. prematricula</th>
                        </tr>
                        
                    </thead>                    
                    <tbody id="dataReporte5">
                    </tbody>';
            foreach ($datosMatriculados as $listaMatriculados) {
                $html1 .= "<tr>";
                $html1 .= "<td>" . $h . "</td>";
                $html1 .= "<td>" . $listaMatriculados['numerodocumento'] . "</td>";
                $html1 .= "<td>" . $listaMatriculados['NombreCompleto'] . "</td>";
                $html1 .= "<td>" . $listaMatriculados['CorreoPersonal'] . "</td>";
                $html1 .= "<td>" . $listaMatriculados['CorreoInstitucional'] . "</td>";
                $html1 .= "<td>" . $listaMatriculados['nombrecarrera'] . "</td>";
                $html1 .= "<td>" . $listaMatriculados['semestreprematricula'] . "</td>";
                $html1 .= "<td>" . $listaMatriculados['telefonoresidenciaestudiantegeneral'] . "</td>";
                $html1 .= "<td>" . $listaMatriculados['nombresituacioncarreraestudiante'] . "</td>";
                $html1 .= "<td>" . $listaMatriculados['nombreestadodetalleprematricula'] . "</td>";
                $html1 .= "</tr>";
                $h++;
            }
            $html1 .= '<div class="col-md-2" id="exportarbtn5">
                        <button class="btn btn-fill-green-XL" type="button" id="exportExcel5">
                            Exportar a Excel
                        </button>
                        <form id="formInforme" method="post" action="../../../assets/lib/ficheroExcel.php">
                            <input  id="datos_a_enviar" type="hidden" name="datos_a_enviar">
                        </form>
                    </div>';
            $html1 .= '</table>        
            </div>';
            echo $html1;

        }
        break;

    case 'ConsultaPerdida':
        {
            $idgrupo = $_REQUEST['idgrupo'];
            $corte = $_REQUEST['corte'];
            $carrera = $_REQUEST['carrera'];
            $SQL_Perdida = "SELECT DISTINCT" .
                " ege.numerodocumento, " .
                " CONCAT(ege.apellidosestudiantegeneral,' ',ege.nombresestudiantegeneral) AS 'NombreCompleto', " .
                " ege.emailestudiantegeneral AS 'CorreoPersonal', " .
                " CONCAT(u.usuario,'@unbosque.edu.co') AS 'CorreoInstitucional', " .
                " c.nombrecarrera, " .
                " p.semestreprematricula, " .
                " ege.telefonoresidenciaestudiantegeneral, " .
                " sce.nombresituacioncarreraestudiante, " .
                "dtn.nota," .
                "m.nombremateria," .
                "cor.numerocorte" .
                " FROM " .
                " detallenota dtn " .
                " INNER JOIN corte cor ON cor.idcorte = dtn.idcorte " .
                " INNER JOIN estudiante e ON dtn.codigoestudiante = e.codigoestudiante " .
                " INNER JOIN estudiantegeneral ege ON (e.idestudiantegeneral = ege.idestudiantegeneral) " .
                " INNER JOIN prematricula p ON (e.codigoestudiante = p.codigoestudiante) " .
                " LEFT  JOIN usuario u ON (ege.numerodocumento = u.numerodocumento) " .
                " INNER JOIN carrera c ON (e.codigocarrera = c.codigocarrera) " .
                " INNER JOIN situacioncarreraestudiante sce ON (e.codigosituacioncarreraestudiante = sce.codigosituacioncarreraestudiante) " .
                "INNER JOIN materia m on dtn.codigomateria = m.codigomateria" .
                " INNER JOIN historicosituacionestudiante hse on e.codigoestudiante = hse.codigoestudiante" .
                " WHERE " .
                " dtn.nota < '3.00' " .
                " AND cor.numerocorte = '" . $corte . "' " .
                " AND dtn.idgrupo = '" . $idgrupo . "' " .
                " AND p.codigoperiodo = cor.codigoperiodo " .
                " AND u.codigotipousuario = 600 " .
                " AND u.codigoestadousuario = 100 " .
                " AND e.codigocarrera IN ($carrera) " .
                "AND hse.idhistoricosituacionestudiante in
                          (
                            select MAX(idhistoricosituacionestudiante) from historicosituacionestudiante hse1
                            where e.codigoestudiante =  hse1.codigoestudiante
                            AND hse1.codigosituacioncarreraestudiante NOT IN (108)
                          );";


            $datosPerdida = $db->GetAll($SQL_Perdida);

            $html2 = "";
            $z = 1;

            $html2 .= '<div class="table-responsive" id="tabla4">                
                <table id="dataR4" class="table table-hover">
                    <thead>
                        <tr>
                            <th>N°</th>
                            <th>Número Documento</th>
                            <th>Nombre Completo</th>
                            <th>Correo Personal</th>
                            <th>Correo Institucional</th>
                            <th>Programa Académico</th>                            
                            <th>Semestre</th>
                            <th>Teléfono</th>
                            <th>Situación Estudiante</th>
                            <th>Nota</th>
                            <th>Materia</th>
                            <th>Corte</th>
                        </tr>
                    </thead>                    
                    <tbody id="dataReporte4">
                    </tbody>';
            foreach ($datosPerdida as $listaPerdidos) {
                $html2 .= "<tr>";
                $html2 .= "<td>" . $z . "</td>";
                $html2 .= "<td>" . $listaPerdidos['numerodocumento'] . "</td>";
                $html2 .= "<td>" . $listaPerdidos['NombreCompleto'] . "</td>";
                $html2 .= "<td>" . $listaPerdidos['CorreoPersonal'] . "</td>";
                $html2 .= "<td>" . $listaPerdidos['CorreoInstitucional'] . "</td>";
                $html2 .= "<td>" . $listaPerdidos['nombrecarrera'] . "</td>";
                $html2 .= "<td>" . $listaPerdidos['semestreprematricula'] . "</td>";
                $html2 .= "<td>" . $listaPerdidos['telefonoresidenciaestudiantegeneral'] . "</td>";
                $html2 .= "<td>" . $listaPerdidos['nombresituacioncarreraestudiante'] . "</td>";
                $html2 .= "<td style='text-align: center'>" . $listaPerdidos['nota'] . "</td>";
                $html2 .= "<td>" . $listaPerdidos['nombremateria'] . "</td>";
                $html2 .= "<td style='text-align: center'>" . $listaPerdidos['numerocorte'] . "</td>";
                $html2 .= "</tr>";
                $z++;
            }
            $html2 .= '<div class="col-md-2" id="exportarbtn4">
                        <button class="btn btn-fill-green-XL" type="button" id="exportExcel4">
                            Exportar a Excel
                        </button>
                        <form id="formInforme" method="post" action="../../../assets/lib/ficheroExcel.php">
                            <input  id="datos_a_enviar" type="hidden" name="datos_a_enviar">
                        </form>
                    </div>';
            $html2 .= '</table>        
            </div>';
            echo $html2;

        }
        break;

    case 'MateriasRetiradas':
        {
            $periodo = $_REQUEST['Periodo'];
            $grupo = $_REQUEST['Grupo'];
            $materia = $_REQUEST['Materia'];
            $carrera = $_REQUEST['Carrera'];
            $contador = $_REQUEST['Contador'];

            $resCancelada = estudiantesMateriasRetiradas($db, $periodo, $grupo, $materia, $carrera, $contador, $datos = 1);


            $html3 = "";
            $y = 1;

            $html3 = '<div class="table-responsive" id="tabla6">                
                <table id="dataR6" class="table table-hover">
                    <thead>
                        <tr>
                            <th>N°</th>
                            <th>Número Documento</th>
                            <th>Nombre Completo</th>
                            <th>Correo Personal</th>
                            <th>Correo Institucional</th>
                            <th>Programa Académico</th>                            
                            <th>Semestre</th>
                            <th>Teléfono</th>
                            <th>Situación Estudiante</th>
                            <th>Estado Materia</th>
                        </tr>
                        
                    </thead>                    
                    <tbody id="dataReporte6">
                    </tbody>';
            foreach ($resCancelada as $listaCanceladas) {
                $html3 .= "<tr>";
                $html3 .= "<td>" . $y . "</td>";
                $html3 .= "<td>" . $listaCanceladas['numerodocumento'] . "</td>";
                $html3 .= "<td>" . $listaCanceladas['NombreCompleto'] . "</td>";
                $html3 .= "<td>" . $listaCanceladas['CorreoPersonal'] . "</td>";
                $html3 .= "<td>" . $listaCanceladas['CorreoInstitucional'] . "</td>";
                $html3 .= "<td>" . $listaCanceladas['nombrecarrera'] . "</td>";
                $html3 .= "<td>" . $listaCanceladas['semestreprematricula'] . "</td>";
                $html3 .= "<td>" . $listaCanceladas['telefonoresidenciaestudiantegeneral'] . "</td>";
                $html3 .= "<td>" . $listaCanceladas['nombresituacioncarreraestudiante'] . "</td>";
                $html3 .= "<td>" . $listaCanceladas['nombreestadodetalleprematricula'] . "</td>";
                $html3 .= "</tr>";
                $y++;
            }
            $html3 .= '<div class="col-md-2" id="exportarbtn6">
                        <button class="btn btn-fill-green-XL" type="button" id="exportExcel6">
                            Exportar a Excel
                        </button>
                        <form id="formInforme" method="post" action="../../../assets/lib/ficheroExcel.php">
                            <input  id="datos_a_enviar" type="hidden" name="datos_a_enviar">
                        </form>
                    </div>';
            $html3 .= '</table>        
            </div>';
            echo $html3;


        }
        break;


}//switch

/*
* @modified Ivan Quintero <coordinadorsisinfo@unbosque.edu.do>.
* Se incluye la formula de la desviacion estandar con la varianza
* @since Septiembre 17, 2018
*/
function desviacion($datos, $promedio)
{
    $media = $promedio;
    $suma2 = 0;
    //Aplicacion de la formula
    for ($i = 0; $i < count($datos); $i++) {
        $suma2 += ($datos[$i][0] - $media) * ($datos[$i][0] - $media);
    }

    $varianza = $suma2 / count($datos);
    $desviacion = sqrt($varianza);

    return $desviacion;
}//function desviacion

//funcion que calcula la cantidad de estudiantes que retiraron la asignatura
//Tambien muestra el detalle de los estudiantes que retiraron la materia.
function estudiantesMateriasRetiradas($db, $periodo, $grupo, $materia, $carrera, $contador, $datos = NULL)
{
    if ($datos == NULL) {
        $parametros = "COUNT(DISTINCT ege.numerodocumento) AS Retiradas ";
        $Agrupar = "";

    } else {
        $parametros = "ege.numerodocumento, " .
            " CONCAT(ege.apellidosestudiantegeneral,' ',ege.nombresestudiantegeneral) AS 'NombreCompleto', " .
            " ege.emailestudiantegeneral AS 'CorreoPersonal', " .
            " CONCAT(u.usuario,'@unbosque.edu.co') AS 'CorreoInstitucional', " .
            " c.nombrecarrera, " .
            " p.semestreprematricula, " .
            " ege.telefonoresidenciaestudiantegeneral, " .
            " sce.nombresituacioncarreraestudiante, " .
            " dp.nombreestadodetalleprematricula ";
        $Agrupar = " GROUP BY e.codigoestudiante ";
    }

    if ($contador == 1) {
        $sqlCarrera = "";
    } else {
        $sqlCarrera = " AND e.codigocarrera IN (" . $carrera . ")";
    }

    $SQL = "SELECT   " . $parametros . " FROM " .
        " prematricula p  " .
        " INNER JOIN logdetalleprematricula l ON (p.idprematricula = l.idprematricula) " .
        " INNER JOIN estadodetalleprematricula dp ON (dp.codigoestadodetalleprematricula = l.codigoestadodetalleprematricula) " .
        " INNER JOIN materia m ON (l.codigomateria = m.codigomateria) " .
        " INNER JOIN estudiante e ON (p.codigoestudiante = e.codigoestudiante) " .
        " INNER JOIN estudiantegeneral ege ON (e.idestudiantegeneral = ege.idestudiantegeneral) " .
        " LEFT JOIN usuario u ON (ege.numerodocumento = u.numerodocumento) " .
        " INNER JOIN carrera c ON (e.codigocarrera = c.codigocarrera) " .
        " INNER JOIN situacioncarreraestudiante sce ON (e.codigosituacioncarreraestudiante = sce.codigosituacioncarreraestudiante) " .
        " WHERE " .
        " p.codigoperiodo = '" . $periodo . "' " .
        " AND l.idgrupo = '" . $grupo . "' " .
        " AND dp.codigoestadodetalleprematricula IN (21,22,23,24) " .
        " AND u.codigotipousuario = 600 " .
        " AND u.codigoestadousuario = 100 " .
        " AND l.codigomateria = '" . $materia . "' " . $sqlCarrera . " " . $Agrupar . " ";

    if ($datos == NULL) {
        $resRetiradas = $db->GetRow($SQL);
    } else {
        $resRetiradas = $db->GetAll($SQL);
    }
    return $resRetiradas;
}//End function estudiantesMateriasRetiradas


function obtenerPlanEstudioElectiva($db, $materia, $carrera)
{

    $SQL = "SELECT m.codigotipomateria,
       tm.nombretipomateria,
       c.codigocarrera,
       c.nombrecarrera,
       dpe.semestredetalleplanestudio,
       pe.nombreplanestudio,
       m.numerocreditos
FROM materia m
         INNER JOIN tipomateria tm ON (m.codigotipomateria = tm.codigotipomateria)
         INNER JOIN carrera c ON (m.codigocarrera = c.codigocarrera)
         LEFT JOIN detalleplanestudio dpe ON (m.codigomateria = dpe.codigomateria)
         LEFT JOIN planestudio pe ON (dpe.idplanestudio = pe.idplanestudio)
WHERE (m.codigomateria = (
    select distinct n.codigomateriaelectiva from notahistorico n
        inner join materia ma on ma.codigomateria = n.codigomateriaelectiva
        inner join carrera ca on ca.codigocarrera = ma.codigocarrera 
    where n.codigomateria = $materia and n.codigomateriaelectiva != 1 and ca.codigocarrera = $carrera limit 1
    ))
group by m.codigomateria ";


    $electiva = $db->GetRow($SQL);

    return $electiva;
}//End function obtenerPlanEstudioElectiva

/**
 * @return mixed
 * funcion para hallar la jornada correspondiente a la carrera
 */
function obtenerDatosJornada($db, $carrera)
{
    $SQL = "SELECT j.nombrejornada
FROM jornadacarrera jc
         left JOIN jornada j on jc.codigojornada = j.codigojornada
WHERE codigocarrera = $carrera";


    $datoJornada = $db->GetRow($SQL);

    if (empty($datoJornada)) {
        $datoJornada['nombrejornada'] = 'Diurna';

    }
    return $datoJornada;
}

function obtenerDatosMateria($db, $materia)
{

    $SQL = "SELECT
m.codigotipomateria,
tm.nombretipomateria,
c.codigocarrera,
c.nombrecarrera,
m.numerocreditos
FROM materia m
         inner JOIN tipomateria tm ON (m.codigotipomateria = tm.codigotipomateria)
         INNER JOIN carrera c ON (m.codigocarrera = c.codigocarrera)
WHERE m.codigomateria = $materia
GROUP BY m.codigomateria ";


    $datoMateria = $db->GetRow($SQL);

    return $datoMateria;
}//End function obtenerPlanEstudioElectiva

?>
<script>
    $('#exportExcel4').click(function (e) {
        $("#datos_a_enviar").val($("<div>").append($("#dataR4").eq(0).clone()).html());
        $("#formInforme").submit();

    });

    $('#exportExcel5').click(function (e) {
        $("#datos_a_enviar").val($("<div>").append($("#dataR5").eq(0).clone()).html());
        $("#formInforme").submit();

    });

    $('#exportExcel6').click(function (e) {
        $("#datos_a_enviar").val($("<div>").append($("#dataR6").eq(0).clone()).html());
        $("#formInforme").submit();

    });
</script>