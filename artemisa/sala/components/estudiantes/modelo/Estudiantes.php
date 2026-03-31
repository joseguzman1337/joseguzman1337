<?php
/**
 * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package model
 */
defined('_EXEC') or die;
class Estudiantes implements Model{
    /**
     * @type adodb Object
     * @access private
     */
    private $db;
    
    /**
     * @type Usuario Object
     * @access private
     */
    private $Usuario;
    
    public function __construct($db) {
        $this->db = $db;
    }
    
    public function getVariables($variables){
        require_once (PATH_SITE.'/entidad/Estudiante.php');
        require_once (PATH_SITE.'/entidad/Periodo.php');
        require_once (PATH_SITE.'/components/mainMenu/modelo/MainMenu.php');
        require_once (PATH_SITE."/components/moduloGraficaNotas/modelo/ModuloGraficaNotas.php");
                
        $variables->menuEstudiante = true;
        $array = array(); 
        $array["variables"] = $variables;
        $modeloRender = Factory::getRenderInstance();
        
        $codigoEstudiante = Factory::getSessionVar('codigo');
        $Estudiante = new Estudiante();
        $Estudiante->setCodigoEstudiante($codigoEstudiante);
        $Estudiante->setDb();
        $Estudiante->getById();
        //ddd($Estudiante);
        
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
        
        $modalidadAcademica = $Carrera->getCodigomodalidadacademica();
        
        /*require_once (PATH_SITE.'/components/asideContainer/modelo/AsideContainer.php');
        //d($modeloRender);
        $Modelo = new AsideContainer($this->db);
        $variablesModelo = $Modelo->getVariables($variables);
        
        $array1 = array_merge($array,$variablesModelo);
        
        $array["asideContainer"] = $modeloRender->render('default',"/components/asideContainer/",$array1, true);/**/
        
        $Modelo = new MainMenu($this->db);
        $variablesModelo = $Modelo->getVariables($variables);
        
        $array1 = array_merge($array,$variablesModelo);
        
        $array["mainMenu"] = $modeloRender->render('menuEstudiante',"/components/mainMenu/",$array1, true);
        //d($array["mainMenu"]);
        
        $variablesNotas = clone $variables;
        $variablesNotas->layout = 'defaul';
        
        $ModuloGraficaNotas = new ModuloGraficaNotas($this->db);
        $arrayNotas = array();
        //d($modalidadAcademica);
        switch($modalidadAcademica){
            case '200':
                $variablesNotas->layout = "notasMateriasPregrado";
                //d($variablesNotas->layout);
                break;
            case '300':
                $variablesNotas->layout = "notasMateriasPosgrado";
                break;
            default:
                $variablesNotas->layout = 'defaul';
                $arrayNotas["menuEstudiante"] = $array1['menuEstudiante'];
                $arrayNotas["valores"] = $array1['valores'];
                break;
        }
        
        $arrayNotas = array_merge($arrayNotas,$ModuloGraficaNotas->getVariables($variablesNotas));
        
        $moduloName = "moduloGraficaNotas";
        
               // d($variablesNotas->layout);
        $graficoNotas = $modeloRender->render($variablesNotas->layout,"/components/".$moduloName,$arrayNotas, true);
        $array["graficoNotas"] = $graficoNotas; 
        
        return $array;
    }
    
    public function getPeriodosEstudiante(){
        $query = "SELECT p.codigoperiodo "
                . "FROM periodo p "
                . "INNER JOIN carreraperiodo cp ON (p.codigoperiodo = cp.codigoperiodo) "
                . "INNER JOIN estudiante e ON (cp.codigocarrera = e.codigocarrera AND p.codigoperiodo >= e.codigoperiodo) "
                . "INNER JOIN prematricula prm ON (prm.codigoestudiante = e.codigoestudiante AND prm.codigoperiodo = p.codigoperiodo ) "
                . "WHERE e.codigoestudiante = '$codigoestudiante' "
                . " AND prm.codigoestadoprematricula = '40' "
                . "ORDER BY p.codigoperiodo DESC";
    }
}
