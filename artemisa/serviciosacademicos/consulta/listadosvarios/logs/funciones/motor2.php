<?php
/**
 * Esta clase, es el motor de informes, recibe una matriz bidimensional cualquiera, y dibuja filtros, efectúa ordenamientos, y exporta a excel
 *
 */
class matriz
{
	/**
	 * Constructor de la clase, recibe una matriz bidimensional, y el título para el reporte
	 *
	 * @param matriz bidimensional $matriz
	 * @param titulo del informe $titulo
	 * @return matriz  matriz ya sea filtrada, ordenada, o recortadaC
	 */
	function matriz($matriz,$titulo="")
	{
		error_reporting(0);
		$this->matriz=$matriz;
		$this->titulo=$titulo;
		$this->leer_llaves();
	}

	/**
	 * Este metodo carga los nombres de las llaves de la matriz, sirve en toda la clase, para operaciones relacionadas con las llaves
	 *
	 */
	function leer_llaves()
	{
		$matriz_columnas=array_keys($this->matriz[0]);
		$this->matriz_llaves=$matriz_columnas;
		//return $matriz_columnas;
	}
	/**
 * Informa si se quiere filtro en el informe o no, para todo el informe
 *
 * @param booleano $filtrasino variable que guarda si o no
 * @param matriz get $valores_get matriz que guarda los valores que entran  por el get
 */
	function filtrasino($filtrasino=false,$valores_get)
	{
		$this->filtrayesno=$filtrasino;
		$this->agregarcolumna_filtro_automatica($valores_get);
		$this->matriz_filtrada=$this->filtrar($this->matriz);
		//print_r($this->matriz_filtrada);
	}

	function ordenamiento($columna,$orden="ASC")
	{
		$this->ordenamiento=true;
		if($this->filtrayesno==true and is_array($this->matriz_filtrada))
		{
			foreach($this->matriz_filtrada as $llave => $fila)
			{
				$arreglo_interno[$llave] = $fila[$columna];
			}
			if($orden=="ASC" or $orden=="asc")
			{
				$this->orden="ASC";
				array_multisort($arreglo_interno, SORT_ASC, $this->matriz_filtrada);
			}
			elseif($orden=="DESC" or $orden=="desc")
			{
				$this->orden="DESC";
				array_multisort($arreglo_interno, SORT_DESC, $this->matriz_filtrada);
			}
		}
		else
		{
			foreach($this->matriz as $llave => $fila)
			{
				$arreglo_interno[$llave] = $fila[$columna];
			}
			if($orden=="ASC" or $orden=="asc")
			{
				$this->orden="ASC";
				array_multisort($arreglo_interno, SORT_ASC, $this->matriz);
			}
			elseif($orden=="DESC" or $orden=="desc")
			{
				$this->orden="DESC";
				array_multisort($arreglo_interno, SORT_DESC, $this->matriz);
			}
		}
	}

