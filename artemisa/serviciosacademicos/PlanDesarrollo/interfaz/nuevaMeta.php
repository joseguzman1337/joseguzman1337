<?php 

 /**
 * @author Diego Rivera <riveradiego@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package interfaz
 */
 ini_set('display_errors','On');
 include '../tools/includes.php';
 include '../control/ControlIndicador.php';
 include '../control/ControlTipoIndicador.php';
 include '../control/ControlProyecto.php';
 include '../control/ControlMeta.php';
 
 
 session_start( );
 
 if($_POST){
		$keys_post = array_keys($_POST);
		foreach ($keys_post as $key_post) {
			if( is_array($_POST[$key_post]) ){
				$$key_post = $_POST[$key_post];
			}else{
				$$key_post = strip_tags(trim($_POST[$key_post]));
			}
		}
	}
	
if($_GET){
    $keys_get = array_keys($_GET); 
    foreach ($keys_get as $key_get){
    	if( is_array($_GET[$key_get]) ){ 
        	$$key_get = $_GET[$key_get];
		}else{
			$$key_post = strip_tags(trim($_GET[$key_get]));
		}
     } 
}
 
 
 
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

$controlIndicador = new ControlIndicador( $persistencia );
$controlMeta = new ControlMeta( $persistencia );

/*Modified Diego Rivera<riveradiego@unbosque.edu.co>
 * recibe variables $tipoIndicador, $idProyecto, $indicadorPlan, $idPersona
 * se añade condicional para identificar si existe o no el indicador  en caso de no existir lo crea  
 * Since April 6 ,2017
 * */
 
 //echo $idIndicador.'--'.$metaPlan.'--'. $valorMeta.'--'. $idPersona.'--'. $idProyecto;
	if( $idIndicador == "" ){
			$controlIndicador->crearIndicadorPlanDesarrollo( $tipoIndicador, $idProyecto, $indicadorPlan, $idPersona);
		    $idIndicador = $persistencia->lastId( );
			
			$controlMeta->crearMetaPrincipalNueva( $idIndicador , $metaPlan, $valorMeta, $idPersona , $idProyecto );
			echo '1';
			
		} else {
			
			$controlMeta->crearMetaPrincipalNueva( $idIndicador , $metaPlan, $valorMeta, $idPersona , $idProyecto );
			echo '1';
			}

/*Modified Diego Rivera<riveradiego@unbosque.edu.co>
 * crea meta prrincipal
 */

?>