<?
/**
 * @param file $Archivo 
 */

$pageName = "traducciones1";
require_once "../common/includes.php";
SessionHandler :: validar_nivel_acceso(ROL__ADMINISTADOR);
global $IdiomaSitio;
$Mensajes = Comienzo($pageName, $IdiomaSitio);

if (!empty($subir)) {
	$directorio = Configuracion::getDirectorioTemporal();
	$straux = str_replace("\\", "/", $directorio);
	require_once "../files/FilesUtils.php";
	$archivo_subido = FilesUtils :: upload_File($_FILES["Archivo"],$directorio);
	if (is_a($archivo_subido,"Celsius_Exception")) {
		$mensaje_error = $Mensajes["warning.errorDeArchivo"];
		$excepcion = $archivo_subido;
		require "../common/mostrar_error.php";
	}else{
		$filename = $directorio . $archivo_subido[0];
		echo $filename;
		$Instruccion = "LOAD DATA INFILE \"" . $filename . "\" REPLACE INTO TABLE traducciones FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '\"' LINES TERMINATED BY '\n'";
		mysql_query($Instruccion);
		echo mysql_error();
		echo " ".$Mensajes["mensajes.traduccionesCargadas"];
	}
}

require "../layouts/top_layout_admin.php";
?>
<br/>

<form enctype="multipart/form-data" method="POST" name="form1" action="subir_traducciones.php">

<table class="table-form" cellpadding="2" cellspacing="1" align="center">
	<tr>
    	<td colspan="2" class="table-form-top-blue">
    		<img src="../images/square-w.gif" width="8" height="8" /><?=$Mensajes["et-1"];?>
        </td>
    </tr>	
	<tr>
		<th><?= $Mensajes["campo.archivoCSV"];?>:</th>
		<td><input  type="file" name="Archivo" size="30"/></td>
	</tr>
	<tr>
		<th>&nbsp;</th>
		<td><input type="submit" name="subir" value="<?= $Mensajes["ec-1"];?>" /></td>
	</tr>
</table>
</form>
<? require "../layouts/base_layout_admin.php";?> 