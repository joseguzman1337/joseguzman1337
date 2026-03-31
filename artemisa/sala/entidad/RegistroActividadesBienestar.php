<?php
/**
 * @author vega Gabriel <vegagabriel@unbosque.edu.do>
 * @copyright Universidad el Bosque - Dirección de Tecnología
 * @package entidad
*/
 
defined('_EXEC') or die;
class RegistroActividadesBienestar implements Entidad{
    
    /**
     * @type adodb Object
     * @access private
     */
    private $db;
    
    /**
     * @type int
     * @access private
     */
    private $id;
    
    /**
     * @type int
     * @access private
     */
    private $idActividadesBienestar;
    
    /**
     * @type varchar
     * @access private
     */
    private $nombre;
    
    /**
     * @type varchar
     * @access private
     */
    private $email;
    
    /**
     * @type int
     * @access private
     */
    private $codigoCarrera;
    
    /**
     * @type int
     * @access private
     */
    private $telefono;
    
    /**
     * @type varchar
     * @access private
     */
    private $audiencia;
    
    /**
     * @type datetime
     * @access private
     */
    private $fechaRegistro;
    
    /**
     * @type varchar
     * @access private
     */
    private $codigoEstado;
   
    
    public function __construct(){
    }
    
    function getDb() {
        return $this->db;
    }

    function getId() {
        return $this->id;
    }

    function getIdActividadesBienestar() {
        return $this->idActividadesBienestar;
    }

    function getNombre() {
        return $this->nombre;
    }

    function getEmail() {
        return $this->email;
    }

    function getCodigoCarrera() {
        return $this->codigoCarrera;
    }

    function getTelefono() {
        return $this->telefono;
    }

    function getAudiencia() {
        return $this->audiencia;
    }

    function getFechaRegistro() {
        return $this->fechaRegistro;
    }

    function getCodigoEstado() {
        return $this->codigoEstado;
    }

    function setDb($db) {
        $this->db = $db;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setIdActividadesBienestar($idActividadesBienestar) {
        $this->idActividadesBienestar = $idActividadesBienestar;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setCodigoCarrera($codigoCarrera) {
        $this->codigoCarrera = $codigoCarrera;
    }

    function setTelefono($telefono) {
        $this->telefono = $telefono;
    }

    function setAudiencia($audiencia) {
        $this->audiencia = $audiencia;
    }

    function setFechaRegistro($fechaRegistro) {
        $this->fechaRegistro = $fechaRegistro;
    }

    function setCodigoEstado($codigoEstado) {
        $this->codigoEstado = $codigoEstado;
    }

        
    public function getById(){
        if(!empty($this->id) && !empty($this->idActividadesBienestar)){
            $query = "SELECT * FROM RegistroActividadesBienestar "
                    ." WHERE id = ".$this->db->qstr($this->id)
                    ." AND idActividadesBienestar = ".$this->db->qstr($this->idActividadesBienestar);
            
            $datos = $this->db->Execute($query);
            $d = $datos->FetchRow();
            if(!empty($d)){
                $this->nombre = $d['nombre'];
                $this->email = $d['email'];
                $this->codigoCarrera = $d['codigoCarrera'];
                $this->telefono = $d['telefono'];
                $this->audiencia = $d['audiencia'];
                $this->fechaRegistro = $d['fechaRegistro'];
                $this->codigoEstado = $d['codigoEstado'];
            }
        }
    }
    
    public static function getList($where=null, $orderBy = null){
        $return = array();
        $db = Factory::createDbo();
        $query = "SELECT * FROM RegistroActividadesBienestar "
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
            $RegistroActividadesBienestar = new RegistroActividadesBienestar();
            $RegistroActividadesBienestar->nombre = $d['nombre'];
            $RegistroActividadesBienestar->email = $d['email'];
            $RegistroActividadesBienestar->codigoCarrera = $d['codigoCarrera'];
            $RegistroActividadesBienestar->telefono = $d['telefono'];
            $RegistroActividadesBienestar->audiencia = $d['audiencia'];
            $RegistroActividadesBienestar->fechaRegistro = $d['fechaRegistro'];
            $RegistroActividadesBienestar->codigoEstado = $d['codigoEstado'];
            
            $return[] = $RegistroActividadesBienestar;
            unset($RegistroActividadesBienestar);
        }
        
        return $return;
    }
    
    function cmp($a, $b, $c, $d, $e){
        return strcmp($a["nombre"], $b["email"], $c["codigoCarrera"], $d["telefono"], $e["audiencia"]);
    }


}

