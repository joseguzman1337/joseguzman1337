<?php
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
// Arregla las materias repetidas de un estudiante, se las quita y deja una. 
require_once('../../../Connections/sala2.php'); 
/*$hostname_sala = "172.16.7.109";
$database_sala = "sala";
$username_sala = "root";
$password_sala = "";*/
//$sala = mysql_pconnect($hostname_sala, $username_sala, $password_sala) or trigger_error("$database_sala",E_USER_ERROR);
$sala = mysql_pconnect($hostname_sala, $username_sala, $password_sala) or trigger_error(mysql_error(),E_USER_ERROR); mysql_select_db($database_sala, $sala);
//session_start();
require_once('../../../funciones/clases/autenticacion/redirect.php' ); 
if(!isset($_GET['codigocarrera']) || !isset($_GET['codigocarrera']) || !isset($_GET['codigocarrera']))
{
?>
<strong>Debe pasar por el get ?codigocarrera=123&codigoperiodoini=20061&codigoperiodovigente=20062</strong>
<?php
}
//$_SESSION['codigofacultad'] = "700";
//$carrera = $_SESSION['codigofacultad'];
// Sin mirar el grupo
$codigocarrera = $_GET['codigocarrera'];
$codigoperiodoini = $_GET['codigoperiodoini'];
$query_grupos = "SELECT g.idgrupo, g.codigogrupo, g.nombregrupo, g.codigomateria, g.codigoperiodo, g.numerodocumento, g.maximogrupo, 
g.matriculadosgrupoelectiva, g.maximogrupoelectiva, g.matriculadosgrupoelectiva, g.codigoestadogrupo, g.codigoindicadorhorario, 
g.fechainiciogrupo, g.fechafinalgrupo, g.numerodiasconservagrupo 
FROM grupo g, materia m
WHERE g.codigoperiodo = '$codigoperiodoini'
and m.codigomateria = g.codigomateria
and m.codigocarrera = '$codigocarrera'";
$grupos = mysql_query($query_grupos, $sala) or die(mysql_error());
$total_grupos = mysql_num_rows($grupos);
while($row_grupos = mysql_fetch_assoc($grupos))
{
	
	$query_insgrupos = "INSERT INTO grupo(idgrupo, codigogrupo, nombregrupo, codigomateria, codigoperiodo, numerodocumento, maximogrupo, matriculadosgrupo, maximogrupoelectiva, matriculadosgrupoelectiva, codigoestadogrupo, codigoindicadorhorario, fechainiciogrupo, fechafinalgrupo, numerodiasconservagrupo) 
	VALUES(0, '".$row_grupos['codigogrupo']."', '".$row_grupos['nombregrupo']."', '".$row_grupos['codigomateria']."', '$codigoperiodovigente', '".$row_grupos['numerodocumento']."', '".$row_grupos['maximogrupo']."', '0', '".$row_grupos['maximogrupoelectiva']."', '".$row_grupos['matriculadosgrupoelectiva']."', '".$row_grupos['codigoestadogrupo']."', '".$row_grupos['codigoindicadorhorario']."', '2006-06-01', '2006-12-31', '".$row_grupos['numerodiasconservagrupo']."')";
	echo "<br><br>$query_insgrupos<br>";
	$insgrupos = mysql_query($query_insgrupos, $sala);// or die(mysql_error());
	$idgrupo = mysql_insert_id();
	
	$query_horarios = "SELECT h.idgrupo, h.codigodia, h.horainicial, h.horafinal, h.codigotiposalon, h.codigosalon 
	FROM horario h
	where h.idgrupo = '".$row_grupos['idgrupo']."'";
	$horarios = mysql_query($query_horarios, $sala) or die(mysql_error());
	$total_horarios = mysql_num_rows($horarios);
	while($row_horarios = mysql_fetch_assoc($horarios))
	{
		$query_inshorarios = "INSERT INTO horario(idhorario, idgrupo, codigodia, horainicial, horafinal, codigotiposalon, codigosalon, codigoestado) 
    	VALUES(0,$idgrupo, '".$row_horarios['codigodia']."', '".$row_horarios['horainicial']."', '".$row_horarios['horafinal']."', '".$row_horarios['codigotiposalon']."', '1', '100')";
		echo "<br>$query_inshorarios";
		$inshorarios = mysql_query($query_inshorarios, $sala); //or die(mysql_error());
	}
	$cuenta++;
}
/*echo "<br>Total : $cuenta";
$query_inshorarios = "UPDATE horario
SET codigosalon = '1'
WHERE idgrupo >= '5688'";
//echo "<br>$query_inshorarios";
$inshorarios = mysql_query($query_inshorarios, $sala) or die(mysql_error());
*/
?>
