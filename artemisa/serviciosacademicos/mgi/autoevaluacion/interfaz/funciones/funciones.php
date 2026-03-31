<?php

/*
 * Reporte de resultados evaluacion docente (pregrado)
 * Vega Gabriel <vegagabriel@unbosque.edu.do>.
 * Universidad el Bosque - Direccion de Tecnologia.
 * Creado 14 de Agosto de 2017.
 */
/*
 * Modificacion logica para generacion de reporte
 * debido a que segun la materia es una encuesta diferente (caso  95693)
 * Vega Gabriel <vegagabriel@unbosque.edu.do>.
 * Universidad el Bosque - Direccion de Tecnologia.
 * Modificado 1 de Diciembre de 2017.
 */
session_start();
include_once('../../../../../serviciosacademicos/utilidades/ValidarSesion.php');
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION);

require_once('../../../../../serviciosacademicos/Connections/sala2.php');
require('../../../../../serviciosacademicos/funciones/funcionpassword.php');
$rutaado = '../../../../../serviciosacademicos/funciones/adodb/';
require_once('../../../../../serviciosacademicos/Connections/salaado.php');

function comprobar($array, $buscar) {
    $retornar = false;
    foreach ($array as $k => $v) {
        if ($v == $buscar) {
            $retornar = $k;
        }
    }
    return $retornar;
}

