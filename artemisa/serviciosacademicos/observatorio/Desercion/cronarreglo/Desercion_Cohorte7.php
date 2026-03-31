<?php

include ('../Desercion_class.php');  $C_Desercion = new Desercion();
include_once('../../../consulta/estadisticas/matriculasnew/funciones/obtener_datos.php');
global $db;
MainJson();

//$CodigoPeriodo_ini  = '20082';

$Periodo_Actual=$C_Desercion->Periodo('Actual','','');
        
$C_Periodo  = $C_Desercion->Periodo('Cadena','20161',$Periodo_Actual);
$D_CohorteEstudiantes = array(); 

$count_C_Periodo = (int) count($C_Periodo);

for($p=0;$p<$count_C_Periodo;$p++){
    if($p<1){echo 'ejecutado ---- ';}else{die;}
    $CodigoPeriodo_ini   = $C_Periodo[$p]['codigoperiodo'];
    
    $D_Periodos = CortesDinamicas($CodigoPeriodo_ini);
    
    $C_Carrera = $C_Desercion->Carreras();
    $cont_C_Carrera = (int) count($C_Carrera);
    for($C=0;$C<$cont_C_Carrera;$C++){
    //for($C=0;$C<5;$C++){
        
        $Carrera_id     = $C_Carrera[$C]['codigocarrera'];
        
        /**********************************************************************/
        
              $SQL='SELECT 
                            
                    d.id_desercion as id 
                    
                    FROM 
                    
                    desercion d 
                    
                    WHERE
                    
                    d.codigocarrera="'.$Carrera_id.'"
                    AND
                    d.codigoestado=100
                    AND
                    d.tipodesercion=3';
                    
              if($Consulta=&$db->Execute($SQL)===false){
                    echo 'Error en el SQl de Consulta...<br><br>'.$SQL;
                    die;
                }   
        
        
        if($Consulta->EOF){
                /********************************************/
                $SQL_Insert='INSERT INTO desercion(codigocarrera,tipodesercion,entrydate)VALUES("'.$Carrera_id.'","3",NOW())';  
             
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
                         WHERE  codigocarrera="'.$Carrera_id.'"  AND  tipodesercion=3  AND  codigoestado=100 AND id_desercion="'.$Consulta->fields['id'].'"';
                         
                    if($Up_Desercion=&$db->Execute($Up_Sql)===false){
                        echo 'Error en el SQl Modificacion Desercion...<br><br>'.$Up_Sql;
                        die;
                    }
                    
                ##################################
                $Last_id=$Consulta->fields['id'];
                ##################################      
                /*********************************************/
              }//if  
        
        /**********************************************************************/
        
        for($D=0;$D<count($D_Periodos);$D++){
            
            $PeriodoDinamico    =  $D_Periodos[$D];
            
            $Continua = 0;
            
            if($PeriodoDinamico==$CodigoPeriodo_ini){
                
                //echo '<br>Periodos Iniciales-->'.$PeriodoDinamico;
                
                    $D_estadisticaInicial   = new obtener_datos_matriculas($db,$PeriodoDinamico);
                    $D_CohorteInical        = $D_estadisticaInicial->obtener_datos_estudiantes_matriculados_nuevos($Carrera_id,'arreglo');
                
             } else if($PeriodoDinamico<=$Periodo_Actual){
               
               //echo '<br><br>Periodo Siguinte --'.$PeriodoDinamico.' MAs no mayor al actual->'.$Periodo_Actual;
                    $Continua = 1;
                    $D_estadistica   = new obtener_datos_matriculas($db,$PeriodoDinamico);
                    $D_SigCohorte    = $D_estadistica->obtener_datos_estudiantes_matriculados_antiguos_tipoestudiante($Carrera_id,20,'arreglo');
                    $D_Desercion     = $D_estadistica->obtener_datos_estudiantes_desercion($Carrera_id,'arreglo');
                    
             }
            
            for($j=0;$j<count($D_CohorteInical);$j++){
                    /*****************************Datos Estudiantes que inician cohorte****************************/
                     $CodigoEstudiante     = $D_CohorteInical[$j]['codigoestudiante'];
                     
                    if($PeriodoDinamico==$CodigoPeriodo_ini){
                        
                        //echo '<br>Periodos Iniciales  2-->'.$PeriodoDinamico;
                        
                        $D_CohorteEstudiantes[$CodigoPeriodo_ini][$Carrera_id][$PeriodoDinamico]['InicioCohorte'][]=$CodigoEstudiante;
                        /************************************************************************************************************/
                        
                          $SQL='SELECT 

                                id_DesercionChohorte  as id
                                
                                FROM 
                                
                                DesercionChohorte
                                
                                WHERE
                                
                                codigoperiodo="'.$PeriodoDinamico.'"
                                AND
                                id_desercion="'.$Last_id.'"
                                AND
                                codigoestudiante="'.$CodigoEstudiante.'"
                                AND
                                codigoestado=100';
                                
                                if($CohoreExisteNew=&$db->Execute($SQL)===false){
                                    echo 'Error en el SQL de Si Existe la Cohorte...<br>'.$SQL;
                                    die;
                                }
                        
                        if(!$CohoreExisteNew->EOF){
                            
                            $SQL_Update='UPDATE DesercionChohorte
                                         SET    chagedate=NOW(),
                                                nuevo="1"
                                         WHERE  
                                                codigoperiodo="'.$PeriodoDinamico.'"
                                                AND
                                                id_desercion="'.$Last_id.'"
                                                AND
                                                codigoestudiante="'.$CodigoEstudiante.'"
                                                AND
                                                codigoestado=100
                                                AND
                                                id_DesercionChohorte="'.$CohoreExisteNew->fields['id'].'"';
                                                
                                    if($ModificaNew=&$db->Execute($SQL_Update)===false){
                                        echo 'Error en el SQl de Modificar Los Inicios de la Cohorte...<br>'.$SQL_Update;
                                        die;
                                       }    
                            
                         }else {
                            
                            $SQL_CohorteNew='INSERT INTO DesercionChohorte(id_desercion,codigoperiodo,codigoestudiante,entrydate,nuevo)VALUES("'.$Last_id.'","'.$PeriodoDinamico.'","'.$CodigoEstudiante.'",NOW(),"1")';
                        
                             if($insertCohorteNew=&$db->Execute($SQL_CohorteNew)===false){
                                    echo 'Error en el SQl de La Cohorte New ..<br><br>'.$SQL_CohorteNew;
                                    die;
                                }
                            
                         }//$CohoreExisteNew->EOF    
                        
                        /************************************************************************************************************/
                     }//if D==0
                     
                     if($Continua==1){
                        
                        for($Q=0;$Q<count($D_SigCohorte);$Q++){
                        /***********************Datos De los siguinetes periodos*********************************/
                        
                        if($CodigoEstudiante==$D_SigCohorte[$Q]['codigoestudiante']){
                            
                            //echo '<br><br>Periodo_Sig_1->'.$PeriodoDinamico;
                            
                            $D_CohorteEstudiantes[$CodigoPeriodo_ini][$Carrera_id][$PeriodoDinamico]['ContinuanCohorte'][]=$CodigoEstudiante;
                            
                            /****************************************************************************************/
                            
                            $SQL='SELECT 

                                        id_DesercionChohorte  as id
                                        
                                        FROM 
                                        
                                        DesercionChohorte
                                        
                                        WHERE
                                        
                                        codigoperiodo="'.$PeriodoDinamico.'"
                                        AND
                                        id_desercion="'.$Last_id.'"
                                        AND
                                        codigoestudiante="'.$CodigoEstudiante.'"
                                        AND
                                        codigoestado=100';
                                        
                                       if($CohoreExisteSig=&$db->Execute($SQL)===false){
                                            echo 'Error en el SQL de Si Existe la Cohorte...<br>'.$SQL;
                                            die;
                                        }
                                        
                                 /****************************************************************************************/       
                                
                                if(!$CohoreExisteSig->EOF){
                                    
                                    //echo '<br><br>Periodo_Sig_2->'.$PeriodoDinamico;
                            
                                    $SQL_Update='UPDATE DesercionChohorte
                                   
                                                 SET    chagedate=NOW()
                                                 
                                                 WHERE  
                                                        codigoperiodo="'.$PeriodoDinamico.'"
                                                        AND
                                                        id_desercion="'.$Last_id.'"
                                                        AND
                                                        codigoestudiante="'.$CodigoEstudiante.'"
                                                        AND
                                                        codigoestado=100
                                                        AND
                                                        id_DesercionChohorte="'.$CohoreExisteSig->fields['id'].'"';
                                                        
                                             if($ModificaSig=&$db->Execute($SQL_Update)===false){
                                                echo 'Error en el SQl de Modificar Los Inicios de la Cohorte...<br>'.$SQL_Update;
                                                die;
                                               }      
                            
                                 }else{
                                    
                                   // echo '<br><br>Periodo_Sig_3->'.$PeriodoDinamico;
                                    
                                    $SQL_CohorteSig='INSERT INTO DesercionChohorte(id_desercion,codigoperiodo,codigoestudiante,entrydate)VALUES("'.$Last_id.'","'.$PeriodoDinamico.'","'.$CodigoEstudiante.'",NOW())';
                                 
                                    if($insertCohorteSig=&$db->Execute($SQL_CohorteSig)===false){
                                            echo 'Error en el SQl de La Cohorte Siquinte ..<br><br>'.$SQL_CohorteSig;
                                            die;
                                        }
                                   
                                 }//$CohoreExisteSig->EOF
                            
                            /****************************************************************************************/
                        }//if Siguinte Corhorte
                        
                        /****************************************************************************************/   
                     } //For Matriculados Siguintes periodos  
                     
                        for($l=0;$l<count($D_Desercion);$l++){
                        /*************************Desercion *************************************/
                       
                        if($CodigoEstudiante==$D_Desercion[$l]['codigoestudiante']){
                           
                             
                           //echo '<br><br>Periodo_Des_1->'.$PeriodoDinamico; 
                            
                           $D_CohorteEstudiantes[$CodigoPeriodo_ini][$Carrera_id][$PeriodoDinamico]['Desercion'][]=$CodigoEstudiante; 
                           
                           /****************************************************************************************************/
                                
                                 $SQL='SELECT 

                                        id_DesercionChohorte  as id
                                        
                                        FROM 
                                        
                                        DesercionChohorte
                                        
                                        WHERE
                                        
                                        codigoperiododesercion="'.$PeriodoDinamico.'"
                                        AND
                                        id_desercion="'.$Last_id.'"
                                        AND
                                        codigoestudiante="'.$CodigoEstudiante.'"
                                        AND
                                        codigoestado=100';
                                        
                                        if($CohoreExisteDes=&$db->Execute($SQL)===false){
                                            echo 'Error en el SQL de Si Existe la Cohorte...<br>'.$SQL;
                                            die;
                                        }
                                
                                /****************************************************************************************************/
                                if(!$CohoreExisteDes->EOF){
                                    
                                     //echo '<br><br>Periodo_Des_2->'.$PeriodoDinamico;
                                    
                                    $SQL_Update='UPDATE DesercionChohorte
                           
                                         SET    chagedate=NOW()
                                         
                                         WHERE  
                                                codigoperiododesercion="'.$PeriodoDinamico.'"
                                                AND
                                                id_desercion="'.$Last_id.'"
                                                AND
                                                codigoestudiante="'.$CodigoEstudiante.'"
                                                AND
                                                codigoestado=100
                                                AND
                                                id_DesercionChohorte="'.$CohoreExisteDes->fields['id'].'"';
                                                
                                      if($ModificaDes=&$db->Execute($SQL_Update)===false){
                                        echo 'Error en el SQl de Modificar Los Inicios de la Cohorte...<br>'.$SQL_Update;
                                        die;
                                       } 
                                    
                                    
                                }else{
                                     //echo '<br><br>Periodo_Des_3->'.$PeriodoDinamico;
                                     
                                    $SQL_CohorteDesercion='INSERT INTO DesercionChohorte(id_desercion,codigoestudiante,codigoperiododesercion,entrydate)VALUES("'.$Last_id.'","'.$CodigoEstudiante.'","'.$PeriodoDinamico.'",NOW())';
                                
                                    if($insertCohorteDes=&$db->Execute($SQL_CohorteDesercion)===false){
                                        echo 'Error en el SQl de La Cohorte Desercion ..<br><br>'.$SQL_CohorteDesercion;
                                        die;
                                    }
                                    
                                }//$CohoreExisteDes->EOF
                           /****************************************************************************************************/
                            
                        }//Desercion
                        
                        /************************************************************************/
                     }//for Desercion 
                        
                     }//Continua
                     
                    /**********************************************************************************************/
            }//For Cortes Iniciales
           
        }//for Peridodos Dinamicos
        
    }//for Carreras
    
}//for periodos Actuales 

