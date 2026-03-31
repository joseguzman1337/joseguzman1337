<?php
/**
 * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package entidad
 */
class TipoPruebaEstado{
    
    /**
     * @type adodb Object
     * @access private
     */
    private $db;  
    
    /**
     * @type int
     * @access private
     */
    private $idTipoPruebaEstado;
    
    /**
     * @type String
     * @access private
     */
    private $nombreEstructura;
    
    /**
     * @type int
     * @access private
     */
    private $codigoPeriodoMIN;
    
    function TipoPruebaEstado($db) {
        $this->db = $db;
    }
    function getIdTipoPruebaEstado() {
        return $this->idTipoPruebaEstado;
    }

    function getNombreEstructura() {
        return $this->nombreEstructura;
    }

    function setCodigoPeriodoMIN($codigoPeriodoMIN) {
        $this->codigoPeriodoMIN = $codigoPeriodoMIN;
    }
    function getCodigoPeriodoMIN() {
        return $this->codigoPeriodoMIN;
    } 

    
        
    public function consultarEstructuraPorPeriodo(){
        $query = "SELECT tpe.id as idTipoPruebaEstado, tpe.nombre as nombreTipoPruebaEstado 
            FROM TipoPruebaEstado tpe
            INNER JOIN estructuraPeriodoPruebaEstado eppe ON (eppe.idEstructuraPruebaEstado = tpe.id) 
            WHERE eppe.codigoPeriodoMIN = '".$this->codigoPeriodoMIN."' AND tpe.codigoEstado = 1 ";
        //d($query);
        $estructuras = $this->db->Execute($query);
        $row_estructura = $estructuras->FetchRow();
        if(!empty($row_estructura)){
            $this->idTipoPruebaEstado = $row_estructura['idTipoPruebaEstado'];
            $this->nombreEstructura = $row_estructura['nombreTipoPruebaEstado']; 
        }
    }

}
