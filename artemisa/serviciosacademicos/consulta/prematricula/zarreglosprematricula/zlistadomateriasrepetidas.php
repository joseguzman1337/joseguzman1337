<?php
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
// Arregla las materias repetidas de un estudiante, se las quita y deja una. 
require_once('../../../Connections/sala2.php'); 
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
$query_materiasrepetidas = "select p.codigoestudiante, p.idprematricula, d.codigomateria, d.idgrupo, count(*) as cuenta, 
d.codigomateriaelectiva, d.codigoestadodetalleprematricula, d.codigotipodetalleprematricula, d.numeroordenpago,
eg.numerodocumento, c.nombrecarrera
from detalleprematricula d, prematricula p, estudiante e, estudiantegeneral eg, carrera c
where p.idprematricula = d.idprematricula
and (p.codigoestadoprematricula like '1%' or p.codigoestadoprematricula like '4%')
and (d.codigoestadodetalleprematricula like '1%' or d.codigoestadodetalleprematricula like '3%')
and p.codigoperiodo >= '20062'
and e.codigoestudiante = p.codigoestudiante
and eg.idestudiantegeneral = e.idestudiantegeneral
and e.codigocarrera = c.codigocarrera
group by 1,2,3
having cuenta > 1
order by d.idprematricula";

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
<h1 align="center">Listado de Materias Repetidas</h1>
<table align="center" border="1" width="100%">
  <tr>
	<td><strong>estudiante</strong></td>
	<td><strong>prematricula</strong></td>
	<td><strong>materia</strong></td>
	<td><strong>materiaelectiva</strong></td>
	<td><strong>documento</strong></td>
	<td><strong>carrera</strong></td>
	<td><strong>grupo</strong></td>
	<td><strong>ordenpago</strong></td>
	<td><strong>cuenta</strong></td>
  </tr>
<?php
while($row_materiasrepetidas = mysql_fetch_assoc($materiasrepetidas))
{
	$codigoestudiante = $row_materiasrepetidas['codigoestudiante'];
	$numerodocumento = $row_materiasrepetidas['numerodocumento'];
	$nombrecarrera = $row_materiasrepetidas['nombrecarrera'];
	$idprematricula = $row_materiasrepetidas['idprematricula'];
	$codigomateria = $row_materiasrepetidas['codigomateria'];
	$codigomateriaelectiva = $row_materiasrepetidas['codigomateriaelectiva'];
	$codigoestadodetalleprematricula = $row_materiasrepetidas['codigoestadodetalleprematricula'];
	$codigotipodetalleprematricula = $row_materiasrepetidas['codigotipodetalleprematricula'];
	$idgrupo = $row_materiasrepetidas['idgrupo'];
	$numeroordenpago = $row_materiasrepetidas['numeroordenpago'];
	$cuenta = $row_materiasrepetidas['cuenta'];
	
	// Sin mirar el grupo
	/*$query_eliminarepetida = "DELETE FROM detalleprematricula 
	WHERE idprematricula = '$idprematricula' 
	and codigoestadodetalleprematricula = '$codigoestadodetalleprematricula'
	and codigomateria = '$codigomateria' 
	and codigomateriaelectiva = '$codigomateriaelectiva'
	and codigotipodetalleprematricula = '$codigotipodetalleprematricula'
	and numeroordenpago = '$numeroordenpago'";
	*/
	// Mirando el grupo
	/*$query_eliminarepetida = "DELETE FROM detalleprematricula 
	WHERE idprematricula = '$idprematricula' 
	and codigoestadodetalleprematricula = '$codigoestadodetalleprematricula'
	and idgrupo = '$idgrupo'
	and codigomateria = '$codigomateria' 
	and codigomateriaelectiva = '$codigomateriaelectiva'
	and codigotipodetalleprematricula = '$codigotipodetalleprematricula'
	and numeroordenpago = '$numeroordenpago'";*/
	// and codigotipodetalleprematricula = '$codigotipodetalleprematricula'
?>
<tr>
	<td>&nbsp;<?php echo $codigoestudiante ?></td>
	<td>&nbsp;<?php echo $idprematricula ?></td>
	<td>&nbsp;<?php echo $codigomateria ?></td>
	<td>&nbsp;<?php echo $codigomateriaelectiva ?></td>
	<td>&nbsp;<?php echo $numerodocumento ?></td>
	<td>&nbsp;<?php echo $nombrecarrera ?></td>
	<td>&nbsp;<a href="zquitarmateriainscrita.php?prematricula=<?php echo "$idprematricula&materia=$codigomateria&grupo=$idgrupo&listado" ?>"><?php echo $idgrupo ?></a></td>
	<td>&nbsp;<?php echo $numeroordenpago ?></td>
	<td>&nbsp;<?php echo $cuenta ?></td>
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
$query_inscripciones4 = "select count(idprematricula) as cuenta
from prematricula
where codigoperiodo = '20062'
and (codigoestadoprematricula like '1%' or codigoestadoprematricula like '4%')";
$inscripciones4 = mysql_query($query_inscripciones4, $sala) or die("$query_inscripciones".mysql_error());
$total_inscripciones4 = mysql_num_rows($inscripciones4);
$row_inscripciones4 = mysql_fetch_assoc($inscripciones4);

$query_inscripciones = "select count(idprematricula) as cuenta
from prematricula
where codigoperiodo = '20061'
and (codigoestadoprematricula like '1%' or codigoestadoprematricula like '4%')";
$inscripciones = mysql_query($query_inscripciones, $sala) or die("$query_inscripciones".mysql_error());
$total_inscripciones = mysql_num_rows($inscripciones);
$row_inscripciones = mysql_fetch_assoc($inscripciones);

$query_inscripciones2 = "select count(idprematricula) as cuenta
from prematricula
where codigoperiodo = '20052'
and (codigoestadoprematricula like '1%' or codigoestadoprematricula like '4%')";
$inscripciones2 = mysql_query($query_inscripciones2, $sala) or die("$query_inscripciones2".mysql_error());
$total_inscripciones2 = mysql_num_rows($inscripciones2);
$row_inscripciones2 = mysql_fetch_assoc($inscripciones2);

$query_inscripciones3 = "select count(idprematricula) as cuenta
from prematricula
where codigoperiodo = '20051'
and (codigoestadoprematricula like '1%' or codigoestadoprematricula like '4%')";
$inscripciones3 = mysql_query($query_inscripciones3, $sala) or die("$query_inscripciones3".mysql_error());
$total_inscripciones3 = mysql_num_rows($inscripciones3);
$row_inscripciones3 = mysql_fetch_assoc($inscripciones3);
?>
<tr>
<td colspan="5" align="center"><strong>Numero de inscripciones 2006-2:</strong></td>
<td align="center" colspan="4"><?php echo $row_inscripciones4['cuenta'];  ?></td>
</tr>
<tr>
<td colspan="5" align="center"><strong>Numero de inscripciones 2006-1:</strong></td>
<td align="center" colspan="4"><?php echo $row_inscripciones['cuenta'];  ?></td>
</tr>
<tr>
<td colspan="5" align="center"><strong>Numero de inscripciones 2005-2:</strong></td>
<td align="center" colspan="4"><?php echo $row_inscripciones2['cuenta'];  ?></td>
</tr>
<tr>
<td colspan="5" align="center"><strong>Numero de inscripciones 2005-1:</strong></td>
<td align="center" colspan="4"><?php echo $row_inscripciones3['cuenta'];  ?></td>
</tr>
</table>
