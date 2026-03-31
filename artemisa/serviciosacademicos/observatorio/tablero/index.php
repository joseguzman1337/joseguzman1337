<?php
session_start();
/*error_reporting(E_ALL);
ini_set('display_errors', '0');*/
include('../templates/templateObservatorio.php');
include("../interfaz/funciones.php");
$db=writeHeaderBD();


function link_H($db,$url1,$modulo,$titulo){
        $fun = new Observatorio(); 
        $on=''; $img=''; $permiso=''; $url=$url1;
		
		$consulta = $fun->ConsultaUsuarioN($db,$_SESSION['MM_Username']);
		/*Se verifica que exista en el nuevo esquema de roles*/
		
		if($consulta == false){ 
			
			$permisoA= $fun->rolesV($db,$_SESSION['MM_Username'],$url);
			if($permisoA == false){
			   $on='onclick="return false"';
			   $img='<img src="img/candado.png"  height="20" width="20" alt="No tiene Acceso" >';
			   $url1='#';
			}
		}else
		{
			$permiso=$fun->roles($db,$_SESSION['MM_Username'],$url);	
			if($permiso == false){
			   $on='onclick="return false"';
			   $img='<img src="img/candado.png"  height="20" width="20" alt="No tiene Acceso" >';
			   $url1='#';
			}	
		}
	   ?>
<a class="nivel2a" href="<?php echo $url1 ?>" title="" <?php echo $on ?> ><?php echo $titulo ?><?php echo $img ?></a>
<?php
}
?>
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
<link href='css/utils.css' rel='stylesheet' type='text/css'>
<!-- Colapsables -->
<script type="text/javascript" src="js/jquery-1.2.2.pack.js"></script>
<script type="text/javascript" src="js/animatedcollapse.js"></script>
<script type="text/javascript">
			
			animatedcollapse.addDiv('primero-a', 'persist=0,hide=1,speed=400,group=grupo1');			<!-- Pregrado -->
			animatedcollapse.addDiv('primero-b', 'persist=0,hide=1,speed=400,group=grupo2');			<!-- Pregrado -->
			animatedcollapse.addDiv('primero-c', 'persist=0,hide=1,speed=400,group=grupo3');			<!-- Pregrado -->
			animatedcollapse.addDiv('segundo-a', 'persist=0,hide=1,speed=400,group=grupo4');			<!-- Pregrado -->
			animatedcollapse.addDiv('segundo-b', 'persist=0,hide=1,speed=400,group=grupo5');			<!-- Pregrado -->
			animatedcollapse.addDiv('segundo-c', 'persist=0,hide=1,speed=400,group=grupo6');			<!-- Pregrado -->
			animatedcollapse.addDiv('segundo-d', 'persist=0,hide=1,speed=400,group=grupo7');			<!-- Pregrado -->
			animatedcollapse.addDiv('segundo-e', 'persist=0,hide=1,speed=400,group=grupo8');			<!-- Pregrado -->
			animatedcollapse.addDiv('tercero-a', 'persist=0,hide=1,speed=400,group=grupo9');			<!-- Postgrado -->
			animatedcollapse.addDiv('cinco-a', 'persist=0,hide=1,speed=400,group=grupo10');			<!-- Postgrado -->
			animatedcollapse.addDiv('seis-a', 'persist=0,hide=1,speed=400,group=grupo11');			<!-- Postgrado -->
			animatedcollapse.addDiv('siete-a', 'persist=0,hide=1,speed=400,group=grupo12');			<!-- Postgrado -->
			
			animatedcollapse.init();
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
    <div> Éxito Estudiantil </div>
  </div>
