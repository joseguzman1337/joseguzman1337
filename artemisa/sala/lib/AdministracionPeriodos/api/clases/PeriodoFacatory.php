<?php
namespace Sala\lib\AdministracionPeriodos\api\clases;
defined('_EXEC') or die;
/**
 * La clase (PeriodoFacatory) creadora declara los factory method que retornan 
 * los objetos de las familias ralacionadas deacuerdo al facory elegido
 * 
 * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package Sala\lib\AdministracionPeriodos\api\interfaces
 */
abstract class PeriodoFacatory {
    
    /**
     * El metodo IPeriodo es el factory para los objetos de la familia IPeriodo
     * retorna el tipo de objeto dependiendo del tipo de periodo pasado como 
     * parametro 
     * @param string $tipoPeriodo puede ser PeriodoMaestro, PeriodoFinanciero ó PeriodoAcademico
     * @access public static
     * @return Sala\lib\AdministracionPeriodos\api\interfaces\IPeriodo objeto de la familia IPeriodo
     * @author Andres Ariza <arizaandres@unbosque.edu.co>
     * @since febrero 19, 2019
    */
    public static function IPeriodo($tipoPeriodo){
        $objetoPeriodo = null;
        switch ($tipoPeriodo){
            case "PeriodoMaestro":
                $objetoPeriodo =  new \Sala\lib\AdministracionPeriodos\api\clases\PeriodoMaestro();
                break;
            case "PeriodoFinanciero":
                $objetoPeriodo =  new \Sala\lib\AdministracionPeriodos\api\clases\PeriodoFinanciero();
                break;
            case "PeriodoAcademico":
                $objetoPeriodo =  new \Sala\lib\AdministracionPeriodos\api\clases\PeriodoAcademico();
                break;
        }
        return $objetoPeriodo;
    }
    
    /**
     * El metodo ICombosPeriodo es el factory para los objetos de la familia ICombosPeriodo
     * retorna el tipo de objeto dependiendo del tipo de periodo pasado como 
     * parametro 
     * @param string $tipoPeriodo puede serPeriodoFinanciero ó PeriodoAcademico
     * @access public static
     * @return Sala\lib\AdministracionPeriodos\api\interfaces\ICombosPeriodo objeto de la familia ICombosPeriodo
     * @author Andres Ariza <arizaandres@unbosque.edu.co>
     * @since febrero 19, 2019
    */
    public static function ICombosPeriodo($tipoPeriodo){
        $objetoCombosPeriodo = null;
        switch ($tipoPeriodo){
            case "PeriodoFinanciero":
                $objetoCombosPeriodo = new \Sala\lib\AdministracionPeriodos\api\clases\combos\CombosPeriodoFinanciero();
                break;
            case "PeriodoAcademico":
                $objetoCombosPeriodo = new \Sala\lib\AdministracionPeriodos\api\clases\combos\CombosPeriodoAcademico();
                break;
        }
        return $objetoCombosPeriodo;
    }
    
    /**
     * El metodo ICambioEstadoPeriodoAcademico es el factory para los objetos de la familia ICambioEstadoPeriodoAcademico
     * retorna el tipo de objeto dependiendo del codigoModalidadAcademica de periodo pasado como 
     * parametro en el objeto $variables
     * @param \stdClass $variables este objeto debe contener el atributo codigoModalidadAcademica para la creacion de la familia
     * @access public static
     * @return Sala\lib\AdministracionPeriodos\api\interfaces\ICambioEstadoPeriodoAcademico objeto de la familia ICambioEstadoPeriodoAcademico
     * @author Andres Ariza <arizaandres@unbosque.edu.co>
     * @since febrero 19, 2019
    */
    public static function ICambioEstadoPeriodoAcademico($variables){
        $objetoCambioEstado = null;
        switch ($variables->codigoModalidadAcademica){
            case "800":
            case "810":
                $objetoCambioEstado = new \Sala\lib\AdministracionPeriodos\api\clases\condicionesPeriodoAcademico\CambioEstadoVirtual($variables);
                break;
            default :
                $objetoCambioEstado = new \Sala\lib\AdministracionPeriodos\api\clases\condicionesPeriodoAcademico\CambioEstadoPresencial($variables);
                break;
        }
        return $objetoCambioEstado;
    }
    
    /**
     * El metodo IActualizarTablasPeriodos es el factory para los objetos de la familia IActualizarTablasPeriodos
     * retorna el tipo de objeto dependiendo de la clase de la entidad en el objeto $entidad
     * @param \Entidad $entidad este objeto debe contener la endidad que se esta editando (PeriodoMaestro, PeriodoFinanciero, PeriodoAcademico)
     * @access public static
     * @return Sala\lib\AdministracionPeriodos\api\interfaces\IActualizarTablasPeriodos  $objetoActualizarTablasPeriodos objeto de la familia IActualizarTablasPeriodos
     * @author Andres Ariza <arizaandres@unbosque.edu.co>
     * @since marzo 7, 2019
    */
    public static function IActualizarTablasPeriodos($entidad){
        $objetoActualizarTablasPeriodos = null;
        $clase = get_class($entidad);
        
        switch ($clase){
            case "PeriodoMaestro":
                $objetoActualizarTablasPeriodos = new actualizaTablasPeriodos\ActualizaTablasPeriodosEntidadMaestro($entidad);
                break;
            case "PeriodoFinanciero":
                $objetoActualizarTablasPeriodos = new actualizaTablasPeriodos\ActualizaTablasPeriodosEntidadFinanciero($entidad);
                break;
            case "PeriodoAcademico":
                $objetoActualizarTablasPeriodos = new actualizaTablasPeriodos\ActualizaTablasPeriodosEntidadAcademico($entidad);
                break;
        }
        
        return $objetoActualizarTablasPeriodos;
    }
}
