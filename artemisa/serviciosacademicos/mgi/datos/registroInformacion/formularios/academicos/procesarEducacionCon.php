<?php 

session_start();
require_once("../../../templates/template.php");

	$proces=new Procesar();
	$proces->Control();
	
	class Procesar{

		public function Control (){
			
			$db = getBD();
           
           //echo'<pre>';print_r($_POST);
           
           	switch ($_REQUEST['procesID']){
			    case 'EliminarData':{
			         $id_detalle = $_GET['id_detalle'];
                     
                     $Delete='UPDATE  siq_detalle_educacioncontinuadaprogramasinfhuerfana
                              SET
                                      codigoestado=200,
                                      changedate=NOW()
                              
                              WHERE
                                      id="'.$id_detalle.'" AND codigoestado=100';
                                      
                            if($Elimina=&$db->Execute($Delete)===false){
                                $a_vectt['val']     = 'FALSE';
                                $a_vectt['descrip']	='Error En el SQL Consulta....'.$Delete;
                                echo json_encode($a_vectt);
                                exit;
                            }//if    
                        
                        $a_vectt['val']     = 'TRUE';
                        //$a_vectt['descrip']	='Error En el SQL Consulta....'.$Delete;
                        echo json_encode($a_vectt);
                        exit;            
			    }break; 
			    case 'BuscarData':{
			     
                    /*$Mes  = $_GET['mes'];
                    $Year = $_GET['year'];*/
                    
                    $Periocidad = $_GET['year'].$_GET['mes'];
                    
                    //echo '<br>Mes->'.$Mes.'<br>year->'.$Year; 
                    
                    
                      $SQL='SELECT 

                            *
                            
                            FROM siq_educacioncontinuadaprogramasinfhuerfana
                            
                            WHERE
                            
                            periodicidad="'.$Periocidad.'"';
                            
                            if($Consulta=&$db->Execute($SQL)===false){
                                $a_vectt['val']     = 'FALSE';
                                $a_vectt['descrip']	='Error En el SQL Consulta....'.$SQL;
                                echo json_encode($a_vectt);
                                exit;
                            }//if
                      $Datos_Uni   = array();
                      $Datos_Multi = array();
                            
                      if(!$Consulta->EOF){
                        while(!$Consulta->EOF){
                            /****************************************************/
                                $Datos_Uni['id'][]               = $Consulta->fields['id'];
                                $Datos_Uni['idclasificacion'][]  = $Consulta->fields['idclasificacion'];
                                $Datos_Uni['idcategorias'][]     = $Consulta->fields['idcategorias'];
                                $Datos_Uni['num_abierto'][]      = $Consulta->fields['num_abierto'];
                                $Datos_Uni['num_cerrado'][]      = $Consulta->fields['num_cerrado'];
                                $Datos_Uni['num_pres'][]         = $Consulta->fields['num_pres'];
                                $Datos_Uni['num_vir'][]          = $Consulta->fields['num_vir'];
                                $Datos_Uni['num_sem'][]          = $Consulta->fields['num_sem'];
                                $Datos_Uni['numero_asistentes'][]= $Consulta->fields['numero_asistentes'];
                                
                                  $SQL_Detalle='SELECT 

                                                id,
                                                tipo,
                                                pais,
                                                cantidad
                                                
                                                FROM siq_detalle_educacioncontinuadaprogramasinfhuerfana
                                                
                                                WHERE
                                                
                                                codigoestado=100
                                                AND
                                                id_educacioncontinuadaprogramasinfhuerfana="'.$Consulta->fields['id'].'"';
                                                
                                                if($Detalle=&$db->Execute($SQL_Detalle)===false){
                                                    $a_vectt['val']     = 'FALSE';
                                                    $a_vectt['descrip']	='Error En el SQL Consulta....'.$SQL_Detalle;
                                                    echo json_encode($a_vectt);
                                                    exit;
                                                }//if
                                  if(!$Detalle->EOF){
                                    while(!$Detalle->EOF){
                                        /*************************************************/
                                        //$Datos_Multi['idclasificacion'][$Detalle->fields['tipo']][$Consulta->fields['idclasificacion']][]  = $Consulta->fields['idclasificacion'];
                                        $Datos_Multi['id_detalle'][$Detalle->fields['tipo']][$Consulta->fields['idclasificacion']][]       = $Detalle->fields['id'];
                                        //$Datos_Multi['tipo'][$Detalle->fields['tipo']][$Consulta->fields['idclasificacion']][]             = $Detalle->fields['tipo'];
                                        $Datos_Multi['pais'][$Detalle->fields['tipo']][$Consulta->fields['idclasificacion']][]             = $Detalle->fields['pais'];
                                        $Datos_Multi['cantidad'][$Detalle->fields['tipo']][$Consulta->fields['idclasificacion']][]         = $Detalle->fields['cantidad'];
                                        /*************************************************/
                                        $Detalle->MoveNext();
                                    }//while
                                  }//if              
                            /****************************************************/
                            $Consulta->MoveNext();
                        }//while
                      }else{
                            
                            $SQL_R='SELECt iec.idclasificacion 
                                    FROM infoEducacionContinuada iec JOIN ( select idclasificacion from infoEducacionContinuada where alias="program" ) sub on iec.idpadreclasificacion=sub.idclasificacion';
                                    
                                    if($ResultadoAlterno=&$db->Execute($SQL_R)===false){
                                        $a_vectt['val']     = 'FALSE';
                                        $a_vectt['descrip']	='Error En el SQL Consulta Alterna....'.$SQL_R;
                                        echo json_encode($a_vectt);
                                        exit;
                                    }
                                    
                            while(!$ResultadoAlterno->EOF){
                                
                                $Datos_Uni['idclasificacion'][]  = $ResultadoAlterno->fields['idclasificacion'];
                                
                                $ResultadoAlterno->MoveNext();
                            }//while        
                        
                      }//if      
                      
                    #echo '<pre>';print_r($Datos_Multi);die;
                 
                    $a_vectt['val']           = 'TRUE';
                    $a_vectt['Datos_Uni']     = $Datos_Uni;
                    $a_vectt['Datos_Multi']   = $Datos_Multi;
                    echo json_encode($a_vectt);
                    exit;
                 
			    }break; 
				case 'registrar_formEducacion_Continuada':
                                    //echo "aca...";
					if( $_POST['actividad']=='programas') {
                                                     $periodicidad=$_REQUEST['anio'].$_REQUEST['mes'];
						    $query_periodoinf="select * from siq_educacioncontinuadaprogramasinfhuerfana where periodicidad=".$periodicidad;
						    //echo $query_periodoinf;
                                                    $periodoinf=$db->Execute($query_periodoinf);
                                                $row_mesinf=0; $int=0;
                                                foreach ($periodoinf as $ro){ $row_mesinf ++; }
                                                    if($row_mesinf==0){
                                                        
                                                        if($_POST['action']=='SaveDynamic'){
                                                            
                                                            $id_Last = array();
                                                            
                                                            foreach ($_POST['idclasificacion'] as $row){
                                                                    //$query_inserta="insert into numeroOfrecidoscontinuada 
																	//(tipoprograma,cantidad_salud,cantidad_vida, cantidad_nucleo,cantidad_academica,mes,anio,
																	//estadoprograma) 
																	//values('".$_POST['tipo_programa'][$int]."','".$_POST['cantidad_salud'][$int]."','".$_POST['cantidad_vida'][$int]."', '".$_POST['cantidad_nucleo'][$int]."','".$_POST['cantidad_academica'][$int]."','".$_POST['mes']."','".$_POST['anio']."', 100)";
                                                                                  $query_inserta="insert into siq_educacioncontinuadaprogramasinfhuerfana
                                                                                    (periodicidad, idclasificacion, idcategorias, num_abierto, num_cerrado, num_pres, num_vir, num_sem, numero_asistentes)
                                                                            values  ('".$periodicidad."', '".$_POST['idclasificacion'][$int]."', '".$_POST['idcategorias'][$int]."', '".$_POST['num_abierto'][$int]."', '".$_POST['num_cerrado'][$int]."'
                                                                                    ,'".$_POST['num_pres'][$int]."', '".$_POST['num_vir'][$int]."', '".$_POST['num_sem'][$int]."', '".$_POST['numero_asistentes'][$int]."')";

                                                                 //   echo $query_inserta.'-->>';
                                                                    if($inserta= &$db->Execute($query_inserta)===false){
                                                                            $a_vectt['descrip']	='Error En el SQL Insert O Consulta....'.$query_inserta;
                                                                            echo json_encode($a_vectt);
                                                                            exit;
                                                                    }//if_insert
                                                                    /*************************************************/
                                                                     $id_Last['idclasificacion'][]=$_POST['idclasificacion'][$int];
                                                                     $id_Last['cabeza_'.$_POST['idclasificacion'][$int]][]=$Last_id = $db->Insert_ID();
                                                                    /*************************************************/
                                                                    //ingresa detalle
                                                                    $Pais_Participante = $_POST['paisparticipantes_'.$_POST['idclasificacion'][$int]];
                                                                    $Cant_Participante = $_POST['cantparticipantes_'.$_POST['idclasificacion'][$int]];
                                                                    $Pais_Conferencia  = $_POST['paisconferencistas_'.$_POST['idclasificacion'][$int]];
                                                                    $Cant_Conferencia  = $_POST['cantconferencistas_'.$_POST['idclasificacion'][$int]];
                                                                   
                                                                    
                                                                    for($l=0;$l<count($Pais_Participante);$l++){//for...1$l=0;$l<count($Pais_Participante);$l++
                                                                        
                                                                        $Pais = $Pais_Participante[$l];
                                                                        $cant = $Cant_Participante[$l];
                                                                        
                                                                        $SQL_insert='INSERT INTO  siq_detalle_educacioncontinuadaprogramasinfhuerfana(id_educacioncontinuadaprogramasinfhuerfana,tipo,pais,cantidad,entrydate)VALUES("'.$Last_id.'","1","'.$Pais.'","'.$cant.'",NOW())';
                                                                        
                                                                        if($Insert_ParticipantesDetalle=&$db->Execute($SQL_insert)===false){
                                                                            $a_vectt['descrip']	='Error En el SQL Insert O Consulta....'.$SQL_insert;
                                                                            echo json_encode($a_vectt);
                                                                            exit;
                                                                        }//IF
                                                                        /**************************************************************************************************/
                                                                        $id_Last['detalle_Participante_'.$_POST['idclasificacion'][$int]][]=$Last_id_detalle = $db->Insert_ID();
                                                                        /**************************************************************************************************/
                                                                    }//for..1
                                                                    
                                                                    for($x=0;$x<count($Pais_Conferencia);$x++){//for...2
                                                                        
                                                                        $Pais_C = $Pais_Conferencia[$x];
                                                                        $cant_C = $Cant_Conferencia[$x];
                                                                        
                                                                        $SQL_insert='INSERT INTO  siq_detalle_educacioncontinuadaprogramasinfhuerfana(id_educacioncontinuadaprogramasinfhuerfana,tipo,pais,cantidad,entrydate)VALUES("'.$Last_id.'","2","'.$Pais_C.'","'.$cant_C.'",NOW())';
                                                                        
                                                                        if($Insert_ParticipantesDetalle=&$db->Execute($SQL_insert)===false){
                                                                            $a_vectt['descrip']	='Error En el SQL Insert O Consulta....'.$SQL_insert;
                                                                            echo json_encode($a_vectt);
                                                                            exit;
                                                                        }//IF
                                                                        /**************************************************************************************************/
                                                                        $id_Last['detalle_conferencias_'.$_POST['idclasificacion'][$int]][]=$Last_id_detalle = $db->Insert_ID();
                                                                        /**************************************************************************************************/
                                                                    }//for..2
                                                                    /****************************************/
                                                                    $int++;
                                                            }//foreach
                                                            $a_vectt['success']=true; 
                                                            $a_vectt['descrip']='Los datos han sido guardados de forma correcta ';
                                                            $a_vectt['id']     =$id_Last;
                                                            echo json_encode($a_vectt);
                                                            exit;
                                                        }else{
                                                            $a_vectt['success']=false; $a_vectt['descrip']='No hay datos';
                                                            echo json_encode($a_vectt);
                                                            exit;
                                                        }
                                                    }else{
                                                            if($_POST['action']=='SelectDynamic' && $row_mesinf>0){
                                                               // $query_selec="select * from numeroOfrecidoscontinuada where anio='".$_POST['anio']."' and mes='".$_POST['mes']."'";
                                                                //echo $query_selec.'-->>';
                                                                $periodoNum=$db->Execute($query_periodoinf);
                                                                $i=0;
                                                                foreach ($periodoNum as $row){
                                                                   $a_vectt[$i]['id']=$row['id']; 
                                                                   $a_vectt[$i]['idclasificacion']=$row['idclasificacion']; 
                                                                   $a_vectt[$i]['periocidad']=$row['periocidad'];
                                                                   $a_vectt[$i]['idcategorias']=$row['idcategorias'];
                                                                   $a_vectt[$i]['num_abierto']=$row['num_abierto'];
                                                                   $a_vectt[$i]['num_cerrado']=$row['num_cerrado'];
                                                                   $a_vectt[$i]['num_pres']=$row['num_pres'];
                                                                   $a_vectt[$i]['num_vir']=$row['num_vir'];
                                                                   $a_vectt[$i]['num_sem']=$row['num_sem'];
                                                                   $a_vectt[$i]['numero_asistentes']=$row['numero_asistentes'];
//                                                                   $sql_compo="select * from siq_educacioncontinuadaprogramas_partconf_infhuerfana where ideducacioncontinuadaprogramasinfhuerfana='".$row['id']."'";
//                                                                   $compo=$db->Execute($sql_compo);
//                                                                   $j=0;
//                                                                   foreach ($compo as $row2){
//                                                                       if($row2['participantesconferencistas']=='P'){
//                                                                        $a_vectt2[$i][$j]['paisparticipantes_'.$row['idclasificacion']]=$row2['idpas'];
//                                                                        $a_vectt2[$i][$j]['cantparticipantes_'.$row['idclasificacion']]=$row2['cantidad'];
//                                                                       }else{
//                                                                        $a_vectt2[$i][$j]['paisconferencistas_'.$row['idclasificacion']]=$row2['idpas'];
//                                                                        $a_vectt2[$i][$j]['cantconferencistas_'.$row['idclasificacion']]=$row2['cantidad'];   
//                                                                       }
//                                                                       
//                                                                       $j++;
//                                                                   }
                                                                   $a_vectt[$i]['totalP']=$j;
                                                                   $i++;
                                                                }
                                                                $a_vectt['total']=$i;    $a_vectt['success']=true; $a_vectt['descrip']='Consultando';
                                                                echo json_encode($a_vectt);
                                                                exit;
                                                            }else if($_POST['action']=='UpdateDynamic'){
                                                                $j=0; $int=0;
                                                                foreach ($_POST['idclasificacion']as $row){
                                                                   //  $query_update="UPDATE numeroOfrecidoscontinuada SET cantidad_salud='".$_POST['cantidad_salud'][$int]."', cantidad_vida='".$_POST['cantidad_vida'][$int]."', cantidad_nucleo='".$_POST['cantidad_nucleo'][$int]."', cantidad_academica='".$_POST['cantidad_academica'][$int]."' WHERE id_ofrecidos='".$_POST['id_ofrecidos'][$int]."' ";
                                                                   
                                                                 //echo '<pre>';print_r($_POST);   
                                                                   
                                                                 $query_update="UPDATE siq_educacioncontinuadaprogramasinfhuerfana SET 
                                                                                periodicidad='$periodicidad',
                                                                                idclasificacion='".$_POST['idclasificacion'][$int]."',
                                                                                idcategorias='".$_POST['idcategorias'][$int]."',
                                                                                num_abierto='".$_POST['num_abierto'][$int]."',
                                                                                num_cerrado='".$_POST['num_cerrado'][$int]."',
                                                                                num_pres='".$_POST['num_pres'][$int]."',
                                                                                num_vir='".$_POST['num_vir'][$int]."',
                                                                                num_sem='".$_POST['num_sem'][$int]."',
                                                                                numero_asistentes='".$_POST['numero_asistentes'][$int]."' where id='".$_POST['idSave'][$int]."'";
                                                                // echo $query_update;
                                                                    if($inserta= &$db->Execute($query_update)===false){
                                                                            $a_vectt['val']='FALSE'; $a_vectt['descrip']='Error En el SQL Insert O Consulta....'.$query_update;
                                                                            echo json_encode($a_vectt);
                                                                            exit;
                                                                    }else{
                                                                       $j++;
                                                                    }
                                                                    
                                                                    $Detalle_P  = $_POST['id_detalleparticipantes_'.$_POST['idclasificacion'][$int]];
                                                                    $Pais_P     = $_POST['paisparticipantes_'.$_POST['idclasificacion'][$int]];
                                                                    $Cant_P     = $_POST['cantparticipantes_'.$_POST['idclasificacion'][$int]];
                                                                    
                                                                    
                                                                    //echo '<pre>';print_r($Detalle_P);print_r($Cant_P);
                                                                    
                                                                    /*****************************************************************/
                                                                    for($n=0;$n<count($Detalle_P);$n++){
                                                                        /*************************************************************/
                                                                        $id_detalle = $Detalle_P[$n];
                                                                        
                                                                        if($id_detalle){
                                                                            /*********************************************************/
                                                                           $UpdateDetalle_P='UPDATE siq_detalle_educacioncontinuadaprogramasinfhuerfana
                                                                                              
                                                                                              SET
                                                                                                     pais="'.$Pais_P[$n].'",
                                                                                                     cantidad="'.$Cant_P[$n].'",
                                                                                                     changedate=NOW()
                                                                                              
                                                                                              WHERE
                                                                                                     id="'.$id_detalle.'" AND codigoestado=100';
                                                                                                     
                                                                             if($Modificado=&$db->Execute($UpdateDetalle_P)===false){
                                                                                $a_vectt['val']='FALSE'; 
                                                                                $a_vectt['descrip']='Error En el SQL Modificar....'.$query_update;
                                                                                echo json_encode($a_vectt);
                                                                                exit;
                                                                             }//if                        
                                                                            /*********************************************************/
                                                                        }else{
                                                                            //insert
                                                                            $SQL_insert='INSERT INTO  siq_detalle_educacioncontinuadaprogramasinfhuerfana(id_educacioncontinuadaprogramasinfhuerfana,tipo,pais,cantidad,entrydate)VALUES("'.$_POST['idSave'][$int].'","1","'.$Pais_P[$n].'","'.$Cant_P[$n].'",NOW())';
                                                                        
                                                                            if($Insert_ParticipantesDetalle=&$db->Execute($SQL_insert)===false){
                                                                                $a_vectt['descrip']	='Error En el SQL Insert O Consulta....'.$SQL_insert;
                                                                                echo json_encode($a_vectt);
                                                                                exit;
                                                                            }//IF
                                                                        }
                                                                        /*************************************************************/
                                                                    }//for.-..1
                                                                    /*****************************************************************/
                                                                    $Detalle_C  = $_POST['id_detalleconferencistas_'.$_POST['idclasificacion'][$int]];
                                                                    $Pais_C     = $_POST['paisconferencistas_'.$_POST['idclasificacion'][$int]];
                                                                    $Cant_C     = $_POST['cantconferencistas_'.$_POST['idclasificacion'][$int]];
                                                                                                                                          
                                                                    //echo '<pre>';print_r($Detalle_C);
                                                                    
                                                                     for($n=0;$n<count($Detalle_C);$n++){
                                                                        /*************************************************************/
                                                                        $id_detalle = $Detalle_C[$n];
                                                                        
                                                                        if($id_detalle){
                                                                            /*********************************************************/
                                                                            $UpdateDetalle_P='UPDATE siq_detalle_educacioncontinuadaprogramasinfhuerfana
                                                                                               
                                                                                              SET
                                                                                                     pais="'.$Pais_C[$n].'",
                                                                                                     cantidad="'.$Cant_C[$n].'",
                                                                                                     changedate=NOW()
                                                                                              
                                                                                              WHERE
                                                                                                     id="'.$id_detalle.'" AND codigoestado=100';
                                                                                                     
                                                                             if($Modificado=&$db->Execute($UpdateDetalle_P)===false){
                                                                                $a_vectt['val']='FALSE'; 
                                                                                $a_vectt['descrip']='Error En el SQL Modificar....'.$query_update;
                                                                                echo json_encode($a_vectt);
                                                                                exit;
                                                                             }//if                        
                                                                            /*********************************************************/
                                                                        }else{
                                                                            //insert
                                                                            $SQL_insert='INSERT INTO  siq_detalle_educacioncontinuadaprogramasinfhuerfana(id_educacioncontinuadaprogramasinfhuerfana,tipo,pais,cantidad,entrydate)VALUES("'.$_POST['idSave'][$int].'","2","'.$Pais_C[$n].'","'.$Cant_C[$n].'",NOW())';
                                                                        
                                                                            if($Insert_ParticipantesDetalle=&$db->Execute($SQL_insert)===false){
                                                                                $a_vectt['descrip']	='Error En el SQL Insert O Consulta....'.$SQL_insert;
                                                                                echo json_encode($a_vectt);
                                                                                exit;
                                                                            }//IF
                                                                        }
                                                                        /*************************************************************/
                                                                    }//for.-..1
                                                                    /******************************************************************************************/
                                                                    $int++;
                                                                    
                                                                }
                                                                if($j>0){
                                                                       $a_vectt['success'] =true; $a_vectt['descrip'] ='Los datos han sido modificados de forma correcta ';
                                                                        echo json_encode($a_vectt);
                                                                        exit;
                                                                }else{
                                                                    $a_vectt['success'] =true; $a_vectt['descrip'] ='Hay un Error';
                                                                        echo json_encode($a_vectt);
                                                                        exit;
                                                                }
                                                                
                                                            }else{ 
                                                                $a_vectt['success']=false;  $a_vectt['descrip']='No hay datos';
                                                                echo json_encode($a_vectt);
                                                                exit;
                                                            }
                                                    }
						} else {
							$a_vectt['val']			='FALSE';
							$a_vectt['descrip']		='Este mes ya fue registrado';
							echo json_encode($a_vectt);
							exit;
						}
					break;
				case'registrar_ProgramasOfrecidos':
					if( $_POST['actividad']=='numero_programas'){
						$query_periodoinf="select mes,anio from numeroProgramaMesesContinuada where anio='".$_POST['anio']."' and mes='".$_POST['mes']."'";
	                                        $periodoinf=$db->Execute($query_periodoinf);
                                                $row_mesinf=0; $int=0;
                                                foreach ($periodoinf as $ro){ $row_mesinf ++; }
                                                    if($row_mesinf==0){
                                                        if($_POST['action']=='SaveDynamic'){
                                                            $query_inserta_mes="insert into numeroProgramaMesesContinuada (idmedioscontinuada,mes,anio,codigoestado)values(0,'".$_POST['mes']."','".$_POST['anio']."', 100)";
                                                            $inserta_mes=&$db->Execute($query_inserta_mes);							
                                                            foreach ($_POST['tipo_programa']as $row){
                                                                    $query_inserta="insert into numeroOfrecidoscontinuada (tipoprograma,cantidad_salud,cantidad_vida, cantidad_nucleo,cantidad_academica,mes,anio,estadoprograma) values('".$_POST['tipo_programa'][$int]."','".$_POST['cantidad_salud'][$int]."','".$_POST['cantidad_vida'][$int]."', '".$_POST['cantidad_nucleo'][$int]."','".$_POST['cantidad_academica'][$int]."','".$_POST['mes']."','".$_POST['anio']."', 100)";
                                                                    //echo $query_inserta.'-->>';
                                                                    if($inserta= &$db->Execute($query_inserta)===false){
                                                                            $a_vectt['descrip']	='Error En el SQL Insert O Consulta....'.$query_inserta;
                                                                            echo json_encode($a_vectt);
                                                                            exit;
                                                                    }//if_insert
                                                                    $int++;
                                                            }//foreach
                                                            $a_vectt['success']=true; $a_vectt['descrip']='Los datos han sido guardados de forma correcta ';
                                                            echo json_encode($a_vectt);
                                                            exit;
                                                        }else{
                                                            $a_vectt['success']=false; $a_vectt['descrip']='No hay datos';
                                                            echo json_encode($a_vectt);
                                                            exit;
                                                        }
                                                    }else{
                                                            if($_POST['action']=='SelectDynamic' && $row_mesinf>0){
                                                                $query_selec="select * from numeroOfrecidoscontinuada where anio='".$_POST['anio']."' and mes='".$_POST['mes']."'";
                                                                //echo $query_selec.'-->>';
                                                                $periodoNum=$db->Execute($query_selec);
                                                                $i=0;
                                                                foreach ($periodoNum as $row){
                                                                   $a_vectt[$i]['id_ofrecidos']=$row['id_ofrecidos']; 
                                                                   $a_vectt[$i]['tipo_programa']=$row['tipoprograma'];
                                                                   $a_vectt[$i]['cantidad_salud']=$row['cantidad_salud'];
                                                                   $a_vectt[$i]['cantidad_vida']=$row['cantidad_vida'];
                                                                   $a_vectt[$i]['cantidad_nucleo']=$row['cantidad_nucleo'];
                                                                   $a_vectt[$i]['cantidad_academica']=$row['cantidad_academica'];
                                                                   $i++;
                                                                }
                                                                $a_vectt['total']=$i;    $a_vectt['success']=true; $a_vectt['descrip']='Consultando';
                                                                echo json_encode($a_vectt);
                                                                exit;
                                                            }else if($_POST['action']=='UpdateDynamic'){
                                                                $j=0; $int=0;
                                                                foreach ($_POST['tipo_programa']as $row){
                                                                     $query_update="UPDATE numeroOfrecidoscontinuada SET cantidad_salud='".$_POST['cantidad_salud'][$int]."', cantidad_vida='".$_POST['cantidad_vida'][$int]."', cantidad_nucleo='".$_POST['cantidad_nucleo'][$int]."', cantidad_academica='".$_POST['cantidad_academica'][$int]."' WHERE id_ofrecidos='".$_POST['id_ofrecidos'][$int]."' ";

                                                                    if($inserta= &$db->Execute($query_update)===false){
                                                                            $a_vectt['val']='FALSE'; $a_vectt['descrip']='Error En el SQL Insert O Consulta....'.$query_update;
                                                                            echo json_encode($a_vectt);
                                                                            exit;
                                                                    }else{
                                                                       $j++;
                                                                    }
                                                                    $int++;
                                                                }
                                                                if($j>0){
                                                                       $a_vectt['success'] =true; $a_vectt['descrip'] ='Los datos han sido modificados de forma correcta ';
                                                                        echo json_encode($a_vectt);
                                                                        exit;
                                                                }else{
                                                                    $a_vectt['success'] =true; $a_vectt['descrip'] ='Hay un Error';
                                                                        echo json_encode($a_vectt);
                                                                        exit;
                                                                }
                                                                
                                                            }else{ 
                                                                $a_vectt['success']=false;  $a_vectt['descrip']='No hay datos';
                                                                echo json_encode($a_vectt);
                                                                exit;
                                                            }
                                                    }
					}
			break;//case'registrar_ProgramasOfrecidos':
				case'registrar_abiertos_cerrados':
					if( $_POST['actividad']=='numero_programas'){
						$query_periodoinf="select mes,anio from abiertocerradomeses where anio='".$_POST['anio']."' and mes='".$_POST['mes']."'";
	                                        //echo $query_periodoinf.'-->';
                                                $periodoinf=$db->Execute($query_periodoinf);
                                                $row_mesinf=0; $int=0;
                                                foreach ($periodoinf as $ro){ $row_mesinf ++; }
                                                
                                                    if($row_mesinf==0){
                                                        if($_POST['action']=='SaveDynamic'){
                                                            $query_inserta_mes="insert into abiertocerradomeses (idmedioscontinuada,mes,anio,codigoestado)values(0,'".$_POST['mes']."','".$_POST['anio']."', 100)";
                                                            $inserta_mes=&$db->Execute($query_inserta_mes);							
                                                            foreach ($_POST['tipo_programa']as $row){
                                                                    $query_inserta="insert into educacionabiertocerrado (tipoprograma,cantidad,procentaje,mes,anio,estado)
																				values('".$_POST['tipo_programa'][$int]."','".$_POST['cantidad'][$int]."','".$_POST['procentaje'][$int]."','".$_POST['mes']."','".$_POST['anio']."', 100)";
												
																	if($inserta= &$db->Execute($query_inserta)===false){
                                                                            $a_vectt['descrip']	='Error En el SQL Insert O Consulta....'.$query_inserta;
                                                                            echo json_encode($a_vectt);
                                                                            exit;
                                                                    }//if_insert
                                                                    $int++;
                                                            }//foreach
                                                            $a_vectt['success']=true; $a_vectt['descrip']='Los datos han sido guardados de forma correcta ';
                                                            echo json_encode($a_vectt);
                                                            exit;
                                                        }else{
                                                            $a_vectt['success']=false; $a_vectt['descrip']='No hay datos';
                                                            echo json_encode($a_vectt);
                                                            exit;
                                                        }
                                                    }else{
                                                            if($_POST['action']=='SelectDynamic' && $row_mesinf>0){
                                                                $query_selec="select * from educacionabiertocerrado where anio='".$_POST['anio']."' and mes='".$_POST['mes']."'";
                                                                //echo $query_selec.'-->>';
                                                                $periodoNum=$db->Execute($query_selec);
                                                                $i=0;
                                                                foreach ($periodoNum as $row){
                                                                   $a_vectt[$i]['id_ofrecidos']=$row['id_ofrecidos']; 
                                                                   $a_vectt[$i]['tipo_programa']=$row['tipoprograma'];
                                                                   $a_vectt[$i]['cantidad']=$row['cantidad'];
                                                                   $a_vectt[$i]['procentaje']=$row['procentaje'];
                                                                   $i++;
                                                                }
                                                                $a_vectt['total']=$i;    $a_vectt['success']=true; $a_vectt['descrip']='Consultando';
                                                                echo json_encode($a_vectt);
                                                                exit;
                                                            }else if($_POST['action']=='UpdateDynamic'){
                                                                $j=0; $int=0;
                                                                foreach ($_POST['tipo_programa']as $row){
                                                                     $query_update="UPDATE educacionabiertocerrado SET cantidad='".$_POST['cantidad'][$int]."', procentaje='".$_POST['procentaje'][$int]."' WHERE id_ofrecidos='".$_POST['id_ofrecidos'][$int]."' ";
                                                                     //   echo   $query_update;
                                                                    if($inserta= &$db->Execute($query_update)===false){
                                                                            $a_vectt['val']='FALSE'; $a_vectt['descrip']='Error En el SQL Insert O Consulta....'.$query_update;
                                                                            echo json_encode($a_vectt);
                                                                            exit;
                                                                    }else{
                                                                         $j++;
                                                                    }
                                                                    $int++;
                                                                        }
                                                                        if($j>0){
                                                                               $a_vectt['success'] =true; $a_vectt['descrip'] ='Los datos han sido modificados de forma correcta ';
                                                                                echo json_encode($a_vectt);
                                                                                exit;
                                                                        }else{
                                                                            $a_vectt['success'] =true; $a_vectt['descrip'] ='Hay un Error';
                                                                                echo json_encode($a_vectt);
                                                                                exit;
                                                                        }
                                                                
                                                            }else{ 
                                                                $a_vectt['success']=false;  $a_vectt['descrip']='No hay datos';
                                                                echo json_encode($a_vectt);
                                                                exit;
                                                            }
                                                    }
					}
				break;//case'registrar_abiertos_cerrados':
				
				case'insert_academica':
					
				if( $_POST['actividad']=='numero_programas'){
						$query_periodoinf="select mes,anio from continuadaacademicameses where anio='".$_POST['anio']."' and mes='".$_POST['mes']."'";
	                                       // echo $query_periodoinf;
                                                $periodoinf=$db->Execute($query_periodoinf);
                                                $row_mesinf=0; $int=0;
                                                foreach ($periodoinf as $ro){ $row_mesinf ++; }
                                              //  echo $row_mesinf.'<->';
                                                    if($row_mesinf==0){
                                                        if($_POST['action']=='SaveDynamic'){
                                                            $query_inserta_mes="insert into continuadaacademicameses (idmedioscontinuada,mes,anio,codigoestado)values(0,'".$_POST['mes']."','".$_POST['anio']."', 100)";
                                                            $inserta_mes=&$db->Execute($query_inserta_mes);							
                                                            foreach ($_POST['tipo_programa']as $row){
                                                                   $query_inserta="insert into educacionacademica (tipoprograma,cant_curso,cant_diplomado,cant_evento,num_abierto,num_cerrado,num_pres,num_vir,num_sem,mes,anio,estado)
																					values('".$_POST['tipo_programa'][$int]."','".$_POST['cant_curso'][$int]."','".$_POST['cant_diplomado'][$int]."',
																						'".$_POST['cant_evento'][$int]."','".$_POST['num_abierto'][$int]."','".$_POST['num_cerrado'][$int]."',
																						'".$_POST['num_pres'][$int]."','".$_POST['num_vir'][$int]."','".$_POST['num_sem'][$int]."','".$_POST['mes']."','".$_POST['anio']."', 100)";
															
																	if($inserta= &$db->Execute($query_inserta)===false){
                                                                            $a_vectt['descrip']	='Error En el SQL Insert O Consulta....'.$query_inserta;
                                                                            echo json_encode($a_vectt);
                                                                            exit;
                                                                    }//if_insert
                                                                    $int++;
                                                            }//foreach
                                                            $a_vectt['success']=true; $a_vectt['descrip']='Los datos han sido guardados de forma correcta ';
                                                            echo json_encode($a_vectt);
                                                            exit;
                                                        }else{
                                                            $a_vectt['success']=false; $a_vectt['descrip']='No hay datos';
                                                            echo json_encode($a_vectt);
                                                            exit;
                                                        }
                                                    }else{
                                                            if($_POST['action']=='SelectDynamic' && $row_mesinf>0){
                                                                $query_selec="select * from educacionacademica where anio='".$_POST['anio']."' and mes='".$_POST['mes']."'";
                                                               // echo $query_selec.'-->>';
                                                                $periodoNum=$db->Execute($query_selec);
                                                                $i=0;
                                                                foreach ($periodoNum as $row){
                                                                    $a_vectt[$i]['id_academicoscontinuada']=$row['id_academicoscontinuada']; 
                                                                    $a_vectt[$i]['tipo_programa']=$row['tipoprograma'];
                                                                    $a_vectt[$i]['cant_curso']=$row['cant_curso'];
                                                                    $a_vectt[$i]['cant_diplomado']=$row['cant_diplomado'];
                                                                    $a_vectt[$i]['cant_evento']=$row['cant_evento'];
                                                                    $a_vectt[$i]['num_abierto']=$row['num_abierto'];
                                                                    $a_vectt[$i]['num_cerrado']=$row['num_cerrado'];
                                                                    $a_vectt[$i]['num_pres']=$row['num_pres'];
                                                                    $a_vectt[$i]['num_vir']=$row['num_vir'];
                                                                    $a_vectt[$i]['num_sem']=$row['num_sem'];
                                                                   $i++;
                                                                }
                                                                $a_vectt['total']=$i;    $a_vectt['success']=true; $a_vectt['descrip']='Consultando';
                                                                echo json_encode($a_vectt);
                                                                exit;
                                                            }else if($_POST['action']=='UpdateDynamic'){
                                                                $j=0; $int=0;
                                                                foreach ($_POST['tipo_programa']as $row){
                                                                     $query_update="UPDATE educacionacademica SET cant_curso='".$_POST['cant_curso'][$int]."', cant_diplomado='".$_POST['cant_diplomado'][$int]."', cant_evento='".$_POST['cant_evento'][$int]."', num_abierto='".$_POST['num_abierto'][$int]."', num_cerrado='".$_POST['num_cerrado'][$int]."', num_pres='".$_POST['num_pres'][$int]."', num_vir='".$_POST['num_vir'][$int]."', num_sem='".$_POST['num_sem'][$int]."' WHERE id_academicoscontinuada='".$_POST['id_academicoscontinuada'][$int]."' ";
                                                                    // echo $query_update.'-->>';
                                                                    if($inserta= &$db->Execute($query_update)===false){
                                                                            $a_vectt['val']='FALSE'; $a_vectt['descrip']='Error En el SQL Insert O Consulta....'.$query_update;
                                                                            echo json_encode($a_vectt);
                                                                            exit;
                                                                    }else{
                                                                         $j++;
                                                                    }
                                                                    $int++;
                                                                   }
                                                                        if($j>0){
                                                                               $a_vectt['success'] =true; $a_vectt['descrip'] ='Los datos han sido modificados de forma correcta ';
                                                                                echo json_encode($a_vectt);
                                                                                exit;
                                                                        }else{
                                                                            $a_vectt['success'] =true; $a_vectt['descrip'] ='Hay un Error';
                                                                                echo json_encode($a_vectt);
                                                                                exit;
                                                                        }
                                                                
                                                            }else{ 
                                                                $a_vectt['success']=false;  $a_vectt['descrip']='No hay datosxxxx';
                                                                echo json_encode($a_vectt);
                                                                exit;
                                                            }
                                                    }
					}
				break;//case'insert_academica':
			}#switch
		}#control
	}#procesar

?>
