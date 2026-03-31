<?php
class asignacionAutomaticaSalones{
	var $conexion;
	var $array_periodo;
	var $idsubperiodo;
	var $codigocarrera;
	var $idadmision;
	var $idinscripcion;
	var $array_salones_admision;
	var $array_salones_admision_disponibles;
	var $numerodocumento;
	var $codigoestudiante;
	var $fechahoy;
	var $direccionsitioadmision;
	var $depurar;
	var $array_admision;
	var $seAsignoSalon=false;
	var $array_asignacion_salon;

	function asignacionAutomaticaSalones(&$conexion,$codigocarrera,$numerodocumento,$depurar=false){
		$this->depurar=$depurar;
		$this->fechahoy=date("Y-m-d H:i:s");
		$this->conexion=$conexion;
		$this->conexion->SetFetchMode(ADODB_FETCH_ASSOC);
		$this->codigocarrera=$codigocarrera;
		$this->numerodocumento=$numerodocumento;
		$this->leePeriodoCodigoestadoperiodo(4);
		$this->leeCarreraPeriodoSubperiodosRecibePeriodo($this->codigocarrera,$this->array_periodo['codigoperiodo']);
		$this->LeerIdadmision($this->codigocarrera,$this->idsubperiodo);
		$this->ObtenerSalonesdelaAdmision($this->codigocarrera,$this->idsubperiodo);
		$this->DeterminarSalonesConCupo($this->array_salones_admision,$this->codigocarrera,$this->idsubperiodo);
		$this->leeCodigoestudianteInscripcion($this->numerodocumento,$this->codigocarrera,$this->array_periodo['codigoperiodo']);
		$this->AsignarSalonesConCupoCodigoestudiante($this->codigoestudiante,$this->array_salones_admision_disponibles);
	}


	function leeCodigoestudianteInscripcion($numerodocumento,$codigocarrera,$codigoperiodo){
		/*$query="SELECT e.codigoestudiante,i.idinscripcion
		FROM estudiante e, inscripcion i, estudiantecarrerainscripcion eci, estudiantegeneral eg
		WHERE 
		i.codigoperiodo='$codigoperiodo'
		AND i.idinscripcion = eci.idinscripcion
		AND eci.codigocarrera='$codigocarrera'
		AND e.idestudiantegeneral=eg.idestudiantegeneral
		AND i.codigoperiodo='$codigoperiodo'
		AND eg.numerodocumento='$numerodocumento'
		";*/
		$query="SELECT e.codigoestudiante,i.idinscripcion
		FROM estudiante e, inscripcion i, estudiantecarrerainscripcion eci, estudiantegeneral eg
		WHERE 
		i.codigoperiodo='$codigoperiodo'
		AND i.idinscripcion = eci.idinscripcion
		AND eci.codigocarrera='$codigocarrera'
		AND e.codigocarrera='$codigocarrera'
		AND e.idestudiantegeneral=eg.idestudiantegeneral
		AND i.idestudiantegeneral=eg.idestudiantegeneral
		AND eg.numerodocumento='$numerodocumento'
		";
		$row_eci=$this->Query($query,true);
		$this->codigoestudiante=$row_eci['codigoestudiante'];
		$this->idinscripcion=$row_eci['idinscripcion'];
		if(empty($this->codigoestudiante)){
			echo "<h1>No existe codigoestudiante, no se puede continuar</h1>";
			exit();
		}
	}

	function leePeriodoCodigoestadoperiodo($codigoestadoperiodo){
		$query="SELECT p.* FROM periodo p WHERE p.codigoestadoperiodo='$codigoestadoperiodo'";
		$this->array_periodo=$this->Query($query,true);
		if(!is_array($this->array_periodo)){
			echo "<h1>No existe periodo, no se puede continuar</h1>";
			exit();
		}
	}

	function leeCarreraPeriodoSubperiodosRecibePeriodo($codigocarrera,$codigoperiodo)
	{
		$query="SELECT sp.idsubperiodo
		FROM subperiodo sp, carreraperiodo cp
		WHERE
		cp.codigoperiodo='".$codigoperiodo."'
		AND sp.codigoestadosubperiodo like '1%'
		AND sp.idcarreraperiodo=cp.idcarreraperiodo
		AND cp.codigocarrera='".$codigocarrera."'
		";
		$row_subperiodo=$this->Query($query);
		$this->idsubperiodo=$row_subperiodo['idsubperiodo'];
		if(empty($this->idsubperiodo)){
			echo "<h1>No existe subperiodo, no se puede continuar</h1>";
			exit();
		}
	}

