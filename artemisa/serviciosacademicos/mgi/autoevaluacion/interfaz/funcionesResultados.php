<?php
/**
 * @modified Vega Gabriel <vegagabriel@unbosque.edu.do>.
 * Ajustes para que los promedios y las desviaciones algan diferentes
 * @since  Noviembre 29, 2019
 */
session_start();

require(realpath(dirname(__FILE__) . "/../../../../sala/includes/adaptador.php"));
require_once (PATH_ROOT . '/kint/Kint.class.php');

$html = "";
$htmlp = "";

if (isset($_REQUEST['action']) && !empty($_REQUEST['action'])) {
    $accion = $_REQUEST['action'];

    switch ($accion) {
        case 'resultadosencuesta': {
                $datos['idInstrumento'] = $_POST['instrumento'];
                $datos['periodo'] = $_POST['periodo'];
                $datos['carrera'] = $_POST['carrera'];
                $datos['categoria'] = $_POST['categoria'];
                $data = array();
                $sqlcarrera = "";
                $tipocategoria = "";

                //sí la categoiaria es docentes se adicionan columnas a la tabla de resultados
                if ($datos['categoria'] == 'EDOCENTES') {
                    $tipocategoria = "<th>Codigo_materia</th><th>Nombre_materia</th><th>Tipo_materia</th> " .
                            "<th>Nombre Grupo</th><th>Cod Grupo</th><th>Documento_docente</th><th>Nombre_docente</th>";
                }
                //lista de columnas a mostrar de los reusltados
                $preguntaslista = "<th>#</th><th>Codigo_carrera</th><th>Nombre_carrera</th>" .
                        "<th>Jornada</th><th>Semestre_plan_estudio</th><th>Documento_estudiante</th>" .
                        "<th>Nombre_estudiante</th><th>Genero_Estudiante</th>" . $tipocategoria . "";
                //si la carrera esta definida y es diferente a 1 (todas)
                if ($datos['carrera'] <> '1') {
                    $sqlcarrera = " and codigocarrera = '" . $datos['carrera'] . "' ";
                }

                //consulta las preguntas del instrumento
                $data_pre = queryConseguirPreguntas($db, $datos['idInstrumento']);
                $cp = 1;
                foreach ($data_pre as $dt) {
                    $titulo1 = $dt['titulo'];
                    $titulo = str_replace('<br>', '', $titulo1);
                    $preguntaslista .= "<th style='font-size:10px'>Preg:" . $cp . " " . strip_tags($titulo, '<br><span style>') . "</th>";
                    $cp++;
                }
                $uidsiq_Apregunta = "";

                foreach ($data_pre as $dt) {
                    //lista las preguntas
                    $uidsiq_Apregunta .= $dt['idsiq_Apregunta'] . ",";
                }
                $gidsiq_Apregunta = substr($uidsiq_Apregunta, 0, -1);

                if ($datos['categoria'] == 'EDOCENTES') {
                    //consulta los participantes para una encuesta de asignaturas
                    $sqlparticipantes = "SELECT sri.idsiq_Arespuestainstrumento, u.idusuario, " .
                            " eg.numerodocumento, e.codigoestudiante, c.codigocarrera, o.numeroordenpago, dpm.codigomateria, " .
                            " g.idgrupo, c.nombrecarrera, c.codigocarrera, m.nombremateria, tm.nombretipomateria, g.nombregrupo, m.codigomateria, j.nombrejornada, " .
                            " pm.semestreprematricula, d.numerodocumento as 'numerodocente', d.nombredocente, d.apellidodocente, " .
                            " eg.nombresestudiantegeneral, eg.apellidosestudiantegeneral, ge.nombregenero " .
                            " FROM siq_Arespuestainstrumento sri " .
                            " INNER JOIN usuario u on (sri.usuariocreacion = u.idusuario and u.codigotipousuario = 600 )" .
                            " INNER JOIN estudiantegeneral eg ON ( eg.numerodocumento = u.numerodocumento ) " .
                            " INNER JOIN estudiante e ON ( eg.idestudiantegeneral = e.idestudiantegeneral " . $sqlcarrera . ") " .
                            " INNER JOIN carrera c ON ( c.codigocarrera = e.codigocarrera and c.codigomodalidadacademica = 200) " .
                            " INNER JOIN ordenpago o on (o.codigoestudiante = e.codigoestudiante and o.codigoperiodo = '" . $datos['periodo'] . "' " .
                            " AND o.codigoestadoordenpago IN (40, 41, 44, 51, 52)) " .
                            " INNER JOIN jornada j on (j.codigojornada = e.codigojornada) " .
                            " INNER JOIN detalleordenpago od ON ( o.numeroordenpago = od.numeroordenpago and od.codigoconcepto = 151) " .
                            " INNER JOIN detalleprematricula dpm ON ( dpm.numeroordenpago = o.numeroordenpago AND dpm.codigoestadodetalleprematricula = 30 )" .
                            " INNER JOIN prematricula pm on (dpm.idprematricula = pm.idprematricula) " .
                            " INNER JOIN grupo g ON (g.idgrupo = dpm.idgrupo) " .
                            " INNER JOIN docente d on (g.numerodocumento = d.numerodocumento) " .
                            " INNER JOIN materia m on (m.codigomateria = g.codigomateria) " .
                            " INNER JOIN tipomateria tm ON (tm.codigotipomateria=m.codigotipomateria) " .
                            " INNER JOIN genero ge on (eg.codigogenero = ge.codigogenero) " .
                            " WHERE sri.idsiq_Ainstrumentoconfiguracion = '" . $datos['idInstrumento'] . "' " .
                            " AND sri.codigoestado = 100 GROUP BY sri.usuariocreacion, idgrupo";
                } else {
                    //consulta para obtener los participantes de una encuesta generica
                    $sqlparticipantes = "SELECT sri.idsiq_Arespuestainstrumento, u.idusuario, eg.numerodocumento, e.codigoestudiante, " .
                            " c.codigocarrera, o.numeroordenpago, dpm.codigomateria, c.nombrecarrera, c.codigocarrera, j.nombrejornada, " .
                            " pm.semestreprematricula, eg.nombresestudiantegeneral, eg.apellidosestudiantegeneral, ge.nombregenero FROM siq_Arespuestainstrumento sri " .
                            " INNER JOIN usuario u ON (sri.usuariocreacion = u.idusuario and u.codigotipousuario = 600 )" .
                            " INNER JOIN estudiantegeneral eg ON ( eg.numerodocumento = u.numerodocumento ) " .
                            " INNER JOIN estudiante e ON ( eg.idestudiantegeneral = e.idestudiantegeneral " . $sqlcarrera . ") " .
                            " INNER JOIN carrera c ON ( c.codigocarrera = e.codigocarrera and c.codigomodalidadacademica = 200) " .
                            " INNER JOIN ordenpago o ON (o.codigoestudiante = e.codigoestudiante and o.codigoperiodo = '" . $datos['periodo'] . "' " .
                            " AND o.codigoestadoordenpago IN (40, 41, 44, 51, 52) ) " .
                            " INNER JOIN jornada j ON (j.codigojornada = e.codigojornada) " .
                            " INNER JOIN detalleordenpago od ON ( o.numeroordenpago = od.numeroordenpago and od.codigoconcepto = 151) " .
                            " INNER JOIN detalleprematricula dpm ON ( dpm.numeroordenpago = o.numeroordenpago AND dpm.codigoestadodetalleprematricula = 30 )" .
                            " INNER JOIN prematricula pm ON (dpm.idprematricula = pm.idprematricula) " .
                            " INNER JOIN genero ge ON (eg.codigogenero = ge.codigogenero) " .
                            " WHERE sri.idsiq_Ainstrumentoconfiguracion = '" . $datos['idInstrumento'] . "' " .
                            " AND sri.codigoestado = 100 GROUP BY sri.usuariocreacion";
                }
                $participantes = $db->GetAll($sqlparticipantes);
                //si la cantidad de registros es mayor a 1
                if (count($participantes) > 1) {
                    $html = "";
                    $k = 1;
                    foreach ($participantes as $listaparticipantes) {
                        $grupo = "";
                        if ($datos['categoria'] == 'EDOCENTES') {
                            $grupo = " AND sri.idgrupo = " . $listaparticipantes['idgrupo'] . " ";
                        }
                        $html2 = "";
                        foreach ($data_pre as $preguntas) {
                            //consulta los resultados para un usuario, pregunta e instrumento, si es categoria docentes adiciona el grupo
                            $sqlparticipacion = "SELECT sri.idsiq_Apregunta, sri.preg_abierta, spr.respuesta, spr.valor, spr.multiple_respuesta " .
                                    " FROM siq_Arespuestainstrumento sri  " .
                                    " LEFT JOIN siq_Apreguntarespuesta spr ON (sri.idsiq_Apreguntarespuesta = spr.idsiq_Apreguntarespuesta)" .
                                    " WHERE sri.usuariocreacion = '" . $listaparticipantes['idusuario'] . "' " .
                                    " AND sri.idsiq_Ainstrumentoconfiguracion = '" . $datos['idInstrumento'] . "' " .
                                    " AND sri.idsiq_Apregunta = '" . $preguntas['idsiq_Apregunta'] . "' " . $grupo . " " .
                                    " AND sri.codigoestado = 100 ORDER BY sri.idsiq_Apregunta ASC ";
                            $respuestaspreguntas = $db->GetRow($sqlparticipacion);

                            if (isset($respuestaspreguntas['idsiq_Apregunta']) && !empty($respuestaspreguntas['idsiq_Apregunta'])) {
                                if ($preguntas['idsiq_Apregunta'] == $respuestaspreguntas['idsiq_Apregunta']) {
                                    if (empty($respuestaspreguntas['valor']) and empty($respuestaspreguntas['respuesta']) and ! empty($respuestaspreguntas['preg_abierta'])) {
                                        $html2 .= "<td>" . $respuestaspreguntas['preg_abierta'] . "</td>";
                                    } else {
                                        if (empty($respuestaspreguntas['valor']) and ! empty($respuestaspreguntas['respuesta'])) {
                                            $html2 .= "<td>" . $respuestaspreguntas['respuesta'] . "</td>";
                                        } else {
                                            $html2 .= "<td>" . $respuestaspreguntas['valor'] . "</td>";
                                        }
                                    }
                                } else {
                                    $html2 .= "<td> sin respuesta </td>";
                                }
                            } else {
                                $html2 .= "<td> sin respuesta </td>";
                            }
                        }

                        $html .= "<tr>";
                        $html .= "<td>" . $k . "</td>";
                        $html .= "<td>" . $listaparticipantes['codigocarrera'] . "</td>";
                        $html .= "<td>" . $listaparticipantes['nombrecarrera'] . "</td>";
                        $html .= "<td>" . $listaparticipantes['nombrejornada'] . "</td>";
                        $html .= "<td>" . $listaparticipantes['semestreprematricula'] . "</td>";
                        $html .= "<td>" . $listaparticipantes['numerodocumento'] . "</td>";
                        $html .= "<td>" . $listaparticipantes['nombresestudiantegeneral'] . " " . $listaparticipantes['apellidosestudiantegeneral'] . "</td>";
                        $html .= "<td>" . $listaparticipantes['nombregenero'] . "</td>";

                        if ($datos['categoria'] == 'EDOCENTES') {
                            $html .= "<td>" . $listaparticipantes['codigomateria'] . "</td>";
                            $html .= "<td>" . $listaparticipantes['nombremateria'] . "</td>";
                            $html .= "<td>" . $listaparticipantes['nombretipomateria'] . "</td>";
                            $html .= "<td>" . $listaparticipantes['nombregrupo'] . "</td>";
                            $html .= "<td>" . $listaparticipantes['idgrupo'] . "</td>";
                            $html .= "<td>" . $listaparticipantes['numerodocente'] . "</td>";
                            $html .= "<td>" . $listaparticipantes['nombredocente'] . " " . $listaparticipantes['apellidodocente'] . "</td>";
                        }
                        $html .= $html2;
                        $html .= "</tr>";
                        $k++;
                    }
                    $val = true;
                } else {
                    $html = "<tr><td>Sin datos para mostrar</td></tr>";
                    $val = false;
                }
                $data['tabla'] = $html;
                $data['preguntas'] = $preguntaslista;
                $data['val'] = $val;
                echo json_encode($data);
            }break;

        case 'consultardatos': {
                $idInstrumento = $_POST['id'];
                $carrera = $_POST['carrera'];
                $periodo = $_POST['periodo'];
                /* LISTA  LAS MATERIAS MATRICULADAS, LAS MATERIAS EVALUADAS Y LAS MATERIAS PENDIENTES POR EVALUAR
                  DE CADA ESTUDIANTE POR CARRERA. */
                $sql = "SELECT p.MateriasMatriculadas, " .
                        " IF (  p.MateriasEvaluadas > p.MateriasMatriculadas,
                        p.MateriasMatriculadas, p.MateriasEvaluadas
                    ) AS MateriasEvaluadas, " .
                        " IF ( " .
                        " ( p.MateriasMatriculadas - p.MateriasEvaluadas ) < 0, 0, " .
                        "  (  p.MateriasMatriculadas - p.MateriasEvaluadas ) ) AS MateriasSinEvaluar,  " .
                        " p.numerodocumento, p.NombreCompleto, " .
                        " p.telefonoresidenciaestudiantegeneral, p.celularestudiantegeneral, " .
                        " p.emailestudiantegeneral, p.emailinstitucional, " .
                        " p.codigocarrera, p.nombrecarrera " .
                        " FROM  ( " .
                        " SELECT ege.numerodocumento, " .
                        " CONCAT(  ege.apellidosestudiantegeneral, ' ', ege.nombresestudiantegeneral ) AS NombreCompleto, " .
                        " COUNT( dp.idprematricula) AS MateriasMatriculadas, dp.idprematricula, " .
                        " IF ( (b.MateriasEvaluadas) IS NULL, 0, b.MateriasEvaluadas ) AS MateriasEvaluadas, " .
                        " ege.telefonoresidenciaestudiantegeneral,  ege.celularestudiantegeneral, " .
                        " ege.emailestudiantegeneral, " .
                        " CONCAT( u.usuario,  '@unbosque.edu.co') AS emailinstitucional, " .
                        " e.codigocarrera, c.nombrecarrera, u.idusuario " .
                        " FROM estudiantegeneral ege " .
                        " INNER JOIN estudiante e ON ( ege.idestudiantegeneral = e.idestudiantegeneral ) " .
                        " INNER JOIN carrera c ON ( e.codigocarrera = c.codigocarrera ) " .
                        " INNER JOIN usuario u ON ( ege.numerodocumento = u.numerodocumento ) " .
                        " INNER JOIN prematricula p ON ( e.codigoestudiante = p.codigoestudiante )" .
                        " INNER JOIN detalleprematricula dp ON ( p.idprematricula = dp.idprematricula ) " .
                        " LEFT JOIN ( " .
                        " SELECT a.usuariocreacion, COUNT(a.usuariocreacion) AS MateriasEvaluadas " .
                        " FROM  ( " .
                        " SELECT ar.usuariocreacion, ar.idsiq_Ainstrumentoconfiguracion, " .
                        " COUNT(*) AS Respuestas FROM " .
                        " siq_Arespuestainstrumento ar WHERE " .
                        " ar.idsiq_Ainstrumentoconfiguracion = '" . $idInstrumento . "' " .
                        " AND ar.codigoestado = '100' GROUP BY ar.idgrupo, ar.usuariocreacion " .
                        " HAVING COUNT(*) >= ( " .
                        " SELECT COUNT(*) AS contador " .
                        " FROM siq_Ainstrumento i " .
                        " INNER JOIN siq_Apregunta p ON ( i.idsiq_Apregunta = p.idsiq_Apregunta ) " .
                        " WHERE i.idsiq_Ainstrumentoconfiguracion = '" . $idInstrumento . "' " .
                        " AND p.obligatoria = '1' AND i.codigoestado = '100' " .
                        " ) ORDER BY ar.usuariocreacion " .
                        " ) a GROUP BY a.usuariocreacion " .
                        " ) b ON ( u.idusuario = b.usuariocreacion ) " .
                        " WHERE u.codigotipousuario = 600 " .
                        " AND u.codigoestadousuario = 100 " .
                        " AND p.codigoperiodo = '" . $periodo . "' " .
                        " AND p.codigoestadoprematricula IN (40, 41) " .
                        " AND dp.codigoestadodetalleprematricula = 30 " .
                        " AND dp.numeroordenpago IN " .
                        " (SELECT o.numeroordenpago FROM ordenpago o  " .
                        " WHERE o.codigoperiodo = p.codigoperiodo AND o.codigoestudiante = p.codigoestudiante " .
                        " AND o.codigoestadoordenpago IN (40, 41, 44)) " .
                        " AND e.codigocarrera = '" . $carrera . "' " .
                        " GROUP BY dp.idprematricula)p " .
                        " ORDER BY p.NombreCompleto ASC ";
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
            }break;
        case 'Consultaprogramas': {
                $valor = $_POST['valor'];
                $sqlcadena = "";
                if (!empty($valor)) {
                    //LISTA CARRERAS 
                    $queryprogramasobjetivo = "SELECT dop.tipoestudiante, dop.E_New, dop.E_Old, " .
                            " dop.E_Egr, dop.E_Gra, dop.cadena, dop.semestre,  dop.codigocarrera " .
                            " FROM siq_Apublicoobjetivo ob " .
                            " INNER JOIN siq_Adetallepublicoobjetivo dop ON ( ob.idsiq_Apublicoobjetivo = dop.idsiq_Apublicoobjetivo ) " .
                            " WHERE ob.idsiq_Ainstrumentoconfiguracion = '" . $valor . "' " .
                            " AND ( dop.E_New = 1 || dop.E_Old = 1 || dop.E_Egr = 1 || dop.E_Gra = 1 )";
                    $datos = $db->GetAll($queryprogramasobjetivo);
                    if (count($datos) > 0) {
                        foreach ($datos as $resultado) {
                            if ($resultado['cadena'] == null || $resultado['cadena'] == '0') {
                                $cadena = "1";
                            } else {
                                $cadena1 = str_replace('::', ',', $resultado['cadena']);
                                $cadena = substr($cadena1, 1);
                            }
                        }
                        if ($cadena <> "1") {
                            $sqlcadena = " AND c.codigocarrera in (" . $cadena . ")";
                        }
                    }
                }
                //LISTA CARRERAS ACTIVAS SOLO PARA LA MODALIDAD DE PREGRADO.   
                $queryprogramas = "SELECT c.codigocarrera, c.nombrecarrera " .
                        " FROM carrera c WHERE " .
                        " c.codigomodalidadacademica = '200' " .
                        " AND c.nombrecarrera NOT LIKE '%departamento%' " .
                        " AND c.nombrecarrera NOT LIKE '%curso%' " .
                        " AND c.codigocarrera NOT IN (30,39,74,138,2,1,12,79,3,868,4) " .
                        " AND c.fechavencimientocarrera > now() " .
                        $sqlcadena . " " .
                        " ORDER BY c.nombrecarrera";
                $programas = $db->GetAll($queryprogramas);

                $html .= "<select id='carrera' name='carrera'><option value='0'>Seleccion</option><option value='1'>Todos</option>";
                foreach ($programas as $listado) {
                    $html .= "<option value='" . $listado['codigocarrera'] . "'>" . $listado['nombrecarrera'] . "</option>";
                }
                $html .= "</select>";
                echo $html;
            }break;
        case 'Consultaperiodo': {
                //consulta la lista de perioidos disponibles
                $SQL_periodo = "SELECT p.codigoperiodo, p.nombreperiodo " .
                        " FROM periodo p ORDER BY p.codigoperiodo DESC";
                $periodos = $db->GetAll($SQL_periodo);

                $htmlp .= "<select id='periodo' name='periodo'> <option value='0'>Seleccion</option>";
                foreach ($periodos as $listaperiodos) {
                    $htmlp .= "<option value='" . $listaperiodos['codigoperiodo'] . "'>" . $listaperiodos['nombreperiodo'] . "</option>";
                }
                $htmlp .= "</select>";
                echo $htmlp;
            }break;
        case 'ConsultaEstadisticaGeneral': {
                $datos['idInstrumento'] = $_POST['id'];
                $datos['carrera'] = $_POST['carrera'];
                $datos['nombrecarrera'] = $_POST['nombrecarrera'];
                $datos['periodo'] = $_POST['periodo'];
                $datos['departamento'] = null;
                $datos['grupo'] = null;
                $datos['idusuario'] = $_SESSION['idusuario'];

                $nomcarrera = explode(" ", $datos['nombrecarrera']);
                if ($datos['carrera'] > 1) {
                    if (in_array("DEPARTAMENTO", $nomcarrera) || in_array("CURSO", $nomcarrera) || in_array("CENTRO", $nomcarrera)) {
                        $datos['departamento'] = 1;
                        //funcion que obtiene el total de matriculados de un departamento o curso
                        $matriculadoscarrera = consultarmatriculadosdepartamento_curso($db, $datos);
                    } else {
                        //funcion que obtiene el total de matriculados para una carrera
                        $matriculadoscarrera = consultarmatriculadosinstitucional($db, $datos);
                    }
                }
                //funcion que obtiene el total de matriculados para la institucion
                $matriculadosinstitucional = consultarmatriculadosinstitucional($db, $datos['periodo']);

                //grupos validos
                $listaGrupos = gruposValidos($db, $datos);

                $html = "";
                $count = 1;
                //consulta las preguntas del instrumento
                $resultados = queryConseguirPreguntas($db, $datos['idInstrumento']);
                foreach ($resultados as $preguntas) {
                    //valida si la pregunta es diferente ha abierta (5)
                    if ($preguntas['idsiq_Atipopregunta'] <> '5') {
                        //consulta el historico para una pregunta, para un isntrumento, para una carrera
                        $datoshistorico = consultahistorico($db, $datos, $preguntas['idsiq_Apregunta'], 'Pregunta', 'Carrera');
                        //si el resulta es diferente a null ingresa a asignacion de variables
                        if (isset($datoshistorico['IdInformeEvaluacioDocenteHistorico']) && $datoshistorico['IdInformeEvaluacioDocenteHistorico'] <> null) {
                            if (!empty($_POST["update"])) {
                                //si no existen datos en el histrorio, inicia la conuslta de promedio para una pregunta y un instrumento y carrera
                                $Numeroregistros = consultarpromedio($db, $datos, $preguntas['idsiq_Apregunta'], $listaGrupos);
                                $datos['participantes'] = $Numeroregistros['cantidad'];
                                $promedio = $Numeroregistros['promedio'];
                                $datos['media'] = round($promedio, 3);
                                //conuslta los valores de las respuestas a una pregunta un instrumento y carrera
                                $respuesta = valorespreguntas($db, $datos, $preguntas['idsiq_Apregunta'], $listaGrupos);
                                //calcula la desviacion y redondea a 3 digitos decimales
                                $datos['desviacion'] = round(desviacion($respuesta, $datos['media']), 3);
                                //funcion que edita en el historico los resultados obtenidos
                                editaregistrohistorico($db, $datos, $preguntas['idsiq_Apregunta'], 'Pregunta');
                            } else {
                                $datos['participantes'] = $datoshistorico['Participantes'];
                                $datos['media'] = $datoshistorico['Media'];
                                $datos['desviacion'] = $datoshistorico['DesviacionEstandar'];
                            }
                        } else {
                            //si no existen datos en el histrorio, inicia la conuslta de promedio para una pregunta y un instrumento y carrera
                            $Numeroregistros = consultarpromedio($db, $datos, $preguntas['idsiq_Apregunta'], $listaGrupos);
                            $datos['participantes'] = $Numeroregistros['cantidad'];
                            $promedio = $Numeroregistros['promedio'];
                            $datos['media'] = round($promedio, 3);
                            //conuslta los valores de las respuestas a una pregunta un instrumento y carrera
                            $respuesta = valorespreguntas($db, $datos, $preguntas['idsiq_Apregunta'], $listaGrupos);
                            //calcula la desvision y redondea a 3 digitos decimales
                            $datos['desviacion'] = round(desviacion($respuesta, $datos['media']), 3);

                            //funcion que registra en el historico los resultados obtenidos
                            registrohistorico($db, $datos, $preguntas['idsiq_Apregunta'], 'Pregunta');
                        }
                        //limpia de tags en el html de las preguntas
                        $titulo = strip_tags($preguntas['seccion'], '<font size="4">');
                        $titulo .= strip_tags($preguntas['titulo'], '<br><span style>');

                        if ($preguntas['idsiq_Apregunta'] == '3139') {
                            $titulo = "Las actividades de aprendizaje han tenido una asignación de trabajo académico "
                                    . "acorde con el número de créditos de la asignatura, 1 crédito = 3 horas de trabajo académico semanal";
                        }

                        $html .= "<tr class='collapse multi-collapse'>";
                        $html .= "<td style='border: 1px solid black;'>" . $count . "</td>";
                        $html .= "<td style='border: 1px solid black;'>" . $titulo . "</td>";
                        $html .= "<td  align='center' style='border: 1px solid black; background-color: #d0e3a3'>" . number_format($datos['media'], 3, ',', '') . "</td>";
                        $html .= "<td  align='center' style='border: 1px solid black; background-color: #d0e3a3'> " . number_format($datos['desviacion'], 3, ',', '') . "</td>";
                        if ($datos['carrera'] <> '1') {
                            //conuslta el historico institucional de una pregunta para un isntrumento
                            $datoinstitucional = consultahistorico($db, $datos, $preguntas['idsiq_Apregunta'], 'Pregunta', null);
                            $html .= "<td align='center' style='border: 1px solid black; background-color: #B6D277'>" . number_format($datoinstitucional['Media'], 3, ',', '') . "</td>";
                            $html .= "<td align='center' style='border: 1px solid black; background-color: #B6D277'>" . number_format($datoinstitucional['DesviacionEstandar'], 3, ',', '') . "</td>";
                        }
                        $html .= "</tr>";
                        $count++;

                        /** Dimensiones * */
                        $iddimension = validadimensionfactor($db, $preguntas['idsiq_Apregunta'], $datos['idInstrumento'], 'Dimension');
                        if ($iddimension == $preguntas['idsiq_Apregunta']) {
                            $datosdimesiones = dimesionesFactores($db, $datos['idInstrumento'], $preguntas['idsiq_Apregunta'], 'Dimension');
                            $listapreguntas = $datosdimesiones['listapreguntas'];
                            $titulo = $datosdimesiones['titulo'];

                            //consulta el historico de una dimension para una carrerae instrumento
                            $datoshistorico = consultahistorico($db, $datos, $preguntas['idsiq_Apregunta'], 'Dimension', 'Carrera');
                            if (isset($datoshistorico['IdInformeEvaluacioDocenteHistorico']) && !empty($datoshistorico['IdInformeEvaluacioDocenteHistorico'])) {
                                if (!empty($_POST["update"])) {
                                    //si no existen datos en el histrorio, inicia la conuslta de promedio para una pregunta y un instrumento y carrera
                                    $Numeroregistros = consultarpromedio($db, $datos, $listapreguntas, $listaGrupos);
                                    $datos['participantes'] = $Numeroregistros['cantidad'];
                                    //conuslta los valores de las respuestas a una pregunta un instrumento y carrera
                                    $respuesta = valorespreguntas($db, $datos, $listapreguntas, $listaGrupos);
                                    $promedio = $Numeroregistros['promedio'];
                                    $datos['media'] = round($promedio, 3);
                                    $datos['desviacion'] = round(desviacion($respuesta, $promedio), 3);
                                    editaregistrohistorico($db, $datos, $preguntas['idsiq_Apregunta'], 'Dimension');
                                } else {
                                    $datos['participantes'] = $datoshistorico['Participantes'];
                                    $datos['media'] = $datoshistorico['Media'];
                                    $datos['desviacion'] = $datoshistorico['DesviacionEstandar'];
                                }
                            } else {
                                //si no existen datos en el histrorio, inicia la conuslta de promedio para una pregunta y un instrumento y carrera
                                $Numeroregistros = consultarpromedio($db, $datos, $listapreguntas, $listaGrupos);
                                $datos['participantes'] = $Numeroregistros['cantidad'];
                                //conuslta los valores de las respuestas a una pregunta un instrumento y carrera
                                $respuesta = valorespreguntas($db, $datos, $listapreguntas, $listaGrupos);
                                $promedio = $Numeroregistros['promedio'];
                                $datos['media'] = round($promedio, 3);
                                $datos['desviacion'] = round(desviacion($respuesta, $datos['media']), 3);
                                registrohistorico($db, $datos, $preguntas['idsiq_Apregunta'], 'Dimension');
                            }

                            $html .= "<tr>";
                            $html .= "<td style='border: 1px solid black;'><b>Dimensión</b></td>";
                            $html .= "<td style='border: 1px solid black;'><b>" . $titulo . "</b></td>";
                            $html .= "<td align='center' style='border: 1px solid black; background-color: #d0e3a3'><b>" . number_format($datos['media'], 3, ',', '') . "</b></td>";
                            $html .= "<td align='center' style='border: 1px solid black; background-color: #d0e3a3'><b>" . number_format($datos['desviacion'], 3, ',', '') . "</b></td>";
                            if ($datos['carrera'] <> '1') {
                                //conuslta el historico institucional de una pregunta para un isntrumento en un total de encuesta
                                $datoinstitucional = consultahistorico($db, $datos, $preguntas['idsiq_Apregunta'], 'Dimension', null);
                                $html .= "<td align='center' style='border: 1px solid black; background-color: #B6D277'><b>" . number_format($datoinstitucional['Media'], 3, ',', '') . "</b></td>";
                                $html .= "<td align='center' style='border: 1px solid black; background-color: #B6D277'><b>" . number_format($datoinstitucional['DesviacionEstandar'], 3, ',', '') . "</b></td>";
                            }
                            $html .= "</tr>";
                        }
                        /** Fin dimension * */
                        /** Total Encuestas * */
                        $idfcator = validadimensionfactor($db, $preguntas['idsiq_Apregunta'], $datos['idInstrumento'], 'Factor');
                        if ($idfcator == $preguntas['idsiq_Apregunta']) {
                            $datosdimesiones = dimesionesFactores($db, $datos['idInstrumento'], $preguntas['idsiq_Apregunta'], 'Factor');
                            $listapreguntas = $datosdimesiones['listapreguntas'];
                            $titulo1 = $datosdimesiones['titulo'];

                            //funcion que obtiene el historico para un total de encuestas de una carrera y pregunta
                            $datoshistorico = consultahistorico($db, $datos, $preguntas['idsiq_Apregunta'], 'TotalEncuesta', 'Carrera');
                            if (isset($datoshistorico['IdInformeEvaluacioDocenteHistorico']) && !empty($datoshistorico['IdInformeEvaluacioDocenteHistorico'])) {
                                if (!empty($_POST["update"])) {
                                    //si no existen datos en el histrorio, inicia la consulta de promedio para una pregunta y un instrumento y carrera de un total de encuesta
                                    $Numeroregistros1 = consultarpromedio($db, $datos, $listapreguntas, $listaGrupos);
                                    $datos['participantes'] = $Numeroregistros1['cantidad'];
                                    $respuesta1 = valorespreguntas($db, $datos, $listapreguntas, $listaGrupos);
                                    $promedio = $Numeroregistros1['promedio'];
                                    $datos['media'] = round($promedio, 3);
                                    $datos['desviacion'] = round(desviacion($respuesta1, $promedio), 3);
                                    editaregistrohistorico($db, $datos, $preguntas['idsiq_Apregunta'], 'TotalEncuesta');
                                } else {
                                    $datos['participantes'] = $datoshistorico['Participantes'];
                                    $datos['media'] = $datoshistorico['Media'];
                                    $datos['desviacion'] = $datoshistorico['DesviacionEstandar'];
                                }
                            } else {
                                //si no existen datos en el histrorio, inicia la consulta de promedio para una pregunta y un instrumento y carrera de un total de encuesta
                                $Numeroregistros1 = consultarpromedio($db, $datos, $listapreguntas, $listaGrupos);
                                $datos['participantes'] = $Numeroregistros1['cantidad'];
                                $respuesta1 = valorespreguntas($db, $datos, $listapreguntas, $listaGrupos);
                                $promedio = $Numeroregistros1['promedio'];
                                $datos['media'] = round($promedio, 3);
                                $datos['desviacion'] = round(desviacion($respuesta1, $promedio), 3);
                                registrohistorico($db, $datos, $preguntas['idsiq_Apregunta'], 'TotalEncuesta');
                            }

                            $html .= "<tr>";
                            $html .= "<td style='border: 3px solid green;'><b>Factor</b></td>";
                            $html .= "<td style='border: 3px solid green;'><b>" . $titulo1 . "</b></td>";
                            $html .= "<td align='center' style='border: 3px solid green; background-color: #d0e3a3'><b>" . number_format($datos['media'], 3, ',', '') . "</b></td>";
                            $html .= "<td align='center' style='border: 3px solid green; background-color: #d0e3a3'><b>" . number_format($datos['desviacion'], 3, ',', '') . "</b></td>";
                            if ($datos['carrera'] <> '1') {
                                //conuslta el historico institucional de una pregunta para un isntrumento en un total de encuesta
                                $datoinstitucional = consultahistorico($db, $datos, $preguntas['idsiq_Apregunta'], 'TotalEncuesta', null);
                                $html .= "<td align='center' style='border: 3px solid green; background-color: #B6D277'><b>" . number_format($datoinstitucional['Media'], 3, ',', '') . "</b></td>";
                                $html .= "<td align='center' style='border: 3px solid green; background-color: #B6D277'><b>" . number_format($datoinstitucional['DesviacionEstandar'], 3, ',', '') . "</b></td>";
                            }

                            /** Fin Total encuesta * */
                            $html .= "</tr>";
                        }
                    }
                }
                echo $html;
            }break;
        case 'CarrerasEncuestas' : {
                $datos['periodo'] = $_POST['periodo'];
                $datos['carrera'] = $_POST['carrera'];
                $datos['rol'] = $_POST['rol'];
                $datos['informe'] = $_POST['informe'];
                $datos['documento'] = $_POST['documento'];

                if (isset($_POST['grupo']) && !empty($_POST['grupo'])) {
                    $datos['grupo'] = $_POST['grupo'];
                } else {
                    $datos['grupo'] = null;
                }
                $adiSql="select DISTINCT c.codigocarrera from grupo g 
                INNER JOIN materia m on (m.codigomateria = g.codigomateria)
                INNER JOIN carrera c on (c.codigocarrera = m.codigocarrera)
                INNER JOIN detalleprematricula dtpr on (dtpr.idgrupo =g.idgrupo and dtpr.codigoestadodetalleprematricula=30)
                where g.codigoperiodo = " . $datos['periodo'] . " and g.codigoestadogrupo = 10 ";
                $sqlcarrera = "";
                if ($datos['carrera'] <> "1" && $datos['carrera'] <> "156" &&
                        ($datos['rol'] <> "93" && $datos['rol'] <> "96" && $datos['rol'] <> "98" && $datos['rol'] <> "99" && $datos['rol'] <> "13")) {
                    $sqlcarrera = " and c.codigocarrera =" . $datos['carrera'];
                }
                if ($datos['grupo'] == 'grupo' && !empty($datos['documento'])) {
                    $sqlcarrera = " and c.codigocarrera in ($adiSql  and g.numerodocumento = " . $datos['documento'] . ")";
                }else{
                $sqlcarrera = "and c.codigocarrera in($adiSql)";                    
                }

                //LISTA CARRERAS ACTIVAS SOLO PARA LA MODALIDAD DE PREGRADO.
                $queryprogramas = "SELECT  c.codigocarrera, c.nombrecarrera " .
                        " FROM carrera c " .
                        " WHERE c.codigomodalidadacademica = 200 " .
                        " AND c.codigocarrera NOT IN (30,39,74,138,2,1,12,79,3,868,4,1187)" .
                        " AND c.fechavencimientocarrera > now() " .
                        " " . $sqlcarrera . " " .
                        " GROUP BY c.codigocarrera ORDER BY c.nombrecarrera";
                $listaprogramas = $db->GetAll($queryprogramas);
                switch ($datos['informe']) {
                    case 'Docente': {
                            $institucional = "";
                        }break;
                    case 'Institucional': {
                            $institucional = "<option value='1'>Institucional</option>";
                        }break;
                }

                $html .= "<select id='carrera' name='carrera' class='form-control js-example-basic-single'><option value='0'>Seleccion</option>" . $institucional;
                foreach ($listaprogramas as $listado) {
                    $html .= "<option value='" . $listado['codigocarrera'] . "'>" . $listado['nombrecarrera'] . "</option>";
                }
                $html .= "</select>";

                echo $html;
            }break;
        case 'gruposdocente': {
                $numerodocumento = $_POST['docente'];
                $periodo = $_POST['periodo'];
                $carrera = $_POST['carrera'];
                $idInstrumento = $_POST['idInstrumento'];

                //consulta las preguntas de un instrumento
                $preguntas = queryConseguirPreguntas($db, $idInstrumento);
                //asigna la primera pregunta para referencia de consulta
                $pregunta = $preguntas['0']['idsiq_Apregunta'];

                $sqlgrupo = "SELECT g.idgrupo, g.nombregrupo, m.nombremateria FROM grupo g " .
                        " INNER JOIN materia m on (g.codigomateria = m.codigomateria) " .
                        " where g.codigoperiodo = " . $periodo . " and g.numerodocumento = " . $numerodocumento . " " .
                        " and  m.codigocarrera = " . $carrera . " and g.codigoestadogrupo = 10";
                $grupos = $db->GetAll($sqlgrupo);

                $html .= "<select id='grupo' name='grupo'> <option value='0'>Seleccion</option>";
                foreach ($grupos as $listado) {
                    $html .= "<option value='" . $listado['idgrupo'] . "'>" . $listado['nombregrupo'] . " - " . $listado['idgrupo'] . " - " . $listado['nombremateria'] . "</option>";
                }
                $html .= "</select>";

                echo $html;
            }break;
        case 'ListadoDocentes': {
                $periodo = $_POST['periodo'];
                $carrera = $_POST['carrera'];
                $docente = $_POST['docente'];
                $sqldocente = "";

                if ($docente <> "") {
                    $sqldocente = " AND g.numerodocumento=" . $docente;
                    $sqlcarrera = " ";
                } else {
                    $sqlcarrera = " AND m.codigocarrera = " . $carrera;
                }

                $sqllistado = "select d.numerodocumento, d.apellidodocente, d.nombredocente, d.iddocente " .
                        " from docente d " .
                        " INNER JOIN grupo g ON (d.numerodocumento = g.numerodocumento) " .
                        " INNER JOIN materia m ON (g.codigomateria = m.codigomateria) " .
                        " INNER JOIN detalleprematricula dp ON (dp.idgrupo=g.idgrupo AND dp.codigoestadodetalleprematricula = 30) " .
                        " WHERE g.codigoperiodo =  " . $periodo . " " . $sqldocente . " " . $sqlcarrera . " " .
                        " AND d.codigoestado=100  " .
                        " AND g.codigoestadogrupo = 10  " .
                        " GROUP BY d.apellidodocente, d.numerodocumento";
                $docentes = $db->GetAll($sqllistado);

                $html .= "<select id='docente' name='docente' class='form-control'><option value='0'>Seleccion</option>";
                foreach ($docentes as $listado) {
                    $html .= "<option value='" . $listado['numerodocumento'] . "'>" . $listado['apellidodocente'] . " " . $listado['nombredocente'] . "</option>";
                }
                $html .= "</select>";

                echo $html;
            }break;
        case 'ConsultaEstadisticaGrupo': {
                $datos['grupo'] = $_POST['grupo'];
                $datos['nombregrupo'] = $_POST['nombregrupo'];
                $datos['idInstrumento'] = $_POST['id'];
                $datos['periodo'] = $_POST['periodo'];
                $carrera1 = infocarrera($db, $datos['grupo']);
                $datos['carrera'] = $carrera1['codigocarrera'];
                $datos['ncarrera'] = $carrera1['nombrecarrera'];
                $datos['departamento'] = null;
                $datos['idusuario'] = $_SESSION['idusuario'];

                $nomcarrera = explode(" ", $datos['ncarrera']);

                if ($datos['carrera'] > 1) {
                    if (in_array("DEPARTAMENTO", $nomcarrera) || in_array("CURSO", $nomcarrera) || in_array("CENTRO", $nomcarrera)) {
                        $datos['departamento'] = '1';
                    }
                }
                //consulta de preguntas
                $preguntas = queryConseguirPreguntas($db, $datos['idInstrumento']);
                //matriculados del grupo
                $matriculadosgrupo = consultarmatriculados($db, $datos['grupo']);

                //grupos validos
                $listaGrupos = gruposValidos($db, $datos);

                $html = "";
                $count = 1;
                foreach ($preguntas as $listapregunta) {
                    //si el tipo de pregunta es diferente a pregunta abierta
                    if ($listapregunta['idsiq_Atipopregunta'] <> '5') {
                        /*                         * * GRUPO ** */
                        //consulta el promedio y cantidad de resultados de la pregunta para el grupo especifico
                        $Registros = consultarpromedio($db, $datos, $listapregunta['idsiq_Apregunta'], $listaGrupos);
                        if (isset($Registros['promedio']) && !empty($Registros['promedio'])) {
                            $media = round($Registros['promedio'], 3);
                            $participantes = $Registros['cantidad'];
                            $respuesta = valorespreguntas($db, $datos, $listapregunta['idsiq_Apregunta'], $listaGrupos);
                            $desviacion = desviacion($respuesta, $media);
                        } else {
                            $mediacarrera = 0;
                            $participantescarrera = 0;
                            $participantes = 0;
                            $media = 0;
                            $desviacion = 0;
                        }
                        /*                         * * FIN GRUPO ** */

                        /*                         * * CARRERA ** */
                        //consulta el historico de los datos del programa para la pregunta y el instrumento
                        $Registroscarrera = consultahistorico($db, $datos, $listapregunta['idsiq_Apregunta'], 'Pregunta', 'Carrera');
                        if (isset($Registroscarrera['IdInformeEvaluacioDocenteHistorico']) && !empty($Registroscarrera['IdInformeEvaluacioDocenteHistorico'])) {
                            $mediacarrera = $Registroscarrera['Media'];
                            $participantescarrera = $Registroscarrera['Participantes'];
                            $desviacioncarrera = $Registroscarrera['DesviacionEstandar'];
                        } else {
                            //consulta el promedio del programa para la pregunta y el instrumento
                            $Registroscarrera = consultarpromedio($db, $datos, $listapregunta, $listaGrupos);
                            if ($Registroscarrera['promedio'] > 0) {
                                $mediacarrera = round($Registroscarrera['promedio'], 3);
                                $participantescarrera = $Registroscarrera['cantidad'];
                                $respuesta = valorespreguntas($db, $datos, $listapregunta, $listaGrupos);
                                $desviacioncarrera = round(desviacion($respuesta, $mediacarrera), 3);
                            } else {
                                $mediacarrera = 0;
                                $participantescarrera = 0;
                                $desviacioncarrera = 0;
                            }
                        }
                        /*                         * * FIN CARRERA ** */
                        /*                         * * INSTITUCIONAL ** */
                        //consulta el historico instutucional para la pregunta
                        $Registrosinstitucion = consultahistorico($db, $datos, $listapregunta['idsiq_Apregunta'], 'Pregunta', null);
                        if (isset($Registrosinstitucion['IdInformeEvaluacioDocenteHistorico']) && !empty($Registrosinstitucion['IdInformeEvaluacioDocenteHistorico'])) {
                            $mediainstitucional = $Registrosinstitucion['Media'];
                            $participantesinstitucional = $Registrosinstitucion['Participantes'];
                            $desviacioninstitucional = $Registrosinstitucion['DesviacionEstandar'];
                        } else {
                            //consulta el promedio y cantidad institucional para la pregunta
                            $Registrosinstitucion = consultarpromedio($db, $datos, $listapregunta['idsiq_Apregunta'], $listaGrupos);
                            $mediainstitucional = round($Registrosinstitucion['promedio'], 3);
                            $participantesinstitucional = $Registrosinstitucion['cantidad'];
                            $respuesta = valorespreguntas($db, $datos, $listapregunta, $listaGrupos);
                            $desviacioninstitucional = round(desviacion($respuesta, $mediainstitucional), 3);
                        }
                        /*                         * * FIN INSTITRUCIONAL ** */
                        $titulo2 = strip_tags($listapregunta['seccion'], '<font size="4">');
                        $titulo2 .= strip_tags($listapregunta['titulo'], '<br><span style>');


                        $titulo = strip_tags($titulo2, '<br>');
                        if ($listapregunta['idsiq_Apregunta'] == '3139') {
                            $titulo = strip_tags($listapregunta['seccion'], '<font size="4">');
                            $titulo .= " Las actividades de aprendizaje han tenido una asignación de trabajo "
                                    . "académico acorde con el número de créditos de la asignatura, 1 crédito = 3 horas de trabajo académico semanal";
                        }

                        $html .= "<tr class='collapse multi-collapse'>";
                        $html .= "<td style='border: 1px solid black;'>" . $count . "</td>";
                        $html .= "<td style='border: 1px solid black;'>" . $titulo . "</td>";
                        if ($_SESSION["rol"] == 13 || $_SESSION["usuario"] == 'fortalecimiento') {
                            $datamedia = "<a href='javascript:listaEstudiantesGrupoMateria(" . $listapregunta['idsiq_Apregunta'] . ")'>" . number_format($media, 3, ',', '') . "</a>";
                            $datamediacarrera = "<a href='javascript:cantidadEstudiantesCarreraPregunta(" . $participantescarrera . ")'>" . number_format($mediacarrera, 3, ',', '') . "</a>";
                        } else {
                            $datamedia = $media;
                            $datamediacarrera = $mediacarrera;
                        }
                        $html .= "<td align='center' style='border: 1px solid black; background-color: #E7F1D1'>" . $datamedia . "</td>";
                        $html .= "<td align='center' style='border: 1px solid black; background-color: #E7F1D1'>" . number_format($desviacion, 3, ',', '') . "</td>";
                        $html .= "<td align='center' style='border: 1px solid black; background-color: #d0e3a3'>" . $datamediacarrera . "</td>";
                        $html .= "<td align='center' style='border: 1px solid black; background-color: #d0e3a3'>" . number_format($desviacioncarrera, 3, ',', '') . "</td>";
                        $html .= "<td align='center' style='border: 1px solid black; background-color: #B6D277'>" . number_format($mediainstitucional, 3, ',', '') . "</td>";
                        $html .= "<td align='center' style='border: 1px solid black; background-color: #B6D277'>" . number_format($desviacioninstitucional, 3, ',', '') . "</td>";
                        $html .= "</tr>";
                        $count++;

                        /** Dimensiones* */
                        //este if valida las preguntas de inicio de dimension
                        $iddimension = validadimensionfactor($db, $listapregunta['idsiq_Apregunta'], $datos['idInstrumento'], 'Dimension');
                        if ($iddimension == $listapregunta['idsiq_Apregunta']) {
                            $datosdimesiones = dimesionesFactores($db, $datos['idInstrumento'], $listapregunta['idsiq_Apregunta'], 'Dimension');
                            $listapreguntas = $datosdimesiones['listapreguntas'];
                            $titulo = $datosdimesiones['titulo'];

                            /** Grupo  * */
                            //consulta el promedio de una carrera para un grupo de preguntas de un grupo
                            $Numeroregistros = consultarpromedio($db, $datos, $listapreguntas, $listaGrupos);
                            $media1 = round($Numeroregistros['promedio'], 3);
                            $respuesta = valorespreguntas($db, $datos, $listapreguntas, $listaGrupos);
                            $desviacion1 = round(desviacion($respuesta, $media1), 3);
                            //calcula la cantidad de matriculados de las preguntas consultadas
                            $Participantes = $Numeroregistros['cantidad'];
                            /** Fin Grupo * */
                            /** Carrera * */
                            //consulta el historico para obtener los datos de la dimension
                            $Registroscarrera = consultahistorico($db, $datos, $listapregunta['idsiq_Apregunta'], 'Dimension', 'Carrera');
                            if (isset($Registroscarrera['IdInformeEvaluacioDocenteHistorico']) && !empty($Registroscarrera['IdInformeEvaluacioDocenteHistorico'])) {
                                $mediacarrera = $Registroscarrera['Media'];
                                $participantescarrera = $Registroscarrera['Participantes'];
                                $desviacioncarrera = $Registroscarrera['DesviacionEstandar'];
                            } else {
                                $mediacarrera = 0;
                                $participantescarrera = 0;
                                $desviacioncarrera = 0;
                            }
                            /** Fin Carrera * */
                            /** Institucion * */
                            //consulta el historico para obtener los datos de la dimension
                            $Numeroregistrosinstitucionales = consultahistorico($db, $datos, $listapregunta['idsiq_Apregunta'], 'Dimension', null);
                            if (isset($Numeroregistrosinstitucionales['IdInformeEvaluacioDocenteHistorico']) && !empty($Numeroregistrosinstitucionales['IdInformeEvaluacioDocenteHistorico'])) {
                                $mediainstitucional = $Numeroregistrosinstitucionales['Media'];
                                $participantesinstitucional = $Numeroregistrosinstitucionales['Participantes'];
                                $desviacioninstitucional = $Numeroregistrosinstitucionales['DesviacionEstandar'];
                            } else {
                                $mediainstitucional = 0;
                                $participantesinstitucional = 0;
                                $desviacioninstitucional = 0;
                            }
                            /** Fin Institucion * */
                            $html .= "<tr>";
                            $html .= "<td style='border: 1px solid black;'><b>Dimensión</td>";
                            $html .= "<td style='border: 1px solid black;'><b>" . $titulo . "</td>";
                            $html .= "<td align='center' style='border: 1px solid black; background-color: #E7F1D1'><b>" . number_format($media1, 3, ',', '') . "</b></td>";
                            $html .= "<td align='center' style='border: 1px solid black; background-color: #E7F1D1'><b>" . number_format($desviacion1, 3, ',', '') . "</b></td>";
                            $html .= "<td align='center' style='border: 1px solid black; background-color: #d0e3a3'><b>" . number_format($mediacarrera, 3, ',', '') . "</b></td>";
                            $html .= "<td align='center' style='border: 1px solid black; background-color: #d0e3a3'><b>" . number_format($desviacioncarrera, 3, ',', '') . "</b></td>";
                            $html .= "<td align='center' style='border: 1px solid black; background-color: #B6D277'><b>" . number_format($mediainstitucional, 3, ',', '') . "</b></td>";
                            $html .= "<td align='center' style='border: 1px solid black; background-color: #B6D277'><b>" . number_format($desviacioninstitucional, 3, ',', '') . "</b></td>";
                            $html .= "</tr>";
                        }

                        /** Fin Dimension* */
                        /** Total Encuesta* */
                        //este if valida grupos de preguntas por las encuestas especificas
                        $idfactor = validadimensionfactor($db, $listapregunta['idsiq_Apregunta'], $datos['idInstrumento'], 'Factor');
                        if ($idfactor == $listapregunta['idsiq_Apregunta']) {
                            $datosfactor = dimesionesFactores($db, $datos['idInstrumento'], $listapregunta['idsiq_Apregunta'], 'Factor');
                            $listapreguntas1 = $datosfactor['listapreguntas'];
                            $titulo1 = $datosfactor['titulo'];
                            /** Grupo * */
                            //consulta el promedio y cantidad de respuestas para un grupo de preguntas
                            $Numeroregistros1 = consultarpromedio($db, $datos, $listapreguntas1, $listaGrupos);
                            $preguntasLista1 = explode(",", $listapreguntas1);
                            //calcula la cantidad de participantes por medio de las preguntas consultadas
                            $Participantes = $Numeroregistros1['cantidad'];
                            $mediaf = round($Numeroregistros1['promedio'], 3);
                            $respuestal = valorespreguntas($db, $datos, $listapreguntas1, $listaGrupos);

                            $desviacionl = round(desviacion($respuestal, $mediaf), 3);

                            /** Fin Grupo * */
                            /** Carrera * */
                            //consulta en el historico para una pregunta de total de encuesta por instrumento
                            $Numeroregistroscarrera = consultahistorico($db, $datos, $listapregunta['idsiq_Apregunta'], 'TotalEncuesta', 'Carrera');
                            if ($Numeroregistroscarrera['IdInformeEvaluacioDocenteHistorico'] <> null) {
                                $mediacarrera = $Numeroregistroscarrera['Media'];
                                $participantescarrera = $Numeroregistroscarrera['Participantes'];
                                $desviacioncarrera = $Numeroregistroscarrera['DesviacionEstandar'];
                            } else {
                                $mediacarrera = 0;
                                $participantescarrera = 0;
                                $desviacioncarrera = 0;
                            }
                            /** Fin carrera * */
                            /**  Institucional * */
                            //consulta en el historico para una pregunta de total de encuesta por instrumento
                            $Numeroregistrosinstitucionales = consultahistorico($db, $datos, $listapregunta['idsiq_Apregunta'], 'TotalEncuesta', null);
                            if ($Numeroregistrosinstitucionales['IdInformeEvaluacioDocenteHistorico'] <> null) {
                                $mediainstitucional = $Numeroregistrosinstitucionales['Media'];
                                $participantesinstitucional = $Numeroregistrosinstitucionales['Participantes'];
                                $desviacioninstitucional = $Numeroregistrosinstitucionales['DesviacionEstandar'];
                            } else {
                                $mediainstitucional = 0;
                                $participantesinstitucional = 0;
                                $desviacioninstitucional = 0;
                            }
                            /** Fin institucional * */
                            $html .= "<tr style='background-color: #d1cfd0'>";
                            $html .= "<td style='border: 1px solid black;'><b>Factor</b></td>";
                            $html .= "<td style='border: 1px solid black;'><b>" . $titulo1 . "</b></td>";
                            $html .= "<td align='center' style='border: 1px solid black;'><b>" . number_format($mediaf, 3, ',', '') . "</b></td>";
                            $html .= "<td align='center' style='border: 1px solid black;'><b>" . number_format($desviacionl, 3, ',', '') . "</b></td>";
                            $html .= "<td align='center' style='border: 1px solid black;'><b>" . number_format($mediacarrera, 3, ',', '') . "</b></td>";
                            $html .= "<td align='center' style='border: 1px solid black;'><b>" . number_format($desviacioncarrera, 3, ',', '') . "</b></td>";
                            $html .= "<td align='center' style='border: 1px solid black;'><b>" . number_format($mediainstitucional, 3, ',', '') . "</b></td>";
                            $html .= "<td align='center' style='border: 1px solid black;'><b>" . number_format($desviacioninstitucional, 3, ',', '') . "</b></td>";
                            $html .= "</tr>";
                        }

                        /** Fin Total encuesta * */
                    } else {
                        //funcion que obtiene las observaciones de una pregunta y un isntruemto
                        $observaciones = consultarobservaciones($db, $datos, $listapregunta['idsiq_Apregunta']);
                        $html .= "<tr>";
                        $html .= "<td style='border: 1px solid black;' colspan='2'>" . strip_tags($listapregunta['titulo'], '<br><span style>') . "</td>";
                        $html .= "<td style='border: 1px solid black;' colspan='6' style='text-align:left;'>" . $observaciones . "</td>";
                        $html .= "</tr>";
                    }
                }
                echo $html;
            }break;
        case 'ConsultarPeriodo': {
                //consulta los periodos academicos en los cuales se encuentren instrumentos de evaluacion docente activos y finalizados
                $sql = "select p.codigoperiodo, p.nombreperiodo " .
                        " from  periodo p, " .
                        " siq_Ainstrumentoconfiguracion s " .
                        " where p.codigoperiodo >= 20182  " .
                        " and s.cat_ins = 'Edocentes' AND s.codigoestado = '100' " .
                        " and s.estado = 1 and s.fecha_inicio >= p.fechainicioperiodo " .
                        " and s.fecha_fin <= p.fechavencimientoperiodo " .
                        " and s.fecha_fin < now() " .
                        " Group BY p.codigoperiodo desc";
                $periodos = $db->GetAll($sql);

                $html .= "<select id='codigoperiodo' name='codigoperiodo' class='form-control'><option value='0'>Seleccion</option>";
                foreach ($periodos as $listado) {
                    $html .= "<option value='" . $listado['codigoperiodo'] . "'>" . $listado['nombreperiodo'] . "</option>";
                }
                $html .= "</select>";

                echo $html;
            }break;
        case 'Consultacategoria': {
                //consulta la lista de categorias de instrumentos disponibles
                $sql = "select cat_ins from siq_Ainstrumentoconfiguracion group by cat_ins";
                $categorias = $db->GetAll($sql);

                $html .= "<select id='categoria' name='categoria'  class='form-control'><option value='0'>Seleccion</option>";
                foreach ($categorias as $listado) {
                    $html .= "<option value='" . $listado['cat_ins'] . "'>" . $listado['cat_ins'] . "</option>";
                }
                $html .= "</select>";

                echo $html;
            }break;
        case 'Consultainstrumentos': {
                //consulta los instrumentos que existen por categoria y periodo
                $categoria = $_POST['categoria'];
                $periodo = $_POST['periodo'];

                $sql = "select s.idsiq_Ainstrumentoconfiguracion, s.nombre from siq_Ainstrumentoconfiguracion s where cat_ins = '" . $categoria . "' " .
                        " AND s.codigoestado = '100' and s.estado = 1 and s.fecha_inicio >= (select fechainicioperiodo from periodo where codigoperiodo = '" . $periodo . "') " .
                        " AND s.fecha_fin <= (select fechavencimientoperiodo from periodo where codigoperiodo = '" . $periodo . "')";
                $instrumento = $db->GetAll($sql);

                $html .= "<select id='instrumento' name='instrumento' class='form-control'><option value='0'>Seleccion</option>";
                foreach ($instrumento as $listado) {
                    $html .= "<option value='" . $listado['idsiq_Ainstrumentoconfiguracion'] . "'>" . $listado['nombre'] . "</option>";
                }
                $html .= "</select>";

                echo $html;
            }break;
        case 'participantesprograma': {
                //consulta los participantes por programa
                $datos['idInstrumento'] = $_POST['id'];
                $datos['periodo'] = $_POST['periodo'];
                $datos['carrera'] = $_POST['carrera'];
                $datos['grupo'] = $_POST['grupo'];
                $datos['nombrecarrera'] = $_POST['nombrecarrera'];

                //consulta las preguntas de un instrumento
                $preguntas = queryConseguirPreguntas($db, $datos['idInstrumento']);
                //asigna la primera pregunta para referencia de consulta
                $pregunta = $preguntas['0']['idsiq_Apregunta'];
                //grupos validos
                $listaGrupos = gruposValidos($db, $datos);
                $datos['departamento'] = null;

                if (isset($datos['grupo']) && !empty($datos['grupo'])) {
                    $matriculados = consultarmatriculados($db, $datos['grupo']);
                } else {
                    $nomcarrera = explode(" ", $datos['nombrecarrera']);
                    if ($datos['carrera'] > 1) {
                        if (in_array("DEPARTAMENTO", $nomcarrera) || in_array("CURSO", $nomcarrera) || in_array("CENTRO", $nomcarrera)) {
                            $datos['departamento'] = 1;
                            $matriculados = consultarmatriculadosdepartamento_curso($db, $datos);
                        } else {
                            $matriculados = consultarmatriculadosinstitucional($db, $datos);
                        }
                    } else {
                        $matriculados = consultarmatriculadosinstitucional($db, $datos);
                    }
                }

                if ($matriculados == 0) {
                    $participantes = 0;
                    $participacion['porcentaje'] = 0;
                    $participacion['color'] = "";
                    $participacion['porcentajeparticipacion'] = 0;
                } else {
                    $Numeroregistros = consultarpromedio($db, $datos, $pregunta, $listaGrupos);
                    if (!empty($Numeroregistros['cantidad'])) {
                        $participantes = $Numeroregistros['cantidad'];
                    } else {
                        $participantes = '0';
                    }
                    $participacion = reglaparticipacion($participantes, $matriculados);
                }

                $html .= "<tr>";
                $html .= "<td>" . $matriculados . "</td>";
                $html .= "<td>" . $participantes . "</td>";
                $html .= "<td>" . $participacion['porcentaje'] . "</td>";
                $html .= "<td " . $participacion['color'] . ">" . $participacion['porcentajeparticipacion'] . "</td>";
                $html .= "</tr>";
                echo $html;
            }break;
        case 'participacionestudiante': {
                //consulta datos del participante
                $datos['idInstrumento'] = $_POST['instrumento'];
                $datos['periodo'] = $_POST['periodo'];
                $datos['carrera'] = $_POST['carrera'];
                $datos['idusuario'] = $_POST['idusuario'];
                $datos['categoria'] = $_POST['categoria'];
                $textoparticipacion = "";

                $participacion = validarparticipacion($db, $datos);
                $resultado = estudiante($db, $datos['idusuario']);
                $datoscarrera = carrera($db, $datos['carrera']);
                $detallesinstrumento = detallesinstrumento($db, $datos['idInstrumento']);
                $html = "";
                $html .= "<tr><td><img src='../../../../sala/assets/images/logo.png'><img src='../../../../sala/assets/images/logoPequeno.png'></td></tr>";

                if ($participacion == true) {
                    $textoparticipacion = "Participo en la encuesta";
                    $html .= "<tr align='center'><td>La Universidad El Bosque certifica que el estudiante</td></tr>";
                    $html .= "<tr align='center'><td><strong>" . $resultado['nombresestudiantegeneral'] . " " . $resultado['apellidosestudiantegeneral'] . "</strong></td></tr>";
                    $html .= "<tr align='center'><td>del programa académico <strong>" . $datoscarrera['nombrecarrera'] . "</strong></td></tr>";
                    $html .= "<tr align='center'><td>" . $textoparticipacion . "</td></tr>";
                    $html .= "<tr align='center'><td>" . $detallesinstrumento['nombre'] . "</td></tr>";
                    $html .= "<tr align='center'><td>Entre las fechas <strong>" . $detallesinstrumento['fecha_inicio'] . "</strong> y <strong>" . $detallesinstrumento['fecha_fin'] . "</strong></td></tr>";
                } else {
                    $textoparticipacion = "No se encontró registro de participación en la encuesta seleccionada";
                    $html .= "<tr align='center'><td>" . $textoparticipacion . "</td></tr>";
                }

                $val = true;

                $data['tabla'] = $html;
                $data['val'] = $val;
                echo json_encode($data);
            }break;
        case 'listaEstudiantesGrupoMateria': {
                //consulta datos del participante
                $pregunta = $_POST['pregunta'];
                $datos['idInstrumento'] = $_POST['idInstrumento'];
                $datos['periodo'] = $_POST['periodo'];
                $datos['carrera'] = $_POST['carrera'];
                $datos['grupo'] = $_POST['grupo'];
                $textoparticipacion = "";

                $listado = verEstudiantesGrupoMateria($db, $datos, $pregunta);

                $html = "<center>";
                $html .= "<table>";
                $html .= "<thead>";
                $html .= "<tr style='background-color: #d1cfd0'>";
                $html .= "<th class='text-center' style='border: 1px solid black;'>#</th>";
                $html .= "<th class='text-center' style='border: 1px solid black;'>Documento</th>";
                $html .= "<th class='text-center' style='border: 1px solid black;'>Apellidos</th>";
                $html .= "<th class='text-center' style='border: 1px solid black;'>Nombres</th>";
                $html .= "<th class='text-center' style='border: 1px solid black;'>Valor</th>";
                $html .= "</tr>";
                $html .= "</thead>";
                $html .= "<tbody>";
                $i = 1;
                foreach ($listado as $lista) {
                    $html .= "<tr>";
                    $html .= "<td align='center' style='border: 1px solid black;'>" . $i . "</td>";
                    $html .= "<td align='center' style='border: 1px solid black;'>" . $lista['numerodocumento'] . "</td>";
                    $html .= "<td align='center' style='border: 1px solid black;'>" . $lista['apellidosestudiantegeneral'] . "</td>";
                    $html .= "<td align='center' style='border: 1px solid black;'>" . $lista['nombresestudiantegeneral'] . "</td>";
                    $html .= "<td align='center' style='border: 1px solid black;'>" . $lista['valor'] . "</td>";
                    $html .= "</tr>";
                    $i++;
                }
                $html .= "</tbody>";
                $html .= "</table>";
                $html .= "</center>";

                echo $html;
            }break;
        case 'NombrePeriodo': {
                $sql = "select p.codigoperiodo, p.nombreperiodo " .
                        " from  periodo p " .
                        " where p.codigoperiodo = '" . $_POST['codigoperiodo'] . "'  ";
                $periodo = $db->GetRow($sql);

                $html .= $periodo['nombreperiodo'];

                echo $html;
            }break;
        case 'NombreInstrumento': {
                $sql = "select s.idsiq_Ainstrumentoconfiguracion, s.nombre " .
                        "from siq_Ainstrumentoconfiguracion s " .
                        "where s.idsiq_Ainstrumentoconfiguracion = '" . $_POST['instrumento'] . "' ";
                $instrumento = $db->GetRow($sql);

                $nombre = strip_tags($instrumento['nombre']);
                $html .= $nombre;

                echo $html;
            }break;
        case 'NombreCarrera': {
                $nombrecarrera = carrera($db, $_POST['carrera']);

                $html .= $nombrecarrera['nombrecarrera'];

                echo $html;
            }break;
        case 'NombreDocente': {
                $sqldocente = "select d.numerodocumento, d.apellidodocente, d.nombredocente " .
                        " from docente d " .
                        " where d.numerodocumento =  " . $_POST['docente'];
                $docente = $db->GetRow($sqldocente);

                $html .= "<b>" . $docente['apellidodocente'] . " " . $docente['nombredocente'] . "</b>";

                echo $html;
            }break;
        case 'NombreGrupo': {
                $sqlgrupo = "SELECT g.idgrupo, g.nombregrupo, m.nombremateria FROM grupo g " .
                        " INNER JOIN materia m on (g.codigomateria = m.codigomateria) " .
                        " where g.idgrupo = " . $_POST['grupo'];
                $grupo = $db->GetRow($sqlgrupo);

                $html .= "<b>" . $grupo['nombregrupo'] . " - " . $grupo['idgrupo'] . " - " . $grupo['nombremateria'] . "</b>";

                echo $html;
            }break;
    }
}

