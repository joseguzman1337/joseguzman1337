<?php
namespace Sala\entidadDAO;

/**
 * @author Iqvn Quintero <quinteroivan@unbosque.edu.do>
 * @copyright Universidad el Bosque - Dirección de Tecnología
 * @package entidadDAO
 */
defined('_EXEC') or die;
class DetallePrematriculaDAO{
    /**
     * @type adodb Object
     * @access private
     */
    private $db;

    private $detalleprematricula;

    public function setDb() {
        $this->db = \Factory::createDbo();
    }

    public function __construct(\DetallePrematricula $detalleprematricula=null){
        $this->detalleprematricula = $detalleprematricula;
        $this->setDb();
    }

    public function logAuditoria($e, $query) {
        require_once(PATH_SITE."/entidadDAO/LogAuditoriaDAO.php");
        $idUsuario = \Factory::getSessionVar("idusuario");
        \Sala\entidadDAO\LogAuditoriaDAO::setLogAuditoria($e, $query, $idUsuario);
    }

    public function update($numeroorden, $estado, $idprematricula=null, $estadoactual= null, $materia=null, $id = null){
        if(!isset($estadoactual) || empty($estadoactual)){
            $estadoactual = "10";
        }
        if(isset($idprematricula) && !empty($idprematricula)){
            $sqlidprematricula = "AND idprematricula = '".$idprematricula."'";
        }else{
            $sqlidprematricula = "";
        }
        if(isset($id) && !empty($id)){
            $sqlid = " AND idDetallePrematricula = '".$id."'";
        }else{
            $sqlid = "";
        }

        if(isset($materia) && !empty($sqlmateria)){
            $sqlmateria = " AND codigomateria = $materia ";
        }else{
            $sqlmateria = "";
        }

        $query_detalleprematricula = "UPDATE detalleprematricula SET codigoestadodetalleprematricula = '".$estado."' " .
        " WHERE numeroordenpago = '".$numeroorden."' ".$sqlidprematricula." ".
        " and codigoestadodetalleprematricula = '".$estadoactual."' ".$sqlid." ".$sqlmateria;
        $detalleprematricula = $this->db->Execute($query_detalleprematricula);

        //pendiente creacion de insert en logdetalleprematricula

        return $detalleprematricula;
    }

}