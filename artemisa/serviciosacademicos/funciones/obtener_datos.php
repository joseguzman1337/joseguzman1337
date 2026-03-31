<?php
class datos_registro_graduados
{
	var $conexion;
	var $array_obtener_carreras;
	var $fechahoy;
	var $array_periodo;
	var $depurar;

	function datos_registro_graduados($conexion,$depurar=false)
	{
		if(!isset($_SESSION['codigomodalidadacademica']))
		{
			$_SESSION['codigomodalidadacademica']=$_GET['codigomodalidadacademica'];
		}
		if(!isset($_SESSION['codigocarrera']))
		{
			$_SESSION['codigocarrera']=$_GET['codigocarrera'];
		}
		if (!isset($_SESSION['codigoperiodo']))
		{
			$_SESSION['codigoperiodo']=$_GET['codigoperiodo'];
		}
		$this->conexion=$conexion;
		//		$this->conexion->debug=true;
		$this->fechahoy=date("Y-m-d H:i:s");
		$this->obtener_periodo($_SESSION['codigoperiodo']);
		$this->depurar=$depurar;
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
		if($this->depurar==si)
		{
			$this->tabla($array_obtener_carreras,"array_carreras_seleccionadas");
		}
		return $array_obtener_carreras;
	}

	function obtener_egresados_archivos_antiguos()
	{
		$contador=0;
		foreach ($this->array_obtener_carreras as $llave => $valor)
		{
			$query="SELECT rga.codigocarrera,
			rga.nombreregistrograduadoantiguo,
			rga.documentoegresadoregistrograduadoantiguo,
			c.nombrecarrera,
			rga.areaconocimientoregistrograduadoantiguo,
			rga.modalidadregistrograduadoantiguo,
			rga.tituloregistrograduadoantiguo,
			rga.numerodiplomaregistrograduadoantiguo,
			rga.numeroactaregistrograduadoantiguo,
			rga.fechaactaregistrograduadoantiguo,
			rga.numerolibroregistrograduadoantiguo,
			rga.numerofolioregistrograduadoantiguo,
			rga.fechagradoregistrograduadoantiguo
			FROM registrograduadoantiguo rga, carrera c
			WHERE rga.codigocarrera='".$valor['codigocarrera']."'
			AND rga.codigocarrera=c.codigocarrera
			";
			$operacion=$this->conexion->query($query);
			$row_operacion=$operacion->fetchRow();
			do
			{
				if(!empty($row_operacion))
				{
					$array_eg=$this->leer_datos_estudiante_documento($row_operacion['documentoegresadoregistrograduadoantiguo']);
					if(!empty($array_eg['idestudiantegeneral']))
					{
						$codigoestudiante=$this->lee_codigo_estudiante($array_eg['idestudiantegeneral'],$row_operacion['codigocarrera']);
					}
					else
					{
						$codigoestudiante=null;
					}
					$array_interno[$contador]['codigocarrera']=$row_operacion['codigocarrera'];
					$array_interno[$contador]['nombreregistrograduadoantiguo']=$row_operacion['nombreregistrograduadoantiguo'];
					$array_interno[$contador]['documentoegresadoregistrograduadoantiguo']=$row_operacion['documentoegresadoregistrograduadoantiguo'];
					//si tiene codigoestudiante, aparecerá en drilldown
					$array_interno[$contador]['codigoestudiante']=$codigoestudiante;
					$array_interno[$contador]['programaregistrograduadoantiguo']=$row_operacion['programaregistrograduadoantiguo'];
					$array_interno[$contador]['areaconocimientoregistrograduadoantiguo']=$row_operacion['areaconocimientoregistrograduadoantiguo'];
					$array_interno[$contador]['modalidadregistrograduadoantiguo']=$row_operacion['modalidadregistrograduadoantiguo'];
					$array_interno[$contador]['tituloregistrograduadoantiguo']=$row_operacion['tituloregistrograduadoantiguo'];
					$array_interno[$contador]['numerodiplomaregistrograduadoantiguo']=$row_operacion['numerodiplomaregistrograduadoantiguo'];
					$array_interno[$contador]['numeroactaregistrograduadoantiguo']=$row_operacion['numeroactaregistrograduadoantiguo'];
					$array_interno[$contador]['fechaactaregistrograduadoantiguo']=$row_operacion['fechaactaregistrograduadoantiguo'];
					$array_interno[$contador]['numerolibroregistrograduadoantiguo']=$row_operacion['numerolibroregistrograduadoantiguo'];
					$array_interno[$contador]['numerofolioregistrograduadoantiguo']=$row_operacion['numerofolioregistrograduadoantiguo'];
					$array_interno[$contador]['fechagradoregistrograduadoantiguo']=$row_operacion['fechagradoregistrograduadoantiguo'];
					//busca si hay algo en SALA
					$array_interno[$contador]['nombretrato']=$array_eg['nombretrato'];
					$array_interno[$contador]['nombregenero']=$array_eg['nombregenero'];
					$array_interno[$contador]['nombreestadocivil']=$array_eg['nombreestadocivil'];
					$array_interno[$contador]['direccionresidenciaestudiantegeneral']=$array_eg['direccionresidenciaestudiantegeneral'];
					$array_interno[$contador]['ciudadresidencia']=$array_eg['ciudadresidencia'];
					$array_interno[$contador]['telefonoresidenciaestudiantegeneral']=$array_eg['telefonoresidenciaestudiantegeneral'];
					$array_interno[$contador]['telefono2estudiantegeneral']=$array_eg['telefono2estudiantegeneral'];
					$array_interno[$contador]['emailestudiantegeneral']=$array_eg['emailestudiantegeneral'];
					$array_interno[$contador]['email2estudiantegeneral']=$array_eg['email2estudiantegeneral'];
					$array_interno[$contador]['fechanacimientoestudiantegeneral']=$array_eg['fechanacimientoestudiantegeneral'];
					$array_interno[$contador]['direccioncorrespondenciaestudiantegeneral']=$array_eg['direccioncorrespondenciaestudiantegeneral'];
					$array_interno[$contador]['ciudadcorrespondenciaestudiantegeneral']=$array_eg['ciudadcorrespondenciaestudiantegeneral'];
					$array_interno[$contador]['telefonocorrespondenciaestudiantegeneral']=$array_eg['telefonocorrespondenciaestudiantegeneral'];
					$array_interno[$contador]['celularestudiantegeneral']=$array_eg['celularestudiantegeneral'];

					/*
					$array_interno[$contador]['']=$row_operacion[''];
					$array_interno[$contador]['']=$row_operacion[''];
					$array_interno[$contador]['']=$row_operacion[''];
					$array_interno[$contador]['']=$row_operacion[''];
					$array_interno[$contador]['']=$row_operacion[''];
					$array_interno[$contador]['']=$row_operacion[''];
					$array_interno[$contador]['']=$row_operacion[''];
					$array_interno[$contador]['']=$row_operacion[''];
					$array_interno[$contador]['']=$row_operacion[''];
					$array_interno[$contador]['']=$row_operacion[''];
					$array_interno[$contador]['']=$row_operacion[''];
					$array_interno[$contador]['']=$row_operacion[''];
					$array_interno[$contador]['']=$row_operacion[''];
					$array_interno[$contador]['']=$row_operacion[''];
					$array_interno[$contador]['']=$row_operacion[''];
					$array_interno[$contador]['']=$row_operacion[''];
					$array_interno[$contador]['']=$row_operacion[''];
					$array_interno[$contador]['']=$row_operacion[''];
					$array_interno[$contador]['']=$row_operacion[''];
					$array_interno[$contador]['']=$row_operacion[''];
					$array_interno[$contador]['']=$row_operacion[''];
					//$array_interno[$contador]['']=$row_operacion[''];*/
					$contador++;
				}
			}
			while($row_operacion=$operacion->fetchRow());
		}

		if($this->depurar==true)
		{
			$this->tabla($array_interno);
		}
		return $array_interno;
	}

