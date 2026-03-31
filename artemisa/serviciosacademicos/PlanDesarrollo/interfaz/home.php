<?php

/*
* @Rivera Diego<arizaandres@unbosque.edu.co>
* Modificado Julio 26 del 2018
* Se unifican las claves con el archivo de configuracion
*/
require_once(realpath ( dirname(__FILE__)."/../../../sala/config/Configuration.php" ));
$Configuration = Configuration::getInstance();
require_once (PATH_SITE."/lib/Factory.php");


/**
 * @author Carlos Alberto Suarez Garrido <suarezcarlos@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package interfaz
 */
header ('Content-type: text/html; charset=utf-8');
header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

//ini_set('display_errors','On');
session_start( );

/*require_once('../../../assets/lib/Permisos.php');
if(!Permisos::validarPermisosComponenteUsuario($_SESSION["MM_Username"], 610)){
    die("no tiene permiso para acceder a este apartado");
}*/


require_once('../../../assets/lib/Permisos.php');
if(!Permisos::validarPermisosComponenteUsuario($_SESSION["MM_Username"], 610) && !Permisos::validarPermisosComponenteUsuario($_SESSION["MM_Username"], 607)){
   $actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $actual_link = explode("/serviciosacademicos", $actual_link);
    $root = $actual_link[0]."/serviciosacademicos";
    header("Location: ".$root."/GestionRolesYPermisos/index.php?option=error");
    exit();
}



include '../tools/includes.php';

//include '../control/ControlRol.php';
//include '../control/ControlRol.php';
require_once '../control/ControlItem.php';
/*include '../control/ControlClienteCorreo.php';*/
//require_once ('../../../kint/Kint.class.php');
/*require_once ('../../../assets/lib/Permisos.php');
Permisos::validarPermisosComponenteUsuario(4186, 610);/**/
		
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

$controlItem = new ControlItem( $persistencia );
$controlUsuario = new ControlUsuario( $persistencia );
$controlPlanDesarrollo = new ControlPlanDesarrollo( $persistencia );

$facilitador = $controlUsuario->buscarId( $idPersona );

$planDesarrollo = $controlPlanDesarrollo->buscarPlanDesarrollo( $txtCodigoFacultad );

if( count( $planDesarrollo->getIdPlanDesarrollo( ) != 0 ) ){
	$nombrePlan = $planDesarrollo->getNombrePlanDesarrollo( );
}

$userMenu = $facilitador->getUser( );

$menuPrincipal = $controlItem->cargarMenu($userMenu);



?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php echo Factory::printImportJsCss("css",HTTP_ROOT."/serviciosacademicos/PlanDesarrollo/css/estiloui.css");?>
<?php echo Factory::printImportJsCss("css",HTTP_ROOT."/serviciosacademicos/PlanDesarrollo/css/estilo.css");?>
<?php echo Factory::printImportJsCss("css",HTTP_ROOT."/serviciosacademicos/PlanDesarrollo/tema/time/jquery.clockpick.1.2.9.css");?>
<?php echo Factory::printImportJsCss("css",HTTP_ROOT."/serviciosacademicos/PlanDesarrollo/tema/uploadify/css/uploadifive.css");?>
<?php echo Factory::printImportJsCss("css",HTTP_ROOT."/serviciosacademicos/PlanDesarrollo/tema/paginador/css/demo_page.css");?>
<?php echo Factory::printImportJsCss("css",HTTP_ROOT."/serviciosacademicos/PlanDesarrollo/tema/paginador/css/demo_table.css");?>
<?php echo Factory::printImportJsCss("css",HTTP_ROOT."/serviciosacademicos/PlanDesarrollo/tema/paginador/css/demo_table_jui.css");?>
<?php echo Factory::printImportJsCss("css",HTTP_ROOT."/serviciosacademicos/PlanDesarrollo/tema/paginador/css/jquery.dataTables.css");?>
<?php echo Factory::printImportJsCss("css",HTTP_ROOT."/serviciosacademicos/PlanDesarrollo/tema/nicefile/css/jquery.nice-file-input.min.css");?>
<?php echo Factory::printImportJsCss("css",HTTP_ROOT."/serviciosacademicos/PlanDesarrollo/tema/paginador/media/css/dataTables.tableTools.css");?>

