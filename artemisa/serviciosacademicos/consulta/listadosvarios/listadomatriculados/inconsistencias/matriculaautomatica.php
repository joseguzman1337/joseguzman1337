<?php 
require_once("../../../prematricula/funcionmateriaaprobada.php");
$query_periodoactivo = "select nombreperiodo
from periodo
where codigoperiodo = '$codigoperiodo'";
//echo "$query_periodoactivo<br>";
$periodoactivo = mysql_db_query($database_sala,$query_periodoactivo) or die("$query_periodoactivo");
$totalRows_periodoactivo = mysql_num_rows($periodoactivo);
$row_periodoactivo = mysql_fetch_array($periodoactivo);
$nombreperiodo = $row_periodoactivo['nombreperiodo'];
//echo "AJA : ".$codigoperiodo." y ".$nombreperiodo;
$enfasisget = "";

// Datos de la primera prematricula hecha
$query_premainicial1 = "SELECT d.codigomateria
FROM detalleprematricula d, prematricula p, materia m, estudiante e
where d.codigomateria = m.codigomateria 
and d.idprematricula = p.idprematricula
and p.codigoestudiante = e.codigoestudiante
and e.codigoestudiante = '$codigoestudiante'
and (p.codigoestadoprematricula like '4%' or p.codigoestadoprematricula like '1%')
and (d.codigoestadodetalleprematricula like '3%' or d.codigoestadodetalleprematricula like '1%' or d.codigoestadodetalleprematricula = '23')
and p.codigoperiodo = '$codigoperiodo'";
//echo "$query_premainicial1<br>";
$premainicial1=mysql_query($query_premainicial1, $sala) or die("$query_premainicial1");
$totalRows_premainicial1 = mysql_num_rows($premainicial1);
$tieneprema = false;
while($row_premainicial1 = mysql_fetch_array($premainicial1))
{
	$prematricula_inicial[] = $row_premainicial1['codigomateria'];
	$tieneprema = true;
}

require_once("../../../prematricula/generarcargaestudiante.php");

// Con este semestre debe mirar que la cantidad de materias sea mayor en creditos, con respecto al semestre 
// que mas se repita

// Materias que quedaron y que son propuestas
// Pone primero las que tienen corequisito doble
$query_materiascarga = "select d.idplanestudio, d.codigomateria, m.nombremateria, d.semestredetalleplanestudio*1 as semestredetalleplanestudio, 
t.nombretipomateria, t.codigotipomateria, d.numerocreditosdetalleplanestudio, c.codigoestadocargaacademica
from planestudioestudiante p, detalleplanestudio d, materia m, tipomateria t, cargaacademica c
where p.codigoestudiante = '$codigoestudiante'
and p.idplanestudio = d.idplanestudio
and p.codigoestadoplanestudioestudiante like '1%'
and d.codigoestadodetalleplanestudio like '1%'
and d.codigomateria = m.codigomateria
and d.codigotipomateria = t.codigotipomateria
and d.codigotipomateria not like '5%'
and c.codigoestudiante = p.codigoestudiante
and c.idplanestudio = p.idplanestudio
and c.codigomateria = d.codigomateria
and c.codigoperiodo = '$codigoperiodo'
order by 4,3";
//and d.codigotipomateria not like '4%'";
//echo "$query_materiascarga<br>";
$materiascarga=mysql_query($query_materiascarga, $sala) or die("$query_materiascarga");
$totalRows_materiascarga = mysql_num_rows($materiascarga);
//echo "Total: $totalRows_materiasplanestudio<br>";
$quitarmaterias1 = "";
if($totalRows_materiascarga != "")
{
	while($row_materiascarga = mysql_fetch_array($materiascarga))
	{
		if(ereg("^2",$row_materiascarga['codigoestadocargaacademica']))
		{
			$materiasquitarcarga[] = $row_materiascarga['codigomateria'];
			$semestre[$row_materiascarga['semestredetalleplanestudio']]--;
		}
		if(ereg("^1",$row_materiascarga['codigoestadocargaacademica']))
		{
			$materiasponercarga[] = $row_materiascarga['codigomateria'];
			$materiasfinal[] = $row_materiascarga;
			$quitarmaterias1 = "$quitarmaterias1 and c.codigomateria <> ".$row_materiascarga['codigomateria']."";
			// Selección de la carga obligatoria
			$semestre[$row_materiascarga['semestredetalleplanestudio']]++;
		}
	}
}

