<script type="text/javascript">
	$(function() {
		$( "#tabs" ).tabs({
                    beforeLoad: function( event, ui ) {
			ui.jqXHR.error(function() {
				ui.panel.html(
				"Ocurrio un problema cargando el contenido." );
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

<?php
$utils = new Utils_datos();

?>

<div id="tabs" class="dontCalculate">
				<ul>
					<li><a href="./formularios/recursosFisicos/ViewTecnologiaAulas.php">Aulas Virtuales</a></li>
					<li><a href="./formularios/recursosFisicos/ViewEquiposServicio.php">Equipos de Cómputo al Servicio de la Comunidad Académica</a></li>
					<li><a href="./formularios/recursosFisicos/ViewBlackboard.php">Servicio de Blackboard Collaborate</a></li>
					<li><a href="./formularios/recursosFisicos/ViewEquiposAudiovisuales.php">Equipos Audiovisuales</a></li>
					<li><a href="./formularios/recursosFisicos/ViewTecnologiaDotacion.php">Dotación salones</a></li>
					<li><a href="./formularios/recursosFisicos/ViewTecnologiaCorreos.php">Correos Electrónicos</a></li>
					<li><a href="./formularios/recursosFisicos/ViewTecnologiaCapacitaciones.php">Capacitaciones en Tics</a></li>
				</ul>

</div>

