<?php
namespace Sala\lib\AdministracionPeriodos\api\clases;
defined('_EXEC') or die;

/**
 * Clase PeriodoFinanciero encargado de la orquestacion de las funcionalidades 
 * que controlan al periodo financiero
 * 
 * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package Sala\lib\AdministracionPeriodos\api\interfaces
 */
class PeriodoFinanciero implements \Sala\lib\AdministracionPeriodos\api\interfaces\IPeriodo {
    
    /**
     * $variables es una variable privada, contenedora de el objeto estandar en 
     * el cual se setean todas las variables recibidas por el sistema a nivel 
     * POST, GET y REQUEST
     * 
     * @var stdObject
     * @access private
     */
    private $variables;

    /**
     * Constructor de la clase PeriodoFinanciero 
     * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
     * @return void
     */ 
    public function __construct() {
    }
    
    /**
     * Este metodo inicializa el atributo variables con el objeto variables 
     * recibido mediante el REQUEST
     * @access public
     * @param \stdClass $variables Variables recibidas del REQUEST
     * @author Andres Ariza <arizaandres@unbosque.edu.co>
     * @since febrero 19, 2019
    */ 
    public function setVariables($variables) {
        $this->variables = $variables;
    }

    /**
     * Retorna las variables requeridas en la vista listar periodo financiero
     * @access public
     * @return array Variables necesarias para la vista listar periodo financiero
     * @author Andres Ariza <arizaandres@unbosque.edu.co>
     * @since febrero 19, 2019
    */
    public function listarPeriodo() {
        $array = array();
        $array["listaPeriodosFinancieros" ] = $this->getList(" codigoEstado = 100 ");
        return $array;        
    }

    /**
     * Retorna las variables requeridas en la vista para crear/editar periodo financiero
     * @access public
     * @return array Variables necesarias para la vista crear/editar periodo financiero
     * @author Andres Ariza <arizaandres@unbosque.edu.co>
     * @since febrero 19, 2019
    */
    public function nuevoPeriodo() {
        $array = array();
        $where = "";
        
        if(empty($this->variables->id)){
            $periodosFinanciero = $this->getList("codigoEstado = 100");
            $idsMaestrosUsados = array();
            foreach($periodosFinanciero as $pf){
                $idsMaestrosUsados[] = $pf->periodoMaestro->id;
            }
            if(!empty($idsMaestrosUsados)){
                $where = " id NOT IN (".implode(",",$idsMaestrosUsados).")";
            }
        }
        
        $periodoMaestro = new \PeriodoMaestro();
        $listaPeriodosMaestros = $periodoMaestro->getList($where); 
        $array["listaPeriodosMaestros"] = $listaPeriodosMaestros;
                
        $idAgnoActual = 0;
        $idsAgnos = array();
        foreach($listaPeriodosMaestros as $pm){
            $t = $pm->getIdAgno();
            if($t != $idAgnoActual){
                $idAgnoActual = $t;
                $idsAgnos[] = $idAgnoActual;
            }
        }
         
        $array["anio"] = \Ano::getList(" codigoestado = 100 AND idano IN (".implode(",",$idsAgnos).")");
        
        if(!empty($this->variables->id)){
            $ePeriodoFinanciero = new \PeriodoFinanciero();
            $ePeriodoFinanciero->setId($this->variables->id);
            $ePeriodoFinanciero->setDb();
            $ePeriodoFinanciero->getById();
            
            $obj = new \stdClass();
            $obj->id = $ePeriodoFinanciero->getId();
            $obj->idPeriodoMaestro = $ePeriodoFinanciero->getIdPeriodoMaestro();
            $obj->nombre = $ePeriodoFinanciero->getNombre();
            $obj->fechaInicio = $ePeriodoFinanciero->getFechaInicio();
            $obj->fechaFin = $ePeriodoFinanciero->getFechaFin();
            
            unset($ePeriodoFinanciero);
            
            $ePeriodoFinanciero = $obj;            
        }else{
            $ePeriodoFinanciero = null;
        }
        $array['ePeriodoFinanciero'] = $ePeriodoFinanciero;
        
        return $array;
    }

