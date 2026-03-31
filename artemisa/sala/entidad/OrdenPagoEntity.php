<?php
/** 
 * @author Andres Ariza <arizaandres@unbosque.edu.do>
 * @copyright Universidad el Bosque - Dirección de Tecnología
 * @package entidad
*/
defined('_EXEC') or die;
class OrdenPagoEntity {
    /**
     * @type adodb Object
     * @access private
     */
    private $db;
    private $numeroordenpago;
    private $codigoestudiante;
    private $fechaordenpago;
    private $idprematricula;
    private $fechaentregaordenpago;
    private $codigoperiodo;
    private $codigoestadoordenpago;
    private $codigoimprimeordenpago;
    private $observacionordenpago;
    private $codigocopiaordenpago;
    private $documentosapordenpago;
    private $idsubperiodo;
    private $idsubperiododestino;
    private $documentocuentaxcobrarsap;
    private $documentocuentacompensacionsap;
    private $fechapagosapordenpago;

    public function __construct(){
        $this->setDb();
    }
    
    public function setDb(){
        $this->db = Factory::createDbo();
    }

    /**
     * @return mixed
     */
    public function getNumeroordenpago()
    {
        return $this->numeroordenpago;
    }

    /**
     * @param mixed $numeroordenpago
     */
    public function setNumeroordenpago($numeroordenpago)
    {
        $this->numeroordenpago = $numeroordenpago;
    }

    /**
     * @return mixed
     */
    public function getCodigoestudiante()
    {
        return $this->codigoestudiante;
    }

    /**
     * @param mixed $codigoestudiante
     */
    public function setCodigoestudiante($codigoestudiante)
    {
        $this->codigoestudiante = $codigoestudiante;
    }

    /**
     * @return mixed
     */
    public function getFechaordenpago()
    {
        return $this->fechaordenpago;
    }

    /**
     * @param mixed $fechaordenpago
     */
    public function setFechaordenpago($fechaordenpago)
    {
        $this->fechaordenpago = $fechaordenpago;
    }

    /**
     * @return mixed
     */
    public function getIdprematricula()
    {
        return $this->idprematricula;
    }

    /**
     * @param mixed $idprematricula
     */
    public function setIdprematricula($idprematricula)
    {
        $this->idprematricula = $idprematricula;
    }

    /**
     * @return mixed
     */
    public function getFechaentregaordenpago()
    {
        return $this->fechaentregaordenpago;
    }

    /**
     * @param mixed $fechaentregaordenpago
     */
    public function setFechaentregaordenpago($fechaentregaordenpago)
    {
        $this->fechaentregaordenpago = $fechaentregaordenpago;
    }

    /**
     * @return mixed
     */
    public function getCodigoperiodo()
    {
        return $this->codigoperiodo;
    }

    /**
     * @param mixed $codigoperiodo
     */
    public function setCodigoperiodo($codigoperiodo)
    {
        $this->codigoperiodo = $codigoperiodo;
    }

    /**
     * @return mixed
     */
    public function getCodigoestadoordenpago()
    {
        return $this->codigoestadoordenpago;
    }

    /**
     * @param mixed $codigoestadoordenpago
     */
    public function setCodigoestadoordenpago($codigoestadoordenpago)
    {
        $this->codigoestadoordenpago = $codigoestadoordenpago;
    }

    /**
     * @return mixed
     */
    public function getCodigoimprimeordenpago()
    {
        return $this->codigoimprimeordenpago;
    }

    /**
     * @param mixed $codigoimprimeordenpago
     */
    public function setCodigoimprimeordenpago($codigoimprimeordenpago)
    {
        $this->codigoimprimeordenpago = $codigoimprimeordenpago;
    }

    /**
     * @return mixed
     */
    public function getObservacionordenpago()
    {
        return $this->observacionordenpago;
    }

    /**
     * @param mixed $observacionordenpago
     */
    public function setObservacionordenpago($observacionordenpago)
    {
        $this->observacionordenpago = $observacionordenpago;
    }

