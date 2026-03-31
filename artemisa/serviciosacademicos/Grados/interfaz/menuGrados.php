<?php
/**
 * @author Carlos Alberto Suarez Garrido <suarezcarlos@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package interfaz
 */

header ('Content-type: text/html; charset=utf-8');

ini_set('display_errors','On');

session_start( );

include '../tools/includes.php';

//include '../control/ControlRol.php';
include '../control/ControlItem.php';

if($_POST){
	$keys_post = array_keys($_POST);
	foreach ($keys_post as $key_post) {
		$$key_post = strip_tags(trim($_POST[$key_post]));
	}
}

if($_GET){
    $keys_get = array_keys($_GET); 
    foreach ($keys_get as $key_get){ 
        $$key_get = strip_tags(trim($_GET[$key_get])); 
     } 
}


if( isset ( $_SESSION["datoSesion"] ) ){
	$user = $_SESSION["datoSesion"];
	$idPersona = $user[ 0 ];
	$luser = $user[ 1 ];
	$lrol = $user[3];
	$persistencia = new Singleton( );
	$persistencia = $persistencia->unserializar( $user[ 4 ] );
	$persistencia->conectar( );
}else{
	header("Location:error.php");
}


$padre= intval($_GET["idPadre"]);

$controlItem = new ControlItem( $persistencia );
$submenu = $controlItem->cargarSubMenu($luser, $padre);

	
?>
<script src="../js/MainMenuGrados.js"></script>
<div id="menuGrados">
	<ul>
		<?php foreach ($submenu as $item) { ?>
			<li><a href="<?php echo $item->getUrl( ); ?>"><span><?php echo $item->getNombre( ); ?></span></a></li>
		<?php }	?>
	</ul>
</div>