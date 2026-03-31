<?php
session_start();
require_once('../../../Connections/sala2.php');
//require_once('seguridadlistadogeneralestudiantes.php');
//require_once('Connections/sala.php');
$porfacultad = false;
$porsemestre = false;
$porestudiante = false;
mysql_select_db($database_sala, $sala);
$concarrera = false;
//$_SESSION['codigofacultad'] = 700;
$codigoperiodo = $_SESSION['codigoperiodosesion'];


  $usuario = $_SESSION['MM_Username'];
 
  mysql_select_db($database_sala, $sala);
  $query_tipousuario = "SELECT * from usuariofacultad where usuario = '".$usuario."'";
  $tipousuario = mysql_query($query_tipousuario, $sala) or die(mysql_error());
  $row_tipousuario = mysql_fetch_assoc($tipousuario);
  $totalRows_tipousuario = mysql_num_rows($tipousuario);



if(isset($_GET['corte']))
{
	$corte1= $_GET['corte'];
}
if($row_tipousuario['codigotipousuariofacultad'] <> 200)
{
	//echo $codigocarrera;
	$codigocarrera = $_SESSION['codigofacultad'];
	/**************** COMENTAR ******************/
	
	//$codigocarrera = 705;
	//	$concarrera = "";
	$concarrera = true;
}
//echo $codigocarrera;
foreach($_GET as $key => $value)
{
	if(ereg("^codestudiante",$key))
	{
		$porestudiante = true;
		//echo $_GET[$key]."<br>";
		$codigoestudiante[] = $_GET[$key];
	}
}
if(isset($_GET['semestre']))
{
	$porsemestre = true;
	$semestreinicial = $_GET['semestre'];
	// Este query retorna los estudiantes que tienen prematricula
	if($concarrera)
	{
		$query_semestre = "SELECT e.codigoestudiante, concat(eg.apellidosestudiantegeneral,' ',eg.nombresestudiantegeneral) as nombre, 
		s.nombresituacioncarreraestudiante,eg.numerodocumento
		FROM estudiante e, prematricula p, situacioncarreraestudiante s,ordenpago o,estudiantegeneral eg
		where e.codigocarrera = '$codigocarrera'
		and e.idestudiantegeneral = eg.idestudiantegeneral
		and e.codigosituacioncarreraestudiante = s.codigosituacioncarreraestudiante
		and p.codigoestudiante = e.codigoestudiante
		and p.semestreprematricula = '$semestreinicial'
		and (p.codigoestadoprematricula like '1%' or p.codigoestadoprematricula like '4%')
		and (o.codigoestadoordenpago like '1%' or o.codigoestadoordenpago like '4%')
		and o.codigoestudiante = e.codigoestudiante
		and p.codigoperiodo = '$codigoperiodo'
		and o.codigoperiodo = p.codigoperiodo
		order by nombre";
		//and e.codigosituacioncarreraestudiante not like '1%'
		//and e.codigosituacioncarreraestudiante not like '5%'
	}
	if(!$concarrera)
	{
		$query_semestre = "SELECT e.codigoestudiante, concat(eg.apellidosestudiantegeneral,' ',eg.nombresestudiantegeneral) as nombre, 
		s.nombresituacioncarreraestudiante,eg.numerodocumento
		FROM estudiante e, prematricula p, situacioncarreraestudiante s, ordenpago o,estudiantegeneral eg
		where p.codigoestudiante = e.codigoestudiante
		and e.idestudiantegeneral = eg.idestudiantegeneral
		and e.codigosituacioncarreraestudiante = s.codigosituacioncarreraestudiante
		and p.semestreprematricula = '$semestreinicial'
		and (p.codigoestadoprematricula like '1%' or p.codigoestadoprematricula like '4%')
		and p.codigoperiodo = '$codigoperiodo'
		and (o.codigoestadoordenpago like '1%' or o.codigoestadoordenpago like '4%')
		and o.codigoestudiante = e.codigoestudiante
		and o.codigoperiodo = p.codigoperiodo
		order by nombre";
		//and e.codigosituacioncarreraestudiante not like '1%'
		//and e.codigosituacioncarreraestudiante not like '5%'
	}

    $semestre1 = mysql_query($query_semestre, $sala) or die(mysql_error());
	$total_semestre = mysql_num_rows($semestre1);
	// Si el estudiante tiene prematricula activa y alguna orden de pago activa le muestra los datos
	if($total_semestre != "")
	{
		while($row_semestre = mysql_fetch_assoc($semestre1))
		{
				$codigoestudiante[] = $row_semestre['codigoestudiante'];
		}
	}
}
if(isset($_GET['facultad']))
{
	$porfacultad = true;
	$semestreinicial = $_GET['semestreinicial'];
	if($concarrera)
	{
		$query_maxsemestre = "select count(d.semestredetallecohorte) as totalsemestres, max(c.numerocohorte) as totalcohortes
		from cohorte c, detallecohorte d
		where c.codigocarrera = '$codigocarrera'
		and d.idcohorte = c.idcohorte";
		$maxsemestre = mysql_query($query_maxsemestre, $sala) or die(mysql_error());
		$total_maxsemestre = mysql_num_rows($maxsemestre);
		// Si el estudiante tiene prematricula activa y alguna orden de pago activa le muestra los datos
		$row_maxsemestre = mysql_fetch_assoc($maxsemestre);
		$totalsemestres = $row_maxsemestre['totalsemestres'];
		$totalcohortes = $row_maxsemestre['totalcohortes'];
		$limitesemestre = $totalsemestres / $totalcohortes;
	}
	if(!$concarrera)
	{
		$limitesemestre = "12";
	}
	
	// Este query retorna los estudiantes que tienen prematricula
	if($concarrera)
	{
		$query_semestre = "SELECT e.codigoestudiante, concat(eg.apellidosestudiantegeneral,' ',eg.nombresestudiantegeneral) as nombre, 
		s.nombresituacioncarreraestudiante,eg.numerodocumento
		FROM estudiante e, prematricula p, situacioncarreraestudiante s, ordenpago o,estudiantegeneral eg
		where e.codigocarrera = '$codigocarrera'
		and e.idestudiantegeneral = eg.idestudiantegeneral
		and e.codigosituacioncarreraestudiante = s.codigosituacioncarreraestudiante
		and p.codigoestudiante = e.codigoestudiante
		and p.semestreprematricula = '$semestreinicial'
		and (p.codigoestadoprematricula like '1%' or p.codigoestadoprematricula like '4%')
		and p.codigoperiodo = '$codigoperiodo'
		and (o.codigoestadoordenpago like '1%' or o.codigoestadoordenpago like '4%')
		and o.codigoestudiante = e.codigoestudiante
		and o.codigoperiodo = p.codigoperiodo
		order by nombre";
	}
	if(!$concarrera)
	{
		$query_semestre = "SELECT e.codigoestudiante, concat(eg.apellidosestudiantegeneral,' ',eg.nombresestudiantegeneral) as nombre, 
		s.nombresituacioncarreraestudiante,eg.numerodocumento
		FROM estudiante e, prematricula p, situacioncarreraestudiante s, ordenpago o,estudiantegeneral eg
		where p.codigoestudiante = e.codigoestudiante
		and e.idestudiantegeneral = eg.idestudiantegeneral
		and e.codigosituacioncarreraestudiante = s.codigosituacioncarreraestudiante
		and p.semestreprematricula = '$semestreinicial'
		and (p.codigoestadoprematricula like '1%' or p.codigoestadoprematricula like '4%')
		and p.codigoperiodo = '$codigoperiodo'
		and (o.codigoestadoordenpago like '1%' or o.codigoestadoordenpago like '4%')
		and o.codigoestudiante = e.codigoestudiante
		and o.codigoperiodo = p.codigoperiodo
		order by nombre";
	}
	//echo "<br>$query_semestre";
	$semestre1 = mysql_query($query_semestre, $sala) or die(mysql_error());
	$total_semestre = mysql_num_rows($semestre1);
	// Si el estudiante tiene prematricula activa y alguna orden de pago activa le muestra los datos
	if($total_semestre != "")
	{
		while($row_semestre = mysql_fetch_assoc($semestre1))
		{
			$codigoestudiante[] = $row_semestre['codigoestudiante'];
		}
	}
}
if($porestudiante) 
{
	$ruta = "codestudiante=".$_GET['codestudiante']; 
}
else if($porsemestre) 
{
	$ruta = "semestre=".$_GET['semestre']; 
}
else if($porfacultad) 
{
	$ruta = "semestreinicial=".$_GET['semestreinicial']."&facultad";
}
?>
<html>
<style type="text/css">
/*
.Estilo1 {
	font-family: Tahoma;
	font-size: xx-small;
}
.Estilo2 {
	font-size: 14px;
	font-family: Tahoma;
}
.Estilo3 {
	font-size: 14;
	font-weight: bold;
	font-family: Tahoma;
}
.Estilo5 {font-family: Tahoma; font-weight: bold; font-size: 12; }
.Estilo6 {font-family: Tahoma}
.Estilo7 {font-family: Tahoma; font-size: xx-small; font-weight: bold; }
*/
    
