<?php 
//require('funcionvalidarcrucehorarios.php');
// Esta funcion retorna un arreglo con el id de los grupos propuestos para ser adicionados en la prematricula
// La funcion recibe las materias ordenadas de mayor a menor numero de grupos
// Dentro de la funcion para cada materia creo un arreglo de grupos pertenecientes a la materia
//function seleccionarhorarios($materias, $grupos, $maximogrupo, $horarios, $sala)
function seleccionarhorarios($materias, $codigoperiodo, $sala)
{
	$numeromateria = 0;
	// Este foreach crea los arreglos con las materias
	foreach($materias as $llave1 => $codigomateria)
	{
		//echo "<br> <h1> $llave1 => $codigomateria </h1><br>";
		$query_datosgrupos = "select g.idgrupo, concat(d.nombredocente,' ',d.apellidodocente) as nombre, g.maximogrupo, 
		g.maximogrupoelectiva, g.matriculadosgrupo, g.matriculadosgrupoelectiva, g.codigoindicadorhorario 
		from grupo g, docente d
		where g.numerodocumento = d.numerodocumento
		and g.codigomateria = '$codigomateria'
		and g.codigoperiodo = '$codigoperiodo'
		and g.codigoestadogrupo = '10'";
		$datosgrupos=mysql_query($query_datosgrupos, $sala) or die("$query_datosgrupos");
		$totalRows_datosgrupos = mysql_num_rows($datosgrupos);
		//echo $query_datosgrupos."<br>";
		//echo "$totalRows_datosgrupos <br>";
		//Los arrglos de grupos se crean con cupo y activos
		if($totalRows_datosgrupos != "")
		{
			$keygrupo = 0;
			while($row_datosgrupos = mysql_fetch_array($datosgrupos))
			{
				// Si hay cupo inicializa el arreglo de grupos
				//echo "if(".$row_datosgrupos['maximogrupo']." < (".$row_datosgrupos['matriculadosgrupoelectiva']." + ".$row_datosgrupos['matriculadosgrupo']."))<br>";
				if($row_datosgrupos['maximogrupo'] > ($row_datosgrupos['matriculadosgrupoelectiva'] + $row_datosgrupos['matriculadosgrupo']))
				{
					// Arreglo de grupos inicializados
					${$numeromateria}[$row_datosgrupos['idgrupo']][$keygrupo] = "0";
					//echo "$$numeromateria","[",$row_datosgrupos['idgrupo'],"][$keygrupo] = 0 &nbsp;";
					$keygrupo++;
				}
			}
		}
		$numeromateria++;
	}
	
	$totalmaterias = $numeromateria - 1;
	$numeromateria = $totalmaterias;
	// Este foreach crea la estructura de datos deseada
	// Asigna a cada grupo un nuevo arreglo
	// Toca voltear el arreglo materias y asignar del ultimo areglo al primero.
	$materiasreversa = array_reverse($materias); 
	
	foreach($materiasreversa as $llave1 => $codigomateria)
	{
		//echo "$llave1 => $codigomateria <br>";
		$query_datosgrupos = "select g.idgrupo, concat(d.nombredocente,' ',d.apellidodocente) as nombre, g.maximogrupo, 
		g.maximogrupoelectiva, g.matriculadosgrupo, g.matriculadosgrupoelectiva, g.codigoindicadorhorario 
		from grupo g, docente d
		where g.numerodocumento = d.numerodocumento
		and g.codigomateria = '$codigomateria'
		and g.codigoperiodo = '$codigoperiodo'
		and g.codigoestadogrupo = '10'";
		$datosgrupos=mysql_query($query_datosgrupos, $sala) or die("$query_datosgrupos");
		$totalRows_datosgrupos = mysql_num_rows($datosgrupos);
		//echo "$query_datosgrupos <br>";
		//echo "$totalRows_datosgrupos <br>";
		//echo "<br>";
		if($totalRows_datosgrupos != "")
		{
			$keygrupo = 0;
			
			while($row_datosgrupos = mysql_fetch_array($datosgrupos))
			{
				// Si hay cupo crea el arbol
				if($row_datosgrupos['maximogrupo'] > ($row_datosgrupos['matriculadosgrupoelectiva'] + $row_datosgrupos['matriculadosgrupo']))
				{
					// Al arreglo con el codigo de la materia como nombre le asigno el idgrupo
					// Arreglo de grupos inicializados
					//echo "$nummateria = 0; $nummateria <= $totalmaterias <br>";
					$numsiguiente = $numeromateria + 1;
					// Si existe el siguiente arreglo
					if(isset(${$numsiguiente}))
					{
						${$numeromateria}[$row_datosgrupos['idgrupo']][$keygrupo] = ${$numsiguiente};
						//echo "${$numeromateria}"."[".$row_datosgrupos['idgrupo']."][$keygrupo] = ${$numsiguiente}<br>";
						//echo "$$numeromateria"."[".$row_datosgrupos['idgrupo']."][$keygrupo] = $$numsiguiente<br>";
					}
					else
					{
						//echo "No existe $$numsiguiente ";
					}
					$keygrupo++;
				}
			}
		}
		$numeromateria--;
	}
	
	$raiz = 0;
	//echo "recorrearbol($$raiz, &$gruposelegidos, $sala)<br>";
	if(!recorrearbol(${$raiz}, &$gruposelegidos, $codigoperiodo, $sala))
	{
		return false;
	}
	else
	{
		return $gruposelegidos;
	}
	
	
	//echo ${$numeromateria}[2310][0]."QUEEE?<br>";
	//print_r($$numeromateria[2310][0]);
	//echo "QUEEE?<br>";
}

