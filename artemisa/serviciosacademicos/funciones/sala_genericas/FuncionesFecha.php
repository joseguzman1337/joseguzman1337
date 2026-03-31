<?php 	
	//Cambia de formato fecha del tipo d/m/Y a Y-m-d de mysql
	function formato_fecha_mysql($fecha_esp){
	$yyyy=$fecha_esp[6].$fecha_esp[7].$fecha_esp[8].$fecha_esp[9];
	$mm=$fecha_esp[3].$fecha_esp[4];
	$dd=$fecha_esp[0].$fecha_esp[1];
	return $yyyy."-".$mm."-".$dd;
	}
	//Formato fecha por defecto del tipo mysql Y-m-d   a tipo d/m/Y
	function formato_fecha_defecto($fecha_esp){
	$yyyy=$fecha_esp[0].$fecha_esp[1].$fecha_esp[2].$fecha_esp[3];
	$mm=$fecha_esp[5].$fecha_esp[6];
	$dd=$fecha_esp[8].$fecha_esp[9];
	return $dd."/".$mm."/".$yyyy;
	}
	//Vacio fecha
	function fecha_vacia($fecha){
	if($fecha=="00/00/0000")
		return "";
	return $fecha;
	}
	//Dia final del mes 30-31-28-29
	function final_mes($mes,$yyyy=""){
	
	if($yyyy=="")
	$yyyy=date("Y");
	
		switch($mes){
		 case 2:
			if(($yyyy%4)==0)
				$no_dias=29;
			else
				$no_dias=28;
		 break;		
		
		default:
			if(($mes==1)||($mes==3)||($mes==5)||($mes==7)||($mes==8)||($mes==10)||($mes==12))
				$no_dias=31;
			else
				$no_dias=30;
		break; 
		 
		}
	return $no_dias;
	}
	//Retorna la fecha de formato dd/mm/yyyy a un vector con nombres dis,mes,anio
	function vector_fecha($fecha){
		$fechafinal["dia"]=$fecha[0].$fecha[1];	
		$fechafinal["mes"]=$fecha[3].$fecha[4];
		$fechafinal["anio"]=$fecha[6].$fecha[7].$fecha[8].$fecha[9];
		
		return $fechafinal;
	}
	//Retorna fecha del final del mes de una fecha en formato dd/mm/yyyy establecida
	function final_mes_fecha($fecha){
		$dd=$fecha[0].$fecha[1];	
		$mm=$fecha[3].$fecha[4];
		$yyyy=$fecha[6].$fecha[7].$fecha[8].$fecha[9];
		$final_mes=final_mes($mm,$yyyy);
		return $final_mes."/".$mm."/".$yyyy;
	}
	//Retorna fecha del final del mes de una fecha en formato dd/mm/yyyy establecida
	function inicio_mes_fecha($fecha){
		$dd=$fecha[0].$fecha[1];	
		$mm=$fecha[3].$fecha[4];
		$yyyy=$fecha[6].$fecha[7].$fecha[8].$fecha[9];
		//$final_mes=final_mes($mm,$yyyy);
		return "01/".$mm."/".$yyyy;
	}
	//Retorna el numero del mes siguiente
	function mes_siguiente($mes,$anio)
	{
		if($mes<12){
			$mesnuevo=$mes+1; $anionuevo=$anio;
			}
			else{
			$mesnuevo="01"; $anionuevo=$anio+1;
		}
		$fechanueva["mes"]=$mesnuevo;
		$fechanueva["anio"]=$anionuevo;
		return $fechanueva;
	}
	//Retorna el numero del mes anterior
	function mes_anterior($mes,$anio)
	{
		if(($mes-0)>1){
			$mesnuevo=$mes-1; $anionuevo=$anio;
			}
			else{
			$mesnuevo="12"; $anionuevo=$anio-1;
		}
		$fechanueva["mes"]=$mesnuevo;
		$fechanueva["anio"]=$anionuevo;
		return $fechanueva;
	}
	
	//valida que haya diferencia en un par de fechas
	function validar_diferencia_fechas($fechainicial,$fechafinal,$mensajetrue=0)
	{
	//echo "($fechainicial,$fechafinal,$mensaje=)";
	$mensaje="ERROR EN DIFERENCIA DE FECHAS";
	$dd_ini=$fechainicial[0].$fechainicial[1];	$dd_fin=$fechafinal[0].$fechafinal[1];
	$mm_ini=$fechainicial[3].$fechainicial[4];	$mm_fin=$fechafinal[3].$fechafinal[4];
	$yyyy_ini=$fechainicial[6].$fechainicial[7].$fechainicial[8].$fechainicial[9];
	$yyyy_fin=$fechafinal[6].$fechafinal[7].$fechafinal[8].$fechafinal[9];
	$siga=1;
					
					if($yyyy_ini<=$yyyy_fin){
						if($yyyy_ini==$yyyy_fin)
							if($mm_ini<=$mm_fin){
								if($mm_ini==$mm_fin)
									if($dd_ini>=$dd_fin){
									 $mensaje= $mensaje."1";
									 $siga=0;
									 }
							}
							else{
								$siga=0;
								$mensaje= $mensaje."4";
							}
					}
					else{
							$siga=0;
							$mensaje=$mensaje.$yyyy_ini."<=".$yyyy_fin."5";
					}
	$mensajescript="<script type=\"text/javascript\">alert('".$mensaje."');</script>";

	if($mensajetrue)
	echo $mensajescript;				
				
	return $siga;
	}
	//Encuentra la diferencia entre 2 fechas de formato dd/mm/yyyy en segundos, dias, meses
	function diferencia_fechas($fechainicial,$fechafinal,$escala,$mensaje=1){
	
	$dd_ini=$fechainicial[0].$fechainicial[1];	$dd_fin=$fechafinal[0].$fechafinal[1];
	$mm_ini=$fechainicial[3].$fechainicial[4];	$mm_fin=$fechafinal[3].$fechafinal[4];
	$yyyy_ini=$fechainicial[6].$fechainicial[7].$fechainicial[8].$fechainicial[9];
	$yyyy_fin=$fechafinal[6].$fechafinal[7].$fechafinal[8].$fechafinal[9];
	$timestamp1 = mktime(0,0,0,$mm_ini,$dd_ini,$yyyy_ini); 
	$timestamp2 = mktime(0,0,0,$mm_fin,$dd_fin,$yyyy_fin); 

		switch($escala){
			case "segundos":
			$diferencia=$timestamp1 - $timestamp2;
			break;
			case "dias":
			$segundos=$timestamp1 - $timestamp2;
			$diferencia=$segundos / (60 * 60 * 24); 
			if(validar_diferencia_fechas($fechainicial,$fechafinal)){
			$diferencia = abs($diferencia); 
			$diferencia = floor($diferencia); 
			}
			else
			$diferencia=0-$diferencia;
			break;
			case "meses":
			$siga=validar_diferencia_fechas($fechainicial,$fechafinal,$mensaje);
			$mes=$mm_ini;
			$anio=$yyyy_ini;
			$diferencia=0;
				
								
				while($siga){
					 if(($mes==($mm_fin+0))&&($anio==($yyyy_fin+0))){
						$siga=0;
						}
					 $fechasiguiente=mes_siguiente($mes,$anio);
					 $mes=$fechasiguiente["mes"];
					 $anio=$fechasiguiente["anio"];
					 $diferencia++;
				}
		
		}
	
		return $diferencia;
		
	}
	//Convierte tipo formato horas ##:##:## en minutos 
	function horaaminutos($hora){
		$arrayhora=explode(":",$hora);
		$numerohoras=$arrayhora[0];
		$numerominutos=$arrayhora[1];
		$numerohorasminutos=$numerohoras*60;
		$minutos=$numerohorasminutos+$numerominutos;	
		return $minutos;
	}
	//Convierte minutos a tipo formato horas
	function minutosahora($minutos){
		$horadecimal=$minutos/60;
		$horaentero=(int)$horadecimal;
		$minutosdecimal=$horadecimal-$horaentero;
		$minutosentero=$minutosdecimal*60;
		$minutosentero<10?$minutosentero="0".$minutosentero:$minutosentero;
		$hora=$horaentero.":".$minutosentero.":00";
		return $hora;
	}
		//Convierte minutos a tipo formato horas
	function segundososaminutos($segundos){
		$minutodecimal=$segundos/60;
		$minutoentero=(int)$minutodecimal;
		$segundosdecimal=$minutodecimal-$minutoentero;
		$segundosentero=$segundosdecimal*60;
		$segundosentero<10?$segundosentero="0".$segundosentero:$segundosentero;
		$minutoentero<10?$minutoentero="0".$minutoentero:$minutoentero;
		$minuto="00:".$minutoentero.":".$segundosentero;
		return $minuto;
	}

	//Convierte fecha tipo yyyy/mm/dd en valor textual dd de mes de yyyy
	function fechaatextofecha($fecha){
		$meses=array("enero","febrero","marzo","abril","mayo","junio","julio","agosto","septiembre","octubre","noviembre","diciembre");
		$numeromes=($fecha[3].$fecha[4])-1;
		$textofecha=$fecha[0].$fecha[1]." de ".$meses[$numeromes]." de ".$fecha[6].$fecha[7].$fecha[8].$fecha[9];
		return $textofecha;
	}
	//Muestra solo mes de una fecha yyyy/mm/dd
	function fechaatextomes($fecha){
		$meses=array("enero","febrero","marzo","abril","mayo","junio","julio","agosto","septiembre","octubre","noviembre","diciembre");
		$numeromes=($fecha[3].$fecha[4])-1;
		$textomes=$meses[$numeromes];
		return $textomes;
	}
	//Convierte fecha tipo yyyy/mm/dd en valor textual nombredia (dd) dias del mes  <mes> de yyyy
	function fechaatextofechadias($fecha){
		$meses=array("enero","febrero","marzo","abril","mayo","junio","julio","agosto","septiembre","octubre","noviembre","diciembre");
		$numeromes=($fecha[3].$fecha[4])-1;
		$textofecha=convercionnumerotexto($fecha[0].$fecha[1])." (".
					$fecha[0].$fecha[1].") dias  del mes  de ".$meses[$numeromes]." de ".$fecha[6].$fecha[7].$fecha[8].$fecha[9];
		return $textofecha;
	}
	//Suma dias a una fecha con formato mysql
	function sumaDia($fecha,$dia)
	{	list($year,$mon,$day) = explode('-',$fecha);
		return date('Y-m-d',mktime(0,0,0,$mon,$day+$dia,$year));		
	}
	
	//Encuentra el periodo anterior
	function encontrarPeriodoAnterior($codigoperiodoinicial)
	{
		$anioinicial=$codigoperiodoinicial[0].$codigoperiodoinicial[1].$codigoperiodoinicial[2].$codigoperiodoinicial[3];
			if($codigoperiodoinicial[4]=="2"){
				$indiceperiodo="1";
				$aniofinal=$anioinicial;
			}
			else
			{
				$indiceperiodo="2";
				$aniofinal=$anioinicial - 1;
			}
			return $aniofinal.$indiceperiodo;
	}
	function encontrarPeriodoPosterior($codigoperiodoinicial)
	{
		$anioinicial=$codigoperiodoinicial[0].$codigoperiodoinicial[1].$codigoperiodoinicial[2].$codigoperiodoinicial[3];
			if($codigoperiodoinicial[4]=="1"){
				$indiceperiodo="2";
				$aniofinal=$anioinicial;
			}
			else
			{
				$indiceperiodo="1";
				$aniofinal=$anioinicial + 1;
			}
			return $aniofinal.$indiceperiodo;
	}
?>