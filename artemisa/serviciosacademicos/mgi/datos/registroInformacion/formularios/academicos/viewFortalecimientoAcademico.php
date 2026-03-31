<script type="text/javascript">
	$(function() {
		$( "#tabs" ).tabs({
			cache: true,
			beforeLoad: function( event, ui ) {
				ui.jqXHR.error(function() {
					ui.panel.html("Ocurrio un problema cargando el contenido." );
				});
			}
		});
		$("#tabs").plusTabs({
			className: "plusTabs", //classname for css scoping
			seeMore: true,  //initiate "see more" behavior
			seeMoreText: "Ver más formularios", //set see more text
			showCount: true, //show drop down count
			expandIcon: "&#9660; ", //icon/caret - if using image, specify image width
			dropWidth: "auto", //width of dropdown
			sizeTweak: 0 //adjust size of active tab to tweak "see more" layout
		});
		//$( "#tabs" ).tabs().addClass( "ui-tabs-vertical ui-helper-clearfix" );
		//$( "#tabs li" ).removeClass( "ui-corner-top" ).addClass( "ui-corner-left" );
	});
</script>
<div id="tabs" class="dontCalculate">
	<ul>
		<li><a href="formularios/academicos/viewFortalecimientoAcademico2.php?alias=caas">Capacitación a los académicos – Aprendizaje significativo</a></li>
		<li><a href="formularios/academicos/viewFortalecimientoAcademico2.php?alias=apeirbyh">Asignaturas del Plan de Estudios que incorporan el referente de la bioética y las humanidades</a></li>
		<li><a href="formularios/academicos/viewFortalecimientoAcademico2.php?alias=scpscpefi">Syllabus y Contenidos Programáticos en SALA correspondientes al Plan de Estudios en Formato Institucional (SALA)</a></li>
		<li><a href="formularios/academicos/viewFortalecimientoAcademico2.php?alias=auleaaecpupa">Asignaturas que utilizan lengua extranjera en las actividades de aprendizaje y evaluación del curso y porcentaje de utilización en el Programa Académico</a></li>
		<li><a href="formularios/academicos/viewFortalecimientoAcademico2.php?alias=aaiaaepu">Asignaturas que articulan la internacionalización  con las actividades de aprendizaje y evaluación y porcentaje de utilización</a></li>
		<li><a href="formularios/academicos/viewFortalecimientoAcademico2.php?alias=aihmtaeaaput">Asignaturas que incluyen herramientas mediadas por las  TIC en las actividades de evaluación y actividades de aprendizaje y porcentaje de utilización en total</a></li>
	</ul>
</div>
