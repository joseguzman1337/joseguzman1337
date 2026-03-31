<?php
header('Content-Type: application/json');
$arrayReturn = array();
//d($variables);
$selected='';

if( $variables->cmbCarrera == '-1' ){
	$selected=' selected ';
}
//$new=true;
$arrayReturn['carreras'] = '<option value="-1" '.$selected.' >Seleccionar</option>';

if(!empty($carreras)){
	//$new=true;
	
	     $no_permitidas= array ("Ñ","Á","É","Í´","Ó","Ú");
		 $permitidas = array("ñ","á","é","í","ó","ú");
	foreach( $carreras as $carrera ) { 
		$selected='';
		if( $variables->cmbCarrera == $carrera->getCodigoCarrera( ) ){
			$selected=' selected ';
			//$new=false;
		} 
		$arrayReturn['carreras'] .= '<option value="'.$carrera->getCodigoCarrera( ).'" '.$selected.' >'.str_replace($no_permitidas,$permitidas,ucwords(strtolower($carrera->getNombreCarrera( )))).'</option>';
	}
}


if( $variables->cmbProgramaConsulta == '-1' ){
	$selected=' selected ';
}
//$new=true;
$arrayReturn['programas'] = '<option value="-1" '.$selected.' >Seleccionar</option>';
//$new2= false;
if(!empty($programas)){
	//$new2=true;
	foreach( $programas as $programa ) {
		$selected=''; 
		if( $variables->cmbProgramaConsulta == $programa->getIdProgramaPlanDesarrollo( ) ){
			$selected=' selected ';
			//$new2=false;
		} 
		$arrayReturn['programas'] .= '<option value="'.$programa->getIdProgramaPlanDesarrollo( ).'" '.$selected.' >'.$programa->getNombrePrograma( ).'</option>';
	}
}

if( $variables->cmbProyectoConsulta == '-1' ){
	$selected=' selected ';
}
$arrayReturn['proyectos'] = '<option value="-1" '.$selected.' >Seleccionar</option>';
//$new3 = false;
//ddd($proyectos);
if(!empty($proyectos)){
	
	$new3=true; 
	foreach( $proyectos as $proyecto ) { 
		$selected=''; 
		if( $variables->cmbProyectoConsulta == $proyecto->getProyectoPlanDesarrolloId( ) ){
			$selected=' selected ';
			//$new3=false;
		} 
		$arrayReturn['proyectos'] .= '<option value="'.$proyecto->getProyectoPlanDesarrolloId( ).'" '.$selected.' >'.$proyecto->getNombreProyectoPlanDesarrollo( ).'</option>';
	}
}
/*
* @ivan quintero <quinteroivan@unbosque.edu.co>
* Se cambia la consulta de indicadores por el de las metas

if( ( !empty($variables->cmbIndicadorConsulta) && $variables->cmbIndicadorConsulta == '-1') ){
	$selected=' selected ';
}

$arrayReturn['indicadores'] = '<option value="-1" '.$selected.' >Seleccionar</option>';
if(!empty($indicadores)){
	foreach( $indicadores as $indicador ) { 
		$selected=''; 
		if(  !empty($variables->cmbIndicadorConsulta) &&  $variables->cmbIndicadorConsulta == $indicador->getIndicadorPlanDesarrolloId( ) ){
			$selected=' selected ';
		} 
		$arrayReturn['indicadores'] .= '<option value="'.$indicador->getIndicadorPlanDesarrolloId( ).'" '.$selected.' >'.$indicador->getNombreIndicador( ).'</option>';
	}
}
*/

if( ( !empty($variables->cmbMetaConsulta) && $variables->cmbMetaConsulta == '-1') ){
	$selected=' selected ';
}

$arrayReturn['metas'] = '<option value="-1" '.$selected.' >Seleccionar</option>';

if(!empty($metas)){
	foreach( $metas as $meta ) { 
		$selected=''; 
		if(  !empty($variables->cmbMetaConsulta) &&  $variables->cmbMetaConsulta == $meta->getMetaIndicadorPlanDesarrolloId( ) ){
			$selected=' selected ';
		} 
		$arrayReturn['metas'] .= '<option value="'.$meta->getMetaIndicadorPlanDesarrolloId( ).'" '.$selected.' >'.$meta->getNombreMetaPlanDesarrollo( ).'</option>';
	}
}

/*END*/


//print_r($arrayReturn['metas']);exit;
if(!empty($arrayReturn)){
	echo json_encode( array('success' => true, 'values' => $arrayReturn) );
}else{
	echo json_encode( array('success' => false) );
}
?>