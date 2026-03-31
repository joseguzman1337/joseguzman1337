<?php
// Primero necesito datos del estudiante, centro de costo, orden de pago y carrera
$query_datosestudiante= "select e.idestudiantegeneral, d.tipodocumento, eg.numerodocumento, o.numeroordenpago, d.nombrecortodocumento,
concat(eg.apellidosestudiantegeneral,' ',eg.nombresestudiantegeneral) as nombre, e.codigoestudiante, p.semestreprematricula, 
o.codigoperiodo, c.codigosucursal, c.centrocosto, c.nombrecarrera, e.codigotipoestudiante, c.codigocarrera, 
o.codigoimprimeordenpago, i.nombreimprimeordenpago, co.nombrecopiaordenpago
from estudiante e, ordenpago o, prematricula p, carrera c, documento d, imprimeordenpago i, copiaordenpago co, estudiantegeneral eg
where e.codigoestudiante = o.codigoestudiante
and o.numeroordenpago = '$numeroordenpago'
and p.idprematricula = o.idprematricula
and e.codigocarrera = c.codigocarrera
and d.tipodocumento = eg.tipodocumento
and o.codigoimprimeordenpago = i.codigoimprimeordenpago
and o.codigocopiaordenpago = co.codigocopiaordenpago
and e.idestudiantegeneral = eg.idestudiantegeneral";
$datosestudiante=mysql_db_query($database_sala,$query_datosestudiante) or die("$query_datosestudiante".mysql_error());
$totalRows_datosestudiante= mysql_num_rows($datosestudiante);
if($totalRows_datosestudiante == "")
{
	echo "No Presenta Orden de Pago";
}
else
{
	$row_datosestudiante=mysql_fetch_array($datosestudiante);
	
	// Este codigo es provisional ya que muestra el codigo anterior del estudiante
	$query_selcodigo= "select e.numerodocumento as codigo
	from estudiantedocumento e
	where e.tipodocumento = '08'
	and e.idestudiantegeneral = '".$row_datosestudiante['idestudiantegeneral']."'";
	$selcodigo = mysql_db_query($database_sala,$query_selcodigo) or die("$query_selcodigo".mysql_error());
	$totalRows_selcodigo = mysql_num_rows($selcodigo);
	if($totalRows_selcodigo != "")
	{
		// Espacio vertical de las materias
		$row_selcodigo = mysql_fetch_array($selcodigo);
		$row_datosestudiante['codigoestudiante'] = $row_selcodigo['codigo'];
	}
	$codigoestudiante = $row_datosestudiante['codigoestudiante'];
	$codigoestudiante = $row_datosestudiante['idestudiantegeneral'];
	
	$row_datosestudiante['codigoestudiante'] = $row_datosestudiante['idestudiantegeneral'];
	//////////////////////////////
	
	/*$query_pazysalvo = "select p.idpazysalvoestudiante
	from pazysalvoestudiante p, detallepazysalvoestudiante d
	where p.codigoestudiante = '".$row_datosestudiante['codigoestudiante']."'
	and p.idpazysalvoestudiante = d.idpazysalvoestudiante
	and d.codigoestadopazysalvoestudiante like '1%'";
	$pazysalvo = mysql_db_query($database_sala,$query_pazysalvo) or die("$query_pazysalvo");
	$totalRows_pazysalvo = mysql_num_rows($pazysalvo);
	$row_pazysalvo = mysql_fetch_array($pazysalvo);
	*/
	fputs($archivo," !R! UNIT C;CSET 8U;CALL UB2;MZP 3,0;FONT 6;EXIT;\n");
	fputs($archivo,"\n");
	fputs($archivo,"\n");
	fputs($archivo,"\n");
	//////////////////////////////////////////////////////////////////
	//																//
	//		PPRIMERA PARTE											//
	//////////////////////////////////////////////////////////////////
	
	/*if($totalRows_pazysalvo != "")
	{
		fputs($archivo,"!R! CALL TIT9,9.7,1.2, DEUDA ;EXIT;");
	}*/
	$cabecera1v = "1.75";
	fputs($archivo,"!R! CALL TITU,2.1,$cabecera1v, ".$row_datosestudiante['codigoestudiante']." ;EXIT; !R! CALL TITU,4.5,$cabecera1v, ".$row_datosestudiante['semestreprematricula']." ;EXIT; !R! CALL TITU,7,$cabecera1v, ".$row_datosestudiante['codigoperiodo']." ;EXIT; !R! CALL TITU,9.5,$cabecera1v, ".$row_datosestudiante['nombrecortodocumento']." ".$row_datosestudiante['numerodocumento']." ;EXIT; !R! CALL TIT9,16,$cabecera1v,".$row_datosestudiante['numeroordenpago']." ;EXIT;");
	$cabecera2v = "2.15";
	$programa = $row_datosestudiante['codigosucursal']."-".$row_datosestudiante['centrocosto']." ".$row_datosestudiante['nombrecarrera'];
	fputs($archivo,"!R! CALL TITU,4,$cabecera2v, ".$row_datosestudiante['nombre']." ;EXIT; !R! CALL TITU,14,$cabecera2v, $programa ;EXIT;");
	
	// Materias Inscritas
	$query_datosmaterias= "select d.codigomateria, m.nombremateria
	from detalleprematricula d, materia m
	where d.numeroordenpago = '$numeroordenpago'
	and (d.codigoestadodetalleprematricula like '1%')
	and m.codigomateria = d.codigomateria";
	$datosmaterias = mysql_db_query($database_sala,$query_datosmaterias) or die("$query_datosmaterias".mysql_error());
	$totalRows_datosmaterias = mysql_num_rows($datosmaterias);
	if($totalRows_datosmaterias != "")
	{
		// Espacio vertical de las materias
		$espaciovmaterias = 2.85;
		while($row_datosmaterias = mysql_fetch_array($datosmaterias))
		{
			// Toca contar los numeros de cada valor y de acuerdo a eso cuadrar los espacios horizontales
			fputs($archivo,"!R! CALL TITU,13,$espaciovmaterias, ".$row_datosmaterias['codigomateria']."  ".$row_datosmaterias['nombremateria']." ;EXIT;");
			$espaciovmaterias = $espaciovmaterias + 0.4;
		}
	}
	else
	{
		$espaciovmaterias = 2.85;
		fputs($archivo,"!R! CALL TITU,13,$espaciovmaterias, SEÃOR ESTUDIANTE USTED DEBE: ;EXIT;");
		$espaciovmaterias = $espaciovmaterias + 0.4;
		fputs($archivo,"!R! CALL TITU,13,$espaciovmaterias, INSCRIBIR ASIGNATURAS CON SUS;EXIT;");
		$espaciovmaterias = $espaciovmaterias + 0.4;
		fputs($archivo,"!R! CALL TITU,13,$espaciovmaterias, RESPECTIVOS GRUPOS Y HORARIOS. ;EXIT;");
		$espaciovmaterias = $espaciovmaterias + 0.4;
		fputs($archivo,"!R! CALL TITU,13,$espaciovmaterias, ESTO PUEDE GENERAR UN EXCEDENTE A PAGAR ;EXIT;");
		$espaciovmaterias = $espaciovmaterias + 0.4;
		fputs($archivo,"!R! CALL TITU,13,$espaciovmaterias, POR MAYORES CREDITOS ACADEMICOS ;EXIT;");
		$espaciovmaterias = $espaciovmaterias + 0.4;
		fputs($archivo,"!R! CALL TITU,13,$espaciovmaterias, SELECCIONADOS O POR REASIGNACION ;EXIT;");
		$espaciovmaterias = $espaciovmaterias + 0.4;
		fputs($archivo,"!R! CALL TITU,13,$espaciovmaterias, DE COHORTE. ;EXIT;");
		$espaciovmaterias = $espaciovmaterias + 0.4;
		fputs($archivo,"!R! CALL TITU,13,$espaciovmaterias, EL SEMESTRE ASIGNADO SE ACTUALIZARA  ;EXIT;");
		$espaciovmaterias = $espaciovmaterias + 0.4;
		fputs($archivo,"!R! CALL TITU,13,$espaciovmaterias, CON LA INSCRIPCION DE ASIGNATURAS. ;EXIT;");
	}
			
	// Descripciones de los pagos
	$query_datosdetalles= "select d.codigoconcepto, c.nombreconcepto, d.valorconcepto, d.cantidaddetalleordenpago
	from detalleordenpago d, concepto c
	where d.numeroordenpago = '$numeroordenpago'
	and d.codigoconcepto = c.codigoconcepto";
	$datosdetalles = mysql_db_query($database_sala,$query_datosdetalles) or die("$query_datosdetalles".mysql_error());
	$totalRows_datosdetalles = mysql_num_rows($datosdetalles);
	if($totalRows_datosdetalles == "")
	{
		echo "No Presenta Detalles de Orden de Pago";
	}
	else
	{
		// Espacio vertical de los detalles
		$espaciovdetalles = 2.85;
		while($row_datosdetalles = mysql_fetch_array($datosdetalles))
		{
			$tamaÃ±onumero = strlen($row_datosdetalles['valorconcepto']);
			switch($tamaÃ±onumero)
			{
				// Por numero 0.125
				// Por punto 0.1
				case 1 :
					// 1
					$inicionumero = "11.05";
					break;
				case 2 :
					// 10
					$inicionumero = "10.925";
					break;
				case 3 :
					// 100
					$inicionumero = "10.8";
					break;
				case 4 :
					// 1.000
					$inicionumero = "10.575";
					break;
				case 5 :
					// 10.000
					$inicionumero = "10.45";
					break;
				case 6 :
					// 100.000
					$inicionumero = "10.325";
					break;
				case 7 :
					// 1.000.000
					$inicionumero = "10.1";
					break;
				case 8 :
					// 10.000.000
					$inicionumero = "9.975";
					break;
			}
			// Toca contar los numeros de cada valor y de acuerdo a eso cuadrar los espacios horizontales
			fputs($archivo,"!R! CALL TITU,1,$espaciovdetalles, ".$row_datosdetalles['nombreconcepto']." ;EXIT; !R! CALL TITU,4,$espaciovdetalles, ".$row_datosdetalles['cantidaddetalleordenpago']." ;EXIT; !R! CALL TITU,$inicionumero,$espaciovdetalles, ".number_format($row_datosdetalles['valorconcepto'],2,".",".")." ;EXIT;");
			$espaciovdetalles = $espaciovdetalles + 0.3;
		}
		
		// Fechas de los pagos
		$query_datosfechas= "select f.fechaordenpago, f.valorfechaordenpago
		from fechaordenpago f
		where f.numeroordenpago = '$numeroordenpago'
		order by fechaordenpago";
		$datosfechas = mysql_db_query($database_sala,$query_datosfechas) or die("$query_datosfechas".mysql_error());
		$totalRows_datosfechas = mysql_num_rows($datosfechas);
		if($totalRows_datosfechas == "")
		{
			echo "No Presenta Fechas de Orden de Pago";
		}
		else
		{
			// Espacio vertical de los detalles
			$espaciovfechas = 7.55;
			$cuentafechas = 1;
			while($row_datosfechas = mysql_fetch_array($datosfechas))
			{
				switch($cuentafechas)
				{
					case "1":
						$nombreplazo = "PAGO OPORTUNO HASTA: ";
						$pagototal = number_format($row_datosfechas['valorfechaordenpago'],2,".",".");
						break;
					case "2":
						$nombreplazo = "2DO VENCIMIENTO HASTA: ";
						break;
					case "3":
						$nombreplazo = "3ER VENCIMIENTO HASTA: ";
						break;
					case "4":
						$nombreplazo = "CUARTO VENCIMIENTO HASTA";
						break;
					case "5":
						$nombreplazo = "QUINTO VENCIMIENTO HASTA";
						break;
				}
				$tamaÃ±onumero = strlen($row_datosfechas['valorfechaordenpago']);
				switch($tamaÃ±onumero)
				{
					// Por numero 0.125
					// Por punto 0.1
					case 1 :
						// 1
						$inicionumero = "11.05";
						break;
					case 2 :
						// 10
						$inicionumero = "10.925";
						break;
					case 3 :
						// 100
						$inicionumero = "10.8";
						break;
					case 4 :
						// 1.000
						$inicionumero = "10.575";
						break;
					case 5 :
						// 10.000
						$inicionumero = "10.45";
						break;
					case 6 :
						// 100.000
						$inicionumero = "10.325";
						break;
					case 7 :
						// 1.000.000
						$inicionumero = "10.1";
						break;
					case 8 :
						// 10.000.000
						$inicionumero = "9.975";
						break;
				}
				
				if($cuentafechas <= 3)
				{
					// Toca contar los numeros de cada valor y de acuerdo a eso cuadrar los espacios horizontales
					fputs($archivo,"!R! CALL TITU,1,$espaciovfechas, $nombreplazo ;EXIT; !R! CALL TITU,5.2,$espaciovfechas, ".$row_datosfechas['fechaordenpago']." ;EXIT; !R! CALL TITU,7.15,$espaciovfechas, LA SUMA DE ;EXIT; !R! CALL TITU,$inicionumero,$espaciovfechas, ".number_format($row_datosfechas['valorfechaordenpago'],2,".",".")." ;EXIT;");
					$espaciovfechas = $espaciovfechas + 0.4;
				}
				$cuentafechas++;
			}
			
			// Aqui va si la orden es original o copia
			fputs($archivo,"!R! CALL TITU,18.1,8.35, ".$row_datosestudiante['nombrecopiaordenpago']." ;EXIT;");
		
			//////////////////////////////////////////////////////////////////
			//																//
			//		SEGUNDA PARTE											//
			//////////////////////////////////////////////////////////////////
				
			/*if($totalRows_pazysalvo != "")
			{
				fputs($archivo,"!R! CALL TIT9,9.7,10.0, DEUDA ;EXIT;");
			}*/
			$cabecera1v = "10.55";
			fputs($archivo,"!R! CALL TITU,2.1,$cabecera1v, ".$row_datosestudiante['codigoestudiante']." ;EXIT; !R! CALL TITU,4.5,$cabecera1v, ".$row_datosestudiante['semestreprematricula']." ;EXIT; !R! CALL TITU,7,$cabecera1v, ".$row_datosestudiante['codigoperiodo']." ;EXIT; !R! CALL TITU,9.5,$cabecera1v, ".$row_datosestudiante['nombrecortodocumento']." ".$row_datosestudiante['numerodocumento']." ;EXIT; !R! CALL TIT9,16,$cabecera1v,".$row_datosestudiante['numeroordenpago']." ;EXIT;");
			$cabecera2v = "10.9";
			$programa = $row_datosestudiante['codigosucursal']."-".$row_datosestudiante['centrocosto']." ".$row_datosestudiante['nombrecarrera'];
			fputs($archivo,"!R! CALL TITU,4,$cabecera2v, ".$row_datosestudiante['nombre']." ;EXIT; !R! CALL TITU,14,$cabecera2v, $programa ;EXIT;");
			
			fputs($archivo,"!R! CALL TITU,1,11.8, PAGO TOTAL: ;EXIT; !R! CALL TITU,10.1,11.8, $pagototal ;EXIT;");
					
			// Espacio vertical de las fechas
			$espaciovfechas = 12.2;
			$query_datosfechas= "select f.fechaordenpago, f.valorfechaordenpago
			from fechaordenpago f
			where f.numeroordenpago = '$numeroordenpago'
			order by fechaordenpago";
			$datosfechas = mysql_db_query($database_sala,$query_datosfechas) or die("$query_datosfechas".mysql_error());
			$cuentafechas = 1;
			while($row_datosfechas = mysql_fetch_array($datosfechas))
			{
				switch($cuentafechas)
				{
					case "1":
						$nombreplazo = "PAGO OPORTUNO HASTA: ";
						break;
					case "2":
						$nombreplazo = "2DO VENCIMIENTO HASTA: ";
						break;
					case "3":
						$nombreplazo = "3ER VENCIMIENTO HASTA: ";
						break;
					case "4":
						$nombreplazo = "CUARTO VENCIMIENTO HASTA";
						break;
					case "5":
						$nombreplazo = "QUINTO VENCIMIENTO HASTA";
						break;
				}
				$tamaÃ±onumero = strlen($row_datosfechas['valorfechaordenpago']);
				switch($tamaÃ±onumero)
				{
					// Por numero 0.125
					// Por punto 0.1
					case 1 :
						// 1
						$inicionumero = "11.05";
						break;
					case 2 :
						// 10
						$inicionumero = "10.925";
						break;
					case 3 :
						// 100
						$inicionumero = "10.8";
						break;
					case 4 :
						// 1.000
						$inicionumero = "10.575";
						break;
					case 5 :
						// 10.000
						$inicionumero = "10.45";
						break;
					case 6 :
						// 100.000
						$inicionumero = "10.325";
						break;
					case 7 :
						// 1.000.000
						$inicionumero = "10.1";
						break;
					case 8 :
						// 10.000.000
						$inicionumero = "9.975";
						break;
				}
				
				if($cuentafechas <= 3)
				{
					// Toca contar los numeros de cada valor y de acuerdo a eso cuadrar los espacios horizontales
					fputs($archivo,"!R! CALL TITU,1,$espaciovfechas, $nombreplazo ;EXIT; !R! CALL TITU,5.2,$espaciovfechas, ".$row_datosfechas['fechaordenpago']." ;EXIT; !R! CALL TITU,7.15,$espaciovfechas, LA SUMA DE ;EXIT; !R! CALL TITU,$inicionumero,$espaciovfechas, ".number_format($row_datosfechas['valorfechaordenpago'],2,".",".")." ;EXIT;\n");
					$espaciovfechas = $espaciovfechas + 0.4;
				}
				$cuentafechas++;
			}
			
			// Aqui va si la orden es original o copia
			fputs($archivo,"!R! CALL TITU,18.1,13.2, ".$row_datosestudiante['nombrecopiaordenpago']." ;EXIT;");
		
			//////////////////////////////////////////////////////////////////
			//																//
			//		TERCERA PARTE											//
			//////////////////////////////////////////////////////////////////
	
			/*if($totalRows_pazysalvo != "")
			{
				fputs($archivo,"!R! CALL TIT9,9.7,14.60, DEUDA ;EXIT;");
			}*/
			$cabecera1v = "15.15";
			fputs($archivo,"!R! CALL TITU,2.1,$cabecera1v, ".$row_datosestudiante['codigoestudiante']." ;EXIT; !R! CALL TITU,4.5,$cabecera1v, ".$row_datosestudiante['semestreprematricula']." ;EXIT; !R! CALL TITU,7,$cabecera1v, ".$row_datosestudiante['codigoperiodo']." ;EXIT; !R! CALL TITU,9.5,$cabecera1v, ".$row_datosestudiante['nombrecortodocumento']." ".$row_datosestudiante['numerodocumento']." ;EXIT; !R! CALL TIT9,16,$cabecera1v,".$row_datosestudiante['numeroordenpago']." ;EXIT;");
			$cabecera2v = "15.5";
			$programa = $row_datosestudiante['codigosucursal']."-".$row_datosestudiante['centrocosto']." ".$row_datosestudiante['nombrecarrera'];
			fputs($archivo,"!R! CALL TITU,4,$cabecera2v, ".$row_datosestudiante['nombre']." ;EXIT; !R! CALL TITU,14,$cabecera2v, $programa ;EXIT;");
			
			fputs($archivo,"!R! CALL TITU,1,16.4, PAGO TOTAL: ;EXIT; !R! CALL TITU,10.1,16.4, $pagototal ;EXIT;");
			
			// Espacio vertical de las fechas
			$espaciovfechas = 16.8;
			$query_datosfechas= "select f.fechaordenpago, f.valorfechaordenpago
			from fechaordenpago f
			where f.numeroordenpago = '$numeroordenpago'
			order by fechaordenpago";
			$datosfechas = mysql_db_query($database_sala,$query_datosfechas) or die("$query_datosfechas".mysql_error());
			$cuentafechas = 1;
			while($row_datosfechas = mysql_fetch_array($datosfechas))
			{
				switch($cuentafechas)
				{
					case "1":
						$nombreplazo = "PAGO OPORTUNO HASTA: ";
						break;
					case "2":
						$nombreplazo = "2DO VENCIMIENTO HASTA: ";
						break;
					case "3":
						$nombreplazo = "3ER VENCIMIENTO HASTA: ";
						break;
					case "4":
						$nombreplazo = "CUARTO VENCIMIENTO HASTA";
						break;
					case "5":
						$nombreplazo = "QUINTO VENCIMIENTO HASTA";
						break;
				}
				$tamaÃ±onumero = strlen($row_datosfechas['valorfechaordenpago']);
				switch($tamaÃ±onumero)
				{
					// Por numero 0.125
					// Por punto 0.1
					case 1 :
						// 1
						$inicionumero = "11.05";
						break;
					case 2 :
						// 10
						$inicionumero = "10.925";
						break;
					case 3 :
						// 100
						$inicionumero = "10.8";
						break;
					case 4 :
						// 1.000
						$inicionumero = "10.575";
						break;
					case 5 :
						// 10.000
						$inicionumero = "10.45";
						break;
					case 6 :
						// 100.000
						$inicionumero = "10.325";
						break;
					case 7 :
						// 1.000.000
						$inicionumero = "10.1";
						break;
					case 8 :
						// 10.000.000
						$inicionumero = "9.975";
						break;
				}
				
				if($cuentafechas <= 3)
				{
					// Toca contar los numeros de cada valor y de acuerdo a eso cuadrar los espacios horizontales
					fputs($archivo,"!R! CALL TITU,1,$espaciovfechas, $nombreplazo ;EXIT; !R! CALL TITU,5.2,$espaciovfechas, ".$row_datosfechas['fechaordenpago']." ;EXIT; !R! CALL TITU,7.15,$espaciovfechas, LA SUMA DE ;EXIT; !R! CALL TITU,$inicionumero,$espaciovfechas, ".number_format($row_datosfechas['valorfechaordenpago'],2,".",".")." ;EXIT;");
					$espaciovfechas = $espaciovfechas + 0.4;
				}
				$cuentafechas++;
			}// Aqui va si la orden es original o copia
			fputs($archivo,"!R! CALL TITU,18.1,17.45, ".$row_datosestudiante['nombrecopiaordenpago']." ;EXIT;");
		
			//////////////////////////////////////////////////////////////////
			//																//
			//		CUARTA PARTE											//
			//////////////////////////////////////////////////////////////////
	
			/*if($totalRows_pazysalvo != "")
			{
				fputs($archivo,"!R! CALL TIT9,9.7,18.63, DEUDA ;EXIT;");
			}*/
			$codigoreferencia = "";
				
			fputs($archivo,"!R! FONT 6;EXIT;!R! FONT 16;EXIT;");
			fputs($archivo,"!R! CALL TITU,2.3,19.25, ".$row_datosestudiante['codigoestudiante']." ;EXIT; !R! CALL TITU,4.5,19.25, ".$row_datosestudiante['semestreprematricula']." ;EXIT; !R! CALL TITU,7,19.25, ".$row_datosestudiante['codigoperiodo']." ;EXIT; !R! CALL TITU,9.5,19.25, ".$row_datosestudiante['nombrecortodocumento']." ".$row_datosestudiante['numerodocumento']." ;EXIT;");
			fputs($archivo,"\n");
			
			fputs($archivo,"!R! CALL TITU,4,19.8, ".$row_datosestudiante['nombre']." ;EXIT; !R! CALL TIT9,16,19.8,".$row_datosestudiante['numeroordenpago']." ;EXIT;");
			if(ereg("^1[0-9]*$",$row_datosestudiante['codigotipoestudiante']))
			{
				$tipoestudiante = 0;
			}
			else
			{
				$tipoestudiante = 1;
			}
			// El codigo del estudiante contarlo si es menor que 8 completarlo con ceros a la izquierda
			$row_datosestudiante['codigoestudiante'] = $codigoestudiante;
			$tamaÃ±ocodigo = strlen($row_datosestudiante['codigoestudiante']);
			if($tamaÃ±ocodigo < 8)
			{
				$codigoreferencia = "";
				for($i=$tamaÃ±ocodigo; $i < 8; $i++)
				{
					$codigoreferencia = $codigoreferencia."0";
				}
			}
			if($row_datosestudiante['semestreprematricula'] < 10)
			{
				$semestrereferencia = "0".$row_datosestudiante['semestreprematricula'];
			}
			else
			{
				$semestrereferencia = $row_datosestudiante['semestreprematricula'];
			}
			$codigoreferencia = $codigoreferencia.$row_datosestudiante['codigoestudiante'];
			//$referencia = "$tipoestudiante".$row_datosestudiante['codigosucursal'].$semestrereferencia.$codigoreferencia.$row_datosestudiante['numeroordenpago'];
			$referencia = "00000".$codigoreferencia.$row_datosestudiante['numeroordenpago'];
			fputs($archivo,"!R! CALL TITU,4,20.3, $programa ;EXIT; !R! CALL TIT9,15,20.3, $referencia ;EXIT;");
			
			$query_datosfechas= "select f.fechaordenpago, f.valorfechaordenpago
			from fechaordenpago f
			where f.numeroordenpago = '$numeroordenpago'
			order by fechaordenpago";
			$datosfechas = mysql_db_query($database_sala,$query_datosfechas) or die("$query_datosfechas".mysql_error());
			// Espacio vertical de las fechas
			$cuentafechas = 1;
			while($row_datosfechas = mysql_fetch_array($datosfechas))
			{
				switch($cuentafechas)
				{
					case "1":
						$nombreplazo = "PRIMER PLAZO";
						$espaciovplazo = 20.65;
						$espaciovbarra = 21.0;
						$espaciovtitu = 22.3;
						break;
					case "2":
						$nombreplazo = "SEGUNDO PLAZO";
						$espaciovplazo = 22.70;
						$espaciovbarra = 23.0;
						$espaciovtitu = 24.3;
						break;
					case "3":
						$nombreplazo = "TERCER PLAZO";
						$espaciovplazo = 24.77;
						$espaciovbarra = 25.2;
						$espaciovtitu = 26.5;
						break;
					case "4":
						$nombreplazo = "CUARTO PLAZO";
						$espaciovplazo = 24.77;
						$espaciovbarra = 27.2;
						$espaciovtitu = 28.5;
						break;
					case "5":
						$nombreplazo = "QUINTO PLAZO";
						$espaciovplazo = 24.77;
						$espaciovbarra = 29.2;
						$espaciovtitu = 30.5;
						break;
				}
				if($cuentafechas <= 3)
				{
					// Toca contar los numeros de cada valor y de acuerdo a eso cuadrar los espacios horizontales
					fputs($archivo,"!R! CALL TITU,1.8,$espaciovplazo, $nombreplazo ;EXIT; !R! CALL TITU,5.5,$espaciovplazo, ".$row_datosfechas['fechaordenpago']."  $ ".number_format($row_datosfechas['valorfechaordenpago'],2,".",".")." ;EXIT;\n");
				}
				
				// Ojo al valor del pago ponerle ceros cuando sea necesario
				$tamaÃ±ovalor = strlen($row_datosfechas['valorfechaordenpago']);
				//echo "<br>$tamaÃ±ovalor<br>";
				if($tamaÃ±ovalor < 8)
				{
					$valorfechareferencia = "";
					for($i=$tamaÃ±ovalor; $i < 8; $i++)
					{
						$valorfechareferencia = $valorfechareferencia."0";
					}
				}
				$valorfechareferencia = $valorfechareferencia.$row_datosfechas['valorfechaordenpago'];
				
				//echo $valorfechareferencia;			
				$codigobarra = "41577099980017018020"."$referencia"."@86"."3900"."$valorfechareferencia"."@86"."96".ereg_replace("-","",$row_datosfechas['fechaordenpago']);
				fputs($archivo,"!R! CALL BAR1,1.6,$espaciovbarra,42,$codigobarra,120,120,2.7,5.4,8.1,10.8;EXIT;\n");
				$titubarra = "(415)7709998001701(8020)"."$referencia"."(3900)"."$valorfechareferencia"."(96)".ereg_replace("-","",$row_datosfechas['fechaordenpago']);
				fputs($archivo,"!R! CALL TITU,1.4,$espaciovtitu,$titubarra;EXIT;\n");
				fputs($archivo,"\n");
				$cuentafechas++;
			}
			// Aqui va si la orden es original o copia
			fputs($archivo,"!R! CALL TITU,18.1,26.9, ".$row_datosestudiante['nombrecopiaordenpago']." ;EXIT;");
		}
	}
	//fputs($archivo," !R! PAGE;CALL UB88;EXIT;\n");
	fputs($archivo,"\n");
}

?>