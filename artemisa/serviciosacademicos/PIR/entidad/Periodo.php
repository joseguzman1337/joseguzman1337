<?php
/**
 * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package entidad
 */
class Periodo{
    /**
     * @type adodb Object
     * @access private
     */
    private $db; 
    
    /**
     * @type int
     * @access private
     */
    private $codigoPeriodo;
    
    /**
     * @type string
     * @access private
     */
    private $nombrePeriodo;
    
    /**
     * @type int
     * @access private
     */
    private $codigoEstadoPeriodo;
    
    /**
     * @type date
     * @access private
     */
    private $fechaInicioPeriodo;
    
    /**
     * @type date
     * @access private
     */
    private $fechaVencimientoPeriodo;
    
    /**
     * @type int
     * @access private
     */
    private $numeroPeriodo;
    
    public function Periodo($db) {
        $this->db = $db;
    }
    
    public function getCodigoPeriodo() {
        return $this->codigoPeriodo;
    }

    public function getNombrePeriodo() {
        return $this->nombrePeriodo;
    }

    public function getCodigoEstadoPeriodo() {
        return $this->codigoEstadoPeriodo;
    }

    public function getFechaInicioPeriodo() {
        return $this->fechaInicioPeriodo;
    }

    public function getFechaVencimientoPeriodo() {
        return $this->fechaVencimientoPeriodo;
    }

    public function getNumeroPeriodo() {
        return $this->numeroPeriodo;
    }
    
    public function setCodigoPeriodo($codigoPeriodo) {
        $this->codigoPeriodo = $codigoPeriodo;
    }

    public function setNombrePeriodo($nombrePeriodo) {
        $this->nombrePeriodo = $nombrePeriodo;
    }

    public function setCodigoEstadoPeriodo($codigoEstadoPeriodo) {
        $this->codigoEstadoPeriodo = $codigoEstadoPeriodo;
    }

    public function setFechaInicioPeriodo($fechaInicioPeriodo) {
        $this->fechaInicioPeriodo = $fechaInicioPeriodo;
    }

    public function setFechaVencimientoPeriodo($fechaVencimientoPeriodo) {
        $this->fechaVencimientoPeriodo = $fechaVencimientoPeriodo;
    }

    public function setNumeroPeriodo($numeroPeriodo) {
        $this->numeroPeriodo = $numeroPeriodo;
    }

    
    public function getPeriodosActivos(){
        $lista = array();
        
        $query = "SELECT * FROM periodo WHERE codigoestadoperiodo IN (1,4)";
        
        $datos = $this->db->Execute($query);
        
        while($p = $datos->FetchRow()){
            $Periodo = null;
            if(!empty($p)){
                $Periodo = new Periodo(null);
                $Periodo->setCodigoPeriodo($p['codigoperiodo']);
                $Periodo->setNombrePeriodo($p['nombreperiodo']);
                $Periodo->setCodigoEstadoPeriodo($p['codigoestadoperiodo']);
                $Periodo->setFechaInicioPeriodo($p['fechainicioperiodo']);
                $Periodo->setFechaVencimientoPeriodo($p['fechavencimientoperiodo']);
                $Periodo->setNumeroPeriodo($p['numeroperiodo']);
                $lista[] = $Periodo;
            }
        }
        
        return $lista;
    }

}