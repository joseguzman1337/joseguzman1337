<?php
/**
 * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package entidadDAO
 */

namespace Sala\entidadDAO;
defined('_EXEC') or die;

/**
 * Description of PeriodoDAO
 *
 * @author arizaandres
 */
class PeriodoDAO implements \Sala\interfaces\EntidadDAO {
    /**
     * @type adodb Object
     * @access private
     */
    private $db;

    /**
     * @type Estudiante
     * @access private
     */
    private $periodo;

    public function __construct(\Periodo $periodo) {
        $this->periodo = $periodo;
    }
    
    public function setDb(){
        $this->db = \Factory::createDbo();
    }

    public function save() {     
        $query = "";
        $where = array();
        $codigoperiodo = $this->periodo->getCodigoperiodo();
        $periodoId = $this->periodo->getPeriodoId();
        if(empty($codigoperiodo) || $this->checkExist()===false ){
            $query .= "INSERT INTO ";
        }else{
            $query .= "UPDATE ";
            $where[] = " codigoperiodo = ".$this->db->qstr($codigoperiodo);
        }
        
        if(empty($periodoId)){
            $periodoId="(SELECT (MAX(P.PeriodoId)+1) FROM periodo P)";
        }else{
            $periodoId=$this->db->qstr($this->periodo->getPeriodoId());
        }
      
        $query .= " periodo SET "
               . " codigoperiodo = ".$this->db->qstr($this->periodo->getCodigoperiodo()).", "
               . " nombreperiodo = ".$this->db->qstr($this->periodo->getNombreperiodo()).", "
               . " codigoestadoperiodo = ".$this->db->qstr($this->periodo->getCodigoestadoperiodo()).", "
               . " fechainicioperiodo = ".$this->db->qstr($this->periodo->getFechainicioperiodo()).", "
               . " fechavencimientoperiodo = ".$this->db->qstr($this->periodo->getFechavencimientoperiodo()).", "
               . " numeroperiodo = ".$this->db->qstr($this->periodo->getNumeroperiodo()).", "
               . " PeriodoId = ".$periodoId.""; 
       
        if(!empty($where)){
            $query .= " WHERE ".implode(" AND ",$where);
        }
        //ddd($query);
        $rs = $this->db->Execute($query);
        if(empty($codigoperiodo)){
            $this->periodo->setCodigoperiodo($this->db->insert_Id());
        }
        //ddd($this->periodo);
        $this->logAuditoria($this->periodo, $query);
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
    
    private function checkExist(){
        $periodo = new \Periodo();
        $periodo->setDb();
        $periodo->setCodigoperiodo($this->periodo->getCodigoperiodo());
        $periodo->getById();
        
        $fecha = $periodo->getFechainicioperiodo();
        
        return ( !empty($fecha) );
        
    }

}
