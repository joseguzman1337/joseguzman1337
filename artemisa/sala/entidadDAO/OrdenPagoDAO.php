<?php
namespace Sala\entidadDAO;

use Faker\Provider\DateTime;

/**
 * @author Diego Rivera <riveradiego@unbosque.edu.do>
 * @copyright Universidad el Bosque - Dirección de Tecnología
 * @package entidadDAO
 */
defined('_EXEC') or die;

class OrdenPagoDAO {
    /**
     * @type adodb Object
     * @access private
     */
    private $db;
     /**
     * @type Carrera
     * @access private
     */
    private $ordenPago;
    
    public function __construct(\OrdenPagoEntity $ordenPago = null) {
        $this->ordenPago = $ordenPago;
        $this->setDb();
    }

    public function setDb() {
        $this->db = \Factory::createDbo();
    }

    public function logAuditoria($e, $query) {
        require_once(PATH_SITE."/entidadDAO/LogAuditoriaDAO.php");
        $idUsuario = \Factory::getSessionVar("idusuario");
        \Sala\entidadDAO\LogAuditoriaDAO::setLogAuditoria($e, $query, $idUsuario);
    }

    public function getOrdersByCarreerByStuden($numeroDocumento,$codigocarrera)
    {

    $query_data = "
            SELECT distinct eg.*,
            ec.codigocarrera, 
            ec.codigoestudiante,
            c.codigoindicadorcobroinscripcioncarrera, 
            c.codigoindicadorprocesoadmisioncarrera, 
            m.nombremodalidadacademica, 
            m.codigomodalidadacademica, 
            c.nombrecarrera, o.* 
              FROM estudiantegeneral eg
                    JOIN estudiante ec on eg.idestudiantegeneral = ec.idestudiantegeneral
                    JOIN carrera c on ec.codigocarrera = c.codigocarrera
                    JOIN modalidadacademica m on m.codigomodalidadacademica = c.codigomodalidadacademica
                    JOIN ordenpago o ON (o.codigoestudiante = ec.codigoestudiante AND o.codigoestadoordenpago in ('10','11','60','61')) 
              WHERE eg.numerodocumento= '" . $numeroDocumento . "' and c.codigocarrera = '" . $codigocarrera . "' 
                  GROUP BY ec.codigocarrera , o.numeroordenpago   
                  ORDER BY codigocarrera desc; ";

        $data = $this->db->GetAll($query_data);
        return $data;
    }

    public function getDateOrderPayment($numeroOrdenPago)
    {
        $query = "select * from fechaordenpago where numeroordenpago = ".$numeroOrdenPago." order by fechaordenpago desc";
        $data = $this->db->GetRow($query);
        return $data;

    }

    public function update($numeroOrdenPago, $estado, $fecha=null){
        if(!isset($fecha) || !empty($fecha)){
            $fecha = date('Y-m-d');
        }
        $query_ordenpago = "UPDATE ordenpago SET codigoestadoordenpago = ".$estado. ", " .
            " fechapagosapordenpago = '$fecha' WHERE numeroordenpago = '$numeroOrdenPago'";
        $orden = $this->db->Execute($query_ordenpago);
        return  $orden;
    }

    public function getNumeroOrdenes($numeroorden){
        $sqlOrdenPago = "SELECT COUNT(1) numeroOrdenes  FROM ordenpago o "
            . " WHERE o.numeroordenpago = '".$numeroorden."' " ;
        $dataOrdenPago = $this->db->GetRow($sqlOrdenPago);
        return $dataOrdenPago;
    }
    public function ordenPagoMatriculas($codigoEstudiante,$codigoperiodo) {
        // consulta la orden de pago del estudiante activas y pagas de MATRICULA
        $sqlOrdenPagoEstudiante = "select o.* from ordenpago o ".
        " inner join detalleordenpago d on o.numeroordenpago = d.numeroordenpago ".
        " where codigoestudiante = '".$codigoEstudiante."' ".
        " and o.codigoperiodo = '".$codigoperiodo."' ".
        " and o.codigoestadoordenpago in (10,11,40,41) ".
        " and d.codigoconcepto = '151' order by numeroordenpago desc limit 1";
        $ordenPagoActual = $this->db->GetRow($sqlOrdenPagoEstudiante);

        if(count($ordenPagoActual)>0){
            return $ordenPagoActual;
        }
    }
}


