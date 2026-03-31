<?php
/**
 * @author Andres Ariza <arizaandres@unbosque.edu.do>
 * @copyright Universidad el Bosque - Dirección de Tecnología
 * @package entidad
 * 
*/
defined('_EXEC') or die;
class CalendarioInstitucional implements Entidad{
    /**
     * @type adodb Object
     * @access private
     */
    private $db;
    
    /**
     * @type int
     * @access private
     */
    private $CalenadrioInstitucionalId;
    
    /**
     * @type varchar
     * @access private
     */
    private $Evento;
    
    /**
     * @type varchar
     * @access private
     */
    private $Lugar;
    
    /**
     * @type varchar
     * @access private
     */
    private $Responsable;
    
    /**
     * @type date
     * @access private
     */
    private $FechaInicial;
    
    /**
     * @type date
     * @access private
     */
    private $FechaFin;
    
    /**
     * @type time
     * @access private
     */
    private $HoraInicial;
    
    /**
     * @type time
     * @access private
     */
    private $HoraFin;
    
    /**
     * @type varchar
     * @access private
     */
    private $ImagenUrl;
    
    /**
     * @type varchar
     * @access private
     */
    private $Descripcion;
    
    /**
     * @type bigint
     * @access private
     */
    private $Estado;
    
    /**
     * @type int
     * @access private
     */
    private $codigocarrera;
    
    /**
     * @type char
     * @access private
     */
    private $CodigoEstado;
    
    /**
     * @type int
     * @access private
     */
    private $UsuarioCreacion;
    
    /**
     * @type datetime
     * @access private
     */
    private $FechaCreacion;
    
    /**
     * @type int
     * @access private
     */
    private $UsuarioUltimaModificacion;
    
    /**
     * @type datetime
     * @access private
     */
    private $FechaUltimaModificacion;
    
    public function __construct() {
    }
    
    public function setDb(){
        $this->db = Factory::createDbo();
    }
    
    function getCalenadrioInstitucionalId() {
        return $this->CalenadrioInstitucionalId;
    }

    function getEvento() {
        return $this->Evento;
    }

    function getLugar() {
        return $this->Lugar;
    }

    function getResponsable() {
        return $this->Responsable;
    }

    function getFechaInicial() {
        return $this->FechaInicial;
    }

    function getFechaFin() {
        return $this->FechaFin;
    }

    function getHoraInicial() {
        return $this->HoraInicial;
    }

    function getHoraFin() {
        return $this->HoraFin;
    }

    function getImagenUrl() {
        return $this->ImagenUrl;
    }

    function getDescripcion() {
        return $this->Descripcion;
    }

    function getEstado() {
        return $this->Estado;
    }

    function getCodigocarrera() {
        return $this->codigocarrera;
    }

    function getCodigoEstado() {
        return $this->CodigoEstado;
    }

    function getUsuarioCreacion() {
        return $this->UsuarioCreacion;
    }

    function getFechaCreacion() {
        return $this->FechaCreacion;
    }

    function getUsuarioUltimaModificacion() {
        return $this->UsuarioUltimaModificacion;
    }

    function getFechaUltimaModificacion() {
        return $this->FechaUltimaModificacion;
    }

    function setCalenadrioInstitucionalId($CalenadrioInstitucionalId) {
        $this->CalenadrioInstitucionalId = $CalenadrioInstitucionalId;
    }

    function setEvento($Evento) {
        $this->Evento = $Evento;
    }

    function setLugar($Lugar) {
        $this->Lugar = $Lugar;
    }

    function setResponsable($Responsable) {
        $this->Responsable = $Responsable;
    }

    function setFechaInicial($FechaInicial) {
        $this->FechaInicial = $FechaInicial;
    }

    function setFechaFin($FechaFin) {
        $this->FechaFin = $FechaFin;
    }

    function setHoraInicial($HoraInicial) {
        $this->HoraInicial = $HoraInicial;
    }

    function setHoraFin($HoraFin) {
        $this->HoraFin = $HoraFin;
    }

    function setImagenUrl($ImagenUrl) {
        $this->ImagenUrl = $ImagenUrl;
    }

    function setDescripcion($Descripcion) {
        $this->Descripcion = $Descripcion;
    }

    function setEstado($Estado) {
        $this->Estado = $Estado;
    }

    function setCodigocarrera($codigocarrera) {
        $this->codigocarrera = $codigocarrera;
    }

    function setCodigoEstado($CodigoEstado) {
        $this->CodigoEstado = $CodigoEstado;
    }

