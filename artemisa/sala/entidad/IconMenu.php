<?php
/**
 * @author Andres Ariza <arizaandres@unbosque.edu.do>
 * @copyright Universidad el Bosque - Dirección de Tecnología
 * @package entidad
*/
defined('_EXEC') or die;
class IconMenu implements Entidad{
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
    private $idMenu;
    
    /**
     * @type varchar
     * @access private
     */
    private $referenciaMenu;
    
    /**
     * @type varchar
     * @access private
     */
    private $icon;
    
    /**
     * @type varchar
     * @access private
     */
    private $estado;
    
    public function __construct(){
    }
    
    public function setDb(){
        $this->db = Factory::createDbo();
    }
    
    public function getId() {
        return $this->id;
    }

    public function getIdMenu() {
        return $this->idMenu;
    }

    public function getReferenciaMenu() {
        return $this->referenciaMenu;
    }

    public function getIcon() {
        return $this->icon;
    }

    public function getEstado() {
        return $this->estado;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setIdMenu($idMenu) {
        $this->idMenu = $idMenu;
    }

    public function setReferenciaMenu($referenciaMenu) {
        $this->referenciaMenu = $referenciaMenu;
    }

    public function setIcon($icon) {
        $this->icon = $icon;
    }

    public function setEstado($estado) {
        $this->estado = $estado;
    }

    public function getById(){
        if(!empty($this->id)){
            $query = "SELECT * FROM IconMenu "
                    ." WHERE id = ".$this->db->qstr($this->id);
            
            $datos = $this->db->Execute($query);
            $d = $datos->FetchRow();
            
            if(!empty($d)){ 
                $this->idMenu = $d["idMenu"];
                $this->referenciaMenu = $d["referenciaMenu"];
                $this->icon = $d["icon"];
                $this->estado = $d["estado"]; 
            }
        }
    }

    public function getByIdMenuReferenciaMenu(){
        if(!empty($this->idMenu) && !empty($this->referenciaMenu)){
            $query = "SELECT * FROM IconMenu "
                    ." WHERE idMenu = ".$this->db->qstr($this->idMenu)
                    ." AND referenciaMenu = ".$this->db->qstr($this->referenciaMenu);
            
            $datos = $this->db->Execute($query);
            $d = $datos->FetchRow();
            
            if(!empty($d)){ 
                $this->id = $d["id"];
                $this->icon = $d["icon"];
                $this->estado = $d["estado"]; 
            }
        }
    }
        
    public static function getList($where=null, $orderBy = null){
        $return = array();
        $db = Factory::createDbo();
        $query = "SELECT * FROM IconMenu "
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
            $IconMenu = new IconMenu();
            
            $IconMenu->id = $d["id"];
            $IconMenu->idMenu = $d["idMenu"];
            $IconMenu->referenciaMenu = $d["referenciaMenu"];
            $IconMenu->icon = $d["icon"];
            $IconMenu->estado = $d["estado"];
            
            $return[] = $IconMenu;
            unset($IconMenu);
        }
        
        return $return;
    }
    
    
    public function save(){
        $query = "";
        $where = array();
        
        if(empty($this->idmenuboton)){
            $query .= "INSERT INTO ";
        }else{
            $query .= "UPDATE ";
            $where[] = " id = ".$this->db->qstr($this->id);
        }
        $estado = $this->estado;
        if(is_null($estado)){
            $this->estado = 1;
        }
        
        $query .= " IconMenu SET "
               . " idMenu = ".$this->db->qstr($this->idMenu).", "
               . " referenciaMenu = ".$this->db->qstr($this->referenciaMenu).", "
               . " icon = ".$this->db->qstr($this->icon).", "
               . " estado = ".$this->db->qstr($this->estado);
        
        if(!empty($where)){
            $query .= " WHERE ".implode(" AND ",$where);
        }
        //d($query);
        $rs = $this->db->Execute($query);
        
        if(empty($this->id)){
            $this->id = $this->db->insert_Id();
        }
        
        if(!$rs){
            return false;
        }else{
            return true;
        }
    } 


}
/*/
`id`  int(11)
`idMenu`  int(11)
`referenciaMenu`  varchar(50) 
`icon`  varchar(50)
`estado`  varchar(3)
/**/