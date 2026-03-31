<?

/**
 * $estado? 
 * $tablaPedidos default pedidos
 * $id_usuario? solo para los bibliotecarios
 */
$pageName = "pedidos";

require_once "../common/includes.php";
SessionHandler :: validar_nivel_acceso(ROL__USUARIO);

global $IdiomaSitio;
$Mensajes = Comienzo($pageName, $IdiomaSitio);

require "../layouts/top_layout_admin.php";

$rol_usuario = SessionHandler :: getRolUsuario();
$usuario = SessionHandler :: getUsuario();
$id_usuario = $usuario["Id"];
if (empty ($estado))
	$estado = array ();
else
	$estado = (array) $estado;
if (empty ($tablaPedidos) || $tablaPedidos != "pedhist") 
	$tablaPedidos = "pedidos";
	
$pedidosCompletos = $servicesFacade->getPedidosEnEstados($estado, array (), $tablaPedidos, $rol_usuario, $id_usuario);

?>
<table width="95%" border="0" align="center" class="table-form">
	<tr>
		<td class="table-form-top-blue" colspan="3">
			<img src="../images/square-w.gif" width="8" height="8" />
			<?= $Mensajes["titulo.cantidadPedidos"];?>
			<b style="color:white"><?= count($pedidosCompletos); ?></b>
		</td>
	</tr>
</table>

<br/>
<?
require "listar_pedidos.php";

require "../layouts/base_layout_admin.php"
?>