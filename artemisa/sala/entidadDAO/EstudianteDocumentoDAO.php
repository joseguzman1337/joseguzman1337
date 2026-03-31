<?php
namespace Sala\entidadDAO;
defined('_EXEC') or die;
/**
 * @author Gabriel Vega <vegagabriel@unbosque.edu.do>
 * @copyright Universidad el Bosque - Dirección de Tecnología
 * @package entidadDAO
 * 
*/
class EstudianteDocumentoDAO implements \Sala\interfaces\EntidadDAO {
    /**
     * @type adodb Object
     * @access private
     */
    private $db;

    /**
     * @type EstudianteDocumento
     * @access private
     */
    private $estudianteDocumento;

    public function __construct(\EstudianteDocumento $estudianteDocumento) {
        $this->estudianteDocumento = $estudianteDocumento;
    }
    
    public function setDb(){
        $this->db = \Factory::createDbo();
    }

    /**
     * Hace una consulta DML de tipo insert o update para las persistencias de 
     * datos en las tabla estudiante con los datos recibidos en $estudianteGeneral
     * @access public
     * @return void
     */
    public function save() {        
        $query = "";
        $where = array();
        $idestudiantedocumento=$this->estudianteDocumento->getIdestudiantedocumento();
        if(empty($idestudiantedocumento)){
            $query .= "INSERT INTO ";
        }else{
            $query .= "UPDATE ";
            $where[] = " idestudiantedocumento = ".$this->db->qstr($this->estudianteDocumento->getIdestudiantedocumento());
        }
        
        $query .= " estudiantedocumento SET ";
	$query .= " idestudiantegeneral = ".$this->db->qstr($this->estudianteDocumento->getIdestudiantegeneral());
        $query .= " ,tipodocumento = ".$this->db->qstr($this->estudianteDocumento->getTipodocumento());
        $query .= " ,numerodocumento = ".$this->db->qstr($this->estudianteDocumento->getNumerodocumento());
        $query .= " ,expedidodocumento = ".$this->db->qstr($this->estudianteDocumento->getExpedidodocumento());
        $query .= " ,fechainicioestudiantedocumento = ".$this->db->qstr($this->estudianteDocumento->getFechainicioestudiantedocumento());
        $query .= " ,fechavencimientoestudiantedocumento = ".$this->db->qstr($this->estudianteDocumento->getFechavencimientoestudiantedocumento());
        
        if(!empty($where)){
            $query .= " WHERE ".implode(" AND ",$where);
        }
        
        $rs = $this->db->Execute($query);
        
        if(empty($idestudiantedocumento)){
            $this->estudianteDocumento->setIdestudiantedocumento($this->db->insert_Id());
        }
        $this->logAuditoria($this->estudianteDocumento, $query);
        if(!$rs){
            return false;
        }else{
            return true;
        }
        
    }
    
    public function logAuditoria( $e, $query) {
        require_once(PATH_SITE."/entidadDAO/LogAuditoriaDAO.php");
        $idUsuario = \Factory::getSessionVar("idusuario");
        \Sala\entidadDAO\LogAuditoriaDAO::setLogAuditoria($e, $query, $idUsuario);
    }

}
