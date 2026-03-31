<?php
/**
 * @author Ivan Dario Quintero Rios <quinteroivan@unbosque.edu.do>
 * @copyright Universidad el Bosque - Dirección de Tecnología
 * @package entidad
*/
defined('_EXEC') or die;
class Encuesta implements Entidad{
   /**
     * @type adodb Object
     * @access private
     */
    private $db;
    
    /**
     * @type int
     * @access private
     */
    private $idencuesta;
    
    /**
     * @type varchar
     * @access private
     */
    private $nombreencuesta;
    
    /**
     * @type datetime
     * @access private
     */
    private $fechainicioencuesta;
    
    /**
     * @type datetime
     * @access private
     */
    private $fechafinalencuesta;
    
    /**
     * @type text
     * @access private
     */
    private $informacionencuesta;
    
    /**
     * @type datetime
     * @access private
     */
    private $fechacreacionencuesta;
    
    /**
     * @type char
     * @access private
     */
    private $codigoestado;
    
    /**
     * @type char
     * @access private
     */
    private $codigotipousuario;
    
    /**
     * @type longtext
     * @access private
     */
    private $titulo1encuesta;
    
    /**
     * @type longtext
     * @access private
     */
    private $titulo2encuesta;
    
    /**
     * @type longtext
     * @access private
     */
    private $descripcionencuesta;
    
    /**
     * @type int
     * @access private
     */
    private $codigocarrera;
    
    public function __construct(){
    }
    
    public function setDb(){
        $this->db = Factory::createDbo();
    }
    
    public function setIdencuesta($idencuesta) {
        $this->idencuesta = $idencuesta;
    }
    
    public function setNombreencuesta($nombreencuesta) {
        $this->nombreencuesta = $nombreencuesta;
    }
    
    public function setFechainicioencuesta($fechainicioencuesta) {
        $this->fechainicioencuesta = $fechainicioencuesta;
    }
    
    public function setFechafinalencuesta($fechafinalencuesta){
        $this->fechafinalencuesta = $fechafinalencuesta;
    }
    
    public function setInformacionencuesta($informacionencuesta){
        $this->informacionencuesta = $informacionencuesta;
    }
    
    public function setFechacreacionencuesta($fechacreacionencuesta){
        $this->fechacreacionencuesta = $fechacreacionencuesta;
    }
    
    public function setCodigoestado($codigoestado){
        $this->codigoestado = $codigoestado;
    }
    
    public function setCodigotipousuario($codigotipousuario){
        $this->codigotipousuario = $codigotipousuario;
    }
            
    public function setTitulo1encuesta($titulo1encuesta){
        $this->titulo1encuesta = $titulo1encuesta;
    }
      
    public function setTitulo2encuesta($titulo2encuesta){
        $this->titulo2encuesta = $titulo2encuesta;
    }
    
    public function setDescripcionencuesta($descripcionencuesta){
        $this->descripcionencuesta = $descripcionencuesta;
    }
    
    public function setCodigocarrera($codigocarrera){
        $this->codigocarrera = $codigocarrera;
    }
    
    public function getIdencuesta() {
        return $this->idencuesta;
    }
    
    public function getNombreencuesta() {
        return $this->nombreencuesta;
    }
    
    public function getFechainicioencuesta(){
        return $this->fechainicioencuesta;
    }
    
    public function getFechafinalencuesta(){
        return $this->fechafinalencuesta;
    }
    
    public function getInformacionencuesta(){
        return $this->informacionencuesta;
    }
    
    public function getFechacreacionencuesta(){
        return $this->fechacreacionencuesta;
    }
    
    public function getCodigoestado(){
        return $this->codigoestado;
    }
    public function getCodigotipousuario(){
        return $this->codigotipousuario;
    }
    
    public function getTitulo1encuesta(){
        return $this->titulo1encuesta;
    }
    
    public function getTitulo2encuesta(){
        return $this->titulo2encuesta;
    }
    
    public function getDescripcionencuesta(){
        return $this->descripcionencuesta;
    }
    
    public function getCodigocarrera(){
        return $this->codigocarrera;
    }
    
    public function getById(){
        if(!empty($this->idencuesta)){
            $query = "SELECT * FROM encuesta "
                    ." WHERE idencuesta = ".$this->db->qstr($this->idencuesta);
            $datos = $this->db->Execute($query);
            $d = $datos->FetchRow();
            
            if(!empty($d)){
                $this->nombreencuesta = $d['nombreencuesta'];
                $this->fechainicioencuesta = $d['fechainicioencuesta'];
                $this->fechainicioencuesta = $d['fechainicioencuesta'];
                $this->fechafinalencuesta = $d['fechafinalencuesta'];
                $this->informacionencuesta = $d['informacionencuesta'];
                $this->fechacreacionencuesta = $d['fechacreacionencuesta'];
                $this->codigoestado = $d['codigoestado'];
                $this->codigotipousuario = $d['codigotipousuario'];
                $this->titulo1encuesta = $d['titulo1encuesta'];
                $this->titulo2encuesta = $d['titulo2encuesta'];
                $this->descripcionencuesta = $d['descripcionencuesta'];
                $this->codigocarrera = $d['codigocarrera'];
            }
        }
     }
     
    public static function getList($where=null, $orderBy = null){
        $return = array();
        $db = Factory::createDbo();
        $query = "SELECT * FROM encuesta "
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
            $Encuesta = new Encuesta();
            $Encuesta->idencuesta = $d['idencuesta'];
            $Encuesta->nombreencuesta = $d['nombreencuesta'];
            $Encuesta->fechainicioencuesta = $d['fechainicioencuesta'];
            $Encuesta->fechainicioencuesta = $d['fechainicioencuesta'];
            $Encuesta->fechafinalencuesta = $d['fechafinalencuesta'];
            $Encuesta->informacionencuesta = $d['informacionencuesta'];
            $Encuesta->fechacreacionencuesta = $d['fechacreacionencuesta'];
            $Encuesta->codigoestado = $d['codigoestado'];
            $Encuesta->codigotipousuario = $d['codigotipousuario'];
            $Encuesta->titulo1encuesta = $d['titulo1encuesta'];
            $Encuesta->titulo2encuesta = $d['titulo2encuesta'];
            $Encuesta->descripcionencuesta = $d['descripcionencuesta'];
            $Encuesta->codigocarrera = $d['codigocarrera'];
            $return[] = $Encuesta;
            unset($Encuesta);
        }
        return $return;
    }
}
