<?php
function datosestudiante($codigoestudiante,$sala,$database_sala,$link)
{
//require_once('../Connections/sala2.php' );
//mysql_select_db($database_sala, $sala);
$sinprematricula = false;
//$codigoestudiante = $_SESSION['codigo'];
//$codigoestudiante = 9344;
$query_seldocumentos = "select ed.numerodocumento, ed.fechainicioestudiantedocumento, ed.fechavencimientoestudiantedocumento, u.linkidubicacionimagen
from estudiantedocumento ed, estudiante e, ubicacionimagen u
where ed.idestudiantegeneral = e.idestudiantegeneral
and e.codigoestudiante = '$codigoestudiante'
and u.idubicacionimagen like '1%'
and u.codigoestado like '1%'
order by 2 desc";
$seldocumentos = mysql_query($query_seldocumentos, $sala) or die("error $query_seldocumentos ".mysql_error($sala));
$totalRows_seldocumentos = mysql_num_rows($seldocumentos);
while($row_seldocumentos = mysql_fetch_assoc($seldocumentos)){

	$imagenjpg = $row_seldocumentos['numerodocumento'].".jpg";
	$imagenJPG = $row_seldocumentos['numerodocumento'].".JPG";
	/*if(@imagecreatefromjpeg($link.$imagenjpg))
	{
		$linkimagen = $link.$imagenjpg;
		break;
	}
	else if(@imagecreatefromjpeg($link.$imagenJPG))
	{
		$linkimagen = $link.$imagenJPG;
		break;
	}*/
    if(is_file($link.$imagenjpg))
    {
        $linkimagen = $link.$imagenjpg;
        break;
    }
    else if(is_file($link.$imagenJPG))
    {
        $linkimagen = $link.$imagenJPG;
        break;
    }
}

$cuentaconplandeestudio = true;
$query_selplan = "select p.idplanestudio, p.nombreplanestudio
from planestudioestudiante pe, planestudio p
where pe.idplanestudio = p.idplanestudio
and pe.codigoestudiante = '$codigoestudiante'
and pe.codigoestadoplanestudioestudiante like '1%'
and p.codigoestadoplanestudio like '1%'";
$selplan = mysql_db_query($database_sala,$query_selplan) or die("$query_selplan");
$totalRows_selplan = mysql_num_rows($selplan);
if($totalRows_selplan != "")
{
	$row_selplan=mysql_fetch_array($selplan);
	$idplan = $row_selplan['idplanestudio'];
	$nombreplan = $row_selplan['nombreplanestudio'];
}
else
{
	$cuentaconplandeestudio = false;
	$idplan = "0";
	$nombreplan = "Sin Asignar";
	// Verifica si la carrera necesita plan de estudio
	$query_datocarreraplan = "select c.codigoindicadorplanestudio
	from carrera c, estudiante e
	where e.codigocarrera = c.codigocarrera
	and e.codigoestudiante = '$codigoestudiante'";
	//echo "$query_datocohorte<br>";
	$datocarreraplan = mysql_db_query($database_sala,$query_datocarreraplan) or die("$query_datocarreraplan".mysql_error());
	$totalRows_datocarreraplan = mysql_num_rows($datocarreraplan);
	$row_datocarreraplan = mysql_fetch_array($datocarreraplan);
	// Mira si la carrera requiere o no requiere plan de estudio
}
  $sinprematricula = true;
	$query_dataestudiante = "select c.codigocarrera, c.nombrecarrera, concat(eg.apellidosestudiantegeneral,' ',eg.nombresestudiantegeneral) as nombre, c.codigocarrera,
	eg.numerodocumento, eg.fechanacimientoestudiantegeneral, eg.expedidodocumento, e.codigojornada, e.semestre,
	e.numerocohorte, e.codigotipoestudiante, t.nombretipoestudiante, e.codigosituacioncarreraestudiante,
	s.nombresituacioncarreraestudiante, eg.celularestudiantegeneral, eg.emailestudiantegeneral, eg.codigogenero,
	eg.direccionresidenciaestudiantegeneral, eg.telefonoresidenciaestudiantegeneral, eg.ciudadresidenciaestudiantegeneral,
	eg.direccioncorrespondenciaestudiantegeneral, eg.telefonocorrespondenciaestudiantegeneral, eg.ciudadcorrespondenciaestudiantegeneral
	from estudiante e, carrera c, tipoestudiante t, situacioncarreraestudiante s, estudiantegeneral eg
	where e.codigocarrera = c.codigocarrera
	and e.codigotipoestudiante = t.codigotipoestudiante
	and e.codigosituacioncarreraestudiante = s.codigosituacioncarreraestudiante
	and e.codigoestudiante = '$codigoestudiante'
	and e.idestudiantegeneral = eg.idestudiantegeneral";
	//echo $query_dataestudiante;
	$dataestudiante = mysql_query($query_dataestudiante, $sala) or die("$query_dataestudiante".mysql_error());
	$totalRows_dataestudiante = mysql_num_rows($dataestudiante);
	$row_dataestudiante = mysql_fetch_assoc($dataestudiante);
?>
<p>DATOS  GENERALES ESTUDIANTE</p>
<table width="750" border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9">
    <tr id="trtitulogris">
      <td>Documento</td>
      <td colspan="2">Nombre Estudiante</td>
      <td colspan="0" rowspan="6" align="center"><img src="<?php echo $linkimagen; ?>" width="80" height="120"></td>
    </tr>
    <tr>
      <td><div><?php echo $row_dataestudiante['numerodocumento'];?></div></td>
      <td colspan="2"><div><?php echo $row_dataestudiante['nombre'];?></div></td>
  </tr>
    <tr id="trtitulogris">
      <td colspan="1">No. Plan de Estudio</td>
	  <td colspan="1">Nombre Del Plan de Estudio</td>
	  <td colspan="1">Semestre</td>
  </tr>
    <tr>
      <td colspan="1"><?php echo $idplan;?></td>
	  <td colspan="1"><?php echo $nombreplan;?></td>
	  <td colspan="1"><?php echo $row_dataestudiante['semestre'];?></td>
  </tr>
    <tr id="trtitulogris">
      <td>Carrera</td>
      <td colspan="1">Situación</td>
	  <td>Fecha</td>
    </tr>
    <tr>
      <td><?php echo $row_dataestudiante['nombrecarrera'];?></td>
      <td><?php echo $row_dataestudiante['nombresituacioncarreraestudiante'];?></td>
      <td><?php echo date("Y-m-d H:i:s");?></td>
    </tr>
</table>
<?php
  } //fin funcion

function obtenerIdestudiantegeneral($codigoestudiante,$sala,$database_sala)
{
    $query = "select e.idestudiantegeneral
    from estudiante e
    where e.codigoestudiante = '$codigoestudiante'";
    $sel = mysql_db_query($database_sala,$query) or die("$query");
    $totalRows_sel = mysql_num_rows($sel);
    if($totalRows_sel != "")
    {
        $row_sel=mysql_fetch_array($sel);
        return $row_sel['idestudiantegeneral'];
    }
    return false;
}
?>
