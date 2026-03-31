<?php
/**
 * @author Andres Ariza <arizaandres@unbosque.edu.do>
 * @copyright Universidad el Bosque - Dirección de Tecnología
 * @package entidad
*/
defined('_EXEC') or die;
class Carrera implements Entidad{
    /**
     * @type adodb Object
     * @access private
     */
    private $db;
    
    /**
     * @type int
     * @access private
     */
    private $codigocarrera;
    
    /**
     * @type varchar
     * @access private
     */
    private $codigocortocarrera;
    
    /**
     * @type int
     * @access private
     */
    private $codigoDiurno;
    
    /**
     * @type varchar
     * @access private
     */
    private $nombrecortocarrera;
    
    /**
     * @type varchar
     * @access private
     */
    private $nombrecarrera;
    
    /**
     * @type varchar
     * @access private
     */
    private $codigofacultad;
    
    /**
     * @type varchar
     * @access private
     */
    private $centrocosto;
    
    /**
     * @type varchar
     * @access private
     */
    private $codigocentrobeneficio;
    
    /**
     * @type char
     * @access private
     */
    private $codigosucursal;
    
    /**
     * @type char
     * @access private
     */
    private $codigomodalidadacademica;
    
    /**
     * @type datetime
     * @access private
     */
    private $fechainiciocarrera;
    
    /**
     * @type datetime
     * @access private
     */
    private $fechavencimientocarrera;
    
    /**
     * @type varchar
     * @access private
     */
    private $abreviaturacodigocarrera;
    
    /**
     * @type int
     * @access private
     */
    private $iddirectivo;
    
    /**
     * @type int
     * @access private
     */
    private $codigotitulo;
    
    /**
     * @type char
     * @access private
     */
    private $codigotipocosto;
    
    /**
     * @type char
     * @access private
     */
    private $codigoindicadorcobroinscripcioncarrera;
    
    /**
     * @type char
     * @access private
     */
    private $codigoindicadorprocesoadmisioncarrera;
    
    /**
     * @type varchar
     * @access private
     */
    private $codigoindicadorplanestudio;
    
    /**
     * @type varchar
     * @access private
     */
    private $codigoindicadortipocarrera;
    
    /**
     * @type varchar
     * @access private
     */
    private $codigoreferenciacobromatriculacarrera;
    
    /**
     * @type Int
     * @access private
     */
    private $numerodiaaspirantecarrera;
    
    /**
     * @type varchar
     * @access private
     */
    private $codigoindicadorcarreragrupofechainscripcion;
    
    /**
     * @type char
     * @access private
     */
    private $codigomodalidadacademicasic;
    
    /**
     * @type Int
     * @access private
     */
    private $EsAdministrativa;
    
    public function __construct(){
    }
    
    public function setDb(){
        $this->db = Factory::createDbo();
    }
    
    public function getCodigocarrera() {
        return $this->codigocarrera;
    }

    public function getCodigocortocarrera() {
        return $this->codigocortocarrera;
    }

    public function getCodigoDiurno() {
        return $this->codigoDiurno;
    }

    public function getNombrecortocarrera() {
        return $this->nombrecortocarrera;
    }

    public function getNombrecarrera() {
        return $this->nombrecarrera;
    }

    public function getCodigofacultad() {
        return $this->codigofacultad;
    }

    public function getCentrocosto() {
        return $this->centrocosto;
    }

    public function getCodigocentrobeneficio() {
        return $this->codigocentrobeneficio;
    }

    public function getCodigosucursal() {
        return $this->codigosucursal;
    }

    public function getCodigomodalidadacademica() {
        return $this->codigomodalidadacademica;
    }

    public function getFechainiciocarrera() {
        return $this->fechainiciocarrera;
    }

    public function getFechavencimientocarrera() {
        return $this->fechavencimientocarrera;
    }

    public function getAbreviaturacodigocarrera() {
        return $this->abreviaturacodigocarrera;
    }

    public function getIddirectivo() {
        return $this->iddirectivo;
    }

    public function getCodigotitulo() {
        return $this->codigotitulo;
    }

    public function getCodigotipocosto() {
        return $this->codigotipocosto;
    }

    public function getCodigoindicadorcobroinscripcioncarrera() {
        return $this->codigoindicadorcobroinscripcioncarrera;
    }

    public function getCodigoindicadorprocesoadmisioncarrera() {
        return $this->codigoindicadorprocesoadmisioncarrera;
    }

    public function getCodigoindicadorplanestudio() {
        return $this->codigoindicadorplanestudio;
    }

    public function getCodigoindicadortipocarrera() {
        return $this->codigoindicadortipocarrera;
    }

    public function getCodigoreferenciacobromatriculacarrera() {
        return $this->codigoreferenciacobromatriculacarrera;
    }

