<?php
ini_set('memory_limit', '128M');
ini_set('max_execution_time','216000');
class GruposyHorarios extends matriz
{
	var $conexion;
	var $codigoperiodo;
	var $debug;
	var $array_rango_semana;
	var $array_rango_horas;
	var $conteo_llamadas_calendario=0;

	function GruposyHorarios(&$conexion,$codigoperiodo,$debug=false)
	{
		$this->conexion=$conexion;
		$this->codigoperiodo=$codigoperiodo;
		$this->debug=$debug;
	}

	function compararFechas($fecha1,$condicion,$fecha2)
	{
		list($ano1,$mes1,$dia1)=split("-",$fecha1);
		list($ano2,$mes2,$dia2)=split("-",$fecha2);
		switch ($condicion)
		{
			case ">=":
				if($ano1 >=$ano2 && $mes1 >=$mes2 && $dia1 >=$dia2)
				{
					return true;
				}
				else
				{
					return false;
				}
				break;
			case "<=":
				if($ano1 <=$ano2 && $mes1 <=$mes2 && $dia1 <=$dia2)
				{
					return true;
				}
				else
				{
					return false;
				}
				break;
		}
	}

	function ObtenerTodoslosGruposyHorariosNocruzadetalle($fechaini,$horaini,$fechafin,$horafin)
	{
		$query="
		SELECT
		d.codigodia,
		d.nombredia,
		h.idgrupo,
		h.codigodia,
		h.horainicial,
		h.horafinal,
		g.codigogrupo,
		g.nombregrupo,
		g.codigoperiodo
		FROM
		horario h, grupo g, dia d
		WHERE
		h.idgrupo=g.idgrupo
		AND g.codigoperiodo='$this->codigoperiodo'
		AND h.codigodia=d.codigodia
		";
		echo $query,"<br>";
		$Operacion=$this->conexion->query($query);
		$RowOperacion=$Operacion->fetchRow();
		do
		{
			$ArrayInterno[]=$RowOperacion;
		}
		while ($RowOperacion=$Operacion->fetchRow());
		if($this->debug==true)
		{
			echo $query,"<br>";
			$this->DibujarTabla($ArrayInterno,"ArrayDatos");
		}
		return $ArrayInterno;
	}

	function obtenerDiasSemana()
	{
		$query="SELECT * FROM dia
		ORDER by codigodia
		";
		$operacion=$this->conexion->query($query);
		$row_operacion=$operacion->fetchRow();
		do
		{
			$array_interno[]=$row_operacion;
		}
		while ($row_operacion=$operacion->fetchRow());
		return $array_interno;
	}

	function obtenerPlantaFisica($codigosede)
	{
		$query="SELECT
		s.codigosalon,
		se.nombresede, 
		ts.nombretiposalon, 
		se.codigosede,
		ts.codigotiposalon
		FROM
		salon s, sede se, tiposalon ts
		WHERE
		s.codigosede=se.codigosede
		AND s.codigotiposalon=ts.codigotiposalon
		AND se.codigosede='$codigosede'
		";
		$operacion=$this->conexion->query($query);
		$row_operacion=$operacion->fetchRow();
		do
		{
			$array_interno[]=$row_operacion;
		}
		while ($row_operacion=$operacion->fetchRow());
		if ($this->debug==true)
		{
			$this->DibujarTabla($array_interno,"Array_planta_fisica");
		}
		return $array_interno;
	}

	function creaArrayCalendarioSede($codigosede,$fecha_ini,$fecha_fin,$ocupacion="ocupados")
	{
		$contador=0;
		$array_planta_fisica=$this->obtenerPlantaFisica($codigosede);
		for ($i=0;$i<count($array_planta_fisica);$i++)
		{
			$array_interno=$this->creaArrayCalendario($fecha_ini,$fecha_fin,$array_planta_fisica[$i]['codigosalon'],$ocupacion="ocupados");
			for ($j=0;$j<count($array_interno);$j++)
			{
				if($ocupacion=="ocupados")
				{
					if($array_interno[$j]['ocupado']==true)
					{
						$array_calendario[$contador]=$array_interno[$j];
						$contador++;
					}
				}
				elseif ($ocupacion=="todos")
				{
					$array_calendario[$contador]=$array_interno[$j];
					$contador++;
				}
				elseif($ocupacion=="desocupados")
				{
					if($array_interno[$j]['ocupado']==false)
					{
						$array_calendario[$contador]=$array_interno[$j];
						$contador++;
					}
				}
			}
		}
		if($this->debug==true)
		{
			$this->DibujarTabla($array_planta_fisica);
			echo count($array_horario);
			$this->DibujarTabla($array_horario);
		}
		return $array_calendario;
	}

