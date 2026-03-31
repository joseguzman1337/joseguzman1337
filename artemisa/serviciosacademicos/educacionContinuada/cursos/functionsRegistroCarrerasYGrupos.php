<?php

@session_start();

function lookForDocentePrincipal($profesores, $db) {
    $docente = "";
    $num = count($profesores);
    $encontrado = false;
    for ($z = 0; $z < $num && !$encontrado; $z++) {
        //debe existir el profesor
        if ($profesores[$z] !== "") {
            $sql = "SELECT numerodocumento FROM docente WHERE numerodocumento='$profesores[$z]' AND codigoestado='100'";
            $result = $db->GetRow($sql);
            if ($result != null && $result != false && count($result) > 0) {
                $encontrado = true;
                $docente = $profesores[$z];
            }
        }
    }

    if (!$encontrado) {
        $docente = "";
    }
    return $docente;
}

function gestionarCiudadCurso($utils, $nombreCiudad = null) {
    //ver si toca crear la ciudad o que
    if ($_REQUEST["idciudad"] === null || $_REQUEST["idciudad"] === "null") {
        $fields = array();
        if ($nombreCiudad == null) {
            $nombreCiudad = $_REQUEST["tmp_ciudad"];
        }
        $fields["nombrecortociudad"] = $nombreCiudad;
        $fields["nombreciudad"] = $nombreCiudad;
        //extranjero
        $fields["iddepartamento"] = 216;
        $fields["codigosapciudad"] = "0";
        $fields["codigoestado"] = 100;
        $idciudad = $utils->processData("save", "ciudad", "idciudad", $fields, false);
    } else {
        $idciudad = $_REQUEST["idciudad"];
    }
    return $idciudad;
}

