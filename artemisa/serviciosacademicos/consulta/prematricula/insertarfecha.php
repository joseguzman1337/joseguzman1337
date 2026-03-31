<?php
    session_start();
    include_once('../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
//echo strtotime($fechapago)." > ".strtotime(date('Y-m-d'));
if(strtotime($fechapago) > strtotime(date('Y-m-d')))
{
	//Fecha mayor y fecha menor
	// Selecciono el mayor día habil
	$diamax = 5;
	//$fechahoy = date("Y-m-d");
	//echo "FHOY : $fechahoy<br>";
	$unDiaMas = strtotime("+1 day", strtotime($fechahoy)); 
	//echo "UDM : $unDiaMas<br>";
	//$fechahabil = date("Y-m-d", $unDiaMas);
	$fechahabil = date("Y-m-d");
	//echo "FH : $fechahabil<br>";
	while($diamax >= 1)
	{
		//echo "$diamax<br>";
		$unDiaMas = strtotime("+1 day", strtotime($fechahabil)); 
		$fechahabil = date("Y-m-d", $unDiaMas);
		//echo "<br>F HABIL : $fechahabil : ";
		//echo "<br>festivo($fechahabil)<br>";
		if(!festivo($fechahabil, $sala))
		{
			// Si la fecha habil no es festivo y es igual a la fecha de pago termina el while
			//if($fechapago == $fechahabil)
			if(restarfecha($fechahabil, $fechapago) >= 0)
			{
				break;
			}
			else
			{
				$diamax--;
			}
		}
	}
	/*$unDiaMenos = strtotime("-1 day", strtotime($fechahabil)); 
	$fechahabil = date("Y-m-d", $unDiaMenos);
	*/	
	//echo restarfecha($fechapago, $fechahabil);
	//echo "<br>restarfecha($fechapago, $fechahabil) = ".restarfecha($fechapago, $fechahabil);
	if(restarfecha($fechapago, $fechahabil) >= 1)
	{
		//$ffechapago = 0;
		echo "La fecha es mayor a 5 dìas habiles<br>";
	    if ($_SESSION['MM_Username'] == "estudiante")
		 {
		   $ffechapago = false;
		 }
	}
	/*else if(restarfecha($fechapago, $fechahabil) == 1)
	{
		$fechapago = $fechapago;
	}*/
	else
	{
		$fechapago = $fechahabil;
	}
	//echo restarfecha($fechapago, date("Y-m-d"))." > 5 || ".restarfecha($fechapago, date("Y-m-d"))." < 0";
}
else
{
	$ffechapago = 0;
	echo "La fecha digitada no puede ser la de hoy o anterior a la de hoy<br>";
}				
?>