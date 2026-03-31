<?php
/**
 * @author Andres Ariza <arizaandres@unbosque.edu.do>
 * @copyright Universidad el Bosque - Dirección de Tecnología
 * @package entidad
*/
defined('_EXEC') or die;
class Corte implements Entidad{
    /**
     * @type adodb Object
     * @access private
     */
    private $db;
    
    /**
     * @type int
     * @access private
     */
    private $idcorte;
    
    /**
     * @type int
     * @access private
     */
    private $codigocarrera;
    
    /**
     * @type String
     * @access private
     */
    private $codigoperiodo;
    
    /**
     * @type int
     * @access private
     */
    private $codigomateria;
    
    /**
     * @type int
     * @access private
     */
    private $numerocorte;
    
    /**
     * @type Date
     * @access private
     */
    private $fechainicialcorte;
    
    /**
     * @type Date
     * @access private
     */
    private $fechafinalcorte;
    
    /**
     * @type int
     * @access private
     */
    private $porcentajecorte;
    
    /**
     * @type String
     * @access private
     */
    private $usuario;
    
    public function __construct(){
    }

    public function setDb() {
        $this->db = Factory::createDbo();
    }
    
    public function getIdcorte() {
        return $this->idcorte;
    }

    public function getCodigocarrera() {
        return $this->codigocarrera;
    }

    public function getCodigoperiodo() {
        return $this->codigoperiodo;
    }

    public function getCodigomateria() {
        return $this->codigomateria;
    }

    public function getNumerocorte() {
        return $this->numerocorte;
    }

    public function getFechainicialcorte() {
        return $this->fechainicialcorte;
    }

    public function getFechafinalcorte() {
        return $this->fechafinalcorte;
    }

    public function getPorcentajecorte() {
        return $this->porcentajecorte;
    }

    public function getUsuario() {
        return $this->usuario;
    }

    public function setIdcorte($idcorte) {
        $this->idcorte = $idcorte;
    }

    public function setCodigocarrera($codigocarrera) {
        $this->codigocarrera = $codigocarrera;
    }

    public function setCodigoperiodo($codigoperiodo) {
        $this->codigoperiodo = $codigoperiodo;
    }

    public function setCodigomateria($codigomateria) {
        $this->codigomateria = $codigomateria;
    }

    public function setNumerocorte($numerocorte) {
        $this->numerocorte = $numerocorte;
    }

    public function setFechainicialcorte($fechainicialcorte) {
        $this->fechainicialcorte = $fechainicialcorte;
    }

    public function setFechafinalcorte($fechafinalcorte) {
        $this->fechafinalcorte = $fechafinalcorte;
    }

    public function setPorcentajecorte($porcentajecorte) {
        $this->porcentajecorte = $porcentajecorte;
    }

    public function setUsuario($usuario) {
        $this->usuario = $usuario;
    }
    
    public function getById() {
        if(!empty($this->idcorte)){
            $query = "SELECT * FROM corte "
                    ." WHERE idcorte = ".$this->db->qstr($this->idcorte);
            
            $datos = $this->db->Execute($query);
            $d = $datos->FetchRow();
            
            if(!empty($d)){
                $this->codigocarrera = $d['codigocarrera'];
                $this->codigoperiodo = $d['codigoperiodo'];
                $this->codigomateria = $d['codigomateria'];
                $this->numerocorte = $d['numerocorte'];
                $this->fechainicialcorte = $d['fechainicialcorte'];
                $this->fechafinalcorte = $d['fechafinalcorte'];
                $this->porcentajecorte = $d['porcentajecorte'];
                $this->usuario = $d['usuario'];
            }
        }
    }

    public static function getList($where=null) {
        $db = Factory::createDbo();
        
        $return = array();
        
        $query = "SELECT * "
                . " FROM corte "
                . " WHERE 1";
        
        if(!empty($where)){
            $query .= " AND ".$where;
        }
        //d($query);
        $datos = $db->Execute($query);
        while($d = $datos->FetchRow()){
            $Corte = new Corte();
            $Corte->idcorte = $d['idcorte'];
            $Corte->codigocarrera = $d['codigocarrera'];
            $Corte->codigoperiodo = $d['codigoperiodo'];
            $Corte->codigomateria = $d['codigomateria'];
            $Corte->numerocorte = $d['numerocorte'];
            $Corte->fechainicialcorte = $d['fechainicialcorte'];
            $Corte->fechafinalcorte = $d['fechafinalcorte'];
            $Corte->porcentajecorte = $d['porcentajecorte'];
                
            $return[] = $Corte;
            unset($Corte);
        }
        return $return;
    }

}
/*/
idcorte	int(11)
codigocarrera	int(11)
codigoperiodo	varchar(8)
codigomateria	int(11)
numerocorte	smallint(6)
fechainicialcorte	date
fechafinalcorte	date
porcentajecorte	smallint(6)
usuario	varchar(30)
/**/