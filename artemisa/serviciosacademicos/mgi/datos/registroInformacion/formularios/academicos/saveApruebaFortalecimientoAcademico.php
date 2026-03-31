<?php
session_start(); 
require_once("../../../templates/template.php");
$db = getBD();
$utils = new Utils_datos();
$success = true;
$mensaje = "";

if($_REQUEST['alias']=='apeirbyh' || $_REQUEST['alias']=='auleaaecpupa' || $_REQUEST['alias']=='aaiaaepu' || $_REQUEST['alias']=='aihmtaeaaput') {	
	
	
	if(isset($_GET['Verificado'])){
	$Verificado=1;
	}
	else{
	$Verificado=0;
	}
	
	$query="update siq_fortalecimientoacademicoinfhuerfana set Verificado ='$Verificado' 
	where periodicidad='".$_REQUEST['semestre']."' 
	and alias='".$_REQUEST['alias']."' 
	and codigocarrera='".$_REQUEST["nacodigocarrera"]."'";
	$db->Execute($query);	
	
}
/*$data = array('success'=> $success,'message'=> $mensaje);
echo json_encode($data);*/
?>
