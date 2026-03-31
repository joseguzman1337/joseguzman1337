<?
$pageName = "traducciones3";
require_once "../common/includes.php";
SessionHandler :: validar_nivel_acceso(ROL__ADMINISTADOR);

global $IdiomaSitio;
$Mensajes = Comienzo($pageName, $IdiomaSitio);

if (!empty($descargar) && !empty($Codigo_Idioma)) {

	//$directorio_TMP = Configuracion :: getDirectorioTemporal();
	
	$real_filename = tempnam("xxx","traducciones");
	if (file_exists($real_filename))
		unlink($real_filename);
	
	$destination_file = str_replace("\\","\\\\",dirname($real_filename).DIRECTORY_SEPARATOR.basename($real_filename));
	$filename = "traduccionesCelsius.csv";
	
	$Instruccion = "SELECT Codigo_Pantalla,Codigo_Elemento,Codigo_Idioma,CONCAT(SUBSTRING(Texto,1 ,LENGTH(Texto))), traduccion_completa   INTO OUTFILE \"" . ($destination_file)."\"";
	$Instruccion .= " FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '\"' LINES TERMINATED BY '\n' FROM traducciones WHERE Codigo_Idioma=" . $Codigo_Idioma;
	mysql_query($Instruccion);
	echo mysql_error();
	
	$size = filesize($destination_file);
	
	header("Content-type: application/force-download");
	header("Pragma: no-cache");
	header("Content-Disposition:attachment; filename=$filename");
	header("Content-Transfer-Encoding: application/octet-stream\n");
	header("Content-Length:$size");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0, public");
	@ readfile($destination_file);
	exit;
}

require "../layouts/top_layout_admin.php";
?>
<table width="70%" class="table-list" align="center" cellpadding="1" cellspacing="1">
	<tr>
		<td class="table-list-top" colspan="4">
			<img src="../images/square-w.gif" width="8" height="8" /> 
			<?= $Mensajes["et-1"]; ?>
		</td>
	</tr>
	<?
	$idiomas = $servicesFacade->getIdiomas();
	foreach ($idiomas as $idioma) {?>
		<tr>
			<th><?= $idioma["Nombre"];?></th>
			<td><a href="descargar_traducciones.php?descargar=1&Codigo_Idioma=<?=$idioma["Id"]; ?>" target="_blank"><?=$Mensajes["ec-1"];?></a></td>
		</tr>
	<? }?>  
	<tr>
		<th>&nbsp;</th>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<th>&nbsp;</th>
		<td><input type="button" name="volver" id="volver" value="<?=$Mensajes["h-1"];?>" onClick="location.href = '../sitio_usuario/sitio_administrador.php';" /></td>
	</tr>
</table>

<? require "../layouts/base_layout_admin.php";?>