</div>
<div id="grueso">
  <div class="cajon">
    <ul>
      <li id="uno"><span class="titulo-programa">Administrador</span>
        <ul class="programa">
          <li class="bloque col1"> <a href="javascript:animatedcollapse.toggle('primero-a')" class="nivel1a">Herramientas de Administrador del Sistema
            <div class="colapsable"></div>
            </a>
            <div id="primero-a" class="contenedor">
              <ul>
                <li> <?php echo  link_H($db,'../permisos/Consola_Roles.html.php','Consola de Permisos','Consola de Asiganción de Permisos »') ?>
                  <!--<a href="../interfaz/buscar_prueba_interes.php" title="" onclick="return false">Ver reporte »</a>-->
                </li>
                <li> <?php echo  link_H($db,'../permisos/Consola_Permisos.html.php','Consola de Permisos','Consola de Asiganción de Roles »') ?>
                  <!--<a href="../interfaz/buscar_prueba_interes.php" title="" onclick="return false">Ver reporte »</a>-->
                </li>
                <li> <?php echo  link_H($db,'../permisos/AsignarCarrera.html.php','Asignacion de Carreras','Asignacion de Carreras »') ?>
                  <!--<a href="../interfaz/buscar_prueba_interes.php" title="" onclick="return false">Ver reporte »</a>-->
                </li>
              </ul>
            </div>
          </li>
        </ul>
      </li>
      <li id="uno"><span class="titulo-programa">Inmersión a la vida universitaria</span>
        <ul class="programa">
          <li class="bloque col1"> <a href="javascript:animatedcollapse.toggle('segundo-a')" class="nivel1a">Prueba de intereses
            <div class="colapsable"></div>
            </a>
            <div id="segundo-a" class="contenedor">
              <ul>
                <li> <?php echo  link_H($db,'../interfaz/buscar_prueba_interes.php','Prueba de intereses','Ver reporte »') ?>
                  <!--<a href="../interfaz/buscar_prueba_interes.php" title="" onclick="return false">Ver reporte »</a>-->
                </li>
              </ul>
            </div>
          </li>
          <li class="bloque col1"> <a href="javascript:animatedcollapse.toggle('primero-b')" class="nivel1a">Admisiones
            <div class="colapsable"></div>
            </a>
            <div id="primero-b" class="contenedor">
              <ul>
                <li><?php echo link_H($db,'../interfaz/listar_admisiones_estadisticas.php','Admisiones','Admisiones »') ?>
                  <!-- <a href="../interfaz/listar_admisiones_estadisticas.php" title="">Admisiones »</a>-->
                </li>
                <li><?php echo link_H($db,'../interfaz/listar_metas_matriculados.php','Metas matriculados','Metas de matriculados »') ?>
                  <!-- <a href="../interfaz/listar_metas_matriculados.php" title="">Metas de matriculados »</a>-->
                </li>
                <li><?php echo link_H($db,'../interfaz/listar_metas_admisiones.php','Metas admisiones','Metas  de admisiones »') ?>
                  <!-- <a href="../interfaz/listar_metas_admisiones.php" title="">Metas  de admisiones »</a>-->
                </li>
                <li><?php echo link_H($db,'../Desercion/DesercionCosto_html.php?actionID=Reporte','Reporte demografico','Reporte demográfico »') ?>
                  <!-- <a href="../Desercion/DesercionCosto_html.php?actionID=Reporte" title="">Reporte demográfico »</a>-->
                </li>
              </ul>
            </div>
          </li>
          <li class="bloque col1"> <a href="javascript:animatedcollapse.toggle('primero-c')" class="nivel1a">Entrevistas
            <div class="colapsable"></div>
            </a>
            <div id="primero-c" class="contenedor">
              <ul>
                <li><?php echo link_H($db,'../interfaz/listar_estudiantes_admitidos.php','Entrevistador','Entrevista »') ?>
                  <!-- <a href="../interfaz/listar_estudiantes_admitidos.php" title="">Entrevista »</a>-->
                </li>
                <li><?php echo link_H($db,'../interfaz/listar_estudiantes_por_admitir.php','Coordinador - Entrevista','Estudiantes por admitir »') ?>
                  <!-- <a href="../interfaz/listar_estudiantes_por_admitir.php" title="">Estudiantes por admitir »</a>-->
                </li>
                <li><?php echo link_H($db,'../interfaz/listar_estudiantes_riesgo_financiero.php','Alertas tempranas','Alertas tempranas »') ?>
                <li><?php echo link_H($db,'../interfaz/ReportesEntrevistas_html.php','Reporte Saber 11','Reporte Saber 11 »') ?>
                <li><?php echo link_H($db,'../interfaz/ReportesEntrevistas_html.php?actionID=Repote','Reporte Entrevistas','Reporte Entrevistas »') ?>
                  <!-- <a href="../interfaz/listar_estudiantes_riesgo_financiero.php" title="">Alertas tempranas »</a>-->
                </li>
                <li><?php echo link_H($db,'../reportes/Reporte_AdmitidoNoAdmitidos.html.php','Reporte Admitidos y No Admitidos','Reporte Admitidos y No Admitidos »') ?></li>
              </ul>
            </div>
          </li>
        </ul>
      </li>
      <li id="dos"><span class="titulo-programa">Desarrollo de la vida universitaria</span>
        <ul class="programa">
          <div class="col4">
            <!-- 
									@Autor: KATARY ("HDCC") 
									@Descripción:  "se agrego el modulo denominado hoja de Visda Estudiantil" "QR-24??"
									@Fecha de modificación: 06/Marzo/2018
								-->
            <li class="bloque"> <a href="javascript:animatedcollapse.toggle('siete-a')" class="nivel1a">Hoja de vida estudiantil
              <div class="colapsable"></div>
              </a>
              <div id="siete-a" class="contenedor">
                <ul>
                  <li> <?php echo  link_H($db,'../interfaz/ConsultaHojadeVida.php','Hoja de vida Estudiante Consulta','Consulta »') ?> </li>
                  <li> <?php echo  link_H($db,'../interfaz/ReporteHojaVida.php','Reporte','Reporte »') ?>
                    <!--<a href="../interfaz/buscar_prueba_interes.php" title="" onclick="return false">Ver reporte »</a>-->
                  </li>
                </ul>
              </div>
            </li>
            <li class="bloque"> <a href="javascript:animatedcollapse.toggle('segundo-b')" class="nivel1a">Indicadores de &Eacute;xito Estudiantil
              <div class="colapsable"></div>
              </a>
              <div id="segundo-b" class="contenedor">
                <ul>
                  <li class="titular"><?php echo link_H($db,'../Desercion/Desercion_html.php?actionID=Retencion','Permanencia','Permanencia »') ?>
                    <!--<a href="../Desercion/Desercion_html.php?actionID=Retencion" title="">Retención »</a>-->
                  </li>
                  <?php
											/*
											 * @modified Andres Ariza <arizaandres@unbosque.edu.co>
											 * Estas opciones se movieron del menu pae hacia Indicadores de Éxito estudiantil deacuerdo al documento Requerimientos Éxito Estudiantil - OEES Última versión.doc
											 * @since  January 12, 2017
											*/
											?>
                  <li> <?php echo link_H($db,'../../consulta/estadisticas/riesgos/menuhistoriconotas.php','Listado historico definitivas periodo','Listado histórico definitivas periodo »') ?>
                    <!--<a href="../../consulta/estadisticas/riesgos/menuhistoriconotas.php" title="">Listado histórico definitivas periodo »</a>-->
                  </li>
                  <li> <?php echo link_H($db,'../../consulta/estadisticas/notascorte/menunotascorte_new.php','Listado notas perdidas por corte','Listado notas perdidas por corte »') ?>
                    <!--<a href="../../consulta/estadisticas/notascorte/menunotascorte_new.php" title="">Listado notas perdidas por corte »</a>-->
                  </li>
                  <li> <?php echo link_H($db,'../../consulta/estadisticas/riesgos/menulistadopromedio.php','Listado promedio corte','Listado promedio corte »') ?>
                    <!--<a href="../../consulta/estadisticas/riesgos/menulistadopromedio.php" title="">Listado promedio corte »</a>-->
                  </li>
                  <?php
											/* Fin Modificación */
											?>
                  <!--<li><a href="#" title="">Semestral »</a></li>
											<li><a href="#" title="">Anual »</a></li>
											<li><a href="#" title="">Por cohorte »</a></li>-->
                </ul>
                <ul>
                  <li class="titular"><?php echo link_H($db,'../Desercion/Desercion_html.php?actionID=Consola','Desercion','Deserción »') ?>
                    <!--<a href="../Desercion/Desercion_html.php?actionID=Consola" title="">Deserción »</a>-->
                  </li>
                  <!--<li><a href="#" title="">Semestral »</a></li>
											<li><a href="#" title="">Anual »</a></li>
											<li><a href="#" title="">Por cohorte »</a></li>-->
                </ul>
                <ul>
                  <li class="titular"><?php echo link_H($db,'../Desercion/DesercionCosto_html.php?actionID=Consola','Costos de desercion','Costos de deserción »') ?>
                    <!--<a href="../Desercion/DesercionCosto_html.php" title="">Costos de deserción »</a></li>-->
                    <!--<li><a href="#" title="">Reporte histórico »</a></li>
											<li><a href="#" title="">Reporte por periodo »</a></li>
											<li><a href="#" title="">Reporte por programa »</a></li>-->
                </ul>
                <ul>
                  <li><?php echo link_H($db,'../Desercion/Desercion_html.php?actionID=Data','Estadisticas Nacionales','Estad&iacute;sticas Nacionales »') ?>
                    <!--<a href="../Desercion/Desercion_html.php?actionID=Data" title="">Gesti&oacute;n Deserción Nacional »</a>-->
                  </li>
                  <li><?php echo link_H($db,'../Desercion/Desercion_html.php?actionID=Fromularios','Graficas UEB vs Nacional','Gr&aacute;ficas UEB vs Nacional »') ?>
                    <!--<a href="../Desercion/Desercion_html.php?actionID=Fromularios" title="">Reporte Deserción Nacional »</a>-->
                  </li>
                  <!--<li><a href="#" title="">Reporte por programa »</a></li>-->
                </ul>
                <ul>
                  <li><?php echo link_H($db,'../interfaz/ganacia_academica.php','Ganancia Academica','Ganancia Académica »') ?></li>
                  <li><?php echo link_H($db,'../interfaz/indicador_repitencia.php','Indicador de Repitencia de Asignaturas','Indicador de Repitencia de Asignaturas »') ?></li>
                  <li><?php echo link_H($db,'../interfaz/listar_estudiantes_repitencia.php','Reporte de Repitencia de Asignaturas','Reporte de Repitencia de Asignaturas »') ?></li>
                  <li><?php echo link_H($db,'../../consulta/listadosvarios/perdidaasignatura/menuperdidasemestre.php','Reporte Estrategia Docentes por Semestre','Reporte Estrategia Decanatura por Semestre »') ?></li>
                  <li><?php echo link_H($db,'../../consulta/listadosvarios/perdidaasignatura/menu.php','Reporte Estrategia Docentes por Asignatura','Reporte Estrategia Docentes por Asignatura »') ?></li>
                  <li><?php echo link_H($db,'../reportes/RedirecionViewReporteTiemposCulminacion.php','Tiempos Culminaci&oacute;n','Tiempos Culminaci&oacute;n »') ?></li>
                  <li><?php echo link_H($db,'../reportes/RedirecionViewReporteEsfuerzoGraduandos.php','Esfuerzo de Graduaci&oacute;n','Esfuerzo de Graduaci&oacute;n »') ?></li>
                  <li><?php echo link_H($db,'../../consulta/facultades/planestudio/planestudioporcarrera/ConsolaListadoMateriasPlanEstudio.php','Reporte Perdida Asigantura por Semestre','Reporte Perdida Asigantura por Semestre »') ?></li>
                  <li><?php echo link_H($db,'../PerdidaCalidad.php','Reporte Perdida de la calidad academica','Reporte Perdida de la calidad academica»') ?></li>
                  <li><?php echo link_H($db,'../InformePlanEstudioPerdidad.php','Informe plan de estudios Perdidas','Informe plan de estudios Perdidas»') ?></li>
                  <li><?php echo link_H($db,'../Informehojadevida.php','Informe Hoja de vida Estudiantes','Informe Hoja de vida Estudiantes»') ?></li>
                  <li><?php echo link_H($db,'../interfaz/BusquedaDesercion.php','Modificar Histórico Deserción','Modificar Histórico Deserción »') ?></li>
                   <li> <?php echo link_H($db,'../../consulta/estadisticas/riesgos/menuriesgossemestre.php','Listados riesgos de estudiantes por semestres','Listados riesgos de estudiantes por semestres »') ?>
                            <!--<a href="../../consulta/estadisticas/riesgos/menuriesgossemestre.php" title="">Listados riesgos de estudiantes por semestres »</a>-->
                          </li>
                          
                          <li> <?php echo link_H($db,'../../consulta/estadisticas/riesgos/menuriesgosmateria.php','Listados riesgos de estudiantes por materia','Listados riesgos de estudiantes por materia »') ?>
                            <!--<a href="../../consulta/estadisticas/riesgos/menuriesgosmateria.php" title="">Listados riesgos de estudiantes por materia »</a>-->
                          </li>
                </ul>
              </div>
            </li>
            <!-- 
								@Autor: KATARY (DB) 
								@Descripción: Se agrega la opción del menú Intervención Psicopedagógica QR-29
								@Fecha de modificación: 05/Marzo/2018
								-->
            <li class="bloque"> <a href="javascript:animatedcollapse.toggle('seis-a')" class="nivel1a">INTERVENCIÓN PSICOPEDAGÓGICA
              <div class="colapsable"></div>
              </a>
              <div id="seis-a" class="contenedor">
                <div class="col3">
                  <ul>
                    <li class="titular">Consultas</li>
                    <li> <a href="javascript:void(0)" data-toggle="opcionesInformePsicoped" class="nivel2a">Informe de Intervención Psicopedagógica
                      <div class="colapsable"></div>
                      </a>
                      <div id="opcionesInformePsicoped" class="contenedor nodisplay">
                        <ul>
                          <li> <?php echo link_H($db,'../InformeIntervencionPsicopedagogica/Consulta_html.php?actionID=ConsultaMasivaPsicopedagogo','Consulta Masiva','Consulta Masiva »') ?>
                            <!-- <a href="../interfaz/solicitar_pr.php" title="">Registro de riesgo »</a>-->
                          </li>
                          <li> <?php echo link_H($db,'../InformeIntervencionPsicopedagogica/Consulta_html.php?actionID=ConsultaMasivaLider','Consulta - Lider Exito Estudiantil','Consulta - Lider Exito Estudiantil »') ?>
                            <!--<a href="../../consulta/estadisticas/riesgos/menuriesgosmateria.php" title="">Listados riesgos de estudiantes por materia »</a>-->
                          </li>
                        </ul>
                      </div>
                    </li>
                  </ul>
                </div>
                <div class="col3">
                  <ul>
                    <li class="titular">Registro</li>
                    <li> <a href="javascript:void(0)" data-toggle="fichaPsicopedagogica" class="nivel2a">Ficha Psicopedagógica
                      <div class="colapsable"></div>
                      </a>
                      <div id="fichaPsicopedagogica" class="contenedor nodisplay">
                        <ul>
                          <li> <?php echo link_H($db,'../FichaPsicopedagogica/FichaPsicopedagogicaBuscar.php','Registro de Ficha','Registro de Ficha »') ?>
                            <!-- <a href="../interfaz/solicitar_pr.php" title="">Registro de riesgo »</a>-->
                          </li>
                        </ul>
                      </div>
                    </li>
                  </ul>
                </div>
              </div>
            </li>
            <!--FIN DB -->
            <li class="bloque"> <a href="javascript:animatedcollapse.toggle('segundo-e')" class="nivel1a">Internacionalizaci&oacute;n
              <div class="colapsable"></div>
              </a>
              <div id="segundo-e" class="contenedor">
                <ul>
                  <li><?php echo link_H($db,'../interfaz/movilidad.php','Movilidad estudiantil','Movilidad Estudiantil »') ?>
                    <!--<a href="../interfaz/movilidad.php" title="">Movilidad Estudiantil »</a>-->
                  </li>
                  <li><?php echo link_H($db,'../interfaz/listar_estudiantes_internalizacion.php','Reporte Internacionalizacion','Ver reporte »') ?>
                    <!--<a href="../interfaz/listar_estudiantes_internalizacion.php" title="">Ver reporte »</a>-->
                  </li>
                </ul>
              </div>
            </li>
          </div>
          <div class="col4">
            <li class="bloque"> <a href="javascript:animatedcollapse.toggle('cinco-a')" class="nivel1a">PAE
              <div class="colapsable"></div>
              </a>
              <div id="cinco-a" class="contenedor">
                <?php
										/*
										 * @modified Andres Ariza <arizaandres@unbosque.edu.co>
										 * Se destribuyó el contenido de este menu de acuerdo al documento Requerimientos Éxito Estudiantil - OEES Última versión.doc
										 * @since  January 12, 2017
										*/
										?>
                <div class="col3">
                  <ul>
                    <li class="titular">Consultas</li>
                    <li style="padding-right:55px"> <?php echo link_H($db,'../interfaz/listar_estudiantes_riesgo_admin.php','Alertas   tempranas ','Alertas   tempranas   »  ') ?>
                      <!-- <a href="../interfaz/solicitar_pr.php" title="">Registro de riesgo »</a>-->
                    </li>
                    <li> 
                   <!--    <a href="javascript:void(0)" data-toggle="listadosRiesgoAcademico" class="nivel2a">Consulta de listados de riesgo académico
                      <div class="colapsable"></div>
                      </a>
                      <div id="listadosRiesgoAcademico" class="contenedor nodisplay">
                        <ul>
                          
                         <?php /*?> <li> <?php echo link_H($db,'../../consulta/estadisticas/riesgos/menuriesgosmateria.php','Listados riesgos de estudiantes por materia','Listados riesgos de estudiantes por materia »') ?>
                            <!--<a href="../../consulta/estadisticas/riesgos/menuriesgosmateria.php" title="">Listados riesgos de estudiantes por materia »</a>-->
                          </li><?php */?>

                        </ul>
                      </div> -->
                      <a href="javascript:void(0)" data-toggle="estudiantesRemitidosPae" class="nivel2a">Consulta de estudiantes Remitidos
                      <div class="colapsable"></div>
                      </a>
                      <div id="estudiantesRemitidosPae" class="contenedor nodisplay">
                        <ul>
                          <li> <?php echo link_H($db,'../interfaz/listar_tipocausas.php','Tipode riesgo','Tipo de riesgo »') ?>
                            <!-- <a href="../interfaz/listar_tipocausas.php" title="">Tipo de riesgo »</a>-->
                          </li>
                          <li> <?php echo link_H($db,'../interfaz/listar_causas.php','Variables de Riesgo','Variables de riesgo »') ?>
                            <!-- <a href="../interfaz/listar_causas.php" title="">Variables de riesgo »</a>-->
                          </li>
                          <li> <?php echo link_H($db,'../interfaz/listar_registro_riesgo.php?tipo=P','Identificacion del riesgo','Identificación del riesgo »') ?>
                            <!-- <a href="../interfaz/listar_registro_riesgo.php?tipo=P" title="">Identificación del riesgo »</a>-->
                          </li>
                        </ul>
                      </div>
                      <a href="javascript:void(0)" data-toggle="consultaPorEstudiante" class="nivel2a">Consulta por estudiante
                      <div class="colapsable"></div>
                      </a>
                      <div id="consultaPorEstudiante" class="contenedor nodisplay">
                        <ul>
                          <li> <?php echo link_H($db,'../interfaz/listar_registro_riesgo2.php?tipo=S','Seguimiento de estudiante - docente','Seguimiento de estudiante - docente »') ?>
                            <!--<a href="../interfaz/listar_registro_riesgo.php?tipo=S" title="">Seguimiento de estudiante - docente »</a>-->
                          </li>
                        </ul>
                      </div>
                    </li>
                  </ul>
                </div>
                <div class="col3">
                  <ul>
                    <li class="titular">Registro</li>
                    <li> <a href="javascript:void(0)" data-toggle="remitirAlPAE" class="nivel2a">Remisión
                      <div class="colapsable"></div>
                      </a>
                      <div id="remitirAlPAE" class="contenedor nodisplay">
                        <ul>
                          <li> <?php echo link_H($db,'../interfaz/Informe_Prueba_Academica.php','Informe Prueba Académica','Informe Prueba Académica »') ?>
                            <!-- <a href="../interfaz/solicitar_pr.php" title="">Registro de riesgo »</a>-->
                          </li>
                          <li> <?php echo link_H($db,'../interfaz/listar_registro_riesgo2.php?tipo=R','Registro de riesgo','Registro de riesgo »') ?>
                            <!-- <a href="../interfaz/solicitar_pr.php" title="">Registro de riesgo »</a>-->
                          </li>
                          <li> <?php echo link_H($db,'../interfaz/solicitar.php?tipo=PS','Seguimiento Psicologico','Seguimiento psicológico »') ?>
                            <!-- <a href="../interfaz/solicitar.php?tipo=PS" title="">Seguimiento psicológico »</a>-->
                          </li>
                          <li> <?php echo link_H($db,'../interfaz/solicitar.php?tipo=PF','Seguimiento Financiero','Seguimiento financiero »') ?>
                            <!-- <a href="../interfaz/solicitar.php?tipo=PF" title="">Seguimiento financiero »</a>-->
                          </li>
                        </ul>
                      </div>
                      <a href="javascript:void(0)" data-toggle="citacionEstudiantesPae" class="nivel2a">Citación
                      <div class="colapsable"></div>
                      </a>
                      <div id="citacionEstudiantesPae" class="contenedor nodisplay">
                        <ul>
                          <li> <?php echo link_H($db,'../interfaz/listar_citaciones.php','Citaciones','Citaciones »') ?>
                            <!-- <a href="../interfaz/listar_citaciones.php" title="">Citaciones »</a>-->
                          </li>
                        </ul>
                      </div>
                      <a href="javascript:void(0)" data-toggle="registrosDeApoyos" class="nivel2a">Registro de apoyos
                      <div class="colapsable"></div>
                      </a>
                      <div id="registrosDeApoyos" class="contenedor nodisplay">
                        <ul>
                          <li> <?php echo link_H($db,'../interfaz/solicitar.php?tipo=TU','Tutorias','Tutorías »') ?>
                            <!-- <a href="../interfaz/solicitar.php?tipo=TU" title="">Tutorías »</a>-->
                          </li>
                          <li> <?php echo link_H($db,'../interfaz/listar_estudiante_tutor2.php?tipo=ET','Estudiante Tutor','Estudiante Tutor »') ?>
                            <!-- <a href="../interfaz/listar_estudiante_tutor.php" title="">Estudiante Tutor »</a>-->
                          </li>
                        </ul>
                      </div>
                    </li>
                  </ul>
                </div>
                <?php 
										/*
										 * @modified Andres Ariza <arizaandres@unbosque.edu.co>
										 * Se oculta esta opcion por solicitud de María del Mar Pulido Suárez http://prntscr.com/e0npuz
										 * @since  January 11, 2017
										*/
										 /*/
										 ?><div class="col4">
											<ul>
												<li class="titular">Seguimiento</li>
												<li><?php echo link_H($db,'../interfaz/listar_registro_riesgo.php?tipo=SE','Seguimiento de estudiante','Seguimiento de estudiante »') ?>
	                                            
												<li><?php //echo link_H($db,'../interfaz/ganacia_academica.php','Ganancia Academica','Ganancia Académica »') ?>
	                                                                                            <!--<a href="../interfaz/ganacia_academica.php" title="">Ganancia Académica »</a>--></li>
												<li><?php //echo link_H($db,'../interfaz/indicador_repitencia.php','Indicador de Repitencia de Asignaturas','Indicador de Repitencia de Asignaturas »') ?>
	                                                                                            <!--<a href="../interfaz/indicador_repitencia.php" title="">Indicador de Repitencia de Asignaturas »</a>--></li>
	                                            <li><?php //echo link_H($db,'../interfaz/listar_estudiantes_repitencia.php','Reporte de Repitencia de Asignaturas','Reporte de Repitencia de Asignaturas »') ?>
	                                                                                            <!--<a href="../interfaz/listar_estudiantes_repitencia.php" title="">Reporte de Repitencia de Asignaturas »</a>--></li>
											</ul>
										</div>
										<?php
										/* Fin Modificación */
										?>
              </div>
            </li>
            <!--<li class="bloque">
									<a href="javascript:animatedcollapse.toggle('segundo-c')" class="nivel1a">Salas de aprendizaje<div class="colapsable"></div></a>
									<div id="segundo-c" class="contenedor">
										<ul>
											<li><?php echo link_H($db,'../interfaz/listar_grupos.php','Administracion de salas de aprendizaje','Administración de salas de aprendizaje »') ?>
                                                                                            //<a href="../interfaz/listar_grupos.php" title="">Administración de salas de aprendizaje »</a></li>
											<li><?php echo link_H($db,'../interfaz/listar_riesgo_salas.php','Seguimiento de salas de aprendizaje','Seguimiento salas de aprendizaje »') ?>
                                                                                            //<a href="../interfaz/listar_riesgo_salas.php" title="">Seguimiento salas de aprendizaje »</a></li>
											<li><?php echo link_H($db,'../interfaz/competencias_basicas.php','Reporte de Competencias Basicas','Reporte de Competencias Básicas »') ?></li>
										</ul>
									</div>
								</li>-->
            <li class="bloque"> <a href="javascript:animatedcollapse.toggle('segundo-d')" class="nivel1a">Spadies
              <div class="colapsable"></div>
              </a>
              <div id="segundo-d" class="contenedor">
                <ul>
                  <li><?php echo link_H($db,'../spadies/Spadies_html.php','Gestion de Reportes','Gesti&oacute;n de Reportes »') ?>
                    <!--<a href="../spadies/Spadies_html.php" title="">Gestor de Reportes »</a>-->
                  </li>
                  <li><?php echo link_H($db,'../spadies/ApoyoAcademico_html.php','Formulario de apoyos academicos','Apoyos Acad&eacute;micos »') ?>
                    <!--<a href="../spadies/ApoyoAcademico_html.php" title="">Apoyos Academicos</a>-->
                  </li>
                  <!--<li><a href="#" title="">Graduados »</a></li>
											<li><a href="#" title="">Retiros disciplinarios »</a></li>
											<li><a href="#" title="">Apoyos financieros »</a></li>
											<li><a href="#" title="">Apoyos académicos »</a></li>
											<li><a href="#" title="">Otros apoyos »</a></li>-->
                </ul>
              </div>
            </li>
          </div>
        </ul>
      </li>
      <li id="tres"><span class="titulo-programa">Preparación a la vida laboral</span>
        <ul class="programa">
          <li class="bloque"> <a href="javascript:animatedcollapse.toggle('tercero-a')" class="nivel1a">Saber PRO
            <div class="colapsable"></div>
            </a>
            <div id="tercero-a" class="contenedor">
              <!--<ul>
										<li class="titular">Tutorías</li>
										<li><a href="#" title="">Seguimiento de tutorías »</a></li>
									</ul>-->
              <ul>
                <li><?php echo link_H($db,'../interfaz/listar_estudiantes_saberpro.php','Saber Pro Gestion de resultados','Gestión de resultados »') ?>
                  <!--<a href="../interfaz/listar_estudiantes_saberpro.php" title="">Gestión de resultados »</a>-->
                </li>
                <li><?php echo link_H($db,'../interfaz/listar_nacionales_saberpro.php','Saber Pro Gestion de resultados nacionales','Gestión de resultados Nacionales »') ?>
                  <!--<a href="../interfaz/listar_nacionales_saberpro.php" title="">Gestión de resultados Nacionales »</a>-->
                </li>
              </ul>
              <ul>
                <li class="titular">Gestión de reportes</li>
                <li><?php echo link_H($db,'../interfaz/listar_saberpro_graficas.php','SaberPro Gestion de reportes','UEB Vs. nacional »') ?>
                  <!--<a href="../interfaz/listar_saberpro_graficas.php" title="">UEB Vs. nacional »</a>-->
                </li>
              </ul>
            </div>
          </li>
        </ul>
      </li>
    </ul>
  </div>
</div>
<script>window.jQuery || document.write('<script src="js/vendor/jquery-1.13.1.min.js"><\/script>')</script>
<script src="js/plugins.js"></script>
<script src="js/main.js"></script>
</body>
</html>