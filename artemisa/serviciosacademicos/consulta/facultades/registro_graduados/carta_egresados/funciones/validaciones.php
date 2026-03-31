<?php
    session_start();
    include_once('../../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
/*error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING ^ E_DEPRECATED);
ini_set('display_errors', E_ALL ^ E_NOTICE ^ E_WARNING ^ E_DEPRECATED);*/
$ruta = "./";
//$contador = 0;
while (!is_file($ruta.'functionsElectivasPendientes.php'))
{   
    $ruta = $ruta."facultades/registro_graduados/carta_egresados/";
    //echo "2 ".$ruta."<br/><br/>";
    if(is_file($ruta.'functionsElectivasPendientes.php')){
        //entonces deja esa ruta que esta afuera
    } else {
        $ruta = str_replace("facultades/registro_graduados/carta_egresados/", "", $ruta);
        $ruta = $ruta."../";     
    }
    //echo "3 ".$ruta."<br/><br/>";
    //$contador += 1;
    //if($contador>5){
    //    die;
    //}
}
require_once($ruta.'functionsElectivasPendientes.php');
class validaciones_requeridas
{
	var $array_validaciones;
	var $materiasporver;
	var $codigoestudiante;
	var $conexion;
	var $array_datos_estudiante;
	var $array_materias_actuales;
	var $array_documentos_pendientes;
	var $array_materias_pendientes;
	var $valor_pago_derechos_grado;
	var $array_pazysalvos_pendientes;
	var $array_deudas_sap;
	var $codigocarrera;
	var $codigogenero;
	var $codigoperiodo;
	var $sap;
	var $login_sap;
	var $plandepagos;

	function validaciones_requeridas(&$conexion,$codigoestudiante,$codigoperiodo,$debug=false)
	{
		if($debug==true)
		{
			$conexion->debug=true;
		}
		$this->debug=$debug;
		$this->conexion=$conexion;
		$this->codigoperiodo=$codigoperiodo;
		//$this->sap=$this->conecta_sap();
		$this->codigoestudiante=$codigoestudiante;
		$this->selecciona_datos_estudiante();
		$this->array_materias_actuales=$this->materias_actuales($codigoestudiante,$codigoperiodo);
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
		$query="SELECT dpe.idtipodetallepazysalvoegresado, tdpe.nombretipodetallepazysalvoegresado as validacion,dpe.ubicacionpaginadetallepazysalvoegresado as orden_ubicacion_carta,dpe.textodetallepazysalvoegresado as texto,
		tdpe.codigotiporegistro
		FROM
		pazysalvoegresado pe, detallepazysalvoegresado dpe, tipodetallepazysalvoegresado tdpe
		WHERE
		pe.idpazysalvoegresado=dpe.idpazysalvoegresado
		AND dpe.codigoestado=100
		AND NOW() BETWEEN pe.fechadesdepazysalvoegresado AND pe.fechahastapazysalvoegresado
		AND pe.codigocarrera='$this->codigocarrera'
		AND dpe.idtipodetallepazysalvoegresado=tdpe.idtipodetallepazysalvoegresado
		ORDER BY dpe.ubicacionpaginadetallepazysalvoegresado
		";

		$operacion=$this->conexion->query($query);
		$row_operacion=$operacion->fetchRow();
		do
		{
			if($row_operacion['idtipodetallepazysalvoegresado']<>"")
			{
				if($row_operacion['codigotiporegistro']==100)
				{
					$requerido=true;
				}
				else
				{
					$requerido=false;
				}
				$array_interno[]=array('idtipodetallepazysalvoegresado'=>$row_operacion['idtipodetallepazysalvoegresado'],'requerido'=>$requerido,'validacion'=>$row_operacion['validacion'],'orden_ubicacion_carta'=>$row_operacion['orden_ubicacion_carta'],'carreta'=>$row_operacion['texto'],'valido'=>$this->validar($row_operacion['idtipodetallepazysalvoegresado']));
			}
		}
		while ($row_operacion=$operacion->fetchRow());
		$this->array_validaciones=$array_interno;
		
	}

	function materias_actuales($codigoestudiante,$codigoperiodo)
	{
		$query_premainicial1 = "SELECT d.codigomateria, m.nombremateria, d.codigomateriaelectiva
		FROM detalleprematricula d, prematricula p, materia m, estudiante e
		where d.codigomateria = m.codigomateria 
		and d.idprematricula = p.idprematricula
		and p.codigoestudiante = e.codigoestudiante
		and e.codigoestudiante = '$codigoestudiante'
		and p.codigoestadoprematricula like '4%'
		and (d.codigoestadodetalleprematricula like '3%' or d.codigoestadodetalleprematricula = '23')
		and p.codigoperiodo = '$codigoperiodo'";
		$operacion=$this->conexion->query($query_premainicial1);
		do
		{
			if($row_operacion['codigomateria']<>"")
			{
				$array_interno[]=$row_operacion;
			}
		}
		while($row_operacion=$operacion->fetchRow());
		if($this->debug==true and is_array($array_interno))
		{
			$this->tabla($array_interno,'materias actuales');
		}
		return $array_interno;
	}

	function retorna_valor_pago_derechos_grado()
	{
		return $this->valor_pago_derechos_grado;
	}

	function retorna_array_validaciones()
	{
		return $this->array_validaciones;
	}

	function retorna_array_materias_pendientes()
	{
		return $this->array_materias_pendientes;
	}

	function retorna_array_materias_actuales()
	{
		return $this->array_materias_actuales;
	}

	function retorna_array_deudas_sap()
	{
		return $this->array_deudas_sap;
	}

	function retorna_array_documentos_pendientes()
	{
		return $this->array_documentos_pendientes;
	}
	function retorna_array_pazysalvos_pendientes()
	{
		return $this->array_pazysalvos_pendientes;
	}
	function retorna_plandepagos()
	{
		return $this->plandepagos;
	}
	function verifica_validaciones()
	{
		$valido=true;
		if(is_array($this->array_validaciones))
		{
			foreach ($this->array_validaciones as $llave => $valor)
			{
				if($valor['requerido']==true and $valor['valido']==false)
				{
					$valido=false;
				}
			}
			if($this->debug==true)
			{
				$this->tabla($this->array_validaciones,'validaciones');
			}
		}
		else
		{
			$valido=false;
		}
		return $valido;
	}

	function validacion_egreso($codigoestudiante)
	{
		$query="select codigoestudiante from estudiante e
		where e.codigosituacioncarreraestudiante='104'
		and codigoestudiante='$codigoestudiante'";
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
	function validacion_trabajogrado($codigoestudiante)
	{
		$query="select codigoestudiante from trabajodegrado 
		where codigoestudiante='$codigoestudiante'
		and codigoestado like '1%'";
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
		$query_pazysalvo = "select p.idpazysalvoestudiante, tpse.nombretipopazysalvoestudiante, c.nombrecarrera
		from pazysalvoestudiante p, detallepazysalvoestudiante d, estudiante e, tipopazysalvoestudiante tpse, carrera c
		where e.codigoestudiante = '$codigoestudiante'
		and p.codigocarrera=c.codigocarrera
		and p.idpazysalvoestudiante = d.idpazysalvoestudiante
		and d.codigoestadopazysalvoestudiante like '1%'
		and tpse.codigotipopazysalvoestudiante=d.codigotipopazysalvoestudiante
		and e.idestudiantegeneral = p.idestudiantegeneral";
		//echo $query_pazysalvo,"<br>";
		$pazysalvo = $this->conexion->query($query_pazysalvo);
		$totalRows_pazysalvo = $pazysalvo->numRows();
		$row_pazysalvo = $pazysalvo->fetchRow();
		//echo $query_pazysalvo,"<br>";
		if($totalRows_pazysalvo>0)
		{
			do
			{
				if($row_pazysalvo['idpazysalvoestudiante']<>"")
				{
					$array_interno[]=$row_pazysalvo;
				}
			}
			while ($row_pazysalvo=$pazysalvo->fetchRow());
			$this->array_pazysalvos_pendientes=$array_interno;
			if($this->debug==true)
			{
				$this->tabla($this->array_pazysalvos_pendientes,'pazysalvos pendientes');
			}
			return false;
		}
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
			$this->array_documentos_pendientes=$documentacionpendiente;
			if($this->debug==true)
			{
				$this->tabla($this->array_documentos_pendientes,'documentos pendientes');
			}
			return false;
		}
		else
		{
			return true;
		}
	}
	// Esta funcion recibe el estudiante, la materia que se quiere verificar, el plan de estudios donde se encuentra la materia y la base de datos.
	function materiaaprobada($codigoestudiante, $codigomateria, $idplanestudio, $reprobada)
	{
		$query_materianota = "SELECT n.codigomateria, n.notadefinitiva, m.notaminimaaprobatoria, n.codigoperiodo
	FROM notahistorico n, materia m
	WHERE n.codigoestudiante = '$codigoestudiante'
	AND m.codigomateria = n.codigomateria
	AND (n.codigomateria = '$codigomateria' OR n.codigomateriaelectiva = '$codigomateria')
	and n.codigoestadonotahistorico like '1%'
	ORDER BY 4 ";
		//echo "$query_materianota<br>";
		$materianota=$this->conexion->query($query_materianota);
		$totalRows_materianota = $materianota->numRows();
		// Entra si la materia tienen nota historica para este estudiante
		// Sino busca la materia equivalente
		if($totalRows_materianota != "")
		{
			while($row_materianota = $materianota->fetchRow())
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
		$materiaequivalente=$this->conexion->query($query_materiaequivalente);
		$totalRows_materiaequivalente = $materiaequivalente->numRows();
		// Si tiene materia equivalente entra a hacer lo mismo, es decir a mirar si la equivalente esta aprobada
		// Para el sigiente plan de estudios de la carrera donde aparezca esta materia
		// Sino retorna falso
		if($totalRows_materiaequivalente != "")
		{
			while($row_materiaequivalente = $materiaequivalente->fetchRow())
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
				$materianota=$this->conexion->query($query_materianota);
				$totalRows_materianota = $materianota->numRows();
				// Entra si la materia tienen nota historica para este estudiante
				// Sino busca la materia equivalente
				if($totalRows_materianota != "")
				{
					while($row_materianota = $materianota->fetchRow())
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
	function generarcargaestudiante($codigoestudiante)
	{
		// Proceso para generar la carga académica
		// Toma todas las materias del plan de estudios
		// La variable $quitaparacartas se usa para las cartas de los estudiantes graduandos
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
		$quitaparacartas
		order by 4,3";
		//and d.codigotipomateria not like '5%'
		//and d.codigotipomateria not like '4%'";
		//echo "$query_materiasplanestudio<br>";
		$materiasplanestudio=$this->conexion->query($query_materiasplanestudio);
		$totalRows_materiasplanestudio = $materiasplanestudio->numRows();
		//echo "Total: $totalRows_materiasplanestudio<br>";
		$quitarmateriasdelplandestudios = "";
		$tieneunplandeestudios = true;
		if($totalRows_materiasplanestudio != "")
		{
			// Este arreglo sirve para guardar el semestre que mas se repite
			// Tomo el maximo numero de semestres del plan de estudio
			$query_semestreplanes = "select max(cantidadsemestresplanestudio*1) as semestre from planestudio";
			$semestreplanes=$this->conexion->query($query_semestreplanes);
			$totalRows_semestreplanes = $semestreplanes->numRows();
			$row_semestreplanes = $semestreplanes->fetchRow();
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
			while($row_materiasplanestudio = $materiasplanestudio->fetchRow())
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
						$estadomateria = $this->materiaaprobada($codigoestudiante, $row_materiasplanestudio['codigomateria'], $row_materiasplanestudio['idplanestudio'], $reprobada);
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
				where le.codigoestudiante = '$codigoestudiante'
				 and now() between le.fechainiciolineaenfasisestudiante and le.fechavencimientolineaenfasisestudiante";
						//and d.codigotipomateria not like '5%'
						//and d.codigotipomateria not like '4%'";
						//echo "$query_materiasplanestudio<br>";
						$poseelineaenfasis=$this->conexion->query($query_poseelineaenfasis);
						$totalRows_poseelineaenfasis = $poseelineaenfasis->numRows();
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
		and now() between l.fechainiciolineaenfasisestudiante and l.fechavencimientolineaenfasisestudiante
		group by 3
		order by 2,5";
				//and d.codigotipomateria not like '5%'
				//and d.codigotipomateria not like '4%'";
				//echo "$query_materiaslineaenfasis<br>";
				$materiaslineaenfasis=$this->conexion->query($query_materiaslineaenfasis);
				$totalRows_materiaslineaenfasis = $materiaslineaenfasis->numRows();
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
				$materiaslineaenfasis=$this->conexion->query($query_materiaslineaenfasis);
				$totalRows_materiaslineaenfasis = $materiaslineaenfasis->numRows();
			}
			if($totalRows_materiaslineaenfasis != "")
			{
				while($row_materiaslineaenfasis = $materiaslineaenfasis->fetchRow())
				{
					$quitarmateriasdelplandestudios = "$quitarmateriasdelplandestudios and m.codigomateria <> '".$row_materiaslineaenfasis['codigomateria']."'";
					$estadomateria = $this->materiaaprobada($codigoestudiante, $row_materiaslineaenfasis['codigomateria'], $idplan, $reprobada);
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
			$materiasafiltrar = $materiasporver;
			//print_r($materiasporver);
			$materiasconprerequisito = $materiasporver;
			$materiasobigatoriasquitar = $materiasobligatorias;
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
					$materiasprerequisito=$this->conexion->query($query_materiasprerequisito);
					$totalRows_materiasprerequisito = $materiasprerequisito->numRows();
					if($totalRows_materiasprerequisito != "")
					{
						$tieneprerequisito = false;
						//echo "<br>PAPA: ".$value1['codigomateria']."";
						while($row_materiasprerequisito = $materiasprerequisito->fetchRow())
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
			//echo '<h1 align="center">Este estudiante no tiene asignado un plan de estudios</h1>';
			$tieneunplandeestudios = false;
			//exit();
		}
		//exit();
		//print_r($materiaspropuestas);
                //calcular las electivas pendientes
                $query_creditoselectivos = getCreditosElectivasPlanEstudio($codigoestudiante,null,true);
                $creditosporverelectivas=$this->conexion->query($query_creditoselectivos);
                //print_r($query_creditoselectivos); echo "<br/><br/>";
                if($creditosporverelectivas->numRows()!=""){
                    $row_creditoselectivos = $creditosporverelectivas->fetchRow();
                    $row_creditoselectivos = $row_creditoselectivos["creditos"];
                } else {
                    $row_creditoselectivos = 0;
                }
                
                $query_materiaselectivasplanestudio = getQueryMateriasElectivasCPEstudiante($codigoestudiante,true);
                //print_r($query_materiaselectivasplanestudio); echo "<br/><br/>";
                
		//and d.codigotipomateria not like '5%'
		//and d.codigotipomateria not like '4%'";
		//echo "$query_materiasplanestudio<br>";
		$materiasporverelectivas=$this->conexion->query($query_materiaselectivasplanestudio);
                $totalRows_materiaselectivas = $materiasporverelectivas->numRows();
		$electivasporver = array();
                $numCreditosPendientes = $row_creditoselectivos;                
                //echo "<pre>";print_r($numCreditosPendientes); echo "<br/><br/>";
                if($totalRows_materiaselectivas != ""){
                    $row_materiaselectivas = $materiasporverelectivas->fetchRow();
                    $numCreditosPendientes = $numCreditosPendientes - $row_materiaselectivas["numerocreditos"];
                    //echo "<pre>";print_r($row_materiaselectivas); echo "<br/><br/>";
                }
               /* if($totalRows_materiaselectivas != "")
		{
                    $row_materiaselectivas = $materiasporverelectivas->fetchRow();
                    $numCreditosPendientes = $numCreditosPendientes - $row_materiaselectivas["numerocreditos"];
                    /*while($row_materiaselectivas = $materiasporverelectivas->fetchRow())
                    {
                        //echo "<pre>";print_r($query_materiahija); echo "<br/><br/>";
                        //$numCreditosPendientes = $numCreditosPendientes - $row_materiaselectivas["numerocreditos"];
                        //echo "<pre>";print_r($numCreditosPendientes); echo "<br/><br/>";
                        /*if($row_materiaselectivas["codigotipomateria"]!=5){                                        
                            $electivasporver[] = $row_materiaselectivas;
                        } else {
                                       
                            $query_materiahija = "select m.*, nh.notadefinitiva from planestudioestudiante pe 
                                inner join lineaenfasisestudiante le on 
                                le.idplanestudio=pe.idplanestudio and 
                                le.codigoestudiante=pe.codigoestudiante 
                                inner join detallelineaenfasisplanestudio dl on 
                                dl.idlineaenfasisplanestudio = le.idlineaenfasisplanestudio 
                                and dl.idplanestudio = pe.idplanestudio 
                                inner join materia m on 
                                m.codigomateria=dl.codigomateriadetallelineaenfasisplanestudio 
                                inner join notahistorico nh on nh.codigomateria=dl.codigomateriadetallelineaenfasisplanestudio
                                and nh.codigoestudiante=pe.codigoestudiante 
                                WHERE pe.codigoestudiante='$codigoestudiante' 
                                and dl.codigomateria=".$row_materiaselectivas['codigomateria']." 
                                    and nh.notadefinitiva>=m.notaminimaaprobatoria";
                                //print_r($query_materiahija); echo "<br/><br/>";
                                $materiahija = $this->conexion->query($query_materiahija);
                                
                                $totalRows_materiahija = $materiahija->RecordCount();
                                if($totalRows_materiahija != "" && $totalRows_materiahija>0)
                                {   
                                    //todo bien ya vio la materia
                                }
                                else
                                {
                                    //por si son equivalencias
                                    $query_materiahija = "select m.*, nh.notadefinitiva from notahistorico nh 
                                        inner join materia m on m.codigomateria=nh.codigomateria  
                                        WHERE nh.codigoestudiante='$codigoestudiante' 
                                        and nh.codigomateria IN 
                                        (
                                            select dgm.codigomateria 
                                            from grupomaterialinea gm 
                                            inner join detallegrupomateria dgm on dgm.idgrupomateria=gm.idgrupomateria
                                            where gm.codigomateria=".$row_materiaselectivas['codigomateria']." 
                                        )
                                         and nh.notadefinitiva>=m.notaminimaaprobatoria";
                                        //print_r($query_materiahija); echo "<br/><br/>";
                                        $materiahija = $this->conexion->query($query_materiahija);

                                        $totalRows_materiahija = $materiahija->RecordCount();
                                        if($totalRows_materiahija != "" && $totalRows_materiahija>0)
                                        {   
                                            //todo bien ya vio la materia
                                        }
                                        else
                                        {
                                                $electivasporver[] = $row_materiaselectivas;
                                        }
                                }
                            
                        }
                    }
                    
		}*/
                
                if($numCreditosPendientes>0){
                    $electivasporver[] = array("codigomateria"=>"Debe ".$numCreditosPendientes." crédito(s)","nombremateria"=>"Electivas Libres",
                        "codigoindicadorgrupomateria" =>100,"nombretipomateria"=>"Electivas libres", "codigotipomateria"=>4,"numerocreditosdetalleplanestudio"=>$numCreditosPendientes );
                }
                
		if(is_array($materiasporver)||is_array($electivasporver))
		{
			//$this->array_materias_pendientes=$materiasporver;
                        $pendientes = array_merge((array)$materiasporver, (array)$electivasporver);
                        if(is_array($pendientes) && count($pendientes)>0){
                            $this->array_materias_pendientes = $pendientes;
                            //var_dump($this->array_materias_pendientes);
                            if($this->debug==true)
                            {
                                    $this->tabla($this->array_materias_pendientes,'pendientes');
                            }
                            return false;
                        } else {
                            return true; 
                        }
		}
		else
		{
			return true;
		}

	}


	/*function conecta_sap()
	{
		$query_estadoconexionexterna = "select e.codigoestadoconexionexterna, e.nombreestadoconexionexterna, e.codigoestado,
		e.hostestadoconexionexterna, e.numerosistemaestadoconexionexterna, e.mandanteestadoconexionexterna, 
		e.usuarioestadoconexionexterna, e.passwordestadoconexionexterna
		from estadoconexionexterna e
		where e.codigoestado like '1%'";
		//echo $query_estadoconexionexterna;
		//and dop.codigoconcepto = '151'
		//echo "sdas $query_ordenes<br>";
		$estadoconexionexterna = $this->conexion->query($query_estadoconexionexterna);
		$row_estadoconexionexterna = $estadoconexionexterna->fetchRow($estadoconexionexterna);
		$numrows_estadoconexionexterna=$estadoconexionexterna->numRows();
		if ($numrows_estadoconexionexterna==0)
		{
			echo "<script language='javascript'>alert('Ni hay conexión a SAP disponible')</script>";
			return false;
		}
		else if(ereg("^1.+$",$row_estadoconexionexterna['codigoestadoconexionexterna']))
		{
			$this->login_sap = array (                              // Set login data to R/3
			"ASHOST"=>$row_estadoconexionexterna['hostestadoconexionexterna'],           	// application server host name
			"SYSNR"=>$row_estadoconexionexterna['numerosistemaestadoconexionexterna'],      // system number
			"CLIENT"=>$row_estadoconexionexterna['mandanteestadoconexionexterna'],          // client
			"USER"=>$row_estadoconexionexterna['usuarioestadoconexionexterna'],             // user
			"PASSWD"=>$row_estadoconexionexterna['passwordestadoconexionexterna'],			// password
			"CODEPAGE"=>"1100");              												// codepage
			return $this->login_sap;
		}
	}*/

	/*function validacion_plan_de_pagos($codigoestudiante,&$plandepagosvencidos)
	{
		$fecha_hoy=date("Y-m-d");
		$query_idestudiante="SELECT *
       FROM estudiante e,estudiantegeneral eg,documento d
       WHERE e.idestudiantegeneral = eg.idestudiantegeneral and eg.tipodocumento=d.tipodocumento
   	   and e.codigoestudiante = '$codigoestudiante'	";
		$operacion=$this->conexion->query($query_idestudiante);
		$row_operacion=$operacion->fetchRow();
		$idestudiante=$row_operacion['idestudiantegeneral'];
		//echo $query_idestudiante;
		if($idestudiante=="")
		{
			echo "No hay idestudiante";
		}
		else
		{
			
			require_once($_SESSION['path_live'].'consulta/interfacespeople/lib/nusoap.php');

			$proxyhost = isset($_POST['proxyhost']) ? $_POST['proxyhost'] : '';
    $proxyport = isset($_POST['proxyport']) ? $_POST['proxyport'] : '';
    $proxyusername = isset($_POST['proxyusername']) ? $_POST['proxyusername'] : '';
    $proxypassword = isset($_POST['proxypassword']) ? $_POST['proxypassword'] : '';

  $client = new soapclient("http://campus.unbosque.edu.co/PSIGW/PeopleSoftServiceListeningConnector/UBI_ESTADO_CUENTA_SRV.1.wsdl", true);
  
  
  
                          
    $err = $client->getError();
    if ($err) {
        echo '<h2>ERROR EN EL CONSTRUCTOR</h2><pre>' . $err . '</pre>';
    }
    $proxy = $client->getProxy();

       $param2="   <UB_DATOSCONS_WK>
           <NATIONAL_ID_TYPE>".$row_operacion['nombrecortodocumento']."</NATIONAL_ID_TYPE>
    <NATIONAL_ID>".$row_operacion['numerodocumento']."</NATIONAL_ID>
        </UB_DATOSCONS_WK>";

    $resultado = $client->call('UBI_CUENTA_CLIENTE_OPR_SRV',$param2);
    $results=$resultado['UBI_ITEMS_WRK'] ['UBI_ITEM_WRK'];
    
   
   
   $valido=true;
				 
		   
			if(is_array($results))
			{
				
				
				foreach ($results as $llave => $valor)
				{
					
		
					$fechavence = $valor['DUE_DT'];
					
					
					
					if($fecha_hoy > $fechavence)
					{
						
						$valido=false;
					}
				}
				
			

		}
		
			if($valido==false)
		{
			$this->plandepagos=" ";
		}
		
		else if($valido==true)
		{
			$this->plandepagos="";
		}
		
		
		
		
		
		return $valido;
		
		
		
		
	}
}*/


function validacion_plan_de_pagos($codigoestudiante,&$plandepagosvencidos)
{

		$query_idestudiante="SELECT *
        FROM estudiante e,estudiantegeneral eg,documento d
        WHERE e.idestudiantegeneral = eg.idestudiantegeneral and eg.tipodocumento=d.tipodocumento
   	    and e.codigoestudiante = '$codigoestudiante'	";
		$operacion=$this->conexion->query($query_idestudiante);
		$row_operacion=$operacion->fetchRow();
   
			
		require_once(dirname(__FILE__).'/../../../../../../nusoap/lib/nusoap.php');
		require_once(realpath(dirname(__FILE__)).'/../../../../interfacespeople/conexionpeople.php');
		//require_once(dirname(__FILE__).'/../../../../interfacespeople/lib/nusoap.php');
		
		$proxyhost = isset($_POST['proxyhost']) ? $_POST['proxyhost'] : '';
		$proxyport = isset($_POST['proxyport']) ? $_POST['proxyport'] : '';
		$proxyusername = isset($_POST['proxyusername']) ? $_POST['proxyusername'] : '';
		$proxypassword = isset($_POST['proxypassword']) ? $_POST['proxypassword'] : '';
			
		$results=array();
		require_once(dirname(__FILE__).'/../../../../interfacespeople/reporteCaidaPeople.php');
		$envio=0;

		if(verificarPSEnLinea()){

			$client = new nusoap_client(WEBESTADOCUENTA,true, false, false, false, false, 0, 100);
								
			$err = $client->getError();
			if ($err) {
				echo '<h2>ERROR EN EL CONSTRUCTOR</h2><pre>' . $err . '</pre>';
			}
			$proxy = $client->getProxy();

				$param2="<UB_DATOSCONS_WK>
						 <NATIONAL_ID_TYPE>".$row_operacion['nombrecortodocumento']."</NATIONAL_ID_TYPE>
						 <NATIONAL_ID>".$row_operacion['numerodocumento']."</NATIONAL_ID>
						 <DEPTID></DEPTID>
						 </UB_DATOSCONS_WK>";
				$start = time();
				$resultado = $client->call('UBI_CUENTA_CLIENTE_OPR_SRV',$param2);
				$time =  time()-$start;             
				$envio = 1;
				if($time>=100 || $resultado===false){
					$envio=0;
					reportarCaida(1,'Consulta Estado de Cuenta');
				}  else {
					$results=$resultado['UBI_ITEMS_WRK'] ['UBI_ITEM_WRK'];
				}
					
		}// if verificarpsenlinea


		if(!is_array($results[0])){

			$resultstmp=$results;
			unset($results);
			$results[0]=$resultstmp;

		}
			
		if ($results <> "") {
				
			foreach ($results as $valor => $total)
			{ 
		
				$fechavence = $total['DUE_DT'];
				$valor = $total['ITEM_AMT'];
				$itemconcepto = $total['ITEM_TYPE'];
				$numerodeorden = $total['INVOICE_ID'];
				$cuenta=$total['ACCOUNT_NBR'];
				$nombreconcepto=$total['DESCR'];
				$fechasaldoafavor=$total['ITEM_EFFECTIVE_DT'];
				$saldoencontra = array();

				$query_concepto="SELECT * FROM carreraconceptopeople ccp, concepto
				c WHERE c.codigoconcepto=ccp.codigoconcepto and itemcarreraconceptopeople='$itemconcepto'";
				
				$concepto=$this->conexion->query($query_concepto);
				$row_concepto=$concepto->fetchRow();
		
				$query_carrera ="SELECT *
				FROM carrera c, carreraconceptopeople  ccp
				WHERE  c.codigocarrera=ccp.codigocarrera AND
				ccp.itemcarreraconceptopeople = '$itemconcepto'
				AND c.codigotipocosto = '100'";
				$carrera=$this->conexion->query($query_carrera);
				$row_carrera=$carrera->fetchRow();

				$codigocarrera = $row_carrera['codigocarrera'];

				if ($codigocarrera == "") {
					$codigocarrera = $row_dataestudiante['codigocarrera'];
				}
				
				if ($row_concepto <> "") {
					
					if ($row_concepto['codigoconcepto'] == '149' and $codigocarrera <> '98') {
						$row_concepto['codigoconcepto'] = '154';
					}
				
					if ($row_concepto['codigotipoconcepto'] == '01') { 						
						$saldoencontra = array($codigocarrera,$itemconcepto, $row_concepto['codigoconcepto'], $nombreconcepto , $fechavence, $valor, $numerodeorden, $codigoestudiante,$cuenta);
					}
				}
								
				$valido=true;
						
				
					if(count($saldoencontra)>0)

					{

						$fecha = array();

						for($i=0;$i<count($saldoencontra);$i++) {
					
							$arr[$saldoencontra[$i]['0']]=$arr[$saldoencontra[$i]['0']];
				
							$fecha[] =$saldoencontra[$i]['0'];
			
							rsort($fecha);		
						}	

						foreach($fecha as $key => $valor) {

							$hoy = date('Y-m-d');					
							$fechavencida=$valor;
						
							if($fechavencida < $hoy)
							{
								$valido=false;
							}

					    }

					}
				
					if($valido==false)
					{
						$this->plandepagos=" ";
					}
				
					else if($valido==true)
					{
						$this->plandepagos="";
					}				
					
				return $valido;

			}

		}
 
}


	function validacion_saldo_sap($codigoestudiante,&$deudassap)
	{
		// echo "<h1>Entro aqui</h1>";
		
     $query_idestudiante="SELECT *
       FROM estudiante e,estudiantegeneral eg,documento d
       WHERE e.idestudiantegeneral = eg.idestudiantegeneral and eg.tipodocumento=d.tipodocumento
   	   and e.codigoestudiante = '$codigoestudiante'	";
		$operacion=$this->conexion->query($query_idestudiante);
		$row_operacion=$operacion->fetchRow();
   
			
			
require_once(dirname(__FILE__).'/../../../../../../nusoap/lib/nusoap.php');
require_once(realpath(dirname(__FILE__)).'/../../../../interfacespeople/conexionpeople.php');

			$proxyhost = isset($_POST['proxyhost']) ? $_POST['proxyhost'] : '';
    $proxyport = isset($_POST['proxyport']) ? $_POST['proxyport'] : '';
    $proxyusername = isset($_POST['proxyusername']) ? $_POST['proxyusername'] : '';
    $proxypassword = isset($_POST['proxypassword']) ? $_POST['proxypassword'] : '';

		$results=array();
	 require_once(dirname(__FILE__).'/../../../../interfacespeople/reporteCaidaPeople.php');
	 $envio=0;
	 if(verificarPSEnLinea()){
        /************** PRODUCCION ***********************/
        $client = new nusoap_client(WEBESTADOCUENTA,true, false, false, false, false, 0, 100);
    
                            
    $err = $client->getError();
    if ($err) {
        echo '<h2>ERROR EN EL CONSTRUCTOR</h2><pre>' . $err . '</pre>';
    }
    $proxy = $client->getProxy();

       $param2="   <UB_DATOSCONS_WK>
           <NATIONAL_ID_TYPE>".$row_operacion['nombrecortodocumento']."</NATIONAL_ID_TYPE>
    <NATIONAL_ID>".$row_operacion['numerodocumento']."</NATIONAL_ID>
	<DEPTID></DEPTID>
        </UB_DATOSCONS_WK>";
$start = time();
    $resultado = $client->call('UBI_CUENTA_CLIENTE_OPR_SRV',$param2);
    $time =  time()-$start;             
		$envio = 1;
		if($time>=100 || $resultado===false){
					$envio=0;
					reportarCaida(1,'Consulta Estado de Cuenta');
		}  else {
	$results=$resultado['UBI_ITEMS_WRK'] ['UBI_ITEM_WRK'];
		}
   
    
  }
  
  
  /*echo"quE IMPRIME??<pre>";
print_r($results);
echo"</pre>";*/

   if(!is_array($results[0])){

    $resultstmp=$results;
    unset($results);
   $results[0]=$resultstmp;

}
   
  if ($results <> "") {
  
    foreach ($results as $valor => $total) { 



 
 
 
$fechavence = $total['DUE_DT'];
$valor = $total['ITEM_AMT'];
$itemconcepto = $total['ITEM_TYPE'];
$numerodeorden = $total['INVOICE_ID'];
$cuenta=$total['ACCOUNT_NBR'];
$nombreconcepto=$total['DESCR'];
$fechasaldoafavor=$total['ITEM_EFFECTIVE_DT']; 




 $query_concepto="SELECT * FROM carreraconceptopeople ccp, concepto
 c WHERE c.codigoconcepto=ccp.codigoconcepto and itemcarreraconceptopeople='$itemconcepto'";
		$concepto=$this->conexion->query($query_concepto);
		$row_concepto=$concepto->fetchRow();
   
   
   
   
   
   $query_carrera ="SELECT *
		   FROM carrera c, carreraconceptopeople  ccp
		   WHERE  c.codigocarrera=ccp.codigocarrera AND
ccp.itemcarreraconceptopeople = '$itemconcepto'
AND c.codigotipocosto = '100'";
		$carrera=$this->conexion->query($query_carrera);
		$row_carrera=$carrera->fetchRow();
   
   
 

        $codigocarrera = $row_carrera['codigocarrera'];

        if ($codigocarrera == "") {
            $codigocarrera = $row_dataestudiante['codigocarrera'];
        }
        
              
        
        if ($row_concepto <> "") {
			
			            if ($row_concepto['codigoconcepto'] == '149' and $codigocarrera <> '98') {
                $row_concepto['codigoconcepto'] = '154';
            }
           
            if ($row_concepto['codigotipoconcepto'] == '01') {

                $saldoencontra[] = array($codigocarrera,$itemconcepto, $row_concepto['codigoconcepto'], $nombreconcepto , $fechavence, $valor, $numerodeorden, $codigoestudiante,$cuenta);
                 
 
            }
			
			}

  }
} 
             
		if(!is_array($saldoencontra))
		{
			//echo "<h1>Entro a SAldo</h1>";
			
			return true;
		}
		else
		{
			$this->array_deudas_sap=$saldoencontra;
			if($this->debug==true)
			{
				$this->tabla($this->array_deudas_sap,'deudas SAP');
			}
			return false;
		}
	}

	function validacion_pago_derechos_grado($codigoestudiante)
	{
		$query_carrera_estudiante="SELECT e.codigocarrera,c.codigomodalidadacademica FROM estudiante e, carrera c
		WHERE e.codigoestudiante='$codigoestudiante'
		AND c.codigocarrera=e.codigocarrera
		";
		$operacion_carrera_estudiante=$this->conexion->query($query_carrera_estudiante);
		$row_operacion_carrera_estudiante=$operacion_carrera_estudiante->fetchRow();
		$codigocarrera=$row_operacion_carrera_estudiante['codigocarrera'];
		$codigomodalidadacademica=$row_operacion_carrera_estudiante['codigomodalidadacademica'];
		if($codigocarrera=="")
		{
			echo "<h1>Error en validacion de pago de derechos de grado. Codigocarrera nulo</h1>";
		}

		$query_valida_pago_derechos_grado="
		SELECT count(c.codigoconcepto) as cantidad
		FROM
		concepto c, ordenpago op, detalleordenpago dop
		WHERE
		op.numeroordenpago=dop.numeroordenpago
		AND	op.codigoestudiante='".$codigoestudiante."'
		AND c.codigoconcepto=dop.codigoconcepto
		AND c.cuentaoperacionprincipal='108'
		AND op.codigoestadoordenpago like '4%'

		";
		//echo $query_valida_pago_derechos_grado,"<br>";
		$valida_pago_derechos_grado=$this->conexion->query($query_valida_pago_derechos_grado);
		$row_valida_pago_derechos_grado=$valida_pago_derechos_grado->fetchRow();
		$cantidad=$row_valida_pago_derechos_grado['cantidad'];
		//print_r($row_valida_pago_derechos_grado);
		//echo $row_valida_pago_derechos_grado['cantidad'],"<br>";
		if($cantidad==0)
		{
			//postgrados
			if($codigomodalidadacademica==300)
			{
				$query_determina_valor_pago_derechos_grado=
				"SELECT DISTINCT  vp.valorpecuniario FROM concepto c, valorpecuniario vp, facturavalorpecuniario fvp, detallefacturavalorpecuniario dfvp, carrera ca WHERE
				vp.codigoconcepto=c.codigoconcepto 
				AND dfvp.idvalorpecuniario=vp.idvalorpecuniario 
				AND fvp.idfacturavalorpecuniario=dfvp.idfacturavalorpecuniario 
				AND fvp.codigocarrera='$codigocarrera'
				AND fvp.codigocarrera=ca.codigocarrera
				AND ca.codigomodalidadacademica='300'
				AND vp.codigoperiodo='$this->codigoperiodo' 
				AND c.cuentaoperacionprincipal='108'
				";
			}
			else
			{
				$query_determina_valor_pago_derechos_grado=
				"SELECT DISTINCT  vp.valorpecuniario FROM concepto c, valorpecuniario vp, facturavalorpecuniario fvp, detallefacturavalorpecuniario dfvp WHERE
				vp.codigoconcepto=c.codigoconcepto 
				AND dfvp.idvalorpecuniario=vp.idvalorpecuniario 
				AND fvp.idfacturavalorpecuniario=dfvp.idfacturavalorpecuniario 
				AND fvp.codigocarrera='$codigocarrera' 
				AND vp.codigoperiodo='$this->codigoperiodo' 
				AND c.cuentaoperacionprincipal='108'
				";
			}
			$operacion=$this->conexion->query($query_determina_valor_pago_derechos_grado);
			$row_operacion=$operacion->fetchRow();
			//echo $query_determina_valor_pago_derechos_grado,"<br>";

			$this->valor_pago_derechos_grado=$row_operacion['valorpecuniario'];
			if($this->debug==true)
			{
				echo "<h1>".$this->valor_pago_derechos_grado."</h1>";
			}

			return false;//debe
		}
		else
		{
			return true;//nodebe
		}

	}

	function validar($idtipodetallepazysalvoegresado)
	{
		$valido=false;

		if($idtipodetallepazysalvoegresado==1)
		{
			$valido=$this->generarcargaestudiante($this->codigoestudiante,$materiaspendientes);
		}
		if($idtipodetallepazysalvoegresado==2)
		{
			$valido=$this->validacion_documentos($this->codigocarrera,$this->codigogenero,$this->codigoestudiante,$this->conexion,$documentacionpendiente);
		}
		if($idtipodetallepazysalvoegresado==3)
		{
			$valido=$this->validacion_pazysalvo($this->codigoestudiante);
		}
		if($idtipodetallepazysalvoegresado==4)
		{
			$valido=$this->validacion_saldo_sap($this->codigoestudiante,&$deudassap);
			if($valido==true)
			{
				$valido=$this->validacion_plan_de_pagos($this->codigoestudiante,&$plandepagosvencidos);
			}
		}
		if($idtipodetallepazysalvoegresado==5)
		{
			$valido=$this->validacion_pago_derechos_grado($this->codigoestudiante);
		}
		if($idtipodetallepazysalvoegresado==6)
		{
			$valido=$this->validacion_egreso($this->codigoestudiante);
		}
		if($idtipodetallepazysalvoegresado==7)
		{
			$valido=$this->validacion_plan_de_pagos($this->codigoestudiante,&$plandepagosvencidos);
		}
		if($idtipodetallepazysalvoegresado==9)
		{
			$valido=$this->validacion_trabajogrado($this->codigoestudiante);
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