function buscar_idpregunta($arreglo, $search) {
    $keys = array();
    foreach ($arreglo as $key => $row) {
        if ($row["idsiq_Apregunta"] == $search) {
            array_push($keys, $key);
        }
    }
    if (count($keys) > 0) {
        return $keys;
    } else {
        return false;
    }
}

function convertirArreglo($arreglo) {
    $arregloResultado = array();
    foreach ($arreglo as $key => $row) {
        $arregloResultado[$row["idsiq_Apregunta"]][] = $row;
    }
    return $arregloResultado;
}

function calcularEdad($birthday) {
    $age = strtotime($birthday);

    if ($age === false) {
        return false;
    }

    list($y1, $m1, $d1) = explode("-", date("Y-m-d", $age));

    $now = strtotime("now");

    list($y2, $m2, $d2) = explode("-", date("Y-m-d", $now));

    $age = $y2 - $y1;

    if ((int) ($m2 . $d2) < (int) ($m1 . $d1))
        $age -= 1;

    return $age;
}

function queryConseguirPreguntas($db, $idInstrumento) {

    $sql_pre = "SELECT pr.titulo, pr.idsiq_Atipopregunta, pr.idsiq_Apregunta, con.nombre, s.nombre as 'seccion' " .
            " FROM siq_Ainstrumento as ins " .
            " inner join siq_Apregunta as pr on (pr.idsiq_Apregunta=ins.idsiq_Apregunta)" .
            " inner join siq_Ainstrumentoconfiguracion as con on (ins.idsiq_Ainstrumentoconfiguracion=con.idsiq_Ainstrumentoconfiguracion) " .
            " INNER JOIN siq_Aseccion AS s ON (s.idsiq_Aseccion = ins.idsiq_Aseccion) " .
            " where ins.codigoestado=100  " .
            " and pr.codigoestado=100 and ins.idsiq_Ainstrumentoconfiguracion='" . $idInstrumento . "' order by ins.idsiq_Aseccion, ins.orden asc";
    $data_pre = $db->GetAll($sql_pre);
    return $data_pre;
}

