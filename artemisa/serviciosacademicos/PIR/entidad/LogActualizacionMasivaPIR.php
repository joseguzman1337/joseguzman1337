<?php
/**
 * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package entidad
 */
class LogActualizacionMasivaPIR{
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
     * @type String
     * @access private
     */
    private $tipoDocumento;
    
    /**
     * @type int
     * @access private
     */
    private $numerodocumento;
    
    /**
     * @type String
     * @access private
     */
    private $numeroregistroresultadopruebaestado;
    
    /**
     * @type int
     * @access private
     */
    private $idEstudianteGeneral;
    
    /**
     * @type string
     * @access private
     */
    private $mensajeLog;
    
    /**
     * @type date
     * @access private
     */
    private $fechadelproceso;
    
    public function LogActualizacionMasivaPIR($db) {
        $this->db = $db;
    }
    
    public function getId() {
        return $this->id;
    }

    public function getTipoDocumento() {
        return $this->tipoDocumento;
    }

    public function getNumerodocumento() {
        return $this->numerodocumento;
    }

    public function getNumeroregistroresultadopruebaestado() {
        return $this->numeroregistroresultadopruebaestado;
    }

    public function getIdEstudianteGeneral() {
        return $this->idEstudianteGeneral;
    }

    public function getMensajeLog() {
        return $this->mensajeLog;
    }

    public function getFechadelproceso() {
        return $this->fechadelproceso;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setTipoDocumento($tipoDocumento) {
        $this->tipoDocumento = $tipoDocumento;
    }

    public function setNumerodocumento($numerodocumento) {
        $this->numerodocumento = $numerodocumento;
    }

    public function setNumeroregistroresultadopruebaestado($numeroregistroresultadopruebaestado) {
        $this->numeroregistroresultadopruebaestado = $numeroregistroresultadopruebaestado;
    }

    public function setIdEstudianteGeneral($idEstudianteGeneral) {
        $this->idEstudianteGeneral = $idEstudianteGeneral;
    }

    public function setMensajeLog($mensajeLog) {
        $this->mensajeLog = $mensajeLog;
    }

    public function setFechadelproceso($fechadelproceso) {
        $this->fechadelproceso = $fechadelproceso;
    }
    
    public function storeLog(){
        $query = "INSERT INTO LogActualizacionMasivaPIR SET "
                . "tipoDocumento = '".$this->tipoDocumento."', "
                . "numerodocumento = '".$this->numerodocumento."', "
                . "numeroregistroresultadopruebaestado = '".$this->numeroregistroresultadopruebaestado."', "
                . "idEstudianteGeneral = '".$this->idEstudianteGeneral."', "
                . "mensajeLog = '".$this->mensajeLog."', "
                . "fechadelproceso = '".$this->fechadelproceso."' ";
        $this->db->Execute($query);
    }

}