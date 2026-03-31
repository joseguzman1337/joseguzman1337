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
		<li><a href="./formularios/academicos/viewEducontinuadaProgramas.php">Programas ofrecidos por la división</a></li>
		<li><a href="./formularios/academicos/viewNumeroProgramas.php">Número de programas ofrecidos por la división</a></li>
		<li><a href="./formularios/academicos/viewContiAC.php">Programas de Educación Continuada (abiertos o cerrados)</a></li>
		<li><a href="./formularios/academicos/viewContiUnidad.php">Programas de Educación Continuada por Unidad Académica</a></li>
		
	</ul>
</div>