<?php
/**
 * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package model
 */
defined('_EXEC') or die;
require_once(PATH_SITE."/entidad/Carrera.php");
require_once(PATH_SITE."/entidad/Periodo.php");
require_once(PATH_SITE."/entidad/PeriodoVirtualCarrera.php");
class CambioPeriodo implements Model{
    /**
     * @type adodb Object
     * @access private
     */
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }
    
    public function getVariables($variables){
        $array = array();
        
        $codigofacultad = Factory::getSessionVar('codigofacultad'); 
        
        //d($_SESSION );
        
        $carreraSession = Factory::getSessionVar('carreraEstudiante');
        
        if( $codigofacultad != $carreraSession->getCodigocarrera()){        
            $Carrera = new Carrera();
            $Carrera->setDb();
            $Carrera->setCodigocarrera($codigofacultad);
            $Carrera->getByCodigo();
        }else{
            $Carrera = $carreraSession;
            $Carrera->setDb();
        }
        
        $modalidadAcademica = $Carrera->getCodigomodalidadacademica();
        $codigocarrera = $Carrera->getCodigocarrera();
        //d($codigocarrera);
        $array['Carrera'] = $Carrera;
        
        $listaPeriodosVirtuales = PeriodoVirtualCarrera::getList(" codigoCarrera = ".$this->db->qstr($codigocarrera));
        
        if(empty($listaPeriodosVirtuales)){
            $listaPeriodosVirtuales = PeriodoVirtualCarrera::getList(" codigoModalidadAcademica = ".$this->db->qstr($modalidadAcademica));
        }
        $array['listaPeriodosVirtuales'] = $listaPeriodosVirtuales;
        
        $query = "SELECT p.codigoperiodo "
                ." FROM periodo p "
                ." INNER JOIN estadoperiodo e ON (p.codigoestadoperiodo = e.codigoestadoperiodo) "
                ." INNER JOIN carreraperiodo cp ON (cp.codigoperiodo = p.codigoperiodo) "
                ." WHERE cp.codigocarrera = '".$codigofacultad."' "
                ." ORDER BY p.codigoperiodo DESC ";
        //d($query);
        /*$datos = $this->db->Execute($query);
        $data = $datos->GetArray();
        $listaPeriodos = array();
        
        foreach($data as $l){
            $listaPeriodos[] = $l['codigoperiodo'];
        }/**/
        $listaPeriodos = array();
        $listaPeriodos = Periodo::getList(" codigoperiodo IN (".$query.")  ORDER BY codigoperiodo DESC ");
        $array['listaPeriodos'] = $listaPeriodos; 
        
        $Periodo = Factory::getSessionVar("PeriodoSession");
        $codigoperiodosesion = Factory::getSessionVar('codigoperiodosesion');
        //d($codigoperiodosesion);
        if($Periodo->getCodigoperiodo()!=$codigoperiodosesion){
            $Periodo = new Periodo();
            $Periodo->setDb();
            $Periodo->setCodigoperiodo($codigoperiodosesion);
            $Periodo->getById();
        }
        
        $array['periodoActual'] = $Periodo;
        
        $PeriodoVirtualActual = Factory::getSessionVar('PeriodoVirtualSession');
        $array['periodoVirtualActual'] = $PeriodoVirtualActual;
        
        $array['rol'] = Factory::getSessionVar('rol');
        
        return $array;
    } 
}