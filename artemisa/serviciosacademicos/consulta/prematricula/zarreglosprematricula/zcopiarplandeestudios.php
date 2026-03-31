<?php 
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
require_once('../../../Connections/sala2.php'); 
$sala = mysql_pconnect($hostname_sala, $username_sala, $password_sala) or trigger_error(mysql_error(),E_USER_ERROR); mysql_select_db($database_sala, $sala);
session_start();
require_once('../../../funciones/clases/autenticacion/redirect.php' );
?>
<html>
<head>
<title> Copia de Planes de Estudio</title>
</head>
<body>
<div align="center">
<form name="formulario" method="post" action="zcopiarplandeestudios.php">
<table width="514" border="1">
    <tr>
    <td width="504">Plan de Estudios Original :    
      <input type="text" name="planestudiooriginal">&nbsp;</td>
  </tr>
  <tr>
    <td width="504">Código Carrera :    
      <input type="text" name="codigocarrera">&nbsp;
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
	$planestudio = "SELECT *
	FROM planestudio 
	WHERE idplanestudio = '".$planestudiooriginal."'
	and codigocarrera = '".$carrera."'";
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
			$planestudio2['nombreplanestudio'] = "98-2";
			
			$insertoplanestudio3="insert into planestudio values 
			(0,
			'".$planestudio2['nombreplanestudio']."',
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
			echo "<br><br>$insertoplanestudio3<br>";
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