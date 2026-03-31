<?php
/**
 * @author Quintrero Ivan <quintreroivan@unbosque.edu.do>
 * @copyright Universidad el Bosque - Dirección de Tecnología
 * @package entidad
*/

defined('_EXEC') or die;
class SiqAinstrumentoconfiguracion implements Entidad{
    /**
     * @var adodb Object
     * @access private
     */
    private $db;
    
    private $idsiq_Ainstrumentoconfiguracion;
    
    private $nombre;
    
    private $mostrar_bienvenida;
    
    private $mostrar_despedida;
    
    private $fecha_inicio;
    
    private $fecha_fin;
    
    private $estado;
    
    private $secciones;
    
    private $idsiq_discriminacionIndicador;
    
    private $codigocarrera;
    
    private $idsiq_periodicidad;
    
    private $codigomodalidadacademica;
    
    private $codigoestado;
    
    private $usuariocreacion;
    
    private $usuariomodificacion;
    
    private $fechacreacion;
    
    private $ip;
    
    private $aprobada;
    
    private $cat_ins;
    
    public function __construct(){
    }
    
    public function setDb(){
        $this->db = Factory::createDbo();
    }
    
    public function getIdsiq_Ainstrumentoconfiguracion() {
        return $this->idsiq_Ainstrumentoconfiguracion;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getMostrar_bienvenida() {
        return $this->mostrar_bienvenida;
    }

    public function getMostrar_despedida() {
        return $this->mostrar_despedida;
    }

    public function getFecha_inicio() {
        return $this->fecha_inicio;
    }

    public function getFecha_fin() {
        return $this->fecha_fin;
    }

    public function getEstado() {
        return $this->estado;
    }

    public function getSecciones() {
        return $this->secciones;
    }

    public function getIdsiq_discriminacionIndicador() {
        return $this->idsiq_discriminacionIndicador;
    }

    public function getCodigocarrera() {
        return $this->codigocarrera;
    }
    
    public function getIdsiq_periodicidad(){
        return $this->idsiq_periodicidad;
    }
    
    public function getCodigomodalidadacademica(){
        return $this->codigomodalidadacademica;
    }

    public function getUsuariocreacion(){
        return $this->usuariocreacion;
    }
    
    public function getUsuariomodificacion(){
        return $this->usuariomodificacion;
    }
    
    public function getFechacreacion(){
        return $this->fechacreacion;
    }
    
    public function getIp(){
        return $this->ip;
    }
    
    public function getAprobada(){
        return $this->aprobada;
    }
    
    public function getCat_ins(){
        return $this->cat_ins;
    }
    
    public function setIdsiq_Ainstrumentoconfiguracion($idsiq_Ainstrumentoconfiguracion) {
        $this->idsiq_Ainstrumentoconfiguracion = $idsiq_Ainstrumentoconfiguracion;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function setMostrar_bienvenida($mostrar_bienvenida) {
        $this->mostrar_bienvenida = $mostrar_bienvenida;
    }

    public function setMostrar_despedida($mostrar_despedida) {
        $this->mostrar_despedida = $mostrar_despedida;
    }

    public function setFecha_inicio($fecha_inicio) {
        $this->fecha_inicio = $fecha_inicio;
    }

    public function setFecha_fin($fecha_fin) {
        $this->fecha_fin = $fecha_fin;
    }

    public function setEstado($estado) {
        $this->estado = $estado;
    }

    public function setSecciones($secciones) {
        $this->secciones = $secciones;
    }

    public function setIdsiq_discriminacionIndicador($idsiq_discriminacionIndicador) {
        $this->idsiq_discriminacionIndicador = $idsiq_discriminacionIndicador;
    }
    
    public function setCodigocarrera ($codigocarrera){
        $this->codigocarrera = $codigocarrera;
    }

    public function setIdsiq_periodicidad($idsiq_periodicidad){
        $this->idsiq_periodicidad = $idsiq_periodicidad;
    }

    public function setCodigomodalidadacademica($codigomodalidadacademica){
        $this->codigomodalidadacademica = $codigomodalidadacademica;
    }

    public function setUsuariocreacion($usuariocreacion){
        $this->usuariocreacion = $usuariocreacion;
    }

    public function setUsuariomodificacion($usuariomodificacion){
        $this->usuariomodificacion = $usuariomodificacion;
    }
    
    public function setFechacreacion($fechacreacion){
        $this->fechacreacion = $fechacreacion;
    }
   
    public function setIp($ip){
        $this->ip = $ip;
    }
    
    public function setAprobada($aprobada){
        $this->aprobada = $aprobada;
    }   
    
    public function setCat_ins($cat_ins){
        $this->cat_ins = $cat_ins;
    }
    
    public function getById() {
        if(!empty($this->idsiq_Ainstrumentoconfiguracion)){
            $query = "SELECT * FROM siq_Ainstrumentoconfiguracion "
                    ." WHERE idsiq_Ainstrumentoconfiguracion = ".$this->db->qstr($this->idsiq_Ainstrumentoconfiguracion);
            $datos = $this->db->Execute($query);
            $d = $datos->FetchRow();
            
            if(!empty($d)){
                $this->nombre = $d['nombre']; 
                $this->mostrar_bienvenida = $d['mostrar_bienvenida']; 
                $this->mostrar_despedida = $d['mostrar_despedida']; 
                $this->fecha_inicio = $d['fecha_inicio']; 
                $this->fecha_fin = $d['fecha_fin']; 
                $this->estado = $d['estado']; 
                $this->secciones = $d['secciones']; 
                $this->idsiq_discriminacionIndicador = $d['idsiq_discriminacionIndicador']; 
                $this->codigocarrera = $d['codigocarrera']; 
                $this->idsiq_periodicidad = $d['idsiq_periodicidad']; 
                $this->codigomodalidadacademica = $d['codigomodalidadacademica']; 
                $this->codigoestado = $d['codigoestado']; 
                $this->usuariocreacion = $d['usuariocreacion']; 
                $this->usuariomodificacion = $d['usuariomodificacion']; 
                $this->fechacreacion = $d['fechacreacion']; 
                $this->fechamodificacion = $d['fechamodificacion']; 
                $this->ip = $d['ip']; 
                $this->aprobada = $d['aprobada']; 
                $this->cat_ins = $d['cat_ins']; 
            }
        }
    }

    public static function getList($where = null, $inner = null, $distinct = false, $orderBy = null) {
        $db = Factory::createDbo();
        $return = array();
        
        $query = "SELECT ";
        if($distinct){
            $query .= "DISTINCT siq_Ainstrumentoconfiguracion.";
        }
        $query .= "* "
                . " FROM siq_Ainstrumentoconfiguracion " ;
        if(!empty($inner)){
            $query .=  $inner;
        }
        if(!empty($where)){
            $query .= " WHERE ".$where;
        }
        if(!empty($orderBy)){
            $query .= " ORDER BY ".$orderBy;
        }
        //d($query);
        $datos = $db->Execute($query);
        while($d = $datos->FetchRow()){
            $SiqAinstrumentoconfiguracion = new siqAinstrumentoconfiguracion();
            $SiqAinstrumentoconfiguracion->idsiq_Ainstrumentoconfiguracion = $d['idsiq_Ainstrumentoconfiguracion'];
            $SiqAinstrumentoconfiguracion->nombre = $d['nombre']; 
            $SiqAinstrumentoconfiguracion->mostrar_bienvenida = $d['mostrar_bienvenida']; 
            $SiqAinstrumentoconfiguracion->mostrar_despedida = $d['mostrar_despedida']; 
            $SiqAinstrumentoconfiguracion->fecha_fin = $d['fecha_fin']; 
            $SiqAinstrumentoconfiguracion->estado = $d['estado']; 
            $SiqAinstrumentoconfiguracion->secciones = $d['secciones']; 
            $SiqAinstrumentoconfiguracion->idsiq_discriminacionIndicador = $d['idsiq_discriminacionIndicador']; 
            $SiqAinstrumentoconfiguracion->codigocarrera = $d['codigocarrera']; 
            $SiqAinstrumentoconfiguracion->idsiq_periodicidad = $d['idsiq_periodicidad']; 
            $SiqAinstrumentoconfiguracion->codigomodalidadacademica = $d['codigomodalidadacademica']; 
            $SiqAinstrumentoconfiguracion->codigoestado = $d['codigoestado']; 
            $SiqAinstrumentoconfiguracion->usuariocreacion = $d['usuariocreacion']; 
            $SiqAinstrumentoconfiguracion->usuariomodificacion = $d['usuariomodificacion']; 
            $SiqAinstrumentoconfiguracion->fechacreacion = $d['fechacreacion']; 
            $SiqAinstrumentoconfiguracion->fechamodificacion = $d['fechamodificacion']; 
            $SiqAinstrumentoconfiguracion->ip = $d['ip']; 
            $SiqAinstrumentoconfiguracion->aprobada = $d['aprobada']; 
            $SiqAinstrumentoconfiguracion->cat_ins = $d['cat_ins'];
            
            $return[] = $SiqAinstrumentoconfiguracion;
        }
        return $return;
    }
}
