<?php
function validardosfechas($fecha1, $fecha2, $mensaje)
{
/* 			echo "
		<style type='text/css'>
		<!--
			.Estilo99 
			{
			font-size: 18px;
			color: #FF0000;
			}
		-->
		</style>"; */
		
	$valido['valido'] = 1;
	$fechasinformato1=strtotime("+0 day",strtotime($fecha1));
	$fechasinformato2=strtotime("+0 day",strtotime($fecha2));
	$fecha1_convertida=date("Y-m-d",$fechasinformato1);
	$fecha2_convertida=date("Y-m-d",$fechasinformato2);
	//echo "<br>",$fecha1_convertida,"<br>",$fecha2_convertida,"<br>";
	if($fecha2_convertida < $fecha1_convertida)
	{
		$valido['valido'] = 0;
	}
	if(!$valido['valido'])
	{
		//echo "<span class='Estilo99'>*</span>";
		$valido['mensaje']=$mensaje;
	}
	return $valido;
}
?>
