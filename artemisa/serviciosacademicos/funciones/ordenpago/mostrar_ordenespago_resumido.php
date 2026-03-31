<?php
foreach($this->ordenesdepago as $key => $value)
{
	$query_selpago= "select f.fechaordenpago, f.valorfechaordenpago
	from fechaordenpago f 
	where f.numeroordenpago = '$value->numeroordenpago'
	order by 1";
	//and dop.codigoconcepto = '151'
	//echo "$query_ordenesporpagar<br>";
	$selpago = mysql_query($query_selpago,$this->sala) or die("$query_selpago<br>".mysql_error());
	$totalRows_selpago = mysql_num_rows($selpago);
	$row_selpago = mysql_fetch_array($selpago);
	
	$query_selestado= "select e.nombreestadoordenpago
	from estadoordenpago e 
	where e.codigoestadoordenpago = '$value->codigoestadoordenpago'
	order by 1";
	$selestado = mysql_query($query_selestado,$this->sala) or die("$query_selestado<br>".mysql_error());
	$totalRows_selestado = mysql_num_rows($selestado);
	$row_selestado = mysql_fetch_array($selestado);
	
	// Hago un query y tomo los datos de la tabla
	$this->numerodeordenesimpresas++;
	//echo "<h5>$this->numerodeordenesimpresas</h5>";
	if($this->numerodeordenesimpresas > 1)
	{
		echo '<tr>';
	}
?>
 <td>
<?php 
				echo "<a href='".$ruta."verorden.php?numeroordenpago=$value->numeroordenpago&codigoestudiante=$value->codigoestudiante&codigoperiodo=$value->codigoperiodo&ipimpresora=$rutaimpresion'>$value->numeroordenpago</a>";
?>
  </td>
  <td>$ <?php echo number_format($row_selpago['valorfechaordenpago']); ?></span></div></td>
  <td>
<?php
	echo $row_selestado['nombreestadoordenpago'];
	if(ereg("^1.+$",$value->codigoestadoordenpago))
	{
		//print_r($_SESSION);
		// Muestra orden por pagar
		if($fechavencimiento = $value->ordenvigente())
		{
			if(!isset($_SESSION['MM_UserGroup']))
			{
?>
		<a href="<?php echo $ruta."verorden.php?pse=".$fechavencimiento['valorfechaordenpago']."&numeroordenpago=$value->numeroordenpago&codigoestudiante=$value->codigoestudiante&codigoperiodo=$value->codigoperiodo&ipimpresora=$rutaimpresion"; ?>"> Pagar PSE</a> 
<?php
			}
		}
		else
		{
			echo " Vencida";
		}
	}
	else if(ereg("^4.+$",$value->codigoestadoordenpago))
	{
		if($codigocomprobante = $value->existe_ticket())
		{
?>
        <a href="<?php echo $ruta?>ticket.php?ordenpago=<?php echo $value->numeroordenpago ?>"><?php echo $codigocomprobante; ?></a>
<?php
		}
		else
		{
			//echo $value->existe_ticket();
?>
			Sin Ticket
<?php
		}
	}
	else if(ereg("^6.+$",$value->codigoestadoordenpago))
	{
		if($codigocomprobante = $value->existe_ticket())
		{
?>
        <a href="<?php echo $ruta?>ticket.php?ordenpago=<?php echo $value->numeroordenpago ?>"><?php echo $codigocomprobante; ?></a>
<?php
		}
	}
?>
	</td>
	<td align="center">
<?php
	// 1 Miranos si esta a paz y salvo el estudiante
	$value->imprimir_ordenpdf($ruta);
?>	
	</td>
<?php
}
$this->numerodeordenesimpresas--;
?>
