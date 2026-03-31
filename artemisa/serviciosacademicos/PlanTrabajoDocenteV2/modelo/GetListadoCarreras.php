<?php
/**
 * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package model
 */
defined('_EXEC') or die; 
class GetListadoCarreras implements Model{
    /**
     * @type adodb Object
     * @access private
     */
    private $db;
    
    public function GetListadoCarreras($db) {
        $this->db = $db;
    }
    
    public function getVariables($variables){
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
        
        if(!empty($variables->carreraSeleccionada)){ 
            $array["codigoCarrera"] = $variables->carreraSeleccionada;
        }
        
        $listaAutoevaluacionDoncentes = AutoevaluacionDocentes::getList(" ".implode(" AND ", $where)." ORDER BY CodigoPeriodo DESC ");
        //ddd($listaAutoevaluacionDoncentes);
        $idsCarreras = array();
        foreach($listaAutoevaluacionDoncentes as $ad){
            $idsCarreras[] = $ad->getCodigoCarrera();
        }
        $idsCarreras = array_unique($idsCarreras);
        $listaCarreras = array();
        if(!empty($idsCarreras)){
            $listaCarreras = Carrera::getList(" codigocarrera IN (".implode(",",$idsCarreras).") ");
        }
        
        $array["listaCarreras"] = $listaCarreras;
        
        return $array;
    }
     
}
