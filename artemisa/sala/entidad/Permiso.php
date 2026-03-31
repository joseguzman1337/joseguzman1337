<?php
/**
 * @author Andres Ariza <arizaandres@unbosque.edu.do>
 * @copyright Universidad el Bosque - Dirección de Tecnología
 * @package entidad
*/
namespace Sala\entidad;
defined('_EXEC') or die;
class Permiso implements \Entidad{
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
    private $idTipoPermiso;
    
    /**
     * @type int
     * @access private
     */
    private $idComponenteModulo;
    
    /**
     * @type int
     * @access private
     */
    private $idRelacionUsuario;
    
    /**
     * @type int
     * @access private
     */
    private $idUsuario;
    
    /**
     * @type int
     * @access private
     */
    private $ver;
    
    /**
     * @type int
     * @access private
     */
    private $editar;
    
    /**
     * @type int
     * @access private
     */
    private $insertar;
    
    /**
     * @type int
     * @access private
     */
    private $eliminar;
    
    public function __construct(){
    }
    
    public function setDb() {
        $this->db = \Factory::createDbo();
    }
    
    public function getId() {
        return $this->id;
    }

    public function getIdTipoPermiso() {
        return $this->idTipoPermiso;
    }

    public function getIdComponenteModulo() {
        return $this->idComponenteModulo;
    }

    public function getIdRelacionUsuario() {
        return $this->idRelacionUsuario;
    }

    public function getIdUsuario() {
        return $this->idUsuario;
    }

    public function getVer() {
        return $this->ver;
    }

    public function getEditar() {
        return $this->editar;
    }

    public function getInsertar() {
        return $this->insertar;
    }

    public function getEliminar() {
        return $this->eliminar;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setIdTipoPermiso($idTipoPermiso) {
        $this->idTipoPermiso = $idTipoPermiso;
    }

    public function setIdComponenteModulo($idComponenteModulo) {
        $this->idComponenteModulo = $idComponenteModulo;
    }

    public function setIdRelacionUsuario($idRelacionUsuario) {
        $this->idRelacionUsuario = $idRelacionUsuario;
    }

    public function setIdUsuario($idUsuario) {
        $this->idUsuario = $idUsuario;
    }

    public function setVer($ver) {
        $this->ver = $ver;
    }

    public function setEditar($editar) {
        $this->editar = $editar;
    }

    public function setInsertar($insertar) {
        $this->insertar = $insertar;
    }

    public function setEliminar($eliminar) {
        $this->eliminar = $eliminar;
    }

    public function getById() {
        if(!empty($this->id)){
            $query = "SELECT p.* FROM Permiso p "
                    . " INNER JOIN TipoPermiso tp ON (tp.id = p.idTipoPermiso) "
                    ." WHERE p.id = ".$this->db->qstr($this->id);
            
            $datos = $this->db->Execute($query);
            $d = $datos->FetchRow();
            
            if(!empty($d)){
                $this->setId($d["id"]);
                $this->setIdTipoPermiso($d["idTipoPermiso"]);
                $this->setIdComponenteModulo($d["idComponenteModulo"]);
                $this->setIdRelacionUsuario($d["idRelacionUsuario"]);
                $this->setIdUsuario($d["idUsuario"]);
                $this->setVer($d["ver"]);
                $this->setEditar($d["editar"]);
                $this->setInsertar($d["insertar"]);
                $this->setEliminar($d["eliminar"]);
            }
        }
    }

    public static function getList($where = null) {
        $db = \Factory::createDbo();
        
        $return = array();
        
        $query = "SELECT p.* "
                . " FROM Permiso p "
                . " INNER JOIN TipoPermiso tp ON (tp.id = p.idTipoPermiso) "
                . " WHERE 1";
        
        if(!empty($where)){
            $query .= " AND ".$where;
        }
        //d($query);
        $datos = $db->Execute($query);
        while($d = $datos->FetchRow()){
            $Permiso = new Permiso();
            $Permiso->setId($d["id"]);
            $Permiso->setIdTipoPermiso($d["idTipoPermiso"]);
            $Permiso->setIdComponenteModulo($d["idComponenteModulo"]);
            $Permiso->setIdRelacionUsuario($d["idRelacionUsuario"]);
            $Permiso->setIdUsuario($d["idUsuario"]);
            $Permiso->setVer($d["ver"]);
            $Permiso->setEditar($d["editar"]);
            $Permiso->setInsertar($d["insertar"]);
            $Permiso->setEliminar($d["eliminar"]);
            $return[] = $Permiso;
            unset($Permiso);
        }
        return $return;
    }

}