	function filtrar_unitario($matriz,$columna,$expresion,$criterio)
	{
		$html = "";
		//echo $matriz,$columna,$expresion,$criterio,"<br><br>";
		if(!is_array($matriz))
		{
			$html .= '<script language="javascript">alert("Filtro demasiado restrictivo, no hay datos para mostrar")</script>';
		}
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
			//echo $nombrecolumna." ".$valorcolumna." ".$tipobusqueda,"<br>";
			$this->columnas['nombrecolumna']=$nombrecolumna;
			$this->columnas['valorcolumna']=$valorcolumna;
			$this->columnas['tipobusqueda']=$tipobusqueda;
			$this->array_columnas_filtro[]=$this->columnas;
		}
	}

	function agregarllave_drilldown($nombrecolumna,$link_origen,$link_destino,$descripcion="",$llave,$cadenaadicional="",$variable="",$aliasvariable="",$mailto="")
	{
		$this->drill=false;
		if($nombrecolumna!="")
		{
			$drill_down['nombrecolumna']=$nombrecolumna;
			$drill_down['link_origen']=$link_origen;
			$drill_down['link_destino']=$link_destino;
			$drill_down['llave']=$llave;
			if($descriptor=!"")
			{
				$drill_down['descriptor']=$descripcion;
			}
			if($cadenaadicional!="")
			{
				$drill_down['cadenaadicional']=$cadenaadicional;
			}
			if($variable!="")
			{
				$drill_down['variable']=$variable;
			}
			if($aliasvariable!="")
			{
				$drill_down['aliasvariable']=$aliasvariable;
			}
			if($mailto!="")
			{
				$drill_down['mailto']=$mailto;
			}
			$this->array_drill_down[]=$drill_down;
			$this->drill=true;
			//$this->listar($this->array_drill_down);
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
		if(count($this->array_columnas_filtro)!=0)
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
		}
		if(count($this->array_columnas_filtro)==0)
		{
			return($matriz);
		}
		else
		{
			if(!is_array($this->filtrotmp))
			{
				$html .= '<script language="javascript">alert("La Búsqueda no contiene ningún resultado")</script>';
				$html .= '<script language="javascript">history.go(-1)</script>';

			}
			return $this->filtrotmp;
		}
	}

	function recortar($post)
	{
		$this->recortar=true;
		foreach($post as $vpost => $valor)
		{
			if (ereg("^sel".$valor."$",$vpost))
			{
				$llaves_seleccionadas[]=$valor;
			}
			//print_r($post);
		}

		if($this->filtrayesno==true)
		{
			foreach ($llaves_seleccionadas as $llaves => $valorllaves)
			{
				foreach ($this->matriz_filtrada as $clave => $valor)
				{
					$this->matriz_recortada[$clave][ereg_replace("_"," ",$valorllaves)]=$valor[ereg_replace("_"," ",$valorllaves)];
				}
			}
		}
		else
		{
			foreach ($llaves_seleccionadas as $llaves => $valorllaves)
			{
				foreach ($this->matriz as $clave => $valor)
				{
					$this->matriz_recortada[$clave][ereg_replace("_"," ",$valorllaves)]=$valor[ereg_replace("_"," ",$valorllaves)];
				}
			}
		}
	}

	function tabla_arreglo_chulitos()
	{
		$contador=1;
		$html .= "<form name='recortar' method='post' action=''>";
		$html .= "<table border=1 cellpadding='2' cellspacing='1'>\n";
		$html .= "<table border=1 cellpadding='2' cellspacing='1'>\n";
		foreach ($this->matriz_llaves as $llave => $valor)
		{
			if($contador%4==0)
			{
				$contador=1;
				$html .= "<tr>\n";
			}
			$html .= "<td nowrap>$valor&nbsp;</td>\n";
			if($_POST["sel".ereg_replace(" ","_",$valor)]==ereg_replace(" ","_",$valor))
			{
				$chequear="checked";
			}
			else
			{
				$chequear="";
			}
			$html .= "<td><input type='checkbox'  name='sel".ereg_replace(" ","_",$valor)."' $chequear value='".ereg_replace(" ","_",$valor)."'></td>\n";

			if($contador%4==0)
			{
				$contador=1;
				$html .= "</tr>\n";
			}
			$contador++;
		}
		$html .= "<tr><td><table border='1'>
		<tr><td><input name='Exportar_recorte' type='submit' id='Exportar_recorte' value='Exportar'></td>
    	<td><div align='center'><input name='tipo_exp' type='radio' value='xls' checked></div></td>
	    <td><div align='center'>XLS</div></td>
	    <td><div align='center'><input name='tipo_exp' type='radio' value='doc'></div></td>
    	<td><div align='center'>DOC</div></td>
		</tr>\n";
		$html .= "</table>\n";
		$html .= "</table>\n";
		$html .= "</form>\n";
		return $html;
	}

	function escribir_filtros($matriz)
	{
		//error_reporting(0);
		$html .= "<tr>";
		if($this->numerar=='si')
		{
			$html .= "<td id='tituloverde'>&nbsp;</td>";
		}
		while($elemento = each($matriz))
		{
			$html .= "<td align='CENTER' id='tituloverde'>
			<input name='$elemento[0]' type='text' size='15' value='".$_GET[$elemento[0]]."'><br>
			<select name='f_$elemento[0]' id='f_$elemento[0]'>
			<option value='like'"; 
			
			if($_GET['f_'.$elemento[0]]=='like'){$html .= 'Selected';}$html .= ">like</option>
			<option value='<>'"; if($_GET['f_'.$elemento[0]]=='<>'){$html .= 'Selected';}$html .= "><></option>
			<option value='='"; if($_GET['f_'.$elemento[0]]=='='){$html .= 'Selected';}$html .= ">=</option>
			<option value='>'"; if($_GET['f_'.$elemento[0]]=='>'){$html .= 'Selected';}$html .= ">></option>
			<option value='>='"; if($_GET['f_'.$elemento[0]]=='>='){$html .= 'Selected';}$html .= ">>=</option>
			<option value='<'"; if($_GET['f_'.$elemento[0]]=='<'){$html .= 'Selected';}$html .= "><</option>
			<option value='<='"; if($_GET['f_'.$elemento[0]]=='<='){$html .= 'Selected';}
			$html .= "><=</option></select></td>";
		}
		
		$html .= "</tr>";
		return $html;
	}

	function escribir_cabeceras($matriz,$href)
	{
		while($elemento = each($matriz))
		{
			$pedazo_a="&".$elemento[0]."=".$_GET[$elemento[0]];
			$cadena_a=$cadena_a.$pedazo_a;
		}
		reset($matriz);
		while($elemento = each($matriz))
		{
			$pedazo_b="&f_".$elemento[0]."=".$_GET['f_'.$elemento[0]];
			$cadena_b=$cadena_b.$pedazo_b;
		}
		reset($matriz);
		//error_reporting(0);
		$html .= "<tr>\n";
		if($this->numerar=='si')
		{
			$html .= "<td align='CENTER' id='tituloverde'>No</td>\n";
		}
		while($elemento = each($matriz))
		{
			if($href=="")
			{
				$html .= "<td align='CENTER' id='tituloverde'>$elemento[0]</a></td>\n";
			}

			else
			{
				$html .= "<td align='CENTER' id='tituloverde'><a href='$href?ordenamiento=$elemento[0]&orden=";
				if(!isset($_GET['orden'])){$html .= "desc";}
				if($_GET['orden']=="asc"){$html .= "desc";}
				if($_GET['orden']=="desc"){$html .= "asc";};
				$html .= $cadena_a.$cadena_b;
				if(isset($_GET['Filtrar']) and $_GET['Filtrar']!="")
				{
					$html .= "&Filtrar=Filtrar";
				}
				if(isset($_GET['Exportar']) and $_GET['Exportar']!="")
				{
					//echo "&Exportar=Exportar";
				}

				$html .= "'>$elemento[0]</a></td>\n";
			}
		}
		$html .= "</tr>\n";
		return $html;
	}

	function listar($matriz="",$texto="",$link="",$filtros="si",$numerar="no",$totalizar="si")
	{
		$html ="";
		$this->numerar=$numerar;
		$no=1;
		$html .= "<form name='form1' method='get' action=''>";
		$html .= "<table border=1 cellpadding='2' cellspacing='1' align=center>\n";
		if($texto!="")
		{
			$html .= "<caption align=TOP><h4>$texto</h4></caption>";
		}
		$html .= $this->escribir_cabeceras($matriz[0],$link);
		
		if($filtros=="si")
		{
			$html .= $this->escribir_filtros($matriz[0]);
		}
		for($i=0; $i < count($matriz); $i++)
		{
			$html .= "<tr>\n";
			if($numerar=="si")
			{
				$html .= "<td>$no</td>\n";
			}
			$no++;
			while($elemento=each($matriz[$i]))
			{
				$bandera_drill_down=false;
				if(is_array($this->array_drill_down))
				{
					foreach ($this->array_drill_down as $llave => $valor)
					{
						if($elemento[0]==$valor['nombrecolumna'])
						{
							unset($mail);
							$bandera_drill_down=true;
							if($valor['mailto']!="")
							{
								$mail="<td nowrap><a href='mailto:".$matriz[$i][$valor['mailto']]."'>".$matriz[$i][$valor['mailto']]."</a>";
							}
							$cadena="<td nowrap><a href=".$valor['link_destino'].'?link_origen='.$valor['link_origen'];
							$complemento='&'.$valor['llave'].'='.$matriz[$i][$valor['llave']];
							if($valor['variable']!="" and $valor['aliasvariable']!="")
							{
								$variable='&'.$valor['aliasvariable'].'='.$matriz[$i][$valor['variable']];
							}
							elseif($valor['variable']!="" and $valor['aliasvariable']=="")
							{
								$variable='&'.$valor['variable'].'='.$matriz[$i][$valor['variable']];
							}
							if($valor['descriptor']!=""){$descriptor='&descriptor='.$valor['descriptor'];}
							if($valor['cadenaadicional']!=""){$cadenaadicional='&'.$valor['cadenaadicional'];}
							$final='>'.$elemento[1].'</a>';

							if($mail!="")
							{
								$html .= $mail;
							}
							elseif($valor['variable']!="")
							{
								$html .= $cadena.$complemento.$cadenaadicional.$descriptor.$variable.$final;
							}
							else
							{
								$html .= $cadena.$complemento.$cadenaadicional.$descriptor.$final;
							}

							//echo "<td nowrap><a href=".$valor['link_destino'].'?link_origen='.$valor['link_origen'].'&'.$valor['llave'].'='.$matriz[$i][$valor['llave']].">$elemento[1]</a>";
						}
					}
				}
				if($bandera_drill_down==false)
				{
					$html .= "<td nowrap>$elemento[1]</td>\n";
				}
				//echo "<td nowrap>$elemento[1]&nbsp;</td>\n";
			}

		}
		$html .= "</tr>\n";
		if(is_array($this->totales))
		{
			if ($numerar=='no')
			{
				$resta=1;
			}
			else
			{
				$suma=1;
			}
			$html .= "<tr>\n";
			$colspan=count($this->matriz_llaves)+$suma;
			{
				$html .= "<td colspan='$colspan'><div align='center'><font size='+1'>Subtotales</font></div></td>";
			}
			$html .= "</tr>\n";
			$html .= "<tr>\n";
			for($i=0;$i <= count($this->matriz_llaves)-$resta;$i++)
			{
				$html .= "<td>";$html .= $this->totales[$this->matriz_llaves[$i]];$html .= "</td>";
			}
			$html .= "</tr>\n";
		}
		$html .= "</table>\n";
		if($filtros=="si")
		{
			$html .= $this->botones();
		}
		$html .= "</form>\n";
		return $html;
	}

	function botones()
	{
		//echo "<form action='' method='get' name='botones'>\n";
		$html .=   "<table border='1'>
	  	<tr>
    	<td><input name='Filtrar' type='submit' id='Filtrar' value='Filtrar'></td>\n
	    <td><input name='Restablecer' type='submit' id='Restablecer' value='Restablecer'></td>\n
	    <td><input name='Regresar' type='submit' id='Regresar' value='Regresar'></td>\n
	    <td><input name='Exportar' type='submit' id='Exportar' value='Exportar'></td>\n
		";
		$html .= '
    	<td><div align="center"><input name="tipo_exp" type="radio" value="xls" checked></div></td>
	    <td><div align="center">XLS</div></td>
	    <td><div align="center"><input name="tipo_exp" type="radio" value="doc"></div></td>
    	<td><div align="center">DOC</div></td>
		  </tr>
		</table>
		';
		if(isset($_GET['ordenamiento']) and $_GET['ordenamiento']!="")
		{
			$html .= "<input type='hidden' name='ordenamiento' value='".$_GET['ordenamiento']."'>\n";
		}
		if(isset($_GET['orden']) and $_GET['orden']!="")
		{
			$html .= "<input type='hidden' name='orden' value='".$_GET['orden']."'>\n";
		}
		if(isset($_GET['Filtrar']))
		{
			$html .= "<input type='hidden' name='Filtrar' value='".$_GET['Filtrar']."'>\n";
		}

		//echo "<input type='hidden' name='Siguiente' value='".$_GET['Siguiente']."'>\n";
		return $html;
	}

	function imprimir_matriz($link="",$filtros="si",$numerar="no")
	{
		if($this->filtrayesno==true)
		{
			if($this->totales=='totales_matriz')
			{
				$this->totales=$this->totales_matriz($this->matriz_filtrada);
			}
			else if($this->totales=='totalizar')
			{
				$this->totales=$this->totalizar($this->matriz_filtrada);
			}
			$html .= $this->listar($this->matriz_filtrada,$this->titulo,$link,$filtros,$numerar);
		}
		else
		{

			if($this->totales=='totales_matriz')
			{
				$this->totales=$this->totales_matriz($this->matriz);
			}
			elseif($this->totales=='totalizar')
			{
				$this->totales=$this->totalizar($this->matriz);
			}
			$html .= $this->listar($this->matriz,$this->titulo,$link,$filtros,$numerar);
		}
		//var_dump($html);die;
		$html .= $this->tabla_arreglo_chulitos();
		//var_dump($html);die;
		return $html;
	}

	function emergente($arreglo,$formato,$nombrearchivo)
	{
		unset($_SESSION[$arreglo]);
		if($this->recortar==true)
		{
			$_SESSION[$arreglo]=$this->matriz_recortada;
		}
		elseif($this->filtrayesno==true)
		{
			$_SESSION[$arreglo]=$this->matriz_filtrada;
		}
		else
		{
			$_SESSION[$arreglo]=$this->matriz;
		}

		?><script language="javascript">window.open("funciones/exportar.php?nombre=<?php echo $nombrearchivo?>&formato=<?php echo $formato?>&arreglo=<?php echo $arreglo?>");</script><?php
	}

	function exportar_array($arreglo,$nombrearchivo,$formato)
	{
		//echo "<h1>$formato</h1>";
		$this->nombrearchivo=trim($nombrearchivo);
		switch ($formato)
		{
			case 'xls' :
				$strType = 'application/msexcel';
				$strName = $nombrearchivo.".xls";
				break;
			case 'doc' :
				$strType = 'application/msword';
				$strName = $nombrearchivo.".doc";
				break;
			case 'txt' :
				$strType = 'text/plain';
				$strName = $nombrearchivo.".txt";
				break;
			case 'csv' :
				$strType = 'text/plain';
				$strName = $nombrearchivo.".csv";
				break;
			case 'xml' :
				$strType = 'text/plain';
				$strName = $nombrearchivo.".xml";
				break;
			default :
				$strType = 'application/msexcel';
				$strName = $nombrearchivo.".xls";
				break;

		}
		header("Content-Type: $strType");
		header("Content-Disposition: attachment; filename=$strName\r\n\r\n");
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Pragma: public");
		$this->listar($arreglo,"","","no","no");
		return true;
	}

	/**
	 * Saca los totales para todas las llaves de la matriz
	 *
	 * @param unknown_type $matriz
	 * @return unknown
	 */
	function totales_matriz($matriz)
	{
		$this->totales='totales_matriz';
		foreach($this->matriz_llaves as $llave => $valor)
		{
			$total_array=$this->totalesxllave($matriz,$valor);
			$array_totales[$valor]=$total_array;
		}
		return($array_totales);
	}

	/**
	 * Funcion para informar a que llaves se les va a sacar el subtotal
	 *
	 * @param unknown_type $llave
	 */
	function agregar_llaves_totales($llave)
	{
		$this->totales='totalizar';
		$this->arreglo_llaves_totales[]=$llave;
	}

	/**
	 * totaliza las llaves seleccionadas con agregar_llaves_totales y llama a totales por llave
	 *
	 */
	function totalizar($matriz)
	{
		foreach ($this->arreglo_llaves_totales as $llave => $valor)
		{
			$total_array=$this->totalesxllave($matriz,$valor);
			$array_totales[$valor]=$total_array;
		}
		return $array_totales;
	}


	function totalesxllave($matriz,$llave)
	{
		$total=0;
		$this->llave=$llave;
		foreach ($matriz as $llave => $valor)
		{
			$total=$total+$valor[$this->llave];
		}
		return $total;
	}

}
?>