<?php
/**
 * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package entidad
 */ 
defined('_EXEC') or die;
class Usuario implements Entidad{
    /**
     * @type adodb Object
     * @access private
     */
    private $db;
 	
    /**
     * @type int 
     * @access private
     */
    private $idusuario;

    /**
     * @type varchar 
     * @access private
     */
    private $usuario;

    /**
     * @type varchar 
     * @access private
     */
    private $numerodocumento;

    /**
     * @type char 
     * @access private
     */
    private $tipodocumento;

    /**
     * @type varchar 
     * @access private
     */
    private $apellidos;

    /**
     * @type varchar 
     * @access private
     */
    private $nombres;

    /**
     * @type varchar 
     * @access private
     */
    private $codigousuario;

    /**
     * @type varchar 
     * @access private
     */
    private $semestre;

    /**
     * @type int 
     * @access private
     */
    private $codigorol;

    /**
     * @type datetime 
     * @access private
     */
    private $fechainiciousuario;

    /**
     * @type datetime 
     * @access private
     */
    private $fechavencimientousuario;

    /**
     * @type datetime 
     * @access private
     */
    private $fecharegistrousuario;

    /**
     * @type char 
     * @access private
     */
    private $codigotipousuario;

    /**
     * @type int 
     * @access private
     */
    private $idusuariopadre;

    /**
     * @type varchar 
     * @access private
     */
    private $ipaccesousuario;

    /**
     * @type varchar 
     * @access private
     */
    private $codigoestadousuario;

    /**
     * Constructor
     * @param Singleton $persistencia
     */
    public function __construct(){
         $this->db = Factory::createDbo();
    }
    
    public function setDb(){
        $this->db = Factory::createDbo();
    }
    
    public function getIdusuario() {
        return $this->idusuario;
    }

    public function getUsuario() {
        return $this->usuario;
    }

    public function getNumerodocumento() {
        return $this->numerodocumento;
    }

    public function getTipodocumento() {
        return $this->tipodocumento;
    }

    public function getApellidos() {
        return $this->apellidos;
    }

    public function getNombres() {
        return $this->nombres;
    }

    public function getCodigousuario() {
        return $this->codigousuario;
    }

    public function getSemestre() {
        return $this->semestre;
    }

    public function getCodigorol() {
        return $this->codigorol;
    }

    public function getFechainiciousuario() {
        return $this->fechainiciousuario;
    }

    public function getFechavencimientousuario() {
        return $this->fechavencimientousuario;
    }

    public function getFecharegistrousuario() {
        return $this->fecharegistrousuario;
    }

    public function getCodigotipousuario() {
        return $this->codigotipousuario;
    }

    public function getIdusuariopadre() {
        return $this->idusuariopadre;
    }

    public function getIpaccesousuario() {
        return $this->ipaccesousuario;
    }

    public function getCodigoestadousuario() {
        return $this->codigoestadousuario;
    }

    public function setIdusuario($idusuario) {
        $this->idusuario = $idusuario;
    }
    
    public function setUsuario($usuario) {
        $this->usuario = $usuario;
    }

    public function setNumerodocumento($numerodocumento) {
        $this->numerodocumento = $numerodocumento;
    }

    public function setTipodocumento($tipodocumento) {
        $this->tipodocumento = $tipodocumento;
    }

    public function setApellidos($apellidos) {
        $this->apellidos = $apellidos;
    }

    public function setNombres($nombres) {
        $this->nombres = $nombres;
    }

    public function setCodigousuario($codigousuario) {
        $this->codigousuario = $codigousuario;
    }

    public function setSemestre($semestre) {
        $this->semestre = $semestre;
    }

    public function setCodigorol($codigorol) {
        $this->codigorol = $codigorol;
    }

    public function setFechainiciousuario($fechainiciousuario) {
        $this->fechainiciousuario = $fechainiciousuario;
    }

    public function setFechavencimientousuario($fechavencimientousuario) {
        $this->fechavencimientousuario = $fechavencimientousuario;
    }

    public function setFecharegistrousuario($fecharegistrousuario) {
        $this->fecharegistrousuario = $fecharegistrousuario;
    }

    public function setCodigotipousuario($codigotipousuario) {
        $this->codigotipousuario = $codigotipousuario;
    }

    public function setIdusuariopadre($idusuariopadre) {
        $this->idusuariopadre = $idusuariopadre;
    }

    public function setIpaccesousuario($ipaccesousuario) {
        $this->ipaccesousuario = $ipaccesousuario;
    }

    public function setCodigoestadousuario($codigoestadousuario) {
        $this->codigoestadousuario = $codigoestadousuario;
    }

        public function getUsuarioByIdUsuario(){
        if(!empty($this->idusuario)){
            $query = "SELECT * "
                    . "FROM usuario "
                    . "WHERE idusuario = ".$this->idusuario;
            $datos = $this->db->Execute($query);
            
            if(!empty($datos)){
                $d = $datos->FetchRow();
                
                $this->usuario = $d['usuario'];
                $this->numerodocumento = $d['numerodocumento'];
                $this->tipodocumento = $d['tipodocumento'];
                $this->apellidos = $d['apellidos'];
                $this->nombres = $d['nombres'];
                $this->codigousuario = $d['codigousuario'];
                $this->semestre = $d['semestre'];
                $this->codigorol = $d['codigorol'];
                $this->fechainiciousuario = $d['fechainiciousuario'];
                $this->fechavencimientousuario = $d['fechavencimientousuario'];
                $this->fecharegistrousuario = $d['fecharegistrousuario'];
                $this->codigotipousuario = $d['codigotipousuario'];
                $this->idusuariopadre = $d['idusuariopadre'];
                $this->ipaccesousuario = $d['ipaccesousuario'];
                $this->codigoestadousuario = $d['codigoestadousuario'];
            }
        }
    }
    
    public function getById() {
        $this->getUsuarioByIdUsuario();
    }

    public static function getList($where = null, $orderBy = null) {
        $return = array();        
        $db = Factory::createDbo();
        $query = "SELECT * FROM usuario "
                    ." WHERE 1 ";
        if(!empty($where)){
            $query .= " AND ".$where;
        }
        if(!empty($orderBy)){
            $query .= " ORDER BY ".$orderBy;
        }
        
        $datos = $db->Execute($query);
        
        while( $d = $datos->FetchRow() ){
            $Usuario = new Usuario();            
            $Usuario->idusuario = $d['idusuario'];  
            $Usuario->usuario = $d['usuario'];  
            $Usuario->numerodocumento = $d['numerodocumento'];
            $Usuario->tipodocumento = $d['tipodocumento'];
            $Usuario->apellidos = $d['apellidos'];
            $Usuario->nombres = $d['nombres'];
            $Usuario->codigousuario = $d['codigousuario'];
            $Usuario->semestre = $d['semestre'];
            $Usuario->codigorol = $d['codigorol'];
            $Usuario->fechainiciousuario = $d['fechainiciousuario'];
            $Usuario->fechavencimientousuario = $d['fechavencimientousuario'];
            $Usuario->fecharegistrousuario = $d['fecharegistrousuario'];
            $Usuario->codigotipousuario = $d['codigotipousuario'];
            $Usuario->idusuariopadre = $d['idusuariopadre'];
            $Usuario->ipaccesousuario = $d['ipaccesousuario'];
            $Usuario->codigoestadousuario = $d['codigoestadousuario'];
            
            $return[] = $Usuario;
            unset($Usuario);
        }        
        return $return;
    }

	
 }