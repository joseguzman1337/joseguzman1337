<?php
echo "<br>open.php<br>";

// Selecciona los datos del estudiante
$consulta1= "SELECT  eg.numerodocumento,p.codigoestudiante,o.numeroordenpago,d.valorconcepto,d.codigoconcepto,o.codigoimprimeordenpago,
c.centrocosto,c.codigosucursal,o.fechaordenpago,o.codigoestadoordenpago,co.codigotipoconcepto,o.observacionordenpago,p.semestreprematricula,
 eg.nombresestudiantegeneral, eg.apellidosestudiantegeneral, eg.telefonoresidenciaestudiantegeneral, eg.direccionresidenciaestudiantegeneral
FROM prematricula p,ordenpago o,detalleordenpago d, estudiante e,carrera c,concepto co,estudiantegeneral eg
WHERE p.codigoestudiante = o.codigoestudiante
AND e.codigoestudiante = p.codigoestudiante
AND o.numeroordenpago = '$numeroordenpago' 
AND e.idestudiantegeneral = eg.idestudiantegeneral			
AND p.idprematricula = o.idprematricula
AND o.numeroordenpago = d.numeroordenpago
AND e.codigocarrera = c.codigocarrera
AND d.codigoconcepto = co.codigoconcepto";
$solucion1=mysql_db_query($database_sala,$consulta1) or die(mysql_error());
$totalRows1= mysql_num_rows($solucion1);

