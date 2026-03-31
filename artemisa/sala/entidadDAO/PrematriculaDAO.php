<?php
namespace Sala\entidadDAO;

/**
 * @author Iqvn Quintero <quinteroivan@unbosque.edu.do>
 * @copyright Universidad el Bosque - Dirección de Tecnología
 * @package entidadDAO
 */
defined('_EXEC') or die;
class PrematriculaDAO {
    /**
     * @type adodb Object
     * @access private
     */
    private $db;

    private $prematricula;

    public function setDb() {
        $this->db = \Factory::createDbo();
    }

    public function __construct(\Prematricula $prematricula=null){
        $this->prematricula = $prematricula;
        $this->setDb();
    }

    public function logAuditoria($e, $query) {
        require_once(PATH_SITE."/entidadDAO/LogAuditoriaDAO.php");
        $idUsuario = \Factory::getSessionVar("idusuario");
        \Sala\entidadDAO\LogAuditoriaDAO::setLogAuditoria($e, $query, $idUsuario);
    }

    public function update($idprematricula, $estado){
        $updateprematricula = "update prematricula set codigoestadoprematricula = '".$estado."' ".
        " where idprematricula = '".$idprematricula."'";
        $idprematricula = $this->db->Execute($updateprematricula);
        return $idprematricula;
    }

}