    /**
     * Retorna un array de DTOs de entidoades de tipo \PeriodoFinanciero
     * @access public
     * @param string $where Si es necesaria, una condicion para filtrar la lista de entidades
     * @return array Array de DTOs de las entidades de periodo financiero
     * @author Andres Ariza <arizaandres@unbosque.edu.co>
     * @since febrero 19, 2019
    */
    public function getList($where = null) {
        $periodos = \PeriodoFinanciero::getList($where);
        $array = array();
        foreach($periodos as $p){
            $obj = new \stdClass();
            $obj->id = $p->getId();
            $obj->nombre = $p->getNombre();
            $obj->fechaInicio = $p->getFechaInicio();
            $obj->fechaFin = $p->getFechaFin();
            $obj->codigoEstado = $p->getCodigoEstado(); 
            
            $eEstado = new \Estado();
            $eEstado->setCodigoestado($obj->codigoEstado);
            $eEstado->setDb();
            $eEstado->getById();
            
            $obj->codigoEstado = $eEstado->getNombreestado();
            
            $idPeriodoMaestro = $p->getIdPeriodoMaestro();
            
            $periodoMaestro = new \PeriodoMaestro();
            $periodoMaestro->setDb();
            $periodoMaestro->setId($idPeriodoMaestro);
            $periodoMaestro->getById();
            
            $objPM = new \stdClass();
            $objPM->id = $idPeriodoMaestro;
            $objPM->codigo = $periodoMaestro->getCodigo();
            
            $obj->periodoMaestro = $objPM;
            
            $array[] = $obj;
        }        
        return $array;
    }

    /**
     * Guarda en base de datos el objeto creado/editado desde la vista de 
     * creacion/edicion de periodos financieros
     * @access public
     * @return array Array con la estructura de respuesta json s => estado, msj => mensaje
     * @author Andres Ariza <arizaandres@unbosque.edu.co>
     * @since febrero 19, 2019
    */
    public function guardarPeriodo() {
        $result = false;
        $this->variables->nombre = mb_strtoupper($this->variables->nombre,"UTF-8");
        $validacion = $this->validarPeriodo();
        if($validacion["s"]){
            $ePeriodoFinanaciero = new \PeriodoFinanciero();
            
            if(!empty($this->variables->id)){
                $ePeriodoFinanaciero->setDb();
                $ePeriodoFinanaciero->setId($this->variables->id);
                $ePeriodoFinanaciero->getById();
                $ePeriodoFinanaciero->setIdUsuarioModificacion(\Factory::getSessionVar("idusuario"));
                $ePeriodoFinanaciero->setFechaModificacion(date("Y-m-d H:i:s"));
            }else{
                $ePeriodoFinanaciero->setIdPeriodoMaestro($this->variables->idPeriodoMaestro);
                $ePeriodoFinanaciero->setCodigoEstado(100);
                $ePeriodoFinanaciero->setIdUsuarioCreacion(\Factory::getSessionVar("idusuario"));
                $ePeriodoFinanaciero->setFechaCreacion(date("Y-m-d H:i:s"));
            }
            $ePeriodoFinanaciero->setNombre($this->variables->nombre);
            $ePeriodoFinanaciero->setFechaInicio($this->variables->fechaInicio);
            $ePeriodoFinanaciero->setFechaFin($this->variables->fechaFin);
            //$ePeriodoFinanaciero
            
            $periodoFinancieroDAO = new \Sala\entidadDAO\PeriodoFinancieroDAO($ePeriodoFinanaciero);
            $periodoFinancieroDAO->setDb();
            $result = $periodoFinancieroDAO->save();
            if($result && !empty($this->variables->id)){
                $this->iActualizaTablasPeriodos = \Sala\lib\AdministracionPeriodos\api\clases\PeriodoFacatory::IActualizarTablasPeriodos($ePeriodoFinanaciero);
                //d($this->iActualizaTablasPeriodos);
                $this->iActualizaTablasPeriodos->actualizarTablaPeriodo();
                $this->iActualizaTablasPeriodos->actualizarTablaSubperiodo();
            }
        }
        echo json_encode($validacion);
        
    }

