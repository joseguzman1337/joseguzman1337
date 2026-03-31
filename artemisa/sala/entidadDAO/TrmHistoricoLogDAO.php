<?php

namespace Sala\entidadDAO;
defined('_EXEC') or die;
class TrmHistoricoLogDAO

{
    /**
     * @type adodb Object
     * @access private
     */
    private $db;
    private $trmHistoricoLogEntity;

    public function __construct(\TrmHistoricoLog $trmHistoricoLog){
        $this->setDb();
        $this->trmHistoricoLogEntity = $trmHistoricoLog;
    }

    public function setDb(){
        $this->db = \Factory::createDbo();
    }
    public function save(){
        $idUsuario=0;
        $query = "";
        $where = array();
        $idTrmhistoricoLog = $this->trmHistoricoLogEntity->getIdTrmHistoricoLog();
        if(empty($idTrmhistoricoLog)){
            $query .= "INSERT INTO ";
        }

        $query .= "trmhistoricolog SET "
            . " idtrmhistorico = ".$this->trmHistoricoLogEntity->getIdTrmHistorico().", "
            . " fechacreacionlog = '".date('Y-m-d :H:i:s')."', "
            . " dia = ".$this->trmHistoricoLogEntity->getDia().", "
            . " novedad = '".$this->trmHistoricoLogEntity->getNovedad()."', "
            . " tipotrm = '".$this->trmHistoricoLogEntity->getTipoTrm()."', "
            . " tipomoneda = ".$this->trmHistoricoLogEntity->getTipoMoneda().", "
            . " valortrm = ".$this->trmHistoricoLogEntity->getValorTrm().", "
            . " vigenciatrmdesde = '".$this->trmHistoricoLogEntity->getVigenciaTrmDesde()."', "
            . " vigenciatrmhasta = '".$this->trmHistoricoLogEntity->getVigenciaTrmHasta()."', "
            . " usuario = '".$idUsuario."', "
            . " ip = '".$this->trmHistoricoLogEntity->getIp()."'";
        $rs = $this->db->Execute($query);
        if(empty($idGrupo)){
            $this->trmHistoricoLogEntity->setIdtrmHistorico($this->db->insert_Id());
        }
        if(!$rs){
            return false;
        }
        return true;
    }
}