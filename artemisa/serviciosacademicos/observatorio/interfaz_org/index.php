<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>Observatorio de Éxito Estudiantil</title>
		<meta name="description" content="">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<link rel="stylesheet" href="css/normalize.css">
		<link rel="stylesheet" href="css/main.css">
		<script src="js/vendor/modernizr-2.6.2.min.js"></script>
		<link href='http://fonts.googleapis.com/css?family=Fjalla+One' rel='stylesheet' type='text/css'>

		<!-- Colapsables -->
		<script type="text/javascript" src="js/jquery-1.2.2.pack.js"></script>
		<script type="text/javascript" src="js/animatedcollapse.js"></script>
		<script type="text/javascript">
			animatedcollapse.addDiv('primero-a', 'persist=0,hide=1,speed=400,group=grupo1')			<!-- Pregrado -->
			animatedcollapse.addDiv('primero-b', 'persist=0,hide=1,speed=400,group=grupo2')			<!-- Pregrado -->
			animatedcollapse.addDiv('primero-c', 'persist=0,hide=1,speed=400,group=grupo3')			<!-- Pregrado -->
			animatedcollapse.addDiv('segundo-a', 'persist=0,hide=1,speed=400,group=grupo4')			<!-- Pregrado -->
			animatedcollapse.addDiv('segundo-b', 'persist=0,hide=1,speed=400,group=grupo5')			<!-- Pregrado -->
			animatedcollapse.addDiv('segundo-c', 'persist=0,hide=1,speed=400,group=grupo6')			<!-- Pregrado -->
			animatedcollapse.addDiv('segundo-d', 'persist=0,hide=1,speed=400,group=grupo7')			<!-- Pregrado -->
			animatedcollapse.addDiv('segundo-e', 'persist=0,hide=1,speed=400,group=grupo8')			<!-- Pregrado -->
			animatedcollapse.addDiv('tercero-a', 'persist=0,hide=1,speed=400,group=grupo9')			<!-- Postgrado -->
			animatedcollapse.init()
		</script>

	</head>
	<body id="mando">
		<!--[if lt IE 7]>
			<p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
		<![endif]-->

		<!-- Add your site or application content here -->
		<div id="encabezado">
			<div class="cajon">
				<div>
					<div>Tablero de mando</div>
					<div>para observatorio de</div>
				</div>
				<div>
					Éxito Estudiantil
				</div>
			</div>
		</div>

		<div id="grueso">
			<div class="cajon">
				<ul>
					<li id="uno"><span class="titulo-programa">Inmersión a la vida universitaria</span>
						<ul class="programa">
							<li class="bloque col1">
								<a href="javascript:animatedcollapse.toggle('primero-a')" class="nivel1a">Prueba de intereses<div class="colapsable"></div></a>
								<div id="primero-a" class="contenedor">
									<ul>
										<li><a href="#" title="">Ver reporte »</a></li>
									</ul>
								</div>
							</li>
							<li class="bloque col1">
								<a href="javascript:animatedcollapse.toggle('primero-b')" class="nivel1a">Admisiones<div class="colapsable"></div></a>
								<div id="primero-b" class="contenedor">
									<ul>
										<li><a href="#" title="">Admisiones »</a></li>
										<li><a href="../interfaz/listar_metas_admisiones.php" title="">Metas de admisiones »</a></li>
										<li><a href="../interfaz/listar_metas_matriculados.php" title="">Metas de matriculados »</a></li>
										<li><a href="../interfaz/listar_estudiantes_por_admitir.php" title="">Estudiantes por admitir »</a></li>
										<li><a href="#" title="">Reporte demográfico »</a></li>
									</ul>
								</div>
							</li>
							<li class="bloque col1">
								<a href="javascript:animatedcollapse.toggle('primero-c')" class="nivel1a">Entrevistas<div class="colapsable"></div></a>
								<div id="primero-c" class="contenedor">
									<ul>
									    <li><a href="../interfaz/listar_estudiantes_admitidos.php" title="">Estudiantes . Entrevista »</a></li>	
                                                                            <li><a href="#" title="">Alertas tempranas »</a></li>
									</ul>
								</div>
							</li>
						</ul>
					</li>
					<li id="dos"><span class="titulo-programa">Desarrollo de la vida universitaria</span>
						<ul class="programa">
							<div class="col2">
								<li class="bloque">
									<a href="javascript:animatedcollapse.toggle('segundo-a')" class="nivel1a">PAE<div class="colapsable"></div></a>
									<div id="segundo-a" class="contenedor">
										<ul>
											<li class="titular">Riesgo</li>
											<li><a href="../interfaz/listar_tipocausas.php" title="">Tipo de riesgo »</a></li>
											<li><a href="../interfaz/listar_causas.php" title="">Variables de riesgo »</a></li>
											<li><a href="../interfaz/listar_registro_riesgo.php?tipo=R" title="">Registro de riesgo »</a></li>
											<li><a href="../interfaz/listar_registro_riesgo.php?tipo=P" title="">Identificación del riesgo »</a></li>
											<li><a href="../interfaz/solicitar.php?tipo=PS" title="">Seguimiento psicológico »</a></li>
											<li><a href="../interfaz/solicitar.php?tipo=PF" title="">Seguimiento financiero »</a></li>
											<li><a href="../interfaz/listar_citaciones.php" title="">Citaciones »</a></li>
											<li><a href="../interfaz/solicitar.php?tipo=TU" title="">Tutorías »</a></li>
                                                                                        <li><a href="../interfaz/solicitar.php?tipo=TU" title="">Estudiante Tutor »</a></li>
										</ul>
										<ul>
											<li class="titular">Seguimiento</li>
											<li><a href="../interfaz/listar_registro_riesgo.php?tipo=S" title="">Seguimiento de estudiante - docente »</a></li>
                                                                                        <li><a href="../interfaz/listar_registro_riesgo.php?tipo=SE" title="">Seguimiento de estudiante »</a></li>
											<li><a href="../../consulta/estadisticas/riesgos/menuhistoriconotas.php" title="">Listado histórico definitivas periodo »</a></li>
											<li><a href="../../consulta/estadisticas/notascorte/menunotascorte_new.php" title="">Listado notas perdidas por corte »</a></li>
											<li><a href="../../consulta/estadisticas/riesgos/menulistadopromedio.php" title="">Listado promedio corte »</a></li>
											<li><a href="../../consulta/estadisticas/riesgos/menuriesgosmateria.php" title="">Listados riesgos de estudiantes por materia »</a></li>
											<li><a href="../../consulta/estadisticas/riesgos/menuriesgossemestre.php" title="">Listados riesgos de estudiantes por semestres »</a></li>
											<li><a href="#" title="">Ganancia Académica »</a></li>
											<li><a href="#" title="">Indicador de Repitencia de Asignaturas »</a></li>
										</ul>
									</div>
								</li>
								<li class="bloque">
									<a href="javascript:animatedcollapse.toggle('segundo-b')" class="nivel1a">Retención / Deserción<div class="colapsable"></div></a>
									<div id="segundo-b" class="contenedor">
										<ul>
											<li class="titular">Retención</li>
											<li><a href="#" title="">Semestral »</a></li>
											<li><a href="#" title="">Anual »</a></li>
											<li><a href="#" title="">Por cohorte »</a></li>
										</ul>
										<ul>
											<li class="titular">Deserción</li>
											<li><a href="#" title="">Semestral »</a></li>
											<li><a href="#" title="">Anual »</a></li>
											<li><a href="#" title="">Por cohorte »</a></li>
										</ul>
										<ul>
											<li class="titular">Costos de deserción</li>
											<li><a href="#" title="">Reporte histórico »</a></li>
											<li><a href="#" title="">Reporte por periodo »</a></li>
											<li><a href="#" title="">Reporte por programa »</a></li>
										</ul>
									</div>
								</li>
								<li class="bloque">
									<a href="javascript:animatedcollapse.toggle('segundo-e')" class="nivel1a">Internacionalización<div class="colapsable"></div></a>
									<div id="segundo-e" class="contenedor">
										<ul>
											<li><a href="#" title="">Ver reporte »</a></li>
										</ul>
									</div>
								</li>
							</div>
							<div class="col1">
								<li class="bloque">
									<a href="javascript:animatedcollapse.toggle('segundo-c')" class="nivel1a">Salas de aprendizaje<div class="colapsable"></div></a>
									<div id="segundo-c" class="contenedor">
										<ul>
											<li><a href="../interfaz/listar_grupos.php" title="">Administración de salas de aprendizaje »</a></li>
											<li><a href="../interfaz/listar_riesgo_salas.php" title="">Tutorías »</a></li>
										</ul>
									</div>
								</li>
								<li class="bloque">
									<a href="javascript:animatedcollapse.toggle('segundo-d')" class="nivel1a">Spadies<div class="colapsable"></div></a>
									<div id="segundo-d" class="contenedor">
										<ul>
											<li><a href="#" title="">Primer nivel »</a></li>
											<li><a href="#" title="">Matriculados »</a></li>
											<li><a href="#" title="">Graduados »</a></li>
											<li><a href="#" title="">Retiros disciplinarios »</a></li>
											<li><a href="#" title="">Apoyos financieros »</a></li>
											<li><a href="#" title="">Apoyos académicos »</a></li>
											<li><a href="#" title="">Otros apoyos »</a></li>
										</ul>
									</div>
								</li>
							</div>
						</ul>
					</li>
					<li id="tres"><span class="titulo-programa">Preparación a la vida laboral</span>
						<ul class="programa">
							<li class="bloque">
								<a href="javascript:animatedcollapse.toggle('tercero-a')" class="nivel1a">Saber PRO<div class="colapsable"></div></a>
								<div id="tercero-a" class="contenedor">
									<ul>
										<li class="titular">Tutorías</li>
										<li><a href="#" title="">Seguimiento de tutorías »</a></li>
									</ul>
									<ul>
										<li><a href="#" title="">Gestión de resultados »</a></li>
									</ul>
									<ul>
										<li class="titular">Gestión de reportes</li>
										<li><a href="#" title="">UEB Vs. nacional »</a></li>
										<li><a href="#" title="">Programas Vs. UEB »</a></li>
										<li><a href="#" title="">Programa Vs. nacional »</a></li>
									</ul>
								</div>
							</li>
						</ul>
					</li>
				</ul>
			</div>
		</div>

		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.13.1/jquery.min.js"></script>
		<script>window.jQuery || document.write('<script src="js/vendor/jquery-1.13.1.min.js"><\/script>')</script>
		<script src="js/plugins.js"></script>
		<script src="js/main.js"></script>
	</body>
</html>