</style>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Mostrar listado</title>
    

<?php
echo '<script language="javascript">
function cambia_tipo()
{ 
    //tomo el valor del select del tipo elegido 
    var tipo 
    tipo = document.f1.tipo[document.f1.tipo.selectedIndex].value 
    //miro a ver si el tipo está definido 
    if (tipo == 1)
	{
		window.location.reload("listadogeneralestudiantesmostrar.php?filtro=Matriculados&'.$ruta.'&corte='.$corte1.'"); 
	} 
    if (tipo == 2)
	{
		window.location.reload("listadogeneralestudiantesmostrar.php?filtro=Prematriculados&'.$ruta.'&corte='.$corte1.'"); 
	}
	if (tipo == 3)
	{
		window.location.reload("listadogeneralestudiantesmostrar.php?filtro=Ninguno&'.$ruta.'&corte='.$corte1.'"); 
	}
} 

/*function buscar()
{ 
    //tomo el valor del select del tipo elegido 
    var busca 
    busca = document.f1.busqueda[document.f1.busqueda.selectedIndex].value 
    //miro a ver si el tipo está definido 
    if (busca != 0)
	{
		window.location.reload("listadogeneralestudiantesmostrar.php?buscar="+busca'.$ruta.'&corte='.$corte1.'); 
	} 
} 
*/
</script>';
?>    
</head>

<body>
<form name="f1" action="listadogeneralestudiantesmostrar.php" method="get">
  <table width="707" border="1" cellpadding="2" cellspacing="1" bordercolor="#003333" align="center">
  <tr>
    <td width="250" bgcolor="#C5D5D6" class="Estilo5">
	  <div align="center"><span class="Estilo6">Filtrar por :</span>	      <select name="tipo" onChange="cambia_tipo()">
		    <option value="0">Seleccionar</option>
		    <option value="1">Matriculados</option>
		    <option value="2">Prematriculados</option>
		    <option value="3">Todos</option>
	        </select>
&nbsp;	</div></td>
	<td class="Estilo1">&nbsp;
        

<?php
if(isset($_GET['filtro']))
{
	if($_GET['filtro']=="Matriculados")
	{
		$_SESSION['filtrado'] = "matriculados";
	}
	if($_GET['filtro']=="Prematriculados")
	{
		$_SESSION['filtrado'] = "prematriculados";
	}
	if($_GET['filtro']=="Ninguno")
	{
		$_SESSION['filtrado'] = "ninguno";
	}
?>
	</td>
  </tr>
<?php
}
?>
</table>
</form>

    <?php
