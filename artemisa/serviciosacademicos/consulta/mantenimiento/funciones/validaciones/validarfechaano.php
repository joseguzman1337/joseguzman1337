<?php
function validarfechaano($ano, $fecha1,$mensaje)
{
		echo "
		<style type='text/css'>
		<!--
			.Estilo99 
			{
			font-size: 18px;
			color: #FF0000;
			}
		-->
		</style>";
	 
	$valido['valido'] = 1;
	$fechasinformato1=strtotime("+0 day",strtotime($fecha1));
	$fecha1_convertida=date("Y",$fechasinformato1);
	//echo $fecha1;
	//echo "<h1>",$fecha1_convertida,"</h1><br>";
	//echo "<h1>",$ano,"</h1><br>";
	if($fecha1_convertida != $ano)
	{
		$valido['valido'] = 0;
	}


	if(!$valido['valido'])
	{
		echo "<span class='Estilo99'>*</span>";
		$valido['mensaje']=$mensaje;
	}
	return $valido;
	//echo "<h1>",$valido,"</h1>";
}
?>