<?php
/**
 * @author Andres Ariza <arizaandres@unbosque.edu.do>
 * @copyright Universidad el Bosque - Dirección de Tecnología
 * @package entidad
*/
defined('_EXEC') or die;
class AutoevaluacionDocentes implements Entidad{
    /**
     * @type adodb Object
     * @access private
     */
    private $db;
    
    /**
     * @type int
     * @access private
     */
    private $AutoevaluacionDocentesId;
    
    /**
     * @type int
     * @access private
     */
    private $DocenteId;
    
    /**
     * @type String
     * @access private
     */
    private $Descripcion;
    
    /**
     * @type int
     * @access private
     */
    private $VocacionesId;
    
    /**
     * @type String
     * @access private
     */
    private $CodigoPeriodo;
    
    /**
     * @type String
     * @access private
     */
    private $CodigoEstado;
    
    /**
     * @type int
     * @access private
     */
    private $CodigoCarrera;
    
    /**
     * @type int
     * @access private
     */
    private $PorcentajeCumplimiento;
    
    /**
     * @type int
     * @access private
     */
    private $PorcentajeCumplimientoDecanos;
    
    /**
     * @type int
     * @access private
     */
    private $UsuarioCreacion;
    
    /**
     * @type int
     * @access private
     */
    private $UsuarioUltimaModificacion;
    
    /**
     * @type Datetime
     * @access private
     */
    private $FechaCreacion;
    
    /**
     * @type Datetime
     * @access private
     */
    private $FechaUltimaModificacion;
    
    /**
     * @type String
     * @access private
     */
    private $ComentarioDecanos;
    
    /**
     * @type int
     * @access private
     */
    private $UsuarioId;
    
    public function __construct(){
    }
    
    public function setDb(){
        $this->db = Factory::createDbo();
        
    }
    
    public function getAutoevaluacionDocentesId() {
        return $this->AutoevaluacionDocentesId;
    }

    public function getDocenteId() {
        return $this->DocenteId;
    }

    public function getDescripcion() {
        return $this->Descripcion;
    }

    public function getVocacionesId() {
        return $this->VocacionesId;
    }

    public function getCodigoPeriodo() {
        return $this->CodigoPeriodo;
    }

    public function getCodigoEstado() {
        return $this->CodigoEstado;
    }

    public function getCodigoCarrera() {
        return $this->CodigoCarrera;
    }

    public function getPorcentajeCumplimiento() {
        return $this->PorcentajeCumplimiento;
    }

    public function getPorcentajeCumplimientoDecanos() {
        return $this->PorcentajeCumplimientoDecanos;
    }

    public function getUsuarioCreacion() {
        return $this->UsuarioCreacion;
    }

    public function getUsuarioUltimaModificacion() {
        return $this->UsuarioUltimaModificacion;
    }

    public function getFechaCreacion() {
        return $this->FechaCreacion;
    }

    public function getFechaUltimaModificacion() {
        return $this->FechaUltimaModificacion;
    }

    public function getComentarioDecanos() {
        return $this->ComentarioDecanos;
    }

    public function getUsuarioId() {
        return $this->UsuarioId;
    }

    public function setAutoevaluacionDocentesId($AutoevaluacionDocentesId) {
        $this->AutoevaluacionDocentesId = $AutoevaluacionDocentesId;
    }

    public function setDocenteId($DocenteId) {
        $this->DocenteId = $DocenteId;
    }

    public function setDescripcion($Descripcion) {
        $this->Descripcion = $Descripcion;
    }

    public function setVocacionesId($VocacionesId) {
        $this->VocacionesId = $VocacionesId;
    }

    public function setCodigoPeriodo($CodigoPeriodo) {
        $this->CodigoPeriodo = $CodigoPeriodo;
    }

    public function setCodigoEstado($CodigoEstado) {
        $this->CodigoEstado = $CodigoEstado;
    }

    public function setCodigoCarrera($CodigoCarrera) {
        $this->CodigoCarrera = $CodigoCarrera;
    }

    public function setPorcentajeCumplimiento($PorcentajeCumplimiento) {
        $this->PorcentajeCumplimiento = $PorcentajeCumplimiento;
    }

    public function setPorcentajeCumplimientoDecanos($PorcentajeCumplimientoDecanos) {
        $this->PorcentajeCumplimientoDecanos = $PorcentajeCumplimientoDecanos;
    }

    public function setUsuarioCreacion($UsuarioCreacion) {
        $this->UsuarioCreacion = $UsuarioCreacion;
    }

    public function setUsuarioUltimaModificacion($UsuarioUltimaModificacion) {
        $this->UsuarioUltimaModificacion = $UsuarioUltimaModificacion;
    }

    public function setFechaCreacion($FechaCreacion) {
        $this->FechaCreacion = $FechaCreacion;
    }

    public function setFechaUltimaModificacion($FechaUltimaModificacion) {
        $this->FechaUltimaModificacion = $FechaUltimaModificacion;
    }

    public function setComentarioDecanos($ComentarioDecanos) {
        $this->ComentarioDecanos = $ComentarioDecanos;
    }

    public function setUsuarioId($UsuarioId) {
        $this->UsuarioId = $UsuarioId;
    }

