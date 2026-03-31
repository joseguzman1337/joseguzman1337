<?php
require_once ('../../kint/Kint.class.php');
//@error_reporting(1023); // NOT FOR PRODUCTION SERVERS!
//@ini_set('display_errors', '1'); // NOT FOR PRODUCTION SERVERS!

//error_reporting(E_ALL);
//ini_set('display_errors', 1);

/**
 * @author Andres Ariza <arizaandres@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque 
*/

session_start( ); 

$root = dirname(__FILE__);

define('ROOT', $root);


require_once('../../assets/Singleton.php');
require_once('../../assets/lib/ControlRender.php');
require_once('../../assets/lib/ControlUsuario.php');
require_once('../../assets/lib/paginator.class.php');
require_once('control/ControlComponentes.php');
$controlRender = new ControlRender( $root );


$option="";
$variables = new stdClass();

if($_POST){
	$keys_post = array_keys($_POST);
	foreach ($keys_post as $key_post) {
		$$key_post = strip_tags(trim($_POST[$key_post]));
		//if($key_post!='option'){
			$variables->$key_post = strip_tags(trim($_POST[$key_post]));
		//}
	}

}

if($_GET){
    $keys_get = array_keys($_GET); 
    foreach ($keys_get as $key_get){ 
        $$key_get = strip_tags(trim($_GET[$key_get]));
		//if($key_get!='option'){
			$variables->$key_get = strip_tags(trim($_GET[$key_get]));
		//}
     } 
}
//d($variables);
if( isset ( $_SESSION['MM_Username'] ) ){
	$persistencia = new Singleton( );
	$persistencia->conectar( );
	
	$txtUsuario = $_SESSION["MM_Username"];
	$txtClave = $_SESSION["key"];
	$txtIdRol = $_SESSION["rol"];
	
	$controlUsuario = new ControlUsuario( $persistencia );
	$usuario = $controlUsuario->buscar( $txtUsuario, $txtClave );
	
	$user[ 0 ] = $usuario->getId( );
	$user[ 1 ] = $usuario->getUser( );
	$user[ 2 ] = date("d_m_y h_i_s");
	//$user[ 3 ] = $usuario->getRol( );
        //$user[ 3 ] = $user[ 3 ]->getId( );
	//$user[ 4 ] = $usuario->getCarrera( );
        //$user[ 4 ] = $user[ 4 ]->getFacultad( );
        //$user[ 4 ] = $user[ 4 ]->getCodigoFacultad( );
	$persistencia->close( );
	$user[ 5 ] = $persistencia->serializar( );
	
	$_SESSION["datoSesion"] = $user;
	
	$user = $_SESSION["datoSesion"];
	$idPersona = $user[ 0 ];
	$luser = $user[ 1 ];
	$lrol = $user[3];
	$txtCodigoFacultad = $user[4];
	$persistencia = new Singleton( );
	$persistencia = $persistencia->unserializar( $user[ 5 ] );
	$persistencia->conectar( );
}
if(empty($idComponente)){
    $idComponente = null;
    //$idComponente = 610;
}
$ControlComponentes = new ControlComponentes($persistencia);
//ddd($variables);
$page = (empty($_REQUEST['page'])?1:$_REQUEST['page']);
$ipp = (empty($_REQUEST['ipp'])?1:$_REQUEST['ipp']);
$variables->page = $page;
$variables->ipp = $ipp;
if(empty($json)){
?>


<!DOCTYPE html>
<html lang="en-ES">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<?php
	include 'includes/includeCss.php';
	include 'includes/includeJs.php';
	?>
</head>
<body>
	<div class="container">
		<?php
} 
		switch($option){
			case "recargarUsuario":{
				header('Content-Type: application/json');
				$Usuarios = $ControlComponentes->getUsuariosOptionList($RelacionUsuario);
				if(!empty($Usuarios)){
					echo json_encode(array("success"=>true, "usuarios"=>$Usuarios));
				}else{
					echo json_encode(array("success"=>false));
				} 
			}break;
			case "recargarTablaComponentes":{
				$usuariosTabla = $ControlComponentes->getUsuariosTabla(@$RelacionUsuario, @$Usuario, $idComponente);
				//d($Usuario);
                                
                                $pagination = new Paginator;
                                $pagination->items_total = $_SESSION["pagination"]["totalPages"];
                                $pagination->mid_range = $_SESSION["pagination"]["size"];
                                
				$array= array(
                                        "usuariosTabla"=>$usuariosTabla, 
                                        "pagination" => $pagination,
                                        "variables" => $variables,
                                        "ControlComponentes" => $ControlComponentes
                                        );
				$controlRender->render('tablaComponentes',$array);
			}break;
			case "componentes":{
				$relacionUsuarios = $ControlComponentes->getRelacionUsuarioList();
                                $componenteList = $ControlComponentes->getComponenteList($idComponente);
                                //ddd($idComponente);
				$usuariosTabla = $ControlComponentes->getUsuariosTabla(@$RelacionUsuario, @$Usuario, @$idComponente);
				$url = "serviciosacademicos/GestionRolesYPermisos/?option=componentes";
                                $pagination = new Paginator;
                                $pagination->items_total = $_SESSION["pagination"]["totalPages"];
                                $pagination->mid_range = $_SESSION["pagination"]["size"];
                                //$pagination->setTotal($_SESSION["pagination"]["totalPages"]);
                                //ddd($usuariosTabla[0]->user);
				$array= array(
                                        "usuariosTabla"=>$usuariosTabla, 
                                        "relacionUsuarios"=>$relacionUsuarios, 
                                        "componenteList"=>$componenteList,
                                        "pagination" => $pagination, 
                                        "variables" => $variables,
                                        "ControlComponentes" => $ControlComponentes
                                        );
                                if(empty($idComponente)){
                                    $array= array(
                                        "componenteList"=>$componenteList,
                                        "variables" => $variables,
                                        "ControlComponentes" => $ControlComponentes
                                        );
                                    $controlRender->render('selectComponente',$array);
                                }else{
                                    $controlRender->render('componentes',$array);
                                }
			}break;
                        case "actualizaPermisos":{
                                if($variables->tipoPermiso=="recargarTablaComponentes"){
                                    $variables->tipoPermiso="componentes";
                                }
                                echo json_encode( $ControlComponentes->actualizaPermisos($variables) );
                        }break;
                        case "habilitarPermisosParaUsuario":{
                                if($variables->tipoPermiso=="recargarTablaComponentes"){
                                    $variables->tipoPermiso="componentes";
                                }
                                echo json_encode( $ControlComponentes->habilitarPermisosParaUsuario($variables) );
                        }break;
                        case "error":{
                                $array= array( );
				$controlRender->render('error',$array);
                        }break;
			default:{
                                $relacionUsuario = empty($_GET['RelacionUsuario'])?null:$_GET['RelacionUsuario'];
                                //d($relacionUsuario);
				$array= array(
                                            "relacionUsuario"=>$relacionUsuario
                                        );
				$controlRender->render('home',$array);
			}break;
		}
if(empty($json)){
		?>
	</div>
</body>
<?php 
} 
?>
