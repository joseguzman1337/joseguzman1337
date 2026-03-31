<?php  
	global $db;
	
	include_once('../templates/mainjson.php');
    include_once('Desercion_class.php');  $C_Desercion = new Desercion();
    
    $CodigoPeriodo	='20131';
    
    $Periodo_Actual=$C_Desercion->Periodo('Actual','','');
        
    $C_Periodo  = $C_Desercion->Periodo('Cadena',$CodigoPeriodo,$Periodo_Actual); 
     
    $P_num= count($C_Periodo);
    
    $C_Datos=$C_Desercion->DesercionSemestral($CodigoPeriodo,'Programas');
    
    $C_Total=$C_Desercion->DesercionSemestral($CodigoPeriodo,'Institucional');
    
    $C_Carrera=$C_Desercion->Carreras();
       
    $Suma_TotalMatriculados=0;
    $Suma_ToralDesercion=0;
    
    //echo '<pre>';print_r($C_Periodo);
    
    for($j=0;$j<count($C_Carrera);$j++){//for Carrera
       /************************************************************/
        for($x=0;$x<count($C_Datos);$x++){//For de Datos
            /*******************************************************/
            for($Q=0;$Q<$P_num;$Q++){//For de Periodos
                /***************************************************/
                if($C_Datos[$x][$C_Carrera[$j]['codigocarrera']][$Q]['Periodo']){/*Si tiene Periodo*/
                    /***********************************************/
                    if($C_Datos[$x][$C_Carrera[$j]['codigocarrera']][$Q]['Periodo']==$C_Periodo[$Q]['codigoperiodo']){//if de los periodods son iguales
                        /*******************************************/
                         $Total_Matriculados   = $C_Datos[$x][$C_Carrera[$j]['codigocarrera']][$Q]['TotalMatriculados'];
                         $C_CodigoPeriodo      = $C_Periodo[$Q]['codigoperiodo'];
                         $D_Desercion          = $C_Datos[$x][$C_Carrera[$j]['codigocarrera']][$Q]['Desercion'];
                         $Num_Estudiante       = $C_Datos[$x][$C_Carrera[$j]['codigocarrera']][$Q]['Estudiantes'];
                         $Num_E_Matriculados   = $C_Datos[$x][$C_Carrera[$j]['codigocarrera']][$Q]['E_Matriculados'];
                         
                         $Estratos = $C_Desercion->EstratoEstudiantes($Num_E_Matriculados,1);
                         
                         $Resultado = ConsultaBasica($db,$C_Carrera[$j]['codigocarrera'],'llamado en la linea 36');
                                 
                         if($Resultado['val']==true){
                            
                            $Last_id = $Resultado['id'];
                            UpdateDesercion($db,$C_Carrera[$j]['codigocarrera'],$Last_id,'LLamado en la linea 39');
                            
                            UpdateDesercionDetalle($db,$Last_id,$C_CodigoPeriodo,$Total_Matriculados,$D_Desercion,'Llamado en la linea 48');
                            
                            $DataDetalle = ConsultaDetalle($db,$Last_id,$C_CodigoPeriodo,'Llamado en la Linea 50');
                            
                            if($DataDetalle['val']==true){
                                $Last_idDetalle = $DataDetalle['id'];
                            }else{
                                $Last_idDetalle = InsertDetalleDesrcion($db,$Last_id,$C_CodigoPeriodo,$Total_Matriculados,$D_Desercion,'LLamada en la linea 58');
                            }
                            
                            UpdateDesercionEstudiante($db,$Last_idDetalle,'Llamado en la linea 61');
                            
                            for($E=0;$E<count($Num_Estudiante);$E++){
                                /********************************************/
                                $Num  = $Num_Estudiante[$E];
                                $Data = ConsultaDesercionEstudiante($db,$Last_idDetalle,$Num,'LLamado en la linea 66');
                                
                                if($Data['val']==true){
                                    UpdateDesercionEstudianteActivo($db,$Last_idDetalle,$Data['id'],$Num,'Llamado en la linea 69');
                                }else{
                                    InsertDesercionEstudiante($db,$Last_idDetalle,$Num,'LLamado en la linea 71');
                                }
                                /********************************************/
                            }//for
                                
                            $DataEstrato = ConsultaDesercionEstrato($db,$Last_idDetalle,'LLamado en la linea 76');
                                
                            for($M=0;$M<count($Num_E_Matriculados);$M++){
                                /***********************************************/
                                
                                $No_Aplica_Num  = count($Estratos['No_Aplica']['id_estrato']);
                                $Uno_Num        = count($Estratos['Uno']['id_estrato']);
                                $Dos_Num        = count($Estratos['Dos']['id_estrato']);
                                $Tres_Num       = count($Estratos['Tres']['id_estrato']);
                                $Cuatro_Num     = count($Estratos['Cuatro']['id_estrato']);
                                $Cinco_Num      = count($Estratos['Cinco']['id_estrato']);
                                $Seis_Num       = count($Estratos['Seis']['id_estrato']);
                                
                                if($DataEstrato['val']==true){
                                    UpdateDesercionEstrato($db,$Last_idDetalle,$No_Aplica_Num,$DataEstrato['id'],0,'LLamado En la line 90 Estrato Cero');
                                    UpdateDesercionEstrato($db,$Last_idDetalle,$Uno_Num,$DataEstrato['id'],1,'LLamado En la line 91 Estrato Uno');
                                    UpdateDesercionEstrato($db,$Last_idDetalle,$Dos_Num,$DataEstrato['id'],2,'LLamado En la line 92 Estrato Dos');
                                    UpdateDesercionEstrato($db,$Last_idDetalle,$Tres_Num,$DataEstrato['id'],3,'LLamado En la line 93 Estrato Tres');
                                    UpdateDesercionEstrato($db,$Last_idDetalle,$Cuatro_Num,$DataEstrato['id'],4,'LLamado En la line 94 Estrato Cuatro');
                                    UpdateDesercionEstrato($db,$Last_idDetalle,$Cinco_Num,$DataEstrato['id'],5,'LLamado En la line 95 Estrato Cinco');
                                    UpdateDesercionEstrato($db,$Last_idDetalle,$Seis_Num,$DataEstrato['id'],6,'LLamado En la line 96 Estrato Seis');
                                }else{
                                    InsertDesercionEstratos($db,$Last_idDetalle,$No_Aplica_Num,0,'Llamado en la linea 98 Estrato Cero');
                                    InsertDesercionEstratos($db,$Last_idDetalle,$Uno_Num,1,'Llamado en la linea 99 Estrato Uno');
                                    InsertDesercionEstratos($db,$Last_idDetalle,$Dos_Num,2,'Llamado en la linea 100 Estrato Dos');
                                    InsertDesercionEstratos($db,$Last_idDetalle,$Tres_Num,3,'Llamado en la linea 101 Estrato Tres');
                                    InsertDesercionEstratos($db,$Last_idDetalle,$Cuatro_Num,4,'Llamado en la linea 102 Estrato Cuatro');
                                    InsertDesercionEstratos($db,$Last_idDetalle,$Cinco_Num,5,'Llamado en la linea 103 Estrato Cinco');
                                    InsertDesercionEstratos($db,$Last_idDetalle,$Seis_Num,6,'Llamado en la linea 104 Estrato Seis');
                                }
                                /***********************************************/
                            }//for
                         }else{
                            $Last_id = InsertDesercion($db,$C_Carrera[$j]['codigocarrera'],'LLamado en la linea 103');
                            
                                 $Last_idDetalle = InsertDetalleDesrcion($db,$Last_id,$C_CodigoPeriodo,$Total_Matriculados,$D_Desercion,'LLamado en la linea 111');
                                 
                                 for($E=0;$E<count($Num_Estudiante);$E++){
                                    $Num = $Num_Estudiante[$E];
                                    InsertDesercionEstudiante($db,$Last_idDetalle,$Num,'LLamado En el For  linea 115');  
                                 }/*for*/
                                 
                                  for($M=0;$M<count($Num_E_Matriculados);$M++){
                                    
                                    $No_Aplica_Num  = count($Estratos['No_Aplica']['id_estrato']);
                                    $Uno_Num        = count($Estratos['Uno']['id_estrato']);
                                    $Dos_Num        = count($Estratos['Dos']['id_estrato']);
                                    $Tres_Num       = count($Estratos['Tres']['id_estrato']);
                                    $Cuatro_Num     = count($Estratos['Cuatro']['id_estrato']);
                                    $Cinco_Num      = count($Estratos['Cinco']['id_estrato']);
                                    $Seis_Num       = count($Estratos['Seis']['id_estrato']);
                                    
                                    InsertDesercionEstratos($db,$Last_idDetalle,$No_Aplica_Num,0,'Llamado en la linea 128 Estrato Cero');
                                    InsertDesercionEstratos($db,$Last_idDetalle,$Uno_Num,1,'Llamado en la linea 129 Estrato Uno');
                                    InsertDesercionEstratos($db,$Last_idDetalle,$Dos_Num,2,'Llamado en la linea 130 Estrato Dos');
                                    InsertDesercionEstratos($db,$Last_idDetalle,$Tres_Num,3,'Llamado en la linea 131 Estrato Tres');
                                    InsertDesercionEstratos($db,$Last_idDetalle,$Cuatro_Num,4,'Llamado en la linea 132 Estrato Cuatro');
                                    InsertDesercionEstratos($db,$Last_idDetalle,$Cinco_Num,5,'Llamado en la linea 133 Estrato Cinco');
                                    InsertDesercionEstratos($db,$Last_idDetalle,$Seis_Num,6,'Llamado en la linea 134 Estrato Seis');
                                  }//for
                                /***************************************************/
                            
                         }//if
                         /*******************************************/
                    }//if de los periodods son iguales
                    /***********************************************/
                }//if /*Si tiene Periodo*/
               /****************************************************/
             }//for de Periodos 
           /********************************************************/ 
          }//for de Datos
        /***********************************************************/
      }//for Carrera
