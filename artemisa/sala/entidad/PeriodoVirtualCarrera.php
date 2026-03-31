<?php
/**
 * @author Andres Ariza <arizaandres@unbosque.edu.do>
 * @copyright Universidad el Bosque - Dirección de Tecnología
 * @package entidad
*/
defined('_EXEC') or die;
require_once(PATH_SITE."/entidad/EstadoPeriodo.php");
require_once(PATH_SITE."/entidad/Periodo.php");
require_once(PATH_SITE."/entidad/PeriodosVirtuales.php");
class PeriodoVirtualCarrera implements Entidad{
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
     * @type String
     * relacionado con la tabla Periodo
     * @access private
     */
    private $codigoPeriodo;
    
    /**
     * @type int
     * relacionado con la tabla PeriodosVirtuales
     * @access private
     */
    private $idPeriodoVirtual;
    
    /**
     * @type String
     * @access private
     */
    private $codigoModalidadAcademica;
    
    /**
     * @type String
     * @access private
     */
    private $codigoCarrera;
    
    /**
     * @type String
     * @access private
     */
    private $codigoEstadoPeriodo;
    
    /**
     * @type Datetime
     * @access private
     */
    private $fechaInicio;
    
    /**
     * @type Datetime
     * @access private
     */
    private $fechaFin;
    
    /**
     * @type int
     * @access private
     */
    private $idUsuarioCreacion;
    
    /**
     * @type dateTime
     * @access private
     */
    private $fechaCreacion;
    
    /**
     * @type int
     * @access private
     */
    private $idUsuarioModificacion;
    
    /**
     * @type dateTime
     * @access private
     */
    private $fechaModificacion;    
    
    /**
     * @type Periodo Object
     * @access private
     */
    private $Periodo;
    
    /**
     * @type PeriodoVirtual Object
     * @access private
     */
    private $PeriodoVirtual;
    
    /**
     * @type EstadoPeriodo Object
     * @access private
     */
    private $EstadoPeriodo;
    
    public function __construct() {}

    public function setDb() {
        $this->db = Factory::createDbo();
    }
    
    public function getId() {
        return $this->id;
    }

    public function getCodigoPeriodo() {
        return $this->codigoPeriodo;
    }

    public function getIdPeriodoVirtual() {
        return $this->idPeriodoVirtual;
    }

    public function getCodigoModalidadAcademica() {
        return $this->codigoModalidadAcademica;
    }

    public function getCodigoCarrera() {
        return $this->codigoCarrera;
    }

    public function getCodigoEstadoPeriodo() {
        return $this->codigoEstadoPeriodo;
    }

    public function getFechaInicio() {
        return $this->fechaInicio;
    }

    public function getFechaFin() {
        return $this->fechaFin;
    }

    public function getIdUsuarioCreacion() {
        return $this->idUsuarioCreacion;
    }

    public function getFechaCreacion() {
        return $this->fechaCreacion;
    }

    public function getIdUsuarioModificacion() {
        return $this->idUsuarioModificacion;
    }

    public function getFechaModificacion() {
        return $this->fechaModificacion;
    }

    public function getPeriodo() {
        return $this->Periodo;
    }

    public function getPeriodoVirtual() {
        return $this->PeriodoVirtual;
    }