// Pone las materias de la carga que no aparecen en el plan de estudio
$query_materiascarga = "select distinct m.codigomateria, m.nombremateria, d.semestredetalleplanestudio, 
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
$quitarmaterias1
order by 3,2";
//and d.codigotipomateria not like '4%'";
//echo "AHAHA: $query_materiascarga<br>";
//exit();
$materiascarga=mysql_query($query_materiascarga, $sala) or die("$query_materiascarga");
$totalRows_materiascarga = mysql_num_rows($materiascarga);
//echo "Total: $totalRows_materiasplanestudio<br>";
if($totalRows_materiascarga != "")
{
	while($row_materiascarga = mysql_fetch_array($materiascarga))
	{
		/*if(ereg("^2",$row_materiascarga['codigoestadocargaacademica']))
		{
			$materiasquitarcarga[] = $row_materiascarga['codigomateria'];
			$semestre[$row_materiascarga['semestredetalleplanestudio']]--;
		}*/
		if(ereg("^1",$row_materiascarga['codigoestadocargaacademica']))
		{
			$quitarmaterias1 = "$quitarmaterias1 and c.codigomateria <> ".$row_materiascarga['codigomateria']."";
			$materiasponercarga[] = $row_materiascarga['codigomateria'];
			$materiasfinal[] = $row_materiascarga;
		}
	}
}

// OJO: El siguiente codigo toca quitarlo despues del 20052
// Se coloco para pasar por alto el error generado por no guardar el idplanestudio en cargaacademica
$query_materiascarga = "select m.codigomateria, m.nombremateria, d.semestredetalleplanestudio, 
t.nombretipomateria, t.codigotipomateria, d.numerocreditosdetalleplanestudio, 
c.codigoestadocargaacademica
from materia m, tipomateria t, cargaacademica c, detalleplanestudio d
where m.codigotipomateria = t.codigotipomateria
and c.codigoestudiante = '$codigoestudiante'
and c.codigomateria = m.codigomateria
and c.codigoperiodo = '$codigoperiodo'
and c.codigoestadocargaacademica like '1%'
and d.codigomateria = c.codigomateria
$quitarmaterias1
group by 1
order by 3,2";
//and d.codigotipomateria not like '4%'";
//echo "AHAHA: $query_materiascarga<br>";
//exit();
$materiascarga=mysql_query($query_materiascarga, $sala) or die("$query_materiascarga");
$totalRows_materiascarga = mysql_num_rows($materiascarga);
//echo "Total: $totalRows_materiasplanestudio<br>";
if($totalRows_materiascarga != "")
{
	while($row_materiascarga = mysql_fetch_array($materiascarga))
	{
		if(ereg("^1",$row_materiascarga['codigoestadocargaacademica']))
		{
			$quitarmaterias1 = "$quitarmaterias1 and c.codigomateria <> ".$row_materiascarga['codigomateria']."";
			$materiasponercarga[] = $row_materiascarga['codigomateria'];
			$materiasfinal[] = $row_materiascarga;
		}
	}
}

