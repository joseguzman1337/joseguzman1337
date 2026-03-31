<?php
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
// Arregla las materias repetidas de un estudiante, se las quita y deja una. 
require_once('../../../Connections/sala2.php'); 
/*$hostname_sala = "200.31.79.227";
$database_sala = "sala";
$username_sala = "emerson";
$password_sala = "kilo999";
*/
/*
$hostname_sala = "172.16.7.110";
$database_sala = "sala";
$username_sala = "root";
$password_sala = "";
//$sala = mysql_pconnect($hostname_sala, $username_sala, $password_sala) or trigger_error("$database_sala",E_USER_ERROR);
*/
$sala = mysql_pconnect($hostname_sala, $username_sala, $password_sala) or trigger_error(mysql_error(),E_USER_ERROR); mysql_select_db($database_sala, $sala);
session_start();
require_once('../../../funciones/clases/autenticacion/redirect.php' );
//$_SESSION['codigofacultad'] = "700";
//$carrera = $_SESSION['codigofacultad'];
// Sin mirar el grupo
$query_materiasrepetidas = "select g.codigomateria, g.idgrupo, m.nombremateria, c.nombrecarrera, g.maximogrupo, 
g.maximogrupoelectiva, g.matriculadosgrupo, g.matriculadosgrupoelectiva
from grupo g, materia m, carrera c
where g.codigoperiodo = '20062'
and g.maximogrupo < g.matriculadosgrupo + g.matriculadosgrupoelectiva
and g.codigomateria = m.codigomateria
and m.codigocarrera = c.codigocarrera";

// Mirando el grupo
/*$query_materiasrepetidas = "select p.codigoestudiante, p.idprematricula, d.codigomateria, d.idgrupo, count(*) as cuenta, 
d.codigomateriaelectiva, d.codigoestadodetalleprematricula, d.codigotipodetalleprematricula, d.numeroordenpago
from detalleprematricula d, prematricula p
where p.idprematricula = d.idprematricula
and (p.codigoestadoprematricula like '1%' or p.codigoestadoprematricula like '4%')
and (d.codigoestadodetalleprematricula like '1%' or d.codigoestadodetalleprematricula like '3%')
and p.codigoperiodo = '20052'
group by 1,2,3,4
having cuenta > 1
order by d.idprematricula";*/
$materiasrepetidas = mysql_query($query_materiasrepetidas, $sala) or die(mysql_error());
$total_materiasrepetidas = mysql_num_rows($materiasrepetidas);
$cuenta = 1;
?>
<h1 align="center">Listado de Materias con Sobre Cupo </h1>
<table align="center" border="1" width="100%">
  <tr>
	<td><strong>codigomateria</strong></td>
	<td><strong>idgrupo</strong></td>
	<td><strong>nombremateria</strong></td>
	<td><strong>nombrecarrera</strong></td>
	<td><strong>maximogrupo</strong></td>
	<td><strong>maximogrupoelectiva</strong></td>
	<td><strong>matriculadosgrupo</strong></td>
	<td><strong>matriculadoselectiva</strong></td>
	<td><strong>Total</strong></td>
  </tr>
<?php
while($row_materiasrepetidas = mysql_fetch_assoc($materiasrepetidas))
{
	$codigomateria = $row_materiasrepetidas['codigomateria'];
	$idgrupo = $row_materiasrepetidas['idgrupo'];
	$nombremateria = $row_materiasrepetidas['nombremateria'];
	$nombrecarrera = $row_materiasrepetidas['nombrecarrera'];
	$maximogrupo = $row_materiasrepetidas['maximogrupo'];
	$maximogrupoelectiva = $row_materiasrepetidas['maximogrupoelectiva'];
	$matriculadosgrupo = $row_materiasrepetidas['matriculadosgrupo'];
	$matriculadosgrupoelectiva = $row_materiasrepetidas['matriculadosgrupoelectiva'];
	$Total = $matriculadosgrupo + $matriculadosgrupoelectiva;
?>
<tr>
	<td>&nbsp;<?php echo $codigomateria ?></td>
	<td>&nbsp;<?php echo $idgrupo ?></td>
	<td>&nbsp;<?php echo $nombremateria ?></td>
	<td>&nbsp;<?php echo $nombrecarrera ?></td>
	<td>&nbsp;<?php echo $maximogrupo ?></td>
	<td>&nbsp;<?php echo $maximogrupoelectiva ?></td>
	<td>&nbsp;<?php echo $matriculadosgrupo ?></td>
	<td>&nbsp;<?php echo $matriculadosgrupoelectiva ?></td>
	<td>&nbsp;<?php echo $Total ?></td>
  </tr>
<?php
	/*//$eliminarepetida = mysql_query($query_eliminarepetida, $sala) or die(mysql_error());
	$query_insertarmateria = "INSERT INTO detalleprematricula(idprematricula, codigomateria, codigomateriaelectiva, codigoestadodetalleprematricula, codigotipodetalleprematricula, idgrupo, numeroordenpago) 
	VALUES($idprematricula, '$codigomateria', '$codigomateriaelectiva', '$codigoestadodetalleprematricula', '$codigotipodetalleprematricula', '$idgrupo', $numeroordenpago)";
	//$insertarmateria = mysql_query($query_insertarmateria, $sala) or die(mysql_error());
	//echo "<br><br>$codigoestudiante<br>$query_eliminarepetida<br>";
	//echo "$query_insertarmateria";
	$cuenta++;*/
}
//echo "<br>Total : $cuenta";
?>
</table>
