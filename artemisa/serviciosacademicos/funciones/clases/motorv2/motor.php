<?php
/**
 * Esta clase, es el motor de informes, recibe una matriz bidimensional cualquiera, y dibuja filtros, efectúa ordenamientos, y exporta a excel
 *
 */
class matriz
{
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
	var $rutaraiz;
	var $mostrar_tabla_arreglo_chulitos=true;
	var $archivo_origen_con_get=false;//si el archivo que genera el motor tiene algún parametro por get, toca pornerlo en true
	var $celdas_redimensionables=false;
	var $mostrarValoresTotales=true;
	var $javascripttabla;
	var $matriz_llaves;
	var $mostrarTitulo;
	var $ModoDHTML;
	var $arrayColumnasOcultas;
	var $filtrotmp;
	var $primeravez;
	var $array_columnas_filtro;

	var $botonFiltrar=true;
	var $botonRestablecer=true;
	var $botonRegresar=true;
	var $botonExportar=true;
	var $botonRecargar=true;

	var $arrayLimitesDatosDinamicos=array();


	function matriz($matriz,$titulo="",$archivo_origen="",$filtrasino="si",$numerarsino="no",$atras="",$link_recarga="",$origen_x_sesion=false,$ordenasino="si",$rutaraiz="../../",$modoDHML=false)
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
		$this->rutaraiz=$rutaraiz;
		$this->ModoDHTML=$modoDHML;
		///$_SESSION['get']=$_GET;

		if(isset($_GET['Recargar']) and $_GET['Recargar']<>"")
		{
			if($origen_x_sesion==true)
			{
				echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=".$_SERVER['REQUEST_URI'].">";
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
				///unset($_SESSION['get']);
				$this->retornar_menu($atras);
			}
			else
			{
				///unset($_SESSION['get']);
				echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=$this->atras'>";
			}
		}

