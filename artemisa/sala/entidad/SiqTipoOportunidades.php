<?php
/**
 * @author Andres Ariza <arizaandres@unbosque.edu.do>
 * @copyright Universidad el Bosque - Dirección de Tecnología
 * @package entidad
*/
defined('_EXEC') or die;
class SiqTipoOportunidades  implements Entidad{
    /**
     * @var adodb Object
     * @access private
     */
    private $db;
    
    /**
     * @var int
     * @access private
     */
    private $idsiq_tipooportunidad;
    
    /**
     * @var String
     * @access private
     */
    private $nombre;
    
    /**
     * @var String
     * @access private
     */
    private $codigoestado;
    
    public function __construct(){
    }
    
    public function setDb(){
        $this->db = Factory::createDbo();
    }
    
    function getIdsiq_tipooportunidad() {
        return $this->idsiq_tipooportunidad;
    }

    function getNombre() {
        return $this->nombre;
    }

    function getCodigoestado() {
        return $this->codigoestado;
    }

    function setIdsiq_tipooportunidad($idsiq_tipooportunidad) {
        $this->idsiq_tipooportunidad = $idsiq_tipooportunidad;
    }

    function setNombre(String $nombre) {
        $this->nombre = $nombre;
    }

    function setCodigoestado(String $codigoestado) {
        $this->codigoestado = $codigoestado;
    }
    
    public function getById() {
        if(!empty($this->idsiq_tipooportunidad)){
            $query = "SELECT * FROM siq_tipooportunidades "
                    ." WHERE idsiq_tipooportunidad = ".$this->db->qstr($this->idsiq_tipooportunidad);
            
            $datos = $this->db->Execute($query);
            $d = $datos->FetchRow();
            
            if(!empty($d)){
                $this->nombre = $d['nombre']; 
                $this->codigoestado = $d['codigoestado'];
            }
        }
    }

    public static function getList($where=null) {
        $db = Factory::createDbo();
        
        $return = array();
        
        $query = "SELECT * "
                . " FROM siq_tipooportunidades "
                . " WHERE 1";
        
        if(!empty($where)){
            $query .= " AND ".$where;
        }
        
        $datos = $db->Execute($query);
        while($d = $datos->FetchRow()){
            $SiqTipoOportunidades = new SiqTipoOportunidades();
            $SiqTipoOportunidades->idsiq_tipooportunidad = $d['idsiq_tipooportunidad'];
            $SiqTipoOportunidades->nombre = $d['nombre'];
            $SiqTipoOportunidades->codigoestado = $d['codigoestado'];
            $return[] = $SiqTipoOportunidades;
        }
        return $return;
    }

      
}