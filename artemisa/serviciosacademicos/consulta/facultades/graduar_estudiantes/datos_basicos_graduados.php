<?php
//error_reporting(0);
require_once("imprimir_array.php");
require_once("../../../../funciones/conexion/conexionpear.php");
class estudiante_graduado
{
	function estudiante_graduado($conexion)
	{
		$this->conexion=$conexion;
	}
	function obtener_listado_estudiantes_graduados($fecha_ini,$fecha_fin)
	{
		$this->fecha_ini=$fecha_ini;
		$this->fecha_fin=$fecha_fin;
		$query_obtener_listado_estudiantes_graduados="SELECT
		e.codigoestudiante,
		e.codigocarrera,
		rg.idregistrograduado,
		rg.codigoestado,
		concat(eg.apellidosestudiantegeneral,' ', eg.nombresestudiantegeneral) AS 'Nombre',
		eg.numerodocumento AS 'documento',
		eg.expedidodocumento as 'expedicion',
		c.nombrecarrera AS 'programa',
		t.nombretitulo AS 'titulo', 
		rg.numerodiplomaregistrograduado AS 'diploma',
		rg.numeropromocion as 'numeropromocion',
		rg.numeroactaregistrograduado AS 'numeroacta', 
		fechaactaregistrograduado as 'fechaacta',
		rg.numeroacuerdoregistrograduado as 'numeroacuerdo',
		rg.fechaacuerdoregistrograduado as 'fechaacuerdo',
		rg.fechagradoregistrograduado as 'fechagrado'
		FROM registrograduado rg, estudiantegeneral eg, estudiante e, carrera c, titulo t
		WHERE 
		rg.fechagradoregistrograduado BETWEEN '".$fecha_ini."' AND '".$fecha_fin."'
		AND rg.codigoautorizacionregistrograduado=100
		AND rg.codigoestudiante=e.codigoestudiante 
		AND e.idestudiantegeneral=eg.idestudiantegeneral 
		AND e.codigocarrera=c.codigocarrera
		AND c.codigotitulo=t.codigotitulo
		ORDER BY rg.idregistrograduado
		";
		//echo $query_obtener_listado_estudiantes_graduados;
		$obtener_listado_estudiantes_graduados=$this->conexion->query($query_obtener_listado_estudiantes_graduados);
		$row_obtener_listado_estudiantes_graduados=$obtener_listado_estudiantes_graduados->fetchRow();
		do
		{
			$array_obtener_listado_estudiantes_graduados[]=$row_obtener_listado_estudiantes_graduados;
		}
		while($row_obtener_listado_estudiantes_graduados=$obtener_listado_estudiantes_graduados->fetchRow());
		$this->array_obtener_listado_estudiantes_graduados=$array_obtener_listado_estudiantes_graduados;
		return $array_obtener_listado_estudiantes_graduados;
	}

