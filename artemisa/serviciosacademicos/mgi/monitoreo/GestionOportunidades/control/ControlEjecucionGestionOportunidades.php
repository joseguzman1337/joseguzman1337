<?php
/**
 * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package control
 */
defined('_EXEC') or die;
require_once (PATH_GESTION.'/control/ControlRenderGestionOportunidades.php');
class ControlEjecucionGestionOportunidades {
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
    
    /**
     * @type Configuracion Object
     * @access private
     */
    private $Configuracion;
    
    function ControlEjecucionGestionOportunidades($variables, $Configuracion) {        
        $this->db = Factory::createDbo();
        $this->variables = $variables;
        $this->Configuracion = $Configuracion;
        //ddd($this);
    }
    
    public function ejecutar($action){
        if(!empty($action)){
            $this->$action();
            exit();
        }
    }
    
    public function ir($option = 'default', $layout = 'default', $task=null){
        $return = false;
        if(empty($layout)){
            $layout = 'default';
            $this->variables->layout = $layout;
        }
        $path = null;
        if(!empty($this->variables->json)){
            $this->variables->tmpl = "json";
            $return = true;            
        }
        
        require_once (PATH_GESTION.'/modelo/GestionOportunidades.php');
        $ModeloDefault = new GestionOportunidades($this->db);
        
        $arrayTemplate = array();
        
        $array = array();
        $array = $ModeloDefault->getVariables($this->variables);
        if(!empty($task)){
            $ModeloDefault->ejecutarTask($this->variables);
        }
        $array['task'] = $task;
        $array['option'] = $option;
        $array['variables'] = $this->variables; 
        
        $arrayTemplate = array_merge($arrayTemplate,$array);
        
        if(!empty($this->variables->json)){
            $return = true;
        }else{
            $return = false;
        }
        $controlRender = new ControlRenderGestionOportunidades();
        $template = $controlRender->render($layout,$option,$arrayTemplate, true);
        if(!empty($this->variables->json)){
            echo json_encode(array('s'=>true,'msj'=>$template));
            exit(); 
        }else{
            $template = $controlRender->render($this->variables->tmpl,$option,array('contenido'=>$template), false);
        }
    }
    
    private function save(){
        require_once(PATH_SITE."/entidad/SiqOportunidades.php");
        
        $SiqOportunidades = new SiqOportunidades();
        $usuarioCreacion = Factory::getSessionVar('idusuario');
        $fechaActual = date("Y-m-d");
        $codigoEstado = 100;
        if(!empty($this->variables->idsiq_oportunidad)){
            $SiqOportunidades->setIdsiq_oportunidad($this->variables->idsiq_oportunidad);
        }else{
            $SiqOportunidades->setUsuariomodificacion($usuarioCreacion);
            $SiqOportunidades->setFechamodificacion($fechaActual);
        }
        
        if(!empty($this->variables->usuariocreacion)){
            $usuarioCreacion = $this->variables->usuariocreacion;
        }
        $SiqOportunidades->setUsuariocreacion($usuarioCreacion);
        
        if(!empty($this->variables->fechacreacion)){
            $fechaActual = $this->variables->fechacreacion;
        }        
        $SiqOportunidades->setFechacreacion($fechaActual);
        
        if(!empty($this->variables->codigoestado)){
            $codigoEstado = $this->variables->codigoestado;
        }
        $SiqOportunidades->setcodigoestado($codigoEstado);
        
        //$SiqOportunidades->setIdsiq_estructuradocumento($this->variables->idsiq_estructuradocumento);
        $SiqOportunidades->setIdsiq_factorestructuradocumento($this->variables->idsiq_factorestructuradocumento);
        $SiqOportunidades->setIdsiq_tipooportunidad($this->variables->idsiq_tipooportunidad);
        $SiqOportunidades->setNombre($this->variables->nombre);
        $SiqOportunidades->setDescripcion($this->variables->descripcion);/**/
        
        $SiqOportunidades->setDb();
        $return = $SiqOportunidades->save();
        
        if($return){
            $msj = "Guardado exitoso";
        }else{
            $msj = "Error al guardar";
        }
        echo json_encode(array("s"=>$return, "msj"=>$msj));
    }
    
    private function eliminar(){
        require_once(PATH_SITE."/entidad/SiqOportunidades.php");
        
        $SiqOportunidades = new SiqOportunidades();
        $SiqOportunidades->setDb();
        $SiqOportunidades->setIdsiq_oportunidad($this->variables->id);
        $SiqOportunidades->getById();
        $SiqOportunidades->setCodigoestado(300);
        $return = $SiqOportunidades->save();
        
        if($return){
            $msj = "El registro fué eliminado";
        }else{
            $msj = "Error al eliminar el registro";
        }
        echo json_encode(array("s"=>$return, "msj"=>$msj));
    }
}