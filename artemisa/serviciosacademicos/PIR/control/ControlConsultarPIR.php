<?php

require_once (PATH_ROOT.'/assets/lib/CurlRestFul.php');
require_once (PATH_ROOT.'/serviciosacademicos/PIR/config/Configuration.php');

use \PIR\config\Configuration;
class ControlConsultarPIR{
    
    /**
     * @type String
     * @access private
     */
    private $idEstudianteGeneral;
    
    /**
     * @type String
     * @access private
     */
    private $tipoDocumento;
    
    /**
     * @type String
     * @access private
     */
    private $numeroDocumento;
    
    /**
     * @type String
     * @access private
     */
    private $ac;
    
    /**
     * @type String
     * @access private
     */
    private $periodo;
    
    /**
     * @type String
     * @access private
     */
    private $accessToken;
    
    /**
     * @type String
     * @access private
     */
    private $respuesta;
    
    function ControlConsultarPIR($tipoDocumento=null, $numeroDocumento=null, $ac=null, $idEstudianteGeneral=null) {
        $this->tipoDocumento = $tipoDocumento;
        $this->numeroDocumento = str_replace(" ", "", $numeroDocumento);
        $this->ac = str_replace(" ", "", $ac);
        $this->idEstudianteGeneral = $idEstudianteGeneral;
        $this->periodo = ControlConsultarPIR::abstraerPeriodo($this->ac);
        $this->getAuthorizationToken();
    }
    
    function getPeriodo() {
        return $this->periodo;
    }

        
    static function abstraerPeriodo($ac){
        return substr($ac, 2, 5);
    }
    
    static function getEstructuraExamen($db,$periodo){
        require_once (PATH_ROOT.'/serviciosacademicos/PIR/entidad/TipoPruebaEstado.php');
        $TipoPruebaEstado = new TipoPruebaEstado($db);
        $TipoPruebaEstado->setCodigoPeriodoMIN($periodo);
        $TipoPruebaEstado->consultarEstructuraPorPeriodo();
        return $TipoPruebaEstado->getNombreEstructura();
    }
    
    public function storeDocumentoAc($db){
        require_once (PATH_ROOT.'/serviciosacademicos/PIR/entidad/DocumentoPresentacionPruebaEstado.php');
        require_once (PATH_ROOT.'/serviciosacademicos/PIR/entidad/ResultadoPruebaEstado.php');
        
        $ResultadoPruebaEstado = new ResultadoPruebaEstado($db);
        $ResultadoPruebaEstado->setIdestudiantegeneral($this->idEstudianteGeneral);
        $ResultadoPruebaEstado->setNumeroregistroresultadopruebaestado($this->ac);
        $ResultadoPruebaEstado->getResultadoEsutiante();
        
        $DocumentoPresentacionPruebaEstado = new DocumentoPresentacionPruebaEstado($db, $this->idEstudianteGeneral, $this->tipoDocumento, $this->numeroDocumento);
        $DocumentoPresentacionPruebaEstado->validarDocumentoEstudiante();
        $DocumentoPresentacionPruebaEstado->setRelacion($ResultadoPruebaEstado->getIdresultadopruebaestado());
    }
    
    public function getAuthorizationToken(){
        if(!Configuration::$active){
            $this->accessToken =  "Servicio apagado";
        }else{
            $getData = '?tipoROL=TORG';
            $url = Configuration::$baseCurl . Configuration::$pathAutentication;// .$getData;

            $headers = array(
                'correoElectronico'=> Configuration::$userCurl,
                'password'=> Configuration::$passwdCurl
            );
            $AccesCurlRestFul = new CurlRestFul( $url, '', "application/json", "application/json", $headers  );
            $AccesCurlRestFul->setInit();
            $this->accessToken = $AccesCurlRestFul->getResult();
        }
    }
    
    public function consultarResultadosPIR(){
        $getData = '?recalificacion=false&tipoDocumento='.$this->tipoDocumento.'&numeroDocumento='.$this->numeroDocumento;
    
        $url = Configuration::$baseCurl . Configuration::$pathConsult . $this->ac;
        $headers = array(
            'Authorization'=>'Bearer '.$this->accessToken->accessToken 
        );
        
        $ResultadosPIRCurlRestFul = new CurlRestFul($url, $getData, "application/json", "application/json", $headers );
        $ResultadosPIRCurlRestFul->setInit();
        
        $this->respuesta = $ResultadosPIRCurlRestFul->getResult();
    }
        
    public function getResultadosPIR(){
        return $this->respuesta;
    }
    
