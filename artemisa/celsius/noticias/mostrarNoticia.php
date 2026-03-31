<?
$pageName="noticias";
require_once "../common/includes.php";
SessionHandler :: validar_nivel_acceso(ROL__ADMINISTADOR);


global $IdiomaSitio;
$Mensajes = Comienzo ($pageName,$IdiomaSitio);


$noticia = $servicesFacade->getNoticia($idNoticia);
$nombreIdioma= $servicesFacade->getIdioma($noticia["Codigo_Idioma"]);

require "../layouts/top_layout_admin.php";
?>
<table class="table-form" width="90%" cellpadding="2" cellspacing="1" align="center">
	<tr>
		<td colspan="2" class="table-form-top-blue">
			<img src="../images/square-w.gif" width="8" height="8" /> 
			<?=$Mensajes["h-3"]; ?>
		</td>
	</tr>
	<tr>
		<th><?= $Mensajes["ec-1"];?></th>
		<td><?  echo $noticia["Fecha"];?></td>
	</tr>
	<tr>
		<th><?= $Mensajes["ec-4"];?></th>
		<td><?= $nombreIdioma["Nombre"]; ?></td>
	</tr>
	<tr>
		<th><?= $Mensajes["ec-2"];?></th>
		<td><? echo $noticia["Titulo"]; ?></td>
	</tr>
	<tr>
		<th><?= $Mensajes["ec-3"];?></th>
		<td><? echo $noticia["Texto_Noticia"]; ?></td>
	</tr>
	<tr>	
		<td>&nbsp;</td>
		<td>
			<input type="button" name="bModificar" value="<?= $Mensajes["bot-1"]; ?>" onclick="location.href='modificarOAgregarNoticia.php?idNoticia=<?= $idNoticia; ?>';"/>
			<input type="button" name="bModificar" value="<?= $Mensajes["h-1"]; ?>" onclick="location.href='modificarOAgregarNoticia.php';"/>
			<input type="button" name="bModificar" value="<?= $Mensajes["boton.listarNoticias"]; ?>" onclick="location.href='listadoNoticias.php';"/>
		</td>
	</tr>	
</table>
<? require "../layouts/base_layout_admin.php";?> 