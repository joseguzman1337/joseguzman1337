<?php
require_once('../../Connections/sala2.php');
session_start();
$periodoactivo=$_SESSION['codigoperiodosesion'];

 
 if(isset($_POST['carrera']))
   {
     $codigocarrera = $_POST['carrera'];
   }
  else
   {
     $codigocarrera = $_SESSION['codigofacultad'];
   }

if ($_POST['busqueda_semestre1'] <> "")
{
 echo '<script language="JavaScript">window.location.reload("listadopromediocortesmostrartodos.php?semestreinicial='.$_POST['busqueda_semestre1'].'&carrera='.$codigocarrera.'");</script>';							
 exit();
}
if ($_POST['busqueda_corte'] == "")
				{
				   echo '<script language="JavaScript">alert("Debe Digitar el nùmero de corte")</script>';			
				   echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=listadopromediocortes.php'>";		
				   exit();
				}
				



if (isset($_POST['busqueda_semestre']))
{
  mysql_select_db($database_sala, $sala);
$query_materiascarrera = "SELECT e.codigoestudiante,m.codigomateria,m.nombremateria,p.semestreprematricula
	FROM detalleprematricula dp,estudiante e, prematricula p,materia m,grupo g
	WHERE p.idprematricula = dp.idprematricula
	AND dp.codigomateria= m.codigomateria	
	AND dp.idgrupo = g.idgrupo	
	AND e.codigoestudiante = p.codigoestudiante
	AND g.codigoperiodo = '".$periodoactivo."'
	AND m.codigoestadomateria = '01'
	AND e.codigocarrera = '$codigocarrera'
	AND p.codigoestadoprematricula LIKE '4%'
	AND dp.codigoestadodetalleprematricula  LIKE '3%'
	AND p.semestreprematricula = '".$_POST['busqueda_semestre']."'	
	ORDER BY 2";	
$materiascarrera = mysql_query($query_materiascarrera, $sala) or die("$query_promedioestudiante");
$total_materiascarrera = mysql_num_rows($materiascarrera);
if($total_materiascarrera != "")
{	
	while($row_materiascarrera = mysql_fetch_assoc($materiascarrera))
	{
		$semestreprematricula = $row_materiascarrera['semestreprematricula'];
		// Se toman las cabeceras de las materias
		$nombresmaterias[$row_materiascarrera['codigomateria']] = $row_materiascarrera['nombremateria'];
		$materias[$row_materiascarrera['codigomateria']] = "&nbsp;";
				
	}
}	
$cuentamaterias= $materias;
// Selecciona los promedios de los estudiantes por codigo, solamente con las materias que tienen nota
	$query_promedioestudiante = "select e.codigoestudiante, concat(eg.apellidosestudiantegeneral,' ',eg.nombresestudiantegeneral) as nombre,eg.numerodocumento ,round(avg(dn.nota),1) as promedio
	from detallenota dn, estudiante e, prematricula p,corte c,estudiantegeneral eg
	where e.codigoestudiante = dn.codigoestudiante
	and e.idestudiantegeneral = eg.idestudiantegeneral
	and e.codigoestudiante = p.codigoestudiante
	and e.codigocarrera = '$codigocarrera'
	AND c.idcorte = dn.idcorte 
	AND c.idcorte = dn.idcorte 
	AND c.numerocorte = '".$_POST['busqueda_corte']."'
	and p.semestreprematricula = '".$_POST['busqueda_semestre']."'
	group by 1
	order by 2";
	//echo $query_promedioestudiante;
	$promedioestudiante = mysql_query($query_promedioestudiante, $sala) or die("$query_promedioestudiante");
	$total_promedioestudiante = mysql_num_rows($promedioestudiante);

// Si el estudiante tiene prematricula activa y alguna orden de pago activa le muestra los datos
} // fin isset $_POST['busqueda_semestre']
else 

