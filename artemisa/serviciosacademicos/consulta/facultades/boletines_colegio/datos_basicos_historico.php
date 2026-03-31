<?php
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
error_reporting(0);
class estudiante
{
	var $debug=false;

	function depurar()
	{
		$this->debug=true;
	}

	function obtener_datos_basicos_estudiante($codigoestudiante,$codigoperiodo,$numerocorte,$conexion)
	{
		$this->conexion=$conexion;
		$this->codigoestudiante=$codigoestudiante;
		$this->numerocorte=$numerocorte;
		$this->codigoperiodo=$codigoperiodo;
		$query_datos_basicos_estudiante = "SELECT estudiante.codigocarrera,estudiante.semestre, estudiante.codigoperiodo, estudiante.idestudiantegeneral, estudiante.codigoestudiante, estudiantegeneral.numerodocumento, carrera.nombrecarrera, concat(estudiantegeneral.nombresestudiantegeneral, ' ',estudiantegeneral.apellidosestudiantegeneral) as nombre
		FROM ((estudiante LEFT JOIN estudiantegeneral ON estudiantegeneral.idestudiantegeneral=estudiante.idestudiantegeneral) LEFT JOIN carrera ON carrera.codigocarrera=estudiante.codigocarrera)
		WHERE estudiante.codigoestudiante='".$codigoestudiante."'
		";
		//echo $query_datos_basicos_estudiante,"<br>";
		$datos_basicos_estudiante=$conexion->query($query_datos_basicos_estudiante);
		$row_datos_basicos_estudiante=$datos_basicos_estudiante->fetchRow();
		$this->row_datos_basicos_estudiante=$row_datos_basicos_estudiante;
		//print_r($row_datos_basicos_estudiante);
		return $row_datos_basicos_estudiante;
	}
	function obtener_semestre_estudiante()
	{
		$query_obtener_semestre_estudiante="select pr.semestreprematricula
		FROM
		prematricula pr, estudiante e
		WHERE
		e.codigoestudiante=pr.codigoestudiante
		AND e.codigoestudiante='".$this->codigoestudiante."'
		AND pr.codigoperiodo = '".$this->codigoperiodo."'
		";
		//echo $query_obtener_semestre_estudiante;
		$obtener_semestre_estudiante=$this->conexion->query($query_obtener_semestre_estudiante);
		$row_obtener_semestre_estudiante=$obtener_semestre_estudiante->fetchRow();
		$semestreprematricula=$row_obtener_semestre_estudiante['semestreprematricula'];
		$this->semestreprematricula=$semestreprematricula;
		return $semestreprematricula;
	}

