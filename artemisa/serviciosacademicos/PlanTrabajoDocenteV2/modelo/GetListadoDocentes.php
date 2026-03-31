<?php
/**
 * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package model
 */
defined('_EXEC') or die; 
class GetListadoDocentes implements Model{
    /**
     * @type adodb Object
     * @access private
     */
    private $db;
    
    public function GetListadoDocentes($db) {
        $this->db = $db;
    }
    
    public function getVariables($variables){
        require_once(PATH_SITE.'/entidad/Docente.php');
        require_once(PATH_SITE.'/entidad/AutoevaluacionDocentes.php');
        require_once(PATH_SITE.'/entidad/Carrera.php');
        $array = array();
        
        $codigoperiodosesion = Factory::getSessionVar('codigoperiodosesion');
        
        if(!empty($variables->codigoPeriodo)){
            $codigoPeriodo = $variables->codigoPeriodo;
        }else{
            $codigoPeriodo = $codigoperiodosesion;
        }
        //d($variables);
        $where = array();
        $where[]= "CodigoPeriodo = ".$this->db->qstr($codigoPeriodo);
        
        if(!empty($variables->codigoCarrera)){
            $where[]= "codigoCarrera = ".$this->db->qstr($variables->codigoCarrera);
            $array["codigoCarrera"] = $variables->codigoCarrera;
        }
        
        if(!empty($variables->docenteSeleccionado)){
            $array["idDocente"] = $variables->docenteSeleccionado;
        }
        
        $listaAutoevaluacionDoncentes = AutoevaluacionDocentes::getList(" ".implode(" AND ", $where)." ORDER BY CodigoPeriodo DESC ");
        //ddd($listaAutoevaluacionDoncentes);
        $idsDocentes = array();
        foreach($listaAutoevaluacionDoncentes as $ad){
            $idsDocentes[] = $ad->getDocenteId();
        }
        $idsDocentes = array_unique($idsDocentes);
        
        $listaDocentes = array();
        if(!empty($idsDocentes)){
            $listaDocentes = Docente::getList(" codigoestado = 100 AND iddocente IN (".implode(",",$idsDocentes).")");
        }
        
        $array["listaDocentes"] = $listaDocentes;
        
        return $array;
    }     
}
