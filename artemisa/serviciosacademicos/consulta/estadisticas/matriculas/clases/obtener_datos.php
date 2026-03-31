<?php
class obtener_datos_matriculas
{
	function obtener_datos_matriculas($conexion,$codigoperiodo)
	{
		$this->conexion=$conexion;
		$this->codigoperiodo=$codigoperiodo;
		$this->fechahoy=date("Y-m-d H:i:s");
	}

	function obtener_carreras($codigomodalidadacademica="",$codigocarrera="")
	{
		if($codigocarrera!="")
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
		elseif($codigomodalidadacademica!="")
		{
			$query_obtener_carreras="SELECT c.codigocarrera,c.nombrecarrera,c.codigomodalidadacademica
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
			$query_obtener_carreras="SELECT c.codigocarrera,c.nombrecarrera,c.codigomodalidadacademica
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

	function obtener_datos_base($codigoconcepto)
	{
		foreach ($this->array_obtener_carreras as $clave => $valor)
		{
			$query_obtener_datos_base="
			SELECT DISTINCT do.codigoconcepto,SUM(do.valorconcepto) AS total, COUNT(do.valorconcepto) AS cantidad 
			FROM detalleordenpago do, ordenpago o, estudiante e, carrera c
			WHERE do.numeroordenpago = o.numeroordenpago
			AND o.codigoestudiante = e.codigoestudiante
			AND c.codigocarrera = e.codigocarrera
			AND o.codigoestadoordenpago LIKE '4%'
			AND c.codigocarrera='".$valor['codigocarrera']."'
			AND do.codigoconcepto = '".$codigoconcepto."'
			AND o.codigoperiodo = '".$this->codigoperiodo."'
			GROUP by c.nombrecarrera, do.codigoconcepto
			ORDER by c.codigocarrera
			";	
			$obtener_datos_base=$this->conexion->query($query_obtener_datos_base);
			$row_obtener_datos_base=$obtener_datos_base->fetchRow();
			//echo $query_obtener_datos_base,"<br><br>";
			$array_obtener_datos_base[]=$row_obtener_datos_base;
		}
		$this->array_obtener_datos_base=$array_obtener_datos_base;
		return $array_obtener_datos_base;
	}

	function contar_cantidades($codigoconcepto)
	{
		foreach ($this->array_obtener_carreras as $clave => $valor)
		{
			$query_obtener_datos_base="
			SELECT DISTINCT e.codigoestudiante
			FROM estudiante e, ordenpago o, detalleordenpago do
			WHERE 
			e.codigoestudiante = o.codigoestudiante
			AND o.codigoestadoordenpago LIKE '4%'
			AND e.codigocarrera = '".$valor['codigocarrera']."'
			AND o.codigoperiodo = '".$this->codigoperiodo."'
			AND do.codigoconcepto = '".$codigoconcepto."'
			AND do.numeroordenpago = o.numeroordenpago
			";	
			$obtener_datos_base=$this->conexion->query($query_obtener_datos_base);
			$row_obtener_datos_base=$obtener_datos_base->fetchRow();
			do
			{
				if($row_obtener_datos_base['codigoestudiante']!="")
				{
					$array_obtener_datos_base[]=$row_obtener_datos_base;
				}
			}
			while($row_obtener_datos_base=$obtener_datos_base->fetchRow());
			$array_cantidades[]=count($array_obtener_datos_base);
			unset($array_obtener_datos_base);
		}
		//print_r($array_cantidades);echo $clave;echo "<br><br>";
		return $array_cantidades;
	}
	function contar_valores($codigoconcepto)
	{
		foreach ($this->array_obtener_carreras as $clave => $valor)
		{
			$query_calcular_totales_datos_base="
			SELECT DISTINCT  e.codigocarrera,SUM(do.valorconcepto) AS valortotal
			FROM estudiante e, ordenpago o, detalleordenpago do
			WHERE e.codigoestudiante = o.codigoestudiante
			AND o.codigoestadoordenpago LIKE '4%'
			AND e.codigocarrera = '".$valor['codigocarrera']."'
			AND o.codigoperiodo = '".$this->codigoperiodo."'
			AND do.codigoconcepto = '".$codigoconcepto."'
			AND do.numeroordenpago = o.numeroordenpago
			GROUP BY do.valorconcepto
			";	
			$calcular_totales_datos_base=$this->conexion->query($query_calcular_totales_datos_base);
			$row_calcular_totales_datos_base=$calcular_totales_datos_base->fetchRow();
			//echo $query_calcular_totales_datos_base,"<br><br>";
			$array_calcular_totales_datos_base[]=$row_calcular_totales_datos_base;
		}
		return $array_calcular_totales_datos_base;
	}
	function obtener_cantidad_pagosxinternet($codigoconcepto)
	{
		foreach ($this->array_obtener_carreras as $clave => $valor)
		{
			$query_obtener_cantidad_pagosxinternet="SELECT DISTINCT COUNT(op.numeroordenpago) AS cantidad, SUM(dop.valorconcepto) AS valor
			FROM
			ordenpago op, detalleordenpago dop, estudiante e, carrera c, LogPagos lp
			WHERE
			op.codigoperiodo='".$this->codigoperiodo."'
			AND e.codigoestudiante=op.codigoestudiante
			AND e.codigocarrera=c.codigocarrera
			AND op.numeroordenpago=dop.numeroordenpago
			AND op.codigoestadoordenpago LIKE '4%'
			AND dop.codigoconcepto='".$codigoconcepto."'
			AND c.codigocarrera='".$valor['codigocarrera']."'
			AND lp.Reference1=op.numeroordenpago
			AND lp.StaCode='OK'
			";
			//echo $query_obtener_cantidad_pagosxinternet,"<br><br>";
			$obtener_cantidad_pagosxinternet=$this->conexion->query($query_obtener_cantidad_pagosxinternet);
			$row_obtener_cantidad_pagosxinternet=$obtener_cantidad_pagosxinternet->fetchRow();
			$array_cantidad[]=$row_obtener_cantidad_pagosxinternet;
		}
		return $array_cantidad;
	}

	function contar_valores_por_tipestudiante($codigotipoestudiante)
	{
		foreach ($this->array_obtener_carreras as $clave => $valor)
		{
			$query_obtener_datos_base="
			SELECT DISTINCT e.codigoestudiante
			FROM estudiante e, ordenpago o, detalleordenpago do
			WHERE 
			e.codigoestudiante = o.codigoestudiante
			AND o.codigoestadoordenpago LIKE '4%'
			AND e.codigotipoestudiante='".$codigotipoestudiante."'
			AND e.codigocarrera = '".$valor['codigocarrera']."'
			AND o.codigoperiodo = '".$this->codigoperiodo."'
			AND do.codigoconcepto = '151'
			AND do.numeroordenpago = o.numeroordenpago
			";	
			$obtener_datos_base=$this->conexion->query($query_obtener_datos_base);
			$row_obtener_datos_base=$obtener_datos_base->fetchRow();
			do
			{
				if($row_obtener_datos_base['codigoestudiante']!="")
				{
					$array_obtener_datos_base[]=$row_obtener_datos_base;
				}
			}
			while($row_obtener_datos_base=$obtener_datos_base->fetchRow());
			$array_cantidades[]=count($array_obtener_datos_base);
			unset($array_obtener_datos_base);
		}
		//print_r($array_cantidades);echo $clave;echo "<br><br>";
		return $array_cantidades;
	}

	function contar_cantidad_alumnos_codigosituacioncarreraestudiante($codigosituacioncarreraestudiante)
	{
		foreach ($this->array_obtener_carreras as $clave => $valor)
		{
			$query_conteo="
			SELECT count(e.codigosituacioncarreraestudiante) as total
			FROM
			estudiante e
			WHERE
			e.codigocarrera = '".$valor['codigocarrera']."'
			AND e.codigosituacioncarreraestudiante='".$codigosituacioncarreraestudiante."'
			AND e.codigoperiodo='".$this->codigoperiodo."' 
			";
			//echo $query_conteo,"<br><br>";
			$conteo=$this->conexion->query($query_conteo);
			$row_conteo=$conteo->fetchRow();
			do
			{
				$array_conteo[]=$row_conteo;
			}
			while($row_conteo=$conteo->fetchRow());
		}
		return $array_conteo;
	}

	function obtener_cantidad_alumnos_matriculados($codigotipoestudiante)
	{
		foreach ($this->array_obtener_carreras as $clave => $valor)
		{
			$query_obtener_cantidad_alumnos_matriculados="SELECT DISTINCT c.codigocarrera,SUM(do.valorconcepto) AS total, COUNT(do.valorconcepto) AS cantidad
			FROM detalleordenpago do, ordenpago o, estudiante e, carrera c, concepto con
			WHERE do.numeroordenpago = o.numeroordenpago
			AND o.codigoestudiante = e.codigoestudiante
			AND c.codigocarrera = e.codigocarrera
			AND c.codigocarrera='".$valor['codigocarrera']."'
			AND do.codigoconcepto = '151'
			AND o.codigoperiodo = '".$this->codigoperiodo."'
			AND con.codigoconcepto = do.codigoconcepto
			AND e.codigotipoestudiante='".$codigotipoestudiante."'
			AND o.codigoestadoordenpago LIKE '4%'
			GROUP by e.codigotipoestudiante, do.codigoconcepto
			ORDER by c.codigocarrera
			";
			//echo $query_obtener_cantidad_alumnos_matriculados,"<br><br>";
			$obtener_cantidad_alumnos_matriculados=$this->conexion->query($query_obtener_cantidad_alumnos_matriculados);
			$row_obtener_cantidad_alumnos_matriculados=$obtener_cantidad_alumnos_matriculados->fetchRow();
			$array_cantidad_alumnos_matriculados[]=$row_obtener_cantidad_alumnos_matriculados;
		}
		return $array_cantidad_alumnos_matriculados;
	}

	function obtener_codigosestudiante_base($desc,$codigocarrera,$codigoconcepto,$codigoperiodo,$codigotipoestudiante="",$tipopago="",$codigosituacioncarreraestudiante="")
	{
		if($desc=='prematriculados')
		{
			$query_obtener_codigosestudiante_base=
			"
			SELECT e.codigoestudiante
			FROM
			estudiante e, prematricula pr
			WHERE
			e.codigocarrera='".$codigocarrera."'
			AND e.codigoestudiante=pr.codigoestudiante
			AND pr.codigoperiodo='".$codigoperiodo."'
			AND pr.codigoestadoprematricula like '1%'
			GROUP BY e.codigoestudiante
			";
		}
		elseif($desc=='no_prematriculados')
		{
			$query_obtener_codigosestudiante_base=
			"
			
			";
		}

		//echo $codigocarrera,$codigoconcepto,$codigoperiodo,$codigotipoestudiante,$tipopago,$codigosituacioncarreraestudiante;
		elseif($tipopago=="presencial")
		{
			if($codigotipoestudiante==0)
			{
				$query_obtener_codigosestudiante_base="
				SELECT DISTINCT o.numeroordenpago,e.codigoestudiante
				FROM detalleordenpago do, ordenpago o, estudiante e, carrera c, concepto con, LogPagos lp
				WHERE do.numeroordenpago = o.numeroordenpago
				AND o.codigoestudiante = e.codigoestudiante
				AND c.codigocarrera = e.codigocarrera
				AND c.codigocarrera='".$codigocarrera."'
				AND do.codigoconcepto = '".$codigoconcepto."'
				AND o.codigoperiodo = '".$codigoperiodo."'
				AND con.codigoconcepto = do.codigoconcepto
				AND o.codigoestadoordenpago LIKE '4%'
				AND o.numeroordenpago NOT IN(SELECT lp.Reference1 FROM LogPagos lp WHERE StaCode='OK')
				GROUP BY e.codigoestudiante
				";
			}
			else
			{
				$query_obtener_codigosestudiante_base="
				SELECT DISTINCT o.numeroordenpago,e.codigoestudiante
				FROM detalleordenpago do, ordenpago o, estudiante e, carrera c, concepto con, LogPagos lp
				WHERE do.numeroordenpago = o.numeroordenpago
				AND o.codigoestudiante = e.codigoestudiante
				AND c.codigocarrera = e.codigocarrera
				AND c.codigocarrera='".$codigocarrera."'
				AND do.codigoconcepto = '".$codigoconcepto."'
				AND o.codigoperiodo = '".$codigoperiodo."'
				AND con.codigoconcepto = do.codigoconcepto
				AND e.codigotipoestudiante='".$codigotipoestudiante."'
				AND o.codigoestadoordenpago LIKE '4%'
				AND o.numeroordenpago NOT IN(SELECT lp.Reference1 FROM LogPagos lp WHERE StaCode='OK')
				GROUP BY e.codigoestudiante
				";

			}
		}
		elseif($tipopago=="internet")
		{
			if($codigotipoestudiante==0)
			{
				$query_obtener_codigosestudiante_base="
				SELECT DISTINCT o.numeroordenpago,e.codigoestudiante
				FROM detalleordenpago do, ordenpago o, estudiante e, carrera c, concepto con, LogPagos lp
				WHERE do.numeroordenpago = o.numeroordenpago
				AND o.codigoestudiante = e.codigoestudiante
				AND c.codigocarrera = e.codigocarrera
				AND c.codigocarrera='".$codigocarrera."'
				AND do.codigoconcepto = '".$codigoconcepto."'
				AND o.codigoperiodo = '".$codigoperiodo."'
				AND con.codigoconcepto = do.codigoconcepto
				AND o.codigoestadoordenpago LIKE '4%'
				AND o.numeroordenpago IN(SELECT lp.Reference1 FROM LogPagos lp WHERE StaCode='OK')
				GROUP BY e.codigoestudiante
				";
			}
			else{
				$query_obtener_codigosestudiante_base="
				SELECT DISTINCT o.numeroordenpago,e.codigoestudiante
				FROM detalleordenpago do, ordenpago o, estudiante e, carrera c, concepto con, LogPagos lp
				WHERE do.numeroordenpago = o.numeroordenpago
				AND o.codigoestudiante = e.codigoestudiante
				AND c.codigocarrera = e.codigocarrera
				AND c.codigocarrera='".$codigocarrera."'
				AND do.codigoconcepto = '".$codigoconcepto."'
				AND o.codigoperiodo = '".$codigoperiodo."'
				AND con.codigoconcepto = do.codigoconcepto
				AND e.codigotipoestudiante='".$codigotipoestudiante."'
				AND o.codigoestadoordenpago LIKE '4%'
				AND o.numeroordenpago IN(SELECT lp.Reference1 FROM LogPagos lp WHERE StaCode='OK')
				GROUP BY e.codigoestudiante
				";
			}

		}
		elseif($tipopago=="no")
		{
			$query_obtener_codigosestudiante_base="
			SELECT e.codigoestudiante
			FROM
			estudiante e
			WHERE
			e.codigocarrera = '".$codigocarrera."'
			AND e.codigosituacioncarreraestudiante='".$codigosituacioncarreraestudiante."'
			AND e.codigoperiodo='".$this->codigoperiodo."'
			";
		}
		elseif ($tipopago==0)
		{
			if($codigotipoestudiante==0)
			{
				$query_obtener_codigosestudiante_base="
				SELECT DISTINCT o.numeroordenpago,e.codigoestudiante
				FROM detalleordenpago do, ordenpago o, estudiante e, carrera c, concepto con
				WHERE do.numeroordenpago = o.numeroordenpago
				AND o.codigoestudiante = e.codigoestudiante
				AND c.codigocarrera = e.codigocarrera
				AND c.codigocarrera='".$codigocarrera."'
				AND do.codigoconcepto = '".$codigoconcepto."'
				AND o.codigoperiodo = '".$codigoperiodo."'
				AND con.codigoconcepto = do.codigoconcepto
				AND o.codigoestadoordenpago LIKE '4%'
				GROUP BY e.codigoestudiante
				";
			}
			else
			{
				$query_obtener_codigosestudiante_base="
				SELECT DISTINCT o.numeroordenpago,e.codigoestudiante
				FROM detalleordenpago do, ordenpago o, estudiante e, carrera c, concepto con
				WHERE do.numeroordenpago = o.numeroordenpago
				AND o.codigoestudiante = e.codigoestudiante
				AND c.codigocarrera = e.codigocarrera
				AND c.codigocarrera='".$codigocarrera."'
				AND do.codigoconcepto = '".$codigoconcepto."'
				AND o.codigoperiodo = '".$codigoperiodo."'
				AND con.codigoconcepto = do.codigoconcepto
				AND e.codigotipoestudiante='".$codigotipoestudiante."'
				AND o.codigoestadoordenpago LIKE '4%'
				GROUP BY e.codigoestudiante
				";
			}

		}

		$query_obtener_codigosestudiante_base;
		$obtener_codigosestudiante_base=$this->conexion->query($query_obtener_codigosestudiante_base);
		$row_obtener_codigosestudiante_base=$obtener_codigosestudiante_base->fetchRow();
		do
		{
			$array_obtener_codigosestudiante_base[]=$row_obtener_codigosestudiante_base;
		}
		while($row_obtener_codigosestudiante_base=$obtener_codigosestudiante_base->fetchRow());
		$this->array_obtener_codigosestudiante_base=$array_obtener_codigosestudiante_base;
		return $array_obtener_codigosestudiante_base;
	}

	function obtener_datos_estudiantes()
	{
		foreach ($this->array_obtener_codigosestudiante_base as $llave => $valor)
		{
			$query_obtener_datos_estudiante="
			SELECT e.codigoestudiante,
			eg.numerodocumento,
			concat(eg.apellidosestudiantegeneral,' ',eg.nombresestudiantegeneral) as nombre,
			eg.direccionresidenciaestudiantegeneral,
			eg.telefonoresidenciaestudiantegeneral,
			eg.celularestudiantegeneral,
			eg.emailestudiantegeneral,
			eg.email2estudiantegeneral
			FROM
			estudiante e, estudiantegeneral eg, carrera c
			WHERE
			e.idestudiantegeneral=eg.idestudiantegeneral
			AND e.codigocarrera=c.codigocarrera
			AND e.codigoestudiante='".$valor['codigoestudiante']."'
			";
			$obtener_datos_estudiante=$this->conexion->query($query_obtener_datos_estudiante);
			$row_obtener_datos_estudiante=$obtener_datos_estudiante->fetchRow();
			$array_obtener_datos_estudiante[]=$row_obtener_datos_estudiante;
		}
		return ($array_obtener_datos_estudiante);
	}
	function obtener_cantidad_prematriculados()
	{
		foreach ($this->array_obtener_carreras as $clave => $valor)
		{
			$query_obtener_cantidad_prematriculados="
			SELECT count(e.codigoestudiante) as cantidad
			FROM
			estudiante e, prematricula pr
			WHERE
			e.codigocarrera='".$valor['codigocarrera']."'
			AND e.codigoestudiante=pr.codigoestudiante
			AND pr.codigoperiodo='".$this->codigoperiodo."'
			AND pr.codigoestadoprematricula like '1%'
			";
			$obtener_cantidad_prematriculados=$this->conexion->query($query_obtener_cantidad_prematriculados);
			$row_obtener_cantidad_prematriculados=$obtener_cantidad_prematriculados->fetchRow();
			$array_cantidad[]=$row_obtener_cantidad_prematriculados;
		}
		return $array_cantidad;

	}

	function barra()
	{
		echo "<div style='float:left;margin:10px 0px 0px 1px;width:5px;height:12px;background:white;color:white;'></div>";
		//echo "<div id='progress' style='position:relative;padding:0px;width:2048px;height:60px;left:25px;'>";
		flush();
		ob_flush();
	}
}
?>