if($totalRows1 == "")
{
	echo "No Presenta Orden de Pago";
//	echo "<META HTTP-EQUIV='Refresh' CONTENT='1; URL=generanuevaorden.php'>";
//	exit();	  
}
else 	
{//1 
	$nombre_temp = tempnam("","FOO");
	//echo $nombre_temp;
	/* $result=copy($nombre_temp, "mi_archivo.txt");
	echo $result; */
	$gestor = fopen($nombre_temp, "r+b");
	//fwrite($gestor,"numerodocumento,codigoestudiante,numeroordenpago,valorconcepto,codigoconcepto,codigoimprimeordenpago,semestreprematricula,centrocosto,codigosucursal,fecharealizaordenpago,fecha1,fecha2,fecha3,fecha4,fecha5,codigoactualizo,periodoacademico,codigotipoconcepto,codigoestadoordenpago,codigotipoorden,observacioordenpago\n");
	fwrite($gestor,"numerodocumento,codigoestudiante,numeroordenpago,valorconcepto,codigoconcepto,codigoimprimeordenpago,semestreprematricula,centrocosto,codigosucursal,fecharealizaordenpago,fecha1,fecha2,fecha3,fecha4,fecha5,codigoactualizo,periodoacademico,codigotipoconcepto,codigoestadoordenpago,codigotipoorden,observacioordenpago,nombresestudiante,apellidosestudiante,telefonoresidenciaestudiante,direccionresidenciaestudiante\n");
	while($respuesta1=mysql_fetch_array($solucion1))
	{
		$bandera =0;
		if ($respuesta1['codigoestadoordenpago'] == 10 or $respuesta1['codigoestadoordenpago'] == 11)
   		{ 
    		$estadoordenpago='01';
   		}
 		else
   		{
    		$estadoordenpago='03';
   		} 
		$seleccion2="SELECT * from descuentovsdeuda where codigoestudiante = '".$_SESSION['codigo']."'";
		$datos2=mysql_db_query($database_sala,$seleccion2);
		$registros2=mysql_fetch_array($datos2);
   
	   	if (!$registros2)
    	{
	   		$concepto=$respuesta1['codigoconcepto'];
		   	$actualizo = '01';
		   	$periodo = $_SESSION['codigoperiodosesion']; 
		}
   		else 
     	{	  
	  		do 
			{
        		if ($respuesta1['codigoconcepto'] == $registros2['codigoconcepto'] and $respuesta1['valorconcepto'] == $registros2['valordescuentovsdeuda'])
        		{
		 			$concepto=$respuesta1['codigoconcepto'];
					$actualizo = $registros2['codigoactualizo'];	
					$periodo = $registros2['codigoperiodo'];	
					$bandera =1;		
				}		
       	   }
		   while($registros2=mysql_fetch_array($datos2));
		   if($bandera == 0)
		   {
		  		$concepto=$respuesta1['codigoconcepto'];
	      		$actualizo = '01';	
		  		$periodo = $codigoperiodo; 	  
		   }	  
	  	}
		
		if($concepto == 151 or $concepto == 154 or $concepto == 165 or $concepto == 155)
  		{
    		$tipoconcepto = '010';
  		}  
		else
  		{
   			$tipoconcepto=0;
  		} 
		fwrite($gestor,"".$respuesta1['numerodocumento'].",");
		fwrite($gestor,"".$respuesta1['codigoestudiante'].",");
		fwrite($gestor,"".$respuesta1['numeroordenpago'].",");
		fwrite($gestor,"".$respuesta1['valorconcepto'].",");
		fwrite($gestor,"".$concepto.",");
		fwrite($gestor,"".$respuesta1['codigoimprimeordenpago'].",");
		fwrite($gestor,"".$respuesta1['semestreprematricula'].",");
		fwrite($gestor,"".$respuesta1['centrocosto'].",");
		fwrite($gestor,"".$respuesta1['codigosucursal'].",");
		fwrite($gestor,"".$respuesta1['fechaordenpago'].",");
		
		$query_fpago="select numeroordenpago, fechaordenpago as fechadeta, porcentajefechaordenpago, valorfechaordenpago 
		from fechaordenpago 
		where numeroordenpago = '$numeroordenpago' 
		order by porcentajefechaordenpago";
		//echo "$query_fpago";
		$fpago=mysql_db_query($database_sala,$query_fpago) or die(mysql_error());
		$cuenta = 0;
		while($row_fpago=mysql_fetch_array($fpago))
		{
        	//echo "<br>Fecha : ".$row_fpago['fechadeta']." <br>";
			$fechaspago = $row_fpago['fechadeta'];	
       		fwrite($gestor,"".$fechaspago.",");
			$cuenta++;
		}
		// Inserta las demas fechas en vacio si no existen mas, el total de fechas es 5
		for($i = $cuenta; $i < 5; $i++)
		{
			fwrite($gestor,"0,");
		}		
	   	fwrite($gestor,"".$actualizo.",");
		fwrite($gestor,"".$periodo.",");
		fwrite($gestor,"".$respuesta1['codigotipoconcepto'].",");
		fwrite($gestor,"".$estadoordenpago.",");
		fwrite($gestor,"".$tipoconcepto.",");
		fwrite($gestor,"".$respuesta1['observacionordenpago'].",");
		fwrite($gestor,"".$respuesta1['nombresestudiantegeneral'].",");
		fwrite($gestor,"".$respuesta1['apellidosestudiantegeneral'].",");
		fwrite($gestor,"".$respuesta1['telefonoresidenciaestudiantegeneral'].",");
		fwrite($gestor,"".$respuesta1['direccionresidenciaestudiantegeneral']."\n");
		
	}
	fclose($gestor);
	readfile($nombre_temp);
	
	//$servidor_ftp="200.31.79.244";
	/******************* COMENTAR *********************************/
	//exit();
	//$servidor_ftp="172.16.6.5";
	/*************************************************************/
	
	$nombre_usuario_ftp="archivonovasoft";
	$contrasenya_ftp="zbkPOW9jc2";
	
	// establecer una conexion basica
	$id_con = ftp_connect($servidor_ftp);
	
	// inicio de sesion con nombre de usuario y contrasenya
	$resultado_login = ftp_login($id_con, $nombre_usuario_ftp, $contrasenya_ftp); 
	
	$archivo_fuente=$nombre_temp;
	$archivo_destino="archivos/".$numeroordenpago.".txt";
	
	// cargar el archivo
	$carga = ftp_put($id_con, $archivo_destino , $archivo_fuente , FTP_BINARY); 
	
	ftp_close($id_con); 
	unlink($nombre_temp);
}
?>
