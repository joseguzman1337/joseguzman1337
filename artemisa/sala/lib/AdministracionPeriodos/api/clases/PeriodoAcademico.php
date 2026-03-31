<?php

namespace Sala\lib\AdministracionPeriodos\api\clases;

defined('_EXEC') or die;

/**
 * Clase PeriodoAcademico encargado de la orquestacion de las funcionalidades 
 * que controlan al periodo financiero
 * 
 * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package Sala\lib\AdministracionPeriodos\api\interfaces
 */
class PeriodoAcademico implements \Sala\lib\AdministracionPeriodos\api\interfaces\IPeriodo {

    /**
     * $variables es una variable privada, contenedora de el objeto estandar en 
     * el cual se setean todas las variables recibidas por el sistema a nivel 
     * POST, GET y REQUEST
     * 
     * @var stdObject
     * @access private
     */
    private $variables;
    private $modaliadesAceptadas = array(200, 300, 800, 810);

    /**
     * Constructor de la clase PeriodoAcademico 
     * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
     * @return void
     */
    public function __construct() {
        
    }

    /**
     * Este metodo inicializa el atributo variables con el objeto variables 
     * recibido mediante el REQUEST
     * @access public
     * @param \stdClass $variables Variables recibidas del REQUEST
     * @author Andres Ariza <arizaandres@unbosque.edu.co>
     * @since febrero 19, 2019
     */
    public function setVariables($variables) {
        $this->variables = $variables;
        if (!empty($this->variables->idEstadoPeriodo) && ($this->variables->idEstadoPeriodo == "null")) {
            unset($this->variables->idEstadoPeriodo);
        }
    }

    /**
     * Retorna las variables requeridas en la vista listar periodo academico
     * @access public
     * @return array Variables necesarias para la vista listar periodo academico
     * @author Andres Ariza <arizaandres@unbosque.edu.co>
     * @since febrero 19, 2019
     */
    public function listarPeriodo() {
        $array = array();
        $where = "";
        $array["listaCarreras"] = \Carrera::getList();
        $array["listaAnios"] = \Ano::getList();
        //qstr

        if (!empty($this->variables->programaAcademico)) {
            \Factory::setSessionVar("programaAcademico", $this->variables->programaAcademico);
        } elseif (empty($this->variables->programaAcademico)) {
            $this->variables->programaAcademico = \Factory::getSessionVar("programaAcademico");
        }

        if (!empty($this->variables->anio)) {
            \Factory::setSessionVar("anio", $this->variables->anio);
        } elseif (empty($this->variables->anio)) {
            $this->variables->anio = \Factory::getSessionVar("anio");
        }

        if (isset($this->variables->anio) || isset($this->variables->programaAcademico)) {
            $where = $this->getWhere();
        }
        $array["listaPeriodosAcademicos"] = $this->getList($where);
        return $array;
    }
    
    /**
     * Retorna variable con  condiciones para realizar busqueda de periodo academico seleccionado
     * @access public
     * @return  String
     * @author Diego Rivera <riveradiego@unbosque.edu.co>
     * @since March 20, 2019
     */    
    private function getWhere(){
        $db = \Factory::createDbo();
        $where = "";
        $programaAcademico = $this->variables->programaAcademico;
        $anio = $this->variables->anio;
        if ($anio == "todos") {
            $anio = 0;
        }
        if ($programaAcademico == "todos") {
            $programaAcademico = 0;
        }

        if (!empty($anio)) {
            $periodoMaestro = \PeriodoMaestro::getList(" codigo LIKE '%" . $anio . "%'");
            $arrayAnios = array();
            if (!empty($periodoMaestro)) {
                foreach ($periodoMaestro as $PM) {
                    array_push($arrayAnios, $PM->getId());
                }
                $idPeriodoMaestro = implode(",", $arrayAnios);
            } else {
                $idPeriodoMaestro = "0";
            }
        }

        if (!empty($programaAcademico) && !empty($anio)) {
            $where = " codigoCarrera=" . $db->qstr($programaAcademico) . " AND idPeriodoMaestro in (" . $idPeriodoMaestro . ")";
        } else if (!empty($programaAcademico)) {
            $where = " codigoCarrera=" . $db->qstr($programaAcademico);
        } else if (!empty($anio)) {
            $where = " idPeriodoMaestro in (" . $idPeriodoMaestro . ")";
        }
        return $where;
    }

