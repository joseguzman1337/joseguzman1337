<?php

defined('_EXEC') or die;

class Ciudad implements Entidad {

    private $db;
    private $idciudad;
    private $nombrecortociudad;
    private $nombreciudad;
    private $iddepartamento;
    private $codigosapciudad;
    private $codigoestado;

    public function __construct(){
    }

    public function setDb(){
        $this->db = Factory::createDbo();
    }

    public function getById() {
        $this->getByCodigo();
    }

    public function getIdCiudad() {
        return $this->idciudad;
    }

    public function getNombreCortoCiudad() {
        return $this->nombrecortociudad;
    }

    public function getNombreCiudad() {
        return $this->nombreciudad;
    }

    public function getIdDepartamento() {
        return $this->iddepartamento;
    }

    public function getCodigoSapCiudad() {
        return $this->codigosapciudad;
    }

    public function setIdCiudad($idciudad) {
        $this->idciudad = $idciudad;
    }

    public function setNombreCortoCiudad($nombrecortociudad) {
        $this->nombrecortociudad = $nombrecortociudad;
    }

    public function setNombreCiudad($nombreciudad) {
        $this->nombreciudad = $nombreciudad;
    }

    public function setIdDepartamento($iddepartamento) {
        $this->iddepartamento = $iddepartamento;
    }

    public function setCodigoSapCiudad($codigosapciudad) {
        $this->codigosapciudad = $codigosapciudad;
    }

    public function setCodigoEstado($codigoestado) {
        $this->codigoestado = $codigoestado;
    }


    public function getByCodigo(){
        if(!empty($this->idciudad)){
            $query = "SELECT * FROM ciudad "
                ." WHERE idciudad = ".$this->db->qstr($this->idciudad);

            $datos = $this->db->Execute($query);
            $d = $datos->FetchRow();

            if(!empty($d)){
                $this->nombrecortociudad = $d['nombrecortociudad'];
                $this->nombreciudad = $d['nombreciudad'];
                $this->iddepartamento = $d['iddepartamento'];
                $this->codigosapciudad = $d['codigosapciudad'];
                $this->codigoestado = $d['codigoestado'];
            }
        }
    }

    public static function getList($where=null, $orderBy = null){
        $return = array();
        $db = Factory::createDbo();
        $query = "SELECT * FROM ciudad WHERE 1 ";
        if(!empty($where)){
            $query .= " AND ".$where;
        }
        if(!empty($orderBy)){
            $query .= " ORDER BY ".$orderBy;
        }
        $datos = $db->Execute($query);

        while( $d = $datos->FetchRow() ){
            $Ciudad = new Ciudad();
            $Ciudad->idciudad = $d['idciudad'];
            $Ciudad->nombrecortociudad = $d['nombrecortociudad'];
            $Ciudad->nombreciudad = $d['nombreciudad'];
            $Ciudad->iddepartamento = $d['iddepartamento'];
            $Ciudad->codigosapciudad = $d['codigosapciudad'];
            $Ciudad->codigoestado = $d['codigoestado'];
            $return[] = $Ciudad;
            unset($Ciudad);
        }

        return $return;
    }
}