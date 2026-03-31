<?php
/////////////////busca la ruta del managerentity
$ruta = "../";
while (!is_file($ruta.'ManagerEntity.php'))
{
    $ruta = $ruta."../";
}
require_once($ruta.'ManagerEntity.php');
$ruta = "../";
while (!is_file($ruta.'Connections/sala2.php'))
    {
        $ruta = $ruta."../";
    }
    require_once($ruta.'Connections/sala2.php');
    $rutaado = $ruta."funciones/adodb/";
require_once($ruta.'Connections/salaado.php');

/*if(!isset($_SESSION['MM_Username'])){
    $_SESSION['MM_Username'] = 'admintecnologia';
}*/

function cleanStringWord($string){
	$result = $string;
			//echo "<br/>".$result."<br/>";
			while (strpos ($result,'<!--[if') !== false) {
				$init = strpos($result, "<!--[if");
				$fin = strpos($result, "<![endif]-->");
				if($fin=="0"){
					$fin = strlen($result);
				} else {
					$fin += 12;
				}
				//echo "<br/>".$fin."<br/>";
				$temp = substr($result,0,$init);
				$tempF = substr($result,$fin,strlen($result));
				$result  = $temp.$tempF;
				//$toReplace = substr($result,$init,$fin);
				//echo "wtf!!!!??? ".$toReplace."<br/>";
				//$result = str_replace($toReplace, "", $result);
				
				//echo "que coños.... <br/>".$result;
			}
			$result = str_replace("<!--[endif]---->", "", $result);
            //$result = str_replace("<!--[if gte mso 9]>", "", $v);
            //$result = str_replace("<xml>", "", $result);
            //$result = str_replace("<o:", "", $result);
			//echo "<br/>final <br/>".$result;
    return $result;
}


///////////trae el id del usuario //////////*
$entity = new ManagerEntity("usuario");
$entity->sql_select = "idusuario";
$entity->prefix ="";
$entity->sql_where = " usuario='".$_SESSION['MM_Username']."' ";
//$entity->debug = true;
$data = $entity->getData();
$userid = $data[0]['idusuario'];

$table = $_REQUEST['entity'];
$action = $_REQUEST['action'];
$currentdate  = date("Y-m-d H:i:s");
$_POST['fechamodificacion'] = $currentdate;
$_POST['usuariomodificacion'] = $userid;
$idname= "idsiq_".$table;
$id_nam=$_REQUEST[$idname];

$entity = new ManagerEntity($table,"autoevaluacion");