function concatenaConsulta($datos, $sqlgrupo, $sqlcarrera, $pregunta) {
    $sqlconcatena = " 
	FROM prematricula pm
	INNER JOIN estudiante e ON ( pm.codigoestudiante = e.codigoestudiante )
	INNER JOIN estudiantegeneral eg ON ( e.idestudiantegeneral = eg.idestudiantegeneral )
	INNER JOIN usuario u ON ( eg.numerodocumento = u.numerodocumento AND u.codigoestadousuario = 100 AND u.codigotipousuario = 600 )
        INNER JOIN detalleprematricula dtpr ON ( dtpr.idprematricula = pm.idprematricula AND dtpr.codigoestadodetalleprematricula = 30)
	INNER JOIN siq_Arespuestainstrumento sri ON ( sri.usuariocreacion = u.idusuario AND dtpr.idgrupo = sri.idgrupo AND sri.codigoestado = 100 )
	INNER JOIN siq_Apreguntarespuesta spr ON ( sri.idsiq_Apreguntarespuesta = spr.idsiq_Apreguntarespuesta AND spr.valor BETWEEN 1 AND 5  ) 
	WHERE 1 " . $sqlgrupo . " AND pm.codigoperiodo = " . $datos['periodo'] . "  AND sri.idsiq_Apregunta IN (" . $pregunta . ") 
	AND sri.usuariocreacion <> 'null'  AND sri.idgrupo <> 'null'  AND pm.codigoestadoprematricula IN ( 40, 41 ) 
	AND sri.idsiq_Ainstrumentoconfiguracion = " . $datos['idInstrumento'] . " " . $sqlcarrera . "
	GROUP BY sri.usuariocreacion, sri.idsiq_Apregunta ";
    return $sqlconcatena;
}

