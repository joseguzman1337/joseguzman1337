<?
/**
 * @param string query EL query a ejecutar
 * @param bool Archivo Si se desea el resultado de la consulta en un csv
 */
$pageName= "ejecutar_SQL";
require_once "../common/includes.php";
SessionHandler :: validar_nivel_acceso(ROL__ADMINISTADOR);
global $IdiomaSitio;
$Mensajes = Comienzo($pageName, $IdiomaSitio);

if (!empty ($query)){
	$query = stripSlashes($query);
	
	//se chequea q el query contenga solo operaciones de lectura sobre la BBDD
	$deniedClauses = array("insert","update" ,"delete", "drop", "alter", "truncate", "create");
	foreach($deniedClauses as $clause){
		if (stripos($query, $clause) !== FALSE){
			$error = $Mensajes["warning.clausulaProhibida"]."($clause)";
			$result = new DB_Exception($error,"", 0);
			break;
		}
	}
	if (empty($error)){
		$result = mysql_query($query);
		if ($result===FALSE)
			$result = new DB_Exception($Mensajes["warning.errorSQL"],mysql_error(), mysql_errno());
	}
}

if (!empty ($result) && !is_a($result, "DB_Exception") && !empty($Archivo)) {
	//si se especifico un query, no hubo error, y el usuario pidio un archivo
	$ext = "csv";
	$sep = ",";

	@ set_time_limit(600);
	$crlf = "\r\n";

	header("Content-disposition: filename=ConsultaCelsius.$ext");
	header("Content-type: application/octetstream");
	header("Pragma: no-cache");
	header("Expires: 0");

	$schema_insert = "";
	for ($i = 0; $i < mysql_num_fields($result); $i++) {
		$schema_insert .= mysql_field_name($result, $i) . $sep;
	}

	$schema_insert = str_replace($sep . "\$", "", $schema_insert);
	echo trim($schema_insert);
	echo $crlf;

	while ($row = mysql_fetch_row($result)) {
		$schema_insert = "";

		for ($j = 0; $j < mysql_num_fields($result); $j++) {
			if (!isset ($row[$j]))
				$schema_insert .= "NULL" . $sep;
			elseif (strpos($row[$j],$sep) === FALSE) 
				$schema_insert .= "$row[$j]" . $sep;
			else
				$schema_insert .= "\"$row[$j]\"" . $sep;
		}
		$schema_insert = str_replace($sep . "\$", "", $schema_insert);
		echo trim($schema_insert);
		echo $crlf;
	}
	exit;
} 

require "../layouts/top_layout_admin.php";
?>

<form method="post">
<div align="center" style="background-color:#CCCCCC;width:95%">
<br/>
<table width="90%" align="center" border="0" cellpadding="1" cellspacing="3" class="table-form" style="background-color:#CCCCCC">
	<tr>
    	<td class="table-form-top-blue">
    		<img src="../images/square-w.gif" width="8" height="8">
    		<? echo $Mensajes["tf-6"]; ?>
    	</td>
	</tr>
	<tr>
		<td>
			<? echo $Mensajes["tf-1"]?><br/>
			<textarea name="query" cols="100" rows="7"><? if (isset($query))echo stripSlashes($query); ?></textarea>
		</td>
	</tr>
	<tr>
		<td>
			<input type="checkbox" name="Archivo"/>
			<? echo $Mensajes["tf-3"]; ?>
		</td>
	</tr>
	<tr>
		<td><input type="submit" value="<? echo $Mensajes["bot-1"]?>"/></td>
	</tr>
	<tr>
		<td>
			<?
			if (isset ($result)) {
				echo $Mensajes["tf-4"]." <b>".$query."</b>";
				
				if (is_a($result, "DB_Exception")){?>
					<blockquote style="color:red">
  						<b><?= $result->getMessage() ?></b>
						<br/><b><?= $Mensajes["warning.codigoError"];?> : </b><?= $result->dbError ?>
						<br/><b><?= $Mensajes["warning.mensajeError"];?> : </b><?= $result->dbErrorNo ?>
					</blockquote>
				<?}else{?>
					<br/>
					
					<br/>
					<!-- impresion de resultados -->
					<div align="center" style="width:95%; height:300px; background-color:#F2F2F2; overflow:auto; padding:5px">
					<table border="1" cellspacing="0" cellpadding="2" style="border:solid #006699;">
					<thead>
						<tr>
							<? for ($i = 0; $i < mysql_num_fields($result); $i++) { ?>
								<th class="titulo">
									<font face='MS Sans Serif' size='1' color='#155CAA'><?= mysql_field_name($result, $i) ?></font>
								</th>
							<?} ?>
						</tr>
					</thead>
					<tbody>
						<? for ($i = 0; $i < mysql_num_rows($result); $i++) {
							$row_array = mysql_fetch_row($result);
							?>
							<tr>
								<? for ($j = 0; $j < mysql_num_fields($result); $j++) {?>
									<td>
										<font face='MS Sans Serif' size='1' color='#003399'>
											<? if ($row_array[$j] != "") echo $row_array[$j];?>
											&nbsp;
										</font>
									</td>
								<? }?>
							</tr>
						<? } ?>
					</tbody>
					
					</table>
					<!-- end impresion de resultados -->
					</div>
				<?} 
			}?>
		</td>
	</tr>
</table>
</div>
</form>

<?
$pageName = "ejecutar_SQL";
require "../layouts/base_layout_admin.php";
?>