<?php
/**
 * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package control
 */

class ControlEjecucionTareas{
    /**
     * @type adodb Object
     * @access private
     */
    private $db;
    
    /**
     * @type stdObject
     * @access private
     */
    private $variables;
    
    function ControlEjecucionTareas($db,$variables) {        
        $this->db = $db;
        $this->variables = $variables;
    }
    
    public function execute($action){
        if(!empty($action)){
            $this->$action();
        }
    }
    
    public function go($option, $task){
        if(!empty($option)){
            $return = false;
            if(!empty($this->variables->json)){
                $return = true;
            }
            require_once (PATH_ROOT.'/serviciosacademicos/PIR/control/ControlRender.php');
            
            $modeloclass = ucfirst($option);
            require_once (PATH_ROOT.'/serviciosacademicos/PIR/modelo/'.$modeloclass.'.php');
            
            $Modelo = new $modeloclass($this->db);
        
            $array = array();
            $array['task'] = $task;
            $array['variables'] = $this->variables;
            
            $variablesModelo = $Modelo->getVariables($this->variables);
            //d($variablesModelo);
            $array = array_merge($array,$variablesModelo); 
            
            //d($array);
            $controlRender = new ControlRender();
            $template = $controlRender->render($option,$array, $return);
            if(!empty($this->variables->json)){
               echo json_encode(array('s'=>true,'msj'=>$template)); 
            }
        }
    }
    
    private function consultarPIR(){
        
        $respuesta = new stdClass();
        require_once (PATH_ROOT.'/serviciosacademicos/PIR/control/ControlConsultarPIR.php');
        $ControlConsultarPIR = new ControlConsultarPIR($this->variables->tipoDocumento, $this->variables->numeroDocumento, $this->variables->registro, $this->variables->idEstudianteGeneral);
        //d($this->variables);
        $at = $ControlConsultarPIR->getAccessToken();
        //d($at);
        if(!empty($at->status) || is_string($at) ){
            $respuesta->s = false;
            $respuesta->msj = "No es posible establecer conexion con la base de datos de las pruebas Saber 11, por favor intente de nuevo o ingrese los resultados manualmente";
        }else{
            $ControlConsultarPIR->consultarResultadosPIR();
            $respuestaPIR = $ControlConsultarPIR->getResultadosPIR();
            //ddd($ControlConsultarPIR);
            if(!empty($respuestaPIR->status)){
                $respuesta->s = false;
                $respuesta->msj = "Puede que los datos que esta enviando no concuerden en la base de datos de las pruebas Saber 11, por favor valide que el tipo de documento, numero de documento y número de registro esten correctos e intentelo de nuevo";
            }else{
                $respuesta = $ControlConsultarPIR->actualizarResultadosSALA($this->db);
                //ddd($respuesta);
                if($respuesta->s){
                    $ControlConsultarPIR->storeDocumentoAc($this->db);
                }
                
            }
        }
        if(!$respuesta->s){
            require_once (PATH_ROOT.'/serviciosacademicos/PIR/entidad/LogActualizacionMasivaPIR.php');
            $LogActualizacionMasivaPIR = new LogActualizacionMasivaPIR($this->db);
            $fechaEjecucion = date("Y-m-d H:i:s");
            
            $LogActualizacionMasivaPIR->setTipoDocumento($this->variables->tipoDocumento);
            $LogActualizacionMasivaPIR->setNumerodocumento($this->variables->numeroDocumento);
            $LogActualizacionMasivaPIR->setNumeroregistroresultadopruebaestado($this->variables->registro);
            $LogActualizacionMasivaPIR->setIdEstudianteGeneral($this->variables->idEstudianteGeneral);
            $LogActualizacionMasivaPIR->setMensajeLog($respuesta->msj);
            $LogActualizacionMasivaPIR->setFechadelproceso($fechaEjecucion);
            $LogActualizacionMasivaPIR->storeLog();
        }
        echo json_encode($respuesta);
    }
    
    private function consultarEstructuraPIR(){
        require_once (PATH_ROOT.'/serviciosacademicos/PIR/control/ControlConsultarPIR.php');
        //ddd($this->variables);
        $periodo = ControlConsultarPIR::abstraerPeriodo($this->variables->registro);
        //d($periodo);
        $estructura = ControlConsultarPIR::getEstructuraExamen($this->db, $periodo);
        $respuesta = new stdClass();
        if(!empty($estructura)){
            $respuesta->s = true;
            $respuesta->estructura = $estructura;
            $respuesta->msj = "Este periodo tiene relacionada la estructura ".$estructura." en la base respuestas del PIR";
        }else{
            $respuesta->s = false;
        }
        echo json_encode($respuesta);
    }
    
