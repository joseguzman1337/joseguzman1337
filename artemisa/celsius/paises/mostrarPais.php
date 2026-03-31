<?
/**
 * @param int $idPais
 */
$pageName="paises";
require_once "../common/includes.php";
SessionHandler::validar_nivel_acceso(ROL__ADMINISTADOR);
require "../layouts/top_layout_admin.php";
global $IdiomaSitio;
$Mensajes = Comienzo ($pageName,$IdiomaSitio);

if(empty($idPais)){
	$mensaje_error= $Mensajes["error.faltaIdPais"];
	$excepcion = new Application_Exception($mensaje_error);
	require "../common/mostrar_error.php";
}

$pais= $servicesFacade->getPais($idPais);
?>

<table class="table-form" width="50%" align="center" cellspacing="1" cellpadding="1">
	<tr>
		<td colspan="2" class="table-form-top-blue">
			<img src="../images/square-w.gif" width="8" height="8"> 
			<?=$Mensajes["titulo.pais"];?>
		</td>
	</tr>
	<tr>
		<th><?=$Mensajes["ec-1"];?></th>
	   	<td><?=$pais["Nombre"]; ?></td>
	</tr>
	<tr>
		<th><?=$Mensajes["ec-2"];?></th>
	   	<td><?=$pais["Abreviatura"]; ?></td>
	</tr>
	<tr>
		<th><?=$Mensajes["campo.permiteRevista"];?></th>
	   	<td><?if ($pais["permite_revista"]==1) echo $Mensajes["mensaje.afirmacion"]; else echo $Mensajes["mensaje.negacion"]; ?></td>
	</tr>
	<tr>
		<th><?=$Mensajes["campo.permiteLibro"];?></th>
	   	<td><?if ($pais["permite_libro"]==1) echo $Mensajes["mensaje.afirmacion"]; else echo $Mensajes["mensaje.negacion"]; ?></td>
	</tr>
	<tr>
		<th><?=$Mensajes["campo.permiteTesis"];?></th>
	   	<td><?if ($pais["permite_tesis"]==1) echo $Mensajes["mensaje.afirmacion"]; else echo $Mensajes["mensaje.negacion"]; ?></td>
	</tr>
	<tr>
		<th><?=$Mensajes["campo.permitePatente"];?></th>
	   	<td><?if ($pais["permite_patente"]==1) echo $Mensajes["mensaje.afirmacion"]; else echo $Mensajes["mensaje.negacion"]; ?></td>
	</tr>
	<tr>
		<th><?=$Mensajes["campo.permiteCongreso"];?></th>
	  	<td><?if ($pais["permite_congreso"]==1) echo $Mensajes["mensaje.afirmacion"]; else echo $Mensajes["mensaje.negacion"]; ?></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>
		 	<input type="button" onclick="location.href='modificarOAgregarPais.php?idPais=<?=$idPais?>';" value="<?=$Mensajes["botc-2"]; ?>" />
		 	<input type="button" onclick="location.href='listadoPaises.php';" value="<?=$Mensajes["boton.listar_paises"]; ?>" />
        </td>
	 </tr>	
</table>
<? require "../layouts/base_layout_admin.php";?>