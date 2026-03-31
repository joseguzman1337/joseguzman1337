<?php
namespace Sala\entidadDAO;
defined('_EXEC') or die;
class TrmHistoricoDAO
{
    /**
     * @type adodb Object
     * @access private
     */
    private $db;
    private $trmhistorico;

    public function __construct(\TrmHistorico $trmhistorico){
        $this->setDb();
        $this->trmhistorico = $trmhistorico;
    }

    public function setDb(){
        $this->db = \Factory::createDbo();
    }

    public function save(){
        $query = "";
        $where = array();
        $idTrmhistorico = $this->trmhistorico->getIdtrmhistorico();
        if(empty($idTrmhistorico)){
            $query .= "INSERT INTO ";
        }else{
            $query .= "UPDATE ";
            $where[] = " idtrmhistorico = ".$this->db->qstr($this->trmhistorico->getIdtrmhistorico());
        }

        $query .= "trmhistorico SET "
            . " fechacreacion = ".$this->db->qstr($this->trmhistorico->getFechaCreacion()).", "
            . " dia = ".$this->db->qstr($this->trmhistorico->getDia()).", "
            . " novedad = ".$this->db->qstr($this->trmhistorico->getNovedad()).", "
            . " tipotrm = ".$this->db->qstr($this->trmhistorico->getTipoTrm()).", "
            . " tipomoneda = ".$this->db->qstr($this->trmhistorico->getTipoMoneda()).", "
            . " valortrm = ".$this->db->qstr($this->trmhistorico->getValorTrm()).", "
            . " vigenciatrmdesde = ".$this->db->qstr($this->trmhistorico->getVigenciaDesde()).", "
            . " vigenciatrmhasta = ".$this->db->qstr($this->trmhistorico->getVigenciaHasta()).", "
            . " codigoestado = ".$this->db->qstr($this->trmhistorico->getCodigoEstado())."";

        if(!empty($where)){
            $query .= " WHERE ".implode(" AND ",$where);
        }
        $rs = $this->db->Execute($query);
        if(empty($idTrmhistorico)){
            $this->trmhistorico->setIdtrmHistorico($this->db->insert_Id());
            $this->logTrmHistoricoDAO($this->db->insert_Id());
        }else{
            $this->logTrmHistoricoDAO($idTrmhistorico);
        }

        if(!$rs){
            return false;
        }
        return true;
    }
    public function logTrmHistoricoDAO($idTrmHistorico){
        require_once(PATH_SITE."/entidad/TrmHistoricoLog.php");
        $logTrmHistoricoObject = new \TrmHistoricoLog($idTrmHistorico);
        require_once(PATH_SITE."/entidadDAO/TrmHistoricoLogDAO.php");
        $logTrmHistoricoDAO = new TrmHistoricoLogDAO($logTrmHistoricoObject);
        $logTrmHistoricoDAO->save();
    }
}