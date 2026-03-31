<?php
/**
 * @author 
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package control
 */
defined('_EXEC') or die;
require_once(PATH_SITE."/entidad/Periodo.php");
class ControlEvaluacionDocente{ 
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
    
    public function seleccionarMateria(){
        if(!empty($this->variables->codigoPeriodo)){
            Factory::setSessionVar('codigoperiodosesion', $this->variables->codigoPeriodo);
            $Periodo = new Periodo();
            $Periodo->setDb();
            $Periodo->setCodigoperiodo($this->variables->codigoPeriodo);
            $Periodo->getById(); 
            echo json_encode(array("s" => true, "nombrePeriodo" => $Periodo->getNombreperiodo()));
        }else{
            echo json_encode(array("s" => false));
        }
        exit();
    }
}