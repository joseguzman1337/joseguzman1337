<?php

/**
 * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package entidad
 */

/**
 * Clase encargada de la lectura de informacion de la base de datos de la tabla
 * subperiodo
 *
 * @author arizaandres
 */

namespace Sala\entidad;
defined('_EXEC') or die;

class Subperiodo  implements \Entidad{
    /**
     * @type adodb Object
     * @access private
     */
    private $db;
    
    /**
     * @type int
     * @access private
     */
    private $idsubperiodo;
    
    /**
     * @type int
     * @access private
     */
    private $idcarreraperiodo;
    
    /**
     * @type string
     * @access private
     */
    private $nombresubperiodo;
    
    /**
     * @type date
     * @access private
     */
    private $fechasubperiodo;
    
    /**
     * @typedate
     * @access private
     */
    private $fechainicioacademicosubperiodo;
    
    /**
     * @type date
     * @access private
     */
    private $fechafinalacademicosubperiodo;
    
    /**
     * @type date
     * @access private
     */
    private $fechainiciofinancierosubperiodo;
    
    /**
     * @type date
     * @access private
     */
    private $fechafinalfinancierosubperiodo;
    
    /**
     * @type string
     * @access private
     */
    private $numerosubperiodo;
    
    /**
     * @type int
     * @access private
     */
    private $idtiposubperiodo;
    
    /**
     * @type string
     * @access private
     */
    private $codigoestadosubperiodo;
    
    /**
     * @type int
     * @access private
     */
    private $idusuario;
    
    /**
     * @type string
     * @access private
     */
    private $ip;
    
    public function __construct(){
    }
    
    public function setDb(){
        $this->db = \Factory::createDbo();
    }
    
    public function getIdsubperiodo() {
        return $this->idsubperiodo;
    }

    public function getIdcarreraperiodo() {
        return $this->idcarreraperiodo;
    }

    public function getNombresubperiodo() {
        return $this->nombresubperiodo;
    }

    public function getFechasubperiodo() {
        return $this->fechasubperiodo;
    }

    public function getFechainicioacademicosubperiodo() {
        return $this->fechainicioacademicosubperiodo;
    }

    public function getFechafinalacademicosubperiodo() {
        return $this->fechafinalacademicosubperiodo;
    }

    public function getFechainiciofinancierosubperiodo() {
        return $this->fechainiciofinancierosubperiodo;
    }

    public function getFechafinalfinancierosubperiodo() {
        return $this->fechafinalfinancierosubperiodo;
    }

    public function getNumerosubperiodo() {
        return $this->numerosubperiodo;
    }

    public function getIdtiposubperiodo() {
        return $this->idtiposubperiodo;
    }

    public function getCodigoestadosubperiodo() {
        return $this->codigoestadosubperiodo;
    }

    public function getIdusuario() {
        return $this->idusuario;
    }

    public function getIp() {
        return $this->ip;
    }

    public function setIdsubperiodo($idsubperiodo) {
        $this->idsubperiodo = $idsubperiodo;
    }

    public function setIdcarreraperiodo($idcarreraperiodo) {
        $this->idcarreraperiodo = $idcarreraperiodo;
    }

    public function setNombresubperiodo($nombresubperiodo) {
        $this->nombresubperiodo = $nombresubperiodo;
    }

    public function setFechasubperiodo($fechasubperiodo) {
        $this->fechasubperiodo = $fechasubperiodo;
    }

    public function setFechainicioacademicosubperiodo($fechainicioacademicosubperiodo) {
        $this->fechainicioacademicosubperiodo = $fechainicioacademicosubperiodo;
    }

    public function setFechafinalacademicosubperiodo($fechafinalacademicosubperiodo) {
        $this->fechafinalacademicosubperiodo = $fechafinalacademicosubperiodo;
    }

    public function setFechainiciofinancierosubperiodo($fechainiciofinancierosubperiodo) {
        $this->fechainiciofinancierosubperiodo = $fechainiciofinancierosubperiodo;
    }