//funcion para obetner el promedio de un total de valores de evaluacion de asignaturas
function consultarpromedio($db, $datos, $pregunta, $listaGrupos) {
    if ($datos['departamento'] <> null) {
        $sqlcarrera = "";
        $sqlgrupo = " and sri.idgrupo IN ($listaGrupos) ";
    } else {
        if (isset($datos['grupo']) && $datos['grupo'] <> null) {
            $sqlgrupo = " and sri.idgrupo = " . $datos['grupo'];
            $sqlcarrera = "";
        } else {
            if ($datos['carrera'] > 1) {
                $sqlcarrera = " and e.codigocarrera = " . $datos['carrera'];
                $sqlgrupo = "and sri.idgrupo IN ($listaGrupos) ";
            } else {
                $sqlcarrera = "";
                $sqlgrupo = "and sri.idgrupo IN ($listaGrupos) ";
            }
        }
    }

    $concatenado = concatenaConsulta($datos, $sqlgrupo, $sqlcarrera, $pregunta);

    $sqlcantidadregistros = "SELECT sum( A.cnt ) AS cantidad, avg( A.pm ) AS promedio FROM (
    SELECT count( DISTINCT ( sri.usuariocreacion ) ) AS cnt, avg( spr.valor ) AS pm ";
    $sqlcantidadregistros .= $concatenado;
    $sqlcantidadregistros .= ") AS A";
    $Registros = $db->GetRow($sqlcantidadregistros);
    return $Registros;
}

