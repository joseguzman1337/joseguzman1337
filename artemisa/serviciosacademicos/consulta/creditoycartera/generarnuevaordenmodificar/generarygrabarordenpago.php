<?php
//$codigoperiodo = $_SESSION['codigoperiodosesion'];
// Tomo los datos de la primera orden
// Verifico si hay conceptos nuevos y los adiciono
$numeroordenpagoini = $numeroordenpago;
/*
$query_updimpresion = "UPDATE ordenpago
						SET codigoestadoordenpago = '21'
						WHERE numeroordenpago = '$numeroordenpagoini'"; 
$updimpresion = mysql_query($query_updimpresion,$sala) or die("$query_updimpresion".mysql_error()); 
*/
$paramodificar = false;

$totalrecargos = 0;
$totaldescuentos = 0;
$valormatricula = 0;

//echo "dsasdasdasda <br>";
// Hago una copia de la orden anterior a la nueva
/*$query_selordenpago = "SELECT numeroordenpago, codigoestudiante, fechaordenpago, idprematricula, fechaentregaordenpago, codigoperiodo, codigoestadoordenpago, codigoimprimeordenpago, observacionordenpago, codigocopiaordenpago 
FROM ordenpago
where numeroordenpago = '$numeroordenpagoini'";
//echo "<br>".$query_detalleordenpago;
$selordenpago = mysql_query($query_selordenpago, $sala) or die("$query_selordenpago".mysql_error());
$totalRows_selordenpago = mysql_num_rows($selordenpago);
while($row_selordenpago = mysql_fetch_assoc($selordenpago))
{
	/************* Agregado Para adicionar la nueva orden ******************************/
	/*$query_selmaxnumeroordenpago="SELECT max(numeroordenpago) as mayor FROM ordenpago";	
	$selmaxnumeroordenpago=mysql_db_query($database_sala,$query_selmaxnumeroordenpago) or die("$query_selmaxnumeroordenpago");     
	$row_selmaxnumeroordenpago=mysql_fetch_array($selmaxnumeroordenpago);	
	$numeroordenpago = $row_selmaxnumeroordenpago['mayor'] + 1;
	
	$query_insordenpago = "insert into ordenpago(numeroordenpago,codigoestudiante,fechaordenpago,idprematricula,fechaentregaordenpago,codigoperiodo,codigoestadoordenpago,codigoimprimeordenpago,observacionordenpago,codigocopiaordenpago)
	VALUES('$numeroordenpago','$codigoestudiante','".date("Y-m-d",time())."','".$row_selordenpago['idprematricula']."','".$row_selordenpago['fechaentregaordenpago']."','$codigoperiodo','11','01','$numeroordenpagoini','100')"; 
	//echo "<br>".$query_insordenpago;
	$query_insordenpago = mysql_query($query_insordenpago, $sala) or die("$query_insordenpago".mysql_error()); 
}

$query_seldetalleordenpago = "SELECT numeroordenpago, codigoconcepto, valorconcepto, codigotipodetalleordenpago 
FROM detalleordenpago
where numeroordenpago = '$numeroordenpagoini'";
//echo "<br>".$query_detalleordenpago;
$seldetalleordenpago = mysql_query($query_seldetalleordenpago, $sala) or die("$query_seldetalleordenpago".mysql_error());
$totalRows_seldetalleordenpago = mysql_num_rows($seldetalleordenpago);
while($row_seldetalleordenpago = mysql_fetch_assoc($seldetalleordenpago))
{
	$query_insdetalleordenpago = "INSERT INTO detalleordenpago(numeroordenpago, codigoconcepto, valorconcepto, codigotipodetalleordenpago) 
    VALUES('$numeroordenpago', '".$row_seldetalleordenpago['codigoconcepto']."', '".$row_seldetalleordenpago['valorconcepto']."', '".$row_seldetalleordenpago['codigotipodetalleordenpago']."')";
	//echo "<br>".$query_insordenpago;
	$insdetalleordenpago = mysql_query($query_insdetalleordenpago, $sala) or die("$query_insdetalleordenpago".mysql_error());
}

if(!isset($_POST['fecha']))
{
	$query_selfechaordenpago = "SELECT numeroordenpago, fechaordenpago, porcentajefechaordenpago, valorfechaordenpago 
	FROM fechaordenpago
	where numeroordenpago = '$numeroordenpagoini'";
	//echo "<br>".$query_detalleordenpago;
	$selfechaordenpago = mysql_query($query_selfechaordenpago, $sala) or die("$query_selfechaordenpago".mysql_error());
	$totalRows_selfechaordenpago = mysql_num_rows($selfechaordenpago);
	while($row_selfechaordenpago = mysql_fetch_assoc($selfechaordenpago))
	{
		$query_insfechaordenpago = "INSERT INTO fechaordenpago(numeroordenpago, fechaordenpago, porcentajefechaordenpago, valorfechaordenpago) 
		VALUES('$numeroordenpago', '".$row_selfechaordenpago['fechaordenpago']."', '".$row_selfechaordenpago['porcentajefechaordenpago']."', '".$row_selfechaordenpago['valorfechaordenpago']."')";
		//echo "<br>".$query_insordenpago;
		$insfechaordenpago = mysql_query($query_insfechaordenpago, $sala) or die("$query_insfechaordenpago".mysql_error());
	}
}

$query_updfechaordenpago = "UPDATE detalleprematricula 
SET numeroordenpago = '$numeroordenpago'
WHERE numeroordenpago = '$numeroordenpagoini'";
//echo "<br>".$query_insordenpago;
$updfechaordenpago = mysql_query($query_updfechaordenpago, $sala) or die("$query_updfechaordenpago".mysql_error());
*/
// Elimino los que esten en dos e inserto los que aparezcan en dvd
// Si son orginales o adicionados los inserta
// Elimina los conceptos que no son del tipo arp
$query_deldvd = "delete from detalleordenpago
where numeroordenpago = '$numeroordenpago'
and codigotipodetalleordenpago = 2
and codigoconcepto <> '165'";
//echo "<br>".$query_detalleordenpago;
$deldvd = mysql_query($query_deldvd, $sala) or die("$query_deldvd".mysql_error());

