<?php //require_once('../../../Connections/sala2.php'); 

$hostname_sala = "200.31.79.227";
$database_sala = "sala";
$username_sala = "emerson";
$password_sala = "kilo999";
$sala = mysql_pconnect($hostname_sala, $username_sala, $password_sala) or trigger_error(mysql_error(),E_USER_ERROR); 

//sql = "LOAD DATA LOCAL INFILE 'C:/wamp/tmp/modificamatriculado.txt' INTO TABLE tmp_modificamatriculado";

mysql_select_db($database_sala, $sala);

$sql = "LOAD DATA LOCAL INFILE '/var/tmp/modificamatriculado.txt' INTO TABLE tmp_modificamatriculado";	

$result = mysql_query($sql,$sala) or die("$sql");

echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=modificarmatriculado.php'>";

?>

