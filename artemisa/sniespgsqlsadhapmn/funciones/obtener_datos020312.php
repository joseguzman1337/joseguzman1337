  <?php
class snies
{
	var $conexion;
	var $codigoperiodo;
	var $array_periodo;
	var $contador_inserta=0;
	var $contador_actualiza=0;
	var $contador_falla=0;
	var $conexionPSQL;
	var $fechahoy;

	function snies($conexion,$codigoperiodo)
	{
		$this->conexion=$conexion;
		$this->obtener_periodo($codigoperiodo);
		$this->fechahoy=date("Y-m-d H:i:s");

	}

	function asignaConexionPostgreSQL(&$conexion){
		$this->conexionPSQL=$conexion;
		$this->conexionPSQL->debug=true;
	}

	function leerMunicioBDSNIES($depa_code){
		$query="SELECT munic_code FROM municipio WHERE depa_code='$depa_code'";
		$operacion=$this->conexionPSQL->query($query);
		$row_operacion=$operacion->fetchRow();
		$munic_code=$row_operacion['munic_code'];
		return $munic_code;
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

	function codigoestudiante_participante($codigoperiodo)
	{
		$query="SELECT DISTINCT e.codigoestudiante, e.codigocarrera
		FROM
		estudiante e, ordenpago op, carrera c
		WHERE
		op.codigoperiodo='$codigoperiodo'
		AND op.codigoestudiante=e.codigoestudiante
		AND op.codigoestadoordenpago like '4%'
		AND e.codigocarrera=c.codigocarrera
		AND (c.codigomodalidadacademica = 200 OR c.codigomodalidadacademica = 300)
		AND c.codigocarrera <> 13
		AND c.codigocarrera <> 92
		ORDER BY e.codigocarrera
		";
		//$this->conexion->debug=true;
		//AND '$this->fechahoy' BETWEEN c.fechainiciocarrera AND c.fechavencimientocarrera
		$operacion=$this->conexion->query($query);
		//$this->conexion->debug=false;
		$row_operacion=$operacion->fetchRow();
		do
		{
			if(!empty($row_operacion))
			{
				$array_interno[]=$row_operacion;
			}
		}
		while ($row_operacion=$operacion->fetchRow());
		//echo count($array_interno);
		//exit();
		return $array_interno;
	}

	function estudiantegeneral_participante($codigoperiodo)
	{
		$query="SELECT DISTINCT e.idestudiantegeneral, e.codigoestudiante,e.codigocarrera
		FROM
		estudiante e, ordenpago op, carrera c
		WHERE
		op.codigoperiodo='$codigoperiodo'
		AND op.codigoestudiante=e.codigoestudiante
		AND op.codigoestadoordenpago like '4%'
		AND e.codigocarrera=c.codigocarrera
		AND (c.codigomodalidadacademica = 200 OR c.codigomodalidadacademica = 300)
		AND c.codigocarrera <> 13
		AND c.codigocarrera <> 92
		ORDER BY e.codigocarrera
		";
		//$this->conexion->debug=true;
		//AND '$this->fechahoy' BETWEEN c.fechainiciocarrera AND c.fechavencimientocarrera
		$operacion=$this->conexion->query($query);
		//$this->conexion->debug=false;
		$row_operacion=$operacion->fetchRow();
		do
		{
			if(!empty($row_operacion))
			{
				$array_interno[]=$row_operacion;
			}
		}
		while ($row_operacion=$operacion->fetchRow());
		//echo count($array_interno);
		//exit();
		return $array_interno;
	}

	function estudianteDocumento($idestudiantegeneral)
	{
		$query="SELECT DISTINCT ed.numerodocumento
		FROM
		estudiantedocumento ed
		WHERE
		ed.idestudiantegeneral='".$idestudiantegeneral."'
		";
		//$this->conexion->debug=true;
		//AND '$this->fechahoy' BETWEEN c.fechainiciocarrera AND c.fechavencimientocarrera
		$operacion=$this->conexion->query($query);
		//$this->conexion->debug=false;
		$row_operacion=$operacion->fetchRow();
		do
		{
			if(!empty($row_operacion))
			{
				$array_interno[]=$row_operacion;
			}
		}
		while ($row_operacion=$operacion->fetchRow());
		//echo count($array_interno);
		//exit();
		return $array_interno;
	}

	function encuentraParticipante($numerodocumento){
		echo $query="SELECT * from participante where codigo_unico='".$numerodocumento."'";

		//AND '$this->fechahoy' BETWEEN c.fechainiciocarrera AND c.fechavencimientocarrera
$this->conexionPSQL->debug=true;
		$operacion=$this->conexionPSQL->query($query);
		//$this->conexion->debug=false;
		$row_operacion=$operacion->fetchRow();
		do
		{
			if(!empty($row_operacion))
			{
				$array_interno[]=$row_operacion;
			}
		}
		while ($row_operacion=$operacion->fetchRow());
		//echo count($array_interno);
		//exit();
		return $array_interno;
	}
	function encuentraEstudianteH($numerodocumento){
		$query="SELECT * from estudiante_h where codigo_unico='$numerodocumento'";
		//$this->conexion->debug=true;
		//AND '$this->fechahoy' BETWEEN c.fechainiciocarrera AND c.fechavencimientocarrera
		$operacion=$this->conexionPSQL->query($query);
		//$this->conexion->debug=false;
		$row_operacion=$operacion->fetchRow();
		do
		{
			if(!empty($row_operacion))
			{
				$array_interno[]=$row_operacion;
			}
		}
		while ($row_operacion=$operacion->fetchRow());
		//echo count($array_interno);
		//exit();
		return $array_interno;
	}
	function codigoestudiante_estudiante($codigoperiodo)
	{
		$query="SELECT DISTINCT e.codigoestudiante, e.codigocarrera,e.idestudiantegeneral
		FROM
		estudiante e, ordenpago op, carrera c
		WHERE
		op.codigoperiodo='$codigoperiodo'
		AND op.codigoestudiante=e.codigoestudiante
		AND op.codigoestadoordenpago like '4%'
		AND e.codigocarrera=c.codigocarrera
		AND (c.codigomodalidadacademica = 200 OR c.codigomodalidadacademica = 300)
		AND c.codigocarrera <> 13
		AND c.codigocarrera <> 92
		ORDER BY e.codigocarrera
		";
		//$this->conexion->debug=true;
		$operacion=$this->conexion->query($query);
		//$this->conexion->debug=false;
		$row_operacion=$operacion->fetchRow();
		do
		{
			if(!empty($row_operacion))
			{
				$array_interno[]=$row_operacion;
			}
		}
		while ($row_operacion=$operacion->fetchRow());
		return $array_interno;
	}

	function codigoestudiante_complementario($codigoperiodo)
	{
		$query="SELECT DISTINCT e.codigoestudiante, e.codigocarrera,e.idestudiantegeneral,cu.nombreciudad,ee.idinstitucioneducativa,ie.nombreinstitucioneducativa,ie.codigonaturaleza,rp.numeroregistroresultadopruebaestado
		FROM
		estudiante e, ordenpago op, carrera c,ciudad cu, estudiantegeneral eg

		left join estudianteestudio ee on idniveleducacion=2 and
		ee.idestudiantegeneral=eg.idestudiantegeneral
		and ee.idestudianteestudio=(select max(ee2.idestudianteestudio) from
		estudianteestudio ee2 where ee2.idestudiantegeneral=eg.idestudiantegeneral)

		left join institucioneducativa ie on
		ee.idinstitucioneducativa=ie.idinstitucioneducativa

		left join resultadopruebaestado rp on
		rp.idestudiantegeneral=eg.idestudiantegeneral
		and rp.idresultadopruebaestado=(select max(rp2.idresultadopruebaestado) from
		resultadopruebaestado rp2 where rp2.idestudiantegeneral=eg.idestudiantegeneral)

		WHERE
		op.codigoperiodo='".$codigoperiodo."'
		AND op.codigoestudiante=e.codigoestudiante
		AND op.codigoestadoordenpago like '4%'
		AND e.codigocarrera=c.codigocarrera
		AND (c.codigomodalidadacademica = 200 OR c.codigomodalidadacademica = 300)
		AND c.codigocarrera <> 13
		AND c.codigocarrera <> 92
		AND eg.idestudiantegeneral=e.idestudiantegeneral
		AND cu.idciudad=eg.idciudadnacimiento
		ORDER BY e.codigocarrera


		";
		//$this->conexion->debug=true;
		$operacion=$this->conexion->query($query);
		//$this->conexion->debug=false;
		$row_operacion=$operacion->fetchRow();
		do
		{
			if(!empty($row_operacion))
			{
				$array_interno[]=$row_operacion;
			}
		}
		while ($row_operacion=$operacion->fetchRow());
		return $array_interno;
	}


	function codigomunicipio_complementario($municipio)
	{
		 $query="select * from tmpmunicipiosnies where nombremunicipio like '%".$municipio."%'";
		//$this->conexion->debug=true;
		$operacion=$this->conexion->query($query);
		//$this->conexion->debug=false;
		$row_operacion=$operacion->fetchRow();
		/* do
		{
			if(!empty($row_operacion))
			{
				$array_interno[]=$row_operacion;
			}
		}
		while ($row_operacion=$operacion->fetchRow()); */
		return $row_operacion;
	}


	function estudiante_historico($idestudiantegeneral)
	{
		echo $query="SELECT DISTINCT eh.idestrato
		FROM estratohistorico eh
		where eh.idestudiantegeneral=$idestudiantegeneral
		and  eh.idestratohistorico = (select max(eh2.idestratohistorico)
		from estratohistorico eh2 where
		eh2.idestudiantegeneral=eh.idestudiantegeneral )";
		//$this->conexion->debug=true;
		$operacion=$this->conexion->query($query);
		//$this->conexion->debug=false;
		$array_interno=$operacion->fetchRow();
/* 		do
		{
			if(!empty($row_operacion))
			{
				$array_interno[]=$row_operacion;
			}
		}
		while ($row_operacion=$operacion->fetchRow());
 */		return $array_interno;
	}


	function estudiante($codigoperiodo)
	{
		$query="SELECT DISTINCT
		1729 as 'IES_CODE',
		CONCAT(CASE
		WHEN eg.tipodocumento=01 THEN 'CC'
		WHEN eg.tipodocumento=02 THEN 'TI'
		WHEN eg.tipodocumento=03 THEN 'CE'
		WHEN eg.tipodocumento=04 THEN 'RC'
		WHEN eg.tipodocumento=05 THEN 'PS'
		WHEN eg.tipodocumento=06 THEN 'NT'
		WHEN eg.tipodocumento=07 THEN 'NT'
		WHEN eg.tipodocumento=08 THEN 'NT'
		WHEN eg.tipodocumento=09 THEN 'NT'
		WHEN eg.tipodocumento=10 THEN 'NT'
		END,eg.numerodocumento) AS COD_ESTUDIANTE
		FROM estudiante e,
		estudiantegeneral eg,
		ordenpago op,
		carrera c,
		modalidadacademica m
		WHERE
		op.codigoperiodo='$codigoperiodo'
		AND e.codigocarrera=c.codigocarrera
		AND c.codigomodalidadacademica=m.codigomodalidadacademica
		AND e.idestudiantegeneral=eg.idestudiantegeneral
		AND op.codigoestadoordenpago LIKE'4%'
		AND op.codigoestudiante=e.codigoestudiante
		AND m.codigomodalidadacademica <> 100
		and c.codigocarrera<>13
		ORDER BY e.codigocarrera
		";
		//$this->conexion->debug=true;
		$operacion=$this->conexion->query($query);
		//$this->conexion->debug=false;
		$row_operacion=$operacion->fetchRow();
		do
		{
			$array_interno[]=$row_operacion;
		}
		while ($row_operacion=$operacion->fetchRow());
		return $array_interno;
	}

	function estudiante_graduado($codigoperiodo)
	{
		echo $query="
		SELECT
		eg.numerodocumento as 'CODIGO_UNICO',
		1729 as 'IES_CODE',
		DATE_FORMAT(rg.fechagradoregistrograduado,'%Y') AS 'GRAD_ANNIO',
		(CASE
		WHEN eg.tipodocumento=01 THEN 'CC'
		WHEN eg.tipodocumento=02 THEN 'TI'
		WHEN eg.tipodocumento=03 THEN 'CE'
		WHEN eg.tipodocumento=04 THEN 'RC'
		WHEN eg.tipodocumento=05 THEN 'PS'
		WHEN eg.tipodocumento=06 THEN 'NI'
		WHEN eg.tipodocumento=07 THEN 'NI'
		WHEN eg.tipodocumento=08 THEN 'NI'
		WHEN eg.tipodocumento=09 THEN 'NI'
		WHEN eg.tipodocumento=10 THEN 'NI'
		WHEN eg.tipodocumento=11 THEN 'CC'
		END) AS 'TIPO_DOC_UNICO',
		cr.numeroregistrocarreraregistro as PROG_CODE,
		DATE_FORMAT(rg.fechagradoregistrograduado,'%Y-%m-%d') AS 'FECHA_GRADO',
		rg.numeroactaregistrograduado AS 'ACTA',
		drgf.idregistrograduadofolio AS 'FOLIO',
		e.codigoestudiante
		FROM periodo p,registrograduado rg
		INNER JOIN estudiante e ON rg.codigoestudiante=e.codigoestudiante
		INNER JOIN carrera c ON e.codigocarrera=c.codigocarrera
		INNER JOIN modalidadacademica m ON c.codigomodalidadacademica=m.codigomodalidadacademica
		INNER JOIN carreraregistro cr ON c.codigocarrera=cr.codigocarrera
		INNER JOIN estudiantegeneral eg ON e.idestudiantegeneral=eg.idestudiantegeneral
		LEFT JOIN detalleregistrograduadofolio drgf ON rg.idregistrograduado=drgf.idregistrograduado
		WHERE
		c.codigocarrera not in (13,83)
		and p.codigoperiodo=".$codigoperiodo."
		AND m.codigomodalidadacademica <> 100
		AND rg.fechagradoregistrograduado BETWEEN p.fechainicioperiodo AND p.fechavencimientoperiodo	";
		//echo $query,"<br>";
		//$this->conexion->debug=true;
		$operacion=$this->conexion->query($query);
		//$this->conexion->debug=false;
		$row_operacion=$operacion->fetchRow();
		do
		{
			$array_interno[]=$row_operacion;
		}
		while ($row_operacion=$operacion->fetchRow());
		return $array_interno;
	}


	function estudiante_egresado($codigoperiodo)
	{
		$query="
		SELECT
		1729 as 'IES_CODE',
		CONCAT(CASE
		WHEN eg.tipodocumento=01 THEN 'CC'
		WHEN eg.tipodocumento=02 THEN 'TI'
		WHEN eg.tipodocumento=03 THEN 'CE'
		WHEN eg.tipodocumento=04 THEN 'RC'
		WHEN eg.tipodocumento=05 THEN 'PS'
		WHEN eg.tipodocumento=06 THEN 'NT'
		WHEN eg.tipodocumento=07 THEN 'NT'
		END,eg.numerodocumento) AS COD_ESTUDIANTE,
		(CASE
		WHEN eg.tipodocumento=01 THEN 'CC'
		WHEN eg.tipodocumento=02 THEN 'TI'
		WHEN eg.tipodocumento=03 THEN 'CE'
		WHEN eg.tipodocumento=04 THEN 'RC'
		WHEN eg.tipodocumento=05 THEN 'PS'
		WHEN eg.tipodocumento=06 THEN 'NT'
		WHEN eg.tipodocumento=07 THEN 'NT'
		WHEN eg.tipodocumento=08 THEN 'NT'
		WHEN eg.tipodocumento=09 THEN 'NT'
		WHEN eg.tipodocumento=10 THEN 'NT'
		END) AS TIPO_DOC_UNICO,
		eg.numerodocumento as 'CODIGO_UNICO',
		cr.numeroregistrocarreraregistro as PROG_CODE,
		NULL as NBC_CODE,
		SUBSTRING(op.codigoperiodo,1,4) AS 'INS_ANNIO',
		CONCAT(0,SUBSTRING(op.codigoperiodo,5,5)) AS INS_SEMESTRE,
		0 as CONSECUTIVO
		FROM estudiante e, carrera c, periodo p, estudiantegeneral eg, carreraregistro cr, ordenpago op, modalidadacademica m
		WHERE
		e.codigoestudiante=op.codigoestudiante
		AND op.codigoperiodo='$codigoperiodo'
		AND e.codigocarrera=cr.codigocarrera
		AND e.codigocarrera=c.codigocarrera
		AND e.idestudiantegeneral=eg.idestudiantegeneral
		AND e.codigoperiodo=p.codigoperiodo
		AND e.codigosituacioncarreraestudiante=104
		AND c.codigomodalidadacademica=m.codigomodalidadacademica
		AND m.codigomodalidadacademica <> 100
		AND c.codigocarrera<>13
		ORDER BY e.codigocarrera
		";
		//echo $query,"<br>";
		//$this->conexion->debug=true;
		$operacion=$this->conexion->query($query);
		//$this->conexion->debug=false;
		$row_operacion=$operacion->fetchRow();
		do
		{
			$array_interno[]=$row_operacion;
		}
		while ($row_operacion=$operacion->fetchRow());
		return $array_interno;
	}

	function codigoestudiante_inscrito($codigoperiodo){
		/*echo $query="
		SELECT e.codigoestudiante, e.codigocarrera,e.idestudiantegeneral
		FROM ordenpago o, detalleordenpago d, estudiante e, carrera c, concepto co
		WHERE o.numeroordenpago=d.numeroordenpago
		AND e.codigoestudiante=o.codigoestudiante
		AND c.codigocarrera=e.codigocarrera
		AND d.codigoconcepto=co.codigoconcepto
		AND co.cuentaoperacionprincipal='153'
		AND o.codigoestadoordenpago LIKE '4%'
		AND o.codigoperiodo='$codigoperiodo'
		and e.codigocarrera <> '13'
		AND e.codigosituacioncarreraestudiante <> '106'
		AND (c.codigomodalidadacademica=200 or c.codigomodalidadacademica=300)
		UNION
		SELECT e.codigoestudiante,e.codigocarrera,e.idestudiantegeneral
		FROM
		estudiante e, inscripcion i, estudiantecarrerainscripcion eci,carrera c
		WHERE
		e.idestudiantegeneral = i.idestudiantegeneral
		AND e.codigosituacioncarreraestudiante = '111'
		AND i.idinscripcion=eci.idinscripcion
		AND i.codigoperiodo = '$codigoperiodo'
		AND e.codigocarrera=c.codigocarrera
		and e.codigocarrera <> '13'
		AND (c.codigomodalidadacademica=200 or c.codigomodalidadacademica=300)
		";*/
            echo $query="SELECT e.codigoestudiante, e.codigocarrera,e.idestudiantegeneral FROM estudianteestadistica ee, carrera c, estudiante e
                  where e.codigocarrera=c.codigocarrera
                  and ee.codigoestudiante=e.codigoestudiante
                  and ee.codigoperiodo = '".$codigoperiodo."'
                  and ee.codigoprocesovidaestudiante= 200
                  and c.codigomodalidadacademica in(200,300)
                 and c.codigocarrera not in(13,560,554,92,6,204,417,94,120,355,434,117,561,562,578,581)
                  and ee.codigoestado like '1%'
                  order by 1";

		$operacion=$this->conexion->query($query);
		$row_operacion=$operacion->fetchRow();
		do
		{
			if(!empty($row_operacion))
			{
				$array_interno[]=$row_operacion;
			}
		}
		while ($row_operacion=$operacion->fetchRow());
		return $array_interno;
	}
	function registro_estudiante_inscrito($codigoperiodo,$idestudiantegeneral){
		echo $query="

		SELECT e.codigoestudiante, e.codigocarrera
		FROM ordenpago o, detalleordenpago d, estudiante e, carrera c, concepto co
		WHERE o.numeroordenpago=d.numeroordenpago
		AND e.codigoestudiante=o.codigoestudiante
		AND c.codigocarrera=e.codigocarrera
		AND d.codigoconcepto=co.codigoconcepto
		AND co.cuentaoperacionprincipal='153'
		AND o.codigoestadoordenpago LIKE '4%'
		AND o.codigoperiodo='$codigoperiodo'
		and e.codigocarrera <> '13'
		and e.idestudiantegeneral='".$idestudiantegeneral."'
		AND e.codigosituacioncarreraestudiante <> '106'
		AND (c.codigomodalidadacademica=200 or c.codigomodalidadacademica=300)
		UNION
		SELECT e.codigoestudiante,e.codigocarrera
		FROM
		estudiante e, inscripcion i, estudiantecarrerainscripcion eci,carrera c
		WHERE
		e.idestudiantegeneral = i.idestudiantegeneral
		and e.idestudiantegeneral='".$idestudiantegeneral."'
		AND e.codigosituacioncarreraestudiante = '111'
		AND i.idinscripcion=eci.idinscripcion
		AND i.codigoperiodo = '$codigoperiodo'
		and e.codigocarrera <> '13'
		AND e.codigocarrera=c.codigocarrera
		AND (c.codigomodalidadacademica=200 or c.codigomodalidadacademica=300)
		order by codigoestudiante asc
		";

		$operacion=$this->conexion->query($query);
		$row_operacion=$operacion->fetchRow();
		do
		{
			if(!empty($row_operacion))
			{
				$array_interno[]=$this->registro_snies($this->carreraregistro($row_operacion['codigocarrera']));
			}
		}
		while ($row_operacion=$operacion->fetchRow());
		$array_interno[]=111111;
		$array_interno[]=111111;

		return $array_interno;
	}
	function registro_snies($numerocarreraregistro){
				$query_pro_consecutivo="SELECT pro_consecutivo FROM programa WHERE prog_code='".$numerocarreraregistro."'";
				$operacion_pro_consecutivo=$this->conexionPSQL->query($query_pro_consecutivo);
				if($operacion_pro_consecutivo)
				{
					$row_pro_consecutivo=$operacion_pro_consecutivo->fetchRow();
				}
				echo "	<h1>numerocarreraregistro=".$numerocarreraregistro." PROCONSECUTIVO=".$row_pro_consecutivo['pro_consecutivo']."</h1>";

	if(trim($row_pro_consecutivo['pro_consecutivo'])!=''&&isset($row_pro_consecutivo['pro_consecutivo']))
				{
					$pro_consecutivo=$row_pro_consecutivo['pro_consecutivo'];
				}
				else
				{
					$pro_consecutivo=111111;
				}
		return  $pro_consecutivo;
	}
	function codigoestudiante_admitido($codigoperiodo){
		$query="SELECT distinct e.codigoestudiante, e.codigocarrera
		FROM ordenpago o, detalleordenpago d, estudiante e, carrera c, concepto co, prematricula pr
		WHERE o.numeroordenpago=d.numeroordenpago
		AND pr.codigoperiodo='".$codigoperiodo."'
		AND e.codigoestudiante=pr.codigoestudiante
		AND e.codigoestudiante=o.codigoestudiante
		AND c.codigocarrera=e.codigocarrera
		AND d.codigoconcepto=co.codigoconcepto
		AND co.cuentaoperacionprincipal=151
		AND o.codigoperiodo='".$codigoperiodo."'
		AND o.codigoestadoordenpago LIKE '4%'
		AND e.codigoperiodo='".$codigoperiodo."'
		AND e.codigotipoestudiante <> 11
		AND (c.codigomodalidadacademica=200 or c.codigomodalidadacademica=300) and
e.codigoestudiante not in(
		SELECT nh.codigoestudiante as cant FROM notahistorico nh
						WHERE nh.codigotiponotahistorico='400'
						AND nh.codigoestudiante=e.codigoestudiante
						and nh.codigoperiodo<'".$codigoperiodo."'
		)
		GROUP by e.codigoestudiante";
		$operacion=$this->conexion->query($query);
		$row_operacion=$operacion->fetchRow();
		do
		{
			if(!empty($row_operacion)){
				$array_interno[]=$row_operacion;
			}
		}
		while ($row_operacion=$operacion->fetchRow());
		return $array_interno;
	}

	function carreraregistro($codigocarrera){
		$query="SELECT numeroregistrocarreraregistro FROM carreraregistro cr
		WHERE
		cr.codigocarrera='$codigocarrera'
		";
		$operacion=$this->conexion->query($query);
		$row_operacion=$operacion->fetchRow();
		return $row_operacion['numeroregistrocarreraregistro'];
	}

	function datos_participante($codigoestudiante)
	{
		$query="
		SELECT
		1729 AS IES_CODE,
		SUBSTRING_INDEX(eg.apellidosestudiantegeneral,' ',1) AS 'PRIMER_APELLIDO',
		SUBSTRING_INDEX(eg.apellidosestudiantegeneral,' ',-1) AS 'SEGUNDO_APELLIDO',
		SUBSTRING_INDEX(eg.nombresestudiantegeneral,' ',1) AS 'PRIMER_NOMBRE',
		SUBSTRING_INDEX(eg.nombresestudiantegeneral,' ',-1) AS 'SEGUNDO_NOMBRE',
		DATE_FORMAT(p.fechainicioperiodo,'%Y-%m-%d') AS 'FECHA_INGR',
		DATE_FORMAT(eg.fechanacimientoestudiantegeneral,'%Y-%m-%d') AS 'FECHA_NACIM',
		IF(eg.codigogenero='100','02','01') AS 'GENERO_CODE',
		eg.emailestudiantegeneral AS 'EMAIL',
		'01' AS 'EST_CIVIL_CODE',
		(CASE
		WHEN eg.tipodocumento=01 THEN 'CC'
		WHEN eg.tipodocumento=02 THEN 'TI'
		WHEN eg.tipodocumento=03 THEN 'CE'
		WHEN eg.tipodocumento=04 THEN 'RC'
		WHEN eg.tipodocumento=05 THEN 'PS'
		WHEN eg.tipodocumento=06 THEN 'NI'
		WHEN eg.tipodocumento=07 THEN 'NI'
		WHEN eg.tipodocumento=08 THEN 'NI'
		WHEN eg.tipodocumento=09 THEN 'NI'
		WHEN eg.tipodocumento=10 THEN 'NI'
		WHEN eg.tipodocumento=11 THEN 'NI'
                WHEN eg.tipodocumento=12 THEN 'NI'
		END) AS TIPO_DOC_UNICO,
		eg.numerodocumento as CODIGO_UNICO,
		'' as TIPO_ID_ANT,
		'' as CODIGO_ID_ANT,
		eg.idciudadnacimiento,
		eg.ciudadresidenciaestudiantegeneral,
		eg.telefonoresidenciaestudiantegeneral
		FROM estudiante e, estudiantegeneral eg, periodo p
		WHERE
		e.codigoperiodo=p.codigoperiodo
		AND e.idestudiantegeneral=eg.idestudiantegeneral
		AND e.codigoestudiante='$codigoestudiante'
		";
		//echo $query,"<br>";
		//$this->conexion->debug=true;
		$operacion=$this->conexion->query($query);
		//$this->conexion->debug=false;
		$row_operacion=$operacion->fetchRow();
		return $row_operacion;
	}


	function estudiante_matriculados($codigoperiodo)
	{
		$query="SELECT DISTINCT
		e.codigocarrera,
		eg.numerodocumento as CODIGO_UNICO,
		CASE
		WHEN eg.tipodocumento=01 THEN 'CC'
		WHEN eg.tipodocumento=02 THEN 'TI'
		WHEN eg.tipodocumento=03 THEN 'CE'
		WHEN eg.tipodocumento=04 THEN 'RC'
		WHEN eg.tipodocumento=05 THEN 'PS'
		WHEN eg.tipodocumento=06 THEN 'NT'
		WHEN eg.tipodocumento=07 THEN 'NT'
		END AS TIPO_DOC_UNICO,
		'03' as HORARIO_CODE,
		0 as CONSECUTIVO,
		1729 as CERES,
		dp.codigosapdepartamento as DEPARTAMENTO,
		11001 as MUNICIPIO
		FROM estudiante e, estudiantegeneral eg, ordenpago op, carrera c, modalidadacademica m, carreraregistro cr, ciudad ciu, departamento dp
		WHERE
		e.codigocarrera=cr.codigocarrera
		AND eg.ciudadresidenciaestudiantegeneral=ciu.idciudad
		AND ciu.iddepartamento=dp.iddepartamento
		AND op.codigoperiodo='$codigoperiodo'
		AND e.codigocarrera=c.codigocarrera
		AND c.codigomodalidadacademica=m.codigomodalidadacademica
		AND e.idestudiantegeneral=eg.idestudiantegeneral
		AND op.codigoestadoordenpago LIKE'4%'
		AND op.codigoestudiante=e.codigoestudiante
		AND m.codigomodalidadacademica <> 100
		and c.codigocarrera<>13
		ORDER BY e.codigocarrera
		";
		//echo $query,"<br>";
		//$this->conexion->debug=true;
		$operacion=$this->conexion->query($query);
		//$this->conexion->debug=false;
		$row_operacion=$operacion->fetchRow();
		do
		{
			$array_interno[]=$row_operacion;
		}
		while ($row_operacion=$operacion->fetchRow());
		return $array_interno;
	}
	function cursos(){
		$query="select '1729' iescode,codigomateria cursocode, nombremateria curso_nombre,'557' nbc_code,
				'02' es_extension from materia m,carrera c, carreraregistro cr where codigoestadomateria = '01' and c.codigocarrera=m.codigocarrera and c.codigocarrera=cr.codigocarrera and c.codigomodalidadacademica in (200,300) and m.codigotipomateria in (1,2,3) and
				NOW() between c.fechainiciocarrera and c.fechavencimientocarrera";
		$operacion=$this->conexion->query($query);
		while ($row_operacion=$operacion->fetchRow()){
				$array_interno[]=$row_operacion;
		}
		return $array_interno;
	}

	function planestudiocursos($codigoperiodo){
	$query="
		select distinct '1729' ies_code,m.codigomateria curso_code, nombremateria curso_nombre,'14' nbc_code,'02' es_extension,

		 pe.fechainioplanestudio fecha_vigencia, concat('PLAN ',c.nombrecarrera) url_plan,m.numerocreditos min_num_cred,

		'02' modalidad_code,
				CASE
				WHEN m.codigomodalidadmateria=01 THEN '01'
				WHEN m.codigomodalidadmateria=02 THEN '03'
				WHEN m.codigomodalidadmateria=03 THEN '05'
				ELSE '03'
				END  tipo_curso_code,
		'02' utiliza_cur_virtuales,
		pe.idplanestudio, cr.numeroregistrocarreraregistro, dpe.codigotipomateria
		from planestudio pe, detalleplanestudio dpe, materia m, carrera c, jornadacarrera jc, carreraregistro cr
		where pe.idplanestudio in (
			select
						max(idplanestudio)  idplanestudio
						from planestudio pe
						where codigoestadoplanestudio like '1%'
						and NOW() between fechainioplanestudio and fechavencimientoplanestudio
						and codigocarrera not in (select codigocarrera from tmpplanestudiosnies where codigoperiodo=".$codigoperiodo." and codigoestado like '1%')

						group by codigocarrera
			UNION
						select idplanestudio from tmpplanestudiosnies where codigoperiodo=".$codigoperiodo." and codigoestado like '1%'
						order by idplanestudio

		) and
		dpe.idplanestudio=pe.idplanestudio and
		dpe.codigomateria=m.codigomateria and
		pe.codigocarrera=c.codigocarrera and
		jc.codigocarrera=c.codigocarrera and
		cr.codigocarrera=c.codigocarrera and
		jc.codigojornada='01' and
		m.codigoestadomateria = '01'
		order by c.nombrecarrera,pe.nombreplanestudio
		";
//		m.codigotipomateria in (1,2,3)

		$operacion=$this->conexion->query($query);
		while ($row_operacion=$operacion->fetchRow()){
				$array_interno[]=$row_operacion;
		}
		return $array_interno;

	}

	function detallemateriaplan($codigomateria){
			$query=" select 	CASE
				WHEN m.codigomodalidadmateria=01 THEN '01'
				WHEN m.codigomodalidadmateria=02 THEN '03'
				WHEN m.codigomodalidadmateria=03 THEN '05'
				ELSE '03'
				END  tipo_curso_code
				from materia m where codigomateria=".$codigomateria."";
		$operacion=$this->conexion->query($query);
		/*while ($row_operacion=$operacion->fetchRow()){
				$array_interno[]=$row_operacion;
		}*/
		$row_operacion=$operacion->fetchRow();
		return $row_operacion;

	}
	function recursofinancieroestudiante($idestudiantegeneral){

	$query="select * from estudianterecursofinanciero
			where idestudiantegeneral=$idestudiantegeneral";
			$operacion=$this->conexion->query($query);
	while ($row_operacion=$operacion->fetchRow()){
			$array_interno[]=$row_operacion;
	}
	return $array_interno;


	}
	function pais($idciudad,$retorno)
	{
		$query="SELECT codigosappais,codigosapdepartamento
		FROM
		pais pais, ciudad ciu, departamento depto
		WHERE ciu.idciudad='$idciudad'
		AND ciu.iddepartamento=depto.iddepartamento
		AND depto.idpais=pais.idpais";
		$operacion=$this->conexion->query($query);
		$row_operacion=$operacion->fetchRow();
		switch ($retorno)
		{
			case "pais":
				return $row_operacion['codigosappais'];
				break;
			case "departamento":
				return $row_operacion['codigosapdepartamento']*1;
				break;
		}
	}
	function docentehojavida($conexion,$codigounico){

		 $base= "select *,
	 if(h.lugarhistorialacademico like '%bogot%','CO','') pais,

		CASE
		WHEN d.codigotipodocumento=1 THEN 'CC'
		WHEN d.codigotipodocumento=2 THEN 'CE'
		WHEN d.codigotipodocumento=3 THEN 'NP'
		WHEN d.codigotipodocumento=4 THEN 'PS'
		ELSE 'CC'
		END  tipodocumento,

				CASE
		WHEN h.codigotipogrado=1 THEN '05'
		WHEN h.codigotipogrado=2 THEN '04'
		WHEN h.codigotipogrado=3 THEN '03'
		WHEN h.codigotipogrado=4 THEN '02'
		WHEN h.codigotipogrado=5 THEN '10'
		WHEN h.codigotipogrado=6 THEN '09'
		WHEN h.codigotipogrado=7 THEN '12'
		ELSE '12'
		END  tipogrado

	  from historialacademico h
	  left join docente d on d.numerodocumento=h.numerodocumento
	          where h.numerodocumento = '".$codigounico."'
			  order by h.fechagradohistorialacademico";
       $sol=mysql_db_query($conexion,$base);
	   $totalRows = mysql_num_rows($sol);
	   $row=mysql_fetch_array($sol);
	   if($totalRows>0)
	      return $row;
		else
			return false;


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
		echo count($matriz[0]);
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
	//Hace una consulta de una sola tabla $tabla dependiendo del id de la tabla $nombreidtabla
	//donde se puede a?dir una condicion $condicion y una operacion (max(),min(),sum()...) basica
	function recuperar_datos_tabla($tabla,$nombreidtabla,$idtabla,$condicion="",$operacion="",$imprimir=0)
	{
		$query="select * $operacion from $tabla where $nombreidtabla= '$idtabla' $condicion";
		$operacion=$this->conexion->query($query);
		$row_operacion=$operacion->fetchRow();
		if($imprimir)
		echo $query;
		return $row_operacion;
	}
	//Hace una consulta de una sola tabla $tabla dependiendo del id de la tabla $nombreidtabla
	//donde se puede a?dir una condicion $condicion y una operacion (max(),min(),sum()...) basica
	function recuperar_resultado_tabla($tabla,$nombreidtabla,$idtabla,$condicion="",$operacion="",$imprimir=0)
	{
		$query="select * $operacion from $tabla where $nombreidtabla= '$idtabla' $condicion";
		$operacion=$this->conexion->query($query);
		if($imprimir)
		echo $query;
		return $operacion;
	}

	//Hace una consulta de una sola tabla $tabla dependiendo del id de la tabla $nombreidtabla
	//donde se puede a?dir una condicion $condicion y una operacion (max(),min(),sum()...) basica
	function recuperar_datos_tabla_fila($tabla,$clave,$valor,$condicion="",$operacion="",$imprimir=0)
	{
		$condicion==""?$where="":$where="where";
		$query="select $clave, $valor $operacion from $tabla $where  $condicion";
		$operacion=$this->conexion->query($query);

		$explodeclave=explode(".",$clave); $explodevalor=explode(".",$valor);
		if($explodeclave[1]!="")  $clave=$explodeclave[1];
		if($explodevalor[1]!="")  $valor=$explodevalor[1];


		while($row_operacion=$operacion->fetchRow()){
			$fila[$row_operacion[$clave]]=$row_operacion[$valor];

		}

		if($imprimir)
		echo $query;

		return $fila;
	}

	//Inserta una fila de datos del tipo $fila['clave']=valor en la tabla $tabla donde
	//las claves son los nombres de los campos y los valores son los valores de campo a insertar
	function insertar_fila_bd($conexion,$tabla,$fila)
	{
                /*echo "<hr>";
                print_r($fila);
                echo "<hr>";
                echo "<h1>".$tabla."</h1> <br>";*/
		$claves="(";
		$valores="(";
		$i=0;
		foreach ( $fila as $clave=>$val) {

			if($i>0){
				$claves .= ",".$clave."";
				$valores .= ",'".$val."'";
			}
			else{
				$claves .= "".$clave."";
				$valores .= "'".$val."'";
			}
			$i++;
		}
		$claves .= ")";
		$valores .= ")";

		echo $sql="insert into $tabla $claves values $valores";
		$conexion->debug=true;
		$operacion=$conexion->query($sql);
		if($operacion){
			$this->contador_inserta++;
		}
		else{
			$this->contador_falla++;
		}
		//$conexion->debug=false;

	}

	//Actualiza de una fila de datos del tipo $fila['clave']=valor en la tabla $tabla donde
	//las claves son los nombres de los campos y los valores son los valores de campo a actualizar
	//dependiendo del id de la tabla ingresado $idtabla
	function actualizar_fila_bd($conexion,$tabla,$fila,$nombreidtabla,$idtabla,$condicion){
		
                echo "<hr>";
                print_r($fila);
                echo "<hr>";
                $val2="";
                $condiciones="";
		while (list ($clave, $val) = each ($fila)) {
                    if($val=='NULL')
                        $val2=$val;
                    else
                        $val2="'".$val."'";
                                
                    $condiciones.= $clave."=".$val2.",";

		}
                $condiciones=rtrim($condiciones,",");
		echo $sql="update $tabla set $condiciones where $nombreidtabla='$idtabla' ".$condicion;
		//$conexion->debug=true;
		$operacion=$conexion->query($sql);
		//$conexion->debug=false;
		$this->contador_actualiza++;
	}

	//Ingresa o actualiza un registro dependiendo de si se encuentran registros con el mismo id
	//o la misma condicion.
	function ingresar_actualizar_fila_bd($conexion,$tabla,$fila,$nombreidtabla,$idtabla,$condicion="")
	{
		$sql="select $idtabla from $tabla where $nombreidtabla='$idtabla' $condicion";
		$operacion=$conexion->query($sql);
		$numrows=$operacion->numRows();
		if($numrows>0)
		$this->actualizar_fila_bd($conexion,$tabla,$fila,$nombreidtabla,$idtabla,$condicion);
		else
		$this->insertar_fila_bd($conexion,$tabla,$fila);
	}
	//Ingresa o anula un registro dependiendo de si se encuentran registros con el mismo id
	//o la misma condicion.
	function ingresar_vencer_fila_bd($conexion,$tabla,$fila,$nombreidtabla,$idtabla,$condicion="")
	{
		$sql="select * from $tabla where $nombreidtabla=$idtabla $condicion";
		$operacion=$this->conexion->query($sql);
		$numrows=$operacion->numRows();
		if($numrows>0)
		insertar_fila_bd($tabla,$fila);
		else
		actualizar_fila_bd($tabla,$fila,$nombreidtabla,$idtabla,$condicion);
	}
}
?>