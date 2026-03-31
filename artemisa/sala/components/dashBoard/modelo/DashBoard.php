<?php
/**
 * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package model
 */
defined('_EXEC') or die;
class DashBoard implements Model{
    /**
     * @type adodb Object
     * @access private
     */
    private $db;
    
    public function __construct($db) {
        $this->db = $db;
    }
    
    public function getVariables($variables){
        /*
         * perfil 1 = Estudiante
         * perfil 2 = Profesor
         * perfil 3 = Administrativo
         * perfil 4 = Padre
         */
        require_once (PATH_SITE."/entidad/Usuario.php");
        require_once (PATH_SITE."/components/moduloCalendarioInstitucional/modelo/ModuloCalendarioInstitucional.php");
        require_once (PATH_SITE."/components/moduloGraficaNotas/modelo/ModuloGraficaNotas.php");
        $modeloRender = Factory::getRenderInstance();
        
        $array = array();
        
        $ModuloHistoricoNotas = new ModuloGraficaNotas($this->db);
        $variablesHistorico = clone $variables;
        $variablesHistorico->layout = "historico";
        unset($variablesHistorico->option);
        $arrayHistoricoNotas = $ModuloHistoricoNotas->getVariables($variablesHistorico);
        $moduloName = "moduloGraficaNotas"; 
        $historicoNotas = $modeloRender->render('historicoDeNotas',"/components/".$moduloName,$arrayHistoricoNotas, true);
        $array["historicoNotas"] = $historicoNotas; 

        
        $Usuario = new Usuario();
        $Usuario->setIdusuario(Factory::getSessionVar('idusuario'));
        $Usuario->getUsuarioByIdUsuario();
        
        $idPerfil = Factory::getSessionVar('idPerfil');
        $codigo = Factory::getSessionVar('codigo');
        $documento = $Usuario->getNumerodocumento();
        
        if((($idPerfil == 1 || $idPerfil == 4) && ($codigo == $documento)) || (@$variables->layout=="carrerasEstudiante" )){
            $variables->layout = "carrerasEstudiante";
            $array["carrerasEstudiante"] = $this->getCarrerasEstudiante();
        }
        $tipoHorario = "";
        if($idPerfil == 1){            
            $tipoHorario = 'estudiante';            
            //consulta si el usuario tiene encuestas pendientes por contestar
            $encuestas = $this->getEncuestasDocente($Usuario, $codigo);  
            if( !empty($encuestas) && !empty($encuestas[0]) ){
                $r=0;
                foreach($encuestas as $encuesta){                    
                    //valida si existe una categoria y si el valor de la encuesta es mayor a cero  
                    if(!empty($encuesta['value']) && ($encuesta['value'] > 0)){
                        $array['encuestas'][$r]["encuestavalue"] = $encuesta['value'];
                        $array['encuestas'][$r]["categoria"] = $encuesta['cat'];
                        $array['encuestas'][$r]["documento"] = $documento;
                        $array['encuestas'][$r]["encuestamsg"] = $encuesta['msg'];
                        //asigna un valor si es obligatoria
                        $array['encuestas'][$r]['obligatoria'] =$encuesta['obligatoria'];
                        if($encuesta['obligatoria'] == 1){
                            $array["obligatoria"] = 1;
                        }
                        //is la categoria es docentes                        
                        if($array['encuestas'][$r]["categoria"] == 'EDOCENTES'){    
                            $array['encuestas'][$r]["grupo"] = $encuesta['grupo'];                
                            $array['encuestas'][$r]["estadogrupo"] = $encuesta['estadogrupo'];
                            $array['encuestas'][$r]["idgrupo"] = $encuesta['idgrupo'];      
                        }
                    }
                    $r++;
                }                
            }            
        }elseif($idPerfil == 2){                            
            $tipoHorario = 'Docente';
            $array["banner"]=  $this->getFechaBanner();              
        }
        $array["horario"] = $this->getHorario($tipoHorario,$Usuario,$variables);

        $moduloCalendarioInstitucional = new ModuloCalendarioInstitucional($this->db);
        $arrayCaledario = $moduloCalendarioInstitucional->getVariables($variables);
        
        $moduloName = "moduloCalendarioInstitucional";         

        $calendario = $modeloRender->render('default',"/components/".$moduloName,$arrayCaledario, true);
        
        $array["calendario"] = $calendario;
                
        return $array;
    }
    
