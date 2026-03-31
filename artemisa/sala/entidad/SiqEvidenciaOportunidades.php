<?php
/**
 * @author Andres Ariza <arizaandres@unbosque.edu.do>
 * @copyright Universidad el Bosque - Dirección de Tecnología
 * @package entidad
*/
defined('_EXEC') or die;
class SiqEvidenciaOportunidades  implements Entidad{
    /**
     * @var adodb Object
     * @access private
     */
    private $db;

    /**
     * @var int
     * @access private
     */
    private $idsiq_evidenciaoportunidad;

    /**
     * @var int
     * @access private
     */
    private $idsiq_oportunidad;

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
     * @var int
     * @access private
     */
    private $usuariocreacion;

    /**
     * @var Date
     * @access private
     */
    private $fechacreacion;

    /**
     * @var int
     * @access private
     */
    private $usuariomodificacion;

    /**
     * @var Date
     * @access private
     */
    private $fechamodificacion;

    /**
     * @var String
     * @access private
     */
    private $codigoestado;

    /**
     * @var string
     * @access private
     */
    private $Valoracion;
    
    public function __construct(){
    }
    
    public function setDb(){
        $this->db = Factory::createDbo();
    }
    
    public function getIdsiq_evidenciaoportunidad() {
        return $this->idsiq_evidenciaoportunidad;
    }

    public function getIdsiq_oportunidad() {
        return $this->idsiq_oportunidad;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function getUsuariocreacion() {
        return $this->usuariocreacion;
    }

    public function getFechacreacion() {
        return $this->fechacreacion;
    }

    public function getUsuariomodificacion() {
        return $this->usuariomodificacion;
    }

    public function getFechamodificacion() {
        return $this->fechamodificacion;
    }

    public function getCodigoestado() {
        return $this->codigoestado;
    }

    public function getValoracion() {
        return $this->Valoracion;
    }

    public function setIdsiq_evidenciaoportunidad($idsiq_evidenciaoportunidad) {
        $this->idsiq_evidenciaoportunidad = $idsiq_evidenciaoportunidad;
    }

    public function setIdsiq_oportunidad($idsiq_oportunidad) {
        $this->idsiq_oportunidad = $idsiq_oportunidad;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    public function setUsuariocreacion($usuariocreacion) {
        $this->usuariocreacion = $usuariocreacion;
    }

    public function setFechacreacion($fechacreacion) {
        $this->fechacreacion = $fechacreacion;
    }

    public function setUsuariomodificacion($usuariomodificacion) {
        $this->usuariomodificacion = $usuariomodificacion;
    }

    public function setFechamodificacion($fechamodificacion) {
        $this->fechamodificacion = $fechamodificacion;
    }

    public function setCodigoestado($codigoestado) {
        $this->codigoestado = $codigoestado;
    }

    public function setValoracion($Valoracion) {
        $this->Valoracion = $Valoracion;
    }
        
    public function getById() {
        if(!empty($this->idsiq_evidenciaoportunidad)){
            $query = "SELECT * FROM siq_evidenciaoportunidades "
                    ." WHERE idsiq_evidenciaoportunidad = ".$this->db->qstr($this->idsiq_evidenciaoportunidad);
            
            $datos = $this->db->Execute($query);
            $d = $datos->FetchRow();
            
            if(!empty($d)){
                $this->idsiq_oportunidad = $d['idsiq_oportunidad'];
                $this->nombre = $d['nombre'];
                $this->descripcion = $d['descripcion'];
                $this->usuariocreacion = $d['usuariocreacion'];
                $this->fechacreacion = $d['fechacreacion'];
                $this->usuariomodificacion = $d['usuariomodificacion'];
                $this->fechamodificacion = $d['fechamodificacion'];
                $this->codigoestado = $d['codigoestado'];
                $this->Valoracion = $d['Valoracion'];
            }
        }
    }

    public static function getList($where=null) {
        $db = Factory::createDbo();
        
        $return = array();
        
        $query = "SELECT * "
                . " FROM siq_evidenciaoportunidades "
                . " WHERE 1";
        
        if(!empty($where)){
            $query .= " AND ".$where;
        }
        
        $datos = $db->Execute($query);
        while($d = $datos->FetchRow()){
            $SiqEvidenciaOportunidades = new SiqEvidenciaOportunidades();
            $SiqEvidenciaOportunidades->idsiq_evidenciaoportunidad = $d['idsiq_evidenciaoportunidad'];
            $SiqEvidenciaOportunidades->idsiq_oportunidad = $d['idsiq_oportunidad'];
            $SiqEvidenciaOportunidades->nombre = $d['nombre'];
            $SiqEvidenciaOportunidades->descripcion = $d['descripcion'];
            $SiqEvidenciaOportunidades->usuariocreacion = $d['usuariocreacion'];
            $SiqEvidenciaOportunidades->fechacreacion = $d['fechacreacion'];
            $SiqEvidenciaOportunidades->usuariomodificacion = $d['usuariomodificacion'];
            $SiqEvidenciaOportunidades->fechamodificacion = $d['fechamodificacion'];
            $SiqEvidenciaOportunidades->codigoestado = $d['codigoestado'];
            $SiqEvidenciaOportunidades->Valoracion = $d['Valoracion'];
            $return[] = $SiqEvidenciaOportunidades;
        }
        return $return;
    }
}