function gruposValidos($db, $datos) {
    
    $nomcarrera = explode(" ", $datos['nombrecarrera']);    
    if ($datos['carrera'] > 1) {
        $sqlcarrera = " AND m.codigocarrera = " . $datos['carrera'];
        if (in_array("DEPARTAMENTO", $nomcarrera) || in_array("CURSO", $nomcarrera) || in_array("CENTRO", $nomcarrera)) {
            $datos['departamento'] = 1;
        }
    } else {
        $sqlcarrera = "";
    }
    //consulta de grupos validos que se hayan tenido estudiantes matriculados
    $sqlGruposValidosInt = "SELECT g.idgrupo FROM grupo g
    INNER JOIN materia m ON (g.codigomateria = m.codigomateria) 
    INNER JOIN detalleprematricula dtpr ON (dtpr.idgrupo=g.idgrupo)
    WHERE g.codigoperiodo =" . $datos['periodo'] . " 
    AND g.codigoestadogrupo = 10
    $sqlcarrera
    AND dtpr.codigoestadodetalleprematricula=30
    GROUP BY dtpr.idgrupo";
    $nRegistros = $db->GetAll($sqlGruposValidosInt);
    $concatStrGroup = '';
    foreach ($nRegistros as $grupo) {
        $concatStrGroup .= $grupo['idgrupo'] . ',';
    }
    $strGroup = substr($concatStrGroup, 0, -1);

    //consulta las preguntas de un instrumento
    $preguntas = queryConseguirPreguntas($db, $datos['idInstrumento']);
    //asigna la primera pregunta para referencia de consulta
    $pregunta = $preguntas['0']['idsiq_Apregunta'];

    //consulta de grupos validos que participaron en la evaluacion
    $sqlGruposValidos = "SELECT idgrupo FROM siq_Arespuestainstrumento 
    WHERE  idsiq_Ainstrumentoconfiguracion=" . $datos['idInstrumento'] . "
    AND idgrupo IN ($strGroup) 
    AND codigoestado=100
    GROUP BY idgrupo";
    $nuRegistros = $db->GetAll($sqlGruposValidos);
    $concatStrGroupG = '';
    foreach ($nuRegistros as $grupo) {
        $Numeroregistros = consultarpromedio($db, $datos, $pregunta, $grupo['idgrupo']);
        if (!empty($Numeroregistros['cantidad'])) {
            $matriculados = consultarmatriculados($db, $grupo['idgrupo']);
            $participacion = reglaparticipacion($Numeroregistros['cantidad'], $matriculados);
            if ($participacion['valido'] == '1') {
                $concatStrGroupG .= $grupo['idgrupo'] . ',';
            }
        }
    }
    $strGroupG = substr($concatStrGroupG, 0, -1);
    return $strGroupG;
}

