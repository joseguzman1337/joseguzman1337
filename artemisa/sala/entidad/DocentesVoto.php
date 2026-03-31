<?php
/**
 * @author Andres Ariza <arizaandres@unbosque.edu.do>
 * @copyright Universidad el Bosque - Dirección de Tecnología
 * @package entidad
 * 
*/
defined('_EXEC') or die;
class DocentesVoto implements Entidad{
    /**
     * @type adodb Object
     * @access private
     */
    private $db;
    
    /**
     * @type int
     * @access private
     */
    private $numerodocumento;
    
    /**
     * @type int
     * @access private
     */
    private $codigocarrera;
    
    public function __construct() {
    }
    
    public function setDb(){
        $this->db = Factory::createDbo();
    }
    
    function getNumerodocumento() {
        return $this->numerodocumento;
    }

    function getCodigocarrera() {
        return $this->codigocarrera;
    }

    function setNumerodocumento($numerodocumento) {
        $this->numerodocumento = $numerodocumento;
    }

    function setCodigocarrera($codigocarrera) {
        $this->codigocarrera = $codigocarrera;
    }

    public function getByDocumento(){
        if(!empty($this->numerodocumento)){
            $query = "SELECT * FROM docentesvoto "
                    . "WHERE numerodocumento = ".$this->db->qstr($this->numerodocumento);
            //d($query);
            $datos = $this->db->Execute($query);
            $d = $datos->FetchRow();
            
            if(!empty($d)){
                $this->codigocarrera = $d['codigocarrera'];
            }
        }
    }
    
    public function getById() {
        $this->getByDocumento();
    }
    
    public static function getList($where) {
        $arrayReturn = array();
        return $arrayReturn;
    }
}
/*/
numerodocumento	int(11)
codigocarrera	int(11)
/**/