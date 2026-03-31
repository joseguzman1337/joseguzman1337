<?php

@error_reporting(1023); // NOT FOR PRODUCTION SERVERS!
@ini_set('display_errors', '1'); // NOT FOR PRODUCTION SERVERS!
/**
 * Se incluye el archivo adaptador para tener acceso a las funciones basicas de
 * del nuevo sala si la aplicacion se corre en un entorno local o de pruebas 
 * se activa la visualizacion de todos los errores de php
 * @modified Andres Ariza <andresariza@unbosque.edu.do>.
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @since 01 de octubre de 2018.
 */
require_once(realpath(dirname(__FILE__) . "/../../../sala/includes/adaptador.php"));
/**
 * El metodo Factory::validateSession($variables) hace una validacion de session activa en el sistema
 * dependiendo de los parametros que se le envíen, si determina que la session acabo redirige el sistema al login
 */
Factory::validateSession($variables);

require_once(PATH_ROOT . '/assets/lib/View.php');

$rutaVistas = "../view"; /* carpeta donde se guardaran las vistas (html) de la aplicación */
require_once(realpath(dirname(__FILE__)) . "/../../../Mustache/load.php"); /* Ruta a /html/Mustache */
$template_index = $mustache->loadTemplate('Formulas'); /* carga la plantilla index */
//$template_instituciones = $mustache->loadTemplate('Instituciones');
//$template_detallesformual = $mustache->loadTemplate('DetallesFormula');

