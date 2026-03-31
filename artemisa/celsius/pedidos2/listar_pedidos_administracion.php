<?php
/**
 * 
 */

$pageName = "pedidos";

require_once "../common/includes.php";
SessionHandler::validar_nivel_acceso(ROL__ADMINISTADOR);
require "../layouts/top_layout_admin.php";
$usuario = SessionHandler::getUsuario();
$id_usuario = $usuario["Id"];


global $IdiomaSitio;
$Mensajes = Comienzo($pageName, $IdiomaSitio);

//debo buscar los pedidos en base a los datos recibidos como parametro
$conditions = array();

if (empty($Estado))
	$Estado = ESTADO__PENDIENTE;
else
	$Estado= (int)$Estado;
	
if (!empty($Operador_Corriente))
	$conditions["Operador_Corriente"] = $Operador_Corriente;
elseif (!isset($Operador_Corriente) && ($Estado != ESTADO__PENDIENTE)&& ($Estado != ESTADO__LISTO_PARA_BAJARSE)&& ($Estado != ESTADO__RECIBIDO)){
	$conditions["Operador_Corriente"] = $id_usuario;
	$Operador_Corriente = $id_usuario;
}else //$Operador_Corriente esta seteado a 0
	$Operador_Corriente = 0;
	
if (!empty($Codigo_Usuario))
	$conditions["Codigo_Usuario"] = $Codigo_Usuario;
else
	$Codigo_Usuario = 0;

if (empty($Lista))
	$Lista = 2;

if ($Estado == ESTADO__CANCELADO || $Estado == ESTADO__DESCAGADO_POR_EL_USUARIO || $Estado == ESTADO__ENTREGADO_IMPRESO)
	$tablaPedidos = "pedhist";
else
	$tablaPedidos = "pedidos";

$pedidosCompletos = $servicesFacade->getPedidosEnEstados($Estado,$conditions,$tablaPedidos);
if (is_a($pedidosCompletos, "Celsius_Exception")){
	$mensaje_error = "Error al tratar de listar los pedidos de la tabla $tablaPedidos en estados (".var_export($Estado,true).") que coincidan con el criterio: ". var_export($conditions, true);
	$excepcion = $pedidosCompletos;
	require "../common/mostrar_error.php";
}
?>
<form action="listar_pedidos_administracion.php" name="formAdministracion" method="get">

<table width="95%" border="0" align="center" cellpadding="1" cellspacing="1" class="table-form">
	<tr>
		<td class="table-form-top-blue" colspan="3">
			<img src="../images/square-w.gif" width="8" height="8">
			<?= $Mensajes["titulo.formBusquedaPedidos"];?>
		</td>
	</tr>
	<tr>
		<th width="120"><? echo $Mensajes["tf-2"]; ?></th>
		<td width="160">
		<? $estados = PedidosUtils::getEstados($VectorIdioma); ?>
			<select name="Estado" size="1" onchange="document.forms.formAdministracion.submit();" style="width:200px"  class="style22">
				<? foreach ($estados as $id_estado => $tradEstado){?>
    				<option value='<?=$id_estado?>' <? if ($Estado == $id_estado) echo "selected"?>>
    					<?=$tradEstado?>
    				</option>	
    			<? }?>
	   		</select>
		</td>
		<td rowspan="2" valign="middle">
			<input type="radio" name="Lista" value="1" <? if ($Lista==1) echo " checked"; ?>>
			<?=$Mensajes["tf-3"] ?>
			<br/>
			<input type="radio" name="Lista" value="2" <? if ($Lista==2) echo " checked"; ?>>
			<?=$Mensajes["tf-4"]; ?>
		</td>
	</tr>
	<tr>
		<th width="120"><?= $Mensajes["campo.usuario"];?></th>
		<td>
			<select name="Codigo_Usuario" size="1" style="width:200px">
		  		<?
		  		$usuariosPedidos = array();
		  		$usuariosCant = array();
		  		foreach ($pedidosCompletos as $pedidoCompleto){
		  			if(empty($pedidoCompleto["origen_remoto"])){
		  				$numUsuario= "0".$pedidoCompleto["Codigo_Usuario"];
		  				$usuariosPedidos[$numUsuario]= $pedidoCompleto["Apellido_Usuario"].", ".$pedidoCompleto["Nombre_Usuario"];}
		  			else{
		  				$numUsuario= "0".$pedidoCompleto["id_instancia_origen"];
		  				$usuariosPedidos[$numUsuario]= $pedidoCompleto["id_instancia_origen"];} 
		  			
		  			if (empty($usuariosCant[$numUsuario]))
		  				$usuariosCant[$numUsuario] = 1;
		  			else
		  				$usuariosCant[$numUsuario]++;		  			
		  		}
		  		
				$array_lowercase = array_map('strtolower', $usuariosPedidos);
				array_multisort($array_lowercase, SORT_ASC, SORT_STRING, $usuariosPedidos);
		  		//array_multisort($usuariosPedidos); ordenamiento case-sensitive
		  		foreach ($usuariosPedidos as $idUsuario => $nomUsuario){?>
		  			
		  			<option value="<?= $idUsuario ?>" <? if ($Codigo_Usuario==$idUsuario) echo "selected "; ?>>
		  				<?= $nomUsuario ?> [<?= $usuariosCant[$idUsuario] ?>]
		  			</option>
		  		<?}	?>
		  		<option value="0" <? if ($Codigo_Usuario==0) echo "selected";?>><?=$Mensajes["opcion.todos"];?></option>
		  	</select>
		</td>
	</tr>
	<tr>
		<th width="120"><?= $Mensajes["campo.operadorCorriente"];?></th>
		<td>
			<select name="Operador_Corriente" size="1" style="width:200px" >
		  		<?
		  		$operadores = $servicesFacade->getUsuarios(array("Staff" => 1));
		  		foreach ($operadores as $oper){?>
		  			<option value="<?= $oper["Id"] ?>" <? if ($Operador_Corriente==$oper["Id"]) echo "selected "; ?>>
		  				<?= $oper["Apellido"].", ".$oper["Nombres"] ?>
		  			</option>
		  		<?}
		  		?>
		  		<option value="0" <? if ($Operador_Corriente==0) echo "selected "; ?>><?=$Mensajes["opcion.todos"];?></option>
		  	</select>
		</td>
		<td width="160">
			<input type="submit" value="<? echo $Mensajes["bot-1"]; ?>">
		</td>
	</tr>
</table>

</form>

<hr>
<table width="95%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#0099CC" class="style22">
	<tr>
		<td height="20">
			<img src="../images/square-w.gif" width="8" height="8">
			<?= TraduccionesUtils::Traducir_Estado ($VectorIdioma,$Estado); ?>
			<b style="color:white"><?= count($pedidosCompletos); ?></b>
		</td>
	</tr>
</table>

<? require "listar_pedidos.php";

require "../layouts/base_layout_admin.php"
?>