    public function getEstadoPeriodo() {
        return $this->EstadoPeriodo;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setCodigoPeriodo($codigoPeriodo) {
        $this->codigoPeriodo = $codigoPeriodo;
    }

    public function setIdPeriodoVirtual($idPeriodoVirtual) {
        $this->idPeriodoVirtual = $idPeriodoVirtual;
    }

    public function setCodigoModalidadAcademica($codigoModalidadAcademica) {
        $this->codigoModalidadAcademica = $codigoModalidadAcademica;
    }

    public function setCodigoCarrera($codigoCarrera) {
        $this->codigoCarrera = $codigoCarrera;
    }

    public function setCodigoEstadoPeriodo($codigoEstadoPeriodo) {
        $this->codigoEstadoPeriodo = $codigoEstadoPeriodo;
    }

    public function setFechaInicio($fechaInicio) {
        $this->fechaInicio = $fechaInicio;
    }

    public function setFechaFin($fechaFin) {
        $this->fechaFin = $fechaFin;
    }

    public function setIdUsuarioCreacion($idUsuarioCreacion) {
        $this->idUsuarioCreacion = $idUsuarioCreacion;
    }

    public function setFechaCreacion($fechaCreacion) {
        $this->fechaCreacion = $fechaCreacion;
    }

    public function setIdUsuarioModificacion($idUsuarioModificacion) {
        $this->idUsuarioModificacion = $idUsuarioModificacion;
    }

    public function setFechaModificacion($fechaModificacion) {
        $this->fechaModificacion = $fechaModificacion;
    }

    public function setPeriodo() {
        if(!empty($this->codigoPeriodo)){
            $this->Periodo = new Periodo();
            $this->Periodo->setDb();
            $this->Periodo->setCodigoperiodo($this->codigoPeriodo);
            $this->Periodo->getById();
            $this->Periodo->setEstadoPeriodo();
        }
    }

    public function setPeriodoVirtual() {
        if(!empty($this->idPeriodoVirtual)){
            $this->PeriodoVirtual = new PeriodosVirtuales();
            $this->PeriodoVirtual->setDb();
            $this->PeriodoVirtual->setIdPeriodoVirtual($this->idPeriodoVirtual);
            $this->PeriodoVirtual->getById();
        }
    }

    public function setEstadoPeriodo() {
        if(!empty($this->codigoEstadoPeriodo)){
            $this->EstadoPeriodo = new EstadoPeriodo();
            $this->EstadoPeriodo->setDb();
            $this->EstadoPeriodo->setCodigoestadoperiodo($this->codigoEstadoPeriodo);
            $this->EstadoPeriodo->getById();
        }
    }

        
    public function getById() {
        if(!empty($this->id)){
            $query = "SELECT * FROM PeriodoVirtualCarrera "
                    ." WHERE id = ".$this->db->qstr($this->id);
            
            $datos = $this->db->Execute($query);
            $d = $datos->FetchRow();
            
            if(!empty($d)){
                $this->codigoPeriodo = $d['codigoPeriodo'];
                $this->idPeriodoVirtual = $d['idPeriodoVirtual'];
                $this->codigoModalidadAcademica = $d['codigoModalidadAcademica'];
                $this->codigoEstadoPeriodo = $d['codigoEstadoPeriodo'];
                $this->fechaInicio = $d['fechaInicio'];
                $this->fechaFin = $d['fechaFin'];
                $this->idUsuarioCreacion = $d['idUsuarioCreacion'];
                $this->fechaCreacion = $d['fechaCreacion'];
                $this->idUsuarioModificacion = $d['idUsuarioModificacion'];
                $this->fechaModificacion = $d['fechaModificacion'];
                $this->setPeriodo();
                $this->setPeriodoVirtual();
                $this->setEstadoPeriodo();
            }
        }
    }

    public static function getList($where=null) {
        $db = Factory::createDbo();
        
        $return = array();
        
        $query = "SELECT * "
                . " FROM PeriodoVirtualCarrera "
                . " WHERE 1";
        
        if(!empty($where)){
            $query .= " AND ".$where;
        }
        //d($query);
        $datos = $db->Execute($query);
        while($d = $datos->FetchRow()){
            $PeriodoVirtualCarrera = new PeriodoVirtualCarrera();
            $PeriodoVirtualCarrera->setDb(); 
            $PeriodoVirtualCarrera->id = $d['id'];
            $PeriodoVirtualCarrera->codigoPeriodo = $d['codigoPeriodo'];
            $PeriodoVirtualCarrera->idPeriodoVirtual = $d['idPeriodoVirtual'];
            $PeriodoVirtualCarrera->codigoModalidadAcademica = $d['codigoModalidadAcademica'];
            $PeriodoVirtualCarrera->codigoEstadoPeriodo = $d['codigoEstadoPeriodo'];
            $PeriodoVirtualCarrera->fechaInicio = $d['fechaInicio'];
            $PeriodoVirtualCarrera->fechaFin = $d['fechaFin'];
            $PeriodoVirtualCarrera->idUsuarioCreacion = $d['idUsuarioCreacion'];
            $PeriodoVirtualCarrera->fechaCreacion = $d['fechaCreacion'];
            $PeriodoVirtualCarrera->idUsuarioModificacion = $d['idUsuarioModificacion'];
            $PeriodoVirtualCarrera->fechaModificacion = $d['fechaModificacion'];
            $PeriodoVirtualCarrera->setPeriodo();
            $PeriodoVirtualCarrera->setPeriodoVirtual();
            $PeriodoVirtualCarrera->setEstadoPeriodo();
            $return[] = $PeriodoVirtualCarrera;
            unset($PeriodoVirtualCarrera);
        }
        return $return;
    }

}
/*/
id	int(11)
codigoPeriodo	varchar(8)
idPeriodoVirtual	int(11)
codigoModalidadAcademica	char(3)
codigoCarrera	int(11)
codigoEstadoPeriodo	char(2)
fechaInicio	datetime
fechaFin	datetime
idUsuarioCreacion	int(11)
fechaCreacion	datetime
idUsuarioModificacion	int(11)
fechaModificacion	datetime
/**/