if (isset($_POST['busqueda_codigo']))
{
     $documento = $_POST['busqueda_codigo'];
	 mysql_select_db($database_sala, $sala);
     $query_solicitud = "SELECT distinct eg.idestudiantegeneral, est.codigoestudiante, concat(eg.apellidosestudiantegeneral,' ',eg.nombresestudiantegeneral) as nombre, 
				c.nombrecarrera, eg.numerodocumento, est.codigoperiodo
				FROM estudiante est, estudiantegeneral eg, estudiantedocumento ed, documento d, carrera c 
				WHERE ed.numerodocumento LIKE '$documento%'				
				and est.codigoperiodo <= '".$_SESSION['codigoperiodosesion']."'
				and eg.idestudiantegeneral = est.idestudiantegeneral
				and ed.idestudiantegeneral = eg.idestudiantegeneral
				and c.codigocarrera = est.codigocarrera
				and ed.fechainicioestudiantedocumento <= '".date("Y-m-d H:m:s",time())."'
				and ed.fechavencimientoestudiantedocumento >= '".date("Y-m-d H:m:s",time())."'
				ORDER BY 3, est.codigoperiodo";
				//and est.codigosituacioncarreraestudiante not like '1%'
				//and est.codigosituacioncarreraestudiante not like '5%'
				//AND est.codigocarrera = '$codigocarrera'
	$res_solicitud = mysql_query($query_solicitud, $sala) or die(mysql_error());
    $solicitud = mysql_fetch_assoc($res_solicitud);
    $codigoestudiante = $solicitud['codigoestudiante'];
  
$query_materiascarrera = "SELECT m.nombremateria,m.codigomateria,m.numerocreditos,g.idgrupo,p.codigoestudiante
						FROM prematricula p,detalleprematricula d,materia m,grupo g
						WHERE  p.codigoestudiante = '".$codigoestudiante."'						
						AND p.idprematricula = d.idprematricula
						AND d.codigomateria = m.codigomateria
						AND d.idgrupo = g.idgrupo
						and m.codigoestadomateria = '01'
						AND g.codigoperiodo = '".$periodoactivo."'
						AND p.codigoestadoprematricula LIKE '4%'
						AND d.codigoestadodetalleprematricula LIKE '3%'";
//echo $query_materiascarrera;AND g.codigomaterianovasoft = m.codigomaterianovasoft
$materiascarrera = mysql_query($query_materiascarrera, $sala) or die("$query_promedioestudiante");
$total_materiascarrera = mysql_num_rows($materiascarrera);

if($total_materiascarrera != "")
{		 
	while($row_materiascarrera = mysql_fetch_assoc($materiascarrera))
	{
		// Se toman las cabeceras de las materias//
		$codigoestudiante = $row_materiascarrera['codigoestudiante'];
		
		$nombresmaterias[$row_materiascarrera['codigomateria']] = $row_materiascarrera['nombremateria'];
		$materias[$row_materiascarrera['codigomateria']] = "sin nota";
	
	}
}	
$cuentamaterias= $materias;
// Selecciona los promedios de los estudiantes por codigo, solamente con las materias que tienen nota
				$query_promedioestudiante = "SELECT e.codigoestudiante, concat(eg.apellidosestudiantegeneral,' ',eg.nombresestudiantegeneral) AS nombre,eg.numerodocumento ,round(AVG(dn.nota),1) AS promedio 
											FROM detallenota dn, estudiante e, prematricula p,corte c,estudiantegeneral eg 
											WHERE e.codigoestudiante = dn.codigoestudiante 
											and e.idestudiantegeneral = eg.idestudiantegeneral
											AND e.codigoestudiante = '".$codigoestudiante."'
											AND e.codigocarrera = '$codigocarrera'
											AND c.idcorte = dn.idcorte 
											AND c.numerocorte = '".$_POST['busqueda_corte']."'
											AND c.codigoperiodo = '".$periodoactivo."'
											AND p.codigoestadoprematricula LIKE '4%' 
											GROUP by 1 
											ORDER BY 2 ";
	//echo $query_promedioestudiante;
	$promedioestudiante = mysql_query($query_promedioestudiante, $sala) or die("$query_promedioestudiante");
	$total_promedioestudiante = mysql_num_rows($promedioestudiante);
 
// Si el estudiante tiene prematricula activa y alguna orden de pago activa le muestra los datos
} // fin isset $_POST['busqueda_semestre']

