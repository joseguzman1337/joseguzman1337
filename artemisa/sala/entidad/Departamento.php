<?php

defined('_EXEC') or die;

class Departamento implements Entidad {

    private $db;
    private $iddepartamento;
    private $nombrecortodepartamento;
    private $nombredepartamento;
    private $idpais;
    private $codigosapdepartamento;
    private $codigoestado;
    private $idregionnatural;

    public function __construct(){
    }

    public function setDb(){
        $this->db = Factory::createDbo();
    }

    public function setIdDepartamento($iddepartamento) {
        $this->iddepartamento = $iddepartamento;
    }

    public function getNombreCortoDepartamento() {
        return $this->nombrecortodepartamento;
    }

    public function getNombreDepartamento() {
        return $this->nombredepartamento;
    }

    public function getIdPais() {
        return $this->idpais;
    }

    public function getIdDepartamento() {
        return $this->iddepartamento;
    }

    public function getCodigoSapDepartamento() {
        return $this->codigosapdepartamento;
    }

    public function getIdRegionNatural() {
        return $this->idregionnatural;
    }

    public function setNombreCortoDepartamento($nombrecortodepartamento) {
        $this->nombrecortodepartamento = $nombrecortodepartamento;
    }

    public function setNombreDepartamento($nombredepartamento) {
        $this->nombredepartamento = $nombredepartamento;
    }

    public function setIdPais($idpais) {
        $this->idpais = $idpais;
    }

    public function setCodigoEstado($codigoestado) {
        $this->codigoestado = $codigoestado;
    }

    public function setCodigoSapDepartamento($codigosapdepartamento) {
        $this->codigosapdepartamento = $codigosapdepartamento;
    }

    public function setIdRegionNatural($idregionnatural) {
        $this->idregionnatural = $idregionnatural;
    }

    public function getById($where=null){
        if(!empty($this->iddepartamento)){
            $query = "SELECT * FROM departamento "
                ." WHERE iddepartamento = ".$this->db->qstr($this->iddepartamento);
            if(!empty($where)){
                $query .= " AND ".$where;
            }
            $datos = $this->db->Execute($query);
            $d = $datos->FetchRow();

            if(!empty($d)){
                $this->nombrecortodepartamento = $d['nombrecortodepartamento'];
                $this->nombredepartamento = $d['nombredepartamento'];
                $this->idpais = $d['idpais'];
                $this->codigosapdepartamento = $d['codigosapdepartamento'];
                $this->idregionnatural = $d['idregionnatural'];
                $this->codigoestado = $d['codigoestado'];
            }
        }
    }

    public static function getList($where=null, $orderBy = null){
        $return = array();
        $db = Factory::createDbo();
        $query = "SELECT * FROM departamento WHERE 1 ";
        if(!empty($where)){
            $query .= " AND ".$where;
        }
        if(!empty($orderBy)){
            $query .= " ORDER BY ".$orderBy;
        }
        $datos = $db->Execute($query);

        while( $d = $datos->FetchRow() ){
            $Departamento = new Departamento();
            $Departamento->iddepartamento = $d['iddepartamento'];
            $Departamento->nombrecortodepartamento = $d['nombrecortodepartamento'];
            $Departamento->nombredepartamento = $d['nombredepartamento'];
            $Departamento->idpais = $d['idpais'];
            $Departamento->codigosapdepartamento = $d['codigosapdepartamento'];
            $Departamento->codigoestado = $d['codigoestado'];
            $Departamento->idregionnatural = $d['idregionnatural'];
            $return[] = $Departamento;
            unset($Departamento);
        }

        return $return;
    }
}