function crearVersionGrupo($utils, $codigoperiodo, $materia, $profesorPrincipal, $db) {
    $fields = array();
    $grupo = 0;
    $fields["nombregrupo"] = substr($_REQUEST["nombre"], 0, 20) . '-' . $codigoperiodo;
    $fields["codigomateria"] = $materia;
    $fields["codigoperiodo"] = $codigoperiodo;
    $fields["numerodocumento"] = $profesorPrincipal;
    $fields["codigoestadogrupo"] = '10';
    $fields["matriculadosgrupo"] = '0';
    $fields["codigogrupo"] = date("z") . date("y");
    if (isset($_REQUEST["cupoEstudiantes"]) && $_REQUEST["cupoEstudiantes"] != "") {
        $fields["maximogrupo"] = $_REQUEST["cupoEstudiantes"];
    } else {
        $fields["maximogrupo"] = '10000';
        $fields["matriculadosgrupo"] = '0';
        $fields["codigoestadogrupo"] = '20';
    }
    $fields["codigoindicadorhorario"] = '200';
    $fields["fechainiciogrupo"] = $_REQUEST['fechainiciogrupo'];
    $fields["fechafinalgrupo"] = $_REQUEST['fechafinalgrupo'];
    $sql = "SELECT idgrupo FROM grupo WHERE codigogrupo = '" . $fields["codigogrupo"] . "'";
    $result = $db->GetRow($sql);
    if ($result == null || count($result) == 0) {
        $grupo = $utils->processData("save", "grupo", "idgrupo", $fields, false);
    } else {
        $i = 0;
        while ($grupo == 0 && $i < 15) {
            //puede ser que se jodio porque estan tratando de crear varias versiones en el mismo dia
            $array = array("a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "z", "y");
            $fields["codigogrupo"] = $array[rand(0, count($array))] . $array[rand(0, count($array))] . $array[rand(0, count($array))] . date("y");
            $sql = "SELECT idgrupo FROM grupo WHERE codigogrupo = '" . $fields["codigogrupo"] . "'";
            $result = $db->GetRow($sql);
            if ($result == null || count($result) == 0) {
                $grupo = $utils->processData("save", "grupo", "idgrupo", $fields, false);
            }
            $i = $i + 1;
        }
    }
    return $grupo;
}

function actualizarGrupo($utils, $codigoperiodo, $materia, $profesorPrincipal, $idgrupo) {
    $fields = array();
    $grupo = $utils->getDataEntity("grupo", $idgrupo, "idgrupo");
    $fields["codigomateria"] = $materia;
    $fields["codigoperiodo"] = $codigoperiodo;
    $fields["numerodocumento"] = $profesorPrincipal;
    $fields["idgrupo"] = $idgrupo;
    $fields["codigoestadogrupo"] = '10';
    if ($grupo["matriculadosgrupo"] == "10000" || $grupo["matriculadosgrupo"] == 10000) {
        $fields["matriculadosgrupo"] = '0';
    }
    if (isset($_REQUEST["cupoEstudiantes"]) && $_REQUEST["cupoEstudiantes"] != "" && $_REQUEST["cupoEstudiantes"] != 0) {
        $fields["maximogrupo"] = $_REQUEST["cupoEstudiantes"];
    } else {
        //para los cerrados
        $fields["maximogrupo"] = '10000';
        $fields["matriculadosgrupo"] = '0';
        $fields["codigoestadogrupo"] = '20';
    }
    $fields["codigoindicadorhorario"] = '200';
    $fields["fechainiciogrupo"] = $_REQUEST['fechainiciogrupo'];
    $fields["fechafinalgrupo"] = $_REQUEST['fechafinalgrupo'];
    $utils->processData("update", "grupo", "idgrupo", $fields, false);
}

function asignarDocentesGrupo($utils, $db, $profesores, $grupo) {
    $num = count($profesores); //echo "profesores--> ".$num."<pre>";print_r($profesores);
    //inactivo por si estoy editando
    $sql = "UPDATE `relacionDocenteCursoEducacionContinuada` SET `codigoestado`=200 WHERE `idgrupo`='$grupo';";
    $db->Execute($sql);
    for ($z = 0; $z < $num; $z++) {
        //debe existir el profesor
        if ($profesores[$z] !== "") {
            $fields = array();
            $fields["idgrupo"] = $grupo;
            $fields["iddocente"] = $profesores[$z];
            $sql = "SELECT * FROM relacionDocenteCursoEducacionContinuada WHERE idgrupo='$grupo' AND iddocente='$profesores[$z]'";
            
            $row = $db->GetRow($sql);
            if ($row != null && count($row) > 0) {
                $fields["idrelacionDocenteCursoEducacionContinuada"] = $row["idrelacionDocenteCursoEducacionContinuada"];
                $utils->processData("update", "relacionDocenteCursoEducacionContinuada", "idrelacionDocenteCursoEducacionContinuada", $fields, false);
            } else {
                $utils->processData("save", "relacionDocenteCursoEducacionContinuada", "idrelacionDocenteCursoEducacionContinuada", $fields, false);
            }
        }
    }
}

function getCarreraPeriodo($utils, $db, $codigoperiodo, $codigocarrera) {
    $sql = "SELECT * FROM carreraperiodo WHERE codigocarrera='" . $codigocarrera . "' AND codigoperiodo='" . $codigoperiodo . "' ";
    $row = $db->GetRow($sql);
    if ($row != null && $row != false && count($row) > 0) {
        $carreraperiodo = $row["idcarreraperiodo"];
    } else {
        $fields = array();
        $fields["codigocarrera"] = $codigocarrera;
        $fields["codigoperiodo"] = $codigoperiodo;
        $fields["codigoestado"] = '100';

        $carreraperiodo = $utils->processData("save", "carreraperiodo", "idcarreraperiodo", $fields, false);
    }
    return $carreraperiodo;
}

function getSubperiodoCarrera($utils, $db, $peridoSelectRow, $idUsuario, $carreraperiodo) {
    $sql = "SELECT * FROM subperiodo WHERE idcarreraperiodo='" . $carreraperiodo . "' ";
    $row = $db->GetRow($sql);
    $dateHoy = date('Y-m-d H:i:s');

    if (count($row) > 0) {
        $subperiodo = $row["idsubperiodo"];
    } else {
        $fields = array();
        $fields["idcarreraperiodo"] = $carreraperiodo;
        $fields["nombresubperiodo"] = "SUBPERIODO EC " . $peridoSelectRow["codigoperiodo"];
        $fields["fechasubperiodo"] = $dateHoy;

        $fechaInicioPeriodo = $peridoSelectRow['fechainicioperiodo'];
        $fechaFinPeriodo = $peridoSelectRow['fechavencimientoperiodo'];
        $dateInicioSimple = date("Y-m-d", strtotime($fechaInicioPeriodo));
        $dateFinSimple = date("Y-m-d", strtotime($fechaFinPeriodo));

        $fields["fechainicioacademicosubperiodo"] = $dateInicioSimple;
        $fields["fechafinalacademicosubperiodo"] = $dateFinSimple;
        $fields["fechainiciofinancierosubperiodo"] = $dateInicioSimple;
        $fields["fechafinalfinancierosubperiodo"] = $dateFinSimple;
        $fields["numerosubperiodo"] = '1';
        $fields["idtiposubperiodo"] = '9';
        $fields["codigoestadosubperiodo"] = '100';
        $fields["idusuario"] = $idUsuario;
        if (preg_match('/^(\d{1,3}\.){3}\d{1,3}$/s', @$_SERVER["HTTP_X_FORWARDED_FOR"])) {
            $fields["ip"] = $_SERVER["HTTP_X_FORWARDED_FOR"];
        } else {
            $fields["ip"] = $_SERVER['REMOTE_ADDR'];
        }
        $subperiodo = $utils->processData("save", "subperiodo", "idsubperiodo", $fields, false);
    }
    return $subperiodo;
}

function actualizarValorMatricula($utils, $db, $valorMatricula, $codigocarrera) {
    $queryValor = $utils->getValorMatriculaCurso($db, $codigocarrera, true);
    $row = $db->GetRow($queryValor);
    $fields = array();
    $fields["preciovaloreducacioncontinuada"] = $valorMatricula;
    if ($row != null && count($row) > 0) {
        $fields["idvaloreducacioncontinuada"] = $row["idvaloreducacioncontinuada"];
        $utils->processData("update", "valoreducacioncontinuada", "idvaloreducacioncontinuada", $fields, false);
    } else {
        $periodo = $utils->getPeriodoActual($db);
        $fields["fechainiciovaloreducacioncontinuada"] = $periodo["fechainicioperiodo"];
        $fields["fechafinalvaloreducacioncontinuada"] = $periodo["fechavencimientoperiodo"];
        $fields["fechavaloreducacioncontinuada"] = $periodo["fechainicioperiodo"];
        $fields["codigoconcepto"] = 151;
        $fields["nombrevaloreducacioncontinuada"] = "Pago 1";
        $fields["codigocarrera"] = $codigocarrera;

        $utils->processData("save", "valoreducacioncontinuada", "idvaloreducacioncontinuada", $fields, false);
    }
}

function actualizarFechaPagoMatricula($utils, $db, $idgrupo, $fechaPago) {
    $fecha = $utils->getFechaMatricula($db, $idgrupo);
    $fields = array();
    $fields["idgrupo"] = $idgrupo;
    $fields["codigoestado"] = 100;

    if ($fecha != NULL) {

        $sql = "SELECT * FROM fechaeducacioncontinuada WHERE idgrupo='" . $idgrupo . "' AND codigoestado='100'";
        $row = $db->GetRow($sql);
        $fechaEC = $row["idfechaeducacioncontinuada"];
        $fields["idfechaeducacioncontinuada"] = $fechaEC;

        //toca actualizar
        $utils->processData("update", "fechaeducacioncontinuada", "idfechaeducacioncontinuada", $fields, false);
    } else {
        //toca crear
        $fechaEC = $utils->processData("save", "fechaeducacioncontinuada", "idfechaeducacioncontinuada", $fields, false);
    }

    $fields = array();
    $fields["idfechaeducacioncontinuada"] = $fechaEC;
    $fields["numerodetallefechaeducacioncontinuada"] = 1;
    $fields["nombredetallefechaeducacioncontinuada"] = "Pago 1";
    $fields["fechadetallefechaeducacioncontinuada"] = $fechaPago;
    $fields["porcentajedetallefechaeducacioncontinuada"] = 0;
    if ($fecha != NULL) {
        $sql = "SELECT * FROM detallefechaeducacioncontinuada WHERE idfechaeducacioncontinuada='" . $fechaEC . "'";
        $row = $db->GetRow($sql);

        $fields["iddetallefechaeducacioncontinuada"] = $row["iddetallefechaeducacioncontinuada"];

        $utils->processData("update", "detallefechaeducacioncontinuada", "iddetallefechaeducacioncontinuada", $fields, false, false);
    } else {
        $utils->processData("save", "detallefechaeducacioncontinuada", "iddetallefechaeducacioncontinuada", $fields, false);
    }
}

function getPeriodoCorrespondiente($db, $fecha) {
    $sql = "SELECT * FROM periodo WHERE '$fecha' BETWEEN fechainicioperiodo AND fechavencimientoperiodo";
    return $db->GetRow($sql);
}

function actualizarFechasInscripcionCurso($utils, $db, $codigocarrera, $fechaInicioInscripcion, $fechaFinalInscripcion, $peridoSelectRow, $idUsuario) {
    $queryfechas = $utils->getFechasInscripcionCurso($db, $codigocarrera, true);

    $periodo = getPeriodoCorrespondiente($db, $fechaFinalInscripcion);

    //obtengo o creo la carreraperiodo
    $carreraperiodo = getCarreraPeriodo($utils, $db, $periodo["codigoperiodo"], $codigocarrera);

    $subperiodo = getSubperiodoCarrera($utils, $db, $periodo, $idUsuario, $carreraperiodo);

    $row = $db->GetRow($queryfechas);
    $fields = array();
    $fields["fechacarreragrupofechainscripcion"] = $fechaInicioInscripcion;
    $fields["fechadesdecarreragrupofechainscripcion"] = $fechaInicioInscripcion;
    $fields["fechahastacarreragrupofechainscripcion"] = $fechaFinalInscripcion;
    $fields["fechahastacarreragrupofechainformacion"] = $fechaFinalInscripcion;
    $fields["ip"] = $_SERVER['REMOTE_ADDR'];
    $fields["idusuario"] = $idUsuario;
    $fields["idsubperiodo"] = $subperiodo;

    /**
     * Caso 2812 
     * @modified Luis Dario Gualteros C <castroluisd@unbosque.edu.co>
     * Se valida si la variable $row[] existe y no esta vacia 
     * @since  Julio 17, 2019.
    */
    
    if(isset($row['idcarreragrupofechainscripcion']) && !empty($row['idcarreragrupofechainscripcion'])){  
       $inscripcion = $row["idcarreragrupofechainscripcion"];
       $fields["idcarreragrupofechainscripcion"] = $row["idcarreragrupofechainscripcion"];

       $utils->processData("update", "carreragrupofechainscripcion", "idcarreragrupofechainscripcion", $fields, false);


    } else {
        $fields["idgrupo"] = 1;
        $fields["codigocarrera"] = $codigocarrera;

        $inscripcion = $utils->processData("save", "carreragrupofechainscripcion", "idcarreragrupofechainscripcion", $fields, false);

     }

    return $inscripcion;
}

function getDetalleGrupo($utils, $db, $ciudad, $grupo) {

    $sql = "SELECT * FROM detalleGrupoCursoEducacionContinuada WHERE idgrupo='" . $grupo . "' ";
    $row = $db->GetRow($sql);

    $fields = array();
    $fields["idgrupo"] = $grupo;
    $fields["ciudad"] = $ciudad;
    $fields["tipo"] = $_REQUEST['tipo'];
    //$fields["porcentajeFallasPermitidas"] = $_REQUEST['porcentajeFallasPermitidas'];
    if (count($row) > 0) {
        $result = $row["iddetalleGrupoCursoEducacionContinuada"];
        $fields["iddetalleGrupoCursoEducacionContinuada"] = $result;
        $utils->processData("update", "detalleGrupoCursoEducacionContinuada", "iddetalleGrupoCursoEducacionContinuada", $fields, false);
    } else {
        $result = $utils->processData("save", "detalleGrupoCursoEducacionContinuada", "iddetalleGrupoCursoEducacionContinuada", $fields, false);
    }
    return $result;
}

function asignarEmpresasGrupo($utils, $db, $grupo) {
    //inactivo por si estoy editando
    $sql = "UPDATE `relacionEmpresaCursoEducacionContinuada` SET `codigoestado`=200 WHERE `idgrupo`='$grupo'";
    $db->Execute($sql);
    //empresas si el curso es cerrado
    if ($_REQUEST['tipo'] == 2) {

        $empresas = $_REQUEST['idempresa'];
        $nombresE = $_REQUEST['tmp_empresa'];
        $num = count($empresas);
        for ($z = 0; $z < $num; $z++) {
            if ($nombresE[$z] != "") {
                $id = $empresas[$z];
                if (($id == null || $id === "null")) {
                    //me toca crearla
                    $fields = array();
                    $fields["nombreempresa"] = $nombresE[$z];
                    $fields["codigoestado"] = "100";
                    $fields["idcategoriaempresa"] = '12';
                    $id = $utils->processData("save", "empresa", "idempresa", $fields, false);
                }
                $sql = "SELECT * FROM relacionEmpresaCursoEducacionContinuada WHERE idgrupo='$grupo' AND idempresa='$id'";

                $fields = array();
                $fields["idgrupo"] = $grupo;
                $fields["idempresa"] = $id;
                $row = $db->GetRow($sql);
                if ($row != null && count($row) > 0) {
                    $fields["idrelacionEmpresaCursoEducacionContinuada"] = $row["idrelacionEmpresaCursoEducacionContinuada"];
                    $utils->processData("update", "relacionEmpresaCursoEducacionContinuada", "idrelacionDocenteCursoEducacionContinuada", $fields, false);
                } else {
                    $utils->processData("save", "relacionEmpresaCursoEducacionContinuada", "idrelacionEmpresaCursoEducacionContinuada", $fields, false);
                }
            }
        }
    }
}

function crearCarrera($utils, $db, $nombre, $facultad, $centroBeneficio = null) {


    $fields = array();
    $dateHoy = date('Y-m-d H:i:s');
    $fields["codigocortocarrera"] = microtime(true);
    $fields["nombrecortocarrera"] = $nombre;
    $fields["nombrecarrera"] = $nombre;
    $fields["codigofacultad"] = $facultad;
    $fields["centrocosto"] = $utils->getValorDefectoCampo($db, "Centro de Costo");
    if ($centroBeneficio != null && $centroBeneficio != "") {
        $fields["codigocentrobeneficio"] = $centroBeneficio;
    } else {
        $fields["codigocentrobeneficio"] = 'PE000090';
    }
    $fields["codigosucursal"] = '60';
    $fields["codigomodalidadacademica"] = '400';
    $fields["fechainiciocarrera"] = $dateHoy;
    $fields["iddirectivo"] = $utils->getValorDefectoCampo($db, "Directivo");
    $fields["codigotitulo"] = '23';
    $fields["codigotipocosto"] = '200';
    $fields["codigoindicadorcobroinscripcioncarrera"] = '200';
    $fields["codigoindicadorprocesoadmisioncarrera"] = '200';
    $fields["codigoindicadorplanestudio"] = '200';
    $fields["codigoindicadortipocarrera"] = '300';
    $fields["codigoreferenciacobromatriculacarrera"] = '200';
    $fields["numerodiaaspirantecarrera"] = '15';
    $fields["codigoindicadorcarreragrupofechainscripcion"] = '100';
    $fields["codigomodalidadacademicasic"] = '400';

    $sql = "SELECT codigocarrera FROM carrera WHERE nombrecarrera='$nombre' "
            . "AND codigomodalidadacademica=400 AND fechavencimientocarrera<NOW() ORDER BY codigocarrera DESC ";
    
    $cursoEC = $db->GetRow($sql);
    if (count($cursoEC) > 0) {
        $fields["codigocarrera"] = $cursoEC["codigocarrera"];
        $result = $utils->processData("update", "carrera", "codigocarrera", $fields, false);
    } else {
        $result = $utils->processData("save", "carrera", "codigocarrera", $fields, false);
    }
    $sql = "SELECT codigocarrera FROM carrera WHERE nombrecarrera='$nombre' AND codigomodalidadacademica=400 ORDER BY codigocarrera DESC";
    
    $cursoEC = $db->GetRow($sql);
    
    if (count($cursoEC) > 0) {
        $utils->asociarMisCarreras($db, $cursoEC["codigocarrera"]);
    }

    return $result;
}