    public function setFechafinalfinancierosubperiodo($fechafinalfinancierosubperiodo) {
        $this->fechafinalfinancierosubperiodo = $fechafinalfinancierosubperiodo;
    }

    public function setNumerosubperiodo($numerosubperiodo) {
        $this->numerosubperiodo = $numerosubperiodo;
    }

    public function setIdtiposubperiodo($idtiposubperiodo) {
        $this->idtiposubperiodo = $idtiposubperiodo;
    }

    public function setCodigoestadosubperiodo($codigoestadosubperiodo) {
        $this->codigoestadosubperiodo = $codigoestadosubperiodo;
    }

    public function setIdusuario($idusuario) {
        $this->idusuario = $idusuario;
    }

    public function setIp($ip) {
        $this->ip = $ip;
    }

    public function getById() {
        if(!empty($this->idsubperiodo)){
            $query = "SELECT * FROM subperiodo "
                    ." WHERE idsubperiodo = ".$this->db->qstr($this->idsubperiodo);
            
            $datos = $this->db->Execute($query);
            $d = $datos->FetchRow();
            
            if(!empty($d)){
                $this->idsubperiodo = $d['idsubperiodo']; 
                $this->idcarreraperiodo = $d['idcarreraperiodo']; 
                $this->nombresubperiodo = $d['nombresubperiodo']; 
                $this->fechasubperiodo = $d['fechasubperiodo']; 
                $this->fechainicioacademicosubperiodo = $d['fechainicioacademicosubperiodo'];
                $this->fechafinalacademicosubperiodo = $d['fechafinalacademicosubperiodo'];
                $this->fechainiciofinancierosubperiodo = $d['fechainiciofinancierosubperiodo'];
                $this->fechafinalfinancierosubperiodo = $d['fechafinalfinancierosubperiodo'];
                $this->numerosubperiodo = $d['numerosubperiodo'];
                $this->idtiposubperiodo = $d['idtiposubperiodo'];
                $this->codigoestadosubperiodo = $d['codigoestadosubperiodo'];
                $this->idusuario = $d['idusuario'];
                $this->ip = $d['ip'];
            }
        }
    }

    public static function getList($where = null) {
        $db = \Factory::createDbo();        
        $return = array();        
        $query = "SELECT * "
                . " FROM subperiodo "
                . " WHERE 1";        
        if(!empty($where)){
            $query .= " AND ".$where;
        }        
        $datos = $db->Execute($query);
        while($d = $datos->FetchRow()){
            $Subperiodo = new Subperiodo();
            $Subperiodo->setIdsubperiodo($d['idsubperiodo']); 
            $Subperiodo->setIdcarreraperiodo($d['idcarreraperiodo']); 
            $Subperiodo->setNombresubperiodo($d['nombresubperiodo']); 
            $Subperiodo->setFechasubperiodo($d['fechasubperiodo']); 
            $Subperiodo->setFechainicioacademicosubperiodo($d['fechainicioacademicosubperiodo']);
            $Subperiodo->setFechafinalacademicosubperiodo($d['fechafinalacademicosubperiodo']);
            $Subperiodo->setFechainiciofinancierosubperiodo($d['fechainiciofinancierosubperiodo']);
            $Subperiodo->setFechafinalfinancierosubperiodo($d['fechafinalfinancierosubperiodo']);
            $Subperiodo->setNumerosubperiodo($d['numerosubperiodo']);
            $Subperiodo->setIdtiposubperiodo($d['idtiposubperiodo']);
            $Subperiodo->setCodigoestadosubperiodo($d['codigoestadosubperiodo']);
            $Subperiodo->setIdusuario($d['idusuario']);
            $Subperiodo->setIp($d['ip']);
            $return[] = $Subperiodo;
            unset($Subperiodo);
        }
        return $return;        
    }

}