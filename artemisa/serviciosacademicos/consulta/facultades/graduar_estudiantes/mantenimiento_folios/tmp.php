<?php
class foliacion_automatica extends FPDF
{
	var $conexion;
	var $accion;
	var $array_idregistrograduado;
	var $array_obtener_listado_estudiantes_graduados;
	var $directivo_secgeneral;
	var $ano;
	var $ultimo_registrograduadofolio;
	var $nuevo_registrograduaadofolio;
	var $array_registrograduadofolio;
	var $array_detalleregistrograduadofolio;
	var $array_registros_novalidos;
	var $usuario;
	var $validacion_folio;
	var $numero_folio_reimpresion;
	var $bucle;

	function foliacion_automatica($conexion,$accion='previsualizar')
	{
		//error_reporting(2047);
		$this->conexion=$conexion;
		$this->accion=$accion;
		$this->validacion_folio=true;
		$this->ano=date("Y");
		$this->ano;
		$this->obtener_numeros_registrograduadofolio();
		$this->obtener_directivo_secgeneral();
		if($this->accion=='previsualizar')
		{
			$this->previsualizar();
		}
		elseif ($this->accion=='generar')
		{
			$this->generar();
		}
		elseif ($this->accion=='reimpresion')
		{
			$this->reimpresion();
		}
	}

	function obtener_numeros_registrograduadofolio()
	{

		$query="SELECT MAX(idregistrograduadofolio) AS idregistrograduadofolio
		FROM
		registrograduadofolio rgf
		ORDER BY idregistrograduadofolio DESC
		";
		$operacion=$this->conexion->query($query);
		$row_operacion=$operacion->fetchRow();
		$ultimo=$row_operacion['idregistrograduadofolio'];
		$this->ultimo_registrograduadofolio=intval($ultimo);
		$nuevo=$ultimo+1;

		$this->nuevo_registrograduaadofolio=$nuevo;
	}
	function obtener_idregistrograduados_sinfoliar()
	{
		$query="SELECT rg.idregistrograduado
		FROM
		registrograduado rg
		WHERE
		rg.idregistrograduado NOT IN
		(SELECT rg.idregistrograduado
		FROM
		registrograduadofolio rgf,
		detalleregistrograduadofolio drgf,
		registrograduado rg
		WHERE
		drgf.idregistrograduadofolio=rgf.idregistrograduadofolio
		AND drgf.idregistrograduado=rg.idregistrograduado 
		)
		ORDER BY rg.idregistrograduado
		";
		$operacion=$this->conexion->query($query);
		$row_operacion=$operacion->fetchRow();
		do
		{
			if($row_operacion['idregistrograduado']!="")
			{
				$array_interno[]=$row_operacion;
			}
		}
		while ($row_operacion=$operacion->fetchRow());
		$this->array_idregistrograduado=$array_interno;
		if(!is_array($this->array_idregistrograduado))
		{
			//error_reporting(0);
			echo "<script language='javascript'>alert('No hay registros nuevos para foliar')</script>";
			$this->regresar();
		}
	}
	/**
	 * Para la reimpresion
	 *
	 */
	function obtener_idregistrograduados_foliados($foliodesde,$foliohasta)
	{
		$query="SELECT drgf.idregistrograduado,rgf.idregistrograduadofolio
		FROM
		registrograduadofolio rgf, detalleregistrograduadofolio drgf
		WHERE
		rgf.idregistrograduadofolio=drgf.idregistrograduadofolio
		AND rgf.idregistrograduadofolio>='$foliodesde'
		AND rgf.idregistrograduadofolio<='$foliohasta'
		ORDER BY drgf.idregistrograduado
		";
		$operacion=$this->conexion->query($query);
		$row_operacion=$operacion->fetchRow();
		do
		{
			if($row_operacion['idregistrograduado']!="")
			{
				$array_interno[]=$row_operacion;
			}
		}
		while ($row_operacion=$operacion->fetchRow());
		$this->array_idregistrograduado=$array_interno;
		$this->numero_folio_reimpresion=$this->array_idregistrograduado[0]['idregistrograduadofolio'];
		//echo $query;
		//$this->tabla($this->array_idregistrograduado);
		if(!is_array($this->array_idregistrograduado))
		{
			//error_reporting(0);
			echo "<script language='javascript'>alert('No hay registros para mostrar')</script>";
			$this->regresar();
		}
	}