    /**
     * Retorna las variables requeridas en la vista para crear/editar periodo academico
     * @access public
     * @return array Variables necesarias para la vista editar periodo academico
     * @author Andres Ariza <arizaandres@unbosque.edu.co>
     * @since febrero 19, 2019
     */
    public function nuevoPeriodo() {
        $array = array();

        $array = array_merge($array, $this->getDatosEdicion());

        $listaModalidadAcademica = \ModalidadAcademica::getList(" codigoestado = 100 ORDER BY codigomodalidadacademica");
        $listaModalidades = array();
        foreach ($listaModalidadAcademica as $ma) {
            $oModAcademica = new \stdClass();
            $oModAcademica->codigo = $ma->getCodigoModalidadAcademica();
            $oModAcademica->nombre = $ma->getNombreModalidadAcademica();
            $listaModalidades[] = $oModAcademica;
        }
        unset($listaModalidadAcademica);
        $array['listaModalidadesAcademicas'] = $listaModalidades;

        $array["listaCarreras"] = array();

        $listaTodosPeriodosFinancieros = \PeriodoFinanciero::getList();
        $idAgnoActual = 0;
        $idsAgnos = array();
        foreach ($listaTodosPeriodosFinancieros as $pf) {
            $pm = new \PeriodoMaestro();
            $pm->setId($pf->getIdPeriodoMaestro());
            $pm->setDb();
            $pm->getById();

            $t = $pm->getIdAgno();
            if ($t != $idAgnoActual) {
                $idAgnoActual = $t;
                $idsAgnos[] = $idAgnoActual;
            }
            unset($pm);
        }

        $array["anio"] = \Ano::getList(" codigoestado = 100 AND idano IN (" . implode(",", $idsAgnos) . ") ");

        return $array;
    }

    /**
     * Retorna un array de DTOs de entidoades de tipo \PeriodoAcademico
     * @access public
     * @param string $where Si es necesaria, una condicion para filtrar la lista de entidades
     * @return array Array de DTOs de las entidades de periodo academico
     * @author Andres Ariza <arizaandres@unbosque.edu.co>
     * @since febrero 19, 2019
     */
    public function getList($where = null) {
        $periodos = \PeriodoAcademico::getList($where);
        $array = array();

        foreach ($periodos as $p) {

            $obj = new \stdClass();
            $eEstado = new \EstadoPeriodo();
            $objPM = new \stdClass();
            $objPF = new \stdClass();
            $objMA = new \stdClass();
            $objTP = new \stdClass();
            $objCA = new \stdClass(); //codigoEstado

            $obj->id = $p->getId();
            $obj->fechaInicio = $p->getFechaInicio();
            $obj->fechaFin = $p->getFechaFin();

            $idEstadoPeriodo = $p->getIdEstadoPeriodo();
            $eEstado->setCodigoestadoperiodo($idEstadoPeriodo);
            $eEstado->setDb();
            $eEstado->getById();

            $obj->nombreEstado = $eEstado->getNombreestadoperiodo($idEstadoPeriodo);
            $obj->codigoEstado = $idEstadoPeriodo;

            $periodoMaestro = new \PeriodoMaestro();
            $periodoMaestro->setDb();
            $periodoMaestro->setId($p->getIdPeriodoMaestro());
            $periodoMaestro->getById();

            $objPM->codigo = $periodoMaestro->getCodigo();
            $obj->periodoMaestro = $objPM;

            $periodoFinanciero = new \PeriodoFinanciero();
            $periodoFinanciero->setDb();
            $periodoFinanciero->setId($p->getIdPeriodoFinanciero());
            $periodoFinanciero->getById();

            switch ($idEstadoPeriodo) {
                case "1":
                    $obj->icon = "check-square-o text-success";
                    break;
                case "2":
                    $obj->icon = "minus-square text-danger";
                    break;
                case "3":
                    $obj->icon = "hourglass-half text-warning";
                    break;
                case "4":
                    $obj->icon = "calendar-plus-o text-info";
                    break;
            }

            $objPF->codigo = $periodoFinanciero->getNombre();
            $obj->periodoFinanciero = $objPF;
            $modalidad = $this->nombreCarreraModalidad($p->getCodigoCarrera(), $p->getCodigoModalidadAcademica());
            $obj->carrera = $modalidad;
            $array[] = $obj;
        }
        return $array;
    }

