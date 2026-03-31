<?php
/**
 * @author Andres Ariza <arizaandres@unbosque.edu.do>
 * @copyright Universidad el Bosque - Dirección de Tecnología
 * @package entidad
*/
defined('_EXEC') or die;
class ViewHistoricoNotasEstudiante implements Entidad{
    /**
     * @type adodb Object
     * @access private
     */
    private $db;
    
    /**
     * @type String
     * @access private
     */
    private $codigoperiodo;
    
    /**
     * @type int
     * @access private
     */
    private $notadefinitiva;
    
    /**
     * @type int
     * @access private
     */
    private $numerocreditos;
    
    /**
     * @type int
     * @access private
     */
    private $idestudiantegeneral;
    
    /**
     * @type int
     * @access private
     */
    private $codigoestudiante;
    
    public function __construct(){
    }

    public function setDb() {
        $this->db = Factory::createDbo();
    }
    
    public function getCodigoperiodo() {
        return $this->codigoperiodo;
    }

    public function getNotadefinitiva() {
        return $this->notadefinitiva;
    }

    public function getNumerocreditos() {
        return $this->numerocreditos;
    }

    public function getIdestudiantegeneral() {
        return $this->idestudiantegeneral;
    }

    public function getCodigoestudiante() {
        return $this->codigoestudiante;
    }

    public function setCodigoperiodo($codigoperiodo) {
        $this->codigoperiodo = $codigoperiodo;
    }

    public function setNotadefinitiva($notadefinitiva) {
        $this->notadefinitiva = $notadefinitiva;
    }

    public function setNumerocreditos($numerocreditos) {
        $this->numerocreditos = $numerocreditos;
    }

    public function setIdestudiantegeneral($idestudiantegeneral) {
        $this->idestudiantegeneral = $idestudiantegeneral;
    }

    public function setCodigoestudiante($codigoestudiante) {
        $this->codigoestudiante = $codigoestudiante;
    }

    public function getById() {
    }

    public static function getList($where=null,$groupBy=null) {
        $return = array();
        $db = Factory::createDbo();
        $query = "SELECT * FROM ViewHistoricoNotasEstudiante "
                    ." WHERE 1 ";
        if(!empty($where)){
            $query .= " AND ".$where;
        }
        if(!empty($groupBy)){
            $query .= " GROUP BY ".$groupBy;
        } 
        //d($query);
        $datos = $db->Execute($query);
        
        while( $d = $datos->FetchRow() ){
            $ViewHistoricoNotasEstudiante = new ViewHistoricoNotasEstudiante();
            $ViewHistoricoNotasEstudiante->codigoperiodo = $d['codigoperiodo'];
            $ViewHistoricoNotasEstudiante->notadefinitiva = $d['notadefinitiva'];
            $ViewHistoricoNotasEstudiante->numerocreditos = $d['numerocreditos'];
            $ViewHistoricoNotasEstudiante->idestudiantegeneral = $d['idestudiantegeneral'];
            $ViewHistoricoNotasEstudiante->codigoestudiante = $d['codigoestudiante'];
            
            $return[] = $ViewHistoricoNotasEstudiante;
            unset($ViewHistoricoNotasEstudiante);
        }
        //d($return);
        return $return;
    }
}
/*/
codigoperiodo	varchar(8)
notadefinitiva	decimal(5,2)
numerocreditos	smallint(6)
idestudiantegeneral	int(11)
codigoestudiante	int(11)
/**/
