<?php
function validar_pago_derechos_grado($codigoestudiante,$sala)
{
	$query_valida_pago_derechos_grado="
	SELECT count(c.codigoconcepto) as cantidad
	FROM
	concepto c, ordenpago op, detalleordenpago dop
	WHERE
	op.numeroordenpago=dop.numeroordenpago
	AND	op.codigoestudiante='".$codigoestudiante."'
	AND c.codigoconcepto=dop.codigoconcepto
	AND c.codigoconcepto='108'
	AND op.codigoestadoordenpago like '4%'
	";
	//echo $query_valida_pago_derechos_grado,"<br>";
	$valida_pago_derechos_grado=mysql_query($query_valida_pago_derechos_grado) or die(mysql_error.$query_valida_pago_derechos_grado);
	$row_valida_pago_derechos_grado=mysql_fetch_assoc($valida_pago_derechos_grado);
	$cantidad=$row_valida_pago_derechos_grado['cantidad'];
	//print_r($row_valida_pago_derechos_grado);
	//echo $row_valida_pago_derechos_grado['cantidad'],"<br>";
	if($cantidad==0)
	{
		return true;//debe
	}
	else
	{
		return false;//nodebe
	}
	
}
?>
