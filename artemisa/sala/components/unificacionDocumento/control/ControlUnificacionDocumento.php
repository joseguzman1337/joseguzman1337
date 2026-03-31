<?php
/**
 * @author vega Gabriel <vegagabriel@unbosque.edu.do>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package control
 */
defined('_EXEC') or die;
require_once(PATH_SITE . "/entidad/Documento.php");
require_once(PATH_SITE . "/entidad/EstudianteGeneral.php");
require_once(PATH_SITE . "/entidad/Estudiante.php");
require_once(PATH_SITE . "/entidad/EstudianteDocumento.php");
require_once(PATH_SITE . "/entidad/Inscripcion.php");
require_once(PATH_SITE . "/entidad/EstudianteCarreraInscripcion.php");
require_once(PATH_SITE . "/entidad/Usuario.php");
require_once(PATH_SITE . "/entidad/Periodo.php");

class ControlUnificacionDocumento {

    /**
     * @type adodb Object
     * @access private
     */
    private $db;

    /**
     * @type stdObject
     * @access private
     */
    private $variables;

    public function __construct($variables) {
        $this->db = Factory::createDbo();
        $this->variables = $variables;
    }

    public function unificaDocumento() {

        $tipoDocumentoAnterior = $this->variables->tipoDocumentoAnterior;
        $numeroDocumentoAnterior = $this->variables->numeroDocumentoAnterior;
        $idEstudianteGenaralAntiguo = $this->variables->idEstudianteGenaralAntiguo;
        $tipoDocumentoNuevo = $this->variables->tipoDocumentoNuevo;
        $numeroDocumentoNuevo = $this->variables->numeroDocumentoNuevo;
        $idEstudianteGenaralNuevo = $this->variables->idEstudianteGenaralNuevo;

        //Para documento Antiguo
        $this->saveEstudianteGeneral($idEstudianteGenaralAntiguo, 200);

        //Para documento Nuevo
        $this->saveEstudianteGeneral($idEstudianteGenaralNuevo, 100);

        $this->saveEstudiante($idEstudianteGenaralAntiguo, $idEstudianteGenaralNuevo);

        //inactivar registros de "idestudiantegeneral" que posiblemante esten asociados a otros "numerodocumento"
        $campoA = "idestudiantegeneral";
        $parametrosA = $idEstudianteGenaralAntiguo . "," . $idEstudianteGenaralNuevo;
        $this->saveEstudianteDocumento($campoA, $parametrosA);

        //inactivar registros de "numerodocumento" que posiblemante esten asociados a otros "idestudiantegeneral"
        $campoB = "numerodocumento";
        $parametrosB = $numeroDocumentoAnterior . "," . $numeroDocumentoNuevo;
        $this->saveEstudianteDocumento($campoB, $parametrosB);

        //activar o crear registro preciso asociado a "idestudiantegeneral", "numerodocumento", "tipodocumento"
        $campoC = "idestudiantegeneral,numerodocumento,tipodocumento";
        $parametrosC = $idEstudianteGenaralNuevo . "," . $numeroDocumentoNuevo . "," . $tipoDocumentoNuevo;
        $this->saveEstudianteDocumento($campoC, $parametrosC);

        $this->saveInscripcion($idEstudianteGenaralAntiguo, $idEstudianteGenaralNuevo);

        $this->saveEstudianteCarreraInscripcion($idEstudianteGenaralAntiguo, $idEstudianteGenaralNuevo);

        $this->saveUsuario($numeroDocumentoAnterior, $numeroDocumentoNuevo, $tipoDocumentoNuevo);

        $return = array("s" => true, "msj" => "Documento Unificado Correctamente");
        echo json_encode($return);
    }

    public function saveEstudianteGeneral($idEstudianteGeneral, $codigoEstado) {
        $EstudianteGeneral = new \EstudianteGeneral();
        $EstudianteGeneral->setDb();

        $EstudianteGeneralDAO = new Sala\entidadDAO\EstudianteGeneralDAO($EstudianteGeneral);
        $EstudianteGeneralDAO->setDb();

        $EstudianteGeneral->setIdestudiantegeneral($idEstudianteGeneral);
        $EstudianteGeneral->getById();
        $EstudianteGeneral->setCodigoestado($codigoEstado);
        $EstudianteGeneralDAO->save();
    }

