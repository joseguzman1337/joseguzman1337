<?php
namespace Sala\entidadDAO;
/** 
 * @author Diego Rivera <riveradiego@unbosque.edu.do>
 * @copyright Universidad el Bosque - Dirección de Tecnología
 * @package entidadDAO
 */
defined('_EXEC') or die;

class CarreraPeriodoDAO implements \Sala\interfaces\EntidadDAO {
    /**
     * @type adodb Object
     * @access private
     */
    private $db;
     /**
     * @type CarreraPeriodo
     * @access private
     */
    private $carrreraPeriodo;
    
    public function __construct(\CarreraPeriodo $carreraPeriodo) {
        $this->carrreraPeriodo=$carreraPeriodo;
    }
 
    public function setDb() {
        $this->db = \Factory::createDbo();
    }
    
    public function save() {
        $query = "";
        $where = array();
        $idCarreraPeriodo = $this->carrreraPeriodo->getIdCarreraPeriodo();
        if(empty($idCarreraPeriodo)){
            $query .= "INSERT INTO ";
        }else{
            $query .= "UPDATE ";
        }
        
        $query .= "carreraperiodo SET "
               . "codigocarrera=".$this->db->qstr($this->carrreraPeriodo->getCodigoCarrera())."," 
               . "codigoperiodo=".$this->db->qstr($this->carrreraPeriodo->getCodigoPeriodo()).","
               . "codigoestado=".$this->db->qstr($this->carrreraPeriodo->getCodigoEStado());
        if(!empty($where)){
            $query .= " WHERE ".implode(" AND ",$where);
        }      
        $rs = $this->db->Execute($query);
        
        if(empty($idCarreraPeriodo)){
           $this->carrreraPeriodo->setIdCarreraPeriodo($this->db->insert_Id());
        }
        
        $this->logAuditoria($this->carrreraPeriodo, $query);
        
        if(!$rs){
            return false;
        }else{
            return true;
        }
        
    }

    public function logAuditoria($e, $query) {
        require_once(PATH_SITE."/entidadDAO/LogAuditoriaDAO.php");
        $idUsuario = \Factory::getSessionVar("idusuario");
        \Sala\entidadDAO\LogAuditoriaDAO::setLogAuditoria($e, $query, $idUsuario);
    }

}