// Este se coloca para coger las materias que no pertenecen a ningun plan de estudio (Electivas y materias no definidas en algun plan de estudio)
$query_materiascarga = "select m.codigomateria, m.nombremateria, 1 as semestredetalleplanestudio, 
t.nombretipomateria, t.codigotipomateria, m.numerocreditos as numerocreditosdetalleplanestudio, 
c.codigoestadocargaacademica
from materia m, tipomateria t, cargaacademica c
where m.codigotipomateria = t.codigotipomateria
and c.codigoestudiante = '$codigoestudiante'
and c.codigomateria = m.codigomateria
and c.codigoperiodo = '$codigoperiodo'
and c.codigoestadocargaacademica like '1%'
$quitarmaterias1
group by 1
order by 3,2";
//and d.codigotipomateria not like '4%'";
//echo "AHAHA: $query_materiascarga<br>";
//exit();
$materiascarga=mysql_query($query_materiascarga, $sala) or die("$query_materiascarga");
$totalRows_materiascarga = mysql_num_rows($materiascarga);
//echo "Total: $totalRows_materiasplanestudio<br>";
if($totalRows_materiascarga != "")
{
	while($row_materiascarga = mysql_fetch_array($materiascarga))
	{
		if(ereg("^1",$row_materiascarga['codigoestadocargaacademica']))
		{
			$quitarmaterias1 = "$quitarmaterias1 and c.codigomateria <> ".$row_materiascarga['codigomateria']."";
			$materiasponercarga[] = $row_materiascarga['codigomateria'];
			$materiasfinal[] = $row_materiascarga;
		}
	}
}

$entroenalgo = false;