	function leer_datos_estudiante_documento($numerodocumento)
	{
		$query="SELECT eg.*, g.nombregenero, ec.nombreestadocivil, t.nombretrato, ciu.nombreciudad as ciudadresidencia
		FROM 
		estudiantegeneral eg, 
		genero g,
		trato t,
		estadocivil ec,
		ciudad ciu
		WHERE eg.numerodocumento='$numerodocumento'
		AND eg.codigogenero=g.codigogenero
		AND ec.idestadocivil=eg.idestadocivil
		AND eg.idtrato=t.idtrato
		AND eg.ciudadresidenciaestudiantegeneral=ciu.idciudad
		";
		$operacion=$this->conexion->query($query);
		$row_operacion=$operacion->fetchRow();
		if(!empty($row_operacion))
		{
			return $row_operacion;
		}
	}

	function lee_codigo_estudiante($idestudiantegeneral,$codigocarrera)
	{
		$query="SELECT e.codigoestudiante FROM estudiante e, estudiantegeneral eg
		WHERE e.idestudiantegeneral=eg.idestudiantegeneral
		AND e.codigocarrera='$codigocarrera'
		AND e.idestudiantegeneral='$idestudiantegeneral'
		";
		$operacion=$this->conexion->query($query);
		$row_operacion=$operacion->fetchRow();
		if(!empty($row_operacion['codigoestudiante']))
		{
			return $row_operacion['codigoestudiante'];
		}
	}