	function generaRangosEstandar()
	{
		$array_rangos[]=array('hora_ini'=>'07:00:00','hora_fin'=>'08:00:00');
		$array_rangos[]=array('hora_ini'=>'08:00:00','hora_fin'=>'09:00:00');
		$array_rangos[]=array('hora_ini'=>'09:00:00','hora_fin'=>'10:00:00');
		$array_rangos[]=array('hora_ini'=>'10:00:00','hora_fin'=>'11:00:00');
		$array_rangos[]=array('hora_ini'=>'11:00:00','hora_fin'=>'12:00:00');
		$array_rangos[]=array('hora_ini'=>'12:00:00','hora_fin'=>'13:00:00');
		$array_rangos[]=array('hora_ini'=>'13:00:00','hora_fin'=>'14:00:00');
		$array_rangos[]=array('hora_ini'=>'14:00:00','hora_fin'=>'15:00:00');
		$array_rangos[]=array('hora_ini'=>'15:00:00','hora_fin'=>'16:00:00');
		$array_rangos[]=array('hora_ini'=>'16:00:00','hora_fin'=>'17:00:00');
		$array_rangos[]=array('hora_ini'=>'17:00:00','hora_fin'=>'18:00:00');
		$array_rangos[]=array('hora_ini'=>'18:00:00','hora_fin'=>'19:00:00');
		$array_rangos[]=array('hora_ini'=>'19:00:00','hora_fin'=>'20:00:00');
		$array_rangos[]=array('hora_ini'=>'20:00:00','hora_fin'=>'21:00:00');
		$array_rangos[]=array('hora_ini'=>'21:00:00','hora_fin'=>'22:00:00');
		return $array_rangos;
	}


	function obtenerHorariosSalon($codigosalon)
	{
		$query="SELECT
		h.idhorario,
		h.idgrupo,
		h.codigodia,
		d.nombredia,
		h.horainicial,
		h.horafinal,
		h.codigosalon,
		h.codigoestado,
		g.idgrupo,
		g.codigoperiodo,
		m.codigomateria,
		m.nombremateria
		FROM
		horario h, dia d, grupo g, materia m
		WHERE
		h.codigosalon='$codigosalon'
		AND g.codigoperiodo='$this->codigoperiodo'
		AND h.codigodia=d.codigodia
		AND h.codigoestado='100'
		AND h.idgrupo=g.idgrupo
		AND g.codigomateria=m.codigomateria
		ORDER BY
		h.idhorario,h.codigodia
		";

		$operacion=$this->conexion->query($query);
		$row_operacion=$operacion->fetchRow();
		do
		{
			$array_interno[]=$row_operacion;
		}
		while ($row_operacion=$operacion->fetchRow());
		if($this->debug==true)
		{
			$this->DibujarTabla($array_interno,"array grupos x salon");
		}
		return $array_interno;
	}

	function obtenerHorarioSalonconHorariodetallefecha($codigosalon)
	{
		$query="SELECT
		h.idhorario,
		hdf.idhorariodetallefecha,
		h.idgrupo,
		h.codigodia,
		d.nombredia,
		DATE_FORMAT(hdf.fechadesdehorariodetallefecha,'%Y-%c-%e') AS fechadesdehorariodetallefecha,
		DATE_FORMAT(hdf.fechahastahorariodetallefecha,'%Y-%c-%e') AS fechahastahorariodetallefecha,
		h.horainicial,
		h.horafinal,
		h.codigosalon,
		ts.nombretiposalon,
		s.codigotiposalon,
		se.nombresede,
		se.codigosede,
		h.codigoestado,
		g.idgrupo,
		g.codigoperiodo,
		m.codigomateria,
		m.nombremateria,
		m.codigocarrera
		FROM
		horario h, dia d, grupo g, materia m, horariodetallefecha hdf, salon s, sede se, tiposalon ts
		WHERE
		h.codigosalon='$codigosalon'
		AND g.codigoperiodo='$this->codigoperiodo'
		AND h.codigodia=d.codigodia
		AND h.codigoestado='100'
		AND h.idgrupo=g.idgrupo
		AND g.codigomateria=m.codigomateria
		AND hdf.idhorario=h.idhorario
		AND h.codigosalon=s.codigosalon
		AND s.codigosede=se.codigosede
		AND s.codigotiposalon=ts.codigotiposalon
		AND hdf.codigoestado='100'
		ORDER BY
		h.idhorario,h.codigodia
		";
		$operacion=$this->conexion->query($query);
		$row_operacion=$operacion->fetchRow();
		do
		{
			$array_interno[]=$row_operacion;
		}
		while ($row_operacion=$operacion->fetchRow());
		if($this->debug==true)
		{
			echo $query,"<br>";
			$this->DibujarTabla($array_interno,"array grupos x salon");
		}
		return $array_interno;
	}

