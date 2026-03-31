<?php

/**
 * @author Diego Rivera<riveradiego@unbosque.edu.co>
 * @copyright Universidad el Bosque - Dirección de Tecnología
 * @package entidad
 */
defined('_EXEC') or die;
class PeriodoAcademico {

    /**
     * @type adodb Object
     * @access private
     */
    private $db;

    /**
     * @type int
     * @access private
     */
    private $id;

    /**
     * @type int
     * @access private
     */
    private $idPeriodoMaestro;

    /**
     * @type char
     * @access private
     */
    private $codigoModalidadAcademica;

    /**
     * @type int
     * @access private
     */
    private $idPeriodoFinanciero;

    /**
     * @type int
     * @access private
     */
    private $idEstadoPeriodo;

    /**
     * @type int
     * @access private
     */
    private $idTipoPeriodo;

    /**
     * @type int
     * @access private
     */
    private $codigoCarrera;

    /**
     * @type date
     * @access private
     */
    private $fechaInicio;

    /**
     * @type date
     * @access private
     */
    private $fechaFin;

    /**
     * @type int
     * @access private
     */
    private $idUsuarioCreacion;

    /**
     * @type datetime
     * @access private
     */
    private $fechaCreacion;

    /**
     * @type int
     * @access private
     */
    private $idUsuarioModificacion;

    /**
     * @type date
     * @access private
     */
    private $fechaModificacion;

    /**
     * @type varchar
     * @access private
     */
    private $ip;

    public function __construct() {
        
    }

    public function getDb() {
        return $this->db;
    }

    public function getId() {
        return $this->id;
    }

    public function getIdPeriodoMaestro() {
        return $this->idPeriodoMaestro;
    }

    public function getCodigoModalidadAcademica() {
        return $this->codigoModalidadAcademica;
    }

    public function getIdPeriodoFinanciero() {
        return $this->idPeriodoFinanciero;
    }

    public function getIdEstadoPeriodo() {
        return $this->idEstadoPeriodo;
    }

    public function getIdTipoPeriodo() {
        return $this->idTipoPeriodo;
    }

    public function getCodigoCarrera() {
        return $this->codigoCarrera;
    }

    public function getFechaInicio() {
        return $this->fechaInicio;
    }

    public function getFechaFin() {
        return $this->fechaFin;
    }

    public function getIdUsuarioCreacion() {
        return $this->idUsuarioCreacion;
    }

    public function getFechaCreacion() {
        return $this->fechaCreacion;
    }

    public function getIdUsuarioModificacion() {
        return $this->idUsuarioModificacion;
    }

    public function getFechaModificacion() {
        return $this->fechaModificacion;
    }

    public function getIp() {
        return $this->ip;
    }

    public function setDb() {
        $this->db = Factory::createDbo();
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setIdPeriodoMaestro($idPeriodoMaestro) {
        $this->idPeriodoMaestro = $idPeriodoMaestro;
    }

    public function setCodigoModalidadAcademica($codigoModalidadAcademica) {
        $this->codigoModalidadAcademica = $codigoModalidadAcademica;
    }

    public function setIdPeriodoFinanciero($idPeriodoFinanciero) {
        $this->idPeriodoFinanciero = $idPeriodoFinanciero;
    }

    public function setIdEstadoPeriodo($idEstadoPeriodo) {
        $this->idEstadoPeriodo = $idEstadoPeriodo;
    }

    public function setIdTipoPeriodo($idTipoPeriodo) {
        $this->idTipoPeriodo = $idTipoPeriodo;
    }

    public function setCodigoCarrera($codigoCarrera) {
        $this->codigoCarrera = $codigoCarrera;
    }

    public function setFechaInicio($fechaInicio) {
        $this->fechaInicio = $fechaInicio;
    }

    public function setFechaFin($fechaFin) {
        $this->fechaFin = $fechaFin;
    }

    public function setIdUsuarioCreacion($idUsuarioCreacion) {
        $this->idUsuarioCreacion = $idUsuarioCreacion;
    }

    public function setFechaCreacion($fechaCreacion) {
        $this->fechaCreacion = $fechaCreacion;
    }

    public function setIdUsuarioModificacion($idUsuarioModificacion) {
        $this->idUsuarioModificacion = $idUsuarioModificacion;
    }

    public function setFechaModificacion($fechaModificacion) {
        $this->fechaModificacion = $fechaModificacion;
    }

    public function setIp($ip) {
        $this->ip = $ip;
    }

    public function getById() {
        if (!empty($this->id)) {
            $query = "SELECT * FROM periodoAcademico "
                    . " WHERE id = " . $this->db->qstr($this->id);

            $datos = $this->db->Execute($query);
            $d = $datos->FetchRow();

            if (!empty($d)) {
                $this->id = $d['id'];
                $this->idPeriodoMaestro = $d['idPeriodoMaestro'];
                $this->codigoModalidadAcademica = $d['codigoModalidadAcademica'];
                $this->idPeriodoFinanciero = $d['idPeriodoFinanciero'];
                $this->idEstadoPeriodo = $d['idEstadoPeriodo'];
                $this->idTipoPeriodo = $d['idTipoPeriodo'];
                $this->codigoCarrera = $d['codigoCarrera'];
                $this->fechaInicio = $d['fechaInicio'];
                $this->fechaFin = $d['fechaFin'];
                $this->idUsuarioCreacion = $d['idUsuarioCreacion'];
                $this->fechaCreacion = $d['fechaCreacion'];
                $this->idUsuarioModificacion = $d['idUsuarioModificacion'];
                $this->fechaModificacion = $d['fechaModificacion'];
                $this->ip = $d['ip'];
            }
        }
    }

    public static function getList($where = null) {
        $db = Factory::createDbo();
        $return = array();
        $query = "SELECT * "
                . " FROM periodoAcademico "
                . " WHERE 1";

        if (!empty($where)) {
            $query .= " AND " . $where;
        }
        //d($query);
        $datos = $db->Execute($query);
        while ($d = $datos->FetchRow()) {
            $periodoAcademico= new PeriodoAcademico();
            $periodoAcademico->setId($d['id']);
            $periodoAcademico->setIdPeriodoMaestro($d['idPeriodoMaestro']);
            $periodoAcademico->setCodigoModalidadAcademica($d['codigoModalidadAcademica']);
            $periodoAcademico->setIdPeriodoFinanciero($d['idPeriodoFinanciero']);
            $periodoAcademico->setIdEstadoPeriodo($d['idEstadoPeriodo']);
            $periodoAcademico->setIdTipoPeriodo($d['idTipoPeriodo']);
            $periodoAcademico->setCodigoCarrera($d['codigoCarrera']);
            $periodoAcademico->setFechaInicio($d['fechaInicio']);
            $periodoAcademico->setFechaFin($d['fechaFin']);
            $periodoAcademico->setIdUsuarioCreacion($d['idUsuarioCreacion']);
            $periodoAcademico->setFechaCreacion($d['fechaCreacion']);
            $periodoAcademico->setIdUsuarioModificacion($d['idUsuarioModificacion']);
            $periodoAcademico->setFechaModificacion($d['fechaModificacion']);
            $periodoAcademico->setIp($d['ip']);            
            
            $return[] = $periodoAcademico;
            unset($periodoAcademico);
        }
        return $return;
    }

}
