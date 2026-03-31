<?php
$nombrearchivo = 'archivo'.$_GET['idgrupo1'];
if(isset($_REQUEST['descargar']))
{
	$formato = 'xls';
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

$rutaado=("../../../funciones/adodb/");
require_once('../../../Connections/sala2.php'); 
require_once('../../../Connections/salaado.php'); 
mysql_select_db($database_sala, $sala);
session_start();
if(!isset($_REQUEST['descargar']))
{
?>
	<link rel="stylesheet" type="text/css" href="../../../estilos/sala.css">
	<form name="f1" method="get" action="">
		<input type="hidden" name="idgrupo1" value="<?php echo $_REQUEST['idgrupo1']; ?>">
		<input type="submit" name="descargar" value="Descargar">
	</form>
<?php
}
//print_r($_GET);
$array_dias = array(
array("dia" => "Lunes"), 
array("dia" => "Martes"), 
array("dia" => "Miercoles"), 
array("dia" => "Jueves"), 
array("dia" => "Viernes"), 
array("dia" => "Sabado"), 
array("dia" => "Domingo")
);
$array_rango_horas = array(
array("hora_ini" => "07:00:00", "hora_fin" => "08:00:00"), 
array("hora_ini" => "08:00:00", "hora_fin" => "09:00:00"), 
array("hora_ini" => "09:00:00", "hora_fin" => "10:00:00"), 
array("hora_ini" => "10:00:00", "hora_fin" => "11:00:00"), 
array("hora_ini" => "11:00:00", "hora_fin" => "12:00:00"), 
array("hora_ini" => "12:00:00", "hora_fin" => "13:00:00"), 
array("hora_ini" => "13:00:00", "hora_fin" => "14:00:00"), 
array("hora_ini" => "14:00:00", "hora_fin" => "15:00:00"), 
array("hora_ini" => "15:00:00", "hora_fin" => "16:00:00"), 
array("hora_ini" => "16:00:00", "hora_fin" => "17:00:00"), 
array("hora_ini" => "17:00:00", "hora_fin" => "18:00:00"), 
array("hora_ini" => "18:00:00", "hora_fin" => "19:00:00"), 
array("hora_ini" => "19:00:00", "hora_fin" => "20:00:00"), 
array("hora_ini" => "20:00:00", "hora_fin" => "21:00:00"), 
array("hora_ini" => "21:00:00", "hora_fin" => "22:00:00"), 
);
//$db->debug = true;
function obtenerHorario($idgrupo, $codigodia, $horaini, $horafin)
{
    global $db;
    $query_horario = "select h.codigosalon, m.nombremateria, m.codigomateria, c.nombrecarrera, d.apellidodocente, d.nombredocente, cc.nombrecarreracolorhorario
    from horario h, materia m, grupo g, docente d, carrera c
    left join carreracolorhorario cc on cc.codigocarrera = c.codigocarrera
    and cc.codigoestado like '1%'
    where h.idgrupo = $idgrupo
    and h.codigodia = $codigodia
    and ('$horaini' between h.horainicial and h.horafinal and '$horafin' between h.horainicial and h.horafinal)
    and g.idgrupo = h.idgrupo
    and m.codigomateria = g.codigomateria
    and h.codigoestado like '1%'
    and g.numerodocumento = d.numerodocumento
    and c.codigocarrera = m.codigocarrera";
    $horario = $db->Execute($query_horario);
    $totalRows_horario = $horario->RecordCount();
    $row_horario = $horario->FetchRow();
    return $row_horario;
}
?>
<h3 align="center">Horario</h3>
<table border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9" width="100%">
<tr>
	<td align="center">Hora Ini</td>
	<td align="center">Hora Fin</td>
	<?php foreach ($array_dias as $llave_d => $valor_d){?>
	<td align="center" width="180"><?php echo $valor_d['dia']; ?></td>
	<?php }?>
</tr>
<?php foreach ($array_rango_horas as $llave_h => $valor_h){?>
<tr>
	<td align="center" height="30"><?php echo $valor_h['hora_ini']?></td>
	<td align="center"><?php echo $valor_h['hora_fin']?></td>
	<?php 
	$codigodia = 1;
	foreach ($array_dias as $llave_d => $valor_d){
		$horario = obtenerHorario($_REQUEST['idgrupo1'], $codigodia, $valor_h['hora_ini'], $valor_h['hora_fin']);
		$codigodia++;
		$colorHorario = $horario['nombrecarreracolorhorario'];
		?>
		<td align="center" bgcolor="<?php echo $colorHorario?>"><?php if($horario['codigosalon'] != '')
		{
			echo $horario['nombremateria']," ","(",$horario['codigomateria'],")";
			//echo "<br>";
			//echo $horario['nombrecarrera'];
			echo $horario['nombredocente']," ",$horario['apellidodocente'];
		}
		else
		{
			echo "&nbsp;";
		}?></td>
	<?php }?>
</tr>
<?php } ?>
</table>
<?php 
if(isset($_REQUEST['descargar']))
{
    echo "<script language='javascript'>
	/*window.opener.recargar('".$dirini."#".$grupo."');
	window.opener.focus();*/
	window.close();
	</script>";
}
?>