    private function getVotacionDocente(){
        require_once (PATH_SITE."/entidad/Votacion.php");
        require_once (PATH_SITE."/entidad/DocentesVoto.php");
        
        //'codigodocente';
        $codigodocente = Factory::getSessionVar('codigodocente');
        $Votacion = new Votacion();
        $DocentesVoto = new DocentesVoto();
        $Votacion->setDb();
        $Votacion->getVotacionVigente();
        
        $idVotacion = $Votacion->getIdvotacion();
        if(!empty($idVotacion)){
            $DocentesVoto->setDb();
            $DocentesVoto->setNumerodocumento($codigodocente);
            $DocentesVoto->getByDocumento();
            $codigoCarrera = $DocentesVoto->getCodigocarrera();
            if(empty($codigoCarrera)){
                //$Votacion = null;
            }
            
            if(!empty($numerodocumento)){
                $query_votacion_vigente="SELECT COUNT(vv.numerodocumentovotantesvotacion) AS votos "
                        . "FROM votacion v "
                        . "INNER JOIN votantesvotacion vv ON (v.idvotacion = vv.idvotacion) "
                        . "WHERE v.codigoestado = '100' "
                        . " AND vv.codigoestado = '100' "
                        . " AND now() BETWEEN v.fechainiciovotacion AND v.fechafinalvotacion "
                        . " AND v.idvotacion = ".$this->db->qstr($idVotacion)." "
                        . " AND vv.numerodocumentovotantesvotacion = ".$this->db->qstr($codigodocente)." ";
                
		$operacion_votacion_vigente = $this->db->Execute($query_votacion_vigente);
		$row_operacion_votacion_vigente = $operacion_votacion_vigente->fetchRow();
		$cantVotos = $row_operacion_votacion_vigente['votos'];
		if($cantVotos==0){
                    $datosvotante = array('codigoestudiante'=> Factory::getSessionVar('codigo'),'numerodocumento'=>$codigodocente,'codigocarrera'=>$codigoCarrera,'tipovotante'=>'docente','cantVotos'=>$cantVotos,'idvotacion'=>$idVotacion,'modalidadacademica'=>null);
                    Factory::setSessionVar('datosvotante', $datosvotante);
		}
            }
            
        }
        return $Votacion;
    }
    
    private function getCarrerasEstudiante(){
        $codigoestudiante = Factory::getSessionVar('codigo');
        
        $Usuario = new Usuario();
        $Usuario->setIdusuario(Factory::getSessionVar('idusuario'));
        $Usuario->getUsuarioByIdUsuario();
         
        $documento = $Usuario->getNumerodocumento();
        unset($Usuario);
        
        if($documento!=$codigoestudiante){
            $codigoestudiante = $documento;
        }
        //d($codigoestudiante);
        $query = "SELECT DISTINCT c.nombrecarrera, c.codigocarrera, eg.apellidosestudiantegeneral, "
                . " eg.nombresestudiantegeneral, d.nombredocumento, d.tipodocumento, "
                . " e.codigoestudiante, eg.numerodocumento, eg.fechanacimientoestudiantegeneral, "
                . " eg.expedidodocumento, eg.idestudiantegeneral, gr.nombregenero, "
                . " e.codigoperiodo, eg.celularestudiantegeneral, eg.emailestudiantegeneral, "
                . " eg.codigogenero,s.nombresituacioncarreraestudiante, eg.direccionresidenciaestudiantegeneral, "
                . " eg.telefonoresidenciaestudiantegeneral, eg.ciudadresidenciaestudiantegeneral, eg.direccioncorrespondenciaestudiantegeneral, "
                . " eg.telefonocorrespondenciaestudiantegeneral, eg.ciudadcorrespondenciaestudiantegeneral, e.codigocarrera "
                . "FROM estudiante e "
                . "INNER JOIN estudiantegeneral eg ON (e.idestudiantegeneral = eg.idestudiantegeneral) "
                . "INNER JOIN estudiantedocumento ed ON (e.idestudiantegeneral = ed.idestudiantegeneral AND ed.idestudiantegeneral = eg.idestudiantegeneral) "
                . "INNER JOIN carrera c ON (e.codigocarrera = c.codigocarrera) "
                . "INNER JOIN documento d ON (eg.tipodocumento = d.tipodocumento) "
                . "INNER JOIN situacioncarreraestudiante s ON (e.codigosituacioncarreraestudiante = s.codigosituacioncarreraestudiante) "
                . "INNER JOIN genero gr ON (gr.codigogenero = eg.codigogenero) "
                . "WHERE ed.numerodocumento = ".$this->db->qstr($codigoestudiante)." "
                . "ORDER BY e.codigosituacioncarreraestudiante DESC";
        //d($query);
        $datos = $this->db->Execute($query);
        $data = $datos->GetArray();
        
        return $data;
    }
    
