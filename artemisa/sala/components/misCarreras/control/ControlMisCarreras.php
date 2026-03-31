<?php
/**
 * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package control
 */
defined('_EXEC') or die;
require_once(PATH_SITE."/entidad/Carrera.php");
class ControlMisCarreras   { 
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
    
    public function seleccionarCarrera(){
        if(!empty($this->variables->codigoCarrera)){
            Factory::setSessionVar("codigofacultad", $this->variables->codigoCarrera);
            $Carrera = new Carrera();
            $Carrera->setDb();
            $Carrera->setCodigocarrera($this->variables->codigoCarrera);
            $Carrera->getByCodigo();
            
            Factory::setSessionVar('carreraEstudiante', $Carrera);
            Factory::setSessionVar("nombrefacultad", $Carrera->getNombrecarrera());
            
            $Periodo = Servicios::getPeriodoVigente();
            $PeriodoVirtual = Servicios::getPeriodoVirtualVigente($Carrera);
            
            Factory::setSessionVar('PeriodoSession', $Periodo);
            Factory::setSessionVar('PeriodoVirtualSession', $PeriodoVirtual);
            Factory::setSessionVar('codigoperiodosesion', $Periodo->getCodigoperiodo());
            
            Factory::inicializarPeridos();
            echo json_encode(array("s" => true));
        }else{
            echo json_encode(array("s" => false));
        }
        //d($_SESSION);
        exit();
    }
}