    private function validarIdestudiantegeneralAC(){
        require_once (PATH_ROOT.'/serviciosacademicos/PIR/entidad/DocumentoPresentacionPruebaEstado.php');
        require_once (PATH_ROOT.'/serviciosacademicos/PIR/entidad/ResultadoPruebaEstado.php');
        
        $ResultadoPruebaEstado = new ResultadoPruebaEstado($this->db);
        $ResultadoPruebaEstado->setIdestudiantegeneral($this->variables->idestudiante);
        $ResultadoPruebaEstado->setNumeroregistroresultadopruebaestado($this->variables->registro);
        $ResultadoPruebaEstado->getResultadoEsutiante();
        //d($ResultadoPruebaEstado);
        $DocumentoPresentacionPruebaEstado = new DocumentoPresentacionPruebaEstado($this->db, $this->variables->idestudiante, $this->variables->tipoDocumento, $this->variables->numeroDocumento);
        $idEstudianteBD = $DocumentoPresentacionPruebaEstado->consultarIdEsutianteGeneral();
        
        $respuesta = new stdClass();
        $respuesta->s = false;
        $respuesta->msj = "El documento ".$this->variables->tipoDocumento." numero ".$this->variables->numeroDocumento." esta asignado a otro estudiante y no puede ser utilizado";
        //d($idEstudianteBD);
        //d($this->variables);
        if(empty($idEstudianteBD) || ($idEstudianteBD==$this->variables->idestudiante)){
            $respuesta->s = true;
            $respuesta->msj = "El documento puede ser utilizado";
        } 
        echo json_encode($respuesta);
    }
    
    private function actualizacionMasiva(){
        require_once (PATH_ROOT.'/serviciosacademicos/PIR/control/ControlConsultarPIR.php');
        $status = ControlConsultarPIR::ejecutarActualizacionMasiva($this->db); 
    }
    
    private function publicarDespublicarActualizacionMasiva(){
        $respuesta = new stdClass();
        $respuesta->s = false;
        
        require_once (PATH_ROOT.'/serviciosacademicos/PIR/entidad/ActualizacionMasivaPIR.php');
        $ActualizacionMasivaPIR = new ActualizacionMasivaPIR($this->db);
        $ActualizacionMasivaPIR->getActualizacionMasivaPIRById($this->variables->id);
        
        $id = $ActualizacionMasivaPIR->getId();
        if(empty($id)){
            $respuesta->s = false;
            $respuesta->msj = "Error en la busqueda, no existe una Actualización masiva programada";
        }else{
            //d($ActualizacionMasivaPIR->getEstado());
            $ActualizacionMasivaPIR->setEstado( ($ActualizacionMasivaPIR->getEstado()==100)?200:100);
            //d($ActualizacionMasivaPIR->getEstado());
            $ActualizacionMasivaPIR->save();
            $respuesta->s = true;
            $respuesta->msj = "Registro actualizado";
        }
        echo json_encode($respuesta);
    }
    
    private function crearEditarActualizacionMasiva(){
        $respuesta = new stdClass();
        $respuesta->s = false;
        //d($this->variables);
        require_once (PATH_ROOT.'/serviciosacademicos/PIR/entidad/ActualizacionMasivaPIR.php');
        $ActualizacionMasivaPIR = new ActualizacionMasivaPIR($this->db);
        
        if(!empty($this->variables->id)){
            $ActualizacionMasivaPIR->getActualizacionMasivaPIRById($this->variables->id);
        }
        //d($ActualizacionMasivaPIR);
        $ActualizacionMasivaPIR->setCodigoPeriodo($this->variables->codigoPeriodo);
        $ActualizacionMasivaPIR->setFechaInicio($this->variables->fechaInicio);
        $ActualizacionMasivaPIR->setFechaFin($this->variables->fechaFin);
        $ActualizacionMasivaPIR->setEstado($this->variables->estado);
        //d($ActualizacionMasivaPIR);
        
        $ActualizacionMasivaPIR->save();
        $respuesta->s = true;
        $respuesta->msj = "Registro guardado"; 
        echo json_encode($respuesta);/**/
    }
}