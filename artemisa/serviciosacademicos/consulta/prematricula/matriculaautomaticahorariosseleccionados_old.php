<?php 

	require_once('../../Connections/sala2.php' );
	mysql_select_db($database_sala, $sala);
	session_start();
	require_once('../../funciones/clases/autenticacion/redirect.php' ); 
	$link = "../../../imagenes/estudiantes/";
	require_once('../../funciones/datosestudiante.php');

	//require_once('seguridadprematricula.php');

	// Esta variable se usa en el resto de la aplicación en el archivo calculocreditossemestre
	$materiaselegidas = $materiasunserial;

	$materiasserial = serialize($materiasunserial);
	$codigoestudiante = $_SESSION['codigo'];

	if(isset($_POST['modificar']))
	{
		echo "<script language='javascript'>
			window.location.href='matriculaautomaticahorarios.php?programausadopor=".$_GET['programausadopor']."&materiassinhorarios=$materiasserial';
		</script>";
		//Se dirige a los horarios donde un estudiante elige
	}

	$semestre[$row_materiascarga['semestredetalleplanestudio']]++;
?>
<html>
	<head>
		<title>HORARIOS</title>
        <!--  Space loading indicator  -->
        <script src="<?php echo HTTP_SITE; ?>/assets/js/spiceLoading/pace.min.js"></script>

        <!--  loading cornerIndicator  -->
        <link href="<?php echo HTTP_SITE; ?>/assets/css/cornerIndicator/cornerIndicator.css" rel="stylesheet">
	</head>
	<link rel="stylesheet" href="../../estilos/sala.css" type="text/css">
	<link rel="stylesheet" href="../../../assets/css/bootstrap.min.css">
	<script src="../../js/jquery-3-1-1.min.js"></script>	
	<script type="application/javascript" src="../../js/jquery-1.9.1.js"></script>
	<script src="../../../assets/js/bootstrap.min.js"></script>
	<body>
		<?php
		if(!isset($_SESSION['codigo']))
		{
			?><script language="javascript">
				alert("Por seguridad su sesion ha sido cerrada, por favor reinicie.");
			</script>
			<?php
		}
		
		$codigoestudiante = $_SESSION['codigo'];
		$codigoperiodo = $_SESSION['codigoperiodosesion'];

		/* Obtener el documento del estudiante */
		$SQL_DOC = 'SELECT eg.numerodocumento FROM estudiantegeneral eg INNER JOIN estudiante e ON e.idestudiantegeneral = eg.idestudiantegeneral WHERE e.codigoestudiante = '.$codigoestudiante;
		$documentoestudiante = mysql_db_query($database_sala,$SQL_DOC) or die("$SQL_DOC");
		$row_documentoestudiante = mysql_fetch_array($documentoestudiante);
		$documentoestudiante = $row_documentoestudiante['numerodocumento'];

		/* Sumar 6 dias a la fecha actual para hacer el calculo de los salones */
		$fecha = date('Y-m-j');
		$nuevafecha = strtotime ( '+6 day' , strtotime ( $fecha ) ) ;
		$nuevafecha = date ( 'Y-m-j' , $nuevafecha );

		/***Consulta para el grupo y el salon***/

		$SQL_ASIG = 'SELECT
				p.idprematricula,
				d.idgrupo,
				x.codigodia,
				x.nombredia,
				m.nombremateria,
				g.nombregrupo,
				sg.SolicitudAsignacionEspacioId,

			IF (
				c.Nombre IS NULL,
				"Falta Por Asignar",
				c.Nombre
			) AS Nombre,
			 a.FechaAsignacion,

			IF (
				a.HoraInicio IS NULL,
				h.horainicial,
				a.HoraInicio
			) AS HoraInicio,

			IF (
				a.HoraFin IS NULL,
				h.horafinal,
				a.HoraFin
			) AS HoraFin,
			 cc.Nombre AS Bloke,
			 ccc.Nombre AS Campus,
			 g.numerodocumento AS numDocente,
			 m.nombremateria,
			 CONCAT(
				dc.nombredocente,
				" ",
				dc.apellidodocente
			) AS DocenteName,
			 p.idprematricula,
			 p.codigoestudiante,
			 CONCAT(
				eg.nombresestudiantegeneral,
				" ",
				eg.apellidosestudiantegeneral
			) AS NameEstudiante,
			 eg.numerodocumento
			FROM
				prematricula p
			INNER JOIN detalleprematricula d ON d.idprematricula = p.idprematricula
			INNER JOIN horario h ON h.idgrupo = d.idgrupo
			INNER JOIN dia x ON x.codigodia = h.codigodia
			INNER JOIN grupo g ON g.idgrupo = d.idgrupo
			INNER JOIN materia m ON m.codigomateria = g.codigomateria
			INNER JOIN estudiante e ON e.codigoestudiante = p.codigoestudiante
			INNER JOIN estudiantegeneral eg ON eg.idestudiantegeneral = e.idestudiantegeneral
			INNER JOIN docente dc ON dc.numerodocumento = g.numerodocumento
			LEFT JOIN SolicitudEspacioGrupos sg ON sg.idgrupo = d.idgrupo
			LEFT JOIN AsignacionEspacios a ON a.SolicitudAsignacionEspacioId = sg.SolicitudAsignacionEspacioId
			LEFT JOIN SolicitudAsignacionEspacios s ON s.SolicitudAsignacionEspacioId = sg.SolicitudAsignacionEspacioId
			LEFT JOIN ClasificacionEspacios c ON c.ClasificacionEspaciosId = a.ClasificacionEspaciosId
			LEFT JOIN ClasificacionEspacios cc ON cc.ClasificacionEspaciosId = c.ClasificacionEspacionPadreId
			LEFT JOIN ClasificacionEspacios ccc ON ccc.ClasificacionEspaciosId = cc.ClasificacionEspacionPadreId
			WHERE
				eg.numerodocumento = "'.$documentoestudiante.'"
			AND (
				a.EstadoAsignacionEspacio = 1
				OR a.EstadoAsignacionEspacio IS NULL
			)
			AND d.codigoestadodetalleprematricula = 30
			AND p.codigoestadoprematricula IN (40, 41)
			AND p.codigoperiodo = "'.$codigoperiodo.'"
			AND (
				sg.codigoestado = 100
				OR sg.codigoestado IS NULL
			)
			AND (
				a.codigoestado = 100
				OR a.codigoestado IS NULL
			)
			AND (
				a.FechaAsignacion BETWEEN CURDATE()
				AND "'.$nuevafecha.'"
				OR a.FechaAsignacion IS NULL
			)
			AND (
				s.codigodia = h.codigodia
				OR s.codigodia IS NULL
			)
			AND s.codigoestado = 100
			GROUP BY
				x.codigodia,
				m.codigomateria,
				d.idgrupo,
				HoraInicio,
				HoraFin,
				a.FechaAsignacion
			ORDER BY
				x.codigodia,
				a.FechaAsignacion,
				a.HoraInicio,
				a.HoraFin';
				
		$asignaturas = mysql_db_query($database_sala,$SQL_ASIG) or die("$SQL_ASIG");
		$arreglo_asignaturas = array();
		while($row_asignaturas = mysql_fetch_array($asignaturas))
		{	
			$arreglo_asignaturas[$row_asignaturas['idgrupo']][$row_asignaturas['nombredia']]['sede'] = $row_asignaturas['Campus'];	
			$arreglo_asignaturas[$row_asignaturas['idgrupo']][$row_asignaturas['nombredia']]['salon'] = $row_asignaturas['Nombre'];
		}

		// Seleccion de los horarios que ya tiene matriculados un estudiante
		$query_materiasestudiante = "SELECT d.codigomateria, d.codigomateriaelectiva, edp.nombreestadodetalleprematricula, d.idgrupo, d.numeroordenpago
		FROM detalleprematricula d, prematricula p, materia m, estudiante e, estadodetalleprematricula edp
		where d.codigomateria = m.codigomateria 
		and d.idprematricula = p.idprematricula
		and p.codigoestudiante = e.codigoestudiante
		and e.codigoestudiante = '$codigoestudiante'
		and edp.codigoestadodetalleprematricula = d.codigoestadodetalleprematricula
		and (p.codigoestadoprematricula like '4%' or p.codigoestadoprematricula like '1%')
		and (d.codigoestadodetalleprematricula like '3%' or d.codigoestadodetalleprematricula like '1%' or d.codigoestadodetalleprematricula = '23')
		and p.codigoperiodo = '$codigoperiodo'";
		$materiasestudiante = mysql_query($query_materiasestudiante, $sala) or die("$query_materiasestudiante");
		$totalRows_materiasestudiante = mysql_num_rows($materiasestudiante);
		$tieneprema = false;
		if($totalRows_materiasestudiante == "")
		{
			if($_GET['programausadopor'] != "creditoycartera" && $_SESSION['MM_Username'] != "estudianterestringido")
			{
				?>
				<SCRIPT LANGUAGE="JavaScript">
				alert("Actualmente no tiene materias seleccionadas, a continuación debe hacerlo")
				</SCRIPT>
				<?php
				echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=matriculaautomatica.php?programausadopor=".$_GET['programausadopor']."'>";
				exit();
			}
			else
			{
				?>
				<SCRIPT LANGUAGE="JavaScript">
				alert("Actualmente no tiene materias seleccionadas");
				</SCRIPT>
				<?php
				echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=matriculaautomaticaordenmatricula.php?programausadopor=".$_GET['programausadopor']."'>";
			}
		}
		?>
		<form name="form1" method="post" action="matriculaautomaticahorariosseleccionados.php">   
			<?php 
			datosestudiante($codigoestudiante,$sala,$database_sala,$link);
			?>
			<p>HORARIOS</p>
			<?php
			// Selecciona los datos de la materia y los horarios para las materias que tiene el estudiante
			while($row_materiasestudiante = mysql_fetch_array($materiasestudiante))
			{
				$eselectivalibre = false;
				$eselectivatecnica = false;

				$codigomateria = $row_materiasestudiante['codigomateria'];
				$codigomateriaelectiva = $row_materiasestudiante['codigomateriaelectiva'];
				$idgrupo = $row_materiasestudiante['idgrupo'];
				$estado = $row_materiasestudiante['nombreestadodetalleprematricula'];
				// Selecciona los datos de las materias para aquellas que no son electivas, de acuerdo al plan de estudio
				$query_datosmateria = "select m.nombremateria, m.codigomateria, dpe.semestredetalleplanestudio, dpe.numerocreditosdetalleplanestudio as numerocreditos
				from materia m, detalleplanestudio dpe, planestudioestudiante pee
				where m.codigomateria = '$codigomateria'
				and pee.codigoestudiante = '$codigoestudiante'
				and m.codigomateria = dpe.codigomateria
				and pee.idplanestudio = dpe.idplanestudio
				and pee.codigoestadoplanestudioestudiante like '1%'";
				// Otro query para selecciona los datos de las materias cuando el anterior es vacio para las demás materias
				// Tanto enfasis como electivas libres	
				$datosmateria=mysql_query($query_datosmateria, $sala) or die("$query_datosmateria");
				$totalRows_datosmateria = mysql_num_rows($datosmateria);
				if($totalRows_datosmateria == "")
				{
					// Toma los datos de la materia si es enfasis
					$query_datosmateria = "select m.nombremateria, m.codigomateria, dle.semestredetallelineaenfasisplanestudio as semestredetalleplanestudio,
					dle.numerocreditosdetallelineaenfasisplanestudio as numerocreditos
					from materia m, detallelineaenfasisplanestudio dle, lineaenfasisestudiante lee
					where m.codigomateria = '$codigomateria'
					and lee.codigoestudiante = '$codigoestudiante'
					and m.codigomateria = dle.codigomateriadetallelineaenfasisplanestudio
					and lee.idplanestudio = dle.idplanestudio
					and lee.idlineaenfasisplanestudio = dle.idlineaenfasisplanestudio
					and dle.codigoestadodetallelineaenfasisplanestudio like '1%'
					and (NOW() between lee.fechainiciolineaenfasisestudiante and lee.fechavencimientolineaenfasisestudiante)";
					// Otro query para selecciona los datos de las materias cuando el anterior es vacio para las demás materias
					// Tanto enfasis como electivas libres		
					$datosmateria=mysql_query($query_datosmateria, $sala) or die("$query_datosmateria");
					$totalRows_datosmateria = mysql_num_rows($datosmateria);
					// Si se trata de una electiva
				}
				if($totalRows_datosmateria == "")
				{
					//echo "Mirar papa <br>";
					// Mira si tiene papa, si el papa es electiva libre toma los creditos directamente del hijo
					// Si no tiene papa toma los datos como si fuera una materia externa		
					$query_datosmateriapapa = "select m.nombremateria, m.codigomateria, dpe.semestredetalleplanestudio, dpe.numerocreditosdetalleplanestudio as numerocreditos,
					dpe.codigotipomateria, gm.codigotipogrupomateria
					from grupomaterialinea gml, materia m, grupomateria gm, detalleplanestudio dpe, planestudioestudiante pee
					where gm.codigoperiodo = '$codigoperiodo'
					and gml.codigomateria = '$codigomateriaelectiva'
					and gml.codigoperiodo = gm.codigoperiodo
					and gm.codigoperiodo = gml.codigoperiodo
					and pee.codigoestudiante = '$codigoestudiante'
					and pee.idplanestudio = dpe.idplanestudio
					and dpe.codigomateria = m.codigomateria
					and gml.codigomateria = m.codigomateria
					and gml.idgrupomateria = gm.idgrupomateria
					and pee.codigoestadoplanestudioestudiante like '1%'
					order by m.nombremateria";

					//echo "<br>$query_datosmateriapapa<br>";
					$datosmateriapapa = mysql_query($query_datosmateriapapa, $sala) or die("$query_datosmateriapapa");
					$totalRows_datosmateriapapa = mysql_num_rows($datosmateriapapa);
					if($totalRows_datosmateriapapa == "")
					{
						//echo "<br>$codigomateria2 EXTERNA<br>";
						// En el caso de haber hecho la prematricula y de tratarse de una materia externa en carga academica se
						// Actualmente todos los planes de estudio tiene el ismo numero de creditos para una materia
						// Toca empezar a guardar el plan de estudio de la materia externa en cargaacademica y de este tomar el semestre y
						// y los creditos de la materia y efectuar el conteo de creditos a partir de aca.
						// Debido a que esto no se hiso  para el semestre 20052 toca dejar el codigo siguiente.
						$query_datosmateria = "select m.nombremateria, m.codigomateria, m.numerocreditos
						from materia m
						where m.codigomateria = '$codigomateria'
						and m.codigoestadomateria = '01'";
						$datosmateria=mysql_query($query_datosmateria, $sala) or die("$query_datosmateria");
						$totalRows_datosmateria = mysql_num_rows($datosmateria);
					}
					else 
					{
						//echo "tienen papa<br>";
						// Si entra aca quiere decir que la materia tiene hijos.
						$row_datosmateriapapa = mysql_fetch_array($datosmateriapapa);

						if($row_datosmateriapapa['codigotipogrupomateria'] == "100")
						{
							// Materia electiva libre
							// Si entra es por que la materia hija es libre y debe tomar el numero de creditos de ella
							//echo "LIBRE $codigomateria<br>";
							$query_datosmateria = "select m.nombremateria, m.codigomateria, m.numerocreditos
							from materia m
							where m.codigomateria = '$codigomateria'
							and m.codigoestadomateria = '01'";
							//echo $query_datosmateria;
							$datosmateria=mysql_query($query_datosmateria, $sala) or die("$query_datosmateria");
							$totalRows_datosmateria = mysql_num_rows($datosmateria);
							$eselectivalibre = true;
						}
						else if($row_datosmateriapapa['codigotipogrupomateria'] == "200")
						{
							// Materia electiva tecnica
							// Si entra aca es por que la materia debe tomar el numero de creditos del papa							
							$query_datosmateria = "select m.nombremateria, m.codigomateria, m.numerocreditos from materia m where m.codigomateria = '$codigomateria'
							and m.codigoestadomateria = '01'";							
							$datosmateria = mysql_query($query_datosmateria, $sala) or die("$query_datosmateria");
							$totalRows_datosmateria = mysql_num_rows($datosmateria);
							$row_datosmateria['semestredetalleplanestudio'] =
							$creditospapa = $row_datosmateriapapa['numerocreditos'];
							$eselectivatecnica = true;
						}
					}
				}
				if($totalRows_datosmateria != "")
				{

					while($row_datosmateria = mysql_fetch_array($datosmateria))
					{
						if($eselectivatecnica)
						{
							//$creditoshijo = $row_datosmateria['numerocreditos'];
							$row_datosmateria['semestredetalleplanestudio'] = $row_datosmateriapapa['semestredetalleplanestudio'];
							$row_datosmateria['numerocreditos'] = $row_datosmateriapapa['numerocreditos'];
							//echo "aca $creditospapa<br>";
						}
						?>
						<table width="750" border="2" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9">
							<tr> 
								<td colspan="5" style="border-top-color:#000000"><label id="labelresaltado"><?php echo $row_datosmateria['nombremateria'];?></label>      </td>
								<td id="tdtitulogris" style="border-top-color:#000000"> 
								Orden de Pago</td>
								<td style="border-top-color:#000000">
								<?php echo $row_materiasestudiante['numeroordenpago'];?>
								</td>
								<td id="tdtitulogris" style="border-top-color:#000000">Estado</td>
								<td style="border-top-color:#000000"><?php echo $estado;?></td>
								<td width="3%" id="tdtitulogris" style="border-top-color:#000000">Código</td>
								<td style="border-top-color:#000000"><?php echo $row_datosmateria['codigomateria'];?></td>
							</tr>
							<?php 
							// Selecciona los datos de los grupos para una materia   
							$query_datosgrupos = "select g.idgrupo, concat(d.nombredocente,' ',d.apellidodocente) as nombre, g.maximogrupo, g.matriculadosgrupo, g.codigoindicadorhorario, g.nombregrupo
							from grupo g, docente d
							where g.numerodocumento = d.numerodocumento
							and g.codigomateria = '$codigomateria'
							and g.codigoperiodo = '$codigoperiodo'
							and g.idgrupo = '$idgrupo'
							and g.codigoestadogrupo = '10' 
							and d.codigoestado=100";			
							$datosgrupos=mysql_query($query_datosgrupos, $sala) or die("$query_datosgrupos");
							$totalRows_datosgrupos = mysql_num_rows($datosgrupos);
							if($totalRows_datosgrupos != "")
							{
								while($row_datosgrupos = mysql_fetch_array($datosgrupos))
								{
									$query_datoshorarios = "select d.codigodia, d.nombredia, h.horainicial, h.horafinal, s.nombresalon, s.codigosalon, se.codigosede
									from horario h, dia d, salon s, sede se
									where h.codigodia = d.codigodia
									and h.codigosalon = s.codigosalon
									and h.idgrupo = '$idgrupo'
									and s.codigosede = se.codigosede
									order by 1,3,4";											
									$datoshorarios=mysql_query($query_datoshorarios, $sala) or die("$query_datoshorarios");
									$totalRows_datoshorarios = mysql_num_rows($datoshorarios);
									?>
									<tr> 
										<td id="tdtitulogris">Grupo</td>
										<td><?php echo $row_datosgrupos['idgrupo'];?></td>
										<?php 
										/* @modified Ivan quintero <quinteroivan@unbosque.edu.co>
										 *  @since  Enero 03, 2017
										 *  funcion para precargue de horarios
										*/
										$gruponumero = $row_datosgrupos['idgrupo']; 
										?>
										<script>
											$(document).ready(function() {
												$(window).load(function() {
													Previsualizar(<?php echo $gruponumero; ?>);
												});
											});					
										</script>	
										<!-- end -->
										<td colspan="2" id="tdtitulogris">Docente</td>
										<td><?php echo $row_datosgrupos['nombre'];?></td>
										<td cellpadding="2" cellspacing="1" id="tdtitulogris">Nombre Grupo</td>
										<td><?php echo $row_datosgrupos['nombregrupo'];?></td>
										<?php
										if(!$eselectivalibre)
										{
											?> 
											<td id="tdtitulogris">Semestre</td>
											<td><?php echo $row_datosmateria['semestredetalleplanestudio'];?></td>
											<?php
										}
										else
										{
											?>
											<td width="5%" colspan="2" id="tdtitulogris">Materia Electiva</td>
											<?php
										}
										?>
										<td id="tdtitulogris">Créditos</td>
										<td><?php echo $row_datosmateria['numerocreditos'];?>&nbsp;</td>
									</tr>
									<?php
									if(ereg("^1+",$row_datosgrupos['codigoindicadorhorario']))
									{
										if($totalRows_datoshorarios != "")
										{
											$tieneprimergrupoconhorarios = true;
											?>
											<tr>
												<td colspan="11"> 
													<table width="100%" border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9">
														<tr id="trtitulogris"> 
															<td>Sede</td>
															<td>D&iacute;a</td>
															<td>Hora Inicial</td>
															<td>Hora Final</td>
															<td>Sal&oacute;n</td>
														</tr>
														<?php
														while($row_datoshorarios = mysql_fetch_array($datoshorarios))
														{
														?>
															<tr>
																<td><?php echo ($arreglo_asignaturas[$idgrupo][$row_datoshorarios['nombredia']]['sede'] == '') ? 'Falta por asignar' : $arreglo_asignaturas[$idgrupo][$row_datoshorarios['nombredia']]['sede'];?></td>
																<td><?php echo $row_datoshorarios['nombredia'];?></td>
																<td><?php echo $row_datoshorarios['horainicial'];?></td>
																<td><?php echo $row_datoshorarios['horafinal'];?></td>
																<td><?php echo ($arreglo_asignaturas[$idgrupo][$row_datoshorarios['nombredia']]['salon'] == '') ? 'Falta por asignar' : $arreglo_asignaturas[$idgrupo][$row_datoshorarios['nombredia']]['salon'];?></td>
															</tr>
														<?php		
														}//while
														?>	
													</table>
												</td>
											</tr>
											<?php
										}//if
										else
										{
											$horariorequerido = true;
											?>
											<tr><td colspan="11"><label id="labelresaltado">Este grupo requiere horario, dirijase a su facultad para informarlo</label></td></tr>
											<?php
										}
									}
									else
									{							
										?>
										<tr><td colspan="11"><label id="labelresaltado">Este grupo no necesita horario</label></td></tr>
										<?php 
									}//else
								}//while
							}
							if($tieneprimergrupo)
							{
								?>
								</table>
								<?php
							}
							else
							{
								?>
								<tr><td colspan="11"><!-- Esta materia no tiene grupos con cupo o con horarios, informelo a la facultad. <br> Si desea tomar grupos en otra jornada oprima el botón <font color="#000000">Modificar Horarios.  --></td></tr>
								<!-- <tr><td colspan="11">&nbsp;</td></tr> -->
								</table>
							<?php
							}						
					}//while
				}//if
			}//while
		?>
		<br/> <!-- 
				@modified Ivan quintero <quinteroivan@unbosque.edu.co>
				@since  Enero 03, 2017
				ESTE DIV MUESTRA LA TABLA DEL CALENDARIO DE LOS GRUPOS SELECCIONADOS POR EL ESTUDIANTE-->
				<div style="position:fixed !important;right:10px; top:10px; z-index:10000 !important;">										
					<button type="button" class="btn btn-warning btn-lg" data-toggle="modal" data-target="#myModal">PREVIZUALIZACION DEL HORARIO</button>
					
					<div class="modal fade" id="myModal" role="dialog">
					<div class="modal-dialog">

					  <!-- Modal-->
					  <div class="modal-content" style="width: 800px;">
						<div class="modal-header">
						  <button type="button" class="close" data-dismiss="modal">&times;</button>
						  <h4 class="modal-title"><center>PREVIZUALIZACION DEL HORARIO </center></h4>
						</div>
						<div class="modal-body">
							<center>
						  <table id="calendario" width="700px" class="table table-bordered table-striped">
							<thead >
								<th style="background:#57A639;">Horas</th><th style="background:#57A639;">LUNES</th><th style="background:#57A639;">MARTES</th><th style="background:#57A639;">MIERCOLES</th><th style="background:#57A639;">JUEVES</th><th style="background:#57A639;">VIERNES</th><th style="background:#57A639;">SABADO</th>
							</thead>
							<tbody>
								<tr id="h7" style="display:none;">
									<td><strong>7:00</strong></td><td id="d17"></td><td id="d27"></td><td id="d37"></td><td id="d47"></td><td id="d57"></td><td id="d67"></td>
								</tr>
								<tr id="h8" style="display:none;" >
									<td><strong>8:00</strong></td><td id="d18" ></td><td id="d28"></td><td id="d38"></td><td id="d48"></td><td id="d58"></td><td id="d68"></td>
								</tr>
								<tr id="h9" style="display:none;">
									<td><strong>9:00</strong></td><td id="d19" ></td><td id="d29"></td><td id="d39"></td><td id="d49"></td><td id="d59"></td><td id="d69"></td>
								</tr>
								<tr id="h10" style="display:none;">
									<td><strong>10:00</strong></td><td id="d110"></td><td id="d210"></td><td id="d310"></td><td id="d410"></td><td id="d510"></td><td id="d610"></td>
								</tr>
								<tr id="h11" style="display:none;">
									<td><strong>11:00</strong></td><td id="d111"></td><td id="d211"></td><td id="d311"></td><td id="d411"></td><td id="d511"></td><td id="d611"></td>
								</tr>
								<tr id="h12" style="display:none;">
									<td><strong>12:00</strong></td><td id="d112"></td><td id="d212"></td><td id="d312"></td><td id="d412"></td><td id="d512"></td><td id="d612"></td>
								</tr>
								<tr id="h13" style="display:none;">
									<td><strong>13:00</strong></td><td id="d113"></td><td id="d213"></td><td id="d313"></td><td id="d413"></td><td id="d513"></td><td id="d613"></td>
								</tr>
								<tr id="h14" style="display:none;">
									<td><strong>14:00</strong></td><td id="d114"></td><td id="d214"></td><td id="d314"></td><td id="d414"></td><td id="d514"></td><td id="d614"></td>
								</tr>
								<tr id="h15" style="display:none;">
									<td><strong>15:00</strong></td><td id="d115"></td><td id="d215"></td><td id="d315"></td><td id="d415"></td><td id="d515"></td><td id="d615"></td>
								</tr>
								<tr id="h16" style="display:none;">
									<td><strong>16:00</strong></td><td id="d116"></td><td id="d216"></td><td id="d316"></td><td id="d416"></td><td id="d516"></td><td id="d616"></td>
								</tr>
								<tr id="h17" style="display:none;">
									<td><strong>17:00</strong></td><td id="d117"></td><td id="d217"></td><td id="d317"></td><td id="d417"></td><td id="d517"></td><td id="d617"></td>
								</tr>
								<tr id="h18" style="display:none;">
									<td><strong>18:00</strong></td><td id="d118"></td><td id="d218"></td><td id="d318"></td><td id="d418"></td><td id="d518"></td><td id="d618"></td>
								</tr>
								<tr id="h19" style="display:none;">
									<td><strong>19:00</strong></td><td id="d119"></td><td id="d219"></td><td id="d319"></td><td id="d419"></td><td id="d519"></td><td id="d619"></td>
								</tr>
								<tr id="h20" style="display:none;">
									<td><strong>20:00</strong></td><td id="d120"></td><td id="d220"></td><td id="d320"></td><td id="d420"></td><td id="d520"></td><td id="d620"></td>
								</tr>
								<tr id="h21" style="display:none;">
									<td><strong>21:00</strong></td><td id="d121"></td><td id="d221"></td><td id="d321"></td><td id="d421"></td><td id="d521"></td><td id="d621"></td>
								</tr>
							</tbody>
							</table>
								</center>
						</div>
						<div class="modal-footer">
						  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						</div>
					  </div>
						<!-- fin del modal -->
					</div>  
					</div>
			</div>
				<!-- FIN DIV-->
		<p>
			<input name="imprimir" type="button" id="imprimir" value="Imprimir" onClick="window.print()">&nbsp;
			<input name="volver" type="button" id="volver" value="Regresar" onClick="history.go(-1)">
		</p>		
		<?php
		$permisograbar = true;
		if(isset($_POST['grabar']))
		{
			foreach($_POST as $llavepost => $valorpost)
			{
				if(ereg("grupo",$llavepost))
				{			
					$codmat = ereg_replace("grupo","",$llavepost);
					// Se guardan el codigo del grupo para una materia
					$materiascongrupo[$codmat] = $valorpost;
					// $valorpost lleva el idgrupo
					$query_horarioselegidos = "select d.codigodia, d.nombredia, h.horainicial, h.horafinal, s.nombresalon, s.codigosalon
					from horario h, dia d, salon s, grupo g
					where h.codigodia = d.codigodia
					and h.codigosalon = s.codigosalon
					and h.idgrupo = '$valorpost'
					and g.idgrupo = h.idgrupo
					and g.codigoindicadorhorario like '1%'
					order by 1,3,4";
					$horarioselegidos=mysql_query($query_horarioselegidos, $sala) or die("$query_horarioselegidos");
					$totalRows_horarioselegidos = mysql_num_rows($horarioselegidos);

					while($row_horarioselegidos = mysql_fetch_array($horarioselegidos))
					{
						$codigomateriahorarios[] = ereg_replace("grupo","",$llavepost);
						$diahorarios[] = $row_horarioselegidos['codigodia'];
						$horainicialhorarios[] = $row_horarioselegidos['horainicial'];
						$horafinalhorarios[] = $row_horarioselegidos['horafinal'];
					}
				}
			}
			// Este for lo va a hacer mientras halla horarios
			$maximohorarios = count($codigomateriahorarios)-1;
			for($llavehorario1 = 0; $llavehorario1 <= $maximohorarios; $llavehorario1++) 
			{
				for($llavehorario2 = 0; $llavehorario2 <= $maximohorarios; $llavehorario2++) 
				{	  
					if($diahorarios[$llavehorario1] == $diahorarios[$llavehorario2] and $llavehorario1 != $llavehorario2)
					{
						if((date("H-i-s",strtotime($horainicialhorarios[$llavehorario1])) >= date("H-i-s",strtotime($horainicialhorarios[$llavehorario2])))and(date("H-i-s",strtotime($horainicialhorarios[$llavehorario1])) < date("H-i-s",strtotime($horafinalhorarios[$llavehorario2]))))
						{				         
							$permisograbar = false;
							echo '<script language="JavaScript">
								alert("FAVOR VERIFICAR HORARIOS SELECCIONADOS PRESENTA CRUCE ENTRE '.$nombresmateria[$codigomateriahorarios[$llavehorario1]].' Y  '.$nombresmateria[$codigomateriahorarios[$llavehorario2]].'");
								history.go(-1);
							</script>';
							/*echo "<script language='javascript'>
								window.location.href='matriculaautomaticahorarios.php?programausadopor=".$_GET['programausadopor']."&materiassinhorarios=$materiasserial';
							</script>";*/	     
							$llavehorario1 = $maximohorarios+1;
							$llavehorario2 = $maximohorarios+1;
						}
					}
				}
			}
			if($permisograbar)
			{
				$procesoautomatico = false;
				require("matriculaautomaticaguardar.php");
			}
		}
		?>
		<script language="javascript">
		function habilitar(campo)
		{
			var entro = false;
			for (i = 0; i < campo.length; i++)
			{
				campo[i].disabled = false;
				entro = true;
			}
			if(!entro)
			{
				form1.habilita.disabled = false;
			}
		}		
		/* @modified Ivan quintero <quinteroivan@unbosque.edu.co>
		 *  @since  Enero 03, 2017
		 *  funcion para mostrar los horarios
		*/
		function Previsualizar(grupoid)
		{
			//var grupoid =  grupo.value;
			$.ajax({
				type: 'post',
				url: 'HorarioPrevisualizar.php',
				data: {grupoid:grupoid},
				success: function(data)
				{
					var datos = jQuery.parseJSON(data);
					var horasi = datos.horai;
					var horasf = datos.horaf; 
					var dias = datos.dia; 
					var gruponombre = datos.grupo;
					var idgrupo = datos.idgrupo;
					var codmateria = datos.codmateria;
					var nombremateria = datos.nombremateria;
					var docente = datos.docente;
					var tableReg = document.getElementById('calendario');

					for (var i = 1; i < tableReg.rows.length; i++)
					{
						var cellsOfRow = tableReg.rows[i].getElementsByTagName('td');																			
						for (var j = 0; j < cellsOfRow.length ; j++)
						{
							var compareWith = cellsOfRow[j].innerHTML.toLowerCase();								
							if (compareWith.indexOf(codmateria[0]+'m') > -1)
							{
								var k = 6+i;
								$('#d'+j+k).text("");
								$('#d'+j+k).css("background-color", "#ffffff");//blanco
							}
						}//for
					}//for

					$.each(dias, function( k, v ) 
					{
						var final = parseInt(horasf[k]);																					

						for(var inicial = parseInt(horasi[k]); inicial < final; inicial++)							
						{
							$('#h'+inicial).show();
							var textCell = $('#d'+v+''+inicial).text();
							textCell = textCell.trim();

							if(textCell)
							{
								if($('#d'+v+''+inicial).text().indexOf(idgrupo[0]) == -1)
								{	
									$('#d'+v+''+inicial).css("background-color", "#E72512");//rojo	
									$('#d'+v+''+inicial).append(" ---------- "+nombremateria[0]+"<div style='display: none;'>"+idgrupo[0]+' - '+codmateria[0]+'m '+"<div>");
								}									
							}else
							{
								//$('#d'+v+''+inicial).css("background-color", "#57A639");//verde
								$('#d'+v+''+inicial).append('<center><strong>'+nombremateria[0]+'</strong> Grupo:'+idgrupo[0]+' Materia:'+codmateria[0]+' Docente: '+docente[0]+'</center>');			
							}							
						}//for
					}); 
				}//function data
			});
		}//function Previsualizar
			/* END*/
		</script>
	</body>
</html>