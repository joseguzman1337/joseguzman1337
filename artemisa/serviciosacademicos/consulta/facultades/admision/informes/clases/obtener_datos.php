<?php
class obtener_datos_admisiones
{
	function obtener_datos_admisiones($conexion,$codigoperiodo)
	{
		$this->conexion=$conexion;
		$this->codigoperiodo=$codigoperiodo;
		$this->fechahoy=date("Y-m-d H:i:s");
	}

	function obtener_carreras($codigomodalidadacademica="",$codigocarrera="")
	{
		if($codigocarrera!="")
		{
			$query_obtener_carreras="SELECT c.codigocarrera
			FROM
			carrera c
			WHERE
			c.codigocarrera='".$codigocarrera."'
			AND c.fechainiciocarrera <= '".$this->fechahoy."' and c.fechavencimientocarrera >= '".$this->fechahoy."'
			ORDER BY c.codigocarrera
			";
		}
		elseif($codigomodalidadacademica!="")
		{
			$query_obtener_carreras="SELECT c.codigocarrera
			FROM
			carrera c
			WHERE
			c.codigomodalidadacademica='".$codigomodalidadacademica."'
			AND c.fechainiciocarrera <= '".$this->fechahoy."' and c.fechavencimientocarrera >= '".$this->fechahoy."'
			ORDER BY c.codigocarrera
			";
		}
		else
		{
			$query_obtener_carreras="SELECT c.codigocarrera
			FROM
			carrera c
			WHERE
			c.fechainiciocarrera <= '".$this->fechahoy."' and c.fechavencimientocarrera >= '".$this->fechahoy."'
			ORDER BY c.codigocarrera
			";
		}
		//echo $query_obtener_carreras;
		$obtener_carreras=$this->conexion->query($query_obtener_carreras);
		$row_obtener_carreras=$obtener_carreras->fetchRow();
		do
		{
			$array_obtener_carreras[]=$row_obtener_carreras;
		}
		while($row_obtener_carreras=$obtener_carreras->fetchRow());
		$this->array_obtener_carreras=$array_obtener_carreras;
		return $array_obtener_carreras;
	}

	function obtener_estudiantes()
	{
		foreach ($this->array_obtener_carreras as $llave => $valor)
		{
			$query_obtener_estudiantes="
			SELECT 
			c.codigocarrera,c.nombrecarrera,e.codigoestudiante,e.idestudiantegeneral
			FROM
			estudiante e, inscripcion i, carrera c
			WHERE
			e.codigocarrera=c.codigocarrera
			AND (e.codigosituacioncarreraestudiante=107 or e.codigosituacioncarreraestudiante=300)
			AND i.codigoperiodo='".$this->codigoperiodo."'
			AND e.codigocarrera='".$valor['codigocarrera']."'
			AND e.idestudiantegeneral=i.idestudiantegeneral
			GROUP BY e.codigoestudiante
			";
			//echo $query_obtener_estudiantes,"<br><br><br>";
			$operacion=$this->conexion->query($query_obtener_estudiantes);
			$row_obtener_estudiantes=$operacion->fetchRow();
			do
			{
				if($row_obtener_estudiantes['codigoestudiante']!="")
				{
					$this->array_obtener_estudiantes[]=$row_obtener_estudiantes;
				}
			}
			while ($row_obtener_estudiantes=$operacion->fetchRow());
		}
		return $this->array_obtener_estudiantes;
	}

	function obtener_estudiantes_estadoadmision()
	{
		foreach ($this->array_obtener_estudiantes as $llave => $valor)
		{
			$query_obtener_estudiantes_estadoadmision="
			SELECT e.codigoestudiante, nombresituacioncarreraestudiante
			FROM estudiante e,situacioncarreraestudiante sce
			WHERE
			e.codigosituacioncarreraestudiante=sce.codigosituacioncarreraestudiante
			AND e.codigoestudiante='".$valor['codigoestudiante']."'
			";
			//echo $query_obtener_estudiantes_estadoadmision,"<br><br>";
			$operacion=$this->conexion->query($query_obtener_estudiantes_estadoadmision);
			$row_obtener_estudiantes_estadoadmision=$operacion->fetchRow();
			
			do
			{
				$array_obtener_estudiantes_estadoadmision[]=$row_obtener_estudiantes_estadoadmision;
			}
			while($row_obtener_estudiantes_estadoadmision=$operacion->fetchRow());

		}
		return $array_obtener_estudiantes_estadoadmision;
	}

