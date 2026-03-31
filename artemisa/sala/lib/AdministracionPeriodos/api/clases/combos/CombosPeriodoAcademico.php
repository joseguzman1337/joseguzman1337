<?php
namespace Sala\lib\AdministracionPeriodos\api\clases\combos;
defined('_EXEC') or die;

use Sala\lib\AdministracionPeriodos\api\clases\PeriodoFacatory;

/**
 * Clase CombosPeriodoAcademico encargado de la carga de los combos de actualizacion dinamica en
 * el formulario de edicion de los periodos Academicos
 * 
 * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package Sala\lib\AdministracionPeriodos\api\clases\combos
 * @since febrero 19, 2019
 */
class CombosPeriodoAcademico implements \Sala\lib\AdministracionPeriodos\api\interfaces\ICombosPeriodo{
    
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
     * Este metodo retorna el combo de opciones de periodos maestros dependiendo
     * del año seleccionado en el formulario de edicion
     * @access private
     * @return array Array con la estructura de respuesta json s => estado, msj => mensaje  y options => combo resultado
     * @author Andres Ariza <arizaandres@unbosque.edu.co>
     * @since febrero 19, 2019
    */
    private function getPeriodosMaestros(){
        $db = \Factory::createDbo();
        $response = false;
        $msj = "No existen periodos asociados al año seleccionado";
        $options ="";
        
        $idsMaestrosUsados = array();
        
        $where = " idAgno = ".$db->qstr($this->variables->idAnio)
                . " ORDER BY codigo";
        $listaPeriodosMaestros = \PeriodoMaestro::getList($where);
        
        if(!empty($listaPeriodosMaestros)){
            $response = true;
            $msj = "";
            $options .= "<option value=\"\">Seleccionar</option>";
            foreach($listaPeriodosMaestros as $p){
                $options .= "<option value=\"".$p->getId()."\">".$p->getNombre()."(".$p->getCodigo().")</option>";
            }
        }/**/
        return json_encode(array("s"=>$response, "msj" => $msj, "options" => $options));
    }
    
    /**
     * Este metodo retorna el combo de opciones de periodos financieros dependiendo
     * del año seleccionado en el formulario de edicion
     * @access private
     * @return array Array con la estructura de respuesta json s => estado, msj => mensaje  y options => combo resultado
     * @author Andres Ariza <arizaandres@unbosque.edu.co>
     * @since febrero 19, 2019
    */
    private function getPeriodosFinancieros(){
        $db = \Factory::createDbo();
        $response = false;
        $msj = "No existen periodos asociados al año seleccionado";
        $options ="";        
        $idsMaestrosUsados = array();
        
        $where = " idAgno = ".$db->qstr($this->variables->idAnio)
                . " ORDER BY codigo";
        $listaPeriodosMaestros = \PeriodoMaestro::getList($where);
        
        if(!empty($listaPeriodosMaestros)){ 
            foreach($listaPeriodosMaestros as $p){
                $idsMaestrosUsados[] = $p->getId();
            }
        }
        
        $where = "idPeriodoMaestro IN (".implode(",", $idsMaestrosUsados).") ";
        
        $listaPeriodosFinancieros = \PeriodoFinanciero::getList($where);
        
        if(!empty($listaPeriodosFinancieros)){
            $response = true;
            $msj = "";
            $options .= "<option value=\"\">Seleccionar</option>";
            foreach($listaPeriodosFinancieros as $p){
                $options .= "<option value=\"".$p->getId()."\">".$p->getNombre()."</option>";
            }
        }
        return json_encode(array("s"=>$response, "msj" => $msj, "options" => $options));
    }
    
    /**
     * Este metodo retorna el combo de programas academicos dependiendo de la
     * modalidad academica seleccionada en el formulario de edición
     * @access private
     * @return array Array con la estructura de respuesta json s => estado, msj => mensaje  y options => combo resultado
     * @author Andres Ariza <arizaandres@unbosque.edu.co>
     * @since febrero 19, 2019
    */
    private function getCarreras(){
        $db = \Factory::createDbo();
        $response = false;
        $msj = "No existen programas adadémicos asociados a la modalidad seleccionada";
        $options ="";
        $options .= "<option value=\"\">Seleccionar</option>";
        
        $carreras = new \Carrera();
        $carreras->setDb();
        $carreras->setCodigocarrera(1);
        $carreras->getByCodigo();
        $options .= "<option value=\"".$carreras->getCodigocarrera()."\">".$carreras->getNombrecortocarrera()."</option>";
        $listaCarreras = \Carrera::getList(" codigomodalidadacademica = ".$db->qstr($this->variables->codigoModalidadAcademica), "nombrecarrera ASC");
        
        if($this->variables->codigoModalidadAcademica == 1 ){
            $response = true;
            $msj = "";
        }else if(!empty($listaCarreras)){
            $response = true;
            $msj = "";
            foreach($listaCarreras as $c){
                $options .= "<option value=\"".$c->getCodigocarrera()."\">".$c->getNombrecarrera()."</option>";
            }
            unset($listaCarreras);
        }
        return json_encode(array("s"=>$response, "msj" => $msj, "options" => $options));
    }

}