    /**
     * Guarda en base de datos el objeto creado/editado desde la vista de 
     * creacion/edicion de periodos academicos
     * @access public
     * @return array Array con la estructura de respuesta json s => estado, msj => mensaje
     * @author Andres Ariza <arizaandres@unbosque.edu.co>
     * @since febrero 19, 2019
     */
    public function guardarPeriodo() {
        if ($this->variables->codigoCarrera == "todos") {
            $this->variables->codigoCarrera = 0;
        }
        $this->setTipoPeriodo();

        $validacion = $this->validarPeriodo();
        if ($validacion["s"]) {
            $ePeriodoAcademico = new \PeriodoAcademico();

            if (!empty($this->variables->id)) {
                $ePeriodoAcademico->setDb();
                $ePeriodoAcademico->setId($this->variables->id);
                $ePeriodoAcademico->getById();
                $ePeriodoAcademico->setIdUsuarioModificacion(\Factory::getSessionVar("idusuario"));
                $ePeriodoAcademico->setFechaModificacion(date("Y-m-d H:i:s"));
            } else {
                $ePeriodoAcademico->setIdEstadoPeriodo(2);
                $ePeriodoAcademico->setCodigoModalidadAcademica($this->variables->codigoModalidadAcademica);
                $ePeriodoAcademico->setCodigoCarrera($this->variables->codigoCarrera);
                $ePeriodoAcademico->setIdTipoPeriodo($this->variables->idTipoPeriodo);
                $ePeriodoAcademico->setIdUsuarioCreacion(\Factory::getSessionVar("idusuario"));
                $ePeriodoAcademico->setFechaCreacion(date("Y-m-d H:i:s"));
            }

            if (!empty($this->variables->idEstadoPeriodo)) {
                $ePeriodoAcademico->setIdEstadoPeriodo($this->variables->idEstadoPeriodo);
            }

            $ePeriodoAcademico->setIdPeriodoMaestro($this->variables->idPeriodoMaestro);
            $ePeriodoAcademico->setIdPeriodoFinanciero($this->variables->idPeriodoFinanciero);
            $ePeriodoAcademico->setFechaInicio($this->variables->fechaInicio);
            $ePeriodoAcademico->setFechaFin($this->variables->fechaFin);
            $ip = \Sala\utiles\GetIp\GetRealIp::getRealIP();
            $ePeriodoAcademico->setIp($ip);

            $periodoAcademicoDAO = new \Sala\entidadDAO\PeriodoAcademicoDAO($ePeriodoAcademico);
            $periodoAcademicoDAO->setDb();
            $respuestaAddPeriodoAcademico = $periodoAcademicoDAO->save();

            $objetoRelacionPeriodos = new \stdClass();
            $objetoRelacionPeriodos->idPeriodoMaestro1 = $this->variables->idPeriodoMaestro;
            $objetoRelacionPeriodos->idPeriodoMaestro2 = null;
            $objetoRelacionPeriodos->idPeriodoFinanciero = $this->variables->idPeriodoFinanciero;
            $objetoRelacionPeriodos->idPeriodoAcademico = $ePeriodoAcademico->getId();

            if (empty($this->variables->id) &&
                    ($this->variables->codigoModalidadAcademica == 1) &&
                    ($this->variables->codigoCarrera == 1) &&
                    ($respuestaAddPeriodoAcademico == true)
            ) {
                $periodo = new \Sala\lib\AdministracionPeriodos\api\clases\insertTablasPeriodo\InsertTablaPeriodo(new \Periodo(), $this->variables->idPeriodoFinanciero);
                $periodo->nuevoPeriodo();
            }

            if (empty($this->variables->id) && $respuestaAddPeriodoAcademico == true) {
                $this->sincronizarTablaCarreraPeriodo($objetoRelacionPeriodos);
            }

            if ($respuestaAddPeriodoAcademico && !empty($this->variables->id)) {
                $this->iActualizaTablasPeriodos = \Sala\lib\AdministracionPeriodos\api\clases\PeriodoFacatory::IActualizarTablasPeriodos($ePeriodoAcademico);
                $this->iActualizaTablasPeriodos->actualizarTablaSubperiodo();
            }
        }
        echo json_encode($validacion);
    }

