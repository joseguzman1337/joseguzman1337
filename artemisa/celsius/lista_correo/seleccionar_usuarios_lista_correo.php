<?

$pageName="listaCorreo";

require_once "../common/includes.php";
SessionHandler :: validar_nivel_acceso(ROL__ADMINISTADOR);
require "../layouts/top_layout_admin.php";

global $IdiomaSitio;
$Mensajes = Comienzo($pageName, $IdiomaSitio);


if (empty($numero_pedidos))
	$numero_pedidos=1;
if (empty($cant_dias))
	$cant_dias=5;
?>
<script language="JavaScript" type="text/javascript">
  	function enviar_mails(){
		var lista_usuarios = document.forms.form1.ListaUsuarios;
		if (lista_usuarios.length == 0){
			alert("<? echo $Mensajes["me-1"]?>");
			return false;
		}
			
		for (i=0; i<lista_usuarios.length; i++){
			lista_usuarios.options[i].selected = true;
		}
		lista_usuarios.name="ListaUsuarios[]";
		document.forms.form1.action = "seleccionar_plantilla_lista_correo.php";

	}
	
	function quitar_usuario(){
		var lista_usuarios = document.forms.form1.ListaUsuarios;
		for (i=0; i<lista_usuarios.length; i++)
			if (lista_usuarios.options[i].selected){
				lista_usuarios.options[i] = null;
		}
	}
	
</script>

<form name="form1">
<table width="90%" border="0" cellpadding="0" cellspacing="1" align="center" class="table-form">
	<tr>
    	<td class="table-form-top-blue" colspan="2">
			<img src="../images/square-w.gif" width="8" height="8"> 
			<? echo $Mensajes["tf-5"]; ?>
		</td>
	</tr>
	<tr>
		<th width="40%"><? echo $Mensajes["tf-2"]; ?></th>
		<td>
			<select name="numero_pedidos" id="numero_pedidos" style="width:100%">
				<option value="1" <? if ($numero_pedidos==1) echo "selected" ?>>&lt;=1</option>
				<option value="2" <? if ($numero_pedidos==2) echo "selected" ?>>&lt;=2</option>
				<option value="3" <? if ($numero_pedidos==3) echo "selected" ?>>&lt;=3</option>
				<option value="4" <? if ($numero_pedidos==4) echo "selected" ?>>&lt;=4</option>
				<option value="5" <? if ($numero_pedidos==5) echo "selected" ?>>&gt;4</option>
			</select>
		</td>
	</tr>
	<tr>
		<th><? echo $Mensajes["tf-3"]; ?></th>
		<td><input type="text" name="cant_dias" size="5" value="<? echo $cant_dias; ?>" /></td>
	</tr>
	<tr>
    	<th>&nbsp;</th>
    	<td><input type="submit" name="submit" value="<? echo $Mensajes["bot-1"]?>" /></td>
    </tr>

<? if (!empty ($submit)) {
	$colgados = $servicesFacade->getUsuarios_CantidadPedidos(ESTADO__RECIBIDO);
	?>
	
		<tr>
			<th><? echo $Mensajes["tf-8"]; ?></th>
			<td>
				
					<select name="ListaUsuarios" size="15" multiple>
						<?
						
						$usuarios_sin_mail = 0;
						$usuarios_con_mail = 0;
						foreach($colgados as $colgado){
							
							$dias_transcurridos = calcular_dias($colgado["min_recepcion"]);
							if ($colgado["cantPedidos"] >= $numero_pedidos && $dias_transcurridos >= $cant_dias) {
								
								$Leyenda = $colgado["Apellido"] . "," . $colgado["Nombres"] . " [" . $colgado["cantPedidos"] . "] - " . $colgado["min_recepcion"];
								
								if (empty($colgado["EMail"])) {
									$Leyenda .= " --NM";
									$usuarios_sin_mail++;
								}else{
										$usuarios_con_mail++;
								}
								?>
								<option value="<? echo $colgado["Id"]; ?>"><? echo $Leyenda; ?></option>
								<? 
							}
						}?>	
					</select>
				
			</td>
		</tr>
		<tr>
			<th><? echo $Mensajes["tf-4"]; ?></th>
			<td><? echo ($usuarios_sin_mail + $usuarios_con_mail); ?></td>
		</tr>
		<tr>
			<th><? echo $Mensajes["tf-6"]; ?></th>
			<td><? echo $usuarios_sin_mail; ?></td>
		</tr>
		<tr>
			<th><? echo $Mensajes["tf-7"]; ?></th>
			<td><? echo $usuarios_con_mail; ?></td>
		</tr>
		<tr>
			<th>&nbsp;</th>
			<td>
				<input type="button" value="<? echo $Mensajes["bot-3"]?>" onclick="quitar_usuario();" />
				<input type="submit" value="<? echo $Mensajes["bot-2"]?>" onclick="enviar_mails();" />
			</td>
		</tr>

<?}?>
</table>
</form>
<?
$pageName = "listaCorreo";
require "../layouts/base_layout_admin.php";
?>