    public function getAccessToken(){
        return $this->accessToken;
    }
    
    
    public function actualizarResultadosSALA($db){ 
        $respuesta = new stdClass();
        $respuesta->s = false;
        require_once (PATH_ROOT.'/serviciosacademicos/PIR/entidad/ResultadoPruebaEstado.php');
        require_once (PATH_ROOT.'/serviciosacademicos/PIR/entidad/DetalleResultadoPruebaEstado.php');
        require_once (PATH_ROOT.'/serviciosacademicos/PIR/control/ControlActualizarMaterias.php');
        
        $ResultadoPruebaEstado = new ResultadoPruebaEstado($db);
        $ResultadoPruebaEstado->setIdestudiantegeneral($this->idEstudianteGeneral);
        $ResultadoPruebaEstado->setNumeroregistroresultadopruebaestado($this->ac);
        $ResultadoPruebaEstado->getResultadoEsutiante();
        
        $DetalleResultadoPruebaEstado = new DetalleResultadoPruebaEstado($db);
        if($ResultadoPruebaEstado->validarIdestudiantegeneralAC()){
            $idResultadoPruebaEstado = $ResultadoPruebaEstado->getIdresultadopruebaestado();
            $actualizadoPIR = $ResultadoPruebaEstado->getActualizadoPir();
            $ac = $ResultadoPruebaEstado->getNumeroregistroresultadopruebaestado();
            $examen = $this->respuesta->examen;
            $ControlActualizarMaterias = new ControlActualizarMaterias($db, $examen->resultado->pruebas);
            $ControlActualizarMaterias->getMaestroMaterias();
            $ControlActualizarMaterias->actualizaMaterias($examen->estructura);
            if(!empty($examen->novedad->publicar) && $examen->novedad->publicar){
                
                if( ($ac != $this->ac) || ($ac == $this->ac && $actualizadoPIR==0) ){
                    $idResultadoPruebaEstadoActual = $ResultadoPruebaEstado->getIdresultadopruebaestado();
                    $puntajeGlobalActual = $ResultadoPruebaEstado->getPuntajeGlobal();
                    $puestoresultadopruebaestadoActual = $ResultadoPruebaEstado->getPuestoresultadopruebaestado();
                    if(!empty($idResultadoPruebaEstado)){
                        if(!empty($puntajeGlobalActual)||!empty($puestoresultadopruebaestadoActual)){
                            $ResultadoPruebaEstado->desactivarActualAc();
                            $ResultadoPruebaEstado->desactivarAcsEstudiante();
                        }
                        $DetalleResultadoPruebaEstado->desactivarActualAc($idResultadoPruebaEstadoActual);
                    }
                    $ResultadoPruebaEstado->setResultados($this);
                    
                    $idResultadoPruebaEstadoNuevo = $ResultadoPruebaEstado->getIdresultadopruebaestado(); 
                    
                    $DetalleResultadoPruebaEstado->setResultados($this->respuesta, $idResultadoPruebaEstadoNuevo);
                }
                $respuesta->s = true;
                $respuesta->msj = "Consulta exitosa, sus datos han sido actualizados con los resultados del número de registro ".$this->ac." ";
                $respuesta->tabla = $this->printTablaResultados($ResultadoPruebaEstado, $ControlActualizarMaterias);
            }else{
                $respuesta->s = false;
                $respuesta->msj = "Publicar examen ".$examen->novedad->publicar;
            }
        }else{
            $respuesta->s = false;
            $respuesta->msj = "El número de registro ".$this->ac." esta siendo utilizado por otro estudiante";
        }
        return $respuesta;
    }
    
    public function printTablaResultados($objResultado, $objMaterias, $resultadosGuardados = false, $db = null){
        require_once (PATH_ROOT.'/serviciosacademicos/PIR/control/ControlRender.php');
        
        $array = array();
        $array['respuesta'] = $this->respuesta;
        $array['objResultado'] = $objResultado;
        $array['objMaterias'] = $objMaterias;
        $array['resultadosGuardados'] = $resultadosGuardados ;
        if(!empty($resultadosGuardados)){
            $array['periodo'] = ControlConsultarPIR::abstraerPeriodo($objResultado->getNumeroregistroresultadopruebaestado());
            $array['estructura'] = ControlConsultarPIR::getEstructuraExamen($db, $array['periodo'] );
        }
        
        $controlRender = new ControlRender();
        return $controlRender->render('imprimirTablaResultadosPIR',$array);
    }
    
