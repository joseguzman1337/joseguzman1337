<?php
/**
 * @author Andres Ariza <arizaandres@unbosque.edu.do>
 * @copyright Universidad el Bosque - Dirección de Tecnología
 * @package entidad
*/
defined('_EXEC') or die;
class Materia implements Entidad{
    /**
     * @type adodb Object
     * @access private
     */
    private $db;
    
    /**
     * @type int
     * @access private
     */
    private $codigomateria;
    
    /**
     * @type varchar
     * @access private
     */
    private $nombrecortomateria;
    
    /**
     * @type varchar
     * @access private
     */
    private $nombremateria;
    
    /**
     * @type smallint
     * @access private
     */
    private $numerocreditos;
    
    /**
     * @type varchar
     * @access private
     */
    private $codigoperiodo;
    
    /**
     * @type decimal
     * @access private
     */
    private $notaminimaaprobatoria;
    
    /**
     * @type decimal
     * @access private
     */
    private $notaminimahabilitacion;
    
    /**
     * @type smallint
     * @access private
     */
    private $numerosemana;
    
    /**
     * @type smallint
     * @access private
     */
    private $numerohorassemanales;
    
    /**
     * @type int
     * @access private
     */
    private $porcentajeteoricamateria;
    
    /**
     * @type int
     * @access private
     */
    private $porcentajepracticamateria;
    
    /**
     * @type int
     * @access private
     */
    private $porcentajefallasteoriamodalidadmateria;
    
    /**
     * @type int
     * @access private
     */
    private $porcentajefallaspracticamodalidadmateria;
    
    /**
     * @type int
     * @access private
     */
    private $codigomodalidadmateria;
    
    /**
     * @type char
     * @access private
     */
    private $codigolineaacademica;
    
    /**
     * @type int
     * @access private
     */
    private $codigocarrera;
    
    /**
     * @type char
     * @access private
     */
    private $codigoindicadorgrupomateria;
    
    /**
     * @type char
     * @access private
     */
    private $codigotipomateria;
    
    /**
     * @type char
     * @access private
     */
    private $codigoestadomateria;
    
    /**
     * @type varchar
     * @access private
     */
    private $ulasa;
    
    /**
     * @type varchar
     * @access private
     */
    private $ulasb;
    
    /**
     * @type varchar
     * @access private
     */
    private $ulasc;
    
    /**
     * @type char
     * @access private
     */
    private $codigoindicadorcredito;
    
    /**
     * @type char
     * @access private
     */
    private $codigoindicadoretiquetamateria;
    
    /**
     * @type char
     * @access private
     */
    private $codigotipocalificacionmateria;
    
    /**
     * @type smallint
     * @access private
     */
    private $sesionesmateria;
    
    /**
     * @type int
     * @access private
     */
    private $TipoRotacionId;
    
    public function __construct(){
    }
    
    public function setDb(){
        $this->db = Factory::createDbo();
    }
    
    public function getCodigomateria() {
        return $this->codigomateria;
    }

    public function getNombrecortomateria() {
        return $this->nombrecortomateria;
    }

    public function getNombremateria() {
        return $this->nombremateria;
    }

    public function getNumerocreditos() {
        return $this->numerocreditos;
    }

    public function getCodigoperiodo() {
        return $this->codigoperiodo;
    }

    public function getNotaminimaaprobatoria() {
        return $this->notaminimaaprobatoria;
    }

    public function getNotaminimahabilitacion() {
        return $this->notaminimahabilitacion;
    }

    public function getNumerosemana() {
        return $this->numerosemana;
    }

    public function getNumerohorassemanales() {
        return $this->numerohorassemanales;
    }

    public function getPorcentajeteoricamateria() {
        return $this->porcentajeteoricamateria;
    }

    public function getPorcentajepracticamateria() {
        return $this->porcentajepracticamateria;
    }

    public function getPorcentajefallasteoriamodalidadmateria() {
        return $this->porcentajefallasteoriamodalidadmateria;
    }

    public function getPorcentajefallaspracticamodalidadmateria() {
        return $this->porcentajefallaspracticamodalidadmateria;
    }

    public function getCodigomodalidadmateria() {
        return $this->codigomodalidadmateria;
    }

    public function getCodigolineaacademica() {
        return $this->codigolineaacademica;
    }

    public function getCodigocarrera() {
        return $this->codigocarrera;
    }

    public function getCodigoindicadorgrupomateria() {
        return $this->codigoindicadorgrupomateria;
    }

    public function getCodigotipomateria() {
        return $this->codigotipomateria;
    }

    public function getCodigoestadomateria() {
        return $this->codigoestadomateria;
    }

    public function getUlasa() {
        return $this->ulasa;
    }

    public function getUlasb() {
        return $this->ulasb;
    }

    public function getUlasc() {
        return $this->ulasc;
    }

    public function getCodigoindicadorcredito() {
        return $this->codigoindicadorcredito;
    }

