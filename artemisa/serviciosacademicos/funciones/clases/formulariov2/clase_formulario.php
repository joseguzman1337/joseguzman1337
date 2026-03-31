<?php
class formulario extends ADODB_Active_Record
{
	/**
	 * variables de la clase
	 */
	var $conexion;
	var $nombre;
	var $metodo;
	var $accion;
	var $validacion;
	var $mensajegeneral='Los campos marcados con *, no han sido correctamente diligenciados:\n\n';
	var $array_validacion;
	var $array_tablas;
	var $array_datos_cuadro_chulitos;
	var $array_datos_cuadro_chulitos_cargados;
	var $array_datos_formulario;
	var $array_flechas;
	var $array_tabla_padre_hijo;
	var $contador;
	var $validaciongeneral;
	var $ultimoID;
	var $carga;
	var $array_datos_cargados;
	var $automatico;
	var $carga_distintivo;
	var $archivo_form;
	var $fechahoy;
	var $chulos;
	var $submitido;
	var $array_ids;
	var $array_datos_iterar;
	var $contador_chulitos;
	var $llave_carga;
	var $valor_llave_carga;
	var $llave_carga_distintiva;
	var $valor_llave_carga_distintiva;
	var $tabla_carga;
	var $chulos_cargados;
	var $contador_llamada_sql_chulos=0;
	var $debug;
	var $arrayTablasBD;
	var $ArrayAtributosTabla;
	var $InfoObjetoTabla;
	var $array_carga_archivo;
	var $rutaraiz="../../";


	function formulario(&$conexion,$nombre,$metodo,$accion="",$validar=false,$archivo_formulario="",$debug=false)
	{
		//$this->jsVarios();
		$this->debug=$debug;
		$this->nombre=$nombre;
		$this->metodo=$metodo;
		$this->accion=$accion;
		$this->validar=$validar;
		$this->conexion=$conexion;
		$this->automatico = @$automatico;
		$this->archivo_form=$archivo_formulario;
		$this->sql_chulos=false;
		$this->contador_chulitos=0;
		$this->chulos=false;
		$this->chulos_cargados=false;
		$this->validaciongeneral=true;
		$this->carga=false;
		$this->carga_distintivo=false;
		$this->fechahoy=date("Y-m-d H:i:s");
		$this->contador=0;
		$this->script_globo();
	}

	function submitir()
	{
		$this->submitido=true;
	}

	function agregar_datos_formulario($tabla_destino,$campo,$valor)
	{
		$this->array_datos_formulario[]=array('tabla'=>$tabla_destino,'campo'=>$campo,'valor'=>$valor);
	}

	function calendario($nombre,$tabla_destino,$tamano=20,$validacion="",$mensaje="",$ayuda="",$accion="")
	{
		if($this->metodo=='get' or $this->metodo=='GET')
		{
			$this->array_datos_formulario[]=array('tabla'=>$tabla_destino,'campo'=>$nombre,'valor'=>$_GET[$nombre]);
		}
		elseif ($this->metodo=='post' or $this->metodo=='POST')
		{
			$this->array_datos_formulario[]=array('tabla'=>$tabla_destino,'campo'=>$nombre,'valor'=>$_POST[$nombre]);
		}

		if($ayuda!="")
		{
			$globo=$this->globo($ayuda);
			$imagen="<img src='".$this->rutaraiz."imagenes/pregunta.gif'";
			$cadena='&nbsp;&nbsp'.$imagen.$globo."'>";
		}

		if($this->carga==true or $this->carga_distintivo==true)
		{
			$valor=$this->array_datos_cargados[$tabla_destino]->$nombre;
		}
		elseif($this->metodo=='get' or $this->metodo=='GET')
		{
			$valor=$_GET[$nombre];
		}
		elseif ($this->metodo=='post' or $this->metodo=='POST')
		{
			$valor=$_POST[$nombre];
		}
		echo "<input name='$nombre' type='text' id='$nombre' value='".$valor."' size='$tamano'><button id='bt$nombre'>...</button>$cadena\n";
		echo '<script type="text/javascript">
		Calendar.setup(
		{
			inputField : "'.$nombre.'", // ID of the input field
			ifFormat : "%Y-%m-%d", // the date format
			button : "bt'.$nombre.'" // ID of the button
		}
		);
			</script>';
		if($validacion!="")
		{
			if($this->metodo=='get' or $this->metodo=='GET')
			{
				$this->array_validacion[]=array('campo'=>$nombre,'valido'=>$this->validacion($_GET[$nombre],$validacion),'mensaje'=>$mensaje,'tipo'=>$validacion);
			}
			elseif ($this->metodo=='post' or $this->metodo=='POST')
			{
				$this->array_validacion[]=array('campo'=>$nombre,'valido'=>$this->validacion($_POST[$nombre],$validacion),'mensaje'=>$mensaje,'tipo'=>$validacion);
			}
		}
	}

	function CalendariorFechaHoraEnDosCampos($nombreCampofecha,$tabla_destinoCampofecha,$tamanoCampofecha=20,$nombreCampohora,$tabla_destinoCampohora,$tamanoCampohora=20,$validacion="",$mensaje="",$ayuda="",$accion="")
	{
		if($ayuda!="")
		{
			$globo=$this->globo($ayuda);
			$imagen="<img src='".$this->rutaraiz."imagenes/pregunta.gif'";
			$cadena='&nbsp;&nbsp'.$imagen.$globo."'>";
		}

		if($this->metodo=='get' or $this->metodo=='GET')
		{
			$this->array_datos_formulario[]=array('tabla'=>$tabla_destinoCampofecha,'campo'=>$nombreCampofecha,'valor'=>$_GET[$nombreCampofecha]);
			$this->array_datos_formulario[]=array('tabla'=>$tabla_destinoCampohora,'campo'=>$nombreCampohora,'valor'=>$_GET[$nombreCampohora]);
		}
		elseif ($this->metodo=='post' or $this->metodo=='POST')
		{
			$this->array_datos_formulario[]=array('tabla'=>$tabla_destinoCampofecha,'campo'=>$nombreCampofecha,'valor'=>$_POST[$nombreCampofecha]);
			$this->array_datos_formulario[]=array('tabla'=>$tabla_destinoCampohora,'campo'=>$nombreCampohora,'valor'=>$_POST[$nombreCampohora]);
		}

		if($this->carga==true or $this->carga_distintivo==true)
		{
			$valorFecha=$this->array_datos_cargados[$tabla_destinoCampofecha]->$nombreCampofecha;
			$valorHora=$this->array_datos_cargados[$tabla_destinoCampohora]->$nombreCampohora;
		}
		elseif($this->metodo=='get' or $this->metodo=='GET')
		{
			$valorFecha=$_GET[$nombreCampofecha];
			$valorHora=$_GET[$nombreCampohora];
		}
		elseif ($this->metodo=='post' or $this->metodo=='POST')
		{
			$valorFecha=$_POST[$nombreCampofecha];
			$valorHora=$_POST[$nombreCampohora];
		}

		echo "<input name='$nombreCampofecha' type='text' id='$nombreCampofecha' value='".$valorFecha."' size='$tamanoCampofecha'><button id='bt$nombreCampofecha'>...</button>\n";
		echo "<input name='$nombreCampohora' type='text' id='$nombreCampohora' value='".$valorHora."' size='$tamanoCampohora'>$cadena\n";

		echo '<script type="text/javascript">
		function PoneHora(cal)
		{
			var date = cal.date;
			var time = date.getTime()
			// use the _other_ field
			var field = document.getElementById("'.$nombreCampohora.'");
			var date2 = new Date(time);
			field.value = date2.print("%H:%M");
		}
			Calendar.setup(
			{
				inputField : "'.$nombreCampofecha.'", // ID of the input field
				ifFormat : "%Y-%m-%d", // the date format
				button : "bt'.$nombreCampofecha.'", // ID of the button
				showsTime : true,
				timeFormat : "24",
				onUpdate : PoneHora
			}
			);
		</script>';
		if($validacion!="")
		{
			if($this->metodo=='get' or $this->metodo=='GET')
			{
				$this->array_validacion[]=array('campo'=>$nombreCampofecha,'valido'=>$this->validacion($_GET[$nombreCampofecha],$validacion),'mensaje'=>$mensaje,'tipo'=>$validacion);
			}
			elseif ($this->metodo=='post' or $this->metodo=='POST')
			{
				$this->array_validacion[]=array('campo'=>$nombreCampohora,'valido'=>$this->validacion($_GET[$nombreCampohora],$validacion),'mensaje'=>$mensaje,'tipo'=>$validacion);
			}
		}
	}

	function combo($nombre,$tabla_destino,$metodo,$tabla_origen,$dato_insertar,$dato_mostrar,$where="",$orderby="",$accion="",$validacion="",$mensaje="",$ayuda="",$validacionJs='required')
	{
		if($ayuda!="")
		{
			$globo=$this->globo($ayuda);
			$imagen="<img src='".$this->rutaraiz."imagenes/pregunta.gif'";
			$cadena='&nbsp;&nbsp'.$imagen.$globo."'>";
		}
		if($this->metodo=='get' or $this->metodo=='GET')
		{
			$this->array_datos_formulario[]=array('tabla'=>$tabla_destino,'campo'=>$nombre,'valor'=>$_GET[$nombre]);
		}
		elseif ($this->metodo=='post' or $this->metodo=='POST')
		{
			$this->array_datos_formulario[]=array('tabla'=>$tabla_destino,'campo'=>$nombre,'valor'=>$_POST[$nombre]);
		}
		if($ayuda!="")
		{
			$globo=$this->globo($ayuda);
		}
		$select="SELECT $dato_insertar,$dato_mostrar";
		$from=" FROM $tabla_origen ";
		if($where!="")
		{
			$where="WHERE $where ";
		}
		if($orderby!="")
		{
			$orderby="ORDER BY $orderby ";
		}
		$query=$select.$from.$where.$orderby;
		$operacion=$this->conexion->query($query);
		$row_operacion=$operacion->fetchRow();
		echo
		"<select name='$nombre' id='$nombre' $accion $validacionJs>\n
		<option value=''>Seleccionar</option>\n";
		do
		{
			$seleccionar="";
			if($this->carga==true or $this->carga_distintivo==true)
			{
				if(!isset($_REQUEST[$nombre]))
				{
					if($this->array_datos_cargados[$tabla_destino]->$nombre == $row_operacion[$dato_insertar])
					{
						$seleccionar=" selected ";
					}
				}
				else
				{
					if($_REQUEST[$nombre] == $row_operacion[$dato_insertar])
					{
						$seleccionar=" selected ";
					}
				}
			}
			elseif($this->metodo=='get' or $this->metodo=='GET')
			{
				if(isset($_GET[$nombre]))
				{
					if($_GET[$nombre] == $row_operacion[$dato_insertar])
					{
						$seleccionar=" selected ";
					}
				}
			}
			elseif($this->metodo=='post' or $this->metodo=='POST')
			{
				if(isset($_POST[$nombre]))
				{
					if($_POST[$nombre] == $row_operacion[$dato_insertar])
					{
						$seleccionar=" selected ";
					}
				}
			}
			echo "<option value=$row_operacion[$dato_insertar]$seleccionar>$row_operacion[$dato_mostrar]</option>\n";
		}
		while ($row_operacion=$operacion->fetchRow());
		echo "</select>$cadena\n";
		if($validacion!="")
		{
			if($this->metodo=='get' or $this->metodo=='GET')
			{
				$this->array_validacion[]=array('campo'=>$nombre,'valido'=>$this->validacion($_GET[$nombre],$validacion),'mensaje'=>$mensaje,'tipo'=>$validacion);
			}
			elseif ($this->metodo=='post' or $this->metodo=='POST')
			{
				$this->array_validacion[]=array('campo'=>$nombre,'valido'=>$this->validacion($_POST[$nombre],$validacion),'mensaje'=>$mensaje,'tipo'=>$validacion);
			}
		}
	}

	function Boton($nombreboton,$etiquetaboton,$tipo="submit")
	{
		echo '<input name="'.$nombreboton.'" type="'.$tipo.'" id="'.$nombreboton.'" value="'.$etiquetaboton.'" />'."\n";
	}

	function combo_valor_por_defecto($nombre,$tabla_destino,$metodo,$tabla_origen,$dato_insertar,$dato_mostrar,$valor_por_defecto,$where="",$orderby="",$accion="",$validacion="",$mensaje="",$ayuda="",$validacionJs='required')
	{
		if($ayuda!="")
		{
			$globo=$this->globo($ayuda);
			$imagen="<img src='".$this->rutaraiz."imagenes/pregunta.gif'";
			$cadena='&nbsp;&nbsp'.$imagen.$globo."'>";
		}
		if($this->metodo=='get' or $this->metodo=='GET')
		{
			$this->array_datos_formulario[]=array('tabla'=>$tabla_destino,'campo'=>$nombre,'valor'=>$_GET[$nombre]);
		}
		elseif ($this->metodo=='post' or $this->metodo=='POST')
		{
			$this->array_datos_formulario[]=array('tabla'=>$tabla_destino,'campo'=>$nombre,'valor'=>$_POST[$nombre]);
		}
		if($ayuda!="")
		{
			$globo=$this->globo($ayuda);
		}
		$select="SELECT $dato_insertar,$dato_mostrar ";
		$from="FROM $tabla_origen ";
		if($where!="")
		{
			$where="WHERE $where ";
		}
		if($orderby!="")
		{
			$orderby="ORDER BY $orderby ";
		}
		$query=$select.$from.$where.$orderby;
		$operacion=$this->conexion->query($query);
		$row_operacion=$operacion->fetchRow();
		echo
		"<select name='$nombre' id='$nombre' $accion $validacionJs>\n";
		do
		{
			$seleccionar="";
			//if($this->carga==true or $this->carga_distintivo==true)
			{
				if($this->metodo=='post' or $this->metodo=='POST')
				{
					if($valor_por_defecto == $row_operacion[$dato_insertar] and !isset($_POST[$nombre]))
					{
						$seleccionar=" selected ";
					}

					elseif(isset($_POST[$nombre]))
					{
						if($_POST[$nombre] == $row_operacion[$dato_insertar])
						{
							$seleccionar=" selected ";
						}
					}
				}

				elseif(!isset($_REQUEST[$nombre]))
				{
					if($this->array_datos_cargados[$tabla_destino]->$nombre == $row_operacion[$dato_insertar])
					{
						$seleccionar=" selected ";
					}
				}
				else
				{
					if($_REQUEST[$nombre] == $row_operacion[$dato_insertar])
					{
						$seleccionar=" selected ";
					}
				}
			}
			if($this->metodo=='get' or $this->metodo=='GET')
			{
				if(isset($_GET[$nombre]))
				{
					if($_GET[$nombre] == $row_operacion[$dato_insertar])
					{
						$seleccionar=" selected ";
					}
				}
			}

			echo "<option value=$row_operacion[$dato_insertar]$seleccionar>$row_operacion[$dato_mostrar]</option>\n";
		}
		while ($row_operacion=$operacion->fetchRow());
		echo "</select>$cadena\n";
		if($validacion!="")
		{
			if($this->metodo=='get' or $this->metodo=='GET')
			{
				$this->array_validacion[]=array('campo'=>$nombre,'valido'=>$this->validacion($_GET[$nombre],$validacion),'mensaje'=>$mensaje,'tipo'=>$validacion);
			}
			elseif ($this->metodo=='post' or $this->metodo=='POST')
			{
				$this->array_validacion[]=array('campo'=>$nombre,'valido'=>$this->validacion($_POST[$nombre],$validacion),'mensaje'=>$mensaje,'tipo'=>$validacion);
			}
		}
	}


	function combo_array($nombre,$tabla_destino,$metodo,$array,$dato_insertar,$dato_mostrar,$accion="",$validacion="",$mensaje="",$ayuda="",$validacionJs='required')
	{
		if($ayuda!="")
		{
			$globo=$this->globo($ayuda);
			$imagen="<img src='".$this->rutaraiz."imagenes/pregunta.gif'";
			$cadena='&nbsp;&nbsp'.$imagen.$globo."'>";
		}
		if($this->metodo=='get' or $this->metodo=='GET')
		{
			$this->array_datos_formulario[]=array('tabla'=>$tabla_destino,'campo'=>$nombre,'valor'=>$_GET[$nombre]);
		}
		elseif ($this->metodo=='post' or $this->metodo=='POST')
		{
			$this->array_datos_formulario[]=array('tabla'=>$tabla_destino,'campo'=>$nombre,'valor'=>$_POST[$nombre]);
		}
		if($ayuda!="")
		{
			$globo=$this->globo($ayuda);
		}
		echo
		"<select name='$nombre' id='$nombre' $accion $validacionJs>\n
		<option value=''>Seleccionar</option>\n";
		foreach ($array as $llave => $valor)
		{
			$seleccionar="";
			if($this->carga==true or $this->carga_distintivo==true)
			{
				if(!isset($_REQUEST[$nombre]))
				{
					if($this->array_datos_cargados[$tabla_destino]->$nombre == $valor[$dato_insertar])
					{
						$seleccionar=" selected ";
					}
				}
				else
				{
					if($_REQUEST[$nombre] == $valor[$dato_insertar])
					{
						$seleccionar=" selected ";
					}
				}
			}
			elseif($this->metodo=='get' or $this->metodo=='GET')
			{
				if(isset($_GET[$nombre]))
				{
					if($_GET[$nombre] == $valor[$dato_insertar])
					{
						$seleccionar=" selected ";
					}
				}
			}
			elseif($this->metodo=='post' or $this->metodo=='POST')
			{
				if(isset($_POST[$nombre]))
				{
					if($_POST[$nombre] == $valor[$dato_insertar])
					{
						$seleccionar=" selected ";
					}
				}
			}
			echo "<option value=$valor[$dato_insertar]$seleccionar>$valor[$dato_mostrar]</option>\n";
		}
		echo "</select>$cadena\n";

		if($validacion!="")
		{
			if($this->metodo=='get' or $this->metodo=='GET')
			{
				$this->array_validacion[]=array('campo'=>$nombre,'valido'=>$this->validacion($_GET[$nombre],$validacion),'mensaje'=>$mensaje,'tipo'=>$validacion);
			}
			elseif ($this->metodo=='post' or $this->metodo=='POST')
			{
				$this->array_validacion[]=array('campo'=>$nombre,'valido'=>$this->validacion($_POST[$nombre],$validacion),'mensaje'=>$mensaje,'tipo'=>$validacion);
			}
		}
	}

	function memo($nombre,$tabla_destino,$columnas,$filas,$validacion="",$mensaje="",$ayuda="",$accion="",$desactivado=false,$validacionJs="required",$mask="",$minLength="",$maxlength="",$freemask="",$caseInsensitive="1")
	{
		if($desactivado==true)
		{
			$inactivo="disabled";
		}

		if($this->metodo=='get' or $this->metodo=='GET')
		{
			$this->array_datos_formulario[]=array('tabla'=>$tabla_destino,'campo'=>$nombre,'valor'=>$_GET[$nombre]);
		}
		elseif ($this->metodo=='post' or $this->metodo=='POST')
		{
			$this->array_datos_formulario[]=array('tabla'=>$tabla_destino,'campo'=>$nombre,'valor'=>$_POST[$nombre]);
		}
		if($ayuda!="")
		{
			$globo=$this->globo($ayuda);
			$imagen="<img src='".$this->rutaraiz."imagenes/pregunta.gif'";
			$cadena='&nbsp;&nbsp'.$imagen.$globo."'>";
		}
		if($this->carga==true or $this->carga_distintivo==true)
		{
			$valor=$this->array_datos_cargados[$tabla_destino]->$nombre;
		}
		elseif($this->metodo=='get' or $this->metodo=='GET')
		{
			$valor=$_GET[$nombre];
		}
		elseif ($this->metodo=='post' or $this->metodo=='POST')
		{
			$valor=$_POST[$nombre];
		}

		echo "<textarea name='$nombre' id='$nombre' $validacionJs mask='$mask' minlength='$minLength' maxlength='$maxlength' freemask='$freemask' caseinsensitive='$caseInsensitive' cols='$columnas' rows='$filas' wrap='VIRTUAL' $inactivo>$valor</textarea>$cadena\n";

		if($validacion!="")
		{
			if($this->metodo=='get' or $this->metodo=='GET')
			{
				$this->array_validacion[]=array('campo'=>$nombre,'valido'=>$this->validacion($_GET[$nombre],$validacion),'mensaje'=>$mensaje,'tipo'=>$validacion);
			}
			elseif ($this->metodo=='post' or $this->metodo=='POST')
			{
				$this->array_validacion[]=array('campo'=>$nombre,'valido'=>$this->validacion($_POST[$nombre],$validacion),'mensaje'=>$mensaje,'tipo'=>$validacion);
			}
		}
	}

	function memoValorPorDefecto($nombre,$tabla_destino,$columnas,$filas,$valorpordefecto,$validacion="",$mensaje="",$ayuda="",$accion="")
	{
		if($this->metodo=='get' or $this->metodo=='GET')
		{
			$this->array_datos_formulario[]=array('tabla'=>$tabla_destino,'campo'=>$nombre,'valor'=>$_GET[$nombre]);
		}
		elseif ($this->metodo=='post' or $this->metodo=='POST')
		{
			$this->array_datos_formulario[]=array('tabla'=>$tabla_destino,'campo'=>$nombre,'valor'=>$_POST[$nombre]);
		}
		if($ayuda!="")
		{
			$globo=$this->globo($ayuda);
			$imagen="<img src='".$this->rutaraiz."imagenes/pregunta.gif'";
			$cadena='&nbsp;&nbsp'.$imagen.$globo."'>";
		}
		if($this->carga==true or $this->carga_distintivo==true)
		{
			$valor=$this->array_datos_cargados[$tabla_destino]->$nombre;
		}
		else
		{
			$valor=$valorpordefecto;
		}

		echo "<textarea name='$nombre' cols='$columnas' rows='$filas' wrap='VIRTUAL'>$valor</textarea>$cadena\n";

		if($validacion!="")
		{
			if($this->metodo=='get' or $this->metodo=='GET')
			{
				$this->array_validacion[]=array('campo'=>$nombre,'valido'=>$this->validacion($_GET[$nombre],$validacion),'mensaje'=>$mensaje,'tipo'=>$validacion);
			}
			elseif ($this->metodo=='post' or $this->metodo=='POST')
			{
				$this->array_validacion[]=array('campo'=>$nombre,'valido'=>$this->validacion($_POST[$nombre],$validacion),'mensaje'=>$mensaje,'tipo'=>$validacion);
			}
		}
	}

	function campotexto($nombre,$tabla_destino,$tamano=20,$validacion="",$mensaje="",$ayuda="",$accion="",$validacionJs="required",$mask="",$minLength="",$maxlength="",$freemask="",$caseInsensitive="1")
	{
		if($this->metodo=='get' or $this->metodo=='GET')
		{
			$this->array_datos_formulario[]=array('tabla'=>$tabla_destino,'campo'=>$nombre,'valor'=>$_GET[$nombre]);
		}
		elseif ($this->metodo=='post' or $this->metodo=='POST')
		{
			$this->array_datos_formulario[]=array('tabla'=>$tabla_destino,'campo'=>$nombre,'valor'=>$_POST[$nombre]);
		}
		if($ayuda!="")
		{
			$globo=$this->globo($ayuda);
			$imagen="<img src='".$this->rutaraiz."imagenes/pregunta.gif'";
			$cadena='&nbsp;&nbsp'.$imagen.$globo."'>";
		}
		if($this->carga==true or $this->carga_distintivo==true)
		{
			$valor=$this->array_datos_cargados[$tabla_destino]->$nombre;
		}
		elseif($this->metodo=='get' or $this->metodo=='GET')
		{
			$valor=$_GET[$nombre];
		}
		elseif ($this->metodo=='post' or $this->metodo=='POST')
		{
			$valor=$_POST[$nombre];
		}

		echo "<input name='$nombre' type='text' class='textInput' $validacionJs mask='$mask' minlength='$minLength' maxlength='$maxlength' freemask='$freemask' caseInsensitive='$caseInsensitive' id='$nombre' value='".$valor."' size='$tamano'>$cadena\n";

		if($validacion!="")
		{
			if($this->metodo=='get' or $this->metodo=='GET')
			{
				$this->array_validacion[]=array('campo'=>$nombre,'valido'=>$this->validacion($_GET[$nombre],$validacion),'mensaje'=>$mensaje,'tipo'=>$validacion);
			}
			elseif ($this->metodo=='post' or $this->metodo=='POST')
			{
				$this->array_validacion[]=array('campo'=>$nombre,'valido'=>$this->validacion($_POST[$nombre],$validacion),'mensaje'=>$mensaje,'tipo'=>$validacion);
			}
		}
	}

	function celda_horizontal_combo($nombre,$etiqueta,$tabla_origen,$tabla_destino,$dato_insertar,$dato_mostrar,$validacion,$mensaje,$where="",$orderby="",$ayuda='',$accion='')
	{
		echo "<tr>\n";
		echo "<td nowrap id='tdtitulogris'>\n";
		$this->etiqueta($nombre,$etiqueta,$validacion);
		echo "</td>\n";
		echo "<td>\n";
		$this->combo($nombre,$tabla_destino,'',$tabla_origen,$dato_insertar,$dato_mostrar,$where,$orderby,$accion,'','',$ayuda);
		echo "</td>\n";
		echo "</tr>\n";
	}

	function celdaHorizontalComboDHTML($nombre,$etiqueta,$tabla_origen,$tabla_destino,$dato_insertar,$dato_mostrar,$validacion,$mensaje,$where="",$orderby="",$ayuda='',$accion='',$validacionJs='required')
	{
		echo "<tr>\n";
		echo "<td nowrap id='tdtitulogris'>\n";
		$this->etiqueta($nombre,$etiqueta,$validacion);
		echo "</td>\n";
		echo '<td id="_'.$nombre.'"></td>';
		echo "<td>\n";
		$this->combo($nombre,$tabla_destino,'',$tabla_origen,$dato_insertar,$dato_mostrar,$where,$orderby,$accion,'','',$ayuda,$validacionJs);
		echo "</td>\n";
		echo "</tr>\n";
	}