    /**
     * Valida los datos recibido del periodo financiero antes del guardado
     * @access public
     * @return array Array con la estructura de respuesta json s => estado, msj => mensaje
     * @author Andres Ariza <arizaandres@unbosque.edu.co>
     * @since febrero 19, 2019
    */
    public function validarPeriodo() {
        $return = array("s"=>true,"msj"=>"Periodo guardado/actualizado correctamente");
        
        if(empty($this->variables->id)){
            $return = $this->validarExistenciaDelPeriodo($return);
            if(!$return["s"]){
                return $return;
            }

            $return = $this->validarSecuenciaDelPeriodo($return);        
            if(!$return["s"]){
                return $return;
            }
        }
        
        if(empty($this->variables->nombre)){
            $return["s"] = false;
            $return["msj"] = "Debe digitar el nombre del período financiero";
            return $return;
        }
        
        $return = \Sala\lib\AdministracionPeriodos\api\clases\utiles\ValidacionesComunes::validarFechasIngresadas($return, $this->variables);
        if(!$return["s"]){
            return $return;
        }
        
        return $return;
    }

    /**
     * Valida que el codigo de periodo financiero no esté previamente creado 
     * @access private
     * @param array Array con la estructura de respuesta json  
     * @return array Array con la estructura de respuesta json s => estado, msj => mensaje
     * @author Andres Ariza <arizaandres@unbosque.edu.co>
     * @since febrero 19, 2019
    */
    private function validarExistenciaDelPeriodo($return){
        $db = \Factory::createDbo();
        if(empty($this->variables->idPeriodoMaestro)){
            $return["s"] = false;
            $return["msj"] = "Debe seleccionar el período";
            return $return;
        }
        
        $p = $this->getList(" codigoEstado = 100 AND idPeriodoMaestro = ".$db->qstr($this->variables->idPeriodoMaestro));
        if(!empty($p)){
            $return["s"] = false;
            $return["msj"] = "El periodo seleccionado ya esta asignado a un periodo financiero";
            return $return;
        }
        return $return;
    }

    /**
     * Valida que el periodo financiero respete la secuencia de creacion
     * @access private
     * @param array Array con la estructura de respuesta json 
     * @return array Array con la estructura de respuesta json s => estado, msj => mensaje
     * @author Andres Ariza <arizaandres@unbosque.edu.co>
     * @since febrero 19, 2019
    */
    private function validarSecuenciaDelPeriodo($return){
        $db = \Factory::createDbo();
        
        $queryMaxPeriodo = "SELECT pm.numeroPeriodo "
                . " FROM periodoMaestro pm "
                . " INNER JOIN periodoFinanciero pf ON (pf.idPeriodoMaestro = pm.id) "
                . " INNER JOIN ano a ON (pm.idAgno = a.idano) "
                . " WHERE a.idano=".$db->qstr($this->variables->idanio)
                . " AND pf.codigoEstado = 100 "
                . " ORDER BY pm.numeroPeriodo DESC LIMIT 1";
      
        $rowMaxPeriodoUsado = $db->getRow($queryMaxPeriodo);
        if(empty($rowMaxPeriodoUsado)){
            $maxPeriodoUsado = 0;
        }else{
            $maxPeriodoUsado = $rowMaxPeriodoUsado["numeroPeriodo"];
        }
        unset($rowMaxPeriodoUsado);
        
        $periodoMaestro = new \PeriodoMaestro();
        $periodoMaestro->setId($this->variables->idPeriodoMaestro);
        $periodoMaestro->setDb();
        $periodoMaestro->getById();
        
        $numPeriodoSeleccionado = $periodoMaestro->getNumeroPeriodo();
        unset($periodoMaestro);
        
        if($numPeriodoSeleccionado != ((int)$maxPeriodoUsado+1)){
            $return["s"] = false;
            $return["msj"] = "El periodo financiero no respeta la secuencia";
        }
        
        return $return;
    }
}
