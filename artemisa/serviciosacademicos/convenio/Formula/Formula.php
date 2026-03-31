<?php

function ubicaciones($db, $coperiodo) {
    $ubicaciones = "SELECT ic.InstitucionConvenioId, ic.NombreInstitucion, ui.IdUbicacionInstitucion, ui.NombreUbicacion FROM RotacionEstudiantes re
                            INNER JOIN InstitucionConvenios ic ON ic.InstitucionConvenioId = re.IdInstitucion
                            INNER JOIN UbicacionInstituciones ui ON ui.InstitucionConvenioId = ic.InstitucionConvenioId
                            where ic.InstitucionConvenioId <> 0 and re.codigoperiodo = " . $coperiodo . " GROUP BY IdInstitucion desc";
    $listaubicaciones = $db->GetAll($ubicaciones);
    return $listaubicaciones;
}

function carreras($db, $coperiodo) {
    $sql_carreras = "SELECT re.codigocarrera, c.nombrecarrera FROM RotacionEstudiantes re INNER JOIN carrera c ON c.codigocarrera = re.codigocarrera WHERE                	re.codigoperiodo = '" . $coperiodo . "' GROUP BY codigocarrera";
    $carreras = $db->GetAll($sql_carreras);
    return $carreras;
}

function estudiantesrotacion($db, $coperiodo, $posicion, $tipo) {
    $sqlestudiantes = "SELECT E.codigocarrera, E.idestudiantegeneral, E.codigoestudiante, RE.JornadaId, RE.TotalDias, RE.TotalHoras, RE.FechaEgreso,  RE.FechaIngreso, E.semestre, E.numerocohorte, EG.nombresestudiantegeneral, EG.apellidosestudiantegeneral, EG.numerodocumento, DCH.valordetallecohorte, C.nombrecarrera, RE.codigomateria, RE.idsiq_convenio, C.codigomodalidadacademica, RE.IdInstitucion, IC.NombreInstitucion
    FROM RotacionEstudiantes RE INNER JOIN estudiante E ON E.codigoestudiante = RE.codigoestudiante INNER JOIN estudiantegeneral EG on EG.idestudiantegeneral = E.idestudiantegeneral INNER JOIN cohorte CH on CH.codigocarrera = E.codigocarrera and CH.codigoperiodo = RE.codigoperiodo INNER JOIN detallecohorte DCH on DCH.idcohorte = CH.idcohorte and DCH.semestredetallecohorte = E.semestre INNER JOIN carrera C on C.codigocarrera = E.codigocarrera INNER JOIN InstitucionConvenios IC on IC.InstitucionConvenioId = RE.IdInstitucion WHERE RE.codigoperiodo = " . $coperiodo . " AND RE." . $tipo . " = " . $posicion . " and DCH.codigoconcepto = '151'";
    $listaestudiantes = $db->GetAll($sqlestudiantes);
    return $listaestudiantes;
}

function creditos($db, $valoresestduiante) {
    $sqlcreditos = "SELECT  sum(D.numerocreditosdetalleplanestudio) AS 'totalcreditossemestre', D.idplanestudio FROM detalleplanestudio D INNER JOIN planestudioestudiante PE on PE.idplanestudio = D.idplanestudio WHERE D.semestredetalleplanestudio = " . $valoresestduiante['semestre'] . " AND D.codigotipomateria NOT IN ('4', '5') and PE.codigoestudiante =" . $valoresestduiante['codigoestudiante'] . " and PE.codigoestadoplanestudioestudiante like '1%'";
    $numerocreditos = $db->GetRow($sqlcreditos);
    return $numerocreditos;
}

function diassemestreEstudiante($db, $coperiodo, $estudiante) {
    $sqltotaldiassemestre = "SELECT g.fechainiciogrupo, g.fechafinalgrupo, m.numerocreditos, m.nombremateria FROM grupo g, materia m  WHERE g.codigoperiodo='" . $coperiodo . "' and g.codigomateria='" . $estudiante['codigomateria'] . "' and m.codigomateria = g.codigomateria";
    $dias_semestre = $db->GetRow($sqltotaldiassemestre);
    return $dias_semestre;
}