	function obtener_datos_estudiantes()
	{
		foreach ($this->array_obtener_estudiantes as $llave => $valor)
		{
			$query_obtener_datos_estudiantes="
			SELECT
			e.codigocarrera,
			e.codigoestudiante,
			concat(eg.apellidosestudiantegeneral,' ',eg.nombresestudiantegeneral) as nombre,
			eg.numerodocumento,
			g.nombregenero,
			(eg.fechanacimientoestudiantegeneral) as fechanacimiento
			FROM
			estudiante e,estudiantegeneral eg, genero g
			WHERE
			e.idestudiantegeneral=eg.idestudiantegeneral
			AND e.codigoestudiante='".$valor['codigoestudiante']."'
			AND eg.codigogenero=g.codigogenero
			";
			//echo $query_obtener_datos_estudiantes,"<br><br>";
			$operacion=$this->conexion->query($query_obtener_datos_estudiantes);
			$row_obtener_datos_estudiantes=$operacion->fetchRow();
			do
			{
				$array_obtener_datos_estudiantes[]=$row_obtener_datos_estudiantes;
			}
			while ($row_obtener_datos_estudiantes=$operacion->fetchRow());
		}
		return $array_obtener_datos_estudiantes;
	}

	function calcular_icfes_estudiantes()
	{
		foreach ($this->array_obtener_estudiantes as $llave => $valor)
		{
			$query_calcular_icfes_estudiantes="
			SELECT r.idestudiantegeneral,SUM(d.notadetalleresultadopruebaestado) as puntaje_total
			FROM detalleresultadopruebaestado d,resultadopruebaestado r,asignaturaestado a
			WHERE r.idestudiantegeneral = '".$valor['idestudiantegeneral']."'
			AND a.idasignaturaestado = d.idasignaturaestado
			AND r.idresultadopruebaestado = d.idresultadopruebaestado
			AND d.codigoestado=100
			AND r.codigoestado=100
			GROUP BY d.idresultadopruebaestado";
			//echo $query_calcular_icfes_estudiantes;echo "<br><br>";
			$operacion=$this->conexion->query($query_calcular_icfes_estudiantes);
			$row_operacion=$operacion->fetchRow();
			$array_calcular_icfes_estudiantes[]=$row_operacion;
		}
		return $array_calcular_icfes_estudiantes;
	}

	function obtener_salon_pruebas_estudiantes()
	{
		foreach ($this->array_obtener_estudiantes as $llave => $valor)
		{
			$query_obtener_salon_pruebas_estudiantes="
			SELECT e.codigocarrera,e.codigoestudiante, e.idestudiantegeneral,ee.observacionestudianteestudio
			FROM
			estudiante e,
			estudianteestudio ee
			WHERE
			ee.idestudiantegeneral=e.idestudiantegeneral
			AND e.idestudiantegeneral='".$valor['idestudiantegeneral']."'
			";
			//echo $query_obtener_salon_pruebas_estudiantes,"<br><br>";
			$operacion=$this->conexion->query($query_obtener_salon_pruebas_estudiantes);
			$row_operacion=$operacion->fetchRow();
			$array_obtener_salon_pruebas_estudiantes[]=$row_operacion;
		}
		return $array_obtener_salon_pruebas_estudiantes;
	}

