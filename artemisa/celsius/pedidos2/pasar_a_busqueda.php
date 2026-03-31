<?php
/*
 * Created on 22-ago-2007
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

$pageName = "eventos1";
require_once "../common/includes.php";
SessionHandler::validar_nivel_acceso(ROL__USUARIO);

$usuario = SessionHandler::getUsuario();
$id_usuario = $usuario["Id"];

$colsToUpdate=array("En_Busqueda"=>"1");
$pasarBusqueda=$servicesFacade->pasarPedidoABusqueda($id_pedido,$colsToUpdate);

$pedido = $servicesFacade->getPedido($id_pedido);

require "../layouts/top_layout_popup.php";
global $IdiomaSitio;
$Mensajes = Comienzo($pageName, $IdiomaSitio);
?>

<form  method="post" action="" >

<table width="100%"  border="0" align="center" cellpadding="2" cellspacing="1" class="table-form">
	<tr>
    	<td colspan="2" class="table-form-top">
			<? echo $Mensajes["ec-1"]; ?>: &nbsp;<? echo $id_pedido; ?>
		</td>
    </tr>
	<div align="center">
		<script language="JavaScript" type="text/javascript">
			setTimeout('self.close()',3000)
		</script>
		<input type="button" onclick="self.close()" value="<?=$Mensajes["boton.cerrar"];?>"/>
	</div>			
	
</table>
</form>


<?
require "../layouts/base_layout_popup.php" 
?>