	function celdaHorizontalComboValorDefectoDHTML($nombre,$etiqueta,$tabla_origen,$tabla_destino,$dato_insertar,$dato_mostrar,$valordefecto,$validacion,$mensaje,$where="",$orderby="",$ayuda='',$accion='',$validacionJs='required')
	{
		echo "<tr>\n";
		echo "<td nowrap id='tdtitulogris'>\n";
		$this->etiqueta($nombre,$etiqueta,$validacion);
		echo "</td>\n";
		echo '<td id="_'.$nombre.'"></td>';
		echo "<td>\n";
		$this->combo_valor_por_defecto($nombre,$tabla_destino,'',$tabla_origen,$dato_insertar,$dato_mostrar,$valordefecto,$where,$orderby,$accion,$validacion,$mensaje,$ayuda,$validacionJs);
		echo "</td>\n";
		echo "</tr>\n";
	}

	function celdaHorizontalComboArrayDHTML($nombre,$etiqueta,$array,$tabla_destino,$dato_insertar,$dato_mostrar,$validacion,$mensaje,$where="",$orderby="",$ayuda='',$accion='',$validacionJs='required')
	{
		echo "<tr>\n";
		echo "<td nowrap id='tdtitulogris'>\n";
		$this->etiqueta($nombre,$etiqueta,$validacion);
		echo "</td>\n";
		echo '<td id="_'.$nombre.'"></td>';
		echo "<td nowrap id='tdtitulogris'>\n";
		$this->combo_array($nombre,$tabla_destino,'',$array,$dato_insertar,$dato_mostrar,$accion,'','',$ayuda,$validacionJs);
		echo "</td>\n";
		echo "</tr>\n";
	}

	function celda_horizontal_combo_array($nombre,$etiqueta,$array,$tabla_destino,$dato_insertar,$dato_mostrar,$validacion,$mensaje,$where="",$orderby="",$ayuda='',$accion='')
	{
		echo "<tr>\n";
		echo "<td nowrap id='tdtitulogris'>\n";
		$this->etiqueta($nombre,$etiqueta,$validacion);
		echo "</td>\n";
		echo "<td nowrap id='tdtitulogris'>\n";
		$this->combo_array($nombre,$tabla_destino,'',$array,$dato_insertar,$dato_mostrar,$accion,'','',$ayuda);
		echo "</td>\n";
		echo "</tr>\n";
	}


	function celda_horizontal_campotexto($nombre,$etiqueta,$tabla_destino,$tamano=20,$validacion="",$mensaje="",$ayuda="",$accion="")
	{
		echo "<tr>\n";
		echo "<td nowrap id='tdtitulogris'>\n";
		$this->etiqueta($nombre,$etiqueta,$validacion);
		echo "</td>\n";
		echo "<td>\n";
		$this->campotexto($nombre,$tabla_destino,$tamano,'','',$ayuda,$accion);
		echo "</td>\n";
		echo "</tr>\n";
	}

	function celdaHorizontalCampoTextoDHTML($nombre,$etiqueta,$tabla_destino,$tamano=20,$validacion="",$mensaje="",$ayuda="",$accion="",$validacionJs="required",$mask="",$minLength="",$maxlength="",$freemask="",$caseInsensitive="1")
	{
		echo "<tr>\n";
		echo "<td nowrap id='tdtitulogris'>\n";
		$this->etiqueta($nombre,$etiqueta,$validacion);
		echo "</td>\n";
		echo '<td id="_'.$nombre.'"></td>';
		echo "<td>\n";
		$this->campotexto($nombre,$tabla_destino,$tamano,'','',$ayuda,$accion,$validacionJs,$mask,$minLength,$maxlength,$freemask,$caseInsensitive);
		echo "</td>\n";
		echo "</tr>\n";
	}


	function celda_horizontal_calendario($nombre,$etiqueta,$tabla_destino,$validacion="",$mensaje="",$ayuda="",$accion="")
	{
		echo "<tr>\n";
		echo "<td nowrap id='tdtitulogris'>\n";
		$this->etiqueta($nombre,$etiqueta,$validacion);
		echo "</td>\n";
		echo "<td>\n";
		$this->calendario($nombre,$tabla_destino,8,'','',$ayuda,$accion);
		echo "</td>\n";
		echo "</tr>\n";
	}


	function celda_horizontal_calendarioFechaHora($nombreCampoFecha,$etiquetaCampoFecha,$tabla_destinoCampoFecha,$validacionCampoFecha="",$nombreCampoHora,$tablaDestinoCampoHora,$mensaje="",$ayuda="",$accion="")
	{
		echo "<tr>\n";
		echo "<td nowrap id='tdtitulogris'>\n";
		$this->etiqueta($nombreCampoFecha,$etiquetaCampoFecha,$validacionCampoFecha);
		echo "</td>\n";
		echo "<td>\n";
		$this->CalendariorFechaHoraEnDosCampos($nombreCampoFecha,$tabla_destinoCampoFecha,8,$nombreCampoHora,$tablaDestinoCampoHora,8,"","",$ayuda,$accion);
		echo "</td>\n";
		echo "</tr>\n";
	}

	function celda_vertical_memo($nombre,$etiqueta,$tabla_destino,$columnas,$filas,$validacion="",$mensaje="",$ayuda="",$accion="",$desactivado=false)
	{
		echo "<tr>\n";
		echo "<td  nowrap id='tdtitulogris' colspan='2'>\n";
		$this->etiqueta($nombre,$etiqueta,$validacion);
		echo "</td>\n";
		echo "</tr>\n";
		echo "<tr>\n";
		echo "<td colspan='2'>";
		$this->memo($nombre,$tabla_destino,$columnas,$filas,'','',$ayuda,$accion,$desactivado);
		echo "</td>";
		echo "</tr>\n";
	}

	function celdaVerticalMemoDHTML($nombre,$etiqueta,$tabla_destino,$columnas,$filas,$validacion="",$mensaje="",$ayuda="",$accion="",$desactivado=false,$validacionJs="required",$mask="",$minLength="",$maxlength="",$freemask="",$caseInsensitive="1")
	{
		echo "<tr>\n";
		echo "<td  nowrap id='tdtitulogris' colspan='3'>\n";
		$this->etiqueta($nombre,$etiqueta,$validacion);
		echo "</td>\n";
		echo "</tr>\n";
		echo "<tr>\n";
		echo "</td>\n";
		echo "<td>\n";
		echo "</td>\n";
		echo '<td align="right" id="_'.$nombre.'"></td>';
		echo "<td colspan='3'>";
		$this->memo($nombre,$tabla_destino,$columnas,$filas,'','',$ayuda,$accion,$desactivado,$validacionJs,$mask,$minLength,$maxlength,$freemask,$caseInsensitive);
		echo "</td>";
		echo "</tr>\n";
	}


	function boton_ventana_emergente($nombre,$destino,$variablesGet="",$width=300,$height=300,$top=200,$left=150,$scrollbars="yes",$resizable="yes",$toolbar="no",$status="no",$menu="no")
	{
		$emergente='<input type="button" name="'.$nombre.'" value="'.$nombre.'" onClick="window.open('."'".$destino.'?'.$variablesGet."','$nombre'".",'width=".$width.",height=".$height.",top=".$top.",left=".$left.",scrollbars=$scrollbars,toolbar=$toolbar,resizable=$resizable,status=$status,menu=$menu');".'"'.">";
		echo $emergente;
	}

	function agregar_validaciones_extra($nombre,$validacion,$valido=false,$mensaje)
	{
		$this->array_validacion[]=array('campo'=>$nombre,'valido'=>$valido,'mensaje'=>$mensaje,'tipo'=>$validacion);
	}

	function cargar_cuadro_chulitos_bd($titulo,$tabla_origen,$where,$orderby,$dato_insertar,$dato_mostrar,$tabla_destino,$llave_tabla_destino,$llave_deshabilita,$valor_llave_habilita,$valor_llave_deshabilita,$divisor=4,$tamano="",$wrap="",$metodo="",$destino="")
	{
		$this->chulos_cargados=true;
		$chuliado=false;
		$existe=false;
		$chequear="";
		$select="SELECT $dato_insertar,$dato_mostrar ";
		$from="FROM $tabla_origen ";
		if($where!="")
		{
			$where="WHERE $where ";
		}
		if($orderby!="")
		{
			$orderby="ORDER BY $orderby ";
		}
		$query=$select.$from.$where.$orderby.";";
		//echo $query,"<br>";
		$operacion=$this->conexion->query($query);
		$row_operacion=$operacion->fetchRow();
		$contador=1;
		if($metodo!="")
		{
			echo "<form name='chulitos' method='$metodo' action='$destino'>\n";
		}
		echo "<table border='1' cellpadding='1' cellspacing='0' bordercolor='#E9E9E9' width='$tamano'>\n";
		if($titulo!="")
		{
			echo "<caption align=LEFT><h4>$titulo</h4></caption>";
		}
		do
		{
			if($this->carga_distintivo==true)
			{
				$query_carga="SELECT $dato_insertar,$llave_deshabilita FROM $tabla_destino WHERE $this->llave_carga_distintiva = $this->valor_llave_carga_distintiva AND $dato_insertar='$row_operacion[$dato_insertar]'";
			}
			else
			{
				$query_carga="SELECT $dato_insertar,$llave_deshabilita FROM $tabla_destino WHERE $this->llave_carga = $this->valor_llave_carga AND $dato_insertar='$row_operacion[$dato_insertar]'";
			}

			$operacion_carga=$this->conexion->query($query_carga);
			$row_operacion_carga=$operacion_carga->fetchRow();

			/*$query_habilitado="SELECT COUNT($dato_insertar) as $dato_insertar FROM $tabla_destino WHERE $this->llave_carga = $this->valor_llave_carga AND $dato_insertar=$row_operacion[$dato_insertar] and $llave_deshabilita=$valor_llave_habilita;";
			$operacion_habilitado=$this->conexion->query($query_habilitado);
			$row_operacion_habilitado=$operacion_habilitado->fetchRow();*/
			$habilitado=false;
			if($row_operacion_carga[$dato_insertar]!="")
			{

				$existe=true;
			}
			else
			{
				$existe=false;
			}

			if($row_operacion_carga[$llave_deshabilita]==$valor_llave_habilita)
			{
				$chequear="checked";
				$habilitado=true;
			}
			else
			{
				$chequear="";
				$habilitado=false;
			}

			/******************/
			$chuliado=false;
			if($this->metodo=='post' or $this->metodo=='POST')
			{
				foreach($_POST as $vpost => $valor)
				{
					if (ereg("^sel$tabla_destino".$valor."$",$vpost))
					{
						if($row_operacion[$dato_insertar]==$valor)
						{
							$chuliado=true;
						}
					}
				}
			}
			/*****************/
			$this->array_datos_cuadro_chulitos_cargados[]=array('tabla'=>$tabla_destino,'llave'=>$this->llave_carga,'campo'=>$dato_insertar,'valor'=>$row_operacion[$dato_insertar],'existe'=>$existe,'chuliado'=>$chuliado,'habilitado'=>$habilitado);
			if($contador%$divisor==0)
			{
				$contador=1;
				echo "<tr>\n";
			}
			echo "<td $wrap>".$row_operacion[$dato_mostrar]."&nbsp;</td>\n";
			echo "<td><div align='center'><input type='checkbox'  name='sel$tabla_destino".$row_operacion[$dato_insertar]."' $chequear value='".$row_operacion[$dato_insertar]."'></div></td>\n";
			if($contador%$divisor==0)
			{
				$contador=1;
				echo "</tr>\n";
			}
			$contador++;
		}
		while($row_operacion=$operacion->fetchRow());
		echo "<table>\n";
		if($metodo!="")
		{
			echo "</form>\n";
		}
		if ($this->chulos_cargados==true)
		{
			$this->asignar_cuadro_chulitos_bd($tabla_destino,$llave_tabla_destino,$dato_insertar);
		}
	}

	function cargar_cuadro_chulitos_bd_query($query,$titulo,$tabla_origen,$where,$and,$orderby,$dato_insertar,$dato_mostrar,$tabla_destino,$llave_tabla_destino,$llave_deshabilita,$valor_llave_habilita,$valor_llave_deshabilita,$divisor=4,$tamano="",$wrap="",$metodo="",$destino="")
	{
		$this->chulos_cargados=true;
		$chuliado=false;
		$existe=false;
		$chequear="";
		$operacion=$this->conexion->query($query);
		$row_operacion=$operacion->fetchRow();
		$contador=1;
		if($metodo!="")
		{
			echo "<form name='chulitos' method='$metodo' action='$destino'>\n";
		}
		echo "<table border='1' cellpadding='1' cellspacing='0' bordercolor='#E9E9E9' width='$tamano'>\n";
		if($titulo!="")
		{
			echo "<caption align=LEFT>$titulo</caption>";
		}
		do
		{
			if($this->carga_distintivo==true)
			{
				$query_carga="SELECT $dato_insertar,$llave_deshabilita FROM $tabla_destino WHERE $this->llave_carga_distintiva = $this->valor_llave_carga_distintiva AND $dato_insertar=$row_operacion[$dato_insertar] $and";
			}
			else
			{
				$query_carga="SELECT $dato_insertar,$llave_deshabilita FROM $tabla_destino WHERE $this->llave_carga = $this->valor_llave_carga AND $dato_insertar=$row_operacion[$dato_insertar] $and";
			}
			//esta vaina es para que no se produzca error SQL cuando no hay ningun dato_insertar
			if($row_operacion[$dato_insertar]<>"")
			{
				$operacion_carga=$this->conexion->query($query_carga);
				$row_operacion_carga=$operacion_carga->fetchRow();
			}


			/*$query_habilitado="SELECT COUNT($dato_insertar) as $dato_insertar FROM $tabla_destino WHERE $this->llave_carga = $this->valor_llave_carga AND $dato_insertar=$row_operacion[$dato_insertar] and $llave_deshabilita=$valor_llave_habilita;";
			$operacion_habilitado=$this->conexion->query($query_habilitado);
			$row_operacion_habilitado=$operacion_habilitado->fetchRow();*/
			$habilitado=false;
			if($row_operacion_carga[$dato_insertar]!="")
			{

				$existe=true;
			}
			else
			{
				$existe=false;
			}

			if($row_operacion_carga[$llave_deshabilita]==$valor_llave_habilita)
			{
				$chequear="checked";
				$habilitado=true;
			}
			else
			{
				$chequear="";
				$habilitado=false;
			}

			/******************/
			$chuliado=false;
			if($this->metodo=='post' or $this->metodo=='POST')
			{
				foreach($_POST as $vpost => $valor)
				{
					if (ereg("^sel$tabla_destino".$valor."$",$vpost))
					{
						if($row_operacion[$dato_insertar]==$valor)
						{
							$chuliado=true;
						}
					}
				}
			}
			/*****************/
			$this->array_datos_cuadro_chulitos_cargados[]=array('tabla'=>$tabla_destino,'llave'=>$this->llave_carga,'campo'=>$dato_insertar,'valor'=>$row_operacion[$dato_insertar],'existe'=>$existe,'chuliado'=>$chuliado,'habilitado'=>$habilitado);
			if($contador%$divisor==0)
			{
				$contador=1;
				echo "<tr>\n";
			}
			echo "<td $wrap>".$row_operacion[$dato_mostrar]."&nbsp;</td>\n";
			echo "<td><div align='center'><input type='checkbox'  name='sel$tabla_destino".$row_operacion[$dato_insertar]."' $chequear value='".$row_operacion[$dato_insertar]."'></div></td>\n";
			if($contador%$divisor==0)
			{
				$contador=1;
				echo "</tr>\n";
			}
			$contador++;
		}
		while($row_operacion=$operacion->fetchRow());
		echo "<table>\n";
		if($metodo!="")
		{
			echo "</form>\n";
		}
		if ($this->chulos_cargados==true)
		{
			$this->asignar_cuadro_chulitos_bd($tabla_destino,$llave_tabla_destino,$dato_insertar);
		}
	}

	function cuadro_chulitos_bd($titulo,$tabla_origen,$where,$orderby,$dato_insertar,$dato_mostrar,$tabla_destino,$llave_tabla_destino,$llave_deshabilita,$valor_llave_habilita,$valor_llave_deshabilita,$divisor=4,$tamano="",$wrap="",$metodo="",$destino="")
	{
		if($this->carga==true or $this->carga_distintivo==true)
		{
			$this->cargar_cuadro_chulitos_bd($titulo,$tabla_origen,$where,$orderby,$dato_insertar,$dato_mostrar,$tabla_destino,$llave_tabla_destino,$llave_deshabilita,$valor_llave_habilita,$valor_llave_deshabilita,$divisor,$tamano,$wrap,$metodo,$destino);
			return;
		}

		$select="SELECT $dato_insertar,$dato_mostrar ";
		$from="FROM $tabla_origen ";
		if($where!="")
		{
			$where="WHERE $where ";
		}
		if($orderby!="")
		{
			$orderby="ORDER BY $orderby ";
		}
		$query=$select.$from.$where.$orderby;
		$operacion=$this->conexion->query($query);
		$row_operacion=$operacion->fetchRow();
		$contador=1;
		if($metodo!="")
		{
			echo "<form name='chulitos' method='$metodo' action='$destino'>\n";
		}
		echo "<table border='1' cellpadding='1' cellspacing='0' bordercolor='#E9E9E9' width='$tamano'>\n";
		if($titulo!="")
		{
			echo "<caption align=LEFT><p>$titulo</p></caption>";
		}
		do
		{
			if($contador%$divisor==0)
			{
				$contador=1;
				echo "<tr>\n";
			}
			echo "<td $wrap>".$row_operacion[$dato_mostrar]."&nbsp;</td>\n";
			if($_POST["sel$tabla_destino".$row_operacion[$dato_insertar]]==$row_operacion[$dato_insertar])
			{
				$chequear="checked";
				$this->chulos=true;
			}
			else
			{
				$chequear="";
			}
			echo "<td><div align='center'><input type='checkbox'  name='sel$tabla_destino".$row_operacion[$dato_insertar]."' $chequear value='".$row_operacion[$dato_insertar]."'></div></td>\n";

			if($contador%$divisor==0)
			{
				$contador=1;
				echo "</tr>\n";
			}
			$contador++;

		}
		while($row_operacion=$operacion->fetchRow());
		echo "<table>\n";
		if($metodo!="")
		{
			echo "</form>\n";
		}
		if($this->chulos==true)
		{
			$this->asignar_cuadro_chulitos_bd($tabla_destino,$llave_tabla_destino,$dato_insertar);
		}
	}

	function cuadro_chulitos_bd_query($query,$titulo,$tabla_origen,$where,$and="",$orderby,$dato_insertar,$dato_mostrar,$tabla_destino,$llave_tabla_destino,$llave_deshabilita,$valor_llave_habilita,$valor_llave_deshabilita,$divisor=4,$tamano="",$wrap="",$metodo="",$destino="")
	{
		if($this->carga==true or $this->carga_distintivo==true)
		{
			$this->cargar_cuadro_chulitos_bd_query($query,$titulo,$tabla_origen,$where,$and,$orderby,$dato_insertar,$dato_mostrar,$tabla_destino,$llave_tabla_destino,$llave_deshabilita,$valor_llave_habilita,$valor_llave_deshabilita,$divisor,$tamano,$wrap,$metodo,$destino);
			return;
		}

		$operacion=$this->conexion->query($query);
		$row_operacion=$operacion->fetchRow();
		$contador=1;
		if($metodo!="")
		{
			echo "<form name='chulitos' method='$metodo' action='$destino'>\n";
		}
		echo "<table border='1' cellpadding='1' cellspacing='0' bordercolor='#E9E9E9' width='$tamano'>\n";
		if($titulo!="")
		{
			echo "<caption align=LEFT>$titulo</caption>";
		}
		do
		{
			if($contador%$divisor==0)
			{
				$contador=1;
				echo "<tr>\n";
			}
			echo "<td $wrap>".$row_operacion[$dato_mostrar]."&nbsp;</td>\n";
			if($_POST["sel$tabla_destino".$row_operacion[$dato_insertar]]==$row_operacion[$dato_insertar])
			{
				$chequear="checked";
				$this->chulos=true;
			}
			else
			{
				$chequear="";
			}
			echo "<td><div align='center'><input type='checkbox'  name='sel$tabla_destino".$row_operacion[$dato_insertar]."' $chequear value='".$row_operacion[$dato_insertar]."'></div></td>\n";

			if($contador%$divisor==0)
			{
				$contador=1;
				echo "</tr>\n";
			}
			$contador++;

		}
		while($row_operacion=$operacion->fetchRow());
		echo "<table>\n";
		if($metodo!="")
		{
			echo "</form>\n";
		}
		if($this->chulos==true)
		{
			$this->asignar_cuadro_chulitos_bd($tabla_destino,$llave_tabla_destino,$dato_insertar);
		}
	}

	function asignar_cuadro_chulitos_bd($tabla_destino,$llave_tabla_destino,$dato_insertar)
	{
		if($this->metodo=='post' or $this->metodo=='POST')
		{
			foreach($_POST as $vpost => $valor)
			{
				if (ereg("^sel$tabla_destino".$valor."$",$vpost))
				{
					$this->array_datos_cuadro_chulitos[]=array('tabla'=>$tabla_destino,'campo'=>$dato_insertar,'valor'=>$valor);
				}
			}
		}
	}


	/**
	 * Inserta los chulitos en la tabla, pero los valores a cargar, provienen de un query
	 * inserta chulos, quita chulos, cambia estados
	 * @param unknown_type $sql
	 * @param unknown_type $tabla_destino
	 * @param unknown_type $dato_insertar
	 * @param unknown_type $llave_deshabilita
	 * @param unknown_type $valor_llave_habilita
	 * @param unknown_type $valor_llave_deshabilita
	 * @param unknown_type $cantidad_llamadas
	 * @param unknown_type $accion_inserta
	 * @param unknown_type $accion_actualiza
	 */function sql_cuadro_chulitos_bd_query($sql,$tabla_destino,$dato_insertar,$llave_deshabilita,$valor_llave_habilita,$valor_llave_deshabilita,$cantidad_llamadas,$accion_inserta="",$accion_actualiza="",$confirmacion=true)
	{
		$this->contador_llamada_sql_chulos++;
		if($this->chulos_cargados==false)
		{
			if(is_array($this->array_datos_cuadro_chulitos) and $this->validaciongeneral==true and $this->chulos_cargados==false)
			{
				$campos="";
				$valores="";
				if($campos=="")
				{
					foreach ($sql as $llave_sql => $valor_sql)
					{
						$campos=$campos.$valor_sql['campo'].",";
						$valores=$valores.$valor_sql['valor'].",";
					}
				}
				$campos="(".$campos.$dato_insertar.")";

				foreach ($this->array_datos_cuadro_chulitos as $llave => $valor)
				{
					if($valor['tabla']==$tabla_destino)
					{
						$sql="INSERT INTO $tabla_destino $campos VALUES ($valores'".$valor['valor']."')";
						//echo "<br>",$sql,"<br>";
						$this->conexion->query($sql);
					}
				}
				if($this->contador_llamada_sql_chulos==$cantidad_llamadas)
				{
					if($confirmacion==true)
					{
						echo "<script language='javascript'>alert('Datos insertados correctamente')</script>";
					}
					if($accion_inserta!="")
					{
						echo $accion_inserta;
					}
				}
			}
		}
		elseif($this->chulos_cargados==true)
		{
			if(is_array($this->array_datos_cuadro_chulitos_cargados) and $this->validaciongeneral==true and $this->submitido==true)
			{
				$campos="";
				$valores="";
				if($campos=="")
				{
					foreach ($sql as $llave_sql => $valor_sql)
					{
						$campos=$campos.$valor_sql['campo'].",";
						$valores=$valores.$valor_sql['valor'].",";
					}
				}
				$campos="(".$campos.$dato_insertar.")";

				foreach ($this->array_datos_cuadro_chulitos_cargados as $llave => $valor)
				{
					if($valor['existe']==true and $valor['chuliado']==true and $valor['habilitado']==false)
					{
						if($valor['tabla']==$tabla_destino)
						{
							if($this->carga_distintivo==true)
							{
								$query="UPDATE $tabla_destino SET $llave_deshabilita=$valor_llave_habilita WHERE ".$valor['campo']."=".$valor['valor']." AND $this->llave_carga_distintiva=$this->valor_llave_carga_distintiva;";
							}
							else
							{
								$query="UPDATE $tabla_destino SET $llave_deshabilita=$valor_llave_habilita WHERE ".$valor['campo']."=".$valor['valor']." AND $this->llave_carga=$this->valor_llave_carga;";
							}
							$operacion=$this->conexion->query($query);
							echo "<br>",$query,"<br>";
						}
					}
					elseif($valor['existe']==false and $valor['chuliado']==true)
					{
						if($valor['tabla']==$tabla_destino)
						{
							if($this->carga_distintivo==true)
							{
								$query="INSERT INTO $tabla_destino $campos VALUES ($valores'".$valor['valor']."')";
							}
							else
							{
								$query="INSERT INTO $tabla_destino $campos VALUES ($valores'".$valor['valor']."')";
							}
							$operacion=$this->conexion->query($query);
							//echo "<br>",$query,"<br>";
						}
					}
					if ($valor['existe']==true and $valor['chuliado']==false)
					{
						if($valor['tabla']==$tabla_destino)
						{
							if($this->carga_distintivo==true)
							{
								$query="UPDATE $tabla_destino SET $llave_deshabilita=$valor_llave_deshabilita WHERE ".$valor['campo']."=".$valor['valor']." AND $this->llave_carga_distintiva=$this->valor_llave_carga_distintiva;";
							}
							else
							{
								$query="UPDATE $tabla_destino SET $llave_deshabilita=$valor_llave_deshabilita WHERE ".$valor['campo']."=".$valor['valor']." AND $this->llave_carga=$this->valor_llave_carga;";
							}
							$operacion=$this->conexion->query($query);
							//echo "<br>",$query,"<br>";
						}
					}
				}
				if($this->contador_llamada_sql_chulos==$cantidad_llamadas)
				{
					if($confirmacion==true)
					{
						echo "<script language='javascript'>alert('Datos actualizados correctamente')</script>";
					}

					if($accion_actualiza!="")
					{
						echo $accion_actualiza;
					}
				}
			}
		}
	}

