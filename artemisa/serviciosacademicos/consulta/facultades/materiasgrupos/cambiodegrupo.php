<?php 
/*
 * @modified Ivan quintero <quinteroivan@unbosque.edu.co>
 * formateo del texto, adicion de realpath
 *
 * @since  November 22, 2016
*/

/* END */
    session_start();
    include_once(realpath(dirname(__FILE__)).'/../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
	require_once('../../../Connections/sala2.php'); 
	require_once('../../../funciones/funcionvalidarcrucehorarios.php'); 
	require_once('../../../funciones/validacion.php' ); 
	require_once('../../../funciones/errores_creacionestudiante.php'); 
	require_once('../../../funciones/actualizarmatriculados.php' ); 
	require_once('../../../funciones/actualizar_grupos.php');
	//require_once('../../../funciones/cruce_horarios/clasearboldesicionhorario.php');

	//session_start();
	mysql_select_db($database_sala, $sala);
	$volver = false;
	//require_once('seguridadcambiodegrupo.php'); 
	//echo "<br>".$_GET['grupo']."<br><br>";
	$codigoperiodo = $_SESSION['codigoperiodosesion'];
	$codigocarrera = $_SESSION['codigofacultad'];

	// agrege esta linea para que no me pida seleccionar materia. 15.01.2007

	$_GET['seleccionarmateria'] = $_GET['materia'];

	// cambio '%".$_GET['materia']."%' por '".$_GET['materia']."' 15.01.2007
	$query_materiaini = "select codigomateria, nombremateria, numerocreditos from materia where codigocarrera = '$codigocarrera' and codigoestadomateria = '01' and codigomateria like '".$_GET['materia']."' order by 2";
	$materiaini = mysql_query($query_materiaini, $sala) or die("$query_materiaini<br>".mysql_error());
	$row_materiaini = mysql_fetch_assoc($materiaini);
	$totalRows_materiaini = mysql_num_rows($materiaini);
	$nombremateriaini = $row_materiaini['nombremateria'];
	$codigomateriaini = $row_materiaini['codigomateria'];
	$numerocreditosini = $row_materiaini['numerocreditos'];

	$query_grupoini = "select idgrupo, nombregrupo, matriculadosgrupo, maximogrupo, matriculadosgrupoelectiva, maximogrupoelectiva from grupo where idgrupo = '".$_GET['grupo']."' and codigoperiodo = '$codigoperiodo' and codigoestadogrupo = '10' order by 1";
	//echo "$query_grupoini";
	$grupoini = mysql_query($query_grupoini, $sala) or die("$query_grupoini<br>".mysql_error());
	$row_grupoini = mysql_fetch_assoc($grupoini);
	$totalRows_grupoini = mysql_num_rows($grupoini);
	$nombregrupoini = $row_grupoini['nombregrupo'];
	$idgrupoini = $row_grupoini['idgrupo'];

	if(isset($_GET['seleccionarmateria']) || isset($_GET['seleccionargrupo'])) {
		// cambio $_GET['gmateria'] por $_GET['materia'] 15.01.2007

		$query_selmateriafin = "select codigomateria, nombremateria from materia where codigocarrera = '$codigocarrera' and codigoestadomateria = '01' and codigomateria like '".$_GET['materia']."' and numerocreditos <= '$numerocreditosini' order by 2";
		//echo "$query_selmateriafin<br>";
		$selmateriafin = mysql_query($query_selmateriafin, $sala) or die("$query_selmateriafin<br>".mysql_error());
		//$row_selmateria = mysql_fetch_assoc($selmateria);
		$totalRows_selmateriafin = mysql_num_rows($selmateriafin);
	}
	else {
		// cambio $_GET['gmateria'] por $_GET['materia'] 15.01.2007
		$query_selmateriafin = "select codigomateria, nombremateria from materia where codigocarrera = '$codigocarrera' and codigoestadomateria = '01' and codigomateria like '%".$_GET['materia']."%' 	and numerocreditos <= '$numerocreditosini' order by 2";
		//echo "$query_selmateriafin<br>";
		$selmateriafin = mysql_query($query_selmateriafin, $sala) or die("$query_selmateriafin<br>".mysql_error());
		//$row_selmateria = mysql_fetch_assoc($selmateria);
		$totalRows_selmateriafin = mysql_num_rows($selmateriafin);

	}

	if($_GET['aceptar']) {
		begin;
		// Grupo origen
		//$idgrupoini;
		$idgrupofin = $_GET['grupodestino'];
		$codigomateriafin = $_GET['materiafin'];
		$mensaje = false;
		$cupolleno = false;
		$tienecorte = false; 
		$query_selcortenotaini = "select * from detallenota dn where dn.idgrupo = '$idgrupoini' and dn.codigomateria = '$codigomateriaini'"; 
		//echo "$query_selgrupoconcupo<br>";
		$selcortenotaini = mysql_query($query_selcortenotaini, $sala) or die("$query_selcortenotaini<br>".mysql_error());
		//$row_selgrupo = mysql_fetch_assoc($selgrupo);
		$totalRows_selcortenotaini = mysql_num_rows($selcortenotaini);
		if($totalRows_selcortenotaini != "") {
			$tienecorte = true;
		}
		$query_selcortenotafin = "select * from detallenota dn where dn.idgrupo = '$idgrupoini' and dn.codigomateria = '$codigomateriaini'";
		//echo "$query_selcortenotafin<br>";
		$selcortenotafin = mysql_query($query_selcortenotafin, $sala) or die("$query_selcortenotafin<br>".mysql_error());
		//$row_selgrupo = mysql_fetch_assoc($selgrupo);
		$totalRows_selcortenotafin = mysql_num_rows($selcortenotafin);
		if($totalRows_selcortenotafin != "") {
			$tienecorte = true;
		}
		//echo $codigomateriaini,"--",$codigomateriafin
		$horariocruce = "Al estudiante o algunos estudiantes no se les cambio el grupo debido a que hay cruce de horarios";
		if(!$tienecorte || $codigomateriaini == $codigomateriafin) 
		{
			foreach($_GET as $llave => $valor) 
			{
				$asignacion = "\$" . $llave . "='" . $valor . "';";
				//echo "$asignacion<br>";
				// Para cada estudiante se le hace el proceso.
				if(ereg("estudiante",$llave)) 
				{
					$codigoestudiante = $valor;
                	// Cuenta el maximocupo para el grupo, si lo sobrepasa no inserta
                	$query_selgrupoconcupo = "select idgrupo, codigomateria, nombregrupo, matriculadosgrupo, maximogrupo, matriculadosgrupoelectiva, maximogrupoelectiva from grupo where codigomateria = '$codigomateriafin' and codigoperiodo = '$codigoperiodo' and codigoestadogrupo = '10' and maximogrupo >= (matriculadosgrupoelectiva + matriculadosgrupo) and idgrupo = ".$_GET['grupodestino']." order by 1";
                	//echo "$query_selgrupoconcupo<br>";
                	$selgrupoconcupo = mysql_query($query_selgrupoconcupo, $sala) or die("$query_selgrupoconcupo<br>".mysql_error());
                	//$row_selgrupo = mysql_fetch_assoc($selgrupo);
                	$totalRows_selgrupoconcupo = mysql_num_rows($selgrupoconcupo);
                	if($totalRows_selgrupoconcupo != "") 
					{
                    	$row_selgrupoconcupo = mysql_fetch_array($selgrupoconcupo);
						//echo "".$row_selgrupoconcupo['maximogrupo']." > ".$row_selgrupoconcupo['matriculadosgrupoelectiva']." + ".$row_selgrupoconcupo['matriculadosgrupo']."";
						if($row_selgrupoconcupo['maximogrupo'] > $row_selgrupoconcupo['matriculadosgrupoelectiva'] + $row_selgrupoconcupo['matriculadosgrupo']) 
						{
							//$estudiantescambiados[] = $codigoestudiante;
							//echo "Materia: $codigomateriaini == $codigomateriafin<br> Grupo: $idgrupoini = $idgrupofin";
							//exit();
							//if($codigomateriaini == $codigomateriafin)
							//{
							require('cambiargrupoestudiante.php');
							//}
						}
                    	else 
						{
                        	$cupolleno = true;
                        	/*
							?>
							<script language="javascript">
							alert("No hay cupo disponible para la materia destino");
							</script>
							<?php
							*/
						}
					}
					else 
					{
						$cupolleno = true;
						/*
						?>
						<script language="javascript">
						alert("No hay cupo disponible para la materia destino");
						</script>	
						<?php
						*/				//exit();
					}
					//echo ereg_replace("estudiante","",$llave)." == $valor <br>";
				}
			}
		}
		else 
		{
        ?>
			<script language="javascript">
				alert("No se permite la modificación ya que la materia destino tiene cortes de notas digitadas");	
			</script>
		<?php
		}
		if($cupolleno) 
		{
			?>	
			<script language="javascript">
				alert("No hay cupo disponible para trasladar a todos los estudiantes al grupo destino");
			</script>
		<?php
		}

		if($mensaje) 
		{
        ?>
		<script language="javascript">
			alert('<?php echo $horariocruce; ?>');
		</script>
        <?php
		}
		/*echo '<script language="javascript">
		window.location.reload("cambiodegrupo.php?gmateria='.$codigomateriafin.'&seleccionargrupo&grupo='.$_GET['grupo'].'&materia='.$_GET['materia'].'&grupodestino='.$_GET['grupodestino'].'");
		</script>';*/
	}//if get aceptar
	//echo $dirini;
	if(isset($_GET['seleccionarmateria'])) 
	{
    	// cambio $_GET['gmateria'] por $_GET['materia'] 15.01.2007
    	$query_selgrupo = "select idgrupo, codigomateria, nombregrupo, matriculadosgrupo, maximogrupo, matriculadosgrupoelectiva, maximogrupoelectiva from grupo where codigomateria = '".$_GET['materia']."' and codigoperiodo = '$codigoperiodo' and codigoestadogrupo = '10' and idgrupo <> '$idgrupoini' and maximogrupo > (matriculadosgrupoelectiva + matriculadosgrupo) order by 1";
    	$selgrupo = mysql_query($query_selgrupo, $sala) or die("$query_selgrupo<br>".mysql_error());
    	//echo $query_selgrupo;
    	//$row_selgrupo = mysql_fetch_assoc($selgrupo);
    	$totalRows_selgrupo = mysql_num_rows($selgrupo);
    	/*if(isset($_GET['primera'])) // comente para bloqueo de pasar a otras materias 15.01.2007
		{
		if($_GET['gmateria'] != $_GET['materia'])
		{
		?>
		<script language="javascript">
			if(!confirm("Si continúa podrá pasar estudiantes de esta materia a una diferente, \nlo cual ocasionaria que la nueva materia tome las notas de la anterior materia. \n¿Quiere continuar?"))
			{
				history.go(-1);
			}
			else if(!confirm("¿Realmente quiere continuar?"))
			{
				history.go(-1);
			}
		</script>
		<?php
		}
		}*/ // fin comente para bloqueo de pasar a otras materias 15.01.2007
	}//if
	$formulariovalido = 1;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>Cambio de grupo</title>
        <style type="text/css">
            <!--
            .Estilo1 {font-family: Tahoma; font-size: 12px}
            .Estilo2 {font-family: Tahoma; font-size: 12px; font-weight: bold; }
            .Estilo3 {font-family: Tahoma; font-size: 14px; font-weight: bold; }
            -->
        </style>
    </head>
    <body>
        <div align="center">
            <form name="formulario" method="get" action="cambiodegrupo.php">
                <input type="hidden" name="grupo" value="<?php echo $_GET['grupo']; ?>">
                <input type="hidden" name="primera">
                <input type="hidden" name="materia" value="<?php echo $_GET['materia']; ?>">
				<?php
				$query_datosmateriaini = "SELECT m.nombremateria, m.codigomateria, c.nombrecarrera, concat(d.nombredocente,' ',d.apellidodocente) as nombre, c.codigocarrera FROM materia m, carrera c, docente d, grupo g where m.codigocarrera = c.codigocarrera and g.numerodocumento = d.numerodocumento and g.codigomateria = m.codigomateria and g.idgrupo = '$idgrupoini' and m.codigomateria = '".$_GET['materia']."'";
				//and m.codigocarrera = '$carrera'
				//echo $query_datosmateriaini;
				$datosmateriaini = mysql_query($query_datosmateriaini, $sala) or die(mysql_error());
				$row_datosmateriaini = mysql_fetch_assoc($datosmateriaini);
				$nombrecarrera = $row_datosmateriaini["nombrecarrera"];
				$codigocarrera = $row_datosmateriaini["codigocarrera"];
				$nombremateriaini = $row_datosmateriaini["nombremateria"];
                $codigomateriaini = $row_datosmateriaini["codigomateria"];
                ?>
                <table width="600" border="1" cellpadding="2" cellspacing="1" bordercolor="#003333" align="center">
                    <tr class="Estilo2">
                        <td colspan="2" align="center">DATOS DE LA MATERIA Y GRUPO ORIGEN</td>
                    </tr>
                    <tr bgcolor="#C5D5D6" class="Estilo2">
                        <td width="50%" align="center">Nombre Materia</td>
                        <td width="50%" align="center">C&oacute;digo Materia</td>
                    </tr>
                    <tr class="Estilo1">
                        <td align='center'><?php echo $nombremateriaini ?>&nbsp;</td>
                        <td align='center'><?php echo $codigomateriaini ?>&nbsp;</td>
                    </tr>
					<?php
					$query_grupoini = "SELECT distinct g.idgrupo, g.codigogrupo, g.nombregrupo, g.maximogrupo, g.matriculadosgrupo, m.nombremateria, m.codigomateria FROM grupo g, materia m where g.codigomateria = m.codigomateria and g.idgrupo = '$idgrupoini'";
					$grupoini = mysql_query($query_grupoini, $sala) or die(mysql_error());
					$row_grupoini = mysql_fetch_assoc($grupoini);
					$codigogrupoini = $row_grupoini['codigogrupo'];
					$nombregrupoini = $row_grupoini['nombregrupo'];
					$maximogrupoini = $row_grupoini['maximogrupo'];
					$idgruporef = $idgrupoini;
					require("calculoestudiantesinscritos.php");
					$valor_prematriculados = $total_prematriculados + $total_prematriculados2;
					$matriculadosgrupoini =  $valor_prematriculados + $total_matriculados;
					$matriculadosini = $total_matriculados;
                    $prematriculadosini = $total_prematriculados + $total_prematriculados2;
                    ?>
                    <tr>
                        <td colspan="2">
                            <table width="100%" border="1" cellpadding="2" cellspacing="1" bordercolor="#003333" align="center">
                                <tr bgcolor="#C5D5D6" class="Estilo2">
                                    <td align="center">C&oacute;digo Grupo</td>
                                    <td align="center">Nombre Grupo</td>
                                    <td align="center">Cupo</td>
                                    <td align="center">Prematriculados</td>
                                    <td align="center">Matriculados</td>
                                    <td align="center">Total Grupo</td>
                                </tr>
                                <tr class="Estilo1">
                                    <td align='center'><?php echo $idgrupoini ?>&nbsp;</td>
                                    <td align='center'><?php echo $nombregrupoini ?>&nbsp;</td>
                                    <td align='center'><?php echo $maximogrupoini ?>&nbsp;</td>
                                    <td align='center'><?php echo $prematriculadosini ?>&nbsp;</td>
                                    <td align='center'><?php echo $matriculadosini ?>&nbsp;</td>
                                    <td align='center'><?php echo $matriculadosgrupoini ?>&nbsp;</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
					<?php
					$query_horario = "select s.nombresede, sa.nombresalon, d.nombredia, h.horainicial, h.horafinal from horario h, sede s, salon sa, dia d where h.codigosalon = sa.codigosalon and sa.codigosede = s.codigosede and h.codigodia = d.codigodia and h.idgrupo = '$idgrupoini'";
				    $res_horario = mysql_query($query_horario, $sala) or die(mysql_error());
					?>
                    <tr>
                        <td colspan="2">
                            <table width="100%" border="1" cellpadding="2" cellspacing="1" bordercolor="#003333" align="center">
                                <tr bgcolor="#C5D5D6" class="Estilo2">
                                    <td align="center">Sede</td>
                                    <td align="center">Salón</td>
                                    <td align="center">Día</td>
                                    <td align="center">Hora Inicial</td>
                                    <td align="center">Hora Final</td>
                                </tr>
								<?php
								while($horario = mysql_fetch_assoc($res_horario)) 
								{
									$nombresede = $horario["nombresede"];
									$nombresalon = $horario["nombresalon"];
									$nombredia = $horario["nombredia"];
									$horainicial = $horario["horainicial"];
									$horafinal = $horario["horafinal"];
									?>
                                <tr class="Estilo1">
                                    <td align='center'><?php echo $nombresede ?>&nbsp;</td>
                                    <td align='center'><?php echo $nombresalon ?>&nbsp;</td>
                                    <td align='center'><?php echo $nombredia ?>&nbsp;</td>
                                    <td align='center'><?php echo $horainicial ?>&nbsp;</td>
                                    <td align='center'><?php echo $horafinal ?>&nbsp;</td>
                                </tr>
								<?php
                                }
                                ?>
                            </table>
                        </td>
                    </tr>
                </table>
                <table width="600" border="1" bordercolor="#003333">
					<?php
                    if(!isset($_GET['seleccionarmateria']) && !isset($_GET['seleccionargrupo'])) 
					{
					?>
                    <tr>
                        <td width="504" align="center" bgcolor="#C5D5D6" class="Estilo2">Seleccione la materia destino:</td>
                        <td class="Estilo3"><font size="-1">
							<select name="gmateria">
								<?php
								while($row_selmateriafin = mysql_fetch_assoc($selmateriafin)) {
                                ?>
								<option value="<?php echo $row_selmateriafin['codigomateria'];?>"<?php if(!(strcmp($row_selmateriafin['codigomateria'], $_GET['gmateria']))) {echo "SELECTED";} ?>><?php echo $row_selmateriafin['codigomateria']." ".$row_selmateriafin['nombremateria']?></option>
								<?php
								}
								?>
							</select>
							</font>
						</td>
                    </tr>
                    <tr>
                        <td colspan="2" align="center">
                            <input type="submit" name="seleccionarmateria" value="Seleccionar Materia">
                        </td>
                    </tr>
					<?php
                    }
                    if(isset($_GET['seleccionarmateria']) || isset($_GET['seleccionargrupo'])) 
					{
						$row_selmateriafin = mysql_fetch_assoc($selmateriafin);
						$nombremateriafin = $row_selmateriafin['nombremateria'];
						$codigomateriafin = $row_selmateriafin['codigomateria'];
						?>
						<tr class="Estilo2">
							<td colspan="2" align="center">DATOS DE LA MATERIA Y GRUPO DESTINO
								<input type="hidden" name="materiafin" value="<?php echo $row_selmateriafin['codigomateria']; ?>">
								<input type="hidden" name="gmateria" value="<?php echo $row_selmateriafin['codigomateria']; ?>">
								<!-- <input type="hidden" name="seleccionarmateria" value="Seleccionado"> -->
							</td>
						</tr>
						<tr bgcolor="#C5D5D6" class="Estilo2">
							<td width="50%" align="center">Nombre Materia</td>
							<td width="50%" align="center">C&oacute;digo Materia</td>
						</tr>
						<tr class="Estilo1">
							<td align='center'><?php echo $nombremateriafin ?>&nbsp;</td>
							<td align='center'><?php echo $codigomateriafin ?>&nbsp;</td>
						</tr>
						<?php
					}
					if(isset($_GET['seleccionarmateria'])) 
					{
					?>
                    <tr>
                        <td bgcolor="#C5D5D6" class="Estilo2" align="center">Seleccione grupo academico destino:</td>
                        <td>	<font size="1">
						<?php
						if($totalRows_selgrupo != "") 
						{
							?>
                            <select name="grupodestino">
								<?php
								while($row_selgrupo = mysql_fetch_assoc($selgrupo)) 
								{
								?>
                                	<option value="<?php echo $row_selgrupo['idgrupo'];?>"<?php if(!(strcmp($row_selgrupo['idgrupo'], $_GET['grupodestino']))) {echo "SELECTED";} ?>><?php echo $row_selgrupo['idgrupo']." ".$row_selgrupo['nombregrupo']?></option>
								<?php
								}	
								$totalRows_selgrupo = mysql_num_rows($selgrupo);
								if($totalRows_selgrupo > 0) 
								{
									mysql_data_seek($selgrupo, 0);
									$row_selgrupo = mysql_fetch_assoc($selgrupo);
								}
								?>
							</select>
                            </font><font size="2">
							<?php
						}
						else 
						{
							echo "No hay mas grupos con cupo";
                            $volver = true;
						}
                        ?>
                        </font>	
						</td>
					</tr>
                    <?php
						if(!$volver) 
						{
							?>
							<tr>
							<td colspan="2" align="center">
								<input type="submit" name="seleccionargrupo" value="Seleccionar Grupo">
							</td>
							</tr>
							<?php
						}
					}
					if(isset($_GET['seleccionargrupo'])) 
					{
						$idgrupofin = $_GET['grupodestino'];
						$query_grupofin = "SELECT distinct g.idgrupo, g.codigogrupo, g.nombregrupo, g.maximogrupo, g.matriculadosgrupo, m.nombremateria, m.codigomateria FROM grupo g, materia m where g.codigomateria = m.codigomateria and g.idgrupo = '".$_GET['grupodestino']."'";
						$grupofin = mysql_query($query_grupofin, $sala) or die(mysql_error());
						$row_grupofin = mysql_fetch_assoc($grupofin);
						$codigogrupofin = $row_grupofin['codigogrupo'];
						$nombregrupofin = $row_grupofin['nombregrupo'];
						$maximogrupofin = $row_grupofin['maximogrupo'];
						$idgruporef = $idgrupofin;
						require("calculoestudiantesinscritos.php");
						$valor_prematriculados = $total_prematriculados + $total_prematriculados2;
						$matriculadosgrupofin =  $valor_prematriculados + $total_matriculados;
						$matriculadosfin = $total_matriculados;
						$prematriculadosfin = $total_prematriculados + $total_prematriculados2;
						?>
						<tr>
							<td colspan="2">
								<input type="hidden" name="seleccionargrupo">
								<input type="hidden" name="grupodestino" value="<?php echo $idgrupofin ?>">
								<table width="100%" border="1" cellpadding="2" cellspacing="1" bordercolor="#003333" align="center">
									<tr bgcolor="#C5D5D6" class="Estilo2">
										<td align="center">C&oacute;digo Grupo</td>
										<td align="center">Nombre Grupo</td>
										<td align="center">Cupo</td>
										<td align="center">Prematriculados</td>
										<td align="center">Matriculados</td>
										<td align="center">Total Grupo</td>
									</tr>
									<tr class="Estilo1">
										<td align='center'><?php echo $idgrupofin ?>&nbsp;</td>
										<td align='center'><?php echo $nombregrupofin ?>&nbsp;</td>
										<td align='center'><?php echo $maximogrupofin ?>&nbsp;</td>
										<td align='center'><?php echo $prematriculadosfin ?>&nbsp;</td>
										<td align='center'><?php echo $matriculadosfin ?>&nbsp;</td>
										<td align='center'><?php echo $matriculadosgrupofin ?>&nbsp;</td>
									</tr>
								</table>
							</td>
						</tr>
						<?php
						$query_horario = "select s.nombresede, sa.nombresalon, d.nombredia, h.horainicial, h.horafinal from horario h, sede s, salon sa, dia d where h.codigosalon = sa.codigosalon and sa.codigosede = s.codigosede and h.codigodia = d.codigodia and h.idgrupo = '$idgrupofin'";
						$res_horario = mysql_query($query_horario, $sala) or die(mysql_error());
						?>
						<tr>
							<td colspan="2">
								<table width="100%" border="1" cellpadding="2" cellspacing="1" bordercolor="#003333" align="center">
									<tr bgcolor="#C5D5D6" class="Estilo2">
										<td align="center">Sede</td>
										<td align="center">Salón</td>
										<td align="center">Día</td>
										<td align="center">Hora Inicial</td>
										<td align="center">Hora Final</td>
									</tr>
									<?php
									while($horario = mysql_fetch_assoc($res_horario)) 
									{
										$nombresede = $horario["nombresede"];
										$nombresalon = $horario["nombresalon"];
										$nombredia = $horario["nombredia"];
										$horainicial = $horario["horainicial"];
										$horafinal = $horario["horafinal"];
										?>
										<tr class="Estilo1">
											<td align='center'><?php echo $nombresede ?>&nbsp;</td>
											<td align='center'><?php echo $nombresalon ?>&nbsp;</td>
											<td align='center'><?php echo $nombredia ?>&nbsp;</td>
											<td align='center'><?php echo $horainicial ?>&nbsp;</td>
											<td align='center'><?php echo $horafinal ?>&nbsp;</td>
										</tr>
										<?php
									}
									?>
								</table>
							</td>
						</tr>
						<?php
						// cambio $_GET['gmateria'] por $_GET['materia'] 15.01.2007

						$query_selgrupo = "select idgrupo, codigomateria, nombregrupo, matriculadosgrupo, maximogrupo, matriculadosgrupoelectiva, maximogrupoelectiva from grupo where codigomateria = '".$_GET['materia']."' and codigoperiodo = '$codigoperiodo' and codigoestadogrupo = '10' and idgrupo <> '$idgrupoini' and maximogrupo > (matriculadosgrupoelectiva + matriculadosgrupo) order by 1";
						$selgrupo = mysql_query($query_selgrupo, $sala) or die("$query_selgrupo<br>".mysql_error());
						//$row_selgrupo = mysql_fetch_assoc($selgrupo);
						$totalRows_selgrupo = mysql_num_rows($selgrupo);
						if($totalRows_selgrupo != "") {
							$query_inscritos = "SELECT c.nombrecarrera, p.codigoestudiante, concat(eg.apellidosestudiantegeneral,' ',eg.nombresestudiantegeneral) as nombre,eg.numerodocumento FROM detalleprematricula d, prematricula p, estudiante e,carrera c,estudiantegeneral eg WHERE d.idprematricula = p.idprematricula and e.idestudiantegeneral = eg.idestudiantegeneral AND p.codigoestudiante = e.codigoestudiante AND c.codigocarrera = e.codigocarrera AND (p.codigoestadoprematricula like '1%' or p.codigoestadoprematricula like '4%') AND (d.codigoestadodetalleprematricula like '1%' OR d.codigoestadodetalleprematricula like '3%') AND d.idgrupo = '$idgrupoini' and p.codigoperiodo = '$codigoperiodo' order by 3,1 asc";
							//echo $query_inscritos;
							$inscritos = mysql_query($query_inscritos, $sala) or die(mysql_error());
							$total_inscritos = mysql_num_rows($inscritos);
							if($total_inscritos != "") 
							{
							?>
                    		<tr>
                    			<td colspan="2">
									<table border="1" cellpadding="2" cellspacing="1" bordercolor="#003333" align="center" width="100%">
										<tr>
											<td colspan="4" align="center" class="Estilo2">ESTUDIANTES INSCRITOS EN EL GRUPO ORIGEN</td>
											<td align="center"><strong><font size="-1">
														<input type="checkbox" onClick="HabilitarTodos(this)">
													</font></strong>
											</td>
										</tr>
										<tr bgcolor="#C5D5D6" class="Estilo2">
											<td align="center">Facultad</td>
											<td align="center">Documento Estudiante</td>
											<td align="center">Nombre Estudiante</td>
											<td align="center">Materias Cruzadas</td>
											<td align="center">Selección</td>
										</tr>
										<?php
										//require_once('../../../funciones/cruce_horarios/crucehorarios.php');
								while($row_inscritos = mysql_fetch_assoc($inscritos)) 
								{
                                    $nombreestudiante = $row_inscritos["nombre"];
                                    $codigoestudiante = $row_inscritos["codigoestudiante"];
                                    $nombrefacultad=$row_inscritos["nombrecarrera"];
                                    $documento=$row_inscritos["numerodocumento"];
                                    /* if($_GET['aceptar'])
									{
									$arraycruces=encuentracrucehorario($codigoestudiante,$codigoperiodo,$sala);
									} */
									?>
									<tr class="Estilo1">
										<td align='center'><?php echo $nombrefacultad ?>&nbsp;</td>
										<td align='center'><?php echo $documento ?>&nbsp;</td>
										<td align='center'><?php echo $nombreestudiante ?>&nbsp;</td>
										<td align='center'><?php
                						/*	    echo "<pre>";
	                 					print_r($estudiantehorariocruce);
	               						echo "pailas";
	              						echo "</pre>";				 */
                						if (is_array($estudiantehorariocruce)) 
										{
                                        	foreach ($estudiantehorariocruce as $value => $key) 
											{
                                            	if ($value == $codigoestudiante) 
												{
                                                	if(is_array($key))
                                                    	foreach ($key as $value2 => $key1) 
														{
                                                        // echo "Cod $value  Mat1 $value2  Mat2  $key1 <br>";
															$query_est_cruce = "select nombremateria from materia where ( codigomateria =  $value2 or codigomateria = $key1)";
															$res_est_cruce = mysql_query($query_est_cruce, $sala) or die(mysql_error());
                                                            $est_cruce = mysql_fetch_assoc($res_est_cruce);
                                                            do {
                                                            	echo "-",$est_cruce['nombremateria'],"<br>";
															}while($est_cruce = mysql_fetch_assoc($res_est_cruce));
														}
												}
											}
										}
										?>
                                        &nbsp;</td>
										<td align='center'><input type="checkbox" name="estudiante<?php echo $codigoestudiante ?>" title="estudiante" value="<?php echo $codigoestudiante ?>"></td>
									</tr>										
									<?php
								}//while
								?>
								</table></td>								
							</tr>		
							<?php
                            }
						}
					}
					?>
				</table>
                <br>
				<?php
				if(isset($estudiantescambiados)) 
				{
				?>
				<table border="1" cellpadding="2" cellspacing="1" bordercolor="#003333" align="center" width="600" >
					<tr>
                        <td colspan="3" align="center"><strong><font size="-1">ESTUDIANTES TRASLADADOS</font></strong></td>
                    </tr>
                    <tr bgcolor="#C5D5D6">
                        <td align="center" class="Estilo2"><strong>Facultad</strong></td>
                        <td align="center" class="Estilo2"><strong>Documento Estudiante</strong>&nbsp;</td>
                        <td align="center" class="Estilo2"><strong>Nombre Estudiante</strong>&nbsp;</td>
                    </tr>
                    <?php
                    foreach($estudiantescambiados as $llave => $codigocambiado) 
					{
                    	$query_estudianteseleccionado = "select c.nombrecarrera, e.codigoestudiante, concat(eg.apellidosestudiantegeneral,' ',eg.nombresestudiantegeneral) as nombre,eg.numerodocumento from estudiante e, carrera c,estudiantegeneral eg where e.codigocarrera = c.codigocarrera and e.idestudiantegeneral = eg.idestudiantegeneral and e.codigoestudiante = '$codigocambiado'";
                        //echo $query_inscritos;
                        $estudianteseleccionado = mysql_query($query_estudianteseleccionado, $sala) or die("$query_estudianteseleccionado".mysql_error());
                        $total_estudianteseleccionado = mysql_num_rows($estudianteseleccionado);
						$row_estudianteseleccionado = mysql_fetch_assoc($estudianteseleccionado);
                        $nombreestudiante = $row_estudianteseleccionado["nombre"];
                        $codigoestudiante = $row_estudianteseleccionado["numerodocumento"];
                        $nombrefacultad = $row_estudianteseleccionado["nombrecarrera"];
					?>
                    <tr>
                        <td align='center' class='Estilo2'><?php echo $nombrefacultad ?>&nbsp;</td>
                        <td align='center' class='Estilo2'><?php echo $codigoestudiante ?>&nbsp;</td>
                        <td align='center' class='Estilo2'><?php echo $nombreestudiante ?>&nbsp;</td>
                    </tr>
					<?php
                    }//foreach
					?>
				</table>
				<?php
				}
				if($totalRows_selgrupo != "") 
				{
				?>
				<br>
				<input type="submit" name="aceptar" value="Aceptar">
				<?php
				}
                if($volver) 
				{
                ?>
				<input type="button" name="volver" value="Atras" onClick="history.go(-1)">
                <?php
                }
				?>
				<input type="submit" name="salir" value="Salir">
			</form>
		</div>    
	</body>
</html>
<script language="javascript">
    function HabilitarTodos(chkbox, seleccion)
    {
        for (var i=0;i < document.forms[0].elements.length;i++)
        {
            var elemento = document.forms[0].elements[i];
            if(elemento.type == "checkbox")
            {
                if (elemento.title == "estudiante")
                {
                    elemento.checked = chkbox.checked
                }
            }
        }
    }
</script>
<?php

if(isset($_GET['salir'])) {
                    echo "<script language='javascript'>
	window.opener.recargar('".$dirini."#".$grupo."');
	window.opener.focus();
	window.close();
	</script>";
} 
?>