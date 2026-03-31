<?php
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
function formatearhora($horasaimprimir)
{
	//echo "IMPR:$horasaimprimir";
	if(strlen ($horasaimprimir)==1)
	{
		$horas = "0".$horasaimprimir.":00";
		return $horas;	
	}
	else if(strlen ($horasaimprimir)==2)
	{
		$horas = $horasaimprimir.":00";	
		return $horas;	
	}


	else


	{


		$horas = ereg_replace("\.",":",$horasaimprimir);


		//echo "HORAS1:$horas<br>";


		$pos = strpos ($horas, ":")+1;


		$long = strlen ($horas);


		$hora = substr ($horas,0,$pos-1);


		$minutos = substr ($horas,$pos);


		if($pos == 2)


		{


			if($long == 3)


			{


				$horas = "0".$horas."0";


			}


			if($long == 4)


			{


				if($horas == 0)


				{


					$horas = "0".$horas;


				}


				else


				{


					$horas = "0".$horas;


				}


			}


		}


		if($pos == 3)


		{


			if($long == 4)


			{


				$horas = $horas."0";


			}


			if($long == 5)


			{


				$horas = $horas;


			}


		}


	}


	$hora = substr ($horas,0,2);


	$minutos = substr ($horas,3);


	if($minutos >= 60)


	{


		$hora = $hora+1;


		$minutos = $minutos - 60;


		$horas = $hora.".".$minutos;


		$horas = formatearhora($horas);


		


	}


	return $horas;


}


function restarhoras($hmayor,$hmenor)


{


	//echo "HORA may1: $hmayor<br>";


	//echo "HORA men1: $hmenor<br>";


	$longmayor = strlen($hmayor);


	$longmenor = strlen($hmenor);


	if($longmayor == 5)


	{


		$horamayor = substr ($hmayor,0,2);


		$minutosmayor = substr ($hmayor,3);


		//echo "HORA may: $horamayor<br>";


		//echo "MIN may: $minutosmayor<br>";


	}


	if($longmenor == 5)


	{


		$horamenor = substr ($hmenor,0,2);


		$minutosmenor = substr ($hmenor,3);


		//echo "HORA men: $horamenor<br>";


		//echo "MIN men: $minutosmenor<br>";


	}


	if($longmayor == 4)


	{


		$horamayor = substr ($hmayor,0,1);


		$minutosmayor = substr ($hmayor,2);


	}


	if($longmenor == 4)


	{


		$horamenor = substr ($hmenor,0,1);


		$minutosmenor = substr ($hmenor,2);


	}


	if($horamayor < $horamenor)


		return "Función mal usada";


	if($horamayor == $horamenor && $minutosmayor < $minutosmenor)


		return "Función mal usada";


	$hora = $horamayor-$horamenor;


	//echo "HORA:$hora<br>";


	$minutos = $minutosmayor-$minutosmenor;


	//echo "MINUTOS:$minutos<br>";


	if($minutos < 0)


	{


		$minutos = $minutos + 60;


		//echo "NUEVOSMINUTOS:$minutos<br>";


		if($hora!=0)


			$hora--;


		if($minutos < 10)


		{


			$sinformato = ($hora."0".$minutos)/100; 


			//echo "SFORm:$sinformato<br>";


			$horas = formatearhora($sinformato);


			return $horas;


		}


		else


		{


			$sinformato = "$hora$minutos"/100; 


			$horas = formatearhora($sinformato);


			return $horas;


		}


		//echo "SFOR:$sinformato<br>";


	}


	if($minutos == 0)


	{


		$sinformato = "$hora"; 


		$horas = formatearhora($sinformato);


		return $horas;


	}


	if($minutos >= 10)


	{


		$sinformato = "$hora$minutos"/100; 


		$horas = formatearhora($sinformato);


		return $horas;


	}


	if($minutos < 10)


	{


		$hora=$hora*10;


		$sinformato = "$hora$minutos"/100;


		//echo "<br>$sinformato<br>"; 


		//$sinformato = $sinformato/100;


		//echo "<br>$sinformato<br>"; 


		$horas = formatearhora($sinformato);


		return $horas;


	}


}


function sumarhoras($hmayor,$hmenor)


{


	$longmayor = strlen($hmayor);


	$longmenor = strlen($hmenor);


	if($longmayor == 5)


	{


		$horamayor = substr ($hmayor,0,2);


		$minutosmayor = substr ($hmayor,3);


	}


	if($longmenor == 5)


	{


		$horamenor = substr ($hmenor,0,2);


		$minutosmenor = substr ($hmenor,3);


	}


	if($longmayor == 4)


	{


		$horamayor = substr ($hmayor,0,1);


		$minutosmayor = substr ($hmayor,2);


	}


	if($longmenor == 4)


	{


		$horamenor = substr ($hmenor,0,1);


		$minutosmenor = substr ($hmenor,2);


	}


	/*if($horamayor < $horamenor)


		return "Función mal usada";


	*/


	$hora = $horamayor+$horamenor;


	//echo "HORA:$hora<br>";


	$minutos = $minutosmayor+$minutosmenor;


	//echo "MINUTOS:$minutos<br>";


	if($hora >= 24)


	{


		$hora = $hora - 24;


	}


	if($minutos > 59)


	{


		$minutos = $minutos - 60;


		//echo "NUEVOSMINUTOS:$minutos<br>";


		if($hora!=23)


			$hora++;


		else


			$hora = 0;


		if($minutos < 10)


		{


			$sinformato = ($hora."0".$minutos)/100; 


			//echo "SFORm:$sinformato<br>";


			$horas = formatearhora($sinformato);


			return $horas;


		}


		else


		{


			$sinformato = "$hora$minutos"/100; 


			$horas = formatearhora($sinformato);


			return $horas;


		}


		//echo "SFOR:$sinformato<br>";


	}


	if($minutos == 0)


	{


		$sinformato = "$hora"; 


		$horas = formatearhora($sinformato);


		return $horas;


	}


	if($minutos >= 10)


	{


		$sinformato = "$hora$minutos"/100; 


		$horas = formatearhora($sinformato);


		return $horas;


	}


	if($minutos < 10)


	{


		$hora=$hora*10;


		$sinformato = "$hora$minutos"/100;


		//echo "<br>$sinformato<br>"; 


		//$sinformato = $sinformato/100;


		//echo "<br>$sinformato<br>"; 


		$horas = formatearhora($sinformato);


		return $horas;


	}


}