	/**
	 * Inserta los chulitos, en la tabla, pero también inserta en una tabla tipo log, para lo cual instancia el objeto que le entra en objetolog
	 * inserta chulos, quita chulos, cambia estados
	 * los valores a cargar provienen de un query
	 * @param unknown_type $objetolog representa el objeto de datos a instanciar por ado(la tabla)
	 * @param unknown_type $llave_objeto_padre informa la llave de la tabla papa del log
	 * @param arreglo bidimensional $llave_objeto_log informa al objeto log, los valores adicionales, que son estaticos
	 * @param unknown_type $sql representa el query
	 * @param unknown_type $tabla_destino
	 * @param unknown_type $dato_insertar
	 * @param unknown_type $llave_deshabilita
	 * @param unknown_type $valor_llave_habilita
	 * @param unknown_type $valor_llave_deshabilita
	 * @param unknown_type $cantidad_llamadas
	 * @param unknown_type $accion_inserta
	 * @param unknown_type $accion_actualiza
	 */

	/**
	 * Inserta valores en la tabla, pero el query se construye por el array $sql de entrada
	 * inserta chulos, quita chulos, cambia estados
	 *
	 * @param unknown_type $sql
	 * @param unknown_type $tabla_destino
	 * @param unknown_type $dato_insertar
	 * @param unknown_type $llave_deshabilita
	 * @param unknown_type $valor_llave_habilita
	 * @param unknown_type $valor_llave_deshabilita
	 * @param unknown_type $cantidad_llamadas
	 * @param unknown_type $accion_inserta
	 * @param unknown_type $accion_actualiza
	 */function sql_cuadro_chulitos_bd($sql,$tabla_destino,$dato_insertar,$llave_deshabilita,$valor_llave_habilita,$valor_llave_deshabilita,$cantidad_llamadas,$accion_inserta="",$accion_actualiza="",$confirmacion=true)
	{
		$this->contador_llamada_sql_chulos++;
		if($this->chulos_cargados==false)
		{
			if(is_array($this->array_datos_cuadro_chulitos) and $this->validaciongeneral==true and $this->chulos_cargados==false)
			{
				$campos="";
				$valores="";
				if($campos=="")
				{
					foreach ($sql as $llave_sql => $valor_sql)
					{
						$campos=$campos.$valor_sql['campo'].",";
						$valores=$valores.$valor_sql['valor'].",";
					}
				}
				$campos="(".$campos.$dato_insertar.")";

				foreach ($this->array_datos_cuadro_chulitos as $llave => $valor)
				{
					if($valor['tabla']==$tabla_destino)
					{
						$sql="INSERT INTO $tabla_destino $campos VALUES ($valores'".$valor['valor']."')";
						//echo "<br>",$sql,"<br>";
						$this->conexion->query($sql);
					}
				}
				if($this->contador_llamada_sql_chulos==$cantidad_llamadas)
				{
					if($confirmacion==true)
					{
						echo "<script language='javascript'>alert('Datos insertados correctamente')</script>";
					}
					if($accion_inserta!="")
					{
						echo $accion_inserta;
					}
				}
			}
		}
		elseif($this->chulos_cargados==true)
		{
			if(is_array($this->array_datos_cuadro_chulitos_cargados) and $this->validaciongeneral==true and $this->submitido==true)
			{
				$campos="";
				$valores="";
				if($campos=="")
				{
					foreach ($sql as $llave_sql => $valor_sql)
					{
						$campos=$campos.$valor_sql['campo'].",";
						$valores=$valores.$valor_sql['valor'].",";
					}
				}
				$campos="(".$campos.$dato_insertar.")";

				foreach ($this->array_datos_cuadro_chulitos_cargados as $llave => $valor)
				{
					if($valor['existe']==true and $valor['chuliado']==true and $valor['habilitado']==false)
					{
						if($valor['tabla']==$tabla_destino)
						{
							if($this->carga_distintivo==true)
							{
								$query="UPDATE $tabla_destino SET $llave_deshabilita='$valor_llave_habilita' WHERE ".$valor['campo']."="."'".$valor['valor']."'"." AND $this->llave_carga_distintiva=$this->valor_llave_carga_distintiva;";
							}
							else
							{
								$query="UPDATE $tabla_destino SET $llave_deshabilita='$valor_llave_habilita' WHERE ".$valor['campo']."="."'".$valor['valor']."'"." AND $this->llave_carga=$this->valor_llave_carga;";
							}
							$operacion=$this->conexion->query($query);
							//echo "<br>",$query,"<br>";
						}
					}
					elseif($valor['existe']==false and $valor['chuliado']==true)
					{
						if($valor['tabla']==$tabla_destino)
						{
							if($this->carga_distintivo==true)
							{
								$query="INSERT INTO $tabla_destino $campos VALUES (".$this->valor_llave_carga_distintiva."$valores'".$valor['valor']."')";
							}
							else
							{
								echo "<h1>*</h1>";
								echo $this->llave_carga;
								echo
								$query="INSERT INTO $tabla_destino $campos VALUES ("."$valores'".$valor['valor']."')";
							}
							echo "<br>",$query,"<br>";
							$operacion=$this->conexion->query($query);
						}
					}
					if ($valor['existe']==true and $valor['chuliado']==false)
					{
						if($valor['tabla']==$tabla_destino)
						{
							if($this->carga_distintivo==true)
							{
								$query="UPDATE $tabla_destino SET $llave_deshabilita=$valor_llave_deshabilita WHERE ".$valor['campo']."="."'".$valor['valor']."'"." AND $this->llave_carga_distintiva=$this->valor_llave_carga_distintiva;";
							}
							else
							{
								$query="UPDATE $tabla_destino SET $llave_deshabilita=$valor_llave_deshabilita WHERE ".$valor['campo']."="."'".$valor['valor']."'"." AND $this->llave_carga=$this->valor_llave_carga;";
							}
							$operacion=$this->conexion->query($query);
							//echo "<br>",$query,"<br>";
						}
					}
				}
				if($this->contador_llamada_sql_chulos==$cantidad_llamadas)
				{
					if($confirmacion==true)
					{
						echo "<script language='javascript'>alert('Datos actualizados correctamente')</script>";
					}
					if($accion_actualiza!="")
					{
						echo $accion_actualiza;
					}
				}
			}
		}
	}

	function agregar_tablas($tabla,$llave,$valorllave=NULL,$consultar=false)
	{
		$this->array_tablas[]=array('tabla'=>$tabla,'llave'=>$llave,'valorllave'=>$valorllave,'consultar'=>$consultar);
	}

	function datos_usuario()
	{
		$query="SELECT u.idusuario,concat(u.apellidos,' ',u.nombres) as nombre,u.codigorol,u.numerodocumento FROM usuario u WHERE u.usuario='".$_SESSION['MM_Username']."'";
		$operacion=$this->conexion->query($query);
		$row_usuario=$operacion->fetchRow();
		return $row_usuario;
	}

	function datos_directivo()
	{
		$usuario=$this->datos_usuario();
		$query_iddirectivo="select iddirectivo, concat(nombresdirectivo,apellidosdirectivo) as nombre from directivo where idusuario='".$usuario['idusuario']."'";
		$operacion=$this->conexion->query($query_iddirectivo);
		$row_operacion=$operacion->fetchRow();
		return $row_operacion;
	}

	function datos_carrera()
	{
		$query="SELECT c.codigocarrera,c.nombrecarrera FROM carrera c WHERE c.codigocarrera='".$_SESSION['codigofacultad']."'";
		$operacion=$this->conexion->query($query);
		$row_carrera=$operacion->fetchRow();
		return $row_carrera;
	}

	function datos_estudiante_noprematricula($codigoestudiante)
	{
		$query="
		SELECT e.codigoestudiante,
		c.nombrecarrera,
		e.codigocarrera,
		eg.numerodocumento,
		concat(eg.apellidosestudiantegeneral,' ',eg.nombresestudiantegeneral) as nombre,
		eg.direccionresidenciaestudiantegeneral as direccion,
		eg.direccioncorrespondenciaestudiantegeneral as direccion_correspondencia,
		eg.telefonoresidenciaestudiantegeneral as teléfono,
		eg.celularestudiantegeneral as celular,
		eg.emailestudiantegeneral as email,
		eg.email2estudiantegeneral as email2,
		ec.nombreestadocivil as estado_civil,
		eg.fechanacimientoestudiantegeneral as fecha_nacimiento,
		TIMESTAMPDIFF(YEAR,eg.fechanacimientoestudiantegeneral,CURDATE()) AS edad,
		g.nombregenero as genero,
		ciu.nombreciudad as ciudad_nacimiento,
		e.codigoperiodo as periodo_ingreso,
		j.nombrejornada as jornada,
		te.nombretipoestudiante as tipo_estudiante,
		sce.nombresituacioncarreraestudiante as situacion_carrera_estudiante
		FROM
		estudiante e, estudiantegeneral eg, carrera c, estadocivil ec, ciudad ciu, jornada j, tipoestudiante te, situacioncarreraestudiante sce, genero g
		WHERE
		e.idestudiantegeneral=eg.idestudiantegeneral
		AND eg.codigogenero=g.codigogenero
		AND e.codigocarrera=c.codigocarrera
		AND eg.idestadocivil=ec.idestadocivil
		AND eg.idciudadnacimiento=ciu.idciudad
		AND e.codigojornada=j.codigojornada
		AND e.codigotipoestudiante=te.codigotipoestudiante
		AND e.codigosituacioncarreraestudiante=sce.codigosituacioncarreraestudiante
		AND e.codigoestudiante='$codigoestudiante'
		";
		$operacion=$this->conexion->query($query);
		$row_operacion=$operacion->fetchRow();
		return $row_operacion;
	}

	function carga_periodo($codigoestadoperiodo)
	{
		$query="SELECT p.codigoperiodo FROM periodo p WHERE p.codigoestadoperiodo='$codigoestadoperiodo'";
		$operacion=$this->conexion->query($query);
		$row_carrera=$operacion->fetchRow();
		return $row_carrera['codigoperiodo'];
	}

	function carga_periodo_2_intentos($codigoestadoperiodo1,$codigoestadoperiodo2)
	{
		$query="SELECT p.codigoperiodo FROM periodo p WHERE p.codigoestadoperiodo='$codigoestadoperiodo1'";
		$operacion=$this->conexion->query($query);
		$row_carrera=$operacion->fetchRow();
		if ($row_carrera['codigoperiodo']=="")
		{
			$query="SELECT p.codigoperiodo FROM periodo p WHERE p.codigoestadoperiodo='$codigoestadoperiodo2'";
			$operacion=$this->conexion->query($query);
			$row_carrera=$operacion->fetchRow();
		}
		return $row_carrera['codigoperiodo'];
	}