if($total_promedioestudiante == "")
{
   /*echo '<script language="JavaScript">alert("No se produjo ningun resultado")</script>';			
   echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=listadopromediocortes.php'>";		
   exit();*/
}

if($total_promedioestudiante != "")
{
	while($row_promedioestudiante = mysql_fetch_assoc($promedioestudiante))
	{
	
		// Selecciona los datos de las materias en las que tiene nota el estudiante		
		$query_materiasestudiante = "select g.idgrupo, m.nombremateria,  m.codigomateria, dn.nota
		from grupo g, materia m, detallenota dn,corte c
		where g.idgrupo = dn.idgrupo
		AND dn.idcorte = c.idcorte
		and g.codigomateria = m.codigomateria
		and m.codigoestadomateria = '01'
		AND c.idcorte = dn.idcorte 
		AND c.numerocorte = '".$_POST['busqueda_corte']."'
		AND c.codigoperiodo = '".$periodoactivo."'
		and dn.codigoestudiante = '".$row_promedioestudiante['codigoestudiante']."'		 
		order by 3";
		//echo $query_materiasestudiante,"</br>";
		$materiasestudiante = mysql_query($query_materiasestudiante, $sala) or die("$query_promedioestudiante");
		$total_materiasestudiante = mysql_num_rows($materiasestudiante);	
		
		// Si el estudiante tiene prematricula activa y alguna orden de pago activa le muestra los datos
		if($total_materiasestudiante != "")
		{
			$materiasesteestudiante = $materias;
			
			while($row_materiasestudiante = mysql_fetch_assoc($materiasestudiante))
			{
				if(($materiasesteestudiante[$row_materiasestudiante['codigomateria']] == "&nbsp;") or ($materiasesteestudiante[$row_materiasestudiante['codigomateria']] == "sin nota"))
				 {			
						$materiasesteestudiante[$row_materiasestudiante['codigomateria']] = $row_materiasestudiante['nota'];
						$materiasesteestudiante['promedio'] = $row_promedioestudiante['promedio'];
						$materiasesteestudiante['nombre'] = $row_promedioestudiante['nombre'];
						//$estudiante[$row_promedioestudiante['codigoestudiante']] = $materiasesteestudiante;
			          $materiasestudiantematricula= $materiasesteestudiante;
					  foreach($materiasestudiantematricula as $key2 => $value2)
                       {
				         if ($value2 == "&nbsp;")
					       {
						     $query_materiascarrera1 = "SELECT m.nombremateria,m.codigomateria,m.numerocreditos,g.idgrupo,p.codigoestudiante
								FROM prematricula p,detalleprematricula d,materia m,grupo g
								WHERE  p.codigoestudiante = '".$row_promedioestudiante['codigoestudiante']."'
								AND p.idprematricula = d.idprematricula
								AND d.codigomateria = m.codigomateria
								and m.codigomateria = '$key2'
								AND d.idgrupo = g.idgrupo
								and m.codigoestadomateria = '01'
								AND g.codigoperiodo = '".$periodoactivo."'
								AND p.codigoestadoprematricula LIKE '4%'
								AND d.codigoestadodetalleprematricula LIKE '3%'";
								//echo $query_materiascarrera1,"</br>";
						$materiascarrera1 = mysql_query($query_materiascarrera1, $sala) or die("$query_promedioestudiante");
						$total_materiascarrera1 = mysql_num_rows($materiascarrera1);
					       if($total_materiascarrera1 <> 0)
                             {							 	
						      $materiasesteestudiante[$key2] = "sin nota";
						     }						   
						     
						   }						   
					   }
				     $estudiante[$row_promedioestudiante['codigoestudiante']] = $materiasesteestudiante;
				  }
			}     
			unset($materiasesteestudiante);
		}	
	
	}
}
?>
<html>
<style type="text/css">
<!--
.Estilo1 {
	font-family: Tahoma;
	font-size: xx-small;
}
.Estilo9 {
	font-size: 14px;
	font-family: Tahoma;
	font-weight: bold;
}
-->
</style>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Mostrar listado promedio cortes</title>
</head>
<body>
<h3 align="center" class="Estilo9">LISTADO PROMEDIO CORTES</h3>
<?php
//foreach
?>
<table width="600" border="1" cellpadding="2" cellspacing="1" bordercolor="#003333" align="center">
  <tr bgcolor="#C5D5D6">
	<td align="center" class="Estilo1" colspan="2"><strong>Estudiantes <?php if ($_POST['busqueda_semestre'] <> "") echo "Semestre&nbsp;",$_POST['busqueda_semestre']; ?></strong></td>
	<td align="center" class="Estilo1" colspan="<?php echo count($cuentamaterias) ;?>"><strong>Materias</strong></td>
	<td align="center" class="Estilo1" rowspan="2"><strong>Promedio Aritm&eacute;tico </strong></td>
	<td align="center" class="Estilo1" rowspan="2"><strong>Promedio Ponderado</strong></td>
  </tr>
  <tr bgcolor="#C5D5D6">
  	<td align="center" class="Estilo1"><strong>Documento</strong></td>
	<td align="center" class="Estilo1"><strong>Nombre</strong></td>
