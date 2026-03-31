<?php 
require_once('funcioneshora.php'); 
class grupo
{
	var $idgrupo;
	var $codigogrupo;
	var $nombregrupo;
	var $codigomateria;
	var $codigomaterianovasoft;
	var $codigoperiodo;
	var $numerodocumento; // Número de documento del profesor
	var $maximogrupo;
	var $matriculadosgrupo;
	var $horario; // Horarios que va a tener el grupo, se insertan en un arreglo el "objeto horario"
	var $numerohorassemanales; // Número de horas que tiene la materia semanalmente
 	var $numerohorashorario; // Número de horas que tiene el grupo asignados a un horario en fromato número
	var $horashorario; // Número de horas que tiene el grupo asignados a un horario en formato hora 00:00:00
	//var $guardado; // Indica si el objeto inicializado fue alguna vez guardado
	var $numerohorarios; // Indica la cantidad de horarios asignadoas a un grupo
	var $tienecabecera; // Indica si el objeto posee cabecera, es decir si existe el grupo
	var $tienegrupo; // Indica si el objeto tiene o no tienen un grupo asignado
	//var $tienehorario; // Indica si el objeto tiene un horario asignado
	var $nombredocente;
	var $apellidodocente;
	var $tienedocente; // Indica si el objeto tiene una docente asignado al grupo
	var $tienehorariocompleto; // Indica si el objeto tiene un horario con el número total de horas semanales
	var $tienematriculados; // Indica si el objeto tiene estudiantes matriculados
	var $horariohistorico; // Se guarda en esta variable el horario historico si lo hay, es decir el que viene de la base de datos
	var $tienehistorico; // Se guarda en esta variable el horario historico si lo hay, es decir el que viene de la base de datos
	var $eliminado;
	function grupo($idgrupo=0)
	{
		$this->idgrupo=$idgrupo;
		//$this->guardado=false;
		$this->tienecabecera=false;
		$this->tienehorario=false;
		$this->tienegrupo=false;
		$this->tienedocente=false;
		$this->tienehorariocompleto=false;
		$this->numerohorarios=0;
		$this->numerohorashorario=0;
		$this->horashorario="00:00";
		$this->numerohorassemanales=0;
		$this->tienehistorico=false;
		$this->eliminado=false;
	}
	function valoresiniciales($codigomateria,$codigomaterianovasoft,$codigoperiodo,$numerohorassemanales)
	{
		$this->codigomateria=$codigomateria;
		$this->codigomaterianovasoft=$codigomaterianovasoft;
		$this->codigoperiodo=$codigoperiodo;
		$this->numerohorassemanales=$numerohorassemanales;
	}
	function cabeceragrupo($numerodocumento,$nombregrupo,$maximogrupo,$codigogrupo,$nombredocente,$apellidodocente, $matriculadosgrupo = 0)
	{
		$this->numerodocumento=$numerodocumento;
		$this->nombregrupo=$nombregrupo;
		$this->maximogrupo=$maximogrupo;
		$this->codigogrupo=$codigogrupo;
		$this->nombredocente=$nombredocente;
		$this->apellidodocente=$apellidodocente;
		$this->matriculadosgrupo=$matriculadosgrupo;
		$this->tienecabecera=true;
		$this->tienegrupo=true;
		if($numerodocumento != 1)
		{
			$this->tienedocente=true;
		}
		if($matriculadosgrupo == 0)
		{
			$this->tienematriculados = false;
		}
		else
		{
			$this->tienematriculados = true;
		}
	}
	function horariogrupo($horariogrupo,$horariohistorico = 0)
	{
		$this->numerohorarios++;
		$horariogrupo['horas'] = restarhoras($horariogrupo['horafinal'],$horariogrupo['horainicial']);
		//echo "<br>RESTA f".restarhoras($horariogrupo['horafinal'],$horariogrupo['horainicial']);
		//echo "<br>RESTA".$horariogrupo['horas'];
		$horariogrupo['horainicial']=$horariogrupo['horainicial'].":00";
		$horariogrupo['horafinal']=$horariogrupo['horafinal'].":00";
		$this->horashorario = sumarhoras($this->horashorario,$horariogrupo['horas']);
		$this->horario[$this->numerohorarios]=$horariogrupo;
		$this->horariohistorico[$this->numerohorarios]=$horariohistorico;
		$this->tienehorario=true;
	}
	/*function horariohistorico($horariohistorico)
	{
		$horariohistorico['horainicial']=$horariohistorico['horainicial'].":00";
		$horariohistorico['horafinal']=$horariohistorico['horafinal'].":00";
		$this->horariohistorico=$horariohistorico;
	}
	*/
	function editarhorariogrupo($horariogrupo,$idhorario)
	{
		//$this->numerohorarios++;
		$horario = $this->horario[$idhorario];
		$horariogrupo['estado'] = $horario['estado'];
		$this->horashorario = restarhoras($this->horashorario,$horario['horas']);
		$horariogrupo['horas'] = restarhoras($horariogrupo['horafinal'],$horariogrupo['horainicial']);
		//echo "<br>RESTA f".restarhoras($horariogrupo['horafinal'],$horariogrupo['horainicial']);
		//echo "<br>RESTA".$horariogrupo['horas'];
		$horariogrupo['horainicial']=$horariogrupo['horainicial'].":00";
		$horariogrupo['horafinal']=$horariogrupo['horafinal'].":00";
		$this->horashorario = sumarhoras($this->horashorario,$horariogrupo['horas']);
		$this->horario[$idhorario]=$horariogrupo;
	}
	function imprima($valor)
	{
		switch($valor)
		{
			case "nombregrupo":
				echo " ".$this->nombregrupo." ";
			break;
			case "maximogrupo":
				echo " ".$this->maximogrupo." ";
			break;
			case "matriculadosgrupo":
				echo " ".$this->matriculadosgrupo." ";
			break;
			case "numerohorassemanales":
				echo " ".$this->numerohorassemanales." ";
			break;
			case "numerohorashorario":
				echo " ".$this->numerohorashorario." ";
			break;
			case "numerodocumento":
				echo " ".$this->numerodocumeto." ";
			break;
			case "nombredocente":
				echo " ".$this->nombredocente." ";
			break;
			case "apellidodocente":
				echo " ".$this->apellidodocente." ";
			break;
			case "horario":
			$cuentahorario = 1;
			while($cuentahorario <= $this->numerohorarios)
			{
				$horario = $this->horario[$cuentahorario];
				if($horario['estado'] != "eliminado")
				{
?>
				  <tr>
					<td><?php echo " ".$horario['nombredia']." ";?></td>
					<td><?php echo " ".$horario['horainicial']." "; ?></td>
					<td><?php echo " ".$horario['horafinal']." "; ?></td>
					<td><?php echo " ".$horario['nombresede']." "; ?></td>
					<td><?php echo " ".$horario['nombresalon']." ".$horario['codigosalon']." "; ?></td>
					<td><?php echo " ".$horario['nombretiposalon']." "; ?></td>
	  			  </tr>
<?php
				}
				$cuentahorario++;
			}
			break;
			case "horariodos":
			$cuentahorario = 1;
			while($cuentahorario <= $this->numerohorarios)
			{
				$horario = $this->horario[$cuentahorario];
				if($horario['estado'] != "eliminado")
				{	
?>
				  <tr>
					<td><?php echo " ".$horario['nombredia']." ";?></td>
					<td><?php echo " ".$horario['horainicial']." "; ?></td>
					<td><?php echo " ".$horario['horafinal']." "; ?></td>
				  </tr>
<?php
				}
				$cuentahorario++;
			}
			break;
			case "horariotres":
			$cuentahorario = 1;
			while($cuentahorario <= $this->numerohorarios)
			{
				$horario = $this->horario[$cuentahorario];
				if($horario['estado'] != "eliminado")
				{	
?>
				  <tr>
					<td><?php echo " ".$horario['nombredia']." ";?></td>
					<td><?php echo " ".$horario['horainicial']." "; ?></td>
					<td><?php echo " ".$horario['horafinal']." "; ?></td>
					<td align="center"><input type="radio" name="editarhorario" value="<?php echo $cuentahorario; ?>" <?php if($cuentahorario == 1) echo "checked"; ?>></td>
				  </tr>
<?php
				}
				$cuentahorario++;
			}
			break;
		}
	}
	function modificardocente($numerodocumento, $nombredocente, $apellidodocente)
	{
		$this->numerodocumento = $numerodocumento;
		$this->nombredocente = $nombredocente;
		$this->apellidodocente = $apellidodocente;
	}
	function modificarmaximogrupo($maximogrupo)
	{
		$this->maximogrupo = $maximogrupo;
	}
	function modificarnumerohorashorario($numerohorashorario)
	{
		if(!$this->tienehorariocompleto)
		{
			$horas = formatearhora($numerohorashorario/100);
			$horas = ereg_replace(":","",$horas);
			$numerohorassemanales = formatearhora($this->numerohorassemanales);
			$numerohorassemanales = ereg_replace(":","",$numerohorassemanales);
			$numerohoras = $this->numerohorashorario+$horas;
			$numerohoras = formatearhora($numerohoras/100);
			$numerohoras = ereg_replace(":","",$numerohoras);
			if($numerohoras < $this->numerohorassemanales*100) 
			{
				$this->numerohorashorario=$numerohoras;
			}
			if($numerohoras == $this->numerohorassemanales*100) 
			{
				$this->numerohorashorario=$numerohoras;
				$this->tienehorariocompleto=true;
			}
		}
	}
	function tienecruces($hini,$hfin,$dia1,$idhorario = 0)
	{
		$hinicial1 = ereg_replace(":","",$hini);
		$hfinal1 = ereg_replace(":","",$hfin);
		//echo "idhorario: $idhorario<br>";
		//echo "cruceini1: $hinicial1<br>";
		//echo "crucefin1: $hfinal1<br>";
		if($this->numerohorarios == 0)
			return false;
		$cuentahorario = 1;
		while($cuentahorario <= $this->numerohorarios)
		{
			//echo "entr<br>";
			if($idhorario != $cuentahorario)
				$horario = $this->horario[$cuentahorario];
			if($horario['estado']!="eliminado")
			{	
				$dia2 = $horario['codigodia'];
				//echo "DIA2: $dia2 <br>";
				if($dia1 == $dia2)
				{
					$horario['horainicial'];
					$horario['horafinal'];
					$hinicial2 = ereg_replace(":","",$horario['horainicial']);
					$hfinal2 = ereg_replace(":","",$horario['horafinal']);
					//echo "cruceini2: $hinicial2<br>";
					//echo "crucefin2: $hfinal2<br>";
					if(($hinicial2 < $hinicial1) && ($hfinal2 > $hinicial1))
						return true;
					if(($hfinal2 > $hfinal1) && ($hinicial2 < $hfinal1))
						return true;
					if(($hfinal2 == $hfinal1) && ($hinicial2 == $hinicial1))
						return true;
				}
			}
			$cuentahorario++;
		}
		return false;
	}
	//1
	function idgrupo()
	{
		return $this->idgrupo;
	}
	//2
	function codigogrupo()
	{
		return $this->codigogrupo;
	}
	//3
	function nombregrupo()
	{
		return $this->nombregrupo;
	}
	//4
	function codigomateria()
	{
		return $this->codigomateria;
	}
	//5
	function codigomaterianovasoft()
	{
		return $this->codigomaterianovasoft;
	}
	//6
	function codigoperiodo()
	{
		return $this->codigoperiodo;
	}
	//7
	function numerodocumento()
	{
		return $this->numerodocumento;
	}
	//8
	function maximogrupo()
	{
		return $this->maximogrupo;
	}
	//9
	function matriculadosgrupo()
	{
		return $this->matriculadosgrupo;
	}
	//10
	function numerohorassemanales()
	{
		return $this->numerohorassemanales;
	}
	//11
	function guardado()
	{
		return $this->guardado;
	}
	//12
	function numerohorarios()
	{
		return $this->numerohorarios;
	}
	//13
	function nombredocente()
	{
		return $this->nombredocente;
	}
	//14
	function apellidodocente()
	{
		return $this->apellidodocente;
	}
	//15
	function horashorario()
	{
		return $this->horashorario;
	}
	//16
	function horario($cuentahorario)
	{
		return $this->horario[$cuentahorario];
	}
	function horarios()
	{
		return $this->horario;
	}
	//17
	function horahorario($cuentahorario)
	{
		$horario = $this->horario[$cuentahorario];
		return $horario['horas'];
	}
	//18
	function numerohorashorario()
	{
		return $this->numerohorashorario;
	}
	//19
	function tienecabecera()
	{
		return $this->tienecabecera;
	}
	//20
	function tienedocente()
	{
		return $this->tienedocente;
	}
	//21
	function tienegrupo()
	{
		return $this->tienegrupo;
	}
	//22
	/*function tienehorario()
	{
		return $this->tienehorario;
	}*/
	//23
	function tienehorariocompleto()
	{
		return $this->tienehorariocompleto;
	}
	//24
	function tienematriculados()
	{
		return $this->tienematriculados;
	}
	function horariohistorico()
	{
		return $this->horariohistorico;
	}
	function adicionarhistorico()
	{
		$this->tienehistorico = true;
	}
	function eliminarhorario($idhorario)
	{
		$horariogrupo = $this->horario[$idhorario];
		$horariogrupo['estado'] = "eliminado";
		$this->horashorario = restarhoras($this->horashorario,$horariogrupo['horas']);
		$this->horario[$idhorario] = $horariogrupo;
	}
	function eliminado()
	{
		return $this->eliminado;
	}
	function eliminar()
	{
		$this->eliminado = true;
	}
	function tienehorario()
	{
		if($this->numerohorarios == 0)
			return false;
		$cuentahorario = 1;
		while($cuentahorario <= $this->numerohorarios)
		{
			$horario = $this->horario[$cuentahorario];
			if($horario['estado'] != "eliminado")
			{
				return true;
			}
			$cuentahorario++;
		}
		return false;		
	}
	/*function nuevoidgrupo($nuevoidgrupo)
	{
		$this->idgrupo=$nuevoidgrupo;
	}*/
}
?>