		if(isset($_GET['orden']) and $_GET['orden']!="")
		{
			$_SESSION['orden']=$_GET['orden'];
		}
		if(isset($_GET['Filtrar']) and $_GET['Filtrar']!="")
		{
			$this->filtrasino(true,$_GET);
			$this->ordenamiento($_GET['ordenamiento'],$_GET['orden']);
		}
		else
		{
			$this->ordenamiento($_GET['ordenamiento'],$_GET['orden']);
		}
		if(isset($_GET['Exportar']))
		{
			$_SESSION['tipo_exportacion']=$_GET['tipo_exp'];
			$this->filtrasino(true,$_GET);
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

	function asignarJavascripttabla($javascripttabla="")
	{
		$this->javascripttabla=$javascripttabla;
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

	function asignarMostrarTitulo($mostrar=true){
		$this->mostrarTitulo=$mostrar;
	}

	function asignarMostrarChulitos($mostrar=true){
		$this->mostrar_tabla_arreglo_chulitos=$mostrar;
	}


	function  asignarCeldasRedimensionables($tamano_celdas_redimensionables="")
	{
		$this->celdas_redimensionables=true;
		/*
		if($tamano_celdas_redimensionables<>"")
		{
		echo '<style type="text/css">
		<!--
		.tablecontainer
		{
		position: absolute;
		}
		.mytable
		{
		table-layout: fixed;
		}
		.mytable TD, .mytable TH
		{
		width: '.$tamano_celdas_redimensionables.';
		}
		.mytable TH
		{
		background-color: #e0e0e0;
		}
		-->
		</style>';
		}
		else
		{
		echo '<style type="text/css">
		<!--
		.tablecontainer
		{
		position: absolute;
		}
		.mytable
		{
		table-layout: auto;
		}
		.mytable TD, .mytable TH
		{

		}
		.mytable TH
		{
		background-color: #e0e0e0;
		}
		-->
		</style>';
		}*/
	}


	function resetearVariablesSesion()
	{
		unset($_SESSION['arreglo_exportacion']);
		///unset($_SESSION['get']);
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

	function creaArrayParametrosAjax()
	{
		echo "<script language='javascript'>\n";
		echo "var arrayParametrosAjax=new Array();\n";


		foreach ($this->arrayLimitesDatosDinamicos as $llave => $valor)
		{
		?>
		arrayParametrosAjax[<?php echo $llave?>]=new Array();
		arrayParametrosAjax[<?php echo $llave?>][0]="<?php echo $valor['tabla']?>";
		arrayParametrosAjax[<?php echo $llave?>][1]="<?php echo $valor['id']?>";
		arrayParametrosAjax[<?php echo $llave?>][2]="<?php echo $valor['campobdcolumna']?>";
		arrayParametrosAjax[<?php echo $llave?>][3]="<?php echo $valor['x_ini']?>";
		arrayParametrosAjax[<?php echo $llave?>][4]="<?php echo $valor['y_ini']?>";
		arrayParametrosAjax[<?php echo $llave?>][5]="<?php echo $valor['x_fin']?>";
		arrayParametrosAjax[<?php echo $llave?>][6]="<?php echo $valor['y_fin']?>";
		arrayParametrosAjax[<?php echo $llave?>][7]="<?php echo $valor['tipooperacion']?>";
		arrayParametrosAjax[<?php echo $llave?>][8]="<?php echo $valor['validacion']?>";
		<?php
		}
		echo '</script>';
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

	function agregarllave_drilldown($nombrecolumna,$link_origen,$link_destino,$descripcion="",$llave,$cadenaadicional="",$variable="",$aliasvariable="",$mailto="",$textoglobo="",$javascript="",$tipoDHTML="",$llamadaFuncOnclick="",$llamadaFuncOnMouseOver="",$llamadaFuncOnMouseOut="",$idObjetoDOMAsociado="")
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
			if($tipoDHTML<>""){
				$drill_down['tipoDHTML']=$tipoDHTML;
			}
			if($llamadaFuncOnclick<>""){
				$drill_down['llamadaFuncOnclick']=$llamadaFuncOnclick;
			}
			if($llamadaFuncOnMouseOver<>""){
				$drill_down['llamadaFuncOnMouseOver']=$llamadaFuncOnMouseOver;
			}
			if($llamadaFuncOnMouseOut<>""){
				$drill_down['llamadaFuncOnMouseOut']=$llamadaFuncOnMouseOut;
			}
			if($idObjetoDOMAsociado<>""){
				$drill_down['idObjetoDOMAsociado']=$idObjetoDOMAsociado;
			}
		}
		$this->array_drill_down[]=$drill_down;
		$this->drill=true;
	}

	function agregarColOculta($nombrecol){
		$this->arrayColumnasOcultas[]=$nombrecol;
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
					$this->filtrotmp=$this->filtrar_unitario($this->filtrotmp,$valor['nombrecolumna'],$valor['valorcolumna'],$valor['tipobusqueda']);

				}
				/*echo "<h1>";
				echo $clave,"-".$valor['nombrecolumna'];
				echo "</h1><br>";
				echo "<pre>";
				print_r($this->filtrotmp);
				echo "</pre>";*/
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
		/*$cadena=$link_destino."?";
		foreach ($_SESSION['array_recarga'] as $llave => $valor)
		{
		$get=$get.$valor['variable']."=".$valor['valor_variable']."&";
		}
		$link_recarga=$cadena.$get."&Enviar";*/
		echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=$link_destino'>";
		unset($_GET['Recargar']);
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
			if($this->ModoDHTML==true){
				echo "<td><input name='Filtrar' type='button' id='Filtrar' value='F' onclick='ejecutarPeticioAjaxFiltros()'></td>\n";
			}
			else{
				echo "<td><input name='Filtrar' type='submit' id='Filtrar' value='F'></td>\n";
			}
			//echo "<td $wrap id='tituloverde'>&nbsp;</td>\n";
		}
		while($elemento = each($matriz))
		{
			if(!in_array($elemento[0],$this->arrayColumnasOcultas) ){
				echo "<td $wrap align='CENTER' id='tituloverde'><input name='$elemento[0]' type='text' size='15' value='".$_GET[$elemento[0]]."'><br>
		<select name='f_$elemento[0]' id='f_$elemento[0]'>
        <option value='like'"; if($_GET['f_'.$elemento[0]]=='like'){echo 'Selected';}echo ">like</option>
        <option value='<>'"; if($_GET['f_'.$elemento[0]]=='<>'){echo 'Selected';}echo "><></option>
        <option value='='"; if($_GET['f_'.$elemento[0]]=='='){echo 'Selected';}echo ">=</option>
        <option value='>'"; if($_GET['f_'.$elemento[0]]=='>'){echo 'Selected';}echo ">></option>
        <option value='>='"; if($_GET['f_'.$elemento[0]]=='>='){echo 'Selected';}echo ">>=</option>
        <option value='<'"; if($_GET['f_'.$elemento[0]]=='<'){echo 'Selected';}echo "><</option>
        <option value='<='"; if($_GET['f_'.$elemento[0]]=='<='){echo 'Selected';}echo "><=</option>
        </select>
		</td>\n";
			}
		}
		echo "</tr>\n";
	}