    private function getHorario($tipo,$Usuario,$variables){
        require_once (PATH_SITE."/components/horario/modelo/Horario.php");
        $horario = null;
        $modeloRender = Factory::getRenderInstance();
        $variables->Usuario = $Usuario;
        $variables->periodo = Factory::getSessionVar('codigoperiodosesion');
        $variables->FechaFutura_1 = date("Y-m-d");
        $variables->FechaFutura_2 = date("Y-m-d");
        $variables->diaDeLaSemana = date('N');
        $variables->tipo = $tipo;
        //d($variables);
        
        $Horario = new Horario($this->db);
        $array = $Horario->getVariables($variables);
        
        $moduloName = "horario"; 
        if(!empty($tipo)){
            $horario = $modeloRender->render('default',"/components/".$moduloName,$array, true);
        }
        return $horario;
    }
    
    /*Funcion creada para la definición de la fecha inicio y la fecha fin en las que se va a mostrar el Banner de la Autoevalución de Asignaturas por parte de los docentes.*/
    private function getFechaBanner(){ 
        $query = "SELECT imagen, UrlEncuesta "
                . " FROM AutoevaluacionesDocente "
                . " WHERE FechaInicial <= NOW() "
                . " AND Fechafinal >= NOW() "
                . " AND CodigoEstado=100";
        $datos = $this->db->GetRow($query);                   
        
        $arrayautoevaluacion = array();
        
        if(!empty($datos)){
            $arrayautoevaluacion['imagen'] = $datos['imagen'];
            $arrayautoevaluacion['UrlEncuesta']= $datos['UrlEncuesta'];
        }
         
        return $arrayautoevaluacion;
     }
      
