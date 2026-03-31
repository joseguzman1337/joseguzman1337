<?php

/**
 * @author Diego Rivera<riveradiego@unbosque.edu.co>
 * @copyright Universidad el Bosque - Dirección de Tecnología
 * @package entidad
 */
defined('_EXEC') or die;
class PeriodoFinanciero {

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
     * @type varchar
     * @access private
     */
    private $nombre;

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
     * @type varchar
     * @access private
     */
    private $codigoEstado;

    /**
     * @type int
     * @access private
     */
    private $idUsuarioCreacion;

    /**
     * @type datatime
     * @access private
     */
    private $fechaCreacion;

    /**
     * @type int
     * @access private
     */
    private $idUsuarioModificacion;

    /**
     * @type datatime
     * @access private
     */
    private $fechaModificacion;

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

    public function getNombre() {
        return $this->nombre;
    }

    public function getFechaInicio() {
        return $this->fechaInicio;
    }

    public function getFechaFin() {
        return $this->fechaFin;
    }

    public function getCodigoEstado() {
        return $this->codigoEstado;
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

    public function setDb() {
        $this->db = Factory::createDbo();
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setIdPeriodoMaestro($idPeriodoMaestro) {
        $this->idPeriodoMaestro = $idPeriodoMaestro;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function setFechaInicio($fechaInicio) {
        $this->fechaInicio = $fechaInicio;
    }

    public function setFechaFin($fechaFin) {
        $this->fechaFin = $fechaFin;
    }

    public function setCodigoEstado($codigoEstado) {
        $this->codigoEstado = $codigoEstado;
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

    public function getById() {
        if (!empty($this->id)) {
            $query = "SELECT * FROM periodoFinanciero "
                    . " WHERE id = " . $this->db->qstr($this->id);

            $datos = $this->db->Execute($query);
            $d = $datos->FetchRow();

            if (!empty($d)) {
                $this->id = $d['id'];
                $this->idPeriodoMaestro = $d['idPeriodoMaestro'];
                $this->nombre = $d['nombre'];
                $this->fechaInicio = $d['fechaInicio'];
                $this->fechaFin = $d['fechaFin'];
                $this->codigoEstado = $d['codigoEstado'];
                $this->idUsuarioCreacion = $d['idUsuarioCreacion'];
                $this->fechaCreacion = $d['fechaCreacion'];
                $this->idUsuarioModificacion = $d['idUsuarioModificacion'];
                $this->fechaModificacion = $d['fechaModificacion'];
            }
        }
    }

    public static function getList($where = null) {
        $db = Factory::createDbo();
        $return = array();
        $query = "SELECT * "
                . " FROM periodoFinanciero "
                . " WHERE 1";

        if (!empty($where)) {
            $query .= " AND " . $where;
        }
        //d($query);
        $datos = $db->Execute($query);
        while ($d = $datos->FetchRow()) {
            $periodoFinanciero = new PeriodoFinanciero();
            $periodoFinanciero->setId($d['id']);
            $periodoFinanciero->setIdPeriodoMaestro($d['idPeriodoMaestro']);
            $periodoFinanciero->setNombre($d['nombre']);
            $periodoFinanciero->setFechaInicio($d['fechaInicio']);
            $periodoFinanciero->setFechaFin($d['fechaFin']);
            $periodoFinanciero->setCodigoEstado($d['codigoEstado']);
            $periodoFinanciero->setIdUsuarioCreacion($d['idUsuarioCreacion']);
            $periodoFinanciero->setFechaCreacion($d['fechaCreacion']);
            $periodoFinanciero->setIdUsuarioModificacion($d['idUsuarioModificacion']);
            $periodoFinanciero->setFechaModificacion($d['fechaModificacion']);
            $return[] = $periodoFinanciero;
            unset($periodoFinanciero);
        }
        return $return;
    }

}