	function obtener_tipos_detalle_admision()//determinar las pruebas en total que manejará el proceso
	{
		$query_determinar_tipos_detalle_admision="
			SELECT tda.*
			FROM
			tipodetalleadmision tda
			";
		//echo $query_determinar_tipos_detalle_admision;
		$operacion=$this->conexion->query($query_determinar_tipos_detalle_admision);
		$row_operacion=$operacion->fetchRow();
		do
		{
			$this->array_obtener_tipos_detalle_admision[]=$row_operacion;
		}
		while($row_operacion=$operacion->fetchRow());
		return $this->array_obtener_tipos_detalle_admision;
	}

	function obtener_datos_pruebas_estudiantes($codigotipodetalleadmision,$codigoestudiante)
	{
		$query_obtener_datos_pruebas_estudiantes="
			SELECT
			e.codigoestudiante,
			dea.idestudianteadmision,
			td.nombretipodetalleadmision,
			eea.nombreestadoestudianteadmision,
			dea.codigoestadoestudianteadmision,
			dea.resultadodetalleestudianteadmision,
			dea.iddetalleadmision,
			dea.idhorariositioadmision
			FROM
			estudianteadmision ea,
			admision a,
			estudiante e,
			detalleadmision da,
			estudiantegeneral eg,
			tipodetalleadmision td,
			detalleestudianteadmision dea,
			estadoestudianteadmision eea
			WHERE
			ea.codigoestudiante = e.codigoestudiante
			AND a.codigocarrera = e.codigocarrera
			AND a.codigoperiodo = '".$this->codigoperiodo."'
			AND da.idadmision = a.idadmision
			AND eg.idestudiantegeneral = e.idestudiantegeneral
			AND da.codigotipodetalleadmision = '".$codigotipodetalleadmision."'
			AND e.codigoestudiante = '".$codigoestudiante."'
			AND td.codigotipodetalleadmision = da.codigotipodetalleadmision
			AND dea.idestudianteadmision = ea.idestudianteadmision
			AND eea.codigoestadoestudianteadmision = dea.codigoestadoestudianteadmision
			AND ea.codigoestado LIKE '1%'
			AND dea.codigoestado LIKE '1%'
			AND dea.iddetalleadmision = da.iddetalleadmision
			ORDER BY 4";
		//echo $query_obtener_datos_pruebas_estudiantes,"<br><br><br>";
		$operacion=$this->conexion->query($query_obtener_datos_pruebas_estudiantes);
		$row_operacion=$operacion->fetchRow();
		//$array_obtener_datos_pruebas_estudiantes[]=$row_operacion;
		return $row_operacion;
	}

	function obtener_acumulado_pruebas_estudiantes($codigoestudiante)
	{
		$query_obtener_acumulado_pruebas_estudiantes="
		SELECT sum(resultadodetalleestudianteadmision  * porcentajedetalleadmision / totalpreguntasdetalleadmision) as total
		from estudianteadmision ea,detalleestudianteadmision dea,detalleadmision da,admision a
		where dea.idestudianteadmision = ea.idestudianteadmision
		AND da.iddetalleadmision = dea.iddetalleadmision
		and a.idadmision = da.idadmision 
		and ea.codigoestudiante = '".$codigoestudiante."'";
		$operacion=$this->conexion->query($query_obtener_acumulado_pruebas_estudiantes);
		$row_operacion=$operacion->fetchRow();
		//echo $query_obtener_acumulado_pruebas_estudiantes,"<br><br>";
		$total=$row_operacion['total'];
		return $total;
	}




	function edad($fecha)
	{
		list ($ano,$dia, $mes) = explode ('-', $fecha);
		$fecha = mktime (0,0,0,$mes,$dia,$ano);
		$fecha = time() - $fecha;
		$anos = round ($fecha/ (365*24*60*60));
		//$meses = $fecha - $anos * (365*24*60*60);
		//$meses = round($meses/ (30*24*60*60));
		return $anos;
	}

	function calcular_edad_estudiantes()
	{
		foreach ($this->array_obtener_estudiantes as $llave => $valor)
		{
			$edad=edad($valor['fechanacimiento']);
		}
		return $edad;
	}

}

?>