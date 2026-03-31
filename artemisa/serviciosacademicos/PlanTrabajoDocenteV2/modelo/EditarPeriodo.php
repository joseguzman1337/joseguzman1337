<?php
/**
 * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package model
 */
defined('_EXEC') or die; 
class EditarPeriodo implements Model{
    /**
     * @type adodb Object
     * @access private
     */
    private $db;
    
    public function EditarPeriodo($db) {
        $this->db = $db;
    }
    
    public function getVariables($variables){
        require_once(PATH_SITE.'/entidad/AutoevaluacionDocentes.php');
        require_once(PATH_SITE.'/entidad/Periodo.php'); 
        $array = array();
        
        $AutoevaluacionDocentes = new AutoevaluacionDocentes();
        $AutoevaluacionDocentes->setAutoevaluacionDocentesId($variables->id);
        $AutoevaluacionDocentes->setDb();
        $AutoevaluacionDocentes->getById();
        //d($AutoevaluacionDocentes);
        
        $listaPeriodos = Periodo::getList(" 1 ORDER BY codigoperiodo DESC");
        
        $array["codigoPeriodo"] = $AutoevaluacionDocentes->getCodigoPeriodo();
        $array["listaPeriodos"] = $listaPeriodos;
        $array["id"] = $variables->id;
        
        return $array;
    }
    
    public function actualizarPeriodo($variables){
        require_once(PATH_SITE.'/entidad/AutoevaluacionDocentes.php');
        $curDate = date("Y-m-d h:i:s");
        /*d($_SESSION);
        d($curDate);
        d($variables);/**/
        
        $AutoevaluacionDocentes = new AutoevaluacionDocentes();
        $AutoevaluacionDocentes->setAutoevaluacionDocentesId($variables->id);
        $AutoevaluacionDocentes->setDb();
        $AutoevaluacionDocentes->getById();
        
        $AutoevaluacionDocentes->setCodigoPeriodo($variables->codigoNuevoPeriodo);
        $AutoevaluacionDocentes->setFechaUltimaModificacion($curDate);
        $AutoevaluacionDocentes->setUsuarioUltimaModificacion(Factory::getSessionVar('idusuario'));
        
        $AutoevaluacionDocentes->save();
        
        echo json_encode(array("s"=>true, "msg"=>"Registro Actualizado"));
        exit();
    }
}