	function LeerIdadmision($codigocarrera,$idsubperiodo)
	{
		$query_idadmision="
		SELECT a.* FROM
		admision a
		WHERE
		a.codigocarrera='$codigocarrera'
		AND a.idsubperiodo='$idsubperiodo'
		AND a.codigoestado='100'
		";
		$operacion_idadmision=$this->conexion->query($query_idadmision);
		$row_idadmision=$operacion_idadmision->fetchRow();
		$this->idadmision=$row_idadmision['idadmision'];
		$this->array_admision=$row_idadmision;
		if(empty($this->idadmision)){
			echo "<h1>No existe idadmision, no se puede continuar</h1>";
			exit();
		}

	}

	function ObtenerSalonesdelaAdmision($codigocarrera,$idsubperiodo)
	{
		$query="SELECT
		a.idadmision, s.codigosalon, s.cupomaximosalon, hdsa.idhorariodetallesitioadmision
		FROM
		admision a, detallesitioadmision dsa, salon s, horariodetallesitioadmision hdsa
		WHERE
		a.idadmision=dsa.idadmision
		AND dsa.codigosalon=s.codigosalon
		AND dsa.iddetallesitioadmision=hdsa.iddetallesitioadmision
		AND a.codigocarrera='$codigocarrera'
		AND a.idsubperiodo='$idsubperiodo'
		AND a.codigoestado=100
		AND hdsa.codigoestado=100
		AND dsa.codigoestado=100
		";
		$this->array_salones_admision=$this->Query($query,false);
	}

	function DeterminarSalonesConCupo($array_salones,$codigocarrera,$idsubperiodo)
	{
		foreach ($array_salones as $llave => $valor)
		{
			$query="
			SELECT dsa.codigosalon
			FROM
			admision a, detallesitioadmision dsa, horariodetallesitioadmision hdsa, estudianteadmision ea, detalleestudianteadmision dea
			WHERE
			a.codigocarrera='$codigocarrera'
			AND a.idsubperiodo='$idsubperiodo'
			AND a.idadmision=dsa.idadmision
			AND a.idadmision=ea.idadmision
			AND ea.idestudianteadmision=dea.idestudianteadmision
			AND dea.idhorariodetallesitioadmision=hdsa.idhorariodetallesitioadmision
			AND dsa.iddetallesitioadmision=hdsa.iddetallesitioadmision
			AND dsa.codigosalon='".$valor['codigosalon']."'
			AND a.codigoestado=100
			AND ea.codigoestado=100
			AND dea.codigoestado=100
			AND hdsa.codigoestado=100
			AND dsa.codigoestado=100
			GROUP BY ea.codigoestudiante
			";
			if($this->depurar==true)
			{
				$this->conexion->debug=true;
			}
			$operacion=$this->conexion->query($query);
			$row_operacion=$operacion->fetchRow();
			$numRows=$operacion->numRows();
			do
			{
				$disponibles=$valor['cupomaximosalon']-$numRows;
				//echo "cupo maximo salon: ".$valor['cupomaximosalon']," Cupo usado: ",$numRows," Disponibles $disponibles<br>";
				//echo $numRows,"<br><br><br>";
				if($disponibles >= 1)
				{
					$this->array_salones_admision_disponibles[]=array('codigosalon'=>$valor['codigosalon'],'disponibles'=>$disponibles,'idhorariodetallesitioadmision'=>$valor['idhorariodetallesitioadmision']);
				}
			}
			while ($row_operacion=$operacion->fetchRow());
		}
		if($this->depurar==true)
		{
			echo "idsubperiodo $idsubperiodo<br>";
			$this->DibujarTablaNormal($this->array_salones_admision_disponibles,"Salones con cupo disponible");
			echo "Cantidad registros: ".count($this->array_salones_admision_disponibles)."<br>";
			$this->conexion->debug=false;
		}
		return $array_interno;
	}


