<?php require_once('../../../Connections/sala2.php');
@session_start();
?>
<style type="text/css">
<!--
.Estilo2 {
	font-weight: bold;
	font-size: x-small;
}
.Estilo3 {font-family: tahoma}
.Estilo5 {font-family: tahoma; font-weight: bold; }
.Estilo6 {font-size: x-small}
.Estilo7 {font-size: xx-small}
.Estilo10 {font-weight: bold}
.Estilo11 {font-family: tahoma; font-size: xx-small; }
.Estilo12 {font-weight: bold}
-->
</style>

<p align="center" class="Estilo10"><span class="Estilo5">Estad&iacute;sticas Matriculas</span>&nbsp;<?php echo $periodo;?></p>
<table width="30%"   border="1" align="center" cellpadding="1" bordercolor="#003333">
<?php
$totalperdidau = 0;
$totalsemestreanterioru = 0;

if ($_GET['carrera'] == 0)
{ // if 1
///////////////////////////// todas las facultades ///////////////////////////////////////
 if ($_GET['modalidad'] == 0)
    {
	    $fecha = date("Y-m-d G:i:s",time());
		mysql_select_db($database_sala, $sala);
		$query_car = "SELECT nombrecarrera,codigocarrera,codigomodalidadacademica
		FROM carrera
		WHERE fechavencimientocarrera > '".$fecha."'		
		order by 3,1";		
		$car = mysql_query($query_car, $sala) or die(mysql_error());
		$row_car = mysql_fetch_assoc($car);
		$totalRows_car = mysql_num_rows($car);		
	}
   else     
	{	 
		
		$fecha = date("Y-m-d G:i:s",time());
		mysql_select_db($database_sala, $sala);
		$query_car = "SELECT nombrecarrera,codigocarrera,codigomodalidadacademica
		FROM carrera
		WHERE fechavencimientocarrera > '".$fecha."'
		and codigomodalidadacademica =  '".$_GET['modalidad']."'	
		order by 3,1";		
		//echo $query_car; 
		$car = mysql_query($query_car, $sala) or die(mysql_error());
		$row_car = mysql_fetch_assoc($car);
		$totalRows_car = mysql_num_rows($car);		
   }
   
  unset($totaluniversidad);
do{
$codigocarrera = $row_car['codigocarrera'];
$totalordenes = 0;
$valortotalordenes = 0;
$ordenesmatriculadas = 0;
$valorordenesmatriculadas = 0;
$nuevo = 0;
$antiguos = 0;
$totalsemestreanterior = 0;
$totalperdida = 0;
$totalreserva = 0;
$totalordenunica = 0;
$totalmayorordenunica = 0;
$ordenestotalidad = 0;
$totalordenestotal = 0;
$totalordenespormitad = 0;
$totalordenespormitadvalor = 0;
$valortotalordenescompletas = 0;
$totalsemestremujeres = 0;
mysql_select_db($database_sala, $sala);

 foreach($_SESSION['periodosseleccionados'] as $valor => $consultarperiodo)
  {	
	$query_validacion = "SELECT p.codigoestudiante
	FROM prematricula p,estudiante e,ordenpago o
	WHERE e.codigocarrera = '$codigocarrera'
	AND o.idprematricula = p.idprematricula
	AND p.codigoestudiante = e.codigoestudiante
	AND (o.codigoestadoordenpago LIKE '4%')
	AND p.codigoperiodo = '$consultarperiodo'";
	//echo $query_validacion,"<br><br>";
	$validacion = mysql_query($query_validacion, $sala) or die(mysql_error());
	$row_validacion = mysql_fetch_assoc($validacion);
	$totalRows_validacion = mysql_num_rows($validacion);
    
	
  }
  
 if ($row_validacion <> "")
  { // validacion
  
	$query_semestrecarrera = "select DISTINCT semestredetallecohorte
	from cohorte c,detallecohorte d
	where c.idcohorte = d.idcohorte 
	and c.codigocarrera = '$codigocarrera'
	and c.codigoperiodo = '$consultarperiodo'";	
	//echo $query_semestrecarrera;
	$semestrecarrera = mysql_query($query_semestrecarrera, $sala) or die(mysql_error());
	$row_semestrecarrera = mysql_fetch_assoc($semestrecarrera);
	$totalRows_semestrecarrera = mysql_num_rows($semestrecarrera);

	$query_carrera = "select *
	from carrera
	where codigocarrera = '$codigocarrera'";
	$carrera = mysql_query($query_carrera, $sala) or die(mysql_error());
	$row_carrera = mysql_fetch_assoc($carrera);
	$totalRows_carrera = mysql_num_rows($carrera);
?>
 <tr>
   <td align="center" colspan="<?php echo count($_SESSION['periodosseleccionados']) + 1; ?>" bgcolor="#C5D5D6"><strong><span class="Estilo6 Estilo3"><strong><?php echo $row_carrera['nombrecarrera'];?></strong></span></strong></td>
 </tr>
 <tr bgcolor="#C5D5D6">
   <td colspan="0"><div align="center" class="Estilo12 Estilo7 Estilo3"><strong><strong>Semestre</strong></strong></div></td>
<?php 
  foreach($_SESSION['periodosseleccionados'] as $valor => $consultarperiodo)
  {
?>				 
   <td colspan="1"><span class="Estilo3 Estilo7"><strong><strong><?php echo $consultarperiodo;?></strong></strong></span></td>
<?php 
  }
?>		  
 </tr>  
 <tr>
	
<?php 
	$contadorperiodo = 1;
	unset($totalporperiodo);
	 do{  
?>
         <td><div align="center" class="Estilo7"><span class="Estilo3"><?php echo $contadorperiodo;?></span></strong></div></td>
<?php 
         foreach($_SESSION['periodosseleccionados'] as $valor => $consultarperiodo)
		  { // foreach
?> 
				 <td><div align="center" class="Estilo11">
<?php
				  $query_periodomatriculados = "select distinct e.codigoestudiante
				  from estudiante e,ordenpago o,prematricula p,fechaordenpago f
				  where e.codigoestudiante = o.codigoestudiante
				  and o.numeroordenpago = f.numeroordenpago
				  and f.porcentajefechaordenpago = '0'
				  and o.idprematricula = p.idprematricula
				  and o.codigoestadoordenpago like '4%'
				  AND p.codigoestadoprematricula LIKE '4%'
				  AND e.codigosituacioncarreraestudiante NOT LIKE '5%'
				  and p.semestreprematricula = '".$row_semestrecarrera['semestredetallecohorte']."'
				  and e.codigocarrera = '$codigocarrera'
				  and o.codigoperiodo = '$consultarperiodo'";	
				  $periodomatriculados = mysql_query($query_periodomatriculados, $sala) or die(mysql_error());
				  $row_periodomatriculados = mysql_fetch_assoc($periodomatriculados);
				  $totalRows_periodomatriculados = mysql_num_rows($periodomatriculados);
				  echo $totalRows_periodomatriculados;					
?>  
				 </div></td>
<?php 
                 $totalporperiodo[$consultarperiodo] = $totalporperiodo[$consultarperiodo] + $totalRows_periodomatriculados;
		         $totaluniversidad[$consultarperiodo] = $totaluniversidad[$consultarperiodo] + $totalRows_periodomatriculados;
			 } // foreach
?>				
  </tr>
<?php 			
			 $contadorperiodo ++ ;
		 }while($row_semestrecarrera = mysql_fetch_assoc($semestrecarrera));?>
  <tr>  
	  <td colspan="1" bgcolor="#C5D5D6"><div align="center" class="Estilo3 Estilo12 Estilo7"><strong><strong>Total</strong></strong></div></td>
	 
<?php 
	foreach($totalporperiodo as $valor => $total)
	 {
?>
	   <td colspan="1"><div align="center" class="Estilo3 Estilo12 Estilo7"><strong><strong><?php echo $total;?></strong></strong></div></td>
<?php  
     }
?>
</tr>
<?php
  } // validacion
  
}while($row_car = mysql_fetch_assoc($car));
?>
  <tr>
   <td align="center" colspan="<?php echo count($_SESSION['periodosseleccionados']) + 1; ?>" bgcolor="#C5D5D6"><strong><span class="Estilo2 Estilo3 Estilo7">DATOS GENERALES UNIVERSIDAD</span></strong></td>  
  </tr> 
  <tr> 
   <td><span class="Estilo7 Estilo3 Estilo8"><strong>Total</strong></span></td>
 
<?php 
   foreach($totaluniversidad as $valor => $total)
	{ 
?>
   <td> <div align="center" class="Estilo8 Estilo3 Estilo7"><?php echo $total;?></div></td>
<?php 
    }
?>
 
  </tr>
</table> 
<?php

} // if 1
else
{ // else
$codigocarrera = $_GET['carrera'];
$totalordenes = 0;
$valortotalordenes = 0;
$ordenesmatriculadas = 0;
$valorordenesmatriculadas = 0;
$nuevo = 0;
$antiguos = 0;
$totalsemestreanterior = 0;
$totalperdida = 0;
$totalreserva = 0;
$totalordenunica = 0;
$totalmayorordenunica = 0;
$ordenestotalidad = 0;
$totalordenestotal = 0;
$totalordenespormitad = 0;
$totalordenespormitadvalor = 0;
$valortotalordenescompletas = 0;

         mysql_select_db($database_sala, $sala);
         foreach($_SESSION['periodosseleccionados'] as $valor => $consultarperiodo)
		  {
			$query_validacion = "SELECT p.codigoestudiante
			FROM prematricula p,estudiante e,ordenpago o
			WHERE e.codigocarrera = '$codigocarrera'
			AND o.idprematricula = p.idprematricula
			AND p.codigoestudiante = e.codigoestudiante
			AND o.codigoestadoordenpago LIKE '4%'
			AND p.codigoperiodo = $consultarperiodo";
			//echo $query_validacion,"<br><br>";
			$validacion = mysql_query($query_validacion, $sala) or die(mysql_error());
			$row_validacion = mysql_fetch_assoc($validacion);
			$totalRows_validacion = mysql_num_rows($validacion);
         
			
              if ($row_validacion == "")
			  {
				echo '<script language="JavaScript">alert("No presenta Matriculas para el periodo '.$consultarperiodo.' "); history.go(-1);</script>';
			  }
		  }		  
		 
	$query_semestrecarrera = "select DISTINCT semestredetallecohorte
	from cohorte c,detallecohorte d
	where c.idcohorte = d.idcohorte 
    and c.codigocarrera = '$codigocarrera'
	and c.codigoperiodo = '$consultarperiodo'";	
	//echo $query_semestrecarrera;//	
	$semestrecarrera = mysql_query($query_semestrecarrera, $sala) or die(mysql_error());
	$row_semestrecarrera = mysql_fetch_assoc($semestrecarrera);
	$totalRows_semestrecarrera = mysql_num_rows($semestrecarrera);
	
	$query_carrera = "select *
	from carrera
	where codigocarrera = '$codigocarrera'";
	$carrera = mysql_query($query_carrera, $sala) or die(mysql_error());
	$row_carrera = mysql_fetch_assoc($carrera);
	$totalRows_carrera = mysql_num_rows($carrera);
?>
<table width="30%" border="1" align="center" bordercolor="#003333">
		  <tr>
		  <td width="32%" colspan="<?php echo count($_SESSION['periodosseleccionados']) + 1; ?>" align="center" bgcolor="#C5D5D6"><strong><span class="Estilo2 Estilo12"><?php echo $row_carrera['nombrecarrera'];?></span></strong></td> 
		  </tr>
		   <tr bgcolor="#C5D5D6">
				<td colspan="1"><div align="center" class="Estilo7 Estilo3 Estilo12"><strong><span class="Estilo10">Semestre</span></strong></div></td>
<?php 
         foreach($_SESSION['periodosseleccionados'] as $valor => $consultarperiodo)
		  {
?>
				<td colspan="1"><span class="Estilo7 Estilo3"><strong><?php echo $consultarperiodo; ?></strong></span></td>
 <?php 
          }
?>
          
  </tr>  
<?php 
			 $contadorperiodo = 1;
			 $matriculadosactual = 0;
			 do{    
?>	
				<tr>
				 <td><div align="center" class="Estilo11"><?php echo $contadorperiodo;?></div></td>
<?php 
         foreach($_SESSION['periodosseleccionados'] as $valor => $consultarperiodo)
		  {
?>

				 <td><div align="center" class="Estilo11">
                 <?php
				  $query_periodomatriculados = "select distinct e.codigoestudiante
			      from estudiante e,ordenpago o,prematricula p,fechaordenpago f
				  where e.codigoestudiante = o.codigoestudiante
				  and o.numeroordenpago = f.numeroordenpago
				  and f.porcentajefechaordenpago = '0'
				  and o.idprematricula = p.idprematricula
				  and o.codigoestadoordenpago like '4%'
				  AND p.codigoestadoprematricula LIKE '4%'
				  AND e.codigosituacioncarreraestudiante NOT LIKE '5%'
				  and p.semestreprematricula = '".$row_semestrecarrera['semestredetallecohorte']."'
				  and e.codigocarrera = '$codigocarrera'
				  and o.codigoperiodo = '$consultarperiodo'";	
				  //echo $query_nuevos,"<br>";
				  $periodomatriculados = mysql_query($query_periodomatriculados, $sala) or die(mysql_error());
				  $row_periodomatriculados = mysql_fetch_assoc($periodomatriculados);
				  $totalRows_periodomatriculados = mysql_num_rows($periodomatriculados);
				    
					echo $totalRows_periodomatriculados;
					$matriculadosactual = $matriculadosactual + $totalRows_periodomatriculados; 
?>  
				</div></td>
<?php 
         $totalporperiodo[$consultarperiodo] = $totalporperiodo[$consultarperiodo] + $totalRows_periodomatriculados;
		 
		  } // foreach
?>
		</tr>
<?php 
		 $contadorperiodo ++ ;
	 }while($row_semestrecarrera = mysql_fetch_assoc($semestrecarrera));	
?> 
	 <tr>  
	  <td colspan="1" bgcolor="#C5D5D6"><div align="center" class="Estilo7 Estilo3 Estilo12"><strong><span class="Estilo10">Total</span></strong></div></td>
	 
<?php 
	foreach($totalporperiodo as $valor => $total)
	 {
?>
	   <td colspan="1"><div align="center" class="Estilo7 Estilo3 Estilo12"><strong><span class="Estilo10"><?php echo $total;?></span></strong></div></td>
<?php  
     }
} 
?>
</tr>
</table>
<br><br><br><br>

<p align="center">
  <input type="button" name="Submit" value="Regresar" onClick="history.go(-1)">
  <input type="button" name="Submit" value="Imprimir" onClick="window.print()">
</p>