switch (@$_POST['Accion']) {
    case 'instituciones': {
            $codigocarrera = $_POST['codigocarrera'];

            $sqlcarrera = "select nombrecarrera from carrera where codigocarrera = '" . $codigocarrera . "'";
            $nombrecarrera = $db->GetRow($sqlcarrera);

            /**
             * Se hace un pequeño ajuste a la consulta para no mostrar datos duplicados
             * @modified Andres Ariza <andresariza@unbosque.edu.do>.
             * @copyright Dirección de Tecnología Universidad el Bosque
             * @since 01 de octubre de 2018.
             */
            $sqlentidades = "SELECT ( @ROW := @ROW + 1 ) AS ROW, "
                    . " InstitucionConvenioId, NombreInstitucion, ConvenioId, IdContraprestacion, FormulaLiquidacionId, "
                    . " formula, FechaInicioVigencia, FechaFinVigencia, FechaCreacion  "
                    . " FROM ( SELECT @ROW := 0 ) r, "
                    . " (SELECT DISTINCTROW ic.InstitucionConvenioId, "
                    . "   ic.NombreInstitucion, "
                    . "   c.ConvenioId, "
                    . "   cc.IdContraprestacion, "
                    . "   f.FormulaLiquidacionId, "
                    . "   f.formula, "
                    . "   f.FechaInicioVigencia, "
                    . "   f.FechaFinVigencia, "
                    . "   f.FechaCreacion "
                    . "   FROM conveniocarrera cc "
                    . "   INNER JOIN Convenios c ON c.ConvenioId = cc.ConvenioId "
                    . "   INNER JOIN InstitucionConvenios ic ON ic.InstitucionConvenioId = c.InstitucionConvenioId "
                    . "   LEFT JOIN FormulaLiquidaciones f ON (f.ConvenioId = c.ConvenioId AND f.codigocarrera = cc.Codigocarrera AND f.codigoestado='100'  )"
                    . "   WHERE cc.codigocarrera = '" . $codigocarrera . "' " 
                    . "   AND cc.codigoestado='100' ) d";
            
            $entidades = $db->GetAll($sqlentidades);

            $sqlcampos = "SELECT cf.CamposFormulaId, cf.Nombre FROM CamposFormulas cf where cf.codigoestado ='100'";
            $campos = $db->GetAll($sqlcampos);

            $c = 0;
            foreach ($entidades as $formulas) {
                $formula = $formulas['formula'];
                if ($formula) {
                    $formulatotal = '';
                    $datos = explode(",", $formula);
                    $numero = count($datos);
                    $f = 'a';
                    for ($i = 0; $i <= $numero; $i++) {
                        if ($f == 'a') {
                            foreach ($campos as $nombres) {
                                $numeros = explode("-", @$datos[$i]);
                                if ($numeros[0] == '3' || $numeros[0] == '6' || $numeros[0] == '9' || $numeros[0] == '12' || $numeros[0] == '11' || $numeros[0] == '15' || $numeros[0] == '16' || $numeros[0] == '17') {
                                    if ($nombres['CamposFormulaId'] == $numeros[0]) {
                                        $formulatotal .= $nombres['Nombre'] . "(" . $numeros[1] . ") ";
                                        $f = 'b';
                                    }
                                } else {
                                    if ($nombres['CamposFormulaId'] == @$datos[$i]) {
                                        $formulatotal .= $nombres['Nombre'] . " ";
                                        $f = 'b';
                                    }
                                }
                            }
                        } else {
                            if ($f == 'b') {
                                switch (@$datos[$i]) {
                                    case '1': {
                                            $formulatotal .= "* ";
                                            $f = 'a';
                                        }break;
                                    case '2': {
                                            $formulatotal .= "/ ";
                                            $f = 'a';
                                        }break;
                                    case '3': {
                                            $formulatotal .= "- ";
                                            $f = 'a';
                                        }break;
                                    case '4': {
                                            $formulatotal .= "+ ";
                                            $f = 'a';
                                        }break;
                                    case '': {
                                            $f = 0;
                                        }break;
                                }//switch
                            }
                        }
                    }
                    $entidades[$c]['formula'] = $formulatotal;
                }//if formula
                $c++;
            }//foreach entidades

            /**
             * Se cambia el uso de mustache por un renderizador mas flexible que permite
             * el uso de php para validaciones y otras dentro del template
             * @modified Andres Ariza <andresariza@unbosque.edu.do>.
             * @copyright Dirección de Tecnología Universidad el Bosque
             * @since 01 de octubre de 2018.
             */
            $path = PATH_ROOT . "/serviciosacademicos/convenio/view";
            $layout = "Instituciones";
            $view = new View($layout, $path);

            $variables = array(
                'title' => 'Entidades de Salud',
                'Entidades' => $entidades,
                'codigocarrera' => $codigocarrera,
                'Nombreprograma' => $nombrecarrera['nombrecarrera']
            );
            
            foreach ($variables as $k => $v) {
                $view->assign($k, $v);
            }
            $view->getResult();
        }break;
    case 'Detalles': {
            /**
             * Se agrega el uso de rangos de vigencia para la formula
             * @modified Andres Ariza <andresariza@unbosque.edu.do>.
             * @copyright Dirección de Tecnología Universidad el Bosque
             * @since 01 de octubre de 2018.
             */
            $fechaInicioVigencia = "";
            $fechaFinVigencia = "";
            if (!empty($_POST['FormulaLiquidacionId'])){
                $query = "SELECT FechaInicioVigencia, FechaFinVigencia "
                        . " FROM FormulaLiquidaciones "
                        . " WHERE FormulaLiquidacionId = ".$_POST['FormulaLiquidacionId'];
                //d($query);
                $data = $db->GetRow($query);
                $fechaInicioVigencia = $data['FechaInicioVigencia'];
                $fechaFinVigencia = $data['FechaFinVigencia'];
                
            }
            $carrera = $_POST['codigocarrera'];

            $sqlcarrera = "select nombrecarrera from carrera where codigocarrera = '" . $carrera . "'";
            $nombrecarrera = $db->GetRow($sqlcarrera);

            $convenio = $_POST['ConvenioId'];
            $formulaanterior = $_POST['formula'];
            $InstitucionConvenioId = $_POST['InstitucionConvenioId'];

            $sqlinstitucion = "select NombreInstitucion from InstitucionConvenios where InstitucionConvenioId = '" . $InstitucionConvenioId . "'";
            $nombreinstitucion = $db->GetRow($sqlinstitucion);

            if ($formulaanterior) {
                $div = 'block';
            } else {
                $div = 'none';
            }
            $IdContraprestacion = $_POST['IdContraprestacion'];
            $sqlcampos = "SELECT cf.CamposFormulaId, cf.Nombre FROM CamposFormulas cf where cf.codigoestado ='100' order by Nombre";
            $campos = $db->GetAll($sqlcampos);

            $simbolos[0]['id'] = '1';
            $simbolos[0]['simbolo'] = '*';
            $simbolos[1]['id'] = '2';
            $simbolos[1]['simbolo'] = '/';
            $simbolos[2]['id'] = '3';
            $simbolos[2]['simbolo'] = '-';
            $simbolos[3]['id'] = '4';
            $simbolos[3]['simbolo'] = '+';

            /**
             * Se cambia el uso de mustache por un renderizador mas flexible que permite
             * el uso de php para validaciones y otras dentro del template
             * @modified Andres Ariza <andresariza@unbosque.edu.do>.
             * @copyright Dirección de Tecnología Universidad el Bosque
             * @since 01 de octubre de 2018.
             */
            $path = PATH_ROOT . "/serviciosacademicos/convenio/view";
            $layout = "DetallesFormula";
            $view = new View($layout, $path);

            $variables = array(
                'title' => 'FORMULA',
                'campos' => $campos,
                'simbolos' => $simbolos,
                'codigocarrera' => $carrera,
                'ConvenioId' => $convenio,
                'IdContraprestacion' => $IdContraprestacion,
                'fechaInicioVigencia' => $fechaInicioVigencia,
                'fechaFinVigencia' => $fechaFinVigencia,
                'formulaLiquidacionId' => @$_POST['FormulaLiquidacionId'],
                'formulaanterior' => $formulaanterior,
                'div' => $div,
                'nombreinstitucion' => $nombreinstitucion['NombreInstitucion'],
                'nombreprograma' => $nombrecarrera['nombrecarrera']
            );
            //d($variables);
            foreach ($variables as $k => $v) {
                $view->assign($k, $v);
            }
            $view->getResult(); /**/
            //echo $template_detallesformual->render();
        }break;
    case '': {
            $sqlprogramas = "SELECT DISTINCT c.codigocarrera, c.nombrecarrera, c.codigomodalidadacademica, m.nombremodalidadacademica FROM conveniocarrera cc INNER JOIN carrera c on c.codigocarrera = cc.codigocarrera INNER JOIN modalidadacademica m on m.codigomodalidadacademica = c.codigomodalidadacademica order by c.codigomodalidadacademica ASC";
            $programas = $db->GetAll($sqlprogramas);

            echo $template_index->render(array(
                'title' => 'FORMULAS LIQUIDACIONES',
                'programas' => $programas
            ));
        }break;
}
?>