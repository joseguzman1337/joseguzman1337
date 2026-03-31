<?php

/*
 * Se encarga del procesamiento de datos
 */
// this starts the session
 session_start();

require_once("../../../templates/template.php");
$db = getBD();

/*echo "<pre>";
print_r($_GET);
echo "</pre>";*/
$success = true;
if($_GET['formulario']=='form_test'){

$query_anioinf = "select idsiq_convenioofdesarrollo from siq_convenioofdesarrollo where codigoperiodo='".$_GET['anio']."' and codigoestado=100";
                $anioinf= $db->Execute($query_anioinf);
                $totalRows_anioinf = $anioinf->RecordCount();
		$row_anioinf = $anioinf->FetchRow();

if($totalRows_anioinf == 0){

    foreach($_GET as $key => $valor){
    $datosg= explode ('/',$key);

    if($datosg[0]=='Convenio_Cooperación_Interinstitucional'){

    if($datosg[2]=='nacional'){
    $numeronacional=$valor;
    }
    if($datosg[2]=='intnacional'){
    $query_inserta="insert into siq_convenioofdesarrollo (idsiq_convenioofdesarrollo,idclasificacionesinfhuerfana,convenionacional,conveniointnacional,codigoperiodo,codigoestado)
    values(0,'$datosg[1]','$numeronacional','$valor','".$_GET['anio']."', 100)";
    $inserta= $db->Execute($query_inserta);
    }

    }
  }
$mensaje='Se ha almacenado de manera correcta la información para el año '.$_GET['anio'];
}
else{
$mensaje='Ya existe información almacenada para el año '.$_GET['anio'];
}

$query_periodoinf = "select idsiq_convenioofdesarrollo from siq_convenioofdesarrollo where codigoperiodo='".$_GET['semestre']."' and codigoestado=100";
                $periodoinf= $db->Execute($query_periodoinf);
                $totalRows_periodoinf = $periodoinf->RecordCount();
		$row_periodoinf = $periodoinf->FetchRow();

if($totalRows_periodoinf == 0){

    foreach($_GET as $key => $valor){
    $datosg= explode ('/',$key);

    if($datosg[0]=='Convenios_Interinstitucionales_para_la_Realización_de_Prácticas_Empresariales'){

    if($datosg[2]=='nacional'){
    $numeronacional=$valor;
    }
    if($datosg[2]=='intnacional'){
    $query_inserta="insert into siq_convenioofdesarrollo (idsiq_convenioofdesarrollo,idclasificacionesinfhuerfana,convenionacional,conveniointnacional,codigoperiodo,codigoestado)
    values(0,'$datosg[1]','$numeronacional','$valor','".$_GET['semestre']."', 100)";
    $inserta= $db->Execute($query_inserta);
    }

    }
  }
$mensaje2='Se ha almacenado de manera correcta la información para el periodo '.$_GET['semestre'];

}
else{
$mensaje2='Ya existe información almacenada para el periodo '.$_GET['semestre'];
$success = false;
}
 
$data = array('success'=> $success,'message'=> $mensaje, 'message2'=> $mensaje2);
// JSON encode and send back to the server
echo json_encode($data);
}

