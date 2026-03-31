<?php
ini_set('display_errors','On');
/**/@error_reporting(1023); // NOT FOR PRODUCTION SERVERS!
@ini_set('display_errors', '1'); // NOT FOR PRODUCTION SERVERS!/**/

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
/*
 * @modified Andres Ariza <arizaandres@unbosque.edu.co>
 * Se agrega validacion de insertar a nivel de componente, esta medida es temporal mientras se define como se va a trabajar 
 * con los modulos y donde se van a registar
 * @since  marzo 21, 2017
*/
require_once('../../../assets/lib/Permisos.php');
$permisoEditar = Permisos::validarPermisosComponenteUsuario($_SESSION["MM_Username"], 610, "editar") ||Permisos::validarPermisosComponenteUsuario($_SESSION["MM_Username"], 607, "editar");
/* FIN MODIFICACION */

///////////////////// 

$option="";
$variables = new stdClass();
//d($_POST);
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
switch($option){
	case 'actualizarMetaSecundaria':{
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
		$controlLineaEstrategica = new ControlLineaEstrategica( $persistencia );
		$controlMeta = new ControlMeta( $persistencia );
		
		$lineaEstrategicas = $controlLineaEstrategica->consultarLineaEstrategica( );
		
		$metaPlanDesarrollo = $controlMeta->buscarMetaPlanDesarrollo( $txtIdMetaPrincipal );
		$valorAvances = $controlMeta->alcanceMetasSecundarias( $txtIdMetaPrincipal );
                
                $txtIdPrograma = $metaPlanDesarrollo->getProgramaProyecto( )->getPrograma( )->getIdProgramaPlanDesarrollo( ); 
		$txtIdProyecto = $metaPlanDesarrollo->getProgramaProyecto( )->getProyecto( )->getProyectoPlanDesarrolloId( );
                $alcanceMeta = $metaPlanDesarrollo->getAlcanceMeta();
		
		$metaSecundaria = $controlMeta->buscarMetaSecundaria( $txtIdMetaSecundaria );
		$metaSecundaria = $metaSecundaria[0];
		
                $array['txtIdMetaSecundaria']=$txtIdMetaSecundaria;
		$array['txtIdMetaPrincipal']=$txtIdMetaPrincipal;
		$array['txtIdPrograma']=$txtIdPrograma;
		$array['txtIdProyecto']=$txtIdProyecto;
		$array['metaSecundaria']=$metaSecundaria;
		$array['permisoEditar']=$permisoEditar;
                $array['valorAvances']=$valorAvances->getValorMetaSecundaria();
                $array['alcanceMeta']=$alcanceMeta;
		//d($array);
		$controlRender->render('actualizarMetaSecundaria',$array);
	}break;
	case 'consultarPlan':{
		
		$controlMeta = new ControlMeta($persistencia);
		/*Modified Diego Rivara <riveradiego@unbosque.edu.co>
		 *se  modifica el llamado de la meta $metas = $controlMeta->consultarMeta($variables) por $metas = $controlMeta->consultarMetaId($variables);
		 *se crean consulta por separado con respecto al cargue de los combos  
		 *Since March 29.2017
		 */
		$metas = $controlMeta->consultarMetaId($variables);
		//fin modificacion March 29.2017
		/*
		*@Ivan Quintero <quinteroivan@unbosque.edu.co>
		* Se agrega la consulta para obtener el id del indicador correspondiente
		*/
		$controlIndicador = new ControlIndicador( $persistencia );
		$indicadores = $controlIndicador->consultarIndicador( 0, $variables->cmbMetaConsultar );	
		//$indicador  = $controlIndicador->consultarDetallesIndicador( $variables->cmbIndicadorConsultar );
		$indicador  = $controlIndicador->consultarDetallesIndicador( $indicadores[0]->getIndicadorPlanDesarrolloId() );
	
		/*
		* END
		*/		
		
		$controlProyecto = new ControlProyecto( $persistencia );
		$proyecto = $controlProyecto->consultarProyectos(0,$variables->cmbProyectoConsultar);		
		
		$array['variables']=$variables;
		$array['txtCodigoFacultad']=$txtCodigoFacultad;
		$array['metas']=$metas;
		$array['indicador']=$indicador[0];
		$array['proyecto']=$proyecto[0];
		$array['permisoEditar']=$permisoEditar;		
		$controlRender->render('seguimientoPlan',$array);
		
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
		}
		if( $variables->cmbProyectoConsulta>0 ){
			if(empty($array['proyectos'])){
				$variables->cmbProyectoConsulta='-1';
			}
            $variables->cmbProyectoConsultar = $variables->cmbProyectoConsulta;
            $controlMeta = new ControlMeta( $persistencia );
            $array['metas'] = $controlMeta->consultarMeta( $variables);
		}		
		$array['variables']=$variables;
		$array['txtCodigoFacultad']=$txtCodigoFacultad;
		
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
				$array['nFacultas'] = $facultad->getNombrefacultad( );
				$array['carreras'] = $carreras;
			}
		}
		$controlRender->render('inicioSeguimientoPlanDesarrollo',$array);
	}break;
}
?>