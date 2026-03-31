<?php
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING ^ E_DEPRECATED);
ini_set('display_errors', E_ALL ^ E_NOTICE ^ E_WARNING ^ E_DEPRECATED);
ini_set('memory_limit', '128M');
ini_set('max_execution_time','216000');
		
function sanear_string($string) {
	$string = trim($string);
	$string = str_replace( array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'), array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'), $string);
	$string = str_replace( array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'), array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'), $string);
	$string = str_replace( array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'), array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'), $string);
	$string = str_replace( array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'), array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'), $string);
	$string = str_replace( array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'), array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'), $string);
	$string = str_replace( array('ñ', 'Ñ', 'ç', 'Ç'), array('n', 'N', 'c', 'C',), $string);
	$string = str_replace( array("\\", "¨", "º", "-", "~","#", "@", "|", "!", "\"","·", "$", "%", "&", "/","(", ")", "?", "'", "¡","¿", "[", "^", "`", "]","+", "}", "{", "¨", "´",">", "<", ";", ",", ":",".", " "),'',$string);
 
	return $string;
}


//Conectamos con PostgreSQL
$conexion = pg_connect("host=snies.unbosque.edu.co dbname=odsbosque user=postgres password=") or die ("Fallo en el establecimiento de la conexión");

//Conectamos con mysql
$conexion2 = mysql_connect("172.16.3.208", "UsuAppConSal", "197DA72C7FEACUNB0$QU32016");
mysql_select_db("sala", $conexion2);

#Efectuamos la consulta SQL
$result = pg_query ($conexion, "select codigo_unico from participante where codigo_unico<>'' order by codigo_unico" ) or die("Error en la consulta SQL".pg_last_error());
#Mostramos los resultados obtenidos
$i=1;
echo date("d-m-Y H:i:s")."<br>";
while( $row = pg_fetch_array ( $result,$i )) {
	echo $i."-";
	$queEmp="SELECT SUBSTRING_INDEX(eg.apellidosestudiantegeneral,' ',1) AS PRIMER_APELLIDO,
	                SUBSTRING_INDEX(eg.apellidosestudiantegeneral,' ',-1) AS SEGUNDO_APELLIDO,
        	        SUBSTRING_INDEX(eg.nombresestudiantegeneral,' ',1) AS PRIMER_NOMBRE,
                	SUBSTRING_INDEX(eg.nombresestudiantegeneral,' ',-1) AS SEGUNDO_NOMBRE
		FROM estudiantegeneral eg
		WHERE numerodocumento='".$row['codigo_unico']."'";
	$resEmp = mysql_query($queEmp, $conexion2) or die(mysql_error());
	$totEmp = mysql_num_rows($resEmp);
	if ($totEmp> 0) {
		$rowEmp = mysql_fetch_assoc($resEmp); 

		pg_query ($conexion, "	update participante 
					set	 primer_apellido='".sanear_string($rowEmp['PRIMER_APELLIDO'])."'
						,segundo_apellido='".sanear_string($rowEmp['SEGUNDO_APELLIDO'])."'
						,primer_nombre='".sanear_string($rowEmp['PRIMER_NOMBRE'])."'
						,segundo_nombre='".sanear_string($rowEmp['SEGUNDO_NOMBRE'])."'
					where codigo_unico='".$row['codigo_unico']."'" ) or die("Error en la consulta SQL".pg_last_error());
	}
	pg_query ($conexion, "update contador set id=$i"); 
	$i++;
}
echo "<br>".date("d-m-Y H:i:s");

?>