if($_GET['formulario']=='proyeccion'){
  $query_periodoinf = "select idproyeccionofdesarrollo from siq_proyeccionofdesarrollo where codigoperiodo='".$_GET['semestre']."' and codigoestado=100";
		  $periodoinf= $db->Execute($query_periodoinf);
		  $totalRows_periodoinf = $periodoinf->RecordCount();
		  $row_periodoinf = $periodoinf->FetchRow();

  if($totalRows_periodoinf == 0){

      foreach($_GET as $key => $valor){
      $datosg= explode ('/',$key);      

      if($datosg[1]=='salud'){
      $numerosalud=$valor;
      }
      if($datosg[1]=='calidad'){
      $numerocalidad=$valor;
      }
      if($datosg[1]=='otras'){
      $query_inserta="insert into siq_proyeccionofdesarrollo (idproyeccionofdesarrollo,idclasificacionesinfhuerfana,salud,calidadvida,otras,codigoperiodo,codigoestado)
      values(0,'$datosg[0]','$numerosalud','$numerocalidad','$valor','".$_GET['semestre']."', 100)";
      $inserta= $db->Execute($query_inserta);
      }

      
    }
  $mensaje='Se ha almacenado de manera correcta la información para el periodo '.$_GET['semestre'];

  }
  else{
  $mensaje='Ya existe información almacenada para el periodo '.$_GET['semestre'];$success = false;
  }
$data = array('success'=> $success,'message'=> $mensaje);
// JSON encode and send back to the server
echo json_encode($data);
}
if($_GET['formulario']=='medios'){
 $query_periodoinf = "select idmedioscomofdesarrollo from siq_medioscomofdesarrollo where anio='".$_GET['anio']."' and mes='".$_GET['mes']."' and codigoestado like '1%'";
		  $periodoinf= $db->Execute($query_periodoinf);
		  $totalRows_periodoinf = $periodoinf->RecordCount();
		  $row_periodoinf = $periodoinf->FetchRow();

  if($totalRows_periodoinf == 0){

      foreach($_GET as $key => $valor){
      $datosg= explode ('/',$key);      

      if($datosg[1]=='medio'){
      $query_inserta="insert into siq_medioscomofdesarrollo (idmedioscomofdesarrollo,idclasificacionesinfhuerfana,numeropublicaciones,mes,anio,codigoestado)
      values(0,'$datosg[0]','$valor','".$_GET['mes']."','".$_GET['anio']."', 100)";
      $inserta= $db->Execute($query_inserta);
      }

      
    }
  $mensaje='Se ha almacenado de manera correcta la información para el mes '.$_GET['mes'].' del año '.$_GET['anio'];

  }
  else{
    $mensaje='Ya existe información almacenada para el mes '.$_GET['mes'].' del año '.$_GET['anio'];$success = false;
    }
$data = array('success'=> $success,'message'=> $mensaje);
// JSON encode and send back to the server
echo json_encode($data);
}

if($_GET['formulario']=='redes'){
  $query_periodoinf = "select codigocarrera from siq_redesofdesarrollo where anio='".$_GET['anio']."' and codigoestado like '1%'";
		    $periodoinf= $db->Execute($query_periodoinf);
		    $totalRows_periodoinf = $periodoinf->RecordCount();
		    $row_periodoinf = $periodoinf->FetchRow();
  if($totalRows_periodoinf == 0){

	foreach($_GET as $key => $valor){
	$datosg= explode ('/',$key);      

	if($datosg[1]=='nacional'){
	$numeronacional=$valor;
	}

	if($datosg[1]=='intnacional'){
	$query_inserta="insert into siq_redesofdesarrollo (idredesofdesarrollo,codigocarrera,ambitonacional,ambitointernacional,anio,codigoestado)
	values(0,'$datosg[0]','$numeronacional','$valor','".$_GET['anio']."', 100)";
	$inserta= $db->Execute($query_inserta);
	}
      }
    $mensaje='Se ha almacenado de manera correcta la información para el año '.$_GET['anio'];

    }
    else{
      $mensaje='Ya existe información almacenada para el año '.$_GET['anio'];$success = false;
      }
$data = array('success'=> $success,'message'=> $mensaje);
// JSON encode and send back to the server
echo json_encode($data);

//print_r($_GET);

}

if($_GET['formulario']=='asociaciones'){
 
      
      $query_inserta="insert into siq_asociacionesofdesarrollo (idasociacionesofdesarrollo,nombre_asociacionesofdesarrollo,asociacionesnacional,asociacionesinternacional,codigoperiodo,codigoestado)
      values(0,'".$_GET['nombreaso']."','".$_GET['nacional']."','".$_GET['intnacional']."','".$_GET['semestre']."', 100)";
      $inserta= $db->Execute($query_inserta);
      
  $mensaje='Se ha almacenado de manera correcta la información';

  

$data = array('success'=> $success,'message'=> $mensaje);
// JSON encode and send back to the server
echo json_encode($data);
}


?>
