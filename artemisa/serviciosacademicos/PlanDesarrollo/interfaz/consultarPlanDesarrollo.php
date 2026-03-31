<?php
require_once ('../../../kint/Kint.class.php'); 
/**
 * @author Andres Ariza <arizaandres@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package interfaz
*/

session_start( );

include '../tools/includes.php';

//include '../control/ControlRol.php';
include '../control/ControlRender.php';
include '../control/ControlItem.php';
include '../control/ControlPeriodo.php';
include '../control/ControlLineaEstrategica.php';
include '../control/ControlPrograma.php';
include '../control/ControlProyecto.php';
include '../control/ControlIndicador.php';
include '../control/ControlMeta.php';
include '../control/ControlTipoIndicador.php';
include '../control/ControlProgramaProyecto.php';




if( isset ( $_SESSION["datoSesion"] ) ){
	$user = $_SESSION["datoSesion"];
	$idPersona = $user[ 0 ];
	$luser = $user[ 1 ];
	$lrol = $user[3]; 
	$txtCodigoFacultad = $user[4];
	$persistencia = new Singleton( );
	$persistencia = $persistencia->unserializar( $user[ 5 ] );
	$persistencia->conectar( );
}else{
	header("Location:error.php");
}

///////////////////// 

$option="";
$variables = new stdClass();

if($_POST){
	$keys_post = array_keys($_POST);
	foreach ($keys_post as $key_post) {
		$$key_post = strip_tags(trim($_POST[$key_post]));
		if($key_post!='option'){
			$variables->$key_post = strip_tags(trim($_POST[$key_post]));
		}
	}

}

if($_GET){
    $keys_get = array_keys($_GET); 
    foreach ($keys_get as $key_get){ 
        $$key_get = strip_tags(trim($_GET[$key_get]));
		
		if($key_get!='option'){
			$variables->$key_get = strip_tags(trim($_GET[$key_get]));
		}
     } 
}
$controlRender = new ControlRender(  );
$controlLineaEstrategica = new ControlLineaEstrategica( $persistencia );
$controlFacultad = new ControlFacultad($persistencia);


$controlFacultad = new ControlFacultad($persistencia);



switch($option){
	
	case 'consultarPlan':{
	//d($_POST);

		$controlMeta = new ControlMeta($persistencia);
		unset($variables->cmbIndicadorConsultar);

		$metas = $controlMeta->consultarMeta($variables);
		
		$controlIndicador = new ControlIndicador( $persistencia );
		$controlCarrera =new ControlCarrera($persistencia); 
		$controlProyecto = new ControlProyecto( $persistencia );
		$proyecto = $controlProyecto->consultarProyectos(0,$variables->cmbProyectoConsultar);
		//ddd($proyecto);
		//$cbmCarrera=123;
		$array['variables']=$variables;
		$array['txtCodigoFacultad']=$txtCodigoFacultad;
		$array['metas']=$metas;
		$array['facultades']=$facultades;
		$array['carreras']=$carreras;
		$array['lineas']=$lineas;
		$array['programas']=$programas;
		$array['proyectos']=$proyectos;
		//$array['indicador']=$indicador[0];
		$array['proyecto']=$proyecto[0];
		
		$controlRender->render('consultarPlan',$array);
		
	}break;
	case 'updateSelectLists':{
	
		$array = array();
		if(empty($txtCodigoFacultad) || $txtCodigoFacultad=="10"){
			$facultades = $controlLineaEstrategica->consultarFacultades();
			$array['facultades'] = $facultades;
		}
		
		$controlFacultad = new ControlFacultad( $persistencia );
		$facultad = $controlFacultad->buscarFacultadId( $txtCodigoFacultad );
		
		if( count( $facultad->getCodigoFacultad( ) != 0 ) ){
			if($variables->txtCodigoFacultad > 0 ){
				$controlCarrera = new ControlCarrera( $persistencia );
				$carreras = $controlCarrera->consultar( $variables->txtCodigoFacultad );
			
				$array['carreras'] = $carreras;
			}
		}
		
		
		
		if($variables->cbmLineaConsulta>0){
			$controlPrograma = new ControlPrograma( $persistencia ); 
			$array['programas'] = $controlPrograma->consultarProgramas( $variables );
		}
		if( $variables->cmbProgramaConsulta>0 ){
			if(empty($array['programas'])){
				$variables->cmbProgramaConsulta='-1';
			}
			$controlProyecto = new ControlProyecto( $persistencia );
			$array['proyectos'] = $controlProyecto->consultarProyectos( $variables->cmbProgramaConsulta );
		}/**/
		if( $variables->cmbProyectoConsulta>0 ){
			if(empty($array['proyectos'])){
				$variables->cmbProyectoConsulta='-1';
			}
			
		
			
			$controlIndicador = new ControlIndicador( $persistencia );
			$array['indicadores'] = $controlIndicador->consultarIndicador( $variables->cmbProyectoConsulta );
		}
		$array['variables']=$variables;
		$array['txtCodigoFacultad']=$txtCodigoFacultad;
		//d($array);
		$controlRender->render('renderSelects',$array);
	}break;
        default:{
		$controlLineaEstrategica = new ControlLineaEstrategica( $persistencia );
		$lineaEstrategicas = $controlLineaEstrategica->consultarLineaEstrategica( );
	
		$array = array(
					"lineaEstrategicas" => $lineaEstrategicas, 
					"programas" => array(), 
					"proyectos" => array(),
					'txtCodigoFacultad' => $txtCodigoFacultad
				 );
		if(empty($txtCodigoFacultad) || $txtCodigoFacultad=="10"){
			$facultades = $controlLineaEstrategica->consultarFacultades();
			$array['facultades'] = $facultades;
		}else{
			$controlFacultad = new ControlFacultad( $persistencia );
			$facultad = $controlFacultad->buscarFacultadId( $txtCodigoFacultad );
		
			if( count( $facultad->getCodigoFacultad( ) != 0 ) ){
				$controlCarrera = new ControlCarrera( $persistencia );
				$carreras = $controlCarrera->consultar( $txtCodigoFacultad );
				$array['carreras'] = $carreras;
			}
		}
		
		$controlRender->render('inicioConsultarPlanDesarrollo',$array);
	}break;
}

?>
