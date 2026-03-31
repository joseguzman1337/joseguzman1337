<?php
class GenerarCartas
{
	var $array_validacion_cartas;
	var $codigoestudiante;
	var $conexion;
	var $array_datos_estudiante;
	var $array_documentos_pendientes;
	var $array_materias_actuales;
	var $array_materias_pendientes;
	var $valor_pago_derechos_grado;
	var $array_pazysalvos_pendientes;
	var $array_deudas_sap;
	var $array_firma_carrera;
	var $plandepagos;

	function GenerarCartas($array_validacion_cartas,$codigoestudiante,$conexion)
	{
		$this->array_validacion_cartas=$array_validacion_cartas;
		$this->codigoestudiante=$codigoestudiante;
		$this->conexion=$conexion;
		$this->array_datos_estudiante=$this->obtener_datos_estudiante_noprematricula($this->codigoestudiante);
		$this->array_firma_carrera=$this->LeerDirectivoFirmaCarrera($this->array_datos_estudiante['codigocarrera']);
		//$this->tabla($this->array_validacion_cartas);
	}

	function obtener_datos_estudiante_noprematricula($codigoestudiante)
	{
		$query="
		SELECT e.codigoestudiante,
		e.idestudiantegeneral,
		e.codigocarrera,
		c.nombrecarrera,
		eg.numerodocumento,
		t.nombretrato,
		concat(eg.apellidosestudiantegeneral,' ',eg.nombresestudiantegeneral) as nombre,
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
		estudiante e, estudiantegeneral eg, carrera c, estadocivil ec, ciudad ciu, jornada j, tipoestudiante te, situacioncarreraestudiante sce, genero g, trato t
		WHERE
		e.idestudiantegeneral=eg.idestudiantegeneral
		AND eg.codigogenero=g.codigogenero
		AND e.codigocarrera=c.codigocarrera
		AND eg.idestadocivil=ec.idestadocivil
		AND eg.idciudadnacimiento=ciu.idciudad
		AND e.codigojornada=j.codigojornada
		AND e.codigotipoestudiante=te.codigotipoestudiante
		AND e.codigosituacioncarreraestudiante=sce.codigosituacioncarreraestudiante
		AND eg.idtrato=t.idtrato
		AND e.codigoestudiante='$codigoestudiante'
		";
		$operacion=$this->conexion->query($query);
		$row_operacion=$operacion->fetchRow();
		return $row_operacion;
	}

	function LeerDirectivoFirmaCarrera($codigocarrera)
	{
		$query = "SELECT *
		FROM directivo d,directivocertificado di,certificado c
		WHERE d.codigocarrera = '".$codigocarrera."'
		AND d.iddirectivo = di.iddirectivo
		AND di.idcertificado = c.idcertificado
		AND di.fechainiciodirectivocertificado <='".date("Y-m-d")."'
		AND di.fechavencimientodirectivocertificado >= '".date("Y-m-d")."'
		AND c.idcertificado = '2'
	    ORDER BY fechainiciodirectivo";	

		$operacion=$this->conexion->query($query);
		$row_operacion=$operacion->fetchRow();
		return $row_operacion;
	}

	function LeerSituacionCarreraEstudiante($codigoestudiante)
	{
		$query="SELECT sce.nombresituacioncarreraestudiante
		FROM
		estudiante e, situacioncarreraestudiante sce
		WHERE
		e.codigoestudiante='$codigoestudiante'
		AND e.codigosituacioncarreraestudiante=sce.codigosituacioncarreraestudiante
		";
		$operacion=$this->conexion->query($query);
		$row_operacion=$operacion->fetchRow();
		//echo $query;
		return $row_operacion['nombresituacioncarreraestudiante'];
	}

	function carta()
	{
		echo $this->array_datos_estudiante['nombretrato'],"<br>";
		echo $this->array_datos_estudiante['nombre'],"<br>";
		echo date("Y-m-d"),"<br><br>";
		foreach ($this->array_validacion_cartas as $llave => $valor)
		{
			//saludos y carretas
			//$valor['valido']=false;
			if($valor['requerido']==false)
			{
				echo $valor['carreta'],'<br>';
			}
			elseif($valor['requerido']==true and $valor['valido']==false)
			{
				echo $valor['carreta'],'<br>';
				$this->bloque($valor['idtipodetallepazysalvoegresado']);
			}
		}
		//firmas
		echo "Cordialmente,<br><br><br>";
		echo $this->array_firma_carrera['nombresdirectivo']." ".$this->array_firma_carrera['apellidosdirectivo']."<br>";
		echo $this->array_firma_carrera['cargodirectivo'];
	}

	function carga_datos_bloques($array_documentos_pendientes,$array_materias_pendientes,$array_materias_actuales,$valor_pago_derechos_grado,$array_pazysalvos_pendientes,$array_deudas_sap,$plandepagos)
	{
		$this->array_deudas_sap=$array_deudas_sap;
		$this->array_documentos_pendientes=$array_documentos_pendientes;
		$this->array_materias_actuales=$array_materias_actuales;
		$this->array_materias_pendientes=$array_materias_pendientes;
		$this->valor_pago_derechos_grado=$valor_pago_derechos_grado;
		$this->array_pazysalvos_pendientes=$array_pazysalvos_pendientes;
		$this->plandepagos=$plandepagos;
	}

	function bloque($idtipodetallepazysalvoegresado)
	{
		if($idtipodetallepazysalvoegresado==1)
		{
			if(is_array($this->array_materias_pendientes))
			{
				foreach ($this->array_materias_pendientes as $llave => $valor)
				{
					echo $valor['nombremateria'],"<br>";
				}
				echo "<br>";
			}
		}
		if($idtipodetallepazysalvoegresado==2)
		{
			if(is_array($this->array_documentos_pendientes))
			{
				foreach ($this->array_documentos_pendientes as $llave => $valor)
				{
					echo $valor['documentacion'],"<br>";
				}
			}
			echo "<br>";
		}
		if($idtipodetallepazysalvoegresado==3)
		{
			if(is_array($this->array_pazysalvos_pendientes))
			{
				foreach ($this->array_pazysalvos_pendientes as $llave => $valor)
				{
					echo $valor['nombrecarrera']," debe : ".$valor['nombretipopazysalvoestudiante'],"<br>";
				}
			}
			echo "<br>";
		}

		if($idtipodetallepazysalvoegresado==4)
		{
			if(is_array($this->array_deudas_sap))
			{
				foreach ($this->array_deudas_sap as $llave => $valor)
				{
					echo $valor['nombreconcepto']," por valor de: ",$valor['valor'],"<br>";
				}

			}
			if($this->plandepagos<>"")
			{
				echo $this->plandepagos,"<br>";
			}

			echo "<br>";
		}

		if($idtipodetallepazysalvoegresado==5)
		{
			echo "$".$this->valor_pago_derechos_grado."<br><br>";

		}

		if($idtipodetallepazysalvoegresado==6)
		{
			echo $this->LeerSituacionCarreraEstudiante($this->codigoestudiante);
			echo "<br>";
			echo "<br>";
		}
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
}
?>