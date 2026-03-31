<?
/**
 * $IdUnidadAEliminar
 * $IdUnidad
 */
$pageName = "uniones";
require_once "../common/includes.php";
SessionHandler::validar_nivel_acceso(ROL__ADMINISTADOR); 
$usuario = SessionHandler::getUsuario();
$id_usuario = $usuario["Id"];
 
global $IdiomaSitio;
$Mensajes = Comienzo ($pageName,$IdiomaSitio);

require "../layouts/top_layout_admin.php";


if (empty($IdUnidadAEliminar)){
	$IdUnidadAEliminar=0;
	$NombreUnidadAEliminar = ""; 
}else{
	$UnidadAEliminar = $servicesFacade->getUnidad($IdUnidadAEliminar);
	$NombreUnidadAEliminar = $UnidadAEliminar["Nombre"];
}
if (empty($IdUnidad)){
	$IdUnidad=0; 
	$NombreUnidad="";
}else{
	$Unidad = $servicesFacade->getUnidad($IdUnidad);
	$NombreUnidad = $Unidad["Nombre"];
}


   
?>
<script language="JavaScript">
	function buscarUnidadesAEliminar(){
		location.href="listadoUnidades.php?IdUnidadAEliminar=<?=$IdUnidadAEliminar?>&seleccionarUnidad=1";
	}
	
	function buscarUnidades(){
		location.href="listadoUnidades.php?IdUnidad=<?=$IdUnidad?>&seleccionarUnidad=2";
	}
</script>

<?
if (empty($IdUnidadAEliminar) || empty($IdUnidad)|| empty($B1)){?> 
	
	<form method="POST" >
		<input type="hidden" name="IdUnidadAEliminar" value="<?=$IdUnidadAEliminar; ?>">
	    <input type="hidden" name="IdUnidad" value="<?=$IdUnidad; ?>">
	    
	<table width="70%" class="table-form" align="center" cellpadding="1" cellspacing="1">
		<tr>
			<td colspan="2" class="table-form-top-blue">
				<img src="../images/square-w.gif" width="8" height="8">
				<?=$Mensajes["tf-10"]; ?>
			</td>
	    </tr>
	    <tr>
	    	<th><?=$Mensajes["ec-7"]; ?></th>
	        <td>
	        	<input type="text" name="NombreUnidadAEliminar"  size="43" value="<? if (isset($NombreUnidadAEliminar)){echo $NombreUnidadAEliminar;   }?>">
				<input type="button" value="?" name="B3"  OnClick="buscarUnidadesAEliminar();">
			</td>
			<td><?=$IdUnidadAEliminar?></td>
	    </tr>
	    <tr>
	    	<th><?=$Mensajes["ec-8"];?></th>
	   		<td>
	   			<input type="text"  name="NombreUnidad" value="<? if (isset($NombreUnidad)){echo $NombreUnidad;} ?>"size="43">
				<input type="button" value="?" name="B4"  OnClick="buscarUnidades();">
	        </td>
	        <td><?=$IdUnidad?></td>
	    </tr>
	    <tr>
			<th>&nbsp;</th>
			<td>
				<input  type="submit" value="<?= $Mensajes["bot-1"]; ?>" name="B1">&nbsp;
				<input type="reset" value="<?=$Mensajes["bot-2"]; ?>" name="B2">
		    </td>
	    </tr>
	</table>
	</form>

<?}else{
    $res = $servicesFacade->unirUnidades($IdUnidadAEliminar,$IdUnidad,$id_usuario);
    if (is_a($res, "Celsius_Exception")){
    	$mensaje_error = $Mensajes["error.unionUnidades"];
		$excepcion = $res;
		require "../common/mostrar_error.php";
	}
	?>
	<table width="70%" class="table-form" align="center" cellpadding="1" cellspacing="1">
		<tr>
			<td colspan="2" class="table-form-top-blue">
				<img src="../images/square-w.gif" width="8" height="8">
				&nbsp;
				<?=$Mensajes["tf-4"]; ?>
			</td>
	    </tr>
		<tr>
	    	<th><?=$Mensajes["tf-11"]; ?></th>
	      	<td><?=$NombreUnidadAEliminar; ?></td>
		</tr>
	    <tr>
	      	<th><?=$Mensajes["tf-12"]; ?></th>
	      	<td><?=$NombreUnidad; ?></td>
		</tr>
	    <tr>
	      	<td>
	        	<a href="../uniones/administracion_uniones.php"><? echo $Mensajes["h-2"]; ?></a>
	        </td>
	    </tr>
	</table>
<?}?> 
<? require "../layouts/base_layout_admin.php";?> 