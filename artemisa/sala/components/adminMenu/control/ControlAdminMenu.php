<?php
/**
 * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package control
 */
defined('_EXEC') or die;
require_once(PATH_SITE."/entidad/MenuOpcion.php");
class ControlAdminMenu   { 
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
        if($estado == "01"){
            $action = "despublicar";
            $icon = '<span class="fa-stack fa-lg">
                        <i class="fa fa-square-o fa-stack-2x"></i>
                        <i class="fa fa-check fa-stack-1x"></i>
                    </span> ';
            $class = "text-success";
            $title = 'Clic para '.$action;
        }elseif($estado == "02"){
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
        $MenuOpcion = new MenuOpcion();
        $MenuOpcion->setDb();
        $MenuOpcion->setIdmenuopcion($this->variables->id);
        $MenuOpcion->getMenuOpcionById();
        $nuevoEstado = ($MenuOpcion->getCodigoestadomenuopcion()=="01")?"02":"01"; 
        //d($nuevoEstado);
        $MenuOpcion->setCodigoestadomenuopcion($nuevoEstado);
        $MenuOpcion->saveMenuOpcion();
        
        $boton = ControlAdminMenu::printInconEstado($nuevoEstado, $this->variables->id);
        //ddd($boton);
        echo json_encode(array("s"=>true, "boton"=>$boton));
        exit();
    }
    
    public function save(){
        $response = array("s"=>false, "msj"=>"No se pudo guardar la información");
        $MenuOpcion = new MenuOpcion();
        $MenuOpcion->setDb();
        $MenuOpcion->setLinkmenuopcion($this->variables->linkmenuopcion);
        $MenuOpcion->setNivelmenuopcion($this->variables->nivelmenuopcion);
        $MenuOpcion->setPosicionmenuopcion($this->variables->posicionmenuopcion);
        $MenuOpcion->setFramedestinomenuopcion($this->variables->framedestinomenuopcion);
        $MenuOpcion->setTransaccionmenuopcion($this->variables->transaccionmenuopcion);
        $MenuOpcion->setCodigotipomenuopcion($this->variables->codigotipomenuopcion);
        $MenuOpcion->setNombremenuopcion($this->variables->nombremenuopcion);
        $MenuOpcion->setLinkAbsoluto($this->variables->linkAbsoluto);
        $MenuOpcion->setIdpadremenuopcion($this->variables->idpadremenuopcion);
        $MenuOpcion->setCodigoestadomenuopcion($this->variables->codigoestadomenuopcion);
        $MenuOpcion->setCodigogerarquiarol($this->variables->codigogerarquiarol);
        if(!empty($this->variables->idmenuopcion)){
            $MenuOpcion->setIdmenuopcion($this->variables->idmenuopcion);
        }
        
        $idmenuopcion = $MenuOpcion->getIdmenuopcion();
        
        $estado = $MenuOpcion->saveMenuOpcion();
        
        if($estado){
            $response["s"] = true;
            $response["id"] = $idmenuopcion;
            $response["msj"] = "Guardado exitoso";
        }
        echo json_encode($response);
        exit();
    }
    /**
      * @modified Luis Dario Gualteros C <castroluisd@unbosque.edu.co>
      * Se crea la funcion activarMenuEnSesion para que permita administrar el itemId por la Sesión.  
      * Ajuste de acceso por usuario por la opción de Gestion de Permisos del plan de Desarrollo.
      * @since 21 de Febrero 2019.
    */
    public function activarMenuEnSesion(){
        $itemId = $this->variables->itemId;
        Factory::setSessionVar("itemId", $itemId);
        echo json_encode(array("s"=>true));
    }
}