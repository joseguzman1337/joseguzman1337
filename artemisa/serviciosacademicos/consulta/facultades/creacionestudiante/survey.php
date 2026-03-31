<?php
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);  
//session_start();
		include('classes/main.class.php');
		include('classes/survey.class.php');
		$survey = new UCCASS_Survey;
		$body = $survey->take_survey($_SESSION['varenc'],$_SESSION['codigo']);
		//$header = $survey->com_header("ENCUESTA #3}: {$survey->survey_name}");
		echo $header;
		echo $body;
		print_r( $_SESSION ); 
		//echo $survey->com_footer();
?>

