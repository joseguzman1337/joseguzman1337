<?php
/** 
 * @author Diego Rivera<riveradiego@unbosque.edu.co>
 * @copyright Universidad el Bosque - Dirección de Tecnología
 * @package entidad 
 */
defined('_EXEC') or die;
class Ano {

    /**
     * @type adodb Object
     * @access private
     */
    private $db;

    /**
     * @type int
     * @access private
     */
    private $idAno;

    /**
     * @type varchar
     * @access private
     */
    private $codigoAno;

    /**
     * @type varchar
     * @access private
     */
    private $nombreAno;

    /**
     * @type char
     * @access private
     */
    private $codigoEstado;

    public function __construct() {
        
    }

    public function getDb() {
        return $this->db;
    }

    public function getIdAno() {
        return $this->idAno;
    }

    public function getCodigoAno() {
        return $this->codigoAno;
    }

    public function getNombreAno() {
        return $this->nombreAno;
    }

    public function getCodigoEstado() {
        return $this->codigoEstado;
    }

    public function setDb($db) {
        $this->db = $db;
    }

    public function setIdAno($idAno) {
        $this->idAno = $idAno;
    }

    public function setCodigoAno($codigoAno) {
        $this->codigoAno = $codigoAno;
    }

    public function setNombreAno($nombreAno) {
        $this->nombreAno = $nombreAno;
    }

    public function setCodigoEstado($codigoEstado) {
        $this->codigoEstado = $codigoEstado;
    }

    public function getById() {
        if (!empty($this->idAno)) {
            $query = "SELECT * FROM ano "
                    . " WHERE idano = " . $this->db->qstr($this->idAno);

            $datos = $this->db->Execute($query);
            $d = $datos->FetchRow();

            if (!empty($d)) {
                $this->idAno = $d['idano'];
                $this->codigoAno = $d['codigoano'];
                $this->nombreAno = $d['nombreano'];
                $this->codigoEstado = $d['codigoestado'];
            }
        }
    }

    public static function getList($where = null) {
        $db = Factory::createDbo();
        $return = array();
        $query = "SELECT * "
                . " FROM ano "
                . " WHERE 1";

        if (!empty($where)) {
            $query .= " AND " . $where;
        }

        $datos = $db->Execute($query);
        while ($d = $datos->FetchRow()) {
            $ano = new Ano();
            $ano->idAno = $d['idano'];
            $ano->codigoAno = $d['codigoano'];
            $ano->nombreAno = $d['nombreano'];
            $ano->codigoEstado= $d['codigoestado'];
            $return[] = $ano;
            unset($ano);
        }
        return $return;
    }

}
