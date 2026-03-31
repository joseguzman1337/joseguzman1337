<?php
namespace Sala\entidadDAO;

defined('_EXEC') or die;

/**
 * @author Andres Ariza <arizaandres@unbosque.edu.do>
 * @copyright Universidad el Bosque - Dirección de Tecnología
 * @package entidadDAO
 * 
*/
class EstudianteCarreraInscripcionDAO implements \Sala\interfaces\EntidadDAO {
    /**
     * @type adodb Object
     * @access private
     */
    private $db;

    /**
     * @type EstudianteCarreraInscripcion
     * @access private
     */
    private $estudianteCarreraInscripcion;

    public function __construct(\EstudianteCarreraInscripcion $estudianteCarreraInscripcion) {
        $this->estudianteCarreraInscripcion = $estudianteCarreraInscripcion;
    }
    
    public function setDb(){
        $this->db = \Factory::createDbo();
    }

    /**
     * Hace una consulta DML de tipo insert o update para las persistencias de 
     * datos en las tabla inscripcion con los datos recibidos en $inscripcion
     * @access public
     * @return void
     */
    public function save() {       
        $query = "";
        $where = array();
        $idestudiantecarrerainscripcion=$this->estudianteCarreraInscripcion->getIdestudiantecarrerainscripcion();
        if(empty($idestudiantecarrerainscripcion)){
            $query .= "INSERT INTO ";
        }else{
            $query .= "UPDATE ";
            $where[] = " idestudiantecarrerainscripcion = ".$this->db->qstr($this->estudianteCarreraInscripcion->getIdestudiantecarrerainscripcion());
        }
        
        $query .= " estudiantecarrerainscripcion SET "
               . " codigocarrera = ".$this->db->qstr($this->estudianteCarreraInscripcion->getCodigocarrera()).", "
               . " idnumeroopcion = ".$this->db->qstr($this->estudianteCarreraInscripcion->getIdnumeroopcion()).", "
               . " idinscripcion = ".$this->db->qstr($this->estudianteCarreraInscripcion->getIdinscripcion()).", "
               . " idestudiantegeneral = ".$this->db->qstr($this->estudianteCarreraInscripcion->getIdestudiantegeneral()).", "
               . " codigoestado = ".$this->db->qstr($this->estudianteCarreraInscripcion->getCodigoestado());
        
        if(!empty($where)){
            $query .= " WHERE ".implode(" AND ",$where);
        }
        
        $rs = $this->db->Execute($query); 
        if(empty($idestudiantecarrerainscripcion)){
            $this->estudianteCarreraInscripcion->setIdestudiantecarrerainscripcion($this->db->insert_Id());
        }
        $this->logAuditoria($this->estudianteCarreraInscripcion, $query);
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