if(isset($materiaspropuestas))
{
	//$materiaspropuestas = $materiasfinal;
	$numeromateriaschequeadas = 0;
	foreach($materiaspropuestas as $key3 => $value3)
	{
		// Miro si la materia tiene un grupo derivado de ella
		// Si el grupo es diferente a elestiva libre se trata de un grupo de materias
		// Si no la materia es enfasis
		if($value3['codigoindicadorgrupomateria'] == '100')
		{
			$query_selgrupomaterialinea = "select *
			from grupomaterialinea g, grupomateria gm
			where g.idgrupomateria = gm.idgrupomateria
			and g.codigomateria = '".$value3['codigomateria']."'
			and gm.codigoperiodo = '$codigoperiodo'
			and gm.codigotipogrupomateria <> '100'";
			//echo "$query_selgrupomaterialinea<br>";
			$selgrupomaterialinea = mysql_db_query($database_sala,$query_selgrupomaterialinea) or die("$query_selgrupomaterialinea");
			$totalRows_selgrupomaterialinea = mysql_num_rows($selgrupomaterialinea);
			if($totalRows_selgrupomaterialinea != "")
			{
				$materiascongrupo[] = $value3;
			}//echo "<br> entro ".$value3['idlineaenfasis']."<br>";
		}
		else if($value3['idlineaenfasisplanestudio'] != "")
		{
			//echo "<br> entro ".$value3['idlineaenfasis']."<br>";
			$materiasenfasis[] = $value3;
		}
		else
		{
			if(!@in_array($value3['codigomateria'],$materiasquitarcarga))
			{
				if(!@in_array($value3['codigomateria'],$materiasponercarga))
				{
					// Variables para los correquisitos
					$title = "";
					$onclic = "";
					$id = "";
					
					if($res_sem[0] >= $value3['semestredetalleplanestudio'])
					{
						$tipomateriacarga = "Propuesta";
						$chequear = "checked";
						$numeromateriaschequeadas++;
					}
					else
					{
						$tipomateriacarga = "Sugerida";
						$chequear = "";
					}
					$desabilitar = "";
					if(isset($prematricula_inicial))
					{
						foreach($prematricula_inicial as $llave => $codigomateriaprematricula)
						{
							if($codigomateriaprematricula == $value3['codigomateria'])
							{
								$prematriculafiltrar[] = $value3; 
								$desabilitar = "disabled";
								$id = "id='habilita'";
								$chequear = "checked";
								break;
							}
						}
					}
					// Mira si la materia tiene corequisitos si el corequisito es doble
					// A las materias que son corequisitos debe seleccionarlas al tiempo
					// 1. Al seleccionarala manualmente seleccionar automaticamente los corequisitos
					
					// 1. Mira si la materia solamente tiene corequisitos dobles, es decir que primero busca sencillos
					$query_materiascorequisitosencillo = "select distinct r.codigomateria
					from referenciaplanestudio r
					where r.idplanestudio = '".$value3['idplanestudio']."'
					and r.codigomateria = '".$value3['codigomateria']."'
					and r.codigotiporeferenciaplanestudio like '201'
					and r.codigoestadoreferenciaplanestudio = '101'";
					//echo "$query_materiascorequisitosencillo<br>";
					$materiascorequisitosencillo=mysql_query($query_materiascorequisitosencillo, $sala) or die("$query_materiascorequisitosencillo");
					$totalRows_materiascorequisitosencillo = mysql_num_rows($materiascorequisitosencillo);
					if($totalRows_materiascorequisitosencillo == "")
					{
						// Mira si tiene corequisitos sencillos como hija
						$query_materiascorequisitosencillo = "select distinct r.codigomateria
						from referenciaplanestudio r
						where r.idplanestudio = '".$value3['idplanestudio']."'
						and r.codigomateriareferenciaplanestudio = '".$value3['codigomateria']."'
						and r.codigotiporeferenciaplanestudio like '201'
						and r.codigoestadoreferenciaplanestudio = '101'";
						//echo "<br>aca $query_materiascorequisito<br><br>";
						$materiascorequisitosencillo=mysql_query($query_materiascorequisitosencillo, $sala) or die("$query_materiascorequisitosencillo");
						$totalRows_materiascorequisitosencillo = mysql_num_rows($materiascorequisitosencillo);
					}
					// Si no tiene corequisitos sencillos busca los dobles
					if($totalRows_materiascorequisitosencillo == "")
					{
						// Mira si es papa
						$query_materiascorequisito = "select distinct r.codigomateria
						from referenciaplanestudio r
						where r.idplanestudio = '".$value3['idplanestudio']."'
						and r.codigomateria = '".$value3['codigomateria']."'
						and r.codigotiporeferenciaplanestudio like '200'
						and r.codigoestadoreferenciaplanestudio = '101'";
						//echo "$query_materiascorequisito<br>";
						$materiascorequisito=mysql_query($query_materiascorequisito, $sala) or die("$query_materiascorequisito");
						$totalRows_materiascorequisito = mysql_num_rows($materiascorequisito);
						if($totalRows_materiascorequisito == "")
						{
							// Mira si es hija y si es asi pone en title el papa
							$query_materiascorequisito = "select distinct r.codigomateria
							from referenciaplanestudio r
							where r.idplanestudio = '".$value3['idplanestudio']."'
							and r.codigomateriareferenciaplanestudio = '".$value3['codigomateria']."'
							and r.codigotiporeferenciaplanestudio like '200'
							and r.codigoestadoreferenciaplanestudio = '101'";
							//echo "<br>aca $query_materiascorequisito<br><br>";
							$materiascorequisito=mysql_query($query_materiascorequisito, $sala) or die("$query_materiascorequisito");
							$totalRows_materiascorequisito = mysql_num_rows($materiascorequisito);
						}
						// Si encontro solamente dobles los deja asociados al papa
						if($totalRows_materiascorequisito != "")
						{
							$row_materiascorequisito = mysql_fetch_array($materiascorequisito);
							$title = "title=".$row_materiascorequisito['codigomateria'];
							$onclic = "onClick='ChequearTodos(this,$title)'";
							$id = "id='habilita'";
						}
					}
					$entroenalgo = true;
					if($chequear == "checked" && $desabilitar == "disabled")
					{
						$materiascarga[] = $value3['codigomateria'];
					}
					$materiaspantallainicial[] = $value3['codigomateria'];
				}
			}
		}
	}
}
// Materias que que son obligatorias
if(isset($materiasobligatorias))
{
	foreach($materiasobligatorias as $key4 => $value4)
	{
		if(!@in_array($value4['codigomateria'],$materiasquitarcarga))
		{
			if(!@in_array($value4['codigomateria'],$materiasponercarga))
			{
				$entroenalgo = true;
				$materiascarga[] = $value4['codigomateria'];
				$materiaspantallainicial[] = $value4['codigomateria'];
			}
		}
	}
}