	function obtener_curso_estudiante()
	{
		$query_obtener_curso_estudiante="SELECT g.nombregrado
		FROM
		estudiante e,estudiantecolegiogrado ecg,grado g
		WHERE
		ecg.codigoestudiante=e.codigoestudiante
		AND g.idgrado=ecg.idgrado
		AND ecg.codigoestado='100'
		AND e.codigoestudiante='".$this->codigoestudiante."'
		AND ecg.codigoperiodo='".$this->codigoperiodo."'
		";
		//echo $query_obtener_curso_estudiante;
		$obtener_curso_estudiante=$this->conexion->query($query_obtener_curso_estudiante);
		$row_obtener_curso_estudiante=$obtener_curso_estudiante->fetchRow();
		$curso_estudiante=$row_obtener_curso_estudiante['nombregrado'];
		$this->curso_estudiante=$curso_estudiante;
		return $curso_estudiante;
	}
	function obtener_materias_estudiante()
	{
		/**
		 * m.codigomateriaelectiva,
		 * m.nombremateria,
		m.codigomateria,
		d.codigomateriaelectiva,
		m.numerocreditos,
		g.idgrupo,
		p.codigoestudiante,
		la.nombrelineaacademica,
		 */
		
		/* SELECT 
		m.*,p.*,d.*,g.*,la.*
		FROM prematricula p,detalleprematricula d,materia m,grupo g,lineaacademica la
		WHERE  p.codigoestudiante = '".$this->codigoestudiante."'
		AND p.idprematricula = d.idprematricula
		AND d.codigomateria = m.codigomateria
		AND d.idgrupo = g.idgrupo
		AND m.codigoestadomateria = '01'
		AND g.codigoperiodo = '".$this->codigoperiodo."'
		AND p.codigoestadoprematricula LIKE '4%'
		AND d.codigoestadodetalleprematricula LIKE '3%'
		AND m.codigolineaacademica=la.codigolineaacademica
		AND p.codigoperiodo='".$this->codigoperiodo."'
		"; */
		
		$query_obtener_materias_estudiante="SELECT 
		*
		FROM notahistorico n,materia m,lineaacademica la
		WHERE  n.codigoestudiante = '".$this->codigoestudiante."'		
		AND n.codigomateria = m.codigomateria		
		AND m.codigoestadomateria = '01'		
		AND n.codigoestadonotahistorico LIKE '1%'		
		AND m.codigolineaacademica=la.codigolineaacademica
		AND n.codigoperiodo='".$this->codigoperiodo."'";
		$obtener_materias_estudiante=$this->conexion->query($query_obtener_materias_estudiante);
		//echo $query_obtener_materias_estudiante;
		$row_obtener_materias_estudiante=$obtener_materias_estudiante->fetchRow();
		do
		{
			$array_obtener_materias_estudiante[]=$row_obtener_materias_estudiante;
		}
		while($row_obtener_materias_estudiante=$obtener_materias_estudiante->fetchRow());
		$this->array_obtener_materias_estudiante=$array_obtener_materias_estudiante;
		//print_r($array_obtener_materias_estudiante);
		if($this->debug==true)
		{
			echo $query_obtener_materias_estudiante;
			echo "<br>";
			$this->tabla($array_obtener_materias_estudiante);
		}
		return $array_obtener_materias_estudiante;
	}
	function obtener_areas_materias()
	{
		foreach ($this->array_obtener_materias_estudiante as $clave => $valor)
		{
			//echo $valor[codigomateriaelectiva];
			if($valor['codigomateriaelectiva']!=1)
			{
				$query_obtener_areas_materias="select distinct m.codigomateria,m.nombremateria,aac.codigoareaacademica,aac.nombreareaacademica from
				areaacademica aac, planestudioestudiante pee,planestudio pe, detalleplanestudio dpe, materia m
				where
				pee.codigoestudiante='".$this->codigoestudiante."'
				and pee.idplanestudio=pe.idplanestudio
				and pe.idplanestudio=dpe.idplanestudio
				and dpe.codigomateria='".$valor['codigomateriaelectiva']."'
				and dpe.codigoareaacademica=aac.codigoareaacademica
				and dpe.codigomateria=m.codigomateria
				";
				//echo "<h1>codigomateriaelectiva</h1>";
			}
			else
			{
				$query_obtener_areas_materias="select distinct m.codigomateria,m.nombremateria,aac.codigoareaacademica,aac.nombreareaacademica from
				areaacademica aac, planestudioestudiante pee,planestudio pe, detalleplanestudio dpe, materia m
				where
				pee.codigoestudiante='".$this->codigoestudiante."'
				and pee.idplanestudio=pe.idplanestudio
				and pe.idplanestudio=dpe.idplanestudio
				and dpe.codigomateria='".$valor['codigomateria']."'
				and dpe.codigoareaacademica=aac.codigoareaacademica
				and dpe.codigomateria=m.codigomateria
				";
				//echo "<h1>materaio</h1>";
			}
			$obtener_areas_materias=$this->conexion->query($query_obtener_areas_materias);
			$row_obtener_areas_materias=$obtener_areas_materias->fetchRow();
			$array_obtener_areas_materias[]=$row_obtener_areas_materias;
			//echo $query_obtener_areas_materias,"<br><br>";
		}
		$this->array_obtener_areas_materias=$array_obtener_areas_materias;
		return $array_obtener_areas_materias;
	}