	function insertarFilaBD($tabla,$fila)
	{

		$claves="(";
		$valores="(";
		$i=0;
		while (list ($clave, $val) = each ($fila)) {

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
		$operacion=$this->conexion->execute($sql);
		$id=$this->conexion->Insert_ID();
		return $id;

	}

	//Actualiza de una fila de datos del tipo $fila['clave']=valor en la tabla $tabla donde
	//las claves son los nombres de los campos y los valores son los valores de campo a actualizar
	//dependiendo del id de la tabla ingresado $idtabla
	function actualizarFilaBD($tabla,$arrayDatos,$llave,$valorLlave){
		$i=0;
		while (list ($clave, $val) = each ($arrayDatos)) {
			if($i>0){
				$claves .= ",".$clave."";
				$valores .= ",'".$val."'";
				$condiciones .= ",".$clave."='".$val."'";
			}
			else{
				@$claves .= "".$clave."";
				@$valores .= "'".$val."'";
				@$condiciones .= $clave."='".$val."'";
			}
			$i++;
		}

		$sql="update $tabla set $condiciones where $llave=$valorLlave";
		$operacion=$this->conexion->query($sql);
	}

	//Ingresa o actualiza un registro dependiendo de si se encuentran registros con el mismo id
	//o la misma condicion.
	function salvarBD($tabla,$arrayDatos,$llave,$valorLlave,$condicion="")
	{
		$sql="select * from $tabla where $llave='$valorLlave' $condicion";
		$operacion=$this->conexion->query($sql);
		$numrows=$operacion->numRows();
		if($numrows>0){
			$id=$this->actualizarFilaBD($tabla,$arrayDatos,$llave,$valorLlave);
		}
		else{
			$id=$this->insertarFilaBD($tabla,$arrayDatos);
		}
		return $id;
	}


	function insertarNoADO($accion_inserta="<script language='javascript'>window.location.href('menu.php')</script>",$accion_actualiza="<script language='javascript'>window.location.href('menu.php')</script>",$muestra_confirmacion=true)
	{
		foreach($this->array_tablas as $clave => $valor)
		{
			$arreglo=$this->recortar_arreglo($valor['tabla']);
			if(is_array($arreglo))
			{
				foreach ($arreglo as $llave => $valor_arreglo)
				{
					$arrayDatos[$valor_arreglo['campo']]=$valor_arreglo['valor'];
				}
				$id=$this->salvarBD($valor['tabla'],$arrayDatos,$valor['llave'],$valor['valorllave']);
			}

		}
		if(!is_array($this->array_datos_cuadro_chulitos))
		{
			if($muestra_confirmacion==true)
			{
				echo "<script language='javascript'>alert('Datos insertados correctamente')</script>";
			}
			if($accion_inserta!="")
			{
				echo $accion_inserta;
			}
		}
		return $id;
	}


	function insertar($accion_inserta="<script language='javascript'>window.location.href('menu.php')</script>",$accion_actualiza="<script language='javascript'>window.location.href('menu.php')</script>",$muestra_confirmacion=true)
	{
		if($this->validaciongeneral==true)
		{
			if($this->carga_distintivo==true)
			{
				//echo "<h1>?</h1>";
				foreach($this->array_tablas as $clave => $valor)
				{
					$arreglo=$this->recortar_arreglo($valor['tabla']);
					if(is_array($arreglo))
					{
						//$llave_anterior=$valor['llave'];
						$key=$clave-1;
						$llave_anterior=$this->array_tablas[$key]['llave'];
						$tabla_anterior=$this->array_tablas[$key]['tabla'];
						$valor_anterior=$this->array_datos_cargados[$tabla_anterior]->$llave_anterior;
						$this->array_datos_cargados[$valor['tabla']]->valor['campo']=$valor_arreglo['valor'];
						foreach ($arreglo as $llave => $valor_arreglo)
						{
							$this->array_datos_cargados[$valor['tabla']]->$valor_arreglo['campo']=$valor_arreglo['valor'];
							{
								$this->array_datos_cargados[$valor['tabla']]->llave_anterior=$valor_anterior;
							}
						}
					}
					//var_dump($this->array_datos_cargados[$valor['tabla']]);
					if($valor['consultar']==false)
					{
						$this->array_datos_cargados[$valor['tabla']]->save();
					}
					else
					{
						$this->array_datos_cargados[$valor['tabla']]->_saved=false;
						$this->array_datos_cargados[$valor['tabla']]->$valor['llave']=NULL;
						$this->array_datos_cargados[$valor['tabla']]->save();
					}
				}
				if(!is_array($this->array_datos_cuadro_chulitos))
				{
					if($muestra_confirmacion==true)
					{
						echo "<script language='javascript'>alert('Datos actualizados correctamente')</script>";
					}

					if($accion_actualiza!="")
					{
						echo $accion_actualiza;
					}
				}
			}
			elseif($this->carga==true)
			{
				foreach($this->array_tablas as $clave => $valor)
				{
					$arreglo=$this->recortar_arreglo($valor['tabla']);
					if(is_array($arreglo))
					{
						//$llave_anterior=$valor['llave'];
						$key=$clave-1;
						$llave_anterior=$this->array_tablas[$key]['llave'];
						$tabla_anterior=$this->array_tablas[$key]['tabla'];
						$valor_anterior=$this->array_datos_cargados[$tabla_anterior]->$llave_anterior;
						/*Se quito el $ a valor['campo'] por problemas de version PHP5*/
						$this->array_datos_cargados[$valor['tabla']]->valor['campo']=$valor_arreglo['valor'];
						foreach ($arreglo as $llave => $valor_arreglo)
						{
							$this->array_datos_cargados[$valor['tabla']]->$valor_arreglo['campo']=$valor_arreglo['valor'];
							{
                                                                /*se quito el $ a llave_anterior por problemas de version PHP5*/  
								$this->array_datos_cargados[$valor['tabla']]->llave_anterior=$valor_anterior;
							}
						}
					}
					//var_dump($this->array_datos_cargados[$valor['tabla']]);
					if($valor['consultar']==false)
					{
						$this->array_datos_cargados[$valor['tabla']]->save();
					}
					else
					{
						$this->array_datos_cargados[$valor['tabla']]->_saved=false;
						$this->array_datos_cargados[$valor['tabla']]->$valor['llave']=NULL;
						$this->array_datos_cargados[$valor['tabla']]->save();
					}
				}
				if(!is_array($this->array_datos_cuadro_chulitos))
				{
					if($muestra_confirmacion==true)
					{
						echo "<script language='javascript'>alert('Datos actualizados correctamente')</script>";
					}

					if($accion_actualiza!="")
					{
						echo $accion_actualiza;
					}
				}
			}
			else
			{
				$contador=0;
				foreach($this->array_tablas as $clave => $valor)
				{
					//echo "<h1>".$this->ultimoID."</h1>";
					$obj = new ADODB_Active_Record($valor['tabla'],array($valor['llave']));
					$arreglo=$this->recortar_arreglo($valor['tabla']);
					if(is_array($arreglo))
					{
						foreach ($arreglo as $llave => $valor_arreglo)
						{
							$obj->$valor_arreglo['campo']=$valor_arreglo['valor'];
						}
						if($clave>0)
						{
							$loc=$this->array_tablas[$clave-1]['llave'];
							$obj->$loc=$this->ultimoID;
						}
						$obj->Insert();
						$this->ultimoID=$this->LastInsertID($this->conexion,$valor['llave']);
						$this->array_ids[$contador]['tabla']=$valor['tabla'];
						$this->array_ids[$contador]['llave']=$valor['llave'];
						$this->array_ids[$contador]['ultimoid']=$this->ultimoID;
						unset($obj);
					}
					$contador++;
				}
				if(!is_array($this->array_datos_cuadro_chulitos))
				{
					if($muestra_confirmacion==true)
					{
						echo "<script language='javascript'>alert('Datos insertados correctamente')</script>";
					}
					if($accion_inserta!="")
					{
						echo $accion_inserta;
					}
				}
			}
		}
		return $this->array_ids;
	}

	function InsertarDatosFormularioenBD($accion_inserta="<script language='javascript'>window.location.href('menu.php')</script>",$accion_actualiza="<script language='javascript'>window.location.href('menu.php')</script>",$muestra_confirmacion=true)
	{
		if($this->validaciongeneral==true)
		{
			if($this->carga_distintivo==true)
			{
				//echo "<h1>?</h1>";
				foreach($this->array_tablas as $clave => $valor)
				{
					$arreglo=$this->recortar_arreglo($valor['tabla']);
					if(is_array($arreglo))
					{
						//$llave_anterior=$valor['llave'];
						$key=$clave-1;
						$llave_anterior=$this->array_tablas[$key]['llave'];
						$tabla_anterior=$this->array_tablas[$key]['tabla'];
						$valor_anterior=$this->array_datos_cargados[$tabla_anterior]->$llave_anterior;
						//depuracion
						//$this->array_datos_cargados[$valor['tabla']]->$valor['campo']=$valor_arreglo['valor'];
						foreach ($arreglo as $llave => $valor_arreglo)
						{
							$this->array_datos_cargados[$valor['tabla']]->$valor_arreglo['campo']=$valor_arreglo['valor'];
							{
								//depuracion
								//$this->array_datos_cargados[$valor['tabla']]->$llave_anterior=$valor_anterior;
							}
						}
					}
					//var_dump($this->array_datos_cargados[$valor['tabla']]);
					if($valor['consultar']==false)
					{
						$this->array_datos_cargados[$valor['tabla']]->save();
					}
					else
					{
						$this->array_datos_cargados[$valor['tabla']]->_saved=false;
						$this->array_datos_cargados[$valor['tabla']]->$valor['llave']=NULL;
						$this->array_datos_cargados[$valor['tabla']]->save();
					}
				}
				if(!is_array($this->array_datos_cuadro_chulitos))
				{
					if($muestra_confirmacion==true)
					{
						echo "<script language='javascript'>alert('Datos actualizados correctamente')</script>";
					}

					if($accion_actualiza!="")
					{
						echo $accion_actualiza;
					}
				}
			}
			elseif($this->carga==true)
			{
				foreach($this->array_tablas as $clave => $valor)
				{
					$arreglo=$this->recortar_arreglo($valor['tabla']);
					if(is_array($arreglo))
					{
						//$llave_anterior=$valor['llave'];
						$key=$clave-1;
						$llave_anterior=$this->array_tablas[$key]['llave'];
						$tabla_anterior=$this->array_tablas[$key]['tabla'];
						$valor_anterior=$this->array_datos_cargados[$tabla_anterior]->$llave_anterior;

						$this->array_datos_cargados[$valor['tabla']]->$valor['campo']=$valor_arreglo['valor'];
						foreach ($arreglo as $llave => $valor_arreglo)
						{
							$this->array_datos_cargados[$valor['tabla']]->$valor_arreglo['campo']=$valor_arreglo['valor'];
							{
								$this->array_datos_cargados[$valor['tabla']]->$llave_anterior=$valor_anterior;
							}
						}
					}
					//var_dump($this->array_datos_cargados[$valor['tabla']]);
					if($valor['consultar']==false)
					{
						$this->array_datos_cargados[$valor['tabla']]->save();
					}
					else
					{
						$this->array_datos_cargados[$valor['tabla']]->_saved=false;
						$this->array_datos_cargados[$valor['tabla']]->$valor['llave']=NULL;
						$this->array_datos_cargados[$valor['tabla']]->save();
					}
				}
				if(!is_array($this->array_datos_cuadro_chulitos))
				{
					if($muestra_confirmacion==true)
					{
						echo "<script language='javascript'>alert('Datos actualizados correctamente')</script>";
					}

					if($accion_actualiza!="")
					{
						echo $accion_actualiza;
					}
				}
			}
			else
			{
				$contador=0;
				foreach($this->array_tablas as $clave => $valor)
				{
					//echo "<h1>".$this->ultimoID."</h1>";
					$obj = new ADODB_Active_Record($valor['tabla'],array($valor['llave']));
					$arreglo=$this->recortar_arreglo($valor['tabla']);
					if(is_array($arreglo))
					{
						foreach ($arreglo as $llave => $valor_arreglo)
						{
							$obj->$valor_arreglo['campo']=$valor_arreglo['valor'];
						}
						if($clave>0)
						{
							$loc=$this->array_tablas[$clave-1]['llave'];
							$obj->$loc=$this->ultimoID;
						}
						$obj->Insert();
						$this->ultimoID=$this->LastInsertID($this->conexion,$valor['llave']);
						$this->array_ids[$contador]['tabla']=$valor['tabla'];
						$this->array_ids[$contador]['llave']=$valor['llave'];
						$this->array_ids[$contador]['ultimoid']=$this->ultimoID;
						unset($obj);
					}
					$contador++;
				}
				if(!is_array($this->array_datos_cuadro_chulitos))
				{
					if($muestra_confirmacion==true)
					{
						echo "<script language='javascript'>alert('Datos insertados correctamente')</script>";
					}
					if($accion_inserta!="")
					{
						echo $accion_inserta;
					}
				}
			}
		}
		return $this->array_ids;
	}


	/**
	 * Inserta, pero sin emitir confirmacion alguna
	 *
	 * @return unknown
	 */
	function InsertarNoConfirma()
	{
		if($this->validaciongeneral==true)
		{
			if($this->carga_distintivo==true)
			{
				//echo "<h1>?</h1>";
				foreach($this->array_tablas as $clave => $valor)
				{
					$arreglo=$this->recortar_arreglo($valor['tabla']);
					if(is_array($arreglo))
					{
						//$llave_anterior=$valor['llave'];
						$key=$clave-1;
						$llave_anterior=$this->array_tablas[$key]['llave'];
						$tabla_anterior=$this->array_tablas[$key]['tabla'];
						$valor_anterior=$this->array_datos_cargados[$tabla_anterior]->$llave_anterior;

						$this->array_datos_cargados[$valor['tabla']]->$valor['campo']=$valor_arreglo['valor'];
						foreach ($arreglo as $llave => $valor_arreglo)
						{
							$this->array_datos_cargados[$valor['tabla']]->$valor_arreglo['campo']=$valor_arreglo['valor'];
							{
								$this->array_datos_cargados[$valor['tabla']]->$llave_anterior=$valor_anterior;
							}
						}
					}
					//var_dump($this->array_datos_cargados[$valor['tabla']]);
					if($valor['consultar']==false)
					{
						$this->array_datos_cargados[$valor['tabla']]->save();
					}
					else
					{
						$this->array_datos_cargados[$valor['tabla']]->_saved=false;
						$this->array_datos_cargados[$valor['tabla']]->$valor['llave']=NULL;
						$this->array_datos_cargados[$valor['tabla']]->save();
					}
				}
				if(!is_array($this->array_datos_cuadro_chulitos))
				{
					if($muestra_confirmacion==true)
					{
						echo "<script language='javascript'>alert('Datos actualizados correctamente')</script>";
					}

					if($accion_actualiza!="")
					{
						echo $accion_actualiza;
					}
				}
			}
			elseif($this->carga==true)
			{
				foreach($this->array_tablas as $clave => $valor)
				{
					$arreglo=$this->recortar_arreglo($valor['tabla']);
					if(is_array($arreglo))
					{
						//$llave_anterior=$valor['llave'];
						$key=$clave-1;
						$llave_anterior=$this->array_tablas[$key]['llave'];
						$tabla_anterior=$this->array_tablas[$key]['tabla'];
						$valor_anterior=$this->array_datos_cargados[$tabla_anterior]->$llave_anterior;

						$this->array_datos_cargados[$valor['tabla']]->$valor['campo']=$valor_arreglo['valor'];
						foreach ($arreglo as $llave => $valor_arreglo)
						{
							$this->array_datos_cargados[$valor['tabla']]->$valor_arreglo['campo']=$valor_arreglo['valor'];
							{
								$this->array_datos_cargados[$valor['tabla']]->$llave_anterior=$valor_anterior;
							}
						}
					}
					//var_dump($this->array_datos_cargados[$valor['tabla']]);
					if($valor['consultar']==false)
					{
						$this->array_datos_cargados[$valor['tabla']]->save();
					}
					else
					{
						$this->array_datos_cargados[$valor['tabla']]->_saved=false;
						$this->array_datos_cargados[$valor['tabla']]->$valor['llave']=NULL;
						$this->array_datos_cargados[$valor['tabla']]->save();
					}
				}
				if(!is_array($this->array_datos_cuadro_chulitos))
				{
					if($muestra_confirmacion==true)
					{
						echo "<script language='javascript'>alert('Datos actualizados correctamente')</script>";
					}

					if($accion_actualiza!="")
					{
						echo $accion_actualiza;
					}
				}
			}
			else
			{
				$contador=0;
				foreach($this->array_tablas as $clave => $valor)
				{
					//echo "<h1>".$this->ultimoID."</h1>";
					$obj = new ADODB_Active_Record($valor['tabla'],array($valor['llave']));
					$arreglo=$this->recortar_arreglo($valor['tabla']);
					if(is_array($arreglo))
					{
						foreach ($arreglo as $llave => $valor_arreglo)
						{
							$obj->$valor_arreglo['campo']=$valor_arreglo['valor'];
						}
						if($clave>0)
						{
							$loc=$this->array_tablas[$clave-1]['llave'];
							$obj->$loc=$this->ultimoID;
						}
						$obj->Insert();
						$this->ultimoID=$this->LastInsertID($this->conexion,$valor['llave']);
						$this->array_ids[$contador]['tabla']=$valor['tabla'];
						$this->array_ids[$contador]['llave']=$valor['llave'];
						$this->array_ids[$contador]['ultimoid']=$this->ultimoID;
						unset($obj);
					}
					$contador++;
				}
				if(!is_array($this->array_datos_cuadro_chulitos))
				{
					if($muestra_confirmacion==true)
					{
						echo "<script language='javascript'>alert('Datos insertados correctamente')</script>";
					}
					if($accion_inserta!="")
					{
						echo $accion_inserta;
					}
				}
			}
		}
		return $this->array_ids;
	}
	/**
 * Inserta objeto en la bd, pero sin emitir confirmación alguna
 *
 * @param unknown_type $objeto
 */
	function InsertarDistintivoNoConfirma($objeto)
	{
		$arreglo=$this->recortar_arreglo($objeto);
		if (is_array($arreglo))
		{
			foreach ($arreglo as $llave => $valor_arreglo)
			{
				$this->array_datos_cargados[$objeto]->$valor_arreglo['campo']=$valor_arreglo['valor'];
			}
		}

		$inserta=$this->array_datos_cargados[$objeto]->insert();
	}

	/**
	 * Salva el objeto en la bd, es decir, cuando ya existe, lo actualiza, no inserta uno nuevo. No emite confirmacion
	 *
	 * @param unknown_type $objeto
	 */
	function SalvarDistintivoNoConfirma($objeto)
	{
		$arreglo=$this->recortar_arreglo($objeto);
		if (is_array($arreglo))
		{
			foreach ($arreglo as $llave => $valor_arreglo)
			{
				$this->array_datos_cargados[$objeto]->$valor_arreglo['campo']=$valor_arreglo['valor'];
			}
		}

		$inserta=$this->array_datos_cargados[$objeto]->save();
	}
	function cargar($llavecarga="",$valorllave)
	{
		$this->valor_llave_carga=$valorllave;
		$this->llave_carga=$llavecarga;
		foreach($this->array_tablas as $clave => $valor)
		{
			$this->array_datos_cargados[$valor['tabla']] = new ADODB_Active_Record($valor['tabla'],array($valor['llave']));
			if($llavecarga<>"")
			{

			}
			$this->carga=$this->array_datos_cargados[$valor['tabla']]->Load("".$valor['llave']."='$valorllave'");
			//var_dump($test);
			if($clave>0)
			{
				$llaveant=$this->array_tablas[$clave-1]['llave'];
				$this->carga=$this->array_datos_cargados[$valor['tabla']]->Load("".$llaveant."='$valorllave'");
			}
		}
		return $this->carga;
	}

	function cargar_condicional($llavecarga="",$valorllave,$condicion)
	{
		$this->valor_llave_carga=$valorllave;
		$this->llave_carga=$llavecarga;
		foreach($this->array_tablas as $clave => $valor)
		{
			$this->array_datos_cargados[$valor['tabla']] = new ADODB_Active_Record($valor['tabla'],array($valor['llave']));
			if($llavecarga<>"")
			{

			}
			$this->carga=$this->array_datos_cargados[$valor['tabla']]->Load("".$valor['llave']."=$valorllave and $condicion");
			//var_dump($test);
			if($clave>0)
			{
				$llaveant=$this->array_tablas[$clave-1]['llave'];
				$this->carga=$this->array_datos_cargados[$valor['tabla']]->Load("".$llaveant."=$valorllave");
			}
		}
		return $this->carga;
	}


	function cargar_distintivo($tabla,$llave,$valorllave,$llave_carga_distintiva="",$valor_llave_carga_distintiva="")
	{
		$this->llave_carga=$llave;
		$this->valor_llave_carga=$valorllave;
		if($llave_carga_distintiva!="" and $valor_llave_carga_distintiva!="")
		{
			$this->llave_carga_distintiva=$llave_carga_distintiva;
			$this->valor_llave_carga_distintiva=$valor_llave_carga_distintiva;
		}
		$this->trazaTabla_carga=$tabla;
		$this->array_datos_cargados[$tabla] = new ADODB_Active_Record($tabla,array($llave));
		$this->carga_distintivo=$this->array_datos_cargados[$tabla]->Load("".$llave."=".$valorllave."");
		return $this->carga_distintivo;
	}

	/**
	 * Carga distintivo instanciando el objeto, pero no le dice que cargue datos.
	 *
	 * @param unknown_type $tabla
	 * @param unknown_type $llave
	 * @param unknown_type $valorllave
	 * @param unknown_type $llave_carga_distintiva
	 * @param unknown_type $valor_llave_carga_distintiva
	 * @return unknown
	 */
	function cargar_distintivo_nocarga($tabla,$llave,$valorllave,$llave_carga_distintiva="",$valor_llave_carga_distintiva="")
	{
		$this->llave_carga=$llave;
		$this->valor_llave_carga=$valorllave;
		if($llave_carga_distintiva!="" and $valor_llave_carga_distintiva!="")
		{
			$this->llave_carga_distintiva=$llave_carga_distintiva;
			$this->valor_llave_carga_distintiva=$valor_llave_carga_distintiva;
		}
		$this->trazaTabla_carga=$tabla;
		$this->array_datos_cargados[$tabla] = new ADODB_Active_Record($tabla,array($llave));
		$this->carga_distintivo=true;
		return true;
	}

	function cargar_distintivo_condicional($tabla,$llave,$valorllave,$condicion,$llave_carga_distintiva="",$valor_llave_carga_distintiva="")
	{
		$this->llave_carga=$llave;
		$this->valor_llave_carga=$valorllave;
		if($llave_carga_distintiva!="" and $valor_llave_carga_distintiva!="")
		{
			$this->llave_carga_distintiva=$llave_carga_distintiva;
			$this->valor_llave_carga_distintiva=$valor_llave_carga_distintiva;
		}
		$this->trazaTabla_carga=$tabla;
		$this->array_datos_cargados[$tabla] = new ADODB_Active_Record($tabla,array($llave));
		$this->carga_distintivo=$this->array_datos_cargados[$tabla]->Load("".$llave."=".$valorllave." AND ".$condicion);
		return $this->carga_distintivo;
	}

	function cargar_distintivo_condicional_true($tabla,$llave,$valorllave,$condicion,$llave_carga_distintiva="",$valor_llave_carga_distintiva="")
	{
		$this->llave_carga=$llave;
		$this->valor_llave_carga=$valorllave;
		if($llave_carga_distintiva!="" and $valor_llave_carga_distintiva!="")
		{
			$this->llave_carga_distintiva=$llave_carga_distintiva;
			$this->valor_llave_carga_distintiva=$valor_llave_carga_distintiva;
		}
		$this->trazaTabla_carga=$tabla;
		$this->array_datos_cargados[$tabla] = new ADODB_Active_Record($tabla,array($llave));
		$this->carga_distintivo=$this->array_datos_cargados[$tabla]->Load("".$llave."=".$valorllave." AND ".$condicion);
		$this->carga_distintivo=true;
		return $this->carga_distintivo;
	}

	function limites_flechas_tabla_padre_hijo($tabla_maestro,$tabla_detalle,$llave_compartida,$llave_detalle,$valor_llave_compartida,$and="")
	{
		if($and=="")
		{
			$query="SELECT ($tabla_detalle.$llave_detalle) as id
			FROM
			$tabla_maestro,$tabla_detalle
			WHERE
			$tabla_maestro.$llave_compartida=$tabla_detalle.$llave_compartida
			AND $tabla_maestro.$llave_compartida=$valor_llave_compartida
			";
		}
		else
		{
			$query="SELECT ($tabla_detalle.$llave_detalle) as id
			FROM
			$tabla_maestro,$tabla_detalle
			WHERE
			$tabla_maestro.$llave_compartida=$tabla_detalle.$llave_compartida
			AND $tabla_maestro.$llave_compartida=$valor_llave_compartida
			AND $and";
		}
		//echo $query,"<br>";
		$operacion=$this->conexion->query($query);
		$row_operacion=$operacion->fetchRow();
		do
		{
			$array_interno[]=array('tabla_maestro'=>$tabla_maestro,'tabla_detalle'=>$tabla_detalle,'llave_compartida'=>$llave_compartida,'llave_detalle'=>$llave_detalle,'valor_llave_compartida'=>$valor_llave_compartida,'id_desplazamiento'=>$row_operacion['id']*1);
		}
		while ($row_operacion=$operacion->fetchRow());
		//$this->array_tabla_padre_hijo=$array_interno;
		$_SESSION['array_flechas_tabla_padre_hijo']=$array_interno;
		$this->array_datos_iterar=$array_interno;
		$this->array_flechas=array('llave_maestro'=>$llave_compartida,'valor_llave_maestro'=>$valor_llave_compartida,'llave_detalle'=>$llave_detalle);
		//var_dump($array_interno);
		//return $array_interno;
	}

	function mostrar_flechas_tabla_padre_hijo($enlace_nuevo=true)
	{
		$conteo_max_flechas=count($this->array_datos_iterar)-1;
		if(isset($_GET['link_origen']))
		{
			$link_origen=$_GET['link_origen'];
		}
		if($_SESSION['puntero_flechas'] < $conteo_max_flechas)
		{
			$final=">>";
			$adelante=">";
			$mostrar_enlace=true;
		}
		else
		{
			$final=" ";
			$adelante=" ";
			$mostrar_enlace=false;
		}
		if($_SESSION['puntero_flechas'] > 0)
		{
			$comienzo="<<";
			$atras="<";
			$mostrar_enlace=true;
		}
		else
		{
			$comienzo=" ";
			$atras=" ";
			$mostrar_enlace=false;
		}

		if($nuevo=true)
		{
			$nuevo="NUEVO";
		}

		$comienzo_href='<a href="'.$this->archivo_form.'';
		$complemento_href='&'.$this->array_flechas['llave_maestro'].'='.$this->array_flechas['valor_llave_maestro'].'&'.$this->array_flechas['llave_detalle'].'='.$_SESSION['contador_flechas'].'&link_origen='.$link_origen.'">';
		$fin_href='</a>';

		if($this->carga_distintivo==false)
		{
			$contador=0;
			$conteo_max=0;
		}
		else
		{
			if(!isset($_GET['nuevo']))
			{
				$contador=$_SESSION['puntero_flechas']+1;
				$conteo_max=count($this->array_datos_iterar);
			}
			else
			{
				$contador=0;
				$conteo_max=0;
			}
		}
		echo '<table border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9">
		<tr>
			<td colspan="5" id="tdtitulogris">Registro '.$contador.' de '.$conteo_max.'</td>
		</tr>
		<tr>
			<td id="tdtitulogris">'.$comienzo_href.'?comienzo'.$complemento_href.$comienzo.$fin_href.'</td>
			<td id="tdtitulogris">'.$comienzo_href.'?atras'.$complemento_href.$atras.$fin_href.'</td>
			<td id="tdtitulogris">'.$comienzo_href.'?siguiente'.$complemento_href.$adelante.$fin_href.'</td>
			<td id="tdtitulogris">'.$comienzo_href.'?final'.$complemento_href.$final.$fin_href.'</td>
			<td id="tdtitulogris">'.$comienzo_href.'?nuevo'.$complemento_href.$nuevo.$fin_href.'</td>
		</tr>
		</table>';
	}

	function resetear_objeto_para_asignar_nuevo_flechas($objeto)//cuando se coloca boton nuevo en las flechas
	{
		unset($this->array_datos_cargados[$objeto]);
		$this->array_datos_cargados[$objeto]= new ADODB_Active_Record($objeto);
	}

	/**
	 * Esta función anula lo que le mande, con botón ANULAR de manera automatica
	 *
	 */
	function cambiar_estado($objeto,$llave_estado,$valor_llave_desactiva,$accion_anula)
	{
		if($_REQUEST['AnularOK']=="OK")
		{
			$this->array_datos_cargados[$objeto]->$llave_estado=$valor_llave_desactiva;
			$this->array_datos_cargados[$objeto]->save();
			echo "<script language='javascript'>alert('Registro anulado correctamente')</script>";
			echo $accion_anula;
		}
	}

	function anular($objeto,$llave_estado,$valor_llave_desactiva,$accion_anula)
	{
		if($_REQUEST['Anular'])
		{
			$this->array_datos_cargados[$objeto]->$llave_estado=$valor_llave_desactiva;
			$this->array_datos_cargados[$objeto]->save();
			echo "<script language='javascript'>alert('Registro anulado correctamente')</script>";
			echo $accion_anula;
		}
	}

	function iterar_flechas_tabla_padre_hijo()
	{
		$limite_puntero_flechas=count($_SESSION['array_flechas_tabla_padre_hijo'])-1;
		if(!isset($_GET['siguiente']) and !isset($_GET['atras']) and !isset($_GET['comienzo']) and !isset($_GET['final']) and !isset($_GET['nuevo']))
		{
			$_SESSION['puntero_flechas']=$limite_puntero_flechas;
		}
		else
		{
			if(isset($_GET['siguiente']))
			{
				if($_SESSION['puntero_flechas']<$limite_puntero_flechas)
				{
					$_SESSION['puntero_flechas']++;
				}
			}
			if(isset($_GET['atras']))
			{
				if($_SESSION['puntero_flechas']>0)
				{
					$_SESSION['puntero_flechas']--;
				}
			}
			if(isset($_GET['comienzo']))
			{
				$_SESSION['puntero_flechas']=0;
			}

			if(isset($_GET['final']))
			{
				$_SESSION['puntero_flechas']=$limite_puntero_flechas;
			}
		}
		$_SESSION['contador_flechas']=$_SESSION['array_flechas_tabla_padre_hijo'][$_SESSION['puntero_flechas']]['id_desplazamiento'];
	}

	function eliminar($accion_elimina="<script language='javascript'>window.location.href('menu.php')</script>")
	{
		for ($i = count($this->array_tablas)-1; $i >= 0; $i--)
		{
			$llave_eliminar=$this->array_tablas[$i]['llave'];
			$tabla_eliminar=$this->array_tablas[$i]['tabla'];
			$valor_llave_eliminar=$this->array_datos_cargados[$tabla_eliminar]->$llave_eliminar;
			$delete="DELETE FROM $tabla_eliminar ";
			$where="WHERE $llave_eliminar = $valor_llave_eliminar";
			$query_elimina=$delete.$where;
			//echo $query_elimina,"<br>";
			$elimina=$this->conexion->query($query_elimina);

		}
		echo "<script language='javascript'>alert('Datos eliminados correctamente')</script>";
		echo $accion_elimina;
	}

	/**
	 * Determina que campos son de cada tabla del formulario, recorriendo todo el array de datos del formulario
	 *
	 * @param unknown_type $tabla
	 * @return unknown
	 */
	function recortar_arreglo($tabla)
	{
		foreach($this->array_datos_formulario as $llave => $valor)
		{
			if($tabla==$valor['tabla'])
			{
				$array_resultado[]=$this->array_datos_formulario[$llave];
			}
		}
		return $array_resultado;
	}

	function etiqueta($nombre,$etiqueta,$validacion)
	{
		if($this->automatico==true)
		{
			$td="<td nowrap id='tdtitulogris'>";
			$td_fin="</td>\n";
		}

		echo $td,$etiqueta;
		if($validacion!="")
		{
			if($this->metodo=='get' or $this->metodo=='GET')
			{
				$this->array_validacion[]=array('campo'=>$nombre,'valido'=>$this->validacion($_GET[$nombre],$validacion),'mensaje'=>$etiqueta,'tipo'=>$validacion);
			}
			elseif ($this->metodo=='post' or $this->metodo=='POST')
			{
				$this->array_validacion[]=array('campo'=>$nombre,'valido'=>$this->validacion($_POST[$nombre],$validacion),'mensaje'=>$etiqueta,'tipo'=>$validacion);
			}
		}
		echo $td_fin;
	}

	function asterisco($nombre)
	{
		if($this->metodo=='post' or $this->metodo=='POST')
		{
			if($_POST[$nombre]=="")
			{
				echo "<label id='labelresaltado'>*</label>";
			}
		}
		elseif ($this->metodo=='get' or $this->metodo=='GET')
		{
			if($_GET[$nombre]=="")
			{
				echo "<label id='labelresaltado'>*</label>";
			}
		}
	}

	function validacion($nombrevar,$validacion)
	{
		$valido=1;
		//if(isset($nombrevar)){
		switch ($validacion)
		{
			case "requerido":
				if($nombrevar == '')
				{
					$valido = 0;
				}
				break;
			case "hora":
				if(!ereg("^([1]{1}[0-9]{1}|[2]{1}[0-3]{1}|[0]{0,1}[0-9]{1}):[0-5]{1}[0-9]{1}$",$nombrevar))
				{
					$valido = 0;
				}
				break;
			case "numero":
				if($nombrevar == '')
				{
					$valido = 0;
				}
				elseif(!ereg("^[0-9]{0,20}$",$nombrevar))
				{
					$valido = 0;
				}
				break;

			case "porcentaje":
				if(!ereg("^[0-9]{0,20}$",$nombrevar) or $nombrevar== '')
				{
					$valido = 0;
				}
				elseif($nombrevar < 0 || $nombrevar > 100)
				{
					$valido = 0;
				}
				break;
			case "letras":
				if($nombrevar == '')
				{
					$valido = 0;
				}
				elseif(!ereg("^[a-zA-ZáéíóúüñÁÉÍÓÚÑÜ]*$",$nombrevar))
				{
					$valido = 0;
				}
				break;
			case "email":
				$patron = "^[A-z0-9\._-]+"
				."@"
				."[A-z0-9][A-z0-9-]*"
				."(\.[A-z0-9_-]+)*"
				."\.([A-z]{2,6})$";
				if($nombrevar == '')
				{
					$valido = 0;
				}
				elseif(!ereg($patron,$nombrevar))
				{
					$valido = 0;
				}
				break;
			case "email_norequerido":
				$patron = "^[A-z0-9\._-]+"
				."@"
				."[A-z0-9][A-z0-9-]*"
				."(\.[A-z0-9_-]+)*"
				."\.([A-z]{2,6})$";
				if($nombrevar == '')
				{
					$valido = 1;
				}
				elseif(!ereg($patron,$nombrevar))
				{
					$valido = 0;
				}
				break;
			case "nombre":
				if($nombrevar == '')
				{
					$valido = 0;
				}
				elseif(!ereg("^([a-zA-ZáéíóúüñÁÉÍÓÚÑÜ]+([A-Za-záéíóúüñÁÉÍÓÚÑÜ]*|( [A-Za-záéíóúüñÁÉÍÓÚÑÜ]+)*))*$",$nombrevar))
				{
					$valido = 0;
				}
				break;
			case "combo":
				if($nombrevar == "0")
				{
					$valido = 0;
				}
				break;
			case "fecha":
				// Para fechas >= a 2000
				//$regs = array();
				if($nombrevar == '')
				{
					$valido = 0;
				}
				elseif(!ereg("^([0-9]{4})-([1-9]{1}|0[1-9]{1}|1[0-2]{1})-([1-9]{1}|[0-2]{1}[1-9]{1}|3[0-1]{1}|10|20)$", $nombrevar, $regs))
				{
					$valido = 0;
				}
				if(!checkdate($regs[2],$regs[3],$regs[1]))
				{
					$valido = 0;
				}
				break;
			case "decimal":
				if (!is_float($nombrevar))
				{
					$valido=0;
				}
				break;
			case "fecha60": //fechas no mayores a 60 dias
			$fechahoy=date("Y-n-j");
			$fechasinformato=strtotime("+60 day",strtotime($fechahoy));
			$fecha60=date("Y-n-j",$fechasinformato);
			$fechasinformato2=strtotime("-60 day",strtotime($fechahoy));
			$fechamenos60=date("Y-n-j",$fechasinformato2);
			//echo $nombrevar,$fechamenos60,fecha60;
			if($nombrevar == '')
			{
				$valido = 0;
			}
			elseif($nombrevar < $fechamenos60)
			{
				$valido = 0;
			}
			if ($nombrevar > $fecha60)
			{
				$valido = 0;
			}
			break;


			case "fechaant":
				// Para fechas < a 2000
				//$regs = array();
				if($nombrevar == '')
				{
					$valido = 0;
				}
				elseif(!ereg("^(1[0-9]{3})-([1-9]{1}|0[1-9]{1}|1[0-2]{1})-([1-9]{1}|[0-2]{1}[1-9]{1}|3[0-1]{1}|10|20)$", $nombrevar, $regs))
				{
					$valido = 0;
				}
				elseif(!checkdate($regs[2],$regs[3],$regs[1]))
				{
					$valido = 0;
				}
				break;
		}

		if($valido==0)
		{
			echo "<label id='labelresaltado'>*</label>";
		}
		return $valido;
	}

	function depurar()
	{
		$this->javaScriptDepurar();
		if(is_array($this->array_datos_cargados))
		{
			$this->trace($this->array_datos_cargados,'','Datos cargados:');
		}
		if(is_array($_SESSION['array_flechas_tabla_padre_hijo']))
		{
			$this->trace($_SESSION['array_flechas_tabla_padre_hijo'],'','Array flechas_padre_hijo');
		}
		if(isset($_SESSION['contador_flechas']))
		{
			$this->trace($_SESSION['contador_flechas'],'','Contador flechas');
		}
		if(is_array($this->array_tabla_padre_hijo))
		{
			$this->trace($this->array_tabla_padre_hijo,'','Array tabla_padre_hijo');
		}
		if(is_array($_SESSION))
		{
			$this->trace($_SESSION,'','Sesión');
		}
		if(is_array($_GET))
		{
			$this->trace($_GET,'','GET');
		}
		if(is_array($_POST))
		{
			$this->trace($_POST,'','POST');
		}
		if(isset($this->conexion))
		{
			$this->trace($this->conexion,'','Objeto ADO');
		}
		if(is_array($this->ArrayAtributosTabla))
		{
			$this->trace($this->ArrayAtributosTabla,'','Atributos tabla');
		}
		if(is_array($this->InfoObjetoTabla))
		{
			$this->trace($this->InfoObjetoTabla,"",'Objeto');
		}
		if(is_array($this->array_tablas))
		{
			$this->trazaTabla($this->array_tablas,'Tablas a instanciar');
		}
		if(is_array($this->array_tablas))
		{
			$this->trazaTabla($this->array_tablas,'Tablas a instanciar');
		}
		if(is_array($this->array_datos_formulario))
		{
			$this->trazaTabla($this->array_datos_formulario,'Datos de formulario');
		}
		if(is_array($this->array_validacion))
		{
			$this->trazaTabla($this->array_validacion,'Datos de validación');
		}
		if(is_array($this->array_datos_cuadro_chulitos))
		{
			$this->trazaTabla($this->array_datos_cuadro_chulitos,'Datos Chulitos Submitidos');
		}
		if(is_array($this->array_datos_cuadro_chulitos_cargados))
		{
			$this->trazaTabla($this->array_datos_cuadro_chulitos_cargados,'Datos Chulitos Cargados');
		}
		if(is_array($this->arrayTablasBD))
		{
			$this->trazaTabla($this->arrayTablasBD,"Array_Tablas_BD");
		}
		if(is_array($this->array_carga_archivo))
		{
			$this->trazaTabla($this->array_carga_archivo,"Array datos cargados de archivo");
		}
		if(is_array($this->array_ids))
		{
			$this->trazaTabla($this->array_ids,'ID´s insertados');
		}

	}

	function valida_formulario()
	{
		$mensajes="";
		if(is_array($this->array_validacion))
		{
			foreach ($this->array_validacion as $llave => $valor)
			{
				if($valor['valido']=='0')
				{
					if($valor['tipo']=='requerido')
					{
						$mensajes=$mensajes.$valor['mensaje'].', es '.$valor['tipo'].'\n';
					}
					else
					{
						$mensajes=$mensajes.$valor['mensaje'].', debe ser del tipo '.$valor['tipo'].'\n';
					}
					$this->validaciongeneral=false;
				}
			}
		}

		if($this->validaciongeneral==false)
		{
			echo "<script language='javascript'>alert('$this->mensajegeneral$mensajes');</script>";
			return false;
		}
		else
		{
			return true;
		}
	}

	function conecta_sap()
	{
		$query_estadoconexionexterna = "select e.codigoestadoconexionexterna, e.nombreestadoconexionexterna, e.codigoestado,
		e.hostestadoconexionexterna, e.numerosistemaestadoconexionexterna, e.mandanteestadoconexionexterna,
		e.usuarioestadoconexionexterna, e.passwordestadoconexionexterna
		from estadoconexionexterna e
		where e.codigoestado like '1%'";
		//and dop.codigoconcepto = '151'
		//echo "sdas $query_ordenes<br>";
		$estadoconexionexterna = $this->conexion->query($query_estadoconexionexterna);
		$row_estadoconexionexterna = $estadoconexionexterna->fetchRow($estadoconexionexterna);
		if(ereg("^1.+$",$row_estadoconexionexterna['codigoestadoconexionexterna']))
		{
			$login = array (                              // Set login data to R/3
			"ASHOST"=>$row_estadoconexionexterna['hostestadoconexionexterna'],           	// application server host name
			"SYSNR"=>$row_estadoconexionexterna['numerosistemaestadoconexionexterna'],      // system number
			"CLIENT"=>$row_estadoconexionexterna['mandanteestadoconexionexterna'],          // client
			"USER"=>$row_estadoconexionexterna['usuarioestadoconexionexterna'],             // user
			"PASSWD"=>$row_estadoconexionexterna['passwordestadoconexionexterna'],			// password
			"CODEPAGE"=>"1100");              												// codepage

			$rfc = saprfc_open($login);
			if(!$rfc)
			{
				echo "<script language='javascript'>alert('Fall? conexión a SAP')</script>";
				// We have failed to connect to the SAP server
				//echo "<br><br>Failed to connect to the SAP server".saprfc_error();
				//exit(1);
			}
		}
		return $rfc;
	}

	function globo($mensaje)
	{
		$globo=" onMouseover='showtip2(this,event,".'"'.$mensaje.'"'.")' onMouseout='hidetip2()'";
		return $globo;
	}

	function script_globo()
	{
		echo '<div id="tooltip2" style="position:absolute;visibility:hidden;clip:rect(0 150 50 0);width:150px;background-color:lightyellow"><layer name="nstip" width=1000px bgColor="lightyellow"></layer></div>';
		echo "\n";
	}

	function escribir_cabeceras($matriz)
	{
		echo "<tr>\n";
		while($elemento = each($matriz))
		{
			echo "<td>$elemento[0]</a></td>\n";
		}
		echo "</tr>\n";
	}

	function tabla($matriz,$texto="")
	{
		echo "<table border=1 cellpadding='2' cellspacing='1' align=center>\n";
		echo "<caption align=TOP>$texto</caption>";
		$this->escribir_cabeceras($matriz[0],$link);
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

	function tomar_ip()
	{
		if( $_SERVER['HTTP_X_FORWARDED_FOR'] != '' )
		{
			$client_ip =
			( !empty($_SERVER['REMOTE_ADDR']) ) ?
			$_SERVER['REMOTE_ADDR']
			:
			( ( !empty($_ENV['REMOTE_ADDR']) ) ?
			$_ENV['REMOTE_ADDR']
			:
			"unknown" );

			// los proxys van añadiendo al final de esta cabecera
			// las direcciones ip que van "ocultando". Para localizar la ip real
			// del usuario se comienza a mirar por el principio hasta encontrar
			// una dirección ip que no sea del rango privado. En caso de no
			// encontrarse ninguna se toma como valor el REMOTE_ADDR

			$entries = split('[, ]', $_SERVER['HTTP_X_FORWARDED_FOR']);

			reset($entries);
			while (list(, $entry) = each($entries))
			{
				$entry = trim($entry);
				if ( preg_match("/^([0-9]+.[0-9]+.[0-9]+.[0-9]+)/", $entry, $ip_list) )
				{
					// http://www.faqs.org/rfcs/rfc1918.html
					$private_ip = array(
					'/^0./',
					'/^127.0.0.1/',
					'/^192.168..*/',
					'/^172.((1[6-9])|(2[0-9])|(3[0-1]))..*/',
					'/^10..*/');

					$found_ip = preg_replace($private_ip, $client_ip, $ip_list[1]);

					if ($client_ip != $found_ip)
					{
						$client_ip = $found_ip;
						break;
					}
				}
			}
		}
		else
		{
			$client_ip =
			( !empty($_SERVER['REMOTE_ADDR']) ) ?
			$_SERVER['REMOTE_ADDR']
			:
			( ( !empty($_ENV['REMOTE_ADDR']) ) ?
			$_ENV['REMOTE_ADDR']
			:
			"unknown" );
		}
		return $client_ip;
	}

	function GetIP()
	{
		if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"),"unknown"))
		$ip = getenv("HTTP_CLIENT_IP");
		else if (getenv("HTTP_X_FORWARDED_FOR ") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR "), "unknown"))
		$ip = getenv("HTTP_X_FORWARDED_FOR ");
		else if (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown"))
		$ip = getenv("REMOTE_ADDR");
		else if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown"))
		$ip = $_SERVER['REMOTE_ADDR'];
		else
		$ip = "unknown";

		return($ip);
	}

	// Esta es la que creo se encuentra mejor
	function tomarip()
	{
		if(preg_match('/^(\d{1,3}\.){3}\d{1,3}$/s', $_SERVER["HTTP_CLIENT_IP"]))
		{
			$ip = $_SERVER["HTTP_CLIENT_IP"];
		}
		else
		{
			if(preg_match('/^(\d{1,3}\.){3}\d{1,3}$/s', $_SERVER["HTTP_X_FORWARDED_FOR"]))
			{
				$ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
			}
			else
			{
				if(preg_match('/^(\d{1,3}\.){3}\d{1,3}$/s', $_SERVER["REMOTE_HOST"]))
				{
					$ip = $_SERVER["REMOTE_HOST"];
				}
				else
				{
					$ip = $_SERVER["REMOTE_ADDR"];
				}
			}
		}
		return $ip;
	}

	function InstanciarObjeto($Tabla)
	{
		$this->ObjetoTabla= new ADODB_Active_Record($Tabla);
	}

	function ObtenerAtributosTabla()
	{
		$Atributos=$this->ObjetoTabla->GetAttributeNames();
		if($this->debug==true)
		{
			echo "<h1>Atributos:<br></h1>";
			print_r($Atributos);
		}
		return $Atributos;
	}

	function ObtenerInfoObjetoTabla()
	{
		$InfoObjeto=$this->ObjetoTabla->TableInfo();
		return $InfoObjeto;
	}

	function ObtenerLLaveObjetoTabla()
	{
		$Atributos=$this->ObjetoTabla->GetAttributeNames();
		$InfoObjeto=$this->ObjetoTabla->TableInfo();
		$Llave=array_keys($InfoObjeto->keys);
		if($this->debug==true)
		{
			echo "<h1>Llaves:<br></h1>";
			print_r($Llave);
		}
		return $Llave;
	}

	function ObtenerNombresTablasBD()
	{
		$Query="SHOW TABLES";
		$Operacion=$this->conexion->query($Query);
		$RowOperacion=$Operacion->fetchRow();
		do
		{
			$ArrayInterno[]=$RowOperacion;
		}
		while($RowOperacion=$Operacion->fetchRow());

		if($this->debug==true)
		{

		}
		$this->arrayTablasBD=$ArrayInterno;
		return $ArrayInterno;
	}

	function buscarCoincidenciasTablaMaestroDetalle($tabla)
	{
		foreach ($this->arrayTablasBD as $llave => $valor)
		{
			if (ereg("^detalle".$tabla."$",$valor['Tables_in_sala']))
			{
				$array_tablas_maestrodetalle=array('tabla_consultar'=>$tabla,'tabla_detalle'=>$valor['Tables_in_sala']);
			}
		}
		return $array_tablas_maestrodetalle;
	}

	function buscarCoincidenciasTablaMaestroDetalleBD()
	{
		foreach ($this->arrayTablasBD as $llave => $valor)
		{
			if(is_array($this->buscarCoincidenciasTablaMaestroDetalle($valor['Tables_in_sala'])))
			{
				$array_tablas_maestro_detalle_bd[]=$this->buscarCoincidenciasTablaMaestroDetalle($valor['Tables_in_sala']);
			}
		}
		if($this->debug==true)
		{
			$this->trazaTabla($array_tablas_maestro_detalle_bd,"Array de tablas maestro detalle");
		}
		return $array_tablas_maestro_detalle_bd;
	}

	function BuscarCoincidenciasTabla($Tabla)
	{
		$this->InstanciarObjeto($Tabla);
		$this->InfoObjetoTabla=$this->ObtenerInfoObjetoTabla();
		$this->ArrayAtributosTabla=$this->ObtenerAtributosTabla();
		if($this->debug==true)
		{

		}
		$array_llaves=array_keys($this->InfoObjetoTabla->keys);
		$llave_primaria=$array_llaves[0];
		foreach ($this->InfoObjetoTabla->flds as $llave => $valor)
		{
			if($valor->name <> $llave_primaria)
			{
				$coincidencia=$this->BuscarCoincidenciasCampo($valor->name);
				$existeTabla=$this->BuscaSiExisteTablaPosible($coincidencia['separacion']);
				if($existeTabla==true)
				{
					$existeCampo=$this->BuscaSiExisteCampo($coincidencia['nombreposible'],$coincidencia['separacion']);
				}
				if($coincidencia['separacion']<>$Tabla)
				{
					$array_coincidencias[]=array('campo'=>$valor->name,'coincidencia'=>$coincidencia['expresion'],'posibletabla'=>$coincidencia['separacion'],'nombreposible'=>$coincidencia['nombreposible'],'existetabla'=>$existeTabla,'existecampo'=>$existeCampo);
				}
			}
		}

		foreach ($array_coincidencias as $llave => $valor)
		{
			if($valor['existetabla']==true)
			{
				$array_tablas_existentes[]=$valor;
			}
			if($valor['existecampo']==true and $valor['existetabla']==true)
			{
				$array_tablas_para_archivo[]=array('tabla_relacionada'=>$valor['posibletabla'],'llave_relacionada'=>$valor['campo'],'dato_mostrar'=>$valor['nombreposible'],'requerido'=>1);
			}
		}
		if($this->debug==true)
		{
			$this->trazaTabla($array_coincidencias,"array_coincidencias");
			$this->trazaTabla($array_tablas_existentes,"array_tablas_existentes");
			$this->trazaTabla($array_tablas_para_archivo,"array_tablas_para_arhivo");
		}
		return $array_tablas_para_archivo;
	}

	function BuscaSiExisteCampo($Campo,$Tabla)
	{
		$QueryCamposTabla="SHOW FIELDS FROM $Tabla";
		$Operacion=$this->conexion->query($QueryCamposTabla);
		$RowOperacion=$Operacion->fetchRow();
		if($this->debug==true)
		{
			echo "Busca si existe tabla: ";
			echo $QueryCamposTabla,"<br>";
		}

		do
		{
			$array_tabla[]=$RowOperacion;
		}
		while($RowOperacion=$Operacion->fetchRow());
		$existeCampo=false;
		foreach ($array_tabla as $llave => $valor)
		{
			if($valor['Field']==$Campo)
			{
				$existeCampo=true;
			}
		}
		return $existeCampo;
	}

	function BuscarCoincidenciasCampo($Campo)
	{
		if(ereg('codigo',$Campo))
		{
			if($this->debug==true)
			{
				echo "codigo ",$Campo,"<br>";
			}
			$destruyecadena=ereg_replace('codigo',null,$Campo);
			$nombreposiblecampomostrar=ereg_replace('codigo','nombre',$Campo);
			$coincidencia=array('expresion'=>'codigo','separacion'=>$destruyecadena,'nombreposible'=>$nombreposiblecampomostrar);
		}
		elseif (ereg('tipo',$Campo))
		{
			if($this->debug==true)
			{
				echo "tipo ",$Campo,"<br>";
			}
			$destruyecadena=ereg_replace('tipo',null,$Campo);
			$nombreposiblecampomostrar=ereg_replace('tipo','nombre',$Campo);
			$coincidencia=array('expresion'=>'tipo','separacion'=>$destruyecadena,'nombreposible'=>$nombreposiblecampomostrar);
		}
		elseif (ereg('id',$Campo))
		{
			if($this->debug==true)
			{
				echo "id ",$Campo,"<br>";
			}
			$destruyecadena=ereg_replace('id',null,$Campo);
			$nombreposiblecampomostrar=ereg_replace('id','nombre',$Campo);
			$coincidencia=array('expresion'=>'id','separacion'=>$destruyecadena,'nombreposible'=>$nombreposiblecampomostrar);
		}
		elseif (ereg('referencia',$Campo))
		{
			if($this->debug==true)
			{
				echo "referencia ",$Campo,"<br>";
			}
			$destruyecadena=ereg_replace('referencia',null,$Campo);
			$nombreposiblecampomostrar=ereg_replace('referencia','nombre',$Campo);
			$coincidencia=array('expresion'=>'referencia','separacion'=>$destruyecadena,'nombreposible'=>$nombreposiblecampomostrar);
		}
		elseif (ereg('estado',$Campo))
		{
			if($this->debug==true)
			{
				echo "estado ",$Campo,"<br>";
			}
			$destruyecadena=ereg_replace('estado',null,$Campo);
			$nombreposiblecampomostrar=ereg_replace('estado','nombre',$Campo);
			$coincidencia=array('expresion'=>'estado','separacion'=>$destruyecadena,'nombreposible'=>$nombreposiblecampomostrar);
		}
		elseif (ereg('numero',$Campo))
		{
			if($this->debug==true)
			{
				echo "numero ",$Campo,"<br>";
			}
			$nombreposiblecampomostrar=$Campo;
			$coincidencia=array('expresion'=>'numero','separacion'=>$destruyecadena,'nombreposible'=>$nombreposiblecampomostrar);
		}
		else
		{
			$coincidencia=false;
		}
		return $coincidencia;
	}

	function BuscaSiExisteTablaPosible($TablaPosible)
	{
		$existeTabla=false;
		foreach ($this->arrayTablasBD as $llave => $valor)
		{
			if ($TablaPosible==$valor['Tables_in_sala'])
			{
				$existeTabla=true;
			}
		}
		return $existeTabla;
	}

	function GenerarArchivoSeparadoPorComas($array,$ruta,$nombrearchivo)
	{
		if(is_array($array))
		{
			if(!file_exists($ruta.$nombrearchivo))
			{
				$NuevoArchivo = fopen($ruta.$nombrearchivo, "x+");
				foreach ($array as $llave => $valor)
				{
					if($this->debug==true)
					{
						echo $valor['posibletabla'].",".$valor['campo'].",".$valor['nombreposible']."<br>";
					}
					$cadena=$valor['posibletabla'].",".$valor['campo'].",".$valor['nombreposible'].","."1"."\n";
					fwrite($NuevoArchivo,$cadena);
				}
				fclose($NuevoArchivo);
			}
		}
		else
		{
			return false;
		}
	}

	function GenerarArchivoSeparadoPorComasMaestroDetalle($array,$ruta,$nombrearchivo)
	{
		if(is_array($array))
		{
			if(!file_exists($ruta.$nombrearchivo))
			{
				$NuevoArchivo = fopen($ruta.$nombrearchivo, "x+");
				foreach ($array as $llave => $valor)
				{
					if($this->debug==true)
					{
						echo $valor['tabla_consultar'].",".$valor['tabla_detalle']."<br>";
					}
					$cadena=$valor['tabla_consultar'].",".$valor['tabla_detalle'].","."1"."\n";
					fwrite($NuevoArchivo,$cadena);
				}
				fclose($NuevoArchivo);
			}
			else
			{
				//sobreescribe por ahora
				$NuevoArchivo = fopen($ruta.$nombrearchivo, "w");
				foreach ($array as $llave => $valor)
				{
					if($this->debug==true)
					{
						echo $valor['tabla_consultar'].",".$valor['tabla_detalle']."<br>";
					}
					$cadena=$valor['tabla_consultar'].",".$valor['tabla_detalle'].","."1"."\n";
					fwrite($NuevoArchivo,$cadena);
				}
				fclose($NuevoArchivo);
			}
		}
		else
		{
			return false;
		}
	}

	function DibujarTablaComoFormulario($tabla,$rutaarchivo)
	{
		$array_archivo=$this->CargarArchivoConfiguracionTabla($tabla,$rutaarchivo);//intenta cargar el archivo previamente generado en el array

		if(!$array_archivo)//si pailas, entonces buscar? la bd para encontrar conincidencias de manera automatica en el array
		{
			if($this->debug==true)
			{
				echo "No existe archivo, se inici? lógica automática<br>";
			}
			$array_archivo=$this->BuscarCoincidenciasTabla($tabla);
		}

		$obj=new ADODB_Active_Record($tabla);
		$atributos=$obj->GetAttributeNames();
		$info=$obj->TableInfo();
		$llave=array_keys($info->keys);
		//$this->agregar_tablas($tabla,$llave[0]);
		$this->agregar_tablas($tabla,$llave[0],$_GET[$llave[0]]);
		if($_GET[$llave[0]]<>"")
		{
			$valor_llave_cargar='"'.$_GET[$llave[0]].'"';

			$this->cargar_distintivo($tabla,$llave[0],$valor_llave_cargar);
		}
		if($array_archivo[0]['tabla_relacionada']=="")
		{
			foreach ($atributos as $llave => $valor)
			{
				$this->DibujarCamposTextoMemo($tabla,$info->keys,$info->flds[$valor]->name,$info->flds[$valor]->type,$info->flds[$valor]->max_length,$info->flds[$valor]->not_null,$info->flds[$valor]->auto_increment);
			}
		}
		else
		{
			foreach ($atributos as $llave => $valor)
			{
				$DisparaCombo=false;
				foreach ($array_archivo as $llave_archivo => $valor_archivo)
				{
					if($info->flds[$valor]->name == $valor_archivo['llave_relacionada'])
					{
						$DisparaCombo=true;
						$LLaveDispara=$llave_archivo;
					}
				}
				if($DisparaCombo==true)
				{
					$this->celda_horizontal_combo($info->flds[$valor]->name,$info->flds[$valor]->name,$array_archivo[$LLaveDispara]['tabla_relacionada'],$tabla,$array_archivo[$LLaveDispara]['llave_relacionada'],$array_archivo[$LLaveDispara]['dato_mostrar'],'requerido','Campoc');
					//echo $info->flds[$valor]->name,$info->flds[$valor]->name,$valor_archivo['tabla_relacionada'],$tabla,$valor_archivo['llave_relacionada'],$valor_archivo['dato_mostrar'],"<br>";
				}
				else
				{
					$this->DibujarCamposTextoMemo($tabla,$info->keys,$info->flds[$valor]->name,$info->flds[$valor]->type,$info->flds[$valor]->max_length,$info->flds[$valor]->not_null,$info->flds[$valor]->auto_increment);
				}
			}
		}

		if($this->debug==true)
		{
			if(is_array($info->keys))
			{
				$this->trace($info->keys,'','LLave Objeto');
			}
			if(is_array($info->flds))
			{
				$this->trace($info->flds,'','Info Campos Objeto');
			}
		}

	}

	function DibujarCamposTextoMemo($tabla,$pk_tabla,$atributo,$tipo,$tamano,$obligatorio,$auto)
	{
		//echo $atributo,"<br>",$tipo,"<br>",$tamano,"<br>",$obligatorio,"<br>";
		if($auto<>1)
		{
			switch ($tipo)
			{
				case 'int' :
					if($obligatorio==1)
					{
						$obligatorio='numero';
					}
					echo "<tr>\n";
					$this->celda_horizontal_campotexto($atributo,$atributo,$tabla,$tamano,$obligatorio,"","","");
					echo "</tr>\n";
					break;

				case 'smallint':
					if($obligatorio==1)
					{
						$obligatorio='numero';
					}
					echo "<tr>\n";
					$this->celda_horizontal_campotexto($atributo,$atributo,$tabla,$tamano,$obligatorio,"","","");
					echo "</tr>\n";
					break;

				case 'decimal':
					if($obligatorio==1)
					{
						$obligatorio='decimal';
					}
					echo "<tr>\n";
					$this->celda_horizontal_campotexto($atributo,$atributo,$tabla,$tamano,$obligatorio,"","","");
					echo "</tr>\n";
					break;

				case 'char':
					if($obligatorio==1)
					{
						$obligatorio='requerido';
					}
					echo "<tr>\n";
					$this->celda_horizontal_campotexto($atributo,$atributo,$tabla,$tamano,$obligatorio,"","","");
					echo "</tr>\n";
					break;

				case 'varchar':
					if($obligatorio==1)
					{
						$obligatorio='requerido';
					}
					echo "<tr>\n";
					$this->celda_horizontal_campotexto($atributo,$atributo,$tabla,$tamano,$obligatorio,"","","");
					echo "</tr>\n";
					break;

				case 'datetime':
					if($obligatorio==1)
					{
						$obligatorio='fecha';
					}
					echo "<tr>\n";
					$this->celda_horizontal_calendario($atributo,$atributo,$tabla);
					echo "</tr>\n";
					break;

				case 'date':
					if($obligatorio==1)
					{
						$obligatorio='fecha';
					}
					echo "<tr>\n";
					$this->celda_horizontal_calendario($atributo,$atributo,$tabla);
					echo "</tr>\n";
					break;

				case 'smalltext':
					if($obligatorio==1)
					{
						$obligatorio='requerido';
					}
					echo "<tr>\n";
					$this->celda_vertical_memo($atributo,$atributo,$tabla,60,5,$obligatorio);
					echo "</tr>\n";
					break;


				case 'mediumtext':
					if($obligatorio==1)
					{
						$obligatorio='requerido';
					}
					echo "<tr>\n";
					$this->celda_vertical_memo($atributo,$atributo,$tabla,60,5,$obligatorio);
					echo "</tr>\n";
					break;

				case 'longtext':
					if($obligatorio==1)
					{
						$obligatorio='requerido';
					}
					echo "<tr>\n";
					$this->celda_vertical_memo($atributo,$atributo,$tabla,60,5,$obligatorio);
					echo "</tr>\n";
					break;

				case 'memo':
					if($obligatorio==1)
					{
						$obligatorio='requerido';
					}
					echo "<tr>\n";
					$this->celda_vertical_memo($atributo,$atributo,$tabla,60,5,$obligatorio);
					echo "</tr>\n";
					break;
			}
		}
	}

	function EscribirCabeceras($matriz)
	{
		echo "<tr>\n";
		echo "<td>Conteo</a></td>\n";
		while($elemento = each($matriz))
		{
			echo "<td>$elemento[0]</a></td>\n";
		}
		echo "</tr>\n";
	}

	function DibujarTabla($matriz,$texto="")
	{
		if(is_array($matriz))
		{
			echo "<table border='1' cellpadding='2' cellspacing='1' align=center>\n";
			echo "<caption align=TOP><h1>$texto</h1></caption>\n";
			$this->EscribirCabeceras($matriz[0],$link);
			for($i=0; $i < count($matriz); $i++)
			{
				$MostrarConteo=$i+1;
				echo "<tr>\n";
				echo "<td nowrap>$MostrarConteo&nbsp;</td>\n";
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

	function LeerTablasBD()
	{
		$query="SHOW TABLES";
		$operacion=$this->conexion->query($query);
		$row_operacion=$operacion->fetchRow();
		do
		{
			$array_interno[]=$row_operacion;
		}
		while ($row_operacion=$operacion->fetchRow());

		return $array_interno;
	}

	function ejecutarQuery($query,$retorno='array',$nombretransaccion=null)
	{
		$operacion=$this->conexion->query($query);
		$row_operacion=$operacion->fetchRow();
		do
		{
			if(!empty($row_operacion))
			{
				$array_interno[]=$row_operacion;
			}
		}
		while($row_operacion=$operacion->fetchRow());

		if($this->depurar==true)
		{
			$this->DibujarTabla($array_interno,$nombretransaccion);
		}

		if($retorno=='array')
		{
			return $array_interno;
		}
		elseif($retorno=='conteo')
		{
			return count($array_interno);
		}
	}

	function CargarArchivoConfiguracionTabla($tabla,$rutaartchivo)
	{
		if(file_exists($rutaartchivo.$tabla.".txt"))
		{
			$archivo = file($rutaartchivo.$tabla.".txt");
			$longitud=sizeof($archivo);
			/**
		 * Se arma primero un array bidimensional con los datos del archivo
	 	*/
			for($i=0; $i<sizeof($archivo); $i++)
			{
				$array_precarga=explode(",",$archivo[$i]);
				if(is_array($array_precarga))
				{
					$array_carga[]=array('tabla_relacionada'=>$array_precarga[0],'llave_relacionada'=>$array_precarga[1],'dato_mostrar'=>$array_precarga[2],'requerido'=>$array_precarga[3]);
				}
				else
				{
					return false;
				}
			}
			$this->array_carga_archivo=$array_carga;
			return $array_carga;
		}
		else
		{
			return false;
		}
	}

	function CargarArchivoConfiguracionBDMaestroDetalle($bd,$rutaartchivo)
	{
		if(file_exists($rutaartchivo.$bd."_maestrodetalle.txt"))
		{
			$archivo = file($rutaartchivo.$bd."_maestrodetalle.txt");
			$longitud=sizeof($archivo);
			/**
		 * Se arma primero un array bidimensional con los datos del archivo
	 	*/
			for($i=0; $i<sizeof($archivo); $i++)
			{
				$array_precarga=explode(",",$archivo[$i]);
				if(is_array($array_precarga))
				{
					$array_carga[]=array('tabla_consultar'=>$array_precarga[0],'tabla_detalle'=>$array_precarga[1]);
				}
				else
				{
					return false;
				}
			}
			return $array_carga;
		}
		else
		{
			return false;
		}
	}

	function estiloCSS(){
		echo '	<style type="text/css">
	body{
		margin:0px;
		font-size:0.8em;
	}
	#mainContainer{
		width:840px;
		margin:5px;
	}
	table,tr,td{
		vertical-align:top;
	}
	.textInput{
		width:300px;
	}
	html{
		margin:0px;
	}
	.formButton{
		width:75px;
	}
	textarea,input,select{
		font-family:Trebuchet MS;
	}
	i{
		font-size:0.9em;
	}
	</style>';
	}

	function javaScriptDepurar()
	{
			?>
		<style>
    .sa_trace_start_link, .sa_trace_start_link:hover
    {
    color: lime;
        text-decoration: none;
    }
    .sa_trace_start
    {
        padding: 2px;
        text-align: center;
        background-color: gray;
        font-family: helvetica, arial, sans-serif;
        font-size: 12px;
        font-weight: bold;
    }
    .sa_trace_dump
    {
        border: solid;
        border-color: lime;
        padding: 20px;
        position: absolute;
        background-color: gray;
        font-family: helvetica, arial, sans-serif;
        font-size: 12px;
        visibility: hidden;
        color: blue;
    }
    .sa_trace_end
    {
        font-family: helvetica, arial, sans-serif;
        font-size: 12px;
        font-weight: bold;
    }
    </style>

      <script language="JavaScript" type="text/JavaScript">
      <!--

      function MM_toggleVisibility(objName)
      {
      	var obj = MM_findObj(objName);
      	return (obj.style.visibility == 'visible') ? 'hidden' : 'visible';
      }

      function MM_findObj(n, d) {
      	var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
      		d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
      		if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
      		for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
      		if(!x && d.getElementById) x=d.getElementById(n); return x;
      }

      function MM_changeProp(objName,x,theProp,theValue) {
      	var obj = MM_findObj(objName);
      	if (obj && (theProp.indexOf("style.")==-1 || obj.style)){
      		if (theValue == true || theValue == false)
      		eval("obj."+theProp+"="+theValue);
      		else eval("obj."+theProp+"='"+theValue+"'");
      	}
      }
      -->
    </script>



<?php
	}


	function trace($var, $file, $line, $exit = false)
	{

		$id = md5(microtime());
            ?>
            <div class="sa_trace_start"><a href="javascript:;" class="sa_trace_start_link" onClick="MM_changeProp('var_<?= $id ?>', '', 'style.visibility', MM_toggleVisibility('var_<?= $id ?>'), 'DIV'); " title="click here to view the output of var_dump(<?= gettype($var) ?>)">:: Traza <span style="color: #ff6600"><?= $file ?></span> on line <?= $line ?> ::</a></div>
             <div id="var_<?= $id ?>" title="click para cerrar" class="sa_trace_dump" onClick="MM_changeProp('var_<?= $id ?>', '', 'style.visibility', MM_toggleVisibility('var_<?= $id ?>'), 'DIV');">
             <pre><?= print_r($var) ?></pre>
             <div class="sa_trace_end">:: Final de la traza ::</div>
             </div>
<?php

	}
	function trazaTabla($var, $line, $exit = false)
	{

		$id = md5(microtime());
            ?>
            <div class="sa_trace_start"><a href="javascript:;" class="sa_trace_start_link" onClick="MM_changeProp('var_<?= $id ?>', '', 'style.visibility', MM_toggleVisibility('var_<?= $id ?>'), 'DIV'); " title="click here to view the output of var_dump(<?= gettype($var) ?>)">:: Traza <span style="color: #FF0000"><?= $file ?></span> on line <?= $line ?> ::</a></div>
             <div id="var_<?= $id ?>" title="click para cerrar" class="sa_trace_dump" onClick="MM_changeProp('var_<?= $id ?>', '', 'style.visibility', MM_toggleVisibility('var_<?= $id ?>'), 'DIV');">
             <pre><?= $this->DibujarTabla($var,$titulovar) ?></pre>
             <div class="sa_trace_end">:: Final de la traza ::</div>
             </div>
<?php
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

		function enviar(formulario)
		{
			document.formulario.submit()
		}

		function Confirmacion(link_si,link_no,formulario,url)
		{
			if(confirm('La autorización de grado no es reversible. ¿Desea continuar?'))
			{
				document.formulario.submit();
				window.location.reload(url);
			}
		}
		function reCarga(url)
		{
			window.location.href = url
		}
		function reCargaAuto()
		{
			window.location.href = "<?php echo $_SERVER['REQUEST_URI']?>"
		}
		function chequeaSubmit(formulario)
		{
			//desactivar boton submit.
			document.formulario.Enviar.disabled = true;
			//Entonces submita el boton.
			document.formulario.submit();
		}
		function refreshx()
		{
			window.location.href=document.location;
		}

		function submitirFormulario(formulario)
		{
			document.formulario.submit();
		}

		function refresh4()
		{
			//  This version of the refresh function will be invoked
			//  for browsers that support JavaScript version 1.2
			//

			//  The argument to the location.reload function determines
			//  if the browser should retrieve the document from the
			//  web-server.  In our example all we need to do is cause
			//  the JavaScript block in the document body to be
			//  re-evaluated.  If we needed to pull the document from
			//  the web-server again (such as where the document contents
			//  change dynamically) we would pass the argument as 'true'.
			//
			window.location.reload(true);
		}

		function refresh1()
		{
			history.go(0);
		}

</script>
		<?php }

		function jsCalendario()
		{ ?>

			<script language="javascript">
			/*  Copyright Mihai Bazon, 2002-2005  |  www.bazon.net/mishoo
			* -----------------------------------------------------------
			*
			* The DHTML Calendar, version 1.0 "It is happening again"
			*
			* Details and latest version at:
			* www.dynarch.com/projects/calendar
			*
			* This script is developed by Dynarch.com.  Visit us at www.dynarch.com.
			*
			* This script is distributed under the GNU Lesser General Public License.
			* Read the entire license text here: http://www.gnu.org/licenses/lgpl.html
			*/

			// $Id: clase_formulario.php,v 1.10 2007/06/01 16:02:14 Abraham Castro Exp $

			/** The Calendar object constructor. */
			Calendar = function (firstDayOfWeek, dateStr, onSelected, onClose) {
				// member variables
				this.activeDiv = null;
				this.currentDateEl = null;
				this.getDateStatus = null;
				this.getDateToolTip = null;
				this.getDateText = null;
				this.timeout = null;
				this.onSelected = onSelected || null;
				this.onClose = onClose || null;
				this.dragging = false;
				this.hidden = false;
				this.minYear = 1970;
				this.maxYear = 2050;
				this.dateFormat = Calendar._TT["DEF_DATE_FORMAT"];
				this.ttDateFormat = Calendar._TT["TT_DATE_FORMAT"];
				this.isPopup = true;
				this.weekNumbers = true;
				this.firstDayOfWeek = typeof firstDayOfWeek == "number" ? firstDayOfWeek : Calendar._FD; // 0 for Sunday, 1 for Monday, etc.
				this.showsOtherMonths = false;
				this.dateStr = dateStr;
				this.ar_days = null;
				this.showsTime = false;
				this.time24 = true;
				this.yearStep = 2;
				this.hiliteToday = true;
				this.multiple = null;
				// HTML elements
				this.table = null;
				this.element = null;
				this.tbody = null;
				this.firstdayname = null;
				// Combo boxes
				this.monthsCombo = null;
				this.yearsCombo = null;
				this.hilitedMonth = null;
				this.activeMonth = null;
				this.hilitedYear = null;
				this.activeYear = null;
				// Information
				this.dateClicked = false;

				// one-time initializations
				if (typeof Calendar._SDN == "undefined") {
					// table of short day names
					if (typeof Calendar._SDN_len == "undefined")
					Calendar._SDN_len = 3;
					var ar = new Array();
					for (var i = 8; i > 0;) {
						ar[--i] = Calendar._DN[i].substr(0, Calendar._SDN_len);
					}
					Calendar._SDN = ar;
					// table of short month names
					if (typeof Calendar._SMN_len == "undefined")
					Calendar._SMN_len = 3;
					ar = new Array();
					for (var i = 12; i > 0;) {
						ar[--i] = Calendar._MN[i].substr(0, Calendar._SMN_len);
					}
					Calendar._SMN = ar;
				}
			};

			// ** constants

			/// "static", needed for event handlers.
			Calendar._C = null;

			/// detect a special case of "web browser"
			Calendar.is_ie = ( /msie/i.test(navigator.userAgent) &&
			!/opera/i.test(navigator.userAgent) );

			Calendar.is_ie5 = ( Calendar.is_ie && /msie 5\.0/i.test(navigator.userAgent) );

			/// detect Opera browser
			Calendar.is_opera = /opera/i.test(navigator.userAgent);

			/// detect KHTML-based browsers
			Calendar.is_khtml = /Konqueror|Safari|KHTML/i.test(navigator.userAgent);

			// BEGIN: UTILITY FUNCTIONS; beware that these might be moved into a separate
			//        library, at some point.

			Calendar.getAbsolutePos = function(el) {
				var SL = 0, ST = 0;
				var is_div = /^div$/i.test(el.tagName);
				if (is_div && el.scrollLeft)
				SL = el.scrollLeft;
				if (is_div && el.scrollTop)
				ST = el.scrollTop;
				var r = { x: el.offsetLeft - SL, y: el.offsetTop - ST };
				if (el.offsetParent) {
					var tmp = this.getAbsolutePos(el.offsetParent);
					r.x += tmp.x;
					r.y += tmp.y;
				}
				return r;
			};

			Calendar.isRelated = function (el, evt) {
				var related = evt.relatedTarget;
				if (!related) {
					var type = evt.type;
					if (type == "mouseover") {
						related = evt.fromElement;
					} else if (type == "mouseout") {
						related = evt.toElement;
					}
				}
				while (related) {
					if (related == el) {
						return true;
					}
					related = related.parentNode;
				}
				return false;
			};

			Calendar.removeClass = function(el, className) {
				if (!(el && el.className)) {
					return;
				}
				var cls = el.className.split(" ");
				var ar = new Array();
				for (var i = cls.length; i > 0;) {
					if (cls[--i] != className) {
						ar[ar.length] = cls[i];
					}
				}
				el.className = ar.join(" ");
			};

			Calendar.addClass = function(el, className) {
				Calendar.removeClass(el, className);
				el.className += " " + className;
			};

			// FIXME: the following 2 functions totally suck, are useless and should be replaced immediately.
			Calendar.getElement = function(ev) {
				var f = Calendar.is_ie ? window.event.srcElement : ev.currentTarget;
				while (f.nodeType != 1 || /^div$/i.test(f.tagName))
				f = f.parentNode;
				return f;
			};

			Calendar.getTargetElement = function(ev) {
				var f = Calendar.is_ie ? window.event.srcElement : ev.target;
				while (f.nodeType != 1)
				f = f.parentNode;
				return f;
			};

			Calendar.stopEvent = function(ev) {
				ev || (ev = window.event);
				if (Calendar.is_ie) {
					ev.cancelBubble = true;
					ev.returnValue = false;
				} else {
					ev.preventDefault();
					ev.stopPropagation();
				}
				return false;
			};

			Calendar.addEvent = function(el, evname, func) {
				if (el.attachEvent) { // IE
					el.attachEvent("on" + evname, func);
				} else if (el.addEventListener) { // Gecko / W3C
					el.addEventListener(evname, func, true);
				} else {
					el["on" + evname] = func;
				}
			};

			Calendar.removeEvent = function(el, evname, func) {
				if (el.detachEvent) { // IE
					el.detachEvent("on" + evname, func);
				} else if (el.removeEventListener) { // Gecko / W3C
					el.removeEventListener(evname, func, true);
				} else {
					el["on" + evname] = null;
				}
			};

			Calendar.createElement = function(type, parent) {
				var el = null;
				if (document.createElementNS) {
					// use the XHTML namespace; IE won't normally get here unless
					// _they_ "fix" the DOM2 implementation.
					el = document.createElementNS("http://www.w3.org/1999/xhtml", type);
				} else {
					el = document.createElement(type);
				}
				if (typeof parent != "undefined") {
					parent.appendChild(el);
				}
				return el;
			};

			// END: UTILITY FUNCTIONS

			// BEGIN: CALENDAR STATIC FUNCTIONS

			/** Internal -- adds a set of events to make some element behave like a button. */
			Calendar._add_evs = function(el) {
				with (Calendar) {
					addEvent(el, "mouseover", dayMouseOver);
					addEvent(el, "mousedown", dayMouseDown);
					addEvent(el, "mouseout", dayMouseOut);
					if (is_ie) {
						addEvent(el, "dblclick", dayMouseDblClick);
						el.setAttribute("unselectable", true);
					}
				}
			};

			Calendar.findMonth = function(el) {
				if (typeof el.month != "undefined") {
					return el;
				} else if (typeof el.parentNode.month != "undefined") {
					return el.parentNode;
				}
				return null;
			};

			Calendar.findYear = function(el) {
				if (typeof el.year != "undefined") {
					return el;
				} else if (typeof el.parentNode.year != "undefined") {
					return el.parentNode;
				}
				return null;
			};

			Calendar.showMonthsCombo = function () {
				var cal = Calendar._C;
				if (!cal) {
					return false;
				}
				var cal = cal;
				var cd = cal.activeDiv;
				var mc = cal.monthsCombo;
				if (cal.hilitedMonth) {
					Calendar.removeClass(cal.hilitedMonth, "hilite");
				}
				if (cal.activeMonth) {
					Calendar.removeClass(cal.activeMonth, "active");
				}
				var mon = cal.monthsCombo.getElementsByTagName("div")[cal.date.getMonth()];
				Calendar.addClass(mon, "active");
				cal.activeMonth = mon;
				var s = mc.style;
				s.display = "block";
				if (cd.navtype < 0)
				s.left = cd.offsetLeft + "px";
				else {
					var mcw = mc.offsetWidth;
					if (typeof mcw == "undefined")
					// Konqueror brain-dead techniques
					mcw = 50;
					s.left = (cd.offsetLeft + cd.offsetWidth - mcw) + "px";
				}
				s.top = (cd.offsetTop + cd.offsetHeight) + "px";
			};

			Calendar.showYearsCombo = function (fwd) {
				var cal = Calendar._C;
				if (!cal) {
					return false;
				}
				var cal = cal;
				var cd = cal.activeDiv;
				var yc = cal.yearsCombo;
				if (cal.hilitedYear) {
					Calendar.removeClass(cal.hilitedYear, "hilite");
				}
				if (cal.activeYear) {
					Calendar.removeClass(cal.activeYear, "active");
				}
				cal.activeYear = null;
				var Y = cal.date.getFullYear() + (fwd ? 1 : -1);
				var yr = yc.firstChild;
				var show = false;
				for (var i = 12; i > 0; --i) {
					if (Y >= cal.minYear && Y <= cal.maxYear) {
						yr.innerHTML = Y;
						yr.year = Y;
						yr.style.display = "block";
						show = true;
					} else {
						yr.style.display = "none";
					}
					yr = yr.nextSibling;
					Y += fwd ? cal.yearStep : -cal.yearStep;
				}
				if (show) {
					var s = yc.style;
					s.display = "block";
					if (cd.navtype < 0)
					s.left = cd.offsetLeft + "px";
					else {
						var ycw = yc.offsetWidth;
						if (typeof ycw == "undefined")
						// Konqueror brain-dead techniques
						ycw = 50;
						s.left = (cd.offsetLeft + cd.offsetWidth - ycw) + "px";
					}
					s.top = (cd.offsetTop + cd.offsetHeight) + "px";
				}
			};

			// event handlers

			Calendar.tableMouseUp = function(ev) {
				var cal = Calendar._C;
				if (!cal) {
					return false;
				}
				if (cal.timeout) {
					clearTimeout(cal.timeout);
				}
				var el = cal.activeDiv;
				if (!el) {
					return false;
				}
				var target = Calendar.getTargetElement(ev);
				ev || (ev = window.event);
				Calendar.removeClass(el, "active");
				if (target == el || target.parentNode == el) {
					Calendar.cellClick(el, ev);
				}
				var mon = Calendar.findMonth(target);
				var date = null;
				if (mon) {
					date = new Date(cal.date);
					if (mon.month != date.getMonth()) {
						date.setMonth(mon.month);
						cal.setDate(date);
						cal.dateClicked = false;
						cal.callHandler();
					}
				} else {
					var year = Calendar.findYear(target);
					if (year) {
						date = new Date(cal.date);
						if (year.year != date.getFullYear()) {
							date.setFullYear(year.year);
							cal.setDate(date);
							cal.dateClicked = false;
							cal.callHandler();
						}
					}
				}
				with (Calendar) {
					removeEvent(document, "mouseup", tableMouseUp);
					removeEvent(document, "mouseover", tableMouseOver);
					removeEvent(document, "mousemove", tableMouseOver);
					cal._hideCombos();
					_C = null;
					return stopEvent(ev);
				}
			};

			Calendar.tableMouseOver = function (ev) {
				var cal = Calendar._C;
				if (!cal) {
					return;
				}
				var el = cal.activeDiv;
				var target = Calendar.getTargetElement(ev);
				if (target == el || target.parentNode == el) {
					Calendar.addClass(el, "hilite active");
					Calendar.addClass(el.parentNode, "rowhilite");
				} else {
					if (typeof el.navtype == "undefined" || (el.navtype != 50 && (el.navtype == 0 || Math.abs(el.navtype) > 2)))
					Calendar.removeClass(el, "active");
					Calendar.removeClass(el, "hilite");
					Calendar.removeClass(el.parentNode, "rowhilite");
				}
				ev || (ev = window.event);
				if (el.navtype == 50 && target != el) {
					var pos = Calendar.getAbsolutePos(el);
					var w = el.offsetWidth;
					var x = ev.clientX;
					var dx;
					var decrease = true;
					if (x > pos.x + w) {
						dx = x - pos.x - w;
						decrease = false;
					} else
					dx = pos.x - x;

					if (dx < 0) dx = 0;
					var range = el._range;
					var current = el._current;
					var count = Math.floor(dx / 10) % range.length;
					for (var i = range.length; --i >= 0;)
					if (range[i] == current)
					break;
					while (count-- > 0)
					if (decrease) {
						if (--i < 0)
						i = range.length - 1;
					} else if ( ++i >= range.length )
					i = 0;
					var newval = range[i];
					el.innerHTML = newval;

					cal.onUpdateTime();
				}
				var mon = Calendar.findMonth(target);
				if (mon) {
					if (mon.month != cal.date.getMonth()) {
						if (cal.hilitedMonth) {
							Calendar.removeClass(cal.hilitedMonth, "hilite");
						}
						Calendar.addClass(mon, "hilite");
						cal.hilitedMonth = mon;
					} else if (cal.hilitedMonth) {
						Calendar.removeClass(cal.hilitedMonth, "hilite");
					}
				} else {
					if (cal.hilitedMonth) {
						Calendar.removeClass(cal.hilitedMonth, "hilite");
					}
					var year = Calendar.findYear(target);
					if (year) {
						if (year.year != cal.date.getFullYear()) {
							if (cal.hilitedYear) {
								Calendar.removeClass(cal.hilitedYear, "hilite");
							}
							Calendar.addClass(year, "hilite");
							cal.hilitedYear = year;
						} else if (cal.hilitedYear) {
							Calendar.removeClass(cal.hilitedYear, "hilite");
						}
					} else if (cal.hilitedYear) {
						Calendar.removeClass(cal.hilitedYear, "hilite");
					}
				}
				return Calendar.stopEvent(ev);
			};

			Calendar.tableMouseDown = function (ev) {
				if (Calendar.getTargetElement(ev) == Calendar.getElement(ev)) {
					return Calendar.stopEvent(ev);
				}
			};

			Calendar.calDragIt = function (ev) {
				var cal = Calendar._C;
				if (!(cal && cal.dragging)) {
					return false;
				}
				var posX;
				var posY;
				if (Calendar.is_ie) {
					posY = window.event.clientY + document.body.scrollTop;
					posX = window.event.clientX + document.body.scrollLeft;
				} else {
					posX = ev.pageX;
					posY = ev.pageY;
				}
				cal.hideShowCovered();
				var st = cal.element.style;
				st.left = (posX - cal.xOffs) + "px";
				st.top = (posY - cal.yOffs) + "px";
				return Calendar.stopEvent(ev);
			};

			Calendar.calDragEnd = function (ev) {
				var cal = Calendar._C;
				if (!cal) {
					return false;
				}
				cal.dragging = false;
				with (Calendar) {
					removeEvent(document, "mousemove", calDragIt);
					removeEvent(document, "mouseup", calDragEnd);
					tableMouseUp(ev);
				}
				cal.hideShowCovered();
			};

			Calendar.dayMouseDown = function(ev) {
				var el = Calendar.getElement(ev);
				if (el.disabled) {
					return false;
				}
				var cal = el.calendar;
				cal.activeDiv = el;
				Calendar._C = cal;
				if (el.navtype != 300) with (Calendar) {
					if (el.navtype == 50) {
						el._current = el.innerHTML;
						addEvent(document, "mousemove", tableMouseOver);
					} else
					addEvent(document, Calendar.is_ie5 ? "mousemove" : "mouseover", tableMouseOver);
					addClass(el, "hilite active");
					addEvent(document, "mouseup", tableMouseUp);
				} else if (cal.isPopup) {
					cal._dragStart(ev);
				}
				if (el.navtype == -1 || el.navtype == 1) {
					if (cal.timeout) clearTimeout(cal.timeout);
					cal.timeout = setTimeout("Calendar.showMonthsCombo()", 250);
				} else if (el.navtype == -2 || el.navtype == 2) {
					if (cal.timeout) clearTimeout(cal.timeout);
					cal.timeout = setTimeout((el.navtype > 0) ? "Calendar.showYearsCombo(true)" : "Calendar.showYearsCombo(false)", 250);
				} else {
					cal.timeout = null;
				}
				return Calendar.stopEvent(ev);
			};

			Calendar.dayMouseDblClick = function(ev) {
				Calendar.cellClick(Calendar.getElement(ev), ev || window.event);
				if (Calendar.is_ie) {
					document.selection.empty();
				}
			};

			Calendar.dayMouseOver = function(ev) {
				var el = Calendar.getElement(ev);
				if (Calendar.isRelated(el, ev) || Calendar._C || el.disabled) {
					return false;
				}
				if (el.ttip) {
					if (el.ttip.substr(0, 1) == "_") {
						el.ttip = el.caldate.print(el.calendar.ttDateFormat) + el.ttip.substr(1);
					}
					el.calendar.tooltips.innerHTML = el.ttip;
				}
				if (el.navtype != 300) {
					Calendar.addClass(el, "hilite");
					if (el.caldate) {
						Calendar.addClass(el.parentNode, "rowhilite");
					}
				}
				return Calendar.stopEvent(ev);
			};

			Calendar.dayMouseOut = function(ev) {
				with (Calendar) {
					var el = getElement(ev);
					if (isRelated(el, ev) || _C || el.disabled)
					return false;
					removeClass(el, "hilite");
					if (el.caldate)
					removeClass(el.parentNode, "rowhilite");
					if (el.calendar)
					el.calendar.tooltips.innerHTML = _TT["SEL_DATE"];
					return stopEvent(ev);
				}
			};

			/**
			*  A generic "click" handler :) handles all types of buttons defined in this
			*  calendar.
			*/
			Calendar.cellClick = function(el, ev) {
				var cal = el.calendar;
				var closing = false;
				var newdate = false;
				var date = null;
				if (typeof el.navtype == "undefined") {
					if (cal.currentDateEl) {
						Calendar.removeClass(cal.currentDateEl, "selected");
						Calendar.addClass(el, "selected");
						closing = (cal.currentDateEl == el);
						if (!closing) {
							cal.currentDateEl = el;
						}
					}
					cal.date.setDateOnly(el.caldate);
					date = cal.date;
					var other_month = !(cal.dateClicked = !el.otherMonth);
					if (!other_month && !cal.currentDateEl)
					cal._toggleMultipleDate(new Date(date));
					else
					newdate = !el.disabled;
					// a date was clicked
					if (other_month)
					cal._init(cal.firstDayOfWeek, date);
				} else {
					if (el.navtype == 200) {
						Calendar.removeClass(el, "hilite");
						cal.callCloseHandler();
						return;
					}
					date = new Date(cal.date);
					if (el.navtype == 0)
					date.setDateOnly(new Date()); // TODAY
					// unless "today" was clicked, we assume no date was clicked so
					// the selected handler will know not to close the calenar when
					// in single-click mode.
					// cal.dateClicked = (el.navtype == 0);
					cal.dateClicked = false;
					var year = date.getFullYear();
					var mon = date.getMonth();
					function setMonth(m) {
						var day = date.getDate();
						var max = date.getMonthDays(m);
						if (day > max) {
							date.setDate(max);
						}
						date.setMonth(m);
					};
					switch (el.navtype) {
						case 400:
						Calendar.removeClass(el, "hilite");
						var text = Calendar._TT["ABOUT"];
						if (typeof text != "undefined") {
							text += cal.showsTime ? Calendar._TT["ABOUT_TIME"] : "";
						} else {
							// FIXME: this should be removed as soon as lang files get updated!
							text = "Help and about box text is not translated into this language.\n" +
							"If you know this language and you feel generous please update\n" +
							"the corresponding file in \"lang\" subdir to match calendar-en.js\n" +
							"and send it back to <mihai_bazon@yahoo.com> to get it into the distribution  ;-)\n\n" +
							"Thank you!\n" +
							"http://dynarch.com/mishoo/calendar.epl\n";
						}
						alert(text);
						return;
						case -2:
						if (year > cal.minYear) {
							date.setFullYear(year - 1);
						}
						break;
						case -1:
						if (mon > 0) {
							setMonth(mon - 1);
						} else if (year-- > cal.minYear) {
							date.setFullYear(year);
							setMonth(11);
						}
						break;
						case 1:
						if (mon < 11) {
							setMonth(mon + 1);
						} else if (year < cal.maxYear) {
							date.setFullYear(year + 1);
							setMonth(0);
						}
						break;
						case 2:
						if (year < cal.maxYear) {
							date.setFullYear(year + 1);
						}
						break;
						case 100:
						cal.setFirstDayOfWeek(el.fdow);
						return;
						case 50:
						var range = el._range;
						var current = el.innerHTML;
						for (var i = range.length; --i >= 0;)
						if (range[i] == current)
						break;
						if (ev && ev.shiftKey) {
							if (--i < 0)
							i = range.length - 1;
						} else if ( ++i >= range.length )
						i = 0;
						var newval = range[i];
						el.innerHTML = newval;
						cal.onUpdateTime();
						return;
						case 0:
						// TODAY will bring us here
						if ((typeof cal.getDateStatus == "function") &&
						cal.getDateStatus(date, date.getFullYear(), date.getMonth(), date.getDate())) {
							return false;
						}
						break;
					}
					if (!date.equalsTo(cal.date)) {
						cal.setDate(date);
						newdate = true;
					} else if (el.navtype == 0)
					newdate = closing = true;
				}
				if (newdate) {
					ev && cal.callHandler();
				}
				if (closing) {
					Calendar.removeClass(el, "hilite");
					ev && cal.callCloseHandler();
				}
			};

			// END: CALENDAR STATIC FUNCTIONS

			// BEGIN: CALENDAR OBJECT FUNCTIONS

			/**
			*  This function creates the calendar inside the given parent.  If _par is
			*  null than it creates a popup calendar inside the BODY element.  If _par is
			*  an element, be it BODY, then it creates a non-popup calendar (still
			*  hidden).  Some properties need to be set before calling this function.
			*/
			Calendar.prototype.create = function (_par) {
				var parent = null;
				if (! _par) {
					// default parent is the document body, in which case we create
					// a popup calendar.
					parent = document.getElementsByTagName("body")[0];
					this.isPopup = true;
				} else {
					parent = _par;
					this.isPopup = false;
				}
				this.date = this.dateStr ? new Date(this.dateStr) : new Date();

				var table = Calendar.createElement("table");
				this.table = table;
				table.cellSpacing = 0;
				table.cellPadding = 0;
				table.calendar = this;
				Calendar.addEvent(table, "mousedown", Calendar.tableMouseDown);

				var div = Calendar.createElement("div");
				this.element = div;
				div.className = "calendar";
				if (this.isPopup) {
					div.style.position = "absolute";
					div.style.display = "none";
				}
				div.appendChild(table);

				var thead = Calendar.createElement("thead", table);
				var cell = null;
				var row = null;

				var cal = this;
				var hh = function (text, cs, navtype) {
					cell = Calendar.createElement("td", row);
					cell.colSpan = cs;
					cell.className = "button";
					if (navtype != 0 && Math.abs(navtype) <= 2)
					cell.className += " nav";
					Calendar._add_evs(cell);
					cell.calendar = cal;
					cell.navtype = navtype;
					cell.innerHTML = "<div unselectable='on'>" + text + "</div>";
					return cell;
				};

				row = Calendar.createElement("tr", thead);
				var title_length = 6;
				(this.isPopup) && --title_length;
				(this.weekNumbers) && ++title_length;

				hh("?", 1, 400).ttip = Calendar._TT["INFO"];
				this.title = hh("", title_length, 300);
				this.title.className = "title";
				if (this.isPopup) {
					this.title.ttip = Calendar._TT["DRAG_TO_MOVE"];
					this.title.style.cursor = "move";
					hh("&#x00d7;", 1, 200).ttip = Calendar._TT["CLOSE"];
				}

				row = Calendar.createElement("tr", thead);
				row.className = "headrow";

				this._nav_py = hh("&#x00ab;", 1, -2);
				this._nav_py.ttip = Calendar._TT["PREV_YEAR"];

				this._nav_pm = hh("&#x2039;", 1, -1);
				this._nav_pm.ttip = Calendar._TT["PREV_MONTH"];

				this._nav_now = hh(Calendar._TT["TODAY"], this.weekNumbers ? 4 : 3, 0);
				this._nav_now.ttip = Calendar._TT["GO_TODAY"];

				this._nav_nm = hh("&#x203a;", 1, 1);
				this._nav_nm.ttip = Calendar._TT["NEXT_MONTH"];

				this._nav_ny = hh("&#x00bb;", 1, 2);
				this._nav_ny.ttip = Calendar._TT["NEXT_YEAR"];

				// day names
				row = Calendar.createElement("tr", thead);
				row.className = "daynames";
				if (this.weekNumbers) {
					cell = Calendar.createElement("td", row);
					cell.className = "name wn";
					cell.innerHTML = Calendar._TT["WK"];
				}
				for (var i = 7; i > 0; --i) {
					cell = Calendar.createElement("td", row);
					if (!i) {
						cell.navtype = 100;
						cell.calendar = this;
						Calendar._add_evs(cell);
					}
				}
				this.firstdayname = (this.weekNumbers) ? row.firstChild.nextSibling : row.firstChild;
				this._displayWeekdays();

				var tbody = Calendar.createElement("tbody", table);
				this.tbody = tbody;

				for (i = 6; i > 0; --i) {
					row = Calendar.createElement("tr", tbody);
					if (this.weekNumbers) {
						cell = Calendar.createElement("td", row);
					}
					for (var j = 7; j > 0; --j) {
						cell = Calendar.createElement("td", row);
						cell.calendar = this;
						Calendar._add_evs(cell);
					}
				}

				if (this.showsTime) {
					row = Calendar.createElement("tr", tbody);
					row.className = "time";

					cell = Calendar.createElement("td", row);
					cell.className = "time";
					cell.colSpan = 2;
					cell.innerHTML = Calendar._TT["TIME"] || "&nbsp;";

					cell = Calendar.createElement("td", row);
					cell.className = "time";
					cell.colSpan = this.weekNumbers ? 4 : 3;

					(function(){
						function makeTimePart(className, init, range_start, range_end) {
							var part = Calendar.createElement("span", cell);
							part.className = className;
							part.innerHTML = init;
							part.calendar = cal;
							part.ttip = Calendar._TT["TIME_PART"];
							part.navtype = 50;
							part._range = [];
							if (typeof range_start != "number")
							part._range = range_start;
							else {
								for (var i = range_start; i <= range_end; ++i) {
									var txt;
									if (i < 10 && range_end >= 10) txt = '0' + i;
									else txt = '' + i;
									part._range[part._range.length] = txt;
								}
							}
							Calendar._add_evs(part);
							return part;
						};
						var hrs = cal.date.getHours();
						var mins = cal.date.getMinutes();
						var t12 = !cal.time24;
						var pm = (hrs > 12);
						if (t12 && pm) hrs -= 12;
						var H = makeTimePart("hour", hrs, t12 ? 1 : 0, t12 ? 12 : 23);
						var span = Calendar.createElement("span", cell);
						span.innerHTML = ":";
						span.className = "colon";
						var M = makeTimePart("minute", mins, 0, 59);
						var AP = null;
						cell = Calendar.createElement("td", row);
						cell.className = "time";
						cell.colSpan = 2;
						if (t12)
						AP = makeTimePart("ampm", pm ? "pm" : "am", ["am", "pm"]);
						else
						cell.innerHTML = "&nbsp;";

						cal.onSetTime = function() {
							var pm, hrs = this.date.getHours(),
							mins = this.date.getMinutes();
							if (t12) {
								pm = (hrs >= 12);
								if (pm) hrs -= 12;
								if (hrs == 0) hrs = 12;
								AP.innerHTML = pm ? "pm" : "am";
							}
							H.innerHTML = (hrs < 10) ? ("0" + hrs) : hrs;
							M.innerHTML = (mins < 10) ? ("0" + mins) : mins;
						};

						cal.onUpdateTime = function() {
							var date = this.date;
							var h = parseInt(H.innerHTML, 10);
							if (t12) {
								if (/pm/i.test(AP.innerHTML) && h < 12)
								h += 12;
								else if (/am/i.test(AP.innerHTML) && h == 12)
								h = 0;
							}
							var d = date.getDate();
							var m = date.getMonth();
							var y = date.getFullYear();
							date.setHours(h);
							date.setMinutes(parseInt(M.innerHTML, 10));
							date.setFullYear(y);
							date.setMonth(m);
							date.setDate(d);
							this.dateClicked = false;
							this.callHandler();
						};
					})();
				} else {
					this.onSetTime = this.onUpdateTime = function() {};
				}

				var tfoot = Calendar.createElement("tfoot", table);

				row = Calendar.createElement("tr", tfoot);
				row.className = "footrow";

				cell = hh(Calendar._TT["SEL_DATE"], this.weekNumbers ? 8 : 7, 300);
				cell.className = "ttip";
				if (this.isPopup) {
					cell.ttip = Calendar._TT["DRAG_TO_MOVE"];
					cell.style.cursor = "move";
				}
				this.tooltips = cell;

				div = Calendar.createElement("div", this.element);
				this.monthsCombo = div;
				div.className = "combo";
				for (i = 0; i < Calendar._MN.length; ++i) {
					var mn = Calendar.createElement("div");
					mn.className = Calendar.is_ie ? "label-IEfix" : "label";
					mn.month = i;
					mn.innerHTML = Calendar._SMN[i];
					div.appendChild(mn);
				}

				div = Calendar.createElement("div", this.element);
				this.yearsCombo = div;
				div.className = "combo";
				for (i = 12; i > 0; --i) {
					var yr = Calendar.createElement("div");
					yr.className = Calendar.is_ie ? "label-IEfix" : "label";
					div.appendChild(yr);
				}

				this._init(this.firstDayOfWeek, this.date);
				parent.appendChild(this.element);
			};

			/** keyboard navigation, only for popup calendars */
			Calendar._keyEvent = function(ev) {
				var cal = window._dynarch_popupCalendar;
				if (!cal || cal.multiple)
				return false;
				(Calendar.is_ie) && (ev = window.event);
				var act = (Calendar.is_ie || ev.type == "keypress"),
				K = ev.keyCode;
				if (ev.ctrlKey) {
					switch (K) {
						case 37: // KEY left
						act && Calendar.cellClick(cal._nav_pm);
						break;
						case 38: // KEY up
						act && Calendar.cellClick(cal._nav_py);
						break;
						case 39: // KEY right
						act && Calendar.cellClick(cal._nav_nm);
						break;
						case 40: // KEY down
						act && Calendar.cellClick(cal._nav_ny);
						break;
						default:
						return false;
					}
				} else switch (K) {
					case 32: // KEY space (now)
					Calendar.cellClick(cal._nav_now);
					break;
					case 27: // KEY esc
					act && cal.callCloseHandler();
					break;
					case 37: // KEY left
					case 38: // KEY up
					case 39: // KEY right
					case 40: // KEY down
					if (act) {
						var prev, x, y, ne, el, step;
						prev = K == 37 || K == 38;
						step = (K == 37 || K == 39) ? 1 : 7;
						function setVars() {
							el = cal.currentDateEl;
							var p = el.pos;
							x = p & 15;
							y = p >> 4;
							ne = cal.ar_days[y][x];
						};setVars();
						function prevMonth() {
							var date = new Date(cal.date);
							date.setDate(date.getDate() - step);
							cal.setDate(date);
						};
						function nextMonth() {
							var date = new Date(cal.date);
							date.setDate(date.getDate() + step);
							cal.setDate(date);
						};
						while (1) {
							switch (K) {
								case 37: // KEY left
								if (--x >= 0)
								ne = cal.ar_days[y][x];
								else {
									x = 6;
									K = 38;
									continue;
								}
								break;
								case 38: // KEY up
								if (--y >= 0)
								ne = cal.ar_days[y][x];
								else {
									prevMonth();
									setVars();
								}
								break;
								case 39: // KEY right
								if (++x < 7)
								ne = cal.ar_days[y][x];
								else {
									x = 0;
									K = 40;
									continue;
								}
								break;
								case 40: // KEY down
								if (++y < cal.ar_days.length)
								ne = cal.ar_days[y][x];
								else {
									nextMonth();
									setVars();
								}
								break;
							}
							break;
						}
						if (ne) {
							if (!ne.disabled)
							Calendar.cellClick(ne);
							else if (prev)
							prevMonth();
							else
							nextMonth();
						}
					}
					break;
					case 13: // KEY enter
					if (act)
					Calendar.cellClick(cal.currentDateEl, ev);
					break;
					default:
					return false;
				}
				return Calendar.stopEvent(ev);
			};

			/**
			*  (RE)Initializes the calendar to the given date and firstDayOfWeek
			*/
			Calendar.prototype._init = function (firstDayOfWeek, date) {
				var today = new Date(),
				TY = today.getFullYear(),
				TM = today.getMonth(),
				TD = today.getDate();
				this.table.style.visibility = "hidden";
				var year = date.getFullYear();
				if (year < this.minYear) {
					year = this.minYear;
					date.setFullYear(year);
				} else if (year > this.maxYear) {
					year = this.maxYear;
					date.setFullYear(year);
				}
				this.firstDayOfWeek = firstDayOfWeek;
				this.date = new Date(date);
				var month = date.getMonth();
				var mday = date.getDate();
				var no_days = date.getMonthDays();

				// calendar voodoo for computing the first day that would actually be
				// displayed in the calendar, even if it's from the previous month.
				// WARNING: this is magic. ;-)
				date.setDate(1);
				var day1 = (date.getDay() - this.firstDayOfWeek) % 7;
				if (day1 < 0)
				day1 += 7;
				date.setDate(-day1);
				date.setDate(date.getDate() + 1);

				var row = this.tbody.firstChild;
				var MN = Calendar._SMN[month];
				var ar_days = this.ar_days = new Array();
				var weekend = Calendar._TT["WEEKEND"];
				var dates = this.multiple ? (this.datesCells = {}) : null;
				for (var i = 0; i < 6; ++i, row = row.nextSibling) {
					var cell = row.firstChild;
					if (this.weekNumbers) {
						cell.className = "day wn";
						cell.innerHTML = date.getWeekNumber();
						cell = cell.nextSibling;
					}
					row.className = "daysrow";
					var hasdays = false, iday, dpos = ar_days[i] = [];
					for (var j = 0; j < 7; ++j, cell = cell.nextSibling, date.setDate(iday + 1)) {
						iday = date.getDate();
						var wday = date.getDay();
						cell.className = "day";
						cell.pos = i << 4 | j;
						dpos[j] = cell;
						var current_month = (date.getMonth() == month);
						if (!current_month) {
							if (this.showsOtherMonths) {
								cell.className += " othermonth";
								cell.otherMonth = true;
							} else {
								cell.className = "emptycell";
								cell.innerHTML = "&nbsp;";
								cell.disabled = true;
								continue;
							}
						} else {
							cell.otherMonth = false;
							hasdays = true;
						}
						cell.disabled = false;
						cell.innerHTML = this.getDateText ? this.getDateText(date, iday) : iday;
						if (dates)
						dates[date.print("%Y%m%d")] = cell;
						if (this.getDateStatus) {
							var status = this.getDateStatus(date, year, month, iday);
							if (this.getDateToolTip) {
								var toolTip = this.getDateToolTip(date, year, month, iday);
								if (toolTip)
								cell.title = toolTip;
							}
							if (status === true) {
								cell.className += " disabled";
								cell.disabled = true;
							} else {
								if (/disabled/i.test(status))
								cell.disabled = true;
								cell.className += " " + status;
							}
						}
						if (!cell.disabled) {
							cell.caldate = new Date(date);
							cell.ttip = "_";
							if (!this.multiple && current_month
							&& iday == mday && this.hiliteToday) {
								cell.className += " selected";
								this.currentDateEl = cell;
							}
							if (date.getFullYear() == TY &&
							date.getMonth() == TM &&
							iday == TD) {
								cell.className += " today";
								cell.ttip += Calendar._TT["PART_TODAY"];
							}
							if (weekend.indexOf(wday.toString()) != -1)
							cell.className += cell.otherMonth ? " oweekend" : " weekend";
						}
					}
					if (!(hasdays || this.showsOtherMonths))
					row.className = "emptyrow";
				}
				this.title.innerHTML = Calendar._MN[month] + ", " + year;
				this.onSetTime();
				this.table.style.visibility = "visible";
				this._initMultipleDates();
				// PROFILE
				// this.tooltips.innerHTML = "Generated in " + ((new Date()) - today) + " ms";
			};

			Calendar.prototype._initMultipleDates = function() {
				if (this.multiple) {
					for (var i in this.multiple) {
						var cell = this.datesCells[i];
						var d = this.multiple[i];
						if (!d)
						continue;
						if (cell)
						cell.className += " selected";
					}
				}
			};

			Calendar.prototype._toggleMultipleDate = function(date) {
				if (this.multiple) {
					var ds = date.print("%Y%m%d");
					var cell = this.datesCells[ds];
					if (cell) {
						var d = this.multiple[ds];
						if (!d) {
							Calendar.addClass(cell, "selected");
							this.multiple[ds] = date;
						} else {
							Calendar.removeClass(cell, "selected");
							delete this.multiple[ds];
						}
					}
				}
			};

			Calendar.prototype.setDateToolTipHandler = function (unaryFunction) {
				this.getDateToolTip = unaryFunction;
			};

			/**
			*  Calls _init function above for going to a certain date (but only if the
			*  date is different than the currently selected one).
			*/
			Calendar.prototype.setDate = function (date) {
				if (!date.equalsTo(this.date)) {
					this._init(this.firstDayOfWeek, date);
				}
			};

			/**
			*  Refreshes the calendar.  Useful if the "disabledHandler" function is
			*  dynamic, meaning that the list of disabled date can change at runtime.
			*  Just * call this function if you think that the list of disabled dates
			*  should * change.
			*/
			Calendar.prototype.refresh = function () {
				this._init(this.firstDayOfWeek, this.date);
			};

			/** Modifies the "firstDayOfWeek" parameter (pass 0 for Synday, 1 for Monday, etc.). */
			Calendar.prototype.setFirstDayOfWeek = function (firstDayOfWeek) {
				this._init(firstDayOfWeek, this.date);
				this._displayWeekdays();
			};

			/**
			*  Allows customization of what dates are enabled.  The "unaryFunction"
			*  parameter must be a function object that receives the date (as a JS Date
			*  object) and returns a boolean value.  If the returned value is true then
			*  the passed date will be marked as disabled.
			*/
			Calendar.prototype.setDateStatusHandler = Calendar.prototype.setDisabledHandler = function (unaryFunction) {
				this.getDateStatus = unaryFunction;
			};

			/** Customization of allowed year range for the calendar. */
			Calendar.prototype.setRange = function (a, z) {
				this.minYear = a;
				this.maxYear = z;
			};

			/** Calls the first user handler (selectedHandler). */
			Calendar.prototype.callHandler = function () {
				if (this.onSelected) {
					this.onSelected(this, this.date.print(this.dateFormat));
				}
			};

			/** Calls the second user handler (closeHandler). */
			Calendar.prototype.callCloseHandler = function () {
				if (this.onClose) {
					this.onClose(this);
				}
				this.hideShowCovered();
			};

			/** Removes the calendar object from the DOM tree and destroys it. */
			Calendar.prototype.destroy = function () {
				var el = this.element.parentNode;
				el.removeChild(this.element);
				Calendar._C = null;
				window._dynarch_popupCalendar = null;
			};

			/**
			*  Moves the calendar element to a different section in the DOM tree (changes
			*  its parent).
			*/
			Calendar.prototype.reparent = function (new_parent) {
				var el = this.element;
				el.parentNode.removeChild(el);
				new_parent.appendChild(el);
			};

			// This gets called when the user presses a mouse button anywhere in the
			// document, if the calendar is shown.  If the click was outside the open
			// calendar this function closes it.
			Calendar._checkCalendar = function(ev) {
				var calendar = window._dynarch_popupCalendar;
				if (!calendar) {
					return false;
				}
				var el = Calendar.is_ie ? Calendar.getElement(ev) : Calendar.getTargetElement(ev);
				for (; el != null && el != calendar.element; el = el.parentNode);
				if (el == null) {
					// calls closeHandler which should hide the calendar.
					window._dynarch_popupCalendar.callCloseHandler();
					return Calendar.stopEvent(ev);
				}
			};

			/** Shows the calendar. */
			Calendar.prototype.show = function () {
				var rows = this.table.getElementsByTagName("tr");
				for (var i = rows.length; i > 0;) {
					var row = rows[--i];
					Calendar.removeClass(row, "rowhilite");
					var cells = row.getElementsByTagName("td");
					for (var j = cells.length; j > 0;) {
						var cell = cells[--j];
						Calendar.removeClass(cell, "hilite");
						Calendar.removeClass(cell, "active");
					}
				}
				this.element.style.display = "block";
				this.hidden = false;
				if (this.isPopup) {
					window._dynarch_popupCalendar = this;
					Calendar.addEvent(document, "keydown", Calendar._keyEvent);
					Calendar.addEvent(document, "keypress", Calendar._keyEvent);
					Calendar.addEvent(document, "mousedown", Calendar._checkCalendar);
				}
				this.hideShowCovered();
			};

			/**
			*  Hides the calendar.  Also removes any "hilite" from the class of any TD
			*  element.
			*/
			Calendar.prototype.hide = function () {
				if (this.isPopup) {
					Calendar.removeEvent(document, "keydown", Calendar._keyEvent);
					Calendar.removeEvent(document, "keypress", Calendar._keyEvent);
					Calendar.removeEvent(document, "mousedown", Calendar._checkCalendar);
				}
				this.element.style.display = "none";
				this.hidden = true;
				this.hideShowCovered();
			};

			/**
			*  Shows the calendar at a given absolute position (beware that, depending on
			*  the calendar element style -- position property -- this might be relative
			*  to the parent's containing rectangle).
			*/
			Calendar.prototype.showAt = function (x, y) {
				var s = this.element.style;
				s.left = x + "px";
				s.top = y + "px";
				this.show();
			};

			/** Shows the calendar near a given element. */
			Calendar.prototype.showAtElement = function (el, opts) {
				var self = this;
				var p = Calendar.getAbsolutePos(el);
				if (!opts || typeof opts != "string") {
					this.showAt(p.x, p.y + el.offsetHeight);
					return true;
				}
				function fixPosition(box) {
					if (box.x < 0)
					box.x = 0;
					if (box.y < 0)
					box.y = 0;
					var cp = document.createElement("div");
					var s = cp.style;
					s.position = "absolute";
					s.right = s.bottom = s.width = s.height = "0px";
					document.body.appendChild(cp);
					var br = Calendar.getAbsolutePos(cp);
					document.body.removeChild(cp);
					if (Calendar.is_ie) {
						br.y += document.body.scrollTop;
						br.x += document.body.scrollLeft;
					} else {
						br.y += window.scrollY;
						br.x += window.scrollX;
					}
					var tmp = box.x + box.width - br.x;
					if (tmp > 0) box.x -= tmp;
					tmp = box.y + box.height - br.y;
					if (tmp > 0) box.y -= tmp;
				};
				this.element.style.display = "block";
				Calendar.continuation_for_the_fucking_khtml_browser = function() {
					var w = self.element.offsetWidth;
					var h = self.element.offsetHeight;
					self.element.style.display = "none";
					var valign = opts.substr(0, 1);
					var halign = "l";
					if (opts.length > 1) {
						halign = opts.substr(1, 1);
					}
					// vertical alignment
					switch (valign) {
						case "T": p.y -= h; break;
						case "B": p.y += el.offsetHeight; break;
						case "C": p.y += (el.offsetHeight - h) / 2; break;
						case "t": p.y += el.offsetHeight - h; break;
						case "b": break; // already there
					}
					// horizontal alignment
					switch (halign) {
						case "L": p.x -= w; break;
						case "R": p.x += el.offsetWidth; break;
						case "C": p.x += (el.offsetWidth - w) / 2; break;
						case "l": p.x += el.offsetWidth - w; break;
						case "r": break; // already there
					}
					p.width = w;
					p.height = h + 40;
					self.monthsCombo.style.display = "none";
					fixPosition(p);
					self.showAt(p.x, p.y);
				};
				if (Calendar.is_khtml)
				setTimeout("Calendar.continuation_for_the_fucking_khtml_browser()", 10);
				else
				Calendar.continuation_for_the_fucking_khtml_browser();
			};

			/** Customizes the date format. */
			Calendar.prototype.setDateFormat = function (str) {
				this.dateFormat = str;
			};

			/** Customizes the tooltip date format. */
			Calendar.prototype.setTtDateFormat = function (str) {
				this.ttDateFormat = str;
			};

			/**
			*  Tries to identify the date represented in a string.  If successful it also
			*  calls this.setDate which moves the calendar to the given date.
			*/
			Calendar.prototype.parseDate = function(str, fmt) {
				if (!fmt)
				fmt = this.dateFormat;
				this.setDate(Date.parseDate(str, fmt));
			};

			Calendar.prototype.hideShowCovered = function () {
				if (!Calendar.is_ie && !Calendar.is_opera)
				return;
				function getVisib(obj){
					var value = obj.style.visibility;
					if (!value) {
						if (document.defaultView && typeof (document.defaultView.getComputedStyle) == "function") { // Gecko, W3C
							if (!Calendar.is_khtml)
							value = document.defaultView.
							getComputedStyle(obj, "").getPropertyValue("visibility");
							else
							value = '';
						} else if (obj.currentStyle) { // IE
							value = obj.currentStyle.visibility;
						} else
						value = '';
					}
					return value;
				};

				var tags = new Array("applet", "iframe", "select");
				var el = this.element;

				var p = Calendar.getAbsolutePos(el);
				var EX1 = p.x;
				var EX2 = el.offsetWidth + EX1;
				var EY1 = p.y;
				var EY2 = el.offsetHeight + EY1;

				for (var k = tags.length; k > 0; ) {
					var ar = document.getElementsByTagName(tags[--k]);
					var cc = null;

					for (var i = ar.length; i > 0;) {
						cc = ar[--i];

						p = Calendar.getAbsolutePos(cc);
						var CX1 = p.x;
						var CX2 = cc.offsetWidth + CX1;
						var CY1 = p.y;
						var CY2 = cc.offsetHeight + CY1;

						if (this.hidden || (CX1 > EX2) || (CX2 < EX1) || (CY1 > EY2) || (CY2 < EY1)) {
							if (!cc.__msh_save_visibility) {
								cc.__msh_save_visibility = getVisib(cc);
							}
							cc.style.visibility = cc.__msh_save_visibility;
						} else {
							if (!cc.__msh_save_visibility) {
								cc.__msh_save_visibility = getVisib(cc);
							}
							cc.style.visibility = "hidden";
						}
					}
				}
			};

			/** Internal function; it displays the bar with the names of the weekday. */
			Calendar.prototype._displayWeekdays = function () {
				var fdow = this.firstDayOfWeek;
				var cell = this.firstdayname;
				var weekend = Calendar._TT["WEEKEND"];
				for (var i = 0; i < 7; ++i) {
					cell.className = "day name";
					var realday = (i + fdow) % 7;
					if (i) {
						cell.ttip = Calendar._TT["DAY_FIRST"].replace("%s", Calendar._DN[realday]);
						cell.navtype = 100;
						cell.calendar = this;
						cell.fdow = realday;
						Calendar._add_evs(cell);
					}
					if (weekend.indexOf(realday.toString()) != -1) {
						Calendar.addClass(cell, "weekend");
					}
					cell.innerHTML = Calendar._SDN[(i + fdow) % 7];
					cell = cell.nextSibling;
				}
			};

			/** Internal function.  Hides all combo boxes that might be displayed. */
			Calendar.prototype._hideCombos = function () {
				this.monthsCombo.style.display = "none";
				this.yearsCombo.style.display = "none";
			};

			/** Internal function.  Starts dragging the element. */
			Calendar.prototype._dragStart = function (ev) {
				if (this.dragging) {
					return;
				}
				this.dragging = true;
				var posX;
				var posY;
				if (Calendar.is_ie) {
					posY = window.event.clientY + document.body.scrollTop;
					posX = window.event.clientX + document.body.scrollLeft;
				} else {
					posY = ev.clientY + window.scrollY;
					posX = ev.clientX + window.scrollX;
				}
				var st = this.element.style;
				this.xOffs = posX - parseInt(st.left);
				this.yOffs = posY - parseInt(st.top);
				with (Calendar) {
					addEvent(document, "mousemove", calDragIt);
					addEvent(document, "mouseup", calDragEnd);
				}
			};

			// BEGIN: DATE OBJECT PATCHES

			/** Adds the number of days array to the Date object. */
			Date._MD = new Array(31,28,31,30,31,30,31,31,30,31,30,31);

			/** Constants used for time computations */
			Date.SECOND = 1000 /* milliseconds */;
			Date.MINUTE = 60 * Date.SECOND;
			Date.HOUR   = 60 * Date.MINUTE;
			Date.DAY    = 24 * Date.HOUR;
			Date.WEEK   =  7 * Date.DAY;

			Date.parseDate = function(str, fmt) {
				var today = new Date();
				var y = 0;
				var m = -1;
				var d = 0;
				var a = str.split(/\W+/);
				var b = fmt.match(/%./g);
				var i = 0, j = 0;
				var hr = 0;
				var min = 0;
				for (i = 0; i < a.length; ++i) {
					if (!a[i])
					continue;
					switch (b[i]) {
						case "%d":
						case "%e":
						d = parseInt(a[i], 10);
						break;

						case "%m":
						m = parseInt(a[i], 10) - 1;
						break;

						case "%Y":
						case "%y":
						y = parseInt(a[i], 10);
						(y < 100) && (y += (y > 29) ? 1900 : 2000);
						break;

						case "%b":
						case "%B":
						for (j = 0; j < 12; ++j) {
							if (Calendar._MN[j].substr(0, a[i].length).toLowerCase() == a[i].toLowerCase()) { m = j; break; }
						}
						break;

						case "%H":
						case "%I":
						case "%k":
						case "%l":
						hr = parseInt(a[i], 10);
						break;

						case "%P":
						case "%p":
						if (/pm/i.test(a[i]) && hr < 12)
						hr += 12;
						else if (/am/i.test(a[i]) && hr >= 12)
						hr -= 12;
						break;

						case "%M":
						min = parseInt(a[i], 10);
						break;
					}
				}
				if (isNaN(y)) y = today.getFullYear();
				if (isNaN(m)) m = today.getMonth();
				if (isNaN(d)) d = today.getDate();
				if (isNaN(hr)) hr = today.getHours();
				if (isNaN(min)) min = today.getMinutes();
				if (y != 0 && m != -1 && d != 0)
				return new Date(y, m, d, hr, min, 0);
				y = 0; m = -1; d = 0;
				for (i = 0; i < a.length; ++i) {
					if (a[i].search(/[a-zA-Z]+/) != -1) {
						var t = -1;
						for (j = 0; j < 12; ++j) {
							if (Calendar._MN[j].substr(0, a[i].length).toLowerCase() == a[i].toLowerCase()) { t = j; break; }
						}
						if (t != -1) {
							if (m != -1) {
								d = m+1;
							}
							m = t;
						}
					} else if (parseInt(a[i], 10) <= 12 && m == -1) {
						m = a[i]-1;
					} else if (parseInt(a[i], 10) > 31 && y == 0) {
						y = parseInt(a[i], 10);
						(y < 100) && (y += (y > 29) ? 1900 : 2000);
					} else if (d == 0) {
						d = a[i];
					}
				}
				if (y == 0)
				y = today.getFullYear();
				if (m != -1 && d != 0)
				return new Date(y, m, d, hr, min, 0);
				return today;
			};

			/** Returns the number of days in the current month */
			Date.prototype.getMonthDays = function(month) {
				var year = this.getFullYear();
				if (typeof month == "undefined") {
					month = this.getMonth();
				}
				if (((0 == (year%4)) && ( (0 != (year%100)) || (0 == (year%400)))) && month == 1) {
					return 29;
				} else {
					return Date._MD[month];
				}
			};

			/** Returns the number of day in the year. */
			Date.prototype.getDayOfYear = function() {
				var now = new Date(this.getFullYear(), this.getMonth(), this.getDate(), 0, 0, 0);
				var then = new Date(this.getFullYear(), 0, 0, 0, 0, 0);
				var time = now - then;
				return Math.floor(time / Date.DAY);
			};

			/** Returns the number of the week in year, as defined in ISO 8601. */
			Date.prototype.getWeekNumber = function() {
				var d = new Date(this.getFullYear(), this.getMonth(), this.getDate(), 0, 0, 0);
				var DoW = d.getDay();
				d.setDate(d.getDate() - (DoW + 6) % 7 + 3); // Nearest Thu
				var ms = d.valueOf(); // GMT
				d.setMonth(0);
				d.setDate(4); // Thu in Week 1
				return Math.round((ms - d.valueOf()) / (7 * 864e5)) + 1;
			};

			/** Checks date and time equality */
			Date.prototype.equalsTo = function(date) {
				return ((this.getFullYear() == date.getFullYear()) &&
				(this.getMonth() == date.getMonth()) &&
				(this.getDate() == date.getDate()) &&
				(this.getHours() == date.getHours()) &&
				(this.getMinutes() == date.getMinutes()));
			};

			/** Set only the year, month, date parts (keep existing time) */
			Date.prototype.setDateOnly = function(date) {
				var tmp = new Date(date);
				this.setDate(1);
				this.setFullYear(tmp.getFullYear());
				this.setMonth(tmp.getMonth());
				this.setDate(tmp.getDate());
			};

			/** Prints the date in a string according to the given format. */
			Date.prototype.print = function (str) {
				var m = this.getMonth();
				var d = this.getDate();
				var y = this.getFullYear();
				var wn = this.getWeekNumber();
				var w = this.getDay();
				var s = {};
				var hr = this.getHours();
				var pm = (hr >= 12);
				var ir = (pm) ? (hr - 12) : hr;
				var dy = this.getDayOfYear();
				if (ir == 0)
				ir = 12;
				var min = this.getMinutes();
				var sec = this.getSeconds();
				s["%a"] = Calendar._SDN[w]; // abbreviated weekday name [FIXME: I18N]
				s["%A"] = Calendar._DN[w]; // full weekday name
				s["%b"] = Calendar._SMN[m]; // abbreviated month name [FIXME: I18N]
				s["%B"] = Calendar._MN[m]; // full month name
				// FIXME: %c : preferred date and time representation for the current locale
				s["%C"] = 1 + Math.floor(y / 100); // the century number
				s["%d"] = (d < 10) ? ("0" + d) : d; // the day of the month (range 01 to 31)
				s["%e"] = d; // the day of the month (range 1 to 31)
				// FIXME: %D : american date style: %m/%d/%y
				// FIXME: %E, %F, %G, %g, %h (man strftime)
				s["%H"] = (hr < 10) ? ("0" + hr) : hr; // hour, range 00 to 23 (24h format)
				s["%I"] = (ir < 10) ? ("0" + ir) : ir; // hour, range 01 to 12 (12h format)
				s["%j"] = (dy < 100) ? ((dy < 10) ? ("00" + dy) : ("0" + dy)) : dy; // day of the year (range 001 to 366)
				s["%k"] = hr;		// hour, range 0 to 23 (24h format)
				s["%l"] = ir;		// hour, range 1 to 12 (12h format)
				s["%m"] = (m < 9) ? ("0" + (1+m)) : (1+m); // month, range 01 to 12
				s["%M"] = (min < 10) ? ("0" + min) : min; // minute, range 00 to 59
				s["%n"] = "\n";		// a newline character
				s["%p"] = pm ? "PM" : "AM";
				s["%P"] = pm ? "pm" : "am";
				// FIXME: %r : the time in am/pm notation %I:%M:%S %p
				// FIXME: %R : the time in 24-hour notation %H:%M
				s["%s"] = Math.floor(this.getTime() / 1000);
				s["%S"] = (sec < 10) ? ("0" + sec) : sec; // seconds, range 00 to 59
				s["%t"] = "\t";		// a tab character
				// FIXME: %T : the time in 24-hour notation (%H:%M:%S)
				s["%U"] = s["%W"] = s["%V"] = (wn < 10) ? ("0" + wn) : wn;
				s["%u"] = w + 1;	// the day of the week (range 1 to 7, 1 = MON)
				s["%w"] = w;		// the day of the week (range 0 to 6, 0 = SUN)
				// FIXME: %x : preferred date representation for the current locale without the time
				// FIXME: %X : preferred time representation for the current locale without the date
				s["%y"] = ('' + y).substr(2, 2); // year without the century (range 00 to 99)
				s["%Y"] = y;		// year with the century
				s["%%"] = "%";		// a literal '%' character

				var re = /%./g;
				if (!Calendar.is_ie5 && !Calendar.is_khtml)
				return str.replace(re, function (par) { return s[par] || par; });

				var a = str.match(re);
				for (var i = 0; i < a.length; i++) {
					var tmp = s[a[i]];
					if (tmp) {
						re = new RegExp(a[i], 'g');
						str = str.replace(re, tmp);
					}
				}

				return str;
			};

			Date.prototype.__msh_oldSetFullYear = Date.prototype.setFullYear;
			Date.prototype.setFullYear = function(y) {
				var d = new Date(this);
				d.__msh_oldSetFullYear(y);
				if (d.getMonth() != this.getMonth())
				this.setDate(28);
				this.__msh_oldSetFullYear(y);
			};

			// END: DATE OBJECT PATCHES


			// global object that remembers the calendar
			window._dynarch_popupCalendar = null;


			// ** I18N

			// Calendar ES (spanish) language
			// Author: Mihai Bazon, <mihai_bazon@yahoo.com>
			// Updater: Servilio Afre Puentes <servilios@yahoo.com>
			// Updated: 2004-06-03
			// Encoding: utf-8
			// Distributed under the same terms as the calendar itself.

			// For translators: please use UTF-8 if possible.  We strongly believe that
			// Unicode is the answer to a real internationalized world.  Also please
			// include your contact information in the header, as can be seen above.

			// full day names
			Calendar._DN = new Array
			("Domingo",
			"Lunes",
			"Martes",
			"Miércoles",
			"Jueves",
			"Viernes",
			"Sábado",
			"Domingo");

			// Please note that the following array of short day names (and the same goes
			// for short month names, _SMN) isn't absolutely necessary.  We give it here
			// for exemplification on how one can customize the short day names, but if
			// they are simply the first N letters of the full name you can simply say:
			//
			//   Calendar._SDN_len = N; // short day name length
			//   Calendar._SMN_len = N; // short month name length
			//
			// If N = 3 then this is not needed either since we assume a value of 3 if not
			// present, to be compatible with translation files that were written before
			// this feature.

			// short day names
			Calendar._SDN = new Array
			("Dom",
			"Lun",
			"Mar",
			"Mié",
			"Jue",
			"Vie",
			"Sáb",
			"Dom");

			// First day of the week. "0" means display Sunday first, "1" means display
			// Monday first, etc.
			Calendar._FD = 1;

			// full month names
			Calendar._MN = new Array
			("Enero",
			"Febrero",
			"Marzo",
			"Abril",
			"Mayo",
			"Junio",
			"Julio",
			"Agosto",
			"Septiembre",
			"Octubre",
			"Noviembre",
			"Diciembre");

			// short month names
			Calendar._SMN = new Array
			("Ene",
			"Feb",
			"Mar",
			"Abr",
			"May",
			"Jun",
			"Jul",
			"Ago",
			"Sep",
			"Oct",
			"Nov",
			"Dic");

			// tooltips
			Calendar._TT = {};
			Calendar._TT["INFO"] = "Acerca del calendario";

			Calendar._TT["ABOUT"] =
			"Selector DHTML de Fecha/Hora\n" +
			"(c) dynarch.com 2002-2005 / Author: Mihai Bazon\n" + // don't translate this this ;-)
			"Para conseguir la última versión visite: http://www.dynarch.com/projects/calendar/\n" +
			"Distribuido bajo licencia GNU LGPL. Visite http://gnu.org/licenses/lgpl.html para más detalles." +
			"\n\n" +
			"Selección de fecha:\n" +
			"- Use los botones \xab, \xbb para seleccionar el año\n" +
			"- Use los botones " + String.fromCharCode(0x2039) + ", " + String.fromCharCode(0x203a) + " para seleccionar el mes\n" +
			"- Mantenga pulsado el ratón en cualquiera de estos botones para una selección rápida.";
			Calendar._TT["ABOUT_TIME"] = "\n\n" +
			"Selección de hora:\n" +
			"- Pulse en cualquiera de las partes de la hora para incrementarla\n" +
			"- o pulse las mayúsculas mientras hace clic para decrementarla\n" +
			"- o haga clic y arrastre el ratón para una selección más rápida.";

			Calendar._TT["PREV_YEAR"] = "Año anterior (mantener para menú)";
			Calendar._TT["PREV_MONTH"] = "Mes anterior (mantener para menú)";
			Calendar._TT["GO_TODAY"] = "Ir a hoy";
			Calendar._TT["NEXT_MONTH"] = "Mes siguiente (mantener para menú)";
			Calendar._TT["NEXT_YEAR"] = "Año siguiente (mantener para menú)";
			Calendar._TT["SEL_DATE"] = "Seleccionar fecha";
			Calendar._TT["DRAG_TO_MOVE"] = "Arrastrar para mover";
			Calendar._TT["PART_TODAY"] = " (hoy)";

			// the following is to inform that "%s" is to be the first day of week
			// %s will be replaced with the day name.
			Calendar._TT["DAY_FIRST"] = "Hacer %s primer día de la semana";

			// This may be locale-dependent.  It specifies the week-end days, as an array
			// of comma-separated numbers.  The numbers are from 0 to 6: 0 means Sunday, 1
			// means Monday, etc.
			Calendar._TT["WEEKEND"] = "0,6";

			Calendar._TT["CLOSE"] = "Cerrar";
			Calendar._TT["TODAY"] = "Hoy";
			Calendar._TT["TIME_PART"] = "(Mayúscula-)Clic o arrastre para cambiar valor";

			// date formats
			Calendar._TT["DEF_DATE_FORMAT"] = "%d/%m/%Y";
			Calendar._TT["TT_DATE_FORMAT"] = "%A, %e de %B de %Y";

			Calendar._TT["WK"] = "sem";
			Calendar._TT["TIME"] = "Hora:";



			/*  Copyright Mihai Bazon, 2002, 2003  |  http://dynarch.com/mishoo/
			* ---------------------------------------------------------------------------
			*
			* The DHTML Calendar
			*
			* Details and latest version at:
			* http://dynarch.com/mishoo/calendar.epl
			*
			* This script is distributed under the GNU Lesser General Public License.
			* Read the entire license text here: http://www.gnu.org/licenses/lgpl.html
			*
			* This file defines helper functions for setting up the calendar.  They are
			* intended to help non-programmers get a working calendar on their site
			* quickly.  This script should not be seen as part of the calendar.  It just
			* shows you what one can do with the calendar, while in the same time
			* providing a quick and simple method for setting it up.  If you need
			* exhaustive customization of the calendar creation process feel free to
			* modify this code to suit your needs (this is recommended and much better
			* than modifying calendar.js itself).
			*/

			// $Id: clase_formulario.php,v 1.10 2007/06/01 16:02:14 Abraham Castro Exp $

			/**
			*  This function "patches" an input field (or other element) to use a calendar
			*  widget for date selection.
			*
			*  The "params" is a single object that can have the following properties:
			*
			*    prop. name   | description
			*  -------------------------------------------------------------------------------------------------
			*   inputField    | the ID of an input field to store the date
			*   displayArea   | the ID of a DIV or other element to show the date
			*   button        | ID of a button or other element that will trigger the calendar
			*   eventName     | event that will trigger the calendar, without the "on" prefix (default: "click")
			*   ifFormat      | date format that will be stored in the input field
			*   daFormat      | the date format that will be used to display the date in displayArea
			*   singleClick   | (true/false) wether the calendar is in single click mode or not (default: true)
			*   firstDay      | numeric: 0 to 6.  "0" means display Sunday first, "1" means display Monday first, etc.
			*   align         | alignment (default: "Br"); if you don't know what's this see the calendar documentation
			*   range         | array with 2 elements.  Default: [1900, 2999] -- the range of years available
			*   weekNumbers   | (true/false) if it's true (default) the calendar will display week numbers
			*   flat          | null or element ID; if not null the calendar will be a flat calendar having the parent with the given ID
			*   flatCallback  | function that receives a JS Date object and returns an URL to point the browser to (for flat calendar)
			*   disableFunc   | function that receives a JS Date object and should return true if that date has to be disabled in the calendar
			*   onSelect      | function that gets called when a date is selected.  You don't _have_ to supply this (the default is generally okay)
			*   onClose       | function that gets called when the calendar is closed.  [default]
			*   onUpdate      | function that gets called after the date is updated in the input field.  Receives a reference to the calendar.
			*   date          | the date that the calendar will be initially displayed to
			*   showsTime     | default: false; if true the calendar will include a time selector
			*   timeFormat    | the time format; can be "12" or "24", default is "12"
			*   electric      | if true (default) then given fields/date areas are updated for each move; otherwise they're updated only on close
			*   step          | configures the step of the years in drop-down boxes; default: 2
			*   position      | configures the calendar absolute position; default: null
			*   cache         | if "true" (but default: "false") it will reuse the same calendar object, where possible
			*   showOthers    | if "true" (but default: "false") it will show days from other months too
			*
			*  None of them is required, they all have default values.  However, if you
			*  pass none of "inputField", "displayArea" or "button" you'll get a warning
			*  saying "nothing to setup".
			*/
			Calendar.setup = function (params) {
				function param_default(pname, def) { if (typeof params[pname] == "undefined") { params[pname] = def; } };

				param_default("inputField",     null);
				param_default("displayArea",    null);
				param_default("button",         null);
				param_default("eventName",      "click");
				param_default("ifFormat",       "%Y/%m/%d");
				param_default("daFormat",       "%Y/%m/%d");
				param_default("singleClick",    true);
				param_default("disableFunc",    null);
				param_default("dateStatusFunc", params["disableFunc"]);	// takes precedence if both are defined
				param_default("dateText",       null);
				param_default("firstDay",       null);
				param_default("align",          "Br");
				param_default("range",          [1900, 2999]);
				param_default("weekNumbers",    true);
				param_default("flat",           null);
				param_default("flatCallback",   null);
				param_default("onSelect",       null);
				param_default("onClose",        null);
				param_default("onUpdate",       null);
				param_default("date",           null);
				param_default("showsTime",      false);
				param_default("timeFormat",     "24");
				param_default("electric",       true);
				param_default("step",           2);
				param_default("position",       null);
				param_default("cache",          false);
				param_default("showOthers",     false);
				param_default("multiple",       null);

				var tmp = ["inputField", "displayArea", "button"];
				for (var i in tmp) {
					if (typeof params[tmp[i]] == "string") {
						params[tmp[i]] = document.getElementById(params[tmp[i]]);
					}
				}
				if (!(params.flat || params.multiple || params.inputField || params.displayArea || params.button)) {
					alert("Calendar.setup:\n  Nothing to setup (no fields found).  Please check your code");
					return false;
				}

				function onSelect(cal) {
					var p = cal.params;
					var update = (cal.dateClicked || p.electric);
					if (update && p.inputField) {
						p.inputField.value = cal.date.print(p.ifFormat);
						if (typeof p.inputField.onchange == "function")
						p.inputField.onchange();
					}
					if (update && p.displayArea)
					p.displayArea.innerHTML = cal.date.print(p.daFormat);
					if (update && typeof p.onUpdate == "function")
					p.onUpdate(cal);
					if (update && p.flat) {
						if (typeof p.flatCallback == "function")
						p.flatCallback(cal);
					}
					if (update && p.singleClick && cal.dateClicked)
					cal.callCloseHandler();
				};

				if (params.flat != null) {
					if (typeof params.flat == "string")
					params.flat = document.getElementById(params.flat);
					if (!params.flat) {
						alert("Calendar.setup:\n  Flat specified but can't find parent.");
						return false;
					}
					var cal = new Calendar(params.firstDay, params.date, params.onSelect || onSelect);
					cal.showsOtherMonths = params.showOthers;
					cal.showsTime = params.showsTime;
					cal.time24 = (params.timeFormat == "24");
					cal.params = params;
					cal.weekNumbers = params.weekNumbers;
					cal.setRange(params.range[0], params.range[1]);
					cal.setDateStatusHandler(params.dateStatusFunc);
					cal.getDateText = params.dateText;
					if (params.ifFormat) {
						cal.setDateFormat(params.ifFormat);
					}
					if (params.inputField && typeof params.inputField.value == "string") {
						cal.parseDate(params.inputField.value);
					}
					cal.create(params.flat);
					cal.show();
					return false;
				}

				var triggerEl = params.button || params.displayArea || params.inputField;
				triggerEl["on" + params.eventName] = function() {
					var dateEl = params.inputField || params.displayArea;
					var dateFmt = params.inputField ? params.ifFormat : params.daFormat;
					var mustCreate = false;
					var cal = window.calendar;
					if (dateEl)
					params.date = Date.parseDate(dateEl.value || dateEl.innerHTML, dateFmt);
					if (!(cal && params.cache)) {
						window.calendar = cal = new Calendar(params.firstDay,
						params.date,
						params.onSelect || onSelect,
						params.onClose || function(cal) { cal.hide(); });
						cal.showsTime = params.showsTime;
						cal.time24 = (params.timeFormat == "24");
						cal.weekNumbers = params.weekNumbers;
						mustCreate = true;
					} else {
						if (params.date)
						cal.setDate(params.date);
						cal.hide();
					}
					if (params.multiple) {
						cal.multiple = {};
						for (var i = params.multiple.length; --i >= 0;) {
							var d = params.multiple[i];
							var ds = d.print("%Y%m%d");
							cal.multiple[ds] = d;
						}
					}
					cal.showsOtherMonths = params.showOthers;
					cal.yearStep = params.step;
					cal.setRange(params.range[0], params.range[1]);
					cal.params = params;
					cal.setDateStatusHandler(params.dateStatusFunc);
					cal.getDateText = params.dateText;
					cal.setDateFormat(dateFmt);
					if (mustCreate)
					cal.create();
					cal.refresh();
					if (!params.position)
					cal.showAtElement(params.button || params.displayArea || params.inputField, params.align);
					else
					cal.showAt(params.position[0], params.position[1]);
					return false;
				};

				return cal;
			};

			</script>
<?php }

}
?>
