<?php
/**
 * @author Andres Ariza <arizaandres@unbosque.edu.do>
 * @copyright Universidad el Bosque - Dirección de Tecnología
 * @package entidad
*/
defined('_EXEC') or die;
class Prematricula implements Entidad{
    /**
     * @type adodb Object
     * @access private
     */
    private $db;
    
    /**
     * @type int
     * @access private
     */
    private $idprematricula;
    
    /**
     * @type Date
     * @access private
     */
    private $fechaprematricula;
    
    /**
     * @type int
     * @access private
     */
    private $codigoestudiante;
    
    /**
     * @type String
     * @access private
     */
    private $codigoperiodo;
    
    /**
     * @type String
     * @access private
     */
    private $codigoestadoprematricula;
    
    /**
     * @type String
     * @access private
     */
    private $observacionprematricula;
    
    /**
     * @type String
     * @access private
     */
    private $semestreprematricula;
    
    public function __construct(){
    }
    
    public function setDb(){
        $this->db = Factory::createDbo();
    }
    public function getIdprematricula() {
        return $this->idprematricula;
    }

    public function getFechaprematricula() {
        return $this->fechaprematricula;
    }

    public function getCodigoestudiante() {
        return $this->codigoestudiante;
    }

    public function getCodigoperiodo() {
        return $this->codigoperiodo;
    }

    public function getCodigoestadoprematricula() {
        return $this->codigoestadoprematricula;
    }

    public function getObservacionprematricula() {
        return $this->observacionprematricula;
    }

    public function getSemestreprematricula() {
        return $this->semestreprematricula;
    }

    public function setIdprematricula($idprematricula) {
        $this->idprematricula = $idprematricula;
    }

    public function setFechaprematricula($fechaprematricula) {
        $this->fechaprematricula = $fechaprematricula;
    }

    public function setCodigoestudiante($codigoestudiante) {
        $this->codigoestudiante = $codigoestudiante;
    }

    public function setCodigoperiodo($codigoperiodo) {
        $this->codigoperiodo = $codigoperiodo;
    }

    public function setCodigoestadoprematricula($codigoestadoprematricula) {
        $this->codigoestadoprematricula = $codigoestadoprematricula;
    }

    public function setObservacionprematricula($observacionprematricula) {
        $this->observacionprematricula = $observacionprematricula;
    }

    public function setSemestreprematricula($semestreprematricula) {
        $this->semestreprematricula = $semestreprematricula;
    }

    public function getById() {
        if(!empty($this->idprematricula)){
            $query = "SELECT * FROM prematricula "
                    ." WHERE idprematricula = ".$this->db->qstr($this->idprematricula);
            
            $datos = $this->db->Execute($query);
            $d = $datos->FetchRow();
            
            if(!empty($d)){
                $this->fechaprematricula = $d['fechaprematricula']; 
                $this->codigoestudiante = $d['codigoestudiante']; 
                $this->codigoperiodo = $d['codigoperiodo']; 
                $this->codigoestadoprematricula = $d['codigoestadoprematricula']; 
                $this->observacionprematricula = $d['observacionprematricula']; 
                $this->semestreprematricula = $d['semestreprematricula']; 
            }
        }
    }

    public static function getList($where=null) { 
        $db = Factory::createDbo();
        
        $return = array();
        
        $query = "SELECT * "
                . " FROM prematricula "
                . " WHERE 1";
        
        if(!empty($where)){
            $query .= " AND ".$where;
        }
        
        $datos = $db->Execute($query);
        while($d = $datos->FetchRow()){
            $Prematricula = new Prematricula();
            $Prematricula->idprematricula = $d['idprematricula']; 
            $Prematricula->fechaprematricula = $d['fechaprematricula']; 
            $Prematricula->codigoestudiante = $d['codigoestudiante']; 
            $Prematricula->codigoperiodo = $d['codigoperiodo']; 
            $Prematricula->codigoestadoprematricula = $d['codigoestadoprematricula']; 
            $Prematricula->observacionprematricula = $d['observacionprematricula']; 
            $Prematricula->semestreprematricula = $d['semestreprematricula']; 
                
            $return[] = $Prematricula;
            unset($Prematricula);
        }
        return $return;
    }

}
/*/
idprematricula	int(11)
fechaprematricula	date
codigoestudiante	int(11)
codigoperiodo	varchar(8)
codigoestadoprematricula	char(2)
observacionprematricula	varchar(100)
semestreprematricula	char(2)
/**/