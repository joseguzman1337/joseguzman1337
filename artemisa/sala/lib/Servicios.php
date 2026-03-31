<?php
/**
 * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package lib
 */
defined('_EXEC') or die;

abstract class Servicios{
    public static function getMateriasMatriculadas($codigoEstudiante, $codigoPeriodo){
        //d($codigoPeriodo);
        require_once(PATH_SITE."/entidad/ViewMateriasMatriculadas.php");
        $db = Factory::createDbo();
        $where = " codigoestudiante = ".$db->qstr($codigoEstudiante)." AND codigoperiodo = ".$db->qstr($codigoPeriodo)." ";
        $listMateriasMatriculadas = ViewMateriasMatriculadas::getList($where);
        
        return $listMateriasMatriculadas;
    }
    
    public static function getListadoNotasMateria($codigoEstudiante, $codigoPeriodo, $codigoCarrera){
        require_once(PATH_SITE."/entidad/Carrera.php");
        require_once(PATH_SITE."/entidad/Corte.php");
        $return = array();
        
        $carreraSession = Factory::getSessionVar("carreraEstudiante");
        
        if(!empty($carreraSession) && ($codigoCarrera == $carreraSession->getCodigocarrera())){
            $Carrera = $carreraSession;
        }else{
            $Carrera = new Carrera();
            $Carrera->setDb();
            $Carrera->setCodigocarrera($codigoCarrera);
            $Carrera->getById();
        }
        
        $modalidadAcademica = $Carrera->getCodigomodalidadacademica();
        
        switch($modalidadAcademica){
            case '200':
                $return = self::getListadoNotasPregrado($codigoEstudiante, $codigoPeriodo, $codigoCarrera);
                break;
            case '300':
                $return = self::getListadoNotasPosgrado($codigoEstudiante, $codigoPeriodo, $codigoCarrera);
                break;
        }
        
        return $return;        
    }
    
    public static function getListadoNotasPregrado($codigoEstudiante, $codigoPeriodo, $codigoCarrera){
        require_once(PATH_SITE."/entidad/Carrera.php");
        require_once(PATH_SITE."/entidad/Corte.php");
        $db = Factory::createDbo();
        $return = array();
        
        $Carrera = new Carrera();
        $Carrera->setDb();
        $Carrera->setCodigocarrera($codigoCarrera);
        $Carrera->getById();
        
        /////////////////////////////////
        $listMateriasMatriculadas = Servicios::getMateriasMatriculadas($codigoEstudiante, $codigoPeriodo);
        $listadoMaterias = array();
        $listadoCortes = array();
        $listadoNotasMateriaCorte = array();
        //d($listMateriasMatriculadas);
        if(!empty($listMateriasMatriculadas)){ 
            foreach($listMateriasMatriculadas as $l){
                //ddd($l);
                $ObjMateria = new stdClass();
                $ObjMateria->Materia = $l->getDetallePrematricula()->getMateria();
                $ObjMateria->Grupo = $l->getDetallePrematricula()->getGrupo();
                $listadoMaterias[] = $ObjMateria;
                
                unset($ObjMateria);
            }
            //d($listadoMateria);
            $listadoCortes = Corte::getList(" codigocarrera= ".$db->qstr($codigoCarrera) . " AND  codigoperiodo= ".$db->qstr($codigoPeriodo) . " AND codigomateria = 1 " );
            if(empty($listadoCortes)){
                $listadoCortes = Corte::getList(" codigocarrera= ".$db->qstr($Carrera->getCodigoDiurno()) . " AND  codigoperiodo= ".$db->qstr($codigoPeriodo) . " AND codigomateria = 1 " );
            }
            //d($listadoCortesCarrera);
            
            //$listadoNotasMateriaCorte = Servicios::getListadoNotasMateria($listadoMateria, $listadoCortesCarrera, $codigoEstudiante, $periodoSession);
            //d($listadoNotasMateriaCorte);
            
            
            //$periodoSession = Factory::getSessionVar('codigoperiodosesion');
            if(!empty($listadoCortes)){
                $codigoCarreraCortes = $listadoCortes[0]->getCodigocarrera();
            }else{
                $codigoCarreraCortes = Factory::getSessionVar('idCarrera');
            }
            //d($listadoMaterias);


            foreach($listadoMaterias as $ObjMateria){
                $codigoCarreraMateria = $ObjMateria->Materia->getCodigocarrera();
                $listadoCortesMateria = Corte::getList(" codigocarrera = 1 AND  codigoperiodo= ".$db->qstr($codigoPeriodo) . " AND codigomateria = ".$db->qstr($ObjMateria->Materia->getCodigomateria()) . " " );

                if(empty($listadoCortesMateria)){
                    if($codigoCarreraCortes==$codigoCarreraMateria){
                        $listadoCortesMateria = $listadoCortes;
                    }else{
                        $listadoCortesMateria = Corte::getList(" codigocarrera= ".$db->qstr($codigoCarreraMateria) . " AND  codigoperiodo= ".$db->qstr($codigoPeriodo) . " AND codigomateria = 1 " );
                    }
                }

                $ObjMateria->notasCorte = null;
                $notasCorte = array();
                //d($listadoCortesMateria);
                if(!empty($listadoCortesMateria)){
                    foreach($listadoCortesMateria as $corte){
                        $objNotasCorte = new stdClass();
                        $objNotasCorte->Corte = $corte;
                        $objNotasCorte->detalleNotas = self::getNotasMateriaCorte($ObjMateria->Materia, $corte, $ObjMateria->Grupo, $codigoEstudiante, $codigoPeriodo);
                        if(!empty($objNotasCorte->detalleNotas)){
                            $objNotasCorte->detalleNotas = $objNotasCorte->detalleNotas[0];
                        }
                        $notasCorte[] = $objNotasCorte;
                        unset($objNotasCorte);
                    }
                    $ObjMateria->notasCorte = $notasCorte;
                }

                $return[] = $ObjMateria;
            }
        }
        return $return;
    }
    
