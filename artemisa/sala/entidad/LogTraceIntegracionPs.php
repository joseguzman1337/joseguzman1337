<?php
/** 
 * @author Ivan Quintero <quinteroivan@unbosque.edu.do>
 * @copyright Universidad el Bosque - Dirección de Tecnología
 * @package entidad
*/
defined('_EXEC') or die;
class LogTraceIntegracionPs {
    /**
     * @type adodb Object
     * @access private
     */
    private $db;
    private $idlogtraceintegracionps;
    private $transaccionlogtraceintegracionps;
    private $enviologtraceintegracionps;
    private $respuestalogtraceintegracionps;
    private $documentologtraceintegracionps;
    private $fecharegistrologtraceintegracionps;
    private $estadoenvio;

    public function __construct(){
        $this->setDb();
    }
    
    public function setDb(){
        $this->db = Factory::createDbo();
    }

    public function getIdlogtraceintegracionps(){
        return $this->idlogtraceintegracionps;
    }

    public function setIdlogtraceintegracionps($idlogtraceintegracionps){
        $this->idlogtraceintegracionps = $idlogtraceintegracionps;
    }

    public function getTransaccionlogtraceintegracionps()
    {
        return $this->transaccionlogtraceintegracionps;
    }


    public function setTransaccionlogtraceintegracionps($transaccionlogtraceintegracionps)
    {
        $this->transaccionlogtraceintegracionps = $transaccionlogtraceintegracionps;
    }


    public function getEnviologtraceintegracionps()
    {
        return $this->enviologtraceintegracionps;
    }


    public function setEnviologtraceintegracionps($enviologtraceintegracionps)
    {
        $this->enviologtraceintegracionps = $enviologtraceintegracionps;
    }


    public function getRespuestalogtraceintegracionps()
    {
        return $this->respuestalogtraceintegracionps;
    }

    public function setRespuestalogtraceintegracionps($respuestalogtraceintegracionps)
    {
        $this->respuestalogtraceintegracionps = $respuestalogtraceintegracionps;
    }


    public function getDocumentologtraceintegracionps()
    {
        return $this->documentologtraceintegracionps;
    }

    public function setDocumentologtraceintegracionps($documentologtraceintegracionps)
    {
        $this->documentologtraceintegracionps = $documentologtraceintegracionps;
    }

    public function getFecharegistrologtraceintegracionps()
    {
        return $this->fecharegistrologtraceintegracionps;
    }

    public function setFecharegistrologtraceintegracionps($fecharegistrologtraceintegracionps)
    {
        $this->fecharegistrologtraceintegracionps = $fecharegistrologtraceintegracionps;
    }

    public function getEstadoenvio()
    {
        return $this->estadoenvio;
    }

    public function setEstadoenvio($estadoenvio)
    {
        $this->estadoenvio = $estadoenvio;
    }

    public function getById(){
        
        if(!empty($this->idlogtraceintegracionps)){
            $query = "SELECT * FROM logtraceintegracionps "
                    ." WHERE idlogtraceintegracionps = ".$this->idlogtraceintegracionps;
            
            $datos = $this->db->Execute($query);
            $d = $datos->FetchRow();
            
            if(!empty($d)){
            $this->transaccionlogtraceintegracionps = $d['transaccionlogtraceintegracionps'];
            $this->enviologtraceintegracionps = $d['enviologtraceintegracionps'];
            $this->respuestalogtraceintegracionps = $d['respuestalogtraceintegracionps'];
            $this->documentologtraceintegracionps = $d['documentologtraceintegracionps'];
            $this->fecharegistrologtraceintegracionps = $d['fecharegistrologtraceintegracionps'];
            $this->estadoenvio = $d['estadoenvio'];
            }
        }
    }

    public function getTransaccion($transaccionlogtraceintegracionps=null){}

}