	function creaArrayCalendario($fecha_ini,$fecha_fin,$salon)
	{
		list($ano,$mes_ini,$dia_ini)=split("-",$fecha_ini);
		list($ano,$mes_final,$dia_fin)=split("-",$fecha_fin);
		$array_rango_horas=$this->generaRangosEstandar();
		$array_horario_salon=$this->obtenerHorarioSalonconHorariodetallefecha($salon);
		$contador=0;
		$cont_semana=0;
		$cont_cal=0;
		$contador_ini=0;
		$semana=0;
		for ($mes=$mes_ini;$mes<=$mes_final;$mes++)
		{
			$ultimoDiadelMes=$this->ultimoDia($mes,$ano);
			/*si se ingresa un rango que excede el del mes, se toma el maximo posible,
			es decir, si digo que el max dia del rango es 31, en el caso de febrero,
			maximo se puede calcular hasta 28*/
			if($dia_fin > $ultimoDiadelMes)
			{
				$dia_final_bucle=$ultimoDiadelMes;
			}
			else
			{
				$dia_final_bucle=$dia_fin;
			}
			for ($j=$dia_ini;$j<=$dia_final_bucle;$j++)
			{
				$numerodia=$this->calcula_numero_dia_semana($j,$mes,$ano);
				$fecha=$ano."-".$mes."-".$j;
				$dia=$this->devuelveDia($j);
				foreach ($array_rango_horas as $llave_rango => $valor_rango)
				{
					$bandera_aumenta_semana=false;
					$array_calendario[$cont_cal]['llave']=$cont_cal;
					$array_calendario[$cont_cal]['codigosalon']=$salon;
					$array_calendario[$cont_cal]['fecha']=$fecha;
					$array_calendario[$cont_cal]['numerodia']=$numerodia;
					$array_calendario[$cont_cal]['dia']=$this->devuelveDia($numerodia);
					$array_calendario[$cont_cal]['mes']=$this->DevuelveMes($mes);
					$array_calendario[$cont_cal]['hora_ini']=$valor_rango['hora_ini'];
					$array_calendario[$cont_cal]['hora_fin']=$valor_rango['hora_fin'];
					$ocupado=false;
					$nombremateria=null;
					$codigomateria=null;
					foreach ($array_horario_salon as $llave => $valor)
					{
						if($numerodia==$valor['codigodia'])
						{
							if($this->compararFechas($fecha,">=",$valor['fechadesdehorariodetallefecha']) and $this->compararFechas($fecha,"<=",$valor['fechahastahorariodetallefecha']))
							{
								if($valor_rango['hora_ini'] >= $valor['horainicial'] and $valor_rango['hora_fin'] <= $valor['horafinal'])
								{
									$ocupado=true;
									$nombremateria=$valor['nombremateria'];
									$codigomateria=$valor['codigomateria'];
								}
							}
						}
						$array_calendario[$cont_cal]['codigosede']=$valor['codigosede'];
						$array_calendario[$cont_cal]['nombresede']=$valor['nombresede'];
						$array_calendario[$cont_cal]['codigotiposalon']=$valor['codigotiposalon'];
						$array_calendario[$cont_cal]['nombretiposalon']=$valor['nombretiposalon'];
						$array_calendario[$cont_cal]['codigomateria']=$codigomateria;
						$array_calendario[$cont_cal]['nombremateria']=$nombremateria;
						$array_calendario[$cont_cal]['codigocarrera']=$valor['codigocarrera'];
						$array_calendario[$cont_cal]['ocupado']=$ocupado;
						$array_calendario[$cont_cal]['desocupado']=!$ocupado;
					}
					$cont_cal++;
				}
			}
		}
		if($this->debug==true)
		{
			$this->DibujarTabla($array_calendario,"Array_calendario salón $salon");
		}
		return $array_calendario;
	}