    /**
     * consulta datos para sincronizar con  la tabla carreraperido
     * @access public
     * @param obj $idPeridoAcademico 
     * @return objeto $objPeriodo
     * @author Diego Rivera <riveradiego@unbosque.edu.do>
     * @since March 11, 2019
     */
    private function sincronizarTablaCarreraPeriodo($periodosObjeto) {
        $subPeriodo = new \Sala\lib\AdministracionPeriodos\api\clases\insertTablasPeriodo\InsertTablaSubperiodo(new \Sala\entidad\Subperiodo());
        $subPeriodo->buscarSubperiodo($periodosObjeto->idPeriodoAcademico, $this->variables->codigoModalidadAcademica, $this->variables->codigoCarrera);

        $db = \Factory::createDbo();
        $carreras = array();

        $carreraPeriodo = new \Sala\lib\AdministracionPeriodos\api\clases\insertTablasPeriodo\InsertTablaCarreraPeriodo(new \CarreraPeriodo());
        $carreraPeriodo->consultarCarreraPeriodo($this->variables->codigoCarrera, $this->variables->idPeriodoMaestro, $this->variables->codigoModalidadAcademica);
        $consultaCarreraPeriodo = $carreraPeriodo->getEntidad();

        if ($this->variables->codigoModalidadAcademica == 1 && $this->variables->codigoCarrera == 1) {
            /* Se deja opcion todas las carreras y todas las modalidades :
             * 200 pregrado
             * 300 posgrado
             * 800 pregrado virtual
             * 810 pregrado virtual
             * Debido a que si no se deja filtro insertaria aproximadamente 1354 carreras
             * */
            $carreras = \Carrera::getList(" codigomodalidadacademica in (" . implode(",", $this->modaliadesAceptadas) . ")");
        } else if ($this->variables->codigoCarrera == 1) {
            $carreras = \Carrera::getList(" codigomodalidadacademica=" . $db->qstr($this->variables->codigoModalidadAcademica));
        } else {
            $carreras = \Carrera::getList(" codigocarrera=" . $db->qstr($this->variables->codigoCarrera));
        }

        if (!empty($carreras)) {

            foreach ($carreras as $todasLasCarrera) {
                $carreraPeriodo->nuevoCarreraPeriodo($todasLasCarrera->getCodigoCarrera(), $consultaCarreraPeriodo->getCodigoPeriodo(), $consultaCarreraPeriodo->getCodigoEstado(), $periodosObjeto);
                $consultaCarreraPeriodo->getIdCarreraPeriodo();
                $this->adicionarTablaSubPeriodo($subPeriodo, $consultaCarreraPeriodo->getIdCarreraPeriodo(), $periodosObjeto);
            }
        }
    }

