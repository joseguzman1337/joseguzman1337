<?php 
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);

require_once('../../../Connections/sala2.php');


mysql_select_db($database_sala, $sala); 


// Código para el objeto que adiciona un grupo


session_start();


require_once('seguridadmateriasgrupos.php');





if(isset($_SESSION['dirini1']))


{


	$codigomateria = $_GET['codigomateria'];


	$codigomaterianovasoft = $_GET['codigomaterianovasoft'];


	$carrera = $_GET['carrera'];


	if(isset($_GET['grupo']))


	{


		$grupo1=$_GET['grupo'];


	}


	if(isset($_POST['grupo']))


	{


		$grupo1=$_POST['grupo'];


	}


	$dirini = $_SESSION['dirini1'];


}


require_once("clasegrupo.php");


$cadenaobjetos = $_SESSION['objetos1'];


$objetos = unserialize($cadenaobjetos);  





$codigocarrera = $_SESSION['codigofacultad'];





if(isset($_GET['guardar']))


{


	$tam = sizeof($objetos);


	echo "Guarda el objeto :: $tam<br>";


	foreach($objetos as $nombre => $objeto)


	{


		//Toma los datos del objeto


		//$objeto = $objetos[$contador]; 


		$idgrupo=$objeto->idgrupo();


		$codigogrupo=$objeto->codigogrupo();


		$nombregrupo=$objeto->nombregrupo();


		$codigomateria=$objeto->codigomateria();


		$codigomaterianovasoft=$objeto->codigomaterianovasoft();


		$codigoperiodo=$objeto->codigoperiodo();


		$numerodocumento=$objeto->numerodocumento();


		$maximogrupo=$objeto->maximogrupo();


		$matriculadosgrupo=$objeto->matriculadosgrupo();


		$horario=$objeto->horarios();


		$numerohorassemanales=$objeto->numerohorassemanales();


		$numerohorashorario=$objeto->numerohorashorario();


		$horashorario=$objeto->horashorario();


		$guardado=$objeto->guardado();


		echo "<br> Guardado : $guardado";


		$numerohorarios=$objeto->numerohorarios();


		$tienecabecera=$objeto->tienecabecera();


		$tienegrupo=$objeto->tienegrupo();


		$tienehorario=$objeto->tienehorario();


		$nombredocente=$objeto->nombredocente();


		$apellidodocente=$objeto->apellidodocente();


		$tienedocente=$objeto->tienedocente();


		$tienehorariocompleto=$objeto->tienehorariocompleto();


		$tienematriculados=$objeto->tienematriculados();


		$horariohistorico=$objeto->horariohistorico();


		if(!$objeto->eliminado())


		{


			if($idgrupo == 0)


			{


				begin;


				echo "<br>El grupo es nuevo:<br>";


				$query_addgrupo = "


				INSERT INTO grupo(idgrupo, codigogrupo, nombregrupo, codigomateria, codigomaterianovasoft, codigoperiodo, numerodocumento, maximogrupo, matriculadosgrupo) 


				VALUES('$idgrupo','$codigogrupo','$nombregrupo','$codigomateria','$codigomaterianovasoft','$codigoperiodo','$numerodocumento','$maximogrupo','$matriculadosgrupo')";


				echo "<br><br>INSERT GRUPO: $query_addgrupo";


				$addgrupo = mysql_query($query_addgrupo, $sala) or die(mysql_error());


				$idgrupo1=mysql_insert_id();


				echo "<br>$idgrupo1";


				$cuentahorario = 1;


				echo "<br>NUMero de horarios: $numerohorarios<br>";


				//while($cuentahorario <= $numerohorarios)


				foreach($horario as $nombre => $horario1)


				{


					//$horario1 = $horario[$cuentahorario];


					$codigodia = $horario1['codigodia'];


					$horainicial = $horario1['horainicial'];


					$horafinal = $horario1['horafinal'];


					$codigosalon = $horario1['codigosalon'];


					$query_addhorario = "


					INSERT INTO horario(idgrupo, codigodia, horainicial, horafinal, codigosalon) 


					VALUES('$idgrupo1', '$codigodia', '$horainicial', '$horafinal', '$codigosalon')";


					echo "<br>INSERT HORARIO: $query_addhorario<br>";


					$addhorario = mysql_query($query_addhorario, $sala) or die(mysql_error());


					$cuentahorario++;


				}


				//$objeto->nuevoidgrupo($idgrupo1);


				commit;				


			}


			else


			{


				begin;


				echo "<br>El grupo existe:<br>";


				$query_updgrupo = "UPDATE grupo 


				SET numerodocumento='$numerodocumento', maximogrupo='$maximogrupo'


				WHERE idgrupo = '$idgrupo'";


				echo "<br>UPDATE GRUPO:".$query_updgrupo;


				$updgrupo = mysql_query($query_updgrupo, $sala) or die(mysql_error());


				$cuentahorario = 1;


				echo "<br>NUMero de horarios: $numerohorarios<br>";


				//while($cuentahorario <= $numerohorarios)


				foreach($horario as $nombre => $horario2)


				{


					echo "<br>Cuenta de horarios: $cuentahorario<br>";


					$horario2 = $horario[$cuentahorario];


					$estado = $horario2['estado'];


					echo "<br>ESTADO: $estado<br>";


					$codigodia = $horario2['codigodia'];


					echo "<br>DIA: $codigodia<br>";


					$horainicial = $horario2['horainicial'];


					$horafinal = $horario2['horafinal'];


					$codigosalon = $horario2['codigosalon'];


					if($estado == "nuevo")


					{


						$query_addhorario = "


						INSERT INTO horario(idgrupo, codigodia, horainicial, horafinal, codigosalon) 


						VALUES('$idgrupo', '$codigodia', '$horainicial', '$horafinal', '$codigosalon')";


						echo "<br>INSERT HORARIO:".$query_addhorario;


						$addhorario = mysql_query($query_addhorario, $sala) or die(mysql_error());


					}


					if($estado == "cargado")


					{


						$horariohis = $horariohistorico[$cuentahorario];


						$estadohis = $horariohis['estado'];


						$codigodiahis = $horariohis['codigodia'];


						$horainicialhis = $horariohis['horainicial'];


						$horafinalhis = $horariohis['horafinal'];


						$codigosalonhis = $horariohis['codigosalon'];


						$query_updhorario = "UPDATE horario 


						SET codigodia='$codigodia', horainicial='$horainicial', horafinal='$horafinal', codigosalon='$codigosalon'


						WHERE idgrupo = '$idgrupo' AND codigodia='$codigodiahis' AND horainicial='$horainicialhis' AND horafinal='$horafinalhis' AND codigosalon='$codigosalonhis'";


						echo "<br>UPDATE HORARIO:".$query_updhorario;


						$updhorario = mysql_query($query_updhorario, $sala) or die(mysql_error());


					}


					if($estado == "eliminado")


					{


						$horariohis = $horariohistorico[$cuentahorario];


						$estadohis = $horariohis['estado'];


						$codigodiahis = $horariohis['codigodia'];


						$horainicialhis = $horariohis['horainicial'];


						$horafinalhis = $horariohis['horafinal'];


						$codigosalonhis = $horariohis['codigosalon'];


						$query_delhorario = "DELETE FROM horario WHERE idgrupo = '$idgrupo'  AND codigodia='$codigodiahis' AND horainicial='$horainicialhis' AND horafinal='$horafinalhis' AND codigosalon='$codigosalonhis'";


						echo "<br>tres:".$query_delhorario;


						$delhorario = mysql_query($query_delhorario, $sala) or die(mysql_error());


					}


					$cuentahorario++;


				}


				commit;	


			}


		}


		else


		{


			begin;


			$query_delhorario = "DELETE FROM horario WHERE idgrupo = '$idgrupo'";


			echo "<br>tres:".$query_delhorario;


			$delhorario = mysql_query($query_delhorario, $sala) or die(mysql_error());


			


			$query_delgrupo = "DELETE FROM grupo WHERE idgrupo = '$idgrupo'";


			//echo "<br>cuatro:".$query_delgrupo;


			$delgrupo = mysql_query($query_delgrupo, $sala) or die(mysql_error());


			commit;


		}


	}


}


/*$cadenaobjetos = serialize($objetos);  


$_SESSION['objetos1'] = $cadenaobjetos;


*/


unset($_SESSION['objetos1']);


session_unregister($_SESSION['objetos1']);


unset($_SESSION['numerodegrupo']);


session_unregister($_SESSION['numerodegrupo']);


echo "<script language='javascript'>


	window.opener.recargar('".$dirini."');


	window.opener.focus();


	window.close();


 </script>";


?>