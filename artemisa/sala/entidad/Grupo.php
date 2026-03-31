<?php
/**
 * @author Andres Ariza <arizaandres@unbosque.edu.do>
 * @copyright Universidad el Bosque - Dirección de Tecnología
 * @package entidad
*/
defined('_EXEC') or die;
class Grupo implements Entidad{
    /**
     * @type adodb Object
     * @access private
     */
    private $db;
    
    /**
     * @type int
     * @access private
     */
    private $idgrupo;
    
    /**
     * @type String
     * @access private
     */
    private $codigogrupo;
    
    /**
     * @type String
     * @access private
     */
    private $nombregrupo;
    
    /**
     * @type int
     * @access private
     */
    private $codigomateria;
    
    /**
     * @type String
     * @access private
     */
    private $codigoperiodo;
    
    /**
     * @type String
     * @access private
     */
    private $numerodocumento;
    
    /**
     * @type int
     * @access private
     */
    private $maximogrupo;
    
    /**
     * @type int
     * @access private
     */
    private $matriculadosgrupo;
    
    /**
     * @type int
     * @access private
     */
    private $maximogrupoelectiva;
    
    /**
     * @type int
     * @access private
     */
    private $matriculadosgrupoelectiva;
    
    /**
     * @type String
     * @access private
     */
    private $codigoestadogrupo;
    
    /**
     * @type String
     * @access private
     */
    private $codigoindicadorhorario;
    
    /**
     * @type Date
     * @access private
     */
    private $fechainiciogrupo;
    
    /**
     * @type Date
     * @access private
     */
    private $fechafinalgrupo;
    
    public function __construct(){
    }
    
    public function setDb(){
        $this->db = Factory::createDbo();
    }
    public function getIdgrupo() {
        return $this->idgrupo;
    }

    public function getCodigogrupo() {
        return $this->codigogrupo;
    }

    public function getNombregrupo() {
        return $this->nombregrupo;
    }

    public function getCodigomateria() {
        return $this->codigomateria;
    }

    public function getCodigoperiodo() {
        return $this->codigoperiodo;
    }

    public function getNumerodocumento() {
        return $this->numerodocumento;
    }

    public function getMaximogrupo() {
        return $this->maximogrupo;
    }

    public function getMatriculadosgrupo() {
        return $this->matriculadosgrupo;
    }

    public function getMaximogrupoelectiva() {
        return $this->maximogrupoelectiva;
    }

    public function getMatriculadosgrupoelectiva() {
        return $this->matriculadosgrupoelectiva;
    }

    public function getCodigoestadogrupo() {
        return $this->codigoestadogrupo;
    }

    public function getCodigoindicadorhorario() {
        return $this->codigoindicadorhorario;
    }

    public function getFechainiciogrupo() {
        return $this->fechainiciogrupo;
    }

    public function getFechafinalgrupo() {
        return $this->fechafinalgrupo;
    }

    public function setIdgrupo($idgrupo) {
        $this->idgrupo = $idgrupo;
    }

    public function setCodigogrupo($codigogrupo) {
        $this->codigogrupo = $codigogrupo;
    }

    public function setNombregrupo($nombregrupo) {
        $this->nombregrupo = $nombregrupo;
    }

    public function setCodigomateria($codigomateria) {
        $this->codigomateria = $codigomateria;
    }

    public function setCodigoperiodo($codigoperiodo) {
        $this->codigoperiodo = $codigoperiodo;
    }

    public function setNumerodocumento($numerodocumento) {
        $this->numerodocumento = $numerodocumento;
    }

    public function setMaximogrupo($maximogrupo) {
        $this->maximogrupo = $maximogrupo;
    }

    public function setMatriculadosgrupo($matriculadosgrupo) {
        $this->matriculadosgrupo = $matriculadosgrupo;
    }

    public function setMaximogrupoelectiva($maximogrupoelectiva) {
        $this->maximogrupoelectiva = $maximogrupoelectiva;
    }

