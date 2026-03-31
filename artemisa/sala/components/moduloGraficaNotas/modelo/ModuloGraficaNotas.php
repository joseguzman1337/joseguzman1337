<?php
/**
 * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package model
 */
defined('_EXEC') or die;
require_once(PATH_SITE."/entidad/ViewHistoricoNotasEstudiante.php");
class ModuloGraficaNotas implements Model{
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
        $array["variables"] = $variables;
        //d($variables);
        switch($variables->layout){
            case "historico":
                $idPerfil = Factory::getSessionVar('idPerfil');
                $variables->option = "test";
                if($idPerfil == 1){
                    $array["historicoNotas"] = $this->getHistoricoNotas();
                }
                break;
            case "notasMateriasPregrado":
            case "notasMateriasPosgrado":
                require_once(PATH_SITE."/entidad/Periodo.php");
                $idPerfil = Factory::getSessionVar('idPerfil');
                //ddd($variables);
                if($idPerfil == 1){
                    $codigoEstudiante = Factory::getSessionVar('codigo');
                    $idEstudianteGeneral = Factory::getSessionVar('codigo');
                    $codigoPeriodo = Factory::getSessionVar('codigoperiodosesion');
                    $idCarreraSession = Factory::getSessionVar('idCarrera');
                    
                    $carreraSession = Factory::getSessionVar("carreraEstudiante");

                    if(!empty($carreraSession) && ($idCarreraSession == $carreraSession->getCodigocarrera())){
                        $Carrera = $carreraSession;
                    }else{
                        $Carrera = new Carrera();
                        $Carrera->setDb();
                        $Carrera->setCodigocarrera($idCarreraSession);
                        $Carrera->getById();
                    }
                    
                    $array["codigoModalidadAcademica"] = $Carrera->getCodigomodalidadacademica();
                    
                    $periodos = Servicios::getPeriodosEstudiante($codigoEstudiante, $idEstudianteGeneral);
                    
                    $materias = Servicios::getMateriasMatriculadas($codigoEstudiante, $codigoPeriodo);
                    if(empty($materias)){
                        $codigoPeriodo = $periodos[0]->getCodigoperiodo();
                    }
                    
                    $array["notasMaterias"] = $this->getNotasMateria($variables, $codigoPeriodo);
                    $array["PeriodoActual"] = new Periodo();
                    $array["PeriodoActual"]->setDb();
                    $array["PeriodoActual"]->setCodigoperiodo($codigoPeriodo);
                    $array["PeriodoActual"]->getById();
                    $array["codigoPeriodo"] = $codigoPeriodo;
                    if(!empty($variables->codigoPeriodo)){
                        $array["codigoPeriodo"] = $variables->codigoPeriodo;
                    }
                    $array["colors"] = array( '#F78181', '#F7BE81', '#D8F781', '#81F781', '#81F7D8', '#8181F7', '#A9A9F5', '#DA81F5', '#F7819F', '#D8D8D8', '#00FFFF');
                    $array["periodos"] = $periodos;
                }
                //d($array["notasMaterias"]);
                break;
        }
        return $array;
    }
    
    private function getHistoricoNotas(){
        $where  = " idestudiantegeneral = ".$this->db->qstr(Factory::getSessionVar('sesion_idestudiantegeneral'))." "
                . " AND codigoestudiante = ".$this->db->qstr(Factory::getSessionVar('codigo'));
        $datos = ViewHistoricoNotasEstudiante::getList($where);
        
        $periodo = 'p_0';
        $arrayNotas = array();
        if(!empty($datos)){
            foreach($datos as $d){
                //d($d);
                if($periodo != 'p_'.$d->getCodigoperiodo()){
                    $periodo = 'p_'.$d->getCodigoperiodo();
                    $arrayNotas[$periodo]["notas"] = 0;
                    $arrayNotas[$periodo]["creditos"] = 0;
                }
                $arrayNotas[$periodo]["notas"] += $d->getNotadefinitiva()*$d->getNumerocreditos();
                $arrayNotas[$periodo]["creditos"] += $d->getNumerocreditos();
            }
        }
        return $arrayNotas;
    }
    
    private function getNotasMateria($variables, $periodoSession){
        
        $codigoEstudiante = Factory::getSessionVar('codigo');
        //$periodoSession = Factory::getSessionVar('codigoperiodosesion');
        $carreraSession = Factory::getSessionVar('idCarrera');
        if(!empty($variables->codigoPeriodo)){
            $periodoSession = $variables->codigoPeriodo;
        }
        //d($periodoSession);
        //$periodoSession = 20171;
        //d($codigoEstudiante);
        
        $listadoNotasMaterias = array();
        
        $listadoNotasMaterias = Servicios::getListadoNotasMateria($codigoEstudiante, $periodoSession, $carreraSession);
        
        
        
        return $listadoNotasMaterias;
    }
}