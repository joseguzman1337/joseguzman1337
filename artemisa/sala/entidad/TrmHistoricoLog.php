<?php
/**
 * @author Leonardo Rubio (M/OO) <rubioleonardo@unbosque.edu.do>
 * @copyright Universidad el Bosque - Dirección de Tecnología
 * @package entidad
 *
 */
defined('_EXEC') or die;
class TrmHistoricoLog implements Entidad
{
    private $db;
    private $idTrmHistoricoLog;
    private $idTrmHistorico;
    private $fechaCreacionLog;
    private $dia;
    private $novedad;
    private $tipoTrm;
    private $tipoMoneda;
    private $valorTrm;
    private $vigenciaTrmDesde;
    private $vigenciaTrmHasta;
    private $codigoestadoTrmLog;
    private $usuario;
    private $ip;

    public function __construct($idTrmHistorico)
    {
        $this->setDb();
        $this->idTrmHistoricoLog = "";
        $this->idTrmHistorico = $idTrmHistorico;
        $this->setParametersSchedule();
    }
    public function getDb()
    {
        return $this->db;
    }
    public function setParametersSchedule()
    {
        $query = "select * from trmhistorico where idtrmhistorico = ".$this->idTrmHistorico;
        $dataTrmHistorico = $this->db->Execute($query);
        $this->dataTrmHistorico = $dataTrmHistorico->FetchRow();

        $this->idTrmHistorico   = $this->dataTrmHistorico['idtrmhistorico'];
        $this->fechaCreacion    = $this->dataTrmHistorico['fechacreacion'];
        $this->dia              = $this->dataTrmHistorico['dia'];
        $this->novedad          = $this->dataTrmHistorico['novedad'];
        $this->tipoTrm          = $this->dataTrmHistorico['tipotrm'];
        $this->tipoMoneda       = $this->dataTrmHistorico['tipomoneda'];
        $this->valorTrm         = $this->dataTrmHistorico['valortrm'];
        $this->vigenciaTrmDesde = $this->dataTrmHistorico['vigenciatrmdesde'];
        $this->vigenciaTrmHasta = $this->dataTrmHistorico['vigenciatrmhasta'];
        $this->fechaCreacionLog = date('Y-m-d h:m:s');
        $this->idUsuario        = $_SESSION['idusuario'];
        $this->ip               = $_SERVER['REMOTE_ADDR'];

    }
    public function getDataTrmHistorico()
    {
        return $this->dataTrmHistorico;
    }

    public function setDb()
    {
        $this->db = Factory::createDbo();
    }

    public function getIdTrmHistoricoLog()
    {
        return $this->idTrmHistoricoLog;
    }
    public function setIdTrmHistoricoLog($idTrmHistoricoLog)
    {
        $this->idTrmHistoricoLog = $idTrmHistoricoLog;
    }
    public function getIdTrmHistorico()
    {
        return $this->idTrmHistorico;
    }
    public function setIdTrmHistorico($idTrmHistorico)
    {
        $this->idTrmHistorico = $idTrmHistorico;
    }
    public function getFechaCreacionLog()
    {
        return $this->fechaCreacionLog;
    }
    public function setFechaCreacionLog($fechaCreacionLog)
    {
        $this->fechaCreacionLog = $fechaCreacionLog;
    }

    public function getDia()
    {
        return $this->dia;
    }
    public function setDia($dia)
    {
        $this->dia = $dia;
    }
    public function getNovedad()
    {
        return $this->novedad;
    }
    public function setNovedad($novedad)
    {
        $this->novedad = $novedad;
    }
    public function getTipoTrm()
    {
        return $this->tipoTrm;
    }
    public function setTipoTrm($tipoTrm)
    {
        $this->tipoTrm = $tipoTrm;
    }
    public function getTipoMoneda()
    {
        return $this->tipoMoneda;
    }

