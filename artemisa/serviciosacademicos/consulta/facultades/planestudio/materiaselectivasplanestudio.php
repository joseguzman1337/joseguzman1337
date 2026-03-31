<?php
session_start();
include_once('../../../utilidades/ValidarSesion.php');
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION);
include (realpath(dirname(__FILE__) . "/../../../../sala/includes/adaptador.php"));
?>
<html>
<head>
<title>Electivas libres</title>
</head>
<link rel="stylesheet" href="../../../estilos/sala.css" type="text/css">
<body>
<table border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9" width="750" align="center">
<tr>
	<td id="tdtitulogris" colspan='4'>ELECTIVAS</td>
</tr>
<tr>
	<td id="tdtitulogris" align="center">C&oacute;digo</td>
	<td id="tdtitulogris" align="center">Asignatura</td>
	<td id="tdtitulogris" align="center">Syllabus</td>
	<td id="tdtitulogris" align="center">Contenido program&aacute;tico</td>
</tr>
<?php
$query="select	 m.codigomateria
		,m.nombremateria
		,cp.urlaarchivofinalcontenidoprogramatico
		,cp.urlasyllabuscontenidoprogramatico
	from materia m
	left join contenidoprogramatico cp on m.codigomateria=cp.codigomateria
	join ( select distinct dg.codigomateria
		from grupomateria g join detallegrupomateria dg on dg.idgrupomateria=g.idgrupomateria
		where codigotipogrupomateria like '1%' and g.codigoperiodo = '".$_SESSION['codigoperiodosesion']."'
	) as sub on m.codigomateria=sub.codigomateria
	order by m.nombremateria";
$materias = $db->GetAll($query);
$totalRows = count($materias);
if($totalRows > 0) {
	foreach ($materias as $row_materias) {
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
	}
} else {
	echo "	<tr>
			<td colspan='4' align='center'>No hay materias electivas.</td>
		</tr>";
}
?>
</table>
</body>
</html>