	function creaArrayCalendarioConOcupacion($fecha_ini,$fecha_fin,$salon,$ocupacion)
	{
		list($ano,$mes_ini,$dia_ini)=split("-",$fecha_ini);
		list($ano,$mes_final,$dia_fin)=split("-",$fecha_fin);
		$array_rango_horas=$this->generaRangosEstandar();
		$array_horario_salon=$this->obtenerHorarioSalonconHorariodetallefecha($salon);
		$contador=0;
		$cont_semana=0;
		$cont_cal=0;
		$contador_ini=0;
		$semana=0;
		for ($mes=$mes_ini;$mes<=$mes_final;$mes++)
		{
			$ultimoDiadelMes=$this->ultimoDia($mes,$ano);
			/*si se ingresa un rango que excede el del mes, se toma el maximo posible,
			es decir, si digo que el max dia del rango es 31, en el caso de febrero,
			maximo se puede calcular hasta 28*/
			if($dia_fin > $ultimoDiadelMes)
			{
				$dia_final_bucle=$ultimoDiadelMes;
			}
			else
			{
				$dia_final_bucle=$dia_fin;
			}
			for ($j=$dia_ini;$j<=$dia_final_bucle;$j++)
			{
				$numerodia=$this->calcula_numero_dia_semana($j,$mes,$ano);
				$fecha=$ano."-".$mes."-".$j;
				$dia=$this->devuelveDia($j);
				foreach ($array_rango_horas as $llave_rango => $valor_rango)
				{

					$ocupado=false;
					$nombremateria=null;
					$codigomateria=null;
					foreach ($array_horario_salon as $llave => $valor)
					{
						if($numerodia==$valor['codigodia'])
						{
							if($this->compararFechas($fecha,">=",$valor['fechadesdehorariodetallefecha']) and $this->compararFechas($fecha,"<=",$valor['fechahastahorariodetallefecha']))
							{
								if($valor_rango['hora_ini'] >= $valor['horainicial'] and $valor_rango['hora_fin'] <= $valor['horafinal'])
								{
									$ocupado=true;
									$nombremateria=$valor['nombremateria'];
									$codigomateria=$valor['codigomateria'];
								}
							}
						}
						if($ocupacion=="ocupados")
						{
							if($ocupado==true)
							{
								$array_calendario[$cont_cal]['llave']=$cont_cal;
								$array_calendario[$cont_cal]['codigosalon']=$salon;
								$array_calendario[$cont_cal]['fecha']=$fecha;
								$array_calendario[$cont_cal]['numerodia']=$numerodia;
								$array_calendario[$cont_cal]['dia']=$this->devuelveDia($numerodia);
								$array_calendario[$cont_cal]['mes']=$this->DevuelveMes($mes);
								$array_calendario[$cont_cal]['hora_ini']=$valor_rango['hora_ini'];
								$array_calendario[$cont_cal]['hora_fin']=$valor_rango['hora_fin'];
								$array_calendario[$cont_cal]['codigosede']=$valor['codigosede'];
								$array_calendario[$cont_cal]['nombresede']=$valor['nombresede'];
								$array_calendario[$cont_cal]['codigotiposalon']=$valor['codigotiposalon'];
								$array_calendario[$cont_cal]['nombretiposalon']=$valor['nombretiposalon'];
								$array_calendario[$cont_cal]['codigomateria']=$codigomateria;
								$array_calendario[$cont_cal]['nombremateria']=$nombremateria;
								$array_calendario[$cont_cal]['codigocarrera']=$valor['codigocarrera'];
								$array_calendario[$cont_cal]['ocupado']=$ocupado;
								$array_calendario[$cont_cal]['desocupado']=!$ocupado;
								$cont_cal++;
							}
						}
						elseif ($ocupacion=="desocupados")
						{
							if($ocupado==false)
							{
								$array_calendario[$cont_cal]['llave']=$cont_cal;
								$array_calendario[$cont_cal]['codigosalon']=$salon;
								$array_calendario[$cont_cal]['fecha']=$fecha;
								$array_calendario[$cont_cal]['numerodia']=$numerodia;
								$array_calendario[$cont_cal]['dia']=$this->devuelveDia($numerodia);
								$array_calendario[$cont_cal]['mes']=$this->DevuelveMes($mes);
								$array_calendario[$cont_cal]['hora_ini']=$valor_rango['hora_ini'];
								$array_calendario[$cont_cal]['hora_fin']=$valor_rango['hora_fin'];
								$array_calendario[$cont_cal]['codigosede']=$valor['codigosede'];
								$array_calendario[$cont_cal]['nombresede']=$valor['nombresede'];
								$array_calendario[$cont_cal]['codigotiposalon']=$valor['codigotiposalon'];
								$array_calendario[$cont_cal]['nombretiposalon']=$valor['nombretiposalon'];
								$array_calendario[$cont_cal]['codigomateria']=$codigomateria;
								$array_calendario[$cont_cal]['nombremateria']=$nombremateria;
								$array_calendario[$cont_cal]['codigocarrera']=$valor['codigocarrera'];
								$array_calendario[$cont_cal]['ocupado']=$ocupado;
								$array_calendario[$cont_cal]['desocupado']=!$ocupado;
								$cont_cal++;
							}
						}
						elseif ($ocupacion=="todos")
						{
							$array_calendario[$cont_cal]['llave']=$cont_cal;
							$array_calendario[$cont_cal]['codigosalon']=$salon;
							$array_calendario[$cont_cal]['fecha']=$fecha;
							$array_calendario[$cont_cal]['numerodia']=$numerodia;
							$array_calendario[$cont_cal]['dia']=$this->devuelveDia($numerodia);
							$array_calendario[$cont_cal]['mes']=$this->DevuelveMes($mes);
							$array_calendario[$cont_cal]['hora_ini']=$valor_rango['hora_ini'];
							$array_calendario[$cont_cal]['hora_fin']=$valor_rango['hora_fin'];
							$array_calendario[$cont_cal]['codigosede']=$valor['codigosede'];
							$array_calendario[$cont_cal]['nombresede']=$valor['nombresede'];
							$array_calendario[$cont_cal]['codigotiposalon']=$valor['codigotiposalon'];
							$array_calendario[$cont_cal]['nombretiposalon']=$valor['nombretiposalon'];
							$array_calendario[$cont_cal]['codigomateria']=$codigomateria;
							$array_calendario[$cont_cal]['nombremateria']=$nombremateria;
							$array_calendario[$cont_cal]['codigocarrera']=$valor['codigocarrera'];
							$array_calendario[$cont_cal]['ocupado']=$ocupado;
							$array_calendario[$cont_cal]['desocupado']=!$ocupado;
							$cont_cal++;
						}
					}
				}
			}
		}
		if($this->debug==true)
		{
			$this->DibujarTabla($array_calendario,"Array_calendario salón $salon");
		}
		return $array_calendario;
	}


