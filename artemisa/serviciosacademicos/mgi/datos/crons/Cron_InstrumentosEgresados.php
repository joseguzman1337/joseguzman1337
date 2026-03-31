<?php

include("../templates/template.php");

$db = getBD();
    
    
    $D_Valores  = array();
    
    $D_Valores[] = '1232';//Ciudad Recidencia 0
    $D_Valores[] = '1233';//Dirreccion 1
    $D_Valores[] = '1234';//Telefono 2
    $D_Valores[] = '1235';//Celular 3 
    $D_Valores[] = '1236';//Correo Electronio o E-mail 4
    $D_Valores[] = '1240';//Estado Civil  5
    
    
      $SQl_ins='SELECT  
      
                ins.idsiq_Ainstrumentoconfiguracion  AS id
                
                FROM 
                
                siq_Ainstrumentoconfiguracion  ins  INNER JOIN actualizacionusuario act ON act.id_instrumento=ins.idsiq_Ainstrumentoconfiguracion
                
                WHERE
                
                ins.cat_ins ="EGRESADOS" 
                AND 
                act.codigoestado=100
                AND
                ins.codigoestado=100
                
                GROUP BY ins.idsiq_Ainstrumentoconfiguracion 
                
                ORDER BY ins.idsiq_Ainstrumentoconfiguracion';
                
                
        if($Instrumentos=&$db->Execute($SQl_ins)===false){
            echo 'Error en el SQLde Busqyeda de Instrumentos de Egresados...<br><br>'.$SQl_ins;
            die;
        } 
        
    while(!$Instrumentos->EOF){
        /*********************************************************************/
        $instrumento_id = $Instrumentos->fields['id'];
        
          $SQL_Usuario='SELECT 

                        usuarioid,
                        numerodocumento
                        
                        FROM  
                        
                        actualizacionusuario 
                        
                        WHERE 
                        
                        id_instrumento ="'.$instrumento_id.'"
                        AND
                        codigoestado=100
                        AND
                        estadoactualizacion  IN(1,2)
                        
                        GROUP BY numerodocumento';
                        
              if($Usuario=&$db->Execute($SQL_Usuario)===false){
                echo 'Error en el SQL del Usuario....<br><br>'.$SQL_Usuario;
                die;
              }     
              
            while(!$Usuario->EOF){
                /***********************************************************************/
                $Usuario_id      = $Usuario->fields['usuarioid'];
                $numerodocumento = $Usuario->fields['numerodocumento'];  
                
                   $SQL_Eg='SELECT 
                            
                            idestudiantegeneral
                            
                            FROM 
                            
                            estudiantegeneral 
                            
                            WHERE 
                            
                            numerodocumento ="'.$numerodocumento.'"';
                            
                            
                  if($Estudiante=&$db->Execute($SQL_Eg)===false){
                    echo 'Error en el SQL del Estudiante General...<br><br>'.$SQL_Eg;
                    die;
                  }     
                  
                  if(!$Estudiante->EOF){
                    /*****************************************/
                    $id_EstudianteGeneral = $Estudiante->fields['idestudiantegeneral'];
                    
                    $D_Respuestas = DataPreguntaRespuesta($db,$instrumento_id,$D_Valores,$numerodocumento);
                    
                    //echo '<pre>';print_r($D_Respuestas);die;
                    
                    $SQL_Ciudad='SELECT idciudad FROM ciudad WHERE nombreciudad LIKE "%'.$D_Respuestas[$D_Valores[0]].'%"';
                    
                    if($Ciudad=&$db->Execute($SQL_Ciudad)===false){
                        Echo 'Error en el SQL de la Ciudad....<br><br>'.$SQL_Ciudad;
                        die;
                    }
                    //$D_Valores[0];//Ciudad
                    
                    $SQL_EstadoCivil='SELECT respuesta FROM siq_Apreguntarespuesta WHERE idsiq_Apreguntarespuesta ="'.$D_Respuestas[$D_Valores[5]].'"';
                    
                    if($EstadoCivil=&$db->Execute($SQL_EstadoCivil)===false){
                        echo 'Error en el SQl del Estado Civil....<br><br>'.$SQL_EstadoCivil;
                        die;
                    }
                    //$D_Valores[5];//Estado Civil
                    
                    $SQL_CodEstado='SELECT idestadocivil FROM estadocivil WHERE nombreestadocivil LIKE "%'.$EstadoCivil->fields['respuesta'].'%"';
                    
                    if($CodEstadoCivil=&$db->Execute($SQL_CodEstado)===false){
                        echo 'Error en el SQL delCodigo Estado Civil...<br><br>'.$SQL_CodEstado;
                        die;
                    }
                    
                    $Update_Eg='UPDATE  estudiantegeneral
                    
                                SET
                                        idestadocivil="'.$CodEstadoCivil->fields['idestadocivil'].'",
                                        direccionresidenciaestudiantegeneral="'.$D_Respuestas[$D_Valores[1]].'",
                                        ciudadresidenciaestudiantegeneral="'.$Ciudad->fields['idciudad'].'",
                                        telefonoresidenciaestudiantegeneral="'.$D_Respuestas[$D_Valores[2]].'",
                                        celularestudiantegeneral="'.$D_Respuestas[$D_Valores[3]].'",
                                        email2estudiantegeneral="'.$D_Respuestas[$D_Valores[4]].'"
                                WHERE   
                                        idestudiantegeneral="'.$id_EstudianteGeneral.'"';
                                        
                         if($ModificaEgeneral=&$db->Execute($Update_Eg)===false){
                            echo 'Error en Update de Estudiante Genral......<br><br>'.$Update_Eg;
                            die;
                         }               
                                        
                        $SQL_G='SELECT 
                                
                                idegresado
                                
                                FROM egresado 
                                
                                WHERE
                                
                                idestudiantegeneral="'.$id_EstudianteGeneral.'"
                                AND
                                codigoestado=100';     
                                
                        if($Egresado=&$db->execute($SQL_G)===false){
                            echo 'Errro ren el SQL del Los Egresados...<br><br>'.$SQL_G;
                            die;
                        }       
                        /*************************Datos del Estudiante**************************/
                        $SQL_EstudianteGeneral='SELECT  
                                                
                                                nombresestudiantegeneral,
                                                apellidosestudiantegeneral,
                                                numerodocumento,
                                                tipodocumento,
                                                telefonoresidenciaestudiantegeneral,
                                                celularestudiantegeneral,
                                                direccionresidenciaestudiantegeneral
                                                
                                                FROM 
                                                
                                                estudiantegeneral
                                                
                                                WHERE
                                                
                                                idestudiantegeneral="'.$id_EstudianteGeneral.'"';
                                                
                            if($EstudianteGeneral=&$db->Execute($SQL_EstudianteGeneral)===false){
                                echo 'Error en el SQL del Estudiante Genral Datos...<br><br>'.$SQL_EstudianteGeneral;
                                die;
                            }       
                            
                         $D_Estudiante = $EstudianteGeneral->GetArray();                  
                        /***********************************************************************/
                        if($Egresado->EOF){
                            /*************Se inserta el Registro******************/
                            $Insert_G='INSERT INTO egresado(nombrecortoegresado,fechadigitaegresado,idestudiantegeneral,tipodocumento,numerodocumento,apellidosegresado,nombresegresado,telefonoresidenciaegresado,telefonorecelularegresado,direccionresidenciaegresado,ciudadpaisresidenciaegresado,emailegresado,codigoestado,codigoindicadorverificacion)VALUES("'.$id_EstudianteGeneral.'",NOW(),"'.$id_EstudianteGeneral.'","'.$D_Estudiante[0]['tipodocumento'].'","'.$D_Estudiante[0]['numerodocumento'].'","'.$D_Estudiante[0]['apellidosestudiantegeneral'].'","'.$D_Estudiante[0]['nombresestudiantegeneral'].'","'.$D_Estudiante[0]['telefonoresidenciaestudiantegeneral'].'","'.$D_Estudiante[0]['celularestudiantegeneral'].'","'.$D_Estudiante[0]['direccionresidenciaestudiantegeneral'].'","'.$D_Respuestas[$D_Valores[0]].'","'.$D_Respuestas[$D_Valores[4]].'",100,200)';
                            /*
                              --nombrecortoegresado-> en BD esta almacenado un 1 o id estudiante genral en este caso se determina que sea el id estudiantegeneral.
                              --fechadigitaegresado-> Fecha de ingreso NOW()  
                              --codigoindicadorverificacion-->200
                            */
                            /*****************************************************/
                        }else{
                            /*************Se Modifica el Registro*****************/
                            $Update_G='UPDATE  egresado
                                       SET
                                               apellidosegresado="'.$D_Estudiante[0]['apellidosestudiantegeneral'].'",
                                               nombresegresado="'.$D_Estudiante[0]['nombresestudiantegeneral'].'",
                                               telefonoresidenciaegresado="'.$D_Estudiante[0]['telefonoresidenciaestudiantegeneral'].'",
                                               telefonorecelularegresado="'.$D_Estudiante[0]['celularestudiantegeneral'].'",
                                               direccionresidenciaegresado="'.$D_Estudiante[0]['direccionresidenciaestudiantegeneral'].'",
                                               ciudadpaisresidenciaegresado="'.$D_Respuestas[$D_Valores[0]].'",
                                               emailegresado="'.$D_Respuestas[$D_Valores[4]].'"
                                               
                                       WHERE
                                               idestudiantegeneral="'.$id_EstudianteGeneral.'" AND  idegresado="'.$Egresado->fields['idegresado'].'" AND codigoestado=100';
                                               
                                    if($ModificacionEgresado=&$db->Execute($Update_G)===false){
                                        echo 'Error en el Update de Egresado...<br><br>'.$$Update_G;
                                        die;
                                    }           
                            /*****************************************************/
                        }               
                    /*****************************************/
                  }//if     
                /***********************************************************************/
                $Usuario->MoveNext();
            }//while
            
           $Instrumentos->MoveNext();        
        /*********************************************************************/
    }//while  
    function DataPreguntaRespuesta($db,$instrumento_id,$D_Valores,$Numerodocumento){
        
        
        for($i=0;$i<count($D_Valores);$i++){
            /******************************************/
              $SQl='SELECT 

                    idsiq_Ainstrumento,
                    idsiq_Ainstrumentoconfiguracion,
                    idsiq_Apregunta
                    
                    FROM 
                    
                    siq_Ainstrumento
                    
                    WHERE 
                    
                    idsiq_Ainstrumentoconfiguracion ="'.$instrumento_id.'"  
                    AND 
                    idsiq_Apregunta="'.$D_Valores[$i].'"
                    AND
                    codigoestado=100';
                    
               if($Relacion=&$db->Execute($SQl)===false){
                    echo 'Error en el SQL de la Relacion de Pregunta Instrumento...<br><br>'.$SQl;
                    die;
               }   
               
               if(!$Relacion->EOF){
                    $SQL_D='SELECT 

                            idsiq_Arespuestainstrumento,
                            idsiq_Apreguntarespuesta,
                            preg_abierta
                            
                            FROM 
                            siq_Arespuestainstrumento
                            
                            WHERE 
                            idsiq_Ainstrumentoconfiguracion="'.$instrumento_id.'"
                            AND 
                            idsiq_Apregunta="'.$D_Valores[$i].'"
                            AND 
                            cedula ="'.$Numerodocumento.'" 
                            AND
                            codigoestado=100';
                            
                   if($Respuesta=&$db->Execute($SQL_D)===false){
                        echo 'Error en el SQL de las Respuestas del Instrumento...<br><br>'.$SQL_D;
                        die;
                   }  
                   
                   if(!$Respuesta->EOF){
                        
                        $Respuesta_id = $Respuesta->fields['idsiq_Apreguntarespuesta'];
                        $preg_abierta = $Respuesta->fields['preg_abierta'];
                        /**************************************************/
                        if(!$Respuesta_id || $Respuesta_id==''){
                            $D_Result[$D_Valores[$i]] = $preg_abierta;
                        }else{
                            $D_Result[$D_Valores[$i]] = $Respuesta_id;
                        }//if
                        /**************************************************/
                   }else{
                        $D_Result[$D_Valores[$i]] = '';
                   }//if       
               }//if  
            /******************************************/
        }//for
      return $D_Result;
    }//function DataPreguntaRespuesta
?>