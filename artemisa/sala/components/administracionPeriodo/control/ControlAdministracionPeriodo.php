<?php

defined('_EXEC') or die;
require_once(PATH_SITE . "/components/administracionPeriodo/modelo/AdministracionPeriodo.php");

use Sala\lib\AdministracionPeriodos\api\clases\PeriodoFacatory;

class ControlAdministracionPeriodo {

    /**
     * @type adodb Object
     * @access private
     */
    private $db;

    /**
     * @type stdObject
     * @access private
     */
    public function __construct($variables) {
        $this->db = Factory::createDbo();
        $this->variables = $variables;

        if (empty($this->variables->dataType)) {
            $this->variables->dataType = null;
        }

        if (empty($this->variables->dataAction)) {
            $this->variables->dataAction = null;
        }
    }

    /**
     * Este metodo retorna la implementacion del metodo parametrizado en la variable variables->dataAction 
     * de los objetos de la familia IPeriodo
     * @access public
     * @return void
     * @author Diego Fernando Rivera Castro<riveradiego@unbosque.edu.co>
     * @since febrero 19, 2019
    */
    public function administrarPeriodo() {
        
        if (!empty($this->variables->dataType)) {
            $periodoApi = PeriodoFacatory::IPeriodo($this->variables->dataType);
            if (!($periodoApi instanceof \Sala\lib\AdministracionPeriodos\api\interfaces\IPeriodo)) {
                throw new Exception('El objeto no implementa la interface IPeriodo');
            }
            $ejecutar = $this->variables->dataAction . "Periodo";

            $periodoApi->setVariables($this->variables);

            echo $retorno = $periodoApi->$ejecutar();
        }
    }
    
    /**
     * Este metodo retorna la implementacion del metodo parametrizado en la variable variables->dataAction 
     * de los objetos de la familia ICombosPeriodo
     * @access public 
     * @return string 
     * @author Andres Ariza <arizaandres@unbosque.edu.co>
     * @since febrero 19, 2019
    */
    public function getCombo(){
        $response = false;
        $msj = "No se especificó el tipo de dato";
        $retorno = json_encode(array("s"=>$response, "m"=>$msj));
        if (!empty($this->variables->dataType)) {
            $comboPeriodoApi = PeriodoFacatory::ICombosPeriodo($this->variables->dataType);
            if (!($comboPeriodoApi instanceof \Sala\lib\AdministracionPeriodos\api\interfaces\ICombosPeriodo)) {
                echo $retorno;
                throw new Exception('El objeto no implementa la interface ICombosPeriodo');
            }            
            $comboPeriodoApi->setVariables($this->variables);
            $retorno = $comboPeriodoApi->getCombo();
            echo $retorno;
        }
    }
    /**
     * metodo carga icono correspondiente al estado a editar
     * @param int $id
     * @param String $dataType
     * @param String $action
     * @access public static
     * @return icono cambio de estado
     * @author Andres Ariza <arizaandres@unbosque.edu.co>
     * @since febrero 19, 2019
    */
    public static function printInconCambioEstado($id, $dataType ,$action="editarEstado") {
        $classType = 'success'; 
        $fa = 'random';
        $title = 'Clic para cambiar de estado';

        $return = self::printIncon($id, $dataType, $action, $fa, $title, $classType);

        return $return;
    }
    
    /**
     * metodo para cargar icono editar
     * @param int $id
     * @param String $dataType
     * @param String $action
     * @access public static
     * @return icono editar
     * @author Andres Ariza <arizaandres@unbosque.edu.co>
     * @since febrero 19, 2019
    */
    public static function printInconEditar($id, $dataType ,$action="editar") {
        $classType = 'warning';
        //$action = "editar";
        $fa = 'pencil';
        $title = 'Clic para editar';

        $return = self::printIncon($id, $dataType, $action, $fa, $title, $classType);

        return $return;
    }
    
    /**
     * metodo para cargar icono eliminar
     * @param string $dataType
     * @param int $id 
     * @access public static
     * @return return Icono eliminar
     * @author Andres Ariza <arizaandres@unbosque.edu.co>
     * @since febrero 19, 2019
    */
    public static function printInconEliminar($id, $dataType) {
        $classType = 'danger';
        $action = "eliminar";
        $fa = 'trash';
        $title = 'Clic para eliminar';
        
        $return = self::printIncon($id, $dataType, $action, $fa, $title, $classType);

        return $return;
    }
    /**
     * Metodo permite crear icono a visualizar para opciones de edicion
     * @param int $id
     * @param string $dataType
     * @param string $action
     * @param string $fa
     * @param string $title
     * @param string $classType
     * @access public static
     * @return  icono 
     * @author Andres Ariza <arizaandres@unbosque.edu.co>
     * @since febrero 19, 2019
    */
    private static function printIncon($id, $dataType, $action, $fa, $title, $classType) {
        $class = $dataType . ' text-'.$classType.' ' .$action.$dataType;
        $icon = '<span class="fa-stack fa-lg">
                    <i class="fa fa-square-o fa-stack-2x"></i>
                    <i class="fa fa-'.$fa.' fa-stack-1x"></i> 
                </span> ';

        $return = '<a class="accion' . $class . '" href="#" id="'.$action.'-icon-' . $id . '" data-type="' . $dataType . '" data-id="' . $id . '" data-action="' . $action . '" data-toggle="tooltip" title="' . $title . '" >' . $icon . '</a>';

        return $return;
    }

}
