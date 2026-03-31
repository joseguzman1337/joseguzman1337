<?php
   session_start();
    include_once(realpath(dirname(__FILE__)).'/../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
function arreglarfecha($fechainicial)
{
		//echo "<br>",$fechainicial;

		$fechasinformato=strtotime("+0 day",strtotime($fechainicial));
		$fecha1_convertida=date("Y-m-d",$fechasinformato);
		//echo "<br>",$fechaconvertida;
		return $fecha1_convertida;
}
?>