<?
/**
 * $IdInstitucionAEliminar
 * $idInstitucion
 */
$pageName = "uniones";
require_once "../common/includes.php";
SessionHandler :: validar_nivel_acceso(ROL__ADMINISTADOR);

global $IdiomaSitio;
$Mensajes = Comienzo($pageName, $IdiomaSitio);

require "../layouts/top_layout_admin.php";
$usuario = SessionHandler :: getUsuario();
$id_usuario = $usuario["Id"];

if (empty ($IdInstitucionAEliminar)){
	$IdInstitucionAEliminar = 0;
	$NombreInstitucionAEliminar ="";
}else{
	$InstitucionAEliminar  = $servicesFacade->getInstitucion($IdInstitucionAEliminar);
	$NombreInstitucionAEliminar = $InstitucionAEliminar["Nombre"]; 
}
if (empty($IdInstitucion)){
	$IdInstitucion = 0;
	$NombreInstitucion ="";
}else{
	$Institucion = $servicesFacade->getInstitucion($IdInstitucion);
	$NombreInstitucion = $Institucion["Nombre"];
}
?>
<script language="JavaScript">
function buscarInstitucionAEliminar(){
	document.forms.form1.IdInstitucionAEliminar.value=<?=$IdInstitucionAEliminar ?>; 
	document.forms.form1.seleccionarInstitucion.value=1;
	document.forms.form1.action = "listadoInstituciones.php";
	document.forms.form1.submit();
}

function buscarInstitucion(){
	document.forms.form1.IdInstitucion.value=<? if (empty($IdInstitucion) || $IdInstitucion==$IdInstitucionAEliminar) { $IdInstitucion=0; } echo $IdInstitucion; ?>; 
	document.forms.form1.seleccionarInstitucion.value=2;
	document.forms.form1.action = "listadoInstituciones.php";
	document.forms.form1.submit();
}

</script>
<?
if (empty ($IdInstitucionAEliminar) || empty ($IdInstitucion) || empty ($B1)) {
?> 

<form method="get" name="form1" action="union_instituciones.php">
	<input type="hidden" name="IdInstitucionAEliminar" value="<?=$IdInstitucionAEliminar; ?>" />
    <input type="hidden" name="IdInstitucion" value="<?=$IdInstitucion; ?>" />
	<input type="hidden" name="seleccionarInstitucion" />
            
<table width="70%" class="table-form" align="center" cellpadding="1" cellspacing="1">
	<tr>
		<td colspan="3" class="table-form-top-blue">
			<img src="../images/square-w.gif" width="8" height="8"><? echo $Mensajes["tf-1"]; ?>
		</td>
    </tr>
    <tr>
    	<th><? echo $Mensajes["ec-1"]; ?></th>
        <td>
        	<input type="text" name="NombreInstitucionAEliminar"  size="43" value="<? if (isset($NombreInstitucionAEliminar)){echo $NombreInstitucionAEliminar;   }?>" />
			<input type="button" value="?" name="B3"  OnClick="buscarInstitucionAEliminar();" />
		</td>
		<td><? echo $IdInstitucionAEliminar; ?></td>
    </tr>
    <tr>
    	<th><? echo $Mensajes["ec-2"];?></th>
   		<td>
   			<input type="text"  name="NombreInstitucion" value="<? if (isset($NombreInstitucion)){echo $NombreInstitucion;} ?>"size="43" />
			<input type="button" value="?" name="B4"  OnClick="buscarInstitucion();" />
        </td>
        <td><?echo $IdInstitucion; ?></td>
    </tr>
    <tr>
		<th>&nbsp;</th>
		<td>
			<input  type="submit" value="<? echo $Mensajes["bot-1"]; ?>" name="B1" />&nbsp;
			<input type="reset" value="<? echo $Mensajes["bot-2"]; ?>" name="B2" />
	    </td>
    </tr>
	
</table>
</form>
<?

} else {
	$res = $servicesFacade->unirInstituciones($IdInstitucionAEliminar, $IdInstitucion, $id_usuario);
	if (is_a($res, "Celsius_Exception")){
		$mensaje_error = $Mensajes["error.unionInstituciones"];
		$excepcion = $res;
		require "../common/mostrar_error.php";
	}
		
	?>
	<table width="70%" class="table-form" align="center" cellpadding="1" cellspacing="1">
		<tr>
			<td colspan="2" class="table-form-top-blue">
				<img src="../images/square-w.gif" width="8" height="8">
				<? echo $Mensajes["tf-1"]; ?>
			</td>
	    </tr>
		<tr>
	    	<th><? echo $Mensajes["tf-2"]; ?></th>
	        <td><? echo $NombreInstitucionAEliminar; ?></td>
	      
	    </tr>
	    <tr>
	    	<th><? echo $Mensajes["tf-3"]; ?></th>
	        <td><? echo $NombreInstitucion; ?></td>
		</tr>
	    <tr>
	    	<td>&nbsp;</td>
	      	<td>
	      		<a href="../uniones/administracion_uniones.php"><? echo $Mensajes["h-2"]; ?></a>
	      	</td>
	    </tr>
	</table>
<?}

require "../layouts/base_layout_admin.php";?> 