	function obtener_listado_estudiantes_graduados()
	{
		foreach ($this->array_idregistrograduado as $llave => $valor)
		{
			$query_obtener_listado_estudiantes_graduados="SELECT
			e.codigoestudiante,
			e.codigocarrera,
			rg.idregistrograduado,
			rg.codigoestado,
			concat(eg.apellidosestudiantegeneral,' ', eg.nombresestudiantegeneral) AS 'nombre',
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
			rg.fechagradoregistrograduado as 'fechagrado',
			rg.codigoestado,
			rg.codigoautorizacionregistrograduado
			FROM registrograduado rg, estudiantegeneral eg, estudiante e, carrera c, titulo t
			WHERE 
			rg.codigoestudiante=e.codigoestudiante 
			AND e.idestudiantegeneral=eg.idestudiantegeneral 
			AND e.codigocarrera=c.codigocarrera
			AND c.codigotitulo=t.codigotitulo
			AND rg.idregistrograduado='".$valor['idregistrograduado']."'
			ORDER BY rg.idregistrograduado
			";
			//echo $query_obtener_listado_estudiantes_graduados;
			$obtener_listado_estudiantes_graduados=$this->conexion->query($query_obtener_listado_estudiantes_graduados);
			$row_obtener_listado_estudiantes_graduados=$obtener_listado_estudiantes_graduados->fetchRow();
			do
			{
				if($row_obtener_listado_estudiantes_graduados['codigoestado']==100 and $row_obtener_listado_estudiantes_graduados['codigoautorizacionregistrograduado']==200)
				{

					$this->validacion_folio=false;
					$this->array_registros_novalidos[]=array('idregistrograduado'=>$row_obtener_listado_estudiantes_graduados['idregistrograduado'],'nombre'=>$row_obtener_listado_estudiantes_graduados['nombre'],'documento'=>$row_obtener_listado_estudiantes_graduados['documento'],'codigoestado'=>$row_obtener_listado_estudiantes_graduados['codigoestado'],'codigoautorizacionregistrograduado'=>$row_obtener_listado_estudiantes_graduados['codigoautorizacionregistrograduado']);
				}
				$array_obtener_listado_estudiantes_graduados[]=$row_obtener_listado_estudiantes_graduados;
			}
			while($row_obtener_listado_estudiantes_graduados=$obtener_listado_estudiantes_graduados->fetchRow());
		}
		$this->array_obtener_listado_estudiantes_graduados=$array_obtener_listado_estudiantes_graduados;
		//$this->tabla($this->array_obtener_listado_estudiantes_graduados);
	}
	function obtener_directivo_secgeneral()
	{
		$query_obtener_directivo_secgeneral="select concat(d.nombresdirectivo,' ',d.apellidosdirectivo) as nombre, d.cargodirectivo from directivo d where d.iddirectivo=8";
		$obtener_directivo_secgeneral=$this->conexion->query($query_obtener_directivo_secgeneral);
		$row_obtener_directivo_secgeneral=$obtener_directivo_secgeneral->fetchRow();
		$this->directivo_secgeneral=$row_obtener_directivo_secgeneral;
		//print_r($this->directivo_secgeneral);
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
		return $row_registro_grado;
	}
	function obtener_incentivos_academicos_2($codigocarrera,$numeropromocion,$numeroacta,$numeroacuerdo)
	{
		$query_obtener_incentivos_academicos_estudiante="SELECT DISTINCT
		rg.codigoestudiante,ia.nombreincentivoacademico,
		concat(eg.apellidosestudiantegeneral,' ', eg.nombresestudiantegeneral) AS nombre,
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
		concat(eg.apellidosestudiantegeneral,' ', eg.nombresestudiantegeneral) AS nombre,
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
	function cabecera_carrera($ano,$array_directivo)
	{
		$this->ano=$ano;

	}
	/**
	 * Aquí se arma también el array para foliar, el Header es implícito en la clase fpdf
	 *
	 */
	function Header()
	{
		$this->array_registrograduadofolio[]=array('idregistrograduadofolio'=>$this->contador_paginas,'fecharegistrograduadofolio'=>date("Y-m-d H:i:s"),'idusuario'=>$this->usuario,'codigoestado'=>100);
		if($this->accion=='previsualizar')
		{
			$this->Image('pre.jpg',65,130,100,20);
			//$this->Image('funciones/previsualizacion.jpg',100,50,100,20);
		}
		elseif ($this->accion=='reimpresion')
		{
			$this->Image('cop.jpg',75,130,70,20);
		}
		$nombrecarrera=strtoupper($this->row_carrera['nombrecarrera']);
		$this->SetFont('Arial','B',10);
		$this->Cell(7);
		$this->Cell(190,5,'FOLIO No. '.$this->contador_paginas,0,1,'R');
		$this->Cell(7);
		$this->Ln(6);
		$this->Cell(7);
		$this->Cell(190,6,"REGISTRO DE TITULOS AÑO ".$this->ano,0,0,'C');
		$this->Ln(8);
		$this->Cell(7);
		$this->SetFont('Arial','B',8);
		$this->Cell(15,10,'REG. No',1,0,'C');
		$this->Cell(90,10,'NOMBRE DEL GRADUADO',1,0,'C');
		$this->Cell(65,5,'DOCUMENTO DE IDENTIDAD',1,1,'C');
		$this->Cell(112);
		$this->Cell(20,5,'NUMERO',1,0,'C');
		$this->Cell(45,5,'LUGAR DE EXPEDICION',1,0,'C');
		$this->SetXY(187, 26);
		$this->Cell(20,10,'No. DIPLOMA',1,1,'C');
		$this->Ln(4);
	}
	function Footer()
	{
		$this->SetY(255);
		$this->SetFont('Arial','B',8);
		$nombre=strtoupper($this->directivo_secgeneral['nombre']);
		$cargodirectivo=strtoupper($this->directivo_secgeneral['cargodirectivo']);
		$this->Cell(7);
		$this->Cell(190,5,$nombre,0,1,'R');
		$this->Cell(7);
		$this->Cell(190,5,$cargodirectivo,0,0,'R');
	}
	function pdf_virtual()
	{
		if($this->accion=='reimpresion')
		{
			$this->FPDF('P','mm','Letter',$this->numero_folio_reimpresion);
		}
		else
		{
			$this->FPDF('P','mm','Letter',$this->nuevo_registrograduaadofolio);
		}

		$this->SetTopMargin(7);
		$this->SetAutoPageBreak(true,25);
		//$this->SetFont('Arial','B',8);
		$this->cabecera_carrera($this->ano,$this->directivo_secgeneral);
		$this->AddPage();
		$this->SetFont('Arial','',8);
		$contador_armado_arreglo=0;
		$codigocarrera_ini="";
		$numeropromocion_ini="";
		$numeroacta_ini="";
		$numeroacuerdo_ini="";
		$fechagrado_ini="";
		$contador=-1;
		$contador_limite=count($this->array_obtener_listado_estudiantes_graduados);
		$contador_busca_incentivos=0;
		$array_acumulativo=0;
		//echo $contador_limite;
		foreach ($this->array_obtener_listado_estudiantes_graduados as $clave => $valor)
		{
			if(
			$valor['codigocarrera']!=$codigocarrera_ini or
			$valor['numeropromocion']!=$numeropromocion_ini or
			$valor['numeroacta']!=$numeroacta_ini or
			$valor['numeroacuerdo']!=$numeroacuerdo_ini
			)
			{
				$array_contador_cambios[$contador]=$contador;
				$codigocarrera_ini=$valor['codigocarrera'];
				$numeropromocion_ini=$valor['numeropromocion'];
				$numeroacta_ini=$valor['numeroacta'];
				$numeroacuerdo_ini=$valor['numeroacuerdo'];
				//echo "CONTADOR:",$contador,"   ",$array_contador_cambios[$contador],"  ",$valor['idregistrograduado'],"<br><br>";
			}
			$array_contador[]=$contador;
			$contador++;

		}
		reset($this->array_obtener_listado_estudiantes_graduados);

		foreach ($this->array_obtener_listado_estudiantes_graduados as $clave => $valor)
		{
			if(
			$valor['codigocarrera']!=$codigocarrera_ini or
			$valor['numeropromocion']!=$numeropromocion_ini or
			$valor['numeroacta']!=$numeroacta_ini or
			$valor['numeroacuerdo']!=$numeroacuerdo_ini)
			{

				$buscarincentivos=true;
				$promocion=strtoupper($valor['numeropromocion']);
				$row_carreras_grados=$this->obtener_datos_carreras_grados($valor['codigocarrera']);
				$titulo=strtoupper($row_carreras_grados['nombretitulo']);
				$carrera=strtoupper($row_carreras_grados['nombrecarrera']);
				$this->Cell(7);
				$this->SetFont('Arial','B',10);
				$this->Cell(190,7,"PROGRAMA: ".$carrera,1,1,'C');
				$this->SetFont('Arial','',8);
				$this->Cell(7);
				$this->Cell(190,7,"TITULO: ".$titulo,1,1,'L');
				$this->Cell(7);
				$this->Cell(45,7,"PROMOCION:".$promocion,1,0,'L');
				$this->Cell(50,7,"ACTA: ".$valor['numeroacta']."   FECHA: ".$valor['fechaacta'],1,0,'L');
				$this->Cell(55,7,"ACUERDO: ".$valor['numeroacuerdo']."  FECHA: ".$valor['fechaacuerdo'],1,0,'L');
				$this->Cell(40,7,"FECHA GRADO: ".$valor['fechagrado'],1,1,'L');
				$row_incentivoacademico_2=$this->obtener_incentivos_academicos_2($valor['codigocarrera'],$valor['numeropromocion'],$valor['numeroacta'],$valor['numeroacuerdo']);
				$row_incentivoacademico_3=$this->obtener_incentivos_academicos_3($valor['codigocarrera'],$valor['numeropromocion'],$valor['numeroacta'],$valor['numeroacuerdo']);
				//print_r($row_incentivoacademico_1);echo "<br><br>";print_r($row_incentivoacademico_2);
			}
			else
			{
				$buscarincentivos=false;
			}
			$this->Cell(7);
			$expedicion=substr(strtoupper($valor['expedicion']),0,42);

			if($valor['codigoestado']==200)
			{
				$this->Cell(15,7,$valor['idregistrograduado'],1,0,'C');
				$this->Cell(90,7,"ANULADO",1,0,'L');
				$this->Cell(20,7,"ANULADO",1,0,'C');
				$this->Cell(45,7,"ANULADO",1,0,'C');
				$this->Cell(20,7,"ANULADO",1,1,'C');
			}
			else
			{
				$this->Cell(15,7,$valor['idregistrograduado'],1,0,'C');
				$this->Cell(90,7,$valor['nombre'],1,0,'L');
				$this->Cell(20,7,$valor['documento'],1,0,'C');
				$this->Cell(45,7,$expedicion,1,0,'C');
				$this->Cell(20,7,$valor['diploma'],1,1,'C');
			}
			if($array_contador_cambios[$contador_busca_incentivos]!="")//$array_contador_cambios[$contador_busca_incentivos]!=""
			{
				$row2=count($row_incentivoacademico_2);
				$row3=count($row_incentivoacademico_3);
				if($row2!=0 or $row3!=0)
				{
					$this->Ln(4);
					$this->SetFont('Arial','B',10);
					//$this->Ln(4);
					$this->Cell(7);
					$this->Cell(95,6,"Mención de Honor:",0,0,'C');
					$this->Cell(95,6,"Grado de Honor:",0,1,'C');
					$this->SetFont('Arial','',8);
					$y_ini=$this->GetY();
					/******************imprime incentivos*************************/
					if(is_array($row_incentivoacademico_2))
					{
						foreach ($row_incentivoacademico_2 as $llave => $valorllave)
						{
							$this->Cell(7);
							$this->Cell(95,6,$valorllave['nombre'],0,1,'C');
						}
					}
					else
					{
						$this->Ln(6);
					}
					$y_fin=$this->GetY();
					$this->setY($y_ini);
					if(is_array($row_incentivoacademico_3))
					{
						foreach ($row_incentivoacademico_3 as $llave => $valorllave)
						{
							$this->Cell(102);
							$this->Cell(95,6,$valorllave['nombre'],0,1,'C');
						}
					}
					$this->setY($y_fin);

					/******************imprime incentivos*************************/
				}

			}
			//unset ($row_incentivoacademico_rango);
			$codigocarrera_ini=$valor['codigocarrera'];
			$numeropromocion_ini=$valor['numeropromocion'];
			$numeroacta_ini=$valor['numeroacta'];
			$numeroacuerdo_ini=$valor['numeroacuerdo'];
			$this->array_detalleregistrograduadofolio[$contador_armado_arreglo]['idregistrograduadofolio']=$this->contador_paginas;
			$this->array_detalleregistrograduadofolio[$contador_armado_arreglo]['idregistrograduado']=$valor['idregistrograduado'];
			$this->array_detalleregistrograduadofolio[$contador_armado_arreglo]['codigoestado']=100;
			$this->array_detalleregistrograduadofolio[$contador_armado_arreglo]['codigotipodetalleregistrograduadofolio']=100;
			$contador_armado_arreglo++;
			$contador_busca_incentivos++;
		}
		$this->SetFont('Arial','B',10);
		$this->ln(3);
		$y=$this->GetY();
		if($y<=245)
		{
			do
			{
				$pos_y=$this->GetY();
				$this->Cell(7);
				$this->Cell(190,3,' * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *','C',1);
			}
			while($pos_y <= 245);
			$this->Cell(7);
			$this->Cell(190,3,' * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *','C',1);
		}
		//$this->tabla($this->array_idregistrograduado);
		//$this->tabla($this->array_registrograduadofolio);
		//$this->tabla($this->array_detalleregistrograduadofolio);
		//$this->tabla($this->array_registros_novalidos);
	}
	function obtener_idusuario($usuario)
	{
		$query="SELECT u.idusuario FROM usuario u WHERE usuario='$usuario'";
		$operacion=$this->conexion->query($query);
		$row_operacion=$operacion->fetchRow();
		$this->usuario=$row_operacion['idusuario'];
	}

	function validar()
	{
		$this->obtener_idregistrograduados_sinfoliar();
		$this->obtener_listado_estudiantes_graduados();
		if(is_array($this->array_registros_novalidos))
		{
			$mensaje_inicial='No se pueden generar los folios, los siguientes registros no han sido autorizados:\n';
			foreach ($this->array_registros_novalidos as $llave => $valor)
			{
				$cadena=$cadena.'\nRegistro no: '.$valor['idregistrograduado'].' estudiante: '.$valor['nombre'];
			}
			echo "<script language=javascript>alert('$mensaje_inicial$cadena')</script>";
		}
		else
		{
			return true;
		}
	}

	function previsualizar()
	{
		$this->obtener_idregistrograduados_sinfoliar();
		$this->obtener_listado_estudiantes_graduados();
		$this->pdf_virtual();
		$this->Output();
	}

	function reimpresion()
	{
		$this->obtener_idregistrograduados_foliados($_GET['foliodesde'],$_GET['foliohasta']);
		$this->obtener_listado_estudiantes_graduados();
		$this->pdf_virtual();
		$this->Output();
	}

	function generar()
	{
		$this->obtener_idusuario($_SESSION['MM_Username']);
		$this->obtener_idregistrograduados_sinfoliar();
		$this->obtener_listado_estudiantes_graduados();
		$this->pdf_virtual();
		//error_reporting(0);
		foreach ($this->array_registrograduadofolio as $llave => $valor)
		{
			$query_tabla_padre="INSERT INTO `registrograduadofolio` (idregistrograduadofolio, fecharegistrograduadofolio, idusuario, codigoestado) VALUES ('".$valor['idregistrograduadofolio']."', '".$valor['fecharegistrograduadofolio']."', '".$valor['idusuario']."','100')";
			$operacion_tabla_padre=$this->conexion->query($query_tabla_padre);
		}
		foreach ($this->array_detalleregistrograduadofolio as $llave => $valor)
		{
			$query_tabla_hijo="INSERT INTO `detalleregistrograduadofolio` (iddetalleregistrograduadofolio, idregistrograduadofolio, idregistrograduado, codigoestado, codigotipodetalleregistrograduadofolio) VALUES ('', '".$valor['idregistrograduadofolio']."', '".$valor['idregistrograduado']."', '100', '100')";
			$operacion_tabla_hijo=$this->conexion->query($query_tabla_hijo);
		}
		if($this->conexion->_errorMsg!="")
		{
			echo "<script language=javascript>alert('Error en la insercción de datos')</script>";
		}
		else
		{
			$this->Output();
		}

	}

	function abrir_ventana($pagina,$ventana="ventana",$ancho=640,$alto=480,$posarr=50,$posizq=50)
	{
		$parametros="'width=$ancho,height=$alto,top=$posarr,left=$posizq,scrollbars=yes'";
		echo "<script language='javascript'>window.open('$pagina','$ventana',$parametros)</script>";
	}

	function regresar()
	{
		$urlregresar=$_GET['link_origen'];
		echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=$urlregresar'>";
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

	function barra_ini()
	{
		echo "<div id='progress' style='position:relative;padding:0px;width:768px;height:60px;left:25px;'>";
	}

	function renderizar()
	{
		echo "<div style='float:left;margin:10px 0px 0px 1px;width:5px;height:12px;background:white;color:white;'></div>";
		flush();
		ob_flush();
	}

	function gif()
	{
		echo '<img src="funciones/barra.gif" width="8" height="28">';
	}

	function barra_fin()
	{
		echo "</div>";
	}

}
?>