<?php
	/**
	 * @author Carlos Alberto Suarez Garrido <suarezcarlos@unbosque.edu.co>
	 * @copyright Dirección de Tecnología Universidad el Bosque
	 * @package interfaz
	 
	 
	 * Ivan dario quintero rios <quinteroivan@unbosque.edu.co 
	 * modificado 05 julio 2017 - 13:00:00
	 * Limpieza de codigo, eliminacion de codigo en comentarios y orgalizacion a la linea.
	 */

	header ('Content-type: text/html; charset=utf-8');
	header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
	header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
	header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache");

	ini_set('display_errors','On');
	//error_reporting(E_ALL);
	session_start( );

	include '../tools/includes.php';
	include '../control/ControlItem.php';

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

	$controlItem = new ControlItem( $persistencia );
	$controlUsuario = new ControlUsuario( $persistencia );

	$facilitador = $controlUsuario->buscarId( $idPersona );

	$userMenu = $facilitador->getUser( );

	$menuPrincipal = $controlItem->cargarMenu($userMenu);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<style type="text/css">
		  @import url("../tema/themes/base/jquery.ui.all.css");
		  @import url("../css/estiloui.css");
		  @import url("../css/estilo.css");
		  @import url("../tema/time/jquery.clockpick.1.2.9.css");
		  @import url("../tema/uploadify/css/uploadifive.css");
		  @import "../tema/paginador/css/demo_page.css";
		  @import "../tema/paginador/css/demo_table.css";
		  @import "../tema/paginador/css/demo_table_jui.css";
		  @import "../tema/paginador/css/jquery.dataTables.css";
		  @import "../tema/nicefile/css/jquery.nice-file-input.min.css";
		  /*@import "../tema/paginador/css/jquery.dataTables_themeroller.css";*/

		  @import "../tema/paginador/media/css/dataTables.tableTools.css";
		</style>
		<script src="../tema/jquery-1.7.1.js"></script>
		<script src="../tema/external/jquery.bgiframe-2.1.2.js"></script>
		<script src="../tema/ui/jquery.ui.core.js"></script>
		<script src="../tema/ui/jquery.ui.widget.js"></script>
		<script src="../tema/ui/jquery.ui.mouse.js"></script>
		<script src="../tema/ui/jquery.ui.accordion.js"></script>
		<script src="../tema/ui/jquery.ui.datepicker.js"></script>
		<script src="../tema/ui/jquery.ui.slider.js"></script>
		<script src="../tema/ui/jquery.ui.draggable.js"></script>
		<script src="../tema/ui/jquery.ui.sortable.js"></script>
		<script src="../tema/ui/jquery.ui.droppable.js"></script>
		<script src="../tema/ui/jquery.ui.tabs.js"></script>
		<script src="../tema/ui/jquery.ui.position.js"></script>
		<script src="../tema/ui/jquery.ui.resizable.js"></script>
		<script src="../tema/ui/jquery.ui.dialog.js"></script>
		<script src="../tema/ui/jquery.ui.button.js"></script>
		<script src="../tema/ui/jquery.ui.autocomplete.js"></script>
		<script src="../tema/ui/i18n/jquery.ui.datepicker-es.js"></script>
		<script src="../js/MainHome.js"></script>
		<script src="../js/MainTools.js"></script>
		<script src="../tema/time/jquery.clockpick.1.2.9.js"></script>
		<script src="../tema/alfanumerico/jquery.numeric.js"></script>
		<script src="../tema/paginador/js/jquery.dataTables.js"></script>
		<script src="../tema/uploadify/js/jquery.uploadifive.min.js"></script>
		<script src="../tema/uploadify/js/jquery.uploadifive.js"></script>
		<script src="../tema/nicefile/js/jquery.nice-file-input.min.js"></script>

		<title>SISTEMA DE GRADOS</title>
	</head>
	<body onload="conexion( )">
		<table width="100%" border="0" id="contenedor" >
  			<!--<tr>
    			<td>
					<div id="contenedor-header">
						<table id="header" width="100%" border="0">
							<tr>
								<th width="11%" rowspan="2" scope="row"><div class="izquierdo"></div></th>
								<td width="76%" height="66" align="right">
									<table class="menu" width="100%" border="0">
							  			<tr>
											<td align="right">
												<?php if( $lrol != 25 && $lrol != 53 && $lrol != 89 && $lrol != 13 ) { ?>
												<a id="ayuda" href="../manual/ManualUsuarioFacultad.pdf" target="_blank"><img src="../css/images/ayuda.jpg" alt="Ayuda"/></a>
												<?php }else{
												switch($lrol){
												case "13": ?>
												 <a id="ayuda" href="../manual/ManualUsuarioRegistroControl.pdf" target="_blank"><img src="../css/images/ayuda.jpg" alt="Ayuda"/></a>
												<?php break;
												case "89": ?>
												 <a id="ayuda" href="../manual/ManualUsuarioConsejoDirectivo.pdf" target="_blank"><img src="../css/images/ayuda.jpg" alt="Ayuda"/></a>
												<?php break;
												case "25":
												case "53": ?>
												 <a id="ayuda" href="../manual/ManualUsuarioSecretaria.pdf" target="_blank"><img src="../css/images/ayuda.jpg" alt="Ayuda"/></a>
												<?php break;
													}
												} ?>
											</td>
							  			</tr>
									</table>
								</td>
								<td width="13%" rowspan="2"><div class="derecho"></div></td>
							</tr>
							<tr>
								<td align="center"><div class="centro">Sistema de Administración de Grados</div></td>
							</tr>
						</table>	
					</div>    
				</td>
			</tr>-->	
			<tr>
				<td>
					<div align="center" id="contenedor-contenido">
						<!--<table border="0" width="100%">
							<tr>
								<td width="30%" align="left"><div id="conexion"></div></td>
								<td width="70%" align="right" id="saludo" >Bienvenido : 
									<?php echo strtoupper($facilitador->getNombres( )." ".$facilitador->getApellidos( ));?><img src="../css/images/usuario.png" />
								</td>
							</tr>
						</table>-->
						<div id="menuFacilitador">
							<ul>
								<?php foreach ($menuPrincipal as $item) { ?>
									<li><a href="<?php echo $item->getUrl( ); ?>?idPadre=<?php echo $item->getId( ); ?>"><span><?php echo $item->getNombre( ); ?></span></a></li>
								<?php }	?>
							</ul>
						</div>
					</div>
				</td>
			</tr>
			<!--<tr>
				<td>
					<div id="contenedor-foot">
						<br /><br />
						<div align="center">
							<span style="color: white; font-size: 9pt;">Av. Cra 9 No. 131 A - 02 • Edificio Fundadores • Línea Gratuita 018000 113033 • PBX (571) 6489000 • Bogotá D.C. - Colombia.
							</span>
						</div>
					</div>
				</td>
			</tr>-->
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
		<div id="mensageRegistroGrado" align="center"><br /><br />¿Desea ingresar el registro de grado?</div>
		<div id="mensageEliminarRegistroGrado" align="center"><br /><br />¿Desea eliminar el registro de grado?</div>
		<div id="mensageActualizarDiploma" align="center"><br /><br />¿Desea actualizar el número del diploma?</div>
		<div id="log"></div>
		<div id="dialogNota" align="left"></div>
		<!--
		*modified Diego RIvera <riveradiego@unbosque.edu.co>
		*Se añaden div  reporteEntidades y actualizarIncentivo  cargan formulario para impresion de carta y formulario para acualizar incentivo por parte la facultad 
		*Since March 01 . 2018
		-->
		<div id="reporteEntidades"></div>	
		<div id="actualizarIncentivo"></div>
		<div id="mensageAnularIncentivo" style="display: none;">Desea eliminar el incentivo seleccionado?</div>
	</body>
</html>
