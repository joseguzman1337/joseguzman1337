<?php
/**
 * @author Ivan Quintero <quinteroivan@unbosque.edu.do>
 * @copyright Universidad el Bosque - Dirección de Tecnología
 * @package entidad
 * 
*/
defined('_EXEC') or die;
class Estudiante implements Entidad{
    /**
     * @type adodb Object
     * @access private
     */
    private $db;
    
    /**
     * @type int
     * @access private
     */
    private $codigoestudiante;
    
    /**
     * @type int
     * @access private
     */
    private $idestudiantegeneral;
    
    /**
     * @type int
     * @access private
     */
    private $codigocarrera;
    
    /**
     * @type char
     * @access private
     */
    private $semestre;
    
    /**
     * @type char
     * @access private
     */
    private $numerocohorte;
    
    /**
     * @type char
     * @access private
     */
    private $codigotipoestudiante;
    
    /**
     * @type char
     * @access private
     */
    private $codigosituacioncarreraestudiante;
    
    /**
     * @type varchar
     * @access private
     */
    private $codigoperiodo;
    
    /**
     * @type char
     * @access private
     */
    private $codigojornada;
    
    /**
     * @type int
     * @access private
     */
    private $VinculacionId;
    
    public function __construct(){}
    
    public function setDb(){
        $this->db = Factory::createDbo();
    }
    
    public function getCodigoEstudiante() {
        return $this->getCodigoesEstudiante();
    }
    
    public function getCodigoesEstudiante() {
        return $this->codigoestudiante;
    }
    
    public function getIdestudiantegeneral() {
        return $this->idestudiantegeneral;
    }
    
    public function getCodigoCarrera() {
        return $this->codigocarrera;
    }
    
    public function getSemestre() {
        return $this->semestre;
    }
    public function getNumeroCohorte() {
        return $this->numerocohorte;
    }
    
    public function getCodigoTipoEstudiante() {
        return $this->codigotipoestudiante;
    }
    
    public function getCodigoSituacionCarreraEstudiante() {
        return $this->codigosituacioncarreraestudiante;
    }
    
    public function getCodigoPeriodo() {
        return $this->codigoperiodo;
    }
    
    public function getCodigoJornada() {
        return $this->codigojornada;
    }
    
    public function getVinculacionId() {
        return $this->VinculacionId;
    }
        
    public function setCodigoEstudiante($codigoestudiante) {
        $this->codigoestudiante = $codigoestudiante;
    }
    
    public function setIdestudiantegeneral($idestudiantegeneral) {
        $this->idestudiantegeneral = $idestudiantegeneral;
    }
    
    public function setCodigoCarrera($codigocarrera) {
        $this->codigocarrera = $codigocarrera;
    }
    
    public function setSemestre($semestre) {
        $this->semestre = $semestre;
    }
    public function setNumeroCohorte($numerocohorte) {
        $this->numerocohorte = $numerocohorte;
    }
    
    public function setCodigoTipoEstudiante($codigotipoestudiante) {
        $this->codigotipoestudiante = $codigotipoestudiante;
    }
    
    public function setCodigoSituacionCarreraEstudiante($codigosituacioncarreraestudiante) {
        $this->codigosituacioncarreraestudiante = $codigosituacioncarreraestudiante;
    }
    
    public function setCodigoPeriodo($codigoperiodo) {
        $this->codigoperiodo = $codigoperiodo;
    }
    
    public function setCodigoJornada($codigojornada){
         $this->codigojornada = $codigojornada;
    }
    
    public function setVinculacionId($VinculacionId){
        $this->VinculacionId = $VinculacionId;
    }
    
    public function getById(){
        if(!empty($this->codigoestudiante)){
            $query = "SELECT * FROM estudiante "
                    . "WHERE codigoestudiante = ".$this->db->qstr($this->codigoestudiante);
            //d($query);
            $datos = $this->db->Execute($query);
            $d = $datos->FetchRow();
            
            if(!empty($d)){
                $this->idestudiantegeneral = $d['idestudiantegeneral'];
                $this->codigocarrera = $d['codigocarrera'];
                $this->semestre = $d['semestre'];
                $this->numerocohorte = $d['numerocohorte'];
                $this->codigotipoestudiante = $d['codigotipoestudiante'];
                $this->codigosituacioncarreraestudiante= $d['codigosituacioncarreraestudiante'];
                $this->codigoperiodo = $d['codigoperiodo'];
                $this->VinculacionId = $d['VinculacionId'];
            }
        }
    }
    
    public static function getList($where = null, $orderBy = null){
        $return = array();
        $db = Factory::createDbo();
        $query = "SELECT * FROM estudiante "
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
            $Estudiante = new Estudiante();
            $Estudiante->codigoestudiante = $d['codigoestudiante'];
            $Estudiante->idestudiantegeneral = $d['idestudiantegeneral'];
            $Estudiante->codigocarrera = $d['codigocarrera'];
            $Estudiante->semestre = $d['semestre'];
            $Estudiante->numerocohorte = $d['numerocohorte'];
            $Estudiante->codigotipoestudiante = $d['codigotipoestudiante'];
            $Estudiante->codigosituacioncarreraestudiante = $d['codigosituacioncarreraestudiante'];
            $Estudiante->codigoperiodo = $d['codigoperiodo'];
            $Estudiante->VinculacionId = $d['VinculacionId'];
            
            $return[] = $Estudiante;
            unset($Estudiante);
        }
        
        return $return;
    }
}