// Selecciona los detalles de la orden de pago
$query_detallesordenpago = "select d.codigoconcepto, d.valorconcepto, d.codigotipodetalleordenpago, 
c.codigotipoconcepto
from detalleordenpago d, concepto c
where d.numeroordenpago = '$numeroordenpago'
and c.codigoconcepto = d.codigoconcepto";
//echo "<br>".$query_detalleordenpago;
$detallesordenpago = mysql_query($query_detallesordenpago, $sala) or die("$query_detallesordenpago".mysql_error());
$totalRows_detallesordenpago = mysql_num_rows($detallesordenpago);
while($row_detallesordenpago = mysql_fetch_assoc($detallesordenpago))
{
	if($row_detallesordenpago['codigoconcepto'] == '151' && $row_detallesordenpago['codigotipodetalleordenpago'] == '1')
	{
		$valormatricula = $valormatricula + $row_detallesordenpago['valorconcepto'];
	}
	else if($row_detallesordenpago['codigoconcepto'] == '165')
	{
		$pecuniarios = $pecuniarios + $row_detallesordenpago['valorconcepto'];
	}
	else if($row_detallesordenpago['codigotipodetalleordenpago'] == '3')
	{
		$pecuniarios = $pecuniarios + $row_detallesordenpago['valorconcepto'];
	}
}

// OJO Toma los conceptos de las deudas y se mira si estan en la orden (u ordenes del estudiante?)
$query_descuentodeuda = "select dvd.codigoconcepto, dvd.valordescuentovsdeuda, 
c.codigotipoconcepto, dvd.codigoactualizo
from descuentovsdeuda dvd, concepto c
where dvd.codigoestudiante = '$codigoestudiante'
and dvd.codigoestadodescuentovsdeuda = '01'
and dvd.codigoperiodo = '$codigoperiodo'
and c.codigoconcepto = dvd.codigoconcepto
order by dvd.codigoconcepto";
//echo "<br>".$query_descuentodeuda;
$descuentodeuda = mysql_query($query_descuentodeuda, $sala) or die("$query_descuentodeuda".mysql_error());
$totalRows_descuentodeuda = mysql_num_rows($descuentodeuda);