function horafaltante($hmayor,$hmenor)


{


	if($hmayor < $hmenor)


		return "Función mal usada";


	$mayor = formatearhora($hmayor);


	$menor = formatearhora($hmenor);	


	//echo "HMAYOR: $mayor<br>";


	//echo "HMENOR: $menor<br>";


	$horamayor = substr ($mayor,0,2);


	$minutosmayor = substr ($mayor,3);


	$horamenor = substr ($menor,0,2);


	$minutosmenor = substr ($menor,3);


	$hora = $horamayor-$horamenor;


	//echo "HORA:$hora<br>";


	$minutos = $minutosmayor-$minutosmenor;


	//echo "MINUTOS:$minutos<br>";


	if($minutos < 0)


	{


		$minutos = $minutos + 60;


		//echo "NUEVOSMINUTOS:$minutos<br>";


		if($hora!=0)


			$hora--;


		if($minutos < 10)


		{


			$sinformato = ($hora."0".$minutos)/100; 


			//echo "SFORm:$sinformato<br>";


			$horas = formatearhora($sinformato);


			return $horas;


		}


		else


		{


			$sinformato = "$hora$minutos"/100; 


			$horas = formatearhora($sinformato);


			return $horas;


		}


		//echo "SFOR:$sinformato<br>";


	}


	if($minutos == 0)


	{


		$sinformato = "$hora"; 


		$horas = formatearhora($sinformato);


		return $horas;


	}


	if($minutos > 0)


	{


		$sinformato = "$hora$minutos"/100; 


		$horas = formatearhora($sinformato);


		return $horas;


	}


}


function horamayor($hmayor,$hmenor)


{


	$longmayor = strlen($hmayor);


	$longmenor = strlen($hmenor);


	if($longmayor == 5)


	{


		$horamayor = substr ($hmayor,0,2);


		$minutosmayor = substr ($hmayor,3);


	}


	if($longmenor == 5)


	{


		$horamenor = substr ($hmenor,0,2);


		$minutosmenor = substr ($hmenor,3);


	}


	if($longmayor == 4)


	{


		$horamayor = substr ($hmayor,0,1);


		$minutosmayor = substr ($hmayor,2);


	}


	if($longmenor == 4)


	{


		$horamenor = substr ($hmenor,0,1);


		$minutosmenor = substr ($hmenor,2);


	}


	if($horamayor < $horamenor)


		return false;


	if($horamayor > $horamenor)


		return true;


	if($horamayor == $horamenor)


	{


		if($minutosmayor < $minutosmenor)


			return false;


		if($minutosmayor > $minutosmenor)


			return true;


	}


	return false;


}


function tienecruces($idgrupo,$sala,$hini,$hfin,$dia1,$numerohorario=0)


{


	$query_horarios = "SELECT h.codigodia, h.codigodia, h.horainicial, h.horafinal, d.nombredia, se.nombresede, s.nombresalon, s.codigosalon, t.nombretiposalon, t.codigotiposalon 


	FROM horario h, dia d, salon s, tiposalon t, sede se


	WHERE h.codigodia = d.codigodia


	AND h.codigosalon = s.codigosalon


	AND h.codigotiposalon = t.codigotiposalon


	AND s.codigosede = se.codigosede


	AND h.idgrupo = '$idgrupo'


	order by 1,2,3,4";


	$horarios = mysql_query($query_horarios, $sala) or die(mysql_error());


	$totalRows_horarios = mysql_num_rows($horarios);		


	if($totalRows_horarios != "")


	{


		$hinicial1 = ereg_replace(":","",$hini.":00");


		$hfinal1 = ereg_replace(":","",$hfin.":00");


		$cuentahorario=1;


		while($row_horarios = mysql_fetch_assoc($horarios))


		{


			$nombredia=$row_horarios['nombredia'];


			$dia2=$row_horarios['codigodia'];


			//$horainicial=ereg_replace(":00$","",$row_horarios['horainicial']);


			//$horafinal=ereg_replace(":00$","",$row_horarios['horafinal']);


			if($cuentahorario != $numerohorario)


			{


				if($dia1 == $dia2)


				{


					$hinicial2 = ereg_replace(":","",$row_horarios['horainicial']);


					$hfinal2 = ereg_replace(":","",$row_horarios['horafinal']);


					if(($hinicial2 < $hinicial1) && ($hfinal2 > $hinicial1))


						return true;


					else if(($hfinal2 > $hfinal1) && ($hinicial2 < $hfinal1))


						return true;


					else if(($hfinal2 == $hfinal1) && ($hinicial2 == $hinicial1))


						return true;


					else if(($hfinal2 == $hfinal1) && ($hinicial2 > $hinicial1))


						return true;


					else if(($hfinal2 < $hfinal1) && ($hinicial2 > $hinicial1))


						return true;


					else if(($hfinal2 > $hfinal1) && ($hinicial1 < $final2))


						return true;


				}


			}


			$cuentahorario++;


		}


	}


	return false;


}


?>