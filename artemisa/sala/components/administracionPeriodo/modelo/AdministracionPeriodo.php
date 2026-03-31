<?php

/**
 * @author Diego Rivera<riveradiego@unbosque.edu.do>
 * @copyright Universidad el Bosque - Dirección de Tecnología
 * @package modelo
 */
defined('_EXEC') or die;
require_once(PATH_SITE . "/entidad/Ano.php");
require_once(PATH_SITE . "/entidad/PeriodoMaestro.php");
require_once(PATH_SITE . "/entidad/PeriodoFinanciero.php"); 

require_once(PATH_SITE."/includes/salaAutoloader.php");
spl_autoload_register('salaAutoloader');
use Sala\lib\AdministracionPeriodos\api\clases\PeriodoFacatory;


class AdministracionPeriodo implements Model {

    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    /** 
     * Consulta las y retorna el un array de variables que se utilizan en el render de los componentes
     * @access public
     * @param stdClass $variables
     * @return array
     * @author Diego Fernando Rivera Castro<riveradiego@unbosque.edu.co>
     * @since febrero 19, 2019
    */
    public function getVariables($variables) { 
        $array = array();
        $variables = $this->setDefaultValues($variables);       
        if(!empty($variables->dataType)){ 
            $array["displayClassNew"] = "hide";
            $array["displayClassEdit"] = "";
            $objetoPeriodo = PeriodoFacatory::IPeriodo($variables->dataType);
            if (!($objetoPeriodo instanceof \Sala\lib\AdministracionPeriodos\api\interfaces\IPeriodo)) {
                throw new Exception('El objeto construido no implementa la interface IPeriodo');
            }
            $objetoPeriodo->setVariables($variables);
            $ejecutar = $variables->dataAction."Periodo";
            $variablesDelTipo = $objetoPeriodo->$ejecutar();
            $array = array_merge($array, $variablesDelTipo);            
            if(empty($variables->id)){
                $array["displayClassNew"] = "";
                $array["displayClassEdit"] = "hide";
            }           
        }else{
            $array = $this->getDefaultVariables();
        }                
        return $array;
    }
    
    /**
     * @access private
     * @param  $variables
     * @return array
     * @author Diego Fernando Rivera Castro<riveradiego@unbosque.edu.co>
     * @since febrero 19, 2019
    */
    private function setDefaultValues($variables){        
        if (empty($variables->layout)) {
            $variables->layout = null;
        }
        
        if(empty($variables->dataType)){
            $variables->dataType = null;
        }
        
        if(empty($variables->dataAction)){
            $variables->dataAction = null;
        }
        return $variables;
    }
    
    /**
     * @access private
     * @return array
     * @author Andres Ariza <arizaandres@unbosque.edu.co>
     * @since marzo 19, 2019
    */
    private function getDefaultVariables($default = false){
        $array = array();
        $codigoModalidad = 1;
        $carreraSession = Factory::getSessionVar("carreraEstudiante");
        
        if($default){
            $codigoCarrera = 1;
        }else{
            $codigoCarrera = $carreraSession->getCodigocarrera();
            if($codigoCarrera>1){
                $codigoModalidad = $carreraSession->getCodigomodalidadacademica();
            }
        }
        $array["nombreCarrera"] = $carreraSession->getNombrecarrera();
        
        $where = " idEstadoPeriodo = 1 "
                . " AND codigoCarrera = ".$this->db->qstr($codigoCarrera)
                . " AND codigoModalidadAcademica = ".$this->db->qstr($codigoModalidad);
        
        $ePeriodoAcademico = PeriodoAcademico::getList($where);
        
        if(!empty($ePeriodoAcademico)){
            $maestroAcademico = new PeriodoMaestro();
            $maestroAcademico->setDb();
            $maestroAcademico->setId($ePeriodoAcademico[0]->getIdPeriodoMaestro());
            $maestroAcademico->getById();
            $array["periodoAcademicoActual"] = $maestroAcademico->getNombre();
            $array["codigoPeriodoAcademicoActual"] = $maestroAcademico->getCodigo();
            
            $periodoFinanciero = new PeriodoFinanciero();
            $periodoFinanciero->setDb();
            $periodoFinanciero->setId($ePeriodoAcademico[0]->getIdPeriodoFinanciero());
            $periodoFinanciero->getById();
            
            $array["periodoFinancieroActual"] = $periodoFinanciero->getNombre();
            
            $maestroFinanciero = new PeriodoMaestro();
            $maestroFinanciero->setDb();
            $maestroFinanciero->setId($periodoFinanciero->getIdPeriodoMaestro());
            $maestroFinanciero->getById();
            $array["codigoPeriodoFinancieroActual"] = $maestroFinanciero->getCodigo();
        }
        
        if(empty($ePeriodoAcademico) && $default ){
            $periodoSession = Factory::getSessionVar('PeriodoSession');
            $array["periodoAcademicoActual"] = $periodoSession->getNombreperiodo();
            $array["codigoPeriodoAcademicoActual"] = $periodoSession->getCodigoperiodo();
            $array["periodoFinancieroActual"] = $periodoSession->getNombreperiodo();
            $array["codigoPeriodoFinancieroActual"] = $periodoSession->getCodigoperiodo();
        }elseif( empty($ePeriodoAcademico) && !$default ){
            $array = $this->getDefaultVariables(true);
        }
                
        return $array;
    }
}
