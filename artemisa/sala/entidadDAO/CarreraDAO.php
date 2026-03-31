<?php
namespace Sala\entidadDAO;
use Symfony\Component\HttpKernel\EventListener\ValidateRequestListener;

/**
 * @author Diego Rivera <riveradiego@unbosque.edu.do>
 * @copyright Universidad el Bosque - Dirección de Tecnología
 * @package entidadDAO
 */
defined('_EXEC') or die;

class CarreraDAO {
    /**
     * @type adodb Object
     * @access private
     */
    private $db;
     /**
     * @type Carrera
     * @access private
     */
    private $carrera;
    
    public function __construct(\Carrera $carrera) {
        $this->carrera = $carrera;
        $this->setDb();
    }
 
    public function setDb() {
        $this->db = \Factory::createDbo();
    }
    
    public function save() {
        $query = "";
        $where = array();
        $codigoCarrera = $this->carrera->getCodigoCarrera();
        if(empty($codigoCarrera)){
            $query .= "INSERT INTO ";
        }else{
            $query .= "UPDATE ";
        }
        
        $query .= "carrera SET "
                ."codigocortocarrera = '".$this->carrera->getCodigocortocarrera().","
                ."codigoDiurno = '".$this->carrera->getCodigoDiurno()."',"
                ."nombrecortocarrera = '".$this->carrera->getNombreCortoCarrera()."',"
                ."nombrecarrera = '".$this->carrera->getNombreCarrera()."',"
                ."codigofacultad = '".$this->carrera->getCodigofacultad()."',"
                ."centrocosto = '".$this->carrera->getCentroCosto()."',"
                ."codigocentrobeneficio = '".$this->carrera->getCodigocentrobeneficio()."',"
                ."codigosucursal = '".$this->carrera->getCodigosucursal()."',"
                ."codigomodalidadacademica = '".$this->carrera->getCodigomodalidadacademica()."',"
                ."fechainiciocarrera = '".$this->carrera->getFechainiciocarrera()."',"
                ."fechavencimientocarrera = '".$this->carrera->getFechavencimientocarrera()."',"
                ."abreviaturacodigocarrera = '".$this->carrera->getAbreviaturacodigocarrera()."',"
                ."iddirectivo = '".$this->carrera->getIddirectivo()."',"
                ."codigotitulo = '".$this->carrera->getCodigotitulo()."',"
                ."codigotipocosto = '".$this->carrera->getCodigotipocosto()."',"
                ."codigoindicadorcobroinscripcioncarrera = '".$this->carrera->getCodigoindicadorcobroinscripcioncarrera()."',"
                ."codigoindicadorprocesoadmisioncarrera = '".$this->carrera->getCodigoindicadorprocesoadmisioncarrera()."',"
                ."codigoindicadorplanestudio = '".$this->carrera->getCodigoindicadorplanestudio()."',"
                ."codigoindicadortipocarrera = '".$this->carrera->getCodigoindicadortipocarrera()."',"
                ."codigoreferenciacobromatriculacarrera = '".$this->carrera->getCodigoreferenciacobromatriculacarrera()."',"
                ."numerodiaaspirantecarrera = '".$this->carrera->getNumerodiaaspirantecarrera()."',"
                ."codigoindicadorcarreragrupofechainscripcion = '".$this->carrera->getCodigoindicadorcarreragrupofechainscripcion()."',"
                ."codigomodalidadacademicasic = '".$this->carrera->getCodigomodalidadacademicasic()."'";
        if(!empty($where)){
            $query .= " WHERE ".implode(" AND ",$where);
        }      
        $rs = $this->db->Execute($query);
        
        if(is_null($this->carrera->getCodigoCarrera())){
           $this->carrera->setCodigocarrera($this->db->insert_Id());
        }
        
        $this->logAuditoria($this->carrera, $query);
        
        if(!$rs){
            return false;
        }else{
            return true;
        }
        
    }

    public function logAuditoria($e, $query) {
        require_once(PATH_SITE."/entidadDAO/LogAuditoriaDAO.php");
        $idUsuario = \Factory::getSessionVar("idusuario");
        \Sala\entidadDAO\LogAuditoriaDAO::setLogAuditoria($e, $query, $idUsuario);
    }


    public function getCarreersOrderPymentsByStudent($numeroDocumento)
    {
       $queryCarrerasOrdenes = "
              SELECT distinct c.codigocarrera, c.nombrecarrera,m.nombremodalidadacademica
                    FROM estudiantegeneral eg
                        JOIN estudiante ec on eg.idestudiantegeneral = ec.idestudiantegeneral
                        JOIN carrera c on ec.codigocarrera = c.codigocarrera
                        JOIN modalidadacademica m on m.codigomodalidadacademica = c.codigomodalidadacademica
                        JOIN ordenpago o ON (o.codigoestudiante = ec.codigoestudiante AND o.codigoestadoordenpago in ('10','11','60','61')) 
                    WHERE eg.numerodocumento = '" . $_SESSION['numerodocumento'] . "'
                      GROUP BY ec.codigocarrera , o.numeroordenpago
                        ORDER BY codigocarrera desc; ";
    
        $carrerasOrdenesData = $this->db->GetAll($queryCarrerasOrdenes);
        return $carrerasOrdenesData;
    }
}
