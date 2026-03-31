<?php
    session_start();
    include_once('../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
//echo "<br>matriculaautomaticaguardarcolegio</br>";
if(!$tiene_prema)
{
	// Inscribir asignaturas
	if($_POST['tipoorden'] == 0)
	{
                //echo "UNO";
		$totalmatricula = $orden->insertarconcepto_matricula_cohorte();
		$totalpecuniarios = $orden->insertarconceptospecuniariosxcodigoreferenciaconcepto(100);
		if(isset($_POST['fechapago']))
		{
			$orden->insertarfechaordenpago($_POST['fechapago'], 0, $totalmatricula+$totalpecuniarios);
		}
		else
		{
			$orden->insertarfechasordenpago_fechafianciera($totalmatricula, $totalpecuniarios);
		}
		$orden->insertarbancosordenpago();
		$orden->enviarsap_orden();
	}
	if($_POST['tipoorden'] == 1)
	{
                //echo "DOS";
		$conceptos[] = '159';
		$totalpecuniarios = $orden->insertarconceptospecuniarios_inscripcion($conceptos);
		//$orden->generarordenpago_conceptos($conceptos);
		if(isset($_POST['fechapago']))
		{
			$orden->insertarfechaordenpago($_POST['fechapago'], 0, $totalpecuniarios);
			//$orden->insertarfechaordenpago($_POST['fechapago'], 0, $totalpecuniarios);
		}
		else
		{
			$orden->insertarfechaordenpago($orden->tomar_fechaconceptosbd($conceptos), 0, $totalpecuniarios);
		}
		$orden->insertarbancosordenpago();
		$orden->enviarsap_orden();
	}
	?>
<script language="javascript">
alert("Se le ha generado una nueva orden de pago, por favor reclamela en CREDITO Y CARTERA");
</script>
<?php
	echo '<script language="javascript">
	window.location.href="matriculaautomaticaordenmatricula.php";
	</script>';
}
else
{
	//echo "POR DONDE VA";
	$query_estadoordenpago = "SELECT codigoestadoordenpago 
	FROM ordenpago
	where codigoestudiante = '$codigoestudiante'
	and numeroordenpago = '$numeroordenpagoinicial'";
	//echo "<br>".$query_estadoordenpago;
	$estadoordenpago = mysql_query($query_estadoordenpago, $sala) or die("$query_estadoordenpago");
	$totalRows_estadoordenpago = mysql_num_rows($estadoordenpago);
	$row_estadoordenpago = mysql_fetch_assoc($estadoordenpago);
	$estadoorden1 = $row_estadoordenpago['codigoestadoordenpago'];
	//echo "<br> $estadoorden1 <br>";
	
	if($estadoorden1 == 10 || $estadoorden1 == 11)
	{
		$query_upddetalleprem1 = "UPDATE detalleprematricula
		set codigoestadodetalleprematricula = '10'
		where numeroordenpago = '$numeroordenpago'";
		$upddetalleprem = mysql_query($query_upddetalleprem1, $sala) or die("$query_upddetalleprem1");
			
		$query_dellogdetalleprematricula = "UPDATE logdetalleprematricula
		set codigoestadodetalleprematricula = '10'
		where numeroordenpago = '$numeroordenpagoinicial'";
		$dellogdetalleprematricula = mysql_query($query_dellogdetalleprematricula, $sala) or die("$query_dellogdetalleprematricula");
	}
	else if($estadoorden1 == 40 || $estadoorden1 == 41)
	{
		$query_upddetalleprem2 = "UPDATE detalleprematricula
		set codigoestadodetalleprematricula = '30'
		where numeroordenpago = '$numeroordenpago'";
		$upddetalleprem = mysql_query($query_upddetalleprem2, $sala) or die("$query_upddetalleprem2");
			
		$query_dellogdetalleprematricula = "UPDATE logdetalleprematricula
		set codigoestadodetalleprematricula = '30'
		where numeroordenpago = '$numeroordenpago'";
		$dellogdetalleprematricula = mysql_query($query_dellogdetalleprematricula, $sala) or die("$query_dellogdetalleprematricula");
	}
	$query_detallepre = "UPDATE detalleprematricula
	set numeroordenpago = '$numeroordenpagoinicial'
	where numeroordenpago = '$numeroordenpago'";
	$upddeta = mysql_query($query_detallepre, $sala) or die("$query_detallepre");
	
	$query_updlogdetalleprematricula = "UPDATE logdetalleprematricula
	set numeroordenpago = '$numeroordenpagoinicial'
	where numeroordenpago = '$numeroordenpago'";
	$updlogdetalleprematricula = mysql_query($query_updlogdetalleprematricula, $sala) or die("$query_updlogdetalleprematricula");
		
	$query_delordenpago = "DELETE FROM ordenpago
	where numeroordenpago = '$numeroordenpago'";
	$delordenpago = mysql_query($query_delordenpago, $sala) or die("$query_delordenpago");
	$numeroordenpagoget = $numeroordenpagoinicial;
	//exit();
	if(!$procesoautomatico)
	{
		echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=matriculaautomaticaordenmatricula.php'>";
	}
}
// Para el colegio debe insertar las materias y asociar la orden de pago si existe de matriculas a estas materias
// si no asociar a una orden de pensión



// Generar la orden de con lo que venga en el tipo de orden matricula


?>
