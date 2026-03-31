<?php
/**
 * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package entidad
 */

namespace Sala\entidad;
defined('_EXEC') or die;


/**
 * Description of RelacionTablasPeriodos
 *
 * @author arizaandres
 */
class RelacionTablasPeriodos implements \Entidad {
    
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
     * @type string
     * @access private
     */
    private $tabla;

    /**
     * @type string
     * @access private
     */
    private $idTabla;

    /**
     * @type int
     * @access private
     */
    private $idPeriodoMaestro1;

    /**
     * @type int
     * @access private
     */
    private $idPeriodoMaestro2;

    /**
     * @type int
     * @access private
     */
    private $idPeriodoFinanciero;

    /**
     * @type int
     * @access private
     */
    private $idPeriodoAcademico;
    
    public function __construct(){
    }
    
    public function setDb(){
        $this->db = \Factory::createDbo();
    }
    
    public function getId() {
        return $this->id;
    }

    public function getTabla() {
        return $this->tabla;
    }

    public function getIdTabla() {
        return $this->idTabla;
    }

    public function getIdPeriodoMaestro1() {
        return $this->idPeriodoMaestro1;
    }

    public function getIdPeriodoMaestro2() {
        return $this->idPeriodoMaestro2;
    }

    public function getIdPeriodoFinanciero() {
        return $this->idPeriodoFinanciero;
    }

    public function getIdPeriodoAcademico() {
        return $this->idPeriodoAcademico;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setTabla($tabla) {
        $this->tabla = $tabla;
    }

    public function setIdTabla($idTabla) {
        $this->idTabla = $idTabla;
    }

    public function setIdPeriodoMaestro1($idPeriodoMaestro1) {
        $this->idPeriodoMaestro1 = $idPeriodoMaestro1;
    }

    public function setIdPeriodoMaestro2($idPeriodoMaestro2) {
        $this->idPeriodoMaestro2 = $idPeriodoMaestro2;
    }

    public function setIdPeriodoFinanciero($idPeriodoFinanciero) {
        $this->idPeriodoFinanciero = $idPeriodoFinanciero;
    }

    public function setIdPeriodoAcademico($idPeriodoAcademico) {
        $this->idPeriodoAcademico = $idPeriodoAcademico;
    }

        
    public function getById() {
        if(!empty($this->id)){
            $query = "SELECT * FROM relacionTablasPeriodos "
                    ." WHERE id = ".$this->db->qstr($this->id);
            
            $datos = $this->db->Execute($query);
            $d = $datos->FetchRow();
            
            if(!empty($d)){
                $this->id = $d['id']; 
                $this->tabla = $d['tabla']; 
                $this->idTabla = $d['idTabla']; 
                $this->idPeriodoMaestro1 = $d['idPeriodoMaestro1']; 
                $this->idPeriodoMaestro2 = $d['idPeriodoMaestro2'];
                $this->idPeriodoFinanciero = $d['idPeriodoFinanciero'];
                $this->idPeriodoAcademico = $d['idPeriodoAcademico'];
            }
        }
    }

    public static function getList($where) {
        $db = \Factory::createDbo();        
        $return = array();        
        $query = "SELECT * "
                . " FROM relacionTablasPeriodos "
                . " WHERE 1";        
        if(!empty($where)){
            $query .= " AND ".$where;
        }
        
        $datos = $db->Execute($query);
        while($d = $datos->FetchRow()){
            $RelacionTablasPeriodos = new RelacionTablasPeriodos();
            $RelacionTablasPeriodos->setId($d['id']); 
            $RelacionTablasPeriodos->setTabla($d['tabla']); 
            $RelacionTablasPeriodos->setIdTabla($d['idTabla']); 
            $RelacionTablasPeriodos->setIdPeriodoMaestro1($d['idPeriodoMaestro1']); 
            $RelacionTablasPeriodos->setIdPeriodoMaestro2($d['idPeriodoMaestro2']);
            $RelacionTablasPeriodos->setIdPeriodoFinanciero($d['idPeriodoFinanciero']);
            $RelacionTablasPeriodos->setIdPeriodoAcademico($d['idPeriodoAcademico']);
            $return[] = $RelacionTablasPeriodos;
            unset($RelacionTablasPeriodos);
        }
        return $return;
    }

}