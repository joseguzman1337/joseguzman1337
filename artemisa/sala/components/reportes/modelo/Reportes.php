<?php

/**
 * @author Diego Rivera<riveradiego@unbosque.edu.do>
 * @copyright Universidad el Bosque - Dirección de Tecnología
 * @package modelo
 */
defined('_EXEC') or die;
require_once(PATH_SITE . "/components/reportes/entidades/enfasisPlanestudio.php");
require_once(PATH_SITE . "/entidad/Periodo.php");

class Reportes implements Model {

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

        switch ($variables->layout) {
            case "reporteEnfasisMusica":
                $estudianteEnfasis = $this->getVariablesReporte($variables);
                $array['estudianteEnfasis'] = $estudianteEnfasis;
                              
                break;
            default:
                $enfasisPlanEstudio = EnfasisPlanEstudio::getListLineas();
                $cantidadSemestre = EnfasisPlanEstudio::getSemestre();
                $periodo = Periodo::getList(" codigoestadoperiodo in (1,3,4)");

                $array['enfasisPlanEstudio'] = $enfasisPlanEstudio;
                $array['cantidadSemestre'] = $cantidadSemestre;
                $array['periodo'] = $periodo;
                break;
        }

        return $array;
    }
    
    public function getVariablesReporte($variables){
        $periodo = $variables->periodo;
        $semestre = $variables->semestre;
        $enfasis = $variables->idEnfasis;
        $estudianteEnfasis = EnfasisPlanEstudio::estudianteEnfasis("P.semestreprematricula =".$semestre." AND P.codigoperiodo = ".$periodo." AND LEE.idlineaenfasisplanestudio=".$enfasis);
        return $estudianteEnfasis;
    }

} 