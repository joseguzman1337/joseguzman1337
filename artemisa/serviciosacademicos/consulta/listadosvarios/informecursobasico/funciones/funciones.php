<?php
/*
 * @create Luis Dario Gualteros <castroluisd@unbosque.edu.co>
 * Se crea el reporte de curso Básico para listar matriculados a curso básico que posteriomente se matricularon en programas de Pregrado.
 * @since Septiembre 4 de 2018.
 */
require_once(realpath(dirname(__FILE__) . "/../../../../../sala/config/Configuration.php"));
$Configuration = Configuration::getInstance();

if ($Configuration->getEntorno() == "local" || $Configuration->getEntorno() == "pruebas") {
    @error_reporting(1023); // NOT FOR PRODUCTION SERVERS!
     require_once(PATH_ROOT . '/kint/Kint.class.php');
}

require_once(PATH_SITE . '/lib/Factory.php');
$db = Factory::createDbo();

$variables = new stdClass();
$variables->option= "";

Factory::validateSession($variables);

$user = Factory::getSessionVar('MM_Username');

switch ($_POST['action']) {

    case 'Periodo': {
            //Lista los periodos a partir del 20101 hasta el vigente.
            $sqlperiodo = "SELECT p.codigoperiodo, p.nombreperiodo FROM periodo p
                        WHERE p.codigoperiodo >= '20101'
                        AND p.codigoperiodo <= (select codigoperiodo from periodo where codigoestadoperiodo = '1')
                        ORDER BY p.codigoperiodo DESC";
            $datosperiodo = $db->GetAll($sqlperiodo);

            $selectperiodohtml = "<option value=''>Seleccione...</option>";
            foreach ($datosperiodo as $periodo) {
                $selectperiodohtml .= "<option value='" . $periodo['codigoperiodo'] . "'>" . $periodo['nombreperiodo'] . "</option>";
            }

            echo $selectperiodohtml;
        }
        break;

        case 'ConsultarMatriculadosCursoBasico': {
            $periodoc = $_POST['periodoc'];
                //Lista el total de matriculados al curso básico de acuerdo al periodo Seleccionado.
                $SQL_Matriculados = "SELECT ".
                        "eg.numerodocumento, ".
                        "CONCAT(eg.apellidosestudiantegeneral,' ',eg.nombresestudiantegeneral) AS 'NombreCompleto', ".
                        "ca.nombrecarrera, ".
                        "op.codigoperiodo, ".
                        "sce.nombresituacioncarreraestudiante, ".
                        "SUM(nh.notadefinitiva) / COUNT(nh.codigomateria) as promedio, ".
                        "CONCAT( u.usuario, '@unbosque.edu.co') AS emailinstitucional, ".
                        "eg.emailestudiantegeneral	 ".
                            "FROM ".
                                    "estudiantegeneral eg ".
                            "INNER JOIN estudiante e ON (e.idestudiantegeneral = eg.idestudiantegeneral) ".
                            "LEFT JOIN prematricula pr ON (pr.codigoestudiante = e.codigoestudiante) ".
                            "RIGHT JOIN detalleprematricula dp ON (dp.idprematricula = pr.idprematricula) ".
                            "INNER JOIN carrera ca ON (ca.codigocarrera = e.codigocarrera) ".
                            "LEFT JOIN ordenpago op ON (op.codigoestudiante = e.codigoestudiante) ".
                            "INNER JOIN situacioncarreraestudiante sce ON (e.codigosituacioncarreraestudiante = sce.codigosituacioncarreraestudiante) ".
                            "LEFT JOIN usuario u ON ( u.numerodocumento = eg.numerodocumento) ".
                            "LEFT JOIN notahistorico nh ON (e.codigoestudiante = nh.codigoestudiante) ".
                            "WHERE ".
                                    "ca.codigomodalidadacademica = 200 ".
                            "AND op.codigoperiodo = '".$periodoc."' ".
                            "AND pr.codigoperiodo = op.codigoperiodo ".
                            "AND pr.codigoestadoprematricula IN (40, 41) ".
                            "AND dp.codigoestadodetalleprematricula = 30 ".
                            "AND ca.codigocarrera IN (13) ".
                            "GROUP BY ".
                                    "eg.idestudiantegeneral ".
                            "ORDER BY ".
                                    "eg.apellidosestudiantegeneral ";
                                              
                $datos = $db->GetAll($SQL_Matriculados);

               $html = "";
               $i=1;
                foreach ($datos as $estudiante) {
                $documento = $estudiante['numerodocumento'];
                $nombre = $estudiante['NombreCompleto'];
                $carrera = $estudiante['nombrecarrera'];
                $periodo = $estudiante['codigoperiodo'];
                $situacion = $estudiante['nombresituacioncarreraestudiante'];
                $promedio = round($estudiante['promedio'], 1);
                $correoI = $estudiante['emailinstitucional'];
                $correoP = $estudiante['emailestudiantegeneral'];

                $html .= "<tr>
                                        <td>" . $i . "</td>
                                        <td>" . $documento . "</td>
                                        <td>" . $nombre . "</td>
                                        <td>" . $carrera . "</td>
                                        <td>" . $periodo . "</td>
                                        <td>" . $situacion . "</td>
                                        <td>" . $promedio . "</td>
                                        <td>" . $correoI . "</td>
                                        <td>" . $correoP . "</td>
                             </tr>";
                $i++;

            }
         echo $html;
        }break;

        case 'ConsultarMatriculadosPregrado': {
        $periodoc = $_POST['periodoc'];    
                
                if($user =='dirbasico' || $user =='adminbasico'){
                    $usuario = "";
                }else{
                  $usuario = " INNER JOIN usuariofacultad uf ON (ca.codigocarrera = uf.codigofacultad AND uf.usuario= '$user') "; 
                }
                   //Lista el  total de matriculados a algún programa de Pregrado de los que tomaron el curso de nivelación 
                   //del periodo seleccionado..
                $SQL_MatriculadosPregrado = "SELECT ".
                                "eg.numerodocumento, ".
                                "CONCAT(eg.apellidosestudiantegeneral,' ',	eg.nombresestudiantegeneral) AS 'NombreCompleto', ".
                                "ca.nombrecarrera, ".
                                "op.codigoperiodo, ".
                                "MAX(pr.semestreprematricula) AS 'Semestre', ".
                                "sce.nombresituacioncarreraestudiante, ".
                                "CONCAT( u.usuario, '@unbosque.edu.co' ) AS emailinstitucional, ".
                                "eg.emailestudiantegeneral ".	
                        "FROM ".
                                "estudiantegeneral eg ".
                        "INNER JOIN estudiante e ON (e.idestudiantegeneral = eg.idestudiantegeneral) ".
                        "LEFT JOIN prematricula pr ON (pr.codigoestudiante = e.codigoestudiante) ".
                        "RIGHT JOIN detalleprematricula dp ON (dp.idprematricula = pr.idprematricula) ".
                        "INNER JOIN carrera ca ON (ca.codigocarrera = e.codigocarrera) ".
                        "LEFT JOIN ordenpago op ON (op.codigoestudiante = e.codigoestudiante) ".
                        "INNER JOIN situacioncarreraestudiante sce ON (e.codigosituacioncarreraestudiante = sce.codigosituacioncarreraestudiante) ".
                        "LEFT JOIN usuario u ON ( u.numerodocumento = eg.numerodocumento) ".$usuario." ".
                        "WHERE ".
                                "ca.codigomodalidadacademica = 200 ".
                        "AND pr.codigoperiodo = op.codigoperiodo ".
                        "AND pr.codigoestadoprematricula IN (40, 41) ".
                        "AND dp.codigoestadodetalleprematricula = 30 ".
                        "AND e.codigocarrera <> '13' ".
                        "AND eg.idestudiantegeneral IN ( ".
                        "SELECT ".
                                "eg.idestudiantegeneral ".
                        "FROM ".
                                "estudiantegeneral eg ".
                        "INNER JOIN estudiante e ON (e.idestudiantegeneral = eg.idestudiantegeneral) ".
                        "LEFT JOIN prematricula pr ON (pr.codigoestudiante = e.codigoestudiante) ".
                        "RIGHT JOIN detalleprematricula dp ON (dp.idprematricula = pr.idprematricula) ".
                        "INNER JOIN carrera ca ON (ca.codigocarrera = e.codigocarrera) ".
                        "LEFT JOIN ordenpago op ON (op.codigoestudiante = e.codigoestudiante) ".
                        "INNER JOIN situacioncarreraestudiante sce ON (e.codigosituacioncarreraestudiante = sce.codigosituacioncarreraestudiante) ".
                        "WHERE ".
                                "ca.codigomodalidadacademica = 200 ".
                        "AND op.codigoperiodo = '".$periodoc."' ".
                        "AND pr.codigoperiodo = op.codigoperiodo ".
                        "AND pr.codigoestadoprematricula IN (40, 41) ".
                        "AND dp.codigoestadodetalleprematricula = 30 ".
                        "AND ca.codigocarrera IN (13) ".
                        "GROUP BY ".
                                "eg.idestudiantegeneral ".
                        "ORDER BY ".
                                "eg.numerodocumento ".
                        ") ".
                        "AND op.codigoperiodo > '".$periodoc."' ".
                        "GROUP BY ".
                                "e.codigoestudiante ".
                        "ORDER BY ".
                                "eg.apellidosestudiantegeneral ";
                         
                $datos = $db->GetAll($SQL_MatriculadosPregrado);

               $html = "";
               $i=1;
                foreach ($datos as $estudiantepre) {
                $documento = $estudiantepre['numerodocumento'];
                $nombre = $estudiantepre['NombreCompleto'];
                $carrera = $estudiantepre['nombrecarrera'];
                $periodo = $estudiantepre['codigoperiodo'];
                $semestre = $estudiantepre['Semestre'];
                $situacion = $estudiantepre['nombresituacioncarreraestudiante'];
                $correoI = $estudiantepre['emailinstitucional'];
                $correoP = $estudiantepre['emailestudiantegeneral'];

                $html .= "<tr>
                                    <td> " . $i . "</td>
                                    <td> " . $documento . "</td>
                                    <td> " . $nombre . "</td>
                                    <td> " . $carrera . "</td>
                                    <td> " . $periodo . "</td>
                                    <td> " . $semestre . "</td>
                                    <td> " . $situacion . "</td>
                                    <td> " . $correoI . "</td>
                                    <td> " . $correoP . "</td>
                              </tr>";
                $i++;

            }
         echo $html;
        }break;
}//switch
