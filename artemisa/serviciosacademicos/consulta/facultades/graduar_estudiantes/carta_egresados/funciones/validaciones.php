<?php
class validaciones_requeridas
{
	var $array_validaciones;
	var $materiasporver;
	var $codigoestudiante;
	var $conexion;
	var $array_datos_estudiante;
	var $codigocarrera;
	var $codigogenero;

	function validaciones_requeridas($conexion,$codigoestudiante)
	{
		$this->conexion=$conexion;
		$sap=$this->conecta_sap();
		$this->codigoestudiante=$codigoestudiante;
		$this->selecciona_datos_estudiante();
		$this->carga_datos_a_validar();
	}

	function selecciona_datos_estudiante()
	{
		$query="SELECT e.codigocarrera,eg.codigogenero FROM
		estudiante e, estudiantegeneral eg
		WHERE
		e.idestudiantegeneral=eg.idestudiantegeneral
		AND e.codigoestudiante='$this->codigoestudiante'
		";	
		//echo $query,"<br>";
		$operacion=$this->conexion->query($query);
		$row_operacion=$operacion->fetchRow();
		$this->codigocarrera=$row_operacion['codigocarrera'];
		$this->codigogenero=$row_operacion['codigogenero'];

	}

	function carga_datos_a_validar()
	{
		$query="SELECT dpe.idtipodetallepazysalvoegresado, tdpe.nombretipodetallepazysalvoegresado as validacion,dpe.ubicacionpaginadetallepazysalvoegresado as orden_ubicacion_carta,dpe.textodetallepazysalvoegresado as texto
		FROM
		pazysalvoegresado pe, detallepazysalvoegresado dpe, tipodetallepazysalvoegresado tdpe
		WHERE
		pe.idpazysalvoegresado=dpe.idpazysalvoegresado
		AND pe.codigocarrera='$this->codigocarrera'
		AND dpe.idtipodetallepazysalvoegresado=tdpe.idtipodetallepazysalvoegresado
		ORDER BY dpe.ubicacionpaginadetallepazysalvoegresado
		";
		//echo $query,"<br>";
		$operacion=$this->conexion->query($query);
		$row_operacion=$operacion->fetchRow();
		do
		{
			$array_interno[]=array('idtipodetallepazysalvoegresado'=>$row_operacion['idtipodetallepazysalvoegresado'],'validacion'=>$row_operacion['validacion'],'orden_ubicacion_carta'=>$row_operacion['orden_ubicacion_carta'],'carreta'=>$row_operacion['texto'],'valido'=>$this->validar($row_operacion['idtipodetallepazysalvoegresado']));
		}
		while ($row_operacion=$operacion->fetchRow());
		$this->array_validaciones=$array_interno;
		$this->tabla($array_interno);
		return $array_interno;
	}

