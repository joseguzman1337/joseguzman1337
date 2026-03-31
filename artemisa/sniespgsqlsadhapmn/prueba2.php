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
	$string = str_replace( array('ñ', 'Ñ', 'ç', 'Ç', '¥', 'ï¾¥', 'Ã“', 'Ã‘', 'Ã±', 'Ã³', 'Ã©', 'Ãš', 'Ã‰'), array('n', 'N', 'c', 'C', 'N', 'N', 'O', 'N', 'N', 'O', 'E', 'U' ,'E'), $string);
	$string = str_replace( array("\\", "¨", "º", "-", "~","#", "@", "|", "!", "\"","·", "$", "%", "&", "/","(", ")", "?", "'", "¡","¿", "[", "^", "`", "]","+", "}", "{", "¨", "´",">", "<", ";", ",", ":",".", " "),'',$string);
 
	return $string;
}
		
//Conectamos con PostgreSQL
$conexion = pg_connect("host=snies.unbosque.edu.co dbname=odsbosque user=postgres password=") or die ("Fallo en el establecimiento de la conexión");

//Conectamos con mysql
$conexion2 = mysql_connect("172.16.3.208", "UsuAppConSal", "197DA72C7FEACUNB0$QU32016");
mysql_select_db("sala", $conexion2);

#Efectuamos la consulta SQL
$result = pg_query ($conexion, "select * from participante WHERE primer_apellido like '%$%' or segundo_apellido like '%$%' or primer_nombre like '%$%' or segundo_nombre like '%$%'" ) or die("Error en la consulta SQL".pg_last_error());
#Mostramos los resultados obtenidos
$i=0;
while( $row = pg_fetch_array ( $result,$i )) {
	echo "update participantes set primer_apellido='".$row['primer_apellido']."',segundo_apellido='".$row['segundo_apellido']."',primer_nombre='".$row['primer_nombre']."',segundo_nombre='".$row['segundo_nombre']."' where codigo_unico='".$row['codigo_unico']."';<br>";
	$i++;
}
echo $i;

?>