//echo '<pre>';print_r($D_CohorteEstudiantes);



function CortesDinamicas($Periodo){
    
   
    
    $arrayP = str_split($Periodo, strlen($Periodo)-1);

    $year = $arrayP[0];
    $P_Ini = $arrayP[1];
    
    $C_Periodos   = array();
    
    for($i=1;$i<=20;$i++){
                /***********************************************************************/
                if($i==1){//if..1
                    $PeriodoView  = $year.'-'.$P_Ini;
                    $CodigoPeriodo = $Periodo;
                }else{
                    if($P_Ini==2){////if..2
                        $year  = $year+1;
                        $P_Ini = 1;
                        $PeriodoView  = $year.'-'.$P_Ini;
                        $CodigoPeriodo = $year.$P_Ini;
                    }else{
                        if($P_Ini==1){
                           $P_Ini = 2; 
                        }
                        $PeriodoView  = $year.'-'.$P_Ini;
                        $CodigoPeriodo = $year.$P_Ini;
                    }//if..2
                }//if..1
                
         $C_Periodos[]=   $CodigoPeriodo;    
     }     
    
    //echo '<pre>';print_r($C_Periodos);
    return $C_Periodos;
    
}
function MainJson(){
	
	global $db,$userid;
	
	include ('../../templates/mainjson.php');
	
	
	$SQL_User='SELECT idusuario as id FROM usuario WHERE usuario="'.$_SESSION['MM_Username'].'"';
	
	if($Usario_id=&$db->Execute($SQL_User)===false){
		echo 'Error en el SQL Userid...<br>';
		die;
	}
	
	$userid=$Usario_id->fields['id'];
	
}
?>