    public function saveEstudiante($idEstudianteGeneralA, $idEstudianteGeneralN) {
        $Estudiante = new \Estudiante();
        $Estudiante->setDb();

        $existeEstudiante = $Estudiante->getList(" idestudiantegeneral='" . $idEstudianteGeneralA . "'");

        $EstudianteDAO = new Sala\entidadDAO\EstudianteDAO($Estudiante);
        $EstudianteDAO->setDb();
        $tamanoArrayEstudiante = sizeof($existeEstudiante);

        if ($tamanoArrayEstudiante > 0) {
            foreach ($existeEstudiante as $estudiante) {
                $Estudiante->setCodigoEstudiante($estudiante->getCodigoesEstudiante());
                $Estudiante->setCodigoCarrera($estudiante->getCodigocarrera());
                $Estudiante->setSemestre($estudiante->getSemestre());
                $Estudiante->setNumeroCohorte($estudiante->getNumerocohorte());
                $Estudiante->setCodigoTipoEstudiante($estudiante->getCodigotipoestudiante());
                $Estudiante->setCodigoSituacionCarreraEstudiante($estudiante->getCodigosituacioncarreraestudiante());
                $Estudiante->setCodigoPeriodo($estudiante->getCodigoperiodo());
                $Estudiante->setCodigoJornada($estudiante->getCodigoJornada());
                $Estudiante->setVinculacionId($estudiante->getVinculacionId());
                $Estudiante->setIdestudiantegeneral($idEstudianteGeneralN);
                $EstudianteDAO->save();
            }
        }
    }

    public function saveEstudianteDocumento($campos, $parametros) {

        $campo = explode(",", $campos);
        $tamano = sizeof($campo);
        $parametro = explode(",", $parametros);

        $venceNuevo = '2999-12-31';
        $fecha = date('Y-m-j');
        $venceAntiguo1 = strtotime('-1 day', strtotime($fecha));
        $venceAntiguo = date('Y-m-j', $venceAntiguo1);

        $EstudianteDocumento = new \EstudianteDocumento();
        $EstudianteDocumento->setDb();

        if ($tamano == 1) {
            $where = $campo[0] . " IN('" . $parametro[0] . "','" . $parametro[1] . "')";
        } else {
            $where = $campo[0] . " ='" . $parametro[0] . "' ";
            $where .= "AND " . $campo[1] . " ='" . $parametro[1] . "' ";
            $where .= "AND " . $campo[2] . " ='" . $parametro[2] . "' ";
        }

        $existenRegistrosED = $EstudianteDocumento->getList($where);

        $EstudianteDocumentoDAO = new Sala\entidadDAO\EstudianteDocumentoDAO($EstudianteDocumento);
        $EstudianteDocumentoDAO->setDb();

        $tamanoArrayEstudianteDocumento = sizeof($existenRegistrosED);

        if ($tamano > 1) {
            if ($tamanoArrayEstudianteDocumento == 0) {
                $EstudianteDocumento->setIdestudiantegeneral($parametro[0]);
                $EstudianteDocumento->setTipodocumento($parametro[1]);
                $EstudianteDocumento->setNumerodocumento($parametro[1]);

                $EstudianteDocumento->setFechainicioestudiantedocumento($fecha);
                $EstudianteDocumento->setFechavencimientoestudiantedocumento($venceNuevo);
                $EstudianteDocumentoDAO->save();
            }
        }

        if ($tamanoArrayEstudianteDocumento > 0) {
            foreach ($existenRegistrosED as $estudianteDocumentoA) {
                $EstudianteDocumento->setIdestudiantedocumento($estudianteDocumentoA->getIdestudiantedocumento());
                $EstudianteDocumento->setIdestudiantegeneral($estudianteDocumentoA->getIdestudiantegeneral());
                $EstudianteDocumento->setTipodocumento($estudianteDocumentoA->getTipodocumento());
                $EstudianteDocumento->setNumerodocumento($estudianteDocumentoA->getNumerodocumento());
                $EstudianteDocumento->setExpedidodocumento($estudianteDocumentoA->getExpedidodocumento());
                $EstudianteDocumento->setFechainicioestudiantedocumento($estudianteDocumentoA->getFechainicioestudiantedocumento());
                if ($tamano > 1) {
                    $EstudianteDocumento->setFechavencimientoestudiantedocumento($venceNuevo);
                } else {
                    $EstudianteDocumento->setFechavencimientoestudiantedocumento($venceAntiguo);
                }
                $EstudianteDocumentoDAO->save();
            }
        }
    }

