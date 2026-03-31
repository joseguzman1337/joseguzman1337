<?php
/**
 * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package control
 */
defined('_EXEC') or die;
require_once(PATH_SITE."/entidad/Periodo.php");
require_once(PATH_SITE."/entidad/PeriodoVirtualCarrera.php");
class ControlCambioPeriodo{ 
    /**
     * @type adodb Object
     * @access private
     */
    private $db;
    
    /**
     * @type stdObject
     * @access private
     */
    private $variables;
    
    public function __construct($variables) {
        $this->db = Factory::createDbo();
        $this->variables = $variables; 
    }
    
    public function seleccionarPeriodo(){
        //d($_SESSION);
        //d($this->variables);
        if(!empty($this->variables->codigoPeriodo)){
            Factory::setSessionVar('codigoperiodosesion', $this->variables->codigoPeriodo);
            $Periodo = new Periodo();
            $Periodo->setDb();
            $Periodo->setCodigoperiodo($this->variables->codigoPeriodo);
            $Periodo->getById();
            
            Factory::setSessionVar('PeriodoSession', $Periodo);
            
            $nombrePeriodo = $Periodo->getNombreperiodo();
            
            if(!empty($this->variables->idPeriodoVirtual)){
                $PeriodoVirtualCarrera = new PeriodoVirtualCarrera();
                $PeriodoVirtualCarrera->setDb();
                $PeriodoVirtualCarrera->setId($this->variables->idPeriodoVirtual);
                $PeriodoVirtualCarrera->getById();
                
                $nombrePeriodo = $PeriodoVirtualCarrera->getPeriodoVirtual()->getNombrePeriodo();
                Factory::setSessionVar('PeriodoVirtualSession', $PeriodoVirtualCarrera);
            }
            // 'PeriodoVirtualSession'
            echo json_encode(array("s" => true, "nombrePeriodo" => $nombrePeriodo));
        }else{
            echo json_encode(array("s" => false));
        }
        exit();
    }
}