	function separar_listado_estudiantes_graduados()
	{
		foreach ($this->array_obtener_listado_estudiantes_graduados as $clave => $valor)
		{
			if(
			$valor['codigocarrera']!=$codigocarrera_ini or
			$valor['numeropromocion']!=$numeropromocion_ini or
			$valor['numeroacta']!=$numeroacta_ini or
			$valor['numeroacuerdo']!=$numeroacuerdo_ini or
			$valor['fechagrado']!=$fechagrado_ini
			)
			{
				$query_separar_listado_estudiantes_graduados="SELECT
				e.codigoestudiante,
				e.codigocarrera,
				rg.idregistrograduado,
				concat(eg.apellidosestudiantegeneral,' ', eg.nombresestudiantegeneral) AS 'Nombre',
				eg.numerodocumento AS 'documento',
				eg.expedidodocumento as 'expedicion',
				c.nombrecarrera AS 'programa',
				t.nombretitulo AS 'titulo', 
				rg.numerodiplomaregistrograduado AS 'diploma',
				rg.numeropromocion as 'numeropromocion',
				rg.numeroactaregistrograduado AS 'numeroacta', 
				fechaactaregistrograduado as 'fechaacta',
				rg.numeroacuerdoregistrograduado as 'numeroacuerdo',
				rg.fechaacuerdoregistrograduado as 'fechaacuerdo',
				rg.fechagradoregistrograduado as 'fechagrado'
				FROM registrograduado rg, estudiantegeneral eg, estudiante e, carrera c, titulo t
				WHERE 
				rg.codigoautorizacionregistrograduado='100' AND
				rg.fechagradoregistrograduado BETWEEN '".$this->fecha_ini."' AND '".$this->fecha_fin."'
				AND rg.codigoestudiante=e.codigoestudiante 
				AND e.idestudiantegeneral=eg.idestudiantegeneral 
				AND e.codigocarrera=c.codigocarrera
				AND c.codigotitulo=t.codigotitulo
				AND c.codigocarrera='".$valor['codigocarrera']."'
				AND rg.numeropromocion='".$valor['numeropromocion']."'
				AND rg.numeroactaregistrograduado='".$valor['numeroacta']."'
				AND rg.numeroacuerdoregistrograduado='".$valor['numeroacuerdo']."'
				AND rg.fechagradoregistrograduado='".$valor['fechagrado']."'
				ORDER BY rg.idregistrograduado
				";
				//echo $query_separar_listado_estudiantes_graduados,"<br><br>";
				$separar_listado_estudiantes_graduados=$this->conexion->query($query_separar_listado_estudiantes_graduados);
				$row_separar_listado_estudiantes_graduados=$separar_listado_estudiantes_graduados->fetchRow();
				unset($array_separar_listado_estudiantes_graduados);
				do
				{
					$array_separar_listado_estudiantes_graduados[]=$row_separar_listado_estudiantes_graduados;
				}
				while($row_separar_listado_estudiantes_graduados=$separar_listado_estudiantes_graduados->fetchRow());
				//print_r($array_separar_listado_estudiantes_graduados);
				//listar($array_separar_listado_estudiantes_graduados,$contador);
				$array_matrices_separadas[]=$array_separar_listado_estudiantes_graduados;
				//echo "<br><br>";
				$contador=$contador+1;
				$codigocarrera_ini=$valor['codigocarrera'];
				$numeropromocion_ini=$valor['numeropromocion'];
				$numeroacta_ini=$valor['numeroacta'];
				$numeroacuerdo_ini=$valor['numeroacuerdo'];
				$fechagrado_ini=$valor['fechagrado'];
			}

		}
		//echo "<h1>",$contador,"</h1>";
		return $array_matrices_separadas;
	}
	function obtener_incentivos_academicos_totales()
	{
		foreach ($this->array_obtener_listado_estudiantes_graduados as $clave => $valor)
		{
			$query_obtener_incentivos_academicos_totales="SELECT
			rg.codigoestudiante,ia.nombreincentivoacademico,
			concat(eg.apellidosestudiantegeneral,' ', eg.nombresestudiantegeneral) AS Nombre,
			rg.numeropromocion,
			rg.fechagradoregistrograduado,
			rg.numeroactaregistrograduado,
			rg.numeroacuerdoregistrograduado
			FROM
			registrograduado rg,registroincentivoacademico ria,incentivoacademico ia, estudiante e, estudiantegeneral eg
			WHERE 
			rg.codigoestudiante='".$valor['codigoestudiante']."'
			AND rg.codigoestudiante=e.codigoestudiante
			AND e.idestudiantegeneral=eg.idestudiantegeneral
			AND rg.idregistrograduado=ria.idregistrograduado
			AND ria.idincentivoacademico<>1
			AND ria.idincentivoacademico=ia.idincentivoacademico
			";
			//echo $query_obtener_incentivos_academicos_estudiante,"<br><br>";
			$obtener_incentivos_academicos_totales=$this->conexion->query($query_obtener_incentivos_academicos_totales);
			$row_obtener_incentivos_academicos_totales=$obtener_incentivos_academicos_totales->fetchRow();
			//print_r($row_obtener_incentivos_academicos_estudiante);
			//if($row_obtener_incentivos_academicos_estudiante['codigoestudiante']!='')
			{
				$array_obtener_incentivos_academicos_totales[]=$row_obtener_incentivos_academicos_totales;
			}
		}
		$this->array_obtener_incentivos_academicos_totales=$array_obtener_incentivos_academicos_totales;
		return $array_obtener_incentivos_academicos_totales;
	}
	function obtener_incentivos_academicos_estudiantes($codigoestudiante)
	{
		$query_obtener_incentivos_academicos_estudiante="SELECT
		rg.codigoestudiante,ia.nombreincentivoacademico,
		concat(eg.apellidosestudiantegeneral,' ', eg.nombresestudiantegeneral) AS Nombre,
		rg.numeropromocion,
		rg.fechagradoregistrograduado,
		rg.numeroactaregistrograduado,
		rg.numeroacuerdoregistrograduado
		FROM
		registrograduado rg,registroincentivoacademico ria,incentivoacademico ia, estudiante e, estudiantegeneral eg
		WHERE 
		rg.codigoestudiante='".$codigoestudiante."'
		AND rg.codigoestudiante=e.codigoestudiante
		AND e.idestudiantegeneral=eg.idestudiantegeneral
		AND rg.idregistrograduado=ria.idregistrograduado
		AND ria.idincentivoacademico<>1
		AND ria.idincentivoacademico=ia.idincentivoacademico
		";
		//echo $query_obtener_incentivos_academicos_estudiante,"<br><br>";
		$obtener_incentivos_academicos_estudiante=$this->conexion->query($query_obtener_incentivos_academicos_estudiante);
		$row_obtener_incentivos_academicos_estudiante=$obtener_incentivos_academicos_estudiante->fetchRow();
		//print_r($row_obtener_incentivos_academicos_estudiante);
		//if($row_obtener_incentivos_academicos_estudiante['codigoestudiante']!='')
		$this->row_obtener_incentivos_academicos_estudiante=$row_obtener_incentivos_academicos_estudiante;
		return $row_obtener_incentivos_academicos_estudiante;
	}
	function obtener_incentivos_academicos_2($codigocarrera,$numeropromocion,$numeroacta,$numeroacuerdo)
	{
		$query_obtener_incentivos_academicos_estudiante="SELECT DISTINCT
		rg.codigoestudiante,ia.nombreincentivoacademico,
		concat(eg.apellidosestudiantegeneral,' ', eg.nombresestudiantegeneral) AS Nombre,
		rg.numeropromocion,
		rg.fechagradoregistrograduado,
		rg.numeroactaregistrograduado,
		rg.numeroacuerdoregistrograduado
		FROM
		registrograduado rg,registroincentivoacademico ria,incentivoacademico ia, estudiante e, estudiantegeneral eg, carrera c
		WHERE 
		e.idestudiantegeneral=eg.idestudiantegeneral
		AND rg.idregistrograduado=ria.idregistrograduado
		AND ria.idincentivoacademico=2
		AND ria.idincentivoacademico=ia.idincentivoacademico
		AND rg.numeropromocion='".$numeropromocion."'
		AND rg.numeroactaregistrograduado='".$numeroacta."'
		AND e.codigocarrera='".$codigocarrera."'
		AND rg.numeroacuerdoregistrograduado='".$numeroacuerdo."'
		AND rg.codigoestudiante=e.codigoestudiante
		";
		//echo $query_obtener_incentivos_academicos_estudiante,"<br><br><br>";
		$obtener_incentivos_academicos_rango=$this->conexion->query($query_obtener_incentivos_academicos_estudiante);
		$row_obtener_incentivos_academicos_rango=$obtener_incentivos_academicos_rango->fetchRow();
		do
		{
			if($row_obtener_incentivos_academicos_rango['codigoestudiante']!="")
			{
				$array_obtener_incentivos_academicos_rango[]=$row_obtener_incentivos_academicos_rango;
			}
		}
		while($row_obtener_incentivos_academicos_rango=$obtener_incentivos_academicos_rango->fetchRow());
		//print_r($row_obtener_incentivos_academicos_rango); echo "<br><br>";
		return $array_obtener_incentivos_academicos_rango;
	}

