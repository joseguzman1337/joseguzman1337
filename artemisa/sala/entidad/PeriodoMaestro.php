<?php
/**
 * @author Diego Rivera<riveradiego@unbosque.edu.co>
 * @copyright Universidad el Bosque - Dirección de Tecnología
 * @package entidad
 */
defined('_EXEC') or die;
class PeriodoMaestro {
    /**
    * @type adodb Object
    * @access private
    */
    private $db;
    /**
     * @type int
     * @access private
     */
    private $id;
    /**
     * @type varchar
     * @access private
     */ 
    private $codigo;
    /**
     * @type varchar
     * @access private
     */
    private $nombre;        
    /**
     * @type int
     * @access private
     */
    private $numeroPeriodo;
    /**
     * @type varchar
     * @access private
     */
    private $idAgno;
    /**
     * @type char
     * @access private
     */
    private $codigoEstado; 
    /**
     * @type date
     * @access private
     */
    private $idUsuarioCreacion;
    /**
     * @type date
     * @access private
     */
    private $fechaCreacion;
    /**
     * @type int
     * @access private
     */
    private $idUsuarioModificacion;
    /**
     * @type datetime
     * @access private
     */
    private $fechaModificacion;
    
    public function __construct(){
    }
    
    public function setDb(){
        $this->db = Factory::createDbo();
    }
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

        
    public function getCodigo() {
        return $this->codigo;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getNumeroPeriodo() {
        return $this->numeroPeriodo;
    }

    public function getIdAgno() {
        return $this->idAgno;
    }

    public function getCodigoEstado() {
        return $this->codigoEstado;
    }

    public function getIdUsuarioCreacion() {
        return $this->idUsuarioCreacion;
    }

    public function getFechaCreacion() {
        return $this->fechaCreacion;
    }

   
    public function getFechaModificacion() {
        return $this->fechaModificacion;
    }

    public function setCodigo($codigo) {
        $this->codigo = $codigo;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function setNumeroPeriodo($numeroPeriodo) {
        $this->numeroPeriodo = $numeroPeriodo;
    }

    public function setIdAgno($idAgno) {
        $this->idAgno = $idAgno;
    }

    public function setCodigoEstado($codigoEstado) {
        $this->codigoEstado = $codigoEstado;
    }

    public function setIdUsuarioCreacion($idUsuarioCreacion) {
        $this->idUsuarioCreacion = $idUsuarioCreacion;
    }

    public function setFechaCreacion($fechaCreacion) {
        $this->fechaCreacion = $fechaCreacion;
    }

    public function getIdUsuarioModificacion() {
        return $this->idUsuarioModificacion;
    }

    public function setIdUsuarioModificacion($idUsuarioModificacion) {
        $this->idUsuarioModificacion = $idUsuarioModificacion;

    } 
        public function setFechaModificacion($fechaModificacion) {
        $this->fechaModificacion = $fechaModificacion;
    }

    public function getById(){
        if(!empty($this->id)){
            $query = "SELECT * FROM periodoMaestro "
                    ." WHERE id = ".$this->db->qstr($this->id);
            
            $datos = $this->db->Execute($query);
            $d = $datos->FetchRow();
            
            if(!empty($d)){
                $this->codigo = $d['codigo']; 
                $this->nombre = $d['nombre']; 
                $this->numeroPeriodo = $d['numeroPeriodo']; 
                $this->idAgno = $d['idAgno']; 
                $this->codigoEstado = $d['codigoEstado'];
                $this->idUsuarioCreacion = $d['idUsuarioCreacion'];
                $this->fechaCreacion = $d['fechaCreacion'];
                $this->idUsuarioModificacion = $d['idUsuarioModificacion'];
                $this->fechaModificacion = $d['fechaModificacion'];
            }
        }
    }
    
    public static function getList( $where=null , $orderBy = null){
        $db = Factory::createDbo();
        //d(1);
        $return = array();
        
        $query = "SELECT * "
                . " FROM periodoMaestro "
                . " WHERE 1";
        
        if(!empty($where)){
            $query .= " AND ".$where;
        }
        
        if(!empty($orderBy)){
            $query .= " ORDER BY ".$orderBy;
        }
        $datos = $db->Execute($query);
        while($d = $datos->FetchRow()){
            $periodoMaestro = new PeriodoMaestro();
            
            $periodoMaestro->setId($d['id']); 
            $periodoMaestro->setCodigo($d['codigo']); 
            $periodoMaestro->setNombre($d['nombre']); 
            $periodoMaestro->setNumeroPeriodo($d['numeroPeriodo']); 
            $periodoMaestro->setIdAgno($d['idAgno']);
            $periodoMaestro->setCodigoEstado($d['codigoEstado']);  
            $periodoMaestro->setIdUsuarioCreacion($d['idUsuarioCreacion']);  
            $periodoMaestro->setFechaCreacion($d['fechaCreacion']);  
            $periodoMaestro->setIdUsuarioModificacion($d['idUsuarioModificacion']);  
            $periodoMaestro->setFechaModificacion($d['fechaModificacion']);
            
            $return[] = $periodoMaestro;
            unset($periodoMaestro);
        }
        return $return;
    }
}
            

