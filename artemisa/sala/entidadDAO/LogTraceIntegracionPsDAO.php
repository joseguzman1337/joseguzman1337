<?php
namespace Sala\entidadDAO;

/**
 * @author Iqvn Quintero <quinteroivan@unbosque.edu.do>
 * @copyright Universidad el Bosque - Dirección de Tecnología
 * @package entidadDAO
 */
defined('_EXEC') or die;
class LogTraceIntegracionPsDAO {
    /**
     * @type adodb Object
     * @access private
     */
    private $db;

    public function __construct(){
        $this->setDb();
    }

    public function setDb() {
        $this->db = \Factory::createDbo();
    }

    public function getById(){
        
        if(!empty($this->idlogtraceintegracionps)){
            $query = "SELECT * FROM logtraceintegracionps "
                    ." WHERE idlogtraceintegracionps = ".$this->idlogtraceintegracionps;
            
            $datos = $this->db->Execute($query);
            $d = $datos->FetchRow();
            
            if(!empty($d)){
            $this->idlogtraceintegracionps = $d['idlogtraceintegracionps'];
            $this->enviologtraceintegracionps = $d['enviologtraceintegracionps'];
            $this->respuestalogtraceintegracionps = $d['respuestalogtraceintegracionps'];
            $this->documentologtraceintegracionps = $d['documentologtraceintegracionps'];
            $this->fecharegistrologtraceintegracionps = $d['fecharegistrologtraceintegracionps'];
            $this->estadoenvio = $d['estadoenvio'];
            }
        }
    }

    public static function getList($where=null) {
        $db = Factory::createDbo();

        $return = array();

        $query = "SELECT * "
            . " FROM logtraceintegracionps "
            . " WHERE 1";

        if(!empty($where)){
            $query .= " AND ".$where;
        }

        $datos = $db->Execute($query);
        while($d = $datos->FetchRow()){
            $LogTraceIntegracionPs = new LogTraceIntegracionPsDAO();
            $LogTraceIntegracionPs->idlogtraceintegracionps = $d['idlogtraceintegracionps'];
            $LogTraceIntegracionPs->transaccionlogtraceintegracionps = $d['transaccionlogtraceintegracionps'];
            $LogTraceIntegracionPs->enviologtraceintegracionps = $d['enviologtraceintegracionps'];
            $LogTraceIntegracionPs->respuestalogtraceintegracionps = $d['respuestalogtraceintegracionps'];
            $LogTraceIntegracionPs->documentologtraceintegracionps = $d['documentologtraceintegracionps'];
            $LogTraceIntegracionPs->fecharegistrologtraceintegracionps = $d['fecharegistrologtraceintegracionps'];
            $LogTraceIntegracionPs->estadoenvio = $d['estadoenvio'];
            $return[] = $LogTraceIntegracionPs;
            unset($LogTraceIntegracionPs);
        }
        return $return;
    }

    public function setLog($numeroordenpago, $envio, $transaccion, $parametros, $estadoenvio){
        $sqlexiste = "select idlogtraceintegracionps conteo from logtraceintegracionps ".
            " where documentologtraceintegracionps = ".$numeroordenpago." ".
            " and transaccionlogtraceintegracionps =  '".$transaccion."' ".
           // " and  enviologtraceintegracionps = '".$envio."'".
            " and respuestalogtraceintegracionps = '".$parametros."' ".
            " order by  idlogtraceintegracionps desc limit 1";
        $conteo = $this->db->GetRow($sqlexiste);

        if(!isset($conteo['conteo']) || empty($conteo['conteo'])){
            $query_logps="INSERT INTO logtraceintegracionps "
                . " (transaccionlogtraceintegracionps, enviologtraceintegracionps, "
                . " respuestalogtraceintegracionps, documentologtraceintegracionps, fecharegistrologtraceintegracionps, "
                . " estadoenvio) "
                . " VALUES ( '".$transaccion."', '".$envio."', "
                . " '".$parametros."' , '".$numeroordenpago."' ,now(),'".$estadoenvio."')";
            $this->db->Execute($query_logps);
        }

        $query = "SELECT idcontrolreportepagospeoplesala  FROM controlreportepagospeoplesala"
            . " WHERE numeroordenpago='".$numeroordenpago."'";
        $data = $this->db->Execute($query);

        if(!empty($data) && $data->NumRows()>=1){
            $query = "UPDATE ";
            $fin =" WHERE numeroordenpago='".$numeroordenpago."'";
        }else{
            $query = "INSERT ";
            $fin =" ,  numeroordenpago='".$numeroordenpago."'";
        }

        $query .= " controlreportepagospeoplesala  SET fechaactualizacionreporte=now(), '".$parametros."' ".$fin;
        $this->db->Execute($query);
    }

    public function update($id, $parametro){
        $SQL_update = "UPDATE logtraceintegracionps SET respuestalogtraceintegracionps='".$parametro." ', ".
            " estadoenvio=1, fecharegistrologtraceintegracionps=NOW() ".
            " WHERE  idlogtraceintegracionps='" . $id . "'";
        $this->db->execute($SQL_update);
    }

}

/*
idlogtraceintegracionps,int(11)
transaccionlogtraceintegracionps,varchar(200)
enviologtraceintegracionps,text
respuestalogtraceintegracionps,text
documentologtraceintegracionps,bigint(20)
fecharegistrologtraceintegracionps,timestamp
estadoenvio,tinyint(1)
*/