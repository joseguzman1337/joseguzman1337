<?php
namespace Sala\entidadDAO;
defined('_EXEC') or die;

//use \Sala\lib\Factory;
/**
 * @author Andres Ariza <arizaandres@unbosque.edu.do>
 * @copyright Universidad el Bosque - Dirección de Tecnología
 * @package entidadDAO
 * 
*/
class EstudianteDAO {
    /**
     * @type adodb Object
     * @access private
     */
    private $db;

    /**
     * @type Estudiante
     * @access private
     */
    private $estudiante;

    public function __construct(\Estudiante $estudiante) {
        $this->estudiante = $estudiante;
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
        $codigoestudiante = $this->estudiante->getCodigoestudiante();
        if(empty($codigoestudiante)){
            $query .= "INSERT INTO ";
        }else{
            $query .= "UPDATE ";
            $where[] = " codigoestudiante = ".$this->db->qstr($this->estudiante->getCodigoestudiante());
        }
        
        $query .= " estudiante SET "
               . " idestudiantegeneral = ".$this->db->qstr($this->estudiante->getIdestudiantegeneral()).", "
               . " codigocarrera = ".$this->db->qstr($this->estudiante->getCodigocarrera()).", "
               . " semestre = ".$this->db->qstr($this->estudiante->getSemestre()).", "
               . " numerocohorte = ".$this->db->qstr($this->estudiante->getNumerocohorte()).", "
               . " codigotipoestudiante = ".$this->db->qstr($this->estudiante->getCodigotipoestudiante()).", "
               . " codigosituacioncarreraestudiante = ".$this->db->qstr($this->estudiante->getCodigosituacioncarreraestudiante()).", "
               . " codigoperiodo = ".$this->db->qstr($this->estudiante->getCodigoperiodo()).", "
                
               . " VinculacionId = ".$this->db->qstr($this->estudiante->getVinculacionId());
        
        if(!empty($where)){
            $query .= " WHERE ".implode(" AND ",$where);
        }
        //d($query);
        $rs = $this->db->Execute($query);
        if(empty($codigoestudiante)){
            $this->estudiante->setCodigoestudiante($this->db->insert_Id());
        }
        $this->logAuditoria($this->estudiante, $query);
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
