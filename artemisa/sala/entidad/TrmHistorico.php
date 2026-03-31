<?php
/**
 * @author Leonardo Rubio <rubioleonardo@unbosque.edu.do>
 * @copyright Universidad el Bosque - Dirección de Tecnología
 * @package entidad
 */
defined('_EXEC') or die;
class TrmHistorico implements Entidad{

    private $db;
    private $idTrmHistorico;
    private $fechaCreacion;
    private $dia;
    private $novedad;
    private $tipoTrm;
    private $tipoMoneda;
    private $valorTrm;
    private $vigenciaDesde;
    private $vigenciaHasta;
    private $codigoEstado;


    public function setDb()
    {
        $this->db = Factory::createDbo();
    }
    public function __construct(){
    }

    public function getIdTrmHistorico() {
        return $this->idTrmHistorico;
    }
    public function setIdTrmHistorico($idtrmhistorico) {
        $this->idTrmHistorico = $idtrmhistorico;
    }
    public function getFechaCreacion() {
        return $this->fechaCreacion;
    }
    public function setFechaCreacion($fechacreacion) {
        return $this->fechaCreacion = $fechacreacion;
    }

    public function getDia() {
        return $this->dia;
    }

    public function setDia($dia) {
        return $this->dia = $dia ;
    }

    public function getNovedad() {
        return $this->novedad;
    }
    public function setNovedad($novedad) {
        return $this->novedad = $novedad;
    }
    public function getTipoTrm() {
        return $this->tipoTrm;
    }
    public function setTipoTrm($tipotrm) {
        return $this->tipoTrm = $tipotrm;
    }

    public function getTipoMoneda() {
        return $this->tipoMoneda;
    }
    public function setTipomoneda($tipomoneda) {
        return $this->tipoMoneda = $tipomoneda;
    }
    public function getValorTrm() {
        return $this->valorTrm;
    }

    public function setValorTrm($valortrm) {
        return $this->valorTrm = $valortrm;
    }

    public function getVigenciaDesde() {
        return $this->vigenciaDesde;
    }

    public function setVigenciaDesde($vigenciadesde) {
        return $this->vigenciaDesde = $vigenciadesde;
    }

    public function getVigenciaHasta() {
        return $this->vigenciaHasta;
    }

    public function setVigenciaHasta($vigenciahasta) {
        return $this->vigenciaHasta = $vigenciahasta;
    }
    public function getCodigoEstado() {
        return $this->codigoEstado;
    }
    public function setCodigoEstado($codigoestado) {
        return $this->codigoEstado = $codigoestado;
    }

    public function getById()
    {
        if(!empty($this->idtrmhistorico)){
            $query = "SELECT * FROM trmhistorico  WHERE idtrmhistorico = ".$this->db->qstr($this->idtrmhistorico);
            $datos = $this->db->Execute($query);
            $d = $datos->FetchRow();

            if(!empty($d)){
                $this->fechaCreacion    = $d['fechacreacion'];
                $this->dia              = $d['dia'];
                $this->novedad          = $d['novedad'];
                $this->tipoTrm          = $d['tipotrm'];
                $this->tipoMoneda       = $d['tipomoneda'];
                $this->valorTrm         = $d['valortrm'];
                $this->vigenciaDesde    = $d['vigenciatrmdesde'];
                $this->vigenciaHasta    = $d['vigenciatrmdesde'];
                $this->codigoEstado     = $d['codigoestado'];

            }
        }
    }
    public static function getList($where=null,$orderBy=null)
    {
        $db = Factory::createDbo();

        $return = array();

        $query = "SELECT * "
            . " FROM trmhistorico "
            . " WHERE 1";

        if(!empty($where)){
            $query .= " AND ".$where;
        }
        if (!empty($orderBy)) {
            $query .= " ORDER BY " . $orderBy;
        }

        $datos = $db->Execute($query);
        while($d = $datos->FetchRow()){
            $Trmhistorico = new TrmHistorico();
            $Trmhistorico->setIdTrmHistorico($d['idtrmhistorico']);
            $Trmhistorico->setFechaCreacion($d['fechacreacion']);
            $Trmhistorico->setDia($d['dia']);
            $Trmhistorico->setNovedad($d['novedad']);
            $Trmhistorico->setTipoTrm($d['tipotrm']);
            $Trmhistorico->setTipoMoneda($d['tipomoneda']);
            $Trmhistorico->setValorTrm($d['valortrm']);
            $Trmhistorico->setVigenciaDesde($d['vigenciatrmdesde']);
            $Trmhistorico->setVigenciaHasta($d['vigenciatrmhasta']);
            $Trmhistorico->setCodigoEstado($d['codigoestado']);
            $return[] = $Trmhistorico;
            unset($Trmhistorico);
        }
        return $return;
    }
}
