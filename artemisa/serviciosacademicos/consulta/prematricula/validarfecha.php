<?php
    session_start();
    include_once('../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
//echo "<br>validarfecha.php<br>";
/************************* VALIDACION DE LA FECHA ********************************/
if(!$generarordenprimeracuota)
{
// Toma el codigo del concepto que se encuentra activo
 $query_conceptofechafinaciera = "select c.nombreoconceptodetallefechafinanciera, c.codigoconceptodetallefechafinanciera
from conceptodetallefechafinanciera c
where codigoestadoconceptodetallefechafinanciera = '01'";
//echo "<br>".$query_selectpecuniarios;
$conceptofechafinaciera = mysql_query($query_conceptofechafinaciera, $sala) or die("query_conceptofechafinaciera");
$row_conceptofechafinaciera = mysql_fetch_assoc($conceptofechafinaciera);
$totalRows_conceptofechafinaciera = mysql_num_rows($conceptofechafinaciera);
$codigoconceptodetallefechafinanciera = $row_conceptofechafinaciera['codigoconceptodetallefechafinanciera'];

  
// Si el estudiante es antiguo
if($codigotipoestudiante == "20")
{
	//Si matriculas se encuentra activa, tome las fechas activas
	if($codigoconceptodetallefechafinanciera == "01")
	{
		$codigoestadoconceptodetallefechafinanciera = "01";
	}
	else
	{
		// Se encuentra activa habilitaciones es decir 02
		// Mira si existe una orden paga con concepto de matricula
		$query_ordenconmaticula = "SELECT o.numeroordenpago
		FROM ordenpago o, periodo p, detalleordenpago d
		where o.codigoestudiante = '$codigoestudiante'
		and o.codigoestadoordenpago like '4%'
		and o.codigoperiodo = p.codigoperiodo
		and p.codigoestadoperiodo = '1'
		and d.numeroordenpago = o.numeroordenpago
		and d.codigoconcepto = '151'";
		//echo "<br>".$query_selectordenconconcepto;
		$ordenconmaticula = mysql_query($query_ordenconmaticula, $sala) or die("query_ordenconmaticula");
		$row_ordenconmaticula = mysql_fetch_assoc($ordenconmaticula);
		$totalRows_ordenconmaticula = mysql_num_rows($ordenconmaticula);

		// Si tiene orden paga le cobra con la fecha habilitaciones
		if($totalRows_ordenconmaticula != "")
		{
			// Toma las activas
			$codigoestadoconceptodetallefechafinanciera = "01";
		}
		else
		{
			// Si no le cobra con la fecha matriculas la cual se encuentra inactiva
			$codigoestadoconceptodetallefechafinanciera = "02";
		}
	}
}
else
{
	$codigoestadoconceptodetallefechafinanciera = "01";
}
/***************************************************************************************************/
/* OJO: Toca mirar si el tipo estudiante es like 1 en la referencia, tomar la fecha que manden por el formulario.   */
/***************************************************************************************************/
//echo "<br>REF: $codigoreferenciatipoestudiante";



// Si el estudiante no es nuevo o el tipo de carrera es curso libres entonces toma las fechas de la base de datos
if(!isset($_SESSION['cursosvacacionalessesion']))
{
if(!ereg("^1.+",$codigoreferenciatipoestudiante)  || ereg("^3.+$",$codigoindicadortipocarrera))
{ 
	if(!ereg("^3.+$",$codigoindicadortipocarrera))
	{ //$codigocarreraantes
		$query_fecha="SELECT  d.nombredetallefechafinanciera, d.fechadetallefechafinanciera, d.porcentajedetallefechafinanciera, d.codigoconceptodetallefechafinanciera
		FROM fechafinanciera f, detallefechafinanciera d, conceptodetallefechafinanciera co
		WHERE f.codigocarrera = '$codigocarrera'
		AND f.idfechafinanciera = d.idfechafinanciera
		AND d.codigoconceptodetallefechafinanciera = co.codigoconceptodetallefechafinanciera
		AND co.codigoestadoconceptodetallefechafinanciera = '$codigoestadoconceptodetallefechafinanciera'
		AND f.codigoperiodo = '$codigoperiodo'
		and f.idsubperiodo = '$idsubperiodo'
		ORDER BY 3 ASC";
		$fecha = mysql_db_query($database_sala,$query_fecha) or die("$query_fecha");
		$totalRows_fecha = mysql_num_rows($fecha);
		if($totalRows_fecha == "")
		{
			$query_fecha="SELECT  d.nombredetallefechafinanciera, d.fechadetallefechafinanciera, d.porcentajedetallefechafinanciera, d.codigoconceptodetallefechafinanciera
			FROM fechafinanciera f, detallefechafinanciera d, conceptodetallefechafinanciera co
			WHERE f.codigocarrera = '$codigocarrera'
			AND f.idfechafinanciera = d.idfechafinanciera
			AND d.codigoconceptodetallefechafinanciera = co.codigoconceptodetallefechafinanciera
			AND co.codigoestadoconceptodetallefechafinanciera = '$codigoestadoconceptodetallefechafinanciera'
			AND f.codigoperiodo = '$codigoperiodo'
			ORDER BY 3 ASC";
			$fecha = mysql_db_query($database_sala,$query_fecha) or die("$query_fecha");
            
           
		}
	}
	else
	{
		foreach($materiascongrupo as $hey => $idgrupo)
		{
			$query_fecha="SELECT d.nombredetallefechaeducacioncontinuada as nombredetallefechafinanciera,
			d.fechadetallefechaeducacioncontinuada as fechadetallefechafinanciera,
			d.porcentajedetallefechaeducacioncontinuada as porcentajedetallefechafinanciera
			from fechaeducacioncontinuada f, detallefechaeducacioncontinuada d
			where f.codigoestado like '1%'
			and d.idfechaeducacioncontinuada = f.idfechaeducacioncontinuada
			and f.idgrupo = '$idgrupo'
			ORDER BY 3 ASC";
		}
		$fecha = mysql_db_query($database_sala,$query_fecha) or die("$query_fecha");
	}
	//echo $query_fecha;
	while($row_fecha = mysql_fetch_array($fecha))
	{
		if($row_fecha['porcentajedetallefechafinanciera'] == 0)
		{
			$totalconrecargo = $totalvalormatricula;
		}
		else if ($row_fecha['porcentajedetallefechafinanciera'] <> 0)
		{
			
						//$saldo=convertirPositivo($saldo);

			
			$conrecargo =  $recargototalvalormatricula + ($recargototalvalormatricula * $row_fecha['porcentajedetallefechafinanciera'] /100 );
			//$totalconrecargo = $conrecargo + $valorpecuniario +  $descuento - $saldo;
			$totalconrecargo = $conrecargo + $descuento + $saldo + $valorpecuniario;
		}
        //$row_fecha['fechadetallefechafinanciera']='0000-00-00';
        if($row_fecha['fechadetallefechafinanciera']=='' || $row_fecha['fechadetallefechafinanciera']==Null || $row_fecha['fechadetallefechafinanciera']=='0000-00-00'){
            
            
            $mensaje = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Reporte de resultados</title>
		
	</head>
<body>
<br> Error Numero 1<br><br>
$codigocarreraantes->'.$codigocarreraantes.'
<br>$codigoperiodo->'.$codigoperiodo.'
<br>$idsubperiodo->'.$idsubperiodo.'
<br>$numeroordenpago->'.$numeroordenpago.'
<br>$query_fecha->'.$query_fecha.'
<br>Insert'.$query_insfechaordenpago = "insert into fechaordenpago(numeroordenpago,fechaordenpago,porcentajefechaordenpago,valorfechaordenpago)
		VALUES('$numeroordenpago','".$row_fecha['fechadetallefechafinanciera']."','".$row_fecha['porcentajedetallefechafinanciera']."','$totalconrecargo')".'
</body>
</html>';
            
            /*$destinatarios = array();*/
        	$destinatarios = array("Marcos Ramirez <ramirezmarcos@unbosque.edu.co>");
        	
        	foreach($destinatarios as $destinatario){
        	
        	$asunto = "Informe de Malparides del Codigo ".date('d-m-Y h:i:s A');
            //$destinatario = "Leyla Bonilla <bonillaleyla@unbosque.edu.co>";
            //$headers = "From: no-responder@unbosque.edu.co \r\n";
                
                // Para enviar un correo HTML mail, la cabecera Content-type debe fijarse
                $cabeceras  = 'MIME-Version: 1.0' . "\r\n";
                //$cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                $cabeceras .= 'Content-type: text/html; charset=UTF-8' . "\r\n";        
        
                // Cabeceras adicionales
                //$cabeceras .= 'To: ' .$to. "\r\n";
                $cabeceras .= 'From: Tecnologia <it@unbosque.edu.co>' . "\r\n";
                //$cabeceras .= 'Cc: birthdayarchive@example.com' . "\r\n";
                //$cabeceras .= 'Bcc: birthdaycheck@example.com' . "\r\n";
                
        			  // Enviamos el mensaje
        			  if (mail($destinatario, $asunto, $mensaje, $cabeceras)) {
        					$aviso = "Su mensaje fue enviado.";
        					$succed = true;
        			  } else {
        					$aviso = "Error de envío.";
        					$succed = false;
        			  }
        		  }
            
        }//if
        
		$query_insfechaordenpago = "insert into fechaordenpago(numeroordenpago,fechaordenpago,porcentajefechaordenpago,valorfechaordenpago)
		VALUES('$numeroordenpago','".$row_fecha['fechadetallefechafinanciera']."','".$row_fecha['porcentajedetallefechafinanciera']."','$totalconrecargo')";
		$insfechaordenpago = mysql_query($query_insfechaordenpago,$sala) or die("$query_insfechaordenpago");
		//echo "<h5>$query_insfechaordenpago</h5>";
	}
}
else
{
    if($fechapago=='' || $fechapago==Null || $fechapago=='0000-00-00'){
            
            
            $mensaje = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Reporte de resultados</title>
		
	</head>
<body>
<br> Error Numero 2<br><br>
$codigocarreraantes->'.$codigocarreraantes.'
<br>$codigoperiodo->'.$codigoperiodo.'
<br>$idsubperiodo->'.$idsubperiodo.'
<br>$numeroordenpago->'.$numeroordenpago.'
<br>$query_fecha->'.$query_fecha.'
<br>Insert'.$query_insfechaordenpago = "insert into fechaordenpago(numeroordenpago,fechaordenpago,porcentajefechaordenpago,valorfechaordenpago)
	VALUES('$numeroordenpago','$fechapago','0','$totalvalormatricula')".'
</body>
</html>';
            
            /*$destinatarios = array();*/
        	$destinatarios = array("Marcos Ramirez <ramirezmarcos@unbosque.edu.co>");
        	
        	foreach($destinatarios as $destinatario){
        	
        	$asunto = "Informe de Malparides del Codigo ".date('d-m-Y h:i:s A');
            //$destinatario = "Leyla Bonilla <bonillaleyla@unbosque.edu.co>";
            //$headers = "From: no-responder@unbosque.edu.co \r\n";
                
                // Para enviar un correo HTML mail, la cabecera Content-type debe fijarse
                $cabeceras  = 'MIME-Version: 1.0' . "\r\n";
                //$cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                $cabeceras .= 'Content-type: text/html; charset=UTF-8' . "\r\n";        
        
                // Cabeceras adicionales
                //$cabeceras .= 'To: ' .$to. "\r\n";
                $cabeceras .= 'From: Tecnologia <it@unbosque.edu.co>' . "\r\n";
                //$cabeceras .= 'Cc: birthdayarchive@example.com' . "\r\n";
                //$cabeceras .= 'Bcc: birthdaycheck@example.com' . "\r\n";
                
        			  // Enviamos el mensaje
        			  if (mail($destinatario, $asunto, $mensaje, $cabeceras)) {
        					$aviso = "Su mensaje fue enviado.";
        					$succed = true;
        			  } else {
        					$aviso = "Error de envío.";
        					$succed = false;
        			  }
        		  }
            
        }//if
    
	 $query_insfechaordenpago = "insert into fechaordenpago(numeroordenpago,fechaordenpago,porcentajefechaordenpago,valorfechaordenpago)
	VALUES('$numeroordenpago','$fechapago','0','$totalvalormatricula')";
	// $query_insfechaordenpago;
	$insfechaordenpago = mysql_query($query_insfechaordenpago,$sala) or die("$query_insfechaordenpago");
}
}
else
{ 
	// Trae la fecha de fechacarreraconcepto
	$conceptoscursovacacional[] = $conceptocobroxcreditos;
	$fechapago2 = $orden->tomar_fechaconceptosbd($conceptoscursovacacional);
    if($fechapago2 != '00-00-00') {
        $fechapago = $fechapago2;
    }
    //echo "<h1>ACA $fechapago2</h1>";
    //exit();
    
    if($fechapago=='' || $fechapago==Null || $fechapago=='0000-00-00'){
            
            
            $mensaje = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Reporte de resultados</title>
		
	</head>
<body>
<br> Error Numero 3<br><br>
<br>conceptoscursovacacional->'.var_dump($conceptoscursovacacional).'<br>
$codigocarreraantes->'.$codigocarreraantes.'
<br>$codigoperiodo->'.$codigoperiodo.'
<br>$idsubperiodo->'.$idsubperiodo.'
<br>$numeroordenpago->'.$numeroordenpago.'
<br>$fechapago2->'.$fechapago2.'
<br>$query_fecha->'.$query_fecha.'
<br>Insert'.$query_insfechaordenpago = "insert into fechaordenpago(numeroordenpago,fechaordenpago,porcentajefechaordenpago,valorfechaordenpago)
	VALUES('$numeroordenpago','$fechapago','0','$totalvalormatricula')".'
</body>
</html>';
            
            /*$destinatarios = array();*/
        	$destinatarios = array("Marcos Ramirez <ramirezmarcos@unbosque.edu.co>");
        	
        	foreach($destinatarios as $destinatario){
        	
        	$asunto = "Informe de Malparides del Codigo ".date('d-m-Y h:i:s A');
            //$destinatario = "Leyla Bonilla <bonillaleyla@unbosque.edu.co>";
            //$headers = "From: no-responder@unbosque.edu.co \r\n";
                
                // Para enviar un correo HTML mail, la cabecera Content-type debe fijarse
                $cabeceras  = 'MIME-Version: 1.0' . "\r\n";
                //$cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                $cabeceras .= 'Content-type: text/html; charset=UTF-8' . "\r\n";        
        
                // Cabeceras adicionales
                //$cabeceras .= 'To: ' .$to. "\r\n";
                $cabeceras .= 'From: Tecnologia <it@unbosque.edu.co>' . "\r\n";
                //$cabeceras .= 'Cc: birthdayarchive@example.com' . "\r\n";
                //$cabeceras .= 'Bcc: birthdaycheck@example.com' . "\r\n";
                
        			  // Enviamos el mensaje
        			  if (mail($destinatario, $asunto, $mensaje, $cabeceras)) {
        					$aviso = "Su mensaje fue enviado.";
        					$succed = true;
        			  } else {
        					$aviso = "Error de envío.";
        					$succed = false;
        			  }
        		  }
            
        }//if
    
	$query_insfechaordenpago = "insert into fechaordenpago(numeroordenpago,fechaordenpago,porcentajefechaordenpago,valorfechaordenpago)
	VALUES('$numeroordenpago','$fechapago','0','$totalvalormatricula')";
	//echo $query_insfechaordenpago;
	$insfechaordenpago = mysql_query($query_insfechaordenpago,$sala) or die("$query_insfechaordenpago");
}
}
else
{
	$query_detalleprematricula = "update detalleprematricula
	set numeroordenpago = '$numerorodenpagoplandepagosap'
	where idprematricula = '$idprematricula'
	and numeroordenpago = '$numeroordenpago'";
	$detalleprematricula=mysql_db_query($database_sala,$query_detalleprematricula) or die("$query_detalleprematricula".mysql_error());


     if($fechapago=='' || $fechapago==Null || $fechapago=='0000-00-00'){
            
            
            $mensaje = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Reporte de resultados</title>
		
	</head>
<body>
<br> Error Numero 4<br><br>
$codigocarreraantes->'.$codigocarreraantes.'
<br>$codigoperiodo->'.$codigoperiodo.'
<br>$idsubperiodo->'.$idsubperiodo.'
<br>$numeroordenpago->'.$numeroordenpago.'
<br>$query_fecha->'.$query_fecha.'
<br>Insert'.$query_insfechaordenpago = "insert into fechaordenpago(numeroordenpago,fechaordenpago,porcentajefechaordenpago,valorfechaordenpago)
	VALUES('$numeroordenpago','$fechapago','0','$totalvalormatricula')".'
</body>
</html>';
            
            /*$destinatarios = array();*/
        	$destinatarios = array("Marcos Ramirez <ramirezmarcos@unbosque.edu.co>");
        	
        	foreach($destinatarios as $destinatario){
        	
        	$asunto = "Informe de Malparides del Codigo ".date('d-m-Y h:i:s A');
            //$destinatario = "Leyla Bonilla <bonillaleyla@unbosque.edu.co>";
            //$headers = "From: no-responder@unbosque.edu.co \r\n";
                
                // Para enviar un correo HTML mail, la cabecera Content-type debe fijarse
                $cabeceras  = 'MIME-Version: 1.0' . "\r\n";
                //$cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                $cabeceras .= 'Content-type: text/html; charset=UTF-8' . "\r\n";        
        
                // Cabeceras adicionales
                //$cabeceras .= 'To: ' .$to. "\r\n";
                $cabeceras .= 'From: Tecnologia <it@unbosque.edu.co>' . "\r\n";
                //$cabeceras .= 'Cc: birthdayarchive@example.com' . "\r\n";
                //$cabeceras .= 'Bcc: birthdaycheck@example.com' . "\r\n";
                
        			  // Enviamos el mensaje
        			  if (mail($destinatario, $asunto, $mensaje, $cabeceras)) {
        					$aviso = "Su mensaje fue enviado.";
        					$succed = true;
        			  } else {
        					$aviso = "Error de envío.";
        					$succed = false;
        			  }
        		  }
            
        }//if
    

	$query_insfechaordenpago = "insert into fechaordenpago(numeroordenpago,fechaordenpago,porcentajefechaordenpago,valorfechaordenpago)
	VALUES('$numeroordenpago','$fechapago','0','$totalvalormatricula')";
	//echo $query_insfechaordenpago;
	$insfechaordenpago = mysql_query($query_insfechaordenpago,$sala) or die("$query_insfechaordenpago");

}
//COMMIT;
$query_banco = "SELECT c.idcuentabanco
FROM cuentabanco c, banco b
WHERE c.codigocarrera = '$codigocarrera'
AND c.codigobanco = b.codigobanco
AND c.codigoperiodo = '$codigoperiodo'";
$banco = mysql_db_query($database_sala, $query_banco);
$totalRows_banco = mysql_num_rows($banco);
if ($totalRows_banco == "")
{
	$query_banco = "SELECT c.idcuentabanco
	FROM cuentabanco c, banco b
	WHERE  c.codigobanco = b.codigobanco
	AND c.codigoperiodo = '$codigoperiodo'
	AND codigocarrera = '1'";
 	$banco = mysql_db_query($database_sala, $query_banco);
}
while($row_banco = mysql_fetch_array($banco))
{
	$query_insordenpago = "insert into cuentabancoordenpago(numeroordenpago,idcuentabanco)
	VALUES('$numeroordenpago','".$row_banco['idcuentabanco']."')";
	$insordenpago = mysql_query($query_insordenpago, $sala) or die("$query_insordenpago");
}

//exit();
//echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=ordenmatricula.php'>";
?>