<?php
$materiasestadistica = $materias;
if (isset($materias))
{
foreach($materias as $key1 => $value1)
{
  $query_Recordset9 ="SELECT materia.notaminimaaprobatoria
					FROM materia
					WHERE  materia.codigomateria = '$key1'
					and materia.codigoestadomateria = '01'";	
							//AND materia.codigoestadomateria = '01'																
    $Recordset9 = mysql_query($query_Recordset9, $sala) or die(mysql_error());
	$row_Recordset9 = mysql_fetch_assoc($Recordset9);
	$totalRows_Recordset9 = mysql_num_rows($Recordset9);	
    $notaminima[] = $row_Recordset9['notaminimaaprobatoria'];    
?>
	<td align="center" class="Estilo1"><strong><?php echo $key1."<br>".$nombresmaterias[$key1]?></strong></td>

<?php
}
}
?>
  </tr>
<?php
if (isset($estudiante))
{
foreach($estudiante as $codigoestudiante => $materiasestudiante)
{
   	
	$query_numerodocumento ="SELECT eg.numerodocumento 
							FROM estudiante e,estudiantegeneral eg
							WHERE e.idestudiantegeneral = eg.idestudiantegeneral 
							AND e.codigoestudiante = '".$codigoestudiante."'";																						
    $numerodocumento = mysql_query($query_numerodocumento, $sala) or die(mysql_error());
	$row_numerodocumento = mysql_fetch_assoc($numerodocumento);
	$totalRows_numerodocumento = mysql_num_rows($numerodocumento);	
	
	
	
	echo "<tr>
	<td align='center' class='Estilo1'>".$row_numerodocumento['numerodocumento']."</td>
	<td align='center' class='Estilo1'>".$materiasestudiante['nombre']."</td>";
	foreach($materiasestudiante as $codigomateria => $nota)
	{
		//echo $notaminima[$cuente],"<br>";
		if($codigomateria != "promedio" && $codigomateria != "nombre" )
		{
			if ($nota < $notaminima[0] and $nota <> "&nbsp;" and $nota <> "sin nota")
			 {
			  echo "<td align='center' class='Estilo1'><font color='red'><strong>$nota</strong></td>";	      
			 }
			else
		     {
			  echo "<td align='center' class='Estilo1'>$nota</td>";			       
			 }		   
		}
	  	
	}
	
	require('calculopremedio.php');
	echo "<td align='center' class='Estilo1'>".$materiasestudiante['promedio']."</td>";	
    echo "<td align='center' class='Estilo1'>".$pro."</td>";
	$pro = 0;
}
}
echo "</tr>";
?>
</table>

