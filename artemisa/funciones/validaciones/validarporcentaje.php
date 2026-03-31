<?php
function validarporcentaje($cadena, $tiponumero,$mensaje)
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

	switch ($tiponumero)
	{
		case "entero":
		if(!ereg("^[0-9]{0,20}$",$cadena))
			{
				$valido['valido'] = 0;
			}
		elseif($cadena <= 0 || $cadena > 100)
			{
				$valido['valido'] = 0;
			}
		break;
		
		case "decimal":
		
		if(!is_numeric($cadena))
		{
			$valido['valido'] = 0;
		}
		elseif($cadena <= 0 || $cadena > 100)
			{
				$valido['valido'] = 0;
			}
		break;
	}
	if($cadena!='')
	{
		if(!$valido['valido'])
		{
			echo "<span class='Estilo99'>*</span>";
			$valido['mensaje']=$mensaje;
		}
	}
	return $valido;
}
?>