    public function varInscripcion($set,$get,$saveDAO,$idEstudianteGeneral) {
        $set->setIdinscripcion($get->getIdinscripcion());
        $set->setNumeroinscripcion($get->getNumeroinscripcion());
        $set->setFotoinscripcion($get->getFotoinscripcion());
        $set->setFechainscripcion($get->getFechainscripcion());
        $set->setCodigomodalidadacademica($get->getCodigomodalidadacademica());
        $set->setCodigoperiodo($get->getCodigoperiodo());
        $set->setAnoaspirainscripcion($get->getAnoaspirainscripcion());

        $set->setIdestudiantegeneral($idEstudianteGeneral);
        $set->setCodigosituacioncarreraestudiante($get->getCodigosituacioncarreraestudiante());
        $set->setCodigoestado($get->getCodigoestado());
        $saveDAO->save();
    }
    
    public function saveInscripcion($idEstudianteGeneralA, $idEstudianteGeneralN) {
        $Inscripcion = new \Inscripcion();
        $Inscripcion->setDb();

        $existeInscripcion = $Inscripcion->getList(" idestudiantegeneral='" . $idEstudianteGeneralA . "'");

        $InscripcionDAO = new Sala\entidadDAO\InscripcionDAO($Inscripcion);
        $InscripcionDAO->setDb();

        $Periodo = new \Periodo();
        $Periodo->setDb();


        $PeriodoDAO = new Sala\entidadDAO\PeriodoDAO($Periodo);
        $PeriodoDAO->setDb();

        $tamanoArrayInscripcion = sizeof($existeInscripcion);

        if ($tamanoArrayInscripcion > 0) {
            foreach ($existeInscripcion as $inscripcion) {
                $Periodo->setCodigoperiodo($inscripcion->getCodigoperiodo());
                $Periodo->getById();
                $Periodo->getCodigoestadoperiodo();
                switch ($Periodo->getCodigoestadoperiodo()) {
                    case 3:
                        $Periodo->setCodigoestadoperiodo(2);
                        $PeriodoDAO->save();
                        $this->varInscripcion($Inscripcion,$inscripcion,$InscripcionDAO,$idEstudianteGeneralN);
                        $Periodo->setCodigoestadoperiodo(3);
                        $PeriodoDAO->save();
                    case 4:
                        $Periodo->setCodigoestadoperiodo(2);
                        $PeriodoDAO->save();
                        $this->varInscripcion($Inscripcion,$inscripcion,$InscripcionDAO,$idEstudianteGeneralN);
                        $Periodo->setCodigoestadoperiodo(4);
                        $PeriodoDAO->save();
                        break;
                    default:
                        $this->varInscripcion($Inscripcion,$inscripcion,$InscripcionDAO,$idEstudianteGeneralN);
                        break;
                }
            }
        }
    }