	function obtener_incentivos_academicos_3($codigocarrera,$numeropromocion,$numeroacta,$numeroacuerdo)
	{
		$query_obtener_incentivos_academicos_estudiante="SELECT DISTINCT
		rg.codigoestudiante,ia.nombreincentivoacademico,
		concat(eg.apellidosestudiantegeneral,' ', eg.nombresestudiantegeneral) AS Nombre,
		rg.numeropromocion,
		rg.fechagradoregistrograduado,
		rg.numeroactaregistrograduado,
		rg.numeroacuerdoregistrograduado
		FROM
		registrograduado rg,registroincentivoacademico ria,incentivoacademico ia, estudiante e, estudiantegeneral eg, carrera c
		WHERE 
		e.idestudiantegeneral=eg.idestudiantegeneral
		AND rg.idregistrograduado=ria.idregistrograduado
		AND ria.idincentivoacademico=3
		AND ria.idincentivoacademico=ia.idincentivoacademico
		AND rg.numeropromocion='".$numeropromocion."'
		AND rg.numeroactaregistrograduado='".$numeroacta."'
		AND rg.numeroacuerdoregistrograduado='".$numeroacuerdo."'
		AND e.codigocarrera='".$codigocarrera."'
		AND rg.codigoestudiante=e.codigoestudiante
		";
		//echo $query_obtener_incentivos_academicos_estudiante,"<br><br><br>";
		$obtener_incentivos_academicos_rango=$this->conexion->query($query_obtener_incentivos_academicos_estudiante);
		$row_obtener_incentivos_academicos_rango=$obtener_incentivos_academicos_rango->fetchRow();
		do
		{
			if($row_obtener_incentivos_academicos_rango['codigoestudiante']!="")
			{
				$array_obtener_incentivos_academicos_rango[]=$row_obtener_incentivos_academicos_rango;
			}
		}
		while($row_obtener_incentivos_academicos_rango=$obtener_incentivos_academicos_rango->fetchRow());
		//print_r($row_obtener_incentivos_academicos_rango); echo "<br><br>";
		return $array_obtener_incentivos_academicos_rango;
	}