     /*
      * Ivan Dario quintero 
      * Octubre 23 Actiacion de encuestas para bienestar y otras
      */
      
     
    private function getEncuestasDocente($Usuario, $codigo){
        $codigoestudiante = $codigo;
        $idCarrera = Factory::getSessionVar('idCarrera');
        $idusuario = $Usuario->getIdusuario();              
        $codigoperiodo = Factory::getSessionVar('codigoperiodosesion');
        
        if(!empty($idCarrera)){
            require_once (PATH_SITE."/entidad/SiqAinstrumentoconfiguracion.php");
            require_once (PATH_SITE."/entidad/SiqApublicoobjetivo.php");
            require_once (PATH_SITE."/entidad/SiqAdetallepublicoobjetivo.php");
            
            require_once (PATH_SITE."/entidad/Estudiante.php");
            require_once (PATH_SITE."/entidad/EncuestaCarreras.php");
            require_once (PATH_SITE."/entidad/EncuestaMateria.php");
            require_once (PATH_SITE."/entidad/ActualizacionUsuario.php");
            
            $SiqAinstrumentoconfiguracion = new SiqAinstrumentoconfiguracion(); 
            $SiqApublicoobjetivo = new SiqApublicoobjetivo();
            $SiqAdetallepublicoobjetivo = new SiqAdetallepublicoobjetivo();
            $Estudiante = new Estudiante();
            $EncuestaCarreras = new EncuestaCarreras();
            $EncuestaMateria = new EncuestaMateria();
            $ActualizacionUsuario = new ActualizacionUsuario();
                        
            $where = " codigoestudiante = ".$codigoestudiante;
            $estudiante = $Estudiante->getList($where);
            $valorreturn = array();
            
            if(count($estudiante)> 0){
                $tipoestudiante = $estudiante[0]->getCodigoTipoEstudiante();
                $situacionestudiante = $estudiante[0]->getCodigoSituacionCarreraEstudiante();
                //$semestreestudiante = $estudiante[0]->getSemestre();

                /*consulta las encuestas activas para fecha actual.*/
                $dia = date("Y-m-d");
                
                $inner = " INNER JOIN siq_Apublicoobjetivo po ON (po.idsiq_Ainstrumentoconfiguracion = siq_Ainstrumentoconfiguracion.idsiq_Ainstrumentoconfiguracion) ";
                                
                $where = " siq_Ainstrumentoconfiguracion.fecha_inicio <= ".$this->db->qstr($dia)
                        . " AND siq_Ainstrumentoconfiguracion.fecha_fin >= ".$this->db->qstr($dia)
                        . " AND siq_Ainstrumentoconfiguracion.codigoestado = 100 "
                        . " AND siq_Ainstrumentoconfiguracion.estado = 1 ";
                
                $rol = Factory::getSessionVar('rol');
                
                switch($rol){
                    case '1':
                        $inner .= " INNER JOIN siq_Adetallepublicoobjetivo dop on (po.idsiq_Apublicoobjetivo = dop.idsiq_Apublicoobjetivo)  ";
                        $where .= " AND (po.estudiante = 1 OR po.admin = 1 OR cvs = 1) ";
                        $where .= " AND	(dop.E_New = 1 || dop.E_Old = 1 || dop.E_Egr = 1 ||dop.E_Gra = 1)";
                        break;
                    case '2':
                        $where .= " AND (po.docente = 1 OR cvs = 1) ";
                        break;
                    case '3':
                    //case '13':
                        $where .= " AND (po.admin = 1 OR cvs = 1) ";
                        break;
                    case '4':
                        //Padre no existe
                        $where .= " AND (po.admin = 12 OR cvs = 1) ";
                        break;    
                }/**/
                $distinct = true;
                $lista = $SiqAinstrumentoconfiguracion->getList($where, $inner, $distinct);             
                        
                /*Si existen encuestas activas ingresa*/
                if(count($lista)> 0){
                    //ingresa a la lista de encuestas activas    
                    $h=0;
                    foreach($lista as $datos){
                        //obtiene el id del instrumento.
                        $idinstrumento = $datos->getIdsiq_Ainstrumentoconfiguracion();                                                     
                        //identifica la categoria
                        $value = $idinstrumento;
                        $cat= $datos->getCat_ins();                                                
                                                                               
                        $where = " idsiq_Ainstrumentoconfiguracion = ".$idinstrumento;
                        $publicoobjetivo = $SiqApublicoobjetivo->getList($where);   
                        
                        if(count($publicoobjetivo)>0){                            
                            $obligatorio= $publicoobjetivo[0]->getObligar();
                            $idpublico = $publicoobjetivo[0]->getIdsiq_Apublicoobjetivo();
                             //retorna el nombre de la encuesta
                            $msg = $datos->getNombre();                            
                            //identifica la carrera                                      
                            $estadousuario = $SiqAdetallepublicoobjetivo->getPublicoObjetivoinstrumento($idinstrumento, $tipoestudiante, $situacionestudiante, $idCarrera);                                                               
                            //si el estado del usuario                            
                            if($estadousuario == true){
                                $estadousuario = $ActualizacionUsuario->getEstadoActualizarUsuario($idusuario, $idinstrumento, $codigoperiodo); 
                                if($estadousuario !== 3){  
                                    $continuar = true;
                                }else{
                                    $continuar = false;
                                }
                            }else{
                                $documento = $Usuario->getNumerodocumento();
                                //si el estudiante no esta en el publico objetivo se debe validar si existe en la lista de registros de cvs
                                $continuar= $SiqAdetallepublicoobjetivo->getPublicoCsv($idpublico, $documento);                                            
                            }
                        }else{
                            $continuar = false;
                        }
                        
                        if($continuar === true){
                            $valorreturn[$h]['obligatoria'] = $obligatorio;
                            $valorreturn[$h]['msg']= $msg;
                            $valorreturn[$h]['value']= $value;
                            $valorreturn[$h]['cat']= $cat;                            
                            //si el semestre es 99, se debe aplicar a todos los estudiantes de todos los semestres
                            //$semestreencuesta = $SiqAdetallepublicoobjetivo->getSemestre();                                    
                            //segun la categoria define actividades                                
                            switch($cat){
                                case 'EDOCENTES':
                                    //validar si las fechas de la encuesta esta en la fecha
                                    $wherefechas = " CodigoCarrera = '".$idCarrera."' and CodigoPeriodo = '".$codigoperiodo."' "
                                    . "AND FechaInicial <= now() AND FechaFinal >= now() and CodigoEstado=100";
                                    $programaactivo = $EncuestaCarreras->getList($wherefechas);                                        
                                    if(count($programaactivo) > 0){
                                        $idencuenstacarrera = $programaactivo[0]->getIdencuestacarrera();                                                        
                                        if(!empty($idencuenstacarrera)){                                                                
                                            //si tiene materias matriculadas
                                            $materiasactivas = $EncuestaMateria->getEncuestamateriaEstudiante($codigoperiodo,$idCarrera,$codigoestudiante);                                                                                                                            
                                            //Crear el contador de las materias del estudiante
                                            $countmaterias = count($materiasactivas);
                                            $materiasevaluadas=0;
                                            //validar respuestas de materias
                                            if($countmaterias>0){                                                                    
                                                foreach($materiasactivas as $activas){
                                                  /**
                                                    * Caso 105
                                                    * @modified Luis Dario Gualteros C <castroluisd@unbosque.edu.co>
                                                    * Se adiciona el parametro de la categoria ($cat) para realizar las respectivas validaciones 
                                                    * Para las encuestas de Bienestar Universitario.
                                                    * @since Febrero 4, 2019.
                                                  */
                                                    $respuestas = $EncuestaMateria->getRespuestaencuestamateria($idusuario, $idinstrumento,$cat,  $activas['idgrupo']);                                                       
                                                    $valorreturn[$h]['grupo'][]= $activas['nombremateria'];
                                                    if($respuestas == false){
                                                        $valorreturn[$h]['value'] = $idinstrumento;
                                                        $valorreturn[$h]['estadogrupo'][] = 'pendiente';
                                                        $valorreturn[$h]['idgrupo'][] = $activas['idgrupo'];
                                                    }else{
                                                        $materiasevaluadas++;
                                                        $valorreturn[$h]['estadogrupo'][]= 'realizada';  
                                                        $valorreturn[$h]['idgrupo'][] = 0;
                                                        $ActualizacionUsuario->ActualizarEstadoActualizarUsuario($idusuario, $idinstrumento, $codigoperiodo);
                                                    }
                                                }
                                                //si la cantidad de materias es igual al numero de materias evaluadas finaliza la encuesta
                                                if($countmaterias == $materiasevaluadas){                                                                          
                                                    $estado = 3;
                                                    $ActualizacionUsuario->ActualizarUsuario($estado, $idusuario, $idinstrumento, $codigoperiodo);
                                                    $valorreturn[$h]['value'] = 0;
                                                    $valorreturn[$h]['cat'] = "";
                                                }else{                                                                        
                                                    $valorreturn[$h]['codigoestudiante']=$codigoestudiante;
                                                    $valorreturn[$h]['value'] = $idinstrumento;
                                                }
                                            }else{
                                                 $valorreturn[$h]['value'] = 0;
                                            }
                                        }else{
                                            $valorreturn[$h]['value'] = 0;
                                        }
                                    }else{
                                        $valorreturn[$h]['value'] = 0;
                                    }
                                break;
                                /**
                                  * Caso 105
                                  * @modified Luis Dario Gualteros C <castroluisd@unbosque.edu.co>
                                  * Se adiciona el parametro de la categoria ($cat) para realizar las respectivas validaciones 
                                  * Para las encuestas de Bienestar Universitario.
                                  * @since Febrero 4, 2019.
                                */
                                case 'OTRAS':   
                                    $valorreturn[$h]['value'] = $idinstrumento;                                                        
                                    $resultados = $EncuestaMateria->getRespuestaencuestamateria($idusuario, $idinstrumento, $cat );                                            
                                    if($resultados == true){
                                        $estado = 3;
                                        $ActualizacionUsuario->ActualizarUsuario($estado, $idusuario, $idinstrumento, $codigoperiodo);                                                        
                                        $valorreturn[$h]['value'] = 0;
                                    }                                            
                                break;
                                case 'BIENESTAR':
                                    $valorreturn[$h]['value'] = $idinstrumento;                                                        
                                    $resultados = $EncuestaMateria->getRespuestaencuestamateria($idusuario, $idinstrumento, $cat);
                                    if($resultados == true){
                                        $estado = 3;
                                        $ActualizacionUsuario->ActualizarUsuario($estado, $idusuario, $idinstrumento, $codigoperiodo);                                                        
                                        $valorreturn[$h]['value'] = 0;
                                    }
                                break;
                                //End Caso 105
                                case 'OBS':  
                                    $valorreturn[$h]['value'] = $idinstrumento;
                                break;
                                case 'COLEGIO':
                                    $valorreturn[$h]['value'] = $idinstrumento;
                                    //../serviciosacademicos/mgi/autoevaluacion/interfaz/colegio.php
                                break;
                                case 'EGRESADOS':  
                                    $valorreturn[$h]['value'] = $idinstrumento;
                                break;
                                case 'MGI':     
                                    $valorreturn[$h]['value'] = $idinstrumento;
                                break;                        
                            }
                            //unset($idinstrumento);                     
                            if($valorreturn[$h]['value'] == $idinstrumento){
                                $h++;
                            }
                        }
                    }
                }
            }else{
                 $valorreturn[0]['value'] = 0;
            }
            return $valorreturn;
        }
        else{
            return $valorreturn[0]['value'] = 0;
        }
    }
}
