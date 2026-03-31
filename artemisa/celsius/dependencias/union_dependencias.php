<?
/**
 * $IdDependenciaAEliminar
 * $IdDependencia
 */

$pageName = "uniones";
require_once "../common/includes.php";
SessionHandler :: validar_nivel_acceso(ROL__ADMINISTADOR);

$usuario = SessionHandler :: getUsuario();
$id_usuario = $usuario["Id"];

global $IdiomaSitio;
$Mensajes = Comienzo($pageName, $IdiomaSitio);

require "../layouts/top_layout_admin.php";

if (empty ($IdDependenciaAEliminar)) {
	$IdDependenciaAEliminar = 0;
	$NombreDependenciaAEliminar = "";
} else {
	$DependenciaAEliminar = $servicesFacade->getDependencia($IdDependenciaAEliminar);
	$NombreDependenciaAEliminar = $DependenciaAEliminar["Nombre"];
}

if (empty ($IdDependencia)) {
	$IdDependencia = 0;
	$NombreDependencia = "";
} else {
	$Dependencia = $servicesFacade->getDependencia($IdDependencia);
	$NombreDependencia = $Dependencia["Nombre"];
}
?>
<script language="JavaScript">
	function buscarDependenciasAEliminar(){
		location.href="listadoDependencias.php?seleccionarDependencia=1&IdDependencia=<?=$IdDependencia?>";	
	}
	
	function buscarDependencias(){
		location.href="listadoDependencias.php?seleccionarDependencia=2&IdDependenciaAEliminar=<?=$IdDependenciaAEliminar?>";
	}

</script>

<?


if (empty ($IdDependenciaAEliminar) || empty ($IdDependencia) || empty ($B1)) {
?> 

<form method="POST">
	<input type="hidden" name="IdDependenciaAEliminar" value="<?=$IdDependenciaAEliminar; ?>" />
	<input type="hidden" name="IdDependencia" value="<?=$IdDependencia; ?>" />
	
<table width="70%" class="table-form" align="center" cellpadding="1" cellspacing="1">
	<tr>
		<td colspan="2" class="table-form-top-blue">
			<img src="../images/square-w.gif" width="8" height="8">
			<?=$Mensajes["tf-4"]; ?>
		</td>
    </tr>
    <tr>
    	<th><?=$Mensajes["ec-3"]; ?></th>
        <td>
        	<input type="text" name="NombreDependenciaAEliminar"  size="43" value="<?=$NombreDependenciaAEliminar;?>" />
			<input type="button" value="?" name="B3"  OnClick="buscarDependenciasAEliminar();" />
		</td>
		<td><?=$IdDependenciaAEliminar ?></td>
    </tr>
    <tr>
    	<th><? echo $Mensajes["ec-4"];?></th>
   		<td>
   			<input type="text"  name="NombreDependencia" value="<?=$NombreDependencia?>" size="43" />
			<input type="button" value="?" name="B4"  OnClick="buscarDependencias();" />
        </td>
        <td><?=$IdDependencia?></td>
    </tr>
    <tr>
		<th>&nbsp;</th>
		<td>
			<input  type="submit" value="<?= $Mensajes["bot-1"]; ?>" name="B1" />&nbsp;
			<input type="reset" value="<?=$Mensajes["bot-2"]; ?>" name="B2" />
			
	    </td>
    </tr>
	
</table>
</form>
<?

} else {
	$res = $servicesFacade->unirDependencias($IdDependenciaAEliminar, $IdDependencia, $id_usuario);
	if (is_a($res, "Celsius_Exception")){
		$mensaje_error = $Mensajes["error.unionDependencias"];
		$excepcion = $res;
		require "../common/mostrar_error.php";
	}
	?>
	 
	<table width="70%" class="table-form" align="center" cellpadding="1" cellspacing="1">
		<tr>
			<td colspan="2" class="table-form-top-blue">
				<img src="../images/square-w.gif" width="8" height="8">
				<?=$Mensajes["tf-4"]; ?>
			</td>
	    </tr>
		<tr>
	    	<td><?=$Mensajes["tf-5"]; ?></td>
	      	<td><?=$NombreDependenciaAEliminar; ?></td>
		</tr>
	    <tr>
	      	<td><?=$Mensajes["tf-6"]; ?></td>
	      	<td><?=$NombreDependencia; ?></td>
		</tr>
	    <tr>
	      	<td>
	        	<a href="../uniones/administracion_uniones.php"><?=$Mensajes["h-2"]; ?></a>
        	</td>
    	</tr>
	</table>
<?}
	 
require "../layouts/base_layout_admin.php";
	
?>