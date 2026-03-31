<?php
defined('_EXEC') or die;
/**
 * Clase ControlEjecucionTareas para orquestacion de la carga de templates, 
 * componentes y modulos, y tambien de la ejecucion de sus task y actions
 * 
 * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package control
 */
class ControlEjecucionTareas{
    /**
     * $db es una variable privada, es la contenedora de la instancia singleton 
     * del objeto adodb de conexion a base de datos de sala
     * 
     * @var adodb Object
     * @access protected static
     */
    private $db;
    
    /**
     * $variables es una variable privada, contenedora de el objeto estandar en 
     * el cual se setean todas las variables recibidas por el sistema a nivel 
     * POST, GET y REQUEST
     * 
     * @var stdObject
     * @access private
     */
    private $variables; 
    
    /**
     * $Configuracion es una variable privada, es la contenedora de la 
     * instancia singleton del objeto Configuration
     * 
     * @var Configuration 
     * @access private static
     */
    private $Configuracion;

    /**
     * Constructor de la clase ControlEjecucionTareas,
     * @param stdClass $variables
     * @param Configuration $Configuracion
     * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
     * @return void
     */  
    function __construct($variables, $Configuracion) {
        $this->db = Factory::createDbo();
        $this->variables = $variables;
        $this->Configuracion = $Configuracion;
    }

    /**
     * Ejecuta cualquier tarea solicitada por request a traves de la variable
     * action, si viene acompañada de una solicitud de option esta accion se 
     * ejecuta en el controlador de componente option, de lo contrario busca
     * ejecutarla en la clase ControlEjecucionTareas
     * @param String $action
     * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
     * @access public
     * @return void
     */ 
    public function execute($action){
        if(!empty($action)){
            $option = @$this->variables->option;
            //ddd($option);
            if(!empty($option)){
                $controlClass = "Control".ucfirst($option);
                //d(PATH_SITE.'/components/'.$option.'/control/'.$controlClass.'.php');
                if(!empty($action) && is_file(PATH_SITE.'/components/'.$option.'/control/'.$controlClass.'.php')){
                    require_once (PATH_SITE.'/components/'.$option.'/control/'.$controlClass.'.php');
                    $Control = new $controlClass($this->variables);
                    $Control->$action();
                }elseif(!empty($action)){
                    $this->$action();
                }
            }elseif(!empty($action)){
                $this->$action();
            }
            exit();
        }
    }

    /**
     * Metodo encargado de la renderizacion del templayte solicitado por request
     * @param String $option
     * @param String $layout
     * @param String $task
     * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
     * @access public
     * @return void
     */ 
    public function go($option, $layout, $task){
        $return = false;
        $path = null;
        if(!empty($this->variables->json)){
            $this->variables->tmpl = "json";
            $return = true;            
        }
        //d($this->variables);
        if((empty($this->variables->tmpl) || $this->variables->tmpl!="json") && $this->variables->option=="dashBoard"){
            Factory::inicializarPeridos();
        }
        
        require_once (PATH_SITE.'/modelo/Defecto.php');
        
        $ModeloDefault = new Defecto($this->db);
        
        $arrayTemplate = array();
        $arrayTemplate['tituloSeccion'] = $ModeloDefault->getTituloSeccion($option);
        
        $arrayTemplate['breadCrumb'] = Factory::getBreadCrumbs($option,$this->variables);
        
        $array = array();
        $array = $ModeloDefault->getVariables($this->variables);
        $array['task'] = $task;
        $array['option'] = $option;
        $array['variables'] = $this->variables; 
        
        $arrayTemplate = array_merge($arrayTemplate,$array);
        
        $arrayTemplate['component'] = null;
        
        if(!empty($option)){
            $arrayTemplate['component'] = $this->getRenderComponente($option, $task, $layout, $array);
        }
        
        $template = $this->Configuracion->getTemplate();
        if(empty($this->variables->tmpl)){
            $layout = "default";
        }else{
            $layout = $this->variables->tmpl;
        }
        $controlRender = Factory::getRenderInstance();
        $template = $controlRender->render($template."/".$layout,$path,$arrayTemplate, $return);
        if(!empty($this->variables->json)){
            echo json_encode(array('s'=>true,'msj'=>$template));
            exit(); 
        }
    }
    
    public function validarNombreCarrera(){
        require_once (PATH_SITE."/entidad/Carrera.php");
        
        $response = array("s"=>false);
        $idCarrera = Factory::getSessionVar('codigofacultad'); 
        if(@$this->variables->idCarrera != $idCarrera){
            $Carrera = new Carrera();
            $Carrera->setDb();
            $Carrera->setCodigocarrera($idCarrera);
            $Carrera->getByCodigo();
            
            $response["s"] = true;
            $response["idCarrera"] = $Carrera->getCodigocarrera();
            $response["nombreCarrera"] = $Carrera->getNombrecarrera();            
        }
        echo json_encode($response);
    }
    
    /**
     * Metodo encargado de la renderizacion de componentes solicitados
     * por request
     * @param String $option
     * @param String $layout
     * @param String $task
     * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
     * @access public
     * @return void
     */ 
    private function getRenderComponente($option, $task, $layout, $array){
        $path =  null;
        $layout =  $this->Configuracion->getTemplate()."/permisoDenegado";
        if($this->checkPermisions()){
            $modeloClass = ucfirst($option);
            if(!is_file(PATH_SITE.'/components/'.$option.'/modelo/'.$modeloClass.'.php')){
                $modeloClass = "Defecto";
            }
            require_once (PATH_SITE.'/components/'.$option.'/modelo/'.$modeloClass.'.php');

            $Modelo = new $modeloClass($this->db);

            /**
             * @modified Andres Ariza <arizaandres@unbosque.edu.do>
             * Se agrega la siguiente validacion para verificar que los clases Modelo implementen la interface Model
             * @since mayo 5, 2018
             */
            if (!($Modelo instanceof Model)) {
                throw new Exception('El modelo '.$modeloClass.' no implementa la interface Model');
            }

            $array['task'] = $task;
            $array['variables'] = $this->variables;

            $variablesModelo = $Modelo->getVariables($this->variables);

            $array = array_merge($array,$variablesModelo); 

            $controlClass = "Control".ucfirst($option);
            if(is_file(PATH_SITE.'/components/'.$option.'/control/'.$controlClass.'.php')){
                require_once (PATH_SITE.'/components/'.$option.'/control/'.$controlClass.'.php');

                $Control = new $controlClass($this->variables);
                if(!empty($task)){
                    $Control->$task();
                }
            }
            if(!empty($this->variables->layout) && $layout!=$this->variables->layout){
                $layout = $this->variables->layout;
            }
            $path = "/components/".$option;
        }
        $componentRender = Factory::getRenderInstance();
        return $componentRender->render($layout, $path,$array, true);
    }
    
    /**
     * Metodo encargado de validar si hay gestion de permisos para los componentes
     * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
     * @access private
     * @return void
     */ 
    private function checkPermisions(){
        $return = true;
        $where = " idComponenteModulo = ".$this->db->qstr($this->variables->itemId);
        $permisos =  \Sala\entidad\Permiso::getList($where);
        if(!empty($permisos)){
            $usuario = Factory::getSessionVar('usuario');
            if(empty($usuario)){
                $usuario = Factory::getSessionVar('MM_Username');
            }
            $return = Sala\lib\ControlAcceso\impl\PermisosImpl::validarPermisosComponenteUsuario($usuario, $this->variables->itemId);
        }
        return $return;
    }
     
}