<?php
/**
 * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package control
 */
defined('_EXEC') or die;
class ControlEventosTelevisorDinamico{ 
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
    
    public function ConsultaEvento(){
        $Fecha  = date('Y-m-d');
        
        $query = 'SELECT
                        UbicacionImagen,
                        UbicacionImagen2
                FROM
                        NoticiaEvento
                WHERE
                        CodigoEstado=100
                        and
                        FileSize <> ""
                        AND
                        FileSize2 <> ""
                        AND
                        CURDATE() BETWEEN FechaInicioVigencia AND FechaFinalVigencia';
        
        $datos = $this->db->Execute($query);
        
        $data = $datos->GetArray();
        if(!empty($data)){
            echo json_encode(array("s" => true, "images" => $data));
        }else{
            echo json_encode(array("s" => false));
        }
    }//public function ConsultaEvento
    
}