function contraprestacion($db, $estudiante, $tipopracticante) {
    $sqlcontraprestacion = "SELECT 	c.ValorContraprestacion, c.IdTipoPagoContraprestacion FROM Contraprestaciones c INNER JOIN Convenios co ON co.ConvenioId = c.ConvenioId WHERE c.ConvenioId = '" . $estudiante['idsiq_convenio'] . "' AND c.codigoestado = '100' AND c.IdTipoPracticante = '" . $tipopracticante . "'";
    $valorcontrapestacion = $db->GetRow($sqlcontraprestacion);
    return $valorcontrapestacion;
}

function listaEstudiantes($db, $periodoinicial, $periodo, $ubicacionfacultad, $and_adicional) {

    $codigoestado = 100;
    $estadoRotacionId = 1;
    $sentencias = obtenerSenteciasMYSQL(__DIR__ . "/sentenciasSQL.json");


    // Validar si existen rotaciones de (estudiantes <==> Programas) con estados erroneos
    $sentenciaValid =  $sentencias['sentencias']['sentencia_02']['sql'];
    $hallazgos =  @current($db->Execute($sentenciaValid)->FetchRow());

    // Si encuentra registros erroneos se procedera a desactivarlos
    if($hallazgos['hallazgos'] > 0)
    {
        $sentenciaUpdate =  $sentencias['sentencias']['sentencia_03']['sql'];
        $db->Execute($sentenciaUpdate);
    }

    $sentencia = $sentencias['sentencias']['sentencia_01']['sql'];
    $sentencia = vsprintf($sentencia, array($codigoestado, $estadoRotacionId, $periodoinicial, $periodo, $ubicacionfacultad, $and_adicional));
    $valoresRotacion = $db->GetAll($sentencia);

    return $valoresRotacion;
}

//listaEstudiantes

function datosEstudiante($db, $idestudiantegeneral, $codigocarrera) {

    $sentencias = obtenerSenteciasMYSQL(__DIR__ . "/sentenciasSQL.json");
    $sentencia = $sentencias['sentencias']['sentencia_04']['sql'];
    $sentencia = vsprintf($sentencia, array((int) $idestudiantegeneral,(int) $codigocarrera));
    $valoresEstudiante = $db->GetAll($sentencia);

    return $valoresEstudiante;
}

/**
 * Función para la lectura y retorno de sentencias MYSQL's
 *
 * @param string $pathArchivo
 * @return array
 * @throws Exception
 */
function obtenerSenteciasMYSQL($pathArchivo)
{

    if (! file_exists($pathArchivo)) throw new \Exception('No se encuntra el archivo de sentencias : ' . $pathArchivo);

    $archivoSentencias = file_get_contents( $pathArchivo );
    $sentencias = json_decode($archivoSentencias, true);

    if ($sentencias == null) throw new \Exception('Error en la estructura del archivo : ' . $pathArchivo);

    return $sentencias;

}

/**
 * Consulta y retorna el semestre matriculado por un estudiante en un periodo
 * determinado
 * @author Andres Ariza <arizaandres@unbosque.edu.co>
 * @access public
 * @param $db ADODB_mysql
 * @param string $codigoEstudiante codigo del estudiante de la rotacion
 * @param string $codigoPeriodo Codigo del periodo de la rotacion
 * @return ingeger
 */
function getSemestreRotacion($db, $codigoEstudiante, $codigoPeriodo){
    $query = "SELECT semestreprematricula "
            . " FROM prematricula "
            . " WHERE codigoestadoprematricula = 40 "
            . " AND codigoperiodo = ".$codigoPeriodo
            . " AND codigoestudiante = ".$codigoEstudiante;
    //echo $query;
    $datos = $db->Execute($query);
    $data = $datos->FetchRow();
    return $data["semestreprematricula"];
}

//datosEstudiante

function servicios($db, $RotacionEstudianteId) {
    $sqlservicios = "SELECT ec.Especialidad FROM RotacionEspecialidades re INNER JOIN EspecialidadCarrera ec ON ec.EspecialidadCarreraId = re.EspecialidadCarreraId         WHERE re.RotacionEstudianteId = '" . $RotacionEstudianteId . "' AND re.CodigoEstado = '100';";
    $resultadoservicios = $db->GetAll($sqlservicios);
    return $resultadoservicios;
}