<?php
/**
 * @modified Andres Ariza <arizaandres@unbosque.edu.co>
 * Added a new Version of jQuery 
 * old <script src="../tema/jquery-1.7.1.js"></script>
 * @since  November 10, 2016
*/
?>
<?php echo Factory::printImportJsCss("js",HTTP_ROOT."/assets/js/jquery-3.6.0.min.js");?>
<?php 
/*END*/
?>
<?php echo Factory::printImportJsCss("js",HTTP_ROOT."/serviciosacademicos/PlanDesarrollo/tema/external/jquery.bgiframe-2.1.2.js");?>
<?php echo Factory::printImportJsCss("js",HTTP_ROOT."/serviciosacademicos/PlanDesarrollo/js/jquery-ui.min.js");?>
<?php echo Factory::printImportJsCss("js",HTTP_ROOT."/serviciosacademicos/PlanDesarrollo/js/MainHome.js");?>
<?php echo Factory::printImportJsCss("js",HTTP_ROOT."/serviciosacademicos/PlanDesarrollo/js/MainTools.js");?>
<?php echo Factory::printImportJsCss("js",HTTP_ROOT."/serviciosacademicos/PlanDesarrollo/tema/time/jquery.clockpick.1.2.9.js");?>
<?php echo Factory::printImportJsCss("js",HTTP_ROOT."/serviciosacademicos/PlanDesarrollo/tema/alfanumerico/jquery.numeric.js");?>
<?php echo Factory::printImportJsCss("js",HTTP_ROOT."/serviciosacademicos/PlanDesarrollo/tema/paginador/js/jquery.dataTables.js");?>
<?php echo Factory::printImportJsCss("js",HTTP_ROOT."/serviciosacademicos/PlanDesarrollo/tema/uploadify/js/jquery.uploadifive.min.js");?>
<?php echo Factory::printImportJsCss("js",HTTP_ROOT."/serviciosacademicos/PlanDesarrollo/tema/uploadify/js/jquery.uploadifive.js");?>
<?php echo Factory::printImportJsCss("js",HTTP_ROOT."/serviciosacademicos/PlanDesarrollo/tema/nicefile/js/jquery.nice-file-input.min.js");?>


<?php
/**
 * @modified Andres Ariza <arizaandres@unbosque.edu.co>
 * Added a new plugin CHOSEN  AND BOOTSTRAP
 * For all select list with class chosen-select
 * @since  November 2, 2016
*/
?>

<?php echo Factory::printImportJsCss("js",HTTP_ROOT."/assets/js/chosen.jquery.min.js");?>
<?php echo Factory::printImportJsCss("js",HTTP_ROOT."/assets/js/triggerChosen.js");?>
<?php echo Factory::printImportJsCss("js",HTTP_ROOT."/assets/js/bootstrap.min.js");?>
<?php echo Factory::printImportJsCss("js",HTTP_ROOT."/assets/js/bootstrap-filestyle.min.js");?>
<?php echo Factory::printImportJsCss("css",HTTP_ROOT."/assets/css/normalize.css");?>
<?php echo Factory::printImportJsCss("css",HTTP_ROOT."/assets/css/bootstrap.min.css");?>
<?php echo Factory::printImportJsCss("css",HTTP_ROOT."/assets/css/font-awesome.min.css");?>
<?php echo Factory::printImportJsCss("css",HTTP_ROOT."/assets/css/general.css");?>
<?php echo Factory::printImportJsCss("css",HTTP_ROOT."/assets/css/chosen.min.css");?>
<?php echo Factory::printImportJsCss("css",HTTP_ROOT."/serviciosacademicos/PlanDesarrollo/css/jquery-ui.css");?>
<?php echo Factory::printImportJsCss("css",HTTP_ROOT."/serviciosacademicos/PlanDesarrollo/css/jquery-ui.theme.min.css");?>
<?php echo Factory::printImportJsCss("js",HTTP_ROOT."/assets/js/bootstrap-filestyle.min.js");?>

