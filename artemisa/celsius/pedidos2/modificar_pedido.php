<?
/**
 * Para modificacion:
 * @param int id_pedido El id del pedido q se desea modificar
 * 
 * Para la creacion:
 * @param int id_usuario El id del usuario q solicita el pedido o null. si es null se considera q el pedido espara el usuario actual
 * @param int $tipo_material El tipo de pedido q se esta creando
 */
$pageName = "eventos";
require_once "../common/includes.php";
SessionHandler::validar_nivel_acceso(ROL__USUARIO);
require_once "../common/PedidosUtils.php";
require_once "../utils/StringUtils.php";
$creador = SessionHandler::getUsuario();

//no muestro lso notices porq sino en la creacion de pedidos se muestran errores por todos lados 
error_reporting(E_ALL ^ E_NOTICE);

//chequea inicializa parametros
$creacion = empty($id_pedido);
$soloLectura = false;
if ($creacion){
	//es una creacion de pedido
	require "../layouts/top_layout_admin.php";
	$id_pedido = "";
	if (empty($tipo_material))
		$tipo_material = TIPO_MATERIAL__REVISTA;
	
	if (empty($id_usuario) || SessionHandler::getRolUsuario() == ROL__USUARIO){
		$id_usuario = $creador["Id"];
		$cliente = $creador;
	}else
		$cliente = $servicesFacade->getUsuario($id_usuario);
		
	$pedidoCompleto = array();
	$pedidoCompleto ["Apellido_Usuario"] = $cliente["Apellido"];
	$pedidoCompleto ["Nombre_Usuario"] = $cliente["Nombres"];
	$pedidoCompleto ["Codigo_Usuario"] = $id_usuario;
	$pedidoCompleto ["Tipo_Pedido"] = $servicesFacade->tipo_pedido_x_defecto($id_usuario);
    //var_dump($pedidoCompleto ["Tipo_Pedido"]);
}else{
	//es una modificacion de un pedido
	require "../layouts/top_layout_popup.php";
	
	$tablaPedido = "pedidos";
	$tablaEventos = "eventos";
	$pedidoCompleto = $servicesFacade->getPedidoCompleto($id_pedido, $tablaPedido);
	if (empty($pedidoCompleto)){
		$tablaPedido = "pedhist";
		$tablaEventos = "evhist";
		$pedidoCompleto = $servicesFacade->getPedidoCompleto($id_pedido, $tablaPedido);
		if (empty($pedidoCompleto)){
			$tablaPedido = "pedanula";
			$tablaEventos = "evanula";
			$pedidoCompleto = $servicesFacade->getPedidoCompleto($id_pedido, $tablaPedido);
		}
	}
	if (empty($pedidoCompleto)){
		echo $Mensajes["warning.pedidoNoExiste1"]." ".$id_pedido." ".$Mensajes["warning.pedidoNoExiste2"];
		exit;
	}
	
	$tipo_material = $pedidoCompleto["Tipo_Material"];
	$soloLectura = $tablaPedido != "pedidos";
}

//i18n
global $IdiomaSitio;
$Mensajes = Comienzo($pageName, $IdiomaSitio);

$CamposFijos = $servicesFacade->getCamposPedidos($IdiomaSitio, 0);
$Campos = $servicesFacade->getCamposPedidos($IdiomaSitio, $tipo_material);

?>
<script language="JavaScript" type="text/javascript">
	
	function ayuda (id_campo){
		var ventana=window.open("ayuda_pedidos.php?id_campo="+id_campo,"Ayuda","dependent=yes,toolbar=no,width=530,height=120");
		ventana.focus();
	}
	
	function validar_campos(){
		var valorCampo;
		<?
		$CamposAValidar = array_merge($CamposFijos,$Campos);
		
		foreach ($CamposAValidar as $campoName => $campoArray){
			if (($campoArray["obligatorio"] == 1) || ($campoArray["tipo_regexp"] != "string")){
				if ($campoName!="Tipo_Pedido"){?>
					valorCampo = document.forms.form1.elements['<? echo $campoName ?>'].value;
				<?}else{?>
					valorCampo = document.getElementById('Tipo_Pedido').value;
				<?}
				if ($campoArray["obligatorio"]){?>
					if (!valorCampo){		
						alert('<?=StringUtils::getSafeString($campoArray["mensaje_error"])?>');
						return false;
					}
				<?}
				if ($campoArray["tipo_regexp"] != "string"){
					if ($campoArray["tipo_regexp"] == "int")
						$regexp = "\d+";
					elseif ($campoArray["tipo_regexp"] == "bool")
						$regexp = "^(true|false)$";
					elseif ($campoArray["tipo_regexp"] == "date")
						$regexp = "\d{2}\/\d{2}\/\d{4}";
					else 
						$regexp = $campoArray["tipo_regexp"];
					?>
					if (valorCampo && (!valorCampo.match(/<?=$regexp?>/g))){
						alert('<?=$campoArray["mensaje_error"]?>');
						return false;
					}
				<?}
			}
		}?>
		document.getElementsByName('submitbtn').item(0).disabled= true;
		return true;
	}
	
</script>

