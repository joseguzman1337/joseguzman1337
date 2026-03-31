<?php
session_start();
include_once('../../../utilidades/ValidarSesion.php');
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION);
include (realpath(dirname(__FILE__) . "/../../../../sala/includes/adaptador.php"));
?>
<html>
<head>
<title>Lineas de enfasis</title>
</head>
<link rel="stylesheet" href="../../../estilos/sala.css" type="text/css">
<body>
<table border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9" width="750" align="center">
<tr>
	<td id="tdtitulogris" colspan='4'>LINEAS DE ENFASIS DEL PLAN DE ESTUDIOS</td>
</tr>
<tr>
	<td id="tdtitulogris" align="center">C&oacute;digo</td>
	<td id="tdtitulogris" align="center">Asignatura</td>
	<td id="tdtitulogris" align="center">Syllabus</td>
	<td id="tdtitulogris" align="center">Contenido program&aacute;tico</td>
</tr>
<?php
$query=" select l.nombrelineaenfasisplanestudio
		,m.codigomateria
		,m.nombremateria
		,cp.urlaarchivofinalcontenidoprogramatico
		,cp.urlasyllabuscontenidoprogramatico
	from lineaenfasisplanestudio l 
	join detallelineaenfasisplanestudio dl on l.idlineaenfasisplanestudio=dl.idlineaenfasisplanestudio 
	join materia m on dl.codigomateriadetallelineaenfasisplanestudio=m.codigomateria 
	left join contenidoprogramatico cp on m.codigomateria=cp.codigomateria 
	where l.idplanestudio=".$_REQUEST['idplanestudio']."
		and l.codigoestadolineaenfasisplanestudio like '1%' 
		and codigoestadodetallelineaenfasisplanestudio like '1%' 
	order by l.nombrelineaenfasisplanestudio
		,m.codigomateria";
$materias = $db->GetAll($query);
$totalRows = count($materias);
if($totalRows > 0) {
	$aux="";
	foreach($materias as $row_materias) {
		if($aux!=$row_materias['nombrelineaenfasisplanestudio'])
			echo "<tr><td id='tdtitulogris' colspan='4' align='center'>LINEA DE ENFASIS : ".$row_materias['nombrelineaenfasisplanestudio']."</td></tr>";
		echo "	<tr>
				<td>".$row_materias['codigomateria']."</td>
				<td>".$row_materias['nombremateria']."</td>
    				<td align='center'>&nbsp;";
					if($row_materias['urlasyllabuscontenidoprogramatico']) 
						echo "<a href='../materiasgrupos/contenidoprogramatico/".$row_materias['urlasyllabuscontenidoprogramatico']."' target='_blank'>Ver syllabus</a>";
    		echo "		<td align='center'>&nbsp;";
					if($row_materias['urlaarchivofinalcontenidoprogramatico']) 
						echo "<a href='../materiasgrupos/contenidoprogramatico/".$row_materias['urlaarchivofinalcontenidoprogramatico']."' target='_blank'>Ver contenido program&aacute;tico</a>";
		echo "		</td>				
			</tr>";
		$aux=$row_materias['nombrelineaenfasisplanestudio'];
	}
} else {
	echo "	<tr>
			<td colspan='4' align='center'>No hay lineas de enfasis para este plan.</td>
		</tr>";
}
?>
</table>
</body>
</html>
