<?
/**
 * @param string $id_pedido
 * @param string $id_catalogo
 * @param string $resultado_busqueda?
 */
$pageName = "busquedas_catalogo1";
require_once "../common/includes.php";
SessionHandler::validar_nivel_acceso(ROL__ADMINISTADOR);
require "../layouts/top_layout_popup.php";

global $IdiomaSitio;
$Mensajes = Comienzo($pageName,$IdiomaSitio);
	
$usuario = SessionHandler::getUsuario();


if (isset($resultado_busqueda)){
	//debe guardar lo ingresado
	
	if (empty ($Comentarios))
		$Comentarios = "";
	
	$busqueda = array("Id_Catalogo" => $id_catalogo,"Fecha" => date("Y-m-d"),"Id_Pedido" => $id_pedido,  "Resultado" => $resultado_busqueda ,"Comentarios" => $Comentarios,  "Id_Usuario" =>$usuario["Id"]);
	
	$result = $servicesFacade->guardarBusqueda($busqueda);
	if (is_a ($result, "Celsius_Exception")){
		$mensaje_error = $Mensajes["error.guardandoBusqueda"];
		$excepcion = $result;
		require "../common/mostrar_error.php";
	}
	?>
	<script language="JavaScript" type="text/javascript">
		window.opener.location.reload();
		self.close();
	</script>
	<?
}else{
	
	
	$busqueda = $servicesFacade->getBusqueda($id_pedido, $id_catalogo);
	
	if ($busqueda === FALSE){
		$busqueda = array("Fecha" => date("Y-m-d"), "Comentarios" => "", "Resultado" => 0);
		$nomUsuario = $usuario["Apellido"].", ".$usuario["Nombres"];
	}else
		$nomUsuario = $busqueda["Apellido_Usuario"] . ", " . $busqueda["Nombre_Usuario"];
	
	?>
	
	<form action="registrar_busqueda.php" method="post">
		<input type="hidden" name="id_pedido" value="<?= $id_pedido; ?>" />
		<input type="hidden" name="id_catalogo" value="<?= $id_catalogo; ?>" />
		
			  
	<table width="500" border="0" align="center" cellpadding="0" cellspacing="0" class="table-form">
		<tr>
			<td class="table-form-top" colspan="2">
	        	<?= $Mensajes["tf-1"]; ?>
	        	<span style="color: #66FFFF"><?= $id_pedido; ?></span>
	        	<? //$nombre_catalogo	????? ?>
	    </tr>
	    <tr>
			<th><?= $Mensajes["tf-2"] ?></th>
			<td><?= $busqueda["Fecha"] ?></td>
	    </tr>
	    <tr>
			<th><?= $Mensajes["tf-3"] ?></th>
			<td>
				<input type="radio" name="resultado_busqueda" value="0" <? if ($busqueda["Resultado"] == 0) echo "checked"; ?>>
				<?= $Mensajes["res-4"];?><!-- No Buscado --><br/>
				<input type="radio" name="resultado_busqueda" value="1" <? if ($busqueda["Resultado"] == 1) echo "checked"; ?>>
				<?= $Mensajes["res-1"];?><!-- Documento Hallado --><br/>
				<input type="radio" name="resultado_busqueda" value="2" <? if ($busqueda["Resultado"] == 2) echo "checked"; ?>>
				<?= $Mensajes["res-2"];?><!-- Título Hallado --><br/>
				<input type="radio" name="resultado_busqueda" value="3" <? if ($busqueda["Resultado"] == 3) echo "checked"; ?>>
				<?= $Mensajes["res-3"];?><!-- Título no hallado --><br/>
			</td>
	    </tr>
	    <tr>
			<th><?= $Mensajes["tf-4"]; ?></th>
			<td><?= $nomUsuario; ?></td>
	    </tr>
	    <tr>
			<th><?= $Mensajes["tf-5"]; ?></th>
			<td><textarea rows="4" name="Comentarios" cols="38"><?= $busqueda["Comentarios"]; ?></textarea></td>
	    </tr>
	    <tr>
			<th>&nbsp;</th>
			<td colspan="2">
				<input type="submit" value="<? echo $Mensajes["bot-1"]; ?>" name="B1" />
				<input type="button" value="<? echo $Mensajes["bot-2"]; ?>" name="B2"  OnClick="self.close()" />
			</td>
	    </tr>
	     
	</table>

	</form>

<?
}
require "../layouts/base_layout_popup.php";
?>