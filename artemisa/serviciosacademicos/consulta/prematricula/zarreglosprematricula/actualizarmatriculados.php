<?php
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);

/* La funcion recibe el idgrupo y el codigoperiodo para actualizar el numero de matriculados 
en un grupo para un periodo que se quiere actualizar */
function actualizarmatriculados($idgrupo, $codigoperiodo, $codigocarrera, $sala)
{
	$cuentamatriculadosgrupo = 0;
	$cuentamatriculadosgrupoelectiva = 0;
	// Toca mirar si el grupo tiene cupo como electiva
	$query_matriculados = "SELECT e.codigoestudiante, d.codigomateria
	FROM detalleprematricula d, estudiante e, prematricula p
	WHERE (d.codigoestadodetalleprematricula LIKE '1%' OR d.codigoestadodetalleprematricula LIKE '3%')
	and (p.codigoestadoprematricula like '1%' or p.codigoestadoprematricula like '4%')
	and p.idprematricula = d.idprematricula
	and p.codigoestudiante = e.codigoestudiante
	and e.codigosituacioncarreraestudiante not like '1%'
	and e.codigosituacioncarreraestudiante not like '4%'
	AND d.idgrupo = '$idgrupo'
	and p.codigoperiodo = '$codigoperiodo'";
	//echo "$query_matriculados<br>";
	$matriculados = mysql_query($query_matriculados, $sala) or die("$query_matriculados".mysql_error());
	$totalRows_matriculados = mysql_num_rows($matriculados);
	if($totalRows_matriculados != "")
	{
		while($row_matriculados = mysql_fetch_assoc($matriculados))
		{
			// Primero mira si la materia se encuentra en el plan de estudios para este estudiante
			$codigoestudiante = $row_matriculados['codigoestudiante'];
			$codigomateria = $row_matriculados['codigomateria'];
			$query_planestudio = "select d.idplanestudio, d.codigomateria, m.nombremateria, m.codigoindicadorgrupomateria, 
			d.semestredetalleplanestudio*1 as semestredetalleplanestudio, 
			t.nombretipomateria, t.codigotipomateria, d.numerocreditosdetalleplanestudio
			from planestudioestudiante p, detalleplanestudio d, materia m, tipomateria t
			where p.codigoestudiante = '$codigoestudiante'
			and p.idplanestudio = d.idplanestudio
			and p.codigoestadoplanestudioestudiante like '1%'
			and d.codigoestadodetalleplanestudio like '1%'
			and d.codigomateria = m.codigomateria
			and d.codigotipomateria = t.codigotipomateria
			and m.codigomateria = '$codigomateria'
			order by 4,3";
			//echo "$query_planestudio<br>";
			$planestudio = mysql_query($query_planestudio, $sala) or die("$query_planestudio".mysql_error());
			$totalRows_planestudio = mysql_num_rows($planestudio);
			if($totalRows_planestudio != "")
			{
				$cuentamatriculadosgrupo++;
			}
			else
			{
				$query_linea = "select d.idplanestudio, d.idlineaenfasisplanestudio, 
				d.codigomateriadetallelineaenfasisplanestudio as codigomateria, m.nombremateria, 
				d.semestredetallelineaenfasisplanestudio*1 as semestredetalleplanestudio, t.nombretipomateria, 
				t.codigotipomateria, d.numerocreditosdetallelineaenfasisplanestudio as numerocreditosdetalleplanestudio
				from detallelineaenfasisplanestudio d, materia m, tipomateria t, lineaenfasisestudiante l
				where d.codigomateriadetallelineaenfasisplanestudio = m.codigomateria
				and d.codigotipomateria = t.codigotipomateria
				and l.idplanestudio = d.idplanestudio
				and l.codigoestudiante = '$codigoestudiante'
				and l.idlineaenfasisplanestudio = d.idlineaenfasisplanestudio
				and d.codigomateriadetallelineaenfasisplanestudio = '$codigomateria'
				and d.codigoestadodetallelineaenfasisplanestudio like '1%'";
				//echo "$query_linea<br>";
				$linea = mysql_query($query_linea, $sala) or die("$query_linea".mysql_error());
				$totalRows_linea = mysql_num_rows($linea);
				if($totalRows_linea != "")
				{
					$cuentamatriculadosgrupo++;
				}
				else
				{
					$query_carga = "select distinct m.codigomateria, m.nombremateria, d.semestredetalleplanestudio, 
					t.nombretipomateria, t.codigotipomateria, d.numerocreditosdetalleplanestudio, 
					c.codigoestadocargaacademica
					from materia m, tipomateria t, cargaacademica c, detalleplanestudio d
					where m.codigotipomateria = t.codigotipomateria
					and c.codigoestudiante = '$codigoestudiante'
					and c.codigomateria = m.codigomateria
					and c.codigoperiodo = '$codigoperiodo'
					and c.codigoestadocargaacademica like '1%'
					and c.idplanestudio = d.idplanestudio
					and d.codigomateria = c.codigomateria
					and m.codigomateria = '$codigomateria'";
					//echo "$query_carga<br>";
					$carga = mysql_query($query_carga, $sala) or die("$query_carga".mysql_error());
					$totalRows_carga = mysql_num_rows($carga);
					if($totalRows_carga != "")
					{
						$cuentamatriculadosgrupo++;
					}
					else
					{
						$cuentamatriculadosgrupoelectiva++;
					}
				}
			}
		}
	}
	$query_updgrupo="UPDATE grupo SET 
	matriculadosgrupo = '$cuentamatriculadosgrupo'
	WHERE idgrupo = '$idgrupo'";
	//echo "<br> $query_updgrupo";
	$updgrupo = mysql_query($query_updgrupo, $sala) or die(mysql_error());

	$query_updgrupo="UPDATE grupo SET 
	matriculadosgrupoelectiva = '$cuentamatriculadosgrupoelectiva'
	WHERE idgrupo = '$idgrupo'";
	//echo "<br> $query_updgrupo";
	$updgrupo = mysql_query($query_updgrupo, $sala) or die(mysql_error());
}
?>