    public function setTipoMoneda($tipoMoneda)
    {
        $this->tipoMoneda = $tipoMoneda;
    }
    public function getValorTrm()
    {
        return $this->valorTrm;
    }
    public function setValorTrm($ValorTrm)
    {
        $this->valorTrm = $ValorTrm;
    }
    public function getVigenciaTrmDesde()
    {
        return $this->vigenciaTrmDesde;
    }
    public function setVigenciaTrmDesde($vigenciaTrmDesde)
    {
        $this->vigenciaTrmDesde = $vigenciaTrmDesde;
    }
    public function getVigenciaTrmHasta()
    {
        return $this->vigenciaTrmHasta;
    }
    public function setVigenciaTrmHasta($vigenciaTrmHasta)
    {
        $this->vigenciaTrmDesde = $vigenciaTrmHasta;
    }

    public function getCodigoEstadoTrmLog()
    {
        return $this->codigoestadoTrmLog;
    }

    public function setCodigoEstadoTrmLog($codigoEstadoTrmLog)
    {
        $this->codigoestadoTrmLog = $codigoEstadoTrmLog;
    }
    public function getUsuario()
    {
        return $this->usuario;
    }
    public function setUsuario($usuario)
    {
        $this->usuario = $usuario;
    }
    public function getIp()
    {
        return $this->ip;
    }
    public function setIp($ip)
    {
        $this->ip = $ip;
    }
    public function getById()
    {
        if (!is_null($this->idTrmHistoricoLog)) {
            $query = "SELECT * FROM trmhistoricolog "
                . "WHERE idtrmhistoricolog = " . $this->db->qstr($this->idTrmHistoricoLog);
            $datos = $this->db->Execute($query);
            $d = $datos->FetchRow();
            if (!empty($d)) {
                $this->idTrmHistoricoLog = $d['idtrmhistoricolog'];
                $this->idTrmHistorico    = $d['idtrmhistorico'];
                $this->fechaCreacionLog  = $d['fechacreacionlog'];
                $this->dia               = $d['dia'];
                $this->novedad           = $d['novedad'];
                $this->tipoTrm           = $d['tipotrm'];
                $this->tipoMoneda        = $d['tipomoneda'];
                $this->valorTrm          = $d['valortrm'];
                $this->vigenciaTrmdesde  = $d['vigenciatrmdesde'];
                $this->vigenciaTrmhasta  = $d['vigenciatrmhasta'];
                $this->codigoEstado      = $d['codigoestado'];
                $this->usuario           = $d['usuario'];
                $this->ip                = $d['ip'];
            }
        }
    }
    public static function getList($where = null, $orderBy = null)
    {
        $return = array();
        $db = Factory::createDbo();
        $query = "SELECT * FROM trmhistoricolog "
            . " WHERE 1 ";
        if (!empty($where)) {
            $query .= " AND " . $where;
        }
        if (!empty($orderBy)) {
            $query .= " ORDER BY " . $orderBy;
        }
        $datos = $db->Execute($query);

        while ($d = $datos->FetchRow()) {
            $trmHistoricoLog = new TrmHistoricoLog($d['idtrmhistorico']);
            $trmHistoricoLog->idtrmhistoricolog = $d['idtrmhistoricolog'];
            $trmHistoricoLog->idtrmhistorico    = $d['idtrmhistorico'];
            $trmHistoricoLog->fechacreacionlog  = $d['fechacreacionlog'];
            $trmHistoricoLog->dia               = $d['dia'];
            $trmHistoricoLog->novedad           = $d['novedad'];
            $trmHistoricoLog->tipotrm           = $d['tipotrm'];
            $trmHistoricoLog->tipomoneda        = $d['tipomoneda'];
            $trmHistoricoLog->valortrm          = $d['valortrm'];
            $trmHistoricoLog->vigenciatrmdesde  = $d['vigenciatrmdesde'];
            $trmHistoricoLog->vigenciatrmhasta  = $d['vigenciatrmhasta'];
            $trmHistoricoLog->codigoestado      = $d['codigoestado'];
            $trmHistoricoLog->usuario           = $d['usuario'];
            $trmHistoricoLog->ip                = $d['ip'];
            $return[] = $trmHistoricoLog;
            unset($trmHistoricoLog);
        }
        return $return;
    }
}

