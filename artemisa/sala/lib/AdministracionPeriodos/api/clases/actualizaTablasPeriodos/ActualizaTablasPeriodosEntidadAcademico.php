<?php
namespace Sala\lib\AdministracionPeriodos\api\clases\actualizaTablasPeriodos;
defined('_EXEC') or die;

/**
 * Clase ActualizaTablasPeriodosEntidadAcademico encargada de la actualizacion 
 * de las tablas de periodo cuando se hace un cambio en PeriodoAcademico
 * 
 * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package Sala\lib\AdministracionPeriodos\api\clases\actualizaTablasPeriodos
 * @since marzo 12, 2019
 */
class ActualizaTablasPeriodosEntidadAcademico implements \Sala\lib\AdministracionPeriodos\api\interfaces\IActualizarTablasPeriodos{
    
    /**
     * $entidad es una variable privada, contenedora de un objeto que implementa
     * la interface Entidad, mas precisamente la Entidad PeriodoAcademico
     * 
     * @var \Entidad PeriodoAcademico
     * @access private
     */
    private $entidad;
    
    /**
     * @var adodb Object
     * @access private
     */
    private $db;
    
    /**
     * Constructor de la clase ActualizaTablasPeriodosEntidadAcademico
     * @access public
     * @param \Entidad $entidad PeriodoAcademico
     * @return void
     * @author Andres Ariza <arizaandres@unbosque.edu.co>
     * @since marzo 12, 2019
    */
    public function __construct($entidad) {
        $this->entidad = $entidad;
        $this->db = \Factory::createDbo();
    }

    /**
     * Esta funcion se encarga de hacer la validacion y actualizacion de los 
     * registros de la tabla periodo con base en la información ingresada en
     * la tabla PeriodoAcademico
     * @access public
     * @return boolena Retorna true o false del exito de la actualización
     * @author Andres Ariza <arizaandres@unbosque.edu.co>
     * @since marzo 12, 2019
    */
    public function actualizarTablaPeriodo() {
        $result = false;
        return $result;
    }

    /**
     * Esta funcion se encarga de hacer la validacion y actualizacion de los 
     * registros de la tabla subperiodo con base en la información ingresada en
     * la tabla PeriodoAcademico
     * @access public
     * @return boolena Retorna true o false del exito de la actualización
     * @author Andres Ariza <arizaandres@unbosque.edu.co>
     * @since marzo 12, 2019
    */
    public function actualizarTablaSubperiodo() {
        $result = false;
        $db = \Factory::createDbo();
        
        $fechaAcademicoInicioPeriodoNuevo = $this->entidad->getFechaInicio();
        $fechaAcademicoVencimientoPeriodoNuevo = $this->entidad->getFechaFin();
        
        $where = " tabla = 'subperiodo' AND idPeriodoAcademico = ".$db->qstr($this->entidad->getId());
        $relaciones = \Sala\entidad\RelacionTablasPeriodos::getList($where);
        
        if(!empty($relaciones)){
            foreach($relaciones as $r){
                $idSubPeriodo = $r->getIdTabla();
                $subperiodo = new \Sala\entidad\Subperiodo();
                $subperiodo->setDb();
                $subperiodo->setIdsubperiodo($idSubPeriodo);
                $subperiodo->getById();
                
                $guardar = false;
                $fechaAcademicoInicioPeriodoActual = $subperiodo->getFechainicioacademicosubperiodo();
                $fechaAcademicoVencimientoPeriodoActual = $subperiodo->getFechafinalacademicosubperiodo();
                
                if($fechaAcademicoInicioPeriodoActual!=$fechaAcademicoInicioPeriodoNuevo){
                    $guardar = true;
                    $subperiodo->setFechainicioacademicosubperiodo($fechaAcademicoInicioPeriodoNuevo);
                }

                if($fechaAcademicoVencimientoPeriodoActual!=$fechaAcademicoVencimientoPeriodoNuevo){
                    $guardar = true;
                    $subperiodo->setFechafinalacademicosubperiodo($fechaAcademicoVencimientoPeriodoNuevo);
                }
                
                if($r->getIdPeriodoFinanciero()!=$this->entidad->getIdPeriodoFinanciero()){
                    $r->setIdPeriodoFinanciero($this->entidad->getIdPeriodoFinanciero());
                    $relacionTablasPeriodosDAO = new \Sala\entidadDAO\RelacionTablasPeriodosDAO($r);
                    $relacionTablasPeriodosDAO->setDb();
                    $relacionTablasPeriodosDAO->save();
                    
                    $ePeriodoFinanciero = new \PeriodoFinanciero();
                    $ePeriodoFinanciero->setDb();
                    $ePeriodoFinanciero->setId($this->entidad->getIdPeriodoFinanciero());
                    $ePeriodoFinanciero->getById();
                    
                    $guardar = true;
                    $subperiodo->setFechainiciofinancierosubperiodo($ePeriodoFinanciero->getFechaInicio());
                    $subperiodo->setFechafinalfinancierosubperiodo($ePeriodoFinanciero->getFechaFin());
                }

                if($guardar){
                    $subPeriodoDao = new \Sala\entidadDAO\SubperiodoDAO($subperiodo);
                    $subPeriodoDao->setDb();
                    $result = $subPeriodoDao->save();
                    unset($subPeriodoDao);
                }
                unset($subperiodo);
                
            }
        }
        return $result;        
    }

    /**
     * Esta funcion se encarga de hacer la validacion y actualizacion de los 
     * registros de la tabla carreraperiodo con base en la información ingresada
     * en la tabla PeriodoAcademico
     * @access public
     * @return boolena Retorna true o false del exito de la actualización
     * @author Andres Ariza <arizaandres@unbosque.edu.co>
     * @since marzo 12, 2019
    */
    public function actualizarTablaCarreraPeriodo() {
        $result = false;
        return $result;
    }

}