    /**
     * Realiza insercion en tabla subperiodo
     * @access public
     * @param int $idCarreraPeriodo
     * @param subPeriodo $subPeriodo
     * @param object $periodosObjeto
     * @return boolean
     * @author Diego Rivera <riveradiego@unbosque.edu.do>
     * @since March 13, 2019
     */
    private function adicionarTablaSubPeriodo($subPeriodo = null, $idCarreraPeriodo = null, $periodosObjeto) {
        $result = false;

        if (!empty($subPeriodo)) {
            $subPeriodo->nuevoSubPeriodo($subPeriodo->getEntidad(), $idCarreraPeriodo, $periodosObjeto);
        }
        return $result;
    }

    /**
     * Valida los datos recibido del periodo financiero antes del guardado
     * @access public
     * @return array Array con la estructura de respuesta json s => estado, msj => mensaje
     * @author Andres Ariza <arizaandres@unbosque.edu.co>
     * @since febrero 19, 2019
     */
    public function validarPeriodo() {
        $return = array("s" => true, "msj" => "Periodo guardado/actualizado correctamente");

        if (empty($this->variables->id)) {
            $return = $this->validarExistenciaDelPeriodo($return);
            if (!$return["s"]) {
                return $return;
            }

            $return = $this->validarSecuenciaDelPeriodo($return);
            if (!$return["s"]) {
                return $return;
            }
        }

        $return = \Sala\lib\AdministracionPeriodos\api\clases\utiles\ValidacionesComunes::validarFechasIngresadas($return, $this->variables);
        if (!$return["s"]) {
            return $return;
        }

        if (!empty($this->variables->idEstadoPeriodo)) {
            if (!empty($this->variables->id)) {
                $ePeriodoAcademico = new \PeriodoAcademico();
                $ePeriodoAcademico->setDb();
                $ePeriodoAcademico->setId($this->variables->id);
                $ePeriodoAcademico->getById();
                $CambioEstado = PeriodoFacatory::ICambioEstadoPeriodoAcademico($this->variables);
                $return = $CambioEstado->validarEstado($return, $ePeriodoAcademico);
                unset($ePeriodoAcademico);
                if (!$return["s"]) {
                    return $return;
                }
            }
        }
        return $return;
    }

    /**
     * Valida que el codigo de periodo Academico no esté previamente creado 
     * @access public
     * @param array Array con la estructura de respuesta json  
     * @return array Array con la estructura de respuesta json s => estado, msj => mensaje
     * @author Andres Ariza <arizaandres@unbosque.edu.co>
     * @since febrero 19, 2019
     */
    private function validarExistenciaDelPeriodo($return) {
        $db = \Factory::createDbo();
        if (empty($this->variables->idPeriodoMaestro)) {
            $return["s"] = false;
            $return["msj"] = "Debe seleccionar el período";
            return $return;
        }

        $where = " codigoModalidadAcademica = " . $db->qstr($this->variables->codigoModalidadAcademica)
                . " AND codigoCarrera = " . $db->qstr($this->variables->codigoCarrera)
                . " AND idPeriodoMaestro = " . $db->qstr($this->variables->idPeriodoMaestro);

        $p = $this->getList($where);

        if (!empty($p)) {
            $return["s"] = false;
            $return["msj"] = "El periodo seleccionado ya esta asignado a un periodo financiero";
            return $return;
        }
        return $return;
    }

