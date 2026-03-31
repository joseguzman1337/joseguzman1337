<?php
//namespace Sala\entidad;

defined('_EXEC') or die;

//use \Sala\lib\Factory;

/**
 * @author Andres Ariza <arizaandres@unbosque.edu.do>
 * @copyright Universidad el Bosque - Dirección de Tecnología
 * @package entidad
*/
class Inscripcion implements Entidad {// \Sala\interfaces\Entidad {
    /**
     * @type adodb Object
     * @access private
     */
    private $db;

    /**
     * @type int
     * @access private
     */
    private $idinscripcion;

    /**
     * @type string
     * @access private
     */
    private $anoaspirainscripcion;

    /**
     * @type string
     * @access private
     */
    private $codigoestado;

    /**
     * @type string
     * @access private
     */
    private $codigomodalidadacademica;

    /**
     * @type string
     * @access private
     */
    private $codigoperiodo;

    /**
     * @type string
     * @access private
     */
    private $codigosituacioncarreraestudiante;

    /**
     * @type datetime
     * @access private
     */
    private $fechainscripcion;

    /**
     * @type string
     * @access private
     */
    private $fotoinscripcion;

    /**
     * @type int
     * @access private
     */
    private $idestudiantegeneral;

    /**
     * @type string
     * @access private
     */
    private $numeroinscripcion;

    public function __construct() {        
    }
    
    public function setDb(){
        $this->db = Factory::createDbo();
    }
    
    public function getAnoaspirainscripcion() {
        return $this->anoaspirainscripcion;
    }

    public function getCodigoestado() {
        return $this->codigoestado;
    }

    public function getCodigomodalidadacademica() {
        return $this->codigomodalidadacademica;
    }

    public function getCodigoperiodo() {
        return $this->codigoperiodo;
    }

    public function getCodigosituacioncarreraestudiante() {
        return $this->codigosituacioncarreraestudiante;
    }

    public function getFechainscripcion() {
        return $this->fechainscripcion;
    }

    public function getFotoinscripcion() {
        return $this->fotoinscripcion;
    }

    public function getIdestudiantegeneral() {
        return $this->idestudiantegeneral;
    }

    public function getIdinscripcion() {
        return $this->idinscripcion;
    }

    public function getNumeroinscripcion() {
        return $this->numeroinscripcion;
    }

    public function setAnoaspirainscripcion($anoaspirainscripcion) {
        $this->anoaspirainscripcion = $anoaspirainscripcion;
    }

    public function setCodigoestado($codigoestado) {
        $this->codigoestado = $codigoestado;
    }

    public function setCodigomodalidadacademica($codigomodalidadacademica) {
        $this->codigomodalidadacademica = $codigomodalidadacademica;
    }

    public function setCodigoperiodo($codigoperiodo) {
        $this->codigoperiodo = $codigoperiodo;
    }

    public function setCodigosituacioncarreraestudiante($codigosituacioncarreraestudiante) {
        $this->codigosituacioncarreraestudiante = $codigosituacioncarreraestudiante;
    }

    public function setFechainscripcion($fechainscripcion) {
        $this->fechainscripcion = $fechainscripcion;
    }

    public function setFotoinscripcion($fotoinscripcion) {
        $this->fotoinscripcion = $fotoinscripcion;
    }

    public function setIdestudiantegeneral($idestudiantegeneral) {
        $this->idestudiantegeneral = $idestudiantegeneral;
    }

    public function setIdinscripcion($idinscripcion) {
        $this->idinscripcion = $idinscripcion;
    }

    public function setNumeroinscripcion($numeroinscripcion) {
        $this->numeroinscripcion = $numeroinscripcion;
    }

    
    public function getById() {
        if(!empty($this->idinscripcion)){
            $query = "SELECT * FROM inscripcion "
                    ." WHERE idinscripcion = ".$this->db->qstr($this->idinscripcion);
            $datos = $this->db->Execute($query);
            $d = $datos->FetchRow();
            
            if(!empty($d)){ 
                $this->setIdinscripcion( $d['idinscripcion'] );
                $this->setAnoaspirainscripcion( $d['anoaspirainscripcion'] );
                $this->setCodigoestado( $d['codigoestado'] );
                $this->setCodigomodalidadacademica( $d['codigomodalidadacademica'] );
                $this->setCodigoperiodo( $d['codigoperiodo'] );
                $this->setCodigosituacioncarreraestudiante( $d['codigosituacioncarreraestudiante'] );
                $this->setFechainscripcion( $d['fechainscripcion'] );
                $this->setFotoinscripcion( $d['fotoinscripcion'] );
                $this->setIdestudiantegeneral( $d['idestudiantegeneral'] );
                $this->setNumeroinscripcion( $d['numeroinscripcion'] );
            }  
        }
        
    }

    /**
     * 
     * @param where
     */
    public static function getList($where = null) {
        
        $db = Factory::createDbo();
        
        $return = array();
        
        $query = "SELECT * "
                . " FROM inscripcion ";
        if(!empty($where)){
            $query .= " WHERE ".$where;
         }
        $datos = $db->Execute($query);
        
        while($d = $datos->FetchRow()){
            $Inscripcion = new Inscripcion();
             
            $Inscripcion->setIdinscripcion( $d['idinscripcion'] );
            $Inscripcion->setAnoaspirainscripcion( $d['anoaspirainscripcion'] );
            $Inscripcion->setCodigoestado( $d['codigoestado'] );
            $Inscripcion->setCodigomodalidadacademica( $d['codigomodalidadacademica'] );
            $Inscripcion->setCodigoperiodo( $d['codigoperiodo'] );
            $Inscripcion->setCodigosituacioncarreraestudiante( $d['codigosituacioncarreraestudiante'] );
            $Inscripcion->setFechainscripcion( $d['fechainscripcion'] );
            $Inscripcion->setFotoinscripcion( $d['fotoinscripcion'] );
            $Inscripcion->setIdestudiantegeneral( $d['idestudiantegeneral'] );
            $Inscripcion->setNumeroinscripcion( $d['numeroinscripcion'] );
            
            $return[] = $Inscripcion;
            unset($Inscripcion);
        }
        return $return;
    }

}