/******************* PENDIENTES **********************
** 	Toca definir que periodo debe visualizarse.		**
******************************************************/
if(isset($codigoestudiante))
{
	foreach($codigoestudiante as $key => $codigo)
	{
		$codigoperiodo = $_SESSION['codigoperiodosesion'];
		$estudiante['valorpagado'] = 0;
		$estudiante['valorpendiente'] = 0;
		$estudiante['valorsemestre'] = 0;
		$estudiante['creditos'] = 0;
		$estudiante['estadoprematriculado'] = false;
		if($concarrera)
		{
			$query_datosestudiante = "select concat(eg.apellidosestudiantegeneral,' ',eg.nombresestudiantegeneral) as nombre,
			p.semestreprematricula, p.idprematricula, e.codigocarrera, s.nombresituacioncarreraestudiante,eg.numerodocumento, 
			e.codigoperiodo, e.codigojornada
			from estudiante e, prematricula p, situacioncarreraestudiante s, ordenpago o,estudiantegeneral eg
			where e.codigoestudiante = '$codigo'
			and eg.idestudiantegeneral = e.idestudiantegeneral
			and e.codigosituacioncarreraestudiante = s.codigosituacioncarreraestudiante
			and e.codigocarrera = '$codigocarrera'
			and e.codigoestudiante = p.codigoestudiante
			and (p.codigoestadoprematricula like '1%' or p.codigoestadoprematricula like '4%')
			and (o.codigoestadoordenpago like '1%' or o.codigoestadoordenpago like '4%')
			and o.codigoestudiante = e.codigoestudiante
			and o.codigoperiodo = p.codigoperiodo
			and p.codigoperiodo = '$codigoperiodo'";
		}
		if(!$concarrera)
		{
			$query_datosestudiante = "select concat(eg.apellidosestudiantegeneral,' ',eg.nombresestudiantegeneral) as nombre,
			p.semestreprematricula, p.idprematricula, e.codigocarrera, s.nombresituacioncarreraestudiante,eg.numerodocumento, 
			e.codigoperiodo, e.codigojornada
			from estudiante e, prematricula p, periodo per, situacioncarreraestudiante s, ordenpago o,estudiantegeneral eg
			where e.codigoestudiante = '$codigo'
			and eg.idestudiantegeneral = e.idestudiantegeneral
			and e.codigosituacioncarreraestudiante = s.codigosituacioncarreraestudiante
			and e.codigoestudiante = p.codigoestudiante
			and (p.codigoestadoprematricula like '1%' or p.codigoestadoprematricula like '4%')
			and p.codigoperiodo = '$codigoperiodo'
			and (o.codigoestadoordenpago like '1%' or o.codigoestadoordenpago like '4%')
			and o.codigoperiodo = p.codigoperiodo
			and o.codigoestudiante = e.codigoestudiante";
		}
		
		$datosestudiante = mysql_query($query_datosestudiante, $sala) or die(mysql_error());
		$total_datosestudiante = mysql_num_rows($datosestudiante);
		// Si el estudiante tiene prematricula activa y alguna orden de pago activa le muestra los datos
		if($total_datosestudiante != "")
		{
			$row_datosestudiante = mysql_fetch_assoc($datosestudiante);
			$codigojornada = $row_datosestudiante['codigojornada'];
			$codigoperiodoestudiante = $row_datosestudiante['codigoperiodo'];
			$estudiante['nombre'] = $row_datosestudiante['nombre']; 
			$estudiante['semestre'] = $row_datosestudiante['semestreprematricula']; 
			$estudiante['tieneprematricula'] = true; 
			$estudiante['pertenececarrera'] = true;
			$idprematricula = $row_datosestudiante['idprematricula'];
			$codigocarrera = $row_datosestudiante['codigocarrera']; 
			$estudiante['nombresituacioncarreraestudiante'] = $row_datosestudiante['nombresituacioncarreraestudiante']; 
			
			$query_datosordenpago = "select distinct do.numeroordenpago, do.valorconcepto, o.codigoestadoordenpago
			from detalleprematricula d, ordenpago o, detalleordenpago do
			where d.idprematricula = '$idprematricula'
			and d.numeroordenpago = o.numeroordenpago
			and o.numeroordenpago = do.numeroordenpago
			and (d.codigoestadodetalleprematricula like '1%' or d.codigoestadodetalleprematricula like '3%')
			and (o.codigoestadoordenpago like '1%' or o.codigoestadoordenpago like '4%')
			and do.codigoconcepto = '151'";
			//and m.codigocarrera = '$carrera'
			//echo "<br>$codigo<br>$query_datosordenpago<br>";
			$datosordenpago = mysql_query($query_datosordenpago, $sala) or die(mysql_error());
			$total_datosordenpago = mysql_num_rows($datosordenpago);
			// Si el estudiante tiene registros en detalle prematricula le muestra las materias
			if($total_datosordenpago != "")
			{
				$estudiante['tieneorden'] = true; 
				$entroorden = false;
				$estudiante['estadoprematriculado'] = true;
				$quitarodenes = "";
				while($row_datosordenpago = mysql_fetch_assoc($datosordenpago))
				{
					$quitarodenes .= "$quitarordenes and o.numeroordenpago <> '".$row_datosordenpago['numeroordenpago']."'";
					$codigoestadoordenpago = $row_datosordenpago['codigoestadoordenpago'];
					$valorconcepto = $row_datosordenpago['valorconcepto'];
					if(ereg("^1[0-9]{1}$",$codigoestadoordenpago))
					{
						$estudiante['valorpendiente'] = $estudiante['valorpendiente'] + $valorconcepto;
					}
					if(ereg("^4[0-9]{1}$",$codigoestadoordenpago))
					{
						$estudiante['valorpagado'] = $estudiante['valorpagado'] + $valorconcepto;
						$estudiante['estadoprematriculado'] = false;
						//echo "<h1>$quitarodenes".$estudiante['valorpagado']."</h1>";
					}
				}
                /*
                 * Caso 100539
                 * @modified Luis Dario Gualteros <castroluisd@unbosque.edu.co>
                 * Ajuste de consulta para que consulte los nuevos campos para la consulta (grupo y docente) de cada materia.
                 * @since Mayo 11, 2018.
                */     
		      
                $query_datosasignaturas = "SELECT DISTINCT
                        m.codigomateria,
                        m.nombremateria,
                        est.codigoestadodetalleprematricula,
                        est.nombreestadodetalleprematricula,
                        d.idgrupo,
                        g.nombregrupo,
                        g.numerodocumento AS documentoDocente,
                        concat(
                            doc.apellidodocente,
                            ' ',
                            doc.nombredocente
                        ) AS nombreDocente
                    FROM
                        prematricula p
                        INNER JOIN detalleprematricula d ON p.idprematricula = d.idprematricula
                        INNER JOIN estadodetalleprematricula est ON d.codigoestadodetalleprematricula = est.codigoestadodetalleprematricula
                        INNER JOIN materia m ON d.codigomateria = m.codigomateria
                        INNER JOIN grupo g ON d.idgrupo = g.idgrupo
                        INNER JOIN docente doc ON g.numerodocumento = doc.numerodocumento
                    WHERE
                        p.idprematricula = '$idprematricula'
                    AND (
                        d.codigoestadodetalleprematricula LIKE '1%'
                        OR d.codigoestadodetalleprematricula LIKE '3%'
                    )
                    AND p.codigoperiodo = '$codigoperiodo'
                    ORDER BY
                        nombremateria";
				
				$datosasignaturas = mysql_query($query_datosasignaturas, $sala) or die(mysql_error());
				$total_datosasignaturas = mysql_num_rows($datosasignaturas);
				// Si el estudiante tiene registros en detalle prematricula le muestra las materias
				if($total_datosasignaturas != "")
				{
					$estudiante['tieneasignaturas'] = false;
					//$estudiante['estadoprematriculado'] = true;
					$query_datosordenpago2 = "select do.numeroordenpago, do.valorconcepto, o.codigoestadoordenpago 
					from ordenpago o, detalleordenpago do
					where o.codigoestudiante = '$codigo'
					and o.numeroordenpago = do.numeroordenpago 
					and (o.codigoestadoordenpago like '1%' or o.codigoestadoordenpago like '4%') 
					and do.codigoconcepto = '151'
					and o.codigoperiodo = '$codigoperiodo'
					$quitarodenes";
				
				    $datosordenpago2 = mysql_query($query_datosordenpago2, $sala) or die(mysql_error());
					$total_datosordenpago2 = mysql_num_rows($datosordenpago2);
					// Si el estudiante tiene registros en detalle prematricula le muestra las materias
					if($total_datosordenpago2 != "")
					{
						$estudiante['tieneorden'] = true; 
						while($row_datosordenpago2 = mysql_fetch_assoc($datosordenpago2))
						{
							$codigoestadoordenpago = $row_datosordenpago2['codigoestadoordenpago'];
							$valorconcepto = $row_datosordenpago2['valorconcepto'];
							if(ereg("^1[0-9]{1}$",$codigoestadoordenpago))
							{
								$estudiante['valorpendiente'] = $estudiante['valorpendiente'] + $valorconcepto;
							}
							if(ereg("^4[0-9]{1}$",$codigoestadoordenpago))
							{
								$estudiante['valorpagado'] = $estudiante['valorpagado'] + $valorconcepto;
								$estudiante['estadoprematriculado'] = false;
                            }
						}
					}
					//$row_datosasignaturas = mysql_fetch_assoc($datosasignaturas);
					$estudiante['tieneasignaturas'] = true;
					$estudiante['numeromaterias'] = $total_datosasignaturas; 
					//echo "<br>".$estudiante['nombre']."<br>";
					while($row_datosasignaturas = mysql_fetch_assoc($datosasignaturas))
					{
						$materia['nombremateria'] = $row_datosasignaturas['nombremateria'];
						$materia['nombreestadodetalleprematricula'] = $row_datosasignaturas['nombreestadodetalleprematricula'];
                        /*
                         * Caso 100539
                         * @modified Luis Dario Gualteros <castroluisd@unbosque.edu.co>
                         * Ajuste para nuevos campos de la consulta (grupo y docente) de cada materia.
                         * @since Mayo 11, 2018.
                        */     
                            $materia['idgrupo'] = $row_datosasignaturas['idgrupo'];
                            $materia['nombregrupo'] = $row_datosasignaturas['nombregrupo'];
                        
                           /*
                             * Caso 100700
                             * @modified Luis Dario Gualteros <castroluisd@unbosque.edu.co>
                             * Ajuste de consulta para que consulte los nuevos campos para la consulta (dias de clase y horario) de cada materia.
                             * @since Mayo 18, 2018.
                           */
                            //Consulta de horarios y dias de clase con base en el id de Grupo.
                            $query_horario = "SELECT d.nombredia, h.horainicial, h.horafinal
                                FROM horario h
                                INNER JOIN dia d ON h.codigodia = d.codigodia
                                WHERE 
                                h.codigoestado = 100
                                AND h.idgrupo = '". $materia['idgrupo']."'";                                            
                        
                            $horarios = mysql_query($query_horario, $sala) or die("Error en la consulta de horarios...");
                            $contador = mysql_num_rows($horarios);
                           //Creación y Organización de la lista de los dias y el horario de clase.
                           if($contador > 0){

                                $ul="<ul style='float:left;'>";
                                $ulhi="<ul style='float:left;'>"; 
                                $ulhf="<ul style='float:left;'>"; 

                                while($row_horarios = mysql_fetch_assoc($horarios)){

                                    $ul.="<li>".$row_horarios['nombredia']."</li>";
                                    $ulhi.="<li>".$row_horarios['horainicial']."</li>";
                                    $ulhf.="<li>".$row_horarios['horafinal']."</li>";

                                }
                            $ul.="</ul>";  $ulhi.="</ul>";  $ulhf.="</ul>"; 

                            $materia['nombredia'] = $ul;
                            $materia['horainicial'] = $ulhi;
                            $materia['horafinal'] = $ulhf;
                        }else{
                               
                            $materia['nombredia'] = "Sin Horario";
                            $materia['horainicial'] = "Sin Horario";
                            $materia['horafinal'] = "Sin Horario";
                        }
                        //End Caso 100700
                        $materia['documentoDocente'] = $row_datosasignaturas['documentoDocente'];
                        $materia['nombreDocente'] = $row_datosasignaturas['nombreDocente'];
                        //End Caso 100539
						
                       
                        
						$query_notamateria = "select m.nombremateria,dn.nota from  
                        materia m,detallenota dn,corte c,grupo g
						where m.codigomateria = ".$row_datosasignaturas['codigomateria']."
						and m.codigomateria = g.codigomateria 
						and g.idgrupo = ".$row_datosasignaturas['idgrupo']."
						AND dn.codigoestudiante = '$codigo'
						and dn.idgrupo = g.idgrupo
						and c.numerocorte = '$corte1'
						and c.idcorte = dn.idcorte
												";
						//echo $query_notamateria ,"</br>";
						$notamateria = mysql_query($query_notamateria, $sala) or die("$query_notamateria");
						$row_notamateria = mysql_fetch_assoc($notamateria);	
						if ($row_notamateria <> "")
						{
							$materia['nota'] = $row_notamateria['nota'];
						}
						else
						{
							$materia['nota'] = "Sin nota";
						}
						//dario
						$asignaturas[$row_datosasignaturas['codigomateria']] = $materia;
					}
					$estudiante['materias'] = $asignaturas;
					$usarcondetalleprematricula = true;
					$codigoestudiante = $codigo;
					require("calculocreditossemestre.php");
					//$estudiante['semestre'] = $semestreactual;
					$estudiante['creditos'] = $creditos;
					$tomarcreditos[$estudiante['creditos']] = $tomarcreditos[$estudiante['creditos']] + $estudiante['creditos'];
				}
				else
				{
					$estudiante['tieneasignaturas'] = false;
					$estudiante['estadoprematriculado'] = true;
					$query_datosordenpago2 = "select do.numeroordenpago, do.valorconcepto, o.codigoestadoordenpago 
					from ordenpago o, detalleordenpago do
					where o.codigoestudiante = '$codigo'
					and o.numeroordenpago = do.numeroordenpago 
					and (o.codigoestadoordenpago like '1%' or o.codigoestadoordenpago like '4%') 
					and do.codigoconcepto = '151'
					and o.codigoperiodo = '$codigoperiodo'";
					//echo "$query_datosordenpago2<br>";
					//and m.codigocarrera = '$carrera'
					
					$datosordenpago2 = mysql_query($query_datosordenpago2, $sala) or die(mysql_error());
					$total_datosordenpago2 = mysql_num_rows($datosordenpago2);
					// Si el estudiante tiene registros en detalle prematricula le muestra las materias
					if($total_datosordenpago2 != "")
					{
						$estudiante['tieneorden'] = true; 
						while($row_datosordenpago2 = mysql_fetch_assoc($datosordenpago2))
						{
							$codigoestadoordenpago = $row_datosordenpago2['codigoestadoordenpago'];
							$valorconcepto = $row_datosordenpago2['valorconcepto'];
							if(ereg("^1[0-9]{1}$",$codigoestadoordenpago))
							{
								$estudiante['valorpendiente'] = $estudiante['valorpendiente'] + $valorconcepto;
							}
							if(ereg("^4[0-9]{1}$",$codigoestadoordenpago))
							{
								$estudiante['valorpagado'] = $estudiante['valorpagado'] + $valorconcepto;
								$estudiante['estadoprematriculado'] = false;
							}
						}
					}
				}
			}
			else
			{
				$estudiante['tieneasignaturas'] = false; 
				$estudiante['estadoprematriculado'] = true;
				$query_datosordenpago2 = "select do.numeroordenpago, do.valorconcepto, o.codigoestadoordenpago 
				from ordenpago o, detalleordenpago do
				where o.codigoestudiante = '$codigo'
				and o.numeroordenpago = do.numeroordenpago 
				and (o.codigoestadoordenpago like '1%' or o.codigoestadoordenpago like '4%') 
				and do.codigoconcepto = '151'
				and o.codigoperiodo = '$codigoperiodo'";
				//and m.codigocarrera = '$carrera'
				
				$datosordenpago2 = mysql_query($query_datosordenpago2, $sala) or die(mysql_error());
				$total_datosordenpago2 = mysql_num_rows($datosordenpago2);
				// Si el estudiante tiene registros en detalle prematricula le muestra las materias
				if($total_datosordenpago2 != "")
				{
					$estudiante['tieneorden'] = true; 
					while($row_datosordenpago2 = mysql_fetch_assoc($datosordenpago2))
					{
						$codigoestadoordenpago = $row_datosordenpago2['codigoestadoordenpago'];
						$valorconcepto = $row_datosordenpago2['valorconcepto'];
						if(ereg("^1[0-9]{1}$",$codigoestadoordenpago))
						{
							$estudiante['valorpendiente'] = $estudiante['valorpendiente'] + $valorconcepto;
						}
						if(ereg("^4[0-9]{1}$",$codigoestadoordenpago))
						{
							$estudiante['valorpagado'] = $estudiante['valorpagado'] + $valorconcepto;
							$estudiante['estadoprematriculado'] = false;
						}
					}
				}
				else
				{
					$estudiante['tieneorden'] = false; 
				}
			}
			// Se toma el numero de creditos del semestre
			/*$query_creditoscarrera = "select c.totalcreditossemestre
			from creditossemestrenovasoft c
			where c.codigocarrera = '$codigocarrera'
			and semestre = '".$estudiante['semestre']."'";
			$creditoscarrera = mysql_query($query_creditoscarrera, $sala) or die("<br>query_creditoscarrera: $query_creditoscarrera<br>");
			$total_creditoscarrera = mysql_num_rows($creditoscarrera);
			$row_creditoscarrera = mysql_fetch_assoc($creditoscarrera);
			$estudiante['creditossemestre'] = $row_creditoscarrera['totalcreditossemestre']; 
			*/
			
			// 4. Se toma el valor de matricula de la carrera
			$query_datocohorte = "select numerocohorte, codigoperiodoinicial, codigoperiodofinal
			from cohorte
			where codigocarrera = '$codigocarrera'
			and codigoperiodo = '$codigoperiodo'
			and codigojornada = '$codigojornada'
			and '$codigoperiodoestudiante'*1 between codigoperiodoinicial*1 and codigoperiodofinal*1";
			//echo "$query_datocohorte<br>";
			$datocohorte = mysql_db_query($database_sala,$query_datocohorte) or die("$query_datocohorte");
			$totalRows_datocohorte = mysql_num_rows($datocohorte);
			$row_datocohorte = mysql_fetch_array($datocohorte);
			$numerocohorte = $row_datocohorte['numerocohorte'];

			$query_valorcarrera = "select d.valordetallecohorte
			from cohorte c, detallecohorte d
			where c.codigocarrera = '$codigocarrera'
			and c.idcohorte = d.idcohorte
			and d.semestredetallecohorte = '".$estudiante['semestre']."'
			and c.numerocohorte = '$numerocohorte'
			and c.codigoperiodo = '$codigoperiodo'";
			$valorcarrera = mysql_query($query_valorcarrera, $sala) or die("<br>query_creditoscarrera: $query_creditoscarrera<br>");
			$total_valorcarrera = mysql_num_rows($valorcarrera);
			$row_valorcarrera = mysql_fetch_assoc($valorcarrera);
			$estudiante['valorsemestre'] = $row_valorcarrera['valordetallecohorte'];
		}
		else
		{
			// Entra si el estudiante no tiene prematricula activa
			// Se toman nuevamente los datos sin verificar las ordenes de pago y la prematricula
			$estudiante['tieneprematricula'] = false; 
			$estudiante['tieneorden'] = false; 
			$estudiante['tieneasignaturas'] = false;
			if($concarrera)
			{
				$query_datosestudiante2 = "select concat(eg.apellidosestudiantegeneral,' ',eg.nombresestudiantegeneral) as nombre,
				e.semestre, s.nombresituacioncarreraestudiante,eg.numerodocumento
				from estudiante e, situacioncarreraestudiante s,estudiantegeneral eg
				where e.codigoestudiante = '$codigo'
				and eg.idestudiantegeneral = e.idestudiantegeneral
				and e.codigosituacioncarreraestudiante = s.codigosituacioncarreraestudiante
				and e.codigocarrera = '$codigocarrera'
				and e.codigosituacioncarreraestudiante not like '1%'
				and e.codigosituacioncarreraestudiante not like '5%'";
			}else	
			if(!$concarrera)
			{
				$query_datosestudiante2 = "select concat(eg.apellidosestudiantegeneral,' ',eg.nombresestudiantegeneral) as nombre,
				e.semestre, s.nombresituacioncarreraestudiante,eg.numerodocumento
				from estudiante e, situacioncarreraestudiante s,estudiantegeneral eg
				where e.codigoestudiante = '$codigo'
				and eg.idestudiantegeneral = e.idestudiantegeneral
				and e.codigosituacioncarreraestudiante = s.codigosituacioncarreraestudiante
				and e.codigosituacioncarreraestudiante not like '1%'
				and e.codigosituacioncarreraestudiante not like '5%'";
			}
			$datosestudiante2 = mysql_query($query_datosestudiante2, $sala) or die(mysql_error());
			$total_datosestudiante2 = mysql_num_rows($datosestudiante2);
			if($total_datosestudiante2 != "")
			{
				$estudiante['pertenececarrera'] = true;
				$row_datosestudiante2 = mysql_fetch_assoc($datosestudiante2);
				$estudiante['nombre'] = $row_datosestudiante2['nombre']; 
				$estudiante['semestre'] = $row_datosestudiante2['semestre'];
				$estudiante['nombresituacioncarreraestudiante'] = $row_datosestudiante2['nombresituacioncarreraestudiante']; 
			}
			else
			{
				$estudiante['pertenececarrera'] = false;
			}
		}
		// Se guardan los datos del estudiante y de las asignaturas
		$dataestudiante[$codigo] = $estudiante;
		unset($materia);
		unset($asignaturas);
		unset($estudiante);
		if(!isset($_GET['codestudiante']))
		{
			unset($materia);
			unset($asignaturas);
			unset($estudiante);
		}
	}
	if($_SESSION['filtrado']=="ninguno")
	{
?>
    
    	<h3 align="center" class="Estilo2">TODOS LOS ESTUDIANTES</h3>
    
    <?php
	}
	if($_SESSION['filtrado']=="prematriculados")
	{
?>
	<h3 align="center" class="Estilo2">ESTUDIANTES PREMATRICULADOS</h3>
<?php
	}
	if($_SESSION['filtrado']=="matriculados")
	{
?>
	<h3 align="center" class="Estilo2">ESTUDIANTES MATRICULADOS</h3>
<?php
	}
?>
    
    	<table width="700" border="1" cellpadding="2" cellspacing="1" bordercolor="#003333" align="center">
	  <tr bgcolor="#C5D5D6">
		<td align="center" class="Estilo1" colspan="7"><strong>Estudiante</strong></td>
		<td align="center" class="Estilo1" colspan="3"><strong>Concepto Matricula</strong></td>
		<td align="center" class="Estilo1" colspan="11"><strong>Asignaturas</strong></td>
	  </tr>
	  <tr bgcolor="#C5D5D6">
		<td align="center" class="Estilo7">N°</td>
		<td align="center" class="Estilo1"><strong>Documento Estudiante</strong></td>
		<td align="center" class="Estilo1"><strong>Nombre Estudiante</strong></td>
		<td align="center" class="Estilo1"><strong>Estado</strong></td>
		<td align="center" class="Estilo1"><strong>Sem.</strong></td>
		<td align="center" class="Estilo1"><strong>Cred. Inscritos</strong></td>
		<td align="center" class="Estilo1"><strong>Cred. Semestre</strong></td>
		<td align="center" class="Estilo1"><strong>Valor Pagado </strong></td>
		<td align="center" class="Estilo1"><strong>Valor Pendiente</strong></td>
		<td align="center" class="Estilo1"><strong>Valor Semestre</strong></td>
	<!--
     * Caso 100700
     * @modified Luis Dario Gualteros <castroluisd@unbosque.edu.co>
     * Ajuste para nuevos campos de la consulta (dia, horario, grupo y docente) de cada materia.
     * @since Mayo 18, 2018.
    -->	
        <td align="center" class="Estilo1"><strong>Código Grupo</strong></td>
		<td align="center" class="Estilo1"><strong>Nombre Grupo</strong></td>
		<td align="center" class="Estilo1"><strong>Dia Clase</strong></td>
		<td align="center" class="Estilo1"><strong>Hora Inicial</strong></td>
		<td align="center" class="Estilo1"><strong>Hora Final</strong></td>
		<td align="center" class="Estilo1"><strong>Documento Docente</strong></td>
		<td align="center" class="Estilo1"><strong>Nombre Docente</strong></td>
  <!--End Caso 100700-->      
		<td align="center" class="Estilo1"><strong>Código Materia</strong></td>
		<td align="center" class="Estilo1"><strong>Nombre Materia</strong></td>
		<td align="center" class="Estilo1"><strong>Estado</strong></td>
		<td align="center" class="Estilo1"><strong>Nota</strong></td>
	  </tr>
            
	<?php
	$hayprematriculados = false;
	$haymatriculados = false;
	
	if($tomarcreditos != "")
	{
		$maximocreditos = max($tomarcreditos);
		$res_cred = array_keys($tomarcreditos, $maximocreditos);
	}
	else
	{
		$maximocreditos = 0;
		$res_cred = 0;
	}
	$cuentaestudiantes = 0;
	$cuentamatriculados = 0;
	$cuentaprematriculados = 0;
	$pagado = 0;
	$pendiente = 0;
	$contador = 0;
	foreach($dataestudiante as $codigo1 => $estudiante1)
	{
		$cuentaestudiantes++;
		if($estudiante1['estadoprematriculado'])
		{
			$cuentaprematriculados++;
		}
		else
		{
			$cuentamatriculados++;
		}
		// Calculo de los creditos del semestre
		$query_seltotalcreditossemestre = "select sum(d.numerocreditosdetalleplanestudio) as totalcreditossemestre, d.idplanestudio
		from detalleplanestudio d, planestudioestudiante p
		where d.idplanestudio = p.idplanestudio
		and p.codigoestudiante = '$codigo1'
		and d.semestredetalleplanestudio = '".$estudiante1['semestre']."'
		and p.codigoestadoplanestudioestudiante like '1%'
		and d.codigotipomateria not like '4'
		group by 2 ";
		$seltotalcreditossemestre = mysql_db_query($database_sala,$query_seltotalcreditossemestre) or die("$query_seltotalcreditossemestre");
		$totalRows_seltotalcreditossemestre = mysql_num_rows($seltotalcreditossemestre);
		$row_seltotalcreditossemestre = mysql_fetch_array($seltotalcreditossemestre);
		$estudiante1['creditossemestre'] = $row_seltotalcreditossemestre['totalcreditossemestre'];
        
		//$estudiante1['creditossemestre'] = $res_cred[0];
		if($_SESSION['filtrado'] == "ninguno")
		{
			$numero = $estudiante1['numeromaterias'];
			$pagado += $estudiante1['valorpagado'];
			$pendiente += $estudiante1['valorpendiente'];
			if($estudiante1['pertenececarrera'] && $estudiante1['tieneprematricula'] && $estudiante1['tieneasignaturas'])
			{	
				$contador++;
				 
				 $query_study = "select eg.numerodocumento
				                 from estudiante e,estudiantegeneral eg
								 where e.idestudiantegeneral = eg.idestudiantegeneral 
								 and e.codigoestudiante = '$codigo1'";
				$study = mysql_db_query($database_sala,$query_study) or die("$query_seltotalcreditossemestre");
				$totalRows_study = mysql_num_rows($study);
				$row_study = mysql_fetch_array($study); 
				$numerodocumento = $row_study['numerodocumento'];
				echo "<tr>
				<td align='center' class='Estilo1' rowspan='".$numero."'>$contador</td>
				<td align='center' class='Estilo1' rowspan='".$numero."'>$numerodocumento</td>
				<td align='center' class='Estilo1' rowspan='".$numero."'>".$estudiante1['nombre']."</td>
				<td align='center' class='Estilo1' rowspan='".$numero."'>".$estudiante1['nombresituacioncarreraestudiante']."</td>
				<td align='center' class='Estilo1' rowspan='".$numero."'>".$estudiante1['semestre']."</td>
				<td align='center' class='Estilo1' rowspan='".$numero."'>".$estudiante1['creditos']."</td>
				<td align='center' class='Estilo1' rowspan='".$numero."'>".$estudiante1['creditossemestre']."</td>
				<td align='center' class='Estilo1' rowspan='".$numero."'>".$estudiante1['valorpagado']."</td>
				<td align='center' class='Estilo1' rowspan='".$numero."'>".$estudiante1['valorpendiente']."</td>
				<td align='center' class='Estilo1' rowspan='".$numero."'>".$estudiante1['valorsemestre']."</td>";
				$asignaturas1 = $estudiante1['materias'];
                
                $cuenta = 1;
				foreach($asignaturas1 as $codigomateria => $materia1)
				{
					if($cuenta == 1)
					{
                    /*
                     * Caso 100700
                     * @modified Luis Dario Gualteros <castroluisd@unbosque.edu.co>
                     * Ajuste para nuevos campos de la consulta (dia, horario, grupo y docente) de cada materia.
                     * @since Mayo 18, 2018.    
                    */
						echo "<td align='center' class='Estilo1'>".$materia1['idgrupo']."</td>
                        <td align='center' class='Estilo1'>".$materia1['nombregrupo']."</td>
                        <td align='center' class='Estilo1'>".$materia1['nombredia']."</td>    
						<td align='center' class='Estilo1'>".$materia1['horainicial']."</td>    
						<td align='center' class='Estilo1'>".$materia1['horafinal']."</td>    
                        <td align='center' class='Estilo1'>".$materia1['documentoDocente']."</td>
                        <td align='center' class='Estilo1'>".$materia1['nombreDocente']."</td>
                        <td align='center' class='Estilo1'>$codigomateria</td>
						<td align='center' class='Estilo1'>".$materia1['nombremateria']."</td>
						<td align='center' class='Estilo1'>".$materia1['nombreestadodetalleprematricula']."</td>
						<td align='center' class='Estilo1'>".$materia1['nota']."</td>
						</tr>";
						$cuenta++;
					}
					else
					{
                   /*
                     * Caso 100700
                     * @modified Luis Dario Gualteros <castroluisd@unbosque.edu.co>
                     * Ajuste para nuevos campos de la consulta (dia, horario, grupo y docente) de cada materia.
                     * @since Mayo 18, 2018.    
                    */
						echo "<tr>
						<td align='center' class='Estilo1'>".$materia1['idgrupo']."</td>    
						<td align='center' class='Estilo1'>".$materia1['nombregrupo']."</td>    
				        <td align='center' class='Estilo1'>".$materia1['nombredia']."</td>    
						<td align='center' class='Estilo1'>".$materia1['horainicial']."</td>    
						<td align='center' class='Estilo1'>".$materia1['horafinal']."</td>    
						<td align='center' class='Estilo1'>".$materia1['documentoDocente']."</td>    
						<td align='center' class='Estilo1'>".$materia1['nombreDocente']."</td>    
						<td align='center' class='Estilo1'>$codigomateria</td>
						<td align='center' class='Estilo1'>".$materia1['nombremateria']."</td>
						<td align='center' class='Estilo1'>".$materia1['nombreestadodetalleprematricula']."</td>
						<td align='center' class='Estilo1'>".$materia1['nota']."</td>
						</tr>";
					}
				}
				echo "</tr>";
			}
            
			else
			{
				if($estudiante1['pertenececarrera'])
				{
					$contador++;
					 $query_study = "select eg.numerodocumento
				                 from estudiante e,estudiantegeneral eg
								 where e.idestudiantegeneral = eg.idestudiantegeneral 
								 and e.codigoestudiante = '$codigo1'";
					$study = mysql_db_query($database_sala,$query_study) or die("$query_seltotalcreditossemestre");
					$totalRows_study = mysql_num_rows($study);
					$row_study = mysql_fetch_array($study); 
					$numerodocumento = $row_study['numerodocumento'];
					
					echo "<tr>
					<td align='center' class='Estilo1'>$contador</td>
					<td align='center' class='Estilo1'>$numerodocumento</td>
					<td align='center' class='Estilo1'>".$estudiante1['nombre']."</td>
					<td align='center' class='Estilo1'>".$estudiante1['nombresituacioncarreraestudiante']."</td>
					<td align='center' class='Estilo1'>".$estudiante1['semestre']."</td>
					<td align='center' class='Estilo1'>".$estudiante1['creditos']."</td>
					<td align='center' class='Estilo1'>".$estudiante1['creditossemestre']."</td>
					<td align='center' class='Estilo1'>".$estudiante1['valorpagado']."</td>
					<td align='center' class='Estilo1'>".$estudiante1['valorpendiente']."</td>
					<td align='center' class='Estilo1'>".$estudiante1['valorsemestre']."</td>
					<td align='center' class='Estilo1' colspan='4'>No Tiene Asignaturas Inscritas</td></tr>";
				}
				else
				{
					echo "<tr><td align='center' class='Estilo1' colspan = '13'>El estudiante no pertenece a la Facultad</td></tr>";
				}
			}
		}
		if($_SESSION['filtrado'] == "prematriculados")
		{
			if($estudiante1['estadoprematriculado'])
			{
				$numero = $estudiante1['numeromaterias'];
				$pagado += $estudiante1['valorpagado'];
				$pendiente += $estudiante1['valorpendiente'];
				$hayprematriculados = true;
				if($estudiante1['pertenececarrera'] && $estudiante1['tieneprematricula'] && $estudiante1['tieneasignaturas'])
				{	
					$contador++;
					$numero = $estudiante1['numeromaterias'];
					 $query_study = "select eg.numerodocumento
				                 from estudiante e,estudiantegeneral eg
								 where e.idestudiantegeneral = eg.idestudiantegeneral 
								 and e.codigoestudiante = '$codigo1'";
					$study = mysql_db_query($database_sala,$query_study) or die("$query_seltotalcreditossemestre");
					$totalRows_study = mysql_num_rows($study);
					$row_study = mysql_fetch_array($study); 
					$numerodocumento = $row_study['numerodocumento'];					
					echo "<tr>
					<td align='center' class='Estilo1' rowspan='".$numero."'>$contador</td>
					<td align='center' class='Estilo1' rowspan='".$numero."'>$numerodocumento</td>
					<td align='center' class='Estilo1' rowspan='".$numero."'>".$estudiante1['nombre']."</td>
					<td align='center' class='Estilo1' rowspan='".$numero."'>".$estudiante1['nombresituacioncarreraestudiante']."</td>
					<td align='center' class='Estilo1' rowspan='".$numero."'>".$estudiante1['semestre']."</td>
					<td align='center' class='Estilo1' rowspan='".$numero."'>".$estudiante1['creditos']."</td>
					<td align='center' class='Estilo1' rowspan='".$numero."'>".$estudiante1['creditossemestre']."</td>
					<td align='center' class='Estilo1' rowspan='".$numero."'>".$estudiante1['valorpagado']."</td>
					<td align='center' class='Estilo1' rowspan='".$numero."'>".$estudiante1['valorpendiente']."</td>
					<td align='center' class='Estilo1' rowspan='".$numero."'>".$estudiante1['valorsemestre']."</td>";
					$asignaturas1 = $estudiante1['materias'];
					$cuenta = 1;
                    
					foreach($asignaturas1 as $codigomateria => $materia1)
					{
						if($cuenta == 1)
						{
                        /*
                         * Caso 100700
                         * @modified Luis Dario Gualteros <castroluisd@unbosque.edu.co>
                         * Ajuste para nuevos campos de la consulta (dia, horario, grupo y docente) de cada materia.
                         * @since Mayo 18, 2018.    
                        */
							echo "<td align='center' class='Estilo1'>".$materia1['idgrupo']."</td>
                            <td align='center' class='Estilo1'>".$materia1['nombregrupo']."</td>
                            <td align='center' class='Estilo1'>".$materia1['nombredia']."</td>    
                            <td align='center' class='Estilo1'>".$materia1['horainicial']."</td>    
                            <td align='center' class='Estilo1'>".$materia1['horafinal']."</td>   
                            <td align='center' class='Estilo1'>".$materia1['documentoDocente']."</td>
                            <td align='center' class='Estilo1'>".$materia1['nombreDocente']."</td>
                            <td align='center' class='Estilo1'>$codigomateria</td>
							<td align='center' class='Estilo1'>".$materia1['nombremateria']."</td>
							<td align='center' class='Estilo1'>".$materia1['nombreestadodetalleprematricula']."</td>
							<td align='center' class='Estilo1'>".$materia1['nota']."</td>
							</tr>";
							$cuenta++;
						}
						else
						{
                        /*
                         * Caso 100700
                         * @modified Luis Dario Gualteros <castroluisd@unbosque.edu.co>
                         * Ajuste para nuevos campos de la consulta (dia, horario, grupo y docente) de cada materia.
                         * @since Mayo 18, 2018.    
                        */
							echo "<tr>
							<td align='center' class='Estilo1'>".$materia1['idgrupo']."</td>    
							<td align='center' class='Estilo1'>".$materia1['nombregrupo']."</td>    
                            <td align='center' class='Estilo1'>".$materia1['nombredia']."</td>    
						    <td align='center' class='Estilo1'>".$materia1['horainicial']."</td>    
						    <td align='center' class='Estilo1'>".$materia1['horafinal']."</td>   
                            <td align='center' class='Estilo1'>".$materia1['documentoDocente']."</td>    
							<td align='center' class='Estilo1'>".$materia1['nombreDocente']."</td>    
							<td align='center' class='Estilo1'>$codigomateria</td>
							<td align='center' class='Estilo1'>".$materia1['nombremateria']."</td>
							<td align='center' class='Estilo1'>".$materia1['nombreestadodetalleprematricula']."</td>
							<td align='center' class='Estilo1'>".$materia1['nota']."</td>
							</tr>";
						}
					}
					echo "</tr>";
				}
				else
				{
					if($estudiante1['pertenececarrera'])
					{
						$contador++;
						 $query_study = "select eg.numerodocumento
				                 from estudiante e,estudiantegeneral eg
								 where e.idestudiantegeneral = eg.idestudiantegeneral 
								 and e.codigoestudiante = '$codigo1'";
						$study = mysql_db_query($database_sala,$query_study) or die("$query_seltotalcreditossemestre");
						$totalRows_study = mysql_num_rows($study);
						$row_study = mysql_fetch_array($study); 
						$numerodocumento = $row_study['numerodocumento'];					
						
						echo "<tr>
						<td align='center' class='Estilo1'>$contador</td>
						<td align='center' class='Estilo1'>$numerodocumento </td>
						<td align='center' class='Estilo1'>".$estudiante1['nombre']."</td>
						<td align='center' class='Estilo1'>".$estudiante1['nombresituacioncarreraestudiante']."</td>
						<td align='center' class='Estilo1'>".$estudiante1['semestre']."</td>
						<td align='center' class='Estilo1'>".$estudiante1['creditos']."</td>
						<td align='center' class='Estilo1'>".$estudiante1['creditossemestre']."</td>
						<td align='center' class='Estilo1'>".$estudiante1['valorpagado']."</td>
						<td align='center' class='Estilo1'>".$estudiante1['valorpendiente']."</td>
						<td align='center' class='Estilo1'>".$estudiante1['valorsemestre']."</td>
						<td align='center' class='Estilo1' colspan='4'>No Tiene Asignaturas Inscritas</td></tr>";
					}
					else
					{
						echo "<tr><td align='center' class='Estilo1' colspan = '13'>El estudiante no pertenece a la Facultad</td></tr>";
					}
				}
			}
		}
		if($_SESSION['filtrado'] == "matriculados")
		{
			if(!$estudiante1['estadoprematriculado'])
			{
				$numero = $estudiante1['numeromaterias'];
				$pagado += $estudiante1['valorpagado'];
				$pendiente += $estudiante1['valorpendiente'];
				$haymatriculados = true;
				if($estudiante1['pertenececarrera'] && $estudiante1['tieneprematricula'] && $estudiante1['tieneasignaturas'])
				{	
					$contador++;
					$numero = $estudiante1['numeromaterias'];
					 $query_study = "select eg.numerodocumento
				                 from estudiante e,estudiantegeneral eg
								 where e.idestudiantegeneral = eg.idestudiantegeneral 
								 and e.codigoestudiante = '$codigo1'";
					$study = mysql_db_query($database_sala,$query_study) or die("$query_seltotalcreditossemestre");
					$totalRows_study = mysql_num_rows($study);
					$row_study = mysql_fetch_array($study); 
					$numerodocumento = $row_study['numerodocumento'];					
					echo "<tr>
					<td align='center' class='Estilo1' rowspan='".$numero."'>$contador</td>
					<td align='center' class='Estilo1' rowspan='".$numero."'>$numerodocumento</td>
					<td align='center' class='Estilo1' rowspan='".$numero."'>".$estudiante1['nombre']."</td>
					<td align='center' class='Estilo1' rowspan='".$numero."'>".$estudiante1['nombresituacioncarreraestudiante']."</td>
					<td align='center' class='Estilo1' rowspan='".$numero."'>".$estudiante1['semestre']."</td>
					<td align='center' class='Estilo1' rowspan='".$numero."'>".$estudiante1['creditos']."</td>
					<td align='center' class='Estilo1' rowspan='".$numero."'>".$estudiante1['creditossemestre']."</td>
					<td align='center' class='Estilo1' rowspan='".$numero."'>".$estudiante1['valorpagado']."</td>
					<td align='center' class='Estilo1' rowspan='".$numero."'>".$estudiante1['valorpendiente']."</td>
					<td align='center' class='Estilo1' rowspan='".$numero."'>".$estudiante1['valorsemestre']."</td>";
					//<td align='center' class='Estilo1' rowspan='".$numero."'>".number_format($estudiante1['valorpagado'])."</td>
					$asignaturas1 = $estudiante1['materias'];
					$cuenta = 1;
					foreach($asignaturas1 as $codigomateria => $materia1)
					{
						if($cuenta == 1)
						{
                    /*
                     * Caso 100700
                     * @modified Luis Dario Gualteros <castroluisd@unbosque.edu.co>
                     * Ajuste para nuevos campos de la consulta (dia, horario, grupo y docente) de cada materia.
                     * @since Mayo 18, 2018.    
                    */
							echo "<td align='center' class='Estilo1'>".$materia1['idgrupo']."</td>
                            <td align='center' class='Estilo1'>".$materia1['nombregrupo']."</td>
                            <td align='center' class='Estilo1'>".$materia1['nombredia']."</td>    
						    <td align='center' class='Estilo1'>".$materia1['horainicial']."</td>    
						    <td align='center' class='Estilo1'>".$materia1['horafinal']."</td>   
                            <td align='center' class='Estilo1'>".$materia1['documentoDocente']."</td>
                            <td align='center' class='Estilo1'>".$materia1['nombreDocente']."</td>
                            <td align='center' class='Estilo1'>$codigomateria</td>
							<td align='center' class='Estilo1'>".$materia1['nombremateria']."</td>
							<td align='center' class='Estilo1'>".$materia1['nombreestadodetalleprematricula']."</td>
							<td align='center' class='Estilo1'>".$materia1['nota']."</td>
							</tr>";
							$cuenta++;
						}
						else
						{
                      /*
                       * Caso 100539
                       * @modified Luis Dario Gualteros <castroluisd@unbosque.edu.co>
                       * Ajuste para nuevos campos de la consulta (dia, horario, grupo y docente) de cada materia.
                       * @since Mayo 18, 2018.    
                      */
							echo "<tr>
							<td align='center' class='Estilo1'>".$materia1['idgrupo']."</td>    
							<td align='center' class='Estilo1'>".$materia1['nombregrupo']."</td>    
						    <td align='center' class='Estilo1'>".$materia1['nombredia']."</td>    
                            <td align='center' class='Estilo1'>".$materia1['horainicial']."</td>    
                            <td align='center' class='Estilo1'>".$materia1['horafinal']."</td>   
                        	<td align='center' class='Estilo1'>".$materia1['documentoDocente']."</td>    
							<td align='center' class='Estilo1'>".$materia1['nombreDocente']."</td>    
							<td align='center' class='Estilo1'>$codigomateria</td>
							<td align='center' class='Estilo1'>".$materia1['nombremateria']."</td>
							<td align='center' class='Estilo1'>".$materia1['nombreestadodetalleprematricula']."</td>
							<td align='center' class='Estilo1'>".$materia1['nota']."</td>
							</tr>";
						}
					}
					echo "</tr>";
				}
				else
				{
					if($estudiante1['pertenececarrera'])
					{
						$contador++;
						echo "<tr>
						<td align='center' class='Estilo1'>$contador</td>
						<td align='center' class='Estilo1'>$codigo1</td>
						<td align='center' class='Estilo1'>".$estudiante1['nombre']."</td>
						<td align='center' class='Estilo1'>".$estudiante1['nombresituacioncarreraestudiante']."</td>
						<td align='center' class='Estilo1'>".$estudiante1['semestre']."</td>
						<td align='center' class='Estilo1'>".$estudiante1['creditos']."</td>
						<td align='center' class='Estilo1'>".$estudiante1['creditossemestre']."</td>
						<td align='center' class='Estilo1'>".$estudiante1['valorpagado']."</td>
						<td align='center' class='Estilo1'>".$estudiante1['valorpendiente']."</td>
						<td align='center' class='Estilo1'>".$estudiante1['valorsemestre']."</td>
						<td align='center' class='Estilo1' colspan='4'>No Tiene Asignaturas Inscritas</td></tr>";
					}
					else
					{
						echo "<tr><td align='center' class='Estilo1' colspan = '13'>El estudiante no pertenece a la Facultad</td></tr>";
					}
				}
			}
		}
	}
	if(!$hayprematriculados && $_SESSION['filtrado'] == "prematriculados")
	{
		echo "<tr><td align='center' class='Estilo1' colspan = '13'>No hay estudiantes prematriculados</td></tr>";
	}
	if(!$haymatriculados && $_SESSION['filtrado'] == "matriculados")
	{
		echo "<tr><td align='center' class='Estilo1' colspan = '13'>No hay estudiantes matriculados</td></tr>";
	}
	?>
            
            
	</table>
	<br>
	<br>
	<table width="700" border="1" cellpadding="2" cellspacing="1" bordercolor="#003333" align="center">
	  <tr bgcolor="#C5D5D6">
		<td align="center" class="Estilo1" colspan="5"><strong>TOTALES</strong></td>
	  </tr>
	  <tr bgcolor="#C5D5D6">
		<td align="center" class="Estilo1"><strong>Estudiantes</strong></td>
		<td align="center" class="Estilo1"><strong>Matriculados</strong></td>
		<td align="center" class="Estilo1"><strong>Prematriculados</strong></td>
		<td align="center" class="Estilo1"><strong>Pagado</strong></td>
		<td align="center" class="Estilo1"><strong>Pendiente</strong></td>
	  </tr>
	  <tr>
		<td align="center" class="Estilo1"><strong><?php echo $cuentaestudiantes ?></strong></td>
		<td align="center" class="Estilo1"><strong><?php echo $cuentamatriculados ?></strong></td>
		<td align="center" class="Estilo1"><strong><?php echo $cuentaprematriculados ?></strong></td>
		<td align="center" class="Estilo1"><strong>$ <?php echo number_format($pagado,2) ?></strong></td>
		<td align="center" class="Estilo1"><strong>$ <?php echo number_format($pendiente,2) ?></strong></td>
	  </tr>
	</table>
	<p align="center"><input type="button" onClick="print()" value="Imprimir">
        
        	<?php 
	if(!isset($_GET['facultad'])) 
	{
	?>
	<input type="button" onClick="salir()" value="Regresar">
	<?php
	}
	else
	{
	?>
	<input type="button" onClick="salir()" value="Salir"><br><br>
	<?php
		if($semestreinicial > 1)
		{
			$atras = $semestreinicial - 1;
			echo '<a href="listadogeneralestudiantesmostrar.php?semestreinicial='.$atras.'&facultad&corte='.$corte1.'"><<- Atras</a>';
		}
		echo "&nbsp;&nbsp;";
		if($semestreinicial < $limitesemestre)
		{
			$adelante = $semestreinicial + 1;
			echo '<a href="listadogeneralestudiantesmostrar.php?semestreinicial='.$adelante.'&facultad&corte='.$corte1.'">Adelante->></a>';
		}
	}
}
else
{
?>
<p align="center"><span class="Estilo3">Este semestre se encuentra sin estudiantes</span></br></br>

<?php
if($semestreinicial > 1)
		{
			$atras = $semestreinicial - 1;
			echo '<a href="listadogeneralestudiantesmostrar.php?semestreinicial='.$atras.'&facultad&corte='.$corte1.'"><<- Atras</a>';
		}
		echo "&nbsp;&nbsp;";
		if($semestreinicial < $limitesemestre)
		{
			$adelante = $semestreinicial + 1;
			echo '<a href="listadogeneralestudiantesmostrar.php?semestreinicial='.$adelante.'&facultad&corte='.$corte1.'">Adelante->></a>';
		}
}
?>
</p>
</p>
</body>
<script language="javascript">
function salir()
{
	window.location.reload("listadogeneralestudiantes.php");
}
</script>
</html>
      