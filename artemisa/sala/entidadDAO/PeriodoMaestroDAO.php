<?php

namespace Sala\entidadDAO;

/**
 * @author Andres Ariza <arizaandres@unbosque.edu.do>
 * @copyright Universidad el Bosque - Dirección de Tecnología
 * @package entidadDAO
 */
defined('_EXEC') or die;

class PeriodoMaestroDAO implements \Sala\interfaces\EntidadDAO {

    /**
     * @type adodb Object
     * @access private
     */
    private $db;

    /**
     * @type PeriodoMaestro
     * @access private
     */
    private $periodoMaestro;

    public function __construct(\PeriodoMaestro $periodoMaestro) {
        $this->periodoMaestro = $periodoMaestro;
    }

    public function setDb() {
        $this->db = \Factory::createDbo();
    }

    public function save() {
        $query = "";
        $where = array();
        $id = $this->periodoMaestro->getId();

        if (empty( $id )) {
            $query .= "INSERT INTO ";
        } else {
            $query .= "UPDATE ";
            $where[] = " id = " . $this->db->qstr($this->periodoMaestro->getId());
        }
        
        $query .= " periodoMaestro SET "
                . "codigo = " . $this->db->qstr($this->periodoMaestro->getCodigo()).", "
                . "nombre = " . $this->db->qstr($this->periodoMaestro->getNombre()).", "
                . "numeroPeriodo = " . $this->db->qstr($this->periodoMaestro->getNumeroPeriodo()).", "
                . "idAgno = " . $this->db->qstr($this->periodoMaestro->getIdAgno()).", "
                . "codigoEstado = " . $this->db->qstr($this->periodoMaestro->getCodigoEstado()).", "
                . "idUsuarioCreacion = " . $this->db->qstr($this->periodoMaestro->getIdUsuarioCreacion()).", "
                . "fechaCreacion = " . $this->db->qstr($this->periodoMaestro->getFechaCreacion()).", "
                . "idUsuarioModificacion = " . $this->db->qstr($this->periodoMaestro->getIdUsuarioModificacion()).", "
                . "fechaModificacion = " . $this->db->qstr($this->periodoMaestro->getFechaModificacion());
        
        if(!empty($where)){
            $query .= " WHERE ".implode(" AND ",$where);
        }
        
        $rs = $this->db->Execute($query);
        if(empty($id)){
            $this->periodoMaestro->setId($this->db->insert_Id());
        }
        $this->logAuditoria($this->periodoMaestro, $query);
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
