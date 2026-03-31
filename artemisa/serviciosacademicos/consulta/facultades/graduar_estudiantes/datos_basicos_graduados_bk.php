<?php
//error_reporting(0);
require_once("../../../../funciones/conexion/conexionpear.php");
class estudiante_graduado
{
	function estudiante_graduado($conexion)
	{
		$this->conexion=$conexion;
	}
	function obtener_listado_estudiantes_graduados($fecha,$codigocarrera)
	{
		$this->codigocarrera=$codigocarrera;
		$query_obtener_listado_estudiantes_graduados="SELECT
		e.codigoestudiante,
		rg.idregistrograduado,
		concat(eg.apellidosestudiantegeneral,' ', eg.nombresestudiantegeneral) AS 'Nombre',
		eg.numerodocumento AS 'Documento',
		eg.expedidodocumento as 'expedicion',
		c.nombrecarrera AS 'Programa',
		t.nombretitulo AS 'Titulo', 
		rg.numeropromocion as 'Promocion',
		rg.numeroactaregistrograduado AS 'Acta', rg.numerodiplomaregistrograduado AS 'diploma',
		fechaactaregistrograduado as 'Fecha Grado',
		rg.numeroacuerdoregistrograduado as 'Acuerdo'
		FROM registrograduado rg, estudiantegeneral eg, estudiante e, carrera c, titulo t
		WHERE 
		rg.codigoestado = '100' AND
		rg.codigoautorizacionregistrograduado='100' AND
		rg.fechagradoregistrograduado='".$fecha."'
		AND rg.codigoestudiante=e.codigoestudiante 
		AND e.idestudiantegeneral=eg.idestudiantegeneral 
		AND e.codigocarrera='".$codigocarrera."'
		AND e.codigocarrera=c.codigocarrera
		AND c.codigotitulo=t.codigotitulo
		ORDER BY c.nombrecarrera,rg.idregistrograduado
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
	function obtener_incentivos_academicos_estudiante()
	{
		foreach ($this->array_obtener_listado_estudiantes_graduados as $clave => $valor)
		{
			$query_obtener_incentivos_academicos_estudiante="SELECT
			rg.codigoestudiante,ia.nombreincentivoacademico,
			concat(eg.apellidosestudiantegeneral,' ', eg.nombresestudiantegeneral) AS Nombre
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
			$obtener_incentivos_academicos_estudiante=$this->conexion->query($query_obtener_incentivos_academicos_estudiante);
			$row_obtener_incentivos_academicos_estudiante=$obtener_incentivos_academicos_estudiante->fetchRow();
			//print_r($row_obtener_incentivos_academicos_estudiante);
			if($row_obtener_incentivos_academicos_estudiante['codigoestudiante']!='')
			{
				$array_obtener_incentivos_academicos_estudiante[]=$row_obtener_incentivos_academicos_estudiante;
			}
		}
		$this->array_obtener_incentivos_academicos_estudiante=$array_obtener_incentivos_academicos_estudiante;
		return $array_obtener_incentivos_academicos_estudiante;
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
	function obtener_datos_carreras_grados()
	{

		$query_obtener_datos_carreras_grados="SELECT
		c.nombrecarrera,t.nombretitulo
		FROM
		estudiante e,carrera c, titulo t
		WHERE
		c.codigocarrera='".$this->codigocarrera."'		
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
		$this->codigoestudiante=$codigoestudiante;
		$this->numerocorte=$numerocorte;
		$this->codigoperiodo=$codigoperiodo;
		$this->codigoestudiante=$codigoestudiante;
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
	function obtener_registro_grado_estudiante()
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
		registrograduado.codigoestudiante='".$this->codigoestudiante."'
		";
		//echo $query_obtener_registro_grado;
		$obtener_registro_grado=$this->conexion->query($query_obtener_registro_grado);
		$row_registro_grado=$obtener_registro_grado->fetchRow();
		$this->row_registro_grado=$row_registro_grado;
		return $row_registro_grado;
	}
}
?>