switch ($_POST['action']) {
    case 'Periodo':
        $sqlperiodo = " SELECT p.codigoperiodo,p.nombreperiodo
                            FROM periodo p
                            WHERE p.codigoperiodo>'20102' ORDER BY p.codigoperiodo DESC";
        $datosperiodo = $db->GetAll($sqlperiodo);

        $selectperiodohtml = "<option value=''>Seleccione</option>";
        foreach ($datosperiodo as $periodo) {
            $selectperiodohtml .= "<option value='" . $periodo['codigoperiodo'] . "'>" . $periodo['nombreperiodo'] . "</option>";
        }

        echo $selectperiodohtml;
        break;
    case 'Carrera':
        $sqlcarrera = "SELECT codigocarrera,nombrecarrera 
                        FROM carrera c 
                        WHERE now()  BETWEEN fechainiciocarrera AND fechavencimientocarrera
                        AND codigomodalidadacademica LIKE '2%'
                        ORDER BY nombrecarrera";
        $datoscarrera = $db->GetAll($sqlcarrera);

        $selectcarrerahtml = "<option value=''>Seleccione</option>";
        foreach ($datoscarrera as $carrera) {
            $selectcarrerahtml .= "<option value='" . $carrera['codigocarrera'] . "'>" . $carrera['nombrecarrera'] . "</option>";
        }

        echo $selectcarrerahtml;
        break;
    case 'Materia':
        $sqlmateria = "SELECT m.codigomateria,m.nombremateria
                        FROM materia m , planestudio p, detalleplanestudio dp
                        WHERE p.idplanestudio=dp.idplanestudio
                        AND dp.codigomateria=m.codigomateria
                        AND p.codigocarrera='" . $_POST['prograacad'] . "'
                        AND p.codigoestadoplanestudio LIKE '1%'
                        AND dp.codigoestadodetalleplanestudio LIKE '1%'
                        UNION 
                        SELECT  m.codigomateria,m.nombremateria 
                        FROM materia m , planestudio p, lineaenfasisplanestudio le,detallelineaenfasisplanestudio dl
                        WHERE dl.idlineaenfasisplanestudio=le.idlineaenfasisplanestudio
                        AND dl.codigomateriadetallelineaenfasisplanestudio=m.codigomateria
                        AND p.codigocarrera='" . $_POST['prograacad'] . "'
                        AND p.codigoestadoplanestudio LIKE '1%'
                        AND dl.codigoestadodetallelineaenfasisplanestudio LIKE '1%'
                        AND le.idplanestudio=p.idplanestudio
                        UNION
                        SELECT m.codigomateria,m.nombremateria
                        FROM materia m, grupo g
                        WHERE m.codigocarrera='" . $_POST['prograacad'] . "' 
                        AND m.codigoestadomateria='01'
                        AND m.codigomateria=g.codigomateria
                        GROUP BY g.codigomateria
                        ORDER BY nombremateria
                        ";
        $datosmateria = $db->GetAll($sqlmateria);

        $selectmateriahtml = "<option value=''>Seleccione</option>";
        foreach ($datosmateria as $materia) {
            $selectmateriahtml .= "<option value='" . $materia['codigomateria'] . "'>" . $materia['nombremateria'] . "</option>";
        }

        echo $selectmateriahtml;
        break;
    case 'Docente':
        $sqldocente = "SELECT d.numerodocumento, concat(d.apellidodocente,' ',d.nombredocente) nombredocentecompleto
                        FROM grupo g, docente d
                        WHERE g.codigomateria='" . $_POST['codigomateria'] . "'
                        AND g.numerodocumento=d.numerodocumento 
                        AND g.codigoperiodo='" . $_POST['periodo'] . "'
                        GROUP BY d.iddocente
                        ORDER BY nombredocentecompleto";
        $datosdocente = $db->GetAll($sqldocente);

        $selectdocentehtml = "<option value=''>Seleccione</option>";
        foreach ($datosdocente as $docente) {
            $selectdocentehtml .= "<option value='" . $docente['numerodocumento'] . "'>" . $docente['nombredocentecompleto'] . "</option>";
        }

        echo $selectdocentehtml;
        break;

    case 'Consultar_Encabezado': {
            //segun la materia se extrae el idencuesta
            $sqlidencuesta = "select e.idencuesta ";
            $sqlidencuesta .= "from encuesta e,encuestamateria em ";
            $sqlidencuesta .= "where em.codigomateria= '" . $_POST['codigomateria'] . "' ";
            $sqlidencuesta .= "and em.idencuesta=e.idencuesta";
            $datosidencuesta = $db->GetRow($sqlidencuesta);

            //grupos preguntas
            $sqlencabezado = "SELECT ";
            $sqlencabezado .= "p.idpreguntagrupo,p.idpregunta,p.nombrepregunta ";
            $sqlencabezado .= "FROM ";
            $sqlencabezado .= "preguntatipousuario pt, ";
            $sqlencabezado .= "tipopregunta tp, ";
            $sqlencabezado .= "pregunta p, ";
            $sqlencabezado .= "encuestapregunta ep ";
            $sqlencabezado .= "WHERE ";
            $sqlencabezado .= "ep.idencuesta = '" . $datosidencuesta['idencuesta'] . "' ";
            $sqlencabezado .= "AND pt.idpregunta = p.idpregunta ";
            $sqlencabezado .= "AND tp.idtipopregunta = p.idtipopregunta ";
            $sqlencabezado .= "AND idpreguntagrupo = '0' ";
            $sqlencabezado .= "AND p.codigoestado LIKE '1%' ";
            $sqlencabezado .= "AND pt.codigoestado LIKE '1%' ";
            $sqlencabezado .= "AND ep.idpregunta = p.idpregunta ";
            $sqlencabezado .= "ORDER BY ";
            $sqlencabezado .= "p.pesopregunta ";
            $datosencabezado = $db->GetAll($sqlencabezado);

            //concatenamos grupos pregunta      
            $tmconcat = "";
            foreach ($datosencabezado as $grupreg) {
                $tmconcat .= $grupreg['idpregunta'] . ",";
            }
            $nconcat = substr($tmconcat, 0, -1);

            //sacamos preguntas
            $sqlpreg = "SELECT p.idpregunta, p.idpreguntagrupo, p.nombrepregunta,tp.numeroopcionestipopregunta
                        FROM pregunta p,tipopregunta tp
                        WHERE 1 ";
            $sqlpreg .= "AND tp.idtipopregunta = p.idtipopregunta ";
            $sqlpreg .= "AND p.idpreguntagrupo IN(" . $nconcat . ") ";
            $sqlpreg .= "AND tp.idtipopregunta NOT IN (101)  ";
            $datospreg = $db->GetAll($sqlpreg);

            //para agrupar y ordenar
            $sqlgrpreg = $sqlpreg;
            $sqlgrpreg .= " GROUP BY p.idpreguntagrupo";
            $sqlgrpreg .= " ORDER BY p.idpregunta";
            $datosgrpreg = $db->GetAll($sqlgrpreg);


            $html = "<tr>
                        <th colspan='2' rowspan='3' style='text-align: center'>CARRERA</th>
                        <th colspan='2' rowspan='3' style='text-align: center'>MATERIA</th>
                        <th colspan='3' rowspan='3' style='text-align: center'>DOCENTE</th>";

            $smconcat = ""; //grupo de preguntas
            //numerales y preguntas
            $smarreglo = "<tr>"; //numeral pregunta - segunda fila
            $tmarreglo = "<tr>"; //nombre pregunta - tercera fila
            $np = 1;
            $numbers = "";
            foreach ($datosencabezado as $grupreg) {//grupo de preguntas
                $numbersc = 0;
                foreach ($datospreg as $idpreg) {//numeral pregunta y nombre pregunta
                    if ($grupreg['idpregunta'] == $idpreg['idpreguntagrupo']) {
                        $numbersb = 0;
                        $nopciones = ""; //
                        if ($idpreg['numeroopcionestipopregunta'] == 0) {
                            $nopciones .= "<th colspan='7' style='text-align: center'></th>"; //
                            $numbersb += 7;
                        } else {
                            $numbersb += $idpreg['numeroopcionestipopregunta'];
                            $op = 1;
                            for ($j = 0; $j <= $idpreg['numeroopcionestipopregunta'] - 1; $j++) {//numero opciones pregunta
                                $nopciones .= "<th style='text-align: center'>" . $op . "</th>"; //
                                $op++;
                            }//numero opciones pregunta
                            $nopciones .= "<th style='text-align: center'>TOTAL</th>";
                            $nopciones .= "<th style='text-align: center'>NOTA</th>";
                            $numbersb += 2;
                        }
                        $numbers .= $nopciones;
                        $rtt = $numbersb;
                        $smarreglo .= "<th colspan='" . $rtt . "' style='text-align: center'>P" . $np . "</th>"; //numeral pregunta - segunda fila
                        $tmarreglo .= "<th colspan='" . $rtt . "' style='text-align: center'>" . $idpreg['nombrepregunta'] . "</th>"; //nombre pregunta - tercera fila
                        $np ++;
                        $numbersc += $rtt;
                    }
                }//numeral pregunta y nombre pregunta
                $smarreglo .= "<th rowspan='3' style='text-align: center'>NOTA PARCIAL</th>";
                $rt = $numbersc + 1;
                $smconcat .= "<th colspan='" . $rt . "' style='text-align: center'>" . $grupreg['nombrepregunta'] . "</th>"; //grupo de preguntas
            } //grupo de preguntas
            $smconcat .= "<th rowspan='4' style='text-align: center'>NOTA TOTAL</th>"; //grupo de preguntas
            $html .= $smconcat; //grupo de preguntas
            $html .= "</tr>";

            $smarreglo .= "</tr>"; //numeral pregunta - segunda fila
            $html .= $smarreglo;
            $tmarreglo .= "</tr>"; //nombre pregunta - tercera fila
            $html .= $tmarreglo;

            //cuarta fila
            $html .= "<tr>
                            <th style='text-align: center'>CODIGO</th>
                            <th style='text-align: center'>NOMBRE</th>
                            <th style='text-align: center'>CODIGO</th>
                            <th style='text-align: center'>NOMBRE</th>
                            <th style='text-align: center'>DOCUMENTO</th>
                            <th style='text-align: center'>APELLIDOS</th>
                            <th style='text-align: center'>NOMBRES</th>";
            $html .= $numbers;
            $html .= "</tr>";


            echo $html;
        }break;
    case 'Consultar': {
            //segun la materia se extrae el idencuesta
            $sqlidencuesta = "select e.idencuesta ";
            $sqlidencuesta .= "from encuesta e,encuestamateria em ";
            $sqlidencuesta .= "where em.codigomateria= '" . $_POST['codigomateria'] . "' ";
            $sqlidencuesta .= "and em.idencuesta=e.idencuesta";
            $datosidencuesta = $db->GetRow($sqlidencuesta);

            //encabezados preguntas (grupos)
            $sqlencabezado = "SELECT ";
            $sqlencabezado .= "p.idpreguntagrupo,p.idpregunta,p.nombrepregunta ";
            $sqlencabezado .= "FROM ";
            $sqlencabezado .= "preguntatipousuario pt, ";
            $sqlencabezado .= "tipopregunta tp, ";
            $sqlencabezado .= "pregunta p, ";
            $sqlencabezado .= "encuestapregunta ep ";
            $sqlencabezado .= "WHERE ";
            $sqlencabezado .= "ep.idencuesta = '" . $datosidencuesta['idencuesta'] . "' ";
            $sqlencabezado .= "AND pt.idpregunta = p.idpregunta ";
            $sqlencabezado .= "AND tp.idtipopregunta = p.idtipopregunta ";
            $sqlencabezado .= "AND idpreguntagrupo = '0' ";
            $sqlencabezado .= "AND p.codigoestado LIKE '1%' ";
            $sqlencabezado .= "AND pt.codigoestado LIKE '1%' ";
            $sqlencabezado .= "AND ep.idpregunta = p.idpregunta ";
            $sqlencabezado .= "ORDER BY ";
            $sqlencabezado .= "p.pesopregunta ";
            $datosencabezado = $db->GetAll($sqlencabezado);

            //encabezados pregunta      
            $tmconcat = "";
            foreach ($datosencabezado as $grupreg) {
                $tmconcat .= $grupreg['idpregunta'] . ",";
            }
            $nconcat = substr($tmconcat, 0, -1);

            //preguntas
            $sqlpreg = "SELECT p.idpregunta, p.idtipopregunta, p.idpreguntagrupo, p.nombrepregunta,tp.numeroopcionestipopregunta
                        FROM pregunta p,tipopregunta tp
                        WHERE 1 ";
            $sqlpreg .= "AND tp.idtipopregunta = p.idtipopregunta ";
            $sqlpreg .= "AND p.idpreguntagrupo IN(" . $nconcat . ") ";
            $sqlpreg .= "AND tp.idtipopregunta NOT IN (101)  ";
            $datospreg = $db->GetAll($sqlpreg);

            $tnarreglo = "";
            $smarreglo = "";
            $nn = 0;
            foreach ($datospreg as $idpreg) {
                $tnarreglo .= $idpreg['idpregunta'] . ",";
                $smarreglo .= $idpreg['nombrepregunta'] . "-**-";
                $nn += 1;
            }
            $narreglo = substr($tnarreglo, 0, -1);
            $arreglo = explode(",", $narreglo);
            $marreglo = substr($smarreglo, 0, -4);
            $sarreglo = explode("-**-", $marreglo);

            //para agrupar y ordenar
            $sqlgrpreg = $sqlpreg;
            $sqlgrpreg .= " GROUP BY p.idpreguntagrupo";
            $sqlgrpreg .= " ORDER BY p.idpregunta";
            $datosgrpreg = $db->GetAll($sqlgrpreg);


            $pcodigomateria = "";
            if ($_POST['codigomateria'] != "") {
                $pcodigomateria .= "AND g.codigomateria='" . $_POST['codigomateria'] . "' ";
            } else {
                $pcodigomateria .= "AND g.codigomateria IN (" . $nconcattmateria . ") ";
            }
            $pnumerodocumento = "";
            if ($_POST['numerodocumento'] != "") {
                $pnumerodocumento .= "AND g.numerodocumento='" . $_POST['numerodocumento'] . "' ";
            }
            $sqldatosdocentes = "SELECT p.codigocarrera,(SELECT nombrecarrera FROM carrera ca WHERE ca.codigocarrera=p.codigocarrera) AS nombrecarrera, 
                                m.codigomateria, m.nombremateria, d.numerodocumento, d.apellidodocente, d.nombredocente 
                                FROM materia m , planestudio p, detalleplanestudio dp ,grupo g, docente d
                                WHERE p.idplanestudio=dp.idplanestudio 
                                AND dp.codigomateria=m.codigomateria 
                                AND p.codigocarrera ='" . $_POST['prograacad'] . "' 
                                AND g.codigomateria=m.codigomateria 
                                AND g.numerodocumento=d.numerodocumento 
                                AND g.codigoperiodo='" . $_POST['periodo'] . "'
                                 " . $pcodigomateria . " " . $pnumerodocumento . "   
                                AND p.codigoestadoplanestudio LIKE '1%' 
                                AND dp.codigoestadodetalleplanestudio LIKE '1%' 
                                UNION 
                                SELECT p.codigocarrera,(SELECT nombrecarrera FROM carrera ca WHERE ca.codigocarrera=p.codigocarrera) AS nombrecarrera, 
                                m.codigomateria,m.nombremateria, d.numerodocumento, d.apellidodocente, d.nombredocente 
                                FROM materia m , planestudio p, lineaenfasisplanestudio le,detallelineaenfasisplanestudio dl ,grupo g, docente d
                                WHERE dl.idlineaenfasisplanestudio=le.idlineaenfasisplanestudio 
                                AND dl.codigomateriadetallelineaenfasisplanestudio=m.codigomateria 
                                AND g.codigomateria=m.codigomateria 
                                AND g.numerodocumento=d.numerodocumento 
                                AND g.codigoperiodo='" . $_POST['periodo'] . "'
                                AND p.codigocarrera='" . $_POST['prograacad'] . "'
                                 " . $pcodigomateria . " " . $pnumerodocumento . "   
                                AND p.codigoestadoplanestudio LIKE '1%' 
                                AND dl.codigoestadodetallelineaenfasisplanestudio LIKE '1%' 
                                AND le.idplanestudio=p.idplanestudio
                                UNION
                                SELECT m.codigocarrera,(SELECT nombrecarrera FROM carrera ca WHERE ca.codigocarrera=m.codigocarrera) AS nombrecarrera, 
                                m.codigomateria,m.nombremateria, d.numerodocumento, d.apellidodocente, d.nombredocente
                                FROM materia m, grupo g,docente d
                                WHERE m.codigocarrera='" . $_POST['prograacad'] . "' 
                                AND m.codigoestadomateria='01'
                                AND m.codigomateria=g.codigomateria
                                AND g.numerodocumento=d.numerodocumento
                                AND g.codigoperiodo='" . $_POST['periodo'] . "'
                                 " . $pcodigomateria . " " . $pnumerodocumento . "   
                                GROUP BY g.codigomateria
                                ORDER BY nombremateria
                                ;";


            $datos = $db->GetAll($sqldatosdocentes);

            $html = "";
            foreach ($datos as $datosdocentes) {
                $html .= "<tr>
                       <td>" . $datosdocentes['codigocarrera'] . "</td>
                       <td>" . $datosdocentes['nombrecarrera'] . "</td>
                       <td>" . $datosdocentes['codigomateria'] . "</td>
                       <td>" . $datosdocentes['nombremateria'] . "</td>
                       <td>" . $datosdocentes['numerodocumento'] . "</td>
                       <td>" . $datosdocentes['apellidodocente'] . "</td>
                       <td>" . $datosdocentes['nombredocente'] . "</td>";

                $sqlresultadosevaluaciondocente = "SELECT 
                                                    ep.idpregunta, 
                                                    r.valorrespuestaautoevaluacion,
                                                    count(distinct r.codigoestudiante) cuenta 
                                                        FROM respuestaautoevaluacion r , encuestapregunta ep, pregunta p ,prematricula pr, 
                                                        detalleprematricula dp,grupo g,docente d 
                                                        where r.idencuestapregunta=ep.idencuestapregunta 
                                                        and p.idpregunta=ep.idpregunta 
                                                        and r.valorrespuestaautoevaluacion <> '' 
                                                        and p.idtipopregunta not in (100,101,201)";
                $sqlresultadosevaluaciondocente .= " and p.idpregunta IN(" . $narreglo . ")";
                $sqlresultadosevaluaciondocente .= " and dp.idprematricula=pr.idprematricula 
                                                        and pr.codigoestudiante=r.codigoestudiante 
                                                        and pr.codigoperiodo=r.codigoperiodo 
                                                        and r.codigomateria=dp.codigomateria 
                                                        and r.codigoperiodo='" . $_POST['periodo'] . "' 
                                                        and g.idgrupo=dp.idgrupo 
                                                        and g.numerodocumento=d.numerodocumento 
                                                        and g.codigoperiodo='" . $_POST['periodo'] . "' 
                                                        and g.codigomateria='" . $datosdocentes['codigomateria'] . "' 
                                                        and d.numerodocumento='" . $datosdocentes['numerodocumento'] . "'
                                                        and r.codigoestudiante not in ( 
                                                                                SELECT r2.codigoestudiante 
                                                                                FROM respuestaautoevaluacion r2 , encuestapregunta ep2, pregunta p2 
                                                                                where r2.idencuestapregunta=ep2.idencuestapregunta 
                                                                                and p2.idpregunta=ep2.idpregunta 
                                                                                and r2.valorrespuestaautoevaluacion = '' 
                                                                                and p2.idtipopregunta not in (100,101,201) 
                                                                                and ep2.idencuesta=ep.idencuesta 
                                                                                and r2.codigoperiodo=20112 
                                                                                and r2.codigoestudiante=r.codigoestudiante 
                                                                                group by r2.codigoestudiante ) 
                                                        ";
                $sqlresultadosevaluaciondocente .= "group by d.numerodocumento,g.codigomateria,ep.idpregunta,r.valorrespuestaautoevaluacion 
                                                        order by d.numerodocumento,g.codigomateria,ep.idpregunta,r.valorrespuestaautoevaluacion ";

                $resultadosevaluaciondocente = $db->GetAll($sqlresultadosevaluaciondocente);
                if (count($resultadosevaluaciondocente)) {

                    $smconcat = ""; //grupo de preguntas
                    //numerales y preguntas
                    $smarreglo = ""; //numeral pregunta
                    $sumanotasparciales = "";
                    $v = 0;
                    foreach ($datosencabezado as $grupreg) {//grupo de preguntas
                        $numbers = "";
                        $sumanota = "";
                        $r = 0;
                        foreach ($datospreg as $idpreg) {//numeral pregunta y nombre pregunta
                            if ($grupreg['idpregunta'] == $idpreg['idpreguntagrupo']) {
                                $nopciones = ""; //
                                if ($idpreg['numeroopcionestipopregunta'] == 0) {
                                    switch ($idpreg['idtipopregunta']) {
                                        case '200':
                                        case '201':
                                            $sqlvarios = "SELECT ep.idpregunta,
                                                        r.valorrespuestaautoevaluacion
                                                FROM  respuestaautoevaluacion r,
                                                        encuestapregunta ep,
                                                        pregunta p,
                                                        prematricula pr,
                                                        detalleprematricula dp,
                                                        grupo g,
                                                        docente d
                                                WHERE r.idencuestapregunta = ep.idencuestapregunta
                                                AND p.idpregunta = ep.idpregunta
                                                AND r.valorrespuestaautoevaluacion <> ''
                                                AND p.idtipopregunta IN (201, 200)
                                                AND p.idpregunta ='" . $idpreg['idpregunta'] . "'
                                                AND dp.idprematricula = pr.idprematricula
                                                AND pr.codigoestudiante = r.codigoestudiante
                                                AND pr.codigoperiodo = r.codigoperiodo
                                                AND r.codigomateria = dp.codigomateria
                                                AND r.codigoperiodo = '" . $_POST['periodo'] . "'
                                                AND g.idgrupo = dp.idgrupo
                                                AND g.numerodocumento = d.numerodocumento
                                                AND g.codigoperiodo = '" . $_POST['periodo'] . "'
                                                AND g.codigomateria = '" . $datosdocentes['codigomateria'] . "'
                                                and d.numerodocumento ='" . $datosdocentes['numerodocumento'] . "'
                                                AND r.codigoestudiante NOT IN (
                                                        SELECT r2.codigoestudiante
                                                        FROM respuestaautoevaluacion r2,
                                                                encuestapregunta ep2,
                                                                pregunta p2
                                                        WHERE r2.idencuestapregunta = ep2.idencuestapregunta
                                                        AND p2.idpregunta = ep2.idpregunta
                                                        AND r2.valorrespuestaautoevaluacion = ''
                                                        AND p2.idtipopregunta NOT IN (100, 101, 201)
                                                        AND ep2.idencuesta = ep.idencuesta
                                                        AND r2.codigoestudiante = r.codigoestudiante
                                                        GROUP BY r2.numerodocumento
                                                )
                                                GROUP BY r.idrespuestaautoevaluacion
                                                ORDER BY r.idrespuestaautoevaluacion";
                                            $resultadosvarios = $db->GetAll($sqlvarios);
                                            $concatvar = "";
                                            foreach ($resultadosvarios as $varios) {
                                                $concatvar .= "*" . $varios['valorrespuestaautoevaluacion'] . "<br>";
                                            }
                                            $nvar = substr($concatvar, 0, -4);
                                            $nopciones .= "<td colspan='7' style='text-align: center'>" . $nvar . "</td>"; //
                                            break;
                                        default:
                                            $nopciones .= "<td colspan='7' style='text-align: center'></td>"; //
                                            break;
                                    }
                                } else {
                                    $pos = "";
                                    foreach ($resultadosevaluaciondocente as $resultados) {
                                        if ($idpreg['idpregunta'] == $resultados['idpregunta']) {
                                            $pos .= $resultados['valorrespuestaautoevaluacion'] . "--" . $resultados['cuenta'] . "|";
                                        }
                                    }
                                    $tpos = substr($pos, 0, -1);
                                    $yy = explode("|", $tpos);

                                    $op = 1;
                                    $total = 0;
                                    $tnota = 0; //
                                    for ($j = 0; $j <= $idpreg['numeroopcionestipopregunta'] - 1; $j++) {//numero opciones pregunta
                                        list($vl[$j], $cnt[$j]) = explode("--", $yy[$j]);
                                        $pos = comprobar($vl, $op);
                                        if ($pos === false) {
                                            $nopciones .= "<td>0</td>";
                                        } else {
                                            $nopciones .= "<td>" . $cnt[$pos] . "</td>";
                                            $total += $cnt[$pos];
                                            $tnota += $cnt[$pos] * $op;
                                        }
                                        $op++;
                                    }//numero opciones pregunta
                                    $nopciones .= "<td style='text-align: center'>" . $total . "</td>";
                                    $notan = $tnota / $total;
                                    //nota
                                    $nota = round($notan, 2);
                                    $nopciones .= "<td style='text-align: center'>" . $nota . "</td>";
                                    $sumanota += $nota;
                                    $r++;
                                    $numbersb += 2;
                                }
                                $numbers .= $nopciones;
                            }
                        }//numeral pregunta y nombre pregunta

                        $tnotaparcial = $sumanota / $r;
                        $notaparcial = round($tnotaparcial, 2);
                        $smarreglo .= $numbers . "<td style='text-align: center'>" . $notaparcial . "</td>"; //NOTA PARCIAL
                        $sumanotasparciales += $notaparcial;
                        $v++;
                    } //grupo de preguntas
                    $tnotatotal = $sumanotasparciales / $v;
                    $notatotal = round($tnotatotal, 2);
                    $smconcat .= $smarreglo . "<td style='text-align: center'>" . $notatotal . "</td>"; //NOTA TOTAL
                    $html .= $smconcat; //grupo de preguntas
                } else {



                    foreach ($datosencabezado as $grupreg) {//grupo de preguntas
                        $numbers = "";
                        $numbersc = 0;
                        foreach ($datospreg as $idpreg) {//numeral pregunta y nombre pregunta
                            if ($grupreg['idpregunta'] == $idpreg['idpreguntagrupo']) {
                                $numbersb = 0;
                                $nopciones = ""; //
                                if ($idpreg['numeroopcionestipopregunta'] == 0) {
                                    $nopciones .= "<td colspan='7' style='text-align: center'>Sin datos asociados</td>"; //
                                    $numbersb += 7;
                                } else {
                                    $numbersb += $idpreg['numeroopcionestipopregunta'];
                                    $ncol = $idpreg['numeroopcionestipopregunta'] + 2;
                                    $nopciones .= "<td colspan='" . $ncol . "' style='text-align: center'>Sin datos asociados</td>";
                                }
                                $numbers .= $nopciones;
                                $rtt = $numbersb;
                                $numbersc += $rtt;
                            }
                        }//numeral pregunta y nombre pregunta
                        $html .= $numbers . "<td style='text-align: center'>N/A</td>";
                        $rt = $numbersc + 1;
                    } //grupo de preguntas
                    $html .= "<td style='text-align: center'>N/A</td>"; //grupo de preguntas
                }
            }
            $html .= "</tr>";


            echo $html;
        }break;
    case 'Consultarencabezadonob': {
            //segun la materia se extrae el idencuesta
            $sqlidencuesta = "select e.idencuesta ";
            $sqlidencuesta .= "from encuesta e,encuestamateria em ";
            $sqlidencuesta .= "where em.codigomateria= '" . $_POST['codigomateria'] . "' ";
            $sqlidencuesta .= "and em.idencuesta=e.idencuesta";
            $datosidencuesta = $db->GetRow($sqlidencuesta);

            //grupos preguntas
            $sqlencabezado = "SELECT ";
            $sqlencabezado .= "p.idpreguntagrupo,p.idpregunta,p.idtipopregunta,p.nombrepregunta ";
            $sqlencabezado .= "FROM ";
            $sqlencabezado .= "preguntatipousuario pt, ";
            $sqlencabezado .= "tipopregunta tp, ";
            $sqlencabezado .= "pregunta p, ";
            $sqlencabezado .= "encuestapregunta ep ";
            $sqlencabezado .= "WHERE ";
            $sqlencabezado .= "ep.idencuesta = '" . $datosidencuesta['idencuesta'] . "' ";
            $sqlencabezado .= "AND pt.idpregunta = p.idpregunta ";
            $sqlencabezado .= "AND tp.idtipopregunta = p.idtipopregunta ";
            $sqlencabezado .= "AND idpreguntagrupo = '0' ";
            $sqlencabezado .= "AND p.codigoestado LIKE '1%' ";
            $sqlencabezado .= "AND pt.codigoestado LIKE '1%' ";
            $sqlencabezado .= "AND ep.idpregunta = p.idpregunta ";
            $sqlencabezado .= "ORDER BY ";
            $sqlencabezado .= "p.pesopregunta ";
            $datosencabezado = $db->GetAll($sqlencabezado);

            //concatenamos grupos pregunta      
            $tmconcat = "";
            foreach ($datosencabezado as $grupreg) {
                $tmconcat .= $grupreg['idpregunta'] . ",";
            }
            $nconcat = substr($tmconcat, 0, -1);

            //sacamos preguntas
            $sqlpreg = "SELECT p.idpregunta, p.idtipopregunta, p.idpreguntagrupo, p.nombrepregunta,tp.numeroopcionestipopregunta
                        FROM pregunta p,tipopregunta tp
                        WHERE 1 ";
            $sqlpreg .= "AND tp.idtipopregunta = p.idtipopregunta ";
            $sqlpreg .= "AND p.idpreguntagrupo IN(" . $nconcat . ") ";
            $sqlpreg .= "AND tp.idtipopregunta NOT IN (101)  ";
            $datospreg = $db->GetAll($sqlpreg);

            //para agrupar y ordenar
            $sqlgrpreg = $sqlpreg;
            $sqlgrpreg .= " GROUP BY p.idpreguntagrupo";
            $sqlgrpreg .= " ORDER BY p.idpregunta";
            $datosgrpreg = $db->GetAll($sqlgrpreg);


            $html = "<tr>
                        <th colspan='2' rowspan='3' style='text-align: center'>CARRERA</th>
                        <th colspan='2' rowspan='3' style='text-align: center'>MATERIA</th>
                        <th colspan='3' rowspan='3' style='text-align: center'>DOCENTE</th>";

            $smconcat = ""; //grupo de preguntas
            //numerales y preguntas
            $smarreglo = "<tr>"; //numeral pregunta - segunda fila
            $tmarreglo = "<tr>"; //nombre pregunta - tercera fila
            $np = 1;
            $numbers = "";
            foreach ($datosencabezado as $grupreg) {//grupo de preguntas
                $numbersc = 0;
                $tipopregconcat = "";
                foreach ($datospreg as $idpreg) {//numeral pregunta y nombre pregunta
                    if ($grupreg['idpregunta'] == $idpreg['idpreguntagrupo']) {

                        switch ($idpreg['idtipopregunta']) {
                            case '200':
                            case '201':
                                $tipopregconcat .= $idpreg['idpreguntagrupo'] . "**";
                                $numbersb = 0;
                                $nopciones = ""; //
                                if ($idpreg['numeroopcionestipopregunta'] == 0) {
                                    $nopciones .= "<th colspan='7' style='text-align: center'></th>"; //
                                    $numbersb += 7;
                                }
                                $numbers .= $nopciones;
                                $rtt = $numbersb;
                                $smarreglo .= "<th colspan='" . $rtt . "' style='text-align: center'>P" . $np . "</th>"; //numeral pregunta - segunda fila
                                $tmarreglo .= "<th colspan='" . $rtt . "' style='text-align: center'>" . $idpreg['nombrepregunta'] . "</th>"; //nombre pregunta - tercera fila
                                $np ++;
                                $numbersc += $rtt;

                                break;
                        }
                    }
                }//numeral pregunta y nombre pregunta
                $tppregconcat = substr($tipopregconcat, 0, -2);
                $tpregconcat = explode("**", $tppregconcat);
                if (in_array($grupreg['idpregunta'], $tpregconcat)) {
                    $rt = $numbersc;
                    $smconcat .= "<th colspan='" . $rt . "' style='text-align: center'>" . $grupreg['nombrepregunta'] . "</th>"; //grupo de preguntas
                }
            } //grupo de preguntas
            $smconcat .= "<th rowspan='4' style='text-align: center'>NOTA TOTAL</th>"; //grupo de preguntas
            $html .= $smconcat; //grupo de preguntas
            $html .= "</tr>";

            $smarreglo .= "</tr>"; //numeral pregunta - segunda fila
            $html .= $smarreglo;
            $tmarreglo .= "</tr>"; //nombre pregunta - tercera fila
            $html .= $tmarreglo;

            //cuarta fila
            $html .= "<tr>
                            <th style='text-align: center'>CODIGO</th>
                            <th style='text-align: center'>NOMBRE</th>
                            <th style='text-align: center'>CODIGO</th>
                            <th style='text-align: center'>NOMBRE</th>
                            <th style='text-align: center'>DOCUMENTO</th>
                            <th style='text-align: center'>APELLIDOS</th>
                            <th style='text-align: center'>NOMBRES</th>";
            $html .= $numbers;
            $html .= "</tr>";


            echo $html;
        }break;
    case 'Consultarnob': {
            //segun la materia se extrae el idencuesta
            $sqlidencuesta = "select e.idencuesta ";
            $sqlidencuesta .= "from encuesta e,encuestamateria em ";
            $sqlidencuesta .= "where em.codigomateria= '" . $_POST['codigomateria'] . "' ";
            $sqlidencuesta .= "and em.idencuesta=e.idencuesta";
            $datosidencuesta = $db->GetRow($sqlidencuesta);

            //encabezados preguntas (grupos)
            $sqlencabezado = "SELECT ";
            $sqlencabezado .= "p.idpreguntagrupo,p.idpregunta,p.nombrepregunta ";
            $sqlencabezado .= "FROM ";
            $sqlencabezado .= "preguntatipousuario pt, ";
            $sqlencabezado .= "tipopregunta tp, ";
            $sqlencabezado .= "pregunta p, ";
            $sqlencabezado .= "encuestapregunta ep ";
            $sqlencabezado .= "WHERE ";
            $sqlencabezado .= "ep.idencuesta = '" . $datosidencuesta['idencuesta'] . "' ";
            $sqlencabezado .= "AND pt.idpregunta = p.idpregunta ";
            $sqlencabezado .= "AND tp.idtipopregunta = p.idtipopregunta ";
            $sqlencabezado .= "AND idpreguntagrupo = '0' ";
            $sqlencabezado .= "AND p.codigoestado LIKE '1%' ";
            $sqlencabezado .= "AND pt.codigoestado LIKE '1%' ";
            $sqlencabezado .= "AND ep.idpregunta = p.idpregunta ";
            $sqlencabezado .= "ORDER BY ";
            $sqlencabezado .= "p.pesopregunta ";
            $datosencabezado = $db->GetAll($sqlencabezado);

            //encabezados pregunta      
            $tmconcat = "";
            foreach ($datosencabezado as $grupreg) {
                $tmconcat .= $grupreg['idpregunta'] . ",";
            }
            $nconcat = substr($tmconcat, 0, -1);

            //preguntas
            $sqlpreg = "SELECT p.idpregunta, p.idtipopregunta, p.idpreguntagrupo, p.nombrepregunta,tp.numeroopcionestipopregunta
                    FROM pregunta p,tipopregunta tp
                    WHERE 1 ";
            $sqlpreg .= "AND tp.idtipopregunta = p.idtipopregunta ";
            $sqlpreg .= "AND p.idpreguntagrupo IN(" . $nconcat . ") ";
            $sqlpreg .= "AND tp.idtipopregunta NOT IN (101)  ";
            $datospreg = $db->GetAll($sqlpreg);

            $tnarreglo = "";
            $smarreglo = "";
            $nn = 0;
            foreach ($datospreg as $idpreg) {
                $tnarreglo .= $idpreg['idpregunta'] . ",";
                $smarreglo .= $idpreg['nombrepregunta'] . "-**-";
                $nn += 1;
            }
            $narreglo = substr($tnarreglo, 0, -1);
            $arreglo = explode(",", $narreglo);
            $marreglo = substr($smarreglo, 0, -4);
            $sarreglo = explode("-**-", $marreglo);

            //para agrupar y ordenar
            $sqlgrpreg = $sqlpreg;
            $sqlgrpreg .= " GROUP BY p.idpreguntagrupo";
            $sqlgrpreg .= " ORDER BY p.idpregunta";
            $datosgrpreg = $db->GetAll($sqlgrpreg);


            $pcodigomateria = "";
            if ($_POST['codigomateria'] != "") {
                $pcodigomateria .= "AND g.codigomateria='" . $_POST['codigomateria'] . "' ";
            } else {
                $pcodigomateria .= "AND g.codigomateria IN (" . $nconcattmateria . ") ";
            }
            $pnumerodocumento = "";
            if ($_POST['numerodocumento'] != "") {
                $pnumerodocumento .= "AND g.numerodocumento='" . $_POST['numerodocumento'] . "' ";
            }
            $sqldatosdocentes = "SELECT p.codigocarrera,(SELECT nombrecarrera FROM carrera ca WHERE ca.codigocarrera=p.codigocarrera) AS nombrecarrera, 
                            m.codigomateria, m.nombremateria, d.numerodocumento, d.apellidodocente, d.nombredocente 
                            FROM materia m , planestudio p, detalleplanestudio dp ,grupo g, docente d
                            WHERE p.idplanestudio=dp.idplanestudio 
                            AND dp.codigomateria=m.codigomateria 
                            AND p.codigocarrera ='" . $_POST['prograacad'] . "' 
                            AND g.codigomateria=m.codigomateria 
                            AND g.numerodocumento=d.numerodocumento 
                            AND g.codigoperiodo='" . $_POST['periodo'] . "'
                             " . $pcodigomateria . " " . $pnumerodocumento . "   
                            AND p.codigoestadoplanestudio LIKE '1%' 
                            AND dp.codigoestadodetalleplanestudio LIKE '1%' 
                            UNION 
                            SELECT p.codigocarrera,(SELECT nombrecarrera FROM carrera ca WHERE ca.codigocarrera=p.codigocarrera) AS nombrecarrera, 
                            m.codigomateria,m.nombremateria, d.numerodocumento, d.apellidodocente, d.nombredocente 
                            FROM materia m , planestudio p, lineaenfasisplanestudio le,detallelineaenfasisplanestudio dl ,grupo g, docente d
                            WHERE dl.idlineaenfasisplanestudio=le.idlineaenfasisplanestudio 
                            AND dl.codigomateriadetallelineaenfasisplanestudio=m.codigomateria 
                            AND g.codigomateria=m.codigomateria 
                            AND g.numerodocumento=d.numerodocumento 
                            AND g.codigoperiodo='" . $_POST['periodo'] . "'
                            AND p.codigocarrera='" . $_POST['prograacad'] . "'
                             " . $pcodigomateria . " " . $pnumerodocumento . "   
                            AND p.codigoestadoplanestudio LIKE '1%' 
                            AND dl.codigoestadodetallelineaenfasisplanestudio LIKE '1%' 
                            AND le.idplanestudio=p.idplanestudio
                            UNION
                            SELECT m.codigocarrera,(SELECT nombrecarrera FROM carrera ca WHERE ca.codigocarrera=m.codigocarrera) AS nombrecarrera, 
                            m.codigomateria,m.nombremateria, d.numerodocumento, d.apellidodocente, d.nombredocente
                            FROM materia m, grupo g,docente d
                            WHERE m.codigocarrera='" . $_POST['prograacad'] . "' 
                            AND m.codigoestadomateria='01'
                            AND m.codigomateria=g.codigomateria
                            AND g.numerodocumento=d.numerodocumento
                            AND g.codigoperiodo='" . $_POST['periodo'] . "'
                             " . $pcodigomateria . " " . $pnumerodocumento . "   
                            GROUP BY g.codigomateria
                            ORDER BY nombremateria
                            ;";


            $datos = $db->GetAll($sqldatosdocentes);

            $html = "";
            foreach ($datos as $datosdocentes) {
                $html .= "<tr>
                   <td>" . $datosdocentes['codigocarrera'] . "</td>
                   <td>" . $datosdocentes['nombrecarrera'] . "</td>
                   <td>" . $datosdocentes['codigomateria'] . "</td>
                   <td>" . $datosdocentes['nombremateria'] . "</td>
                   <td>" . $datosdocentes['numerodocumento'] . "</td>
                   <td>" . $datosdocentes['apellidodocente'] . "</td>
                   <td>" . $datosdocentes['nombredocente'] . "</td>";

                $sqlresultadosevaluaciondocente = "SELECT 
                                                ep.idpregunta, 
                                                r.valorrespuestaautoevaluacion,
                                                count(distinct r.codigoestudiante) cuenta 
                                                    FROM respuestaautoevaluacion r , encuestapregunta ep, pregunta p ,prematricula pr, 
                                                    detalleprematricula dp,grupo g,docente d 
                                                    where r.idencuestapregunta=ep.idencuestapregunta 
                                                    and p.idpregunta=ep.idpregunta 
                                                    and r.valorrespuestaautoevaluacion <> '' 
                                                    and p.idtipopregunta not in (100,101,201)";
                $sqlresultadosevaluaciondocente .= " and p.idpregunta IN(" . $narreglo . ")";
                $sqlresultadosevaluaciondocente .= " and dp.idprematricula=pr.idprematricula 
                                                    and pr.codigoestudiante=r.codigoestudiante 
                                                    and pr.codigoperiodo=r.codigoperiodo 
                                                    and r.codigomateria=dp.codigomateria 
                                                    and r.codigoperiodo='" . $_POST['periodo'] . "' 
                                                    and g.idgrupo=dp.idgrupo 
                                                    and g.numerodocumento=d.numerodocumento 
                                                    and g.codigoperiodo='" . $_POST['periodo'] . "' 
                                                    and g.codigomateria='" . $datosdocentes['codigomateria'] . "' 
                                                    and d.numerodocumento='" . $datosdocentes['numerodocumento'] . "'
                                                    and r.codigoestudiante not in ( 
                                                                            SELECT r2.codigoestudiante 
                                                                            FROM respuestaautoevaluacion r2 , encuestapregunta ep2, pregunta p2 
                                                                            where r2.idencuestapregunta=ep2.idencuestapregunta 
                                                                            and p2.idpregunta=ep2.idpregunta 
                                                                            and r2.valorrespuestaautoevaluacion = '' 
                                                                            and p2.idtipopregunta not in (100,101,201) 
                                                                            and ep2.idencuesta=ep.idencuesta 
                                                                            and r2.codigoperiodo=20112 
                                                                            and r2.codigoestudiante=r.codigoestudiante 
                                                                            group by r2.codigoestudiante ) 
                                                    ";
                $sqlresultadosevaluaciondocente .= "group by d.numerodocumento,g.codigomateria,ep.idpregunta,r.valorrespuestaautoevaluacion 
                                                    order by d.numerodocumento,g.codigomateria,ep.idpregunta,r.valorrespuestaautoevaluacion ";

                $resultadosevaluaciondocente = $db->GetAll($sqlresultadosevaluaciondocente);
                if (count($resultadosevaluaciondocente)) {

                    $smconcat = ""; //grupo de preguntas
                    //numerales y preguntas
                    $smarreglo = ""; //numeral pregunta
                    $sumanotasparciales = "";
                    $v = 0;
                    foreach ($datosencabezado as $grupreg) {//grupo de preguntas
                        $numbers = "";
                        $sumanota = "";
                        $r = 0;
                        foreach ($datospreg as $idpreg) {//numeral pregunta y nombre pregunta
                            if ($grupreg['idpregunta'] == $idpreg['idpreguntagrupo']) {
                                $nopciones = ""; //
                                if ($idpreg['numeroopcionestipopregunta'] == 0) {
                                    switch ($idpreg['idtipopregunta']) {
                                        case '200':
                                        case '201':
                                            $sqlvarios = "SELECT ep.idpregunta,
                                                    r.valorrespuestaautoevaluacion
                                            FROM  respuestaautoevaluacion r,
                                                    encuestapregunta ep,
                                                    pregunta p,
                                                    prematricula pr,
                                                    detalleprematricula dp,
                                                    grupo g,
                                                    docente d
                                            WHERE r.idencuestapregunta = ep.idencuestapregunta
                                            AND p.idpregunta = ep.idpregunta
                                            AND r.valorrespuestaautoevaluacion <> ''
                                            AND p.idtipopregunta IN (201, 200)
                                            AND p.idpregunta ='" . $idpreg['idpregunta'] . "'
                                            AND dp.idprematricula = pr.idprematricula
                                            AND pr.codigoestudiante = r.codigoestudiante
                                            AND pr.codigoperiodo = r.codigoperiodo
                                            AND r.codigomateria = dp.codigomateria
                                            AND r.codigoperiodo = '" . $_POST['periodo'] . "'
                                            AND g.idgrupo = dp.idgrupo
                                            AND g.numerodocumento = d.numerodocumento
                                            AND g.codigoperiodo = '" . $_POST['periodo'] . "'
                                            AND g.codigomateria = '" . $datosdocentes['codigomateria'] . "'
                                            and d.numerodocumento ='" . $datosdocentes['numerodocumento'] . "'
                                            AND r.codigoestudiante NOT IN (
                                                    SELECT r2.codigoestudiante
                                                    FROM respuestaautoevaluacion r2,
                                                            encuestapregunta ep2,
                                                            pregunta p2
                                                    WHERE r2.idencuestapregunta = ep2.idencuestapregunta
                                                    AND p2.idpregunta = ep2.idpregunta
                                                    AND r2.valorrespuestaautoevaluacion = ''
                                                    AND p2.idtipopregunta NOT IN (100, 101, 201)
                                                    AND ep2.idencuesta = ep.idencuesta
                                                    AND r2.codigoestudiante = r.codigoestudiante
                                                    GROUP BY r2.numerodocumento
                                            )
                                            GROUP BY r.idrespuestaautoevaluacion
                                            ORDER BY r.idrespuestaautoevaluacion";
                                            $resultadosvarios = $db->GetAll($sqlvarios);
                                            $concatvar = "";
                                            foreach ($resultadosvarios as $varios) {
                                                $concatvar .= "*" . $varios['valorrespuestaautoevaluacion'] . "<br>";
                                            }
                                            $nvar = substr($concatvar, 0, -4);
                                            $nopciones .= "<td colspan='7' style='text-align: center'>" . $nvar . "</td>"; //
                                            break;
                                        default:
                                            $nopciones .= "<td colspan='7' style='text-align: center'></td>"; //
                                            break;
                                    }
                                } else {
                                    $pos = "";
                                    foreach ($resultadosevaluaciondocente as $resultados) {
                                        if ($idpreg['idpregunta'] == $resultados['idpregunta']) {
                                            $pos .= $resultados['valorrespuestaautoevaluacion'] . "--" . $resultados['cuenta'] . "|";
                                        }
                                    }
                                    $tpos = substr($pos, 0, -1);
                                    $yy = explode("|", $tpos);

                                    $op = 1;
                                    $total = 0;
                                    $tnota = 0; //
                                    for ($j = 0; $j <= $idpreg['numeroopcionestipopregunta'] - 1; $j++) {//numero opciones pregunta
                                        list($vl[$j], $cnt[$j]) = explode("--", $yy[$j]);
                                        $pos = comprobar($vl, $op);
                                        if ($pos !== false) {
                                            $total += $cnt[$pos];
                                            $tnota += $cnt[$pos] * $op;
                                        }
                                        $op++;
                                    }//numero opciones pregunta
                                    $notan = $tnota / $total;
                                    //nota
                                    $nota = round($notan, 2);
                                    $sumanota += $nota;
                                    $r++;
                                    $numbersb += 2;
                                }
                                $numbers .= $nopciones;
                            }
                        }//numeral pregunta y nombre pregunta

                        $tnotaparcial = $sumanota / $r;
                        $notaparcial = round($tnotaparcial, 2);
                        $smarreglo .= $numbers; //NOTA PARCIAL
                        $sumanotasparciales += $notaparcial;
                        $v++;
                    } //grupo de preguntas
                    $tnotatotal = $sumanotasparciales / $v;
                    $notatotal = round($tnotatotal, 2);
                    $smconcat .= $smarreglo . "<td style='text-align: center'>" . $notatotal . "</td>"; //NOTA TOTAL
                    $html .= $smconcat; //grupo de preguntas
                    
                } else {

                    foreach ($datosencabezado as $grupreg) {//grupo de preguntas
                        $numbersc = 0;
                        $tipopregconcat = "";
                        foreach ($datospreg as $idpreg) {//numeral pregunta y nombre pregunta
                            if ($grupreg['idpregunta'] == $idpreg['idpreguntagrupo']) {

                                switch ($idpreg['idtipopregunta']) {
                                    case '200':
                                    case '201':
                                        $tipopregconcat .= $idpreg['idpreguntagrupo'] . "**";
                                        $numbersb = 0;
                                        $nopciones = ""; //
                                        if ($idpreg['numeroopcionestipopregunta'] == 0) {
                                            $nopciones .= "<th colspan='7' style='text-align: center'></th>"; //
                                            $numbersb += 7;
                                        }
                                        $numbers .= $nopciones;
                                        $rtt = $numbersb;
                                        $html .= "<td colspan='" . $rtt . "' style='text-align: center'>N/A</td>"; //numeral pregunta - segunda fila
                                        $np ++;
                                        $numbersc += $rtt;

                                        break;
                                }
                            }
                        }//numeral pregunta y nombre pregunta
                    } //grupo de preguntas

                    $html .= "<td style='text-align: center'>N/A</td>"; //grupo de preguntas
                }
            }
            $html .= "</tr>";


            echo $html;
        }break;
}//switch
//end
//end
?>