// Si el numero de conceptos de dvd son iguales a los de la orden de pago
// entonces los genera
// Deberia verificar para todas las ordenes del estudiante
$paramodificar = false;
if($totalRows_descuentodeuda != "")
{
	while($row_descuentodeuda = mysql_fetch_assoc($descuentodeuda))
	{
		if($row_descuentodeuda['codigotipoconcepto'] == 01)
		{
			//$valormatricula = $valormatricula + $row_descuentodeuda['valordescuentovsdeuda'];
			$totalrecargos = $totalrecargos + $row_descuentodeuda['valordescuentovsdeuda'];
		}
		if($row_descuentodeuda['codigotipoconcepto'] == 02)
		{
			//$valortotal = $valortotal - $row_descuentodeuda['valordescuentovsdeuda'];
			$totaldescuentos = $totaldescuentos + $row_descuentodeuda['valordescuentovsdeuda'];
		}
		
		$query_insdetalleordenpago = "insert into detalleordenpago(numeroordenpago,codigoconcepto,cantidaddetalleordenpago, valorconcepto,codigotipodetalleordenpago)
		VALUES('$numeroordenpago','".$row_descuentodeuda['codigoconcepto']."',1,'".$row_descuentodeuda['valordescuentovsdeuda']."','2')"; 
		echo $query_insdetalleordenpago,"<br>";
		$insdetalleordenpago = mysql_query($query_insdetalleordenpago,$sala) or die("$query_insdetalleordenpago");
		$paramodificar = true;
	}
  
		
}

// Si viene una fecha adicional se debe insertar aca calculandola con el recargo adecuado.
if(isset($_POST['fecha']))
{
	// Si entra es por que se debe insertar una fecha adicional
	$totalconrecargo = $valormatricula + ($valormatricula * $_POST['porcentaje'] / 100) + $pecuniarios + $totalrecargos - $totaldescuentos; 
	echo "$totalconrecargo = $valormatricula + ($valormatricula * ".$_POST['porcentaje']." / 100) + $pecuniarios + $totalrecargos - $totaldescuentos;";
	$query_insfechaordenpago = "insert into fechaordenpago(numeroordenpago,fechaordenpago,porcentajefechaordenpago,valorfechaordenpago)
	VALUES('$numeroordenpago','".$_POST['fecha']."','".$_POST['porcentaje']."','$totalconrecargo')"; 
	echo $query_insfechaordenpago;
	$insfechaordenpago = mysql_query($query_insfechaordenpago,$sala) or die("$query_insfechaordenpago");
}
else
{
	$query_fecha="SELECT o.numeroordenpago, f.valorfechaordenpago, f.porcentajefechaordenpago, f.fechaordenpago
	FROM ordenpago o, fechaordenpago f
	where o.codigoestudiante = '$codigoestudiante'
	and o.codigoestadoordenpago like '1%'
	and o.codigoperiodo = '$codigoperiodo'
	and f.numeroordenpago = o.numeroordenpago
	and o.numeroordenpago = '$numeroordenpago'";
	//echo $query_fecha; 
	$fecha=mysql_db_query($database_sala,$query_fecha) or die("$query_fecha".mysql_error());
		
	while($row_fecha=mysql_fetch_array($fecha))
	{			
		//$totalconrecargo = $row_fecha['valorfechaordenpago'] + $totalrecargos - $totaldescuentos; 
		$totalconrecargo = $valormatricula + ($valormatricula * $row_fecha['porcentajefechaordenpago'] / 100)+ $pecuniarios +$totalrecargos - $totaldescuentos; 
		//echo $valormatricula,"mtr&nbsp;",$row_fecha['porcentajefechaordenpago'],"%&nbsp;",$pecuniarios,"pe&nbsp;",$totalrecargos,"re&nbsp;",$totaldescuentos,"des-->recargo",$totalconrecargo,"re<br>"; 
		$query_updfecha = "UPDATE fechaordenpago 
		SET valorfechaordenpago = '$totalconrecargo'
		WHERE numeroordenpago = '$numeroordenpago'						
		and porcentajefechaordenpago = '".$row_fecha['porcentajefechaordenpago']."'";		
		//echo $query_updfecha;
		$updfecha = mysql_query($query_updfecha,$sala) or die("$query_updfecha".mysql_error());
	}
}
//exit();
require("../../../funciones/open.php");
?>
<script language="javascript">
	alert("Se ha generado la orden de pago <?php echo $numeroordenpago ?>,puede imprimirla");
	//window.location.reload("generarnuevaorden.php");
</script>
<?php
//}
// Selecciono los datos de fechaorden pago con el valor que alli se encuentra y sumo o resto el concepto
if(isset($_POST['fecha']))
{
	echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=generarnuevaordenmodificacionfecha.php'>";
}
else
{
	echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=generarnuevaorden.php'>";
}
?>