<?php
class TipoMoneda implements Entidad {
    private $db;
    private $idTipoMoneda;
    private $nombreMoneda;
    private $siglas;
    private $codigoEstado;
    private $fechaRegistro;

    public function setDb()
    {
        $this->db = Factory::createDbo();
    }

    public function getIdTipoMoneda(){
        return $this->idTipoMoneda;
    }
    public function setIdTipoMoneda($idtipomoneda){
        return $this->idTipoMoneda = $idtipomoneda;
    }
    public function getNombreMoneda(){
        return $this->nombreMoneda;
    }
    public function setNombreMoneda($nombremoneda){
        return $this->nombreMoneda = $nombremoneda;
    }
    public function getSiglas(){
        return $this->siglas;
    }
    public function setSiglas($siglas){
        return $this->siglas = $siglas;
    }
    public function getFechaRegistro(){
        return $this->fechaRegistro;
    }
    public function setFechaRegistro($fecharegistro){
        return $this->fechaRegistro = $fecharegistro;
    }
    public function getCodigoEstado(){
        return $this->codigoEstado;
    }
    public function setCodigoEstado($codestado){
        return $this->codigoEstado = $codestado;
    }

    public function getById()
    {
        if(!empty($this->idTipoMoneda)){
            $query = "SELECT * FROM tipomoneda  WHERE id = ".$this->db->qstr($this->idTipoMoneda);
            $datos = $this->db->Execute($query);
            $d = $datos->FetchRow();
            if(!empty($d)){
                $this->nombreMoneda    = $d['fechacreacion'];
                $this->siglas              = $d['dia'];
                $this->codigoEstado          = $d['novedad'];
            }
        }
    }

    public static function getList($where=null,$orderBy=null)
    {
        $db = Factory::createDbo();
        $return = array();
        $query = "SELECT * "
            . " FROM tipomoneda "
            . " WHERE 1";
        if(!empty($where)){
            $query .= " AND ".$where;
        }
        if (!empty($orderBy)) {
            $query .= " ORDER BY " . $orderBy;
        }
        $datos = $db->Execute($query);
        while($d = $datos->FetchRow()){
            $Tipomoneda = new TipoMoneda();
            $Tipomoneda->setIdTipoMoneda($d['id']);
            $Tipomoneda->setNombreMoneda($d['nombremoneda']);
            $Tipomoneda->setSiglas($d['siglas']);
            $Tipomoneda->setCodigoEstado($d['codigoestado']);
            $Tipomoneda->setFechaRegistro($d['fecharegistro']);
            $return[] = $Tipomoneda;
            unset($Tipomoneda);
        }
        return $return;
    }
}