	function DibujaCalendarios($fecha_ini,$fecha_fin,$salon,$ocupacion="ocupados")
	{
	
		list($ano,$mes_ini,$dia_ini)=split("-",$fecha_ini);
		list($ano,$mes_final,$dia_fin)=split("-",$fecha_fin);

		$array_rango_horas=$this->generaRangosEstandar();
		$array_horario_salon=$this->obtenerHorarioSalonconHorariodetallefecha($salon);
		$contador=0;
		$cont_semana=0;
		$cont_cal=0;
		$contador_ini=0;
		$semana=1;
		for ($mes=$mes_ini;$mes<=$mes_final;$mes++)
		{
			$ultimoDiadelMes=$this->ultimoDia($mes,$ano);
			/*si se ingresa un rango que excede el del mes, se toma el maximo posible,
			es decir, si digo que el max dia del rango es 31, en el caso de febrero,
			maximo se puede calcular hasta 28*/
			if($dia_fin > $ultimoDiadelMes)
			{
				$dia_final_bucle=$ultimoDiadelMes;
			}
			else
			{
				$dia_final_bucle=$dia_fin;
			}
			for ($j=$dia_ini;$j<=$dia_final_bucle;$j++)
			{
				$numerodia=$this->calcula_numero_dia_semana($j,$mes,$ano);
				$fecha=$ano."-".$mes."-".$j;
				$dia=$this->devuelveDia($j);
				$array[$cont_cal]['fecha']=$fecha;
				$array[$cont_cal]['semana']=$semana;
				if($numerodia==6)
				{
					$semana++;
				}
				$cont_cal++;
			}
		}
		$semana_ini=$array[0]['semana'];
		$fecha_ini=$array[0]['fecha'];
		$cont=0;
		for ($i=0;$i<count($array);$i++)
		{
			$array_rangos[$cont]['fechaini']=$fecha_ini;
			$array_rangos[$cont]['fechafin']=$array[$i]['fecha'];

			if($array[$i]['semana']<>$semana_ini)
			{
				$fecha_ini=$array[$i]['fecha'];
				$semana_ini=$array[$i]['semana'];
				$cont++;
			}
		}

		for ($j=0;$j<count($array_rangos);$j++)
		{
			if($ocupacion=="ocupados")
			{
				$this->creaArrayHorarioBase($salon,$array_rangos[$j]['fechaini'],$array_rangos[$j]['fechafin'],"nombremateria",true);
			}
			elseif ($ocupacion=="desocupados")
			{
				$this->creaArrayHorarioBaseDesocupados($salon,$array_rangos[$j]['fechaini'],$array_rangos[$j]['fechafin'],"nombremateria",true);
			}
		}
		if($this->debug==true)
		{
			$this->DibujarTabla($array,"Array_semanas");
			$this->DibujarTabla($array_rangos,"array_rangos");
		}
		return $array_calendario;
	}

	function dibujaCalendariosSede($fecha_ini,$fecha_fin,$codigosede,$ocupacion="ocupados")
	{
		$array_planta_fisica=$this->obtenerPlantaFisica($codigosede);
		for ($i=0;$i<count($array_planta_fisica);$i++)
		{
			$this->DibujaCalendarios($fecha_ini,$fecha_fin,$array_planta_fisica[$i]['codigosalon'],$ocupacion);
		}
	}