    public static function ejecutarActualizacionMasiva($db = null){
        $countErrores = 0;
        $fechaEjecucion = date("Y-m-d H:i:s");
        print_r ("Iniciando en ".$fechaEjecucion." \n");
        
        require_once (PATH_ROOT.'/serviciosacademicos/PIR/entidad/Periodo.php');
        require_once (PATH_ROOT.'/serviciosacademicos/PIR/entidad/EstudiantesActualizar.php');
        require_once (PATH_ROOT.'/serviciosacademicos/PIR/entidad/LogActualizacionMasivaPIR.php');
        
        $LogActualizacionMasivaPIR = new LogActualizacionMasivaPIR($db);
        $EstudiantesActualizar = new EstudiantesActualizar($db);
        $listaPreinscritos = $EstudiantesActualizar->getListaPreinscritos();
        
        foreach($listaPreinscritos as $l){
            $respuesta = new stdClass();
            
            $ControlConsultarPIR = new ControlConsultarPIR($l->getTipodocumento(), $l->getNumerodocumento(), $l->getNumeroregistroresultadopruebaestado(), $l->getIdEstudianteGeneral());
            $at = $ControlConsultarPIR->getAccessToken();
            if(!empty($at->status)){
                $respuesta->s = false;
                $respuesta->msj = $at->message." - No es posible establecer conexion con el MEN para consultar datos del PIR";
            }else{
                $ControlConsultarPIR->consultarResultadosPIR();
                $respuestaPIR = $ControlConsultarPIR->getResultadosPIR();
                if(!empty($respuestaPIR->status)){
                    $respuesta->s = false;
                    $respuesta->msj = $respuestaPIR->message." - Puede que los datos que esta enviando no concuerden en la base de datos del MEN, por favor valide que esten correctos";
                }else{
                    $respuesta = $ControlConsultarPIR->actualizarResultadosSALA($db);
                    
                }
            }
            if(!$respuesta->s){
                $LogActualizacionMasivaPIR->setTipoDocumento($l->getTipodocumento());
                $LogActualizacionMasivaPIR->setNumerodocumento($l->getNumerodocumento());
                $LogActualizacionMasivaPIR->setNumeroregistroresultadopruebaestado($l->getNumeroregistroresultadopruebaestado());
                $LogActualizacionMasivaPIR->setIdEstudianteGeneral($l->getIdEstudianteGeneral());
                $LogActualizacionMasivaPIR->setMensajeLog($respuesta->msj);
                $LogActualizacionMasivaPIR->setFechadelproceso($fechaEjecucion);
                $LogActualizacionMasivaPIR->storeLog();
                $countErrores++;
            }
        }
        
        
        $listaInscritos = $EstudiantesActualizar->getListaInscritos();
        
        $ControlConsultarPIR = new ControlConsultarPIR($l->getTipodocumento(), $l->getNumerodocumento(), $l->getNumeroregistroresultadopruebaestado(), $l->getIdEstudianteGeneral());
        $at = $ControlConsultarPIR->getAccessToken();
        
        foreach($listaInscritos as $l){
            $respuesta = new stdClass();
            
            if(!empty($at->status)){
                $respuesta->s = false;
                $respuesta->msj = $at->message." - No es posible establecer conexion con el MEN para consultar datos del PIR";
            }else{
                $ControlConsultarPIR->consultarResultadosPIR();
                $respuestaPIR = $ControlConsultarPIR->getResultadosPIR();
                if(!empty($respuestaPIR->status)){
                    $respuesta->s = false;
                    $respuesta->msj = $respuestaPIR->message." - Puede que los datos que esta enviando no concuerden en la base de datos del MEN, por favor valide que esten correctos";
                }else{
                    $respuesta = $ControlConsultarPIR->actualizarResultadosSALA($db);
                    
                }
            }
            if(!$respuesta->s){
                $LogActualizacionMasivaPIR->setTipoDocumento($l->getTipodocumento());
                $LogActualizacionMasivaPIR->setNumerodocumento($l->getNumerodocumento());
                $LogActualizacionMasivaPIR->setNumeroregistroresultadopruebaestado($l->getNumeroregistroresultadopruebaestado());
                $LogActualizacionMasivaPIR->setIdEstudianteGeneral($l->getIdEstudianteGeneral());
                $LogActualizacionMasivaPIR->setMensajeLog($respuesta->msj);
                $LogActualizacionMasivaPIR->setFechadelproceso($fechaEjecucion);
                $LogActualizacionMasivaPIR->storeLog();
                $countErrores++;
            }
        }
        
        $fechaFin = date("Y-m-d H:i:s");
        print_r ("Finalizado en ".$fechaFin." \n".(count($listaPreinscritos)+count($listaInscritos))." registros procesados \n".$countErrores." registros con error");
        
    }

}