function seleccionarhorariosporjornada($materias, $codigoperiodo, $jornada, $sala)
{
	$numeromateria = 0;
	// Este foreach crea los arreglos con las materias
	foreach($materias as $llave1 => $codigomateria)
	{
		//echo "<br> <h1> $llave1 => $codigomateria </h1><br>";
		
		// Selecciona los grupos de acuerdo a la jornada del estudiante, estos dos querys los toma para los grupos que necesitan horario y que tengan
		if($jornada == '01')
		{
			$query_datosgrupos = "select distinct g.idgrupo, concat(d.nombredocente,' ',d.apellidodocente) as nombre, g.maximogrupo, 
			g.maximogrupoelectiva, g.matriculadosgrupo, g.matriculadosgrupoelectiva, g.codigoindicadorhorario
			from grupo g, docente d, horario h
			where g.numerodocumento = d.numerodocumento
			and g.codigomateria = '$codigomateria'
			and g.codigoperiodo = '$codigoperiodo'
			and g.codigoestadogrupo = '10'
			and g.codigoindicadorhorario = '100'
			and h.idgrupo = g.idgrupo
			and (h.horafinal <= '16:00:00' or h.codigodia = '6' or h.codigodia = '7')";
			$datosgrupos=mysql_query($query_datosgrupos, $sala) or die("$query_datosgrupos");
			$totalRows_datosgrupos = mysql_num_rows($datosgrupos);
		}
		if($jornada == '02')
		{
			$query_datosgrupos = "select distinct g.idgrupo, concat(d.nombredocente,' ',d.apellidodocente) as nombre, g.maximogrupo, 
			g.maximogrupoelectiva, g.matriculadosgrupo, g.matriculadosgrupoelectiva, g.codigoindicadorhorario
			from grupo g, docente d, horario h
			where g.numerodocumento = d.numerodocumento
			and g.codigomateria = '$codigomateria'
			and g.codigoperiodo = '$codigoperiodo'
			and g.codigoestadogrupo = '10'
			and g.codigoindicadorhorario = '100'
			and h.idgrupo = g.idgrupo
			and (h.horainicial >= '16:00:00' or h.codigodia = '6' or h.codigodia = '7')";
			$datosgrupos=mysql_query($query_datosgrupos, $sala) or die("$query_datosgrupos");
			$totalRows_datosgrupos = mysql_num_rows($datosgrupos);
		}
		//echo $query_datosgrupos."<br>";
		//echo "$totalRows_datosgrupos <br>";
		// Los arrglos de grupos se crean con cupo y activos
		if($totalRows_datosgrupos != "")
		{
			$keygrupo = 0;
			while($row_datosgrupos = mysql_fetch_array($datosgrupos))
			{
				// Si hay cupo inicializa el arreglo de grupos
				//echo "if(".$row_datosgrupos['maximogrupo']." < (".$row_datosgrupos['matriculadosgrupoelectiva']." + ".$row_datosgrupos['matriculadosgrupo']."))<br>";
				if($row_datosgrupos['maximogrupo'] > ($row_datosgrupos['matriculadosgrupoelectiva'] + $row_datosgrupos['matriculadosgrupo']))
				{
					// Arreglo de grupos inicializados
					${$numeromateria}[$row_datosgrupos['idgrupo']][$keygrupo] = "0";
					//echo "$$numeromateria","[",$row_datosgrupos['idgrupo'],"][$keygrupo] = 0 &nbsp;";
					$keygrupo++;
				}
			}
		}
		
		// Aca selecciona los grupos que no necesiten horario por lo tanto funciona para las dos jornadas
		$query_datosgrupos = "select distinct g.idgrupo, concat(d.nombredocente,' ',d.apellidodocente) as nombre, g.maximogrupo, 
		g.maximogrupoelectiva, g.matriculadosgrupo, g.matriculadosgrupoelectiva, g.codigoindicadorhorario
		from grupo g, docente d
		where g.numerodocumento = d.numerodocumento
		and g.codigomateria = '$codigomateria'
		and g.codigoperiodo = '$codigoperiodo'
		and g.codigoestadogrupo = '10'
		and g.codigoindicadorhorario = '200'";
		$datosgrupos=mysql_query($query_datosgrupos, $sala) or die("$query_datosgrupos");
		$totalRows_datosgrupos = mysql_num_rows($datosgrupos);
		
		//echo $query_datosgrupos."<br>";
		//echo "$totalRows_datosgrupos <br>";
		// Los arrglos de grupos se crean con cupo y activos
		if($totalRows_datosgrupos != "")
		{
			$keygrupo = 0;
			while($row_datosgrupos = mysql_fetch_array($datosgrupos))
			{
				// Si hay cupo inicializa el arreglo de grupos
				//echo "if(".$row_datosgrupos['maximogrupo']." < (".$row_datosgrupos['matriculadosgrupoelectiva']." + ".$row_datosgrupos['matriculadosgrupo']."))<br>";
				if($row_datosgrupos['maximogrupo'] > ($row_datosgrupos['matriculadosgrupoelectiva'] + $row_datosgrupos['matriculadosgrupo']))
				{
					// Arreglo de grupos inicializados
					${$numeromateria}[$row_datosgrupos['idgrupo']][$keygrupo] = "0";
					//echo "$$numeromateria","[",$row_datosgrupos['idgrupo'],"][$keygrupo] = 0 &nbsp;";
					$keygrupo++;
				}
			}
		}
		$numeromateria++;
		
		
		// Por ultimo selecciona los grupos que no tienen horarios
	}
	
	$totalmaterias = $numeromateria - 1;
	$numeromateria = $totalmaterias;
	// Este foreach crea la estructura de datos deseada
	// Asigna a cada grupo un nuevo arreglo
	// Toca voltear el arreglo materias y asignar del ultimo areglo al primero.
	$materiasreversa = array_reverse($materias); 
	
	foreach($materiasreversa as $llave1 => $codigomateria)
	{
		//echo "$llave1 => $codigomateria <br>";
		// Selecciona los grupos de acuerdo a la jornada del estudiante, estos dos querys los toma para los grupos que necesitan horario y que tengan
		if($jornada == '01')
		{
			$query_datosgrupos = "select distinct g.idgrupo, concat(d.nombredocente,' ',d.apellidodocente) as nombre, g.maximogrupo, 
			g.maximogrupoelectiva, g.matriculadosgrupo, g.matriculadosgrupoelectiva, g.codigoindicadorhorario
			from grupo g, docente d, horario h
			where g.numerodocumento = d.numerodocumento
			and g.codigomateria = '$codigomateria'
			and g.codigoperiodo = '$codigoperiodo'
			and g.codigoestadogrupo = '10'
			and g.codigoindicadorhorario = '100'
			and h.idgrupo = g.idgrupo
			and (h.horafinal <= '16:00:00' or h.codigodia = '6' or h.codigodia = '7')";
			$datosgrupos=mysql_query($query_datosgrupos, $sala) or die("$query_datosgrupos");
			$totalRows_datosgrupos = mysql_num_rows($datosgrupos);
		}
		if($jornada == '02')
		{
			$query_datosgrupos = "select distinct g.idgrupo, concat(d.nombredocente,' ',d.apellidodocente) as nombre, g.maximogrupo, 
			g.maximogrupoelectiva, g.matriculadosgrupo, g.matriculadosgrupoelectiva, g.codigoindicadorhorario
			from grupo g, docente d, horario h
			where g.numerodocumento = d.numerodocumento
			and g.codigomateria = '$codigomateria'
			and g.codigoperiodo = '$codigoperiodo'
			and g.codigoestadogrupo = '10'
			and g.codigoindicadorhorario = '100'
			and h.idgrupo = g.idgrupo
			and (h.horainicial >= '16:00:00' or h.codigodia = '6' or h.codigodia = '7')";
			$datosgrupos=mysql_query($query_datosgrupos, $sala) or die("$query_datosgrupos");
			$totalRows_datosgrupos = mysql_num_rows($datosgrupos);
		}
		if($totalRows_datosgrupos != "")
		{
			$keygrupo = 0;
			
			while($row_datosgrupos = mysql_fetch_array($datosgrupos))
			{
				// Si hay cupo crea el arbol
				if($row_datosgrupos['maximogrupo'] > ($row_datosgrupos['matriculadosgrupoelectiva'] + $row_datosgrupos['matriculadosgrupo']))
				{
					// Al arreglo con el codigo de la materia como nombre le asigno el idgrupo
					// Arreglo de grupos inicializados
					//echo "$nummateria = 0; $nummateria <= $totalmaterias <br>";
					$numsiguiente = $numeromateria + 1;
					// Si existe el siguiente arreglo
					if(isset(${$numsiguiente}))
					{
						${$numeromateria}[$row_datosgrupos['idgrupo']][$keygrupo] = ${$numsiguiente};
						//echo "${$numeromateria}"."[".$row_datosgrupos['idgrupo']."][$keygrupo] = ${$numsiguiente}<br>";
						//echo "$$numeromateria"."[".$row_datosgrupos['idgrupo']."][$keygrupo] = $$numsiguiente<br>";
					}
					else
					{
						//echo "No existe $$numsiguiente ";
					}
					$keygrupo++;
				}
			}
		}
		
		// Y este es para los grupos que no necesitan horarios		
		$query_datosgrupos = "select g.idgrupo, concat(d.nombredocente,' ',d.apellidodocente) as nombre, g.maximogrupo, 
		g.maximogrupoelectiva, g.matriculadosgrupo, g.matriculadosgrupoelectiva, g.codigoindicadorhorario 
		from grupo g, docente d
		where g.numerodocumento = d.numerodocumento
		and g.codigomateria = '$codigomateria'
		and g.codigoperiodo = '$codigoperiodo'
		and g.codigoestadogrupo = '10'
		and g.codigoindicadorhorario = '200'";
		$datosgrupos=mysql_query($query_datosgrupos, $sala) or die("$query_datosgrupos");
		$totalRows_datosgrupos = mysql_num_rows($datosgrupos);
		//echo "$query_datosgrupos <br>";
		//echo "$totalRows_datosgrupos <br>";
		//echo "<br>";
		if($totalRows_datosgrupos != "")
		{
			//$keygrupo = 0;
			
			while($row_datosgrupos = mysql_fetch_array($datosgrupos))
			{
				// Si hay cupo crea el arbol
				if($row_datosgrupos['maximogrupo'] > ($row_datosgrupos['matriculadosgrupoelectiva'] + $row_datosgrupos['matriculadosgrupo']))
				{
					// Al arreglo con el codigo de la materia como nombre le asigno el idgrupo
					// Arreglo de grupos inicializados
					//echo "$nummateria = 0; $nummateria <= $totalmaterias <br>";
					$numsiguiente = $numeromateria + 1;
					// Si existe el siguiente arreglo
					if(isset(${$numsiguiente}))
					{
						${$numeromateria}[$row_datosgrupos['idgrupo']][$keygrupo] = ${$numsiguiente};
						//echo "${$numeromateria}"."[".$row_datosgrupos['idgrupo']."][$keygrupo] = ${$numsiguiente}<br>";
						//echo "$$numeromateria"."[".$row_datosgrupos['idgrupo']."][$keygrupo] = $$numsiguiente<br>";
					}
					else
					{
						//echo "No existe $$numsiguiente ";
					}
					$keygrupo++;
				}
			}
		}
		$numeromateria--;
	}
	
	$raiz = 0;
	//echo "recorrearbol($$raiz, &$gruposelegidos, $sala)<br>";
	if(!recorrearbol(${$raiz}, &$gruposelegidos, $codigoperiodo, $sala))
	{
		return false;
	}
	else
	{
		return $gruposelegidos;
	}
	
	
	//echo ${$numeromateria}[2310][0]."QUEEE?<br>";
	//print_r($$numeromateria[2310][0]);
	//echo "QUEEE?<br>";
}

?>