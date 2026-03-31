<?php
function sumahoraafecha($fechainicial,$horasuma,$unidad)
{
		$horasegundos=$horasuma*3600*$unidad;
		//echo $horasegundos;
		//echo "<br>",$horasuma;
		//echo "<br>",$fechainicial;
		$horaarreglada=$horasuma;
		
		$fechasinformato=strtotime("+$horasegundos seconds",strtotime($fechainicial));
		$fecha1_convertida=date("Y-m-d H:i:s",$fechasinformato);
		//echo "<br>",$fecha1_convertida;
		return $fecha1_convertida;
}
?>