    public function setMatriculadosgrupoelectiva($matriculadosgrupoelectiva) {
        $this->matriculadosgrupoelectiva = $matriculadosgrupoelectiva;
    }

    public function setCodigoestadogrupo($codigoestadogrupo) {
        $this->codigoestadogrupo = $codigoestadogrupo;
    }

    public function setCodigoindicadorhorario($codigoindicadorhorario) {
        $this->codigoindicadorhorario = $codigoindicadorhorario;
    }

    public function setFechainiciogrupo($fechainiciogrupo) {
        $this->fechainiciogrupo = $fechainiciogrupo;
    }

    public function setFechafinalgrupo($fechafinalgrupo) {
        $this->fechafinalgrupo = $fechafinalgrupo;
    }

    public function getById() {
        if(!empty($this->idgrupo)){
            $query = "SELECT * FROM grupo "
                    ." WHERE idgrupo = ".$this->db->qstr($this->idgrupo);
            
            $datos = $this->db->Execute($query);
            $d = $datos->FetchRow();
            
            if(!empty($d)){
                $this->codigogrupo = $d['codigogrupo'];
                $this->nombregrupo = $d['nombregrupo'];
                $this->codigomateria = $d['codigomateria'];
                $this->codigoperiodo = $d['codigoperiodo'];
                $this->numerodocumento = $d['numerodocumento'];
                $this->maximogrupo = $d['maximogrupo'];
                $this->matriculadosgrupo = $d['matriculadosgrupo'];
                $this->maximogrupoelectiva = $d['maximogrupoelectiva'];
                $this->matriculadosgrupoelectiva = $d['matriculadosgrupoelectiva'];
                $this->codigoestadogrupo = $d['codigoestadogrupo'];
                $this->codigoindicadorhorario = $d['codigoindicadorhorario'];
                $this->fechainiciogrupo = $d['fechainiciogrupo'];
                $this->fechafinalgrupo = $d['fechafinalgrupo'];
            }
            //d($this);
        }
    }

    public static function getList($where=null) {
        $db = Factory::createDbo();
        
        $return = array();
        
        $query = "SELECT * "
                . " FROM grupo "
                . " WHERE 1";
        
        if(!empty($where)){
            $query .= " AND ".$where;
        }
        
        $datos = $db->Execute($query);
        while($d = $datos->FetchRow()){
            $Grupo = new Grupo();
            $Grupo->idgrupo = $d['idgrupo'];
            $Grupo->codigogrupo = $d['codigogrupo'];
            $Grupo->nombregrupo = $d['nombregrupo'];
            $Grupo->codigomateria = $d['codigomateria'];
            $Grupo->codigoperiodo = $d['codigoperiodo'];
            $Grupo->numerodocumento = $d['numerodocumento'];
            $Grupo->maximogrupo = $d['maximogrupo'];
            $Grupo->matriculadosgrupo = $d['matriculadosgrupo'];
            $Grupo->maximogrupoelectiva = $d['maximogrupoelectiva'];
            $Grupo->matriculadosgrupoelectiva = $d['matriculadosgrupoelectiva'];
            $Grupo->codigoestadogrupo = $d['codigoestadogrupo'];
            $Grupo->codigoindicadorhorario = $d['codigoindicadorhorario'];
            $Grupo->fechainiciogrupo = $d['fechainiciogrupo'];
            $Grupo->fechafinalgrupo = $d['fechafinalgrupo'];
            $return[] = $Grupo;
            unset($Grupo);
        }
        return $return;
    }

}
/*/
idgrupo	int(11)
codigogrupo	varchar(5)
nombregrupo	varchar(30)
codigomateria	int(11)
codigoperiodo	varchar(8)
numerodocumento	varchar(15)
maximogrupo	smallint(6)
matriculadosgrupo	smallint(6)
maximogrupoelectiva	smallint(6)
matriculadosgrupoelectiva	smallint(6)
codigoestadogrupo	char(2)
codigoindicadorhorario	char(3)
fechainiciogrupo	date
fechafinalgrupo	date
/**/