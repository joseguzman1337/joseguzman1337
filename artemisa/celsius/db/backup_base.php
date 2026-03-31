<?
$pageName= "backup";
require_once "../common/includes.php";
SessionHandler :: validar_nivel_acceso(ROL__ADMINISTADOR);

require_once "../files/pclzip.lib.php";

global $IdiomaSitio;
$Mensajes = Comienzo($pageName, $IdiomaSitio);

//saca el timeout 
set_time_limit(0);

/******************************************************************************************************/
function file_init($name) {
	if (file_exists($name)) {
		unlink($name);
	}
	$arch = fopen($name, "w");
	echo "archicooo creado";
	return ($arch);
}

function add_line($archivo, $insert) {
	$retorno = fwrite($archivo, $insert . "\r\n");
	return $retorno;
}

function armar_CREATE_TABLA($db, $tabla, $archivo) {
	$resultado = mysql_query("SHOW CREATE TABLE " . $tabla);
	$row = mysql_fetch_array($resultado);
	$cadena = $row["Create Table"];
	$cadena .= '; ';
	add_line($archivo, $cadena);
	return $cadena;
}

function armar_INSERT_TABLA($db, $tabla, $archivo) {
	$local_query = 'SELECT * FROM ' . $db . '.' . $tabla;
	$resultado_contenido_tabla = mysql_query($local_query);
	$fields = mysql_list_fields($db, $tabla);
	$esquema_insert = " INSERT INTO ". $tabla . "   ( ";
	$cantidad_campos = mysql_num_fields($fields);
	for ($i = 0; $i < $cantidad_campos; $i++) {
		$campo = mysql_field_name($resultado_contenido_tabla, $i);
		$esquema_insert .= $campo;
		if ($i < ($cantidad_campos -1)) {
			$esquema_insert .= ' , ';
		}
	}
	$esquema_insert .= ' ) VALUES ( ';
	$cadena = "";
	while ($row = mysql_fetch_array($resultado_contenido_tabla)) {

		$cadena = $esquema_insert;
		for ($i = 0; $i < $cantidad_campos; $i++) {
			//Tendria que reemplazar los valores
			$cadena .= "'" . addslashes(str_replace('`', '&#96;', $row[$i])) . "'";

			if ($i < ($cantidad_campos -1)) {
				$cadena .= ' , ';
			}
		}
		$cadena .= ' ); ';
		add_line($archivo, $cadena);
	}
	mysql_free_result($resultado_contenido_tabla);
	return "";
}

function armar_INSERT_TABLAS($db, $archivo) {
	//	"Armo los insert de cada tabla"

	$show_table = 'SHOW TABLES FROM ' . $db;
	$resultado_tablas = mysql_query($show_table);
	$num_tables = mysql_num_rows($resultado_tablas);
	$consulta = "";

	while ($row = mysql_fetch_row($resultado_tablas)) {
		$tabla = $row[0];
		$consulta = armar_CREATE_TABLA($db, $tabla, $archivo);
		$consulta = armar_INSERT_TABLA($db, $tabla, $archivo);
	}
	return $consulta;
}

function armar_DROP($db, $archivo) {
	//	"Borra la bd si existe"

	$drop_query = "DROP DATABASE " . $db . ';';
	add_line($archivo, $drop_query);
	return $drop_query;
}

function armar_CREATE($db, $archivo) {
	//	"Crea la bd "

	$create_query = 'CREATE DATABASE ' . $db . ';';
	add_line($archivo, $create_query);
	return $create_query;

}

function armar_USE($db, $archivo) {
	// "Se hace uso de la bd"
	$use_query= 'USE '.$db.';';
	add_line($archivo, $use_query);
	return $use_query;
	
}


/******************************************************************************************************/

