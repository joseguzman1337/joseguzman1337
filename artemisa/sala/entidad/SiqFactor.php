<?php
/**
 * @author Andres Ariza <arizaandres@unbosque.edu.do>
 * @copyright Universidad el Bosque - Dirección de Tecnología
 * @package entidad
*/
defined('_EXEC') or die;
class SiqFactor  implements Entidad{
    /**
     * @var adodb Object
     * @access private
     */
    private $db;
    
    /**
     * @var int
     * @access private
     */
    private $idsiq_factor;
    
    /**
     * @var int
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
     * @var date
     * @access private
     */
    private $fecha_creacion;
    
    /**
     * @var int
     * @access private
     */
    private $usuario_creacion;
    
    /**
     * @var int
     * @access private
     */
    private $codigoestado;
    
    /**
     * @var Date
     * @access private
     */
    private $fecha_modificacion;
    
    /**
     * @var int
     * @access private
     */
    private $usuario_modificacion;
    
    public function __construct(){
    }
    
    public function setDb(){
        $this->db = Factory::createDbo();
    }
    
    public function getIdsiq_factor() {
        return $this->idsiq_factor;
    }

    public function getCodigo() {
        return $this->codigo;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function getFecha_creacion() {
        return $this->fecha_creacion;
    }

    public function getUsuario_creacion() {
        return $this->usuario_creacion;
    }

    public function getCodigoestado() {
        return $this->codigoestado;
    }

    public function getFecha_modificacion() {
        return $this->fecha_modificacion;
    }

    public function getUsuario_modificacion() {
        return $this->usuario_modificacion;
    }

    public function setIdsiq_factor($idsiq_factor) {
        $this->idsiq_factor = $idsiq_factor;
    }

    public function setCodigo($codigo) {
        $this->codigo = $codigo;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    public function setFecha_creacion($fecha_creacion) {
        $this->fecha_creacion = $fecha_creacion;
    }

    public function setUsuario_creacion($usuario_creacion) {
        $this->usuario_creacion = $usuario_creacion;
    }

    public function setCodigoestado($codigoestado) {
        $this->codigoestado = $codigoestado;
    }

    public function setFecha_modificacion($fecha_modificacion) {
        $this->fecha_modificacion = $fecha_modificacion;
    }

    public function setUsuario_modificacion($usuario_modificacion) {
        $this->usuario_modificacion = $usuario_modificacion;
    }

    public function getById() {
        if(!empty($this->idsiq_factor)){
            $query = "SELECT * FROM siq_factor "
                    ." WHERE idsiq_factor = ".$this->db->qstr($this->idsiq_factor);
            
            $datos = $this->db->Execute($query);
            $d = $datos->FetchRow();
            
            if(!empty($d)){
                $this->codigo = $d['codigo'];
                $this->nombre = $d['nombre'];
                $this->descripcion = $d['descripcion'];
                $this->fecha_creacion = $d['fecha_creacion'];
                $this->usuario_creacion = $d['usuario_creacion'];
                $this->codigoestado = $d['codigoestado'];
                $this->fecha_modificacion = $d['fecha_modificacion'];
                $this->usuario_modificacion = $d['usuario_modificacion'];
            }
        }
    }

    public static function getList($where=null) {
        $db = Factory::createDbo();
        
        $return = array();
        
        $query = "SELECT * "
                . " FROM siq_factor "
                . " WHERE 1";
        
        if(!empty($where)){
            $query .= " AND ".$where;
        }
        
        $datos = $db->Execute($query);
        while($d = $datos->FetchRow()){
            $SiqFactor = new SiqFactor();            
            $SiqFactor->idsiq_factor = $d['idsiq_factor'];
            $SiqFactor->codigo = $d['codigo'];
            $SiqFactor->nombre = $d['nombre'];
            $SiqFactor->descripcion = $d['descripcion'];
            $SiqFactor->fecha_creacion = $d['fecha_creacion'];
            $SiqFactor->usuario_creacion = $d['usuario_creacion'];
            $SiqFactor->codigoestado = $d['codigoestado'];
            $SiqFactor->fecha_modificacion = $d['fecha_modificacion'];
            $SiqFactor->usuario_modificacion = $d['usuario_modificacion'];

            $return[] = $SiqFactor;
        }
        return $return;
    }
}
