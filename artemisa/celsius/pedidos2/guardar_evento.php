<?php
/**
 *
 */
$pageName="eventos2";
require_once "../common/includes.php";
SessionHandler::validar_nivel_acceso(ROL__USUARIO);
$usuario = SessionHandler::getUsuario();
$rol=SessionHandler::getRolUsuario();
require "../layouts/top_layout_popup.php";

global $IdiomaSitio;
$Mensajes = Comienzo($pageName, $IdiomaSitio);

if (empty ($id_pedido)){
	die("Falta el parametro id_pedido");
}
if (empty ($codigo_evento)){
	die("Falta el parametro codigo_evento");
}

?>

<table width="95%"  border="0" align="center" cellpadding="0" cellspacing="0" class="table-form">
	<tr>
		<td colspan="2" class="table-form-top">
			<? echo $Mensajes["tf-1"]; ?>&nbsp;<?echo $id_pedido; ?>
		</td>
	</tr>
	<tr>
		<td>
<? 
// Informacion del evento

$evento = array ();
$evento["Id_Pedido"] = $id_pedido;
$evento["Codigo_Evento"] = $codigo_evento;
$evento["Codigo_Pais"] = (!empty ($Paises)) ? $Paises : 0;
$evento["Codigo_Institucion"] = (!empty ($Instituciones)) ? $Instituciones : 0;
$evento["Codigo_Dependencia"] = (!empty ($Dependencias)) ? $Dependencias : 0;
$evento["Codigo_Unidad"] = (!empty ($Unidades)) ? $Unidades : 0;
$evento["Id_Instancia_Celsius"] = (!empty ($id_instancia_celsius)) ? $id_instancia_celsius : "";
$evento["Numero_Paginas"] = (!empty ($Numero_Paginas)) ? $Numero_Paginas : 0;
$evento["Es_Privado"] = (int)(isset ($Es_Privado));

if(!empty($id_evento_origen))
	$evento["id_evento_origen"] = (int)$id_evento_origen;
else
	$id_evento_origen = 0;

if (empty($Observaciones))
	$Observaciones = "";
$evento["Observaciones"] = $Observaciones;
if (empty($Operador))
	$Operador = $usuario["Id"];

$evento["Operador"] = $Operador;

if (!empty($Fecha_Recepcion) && ereg("([0-9]{4})-([0-9]{1,2})-([0-9]{1,2})", $Fecha_Recepcion) !== FALSE) 
	$evento["Fecha"] = $Fecha_Recepcion;
else
	$evento["Fecha"] = date("Y-m-d H:i:s");

$archivos = $_FILES;

//crea el evento
if(empty($manual))
	$manual=false;

$Id_Evento = $servicesFacade->generarEvento_OrigenLocal($evento, $archivos, $manual);