	function AsignarSalonesConCupoCodigoestudiante($codigoestudiante,$array_salones_con_cupo)
	{
		$sePuedeAsignarSalon=false;

		foreach ($array_salones_con_cupo as $llave_salones => $valor_salones)
		{
			$codigosalon=null;
			//echo $valor_salones['disponibles'],"<br>";
			$CantidadDisponibleEstudiantesParaAsignar=$valor_salones['disponibles'];
			if($CantidadDisponibleEstudiantesParaAsignar > 0)
			{
				$sePuedeAsignarSalon=true;
				$codigosalon=$valor_salones['codigosalon'];
				//echo "<br>asignar $codigosalon<br>";
				break;
			}

		}
		if($sePuedeAsignarSalon==true){
			$arrayHorarioSalon=$this->leeHorarioSalon($codigosalon,$this->idadmision);
			if(!is_array($arrayHorarioSalon)){
				echo "<h1>No existe parametrización de horario para este salon, no se puede continuar</h1>";
				exit();
			}
			else{

				$array_parametros_admision=$this->leerParametrizacionPruebasAdmision($this->idadmision);
				if(is_array($array_parametros_admision))
				{

					$verificaAsignacion=$this->verificaSiHaySalonAsignado($codigoestudiante);
					if(!$verificaAsignacion){
						//echo "<h1>Entro 4</h1>";

						$query_estudianteadmision="INSERT INTO estudianteadmision
					(idestudianteadmision, idadmision,fechaestudianteadmision,codigoestudiante, idinscripcion, codigoestado,codigoestadoestudianteadmision) 
					VALUES ('', '$this->idadmision', '$this->fechahoy', '".$codigoestudiante."','".$this->idinscripcion."', '100', '100')";
						$operacion_estudianteadmision=$this->conexion->query($query_estudianteadmision);
						$idestudianteadmision=$this->conexion->Insert_ID();
						/**
					 * Se inserta por cada prueba parametrizada en detalleadmision, valores con el salon, pero en blanco, en tabla detalleestudianteadmision
					 */
						reset($array_parametros_admision);
						foreach ($array_parametros_admision as $llave => $valor_admisiones)
						{
							if($valor_admisiones['codigotipodetalleadmision']==1){//inserccion automatica solo para la entrevista
								$query_detalleestudianteadmision="INSERT INTO detalleestudianteadmision(iddetalleestudianteadmision, fechadetalleestudianteadmision, idestudianteadmision, iddetalleadmision, resultadodetalleestudianteadmision, idhorariodetallesitioadmision, codigoestado, codigoestadoestudianteadmision, observacionesdetalleestudianteadmision)
							VALUES ('', '$this->fechahoy', '$idestudianteadmision', '".$valor_admisiones['iddetalleadmision']."','0','".$arrayHorarioSalon['idhorariodetallesitioadmision']."', '100', '100', '')";
								$this->conexion->query($query_detalleestudianteadmision);
								$prueba=$valor_admisiones['nombretipodetalleadmision'];
							}
						}
						list($fechaIni,$hor)=explode(" ",$arrayHorarioSalon['fechainiciohorariodetallesitioadmision']);
						list($anoIni,$mes_ini,$dia_ini)=explode("-",$fechaIni);
						$direccionsitioadmision=$this->array_admision['direccionsitioadmision'];
						$telefonositioadmision=$this->array_admision['telefonositioadmision'];
						$this->seAsignoSalon=true;
						$this->array_asignacion_salon=array('prueba'=>$prueba,'codigosalon'=>$codigosalon,'direccionsitioadmision'=>$direccionsitioadmision,'telefonositioadmision'=>$telefonositioadmision,'dia'=>$dia_ini,'mes'=>$mes_ini,'mesTexto'=>$this->devuelveMes($mes_ini),'ano'=>$anoIni,'hora'=>substr($arrayHorarioSalon['horainicialhorariodetallesitioadmision'],0,5),'codigocarrera'=>$this->array_admision['codigocarrera']);
						echo '<script language="javascript">alert("Señor(a) aspirante:\nUsted ha sido citado en '.$direccionsitioadmision. ' teléfono '.$telefonositioadmision. ' el dia '.$dia_ini.' de '.$this->devuelveMes($mes_ini).' de '.$anoIni.' a las '.substr($arrayHorarioSalon['horainicialhorariodetallesitioadmision'],0,5).' en el salón '.$codigosalon.'\nSe enviará un e-mail durante los próximos minutos a la dirección de correo electrónico registrada")</script>';
					}
				}
				else{
					echo "<h1>No hay suficientes cupos en salones disponibles, no se puede continuar</h1>";
					exit();
				}
			}
		}

	}
	
	function retornaSiSeAsignoSalon(){
		return $this->seAsignoSalon;
	}
	
	function retornaArrayAsignacionSalon(){
		return $this->array_asignacion_salon;
	}
	
