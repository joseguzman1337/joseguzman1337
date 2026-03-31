<?php
   /**
    * Caso 2812 
    * @modified Luis Dario Gualteros C <castroluisd@unbosque.edu.co>
    * Se realiza limpieza de código y se eliminan die; que generan error 
    * Y no permite la creación de programas de Educación Continuada.
    * @since  Julio 17, 2019.
   */
@session_start();


include_once(realpath(dirname(__FILE__)) . "/../variables.php");
include($rutaTemplate . "template.php");
include_once("./functionsRegistroCarrerasYGrupos.php");
require("../../../sala/entidad/LogGrupo.php");
require("../../../sala/entidadDAO/LogGrupoDAO.php");

$db = getBD();

$utils = Utils::getInstance();

$action = $_REQUEST["action"];
$entity = $_REQUEST["entity"];
$message = null;
$result = 0;


if ($entity == "carrera") {
    //verificar si la ciudad hay que agregarla o que... Solo cuando es presencial
    if ($_REQUEST["categoria"] != 2) {
        $_POST["ciudad"] = gestionarCiudadCurso($utils);
    } else {
        $_POST["ciudad"] = null;
    }

    //SI ES UNA CARRERA NUEVA 
    if ($action == "save") {

        $fields = array();
        $dateHoy = date('Y-m-d H:i:s');
        $peridoSelectRow = $utils->getPeriodoActual($db);

        $dateHoySimple = date('Y-m-d');
        //CREA LA CARRERA
        $result = crearCarrera($utils, $db, $_REQUEST["nombre"], $_REQUEST["codigofacultad"], $_REQUEST["codigocentrobeneficio"]);

        if ($result != 0) {
            $_POST["codigocarrera"] = $result;
            $resultCarrera = $result;

            if ($_REQUEST["tipoCertificacion"] == 3) {
                $creditos = $_REQUEST["numerocreditos"];
            } else {
                $creditos = 0;
            }

            //JORNADA DE LA CARRERA
            $fields = array();
            $fields["nombrejornadacarrera"] = $_REQUEST["nombre"];
            $fields["codigocarrera"] = $result;
            $fields["codigojornada"] = '01';
            $fields["numerominimocreditosjornadacarrera"] = $creditos;
            $fields["numeromaximocreditosjornadacarrera"] = $creditos;
            $fields["fechajornadacarrera"] = $dateHoySimple;
            $fields["fechadesdejornadacarrera"] = $dateHoySimple;
            $fields["fechahastajornadacarrera"] = '2999-01-01';
            $jornada = $utils->processData("save", "jornadacarrera", "idjornadacarrera", $fields, false);

            $fields = array();
            $fields["nombrecortomateria"] = $_REQUEST["nombre"];
            $fields["nombremateria"] = $_REQUEST["nombre"];
            $fields["numerocreditos"] = $creditos;
            $fields["codigoperiodo"] = $peridoSelectRow["codigoperiodo"];
            $fields["codigomodalidadmateria"] = '01';
            $fields["codigolineaacademica"] = '001';
            $fields["codigocarrera"] = $result;
            $fields["codigoindicadorgrupomateria"] = '200';
            $fields["codigotipomateria"] = '1';
            $fields["codigoestadomateria"] = '01';
            $fields["ulasc"] = '0';
            $fields["codigoindicadorcredito"] = '100';
            $fields["codigoindicadoretiquetamateria"] = '100';
            $fields["codigotipocalificacionmateria"] = '100';

            $materia = $utils->processData("save", "materia", "codigomateria", $fields, false);

            $data2 = $utils->getUser();
            $idUsuario = $data2['idusuario'];

            $profesores = $_REQUEST['idprofesor'];
            $profesorPrincipal = lookForDocentePrincipal($profesores, $db);
            $grupo = crearVersionGrupo($utils, $peridoSelectRow["codigoperiodo"], $materia, $profesorPrincipal, $db);

            if ($grupo != 0) {
                asignarDocentesGrupo($utils, $db, $profesores, $grupo);

                //Valor matricula y fechas de inscripcion que maneja sala
                actualizarValorMatricula($utils, $db, $_REQUEST["valorMatricula"], $result);

                //fecha pago matriculas
                actualizarFechaPagoMatricula($utils, $db, $grupo, $_REQUEST["fechaFinalMatriculas"]);

                $carreragrupo = actualizarFechasInscripcionCurso($utils, $db, $result, $_REQUEST["fechaInicioInscripcion"], $_REQUEST["fechaFinalInscripcion"], $peridoSelectRow, $idUsuario);
                $detalle = getDetalleGrupo($utils, $db, $_POST["ciudad"], $grupo);
            } else {
                $message = 'Ha ocurrido un problema al tratar de crear el grupo/nueva versión del curso.';
            }

            //empresas si el curso es cerrado
            asignarEmpresasGrupo($utils, $db, $grupo);
            //detalleCurso            
            $result = $utils->processData("save", "detalleCursoEducacionContinuada", "iddetalleCursoEducacionContinuada");
        }
        $data = array('success' => true, 'message' => 'Se ha registrado el curso de forma correcta.', 'id' => $resultCarrera);

        echo json_encode($data);
        die;
    }
    //action save
    else {
        //ya esta creada la carrera es solo el detalle
        $action2 = "save";
        if (isset($_REQUEST["iddetalleCursoEducacionContinuada"])) {
            $action2 = "update";
        }
        //con créditos
        if ($_REQUEST["tipoCertificacion"] == 3) {
            $fields = array();
            $fields["codigomateria"] = $_REQUEST["codigomateria"];
            $fields["numerocreditos"] = $_REQUEST["numerocreditos"];
            $utils->processData("update", "materia", "codigomateria", $fields, false);
        }

        $fields = array();
        $fields["codigocarrera"] = $_REQUEST["codigocarrera"];
        $fields["nombrecarrera"] = $_REQUEST["nombre"];
        $fields["codigofacultad"] = $_REQUEST["codigofacultad"];
        $fields["codigocentrobeneficio"] = $_REQUEST["codigocentrobeneficio"];
        $utils->processData("update", "carrera", "codigocarrera", $fields, false);

        $result = $utils->processData($action2, "detalleCursoEducacionContinuada", "iddetalleCursoEducacionContinuada");

        $data = array('success' => true, 'message' => 'Se han guardado los cambios de forma correcta.', 'id' => $_REQUEST["codigocarrera"]);
        echo json_encode($data);
        die;
    }
} //$entity 



