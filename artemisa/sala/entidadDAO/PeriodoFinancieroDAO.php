<?php

namespace Sala\entidadDAO;
defined('_EXEC') or die;
/**
 * @author Andres Ariza <arizaandres@unbosque.edu.do>
 * @copyright Universidad el Bosque - Dirección de Tecnología
 * @package entidadDAO
 * 
*/
class PeriodoFinancieroDAO implements \Sala\interfaces\EntidadDAO{
    
    /**
     * @type adodb Object
     * @access private
     */
    private $db;

    /**
     * @type PeriodoFinanciero
     * @access private
     */
    private $periodoFinanciero;

    public function __construct(\PeriodoFinanciero $periodoFinanciero) {
        $this->periodoFinanciero = $periodoFinanciero;
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
        $codigoestudiante = $this->periodoFinanciero->getId();
        if(empty($codigoestudiante)){
            $query .= "INSERT INTO ";
        }else{
            $query .= "UPDATE ";
            $where[] = " id = ".$this->db->qstr($this->periodoFinanciero->getId());
        }
        
        $query .= " periodoFinanciero SET "
               . " idPeriodoMaestro = ".$this->db->qstr($this->periodoFinanciero->getIdPeriodoMaestro()).", " 
               . " nombre = ".$this->db->qstr($this->periodoFinanciero->getNombre()).", " 
               . " fechaInicio = ".$this->db->qstr($this->periodoFinanciero->getFechaInicio()).", " 
               . " fechaFin = ".$this->db->qstr($this->periodoFinanciero->getFechaFin()).", " 
               . " codigoEstado = ".$this->db->qstr($this->periodoFinanciero->getCodigoEstado()).", " 
               . " idUsuarioCreacion = ".$this->db->qstr($this->periodoFinanciero->getIdUsuarioCreacion()).", " 
               . " fechaCreacion = ".$this->db->qstr($this->periodoFinanciero->getFechaCreacion()).", " 
               . " idUsuarioModificacion = ".$this->db->qstr($this->periodoFinanciero->getIdUsuarioModificacion()).", " 
               . " fechaModificacion = ".$this->db->qstr($this->periodoFinanciero->getFechaModificacion()) ;
        
        if(!empty($where)){
            $query .= " WHERE ".implode(" AND ",$where);
        }
        
        $rs = $this->db->Execute($query);
        if(empty($codigoestudiante)){
            $this->periodoFinanciero->setId($this->db->insert_Id());
        }
        $this->logAuditoria($this->periodoFinanciero, $query);
        if(!$rs){
            return false;
        }else{
            return true;
        }
    }
    
    public function logAuditoria($e, $query) {
        $idUsuario = \Factory::getSessionVar("idusuario");
        \Sala\entidadDAO\LogAuditoriaDAO::setLogAuditoria($e, $query, $idUsuario);
    }

}