	function creaArrayHorarioBase($salon,$fecha_ini,$fecha_fin,$variableMuestra,$mostrarConteollamadascalendario=false)
	{
		$this->conteo_llamadas_calendario++;
		$array_horas=$this->generaRangosEstandar();
		$array_semana=$this->obtenerDiasSemana();
		$array_horario_salon=$this->obtenerHorarioSalonconHorariodetallefecha($salon);
		$contador=0;
		foreach ($array_horas as $llave => $valor)
		{
			$array[$contador]['hora_ini']=$valor['hora_ini'];
			$array[$contador]['hora_fin']=$valor['hora_fin'];

			foreach ($array_semana as $llave_s => $valor_s)
			{
				$ocupado=false;
				$nombremateria=null;
				$codigomateria=null;
				$idgrupo=null;
				foreach ($array_horario_salon as $llave_h => $valor_h)
				{
					if($valor_s['codigodia']==$valor_h['codigodia'])
					{
						if($this->compararFechas($fecha_ini,">=",$valor_h['fechadesdehorariodetallefecha']) and $this->compararFechas($fecha_fin,"<=",$valor_h['fechahastahorariodetallefecha']))
						{
							if($valor['hora_ini'] >= $valor_h['horainicial'] and $valor['hora_fin'] <= $valor_h['horafinal'])
							{
								$ocupado=true;
								$nombremateria=$valor_h['nombremateria'];
								$codigomateria=$valor_h['codigomateria'];
								$idgrupo=$valor_h['idgrupo'];
								$codigocarrera=$valor_h['codigocarrera'];
							}
						}
					}
				}
				$codigodia=$valor_s['codigodia'];
				//$array[$contador][$valor_s['codigodia']]=$valor_s['codigodia'];
				$array[$contador][$valor_s['nombredia']]=$$variableMuestra;
				//$array[$contador][$valor_s['nombredia']]=array('hora_ini'=>$valor['hora_ini'],'hora_fin'=>$valor['hora_fin'],'codigodia'=>$valor_s['codigodia'],'nombredia'=>$nombremateria,'idgrupo'=>$idgrupo);
				$array[$contador][$valor_s['nombredia']]=$codigodia."|".$nombremateria."|".$codigomateria."|".$idgrupo."|".$codigocarrera;
			}
			$contador++;
		}
		if($mostrarConteollamadascalendario==true)
		{
			$semana="Semana $this->conteo_llamadas_calendario";
		}
		$this->DibujarTablaHorario($array,"Horario salón $salon desde $fecha_ini hasta $fecha_fin $semana");
		/*$motor = new matriz($array,"Horario","","no","no");
		$motor->asignarWrap("wrap");
		$motor->asignarAlign("center");
		$motor->asignarNbsp("&nbsp;");
		$motor->mostrar();*/
		return $array;
	}

	function muestraArrayHorario($array)
	{
		for ($i=0;$i<count($array);$i++)
		{
			list($ano1,$mes1,$dia1)=split("-",$fecha1);
		}
	}

	function creaArrayHorarioBaseDesocupados($salon,$fecha_ini,$fecha_fin,$variableMuestra,$mostrarConteollamadascalendario=false)
	{
		$this->conteo_llamadas_calendario++;
		$array_horas=$this->generaRangosEstandar();
		$array_semana=$this->obtenerDiasSemana();
		$array_horario_salon=$this->obtenerHorarioSalonconHorariodetallefecha($salon);
		$contador=0;
		foreach ($array_horas as $llave => $valor)
		{
			$array[$contador]['hora_ini']=$valor['hora_ini'];
			$array[$contador]['hora_fin']=$valor['hora_fin'];

			foreach ($array_semana as $llave_s => $valor_s)
			{
				$ocupado=false;
				$nombremateria=null;
				$codigomateria=null;
				foreach ($array_horario_salon as $llave_h => $valor_h)
				{
					if($valor_s['codigodia']==$valor_h['codigodia'])
					{
						if($this->compararFechas($fecha_ini,">=",$valor_h['fechadesdehorariodetallefecha']) and $this->compararFechas($fecha_fin,"<=",$valor_h['fechahastahorariodetallefecha']))
						{
							if($valor['hora_ini'] >= $valor_h['horainicial'] and $valor['hora_fin'] <= $valor_h['horafinal'])
							{
								$ocupado=true;
								$nombremateria=$valor_h['nombremateria'];
								$codigomateria=$valor_h['codigomateria'];
							}
						}
					}
				}
				$array[$contador][$valor_s['nombredia']]=!$ocupado;
			}
			$contador++;
		}
		if($mostrarConteollamadascalendario==true)
		{
			$semana="Semana $this->conteo_llamadas_calendario";
		}
		$this->DibujarTabla($array,"Horario de espacios desocupados salón $salon desde $fecha_ini hasta $fecha_fin $semana");
		return $array;
	}