    public function getNumerodiaaspirantecarrera() {
        return $this->numerodiaaspirantecarrera;
    }

    public function getCodigoindicadorcarreragrupofechainscripcion() {
        return $this->codigoindicadorcarreragrupofechainscripcion;
    }

    public function getCodigomodalidadacademicasic() {
        return $this->codigomodalidadacademicasic;
    }

    public function getEsAdministrativa() {
        return $this->EsAdministrativa;
    }

    public function setCodigocarrera($codigocarrera) {
        $this->codigocarrera = $codigocarrera;
    }

    public function setCodigocortocarrera($codigocortocarrera) {
        $this->codigocortocarrera = $codigocortocarrera;
    }

    public function setCodigoDiurno($codigoDiurno) {
        $this->codigoDiurno = $codigoDiurno;
    }

    public function setNombrecortocarrera($nombrecortocarrera) {
        $this->nombrecortocarrera = $nombrecortocarrera;
    }

    public function setNombrecarrera($nombrecarrera) {
        $this->nombrecarrera = $nombrecarrera;
    }

    public function setCodigofacultad($codigofacultad) {
        $this->codigofacultad = $codigofacultad;
    }

    public function setCentrocosto($centrocosto) {
        $this->centrocosto = $centrocosto;
    }

    public function setCodigocentrobeneficio($codigocentrobeneficio) {
        $this->codigocentrobeneficio = $codigocentrobeneficio;
    }

    public function setCodigosucursal($codigosucursal) {
        $this->codigosucursal = $codigosucursal;
    }

    public function setCodigomodalidadacademica($codigomodalidadacademica) {
        $this->codigomodalidadacademica = $codigomodalidadacademica;
    }

    public function setFechainiciocarrera($fechainiciocarrera) {
        $this->fechainiciocarrera = $fechainiciocarrera;
    }

    public function setFechavencimientocarrera($fechavencimientocarrera) {
        $this->fechavencimientocarrera = $fechavencimientocarrera;
    }

    public function setAbreviaturacodigocarrera($abreviaturacodigocarrera) {
        $this->abreviaturacodigocarrera = $abreviaturacodigocarrera;
    }

    public function setIddirectivo($iddirectivo) {
        $this->iddirectivo = $iddirectivo;
    }

    public function setCodigotitulo($codigotitulo) {
        $this->codigotitulo = $codigotitulo;
    }

    public function setCodigotipocosto($codigotipocosto) {
        $this->codigotipocosto = $codigotipocosto;
    }

    public function setCodigoindicadorcobroinscripcioncarrera($codigoindicadorcobroinscripcioncarrera) {
        $this->codigoindicadorcobroinscripcioncarrera = $codigoindicadorcobroinscripcioncarrera;
    }

    public function setCodigoindicadorprocesoadmisioncarrera($codigoindicadorprocesoadmisioncarrera) {
        $this->codigoindicadorprocesoadmisioncarrera = $codigoindicadorprocesoadmisioncarrera;
    }

    public function setCodigoindicadorplanestudio($codigoindicadorplanestudio) {
        $this->codigoindicadorplanestudio = $codigoindicadorplanestudio;
    }

    public function setCodigoindicadortipocarrera($codigoindicadortipocarrera) {
        $this->codigoindicadortipocarrera = $codigoindicadortipocarrera;
    }

    public function setCodigoreferenciacobromatriculacarrera($codigoreferenciacobromatriculacarrera) {
        $this->codigoreferenciacobromatriculacarrera = $codigoreferenciacobromatriculacarrera;
    }

    public function setNumerodiaaspirantecarrera($numerodiaaspirantecarrera) {
        $this->numerodiaaspirantecarrera = $numerodiaaspirantecarrera;
    }

    public function setCodigoindicadorcarreragrupofechainscripcion($codigoindicadorcarreragrupofechainscripcion) {
        $this->codigoindicadorcarreragrupofechainscripcion = $codigoindicadorcarreragrupofechainscripcion;
    }

    public function setCodigomodalidadacademicasic($codigomodalidadacademicasic) {
        $this->codigomodalidadacademicasic = $codigomodalidadacademicasic;
    }

