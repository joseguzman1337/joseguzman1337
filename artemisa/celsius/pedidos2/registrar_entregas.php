<?
/**
 * @param int $id_usuario - usuario al que se le registran todas las entregas
 * @param int $codigo_evento - evento que se le genera a cada pedido del usuario listo para entregar/descargar
 * @param int $id_estado - estado de los pedidos que se quieren registrar (ESTADO__RECIBIDO | ESTADO__LISTO_PARA_BAJARSE)
 */
$pageName = "eventos2";
require_once "../common/includes.php";
SessionHandler::validar_nivel_acceso(ROL__ADMINISTADOR);
require "../layouts/top_layout_popup.php";

global $IdiomaSitio;
$Mensajes = Comienzo($pageName,$IdiomaSitio);
$usuario = SessionHandler::getUsuario();
$cant=0;

if ((!empty($id_usuario))&&(!empty($codigo_evento))){
	if(($codigo_evento==EVENTO__A_PDF_DESCARGADO)||($codigo_evento==EVENTO__A_ENTREGADO_IMPRESO)){	
		$conditions["Codigo_Usuario"] = $id_usuario;
		$pedidosCompletos = $servicesFacade->getPedidosEnEstados($id_estado,$conditions,"pedidos");
		$cant= count($pedidosCompletos);
		
		foreach ($pedidosCompletos as $pedido){
			//header("Location: guardar_evento.php?id_pedido=".$id_pedido."&codigo_evento=".$codigo_evento);
			$evento = array ();
			$evento["Id_Pedido"]= $pedido["Id"];
			$evento["Codigo_Evento"]= $codigo_evento;
			$evento["Codigo_Pais"] = (!empty ($Paises)) ? $Paises : 0;
			$evento["Codigo_Institucion"] = (!empty ($Instituciones)) ? $Instituciones : 0;
			$evento["Codigo_Dependencia"] = (!empty ($Dependencias)) ? $Dependencias : 0;
			$evento["Codigo_Unidad"] = (!empty ($Unidades)) ? $Unidades : 0;
			$evento["Id_Instancia_Celsius"] = (!empty ($id_instancia_celsius)) ? $id_instancia_celsius : "";
			$evento["Numero_Paginas"] = (!empty ($Numero_Paginas)) ? $Numero_Paginas : 0;
			$evento["Es_Privado"] = (int)(isset ($Es_Privado));
			
			if(!empty($id_evento_origen))
				$evento["id_evento_origen"] = (int)$id_evento_origen;
			
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
			
			if (is_a($Id_Evento, "Celsius_Exception")){
				$mensaje_error = "Se produjo un error al tratar de generar el evento de entrega ". var_export($evento, true);
				$excepcion = $Id_Evento;
				require "../common/mostrar_error.php";
		   	//die("<br>Se proujo el siguiente Error: ".$Id_Evento->getMessage()."<br>");
			
		}			
	}
	
}}
?>
	<script language="JavaScript" type="text/javascript">
		<?$Codigo_Usuario=0;
		$Estado= $id_estado;?>
		window.opener.location.reload();
	</script>
	<div align="center">
		<?=$cant." ".$Mensajes["mensaje.pedidosPasadosA"]." ";?> '<?=TraduccionesUtils::Traducir_Evento($VectorIdioma,$codigo_evento);?>'
		<script language="JavaScript" type="text/javascript">
			setTimeout('self.close()',3000);
		</script>
		<input type="button" onclick="self.close()" value="<?=$Mensajes["boton.cerrar"];?>"/>
	</div>
<?require "../layouts/base_layout_popup.php";?>