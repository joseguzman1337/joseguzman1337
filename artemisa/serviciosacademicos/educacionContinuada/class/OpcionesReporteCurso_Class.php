<?php
class OpcionesReporteCurso{
    public function CancelarRegistro($db,$idEstudiante,$id,$userid){
        $SQL='UPDATE  EstudianteConvenioEducacionContinuada
              SET     CodigoEstado=200,
                      UsuarioUltimaModificacion="'.$userid.'",
                      FechaultimaModificacion=NOW()
              WHERE   EstudianteConvenioEducacionContinuadaId="'.$id.'" AND Idestudiantegeneral="'.$idEstudiante.'"';
              
        if($Cancelar=&$db->Execute($SQL)===false){
           $info['val'] = false;
           $info['msj'] = 'Ha Ocurido Un Problema Cancelando...';
           echo json_encode($info);
           exit; 
        }   
        $info['val'] = true;
        $info['msj'] = 'Se ha cancelado el registro de forma correcta...';
        echo json_encode($info);
        exit;    
    }//public function CancelarRegistro
     public function GenerarOrdenPago($codigoestudiante,$codigoperiodo,$db){ //echo 'llego...>';echo '<pre>';print_r($db->_connectionID);//die;  
     
        require_once('../../Connections/sala2.php');        

        include_once('../../funciones/funcionip.php');
        
        $ruta = "../../funciones/";
        
        $rutaorden = "../../funciones/ordenpago/";
        
        include_once($rutaorden.'claseordenpago.php');
        
        mysql_select_db($database_sala, $db->_connectionID);     
        
        $ordenesxestudiante = new Ordenesestudiante($db->_connectionID, $codigoestudiante, $codigoperiodo);
		
        if(!$ordenesxestudiante->validar_generacionordenesmatricula(1)){
            $info['val'] = 1;
            $info['msj'] = "Por favor comunicarse con la Universidad";
            // echo '<pre>';print_r($info);
            echo json_encode($info);
            exit;
        }else{
           
              $SQL='SELECT
                    numeroordenpago
                    FROM
                    ordenpago
                    WHERE
                    codigoestudiante="'.$codigoestudiante.'"
                    AND
                    codigoperiodo="'.$codigoperiodo.'"
                    AND
                    codigoestadoordenpago IN(10,40)';
                    
             if($Existe=&$db->Execute($SQL)===false){
                echo 'Error en el SQL Existe....';
                die;
            }     
            
            if($Existe->EOF){  
                
                $SQL='select v.codigoconcepto,v.preciovaloreducacioncontinuada
    			from valoreducacioncontinuada v, estudiante e, carrera ca, modalidadacademica m
    			where v.codigocarrera = e.codigocarrera
    			and v.fechainiciovaloreducacioncontinuada <= NOW()
    			and v.fechafinalvaloreducacioncontinuada >= NOW()
    			and e.codigoestudiante = "'.$codigoestudiante.'"
    			and ca.codigocarrera = e.codigocarrera
    			and ca.codigomodalidadacademica = m.codigomodalidadacademica
    			and ca.codigoreferenciacobromatriculacarrera like "2%"';
                
                if($Valores=&$db->GetAll($SQL)===false){
                    echo 'Error en el SQL valores....';
                    die;
                }
                $SQL='SELECT
                    m.codigomateria,
                    g.idgrupo,
                    g.codigoestadogrupo
                    FROM
                    estudiante e INNER JOIN materia m ON m.codigocarrera=e.codigocarrera
                    INNER JOIN grupo g ON g.codigomateria=m.codigomateria
                    WHERE
                    e.codigoestudiante="'.$codigoestudiante.'"
                    AND
                    e.codigoperiodo="'.$codigoperiodo.'"
                    AND
                    g.fechafinalgrupo>=CURDATE()
                    AND
                    g.codigoestadogrupo=10';
                    
                if($ValidaGrupoActivo=&$db->Execute($SQL)===false){
                    $info['val'] = 1;
                    $info['msj'] = "Error al validar el grupo activo";
                    
                    // echo '<pre>';print_r($info);
                    echo json_encode($info);
                    exit;
                }  
                
                if($ValidaGrupoActivo->EOF){
                    $info['val'] = 1;
                    $info['msj'] = "El Grupo Asociado no Esta Activo";
                    echo json_encode($info);
                    exit;
                }  
                $nuevaorden = $ordenesxestudiante->generarordenpago_matriculaEducacionContinuada($Valores[0]['codigoconcepto'],$Valores[0]['preciovaloreducacioncontinuada']);
                
                $info['val'] = 2;
                $info['msj'] = "Se ha genarado la Orden correctamente...";
                $info['codigoestudiante'] = $codigoestudiante;
                $info['codigoperiodo'] = $codigoperiodo;
                // echo '<pre>';print_r($info);
                echo json_encode($info);
                exit;
            }else{
               // $this->VerOrdenes($db,$codigoestudiante,$codigoperiodo);
                $info['val'] = 2;
                $info['msj'] = "Estimado Usuario usted ya Tiene una Orden Creada...";
                $info['codigoestudiante'] = $codigoestudiante;
                $info['codigoperiodo'] = $codigoperiodo;
                // echo '<pre>';print_r($info);
                echo json_encode($info);
                exit;
            }
        }
   }// public function GenerarOrdenPago 
   public function CambioStatus($db,$Estatus,$id,$idestudiantegeneral,$userid,$CodigoEstudiante,$CodigoPeriodo){
        $SQL='UPDATE EstudianteConvenioEducacionContinuada
              SET    Estatus ="'.$Estatus.'", 
                     UsuarioUltimaModificacion="'.$userid.'",
                     FechaultimaModificacion =NOW()
              WHERE  Idestudiantegeneral ="'.$idestudiantegeneral.'"  AND EstudianteConvenioEducacionContinuadaId ="'.$id.'"  AND CodigoEstado = 100';
              
          if($CambioEstatus=&$db->Execute($SQL)===false){
               $info['val'] = false;
               $info['msj'] = 'Ha Ocurido Un Problema cambiando el Status...';
               echo json_encode($info);
               exit; 
          }  
           
        $this->GenerarOrdenPago($CodigoEstudiante,$CodigoPeriodo,$db);
          
   }//public function Aprobado
   public function CambioCarrera($db,$Codigoestudiante,$Carrera,$userid,$idestudiantegeneral,$CodigoPeriodo,$id){
        $SQL='UPDATE estudiante
              SET    codigocarrera="'.$Carrera.'"
              WHERE  codigoestudiante="'.$Codigoestudiante.'"';
              
         if($CambioCarrera=&$db->Execute($SQL)===false){
            $info['val'] = false;
            $info['msj'] = 'Ha Ocurido Un Problema cambiando de la Carrera...';
            echo json_encode($info);
            exit; 
         }   
         
      $this->CambioStatus($db,0,$id,$idestudiantegeneral,$userid,$Codigoestudiante,$CodigoPeriodo);     
   }//public function CambioCarrera
}///class OpcionesReporteCurso

?>