<?php
session_start(); 
require_once("../../../templates/template.php");
$db = getBD();
$utils = new Utils_datos();
$success = true;
$mensaje = "";


// echo '<pre>';print_r($_REQUEST['aux']);die;
$data = array();
if($_REQUEST['actionID']=='BuscarData'){
    
     $SQL_Data='SELECT * 
               
               FROM 
               
               siq_fortalecimientoacademicoinfhuerfana 
               
               WHERE 
                     
                     codigocarrera = "'.$_REQUEST['aux'][0].'" 
                     AND alias = "'.$_REQUEST['alias'].'" 
                     AND periodicidad = "'.$_REQUEST['codigoperiodo'].'"';
                     
           if($R_Data=&$db->Execute($SQL_Data)===false){
                $a_vectt['val']			='FALSE';
                $a_vectt['descrip']		='Error en el SQL ...'.$SQL_Data;
                echo json_encode($a_vectt);
                exit;
           }   
           
        $C_Data  = $R_Data->GetArray();
                if(count($C_Data)>0){
			$data = $C_Data[0];
		} 
        //echo '<pre>';print_r($C_Data);
        //die;        

		$a_vectt['val']			=true;
		$a_vectt['total']		=$C_Data[0]['total_asignaturas'];
		$a_vectt['porcentaje']	=$C_Data[0]['porcentaje_utilizacion'];
		echo json_encode($a_vectt);
		exit;  
    
}
elseif($_REQUEST['alias']=='caas') {
	//print_r($_REQUEST);
	foreach ($_REQUEST['aux'] as $key => $value) {
		$query="insert into siq_fortalecimientoacademicoprofesoresinfhuerfana
				(evento
				,fechaterminacion
				,conferencista
				,numeroasistentes)
			values ( '".$_REQUEST['evento'][$key]."'
				,'".$_REQUEST['fechaterminacion'][$key]."'
				,'".$_REQUEST['conferencista'][$key]."'
				,".$_REQUEST['numeroasistentes'][$key].")";
		$db->Execute($query);
	}
	$mensaje='Información almacenada correctamente';
} else {
	$query="select id
		from siq_fortalecimientoacademicoinfhuerfana
		where periodicidad=".$_REQUEST['semestre']." and alias='".$_REQUEST['alias']."'";
        if(isset($_REQUEST["codigocarrera"]) && $_REQUEST["codigocarrera"]!=""){
            $query .= " and codigocarrera='".$_REQUEST["codigocarrera"]."'";
        }

$resultado = $db->GetRow($query);

if(count($resultado)==0) {
		foreach ($_REQUEST['aux'] as $codcar) {
			$vlr1=($_REQUEST['total_asignaturas'][$codcar])?$_REQUEST['total_asignaturas'][$codcar]:'null';
			$vlr2=($_REQUEST['porcentaje_utilizacion'][$codcar])?$_REQUEST['porcentaje_utilizacion'][$codcar]:'null';
			$query="INSERT INTO siq_fortalecimientoacademicoinfhuerfana
					(periodicidad
					,codigocarrera
					,total_asignaturas
					,porcentaje_utilizacion
					,alias)
				VALUES (".$_REQUEST['semestre']."
					,".$codcar."
					,".$vlr1."
					,".$vlr2."
					,'".$_REQUEST['alias']."')";
			$db->Execute($query);
		}
		$mensaje='Información almacenada para el semestre '.$_REQUEST['semestre'];
	} else {
			foreach ($_REQUEST['aux'] as $codcar) {
			$vlr1=($_REQUEST['total_asignaturas'][$codcar])?$_REQUEST['total_asignaturas'][$codcar]:'null';
			$vlr2=($_REQUEST['porcentaje_utilizacion'][$codcar])?$_REQUEST['porcentaje_utilizacion'][$codcar]:'null';
		//hacer update
		$query="UPDATE siq_fortalecimientoacademicoinfhuerfana
		SET total_asignaturas='".$vlr1."', porcentaje_utilizacion='".$vlr2."' 
		where id=".$resultado['id'];
				$db->Execute($query);	
			}
		$mensaje='Información actualizada para el semestre '.$_REQUEST['semestre'];
		$success = true;
	}
}

$data = array('success'=> $success,'message'=> $mensaje);
echo json_encode($data);
?>
