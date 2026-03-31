<?php
    session_start();
    include_once('../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
require_once('../../Connections/sala2.php'); 
//sql = "LOAD DATA LOCAL INFILE 'C:/wamp/tmp/modificamatriculado.txt' INTO TABLE tmp_modificamatriculado";
mysql_select_db($database_sala, $sala);
$sql = "LOAD DATA LOCAL INFILE '/var/tmp/modificamatriculado.txt' INTO TABLE tmp_modificamatriculado";	
$result = mysql_query($sql,$sala) or die("$sql");
echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=modificarmatriculado.php'>";
?>

