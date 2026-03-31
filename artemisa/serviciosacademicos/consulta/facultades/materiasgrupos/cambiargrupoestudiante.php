<?php
// Para cambiar de grupo a un estudiante.
// Primero se valida si el nuevo grupo no se cruza con los horarios ya seleccionados del estudiante
// Para esto primero selecciono los grupos del estudiante que aparecen en detalle prematricula
// Datos de la primera prematricula hecha sin el horario del grupo origen


$query_premainicial = "SELECT d.codigomateria, d.idgrupo, d.idprematricula
FROM detalleprematricula d, prematricula p, materia m, estudiante e,ordenpago o,detalleordenpago de
where d.codigomateria = m.codigomateria 
and d.idprematricula = p.idprematricula
and p.codigoestudiante = e.codigoestudiante
and o.numeroordenpago = de.numeroordenpago
and o.numeroordenpago = d.numeroordenpago
and o.codigoperiodo = p.codigoperiodo
and de.codigoconcepto = 151
and e.codigoestudiante = '$codigoestudiante'
and (p.codigoestadoprematricula like '4%' or p.codigoestadoprematricula like '1%')
and (d.codigoestadodetalleprematricula like '3%' or d.codigoestadodetalleprematricula like '1%')
and p.codigoperiodo = '$codigoperiodo'";
//  or d.codigoestadodetalleprematricula = '23'
//echo "dadadad $query_premainicial<br>";
//exit();
$premainicial=mysql_query($query_premainicial, $sala) or die("$query_premainicial");
$totalRows_premainicial = mysql_num_rows($premainicial);
$tieneprema = false;
while($row_premainicial = mysql_fetch_array($premainicial))
{
	$gruposestudiante[$row_premainicial["codigomateria"]] = $row_premainicial['idgrupo'];
	$idprematricula = $row_premainicial['idprematricula'];
}
// Le asigno el nuevo grupo al arreglo
$gruposestudiante[$codigomateriaini] = $idgrupofin;
unset($horariocruce);

$horariocruce = horariovalido($gruposestudiante, $codigoperiodo, $sala,$codigomateriaini);

$estudiantehorariocruce[$codigoestudiante] = $horariocruce;

if($horariocruce == 1)
{
	//exit();
	// Si el horario es valido le hace la respectiva modificacion
	// Co la respectiva materia
	if(!$tienecorte && $codigomateriaini != $codigomateriafin)
	{
		//echo "Entro1<br>";
		$modificadetalleprematriculagrupo = "UPDATE detalleprematricula dp 
		SET dp.idgrupo = '$idgrupofin', dp.codigomateria = '$codigomateriafin'
		WHERE dp.idgrupo = '$idgrupoini'
		and dp.idprematricula = '$idprematricula'";
		$modificadetalleprematriculagrupo1=mysql_db_query($database_sala,$modificadetalleprematriculagrupo) or die (mysql_error()."<br>$modificadetalleprematriculagrupo");
		
	}
	// Deja cambio de nota cuando no se trata de los mismos cortes o se trate de la misma materia
	if($codigomateriaini == $codigomateriafin)
	{
		//echo "Entro2<br>";
		 $modificadetalleprematriculagrupo = "UPDATE detalleprematricula dp 
		SET dp.idgrupo = '$idgrupofin', dp.codigomateria = '$codigomateriafin'
		WHERE dp.idgrupo = '$idgrupoini'
		and dp.idprematricula = '$idprematricula'";
		$modificadetalleprematriculagrupo1=mysql_db_query($database_sala,$modificadetalleprematriculagrupo) or die (mysql_error()."<br>$modificadetalleprematriculagrupo");
		
		$modificadetallenota = "UPDATE detallenota dn
		SET dn.idgrupo = '$idgrupofin'
		where dn.idgrupo = '$idgrupoini'
		and dn.codigoestudiante = '$codigoestudiante'";
		$modificadetallenota1=mysql_db_query($database_sala,$modificadetallenota) or die (mysql_error()."<br>$modificadetallenota");
	}
	
	$estudiantescambiados[] = $codigoestudiante;
}
else
{	
	$estudiantehorariocruce[$codigoestudiante] = $horariocruce;
	$mensaje = true;
}

$gruposestudiante[] = $idgrupoini;
foreach($gruposestudiante as $llave2 => $valor2)
{	
	actualizarmatriculados($valor2, $codigoperiodo, $codigocarrera, $sala);
	actualizargrupos($valor2 , $codigoperiodo , $sala);
	//echo $codigoperiodo,"<br>";
}
unset($gruposestudiante);
commit;
?>