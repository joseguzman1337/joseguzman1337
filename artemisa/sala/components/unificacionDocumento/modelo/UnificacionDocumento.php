<?php

/**
 * @author vega Gabriel <vegagabriel@unbosque.edu.do>
 * @copyright Universidad el Bosque - Dirección de Tecnología
 * @package modelo
 */
defined('_EXEC') or die;
require_once(PATH_SITE . "/entidad/Documento.php");
require_once(PATH_SITE . "/entidad/EstudianteGeneral.php");

class unificacionDocumento implements Model {

    /**
     * @type adodb Object
     * @access private
     */
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getVariables($variables) {
        $array = array();
        if (empty($variables->layout)) {
            $array['test'] = "Unificacion De Documento";
            $Documento = Documento::getList(" codigoestado=100 ");
            $array['Documento'] = $Documento;
        }

        return $array;
    }

}
