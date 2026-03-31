<?php 
require_once('../../../../Connections/sala2.php');
session_start();
if(!isset ($_SESSION['MM_Username'])){
	echo '<blink><strong style="color:#F00; font-size:18px">No ha iniciado sesión en el sistema</strong></blink>';
	exit();
} 
?>
<html>
<head>
<title> Copia de Planes de Estudio</title>
</head>
<body>
<div align="center">
<form name="formulario" method="post" action="copiarplandeestudios.php">
<table width="514" border="1">
    <tr>
    <td width="504">Plan de Estudios Original :    
      <input type="text" name="planestudiooriginal" value="<?php echo $_REQUEST['planestudio']; ?>">&nbsp;</td>
  </tr>
  <tr>
    <td width="504">Código Carrera :    
      <?php if($_SESSION['MM_Username'] !== 'admintecnologia'){
			?> <input type="text" name="codigocarrera">&nbsp; <?php
		}else{
			?>
			<select name='codigocarrera' id='codigocarrera'>
		<option></option>
			<?php 		
			$carreras = "SELECT F.nombrefacultad, C.nombrecarrera , C.codigocarrera
							FROM facultad F
							INNER JOIN carrera C ON ( C.codigofacultad = F.codigofacultad )
							WHERE F.codigoestado = 100
							AND C.codigomodalidadacademica IN (200,300)
							AND C.codigofacultad != 10
							GROUP BY C.codigocarrera
							ORDER BY C.nombrecarrera ASC";
					//echo "$planestudio9<br>";
					$carreras=mysql_db_query($database_sala,$carreras) or die("$carreras".mysql_error());
					$carrerasAll=mysql_fetch_array($carreras);
			
			do
			{
				echo "<option value='".$carrerasAll['codigocarrera']."'>".$carrerasAll['nombrecarrera']."</option>";
			}
			while($carrerasAll=mysql_fetch_array($carreras)); ?>
		</select>
		<?php } ?>
	  
	
		
	</td>	
  </tr>
  </table>

<input type="submit" name="aceptar" value="Aceptar">
<?php 

