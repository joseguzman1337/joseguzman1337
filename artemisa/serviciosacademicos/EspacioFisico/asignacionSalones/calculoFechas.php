<?php
// echo "<pre>"; print_r($_REQUEST);die;
/**
* Calculo fechas
*/
class calculoFechas
{
  public $a_vectt;
  public $fechaInicio;
  public $fechaFinal;
  public $diaSemana;
  function __construct($fechainicio, $fechafinal, $diasemana){
  	$this->fechaInicio = $fechainicio;
  	$this->fechaFinal = $fechafinal;
  	$this->diaSemana = $diasemana;
  }
  function calculoSemana(){
    $d1=new DateTime($this->fechaInicio);
    $d2=new DateTime($this->fechaFinal);
    $diff=$d2->diff($d1);
    for ($i=0; $i <= $diff->days; $i++) { 
        $numsemana[]= $d1->format('W');
      date_add($d1, date_interval_create_from_date_string('1 days'));
    }
    $numsemana = array_unique($numsemana);
    //Funcion Para calcular por periodicidad
    for ($periodicidad=$numsemana[0]; $periodicidad <= end($numsemana); $periodicidad+=1) {
      $this->calculoFechasDias($periodicidad);
    }
  }
  function calculoFechasDias($sem){

    $d1=new DateTime($this->fechaInicio);
    $d2=new DateTime($this->fechaFinal);
    $diff=$d2->diff($d1);
      for ($i=0; $i <= $diff->days; $i++) {
        foreach ($this->diaSemana as $key => $value) {
          if ($d1->format('N')==$value){
             if ($d1->format('W')==$sem){
              // echo $i."=".$d1->format('Y-m-d-N-D-W') . "</br>";
              $this->a_vectt[] = $d1->format('Y-m-d');
            }
          }
        }
        date_add($d1, date_interval_create_from_date_string('1 days'));
      }
	}
	function envioArreglo(){
		echo json_encode($this->a_vectt);
	}
}
$fecha1 = new calculoFechas($_POST['FechaInicio'], $_POST['FechaFinal'], $_POST['dia']);
$fecha1->calculoSemana();
$fecha1->envioArreglo();
unset($fecha1);

?>