<?php
/**
* @modified Andres Ariza <arizaandres@unbosque.edu.co>
* Added New css for font-awesome
* @since  October 19, 2016
*/
?>
<?php echo Factory::printImportJsCss("css",HTTP_ROOT."/assets/css/font-awesome.min.css");?>

<?php 
/*END*/
?>

<?php
/*
 * @modified Andres Ariza <arizaandres@unbosque.edu.co>
 * Se cambio el nombre de ingreso de sistema Sistema Plan de Desarrollo por Gestión del Plan de Desarrollo 
 * @since  January 02, 2017
*/
//<title>SISTEMA PLAN DE DESARROLLO</title>
?>
<title>GESTIÓN PLAN DE DESARROLLO</title>
<?php /*Fin Modificacion*/ ?>
</head>
<body onload="conexion( )">
<table width="100%" border="0" id="contenedor" >
  <tr>
    <td>
		<div align="center" id="contenedor-contenido">
			<br />
			<table border="0" width="100%">
				<tr>
					<td width="30%" align="left"><div id="conexion"></div></td>
					<td width="70%" align="right" id="saludo" >Bienvenido: 
						<?php echo strtoupper($facilitador->getNombres( )." ".$facilitador->getApellidos( ));?><img src="../css/images/usuario.png" />
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td width="70%" align="right" id="saludo" ><?php if( isset($nombrePlan) ) echo $planDesarrollo->getNombrePlanDesarrollo( );?></td>
				</tr>
			</table>
	
			<div id="menuFacilitador">
				<br />
				<div id="menuPlanDesarrollo" align="left">
					<?php if( count( $menuPrincipal ) > 0 ){
						
						$padre = $menuPrincipal[0]->getId( );
						$submenu = $controlItem->cargarSubMenu($luser, $padre);							
						 ?>
					<span id="menuTexto"><?php echo $menuPrincipal[0]->getNombre( ); ?></span>
						<ul>
							<?php foreach ($submenu as $item) { ?>
								<li><a class="cargaMenu" href="<?php echo $item->getUrl( ); ?>?idPlanDesarrollo=<?php echo $planDesarrollo->getIdPlanDesarrollo( );?>"><p><?php echo $item->getDescripcion( ); ?></p></a></li>
							<?php }	?>
						</ul>
					<?php } ?>
				</div>
				<br />
				<div id="contenidoPlan" align="left">
					
				</div>
			</div>
			<!--<div id="menuFacilitador">
				<ul>
					<li>
						Esto es una prueba
					</li>
				</ul>
				<!--<ul>
					<?php foreach ($menuPrincipal as $item) { ?>
						<li><a href="<?php echo $item->getUrl( ); ?>?idPadre=<?php echo $item->getId( ); ?>"><span><?php echo $item->getNombre( ); ?></span></a></li>
					<?php }	?>
				</ul>-->
			<!--</div>-->
		</div>
    </td>
  </tr>

</table>
<div id="mensageDialogo" align="left" class="ui-widget">
	<span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
	<div id="dialogo"></div>
</div>
<div id="mensageAlert" align="left" class="ui-widget">
			<span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
			<div id="alerta"></div>
		</div>
<div id="mensageCargando" align="left"></div>
<div id="log"></div>
<div id="mensageRegistrar" class="mensageRegistrar"><div>¿Desea Registrar el Plan de Desarrollo?</div></div>
<div id="eliminarMetaSecundaria" class="mensageMetaS"><div>¿Desea Eliminar la Meta Anual?</div></div>
<div id="eliminarMeta" class="mensageMetaS"><div>¿Desea Eliminar la Meta?</div></div>
<div id="mensageActualizarMetaSec" class="mensageMetaS"><div>¿Desea Actualizar la Meta Anual?</div></div>
</body>
</html>