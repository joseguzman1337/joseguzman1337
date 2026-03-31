<?php
/**
 * @param array(Codigo_Usuario, rol, Codigo_Pais, Codigo_Institucion, Codigo_Dependencia, Codigo_Unidad) conditions
 * 
 *Lista los pedidos por usuario.
 *
 *En caso de rol administrador el mismo elige un PIDU, y se muestran los pedidos historicos entregados de todos los usuarios de ese PIDU.
 *En caso de rol usuario, se le muestran al mismo todos sus pedidos historicos entregados.
 *En caso de rol bibliotecario, se le muestran al mismo todos los pedidos historicos entregados de todos los usuarios de la institucion
 *a la cual pertenece el bibliotecario.
 *
 */
$pageName = "pedidos";
require_once "../common/includes.php";
SessionHandler :: validar_nivel_acceso(ROL__USUARIO);
require "../layouts/top_layout_admin.php";
global $IdiomaSitio;
$Mensajes = Comienzo($pageName, $IdiomaSitio);
$usuario = SessionHandler :: getUsuario();
$id_usuario = $usuario["Id"];
$rol_usuario = SessionHandler :: getRolUsuario();

$conditions = array ();

if ($rol_usuario == ROL__ADMINISTADOR) {

	$mostrar_elemento = array (
		"paises",
		"instituciones",
		"dependencias",
		"unidades"
	);
	require "../utils/pidui.php";

	if (empty ($Codigo_Pais))
		$Codigo_Pais = 0;
	else
		$conditions["Codigo_Pais"] = $Codigo_Pais;

	if (empty ($Codigo_Institucion))
		$Codigo_Institucion = 0;
	else
		$conditions["Codigo_Institucion"] = $Codigo_Institucion;

	if (empty ($Codigo_Dependencia))
		$Codigo_Dependencia = 0;
	else
		$conditions["Codigo_Dependencia"] = $Codigo_Dependencia;

	if (empty ($Codigo_Unidad))
		$Codigo_Unidad = 0;
	else
		$conditions["Codigo_Unidad"] = $Codigo_Unidad;
	?>
	
	<form method="get" onsubmit="return validar_formulario();">
    
	<table width="75%" cellspacing="1" cellpadding="1" class="table-form" align="center">
		<tr>
			<td colspan="2" class="table-form-top-blue">
				<img src="../images/square-w.gif" width="8" height="8"/>
				<?=$Mensajes["mensaje.listadoPedidosEntregadosPorUsuario"]; ?>
			</td>
    	</tr>
    	<tr>
	    	<th><?=$Mensajes["campo.pais"]; ?></th>
	        <td><select size="1" name="Codigo_Pais" OnChange="generar_instituciones(0);" style="width:350px"/></td>
	    </tr>
	    <tr>
    	 	<th><?=$Mensajes["campo.institucion"]; ?></th>
     		<td><select size="1" name="Codigo_Institucion" OnChange="generar_dependencias(0);" style="width:350px" /></td>
		</tr>
		<tr>
			<th><?=$Mensajes["campo.dependencia"]; ?></th>
     		<td><select size="1" name="Codigo_Dependencia" OnChange="generar_unidades(0);" style="width:350px" /></td>
		</tr>
		<tr>
			<th><?=$Mensajes["campo.unidad"]; ?></th>
     		<td><select size="1" name="Codigo_Unidad" style="width:350px" /></td>
		</tr>
    	<tr>
    		<th>&nbsp;</th>
			<td colspan="2">
				<input type="submit" value="<? echo $Mensajes["bot-1"]; ?>">
			</td>
		</tr>
	</table>
	</form>
	
	<script language="JavaScript" type="text/javascript">
		listNames[0] = new Array();
		listNames[0]["paises"]="Codigo_Pais";
		listNames[0]["instituciones"]="Codigo_Institucion";
    	listNames[0]["dependencias"]="Codigo_Dependencia";
    	listNames[0]["unidades"]="Codigo_Unidad";
		generar_paises(<?=$Codigo_Pais?>);
		generar_instituciones(<?=$Codigo_Institucion?>); 
		generar_dependencias(<?=$Codigo_Dependencia?>);
		generar_unidades(<?=$Codigo_Unidad?>);
		
		function validar_formulario(){
			codPais= document.getElementsByName("Codigo_Pais").item(0).value;
			codInstitucion= document.getElementsByName("Codigo_Institucion").item(0).value;
			//codDependencia= document.getElementsByName("Codigo_Dependencia").item(0).value;
			//codUnidad= document.getElementsByName("Codigo_Unidad").item(0).value;
				if((codPais==0)||(codInstitucion==0)){
				alert('<?= $Mensajes["warning.faltaPI"];?>');
				return false;
			}
			return true;
		}
	
	</script>
	<? 
}elseif ($rol_usuario == ROL__BIBLIOTECARIO) {
	if (!empty ($usuario["Codigo_Pais"]))
		$conditions["Codigo_Pais"] = $usuario["Codigo_Pais"];
	if (!empty ($usuario["Codigo_Institucion"]))
		$conditions["Codigo_Institucion"] = $usuario["Codigo_Institucion"];
	if (!empty ($usuario["Codigo_Dependencia"]))
		$conditions["Codigo_Dependencia"] = $usuario["Codigo_Dependencia"];
	if (!empty ($usuario["Codigo_Unidad"]))
		$conditions["Codigo_Unidad"] = $usuario["Codigo_Unidad"];
}

if((!empty($conditions))||($rol_usuario==ROL__USUARIO)){
	$pedidosCompletos = $servicesFacade->getPedidosEntregadosDeUsuarios($conditions, 0, $rol_usuario, $id_usuario);
	if (is_a($pedidosCompletos, "Celsius_Exception")) {
		$mensaje_error = $Mensajes["error.listado_entregas_x_usuario"];
		$excepcion = $pedidosCompletos;
		require "../common/mostrar_error.php";
	}
		
	echo "<hr>";
	$Lista = 3;
	require "listar_pedidos.php";
}
	require "../layouts/base_layout_admin.php"?>