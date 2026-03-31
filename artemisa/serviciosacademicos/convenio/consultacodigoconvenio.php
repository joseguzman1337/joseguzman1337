<?php

require_once('../Connections/salasiq.php');
$rutaado = "../funciones/adodb/";
require_once('../Connections/salaado.php');


if(isset($_REQUEST['idsiq_convenio'])){
$success=false;
}
else{

if(isset($_REQUEST['codigoconvenio']) && $_REQUEST['codigoconvenio']!=''){

  $query_existecod = "select * from siq_convenio where codigoconvenio='".$_REQUEST['codigoconvenio']."' and codigoestado like '1%'";
  $existecod= $db->Execute($query_existecod);
  $totalRows_existecod = $existecod->RecordCount();
  $row_existecod = $existecod->FetchRow();
  
  if($totalRows_existecod !=0){  
  $success=true;  
  }
  else{
  $success=false;
  }  

  }  
  
}
$data = array('success'=> $success);
  // JSON encode and send back to the server
  echo json_encode($data);


?>