//var_dump($Id_Evento);
if (is_a($Id_Evento, "WS_Exception")){
	if ($codigo_evento != EVENTO__A_SOLICITADO){
		$mensaje_error = "NO SE PUEDE REALIZAR EL EVENTO REMOTO EN ESTE MOMENTO, INTENTELO MAS TARDE";
		$excepcion = $resModificacion;
		require "../common/mostrar_error.php";
	}else{ // poner la pantalla de darle la opcion de si hacerlo manual o no 
		?>
		<script language="JavaScript" type="text/javascript">
			function procesarEventoRemoto(){
				var opcion = "";
				if (document.getElementsByName("opcion").item(0).checked)
					opcion = document.getElementsByName("opcion").item(0).value;
				else if (document.getElementsByName("opcion").item(1).checked)
					opcion = document.getElementsByName("opcion").item(1).value;
				else if (document.getElementsByName("opcion").item(2).checked)
					opcion = document.getElementsByName("opcion").item(2).value;
				
				if (opcion == "manual"){
					document.getElementsByName("manual").item(0).value="true";
					document.getElementById("formEvento").submit();
				}else if (opcion == "reintentar"){
					document.getElementsByName("manual").item(0).value="";
					document.getElementById("formEvento").submit();
				}else if (opcion == "cancelar"){
					window.close();
				}
			}
		</script>
        <form method="post" id="formEvento" action="guardar_evento.php">
			<input type="hidden" name="Paises" value="<?=$Paises?>">
			<input type="hidden" name="Instituciones" value="<?=$Instituciones?>">
			<input type="hidden" name="Dependencias" value="<?=$Dependencias?>">
			<input type="hidden" name="Unidades" value="<?=$Unidades?>">
			<input type="hidden" name="id_instancia_celsius" value="<?=$id_instancia_celsius?>">
			<input type="hidden" name="Es_Privado" value="<?if(isset($Es_Privado)) echo 'ON'?>"/>
			<input type="hidden" name="Env_Mail" value="<?if(isset($Env_Mail)) echo 'ON'?>"/>
			<input type="hidden" name="Observaciones" value="<?=$Observaciones?>"/>
			<input type="hidden" name="id_pedido" value="<?= $id_pedido?>"/>
			<input type="hidden" name="codigo_evento" value="<?= $codigo_evento?>"/>
			<input type="hidden" name="id_evento_origen" value="<?=$id_evento_origen?>"/>
			<input type="hidden" name="manual" value=""/>
		</form>
		<table width="95%" border="0" align="center" cellpadding="2" cellspacing="0">
			<tr height="20" bgcolor="#006699" class="style18">
				<td><? echo $Id_Evento->getMessage(); ?> </td>
				<td>&nbsp;</td>
	         </tr>
	         <tr>
	         	<td><?=$Mensajes["opcion.realizarPedidoManual"];?></td>
	         	<td><input type="radio" name="opcion" value="manual"/></td>
	         </tr>
	         <tr>
	         	<td><?=$Mensajes["opcion.reintentar"];?></td>
	         	<td><input type="radio" name="opcion" value="reintentar"/></td>
	         </tr>
	         <tr>
	         	<td><?=$Mensajes["opcion.realizarMasTarde"];?></td>
	         	<td><input type="radio" name="opcion" value="cancelar"/></td>
	         </tr>
	         <tr>
	         	<td colspan="2">
	            	<input type="button" value="<?=$Mensajes["boton.procesar"];?>" name="B3" onclick="procesarEventoRemoto();" >
				</td>  
	        </tr>
		</table>

		<?
	}
}elseif (is_a($Id_Evento, "Celsius_Exception")){
	$mensaje_error = "Error al tratar de generar el evento del pedido $id_pedido. Datos del Evento: ". var_export($evento, true);
	$excepcion = $Id_Evento;
	require "../common/mostrar_error.php";

}else{//ta todo bien?>
	<script language="JavaScript" type="text/javascript">
		window.opener.location.reload();
	</script>
	<?
	
	$tablaEventoNueva = PedidosUtils::getTablaEventosParaEventos($codigo_evento);
	$evento_creado = $servicesFacade->getEvento($Id_Evento,$tablaEventoNueva);
	if (!empty ($Env_Mail) && ($Env_Mail == "ON")){
		$tablaPedNueva = PedidosUtils::getTablaPedidosParaEstado(PedidosUtils::Determinar_Estado($codigo_evento));
		$pedidoCompleto = $servicesFacade->getPedidoCompleto($id_pedido,$tablaPedNueva);
		
	    //seteo todos los parametros necesarios para enviar el mail
	 //   var_dump($evento_creado["Codigo_Evento"]);
	    $id_plantilla = $servicesFacade->getPlantilla(array("Cuando_Usa" => $evento_creado["Codigo_Evento"]), "Id");
	    
	    $id_plantilla = $id_plantilla ["Id"];
	  // var_dump($id_plantilla);   
	    $id_creador = $pedidoCompleto["Usuario_Creador"];
	    $id_usuario = $pedidoCompleto["Codigo_Usuario"];
	    $embebido = true;
	    
	    require_once "funciones_mostrar_pedido.php";
	    $cita_pedido = Devolver_Descriptivo_Material_Email($pedidoCompleto);
	    
	    //$Id_Evento ya esta seteado
	    //$url_destino ya esta seteada
	    require "../mail/enviar_mail2.php"; 
	}else{?>
		<div align="center">
			<?=$Mensajes["mensaje.pedidoPasadoA"]." ";?> '<?=TraduccionesUtils::Traducir_Evento($VectorIdioma,$codigo_evento);?>'
			<script language="JavaScript" type="text/javascript">
				setTimeout('self.close()',3000)
		  	</script>
			<input type="button" onclick="self.close()" value="<?=$Mensajes["boton.cerrar"];?>"/>
		</div>
  		<?
	}
}
?>
		</td>
	</tr>
</table>

<? require "../layouts/base_layout_popup.php"; ?>