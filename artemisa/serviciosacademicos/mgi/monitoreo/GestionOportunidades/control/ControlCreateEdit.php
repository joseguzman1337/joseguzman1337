<?php
/**
 * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package control
 */
defined('_EXEC') or die;
class ControlCreateEdit {
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
    
    function ControlCreateEdit($variables) {        
        $this->db = Factory::createDbo();
        $this->variables = $variables;
    }
    
    public static function printInconEditar($id){
        $class = 'text-success';        
        $action = "editar";
        $icon = '<span class="fa-stack fa-lg">
                    <i class="fa fa-square-o fa-stack-2x"></i>
                    <i class="fa fa-pencil fa-stack-1x"></i> 
                </span> ';
        $title = 'Clic para editar';
        
        $return='<a class="accion '.$class.'" href="#" id="edit-icon-'.$id.'" data-id="'.$id.'" data-action="'.$action.'" data-toggle="tooltip" title="'.$title.'" >'.$icon.'</a>';
        
        return $return;
    }
    
    public static function printInconEliminar($id){
        $class = 'text-success';        
        $action = "eliminar";
        $icon = '<span class="fa-stack fa-lg">
                    <i class="fa fa-square-o fa-stack-2x"></i>
                    <i class="fa fa-trash fa-stack-1x"></i> 
                </span> ';
        $title = 'Clic para eliminar';
        
        $return='<a class="accion '.$class.'" href="#" id="edit-icon-'.$id.'" data-id="'.$id.'" data-action="'.$action.'" data-toggle="tooltip" title="'.$title.'" >'.$icon.'</a>';
        
        return $return;
    }
}
