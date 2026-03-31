<?php
session_start(); 
require_once("../../../templates/template.php");
$db = getBD();
$utils = new Utils_datos();
$success = true;
$query="select sbu.id
	from siq_bienestaruniversitario sbu 
	join siq_clasificacionesinfhuerfana sch1 using(idclasificacionesinfhuerfana) 
	join siq_clasificacionesinfhuerfana sch2 on sch1.idpadreclasificacionesinfhuerfana=sch2.idclasificacionesinfhuerfana
	join siq_clasificacionesinfhuerfana sch3 on sch2.idpadreclasificacionesinfhuerfana=sch3.idclasificacionesinfhuerfana
	where sbu.semestre=".$_REQUEST['semestre']." and sch3.aliasclasificacionesinfhuerfana='".$_REQUEST['alias']."'";
$exec= $db->Execute($query);
if($exec->RecordCount()==0) {
	foreach ($_REQUEST['aux'] as $vlrid) {
		$vlr1=($_REQUEST['pregrado'][$vlrid])?$_REQUEST['pregrado'][$vlrid]:'null';
		$vlr2=($_REQUEST['posgrado'][$vlrid])?$_REQUEST['posgrado'][$vlrid]:'null';
		$vlr3=($_REQUEST['egresados'][$vlrid])?$_REQUEST['egresados'][$vlrid]:'null';
		$vlr4=($_REQUEST['docentes'][$vlrid])?$_REQUEST['docentes'][$vlrid]:'null';
		$vlr5=($_REQUEST['administrativos'][$vlrid])?$_REQUEST['administrativos'][$vlrid]:'null';
		$vlr6=($_REQUEST['familiares'][$vlrid])?$_REQUEST['familiares'][$vlrid]:'null';
		$vlr7=($_REQUEST['encuentros'][$vlrid])?$_REQUEST['encuentros'][$vlrid]:'null';
		$vlr8=($_REQUEST['beneficiarios'][$vlrid])?$_REQUEST['beneficiarios'][$vlrid]:'null';
		$vlr9=($_REQUEST['lunes'][$vlrid])?$_REQUEST['lunes'][$vlrid]:'null';
		$vlr10=($_REQUEST['martes'][$vlrid])?$_REQUEST['martes'][$vlrid]:'null';
		$vlr11=($_REQUEST['miercoles'][$vlrid])?$_REQUEST['miercoles'][$vlrid]:'null';
		$vlr12=($_REQUEST['jueves'][$vlrid])?$_REQUEST['jueves'][$vlrid]:'null';
		$vlr13=($_REQUEST['viernes'][$vlrid])?$_REQUEST['viernes'][$vlrid]:'null';
		$vlr14=($_REQUEST['sabado'][$vlrid])?$_REQUEST['sabado'][$vlrid]:'null';
		$query="INSERT INTO siq_bienestaruniversitario (semestre,idclasificacionesinfhuerfana,pregrado,posgrado,egresados,docentes,administrativos,familiares,encuentros_presentacion_oficiales,beneficiarios_comunidades,lunes,martes,miercoles,jueves,viernes,sabado) VALUES (".$_REQUEST['semestre'].",".$vlrid.",".$vlr1.",".$vlr2.",".$vlr3.",".$vlr4.",".$vlr5.",".$vlr6.",".$vlr7.",".$vlr8.",".$vlr9.",".$vlr10.",".$vlr11.",".$vlr12.",".$vlr13.",".$vlr14.")";
		$db->Execute($query);
	}
	$mensaje='Información almacenada para el semestre '.$_REQUEST['semestre'];
} else {
	$mensaje='Ya existe información almacenada para el semestre '.$_REQUEST['semestre'];
        $success = false;
}

$data = array('success'=> $success,'message'=> $mensaje);
echo json_encode($data);
?>