//servicios

function creditosEstudiante($db, $codigoestudiante, $semestre) {
    $sqlcreditos = "SELECT sum( d.numerocreditosdetalleplanestudio ) AS totalcreditossemestre, d.idplanestudio FROM detalleplanestudio d, planestudioestudiante p   WHERE d.idplanestudio = p.idplanestudio AND p.codigoestudiante = '" . $codigoestudiante . "' AND d.semestredetalleplanestudio = '" . $semestre . "' AND p.codigoestadoplanestudioestudiante LIKE '1%'   AND d .codigotipomateria NOT LIKE '4'   AND d.codigotipomateria NOT LIKE '5' ";
    $numerocreditos = $db->GetRow($sqlcreditos);

    return $numerocreditos;
}

//creditosEstudiante

function ValorSemestre($db, $periodo, $semestre, $codigocarrera) {
    $sqlvalorsemestre = "SELECT dc.valordetallecohorte, cc.codigomodalidadacademica, cc.nombrecarrera FROM cohorte c INNER JOIN detallecohorte dc ON dc.idcohorte = c.idcohorte INNER JOIN carrera cc ON cc.codigocarrera = c.codigocarrera WHERE c.codigoperiodo = '" . $periodo . "' AND dc.codigoconcepto = '151' AND dc.semestredetallecohorte = '" . $semestre . "' AND c.codigocarrera = '" . $codigocarrera . "'";
    $valorsemestre = $db->GetRow($sqlvalorsemestre);
    return $valorsemestre;
}

//ValorSemestre

function diasSemestre($db, $periodo, $codigomateria) {
    $sqltotaldiassemestre = "SELECT g.fechainiciogrupo, g.fechafinalgrupo, m.numerocreditos, m.nombremateria, g.codigomateria  FROM grupo g, materia m WHERE g.codigoperiodo='" . $periodo . "' and g.codigomateria='" . $codigomateria . "' and m.codigomateria = g.codigomateria";
    $diassemestre = $db->GetRow($sqltotaldiassemestre);
    return $diassemestre;
}

function CalcularContrapestacion($db, $idconvenio, $tipopracticante, $codigocarrera) {
    //consulta de la contraprestacion, se consulta por el tipo de participante, carrera y convenio.    
    $sqlcontraprestacion = "SELECT C.ValorContraprestacion, C.IdTipoPagoContraprestacion, 	tpc.NombrePagoContraprestacion  from Contraprestaciones C  INNER JOIN conveniocarrera cc ON cc.IdContraprestacion = C.IdContraprestacion AND cc.codigoestado ='100' INNER JOIN TipoPagoContraprestaciones tpc on tpc.IdTipoPagoContraprestacion = C.IdTipoPagoContraprestacion WHERE C.ConvenioId = '" . $idconvenio . "' and C.codigoestado = '100' and C.IdTipoPracticante ='" . $tipopracticante . "' and cc.codigocarrera = '" . $codigocarrera . "'";
    $valorcontrapestacion = $db->GetRow($sqlcontraprestacion);
    return $valorcontrapestacion;
}

/**
 * Se agrega como parametro a la formula "Formula" el valor de la fecha de ingreso a la rotacion
 * para consultar la formula correcta dependiendo de su fecha de vigencia
 * @modified Andres Ariza <arizaandres@unbosque.edu.do>
 * Caso aranda 105410
 * @since octubre 2 2018
 */