    public static function getListadoNotasPosgrado($codigoEstudiante, $codigoPeriodo, $codigoCarrera){
        require_once(PATH_SITE."/entidad/Carrera.php"); 
        require_once(PATH_SITE."/entidad/ViewHistoricoNotasEstudiante.php"); 
        $db = Factory::createDbo();
        $return = array();
        
        $Carrera = new Carrera();
        $Carrera->setDb();
        $Carrera->setCodigocarrera($codigoCarrera);
        $Carrera->getById();
        
        /*d($codigoEstudiante);
        d($codigoPeriodo);
        d($codigoCarrera);/**/
        
        /////////////////////////////////
        $listMateriasMatriculadas = Servicios::getMateriasMatriculadas($codigoEstudiante, $codigoPeriodo);
        $listadoMaterias = array();
        
        //d($listMateriasMatriculadas);
        if(!empty($listMateriasMatriculadas)){ 
            foreach($listMateriasMatriculadas as $l){
                //ddd($l);
                $ObjMateria = new stdClass();
                $ObjMateria->Materia = $l->getDetallePrematricula()->getMateria();
                $ObjMateria->Grupo = $l->getDetallePrematricula()->getGrupo();
                $listadoMaterias[] = $ObjMateria;
                
                unset($ObjMateria);
            }
            //d($listadoMateria);

            foreach($listadoMaterias as $ObjMateria){
                $codigoCarreraMateria = $ObjMateria->Materia->getCodigocarrera();
                
                $codigoMateria = $ObjMateria->Materia->getCodigomateria();
                
                $where = "codigoperiodo = ".$db->qstr($codigoPeriodo)
                        . " AND codigomateria = ".$db->qstr($codigoMateria) 
                        . " AND codigoestudiante = ".$db->qstr($codigoEstudiante);
                
                $notas = ViewHistoricoNotasEstudiante::getList($where);
                $ObjMateria->notaHisotrico = null;
                
                if(!empty($notas)){
                    $ObjMateria->notaHisotrico = $notas[0];
                }
                
                /*$listadoCortesMateria = Corte::getList(" codigocarrera = 1 AND  codigoperiodo= ".$db->qstr($codigoPeriodo) . " AND codigomateria = ".$db->qstr($ObjMateria->Materia->getCodigomateria()) . " " );

                if(empty($listadoCortesMateria)){
                    if($codigoCarreraCortes==$codigoCarreraMateria){
                        $listadoCortesMateria = $listadoCortes;
                    }else{
                        $listadoCortesMateria = Corte::getList(" codigocarrera= ".$db->qstr($codigoCarreraMateria) . " AND  codigoperiodo= ".$db->qstr($codigoPeriodo) . " AND codigomateria = 1 " );
                    }
                }

                $ObjMateria->notasCorte = null;
                $notasCorte = array();
                //d($listadoCortesMateria);
                if(!empty($listadoCortesMateria)){
                    foreach($listadoCortesMateria as $corte){
                        $objNotasCorte = new stdClass();
                        $objNotasCorte->Corte = $corte;
                        $objNotasCorte->detalleNotas = self::getNotasMateriaCorte($ObjMateria->Materia, $corte, $ObjMateria->Grupo, $codigoEstudiante, $codigoPeriodo);
                        if(!empty($objNotasCorte->detalleNotas)){
                            $objNotasCorte->detalleNotas = $objNotasCorte->detalleNotas[0];
                        }
                        $notasCorte[] = $objNotasCorte;
                        unset($objNotasCorte);
                    }
                    $ObjMateria->notasCorte = $notasCorte;
                }/**/

                $return[] = $ObjMateria;
            }
        }
        return $return;
    }
    
