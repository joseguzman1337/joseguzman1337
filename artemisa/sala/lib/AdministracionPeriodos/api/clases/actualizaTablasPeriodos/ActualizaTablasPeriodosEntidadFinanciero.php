<?php
namespace Sala\lib\AdministracionPeriodos\api\clases\actualizaTablasPeriodos;
defined('_EXEC') or die;

/**
 * Clase ActualizaTablasPeriodosEntidadFinanciero encargada de la actualizacion 
 * de las tablas de periodo cuando se hace un cambio en PeriodoFinanciero
 * 
 * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package Sala\lib\AdministracionPeriodos\api\clases\actualizaTablasPeriodos
 * @since marzo 12, 2019
 */
class ActualizaTablasPeriodosEntidadFinanciero implements \Sala\lib\AdministracionPeriodos\api\interfaces\IActualizarTablasPeriodos{ 
    
    /**
     * $entidad es una variable privada, contenedora de un objeto que implementa
     * la interface Entidad, mas precisamente la Entidad PeriodoFinanciero
     * 
     * @var \Entidad PeriodoFinanciero
     * @access private
     */
    private $entidad;
    
    /**
     * @var adodb Object
     * @access private
     */
    private $db;
    
    /**
     * Constructor de la clase ActualizaTablasPeriodosEntidadFinanciero
     * @access public
     * @param \Entidad $entidad PeriodoFinanciero
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
     * la tabla PeriodoFinanciero
     * @access public
     * @return boolena Retorna true o false del exito de la actualización
     * @author Andres Ariza <arizaandres@unbosque.edu.co>
     * @since marzo 12, 2019
    */
    public function actualizarTablaPeriodo() {
        $result = false;
        $db = \Factory::createDbo();
        
        $fechaInicioPeriodoNuevo = $this->entidad->getFechaInicio();
        $fechaVencimientoPeriodoNuevo = $this->entidad->getFechaFin();
        
        $where = " tabla = 'periodo' AND idPeriodoFinanciero = ".$db->qstr($this->entidad->getId());
        $relaciones = \Sala\entidad\RelacionTablasPeriodos::getList($where);
        
        if(!empty($relaciones)){
            foreach($relaciones as $r){
                $periodo = \Periodo::getList("PeriodoId = ".$db->qstr($r->getIdTabla()));
                
                if(!empty($periodo)){
                    $guardar = false;
                    $fechaInicioPeriodoActual = $periodo[0]->getFechainicioperiodo();
                    $fechaVencimientoPeriodoActual = $periodo[0]->getFechavencimientoperiodo();

                    if($fechaInicioPeriodoActual!=$fechaInicioPeriodoNuevo){
                        $guardar = true;
                        $periodo[0]->setFechainicioperiodo($fechaInicioPeriodoNuevo);
                    }

                    if($fechaVencimientoPeriodoActual!=$fechaVencimientoPeriodoNuevo){
                        $guardar = true;
                        $periodo[0]->setFechavencimientoperiodo($fechaVencimientoPeriodoNuevo);
                    }

                    if($guardar){
                        $periodoDao = new \Sala\entidadDAO\PeriodoDAO($periodo[0]);
                        $periodoDao->setDb();
                        $result = $periodoDao->save();
                        unset($periodoDao);
                    }
                }
                unset($periodo);
            }
        }
        return $result;        
    }

    /**
     * Esta funcion se encarga de hacer la validacion y actualizacion de los 
     * registros de la tabla subperiodo con base en la información ingresada en
     * la tabla PeriodoFinanciero
     * @access public
     * @return boolena Retorna true o false del exito de la actualización
     * @author Andres Ariza <arizaandres@unbosque.edu.co>
     * @since marzo 12, 2019
    */
    public function actualizarTablaSubperiodo() {
        $result = false;
        $db = \Factory::createDbo(); 
        
        $fechaInicioPeriodoNuevo = $this->entidad->getFechaInicio();
        $fechaVencimientoPeriodoNuevo = $this->entidad->getFechaFin();
        
        $where = " tabla = 'subperiodo' AND idPeriodoFinanciero = ".$db->qstr($this->entidad->getId());
        $relaciones = \Sala\entidad\RelacionTablasPeriodos::getList($where);
        
        if(!empty($relaciones)){
            foreach($relaciones as $r){
                $idSubPeriodo = $r->getIdTabla();
                $subperiodo = new \Sala\entidad\Subperiodo();
                $subperiodo->setDb();
                $subperiodo->setIdsubperiodo($idSubPeriodo);
                $subperiodo->getById();
                
                $guardar = false;
                $fechaInicioPeriodoActual = $subperiodo->getFechainiciofinancierosubperiodo();
                $fechaVencimientoPeriodoActual = $subperiodo->getFechafinalfinancierosubperiodo();
                

                if($fechaInicioPeriodoActual!=$fechaInicioPeriodoNuevo){
                    $guardar = true;
                    $subperiodo->setFechainiciofinancierosubperiodo($fechaInicioPeriodoNuevo);
                }

                if($fechaVencimientoPeriodoActual!=$fechaVencimientoPeriodoNuevo){
                    $guardar = true;
                    $subperiodo->setFechafinalfinancierosubperiodo($fechaVencimientoPeriodoNuevo);
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
     * en la tabla PeriodoFinanciero
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