	function verificaSiHaySalonAsignado($codigoestudiante){
		$query="SELECT ea.*,dea.*
		FROM admision a, estudianteadmision ea, detalleestudianteadmision dea
		WHERE
		ea.idestudianteadmision=dea.idestudianteadmision
		AND a.idadmision=ea.idadmision
		AND ea.codigoestado='100'
		AND dea.codigoestado='100'
		AND a.idsubperiodo='".$this->idsubperiodo."'
		AND ea.codigoestudiante='$codigoestudiante'
		";
		$array_asignacion=$this->Query($query,false);
		if(is_array($array_asignacion)){
			$asignado=true;
		}
		else{
			$asignado=false;
		}
		return $asignado;
	}

	function devuelveMes($mes){
		switch ($mes){
			case 1:
				$mes="enero";
				break;
			case 2:
				$mes="febrero";
				break;
			case 3:
				$mes="marzo";
				break;
			case 4:
				$mes="abril";
				break;
			case 5:
				$mes="mayo";
				break;
			case 6:
				$mes="junio";
				break;
			case 7:
				$mes="julio";
				break;
			case 8:
				$mes="agosto";
				break;
			case 9:
				$mes="septiembre";
				break;
			case 10:
				$mes="octubre";
				break;
			case 11:
				$mes="noviembre";
				break;
			case 12:
				$mes="diciembre";
				break;
		}
		return $mes;
	}

	function leeHorarioSalon($codigosalon,$idadmision){
		$query="SELECT hdsa.*
		FROM horariodetallesitioadmision hdsa, detallesitioadmision dsa
		WHERE
		dsa.idadmision='$idadmision'
		AND dsa.codigosalon='$codigosalon'
		AND dsa.iddetallesitioadmision=hdsa.iddetallesitioadmision
		AND hdsa.codigoestado='100'
		";
		$row_horario=$this->Query($query,true);
		return $row_horario;
	}

	function leerParametrizacionPruebasAdmision($idadmision)
	{
		$query="SELECT da.codigotipodetalleadmision,
		tda.nombretipodetalleadmision, 
		da.iddetalleadmision, 
		da.porcentajedetalleadmision, 
		da.totalpreguntasdetalleadmision
		FROM
		admision a, detalleadmision da, tipodetalleadmision tda
		WHERE
		a.idadmision = da.idadmision
		AND a.codigoestado=100
		AND da.codigoestado=100
		AND a.idadmision='$idadmision'
		AND da.codigotipodetalleadmision=tda.codigotipodetalleadmision
		ORDER BY
		da.codigotipodetalleadmision
		";
		if($this->debug==true)
		{
			$this->conexion->debug=true;
		}
		$operacion=$this->conexion->query($query);
		$row_operacion=$operacion->fetchRow();
		do
		{
			$array_interno[]=$row_operacion;
		}
		while($row_operacion=$operacion->fetchRow());
		if($this->debug==true)
		{
			$this->conexion->debug=false;
			$this->DibujarTabla($array_interno,"Array_parametrizacion_admision");
		}
		return $array_interno;
	}

	function Query($query,$unicaFila=true){
		$operacion=$this->conexion->query($query);
		$row_operacion=$operacion->fetchRow();
		if($unicaFila==true){
			return $row_operacion;
		}
		else {
			do{
				if(!empty($row_operacion)){
					$array_interno[]=$row_operacion;
				}
			}
			while ($row_operacion=$operacion->fetchRow());
			if(is_array($array_interno)){
				return $array_interno;
			}
		}
	}

	function QueryLlave($query,$llave){
		$operacion=$this->conexion->query($query);
		$row_operacion=$operacion->fetchRow();
		do{
			if(!empty($row_operacion)){
				$array_interno[$row_operacion[$llave]]=$row_operacion;
			}
		}
		while ($row_operacion=$operacion->fetchRow());
		if(is_array($array_interno)){
			return $array_interno;
		}
	}

	function DibujarTablaNormal($matriz,$texto="")
	{
		if(is_array($matriz))
		{
			echo "<table width='100%' border=1 cellpadding='2' cellspacing='1' align=center>\n ";
			echo "<caption align=TOP><h4>$texto</h4></caption>";
			$this->EscribirCabecerasTablaNormal($matriz[0],$link);
			for($i=0; $i < count($matriz); $i++)
			{
				echo "<tr>\n";
				while($elemento=each($matriz[$i]))
				{
					echo "<td wrap>$elemento[1]&nbsp;</td>\n";
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

	function EscribirCabecerasTablaNormal($matriz)
	{
		echo "<tr>\n";
		while($elemento = each($matriz))
		{
			echo "<td>$elemento[0]</a></td>\n";
		}
		echo "</tr>\n";
	}


}

?>