<?php 
if ( ! isset($_POST['busqueda_codigo']))
 { // if codigoestudiante
?>
<p align="center"><span class="Estilo9">DATOS ESTAD&Iacute;STICOS</span></p>
<table width="600" border="1" cellpadding="2" cellspacing="1" bordercolor="#003333" align="center">
<tr bgcolor="#C5D5D6">
<td align="center" class="Estilo1" colspan="2"><strong>NOMBRE ASIGNATURA</strong></td>
<?php
if (isset($estudiante))
{
foreach($materias as $key1 => $value1) 
{   
   ?>	
	<td align="center" class="Estilo1"><strong><?php echo $key1."<br>".$nombresmaterias[$key1]?></strong></td> 
 <?php

}
}
echo "</tr>";
//for ($row = 1; $row <= count($cuentamaterias);$row++)
 //{//for
if (isset($materiasestadistica))
{
foreach($materiasestadistica as $key2 => $value1)
{ 
 
  $query_Recordset9 ="SELECT e.codigoestudiante
									FROM detalleprematricula dp,estudiante e, prematricula p,materia m,grupo g
									WHERE p.idprematricula = dp.idprematricula
									AND dp.codigomateria= m.codigomateria	
									AND dp.idgrupo = g.idgrupo	
									AND e.codigoestudiante = p.codigoestudiante
									AND  m.codigomateria = '".$key2."'
									AND g.codigoperiodo = '".$periodoactivo."'									 
									AND e.codigocarrera = '$codigocarrera'
									AND m.codigoestadomateria = '01'
									AND p.codigoestadoprematricula LIKE '4%'
									AND dp.codigoestadodetalleprematricula  LIKE '3%'
									AND p.semestreprematricula = '".$_POST['busqueda_semestre']."'	
									";	
							//echo  $query_Recordset9;
							//AND materia.codigoestadomateria = '01'		count(*) as mayor														
    $Recordset9 = mysql_query($query_Recordset9, $sala) or die(mysql_error());
	$row_Recordset9 = mysql_fetch_assoc($Recordset9);
	$totalRows_Recordset9 = mysql_num_rows($Recordset9);	
	$cuenteme = $row_Recordset9['mayor'];   
	//echo $cuenteme,"<br>"; 
//echo $row_Recordset9['mayor'];
    $me = 5;
	$ma = 0;
	$e = 1;
	$perdieron = 0;
		do
		  {
		       $query_Recordset ="SELECT DISTINCT dn.codigoestudiante,dn.nota 
									FROM grupo g, materia m, detallenota dn,corte c 
									WHERE g.idgrupo = dn.idgrupo 
									AND dn.idcorte = c.idcorte 
									AND g.codigomateria = m.codigomateria									
									AND m.codigomateria = '".$key2."'
									AND c.idcorte = dn.idcorte 
									AND c.numerocorte = '".$_POST['busqueda_corte']."'
									AND c.codigoperiodo = '".$periodoactivo."'
									AND dn.codigoestudiante = '".$row_Recordset9['codigoestudiante']."'
									ORDER BY 1
									";																			
				$Recordset = mysql_query($query_Recordset, $sala) or die(mysql_error());
				$row_Recordset = mysql_fetch_assoc($Recordset);
				$totalRows_Recordset = mysql_num_rows($Recordset);
				//print_r ($row_Recordset)."<br>"; 
                if ($row_Recordset['nota'] <> "")
			    {				 
				 $cuenteme = $cuenteme + 1;
				 $promedionota[$e] = $row_Recordset['nota'];
					if ($row_Recordset['nota'] < $me)
					{
					 $me = $row_Recordset['nota'];					 
					} 
					
					if ($row_Recordset['nota'] > $ma)
					{
					 $ma = $row_Recordset['nota'];
					 //$manornota[$e] = $row_Recordset['nota'];
					} 								
				    
					if ($row_Recordset['nota'] < $notaminima[0])
					{
					 $perdieron ++;
					} 								 
				  $e ++;
				}  
			//echo $row_Recordset9['codigoestudiante']."<br>";
			
		   }while($row_Recordset9 = mysql_fetch_assoc($Recordset9));

$sum = 0;
for($r = 1; $r < $e; $r++)
 {
  $sum = $sum + $promedionota[$r];
 }
if ($r <> 1)
$totalpromedio = number_format($sum/($r-1),1);

$desviacion = 0;

for($r = 1; $r < $e; $r++)
 {
  $desviacion = $desviacion + pow (($promedionota[$r] - $totalpromedio),2);
 }
 if ($r <> 1)
$desviacion3= $desviacion/($r-1);
$desviaciontotal = number_format(sqrt($desviacion3),1);
$imprime['promedio'] = $totalpromedio;
$imprime['notaminima'] = $me;
$imprime['notamaxima'] = $ma;
$imprime['desviacionestandar'] = $desviaciontotal;
$imprime['perdieron'] = $perdieron;
$imprime['totalestudiantes'] = $cuenteme;

$materia[$key2] = $imprime;

unset($imprime);
}
}//nuevo
if (isset($materia))
{
foreach($materia as $codigodemateria => $datos)
{
	foreach($datos as $llave => $valor)
	{
		if($llave == "promedio")
		{
			$promedioA[] = $valor;
		}
		if($llave == "notaminima")
		{
			$notaminimaA[] = $valor;
		}
		if($llave == "notamaxima")
		{
			$notamaximaA[] = $valor;
		}
		if($llave == "desviacionestandar")
		{
			$desviacionestandarA[] = $valor;
		}
		if($llave == "perdieron")
		{
			$perdieronA[] = $valor;
		}
		if($llave == "totalestudiantes")
		{
			$totalestudiantesA[] = $valor;
		}
	}
}
}
?>
<tr>
<td align="center" class="Estilo1" colspan="2"><strong>PROMEDIO</strong></td>
<?php
if (isset($promedioA))
{
foreach($promedioA as $llave1 => $datopromedio)
{
?>
	<td align='center' class='Estilo1'><?php echo $datopromedio ?>&nbsp;</td>
<?php
}
}
?>
</tr>
<tr>
<td align="center" class="Estilo1" colspan="2"><strong>NOTA M&Iacute;NIMA</strong></td>
<?php
if (isset($notaminimaA))
{
foreach($notaminimaA as $llave1 => $datopromedio)
{
?>
	<td align='center' class='Estilo1'><?php echo $datopromedio ?>&nbsp;</td>
<?php
}
}
?>
</tr>
<tr>
<td align="center" class="Estilo1" colspan="2"><strong>NOTA M&Aacute;XIMA</strong></td>
<?php
if (isset($notamaximaA))
{
foreach($notamaximaA as $llave1 => $datopromedio)
{
?>
	<td align='center' class='Estilo1'><?php echo $datopromedio ?>&nbsp;</td>
<?php
}
}
?>
</tr>
<tr>
<td align="center" class="Estilo1" colspan="2"><strong>DESVIACI&Oacute;N ESTANDAR</strong></td>
<?php
if (isset($notamaximaA))
{
foreach($notamaximaA as $llave1 => $datopromedio)
{
?>
	<td align='center' class='Estilo1'><?php echo $datopromedio ?>&nbsp;</td>
<?php
}
}
?>
</tr>
<tr>
<td align="center" class="Estilo1" colspan="2"><strong>Nº ESTUDIANTES PERDIERON</strong></td>
<?php
if (isset($perdieronA))
{
foreach($perdieronA as $llave1 => $datopromedio)
{
?>
	<td align='center' class='Estilo1'><?php echo $datopromedio ?>&nbsp;</td>
<?php
}
}
?>
</tr>
<tr>
<td align="center" class="Estilo1" colspan="2"><strong>Nº ESTUDIANTES / ASIGNATURA</strong></td>
<?php
if (isset($totalestudiantesA))
{
foreach($totalestudiantesA as $llave1 => $datopromedio)
{
?>
	<td align='center' class='Estilo1'><?php echo $datopromedio ?>&nbsp;</td>
<?php
}
}
?>
</tr>
</table>
<?php 
} // if codigoestudiante
?>
<p align="center"><input type="button" onClick="print()" value="Imprimir">
<input type="button" onClick="volver()" value="Regresar">
<br><br>
</p>
</body>
</html>
<script language="JavaScript">
  function volver()
   {
    window.location.reload("listadopromediocortes.php")
   }
</script>
 