    /**
     * @return mixed
     */
    public function getCodigocopiaordenpago()
    {
        return $this->codigocopiaordenpago;
    }

    /**
     * @param mixed $codigocopiaordenpago
     */
    public function setCodigocopiaordenpago($codigocopiaordenpago)
    {
        $this->codigocopiaordenpago = $codigocopiaordenpago;
    }

    /**
     * @return mixed
     */
    public function getDocumentosapordenpago()
    {
        return $this->documentosapordenpago;
    }

    /**
     * @param mixed $documentosapordenpago
     */
    public function setDocumentosapordenpago($documentosapordenpago)
    {
        $this->documentosapordenpago = $documentosapordenpago;
    }

    /**
     * @return mixed
     */
    public function getIdsubperiodo()
    {
        return $this->idsubperiodo;
    }

    /**
     * @param mixed $idsubperiodo
     */
    public function setIdsubperiodo($idsubperiodo)
    {
        $this->idsubperiodo = $idsubperiodo;
    }

    /**
     * @return mixed
     */
    public function getIdsubperiododestino()
    {
        return $this->idsubperiododestino;
    }

    /**
     * @param mixed $idsubperiododestino
     */
    public function setIdsubperiododestino($idsubperiododestino)
    {
        $this->idsubperiododestino = $idsubperiododestino;
    }

    /**
     * @return mixed
     */
    public function getDocumentocuentaxcobrarsap()
    {
        return $this->documentocuentaxcobrarsap;
    }

    /**
     * @param mixed $documentocuentaxcobrarsap
     */
    public function setDocumentocuentaxcobrarsap($documentocuentaxcobrarsap)
    {
        $this->documentocuentaxcobrarsap = $documentocuentaxcobrarsap;
    }

    /**
     * @return mixed
     */
    public function getDocumentocuentacompensacionsap()
    {
        return $this->documentocuentacompensacionsap;
    }

    /**
     * @param mixed $documentocuentacompensacionsap
     */
    public function setDocumentocuentacompensacionsap($documentocuentacompensacionsap)
    {
        $this->documentocuentacompensacionsap = $documentocuentacompensacionsap;
    }

    /**
     * @return mixed
     */
    public function getFechapagosapordenpago()
    {
        return $this->fechapagosapordenpago;
    }

    /**
     * @param mixed $fechapagosapordenpago
     */
    public function setFechapagosapordenpago($fechapagosapordenpago)
    {
        $this->fechapagosapordenpago = $fechapagosapordenpago;
    }
        
    public function getById(){
        
        if(!empty($this->numeroordenpago)){
            $query = "SELECT * FROM ordenpago "
                    ." WHERE numeroordenpago = ".$this->numeroordenpago;
            
            $datos = $this->db->Execute($query);
            $d = $datos->FetchRow();
            
            if(!empty($d)){
            $this->codigoestudiante = $d['codigoestudiante'];
            $this->fechaordenpago = $d['fechaordenpago'];
            $this->idprematricula = $d['idprematricula'];
            $this->fechaentregaordenpago = $d['fechaentregaordenpago'];
            $this->codigoperiodo = $d['codigoperiodo'];
            $this->codigoestadoordenpago = $d['codigoestadoordenpago'];
            $this->codigoimprimeordenpago = $d['codigoimprimeordenpago'];
            $this->observacionordenpago = $d['observacionordenpago'];
            $this->codigocopiaordenpago = $d['codigocopiaordenpago'];
            $this->documentosapordenpago = $d['documentosapordenpago'];
            $this->idsubperiodo = $d['idsubperiodo'];
            $this->idsubperiododestino = $d['idsubperiododestino'];
            $this->documentocuentaxcobrarsap = $d['documentocuentaxcobrarsap'];
            $this->documentocuentacompensacionsap = $d['documentocuentacompensacionsap'];
            $this->fechapagosapordenpago = $d['fechapagosapordenpago'];
            }
        }
    }

}