    public static function getNotasMateriaCorte($Materia, $Corte, $Grupo, $codigoEstudiante, $codigoPeriodo){
        require_once(PATH_SITE."/entidad/DetalleNota.php");
        $db = Factory::createDbo();
        
        $where = " codigotiponota = 10 "
                . " AND idgrupo = ".$db->qstr($Grupo->getIdgrupo())." "
                . " AND idcorte = ".$db->qstr($Corte->getIdcorte())." "
                . " AND codigoestudiante = ".$db->qstr($codigoEstudiante)." "
                . " AND codigomateria = ".$db->qstr($Materia->getCodigomateria())." ";
                
        $notas = DetalleNota::getList($where);
                
        return $notas;
    }
    
    public static function getPeriodosEstudiante($codigoEstudiante, $idEstudianteGeneral=null){
        require_once(PATH_SITE."/entidad/ViewHistoricoNotasEstudiante.php");
        require_once(PATH_SITE."/entidad/Periodo.php");
        $db = Factory::createDbo();
        
        $where  = " idestudiantegeneral = ".$db->qstr(Factory::getSessionVar('sesion_idestudiantegeneral'))." "
                . " AND codigoestudiante = ".$db->qstr(Factory::getSessionVar('codigo'));
        
        $datos = ViewHistoricoNotasEstudiante::getList($where, "codigoperiodo");
        $codigosPeriodos = array();

        foreach($datos as $d){
            $codigosPeriodos[] = $d->getCodigoperiodo();
        }
        
        $periodos = array();
        
        if(!empty($codigosPeriodos)){
            $periodos = Periodo::getList(" codigoperiodo IN (".implode(",",$codigosPeriodos).") ORDER BY codigoperiodo DESC");
        }
        
        return $periodos;
    }
    
    public static function getPeriodoVigente(){
        require_once(PATH_SITE."/entidad/Periodo.php");
        $db = Factory::createDbo();
        
        /**
         * @modified Andres Ariza <arizaandres@unbosque.edu.do>
         * Se agrega en la validacion del estado de periodo el estado 4, de modo que cuando se este en proceso de cierre 
         * y activacion de nuevo periodo, si no hay periodo activo tome el periodo en inscripcion
         * @since Diciembre 20, 2018
         */

        $where  = " codigoestadoperiodo IN ( 1, 4 ) ORDER BY codigoestadoperiodo ";
        
        $periodos = Periodo::getList($where);
        
        $Periodo = null;
        
        if(!empty($periodos)){
            $Periodo = $periodos[0];
        }
        return $Periodo;
    }
    
    public static function getPeriodoVirtualVigente($Carrera, $modalidadAcademica=false){
        require_once(PATH_SITE."/entidad/PeriodoVirtualCarrera.php");
        
        $codigoModalidadAcademica = $Carrera->getCodigomodalidadacademica();
        $codigoCarrera = $Carrera->getCodigocarrera();
            
        $db = Factory::createDbo();
        
        $where[] = " codigoEstadoPeriodo = 1 ";
        
        if(empty($modalidadAcademica)){
            $where[] = " codigoCarrera = ".$db->qstr($codigoCarrera)." ";
        }elseif(!empty($codigoModalidadAcademica)){
            $where[] = " codigoModalidadAcademica = ".$db->qstr($codigoModalidadAcademica)." ";
        }
        
        $periodos = PeriodoVirtualCarrera::getList(implode(" AND ", $where));

        $Periodo = null;

        if(!empty($periodos)){
            $Periodo = $periodos[0];
            $Periodo->setDb();
            $Periodo->setEstadoPeriodo();
            $Periodo->setPeriodo();
            $Periodo->setPeriodoVirtual();
        }elseif($modalidadAcademica===false){
            $Periodo = self::getPeriodoVirtualVigente($Carrera, true);
        }
        return $Periodo;
    }

