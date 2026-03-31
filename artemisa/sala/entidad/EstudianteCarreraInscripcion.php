<?php
//namespace Sala\entidad;

defined('_EXEC') or die;

//use \Sala\lib\Factory;

/**
 * @author Andres Ariza <arizaandres@unbosque.edu.do>
 * @copyright Universidad el Bosque - Dirección de Tecnología
 * @package entidad
 * 
*/
class EstudianteCarreraInscripcion implements Entidad {// \Sala\interfaces\Entidad {
    /**
     * @type adodb Object
     * @access private
     */
    private $db;

    /**
     * @type int
     * @access private
     */
    private $idestudiantecarrerainscripcion;

    /**
     * @type int
     * @access private
     */
    private $codigocarrera;

    /**
     * @type string
     * @access private
     */
    private $codigoestado;

    /**
     * @type int
     * @access private
     */
    private $idestudiantegeneral;

    /**
     * @type int
     * @access private
     */
    private $idinscripcion;

    /**
     * @type int
     * @access private
     */
    private $idnumeroopcion;

    public function __construct() {
    }
    
    public function setDb(){
        $this->db = Factory::createDbo();
    }

    public function getIdestudiantecarrerainscripcion() {
        return $this->idestudiantecarrerainscripcion;
    }
    
    public function getCodigocarrera() {
        return $this->codigocarrera;
    }

    public function getCodigoestado() {
        return $this->codigoestado;
    }

    public function getIdestudiantegeneral() {
        return $this->idestudiantegeneral;
    }

    public function getIdinscripcion() {
        return $this->idinscripcion;
    }

    public function getIdnumeroopcion() {
        return $this->idnumeroopcion;
    }

    public function setIdestudiantecarrerainscripcion($idestudiantecarrerainscripcion) {
        $this->idestudiantecarrerainscripcion = $idestudiantecarrerainscripcion;
    }

    public function setCodigocarrera($codigocarrera) {
        $this->codigocarrera = $codigocarrera;
    }

    public function setCodigoestado($codigoestado) {
        $this->codigoestado = $codigoestado;
    }

    public function setIdestudiantegeneral($idestudiantegeneral) {
        $this->idestudiantegeneral = $idestudiantegeneral;
    }

    public function setIdinscripcion($idinscripcion) {
        $this->idinscripcion = $idinscripcion;
    }

    public function setIdnumeroopcion($idnumeroopcion) {
        $this->idnumeroopcion = $idnumeroopcion;
    }

    public function getById() {
        if(!empty($this->idestudiantecarrerainscripcion)){
            $query = "SELECT * FROM estudiantecarrerainscripcion"
                    ." WHERE idestudiantecarrerainscripcion = ".$this->db->qstr($this->idestudiantecarrerainscripcion);
            $datos = $this->db->Execute($query);
            $d = $datos->FetchRow();
            
            if(!empty($d)){ 
                $this->codigocarrera = $d['codigocarrera'];
                $this->codigoestado = $d['codigoestado'];
                $this->idestudiantegeneral = $d['idestudiantegeneral'];
                $this->idinscripcion = $d['idinscripcion'];
                $this->idnumeroopcion = $d['idnumeroopcion'];
            }  
        }
    }
    
    
    public static function getByIdInscripcionEstudiante($idInscripcion, $idEstudianteGeneral=null, $codigoCarrera=null){
        
        $db = Factory::createDbo();
        
        $return = array();
        $where = array();
        
        $where[] = " idinscripcion = ".$db->qstr($idInscripcion);
        
        if(!empty($idEstudianteGeneral)){
            $where[] = " idestudiantegeneral = ".$db->qstr($idEstudianteGeneral);
        }
        
        if(!empty($codigoCarrera)){
            $where[] = " codigocarrera = ".$db->qstr($codigoCarrera);
        }
        
        $query = "SELECT * FROM estudiantecarrerainscripcion "
                ." WHERE ".implode(" AND ",$where);
        $datos = $db->Execute($query);
        
        while($d = $datos->FetchRow()){
            $EstudianteCarreraInscripcion = new EstudianteCarreraInscripcion();
             
            $EstudianteCarreraInscripcion->setIdestudiantecarrerainscripcion($d['idestudiantecarrerainscripcion']);
            $EstudianteCarreraInscripcion->setCodigocarrera( $d['codigocarrera'] );
            $EstudianteCarreraInscripcion->setCodigoestado( $d['codigoestado'] );
            $EstudianteCarreraInscripcion->setIdestudiantegeneral( $d['idestudiantegeneral'] );
            $EstudianteCarreraInscripcion->setIdinscripcion( $d['idinscripcion'] );
            $EstudianteCarreraInscripcion->setIdnumeroopcion( $d['idnumeroopcion'] );
            
            $return[] = $EstudianteCarreraInscripcion;
            unset($EstudianteCarreraInscripcion);
        }
        return $return;
    }

    /**
     * 
     * @param where
     */
    public static function getList($where = null) {
        
        $db = Factory::createDbo();
        
        $return = array();
        
        $query = "SELECT * "
                . " FROM estudiantecarrerainscripcion ";
        if(!empty($where)){
            $query .= " WHERE ".$where;
         }
        $datos = $db->Execute($query);
        
        while($d = $datos->FetchRow()){
            $EstudianteCarreraInscripcion = new EstudianteCarreraInscripcion();
             
            $EstudianteCarreraInscripcion->setIdestudiantecarrerainscripcion($d['idestudiantecarrerainscripcion']);
            $EstudianteCarreraInscripcion->setCodigocarrera( $d['codigocarrera'] );
            $EstudianteCarreraInscripcion->setCodigoestado( $d['codigoestado'] );
            $EstudianteCarreraInscripcion->setIdestudiantegeneral( $d['idestudiantegeneral'] );
            $EstudianteCarreraInscripcion->setIdinscripcion( $d['idinscripcion'] );
            $EstudianteCarreraInscripcion->setIdnumeroopcion( $d['idnumeroopcion'] );
            
            $return[] = $EstudianteCarreraInscripcion;
            unset($EstudianteCarreraInscripcion);
        }
        return $return;
    }

}
