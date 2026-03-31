<?php

defined('_EXEC') or die;

class Pais implements Entidad{
    private $db;
    private $idpais;
    private $nombrepais;
    private $nombrecortopais;
    private $codigosappais;
    private $codigoestado;
    private $IdHecaa;
    private $CodPaisHecaa3;

    public function __construct(){

    }

    public function setDb(){
        $this->db = Factory::createDbo();
    }

    public function getById() {
        $this->getByCodigo();
    }

    public function getIdPais(){
        return $this->idpais;
    }

    public function setIdPais($idpais){
        $this->idpais = $idpais;
    }

    public function getNombrePais(){
        return $this->nombrepais;
    }

    public function setNombrePais($nombrepais){
        $this->nombrepais = $nombrepais;
    }

    public function getNombreCortoPais(){
        return $this->nombrecortopais;
    }

    public function setNombreCortoPais($nombrecortopais){
        $this->nombrecortopais = $nombrecortopais;
    }

    public function getCodigoSapPais(){
        return $this->codigosappais;
    }

    public function setCodigoSapPais($codigosappais){
        $this->codigosappais = $codigosappais;

    }

    public function getCodigoEstado(){
        return $this->codigoestado;
    }

    public function setCodigoEstado($codigoestado){
        $this->codigoestado = $codigoestado;
    }

    public function getIdHecaa(){
        return $this->IdHecaa;
    }

    public function setIdHecaa($IdHecaa){
        $this->IdHecaa = $IdHecaa;
    }

    public function getCodPaisHecaa3(){
        return $this->CodPaisHecaa3;
    }

    public function setCodPaisHecaa3($CodPaisHecaa3){
        $this->CodPaisHecaa3 = $CodPaisHecaa3;
    }

    public function getByCodigo(){
        if(!empty($this->idpais)){
            $query = "SELECT * FROM pais "
                ." WHERE idpais = ".$this->db->qstr($this->idpais);

            $datos = $this->db->Execute($query);
            $d = $datos->FetchRow();

            if(!empty($d)){
                $this->nombrecortopais = $d['nombrecortopais'];
                $this->nombrepais = $d['nombrepais'];
                $this->codigosappais = $d['codigosappais'];
                $this->codigoestado = $d['codigoestado'];
                $this->IdHecaa = $d['IdHecaa'];
                $this->CodPaisHecca3 = $d['CodPaisHecca3'];
            }
        }
    }

    public static function getList($where=null, $orderBy = null){
        $return = array();
        $db = Factory::createDbo();
        $query = "SELECT * FROM pais WHERE 1 ";
        if(!empty($where)){
            $query .= " AND ".$where;
        }
        if(!empty($orderBy)){
            $query .= " ORDER BY ".$orderBy;
        }
        $datos = $db->Execute($query);

        while( $d = $datos->FetchRow() ){
            $Pais = new Pais();
            $Pais->idpais = $d['idpais'];
            $Pais->nombrecortopais = $d['nombrecortopais'];
            $Pais->nombrepais = $d['nombrepais'];
            $Pais->codigosappais = $d['codigosappais'];
            $Pais->IdHecaa = $d['IdHecaa'];
            $Pais->codigoestado = $d['codigoestado'];
            $Pais->CodPaisHecca3 = $d['CodPaisHecca3'];
            $return[] = $Pais;
            unset($Pais);
        }

        return $return;
    }
}