    public function getCodigoindicadoretiquetamateria() {
        return $this->codigoindicadoretiquetamateria;
    }

    public function getCodigotipocalificacionmateria() {
        return $this->codigotipocalificacionmateria;
    }

    public function getSesionesmateria() {
        return $this->sesionesmateria;
    }

    public function getTipoRotacionId() {
        return $this->TipoRotacionId;
    }

    public function setCodigomateria($codigomateria) {
        $this->codigomateria = $codigomateria;
    }

    public function setNombrecortomateria($nombrecortomateria) {
        $this->nombrecortomateria = $nombrecortomateria;
    }

    public function setNombremateria($nombremateria) {
        $this->nombremateria = $nombremateria;
    }

    public function setNumerocreditos($numerocreditos) {
        $this->numerocreditos = $numerocreditos;
    }

    public function setCodigoperiodo($codigoperiodo) {
        $this->codigoperiodo = $codigoperiodo;
    }

    public function setNotaminimaaprobatoria($notaminimaaprobatoria) {
        $this->notaminimaaprobatoria = $notaminimaaprobatoria;
    }

    public function setNotaminimahabilitacion($notaminimahabilitacion) {
        $this->notaminimahabilitacion = $notaminimahabilitacion;
    }

    public function setNumerosemana($numerosemana) {
        $this->numerosemana = $numerosemana;
    }

    public function setNumerohorassemanales($numerohorassemanales) {
        $this->numerohorassemanales = $numerohorassemanales;
    }

    public function setPorcentajeteoricamateria($porcentajeteoricamateria) {
        $this->porcentajeteoricamateria = $porcentajeteoricamateria;
    }

    public function setPorcentajepracticamateria($porcentajepracticamateria) {
        $this->porcentajepracticamateria = $porcentajepracticamateria;
    }

    public function setPorcentajefallasteoriamodalidadmateria($porcentajefallasteoriamodalidadmateria) {
        $this->porcentajefallasteoriamodalidadmateria = $porcentajefallasteoriamodalidadmateria;
    }

    public function setPorcentajefallaspracticamodalidadmateria($porcentajefallaspracticamodalidadmateria) {
        $this->porcentajefallaspracticamodalidadmateria = $porcentajefallaspracticamodalidadmateria;
    }

    public function setCodigomodalidadmateria($codigomodalidadmateria) {
        $this->codigomodalidadmateria = $codigomodalidadmateria;
    }

    public function setCodigolineaacademica($codigolineaacademica) {
        $this->codigolineaacademica = $codigolineaacademica;
    }

    public function setCodigocarrera($codigocarrera) {
        $this->codigocarrera = $codigocarrera;
    }

    public function setCodigoindicadorgrupomateria($codigoindicadorgrupomateria) {
        $this->codigoindicadorgrupomateria = $codigoindicadorgrupomateria;
    }

    public function setCodigotipomateria($codigotipomateria) {
        $this->codigotipomateria = $codigotipomateria;
    }

    public function setCodigoestadomateria($codigoestadomateria) {
        $this->codigoestadomateria = $codigoestadomateria;
    }

    public function setUlasa($ulasa) {
        $this->ulasa = $ulasa;
    }

    public function setUlasb($ulasb) {
        $this->ulasb = $ulasb;
    }

    public function setUlasc($ulasc) {
        $this->ulasc = $ulasc;
    }

    public function setCodigoindicadorcredito($codigoindicadorcredito) {
        $this->codigoindicadorcredito = $codigoindicadorcredito;
    }

    public function setCodigoindicadoretiquetamateria($codigoindicadoretiquetamateria) {
        $this->codigoindicadoretiquetamateria = $codigoindicadoretiquetamateria;
    }

    public function setCodigotipocalificacionmateria($codigotipocalificacionmateria) {
        $this->codigotipocalificacionmateria = $codigotipocalificacionmateria;
    }

    public function setSesionesmateria($sesionesmateria) {
        $this->sesionesmateria = $sesionesmateria;
    }

    public function setTipoRotacionId($TipoRotacionId) {
        $this->TipoRotacionId = $TipoRotacionId;
    }
    
