<?php
class InformeDescuentos
{
	var $conexion;
	var $codigoperiodo;
	var $debug;
	var $fechahoy;
	/**
 * Constrctor
 *
 * @param unknown_type $conexion
 * @param unknown_type $codigoperiodo
 * @return InformeDescuentos
 */
	function InformeDescuentos($conexion,$codigoperiodo,$debug=false)
	{
		$this->conexion=$conexion;
		$this->codigoperiodo=$codigoperiodo;
		$this->debug=$debug;
		$this->fechahoy=date("Y-m-d H:i:s");
	}

	function LeerCarreras($codigomodalidadacademica="",$codigocarrera="")
	{
		if($codigomodalidadacademica=="todos" and $codigocarrera=="todos")
		{
			$query_obtener_carreras="SELECT c.codigocarrera,c.nombrecarrera,c.codigomodalidadacademica
			FROM
			carrera c
			WHERE
			c.fechainiciocarrera <= '".$this->fechahoy."' and c.fechavencimientocarrera >= '".$this->fechahoy."'
			ORDER BY c.codigocarrera
			";
		}
		elseif($codigomodalidadacademica=="todos" and $codigocarrera<>"todos")
		{
			$query_obtener_carreras="SELECT c.codigocarrera,c.nombrecarrera,c.codigomodalidadacademica
			FROM
			carrera c
			WHERE
			c.codigocarrera='".$codigocarrera."'
			AND c.fechainiciocarrera <= '".$this->fechahoy."' and c.fechavencimientocarrera >= '".$this->fechahoy."'
			ORDER BY c.codigocarrera
			";
		}
		elseif($codigomodalidadacademica<>"todos" and $codigocarrera=="todos")
		{
			$query_obtener_carreras="SELECT c.codigocarrera,c.nombrecarrera,c.codigomodalidadacademica
			FROM
			carrera c
			WHERE
			c.codigomodalidadacademica='$codigomodalidadacademica'
			AND c.fechainiciocarrera <= '".$this->fechahoy."' and c.fechavencimientocarrera >= '".$this->fechahoy."'
			ORDER BY c.codigocarrera
			";
		}
		elseif($codigomodalidadacademica<>"todos" and $codigocarrera<>"todos")
		{
			$query_obtener_carreras="SELECT c.codigocarrera,c.nombrecarrera,c.codigomodalidadacademica
			FROM
			carrera c
			WHERE
			c.codigocarrera='$codigocarrera'
			AND c.fechainiciocarrera <= '".$this->fechahoy."' and c.fechavencimientocarrera >= '".$this->fechahoy."'
			ORDER BY c.codigocarrera
			";
		}

		//echo $query_obtener_carreras,"<br>";
		$obtener_carreras=$this->conexion->query($query_obtener_carreras);
		$row_obtener_carreras=$obtener_carreras->fetchRow();
		do
		{
			$array_obtener_carreras[]=$row_obtener_carreras;
		}
		while($row_obtener_carreras=$obtener_carreras->fetchRow());
		$this->array_obtener_carreras=$array_obtener_carreras;
		if($this->debug==true)
		{
			$this->tabla($array_obtener_carreras,"array_carreras_seleccionadas");
		}
		return $array_obtener_carreras;
	}