    /**
     * Valida que el periodo Academico respete la secuencia de creacion
     * @access private
     * @param array Array con la estructura de respuesta json 
     * @return array Array con la estructura de respuesta json s => estado, msj => mensaje
     * @author Andres Ariza <arizaandres@unbosque.edu.co>
     * @since febrero 19, 2019
     */
    private function validarSecuenciaDelPeriodo($return) {
        $db = \Factory::createDbo();

        $queryMaxPeriodo = "SELECT pm.numeroPeriodo "
                . " FROM periodoMaestro pm "
                . " INNER JOIN periodoAcademico pa ON (pa.idPeriodoMaestro = pm.id) "
                . " INNER JOIN ano a ON (pm.idAgno = a.idano) "
                . " WHERE a.idano=" . $db->qstr($this->variables->anio)
                . " AND pa.codigoModalidadAcademica = " . $db->qstr($this->variables->codigoModalidadAcademica)
                . " AND pa.codigoCarrera = " . $db->qstr($this->variables->codigoCarrera)
                . " ORDER BY pm.numeroPeriodo DESC LIMIT 1";

        $rowMaxPeriodoUsado = $db->getRow($queryMaxPeriodo);
        if (empty($rowMaxPeriodoUsado)) {
            $maxPeriodoUsado = 0;
        } else {
            $maxPeriodoUsado = $rowMaxPeriodoUsado["numeroPeriodo"];
        }
        unset($rowMaxPeriodoUsado);

        $periodoMaestro = new \PeriodoMaestro();
        $periodoMaestro->setId($this->variables->idPeriodoMaestro);
        $periodoMaestro->setDb();
        $periodoMaestro->getById();

        $numPeriodoSeleccionado = $periodoMaestro->getNumeroPeriodo();
        unset($periodoMaestro);
        if ($numPeriodoSeleccionado != ((int) $maxPeriodoUsado + 1)) {
            $return["s"] = false;
            $return["msj"] = "El periodo financiero no respeta la secuencia";
        }
        return $return;
    }

    /**
     * Retorna el nombre de un programa academico dado un codigo y modalidad academica
     * @access private
     * @param int $codigoCarrera codigo del programa academico consultado
     * @param int $modalidadCarrera codigo de la modalidad academica consultada 
     * @return string Texto con el nombre del programa academico
     * @author Andres Ariza <arizaandres@unbosque.edu.co>
     * @since febrero 19, 2019
     */
    private function nombreCarreraModalidad($codigoCarrera, $modalidadCarrera) {

        if ($codigoCarrera == 1) {
            $modalidad = new \ModalidadAcademica();
            $db = \Factory::createDbo();
            $modalidad->setDb($db);
            $modalidad->setCodigoModalidadAcademica($modalidadCarrera);
            $modalidad->getById();
            $nombreCarrera = "TODAS LAS  CARRERAS " . mb_strtoupper($modalidad->getNombreModalidadAcademica(), "UTF-8");
        } else {
            $carrera = new \Carrera();
            $carrera->setDb();
            $carrera->setCodigoCarrera($codigoCarrera);
            $carrera->getById();
            $nombreCarrera = $carrera->getNombreCarrera();
        }
        return $nombreCarrera;
    }

