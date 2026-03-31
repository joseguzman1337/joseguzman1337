<?php
$descuento = 0;
$saldo = 0;

// Inserto los nuevos conceptos en detalle orden pago

// Selecciono los conceptos de la orden
$query_ordenpago = "SELECT o.numeroordenpago, f.valorfechaordenpago
FROM ordenpago o, fechaordenpago f
where o.codigoestudiante = '$codigoestudiante'
and (o.codigoestadoordenpago like '4%' or o.codigoestadoordenpago like '1%')
and o.codigoperiodo = '$codigoperiodo'
and f.numeroordenpago = o.numeroordenpago
and f.porcentajefechaordenpago = '0'";
//echo "<br>".$query_detalleordenpago;
$ordenpago = mysql_query($query_ordenpago, $sala) or die(mysql_error());
$totalRows_ordenpago = mysql_num_rows($ordenpago);

// Si tiene una orden de pago activa entra a comparar los datos de la nueva con las anteriores
while($row_ordenpago = mysql_fetch_assoc($ordenpago))
{
	$numeroordenpagoinicial = $row_ordenpago['numeroordenpago'];
	$valorordenpagoinicial = $row_ordenpago['valorfechaordenpago'];

	$query_conceptoinicial = "SELECT d.valorconcepto
	FROM detalleordenpago d
	where d.numeroordenpago = '$numeroordenpagoinicial'
	and d.codigoconcepto = '151'";
	//echo "<br>".$query_conceptoinicial;
	$conceptoinicial = mysql_query($query_conceptoinicial, $sala) or die(mysql_error());
	$row_conceptoinicial = mysql_fetch_assoc($conceptoinicial);
	$totalRows_conceptoinicial = mysql_num_rows($conceptoinicial);
	// Suma el valor de todos los conceptos de matricula, si el valor nuevo supera esta suma se genera nueva orden
	$valormatriculainicial = $valormatriculainicial+$row_conceptoinicial['valorconcepto'];
}
$query_descuentovsdeuda="SELECT * FROM descuentovsdeuda
WHERE codigoestudiante = '$codigoestudiante'
and codigoperiodo = '$codigoperiodo'
and codigoestadodescuentovsdeuda = 01";
//echo "<br>".$query_descuentovsdeuda;
$descuentovsdeuda=mysql_db_query($database_sala,$query_descuentovsdeuda) or die(mysql_error());
$row_descuentovsdeuda=mysql_fetch_array($descuentovsdeuda);
if(!$row_descuentovsdeuda)
{

}
else
{
	do
	{
		//echo "holaaa $codigoconcepto1<br>";
		$deuda1="SELECT * FROM concepto c,tipoconcepto t
		WHERE c.codigoconcepto = '".$row_descuentovsdeuda['codigoconcepto']."'
        AND c.codigotipoconcepto = t.codigotipoconcepto";
		$query1=mysql_db_query($database_sala,$deuda1)  or die(mysql_error());
    	//echo "$deuda1<br>";
		$solucion1=mysql_fetch_array($query1);
		$codigoconcepto[$guardar] = $row_descuentovsdeuda['codigoconcepto'];
		//echo "Codigoconceptodos: ".$codigoconcepto1."<br>";
		$valorconcepto[$guardar] = $row_descuentovsdeuda['valordescuentovsdeuda'];
		$codigotipodetalle[$guardar] = 02;
		$guardar=$guardar + 1;
		// echo $solucion1['codigotipoconcepto'];
		// echo $row_descuentovsdeuda['codigoconcepto'];

		if ($solucion1['codigotipoconcepto'] == 01)
  		{
			$totalvalormatricula= $totalvalormatricula + $row_descuentovsdeuda['valordescuentovsdeuda'];
			$descuento= $descuento + $row_descuentovsdeuda['valordescuentovsdeuda'];
			//echo "descuento: $saldo";
		}
		else if ($solucion1['codigotipoconcepto'] == 02)
  		{
   			$totalvalormatricula= $totalvalormatricula - $row_descuentovsdeuda['valordescuentovsdeuda'];
			$saldo=  $saldo + $row_descuentovsdeuda['valordescuentovsdeuda'];
			//echo "SALDO: $saldo";
  		}
	}
 	while ($row_descuentovsdeuda=mysql_fetch_array($descuentovsdeuda));
}
if ($descuento > 0)
{
	$codigoimprimeordenpago = '02';
}
else
{
	$codigoimprimeordenpago = '01';
}
$deuda8="SELECT max(numeroordenpago) as mayor FROM ordenpago";
$query8=mysql_db_query($database_sala,$deuda8) or die(mysql_error());
$solucion8=mysql_fetch_array($query8);
$numeroordenpago = $solucion8['mayor'] + 1;
// BEGIN;
$sql = "UPDATE ordenpago
    SET codigoestadoordenpago='$nuevoestado1'
    WHERE numeroordenpago = '$observacion'";
	// echo $sql."<br>";
