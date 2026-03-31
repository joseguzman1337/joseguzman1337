<?php
session_start();
include_once('../../utilidades/ValidarSesion.php'); 
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION);

//session_start();
require_once('../../Connections/sala2.php');
$rutaado = "../../funciones/adodb/";
//$rutazado = "../../../funciones/zadodb/";
require_once('../../Connections/salaado.php'); 
require_once('../../funciones/sala/estudiante/estudiante.php'); 


?>
<html>
<head>
<title>Resultados encuesta</title>
<link rel="stylesheet" type="text/css" href="../../estilos/sala.css">
</head>
<body>
<?php
// Primero traer los estudiantes que hicieron encuesta
$query_estudiantesencuesta = "select e.semestre, c.nombrecarrera, eg.numerodocumento, concat(eg.apellidosestudiantegeneral,' ',nombresestudiantegeneral) as nombre, de.codigoestudiante, de.iddetalleencuesta 
from detalleencuesta de, estudiante e, estudiantegeneral eg, carrera c
where codigoestado like '1%'
and e.codigoestudiante = de.codigoestudiante
and e.idestudiantegeneral = eg.idestudiantegeneral
and e.codigocarrera = c.codigocarrera
order by e.semestre,c.nombrecarrera,nombre";
$estudiantesencuesta = $db->Execute($query_estudiantesencuesta);
$totalRows_estudiantesencuesta = $estudiantesencuesta->RecordCount();
?>
<table border="1" cellpadding="1" cellspacing="0">
<tr id="trtitulogris">
  <td>Semestre</td>
  <td>nombre carrera</td>
  <td>numero documento</td>
  <td>nombre</td>
  <td>direccion</td>
  <td>direccion correspondencia</td>
  <td>teléfono</td>

  <td>celular</td>
  <td>email</td>
  <td>email 2</td>
  <td>estado civil</td>
  <td>fecha nacimiento</td>
  <td>edad</td>

  <td>genero</td>
  <td>ciudad nacimiento</td>
  <td>periodo ingreso</td>
  <td>jornada</td>
  <td>tipo estudiante</td>
  <td>situacion carrera estudiante</td>

  <td>semestre</td>
  <td>Estrato</td>
<?php
// # de respuestas de la encuesta
$query_respuestas = "select idrespuesta
from respuesta
order by 1";
$respuestas = $db->Execute($query_respuestas);
$totalRows_estudiantesencuesta = $respuestas->RecordCount();
$cuentarespuestas = 0;
while($row_respuestas = $respuestas->FetchRow()) :
	$cuentarespuestas++;
?>
  <td><?php echo $cuentarespuestas; ?></td>
<?php
endwhile;
?>
</tr>
<?php
while($row_estudiantesencuesta = $estudiantesencuesta->FetchRow()) :
	$estudiante = new estudiante($row_estudiantesencuesta['codigoestudiante']);
?>
<tr>
  <td><?php echo $estudiante->semestre ?></td>
  <td><?php echo $estudiante->getNombrecarrera() ?></td>
  <td><?php echo $estudiante->numerodocumento ?></td>
  <td><?php echo "$estudiante->apellidosestudiantegeneral $estudiante->nombresestudiantegeneral"; ?></td>
  <td><?php echo $estudiante->direccionresidenciaestudiantegeneral ?></td>
  <td><?php echo $estudiante->direccioncorrespondenciaestudiantegeneral ?></td>
  <td><?php echo $estudiante->telefonoresidenciaestudiantegeneral ?></td>

  <td><?php echo $estudiante->celularestudiantegeneral ?></td>
  <td><?php echo $estudiante->emailestudiantegeneral ?></td>
  <td><?php echo $estudiante->email2estudiantegeneral ?></td>
  <td><?php echo $estudiante->getEstadocivil() ?></td>
  <td><?php echo $estudiante->fechanacimientoestudiantegeneral ?></td>
  <td><?php echo $estudiante->getEdad() ?></td>

  <td><?php echo $estudiante->getGenero() ?></td>
  <td><?php echo $estudiante->getCiudadnacimiento() ?></td>
  <td><?php echo $estudiante->codigoperiodo ?></td>
  <td><?php echo $estudiante->getJornada() ?></td>
  <td><?php echo $estudiante->getTipoestudiante() ?></td>
  <td><?php echo $estudiante->getSituacioncarreraestudiante() ?></td>

  <td><?php echo $estudiante->semestreprematricula ?></td>
  <td><?php echo $estudiante->getEstrato() ?></td>
<?php
	// Respuestas de cada estudiante
	//$db->debug = true;
	$query_respuestasestudiante = "select idrespuesta, valorrespuetasencuesta
	from respuestasencuesta
	where iddetalleencuesta = '".$row_estudiantesencuesta['iddetalleencuesta']."'
	order by 1";
	$respuestasestudiante = $db->Execute($query_respuestasestudiante);
	$totalRows_respuestasestudiante = $respuestasestudiante->RecordCount();
	while($row_respuestasestudiante = $respuestasestudiante->FetchRow()) :
?>
<td>
<?php
		if($row_respuestasestudiante['valorrespuetasencuesta'] == 0)
			echo "B";
		else if($row_respuestasestudiante['valorrespuetasencuesta'] == 1)
			echo "A";
		else
			echo "C";
?>
</td>
<?php
	endwhile;
?>
</tr>
<?php
endwhile;
?>
</table>
</body>
</html>
