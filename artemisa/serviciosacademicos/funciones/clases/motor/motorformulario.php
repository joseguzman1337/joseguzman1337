<?php
/**
 * Esta clase, es el motor de informes, recibe una matriz bidimensional cualquiera, y dibuja filtros, efectúa ordenamientos, y exporta a excel
7 *
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
	var $matriz;
	var $titulo;
	var $leer_llaves;
	var $archivo_origen;
	var $filtrasino;
	var $atras;
	var $numerarsino;
	var $ordenasino;
	var $drill;
	var $llave_principal_edicion;
	var $llave_secundaria_edicion;
	var $link_destino_edicion;
	var $emergentes_edicion=false;
	var $mostrar_boton_agregar=true;
	var $mostrar_boton_editar=true;
	var $mostrar_boton_borrar=true;
	var $mostrar_botones_edicion=false;
	var $cadena_emergente;
	var $width=300;
	var $height=300;
	var $top=200;
	var $left=150;
	var $scrollbars="yes";
	var $resizable="yes";
	var $toolbar="no";
	var $status="no";
	var $menu="no";
	var $javascript="";
	var $array_drill_down;
	var $array_drill_down_emergente;
	var $matriz_recortada;
	var $matriz_filtrada;
	var $MatrizRecortada;
	var $wrap="noWrap";
	var $align="Left";
	var $nbsp="";

	function matriz($matriz,$titulo="",$archivo_origen="",$filtrasino="si",$numerarsino="no",$atras="",$link_recarga="",$origen_x_sesion=true,$ordenasino="si")
	{
		error_reporting(0);
		$this->matriz=$matriz;
		$this->titulo=$titulo;
		$this->leer_llaves();
		$this->archivo_origen=$archivo_origen;
		$this->filtrasino=$filtrasino;
		$this->atras=$atras;
		$this->numerarsino=$numerarsino;
		$this->ordenasino=$ordenasino;
		$this->drill=false;
		$_SESSION['get']=$_GET;

		if(isset($_GET['Recargar']) and $_GET['Recargar']!="")
		{
			if($origen_x_sesion==false)
			{
				echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=$REQUEST_URI'>";
			}
			else
			{
				$this->recargar($link_recarga);
			}
		}

		if(isset($_GET['Regresar']))
		{
			if(isset($_SESSION['archivo_ejecuta_recarga']) and is_array($_SESSION['array_recarga']))
			{
				unset($_SESSION['get']);
				$this->retornar_menu($atras);
			}
			else
			{
				unset($_SESSION['get']);
				echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=$this->atras'>";
			}
		}

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
			$this->llamarEmergenteParaExportar('arreglo_exportacion',$_SESSION['tipo_exportacion'],$this->titulo);

		}
		if(isset($_POST['Exportar_recorte']))
		{
			$_SESSION['tipo_exportacion']=$_POST['tipo_exp'];
			
			$this->recortar($_POST);
			$this->CreaArrayRecortadoSesionParaExportar();
			$this->llamarEmergenteParaExportar('arreglo_exportacion',$_SESSION['tipo_exportacion'],$this->titulo);
		}
		if(isset($_GET['Restablecer']))
		{
			$this->resetearVariablesSesion();
			echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=$this->archivo_origen'>";
		}
		if(isset($_REQUEST['Recortar']))
		{
			//en depuracion, todavía molesta
			if(!isset($_SESSION['post']))
			{
				$this->recortar($_POST);
				$this->CreaArrayRecortadoSesionParaMostrar();
			}
			else
			{
				$this->recortar($_SESSION['post']);
				$this->CreaArrayRecortadoSesionParaMostrar();
			}
		}
	}
	
	function asignarNbsp($nbsp="&nbsp;")
	{
		$this->nbsp=$nbsp;
	}
	
	function asignarWrap($wrap="noWrap")
	{
		$this->wrap=$wrap;	
	}
	
	function asignarAlign($align="left")
	{
		$this->align=$align;
	}
	function asignarJavascripttabla($javascripttabla=""){
		$this->javascripttabla=$javascripttabla;
	}
	function resetearVariablesSesion()
	{
		unset($_SESSION['arreglo_exportacion']);
		unset($_SESSION['get']);
		unset($_SESSION['tipo_exportacion']);
		unset($_SESSION['post']);
		unset($_SESSION['array_recortado']);
	}

	function ObtenerArrayRecorte()
	{
		return $this->matriz_recortada;
	}

	function LLamaBotonesEdicion($llave_principal_edicion,$llave_secundaria_edicion,$link_destino_edicion,$emergentes_edicion=false,$mostrar_boton_agregar=true,$mostrar_boton_editar=true,$mostrar_boton_borrar=true)
	{
		$this->mostrar_botones_edicion=true;
		$this->llave_principal_edicion=$llave_principal_edicion;
		$this->llave_secundaria_edicion=$llave_secundaria_edicion;
		$this->link_destino_edicion=$link_destino_edicion;
		$this->emergentes_edicion=$emergentes_edicion;
		$this->mostrar_boton_agregar=$mostrar_boton_agregar;
		$this->mostrar_boton_borrar=$mostrar_boton_borrar;
		$this->mostrar_boton_editar=$mostrar_boton_editar;
	}

	function ParametrizaEmergenteLlamaBototesEdicion($width=300,$height=300,$top=200,$left=150,$scrollbars="yes",$resizable="yes",$toolbar="no",$status="no",$menu="no",$javascript="")
	{
		$this->width=$width;
		$this->height=$height;
		$this->top=$top;
		$this->toolbar=$toolbar;
		$this->left=$left;
		$this->scrollbars=$scrollbars;
		$this->resizable=$resizable;
		$this->toolbar=$toolbar;
		$this->status=$status;
		$this->menu=$menu;
		$this->javascript=$javascript;
	}


	function mostrar()
	{
		$this->script_globo();
		$this->imprimir_matriz($this->archivo_origen,$this->filtrasino,$this->numerarsino,$this->wrap,$this->align,$this->nbsp);
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

	function OrdenarMatriz(&$matriz,$columna,$orden,$activaBool=false)
	{
		if($activaBool==true)
		{
			$this->ordenamiento=true;
		}
		foreach($matriz as $llave => $fila)
		{
			$arreglo_interno[$llave] = $fila[$columna];
		}
		if($orden=="ASC" or $orden=="asc")
		{
			$this->orden="ASC";
			array_multisort($arreglo_interno, SORT_ASC, $matriz);
		}
		elseif($orden=="DESC" or $orden=="desc")
		{
			$this->orden="DESC";
			array_multisort($arreglo_interno, SORT_DESC, $matriz);
		}
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
	function agregarllave_emergente($nombrecolumna,$link_origen,$link_destino,$descripcion="",$llave,$cadenaadicional="",$width=300,$height=300,$top=200,$left=150,$scrollbars="yes",$resizable="yes",$toolbar="no",$status="no",$menu="no",$variable="",$aliasvariable="",$textoglobo="",$javascript="")
	{
		if($nombrecolumna!="")
		{
			$drill_down_emergente['nombrecolumna']=$nombrecolumna;
			$drill_down_emergente['link_origen']=$link_origen;
			$drill_down_emergente['link_destino']=$link_destino;
			$drill_down_emergente['llave']=$llave;
			$drill_down_emergente['javascript']=$javascript;
			$drill_down_emergente['width']=$width;
			$drill_down_emergente['height']=$height;
			$drill_down_emergente['top']=$top;
			$drill_down_emergente['left']=$left;
			$drill_down_emergente['scrollbars']=$scrollbars;
			$drill_down_emergente['resizable']=$resizable;
			$drill_down_emergente['toolbar']=$toolbar;
			$drill_down_emergente['status']=$status;
			$drill_down_emergente['menu']=$menu;
			if($descriptor=!"")
			{
				$drill_down_emergente['descriptor']=$descripcion;
			}
			if($cadenaadicional!="")
			{
				$drill_down_emergente['cadenaadicional']=$cadenaadicional;
			}
			if($variable!="")
			{
				$drill_down_emergente['variable']=$variable;
			}
			if($aliasvariable!="")
			{
				$drill_down_emergente['aliasvariable']=$aliasvariable;
			}
			if($textoglobo!="")
			{
				$drill_down_emergente['globo']=$textoglobo;
			}
		}
		$this->array_drill_down_emergente[]=$drill_down_emergente;
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

	function retornar_menu($link_destino)
	{
		$cadena=$link_destino."?";
		foreach ($_SESSION['array_recarga'] as $llave => $valor)
		{
			$get=$get.$valor['variable']."=".$valor['valor_variable']."&";
		}
		$link_recarga=$cadena.$get;
		echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=$link_recarga'>";
		//echo '<script language="javascript">window.location.reload("'.$link_recarga.'")</script>';
	}

	function recargar($link_destino) //este metodo no vuela variables de sesion, como si lo hace restablecer
	{
		$cadena=$link_destino."?";
		foreach ($_SESSION['array_recarga'] as $llave => $valor)
		{
			$get=$get.$valor['variable']."=".$valor['valor_variable']."&";
		}
		$link_recarga=$cadena.$get."&Enviar";
		echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=$link_recarga'>";
		//echo '<script language="javascript">window.location.reload("'.$link_recarga.'")</script>';
	}

	function recortar($post)
	{
		$this->recortar=true;
		$this->MatrizRecortada=true;
		
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

			if(!isset($_POST['Recortar']))
			{
				if($_SESSION['post']["sel".$valor]==$valor)
				{
					$chequear="checked";
				}
				else
				{
					$chequear="";
				}

			}
			else
			{
				$_SESSION['post']=$_POST;
				if($_POST["sel".$valor]==$valor)
				{
					$chequear="checked";
				}
				else
				{
					$chequear="";
				}
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
		<td><input name='Recortar' type='submit' id='Recortar' value='Recortar'></td>
    	<td><div align='center'><input name='tipo_exp' type='radio' value='xls' checked></div></td>
	    <td><div align='center'>XLS</div></td>
	    <td><div align='center'><input name='tipo_exp' type='radio' value='doc'></div></td>
    	<td><div align='center'>DOC</div></td>
		</tr>\n";
		echo "</table>\n";
		echo "</table>\n";
		echo "</form>\n";
	}

	function escribir_filtros($matriz,$wrap="noWrap")
	{
		//error_reporting(0);
		echo "<tr>\n";
		if($this->numerar=='si')
		{
			echo "<td $wrap id='tituloverde'>&nbsp;</td>\n";
		}
		while($elemento = each($matriz))
		{
			echo "<td $wrap align='CENTER' id='tituloverde'><input name='$elemento[0]' type='text' size='15' value='".$_SESSION['get'][$elemento[0]]."'><br>
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

	function escribir_cabeceras($matriz,$href,$wrap="noWrap")
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
			echo "<td $wrap align='CENTER' id='tdtitulogris'>No</td>\n";
		}
		while($elemento = each($matriz))
		{
			if($href=="")
			{
				echo "<td $wrap align='CENTER'>$elemento[0]</a></td>\n";
			}

			else
			{
				echo "<td $wrap align='CENTER' id='tdtitulogris'><a href='$href?ordenamiento=$elemento[0]&orden=";if(!isset($_GET['orden'])){echo "desc";}if($_GET['orden']=="asc"){echo "desc";}if($_GET['orden']=="desc"){echo "asc";};echo $cadena_a.$cadena_b;
				if(isset($_GET['Filtrar']) and $_GET['Filtrar']!="")
				{
					echo "&Filtrar=Filtrar";
				}
				if(isset($_REQUEST['Recortar']) and $_REQUEST['Recortar']!="")
				{
					echo "&Recortar=Recortar";
				}

				echo "'>$elemento[0]</a></td>\n";
			}
		}

		echo "</tr>\n";
	}

	function listar($matriz="",$texto="",$link="",$filtros="si",$numerar="no",$totalizar="no",$campos_edicion="no",$wrap="noWrap",$align="left",$nbsp="")
	{
		$this->numerar=$numerar;
		$no=1;
		echo "<form name='form1' method='get' action=''>";
		echo "<table border='1' cellpadding='1' cellspacing='0' bordercolor='#E9E9E9' ".$this->javascripttabla.">\n";
		if($texto!="")
		{
			echo "<caption align=TOP><h4>$texto</h4></caption>";
		}
		if($this->ordenasino=="no")
		{
			$this->EscribirCabecerasTabla($matriz[0],$wrap);
		}
		elseif($campos_edicion=="si")//si se quieren mostrar botones de editar,quitar y eliminar
		{
			$this->EscribirCabecerasTablaAgregarEditarEliminar($matriz[0]);
		}
		else
		{
			$this->escribir_cabeceras($matriz[0],$link,$wrap);
		}
		if($filtros=="si")
		{
			$this->escribir_filtros($matriz[0],$wrap);
		}
		for($i=0; $i < count($matriz); $i++)
		{
			echo "<tr>\n";
			if($numerar=="si")
			{
				echo "<td  align=$align $wrap>$no</td>\n";
			}
			$no++;
			while($elemento=each($matriz[$i]))
			{
				$bandera_drill_down=false;
				$bandera_drill_down_emergente=false;

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
								$mail="<td  align=$align $wrap><a href='mailto:".$matriz[$i][$valor['mailto']]."'>".$matriz[$i][$valor['mailto']]."</a>";
							}

							$cadena="<td  align=$align $wrap><a href=".$valor['link_destino'].'?link_origen='.$valor['link_origen'];
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
				elseif (is_array($this->array_drill_down_emergente))
				{
					foreach ($this->array_drill_down_emergente as $llave => $valor)
					{
						if($elemento[0]==$valor['nombrecolumna'])
						{
							unset($mail);
							unset($globo);
							unset($javascript);
							$bandera_drill_down_emergente=true;
							if($valor['mailto']!="")
							{
								$mail="<td align=$align $wrap><a href='mailto:".$matriz[$i][$valor['mailto']]."'>".$matriz[$i][$valor['mailto']]."</a>";
							}

							$cadena="<td align=$align $wrap><a href="."'".$valor['link_destino'].'?link_origen='.$valor['link_origen'];
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

							$onClick=' onClick="'.'window.open('."'".$valor['link_destino'].'?'.$complemento.$cadenaadicional.$descriptor.$variable."','".$valor['nombre']."'".",'width=".$valor['width'].",height=".$valor['height'].",top=".$valor['top'].",left=".$valor['left'].",scrollbars=".$valor['scrollbars'].",toolbar=".$valor['toolbar'].",resizable=".$valor['resizable'].",status=".$valor['status'].",menu=".$valor['menu']."'".");return false".'"';

							if($mail!="")
							{
								echo $mail;
							}
							elseif($valor['variable']!="")
							{
								echo $cadena.$complemento.$cadenaadicional.$descriptor.$variable."'".$globo.$onClick.$javascript.$final."\n";
							}
							else
							{
								echo $cadena.$complemento.$cadenaadicional.$descriptor."'".$globo.$onClick.$javascript.$final."\n";
							}
						}
					}

				}

				if($bandera_drill_down==false and $bandera_drill_down_emergente==false)
				{
					echo "<td align=$align $wrap>$elemento[1]$nbsp</td>\n";
				}
			}
			//botones_col_botones_edicion
			if($this->mostrar_botones_edicion==true)
			{
				$cadena_emergente="";
				if($this->mostrar_boton_agregar==true)
				{
					if($this->emergentes_edicion==true)
					{
						$cadena_emergente=' onClick="window.open('.$this->link_destino_edicion.'?adicionar&'.$this->llave_principal_edicion.'='.$this->matriz[$i][$this->llave_principal_edicion].'&'.$this->llave_secundaria_edicion.'='.$this->matriz[$i][$this->llave_secundaria_edicion].'",width="'.$this->width.'",height="'.$this->height.'",top="'.$this->top.'",left="'.$this->left.'",scrollbars="'.$this->scrollbars.'",toolbar="'.$this->toolbar.'",resizable="'.$this->resizable.'",status="'.$this->status.'",menu="'.$this->menu."')";
					}
					echo '<td '.$wrap.' align='.$align.'><a href="'.$this->link_destino_edicion.'?adicionar&'.$this->llave_principal_edicion.'='.$this->matriz[$i][$this->llave_principal_edicion].'&'.$this->llave_secundaria_edicion.'='.$this->matriz[$i][$this->llave_secundaria_edicion].'"><img src="imagenes/adicionar.png" width="23" height="23" border="0"></a>&nbsp;</td>'."\n";
				}
				if($this->mostrar_boton_editar==true)
				{
					echo '<td '.$wrap.' align='.$align.'><a href="'.$this->link_destino_edicion.'?editar&'.$this->llave_principal_edicion.'='.$this->matriz[$i][$this->llave_principal_edicion].'&'.$this->llave_secundaria_edicion.'='.$this->matriz[$i][$this->llave_secundaria_edicion].'"><img src="imagenes/editar.png" width="23" height="23" border="0"></a>&nbsp;</td>'."\n";
				}
				if($this->mostrar_boton_borrar==true)
				{
					echo '<td '.$wrap.' align='.$align.'><a href="'.$this->link_destino_edicion.'?eliminar&'.$this->llave_principal_edicion.'='.$this->matriz[$i][$this->llave_principal_edicion].'&'.$this->llave_secundaria_edicion.'='.$this->matriz[$i][$this->llave_secundaria_edicion].'"><img src="imagenes/eliminar.png" width="23" height="23" border="0"></a>&nbsp;</td>'."\n";
				}
			}
			//botones_col_botones_edicion
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
				echo "<td align='$align' '$wrap' colspan='$colspan'><div align='center'><font size='+1'>Subtotales</font></div></td>";
			}
			echo "</tr>\n";
			echo "<tr>\n";
			for($i=0;$i <= count($this->matriz_llaves)-$resta;$i++)
			{
				if($this->totales[$i]['link_destino']!="" and $this->totales[$i]['link_origen']!="" and $this->totales[$i]['descripcion']!="")
				{
					if($this->totales[$i]['textoglobo']<>"")
					{
						$globo=" onMouseover='showtip2(this,event,".'"'.$this->totales[$i]['textoglobo'].'"'.")' onMouseout='hidetip2()'";
					}
					echo "<td>";echo "<a href='".$this->totales[$i]['link_destino']."?totales&link_origen=".$this->totales[$i]['link_origen']."&descriptor=".$this->totales[$i]['descripcion']."&".$this->totales[$i]['cadenaadicional']."'$globo>".$this->totales[$i]['total']."</a>";echo "</td>";
				}
				else
				{
					echo "<td align=$align $wrap>";echo $this->totales[$i]['total'];echo "</td>";
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
	    <td><input name='Recargar' type='submit' id='Recargar' value='Recargar'></td>\n
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
		if(isset($_GET['Recargar']))
		{
			echo "<input type='hidden' name='Recargar' value='".$_GET['Recargar']."'>\n";
		}
		if(isset($_REQUEST['Recortar']))
		{
			//echo "<input type='hidden' name='Recortar' value='".$_POST['Recortar']."'>\n";
		}
		//echo "<input type='hidden' name='Siguiente' value='".$_GET['Siguiente']."'>\n";
	}

	function imprimir_matriz($link="",$filtros="si",$numerar="no",$wrap="noWrap",$align="left",$nbsp="")
	{
		if(isset($_SESSION['array_recortado']))
		{
			if($this->totales=='totales_matriz')
			{
				//$this->totales=$this->totales_matriz($this->matriz_recortada);//depurar, todavia falla
			}
			elseif($this->totales=='totalizar')
			{
				//$this->totales=$this->totalizar($this->matriz_recortada);//depurar, todavia falla
			}
			//chambonada temporal, según el diseño es el metodo ordenamiento el que debe hacer eso automatico, si existe una matriz recortada
			//$this->OrdenarMatriz($_SESSION['array_recortado'],$_GET['ordenamiento'],$_GET['orden']);
			$this->listar($_SESSION['array_recortado'],$this->titulo,$link,$filtros,$numerar,"no","no",$wrap,$align,$nbsp);
		}

		elseif($this->filtrayesno==true)
		{
			if($this->totales=='totales_matriz')
			{
				$this->totales=$this->totales_matriz($this->matriz_filtrada);
			}
			elseif($this->totales=='totalizar')
			{
				$this->totales=$this->totalizar($this->matriz_filtrada);
			}
			$this->listar($this->matriz_filtrada,$this->titulo,$link,$filtros,$numerar,"no","no",$wrap,$align,$nbsp);
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
			$this->listar($this->matriz,$this->titulo,$link,$filtros,$numerar,"no","no",$wrap,$align,$nbsp,$javascriptabla);
		}
		$this->tabla_arreglo_chulitos();
	}

	function llamarEmergenteParaExportar($arreglo,$formato,$nombrearchivo)
	{
		unset($_SESSION[$arreglo]);
		if($this->MatrizRecortada==true)
		{
			$_SESSION[$arreglo]=$_SESSION['array_recortado_exportar'];
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

	function CreaArrayRecortadoSesionParaMostrar()
	{
		if($this->recortar==true)
		{
			$_SESSION['array_recortado']=$this->matriz_recortada;
		}
		elseif($this->filtrayesno==true)
		{
			$_SESSION['array_recortado']=$this->matriz_filtrada;
		}
		else
		{
			$_SESSION['array_recortado']=$this->matriz;
		}
	}
	
	function CreaArrayRecortadoSesionParaExportar()
	{
		if($this->recortar==true)
		{
			$_SESSION['array_recortado_exportar']=$this->matriz_recortada;
		}
		elseif($this->filtrayesno==true)
		{
			$_SESSION['array_recortado_exportar']=$this->matriz_filtrada;
		}
		else
		{
			$_SESSION['array_recortado_exportar']=$this->matriz;
		}
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


	function SumatoriaColumnaArrayBidimensional($columna,$array)
	{
		$acumulador=0;
		foreach ($array as $llave => $valor)
		{
			$acumulador=$acumulador + $valor[$columna];
		}
		return $acumulador;
	}

	function EliminarColumnaArrayBidimensional($columna,$array)
	{
		foreach ($array as $llave => $valor)
		{
			unset($valor[$columna]);
			$array_resultado[]=$valor;
		}
		return $array_resultado;
	}

	function SesionArrayBidimensionalFilasChulitos()
	{
		foreach($_POST as $vpost => $valor)
		{
			if (ereg("^selfila".$valor."$",$vpost))
			{
				$llaves_seleccionadas[]=$valor;
			}
		}
		$_SESSION['SesionArrayBidimensionalFilasChulitos']=$llaves_seleccionadas;
	}

	function SesionArrayBidimensionalChulitos()
	{
		foreach($_POST as $vpost => $valor)
		{
			if (ereg("^sel".$valor."$",$vpost))
			{
				$llaves_seleccionadas[]=$valor;
			}
		}
		$_SESSION['SesionArrayBidimensionalChulitos']=$llaves_seleccionadas;
	}

	function RecortarSesionArrayBidimensionalChulitos($matriz)
	{
		foreach ($_SESSION['SesionArrayBidimensionalChulitos'] as $llaves => $valorllaves)
		{
			foreach ($matriz as $clave => $valor)
			{
				$matriz_recortada[$clave][$valorllaves]=$valor[$valorllaves];
			}
		}
		return $matriz_recortada;
	}

	function RecortarArrayBidimensionalChulitos($matriz)
	{
		foreach($_POST as $vpost => $valor)
		{
			if (ereg("^sel".$valor."$",$vpost))
			{
				$llaves_seleccionadas[]=$valor;
			}
		}

		foreach ($llaves_seleccionadas as $llaves => $valorllaves)
		{
			foreach ($matriz as $clave => $valor)
			{
				$matriz_recortada[$clave][$valorllaves]=$valor[$valorllaves];
			}
		}
		return $matriz_recortada;
	}

	function RecortarArrayBidimensionalFilasChulitos($matriz,$col_id)
	{
		foreach($_POST as $vpost => $valor)
		{
			if (ereg("^selfila".$valor."$",$vpost))
			{
				$llaves_seleccionadas[]=$valor;
			}
		}

		foreach ($llaves_seleccionadas as $llaves => $valorllaves)
		{
			foreach ($matriz as $clave => $valor)
			{
				if($valor[$col_id]==$valorllaves)
				{
					$matriz_recortada[]=$valor;
				}
			}
		}
		//$matriz_recortada=$matriz;
		return $matriz_recortada;

	}

	function EscribirCabecerasTablaNormal($matriz)
	{
		echo "<tr>\n";
		while($elemento = each($matriz))
		{
			echo "<td>$elemento[0]</a></td>\n";
		}
		echo "</tr>\n";
	}

	function EscribirCabecerasTabla($matriz,$wrap="noWrap")
	{
		echo "<tr>\n";
		if($this->numerarsino=='si')
		{
			echo "<td $wrap>&nbsp;</a></td>\n";
		}
		while($elemento = each($matriz))
		{
			echo "<td $wrap>$elemento[0]</a></td>\n";
		}
		echo "</tr>\n";
	}

	function EscribirCabecerasTablaAgregarEditarEliminar($matriz)
	{
		echo "<tr>\n";
		if($this->numerarsino=='si')
		{
			echo '<td nowrap>&nbsp;</td>'."\n";
		}
		while($elemento = each($matriz))
		{
			echo "<td>$elemento[0]</a></td>\n";
		}
		echo "<td nowrap>Agregar</td>\n";
		echo "<td nowrap>Editar</td>\n";
		echo "<td nowrap>Eliminar</td>\n";
		echo "</tr>\n";
	}

	function DibujarTablaNormal($matriz,$texto="")
	{
		if(is_array($matriz))
		{
			echo "<table border=1 cellpadding='2' cellspacing='1' align=center>\n";
			echo "<caption align=TOP>$texto</caption>";
			$this->EscribirCabecerasTablaNormal($matriz[0],$link);
			for($i=0; $i < count($matriz); $i++)
			{
				echo "<tr>\n";
				while($elemento=each($matriz[$i]))
				{
					echo "<td nowrap>$elemento[1]&nbsp;</td>\n";
				}
				echo "</tr>\n";
			}
			echo "</table>\n";
		}
		else
		{
			echo $texto." Matriz no valida<br>";
		}
	}

	function DibujaTablaAgregarEditarEliminar($matriz,$columna_llave_principal,$columna_llave_secundaria,$link_destino,$llave_desactiva="codigoestado",$valor_llave_desactiva=200,$texto="")
	{
		if(is_array($matriz))
		{
			echo "<table border=1 cellpadding='2' cellspacing='1' align=center>\n";
			echo "<caption align=TOP>$texto</caption>";
			$this->EscribirCabecerasTablaAgregarEditarEliminar($matriz[0]);
			for($i=0; $i < count($matriz); $i++)
			{
				echo "<tr>\n";
				while($elemento=each($matriz[$i]))
				{
					echo "<td nowrap>$elemento[1]&nbsp;</td>\n";
				}
				echo '<td nowrap><a href="'.$link_destino.'?adicionar&'.$columna_llave_principal.'='.$matriz[$i][$columna_llave_principal].'&'.$columna_llave_secundaria.'='.$matriz[$i][$columna_llave_secundaria].'"><img src="imagenes/adicionar.png" width="23" height="23" border="0"></a>&nbsp;</td>'."\n";
				echo '<td nowrap><a href="'.$link_destino.'?editar&'.$columna_llave_principal.'='.$matriz[$i][$columna_llave_principal].'&'.$columna_llave_secundaria.'='.$matriz[$i][$columna_llave_secundaria].'"><img src="imagenes/editar.png" width="23" height="23" border="0"></a>&nbsp;</td>'."\n";
				echo '<td nowrap><a href="'.$link_destino.'?eliminar&'.$columna_llave_principal.'='.$matriz[$i][$columna_llave_principal].'&'.$columna_llave_secundaria.'='.$matriz[$i][$columna_llave_secundaria].'"><img src="imagenes/eliminar.png" width="23" height="23" border="0"></a>&nbsp;</td>'."\n";
				echo "</tr>\n";
			}
			echo "</table>\n";
		}
		else
		{
			echo $texto." Matriz no valida<br>";
		}
	}

	function MuestraBotonVentanaEmergente($nombre,$destino,$variablesGet="",$width=300,$height=300,$top=200,$left=150,$scrollbars="yes",$resizable="yes",$toolbar="no",$status="no",$menu="no")
	{
		$emergente='<input type="button" name="'.$nombre.'" value="'.$nombre.'" onClick="window.open('."'".$destino.'?'.$variablesGet."','$nombre'".",'width=".$width.",height=".$height.",top=".$top.",left=".$left.",scrollbars=$scrollbars,toolbar=$toolbar,resizable=$resizable,status=$status,menu=$menu');".'"'.">";
		echo $emergente;
	}

	function ListarTabla($tabla,$limite_inferior=null,$limite_superior=null)
	{
		$obj=new ADODB_Active_Record($tabla);
		$atributos=$obj->GetAttributeNames();
		$info=$obj->TableInfo();
		$llave=array_keys($info->keys);
		if($limite_inferior<>"" and $limite_superior<>"")
		{
			$inferior=$_GET['inferior'];
			$superior=$_GET['superior'];
			$query="SELECT * FROM $tabla limit $inferior,$superior";
		}
		else
		{
			$query="SELECT * FROM $tabla";
		}
		$operacion=$sala->query($query);
		$row_operacion=$operacion->fetchRow();
		do
		{
			$array_interno[]=$row_operacion;
		}
		while($row_operacion=$operacion->fetchRow());
		$motor = new matriz($array_interno,$tabla,"listado.php?tabla=$tabla&inferior=$inferior&superior=$superior","si","si","menu.php");
		$motor->agregarllave_drilldown($llave[0],'listado.php','formulario.php','form',$llave[0],"tabla=$tabla&inferior=$inferior&superior=$superior");
		$motor->mostrar();
	}

	function TablaArregloChulitosFilas($matriz,$col_id,$texto="")
	{
		if(is_array($matriz))
		{
			echo "<table border='1' cellpadding='1' cellspacing='0' bordercolor='#E9E9E9'>\n";
			echo "<caption align=TOP>$texto</caption>";
			$this->EscribirCabecerasTablaArregloChulitosFilas($matriz[0],$link);
			for($i=0; $i < count($matriz); $i++)
			{
				echo "<tr>\n";
				while($elemento=each($matriz[$i]))
				{
					echo "<td nowrap>$elemento[1]&nbsp;</td>\n";
					if($elemento['key']==$col_id)
					{
						if($_POST["selfila".$elemento['value']]==$elemento['value'])
						{
							$chequear="checked";
						}
						else
						{
							$chequear="";
						}
						echo "<td nowrap><input type='checkbox'  name='selfila".$elemento['value']."' $chequear value='".$elemento['value']."'></td>\n";

						//echo "<td nowrap>".$elemento['value']."&nbsp;</td>\n";
					}
				}
				echo "</tr>\n";
			}
			echo "</table>\n";
		}
		else
		{
			echo $texto." Matriz no valida<br>";
		}
	}
	function EscribirCabecerasTablaArregloChulitosFilas($matriz)
	{
		echo "<tr>\n";
		while($elemento = each($matriz))
		{
			echo "<td>$elemento[0]</a></td>\n";
		}
		echo "</tr>\n";
	}
	/**
 * Revisar
 *
 * @param unknown_type $tabla
 * @param unknown_type $array_fila
 */
	function insertar_fila_bd_($tabla,$array_fila)
	{
		$claves="(";
		$valores="(";
		$i=0;
		while (list ($clave, $val) = each ($array_fila)) {

			if($i>0){
				$claves .= ",".$clave."";
				$valores .= ",'".$val."'";
			}
			else{
				$claves .= "".$clave."";
				$valores .= "'".$val."'";
			}
			$i++;
		}
		$claves .= ")";
		$valores .= ")";
		$sql="insert into $tabla $claves values $valores";
		$operacion=$this->conexion->query($sql);

	}

	/**
	 * Revisar
	 *
	 * @param unknown_type $tabla
	 * @param unknown_type $fila
	 * @param unknown_type $nombreidtabla
	 * @param unknown_type $idtabla
	 */
	function actualizar_fila_bd_($tabla,$fila,$nombreidtabla,$idtabla)
	{
		$i=0;
		while (list ($clave, $val) = each ($fila)) {

			if($i>0){
				$claves .= ",".$clave."";
				$valores .= ",'".$val."'";
				$condiciones .= ",".$clave."='".$val."'";
			}
			else{
				$claves .= "".$clave."";
				$valores .= "'".$val."'";
				$condiciones .= $clave."='".$val."'";
			}
			$i++;
		}
		$sql="update $tabla set $condiciones where $nombreidtabla=$idtabla";
		$operacion=$this->conexion->query($sql);
	}

	function trace($var, $file, $line, $exit = false)
	{
		if (ENABLE_DEBUG) {
			$id = md5(microtime());
            ?>
            <div class="sa_trace_start"><a href="javascript:;" class="sa_trace_start_link" onClick="MM_changeProp('var_<?= $id ?>', '', 'style.visibility', MM_toggleVisibility('var_<?= $id ?>'), 'DIV'); " title="click here to view the output of var_dump(<?= gettype($var) ?>)">:: Trace <span style="color: #ff6600"><?= $file ?></span> on line <?= $line ?> ::</a></div>
             <div id="var_<?= $id ?>" title="click to close" class="sa_trace_dump" onClick="MM_changeProp('var_<?= $id ?>', '', 'style.visibility', MM_toggleVisibility('var_<?= $id ?>'), 'DIV');">
             <pre><?= print_r($var) ?></pre>
             <div class="sa_trace_end">:: Trace end ::</div>
             </div>
<?php
if ($exit) exit;
		}
	}
}
?>