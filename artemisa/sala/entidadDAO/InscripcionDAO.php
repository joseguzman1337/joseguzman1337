<?php
namespace Sala\entidadDAO;

defined('_EXEC') or die;

/**
 * @author Andres Ariza <arizaandres@unbosque.edu.do>
 * @copyright Universidad el Bosque - Dirección de Tecnología
 * @package entidadDAO
 * 
*/
class InscripcionDAO implements \Sala\interfaces\EntidadDAO {
    /**
     * @type adodb Object
     * @access private
     */
    private $db;

    /**
     * @type Inscripcion
     * @access private
     */
    private $inscripcion;

    public function __construct(\Inscripcion $inscripcion) {
        $this->inscripcion = $inscripcion;
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
        $idinscripcion = $this->inscripcion->getIdinscripcion();
        if(empty($idinscripcion)){
            $query .= "INSERT INTO ";
        }else{
            $query .= "UPDATE ";
            $where[] = " idinscripcion = ".$this->db->qstr($this->inscripcion->getIdinscripcion());
        }
        
        $query .= " inscripcion SET "
               . " anoaspirainscripcion = ".$this->db->qstr($this->inscripcion->getAnoaspirainscripcion()).", "
               . " codigoestado = ".$this->db->qstr($this->inscripcion->getCodigoestado()).", "
               . " codigomodalidadacademica = ".$this->db->qstr($this->inscripcion->getCodigomodalidadacademica()).", "
               . " codigoperiodo = ".$this->db->qstr($this->inscripcion->getCodigoperiodo()).", "
               . " codigosituacioncarreraestudiante = ".$this->db->qstr($this->inscripcion->getCodigosituacioncarreraestudiante()).", "
               . " fechainscripcion = ".$this->db->qstr($this->inscripcion->getFechainscripcion()).", "
               . " fotoinscripcion = ".$this->db->qstr($this->inscripcion->getFotoinscripcion()).", "
               . " idestudiantegeneral = ".$this->db->qstr($this->inscripcion->getIdestudiantegeneral()).", "
                
               . " numeroinscripcion = ".$this->db->qstr($this->inscripcion->getNumeroinscripcion());
        
        if(!empty($where)){
            $query .= " WHERE ".implode(" AND ",$where);
        }
        //d($query);
        $rs = $this->db->Execute($query); 
        if(empty($idinscripcion)){
            $this->inscripcion->setIdinscripcion($this->db->insert_Id());
        }
        $this->logAuditoria($this->inscripcion, $query);
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
