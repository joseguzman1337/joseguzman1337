<?php
/**
 * @author Andres Ariza <arizaandres@unbosque.edu.do>
 * @copyright Universidad el Bosque - Dirección de Tecnología
 * @package entidad
 * 
*/
defined('_EXEC') or die;
class Votacion implements Entidad{
    /**
     * @type adodb Object
     * @access private
     */
    private $db;
    
    /**
     * @type int
     * @access private
     */
    private $idvotacion;
    
    /**
     * @type varchar
     * @access private
     */
    private $nombrevotacion;
    
    /**
     * @type varchar
     * @access private
     */
    private $descripcionvotacion;
    
    /**
     * @type datetime
     * @access private
     */
    private $fechainiciovotacion;
    
    /**
     * @type datetime
     * @access private
     */
    private $fechafinalvotacion;
    
    /**
     * @type date
     * @access private
     */
    private $fechainiciovigenciacargoaspiracionvotacion;
    
    /**
     * @type date
     * @access private
     */
    private $fechafinalvigenciacargoaspiracionvotacion;
    
    /**
     * @type char
     * @access private
     */
    private $codigoestado;
    
    /**
     * @type int
     * @access private
     */
    private $idtipocandidatodetalleplantillavotacion;
    
    public function __construct() {
    }
    
    public function setDb(){
        $this->db = Factory::createDbo();
    }
    
    public function getIdvotacion() {
        return $this->idvotacion;
    }

    public function getNombrevotacion() {
        return $this->nombrevotacion;
    }

    public function getDescripcionvotacion() {
        return $this->descripcionvotacion;
    }

    public function getFechainiciovotacion() {
        return $this->fechainiciovotacion;
    }

    public function getFechafinalvotacion() {
        return $this->fechafinalvotacion;
    }

    public function getFechainiciovigenciacargoaspiracionvotacion() {
        return $this->fechainiciovigenciacargoaspiracionvotacion;
    }

    public function getFechafinalvigenciacargoaspiracionvotacion() {
        return $this->fechafinalvigenciacargoaspiracionvotacion;
    }

    public function getCodigoestado() {
        return $this->codigoestado;
    }

    public function getIdtipocandidatodetalleplantillavotacion() {
        return $this->idtipocandidatodetalleplantillavotacion;
    }

    public function setIdvotacion($idvotacion) {
        $this->idvotacion = $idvotacion;
    }

    public function setNombrevotacion($nombrevotacion) {
        $this->nombrevotacion = $nombrevotacion;
    }

    public function setDescripcionvotacion($descripcionvotacion) {
        $this->descripcionvotacion = $descripcionvotacion;
    }

    public function setFechainiciovotacion($fechainiciovotacion) {
        $this->fechainiciovotacion = $fechainiciovotacion;
    }

    public function setFechafinalvotacion($fechafinalvotacion) {
        $this->fechafinalvotacion = $fechafinalvotacion;
    }

    public function setFechainiciovigenciacargoaspiracionvotacion($fechainiciovigenciacargoaspiracionvotacion) {
        $this->fechainiciovigenciacargoaspiracionvotacion = $fechainiciovigenciacargoaspiracionvotacion;
    }

    public function setFechafinalvigenciacargoaspiracionvotacion($fechafinalvigenciacargoaspiracionvotacion) {
        $this->fechafinalvigenciacargoaspiracionvotacion = $fechafinalvigenciacargoaspiracionvotacion;
    }

    public function setCodigoestado($codigoestado) {
        $this->codigoestado = $codigoestado;
    }

    public function setIdtipocandidatodetalleplantillavotacion($idtipocandidatodetalleplantillavotacion) {
        $this->idtipocandidatodetalleplantillavotacion = $idtipocandidatodetalleplantillavotacion;
    }

    public function getById(){
        if(!empty($this->idvotacion)){
            $query = "SELECT * FROM votacion "
                    . "WHERE idvotacion = ".$this->db->qstr($this->idvotacion);
            
            $datos = $this->db->Execute($query);
            $d = $datos->FetchRow();
            
            if(!empty($d)){
                $this->nombrevotacion = $d['nombrevotacion'];
                $this->descripcionvotacion = $d['descripcionvotacion'];
                $this->fechainiciovotacion = $d['fechainiciovotacion'];
                $this->fechafinalvotacion = $d['fechafinalvotacion'];
                $this->fechainiciovigenciacargoaspiracionvotacion = $d['fechainiciovigenciacargoaspiracionvotacion'];
                $this->fechafinalvigenciacargoaspiracionvotacion = $d['fechafinalvigenciacargoaspiracionvotacion'];
                $this->codigoestado = $d['codigoestado'];
                $this->idtipocandidatodetalleplantillavotacion = $d['idtipocandidatodetalleplantillavotacion'];
            }
        }
    } 

    public function getVotacionVigente(){
        $query = "SELECT * FROM votacion v "
                . "WHERE v.codigoestado=100 "
                . "AND v.idtipocandidatodetalleplantillavotacion=1 "
                . "AND now() BETWEEN v.fechainiciovotacion AND v.fechafinalvotacion ";
        //d($query);
        $datos = $this->db->Execute($query);
        $d = $datos->FetchRow();

        if(!empty($d)){//idvotacion
            $this->idvotacion = $d['idvotacion'];
            $this->nombrevotacion = $d['nombrevotacion'];
            $this->descripcionvotacion = $d['descripcionvotacion'];
            $this->fechainiciovotacion = $d['fechainiciovotacion'];
            $this->fechafinalvotacion = $d['fechafinalvotacion'];
            $this->fechainiciovigenciacargoaspiracionvotacion = $d['fechainiciovigenciacargoaspiracionvotacion'];
            $this->fechafinalvigenciacargoaspiracionvotacion = $d['fechafinalvigenciacargoaspiracionvotacion'];
            $this->codigoestado = $d['codigoestado'];
            $this->idtipocandidatodetalleplantillavotacion = $d['idtipocandidatodetalleplantillavotacion'];
        }
    }
    public static function getList($where) {
        $arrayReturn = array();
        return $arrayReturn;
    }

}
/*/
idvotacion	int(11)
nombrevotacion	varchar(100)
descripcionvotacion	varchar(255)
fechainiciovotacion	datetime
fechafinalvotacion	datetime
fechainiciovigenciacargoaspiracionvotacion	date
fechafinalvigenciacargoaspiracionvotacion	date
codigoestado	char(3)
idtipocandidatodetalleplantillavotacion	int(11)
/**/