switch ($action) {
    case 'inactivate': {
            $now = date('Y-m-d H-i-s');
            $sql = "UPDATE carrera SET fechavencimientocarrera = NOW() WHERE codigocarrera = '" . $_REQUEST["id"] . "'";
            $result = $db->Execute($sql);
            $utils->quitarMisCarreras($db, $_REQUEST["id"]);
            $data = array('success' => true, 'message' => "El curso se ha descontinuado correctamente.");
            echo json_encode($data);
            die;
        }break;
    case 'inactivateEntity': {
            $fields["id" . $_REQUEST["entity"]] = $_REQUEST["id"];
            $result = $utils->processData("inactivate", $_REQUEST["entity"], "id" . $_REQUEST["entity"], $fields, false);
            $data = array('success' => true, 'message' => 'Se ha eliminado el pago de forma correcta.', 'id' => $_REQUEST["id"]);
            echo json_encode($data);
            die;
        }break;
    case 'inactivateGrupo': {
            $sql = "UPDATE grupo SET codigoestadogrupo = 20 WHERE idgrupo = '" . $_REQUEST["id"] . "'";
            $result = $db->Execute($sql);

            #Instancia de objecto de LOgGrupo para insercion del log
            $logGroupObject = new LogGrupo($_REQUEST["id"]);
            $logGroupDAO = new \Sala\entidadDAO\LogGrupoDAO($logGroupObject);
            $logGroupDAO->save();

            $data = array('success' => true, 'message' => 'Se ha eliminado el grupo de forma correcta.', 'id' => $_REQUEST["id"]);
            echo json_encode($data);
            die;
        }
        break;
    case 'saveValoresPecunarios': {
            $periodo = $utils->getPeriodoActual($db);
            $codigocarrera = $_REQUEST["codigocarrera"];
            $sql = "SELECT idfacturavalorpecuniario as id FROM facturavalorpecuniario WHERE codigoperiodo='" . $periodo["codigoperiodo"] . "' 
                    AND codigocarrera = '" . $codigocarrera . "'";
            $result = $db->GetRow($sql);
            if (count($result) > 0) {
                //ya existe entonces se inactivan los anteriores valores
                $sql = "UPDATE `detallefacturavalorpecuniario` SET `codigoestado`=200 WHERE `idfacturavalorpecuniario`='" . $result["id"] . "';";
                $db->Execute($sql);
            } else {
                //toca crearlo
                $fields["nombrefacturavalorpecuniario"] = "FACTURA " . $periodo["codigoperiodo"];
                $fields["fechafacturavalorpecuniario"] = date("Y-m-d H:i:s");
                $fields["codigoperiodo"] = $periodo["codigoperiodo"];
                $fields["codigocarrera"] = $codigocarrera;
                $utils->processData("save", "facturavalorpecuniario", "idfacturavalorpecuniario", $fields, false);
                $result = $db->GetRow($sql);
            }

            $arreglo = $_REQUEST["aplica"];
            foreach ($arreglo as $valor) {
                $fields = array();
                $valores = explode(";", $valor);
                $sql = "SELECT iddetallefacturavalorpecuniario as id FROM detallefacturavalorpecuniario 
                WHERE idfacturavalorpecuniario='" . $result["id"] . "'  
                AND idvalorpecuniario = '" . $valores[0] . "' AND codigotipoestudiante = '" . $valores[1] . "'";
                $row = $db->GetRow($sql);
                $fields["idfacturavalorpecuniario"] = $result["id"];
                $fields["idvalorpecuniario"] = $valores[0];
                $fields["codigotipoestudiante"] = $valores[1];
                $fields["codigoestado"] = 100;
                if (count($row) > 0) {
                    //existe solo activarlo
                    $fields["iddetallefacturavalorpecuniario"] = $row["id"];
                    $utils->processData("update", "detallefacturavalorpecuniario", "iddetallefacturavalorpecuniario", $fields, false);
                } else {
                    $utils->processData("save", "detallefacturavalorpecuniario", "iddetallefacturavalorpecuniario", $fields, false);
                }
            }//foreach

            $data = array('success' => false, 'message' => 'Se han guardado los valores de forma correcta.');
            echo json_encode($data);
            die;
        }
        break;
    case 'savePagoPatrocinado': {
            if ($_REQUEST["idEmpresa"] == null || $_REQUEST["idEmpresa"] === "null") {
                //me toca crear la empresa
                $fields = array();
                $fields["nombreempresa"] = $_REQUEST["tmp_empresa"];
                $fields["codigoestado"] = "100";
                $fields["idcategoriaempresa"] = '12';
                $_POST["idEmpresa"] = $utils->processData("save", "empresa", "idempresa", $fields, false);
            } else {
                $_POST["idEmpresa"] = $_REQUEST["idEmpresa"];
            }

            $result = $utils->processData("save", $_REQUEST["entity"], "id" . $_REQUEST["entity"]);
            if ($result == 0) {
                $result = -1;
                $data = array('success' => false, 'message' => 'Ha ocurrido un error al registrar el pago.');
            } else {
                $datos = $utils->getDataEntity($_REQUEST["entity"], $result, "id" . $_REQUEST["entity"]);
                $empresa = $utils->getDataEntity("empresa", $datos["idEmpresa"], "idempresa");
                $data = array('success' => true, 'message' => 'Se ha registrado el pago de forma correcta.', 'data' => $datos, 'dataEmpresa' => $empresa);
            }
            echo json_encode($data);
            die;
        }
        break;
    case 'saveGroup': {

            //verificar si la ciudad hay que agregarla o que... Solo cuando es presencial
            if ($_REQUEST["categoria"] != 2) {
                $_POST["ciudad"] = gestionarCiudadCurso($utils);
            } else {
                $_POST["ciudad"] = null;
            }

            if (!isset($_REQUEST["iddetalleCursoEducacionContinuada"])) {
                $result = $utils->processData("save", "detalleCursoEducacionContinuada", "iddetalleCursoEducacionContinuada");
            }

            $dateHoy = date('Y-m-d H:i:s');
            $dateHoySimple = date('Y-m-d');
            /*
             * Se agrega el if para validar que fechainiciogrupo y fechafinalgrupo sean asociados al respectivo periodo 
             * y se comenta $peridoSelectRow =  $utils->getPeriodoActual($db);
             * Vega Gabriel <vegagabriel@unbosque.edu.do>.
             * Universidad el Bosque - Direccion de Tecnologia.
             * Modificado 16 de Mayo de 2018.
             */
//            $peridoSelectRow =  $utils->getPeriodoActual($db); 

            $fdate = explode("-", $_REQUEST['fechainiciogrupo']);

            /*
             * Se modifica el if para validar que fechainiciogrupo sea el unico asociado al respectivo periodo 
             * Vega Gabriel <vegagabriel@unbosque.edu.do>.
             * Universidad el Bosque - Direccion de Tecnologia.
             * Modificado 17 de Mayo de 2018.
             */
            if (($_REQUEST['fechainiciogrupo'] >= $fdate[0] . '-01-01') && ($_REQUEST['fechainiciogrupo'] <= $fdate[0] . '-06-30')) {
                $period = $fdate[0] . '1';
            } else if (($_REQUEST['fechainiciogrupo'] >= $fdate[0] . '-07-01') && ($_REQUEST['fechainiciogrupo'] <= $fdate[0] . '-12-31')) {
                $period = $fdate[0] . '2';
            }
//            end
            $profesores = $_REQUEST['idprofesor'];
            $profesorPrincipal = lookForDocentePrincipal($profesores, $db);
            //crear la nueva version grupo
            if (!isset($_REQUEST["idgrupo"])) {

                $grupo = crearVersionGrupo($utils, $period, $_REQUEST["codigomateria"], $profesorPrincipal, $db);
                #Instancia de objecto de LOgGrupo para insercion del log
                $logGroupObject = new LogGrupo($grupo);
            } else {
                $grupo = $_REQUEST["idgrupo"];
                actualizarGrupo($utils, $period, $_REQUEST["codigomateria"], $profesorPrincipal, $grupo);
                #Instancia de objecto de LOgGrupo para insercion del log
                $logGroupObject = new LogGrupo($grupo);
            }
        $logGroupDAO = new \Sala\entidadDAO\LogGrupoDAO($logGroupObject);
        $logGroupDAO->save();
            
            if ($grupo != 0) {
                asignarDocentesGrupo($utils, $db, $profesores, $grupo);

                //si es un curso abierto
                //Valor matricula y fechas de inscripcion que maneja sala
                actualizarValorMatricula($utils, $db, $_REQUEST["valorMatricula"], $_REQUEST["codigocarrera"]);

                //fecha pago matriculas
                actualizarFechaPagoMatricula($utils, $db, $grupo, $_REQUEST["fechaFinalMatriculas"]);

                $data2 = $utils->getUser();
                $idUsuario = $data2['idusuario'];
                $carreragrupo = actualizarFechasInscripcionCurso($utils, $db, $_REQUEST["codigocarrera"], $_REQUEST["fechaInicioInscripcion"], $_REQUEST["fechaFinalInscripcion"], $peridoSelectRow, $idUsuario);
                //}

                $result = getDetalleGrupo($utils, $db, $_POST["ciudad"], $grupo);

                //empresas si el curso es cerrado
                asignarEmpresasGrupo($utils, $db, $grupo);
            } else {
                $message = 'Ha ocurrido un problema al tratar de crear el grupo/nueva versión del curso.';
                //no pudo crear el grupo ... fuck!
                $data = array('success' => false, 'message' => $message);
                echo json_encode($data);
                die;
            }

            $data = array('success' => true, 'message' => 'Se han guardado los cambios de forma correcta.', 'id' => $_REQUEST["codigocarrera"]);
            echo json_encode($data);
            die;
        }
        break;
    /*
     * Ivan Dario Quintero Rios
     * Febrero 8 del 2018
     * creacion de funcion
     */
    case 'asignar': {
            $codigocarrera = $_REQUEST['codigocarrera'];
            $agrupacion = $_REQUEST['agrupacion'];

            $sqlconsulta = "select AgrupacionCarreraEducacionContinuadaId, CarreraEducacionContinuadaId from CarrerasEducacionContinuada where codigocarrera = '" . $codigocarrera . "' and codigoestado= 100";
            $resultado = $db->GetRow($sqlconsulta);

            if ($resultado['AgrupacionCarreraEducacionContinuadaId'] == null || $resultado['AgrupacionCarreraEducacionContinuadaId'] == "") {
                $sqlinsert = "INSERT INTO CarrerasEducacionContinuada (AgrupacionCarreraEducacionContinuadaId, CodigoCarrera, CodigoEstado) VALUES ('" . $agrupacion . "', '" . $codigocarrera . "', '100')";
                $db->Execute($sqlinsert);

                $message = "Se asigna la nueva agrupacion a la carrera.";
                $result = true;
            } else {
                $sqlupdate = "UPDATE CarrerasEducacionContinuada SET AgrupacionCarreraEducacionContinuadaId='" . $agrupacion . "' WHERE (CarreraEducacionContinuadaId='" . $resultado['CarreraEducacionContinuadaId'] . "') ";
                $db->Execute($sqlupdate);

                $message = "Se actualiza la nueva agrupacion a la carrera.";
                $result = true;
            }

            $data = array('success' => $result, 'message' => $message);
            echo json_encode($data);
            die;
        }
        break;
    case 'nuevaagrupacion': {
            $nombre = $_POST['nombre'];
            $codigocarrera = $_POST['codigocarrera'];

            $sqlbuscar1 = "select NombreAgrupacion, CodigoEstado from AgrupacionCarreraEducacionContinuada where NombreAgrupacion = '" . $nombre . "'";
            $nombreagrupacion = $db->GetRow($sqlbuscar1);

            if ($nombreagrupacion['NombreAgrupacion'] != $nombre) {
                $sqlinsert = "INSERT INTO AgrupacionCarreraEducacionContinuada (NombreAgrupacion, CodigoEstado) VALUES ('" . $nombre . "', '100')";
                $db->Execute($sqlinsert);

                $sqlbuscar = "select AgrupacionCarreraEducacionContinuadaId from AgrupacionCarreraEducacionContinuada where NombreAgrupacion = '" . $nombre . "'";
                $idagrupacion = $db->GetRow($sqlbuscar);

                $sqlupdate = "UPDATE CarrerasEducacionContinuada SET CodigoEstado='200' WHERE CodigoCarrera='" . $codigocarrera . "'";
                $db->Execute($sqlupdate);

                $sqlinsertcarrera = "INSERT INTO CarrerasEducacionContinuada (AgrupacionCarreraEducacionContinuadaId, CodigoCarrera, CodigoEstado) VALUES ('" . $idagrupacion['AgrupacionCarreraEducacionContinuadaId'] . "', '" . $codigocarrera . "', '100')";
                $db->Execute($sqlinsertcarrera);

                $data = array('success' => true, 'message' => "Agrupacion creada correctamente y asignada.");
                echo json_encode($data);
                die;
            } else {
                if ($nombreagrupacion['CodigoEstado'] == 100) {
                    $data = array('success' => false, 'message' => "El nombre que trata de crear ya se encuetra creado");
                    echo json_encode($data);
                    die;
                } else {
                    $data = array('success' => false, 'message' => "El nombre que trata de crear ya se encuetra creado y esta en estado inactivo.");
                    echo json_encode($data);
                    die;
                }
            }
        }
        break;
    /* END */
}


// Do lots of devilishly clever analysis and processing here...
if ($result == 0) {
    // Set up associative array
    if ($message === null) {
        $data = array('success' => false, 'message' => 'Ha ocurrido un problema al tratar de crear el curso.');
    } else {
        $data = array('success' => false, 'message' => $message);
    }

    // JSON encode and send back to the server
    echo json_encode($data);
} else {
    echo json_encode($data);
}

