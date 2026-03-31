<?php

namespace Sala\entidadDAO;

defined('_EXEC') or die;

class CobroMatriculaDAO implements \Sala\interfaces\EntidadDAO {

    private $db;
    private $cobroMatricula;

    public function __construct(\CobroMatricula $cobroMatricula) {
        $this->cobroMatricula = $cobroMatricula;
    }

    public function setDb() {
        $this->db = \Factory::createDbo();
    }

    public function logAuditoria($e, $query) {
        
    }

    public function save() {
        $query = "";
        $where = array();
        $id = $this->cobroMatricula->getIdentificador();
        if ($id=="Nuevo" ) {
            $query .= "INSERT INTO ";
        } else {
            $query .= "UPDATE ";
            $where[] = "codigoperiodo = " . $this->db->qstr($this->cobroMatricula->getCodigoPeriodo()) . "AND "
                . "porcentajecreditosdesde = " . $this->db->qstr($this->cobroMatricula->getPorcentajeCreditosDesde()) . "AND "
                . "porcentajecreditoshasta = " . $this->db->qstr($this->cobroMatricula->getPorcentajeCreditosHasta()) . " AND "
                . "porcentajecobromatricula = " . $this->db->qstr($this->cobroMatricula->getPorcentajeCobroMatricula());
        }

        $query .= "cobromatricula SET "
                . "codigoperiodo = " . $this->db->qstr($this->cobroMatricula->getCodigoPeriodoN()) . ","
                . "porcentajecreditosdesde = " . $this->db->qstr($this->cobroMatricula->getPorcentajeCreditosDesdeN()) . ","
                . "porcentajecreditoshasta = " . $this->db->qstr($this->cobroMatricula->getPorcentajeCreditosHastaN()) . ","
                . "porcentajecobromatricula = " . $this->db->qstr($this->cobroMatricula->getPorcentajeCobroMatriculaN());


        if (!empty($where)) {
            $query .= " WHERE " . implode(" AND ", $where);
        }
        $rs = $this->db->Execute($query);
        if (!$rs) {
            return false;
        } else {
            return true;
        }
    }

}
