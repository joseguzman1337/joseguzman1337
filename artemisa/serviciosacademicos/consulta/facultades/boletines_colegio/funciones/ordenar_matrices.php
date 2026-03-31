<?php
class matriz
{
	function matriz($matriz)
	{
		$this->matriz=$matriz;
	}

	function leer_llaves()
	{
		$matriz_columnas=array_keys($this->matriz[0]);
		$this->matriz_llaves=$matriz_columnas;
		//return $matriz_columnas;
	}

	function ordenamiento($columna,$orden="ASC")
	{
		foreach($this->matriz as $llave => $fila)
		{
			$arreglo_interno[$llave] = $fila[$columna];
		}
		if($orden=="ASC" or $orden=="asc")
		{
			array_multisort($arreglo_interno, SORT_ASC, $this->matriz);
		}
		elseif($orden=="DESC" or $orden=="desc")
		{
			array_multisort($arreglo_interno, SORT_DESC, $this->matriz);
		}
		return $this->matriz;
	}

	function filtrar_unitario($matriz,$columna,$expresion,$criterio)
	{
		$this->conteo++;
		//echo $matriz,$columna,$expresion,$criterio,"<br><br>";

		foreach($matriz as $llave => $valor)
		{
			//echo $criterio;echo "<br><br>";
			if($criterio=="like")
			{
				if(eregi($expresion,$valor[$columna]))
				{
					$array_resultado[]=$matriz[$llave];
				}
			}
			elseif($criterio=="=" or $criterio=="igual")
			{
				if(eregi("^$expresion$",$valor[$columna]))
				{
					$array_resultado[]=$matriz[$llave];
				}
			}
			elseif($criterio==">" or $criterio=="mayor")
			{
				if($valor[$columna] > $expresion)
				{
					$array_resultado[]=$matriz[$llave];
				}
			}
			elseif($criterio==">=" or $criterio=="mayorigual")
			{
				if($valor[$columna] >= $expresion)
				{
					$array_resultado[]=$matriz[$llave];
				}
			}

			elseif($criterio=="<" or $criterio=="menor")
			{
				if($valor[$columna] < $expresion)
				{
					$array_resultado[]=$matriz[$llave];
				}
			}

			elseif($criterio=="<=" or $criterio=="menorigual")
			{
				if($valor[$columna] <= $expresion)
				{
					$array_resultado[]=$matriz[$llave];
				}
			}
			elseif($criterio=="<>" or $criterio=="diferente")
			{
				if($valor[$columna] <> $expresion)
				{
					$array_resultado[]=$matriz[$llave];
				}
			}
		}
		//print_r($array_resultado);echo "<h1>",$this->conteo,"</h1>";echo "<br><br>";
		return $array_resultado;
	}

	function agregarcolumna_filtro($nombrecolumna, $valorcolumna,$tipobusqueda) //puede ser cadena manda like, o normal manda =,
	{
		if($valorcolumna!="")
		{
			$this->columnas['nombrecolumna']=$nombrecolumna;
			$this->columnas['valorcolumna']=$valorcolumna;
			$this->columnas['tipobusqueda']=$tipobusqueda;
			$this->array_columnas_filtro[]=$this->columnas;
		}
	}

	function agregarcolumna_filtro_automatica($valores_get)
	{
		foreach ($this->matriz_llaves as $llave => $valor)
		{
			$this->agregarcolumna_filtro($valor,$valores_get[$valor],$valores_get["f_".$valor]);
		}
	}

	function filtrar($matriz)
	{
		foreach($this->array_columnas_filtro as $clave => $valor)
		{
			if(!isset($this->primeravez))
			{
				$this->filtrotmp=$this->filtrar_unitario($matriz,$valor['nombrecolumna'],$valor['valorcolumna'],$valor['tipobusqueda']);
				$this->primeravez=1;
			}
			else
			{
				//echo "<h1>",print_r($this->filtrotmp),"</h1><br>";
				$this->filtrotmp=$this->filtrar_unitario($this->filtrotmp,$valor['nombrecolumna'],$valor['valorcolumna'],$valor['tipobusqueda']);
			}
		}
		if(count($this->array_columnas_filtro)==0)
		{
			return($matriz);
		}
		else
		{
			return $this->filtrotmp;
		}
	}
	function recortar($matriz,$llaves_seleccionadas)
	{
		foreach ($llaves_seleccionadas as $llaves => $valorllaves)
		{
			foreach ($matriz as $clave => $valor)
			{
				$matriz_cortada[$clave][$valorllaves]=$valor[$valorllaves];
			}
		}
		return $matriz_cortada;
	}
}
?>

