<?php
global $db;
	
	include ('../templates/mainjson.php');
    include ('Desercion_class.php');  
	$C_Desercion = new Desercion();
    
    for($O=1;$O<=2;$O++){
        /**************************************************************************/
      
    $CodigoPeriodo	='2015'.$O;
    
    $PeriodoAnual   = $C_Desercion->PeriodosAnuales($CodigoPeriodo);
   
    $D_Anual    = $C_Desercion->DesercionAnual($CodigoPeriodo);  
    /*echo '<pre>'; print_r($D_Anual); die;	
    die;*/
    
            
                        
    for($j=0;$j<count($C_Carrera);$j++){//for
    
      
        /********************************************************************/
      
          $SQL='SELECT 
                    
                d.id_desercion as id 
                
                FROM 
                
                desercion d 
                
                WHERE
                
                d.codigocarrera="'.$C_Carrera[$j]['codigocarrera'].'"
                AND
                d.codigoestado=100
                AND
                d.tipodesercion=1';
                
            if($Consulta=&$db->Execute($SQL)===false){
                echo 'Error en el SQl de Consulta...<br><br>'.$SQL;
                die;
            }    
          if($Consulta->EOF){
            /********************************************/
            $SQL_Insert='INSERT INTO desercion(codigocarrera,tipodesercion,entrydate)VALUES("'.$C_Carrera[$j]['codigocarrera'].'","1",NOW())';  
         
             if($Desercion=&$db->Execute($SQL_Insert)===false){
                echo 'Error en el Insert del la Desercion...<br><br>'.$SQL_Insert;
                die;
             }
         
            ##################################
            $Last_id=$db->Insert_ID();
            ##################################
            /********************************************/
          }else{
            /*********************************************/
            $Up_Sql='UPDATE desercion
                     SET    changedate=NOW()
                     WHERE  codigocarrera="'.$C_Carrera[$j]['codigocarrera'].'"  AND  tipodesercion=1  AND  codigoestado=100 AND id_desercion="'.$Consulta->fields['id'].'"';
                     
                if($Up_Desercion=&$db->Execute($Up_Sql)===false){
                    echo 'Error en el SQl Modificacion Desercion...<br><br>'.$Up_Sql;
                    die;
                }
                
            ##################################
            $Last_id=$Consulta->fields['id'];
            ##################################      
            /*********************************************/
          }//if 
        /**************************************************************/  
       
            for($i=0;$i<count($D_Anual[$C_Carrera[$j]['codigocarrera']]);$i++){//for
                /*******************************************************************/
                
                $SQLDetalle='SELECT 

                             id_detalledesercion
                            
                             FROM deserciondetalle 
                             
                             WHERE  
                             
                             id_desercion="'.$Last_id.'"
                             AND
                             codigoestado=100
                             AND
                             desercionperiodo="'.$D_Anual[$C_Carrera[$j]['codigocarrera']][$i]['t+2'].'"';
                             
                   if($Detalle=&$db->Execute($SQLDetalle)===false){
                        echo 'Error en el SQL Detalle...<br><br>'.$SQLDetalle;
                        die;
                   }  
                   
                   
                  
                      
                 if($Detalle->EOF){
                            /******************************************/
                        $SQL_InsertDetalle='INSERT INTO deserciondetalle(id_desercion,matriculados,desercion,entrydate,periodos,desercionperiodo)VALUES("'.$Last_id.'","'.$D_Anual[$C_Carrera[$j]['codigocarrera']][$i]['Total_Matriculados'].'","'.$D_Anual[$C_Carrera[$j]['codigocarrera']][$i]['Desercion_Anual'].'",NOW(),"'.$D_Anual[$C_Carrera[$j]['codigocarrera']][$i]['periodos'].'","'.$D_Anual[$C_Carrera[$j]['codigocarrera']][$i]['t+2'].'")';
                       
                      if($DetalleDesercion=&$db->Execute($SQL_InsertDetalle)===false){
                        echo 'Error en el SQl del Insert Detalle Desercion...<br><br>'.$SQL_InsertDetalle;
                        die;
                       }
                       
                        ##################################
                        $Last_Detalle=$db->Insert_ID();
                        ##################################
                            /******************************************/
                        }else{
                            /**********************************************/
                            
                                 
                            
                            /**********************************************/
                            
                            $Up_Detalle='UPDATE  deserciondetalle
                                         SET     matriculados="'.$D_Anual[$C_Carrera[$j]['codigocarrera']][$i]['Total_Matriculados'].'",
                                                 desercion="'.$D_Anual[$C_Carrera[$j]['codigocarrera']][$i]['Desercion_Anual'].'",
                                                 changedate=NOW(),
                                                 periodos="'.$D_Anual[$C_Carrera[$j]['codigocarrera']][$i]['periodos'].'",
                                                 desercionperiodo="'.$D_Anual[$C_Carrera[$j]['codigocarrera']][$i]['t+2'].'"
                                                 
                                         WHERE
                                                 id_desercion="'.$Last_id.'"
                                                 AND
                                                 codigoestado=100
                                                 AND
                                                 desercionperiodo="'.$D_Anual[$C_Carrera[$j]['codigocarrera']][$i]['t+2'].'"
                                                 AND
                                                 id_detalledesercion="'.$Detalle->fields['id_detalledesercion'].'"';
                                                    
                             if($Detalle_Mod=&$db->Execute($Up_Detalle)===false){
                                echo 'Error en el SQl Modificar Detalle Desercion...<br><br>'.$Up_Detalle;
                                die;
                             }
                             
                                ##################################
                                $Last_Detalle=$Detalle->fields['id_detalledesercion'];
                                ################################## 
                             
                             
                             /*else{
                                $SQL_InsertDetalle='INSERT INTO deserciondetalle(id_desercion,matriculados,desercion,entrydate,periodos,desercionperiodo)VALUES("'.$Last_id.'","'.$D_Anual[$C_Carrera[$j]['codigocarrera']][$i]['Total_Matriculados'].'","'.$D_Anual[$C_Carrera[$j]['codigocarrera']][$i]['Desercion_Anual'].'",NOW(),"'.$D_Anual[$C_Carrera[$j]['codigocarrera']][$i]['periodos'].'","'.$D_Anual[$C_Carrera[$j]['codigocarrera']][$i]['t+2'].'")';
                       
                                  if($DetalleDesercion=&$db->Execute($SQL_InsertDetalle)===false){
                                    echo 'Error en el SQl del Insert Detalle Desercion...<br><br>'.$SQL_InsertDetalle;
                                    die;
                                   }*/
                                   
                                ##################################
                               // $Last_Detalle=$db->Insert_ID();
                                ##################################    
                                   
                            // }
                        
                       }//if
                      
                    /****************************************************************************/
                    $C_CodigoEstudiante  = $D_Anual[$C_Carrera[$j]['codigocarrera']][$i]['Estudiante'];
                    
                    //echo '<pre>';print_r($C_CodigoEstudiante);die;
                    //echo $Num_Estudiante  = count($C_CodigoEstudiante);
                    
                    for($l=0;$l<count($C_CodigoEstudiante);$l++){
                        
                        $CodigoEstudiante   = $C_CodigoEstudiante[$l];
                        //$Semestre           = $C_CodigoEstudiante['Semestre'][$l];
                        
                        $SQL_3='SELECT * 
                                
                                FROM   
                                
                                desercionEstudiante
                                
                                WHERE
                                
                                id_detalledesercion="'.$Last_Detalle.'"
                                AND
                                codigoestudiante="'.$CodigoEstudiante.'"';
                                
                            
                            if($Existe=&$db->Execute($SQL_3)===false){
                                echo 'Error en el SQl 3...<br><br>'.$SQL_3;
                                die;
                            }     
                        
                        if($Existe->EOF){
                        
                            $InsertEstudiante='INSERT INTO desercionEstudiante(id_detalledesercion,codigoestudiante,entrydate)VALUES("'.$Last_Detalle.'","'.$CodigoEstudiante.'",NOW())';
                        
                            if($DetalleEstudiante=&$db->Execute($InsertEstudiante)===false){
                                echo 'Error en el SQl del detalle desercion estudiante...<br><br>'.$InsertEstudiante;
                                die;
                            }    
                            
                        }else{
                            
                            $UPDATE='UPDATE  desercionEstudiante
                                     
                                     SET     changedate=NOW()
                                     
                                     WHERE
                                     
                                     id_detalledesercion="'.$Last_Detalle.'"
                                AND
                                codigoestudiante="'.$CodigoEstudiante.'"';
                                
                               if($Modica=&$db->Execute($UPDATE)===false){
                                    echo 'Error en el Update...<br><br>'.$UPDATE;
                                    die;
                                }
                            
                        }//if
                        
                         
                        
                    }//for
                    
                    
                    $E_EstratoMatriculados = $D_Anual[$C_Carrera[$j]['codigocarrera']][$i]['E_Estrato'];
                    
                    $Estratos = $C_Desercion->EstratoEstudiantes($E_EstratoMatriculados,1);
                    
                    $No_Aplica_Num  = count($Estratos['No_Aplica']['id_estrato']);
                    $Uno_Num        = count($Estratos['Uno']['id_estrato']);
                    $Dos_Num        = count($Estratos['Dos']['id_estrato']);
                    $Tres_Num       = count($Estratos['Tres']['id_estrato']);
                    $Cuatro_Num     = count($Estratos['Cuatro']['id_estrato']);
                    $Cinco_Num      = count($Estratos['Cinco']['id_estrato']);
                    $Seis_Num       = count($Estratos['Seis']['id_estrato']);
                    
                    
                    
                    $SQL_Estrato='SELECT iddesercionestrato FROM desercionestrato WHERE iddetalledesercion="'.$Last_Detalle.'"';
                                
                        if($EstratoDesercion=&$db->Execute($SQL_Estrato)===false){
                            echo 'Error en el SQl del Estrado Desercion de los Matriculados...<br><br>'.$SQL_Estrato;
                            die;
                        }
                        
                    if($EstratoDesercion->EOF){
                                    
                                $SQL_NoAplica='INSERT INTO desercionestrato(iddetalledesercion,cantidad,tipo,userid,entrydate)VALUES("'.$Last_Detalle.'","'.$No_Aplica_Num.'","0","4186",NOW())';//4186
                                
                                if($IN_NoAplica=&$db->Execute($SQL_NoAplica)===false){
                                    echo 'Error en el SQL No Aplica...<br><br>'.$SQL_NoAplica;
                                    die;
                                }
                                
                                /****************************************************************/
                                
                                $SQL_Uno='INSERT INTO desercionestrato(iddetalledesercion,cantidad,tipo,userid,entrydate)VALUES("'.$Last_Detalle.'","'.$Uno_Num.'","1","4186",NOW())';//4186
                                
                                if($IN_Uno=&$db->Execute($SQL_Uno)===false){
                                    echo 'Error en el SQL Uno...<br><br>'.$SQL_Uno;
                                    die;
                                }
                                
                                /****************************************************************/
                                
                                
                                $SQL_Dos='INSERT INTO desercionestrato(iddetalledesercion,cantidad,tipo,userid,entrydate)VALUES("'.$Last_Detalle.'","'.$Dos_Num.'","2","4186",NOW())';//4186
                                
                                if($IN_Dos=&$db->Execute($SQL_Dos)===false){
                                    echo 'Error en el SQL Dos...<br><br>'.$SQL_Dos;
                                    die;
                                }
                                
                                /****************************************************************/
                                
                                $SQL_Tres='INSERT INTO desercionestrato(iddetalledesercion,cantidad,tipo,userid,entrydate)VALUES("'.$Last_Detalle.'","'.$Tres_Num.'","3","4186",NOW())';//4186
                                
                                if($IN_Tres=&$db->Execute($SQL_Tres)===false){
                                    echo 'Error en el SQL Tres...<br><br>'.$SQL_Tres;
                                    die;
                                }
                                
                                /****************************************************************/
                                
                                $SQL_Cuatro='INSERT INTO desercionestrato(iddetalledesercion,cantidad,tipo,userid,entrydate)VALUES("'.$Last_Detalle.'","'.$Cuatro_Num.'","4","4186",NOW())';//4186
                                
                                if($IN_Cuatro=&$db->Execute($SQL_Cuatro)===false){
                                    echo 'Error en el SQL Cuatro...<br><br>'.$SQL_Cuatro;
                                    die;
                                }
                                
                                /****************************************************************/
                                
                                $SQL_Cinco='INSERT INTO desercionestrato(iddetalledesercion,cantidad,tipo,userid,entrydate)VALUES("'.$Last_Detalle.'","'.$Cinco_Num.'","5","4186",NOW())';//4186
                                
                                if($IN_Cinco=&$db->Execute($SQL_Cinco)===false){
                                    echo 'Error en el SQL Cinco...<br><br>'.$SQL_Cinco;
                                    die;
                                }
                                
                                /****************************************************************/
                                
                                $SQL_Seis='INSERT INTO desercionestrato(iddetalledesercion,cantidad,tipo,userid,entrydate)VALUES("'.$Last_Detalle.'","'.$Seis_Num.'","6","4186",NOW())';//4186
                                
                                if($IN_Seis=&$db->Execute($SQL_Seis)===false){
                                    echo 'Error en el SQL Seis...<br><br>'.$SQL_Seis;
                                    die;
                                }
                                
                                /****************************************************************/
                                    
                                }else{
                                    
                                    $Update_NoAplica='UPDATE desercionestrato
                                    
                                                     SET    cantidad="'.$No_Aplica_Num.'",
                                                            changedate=NOW()
                                                            
                                                     WHERE iddetalledesercion="'.$Last_Detalle.'" AND tipo="0" AND iddesercionestrato="'.$EstratoDesercion->fields['iddesercionestrato'].'"';
                                                     
                                           if($UpdateNoAplica=&$db->Execute($Update_NoAplica)===false){
                                                echo 'Error en el SQl Update No Aplica..<br><br>'.$Update_NoAplica;
                                                die;
                                           }  
                                           
                                     /***************************************************************************/   
                                     
                                     $Update_Uno='UPDATE desercionestrato
                                    
                                                     SET    cantidad="'.$Uno_Num.'",
                                                            changedate=NOW()
                                                            
                                                     WHERE iddetalledesercion="'.$Last_Detalle.'" AND tipo="1" AND iddesercionestrato="'.$EstratoDesercion->fields['iddesercionestrato'].'"';
                                                     
                                           if($UpdateUno=&$db->Execute($Update_Uno)===false){
                                                echo 'Error en el SQl Update Uno..<br><br>'.$Update_Uno;
                                                die;
                                           }  
                                           
                                     /***************************************************************************/
                                     
                                     $Update_Dos='UPDATE desercionestrato
                                    
                                                     SET    cantidad="'.$Dos_Num.'",
                                                            changedate=NOW()
                                                            
                                                     WHERE iddetalledesercion="'.$Last_Detalle.'" AND tipo="2" AND iddesercionestrato="'.$EstratoDesercion->fields['iddesercionestrato'].'"';
                                                     
                                           if($UpdateDos=&$db->Execute($Update_Dos)===false){
                                                echo 'Error en el SQl Update Dos..<br><br>'.$Update_Dos;
                                                die;
                                           }  
                                           
                                     /***************************************************************************/
                                     
                                      $Update_Tres='UPDATE desercionestrato
                                    
                                                     SET    cantidad="'.$Tres_Num.'",
                                                            changedate=NOW()
                                                            
                                                     WHERE iddetalledesercion="'.$Last_Detalle.'" AND tipo="3" AND iddesercionestrato="'.$EstratoDesercion->fields['iddesercionestrato'].'"';
                                                     
                                           if($UpdateTres=&$db->Execute($Update_Tres)===false){
                                                echo 'Error en el SQl Update Tres..<br><br>'.$Update_Tres;
                                                die;
                                           }  
                                           
                                     /***************************************************************************/ 
                                     
                                     $Update_Cuatro='UPDATE desercionestrato
                                    
                                                     SET    cantidad="'.$Cuatro_Num.'",
                                                            changedate=NOW()
                                                            
                                                     WHERE iddetalledesercion="'.$Last_Detalle.'" AND tipo="4" AND iddesercionestrato="'.$EstratoDesercion->fields['iddesercionestrato'].'"';
                                                     
                                           if($UpdateCuatro=&$db->Execute($Update_Cuatro)===false){
                                                echo 'Error en el SQl Update Cuatro..<br><br>'.$Update_Cuatro;
                                                die;
                                           }  
                                           
                                     /***************************************************************************/  
                                     
                                     $Update_Cinco='UPDATE desercionestrato
                                    
                                                     SET    cantidad="'.$Cinco_Num.'",
                                                            changedate=NOW()
                                                            
                                                     WHERE iddetalledesercion="'.$Last_Detalle.'" AND tipo="5" AND iddesercionestrato="'.$EstratoDesercion->fields['iddesercionestrato'].'"';
                                                     
                                           if($UpdateCinco=&$db->Execute($Update_Cinco)===false){
                                                echo 'Error en el SQl Update Cinco..<br><br>'.$Update_Cinco;
                                                die;
                                           }  
                                           
                                     /***************************************************************************/   
                                     
                                     $Update_Seis='UPDATE desercionestrato
                                    
                                                     SET    cantidad="'.$Seis_Num.'",
                                                            changedate=NOW()
                                                            
                                                     WHERE iddetalledesercion="'.$Last_Detalle.'" AND tipo="6" AND iddesercionestrato="'.$EstratoDesercion->fields['iddesercionestrato'].'"';
                                                     
                                           if($UpdateSeis=&$db->Execute($Update_Seis)===false){
                                                echo 'Error en el SQl Update Seis..<br><br>'.$Update_Seis;
                                                die;
                                           }  
                                           
                                     /***************************************************************************/   
                                                     
                                    
                                }/*fin del if*/    
                    
                    //echo '<pre>';print_r($Estratos);die;
                    
                    $D_Anual[$C_Carrera[$j]['codigocarrera']][$i]['periodos'];
                    $D_Anual[$C_Carrera[$j]['codigocarrera']][$i]['Total_Matriculados'];
                    $D_Anual[$C_Carrera[$j]['codigocarrera']][$i]['Desercion_Anual'];
                    $D_Anual[$C_Carrera[$j]['codigocarrera']][$i]['Porcentaje_Anual'];
                    $D_Anual[$C_Carrera[$j]['codigocarrera']][$i]['Estudiante'];
                    $D_Anual[$C_Carrera[$j]['codigocarrera']][$i]['E_Estrato'];
                    
                    /****************************************************************************/
               
                /*******************************************************************/
            }//for
            die;
        /********************************************************************/
    }//for
  /**************************************************************************/
 }//for   
?>
             