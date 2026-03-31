<?
require_once('../../../Connections/sala2.php');
$rutaado = "../../../funciones/adodb/";
require_once('../../../Connections/salaado.php');
$tabla='respuestaegresadosindustrialacreditacion20131';
$periodo='20131';
$codigocarreras='126,8';

if($_REQUEST['accion']=='Exportar') {
	$nombre_archivo_excel='resultados.xls';
	header("Content-Type: application/vnd.ms-excel");
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("content-disposition: attachment;filename=$nombre_archivo_excel");
}
$query="SELECT	 s1.codigocarrera
		,c.nombrecarrera
		,s1.total_egresados
		,s2.total_diligenciados
	FROM (
		SELECT	 codigocarrera
			,COALESCE(nuevos,0)+COALESCE(antiguos,0) AS total_egresados 
		FROM (  
			Select   codigocarrera
				,count(*) As nuevos 
			From (  select   distinct 
					codigoestudiante
					,codigocarrera 
				from registrograduado 
				join estudiante using(codigoestudiante) 
				where codigocarrera in ($codigocarreras)
			) s1 
			Group By codigocarrera
		) sub1 
		LEFT JOIN (     
			Select   codigocarrera
				,count(*) As antiguos 
			From (  select   distinct 
					documentoegresadoregistrograduadoantiguo
					,codigocarrera 
				from registrograduadoantiguo 
				where codigocarrera in ($codigocarreras) 
			) s2 
			Group By codigocarrera
		) sub2 USING(codigocarrera)
	) s1
	LEFT JOIN (
		Select	 codigocarrera
			,Count(*) As total_diligenciados
		From (
			select	 distinct 
				 codigocarrera
				,numerodocumento
			from $tabla
			where numerodocumento not in (	select distinct numerodocumento
							from $tabla
							where valorrespuestaegresadosindustrialacreditacion20131='' )
		) sub 
		Group By codigocarrera
	) s2 USING (codigocarrera)
	JOIN carrera c ON s1.codigocarrera=c.codigocarrera";
$exec = mysql_query($query, $sala) or die("$query" . mysql_error());
echo "<form name='forma' action='' method='post'>";
if($_REQUEST['accion']!='Exportar')
	echo "<input type='submit' name='accion' value='Exportar'>";
echo "<br><br>";
echo "<table border='1'>";
echo "<tr>";
echo "<th>Codigo carrera</th>";
echo "<th>Nombre carrera</th>";
echo "<th>Total egresados</th>";
echo "<th>Total diligenciados</th>";
echo "</tr>";
while($row=mysql_fetch_array($exec)) {
	echo "<tr>";
	echo "<td align='center'>".$row['codigocarrera']."</td>";
	echo "<td>".$row['nombrecarrera']."</td>";
	echo "<td align='center'>".$row['total_egresados']."</td>";
	echo "<td align='center'>".$row['total_diligenciados']."</td>";
	echo "</tr>";
}
echo "</table>";
echo "</form>";
?>		
