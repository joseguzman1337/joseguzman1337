<?php
/**
 * @author Andres Ariza <arizaandres@unbosque.edu.do>
 * @copyright Universidad el Bosque - Dirección de Tecnología
 * @package entidad
 * 
*/
defined('_EXEC') or die;
class EstudianteDocumento implements Entidad{
    /**
     * @type adodb Object
     * @access private
     */
    private $db;
    
    /**
     * @type int
     * @access private
     */
    private $idestudiantedocumento;
    
    /**
     * @type int
     * @access private
     */
    private $idestudiantegeneral;
    
    /**
     * @type String
     * @access private
     */
    private $tipodocumento;
    
    /**
     * @type String
     * @access private
     */
    private $numerodocumento;
    
    /**
     * @type String
     * @access private
     */
    private $expedidodocumento;
    
    /**
     * @type Date
     * @access private
     */
    private $fechainicioestudiantedocumento;
    
    /**
     * @type Date
     * @access private
     */
    private $fechavencimientoestudiantedocumento;
    
    public function __construct(){}
    
    public function setDb(){
        $this->db = Factory::createDbo();
    }
    
    public function getIdestudiantedocumento() {
        return $this->idestudiantedocumento;
    }

    public function getIdestudiantegeneral() {
        return $this->idestudiantegeneral;
    }

    public function getTipodocumento() {
        return $this->tipodocumento;
    }

    public function getNumerodocumento() {
        return $this->numerodocumento;
    }

    public function getExpedidodocumento() {
        return $this->expedidodocumento;
    }

    public function getFechainicioestudiantedocumento() {
        return $this->fechainicioestudiantedocumento;
    }

    public function getFechavencimientoestudiantedocumento() {
        return $this->fechavencimientoestudiantedocumento;
    }

    public function setIdestudiantedocumento($idestudiantedocumento) {
        $this->idestudiantedocumento = $idestudiantedocumento;
    }

    public function setIdestudiantegeneral($idestudiantegeneral) {
        $this->idestudiantegeneral = $idestudiantegeneral;
    }

    public function setTipodocumento($tipodocumento) {
        $this->tipodocumento = $tipodocumento;
    }

    public function setNumerodocumento($numerodocumento) {
        $this->numerodocumento = $numerodocumento;
    }

    public function setExpedidodocumento($expedidodocumento) {
        $this->expedidodocumento = $expedidodocumento;
    }

    public function setFechainicioestudiantedocumento($fechainicioestudiantedocumento) {
        $this->fechainicioestudiantedocumento = $fechainicioestudiantedocumento;
    }

    public function setFechavencimientoestudiantedocumento($fechavencimientoestudiantedocumento) {
        $this->fechavencimientoestudiantedocumento = $fechavencimientoestudiantedocumento;
    }

    public function getById() {
        if(!empty($this->idestudiantedocumento)){
            $query = "SELECT * FROM estudiantedocumento "
                    . "WHERE idestudiantedocumento = ".$this->db->qstr($this->idestudiantedocumento);
            
            $datos = $this->db->Execute($query);
            $d = $datos->FetchRow();
            
            if(!empty($d)){
                $this->idestudiantegeneral = $d['idestudiantegeneral'];
                $this->tipodocumento = $d['tipodocumento'];
                $this->numerodocumento = $d['numerodocumento'];
                $this->expedidodocumento = $d['expedidodocumento'];
                $this->fechainicioestudiantedocumento = $d['fechainicioestudiantedocumento'];
                $this->fechavencimientoestudiantedocumento = $d['fechavencimientoestudiantedocumento'];
            }
        }
    }

    public static function getList($where=null){
        $db = Factory::createDbo();
        
        $return = array();
        
        $query = "SELECT * "
                . " FROM estudiantedocumento "
                . " WHERE 1";
        
        if(!empty($where)){
            $query .= " AND ".$where;
        }
        
        $datos = $db->Execute($query);
        while($d = $datos->FetchRow()){
            $EstudianteDocumento = new EstudianteDocumento();
            $EstudianteDocumento->idestudiantedocumento = $d['idestudiantedocumento'];
            $EstudianteDocumento->idestudiantegeneral = $d['idestudiantegeneral'];
            $EstudianteDocumento->tipodocumento = $d['tipodocumento'];
            $EstudianteDocumento->numerodocumento = $d['numerodocumento'];
            $EstudianteDocumento->expedidodocumento = $d['expedidodocumento'];
            $EstudianteDocumento->fechainicioestudiantedocumento = $d['fechainicioestudiantedocumento'];
            $EstudianteDocumento->fechavencimientoestudiantedocumento = $d['fechavencimientoestudiantedocumento'];
            $return[] = $EstudianteDocumento;
            unset($EstudianteDocumento);
        }
        return $return;
    }

}
/*/
idestudiantedocumento	int(11)
idestudiantegeneral	int(11)
tipodocumento	char(2)
numerodocumento	varchar(15)
expedidodocumento	varchar(30)
fechainicioestudiantedocumento	date
fechavencimientoestudiantedocumento	date
/**/