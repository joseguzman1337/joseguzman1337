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
	var $mensajegeneral;
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
	var $rutaraiz;


	function formulario(&$conexion,$nombre,$metodo,$accion="",$validar=false,$mensajegeneral='Los campos marcados con *, no han sido correctamente diligenciados:\n\n',$archivo_formulario="",$debug=false,$rutaraiz="../../../../",$scriptglobo=1)
	{
		$this->rutaraiz=$rutaraiz;
		$this->debug=$debug;
		$this->nombre=$nombre;
		$this->metodo=$metodo;
		$this->accion=$accion;
		$this->validar=$validar;
		$this->conexion=$conexion;
		$this->mensajegeneral=$mensajegeneral;
		$this->automatico=$automatico;
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
		if($scriptglobo)
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

	function combo($nombre,$tabla_destino,$metodo,$tabla_origen,$dato_insertar,$dato_mostrar,$where="",$orderby="",$accion="",$validacion="",$mensaje="",$ayuda="")
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
		"<select name='$nombre' id='$nombre' $accion>\n
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

	function combo_valor_por_defecto($nombre,$tabla_destino,$metodo,$tabla_origen,$dato_insertar,$dato_mostrar,$valor_por_defecto,$where="",$orderby="",$accion="",$validacion="",$mensaje="",$ayuda="")
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
		"<select name='$nombre' id='$nombre' $accion>\n";
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


	function combo_array($nombre,$tabla_destino,$metodo,$array,$dato_insertar,$dato_mostrar,$accion="",$validacion="",$mensaje="",$ayuda="")
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
		"<select name='$nombre' id='$nombre' $accion>\n
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

	function memo($nombre,$tabla_destino,$columnas,$filas,$validacion="",$mensaje="",$ayuda="",$accion="")
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

		echo "<textarea name='$nombre' id='$nombre' cols='$columnas' rows='$filas' wrap='VIRTUAL'>$valor</textarea>$cadena\n";

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

	function campotexto($nombre,$tabla_destino,$tamano=20,$validacion="",$mensaje="",$ayuda="",$accion="")
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

		echo "<input name='$nombre' type='text' id='$nombre' value='".$valor."' size='$tamano'>$cadena\n";

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

	function celda_vertical_memo($nombre,$etiqueta,$tabla_destino,$columnas,$filas,$validacion="",$mensaje="",$ayuda="",$accion="")
	{
		echo "<tr>\n";
		echo "<td  nowrap id='tdtitulogris' colspan='2'>\n";
		$this->etiqueta($nombre,$etiqueta,$validacion);
		echo "</td>\n";
		echo "</tr>\n";
		echo "<tr>\n";
		echo "<td colspan='2'>";
		$this->memo($nombre,$tabla_destino,$columnas,$filas,'','',$ayuda,$accion);
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
			echo "<caption align=LEFT><h4>$titulo</h4></caption>";
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
							//echo "<br>",$query,"<br>";
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
		$query="SELECT p.codigoperiodo FROM periodo p WHERE p.codigoestadoperiodo like '$codigoestadoperiodo%'";
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
                                                if(isset($valor['campo'])&&$valor['campo']!=''){
						$this->array_datos_cargados[$valor['tabla']]->$valor['campo']=$valor_arreglo['valor'];
                                                }
						foreach ($arreglo as $llave => $valor_arreglo)
						{
							$this->array_datos_cargados[$valor['tabla']]->$valor_arreglo['campo']=$valor_arreglo['valor'];
							{
                                                            if(isset($llave_anterior)&&$llave_anterior!=''){
								$this->array_datos_cargados[$valor['tabla']]->$llave_anterior=$valor_anterior;
                                                            }
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
		//echo "<br><br>".$nombre." validacion=".$validacion." mertodo=".$this->metodo." <br><br>";
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
				//echo "<label id='labelresaltado'>*</label>";
				echo "<label id='labelasterisco'>*</label>";
			}
		}
		elseif ($this->metodo=='get' or $this->metodo=='GET')
		{
			if($_GET[$nombre]=="")
			{
				//echo "<label id='labelresaltado'>*</label>";
				echo "<label id='labelasterisco'>*</label>";
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
			case "fechanacimiento":
				// Para fechas < a 2000 formato dd/mm/yyyy
				//$regs = array();
				if($nombrevar == '')
				{
					$valido = 0;
				}
				elseif(!ereg("^([1-9]{1}|[0-2]{1}[1-9]{1}|3[0-1]{1}|10|20)\/([1-9]{1}|0[1-9]{1}|1[0-2]{1})\/(1[0-9]{3})$", $nombrevar, $regs))
				{
					$valido = 0;
					echo $nombrevar."<br>";
				}
				elseif(!checkdate($regs[2],$regs[1],$regs[3]))
				{
					$valido = 0;
				}
				break;
		}

		if($valido==0)
		{
			echo "<label id='labelasterisco'>*</label>";
		}
		return $valido;
		}

		function depurar()
		{

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
			/*echo "this->array_validacion<pre>";
			print_r($this->array_validacion);
			echo "<pre>";*/

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

		/*function conecta_sap()
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
		}*/

		function globo($mensaje)
		{
			$globo=" onMouseover='showtip2(this,event,".'"'.$mensaje.'"'.")' onMouseout='hidetip2()'";
			return $globo;
		}

		function script_globo()
		{
			/*echo '<script type="text/javascript">
			if (!document.layers&&!document.all)
			event="test"
			function showtip2(current,e,text){
			if (document.all&&document.readyState=="complete"){
			document.all.tooltip2.innerHTML="<marquee style="border:1px solid black">"+text+"</marquee>"
			document.all.tooltip2.style.pixelLeft=event.clientX+document.body.scrollLeft+10
			document.all.tooltip2.style.pixelTop=event.clientY+document.body.scrollTop+10
			document.all.tooltip2.style.visibility="visible"
			}
			else if (document.layers){
			document.tooltip2.document.nstip.document.write("<b>"+text+"</b>")
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
			</script>';
			echo "\n";
			*/
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


		function javaScript()
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
<script language="javascript">
function abrir(pagina,ventana,parametros)
{
	window.open(pagina,ventana,parametros);
}
function enviar()
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
}
?>