function verEstudiantesGrupoMateria($db, $datos, $pregunta) {
    if (isset($datos['grupo']) && $datos['grupo'] <> null) {
        $sqlgrupo = " and sri.idgrupo = " . $datos['grupo'];
        $sqlcarrera = "";
    }
    $concatenado = concatenaConsulta($datos, $sqlgrupo, $sqlcarrera, $pregunta);
    $sqlcantidadregistros = "
	SELECT eg.numerodocumento
        , eg.apellidosestudiantegeneral
        , eg.nombresestudiantegeneral   
        , spr.valor ";
    $sqlcantidadregistros .= $concatenado;
    $sqlcantidadregistros .= "ORDER BY eg.apellidosestudiantegeneral ";
    $Registros = $db->GetAll($sqlcantidadregistros);

    return $Registros;
}

function pintarInformacionDemografica($db, $dt_res, $idInstrumento) {
    //para los estudiantes de medicina
    $sql_estudiante = "select porcentajedetalleadmision,totalpreguntasdetalleadmision,resultadodetalleestudianteadmision,codigotipodetalleadmision from estudianteadmision ea 
    INNER JOIN detalleadmision da on da.idadmision=ea.idadmision 
    LEFT JOIN detalleestudianteadmision dea on dea.idestudianteadmision=ea.idestudianteadmision and da.iddetalleadmision=dea.iddetalleadmision
    where ea.codigoestudiante='" . $dt_res['codigoestudiante'] . "' AND ea.codigoestadoestudianteadmision IN (100,101,102,300)
    ORDER BY ea.codigoestadoestudianteadmision ASC";
    $data_estudiante = $db->Execute($sql_estudiante);
    $estudianteAdmision = $data_estudiante->GetArray();
    $relacionAdmision = 0;
    $puntajeExamenAdmision = "";
    $relacionEntrevista = 0;
    $puntajeEntrevista = "";
    $relacionIcfes = 0;
    foreach ($estudianteAdmision as $datos_admision) {
        if ($datos_admision["codigotipodetalleadmision"] == 1) {
            $puntajeExamenAdmision = $datos_admision["resultadodetalleestudianteadmision"];
            $relacionAdmision = ($puntajeExamenAdmision * $datos_admision["porcentajedetalleadmision"]) / $datos_admision["totalpreguntasdetalleadmision"];
        } else if ($datos_admision["codigotipodetalleadmision"] == 3) {
            $puntajeEntrevista = $datos_admision["resultadodetalleestudianteadmision"];
            $relacionEntrevista = ($puntajeEntrevista * $datos_admision["porcentajedetalleadmision"]) / $datos_admision["totalpreguntasdetalleadmision"];
        } else if ($datos_admision["codigotipodetalleadmision"] == 4) {
            $relacionIcfes = ($datos_admision["porcentajedetalleadmision"]) / $datos_admision["totalpreguntasdetalleadmision"];
        }
    }

    $sql_icfes = "SELECT SUM(dr.notadetalleresultadopruebaestado) as valor_total, COUNT(rp.idresultadopruebaestado) as num_materias
    FROM resultadopruebaestado rp, detalleresultadopruebaestado dr, asignaturaestado ae, estudiante e
    WHERE
    e.codigoestudiante='" . $dt_res['codigoestudiante'] . "'
    AND e.idestudiantegeneral = rp.idestudiantegeneral
    AND dr.idresultadopruebaestado = rp.idresultadopruebaestado
    AND dr.idasignaturaestado = ae.idasignaturaestado
    AND ae.codigoestado like '1%'";
    $data_icfes = $db->GetRow($sql_icfes);
    $puntajeIcfes1 = number_format((float) ($data_icfes["valor_total"] / $data_icfes["num_materias"]), 2, '.', '');
    $relacionIcfes = $relacionIcfes * $puntajeIcfes1;
    $puntajeTotalAdmision = number_format((float) ($relacionAdmision + $relacionEntrevista + $relacionIcfes), 2, '.', '');

    $sql_colegio = "SELECT n.nombrenaturaleza,e.codigoestudiante,
    if(ie.idinstitucioneducativa=1,ee.otrainstitucioneducativaestudianteestudio,ie.nombreinstitucioneducativa) nombreinstitucion FROM
    institucioneducativa ie, 
    estudianteestudio ee, 
    estudiantegeneral eg,
    estudiante e,
    naturaleza n
    WHERE
    e.codigoestudiante='" . $dt_res['codigoestudiante'] . "'
    AND e.idestudiantegeneral=eg.idestudiantegeneral
    AND ee.idestudiantegeneral=e.idestudiantegeneral
    AND ee.idinstitucioneducativa = ie.idinstitucioneducativa
    AND n.codigonaturaleza=ie.codigonaturaleza 
    AND ie.codigomodalidadacademica='100'
    and (ee.idniveleducacion='2' or ie.codigomodalidadacademica='100')";
    $data_colegio = $db->GetRow($sql_colegio);
    $colegio = $data_colegio["nombrenaturaleza"];

    $sql_publico = "select dao.* from siq_Apublicoobjetivo ao 
    INNER JOIN siq_Adetallepublicoobjetivo dao on dao.idsiq_Apublicoobjetivo=ao.idsiq_Apublicoobjetivo
    where idsiq_Ainstrumentoconfiguracion='" . $idInstrumento . "' and dao.codigoestado=100 and codigocarrera IS NOT NULL 
    and filtro=2 and semestre<>99";
    $data_publico = $db->GetRow($sql_publico);
    $materias1 = $data_publico["cadena"];
    $materias = explode("::", $materias1);

    $semestre = $data_publico["semestre"];
    $asignatura = "";
    $codigos = "";
    foreach ($materias as $materia) {
        $sql_materia = "SELECT nombremateria FROM materia where codigomateria=" . $materia;
        $data_mat = $db->GetRow($sql_materia);
        if ($asignatura !== "") {
            $asignatura .= ";" . $data_mat["nombremateria"];
            $codigos .= "," . $materia;
        } else {
            $asignatura .= $data_mat["nombremateria"];
            $codigos .= $materia;
        }
    }
    $sql_nota = "SELECT notadefinitiva FROM notahistorico where codigomateria IN (" . $codigos . ") AND codigoestudiante=" . $dt_res['codigoestudiante'];
    $data_nota = $db->GetAll($sql_nota);
    $nota = "";
    foreach ($data_nota as $grade) {
        if ($asignatura !== "") {
            $nota .= ";" . $grade["notadefinitiva"];
        } else {
            $nota .= $grade["notadefinitiva"];
        }
    }
    $nota = $data_nota[0]["notadefinitiva"];
    ?>
    <td><?php echo $colegio; ?></td>
    <td><?php echo $puntajeTotalAdmision; ?></td>
    <td><?php echo $puntajeIcfes1; ?></td>
    <td><?php echo $puntajeExamenAdmision; ?></td>
    <td><?php echo $puntajeEntrevista; ?></td>
    <td><?php echo $semestre; ?></td>
    <td><?php echo $asignatura; ?></td>
    <td><?php echo $nota; ?></td>
    <?php
}

function convertirArregloRespuestasInstrumento($arreglo) {
    $arregloResultado = array();
    foreach ($arreglo as $key => $row) {
        if ($row["cedula"] != null) {
            $arregloResultado[$row["cedula"]][$row["idsiq_Apregunta"]][] = $row;
        } else {
            $arregloResultado[$row["usuariocreacion"]][$row["idsiq_Apregunta"]][] = $row;
        }
    }
    return $arregloResultado;
}

