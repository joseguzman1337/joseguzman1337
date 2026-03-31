<?php
/**
 * @author Andres Ariza <arizaandres@unbosque.edu.do>
 * @copyright Universidad el Bosque - Dirección de Tecnología
 * @package entidad
*/
defined('_EXEC') or die;
require_once(PATH_SITE."/entidad/Materia.php");
require_once(PATH_SITE."/entidad/Grupo.php");
class DetallePrematricula implements Entidad{
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
     * @type int
     * @access private
     */
    private $idprematricula;
    
    /**
     * @type int
     * @access private
     */
    private $codigomateria;
    
    /**
     * @type Materia Object
     * @access private
     */
    private $Materia;
    
    /**
     * @type int
     * @access private
     */
    private $codigomateriaelectiva;
    
    /**
     * @type String
     * @access private
     */
    private $codigotipodetalleprematricula;
    
    /**
     * @type int
     * @access private
     */
    private $idgrupo;
    
    /**
     * @type Grupo Object
     * @access private
     */
    private $Grupo;
    
    /**
     * @type int
     * @access private
     */
    private $numeroordenpago;
    
    
    public function __construct(){
    }
    
    public function setDb(){
        $this->db = Factory::createDbo();
    }
    
    public function getIdDetallePrematricula() {
        return $this->idDetallePrematricula;
    }
    
    public function getIdprematricula() {
        return $this->idprematricula;
    }
    
    public function getCodigomateria() {
        return $this->codigomateria;
    }
    
    public function getMateria() {
        return $this->Materia;
    }

    public function getCodigomateriaelectiva() {
        return $this->codigomateriaelectiva;
    }

    public function getCodigotipodetalleprematricula() {
        return $this->codigotipodetalleprematricula;
    }

    public function getIdgrupo() {
        return $this->idgrupo;
    }

    public function getGrupo() {
        return $this->Grupo;
    }

    public function getNumeroordenpago() {
        return $this->numeroordenpago;
    }
    
    
    public function setIdDetallePrematricula($idDetallePrematricula) {
        $this->idDetallePrematricula = $idDetallePrematricula;
    }    

    public function setIdprematricula($idprematricula) {
        $this->idprematricula = $idprematricula;
    }

    public function setCodigomateria($codigomateria) {
        $this->codigomateria = $codigomateria;
        $this->setMateria();
    }

    private function setMateria() {
        if(!empty($this->codigomateria)){
            $this->Materia = new Materia();
            $this->Materia->setDb();
            $this->Materia->setCodigoMateria($this->codigomateria);
            $this->Materia->getById();
        }
    }

    public function setCodigomateriaelectiva($codigomateriaelectiva) {
        $this->codigomateriaelectiva = $codigomateriaelectiva;
    }

    public function setCodigotipodetalleprematricula($codigotipodetalleprematricula) {
        $this->codigotipodetalleprematricula = $codigotipodetalleprematricula;
    }

    public function setIdgrupo($idgrupo) {
        $this->idgrupo = $idgrupo;
        $this->setGrupo();
    }
    
    public function setGrupo(){
        if(!empty($this->idgrupo)){
            $this->Grupo = new Grupo();
            $this->Grupo->setDb();
            $this->Grupo->setIdgrupo($this->idgrupo);
            $this->Grupo->getById();
        }
    }

    public function setNumeroordenpago($numeroordenpago) {
        $this->numeroordenpago = $numeroordenpago;
    }
    
    public function getById() {
        if(!empty($this->idDetallePrematricula)){
            $query = "SELECT * FROM detalleprematricula "
                    ." WHERE idDetallePrematricula = ".$this->db->qstr($this->idDetallePrematricula);
            
            $datos = $this->db->Execute($query);
            $d = $datos->FetchRow();
            
            if(!empty($d)){
                $this->idprematricula = $d['idprematricula'];
                $this->codigomateria = $d['codigomateria'];
                $this->setMateria();
                $this->codigomateriaelectiva = $d['codigomateriaelectiva'];
                $this->codigoestadodetalleprematricula = $d['codigoestadodetalleprematricula'];
                $this->codigotipodetalleprematricula = $d['codigotipodetalleprematricula'];
                $this->idgrupo = $d['idgrupo'];
                $this->setGrupo();
                $this->numeroordenpago = $d['numeroordenpago'];
            }
        }
    }

    public static function getList($where=null) {
        $db = Factory::createDbo();
        
        $return = array();
        
        $query = "SELECT * "
                . " FROM detalleprematricula "
                . " WHERE 1";
        
        if(!empty($where)){
            $query .= " AND ".$where;
        }
        
        $datos = $db->Execute($query);
        while($d = $datos->FetchRow()){
            $DetallePrematricula = new DetallePrematricula();
            $DetallePrematricula->idDetallePrematricula = $d['idDetallePrematricula'];
            $DetallePrematricula->idprematricula = $d['idprematricula'];
            $DetallePrematricula->codigomateria = $d['codigomateria'];
            $DetallePrematricula->setMateria();
            $DetallePrematricula->codigomateriaelectiva = $d['codigomateriaelectiva'];
            $DetallePrematricula->codigoestadodetalleprematricula = $d['codigoestadodetalleprematricula'];
            $DetallePrematricula->codigotipodetalleprematricula = $d['codigotipodetalleprematricula'];
            $DetallePrematricula->idgrupo = $d['idgrupo'];
            $DetallePrematricula->setGrupo();
            $DetallePrematricula->numeroordenpago = $d['numeroordenpago'];
                
            $return[] = $DetallePrematricula;
            unset($DetallePrematricula);
        }
        return $return;
    }

    
}
/*/
idDetallePrematricula
idprematricula
codigomateria
codigomateriaelectiva
codigoestadodetalleprematricula
codigotipodetalleprematricula
idgrupo
numeroordenpago
/**/