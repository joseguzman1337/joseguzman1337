<?php
error_reporting(0);
require_once("../../../../funciones/conexion/conexionpear.php");
class estudiante
{
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
		$query_obtener_materias_estudiante="SELECT d.codigomateriaelectiva,m.nombremateria,m.codigomateria,d.codigomateriaelectiva,m.numerocreditos,g.idgrupo,p.codigoestudiante,la.nombrelineaacademica
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
		";
		$obtener_materias_estudiante=$this->conexion->query($query_obtener_materias_estudiante);
		//echo $query_obtener_materias_estudiante;
		$row_obtener_materias_estudiante=$obtener_materias_estudiante->fetchRow();
		do
		{
			$array_obtener_materias_estudiante[]=$row_obtener_materias_estudiante;
		}
		while($row_obtener_materias_estudiante=$obtener_materias_estudiante->fetchRow());
		$this->array_obtener_materias_estudiante=$array_obtener_materias_estudiante;
		//$array_obtener_materias_estdiante=
		return $array_obtener_materias_estudiante;
	}
	function obtener_areas_materias()
	{
		foreach ($this->array_obtener_materias_estudiante as $clave => $valor)
		{
			//echo $valor[codigomateriaelectiva];
			if($valor['codigomateriaelectiva']!=0)
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
	
	function obtener_datos_corte()
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

	function obtener_notas_estudiante()
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
			else
			{
				$query_obtener_notas_estudiante ="SELECT detallenota.*,materia.nombremateria,materia.numerocreditos,
				grupo.codigomateria,corte.porcentajecorte
				FROM detallenota,materia,grupo,corte
				WHERE  materia.codigomateria=grupo.codigomateria
				AND materia.codigoestadomateria = '01'
				AND detallenota.idgrupo=grupo.idgrupo
				AND detallenota.idcorte=corte.idcorte
				AND detallenota.codigoestudiante = '".$this->codigoestudiante."'
				AND detallenota.codigomateria = '".$valor['codigomateria']."'
				AND grupo.codigoperiodo = '".$this->codigoperiodo."'
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
	
	function obtener_equivalencias_notas()
	{
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
			$obtener_equivalencias_notas_estudiante=$this->conexion->query($query_obtener_equivalencias_notas_estudiante);
			$array_obtener_equivalencias_notas_estudiante[]=$obtener_equivalencias_notas_estudiante->fetchRow();
		}
		//print_r($array_obtener_equivalencias_notas_estudiante);
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
}
?>
<?php
function imprimir_array($array)
{
	print "\n<pre>";
	print_r ($array);
	print "\n</pre>";
}
?>
<?php
function print_a( $TheArray )
  { // Note: the function is recursive
    echo "<table border=1>\n";
    
    $Keys = array_keys( $TheArray );
    foreach( $Keys as $OneKey )
    {
      echo "<tr>\n";
      
      echo "<td bgcolor='#727450'>";
      echo "<B>" . $OneKey . "</B>";
      echo "</td>\n";
      
      echo "<td bgcolor='#C4C2A6'>";
        if ( is_array($TheArray[$OneKey]) )
          print_a($TheArray[$OneKey]);
        else
          echo $TheArray[$OneKey];
      echo "</td>\n";
      
      echo "</tr>\n";
    }
    echo "</table>\n";
  }
?>

<?php
function escribir_cabeceras($matriz)
{
	echo "<tr>\n";
	while($elemento = each($matriz))
	{
		echo "<th>$elemento[0]</th>\n";
	}
	echo "</tr>\n";
}

function listar($matriz,$texto)
{
	echo "<table border=1 align=center>\n";
	echo "<caption align=TOP>$texto</caption>";
	escribir_cabeceras($matriz[0]);
	for($i=0; $i < count($matriz); $i++)
	{
		echo "<tr>\n";
		while($elemento=each($matriz[$i]))
		{
			echo "<td>$elemento[1]</td>\n";
		}
	echo "</tr>\n";
	}
	echo "</table>\n";
}
?>