<?
$pageName= "paises1";
require_once "../common/includes.php";
SessionHandler::validar_nivel_acceso(ROL__ADMINISTADOR);
require "../layouts/top_layout_admin.php";
global $IdiomaSitio;
$Mensajes = Comienzo ($pageName,$IdiomaSitio);
$conditions=array();
   	
if (!empty($seleccionarPais)&&($seleccionarPais==1)){
	$conditions["esCentralizado"]=0;
}

$paises= $servicesFacade->getPaises($conditions);
?>

<table width="70%" class="table-list" align="center" cellpadding="1" cellspacing="1">
	<tr>
		<td class="table-list-top" colspan="4">
			<img src="../images/square-w.gif" width="8" height="8"> 
			<? echo $Mensajes["et-1"]; ?>
		</td>
	</tr>
	<tr>
  		<th><?=$Mensajes["ec-1"]; ?></th>
	   	<th><?=$Mensajes["campo.esCentralizado"]; ?></th>
	   	<th>&nbsp;</th>
	   	<th>&nbsp;</th>
	   	<th>&nbsp;</th>
	</tr>
	<? foreach ($paises as $pais){?>
  	<tr>
  		<td><?=$pais["Nombre"]; ?></td>
  		<td><?=($pais["esCentralizado"] == 1)? $Mensajes["mensaje.afirmacion"]:$Mensajes["mensaje.negacion"]; ?></td>
		<td><a href="modificarOAgregarPais.php?idPais=<?=$pais["Id"] ?>"><?=$Mensajes["h-2"]; ?></a></td>	    
	   	<td><a href="mostrarPais.php?idPais=<?=$pais["Id"]?>"><?=$Mensajes["et-1"]; ?></a></td>
	  	<td>&nbsp;
	  	    <? if (!empty($seleccionarPais) && $seleccionarPais==1){?>
  				   |<a href="union_paises.php?IdPaisAEliminar=<?=$pais["Id"]; ?>&NombrePaisAEliminar=<?=$pais["Nombre"]; ?>"><?=$Mensajes["h-4"]; ?></a>
  	    	<?}elseif (!empty($seleccionarPais) && $seleccionarPais==2){?>
  	    		   |<a href="union_paises.php?IdPaisAEliminar=<?= $IdPaisAEliminar; ?>&NombrePaisAEliminar=<? echo $NombrePaisAEliminar; ?>&IdPais=<?=$pais["Id"]; ?>&NombrePais=<?=$pais["Nombre"]; ?>"><?=$Mensajes["h-4"]; ?></a>
  	    	<?}?>
  	    </td>
  	</tr>
  <?}?>
</table>

<? require "../layouts/base_layout_admin.php";?>