if(isset($materiasfinal))
{	
	foreach($materiasfinal as $key5 => $value5)
	{
		if(isset($prematricula_inicial))
		{
			$desabilitar = "";
			$id = "";
			$chequear = "";
			
			foreach($prematricula_inicial as $llave => $codigomateriaprematricula)
			{
				if($codigomateriaprematricula == $value5['codigomateria'])
				{
					$prematriculafiltrar[] = $value5; 
					$desabilitar = "disabled";
					$id = "id='habilita'";
					$chequear = "checked";
					//break;
				}
			}
		}
		if($chequear == "checked" && $desabilitar == "disabled")
		{
			$materiascarga[] = $value5['codigomateria'];
		}
		$materiaspantallainicial[] = $value5['codigomateria'];
	}
}
if(isset($prematriculafiltrar))
{	
	foreach($prematriculafiltrar as $key6 => $value6)
	{
		if(isset($prematricula_inicial))
		{
			$desabilitar = "";
			$id = "";
			$chequear = "";
			
			$estamateria = false;
			foreach($prematricula_inicial as $llave => $codigomateriaprematricula)
			{
				if($codigomateriaprematricula == $value6['codigomateria'])
				{
					$prematriculaencontrada[] = $codigomateriaprematricula;
					//echo "$codigomateriaprematricula == ".$value6['codigomateria']."";
					$estamateria = true;
					break;
				}
			}
		}
		$desabilitar = "disabled";
		$id = "id='habilita'";
		$chequear = "checked";
		if(!$estamateria)
		{
			$entroenalgo = true;
			if($chequear == "checked" && $desabilitar == "disabled")
			{
				$materiascarga[] = $value6['codigomateria'];
			}
			$materiaspantallainicial[] = $value6['codigomateria'];
		}
	}
}
if(isset($prematricula_inicial))
{
	foreach($prematricula_inicial as $key7 => $value7)
	{
		if(isset($prematriculaencontrada))
		{	
			$estamateria = true;
			foreach($prematriculaencontrada as $key8 => $value8)
			{
				if($value8 == $value7)
				{
					//echo "$codigomateriaprematricula == ".$value6['codigomateria']."";
					$estamateria = true;
					break;
				}
			}
			$desabilitar = "disabled";
			$id = "id='habilita'";
			$chequear = "checked";
			if(!$estamateria)
			{
				$query_datosmateriafinal = "select m.nombremateria, d.semestredetalleplanestudio, d.codigotipomateria, d.numerocreditosdetalleplanestudio
				from materia m, detalleplanestudio d, planestudioestudiante pe
				where m.codigomateria = '$value7'
				and d.codigomateria = m.codigomateria
				and pe.codigoestudiante = '$codigoestudiante'
				and pe.idplanestudio = d.idplanestudio
				and pe.codigoestadoplanestudioestudiante = '101'";
				//echo "<br>aca $query_materiascorequisito<br><br>";
				$datosmateriafinal=mysql_query($query_datosmateriafinal, $sala) or die("$query_datosmateriafinal");
				$totalRows_datosmateriafinal = mysql_num_rows($datosmateriafinal);
				// Si encontro solamente dobles los deja asociados al papa
				if($totalRows_datosmateriafinal != "")
				{
					$row_datosmateriafinal = mysql_fetch_array($datosmateriafinal);
					$entroenalgo = true;
	
					if($chequear == "checked" && $desabilitar == "disabled")
					{
						$materiascarga[] = $row_datosmateriafinal['codigomateria'];
					}
					$materiaspantallainicial[] = $row_datosmateriafinal['codigomateria'];
				}
			}
		}
	}
}
if(!$entroenalgo)
{
?>
<tr> 
  	<td class="Estilo1 Estilo2 Estilo1 Estilo3 Estilo8" colspan="6" align="center"><strong>El estudiante no tiene carga académica</strong></td>
</tr>
<?php
}
$entroengrupo = false;
// Materias con grupo
if(isset($materiascongrupo))
{
	$title = "";
	$onclic = "";
	$id = "";
	$chequear = "";
	foreach($materiascongrupo as $key11 => $value11)
	{
		if(!@in_array($value11['codigomateria'],$materiasquitarcarga))
		{
			if(!@in_array($value11['codigomateria'],$materiasponercarga))
			{
				$valueserial11 = serialize($value11);
				$title = "title=".$value11['codigomateria'];
				// Si la materia existe en detalle prematricula desabilita todas las demas, dejando chequeada la activa en prematricula
				$query_mategrupo = "SELECT d.codigomateria
				FROM detalleprematricula d, prematricula p, materia m, estudiante e
				where d.codigomateria = m.codigomateria 
				and d.idprematricula = p.idprematricula
				and p.codigoestudiante = e.codigoestudiante
				and e.codigoestudiante = '$codigoestudiante'
				and d.codigomateriaelectiva = '".$value11['codigomateria']."'
				and (p.codigoestadoprematricula like '4%' or p.codigoestadoprematricula like '1%')
				and (d.codigoestadodetalleprematricula like '3%' or d.codigoestadodetalleprematricula like '1%' or d.codigoestadodetalleprematricula = '23')
				and p.codigoperiodo = '$codigoperiodo'";
				//echo "$query_premainicial1<br>";
				$mategrupo=mysql_query($query_mategrupo, $sala) or die("$query_mategrupo");
				$totalRows_mategrupo = mysql_num_rows($mategrupo);
				if($totalRows_mategrupo != "")
				{
					$row_mategrupo = mysql_fetch_array($mategrupo);
					$materiaescogida = $row_mategrupo['codigomateria'];
					$desabilitar = "disabled";
					$chequear = "checked";
					$id = "id='habilita'";
				}
				else
				{
					$desabilitar = "";
					$materiaescogida = "";
				}
				$numeromateriaschequeadas++;
				//$chequear = "checked";
				$onclic = "onClick='HabilitarGrupoCheck($title)'";

				$chequear = "";
				$id = "";
				// Selleciono el grupo de la materia
				// Solamente aquellas que no ha vsto el estudiante
				$query_datosgrupo = "select d.codigomateria, m.nombremateria, m.numerohorassemanales, m.numerocreditos as numerocreditosdetalleplanestudio
				from detallegrupomateria d, materia m, grupomaterialinea gm
				where d.codigomateria = m.codigomateria
				and gm.codigomateria = '".$value11['codigomateria']."'
				and gm.idgrupomateria = d.idgrupomateria
				and gm.codigoperiodo = '$codigoperiodo'
				order by m.nombremateria";
				$datosgrupo=mysql_query($query_datosgrupo, $sala) or die("$query_datosgrupo");
				$totalRows_datosgrupo = mysql_num_rows($datosgrupo);
				if($totalRows_datosgrupo != "")
				{
					$entroengrupo = false;
					while($row_datosgrupo = mysql_fetch_array($datosgrupo))
					{
						$row_datosgrupo['semestredetalleplanestudio'] = $value11['semestredetalleplanestudio'];
						$row_datosgrupo['numerocreditosdetalleplanestudio'] = $value11['numerocreditosdetalleplanestudio'];
					
						// Variables para los correquisitos						
						$valueserial12 = serialize($row_datosgrupo);
						if($materiaescogida == $row_datosgrupo['codigomateria'])
						{
							$chequear = "checked";
							$id = "id='habilita'";
						}
						else
						{
							if(!$entroengrupo)
							{
								$chequear = "";
								//$id = "id='habilita'";
							}
							else
							{
								$chequear = "";
								$id = "";
							}					
						}
						$desabilitar = "disabled";
						$entroengrupo = true;
						//echo "<br>ID $id<br>";
						
						if($chequear == "checked" && $desabilitar == "disabled")
						{
							$materiascarga[$value11['codigomateria']] = $row_datosgrupo['codigomateria'];
						}
					}
				}
			}
		}
	}
}
$entroenenfasis = false;
// Materias que que son enfasis
if(isset($materiasenfasis))
{
	foreach($materiasenfasis as $key8 => $value8)
	{
		//$idvievo = 1;
		
		if(!@in_array($value8['codigomateria'],$materiasquitarcarga))
		{
			if(!@in_array($value8['codigomateria'],$materiasponercarga))
			{
				// Variables para los correquisitos
				$title = "";
				$onclic = "";
				$id = "";
				
				$valueserial8 = serialize($value8);
				//echo $valueserial3;
				if($res_sem[0] >= $value8['semestredetalleplanestudio'])
				{
					$tipomateriacarga = "Propuesta";
					$chequear = "checked";
					$numeromateriaschequeadas++;
				}
				else
				{
					$tipomateriacarga = "Sugerida";
					$chequear = "";
				}
				if(!$estudiantetieneenfasis)
				{
					//$id = "id='habilita'";
					$desabilitar = "disabled";
				}
				else
				{
					$desabilitar = "";				
				}
				if(isset($prematricula_inicial))
				{
					foreach($prematricula_inicial as $llave => $codigomateriaprematricula)
					{
						if($codigomateriaprematricula == $value8['codigomateria'])
						{
							$prematriculafiltrar[] = $value8; 
							$desabilitar = "disabled";
							$id = "id='habilita'";
							$chequear = "checked";
							break;
						}
					}
				}
				$entroenenfasis = true;
				$enfasisget = "tieneenfasis";

				if($idviejo != $value8['idlineaenfasisplanestudio'])
				{
					$query_sellinea = "select l.nombrelineaenfasisplanestudio
					from lineaenfasisplanestudio l
					where l.idlineaenfasisplanestudio = '".$value8['idlineaenfasisplanestudio']."'";
					//echo "<br>aca $query_materiascorequisito<br><br>";
					$sellinea=mysql_query($query_sellinea, $sala) or die("$query_sellinea");
					$totalRows_sellinea = mysql_num_rows($sellinea);
					// Si encontro solamente dobles los deja asociados al papa
					if($totalRows_sellinea != "")
					{
						$row_sellinea = mysql_fetch_array($sellinea);
						$title = "title=".$value8['idlineaenfasisplanestudio'];
						//$onclic2 = "onClick='HabilitarGrupo(this,$title)'";
						//$id = "id='habilita'";
						//echo $onclic;
				}
				$title = "title=".$idviejo;
				if($chequear == "checked" && $desabilitar == "disabled")
				{
					$materiascarga[] = $value8['codigomateria'];
				}
			}
		}
	}
	if(!$entroenenfasis)
	{
?>
<tr> 
  	<td class="Estilo1 Estilo2 Estilo1 Estilo3 Estilo8" colspan="6" align="center"><strong>El estudiante ha cumplido con las línea de énfasis del plan de estudio</strong></td>
</tr>
<?php
	}
}
// Selecciona las electivas libres vistas y pasadas por el estudiante, en donde tenga nota y la nota sea electiva
// Nota historico tiene el codigotipomateria de la cual el estudiante tiene nota
$query_electivaslibresvistas = "select n.notadefinitiva, m.numerocreditos, n.codigomateria, 
m.codigoindicadorcredito, m.ulasa, m.ulasb, m.ulasc 
from notahistorico n, materia m
where n.codigomateria = m.codigomateria
and m.notaminimaaprobatoria <= n.notadefinitiva
and n.codigotipomateria = '4'
and n.codigoestudiante = '$codigoestudiante'";
//and p.codigoestadoplanestudioestudiante like '1%'
//echo "$query_premainicial1<br>";
// and m.codigoestadomateria = '1'
$electivaslibresvistas=mysql_query($query_electivaslibresvistas, $sala) or die("$query_electivaslibresvistas");
$totalRows_electivaslibresvistas = mysql_num_rows($electivaslibresvistas);
$sinelectivas = "";
if($totalRows_electivaslibresvistas != "")
{
	while($row_electivaslibresvistas = mysql_fetch_array($electivaslibresvistas))
	{
		if($row_electivaslibresvistas['codigoindicadorcredito'] == "100")
		{
			$numerocreditoselectivasvistas = $numerocreditoselectivasvistas + $row_electivaslibresvistas['numerocreditos'];
		}
		else if($row_electivaslibresvistas['codigoindicadorcredito'] == "200")
		{
			$creditosulas = round(($row_electivaslibresvistas['ulasa'] + $row_electivaslibresvistas['ulasb'] + $row_electivaslibresvistas['ulasc'])/48);
			//echo "<br>UNO:  $creditosulas <br>";
			$numerocreditoselectivasvistas = $numerocreditoselectivasvistas + $creditosulas;
		}
		$sinelectivas = "$sinelectivas and codigomateria <> ".$row_electivaslibresvistas['codigomateria']."";
		$electivasaprobadas[] = $row_electivaslibresvistas; 
	}
}
else
{
	$numerocreditoselectivasvistas = 0;
}
if($tieneelectivas)
{
	$numerocreditosfaltantes = $numerocreditoselectivas - $numerocreditoselectivasvistas;
	if($numerocreditosfaltantes != 0)
	{
		// Seleccion de las electivas que no ha visto el estudiante
		// En caso de que exista una electiva libre que se halla escogido como obligatoria tampoco deberia aparecer aca
		// Es decir que hay que quitar las materias que tenga el plan de estudios
		$query_datoselectivas = "select m.codigomateria, m.nombremateria, m.numerohorassemanales, m.numerocreditos
		from materia m, grupomateria gm, detallegrupomateria d
		where gm.codigotipogrupomateria = '100'
		and gm.codigoperiodo = '20052'
		and d.idgrupomateria = gm.idgrupomateria
		and m.codigomateria = d.codigomateria
		$quitarmateriasdelplandestudios
		order by m.nombremateria";
		$datoselectivas=mysql_query($query_datoselectivas, $sala) or die("$query_datoselectivas");
		$totalRows_datoselectivas = mysql_num_rows($datoselectivas);
		if($totalRows_datoselectivas != "")
		{
			$electivasaprobadas1 = $electivasaprobadas;
			$cuentamateriaselectivas = 0;
			while($row_datoselectivas = mysql_fetch_array($datoselectivas))
			{
				$desabilitar = "";
				//$id = "id='habilita'";
				$chequear = "";
				
				$electivavista = false;
				$electivasuperiorencreditos = false;
				//echo "$numerocreditosfaltantes<br> ".$row_datoselectivas['numerocreditos'];
				if($numerocreditosfaltantes < $row_datoselectivas['numerocreditos'])
				{
					$electivasuperiorencreditos = true;
				}
				else if(isset($electivasaprobadas))
				{
					foreach($electivasaprobadas1 as $key1 => $value1)
					{
						if($value1['codigomateria'] == $row_datoselectivas['codigomateria'])
						{
							$electivavista = true;
						}
					}
				}
				if(!$electivavista && !$electivasuperiorencreditos)
				{
					$row_datoselectivasserial = serialize($row_datoselectivas);
					if(isset($prematricula_inicial))
					{
						foreach($prematricula_inicial as $llave2 => $codigomateriaprematricula)
						{
							if($codigomateriaprematricula == $row_datoselectivas['codigomateria'])
							{
								//echo "$llave2 => $codigomateriaprematricula<br>"; 
								//$prematriculafiltrar[] = $value3; 
								$desabilitar = "disabled";
								//$id = "id='habilita'";
								$chequear = "checked";
								break;
							}
						}
					}
					if($chequear == "checked" && $desabilitar == "disabled")
					{
						$materiascarga[] = $row_datoselectivas['codigomateria'];
					}
					$cuentamateriaselectivas++;
				}
			}
		}
	}
}
unset($prematricula_inicial);
unset($semestre);
unset($electivaslibresplan);
unset($materiasporver);
unset($cargaobligatoria);
unset($materiasobligatorias);
unset($materiaspasadas);
unset($materiasquitarcarga);
unset($materiasponercarga);
unset($materiasfinal);
unset($materiaspropuestas);
unset($materiascongrupo);
unset($materiasenfasis);
unset($prematriculafiltrar);	
unset($materiaspantallainicial);	
unset($electivasaprobadas);	
?>
