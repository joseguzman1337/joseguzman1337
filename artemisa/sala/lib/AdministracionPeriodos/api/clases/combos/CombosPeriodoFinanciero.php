<?php
namespace Sala\lib\AdministracionPeriodos\api\clases\combos;
defined('_EXEC') or die;

use Sala\lib\AdministracionPeriodos\api\clases\PeriodoFacatory;

/**
 * Clase CombosPeriodoFinanciero encargado de la carga de los combos de actualizacion dinamica en
 * el formulario de edicion de los periodos Financieros
 * 
 * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package Sala\lib\AdministracionPeriodos\api\clases\combos
 */
class CombosPeriodoFinanciero implements \Sala\lib\AdministracionPeriodos\api\interfaces\ICombosPeriodo{
    
    /**
     * $variables es una variable privada, contenedora de un objeto estandar en 
     * el cual se setean todas las variables recibidas por el sistema a nivel 
     * POST, GET y REQUEST
     * 
     * @var \stdClass
     * @access private
     */
    private $variables;

    /**
     * Constructor de la clase CombosPeriodoAcademico
     * @param \stdClass $variables
     * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
     * @return void
     */ 
    public function __construct($variables = null) {
        if(!empty($variables)){
            $this->variables = $variables;
        }
    }
    
    /**
     * Este metodo inicializa el atributo variables con el objeto variables 
     * recibido mediante el REQUEST
     * @access public
     * @param \stdClass $variables Variables recibidas del REQUEST
     * @author Andres Ariza <arizaandres@unbosque.edu.co>
     * @since febrero 19, 2019
    */ 
    public function setVariables($variables) {
        $this->variables = $variables;
    }
    
    /**
     * Este metodo retorna el combo de opciones de acuerdo a las variables seleccionadadas
     * @access public
     * @return array Array con la estructura de respuesta json s => estado, msj => mensaje  y options => combo resultado
     * @author Andres Ariza <arizaandres@unbosque.edu.co>
     * @since febrero 19, 2019
    */
    public function getCombo() {
        $response = false;
        $msj = "No se especifico el combo a retornar";
        $retorno = json_encode(array("s"=>$response, "m"=>$msj));
        $ejecutar = $this->variables->dataAction;
        
        if(!empty($ejecutar)){
            $retorno = $this->$ejecutar();
        }
        return $retorno;
    }
    
    /**
     * Este metodo retorna el combo de periodos creados para el año seleccionado
     * en el formulario de edición
     * @access private
     * @return array Array con la estructura de respuesta json s => estado, msj => mensaje  y options => combo resultado
     * @author Andres Ariza <arizaandres@unbosque.edu.co>
     * @since febrero 19, 2019
    */
    private function getPeriodosDelAgno(){
        $db = \Factory::createDbo();
        $response = false;
        $msj = "No existen periodos asociados al año seleccionado";
        $options ="";
        
        $apiPeriodoFinanciero = PeriodoFacatory::IPeriodo("PeriodoFinanciero");
        $periodosFinanciero = $apiPeriodoFinanciero->getList("codigoEstado = 100");
        //d($periodosFinanciero);
        
        $idsMaestrosUsados = array();
        foreach($periodosFinanciero as $pf){
            $idsMaestrosUsados[] = $pf->periodoMaestro->id;
        }
        
        $where = " idAgno = ".$db->qstr($this->variables->idAnio);
        if(!empty($idsMaestrosUsados)){
            $where .= " AND id NOT IN (".implode(",",$idsMaestrosUsados).") ";
        }
        $where .= " ORDER BY codigo";
        $listaPeriodosMaestros = \PeriodoMaestro::getList($where);
        
        if(!empty($listaPeriodosMaestros)){
            $response = true;
            $msj = "";
            $options .= "<option value=\"\">Seleccionar</option>";
            foreach($listaPeriodosMaestros as $p){
                $options .= "<option value=\"".$p->getId()."\">".$p->getNombre()."(".$p->getCodigo().")</option>";
            }
        }
        return json_encode(array("s"=>$response, "msj" => $msj, "options" => $options));
    }

}
