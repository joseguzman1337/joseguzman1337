<?php
class snies
{
	var $array_carreras;
	var $array_periodo;

	function snies($conexion,$codigoperiodo)
	{
		$this->conexion=$conexion;
		$this->codigoperiodo=$codigoperiodo;
		$this->fechahoy=date("Y-m-d H:i:s");
		$this->obtener_periodo();
	}

	function obtener_periodo($codigoperiodo="")
	{
		if($codigoperiodo!="")
		{
			$query="SELECT * FROM periodo p WHERE p.codigoperiodo='$codigoperiodo'";
		}
		else
		{
			$query="SELECT * FROM periodo p WHERE p.codigoperiodo='$this->codigoperiodo'";
		}
		$operacion=$this->conexion->query($query);
		$row_operacion=$operacion->fetchRow();
		$this->array_periodo=$row_operacion;
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
		$this->array_carreras=$array_obtener_carreras;
		return $this->array_carreras;
	}

	function obtener_datos_estudiante($codigoestudiante)
	{
		$query="
		SELECT e.codigoestudiante,
		eg.idestudiantegeneral,
		c.nombrecarrera,
		eg.numerodocumento,
		d.nombrecortodocumento,
		eg.apellidosestudiantegeneral,
		eg.nombresestudiantegeneral,
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
		estudiante e, estudiantegeneral eg, carrera c, estadocivil ec, ciudad ciu, jornada j, tipoestudiante te, situacioncarreraestudiante sce,  genero g, documento d
		WHERE
		e.idestudiantegeneral=eg.idestudiantegeneral
		AND eg.tipodocumento=d.tipodocumento
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

	function obtener_egresados()
	{
		foreach ($this->array_carreras as $llave => $valor)
		{
			$query="
			SELECT
			e.codigoestudiante,e.codigocarrera,rg.fechagradoregistrograduado,c.nombrecarrera,rg.numeroactaregistrograduado,drgf.idregistrograduadofolio
			FROM registrograduado rg, estudiante e, carrera c, registrograduadofolio rgf, detalleregistrograduadofolio drgf
			WHERE e.codigoestudiante=rg.codigoestudiante
			AND e.codigocarrera='".$valor['codigocarrera']."'
			AND drgf.idregistrograduado=rg.idregistrograduado
			AND drgf.idregistrograduadofolio=rgf.idregistrograduadofolio
			AND e.codigocarrera=c.codigocarrera
			AND rg.fechagradoregistrograduado >= '".$this->array_periodo['fechainicioperiodo']."'
			AND rg.fechagradoregistrograduado <= '".$this->array_periodo['fechavencimientoperiodo']."'
			";	
			//echo $query,"<br><br>";
			$operacion=$this->conexion->query($query);
			$row_operacion=$operacion->fetchRow();
			do
			{
				if(is_array($row_operacion))
				{
					if($row_operacion['codigoestudiante']!="")
					{
						$array_interno[]=$row_operacion;
					}
				}
			}
			while($row_operacion=$operacion->fetchRow());

		}
		return $array_interno;

	}

	function obtener_reg_icfes($codigocarrera)
	{
		$query="SELECT cr.numeroregistrocarreraregistro FROM carreraregistro cr
		WHERE
		cr.codigocarrera=$codigocarrera
		";
		//echo $query,"<br><br>";
		$operacion=$this->conexion->query($query);
		$row_operacion=$operacion->fetchRow();
		return $row_operacion;

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