/****************************************************************************************************************************************************************************/
function ConsultaBasica($db,$Carrera,$Msg){
    /***************************************************************/
      $SQL='SELECT 
                    
            d.id_desercion as id 
            
            FROM 
            
            desercion d 
            
            WHERE
            
            d.codigocarrera="'.$Carrera.'"
            AND
            d.codigoestado=100
            AND
            d.tipodesercion=0';
            
     if($Consulta=&$db->Execute($SQL)===false){
        echo 'Error en el SQl de Consulta line ....'.$Msg.'<br><br>'.$SQL;
        die;
    }      
    
    $Resultado = array();
    
    if(!$Consulta->EOF){
        $Resultado['val'] = true;
        $Resultado['id']  = $Consulta->fields['id'];
    }else{
        $Resultado['val'] = false;
    }     
    
    return $Resultado;
    /***************************************************************/
}//function ConsultaBasica
function InsertDesercion($db,$Carrera,$Msg){
    /***************************************************************/
     $SQL_Insert='INSERT INTO desercion(codigocarrera,tipodesercion,entrydate)VALUES("'.$Carrera.'","0",NOW())';  
                         
     if($Desercion=&$db->Execute($SQL_Insert)===false){
        echo 'Error en el Insert del la Desercion...line..'.$Msg.'<br><br>'.$SQL_Insert;
        die;
     }
 
    ##################################
    $Last_id=$db->Insert_ID();
    ##################################
    
    return $Last_id;
   /***************************************************************/
}//function InsertDesercion
function UpdateDesercion($db,$Carrera,$id,$Msg){
    /***************************************************************/
    $Up_Sql='UPDATE desercion
             SET    changedate=NOW()
             WHERE  codigocarrera="'.$Carrera.'"  AND  tipodesercion=0  AND  codigoestado=100 AND id_desercion="'.$id.'"';
    
    
           
        if($Up_Desercion=&$db->Execute($Up_Sql)===false){
            echo 'Error en el SQl Modificacion Desercion...'.$Msg.'<br><br>'.$Up_Sql;
            die;
        }  
   /***************************************************************/
}//function UpdateDesercion
function InsertDetalleDesrcion($db,$Last_id,$codigoperiodo,$TotalMatriculados,$Desercion,$Msg){
    /***************************************************************/
    $SQL_InsertDetalle='INSERT INTO deserciondetalle(id_desercion,codigoperiodo,matriculados,desercion,entrydate)VALUES("'.$Last_id.'","'.$codigoperiodo.'","'.$TotalMatriculados.'","'.$Desercion.'",NOW())';
                               
   if($DetalleDesercion=&$db->Execute($SQL_InsertDetalle)===false){
    echo 'Error en el SQl del Insert Detalle Desercion...'.$Msg.'<br><br>'.$SQL_InsertDetalle;
    die;
   }
 
    ##################################
    $Last_idDetalle=$db->Insert_ID();
    ##################################
    
    return $Last_idDetalle;
    /***************************************************************/
}//function InsertDetalleDesrcion
function InsertDesercionEstudiante($db,$Last_idDetalle,$Num,$Msg){
    /***************************************************************/
    $Insert_Estudiante='INSERT INTO desercionEstudiante(id_detalledesercion,codigoestudiante,entrydate)VALUES("'.$Last_idDetalle.'","'.$Num.'",NOW())';
                                    
    if($InsertEstudiante=&$db->Execute($Insert_Estudiante)===false){
        echo 'Error en el SQL del Insert Estudiante...'.$Msg.'<br><br>'.$Insert_Estudiante;
        die;
    }
    /***************************************************************/
}//function InsertDesercionEstudiante
function InsertDesercionEstratos($db,$Last_idDetalle,$Valor,$Estrato,$Msg){
    /***************************************************************/
    $SQL='INSERT INTO desercionestrato(iddetalledesercion,cantidad,tipo,userid,entrydate)VALUES("'.$Last_idDetalle.'","'.$Valor.'","'.$Estrato.'","4186",NOW())';//4186
                                
    if($Estratos=&$db->Execute($SQL)===false){
        echo 'Error en el SQL Estratos...'.$Msg.'<br><br>'.$SQL;
        die;
    }
    /***************************************************************/
}//function InsertDesercionEstratos
function UpdateDesercionDetalle($db,$Last_id,$codigoperiodo,$TotalMatriculados,$Desercion,$Msg){
    /***************************************************************/
    $Up_Detalle='UPDATE  deserciondetalle
                 SET     matriculados="'.$TotalMatriculados.'",
                         desercion="'.$Desercion.'",
                         changedate=NOW()
                         
                 WHERE
                         id_desercion="'.$Last_id.'"
                         AND
                         codigoperiodo="'.$codigoperiodo.'"
                         AND
                         codigoestado=100';
                         
     if($Detalle_Mod=&$db->Execute($Up_Detalle)===false){
        echo 'Error en el SQl Modificar Detalle Desercion...'.$Msg.'<br><br>'.$Up_Detalle;
        die;
       }
    /***************************************************************/
}//function UpdateDesercionDetalle
function ConsultaDetalle($db,$Last_id,$codigoperiodo,$Msg){
    /***************************************************************/
   $SQL_Detalle='SELECT id_detalledesercion 
                            
                   FROM  deserciondetalle  
                    
                   WHERE
                         id_desercion="'.$Last_id.'"
                         AND
                         codigoperiodo="'.$codigoperiodo.'"
                         AND
                         codigoestado=100';
                         
                         
            if($DetalleSelect=&$db->Execute($SQL_Detalle)===false){
                echo 'Error en el SQL Del Detalle...'.$Msg.'<br><br>'.$SQL_Detalle;
                die;
            }             
     
  $Resultado = array();
    
    if(!$DetalleSelect->EOF){
        $Resultado['val']  = true;
        $Resultado['id']   = $DetalleSelect->fields['id_detalledesercion'];;
    }else{
        $Resultado['val']  = false;
    }
      
    return $Resultado;
    /***************************************************************/
}//function ConsultaDetalle
function UpdateDesercionEstudiante($db,$Last_idDetalle,$Msg){
    /***************************************************************/
    $Update_Estudiante='UPDATE desercionEstudiante
                        SET  codigoestado=200
                        WHERE 
                        id_detalledesercion="'.$Last_idDetalle.'"';
          
                                
      if($ModifarEstado=&$db->Execute($Update_Estudiante)===false){
            echo 'Error en el SQL de Moficar Fecha...'.$Msg.'<br><br>'.$$Update_Estudiante;
            die;
      } 
    /***************************************************************/                      
}//function UpdateDesercionEstudiante
function ConsultaDesercionEstudiante($db,$Last_idDetalle,$Num,$Msg){
   /***************************************************************/
    $SQL_Estudiante='SELECT id_desercionestudiante FROM desercionEstudiante WHERE  id_detalledesercion="'.$Last_idDetalle.'" AND codigoestudiante="'.$Num.'"';
                                
        if($E_Estudiante=&$db->Execute($SQL_Estudiante)===false){
            echo 'Error en el SQL de Los Estudiantes...'.$Msg.'<br><br>'.$SQL_Estudiante;
            die;
        }
        
   $Resultado = array();
   
   if(!$E_Estudiante->EOF){
        $Resultado['val']  = true;
        $Resultado['id']   = $E_Estudiante->fields['id_desercionestudiante'];
   }else{
        $Resultado['val']  = false;
   } 
   
   return $Resultado;
    /***************************************************************/    
}//function ConsultaDesercionEstudiante
function UpdateDesercionEstudianteActivo($db,$Last_idDetalle,$DesercionEstudiante_id,$Num,$Msg){
    /***************************************************************/
    $Update_Estudiante='UPDATE desercionEstudiante
                        SET  changedate=NOW() , codigoestado=100
                        WHERE id_desercionestudiante="'.$DesercionEstudiante_id.'"
                        AND
                        id_detalledesercion="'.$Last_idDetalle.'" AND codigoestudiante="'.$Num.'"';
  
                        
              if($ModifarFecha=&$db->Execute($Update_Estudiante)===false){
                    echo 'Error en el SQL de Moficar Fecha...'.$Msg.'<br><br>'.$$Update_Estudiante;
                    die;
              }
  /***************************************************************/            
}//function UpdateDesercionEstudianteActivo
function ConsultaDesercionEstrato($db,$Last_idDetalle,$Msg){
    /***************************************************************/
     $SQL_Estrato='SELECT iddesercionestrato FROM desercionestrato WHERE iddetalledesercion="'.$Last_idDetalle.'"';
                                
        if($EstratoDesercion=&$db->Execute($SQL_Estrato)===false){
            echo 'Error en el SQl del Estrado Desercion de los Matriculados...'.$Msg.'<br><br>'.$SQL_Estrato;
            die;
        }
        
     $Resultado = array();
     
     if(!$EstratoDesercion->EOF){
        $Resultado['val']   = true;
        $Resultado['id']    = $EstratoDesercion->fields['iddesercionestrato'];
     }else{
        $Resultado['val']   = false;
     }   
     
     return $Resultado;
   /***************************************************************/     
}//function ConsultaDesercionEstrato
function UpdateDesercionEstrato($db,$Last_idDetalle,$Valor,$EstratoDesercion_id,$Estrato,$Msg){
   /***************************************************************/  
       $SQL='UPDATE desercionestrato
                            
             SET    cantidad="'.$Valor.'",
                    changedate=NOW()
                    
             WHERE iddetalledesercion="'.$Last_idDetalle.'" AND tipo="'.$Estrato.'" AND iddesercionestrato="'.$EstratoDesercion_id.'"';
                     
           if($UpdateNoAplica=&$db->Execute($SQL)===false){
                echo 'Error en el SQl Estrato...'.$Msg.'<br><br>'.$SQL;
                die;
           }
   /***************************************************************/         
}//function UpdateDesercionEstrato
?>