    public function saveEstudianteCarreraInscripcion($idEstudianteGeneralA, $idEstudianteGeneralN) {
        $EstudianteCI = new \EstudianteCarreraInscripcion();
        $EstudianteCI->setDb();

        $existeRegECI = $EstudianteCI->getList(" idestudiantegeneral='" . $idEstudianteGeneralA . "'");
        $EstudianteCIDAO = new Sala\entidadDAO\EstudianteCarreraInscripcionDAO($EstudianteCI);
        $EstudianteCIDAO->setDb();

        $tamanoArrayECI = sizeof($existeRegECI);

        if ($tamanoArrayECI > 0) {
            foreach ($existeRegECI as $estudianteCI) {
                $EstudianteCI->setIdestudiantecarrerainscripcion($estudianteCI->getIdestudiantecarrerainscripcion());
                $EstudianteCI->setCodigocarrera($estudianteCI->getCodigocarrera());
                $EstudianteCI->setIdnumeroopcion($estudianteCI->getIdnumeroopcion());
                $EstudianteCI->setIdinscripcion($estudianteCI->getIdinscripcion());
                $EstudianteCI->setIdestudiantegeneral($idEstudianteGeneralN);
                $EstudianteCI->setCodigoestado($estudianteCI->getCodigoestado());
                $EstudianteCIDAO->save();
            }
        }
    }

    public function saveUsuario($numeroDocumentoA, $numeroDocumentoN, $tipoDocumentoN) {
        $Usuario = new \Usuario();
        $Usuario->setDb();

        $existeUsuario = $Usuario->getList(" numerodocumento='" . $numeroDocumentoA . "'");

        $UsuarioDAO = new Sala\entidadDAO\UsuarioDAO($Usuario);
        $UsuarioDAO->setDb();

        $tamanoArrayUsuario = sizeof($existeUsuario);

        if ($tamanoArrayUsuario > 0) {
            foreach ($existeUsuario as $usuario) {
                $Usuario->setIdusuario($usuario->getIdusuario());
                $Usuario->setUsuario($usuario->getUsuario());
                $Usuario->setNumerodocumento($numeroDocumentoN);
                $Usuario->setTipodocumento($tipoDocumentoN);
                $Usuario->setApellidos($usuario->getApellidos());
                $Usuario->setNombres($usuario->getNombres());
                if ($usuario->getCodigotipousuario() != 900) {
                    $Usuario->setCodigousuario($numeroDocumentoN);
                } else {
                    $Usuario->setCodigousuario($usuario->getCodigousuario());
                }
                $Usuario->setSemestre($usuario->getSemestre());
                $Usuario->setCodigorol($usuario->getCodigorol());
                $Usuario->setFechainiciousuario($usuario->getFechainiciousuario());
                $Usuario->setFechavencimientousuario($usuario->getFechavencimientousuario());
                $Usuario->setFecharegistrousuario($usuario->getFecharegistrousuario());
                $Usuario->setCodigotipousuario($usuario->getCodigotipousuario());
                $Usuario->setIdusuariopadre($usuario->getIdusuariopadre());
                $Usuario->setIpaccesousuario($usuario->getIpaccesousuario());
                $Usuario->setCodigoestadousuario($usuario->getCodigoestadousuario());
                $UsuarioDAO->save();
            }
        }
    }

    public function valiDatos() {

        $this->variables->tipoDocumento;
        $this->variables->numeroDocumento;

        $EstudianteGeneral = new \EstudianteGeneral();

        $message = '';
        if (!empty($this->variables->numeroDocumento)) {
            $existeEstudianteGeneral = $EstudianteGeneral->getList(" tipodocumento='" . $this->variables->tipoDocumento . "' AND numerodocumento='" . $this->variables->numeroDocumento . "'");
            $idEg = '';
            $name = '';
            foreach ($existeEstudianteGeneral as $estudianteGeneral) {
                $idEg .= $estudianteGeneral->getIdestudiantegeneral();
                $name .= $estudianteGeneral->getNombresestudiantegeneral() . ' ' . $estudianteGeneral->getApellidosestudiantegeneral();
            }
            if (empty($name)) {
                $message .= $idEg . "-*-<strong><font color=red>Tipo  o número de documento incorrecto</font></strong>";
            } else {
                $message .= $idEg . "-*-<strong>Nombre: " . $name . "</strong>";
            }
        }
        echo $message;
    }

}