	function escribirCabecerasRedimensionables($matriz,$href,$wrap="noWrap")
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
			echo "<th $wrap align='CENTER' id='tdtitulogris'>No</th>\n";
		}
		while($elemento = each($matriz))
		{
			if($href=="")
			{
				echo "<th $wrap align='CENTER'>$elemento[0]</a></th>\n";
			}

			else
			{
				echo "<th $wrap align='CENTER' id='tdtitulogris'><a href='$href?ordenamiento=$elemento[0]&orden=";if(!isset($_GET['orden'])){echo "desc";}if($_GET['orden']=="asc"){echo "desc";}if($_GET['orden']=="desc"){echo "asc";};echo $cadena_a.$cadena_b;
				if(isset($_GET['Filtrar']) and $_GET['Filtrar']!="")
				{
					echo "&Filtrar=Filtrar";
				}
				if(isset($_REQUEST['Recortar']) and $_REQUEST['Recortar']!="")
				{
					echo "&Recortar=Recortar";
				}

				echo "'>$elemento[0]</a></th>\n";
			}
		}

		echo "</tr>\n";
	}

	function escribir_cabeceras($matriz,$href,$wrap="noWrap")
	{
		$contador=0;
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
			echo "<td id='tdtitulogris' $wrap align='CENTER'>No</td>\n";
		}
		while($elemento = each($matriz))
		{
			if(!in_array($elemento[0],$this->arrayColumnasOcultas) ){
				$array_columnas[$elemento[0]]=$contador;
				$contador++;

				if($href=="")
				{
					echo "<td $wrap align='CENTER'>$elemento[0]</a></td>\n";
				}
				else
				{
					if($this->ModoDHTML==true){

						$llamadaAjax="?ordenamiento=$elemento[0]&orden=";
						if(!isset($_GET['orden']))
						{
							$orden="asc";
						}
						if($_GET['orden']=="asc")
						{
							$orden="desc";
						}
						if($_GET['orden']=="desc"){
							$orden="asc";
						}
						if(isset($_GET['filtrar'])){
							$comp='&Filtrar=Filtrar';
						}
						$Ajax=$llamadaAjax.$orden.$cadena_a.$cadena_b.$comp;

						echo "<td $wrap align='CENTER'><div id='ordenamiento' style='cursor: pointer' onclick='ejecutarPeticionAjaxGenerica(".'"'.$Ajax.'"'.")' >$elemento[0]</div></td>\n";
					}
					else{
						if($this->archivo_origen_con_get==true)
						{
							echo "<td $wrap align='CENTER' id='tdtitulogris'><a href='$href&ordenamiento=$elemento[0]&orden=";if(!isset($_GET['orden'])){echo "desc";}if($_GET['orden']=="asc"){echo "desc";}if($_GET['orden']=="desc"){echo "asc";};echo $cadena_a.$cadena_b;
						}
						else
						{
							echo "<td $wrap align='CENTER' id='tdtitulogris'><a href='$href?ordenamiento=$elemento[0]&orden=";if(!isset($_GET['orden'])){echo "desc";}if($_GET['orden']=="asc"){echo "desc";}if($_GET['orden']=="desc"){echo "asc";};echo $cadena_a.$cadena_b;
						}
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
			}
		}
		echo "</tr>\n";
		return $array_columnas;
	}

	function listar($matriz="",$texto="",$link="",$filtros="si",$numerar="no",$totalizar="no",$campos_edicion="no",$wrap="noWrap",$align="left",$nbsp="")
	{
		$this->numerar=$numerar;
		$no=1;
		echo "<form name='form1' method='get' action='' id='form1'>";

		if(isset($_GET['ordenamiento'])){
			echo "<input type='hidden' value='".$_GET['ordenamiento']."' name='ordenamiento' id='ordenamiento'>";
		}
		if(isset($_GET['orden'])){
			echo "<input type='hidden' value='".$_GET['orden']."' name='orden' id='orden'>";
		}
		if($this->celdas_redimensionables==false)
		{
			echo "<table border='1' cellpadding='1' cellspacing='0' bordercolor='#CCCCCC' ".$this->javascripttabla.">\n ";
		}
		else
		{
			echo    '<table border="1" cellspacing="0" cellpadding="1" bordercolor="#CCCCCC" '.$this->javascripttabla. '
			class="mytable"
	        onmousemove="TableResize_OnMouseMove(this);"
	        onmouseup="TableResize_OnMouseUp(this);"
	        onmousedown="TableResize_OnMouseDown(this);">';
		}

		if($this->mostrarTitulo==true){
			if($texto<>"")
			{
				echo "<div align=LEFT><h6>$texto</h6></div>";
			}
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
			if ($this->celdas_redimensionables==true)
			{
				$this->escribirCabecerasRedimensionables($matriz[0],$link,$wrap);
			}
			else
			{
				$cabeceras=$this->escribir_cabeceras($matriz[0],$link,$wrap);
			}
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
							if(isset($elemento[1]))
							{
								if($this->ModoDHTML==true){
									$parametros='?'.$valor['llave'].'='.$matriz[$i][$valor['llave']];
									if($valor['tipoDHTML']<>''){
										$funcOnclick=$valor['llamadaFuncOnclick'];
										$idObjetoDOMAsociado=$valor['idObjetoDOMAsociado'];
										switch ($valor['tipoDHTML']){
											case 'drilldown':
												$funcion="onclick='$funcOnclick(".'"'.$parametros.'"'.")'";
												break;
											case 'globoAJAX':
												$a=" onmouseover='ajax_showTooltip(".'"GloboAjax.php?descriptor='.$valor['descriptor'].'&'.$valor['llave'].'='.$matriz[$i][$valor['llave']].'",'.$idObjetoDOMAsociado.")';";
												$b=" onmouseout='ajax_hideTooltip();'";
												$funcion=$a.$b;
												break;
											case 'drilldown-globoAjax':
												$a=" onclick='$funcOnclick(".'"'.$parametros.'"'.")'";
												$b=" onmouseover='ajax_showTooltip(".'"GloboAjax.php?descriptor='.$valor['descriptor'].'&'.$valor['llave'].'='.$matriz[$i][$valor['llave']].'",'.$idObjetoDOMAsociado.")';";
												$c=" onmouseout='ajax_hideTooltip();'";
												$funcion=$a.$b.$c;
												break;
										}
									}
									else{
										$funcion="onclick='$funcOnclick(".'"'.$parametros.'"'.")'";
									}
									$cadena="<td bgcolor='AliceBlue' align=$align $wrap><div id='celdas' style='cursor: pointer;color: blue' $funcion>".$elemento[1]."</div></td>";
									echo $cadena;
								}
								elseif($mail!="")
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
							}
							else
							{
								echo "<td>&nbsp;</td>\n";
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

							if(isset($elemento[1]) and !empty($elemento[1]))
							{
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
							else
							{
								echo "<td>&nbsp;</td>\n";
							}
						}
					}

				}

				if($bandera_drill_down==false and $bandera_drill_down_emergente==false)
				{
					if(!in_array($elemento[0],$this->arrayColumnasOcultas) ){
						if(isset($elemento[1]))
						{
						    $elemento[1] = utf8_decode($elemento[1]);  
							echo "<td id=f_".$i."_".$cabeceras[$elemento[0]]." align=$align $wrap>$elemento[1]$nbsp</td>\n";
						}
						else
						{
							echo "<td>&nbsp;</td>\n";
						}
					}
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
				$resta=1;
			}
			echo "<tr>\n";
			$colspan=count($this->matriz_llaves)+$suma;
			{
				echo "<td align='$align' '$wrap' colspan='$colspan'><div align='center'><font size='+1'>Subtotales</font></div></td>";
			}
			echo "</tr>\n";
			echo "<tr>\n";
			if($numerar<>'no')
			{
				echo "<td></td>";
			}
			//si es verdadero, muestra el contenido del array totales, de lo contrario coloca la palabra Total
			if($this->mostrarValoresTotales==true)
			{
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

				}
			}
			else
			{
				for($i=0;$i <= count($this->matriz_llaves)-$resta;$i++)
				{
					if($this->totales[$i]['link_destino']!="" and $this->totales[$i]['link_origen']!="" and $this->totales[$i]['descripcion']!="")
					{
						if($this->totales[$i]['textoglobo']<>"")
						{
							$globo=" onMouseover='showtip2(this,event,".'"'.$this->totales[$i]['textoglobo'].'"'.")' onMouseout='hidetip2()'";
						}
						echo "<td>";echo "<a href='".$this->totales[$i]['link_destino']."?totales&link_origen=".$this->totales[$i]['link_origen']."&descriptor=".$this->totales[$i]['descripcion']."&".$this->totales[$i]['cadenaadicional']."'$globo>"."Total"."</a>";echo "</td>";
					}
					else
					{
						echo "<td align=$align $wrap>";echo $this->totales[$i]['total'];echo "</td>";
					}

				}
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
	  	<tr>";

		if($this->botonFiltrar==true)
		{

			if($this->ModoDHTML==true){
				echo "<td><input name='Filtrar' type='button' id='Filtrar' value='Filtrar' onclick='ejecutarPeticioAjaxFiltros()'></td>\n";
			}
			else{
				echo "<td><input name='Filtrar' type='submit' id='Filtrar' value='Filtrar'></td>\n";
			}
		}
		if($this->botonRestablecer==true)
		{
			if($this->ModoDHTML==true){
				echo "<td><input name='Restablecer' type='button' id='Restablecer' value='Restablecer' onclick='ejecurarPeticionAjaxRestablecer()'></td>\n";
			}
			else{
				echo "<td><input name='Restablecer' type='submit' id='Restablecer' value='Restablecer'></td>\n";
			}



		}
		if($this->botonRegresar==true)
		{
			if($this->ModoDHTML==false){
				echo "<td><input name='Regresar' type='button' id='Regresar' value='Regresar' onClick='reCarga(".'"'.$this->atras.'"'.");'></td>\n";
			}
		}
		if($this->botonRecargar==true)
		{
			if($this->ModoDHTML==false){
				echo "<td><input name='Recargar' type='submit' id='Recargar' value='Recargar'></td>\n";
			}
		}
		if($this->botonExportar==true)
		{
			if($this->ModoDHTML==true){
				echo "<td><input name='Exportar' type='button' id='Exportar' value='Exportar' onclick='ejecutarPeticionAjaxExportarXML()'></td>\n";
			}
			else{
				echo "<td><input name='Exportar' type='submit' id='Exportar' value='Exportar'></td>\n";
			}
		}

		if($this->ModoDHTML==false){
			echo '
	    	<td><div align="center"><input name="tipo_exp" type="radio" value="xls" checked></div></td>
		    <td><div align="center">XLS</div></td>
		    <td><div align="center"><input name="tipo_exp" type="radio" value="doc"></div></td>
	    	<td><div align="center">DOC</div></td>
			 </tr>
			</table>
			';
		}

		foreach ($_GET as $llave => $valor)
		{
			if (isset($_GET[$llave]) and $_GET[$llave]<>"")
			{
				echo "<input type='hidden' name='$llave' value='".$_GET[$llave]."'>\n";
			}
		}
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
			$this->listar($this->matriz,$this->titulo,$link,$filtros,$numerar,"no","no",$wrap,$align,$nbsp);
		}
		if($this->mostrar_tabla_arreglo_chulitos==true)
		{
			$this->tabla_arreglo_chulitos();
		}
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

		?>
		<!--<script language="javascript">window.open("<?php echo $this->rutaraiz?>funciones/clases/motorv2/exportar.php?nombre=<?php echo $nombrearchivo?>&formato=<?php echo $formato?>&arreglo=<?php echo $arreglo?>");</script>-->
<?php 
 $REQUEST_URI =$this->rutaraiz."funciones/clases/motorv2/exportar.php?nombre=".$nombrearchivo."&formato=".$formato."&arreglo=".$arreglo;
echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=$REQUEST_URI'>";
?>
		<?php
		unset($_GET['Exportar']);
		unset($_POST['Exportar_recorte']);
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
	   $nombrearchivo = str_replace(" ", "", $nombrearchivo);
       switch ($formato)
		{
 			case 'xls' :
				$strType = 'application/msexcel';
				$strName = 'filename='.$nombrearchivo.'.xls';
                break;
			case 'doc' :
				$strType = 'application/msword';
				$strName = 'filename='.$nombrearchivo.'.doc';
				break;
			case 'txt' :
				$strType = 'text/plain';
				$strName = 'filename='.$nombrearchivo.'.txt';
				break;
			case 'csv' :
				$strType = 'text/plain';
				$strName = 'filename='.$nombrearchivo.'.csv';
				break;
			case 'xml' :
				$strType = 'text/plain';
				$strName = 'filename='.$nombrearchivo.'.xml';
				break;
			default :
				$strType = 'application/msexcel';
				$strName = 'filename='.$nombrearchivo.'.xls';
				break;

		}

        header("Content-Type: ".$strType."");
        header('Content-Disposition: attachment; '.$strName.'');
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
	function agregar_llaves_totales($llave,$link_origen="",$link_destino="",$descripcion="",$cadenaadicional="",$variable="",$aliasvariable="",$textoglobo="",$mostrarValoresTotales=true)
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
		$this->mostrarValoresTotales=$mostrarValoresTotales;
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

	function SumaArreglosBidimensionalesDelMismoTamano($arreglo1,$arreglo2)
	{
		if(count($arreglo1)==count($arreglo2))
		{
			for($i=0; $i<count($arreglo1);$i++)
			{
				$array_sumado[]=$arreglo1[$i] + $arreglo2[$i];
			}
			return $array_sumado;
		}
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
			echo "<td id='tdtitulogris'>$elemento[0]</a></td>\n";
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
			echo "<td id='tdtitulogris' $wrap>$elemento[0]</a></td>\n";
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
			echo "<td >$elemento[0]</a></td>\n";
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

	function listarXML($matriz,$tagXMLPrincipal,$tagXML){
		/*header('Expires: Fri, 25 Dec 1980 00:00:00 GMT'); // time in the past
		header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . 'GMT');
		header('Cache-Control: no-cache, must-revalidate');
		header('Pragma: no-cache');
		header('Content-type: text/xml');
		header ("Content-Type: application/octet-stream");
		header("Content-Disposition: attachment; filename=\"archivo.xml\"\n");*/
		header('Content-type: text/xml');
		header("Content-Disposition: attachment; filename=archivo.xml\r\n\r\n");
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Pragma: public");

		echo '<?xml version="1.0" encoding="UTF-8"?>';

		echo "<$tagXMLPrincipal>\n";
		for($i=0; $i < count($matriz); $i++)
		{
			echo "	<$tagXML>\n";
			while($elemento=each($matriz[$i]))
			{
				echo "		<".iconv('UTF-8','UTF-8',$elemento[0]).">".iconv('UTF-8','UTF-8',$elemento[1])."</".iconv('UTF-8','UTF-8',$elemento[0]).">\n";
			}
			echo "	</$tagXML>\n";
		}
		echo "</$tagXMLPrincipal>\n";
	}

	function creaXML($matriz,$nombreXML){
		$mixml = fopen($nombreXML,'w+');
		$contenido = '<?xml version="1.0" encoding="utf-8"?>';
		fwrite($mixml,$contenido);
		//$contenido = '';
		for($i=0; $i < count($matriz); $i++)
		{
			while($elemento=each($matriz[$i]))
			{
				$contenido = "		<".$elemento[0].">".$elemento[1]."</".$elemento[0].">\n";
				fwrite($mixml,$contenido);
				unset($contenido);
			}
		}
		fclose($mixml);
	}

	function DibujarTablaHref($matriz,$texto="")
	{
		if(is_array($matriz))
		{
			echo "<table border=1 cellpadding='2' cellspacing='1' align=left>\n";
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

	function RestarDosArraysBidimensionalesFilas($array1,$array2,$llavecomun)
	{
		if(is_array($array1) and is_array($array2))
		{
			foreach ($array1 as $llave => $valor)
			{
				$bandera=false;
				foreach ($array2 as $llave_int => $valor_int)
				{
					if($valor[$llavecomun]==$valor_int[$llavecomun])
					{
						$bandera=true;
					}
				}
				if($bandera==false)
				{
					$array_diferencia[][$llavecomun]=$valor[$llavecomun];
				}
			}
		}
		return $array_diferencia;
	}

	function asignarLimitesDatosDinamicos($tabla,$id,$campobdcolumna,$x_ini,$y_ini,$x_fin,$y_fin,$operacion,$validacion=null)
	{
		if($operacion=="actualizartexto")
		{
			$tipooperacion=0;
		}
		$this->arrayLimitesDatosDinamicos[]=array('tabla'=>$tabla,'id'=>$id,'campobdcolumna'=>$campobdcolumna,'x_ini'=>$x_ini,'y_ini'=>$y_ini,'x_fin'=>$x_fin,'y_fin'=>$y_fin,'operacion'=>$operacion,'tipooperacion'=>$tipooperacion,'validacion'=>$validacion);
		echo "<script language='javascript'>nuevosLimites($x_ini,$y_ini,$x_fin,$y_fin,$tipooperacion);</script>\n";
	}

	function asignarColumnaDatosDinamicos($tabla,$id,$columna,$campobdcolumna,$operacion,$validacion)
	{
		foreach ($this->matriz_llaves as $llave => $valor)
		{
			if($valor==$columna)
			{
				$x=$llave;
			}
		}
		$y_fin=count($this->matriz);
		if(!empty($x) and !empty($y_fin))
		{
			$this->asignarLimitesDatosDinamicos($tabla,$id,$campobdcolumna,$x,0,$x,$y_fin,$operacion,$validacion);
		}
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
	function jsVarios(){ ?>
		<script language="javascript">
		if (!document.layers&&!document.all)
		event="test"
		function showtip2(current,e,text){
			if (document.all&&document.readyState=="complete"){
				document.all.tooltip2.innerHTML='<marquee style="border:1px solid black">'+text+'</marquee>'
				document.all.tooltip2.style.pixelLeft=event.clientX+document.body.scrollLeft+10
				document.all.tooltip2.style.pixelTop=event.clientY+document.body.scrollTop+10
				document.all.tooltip2.style.visibility="visible"
			}
			else if (document.layers){
				document.tooltip2.document.nstip.document.write('<b>'+text+'</b>')
				document.tooltip2.document.nstip.document.close()
				document.tooltip2.document.nstip.left=0
				currentscroll=setInterval("scrolltip()",100)
				document.tooltip2.left=e.pageX+10
				document.tooltip2.top=e.pageY+10
				document.tooltip2.visibility="show"
			}
		}
		function hidetip2(){
			if (document.all)
			document.all.tooltip2.style.visibility="hidden"
			else if (document.layers){
				clearInterval(currentscroll)
				document.tooltip2.visibility="hidden"
			}
		}

		function scrolltip(){
			if (document.tooltip2.document.nstip.left>=-document.tooltip2.document.nstip.document.width)
			document.tooltip2.document.nstip.left-=5
			else
			document.tooltip2.document.nstip.left=150
		}

		function abrir(pagina,ventana,parametros)
		{
			window.open(pagina,ventana,parametros);
		}
		function enviar()
		{
			document.form1.submit()
		}
		function submitir()
		{
			document.form1.submit()
		}
		function Confirmacion(link_si,link_no)
		{
			if(confirm('La autorización de grado no es reversible. ¿Desea continuar?'))
			{
				document.form1.submit();
				window.location.reload('creacion_folios_automaticos.php?link_origen=menu.php');
			}
		}
		function reCarga(url)
		{
			window.location.href = url
		}
		function reCargaAuto()
		{
			window.location.href = "<?php echo $_SERVER['REQUEST_URI']?>";
		}
		<?php if($this->celdas_redimensionables==true){ ?>
		/*

		Table Resizing code

		*/

		/*
		Global constants to store elements that may be resized but we
		could probably place these into custom table attributes instead.
		*/
		var sResizableElement = "TH";    // This MUST be upper case
		var iResizeThreshold = 8;
		var iEdgeThreshold = 8;
		var iSizeThreshold = 20;
		var sVBarID = "VBar";

		/*
		Global variables to store position and distance moved but we
		could probably place these into custom table attributes instead.
		*/
		var oResizeTarget = null;
		var iStartX = null;
		var iEndX = null;
		var iSizeX = null;

		/*
		Helper Functions
		*/

		/*
		Creates the VBar on document load
		*/
		function TableResize_CreateVBar()
		{
			// Returns a reference to the resizer VBar for the table
			var objItem = document.getElementById(sVBarID);

			// Check if the item doesn't yet exist
			if (!objItem)
			{
				// and Create the item if necessary
				objItem = document.createElement("SPAN");

				// Setup the bar
				objItem.id = sVBarID;
				objItem.style.position = "absolute";
				objItem.style.top = "0px";
				objItem.style.left = "0px";
				objItem.style.height = "0px";
				objItem.style.width = "2px";
				objItem.style.background = "silver";
				objItem.style.borderLeft = "1px solid black";
				objItem.style.display = "none";

				// Add the bar to the document
				document.body.appendChild(objItem);
			}
		}

		window.attachEvent("onload", TableResize_CreateVBar);

		/*
		Returns a valid resizable element, even if it contains another element
		which was actually clicked otherwise it returns the top body element.
		*/
		function TableResize_GetOwnerHeader(objReference)
		{
			var oElement = objReference;

			while (oElement != null && oElement.tagName != null && oElement.tagName != "BODY")
			{
				if (oElement.tagName.toUpperCase() == sResizableElement)
				{
					return oElement;
				}

				oElement = oElement.parentElement;
			}

			// The TH wasn't found
			return null;
		}

		/*
		Find cell at column iCellIndex in the first row of the table
		needed because you can only resize a column from the first row.
		by using this, we can resize from any cell in the table if we want to.
		*/
		function TableResize_GetFirstColumnCell(objTable, iCellIndex)
		{
			var oHeaderCell = objTable.rows(0).cells(iCellIndex);

			return oHeaderCell;
		}

		/*
		Clean up - clears out the tracking information if we're not resizing.
		*/
		function TableResize_CleanUp()
		{
			// Void the Global variables and hide the resizer VBar.
			var oVBar = document.getElementById(sVBarID);

			if (oVBar)
			{
				oVBar.runtimeStyle.display = "none";
			}

			iEndX = null;
			iSizeX = null;
			iStartX = null;
			oResizeTarget = null;
			oAdjacentCell = null;

			return true;
		}

		/*
		Main Functions
		*/

		/*
		MouseMove event.
		On resizable table This checks if you are in an allowable 'resize start' position.
		It also puts the vertical bar (visual feedback) directly under the mouse cursor.
		The vertical bar may NOT be currently visible, that depnds on if you're resizing.
		*/
		function TableResize_OnMouseMove(objTable)
		{
			// Change cursor and store cursor position for resize indicator on column
			var objTH = TableResize_GetOwnerHeader(event.srcElement);

			if (!objTH)
			return;

			var oVBar = document.getElementById(sVBarID);

			if (!oVBar)
			return;

			var oAdjacentCell = objTH.nextSibling;

			// Show the resize cursor if we are within the edge threshold.
			if ((event.offsetX >= (objTH.offsetWidth - iEdgeThreshold)) && (oAdjacentCell != null))
			{
				objTH.runtimeStyle.cursor = "e-resize";
			}
			else
			{
				if(objTH.style.cursor)
				{
					objTH.runtimeStyle.cursor = objTH.style.cursor;
				}
				else
				{
					objTH.runtimeStyle.cursor = "";
				}
			}

			// We want to keep the right cursor if resizing and
			// don't want resizing to select any text elements...
			if (oVBar.runtimeStyle.display == "inline")
			{
				// We have to add the body.scrollLeft in case the table is wider than the view window
				// where the table is entirely within the screen this value should be zero...
				oVBar.runtimeStyle.left = window.event.clientX + document.body.scrollLeft;

				document.selection.empty();
			}

			return true;
		}

		/*
		MouseDown event.
		This fills the globals with tracking information, and displays the
		vertical bar. This is only done if you are allowed to start resizing.
		*/
		function TableResize_OnMouseDown(objTable)
		{
			// Record start point and show vertical bar resize indicator
			var oTargetCell = event.srcElement;

			if (!oTargetCell)
			return;

			var oVBar = document.getElementById(sVBarID);

			if (!oVBar)
			return;

			if (oTargetCell.parentElement.tagName.toUpperCase() == sResizableElement)
			{
				oTargetCell = oTargetCell.parentElement;
			}

			var oHeaderCell = TableResize_GetFirstColumnCell(objTable, oTargetCell.cellIndex);

			if ((oHeaderCell.tagName.toUpperCase() == sResizableElement) && (oTargetCell.runtimeStyle.cursor == "e-resize"))
			{
				iStartX = event.screenX;
				oResizeTarget = oHeaderCell;

				// Mark the table with the resize attribute and show the resizer VBar.
				// We also capture all events on the table we are resizing because Internet
				// Explorer sometimes forgets to bubble some events up.
				// Now all events will be fired on the table we are resizing.
				objTable.setAttribute("Resizing", "true");
				objTable.setCapture();

				// Set up the VBar for display

				// We have to add the body.scrollLeft in case the table is wider than the view window
				// where the table is entriely within the screen this value should be zero...
				oVBar.runtimeStyle.left = window.event.clientX + document.body.scrollLeft;

				oVBar.runtimeStyle.top = objTable.parentElement.offsetTop + objTable.offsetTop;;
				oVBar.runtimeStyle.height = objTable.parentElement.clientHeight;
				oVBar.runtimeStyle.display = "inline";
			}

			return true;
		}

		/*
		MouseUp event.
		This finishes the resize.
		*/
		function TableResize_OnMouseUp(objTable)
		{
			// Resize the column and its adjacent sibling if position and size are within threshold values
			var oAdjacentCell = null;
			var iAdjCellOldWidth = 0;
			var iResizeOldWidth = 0;

			if (iStartX != null && oResizeTarget != null)
			{
				iEndX = event.screenX;
				iSizeX = iEndX - iStartX;

				// Mark the table with the resize attribute for not resizing
				objTable.setAttribute("Resizing", "false");

				if ((oResizeTarget.offsetWidth + iSizeX) >= iSizeThreshold)
				{
					if (Math.abs(iSizeX) >= iResizeThreshold)
					{
						if (oResizeTarget.nextSibling != null)
						{
							oAdjacentCell = oResizeTarget.nextSibling;
							iAdjCellOldWidth = (oAdjacentCell.offsetWidth);
						}
						else
						{
							oAdjacentCell = null;
						}

						iResizeOldWidth = (oResizeTarget.offsetWidth);
						oResizeTarget.style.width = iResizeOldWidth + iSizeX;

						if ((oAdjacentCell != null) && (oAdjacentCell.tagName.toUpperCase() == sResizableElement))
						{
							oAdjacentCell.style.width = (((iAdjCellOldWidth - iSizeX) >= iSizeThreshold)?(iAdjCellOldWidth - iSizeX):(oAdjacentCell.style.width = iSizeThreshold))
						}
					}
				}
				else
				{
					oResizeTarget.style.width = iSizeThreshold;
				}
			}

			// Clean up the VBar and release event capture.
			TableResize_CleanUp();
			objTable.releaseCapture();

			return true;
		}
		<?php } ?>
		</script>
		<?php }
}
?>