    public function getById(){
        if(!empty($this->codigomateria)){
            $query = "SELECT * FROM materia "
                    ." WHERE codigomateria = ".$this->db->qstr($this->codigomateria);
            
            $datos = $this->db->Execute($query);
            $d = $datos->FetchRow();
            
            if(!empty($d)){
                $this->nombrecortomateria = $d['nombrecortomateria'];
                $this->nombremateria = $d['nombremateria'];
                $this->numerocreditos = $d['numerocreditos'];
                $this->codigoperiodo = $d['codigoperiodo'];
                $this->notaminimaaprobatoria = $d['notaminimaaprobatoria'];
                $this->notaminimahabilitacion = $d['notaminimahabilitacion'];
                $this->numerosemana = $d['numerosemana'];
                $this->numerohorassemanales = $d['numerohorassemanales'];
                $this->porcentajeteoricamateria = $d['porcentajeteoricamateria'];
                $this->porcentajepracticamateria = $d['porcentajepracticamateria'];
                $this->porcentajefallasteoriamodalidadmateria = $d['porcentajefallasteoriamodalidadmateria'];
                $this->porcentajefallaspracticamodalidadmateria = $d['porcentajefallaspracticamodalidadmateria'];
                $this->codigomodalidadmateria = $d['codigomodalidadmateria'];
                $this->codigolineaacademica = $d['codigolineaacademica'];
                $this->codigocarrera = $d['codigocarrera'];
                $this->codigoindicadorgrupomateria = $d['codigoindicadorgrupomateria'];
                $this->codigotipomateria = $d['codigotipomateria'];
                $this->codigoestadomateria = $d['codigoestadomateria'];
                $this->ulasa = $d['ulasa'];
                $this->ulasb = $d['ulasb'];
                $this->ulasc = $d['ulasc'];
                $this->codigoindicadorcredito = $d['codigoindicadorcredito'];
                $this->codigoindicadoretiquetamateria = $d['codigoindicadoretiquetamateria'];
                $this->codigotipocalificacionmateria = $d['codigotipocalificacionmateria'];
                $this->sesionesmateria = $d['sesionesmateria'];
                $this->TipoRotacionId = $d['TipoRotacionId'];
            }
        }
    }
    
    public static function getList($where=null){
        $db = Factory::createDbo();
        
        $return = array();
        
        $query = "SELECT * "
                . " FROM materia "
                . " WHERE 1";
        
        if(!empty($where)){
            $query .= " AND ".$where;
        }
        
        $datos = $db->Execute($query);
        while($d = $datos->FetchRow()){
            $Materia = new Materia();
            $Materia->codigomateria = $d['codigomateria']; 
            $Materia->nombrecortomateria = $d['nombrecortomateria'];
            $Materia->nombremateria = $d['nombremateria'];
            $Materia->numerocreditos = $d['numerocreditos'];
            $Materia->codigoperiodo = $d['codigoperiodo'];
            $Materia->notaminimaaprobatoria = $d['notaminimaaprobatoria'];
            $Materia->notaminimahabilitacion = $d['notaminimahabilitacion'];
            $Materia->numerosemana = $d['numerosemana'];
            $Materia->numerohorassemanales = $d['numerohorassemanales'];
            $Materia->porcentajeteoricamateria = $d['porcentajeteoricamateria'];
            $Materia->porcentajepracticamateria = $d['porcentajepracticamateria'];
            $Materia->porcentajefallasteoriamodalidadmateria = $d['porcentajefallasteoriamodalidadmateria'];
            $Materia->porcentajefallaspracticamodalidadmateria = $d['porcentajefallaspracticamodalidadmateria'];
            $Materia->codigomodalidadmateria = $d['codigomodalidadmateria'];
            $Materia->codigolineaacademica = $d['codigolineaacademica'];
            $Materia->codigocarrera = $d['codigocarrera'];
            $Materia->codigoindicadorgrupomateria = $d['codigoindicadorgrupomateria'];
            $Materia->codigotipomateria = $d['codigotipomateria'];
            $Materia->codigoestadomateria = $d['codigoestadomateria'];
            $Materia->ulasa = $d['ulasa'];
            $Materia->ulasb = $d['ulasb'];
            $Materia->ulasc = $d['ulasc'];
            $Materia->codigoindicadorcredito = $d['codigoindicadorcredito'];
            $Materia->codigoindicadoretiquetamateria = $d['codigoindicadoretiquetamateria'];
            $Materia->codigotipocalificacionmateria = $d['codigotipocalificacionmateria'];
            $Materia->sesionesmateria = $d['sesionesmateria'];
            $Materia->TipoRotacionId = $d['TipoRotacionId'];
            $return[] = $Materia;
            unset($Materia);
        }
        return $return;
    }


}
/*/
codigomateria	int(11)
nombrecortomateria	varchar(15)
nombremateria	varchar(52)
numerocreditos	smallint(6)
codigoperiodo	varchar(8)
notaminimaaprobatoria	decimal(5,2)
notaminimahabilitacion	decimal(5,2)
numerosemana	smallint(6)
numerohorassemanales	smallint(6)
porcentajeteoricamateria	int(3)
porcentajepracticamateria	int(3)
porcentajefallasteoriamodalidadmateria	int(3)
porcentajefallaspracticamodalidadmateria	int(3)
codigomodalidadmateria	char(2)
codigolineaacademica	char(3)
codigocarrera	int(11)
codigoindicadorgrupomateria	char(3)
codigotipomateria	char(2)
codigoestadomateria	char(2)
ulasa	varchar(10)
ulasb	varchar(10)
ulasc	varchar(10)
codigoindicadorcredito	char(3)
codigoindicadoretiquetamateria	char(3)
codigotipocalificacionmateria	char(3)
sesionesmateria	smallint(6)
TipoRotacionId	int(11)
/**/