<?
$pageName= "categorias1";
require_once "../common/includes.php";
SessionHandler::validar_nivel_acceso(ROL__ADMINISTADOR);
require "../layouts/top_layout_admin.php";
global $IdiomaSitio;
$Mensajes = Comienzo ($pageName,$IdiomaSitio);
$tiposUsuarios=$servicesFacade->getCategoriasUsuarios();
?>
<table width="70%" class="table-list" align="center" cellpadding="1" cellspacing="1">
	<tr>
		<td class="table-list-top" colspan="4">
			<img src="../images/square-w.gif" width="8" height="8" /> 
			<?=$Mensajes["ec-1"]; ?>
		</td>
	</tr>
	<tr>
  		<th><?=$Mensajes["ele-1"];?></th>
	   	<th>&nbsp;</th>
	   	<th>&nbsp;</th>
	   	<th>&nbsp;</th>
	</tr>
	<?foreach ($tiposUsuarios as $tipoUsuario){?>
	<tr>
		<td><?=$tipoUsuario["Nombre"];?></td>
		<td><a href="modificarOAgregarCategoria.php?operacion=1&IdCategoria=<?=$tipoUsuario["Id"];?>"><?=$Mensajes["h-2"];?></a></td>	    
	   	<td><a href="mostrarCategoria.php?IdCategoria=<?=$tipoUsuario["Id"]?>"><?=$Mensajes["link.mostrarCategoria"]; ?></a></td>
		<td>&nbsp;
			<? if (!empty($seleccionarCategoria) && $seleccionarCategoria==1){?>
	  	    |<a href="union_categorias.php?IdCategoriaAEliminar=<?=$tipoUsuario["Id"]; ?>&NombreCategoriaAEliminar=<?=$tipoUsuario["Nombre"]; ?>"><?=$Mensajes["h-4"]; ?></a>
	  	    <?}elseif (!empty($seleccionarCategoria) && $seleccionarCategoria==2){?>
	  	    |<a href="union_categorias.php?IdCategoriaAEliminar=<?=$IdCategoriaAEliminar; ?>&NombreCategoriaAEliminar=<?=$NombreCategoriaAEliminar; ?>&IdCategoria=<?=$tipoUsuario["Id"]; ?>&NombreCategoria=<?=$tipoUsuario["Nombre"]; ?>"><?=$Mensajes["h-4"]; ?></a>
  	    <?}?>
  	    </td>	
	</tr>
<?}?>
</table>
<? require "../layouts/base_layout_admin.php";?>