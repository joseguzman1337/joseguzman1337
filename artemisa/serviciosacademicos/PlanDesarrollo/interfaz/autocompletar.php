
<?php 
/**
 * @author Diego Rivera <riveradiego@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package interfaz
 */
 ini_set('display_errors','On');
 include '../tools/includes.php';
 include '../control/ControlIndicador.php';
 
 
 
 
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
	
	$no_permitidas= array ("á","é","í","ó","ú","Á","É","Í","Ó","Ú","ñ","À","Ã","Ì","Ò","Ù","Ã™","Ã ","Ã¨","Ã¬","Ã²","Ã¹","ç","Ç","Ã¢","ê","Ã®","Ã´","Ã»","Ã‚","ÃŠ","ÃŽ","Ã”","Ã›","ü","Ã¶","Ã–","Ã¯","Ã¤","«","Ò","Ã","Ã„","Ã‹");
	$permitidas= array ("a","e","i","o","u","A","E","I","O","U","n","N","A","E","I","O","U","a","e","i","o","u","c","C","a","e","i","o","u","A","E","I","O","U","u","o","O","i","a","e","U","I","A","E");
	
	$NIndicador=str_replace( $no_permitidas , $permitidas , $NIndicador );
	
	$salida='<ul class="list-unstyled" id="listaIndicadores">';
	
	$controlIndicador = new ControlIndicador( $persistencia );
	$indicadores = $controlIndicador->verIndicadorProyecto( $idProyecto , $NIndicador);
	$tamaño =  sizeof($indicadores);
	
	if( $tamaño > 0){
		 foreach($indicadores as $indicador){
			$salida.='<li>'.$indicador->getIndicadorPlanDesarrolloId().'-'.$indicador->getTipoIndicador().'-'.$indicador->getNombreIndicador().'</li>'; 
		}
	}else{
		$salida.="";
		//$salida.='<li>Indicador Nuevo</li>';
	}
	$salida.='</ul>';
	echo $salida;
?>