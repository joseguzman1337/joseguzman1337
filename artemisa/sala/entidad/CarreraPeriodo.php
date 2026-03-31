<?php
defined('_EXEC') or die;
/** 
 * @author Diego Rivera<riveradiego@unbosque.edu.do>
 * @copyright Universidad el Bosque - Dirección de Tecnología
 * @package entidad
*/
class CarreraPeriodo implements Entidad{
    /**
    * @type adodb Object
    * @access private
    */
    private $db;
    /**
     * @type int
     * @access private
     */
    private $idCarreraPeriodo;
    /**
     * @type varchar
     * @access private
     */
    private $codigoCarrera;
    /**
     * @type int
     * @access private
     */
    private $codigoPeriodo;
    /**
     * @type int
     * @access private
     */
    private $codigoEstado;
    
    public function __construct(){
            
    }
    
    public function setDb(){
        $this->db = Factory::createDbo();
    }
    
    public function getIdCarreraPeriodo() {
        return $this->idCarreraPeriodo;
    }

    public function getCodigoCarrera() {
        return $this->codigoCarrera;
    }

    public function getCodigoPeriodo() {
        return $this->codigoPeriodo;
    }

    public function getCodigoEstado() {
        return $this->codigoEstado;
    }

    public function setIdCarreraPeriodo($idCarreraPeriodo) {
        $this->idCarreraPeriodo = $idCarreraPeriodo;
    }

    public function setCodigoCarrera($codigoCarrera) {
        $this->codigoCarrera = $codigoCarrera;
    }

    public function setCodigoPeriodo($codigoPeriodo) {
        $this->codigoPeriodo = $codigoPeriodo;
    }

    public function setCodigoEstado($codigoEstado) {
        $this->codigoEstado = $codigoEstado;
    }

         
    public function getById(){
        
        if(!empty($this->idCarreraPeriodo)){
            $query = "SELECT * FROM carreraperiodo "
                    ." WHERE idcarreraperiodo = ".$this->db->qstr($this->idCarreraPeriodo);
            
            $datos = $this->db->Execute($query);
            $d = $datos->FetchRow();
            
            if(!empty($d)){
                $this->idCarreraPeriodo = $d['idcarreraperiodo']; 
                $this->codigoCarrera = $d['codigocarrera']; 
                $this->codigoPeriodo = $d['codigoperiodo']; 
                $this->codigoEstado = $d['codigoestado'];
            }
        }
    }
    
    public static function getList($where=null){
        $db = Factory::createDbo();
        
        $return = array();
        
        $query = "SELECT * "
                . " FROM carreraperiodo "
                . " WHERE 1";
        
        if(!empty($where)){
            $query .= " AND ".$where;
        }
        
        $datos = $db->Execute($query);
        while($d = $datos->FetchRow()){
            $carreraPeriodo = new CarreraPeriodo();
            $carreraPeriodo->setIdCarreraPeriodo($d['idcarreraperiodo']); 
            $carreraPeriodo->setCodigoCarrera($d['codigocarrera']); 
            $carreraPeriodo->setCodigoPeriodo($d['codigoperiodo']);
            $carreraPeriodo->setCodigoEstado($d['codigoestado']); 
            
            $return[] = $carreraPeriodo;
            unset($carreraPeriodo);
        }
        return $return;
    }
}