	function obtener_datos_corte() // no necesitooooooooooooooooooooooooooooooooooooooooooo
	{
		foreach ($this->array_obtener_materias_estudiante as $clave => $valor)
		{
			$query_obtener_datos_corte ="SELECT c.numerocorte
			FROM corte c
			WHERE c.codigomateria = '".$valor['codigomateria']."'
			AND c.codigoperiodo = '".$this->codigoperiodo."'
			and c.usuario = '".$this->row_datos_basicos_estudiante['codigocarrera']."'";
			//echo $query_obtener_datos_corte,"<br>";
			$obtener_datos_corte=$this->conexion->query($query_obtener_datos_corte);
			$row_obtener_datos_corte=$obtener_datos_corte->fetchRow();
			$totalRows_obtener_datos_corte = $obtener_datos_corte->numRows();
			$array_obtener_datos_corte[]=$row_obtener_datos_corte;
			$i= 1;
			$contadorcortes = 0;
			if ($totalRows_obtener_datos_corte <> 0)
			{
				do
				{
					//$cortes[$i]=$row_fecha;
					//$i+=1;
					$contadorcortes +=1;
				}
				while ($row_obtener_datos_corte=$obtener_datos_corte->fetchRow());
			}
			elseif($totalRows_obtener_datos_corte==0)
			{
				$query_obtener_datos_corte = "SELECT * FROM corte WHERE codigocarrera = '".$this->row_datos_basicos_estudiante['codigocarrera']."' and codigoperiodo = '".$this->codigoperiodo."' order by numerocorte";
				//echo $query_obtener_datos_corte ,"<br>";
				$obtener_datos_corte=$this->conexion->query($query_obtener_datos_corte);
				$row_obtener_datos_corte=$obtener_datos_corte->fetchRow();
				//print_r($row_obtener_datos_corte);
				$totalRows_obtener_datos_corte=$obtener_datos_corte->numRows();
				//echo $totalRows_obtener_datos_corte;
				$array_obtener_datos_corte[]=$row_obtener_datos_corte;
				do
				{
					//$cortes[$i]=$row_fecha;
					//$i+=1;
					$contadorcortes +=1;
				}
				while ($row_obtener_datos_corte=$obtener_datos_corte->fetchRow());

			}
			if (@$ultimocorte < $contadorcortes)
			{
				$ultimocorte = $contadorcortes;
			}
			//echo $ultimocorte;
		}
		//echo $row_obtener_datos_corte['numerocorte'];

		$this->array_obtener_datos_corte=$array_obtener_datos_corte;
		//print_r($array_obtener_datos_corte);
		return ($array_obtener_datos_corte);
	}

	function obtener_notas_estudiante() // no nesecitooooooooooooooooooooooooooooo
	{
		foreach ($this->array_obtener_materias_estudiante as $clave => $valor)
		{
			if($this->numerocorte!=0)
			{
				$query_obtener_notas_estudiante ="SELECT detallenota.*,materia.codigomateria,materia.nombremateria,materia.numerocreditos,
				grupo.codigomateria,corte.porcentajecorte
				FROM detallenota,materia,grupo,corte
				WHERE  materia.codigomateria=grupo.codigomateria
				AND materia.codigoestadomateria = '01'
				AND detallenota.idgrupo=grupo.idgrupo
				AND detallenota.idcorte=corte.idcorte
				AND detallenota.codigoestudiante = '".$this->codigoestudiante."'
				AND detallenota.codigomateria = '".$valor['codigomateria']."'
				AND grupo.codigoperiodo = '".$this->codigoperiodo."'
				AND corte.numerocorte='".$this->numerocorte."'
				ORDER BY 2";
			}
			//echo $query_obtener_notas_estudiante,"<br>";
			$obtener_notas_estudiante=$this->conexion->query($query_obtener_notas_estudiante);
			$row_obtener_notas_estudiante=$obtener_notas_estudiante->fetchRow();
			do
			{
				$array_obtener_notas_estudiante_pormateria[]=$row_obtener_notas_estudiante;
				//print_r($row_obtener_notas_estudiante);echo "<br>";
			}
			while($row_obtener_notas_estudiante=$obtener_notas_estudiante->fetchRow());
		}
		$array_obtener_notas_estudiante[]=$array_obtener_notas_estudiante_pormateria;
		$this->array_obtener_notas_estudiante=$array_obtener_notas_estudiante;
		$this->array_obtener_notas_estudiante_pormateria=$array_obtener_notas_estudiante_pormateria;
		return $array_obtener_notas_estudiante_pormateria;
		//return $array_obtener_notas_estudiante;
	}

