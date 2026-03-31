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
	function matriz($matriz,$titulo="",$archivo_origen="",$filtrasino="si",$numerarsino="no",$atras="")
	{
		error_reporting(0);
		$this->matriz=$matriz;
		$this->titulo=$titulo;
		$this->leer_llaves();
		$this->archivo_origen=$archivo_origen;
		$this->filtrasino=$filtrasino;
		$this->atras=$atras;
		$this->numerarsino=$numerarsino;
		$this->drill=false;


		$_SESSION['get']=$_GET;
		if(isset($_GET['orden']) and $_GET['orden']!="")
		{
			$_SESSION['orden']=$_GET['orden'];
		}
		if(isset($_GET['Filtrar']) and $_GET['Filtrar']!="")
		{
			$this->filtrasino(true,$_SESSION['get']);
			$this->ordenamiento($_GET['ordenamiento'],$_GET['orden']);
		}
		else
		{
			$this->ordenamiento($_GET['ordenamiento'],$_GET['orden']);
		}
		if(isset($_GET['Exportar']))
		{
			$_SESSION['tipo_exportacion']=$_GET['tipo_exp'];
			$this->filtrasino(true,$_SESSION['get']);
			$this->emergente('arreglo_exportacion',$_SESSION['tipo_exportacion'],$this->titulo);

		}
		if(isset($_POST['Exportar_recorte']))
		{
			$_SESSION['tipo_exportacion']=$_POST['tipo_exp'];
			$this->recortar($_POST);
			$this->emergente('arreglo_exportacion',$_SESSION['tipo_exportacion'],$this->titulo);
		}
		if(isset($_GET['Restablecer']))
		{
			unset($_SESSION['arreglo_exportacion']);
			unset($_SESSION['get']);
			unset($_SESSION['tipo_exportacion']);
			echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=$this->archivo_origen'>";
		}
		if(isset($_GET['Regresar']))
		{
			unset($_SESSION['get']);
			echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=$this->atras'>";
		}

	}

	function mostrar()
	{
		$this->script_globo();
		$this->imprimir_matriz($this->archivo_origen,$this->filtrasino,$this->numerarsino);
	}

	/**
	 * Este metodo carga los nombres de las llaves de la matriz, sirve en toda la clase, para operaciones relacionadas con las llaves
	 *
	 */

	function script_globo()
	{
		echo '<script type="text/javascript" src="funciones/globo.js"></script>';
		echo '<div id="tooltip2" style="position:absolute;visibility:hidden;clip:rect(0 150 50 0);width:150px;background-color:lightyellow"><layer name="nstip" width=1000px bgColor="lightyellow"></layer></div>';
	}

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
		//echo $matriz,$columna,$expresion,$criterio,"<br><br>";
		if(!is_array($matriz))
		{
			echo '<script language="javascript">alert("Filtro demasiado restrictivo, no hay datos para mostrar")</script>';
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

	function agregarllave_drilldown($nombrecolumna,$link_origen,$link_destino,$descripcion="",$llave,$cadenaadicional="",$variable="",$aliasvariable="",$mailto="",$textoglobo="",$javascript="")
	{

		if($nombrecolumna!="")
		{
			$drill_down['nombrecolumna']=$nombrecolumna;
			$drill_down['link_origen']=$link_origen;
			$drill_down['link_destino']=$link_destino;
			$drill_down['llave']=$llave;
			$drill_down['javascript']=$javascript;
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
			if($textoglobo!="")
			{
				$drill_down['globo']=$textoglobo;
			}
		}
		$this->array_drill_down[]=$drill_down;
		$this->drill=true;
		//$this->listar($this->array_drill_down);
	}
	function agregarllave_emergente($nombrecolumna,$link_origen,$link_destino,$ancho_ventana=400,$alto_ventana=200,$pos_x=50,$pos_y=50,$descripcion="",$llave,$cadenaadicional="",$variable="",$aliasvariable="",$textoglobo="",$javascript="")
	{
		$emergente['nombrecolumna']=$nombrecolumna;
		$emergente['link_origen']=$link_origen;
		$emergente['link_destino']=$link_destino;
		$emergente['llave']=$llave;
		$emergente['ancho_ventana']=$ancho_ventana;
		$emergente['alto_ventana']=$alto_ventana;
		$emergente['pos_x']=$pos_x;
		$emergente['pos_y']=$pos_Y;

		if($javascript!="")
		{
			$emergente['javascript']=$javascript;
		}
		if($descriptor=!"")
		{
			$emergente['descriptor']=$descripcion;
		}
		if($cadenaadicional!="")
		{
			$emergente['cadenaadicional']=$cadenaadicional;
		}
		if($variable!="")
		{
			$emergente['variable']=$variable;
		}
		if($aliasvariable!="")
		{
			$emergente['aliasvariable']=$aliasvariable;
		}
		if($textoglobo!="")
		{
			$emergente['globo']=$textoglobo;
		}
		$this->array_emergente[]=$emergente;
		$this->emergente=true;
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
				echo '<script language="javascript">alert("La Búsqueda no contiene ningún resultado")</script>';
				echo '<script language="javascript">history.go(-1)</script>';

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
					$this->matriz_recortada[$clave][$valorllaves]=$valor[$valorllaves];				}
			}
		}
		else
		{
			foreach ($llaves_seleccionadas as $llaves => $valorllaves)
			{
				foreach ($this->matriz as $clave => $valor)
				{
					$this->matriz_recortada[$clave][$valorllaves]=$valor[$valorllaves];
				}
			}
		}
	}

	function tabla_arreglo_chulitos()
	{
		$contador=1;
		echo "<form name='recortar' method='post' action=''>";
		echo "<table border='1' cellpadding='1' cellspacing='0' bordercolor='#E9E9E9'>\n";
		foreach ($this->matriz_llaves as $llave => $valor)
		{
			if($contador%4==0)
			{
				$contador=1;
				echo "<tr>\n";
			}
			echo "<td nowrap>$valor&nbsp;</td>\n";
			if($_POST["sel".$valor]==$valor)
			{
				$chequear="checked";
			}
			else
			{
				$chequear="";
			}
			echo "<td><input type='checkbox'  name='sel".$valor."' $chequear value='".$valor."'></td>\n";

			if($contador%4==0)
			{
				$contador=1;
				echo "</tr>\n";
			}
			$contador++;
		}
		echo "<tr><td><table border='1' cellpadding='1' cellspacing='0' bordercolor='#E9E9E9'>
		<tr><td><input name='Exportar_recorte' type='submit' id='Exportar_recorte' value='Exportar'></td>
    	<td><div align='center'><input name='tipo_exp' type='radio' value='xls' checked></div></td>
	    <td><div align='center'>XLS</div></td>
	    <td><div align='center'><input name='tipo_exp' type='radio' value='doc'></div></td>
    	<td><div align='center'>DOC</div></td>
		</tr>\n";
		echo "</table>\n";
		echo "</table>\n";
		echo "</form>\n";
	}

	function escribir_filtros($matriz)
	{
		//error_reporting(0);
		echo "<tr>\n";
		if($this->numerar=='si')
		{
			echo "<td id='tituloverde'>&nbsp;</td>\n";
		}
		while($elemento = each($matriz))
		{
			echo "<td align='CENTER' id='tituloverde'><input name='$elemento[0]' type='text' size='15' value='".$_SESSION['get'][$elemento[0]]."'><br>
		<select name='f_$elemento[0]' id='f_$elemento[0]'>
        <option value='like'"; if($_SESSION['get']['f_'.$elemento[0]]=='like'){echo 'Selected';}echo ">like</option>
        <option value='<>'"; if($_SESSION['get']['f_'.$elemento[0]]=='<>'){echo 'Selected';}echo "><></option>
        <option value='='"; if($_SESSION['get']['f_'.$elemento[0]]=='='){echo 'Selected';}echo ">=</option>
        <option value='>'"; if($_SESSION['get']['f_'.$elemento[0]]=='>'){echo 'Selected';}echo ">></option>
        <option value='>='"; if($_SESSION['get']['f_'.$elemento[0]]=='>='){echo 'Selected';}echo ">>=</option>
        <option value='<'"; if($_SESSION['get']['f_'.$elemento[0]]=='<'){echo 'Selected';}echo "><</option>
        <option value='<='"; if($_SESSION['get']['f_'.$elemento[0]]=='<='){echo 'Selected';}echo "><=</option>
        </select>
		</td>\n";
		}
		echo "</tr>\n";
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
		echo "<tr>\n";
		if($this->numerar=='si')
		{
			echo "<td align='CENTER' id='tdtitulogris'>No</td>\n";
		}
		while($elemento = each($matriz))
		{
			if($href=="")
			{
				echo "<td align='CENTER'>$elemento[0]</a></td>\n";
			}

			else
			{
				echo "<td align='CENTER' id='tdtitulogris'><a href='$href&ordenamiento=$elemento[0]&orden=";if(!isset($_GET['orden'])){echo "desc";}if($_GET['orden']=="asc"){echo "desc";}if($_GET['orden']=="desc"){echo "asc";};echo $cadena_a.$cadena_b;
				if(isset($_GET['Filtrar']) and $_GET['Filtrar']!="")
				{
					echo "&Filtrar=Filtrar";
				}
				if(isset($_GET['Exportar']) and $_GET['Exportar']!="")
				{
					//echo "&Exportar=Exportar";
				}

				echo "'>$elemento[0]</a></td>\n";
			}
		}
		echo "</tr>\n";
	}

	function listar($matriz="",$texto="",$link="",$filtros="si",$numerar="no",$totalizar="no")
	{
		$this->numerar=$numerar;
		$no=1;
		echo "<form name='form1' method='get' action=''>";
		echo "<table border='1' cellpadding='1' cellspacing='0' bordercolor='#E9E9E9'>\n";
		if($texto!="")
		{
			echo "<caption align=TOP><h4>$texto</h4></caption>";
		}
		$this->escribir_cabeceras($matriz[0],$link);
		if($filtros=="si")
		{
			$this->escribir_filtros($matriz[0]);
		}
		for($i=0; $i < count($matriz); $i++)
		{
			echo "<tr>\n";
			if($numerar=="si")
			{
				echo "<td>$no</td>\n";
			}
			$no++;
			while($elemento=each($matriz[$i]))
			{
				$bandera_drill_down=false;
				$bandera_emergente=false;
				if(is_array($this->array_drill_down))
				{
					foreach ($this->array_drill_down as $llave => $valor)
					{
						if($elemento[0]==$valor['nombrecolumna'])
						{
							unset($mail);
							unset($globo);
							unset($javascript);
							$bandera_drill_down=true;
							if($valor['mailto']!="")
							{
								$mail="<td nowrap><a href='mailto:".$matriz[$i][$valor['mailto']]."'>".$matriz[$i][$valor['mailto']]."</a>";
							}

							$cadena="<td nowrap><a href=".$valor['link_destino'].'?link_origen='.$valor['link_origen'];
							if($valor['javascript']!="")
							{
								$javascript=' '.$valor['javascript'];
							}

							if($valor['globo']!="")
							{
								$globo=" onMouseover='showtip2(this,event,".'"'.$valor['globo'].'"'.")' onMouseout='hidetip2()'";
							}
							elseif($this->globogeneral==true)
							{
								$globo=" onMouseover='showtip2(this,event,".'"'.$matriz[$i][$this->globogeneral].'"'.")' onMouseout='hidetip2()'";
							}
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
							$final=">".$elemento[1]."</a>\n";

							if($mail!="")
							{
								echo $mail;
							}
							elseif($valor['variable']!="")
							{
								echo $cadena.$complemento.$cadenaadicional.$descriptor.$variable.$globo.$javascript.$final."\n";
							}
							else
							{
								echo $cadena.$complemento.$cadenaadicional.$descriptor.$globo.$javascript.$final."\n";
							}

							//echo "<td nowrap><a href=".$valor['link_destino'].'?link_origen='.$valor['link_origen'].'&'.$valor['llave'].'='.$matriz[$i][$valor['llave']].">$elemento[1]</a>";
						}
					}
				}
				elseif (is_array($this->array_emergente))
				{
					foreach ($this->array_emergente as $llave => $valor)
					{
						if($elemento[0]==$valor['nombrecolumna'])
						{
							unset($globo);
							unset($javascript);
							$bandera_drill_down=true;
							/* window.open(pagina,ventana,parametros); */
							/*<a href="grupomateria_form.php" onclick="abrir('grupomateria_detalle.php?idgrupomateria=<?php echo $grupomateria->idgrupomateria?>&codigoperiodo=<?php echo $_GET['codigoperiodo']?>','Formgrupomateria','width=400,height=200,top=50,left=50,scrollbars=yes');return false"><?php echo $grupomateria->idgrupomateria?></a>*/
							$cadena="<td nowrap><a href=".$valor['link_destino'].'?link_origen='.$valor['link_origen'];
							$emergente=" onClick=window.open('".$valor['link_destino'].",'".ereg_replace(".php","",$valor['link_destino'])."'"."'width=".$valor['ancho'].",height=".$valor['alto'].",top=".$valor['posx'].",left=".$valor['posy']."";
							if($valor['javascript']!="")
							{
								$javascript=' '.$valor['javascript'];
							}
							if($valor['globo']!="")
							{
								$globo=" onMouseover='showtip2(this,event,".'"'.$valor['globo'].'"'.")' onMouseout='hidetip2()'";
							}
							elseif($this->globogeneral==true)
							{
								$globo=" onMouseover='showtip2(this,event,".'"'.$matriz[$i][$this->globogeneral].'"'.")' onMouseout='hidetip2()'";
							}
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
							$final=">".$elemento[1]."</a>\n";

							if($valor['variable']!="")
							{
								echo $cadena.$complemento.$cadenaadicional.$descriptor.$emergente.$variable.$globo.$javascript.$final."\n";
							}
							else
							{
								echo $cadena.$complemento.$cadenaadicional.$descriptor.$emergente.$globo.$javascript.$final."\n";
							}

							//echo "<td nowrap><a href=".$valor['link_destino'].'?link_origen='.$valor['link_origen'].'&'.$valor['llave'].'='.$matriz[$i][$valor['llave']].">$elemento[1]</a>";
						}
					}

				}

				if($bandera_drill_down==false)
				{
					echo "<td nowrap>$elemento[1]</td>\n";
				}
				elseif ($bandera_emergente==false)
				{
					//echo "<td nowrap>$elemento[1]&nbsp;</td>\n";
				}
			}
		}
		echo "</tr>\n";
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
			echo "<tr>\n";
			$colspan=count($this->matriz_llaves)+$suma;
			{
				echo "<td colspan='$colspan'><div align='center'><font size='+1'>Subtotales</font></div></td>";
			}
			echo "</tr>\n";
			echo "<tr>\n";
			for($i=0;$i <= count($this->matriz_llaves)-$resta;$i++)
			{
				if($this->totales[$i]['link_destino']!="" and $this->totales[$i]['link_origen']!="" and $this->totales[$i]['descripcion']!="")
				{
					echo "<td>";echo "<a href='".$this->totales[$i]['link_destino']."?totales&link_origen=".$this->totales[$i]['link_origen']."&descriptor=".$this->totales[$i]['descripcion']."&".$this->totales[$i]['cadenaadicional']."'>".$this->totales[$i]['total']."</a>";echo "</td>";
				}
				else
				{
					echo "<td>";echo $this->totales[$i]['total'];echo "</td>";
				}


				/*foreach ($this->totales as $llave => $valor)
				{
				if($this->matriz_llaves[$i]==$valor['llave'])
				{
				echo "<td>";echo $valor['llave'];echo "</td>";
				}
				else
				{
				//echo "<td></td>";
				}
				}*/
			}
			echo "</tr>\n";
		}
		echo "</table>\n";
		if($filtros=="si")
		{
			$this->botones();
		}
		echo "</form>\n";
	}

	function botones()
	{
		//echo "<form action='' method='get' name='botones'>\n";
		echo   "<table border='1' cellpadding='1' cellspacing='0' bordercolor='#E9E9E9'>
	  	<tr>
    	<td><input name='Filtrar' type='submit' id='Filtrar' value='Filtrar'></td>\n
	    <td><input name='Restablecer' type='submit' id='Restablecer' value='Restablecer'></td>\n
	    <td><input name='Regresar' type='button' id='Regresar' value='Regresar' onClick='reCarga(".'"'.$this->atras.'"'.");'></td>\n
	    <td><input name='Exportar' type='submit' id='Exportar' value='Exportar'></td>\n
		";
		echo '
    	<td><div align="center"><input name="tipo_exp" type="radio" value="xls" checked></div></td>
	    <td><div align="center">XLS</div></td>
	    <td><div align="center"><input name="tipo_exp" type="radio" value="doc"></div></td>
    	<td><div align="center">DOC</div></td>
		  </tr>
		</table>
		';
		if(isset($_GET['ordenamiento']) and $_GET['ordenamiento']!="")
		{
			echo "<input type='hidden' name='ordenamiento' value='".$_GET['ordenamiento']."'>\n";
		}
		if(isset($_GET['orden']) and $_GET['orden']!="")
		{
			echo "<input type='hidden' name='orden' value='".$_GET['orden']."'>\n";
		}
		if(isset($_GET['Filtrar']))
		{
			echo "<input type='hidden' name='Filtrar' value='".$_GET['Filtrar']."'>\n";
		}
		if(isset($_GET['tabla']))
		{
			echo "<input type='hidden' name='tabla' value='".$_GET['tabla']."'>\n";
		}
		//echo "<input type='hidden' name='Siguiente' value='".$_GET['Siguiente']."'>\n";
	}

	function imprimir_matriz($link="",$filtros="si",$numerar="no")
	{
		if($this->filtrayesno==true)
		{
			if($this->totales=='totales_matriz')
			{
				$this->totales=$this->totales_matriz($this->matriz_filtrada);
			}
			elseif($this->totales=='totalizar')
			{
				$this->totales=$this->totalizar($this->matriz_filtrada);
			}
			$this->listar($this->matriz_filtrada,$this->titulo,$link,$filtros,$numerar);
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
			$this->listar($this->matriz,$this->titulo,$link,$filtros,$numerar);
		}
		$this->tabla_arreglo_chulitos();
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
	function agregar_llaves_totales($llave,$link_origen="",$link_destino="",$descripcion="",$cadenaadicional="",$variable="",$aliasvariable="",$textoglobo="")
	{
		$this->totales='totalizar';
		$llaves_totales['llave']=$llave;
		$llaves_totales['link_origen']=$link_origen;
		$llaves_totales['link_destino']=$link_destino;
		$llaves_totales['descripcion']=$descripcion;
		$llaves_totales['cadenaadicional']=$cadenaadicional;
		$llaves_totales['variable']=$variable;
		$llaves_totales['aliasvariable']=$aliasvariable;
		$llaves_totales['textoglobo']=$textoglobo;
		$this->arreglo_llaves_totales[]=$llaves_totales;
	}

	function agregar_llaves_globo_texto($llave)
	{
		$this->globo=true;
		$this->arreglo_llaves_globos[]=$llave;
	}

	function definir_llave_globo_general($llave)
	{
		$this->globogeneral==true;
		$this->globogeneral=$llave;
	}


	/**
	 * totaliza las llaves seleccionadas con agregar_llaves_totales y llama a totales por llave
	 *
	 */
	function totalizar($matriz)
	{
		//foreach ($this->arreglo_llaves_totales as $llave => $valor)
		foreach ($this->matriz_llaves as $llave => $valor)
		{
			foreach ($this->arreglo_llaves_totales as $llave_totales => $valor_totales)
			{
				if($valor_totales['llave']==$valor)
				{
					$total_array=$this->totalesxllave($matriz,$valor_totales['llave']);
					$array_totales[$llave]['llave']=$valor;
					$array_totales[$llave]['total']=$total_array;
					$array_totales[$llave]['link_origen']=$valor_totales['link_origen'];
					$array_totales[$llave]['link_destino']=$valor_totales['link_destino'];
					$array_totales[$llave]['descripcion']=$valor_totales['descripcion'];
					$array_totales[$llave]['cadenaadicional']=$valor_totales['cadenaadicional'];
					$array_totales[$llave]['variable']=$valor_totales['variable'];
					$array_totales[$llave]['aliasvariable']=$valor_totales['aliasvariable'];
					$array_totales[$llave]['textoglobo']=$valor_totales['textoglobo'];
				}
			}
		}
		//print_r($array_totales);
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
	function MuestraBotonVentanaEmergente($nombre,$destino,$variablesGet="",$width=300,$height=300,$top=200,$left=150,$scrollbars="yes",$resizable="yes",$toolbar="no",$status="no",$menu="no")
	{
		$emergente='<input type="button" name="'.$nombre.'" value="'.$nombre.'" onClick="window.open('."'".$destino.'?'.$variablesGet."','$nombre'".",'width=".$width.",height=".$height.",top=".$top.",left=".$left.",scrollbars=$scrollbars,toolbar=$toolbar,resizable=$resizable,status=$status,menu=$menu');".'"'.">";
		echo $emergente;
	}
}
?>