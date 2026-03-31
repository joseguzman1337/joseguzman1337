<?php
//echo "<pre>"; print_r($_REQUEST);
/**
* Validar 
*/
class Validacion
{
	private $a_vectt;
	public function validaFecha($fechaInicio, $fechaFin){
		if (($ts = strtotime($fechaInicio)) === false || ($ts = strtotime($fechaFin)) === false) {
			$this->a_vectt['Error'] = "Error: Las fechas no pueden estar vacias.";
			$this->a_vectt['valida'] = false;
			
		}elseif (strtotime($fechaInicio) > strtotime($fechaFin)) {
			$this->a_vectt['Error'] = "Error: La fecha de inicio no puede ser mayor que la fecha final.";
			$this->a_vectt['valida'] = false;
		}else{
			$this->a_vectt['valida'] = true;
		}
	}
	public function enviaRespuesta(){
		// print_r($this->a_vectt);
		echo json_encode($this->a_vectt);
        exit;
	}
}
$validacion1 = new Validacion;
$validacion1->validaFecha($_POST['fechaInicio'],$_POST['fechaFinal']);
$validacion1->enviaRespuesta();
unset($validacion1);
?>