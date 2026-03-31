<?php
namespace Sala\entidadDAO;

defined('_EXEC') or die;

/**
 * @author Andres Ariza <arizaandres@unbosque.edu.do>
 * @copyright Universidad el Bosque - Dirección de Tecnología
 * @package entidadDAO
 * 
 */
class PeriodoAcademicoDAO implements \Sala\interfaces\EntidadDAO {

    /**
     * @type adodb Object
     * @access private
     */
    private $db;

    /**
     * @type PeriodoAcademico
     * @access private
     */
    private $periodoAcademico;

    public function __construct(\PeriodoAcademico $periodoAcademico) {
        $this->periodoAcademico = $periodoAcademico;
    }

    public function setDb() {
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
        $id = $this->periodoAcademico->getId();
        if (empty($id)) {
            $query .= "INSERT INTO ";
        } else {
            $query .= "UPDATE ";
            $where[] = " id = " . $this->db->qstr($this->periodoAcademico->getId());
        }

        $query .= " periodoAcademico SET "
                . " idPeriodoMaestro = " . $this->db->qstr($this->periodoAcademico->getIdPeriodoMaestro()) . ", "
                . " codigoModalidadAcademica = " . $this->db->qstr($this->periodoAcademico->getCodigoModalidadAcademica()) . ", "
                . " idPeriodoFinanciero = " . $this->db->qstr($this->periodoAcademico->getIdPeriodoFinanciero()) . ", "
                . " idEstadoPeriodo = " . $this->db->qstr($this->periodoAcademico->getIdEstadoPeriodo()) . ", "
                . " idTipoPeriodo = " . $this->db->qstr($this->periodoAcademico->getIdTipoPeriodo()) . ", "
                . " codigoCarrera = " . $this->db->qstr($this->periodoAcademico->getCodigoCarrera()) . ", "
                . " fechaInicio = " . $this->db->qstr($this->periodoAcademico->getFechaInicio()) . ", "
                . " fechaFin = " . $this->db->qstr($this->periodoAcademico->getFechaFin()) . ", "
                . " idUsuarioCreacion = " . $this->db->qstr($this->periodoAcademico->getIdUsuarioCreacion()) . ", "
                . " fechaCreacion = " . $this->db->qstr($this->periodoAcademico->getFechaCreacion()) . ", "
                . " idUsuarioModificacion = " . $this->db->qstr($this->periodoAcademico->getIdUsuarioModificacion()) . ", "
                . " fechaModificacion = " . $this->db->qstr($this->periodoAcademico->getFechaModificacion()) . ", "
                . " ip = " . $this->db->qstr($this->periodoAcademico->getIp());

        if (!empty($where)) {
            $query .= " WHERE " . implode(" AND ", $where);
        }

        $rs = $this->db->Execute($query);
        if (empty($id)) {
            $this->periodoAcademico->setId($this->db->insert_Id());
        }
        $this->logAuditoria($this->periodoAcademico, $query);
        if (!$rs) {
            return false;
        } else {
            return true;
        }
    }

    public function logAuditoria($e, $query) {
        $idUsuario = \Factory::getSessionVar("idusuario");
        \Sala\entidadDAO\LogAuditoriaDAO::setLogAuditoria($e, $query, $idUsuario);
    }

}