function Formula($db, $codigocarrera, $idconvenio, $valoresformula, $fechaIngreso) {
    //d($fechaIngreso);
    $sqlentidades = "SELECT cc.IdContraprestacion, f.formula "
            . " FROM conveniocarrera cc "
            . " INNER JOIN Convenios c ON c.ConvenioId = cc.ConvenioId "
            . " INNER JOIN InstitucionConvenios ic ON ic.InstitucionConvenioId = c.InstitucionConvenioId "
            . " LEFT JOIN FormulaLiquidaciones f ON ( f.ConvenioId = c.ConvenioId AND f.codigocarrera = cc.Codigocarrera "
            . "  AND f.CodigoEstado = 100 AND ('".$fechaIngreso."' BETWEEN f.FechaInicioVigencia AND f.FechaFinVigencia)) "
            . " WHERE cc.codigocarrera = '" . $codigocarrera . "' and cc.ConvenioId = '" . $idconvenio . "'";
    //ddd($sqlentidades);
    $formula = $db->GetRow($sqlentidades);

    $sqlcampos = "SELECT cf.CamposFormulaId, cf.Nombre FROM CamposFormulas cf where cf.codigoestado ='100'";
    $campos = $db->GetAll($sqlcampos);

    if ($formula['formula']) {
        $formula = $formula['formula'];
        $formulatotal = '(';
        $formulaNombre = '';
        $datos = explode(",", $formula);
        $numero = count($datos);
        $f = 'a';
        for ($i = 0; $i <= $numero; $i++) {
            if ($f == 'a') {
                foreach ($campos as $nombres) {
                    $numeros = explode("-", $datos[$i]);
                    if (in_array($numeros[0],array('12','11','3','6','9','15','16','17','20','19'))) {
                        if ($nombres['CamposFormulaId'] == $numeros[0]) {
                            $formulatotal .= $numeros[1] . " ";
                            $formulaNombre .= $nombres['Nombre'] . "(" . $numeros[1] . ") ";
                            if ($i == 2) {
                                $formulatotal .= ")";
                            }
                            $f = 'b';
                        }
                    } else {
                        if ($nombres['CamposFormulaId'] == $datos[$i]) {
                            $formulatotal .= $valoresformula[$nombres['CamposFormulaId']];
                            $formulaNombre .= $nombres['Nombre'] . " ";
                            if ($i == 2) {
                                $formulatotal .= ")";
                            }
                            $f = 'b';
                        }
                    }//else                    
                }//foreach
            } else {
                if ($f == 'b') {
                    switch ($datos[$i]) {
                        case '1': {
                                $formulatotal .= "* ";
                                $formulaNombre .= "* ";
                                $f = 'a';
                            }break;
                        case '2': {
                                $formulatotal .= "/ ";
                                $formulaNombre .= "/ ";
                                $f = 'a';
                            }break;
                        case '3': {
                                $formulatotal .= "- ";
                                $formulaNombre .= "- ";
                                $f = 'a';
                            }break;
                        case '4': {
                                $formulatotal .= "+ ";
                                $formulaNombre .= "+ ";
                                $f = 'a';
                            }break;
                        case '': {
                                $f = 0;
                            }break;
                    }//switch
                }//if
            }//else

        } //for
        eval("\$var = $formulatotal;");

        $formulasalida['formula'] = $formulaNombre;
        $formulasalida['total'] = $var;
        $formulasalida['campos'] = $formulatotal;
    }//if formula
    else {
        $formulasalida['formula'] = "sin formula definida";
        $formulasalida['total'] = "0";
        $formulasalida['campos'] = $formulatotal;
    }
    return $formulasalida;
}

//Formula

function Buscardias($db, $id) {
    $sqldias = "SELECT D.nombredia FROM DetalleRotaciones DR INNER JOIN dia D on D.codigodia = DR.codigodia WHERE DR.RotacionEstudianteId = '" . $id . "';";
    $dias = $db->GetAll($sqldias);

    foreach ($dias as $nombres) {
        $lisatas .= $nombres['nombredia'] . " / ";
    }
    return $lisatas;
}

function valoresestudiante($db, $estudiante) {
    $sqlestudiante = "SELECT e.semestre, e.codigoperiodo, e.numerocohorte, e.codigoestudiante, eg.nombresestudiantegeneral, eg.apellidosestudiantegeneral,          	eg.numerodocumento FROM estudiante e, estudiantegeneral eg WHERE e.idestudiantegeneral = '" . $estudiante['idestudiantegeneral'] . "' AND e.codigocarrera = '" . $estudiante['codigocarrera'] . "' AND eg.idestudiantegeneral = e.idestudiantegeneral";

    $valoresEstudiante = $db->GetRow($sqlestudiante);
    return $valoresEstudiante;
}