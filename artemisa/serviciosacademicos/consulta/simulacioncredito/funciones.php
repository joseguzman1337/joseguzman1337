<?php

class Simulador
{
	
	public function obtenerconfiguracion()
	{
		$query="select * from configsimuladorfinanciero where activo order by idconfigsimuladorfinanciero desc limit 1";
		$datos = 'ivan';
		return $datos;
	}
}

?>