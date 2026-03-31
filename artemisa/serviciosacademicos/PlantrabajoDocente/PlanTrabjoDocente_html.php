<?PHP 
session_start();
/*if(!isset ($_SESSION['MM_Username'])){
	?>
	<blink><strong style="color:#F00; font-size:18px">No ha iniciado sesión en el sistema</strong></blink>
	<?PHP
    exit();
} */
switch($_REQUEST['actionID']){
    case 'Decanos':{
        define(AJAX,'TRUE');
		define(BIENVENIDA,'TRUE');
		MainGeneral($_POST['Docente_id']);
        JsGenral();
        
        global $db,$C_PlanTrabjoDocente,$userid;
        
        
    }break;
    case 'Retorno':{
   	    define(AJAX,'TRUE');
		define(BIENVENIDA,'TRUE');
		MainGeneral($_POST['Docente_id']);
        JsGenral();
        
        global $db,$C_PlanTrabjoDocente,$userid;
        
        $C_PlanTrabjoDocente->Principal($_POST['Docente_id'],$_POST['PeRiodo']);
        
    }break;
    case 'PintarPeriodo':{
        
       	MainJson();
        
        global $db;
        
        $arrayP = str_split($_POST['PeliodoSelect'], strlen($_POST['PeliodoSelect'])-1);
                
        $P = $arrayP[0].'-'.$arrayP[1];
        
          $SQL='SELECT 

                codigoestadoperiodo
                
                FROM 
                
                periodo 
                
                WHERE codigoperiodo="'.$_POST['PeliodoSelect'].'"';
                
                if($Estado=&$db->Execute($SQL)===false){
                    $a_vectt['val']		        ='FALSE';
                    $a_vectt['descrip']		    ='Error en el SQL del Periodo....'.$SQL;
                    echo json_encode($a_vectt);
                    exit;  
                }
         
         
        
        
        $a_vectt['Estado']		        =$Estado->fields['codigoestadoperiodo'];
        $a_vectt['Formato']		        =$P;
        echo json_encode($a_vectt);
        exit;
        
    }break;
    case 'BuscaPeriodo':{
        define(AJAX,'FALSE');
		
		MainGeneral();
        
        global $db,$C_PlanTrabjoDocente;
        
        $C_PlanTrabjoDocente->Periodo(1);
        
    }break;
    case 'BuscaMasData':{
        $Docente_id     = $_POST['Docente_id'];
        $id             = $_POST['id'];
         
        MainJson($Docente_id);
        
       global $db,$userid;
       
       
       
       
          $SQL='SELECT

                        id_plandocente,
                        id_vocacion,
                        autoevaluacion,
                        porcentaje,
                        consolidacion,
                        mejora
                
                FROM 
                
                        plandocente
                
                
                WHERE
                
                        id_docente="'.$Docente_id.'"
                        AND
                        plantrabajo_id="'.$id.'"
                        AND
                        codigoestado=100';
                        
                
                if($DataResult=&$db->Execute($SQL)===false){
                    $a_vectt['val']			='FALSE';
                    $a_vectt['descrip']		='Error en la Consulta...'.$SQL;
                    echo json_encode($a_vectt);
                    exit;
                }
            
            
            switch($DataResult->fields['id_vocacion']){
                case '1':{
                    $Div_Auto  = 'Auto';
                    $Div_Por   = 'PorcentajeUno';
                    $Div_Conso = 'Consolidado';
                    $Div_Mej   = 'Mejora';
                    $Button    = 'PimeraSave';
                }break;
                case '2':{
                    $Div_Auto  = 'AutoPd';
                    $Div_Por   = 'PorcentajeDos';
                    $Div_Conso = 'ConsolidadoPd';
                    $Div_Mej   = 'MejoraPd';
                    $Button    = 'DosSave';
                }break;
                case '3':{
                    $Div_Auto  = 'AutoPt';
                    $Div_Por   = 'PorcentajeTres';
                    $Div_Conso = 'ConsolidadoPt';
                    $Div_Mej   = 'MejoraPt';
                    $Button    = 'TresSave';
                }break;
                case '4':{
                    $Div_Auto  = 'AutoPc';
                    $Div_Por   = 'PorcentajeCuatro';
                    $Div_Conso = 'ConsolidadoPc';
                    $Div_Mej   = 'MejoraPc';
                    $Button    = 'CuatroSave';
                }break;
            }
            
              
            $a_vectt['val']			        ='TRUE';
            $a_vectt['autoevaluacion']		=$DataResult->fields['autoevaluacion'];
            $a_vectt['porcentaje']		    =$DataResult->fields['porcentaje'];
            $a_vectt['consolidacion']		=$DataResult->fields['consolidacion'];
            $a_vectt['mejora']		        =$DataResult->fields['mejora'];
            $a_vectt['id_Auto']		        =$Div_Auto;
            $a_vectt['id_Porj']		        =$Div_Por;
            $a_vectt['id_Cons']		        =$Div_Conso;
            $a_vectt['id_Mej']		        =$Div_Mej;
            $a_vectt['Boton']		        =$Button;
            echo json_encode($a_vectt);
            exit;       
       
    }break;
    case 'UpdetaHoras':{
       $Docente_id              = $_POST['Docente_id'];
       
       MainJson($Docente_id);
        
       global $db,$userid;
       
       $PlanDocente_id          = $_POST['PlanDocente_id']; 
       $Horas                   = $_POST['Horas'];
       $Vocacion_id             = $_POST['Vocacion_id'];
       
       
       $Update='UPDATE  plandocente
       
                SET     horas="'.$Horas.'",
                        changedate=NOW(),
                        useridestado="'.$userid.'"
                        
                WHERE   id_plandocente="'.$PlanDocente_id.'" 
                        AND
                        id_docente="'.$Docente_id.'"
                        AND
                        id_vocacion="'.$Vocacion_id.'"
                        AND
                        codigoestado=100';
                        
               if($Modificado=&$db->Execute($Update)===false){
                    $a_vectt['val']			='FALSE';
                    $a_vectt['descrip']		='Error en Update... '.$Update;
                    echo json_encode($a_vectt);
                    exit;
                }  
                
            $a_vectt['val']			='TRUE';
            //$a_vectt['descrip']		='Error en Update... '.$Update;
            echo json_encode($a_vectt);
            exit;                    
       
    }break;
    case 'UpdateHoras':{
        $Docente_id      = $_POST['Docente_id'];
        
        MainJson($Docente_id);
        
        global $db,$userid;
        
        $Plan_id            = $_POST['Plan'];  
        $H_Preparacio       = $_POST['H_Preparacio'];
        $T_horas            = $_POST['T_horas'];       
        
        
        $Update_horas='UPDATE   accionesplandocente_temp
                       SET      hora="'.$T_horas.'",
                                hora_trabajo="'.$H_Preparacio.'"
                                
                       WHERE    id_accionesplandocentetemp="'.$Plan_id.'" AND docente_id="'.$Docente_id.'"';
                       
               if($HorasModificado=&$db->Execute($Update_horas)===false){
                    $a_vectt['val']			='FALSE';
                    $a_vectt['descrip']		='Error en Update... '.$Update_horas;
                    echo json_encode($a_vectt);
                    exit;
               }        
        
            $a_vectt['val']			='TRUE';
            echo json_encode($a_vectt);
            exit; 
        
    }break;
    case 'UpdetaText':{
        
        $Docente_id    = $_POST['Docente_id'];
		
		MainJson($Docente_id);
        
        global $db,$userid;
         
         $id            = $_POST['id'];
         $TXT           = $_POST['TXT'];
         
         
         //accionesplandocente_temp(descripcion,codigoperiodo,entrydate,userid,docente_id)
         
         $Up_Text='UPDATE   accionesplandocente_temp
                   SET      descripcion="'.$TXT.'",
                            changedate=NOW(),
                            useridestado="'.$userid.'"
                            
                   WHERE    id_accionesplandocentetemp="'.$id.'" AND codigoestado=100 AND docente_id="'.$Docente_id.'"';
                   
                if($Text_Edit=&$db->Execute($Up_Text)===false){
                    $a_vectt['val']			='FALSE';
                    $a_vectt['descrip']		='Error en Update... '.$Up_Text;
                    echo json_encode($a_vectt);
                    exit;
                }   
                
            $a_vectt['val']			='TRUE';
            $a_vectt['descrip']		='Modificado';
            $a_vectt['Texto']		=$TXT;
            echo json_encode($a_vectt);
            exit;     
         
    }break;
    case 'PlanDinamic':{
        
		 
         $Docente_id  = $_POST['Docente_id'];
         
		MainJson($Docente_id);
        
         global $db,$userid;
         
         
        $plan_id        = $_POST['plan_id'];
        $Vocacion       = $_POST['Vocacion'];
        
          $SQL='SELECT 

				id_plandocente,
				id_vocacion,
				proyecto_nom,
				tipo,
				cual,
                horas,
                plantrabajo_id,
                id_docente
				
				FROM 
                
                plandocente 
				
				WHERE
				
				codigoestado=100
                AND
                id_vocacion="'.$Vocacion.'"
                AND
                id_plandocente="'.$plan_id.'"';
                
             if($Resultado_Plan=&$db->execute($SQL)===false){
                $a_vectt['val']			='FALSE';
                $a_vectt['descrip']		='Error en SQl... '.$SQL;
                echo json_encode($a_vectt);
                exit;
             }   
             
            $a_vectt['val']			     ='TRUE'; 
            $a_vectt['label']		     = $Resultado_Plan->fields['proyecto_nom'];
            //$a_vectt['value']		     = $Resultado_Plan->fields['proyecto_nom'];
            $a_vectt['idProyecto']	     = $Resultado_Plan->fields['id_plandocente'];
            $a_vectt['tipo']	         = $Resultado_Plan->fields['tipo'];
            $a_vectt['cual']		     = $Resultado_Plan->fields['cual'];
            $a_vectt['Horas']		     = $Resultado_Plan->fields['horas'];
            $a_vectt['plantrabajo_id']	 = $Resultado_Plan->fields['plantrabajo_id'];
            $a_vectt['Docente_id']	     = $Resultado_Plan->fields['id_docente'];
            echo json_encode($a_vectt);
            exit;
        
    }break;
    case 'RefreshPlanes':{
        define(AJAX,'FALSE');
		
		$Docente_id     = $_POST['Docente_id'];
        
		MainGeneral($Docente_id);
        
        global $C_PlanTrabjoDocente,$userid,$db,$id_Docente;
		
        
        $vocacion       = $_POST['vocacion'];
        $Periodo_id     = $_POST['Periodo_id'];
        
        
        $C_PlanTrabjoDocente->PlanesTrabjoView($Docente_id,$vocacion,$Periodo_id);
        
    }break;
    case 'SaveTabCuatro':{
        
	    $Docente_id        = $_POST['Docente_id'];
        
		MainJson($Docente_id);
        
        global $db,$userid;
         
         $id                = $_POST['Cadena'];
         $Auto              = $_POST['Auto'];
         $PorcentajeUno     = $_POST['PorcentajeUno'];
         $Consolidado       = $_POST['Consolidado'];
         $Mejora            = $_POST['Mejora'];
         $Periodo_id        = $_POST['Periodo_id'];
         
         
          $SQL='SELECT 
          
                        id_plandocente
                
                FROM 
                
                         plandocente 
                
                WHERE
                
                        id_vocacion=4
                        AND
                        id_plandocente="'.$id.'"
                        AND
                        id_docente="'.$Docente_id.'"
                        AND
                        codigoestado=100
                        AND
                        codigoperiodo="'.$Periodo_id.'"';
                
              if($Plan_id=&$db->Execute($SQL)===false){
                echo 'Error en el SQl <br>'.$SQL;
                die;
              }  
              
              
          $SQL_UP='UPDATE   plandocente
              
                       SET      autoevaluacion="'.$Auto.'",   
                                porcentaje="'.$PorcentajeUno.'",
                                consolidacion="'.$Consolidado.'",
                                mejora="'.$Mejora.'"
                                
                       WHERE    id_plandocente="'.$Plan_id->fields['id_plandocente'].'" 
                                AND
                                id_vocacion=4
                                 AND
                                id_docente="'.$Docente_id.'"
                                AND
                                codigoestado=100
                                AND
                                codigoperiodo="'.$Periodo_id.'"';
                                
                     if($Update_Dos=&$db->Execute($SQL_UP)===false){
                        $a_vectt['val']			='FALSE';
                        $a_vectt['descrip']		='Error en El Update ... '.$SQL_UP;
                        echo json_encode($a_vectt);
                        exit;
                     }    
                            
        $a_vectt['val']			='TRUE';
        $a_vectt['descrip']		='Se Ha Guardado Correctamente';
        echo json_encode($a_vectt);
        exit;   
        
    }break;
    case 'SaveTabTres':{
        
        $Docente_id        = $_POST['Docente_id'];
        
		MainJson($Docente_id);
        
        global $db,$userid;
	
         
         $id                = $_POST['Cadena'];
         $Auto              = $_POST['Auto'];
         $PorcentajeUno     = $_POST['PorcentajeUno'];
         $Consolidado       = $_POST['Consolidado'];
         $Mejora            = $_POST['Mejora'];
         $Periodo_id        = $_POST['Periodo_id'];
         
         
         $SQL='SELECT 
          
                        id_plandocente
                
                FROM 
                
                         plandocente 
                
                WHERE
                
                        id_vocacion=3
                        AND
                        id_plandocente="'.$id.'"
                        AND
                        id_docente="'.$Docente_id.'"
                        AND
                        codigoestado=100
                        AND
                        codigoperiodo="'.$Periodo_id.'"';
                
              if($Plan_id=&$db->Execute($SQL)===false){
                echo 'Error en el SQl <br>'.$SQL;
                die;
              }  
              
              
           $SQL_UP='UPDATE   plandocente
              
                       SET      autoevaluacion="'.$Auto.'",
                                porcentaje="'.$PorcentajeUno.'",
                                consolidacion="'.$Consolidado.'",
                                mejora="'.$Mejora.'"
                                
                       WHERE    id_plandocente="'.$Plan_id->fields['id_plandocente'].'" 
                                AND
                                id_vocacion=3
                                 AND
                                id_docente="'.$Docente_id.'"
                                AND
                                codigoestado=100
                                AND
                                codigoperiodo="'.$Periodo_id.'"';
                                
                     if($Update_Dos=&$db->Execute($SQL_UP)===false){
                        $a_vectt['val']			='FALSE';
                        $a_vectt['descrip']		='Error en El Update ... '.$SQL_UP;
                        echo json_encode($a_vectt);
                        exit;
                     }    
                            
        $a_vectt['val']			='TRUE';
        $a_vectt['descrip']		='Se Ha Guardado Correctamente';
        echo json_encode($a_vectt);
        exit;   
        
        
    }break;
    case 'AccExistentesCuatro':{
        define(AJAX,'FALSE');
		global $C_PlanTrabjoDocente,$userid,$db,$id_Docente;
		
        $Docente_id     = $_POST['Docente_id'];
        
		MainGeneral($Docente_id);
	
		
		
		$C_PlanTrabjoDocente->AcionesDinamicCuatro($_POST['id'],$_POST['Periodo_id']);
        
    }break;
    case 'AccExistentesTres':{
		define(AJAX,'FALSE');
		global $C_PlanTrabjoDocente,$userid,$db,$id_Docente;
		
        $Docente_id  = $_POST['Docente_id'];
        
		MainGeneral($Docente_id);
		
		
		$C_PlanTrabjoDocente->AcionesDinamicTres($_POST['id'],$_POST['Periodo_id']);
		
		}break;
    case 'SaveTemp4':{
        
        $Docente_id        = $_POST['Docente_id']; 
         
		MainJson($Docente_id);
         
        global $db,$userid; 
   
         $NomProyecto       = $_POST['NomProyecto'];
        
         $Periodo_id        = $_POST['Periodo_id'];
         $Last_id           = $_POST['Last_id'];
         
         $Hora              = $_POST['Hora'];
         
         
          $SQL_Temp='INSERT INTO plandocente(proyecto_nom,codigoperiodo,entrydate,userid,id_vocacion,plantrabajo_id,id_docente,horas)VALUES("'.$NomProyecto.'","'.$Periodo_id.'",NOW(),"'.$userid.'","4","'.$Last_id.'","'.$Docente_id.'","'.$Hora.'")';
		 
		 	if($InsertPlan=&$db->Execute($SQL_Temp)===false){
					$a_vectt['val']			='FALSE';
					$a_vectt['descrip']		='Error en El Insert ... '.$SQL_Temp;
					echo json_encode($a_vectt);
					exit;
				}
				
			###################################
			$Last_id=$db->Insert_ID();
			###################################
			
			
			
			$a_vectt['val']			='TRUE';
			//$a_vectt['Last_id']		=$Last_id;
            $a_vectt['descrip']		='Se Ha Almacenado Correctamente...';
			echo json_encode($a_vectt);
			exit;		
		 
        
    }break;    
    case 'SaveTemp3':{
        
        $Docente_id        = $_POST['Docente_id'];
		
		MainJson($Docente_id);
        global $db,$userid; 
   
         $NomProyecto       = $_POST['NomProyecto'];
         $TipoProyectoInv   = $_POST['TipoProyectoInv'];
         $Periodo_id        = $_POST['Periodo_id'];
         $Last_id           = $_POST['Last_id'];
         
         $Hora              = $_POST['Hora'];
         
         
          $SQL_Temp='INSERT INTO plandocente(proyecto_nom,tipo,codigoperiodo,entrydate,userid,id_vocacion,plantrabajo_id,id_docente,horas)VALUES("'.$NomProyecto.'","'.$TipoProyectoInv.'","'.$Periodo_id.'",NOW(),"'.$userid.'","3","'.$Last_id.'","'.$Docente_id.'","'.$Hora.'")';
		 
		 	if($InsertPlan=&$db->Execute($SQL_Temp)===false){
					$a_vectt['val']			='FALSE';
					$a_vectt['descrip']		='Error en El Insert ... '.$SQL_Temp;
					echo json_encode($a_vectt);
					exit;
				}
				
			###################################
			$Last_id=$db->Insert_ID();
			###################################
			
			
			
			$a_vectt['val']			='TRUE';
			//$a_vectt['Last_id']		=$Last_id;
            $a_vectt['descrip']		='Se Ha Almacenado Correctamente...';
			echo json_encode($a_vectt);
			exit;		
		 
         
    }break;
    case 'SaveTabDos':{
        
        $Docente_id        = $_POST['Docente_id'];
       
		MainJson($Docente_id);
		global $db,$userid; 
         
         $id        = $_POST['Cadena'];
         $Auto       = $_POST['Auto'];
         $PorcentajeUno        = $_POST['PorcentajeUno'];
         $Consolidado        = $_POST['Consolidado'];
         $Mejora        = $_POST['Mejora'];
         $Periodo_id        = $_POST['Periodo_id'];
         
         
           $SQL='SELECT 
          
                        id_plandocente
                
                FROM 
                
                         plandocente 
                
                WHERE
                
                        id_vocacion=2
                        AND
                        id_plandocente="'.$id.'"
                        AND
                        id_docente="'.$Docente_id.'"
                        AND
                        codigoestado=100
                        AND
                        codigoperiodo="'.$Periodo_id.'"';
                
              if($Plan_id=&$db->Execute($SQL)===false){
                echo 'Error en el SQl <br>'.$SQL;
                die;
              }  
              
              
               $SQL_UP='UPDATE   plandocente
              
                       SET      autoevaluacion="'.$Auto.'",
                                porcentaje="'.$PorcentajeUno.'",
                                consolidacion="'.$Consolidado.'",
                                mejora="'.$Mejora.'"
                                
                       WHERE    id_plandocente="'.$Plan_id->fields['id_plandocente'].'" 
                                AND
                                id_vocacion=2
                                AND
                                id_docente="'.$Docente_id.'"
                                AND
                                codigoestado=100
                                AND
                                codigoperiodo="'.$Periodo_id.'"';
                                
                     if($Update_Dos=&$db->Execute($SQL_UP)===false){
                        $a_vectt['val']			='FALSE';
                        $a_vectt['descrip']		='Error en El Update ... '.$SQL_UP;
                        echo json_encode($a_vectt);
                        exit;
                     }    
                            
        $a_vectt['val']			='TRUE';
        $a_vectt['descrip']		='Se Ha Guardado Correctamente';
        echo json_encode($a_vectt);
        exit;   
        
    }break;
    case 'EvidenciaSave':{
        
       
       $PlanTrabajo_id         = $_POST['PlanTrabajo_id'];
        $Cadena_Evidencias      = $_POST['Cadena_Evidencias'];
        $Docente_id             = $_POST['Docente_id'];
       
		MainJson($Docente_id);
		
        global $db,$userid;
         
        $SQL_Periodo='SELECT 

                   codigoperiodo

                   FROM 
                   
                   periodo 
                   
                   WHERE 
                   
                   codigoestadoperiodo=1';
                   
       if($Periodo=&$db->Execute($SQL_Periodo)===false){
            echo 'Error en el SQL ....<br><br>'.$SQL_Periodo;
            die;
       }   
       
      $CodigoPeriodo=$Periodo->fields['codigoperiodo']; 
         
        
        /*****************************************************/
        $C_Evidencia  = explode('::',$Cadena_Evidencias);
        
        //echo '<pre>';print_r($C_Evidencia);
        
        for($i=1;$i<count($C_Evidencia);$i++){
            /*********************************/
                $D_Evidencia  = explode(';',$C_Evidencia[$i]);
                
                //echo '<pre>';print_r($D_Evidencia);
                
                $Inser_Evidencia='INSERT INTO evidenciaplandocente(id_plantrabajo,evidencia,fecha,codigoperiodo,userid,entrydate,docente_id)VALUES("'.$PlanTrabajo_id.'","'.$D_Evidencia[0].'","'.$D_Evidencia[1].'","'.$CodigoPeriodo.'","'.$userid.'",NOW(),"'.$Docente_id.'")';
                
                if($Evidencia=&$db->Execute($Inser_Evidencia)===false){
                        $a_vectt['val']			='FALSE';
                        $a_vectt['descrip']		='Error en El Insert ... '.$Inser_Evidencia;
                        echo json_encode($a_vectt);
                        exit;
                }
                
                ###################################
    			$Last_id=$db->Insert_ID();
    			###################################
                
                $UP_Doc='UPDATE  doc_evidenciaplantrabajo
                         SET     evidencia_id="'.$Last_id.'"
                         WHERE   plantrabajo_id="'.$PlanTrabajo_id.'"
                                 AND
                                 codigoperiodo="'.$CodigoPeriodo.'"
                                 AND
                                 codigoestado=100
                                 AND
                                 evidencia_index="'.$D_Evidencia[2].'"';
                                 
                       if($Update_Doc=&$db->Execute($UP_Doc)===false){
                            $a_vectt['val']			='FALSE';
                            $a_vectt['descrip']		='Error en El Modificar ... '.$UP_Doc;
                            echo json_encode($a_vectt);
                            exit;
                       }          

            /*********************************/
        }//for  
         
         
        $a_vectt['val']			='TRUE';
        $a_vectt['descrip']		='Se Ha Guardado Correctamente';
        echo json_encode($a_vectt);
        exit;  
        /*****************************************************/
    }break;
    case 'Archivos':{
        define(AJAX,'FALSE');
		global $C_PlanTrabjoDocente,$userid,$db,$id_Docente;
		
        $Docente_id     = $_POST['Docente_id'];
        
		MainGeneral($id_Docente);
		
        
        
        $C_PlanTrabjoDocente->Archivos($_POST['PlanTrabajo_id'],$_POST['index']); 
         
    }break;
    case 'AutoCompleteCuatro':{
        
        $Docente_id   = $_REQUEST['Docente_id'];
		 
		MainJson($Docente_id);
		global $db,$userid; 
		 
		  $Letra   		= $_REQUEST['term'];
		  $Periodo_id	= $_REQUEST['Periodo_id'];
          
		 
		  $SQL='SELECT 

				id_plandocente,
				id_vocacion,
				proyecto_nom,
				tipo,
				cual,
                horas,
                plantrabajo_id
				
				FROM plandocente 
				
				WHERE
				
				codigoestado=100
				AND
				codigoperiodo="'.$Periodo_id.'"
				AND
				proyecto_nom LIKE "%'.$Letra.'%"
                AND
                id_docente="'.$Docente_id.'"
                AND
                id_vocacion=4';
				
			if($Resultado=&$db->Execute($SQL)===false){
					echo 'Error en el SQl ....<br>'.$SQL;
					die;
				}
				
			 $Result = array();		
			 
			 if(!$Resultado->EOF){
				 while(!$Resultado->EOF){
					 /*********************************************/
					 	$C_Result['label']		= $Resultado->fields['proyecto_nom'];
						$C_Result['value']		= $Resultado->fields['proyecto_nom'];
						$C_Result['idProyecto']	= $Resultado->fields['id_plandocente'];
						$C_Result['tipo']		= $Resultado->fields['tipo'];
						$C_Result['cual']		= $Resultado->fields['cual'];
                        $C_Result['Horas']		= $Resultado->fields['horas'];
                        $C_Result['plantrabajo_id']		= $Resultado->fields['plantrabajo_id'];
					 /*********************************************/
					 array_push($Result,$C_Result);
					 $Resultado->MoveNext();
					 }
				 }
		 	echo json_encode($Result);
    }break;
    case 'AutoCompleteTres':{
        
        
        $Docente_id   = $_REQUEST['Docente_id'];
        
		MainJson($Docente_id);
		global $db,$userid; 
		 
		 
		  $Letra   		= $_REQUEST['term'];
		  $Periodo_id	= $_REQUEST['Periodo_id'];
          
		 
		  $SQL='SELECT 

				id_plandocente,
				id_vocacion,
				proyecto_nom,
				tipo,
				cual,
                horas,
                plantrabajo_id
				
				FROM plandocente 
				
				WHERE
				
				codigoestado=100
				AND
				codigoperiodo="'.$Periodo_id.'"
				AND
				proyecto_nom LIKE "%'.$Letra.'%"
                AND
                id_docente="'.$Docente_id.'"
                AND
                id_vocacion=3';
				
			if($Resultado=&$db->Execute($SQL)===false){
					echo 'Error en el SQl ....<br>'.$SQL;
					die;
				}
				
			 $Result = array();		
			 
			 if(!$Resultado->EOF){
				 while(!$Resultado->EOF){
					 /*********************************************/
					 	$C_Result['label']		= $Resultado->fields['proyecto_nom'];
						$C_Result['value']		= $Resultado->fields['proyecto_nom'];
						$C_Result['idProyecto']	= $Resultado->fields['id_plandocente'];
						$C_Result['tipo']		= $Resultado->fields['tipo'];
						$C_Result['cual']		= $Resultado->fields['cual'];
                        $C_Result['Horas']		= $Resultado->fields['horas'];
                        $C_Result['plantrabajo_id']		= $Resultado->fields['plantrabajo_id'];
					 /*********************************************/
					 array_push($Result,$C_Result);
					 $Resultado->MoveNext();
					 }
				 }
		 	echo json_encode($Result);
        
    }break;
	case 'AutoCompleteProyecto':{
		
        $Docente_id   = $_REQUEST['Docente_id'];
        
		MainJson($Docente_id);
		global $db,$userid;
        
		 
		 
		  $Letra   		= $_REQUEST['term'];
		  $Periodo_id	= $_REQUEST['Periodo_id'];
          
		 
		  $SQL='SELECT 

				id_plandocente,
				id_vocacion,
				proyecto_nom,
				tipo,
				cual,
                horas,
                plantrabajo_id
				
				FROM plandocente 
				
				WHERE
				
				codigoestado=100
				AND
				codigoperiodo="'.$Periodo_id.'"
				AND
				proyecto_nom LIKE "%'.$Letra.'%"
                AND
                id_docente="'.$Docente_id.'"
                AND
                id_vocacion=2';
				
			if($Resultado=&$db->Execute($SQL)===false){
					echo 'Error en el SQl ....<br>'.$SQL;
					die;
				}
				
			 $Result = array();		
			 
			 if(!$Resultado->EOF){
				 while(!$Resultado->EOF){
					 /*********************************************/
					 	$C_Result['label']		= $Resultado->fields['proyecto_nom'];
						$C_Result['value']		= $Resultado->fields['proyecto_nom'];
						$C_Result['idProyecto']	= $Resultado->fields['id_plandocente'];
						$C_Result['tipo']		= $Resultado->fields['tipo'];
						$C_Result['cual']		= $Resultado->fields['cual'];
                        $C_Result['Horas']		= $Resultado->fields['horas'];
                        $C_Result['plantrabajo_id']		= $Resultado->fields['plantrabajo_id'];                        
					 /*********************************************/
					 array_push($Result,$C_Result);
					 $Resultado->MoveNext();
					 }
				 }
		 	echo json_encode($Result);
			
		}break;
	case 'AccExistentes':{
		define(AJAX,'FALSE');
		global $C_PlanTrabjoDocente,$userid,$db,$id_Docente;
		
        $Docente_id         = $_POST['Docente_id'];
		
		MainGeneral($Docente_id);
        
		
		
		$C_PlanTrabjoDocente->AcionesDinamic($_POST['id'],$_POST['Periodo_id']);
		
		}break;
	case 'SaveTempDetalle':{
		 
         
         $Docente_id   = $_POST['Docente_id'];
       
		MainJson($Docente_id);
		global $db,$userid;
		 
		 $Accion		= $_POST['Accion'];
		 
		 $Periodo_id	= $_POST['Periodo_id'];
         
         
		
		$SQL_Temp='INSERT INTO accionesplandocente_temp(descripcion,codigoperiodo,entrydate,userid,docente_id)VALUES("'.$Accion.'","'.$Periodo_id.'",NOW(),"'.$userid.'","'.$Docente_id.'")';
		
				if($InsertAcion=&$db->Execute($SQL_Temp)===false){
						$a_vectt['val']			='FALSE';
						$a_vectt['descrip']		='Error en El Insert ... '.$SQL_Temp;
						echo json_encode($a_vectt);
						exit;
					}
                    
             ###################################
			$Last_id=$db->Insert_ID();
			###################################       
		
		
				$a_vectt['val']			='TRUE';
                $a_vectt['Last_id']		=$Last_id;
				
				echo json_encode($a_vectt);
				exit;
		
		}break;
	case 'SaveTemp2':{
		
         
         $Docente_id    = $_POST['Docente_id'];
         
		MainJson($Docente_id);
		
		  global $db,$userid;
		     
		 $NomProyecto		= $_POST['NomProyecto'];
		 $TipoProyectoInv	= $_POST['TipoProyectoInv'];
		 $OtroType			= $_POST['OtroType'];
		 $Periodo_id		= $_POST['Periodo_id'];
         $Last_id		= $_POST['Last_id'];
         
         $Hora          = $_POST['Hora'];
		 
		 
		 $SQL_Temp='INSERT INTO plandocente(proyecto_nom,tipo,cual,codigoperiodo,entrydate,userid,id_vocacion,plantrabajo_id,id_docente,horas)VALUES("'.$NomProyecto.'","'.$TipoProyectoInv.'","'.$OtroType.'","'.$Periodo_id.'",NOW(),"'.$userid.'","2","'.$Last_id.'","'.$Docente_id.'","'.$Hora.'")';
		 
		 	if($InsertPlan=&$db->Execute($SQL_Temp)===false){
					$a_vectt['val']			='FALSE';
					$a_vectt['descrip']		='Error en El Insert ... '.$SQL_Temp;
					echo json_encode($a_vectt);
					exit;
				}
				
			###################################
			$Last_id=$db->Insert_ID();
			###################################
			
			
			
			$a_vectt['val']			='TRUE';
			//$a_vectt['Last_id']		=$Last_id;
            $a_vectt['descrip']		='Se Ha Almacenado Correctamente...';
			echo json_encode($a_vectt);
			exit;		
		 
		 
		}break;
	case 'SaveTabUno':{
		 
         $Docente_id        = $_POST['Docente_id'];
         
	 	 MainJson($Docente_id);
		 
		 global $db,$userid;
		 
		 $Cadena			= $_POST['Cadena'];
		 $Auto				= $_POST['Auto'];
		 $PorcentajeUno		= $_POST['PorcentajeUno'];
		 $Consolidado		= $_POST['Consolidado'];
		 $Mejora			= $_POST['Mejora'];
		 $Periodo_id		= $_POST['Periodo_id'];
         $PlanTrabajo_id    = $_POST['PlanTrabajo_id'];
         
         
          $SQL='SELECT 

                id_plandocente
                
                FROM 
                plandocente 
                
                WHERE
                
                
                id_docente="'.$Docente_id.'"
                AND
                id_vocacion=1
                AND
                codigoestado=100
                AND
                plantrabajo_id="'.$PlanTrabajo_id.'"
                AND
                codigoperiodo="'.$Periodo_id.'"';
                
                
                if($Dato_Plan=&$db->Execute($SQL)===false){
                    $a_vectt['val']			='FALSE';
    				$a_vectt['descrip']		='Error en El SQL ... '.$SQL;
    				echo json_encode($a_vectt);
    				exit;
                }
         
		 
		 
         $SQL_Update='UPDATE plandocente
         
                      SET    autoevaluacion="'.$Auto.'",
                             porcentaje="'.$PorcentajeUno.'",
                             consolidacion="'.$Consolidado.'",
                             mejora="'.$Mejora.'"
                             
                      WHERE
                
                
                            id_docente="'.$Docente_id.'"
                            AND
                            id_vocacion=1
                            AND
                            codigoestado=100
                            AND
                            plantrabajo_id="'.$PlanTrabajo_id.'"
                            AND
                            codigoperiodo="'.$Periodo_id.'"
                            AND
                            id_plandocente="'.$Dato_Plan->fields['id_plandocente'].'"';
         
		 //$Insert= 'INSERT INTO plandocente(id_docente,id_vocacion,plantrabajo_id,autoevaluacion,porcentaje,consolidacion,mejora,codigoperiodo,entrydate,userid)VALUES("'.$Docente_id.'","1","'.$PlanTrabajo_id.'","'.$Auto.'","'.$PorcentajeUno.'","'.$Consolidado.'","'.$Mejora.'","'.$Periodo_id.'",NOW(),"'.$userid.'")';
		   
		 if($InsertPlanDocente=&$db->Execute($SQL_Update)===false){
				$a_vectt['val']			='FALSE';
				$a_vectt['descrip']		='Error en El Insert ... '.$SQL_Update;
				echo json_encode($a_vectt);
				exit;
			}
			
			###################################
			$Last_id=$db->Insert_ID();
			###################################
			
			
			$a_vectt['val']			='TRUE';
			$a_vectt['descrip']		='Se Ha Almacenado Correctamente';
			echo json_encode($a_vectt);
			exit;
		 
		}break;
	case 'TablaDinamic':{
		define(AJAX,'TRUE');
		global $C_PlanTrabjoDocente,$userid,$db,$id_Docente;
		$id_Docente = '';
        
        if($_REQUEST['Ext']===0 || $_REQUEST['Ext']==='0'){
            $id_Docente = $_REQUEST['id_Docente'];
         }
		MainGeneral($id_Docente);
		
		$C_PlanTrabjoDocente->TablaDianmica();
		}break;
	case 'VisualizarTemp':{
		define(AJAX,'TRUE');
		global $C_PlanTrabjoDocente,$userid,$db,$id_Docente;
		
		MainGeneral($_POST['Docente_id']);
		
		$C_PlanTrabjoDocente->VisualizarTemp($_POST['id'],$_POST['i'],$_POST['Docente_id'],$_POST['Disable']);
		}break;
	case 'AcionesText':{
		define(AJAX,'TRUE');
		global $C_PlanTrabjoDocente,$userid,$db,$id_Docente;
		$id_Docente = '';
        
        if($_REQUEST['Ext']===0 || $_REQUEST['Ext']==='0'){
            $id_Docente = $_REQUEST['id_Docente'];
         }
		MainGeneral($id_Docente);
		JsGenral();
		
		$C_PlanTrabjoDocente->Acciones();
		}break;
	case 'AcionesExixtentes':{
		define(AJAX,'FALSE');
		global $C_PlanTrabjoDocente,$userid,$db,$id_Docente;
		
        
		MainGeneral($_POST['Docente_id']);
	       
          

		$C_PlanTrabjoDocente->AccionesExistentes($_POST['Facultad_id'],$_POST['Programa_id'],$_POST['Materia_id'],$_POST['Periodo_id'],$_POST['NameHidden'],$_POST['Docente_id']);	
	
    	}break;
	case 'SaveTemp':{
		
       
        $id_docente                = $_POST['id_docente'];
        
		MainJson($id_docente);
		global $db,$userid;
        
        
		 
		 $Accion					= $_POST['Accion'];
		 $Facultad_id				= $_POST['Facultad_id'];
		 $Programa_id				= $_POST['Programa_id'];
		 $Materia_id				= $_POST['Materia_id'];
		 $Periodo_id				= $_POST['Periodo_id'];
         $Docente_id                = $_POST['Docente_id'];
         $H_Preparacio              = $_POST['H_Preparacio'];
         $HorasSemana               = $_POST['HorasSemana'];
         $Grupo                     = $_POST['Grupo'];
        
        
        

		 /**************************************SaveTemp********************************************************/
		 //Solo es 1 plan docente, si ya existe sera update
             $SQL_Temp='SELECT * FROM accionesplandocente_temp WHERE codigoestado=100 AND materia_id="'.$Materia_id.'" AND grupo_id="'.$Grupo.'" AND docente_id="'.$Docente_id.'"';
            
			$result = $db->GetRow($SQL_Temp);
            
           
                        if(count($result)==0){
                 
                            $SQL_Temp='INSERT INTO accionesplandocente_temp(descripcion,facultad_id,carrera_id,materia_id,codigoperiodo,entrydate,userid,docente_id,hora,hora_trabajo,grupo_id)VALUES("'.$Accion.'","'.$Facultad_id.'","'.$Programa_id.'","'.$Materia_id.'","'.$Periodo_id.'",NOW(),"'.$userid.'","'.$Docente_id.'","'.$HorasSemana.'","'.$H_Preparacio.'","'.$Grupo.'")';

                            if($Insert_Temp=&$db->Execute($SQL_Temp)===false){
                                            $a_vectt['val']			='FALSE';
                                            $a_vectt['descrip']		='Error en El Insert Temp ... '.$SQL_Temp;
                                            echo json_encode($a_vectt);
                                            exit;
                                    }

                            ###################################
                            $Last_id=$db->Insert_ID();
                            ###################################
                            
                             $Insert= 'INSERT INTO plandocente(id_docente,id_vocacion,plantrabajo_id,codigoperiodo,entrydate,userid)VALUES("'.$Docente_id.'","1","'.$Last_id.'","'.$Periodo_id.'",NOW(),"'.$userid.'")';
		   
                    		 if($InsertPlanDocente=&$db->Execute($Insert)===false){
                    				$a_vectt['val']			='FALSE';
                    				$a_vectt['descrip']		='Error en El Insert ... '.$Insert;
                    				echo json_encode($a_vectt);
                    				exit;
                    			}
                                
                            ###################################
                            $Last_CabezaID=$db->Insert_ID();
                            ###################################   
			

                            $a_vectt['val']			='TRUE';
                            $a_vectt['descrip']		='Se Ha Almacenado Correctamente...';
                            $a_vectt['Last_id']		=$Last_id;
                            //$a_vectt['Last_CabezaID']		=$Last_CabezaID;
                            echo json_encode($a_vectt);
                            exit;	
                        } else {
                            $a_vectt['val']			='FALSE';
                            $a_vectt['descrip']		='Ya existe un plan de trabajo.';
                            echo json_encode($a_vectt);
                            exit;
                        }
                        
		 
		 /**************************************SaveTemp********************************************************/
		 		 
		}break;
	case 'AddColumnas':{
		define(AJAX,'FALSE');
		global $C_PlanTrabjoDocente,$userid,$db,$id_Docente;
		
        $Docente_id  = $_REQUEST['Docente_id'];
		
		MainGeneral($Docente_id);
		
		$C_PlanTrabjoDocente->CamposEvidencia($_GET['Indice']);
		}break;
	case 'InfoMaterias':{
		define(AJAX,'FALSE');
		global $C_PlanTrabjoDocente,$userid,$db,$id_Docente;
	       
           $Docente_id  = $_REQUEST['Docente_id'];	
	
		MainGeneral($id_Docente);
		//JsGenral();
		
		$C_PlanTrabjoDocente->InfoMaterias($_GET['Programa_id'],$_GET['NumDocumento'],$_GET['CodigoPeriodo'],$_GET['Materia_id']);
		}break;
	case 'Materias':{
		define(AJAX,'FALSE');
		global $C_PlanTrabjoDocente,$userid,$db,$id_Docente;
		
        $Docente_id    = $_REQUEST['Docente_id'];
        
		MainGeneral($Docente_id);
		
		$C_PlanTrabjoDocente->Materia($_GET['Programa_id'],$_GET['NumDocumento'],$_GET['CodigoPeriodo']);
		}break;
	case 'Programa':{
		define(AJAX,'FALSE');
		global $C_PlanTrabjoDocente,$userid,$db,$id_Docente;
		
        $Docente_id   = $_REQUEST['Docente_id'];
        
		MainGeneral($Docente_id);
		
		$C_PlanTrabjoDocente->Programa($_GET['CodigoFacultad'],$_GET['NumDocumento'],$_GET['CodigoPeriodo']);
		}break;
	default:{ 
		define(AJAX,'TRUE');
		define(BIENVENIDA,'TRUE');
		global $C_PlanTrabjoDocente,$userid,$db,$id_Docente;
		
        $id_Docente = '';
        
        if($_REQUEST['Ext']===0 || $_REQUEST['Ext']==='0'){
            $id_Docente = $_REQUEST['id_Docente'];
         }
        
		MainGeneral($id_Docente);
		JsGenral();
        
        //echo '<br>--<<'.$id_Docente;
		//echo '<br>'.$_REQUEST['Ext'];
         
        //echo '<br>->'.$id_Docente;
	     $C_PlanTrabjoDocente->Principal($id_Docente);
		
		}break;
}
function MainGeneral($id_Docente=''){
	
		
		global $C_PlanTrabjoDocente,$userid,$db,$id_Docente;
		
        //echo '<pre>';print_r($_SESSION);;
		
		if(AJAX=='TRUE'){ 
		//var_dump (is_file('templates/MenuReportes.php'));die;  
		include("templates/MenuReportes.php");
		}else{
			include("templates/mainjson.php");
			}
		include('PlanTrabjoDocente_Class.php');  $C_PlanTrabjoDocente = new PlanTrabjoDocente();
		
        //echo '<pre>';print_r($db);
        
		/*$SQL_User='SELECT idusuario as id, numerodocumento FROM usuario WHERE usuario="'.$_SESSION['MM_Username'].'"';

		if($Usario_id=&$db->Execute($SQL_User)===false){
				echo 'Error en el SQL Userid...<br>'.$SQL_User;
				die;
			}*/
            
         $SQL_docente='SELECT u.idusuario, d.iddocente FROM docente d INNER JOIN usuario u ON u.numerodocumento=d.numerodocumento AND u.codigorol=2 AND (d.iddocente="'.$id_Docente.'"  OR  u.numerodocumento="'.$_SESSION['numerodocumento'].'")  AND d.codigoestado=100' ;
         
         if($Docente_id=&$db->Execute($SQL_docente)===false){
				echo 'Error en el SQL $SQL_docente...<br>'.$SQL_docente;
				die;
			}  
		
		 $userid            = $Docente_id->fields['idusuario'];
         
         if(!$id_Docente){
            $id_Docente        = $Docente_id->fields['iddocente'];
         }else{
           $id_Docente        = $id_Docente; 
         }
         
         
	}
