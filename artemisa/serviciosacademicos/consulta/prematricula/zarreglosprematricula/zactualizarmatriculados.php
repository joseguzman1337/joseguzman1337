<?php
require_once('../../../Connections/sala2.php' );
require_once('../../../funciones/clases/autenticacion/redirect.php' ); 
$sala = mysql_pconnect($hostname_sala, $username_sala, $password_sala) or trigger_error(mysql_error(),E_USER_ERROR); 
mysql_select_db($database_sala, $sala);
session_start();
require_once('actualizarmatriculados.php');
$query_grupos= "SELECT idgrupo FROM grupo
WHERE codigoperiodo = '20062'
AND codigoestadogrupo LIKE '1%'";
$grupos=mysql_db_query($database_sala,$query_grupos);
$totalRows_grupos = mysql_num_rows($grupos);
$cuenta = 0;
while($row_grupos=mysql_fetch_array($grupos))
{
	$cuenta++;
	$idgrupo = $row_grupos['idgrupo'];
	actualizarmatriculados($idgrupo, 20062, $codigocarrera, $sala);
	//echo $numeroordenpago."<br>";
} 
echo "<br>TOTAL : $cuenta";
?>