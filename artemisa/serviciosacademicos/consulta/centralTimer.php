<?php
//session_start();
    session_start();
    include_once('../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
function tiempoRestante()
{	
	if(isset($_SESSION['fecha_final']) and !empty($_SESSION['fecha_final'])){
		$fechahoy=date("Y-m-d H:i:s");
		list($fecha_hoy,$hora_hoy)=explode(" ",$fechahoy);
		list($ano_hoy,$mes_hoy,$dia_hoy)=explode("-",$fecha_hoy);
		list($hh_hoy,$mm_hoy,$ss_hoy)=explode(":",$hora_hoy);
		$fecha_hoy_timestamp=mktime($hh_hoy,$mm_hoy,$ss_hoy,$mes_hoy,$dia_hoy,$ano_hoy);

		list($fecha_fin,$hora_fin)=explode(" ",$_SESSION['fecha_final']);
		list($ano_fin,$mes_fin,$dia_fin)=explode("-",$fecha_fin);
		list($hh_fin,$mm_fin,$ss_fin)=explode(":",$hora_fin);
		$fecha_fin_timestamp=mktime($hh_fin,$mm_fin,$ss_fin,$mes_fin,$dia_fin,$ano_fin);

		$diasQuedan=(($fecha_fin_timestamp - $fecha_hoy_timestamp) / (60 * 60 * 24));
		$diasQuedanDecimal=(($fecha_fin_timestamp - $fecha_hoy_timestamp) / (60 * 60 * 24));
		$diaEntero=intval($diasQuedanDecimal);
		$decimal=$diasQuedanDecimal-$diaEntero;

		$horasQuedan = $decimal * 24;
		//
		$horaEntera=intval($horasQuedan);
		$decimalHora=$horasQuedan-$horaEntera;
		$minutosQuedan=$decimalHora * 60;
		//
		$minutosEntero=intval($minutosQuedan);
		$minutosDecimal=$minutosQuedan-$minutosEntero;
		//
		$segundosQuedan=$minutosDecimal * 60;


		echo 'Quedan '.$diaEntero.' dias '.$horaEntera.' horas '.$minutosEntero.' minutos '.round($segundosQuedan).' segundos de plazo para poder votar ';
	}
}
tiempoRestante();
?>

