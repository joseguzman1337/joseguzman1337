<?php
/**
 * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package model
 */
defined('_EXEC') or die; 
class DashBoard implements Model{
    /**
     * @type adodb Object
     * @access private
     */
    private $db;
    
    public function DashBoard($db) {
        $this->db = $db;
    }
    
    public function getVariables($variables){
        require_once(PATH_SITE.'/entidad/Docente.php');
        require_once(PATH_SITE.'/entidad/AutoevaluacionDocentes.php');
        require_once(PATH_SITE.'/entidad/Carrera.php');
        require_once(PATH_SITE.'/entidad/Periodo.php');
        require_once(PATH_SITE.'/entidad/PeriodosVirtuales.php');
        $array = array();
        
        $codigoperiodosesion = Factory::getSessionVar('codigoperiodosesion');
        
        if(!empty($variables->codigoperiodo)){
            $codigoPeriodo = $variables->codigoperiodo;
        }else{
            $codigoPeriodo = $codigoperiodosesion;
        }
        //d($variables);
        $where = array();
        $where[]= "CodigoPeriodo = ".$this->db->qstr($codigoPeriodo);
        
        $idsDocentes = array();
        $idsCarreras = array();
        
        $listaAutoevaluacionDoncentes1 = AutoevaluacionDocentes::getList(" ".implode(" AND ", $where)." ORDER BY CodigoPeriodo DESC ");
        foreach($listaAutoevaluacionDoncentes1 as $ad){
            $idsCarreras[] = $ad->getCodigoCarrera();
        }
        if(!empty($variables->codigocarrera)){
            $where[]= "CodigoCarrera = ".$this->db->qstr($variables->codigocarrera);
            $array["codigoCarrera"] = $variables->codigocarrera;
        }
        
        $listaAutoevaluacionDoncentes1 = AutoevaluacionDocentes::getList(" ".implode(" AND ", $where)." ORDER BY CodigoPeriodo DESC ");
        //d($listaAutoevaluacionDoncentes1);
        foreach($listaAutoevaluacionDoncentes1 as $ad){
            $idsDocentes[] = $ad->getDocenteId();
        }
        
        if(!empty($variables->iddocente)){
            $where[]= "DocenteId = ".$this->db->qstr($variables->iddocente);
            $array["idDocente"] = $variables->iddocente;
        }
        
        $listaAutoevaluacionDoncentes = AutoevaluacionDocentes::getList(" ".implode(" AND ", $where)." ORDER BY CodigoPeriodo DESC ");
        
        $idsDocentes = array_unique($idsDocentes);
        $idsCarreras = array_unique($idsCarreras);
        
        d($idsDocentes);
        
        $listaDocentes = array();
        if(!empty($idsDocentes)){
            $listaDocentes = Docente::getList(" codigoestado = 100 AND iddocente IN (".implode(",",$idsDocentes).")");
        }
        
        $listaCarreras = array();
        if(!empty($idsCarreras)){
            $listaCarreras = Carrera::getList(" codigocarrera IN (".implode(",",$idsCarreras).") ");
        }
        $listaPeriodos = Periodo::getList(" 1 ORDER BY codigoperiodo DESC");
        //d($listaDocentes);
        $array["listaAutoevaluacionDoncentes"] = $listaAutoevaluacionDoncentes;
        $array["listaDocentes"] = $listaDocentes;
        $array["listaCarreras"] = $listaCarreras;
        $array["listaPeriodos"] = $listaPeriodos;
        $array["codigoPeriodo"] = $codigoPeriodo;
        
        return $array;
    }
    
    
    public static function printInconEditar($id){
        $action = "editar";
        $icon = '<span class="fa-stack fa-lg">
                    <i class="fa fa-square-o fa-stack-2x"></i>
                    <i class="fa fa-pencil fa-stack-1x"></i> 
                </span> ';
        $title = 'Clic para editar';
        
        $return='<a class="accion" href="#" data-id="'.$id.'" data-action="'.$action.'" data-toggle="tooltip" title="'.$title.'" >'.$icon.'</a>';
        
        echo $return;
    }
     
}
