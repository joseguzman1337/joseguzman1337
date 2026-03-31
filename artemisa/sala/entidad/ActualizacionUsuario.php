<?php
/**
 * @author Ivan Dario Quintero Rios <quinteroivan@unbosque.edu.do>
 * @copyright Universidad el Bosque - Dirección de Tecnología
 * @package entidad
 */
defined('_EXEC') or die;
class ActualizacionUsuario implements Entidad{
    /**
     * @type adodb Object
     * @access private
     */
    private $db;
    
    /**
     * @type int
     * @access private
     */
    private $idactualizacionusuario;
    
    /**
     * @type int
     * @access private
     */
    private $usuarioid;
    
    /**
     * @type int
     * @access private
     */
    private $tipoactualizacion;
    
    /**
     * @type int
     * @access private
     */
    private $id_instrumento;
    /**
     * @type int
     * @access private
     */
    
    private $codigoperiodo;
    /**
     * @type int
     * @access private
     */
    
    private $estadoactualizacion;
    /**
     * @type int
     * @access private
     */
    
    private $userid;
    /**
     * @type int
     * @access private
     */
    
    private $entrydate;
    /**
     * @type int
     * @access private
     */
    
    private $useridestado;
    /**
     * @type int
     * @access private
     */
    
    private $changedate;
    /**
     * @type int
     * @access private
     */
    
    private $codigoestado;
    /**
     * @type int
     * @access private
     */
    
    private $numerodocumento;
    /**
     * @type int
     * @access private
     */
    
    public function __construct(){
    }
    
    public function setDb(){
        $this->db = Factory::createDbo();
    }
    
    public function setIdactualizacionusuario($idactualizacionusuario){
        $this->idactualizacionusuario = $idactualizacionusuario;
    }
    
    public function setUsuarioid($usuarioid){
        $this->usuarioid = $usuarioid;
    }
    
    public function setTipoactualizacion($tipoactualizacion){
        $this->tipoactualizacion = $tipoactualizacion;
    }
    
    public function setId_instrumento($id_instrumento){
        $this->id_instrumento = $id_instrumento;
    }
    
    public function setCodigoperiodo($codigoperiodo){
        $this->codigoperiodo = $codigoperiodo;
    }
    
    public function setEstadoactualizacion($estadoactualizacion){
        $this->estadoactualizacion = $estadoactualizacion;
    }
    
    public function setUserid($userid){
        $this->userid = $userid;
    }
    
    public function setEntrydate($entrydate){
        $this->entrydate = $entrydate;
    }
    
    public function setUseridestado($useridestado){
        $this->useridestado =$useridestado;
    }
    
    public function setChangedate($changedate){
        $this->changedate = $changedate;
    }
    
    public function setCodigoestado($codigoestado){
        $this->codigoestado = $codigoestado;
    }
    
    public function setNumerodocumento($numerodocumento){
        $this->numerodocumento = $numerodocumento;
    }
    
    public function getIdactualizacionusuario(){
        return $this->idactualizacionusuario;
    }    
    
    public function getUsuarioid(){
        return $this->usuarioid;
    }
    
    public function getTipoactualizacion(){
        return $this->tipoactualizacion;
    }
    
    public function getId_instrumento(){
        return $this->id_instrumento;
    }
    
    public function getCodigoperiodo(){
        return $this->codigoperiodo;
    }
    
    public function getEstadoactualizacion(){
        return $this->estadoactualizacion;
    }
    
    public function getUserid(){
        return $this->userid;
    }
    
    public function getEntrydate(){
        return $this->entrydate;
    }

    public function getUseridestado(){
        return $this->useridestado;
    }

    public function getChangedate(){
        return $this->changedate;
    }
    
    public function getCodigoestado(){
        return $this->codigoestado;
    }
    
    public function getNumerodocumento(){
        return $this->numerodocumento;
    }
    