    public function getById() {
        if(!empty($this->AutoevaluacionDocentesId)){
            $query = "SELECT * FROM AutoevaluacionDocentes "
                    ." WHERE AutoevaluacionDocentesId = ".$this->db->qstr($this->AutoevaluacionDocentesId);
            
            $datos = $this->db->Execute($query);
            $d = $datos->FetchRow();
            
            if(!empty($d)){
                $this->DocenteId = $d['DocenteId'];
                $this->Descripcion = $d['Descripcion'];
                $this->VocacionesId = $d['VocacionesId'];
                $this->CodigoPeriodo = $d['CodigoPeriodo'];
                $this->CodigoEstado = $d['CodigoEstado'];
                $this->CodigoCarrera = $d['CodigoCarrera'];
                $this->PorcentajeCumplimiento = $d['PorcentajeCumplimiento'];
                $this->PorcentajeCumplimientoDecanos = $d['PorcentajeCumplimientoDecanos'];
                $this->UsuarioCreacion = $d['UsuarioCreacion'];
                $this->UsuarioUltimaModificacion = $d['UsuarioUltimaModificacion'];
                $this->FechaCreacion = $d['FechaCreacion'];
                $this->FechaUltimaModificacion = $d['FechaUltimaModificacion'];
                $this->UsuarioId = $d['UsuarioId'];
                $this->ComentarioDecanos = $d['ComentarioDecanos'];
            }
        }
    }

    public static function getList($where=null) {
        $return = array();
        $db = Factory::createDbo();
        $query = "SELECT * FROM AutoevaluacionDocentes "
                    ." WHERE 1 ";
        if(!empty($where)){
            $query .= " AND ".$where;
        }
        //d($query);
        $datos = $db->Execute($query);
        
        while( $d = $datos->FetchRow() ){
            $AutoevaluacionDocentes = new AutoevaluacionDocentes(); 
            $AutoevaluacionDocentes->AutoevaluacionDocentesId = $d['AutoevaluacionDocentesId'];
            $AutoevaluacionDocentes->DocenteId = $d['DocenteId'];
            $AutoevaluacionDocentes->Descripcion = $d['Descripcion'];
            $AutoevaluacionDocentes->VocacionesId = $d['VocacionesId'];
            $AutoevaluacionDocentes->CodigoPeriodo = $d['CodigoPeriodo'];
            $AutoevaluacionDocentes->CodigoEstado = $d['CodigoEstado'];
            $AutoevaluacionDocentes->CodigoCarrera = $d['CodigoCarrera'];
            $AutoevaluacionDocentes->PorcentajeCumplimiento = $d['PorcentajeCumplimiento'];
            $AutoevaluacionDocentes->PorcentajeCumplimientoDecanos = $d['PorcentajeCumplimientoDecanos'];
            $AutoevaluacionDocentes->UsuarioCreacion = $d['UsuarioCreacion'];
            $AutoevaluacionDocentes->UsuarioUltimaModificacion = $d['UsuarioUltimaModificacion'];
            $AutoevaluacionDocentes->FechaCreacion = $d['FechaCreacion'];
            $AutoevaluacionDocentes->FechaUltimaModificacion = $d['FechaUltimaModificacion'];
            $AutoevaluacionDocentes->UsuarioId = $d['UsuarioId'];
            $AutoevaluacionDocentes->ComentarioDecanos = $d['ComentarioDecanos'];
            
            $return[] = $AutoevaluacionDocentes;
            unset($AutoevaluacionDocentes);
        }
        
        return $return;
    }
    
    public function save(){
        $query = "";
        $where = array();
        
        if(empty($this->AutoevaluacionDocentesId)){
            $query .= "INSERT INTO ";
        }else{
            $query .= "UPDATE ";
            $where[] = " AutoevaluacionDocentesId = ".$this->db->qstr($this->AutoevaluacionDocentesId);
        }
        
        $query .= " AutoevaluacionDocentes SET "
               . " DocenteId = ".$this->db->qstr($this->DocenteId).", " 
               . " Descripcion = ".$this->db->qstr($this->Descripcion).", " 
               . " VocacionesId = ".$this->db->qstr($this->VocacionesId).", " 
               . " CodigoPeriodo = ".$this->db->qstr($this->CodigoPeriodo).", " 
               . " CodigoEstado = ".$this->db->qstr($this->CodigoEstado).", " 
               . " CodigoCarrera = ".$this->db->qstr($this->CodigoCarrera).", " 
               . " PorcentajeCumplimiento = ".$this->db->qstr($this->PorcentajeCumplimiento).", " 
               . " PorcentajeCumplimientoDecanos = ".$this->db->qstr($this->PorcentajeCumplimientoDecanos).", " 
               . " UsuarioCreacion = ".$this->db->qstr($this->UsuarioCreacion).", " 
               . " UsuarioUltimaModificacion = ".$this->db->qstr($this->UsuarioUltimaModificacion).", " 
               . " FechaCreacion = ".$this->db->qstr($this->FechaCreacion).", " 
               . " FechaUltimaModificacion = ".$this->db->qstr($this->FechaUltimaModificacion).", " 
               . " UsuarioId = ".$this->db->qstr($this->UsuarioId).", " 
               . " ComentarioDecanos = ".$this->db->qstr($this->ComentarioDecanos);
        
        if(!empty($where)){
            $query .= " WHERE ".implode(" AND ",$where);
        }
        //ddd($query);
        $rs = $this->db->Execute($query);
        
        if(empty($this->AutoevaluacionDocentesId)){
            $this->AutoevaluacionDocentesId = $this->db->insert_Id();
        }
        
        if(!$rs){
            return false;
        }else{
            return true;
        }
    }

}
/*/
AutoevaluacionDocentesId	int(11)
DocenteId	int(11)
Descripcion	text
VocacionesId	int(11)
CodigoPeriodo	varchar(8)
CodigoEstado	char(3)
CodigoCarrera	int(11)
PorcentajeCumplimiento	int(11)
PorcentajeCumplimientoDecanos	int(11)
UsuarioCreacion	int(11)
UsuarioUltimaModificacion	int(11)
FechaCreacion	datetime
FechaUltimaModificacion	datetime
UsuarioId	int(11)
ComentarioDecanos	text
/**/