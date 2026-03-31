<?php
/**
 * Ivan Dario quintero Rios <quinteroivan@unbosque.edu.co>
 * Abril 2 del 2018
 */
defined('_EXEC') or die;
class EncuestaCarreras implements Entidad{
     /**
     * @type adodb Object
     * @access private
     */
    private $db;
    
    /**
     * @type int
     * @access private
     */
    private $IdEncuestaCarrera;
    
    /**
     * @type int
     * @access private
     */
    private $CodigoCarrera;
    
    /**
     * @type date
     * @access private
     */
    private $FechaInicial;
    
    /**
     * @type date
     * @access private
     */
    private $FechaFinal;
    
    /**
     * @type int
     * @access private
     */
    private $CodigoPeriodo;
    
    /**
     * @type varchar
     * @access private
     */
    private $UsuarioCreacion;
    
    /**
     * @type date
     * @access private
     */
    private $FechaCreacion;
    
    /**
     * @type varchar
     * @access private
     */
    private $UsuarioModificacion;
    
    /**
     * @type date
     * @access private
     */
    private $FechaModificacion;
    
    /**
     * @type char
     * @access private
     */
    private $CodigoEstado;
    
    public function __construct(){
    }
    
    public function setDb(){
        $this->db = Factory::createDbo();
    }
    
    public function setIdencuestacarrera($IdEncuestaCarrera) {
        $this->IdEncuestaCarrera = $IdEncuestaCarrera;
    }
    
    public function setCodigocarrera($CodigoCarrera) {
        $this->CodigoCarrera = $CodigoCarrera;
    }
    
    public function setFechainicial($FechaInicial) {
        $this->FechaInicial = $FechaInicial;
    }
    
    public function setFechafinal($FechaFinal) {
        $this->FechaFinal = $FechaFinal;
    }
    
    public function setCodigoperiodo($CodigoPeriodo) {
        $this->CodigoPeriodo = $CodigoPeriodo;
    }
    
    public function setUsuariocreacion($UsuarioCreacion) {
        $this->UsuarioCreacion = $UsuarioCreacion;
    }
    
    public function setFechacreacion($FechaCreacion) {
        $this->FechaCreacion = $FechaCreacion;
    }
    
    public function setUsuariomodificacion($UsuarioModificacion) {
        $this->UsuarioModificacion = $UsuarioModificacion;
    }
    
    public function setFechamodificacion($FechaModificacion) {
        $this->FechaModificacion = $FechaModificacion;
    }
    
    public function setCodigoestado($CodigoEstado){
        $this->CodigoEstado = $CodigoEstado;
    }
    
    public function getIdencuestacarrera(){
        return $this->IdEncuestaCarrera;
    }
    
    public function getCodigocarrera(){
        return $this->CodigoCarrera;
    }
    
    public function getFechainicial(){
        return $this->FechaInicial;
    }
    
    public function getFechafinal(){
        return $this->FechaFinal;
    }
    
    public function getCodigoperiodo(){
        return $this->CodigoPeriodo;
    }
    
    public function getUsuariocreacion(){
        return $this->UsuarioCreacion;
    }
    
    public function getFechacreacion(){
        return $this->FechaCreacion;
    }
    
    public function getUsuariomodificacion(){
        return $this->UsuarioModificacion;
    }
    
    public function getFechamodificacion(){
        return $this->FechaModificacion;
    }
    
    public function getCodigoestado(){
        return $this->CodigoEstado;
    }
    
    public function getById(){
         if(!empty($this->IdEncuestaCarrera)){
            $query = "SELECT * FROM EncuestaCarreras "
                    ." WHERE IdEncuestaCarrera = ".$this->db->qstr($this->IdEncuestaCarrera);
            $datos = $this->db->Execute($query);
            $d = $datos->FetchRow();
            //d($query);
            if(!empty($d)){
                $this->CodigoCarrera = $d['CodigoCarrera'];
                $this->FechaInicial = $d['FechaInicial'];
                $this->FechaFinal= $d['FechaFinal'];
                $this->CodigoPeriodo= $d['CodigoPeriodo'];
                $this->UsuarioCreacion= $d['UsuarioCreacion'];
                $this->FechaCreacion= $d['FechaCreacion'];
                $this->UsuarioModificacion= $d['UsuarioModificacion'];
                $this->FechaModificacion = $d['FechaModificacion'];
                $this->CodigoEstado = $d['CodigoEstado'];
            }//if
         }//if
    }
    
    public static function getList($where=null, $orderBy = null){
        $return = array();
        $db = Factory::createDbo();
        $query = "SELECT * FROM EncuestaCarreras "
                    ." WHERE 1 ";
        if(!empty($where)){
            $query .= " AND ".$where;
        }
        if(!empty($orderBy)){
            $query .= " ORDER BY ".$orderBy;
        }
        //d($query);
        $datos = $db->Execute($query);
        
        while( $d = $datos->FetchRow() ){
            $EncuestaCarrera = new EncuestaCarreras();
            $EncuestaCarrera->IdEncuestaCarrera = $d['IdEncuestaCarrera'];
            $EncuestaCarrera->CodigoCarrera = $d['CodigoCarrera'];
            $EncuestaCarrera->FechaInicial = $d['FechaInicial'];
            $EncuestaCarrera->FechaFinal= $d['FechaFinal'];
            $EncuestaCarrera->CodigoPeriodo = $d['CodigoPeriodo'];
            
            $return[] = $EncuestaCarrera;
            unset($EncuestaCarrera);
        }
        return $return;
    }
}
