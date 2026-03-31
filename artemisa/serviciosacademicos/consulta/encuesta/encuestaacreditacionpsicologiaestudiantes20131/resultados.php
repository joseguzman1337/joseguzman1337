<?
require_once('../../../Connections/sala2.php');
$rutaado = "../../../funciones/adodb/";
require_once('../../../Connections/salaado.php');

$nombre_archivo_excel='resultados.xls';
$idencuesta=77;
$tabla='respuestaestudiantespsicologiaacreditacion20131';

if($_REQUEST['accion']=='Exportar') {
	$nombre_archivo_excel='resultados.xls';
	header("Content-Type: application/vnd.ms-excel");
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("content-disposition: attachment;filename=$nombre_archivo_excel");
}

echo "<form name='forma' action='' method='post'>";
if($_REQUEST['accion']!='Exportar')
	echo "<input type='submit' name='accion' value='Exportar'>";

echo "<br><br>";

echo "<table border='1'>";

$query="select   idpregunta
	        ,nombrepregunta
	        ,conteo
	from pregunta p
	join (  select   idpreguntagrupo
	                ,count(*) as conteo
	        from encuestapregunta
	        join pregunta using(idpregunta)
	        where idencuesta=$idencuesta and idpreguntagrupo<>0
	        group by idpreguntagrupo
	) sub on p.idpregunta=sub.idpreguntagrupo
	order by idpregunta";
$exec = mysql_query($query, $sala) or die("$query" . mysql_error());
echo "<tr>";
echo "<td rowspan='2'>Participante</td>";
echo "<td rowspan='2'>Programa académico</td>";
while($row=mysql_fetch_array($exec)) {
	$arrGrupos[]=$row['idpregunta'];
	echo "<th colspan='".$row['conteo']."'>".$row['nombrepregunta']."</th>";
}
echo "</tr>";


$query="select idencuestapregunta
		,nombrepregunta
		,idtipopregunta
	from encuestapregunta
	join pregunta using(idpregunta)
	where idpreguntagrupo in (".implode(",",$arrGrupos).")
	order by idpreguntagrupo,idencuestapregunta";
echo "<tr>";
$exec = mysql_query($query, $sala) or die("$query" . mysql_error());
while($row=mysql_fetch_array($exec)) {
	$arrPreguntas[]=$row['idencuestapregunta'];
	if($row['idtipopregunta']==101)
		echo "<th bgcolor='#CEECF5'>".$row['nombrepregunta']."</th>";
	else
		echo "<td>".$row['nombrepregunta']."</td>";
}
echo "</tr>";

$query="select   numerodocumento
                ,nombrecarrera
                ,idencuestapregunta
                ,valor$tabla
        from $tabla rep
        join encuestapregunta ep using(idencuestapregunta)
        join pregunta p using(idpregunta)
        join carrera using(codigocarrera)
        where not exists (      select distinct numerodocumento,nombrecarrera
                                from $tabla rep2
                                where trim(valor$tabla)=''
                                        and rep.numerodocumento=rep2.numerodocumento
                                        and rep.codigocarrera=rep2.codigocarrera
        )
        order by numerodocumento,nombrecarrera,idencuestapregunta";
$exec = mysql_query($query, $sala) or die("$query" . mysql_error());
echo "<tr>";
$nro_doc=0;
while($row=mysql_fetch_array($exec)) {
	if($nro_doc==0)
		$nro_doc=$row['numerodocumento'];
	if($nro_doc!=$row['numerodocumento']) {
		echo "<td>".$nro_doc."</td>";
		echo "<td>".$nom_car."</td>";
		foreach ($arrPreguntas as $valor) {
			echo "<td>".$arrRespuestas[$valor]."&nbsp;</td>";
		} 
		echo "</tr>";
		$arrRespuestas=array();
		echo "<tr>";
	}
	$arrRespuestas[$row['idencuestapregunta']]=$row['valor'.$tabla];
	$nro_doc=$row['numerodocumento'];
	$nom_car=$row['nombrecarrera'];
}
echo "<td>".$nro_doc."</td>";
echo "<td>".$nom_car."</td>";
foreach ($arrPreguntas as $valor) {
	echo "<td>".$arrRespuestas[$valor]."&nbsp;</td>";
} 
echo "</tr>";
echo "</table>";
echo "</form>";
?>		
