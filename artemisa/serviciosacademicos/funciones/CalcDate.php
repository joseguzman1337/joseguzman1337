<?php
/**************************************************************************************
Author:  Abhishek Kumar Srivastava
Email:	 abhisheksrivastava@fastmail.fm
Purpose: The class is written for calculating difference between 2 dates
Liscense: GNU GPL
**************************************************************************************/

class CalcDate
{
	// get timestamp from current date time
	function CalculateTimestampFromCurrDatetime($DateTime = -1) 
	{

		if ($DateTime == -1 || $DateTime == '' || $DateTime == '0000-00-00 00:00:00' || $DateTime == '0000-00-00') 
		{
			$DateTime = date("Y-m-d H:i:s");
		}

		$NewDate['year'] = substr($DateTime,0,4);
		$NewDate['month'] = substr($DateTime,5,2);
		$NewDate['day'] = substr($DateTime,8,2);
		$NewDate['hour'] = substr($DateTime,11,2);
		$NewDate['minute'] = substr($DateTime,14,2);
		$NewDate['second'] = substr($DateTime,17,2);

		return mktime($NewDate['hour'], $NewDate['minute'], $NewDate['second'], $NewDate['month'], $NewDate['day'], $NewDate['year']);
	}

	// calculate date difference
	function CalculateDateDifference($TimestampFirst, $TimestampSecond = -1)	
	{
		if ($TimestampSecond == -1) 
		{
			$TimestampSecond = $this->CalculateTimestampFromCurrDatetime();
		}

		if ($TimestampSecond < $TimestampFirst) 
		{
			$TempTimestamp = $TimestampFirst;
			$TimestampFirst = $TimestampSecond;
			$TimestampSecond = $TempTimestamp;
			
			$NegativeDifference = true;
		}
		else 
		{
			$NegativeDifference = false;
		}

		list($Year1, $Month1, $Day1) = split('-', date('Y-m-d', $TimestampFirst));
		list($Year2, $Month2, $Day2) = split('-', date('Y-m-d', $TimestampSecond));
		$Time1 = (date('H',$TimestampFirst)*3600) + (date('i',$TimestampFirst)*60) + (date('s',$TimestampFirst));
		$Time2 = (date('H',$TimestampSecond)*3600) + (date('i',$TimestampSecond)*60) + (date('s',$TimestampSecond));

		$YearDiff = $Year2 - $Year1;
		$MonthDiff = ($Year2 * 12 + $Month2) - ($Year1 * 12 + $Month1);

		if($Month1 > $Month2)
		{
			$YearDiff -= 1;
		}
		elseif($Month1 == $Month2)
		{
			if($Day1 > $Day2) 
			{
				$YearDiff -= 1;
			}
			elseif($Day1 == $Day2) 
			{
				if($Time1 > $Time2) 
				{
					$YearDiff -= 1;
				}
			}
		}

		// handle over flow of month difference
		if($Day1 > $Day2) 
		{
			$MonthDiff -= 1;
		}
		elseif($Day1 == $Day2) 
		{
			if($Time1 > $Time2) 
			{
				$MonthDiff -= 1;
			}
		}

		$DateDifference = Array();
		$TotalSeconds = $TimestampSecond - $TimestampFirst;

		$WeekDiff = floor(($TotalSeconds / 604800));
		$DayDiff = floor(($TotalSeconds / 86400));

		if ($NegativeDifference == true) 
		{
			$DateDifference['years'] = ($YearDiff == 0) ? $YearDiff : -($YearDiff);
			$DateDifference['months'] = ($MonthDiff == 0) ? $MonthDiff : -($MonthDiff);
			$DateDifference['weeks'] = ($WeekDiff == 0) ? $WeekDiff : -($WeekDiff);
			$DateDifference['days'] = ($DayDiff == 0) ? $DayDiff : -($DayDiff);
		}
		else 
		{
			$DateDifference['years'] = $YearDiff;
			$DateDifference['months'] = $MonthDiff;
			$DateDifference['weeks'] = $WeekDiff;
			$DateDifference['days'] = $DayDiff;
		}
		
		return $DateDifference;
	}

	// Recibe el número de días que se quieren calcular a partir de la fecha de hoy
	function calcularfechafuturaxmes($mesmas=1, $fecha=0)
	{
		if(!fecha)
		{
			$unMesMas = strtotime("+$mesmas month", strtotime(date("Y-m-d"))); 
		}
		else
		{
			$unMesMas = strtotime("+$mesmas month", strtotime($fecha)); 
		}
		$fechacalculada = date("Y-m-d", $unMesMas);
		//echo "<h1>$mesmas, $fecha, $fechacalculada</h1>";		
		return $fechacalculada;
	}
	
	function restarfecha($fechamayor, $fechamenor)
	{
		$s = strtotime($fechamayor)-strtotime($fechamenor);
		$d = intval($s/86400);
		$s -= $d*86400;
		$h = intval($s/3600);
		$s -= $h*3600;
		$m = intval($s/60);
		$s -= $m*60;
		
		$dif= (($d*24)+$h).hrs." ".$m."min";
		$dif2= $d.$space.dias." ".$h.hrs." ".$m."min";
		
		return $d;
	}
	
	// Retorna el número de días entre dos fechas donde los meses son de 30 días
	function restarfechacomercial($fechamayor = '2006-04-01', $fechamenor = '2006-02-28')
	{
		$anofin = date("Y",strtotime($fechamayor));
		$anoini = date("Y",strtotime($fechamenor));
		
		//echo "$anofin $anoini";
		$mesfin = date("m",strtotime($fechamayor));
		$mesini = date("m",strtotime($fechamenor));
		
		$mesnum = $mesfin - $mesini;
		//echo "<h1>Mes num$mesnum</h1>";
		$diasasumar = 0;
		$anos = $anofin - $anoini;
		if($anos > 0)
		{
			$mesnum = $mesnum + 12*$anos;
		}
		for($i = 0; $mesnum >= $i; $i++)
		{
			if($mesnum == $i)
			{
				$fechaireal = date("Y-m-d",strtotime("+$diasasumar day", strtotime($fechamayor)));
			}
			else
			{
				$diasasumar = $diasasumar + 30 - date("t",strtotime("+$i month", strtotime($fechamenor)));
			}
		}
		if($fechaireal == "")
		{
			$fechaireal = date("Y-m-d",strtotime("+$diasasumar day", strtotime($fechamayor)));
			$fechaireal = $fechamayor;
		}
		//echo "<h1>$fechaireal, $fechamenor</h1>";
		return $this->restarfecha($fechaireal, $fechamenor);
	}
}
?>