<?php
namespace Sala\entidadDAO;
defined('_EXEC') or die;
/**
 * @author Andres Ariza <arizaandres@unbosque.edu.do>
 * @copyright Universidad el Bosque - Dirección de Tecnología
 * @package entidadDAO
 * 
*/
class UsuarioDAO implements \Sala\interfaces\EntidadDAO {
    /**
     * @type adodb Object
     * @access private
     */
    private $db;

    /**
     * @type Estudiante
     * @access private
     */
    private $usuario;

    public function __construct(\Usuario $usuario) {
        $this->usuario = $usuario;
    }
    
    public function setDb(){
        $this->db = \Factory::createDbo();
    }

    /**
     * Hace una consulta DML de tipo insert o update para las persistencias de 
     * datos en las tabla estudiante con los datos recibidos en $estudiante
     * @access public
     * @return void
     */
    public function save() {        
        $query = "";
        $where = array();
        $usuario=$this->usuario->getIdusuario();
        if(empty($usuario)){
            $query .= "INSERT INTO ";
        }else{
            $query .= "UPDATE ";
            $where[] = " idusuario = ".$this->db->qstr($this->usuario->getIdusuario());
        }

        
        $query .= " usuario SET "
               . " usuario = ".$this->db->qstr($this->usuario->getUsuario())
               . " ,numerodocumento = ".$this->db->qstr($this->usuario->getNumerodocumento())
               . " ,tipodocumento = ".$this->db->qstr($this->usuario->getTipodocumento())
               . " ,apellidos = ".$this->db->qstr($this->usuario->getApellidos())
               . " ,nombres = ".$this->db->qstr($this->usuario->getNombres())
               . " ,codigousuario = ".$this->db->qstr($this->usuario->getCodigousuario())
               . " ,semestre = ".$this->db->qstr($this->usuario->getSemestre())
               . " ,codigorol = ".$this->db->qstr($this->usuario->getCodigorol())
               . " ,fechainiciousuario = ".$this->db->qstr($this->usuario->getFechainiciousuario())                
               . " ,fechavencimientousuario = ".$this->db->qstr($this->usuario->getFechavencimientousuario())
               . " ,fecharegistrousuario = ".$this->db->qstr($this->usuario->getFecharegistrousuario())
               . " ,codigotipousuario = ".$this->db->qstr($this->usuario->getCodigotipousuario())
               . " ,idusuariopadre = ".$this->db->qstr($this->usuario->getIdusuariopadre())
               . " ,ipaccesousuario = ".$this->db->qstr($this->usuario->getIpaccesousuario())
               . " ,codigoestadousuario = ".$this->db->qstr($this->usuario->getCodigoestadousuario());
        
        if(!empty($where)){
            $query .= " WHERE ".implode(" AND ",$where);
        }
        
        $rs = $this->db->Execute($query);
        if(empty($usuario)){
            $this->usuario->setIdusuario($this->db->insert_Id());
        }
        $this->logAuditoria($this->usuario, $query);
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
