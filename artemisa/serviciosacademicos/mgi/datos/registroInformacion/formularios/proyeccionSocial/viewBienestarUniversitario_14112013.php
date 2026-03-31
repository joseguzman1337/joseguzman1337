<script type="text/javascript">
	$(function() {
		$( "#tabs" ).tabs({
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
	});
</script>
<div id="tabs" class="dontCalculate">
	<ul>
		<li><a href="formularios/proyeccionSocial/viewBienestarUniversitarioDeporteActividadFisica.php?alias=eadaf_ddbu">Estadísticas área de deportes y actividad física</a></li>
		<li><a href="formularios/proyeccionSocial/viewBienestarUniversitarioSalud.php?alias=eas_ddbu">Estadísticas área de la salud</a></li>
		<li><a href="formularios/proyeccionSocial/viewBienestarUniversitarioCulturaRecreacion.php?alias=eacr_ddbu">Estadísticas área de cultura y recreación</a></li>
		<li><a href="formularios/proyeccionSocial/viewBienestarUniversitarioVoluntariadoUniversitario.php?alias=evu_ddbu">Estadísticas voluntariado universitario</a></li>
		<li><a href="formularios/proyeccionSocial/viewBienestarUniversitarioUsoCuevaTerrazas.php?alias=euct_ddbu">Estadísticas uso de la cueva y las terrazas</a></li>
	</ul>
</div>
