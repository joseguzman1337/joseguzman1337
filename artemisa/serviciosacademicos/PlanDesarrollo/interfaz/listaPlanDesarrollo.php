<?php 
/**
 * @author Diego Rivera <riveradiego@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package interfaz
 */

ini_set('display_errors','On');
/**/@error_reporting(1023); // NOT FOR PRODUCTION SERVERS!
@ini_set('display_errors', '1'); // NOT FOR PRODUCTION SERVERS!/**/

session_start( );

include '../tools/includes.php';
include '../control/ControlRender.php';
//include '../control/ControlPlanDesarrollo.php';

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

$variables = new stdClass();
//d($_REQUEST);
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
    $controlPlanDesarrollo = new ControlPlanDesarrollo( $persistencia );

    /*Modified Diego Rivera<riveradiego@unbsoque.edu.co>
     *Se agrega validacion  para visualizar plan institucional en opcion facultad y asi mismo carge en opcion programa academico el plan institucional 
     *Since May 23 ,2018
     */
    if( $cmbFacultadPlanDesarrollo == "10000" ) {
        $programasPlanDesarrolloInstitucional = array( 'Plan Desarrollo Institucional','10000' );
        $array['programasPlanDesarrolloInstitucional'] = $programasPlanDesarrolloInstitucional ;
    
    } else {
        $programasPlanDesarrollo = $controlPlanDesarrollo->verPlanesDesarrollo( $cmbFacultadPlanDesarrollo );
        $array['programasPlanDesarrollo'] = $programasPlanDesarrollo;
            
    }
    $controlRender->render('renderPlanesDesarrollo',$array); 
	

?>