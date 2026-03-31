<?php

/**
 * @author Diego Rivera<riveradiego@unbosque.edu.co>
 * @copyright Universidad el Bosque - Dirección de Tecnología
 * @package entidad 
 */
defined('_EXEC') or die;

class CobroMatricula {

    private $db;
    private $codigoPeriodo;
    private $porcentajeCreditosDesde;
    private $porcentajeCreditosHasta;
    private $porcentajeCobroMatricula;
    
    private $codigoPeriodoN;
    private $porcentajeCreditosDesdeN;
    private $porcentajeCreditosHastaN;
    private $porcentajeCobroMatriculaN;
    
    
    private $identificador;
    public function __construct() {
        
    }

    public function setDb() {
        $this->db = Factory::createDbo();
    }

    public function getCodigoPeriodo() {
        return $this->codigoPeriodo;
    }

    public function getPorcentajeCreditosDesde() {
        return $this->porcentajeCreditosDesde;
    }

    public function getPorcentajeCreditosHasta() {
        return $this->porcentajeCreditosHasta;
    }

    public function getPorcentajeCobroMatricula() {
        return $this->porcentajeCobroMatricula;
    }

    public function setCodigoPeriodo($codigoPeriodo) {
        $this->codigoPeriodo = $codigoPeriodo;
    }

    public function setPorcentajeCreditosDesde($porcentajeCreditosDesde) {
        $this->porcentajeCreditosDesde = $porcentajeCreditosDesde;
    }

    public function setPorcentajeCreditosHasta($porcentajeCreditosHasta) {
        $this->porcentajeCreditosHasta = $porcentajeCreditosHasta;
    }

    public function setPorcentajeCobroMatricula($porcentajeCobroMatricula) {
        $this->porcentajeCobroMatricula = $porcentajeCobroMatricula;
    }
    
    public function getIdentificador() {
        return $this->identificador;
    }

    public function setIdentificador($identificador) {
        $this->identificador = $identificador;
    }
    
    public function getCodigoPeriodoN() {
        return $this->codigoPeriodoN;
    }

    public function getPorcentajeCreditosDesdeN() {
        return $this->porcentajeCreditosDesdeN;
    }

    public function getPorcentajeCreditosHastaN() {
        return $this->porcentajeCreditosHastaN;
    }

    public function getPorcentajeCobroMatriculaN() {
        return $this->porcentajeCobroMatriculaN;
    }

    public function setCodigoPeriodoN($codigoPeriodoN) {
        $this->codigoPeriodoN = $codigoPeriodoN;
    }

    public function setPorcentajeCreditosDesdeN($porcentajeCreditosDesdeN) {
        $this->porcentajeCreditosDesdeN = $porcentajeCreditosDesdeN;
    }

    public function setPorcentajeCreditosHastaN($porcentajeCreditosHastaN) {
        $this->porcentajeCreditosHastaN = $porcentajeCreditosHastaN;
    }

    public function setPorcentajeCobroMatriculaN($porcentajeCobroMatriculaN) {
        $this->porcentajeCobroMatriculaN = $porcentajeCobroMatriculaN;
    }

    
        public function getById() {
        if (!empty($this->lugarRotacionCarreraId)) {
            $query = "SELECT * "
                    . "FROM cobromatricula "
                    . "WHERE codigoperiodo = " . $this->db->qstr($this->codigoPeriodo);

            $datos = $this->db->Execute($query);
            $d = $datos->FetchRow();

            if (!empty($d)) {
                $this->codigoPeriodo= $d['codigoperiodo'];
                $this->porcentajeCreditosDesde = $d['porcentajecreditosdesde'];
                $this->porcentajeCreditosHasta = $d['porcentajecreditoshasta'];
                $this->porcentajeCobroMatricula = $d['porcentajecobromatricula'];
            }
        }
    }

    public static function getList($where = null) {
        $db = Factory::createDbo();
        $return = array();
        $query = "SELECT * "
                . "FROM cobromatricula "
                . "WHERE 1 ";

        if (!empty($where)) {
            $query .= " AND " . $where;
        }

        $datos = $db->Execute($query);
        while ($d = $datos->FetchRow()) {
            $cobroMatricula = new CobroMatricula();
            $cobroMatricula->setCodigoPeriodo($d['codigoperiodo']);
            $cobroMatricula->setPorcentajeCreditosDesde($d['porcentajecreditosdesde']);
            $cobroMatricula->setPorcentajeCreditosHasta($d['porcentajecreditoshasta']);
            $cobroMatricula->setPorcentajeCobroMatricula($d['porcentajecobromatricula']);
            $return[] = $cobroMatricula;
            unset($cobroMatricula);
        }
        return $return;
    }

}
