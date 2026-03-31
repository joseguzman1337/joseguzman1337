<?php
class totales
{
	function totales($matriz)
	{
		$this->matriz=$matriz;
	}

	function leer_columnas()
	{
		$matriz_columnas=array_keys($this->matriz[0]);
		$this->matriz_columnas=$matriz_columnas;
		return $matriz_columnas;
	}
	
	function totales_matriz()
	{
		$contador=0;
		foreach($this->matriz_columnas as $llave => $valor)
		{
			$total_array=$this->totalesxllave($valor);
			$array_totales[$contador][$valor]=$total_array;
		}
		return($array_totales);
	}

	function totalesxllave($llave)
	{
		$total=0;
		$this->llave=$llave;
		foreach ($this->matriz as $llave => $valor)
		{
			$total=$total+$valor[$this->llave];
		}
		return $total;
	}
}
?>