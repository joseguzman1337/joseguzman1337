<?php

session_start;
/*include_once(realpath(dirname(__FILE__)).'/../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);*/
	
include_once("../variables.php");
include($rutaTemplate."template.php");

$db = getBD();
$respuesta=array();
$Nit= $_REQUEST["nit"];

$empresaSelectSql="SELECT * FROM sala.empresa where idempresa='$Nit' AND codigoestado='100' ;";
$empresaSelectRow = $db->GetRow($empresaSelectSql);
if($empresaSelectRow!=NULL && count($empresaSelectRow)>0){
    $respuesta['mensaje']='success';
    $respuesta['nombre']=$empresaSelectRow['nombreempresa'];
}
else{
    //$respuesta['mensaje']='Error empresa no encontrada';
    $respuesta['mensaje']=$empresaSelectSql;
}


echo json_encode($respuesta);
exit;


?>
