<?
require_once('../../Connections/sala2.php');
$rutaado = "../../funciones/adodb/";
require_once('../../Connections/salaado.php');

$nombre_archivo_excel='consultaPagosEducacionContinuada.xls';

header("Content-Type: application/vnd.ms-excel");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("content-disposition: attachment;filename=$nombre_archivo_excel");

// La siguiente consulta es para obtener las ordenes pagadas de educacion continuada a partir del 01 de enero del 2012

// En la consulta se busca el maximo grupo de la orden de pago, ya que hay carreras de educacion continuada que se comportan como una carrera de pregrado
// (es decir la carrera tienen varias materias y las materias varios grupos, por ende una orden de pago puede estar amarrada a varios grupo)

// Solo se toman ordenes de pago que tengan concepto "Matricula"

// No se tienen en cuenta ordenes hijas, solo ordenes padre (esto para el caso de que una orden haya sido paga con un plan de pagos)

$query="SELECT	 c.nombrecarrera
		,g.nombregrupo
		,eg.numerodocumento
		,eg.apellidosestudiantegeneral
		,eg.nombresestudiantegeneral
		,numeroordenpago
		,valor
	FROM (
		Select distinct op.numeroordenpago
			,c.codigocarrera
			,dp.idgrupo
			,e.idestudiantegeneral
			,dop.valor
		From carrera c
		Join estudiante e Using(codigocarrera)
		Join ordenpago op Using(codigoestudiante)
		Left Join (
				select numeroordenpago
					,max(idgrupo) as idgrupo
				from detalleprematricula
				group by numeroordenpago
		) dp On dp.numeroordenpago=op.numeroordenpago
		join (
			select	 numeroordenpago
				,valorconcepto as valor
			from detalleordenpago
			where codigoconcepto='151'
		) dop on op.numeroordenpago=dop.numeroordenpago
		Where codigomodalidadacademica=400
			And fechaordenpago > '2011-12-31'
			And (codigoestadoordenpago like '4%' Or codigoestadoordenpago like '5%')
			And op.numeroordenpago Not In (select numerorodencoutaplandepagosap from ordenpagoplandepago) 
	) sub1 
	JOIN carrera c USING(codigocarrera)
	LEFT JOIN grupo g USING(idgrupo)
	JOIN estudiantegeneral eg USING(idestudiantegeneral)
	ORDER BY c.nombrecarrera
		,g.nombregrupo
		,eg.apellidosestudiantegeneral
		,eg.nombresestudiantegeneral";

$exec = mysql_query($query, $sala) or die("$query" . mysql_error());

echo "<table border='1'>";
echo "<tr>";
echo "<th>Carrera</th>";
echo "<th>Grupo</th>";
echo "<th>Nro. documento</th>";
echo "<th>Apellidos</th>";
echo "<th>Nombres</th>";
echo "<th>Nro. Orden Pago</th>";
echo "<th>Valor</th>";
echo "</tr>";
while($row=mysql_fetch_array($exec)) {
	echo "<tr>";
	echo "<td>".$row['nombrecarrera']."</td>";
	echo "<td>".$row['nombregrupo']."</td>";
	echo "<td align='right'>".$row['numerodocumento']."</td>";
	echo "<td>".$row['apellidosestudiantegeneral']."</td>";
	echo "<td>".$row['nombresestudiantegeneral']."</td>";
	echo "<td align='center'>".$row['numeroordenpago']."</td>";
	echo "<td align='right'>".$row['valor']."</td>";
	echo "</tr>";
}
echo "</table>";
?>		
