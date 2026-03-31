<?php
namespace Sala\lib\AdministracionPeriodos\api\clases\actualizaTablasPeriodos;
defined('_EXEC') or die;

/**
 * Clase ActualizaTablasPeriodosEntidadMaestro encargada de la actualizacion 
 * de las tablas de periodo cuando se hace un cambio en PeriodoMaestro
 * 
 * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package Sala\lib\AdministracionPeriodos\api\clases\actualizaTablasPeriodos
 * @since marzo 12, 2019
 */
class ActualizaTablasPeriodosEntidadMaestro implements \Sala\lib\AdministracionPeriodos\api\interfaces\IActualizarTablasPeriodos{
    
    /**
     * $entidad es una variable privada, contenedora de un objeto que implementa
     * la interface Entidad, mas precisamente la Entidad PeriodoMaestro
     * 
     * @var \Entidad PeriodoMaestro
     * @access private
     */
    private $entidad;
    
    /**
     * @var adodb Object
     * @access private
     */
    private $db;
    
    /**
     * Constructor de la clase ActualizaTablasPeriodosEntidadMaestro
     * @access public
     * @param \Entidad $entidad PeriodoMaestro
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
     * la tabla PeriodoMaestro
     * @access public
     * @return boolena Retorna true o false del exito de la actualización
     * @author Andres Ariza <arizaandres@unbosque.edu.co>
     * @since marzo 12, 2019
    */
    public function actualizarTablaPeriodo() {
        $result = false;
        $db = \Factory::createDbo();
        $periodo = \Periodo::getList("codigoperiodo = ".$db->qstr($this->entidad->getCodigo()));
        
        if(!empty($periodo)){
            $nombreActual = $periodo[0]->getNombreperiodo();
            $nombreNuevo = $this->entidad->getNombre();
            
            if($nombreActual != $nombreNuevo){
                $periodo[0]->setNombreperiodo($nombreNuevo);
                $periodoDao = new \Sala\entidadDAO\PeriodoDAO($periodo[0]);
                $periodoDao->setDb();
                $result = $periodoDao->save();
            }
        }
        return $result;
        
    }

    /**
     * Esta funcion se encarga de hacer la validacion y actualizacion de los 
     * registros de la tabla subperiodo con base en la información ingresada en
     * la tabla PeriodoMaestro
     * @access public
     * @return boolena Retorna true o false del exito de la actualización
     * @author Andres Ariza <arizaandres@unbosque.edu.co>
     * @since marzo 12, 2019
    */
    public function actualizarTablaSubperiodo() {
        $result = false;
        $db = \Factory::createDbo();
        $nuevoNombre = $this->entidad->getNombre();
        $where = " tabla = 'subperiodo' AND (idPeriodoMaestro1 = ".$db->qstr($this->entidad->getId())." OR idPeriodoMaestro2 = ".$db->qstr($this->entidad->getId()).")";
        
        $relaciones = \Sala\entidad\RelacionTablasPeriodos::getList($where);
        if(!empty($relaciones)){
            foreach($relaciones as $r){
                $idSubPeriodo = $r->getIdTabla();
                $subperiodo = new \Sala\entidad\Subperiodo();
                $subperiodo->setDb();
                $subperiodo->setIdsubperiodo($idSubPeriodo);
                $subperiodo->getById();
                
                $nombreActual = $subperiodo->getNombresubperiodo();
                if($nuevoNombre !== $nombreActual){
                    $subperiodo->setNombresubperiodo($nuevoNombre); 
                    $subPeriodoDAO = new \Sala\entidadDAO\SubperiodoDAO($subperiodo);
                    $subPeriodoDAO->setDb();
                    $result = $subPeriodoDAO->save();
                    unset($subPeriodoDAO);
                }
                unset($subperiodo);
            }
        }
        return $result;
    }

    /**
     * Esta funcion se encarga de hacer la validacion y actualizacion de los 
     * registros de la tabla carreraperiodo con base en la información ingresada
     * en la tabla PeriodoMaestro
     * @access public
     * @return boolena Retorna true o false del exito de la actualización
     * @author Andres Ariza <arizaandres@unbosque.edu.co>
     * @since marzo 12, 2019
    */
    public function actualizarTablaCarreraPeriodo() {
        return false;
    }
}