if($_POST['aceptar'])
{
	// Primero coloco el plan de estudio
	// Despues coloco los detalles del plan
	
	begin;
	$planestudiooriginal = $_POST['planestudiooriginal'];
	$carrera = $_POST['codigocarrera'];
	$hoy = date("Y-m-d");
	echo $planestudio = "SELECT *
	FROM planestudio 
	WHERE idplanestudio = '".$planestudiooriginal."'
	and codigocarrera = '".$carrera."'"; exit();
	$planestudio1 = mysql_db_query($database_sala,$planestudio);
	$planestudio2 = mysql_fetch_array($planestudio1);
	do 
	{
		if($planestudio2!='')
		{
			
			echo "<h1>PLAN ESTUDIO</h1>";
			// inserta planestudio
			
			// Este es opcional cuando se quiere copiar en otra carrera
			//$planestudio2['codigocarrera'] = "805";
			
			
			$insertoplanestudio3="insert into planestudio values 
			(0,
			'Copia ".$planestudio2['nombreplanestudio']."',
			'".$planestudio2['codigocarrera']."',
			'".$planestudio2['responsableplanestudio']."',
			'".$planestudio2['cargoresponsableplanestudio']."',
			'".$planestudio2['numeroautorizacionplanestudio']."',
			'".$planestudio2['cantidadsemestresplanestudio']."',
			'".$hoy."',
			'".$hoy."',
			'".$planestudio2['fechavencimientoplanestudio']."',
			'101',
			'".$planestudio2['codigotipocantidadelectivalibre']."',
			'".$planestudio2['cantidadelectivalibre']."')";
			//echo "<br><br>$insertoplanestudio3<br>";
			$insertoplanestudio31=mysql_db_query($database_sala,$insertoplanestudio3);
			$nuevoplanestudio=mysql_insert_id();
			
			// inserta detalleplanestudio
			$planestudio4 = "SELECT *
			FROM detalleplanestudio 
			WHERE idplanestudio='".$planestudiooriginal."'";
			//echo "$planestudio4<br>";
			$planestudio5=mysql_db_query($database_sala,$planestudio4) or die("$planestudio4".mysql_error());
			$planestudio6=mysql_fetch_array($planestudio5);
			if($planestudio6 != "")
			{
				do 
				{
					$insertoplanestudio7="insert into detalleplanestudio values 
					('".$nuevoplanestudio."',
					'".$planestudio6['codigomateria']."',
					'".$planestudio6['semestredetalleplanestudio']."',
					'".$planestudio6['valormateriadetalleplanestudio']."',
					'".$planestudio6['numerocreditosdetalleplanestudio']."',
					'".$planestudio6['codigoformacionacademica']."',
					'".$planestudio6['codigoareaacademica']."',
					'".$hoy."',
					'".$hoy."',
					'".$planestudio6['fechavencimientodetalleplanestudio']."',
					'".$planestudio6['codigoestadodetalleplanestudio']."',
					'".$planestudio6['codigotipomateria']."')";
					echo "<br><br>$insertoplanestudio7<br>";
					$insertoplanestudio8=mysql_db_query($database_sala,$insertoplanestudio7);
					// Para los detalles del plan de estudio inserta las referencias
					// inserta referenciaplanestudio
					$planestudio9 = "SELECT *
					FROM referenciaplanestudio 
					WHERE idplanestudio = '".$planestudiooriginal."'
					and codigomateria = '".$planestudio6['codigomateria']."'";
					//echo "$planestudio9<br>";
					$planestudio10=mysql_db_query($database_sala,$planestudio9) or die("$planestudio9".mysql_error());
					$planestudio11=mysql_fetch_array($planestudio10);
					if($planestudio11 != "")
					{
						do
						{
							$insertoplanestudio12="insert into referenciaplanestudio values 
							('".$nuevoplanestudio."',
							'".$planestudio11['idlineaenfasisplanestudio']."',
							'".$planestudio11['codigomateria']."',
							'".$planestudio11['codigomateriareferenciaplanestudio']."',
							'".$planestudio11['codigotiporeferenciaplanestudio']."',
							'".$hoy."',
							'".$hoy."',
							'".$planestudio11['fechavencimientoreferenciaplanestudio']."',
							'".$planestudio11['codigoestadoreferenciaplanestudio']."')";
							echo "$insertoplanestudio12<br>";
							$insertoplanestudio13=mysql_db_query($database_sala,$insertoplanestudio12) or die(mysql_error());
						}
						while($planestudio11=mysql_fetch_array($planestudio10));
					}
				}
				while($planestudio6=mysql_fetch_array($planestudio5));
			}

			// Inserta las lineas de enfasis
			$query_lineaenfasis = "select *
			from lineaenfasisplanestudio
			where idplanestudio = '".$planestudiooriginal."'";
			$lineaenfasis = mysql_db_query($database_sala, $query_lineaenfasis);
			$totalRows_lineaenfasis = mysql_num_rows($lineaenfasis);
			if($totalRows_lineaenfasis != "")
			{
				$row_lineaenfasis = mysql_fetch_array($lineaenfasis);
				do
				{
					$query_inslineaenfasis="INSERT INTO lineaenfasisplanestudio(idlineaenfasisplanestudio, idplanestudio, nombrelineaenfasisplanestudio, fechacreacionlineaenfasisplanestudio, fechainiciolineaenfasisplanestudio, fechavencimientolineaenfasisplanestudio, responsablelineaenfasisplanestudio, codigoestadolineaenfasisplanestudio) 
				    VALUES(0, '$nuevoplanestudio', '".$row_lineaenfasis['nombrelineaenfasisplanestudio']."', '$hoy', '$hoy', '2999-12-31', '".$row_lineaenfasis['responsablelineaenfasisplanestudio']."', '101')";
					echo "$query_inslineaenfasis<br>";
					$inslineaenfasis=mysql_db_query($database_sala,$query_inslineaenfasis) or die(mysql_error());
					$nuevalineaenfasis=mysql_insert_id();
					
					// Para cada linea de enfasis creada inserta los detalles
					// Inserta los detalles de las lineas de enfasis
					$query_detallelineaenfasis = "select *
					from detallelineaenfasisplanestudio
					where idplanestudio = '".$planestudiooriginal."'
					and idlineaenfasisplanestudio = '".$row_lineaenfasis['idlineaenfasisplanestudio']."'";
					$detallelineaenfasis = mysql_db_query($database_sala, $query_detallelineaenfasis);
					$totalRows_detallelineaenfasis = mysql_num_rows($detallelineaenfasis);
					if($totalRows_detallelineaenfasis != "")
					{
						$row_detallelineaenfasis = mysql_fetch_array($detallelineaenfasis);
						do
						{
							$query_insdetallelineaenfasis = "INSERT INTO detallelineaenfasisplanestudio(idlineaenfasisplanestudio, idplanestudio, codigomateria, codigomateriadetallelineaenfasisplanestudio, codigotipomateria, valormateriadetallelineaenfasisplanestudio, semestredetallelineaenfasisplanestudio, numerocreditosdetallelineaenfasisplanestudio, fechacreaciondetallelineaenfasisplanestudio, fechainiciodetallelineaenfasisplanestudio, fechavencimientodetallelineaenfasisplanestudio, codigoestadodetallelineaenfasisplanestudio) 
						    VALUES('$nuevalineaenfasis', '$nuevoplanestudio', '".$row_detallelineaenfasis['codigomateria']."', '".$row_detallelineaenfasis['codigomateriadetallelineaenfasisplanestudio']."', '".$row_detallelineaenfasis['codigotipomateria']."', '".$row_detallelineaenfasis['valormateriadetallelineaenfasisplanestudio']."', '".$row_detallelineaenfasis['semestredetallelineaenfasisplanestudio']."', '".$row_detallelineaenfasis['numerocreditosdetallelineaenfasisplanestudio']."', '$hoy', '$hoy', '2999-12-31', '101')";
							echo "$query_insdetallelineaenfasis<br>";
							$insdetallelineaenfasis = mysql_db_query($database_sala,$query_insdetallelineaenfasis) or die(mysql_error());
						}
						while($row_detallelineaenfasis = mysql_fetch_array($detallelineaenfasis));
					}
				}
				while($row_lineaenfasis=mysql_fetch_array($lineaenfasis));
			}
		}
		else
		{
			echo "No existe este plan de estudios para crear copia";
		}
	}
	while($planestudio2=mysql_fetch_array($planestudio1));
	commit;
	
	// Selecciona las lineas de enfasis
	echo "<h1>Operacion realizada</h1>", $nuevoplanestudio;
	
}
	
?>
</form>
</div>
</body>
</html>