	function DibujaTablaHorario()
	{
		$this->dibujaTablaConvencionColores();
		$array_semana=$this->obtenerDiasSemana();
		$array_horas=$this->generaRangosEstandar();
?>
<table cellspacing="1" cellpadding="2" border="1" align="center" width="100%">
  <tr>
    <td width="716">HORAS</td>
    <?php foreach ($array_semana as $llave => $valor){?>
    <td width="131"><?php echo $valor['nombredia']?></td>
       <?php }?>
  </tr>
  <?php foreach ($array_horas as $llave => $valor){?>
  <tr>
    <td width="716"><?php echo $valor['hora_ini']."-".$valor['hora_fin']?></td>
    <td width="131">&nbsp;</td>
    <td width="131">&nbsp;</td>
    <td width="131">&nbsp;</td>
    <td width="131">&nbsp;</td>
    <td width="131">&nbsp;</td>
    <td width="131">&nbsp;</td>
    <td width="131">&nbsp;</td>
  </tr>
  <?php } ?>
</table>
  <?php } 

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

  function EscribirCabecerasHorario($matriz)
  {
  	echo "<tr>\n";
  	//echo "<td>Conteo</a></td>\n";
  	while($elemento = each($matriz))
  	{
  		echo "<td wrap><div align='center'>$elemento[0]</div></a></td>\n";
  	}
  	echo "</tr>\n";
  }

