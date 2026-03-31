<?php
defined('_EXEC') or die;

/**
 * Clase ModulosMenu es una entidad de la capa de datos encargada de interactuar
 * con la base de datos en todo lo relacionado con la taba ModulosMenu
 * 
 * @author Andres Ariza <arizaandres@unbosque.edu.do>
 * @copyright Universidad el Bosque - Dirección de Tecnología
 * @package entidad
*/
class ModulosMenu implements Entidad{
    /**
     * @var adodb Object
     * @access private
     */
    private $db;
    
    /**
     * @var int
     * @access private
     */
    private $id;
    
    /**
     * @var int
     * @access private
     */
    private $itemId;
    
    /**
     * @var int
     * @access private
     */
    private $modulo;
    
    /**
     * @var int
     * @access private
     */
    private $estado;
    
    public function __construct(){}
    
    /**
     * Instancia el objeto db para la conexion a bases de datos
     * @access public
     * @return void
     * @author Andres Ariza <arizaandres@unbosque.edu.do>
    */
    public function setDb(){
        $this->db = Factory::createDbo();
    }
    
    public function getId() {
        return $this->id;
    }

    public function getItemId() {
        return $this->itemId;
    }

    public function getModulo() {
        return $this->modulo;
    }

    public function getEstado() {
        return $this->estado;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setItemId($itemId) {
        $this->itemId = $itemId;
    }

    public function setModulo($modulo) {
        $this->modulo = $modulo;
    }

    public function setEstado($estado) {
        $this->estado = $estado;
    }

    /**
     * Hace una consulta con el primary key de la tabla a bases de datos y 
     * rellena todos los atriburos con el resultado devuelto
     * @access public
     * @return void
     * @author Andres Ariza <arizaandres@unbosque.edu.do>
    */
    public function getById(){
        
        if(!empty($this->id)){
            $query = "SELECT * FROM ModulosMenu "
                    ." WHERE id = ".$this->db->qstr($this->id);
            
            $datos = $this->db->Execute($query);
            $d = $datos->FetchRow();
            
            if(!empty($d)){
                $this->itemId = $d['itemId'];
                $this->modulo = $d['modulo'];
                $this->estado = $d['estado'];
            }
        }
    }
    
    public function saveModulosMenu(){
        $query = "";
        $where = array();
        
        if(empty($this->id)){
            $query .= "INSERT INTO ";
        }else{
            $query .= "UPDATE ";
            $where[] = " id = ".$this->db->qstr($this->id);
        }
        
        $query .= " ModulosMenu SET "
               . " itemId = ".$this->db->qstr($this->itemId).", "
               . " modulo = ".$this->db->qstr($this->modulo).", "
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
    
    public static function getListModulosMenu(){
        $db = Factory::createDbo();
        $return = array();
        $where = array();
        $where[] = " estado = ".$db->qstr(1);
                
        $args = func_get_args();
        if(!empty($args)){
            $where[] = " itemId IN (".implode(", ", $args).") ";
        }
        
        $query = "SELECT * "
                . " FROM ModulosMenu";
        
        if(!empty($where)){
            $query .= " WHERE ".implode(" AND ", $where);
        }
        
        $datos = $db->Execute($query);
        while($d = $datos->FetchRow()){
            $ModulosMenu = new ModulosMenu();
            $ModulosMenu->id = $d['id'];
            $ModulosMenu->itemId = $d['itemId'];
            $ModulosMenu->modulo = $d['modulo'];
            $ModulosMenu->estado = $d['estado'];
            $return[] = $ModulosMenu;
            unset($ModulosMenu);
        }
        //ddd($return);
        return $return;
    }
    
    /**
     * Hace una consulta a la tabla en bases de datos con las condiciones de la 
     * variable where 
     * y retorna un array de Entidad con los resultados de la consulta
     * @access public
     * @param String $where
     * @return array of Entidad
     * @author Andres Ariza <arizaandres@unbosque.edu.do>
     * @since mayo 3, 2018
    */
    public static function getList($where) {
        return self::getListModulosMenu();
    }

}