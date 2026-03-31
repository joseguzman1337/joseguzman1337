<?php
class formulario
{
	/**
	 * variables de la clase
	 */
	var $nombre;
	var $metodo;
	var $accion;
	var $validacion;
	var $mensajegeneral;
	var $array_validacion;

	function formulario($nombre,$metodo,$accion="",$validar=false,$mensajegeneral="")
	{
		$this->nombre=$nombre;
		$this->metodo=$metodo;
		$this->accion=$accion;
		$this->validar=$validar;
		$this->mensajegeneral=$mensajegeneral;
	}

	function campotexto($nombrevar,$tamano=20,$validacion="",$mensaje="",$ayuda="")
	{
		if($ayuda!="")
		{
			$globo=$this->globo($ayuda);
		}
		if($this->metodo=='get' or $this->metodo=='GET')
		{
			echo "<table border='0'><tr><td>\n";
			echo "<input name='$nombrevar' type='text' id='$nombrevar' value='".$_GET[$nombrevar]."' size='$tamano'>\n";
			echo "</td></tr>\n";
		}
		elseif ($this->metodo=='post' or $this->metodo=='POST')
		{
			echo "<input name='$nombrevar' type='text' id='$nombrevar' value='".$_POST[$nombrevar]."' size='$tamano' $globo>\n";
		}
		if($validacion!="")
		{
			if($this->metodo=='get' or $this->metodo=='GET')
			{
				$this->array_validacion=array('valido',$this->validacion($_GET[$nombrevar],$validacion,$mensaje));
			}
			elseif ($this->metodo=='post' or $this->metodo=='POST')
			{
				$this->array_validacion=array('campo'=>$nombrevar,'valido'=>$this->validacion($_POST[$nombrevar],$validacion,$mensaje),'mensaje'=>$mensaje);
			}
		}

		echo "</table>\n";
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
				elseif(!ereg("^(2[0-9]{3})-([1-9]{1}|0[1-9]{1}|1[0-2]{1})-([1-9]{1}|[0-2]{1}[1-9]{1}|3[0-1]{1}|10|20)$", $nombrevar, $regs))
				{
					$valido = 0;
				}
				if(!checkdate($regs[2],$regs[3],$regs[1]))
				{
					$valido = 0;
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
			echo "<span class='Estilo99'>*</span>";
		}
		return $valido;
	}

	function globo($mensaje)
	{
		$globo=" onMouseover='showtip2(this,event,".'"'.$mensaje.'"'.")' onMouseout='hidetip2()'";
		return $globo;
	}

	function script_globo()
	{
		echo '<script type="text/javascript" src="globo.js"></script>';
		echo "\n";
		echo '<div id="tooltip2" style="position:absolute;visibility:hidden;clip:rect(0 150 50 0);width:150px;background-color:lightyellow"><layer name="nstip" width=1000px bgColor="lightyellow"></layer></div>';
		echo "\n";
	}
}
?>
