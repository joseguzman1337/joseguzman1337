<?php
/**
 * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package entidadDAO
 */

namespace Sala\entidadDAO;

defined('_EXEC') or die;

/**
 * Description of SubperiodoDAO
 *
 * @author arizaandres
 */
class SubperiodoDAO implements \Sala\interfaces\EntidadDAO {

    /**
     * @type adodb Object
     * @access private
     */
    private $db;

    /**
     * @type Estudiante
     * @access private
     */
    private $subPeriodo;

    public function __construct(\Sala\entidad\Subperiodo $subPeriodo) {
        $this->subPeriodo = $subPeriodo;
    }

    public function setDb() {
        $this->db = \Factory::createDbo();
    }

    public function save() {
        $query = "";
        $where = array();
        $idsubperiodo = $this->subPeriodo->getIdsubperiodo();
        if (empty($idsubperiodo)) {
            $query .= "INSERT INTO ";
        } else {
            $query .= "UPDATE ";
            $where[] = " idsubperiodo = " . $this->db->qstr($idsubperiodo);
        }

        $query .= " subperiodo SET "
                . " idsubperiodo = " . $this->db->qstr($this->subPeriodo->getIdsubperiodo()) . ", "
                . " idcarreraperiodo = " . $this->db->qstr($this->subPeriodo->getIdcarreraperiodo()) . ", "
                . " nombresubperiodo = " . $this->db->qstr($this->subPeriodo->getNombresubperiodo()) . ", "
                . " fechasubperiodo = " . $this->db->qstr($this->subPeriodo->getFechasubperiodo()) . ", "
                . " fechainicioacademicosubperiodo = " . $this->db->qstr($this->subPeriodo->getFechainicioacademicosubperiodo()) . ", "
                . " fechafinalacademicosubperiodo = " . $this->db->qstr($this->subPeriodo->getFechafinalacademicosubperiodo()) . ", "
                . " fechainiciofinancierosubperiodo = " . $this->db->qstr($this->subPeriodo->getFechainiciofinancierosubperiodo()) . ", "
                . " fechafinalfinancierosubperiodo = " . $this->db->qstr($this->subPeriodo->getFechafinalfinancierosubperiodo()) . ", "
                . " numerosubperiodo = " . $this->db->qstr($this->subPeriodo->getNumerosubperiodo()) . ", "
                . " idtiposubperiodo = " . $this->db->qstr($this->subPeriodo->getIdtiposubperiodo()) . ", "
                . " codigoestadosubperiodo = " . $this->db->qstr($this->subPeriodo->getCodigoestadosubperiodo()) . ", "
                . " idusuario = " . $this->db->qstr($this->subPeriodo->getIdusuario()) . ", "
                . " ip = " . $this->db->qstr($this->subPeriodo->getIp());

        if (!empty($where)) {
            $query .= " WHERE " . implode(" AND ", $where);
        }
        $rs = $this->db->Execute($query);

        if (empty($codigoperiodo)) {
            $this->subPeriodo->setIdsubperiodo($this->db->insert_Id());
        }

        $this->logAuditoria($this->subPeriodo, $query);
        if (!$rs) {
            return false;
        } else {
            return true;
        }
    }

    public function logAuditoria($e, $query) {
        require_once(PATH_SITE . "/entidadDAO/LogAuditoriaDAO.php");
        $idUsuario = \Factory::getSessionVar("idusuario");
        \Sala\entidadDAO\LogAuditoriaDAO::setLogAuditoria($e, $query, $idUsuario);
    }

}
