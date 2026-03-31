<?php
/**
 * @author Andres Ariza <arizaandres@unbosque.edu.do>
 * @copyright Universidad el Bosque - Dirección de Tecnología
 * @package entidad
*/
defined('_EXEC') or die;
require_once(PATH_SITE."/entidad/DetallePrematricula.php");
require_once(PATH_SITE."/entidad/Prematricula.php");
class ViewMateriasMatriculadas implements Entidad{
    /**
     * @type adodb Object
     * @access private
     */
    private $db;
    
    /**
     * @type int
     * @access private
     */
    private $idDetallePrematricula;
    
    /**
     * @type DetallePrematricula Object
     * @access private
     */
    private $DetallePrematricula;
    
    /**
     * @type int
     * @access private
     */
    private $idprematricula;
    
    /**
     * @type Prematricula Object
     * @access private
     */
    private $Prematricula;
    
    public function __construct(){
    }
    
    public function setDb(){
        $this->db = Factory::createDbo();
    }
    
    public function getIdDetallePrematricula() {
        return $this->idDetallePrematricula;
    }
    
    public function getDetallePrematricula(){
        return $this->DetallePrematricula;
    }

    public function getIdprematricula() {
        return $this->idprematricula;
    }
    
    public function getPrematricula() {
        return $this->Prematricula;
    }

    public function setIdDetallePrematricula($idDetallePrematricula) {
        $this->idDetallePrematricula = $idDetallePrematricula;
    }
    
    public function setDetallePrematricula(){
        if(!empty($this->idDetallePrematricula)){
            $this->DetallePrematricula = new DetallePreMatricula();
            $this->DetallePrematricula->setDb();
            $this->DetallePrematricula->setIdDetallePrematricula($this->idDetallePrematricula);
            $this->DetallePrematricula->getById();
        }
    }

    public function setIdprematricula($idprematricula) {
        $this->idprematricula = $idprematricula;
    }

    public function setPrematricula() {
        if(!empty($this->idprematricula)){
            $this->Prematricula = new Prematricula();
            $this->Prematricula->setDb();
            $this->Prematricula->setIdprematricula($this->idprematricula);
            $this->Prematricula->getById();
        }
    } 

    public function getById() {
        if(!empty($this->idDetallePrematricula)){
            $query = "SELECT * FROM ViewMateriasMatriculadas "
                    ." WHERE idDetallePrematricula = ".$this->db->qstr($this->idDetallePrematricula);
            
            $datos = $this->db->Execute($query);
            $d = $datos->FetchRow();
            
            if(!empty($d)){
                $this->setDetallePrematricula();
                $this->idprematricula = $d['idprematricula'];
                $this->setPrematricula();
            }
        }
        
    }

    public static function getList($where){
        $return = array();
        $db = Factory::createDbo();
        $query = "SELECT * FROM ViewMateriasMatriculadas "
                    ." WHERE 1 ";
        if(!empty($where)){
            $query .= " AND ".$where;
        } 
        //d($query);
        $datos = $db->Execute($query);
        
        while( $d = $datos->FetchRow() ){
            $ViewMateriasMatriculadas = new ViewMateriasMatriculadas();
            $ViewMateriasMatriculadas->idDetallePrematricula = $d['idDetallePrematricula'];
            $ViewMateriasMatriculadas->setDetallePrematricula();
            $ViewMateriasMatriculadas->idprematricula = $d['idprematricula'];
            $ViewMateriasMatriculadas->setPrematricula();
            
            $return[] = $ViewMateriasMatriculadas;
            unset($ViewMateriasMatriculadas);
        }
        //d($return);
        return $return;
    }

}
/*/
idDetallePrematricula	int(11)
codigomateria	int(11)
codigomateriaelectiva	int(11)
codigotipodetalleprematricula	char(2)
idgrupo	int(11)
numeroordenpago	int(11)
idprematricula	int(11)
fechaprematricula	date
codigoestudiante	int(11)
codigoperiodo	varchar(8)
codigoestadoprematricula	char(2)
semestreprematricula	char(2)
/**/