	function calcular_definitivas($cantidadcortes) // no necesitoooooooooooooooo
	{
		$contador=0;
		foreach ($this->array_obtener_materias_estudiante as $clave => $valor)
		{
			$notas_incompletas==false;
			for($i=1;$i<=$cantidadcortes;$i++)
			{
				$query_obtener_notas_corte ="SELECT detallenota.*,
				grupo.codigomateria,corte.porcentajecorte
				FROM detallenota,materia,grupo,corte
				WHERE  materia.codigomateria=grupo.codigomateria
				AND materia.codigoestadomateria = '01'
				AND detallenota.idgrupo=grupo.idgrupo
				AND detallenota.idcorte=corte.idcorte
				AND detallenota.codigoestudiante = '".$this->codigoestudiante."'
				AND detallenota.codigomateria = '".$valor['codigomateria']."'
				AND grupo.codigoperiodo = '".$this->codigoperiodo."'
				AND corte.numerocorte='".$i."'
				ORDER BY 2";
				$operacion=$this->conexion->query($query_obtener_notas_corte);
				$row_operacion=$operacion->fetchRow();
				$nota[$i]=$row_operacion['nota'];
				$array_promedio[$contador]['nota_'.$i]=$row_operacion['nota'];
				if($row_operacion['nota']==0 or $row_operacion['nota']=="")
				{
					$notas_incompletas=true;
				}
				else
				{
					$notas_incompletas=false;
				}
				//echo $i." ".$row_operacion['codigomateria']." ".$row_operacion['nota']." ".$notas_incompletas,"<br>";
			}
			$sumatoria=array_sum($nota);
			unset($nota);
			$promedio=$sumatoria/$cantidadcortes;
			$array_promedio[$contador]['codigomateria']=$valor['codigomateria'];

			$array_promedio[$contador]['sumatoria']=$sumatoria;
			$array_promedio[$contador]['nota']=$promedio;
			$array_promedio[$contador]['incompletas']=$notas_incompletas;
			$contador++;
			unset($sumatoria);
			unset($promedio);
		}
		$this->array_promedio=$array_promedio;
		return($array_promedio);
	}

	function obtener_equivalencias_notas()
	{
		/* $contador=0;
		foreach ($this->array_obtener_notas_estudiante_pormateria as $clave => $valor)
		{
			$query_obtener_equivalencias_notas_estudiante="select neq.*
			from notaequivalencia neq, tipoequivalencianota teq
			where neq.codigotipoequivalencianota=teq.codigotipoequivalencianota
			AND neq.codigocarrera='".$this->row_datos_basicos_estudiante['codigocarrera']."'
			AND neq.codigomateria='".$valor['codigomateria']."'
			AND '".$valor['nota']."' between neq.notainicionotaequivalencia and neq.notafinalnotaequivalencia
			";
			//echo $query_obtener_equivalencias_notas_estudiante,"<br>","<br>";
			//echo $valor['nota'],"<br><br>";
			$obtener_equivalencias_notas_estudiante=$this->conexion->query($query_obtener_equivalencias_notas_estudiante);
			$array_obtener_equivalencias_notas_estudiante[$contador]=$obtener_equivalencias_notas_estudiante->fetchRow();

			$contador++;
		}
		//print_r($array_obtener_equivalencias_notas_estudiante);
		$this->array_obtener_equivalencias_notas_estudiante=$array_obtener_equivalencias_notas_estudiante;
		return $array_obtener_equivalencias_notas_estudiante; */
		$contador=0;
		foreach ($this->array_obtener_materias_estudiante as $clave => $valor)
		{
			//echo $valor[codigomateriaelectiva];			
		   $query_obtener_equivalencias_notas_estudiante="select neq.*
		   from notaequivalencia neq, tipoequivalencianota teq
		   where
		   neq.codigotipoequivalencianota=teq.codigotipoequivalencianota
		   AND neq.codigocarrera='".$this->row_datos_basicos_estudiante['codigocarrera']."'
		   AND neq.codigomateria='".$valor['codigomateria']."'
		   AND '".$valor['notadefinitiva']."' between neq.notainicionotaequivalencia and neq.notafinalnotaequivalencia
			";
		  $obtener_equivalencias_notas_estudiante=$this->conexion->query($query_obtener_equivalencias_notas_estudiante);
       	  $array_obtener_equivalencias_notas_estudiante[$contador]=$obtener_equivalencias_notas_estudiante->fetchRow();
	      $contador++;				
				//echo "<h1>codigomateriaelectiva</h1>";
		 		
		}
		$this->array_obtener_equivalencias_notas_estudiante=$array_obtener_equivalencias_notas_estudiante;
		return $array_obtener_equivalencias_notas_estudiante; 		
	}
	
	function datos_universidad()
	{
		$query_universidad = "SELECT u.nombreuniversidad,direccionuniversidad,c.nombreciudad,p.nombrepais,u.paginawebuniversidad,u.imagenlogouniversidad,u.telefonouniversidad,u.faxuniversidad,u.nituniversidad,u.personeriauniversidad,u.entidadrigeuniversidad
		FROM universidad u,ciudad c,pais p,departamento d 
		WHERE u.iduniversidad = 2
		AND d.idpais = p.idpais
		AND u.idciudad = c.idciudad
		AND c.iddepartamento = d.iddepartamento";
		//echo $query_universidad;
		$universidad = $this->conexion->query($query_universidad);
		$row_universidad = $universidad->fetchRow();
		$this->row_universidad=$row_universidad;
		return $row_universidad;
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