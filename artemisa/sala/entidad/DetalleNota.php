<?php
/**
 * @author Andres Ariza <arizaandres@unbosque.edu.do>
 * @copyright Universidad el Bosque - Dirección de Tecnología
 * @package entidad
*/
defined('_EXEC') or die;
class DetalleNota implements Entidad{
    /**
     * @type adodb Object
     * @access private
     */
    private $db;
    
    /**
     * @type int
     * @access private
     */
    private $idDetalleNota;
    
    /**
     * @type int
     * @access private
     */
    private $idgrupo;
    
    /**
     * @type int
     * @access private
     */
    private $idcorte;
    
    /**
     * @type int
     * @access private
     */
    private $codigoestudiante;
    
    /**
     * @type int
     * @access private
     */
    private $codigomateria;
    
    /**
     * @type int
     * @access private
     */
    private $nota;
    
    /**
     * @type int
     * @access private
     */
    private $numerofallasteoria;
    
    /**
     * @type int
     * @access private
     */
    private $numerofallaspractica;
    
    /**
     * @type int
     * @access private
     */
    private $codigotiponota;
    
    /**
     * @type int
     * @access private
     */
    private $codigoestado;
    
    public function __construct(){
        
    }

    public function setDb() {
        $this->db = Factory::createDbo();
    }
    
    public function getIdDetalleNota() {
        return $this->idDetalleNota;
    }
    
    public function getIdgrupo() {
        return $this->idgrupo;
    }

    public function getIdcorte() {
        return $this->idcorte;
    }

    public function getCodigoestudiante() {
        return $this->codigoestudiante;
    }

    public function getCodigomateria() {
        return $this->codigomateria;
    }

    public function getNota() {
        return $this->nota;
    }

    public function getNumerofallasteoria() {
        return $this->numerofallasteoria;
    }

    public function getNumerofallaspractica() {
        return $this->numerofallaspractica;
    }

    public function getCodigotiponota() {
        return $this->codigotiponota;
    }

    public function getCodigoestado() {
        return $this->codigoestado;
    }

    public function setIdDetalleNota($idDetalleNota) {
        $this->idDetalleNota = $idDetalleNota;
    }

    public function setIdgrupo($idgrupo) {
        $this->idgrupo = $idgrupo;
    }

    public function setIdcorte($idcorte) {
        $this->idcorte = $idcorte;
    }

    public function setCodigoestudiante($codigoestudiante) {
        $this->codigoestudiante = $codigoestudiante;
    }

    public function setCodigomateria($codigomateria) {
        $this->codigomateria = $codigomateria;
    }

    public function setNota($nota) {
        $this->nota = $nota;
    }

    public function setNumerofallasteoria($numerofallasteoria) {
        $this->numerofallasteoria = $numerofallasteoria;
    }

    public function setNumerofallaspractica($numerofallaspractica) {
        $this->numerofallaspractica = $numerofallaspractica;
    }

    public function setCodigotiponota($codigotiponota) {
        $this->codigotiponota = $codigotiponota;
    }

    public function setCodigoestado($codigoestado) {
        $this->codigoestado = $codigoestado;
    }
    
    public function getById() {
        if(!empty($this->idDetalleNota)){
            $query = "SELECT * FROM detallenota "
                    ." WHERE idDetalleNota = ".$this->db->qstr($this->idDetalleNota);
            
            $datos = $this->db->Execute($query);
            $d = $datos->FetchRow();
            
            if(!empty($d)){
                $this->idgrupo = $d['idgrupo'];
                $this->idcorte = $d['idcorte'];
                $this->codigoestudiante = $d['codigoestudiante'];
                $this->codigomateria = $d['codigomateria'];
                $this->nota = $d['nota'];
                $this->numerofallasteoria = $d['numerofallasteoria'];
                $this->numerofallaspractica = $d['numerofallaspractica'];
                $this->codigotiponota = $d['codigotiponota'];
                $this->codigoestado = $d['codigoestado'];
            }
        }
        
    }

    public static function getList($where=null) {
        $db = Factory::createDbo();
        
        $return = array();
        
        $query = "SELECT * "
                . " FROM detallenota "
                . " WHERE 1";
        
        if(!empty($where)){
            $query .= " AND ".$where;
        }
        //d($query);
        
        $datos = $db->Execute($query);
        if($datos){
            while($d = $datos->FetchRow()){
                $DetalleNota = new DetalleNota();
                $DetalleNota->idDetalleNota = $d['idDetalleNota'];
                $DetalleNota->idgrupo = $d['idgrupo'];
                $DetalleNota->idcorte = $d['idcorte'];
                $DetalleNota->codigoestudiante = $d['codigoestudiante'];
                $DetalleNota->codigomateria = $d['codigomateria'];
                $DetalleNota->nota = $d['nota'];
                $DetalleNota->numerofallasteoria = $d['numerofallasteoria'];
                $DetalleNota->numerofallaspractica = $d['numerofallaspractica'];
                $DetalleNota->codigotiponota = $d['codigotiponota'];
                $DetalleNota->codigoestado = $d['codigoestado'];

                $return[] = $DetalleNota;
                unset($DetalleNota);
            }
        }
        return $return;
    }
}
/*/
idDetalleNota	int(11)
idgrupo	int(11)
idcorte	int(11)
codigoestudiante	int(11)
codigomateria	int(11)
nota	decimal(5,1)
numerofallasteoria	smallint(6)
numerofallaspractica	smallint(6)
codigotiponota	char(2)
codigoestado	char(3)
/**/