    public function getById(){
        if(!empty($this->idactualizacionusuario)){
            $query = "SELECT * FROM actualizacionusuario"
                    ." WHERE idactualizacionusuario = ".$this->db->qstr($this->idencuesta);
            $datos = $this->db->Execute($query);
            $d = $datos->FetchRow();
            
            if(!empty($d)){
                $this->idactualizacionusuario = $d['idactualizacionusuario'];
                $this->usuarioid = $d['usuarioid'];
                $this->tipoactualizacion = $d['tipoactualizacion'];
                $this->id_instrumento = $d['id_instrumento'];
                $this->codigoperiodo = $d['codigoperiodo'];
                $this->estadoactualizacion = $d['estadoactualizacion'];
                $this->userid = $d['userid'];
                $this->entrydate = $d['entrydate'];
                $this->useridestado = $d['useridestado'];
                $this->changedate = $d['changedate'];
                $this->codigoestado = $d['codigoestado'];
                $this->numerodocumento = $d['numerodocumento'];
            }           
        }
    }
    
    public static function getList($where=null, $orderBy = null){
        $return = array();
        
        $query = "SELECT * FROM actualizacionusuario "
                    ." WHERE 1 ";
        if(!empty($where)){
            $query .= " AND ".$where;
        }
        if(!empty($orderBy)){
            $query .= " ORDER BY ".$orderBy;
        }        
        $datos = $this->db->Execute($query);
        
        while( $d = $datos->FetchRow() ){
            $ActualizacionUsuario = new ActualizacionUsuario();
            $ActualizacionUsuario->idactualizacionusuario = $d['idactualizacionusuario'];
            $ActualizacionUsuario->usuarioid = $d['usuarioid'];
            $ActualizacionUsuario->tipoactualizacion = $d['tipoactualizacion'];
            $ActualizacionUsuario->id_instrumento = $d['id_instrumento'];
            $ActualizacionUsuario->codigoperiodo = $d['codigoperiodo'];
            $ActualizacionUsuario->estadoactualizacion = $d['estadoactualizacion'];
            $ActualizacionUsuario->userid = $d['userid'];
            $ActualizacionUsuario->entrydate = $d['entrydate'];
            $ActualizacionUsuario->useridestado = $d['useridestado'];
            $ActualizacionUsuario->changedate = $d['changedate'];
            $ActualizacionUsuario->codigoestado = $d['codigoestado'];
            $ActualizacionUsuario->numerodocumento = $d['numerodocumento'];
                    
            $return[] = $ActualizacionUsuario;
            unset($ActualizacionUsuario);
        }
        
        return $return;
    }
    
    public function ActualizarUsuario($estado, $usuarioid, $idinstrumento, $periodo){                
        $db = Factory::createDbo();
        $updatequery = "UPDATE  actualizacionusuario SET estadoactualizacion=".$estado.", "
        ."useridestado='".$usuarioid."', changedate=NOW() "
        ."WHERE usuarioid='".$usuarioid."' AND id_instrumento= '".$idinstrumento."' "
        ."AND codigoperiodo= '".$periodo."' AND codigoestado= 100 ";    
        //d($updatequery);
        $db->Execute($updatequery);        
        return true;        
    } 
    
    public function getEstadoActualizarUsuario($usuarioid, $idinstrumento, $periodo){
        $db = Factory::createDbo();
        $query = "SELECT a.estadoactualizacion FROM actualizacionusuario a "
        ."where a.id_instrumento = ".$idinstrumento." and usuarioid = ".$usuarioid." and codigoperiodo = ".$periodo." ";            
        $Estadousuario = $db->GetRow($query);        
        
        if(!empty($Estadousuario['estadoactualizacion'])){
            return $Estadousuario['estadoactualizacion'];
        }else{
            return 0;
        }        
    }
    
    public function ActualizarEstadoActualizarUsuario($usuarioid, $idinstrumento, $periodo){
        $db = Factory::createDbo();
        $query1 = "SELECT a.estadoactualizacion FROM actualizacionusuario a "
        ."where a.id_instrumento = ".$idinstrumento." and usuarioid = ".$usuarioid." and codigoperiodo = ".$periodo." ";            
        $Estadousuario = $db->GetRow($query1);        
        
        if(!empty($Estadousuario['estadoactualizacion'])){
            return $Estadousuario['estadoactualizacion'];
        }else{
             $query2 = "INSERT INTO actualizacionusuario(usuarioid,id_instrumento,codigoperiodo,estadoactualizacion,userid,entrydate) "
            ." VALUES('".$usuarioid."','".$idinstrumento."','".$periodo."',1,'".$usuarioid."',NOW())";                
            $db->Execute($query2);         
            return true;
        }
    }
}