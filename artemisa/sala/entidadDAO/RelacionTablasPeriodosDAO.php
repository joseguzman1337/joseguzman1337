<?php
/**
 * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package entidadDAO
 */

namespace Sala\entidadDAO;

/**
 * Description of RelacionTablasPeriodosDAO
 *
 * @author arizaandres
 */
class RelacionTablasPeriodosDAO implements \Sala\interfaces\EntidadDAO {
    /**
     * @type adodb Object
     * @access private
     */
    private $db;

    /**
     * @type RelacionTablasPeriodosDAO
     * @access private
     */
    private $relacionTablasPeriodos;

    public function __construct(\Sala\entidad\RelacionTablasPeriodos $relacionTablasPeriodos) {
        $this->relacionTablasPeriodos = $relacionTablasPeriodos;
    }
    
    public function setDb(){
        $this->db = \Factory::createDbo();
    }

    public function save() {  
        $query = "";
        $where = array();
        $id = $this->relacionTablasPeriodos->getId();
        if(empty($id)){
            $query .= "INSERT INTO ";
        }else{
            $query .= "UPDATE ";
            $where[] = " id = ".$this->db->qstr($id);
        }
        
        $query .= " relacionTablasPeriodos SET "
               . " tabla = ".$this->db->qstr($this->relacionTablasPeriodos->getTabla()).", "
               . " idTabla = ".$this->db->qstr($this->relacionTablasPeriodos->getIdTabla()).", "
               . " idPeriodoMaestro1 = ".$this->db->qstr($this->relacionTablasPeriodos->getIdPeriodoMaestro1()).", "
               . " idPeriodoMaestro2 = ".$this->db->qstr($this->relacionTablasPeriodos->getIdPeriodoMaestro2()).", "
               . " idPeriodoFinanciero = ".$this->db->qstr($this->relacionTablasPeriodos->getIdPeriodoFinanciero()).", "
               . " idPeriodoAcademico = ".$this->db->qstr($this->relacionTablasPeriodos->getIdPeriodoAcademico());
        
        if(!empty($where)){
            $query .= " WHERE ".implode(" AND ",$where);
        }
        
        $rs = $this->db->Execute($query);
        if(empty($id)){
            $this->relacionTablasPeriodos->setId($this->db->insert_Id());
        }
        
        if(!$rs){
            return false;
        }else{
            return true;
        }
    }
    
    public function logAuditoria($e = null, $query = null) {
        return $e = $query;
    }

}
