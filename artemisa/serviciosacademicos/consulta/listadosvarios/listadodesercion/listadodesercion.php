<?php require_once('../../../Connections/sala2.php');

session_start();

mysql_select_db($database_sala, $sala);


$codigocarrera = $_SESSION['codigofacultad'];

$periodo = $_SESSION['codigoperiodosesion'];



if (isset($_GET['carrera']))

  {

   unset($codigocarrera);

   $codigocarrera = $_GET['carrera'];

  }



if (isset($_GET['todas']))

  { // if todas

 /////////////////////////////////////////////////////////////////////////////////////////////////////////////////   

        $fecha = date("Y-m-d G:i:s",time());

		mysql_select_db($database_sala, $sala);

		$query_car = "SELECT nombrecarrera,codigocarrera 

						FROM carrera

						WHERE codigomodalidadacademica = '200'						

					    AND fechavencimientocarrera > '".$fecha."'	

					    order by 1";		

		$car = mysql_query($query_car, $sala) or die(mysql_error());

		$row_car = mysql_fetch_assoc($car);

		$totalRows_car = mysql_num_rows($car);		

//echo $query_car;

?>

<style type="text/css">

<!--

.Estilo1 {font-family: Tahoma; font-size: 12px}

.Estilo2 {font-family: Tahoma; font-size: 12px; font-weight: bold; }

.Estilo3 {font-family: Tahoma; font-size: 14px; font-weight: bold; }

.Estilo4 {color: #FF6600}

-->

</style>



  <body>

  <div align="center" class="Estilo3">REPORTE DESERCIÓN</div>

  <?php	   

      $prematriculau=0;

	  $sinprematriculau=0;    

	  echo "<div align='center'><span class='Estilo2'>Periodo&nbsp",$periodo,"</span></div><br>";

	   do{

			   $codigocarrera = $row_car['codigocarrera'];

			  

			  $query_semestrecarrera = "SELECT nombrecarrera,MAX(semestredetalleplanestudio * 1) AS mayor

						FROM planestudio p,detalleplanestudio d,carrera c

						WHERE p.idplanestudio = d.idplanestudio

						AND c.codigocarrera = p.codigocarrera

						AND p.codigoestadoplanestudio LIKE '1%'

						and p.codigocarrera = '$codigocarrera' 

						GROUP by 1						                         

	";	

//echo $query_semestrecarrera;

$semestrecarrera = mysql_query($query_semestrecarrera, $sala) or die("1");

$row_semestrecarrera = mysql_fetch_assoc($semestrecarrera);

$totalRows_semestrecarrera = mysql_num_rows($semestrecarrera);

?>

  <form action="" method="post" name="form1" class="Estilo1">

  <table width="85%" border="1" align="center" cellpadding="1" bordercolor="#003333">

  <tr bgcolor="#C5D5D6" class="Estilo2">

    <td colspan="7" align="center"><?php echo $row_semestrecarrera['nombrecarrera'];?></td>

  </tr>

  <tr bgcolor="#C5D5D6" class="Estilo2">

  <td align="center">Documento</td>

    <td align="center">Nombre</td>

    <td align="center">Situaci&oacute;n Carrera</td>

    <td align="center">Tipo Estudiante</td>

    <td align="center">Estado</td>

    <td align="center">Teléfono</td>

    <td align="center">E-mail</td>

  </tr>

<?php



mysql_select_db($database_sala, $sala);

$query_periodos = "SELECT distinct codigoperiodo

				   FROM prematricula

				   order by 1 desc";

$periodos = mysql_query($query_periodos, $sala) or die(mysql_error());

$row_periodos = mysql_fetch_assoc($periodos);

$totalRows_periodos = mysql_num_rows($periodos);

$contadorperiodo = 0;

do{

    if ($contadorperiodo == 1)

     {

	   $periodocierre = $row_periodos['codigoperiodo'];

	    $contadorperiodo = 0;

	 }

  

   if ($periodo == $row_periodos['codigoperiodo'])

     {

	   $contadorperiodo = 1;	   

	 }

  

}while($row_periodos = mysql_fetch_assoc($periodos));

//echo $periodocierre;

mysql_select_db($database_sala, $sala);

$query_estudiante = "select distinct e.codigoestudiante,eg.apellidosestudiantegeneral
from estudiante e,ordenpago o,prematricula p,fechaordenpago f,estudiantegeneral eg
where e.codigoestudiante = o.codigoestudiante
and eg.idestudiantegeneral = e.idestudiantegeneral
and o.numeroordenpago = f.numeroordenpago
and o.idprematricula = p.idprematricula
and o.codigoestadoordenpago like '4%'
and p.codigoestadoprematricula like '4%'					 
and e.codigocarrera = '$codigocarrera'
and o.codigoperiodo = '$periodocierre'
and p.semestreprematricula <> '".$row_semestrecarrera['mayor']."'
and e.codigosituacioncarreraestudiante not like '104%'
and e.codigosituacioncarreraestudiante not like '400%'
order by 2";
$estudiante = mysql_query($query_estudiante, $sala) or die("2");
$row_estudiante = mysql_fetch_assoc($estudiante);
$totalRows_estudiante = mysql_num_rows($estudiante);

if ($row_estudiante <> "")
{
 $prematricula = 0;
 $sinprematricula = 0;

 do{

    mysql_select_db($database_sala, $sala);

	$query_estudiante1 = "select distinct e.codigoestudiante

						 from estudiante e,ordenpago o,prematricula p,fechaordenpago f

						 where e.codigoestudiante = o.codigoestudiante

						 and o.numeroordenpago = f.numeroordenpago
						 and o.idprematricula = p.idprematricula

						 and o.codigoestadoordenpago like '4%'					 

						 and e.codigocarrera = '$codigocarrera'

						 and o.codigoperiodo = '$periodo'

						 and p.codigoestudiante = '".$row_estudiante['codigoestudiante']."'";

	$estudiante1 = mysql_query($query_estudiante1, $sala) or die("3");

	$row_estudiante1 = mysql_fetch_assoc($estudiante1);

	$totalRows_estudiante1 = mysql_num_rows($estudiante1);

    

	if (!$row_estudiante1)

	  { //i f1

			 mysql_select_db($database_sala, $sala);

			$query_estudiante2 = "select distinct e.codigoestudiante

								 from estudiante e,ordenpago o,prematricula p,fechaordenpago f

								 where e.codigoestudiante = o.codigoestudiante

								 and o.numeroordenpago = f.numeroordenpago
								 and o.idprematricula = p.idprematricula

								 and o.codigoestadoordenpago like '1%'					 

								 and e.codigocarrera = '$codigocarrera'

								 and o.codigoperiodo = '$periodo'

								 and p.codigoestudiante = '".$row_estudiante['codigoestudiante']."'";

			$estudiante2 = mysql_query($query_estudiante2, $sala) or die("4");

			$row_estudiante2 = mysql_fetch_assoc($estudiante2);

			$totalRows_estudiante2= mysql_num_rows($estudiante2);

	         //echo $query_estudiante2,"<br>";

	       

		     if (!$row_estudiante2)

			   { // 2

			        mysql_select_db($database_sala, $sala);

					$query_estudiante3 = "select distinct e.codigoestudiante

										 from estudiante e,ordenpago o,prematricula p,fechaordenpago f

										 where e.codigoestudiante = o.codigoestudiante

										 and o.numeroordenpago = f.numeroordenpago										

										 and o.idprematricula = p.idprematricula

										 and o.codigoestadoordenpago like '2%'					 

										 and e.codigocarrera = '$codigocarrera'

										 and o.codigoperiodo = '$periodo'

										 and p.codigoestudiante = '".$row_estudiante['codigoestudiante']."'";

					$estudiante3 = mysql_query($query_estudiante3, $sala) or die("5");

					$row_estudiante3 = mysql_fetch_assoc($estudiante3);

					$totalRows_estudiante3= mysql_num_rows($estudiante3);

			   

			          if (!$row_estudiante3)

					   { // if 3

			      

							  mysql_select_db($database_sala, $sala);

							  $query_data = "SELECT e.codigoestudiante,eg.nombresestudiantegeneral,eg.apellidosestudiantegeneral,

	                                         eg.telefonoresidenciaestudiantegeneral,eg.emailestudiantegeneral,s.nombresituacioncarreraestudiante,t.nombretipoestudiante,eg.numerodocumento

									FROM estudiante e,situacioncarreraestudiante s,tipoestudiante t,estudiantegeneral eg									 

									WHERE e.codigoestudiante = '".$row_estudiante['codigoestudiante']."'

									AND e.idestudiantegeneral = eg.idestudiantegeneral

									AND e.codigosituacioncarreraestudiante = s.codigosituacioncarreraestudiante

									AND e.codigotipoestudiante = t.codigotipoestudiante			                                

			";

							  $data = mysql_query($query_data, $sala) or die("6");

							  $row_data = mysql_fetch_assoc($data);

							  $totalRows_data = mysql_num_rows($data);

							//echo $query_data;

							$sinprematricula ++ ;

	                  if ($row_data <> "")

						{

	?>

						<tr class="Estilo1">

						<td align="center"><?php echo  $row_data['numerodocumento']; ?>&nbsp;</td>

						<td align="center"><?php echo  $row_data['apellidosestudiantegeneral'];?>&nbsp;<?php echo  $row_data['nombresestudiantegeneral'];?></td>

						<td align="center"><?php echo  $row_data['nombresituacioncarreraestudiante'];?>&nbsp;</td>

						<td align="center"><?php echo  $row_data['nombretipoestudiante'];?>&nbsp;</td>

						<td align="center">Sin Prematricula</td>

						<td align="center"><?php echo  $row_data['telefonoresidenciaestudiantegeneral'];?>&nbsp;</td>

						<td align="center"><a href="mailto:<?php echo  $row_data['emailestudiantegeneral'];?>"><?php echo  $row_data['emailestudiantegeneral'];?></a>&nbsp;</td>

	</tr>

<?php	

					    }

					   } // if 3

					  else

					   {		    

							 mysql_select_db($database_sala, $sala);

							 $query_data = "SELECT e.codigoestudiante,eg.nombresestudiantegeneral,eg.apellidosestudiantegeneral,

	                                         eg.telefonoresidenciaestudiantegeneral,eg.emailestudiantegeneral,s.nombresituacioncarreraestudiante,t.nombretipoestudiante,eg.numerodocumento

									FROM estudiante e,situacioncarreraestudiante s,tipoestudiante t,estudiantegeneral eg									 

									WHERE e.codigoestudiante = '".$row_estudiante['codigoestudiante']."'

									AND e.idestudiantegeneral = eg.idestudiantegeneral

									AND e.codigosituacioncarreraestudiante = s.codigosituacioncarreraestudiante

									AND e.codigotipoestudiante = t.codigotipoestudiante			                                

			";

							  $data = mysql_query($query_data, $sala) or die("7");

							  $row_data = mysql_fetch_assoc($data);

							  $totalRows_data = mysql_num_rows($data);

						//echo $query_data;  

						$sinprematricula ++; 

						if ($row_data <> "")

						  {

						 ?>

							<tr class="Estilo1">

							<td align="center"><?php echo  $row_data['numerodocumento'];?>&nbsp;</td>

							<td align="center"><?php echo  $row_data['apellidosestudiantegeneral'];?>&nbsp;<?php echo  $row_data['nombresestudiantegeneral'];?></td>

							<td align="center"><?php echo  $row_data['nombresituacioncarreraestudiante'];?>&nbsp;</td>

							<td align="center"><?php echo  $row_data['nombretipoestudiante'];?>&nbsp;</td>

							<td align="center">Sin Prematicula&nbsp;</td>

							<td><div align="center"><?php echo  $row_data['telefonoresidenciaestudiantegeneral'];?>&nbsp;</td>

							<td><div align="center"><a href="mailto:<?php echo  $row_data['emailestudiantegeneral'];?>"><?php echo  $row_data['emailestudiantegeneral'];?></a>&nbsp;</td>

	</tr>

<?php  

			               }

					}  

			  }//if 2

			 else

			  {		    

				  mysql_select_db($database_sala, $sala);

				  $query_data = "SELECT e.codigoestudiante,eg.nombresestudiantegeneral,eg.apellidosestudiantegeneral,

	                                         eg.telefonoresidenciaestudiantegeneral,eg.emailestudiantegeneral,s.nombresituacioncarreraestudiante,t.nombretipoestudiante,eg.numerodocumento

									FROM estudiante e,situacioncarreraestudiante s,tipoestudiante t,estudiantegeneral eg									 

									WHERE e.codigoestudiante = '".$row_estudiante['codigoestudiante']."'

									AND e.idestudiantegeneral = eg.idestudiantegeneral

									AND e.codigosituacioncarreraestudiante = s.codigosituacioncarreraestudiante

									AND e.codigotipoestudiante = t.codigotipoestudiante			                                

			";

							  $data = mysql_query($query_data, $sala) or die("$query_data".mysql_error());

							  $row_data = mysql_fetch_assoc($data);

							  $totalRows_data = mysql_num_rows($data);

				  //echo $query_data;  

				  $prematricula ++; 
?>

							<tr class="Estilo1">

							<td><div align="center"><?php echo  $row_data['numerodocumento'];?>&nbsp;</div></td>

							<td><div align="center"><?php echo  $row_data['apellidosestudiantegeneral'];?>&nbsp;<?php echo  $row_data['nombresestudiantegeneral'];?></div></td>

							<td><div align="center"><?php echo  $row_data['nombresituacioncarreraestudiante'];?>&nbsp;</div></td>

							<td><div align="center"><?php echo  $row_data['nombretipoestudiante'];?>&nbsp;</div></td>

							<td><div align="center">Prematriculado</div></td>

							<td><div align="center"><?php echo  $row_data['telefonoresidenciaestudiantegeneral'];?>&nbsp;</div></td>

							<td><div align="center"><a href="mailto:<?php echo  $row_data['emailestudiantegeneral'];?>"><?php echo  $row_data['emailestudiantegeneral'];?></a>&nbsp;</div></td>

	</tr>

<?php	 

	         }

	  }//i f1  

  }while($row_estudiante = mysql_fetch_assoc($estudiante));



echo "<tr>";

echo "<td colspan='3'><div align='center'><span class='Estilo2'>Prematriculados&nbsp;&nbsp;",$prematricula,"</span></div></td>";

echo "<td colspan='4'><div align='center'><span class='Estilo2'>Sin Prematricula&nbsp;&nbsp;",$sinprematricula,"</span></div></td>";

echo "</tr>";



$prematriculau = $prematriculau + $prematricula;

$sinprematriculau = $sinprematriculau + $sinprematricula;

} // if 2	  

?>  

</table>      

<br>

<?php

  

}while($row_car = mysql_fetch_assoc($car)); 

?>

<table width="85%" border="1" align="center" cellpadding="1" bordercolor="#003333">

 <tr  bgcolor="#C5D5D6" class="Estilo2">

  <td colspan='7'><div align='center'>TOTAL UNIVERSIDAD</div></td>

 </tr>

  <tr class="Estilo2">

  <td colspan='3'><div align='center'>Prematriculados&nbsp;&nbsp;<?php echo $prematriculau;?></div></td>

  <td colspan='4'><div align='center'>Sin Prematricula&nbsp;&nbsp;<?php echo $sinprematriculau;?></div></td>

 </tr>

</table>

<br>

 <div align="center"> 

  <input type="button" name="Submit" value="Imprimir" onClick="window.print()">&nbsp; <input type="button" name="Submit" value="Regresar" onClick="history.go(-1)">

 </div>

<?php
exit();  
  }  // if todas
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	
	
	
	$query_semestrecarrera = "SELECT nombrecarrera,MAX(semestredetalleplanestudio * 1) AS mayor
	FROM planestudio p,detalleplanestudio d,carrera c
	WHERE p.idplanestudio = d.idplanestudio
	AND c.codigocarrera = p.codigocarrera
	AND p.codigoestadoplanestudio LIKE '1%'
	and p.codigocarrera = '$codigocarrera' 
	GROUP by 1";	
	//echo $query_semestrecarrera;
	$semestrecarrera = mysql_query($query_semestrecarrera, $sala) or die("$query_semestrecarrera".mysql_error());
	$row_semestrecarrera = mysql_fetch_assoc($semestrecarrera);
	$totalRows_semestrecarrera = mysql_num_rows($semestrecarrera);

?>

<style type="text/css">

<!--

.Estilo1 {font-family: Tahoma; font-size: 12px}

.Estilo2 {font-family: Tahoma; font-size: 12px; font-weight: bold; }

.Estilo3 {font-family: Tahoma; font-size: 14px; font-weight: bold; }

.Estilo4 {color: #FF6600}

-->

</style>

<form action="" method="post" name="form1" class="Estilo1">

  <div align="center"> <span class="Estilo3">REPORTE DESERCIÓN </span></div>

  <?php echo "<div align='center'><span class='Estilo2'>Periodo&nbsp",$periodo,"<br></span></div>";?>

  <table width="200" border="0" cellpadding="0" cellspacing="0">

    <tr>

      <td>&nbsp;</td>

    </tr>

  </table>

  <table width="85%" border="1" align="center" cellpadding="1" bordercolor="#003333">

  <tr bgcolor="#C5D5D6" class="Estilo2">

    <td colspan="7"><div align="center"><?php echo $row_semestrecarrera['nombrecarrera'];?></div></td>

    </tr>

  <tr bgcolor="#C5D5D6" class="Estilo2">

  <td><div align="center">Documento</div></td>

    <td><div align="center">Nombre</div></td>

    <td><div align="center">Situaci&oacute;n Carrera</div></td>

    <td><div align="center">Tipo Estudiante</div></td>

    <td><div align="center">Estado</div></td>

    <td><div align="center">Teléfono</div></td>

    <td><div align="center">E-mail</div></td>

  </tr>

<?php
mysql_select_db($database_sala, $sala);
$query_periodos = "SELECT distinct codigoperiodo
FROM prematricula
order by 1 desc";
$periodos = mysql_query($query_periodos, $sala) or die("9");
$row_periodos = mysql_fetch_assoc($periodos);
$totalRows_periodos = mysql_num_rows($periodos);
$contadorperiodo = 0;
do{

    if ($contadorperiodo == 1)

     {

	   $periodocierre = $row_periodos['codigoperiodo'];

	    $contadorperiodo = 0;

	 }

  

   if ($periodo == $row_periodos['codigoperiodo'])

     {

	   $contadorperiodo = 1;	   

	 } 

}while($row_periodos = mysql_fetch_assoc($periodos));

//echo $periodocierre;

mysql_select_db($database_sala, $sala);

	$query_estudiante = "select distinct e.codigoestudiante,eg.apellidosestudiantegeneral
	from estudiante e,ordenpago o,prematricula p,fechaordenpago f,estudiantegeneral eg
	where e.codigoestudiante = o.codigoestudiante
	and e.idestudiantegeneral = eg.idestudiantegeneral
	and o.numeroordenpago = f.numeroordenpago	
	and o.idprematricula = p.idprematricula
	and o.codigoestadoordenpago like '4%'
	and p.codigoestadoprematricula like '4%'					 
	and e.codigocarrera = '$codigocarrera'
	and o.codigoperiodo = '$periodocierre'
	and p.semestreprematricula <> '".$row_semestrecarrera['mayor']."'
	and e.codigosituacioncarreraestudiante not like '104%'
	and e.codigosituacioncarreraestudiante not like '400%'
	order by 2";
	//echo $query_estudiante;
	$estudiante = mysql_query($query_estudiante, $sala) or die("10");
	$row_estudiante = mysql_fetch_assoc($estudiante);
	$totalRows_estudiante = mysql_num_rows($estudiante);
    $prematricula = 0;
    $sinprematricula = 0;
 do{

    mysql_select_db($database_sala, $sala);

	$query_estudiante1 = "select distinct e.codigoestudiante
	from estudiante e,ordenpago o,prematricula p,fechaordenpago f
	where e.codigoestudiante = o.codigoestudiante
    and o.numeroordenpago = f.numeroordenpago    
	and o.idprematricula = p.idprematricula
	and o.codigoestadoordenpago like '4%'					 
	and e.codigocarrera = '$codigocarrera'
    and o.codigoperiodo = '$periodo'
    and p.codigoestudiante = '".$row_estudiante['codigoestudiante']."'";
	//echo $query_estudiante1,"<br>";
	$estudiante1 = mysql_query($query_estudiante1, $sala) or die("11");
	$row_estudiante1 = mysql_fetch_assoc($estudiante1);
	$totalRows_estudiante1 = mysql_num_rows($estudiante1);

	if (!$row_estudiante1)
	  { //i f1
		 mysql_select_db($database_sala, $sala);
		$query_estudiante2 = "select distinct e.codigoestudiante
		from estudiante e,ordenpago o,prematricula p,fechaordenpago f
	    where e.codigoestudiante = o.codigoestudiante
		and o.numeroordenpago = f.numeroordenpago		
	    and o.idprematricula = p.idprematricula
	    and o.codigoestadoordenpago like '1%'					 
		and e.codigocarrera = '$codigocarrera'
	    and o.codigoperiodo = '$periodo'
	    and p.codigoestudiante = '".$row_estudiante['codigoestudiante']."'";
	  // echo $query_estudiante2,"<br>";
	    $estudiante2 = mysql_query($query_estudiante2, $sala) or die("12");
		$row_estudiante2 = mysql_fetch_assoc($estudiante2);
    	$totalRows_estudiante2= mysql_num_rows($estudiante2);
	         //echo $query_estudiante2,"<br>";
		     if (!$row_estudiante2)
			   { // 2
			        mysql_select_db($database_sala, $sala);
					$query_estudiante3 = "select distinct e.codigoestudiante
					from estudiante e,ordenpago o,prematricula p,fechaordenpago f
					where e.codigoestudiante = o.codigoestudiante
					and o.numeroordenpago = f.numeroordenpago				   
					and o.idprematricula = p.idprematricula
					and o.codigoestadoordenpago like '2%'					 
					and e.codigocarrera = '$codigocarrera'
					and o.codigoperiodo = '$periodo'
				    and p.codigoestudiante = '".$row_estudiante['codigoestudiante']."'";
					$estudiante3 = mysql_query($query_estudiante3, $sala) or die("13");
					$row_estudiante3 = mysql_fetch_assoc($estudiante3);
					$totalRows_estudiante3= mysql_num_rows($estudiante3);
			          if (!$row_estudiante3)
					   { // if 3
						  mysql_select_db($database_sala, $sala);
						 $query_data = "SELECT e.codigoestudiante,eg.nombresestudiantegeneral,eg.apellidosestudiantegeneral,
                         eg.telefonoresidenciaestudiantegeneral,eg.emailestudiantegeneral,s.nombresituacioncarreraestudiante,t.nombretipoestudiante,eg.numerodocumento
						 FROM estudiante e,situacioncarreraestudiante s,tipoestudiante t,estudiantegeneral eg									 
						 WHERE e.codigoestudiante = '".$row_estudiante['codigoestudiante']."'
						 AND e.idestudiantegeneral = eg.idestudiantegeneral
						 AND e.codigosituacioncarreraestudiante = s.codigosituacioncarreraestudiante
						 AND e.codigotipoestudiante = t.codigotipoestudiante";		   
						  $data = mysql_query($query_data, $sala) or die("14");
						  $row_data = mysql_fetch_assoc($data);
						  $totalRows_data = mysql_num_rows($data);
							//echo $query_data;
						$sinprematricula ++ ;

	                  if ($row_data <> "")

						{ ?>

						<tr class="Estilo1">

						<td><div align="center"><?php echo  $row_data['numerodocumento']; ?></div></td>

						<td><div align="center"><?php echo  $row_data['apellidosestudiantegeneral'];?>&nbsp;<?php echo  $row_data['nombresestudiantegeneral'];?></div></td>

						<td><div align="center"><?php echo  $row_data['nombresituacioncarreraestudiante'];?></div></td>

						<td><div align="center"><?php echo  $row_data['nombretipoestudiante'];?>&nbsp;</div></td>

						<td><div align="center">Sin Prematricula</div></td>

						<td><div align="center"><?php echo  $row_data['telefonoresidenciaestudiantegeneral'];?>&nbsp;</div></td>

						<td><div align="center"><a href="mailto:<?php echo  $row_data['emailestudiantegeneral'];?>"><?php echo  $row_data['emailestudiantegeneral'];?></a>&nbsp;</div></td>

	</tr>

<?php	
					    }

					   } // if 3

					  else

					   {		    

							 mysql_select_db($database_sala, $sala);

							 $query_data = "SELECT e.codigoestudiante,eg.nombresestudiantegeneral,eg.apellidosestudiantegeneral,
                             eg.telefonoresidenciaestudiantegeneral,eg.emailestudiantegeneral,s.nombresituacioncarreraestudiante,t.nombretipoestudiante,eg.numerodocumento
							 FROM estudiante e,situacioncarreraestudiante s,tipoestudiante t,estudiantegeneral eg									 
							 WHERE e.codigoestudiante = '".$row_estudiante['codigoestudiante']."'
							 AND e.idestudiantegeneral = eg.idestudiantegeneral
							 AND e.codigosituacioncarreraestudiante = s.codigosituacioncarreraestudiante
							 AND e.codigotipoestudiante = t.codigotipoestudiante			                                

			";

							  $data = mysql_query($query_data, $sala) or die("15");

							  $row_data = mysql_fetch_assoc($data);

							  $totalRows_data = mysql_num_rows($data);

						//echo $query_data;  

						$sinprematricula ++; 

						 if ($row_data <> "")

						  {

						   ?>

							<tr class="Estilo1">

							<td><div align="center"><?php echo  $row_data['numerodocumento'];?></div></td>

							<td><div align="center"><?php echo  $row_data['apellidosestudiantegeneral'];?>&nbsp;<?php echo  $row_data['nombresestudiantegeneral'];?></div></td>

							<td><div align="center"><?php echo  $row_data['nombresituacioncarreraestudiante'];?></div></td>

							<td><div align="center"><?php echo  $row_data['nombretipoestudiante'];?>&nbsp;</div></td>

							<td><div align="center">Sin Prematicula&nbsp;</div></td>

							<td><div align="center"><?php echo  $row_data['telefonoresidenciaestudiantegeneral'];?>&nbsp;</div></td>

							<td><div align="center"><a href="mailto:<?php echo  $row_data['emailestudiantegeneral'];?>"><?php echo  $row_data['emailestudiantegeneral'];?></a>&nbsp;</div></td>

	</tr>

<?php  

			              }

				    }  

			  }//if 2

			 else

			  {		    

				  mysql_select_db($database_sala, $sala);

				  $query_data = "SELECT e.codigoestudiante,eg.nombresestudiantegeneral,eg.apellidosestudiantegeneral,
                  eg.telefonoresidenciaestudiantegeneral,eg.emailestudiantegeneral,s.nombresituacioncarreraestudiante,t.nombretipoestudiante,eg.numerodocumento
				  FROM estudiante e,situacioncarreraestudiante s,tipoestudiante t,estudiantegeneral eg									 
				  WHERE e.codigoestudiante = '".$row_estudiante['codigoestudiante']."'
				  AND e.idestudiantegeneral = eg.idestudiantegeneral
				  AND e.codigosituacioncarreraestudiante = s.codigosituacioncarreraestudiante
				  AND e.codigotipoestudiante = t.codigotipoestudiante";
				 $data = mysql_query($query_data, $sala) or die("16");
			     $row_data = mysql_fetch_assoc($data);
				  $totalRows_data = mysql_num_rows($data);

				  //echo $query_data;  

				  $prematricula ++; 

			   if ($row_data <> "")

						  {

						 ?>

							<tr class="Estilo1">

							<td><div align="center"><?php echo  $row_data['numerodocumento'];?></div></td>

							<td><div align="center"><?php echo  $row_data['apellidosestudiantegeneral'];?>&nbsp;<?php echo  $row_data['nombresestudiantegeneral'];?></div></td>

							<td><div align="center"><?php echo  $row_data['nombresituacioncarreraestudiante'];?></div></td>

							<td><div align="center"><?php echo  $row_data['nombretipoestudiante'];?>&nbsp;</div></td>

							<td><div align="center">Prematriculado</div></td>

							<td><div align="center"><?php echo  $row_data['telefonoresidenciaestudiantegeneral'];?>&nbsp;</div></td>

							<td><div align="center"><a href="mailto:<?php echo  $row_data['emailestudiantegeneral'];?>"><?php echo  $row_data['emailestudiantegeneral'];?></a>&nbsp;</div></td>

	</tr>

<?php	 

	                       }

			 }

	  }//i f1  

  }while($row_estudiante = mysql_fetch_assoc($estudiante));

echo "<tr>";

if ($row_data <> "")

 {

	echo "<td colspan='3'><div align='center'><span class='Estilo2'>Prematriculados&nbsp;&nbsp;",$prematricula,"</span></div></td>";

	echo "<td colspan='4'><div align='center'><span class='Estilo2'>Sin Prematricula&nbsp;&nbsp;",$sinprematricula,"</span></div></td>";

 }

echo "</tr>";

?>  

</table>

<p align="center">

  <input type="button" name="Submit" value="Imprimir" onClick="window.print()">&nbsp; <input type="button" name="Submit" value="Regresar" onClick="history.go(-1)">

</p>

</form>