    public static function getUserImage($Usuario){
        require_once (PATH_SITE."/entidad/EstudianteDocumento.php");
        require_once (PATH_SITE.'/entidad/Estudiante.php');
        
        $userImageSession = Factory::getSessionVar('userImageSession');
        
        if(empty($userImageSession)){
            $linkimagen = null;
            $imagenjpg = $Usuario->getNumerodocumento().".jpg";
            $imagenJPG = $Usuario->getNumerodocumento().".JPG";
            //d(PATH_ROOT."/imagenes/estudiantes/".$imagenjpg);
            if(is_file(PATH_ROOT."/imagenes/estudiantes/".$imagenjpg)){
                $linkimagen = HTTP_ROOT."/imagenes/estudiantes/".$imagenjpg;
            }elseif(is_file(PATH_ROOT."/imagenes/estudiantes/".$imagenJPG)){
                $linkimagen = HTTP_ROOT."/imagenes/estudiantes/".$imagenJPG;
            }

            $db = Factory::createDbo();

            $codigotipousuario = Factory::getSessionVar('codigotipousuario');
            if(empty($linkimagen) && ($codigotipousuario == "600")){
                $codigoEstudiante = Factory::getSessionVar('codigo');
                $Estudiante = new Estudiante();
                $Estudiante->setCodigoEstudiante($codigoEstudiante);
                $Estudiante->setDb();
                $Estudiante->getById();

                $listaEstudianteDocumento = EstudianteDocumento::getList(" idestudiantegeneral = ".$db->qstr($Estudiante->getIdestudiantegeneral())." AND numerodocumento <> ".$db->qstr($Usuario->getNumerodocumento())." ORDER BY idestudiantedocumento DESC");
                //$listaEstudianteDocumento = EstudianteDocumento::getList(" idestudiantegeneral = ".$db->qstr($Estudiante->getIdestudiantegeneral())." ORDER BY idestudiantedocumento ASC" );
                //d($listaEstudianteDocumento);
                foreach($listaEstudianteDocumento as $ed){
                    $imagenjpg = $ed->getNumerodocumento().".jpg";
                    $imagenJPG = $ed->getNumerodocumento().".JPG";
                    //d(PATH_ROOT."/imagenes/estudiantes/".$imagenjpg);
                    if(is_file(PATH_ROOT."/imagenes/estudiantes/".$imagenjpg)){
                        $linkimagen = HTTP_ROOT."/imagenes/estudiantes/".$imagenjpg;
                        break;
                    }elseif(is_file(PATH_ROOT."/imagenes/estudiantes/".$imagenJPG)){
                        $linkimagen = HTTP_ROOT."/imagenes/estudiantes/".$imagenJPG;
                        break;
                    }
                }
            }

            if(empty($linkimagen)){
               $linkimagen = HTTP_SITE."/assets/img/av1.png";
            }
            
            Factory::setSessionVar('userImageSession', $linkimagen);

            return ($linkimagen);
        }else{
            return $userImageSession;
        }        
    }
    
    public static function isVirtual(Carrera $C){
        require_once (PATH_SITE."/entidad/Carrera.php");
        
        $db = Factory::createDbo();
        
        $codigoModalidad = $C->getCodigomodalidadacademica();
        $return = false;
        
        if(!empty($codigoModalidad)){
            $query = "SELECT codigomodalidadacademica "
                    . " FROM modalidadacademica "
                    . " WHERE nombremodalidadacademica LIKE '%Virtual P%' "
                    . " AND codigomodalidadacademica = ".$db->qstr($codigoModalidad);
            
            $datos = $db->Execute($query);
            
            if(!empty($datos)){
                $d = $datos->FetchRow();
                if(!empty($d)){
                    $return = true;
                }
            }
        }
        return $return;
    }
}