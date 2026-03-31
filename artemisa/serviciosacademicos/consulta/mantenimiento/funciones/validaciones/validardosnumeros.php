<?php
function validardosnumeros($numero1, $numero2, $tipo,$mensaje="",$imprimir=true)
{
	echo "
		<style type='text/css'>
		<!--
			.Estilo99 {
			font-size: 18px;
			color: #FF0000;
					}
		-->
		</style>";

	$valido = 1;
	if($numero2 < $numero1)
	{
		$valido = 0;
	}
	if(!$valido && $imprimir)
	{
		echo "
		<span class='Estilo99'>*</span>";
		$valido['mensaje']=$mensaje;
		$valido['valido'] = 0;
	}
	return $valido;
}
?>