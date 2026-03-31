<?php

/*
 * Se encarga del procesamiento de datos
 */
// this starts the session
 session_start();

require_once("../../../templates/template.php");
$db = getBD();

/*echo "<pre>";
print_r($_REQUEST);
echo "</pre>";*/
$success = true;



if($_REQUEST['formulario']=='Aulas' || $_REQUEST['formulario']=='EquipoSer' || $_REQUEST['formulario']=='EquAud' || $_REQUEST['formulario']=='DotaSal' || $_REQUEST['formulario']=='CorreosE'){
        
       $query_periodoinf="select * from siq_tecnologia where codigoperiodo='".$_REQUEST['semestre']."' and idpadreclasificacionesinfhuerfana='".$_REQUEST['padre']."' and codigoestado=100";
        //echo $query_periodoinf;
        $periodoinf=$db->Execute($query_periodoinf);
        $row_mesinf=0; $int=0;
        foreach ($periodoinf as $ro){ $row_mesinf ++; }
            if($row_mesinf==0){
                if($_REQUEST['action']=='SaveDynamic'){	
                    foreach ($_REQUEST['idclasificacionesinfhuerfana']as $row){
                                 $query_inserta="insert into siq_tecnologia (idsiq_tecnologia,idpadreclasificacionesinfhuerfana,idclasificacionesinfhuerfana,cantidad,codigoperiodo,codigoestado)
                                            values(0,'".$_REQUEST['padre']."','".$_REQUEST['idclasificacionesinfhuerfana'][$int]."','".$_REQUEST['cantidad'][$int]."','".$_REQUEST['semestre']."', 100)";
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
                   //echo $_REQUEST['action'].'-->>';
                    if($_REQUEST['action']=='SelectDynamic' && $row_mesinf>0){
                        
                        $i=0;
                        foreach ($periodoinf as $row){
                            $a_vectt[$i]['idsiq_tecnologia']=$row['idsiq_tecnologia']; 
                            $a_vectt[$i]['idclasificacionesinfhuerfana']=$row['idclasificacionesinfhuerfana'];
                            $a_vectt[$i]['cantidad']=$row['cantidad'];
                           $i++;
                        }
                        $a_vectt['total']=$i;    $a_vectt['success']=true; $a_vectt['descrip']='Consultando';
                        echo json_encode($a_vectt);
                        exit;
                    }else if($_REQUEST['action']=='UpdateDynamic'){
                       // echo "aca3..";
                       // print_r($_REQUEST['idclasificacionesinfhuerfana']);
                        $j=0; $int=0;
                        foreach ($_REQUEST['idclasificacionesinfhuerfana'] as $row){
							if(!isset($_REQUEST['idsiq_tecnololgia'][$int]) || $_REQUEST['idsiq_tecnololgia'][$int]==""){
								$query_inserta="insert into siq_tecnologia (idsiq_tecnologia,idpadreclasificacionesinfhuerfana,idclasificacionesinfhuerfana,cantidad,codigoperiodo,codigoestado)
                                            values(0,'".$_REQUEST['padre']."','".$_REQUEST['idclasificacionesinfhuerfana'][$int]."','".$_REQUEST['cantidad'][$int]."','".$_REQUEST['semestre']."', 100)";
                                    if($inserta= &$db->Execute($query_inserta)===false){
                                    $a_vectt['descrip']	='Error En el SQL Insert O Consulta....'.$query_inserta;
                                    echo json_encode($a_vectt);
                                    exit;
									}
							} else {						
                             $query_update="UPDATE siq_tecnologia SET cantidad ='".$_REQUEST['cantidad'][$int]."' WHERE idsiq_tecnologia='".$_REQUEST['idsiq_tecnololgia'][$int]."' ";
								// echo $query_update,'-->>';
								if($inserta= &$db->Execute($query_update)===false){
										$a_vectt['val']='FALSE'; $a_vectt['descrip']='Error En el SQL Insert O Consulta....'.$query_update;
										echo json_encode($a_vectt);
										exit;
								}else{
									$j++;
								}
							}
                            $int++;
                        }
                        if($j>0){
                               $a_vectt['success'] =true; $a_vectt['descrip'] ='Los datos han sido modificados de forma correcta.';
                                echo json_encode($a_vectt);
                                exit;
                        }else{
                            $a_vectt['success'] =true; $a_vectt['descrip'] ='Hay un Error';
                                echo json_encode($a_vectt);
                                exit;
                        }
                    }else{ 
                        $a_vectt['success']=false;  $a_vectt['descrip']='No hay datos.';
                        echo json_encode($a_vectt);
                        exit;
                    }
            }

}


if($_REQUEST['formulario']=='BlackBoard' || $_REQUEST['formulario']=='CapTic'){
 $query_periodoinf="select * from siq_tecnologia where codigoperiodo='".$_REQUEST['semestre']."' and idpadreclasificacionesinfhuerfana='".$_REQUEST['padre']."' and codigoestado=100";
        //echo $query_periodoinf;
        $periodoinf=$db->Execute($query_periodoinf);
        $row_mesinf=0; $int=0;
        foreach ($periodoinf as $ro){ $row_mesinf ++; }
            if($row_mesinf==0){
                if($_REQUEST['action']=='SaveDynamic'){	
                    foreach ($_REQUEST['idclasificacionesinfhuerfana']as $row){
                                 $query_inserta="insert into siq_tecnologia (idsiq_tecnologia,idpadreclasificacionesinfhuerfana,idclasificacionesinfhuerfana,cantidad,caracteristicas,codigoperiodo,codigoestado)
                                            values(0,'".$_REQUEST['padre']."','".$_REQUEST['idclasificacionesinfhuerfana'][$int]."','".$_REQUEST['cantidad'][$int]."','".$_REQUEST['caracteristicas'][$int]."','".$_REQUEST['semestre']."', 100)";
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
                   //echo $_REQUEST['action'].'-->>';
                    if($_REQUEST['action']=='SelectDynamic' && $row_mesinf>0){
                        
                        $i=0;
                        foreach ($periodoinf as $row){
                            $a_vectt[$i]['idsiq_tecnologia']=$row['idsiq_tecnologia']; 
                            $a_vectt[$i]['idclasificacionesinfhuerfana']=$row['idclasificacionesinfhuerfana'];
                            $a_vectt[$i]['cantidad']=$row['cantidad'];
                            $a_vectt[$i]['caracteristicas']=$row['caracteristicas'];
                           $i++;
                        }
                        $a_vectt['total']=$i;    $a_vectt['success']=true; $a_vectt['descrip']='Consultando';
                        echo json_encode($a_vectt);
                        exit;
                    }else if($_REQUEST['action']=='UpdateDynamic'){
                       // echo "aca3..";
                       // print_r($_REQUEST['idclasificacionesinfhuerfana']);
                        $j=0; $int=0;
                        foreach ($_REQUEST['idclasificacionesinfhuerfana'] as $row){
                             $query_update="UPDATE siq_tecnologia SET cantidad ='".$_REQUEST['cantidad'][$int]."', caracteristicas ='".$_REQUEST['caracteristicas'][$int]."' WHERE idsiq_tecnologia='".$_REQUEST['idsiq_tecnololgia'][$int]."' ";
                            // echo $query_update,'-->>';
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


if ($_REQUEST['formulario']=='form1_ti' && $_REQUEST['action']=='SelectDynamic'){
  $query_periodoinf="select * from siq_tecnologia where codigoperiodo='".$_REQUEST['semestre']."' and idpadreclasificacionesinfhuerfana='".$_REQUEST['padre']."' and codigoestado=100";
  $periodoinf=$db->Execute($query_periodoinf);
  if(!$periodoinf->EOF){
    $i=0;
    foreach ($periodoinf as $row){
      $a_vectt[$i]['idsiq_tecnologia']=$row['idsiq_tecnologia']; 
      $a_vectt[$i]['idclasificacionesinfhuerfana']=$row['idclasificacionesinfhuerfana'];
      $a_vectt[$i]['cantidad']=$row['cantidad'];
      $a_vectt[$i]['caracteristicas']=$row['caracteristicas'];
      $i++;
    }
    $a_vectt['total']=$i;    
    $a_vectt['success']=true; 
    echo json_encode($a_vectt);
    exit;
  }else{
    $query_sectores = "select idclasificacionesinfhuerfana,clasificacionesinfhuerfana from siq_clasificacionesinfhuerfana where idpadreclasificacionesinfhuerfana ='".$_REQUEST['padre']."' AND estado=1 order by 2 ";
    $sectoresinf=$db->Execute($query_sectores);
    if(!$sectoresinf->EOF){
      $i=0;
      foreach ($sectoresinf as $row){
        $a_vectt[$i]['idclasificacionesinfhuerfana']=$row['idclasificacionesinfhuerfana'];
        $a_vectt[$i]['cantidad']="";
        $a_vectt[$i]['caracteristicas']="";
        $i++;
      }
      $a_vectt['total']=$i; 
      $a_vectt['success']=false; 
      $a_vectt['descrip']='No existen datos para este periodo';
      echo json_encode($a_vectt);
      exit;

    }else{
      $a_vectt['success']=false; 
      $a_vectt['descrip']='Error en la consulta';
      echo json_encode($a_vectt);
      exit;
    }
  }
}elseif ($_REQUEST['formulario']=='form1_eq' && $_REQUEST['action']=='SelectDynamic'){
  $query_cantidad= "select * from siq_tecnologia where idpadreclasificacionesinfhuerfana ='".$_REQUEST['padre']."' and codigoperiodo='".$_POST['semestre']."' ";
  $consulta_cantidad_ea=$db->Execute($query_cantidad);
  if(!$consulta_cantidad_ea->EOF){
    foreach ($consulta_cantidad_ea as $value) {
        $cantidad_valor[$value['idclasificacionesinfhuerfana']] = $value['cantidad'];
      }
      $a_vectt['cant'] = $cantidad_valor;
      $a_vectt['success']=true; 
      $a_vectt['total'] = count($cantidad_valor);
      echo json_encode($a_vectt);
      exit;
  }else{
      $query_sectores = "select idclasificacionesinfhuerfana,clasificacionesinfhuerfana from siq_clasificacionesinfhuerfana where idpadreclasificacionesinfhuerfana ='".$_REQUEST['padre']."' order by 1";
      $sectores= $db->Execute($query_sectores);
      while($row_sectores = $sectores->FetchRow()){
        $query_hijos = "select idclasificacionesinfhuerfana,clasificacionesinfhuerfana from siq_clasificacionesinfhuerfana where idpadreclasificacionesinfhuerfana ='".$row_sectores['idclasificacionesinfhuerfana']."' order by 2 ";
        $hijos= $db->Execute($query_hijos);
        while($row_hijos= $hijos->FetchRow()){
          $cantidad_valor[$row_hijos['idclasificacionesinfhuerfana']] = "";
        }
      }
      $a_vectt['cant'] = $cantidad_valor;
      $a_vectt['success']=false; 
      $a_vectt['descrip']='No existen datos para este periodo';
      echo json_encode($a_vectt);
      exit;
    }
  }elseif ($_REQUEST['formulario']=='form1_ea' && $_REQUEST['action']=='SelectDynamic'){
  $query_consulta_ea= "select idclasificacionesinfhuerfana, cantidad from siq_tecnologia where idpadreclasificacionesinfhuerfana ='".$_REQUEST['padre']."' and codigoperiodo='".$_POST['semestre']."'";
  $consulta_cantidad_ea=$db->Execute($query_consulta_ea);
  if(!$consulta_cantidad_ea->EOF){
    foreach ($consulta_cantidad_ea as $value) {
        $cantidad_valor[$value['idclasificacionesinfhuerfana']] = $value['cantidad'];
      }
      $a_vectt['cant'] = $cantidad_valor;
      $a_vectt['success']=true; 
      $a_vectt['total'] = count($cantidad_valor);
      echo json_encode($a_vectt);
      exit;
  }else{
      $query_sectores = "select idclasificacionesinfhuerfana,clasificacionesinfhuerfana from siq_clasificacionesinfhuerfana where idpadreclasificacionesinfhuerfana ='".$row_papa['idclasificacionesinfhuerfana']."' order by 2 ";
      $sectores= $db->Execute($query_sectores);
      while($row_sectores = $sectores->FetchRow()){
        $query_hijos = "select idclasificacionesinfhuerfana,clasificacionesinfhuerfana from siq_clasificacionesinfhuerfana where idpadreclasificacionesinfhuerfana ='".$_REQUEST['padre']."' order by 2 ";
        $hijos= $db->Execute($query_hijos);
        while($row_hijos= $hijos->FetchRow()){
          $cantidad_valor[$row_hijos['idclasificacionesinfhuerfana']] = "";
        }
      }
      $a_vectt['cant'] = $cantidad_valor;
      $a_vectt['success']=false; 
      $a_vectt['descrip']='No existen datos para este periodo';
      echo json_encode($a_vectt);
      exit;
    }
  }


if($_REQUEST['formulario']=='medios'){
 $query_periodoinf = "select idmedioscomofdesarrollo from siq_medioscomofdesarrollo where anio='".$_REQUEST['anio']."' and mes='".$_REQUEST['mes']."' and codigoestado like '1%'";
		  $periodoinf= $db->Execute($query_periodoinf);
		  $totalRows_periodoinf = $periodoinf->RecordCount();
		  $row_periodoinf = $periodoinf->FetchRow();

  if($totalRows_periodoinf == 0){

      foreach($_REQUEST as $key => $valor){
      $datosg= explode ('/',$key);      

      if($datosg[1]=='medio'){
      $query_inserta="insert into siq_medioscomofdesarrollo (idmedioscomofdesarrollo,idclasificacionesinfhuerfana,numeropublicaciones,mes,anio,codigoestado)
      values(0,'$datosg[0]','$valor','".$_REQUEST['mes']."','".$_REQUEST['anio']."', 100)";
      $inserta= $db->Execute($query_inserta);
      }

      
    }
  $mensaje='Se ha almacenado de manera correcta la información para el mes '.$_REQUEST['mes'].' del año '.$_REQUEST['anio'];

  }
  else{
    $mensaje='Ya existe información almacenada para el mes '.$_REQUEST['mes'].' del año '.$_REQUEST['anio'];$success = false;
    }
$data = array('success'=> $success,'message'=> $mensaje);
// JSON encode and send back to the server
echo json_encode($data);
}

if($_REQUEST['formulario']=='redes'){
  $query_periodoinf = "select codigocarrera from siq_redesofdesarrollo where anio='".$_REQUEST['anio']."' and codigoestado like '1%'";
		    $periodoinf= $db->Execute($query_periodoinf);
		    $totalRows_periodoinf = $periodoinf->RecordCount();
		    $row_periodoinf = $periodoinf->FetchRow();
  if($totalRows_periodoinf == 0){

	foreach($_REQUEST as $key => $valor){
	$datosg= explode ('/',$key);      

	if($datosg[1]=='nacional'){
	$numeronacional=$valor;
	}

	if($datosg[1]=='intnacional'){
	$query_inserta="insert into siq_redesofdesarrollo (idredesofdesarrollo,codigocarrera,ambitonacional,ambitointernacional,anio,codigoestado)
	values(0,'$datosg[0]','$numeronacional','$valor','".$_REQUEST['anio']."', 100)";
	$inserta= $db->Execute($query_inserta);
	}
      }
    $mensaje='Se ha almacenado de manera correcta la información para el año '.$_REQUEST['anio'];

    }
    else{
      $mensaje='Ya existe información almacenada para el año '.$_REQUEST['anio'];$success = false;
      }
$data = array('success'=> $success,'message'=> $mensaje);
// JSON encode and send back to the server
echo json_encode($data);

//print_r($_REQUEST);

}

if($_REQUEST['formulario']=='asociaciones'){
 
      
      $query_inserta="insert into siq_asociacionesofdesarrollo (idasociacionesofdesarrollo,nombre_asociacionesofdesarrollo,asociacionesnacional,asociacionesinternacional,codigoperiodo,codigoestado)
      values(0,'".$_REQUEST['nombreaso']."','".$_REQUEST['nacional']."','".$_REQUEST['intnacional']."','".$_REQUEST['semestre']."', 100)";
      $inserta= $db->Execute($query_inserta);
      
  $mensaje='Se ha almacenado de manera correcta la información';

  

$data = array('success'=> $success,'message'=> $mensaje);
// JSON encode and send back to the server
echo json_encode($data);
}


?>
