<?php
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
session_start();
 if(!isset ($_SESSION['MM_Username'])){

echo "No tiene permiso para acceder a esta opción";
exit();
}

require_once('../../../Connections/sala2.php' );
require_once('../registro_graduados/carta_egresados/functionsElectivasPendientes.php');
mysql_select_db($database_sala, $sala);

$colspan=(isset($_REQUEST["solomaterias"]))?"5":"7";

?>
<html>
<head>
<title>Electivas del estudiante</title>
<script type="text/javascript" src="../../../funciones/sala/js/overlib/overlib.js"></script>
</head>
<link rel="stylesheet" href="../../../estilos/sala.css" type="text/css">
<body>
<table border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9" width="750" align="center">
<tr>
	<td id="tdtitulogris" colspan='<?php echo $colspan?>'>ELECTIVAS</td>
</tr>
<tr>
	<td id="tdtitulogris" align="center">C&oacute;digo</td>
	<td id="tdtitulogris" align="center">Asignatura</td>
	<td id="tdtitulogris" align="center">Periodo</td>
	<td id="tdtitulogris" align="center">Nota</td>
	<td id="tdtitulogris" align="center">Cr&eacute;ditos</td>
<?php
	if(!isset($_REQUEST["solomaterias"])) {
?>
		<td id="tdtitulogris" align="center">Syllabus</td>
		<td id="tdtitulogris" align="center">Contenido program&aacute;tico</td>
<?php
	}
?>
</tr>
<?php
/*$query="select m.codigomateria
		,m.nombremateria
		,nh.codigoperiodo
		,nh.notadefinitiva
		,cp.urlaarchivofinalcontenidoprogramatico
		,cp.urlasyllabuscontenidoprogramatico
                ,cp.idcontenidoprogramatico
                
	from tipomateria tp
	join materia m on tp.codigotipomateria=m.codigotipomateria
	join notahistorico nh on m.codigomateria=nh.codigomateria
	left join contenidoprogramatico cp on m.codigomateria=cp.codigomateria 
        AND cp.codigoperiodo=nh.codigoperiodo AND cp.codigoestado=100 
	where (m.codigotipomateria=4 or m.codigotipomateria=5)
		and nh.codigoestudiante=".$_REQUEST['cod_estudiante']." and nh.codigoestadonotahistorico like '1%'";*/


$query = getQueryMateriasElectivasCPEstudiante($_REQUEST['cod_estudiante']);
//echo $query; die;
$materias = mysql_query($query, $sala) or die(mysql_error());
$totalRows = mysql_num_rows($materias);

$query_creditoselectivos = getCreditosElectivasPlanEstudio($_REQUEST['cod_estudiante'],null,true);
$creditosPlanEstudio = mysql_query($query_creditoselectivos, $sala) or die(mysql_error());
if(mysql_num_rows($creditosPlanEstudio) > 0) {
    $creditosPlanEstudio=mysql_fetch_assoc($creditosPlanEstudio);
    $creditosPlanEstudio=$creditosPlanEstudio["creditos"];
} else {
    $creditosPlanEstudio = 0;
}

$creditosDebe = $creditosPlanEstudio;

if($totalRows > 0) {
	require_once('horarios.php');
	while($row_materias=mysql_fetch_assoc($materias)) {
            $creditosDebe = $creditosDebe - $row_materias['numerocreditos'];
                echo "<tr>
                <td>".$row_materias['codigomateria']."</td>
                <td><label onclick=\"return overlib('".getHorario($row_materias['codigomateria'], $_SESSION['codigoperiodosesion'], $_SESSION['codigo'])."', STICKY, CAPTION, 'Información:', BGCOLOR, '#E9E9E9', CAPCOLOR, '#000000', FGCOLOR, '#FFFFFF', BORDER, 2, TEXTSIZE, '8px');\">".$row_materias['nombremateria']."</label></td>
                <td align='center'>".$row_materias['codigoperiodo']."</td>
                <td align='right'>".$row_materias['notadefinitiva']."</td>
                <td align='center'>".$row_materias['numerocreditos']."</td>";
		if(!isset($_REQUEST["solomaterias"])) {
			echo "<td align='center'>&nbsp;";
			if($row_materias['codigoperiodo'] >= 20122){
			    if($row_materias['idcontenidoprogramatico']) 
			    echo '<a href="../materiasgrupos/contenidoprogramatico/toPdf.php?usuariosesion='.$_SESSION['MM_Username'].'&type=1&periodosesion='.$row_materias['codigoperiodo'].'&codigomateria='.$row_materias['codigomateria'].'" target="new">Ver syllabus</a>';
			    echo "<td align='center'>&nbsp;";
			    if($row_materias['idcontenidoprogramatico']) 
			    echo '<a href="../materiasgrupos/contenidoprogramatico/toPdf.php?usuariosesion='.$_SESSION['MM_Username'].'&type=2&periodosesion='.$row_materias['codigoperiodo'].'&codigomateria='.$row_materias['codigomateria'].'" target="new">Ver contenido program&aacute;tico</a>';
			    echo "</td>";
			}else{
			    if($row_materias['urlasyllabuscontenidoprogramatico']) 
			    echo "<a href='../materiasgrupos/contenidoprogramatico/".$row_materias['urlasyllabuscontenidoprogramatico']."' target='_blank'>Ver syllabus</a>";
			    echo "<td align='center'>&nbsp;";
			    if($row_materias['urlaarchivofinalcontenidoprogramatico'])
			    echo "<a href='../materiasgrupos/contenidoprogramatico/".$row_materias['urlaarchivofinalcontenidoprogramatico']."' target='_blank'>Ver contenido program&aacute;tico</a>";
			    echo "</td>";
			}
		}
		echo "</tr>";
	}
        if($creditosDebe >0){
		if(!isset($_REQUEST["solomaterias"]))
			echo "<tr><td colspan='".$colspan."'>Debe ".$creditosDebe." crédito(s) de Electivas Libres.</td></tr>";
        }
} else {
	echo "	<tr>
			<td colspan='".$colspan."'>No hay materias electivas.</td>
		</tr>";
}
?>
</table>
</body>
</html>
