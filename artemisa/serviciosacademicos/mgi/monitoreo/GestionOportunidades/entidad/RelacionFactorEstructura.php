<?php
/**
 * @author Andres Ariza <arizaandres@unbosque.edu.do>
 * @copyright Universidad el Bosque - Dirección de Tecnología
 * @package entidad
*/
defined('_EXEC') or die;
class RelacionFactorEstructura implements Entidad{
    /**
     * @var adodb Object
     * @access private
     */
    private $db;
    
    /**
     * @var int
     * @access private
     */
    private $idsiq_factoresestructuradocumento;
    
    /**
     * @var int
     * @access private
     */
    private $idsiq_estructuradocumento;
    
    /**
     * @var int
     * @access private
     */
    private $factor_id;
    
    /**
     * @var String
     * @access private
     */
    private $codigo;
    
    /**
     * @var String
     * @access private
     */
    private $nombre;
    
    /**
     * @var String
     * @access private
     */
    private $descripcion;
    
    /**
     * @var String
     * @access private
     */
    private $nombre_entidad;
    
    /**
     * @var String
     * @access private
     */
    private $nombre_documento;
    
    /**
     * @var String
     * @access private
     */
    private static $queryRelacional = "SELECT  fed.idsiq_factoresestructuradocumento, fed.idsiq_estructuradocumento,  fed.factor_id, f.codigo, f.nombre, f.descripcion, ed.nombre_entidad, ed.nombre_documento FROM siq_factoresestructuradocumento fed INNER JOIN siq_factor f ON (f.idsiq_factor = fed.factor_id)  INNER JOIN siq_estructuradocumento ed ON (ed.idsiq_estructuradocumento = fed.idsiq_estructuradocumento) ";
    
    
    public function RelacionFactorEstructura(){
    }
    
    public function setDb(){
        $this->db = Factory::createDbo();
    }
    
    function getIdsiq_factoresestructuradocumento() {
        return $this->idsiq_factoresestructuradocumento;
    }

    function getIdsiq_estructuradocumento() {
        return $this->idsiq_estructuradocumento;
    }

    function getFactor_id() {
        return $this->factor_id;
    }

    function getCodigo() {
        return $this->codigo;
    }

    function getNombre() {
        return $this->nombre;
    }

    function getDescripcion() {
        return $this->descripcion;
    }

    function getNombre_entidad() {
        return $this->nombre_entidad;
    }

    function getNombre_documento() {
        return $this->nombre_documento;
    }

    function setIdsiq_factoresestructuradocumento($idsiq_factoresestructuradocumento) {
        $this->idsiq_factoresestructuradocumento = $idsiq_factoresestructuradocumento;
    }

    function setIdsiq_estructuradocumento($idsiq_estructuradocumento) {
        $this->idsiq_estructuradocumento = $idsiq_estructuradocumento;
    }

    function setFactor_id($factor_id) {
        $this->factor_id = $factor_id;
    }

    function setCodigo($codigo) {
        $this->codigo = $codigo;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    function setNombre_entidad($nombre_entidad) {
        $this->nombre_entidad = $nombre_entidad;
    }

    function setNombre_documento($nombre_documento) {
        $this->nombre_documento = $nombre_documento;
    }

    public function getById() {
        if(!empty($this->idsiq_factoresestructuradocumento)){
            $query = self::$queryRelacional
                    ." WHERE fed.idsiq_factoresestructuradocumento = ".$this->db->qstr($this->idsiq_factoresestructuradocumento);
            //ddd($query);
            $datos = $this->db->Execute($query);
            $d = $datos->FetchRow();
            
            if(!empty($d)){
                $this->idsiq_factoresestructuradocumento = $d['idsiq_factoresestructuradocumento']; 
                $this->idsiq_estructuradocumento = $d['idsiq_estructuradocumento']; 
                $this->factor_id = $d['factor_id']; 
                $this->codigo = $d['codigo']; 
                $this->nombre = $d['nombre']; 
                $this->descripcion = $d['descripcion']; 
                $this->nombre_entidad = $d['nombre_entidad']; 
                $this->nombre_documento = $d['nombre_documento'];
            }
        }
    }

    public static function getList($where=null) {
        $db = Factory::createDbo();
        
        $return = array();
        
        $query = self::$queryRelacional
                . " WHERE 1";
        
        if(!empty($where)){
            $query .= " AND ".$where;
        }
        //d($query);
        $datos = $db->Execute($query);
        while($d = $datos->FetchRow()){
            $RelacionFactorEstructura = new RelacionFactorEstructura();
                $RelacionFactorEstructura->idsiq_factoresestructuradocumento = $d['idsiq_factoresestructuradocumento']; 
                $RelacionFactorEstructura->idsiq_estructuradocumento = $d['idsiq_estructuradocumento']; 
                $RelacionFactorEstructura->factor_id = $d['factor_id']; 
                $RelacionFactorEstructura->codigo = $d['codigo']; 
                $RelacionFactorEstructura->nombre = $d['nombre']; 
                $RelacionFactorEstructura->descripcion = $d['descripcion']; 
                $RelacionFactorEstructura->nombre_entidad = $d['nombre_entidad']; 
                $RelacionFactorEstructura->nombre_documento = $d['nombre_documento'];
            
            $return[] = $RelacionFactorEstructura;
        }
        return $return;
    }
}