	function obtener_cabeceras_listado_estudiantes_graduados()
	{
		$cabeceras=array_keys($this->array_obtener_listado_estudiantes_graduados[0]);
		foreach ($cabeceras as $clave => $valor)
		{
			$array_titulos[]=strtoupper($valor);
		}
		$this->array_titulos=$array_titulos;
		return $array_titulos;
	}
	function obtener_datos_carreras_grados($codigocarrera_grado)
	{

		$query_obtener_datos_carreras_grados="SELECT
		c.nombrecarrera,t.nombretitulo
		FROM
		estudiante e,carrera c, titulo t
		WHERE
		c.codigocarrera='".$codigocarrera_grado."'		
		AND c.codigotitulo=t.codigotitulo
		";
		//echo $query_obtener_datos_carreras_grados,"<br><br>";
		$obtener_datos_carreras_grados=$this->conexion->query($query_obtener_datos_carreras_grados);
		$row_obtener_datos_carreras_grados=$obtener_datos_carreras_grados->fetchRow();
		$this->array_obtener_datos_carreras_grados=$row_obtener_datos_carreras_grados;
		return $row_obtener_datos_carreras_grados;

	}
	function obtener_datos_basicos_estudiante($codigoestudiante)
	{
		$query_datos_basicos_estudiante = "SELECT
		carrera.nombrecarrera,
		carrera.codigofacultad,
		carrera.codigotitulo,
		titulo.nombretitulo,
		estudiantegeneral.idestudiantegeneral,
		estudiantegeneral.numerodocumento,
		estudiantegeneral.expedidodocumento,
		estudiantegeneral.nombrecortoestudiantegeneral,
		estudiantegeneral.nombresestudiantegeneral,
		estudiantegeneral.apellidosestudiantegeneral,
		carrera.codigocarrera,
		documento.tipodocumento,
		documento.nombredocumento
		FROM
		estudiante
		INNER JOIN estudiantegeneral ON (estudiante.idestudiantegeneral = estudiantegeneral.idestudiantegeneral)
		INNER JOIN carrera ON (estudiante.codigocarrera = carrera.codigocarrera)
		INNER JOIN titulo ON (carrera.codigotitulo = titulo.codigotitulo)
		INNER JOIN documento ON (estudiantegeneral.tipodocumento = documento.tipodocumento)
		WHERE estudiante.codigoestudiante='".$codigoestudiante."'
		";
		//echo $query_datos_basicos_estudiante,"<br>";
		$datos_basicos_estudiante=$this->conexion->query($query_datos_basicos_estudiante);
		$row_datos_basicos_estudiante=$datos_basicos_estudiante->fetchRow();
		$this->row_datos_basicos_estudiante=$row_datos_basicos_estudiante;
		//print_r($row_datos_basicos_estudiante);
		return $row_datos_basicos_estudiante;
	}
	function datos_universidad()
	{
		$query_universidad = "SELECT u.nombreuniversidad,direccionuniversidad,c.nombreciudad,p.nombrepais,u.paginawebuniversidad,u.imagenlogouniversidad,u.telefonouniversidad,u.faxuniversidad,u.nituniversidad,u.personeriauniversidad,u.entidadrigeuniversidad
		FROM universidad u,ciudad c,pais p,departamento d 
		WHERE u.iduniversidad = 1
		AND d.idpais = p.idpais
		AND u.idciudad = c.idciudad
		AND c.iddepartamento = d.iddepartamento";
		//echo $query_universidad;
		$universidad = $this->conexion->query($query_universidad);
		$row_universidad = $universidad->fetchRow();
		$this->row_universidad=$row_universidad;
		return $row_universidad;
	}
	function obtener_registro_grado_estudiante($codigoestudiante)
	{
		$query_obtener_registro_grado="
		SELECT 
		registrograduado.idregistrograduado,
		registrograduado.codigoestudiante,
		registrograduado.fecharegistrograduado,
		registrograduado.numeropromocion,
		registrograduado.numeroacuerdoregistrograduado,
		registrograduado.fechaacuerdoregistrograduado,
		registrograduado.responsableacuerdoregistrograduado,
		registrograduado.numeroactaregistrograduado,
		registrograduado.fechaactaregistrograduado,
		registrograduado.numerodiplomaregistrograduado,
		registrograduado.fechadiplomaregistrograduado,
		registrograduado.fechagradoregistrograduado,
		registrograduado.codigoestado,
		registrograduado.codigotiporegistrograduado,
		registrograduado.idtipogrado,
		tipogrado.nombretipogrado,
		tiporegistrograduado.nombretiporegistrograduado
		FROM
		registrograduado
		INNER JOIN tipogrado ON (registrograduado.idtipogrado = tipogrado.idtipogrado)
		INNER JOIN tiporegistrograduado ON (registrograduado.codigotiporegistrograduado = tiporegistrograduado.codigotiporegistrograduado)
		WHERE
		registrograduado.codigoestudiante='".$codigoestudiante."'
		";
		//echo $query_obtener_registro_grado;
		$obtener_registro_grado=$this->conexion->query($query_obtener_registro_grado);
		$row_registro_grado=$obtener_registro_grado->fetchRow();
		$this->row_registro_grado=$row_registro_grado;
		return $row_registro_grado;
	}
	function obtener_directivo_secgeneral()
	{
		$query_obtener_directivo_secgeneral="select concat(d.nombresdirectivo,' ',d.apellidosdirectivo) as nombre, d.cargodirectivo from directivo d where d.iddirectivo=8";
		$obtener_directivo_secgeneral=$this->conexion->query($query_obtener_directivo_secgeneral);
		$row_obtener_directivo_secgeneral=$obtener_directivo_secgeneral->fetchRow();
		return $row_obtener_directivo_secgeneral;
	}
}
?>
