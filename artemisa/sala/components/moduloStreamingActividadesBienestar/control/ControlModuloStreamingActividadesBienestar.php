<?php
/** 
 * @author vega Gabriel <vegagabriel@unbosque.edu.do>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package control
 */
defined('_EXEC') or die;
require_once(PATH_SITE."/entidad/StreamingActividadesBienestar.php");
class ControlModuloStreamingActividadesBienestar   { 
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
    
    public static function printInconEstado($estado, $id){
        $class = '';
        $title = '';
        if($estado == "100"){
            $action = "despublicar";
            $icon = '<span class="fa-stack fa-lg">
                        <i class="fa fa-square-o fa-stack-2x"></i>
                        <i class="fa fa-check fa-stack-1x"></i>
                    </span> ';
            $class = "text-success";
            $title = 'Clic para '.$action;
        }elseif($estado == "200"){
            $action = "publicar";
            $icon = '<span class="fa-stack fa-lg">
                    <i class="fa fa-circle fa-stack-2x"></i>
                    <i class="fa fa-times fa-stack-1x fa-inverse"></i>
                </span>  ';
            $class = "text-danger";
            $title = 'Clic para '.$action;
        }
        
        $return='<a class="accion '.$class.'" href="#" data-id="'.$id.'" data-action="'.$action.'"  data-toggle="tooltip" title="'.$title.'" >'.$icon.'</a>';
        
        return $return;
    }
    
    public static function printInconEditar($id){
        $class = 'text-warning';        
        $action = "editar";
        $icon = '<span class="fa-stack fa-lg">
                    <i class="fa fa-square-o fa-stack-2x"></i>
                    <i class="fa fa-pencil fa-stack-1x"></i> 
                </span> ';
        $title = 'Clic para editar';
        
        $return='<a class="accion '.$class.'" href="#" id="edit-icon-'.$id.'" data-id="'.$id.'" data-action="'.$action.'" data-toggle="tooltip" title="'.$title.'" >'.$icon.'</a>';
        
        return $return;
    }
    
    public function publicarDespublicar(){
        $StreamingActividadesBienestar = new StreamingActividadesBienestar();
        $StreamingActividadesBienestar->setDb();
        $StreamingActividadesBienestar->setId($this->variables->id);
        $StreamingActividadesBienestar->getById();
        $nuevoEstado = ($StreamingActividadesBienestar->getCodigoEstado()=="100")?"200":"100"; 
        //d($nuevoEstado);
        $StreamingActividadesBienestar->setCodigoEstado($nuevoEstado);
        $StreamingActividadesBienestar->saveStreamingActividadesBienestar();
        
        $boton = ControlModuloStreamingActividadesBienestar::printInconEstado($nuevoEstado, $this->variables->id);
        //ddd($boton);
        echo json_encode(array("s"=>true, "boton"=>$boton));
        exit();
    }
    
    public function save(){
        $response = array("s"=>false, "msj"=>"No se pudo guardar la informacion");
        $StreamingActividadesBienestar = new StreamingActividadesBienestar();
        $StreamingActividadesBienestar->setDb();  
        $StreamingActividadesBienestar->setUrl($this->variables->url);
        $StreamingActividadesBienestar->setTipo($this->variables->tipo);        
        $StreamingActividadesBienestar->setUsuarioCreacion($this->variables->usuarioCreacion);
        $StreamingActividadesBienestar->setUsuarioModificacion($this->variables->usuarioModificacion);
        $StreamingActividadesBienestar->setFechaCreacion($this->variables->fechaCreacion);
        $StreamingActividadesBienestar->setFechaModificacion($this->variables->fechaModificacion);
        $StreamingActividadesBienestar->setCodigoEstado($this->variables->codigoEstado);
    
        
        if(!empty($this->variables->id)){
            $StreamingActividadesBienestar->setId($this->variables->id);
        }
        
        $id = $StreamingActividadesBienestar->getId();
        
        $estado = $StreamingActividadesBienestar->saveStreamingActividadesBienestar();
        
        if($estado){
            $response["s"] = true;
            $response["id"] = $id;
            $response["msj"] = "Guardado exitoso";
        }
        echo json_encode($response);
        exit();
    }
}