    /**
     * Retorna las variables requeridas en la vista para editar periodo academico
     * @access private
     * @return array Variables necesarias para la vista editar periodo academico
     * @author Andres Ariza <arizaandres@unbosque.edu.co>
     * @since febrero 19, 2019
     */
    private function getDatosEdicion() {
        $array = array();
        $ePeriodoAcademico = null;
        $eCarrera = null;
        $eAno = array();
        $listaPeriodosMaestros = array();
        $listaPeriodosFinancieros = array();
        $listaEstados = array();

        if (!empty($this->variables->id)) {
            $db = \Factory::createDbo();
            $ePeriodoAcademicoActual = new \PeriodoAcademico();
            $ePeriodoAcademicoActual->setDb();
            $ePeriodoAcademicoActual->setId($this->variables->id);
            $ePeriodoAcademicoActual->getById();
            $ePeriodoAcademico = new \stdClass();
            $ePeriodoAcademico->id = $this->variables->id;
            $ePeriodoAcademico->idPeriodoMaestro = $ePeriodoAcademicoActual->getIdPeriodoMaestro();
            $ePeriodoAcademico->codigoModalidadAcademica = $ePeriodoAcademicoActual->getCodigoModalidadAcademica();
            $ePeriodoAcademico->idPeriodoFinanciero = $ePeriodoAcademicoActual->getIdPeriodoFinanciero();
            $ePeriodoAcademico->idEstadoPeriodo = $ePeriodoAcademicoActual->getIdEstadoPeriodo();
            $ePeriodoAcademico->idTipoPeriodo = $ePeriodoAcademicoActual->getIdTipoPeriodo();
            $ePeriodoAcademico->codigoCarrera = $ePeriodoAcademicoActual->getCodigoCarrera();
            $ePeriodoAcademico->fechaInicio = $ePeriodoAcademicoActual->getFechaInicio();
            $ePeriodoAcademico->fechaFin = $ePeriodoAcademicoActual->getFechaFin();
            unset($ePeriodoAcademicoActual);

            $eCarreraActual = new \Carrera();
            $eCarreraActual->setDb();
            $eCarreraActual->setCodigocarrera($ePeriodoAcademico->codigoCarrera);
            $eCarreraActual->getById();
            $eCarrera = new \stdClass();
            $eCarrera->codigocarrera = $eCarreraActual->getCodigocarrera();
            if ($eCarreraActual->getCodigocarrera() == 0) {
                $eCarrera->nombrecarrera = "Todas las carreras";
            } else {
                $eCarrera->nombrecarrera = $eCarreraActual->getNombrecarrera();
            }
            unset($eCarreraActual);

            $ePeriodoMaestroActual = new \PeriodoMaestro();
            $ePeriodoMaestroActual->setDb();
            $ePeriodoMaestroActual->setId($ePeriodoAcademico->idPeriodoMaestro);
            $ePeriodoMaestroActual->getById();
            $eAno = new \stdClass();
            $eAno->idAgno = $ePeriodoMaestroActual->getIdAgno();

            $listaPeriodosMaestros = \PeriodoMaestro::getList(" idAgno = " . $db->qstr($eAno->idAgno));

            $idsMastros = array();
            foreach ($listaPeriodosMaestros as $p) {
                $idsMastros[] = $p->getId();
            }

            $listaPeriodosFinancieros = \PeriodoFinanciero::getList(" idPeriodoMaestro IN (" . implode(",", $idsMastros) . ")");


            $estadoPeriodo = new \EstadoPeriodo();
            $listaEstados = $estadoPeriodo->getList("");
        }


        $array['ePeriodoAcademico'] = $ePeriodoAcademico;
        $array['eCarrera'] = $eCarrera;
        $array["listaPeriodosMaestros"] = $listaPeriodosMaestros;
        $array["eAno"] = $eAno;
        $array["listaPeriodosFinancieros"] = $listaPeriodosFinancieros;
        $array["listaEstadoPeriodo"] = $listaEstados;

        return $array;
    }

    /**
     * Setea el valor para el tipo de periodo dependiendo de el rango de fechas
     * establecidas
     * @access private
     * @return void
     * @author Andres Ariza <arizaandres@unbosque.edu.co>
     * @since febrero 19, 2019
     */
    private function setTipoPeriodo() {
        $date1 = new \DateTime($this->variables->fechaInicio);
        $date2 = new \DateTime($this->variables->fechaFin);

        $diff = $date1->diff($date2);
        $d = $diff->days;

        if ($d <= 2) {
            $this->variables->idTipoPeriodo = 2;
        } elseif ($d > 2 && $d <= 7) {
            $this->variables->idTipoPeriodo = 3;
        } elseif ($d > 7 && $d <= 14) {
            $this->variables->idTipoPeriodo = 4;
        } elseif ($d > 14 && $d <= 31) {
            $this->variables->idTipoPeriodo = 5;
        } elseif ($d > 31 && $d <= 61) {
            $this->variables->idTipoPeriodo = 6;
        } elseif ($d > 61 && $d <= 186) {
            $this->variables->idTipoPeriodo = 9;
        } else {
            $this->variables->idTipoPeriodo = 10;
        }
    }

}