if(!empty($id_nam)){
     //si existe datos en la variable $idname es porque va a modificar o eliminar
    if (!empty($_POST['duplicar']) && $_POST['verificada']==1){//si se va a duplicar una pregunta
		//echo "1";
        //////******para duplicar ****/////////
		
        $id2="";
        if (in_array('siq_Apregunta', $_POST['duplicar'])) {
             foreach($_POST['duplicar'] as $c=>$v){
                        $entity2 = new ManagerEntity($v);
                        $entity2->prefix ="";
                        $entity2->sql_where = " idsiq_Apregunta='".$_POST['idsiq_Apregunta']."' and codigoestado='100' limit 1 ";
                       // $entity2->debug = true;
                        $data2 = $entity2->getData();
                        $nr=count($data2);
                        if ($nr>0){
                            $id=$data2[0]['idsiq_Apregunta'];
                            $sql="insert into ".$v." select ";
                            $i=0;
                           //construye los insert de las tablas que tiene que duplicar
                            foreach($data2[0] as $c2=>$v2){
                                if ($c2=='duplicada'){
                                    $sql.="1 as duplicada, ";
                                }else if ($c2=='verificada'){
                                    $sql.="2 as verificada, ";
                                }else if ($c2=='idsiq_Apregunta' and !empty($id2)){
                                     $sql.="'".$id2."' as idsiq_Apregunta, ";
                                }else{
                                    if ($i==0) $sql.="'' , ";
                                    if ($i>0) $sql.=$c2.", ";
                                }
                                
                                $i++;
                            }
                            $conc=strlen($sql); $conc=$conc-2;
                            $sql=substr( $sql,0,$conc);
                            if (empty($id2)) $sql.=" FROM ".$v." WHERE idsiq_Apregunta=".$_POST['idsiq_Apregunta']." and codigoestado='100'";
                            if (!empty($id2)) $sql.=" FROM ".$v." WHERE idsiq_Apregunta='".$_POST['idsiq_Apregunta']."' and codigoestado='100'";
                            $entity3 = new ManagerEntity($v);
                            $id_aux=$entity3->insertquery($sql);
                            // $entity3->debug = true;
                            if($v=='siq_Apregunta'){
                                $id2=$id_aux;
                            }else{
                                $id3=$id_aux;
                            }
                            $result='Se modifico exitosamente';
                            $id=$id2;
                        }
                }
        }
        
        
    }else{
		//echo "2";
        ////*********para eliminar o modificar normalmente*******/////////
		//echo '<pre>';print_r($_POST);die;
        $fields = array(); 
	foreach($_POST as $c=>$v){
			/*$result = $v;
			//echo "<br/>".$result."<br/>";
			while (strpos ($result,'<!--[if') !== false) {
				$init = strpos($result, "<!--[if");
				$fin = strpos($result, "<![endif]-->");
				if($fin=="0"){
					$fin = strlen($result);
				} else {
					$fin += 12;
				}
				//echo "<br/>".$fin."<br/>";
				$temp = substr($result,0,$init);
				$tempF = substr($result,$fin,strlen($result));
				$result  = $temp.$tempF;
				//$toReplace = substr($result,$init,$fin);
				//echo "wtf!!!!??? ".$toReplace."<br/>";
				//$result = str_replace($toReplace, "", $result);
				
				//echo "que coños.... <br/>".$result;
			}
			$result = str_replace("<!--[endif]---->", "", $result);
            //$result = str_replace("<!--[if gte mso 9]>", "", $v);
            //$result = str_replace("<xml>", "", $result);
            //$result = str_replace("<o:", "", $result);
			//echo "<br/>final <br/>".$result;*/
            $fields[$c] = cleanStringWord($v);
        }	
        $entity->SetEntity($fields);
		
        $entity->fieldlist[$idname]['pkey']=$_REQUEST[$idname];
		
        if($action=='inactivate'){
            //$entity->debug = true;
            $entity->deleteRecord();
            $id=$id_nam;
        }else{
           //$entity->debug = true;        
            $entity->updateRecord();
            $id=$id_nam;
        }
    }
    
    
    $result='Se modifico exitosamente';
} else if(strcmp($action,"asociarPreguntas")==0){
		//echo "3";
     $_POST['fechacreacion'] = $currentdate;
    $_POST['usuariocreacion'] = $userid;
    
    //inactivo todas las relacionadas a esa respuesta por si estoy editando 
    $sql = "UPDATE siq_ApreguntaRespuestaDependencia SET `codigoestado`=200 WHERE idRespuesta='".$_REQUEST["idRespuesta"]."'
        AND idInstrumento='".$_REQUEST["idInstrumento"]."' AND tipo=1";
    $db->Execute($sql);
    /*for($i=0;$i<count($_POST['ids'] );$i++){
                        $id_pregunta=trim($_POST['ids'][$i]);
                        $entity->SetEntity($_POST);
                        $entity->fieldlist['idsiq_Ainstrumentoconfiguracion']['pkey']=$_POST['idsiq_Ainstrumentoconfiguracion'][$i];
                        //$entity->debug = true;
                        $entity->deleteRecord();
                }*/
               // var_dump($_POST['Apregunta1']);
                foreach ($_POST['Apregunta1'] as $key => $val) {
                   //echo $_POST['idsiq_Ainstrumento1'][$i].'<-->  <br>';
                    $id_ins=trim($_POST['idsiq_Ainstrumento1'][$key]);
                    $idPreguntaRespuestaDep=trim($_POST['idPreguntaRespuestaDep'][$key]);
                    //$_POST['idsiq_Apregunta']=$_POST['Apregunta1'][$i];
                    //$_POST['idsiq_Ainstrumentoconfiguracion']=$_POST['idsiq_Ainstrumentoconfiguracion'];
                    //echo $idPreguntaRespuestaDep;
                   if (!empty($_POST['idPreguntaRespuestaDep'][$key])){
                       // if (!empty($_POST['id_secc1'][$i])){
                             if (!empty($_POST['idsiq_Ainstrumento1'][$key])){
                                 /*if (!empty($_POST['id_secc1'][$i])){
                                    $_POST['idsiq_Aseccion']=$_POST['id_secc1'][$i];
                                 }else{
                                      $_POST['idsiq_Aseccion']=$_POST['idsiq_Aseccion2'][$i];
                                 }*/
                                    $_POST['idDependencia']=$id_ins;
                                    $_POST['codigoestado']=100;
                                    $_POST['idsiq_ApreguntaRespuestaDependencia']=$idPreguntaRespuestaDep;
                                    $entity->SetEntity($_POST);
                                    $entity->fieldlist['idsiq_ApreguntaRespuestaDependencia']['pkey']=$idPreguntaRespuestaDep;
                                    //$entity->debug = true;
                                    $entity->updateRecord();                                    
                             }
                        //}
                   }else{
                       //echo 'preg-->'.$_POST['Apregunta1'][$i].$i.'<br>';
                       if (!empty($_POST['idsiq_Ainstrumento1'][$key])){
                           $_POST['idsiq_ApreguntaRespuestaDependencia'] = NULL;
                                  //$_POST['idsiq_Aseccion']= $_POST['idsiq_Aseccion2'][$i];
                                //echo 'idsecc2 --> '.$_POST['idsiq_Aseccion2'][$i];
                            $_POST['idDependencia']=$id_ins;
                                //$_POST['idDependencia']=$_POST['idsiq_Aseccion2'][$i];
                                //$_POST['idsiq_ApreguntaRespuestaDependencia']='';
                                $entity->SetEntity($_POST);
                                //$entity->debug = true;
                                $entity->insertRecord(); 
                            
                            
                       }
                   }
               }
                 $result='Se asociaron las preguntas de forma correcta';

} else if(strcmp($action,"asociarSecciones")==0){
		//echo "4";
     $_POST['fechacreacion'] = $currentdate;
    $_POST['usuariocreacion'] = $userid;
    
    //inactivo todas las relacionadas a esa respuesta por si estoy editando 
    $sql = "UPDATE siq_ApreguntaRespuestaDependencia SET `codigoestado`=200 WHERE idRespuesta='".$_REQUEST["idRespuesta"]."'
        AND idInstrumento='".$_REQUEST["idInstrumento"]."' AND tipo=2";
    $db->Execute($sql);
    //var_dump($_REQUEST);
        $i=0;
                foreach ($_POST['Apregunta1'] as $key => $val) {
                //for($i=0;$i<count($_POST['Apregunta1']);$i++){
                    $id_ins=trim($_POST['idsiq_Ainstrumento1'][$key]);
                    $idPreguntaRespuestaDep=trim($_POST['idPreguntaRespuestaDep'][$key]);
                   if (!empty($_POST['idPreguntaRespuestaDep'][$key])){
                       // if (!empty($_POST['id_secc1'][$i])){
                             if (!empty($_POST['idsiq_Ainstrumento1'][$key])){
                                    $_POST['idDependencia']=$id_ins;
                                    $_POST['codigoestado']=100;
                                    $_POST['idsiq_ApreguntaRespuestaDependencia']=$idPreguntaRespuestaDep;
                                    $entity->SetEntity($_POST);
                                    $entity->fieldlist['idsiq_ApreguntaRespuestaDependencia']['pkey']=$idPreguntaRespuestaDep;
                                    //$entity->debug = true;
                                    $entity->updateRecord();
                             }
                        //}
                   }else{
                       if (!empty($_POST['idsiq_Ainstrumento1'][$key])){
                           $_POST['idsiq_ApreguntaRespuestaDependencia']=NULL;
                                $_POST['idDependencia']=$id_ins;
                                $entity->SetEntity($_POST);
                                //$entity->debug = true;
                                $entity->insertRecord(); 
                            
                            
                       }
                   }
               }
                 $result='Se asociaron las secciones de forma correcta';

} else{
		//echo "5";
    //echo "hola ultimo";
    ///////////inserta segun el caso/////////////////
    $_POST['fechacreacion'] = $currentdate;
    $_POST['usuariocreacion'] = $userid;
    $can_valor=count($_POST['valor1']); // para los tipos de preguntas
    $can_preg=count($_POST['Apregunta1']); //para las preguntas
    $inser="";
    
    ////////////********* para insertar o moduficar las respuestas **********/////////////
    if ($can_valor>0){
            $id_a=null;
            for($i=0;$i<count($_POST['valor1'] );$i++){
                $valor=trim($_POST['valor1'][$i]);
                $resp=trim($_POST['respuesta1'][$i]);
                $id_r=trim($_POST['idsiq_Arespuesta1'][$i]);
                $corr=trim($_POST['correcta1'][$i]);
                $_POST['respuesta']=$resp;
                $_POST['valor']=$valor;
                $_POST['idsiq_Apreguntarespuesta']=$id_r;
                $_POST['correcta']=$corr;
                if ($corr=='on') $_POST['correcta']='1';
                if ($corr=='off' or $corr=='') $_POST['correcta']='0';
                
                
                if (empty($id_r)){
                    if ($valor!=''){
						  $fields = array(); 
							foreach($_POST as $c=>$v){
								$fields[$c] = cleanStringWord($v);
							}	
						$entity->SetEntity($fields);
                        //$entity->SetEntity($_POST);
                       // $entity->debug = true;
                        $id_a[$i]=$entity->insertRecord();
                        $inser='ok';
                    }
                }else{
						  $fields = array(); 
							foreach($_POST as $c=>$v){
								$fields[$c] = cleanStringWord($v);
							}	
						$entity->SetEntity($fields);
                    //$entity->SetEntity($_POST);
                    $entity->fieldlist['idsiq_Apreguntarespuesta']['pkey']=$id_r;
                    //$entity->debug = true;
                    if ($valor=='0'){
                    $entity->deleteRecord();
                    }else{
                        $entity->updateRecord();
                    }

                }
                $result='Se registro exitosamente';

            }
            $id=$id_a;
			
			//nuevo campo RequiereJustificacion
			
				$entity = new ManagerEntity("Apregunta","autoevaluacion");
				$pregunta["idsiq_Apregunta"]=$_POST['idsiq_Apregunta'];
				if(isset($_POST["RequiereJustificacion"])){
					$pregunta["RequiereJustificacion"]=$_POST["RequiereJustificacion"];
				} else {
					$pregunta["RequiereJustificacion"]=0;
				}
				$entity->SetEntity($pregunta);
                $entity->fieldlist['idsiq_Apregunta']['pkey']=$_POST['idsiq_Apregunta'];
				//$entity->debug = true;
				$entity->updateRecord();
			
        }else if (!empty($_POST['totalindicadores'])){
             ////////*******para guardar o modificar los indicadores**********/////////
                //print_r($_POST['idsiq_Apreguntaindicador1']);
                $id=$_POST['idsiq_Apregunta'];
                for($i=0;$i<count($_POST['idsiq_Apreguntaindicador1']);$i++){
                    $_POST['idsiq_Apreguntaindicador']=$_POST['idsiq_Apreguntaindicador1'][$i];
                     $entity->SetEntity($_POST);
                     $entity->fieldlist['idsiq_Apreguntaindicador']['pkey']=$_POST['idsiq_Apreguntaindicador1'][$i];
                     $entity->debug = true;
                     $entity->deleteRecord();
                }
                $indi = explode(",",$_POST['totalindicadores']); 
                for($i=0;$i<count($indi);$i++){
                   if ($indi[$i]!='0'){
                     $_POST['disiq_indicador']=$indi[$i];
                      $id_r=trim($_POST['idsiq_Arespuesta1'][$i]);
                      $id_api=trim($_POST['idsiq_Apreguntaindicador1'][$i]);
                      $_POST['idsiq_Apreguntaindicador']=$_POST['idsiq_Apreguntaindicador1'][$i];
                      if (!empty($id_api)){
                          $entity->SetEntity($_POST);
                          $entity->fieldlist['idsiq_Apreguntaindicador']['pkey']=$id_api;
                          $entity->updateRecord();
                      }else{
                         $entity->SetEntity($_POST);
                       // $entity->debug = true;
                        $entity->insertRecord(); 
                      }
                     
                   }
                }
                $result='Se registro exitosamente';
            }else if (!empty($_POST['totalsecciones'])){
              ////////*******para guardar o modificar las secciones**********/////////
                $id=$_POST['idsiq_Ainstrumentoconfiguracion'];
                //inactivo todas las relacionadas a esa respuesta por si estoy editando 
            $sql = "UPDATE siq_Ainstrumentoseccion SET `codigoestado`=200 WHERE idsiq_Ainstrumentoconfiguracion='".$id."' ";
            $db->Execute($sql);
            
                $indi = explode(",",$_POST['totalsecciones']); 
                for($i=0;$i<count($indi);$i++){
                   if ($indi[$i]!='0' && $indi[$i]!=0){
                     $_POST['idsiq_Aseccion']=$indi[$i];
                      $id_r=trim($_POST['idsiq_Aseccion1'][$i]);
                      $id_api=trim($_POST['idsiq_Ainstrumentoseccion1'][$i]);
                      $_POST['idsiq_Ainstrumentoseccion']=$_POST['idsiq_Ainstrumentoseccion1'][$i];
                      if (!empty($id_api)){
						     $fields = array(); 
							foreach($_POST as $c=>$v){
									$fields[$c] = cleanStringWord($v);
								}	
                          $entity->SetEntity($fields);
                          $entity->fieldlist['idsiq_Ainstrumentoseccion']['pkey']=$id_api;
                          //$entity->debug = true;
                          $entity->updateRecord();
                      }else{
                           $sql = "SELECT idsiq_Ainstrumentoseccion FROM siq_Ainstrumentoseccion 
                          WHERE idsiq_Ainstrumentoconfiguracion='".$id."' AND idsiq_Aseccion='".$_POST['idsiq_Aseccion']."'
                             AND codigoestado=100 ";
                           $row =  $db->GetRow($sql);
                            if(count($row)===0){
						     $fields = array(); 
								foreach($_POST as $c=>$v){
									$fields[$c] = cleanStringWord($v);
								}	
                                $entity->SetEntity($fields);
                                    // $entity->debug = true;
                                $entity->insertRecord(); 
                           } /*else {
                                $sql = "UPDATE siq_Ainstrumentoseccion SET `codigoestado`=100 WHERE idsiq_Ainstrumentoseccion='".$row["idsiq_Ainstrumentoseccion"]."' ";
                                $db->Execute($sql);  
                           }*/
                      }
                     
                   }
                }
                $result='Se registro exitosamente';
            }else if (!empty($_POST['totalusuarios'])){
              ////////*******para guardar o modificar los usuarios asignados**********/////////
                $id=$_POST['idsiq_Ainstrumentoconfiguracion'];
               // print_r($_POST['idsiq_Ainstrumentousuario1']);
                for($i=1;$i<count($_POST['idsiq_Ainstrumentousuario1'])+1;$i++){
                    $_POST['idsiq_Ainstrumentousuario']=$_POST['idsiq_Ainstrumentousuario1'][$i];
                     $entity->SetEntity($_POST);
                     $entity->fieldlist['idsiq_Ainstrumentousuario']['pkey']=$_POST['idsiq_Ainstrumentousuario1'][$i];
                     //$entity->debug = true;
                     $entity->deleteRecord();
                }
               // var_dump($_POST['idsiq_Ainstrumentousuario1'][0]);
//               var_dump($_POST['totalusuarios']);
                $indi = explode(",",$_POST['totalusuarios']); 

                for($i=0;$i<count($indi);$i++){
                  // echo $indi[$i].'->val';
                   if ($indi[$i]!='0'){
                     $_POST['idusuario']=trim($indi[$i]);
                      $id_r=trim($_POST['idusuario1'][$i]);
                      $id_api=trim($_POST['idsiq_Ainstrumentousuario1'][$i]);
                     // echo $id_api.'->'.$i.'idapi<br>';
                      $_POST['idsiq_Ainstrumentousuario']=$_POST['idsiq_Ainstrumentousuario1'][$i];
                      if (!empty($id_api)){
                          $entity->SetEntity($_POST);
                          $entity->fieldlist['idsiq_Ainstrumentousuario']['pkey']=$id_api;
                          //echo $id_api.'->id    ';
                          //$entity->debug = true;
                          $entity->updateRecord();
                      }else{
                         $entity->SetEntity($_POST);
                        //$entity->debug = true;
                        $entity->insertRecord(); 
                      }
                     
                   }
                }
                $result='Se registro exitosamente';
            }else if (!empty($_POST['idPregunta'])){
                //////////*********inserta los analisis de las preguntas***********////////////
                for($i=0;$i<(count($_POST['idPregunta'])+1);$i++){
                    //echo "pregunta->".$_POST['idPregunta'][$i].' Analisis->'.$_POST['analisis2'][$i];
                    $_POST['idsiq_Apregunta']=$_POST['idPregunta'][$i];
                    $_POST['idsiq_Ainstrumentoconfiguracion']=$_POST['id_Ins'][$i];
                    $_POST['analisis']=$_POST['analisis2'][$i];
                    if (empty($_POST['Ainstrumentoanalisis'][$i])){
                        if (!empty($_POST['analisis'])){
                            $entity->SetEntity($_POST);
                          //  $entity->debug = true;
                            $entity->insertRecord(); 
                        }
                    }else{
                     $_POST['idsiq_Ainstrumentoanalisis']=$_POST['Ainstrumentoanalisis'][$i];
                     $entity->SetEntity($_POST);
                     $entity->fieldlist['idsiq_Ainstrumentoanalisis']['pkey']=$_POST['Ainstrumentoanalisis'][$i];
                     //$entity->debug = true;
                     $entity->updateRecord(); 
                    }
                    
                }
                $result='Se registro exitosamente';
            }else if ($can_preg>0){
                ///////////**********relaciona las preguntas con las secciones*****////////
                for($i=0;$i<count($_POST['ids'] );$i++){
                        $id_pregunta=trim($_POST['ids'][$i]);
                        $entity->SetEntity($_POST);
                        $entity->fieldlist['idsiq_Ainstrumentoconfiguracion']['pkey']=$_POST['idsiq_Ainstrumentoconfiguracion'][$i];
                        //$entity->debug = true;
                        $entity->deleteRecord();
                }
               // var_dump($_POST['Apregunta1']);
                for($i=0;$i<count($_POST['ids']);$i++){
                   //echo $_POST['idsiq_Ainstrumento1'][$i].'<-->  <br>';
                    $id_ins=trim($_POST['idsiq_Ainstrumento1'][$i]);
                    $_POST['idsiq_Apregunta']=$_POST['Apregunta1'][$i];
                    $_POST['idsiq_Ainstrumentoconfiguracion']=$_POST['idsiq_Ainstrumentoconfiguracion'];
                    //echo $id_ins.'-->id   ';
                   if (!empty($_POST['idsiq_Ainstrumento1'][$i])){
                       // if (!empty($_POST['id_secc1'][$i])){
                             if (!empty($_POST['Apregunta1'][$i])){
                                 if (!empty($_POST['id_secc1'][$i])){
                                    $_POST['idsiq_Aseccion']=$_POST['id_secc1'][$i];
                                 }else{
                                      $_POST['idsiq_Aseccion']=$_POST['idsiq_Aseccion2'][$i];
                                 }
                                    $_POST['idsiq_Ainstrumento']=$id_ins;
                                    $_POST['codigoestado']=100;
                                    $entity->SetEntity($_POST);
                                    $entity->fieldlist['idsiq_Ainstrumento']['pkey']=$id_ins;
                                    //$entity->debug = true;
                                    $entity->updateRecord();
                             }
                        //}
                   }else{
                       //echo 'preg-->'.$_POST['Apregunta1'][$i].$i.'<br>';
                       if (!empty($_POST['Apregunta1'][$i])){
                            if (empty($_POST['id_secc1'][$i])){
                                  //$_POST['idsiq_Aseccion']= $_POST['idsiq_Aseccion2'][$i];
                                //echo 'idsecc2 --> '.$_POST['idsiq_Aseccion2'][$i];
                                $_POST['idsiq_Aseccion']=$_POST['idsiq_Aseccion2'][$i];
                                $_POST['idsiq_Ainstrumento']='';
                                $entity->SetEntity($_POST);
                                //$entity->debug = true;
                                $entity->insertRecord(); 
                            }
                            
                            
                       }
                   }
                    
                }
                 $result='Se registro exitosamente';
                //echo "hola";
            }else{
                /////////****insertar normal******/////////
				$fields = array(); 
				foreach($_POST as $c=>$v){
					$fields[$c] = cleanStringWord($v);
				}	
                $entity->SetEntity($fields);
                //$entity->SetEntity($_POST);
                //$entity->debug = true;
                $id=$entity->insertRecord();
                $result='Se registro exitosamente';
            }
}

$data = array('success'=> true,'message'=> $result,'id'=>$id);
//print_r($data);
echo json_encode($data);
?>