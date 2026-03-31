<script type="text/javascript">
	$(function() {
		$( "#tabs" ).tabs({
                    cache: true,
			beforeLoad: function( event, ui ) {
				ui.jqXHR.error(function() {
					ui.panel.html("Ocurrio un problema cargando el contenido.");
				});
			}
		});
                
                $("#tabs").plusTabs({
   			className: "plusTabs", //classname for css scoping
   			seeMore: true,  //initiate "see more" behavior
   			seeMoreText: "Ver más información", //set see more text
   			showCount: true, //show drop down count
   			expandIcon: "&#9660; ", //icon/caret - if using image, specify image width
   			dropWidth: "auto", //width of dropdown
 			sizeTweak: 0 //adjust size of active tab to tweak "see more" layout
   		});
	});
</script>
<div id="tabs" class="dontCalculate">
	<ul>
		<li><a href="./formularios/docentes/viewOficinaDesarrolloCooperacion.php">Convenio Cooperación</a></li>
		<li><a href="./formularios/docentes/viewOficinaDesarrolloCooperacionInter.php">Convenios Interinstitucionales</a></li>
		<!--<li><a href="./formularios/docentes/viewOficinaDesarrolloProyeccion.php">Proyección Social</a></li>-->
		<li><a href="./formularios/docentes/viewOficinaDesarrolloMedios.php">Medios de Comunicación</a></li>
		<li><a href="./formularios/docentes/viewOficinaDesarrolloEgresados.php">Egresados</a></li>
		<li><a href="./formularios/docentes/viewOficinaDesarrolloRedes.php">Redes Nacionales e Internacionales</a></li>
		<li><a href="./formularios/docentes/viewOficinaDesarrolloAsociaciones.php">Redes y Asociaciones Institucionales</a></li>
	</ul>
</div>