	function obtener_codigos_estudiante_egresados()
	{
		foreach ($this->array_obtener_carreras as $llave => $valor)
		{
			$query_egresados="SELECT
			rg.idregistrograduado as no_registro,
			e.codigoestudiante,
			c.nombrecarrera as carrera,
			eg.numerodocumento,
			concat(eg.apellidosestudiantegeneral,' ',eg.nombresestudiantegeneral) as nombre,
			arg.nombreautorizacionregistrograduado as autorizado_sino,
			rg.fechaautorizacionregistrograduado,
			rg.fecharegistrograduado as fecha_registro,
			rg.numeropromocion,
			rg.numeroacuerdoregistrograduado as numero_acuerdo,
			rg.numeroacuerdoregistrograduado as fecha_acuerdo,
			rg.numeroacuerdoregistrograduado as responsable_acuerdo,
			rg.numeroactaregistrograduado as numero_acta,
			rg.fechaactaregistrograduado as fecha_acta,
			rg.numerodiplomaregistrograduado as numero_diploma,
			rg.fechadiplomaregistrograduado as fecha_diploma,
			rg.fechagradoregistrograduado as fecha_grado,
			rg.lugarregistrograduado as lugar_grado,
			rg.presidioregistrograduado as director_ceremonia,
			rg.observacionregistrograduado as observacion,
			est.nombreestado as estado,
			trg.nombretiporegistrograduado as tipo_registro,
			rg.direccionipregistrograduado as ip_registro,
			rg.usuario as usuario_registro,
			eg.emailestudiantegeneral as email,
			eg.email2estudiantegeneral as email2,
			eg.direccionresidenciaestudiantegeneral as direccion,
			eg.telefonoresidenciaestudiantegeneral as telefono
					
			FROM registrograduado rg, estudiante e, autorizacionregistrograduado arg, estado est, tiporegistrograduado trg, carrera c, estudiantegeneral eg
			WHERE 
			e.codigoestudiante=rg.codigoestudiante
			AND eg.idestudiantegeneral=e.idestudiantegeneral
	
			AND e.codigocarrera=c.codigocarrera
			AND rg.codigoestado=est.codigoestado
			AND rg.codigotiporegistrograduado=trg.codigotiporegistrograduado
			AND e.codigocarrera='".$valor['codigocarrera']."' 
			AND rg.codigoautorizacionregistrograduado=arg.codigoautorizacionregistrograduado
			";
			//echo $query_egresados,"<br>";
			$operacion=$this->conexion->query($query_egresados);
			$row_operacion=$operacion->fetchRow();
			do
			{
				if($row_operacion['no_registro']<>"")
				{
					$array_interno[]=$row_operacion;
				}
			}
			while($row_operacion=$operacion->fetchRow());
		}
		if($this->depurar==true)
		{
			$this->tabla($array_interno);
		}
		return $array_interno;
	}

	function muestra_incentivos($idregistrograduado)
	{
		$query="SELECT ri.idregistroincentivoacademico,i.nombreincentivoacademico FROM registroincentivoacademico ri, incentivoacademico i
		WHERE ri.idincentivoacademico=i.idincentivoacademico
		AND ri.idregistrograduado='$idregistrograduado'
		AND ri.codigoestado='100'
		";
		//echo $query,"<br>";
		$operacion=$this->conexion->query($query);
		$row_operacion=$operacion->fetchRow();
		do
		{
			if($row_operacion['idregistroincentivoacademico']<>"")
			{
				$array_interno[]=$row_operacion;
			}
		}
		while($row_operacion=$operacion->fetchRow());
		return $array_interno;
	}
	function muestra_firmas_incentivos_idregistroincentivoacademico($idregistroincentivoacademico)
	{
		$query="SELECT distinct iddocumentograduado,idregistrograduado,dg.codigotipodocumentograduado,d.iddirectivo,concat(d.nombresdirectivo,' ',d.apellidosdirectivo) AS nombre FROM documentograduado dg, directivo d WHERE
		d.iddirectivo=dg.iddirectivo 
		AND idregistroincentivoacademico='$idregistroincentivoacademico'
		AND codigotipodocumentograduado='3' 
		AND codigoestado='100'
		group by d.iddirectivo
		";
		//echo $query,"<br>";
		$operacion=$this->conexion->query($query);
		$row_operacion=$operacion->fetchRow();
		do
		{
			if($row_operacion['iddocumentograduado']<>"")
			{
				$array_interno[]=$row_operacion;
			}
		}
		while($row_operacion=$operacion->fetchRow());
		return $array_interno;
	}

	function muestra_firma_documento($idregistrograduado,$codigotipodocumentograduado)
	{
		$query="SELECT iddocumentograduado,idregistrograduado,dg.codigotipodocumentograduado,d.iddirectivo,concat(d.nombresdirectivo,' 					',d.apellidosdirectivo) AS nombre FROM documentograduado dg, directivo d WHERE
		d.iddirectivo=dg.iddirectivo AND
		idregistrograduado = '$idregistrograduado' AND
		codigotipodocumentograduado='$codigotipodocumentograduado' AND codigoestado='100'
		group by d.iddirectivo
		";	
		$operacion=$this->conexion->query($query);
		$row_operacion=$operacion->fetchRow();
		do
		{
			if($row_operacion['iddocumentograduado']<>"")
			{
				$array_interno[]=$row_operacion;
			}
		}
		while($row_operacion=$operacion->fetchRow());
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
