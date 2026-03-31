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
		//$( "#tabs" ).tabs().addClass( "ui-tabs-vertical ui-helper-clearfix" );
		//$( "#tabs li" ).removeClass( "ui-corner-top" ).addClass( "ui-corner-left" );
	});
</script>
<div id="tabs" class="dontCalculate">
	<ul>
		<li><a href="formularios/recursosFisicos/formBibliotecaVolumenesTitulosColecciones.php?alias=vtc_bib">Volúmenes y títulos de colecciones</a></li>
		<li><a href="formularios/recursosFisicos/formBibliotecaConveniosServiciosInformacionBiblioteca.php?alias=cspapsib_bib">Convenios suscritos para la adquisición y<br/>prestación de servicios de información de la biblioteca</a></li>
		<li><a href="formularios/recursosFisicos/formBibliotecaUsoRecursosFisicos.php?alias=urf_bib">Uso de los recursos físicos</a></li>
		<li><a href="formularios/recursosFisicos/formBibliotecaUsoRecursosDigitales.php?alias=urd_bib">Uso de los recursos digitales</a></li>
		<li><a href="formularios/recursosFisicos/formBibliotecaServiciosPresenciales.php?alias=sp_bib">Servicios presenciales</a></li>
		<li><a href="formularios/recursosFisicos/formBibliotecaServiciosFormacion.php?alias=sf_bib">Servicios de formación</a></li>
		<li><a href="formularios/recursosFisicos/formBibliotecaServiciosDigitales.php?alias=sd_bib">Servicios digitales</a></li>
		<li><a href="formularios/recursosFisicos/formBibliotecaServiciosWeb.php?alias=sw_bib">Servicios WEB 2.0</a></li>
		<li><a href="formularios/recursosFisicos/formBibliotecaRecursosSuscritos.php?alias=rsntc_bib">Recursos suscritos - Número de títulos y consultas</a></li>
		<li><a href="formularios/recursosFisicos/formBibliotecaBasesDeDatosDispxAreaTematica.php?alias=bddxat_bib">Bases de datos disponibles por área temática</a></li>
	</ul>
</div>