  function DibujarTabla($matriz,$texto="")
  {
  	if(is_array($matriz))
  	{
  		echo "<table border=1 cellpadding='2' cellspacing='1' align=center width='100%'>\n";
  		echo "<caption align=TOP><h1>$texto</h1></caption>";
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

  function DibujarTablaHorario($matriz,$texto="")
  {
  	/*echo '
  	<script language="javascript">
	var i=0;
	var Arreglo = new Array();
  	function cambiar_color_over(celda)
		{
   			celda.style.backgroundColor="#66ff33"
		}
		function cambiar_color_out(celda)
		{
   			celda.style.backgroundColor="#FFFFFF"
		}
		function cambiar_color_seleccionado(celda,llave,codigodia,nombremateria,codigomateria,idgrupo)
		{
   			Arreglo[i]=new Array("*",llave,codigodia,nombremateria,codigomateria,idgrupo);
			//alert(Arreglo[i]);
   			i++;
			celda.style.backgroundColor="#FF0000";
		}
		function imprimeArray()
		{
			for (var i = 0; i < Arreglo.length; i++) 
			{
				document.write (Arreglo[i] + "<br>");
			}		
		}
		
		function pasaArray()
		{
			var campoAsignacion = document.getElementById("asignacion");
			var cadena;
			campoAsignacion.value=Arreglo;
			document.form1.submit();
		}
	
	</script>';*/

  	if(is_array($matriz))
  	{

  		$this->dibujaTablaConvencionColores();
  		//echo '<form name="form1" method="post" action="">';
  		echo '<input name="asignacion" type="hidden" id="asignacion">';
  		$seleccionados=$_REQUEST['asignacion'];
  		echo "<table border='1' cellpadding='1' cellspacing='1' bordercolor='#000000' onClick='print()' width='100%' align=center>\n ";
  		echo "<caption align=TOP><h3>$texto</h3></caption>";
  		$this->EscribirCabecerasHorario($matriz[0],$link);
  		for($i=0; $i < count($matriz); $i++)
  		{
  			$MostrarConteo=$i+1;
  			echo "<tr>\n";
  			//echo "<td align='center' wrap>$MostrarConteo&nbsp;</td>\n";
  			while($elemento=each($matriz[$i]))
  			{
  				$divcadena=explode("|",$elemento[1]);
  				if($elemento[0]=="hora_ini" or $elemento[0]=="hora_fin"){
  				?>
  				<td Wrap bgcolor="#FFFFFF" align ="center"><?php echo $divcadena[0]?>&nbsp;</td>
  				<?php }
  				else
  				{?>
  				<td Wrap bgcolor="<?php if($divcadena[1]<>""){echo $this->devuelveColorHorarioCarrera($divcadena[4]);}?>" align ="center" id="celda<?php echo $i?>"><?php echo $divcadena[1]?>&nbsp;</td>
  				<?php }
  			}

  			echo "</tr>\n";
  		}
  		echo "</table>\n";
  		//echo '<input type="button" name="Asignar" value="Asignar" onclick="imprimeArray()">';
  		//echo '<input type="button" name="Enviar" value="Enviar" onclick="pasaArray()">';
  		//echo '</form>';
  		echo "<H1 class=SaltoDePagina> </H1>";
  		/*$sel=explode("*",$seleccionados);
  		foreach ($sel as $llave => $valor)
  		{
  		$sel2=explode(",",$valor);
  		$llave_array_horas=$sel2[1];
  		$codigodia=$sel2[2];
  		$nombremateria=$sel2[3];
  		$codigomateria=$sel2[4];
  		$idgrupo=$sel2[5];
  		$codigocarrera=$sel2[6];
  		if($llave_array_horas<>"")
  		{
  		$array_datos_seleccionados[]=array('llave_horas'=>$llave_array_horas,'codigodia'=>$codigodia,'nombremateria'=>$nombremateria,'codigomateria'=>$codigomateria,'idgrupo'=>$idgrupo,'codigocarrera'=>$codigocarrera);
  		}
  		}
  		$this->DibujarTabla($array_datos_seleccionados)
  		*/

  	}
  	else
  	{
  		echo $texto." Matriz no valida<br>";
  	}

  }

  function devuelveColorHorarioCarrera($codigocarrera)
  {
  	$query_colores="SELECT * FROM carreracolorhorario cch WHERE
  	cch.codigoestado=100 AND cch.codigocarrera='$codigocarrera'";
  	$operacion=$this->conexion->query($query_colores);
  	$row_operacion=$operacion->fetchRow();
  	if(!empty($row_operacion['colorhorario']))
  	{
  		return $row_operacion['colorhorario'];
  	}
  	else
  	{
  		return "#FFFFFF";
  	}
  }

  function dibujaTablaConvencionColores()
  {
  	$query="SELECT cch.colorhorario, c.nombrecarrera
  	FROM
  	carrera c, carreracolorhorario cch
  	WHERE
  	cch.codigoestado=100
  	AND
  	cch.codigocarrera=c.codigocarrera
  	";
  	$operacion=$this->conexion->query($query);
  	$row_operacion=$operacion->fetchRow();
  	do
  	{
  		$array_interno[]=$row_operacion;
  	}
  	while ($row_operacion=$operacion->fetchRow());
  	

  	$contador=1;
  	echo "<table border='0' cellpadding='0' cellspacing='0' bordercolor='#E9E9E9' width='100%'>\n";
  	foreach ($array_interno as $llave => $valor)
  	{
  		if($contador%8==0)
  		{
  			$contador=1;
  			echo "<tr>\n";
  		}
  		echo "<td bgcolor='".$valor['colorhorario']."' align=center>".$valor['nombrecarrera']."</td>\n";
  		$contador++;
  	}
  	echo "</table>\n";
  }



  function calcula_numero_dia_semana($dia,$mes,$ano)
  {
  	$numerodiasemana = date('w', mktime(0,0,0,$mes,$dia,$ano));
  	if ($numerodiasemana == 0)
  	$numerodiasemana = 6;
  	else
  	$numerodiasemana--;
  	return $numerodiasemana;
  }

  //funcion que devuelve el último día de un mes y año dados
  function ultimoDia($mes,$ano)
  {
  	$ultimo_dia=28;
  	while (checkdate($mes,$ultimo_dia + 1,$ano))
  	{
  		$ultimo_dia++;
  	}
  	return $ultimo_dia;
  }

  function DevuelveMes($mes)
  {
  	switch ($mes)
  	{
  		case 1:
  			return "Enero";
  			break;
  		case 2:
  			return "Febrero";
  			break;
  		case 3:
  			return "Marzo";
  			break;
  		case 4:
  			return "Abril";
  			break;
  		case 5:
  			return "Mayo";
  			break;
  		case 6:
  			return "Junio";
  			break;
  		case 7:
  			return "Julio";
  			break;
  		case 8:
  			return "Agosto";
  			break;
  		case 9:
  			return "Septiembre";
  			break;
  		case 10:
  			return "Octubre";
  			break;
  		case 11:
  			return "Noviembre";
  			break;
  		case 12:
  			return "Diciembre";
  			break;
  		default:
  			return false;
  			break;
  	}
  }
  function devuelveDia($dia)
  {
  	$cadenaDia=jddayofweek($dia,1);
  	switch ($cadenaDia)
  	{
  		case "Monday":
  			return "Lunes";
  			break;
  		case "Tuesday":
  			return "Martes";
  			break;
  		case "Wednesday":
  			return "Miércoles";
  			break;
  		case "Thursday":
  			return "Jueves";
  			break;
  		case "Friday":
  			return "Viernes";
  			break;
  		case "Saturday":
  			return "Sábado";
  			break;
  		case "Sunday":
  			return "Domingo";
  			break;
  	}
  }

  function rangoSemanas()
  {

  }
}
?>