<form name="form1" method="post" action="guardar_pedido.php" onsubmit="return validar_campos();">
	<input type="hidden" name="id_pedido" value="<? echo $id_pedido; ?>" />
	<input type="hidden" name="Codigo_Usuario" value="<? echo $id_usuario; ?>" />
	<input type="hidden" name="Tipo_Material" value="<? echo $tipo_material ?>" />
	    
<table width="95%"  border="0" align="center" cellpadding="0" cellspacing="0" class="table-form">
	<tr>
    	<td colspan="2" class="table-form-top">
			<? if ($pedidoCompleto ["Codigo_Usuario"] != 0) 
				echo $pedidoCompleto ["Apellido_Usuario"].", ".$pedidoCompleto["Nombre_Usuario"];
			else 
				echo $pedidoCompleto ["id_instancia_origen"];
			?>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<? echo $id_pedido; ?>
		</td>
		<td class="table-form-top">
			<a href='javascript:window.print()'>
				<img src="../images/printer.gif" width="32" border="0" height="33">
			</a>
		</td>
    </tr>
	<tr>
		<th><?= $CamposFijos["Tipo_Pedido"]["texto"] ?></th>
		<td>
			<select name="Tipo_Pedido" id="Tipo_Pedido" <? if (SessionHandler::getRolUsuario() < ROL__ADMINISTADOR){ echo "disabled";} ?>>
				<option value='<?=TIPO_PEDIDO__BUSQUEDA?>' <? if ($pedidoCompleto["Tipo_Pedido"]==TIPO_PEDIDO__BUSQUEDA) echo "selected"; ?>>
             		<?= TraduccionesUtils::Traducir_Tipo_Pedido($VectorIdioma,TIPO_PEDIDO__BUSQUEDA) ?>
             	</option>
				<option value='<?=TIPO_PEDIDO__PROVISION?>' <? if ($pedidoCompleto["Tipo_Pedido"]==TIPO_PEDIDO__PROVISION) echo "selected"; ?>>
					<?= TraduccionesUtils::Traducir_Tipo_Pedido($VectorIdioma,TIPO_PEDIDO__PROVISION) ?>
				</option>
			</select>
		</td>
		<td>
			<a href="javascript:ayuda(<?=$CamposFijos["Tipo_Pedido"]["id_campo"]?>)"><img src="../images/help.gif" width="22" height="22" border="0"></a>
		</td>
	</tr>

	<?
	switch ($tipo_material) {
		case TIPO_MATERIAL__REVISTA:
			require "modificar_pedido_articulo.php";
			break;
		case TIPO_MATERIAL__LIBRO:
			require "modificar_pedido_libro.php";
			break;
		case TIPO_MATERIAL__PATENTE:
			require "modificar_pedido_patente.php";
			break;
		case TIPO_MATERIAL__TESIS:
			require "modificar_pedido_tesis.php";
			break;
		case TIPO_MATERIAL__CONGRESO:
			require "modificar_pedido_congreso.php";
			break;
		default:
			echo ("El tipo de material # ".$tipo_material." es desconocido");
			break;
	}
	?>
	
	<tr>
		<th><?= $CamposFijos["isbn_issn"]["texto"] ?></th>
		<td><input type="text" name="isbn_issn" value="<? echo $pedidoCompleto["isbn_issn"]; ?>" size="60"/></td>
		<td><a href="javascript:ayuda(<?= $CamposFijos["isbn_issn"]["id_campo"] ?>)"><img src="../images/help.gif" border="0" width="22" height="22"></a></td>
	</tr>
	
	<tr>
		<th><?= $CamposFijos["Biblioteca"]["texto"] ?></th>
		<td><input type="text" name="Biblioteca" value="<? echo $pedidoCompleto["Biblioteca_Sugerida"]; ?>" size="60"/></td>
		<td><a href="javascript:ayuda(<?= $CamposFijos["Biblioteca"]["id_campo"] ?>)"><img src="../images/help.gif" border="0" width="22" height="22"></a></td>
	</tr>
	
	<tr>
		<th><?= $CamposFijos["Observaciones"]["texto"] ?></th>
		<td><textarea rows="4" name="Observaciones" cols="57"><? echo $pedidoCompleto["Observaciones"]; ?></textarea></td>
		<td><a href="javascript:ayuda(<?= $CamposFijos["Observaciones"]["id_campo"] ?>)"><img src="../images/help.gif" border="0" width="22" height="22"></a></td>
	</tr>
	<tr>
		<th>&nbsp;</th>
		<td >
			<? if (!$soloLectura){?>
				<input type="submit" name="submitbtn" value="<?= $Mensajes["boton.guardar"];?>"  />
			<?}
			if ($creacion){?>
				<input type="button" value="<?= $Mensajes["boton.cancelar"];?>" OnClick="javascript:history.back();" />
			<? }else{?>
				<input type="button" value="<?= $Mensajes["botc-2"]; ?>" OnClick="javascript:self.close();" />
			<?}?>
		</td>
		<td>&nbsp;</td>
	</tr>
	
</table>
	<!--<input type='hidden' id="Tipo_Pedido" name='Tipo_Pedido' value='<?=$pedidoCompleto["Tipo_Pedido"]?>' />-->
</form>

<?
if ($creacion)
	//es una creacion de pedido
	require "../layouts/base_layout_admin.php";
else
	//es ua modificacion
 	require "../layouts/base_layout_popup.php";
?>