	Function LeerEstudiantesDescuento($codigoperiodo,$array_codigocarrera,$codigoconcepto)
	{
		foreach ($array_codigocarrera as $llave => $valor)
		{
			if($codigoconcepto=="todos")
			{
				$query="SELECT DISTINCT op.numeroordenpago
						, op.codigoperiodo
						, eg.idestudiantegeneral
						, eg.numerodocumento
						, op.codigoestudiante
						, op.documentocuentaxcobrarsap
						, op.documentocuentacompensacionsap
						, sub.fecha_limite_pago
						, sce.nombresituacioncarreraestudiante
						, te.nombretipoestudiante
						, op.fechaordenpago as fecha_creacion_ordenpago
						, op.fechapagosapordenpago
						, eop.nombreestadoordenpago
						, c.nombreconcepto
						, c.codigoconcepto
						, dop.valorconcepto
						, concat(eg.apellidosestudiantegeneral,' ', eg.nombresestudiantegeneral) as nombre
						, car.nombrecarrera
						, e.semestre as semestre
						, eg.emailestudiantegeneral as email
						, eg.telefonoresidenciaestudiantegeneral as teléfono_fijo
						, eg.celularestudiantegeneral as teléfono_celular
						, eg.numerodocumento as documento
					FROM ordenpago op
					, detalleordenpago dop
					, estadoordenpago eop
					, concepto c
					, estudiante e
					, estudiantegeneral eg
					, carrera car
					, situacioncarreraestudiante sce
					, tipoestudiante te
					, (select numeroordenpago,group_concat(fechaordenpago order by fechaordenpago separator ' / ') as fecha_limite_pago from fechaordenpago group by numeroordenpago) as sub
					WHERE op.numeroordenpago=dop.numeroordenpago 
						AND op.codigoestadoordenpago = eop.codigoestadoordenpago 
						AND c.codigoconcepto=dop.codigoconcepto 
						AND e.codigosituacioncarreraestudiante=sce.codigosituacioncarreraestudiante
						AND e.codigotipoestudiante=te.codigotipoestudiante
						AND op.numeroordenpago=sub.numeroordenpago
						AND op.codigoperiodo='$codigoperiodo'
						AND op.codigoestudiante=e.codigoestudiante 
						AND e.idestudiantegeneral=eg.idestudiantegeneral 
						AND e.codigocarrera=car.codigocarrera 
						AND e.codigocarrera='".$valor['codigocarrera']."'
					ORDER BY op.codigoestudiante";
			}
			else
			{	
				$query="SELECT DISTINCT
							op.numeroordenpago,
							op.codigoperiodo,
							eg.idestudiantegeneral,
							eg.numerodocumento,
							op.codigoestudiante,
							op.documentocuentaxcobrarsap,
							op.documentocuentacompensacionsap,
							sub.fecha_limite_pago,
							sce.nombresituacioncarreraestudiante,
							te.nombretipoestudiante,
							op.fechaordenpago AS fecha_creacion_ordenpago,
							op.fechapagosapordenpago,
							eop.nombreestadoordenpago,
							c.nombreconcepto,
							c.codigoconcepto,
							dop.valorconcepto,
							concat(
								eg.apellidosestudiantegeneral,
								' ',
								eg.nombresestudiantegeneral
							) AS nombre,
							car.nombrecarrera,
							e.semestre AS semestre,
							eg.emailestudiantegeneral AS email,
							eg.telefonoresidenciaestudiantegeneral AS teléfono_fijo,
							eg.celularestudiantegeneral AS teléfono_celular,
							eg.numerodocumento AS documento,

						IF (
							e.semestre = '',
							0,
							dc.valordetallecohorte
						) AS valordetallecohorte
						FROM
							ordenpago op
						INNER JOIN estadoordenpago eop ON op.codigoestadoordenpago = eop.codigoestadoordenpago
						INNER JOIN estudiante e ON op.codigoestudiante = e.codigoestudiante
						INNER JOIN detalleordenpago dop ON op.numeroordenpago = dop.numeroordenpago
						INNER JOIN concepto c ON c.codigoconcepto = dop.codigoconcepto
						INNER JOIN tipoestudiante te ON e.codigotipoestudiante = te.codigotipoestudiante
						INNER JOIN carrera car ON e.codigocarrera = car.codigocarrera
						INNER JOIN estudiantegeneral eg ON e.idestudiantegeneral = eg.idestudiantegeneral
						INNER JOIN (
							SELECT
								numeroordenpago,
								group_concat(
									fechaordenpago
									ORDER BY
										fechaordenpago SEPARATOR ' / '
								) AS fecha_limite_pago
							FROM
								fechaordenpago
							GROUP BY
								numeroordenpago
						) AS sub ON op.numeroordenpago = sub.numeroordenpago
						INNER JOIN situacioncarreraestudiante sce ON e.codigosituacioncarreraestudiante = sce.codigosituacioncarreraestudiante
						LEFT JOIN cohorte coh ON coh.codigocarrera = e.codigocarrera
						AND coh.codigoperiodo = op.codigoperiodo
						LEFT JOIN detallecohorte dc ON dc.idcohorte = coh.idcohorte
						AND (
							dc.semestredetallecohorte = e.semestre
							OR e.semestre = ''
						)
						WHERE
							op.codigoperiodo = '$codigoperiodo'
						AND dop.codigoconcepto = '$codigoconcepto'
						AND e.codigocarrera = '".$valor['codigocarrera']."'
						ORDER BY
							op.codigoestudiante";				
				/*Anterior
				
				$query="SELECT DISTINCT op.numeroordenpago
						, op.codigoperiodo
						, eg.idestudiantegeneral
						, eg.numerodocumento
						, op.codigoestudiante
						, op.documentocuentaxcobrarsap
						, op.documentocuentacompensacionsap
						, sub.fecha_limite_pago
						, sce.nombresituacioncarreraestudiante
						, te.nombretipoestudiante
						, op.fechaordenpago as fecha_creacion_ordenpago
						, op.fechapagosapordenpago
						, eop.nombreestadoordenpago
						, c.nombreconcepto
						, c.codigoconcepto
						, dop.valorconcepto
						, concat(eg.apellidosestudiantegeneral,' ', eg.nombresestudiantegeneral) as nombre
						, car.nombrecarrera
						, e.semestre as semestre
						, eg.emailestudiantegeneral as email
						, eg.telefonoresidenciaestudiantegeneral as teléfono_fijo
						, eg.celularestudiantegeneral as teléfono_celular
						, eg.numerodocumento as documento,						
						IF(e.semestre='',0,dc.valordetallecohorte) as valordetallecohorte
					FROM ordenpago op
					, detalleordenpago dop
					, estadoordenpago eop
					, concepto c
					, estudiante e
					, estudiantegeneral eg
					, carrera car
					, situacioncarreraestudiante sce
					, tipoestudiante te,
						cohorte coh,
						detallecohorte dc
					, (select numeroordenpago,group_concat(fechaordenpago order by fechaordenpago separator ' / ') as fecha_limite_pago from fechaordenpago group by numeroordenpago) as sub
					WHERE op.numeroordenpago=dop.numeroordenpago 
						AND op.codigoestadoordenpago = eop.codigoestadoordenpago 
						AND c.codigoconcepto=dop.codigoconcepto 
						AND e.codigosituacioncarreraestudiante=sce.codigosituacioncarreraestudiante
						AND e.codigotipoestudiante=te.codigotipoestudiante
						AND op.numeroordenpago=sub.numeroordenpago
						AND dc.idcohorte = coh.idcohorte
						AND coh.codigocarrera = e.codigocarrera
						 AND coh.codigoperiodo = op.codigoperiodo
						 AND (dc.semestredetallecohorte = e.semestre OR e.semestre='') 
						AND op.codigoperiodo='$codigoperiodo'
						AND dop.codigoconcepto = '$codigoconcepto'
						AND op.codigoestudiante=e.codigoestudiante 
						AND e.idestudiantegeneral=eg.idestudiantegeneral 
						AND e.codigocarrera=car.codigocarrera 
						AND e.codigocarrera='".$valor['codigocarrera']."'
					ORDER BY op.codigoestudiante";*/
			}

    		$operacion=$this->conexion->query($query);
			$row_operacion=$operacion->fetchRow();
			do
			{
				if($row_operacion['codigoestudiante']<>'')
				{
					$array_interno[]=$row_operacion;
				}
			}
			while ($row_operacion=$operacion->fetchRow());
		}
		if($this->debug==true)
		{
			$this->tabla($array_interno,"LeerEstudiantesDescuento");
		}
		return $array_interno;
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
		if(is_array($matriz))
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
		else
		{
			echo $texto." Matriz no valida<br>";
		}
	}

}

?>
