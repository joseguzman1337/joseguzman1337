<?php
/*
 * @modified Ivan quintero <quinteroivan@unbosque.edu.co>
 * formateo del texto, adicion de realpath
 *
 * @since  November 22, 2016
*/

/* END */
	require_once(realpath(dirname(__FILE__)).'/../../../Connections/sala2.php');
	mysql_select_db($database_sala, $sala);
	session_start();
	//require_once('seguridadplandeestudio.php');
	$codigocarrera = $_SESSION['codigofacultad'];
?>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Planes de estudio en construcción</title>
		<style type="text/css">
			<!--
			.Estilo1 {
				font-size: 12px;
				font-family: Tahoma;
			}
			.Estilo2 {
				font-size: 14px;
				font-family: Tahoma;
				font-weight: bold;
			}
			-->
		</style>
	</head>
	<body>
		<div align="center">
			<form action="plandeestudioinicial.php" name="f1" method="post">
				<p align="center" class="Estilo2"> VISUALIZACION DE HORARIOS POR PLAN DE ESTUDIO</p>
				<span class="Estilo1">
					<?php
					// Se selecciona el plan de estudios de acuerdo a la fecha, es decir que en determinada fecha queda 
					// activo, esto se hace con la fecha del sistema
					/*
					echo date("Y-m-d")."<br>";
					select c.nombrecarrera, p.nombreplanestudio, p.idplanestudio
					from planestudio p, carrera c
					where c.codigocarrera = p.codigocarrera
					and c.codigocarrera = '730'//'$codigocarrera'
					//and p.codigoestadoplanestudio = '101'
					and p.fechainioplanestudio <= '2007-04-02'
					and p.fechavencimientoplanestudio >= '2007-04-02'
					*/
					// Selecciona los planes de estudio que posee la facultad en construccion
					$query_planesdeestudio = "select c.nombrecarrera, p.nombreplanestudio, p.idplanestudio from planestudio p, carrera c where c.codigocarrera = p.codigocarrera and c.codigocarrera = '$codigocarrera' and p.codigoestadoplanestudio like '101%'";
					$planesdeestudio = mysql_query($query_planesdeestudio, $sala) or die(mysql_error());//die("$query_planesdeestudio");
					$totalRows_planesdeestudio = mysql_num_rows($planesdeestudio);
					if($totalRows_planesdeestudio != "")
					{
					?>
				</span>
				<p align="center" class="Estilo2">PLANES DE ESTUDIO EN CONSTRUCCION</p>
				<table width="500" border="1" cellpadding="2" cellspacing="1" bordercolor="#003333">
					<tr> 
						<td width="250" rowspan="2">
							<select name='identplanestudio' size="7" style="width: 250px">
								<?php
								while($row_planesdeestudio = mysql_fetch_assoc($planesdeestudio)) 
								{
									$nombreCarrera = $row_planesdeestudio['nombrecarrera'];
									$nombreplanestudio = $row_planesdeestudio['nombreplanestudio'];
									$idplanestudio = $row_planesdeestudio['idplanestudio'];	
									?>
									<option value="<?php echo $idplanestudio; ?>"><?php echo "$nombreplanestudio"; ?></option>
									<?php
								}//while
								?>
							</select>
						</td>
						<td align="center"><input type="submit" name="seleccionar" value="Seleccionar" style="WIDTH:80px"></td>
					</tr>	
				</table>
				<?php
			}//if
			else
			{
			/*
			?>
				<span class="Estilo1">
				<option value="0"><strong>No tiene planes de estudio</strong></option>
				</span><?php
				*/
				$query_carrera = "SELECT nombrecarrera FROM carrera where codigocarrera = '$codigocarrera'";
				$carrera = mysql_query($query_carrera, $sala) or die("$query_carrera");
				$row_carrera = mysql_fetch_assoc($carrera);
				$totalRows_carrera = mysql_num_rows($carrera);
				$nombreCarrera = $row_carrera['nombrecarrera'];
			}
			$query_planesdeestudioactivos = "select c.nombrecarrera, p.nombreplanestudio, p.idplanestudio from planestudio p, carrera c where c.codigocarrera = p.codigocarrera and c.codigocarrera = '$codigocarrera' and p.codigoestadoplanestudio like '100%'";
			$planesdeestudioactivos = mysql_query($query_planesdeestudioactivos, $sala) or die("$query_planesdeestudioactivos");
			$totalRows_planesdeestudioactivos = mysql_num_rows($planesdeestudioactivos);
			if($totalRows_planesdeestudioactivos != "")
			{
			?>
			<p align="center" class="Estilo2">PLANES DE ESTUDIO ACTIVOS</p>
			<table width="500" border="1" cellpadding="2" cellspacing="1" bordercolor="#003333">
				<tr> 
					<td width="250" rowspan="4">
						<select name='identplanestudio2' size="7" style="width: 250px">	
							<?php
							while($row_planesdeestudioactivos = mysql_fetch_assoc($planesdeestudioactivos)) 
							{
								$nombreCarrera = $row_planesdeestudioactivos['nombrecarrera'];
								$nombreplanestudio = $row_planesdeestudioactivos['nombreplanestudio'];
								$idplanestudio = $row_planesdeestudioactivos['idplanestudio'];
								?>
								<option value="<?php echo $idplanestudio; ?>"><?php echo "$nombreplanestudio"; ?></option>
								<?php
							}
							?>
						</select>	
					</td>
					<td align="center"><input type="submit" name="seleccionar" value="Seleccionar" style="WIDTH:80px"></td>
				</tr>
			</table>
			<span class="Estilo1">
			<?php
			}//if
			else
			{
			/*
			?>
				<option value="0"><strong>No tiene planes de estudio</strong></option>
				<?php
				*/
				$query_carrera = "SELECT nombrecarrera FROM carrera where codigocarrera = '$codigocarrera'";
				$carrera = mysql_query($query_carrera, $sala) or die("$query_carrera");
				$row_carrera = mysql_fetch_assoc($carrera);
				$totalRows_carrera = mysql_num_rows($carrera);
				$nombreCarrera = $row_carrera['nombrecarrera'];
			}
			?>
			</span>
			</form>
		</div>
		<!-- <p align="center" class="Estilo1">&nbsp;
		  SCRIPTS PARA PRUEBAS<br><br>
		 <a href="zconstruccionplan.php?planestudio=<?php echo $row_seltotalcreditossemestre['idplanestudio']."&estudiante=".$row_iniciales['codigoestudiante'];?>">Ponerlo en construccion</a><br>
		 <a href="zactivarplan.php?planestudio=<?php echo $row_seltotalcreditossemestre['idplanestudio']."&estudiante=".$row_iniciales['codigoestudiante'];?>">Activarlo</a><br>
		 </p> -->
	</body>
	<?php
	if(isset($_POST['seleccionar']))
	{
		if(isset($_POST['identplanestudio']))
		{
			echo '<script language="javascript">
			window.location.href="horario.php?planestudio='.$_POST['identplanestudio'].'&filtro=todos";
			</script>';
		}
		else if(isset($_POST['identplanestudio2']))
		{
			if(isset($_POST['seleccionar']))
			{
				echo '<script language="javascript">
				window.location.href="horario.php?planestudio='.$_POST['identplanestudio2'].'&filtro=todos";
				</script>';
			}
		}
		else
		{
			echo '<script language="javascript">
			alert("Debe seleccionar un plan de estudios del panel de la izquierda");
			</script>';
		}
	}
	?>
</html>
