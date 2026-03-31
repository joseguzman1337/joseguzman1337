<?php
global $db;
	
	include ('../templates/mainjson.php');
    include ('Desercion_class.php');  $C_Desercion = new Desercion();
    
    $CodigoPeriodo	='20151';
    
    $Periodo_Actual     = $C_Desercion->Periodo('Actual','','');
        
    $C_Periodo          = $C_Desercion->Periodo('Cadena',$CodigoPeriodo,$Periodo_Actual);
    
    
    $Carrera   = $C_Desercion->Carreras();
    $cont_Carrera = (int) count($Carrera);
    
    for($Q=0;$Q<1;$Q++){
      
      $Periodo = $C_Periodo[$Q]['codigoperiodo'];
      //$Periodo  = 20081;
       for($i=0;$i<count($cont_Carrera);$i++){
        
          $Carrera_id     = $Carrera[$i]['codigocarrera'];
          
          //$Carrera_id  = 119;
          /********************************************************************/
          $SQL='SELECT 

                id_desercion,
                codigocarrera
                
                FROM 
                
                desercion
                
                WHERE
                
                tipodesercion=2
                AND
                codigoestado=100
                AND
                codigocarrera="'.$Carrera_id.'"';
                
                if($DesercionCarrera=&$db->Execute($SQL)===false){
                    echo 'Error en el SQl de la Desercion Carrera...<br><br>'.$SQL;
                    die;
                }
                
           if(!$DesercionCarrera->EOF){
            
                //Si existe ya un Registro de la carerra
                
                ##################################
                $Last_id = $DesercionCarrera->fields['id_desercion'];
                ##################################          
            
           }else{
            
            //Tipo DOS (2) para los que son desercion Costo
            
                $InsertCabeza='INSERT INTO desercion(codigocarrera,tipodesercion,entrydate)VALUES("'.$Carrera_id.'","2",NOW())';
                
               if($DesercionCabeza=&$db->Execute($InsertCabeza)===false){
                    echo 'Error en el SQl del Inser de la Cabeza..<br><br>'.$InsertCabeza;
                    die;
                }
            
                ##################################
                $Last_id=$db->Insert_ID();
                ##################################
                
           }// if $DesercionCarrera->EOF    
          /********************************************************************/
          
          $DesercionCadena = $C_Desercion->DesercionCosto($Carrera_id,$Periodo);
            
          /*********************************************************************/
          
          //echo '<pre>';print_r($DesercionCadena);die;  
          
          for($n=0;$n<count($DesercionCadena);$n++){
          
              $SQL_Detalle='SELECT 
    
                            id_cohortecosto
                            
                            FROM 
                            
                            DesercionCosto
                            
                            WHERE
                            
                            id_desercion="'.$Last_id.'"
                            AND
                            periododesercion="'.$Periodo.'"
                            AND
                            codigoestudiante="'.$DesercionCadena[$n]['CodigoEstudiante'].'"';
                            
                     if($Detalle=&$db->Execute($SQL_Detalle)===false){
                        echo 'Error en el SQL del detalle..<br><br>'.$SQL_Detalle;
                        die;
                     }       
              
              
                if(!$Detalle->EOF){
                    
                    $id_Detalle  = $Detalle->fields['id_cohortecosto'];
                    
                    $UPDATE='UPDATE  DesercionCosto
                            
                             SET     costo="'.$DesercionCadena[$n]['Valor'].'",
                                     chagedate=NOW()
                             
                             WHERE
                                    id_cohortecosto="'.$id_Detalle.'"
                                    AND
                                    periododesercion="'.$Periodo.'"
                                    AND
                                    codigoestudiante="'.$DesercionCadena[$n]['CodigoEstudiante'].'"';
                                    
                          if($UpdateDetalle=&$db->Execute($UPDATE)===false){
                             echo 'Error en el SQL del Update...<br><br>'.$UPDATE;
                             die;
                          }       
                    
                }else{
                    
                    $InsertDetalle='INSERT INTO DesercionCosto(id_desercion,codigoestudiante,periododesercion,periodoingreso,semestre,costo,entrydate)VALUES("'.$Last_id.'","'.$DesercionCadena[$n]['CodigoEstudiante'].'","'.$Periodo.'","'.$DesercionCadena[$n]['inicio'].'","'.$DesercionCadena[$n]['Semestre'].'","'.$DesercionCadena[$n]['Valor'].'",NOW())';
                    
                    if($InsertCosto=&$db->Execute($InsertDetalle)===false){
                        echo 'Error en el SQl del Insert de los Costos..<br><br>'.$InsertDetalle;
                        die;
                    }
                    
                }//if $Detalle->EOF
          /*********************************************************************/
            }//for Datos
            
       }//For Carreras
        
   }//for Periodos
    
  
    
    
?>