    public function setEsAdministrativa($EsAdministrativa) {
        $this->EsAdministrativa = $EsAdministrativa;
    }
    public function getById() {
        $this->getByCodigo();
    }
    public function getByCodigo(){
        if(!empty($this->codigocarrera)){
            $query = "SELECT * FROM carrera "
                    ." WHERE codigocarrera = ".$this->db->qstr($this->codigocarrera);
            
            $datos = $this->db->Execute($query);
            $d = $datos->FetchRow();
            
            if(!empty($d)){
                $this->codigocortocarrera = $d['codigocortocarrera'];
                $this->codigoDiurno = $d['codigoDiurno'];
                $this->nombrecortocarrera = $d['nombrecortocarrera'];
                $this->nombrecarrera = $d['nombrecarrera'];
                $this->codigofacultad = $d['codigofacultad'];
                $this->centrocosto = $d['centrocosto'];
                $this->codigocentrobeneficio = $d['codigocentrobeneficio'];
                $this->codigosucursal = $d['codigosucursal'];
                $this->codigomodalidadacademica = $d['codigomodalidadacademica'];
                $this->fechainiciocarrera = $d['fechainiciocarrera'];
                $this->fechavencimientocarrera = $d['fechavencimientocarrera'];
                $this->abreviaturacodigocarrera = $d['abreviaturacodigocarrera'];
                $this->iddirectivo = $d['iddirectivo'];
                $this->codigotitulo = $d['codigotitulo'];
                $this->codigotipocosto = $d['codigotipocosto'];
                $this->codigoindicadorcobroinscripcioncarrera = $d['codigoindicadorcobroinscripcioncarrera'];
                $this->codigoindicadorprocesoadmisioncarrera = $d['codigoindicadorprocesoadmisioncarrera'];
                $this->codigoindicadorplanestudio = $d['codigoindicadorplanestudio'];
                $this->codigoindicadortipocarrera = $d['codigoindicadortipocarrera'];
                $this->codigoreferenciacobromatriculacarrera = $d['codigoreferenciacobromatriculacarrera'];
                $this->numerodiaaspirantecarrera = $d['numerodiaaspirantecarrera'];
                $this->codigoindicadorcarreragrupofechainscripcion = $d['codigoindicadorcarreragrupofechainscripcion'];
                $this->codigomodalidadacademicasic = $d['codigomodalidadacademicasic'];
                $this->EsAdministrativa = $d['EsAdministrativa'];
            }
        }
    }
    
    public static function getList($where=null, $orderBy = null){
        $return = array();
        $db = Factory::createDbo();
        $query = "SELECT * FROM carrera "
                    ." WHERE 1 ";
        if(!empty($where)){
            $query .= " AND ".$where;
        }
        if(!empty($orderBy)){
            $query .= " ORDER BY ".$orderBy;
        }
        //d($query);
        $datos = $db->Execute($query);
        
        while( $d = $datos->FetchRow() ){
            $Carrera = new Carrera();
            $Carrera->codigocarrera = $d['codigocarrera'];
            $Carrera->codigocortocarrera = $d['codigocortocarrera'];
            $Carrera->codigoDiurno = $d['codigoDiurno'];
            $Carrera->nombrecortocarrera = $d['nombrecortocarrera'];
            $Carrera->nombrecarrera = trim($d['nombrecarrera']);
            $Carrera->codigofacultad = $d['codigofacultad'];
            $Carrera->centrocosto = $d['centrocosto'];
            $Carrera->codigocentrobeneficio = $d['codigocentrobeneficio'];
            $Carrera->codigosucursal = $d['codigosucursal'];
            $Carrera->codigomodalidadacademica = $d['codigomodalidadacademica'];
            $Carrera->fechainiciocarrera = $d['fechainiciocarrera'];
            $Carrera->fechavencimientocarrera = $d['fechavencimientocarrera'];
            $Carrera->abreviaturacodigocarrera = $d['abreviaturacodigocarrera'];
            $Carrera->iddirectivo = $d['iddirectivo'];
            $Carrera->codigotitulo = $d['codigotitulo'];
            $Carrera->codigotipocosto = $d['codigotipocosto'];
            $Carrera->codigoindicadorcobroinscripcioncarrera = $d['codigoindicadorcobroinscripcioncarrera'];
            $Carrera->codigoindicadorprocesoadmisioncarrera = $d['codigoindicadorprocesoadmisioncarrera'];
            $Carrera->codigoindicadorplanestudio = $d['codigoindicadorplanestudio'];
            $Carrera->codigoindicadortipocarrera = $d['codigoindicadortipocarrera'];
            $Carrera->codigoreferenciacobromatriculacarrera = $d['codigoreferenciacobromatriculacarrera'];
            $Carrera->numerodiaaspirantecarrera = $d['numerodiaaspirantecarrera'];
            $Carrera->codigoindicadorcarreragrupofechainscripcion = $d['codigoindicadorcarreragrupofechainscripcion'];
            $Carrera->codigomodalidadacademicasic = $d['codigomodalidadacademicasic'];
            $Carrera->EsAdministrativa = $d['EsAdministrativa'];
            
            $return[] = $Carrera;
            unset($Carrera);
        }
        
        return $return;
    }
    
    function cmp($a, $b){
        return strcmp($a["nombrecarrera"], $b["nombrecarrera"]);
    }


}