function pintarResultados($db, $data_res, $idInstrumento, $data_pre) {

    $sql_res = "SELECT res.idsiq_Arespuestainstrumento, res.idsiq_Apregunta, res.idsiq_Apreguntarespuesta,res.preg_abierta,respuesta, valor, res.cedula,res.usuariocreacion  
    FROM siq_Arespuestainstrumento as res inner join siq_Apreguntarespuesta pr on pr.idsiq_Apreguntarespuesta =res.idsiq_Apreguntarespuesta 
    WHERE res.idsiq_Ainstrumentoconfiguracion='" . $idInstrumento . "' and res.codigoestado='100'";
    $respuestas = $db->GetAll($sql_res);
    $respuestasFinales = convertirArregloRespuestasInstrumento($respuestas);
    $respuestas = null;
    unset($respuestas);
    foreach ($data_res as $dt_res) {//pinta los resultados
        $cedula = $dt_res['cedula'];
        $usuario = $dt_res['usuariocreacion'];
        $nombrerol = $dt_res['nombrerol'];
        $edad = "";
        $unidad = $dt_res["unidad"];
        if (!empty($dt_res['nombrecarrera'])) {
            $unidad = $dt_res['nombrecarrera'];
        }
        ?>
        <tr>
            <?php
            if (empty($usuario) || !empty($cedula)) {
                $tit = $cedula;
            } else {
                $sql_user = "select numerodocumento from usuario where idusuario='" . $usuario . "' ";
                $data_user = $db->Execute($sql_user);
                $C_User = $data_user->GetArray();
                $tit = $C_User[0]['numerodocumento'];
            }
            //si son externos y tienen area funcional, mandar como anonimos
            if (!empty($dt_res['unidad'])) {
                $tit = "";
            }
            ?>
            <td><?php echo $tit ?></td><!--pinta el numero de documento-->
            <?php
            if (!empty($nombrerol)) {//pinta el tipo de participante
                ?>
                <td><?php echo $nombrerol; ?></td>
                <?php
            } else {
                ?>
                <td>&nbsp;</td>
                <?php
            }
            ?>
            <td><?php echo utf8_decode($unidad); ?></td>
            <?php
            if (!empty($dt_res['fecha_nacimiento'])) {
                $edad = calcularEdad($dt_res['fecha_nacimiento']);
                ?>
                <td><?php echo $edad; ?></td>
                <td><?php echo $dt_res['nombregenero']; ?></td>
                <?php
            } else {
                if (!empty($dt_res['area'])) {
                    ?>
                    <td><?php echo utf8_decode($dt_res['area']); ?></td>
                    <td>&nbsp;</td>
                    <?php
                } else {
                    for ($i = 0; $i < 2; $i++) {//las variables
                        ?>
                        <td>&nbsp;</td>
                        <?php
                    }
                }
            }

            $idusuario_respuesta = "";
            if (!empty($cedula) && isset($respuestasFinales[$cedula]) && count($respuestasFinales[$cedula]) > 0) {
                $idusuario_respuesta = $cedula;
            } else {
                $idusuario_respuesta = $usuario;
            }
            
            pintarInformacionDemografica($db, $dt_res, $idInstrumento);
            
            if (!empty($cedula) && $cedula != 0 && !empty($usuario)) {//si busca por la cedula el el usuario de creacion
                $whe = " and ( res.cedula='" . $cedula . "' or res.usuariocreacion='" . $usuario . "' )";
            } else if (!empty($usuario)) {
                $whe = " and res.usuariocreacion='" . $usuario . "' ";
            } else {
                $whe = " and res.cedula='" . $cedula . "' ";
            }

            foreach ($data_pre as $dt) {
                $resp = $respuestasFinales[$idusuario_respuesta][$dt["idsiq_Apregunta"]];
                if ($resp !== false) {
                    $can = count($resp);

                    if ($can == 0) {
                        echo "<td>&nbsp;</td>";
                    } else if ($can == 1) {
                        $respu = $resp[0]['idsiq_Apreguntarespuesta'];
                        $preg_abierta = $resp[0]['preg_abierta'];
                        $respuesta = $resp[0]['respuesta'];
                        $Valor = $resp[0]['valor'];
                        echo "<td>" . $Valor . "</td>";
                    } else {
                        $res_mul = '';
                        //si es de Ãºnica selecciÃ³n, muestro la Ãºltima solamente
                        if ($dt["idsiq_Atipopregunta"] == 1 || $dt["idsiq_Atipopregunta"] == 2) {
                            echo "<td>" . $resp[$can - 1]['valor'] . "</td>";
                        } else {
                            for ($j = 0; $j < $can; $j++) {
                                if ($j == 0)
                                    $res_mul = $resp[$j]['valor'];
                                if ($j > 0)
                                    $res_mul .= ',' . $resp[$j]['valor'];
                            }
                            echo "<td>" . $res_mul . "</td>";
                        }
                    }
                } else {
                    echo "<td>&nbsp;</td>";
                }
            }
            echo "</tr>";
        }
    }

    function convertirArregloRespuestasInstrumentoOptimizadoMemoria($arreglo) {
        $arregloResultado = array();
        foreach ($arreglo as $key => $row) {

            if ($row["cedula"] != null) {
                $arregloResultado[$row["cedula"]][$row["idsiq_Apregunta"]][] = array("preg_abierta" => $row["preg_abierta"], "respuesta" => $row["respuesta"],
                    "valor" => $row["valor"], "fechamodificacion" => $row["fechamodificacion"], "multiple_respuesta" => $row["multiple_respuesta"]);
            } else {
                $arregloResultado[$row["usuariocreacion"]][$row["idsiq_Apregunta"]][] = array("preg_abierta" => $row["preg_abierta"], "respuesta" => $row["respuesta"],
                    "valor" => $row["valor"], "fechamodificacion" => $row["fechamodificacion"], "multiple_respuesta" => $row["multiple_respuesta"]);
            }
        }
        return $arregloResultado;
    }

    function pintarDiaHora($db, $idGrupo) {
        $sql_dh = 'SELECT d.nombredia ,h.horainicial ,h.horafinal
    FROM horario h
    INNER JOIN dia d ON d.codigodia=h.codigodia
    WHERE h.idgrupo="' . $idGrupo . '"
    AND h.codigoestado = 100 ';
        $rtas = $db->GetAll($sql_dh);
        return $rtas;
    }

    function pintarResultadosEvaluacionDocentes($db, $data_res, $idInstrumento, $data_pre, $regPag = null, $pag = null, $totalPaginas = null) {
        //comillas simples son mas rapidas que dobles
        $sql_res = 'SELECT res.idsiq_Apregunta, res.preg_abierta,respuesta, valor, res.cedula,
	res.usuariocreacion,res.fechamodificacion,  pr.multiple_respuesta  
        FROM siq_Arespuestainstrumento as res 
        LEFT JOIN siq_Apreguntarespuesta pr on pr.idsiq_Apreguntarespuesta =res.idsiq_Apreguntarespuesta 
        WHERE res.idsiq_Ainstrumentoconfiguracion="' . $idInstrumento . '" and res.codigoestado="100" 
        AND (res.cedula IS NOT NULL OR res.usuariocreacion IS NOT NULL) ';
        //Se crea este foreach para que concatene los 'usuariocreacion' generados en la anterior consulta
        $userc = array();
        foreach ($data_res as $dt_resp) {//pinta los resultados
            $userc[] = $dt_resp['usuariocreacion'];
        }
        //Se crea este array_unique() para que resuma los 'usuariocreacion' y no consuma muchos recursos
        $uusuarioc = array_unique($userc);
        $usuarioc = implode(",", $uusuarioc);
        $sql_res .= 'AND res.usuariocreacion IN(' . $usuarioc . ') ';
        $sql_res .= 'ORDER BY res.usuariocreacion,res.fechamodificacion ASC';
        $respuestas = $db->GetAll($sql_res);
        //como no voy a alterar respuestas => menor consumo de memoria si lo paso por referencia
        $respuestasFinales = convertirArregloRespuestasInstrumentoOptimizadoMemoria($respuestas);

        $respuestas = null;
        unset($respuestas);

        $tt = $pag * $regPag;
        $tat = $regPag - 1;
        $tet = $tt - $tat;

        $h = $tet;
        foreach ($data_res as $dt_res) {//pinta los resultados
            $to_time = strtotime($dt_res["FechaUltimaModificacion"]);

            $cedula = $dt_res['cedula'];
            $usuario = $dt_res['usuariocreacion'];
            $unidad = $dt_res["unidad"];
            if (!empty($dt_res['nombrecarrera'])) {
                $unidad = $dt_res['nombrecarrera'];
            }
            ?>
        <tr>
            <td><?php echo $h; ?></td>
            <td><?php echo $dt_res['codigocarrera']; ?></td>
            <td><?php echo $dt_res['nombrecarrera']; ?></td>
            <td><?php echo $dt_res['FechaUltimaModificacion']; ?></td>
            <td><?php echo $dt_res['codigomateria']; ?></td>
            <td><?php echo $dt_res['nombremateria']; ?></td>
            <td><?php echo $dt_res['nombretipomateria']; ?></td>
            <td><?php echo $dt_res['1']; ?></td>
            <td><?php echo $dt_res['nombregrupo']; ?></td>
            <td><?php echo $dt_res['idgrupo']; ?></td>
            <?php
            $rtas = pintarDiaHora($db, $dt_res['idgrupo']);
            if (empty($rtas)) {
                $sdia = "n/a";
                $shini = "n/a";
                $shfin = "n/a";
            } else {
                $dia = "";
                $hini = "";
                $hfin = "";
                //organizacion de dias y  horas
                foreach ($rtas as $rta) {
                    $dia .= $rta['nombredia'] . " / ";
                    $hini .= $rta['horainicial'] . " / ";
                    $hfin .= $rta['horafinal'] . " / ";
                }
                $sdia = substr($dia, 0, -3);
                $shini = substr($hini, 0, -3);
                $shfin = substr($hfin, 0, -3);
            }
            ?>
            <td><?php echo $sdia; ?></td>
            <td><?php echo $shini; ?></td>
            <td><?php echo $shfin; ?></td>

            <td><?php echo $dt_res['documentodocente']; ?></td>
            <td><?php echo $dt_res['nombredocente']; ?></td>
            <td><?php echo $dt_res['documentoestudiante']; ?></td>
            <td><?php echo $dt_res['nombreestudiante']; ?></td>
            <?php
            $idusuario_respuesta = "";
            if (!empty($cedula) && isset($respuestasFinales[$cedula]) && count($respuestasFinales[$cedula]) > 0) {
                $idusuario_respuesta = $cedula;
            } else {
                $idusuario_respuesta = $usuario;
            }

            foreach ($data_pre as $dt) {
                $resp = array();
                $i = 0;
                foreach ($respuestasFinales[$idusuario_respuesta][$dt["idsiq_Apregunta"]] as $resp_row) {
                    $from_time = strtotime($resp_row["fechamodificacion"]);
                    //minutos de diferencia
                    $mins = round(abs($to_time - $from_time) / 60,2);
                    if ($from_time < $to_time) {
                        //no puede demorar + de 60 mins respondiendo esta vaina... no acepta encuesta a medias hasta el momento
                        if ($mins <= 60) {
                            $resp[] = $resp_row;
                        }
                        $respuestasFinales[$idusuario_respuesta][$dt["idsiq_Apregunta"]][$i] = null;
                        unset($respuestasFinales[$idusuario_respuesta][$dt["idsiq_Apregunta"]][$i]);
                    }
                    $i++;
                }
                $respuestasFinales[$idusuario_respuesta][$dt["idsiq_Apregunta"]] = array_values($respuestasFinales[$idusuario_respuesta][$dt["idsiq_Apregunta"]]);

                if ($resp !== false) {
                    $can = count($resp);

                    if ($can === 0) {
                        //ingresa si no encuentra respuestas para ese grupo y ese estudiante
                        echo "<td>n/a</td>";
                    } else if ($can === 1) {
                        $respu = $resp[0]['idsiq_Apreguntarespuesta'];
                        $preg_abierta = $resp[0]['preg_abierta'];
                        $respuesta = $resp[0]['respuesta'];
                        $Valor = $resp[0]['valor'];
                        if (!empty($Valor) and empty($preg_abierta) && $resp[0]["multiple_respuesta"] != 1) {
                            echo "<td>" . $Valor . "</td>";
                        } else if (empty($Valor) and ! empty($preg_abierta)) {
                            echo "<td>" . ($preg_abierta) . "</td>";
                        } else if (!empty($respuesta)) {
                            echo "<td>" . ($respuesta) . "</td>";
                        }
                    } else {
                        $res_mul = '';
                        //si es de Ãºnica selecciÃ³n muestro el Ãºltimo resultado
                        if ($dt["idsiq_Atipopregunta"] == 1 || $dt["idsiq_Atipopregunta"] == 2) {
                            echo "<td>" . $resp[$can - 1]['valor'] . "</td>";
                        } else {
                            $arreglo = array();
                            for ($j = 0; $j < $can; $j++) {
                                $Valor = $resp[$j]['valor'];
                                $respuesta = $resp[$j]['respuesta'];
                                $text = "";
                                if (!empty($Valor) and empty($preg_abierta) && $resp[$j]["multiple_respuesta"] != 1) {
                                    $text = $Valor;
                                } else if (empty($Valor) and ! empty($preg_abierta)) {
                                    $text = $preg_abierta;
                                } else if (!empty($respuesta)) {
                                    $text = $respuesta;
                                    $yaEsta = in_array($respuesta, $arreglo);
                                    if (!$yaEsta) {
                                        $arreglo[] = $respuesta;
                                    }
                                }
                                if (!$yaEsta) {
                                    if ($j == 0)
                                        $res_mul = $text;
                                    if ($j > 0)
                                        $res_mul .= ',' . $text;
                                }
                            }
                            echo "<td>" . $res_mul . "</td>";
                        }
                    }
                } else {
                    echo "<td>n/a</td>";
                }
            }
            echo "<td>" . $dt_res['nombrejornada'] . "</td>";
            echo "</tr>";
            $h++;
        }
        echo "<tr>";
        echo "<td colspan='2'><input class='btn btn-fill-green-XL' type='button' onclick='desiteraPag()' value='<< Anterior'></td>";
        echo "<td colspan='2'><input class='btn btn-fill-green-XL' type='button' onclick='iteraPag()' value='Siguiente >>'></td>";
        echo "<td colspan='2'><input type='hidden' name='pag' id='pag' value='" . $pag . "' readonly>Pagina: " . $pag . "</td>";
        echo "<td colspan='2'><input type='hidden' name='totalPaginas' id='totalPaginas' value='" . $totalPaginas . "' readonly>de: " . $totalPaginas . "</td>";
        echo "</tr>";
    }

//funcion para calcular la desviacion de un promedio
    function desviacion($respuestas, $promedio) {
        $media = $promedio;
        $suma2 = 0;
        //Aplicacion de la formula
        for ($i = 0; $i < count($respuestas); $i++) {
            $suma2 += (($respuestas[$i][0] - $media) * ($respuestas[$i][0] - $media));
        }
        if (count($respuestas) > 0) {
            $varianza = $suma2 / count($respuestas);
        } else {
            $varianza = 0;
        }
        $desviacion = sqrt($varianza);
        return $desviacion;
    }

//function desviacion
//funcion para obtener los valores de las preguntas del instrumento
    function valorespreguntas($db, $datos, $preguntas, $listaGrupos) {

        if ($datos['departamento'] <> null) {
            $sqlcarrera = "";
            $sqlgrupo = " and sri.idgrupo IN ($listaGrupos) ";
        } else {
            if (isset($datos['grupo']) && $datos['grupo'] <> null) {
                $sqlgrupo = " and sri.idgrupo = " . $datos['grupo'];
                $sqlcarrera = "";
            } else {
                if ($datos['carrera'] > 1) {
                    $sqlcarrera = " and e.codigocarrera = " . $datos['carrera'];
                    $sqlgrupo = "and sri.idgrupo IN ($listaGrupos) ";
                } else {
                    $sqlcarrera = "";
                    $sqlgrupo = "and sri.idgrupo IN ($listaGrupos) ";
                }
            }
        }

        $concatenado = concatenaConsulta($datos, $sqlgrupo, $sqlcarrera, $preguntas);

        $sqlrespuestas = " SELECT spr.valor as vl  ";
        $sqlrespuestas .= $concatenado;

        $respuesta = $db->GetAll($sqlrespuestas);
        return $respuesta;
    }