    function setUsuarioCreacion($UsuarioCreacion) {
        $this->UsuarioCreacion = $UsuarioCreacion;
    }

    function setFechaCreacion($FechaCreacion) {
        $this->FechaCreacion = $FechaCreacion;
    }

    function setUsuarioUltimaModificacion($UsuarioUltimaModificacion) {
        $this->UsuarioUltimaModificacion = $UsuarioUltimaModificacion;
    }

    function setFechaUltimaModificacion($FechaUltimaModificacion) {
        $this->FechaUltimaModificacion = $FechaUltimaModificacion;
    }
    
    public function getById(){
        if(!empty($this->CalenadrioInstitucionalId)){
            $query = "SELECT * FROM CalendarioInstitucional "
                    . "WHERE CalenadrioInstitucionalId = ".$this->db->qstr($this->CalenadrioInstitucionalId);
            
            $datos = $this->db->Execute($query);
            $d = $datos->FetchRow();
            
            if(!empty($d)){
                $this->Evento = $d['Evento'];
                $this->Lugar = $d['Lugar'];
                $this->Responsable = $d['Responsable'];
                $this->FechaInicial = $d['FechaInicial'];
                $this->FechaFin = $d['FechaFin'];
                $this->HoraInicial = $d['HoraInicial'];
                $this->HoraFin = $d['HoraFin'];
                $this->ImagenUrl = $d['ImagenUrl'];
                $this->Descripcion = eregi_replace("\n|\r|\n\r", ' ', $d['Descripcion']);
                $this->Estado = $d['Estado'];
                $this->codigocarrera = $d['codigocarrera'];
                $this->CodigoEstado = $d['CodigoEstado'];
                $this->UsuarioCreacion = $d['UsuarioCreacion'];
                $this->FechaCreacion = $d['FechaCreacion'];
                $this->UsuarioUltimaModificacion = $d['UsuarioUltimaModificacion'];
                $this->FechaUltimaModificacion = $d['FechaUltimaModificacion'];
            }
        }
    } 
    
    public static function getByCodigoCarrera(){
        $return = array();
        $db = Factory::createDbo(); 

        $query = "SELECT * FROM CalendarioInstitucional "
                . "WHERE  (FechaInicial >= CURDATE() OR FechaFin >= CURDATE()) "
                . "AND CodigoEstado = 100";
        //d($query);
        $datos = $db->Execute($query);

        while($d = $datos->FetchRow()){
            $t = new CalendarioInstitucional();
            $t->CalenadrioInstitucionalId = $d['CalenadrioInstitucionalId'];
            $t->Evento = $d['Evento'];
            $t->Lugar = $d['Lugar'];
            $t->Responsable = $d['Responsable'];
            $t->FechaInicial = $d['FechaInicial'];
            $t->FechaFin = $d['FechaFin'];
            $t->HoraInicial = $d['HoraInicial'];
            $t->HoraFin = $d['HoraFin'];
            $t->ImagenUrl = $d['ImagenUrl'];
            $t->Descripcion =  eregi_replace("\n|\r|\n\r", ' ', $d['Descripcion']);
            $t->Estado = $d['Estado'];
            $t->codigocarrera = $d['codigocarrera'];
            $t->CodigoEstado = $d['CodigoEstado'];
            $t->UsuarioCreacion = $d['UsuarioCreacion'];
            $t->FechaCreacion = $d['FechaCreacion'];
            $t->UsuarioUltimaModificacion = $d['UsuarioUltimaModificacion'];
            $t->FechaUltimaModificacion = $d['FechaUltimaModificacion'];
            $return[] = $t;
            unset($t);
        }
        if(empty($return) && ( !empty($codigoCarrera) && $codigoCarrera!=1 && $codigoCarrera!=156) ){
            $return = self::getByCodigoCarrera(null);
        }
        return $return;
    }
    
    public static function getList($where) {
        $arrayReturn = array();
        return $arrayReturn;
    }
}
/*/
CalenadrioInstitucionalId	int(11)
Evento	varchar(250)
Lugar	varchar(250)
Responsable	varchar(250)
FechaInicial	date
FechaFin	date
HoraInicial	time
HoraFin	time
ImagenUrl	varchar(250)
Descripcion	varchar(250)
Estado	bigint(2)
codigocarrera	int(11)
CodigoEstado	char(3)
UsuarioCreacion	int(11)
FechaCreacion	datetime
UsuarioUltimaModificacion	int(11)
FechaUltimaModificacion	datetime
/**/