	function valida_egreso()
	{
		$query="select codigoestudiante from estudiante e
		where e.codigosituacioncarreraestudiante='104'
		and codigoestudiante='$this->codigoestudiante'";
		$operacion=$this->conexion->query($query);
		$row_operacion=$operacion->fetchRow();
		//echo $query,"<br>";
		if($row_operacion['codigoestudiante']!="")
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	function validacion_pazysalvo($codigoestudiante)
	{
		$query_pazysalvo = "select p.idpazysalvoestudiante, e.codigocarrera
		from pazysalvoestudiante p, detallepazysalvoestudiante d, estudiante e
		where e.codigoestudiante = '$codigoestudiante'
		and p.idpazysalvoestudiante = d.idpazysalvoestudiante
		and d.codigoestadopazysalvoestudiante like '1%'
		and e.idestudiantegeneral = p.idestudiantegeneral";
		//echo $query_pazysalvo,"<br>";
		$pazysalvo = $this->conexion->query($query_pazysalvo);
		$totalRows_pazysalvo = $pazysalvo->numRows();
		$row_pazysalvo = $pazysalvo->fetchRow();
		//echo $query_pazysalvo,"<br>";
		if($totalRows_pazysalvo==0)
		{
			return false;
		}//echo $query_pazysalvo;
		else
		{
			return true;
		}
	}

	function validacion_documentos($codigocarrera,$codigogenero,$codigoestudiante,$sala,&$documentacionpendiente)
	{
		$query_documentos = "SELECT d.nombredocumentacion, d.iddocumentacion
	from documentacion d,documentacionfacultad df
	where d.iddocumentacion = df.iddocumentacion
	and df.codigocarrera = '$codigocarrera'
	and df.fechainiciodocumentacionfacultad <= '".date("Y-m-d")."'
	and df.fechavencimientodocumentacionfacultad >= '".date("Y-m-d")."'
	AND (df.codigogenerodocumento = '300' 
	OR df.codigogenerodocumento = '$codigogenero')";
		//echo $query_documentos,"<br>";
		//exit();
		$documentos = $this->conexion->query($query_documentos);
		$totalRows_documentos = $documentos->numRows();
		$row_documentos = $documentos->fetchRow();
		//echo $query_documentos;
		do
		{
			// Selecciona los documentos para la facultad que posee un estudiante
			$query_documentosestudiante = "SELECT d.codigotipodocumentovencimiento
		FROM documentacionestudiante d,documentacionfacultad df,tipovencimientodocumento t
	    where d.codigoestudiante = '$codigoestudiante'
		and d.iddocumentacion = '".$row_documentos['iddocumentacion']."'
		AND d.codigotipodocumentovencimiento = '100' 
		and d.iddocumentacion = df.iddocumentacion
		AND d.codigotipodocumentovencimiento = t.codigotipovencimientodocumento";
			$documentosestudiante = $this->conexion->query($query_documentosestudiante);
			$totalRows_documentosestudiante = $documentosestudiante->numRows();
			$row_documentosestudiante = $documentosestudiante->fetchRow();
			//echo $query_documentosestudiante;echo "<br>";
			//echo  $totalRows_documentosestudiante,"<br>";
			if($totalRows_documentosestudiante==0)
			{
				$documentacionpendiente[] = array('codigoestudiante'=>$codigoestudiante,'documentacion'=>$row_documentos['nombredocumentacion']);
			}
			/*if($totalRows_documentosestudiante == 0)
			{
			return true;
			}
			else if($row_documentosestudiante['codigotipodocumentovencimiento'] == '100')
			{
			return false;
			continue;
			}
			else
			{
			return true;
			}*/
			//echo $row_documentos['nombredocumentacion'];
			//echo "<br>";
			//echo $pendiente;
		}
		while ($row_documentos = $documentos->fetchRow());
		if(is_array($documentacionpendiente))
		{
			return false;
		}
		else
		{
			return true;
		}
	}
	// Esta funcion recibe el estudiante, la materia que se quiere verificar, el plan de estudios donde se encuentra la materia y la base de datos.
	function materiaaprobada($codigoestudiante, $codigomateria, $idplanestudio, $reprobada, $sala)
	{
		$query_materianota = "SELECT n.codigomateria, n.notadefinitiva, m.notaminimaaprobatoria, n.codigoperiodo
	FROM notahistorico n, materia m
	WHERE n.codigoestudiante = '$codigoestudiante'
	AND m.codigomateria = n.codigomateria
	AND (n.codigomateria = '$codigomateria' OR n.codigomateriaelectiva = '$codigomateria')
	and n.codigoestadonotahistorico like '1%'
	ORDER BY 4 ";
		//echo "$query_materianota<br>";
		$materianota=mysql_query($query_materianota, $sala) or die("$query_materianota");
		$totalRows_materianota = mysql_num_rows($materianota);
		// Entra si la materia tienen nota historica para este estudiante
		// Sino busca la materia equivalente
		if($totalRows_materianota != "")
		{
			while($row_materianota = mysql_fetch_array($materianota))
			{
				// Si la nota es aprobada retorna verdadero
				if($row_materianota['notadefinitiva'] >= $row_materianota['notaminimaaprobatoria'])
				{
					$reprobada = false;
					return "aprobada";
				}
				else
				{
					$reprobada = true;
				}
			}
		}
		$query_materiaequivalente = "select r.idplanestudio, r.codigomateriareferenciaplanestudio
	from referenciaplanestudio r
	where r.idplanestudio = '$idplanestudio'
	and r.codigomateria = '$codigomateria'
	and r.codigotiporeferenciaplanestudio like '3%'";
		//echo "$query_materiaequivalente<br>";
		$materiaequivalente=mysql_query($query_materiaequivalente, $sala) or die("$query_materiaequivalente");
		$totalRows_materiaequivalente = mysql_num_rows($materiaequivalente);
		// Si tiene materia equivalente entra a hacer lo mismo, es decir a mirar si la equivalente esta aprobada
		// Para el sigiente plan de estudios de la carrera donde aparezca esta materia
		// Sino retorna falso
		if($totalRows_materiaequivalente != "")
		{
			while($row_materiaequivalente = mysql_fetch_array($materiaequivalente))
			{
				$codigoequivalente = $row_materiaequivalente['codigomateriareferenciaplanestudio'];
				$query_materianota = "SELECT n.codigomateria, n.notadefinitiva, m.notaminimaaprobatoria, n.codigoperiodo
			FROM notahistorico n, materia m
			WHERE n.codigoestudiante = '$codigoestudiante'
			AND m.codigomateria = n.codigomateria
			AND (n.codigomateria = '$codigoequivalente' OR n.codigomateriaelectiva = '$codigoequivalente')
			and n.codigoestadonotahistorico like '1%'
			ORDER BY 4 ";
				//echo "$query_materianota<br>";
				$materianota=mysql_query($query_materianota, $sala) or die("$query_materianota");
				$totalRows_materianota = mysql_num_rows($materianota);
				// Entra si la materia tienen nota historica para este estudiante
				// Sino busca la materia equivalente
				if($totalRows_materianota != "")
				{
					while($row_materianota = mysql_fetch_array($materianota))
					{
						// Si la nota es aprobada retorna verdadero
						if($row_materianota['notadefinitiva'] >= $row_materianota['notaminimaaprobatoria'])
						{
							$reprobada = false;
							return "aprobada";
						}
						else
						{
							$reprobada = true;
						}
					}
				}
			}
		}
		else
		{
			//$reprobada = false;
			return "porver";
		}
		if($reprobada)
		{
			return "reprobada";
		}
		else
		{
			//$reprobada = false;
			return "porver";
		}
	}
	function generarcargaestudiante($codigoestudiante,$sala,&$materiaspendientes)
	{
		// Proceso para generar la carga académica
		// Toma todas las materias del plan de estudios
		$query_materiasplanestudio = "select d.idplanestudio, d.codigomateria, m.nombremateria, m.codigoindicadorgrupomateria,
	d.semestredetalleplanestudio*1 as semestredetalleplanestudio, 
	t.nombretipomateria, t.codigotipomateria, d.numerocreditosdetalleplanestudio
	from planestudioestudiante p, detalleplanestudio d, materia m, tipomateria t
	where p.codigoestudiante = '$codigoestudiante'
	and p.idplanestudio = d.idplanestudio
	and p.codigoestadoplanestudioestudiante like '1%'
	and d.codigoestadodetalleplanestudio like '1%'
	and d.codigomateria = m.codigomateria
	and d.codigotipomateria = t.codigotipomateria
	order by 4,3";
		//and d.codigotipomateria not like '5%'
		//and d.codigotipomateria not like '4%'";
		//echo "$query_materiasplanestudio<br>";
		$materiasplanestudio=mysql_query($query_materiasplanestudio, $sala) or die("$query_materiasplanestudio");
		$totalRows_materiasplanestudio = mysql_num_rows($materiasplanestudio);
		$rowmateriasplanestudio=mysql_fetch_assoc($materiasplanestudio);
		//print_r($rowmateriasplanestudio);
		//echo "Total: $totalRows_materiasplanestudio<br>";
		$quitarmateriasdelplandestudios = "";
		if($totalRows_materiasplanestudio != "")
		{
			// Este arreglo sirve para guardar el semestre que mas se repite
			// Tomo el maximo numero de semestres del plan de estudio
			$query_semestreplanes = "select max(cantidadsemestresplanestudio*1) as semestre
	from planestudio";
			$semestreplanes=mysql_query($query_semestreplanes, $sala) or die("$query_semestreplanes");
			$totalRows_semestreplanes = mysql_num_rows($semestreplanes);
			$row_semestreplanes = mysql_fetch_array($semestreplanes);
			for($semestreini = 1; $semestreini <= $row_semestreplanes['semestre']; $semestreini++)
			{
				$semestre[$semestreini] = 0;
			}
			$numerocreditoselectivas = 0;
			$tieneelectivas = false;
			$tieneenfasis = false;
			$estudiantetieneenfasis = false;
			// String que va a guardar las materias del plan de estudios para quitarselas a las electivas libres, en caso de existir una obligatoria
			$quitarmateriasdelplandestudios = "";
			while($row_materiasplanestudio = mysql_fetch_array($materiasplanestudio))
			{
				$idplan = $row_materiasplanestudio['idplanestudio'];
				//echo $row_materiasplanestudio['codigomateria']."<br>";
				$quitarmateriasdelplandestudios = "$quitarmateriasdelplandestudios and m.codigomateria <> '".$row_materiasplanestudio['codigomateria']."'";
				if($row_materiasplanestudio['codigotipomateria'] == '4')
				{
					$numerocreditoselectivas = $numerocreditoselectivas + $row_materiasplanestudio['numerocreditosdetalleplanestudio'];
					$electivaslibresplan[] = $row_materiasplanestudio;
					$tieneelectivas = true;
				}
				else
				{
					// Mira si cada materia n ha sido aprobada para meterla en la carga
					// Por el momento toma totas las materias
					//$reprobada=true;
					if($row_materiasplanestudio['codigotipomateria'] != '5')
					{
						//echo "materiaaprobada($codigoestudiante, ".$row_materiasplanestudio['codigomateria'].", ".$row_materiasplanestudio['idplanestudio'].", $reprobada, $sala<br>";
						@$estadomateria = materiaaprobada($codigoestudiante, $row_materiasplanestudio['codigomateria'], $row_materiasplanestudio['idplanestudio'], $reprobada, $sala);
						if($estadomateria == "porver")
						{
							$materiasporver[] = $row_materiasplanestudio;
							//echo "entro <br>";
						}
						else if($estadomateria == "reprobada")
						{
							//echo "REPRO: $reprobada : ".$row_materiasplanestudio['codigomateria']."<br>";
							// Estas materias son obligatorias
							$materiasobligatorias[] = $row_materiasplanestudio;
							// Selección de la carga obligatoria
							$cargaobligatoria[] = $row_materiasplanestudio['codigomateria'];
							$materiasporver[] = $row_materiasplanestudio;
							$semestre[$row_materiasplanestudio['semestredetalleplanestudio']]++;
						}
						else if($estadomateria == "aprobada")
						{
							//echo "bien<br>";
							$materiaspasadas[] = $row_materiasplanestudio;
						}
						else
						{
							echo "error";
						}
					}
					else if($row_materiasplanestudio['codigotipomateria'] == '5')
					{
						// Aqui es para las lineas de enfasis
						$tieneenfasis = true;
						// Primero miro si el estudiante ya tiene linea de enfasis.
						$query_poseelineaenfasis = "select le.idlineaenfasisplanestudio
				from lineaenfasisestudiante le
				where le.codigoestudiante = '$codigoestudiante'";
						//and d.codigotipomateria not like '5%'
						//and d.codigotipomateria not like '4%'";
						//echo "$query_materiasplanestudio<br>";
						$poseelineaenfasis=mysql_query($query_poseelineaenfasis, $sala) or die("$query_poseelineaenfasis");
						$totalRows_poseelineaenfasis = mysql_num_rows($poseelineaenfasis);
						if($totalRows_poseelineaenfasis != "")
						{
							// Selecciona las materias de la línea y efectua el proceso de carga para esas materias
							$estudiantetieneenfasis = true;
						}
					}
				}
				$idplanestudioini = $row_materiasplanestudio['idplanestudio'];
			}
			if($estudiantetieneenfasis)
			{
				// Selecciona las materias de la linea de enfasis de este estudiante las cuales deben estar activas
				$query_materiaslineaenfasis = "select d.idplanestudio, d.idlineaenfasisplanestudio,
			d.codigomateriadetallelineaenfasisplanestudio as codigomateria, m.nombremateria, 
			d.semestredetallelineaenfasisplanestudio*1 as semestredetalleplanestudio, t.nombretipomateria, 
			t.codigotipomateria, d.numerocreditosdetallelineaenfasisplanestudio as numerocreditosdetalleplanestudio
			from detallelineaenfasisplanestudio d, materia m, tipomateria t, lineaenfasisestudiante l
			where d.codigomateriadetallelineaenfasisplanestudio = m.codigomateria
			and d.codigotipomateria = t.codigotipomateria
			and l.idplanestudio = d.idplanestudio
			and l.codigoestudiante = '$codigoestudiante'
			and l.idlineaenfasisplanestudio = d.idlineaenfasisplanestudio
			and d.codigoestadodetallelineaenfasisplanestudio like '1%'
			group by 3
			order by 2,5";
				//and d.codigotipomateria not like '5%'
				//and d.codigotipomateria not like '4%'";
				//echo "$query_materiaslineaenfasis<br>";
				$materiaslineaenfasis=mysql_query($query_materiaslineaenfasis, $sala) or die("$query_materiaslineaenfasis");
				$totalRows_materiaslineaenfasis = mysql_num_rows($materiaslineaenfasis);
			}
			else if($tieneenfasis)
			{
				// Selecciona todas las materias del plan de estudio que son enfais
				// Es decir toma todos los enfasis
				$query_materiaslineaenfasis = "select d.idplanestudio, d.idlineaenfasisplanestudio,
			d.codigomateriadetallelineaenfasisplanestudio as codigomateria, m.nombremateria, 
			d.semestredetallelineaenfasisplanestudio*1 as semestredetalleplanestudio, t.nombretipomateria, 
			t.codigotipomateria, d.numerocreditosdetallelineaenfasisplanestudio as numerocreditosdetalleplanestudio
			from detallelineaenfasisplanestudio d, materia m, lineaenfasisplanestudio l, tipomateria t
			where d.idplanestudio = '$idplan'
			and d.codigomateriadetallelineaenfasisplanestudio = m.codigomateria
			and d.codigotipomateria = t.codigotipomateria
			and l.idplanestudio = d.idplanestudio
			group by 3
			order by 2,5";
				//and d.codigotipomateria not like '5%'
				//and d.codigotipomateria not like '4%'";
				//echo "$query_materiaslineaenfasis<br>";
				$materiaslineaenfasis=mysql_query($query_materiaslineaenfasis, $sala) or die("$query_materiaslineaenfasis");
				$totalRows_materiaslineaenfasis = mysql_num_rows($materiaslineaenfasis);
			}
			if(@$totalRows_materiaslineaenfasis != "")
			{
				while($row_materiaslineaenfasis = mysql_fetch_array($materiaslineaenfasis))
				{
					$quitarmateriasdelplandestudios = "$quitarmateriasdelplandestudios and m.codigomateria <> '".$row_materiaslineaenfasis['codigomateria']."'";
					@$estadomateria = materiaaprobada($codigoestudiante, $row_materiaslineaenfasis['codigomateria'], $idplan, $reprobada, $sala);
					if($estadomateria == "porver")
					{
						$materiasporver[] = $row_materiaslineaenfasis;
						//echo "entro <br>";
					}
					else if($estadomateria == "reprobada")
					{
						// No la puse por que no hay linea de enfasis
						//echo "REPRO: $reprobada : ".$row_materiasplanestudio['codigomateria']."<br>";
						// Estas materias son obligatorias
						$materiasobligatorias[] = $row_materiaslineaenfasis;
						// Selección de la carga obligatoria
						$cargaobligatoria[] = $row_materiaslineaenfasis['codigomateria'];
						$materiasporver[] = $row_materiaslineaenfasis;
						$semestre[$row_materiaslineaenfasis['semestredetalleplanestudio']]++;
					}
					else if($estadomateria == "aprobada")
					{
						//echo "bien<br>";
						$materiaspasadas[] = $row_materiaslineaenfasis;
					}
					else
					{
						echo "error";
					}
				}
			}
			@$materiasafiltrar = $materiasporver;
			//print_r($materiasporver);
			@$materiasconprerequisito = $materiasporver;
			@$materiasobigatoriasquitar = $materiasobligatorias;
			// Solamente se filtran las materias por ver, es decir las sugeridas
			if(isset($materiasafiltrar))
			{
				foreach($materiasafiltrar as $key1 => $value1)
				{
					// Debe tomar las materias que no tengan prerequisito, o el prerequisito este aprobado
					// Las materias del anterior arreglo deben filtrarse por las que no tengan prerequisito o el prerequisito este aprobado.
					// Mejor dicho si el prereqisito de una materia no se encuentra en este mismo arreglo se acepta la materia si no No.
					$query_materiasprerequisito = "select r.codigomateriareferenciaplanestudio
				from referenciaplanestudio r
				where r.idplanestudio = '".$value1['idplanestudio']."'
				and r.codigomateria = '".$value1['codigomateria']."'
				and r.codigotiporeferenciaplanestudio like '1%'
				and r.codigoestadoreferenciaplanestudio = '101'";
					//echo "$query_materiasprerequisito<br>";
					$materiasprerequisito=mysql_query($query_materiasprerequisito, $sala) or die("$query_materiasprerequisito");
					$totalRows_materiasprerequisito = mysql_num_rows($materiasprerequisito);
					if($totalRows_materiasprerequisito != "")
					{
						$tieneprerequisito = false;
						//echo "<br>PAPA: ".$value1['codigomateria']."";
						while($row_materiasprerequisito = mysql_fetch_array($materiasprerequisito))
						{
							// Cada una de las materias prerequisitos se busca en el arreglo, si esta no incluye la materia
							foreach($materiasconprerequisito as $key2 => $value2)
							{
								//echo "<br>".$row_materiasprerequisito['codigomateriareferenciaplanestudio']." = ".$value2['codigomateria']."<br>";
								if($row_materiasprerequisito['codigomateriareferenciaplanestudio'] == $value2['codigomateria'])
								{
									//echo "<br>".$row_materiasprerequisito['codigomateriareferenciaplanestudio']." = ".$value2['codigomateria']."<br>";
									$tieneprerequisito = true;
									//return;
								}
							}
						}
						if(!$tieneprerequisito)
						{
							$quitarobligatoria = false;
							if(isset($materiasobigatoriasquitar))
							{
								foreach($materiasobigatoriasquitar as $key3 => $value3)
								{
									//echo $value1['codigomateria']." == ".$value3['codigomateria']."<br>";
									if($value1['codigomateria'] == $value3['codigomateria'])
									{
										//echo $value1['codigomateria']." == ".$value3['codigomateria']."<br>";
										$quitarobligatoria = true;
									}
								}
							}
							if(!$quitarobligatoria)
							{
								$materiaspropuestas[] = $value1;
								// Selección de la carga obligatoria
								$cargaobligatoria[] = $value1['codigomateria'];
								$semestre[$value1['semestredetalleplanestudio']]++;
							}
						}
					}
					else
					{
						$quitarobligatoria = false;
						if(isset($materiasobigatoriasquitar))
						{
							foreach($materiasobigatoriasquitar as $key3 => $value3)
							{
								//echo $value1['codigomateria']." == ".$value3['codigomateria']."<br>";
								if($value1['codigomateria'] == $value3['codigomateria'])
								{
									//echo $value1['codigomateria']." == ".$value3['codigomateria']."<br>";
									$quitarobligatoria = true;
								}
							}
						}
						if(!$quitarobligatoria)
						{
							$materiaspropuestas[] = $value1;
							// Selección de la carga obligatoria
							$cargaobligatoria[] = $value1['codigomateria'];
							$semestre[$value1['semestredetalleplanestudio']]++;
						}
					}
				}
			}
			else
			{
				//echo '<h1 align="center">El estudiante no tiene materias para ver</h1>';
			}
		}
		else
		{
			//echo "Este estudiante no tiene asignado un plan de estudios";
			//exit();
		}

		if(isset($materiasporver))
		{
			foreach($materiasporver as $llave => $valor)
			{
				$materiaspendientes[]=array('codigoestudiante'=>$codigoestudiante,'codigomateria'=>$valor['codigomateria'],'nombremateria'=>$valor['nombremateria']);
			}
			return "si";
			//echo "debematerias";
		}
		else
		{
			return "no";
		}
	}


	function conecta_sap()
	{
		$query_estadoconexionexterna = "select e.codigoestadoconexionexterna, e.nombreestadoconexionexterna, e.codigoestado,
		e.hostestadoconexionexterna, e.numerosistemaestadoconexionexterna, e.mandanteestadoconexionexterna, 
		e.usuarioestadoconexionexterna, e.passwordestadoconexionexterna
		from estadoconexionexterna e
		where e.codigoestado like '1%'";
		//and dop.codigoconcepto = '151'
		//echo "sdas $query_ordenes<br>";
		$estadoconexionexterna = $this->conexion->query($query_estadoconexionexterna);
		$row_estadoconexionexterna = $estadoconexionexterna->fetchRow($estadoconexionexterna);
		if(ereg("^1.+$",$row_estadoconexionexterna['codigoestadoconexionexterna']))
		{
			$login = array (                              // Set login data to R/3
			"ASHOST"=>$row_estadoconexionexterna['hostestadoconexionexterna'],           	// application server host name
			"SYSNR"=>$row_estadoconexionexterna['numerosistemaestadoconexionexterna'],      // system number
			"CLIENT"=>$row_estadoconexionexterna['mandanteestadoconexionexterna'],          // client
			"USER"=>$row_estadoconexionexterna['usuarioestadoconexionexterna'],             // user
			"PASSWD"=>$row_estadoconexionexterna['passwordestadoconexionexterna'],			// password
			"CODEPAGE"=>"1100");              												// codepage

			$rfc = saprfc_open($login);
			if(!$rfc)
			{
				echo "<script language='javascript'>alert('Falló conexión a SAP')</script>";
				// We have failed to connect to the SAP server
				//echo "<br><br>Failed to connect to the SAP server".saprfc_error();
				//exit(1);
			}
		}
		return $rfc;
	}

	function validacion_saldo_sap($codigoestudiante,$rfc,&$deudassap)
	{
		$query_dataestudiante = "SELECT *
       FROM estudiante e,estudiantegeneral eg 
       WHERE e.idestudiantegeneral = eg.idestudiantegeneral
   	   and e.codigoestudiante = '".$codigoestudiante."'";
		// echo $query_dataestudiante;
		$dataestudiante = $this->conexion->query($query_dataestudiante);
		$row_dataestudiante = $dataestudiante->fetchRow();
		$totalRows_dataestudiante = $dataestudiante->numRows();
		if ($row_dataestudiante <> "")
		{
			$numerodocumento = $row_dataestudiante['idestudiantegeneral'];
		}
		$rfcfunction = "ZFKK_OPEN_ITEMS_FOR_ACC_READ";
		$entrego = "I_GPART";
		$resultstable = "T_FKKOP";

		$rfc = saprfc_open($login);

		if(!$rfc)
		{
			// echo "Failed to connect to the SAP server".saprfc_error();
		}
		@$rfchandle = saprfc_function_discover($rfc, $rfcfunction);

		if(!$rfchandle)
		{
			// echo "We have failed to discover the function".saprfc_error($rfc);
		}
		// traigo la tabla interna de SAP
		@saprfc_table_init($rfchandle,$resultstable);
		// importo el numero de documento a consultar
		@saprfc_import($rfchandle,$entrego,$numerodocumento);

		@$rfcresults = saprfc_call_and_receive($rfchandle);

		$numrows = saprfc_table_rows($rfchandle,$resultstable);
		//echo $numrows;
		for ($i=1; $i <= $numrows; $i++)
		{
			$results[$i] = saprfc_table_read($rfchandle,$resultstable,$i);
		}
		if ($results <> "")
		{  // if 1
			foreach ($results as $valor => $total)
			{ // foreach 1
				foreach ($total as $valor1 => $total1)
				{ // foreach 2
					if ($valor1 == "HVORG")
					{
						$opprincipal = $total1;
						// echo $opprincipal,"<br>";
					}
					if ($valor1 == "TVORG")
					{
						$opparcial = $total1;
					}
					if ($valor1 == "FAEDN")
					{
						$fechavence =  $total1;
					}
					if ($valor1 == "BETRW")
					{
						$valor =  $total1;
					}
					if ($valor1 == "OPBEL")
					{
						$contabilizar =  $total1;
					}
					if ($valor1 == "PRCTR")
					{
						$cb =  $total1;
					}
				} // foreah 2

				$query_concepto = "SELECT * FROM concepto WHERE cuentaoperacionprincipal = '$opprincipal' and cuentaoperacionparcial = '$opparcial'";
				// echo $query_concepto,"<br>";
				$concepto = $this->conexion->query($query_concepto);
				$row_concepto = $concepto->fetchRow();
				$totalRows_concepto = $concepto->numRows();
				$codigocarrera = "";
				$query_carrera = "SELECT * FROM carrera c WHERE  c.codigocentrobeneficio = '$cb' AND c.codigotipocosto = '100'";
				//echo $query_carrera;
				$carrera = $this->$query_carrera;
				$row_carrera = $carrera->fetchRow();
				$totalRows_carrera = $carrera->numRows();

				if (! $row_carrera)
				{
				$query_carrera = "SELECT m.codigocarrera
			   FROM numeroordeninternasap n,grupo g,materia m
			   WHERE numeroordeninternasap = '$cb'
			   AND g.idgrupo = n.idgrupo
			   AND m.codigomateria = g.codigomateria";
					// echo $query_carrera;
					$carrera = $this->conexion->query($query_carrera);
					$row_carrera = $carrera->fetchRow();
					$totalRows_carrera = mysql_num_rows($carrera);
				}
				$codigocarrera = $row_carrera['codigocarrera'];

				if ($codigocarrera == "")
				{
					$codigocarrera = $row_dataestudiante['codigocarrera'];
				}
				$query_codigoestudiantecarrera = "SELECT *
		   FROM estudiante e, prematricula p
		   WHERE e.idestudiantegeneral = '".$row_dataestudiante['idestudiantegeneral']."'
		   AND e.codigocarrera = '$codigocarrera'
		   and p.codigoestudiante = e.codigoestudiante";
				//echo $query_codigoestudiantecarrera,"<br><br><br>";
				$codigoestudiantecarrera = mysql_query($query_codigoestudiantecarrera, $sala) or die("$query_codigoestudiantecarrera".mysql_error());
				$row_codigoestudiantecarrera = mysql_fetch_assoc($codigoestudiantecarrera);
				$totalRows_codigoestudiantecarrera = mysql_num_rows($codigoestudiantecarrera);
				$codigoestudiante =  $row_codigoestudiantecarrera['codigoestudiante'];
				if ($row_concepto <> "")
				{
					if ($row_concepto['codigoconcepto'] == '149' and $codigocarrera <> '98')
					{
						$row_concepto['codigoconcepto'] = '154';
					}
					// echo $row_concepto['codigoconcepto'],"-",$codigocarrera;
					if ($row_concepto['codigotipoconcepto'] == '02')
					{
						$saldoafavor[] = array('codigoestudiante'=>$codigoestudiante,'codigocarrera'=>$codigocarrera,'concepto'=>$row_concepto['codigoconcepto'],'nombreconcepto'=>$row_concepto['nombreconcepto'],'fechavence'=>$fechavence,'valor'=>$valor,'contabilizar'=>$contabilizar);
					}
					else
					if ($row_concepto['codigotipoconcepto'] == '01')
					{
						$saldoencontra[] = array('codigoestudiante'=>$codigoestudiante,'codigocarrera'=>$codigocarrera,'codigoconcepto'=>$row_concepto['codigoconcepto'],'nombreconcepto'=>$row_concepto['nombreconcepto'],'fechavence'=>$fechavence,'valor'=>$valor,'contabilizar'=>$contabilizar);
						//echo "debe";
						$deudassap=$saldoencontra;

					}
				} // foreach 1
			} // if 1
		}
		if(!is_array($saldoencontra))
		{
			return "no";
		}
		else
		{
			return "si";
		}
	}
	function validacion_pago_derechos_grado($codigoestudiante,$sala)
	{
		$query_valida_pago_derechos_grado="
	SELECT count(c.codigoconcepto) as cantidad
	FROM
	concepto c, ordenpago op, detalleordenpago dop
	WHERE
	op.numeroordenpago=dop.numeroordenpago
	AND	op.codigoestudiante='".$codigoestudiante."'
	AND c.codigoconcepto=dop.codigoconcepto
	AND c.codigoconcepto='108'
	AND op.codigoestadoordenpago like '4%'
	";
		//echo $query_valida_pago_derechos_grado,"<br>";
		$valida_pago_derechos_grado=mysql_query($query_valida_pago_derechos_grado) or die(mysql_error.$query_valida_pago_derechos_grado);
		$row_valida_pago_derechos_grado=mysql_fetch_assoc($valida_pago_derechos_grado);
		$cantidad=$row_valida_pago_derechos_grado['cantidad'];
		//print_r($row_valida_pago_derechos_grado);
		//echo $row_valida_pago_derechos_grado['cantidad'],"<br>";
		if($cantidad==0)
		{
			return "si";//debe
		}
		else
		{
			return "no";//nodebe
		}
	}

	function validar($idtipodetallepazysalvoegresado)
	{
		$valido=false;
		if($idtipodetallepazysalvoegresado==6)
		{
			$valido=$this->valida_egreso();
		}
		if($idtipodetallepazysalvoegresado==3)
		{
			$valido=$this->validacion_pazysalvo($this->codigoestudiante);
		}
		if($idtipodetallepazysalvoegresado==2)
		{
			$valido=$this->validacion_documentos($this->codigocarrera,$this->codigogenero,$this->codigoestudiante,$this->conexion,$documentacionpendiente);
		}
		if($idtipodetallepazysalvoegresado==7)
		{
			//$valido=true;
		}
		if($idtipodetallepazysalvoegresado==1)
		{
			//$valido=$this->generarcargaestudiante($this->codigoestudiante,$sala,$materiaspendientes);
		}
		if($idtipodetallepazysalvoegresado==4)
		{
			$valido=$this->validacion_saldo_sap();
		}
		return $valido;
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

	function tomar_ip()
	{
		if( $_SERVER['HTTP_X_FORWARDED_FOR'] != '' )
		{
			$client_ip =
			( !empty($_SERVER['REMOTE_ADDR']) ) ?
			$_SERVER['REMOTE_ADDR']
			:
			( ( !empty($_ENV['REMOTE_ADDR']) ) ?
			$_ENV['REMOTE_ADDR']
			:
			"unknown" );

			// los proxys van añadiendo al final de esta cabecera
			// las direcciones ip que van "ocultando". Para localizar la ip real
			// del usuario se comienza a mirar por el principio hasta encontrar
			// una dirección ip que no sea del rango privado. En caso de no
			// encontrarse ninguna se toma como valor el REMOTE_ADDR

			$entries = split('[, ]', $_SERVER['HTTP_X_FORWARDED_FOR']);

			reset($entries);
			while (list(, $entry) = each($entries))
			{
				$entry = trim($entry);
				if ( preg_match("/^([0-9]+.[0-9]+.[0-9]+.[0-9]+)/", $entry, $ip_list) )
				{
					// http://www.faqs.org/rfcs/rfc1918.html
					$private_ip = array(
					'/^0./',
					'/^127.0.0.1/',
					'/^192.168..*/',
					'/^172.((1[6-9])|(2[0-9])|(3[0-1]))..*/',
					'/^10..*/');

					$found_ip = preg_replace($private_ip, $client_ip, $ip_list[1]);

					if ($client_ip != $found_ip)
					{
						$client_ip = $found_ip;
						break;
					}
				}
			}
		}
		else
		{
			$client_ip =
			( !empty($_SERVER['REMOTE_ADDR']) ) ?
			$_SERVER['REMOTE_ADDR']
			:
			( ( !empty($_ENV['REMOTE_ADDR']) ) ?
			$_ENV['REMOTE_ADDR']
			:
			"unknown" );
		}
		return $client_ip;
	}

}
?>

