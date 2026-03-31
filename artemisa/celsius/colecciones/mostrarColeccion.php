<?
/**
 * $IdColeccion   int
 */
$pageName= "colecciones";
require_once "../common/includes.php";
SessionHandler::validar_nivel_acceso(ROL__ADMINISTADOR);

global $IdiomaSitio;
$Mensajes = Comienzo ($pageName, $IdiomaSitio);

require "../layouts/top_layout_admin.php";  
$coleccion = $servicesFacade->getTituloColeccion($IdColeccion);


?>
<table class="table-form" width="70%" align="center" cellspacing="1" cellpadding="3">
	<tr>
		<td colspan="2" class="table-form-top-blue">
			<img src="../images/square-w.gif" width="8" height="8"> 
			<?= $Mensajes["titulo.mostrarTitulo"];  ?>
		</td>
	</tr>
	<tr>
		<th><?= $Mensajes["tf-2"];  ?></th>
		<td><?= $coleccion["Nombre"];?></td>
	</tr>
	<tr>
		<th><?= $Mensajes["tf-3"];?></th>
		<td><?= $coleccion["Abreviado"]; ?></td>
	</tr>
	<tr>
		<th><?= $Mensajes["tf-4"]; ?></th>
		<td><?= $coleccion["ISSN"]; ?></td>
	</tr>
	<tr>
		<th><?= $Mensajes["tf-5"]; ?></th>
		<td><?= $coleccion["Responsable"];?></td>
	</tr>
	<tr>
		<th><?= $Mensajes["campo.volumenes"];?></th>
		<td><?= $coleccion["Volumenes"]; ?></td>
	</tr>
	<tr>
		<th><?= $Mensajes["campo.frecuencia"];?></th>
		<td><?= $coleccion["Frecuencia"]; ?></td>
	</tr>	
	<tr>
		<th>&nbsp;</th>
		<td style='important!'>
			<form name='formu1' action='agregarOModificarCol.php' method='POST'>
			<?							
			if (!empty($IdColeccion)) {?>
				<input type='hidden' value="<?=$IdColeccion?>" name='IdColeccion' />
			   	   						
				<a href="javascript:document.formu1.submit()" ><? echo $Mensajes["botc-2"]; ?></a>
			<?}else{?>
				<a href="javascript:document.formu1.submit()" ><?echo $Mensajes["botc-1"]; ?></a>&nbsp;
			<?}?>
				<a href="seleccionar_titulo_coleccion.php?popup=0&url_destino=colecciones/agregarOModificarCol.php" ><?echo $Mensajes["boton.listadoTitulos"]; ?></a>
			</form>		        				    
		</td>
	</tr>	
</table>
<? require "../layouts/base_layout_admin.php";?>