<?php
/**
 * @author Andres Ariza <arizaandres@unbosque.edu.do>
 * @copyright Universidad el Bosque - Dirección de Tecnología
 * @package entidad
*/
defined('_EXEC') or die;
class PeriodosVirtuales implements Entidad{
    /**
     * @type adodb Object
     * @access private
     */
    private $db;
    
    /**
     * @type int
     * @access private
     */
    private $IdPeriodoVirtual;
    
    /**
     * @type int
     * @access private
     */
    private $Agno;
    
    /**
     * @type int
     * @access private
     */
    private $CodigoPeriodo; 
    
    /**
     * @type String
     * @access private
     */
    private $NombrePeriodo;
    
    /**
     * @type int
     * @access private
     */
    private $CodigoEstado;
    
    /**
     * @type int
     * @access private
     */
    private $NumeroPeriodo;
    
    public function __construct() {}

    public function setDb() {
        $this->db = Factory::createDbo();
    }
    
    public function getIdPeriodoVirtual() {
        return $this->IdPeriodoVirtual;
    }

    public function getAgno() {
        return $this->Agno;
    }

    public function getCodigoPeriodo() {
        return $this->CodigoPeriodo;
    }

    public function getNombrePeriodo() {
        return $this->NombrePeriodo;
    }

    public function getCodigoEstado() {
        return $this->CodigoEstado;
    }

    public function getNumeroPeriodo() {
        return $this->NumeroPeriodo;
    }

    public function setIdPeriodoVirtual($IdPeriodoVirtual) {
        $this->IdPeriodoVirtual = $IdPeriodoVirtual;
    }

    public function setAgno($Agno) {
        $this->Agno = $Agno;
    }

    public function setCodigoPeriodo($CodigoPeriodo) {
        $this->CodigoPeriodo = $CodigoPeriodo;
    }

    public function setNombrePeriodo($NombrePeriodo) {
        $this->NombrePeriodo = $NombrePeriodo;
    }

    public function setCodigoEstado($CodigoEstado) {
        $this->CodigoEstado = $CodigoEstado;
    }

    public function setNumeroPeriodo($NumeroPeriodo) {
        $this->NumeroPeriodo = $NumeroPeriodo;
    }
            
    public function getById() {
        if(!empty($this->IdPeriodoVirtual)){
            $query = "SELECT * FROM PeriodosVirtuales "
                    ." WHERE IdPeriodoVirtual = ".$this->db->qstr($this->IdPeriodoVirtual);
            
            $datos = $this->db->Execute($query);
            $d = $datos->FetchRow();
            
            if(!empty($d)){
                $this->Agno = $d['Agno'];
                $this->CodigoPeriodo = $d['CodigoPeriodo'];
                $this->NombrePeriodo = $d['NombrePeriodo'];
                $this->CodigoEstado = $d['CodigoEstado'];
                $this->NumeroPeriodo = $d['NumeroPeriodo'];
            }
        }
    }

    public static function getList($where=null) {
        $db = Factory::createDbo();
        
        $return = array();
        
        $query = "SELECT * "
                . " FROM PeriodosVirtuales "
                . " WHERE 1";
        
        if(!empty($where)){
            $query .= " AND ".$where;
        }
        
        $datos = $db->Execute($query);
        while($d = $datos->FetchRow()){
            $PeriodosVirtuales = new PeriodosVirtuales();
            $PeriodosVirtuales->IdPeriodoVirtual = $d['IdPeriodoVirtual'];
            $PeriodosVirtuales->Agno = $d['Agno'];
            $PeriodosVirtuales->CodigoPeriodo = $d['CodigoPeriodo'];
            $PeriodosVirtuales->NombrePeriodo = $d['NombrePeriodo'];
            $PeriodosVirtuales->CodigoEstado = $d['CodigoEstado'];
            $PeriodosVirtuales->NumeroPeriodo = $d['NumeroPeriodo'];
            $return[] = $PeriodosVirtuales;
            unset($PeriodosVirtuales);
        }
        return $return;
    }
}
/*/
IdPeriodoVirtual	int(5)
Agno	int(4)
CodigoPeriodo	int(5)
NombrePeriodo	varchar(100)
CodigoEstado	int(3)
NumeroPeriodo	int(6)
/**/