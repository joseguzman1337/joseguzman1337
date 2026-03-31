<?php 
/**
 * @author vega Gabriel <vegagabriel@unbosque.edu.do>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package control
 */
defined('_EXEC') or die;
require_once(PATH_SITE."/entidad/ActividadesBienestar.php");
class ControlModuloActividadesBienestar   { 
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
        $ActividadesBienestar = new ActividadesBienestar();
        $ActividadesBienestar->setDb();
        $ActividadesBienestar->setId($this->variables->id);
        $ActividadesBienestar->getById();
        $nuevoEstado = ($ActividadesBienestar->getCodigoEstado()=="100")?"200":"100"; 
//        //d($nuevoEstado);
        $ActividadesBienestar->setCodigoEstado($nuevoEstado);
        $ActividadesBienestar->saveActividadesBienestar();
        
        $boton = ControlModuloActividadesBienestar::printInconEstado($nuevoEstado, $this->variables->id);
        //ddd($boton);
        echo json_encode(array("s"=>true, "boton"=>$boton));
        exit();
    }
    
    public function save(){
        $response = array("s"=>false, "msj"=>"No se pudo guardar la informacion");
        $ActividadesBienestar = new ActividadesBienestar();
        $ActividadesBienestar->setDb();  
        $ActividadesBienestar->setNombre($this->variables->nombre);
        $ActividadesBienestar->setDescripcion($this->variables->descripcion);
        //en la tabla el campo fechaLimite esta como datetime, por lo tanto se concatena con la hora de inicio
        $ActividadesBienestar->setFechaLimite($this->variables->fechaLimite." ".$this->variables->horaInicio);
        $ActividadesBienestar->setCupo($this->variables->cupo);
        $ActividadesBienestar->setUsuarioCreacion($this->variables->usuarioCreacion);
        $ActividadesBienestar->setUsuarioModificacion($this->variables->usuarioModificacion);
        $ActividadesBienestar->setFechaCreacion($this->variables->fechaCreacion);
        $ActividadesBienestar->setFechaModificacion($this->variables->fechaModificacion);
        $ActividadesBienestar->setCodigoEstado($this->variables->codigoEstado);
        $ActividadesBienestar->setEmailResponsable($this->variables->emailResponsable);
        $ActividadesBienestar->setHoraFin($this->variables->horaFin);
        $ActividadesBienestar->setImagen($this->variables->imagen);
        $ActividadesBienestar->setUrl($this->variables->url);
    
        
        if(!empty($this->variables->id)){
            $ActividadesBienestar->setId($this->variables->id);
        }
        
        $id = $ActividadesBienestar->getId();
        
        $estado = $ActividadesBienestar->saveActividadesBienestar();
        
        if($estado){
            $response["s"] = true;
            $response["id"] = $id;
            $response["msj"] = "Guardado exitoso";
        }
        echo json_encode($response);
        exit();
    }/**/
    
    public function subirArchivo(){
//        d($_FILES);
        $target_dir=PATH_SITE."/uploads/moduloActividadesbienestar/";
        
        $target_file = $target_dir . basename($_FILES['image']["name"]);
        
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        // Check if image file is a actual image or fake image
        if(isset($_POST["submit"])) {
            $check = getimagesize($_FILES['image']["tmp_name"]);
            if($check !== false) {
                echo "File is an image - " . $check["mime"] . ".";
                $uploadOk = 1;
            }else{
                echo "File is not an image.";
                $uploadOk = 0;
            }
        }
        // Check if file already exists
        if (file_exists($target_file)) {
            echo "Sorry, file already exists.";
            $uploadOk = 0;
        }
        // Check file size
        if ($_FILES['image']["size"] > 500000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }
        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }
        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES['image']["tmp_name"], $target_file)) {
                echo "The file ". basename( $_FILES['image']["name"]). " has been uploaded.";
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
//        //termina de procesar, responder la ruta donde quedo el archivo fisico
//        echo json_econde(array("ruta"=>$target_file));
        exit();
    }
}