function MainJson($id_Docente=''){
    
	global $userid,$db;
	

		
		include("templates/mainjson.php");
		
		
		$SQL_User='SELECT u.idusuario, d.iddocente FROM docente d INNER JOIN usuario u ON u.numerodocumento=d.numerodocumento AND u.codigorol=2 AND (d.iddocente="'.$id_Docente.'"  OR  u.numerodocumento="'.$_SESSION['numerodocumento'].'")  AND d.codigoestado=100';

		if($Usario_id=&$db->Execute($SQL_User)===false){
				echo 'Error en el SQL Userid...<br>'.$SQL_User;
				die;
			}
		
		 $userid            = $Usario_id->fields['idusuario'];
         
         $id_Docente        = $Usario_id->fields['iddocente'];
	}
function JsGenral(){
?>
 <link rel="stylesheet" href="PlanTrabjoDocente.css" type="text/css" />   
 <script src="ckeditor/ckeditor.js"></script>
<!--<link href="ckeditor/samples/sample.css" rel="stylesheet"/>-->    
<style>

		.cke_focused,
		.cke_editable.cke_focused
		{
			outline: 3px dotted blue !important;
			*border: 3px dotted blue !important;	/* For IE7 */
		}

	</style>
    <script>

		CKEDITOR.on( 'instanceReady', function( evt ) {
			var editor = evt.editor;
			editor.setData();

			// Apply focus class name.
			editor.on( 'focus', function() {
				editor.container.addClass( 'cke_focused' );
			});
			editor.on( 'blur', function() {
				editor.container.removeClass( 'cke_focused' );
			});

			// Put startup focus on the first editor in tab order.
			if ( editor.tabIndex == 1 )
				editor.focus();
		});

	</script>
 <script type="text/javascript">
	
	$(function() {
		$( "#tabs" ).tabs({
		beforeLoad: function( event, ui ) {
			ui.jqXHR.error(function() {
				ui.panel.html(
				"Ocurrio un problema cargando el contenido." );
				});
			}
		});
      $("#tabs").tabs({ cache:true });
                //$( "#tabs" ).tabs().addClass( "ui-tabs-vertical ui-helper-clearfix" );
                //$( "#tabs li" ).removeClass( "ui-corner-top" ).addClass( "ui-corner-left" );
                
       $("#tabs").plusTabs({
   			className: "plusTabs", //classname for css scoping
   			seeMore: true,  //initiate "see more" behavior
   			seeMoreText: "Ver más formularios", //set see more text
   			showCount: true, //show drop down count
   			expandIcon: "&#9660; ", //icon/caret - if using image, specify image width
   			dropWidth: "auto", //width of dropdown
 			sizeTweak: 0 //adjust size of active tab to tweak "see more" layout
   		});
	});
	
</script>
<script>	  
	function Programa(){ 
		
		$('#Div_Programa').html('');
			$('#Datos').html('');
		
		var CodigoFacultad	 = $('#Facultad_id').val();
		var NumDocumento	 = $('#NumDocumento').val();
		var CodigoPeriodo	 = $('#Periodo_id').val();
        var Docente_id       = $('#Docente_id').val();
        
        if(CodigoFacultad=='-1' || CodigoFacultad==-1){
            alert('Eliga una Facultad');
            $('#Facultad_id').effect("pulsate", {times:3}, 500);
		    $('#Facultad_id').css('border-color','#F00');
            return false;
        }
		
		/********************************************************************/	
			$.ajax({//Ajax
				  type: 'GET',
				  url: 'PlanTrabjoDocente_html.php',
				  async: false,
				  //dataType: 'json',
				  data:({actionID:'Programa',CodigoFacultad:CodigoFacultad,
				  							 NumDocumento:NumDocumento,
											 CodigoPeriodo:CodigoPeriodo,
                                             Docente_id:Docente_id}),
				 error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
				 success:function(data){
						$('#Div_Programa').html(data);
			   }
			}); //AJAX
		/********************************************************************/
		}
		
    function Materias(){
        
        	$('#Datos').html('');
		
		var Programa_id		= $('#Programa_id').val();
		var NumDocumento	 = $('#NumDocumento').val();
		var CodigoPeriodo	 = $('#Periodo_id').val();
        var Docente_id      = $('#Docente_id').val();
        
         if(Programa_id=='-1' || Programa_id==-1){
            alert('Eliga una Programa Academico');
            $('#Programa_id').effect("pulsate", {times:3}, 500);
		    $('#Programa_id').css('border-color','#F00');
            return false;
        }
		
		/*********************************************************************/
			$.ajax({//Ajax
				  type: 'GET',
				  url: 'PlanTrabjoDocente_html.php',
				  async: false,
				  //dataType: 'json',
				  data:({actionID:'Materias',Programa_id:Programa_id,
				  							 NumDocumento:NumDocumento,
											 CodigoPeriodo:CodigoPeriodo,
                                             Docente_id:Docente_id}),
				 error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
				 success:function(data){
						$('#DivMateria').html(data);
			   }
			}); //AJAX
		/*********************************************************************/
		}
	function InfoMateria(){
	   
       $('#Datos').html('');
		
		var Programa_id		 = $('#Programa_id').val();
		var NumDocumento	 = $('#NumDocumento').val();
		var CodigoPeriodo	 = $('#Periodo_id').val();
		var Materia_id		 = $('#Materia_id').val();
        var Docente_id       = $('#Docente_id').val();
        
        if(Materia_id=='-1' || Materia_id==-1){
            alert('Eliga una Asignatura');
            $('#Materia_id').effect("pulsate", {times:3}, 500);
		    $('#Materia_id').css('border-color','#F00');
            return false;
        }
		
		/*********************************************************************/
			$.ajax({//Ajax
				  type: 'GET',
				  url: 'PlanTrabjoDocente_html.php',
				  async: false,
				  //dataType: 'json',
				  data:({actionID:'InfoMaterias',Programa_id:Programa_id,
				  							 NumDocumento:NumDocumento,
											 CodigoPeriodo:CodigoPeriodo,
											 Materia_id:Materia_id,
                                             Docente_id:Docente_id}),
				 error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
				 success:function(data){
						$('#Datos').html(data);
			   }
			}); //AJAX
		/*********************************************************************/
		
		}	
function AgregarFila(Plan){
	/********************************************************************************************************/
	var NumFiles   =  parseFloat($('#Index_'+Plan).val());
    var Docente_id  = $('#Docente_id').val();
	/**********************************************************/
	
		var Evidencia	= $('#Evidencia_'+NumFiles+'_'+Plan).val();
		//var Descrip		= $('#Descrip_'+NumFiles+'_'+Plan).val();
		var Fecha		= $('#Fecha_'+NumFiles+'_'+Plan).val();
		//var Porcentaje	= $('#Porcentaje_'+NumFiles).val();
		
		if(!$.trim(Evidencia)){
				alert('Digite la Evidencia...');
				/***********************************************************/
				$('#Evidencia_'+NumFiles).effect("pulsate", {times:3}, 500);
				$('#Evidencia_'+NumFiles).css('border-color','#F00');
				/***********************************************************/
				return false;
			}
			
		/*if(!$.trim(Descrip)){
				alert('Digite la Descripcion de la Evidencia...');
				/***********************************************************/
				/*$('#Descrip_'+NumFiles).effect("pulsate", {times:3}, 500);
				$('#Descrip_'+NumFiles).css('border-color','#F00');
				/***********************************************************/
				/*return false;
			}*/
			
		if(!$.trim(Fecha)){
				alert('Selecione la Fecha de la Evidencia...');
				/***********************************************************/
				$('#Fecha_'+NumFiles).effect("pulsate", {times:3}, 500);
				$('#Fecha_'+NumFiles).css('border-color','#F00');
				/***********************************************************/
				return false;
			}
			
		//if(!$.trim(Porcentaje)){
//				alert('Digite el Porcentaje de la Evidencia...');
//				/***********************************************************/
//				$('#Porcentaje_'+NumFiles).effect("pulsate", {times:3}, 500);
//				$('#Porcentaje_'+NumFiles).css('border-color','#F00');
//				/***********************************************************/
//				return false;
//			}			
	
	/**********************************************************/
	var TblMain    =  document.getElementById("Evidencias_Table");
	var NumFiles   =  parseFloat($('#Index_'+Plan).val()) + 1;
	var NewTr      =  document.createElement("tr");
	NewTr.id       =  'trNewDetalle'+NumFiles;
	
	
	TblMain.appendChild(NewTr);

    $.ajax({
       url: "PlanTrabjoDocente_html.php",
       type: "GET",
       data: "actionID=AddColumnas&Indice="+NumFiles+"&Docente_id="+Docente_id,
       success: function(data){
        $('#Index_'+Plan).val(NumFiles);
			$('#trNewDetalle'+NumFiles).attr('align','center');  
            $('#trNewDetalle'+NumFiles).html(data);
                               
       }
    });
	/*********************************************************************************************************/
	}		
function SaveTemp(op,NameHidden,id_docente){  
		
	var Periodo_id	= $('#Periodo_id').val();	
    
    var Docente_id      = $('#Docente_id').val();  
	
	/**************************************************************/
	if(op==1 || op=='1'){	
	
		var Facultad_id		= $('#Facultad_id').val();
		var Programa_id		= $('#Programa_id').val();
		var Materia_id		= $('#Materia_id').val();
		
		
		if(!$.trim(Facultad_id) || Facultad_id=='-1' || Facultad_id==-1){
			alert('Selecione Una Faculta...');
				/***********************************************************/
				$('#Facultad_id').effect("pulsate", {times:3}, 500);
				$('#Facultad_id').css('border-color','#F00');
				/***********************************************************/
				return false;	
			}
			
		if(!$.trim(Programa_id) || Programa_id=='-1' || Programa_id==-1){
			alert('Selecione Una Programa...');
				/***********************************************************/
				$('#Programa_id').effect("pulsate", {times:3}, 500);
				$('#Programa_id').css('border-color','#F00');
				/***********************************************************/
				return false;	
			}
			
		if(!$.trim(Materia_id)  || Materia_id=='-1' || Materia_id==-1){
			alert('Selecione Una Materia...');
				/***********************************************************/
				$('#Materia_id').effect("pulsate", {times:3}, 500);
				$('#Materia_id').css('border-color','#F00');
				/***********************************************************/
				return false;	
			}
        var HorasSemana  = $('#HorasSemana_'+Materia_id).val(); 
        
        if(!$.trim(HorasSemana)){
            alert('Digite el numero de horas presenciales por semana');
            /***********************************************************/
			$('#HorasSemana_'+Materia_id).effect("pulsate", {times:3}, 500);
			$('#HorasSemana_'+Materia_id).css('border-color','#F00');
			/***********************************************************/
			return false;	
        }
            
        var H_Preparacio  = $('#H_Preparacio_'+Materia_id).val();   
        
        if(!$.trim(H_Preparacio)){
            alert('Digite el numero de horas destinadas a preparacion y evaluacion');
            /***********************************************************/
			$('#H_Preparacio_'+Materia_id).effect("pulsate", {times:3}, 500);
			$('#H_Preparacio_'+Materia_id).css('border-color','#F00');
			/***********************************************************/
			return false;	
        }
		//console.log(nicEditors.findEditor('Accion'));
		
		//document.getElementById('Accion').innerHTML = nicEditors.findEditor('Accion').getContent();
	
		//var Accion				= $('#Accion').val();
		//alert(Accion);
		
       var Accion = CKEDITOR.instances['Accion'].getData();
       
        
      
		if(!$.trim(Accion)){
			/*************************************/
				alert('Digite El Plan De Trabajo...');
				return false;
			/*************************************/
			}
			
		
        C_materia  = Materia_id.split('-');
        	
		/**********************************************AJAX****************************************************/	
		
		 $.ajax({//Ajax
			  type: 'POST',
			  url: 'PlanTrabjoDocente_html.php',
			  async: false,
			  dataType: 'json',
			  data:({actionID:'SaveTemp',
					 Accion:Accion,
					 Facultad_id:Facultad_id,
					 Programa_id:Programa_id,
					 Materia_id:C_materia[0],
					 Periodo_id:Periodo_id,
                     Docente_id:Docente_id,
                     H_Preparacio:H_Preparacio,
                     HorasSemana:HorasSemana,
                     id_docente:id_docente,
                     Grupo:C_materia[1]}),
			 error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
			 success:function(data){
					if(data.val=='FALSE'){
							alert(data.descrip);
							return false;
						}else{
								alert(data.descrip);
								/****************************/
								
								
                               /* var myNicEditor = nicEditors.findEditor('Accion');
                                myNicEditor.setContent(""); */
                                //$('#H_Preparacio_'+Materia_id).attr('disabled',true);
                                //$('#HorasSemana_'+Materia_id).attr('disabled',true);
                                $('#Plan_'+Materia_id).val(data.Last_id);
                                
								AccionesExistentes(Facultad_id,Programa_id,Materia_id,Periodo_id,NameHidden,Docente_id);
                                
								/****************************/
							}
			 }
		  }); //AJAX
		
		/*******************************************AJAX*********************************************************/
	}
	if(op==2 || op=='2'){
		/*********************************************************************/
		var id_CampoDos		= $('#id_CampoDos').val();
		
		if(!$.trim(id_CampoDos)){
		
		var NomProyecto			= $('#NomProyecto').val();
		var TipoProyectoInv		= $('#TipoProyectoInv').val();
		var Hora            = $('#Thsemana').val();
		
		if(!$.trim(NomProyecto)){
			alert('Digite el Nombre del Proyecto...');
				/***********************************************************/
				$('#NomProyecto').effect("pulsate", {times:3}, 500);
				$('#NomProyecto').css('border-color','#F00');
				/***********************************************************/
				return false;	
			}
			
		if(TipoProyectoInv=='-1' || TipoProyectoInv==-1){
			alert('Selecione Una Tipo de Proyecto...');
				/***********************************************************/
				$('#TipoProyectoInv').effect("pulsate", {times:3}, 500);
				$('#TipoProyectoInv').css('border-color','#F00');
				/***********************************************************/
				return false;	
			}
		
        if(!$.trim(Hora)){
			alert('Digite el Numero de Horas...');
				/***********************************************************/
				$('#Thsemana').effect("pulsate", {times:3}, 500);
				$('#Thsemana').css('border-color','#F00');
				/***********************************************************/
				return false;	
			}
        
		var OtroType	= '';
			
		/*if(TipoProyectoInv==5 || TipoProyectoInv=='5'){
			var OtroType	= $('#OtroType').val();
			if(!$.trim(OtroType)){
				alert('Digite Cual ...');
					/***********************************************************/
					/*$('#OtroType').effect("pulsate", {times:3}, 500);
					$('#OtroType').css('border-color','#F00');
					/***********************************************************/
					//return false;	
				//}
		//}		
		
		//console.log(nicEditors.findEditor('Accion'));
        
        var Accion = CKEDITOR.instances['AccionPd'].getData();//$('#AccionPd').val();
        
		/*var Accion = $.trim(document.getElementById('AccionPd').innerHTML = nicEditors.findEditor('AccionPd').getContent());
                   Accion = $("<div/>").html(Accion).text();
                   var find = '<br>';
                   var re = new RegExp(find, 'g');
                   Accion = Accion.replace(re,"");
                   find = '<br/>';
                   re = new RegExp(find, 'g');
                   Accion = Accion.replace(re,"");
                   find = '<br />';
                   re = new RegExp(find, 'g');
                   Accion = Accion.replace(re,"");
                   Accion = $.trim(Accion);	*/
		
		//document.getElementById('Accion').innerHTML = nicEditors.findEditor('Accion').getContent();
	
		//var Accion				= $('#Accion').val();
		//alert(Accion);
		
		if(!$.trim(Accion)){
			/*************************************/
				alert('Digite El Plan De Trabajo...');
				return false;
			/*************************************/
			}
			
			
		/**********************************************AJAX****************************************************/
        
        $.ajax({//Ajax
    		  type: 'POST',
    		  url: 'PlanTrabjoDocente_html.php',
    		  async: false,
    		  dataType: 'json',
    		  data:({actionID:'SaveTempDetalle',
    				 Accion:Accion,
                     Periodo_id:Periodo_id,
                     Docente_id:Docente_id}),
    		 error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
    		 success:function(data){
    				 if(data.val=='FALSE'){
    						alert(data.descrip);
    						return false;
    					}else{
    						
    					   /****************************/
								var Docente_id  = $('#Docente_id').val();
								$('#id_CampoDos').val(data.Last_id);
								
                           /**********************Ajax Interno*******************************/
    						 $.ajax({//Ajax
                    			  type: 'POST',
                    			  url: 'PlanTrabjoDocente_html.php',
                    			  async: false,
                    			  dataType: 'json',
                    			  data:({actionID:'SaveTemp2',
                    					 Accion:Accion,
                    					 NomProyecto:NomProyecto,
                    					 TipoProyectoInv:TipoProyectoInv,
                    					 OtroType:OtroType,
                    					 Periodo_id:Periodo_id,
                                         Last_id:data.Last_id,
                                         Docente_id:Docente_id,
                                         Hora:Hora}),
                    			 error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
                    			 success:function(data){
                    					if(data.val=='FALSE'){
                    							alert(data.descrip);
                    							return false;
                    						}else{
                    						  alert(data.descrip);
                                              AccionesProyecto(Periodo_id,NameHidden,2);
                    						} 
                                         }//data
                                      }); //AJAX       
    						/***********************Fin Ajax Interno*******************************/
    						
    						}
    			  }//data
	     }); //AJAX
        
        	
		
		
		/*******************************************AJAX*********************************************************/
		}//if
		/*********************************************************************/
		}
	if(op==3 || op=='3'){
		/**********************************************************************/
        var NomProyecto_tres  = $('#NomProyecto_tres').val();
        
        if(!$.trim(NomProyecto_tres)){
            
            /***********************************************************/
				$('#NomProyecto_tres').effect("pulsate", {times:3}, 500);
				$('#NomProyecto_tres').css('border-color','#F00');
				/***********************************************************/
				return false;	
            
        }
        
        var TipoProyectoCompromiso  = $('#TipoProyectoCompromiso').val();
        
        if(TipoProyectoCompromiso==-1 || TipoProyectoCompromiso=='-1'){
            /***********************************************************/
				$('#TipoProyectoCompromiso').effect("pulsate", {times:3}, 500);
				$('#TipoProyectoCompromiso').css('border-color','#F00');
				/***********************************************************/
				return false;
        }
        
        var Horas_tres = $('#Thsemana_Tres').val();
        
        if(!$.trim(Horas_tres)){
            
                /***********************************************************/
				$('#Thsemana_Tres').effect("pulsate", {times:3}, 500);
				$('#Thsemana_Tres').css('border-color','#F00');
				/***********************************************************/
				return false;	
            
        }
        
        var Plan  = CKEDITOR.instances['AccionPt'].getData();//$('#AccionPt').val();
        
        if(!$.trim(Plan)){
            /***********************************************************/
    		$('#AccionPt').effect("pulsate", {times:3}, 500);
    		$('#AccionPt').css('border-color','#F00');
    		/***********************************************************/
    		return false;	  
        }
        
        /**********************************************AJAX****************************************************/
        
        $.ajax({//Ajax
    		  type: 'POST',
    		  url: 'PlanTrabjoDocente_html.php',
    		  async: false,
    		  dataType: 'json',
    		  data:({actionID:'SaveTempDetalle',
    				 Accion:Plan,
                     Periodo_id:Periodo_id,
                     Docente_id:Docente_id}),
    		 error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
    		 success:function(data){
    				 if(data.val=='FALSE'){
    						alert(data.descrip);
    						return false;
    					}else{
    						
    					   /****************************/
								var Docente_id  = $('#Docente_id').val();
								$('#Campo_id_Tres').val(data.Last_id);
								
                           /**********************Ajax Interno*******************************/
    						 $.ajax({//Ajax
                    			  type: 'POST',
                    			  url: 'PlanTrabjoDocente_html.php',
                    			  async: false,
                    			  dataType: 'json',
                    			  data:({actionID:'SaveTemp3', 
                                         NomProyecto:NomProyecto_tres,
                    					 TipoProyectoInv:TipoProyectoCompromiso,
                    					 Periodo_id:Periodo_id,
                                         Last_id:data.Last_id,
                                         Docente_id:Docente_id,
                                         Hora:Horas_tres}),
                    			 error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
                    			 success:function(data){
                    					if(data.val=='FALSE'){
                    							alert(data.descrip);
                    							return false;
                    						}else{
                    						  alert(data.descrip);
                                              AccionesProyecto(Periodo_id,NameHidden,3);
                    						} 
                                         }//data
                                      }); //AJAX       
    						/***********************Fin Ajax Interno*******************************/
    						
    						}
    			  }//data
	     }); //AJAX
		/*******************************************AJAX*********************************************************/
        
		/**********************************************************************/
		}
	if(op==4 || op=='4'){
		/**********************************************************************/
        var AADesarrolladas     = $('#AADesarrolladas').val();
        
        if(!$.trim(AADesarrolladas)){
            /***********************************************************/
    		$('#AADesarrolladas').effect("pulsate", {times:3}, 500);
    		$('#AADesarrolladas').css('border-color','#F00');
    		/***********************************************************/
    		return false;	  
        }
        
        var Hora        = $('#Thsemana_Des').val();
        
        if(!$.trim(Hora)){
            /***********************************************************/
    		$('#Thsemana_Des').effect("pulsate", {times:3}, 500);
    		$('#Thsemana_Des').css('border-color','#F00');
    		/***********************************************************/
    		return false;	  
        }
        
        var Plan        = CKEDITOR.instances['AccionPc'].getData();//$('#AccionPc').val();
        
        if(!$.trim(Plan)){
            /***********************************************************/
    		$('#AccionPc').effect("pulsate", {times:3}, 500);
    		$('#AccionPc').css('border-color','#F00');
    		/***********************************************************/
    		return false;	  
        }
        
        /**********************************************AJAX****************************************************/
        
        $.ajax({//Ajax
    		  type: 'POST',
    		  url: 'PlanTrabjoDocente_html.php',
    		  async: false,
    		  dataType: 'json',
    		  data:({actionID:'SaveTempDetalle',
    				 Accion:Plan,
                     Periodo_id:Periodo_id,
                     Docente_id:Docente_id}),
    		 error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
    		 success:function(data){
    				 if(data.val=='FALSE'){
    						alert(data.descrip);
    						return false;
    					}else{
    						
    					   /****************************/
								var Docente_id  = $('#Docente_id').val();
                                
								$('#Campo_Cuatro_id').val(data.Last_id);
								
                           /**********************Ajax Interno*******************************/
    						 $.ajax({//Ajax
                    			  type: 'POST',
                    			  url: 'PlanTrabjoDocente_html.php',
                    			  async: false,
                    			  dataType: 'json',
                    			  data:({actionID:'SaveTemp4', 
                                         NomProyecto:AADesarrolladas,Periodo_id:Periodo_id,
                                         Last_id:data.Last_id,
                                         Docente_id:Docente_id,
                                         Hora:Hora}),
                    			 error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
                    			 success:function(data){
                    					if(data.val=='FALSE'){
                    							alert(data.descrip);
                    							return false;
                    						}else{
                    						  alert(data.descrip);
                                              AccionesProyecto(Periodo_id,NameHidden,4);
                    						} 
                                         }//data
                                      }); //AJAX       
    						/***********************Fin Ajax Interno*******************************/
    						
    						}
    			  }//data
	     }); //AJAX
        
		/*******************************************AJAX*********************************************************/
		/**********************************************************************/
		}
	/**************************************************************/
	}
function AccionesExistentes(Facultad_id,Programa_id,Materia_id,Periodo_id,NameHidden,Docente_id){
		/**********************************************AJAX****************************************************/	
		
		 $.ajax({//Ajax
			  type: 'POST',
			  url: 'PlanTrabjoDocente_html.php',
			  async: false,
			  //dataType: 'json',
			  data:({actionID:'AcionesExixtentes',
			  		 Facultad_id:Facultad_id,
					 Programa_id:Programa_id,
					 Materia_id:Materia_id,
					 Periodo_id:Periodo_id,
					 NameHidden:NameHidden,
                     Docente_id:Docente_id}),
			 error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
			 success:function(data){
				 	$('#Acci_Temp').css('display','block');
					$('#AcionesTemp').html(data);
			 }
		  }); //AJAX
		
		/*******************************************AJAX*********************************************************/
	}
function Color(i){
	/**************************************/
		$('#Accion_'+i).css('background-color','#999');
	/**************************************/
	}
function SinColor(i){
	/**************************************/
		$('#Accion_'+i).css('background-color','#FFF');
	/**************************************/
	}		
function Visualizar(id,i,Docente_id,Disable){
	/******************************************************************/
 
		 $.ajax({//Ajax
			  type: 'POST',
			  url: 'PlanTrabjoDocente_html.php',
			  async: false,
			  //dataType: 'json',
			  data:({actionID:'VisualizarTemp',id:id,i:i,Docente_id:Docente_id}),
			 error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
			 success:function(data){
				 	$('#TablaDinamic').css('display','none')
					$('#CaragarEvidenciaTemp').css('display','inline');
				 	$('#CaragarEvidenciaTemp').css('margin','0 auto');
					$('#CaragarEvidenciaTemp').html(data);
			 }
		  }); //AJAX
	
	/******************************************************************/
	}	
function EvidenciaSaveTemp(PlanTrabajo){
    //alert('PlanTrabajo->'+PlanTrabajo);
    /**************************************************************/
    var Docente_id      = $('#Docente_id').val();
    
    var Index  = $('#Index_'+PlanTrabajo).val();
    
    var inicio  = $('#inicio_'+PlanTrabajo).val();
    
    
    $('#Cadena_Evidencias_'+PlanTrabajo).val('');
    
    for(i=inicio;i<=Index;i++){
        /********************************/
        var Evidencia   = $('#Evidencia_'+i+'_'+PlanTrabajo).val();
        var Fecha       = $('#Fecha_'+i+'_'+PlanTrabajo).val();
        
        if(!$.trim(Evidencia) || !$.trim(Fecha)){
           if(confirm('Hay Evidencias o fechas en Blanco \n Desea continuar.')){
            /*******************************************************************/
                if($.trim(Evidencia) && $.trim(Fecha)){
                    /********************************/
                    $('#Cadena_Evidencias_'+PlanTrabajo).val($('#Cadena_Evidencias_'+PlanTrabajo).val()+'::'+Evidencia+';'+Fecha+';'+i);
                    /********************************/
                }
            /*******************************************************************/
           }else{
            /******************************/
            $('#Cadena_Evidencias_'+PlanTrabajo).val('');
            /******************************/
            return false;
           }
           
        }else{
             /********************************/
            $('#Cadena_Evidencias_'+PlanTrabajo).val($('#Cadena_Evidencias_'+PlanTrabajo).val()+'::'+Evidencia+';'+Fecha+';'+i);
            /********************************/
        }
        
    }
  
    var Cadena_Evidencias  = $('#Cadena_Evidencias_'+PlanTrabajo).val();
    
   
    
    if(!$.trim(Cadena_Evidencias)){
        alert('No hay Evidencias');
        return false;
    }
    /**************************************************************/
    $.ajax({//Ajax
    	  type: 'POST',
    	  url: 'PlanTrabjoDocente_html.php',
    	  async: false,
    	  dataType: 'json',
    	  data:({actionID:'EvidenciaSave',
    			 PlanTrabajo_id:PlanTrabajo,
    			 Cadena_Evidencias:Cadena_Evidencias,
                 Docente_id:Docente_id}),
    	 error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
    	 success:function(data){ //descrip
    			if(data.val=='FALSE'){
					alert(data.descrip);
					return false;
				}else{
				    alert(data.descrip);
                    
				}
    		  }
	 }); //AJAX
    /**************************************************************/
}

	
 function isNumberKey(evt){
			var e = evt; 
			var charCode = (e.which) ? e.which : e.keyCode
				console.log(charCode);
				
				//el comentado me acepta negativos
			//if ( (charCode > 31 && (charCode < 48 || charCode > 57)) ||  charCode == 109 || charCode == 173 )
				if( charCode > 31 && (charCode < 48 || charCode > 57) ){
					//si no es - ni borrar
					if((charCode!=8 && charCode!=45)){
						return false;
					}
				}
		
			return true;
		}
function VerAcionesTemp(NameHidden){
	
		var Periodo_id		= $('#Periodo_id').val();
		var Facultad_id		= $('#Facultad_id').val();
		var Programa_id		= $('#Programa_id').val();
		var Materia_id		= $('#Materia_id').val();
        var Docente_id      = $('#Docente_id').val();
		
		AccionesExistentes(Facultad_id,Programa_id,Materia_id,Periodo_id,NameHidden,Docente_id);
	
	}	
function Close(){
	/******************************************************************/
	
		
	//$('#TablaDinamic').css('display','inline');
	$('#CaragarEvidenciaTemp').css('display','none');
		
	
	/******************************************************************/
	}		
function FormatBox(id_Box,id_Form){
	/**********************************************************/
		$('#'+id_Form+' #'+id_Box).val('');
        
        if(id_Box=='AADesarrolladas'){
            /******************************/
            $('#Thsemana_Des').val('');
            $('#Thsemana_Des').attr('disabled',false);
            $('#CaragarEvidenciaTempCuatro').css('display','none');
            $('#TablaDinamic_Cuatro').css('display','inline');
            /******************************/
        }//if
        if(id_Box=='NomProyecto'){
           /******************************/
            $('#TipoProyectoInv').val('-1');
            $('#TipoProyectoInv').attr('disabled',false);
            $('#Thsemana').val('');
            $('#Thsemana').attr('disabled',false);
            $('#CaragarEvidenciaTempDos').css('display','none');
            $('#TablaDinamic_Dos').css('display','inline');
            $('#Plan_Descubrimiento').val('');
            /******************************/ 
        }//if
        if(id_Box=='NomProyecto_tres'){
           /******************************/
            $('#TipoProyectoCompromiso').val('-1');
            $('#TipoProyectoCompromiso').attr('disabled',false);
            $('#Thsemana_Tres').val('');
            $('#Thsemana_Tres').attr('disabled',false);
            $('#CaragarEvidenciaTempTres').css('display','none');
            $('#TablaDinamic_Tres').css('display','inline');
            /******************************/ 
        }//if
        
	/**********************************************************/
	}	
function FormatBoxEvidencia(id_Box){
	/**********************************************************/
		$('#'+id_Box).val('');
	/**********************************************************/
	}	
function CajaVer(){
	/********************************************/
		var SelectType	= $('#TipoProyectoCompromiso').val();
		
		if(SelectType=='6' || SelectType==6){
				$('#Tr_CualType').css('visibility','visible');
				$('#CualType').val('');
			}else{
					$('#CualType').val('');
					$('#Tr_CualType').css('visibility','collapse');
				}
	/********************************************/
	}	
/*function OtroType(){
	/********************************************/
		//var SelectType	= $('#TipoProyectoInv').val();
		
		//if(SelectType=='5' || SelectType==5){
				//$('#Tr_OtroType').css('visibility','visible');
				//$('#OtroType').val('');
			//}else{
					//$('#OtroType').val('');
					//$('#Tr_OtroType').css('visibility','collapse');
				//}
	/********************************************/
	//}	
function Guardar(name_id,op){
	
	var Periodo_id	= $('#Periodo_id').val();	
	
	/**************************Save Primera Pestaña************************************/
	if(op==1 || op=='1'){
		/**********************************************************/
			var Cadena	= $('#CadenaTableUno').val();
            var Materia_id		= $('#Materia_id').val();
            
            if(!$.trim(Materia_id)  || Materia_id=='-1' || Materia_id==-1){
    			alert('Selecione Una Materia...');
    				/***********************************************************/
    				$('#Materia_id').effect("pulsate", {times:3}, 500);
    				$('#Materia_id').css('border-color','#F00');
    				/***********************************************************/
    				return false;	
    			}
            
            var PlanTrabajo_id  = $('#Plan_'+Materia_id).val();
            
            var Docente_id      = $('#Docente_id').val();
            
            //alert('PlanTrabajo_id->'+PlanTrabajo_id+'\n Docente_id->'+Docente_id);
            
            var PorcentajeUno	= $('#PorcentajeUno').val();
            
            var Auto = CKEDITOR.instances['Auto'].getData();//$('#Auto').val();
            var Consolidado = CKEDITOR.instances['Consolidado'].getData();//$('#Consolidado').val();
            var Mejora =  CKEDITOR.instances['Mejora'].getData();//$('#Mejora').val();
			
			/*var Auto = $.trim(document.getElementById('Auto').innerHTML = nicEditors.findEditor('Auto').getContent());
            
            alert('Auto->'+Auto);    
                   Auto = $("<div/>").html(Auto).text();
                   var find = '<br>';
                   var re = new RegExp(find, 'g');
                   Auto = Auto.replace(re,"");
                   find = '<br/>';
                   re = new RegExp(find, 'g');
                   Auto = Auto.replace(re,"");
                   find = '<br />';
                   re = new RegExp(find, 'g');
                   Auto = Auto.replace(re,"");
                   Auto = $.trim(Auto);	
               
				   
				   
			
			var Consolidado = $.trim(document.getElementById('Consolidado').innerHTML = nicEditors.findEditor('Consolidado').getContent());
                   Consolidado = $("<div/>").html(Consolidado).text();
                   var find = '<br>';
                   var re = new RegExp(find, 'g');
                   Consolidado = Consolidado.replace(re,"");
                   find = '<br/>';
                   re = new RegExp(find, 'g');
                   Consolidado = Consolidado.replace(re,"");
                   find = '<br />';
                   re = new RegExp(find, 'g');
                   Consolidado = Consolidado.replace(re,"");
                   Consolidado = $.trim(Consolidado);	
				   
			var Mejora = $.trim(document.getElementById('Mejora').innerHTML = nicEditors.findEditor('Mejora').getContent());
                   Mejora = $("<div/>").html(Mejora).text();
                   var find = '<br>';
                   var re = new RegExp(find, 'g');
                   Mejora = Mejora.replace(re,"");
                   find = '<br/>';
                   re = new RegExp(find, 'g');
                   Mejora = Mejora.replace(re,"");
                   find = '<br />';
                   re = new RegExp(find, 'g');
                   Mejora = Mejora.replace(re,"");
                   Mejora = $.trim(Mejora);	*/
				   	   
			/***************************Ajax***************************************************************/	   
			
		 $.ajax({//Ajax
			  type: 'POST',
			  url: 'PlanTrabjoDocente_html.php',
			  async: false,
			  dataType: 'json',
			  data:({actionID:'SaveTabUno',
					 Cadena:Cadena,
					 Auto:Auto,
					 PorcentajeUno:PorcentajeUno,
					 Consolidado:Consolidado,
					 Mejora:Mejora,
					 Periodo_id:Periodo_id,
                     PlanTrabajo_id:PlanTrabajo_id,
                     Docente_id:Docente_id}),
			 error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
			 success:function(data){
					if(data.val=='FALSE'){
							alert(data.descrip);
							return false;
						}else{
								alert(data.descrip);
								/****************************/
                                //var myNicEditor = nicEditors.findEditor('Auto');
                                //myNicEditor.setContent(""); 
								/****************************/
								/****************************/
                                //var myNicEditor = nicEditors.findEditor('Consolidado');
                                //myNicEditor.setContent(""); 
								/****************************/
								/****************************/
                                //var myNicEditor = nicEditors.findEditor('Mejora');
                                //myNicEditor.setContent(""); 
								/****************************/
								
								$('#'+name_id).css('display','none');
							}
			 }
		  }); //AJAX
			
			/****************************Fin Ajax***************************************************************/	   
		/**********************************************************/
		}
	/***************************Save Segunda Pestaña***********************************/
	if(op==2 || op=='2'){
		/**********************************************************/
			var Cadena	= $('#id_CampoDos').val();
            var Docente_id      = $('#Docente_id').val();
			
            var Auto = CKEDITOR.instances['AutoPd'].getData();//$('#AutoPd').val();
			/*var Auto = $.trim(document.getElementById('AutoPd').innerHTML = nicEditors.findEditor('AutoPd').getContent());
                   Auto = $("<div/>").html(Auto).text();
                   var find = '<br>';
                   var re = new RegExp(find, 'g');
                   Auto = Auto.replace(re,"");
                   find = '<br/>';
                   re = new RegExp(find, 'g');
                   Auto = Auto.replace(re,"");
                   find = '<br />';
                   re = new RegExp(find, 'g');
                   Auto = Auto.replace(re,"");
                   Auto = $.trim(Auto);	*/
				   
			var PorcentajeUno	= $('#PorcentajeDos').val();
            
            var Consolidado = CKEDITOR.instances['ConsolidadoPd'].getData();//$('#ConsolidadoPd').val(); 	   
			
			/*var Consolidado = $.trim(document.getElementById('ConsolidadoPd').innerHTML = nicEditors.findEditor('ConsolidadoPd').getContent());
                   Consolidado = $("<div/>").html(Consolidado).text();
                   var find = '<br>';
                   var re = new RegExp(find, 'g');
                   Consolidado = Consolidado.replace(re,"");
                   find = '<br/>';
                   re = new RegExp(find, 'g');
                   Consolidado = Consolidado.replace(re,"");
                   find = '<br />';
                   re = new RegExp(find, 'g');
                   Consolidado = Consolidado.replace(re,"");
                   Consolidado = $.trim(Consolidado);*/	
                   
            var Mejora =  CKEDITOR.instances['MejoraPd'].getData();//$('#MejoraPd').val();       
				   
			/*var Mejora = $.trim(document.getElementById('MejoraPd').innerHTML = nicEditors.findEditor('MejoraPd').getContent());
                   Mejora = $("<div/>").html(Mejora).text();
                   var find = '<br>';
                   var re = new RegExp(find, 'g');
                   Mejora = Mejora.replace(re,"");
                   find = '<br/>';
                   re = new RegExp(find, 'g');
                   Mejora = Mejora.replace(re,"");
                   find = '<br />';
                   re = new RegExp(find, 'g');
                   Mejora = Mejora.replace(re,"");
                   Mejora = $.trim(Mejora);	*/
				   	   
			/***************************Ajax***************************************************************/	   
			
		 $.ajax({//Ajax
			  type: 'POST',
			  url: 'PlanTrabjoDocente_html.php',
			  async: false,
			  dataType: 'json',
			  data:({actionID:'SaveTabDos',
					 Cadena:Cadena,
					 Auto:Auto,
					 PorcentajeUno:PorcentajeUno,
					 Consolidado:Consolidado,
					 Mejora:Mejora,
					 Periodo_id:Periodo_id,
                     Docente_id:Docente_id}),
			 error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
			 success:function(data){
					if(data.val=='FALSE'){
							alert(data.descrip);
							return false;
						}else{
								alert(data.descrip);
								/****************************/
                                /*var myNicEditor = nicEditors.findEditor('AutoPd');
                                myNicEditor.setContent(""); */
								/****************************/
								/****************************/
                                /*var myNicEditor = nicEditors.findEditor('ConsolidadoPd');
                                myNicEditor.setContent("");*/ 
								/****************************/
								/****************************/
                                /*var myNicEditor = nicEditors.findEditor('MejoraPd');
                                myNicEditor.setContent(""); */
								/****************************/
								
								$('#'+name_id).css('display','none');
							}
			 }
		  }); //AJAX
			
			/****************************Fin Ajax***************************************************************/
		/**********************************************************/
		}
	/************************Save Tercera Pestaña**************************************/
	if(op==3 || op=='3'){
		/**********************************************************/
			var Cadena	= $('#Campo_id_Tres').val();
			
            var Docente_id      = $('#Docente_id').val();
            
            var Auto = CKEDITOR.instances['AutoPt'].getData();//$('#AutoPt').val();
			/*var Auto = $.trim(document.getElementById('AutoPt').innerHTML = nicEditors.findEditor('AutoPt').getContent());
                   Auto = $("<div/>").html(Auto).text();
                   var find = '<br>';
                   var re = new RegExp(find, 'g');
                   Auto = Auto.replace(re,"");
                   find = '<br/>';
                   re = new RegExp(find, 'g');
                   Auto = Auto.replace(re,"");
                   find = '<br />';
                   re = new RegExp(find, 'g');
                   Auto = Auto.replace(re,"");
                   Auto = $.trim(Auto);	*/
				   
			var PorcentajeUno	= $('#PorcentajeTres').val();	   
			var Consolidado =  CKEDITOR.instances['ConsolidadoPt'].getData();//$('#ConsolidadoPt').val();
			/*var Consolidado = $.trim(document.getElementById('ConsolidadoPt').innerHTML = nicEditors.findEditor('ConsolidadoPt').getContent());
                   Consolidado = $("<div/>").html(Consolidado).text();
                   var find = '<br>';
                   var re = new RegExp(find, 'g');
                   Consolidado = Consolidado.replace(re,"");
                   find = '<br/>';
                   re = new RegExp(find, 'g');
                   Consolidado = Consolidado.replace(re,"");
                   find = '<br />';
                   re = new RegExp(find, 'g');
                   Consolidado = Consolidado.replace(re,"");
                   Consolidado = $.trim(Consolidado);*/	
			var Mejora = CKEDITOR.instances['MejoraPt'].getData();//$('#MejoraPt').val();	   
		/*	var Mejora = $.trim(document.getElementById('MejoraPt').innerHTML = nicEditors.findEditor('MejoraPt').getContent());
                   Mejora = $("<div/>").html(Mejora).text();
                   var find = '<br>';
                   var re = new RegExp(find, 'g');
                   Mejora = Mejora.replace(re,"");
                   find = '<br/>';
                   re = new RegExp(find, 'g');
                   Mejora = Mejora.replace(re,"");
                   find = '<br />';
                   re = new RegExp(find, 'g');
                   Mejora = Mejora.replace(re,"");
                   Mejora = $.trim(Mejora);	*/
				   	   
			/***************************Ajax***************************************************************/	   
			
		 $.ajax({//Ajax
			  type: 'POST',
			  url: 'PlanTrabjoDocente_html.php',
			  async: false,
			  dataType: 'json',
			  data:({actionID:'SaveTabTres',
					 Cadena:Cadena,
					 Auto:Auto,
					 PorcentajeUno:PorcentajeUno,
					 Consolidado:Consolidado,
					 Mejora:Mejora,
					 Periodo_id:Periodo_id,
                     Docente_id:Docente_id}),
			 error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
			 success:function(data){
					if(data.val=='FALSE'){
							alert(data.descrip);
							return false;
						}else{
								alert(data.descrip);
								/****************************/
                                //var myNicEditor = nicEditors.findEditor('AutoPt');
                                //myNicEditor.setContent(""); 
								/****************************/
								/****************************/
                                /*var myNicEditor = nicEditors.findEditor('ConsolidadoPt');
                                myNicEditor.setContent(""); */
								/****************************/
								/****************************/
                                /*var myNicEditor = nicEditors.findEditor('MejoraPt');
                                myNicEditor.setContent(""); */
								/****************************/
								
								$('#'+name_id).css('display','none');
							}
			 }
		  }); //AJAX
			
			/****************************Fin Ajax***************************************************************/
		/**********************************************************/
		}
	/************************Save Cuarta Pestaña**************************************/
	if(op==4 || op=='4'){
		/**********************************************************/
			var Cadena	= $('#Campo_Cuatro_id').val();
            
            var Docente_id      = $('#Docente_id').val();
			
            var Auto =  CKEDITOR.instances['AutoPc'].getData();//$('#AutoPc').val();
			/*var Auto = $.trim(document.getElementById('AutoPc').innerHTML = nicEditors.findEditor('AutoPc').getContent());
                   Auto = $("<div/>").html(Auto).text();
                   var find = '<br>';
                   var re = new RegExp(find, 'g');
                   Auto = Auto.replace(re,"");
                   find = '<br/>';
                   re = new RegExp(find, 'g');
                   Auto = Auto.replace(re,"");
                   find = '<br />';
                   re = new RegExp(find, 'g');
                   Auto = Auto.replace(re,"");
                   Auto = $.trim(Auto);	*/
				   
			var PorcentajeUno	= $('#PorcentajeCuatro').val();	
            
            var Consolidado = CKEDITOR.instances['ConsolidadoPc'].getData();//$('#ConsolidadoPc').val();   
			
			/*var Consolidado = $.trim(document.getElementById('ConsolidadoPc').innerHTML = nicEditors.findEditor('ConsolidadoPc').getContent());
                   Consolidado = $("<div/>").html(Consolidado).text();
                   var find = '<br>';
                   var re = new RegExp(find, 'g');
                   Consolidado = Consolidado.replace(re,"");
                   find = '<br/>';
                   re = new RegExp(find, 'g');
                   Consolidado = Consolidado.replace(re,"");
                   find = '<br />';
                   re = new RegExp(find, 'g');
                   Consolidado = Consolidado.replace(re,"");
                   Consolidado = $.trim(Consolidado);	*/
			var Mejora = CKEDITOR.instances['MejoraPc'].getData();//$('#MejoraPc').val();	   
			/*var Mejora = $.trim(document.getElementById('MejoraPc').innerHTML = nicEditors.findEditor('MejoraPc').getContent());
                   Mejora = $("<div/>").html(Mejora).text();
                   var find = '<br>';
                   var re = new RegExp(find, 'g');
                   Mejora = Mejora.replace(re,"");
                   find = '<br/>';
                   re = new RegExp(find, 'g');
                   Mejora = Mejora.replace(re,"");
                   find = '<br />';
                   re = new RegExp(find, 'g');
                   Mejora = Mejora.replace(re,"");
                   Mejora = $.trim(Mejora);	*/
				   	   
			/***************************Ajax***************************************************************/	   
			
		 $.ajax({//Ajax
			  type: 'POST',
			  url: 'PlanTrabjoDocente_html.php',
			  async: false,
			  dataType: 'json',
			  data:({actionID:'SaveTabCuatro',
					 Cadena:Cadena,
					 Auto:Auto,
					 PorcentajeUno:PorcentajeUno,
					 Consolidado:Consolidado,
					 Mejora:Mejora,
					 Periodo_id:Periodo_id,
                     Docente_id:Docente_id}),
			 error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
			 success:function(data){
					if(data.val=='FALSE'){
							alert(data.descrip);
							return false;
						}else{
								alert(data.descrip);
								/****************************/
                                //var myNicEditor = nicEditors.findEditor('AutoPc');
                                //myNicEditor.setContent(""); 
								/****************************/
								/****************************/
                                //var myNicEditor = nicEditors.findEditor('ConsolidadoPc');
                                //myNicEditor.setContent(""); 
								/****************************/
								/****************************/
                                //var myNicEditor = nicEditors.findEditor('MejoraPc');
                                //myNicEditor.setContent(""); 
								/****************************/  
								
								$('#'+name_id).css('display','none');
							}
			 }
		  }); //AJAX
			
			/****************************Fin Ajax***************************************************************/
		/**********************************************************/
		}
	/**************************************************************/
	}
function AccionesProyecto(Periodo_id,NameHidden,op){
	/******************************************************************/
		if(op==2  || op=='2'){
		  
				var id_CampoDos		= $('#id_CampoDos').val();
				
				var Docente_id      = $('#Docente_id').val();
				/**********************Ajax Interno*******************************/
								
				 $.ajax({//Ajax
						  type: 'POST',
						  url: 'PlanTrabjoDocente_html.php',
						  async: false,
						  //dataType: 'json',
						  data:({actionID:'AccExistentes',
								 id:id_CampoDos,
								 Periodo_id:Periodo_id,
                                 Docente_id:Docente_id}),
						 error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
						 success:function(data){
								 $('#Acci_TempDos').css('display','inline');
								 $('#AcionesTempDos').html(data);
							  }
						 }); //AJAX
				
				/***********************Fin Ajax Interno*******************************/
				
			}
        if(op==3  || op=='3'){
		  
				var id_CampoDos		= $('#Campo_id_Tres').val();
				
				var Docente_id      = $('#Docente_id').val();
				/**********************Ajax Interno*******************************/
								
				 $.ajax({//Ajax
						  type: 'POST',
						  url: 'PlanTrabjoDocente_html.php',
						  async: false,
						  //dataType: 'json',
						  data:({actionID:'AccExistentesTres',
								 id:id_CampoDos,
								 Periodo_id:Periodo_id,
                                 Docente_id:Docente_id}),
						 error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
						 success:function(data){
								 $('#Acci_TempTres').css('display','inline');
								 $('#AcionesTempTres').html(data);
							  }
						 }); //AJAX
				
				/***********************Fin Ajax Interno*******************************/
				
			}  
         if(op==4  || op=='4'){
		  
				var id_CampoDos		= $('#Campo_Cuatro_id').val();
				
				var Docente_id      = $('#Docente_id').val();
				/**********************Ajax Interno*******************************/
								
				 $.ajax({//Ajax
						  type: 'POST',
						  url: 'PlanTrabjoDocente_html.php',
						  async: false,
						  //dataType: 'json',
						  data:({actionID:'AccExistentesCuatro',
								 id:id_CampoDos,
								 Periodo_id:Periodo_id,
                                 Docente_id:Docente_id}),
						 error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
						 success:function(data){
								 $('#Acci_TempCuatro').css('display','inline');
								 $('#AcionesTempCuatro').html(data);
							  }
						 }); //AJAX
				
				/***********************Fin Ajax Interno*******************************/
				
			}      
	/******************************************************************/
	}
function AutoCompleteProyecto(){
	
	var Periodo_id	= $('#Periodo_id').val();
    var Docente_id  = $('#Docente_id').val();	
	
	/*************************************************************/
	$('#NomProyecto').autocomplete({
					
			source: "PlanTrabjoDocente_html.php?actionID=AutoCompleteProyecto&Periodo_id="+Periodo_id+"&Docente_id="+Docente_id,
			minLength: 3,
			select: function( event, ui ) {
				
				$('#id_CampoDos').val(ui.item.idProyecto);
				
                $('#TipoProyectoInv').val(ui.item.tipo);
                $('#TipoProyectoInv').attr('disabled',true);
                $('#Thsemana').val(ui.item.Horas);
                $('#Plan_Descubrimiento').val(ui.item.idProyecto)
                //$('#Thsemana').attr('disabled',true)
                
                
                VisualizarDos(ui.item.plantrabajo_id,'2',Docente_id);
                
				}
			
		});
	/*************************************************************/
	}
  function AutoCompleteTres(){
    
    var Periodo_id	= $('#Periodo_id').val();
    var Docente_id  = $('#Docente_id').val();	
	
	/*************************************************************/
	$('#NomProyecto_tres').autocomplete({
					
			source: "PlanTrabjoDocente_html.php?actionID=AutoCompleteTres&Periodo_id="+Periodo_id+"&Docente_id="+Docente_id,
			minLength: 3,
			select: function( event, ui ) {
				
				$('#Campo_id_Tres').val(ui.item.idProyecto);
				
                $('#TipoProyectoCompromiso').val(ui.item.tipo);
                $('#TipoProyectoCompromiso').attr('disabled',true);
                $('#Thsemana_Tres').val(ui.item.Horas);
                //$('#Thsemana_Tres').attr('disabled',true)
                $('#PlanCompromiso').val(ui.item.idProyecto);
                
                
                VisualizarTres(ui.item.plantrabajo_id,'3',Docente_id);
                
				}
			
		});
	/*************************************************************/
    
  }  
 function AutoCompletDesarrollo(){
    var Periodo_id	= $('#Periodo_id').val();
    var Docente_id  = $('#Docente_id').val();	
	
	/*************************************************************/
	$('#AADesarrolladas').autocomplete({
					
			source: "PlanTrabjoDocente_html.php?actionID=AutoCompleteCuatro&Periodo_id="+Periodo_id+"&Docente_id="+Docente_id,
			minLength: 3,
			select: function( event, ui ) {
				
				$('#Campo_Cuatro_id').val(ui.item.idProyecto);
				
                
                $('#Thsemana_Des').val(ui.item.Horas);
                //$('#Thsemana_Des').attr('disabled',true);
                $('#PlanGestion').val(ui.item.idProyecto);
                
                
                VisualizarCuatro(ui.item.plantrabajo_id,'4',Docente_id);
                
				}
			
		});
	/*************************************************************/
 } 		
  function GargarArchivo(i,plan){
    ;
    /************************************************/
    var PlanTrabajo_id  = plan;
    var Docente_id  = $('#Docente_id').val();
    /************************************************/
    var url  = 'CarcarEvidencia.php?PlanTrabajo_id='+PlanTrabajo_id+'&index='+i+'&Docente_id='+Docente_id;
        var centerWidth = (window.screen.width - 850) / 2;
        var centerHeight = (window.screen.height - 700) / 2;
        
        var opciones="toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=850, height=700, top="+centerHeight+", left="+centerWidth;
        var mypopup = window.open(url,"",opciones);
        //para poner la ventana en frente
        window.focus();
        mypopup.focus();
    /************************************************/
  }/*function GargarArchivo*/	
  function Refresh(i,j){
    /************************************************/
    var PlanTrabajo_id  = $('#id_PlanTrabajo_'+j).val();
    var Docente_id      = $('#Docente_id').val();
    /************************************************/
    $.ajax({//Ajax
    	  type: 'POST',
    	  url: 'PlanTrabjoDocente_html.php',
    	  async: false,
    	  dataType: 'html',
    	  data:({actionID:'Archivos',
    			 PlanTrabajo_id:PlanTrabajo_id,
    			 index:i,
                 Docente_id:Docente_id}),
    	 error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
    	 success:function(data){ 
    			 $('#Refesh_Div_'+i).css('display','inline');
                 $('#Refesh_Div_'+i).html(data);
    		  }
	 }); //AJAX
    /************************************************/
  }//Refresh
 function VisualizarDos(id,i,Docente_id){
	/******************************************************************/
	$("#TablaDinamic_Dos").css("display","none");
		 $.ajax({//Ajax
			  type: 'POST',
			  url: 'PlanTrabjoDocente_html.php',
			  async: false,
			  //dataType: 'json',
			  data:({actionID:'VisualizarTemp',id:id,i:i,Docente_id:Docente_id}),
			 error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
			 success:function(data){
				 	//$('#TablaDinamic').css('display','none')
					$('#CaragarEvidenciaTempDos').css('display','inline');
				 	$('#CaragarEvidenciaTempDos').css('margin','0 auto');
					$('#CaragarEvidenciaTempDos').html(data);
			 }
		  }); //AJAX
	
	/******************************************************************/
	}
    function VisualizarTres(id,i,Docente_id){
	/******************************************************************/
	$("#TablaDinamic_Tres").css("display","none");
		 $.ajax({//Ajax
			  type: 'POST',
			  url: 'PlanTrabjoDocente_html.php',
			  async: false,
			  //dataType: 'json',
			  data:({actionID:'VisualizarTemp',id:id,i:i,Docente_id:Docente_id}),
			 error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
			 success:function(data){
				 	//$('#TablaDinamic').css('display','none')
					$('#CaragarEvidenciaTempTres').css('display','inline');
				 	$('#CaragarEvidenciaTempTres').css('margin','0 auto');
					$('#CaragarEvidenciaTempTres').html(data);
			 }
		  }); //AJAX
	
	/******************************************************************/
	}
    function VisualizarCuatro(id,i,Docente_id){
        
        /******************************************************************/
	$("#TablaDinamic_Cuatro").css("display","none");
    
		 $.ajax({//Ajax
			  type: 'POST',
			  url: 'PlanTrabjoDocente_html.php',
			  async: false,
			  //dataType: 'json',
			  data:({actionID:'VisualizarTemp',id:id,i:i,Docente_id:Docente_id}),
			 error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
			 success:function(data){
				 	//$('#TablaDinamic').css('display','none')
					$('#CaragarEvidenciaTempCuatro').css('display','inline');
				 	$('#CaragarEvidenciaTempCuatro').css('margin','0 auto');
					$('#CaragarEvidenciaTempCuatro').html(data);
			 }
		  }); //AJAX
	
	/******************************************************************/
    }	 
   function Suma(m){ 
    /***************************************************/
    var T_horas         = $('#HorasSemana_'+m).val();
    var H_Preparacio    = $('#H_Preparacio_'+m).val();
    var Plan            = $('#Plan_'+m).val();
    var Docente_id      = $('#Docente_id').val();
    //alert('T_horas->'+T_horas+'\n H_Preparacio->'+H_Preparacio);
    
    if($.trim(Plan)){
        
        $.ajax({//Ajax
			type: 'POST',
			url: 'PlanTrabjoDocente_html.php',
			async: false,
			dataType: 'json',
			data:({actionID:'UpdateHoras',Plan:Plan,
                                          H_Preparacio:H_Preparacio,
                                          T_horas:T_horas,
                                          Docente_id:Docente_id}),
			error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
			success:function(data){
				 if(data.val=='FALSE'){
				    alert(data.descrip);
                    return false;
				 }
			 }
		  }); //AJAX
        
    }//if
    
   
    var T_Fina = parseInt(T_horas)+parseInt(H_Preparacio);
    
    //alert('T_Fina->'+T_Fina);
    $('#T_horas').val(T_Fina);
    /***************************************************/
   } 
   function isNumberKey(evt){
   	    
    	var e = evt; 
    	var charCode = (e.which) ? e.which : e.keyCode
            console.log(charCode);
            
            //el comentado me acepta negativos
    	//if ( (charCode > 31 && (charCode < 48 || charCode > 57)) ||  charCode == 109 || charCode == 173 )
            if( charCode > 31 && (charCode < 48 || charCode > 57) ){
                //si no es - ni borrar
                if((charCode!=8 && charCode!=45)){
                    return false;
                }
            }
    
    	return true;
    
    }
   function RefreshPlanes(Div_carga,vocacion){
    /**********************************************/
        var Docente_id  = $('#Docente_id').val();
        var Periodo_id  = $('#Periodo_id').val();
        
        $.ajax({//Ajax
            type: 'POST',
            url: 'PlanTrabjoDocente_html.php',
            async: false,
            //dataType: 'json',
            data:({actionID:'RefreshPlanes',vocacion:vocacion,Docente_id:Docente_id,Periodo_id:Periodo_id}),
            error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
            success:function(data){
              
                    $('#'+Div_carga).css('display','inline');
                    $('#'+Div_carga).css('margin','0 auto');
                    $('#'+Div_carga).html(data);
                }
		  }); //AJAX
    /**********************************************/
   }//function RefreshPlanes 
 function ColorDinamic(i,id){
	/**************************************/
		$('#'+id+''+i).css('background-color','#FFF');
	/**************************************/
	}
function SinColorDinamic(i,id,op){
	/**************************************/
    if(op==2){
       var Color = '#D0EDD9'; 
    }else if(op==3){
        var Color = '#F4D7E9';
    }else if(op==4){
        var Color = '#E8E8E8';
    }
    
		$('#'+id+''+i).css('background-color',Color);
	/**************************************/
	}
 function CargarPlanDinamic(plan_id,Vocacion){
    
    var Docente_id  = $('#Docente_id').val();
    
    /****************************************************/
        $.ajax({//Ajax
            type: 'POST',
            url: 'PlanTrabjoDocente_html.php',
            async: false,
            dataType: 'json',
            data:({actionID:'PlanDinamic',plan_id:plan_id,Vocacion:Vocacion,Docente_id:Docente_id}),
            error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
            success:function(data){
                        
                        if(data.val=='FALSE'){
                            alert(data.descrip);
                            return false;
                        }else{
                            /****************************************************/
                            switch(Vocacion){
                                case '2':{
                                    /********************************************/
                                    $('#id_CampoDos').val(data.idProyecto);
				                    $('#NomProyecto').val(data.label);
                                    $('#TipoProyectoInv').val(data.tipo);
                                    $('#TipoProyectoInv').attr('disabled',true);
                                    $('#Thsemana').val(data.Horas);
                                    $('#Plan_Descubrimiento').val(plan_id);
                                    //$('#Thsemana').attr('disabled',true)
                                    
                                    
                                    VisualizarDos(data.plantrabajo_id,'2',data.Docente_id);
                                    BuscaMasData(data.plantrabajo_id,Docente_id);
                                    /********************************************/
                                }break;
                                case '3':{
                                    /********************************************/
                                    $('#Campo_id_Tres').val(data.idProyecto);
                    				$('#NomProyecto_tres').val(data.label);
                                    $('#TipoProyectoCompromiso').val(data.tipo);
                                    $('#TipoProyectoCompromiso').attr('disabled',true);
                                    $('#Thsemana_Tres').val(data.Horas);
                                    //$('#Thsemana_Tres').attr('disabled',true)
                                    $('#PlanCompromiso').val(plan_id);
                                    
                                    
                                    VisualizarTres(data.plantrabajo_id,'3',data.Docente_id);
                                    BuscaMasData(data.plantrabajo_id,Docente_id);
                                    /********************************************/
                                }break;
                                case '4':{
                                    /*********************************************/
                                    $('#Campo_Cuatro_id').val(data.idProyecto);
                    				$('#AADesarrolladas').val(data.label);
                                    $('#Thsemana_Des').val(data.Horas);
                                    //$('#Thsemana_Des').attr('disabled',true);
                                    $('#PlanGestion').val(plan_id);
                                    
                                    
                                    VisualizarCuatro(data.plantrabajo_id,'4',data.Docente_id);
                                    BuscaMasData(data.plantrabajo_id,Docente_id);
                                    /*********************************************/
                                }break;
                            }
                            /****************************************************/
                        }
                        
                        
                }
		  }); //AJAX
    /****************************************************/
 }   
 function EditText(Div,id,View){
    /*****************************************/
    $('#'+Div+''+id).css('display','inline');
    $('#'+View+''+id).css('display','none');
    $('#EditPng_'+id).css('display','none');
    $('#SavePng_'+id).css('display','inline');
    /*****************************************/
 }//function EditText
 function UpdateText(Div,id,View){
    /**********************************************/
    var Edit    = CKEDITOR.instances['Edit_'+id].getData();//$('#Edit_'+id).val();
    var Docente_id  = $('#Docente_id').val();
    
    if(confirm('Desea Modificar el Texto.')){
        /**************************************/
        $.ajax({//Ajax
            type: 'POST',
            url: 'PlanTrabjoDocente_html.php',
            async: false,
            dataType: 'json',
            data:({actionID:'UpdetaText',id:id,TXT:Edit,Docente_id:Docente_id}),
            error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
            success:function(data){
                if(data.val=='FALSE'){
                    alert(data.descrip);
                    return false;
                }else{
                    alert(data.descrip);
                    /*****************************************/
                    $('#'+Div+''+id).css('display','none');
                    $('#'+View+''+id).html(data.Texto);
                    $('#'+View+''+id).css('display','inline');
                    $('#EditPng_'+id).css('display','inline');
                    $('#SavePng_'+id).css('display','none');
                    /*****************************************/
                }
            }
         }); //AJAX 
        /**************************************/
    }//if
       
    /**********************************************/
 }/*function UpdateText*/	 
 function UpdateHoras(){ 
    /************************************************************/
    var Docente_id          = $('#Docente_id').val();
    /************************************************************/
    var Plan_Descubrimiento  = $('#Plan_Descubrimiento').val();
    
    if($.trim(Plan_Descubrimiento)){
       /*********************************************************/
       var Thsemana     = $('#Thsemana').val();
       
       $.ajax({//Ajax
            type: 'POST',
            url: 'PlanTrabjoDocente_html.php',
            async: false,
            dataType: 'json',
            data:({actionID:'UpdetaHoras',PlanDocente_id:Plan_Descubrimiento,
                                          Horas:Thsemana,
                                          Docente_id:Docente_id,
                                          Vocacion_id:'2'}),
            error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
            success:function(data){
                if(data.val=='FALSE'){
                    alert(data.descrip);
                    return false;
                }else{}
            }
         }); //AJAX 
       /*********************************************************/
    }//if
    
    var PlanCompromiso      = $('#PlanCompromiso').val();
    
    if($.trim(PlanCompromiso)){
       /*********************************************************/
       var Thsemana_Tres     = $('#Thsemana_Tres').val();
       
       $.ajax({//Ajax
            type: 'POST',
            url: 'PlanTrabjoDocente_html.php',
            async: false,
            dataType: 'json',
            data:({actionID:'UpdetaHoras',PlanDocente_id:PlanCompromiso,
                                          Horas:Thsemana_Tres,
                                          Docente_id:Docente_id,
                                          Vocacion_id:'3'}),
            error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
            success:function(data){
                if(data.val=='FALSE'){
                    alert(data.descrip);
                    return false;
                }else{}
            }
         }); //AJAX 
       /*********************************************************/
    }//if
    
    var PlanGestion     = $('#PlanGestion').val();
    
    if($.trim(PlanGestion)){
       /*********************************************************/
       var Thsemana_Des     = $('#Thsemana_Des').val();
       
       $.ajax({//Ajax
            type: 'POST',
            url: 'PlanTrabjoDocente_html.php',
            async: false,
            dataType: 'json',
            data:({actionID:'UpdetaHoras',PlanDocente_id:PlanGestion,
                                          Horas:Thsemana_Des,
                                          Docente_id:Docente_id,
                                          Vocacion_id:'4'}),
            error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
            success:function(data){
                if(data.val=='FALSE'){
                    alert(data.descrip);
                    return false;
                }else{}
            }
         }); //AJAX 
       /*********************************************************/
    }//if
    /************************************************************/
 }/*function UpdateHoras()*/
 function BuscaMasData(id,Docente_id){
    /***************************************************************/
    
     $.ajax({//Ajax
            type: 'POST',
            url: 'PlanTrabjoDocente_html.php',
            async: false,
            dataType: 'json',
            data:({actionID:'BuscaMasData',id:id,Docente_id:Docente_id}),
            error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
            success:function(data){
               
                if(data.val=='TRUE'){ 
                    
                    CKEDITOR.instances[data.id_Auto].setData(data.autoevaluacion);
                    //CKEDITOR.instances[data.id_Porj].setData(data.autoevaluacion);
                    CKEDITOR.instances[data.id_Cons].setData(data.consolidacion);
                    CKEDITOR.instances[data.id_Mej].setData(data.mejora);
                    
                    //$('#'+data.id_Auto).val(data.autoevaluacion);
                    $('#'+data.id_Porj).val(data.porcentaje);
                    //$('#'+data.id_Cons).val(data.consolidacion);
                    //$('#'+data.id_Mej).val(data.mejora);
                    //$('#'+data.Boton).css('display','none');
                }else{
                    alert(data.descrip);
                }    
            }
         }); //AJAX 
    /***************************************************************/
 }/*function BuscaMasData*/ 
 function CambiarPeriodo(){
    $.ajax({//Ajax
            type: 'POST',
            url: 'PlanTrabjoDocente_html.php',
            async: false,
            dataType: 'html',
            data:({actionID:'BuscaPeriodo'}),
            error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
            success:function(data){
               
                $('#periodo').css('display','none');
                $('#DivPeriodo').css('display','inline');
                $('#DivPeriodo').html(data);
                 
            }
         }); //AJAX 
 }/*Function CambiarPeriodo*/
 function PintarPeriodo(){
    
    var PeliodoSelect = $('#PeliodoSelect').val();
    
    $.ajax({//Ajax
            type: 'POST',
            url: 'PlanTrabjoDocente_html.php',
            async: false,
            dataType: 'json',
            data:({actionID:'PintarPeriodo',PeliodoSelect:PeliodoSelect}),
            error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
            success:function(data){
               
                $('#periodo').css('display','inline');
                $('#periodo').html(data.Formato);
                $('#Periodo_id').val(PeliodoSelect); 
                $('#DivPeriodo').css('display','none');
                
                /*
                *PimeraSave
                *DosSave
                *TresSave
                *CuatroSave
                *guardar
                *guardar
                */
             
                
                
                
                var Docente_id = $('#Docente_id').val();
                
                $.ajax({//Ajax
                    type: 'POST',
                    url: 'PlanTrabjoDocente_html.php',
                    async: false,
                    dataType: 'html',
                    data:({actionID:'Retorno',Docente_id:Docente_id,PeRiodo:PeliodoSelect}),
                    error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
                    success:function(data){
                       
                        $('#Data').html(data);
                         
                    }
                 }); //AJAX 
                
                
            }
         }); //AJAX 
    
 }/*function PintarPeriodo*/	 
    </script>
    <?PHP
}	
?>
