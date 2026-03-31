<?php
    session_start();
    include_once('../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
$nombrearchivo = 'estadocuenta';
if(isset($_REQUEST['formato']))
{
	$formato = $_REQUEST['formato'];
	switch ($formato)
	{
		case 'xls' :
			$strType = 'application/msexcel';
			$strName = $nombrearchivo.".xls";
			break;
		case 'doc' :
			$strType = 'application/msword';
			$strName = $nombrearchivo.".doc";
			break;
		case 'txt' :
			$strType = 'text/plain';
			$strName = $nombrearchivo.".txt";
			break;
		case 'csv' :
			$strType = 'text/plain';
			$strName = $nombrearchivo.".csv";
			break;
		case 'xml' :
			$strType = 'text/plain';
			$strName = $nombrearchivo.".xml";
			break;
		default :
			$strType = 'application/msexcel';
			$strName = $nombrearchivo.".xls";
			break;
	}
	header("Content-Type: $strType");
	header("Content-Disposition: attachment; filename=$strName\r\n\r\n");
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Pragma: public");
}

//session_start();
require_once('../../Connections/sala2.php');
$rutaado = "../../funciones/adodb/";
//$rutazado = "../../../funciones/zadodb/";
require_once('../../Connections/salaado.php'); 
require_once('../../funciones/sala/estudiante/estudiante.php'); 
//$db->debug = true;

?>
<html>
<head>
<title>Resultados encuesta</title>
<?php
if(!isset($_REQUEST['formato']))
{
?>
<link rel="stylesheet" type="text/css" href="../../estilos/sala.css">
<?php
}
?></head>
<body>
<?php
if(!isset($_REQUEST['formato']))
{
?>
<a href="?formato&idestadocuenta=<?php echo $_GET['idestadocuenta']; ?>">Descargar a Excel</a><br><br>
<?php
}
//$_GET['idestadocuenta'] = 1;
// Primero traer los estudiantes que hicieron encuesta
$order = "order by ";
//$db->debug = true;
switch($_GET['order'])
{
	case 'semestre' : 
		$order .= ' e.semestre';
	break;
	case 'nombrecarrera' : 
		$order .= ' c.nombrecarrera';
	break;
	case 'nombre' : 
		$order .= ' nombre';
	break;
	default:
		$order .= ' e.semestre,c.nombrecarrera,nombre';
	break;
}
$query_estudianteestadocuenta = "select e.semestre, c.nombrecarrera, eg.numerodocumento, concat(eg.apellidosestudiantegeneral,' ',nombresestudiantegeneral) as nombre, eec.idestudiantegeneral, eec.idestudianteestadocuenta, e.codigoestudiante
from estudianteestadocuenta eec, estudiante e, estudiantegeneral eg, carrera c
where codigoestado like '1%'
and e.idestudiantegeneral = eg.idestudiantegeneral
and e.codigocarrera = c.codigocarrera
and eg.idestudiantegeneral = eec.idestudiantegeneral
and eec.idestadocuenta = '".$_GET['idestadocuenta']."'
$order";
$estudianteestadocuenta = $db->Execute($query_estudianteestadocuenta);
$totalRows_estudianteestadocuenta = $estudianteestadocuenta->RecordCount();
?>
<table border="1" cellpadding="1" cellspacing="0">
<tr id="trtitulogris">
  <td><?php if(!isset($_REQUEST['formato'])) { ?><a href="?order=semestre"><?php } ?>Semestre<?php if(!isset($_REQUEST['formato'])) { ?></a><?php } ?></td>
  <td><?php if(!isset($_REQUEST['formato'])) { ?><a href="?order=nombrecarrera"><?php } ?>nombre carrera<?php if(!isset($_REQUEST['formato'])) { ?></a><?php } ?></td>
  <td>numero documento</td>
  <td><?php if(!isset($_REQUEST['formato'])) { ?><a href="?order=nombre"><?php } ?>nombre<?php if(!isset($_REQUEST['formato'])) { ?></a><?php } ?></td>
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
/*// # de respuestas de la encuesta
$query_respuestas = "select idrespuesta
from respuesta
order by 1";
$respuestas = $db->Execute($query_respuestas);
$totalRows_estudiantesencuesta = $respuestas->RecordCount();
$cuentarespuestas = 0;
while($row_respuestas = $respuestas->FetchRow()) :
	$cuentarespuestas++;*/
	$cuentarespuestas = 1;
?>
  <td><?php echo //$cuentarespuestas; ?>Está de acuerdo</td>
  <td>Observación</td>
<?php
//endwhile;
?>
</tr>
<?php
while($row_estudianteestadocuenta = $estudianteestadocuenta->FetchRow()) :
	$estudiante = new estudiante($row_estudianteestadocuenta['codigoestudiante']);
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
	$query_respuestasestudiante = "SELECT idestudianteestadocuenta, idestadocuenta, idestudiantegeneral, respuestaestudianteestadocuenta, fechaestudianteestadocuenta, observacionestudianteestadocuenta, codigoestado 
    FROM estudianteestadocuenta
	where idestudianteestadocuenta = '".$row_estudianteestadocuenta['idestudianteestadocuenta']."'
	order by 1";
	$respuestasestudiante = $db->Execute($query_respuestasestudiante);
	$totalRows_respuestasestudiante = $respuestasestudiante->RecordCount();
	while($row_respuestasestudiante = $respuestasestudiante->FetchRow()) :
?>
<td>
<?php
		if($row_respuestasestudiante['respuestaestudianteestadocuenta'] == 0)
			echo "NO";
		else if($row_respuestasestudiante['respuestaestudianteestadocuenta'] == 1)
			echo "SI";
		else
			echo "C";
?>
</td>
<td>
<?php echo $row_respuestasestudiante['observacionestudianteestadocuenta'] ?>
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
