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
if($_GET['formulario']=='desarrollo'){

$query_anioinf = "select idsiq_ofpresupuestos from siq_ofpresupuestos where anioperiodo='".$_GET['anio']."' and idpadreclasificacionesinfhuerfana='".$_GET['padre']."' and codigoestado=100";
                $anioinf= $db->Execute($query_anioinf);
                $totalRows_anioinf = $anioinf->RecordCount();
		$row_anioinf = $anioinf->FetchRow();

if($totalRows_anioinf == 0){

    foreach($_GET as $key => $valor){
    $datosg= explode ('/',$key);
  

    if($datosg[1]=='presupuestado'){
    $presupuestado=$valor;
    }
    if($datosg[1]=='ejecutado'){
    $query_inserta="insert into siq_ofpresupuestos (idsiq_ofpresupuestos,idpadreclasificacionesinfhuerfana,idclasificacionesinfhuerfana,presupuestado,ejecutado,anioperiodo,codigoestado)
    values(0,'".$_GET['padre']."','$datosg[0]','$presupuestado','$valor','".$_GET['anio']."', 100)";
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
}

if($_GET['formulario']=='investigacion'){
  $query_periodoinf = "select idsiq_ofpresupuestos from siq_ofpresupuestos where anioperiodo='".$_GET['anio']."' and idpadreclasificacionesinfhuerfana='".$_GET['padre']."' and codigoestado=100";
		  $periodoinf= $db->Execute($query_periodoinf);
		  $totalRows_periodoinf = $periodoinf->RecordCount();
		  $row_periodoinf = $periodoinf->FetchRow();

  if($totalRows_periodoinf == 0){

      foreach($_GET as $key => $valor){
      $datosg= explode ('/',$key);      

      if($datosg[1]=='presupuestado'){
      $presupuestado=$valor;
      }
      if($datosg[1]=='ejecutado'){
      $query_inserta="insert into siq_ofpresupuestos (idsiq_ofpresupuestos,idpadreclasificacionesinfhuerfana,idclasificacionesinfhuerfana,presupuestado,ejecutado,anioperiodo,codigoestado)
      values(0,'".$_GET['padre']."','$datosg[0]','$presupuestado','$valor','".$_GET['anio']."', 100)";
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
}

if($_GET['formulario']=='biblio'){
  $query_periodoinf = "select idsiq_ofpresupuestos from siq_ofpresupuestos where anioperiodo='".$_GET['anio']."' and idpadreclasificacionesinfhuerfana='".$_GET['padre']."' and codigoestado=100";
		  $periodoinf= $db->Execute($query_periodoinf);
		  $totalRows_periodoinf = $periodoinf->RecordCount();
		  $row_periodoinf = $periodoinf->FetchRow();

  if($totalRows_periodoinf == 0){

      foreach($_GET as $key => $valor){
      $datosg= explode ('/',$key);      

      if($datosg[1]=='presupuestado'){
      $presupuestado=$valor;
      }
      if($datosg[1]=='ejecutado'){
      $query_inserta="insert into siq_ofpresupuestos (idsiq_ofpresupuestos,idpadreclasificacionesinfhuerfana,idclasificacionesinfhuerfana,presupuestado,ejecutado,anioperiodo,codigoestado)
      values(0,'".$_GET['padre']."','$datosg[0]','$presupuestado','$valor','".$_GET['anio']."', 100)";
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
}

if($_GET['formulario']=='financiamiento'){
  $query_periodoinf = "select idsiq_ofpresupuestos from siq_ofpresupuestos where anioperiodo='".$_GET['anio']."' and idpadreclasificacionesinfhuerfana='".$_GET['padre']."' and codigoestado=100";
		  $periodoinf= $db->Execute($query_periodoinf);
		  $totalRows_periodoinf = $periodoinf->RecordCount();
		  $row_periodoinf = $periodoinf->FetchRow();

  if($totalRows_periodoinf == 0){

      foreach($_GET as $key => $valor){
      $datosg= explode ('/',$key);      

      if($datosg[1]=='presupuestado'){
      $presupuestado=$valor;
      }
      if($datosg[1]=='ejecutado'){
      $query_inserta="insert into siq_ofpresupuestos (idsiq_ofpresupuestos,idpadreclasificacionesinfhuerfana,idclasificacionesinfhuerfana,presupuestado,ejecutado,anioperiodo,codigoestado)
      values(0,'".$_GET['padre']."','$datosg[0]','$presupuestado','$valor','".$_GET['anio']."', 100)";
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
}

if($_GET['formulario']=='bienestar'){
  $query_periodoinf = "select idsiq_ofpresupuestos from siq_ofpresupuestos where anioperiodo='".$_GET['anio']."' and idpadreclasificacionesinfhuerfana='".$_GET['padre']."' and codigoestado=100";
		  $periodoinf= $db->Execute($query_periodoinf);
		  $totalRows_periodoinf = $periodoinf->RecordCount();
		  $row_periodoinf = $periodoinf->FetchRow();

  if($totalRows_periodoinf == 0){

      foreach($_GET as $key => $valor){
      $datosg= explode ('/',$key);      

      if($datosg[1]=='presupuestado'){
      $presupuestado=$valor;
      }
      if($datosg[1]=='ejecutado'){
      $query_inserta="insert into siq_ofpresupuestos (idsiq_ofpresupuestos,idpadreclasificacionesinfhuerfana,idclasificacionesinfhuerfana,presupuestado,ejecutado,anioperiodo,codigoestado)
      values(0,'".$_GET['padre']."','$datosg[0]','$presupuestado','$valor','".$_GET['anio']."', 100)";
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
}


?>