$result = mysql_query($sql,$sala) or die(mysql_error());

$fechainicialentregaordenpago = 0;
$sql = "insert into ordenpago(numeroordenpago,codigoestudiante,fechaordenpago,idprematricula,fechaentregaordenpago,codigoperiodo,codigoestadoordenpago,codigoimprimeordenpago,observacionordenpago)";
$sql.= "VALUES('$numeroordenpago','$codigoestudiante','".date("Y-m-d",time())."','$idprematricula','$fechainicialentregaordenpago','$codigoperiodo','11','".$codigoimprimeordenpago."','$observacion')";
	// echo $sql."<br>";
$result = mysql_query($sql,$sala) or die(mysql_error());

for ($i = 1; $i < $guardar ; $i++)
{
	$sql = "insert into detalleordenpago(numeroordenpago,codigoconcepto,valorconcepto,codigotipodetalleordenpago)";
	$sql.= "VALUES('$numeroordenpago','".$codigoconcepto[$i]."','".$valorconcepto[$i] ."','".$codigotipodetalle[$i]."')";
	//echo $sql."<br>";
	$result = mysql_query($sql,$sala) or die(mysql_error());
}

$fecha="SELECT d.nombredetallefechafinanciera,d.fechadetallefechafinanciera,d.porcentajedetallefechafinanciera
         FROM fechafinanciera f,detallefechafinanciera d
         WHERE f.codigocarrera = '$codigocarrera'
         AND f.idfechafinanciera =d.idfechafinanciera
		 order by 3 asc";
$query5=mysql_db_query($database_sala,$fecha) or die(mysql_error());
$fechas=mysql_fetch_array($query5);
do
{
	if ($fechas['porcentajedetallefechafinanciera'] == 0)
	{
 		$totalconrecargo = $totalvalormatricula ;
	}
	else if ($fechas['porcentajedetallefechafinanciera'] <> 0)
	{
 		$conrecargo =  $recargototalvalormatricula + ($recargototalvalormatricula * $fechas['porcentajedetallefechafinanciera'] /100 );
		$totalconrecargo = $conrecargo + $valorpecuniario +  $descuento - $saldo;
	}
    $sql = "insert into fechaordenpago(numeroordenpago,fechaordenpago,porcentajefechaordenpago,valorfechaordenpago)";
	$sql.= "VALUES('$numeroordenpago','".$fechas['fechadetallefechafinanciera']."','".$fechas['porcentajedetallefechafinanciera']."','".$totalconrecargo."')";
	//echo $sql."<br>";
	$result = mysql_query($sql,$sala) or die(mysql_error());
}
while ($fechas=mysql_fetch_array($query5));
//COMMIT;

$banco="SELECT *
					FROM cuentabanco c,banco b,periodo p
					WHERE c.codigocarrera = '$codigocarrera'
					AND p.codigoestadoperiodo = 1
					AND c.codigobanco =b.codigobanco
					AND c.codigoperiodo = p.codigoperiodo";
//echo $banco."<br>";
$banco5=mysql_db_query($database_sala,$banco) or die(mysql_error());
$bancos=mysql_fetch_array($banco5);

if (! $bancos)
{
	$banco="SELECT *
				FROM cuentabanco c,banco b,periodo p
					WHERE  c.codigobanco =b.codigobanco
					AND p.codigoestadoperiodo = 1
					AND c.codigoperiodo = p.codigoperiodo
					AND codigocarrera IS NULL";
	$banco5=mysql_db_query($database_sala,$banco) or die(mysql_error());
	$bancos=mysql_fetch_array($banco5);
}
do
{
	$sql = "insert into cuentabancoordenpago(numeroordenpago,idcuentabanco)";
	$sql.= "VALUES('$numeroordenpago','".$bancos['idcuentabanco']."')";
	$result = mysql_query($sql,$sala) or die(mysql_error());
}
while ($bancos=mysql_fetch_array($banco5));
echo '<script language="JavaScript">alert("Nueva Orden generada: '.$numeroordenpago.'")</script>';
?>