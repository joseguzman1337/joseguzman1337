<?php
/** 
 * @author Andres Ariza <arizaandres@unbosque.edu.do>
 * @copyright Universidad el Bosque - Dirección de Tecnología
 * @package entidad
*/
defined('_EXEC') or die;
require_once(PATH_SITE."/entidad/EstadoPeriodo.php");
class Periodo implements Entidad{
    /**
     * @type adodb Object
     * @access private
     */
    private $db;
    
    /**
     * @type varchar
     * @access private
     */
    private $codigoperiodo;
    
    /**
     * @type varchar
     * @access private
     */
    private $nombreperiodo;
    
    /**
     * @type char
     * @access private
     */
    private $codigoestadoperiodo;
    
    /**
     * @type datetime
     * @access private
     */
    private $fechainicioperiodo;
    
    /**
     * @type datetime
     * @access private
     */
    private $fechavencimientoperiodo;
    
    /**
     * @type smallint
     * @access private
     */
    private $numeroperiodo;
    
    /**
     * @type EstadoPeriodo Object
     * @access private
     */
    private $EstadoPeriodo;
    
    private $periodoId;
    
    public function __construct(){
    }
    
    public function setDb(){
        $this->db = Factory::createDbo();
    }
    
    public function getCodigoperiodo() {
        return $this->codigoperiodo;
    }

    public function getNombreperiodo() {
        return $this->nombreperiodo;
    }

    public function getCodigoestadoperiodo() {
        return $this->codigoestadoperiodo;
    }

    public function getFechainicioperiodo() {
        return $this->fechainicioperiodo;
    }

    public function getFechavencimientoperiodo() {
        return $this->fechavencimientoperiodo;
    }

    public function getNumeroperiodo() {
        return $this->numeroperiodo;
    }

    public function getEstadoPeriodo() {
        return $this->EstadoPeriodo;
    }

    public function setCodigoperiodo($codigoperiodo) {
        $this->codigoperiodo = $codigoperiodo;
    }

    public function setNombreperiodo($nombreperiodo) {
        $this->nombreperiodo = $nombreperiodo;
    }

    public function setCodigoestadoperiodo($codigoestadoperiodo) {
        $this->codigoestadoperiodo = $codigoestadoperiodo;
    }

    public function setFechainicioperiodo($fechainicioperiodo) {
        $this->fechainicioperiodo = $fechainicioperiodo;
    }

    public function setFechavencimientoperiodo($fechavencimientoperiodo) {
        $this->fechavencimientoperiodo = $fechavencimientoperiodo;
    }

    public function setNumeroperiodo($numeroperiodo) {
        $this->numeroperiodo = $numeroperiodo;
    }

    public function setEstadoPeriodo() {
        $this->EstadoPeriodo = new EstadoPeriodo();
        $this->EstadoPeriodo->setDb();
        $this->EstadoPeriodo->setCodigoestadoperiodo($this->codigoestadoperiodo);
        $this->EstadoPeriodo->getById();
    }
    
    public function getPeriodoId() {
        return $this->periodoId;
    }

    public function setPeriodoId($periodoId) {
        $this->periodoId = $periodoId;
    }

        
    public function getById(){
        
        if(!empty($this->codigoperiodo)){
            $query = "SELECT * FROM periodo "
                    ." WHERE codigoperiodo = ".$this->db->qstr($this->codigoperiodo);
            
            $datos = $this->db->Execute($query);
            $d = $datos->FetchRow();
            
            if(!empty($d)){
                $this->periodoId = $d['PeriodoId']; 
                $this->nombreperiodo = $d['nombreperiodo']; 
                $this->codigoestadoperiodo = $d['codigoestadoperiodo']; 
                $this->fechainicioperiodo = $d['fechainicioperiodo']; 
                $this->fechavencimientoperiodo = $d['fechavencimientoperiodo']; 
                $this->numeroperiodo = $d['numeroperiodo'];
            }
        }
    }
    
    public static function getList($where=null){
        $db = Factory::createDbo();
        
        $return = array();
        
        $query = "SELECT * "
                . " FROM periodo "
                . " WHERE 1";
        
        if(!empty($where)){
            $query .= " AND ".$where;
        }
        
        $datos = $db->Execute($query);
        while($d = $datos->FetchRow()){
            $Periodo = new Periodo();
            $Periodo->periodoId = $d['PeriodoId']; 
            $Periodo->codigoperiodo = $d['codigoperiodo']; 
            $Periodo->nombreperiodo = $d['nombreperiodo']; 
            $Periodo->codigoestadoperiodo = $d['codigoestadoperiodo']; 
            $Periodo->fechainicioperiodo = $d['fechainicioperiodo']; 
            $Periodo->fechavencimientoperiodo = $d['fechavencimientoperiodo']; 
            $Periodo->numeroperiodo = $d['numeroperiodo'];
            $return[] = $Periodo;
            unset($Periodo);
        }
        return $return;
    }
}
/*/
codigoperiodo	varchar(8)
nombreperiodo	varchar(100)
codigoestadoperiodo	char(2)
fechainicioperiodo	datetime
fechavencimientoperiodo	datetime
numeroperiodo	smallint(6)
/**/