//function valorespreguntas
//funcion para obetener la cantida de matriculados de un grupo
    function consultarmatriculados($db, $grupo) {
        $sql = "select count(*) as cantidad from detalleprematricula " .
                " where idgrupo = " . $grupo . " and codigoestadodetalleprematricula = 30";
        $cantidad = $db->GetRow($sql);
        return $cantidad['cantidad'];
    }

//function consultarmatriculados
//funcion para obtener la cantidad de matriculados institucionales

    function consultarmatriculadosinstitucional($db, $datos) {
        $sqlcarrera = "";
        if ($datos['carrera'] > 1) {
            $sqlcarrera = " and c.codigocarrera =" . $datos['carrera'] . " ";
        }

        $sqlmatriculados = "SELECT count(DISTINCT e.codigoestudiante) as matriculados from  ordenpago o " .
                " INNER JOIN estudiante e on (o.codigoestudiante = e.codigoestudiante) " .
                " INNER JOIN carrera c on (c.codigocarrera = e.codigocarrera) " .
                " INNER JOIN detalleordenpago od on (o.numeroordenpago = od.numeroordenpago) " .
                " where o.codigoperiodo = '" . $datos['periodo'] . "' " .
                " and o.codigoestadoordenpago IN (40, 41) " .
                " and c.codigomodalidadacademica = 200 " .
                " " . $sqlcarrera . " " .
                " and od.codigoconcepto = 151";
        $cantidad = $db->GetRow($sqlmatriculados);
        return $cantidad['matriculados'];
    }

//function consultarmatriculadosinstitucional
//funcion para identificar la cantidad de matriculados de un departamento o curso
    function consultarmatriculadosdepartamento_curso($db, $datos) {
        $sqlcarrera = "";
        if ($datos['carrera'] > 1) {
            $sqlcarrera = "	AND mt.codigocarrera=" . $datos['carrera'];
        }

        $sqlmatriculados = "select count(*) as cantidad from detalleprematricula where idgrupo IN " .
                " (SELECT gr.idgrupo FROM materia mt " .
                " INNER JOIN grupo gr ON gr.codigomateria=mt.codigomateria" .
                " WHERE 1  " . $sqlcarrera . " AND mt.codigoestadomateria=01 " .
                " AND gr.codigoperiodo='" . $datos['periodo'] . "' GROUP BY gr.idgrupo)" .
                " and codigoestadodetalleprematricula = 30";
        $cantidad = $db->GetRow($sqlmatriculados);
        return $cantidad['cantidad'];
    }

//funcion para obtener las observaciones de un grupo para una pregunta
    function consultarobservaciones($db, $datos, $pregunta) {
        $ul = "";
        $sqlcantidadregistros = "select sri.preg_abierta  from prematricula pm " .
                " INNER JOIN estudiante e on (pm.codigoestudiante = e.codigoestudiante) " .
                " INNER JOIN estudiantegeneral eg on (e.idestudiantegeneral = eg.idestudiantegeneral) " .
                " INNER JOIN usuario u on (eg.numerodocumento = u.numerodocumento and u.codigoestadousuario = 100 and u.codigotipousuario = 600) " .
                " INNER JOIN siq_Arespuestainstrumento sri on (sri.usuariocreacion = u.idusuario and sri.codigoestado = 100) " .
                " WHERE  sri.idgrupo = " . $datos['grupo'] . " " .
                " and pm.codigoperiodo = " . $datos['periodo'] . " and sri.idsiq_Apregunta in (" . $pregunta . ") " .
                " and pm.codigoestadoprematricula in (40, 41) AND sri.idsiq_Ainstrumentoconfiguracion = '" . $datos['idInstrumento'] . "' ";
        $resultados = $db->GetAll($sqlcantidadregistros);
        $ul .= "<ul>";
        foreach ($resultados as $listas) {
            $ul .= "<li>" . $listas['preg_abierta'] . "</li>";
        }
        $ul .= "</ul>";
        return $ul;
    }

//funcion para cobtener los registros guardados en el historico de evaluacion de asignaturas
    function consultahistorico($db, $datos, $preguntas, $categoria, $carrera) {
        if ($carrera == 'Carrera') {
            $carrera = $datos['carrera'];
        } else {
            $carrera = 1;
        }
        $sql = "SELECT i.IdInformeEvaluacioDocenteHistorico,  i.Participantes, i.DesviacionEstandar, i.Media " .
                " FROM InformeEvaluacioDocenteHistoricos i " .
                " where i.CodigoPeriodo = " . $datos['periodo'] . " and i.CodigoCarrera = " . $carrera . " and i.Idpregunta = " . $preguntas . " " .
                " and i.idinstrumento = " . $datos['idInstrumento'] . " and i.Categoria = '" . $categoria . "'";
        $buscardatos = $db->GetRow($sql);
        return $buscardatos;
    }

//funcion para crear el registro en el historico de la veluacion de asignaturas
    function registrohistorico($db, $datos, $pregunta, $categoria) {
        $sqlinsert = "INSERT INTO InformeEvaluacioDocenteHistoricos " .
                "(CodigoCarrera, CodigoPeriodo, Media, DesviacionEstandar, Participantes, Idpregunta, FechaCreacion, IdInstrumento, Categoria, UsuarioCreacion) VALUES " .
                "(" . $datos['carrera'] . ", " . $datos['periodo'] . " ,'" . $datos['media'] . "','" . $datos['desviacion'] . "'," . $datos['participantes'] . "," . $pregunta
                . ", now(), " . $datos['idInstrumento'] . ", '" . $categoria . "', " . $datos['idusuario'] . ")";
        $db->Execute($sqlinsert);
    }

//funcion para editar el registro en el historico de la evaluacion de asignaturas
    function editaregistrohistorico($db, $datos, $pregunta, $categoria) {
        $sqlupdate = "UPDATE InformeEvaluacioDocenteHistoricos SET Media='" . $datos['media'] . "', DesviacionEstandar='" . $datos['desviacion'] . "', "
                . "Participantes=" . $datos['participantes'] . ", FechaModificaicon=now(), UsuarioModificacion=" . $datos['idusuario'] . " "
                . "WHERE CodigoCarrera=" . $datos['carrera'] . " AND CodigoPeriodo=" . $datos['periodo'] . " "
                . "AND IdInstrumento=" . $datos['idInstrumento'] . " AND Categoria='" . $categoria . "' AND Idpregunta=" . $pregunta . " ";
        $db->Execute($sqlupdate);
    }

//funcion que obtiene lel nombre y codigo de una carrera
    function infocarrera($db, $grupo) {
        $sql = "select c.codigocarrera, c.nombrecarrera from carrera c 
    INNER JOIN materia m on (m.codigocarrera = c.codigocarrera)
    INNER JOIN grupo g on (g.codigomateria = m.codigomateria)
    where g.idgrupo = " . $grupo . " ";
        $infocarrera = $db->getRow($sql);

        return $infocarrera;
    }

    function instrumentoactivo($db, $periodo) {
        $sqlinstrumento = "SELECT s.idsiq_Ainstrumentoconfiguracion " .
                "FROM siq_Ainstrumentoconfiguracion s " .
                " WHERE s.cat_ins = 'EDOCENTES' " .
                " AND s.codigoestado = 100 " .
                " AND s.fecha_inicio >=  ( SELECT p.fechainicioperiodo FROM periodo p WHERE p.codigoperiodo = '" . $periodo . "') " .
                " AND s.fecha_fin <= ( SELECT p.fechavencimientoperiodo FROM periodo p WHERE p.codigoperiodo = '" . $periodo . "')";
        $id = $db->getRow($sqlinstrumento);

        return $id['idsiq_Ainstrumentoconfiguracion'];
    }

    function reglaparticipacion($participantes, $matriculados) {
        if ($matriculados > 0) {
            switch (true) {
                case ($matriculados > 10): {
                        $porcentaje = '51';
                    }break;
                case ($matriculados >= 4 && $matriculados <= 9): {
                        $porcentaje = '75';
                    }break;
                case ($matriculados < 4): {
                        $porcentaje = '100';
                    }break;
            }

            $porcentajeparticipacion = (($participantes * 100) / $matriculados);
            if (round($porcentajeparticipacion, 2) >= $porcentaje) {
                $color = "style='background-color: #2ED353;'";
                $datos['valido'] = '1';
            } else {
                if (round($porcentajeparticipacion, 2) <= $porcentaje) {
                    $color = "style='background-color: #D3492E;'";
                    $datos['valido'] = '0';
                }
            }
            $datos['porcentaje'] = $porcentaje;
            $datos['color'] = $color;
            $datos['porcentajeparticipacion'] = number_format($porcentajeparticipacion, 2,',','');

            return $datos;
        }
    }

    function dimesionesFactores($db, $instrumento, $pregunta, $categoria) {
        $respuesta['titulo'] = "";
        $respuesta['listapreguntas'] = "";

        $sqldimension = "SELECT d.IdDimensionFactor, d.Nombre FROM DimensionPreguntas dp " .
                " INNER JOIN DimensionesFactores d on (dp.IdDimensionFactor = d.IdDimensionFactor) " .
                " where dp.Instrumento = '" . $instrumento . "' and d.Categoria = '" . $categoria . "' and dp.idsiq_Apregunta = '" . $pregunta . "'";
        $dimension = $db->GetRow($sqldimension);

        if (isset($dimension['IdDimensionFactor']) && !empty($dimension['IdDimensionFactor'])) {
            $respuesta['titulo'] = $dimension['Nombre'];
            $sqlpreguntas = "SELECT dp.idsiq_Apregunta FROM DimensionPreguntas dp " .
                    " INNER JOIN DimensionesFactores d ON ( dp.IdDimensionFactor = d.IdDimensionFactor ) " .
                    " WHERE dp.Instrumento = '" . $instrumento . "' AND dp.IdDimensionFactor = '" . $dimension['IdDimensionFactor'] . "'";
            $listado = $db->GetAll($sqlpreguntas);

            foreach ($listado as $preguntas) {
                $respuesta['listapreguntas'] .= $preguntas['idsiq_Apregunta'] . ",";
            }
            $respuesta['listapreguntas'] = substr($respuesta['listapreguntas'], 0, -1);
            return $respuesta;
        } else {
            return "0";
        }
    }

    function validadimensionfactor($db, $pregunta, $instrumento, $categoria) {
        $select = "SELECT dp.IdDimencionPregunta, dp.idsiq_Apregunta" .
                " FROM DimensionPreguntas dp " .
                " WHERE dp.Instrumento =  " . $instrumento . " " .
                " AND dp.IdDimensionFactor IN ( " .
                " SELECT dp.IdDimensionFactor " .
                " FROM DimensionPreguntas dp " .
                " INNER JOIN DimensionesFactores df ON ( df.IdDimensionFactor = dp.IdDimensionFactor ) " .
                " WHERE dp.Instrumento = " . $instrumento . " " .
                " AND dp.idsiq_Apregunta IN (" . $pregunta . ") " .
                " AND df.Categoria = '" . $categoria . "' )"
                . " ORDER BY IdDimencionPregunta desc limit 1 ";
        $id = $db->getRow($select);

        if ($id['idsiq_Apregunta'] == $pregunta) {
            return $pregunta;
        } else {
            return false;
        }
    }

    function estudiante($db, $idusuario) {
        $sqlestudiante = "SELECT g.numerodocumento, g.nombresestudiantegeneral, g.apellidosestudiantegeneral " .
                " FROM estudiantegeneral g " .
                " INNER JOIN usuario u on (u.numerodocumento = g.numerodocumento and u.codigotipousuario = 600) " .
                " where u.idusuario = '" . $idusuario . "'";
        $estudiante = $db->GetRow($sqlestudiante);

        return $estudiante;
    }

    /**
     * @param $db
     * @param $instrumento
     */
    function detallesinstrumento($db, $instrumento) {
        $sqlinstrumento = "SELECT s.nombre, s.fecha_inicio, 	s.fecha_fin " .
                " FROM siq_Ainstrumentoconfiguracion s " .
                " WHERE s.idsiq_Ainstrumentoconfiguracion = " . $instrumento . " ;";
        $detalles = $db->GetRow($sqlinstrumento);
        return $detalles;
    }

    function validarparticipacion($db, $datos) {
        $return = "";

        $sqlactualizacionusuario = "SELECT estadoactualizacion FROM actualizacionusuario " .
                "WHERE usuarioid = '" . $datos['idusuario'] . "' AND id_instrumento = '" . $datos['idInstrumento'] . "'";
        $participacion = $db->Getrow($sqlactualizacionusuario);

        if (isset($participacion['estadoactualizacion']) && $participacion['estadoactualizacion'] == '3') {
            $return = true;
        } else {
            $sqlrespuestas = "SELECT count(s.idsiq_Ainstrumentoconfiguracion) as 'total' FROM " .
                    " siq_Arespuestainstrumento s " .
                    " WHERE s.usuariocreacion = '" . $datos['idusuario'] . "' " .
                    " AND s.idsiq_Ainstrumentoconfiguracion = '" . $datos['idInstrumento'] . "' " .
                    " and s.codigoestado = 100";
            $participacion = $db->GetRow($sqlrespuestas);
            if (isset($participacion['total']) && $participacion['total'] > 0) {
                $return = true;
            } else {
                $return = false;
            }
        }
        return $return;
    }

    function carrera($db, $carrera) {
        $sql = "select c.nombrecarrera from carrera c where c.codigocarrera = " . $carrera . " ";
        $datos = $db->GetRow($sql);

        return $datos;
    }
    