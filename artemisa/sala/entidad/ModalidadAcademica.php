<?php
/**
 * @author Diego Rivera<riveradiego@unbosque.edu.co>
 * @copyright Universidad el Bosque - Dirección de Tecnología
 * @package entidad 
 */
defined('_EXEC') or die;
class ModalidadAcademica {

    /**
     * @type adodb Object
     * @access private
     */
    private $db;

    /**
     * @type char
     * @access private
     */
    private $codigoModalidadAcademica;

    /**
     * @type varchar
     * @access private
     */
    private $nombreModalidadAcademica;

    /**
     * @type varchar
     * @access private
     */
    private $codigoEstado;

    /**
     * @type int
     * @access private
     */
    private $pesoModalidadAcademica;

    public function __construct() {
        
    }

    public function getDb() {
        return $this->db;
    }

    public function getCodigoModalidadAcademica() {
        return $this->codigoModalidadAcademica;
    }

    public function getNombreModalidadAcademica() {
        return $this->nombreModalidadAcademica;
    }

    public function getCodigoEstado() {
        return $this->codigoEstado;
    }

    public function getPesoModalidadAcademica() {
        return $this->pesoModalidadAcademica;
    }

    public function setDb($db) {
        $this->db = $db;
    }

    public function setCodigoModalidadAcademica($codigoModalidadAcademica) {
        $this->codigoModalidadAcademica = $codigoModalidadAcademica;
    }

    public function setNombreModalidadAcademica($nombreModalidadAcademica) {
        $this->nombreModalidadAcademica = $nombreModalidadAcademica;
    }

    public function setCodigoEstado($codigoEstado) {
        $this->codigoEstado = $codigoEstado;
    }

    public function setPesoModalidadAcademica($pesoModalidadAcademica) {
        $this->pesoModalidadAcademica = $pesoModalidadAcademica;
    }

    public function getById() {
        if (!empty($this->codigoModalidadAcademica)) {
            $query = "SELECT * FROM modalidadacademica "
                    . " WHERE codigomodalidadacademica = " . $this->db->qstr($this->codigoModalidadAcademica);

            $datos = $this->db->Execute($query);
            $d = $datos->FetchRow();

            if (!empty($d)) {
                $this->codigoModalidadAcademica = $d['codigomodalidadacademica'];
                $this->nombreModalidadAcademica = $d['nombremodalidadacademica'];
                $this->codigoEstado = $d['codigoestado'];
                $this->pesoModalidadAcademica = $d['pesomodalidadacademica'];
            }
        }
    }

    public static function getList($where = null) {
        $db = Factory::createDbo();
        $return = array();
        $query = "SELECT * "
                . " FROM modalidadacademica  "
                . " WHERE 1";

        if (!empty($where)) {
            $query .= " AND " . $where;
        }

        $datos = $db->Execute($query);
        while ($d = $datos->FetchRow()) {
            $modalidadAcademica = new ModalidadAcademica();
            $modalidadAcademica->codigoModalidadAcademica = $d['codigomodalidadacademica'];
            $modalidadAcademica->nombreModalidadAcademica = $d['nombremodalidadacademica'];
            $modalidadAcademica->codigoEstado = $d['codigoestado'];
            $modalidadAcademica->pesoModalidadAcademica = $d['pesomodalidadacademica'];

            $return[] = $modalidadAcademica;
            unset($modalidadAcademica);
        }
        return $return;
    }

}