if (isset ($paso2) && ($paso2 == 1)) {

	$directorio = Configuracion::getDirectorioTemporal();
	if (is_a($directorio, "File_Exception")){
    		return $directorio;
    }
	
	$straux = str_replace("/", "//", $directorio);
	//if ($straux == $directorio)		$straux = str_replace('\\', "\\\\", $directorio);
	if (file_exists($straux . '//backup_' . $db . '_' . date('Ymd') . '.zip')) {
		unlink($straux . '//backup_' . $db . '_' . date('Ymd') . '.zip');
	}

   
	$zip = new PclZip($straux . '//backup_' . $db . '_' . date('Ymd') . '.zip' );
	
	$total = $zip->create($straux .'//'.$filename ,    PCLZIP_OPT_REMOVE_ALL_PATH);
	//@ unlink($straux .'//'.$filename);
    $filename1 = $directorio . '//backup_' . $db . '_' . date('Ymd') . '.zip';
	$filesize = filesize($filename1);
	$length = filesize($source);
	//echo $filename;
	header("Content-type: application/zip");
    header("Content-Transfer-Encoding: Binary");
    header("Accept-Ranges: bytes");
	header("Cache-Control: ");// leave blank to avoid IE errors
    header("Pragma: ");// leave blank to avoid IE errors 
    header("Content - length: $length");
	header("Content-Disposition:attachment; filename=backup_" . $db . "_" . date('Ymd') . ".zip");
	@ readfile($filename1);
	@unlink($straux .'//'.$filename);
	@unlink($filename1);

}
else{
	require "../layouts/top_layout_admin.php";
	?>
	<table class="table-form" width="100%">
	<tr>
		<td class="table-form-top-blue">
			<img src="../images/square-w.gif" width="8" height="8">
		</td>
	</tr>
	</table>
	<table width="90%" border="0" style="margin-bottom: 0; border-collapse:collapse" bordercolor="#111111" cellpadding="0" cellspacing="0">
		<tr>
	    	<td class="style50" align="left">
	    		<blockquote><p class="style50">
	    		<? if ((isset ($paso1)) && $paso1 == 1) {
					
					
					?>
					<table width='95%' align='center'>
						<tr>
							<td width='100%' align='center'>
								<embed src='../images/simple_countdown.swf' menu='false' quality='high' background='../images/banda.jpg' type='application/x-shockwave-flash'></embed>
							</td>
						</tr>
						<tr>
							<td width='100%' align='center'>
								<b><font face='MS Sans Serif' size='2' color='#000000'><?= $Mensajes["tit-1"] ?></font></b>
								<br/>
								
								<font face='MS Sans Serif' color='#000000' size='2'><?= $Mensajes["tit-2"] ?></font>
								<img src='../images/diskette.gif'/>
							</td>
						</tr>
					</table>
					
				<? 
					
					$conf= new Configuracion;
					$db = $conf->get_DB_DatabaseName();
					$directorio = Configuracion::getDirectorioTemporal();
	                if (is_a($directorio, "File_Exception")){
    		            return $directorio;
                    }
					$filename = 'backup_' . $db . '_' . date('Ymd') . '.sql';
//					var_dump($directorio); echo "hola";
					$name = $directorio . "/" . $filename;
					
					?>
					<form name="form1" method="post">
						<input type="hidden" name="db" value="<?= $db ?>">
						<input type="hidden" name="filename" value="<?= $filename ?>">
						<input type="hidden" name="paso2" value="1">
						<input type="hidden" name="name" value="<?=$name?>">
					</form> 
					<?
					
					
								
				} else {?>
					<table width='95%' align='center'>
						<tr>
							<td width='100%' align='center'>
								<embed src='../images/simple_countdown.swf' menu='false' quality='high' background='../images/banda.jpg' type='application/x-shockwave-flash'></embed>
							</td>
						</tr>
						<tr>
							<td width='100%' align='center'>
								<b>
									<font face='MS Sans Serif' size='2' color='#000000'><?= $Mensajes["tit-1"] ?></font>
								</b>
							</td>
						</tr>
					</table>
					<form name='form1' method='post' action='backup_base.php'>
						<input type="hidden" name="paso1" value="1">
					</form>
			<?}?>
			</p></blockquote>
	    	</td>
	    </tr>
	</table>
	
	
	<?
    $pageName = "backup";
    require "../layouts/base_layout_admin.php";
    if ((isset ($paso1)) && $paso1 == 1) {
    				flush();
					sleep(5);
      				$archivo = file_init($name); //armo el nombre del archivo: backup_NombreBD_fecha
					$drop	= armar_DROP($db,$archivo);  
					$create	= armar_CREATE($db,$archivo);
					$use = armar_USE($db,$archivo); 
					$inserts	= armar_INSERT_TABLAS($db,$archivo); 
					fclose($archivo);
    }
    
    ?>
    <script language="JavaScript" type="text/javascript">
	  	document.forms.form1.submit(); 
	</script><?
}
?>